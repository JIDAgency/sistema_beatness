<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprar_planes extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('planes_model');
	}

	public function index()
	{
		redirect(base_url().'usuario/shop/');

		$data['planes_normales'] = $this->planes_model->get_planes_normales_disponibles_para_venta()->result();
		$data['planes_online'] = $this->planes_model->get_planes_online_disponibles_para_venta()->result();
		$data['planes_godinez'] = $this->planes_model->get_planes_godin_disponibles_para_venta()->result();
		
		$data['menu_usuario_comprar_planes_activo'] = true;
		$data['pagina_titulo'] = 'Comprar Plan';
		
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $this->construir_private_usuario_ui('usuario/comprar_planes', $data);
	}
}
