<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/vendor/autoload.php';

class Gympass_lib
{

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper('file');
        $this->gympass_base_url = 'https://apitesting.partners.gympass.com';
        $this->gympass_api_key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyNjYzNGFmYy1kZjE4LTQ1MzctYjEzMC1hM2VlZjY2ODVhN2IiLCJpc3MiOiJwYXJ0bmVycy10ZXN0aW5nLWlhbS51cy5zdGcuZ3ltcGFzcy5jbG91ZCIsImlhdCI6MTcxMzk3NTE3NSwianRpIjoiMjY2MzRhZmMtZGYxOC00NTM3LWIxMzAtYTNlZWY2Njg1YTdiIn0.FArt7ha1fJuNihB9Am0y_858duLbNU8ghQe0XQI78ZM';
        $this->gympass_gym_id = 60;
        $this->gympass_partner_id = 'b806bd77-d913-4046-a6e7-8fba7b34d277';
        $this->gympass_system_id = 81;
    }

    /**
     * Obtiene la lista de clases del gimnasio.
     *
     * @return string JSON con la lista de clases
     * @throws Exception si hay un error al llamar a la API
     */
    public function get_list_classes()
    {
        // Obtener la URL base y la clave de la API desde la configuración
        $gympass_base_url = $this->gympass_base_url;
        $gympass_api_key = $this->gympass_api_key;
        $gympass_gym_id = $this->gympass_gym_id;

        if (!$gympass_base_url || !$gympass_api_key || !$gympass_gym_id) {
            throw new Exception("La configuración de Gympass no está completa: " . $gympass_base_url);
        }

        // Construir la URL de la API
        $url = "$gympass_base_url/booking/v1/gyms/$gympass_gym_id/classes";

        // Configurar los encabezados de la solicitud
        $headers = [
            'Accept: application/json',
            'Authorization: Bearer ' . $gympass_api_key
        ];

        // Configurar la solicitud cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Realizar la solicitud a la API
        $response = curl_exec($ch);

        // Verificar si hubo un error en la solicitud
        if ($response === false) {
            $error_message = curl_error($ch);
            curl_close($ch);
            throw new Exception("Error al llamar a la API: $error_message");
        }

        // Obtener el código de estado de la respuesta
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Verificar si la respuesta fue exitosa (código 200)
        if ($http_status !== 200) {
            throw new Exception("Error al llamar a la API: Código de estado HTTP $http_status");
        }

        // Registrar la respuesta exitosa en el archivo de registro
        $log_message = "Respuesta exitosa de la API: $response";
        log_message('info', $log_message);

        // Retornar la respuesta de la API
        return $response;
    }
}
