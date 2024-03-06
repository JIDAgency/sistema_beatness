<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('asignaciones_model');
	}

	public function index()
	{		
		$data['menu_inicio_activo'] = true;
        $data['pagina_titulo'] = 'Inicio';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Cargar estilos y scripts
        $data['styles'] = array(
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/charts/echarts/echarts.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/charts/chart.min.js'),
            array('es_rel' => true, 'src' => 'inicio/index.js'),
        );

		//$planes_godin_list = $this->asignaciones_model->get_todas_las_godin_activas()->result();

		//$data['planes_godin_list'] = $planes_godin_list;

        $this->construir_private_site_ui('inicio/index', $data);
	}


}
