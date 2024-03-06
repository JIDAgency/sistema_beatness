<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('disciplinas_model');
	}

	public function index()
	{
		$data['controlador'] = 'usuario/inicio';
		$data['regresar_a'] = 'usuario/inicio';

		$data['menu_usuario_inicio_activo'] = true;
		$data['pagina_titulo'] = 'Inicio';
		
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

		$controlador_js = "usuario/inicio/index";

		$data['styles'] = array(
        );
        $data['scripts'] = array(
		);

		$disciplinas_online_list = $this->disciplinas_model->get_lista_de_disciplinas_online()->result();

        $data['disciplinas_online_list'] = $disciplinas_online_list;

        $this->construir_private_usuario_ui('usuario/inicio/index', $data);
	}

}
