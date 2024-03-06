<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suscripciones extends MY_Controller {

	public function __construct()
	{
        parent::__construct();

        $this->config->load('b3studio', true);

        $this->load->model('asignaciones_model');
    }

    public function index()
    {
        $data['pagina_menu_inicio'] = true;
		$data['pagina_titulo'] = 'suscripciones';

		//revisar
		$data['controlador'] = 'suscripciones/index';
		$data['regresar_a'] = 'inicio';
		$controlador_js = "suscripciones/index";

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		
		$data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
		);
		$data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );
        
        $this->construir_private_site_ui('suscripciones/index', $data);
    }

	public function get_datos_tabla_suscripciones()
	{
		//$this->load->library('openpagos');

		$suscripciones_list = $this->asignaciones_model->get_suscripciones()->result();
		
		$data_suscripciones = array();

		foreach ($suscripciones_list as $suscripcion_row) {
			/*
			$resultado_openpay = $this->openpagos->obtener_una_suscripcion_en_openpay($suscripcion_row->openpay_cliente_id, $suscripcion_row->openpay_suscripcion_id);

			$data = array(
                'openpay_estatus' => $resultado_openpay->status,
            );

			$this->asignaciones_model->editar($suscripcion_row->id, $data);
			*/
			$opciones = '
				<br>
				<a href="'.site_url("suscripciones/ver/".$suscripcion_row->id."").'" target="_blank" rel="noopener noreferrer">Ver</a>
			';

			$data_suscripciones[] = array(
				'id' => $suscripcion_row->id,
				'cliente_nombre' => $suscripcion_row->cliente_nombre,
				//"categoria" => ($suscripcion_row->categoria == 'plan' ? "FrontDesk" : "OpenPay"),
				"categoria" => $suscripcion_row->openpay_estatus,
				'fecha_activacion' => date("d/m/Y", strtotime($suscripcion_row->fecha_activacion)),
				"suscripcion_fecha_de_actualizacion" => (strtotime($suscripcion_row->suscripcion_fecha_de_actualizacion) == false ? "" : date("d/m/Y", strtotime($suscripcion_row->suscripcion_fecha_de_actualizacion))),
				'suscripcion_estatus_del_pago' => ucfirst($suscripcion_row->suscripcion_estatus_del_pago),
				'openpay_suscripcion_id' => $suscripcion_row->openpay_suscripcion_id,
				'opciones' => $opciones,
			);

		}

		echo json_encode(array("data" => $data_suscripciones));
	}

	public function ver($id = null)
	{
		if ($this->input->post()) {
			$id = $this->input->post("id");
		}

        $data['pagina_menu_inicio'] = true;
		$data['pagina_titulo'] = 'suscripciones';

		//revisar
		$data['controlador'] = 'suscripciones/ver';
		$data['regresar_a'] = 'suscripciones';
		$controlador_js = "suscripciones/ver";

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

		$this->load->library('openpagos');

		$data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
		);
		$data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

		$suscripcion_row = $this->asignaciones_model->get_suscripciones_por_id($id)->row();

		$resultado_openpay = $this->openpagos->obtener_una_suscripcion_en_openpay($suscripcion_row->openpay_cliente_id, $suscripcion_row->openpay_suscripcion_id);


        $data["suscripcion_row"] = $suscripcion_row;
        $data["resultado_openpay"] = $resultado_openpay;

        $this->construir_private_site_ui('suscripciones/ver', $data);
	}

	public function crear($id = null)
	{
		if ($this->input->post()) {
			$id = $this->input->post("id");
		}

		//$this->load->library('openpagos');

		//$suscripcion_row = $this->asignaciones_model->get_suscripciones_por_id($id)->row();

		//$this->openpagos->crear_una_nueva_suscripcion_mensual_sin_prueba_en_openpay($suscripcion_row->openpay_cliente_id, $suscripcion_row->openpay_tarjeta_id, "pf5hgwbgnsdvljfq5zaa");

		redirect("suscripciones/ver/".$suscripcion_row->id."");
	}

	public function cancelar($id = null)
	{
		if ($this->input->post()) {
			$id = $this->input->post("id");
		}

		$this->load->library('openpagos');

		$suscripcion_row = $this->asignaciones_model->get_suscripciones_por_id($id)->row();

		$this->openpagos->cancelar_suscripcion_en_openpay($suscripcion_row->openpay_cliente_id, $suscripcion_row->openpay_suscripcion_id);

		redirect("suscripciones/ver/".$suscripcion_row->id."");
	}
}
