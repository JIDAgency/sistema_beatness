<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Codigos extends MY_Controller {

	public function __construct() {
        parent::__construct();

		$this->load->model('codigos_model');
		$this->load->model('codigos_canjeados_model');
		$this->load->model('planes_model');
    }

	public function index() {
        $data['pagina_titulo'] = 'Códigos';
		$data['pagina_menu_codigos'] = true;

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		
		$data['controlador'] = 'codigos';
		$data['regresar_a'] = 'inicio';
		$controlador_js = 'codigos/index';

		$data['styles'] = array(
		);

		$data['scripts'] = array(
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
		);

		$codigos_list = $this->codigos_model->get_codigos();
		$codigos_canejados_list = $this->codigos_canjeados_model->get_codigos_canjeados();

		$data['codigos_list'] = $codigos_list;
		$data['codigos_canejados_list'] = $codigos_canejados_list;

		$this->construir_private_site_ui('codigos/index', $data);
	}

	public function lista() {
        $data['pagina_titulo'] = 'Lista códigos';
		$data['pagina_menu_codigos'] = true;

		$data['controlador'] = 'codigos/lista';
		$data['regresar_a'] = 'inicio';
		$controlador_js = 'codigos/lista';

		$data['styles'] = array(
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
		);

		$this->construir_private_site_ui('codigos/lista', $data);
	}

    public function obtener_tabla_codigos_lista() {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $codigos_list = $this->codigos_model->get_codigos();

		$codigos_canejados_list = $this->codigos_canjeados_model->get_codigos_canjeados();

		$planes_list =$this->planes_model->obtener_planes_con_codigo();

        $data = [];

		$cont = 1;

        foreach ($codigos_list->result() as $key => $codigo_row) {

			$cont_2 = 0;

			foreach ($codigos_canejados_list->result() as $key => $codigo_canjeado_row) {
				if ($codigo_canjeado_row->codigo == $codigo_row->codigo) {
					$cont_2 = $cont_2 + 1;
				}
			}

			$plan_vicnulado = null;

			foreach ($planes_list->result() as $key => $plan_row) {
				if ($plan_row->codigo == $codigo_row->codigo) {
					$plan_vicnulado = $plan_row->nombre;
				}
			}

            $data[] = array(
                'id' => $cont,
                'codigo' => mb_strtoupper($codigo_row->codigo),
                'plan' => $plan_vicnulado,
                'tipo' => mb_strtoupper($codigo_row->tipo),
                'usados' => $cont_2,
                'lote' => $codigo_row->lote ? $codigo_row->lote : 'N/A',
                'nota' => $codigo_row->nota,

            );

			$cont++;
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $codigos_list->num_rows(),
            'recordsFiltered' => $codigos_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

	public function agregar() {
        $data['pagina_titulo'] = 'Agregar código';
		$data['pagina_menu_codigos'] = true;

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

		$data['controlador'] = 'codigos/agregar';
		$data['regresar_a'] = 'codigos';
		$controlador_js = 'codigos/agregar';

		$data['styles'] = array(
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
		);
		
		$this->form_validation->set_rules('codigo', 'código', 'trim|required|min_length[1]|max_length[20]|is_unique_for_codigos[codigos.codigo]');
		$this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
		$this->form_validation->set_rules('estatus', 'estatus', 'trim|required');

		$planes_list =$this->planes_model->obtener_planes_sin_codigo()->result();

		$data['planes_list'] = $planes_list;

		if ($this->form_validation->run() == false) {
			$this->construir_private_site_ui('codigos/agregar', $data);
        } else {

			$this->session->set_flashdata('codigo', $this->input->post('codigo'));
			$this->session->set_flashdata('tipo', $this->input->post('tipo'));
			$this->session->set_flashdata('estatus', $this->input->post('estatus'));

			$fecha_registro = date("Y-m-d H:i:s");
			$fecha = date("Y-m-d-H-i-s", strtotime($fecha_registro));

			$key = "codigos-".$fecha;
			$identificador = hash("crc32b", $key);

			$data_post = array(
				'identificador' => strval($identificador),
				'codigo' => trim(strval(str_replace(' ', '', mb_strtolower(preg_replace('/[^a-zA-Z0-9 \-\_]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $this->input->post('codigo'))))))),
				'tipo' => strval($this->input->post('tipo')),
				'estatus' => strval($this->input->post('estatus')),
				'fecha_registro' => strval($fecha_registro),
            );

			if (!$data_post) {
				$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (1)', $data['controlador']);
			}

			if (!$this->codigos_model->insert_codigo($data_post)) {
				$this->mensaje_del_sistema('MENSAJE_ERROR', 'No se pudo procesar la solicitud, por favor inténtalo más tarde. (2)', $data['controlador']);
			}

			$this->mensaje_del_sistema('MENSAJE_EXITO', '"'.trim(strval($this->input->post('codigo'))).'" se agregó con éxito.', $data['regresar_a']);

			$this->construir_private_site_ui('codigos/agregar', $data);
		}
	}

	public function agregar_nota() {
		$data['controlador'] = 'codigos/agregar_nota';
		$data['regresar_a'] = 'codigos';

		if ($this->input->post()) {
			$identificador = $this->input->post('identificador');
			$nota = $this->input->post('nota');
		}

		if (empty($identificador)) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (1)', $data['regresar_a']);
		}
		
		$codigo_row = $this->codigos_model->obtener_codigo_por_identificador($identificador)->row();

		if (!$codigo_row) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (2)', $data['regresar_a']);
		}

		$data_post = array(
			'nota' => $this->input->post('nota'),
		);

		if (!$this->codigos_model->update_codigo($codigo_row->id, $data_post)) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (3)', $data['regresar_a']);
		}

		$this->mensaje_del_sistema('MENSAJE_EXITO', 'Nota se eliminó con éxito.', $data['regresar_a']);

	}

	public function eliminar($identificador) {

		$data['controlador'] = 'codigos/eliminar';
		$data['regresar_a'] = 'codigos';
		
		if ($this->input->post()) {
			$identificador = $this->input->post('identificador');
		}

		if (empty($identificador)) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (1)', $data['regresar_a']);
		}
		
		$codigo_row = $this->codigos_model->obtener_codigo_por_identificador($identificador)->row();

		if (!$codigo_row) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (2)', $data['regresar_a']);
		}

		$planes_list = $this->planes_model->obtener_planes_por_codigo($codigo_row->codigo)->result();

		if ($planes_list) {
			foreach ($planes_list as $key => $value) {

				$data_post = array(
					'codigo' => null
				);

				if (!$this->planes_model->editar($value->id, $data_post)) {
					$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (3)', $data['regresar_a']);
				}

			}
		}

		if (!$this->codigos_model->eliminar_codigo_por_identificador($codigo_row->identificador)) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (4)', $data['regresar_a']);
		}

		$this->mensaje_del_sistema('MENSAJE_EXITO', '"'.mb_strtoupper($codigo_row->codigo).'"'.trim(strval($this->input->post('codigo'))).'" se eliminó con éxito.', $data['regresar_a']);
	}
	
}
