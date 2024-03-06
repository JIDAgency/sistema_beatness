<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleccionarplan extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('planes_model');

	}

	public function index()
	{
		$data['planes'] = $this->planes_model->obtener_todos();
		
		$data['menu_usuario_seleccionarplan_activo'] = true;
        $data['pagina_titulo'] = 'Seleccionar Plan';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		//$this->session->userdata("nombre");

        $this->load->view('usuario/seleccionarplan', $data);
    }
    
    public function comprar($id = null)
	{
        // Inicializar vista, scripts y catálogos
        $data['menu_planes_activo'] = true;
		$data['pagina_titulo'] = 'Editar plan';
		
		// Verificar que el plan a comprar exista, obtener sus datos y pasarlos a la vista
		$plan_a_comprar = $this->planes_model->obtener_por_id($id)->row();

		if (!$plan_a_comprar) {
			$this->session->set_flashdata('MENSAJE_INFO', 'El plan que intenta comprar no existe.');
			redirect('/usuario/index');
		}

		$data['plan_a_comprar'] = $plan_a_comprar;

            $this->load->view('usuario/openpay', $data);
	}

}
