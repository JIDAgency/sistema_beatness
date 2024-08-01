<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Totalpass extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('totalpass_lib');
        $this->load->model('totalpass_model');
    }

    public function index_post()
    {
        redirect('error_404');
    }

    public function webhooks_post()
    {
        try {
            $body_post = $this->post();
            $headers_post = $this->input->request_headers();

            if (empty($body_post)) {
                throw new Exception('No se recibieron datos de entrada.');
            }

            $this->db->trans_start();

            $validar_webhook = $this->totalpass_model->webhook_obtener_por_slot_id_y_tipo(isset($body_post['slot']['id']) ? $body_post['slot']['id'] : null, isset($body_post['slot']['status']) ? $body_post['slot']['status'] : null)->row();

            if (!$validar_webhook) {
                $data_1 = array(
                    'event_id' => isset($body_post['event']['id']) ? $body_post['event']['id'] : null,
                    'place_id' => isset($body_post['place']['place']) ? $body_post['place']['place'] : null,
                    'user_code' => isset($body_post['user']['code']) ? $body_post['user']['code'] : null,
                    'slot_id' => isset($body_post['slot']['id']) ? $body_post['slot']['id'] : null,
                    'tipo' => isset($body_post['slot']['status']) ? $body_post['slot']['status'] : null,
                    'contenido' => json_encode($body_post, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    'intentos' => 1
                );

                if (!$this->totalpass_model->insertar_webhook($data_1)) {
                    throw new Exception('Hubo un problema al procesar la solicitud del webhook.');
                }

                $webhook_id = $this->db->insert_id();
            } else {

                $this->totalpass_model->webhook_actualizar_por_id($validar_webhook->id, array(
                    'intentos' => $validar_webhook->intentos + 1,
                ));

                $webhook_id = $validar_webhook->id;
            }
            $this->set_response(REST_Controller::HTTP_OK);

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception('La transacción falló al completar la operación.');
            }

            $this->validar_reservacion($webhook_id);
        } catch (Exception $e) {
            $this->db->trans_rollback();

            $this->response(array(
                'error' => true,
                'message' => $e->getMessage(),
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function validar_reservacion($id)
    {
        $this->db->trans_start();

        $webhook_row = $this->totalpass_model->obtener_webhook_por_id($id)->row();
        $webhook_contenido = json_decode($webhook_row->contenido, true);
        $cliente_row = null;
        $minutos_para_reservar = 15;

        if ($webhook_row->tipo == 'active') {
            try {
                $flar_validar_cliente = false;
                $event = $webhook_contenido['event'];
                $place = $webhook_contenido['place'];
                $user = $webhook_contenido['user'];
                $slot = $webhook_contenido['slot'];

                if (!empty($user['code'])) {
                    $cliente_row = $this->totalpass_model->obtener_cliente_por_totalpass_user_code($user['code'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;
                    }
                }

                if (!$flar_validar_cliente && !empty($user['email'])) {
                    $cliente_row = $this->totalpass_model->obtener_cliente_por_email($user['email'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;

                        $data_1 = ['totalpass_user_code' => $user['code'] ?? null];
                        if (!$this->totalpass_model->actualizar_usuario_por_id($cliente_row->id, $data_1)) {
                            throw new Exception('No se pudo vincular la cuenta de usuario con Gympass. Por favor, intente nuevamente.');
                        }
                    }
                }

                if (!$flar_validar_cliente) {
                    $nombre_completo = $user['name'] ?? '';
                    $nombre_dividido = $this->dividir_nombre($nombre_completo);

                    $data_1 = [
                        'totalpass_user_code' => $user['code'] ?? null,
                        'nombre_completo' => $nombre_dividido['nombre'] ?? '',
                        'apellido_paterno' => $nombre_dividido['apellido_paterno'] ?? '',
                        'apellido_materno' => $nombre_dividido['apellido_materno'] ?? '',
                        'correo' => $user['email'] ?? null,
                        'no_telefono' => $user['phone'] ?? null,
                        'contrasena_hash' => password_hash('temporal', PASSWORD_DEFAULT),
                        'rol_id' => 1,
                        'es_estudiante' => 'no',
                        'es_estudiante_vigencia' => date('Y-m-d'),
                        'fecha_nacimiento' => date('Y-m-d'),
                        'rfc' => null,
                        'curp' => $user['document_number'] ?? null,
                        'genero' => 'M',
                        'calle' => null,
                        'numero' => null,
                        'colonia' => null,
                        'ciudad' => null,
                        'estado' => null,
                        'pais' => null,
                        'nombre_imagen_avatar' => 'default.jpg',
                        'dominio' => 'beatness'
                    ];

                    if (!$this->totalpass_model->insertar_usuario($data_1)) {
                        throw new Exception('Ocurrió un error al registrar el usuario. Por favor, intente nuevamente.');
                    }

                    $cliente_row = $this->totalpass_model->obtener_cliente_por_totalpass_user_code($user['code'])->row();
                }

                if (!$cliente_row) {
                    throw new Exception('El usuario no fue encontrado. Por favor, verifique los datos proporcionados.');
                }

                $clase_row = $this->totalpass_model->clase_obtener_por_totalpass_eventOccurrenceUuid($event['id'])->row();

                if (!$clase_row) {
                    throw new Exception('La clase a reservar no fue encontrada. Por favor, verifique los datos proporcionados.');
                }

                if ($clase_row->estatus === 'Cancelada') {
                    throw new Exception('La clase ha sido cancelada. Por favor, seleccione otra clase.');
                }

                if ($clase_row->estatus === 'Terminada') {
                    throw new Exception('La clase ya ha terminado. Por favor, seleccione otra clase.');
                }

                $validar_reservacion = $this->totalpass_model->reservaciones_obtener_por_totalpass_slot_id($slot['id'])->row();
                if ($validar_reservacion) {
                    throw new Exception('El usuario ya tiene una reserva para esta clase.', 1003);
                }

                $fecha_de_clase = $clase_row->inicia;
                $fecha_limite_de_clase = strtotime($minutos_para_reservar . ' minutes', strtotime($fecha_de_clase));
                if (strtotime('now') > $fecha_limite_de_clase) {
                    throw new Exception('El tiempo límite para reservar ha pasado. Por favor, seleccione otro horario.');
                }

                $cupo_lugares = json_decode($clase_row->cupo_lugares);
                usort($cupo_lugares, function ($a, $b) {
                    return $b->no_lugar - $a->no_lugar;
                });

                $lugar_reservado = false;
                $no_lugar_reservado = 0;

                foreach ($cupo_lugares as &$lugar) {
                    if (!$lugar->esta_reservado) {
                        $lugar->esta_reservado = true;
                        $lugar->nombre_usuario = $cliente_row->id;
                        $no_lugar_reservado = $lugar->no_lugar;
                        $lugar_reservado = true;
                        break;
                    }
                }

                if (!$lugar_reservado) {
                    throw new Exception('No hay lugares disponibles para esta clase. Por favor, seleccione otra clase.');
                }

                usort($cupo_lugares, function ($a, $b) {
                    return $a->no_lugar - $b->no_lugar;
                });

                $clase_row->cupo_lugares = json_encode($cupo_lugares);

                if (!$this->totalpass_model->clase_actualizar_por_id($clase_row->id, array('reservado' => $clase_row->reservado + 1, 'cupo_lugares' => json_encode($cupo_lugares)))) {
                    throw new Exception('No se pudo actualizar la clase con la nueva reserva. Por favor, intente nuevamente.');
                }


                $disciplina_row = $this->totalpass_model->disciplina_obtener_por_id($clase_row->disciplina_id)->row();

                if (!$disciplina_row) {
                    throw new Exception('No se pudo encontrar la disciplina de la clase seleccionada. Por favor, intente nuevamente.');
                }

                if (!$disciplina_row->totalpass_plan_interno_id) {
                    throw new Exception('No se pudo encontrar el plan asignado a totalpass. Por favor, intente nuevamente. (1)');
                }

                $plan_row = $this->totalpass_model->plan_obtener_por_id($disciplina_row->totalpass_plan_interno_id)->row();

                if (!$plan_row) {
                    throw new Exception('No se pudo encontrar el plan asignado a totalpass. Por favor, intente nuevamente. (2)');
                }

                $data_2 = array(
                    'usuario_id' => $cliente_row->id,
                    'plan_id' => $plan_row->id,
                    'nombre' => $plan_row->nombre,
                    'clases_incluidas' => $plan_row->clases_incluidas,
                    'disciplinas' => $disciplina_row->id,
                    'vigencia_en_dias' => $plan_row->vigencia_en_dias,
                    'es_ilimitado' => !empty($plan_row->es_ilimitado) ? $plan_row->es_ilimitado : 'no',
                    'esta_activo' => '1',
                    'fecha_activacion' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time'),
                );

                if (!$this->totalpass_model->asignacion_insertar($data_2)) {
                    throw new Exception('No se pudo crear la asignación para esta reservación. Por favor, inténtelo nuevamente.');
                }

                $asginacion_id = $this->db->insert_id();

                $asignacion_row = $this->totalpass_model->asignacion_obtener_por_id($asginacion_id)->row();

                if (!$asignacion_row) {
                    throw new Exception('No se pudo obtener la asignación para esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_3 = array(
                    'concepto' => $plan_row->nombre,
                    'sucursal_id' => $disciplina_row->sucursal_id,
                    'usuario_id' => $cliente_row->id,
                    'asignacion_id' => $asignacion_row->id,
                    'metodo_id' => 15,
                    'costo' => $plan_row->costo,
                    'cantidad' => 1,
                    'total' => $plan_row->costo,
                    'vendedor' => '289 - TOTALPASS ',
                );

                if (!$this->totalpass_model->venta_insertar($data_3)) {
                    throw new Exception('No se pudo crear la venta para esta reservación. Por favor, inténtelo nuevamente.');
                }

                $venta_id = $this->db->insert_id();

                $venta_row = $this->totalpass_model->venta_obtener_por_id($venta_id)->row();

                if (!$venta_row) {
                    throw new Exception('No se pudo obtener la venta para esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_4 = array(
                    'usuario_id' => $cliente_row->id,
                    'clase_id' => $clase_row->id,
                    'asignaciones_id' => $asignacion_row->id,
                    'no_lugar' => $no_lugar_reservado,
                    'totalpass_slot_id' => $slot['id'],
                );

                if (!$this->totalpass_model->reservaciones_insertar($data_4)) {
                    throw new Exception('No se pudo crear la reserva. Por favor, intente nuevamente.');
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    throw new Exception('La transacción falló al completar la operación. Por favor, intente nuevamente.');
                }

                $this->response(REST_Controller::HTTP_OK);
            } catch (Exception $e) {
                $this->db->trans_rollback();

                $this->response(array(
                    'error' => true,
                    'message' => $e->getMessage(),
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        if ($webhook_row->tipo == 'canceled') {
            try {
                $flar_validar_cliente = false;
                $event = $webhook_contenido['event'];
                $place = $webhook_contenido['place'];
                $user = $webhook_contenido['user'];
                $slot = $webhook_contenido['slot'];

                if (!empty($user['code'])) {
                    $cliente_row = $this->totalpass_model->obtener_cliente_por_totalpass_user_code($user['code'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;
                    }
                }

                if (!$flar_validar_cliente && !empty($user['email'])) {
                    $cliente_row = $this->totalpass_model->obtener_cliente_por_email($user['email'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;

                        $data_1 = ['totalpass_user_code' => $user['code'] ?? null];
                        if (!$this->totalpass_model->actualizar_usuario_por_id($cliente_row->id, $data_1)) {
                            throw new Exception('No se pudo vincular la cuenta de usuario con Gympass. Por favor, intente nuevamente.');
                        }
                    }
                }

                if (!$flar_validar_cliente) {
                    $nombre_completo = $user['name'] ?? '';
                    $nombre_dividido = $this->dividir_nombre($nombre_completo);

                    $data_1 = [
                        'totalpass_user_code' => $user['code'] ?? null,
                        'nombre_completo' => $nombre_dividido['nombre'] ?? '',
                        'apellido_paterno' => $nombre_dividido['apellido_paterno'] ?? '',
                        'apellido_materno' => $nombre_dividido['apellido_materno'] ?? '',
                        'correo' => $user['email'] ?? null,
                        'no_telefono' => $user['phone'] ?? null,
                        'contrasena_hash' => password_hash('temporal', PASSWORD_DEFAULT),
                        'rol_id' => 1,
                        'es_estudiante' => 'no',
                        'es_estudiante_vigencia' => date('Y-m-d'),
                        'fecha_nacimiento' => date('Y-m-d'),
                        'rfc' => null,
                        'curp' => $user['document_number'] ?? null,
                        'genero' => 'M',
                        'calle' => null,
                        'numero' => null,
                        'colonia' => null,
                        'ciudad' => null,
                        'estado' => null,
                        'pais' => null,
                        'nombre_imagen_avatar' => 'default.jpg',
                        'dominio' => 'beatness'
                    ];

                    if (!$this->totalpass_model->insertar_usuario($data_1)) {
                        throw new Exception('Ocurrió un error al registrar el usuario. Por favor, intente nuevamente.');
                    }

                    $cliente_row = $this->totalpass_model->obtener_cliente_por_totalpass_user_code($user['code'])->row();
                }

                if (!$cliente_row) {
                    throw new Exception('El usuario no fue encontrado. Por favor, verifique los datos proporcionados.');
                }

                $clase_row = $this->totalpass_model->clase_obtener_por_totalpass_eventOccurrenceUuid($event['id'])->row();

                if (!$clase_row) {
                    throw new Exception('La clase a reservar no fue encontrada. Por favor, verifique los datos proporcionados.');
                }

                if ($clase_row->estatus === 'Cancelada') {
                    throw new Exception('La clase ha sido cancelada. Por favor, seleccione otra clase.');
                }

                if ($clase_row->estatus === 'Terminada') {
                    throw new Exception('La clase ya ha terminado. Por favor, seleccione otra clase.');
                }

                $reservacion_row = $this->totalpass_model->reservaciones_obtener_por_totalpass_slot_id($slot['id'])->row();

                if (!$reservacion_row) {
                    throw new Exception('El usuario no tiene una reserva para esta clase.');
                }

                $cupo_lugares = json_decode($clase_row->cupo_lugares);

                $lugar_reservado = false;

                foreach ($cupo_lugares as $lugar) {
                    if ($lugar->no_lugar == $reservacion_row->no_lugar) {
                        $lugar->esta_reservado = false;
                        $lugar->nombre_usuario = '';
                        $lugar_reservado = true;
                        break;
                    }
                }

                if (!$lugar_reservado) {
                    throw new Exception('No se encontró el lugar de la reserva para esta clase.');
                }

                $clase_row->cupo_lugares = json_encode($cupo_lugares);

                if (!$this->totalpass_model->clase_actualizar_por_id($clase_row->id, array('reservado' => $clase_row->reservado - 1, 'cupo_lugares' => json_encode($cupo_lugares)))) {
                    throw new Exception('No se pudo actualizar la clase con la cancelación de la reserva.');
                }

                $data_2 = array(
                    'asistencia' => 'cancelada',
                    'estatus' => 'Cancelada',
                );

                if (!$this->totalpass_model->reservaciones_actualizar_por_id($reservacion_row->id, $data_2)) {
                    throw new Exception('No se pudo cancelar la reserva. Por favor, intente nuevamente.');
                }

                $asignacion_row = $this->totalpass_model->asignacion_obtener_por_id($reservacion_row->asignaciones_id)->row();

                if (!$asignacion_row) {
                    throw new Exception('No se pudo obtener la asignación de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_3 = array(
                    'esta_activo' => '0',
                    'estatus' => 'Cancelado',
                );

                if (!$this->totalpass_model->asignacion_actualizar_por_id($asignacion_row->id, $data_3)) {
                    throw new Exception('No se pudo cancelar la asignación de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $venta_row = $this->totalpass_model->venta_obtener_por_usuario_id_y_asignacion_id($cliente_row->id, $asignacion_row->id)->row();

                if (!$venta_row) {
                    throw new Exception('No se pudo obtener la venta de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_4 = array(
                    'total' => '0',
                    'estatus' => 'Cancelada',
                );

                if (!$this->totalpass_model->venta_actualizar_por_id($venta_row->id, $data_4)) {
                    throw new Exception('No se pudo cancelar la venta de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    throw new Exception('La transacción falló al completar la operación. Por favor, intente nuevamente.');
                }

                $this->response(REST_Controller::HTTP_OK);
            } catch (Exception $e) {
                $this->db->trans_rollback();

                $this->response(array(
                    'error' => true,
                    'message' => $e->getMessage(),
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    function dividir_nombre($nombre_completo)
    {
        $nombre = '';
        $apellido_paterno = '';
        $apellido_materno = '';

        $partes = array_filter(explode(' ', trim($nombre_completo)));
        $numPartes = count($partes);

        if ($numPartes === 2) {
            list($nombre, $apellido_paterno) = $partes;
        } elseif ($numPartes >= 3) {
            $apellido_materno = array_pop($partes);
            $apellido_paterno = array_pop($partes);
            $nombre = implode(' ', $partes);
        } else {
            $nombre = $nombre_completo;
        }

        return [
            'nombre' => $nombre,
            'apellido_paterno' => $apellido_paterno,
            'apellido_materno' => $apellido_materno
        ];
    }
}
