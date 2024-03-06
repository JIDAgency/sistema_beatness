<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bienvenido extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		$id = $this->session->userdata("id");
		
		$data['menu_usuario_bienvenido_activo'] = true;
        $data['pagina_titulo'] = 'Bienvenido';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		//$this->session->userdata("nombre");

        $this->load->view('usuario/bienvenido', $data);
	}

	public function seleccionarplan()
	{
		redirect('usuario/inicio');
	}
}
