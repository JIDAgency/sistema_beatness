<?php defined('BASEPATH') or exit('No direct script access allowed');

class Resenias extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('clases_model');
        $this->load->model('reportes_model');
        $this->load->model('resenias_model');
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Resenias';
        $data['pagina_subtitulo'] = 'Reportes de resnias';
        $data['menu_clases_activo'] = true;

        $data['controlador'] = 'resenias';
        $data['ir_a'] = 'resenias/crear';
        $data['regresar_a'] = 'inicio';
        $controlador_js = 'resenias/index';

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

        $this->construir_private_site_ui('resenias/index', $data);
    }

    public function obtener_tabla_resenias()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $resenias_list = $this->resenias_model->obtener_tabla_resenias();

        $data = [];
        $estrellas = [];

        foreach ($resenias_list->result() as $reporte_key => $resenia_value) {

            $data[] = array(
                'id' => $reporte_key + 1,
                'calificacion' => $resenia_value->calificacion . ' ⭐️',
                'nota' => $resenia_value->nota,
                'instructor' => $resenia_value->coach . ' #' . $resenia_value->instructor_id,
                'clase' => $resenia_value->nombre . ' ' . $resenia_value->dificultad,
                'fecha_registro' => $resenia_value->fecha_registro,
            );
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $resenias_list->num_rows(),
            'recordsFiltered' => $resenias_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }
}
