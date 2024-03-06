<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Asignaciones extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('asignaciones_model');
        $this->load->model('disciplinas_model');
    }

	public function index() {
        $data['pagina_titulo'] = 'Planes de clientes';
        $data['pagina_subtitulo'] = 'Listas de planes de clientes';
        $data['menu_asginaciones_activo'] = true;

		$data['controlador'] = 'asignaciones';
		$data['regresar_a'] = 'inicio';
		$controlador_js = "asignaciones/index";

		$data['styles'] = array(
			array('es_rel' => false, 'href' => base_url('app-assets/vendors/css/tables/datatable/datatables.min.css')),
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url('app-assets/vendors/js/tables/datatable/datatables.min.js')),
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
		);
		
		$this->construir_private_site_ui('asignaciones/index', $data);
	}

    public function obtener_tabla_index_planes_activos_por_cliente() {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order');

		$asignaciones_list = $this->asignaciones_model->obtener_tabla_index_planes_activos_por_cliente();

        $data = [];
        $flag_key = 0;
		$flag_comparar_correo = '';

        foreach ($asignaciones_list->result() as $key => $value) {

            if ($flag_comparar_correo != $value->usuarios_correo) {

                $data[$flag_key] = array(
                    'id' => $flag_key + 1,
                    'usuarios_correo' => $value->usuarios_correo.'<br>#'.$value->usuarios_id,
                    'usuarios_nombre' => ucwords($value->usuarios_nombre),
                    'planes' => $value->nombre.'&nbsp;#'.$value->id.'&nbsp;Clases:&nbsp;['.$value->clases_usadas.'/'.$value->clases_incluidas.']',
                    'estatus' => ucfirst($value->estatus),
                );

                $flag_key++;
            } else {
                $data[$flag_key-1]['planes'] .= '<br>'.$value->nombre.'&nbsp;#'.$value->id.'&nbsp; Clases: ['.$value->clases_usadas.'/'.$value->clases_incluidas.']';
            }

            $flag_comparar_correo = $value->usuarios_correo;            
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $asignaciones_list->num_rows(),
            "recordsFiltered" => $asignaciones_list->num_rows(),
            "data" => $data
        );

        echo json_encode($result);
        exit();
    }

    public function obtener_tabla_index_planes_por_caducar_por_cliente() {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order');

		$asignaciones_list = $this->asignaciones_model->obtener_tabla_index_planes_por_caducar_por_cliente();

        $data = [];
        $flag_key = 0;
		$flag_comparar_correo = '';

        foreach ($asignaciones_list->result() as $key => $value) {

            if ($flag_comparar_correo != $value->usuarios_correo) {

                $data[$flag_key] = array(
                    'id' => $flag_key + 1,
                    'usuarios_correo' => $value->usuarios_correo.'<br>#'.$value->usuarios_id,
                    'usuarios_nombre' => ucwords($value->usuarios_nombre),
                    'planes' => $value->nombre.'&nbsp;#'.$value->id.'&nbsp;Clases:&nbsp;['.$value->clases_usadas.'/'.$value->clases_incluidas.']',
                    'estatus' => ucfirst($value->estatus),
                    'fecha_activacion' => $value->fecha_activacion,
                    'vigencia_en_dias' => $value->vigencia_en_dias,
                    'asignaciones_fecha_finalizacion' => $value->asignaciones_fecha_finalizacion,
                );

                $flag_key++;
            } else {
                $data[$flag_key-1]['planes'] .= '<br>'.$value->nombre.'&nbsp;#'.$value->id.'&nbsp; Clases: ['.$value->clases_usadas.'/'.$value->clases_incluidas.']';
            }

            $flag_comparar_correo = $value->usuarios_correo;            
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $asignaciones_list->num_rows(),
            "recordsFiltered" => $asignaciones_list->num_rows(),
            "data" => $data
        );

        echo json_encode($result);
        exit();
    }

    public function obtener_tabla_index_planes_caducados_por_cliente() {
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order');

		$asignaciones_list = $this->asignaciones_model->obtener_tabla_index_planes_caducados_por_cliente();

        $data = [];
        $flag_key = 0;
		$flag_comparar_correo = '';

        foreach ($asignaciones_list->result() as $key => $value) {

            if ($flag_comparar_correo != $value->usuarios_correo) {

                $data[$flag_key] = array(
                    'id' => $flag_key + 1,
                    'usuarios_correo' => $value->usuarios_correo.'<br>#'.$value->usuarios_id,
                    'usuarios_nombre' => ucwords($value->usuarios_nombre),
                    'planes' => $value->nombre.'&nbsp;#'.$value->id.'&nbsp;Clases:&nbsp;['.$value->clases_usadas.'/'.$value->clases_incluidas.']',
                    'estatus' => ucfirst($value->estatus),
                );

                $flag_key++;
            } else {
                $data[$flag_key-1]['planes'] .= '<br>'.$value->nombre.'&nbsp;#'.$value->id.'&nbsp; Clases: ['.$value->clases_usadas.'/'.$value->clases_incluidas.']';
            }

            $flag_comparar_correo = $value->usuarios_correo;            
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $asignaciones_list->num_rows(),
            "recordsFiltered" => $asignaciones_list->num_rows(),
            "data" => $data
        );

        echo json_encode($result);
        exit();
    }

    public function control() {
        $data['pagina_titulo'] = 'Control';
        $data['pagina_subtitulo'] = 'Control de planes de clientes';
        $data['menu_asginaciones_activo'] = true;

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $data['controlador'] = 'asignaciones/control';
		$data['regresar_a'] = 'inicio';
		$controlador_js = "asignaciones/control";

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        $this->construir_private_site_ui('asignaciones/control', $data);
    }

    public function obtener_datos_tabla_control() {
        $asignaciones_list = $this->asignaciones_model->obtener_datos_tabla_control()->result();

        $disciplinas_list = $this->disciplinas_model->obtener_todas()->result();

        $respuesta = array();

        foreach ($asignaciones_list as $key => $asignacion_row) {

            $disciplinas_id = explode('|',$asignacion_row->disciplinas);

            $disciplinas_result = '';

            foreach ($disciplinas_list as $key => $disciplina_row) {

                if(in_array($disciplina_row->id, $disciplinas_id)){

                    $disciplinas_result = $disciplinas_result.'&bull;'.$disciplina_row->nombre.'<br>';
                }

            }

            $respuesta[] = array(
                'id' => $asignacion_row->id,
                'nombre' => $asignacion_row->nombre,
                'estatus' => ucfirst($asignacion_row->estatus),
                'cliente_nombre' => $asignacion_row->cliente_nombre,
                'cliente_correo' => $asignacion_row->cliente_correo.'&nbsp;#'.$asignacion_row->id,
                'clases_plan' => $asignacion_row->clases_usadas.' / '.$asignacion_row->clases_incluidas,
                'fecha_activacion' => date('d/m/Y', strtotime($asignacion_row->fecha_activacion)),
                'vigencia_en_dias' => $asignacion_row->vigencia_en_dias,
                'fecha_vigencia' => date('d/m/Y', strtotime('+ '.$asignacion_row->vigencia_en_dias.' days', strtotime($asignacion_row->fecha_activacion))),
                'categoria' => ucfirst($asignacion_row->categoria),
                'disciplinas_result' => $disciplinas_result,
                'clases_incluidas' => $asignacion_row->clases_incluidas,
                'clases_usadas' => $asignacion_row->clases_usadas,
                'plan_id' => $asignacion_row->plan_id,
                'usuario_id' => $asignacion_row->usuario_id,
            );
        }

        echo json_encode(array("data" => $respuesta));
    }

    public function suscripciones()
    {
		$data['menu_asginaciones_activo'] = true;
		$data['pagina_titulo'] = 'Suscripciones';

		$data['controlador'] = 'asignaciones/suscripciones';
		$data['regresar_a'] = 'asignaciones';
		$controlador_js = "asignaciones/suscripciones";

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

        $suscripciones_list = $this->asignaciones_model->get_todas_las_suscripciones()->result();
        $data['suscripciones_list'] = $suscripciones_list;

		$this->construir_private_site_ui('asignaciones/suscripciones' ,$data);
    }

    public function suscripcion_suspender($id = null)
    {
        $asignacion_row = $this->asignaciones_model->obtener_por_id($id)->row();

        if (!$asignacion_row) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo mas tarde. (1)');
            redirect(site_url('asignaciones/suscripciones'));
        }

        if ($asignacion_row->categoria != "suscripcion") {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo mas tarde. (2)');
            redirect(site_url('asignaciones/suscripciones'));
        }

        if ($asignacion_row->suscripcion_estatus_del_pago == "rechazado") {
            $data = array(
                'esta_activo' => intval(0),
                'estatus' => 'Cancelado',
            );
        } else {
            $data = array(
                'suscripcion_estatus_del_pago' => 'cancelado',
                'esta_activo' => intval(0),
                'estatus' => 'Cancelado',
            );
        }

        if (!$this->asignaciones_model->editar($id, $data)) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo mas tarde. (3)');
            redirect(site_url('asignaciones/suscripciones'));
        }

        redirect(site_url('asignaciones/suscripciones'));
    }

    public function suscripcion_activar($id = null)
    {
        $asignacion_row = $this->asignaciones_model->obtener_por_id($id)->row();

        if (!$asignacion_row) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo mas tarde. (1)');
            redirect(site_url('asignaciones/suscripciones'));
        }

        if ($asignacion_row->categoria != "suscripcion") {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo mas tarde. (2)');
            redirect(site_url('asignaciones/suscripciones'));
        }

        $data = array(
            'suscripcion_estatus_del_pago' => 'pagado',
            'esta_activo' => intval(1),
            'estatus' => 'Activo',
        );

        if (!$this->asignaciones_model->editar($id, $data)) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo mas tarde. (3)');
            redirect(site_url('asignaciones/suscripciones'));
        }

        redirect(site_url('asignaciones/suscripciones'));
    }
}
