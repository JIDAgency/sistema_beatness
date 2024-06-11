<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gympass extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('gympass_lib');
        $this->load->model('gympass_model');
    }

    public function disciplinas()
    {
        $data['pagina_titulo'] = 'Disciplinas';
        $data['pagina_subtitulo'] = 'Disciplinas | Gympass';
        $data['pagina_gympass'] = true;

        $data['controlador'] = 'gympass';
        $data['regresar_a'] = 'gympass';
        $controlador_js = "gympass/disciplinas";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $list_products = $this->list_products();
        if (isset($list_products['error']) && $list_products['error']) {
            $this->session->set_flashdata('MENSAJE_ERROR', $list_products['message'] . ' (1)');
            $list_products = null;
        }

        $disciplinas_list = $this->gympass_model->disciplinas_obtener()->result();

        if (!$disciplinas_list) {
            $this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (1)', $data['regresar_a']);
        }

        $data['list_products'] = $list_products;
        $data['disciplinas_list'] = $disciplinas_list;

        $this->construir_private_site_ui('gympass/disciplinas', $data);
    }

    public function actualizar_disciplina()
    {
        if ($this->input->method(true) != 'POST') {
            $this->output_json(['status' => 'error', 'message' => 'Método de solicitud no válido.']);
            return;
        }

        $disciplina_id = $this->input->post('id');
        $gympass_product_id = $this->input->post('gympass_product_id');

        if (empty($disciplina_id)) {
            $this->output_json(['status' => 'error', 'message' => 'Faltan parámetros.']);
            return;
        }

        if (!empty($gympass_product_id)) {
            if ($this->gympass_model->disciplina_esta_vinculado($gympass_product_id, $disciplina_id)) {
                $this->output_json(['status' => 'error', 'message' => 'Este ID de Gympass ya está vinculado a otra disciplina.']);
                return;
            }
        }

        $data = ['gympass_product_id' => $gympass_product_id ?: null];
        if ($this->gympass_model->disciplina_editar($disciplina_id, $data)) {
            $this->output_json(['status' => 'success', 'message' => 'ID de Gympass actualizado correctamente.']);
        } else {
            $this->output_json(['status' => 'error', 'message' => 'Error al actualizar el ID de Gympass.']);
        }
    }

    function categorias()
    {
        $data['pagina_titulo'] = 'Categorías';
        $data['pagina_subtitulo'] = 'Categorías | Gympass';
        $data['pagina_gympass'] = true;

        $data['controlador'] = 'gympass/categorias';
        $data['regresar_a'] = 'gympass';
        $controlador_js = "gympass/categorias";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $categorias_list = $this->gympass_model->categorias_obtener()->result();

        $data['categorias_list'] = $categorias_list;

        $this->construir_private_site_ui('gympass/categorias', $data);
    }

    public function actualizar_categoria()
    {
        try {
            if ($this->input->method(true) != 'POST') {
                $this->output_json(['status' => 'error', 'message' => 'Método de solicitud no válido.']);
                return;
            }

            $id = $this->input->post('id');

            if (empty($id)) {
                $this->output_json(['status' => 'error', 'message' => 'Faltan parámetros.']);
                return;
            }

            $categoria_row = $this->gympass_model->categorias_obtener_por_id($id)->row();

            if (empty($categoria_row->gympass_class_id)) {
                $this->output_json(['status' => 'error', 'message' => 'Esta categoría de clase aún no está vinculada a Gympass.']);
                return;
            }

            if (empty($categoria_row->disciplina_id)) {
                $this->output_json(['status' => 'error', 'message' => 'Esta categoría de clase aún no está vinculada a una Disciplina.']);
                return;
            }

            if (empty($categoria_row->disciplinas_gympass_product_id)) {
                $this->output_json(['status' => 'error', 'message' => 'Esta disciplina de clase aún no está vinculada a Gympass.']);
                return;
            }

            $data = [
                'name' => $categoria_row->nombre ?: null,
                'description' => $categoria_row->descripcion ?: null,
                'notes' => $categoria_row->nota ?: null,
                'bookable' => true,
                'visible' => true,
                'reference' => $categoria_row->id,
                'product_id' => $categoria_row->disciplinas_gympass_product_id ?: null,
            ];

            $data_in = $this->gympass_lib->get_class_details($categoria_row->gympass_class_id);
            if (!empty($data_in['message'])) {
                $this->output_json(['status' => 'error', 'message' => $data_in['message']]);
                return;
            }

            // $data_comparacion = [
            //     'name' => $data_in['name'] ?: null,
            //     'description' => $data_in['description'] ?: null,
            //     'notes' => $data_in['notes'] ?: null,
            //     'bookable' => $data_in['bookable'] ?: null,
            //     'visible' => $data_in['visible'] ?: null,
            //     'reference' => $data_in['reference'] ?: null,
            //     'product_id' => $data_in['product_id'] ?: null,
            // ];

            // if ($data == $data_comparacion) {
            //     $this->output_json(['status' => 'error', 'message' => 'Cambios ya registrados previamente.']);
            //     return;
            // }

            $response = $this->gympass_lib->put_update_class($categoria_row->gympass_class_id, $data);

            if (!empty($response)) {
                $this->output_json(['status' => 'error', 'message' => $response['message']]);
            } else {

                $this->gympass_model->categoria_actualizar_por_id($categoria_row->id, array('gympass_json' => json_encode($data_in, JSON_UNESCAPED_UNICODE)));

                $this->output_json(['status' => 'success', 'message' => 'Categorías de Gympass actualizada correctamente.']);
            }
        } catch (Exception $e) {
            $this->output_json(['status' => 'error', 'message' => 'Error al actualizar la Categorías de Gympass: ' . $e->getMessage()]);
        }
    }

    public function registrar_categoria()
    {
        try {
            if ($this->input->method(true) != 'POST') {
                $this->output_json(['status' => 'error', 'message' => 'Método de solicitud no válido.']);
                return;
            }

            $id = $this->input->post('id');

            if (empty($id)) {
                $this->output_json(['status' => 'error', 'message' => 'Faltan parámetros.']);
                return;
            }

            $categoria_row = $this->gympass_model->categorias_obtener_por_id($id)->row();

            if (empty($categoria_row->disciplina_id)) {
                $this->output_json(['status' => 'error', 'message' => 'Esta categoría de clase aún no está vinculada a una Disciplina.']);
                return;
            }

            if (empty($categoria_row->disciplinas_gympass_product_id)) {
                $this->output_json(['status' => 'error', 'message' => 'Esta disciplina de clase aún no está vinculada a Gympass.']);
                return;
            }

            if (!empty($categoria_row->gympass_class_id)) {
                $this->output_json(['status' => 'error', 'message' => 'Esta Categoría ya se encuentra registrada en Gympass.']);
                return;
            }

            $data = [
                'classes' => [
                    [
                        'name' => $categoria_row->nombre ?: null,
                        'description' => $categoria_row->descripcion ?: null,
                        'notes' => $categoria_row->nota ?: null,
                        'bookable' => true,
                        'visible' => true,
                        'reference' => (string)$categoria_row->id,
                        'product_id' => $categoria_row->disciplinas_gympass_product_id ?: null,
                    ]
                ]
            ];

            $response = $this->gympass_lib->post_create_class($data);

            if (!empty($response['message'])) {
                $this->output_json(['status' => 'error', 'message' => $response['message']]);
            } else {

                $this->gympass_model->categoria_actualizar_por_id($categoria_row->id, array('gympass_class_id' => $response['classes'][0]['id'], 'gympass_json' => json_encode($response, JSON_UNESCAPED_UNICODE)));

                $this->output_json(['status' => 'success', 'message' => 'Categorías de Gympass registrada correctamente.']);
            }
        } catch (Exception $e) {
            $this->output_json(['status' => 'error', 'message' => 'Error al registrar la Categorías de Gympass: ' . $e->getMessage()]);
        }
    }

    public function clases()
    {
        $data['pagina_titulo'] = 'Clases';
        $data['pagina_subtitulo'] = 'Clases | Gympass';
        $data['pagina_gympass'] = true;

        $data['controlador'] = 'gympass/clases';
        $data['regresar_a'] = 'gympass';
        $controlador_js = "gympass/clases";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $clases_list = $this->gympass_model->clases_obtener_activas()->result();
        $categorias_list = $this->gympass_model->categorias_obtener()->result();

        $data['clases_list'] = $clases_list;
        $data['categorias_list'] = $categorias_list;

        $this->construir_private_site_ui('gympass/clases', $data);
    }

    public function registrar_clase()
    {
        $this->db->trans_start();

        try {
            if (!$this->input->post()) {
                throw new Exception('No se recibieron datos de entrada.', 1001);
            }

            $id = $this->input->post('id');
            $categoria = $this->input->post('categoria');

            if (empty($id)) {
                throw new Exception('El ID de la clase no fue proporcionado.', 1001);
            }
            if (empty($categoria)) {
                throw new Exception('La categoría no fue proporcionada.', 1001);
            }

            $clase_row = $this->gympass_model->clases_obtener_por_id($id)->row();

            if (empty($clase_row)) {
                throw new Exception('La clase especificada no existe.', 1001);
            }

            if (!empty($clase_row->gympass_slot_id)) {
                throw new Exception('Esta clase ya se encuentra registrada en Gympass.', 1002);
            }

            $categoria_row = $this->gympass_model->categorias_obtener_por_id($categoria)->row();

            if (empty($categoria_row)) {
                throw new Exception('La categoría especificada no existe.', 1001);
            }

            if (empty($categoria_row->gympass_class_id)) {
                throw new Exception('La categoría especificada no tiene un Gympass Class ID asociado.', 1001);
            }

            $class_datetime = $clase_row->inicia;
            $puebla_timezone = new DateTimeZone('America/Mexico_City');
            $utc_timezone = new DateTimeZone('UTC');
            $class_date = new DateTime($class_datetime, $puebla_timezone);
            $class_date->setTimezone($utc_timezone);
            $occur_date = $class_date->format('Y-m-d\TH:i:s\Z');

            $booking_window_opens_date = clone $class_date;
            $booking_window_opens_date->modify('-5 days');
            $booking_window_opens = $booking_window_opens_date->format('Y-m-d\TH:i:s\Z');

            $booking_window_closes_date = clone $class_date;
            $booking_window_closes_date->modify('-1 hour');
            $booking_window_closes = $booking_window_closes_date->format('Y-m-d\TH:i:s\Z');

            $cancellable_until_date = clone $class_date;
            $cancellable_until_date->modify('-4 hours');
            $cancellable_until = $cancellable_until_date->format('Y-m-d\TH:i:s\Z');

            $status = $clase_row->estatus === 'Activa' ? 1 : 0;

            $data_1 = array(
                "occur_date" => $occur_date . '[UTC]',
                "status" => $status,
                "room" => 'Salon',
                "length_in_minutes" => $clase_row->intervalo_horas * 60,
                "total_capacity" => $clase_row->cupo,
                "total_booked" => $clase_row->reservado,
                "product_id" => $clase_row->disciplinas_gympass_product_id,
                "booking_window" => array(
                    "opens_at" => $booking_window_opens . '[UTC]',
                    "closes_at" => $booking_window_closes . '[UTC]'
                ),
                "cancellable_until" => $cancellable_until . '[UTC]',
                "instructors" => [
                    array(
                        "name" => trim($clase_row->instructores_nombre),
                        "substitute" => false
                    )
                ],
                "rate" => 4.0
            );

            $response = $this->gympass_lib->post_create_slot($categoria_row->gympass_class_id, $data_1);

            if (!is_array($response) || isset($response['error']) && $response['error'] === true) {
                throw new Exception("Error: " . ($response['message'] ?? 'Respuesta inválida de Gympass.'), 1001);
            }

            if (empty($response['results']) || !isset($response['results'][0]['id'])) {
                throw new Exception("La respuesta de Gympass no contiene un ID de slot válido.", 1001);
            }

            $data_2 = array(
                'categoria_id' => $categoria_row->id,
                'gympass_slot_id' => $response['results'][0]['id'],
                'gympass_json' => json_encode($response, true)
            );

            if (!$this->gympass_model->clase_actualizar_por_id($clase_row->id, $data_2)) {
                throw new Exception("No se pudo actualizar la clase en la base de datos.", 1001);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception('La transacción falló al completar la operación.', 1001);
            }

            $this->mensaje_del_sistema('MENSAJE_EXITO', 'La clase se ha registrado en Gympass correctamente.', 'gympass/clases');
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $mensaje_tipo = ($e->getCode() === 1002) ? 'MENSAJE_INFO' : 'MENSAJE_ERROR';
            $this->mensaje_del_sistema($mensaje_tipo, $e->getMessage(), 'gympass/clases');
        }
    }

    public function actualizar_clase()
    {
        $this->db->trans_start();

        try {
            if ($this->input->method() !== 'post') {
                throw new Exception('Método de solicitud no válido.', 1001);
            }

            $id = $this->input->post('id');

            if (empty($id)) {
                throw new Exception('El ID de la clase no fue proporcionado.', 1001);
            }

            $clase_row = $this->gympass_model->clases_obtener_por_id($id)->row();

            if (empty($clase_row)) {
                throw new Exception('La clase especificada no existe.', 1001);
            }

            if (empty($clase_row->gympass_slot_id)) {
                throw new Exception('Esta clase no se encuentra registrada en Gympass.', 1002);
            }

            $categoria_row = $this->gympass_model->categorias_obtener_por_id($clase_row->categoria_id)->row();

            if (empty($categoria_row)) {
                throw new Exception('La categoría especificada no existe.', 1001);
            }

            if (empty($categoria_row->gympass_class_id)) {
                throw new Exception('La categoría especificada no tiene un Gympass Class ID asociado.', 1001);
            }

            $class_datetime = $clase_row->inicia;
            $puebla_timezone = new DateTimeZone('America/Mexico_City');
            $utc_timezone = new DateTimeZone('UTC');
            $class_date = new DateTime($class_datetime, $puebla_timezone);
            $class_date->setTimezone($utc_timezone);
            $occur_date = $class_date->format('Y-m-d\TH:i:s\Z');

            $booking_window_opens_date = clone $class_date;
            $booking_window_opens_date->modify('-5 days');
            $booking_window_opens = $booking_window_opens_date->format('Y-m-d\TH:i:s\Z');

            $booking_window_closes_date = clone $class_date;
            $booking_window_closes_date->modify('-1 hour');
            $booking_window_closes = $booking_window_closes_date->format('Y-m-d\TH:i:s\Z');

            $cancellable_until_date = clone $class_date;
            $cancellable_until_date->modify('-4 hours');
            $cancellable_until = $cancellable_until_date->format('Y-m-d\TH:i:s\Z');

            $status = $clase_row->estatus === 'Activa' ? 1 : 0;

            $data_1 = array(
                "occur_date" => $occur_date . '[UTC]',
                "status" => $status,
                "room" => 'Salon',
                "length_in_minutes" => $clase_row->intervalo_horas * 60,
                "total_capacity" => $clase_row->cupo,
                "total_booked" => $clase_row->reservado,
                "product_id" => $clase_row->disciplinas_gympass_product_id,
                "booking_window" => array(
                    "opens_at" => $booking_window_opens . '[UTC]',
                    "closes_at" => $booking_window_closes . '[UTC]'
                ),
                "cancellable_until" => $cancellable_until . '[UTC]',
                "instructors" => [
                    array(
                        "name" => trim($clase_row->instructores_nombre),
                        "substitute" => false
                    )
                ],
                "rate" => 4.0
            );

            $response = $this->gympass_lib->put_update_slot($categoria_row->gympass_class_id, $clase_row->gympass_slot_id, $data_1);

            if (!is_array($response) || isset($response['error']) && $response['error'] === true) {
                throw new Exception("Error: " . ($response['message'] ?? 'Respuesta inválida de Gympass.'), 1001);
            }

            if (empty($response['results']) || !isset($response['results'][0]['id'])) {
                throw new Exception("La respuesta de Gympass no contiene un ID de slot válido.", 1001);
            }

            $data_2 = array(
                'gympass_json' => json_encode($response, true)
            );

            if (!$this->gympass_model->clase_actualizar_por_id($clase_row->id, $data_2)) {
                throw new Exception("No se pudo actualizar la clase en la base de datos.", 1001);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception('La transacción falló al completar la operación.', 1001);
            }

            $this->output_json(array('status' => 'success', 'message' => 'La clase se ha actualizado en Gympass correctamente.'));
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $mensaje_tipo = ($e->getCode() === 1002) ? 'info' : 'error';
            $this->output_json(array('status' => $mensaje_tipo, 'message' => $e->getMessage()));
        }
    }

    public function eliminar_clase()
    {
        $this->db->trans_start();

        try {
            if ($this->input->method() !== 'post') {
                throw new Exception('Método de solicitud no válido.', 1001);
            }

            $id = $this->input->post('id');

            if (empty($id)) {
                throw new Exception('El ID de la clase no fue proporcionado.', 1001);
            }

            $clase_row = $this->gympass_model->clases_obtener_por_id($id)->row();

            if (empty($clase_row)) {
                throw new Exception('La clase especificada no existe.', 1001);
            }

            if (empty($clase_row->gympass_slot_id)) {
                throw new Exception('Esta clase no se encuentra registrada en Gympass.', 1002);
            }

            $categoria_row = $this->gympass_model->categorias_obtener_por_id($clase_row->categoria_id)->row();

            if (empty($categoria_row)) {
                throw new Exception('La categoría especificada no existe.', 1001);
            }

            if (empty($categoria_row->gympass_class_id)) {
                throw new Exception('La categoría especificada no tiene un Gympass Class ID asociado.', 1001);
            }

            $response = $this->gympass_lib->delete_slot($categoria_row->gympass_class_id, $clase_row->gympass_slot_id);

            if (!empty($response) || isset($response['error']) && $response['error'] === true) {
                throw new Exception("Error: " . ($response['message'] ?? 'Respuesta inválida de Gympass.'), 1001);
            }

            $data_2 = array(
                'categoria_id' => null,
                'gympass_slot_id' => null,
                'gympass_json' => json_encode(array('eliminado' => $this->session->userdata('correo')), true)
            );

            if (!$this->gympass_model->clase_actualizar_por_id($clase_row->id, $data_2)) {
                throw new Exception("No se pudo actualizar la clase en la base de datos.", 1001);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception('La transacción falló al completar la operación.', 1001);
            }

            $this->output_json(array('status' => 'success', 'message' => 'La clase se ha eliminado en Gympass correctamente.'));
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $mensaje_tipo = ($e->getCode() === 1002) ? 'info' : 'error';
            $this->output_json(array('status' => $mensaje_tipo, 'message' => $e->getMessage()));
        }
    }

    public function reservacion_clase()
    {
        $this->db->trans_start();

        try {
            if ($this->input->method() !== 'post') {
                throw new Exception('Método de solicitud no válido.', 1001);
            }

            $id = $this->input->post('id');

            if (empty($id)) {
                throw new Exception('El ID de la clase no fue proporcionado.', 1001);
            }

            $clase_row = $this->gympass_model->clases_obtener_por_id($id)->row();

            if (empty($clase_row)) {
                throw new Exception('La clase especificada no existe.', 1001);
            }

            if (empty($clase_row->gympass_slot_id)) {
                throw new Exception('Esta clase no se encuentra registrada en Gympass.', 1002);
            }

            $categoria_row = $this->gympass_model->categorias_obtener_por_id($clase_row->categoria_id)->row();

            if (empty($categoria_row)) {
                throw new Exception('La categoría especificada no existe.', 1001);
            }

            if (empty($categoria_row->gympass_class_id)) {
                throw new Exception('La categoría especificada no tiene un Gympass Class ID asociado.', 1001);
            }


            $data_1 = array(
                "total_capacity" => $clase_row->cupo,
                "total_booked" => $clase_row->reservado
            );

            $response = $this->gympass_lib->patch_update_slot($categoria_row->gympass_class_id, $clase_row->gympass_slot_id, $data_1);

            if (!empty($response) || isset($response['error']) && $response['error'] === true) {
                throw new Exception("Error: " . ($response['message'] ?? 'Respuesta inválida de Gympass.'), 1001);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                throw new Exception('La transacción falló al completar la operación.', 1001);
            }

            $this->output_json(array('status' => 'success', 'message' => 'La clase se ha actualizado en Gympass correctamente.'));
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $mensaje_tipo = ($e->getCode() === 1002) ? 'info' : 'error';
            $this->output_json(array('status' => $mensaje_tipo, 'message' => $e->getMessage()));
        }
    }

    private function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Gympass';
        $data['pagina_subtitulo'] = 'Gympass';
        $data['pagina_gympass'] = true;

        $data['controlador'] = 'gympass';
        $data['regresar_a'] = 'inicio';
        $controlador_js = "gympass/index";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('gympass/index', $data);
    }

    // ============ PRODUCTS ============

    public function list_products()
    {
        try {
            $response = $this->gympass_lib->get_list_products();
            return $response;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
