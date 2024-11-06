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

        $this->gympass_base_url = 'https://api.partners.gympass.com';
        $this->gympass_api_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI4NjIyMjUwNS05ZDM0LTRlODItOGY5ZS0wZTE1MTI0YTQ3Y2EiLCJpYXQiOjE3MTg2MjQxOTQsImlzcyI6ImlhbS51cy5neW1wYXNzLmNsb3VkIiwic3ViIjoiODYyMjI1MDUtOWQzNC00ZTgyLThmOWUtMGUxNTEyNGE0N2NhIn0.gGUd_IUegwTy-_WqaXTgXtXBFc9EpHXpqcnykzc5J54';
        $this->gympass_gym_id = null;
        // $this->gympass_gym_id = 482157;
        $this->gympass_partner_id = 'b806bd77-d913-4046-a6e7-8fba7b34d277';
        $this->gympass_system_id = 81;
        $this->gympass_secret_key = 'marca_fuerza_vigor_bienestar_meta_equipo';
        $this->gympass_access_control_base_url = 'https://api.partners.gympass.com';
        $this->gympass_access_control_api_key = $this->gympass_api_key;

        // $this->gympass_base_url = 'https://apitesting.partners.gympass.com';
        // $this->gympass_api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyNjYzNGFmYy1kZjE4LTQ1MzctYjEzMC1hM2VlZjY2ODVhN2IiLCJpc3MiOiJwYXJ0bmVycy10ZXN0aW5nLWlhbS51cy5zdGcuZ3ltcGFzcy5jbG91ZCIsImlhdCI6MTcxMzk3NTE3NSwianRpIjoiMjY2MzRhZmMtZGYxOC00NTM3LWIxMzAtYTNlZWY2Njg1YTdiIn0.FArt7ha1fJuNihB9Am0y_858duLbNU8ghQe0XQI78ZM';
        // $this->gympass_gym_id = 60;
        // $this->gympass_partner_id = 'b806bd77-d913-4046-a6e7-8fba7b34d277';
        // $this->gympass_system_id = 81;
        // $this->gympass_secret_key = 'office_eagle_consider';
        // $this->gympass_access_control_base_url = 'https://apitesting.partners.gympass.com';
        // // $this->gympass_access_control_api_key = 'testkey';
        // $this->gympass_access_control_api_key = $this->gympass_api_key;

        // PRODUCT ID = 120
        // CLASS ID = 1799 para push day
    }

    private function call_api($url, $method = 'GET', $data = null)
    {
        $headers = [
            'Authorization: Bearer ' . $this->gympass_api_key,
            'Accept: application/json',
            'Content-Type: application/json',
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

    private function call_api_access_control($url, $method = 'GET', $data = null)
    {
        $headers = [
            'Authorization: Bearer ' . $this->gympass_access_control_api_key,
            'Accept: application/json',
            'Content-Type: application/json',
            'X-Gym-Id: ' . $this->gympass_gym_id
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

            // Extraer el mensaje de error
            $error_message = 'Error desconocido en la API.';
            if (isset($error_response['errors']) && is_array($error_response['errors']) && count($error_response['errors']) > 0) {
                $errors = $error_response['errors'];
                $error_messages = array_column($errors, 'message');
                $error_message = implode(' | ', $error_messages);
            } elseif (isset($error_response['Message'])) {
                $error_message = $error_response['Message'];
            } elseif (isset($error_response['message'])) {
                $error_message = $error_response['message'];
            } else {
                $error_message .= ' (' . $response . ')';
            }

            return ['error' => true, 'message' => $error_message];
        }
    }

    // ============ PRODUCTS ============

    public function get_list_products($gym_id)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_base_url . "/setup/v1/gyms/{$this->gympass_gym_id}/products";
        return $this->call_api($url);
    }

    // ============ CLASSES ============

    public function post_create_class($gym_id, $data)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes";
        return $this->call_api($url, 'POST', $data);
    }

    public function get_list_classes()
    {
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes";
        return $this->call_api($url);
    }

    public function get_class_details($gym_id, $class_id)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/$class_id?show-deleted=false";
        return $this->call_api($url);
    }

    public function put_update_class($gym_id, $class_id, $data)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/$class_id/";
        return $this->call_api($url, 'PUT', $data);
    }

    // ============ SLOTS ============

    public function post_create_slot($gym_id, $class_id, $data)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots";
        return $this->call_api($url, 'POST', $data);
    }

    public function put_update_slot($gym_id, $class_id, $slot_id, $data)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots/{$slot_id}";
        return $this->call_api($url, 'PUT', $data);
    }

    public function delete_slot($gym_id, $class_id, $slot_id)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots/{$slot_id}";
        return $this->call_api($url, 'DELETE');
    }

    public function patch_update_slot($gym_id, $class_id, $slot_id, $data)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/classes/{$class_id}/slots/{$slot_id}";
        return $this->call_api($url, 'PATCH', $data);
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

    // ============ BOOKING ============

    public function patch_validate_booking($gym_id, $booking_number, $data)
    {
        $this->gympass_gym_id = $gym_id;
        // $url = $this->gympass_base_url . "/booking/v1/gyms/{$this->gympass_gym_id}/bookings/{$booking_number}";
        $url = $this->gympass_base_url . "/booking/v2/gyms/{$this->gympass_gym_id}/bookings/{$booking_number}";
        return $this->call_api($url, 'PATCH', $data);
    }

    // ============ ACCESS CONTROL ============

    public function post_access_validate($gym_id, $data)
    {
        $this->gympass_gym_id = $gym_id;
        $url = $this->gympass_access_control_base_url . "/access/v1/validate";
        return $this->call_api_access_control($url, 'POST', $data);
    }
}
