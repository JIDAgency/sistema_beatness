<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Webhook extends REST_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->config->load('b3studio', true);
        $this->load->model('asignaciones_model');
        $this->load->model('ventas_model');
        $this->load->model('webhooks_model');
        $this->load->database();
    }

    public function recibir_post()
    {
        $data = $this->post();

        //Comprobar si ya existe esta misma transacción en la base de datos.
        $reviosar_si_es_duplicado = $this->webhooks_model->get_webhook_por_transaction_id($data['transaction']['id'])->row();

        $data_content = array(
            'openpay_webhook_id' => $data['id'],
            'type' => $data['type'],
            'event_date' => date('Y-m-d H:i:s', strtotime($data['event_date'])),
            'transaction_id' => $data['transaction']['id'],
            'transaction' => json_encode($data['transaction']),
            'verification_code' => $data['verification_code'],
            'content' => json_encode($data),
            'estatus' => 'recibido',
            'fecha_registro' => date('Y-m-d H:i:s'),
        );

        $inserted_webhook = $this->webhooks_model->insert_webhook($data_content);

        if (!$inserted_webhook) {

            //Si el webhook no se creo, regresar un estatus de error...
            $this->response( $inserted_webhook, 400 );

        } else {

            //Obtenemos el id de la inserción en la base de datos.
            $webhook_id = $this->db->insert_id();

            $webhook_content = $this->webhooks_model->get_webhook_por_id($webhook_id)->row();

            //Para proceder con la ejecución, comprobamos que nuestro webhook existe y que sea diferente de...
            if ($webhook_content) {

                if ($reviosar_si_es_duplicado) {

                    $data_content_update = array(
                        'estatus' => 'duplicado',
                    );

                    $update_webhook = $this->webhooks_model->update_webhook($webhook_content->id, $data_content_update);
                } else {

                    if ($webhook_content->type == 'verification' AND $webhook_content->estatus == 'recibido') {
                        //También se comprueba que el estatus del webhook no se haya modificado por otro proceso...

                        $data_content_update = array(
                            'estatus' => 'completado',
                        );

                        $update_webhook = $this->webhooks_model->update_webhook($webhook_content->id, $data_content_update);
                        
                    } elseif ($webhook_content->type != 'verification' AND $webhook_content->estatus == 'recibido') {

                        $transaction_content = json_decode($webhook_content->transaction);

                        if (isset($transaction_content->subscription_id) OR $transaction_content->subscription_id != '') {
                            # code...
                        
                            $asignacion_content = $this->asignaciones_model->get_asignacion_por_suscripcion_id($transaction_content->subscription_id)->row();

                            if ($asignacion_content) {
                                
                                if ($webhook_content->type == 'charge.succeeded') {

                                    $data_asignacion_update = array(
                                        'suscripcion_fecha_de_actualizacion' => date('Y-m-d H:i:s'),
                                        'suscripcion_estatus_del_pago' => 'pagado',
                                    );

                                    $update_asignacion = $this->asignaciones_model->editar($asignacion_content->id, $data_asignacion_update);

                                    /** Se crean y validan todos los arreglos de datos a guardar. */
                                    $data_venta = array(
                                        'concepto' => $asignacion_content->nombre,
                                        'usuario_id' => $asignacion_content->usuario_id,
                                        'asignacion_id' => $asignacion_content->id,
                                        'metodo_id' => 7,
                                        'costo' => $transaction_content->amount,
                                        'cantidad' => 1,
                                        'total' => $transaction_content->amount,
                                        'estatus' => 'Vendido',
                                        'vendedor' => 'Sistema de suscripciones (WH-Renovación)',
                                    );

                                    $registrar_venta = $this->ventas_model->crear($data_venta);

                                    $data_content_update = array(
                                        'estatus' => 'completado',
                                    );
                
                                    $update_webhook = $this->webhooks_model->update_webhook($webhook_content->id, $data_content_update);

                                } elseif ($webhook_content->type == 'subscription.charge.failed') {

                                    $data_asignacion_update = array(
                                        'suscripcion_fecha_de_actualizacion' => date('Y-m-d H:i:s'),
                                        'suscripcion_estatus_del_pago' => 'rechazado',
                                    );

                                    $update_asignacion = $this->asignaciones_model->editar($asignacion_content->id, $data_asignacion_update);

                                    $data_content_update = array(
                                        'estatus' => 'completado',
                                    );
                
                                    $update_webhook = $this->webhooks_model->update_webhook($webhook_content->id, $data_content_update);
                                }
                                
                            }

                        } else {
                            $data_content_update = array(
                                'comentario' => 'WebHook de compra de la app',
                            );
        
                            $update_webhook = $this->webhooks_model->update_webhook($webhook_content->id, $data_content_update);
                        }
                    }
                }
            }
        }

        $this->response($inserted_webhook, 200 );

    }

    /*public function recibir_post()
    {
        $data = $this->post();

        $data_content = array(
            'type' => $data['type'],
            'event_date' => $data['event_date'],
            'transaction' => $data['transaction'],
            'verification_code' => $data['verification_code'],
            'content' => json_encode(),
            'estatus' => 'recibido',
            'fecha_registro' => date('Y-m-d H:i:s'),
        );

        $inserted_webhook = $this->webhooks_model->insert_webhook($data_content);

        $this->response( $inserted_webhook, 200 );

        {
            "type":"verification",
            "event_date":"2020-07-06T18:44:17-05:00",
            "verification_code":"vSUIcU4E",
            "id":"we8b4ajucc3uvzfscmql"
        }

    }*/

}
