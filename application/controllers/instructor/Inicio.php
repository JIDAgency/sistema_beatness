<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('clases_model');
        $this->load->model('disciplinas_model');
        $this->load->model('usuarios_model');
        $this->load->model('asignaciones_model');
        $this->load->model('reservaciones_model');
        $this->load->model('clases_en_linea_model');
    }

    public function index()
    {
		$data['menu_instructor_inicio'] = true;
		$data['pagina_titulo'] = 'Inicio';

		//revisar
		$data['controlador'] = 'instructor/inicio';
		$data['regresar_a'] = 'instructor/inicio';
		$controlador_js = "instructor/inicio/index";

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
  
        //$data['clases'] = $this->clases_model->obtener_todas_con_detalle();
        $data['clases'] = $this->clases_model->obtener_todas_para_front_con_detalle();
        $data['usuarios'] = $this->usuarios_model->obtener_todos();

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => $controlador_js.'.js'),
        );

        $this->instructor_ui('instructor/inicio/index', $data);

    }

}
