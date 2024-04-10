<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Gympass extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->config->load('b3studio', true);
    }

    public function checkin_post()
    {
        // Obtener el cuerpo de la solicitud
        $data_body = $this->input->raw_input_stream;

        $this->response($data_body, REST_Controller::HTTP_OK);

        // Verificar la firma de Gympass
        $gympass_signature = $this->verifySignature($data_body);
        $_signature = $this->input->get_request_header('X-Gympass-Signature', TRUE);

        if ($gympass_signature !== $_signature) {
            // La firma no coincide, probablemente una solicitud maliciosa
            $this->response(['error' => 'Forbidden'], REST_Controller::HTTP_FORBIDDEN);
        }

        // La firma coincide, procesar el evento
        $eventData = json_decode($data_body, TRUE);
        // Aquí puedes realizar acciones basadas en los datos del evento, como actualizar tu base de datos

        // Responder a Gympass con un código 200 OK
        $this->response(['message' => 'OK'], REST_Controller::HTTP_OK);
    }

    private function verifySignature($data_body)
    {
        // Método para verificar la firma utilizando la clave secreta de Gympass
        $secretKey = '2106137401033';
        $signature = hash_hmac('sha1', $data_body, $secretKey);
        return strtoupper($signature);
    }
}
