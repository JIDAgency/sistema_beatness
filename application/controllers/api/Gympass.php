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
        try {
            $body_post = $this->post();
            $headers_post = $this->input->request_headers();

            if (empty($body_post)) {
                throw new Exception('No se recibieron datos de entrada.');
            }

            $signatures = $this->generar_gympass_signatures($body_post, $this->gympass_lib->gympass_secret_key);
            $signature_esperada = isset($headers_post['x-gympass-signature']) ? $headers_post['x-gympass-signature'] : '';

            if (!in_array(strtoupper($signature_esperada), $signatures)) {
                throw new Exception('Ninguna de las firmas generadas coincide con la esperada.');
            }

            $this->db->trans_start();

            $data_1 = array(
                'evento_tipo' => isset($body_post['event_type']) ? $body_post['event_type'] : null,
                'evento_id' => isset($body_post['event_data']['event_id']) ? $body_post['event_data']['event_id'] : null,
                'contenido' => json_encode($body_post, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            );

            if (!$this->wellhub_model->insertar_webhook($data_1)) {
                throw new Exception('Hubo un problema al procesar la solicitud del webhook.');
            }

            $webhook_id = $this->db->insert_id();

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception('La transacción falló al completar la operación.');
            }

            $this->output->set_header('X-Gympass-Signature: ' . $signature_esperada);
            $this->set_response(REST_Controller::HTTP_OK);

            // Permite que la respuesta se envíe de inmediato
            ignore_user_abort(true);
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }

            // Ejecuta la función en segundo plano
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

        try {

            if ($webhook_row->evento_tipo == 'booking-requested') {
                $flar_validar_cliente = false;
                $user = $webhook_contenido['event_data']['user'];

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

                        $data_1 = [
                            'gympass_user_id' => $user['unique_token'] ?? null,
                        ];

                        if ($this->wellhub_model->actualizar_usuario_por_id($cliente_row->id, $data_1)) {
                            throw new Exception('No fue posible vincular su cuenta de usuario con Gympass.', 1009);
                        }
                    }
                }

                if (!$flar_validar_cliente) {
                    $nombre_completo = isset($user['name']) ? $user['name'] : '';
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
                        throw new Exception('Ninguna de las firmas generadas coincide con la esperada.');
                    }
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception('La transacción falló al completar la operación.');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();

            $reason = $this->determinar_reason_category($e->getCode());

            $data_2 = array(
                'status' => 3,
                'reason' => $e->getMessage(),
                'reason_category' => $reason,
            );

            print_r($data_2);

            $response = $this->gympass_lib->patch_validate_booking($webhook_contenido['event_data']['slot']['booking_number'], $data_2);
            echo '<br>';
            print_r($response);
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
