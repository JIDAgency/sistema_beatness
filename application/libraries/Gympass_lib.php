<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/vendor/autoload.php';

class Gympass_lib
{
    private $gympass_base_url;
    private $gympass_api_key;
    private $gympass_gym_id;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper('file');

        $this->gympass_base_url = 'https://apitesting.partners.gympass.com';
        $this->gympass_api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyNjYzNGFmYy1kZjE4LTQ1MzctYjEzMC1hM2VlZjY2ODVhN2IiLCJpc3MiOiJwYXJ0bmVycy10ZXN0aW5nLWlhbS51cy5zdGcuZ3ltcGFzcy5jbG91ZCIsImlhdCI6MTcxMzk3NTE3NSwianRpIjoiMjY2MzRhZmMtZGYxOC00NTM3LWIxMzAtYTNlZWY2Njg1YTdiIn0.FArt7ha1fJuNihB9Am0y_858duLbNU8ghQe0XQI78ZM';
        $this->gympass_gym_id = 60;
        $this->gympass_partner_id = 'b806bd77-d913-4046-a6e7-8fba7b34d277';
        $this->gympass_system_id = 81;
        $this->gympass_secret_key = 'office_eagle_consider'; // Clave secreta para la firma X-Gympass-Signature
    }

    private function call_api($url, $method = 'GET', $data = null)
    {
        $headers = [
            'Authorization: Bearer ' . $this->gympass_api_key,
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
            return json_decode($response, true); // Success response
        } else {
            $error_response = json_decode($response, true);
            return ['error' => true, 'message' => $error_response['Message'] ?? $error_response['message'] ?? 'Error desconocido en la API (' . $response . ')'];
        }
    }

    // ============ PRODUCTS ============

    public function get_list_products()
    {
        $url = $this->gympass_base_url . "/setup/v1/gyms/{$this->gympass_gym_id}/products";
        return $this->call_api($url);
    }

    // ============ CLASSES ============

    public function post_create_class($data)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes";
        return $this->call_api($url, 'POST', $data);
    }

    public function get_list_classes()
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes";
        return $this->call_api($url);
    }

    public function get_class_details($class_id)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/$class_id?show-deleted=false";
        return $this->call_api($url);
    }

    public function put_update_class($class_id, $data)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/$class_id/";
        return $this->call_api($url, 'PUT', $data);
    }

    // ============ SLOTS ============

    public function post_create_slot($class_id, $data)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots";
        return $this->call_api($url, 'POST', $data);
    }

    public function get_slot_details($class_id, $slot_id)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots/{$slot_id}";
        return $this->call_api($url);
    }

    public function get_list_slots($class_id, $from, $to)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots?from={$from}&to={$to}";
        return $this->call_api($url);
    }

    public function delete_slot($class_id, $slot_id)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots/{$slot_id}";
        return $this->call_api($url, 'DELETE');
    }

    public function patch_update_slot($class_id, $slot_id, $data)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots/{$slot_id}";
        return $this->call_api($url, 'PATCH', $data);
    }

    public function put_update_slot($class_id, $slot_id, $data)
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots/{$slot_id}";
        return $this->call_api($url, 'PUT', $data);
    }

    // ============ BOOKING ============

    public function patch_validate_booking($booking_number, $data)
    {
        // $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/bookings/{$booking_number}";
        $url = $this->gympass_base_url . "/booking/v2/gyms/{$this->gympass_gym_id}/bookings/{$booking_number}";
        return $this->call_api($url, 'PATCH', $data);
    }
}
