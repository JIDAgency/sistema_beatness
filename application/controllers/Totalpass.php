<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Totalpass extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('totalpass_lib');
        $this->load->model('totalpass_model');
        $this->load->model('clases_model');
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Totalpass';
        $data['pagina_subtitulo'] = 'Totalpass';
        $data['pagina_totalpass'] = true;

        $data['controlador'] = 'totalpass';
        $data['regresar_a'] = 'inicio';
        $controlador_js = "totalpass/index";

        $data['styles'] = array();

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('totalpass/index', $data);
    }

    public function disciplinas()
    {
        $data['pagina_titulo'] = 'Disciplinas';
        $data['pagina_subtitulo'] = 'Vincular disciplinas';
        $data['pagina_totalpass'] = true;

        $data['controlador'] = 'totalpass';
        $data['regresar_a'] = 'inicio';
        $controlador_js = "totalpass/disciplinas";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $token_data = $this->totalpass_model->obtener_token()->row();

        if (time() >= $token_data->valor_2) {
            $this->totalpass_lib->token_renovar();
            $token_data = $this->totalpass_model->obtener_token()->row();
        }

        $token_data = json_decode($token_data->json_1);
        $token_data = $token_data;

        $data['token_data'] = $token_data;

        $this->construir_private_site_ui('totalpass/disciplinas', $data);
    }

    public function disciplinas_obtener()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $disciplinas_list = $this->totalpass_model->disciplinas_obtener();

        $data = [];

        foreach ($disciplinas_list->result() as $disciplina_key => $disciplina_value) {
            $opciones = '<a href="javascript:crear_ocurrencia_evento(' . $disciplina_value->id . ')" class="" data-id="' . $disciplina_value->id . '">Registrar</a>';

            $data[] = array(
                'id' => $disciplina_value->id,
                'nombre' => $disciplina_value->nombre,
                'totalpass_plan_id' => $disciplina_value->totalpass_plan_id,
                'estatus' => mb_strtoupper($disciplina_value->estatus),
            );
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $disciplinas_list->num_rows(),
            'recordsFiltered' => $disciplinas_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    public function clases()
    {
        $data['pagina_titulo'] = 'Clases';
        $data['pagina_subtitulo'] = 'Clases | Totalpass';
        $data['pagina_totalpass'] = true;

        $data['controlador'] = 'totalpass';
        $data['regresar_a'] = 'inicio';
        $controlador_js = "totalpass/clases";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('totalpass/clases', $data);
    }

    public function clases_obtener_activas()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $clases_list = $this->totalpass_model->clases_obtener_activas();

        $data = [];

        foreach ($clases_list->result() as $clase_key => $clase_value) {
            $opciones = '';
            if (!empty($clase_value->totalpass_eventOccurrenceUuid)) {
                // $opciones .= '<a href="javascript:crear_ocurrencia_evento(' . $clase_value->id . ')" class="" data-id="' . $clase_value->id . '">Actualizar</a>';
            } else {
                $opciones .= '<a href="javascript:crear_ocurrencia_evento(' . $clase_value->id . ')" class="" data-id="' . $clase_value->id . '">Registrar</a>';
            }

            $data[] = array(
                'opciones' => $opciones,
                'id' => $clase_value->id,
                'totalpass_event_id' => !empty($clase_value->totalpass_event_id) ? $clase_value->totalpass_event_id : '<span class="text-muted">No cargada</span>',
                'totalpass_eventOccurrenceUuid' => !empty($clase_value->totalpass_eventOccurrenceUuid) ? $clase_value->totalpass_eventOccurrenceUuid : '<span class="text-muted">No cargada</span>',
                'identificador' => $clase_value->identificador,
                'disciplinas_nombre' => $clase_value->disciplinas_nombre,
                'dificultad' => $clase_value->dificultad,
                'fecha' => date('Y-m-d', strtotime($clase_value->inicia)),
                'horario' => date('h:i A', strtotime($clase_value->inicia)),
                'instructores_nombre' => $clase_value->instructores_nombre,
                'sucursales_locacion' => $clase_value->sucursales_locacion,
                'cupos' => $clase_value->reservado . '/' . $clase_value->cupo
            );
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $clases_list->num_rows(),
            'recordsFiltered' => $clases_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    public function crear_ocurrencia_evento($id)
    {
        $this->db->trans_begin();

        try {
            $clase_row = $this->totalpass_model->clases_obtener_por_id($id)->row();

            if (!$clase_row) {
                throw new Exception('Clase no encontrada', 1001);
            }

            $data_1 = array(
                'title' => mb_strtoupper($clase_row->dificultad),
                'responsible' => $clase_row->instructores_nombre,
                'duration' => $clase_row->intervalo_horas * 60,
                'slots' => intval($clase_row->cupo - $clase_row->reservado),
                'planId' => 19976,
                'eventDate' => date('Y-m-d', strtotime($clase_row->inicia)),
                'startTime' => date('h:i A', strtotime($clase_row->inicia)),
                'timezone' => 'es-MX',
                'description' => $clase_row->disciplinas_nombre
            );

            $response = $this->totalpass_lib->crear_ocurrencia_evento($data_1);

            if (isset($response['error']) && $response['error'] === true) {
                $error_message = is_array($response['message']) ? implode(', ', $response['message']) : $response['message'];
                throw new Exception('Error al crear la ocurrencia del evento en Totalpass: ' . $error_message, 1002);
            }

            $data_2 = array(
                'totalpass_event_id' => isset($response['id']) ? $response['id'] : null,
                'totalpass_eventOccurrenceUuid' => isset($response['eventOccurrenceUuid']) ? $response['eventOccurrenceUuid'] : null,
                'totalpass_json' => json_encode($response)
            );

            if (!$this->totalpass_model->clases_actualizar_por_id($clase_row->id, $data_2)) {
                throw new Exception('Error al crear la ocurrencia del evento en Totalpass.', 1002);
            }

            $clase_actualizada_row = $this->totalpass_model->clases_obtener_por_id($id)->row();

            $opciones = '';
            if (!empty($clase_actualizada_row->totalpass_eventOccurrenceUuid)) {
                // $opciones .= '<a href="javascript:crear_ocurrencia_evento(' . $clase_actualizada_row->id . ')" class="" data-id="' . $clase_actualizada_row->id . '">Actualizar</a>';
            } else {
                $opciones .= '<a href="javascript:crear_ocurrencia_evento(' . $clase_actualizada_row->id . ')" class="" data-id="' . $clase_actualizada_row->id . '">Registrar</a>';
            }

            $data_3 = array(
                'opciones' => $opciones,
                'id' => $clase_actualizada_row->id,
                'totalpass_event_id' => !empty($clase_actualizada_row->totalpass_event_id) ? $clase_actualizada_row->totalpass_event_id : '<span class="text-muted">No cargada</span>',
                'totalpass_eventOccurrenceUuid' => !empty($clase_actualizada_row->totalpass_eventOccurrenceUuid) ? $clase_actualizada_row->totalpass_eventOccurrenceUuid : '<span class="text-muted">No cargada</span>',
                'identificador' => $clase_actualizada_row->identificador,
                'disciplinas_nombre' => $clase_actualizada_row->disciplinas_nombre,
                'dificultad' => $clase_actualizada_row->dificultad,
                'fecha' => date('Y-m-d', strtotime($clase_actualizada_row->inicia)),
                'horario' => date('h:i A', strtotime($clase_actualizada_row->inicia)),
                'instructores_nombre' => $clase_actualizada_row->instructores_nombre,
                'sucursales_locacion' => $clase_actualizada_row->sucursales_locacion,
                'cupos' => $clase_actualizada_row->reservado . '/' . $clase_actualizada_row->cupo
            );

            $this->db->trans_commit();

            $this->output_json(array(
                'success' => true,
                'message' => 'Ocurrencia del evento creada correctamente en Totalpass.',
                'data' => $data_3
            ));
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $mensaje_tipo = ($e->getCode() === 1002) ? 'info' : 'error';
            $this->output_json(array('error' => true, 'message' => $e->getMessage()));
        }
    }

    private function output_json($data)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
