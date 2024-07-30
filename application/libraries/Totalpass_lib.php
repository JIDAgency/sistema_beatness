<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/vendor/autoload.php';

class Totalpass_lib
{
    private $CI;
    private $totalpass_base_url;
    private $place_api_key;
    private $partner_api_key;
    private $token;
    private $token_expiracion;
    private $token_response;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper('file');
        $this->CI->load->model('totalpass_model');

        $this->totalpass_base_url = 'https://booking-api.totalpass.com';

        $this->partner_api_key = '8e85f6e4-8653-470f-9cee-ac67321f38f6';

        // Sandbox
        // $this->place_api_key = '3e05190a-013e-4f0d-afc2-57dcf4d121e9';
        // Cycling Polanco
        // $this->place_api_key = '1c90544a-e9f6-4794-a8b4-adb1ac4eac20';
        // Bootcamp Polanco
        // $this->place_api_key = '1c38afd4-0dbc-4d3c-bf6f-8e201749e3b2';
        // Bootcamp Puebla
        $this->place_api_key = '90e01ec4-07f9-4d82-8cfe-7dadef7a3d31';

        $this->token_cargar();
    }

    private function token_cargar()
    {
        $token_data = $this->CI->totalpass_model->obtener_token()->row();
        if ($token_data) {
            $this->token = $token_data->valor_1;
            $this->token_expiracion = $token_data->valor_2;
        } else {
            $this->token = null;
            $this->token_expiracion = null;
        }
    }

    public function token_renovar()
    {
        $url = $this->totalpass_base_url . '/partner/auth';
        $response = $this->call_api_token(
            $url,
            'POST',
            array(
                'place_api_key' => $this->place_api_key,
                'partner_api_key' => $this->partner_api_key
            )
        );

        if (isset($response['token'])) {
            $this->token_guardar($response['token'], strtotime('+24 hours'), $response);
        } else {
            throw new Exception('Error al renovar el token: ' . ($response['message'] ?? 'Respuesta inválida de TotalPass.'));
        }
    }

    private function token_guardar($token, $expiracion, $response = null)
    {
        $this->token = $token;
        $this->token_expiracion = $expiracion;
        $this->token_response = $response;

        $data = array(
            'descripcion' => 'Se renueva cada 24 hrs. Última renovación: ' . date('Y-m-d H:i:s'),
            'valor_1' => $token,
            'valor_2' => strtotime('-10 minutes', $expiracion),
            'json_1' => json_encode($response)
        );

        $this->CI->totalpass_model->guardar_token($data);
    }

    private function token_esta_expirado()
    {
        return time() >= $this->token_expiracion;
    }

    private function call_api_token($url, $method = 'GET', $data = null)
    {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($data !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            $error_message = curl_error($ch);
            return ['error' => true, 'message' => "Error al llamar a la API: $error_message"];
        }

        if ($http_status >= 200 && $http_status < 300) {
            return json_decode($response, true);
        } else {
            $error_response = json_decode($response, true);
            return ['error' => true, 'message' => $error_response['Message'] ?? $error_response['message'] ?? 'Error desconocido en la API (' . $response . ')'];
        }
    }

    private function call_api($url, $method = 'GET', $data = null)
    {
        if ($this->token_esta_expirado()) {
            $this->token_renovar();
        }

        $headers = [
            'Authorization: Bearer ' . $this->token,
            'Accept: application/json',
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($data !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            $error_message = curl_error($ch);
            return ['error' => true, 'message' => "Error al llamar a la API: $error_message"];
        }

        if ($http_status >= 200 && $http_status < 300) {
            return json_decode($response, true);
        } else {
            $error_response = json_decode($response, true);
            return ['error' => true, 'message' => $error_response['Message'] ?? $error_response['message'] ?? 'Error desconocido en la API (' . $response . ')'];
        }
    }

    // Funciones para eventos
    public function obtener_events()
    {
        $url = $this->totalpass_base_url . "/partner/events";
        return $this->call_api($url);
    }

    public function crear_evento($data)
    {
        $url = $this->totalpass_base_url . "/partner/events";
        return $this->call_api($url, 'POST', $data);
    }

    public function actualizar_evento($event_id, $data)
    {
        $url = $this->totalpass_base_url . "/partner/events/$event_id";
        return $this->call_api($url, 'PUT', $data);
    }

    public function eliminar_evento($event_id)
    {
        $url = $this->totalpass_base_url . "/partner/events/$event_id";
        return $this->call_api($url, 'DELETE');
    }

    // Funciones para ocurrencias de eventos
    public function crear_ocurrencia_evento($data)
    {
        $url = $this->totalpass_base_url . "/partner/event-occurrence";
        return $this->call_api($url, 'POST', $data);
    }

    public function actualizar_ocurrencia_evento($event_occurrence_uuid, $data)
    {
        $url = $this->totalpass_base_url . "/partner/event-occurrence/$event_occurrence_uuid";
        return $this->call_api($url, 'PUT', $data);
    }

    public function eliminar_ocurrencia_evento($occurrence_uuid)
    {
        $url = $this->totalpass_base_url . "/partner/event-occurrence/$occurrence_uuid";
        return $this->call_api($url, 'DELETE');
    }

    public function obtener_ocurrencia_evento($occurrence_uuid)
    {
        $url = $this->totalpass_base_url . "/partner/events/$occurrence_uuid";
        return $this->call_api($url);
    }

    public function actualizar_slots_ocurrencia_evento($occurrence_uuid, $data)
    {
        $url = $this->totalpass_base_url . "/partner/event-occurrence/$occurrence_uuid/slot";
        return $this->call_api($url, 'PUT', $data);
    }

    // Funciones para slots
    public function obtener_slots($params = [])
    {
        $url = $this->totalpass_base_url . "/partner/slot";
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return $this->call_api($url);
    }

    public function cancelar_slot($slot_id)
    {
        $url = $this->totalpass_base_url . "/partner/slot/$slot_id";
        return $this->call_api($url, 'DELETE');
    }

    // Funciones para webhooks
    public function suscribir_webhook($webhook_url)
    {
        $url = $this->totalpass_base_url . "/partner/webhook/subscribe";
        $data = ['webhook_url' => $webhook_url];
        return $this->call_api($url, 'POST', $data);
    }

    public function obtener_webhook_url()
    {
        $url = $this->totalpass_base_url . "/partner/webhook";
        return $this->call_api($url);
    }

    public function eliminar_webhook()
    {
        $url = $this->totalpass_base_url . "/partner/webhook";
        return $this->call_api($url, 'DELETE');
    }
}
