<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkin_model');
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Checkin';
        $data['pagina_subtitulo'] = 'Registro de checkin';
        $data['menu_checkins_activo'] = true;

        $data['controlador'] = 'checkin';
        $data['ir_a'] = 'checkin/crear';
        $data['regresar_a'] = 'inicio';
        $controlador_js = 'checkin/index';

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/moment.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );


        $this->construir_private_site_ui('checkin/index', $data);
    }

    public function obtener_tabla_index()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $checkin_list = $this->checkin_model->obtener_todos_checkins();

        $data = [];

        foreach ($checkin_list->result() as $checkin) {

            $opciones = '';

            $data[] = array(
                'opciones' => $opciones,
                'id' => $checkin->id,
                'usuario_id' => !empty($checkin->usuario_id) ? $checkin->usuario_id : '',
                'reservacion_id' => !empty($checkin->reservacion_id) ? $checkin->reservacion_id : '',
                'descripcion' => !empty($checkin->descripcion) ? $checkin->descripcion : '',
                'timestamp' => !empty($checkin->timestamp) ? $checkin->timestamp : '',
                'estatus' => !empty($checkin->estatus) ? $checkin->estatus : '',
                'fecha_registro' =>  (!empty($checkin->fecha_registro) ? date('h:i A', strtotime($checkin->fecha_registro)) : ''),
            );
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $checkin_list->num_rows(),
            'recordsFiltered' => $checkin_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }
}
