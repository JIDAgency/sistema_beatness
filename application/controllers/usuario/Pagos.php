<?php defined('BASEPATH') or exit('No direct script access allowed');


class Pagos extends MY_Controller {

	public function __construct()
	{
        parent::__construct();

		$this->load->library('stripe_lib');
		
		$this->load->model('asignaciones_model');
		$this->load->model('planes_model');
		$this->load->model('ventas_model');
	}

	public function index() {
		$data['menu_usuario_pagos'] = true;
		$data['pagina_titulo'] = 'Pagos';
		
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		
		$data['controlador'] = 'usuario/pagos';
		$data['regresar_a'] = 'usuario/inicio';
        $controlador_js = "usuario/pagos/index";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
        );

        $data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/card/jquery.card.js'),
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

		$this->form_validation->set_rules('name', 'Nombre en la tarjeta', 'required');
		$this->form_validation->set_rules('card_num', 'Número en la tarjeta', 'required');
		$this->form_validation->set_rules('card_cvv', 'CVV / CVC', 'required');
		$this->form_validation->set_rules('exp_month', 'Mes de expiración', 'required');
		$this->form_validation->set_rules('exp_year', 'Año de expiración', 'required');
		$this->form_validation->set_rules('token', 'Error', 'required');

		$plan_row = $this->planes_model->obtener_por_id(1)->row();

		if (!$plan_row) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, este plan no se encuentra disponible.', 'usuario/shop');
        }

		$disciplinas_list = $this->planes_model->obtener_disciplinas_por_plan_id($plan_row->id)->result();

        $disciplinas_array = array();

        foreach ($disciplinas_list as $key => $disciplina_row) {
            array_push($disciplinas_array, $disciplina_row->disciplina_id);
        }

		$data['plan_row'] = $plan_row;

        if ($this->form_validation->run() == false) {
			$this->construir_private_usuario_ui('usuario/pagos/index', $data);
        } else {

			if (!$this->input->post()) {

				$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor intentelo mas tarde. (1)', 'usuario/shop');

			} else {

				if (!$this->asignaciones_model->crear(array(
					'usuario_id' => $this->session->userdata('id'),
					'plan_id' => $plan_row->id,
					'nombre' => $plan_row->nombre,
					'clases_incluidas' => $plan_row->clases_incluidas,
					'disciplinas' => implode('|', $disciplinas_array),
					'vigencia_en_dias' => $plan_row->vigencia_en_dias,
					'fecha_activacion' => date('Y-m-d H:i:s'),
					'esta_activo' => 1
				)))	{
					$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor intentelo mas tarde. (2)', 'usuario/shop');
				}

				$asignacion_row = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();


				if (!$this->ventas_model->crear(array(
					'concepto' => 'STRIPE TEST '.$plan_row->nombre,
					'usuario_id' => $this->session->userdata('id'),
					'asignacion_id' => $asignacion_row->id,
					'metodo_id' => 3,
					'costo' => $plan_row->costo,
					'cantidad' => 1,
					'total' => $plan_row->costo,
					'vendedor' => 'Compra desde la aplicación'
				))) {
					$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor intentelo mas tarde. (3)', 'usuario/shop');
				}
				
				if ($this->stripe_lib->cargo(
					bcmul($plan_row->costo, 100),
					$plan_row->nombre,
					$this->db->insert_id(),
					$plan_row->sku,
					$this->session->userdata('correo'),
					$this->input->post('token')
				)) {
					$this->mensaje_del_sistema('MENSAJE_EXITO', 'Compra exitosa', 'usuario/inicio');
				} else {
					$this->mensaje_del_sistema('MENSAJE_ERROR', 'Compra error', 'usuario/inicio');
				}
			}

			$this->construir_private_usuario_ui('usuario/pagos/index', $data);
		}
	}
}
