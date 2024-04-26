<?php defined('BASEPATH') or exit('No direct script access allowed');

class Error_404 extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$data['pagina_menu_error_404'] = true;
		$data['pagina_subtitulo'] = '404 Página no encontrada';

		$data['controlador'] = 'error_404';
		$data['regresar_a'] = 'inicio';
		$controlador_js = "error_404/index";

		$data['styles'] = array();

		$data['scripts'] = array();

		$this->output->set_status_header('404');

		$this->load->view('error_404', $data); //loading in custom error view
	}
}
