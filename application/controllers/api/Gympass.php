<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Gympass extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('gympass_lib');
        $this->load->model('wellhub_model');
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

            $signatures = $this->generar_gympass_signatures($body_post, $this->gympass_lib->gympass_secret_key);
            $signature_esperada = isset($headers_post['x-gympass-signature']) ? $headers_post['x-gympass-signature'] : '';

            if (!in_array(strtoupper($signature_esperada), $signatures)) {
                // throw new Exception('Ninguna de las firmas generadas coincide con la esperada.');
            }

            $this->db->trans_start();

            $validar_webhook = $this->wellhub_model->webhook_obtener_por_evento_id(isset($body_post['event_data']['event_id']) ? $body_post['event_data']['event_id'] : (isset($body_post['event_data']['booking']['booking_number']) ? $body_post['event_data']['booking']['booking_number'] : null))->row();

            if (!$validar_webhook) {
                $data_1 = array(
                    'evento_tipo' => isset($body_post['event_type']) ? $body_post['event_type'] : null,
                    'evento_id' => isset($body_post['event_data']['event_id']) ? $body_post['event_data']['event_id'] : (isset($body_post['event_data']['booking']['booking_number']) ? $body_post['event_data']['booking']['booking_number'] : null),
                    'contenido' => json_encode($body_post, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    'intentos' => 1
                );

                if (!$this->wellhub_model->insertar_webhook($data_1)) {
                    throw new Exception('Hubo un problema al procesar la solicitud del webhook.');
                }

                $webhook_id = $this->db->insert_id();
            } else {

                $this->wellhub_model->webhook_actualizar_por_id($validar_webhook->id, array(
                    'intentos' => $validar_webhook->intentos + 1,
                ));

                $webhook_id = $validar_webhook->id;
            }

            $this->output->set_header('X-Gympass-Signature: ' . $signature_esperada);
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

        $webhook_row = $this->wellhub_model->obtener_webhook_por_id($id)->row();
        $webhook_contenido = json_decode($webhook_row->contenido, true);
        $cliente_row = null;
        $minutos_para_reservar = 15;

        if ($webhook_row->evento_tipo == 'booking-requested') {
            try {
                $flar_validar_cliente = false;
                $user = $webhook_contenido['event_data']['user'];
                $slot = $webhook_contenido['event_data']['slot'];

                if (!empty($user['unique_token'])) {
                    $cliente_row = $this->wellhub_model->obtener_cliente_por_gympass_user_id($user['unique_token'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;
                    }
                }

                if (!$flar_validar_cliente && !empty($user['email'])) {
                    $cliente_row = $this->wellhub_model->obtener_cliente_por_email($user['email'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;

                        $data_1 = ['gympass_user_id' => $user['unique_token'] ?? null];
                        if (!$this->wellhub_model->actualizar_usuario_por_id($cliente_row->id, $data_1)) {
                            throw new Exception('No se pudo vincular la cuenta de usuario con Gympass. Por favor, intente nuevamente.', 1009);
                        }
                    }
                }

                if (!$flar_validar_cliente) {
                    $nombre_completo = $user['name'] ?? '';
                    $nombre_dividido = $this->dividir_nombre($nombre_completo);

                    $data_1 = [
                        'gympass_user_id' => $user['unique_token'] ?? null,
                        'nombre_completo' => $nombre_dividido['nombre'] ?? '',
                        'apellido_paterno' => $nombre_dividido['apellido_paterno'] ?? '',
                        'apellido_materno' => $nombre_dividido['apellido_materno'] ?? '',
                        'correo' => $user['email'] ?? null,
                        'no_telefono' => $user['phone_number'] ?? null,
                        'contrasena_hash' => password_hash('temporal', PASSWORD_DEFAULT),
                        'rol_id' => 1, // Este usuario pertenece al rol con id 1 (Cliente)
                        'es_estudiante' => 'no',
                        'es_estudiante_vigencia' => date('Y-m-d'),
                        'fecha_nacimiento' => date('Y-m-d'),
                        'rfc' => null,
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

                    if (!$this->wellhub_model->insertar_usuario($data_1)) {
                        throw new Exception('Ocurrió un error al registrar el usuario. Por favor, intente nuevamente.', 1010);
                    }

                    $cliente_row = $this->wellhub_model->obtener_cliente_por_gympass_user_id($user['unique_token'])->row();
                }

                if (!$cliente_row) {
                    throw new Exception('El usuario no fue encontrado. Por favor, verifique los datos proporcionados.', 1005);
                }

                $clase_row = $this->wellhub_model->clase_obtener_por_gympass_slot_id($slot['id'])->row();

                if (!$clase_row) {
                    throw new Exception('La clase a reservar no fue encontrada. Por favor, verifique los datos proporcionados.', 1008);
                }

                if ($clase_row->estatus === 'Cancelada') {
                    throw new Exception('La clase ha sido cancelada. Por favor, seleccione otra clase.', 1007);
                }

                if ($clase_row->estatus === 'Terminada') {
                    throw new Exception('La clase ya ha terminado. Por favor, seleccione otra clase.', 1006);
                }

                $validar_reservacion = $this->wellhub_model->reservaciones_obtener_por_gympass_booking_number($slot['booking_number'])->row();
                if ($validar_reservacion) {
                    throw new Exception('El usuario ya tiene una reserva para esta clase.', 1003);
                }

                $fecha_de_clase = $clase_row->inicia;
                $fecha_limite_de_clase = strtotime($minutos_para_reservar . ' minutes', strtotime($fecha_de_clase));
                if (strtotime('now') > $fecha_limite_de_clase) {
                    throw new Exception('El tiempo límite para reservar ha pasado. Por favor, seleccione otro horario.', 1006);
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
                    throw new Exception('No hay lugares disponibles para esta clase. Por favor, seleccione otra clase.', 1001);
                }

                usort($cupo_lugares, function ($a, $b) {
                    return $a->no_lugar - $b->no_lugar;
                });

                $clase_row->cupo_lugares = json_encode($cupo_lugares);

                if (!$this->wellhub_model->clase_actualizar_por_id($clase_row->id, array('reservado' => $clase_row->reservado + 1, 'cupo_lugares' => json_encode($cupo_lugares)))) {
                    throw new Exception('No se pudo actualizar la clase con la nueva reserva. Por favor, intente nuevamente.', 1010);
                }

                $disciplina_row = $this->wellhub_model->disciplina_obtener_por_id($clase_row->disciplina_id)->row();

                if (!$disciplina_row) {
                    throw new Exception('No se pudo encontrar la disciplina de la clase seleccionada. Por favor, intente nuevamente.');
                }

                if (!$disciplina_row->gympass_plan_interno_id) {
                    throw new Exception('No se pudo encontrar el plan asignado. Por favor, intente nuevamente. (1)');
                }

                $plan_row = $this->wellhub_model->plan_obtener_por_id($disciplina_row->gympass_plan_interno_id)->row();

                if (!$plan_row) {
                    throw new Exception('No se pudo encontrar el plan asignado. Por favor, intente nuevamente. (2)');
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

                if (!$this->wellhub_model->asignacion_insertar($data_2)) {
                    throw new Exception('No se pudo crear la asignación para esta reservación. Por favor, inténtelo nuevamente.');
                }

                $asginacion_id = $this->db->insert_id();

                $asignacion_row = $this->wellhub_model->asignacion_obtener_por_id($asginacion_id)->row();

                if (!$asignacion_row) {
                    throw new Exception('No se pudo obtener la asignación para esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_3 = array(
                    'concepto' => $plan_row->nombre,
                    'sucursal_id' => $disciplina_row->sucursal_id,
                    'usuario_id' => $cliente_row->id,
                    'asignacion_id' => $asignacion_row->id,
                    'metodo_id' => 9,
                    'costo' => $plan_row->costo,
                    'cantidad' => 1,
                    'total' => $plan_row->costo,
                    'vendedor' => '35 - GYMPASS ',
                );

                if (!$this->wellhub_model->venta_insertar($data_3)) {
                    throw new Exception('No se pudo crear la venta para esta reservación. Por favor, inténtelo nuevamente.');
                }

                $venta_id = $this->db->insert_id();

                $venta_row = $this->wellhub_model->venta_obtener_por_id($venta_id)->row();

                if (!$venta_row) {
                    throw new Exception('No se pudo obtener la venta para esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_4 = array(
                    'usuario_id' => $cliente_row->id,
                    'clase_id' => $clase_row->id,
                    'asignaciones_id' => $asignacion_row->id,
                    'no_lugar' => $no_lugar_reservado,
                    'gympass_booking_number' => $slot['booking_number'],
                );

                if (!$this->wellhub_model->reservaciones_insertar($data_4)) {
                    throw new Exception('No se pudo crear la reserva. Por favor, intente nuevamente.', 1010);
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    throw new Exception('La transacción falló al completar la operación. Por favor, intente nuevamente.', 1010);
                }

                $data_result = array(
                    'status' => 'RESERVED'
                );

                $response = $this->gympass_lib->patch_validate_booking($slot['gym_id'], $slot['booking_number'], $data_result);

                $data_5 = array(
                    'data' => !empty($webhook_row->data) ? $webhook_row->data . ',' . json_encode($data_result) : json_encode($data_result),
                    'respuesta' => !empty($webhook_row->respuesta) ? $webhook_row->respuesta . ',' . json_encode($response) : json_encode($response),
                );

                $this->wellhub_model->webhook_actualizar_por_id($webhook_row->id, $data_5);

                $data_6 = array(
                    "total_capacity" => $clase_row->cupo,
                    "total_booked" => $clase_row->reservado + 1
                );

                $response = $this->gympass_lib->patch_update_slot($slot['gym_id'], $slot['class_id'], $clase_row->gympass_slot_id, $data_6);

                if (!empty($response) || (isset($response['error']) && $response['error'] === true)) {
                    throw new Exception("Hubo un error al comunicarse con Gympass: " . ($response['message'] ?? 'Respuesta inválida de Gympass.'), 1010);
                }
            } catch (Exception $e) {
                $this->db->trans_rollback();

                $reason = $this->determinar_reason_category($e->getCode());

                $data_result = array(
                    'status' => 'REJECTED',
                    'reason' => $e->getMessage(),
                    'reason_category' => $reason,
                );

                $response = $this->gympass_lib->patch_validate_booking($slot['gym_id'], $slot['booking_number'], $data_result);

                $data_3 = array(
                    'data' => !empty($webhook_row->data) ? $webhook_row->data . ',' . json_encode($data_result) : json_encode($data_result),
                    'respuesta' => !empty($webhook_row->respuesta) ? $webhook_row->respuesta . ',' . json_encode($response) : json_encode($response),
                );

                $this->wellhub_model->webhook_actualizar_por_id($webhook_row->id, $data_3);

                $this->response(array(
                    'error' => true,
                    'message' => $e->getMessage(),
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        if ($webhook_row->evento_tipo == 'booking-canceled') {
            try {
                $flar_validar_cliente = false;
                $user = $webhook_contenido['event_data']['user'];
                $slot = $webhook_contenido['event_data']['slot'];

                if (!empty($user['unique_token'])) {
                    $cliente_row = $this->wellhub_model->obtener_cliente_por_gympass_user_id($user['unique_token'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;
                    }
                }

                if (!$flar_validar_cliente && !empty($user['email'])) {
                    $cliente_row = $this->wellhub_model->obtener_cliente_por_email($user['email'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;

                        $data_1 = ['gympass_user_id' => $user['unique_token'] ?? null];
                        if (!$this->wellhub_model->actualizar_usuario_por_id($cliente_row->id, $data_1)) {
                            throw new Exception('No se pudo vincular la cuenta de usuario con Gympass. Por favor, intente nuevamente.');
                        }
                    }
                }

                if (!$flar_validar_cliente) {
                    $nombre_completo = $user['name'] ?? '';
                    $nombre_dividido = $this->dividir_nombre($nombre_completo);

                    $data_1 = [
                        'gympass_user_id' => $user['unique_token'] ?? null,
                        'nombre_completo' => $nombre_dividido['nombre'] ?? '',
                        'apellido_paterno' => $nombre_dividido['apellido_paterno'] ?? '',
                        'apellido_materno' => $nombre_dividido['apellido_materno'] ?? '',
                        'correo' => $user['email'] ?? null,
                        'no_telefono' => $user['phone_number'] ?? null,
                        'contrasena_hash' => password_hash('temporal', PASSWORD_DEFAULT),
                        'rol_id' => 1, // Este usuario pertenece al rol con id 1 (Cliente)
                        'es_estudiante' => 'no',
                        'es_estudiante_vigencia' => date('Y-m-d'),
                        'fecha_nacimiento' => date('Y-m-d'),
                        'rfc' => null,
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

                    if (!$this->wellhub_model->insertar_usuario($data_1)) {
                        throw new Exception('Ocurrió un error al registrar el usuario. Por favor, intente nuevamente.');
                    }

                    $cliente_row = $this->wellhub_model->obtener_cliente_por_gympass_user_id($user['unique_token'])->row();
                }

                if (!$cliente_row) {
                    throw new Exception('El usuario no fue encontrado. Por favor, verifique los datos proporcionados.');
                }

                $clase_row = $this->wellhub_model->clase_obtener_por_gympass_slot_id($slot['id'])->row();

                if (!$clase_row) {
                    throw new Exception('La clase a reservar no fue encontrada. Por favor, verifique los datos proporcionados.');
                }

                if ($clase_row->estatus === 'Cancelada') {
                    throw new Exception('La clase ha sido cancelada. Por favor, seleccione otra clase.');
                }

                if ($clase_row->estatus === 'Terminada') {
                    throw new Exception('La clase ya ha terminado. Por favor, seleccione otra clase.');
                }

                $reservacion_row = $this->wellhub_model->reservaciones_obtener_por_gympass_booking_number($slot['booking_number'])->row();
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

                if (!$this->wellhub_model->clase_actualizar_por_id($clase_row->id, array('reservado' => $clase_row->reservado - 1, 'cupo_lugares' => json_encode($cupo_lugares)))) {
                    throw new Exception('No se pudo actualizar la clase con la cancelación de la reserva.');
                }

                $data_2 = array(
                    'asistencia' => 'cancelada',
                    'estatus' => 'Cancelada',
                );

                if (!$this->wellhub_model->reservaciones_actualizar_por_id($reservacion_row->id, $data_2)) {
                    throw new Exception('No se pudo cancelar la reserva. Por favor, intente nuevamente.');
                }

                $asignacion_row = $this->wellhub_model->asignacion_obtener_por_id($reservacion_row->asignaciones_id)->row();

                if (!$asignacion_row) {
                    throw new Exception('No se pudo obtener la asignación de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_3 = array(
                    'esta_activo' => '0',
                    'estatus' => 'Cancelado',
                );

                if (!$this->wellhub_model->asignacion_actualizar_por_id($asignacion_row->id, $data_3)) {
                    throw new Exception('No se pudo cancelar la asignación de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $venta_row = $this->wellhub_model->venta_obtener_por_usuario_id_y_asignacion_id($cliente_row->id, $asignacion_row->id)->row();

                if (!$venta_row) {
                    throw new Exception('No se pudo obtener la venta de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_4 = array(
                    'total' => '0',
                    'estatus' => 'Cancelada',
                );

                if (!$this->wellhub_model->venta_actualizar_por_id($venta_row->id, $data_4)) {
                    throw new Exception('No se pudo cancelar la venta de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    throw new Exception('La transacción falló al completar la operación. Por favor, intente nuevamente.');
                }

                $data_result = array(
                    "total_capacity" => $clase_row->cupo,
                    "total_booked" => $clase_row->reservado - 1
                );

                $response = $this->gympass_lib->patch_update_slot($slot['gym_id'], $slot['class_id'], $clase_row->gympass_slot_id, $data_result);

                $data_5 = array(
                    'data' => !empty($webhook_row->data) ? $webhook_row->data . ',' . json_encode($data_result) : json_encode($data_result),
                    'respuesta' => !empty($webhook_row->respuesta) ? $webhook_row->respuesta . ',' . json_encode($response) : json_encode($response),
                );

                $this->wellhub_model->webhook_actualizar_por_id($webhook_row->id, $data_5);

                $this->response(REST_Controller::HTTP_OK);
            } catch (Exception $e) {
                $this->db->trans_rollback();

                $this->response(array(
                    'error' => true,
                    'message' => $e->getMessage(),
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        if ($webhook_row->evento_tipo == 'booking-late-canceled') {
            try {
                $flar_validar_cliente = false;
                $user = $webhook_contenido['event_data']['user'];
                $slot = $webhook_contenido['event_data']['slot'];

                if (!empty($user['unique_token'])) {
                    $cliente_row = $this->wellhub_model->obtener_cliente_por_gympass_user_id($user['unique_token'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;
                    }
                }

                if (!$flar_validar_cliente && !empty($user['email'])) {
                    $cliente_row = $this->wellhub_model->obtener_cliente_por_email($user['email'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;

                        $data_1 = ['gympass_user_id' => $user['unique_token'] ?? null];
                        if (!$this->wellhub_model->actualizar_usuario_por_id($cliente_row->id, $data_1)) {
                            throw new Exception('No se pudo vincular la cuenta de usuario con Gympass. Por favor, intente nuevamente.');
                        }
                    }
                }

                if (!$flar_validar_cliente) {
                    $nombre_completo = $user['name'] ?? '';
                    $nombre_dividido = $this->dividir_nombre($nombre_completo);

                    $data_1 = [
                        'gympass_user_id' => $user['unique_token'] ?? null,
                        'nombre_completo' => $nombre_dividido['nombre'] ?? '',
                        'apellido_paterno' => $nombre_dividido['apellido_paterno'] ?? '',
                        'apellido_materno' => $nombre_dividido['apellido_materno'] ?? '',
                        'correo' => $user['email'] ?? null,
                        'no_telefono' => $user['phone_number'] ?? null,
                        'contrasena_hash' => password_hash('temporal', PASSWORD_DEFAULT),
                        'rol_id' => 1, // Este usuario pertenece al rol con id 1 (Cliente)
                        'es_estudiante' => 'no',
                        'es_estudiante_vigencia' => date('Y-m-d'),
                        'fecha_nacimiento' => date('Y-m-d'),
                        'rfc' => null,
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

                    if (!$this->wellhub_model->insertar_usuario($data_1)) {
                        throw new Exception('Ocurrió un error al registrar el usuario. Por favor, intente nuevamente.');
                    }

                    $cliente_row = $this->wellhub_model->obtener_cliente_por_gympass_user_id($user['unique_token'])->row();
                }

                if (!$cliente_row) {
                    throw new Exception('El usuario no fue encontrado. Por favor, verifique los datos proporcionados.');
                }

                $clase_row = $this->wellhub_model->clase_obtener_por_gympass_slot_id($slot['id'])->row();

                if (!$clase_row) {
                    throw new Exception('La clase a reservar no fue encontrada. Por favor, verifique los datos proporcionados.');
                }

                if ($clase_row->estatus === 'Cancelada') {
                    throw new Exception('La clase ha sido cancelada. Por favor, seleccione otra clase.');
                }

                if ($clase_row->estatus === 'Terminada') {
                    throw new Exception('La clase ya ha terminado. Por favor, seleccione otra clase.');
                }

                $reservacion_row = $this->wellhub_model->reservaciones_obtener_por_gympass_booking_number($slot['booking_number'])->row();
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

                if (!$this->wellhub_model->clase_actualizar_por_id($clase_row->id, array('reservado' => $clase_row->reservado - 1, 'cupo_lugares' => json_encode($cupo_lugares)))) {
                    throw new Exception('No se pudo actualizar la clase con la cancelación de la reserva.');
                }

                $data_2 = array(
                    'asistencia' => 'inasistencia',
                    'estatus' => 'Cancelada',
                );

                if (!$this->wellhub_model->reservaciones_actualizar_por_id($reservacion_row->id, $data_2)) {
                    throw new Exception('No se pudo crear la reserva. Por favor, intente nuevamente.');
                }

                $asignacion_row = $this->wellhub_model->asignacion_obtener_por_id($reservacion_row->asignaciones_id)->row();

                if (!$asignacion_row) {
                    throw new Exception('No se pudo obtener la asignación de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $data_3 = array(
                    'esta_activo' => '0',
                    'estatus' => 'Cancelado',
                );

                if (!$this->wellhub_model->asignacion_actualizar_por_id($asignacion_row->id, $data_3)) {
                    throw new Exception('No se pudo cancelar la asignación de esta reservación. Por favor, inténtelo nuevamente.');
                }

                $venta_row = $this->wellhub_model->venta_obtener_por_usuario_id_y_asignacion_id($cliente_row->id, $asignacion_row->id)->row();

                if (!$venta_row) {
                    throw new Exception('No se pudo obtener la venta de esta reservación. Por favor, inténtelo nuevamente.');
                }

                // $data_4 = array(
                //     'total' => '0',
                //     'estatus' => 'Cancelada',
                // );

                // if (!$this->wellhub_model->venta_actualizar_por_id($venta_row->id, $data_4)) {
                //     throw new Exception('No se pudo cancelar la venta de esta reservación. Por favor, inténtelo nuevamente.');
                // }

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    throw new Exception('La transacción falló al completar la operación. Por favor, intente nuevamente.');
                }

                $data_result = array(
                    "total_capacity" => $clase_row->cupo,
                    "total_booked" => $clase_row->reservado - 1
                );

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    throw new Exception('La transacción falló al completar la operación. Por favor, intente nuevamente.');
                }

                $data_result = array(
                    "total_capacity" => $clase_row->cupo,
                    "total_booked" => $clase_row->reservado - 1
                );

                $response = $this->gympass_lib->patch_update_slot($slot['gym_id'], $slot['class_id'], $clase_row->gympass_slot_id, $data_result);

                $data_5 = array(
                    'data' => !empty($webhook_row->data) ? $webhook_row->data . ',' . json_encode($data_result) : json_encode($data_result),
                    'respuesta' => !empty($webhook_row->respuesta) ? $webhook_row->respuesta . ',' . json_encode($response) : json_encode($response),
                );

                $this->wellhub_model->webhook_actualizar_por_id($webhook_row->id, $data_5);

                $this->response(REST_Controller::HTTP_OK);
            } catch (Exception $e) {
                $this->db->trans_rollback();

                $this->response(array(
                    'error' => true,
                    'message' => $e->getMessage(),
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        if ($webhook_row->evento_tipo == 'checkin-booking-occurred') {

            try {
                $flar_validar_cliente = false;
                $user = $webhook_contenido['event_data']['user'];
                $booking = $webhook_contenido['event_data']['booking'];
                $gym = $webhook_contenido['event_data']['gym'];

                if (!empty($user['unique_token'])) {
                    $cliente_row = $this->wellhub_model->obtener_cliente_por_gympass_user_id($user['unique_token'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;
                    }
                }

                if (!$flar_validar_cliente && !empty($user['email'])) {
                    $cliente_row = $this->wellhub_model->obtener_cliente_por_email($user['email'])->row();
                    if (!empty($cliente_row)) {
                        $flar_validar_cliente = true;

                        $data_1 = ['gympass_user_id' => $user['unique_token'] ?? null];
                        if (!$this->wellhub_model->actualizar_usuario_por_id($cliente_row->id, $data_1)) {
                            throw new Exception('No se pudo vincular la cuenta de usuario con Gympass. Por favor, intente nuevamente.');
                        }
                    }
                }

                if (!$flar_validar_cliente) {
                    $nombre_completo = $user['name'] ?? '';
                    $nombre_dividido = $this->dividir_nombre($nombre_completo);

                    $data_1 = [
                        'gympass_user_id' => $user['unique_token'] ?? null,
                        'nombre_completo' => $nombre_dividido['nombre'] ?? '',
                        'apellido_paterno' => $nombre_dividido['apellido_paterno'] ?? '',
                        'apellido_materno' => $nombre_dividido['apellido_materno'] ?? '',
                        'correo' => $user['email'] ?? null,
                        'no_telefono' => $user['phone_number'] ?? null,
                        'contrasena_hash' => password_hash('temporal', PASSWORD_DEFAULT),
                        'rol_id' => 1, // Este usuario pertenece al rol con id 1 (Cliente)
                        'es_estudiante' => 'no',
                        'es_estudiante_vigencia' => date('Y-m-d'),
                        'fecha_nacimiento' => date('Y-m-d'),
                        'rfc' => null,
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

                    if (!$this->wellhub_model->insertar_usuario($data_1)) {
                        throw new Exception('Ocurrió un error al registrar el usuario. Por favor, intente nuevamente.');
                    }

                    $cliente_row = $this->wellhub_model->obtener_cliente_por_gympass_user_id($user['unique_token'])->row();
                }

                if (!$cliente_row) {
                    throw new Exception('El usuario no fue encontrado. Por favor, verifique los datos proporcionados.');
                }

                $reservacion_row = $this->wellhub_model->reservaciones_obtener_por_gympass_booking_number($booking['booking_number'])->row();
                if (!$reservacion_row) {
                    throw new Exception('El usuario no tiene una reserva para esta clase.');
                }

                $data_2 = array(
                    'asistencia' => 'completada',
                );

                if (!$this->wellhub_model->reservaciones_actualizar_por_id($reservacion_row->id, $data_2)) {
                    throw new Exception('No se pudo crear la reserva. Por favor, intente nuevamente.');
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    throw new Exception('La transacción falló al completar la operación. Por favor, intente nuevamente.');
                }

                $data_result = array(
                    "gympass_id" => $cliente_row->gympass_user_id,
                    //"gympass_id" => 1234321567890,
                );

                $response = $this->gympass_lib->post_access_validate($gym['id'], $data_result);

                $data_3 = array(
                    'data' => !empty($webhook_row->data) ? $webhook_row->data . ',' . json_encode($data_result) : json_encode($data_result),
                    'respuesta' => !empty($webhook_row->respuesta) ? $webhook_row->respuesta . ',' . json_encode($response) : json_encode($response),
                );

                $this->wellhub_model->webhook_actualizar_por_id($webhook_row->id, $data_3);

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

    private function generar_gympass_signatures($requestBody, $secretKey)
    {
        $json_body = json_encode($requestBody, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $signature1 = hash_hmac('sha1', $json_body, $secretKey);

        $json_body_pretty = json_encode($requestBody, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $signature2 = hash_hmac('sha1', $json_body_pretty, $secretKey);

        return [strtoupper($signature1), strtoupper($signature2)];
    }

    private function determinar_reason_category($code)
    {
        switch ($code) {
            case 1001:
                return 'CLASS_IS_FULL'; // La reserva fue rechazada porque la clase está llena
            case 1002:
                return 'USAGE_RESTRICTION'; // La reserva fue rechazada por límites de uso
            case 1003:
                return 'USER_IS_ALREADY_BOOKED'; // La reserva fue rechazada porque el usuario ya ha reservado esta clase
            case 1004:
                return 'SPOT_NOT_AVAILABLE'; // La reserva fue rechazada porque no hay lugares disponibles
            case 1005:
                return 'USER_DOES_NOT_EXIST'; // La reserva fue rechazada porque el usuario necesita registrarse primero
            case 1006:
                return 'CHECK_IN_AND_CANCELATION_WINDOWS_CLOSED'; // La reserva fue rechazada porque no es posible reservar esta clase en este momento
            case 1007:
                return 'CLASS_HAS_BEEN_CANCELED'; // La reserva fue rechazada porque la clase ha sido cancelada
            case 1008:
                return 'CLASS_NOT_FOUND'; // La reserva fue rechazada porque la clase no se encontró
            case 1009:
                return 'USER_PROFILE_CMS'; // La reserva fue rechazada por un error en el perfil del usuario
            case 1010:
                return 'TECHNICAL_ERROR'; // La reserva fue rechazada por un error técnico
            case 1011:
                return 'PREREQUISITES'; // La reserva fue rechazada porque esta clase tiene requisitos previos
            default:
                return 'GENERAL_ERROR'; // La reserva fue rechazada porque ocurrió un error
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
