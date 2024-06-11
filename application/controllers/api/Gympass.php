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
        $this->load->model('gympass_model');
    }

    public function index_post()
    {
        $this->db->trans_start();

        try {
            $body_post = $this->post();
            $headers_post = $this->input->request_headers();

            if (empty($body_post)) {
                throw new Exception('No se recibieron datos de entrada.', 1001);
            }

            $signatures = $this->generateGympassSignature($body_post, $this->gympass_lib->gympass_secret_key);
            $expectedSignature = isset($headers_post['x-gympass-signature']) ? $headers_post['x-gympass-signature'] : '';

            if (strcasecmp($signatures['signature1'], $expectedSignature) !== 0 && strcasecmp($signatures['signature2'], $expectedSignature) !== 0) {
                throw new Exception('Ninguna de las firmas generadas coincide con la esperada.', 1001);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception('La transacción falló al completar la operación.', 1001);
            }

            $this->response(array(
                // 'headers' => $headers_post,
                // 'body' => $body_post,
                'x-gympass-signature' => $expectedSignature,
            ), REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->db->trans_rollback();

            $mensaje_tipo = ($e->getCode() === 1002) ? 'MENSAJE_INFO' : 'MENSAJE_ERROR';

            $this->response(array(
                'error' => true,
                'type' => $mensaje_tipo,
                'mensaje' => $e->getMessage(),
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    private function generateGympassSignature($requestBody, $secretKey)
    {
        $json_body_option1 = json_encode($requestBody, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $json_body_option2 = json_encode($requestBody, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $signature1 = hash_hmac('sha1', $json_body_option1, $secretKey);
        $signature2 = hash_hmac('sha1', $json_body_option2, $secretKey);

        return array(
            'signature1' => strtoupper($signature1),
            'signature2' => strtoupper($signature2),
        );
    }
}
