<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class comprar_planes_confirmarpago extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('reservaciones_model');
		$this->load->model('clases_model');

	}

	public function index()
	{
		$id = $this->session->userdata("id");
		$data['reservaciones'] = $this->reservaciones_model->obtener_reservacion_para_cliente($id);
		$data['clases'] = $this->clases_model->obtener_todas_con_detalle();
		
		$data['menu_usuario_comprar_plan_activo'] = true;
        $data['pagina_titulo'] = 'Comprar Plan';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		//$this->session->userdata("nombre");

        $this->construir_private_usuario_ui('usuario/comprar_planes_confirmarpago', $data);
	}
}
