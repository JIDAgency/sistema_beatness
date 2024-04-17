<?php defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('clases_model');
		$this->load->model('notificaciones_model');
		$this->load->model('usuarios_model');
	}

	public function index()
	{
		$data['pagina_titulo'] = 'Notificaciones';
		$data['pagina_menu_notificaciones'] = true;

		$data['controlador'] = 'notificaciones';
		$data['regresar_a'] = 'inicio';
		$controlador_js = 'notificaciones/index';

		$data['styles'] = array(
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$this->construir_private_site_ui('notificaciones/index', $data);
	}

	public function obtener_list_index()
	{
		$draw = intval($this->input->post('draw'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));

		$list = $this->notificaciones_model->get_notificaciones();

		foreach ($list->result() as $key => $value) {

			if ($value->segmento == 'general') {
				$opciones = '
					<a href="javascript:modal_notificaciones_enviar(\'' . $value->id . '\');">Enviar</a>
				';
			} elseif ($value->segmento == 'segmento_usuarios_sin_compras_hace_dos_meses') {
				$opciones = '
					<a href="javascript:modal_enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses(\'' . $value->id . '\');"><i class="fa fa-check-circle"></i>&nbsp;Enviar</a>
				';
			}

			$data[] = array(
				'id' => $value->id,
				'titulo' => $value->titulo,
				'mensaje' => $value->mensaje,
				'no_envios' => $value->no_envios,
				'estatus' => ucfirst($value->estatus),
				'fecha_registro' => date('Y-m-d H:i', strtotime($value->fecha_registro)),
				'fecha_actualizacion' => date('Y-m-d H:i', strtotime($value->fecha_actualizacion)),
				'opciones' => $opciones,
			);
		}

		$result = array(
			'draw' => $draw,
			'recordsTotal' => $list->num_rows(),
			'recordsFiltered' => $list->num_rows(),
			'data' => $data
		);

		echo json_encode($result);
		exit();
	}

	public function agregar()
	{
		$data['pagina_titulo'] = 'Agregar notificación';
		$data['pagina_menu_areas'] = true;

		$data['controlador'] = 'notificaciones/agregar';
		$data['regresar_a'] = 'notificaciones';
		$controlador_js = 'notificaciones/agregar';

		$data['styles'] = array(
		);

		$data['scripts'] = array(
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$this->form_validation->set_rules('titulo', 'Título', 'trim|required|min_length[1]|max_length[120]');
		$this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|min_length[1]|max_length[240]');

		if ($this->form_validation->run() == false) {
			$this->construir_private_site_ui('notificaciones/agregar', $data);
		} else {

			$this->session->set_flashdata('nombre', $this->input->post('nombre'));
			$this->session->set_flashdata('mensaje', $this->input->post('mensaje'));

			$data_post = array(
				'titulo' => trim(strval($this->input->post('titulo'))),
				'mensaje' => trim(strval($this->input->post('mensaje'))),
				'segmento' => trim('general'),
				'estatus' => trim(strval('activo')),
			);

			if (!$data_post) {
				$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (1)', $data['controlador']);
			}

			if (!$this->notificaciones_model->insert_notificacion($data_post)) {
				$this->mensaje_del_sistema('MENSAJE_ERROR', 'No se pudo procesar la solicitud, por favor inténtalo más tarde. (2)', $data['controlador']);
			}

			$this->mensaje_del_sistema('MENSAJE_EXITO', '"' . trim(ucfirst(strval(mb_strtolower($this->input->post('nombre'))))) . '" se agregó con éxito.', $data['regresar_a']);

			$this->construir_private_site_ui('notificaciones/agregar', $data);
		}
	}

	public function enviar()
	{

		if ($this->input->post()) {
			$id = $this->input->post('id');
			if ($this->input->post('segmento') == 'Active Users') {
				$mensaje_confirmacion = $this->input->post('segmento') . ' y Engaged Users';
				$segmento = array($this->input->post('segmento'), 'Engaged Users');
			} else {
				$mensaje_confirmacion = $this->input->post('segmento');
				$segmento = array($this->input->post('segmento'));
			}
		} else {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo más tarde.', 'notificaciones');
		}

		$notificacion_row = $this->notificaciones_model->get_notificacion_por_id($id)->row();

		if (!$notificacion_row) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo más tarde.', 'notificaciones');
		}

		//$to = array('22', '271', '40', '883');
		//$to = array('22');

		$title = $notificacion_row->titulo;
		$message = $notificacion_row->mensaje;

		$img = '';

		$app_id = '66454c58-6e0b-4489-ba82-524c05331a3b';
		$app_key = 'YmNkMzhkMjYtM2U5NS00N2IyLThlNWEtYjg2NTE5YWFmNDg4';

		$msg = $message;

		$content = array(
			"es" => $msg,
			"en" => $msg
		);

		$headings = array(
			"es" => $title,
			"en" => $title
		);

		if ($img == '') {

			$fields = array(
				'app_id' => $app_id,
				"headings" => $headings,
				//'include_external_user_ids' => $to,
				'included_segments' => $segmento,
				'contents' => $content,
				'large_icon' => "",
				'content_available' => true,
			);

		} else {

			$ios_img = array(
				"id1" => $img
			);

			$fields = array(
				'app_id' => $app_id,
				"headings" => $headings,
				//'include_external_user_ids' => $to,
				'included_segments' => $segmento,
				'contents' => $content,
				"big_picture" => $img,
				'large_icon' => "",
				'content_available' => true,
				"ios_attachments" => $ios_img
			);

		}

		$headers = array(
			'Authorization: Basic ' . $app_key . '',
			'accept: application/json',
			'content-type: application/json'
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields, JSON_UNESCAPED_UNICODE));

		$result = curl_exec($ch);

		curl_close($ch);

		//return $result;

		$this->notificaciones_model->update_notificacion($id, array('no_envios' => $notificacion_row->no_envios + 1, 'fecha_actualizacion' => date('Y-m-d H:i:s')));

		$this->mensaje_del_sistema('MENSAJE_EXITO', 'Notificación enviada con éxito: ' . $title, 'notificaciones');
	}

	public function segmentos()
	{
		$data['pagina_titulo'] = 'Segmentos';
		$data['pagina_menu_notificaciones'] = true;

		$data['controlador'] = 'notificaciones/segmentos';
		$data['regresar_a'] = 'inicio';
		$controlador_js = 'notificaciones/segmentos';

		$data['styles'] = array(
		);

		$data['scripts'] = array(
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$this->construir_private_site_ui('notificaciones/segmentos', $data);
	}

	public function segmento_usuarios_seleccionados_julio_2023()
	{
		$data['pagina_titulo'] = 'Segmento de usuarios seleccionados en Julio 2023';
		$data['pagina_subtitulo'] = 'Enviar una notificación al segmento de usuarios';
		$data['pagina_menu_notificaciones'] = true;

		$data['controlador'] = 'notificaciones/segmento_usuarios_seleccionados_julio_2023/';
		$data['regresar_a'] = 'notificaciones/segmentos/';
		$controlador_js = 'notificaciones/segmento_usuarios_seleccionados_julio_2023';

		$data['styles'] = array(
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$this->form_validation->set_rules('fecha_notificacion', 'Fecha de notificación', 'trim');

		$usuarios_seleccionados_list = array('934', '347', '933', '931', '411', '906', '562', '719', '717', '235', '880', '885', '169', '505', '354', '861', '195', '91', '989', '862', '994', '829', '990', '856', '282', '975', '973', '156');

		$usuarios_list = $this->usuarios_model->obtener_usuarios_seleccionados($usuarios_seleccionados_list)->result();

		$data['usuarios_list'] = $usuarios_list;

		if ($this->form_validation->run() == false) {
			$this->construir_private_site_ui('notificaciones/segmento_usuarios_seleccionados_julio_2023', $data);
		} else {

			array_push($usuarios_seleccionados_list, '22');

			$to = $usuarios_seleccionados_list;

			$title = $this->input->post('titulo');
			$message = $this->input->post('mensaje');

			$img = '';

			$app_id = '66454c58-6e0b-4489-ba82-524c05331a3b';
			$app_key = 'YmNkMzhkMjYtM2U5NS00N2IyLThlNWEtYjg2NTE5YWFmNDg4';

			$msg = $message;

			$content = array(
				"es" => $msg,
				"en" => $msg
			);

			$headings = array(
				"es" => $title,
				"en" => $title
			);

			if ($img == '') {

				$fields = array(
					'app_id' => $app_id,
					"headings" => $headings,
					'include_external_user_ids' => $to,
					'contents' => $content,
					'large_icon' => "",
					'content_available' => true,
				);

			} else {

				$ios_img = array(
					"id1" => $img
				);

				$fields = array(
					'app_id' => $app_id,
					"headings" => $headings,
					'include_external_user_ids' => $to,
					'contents' => $content,
					"big_picture" => $img,
					'large_icon' => "",
					'content_available' => true,
					"ios_attachments" => $ios_img
				);

			}

			$headers = array(
				'Authorization: Basic ' . $app_key . '',
				'accept: application/json',
				'content-type: application/json'
			);

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields, JSON_UNESCAPED_UNICODE));

			$result = curl_exec($ch);

			curl_close($ch);

			//return $result;


			$this->mensaje_del_sistema('MENSAJE_EXITO', 'Notificación enviada con éxito: ' . $title, $data['controlador']);

			$this->construir_private_site_ui('notificaciones/segmento_usuarios_seleccionados_julio_2023', $data);
		}
	}

	public function segmento_usuarios_sin_compras_hace_dos_meses()
	{
		$data['pagina_titulo'] = 'Segmento de usuarios sin compras hace dos meses';
		$data['pagina_menu_notificaciones'] = true;

		$data['controlador'] = 'notificaciones/segmento_usuarios_sin_compras_hace_dos_meses';
		$data['regresar_a'] = 'inicio';
		$controlador_js = 'notificaciones/segmento_usuarios_sin_compras_hace_dos_meses';

		$data['styles'] = array(
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$this->construir_private_site_ui('notificaciones/segmento_usuarios_sin_compras_hace_dos_meses', $data);
	}

	public function obtener_lista_segmento_usuarios_sin_compras_hace_dos_meses()
	{
		$draw = intval($this->input->post('draw'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));

		$list_usuarios_que_si_han_comprado_los_ultimos_dos_meses = $this->notificaciones_model->obtener_usuarios_que_si_han_comprado_los_ultimos_dos_meses();

		$array_usuarios_que_si_han_comprado_los_ultimos_dos_meses = array();
		foreach ($list_usuarios_que_si_han_comprado_los_ultimos_dos_meses->result() as $key => $value) {
			array_push($array_usuarios_que_si_han_comprado_los_ultimos_dos_meses, $value->id);
		}

		$lista_usuarios_que_no_han_comprado_los_ultimos_dos_meses = $this->notificaciones_model->obtener_usuarios_que_no_han_comprado_los_ultimos_dos_meses($array_usuarios_que_si_han_comprado_los_ultimos_dos_meses);

		foreach ($lista_usuarios_que_no_han_comprado_los_ultimos_dos_meses->result() as $key => $value) {
			$data[] = array(
				'id' => $value->id,
				'correo' => $value->correo,
				'nombre_completo' => $value->nombre_completo . ' ' . $value->apellido_paterno . ' ' . $value->apellido_materno,
				'asignaciones_nombre' => $value->asignaciones_nombre,
				'asignaciones_fecha_activacion' => (!empty($value->asignaciones_fecha_activacion)) ? strval(date('Y-m-d', strtotime($value->asignaciones_fecha_activacion))) : '',

			);
		}

		$result = array(
			'draw' => $draw,
			'recordsTotal' => $lista_usuarios_que_no_han_comprado_los_ultimos_dos_meses->num_rows(),
			'recordsFiltered' => $lista_usuarios_que_no_han_comprado_los_ultimos_dos_meses->num_rows(),
			'data' => $data
		);

		echo json_encode($result);
		exit();
	}

	public function agregar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses()
	{
		$data['pagina_titulo'] = 'Agregar notificación para el segmento de usuarios sin compras hace dos meses';
		$data['pagina_menu_areas'] = true;

		$data['controlador'] = 'notificaciones/agregar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses';
		$data['regresar_a'] = 'notificaciones';
		$controlador_js = 'notificaciones/agregar';

		$data['styles'] = array(
		);

		$data['scripts'] = array(
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$this->form_validation->set_rules('titulo', 'Título', 'trim|required|min_length[1]|max_length[120]');
		$this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|min_length[1]|max_length[240]');

		if ($this->form_validation->run() == false) {
			$this->construir_private_site_ui('notificaciones/agregar', $data);
		} else {

			$this->session->set_flashdata('nombre', $this->input->post('nombre'));
			$this->session->set_flashdata('mensaje', $this->input->post('mensaje'));

			$data_post = array(
				'titulo' => trim(strval($this->input->post('titulo'))),
				'mensaje' => trim(strval($this->input->post('mensaje'))),
				'segmento' => trim('segmento_usuarios_sin_compras_hace_dos_meses'),
				'estatus' => trim(strval('activo')),
			);

			if (!$data_post) {
				$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor inténtalo más tarde. (1)', $data['controlador']);
			}

			if (!$this->notificaciones_model->insert_notificacion($data_post)) {
				$this->mensaje_del_sistema('MENSAJE_ERROR', 'No se pudo procesar la solicitud, por favor inténtalo más tarde. (2)', $data['controlador']);
			}

			$this->mensaje_del_sistema('MENSAJE_EXITO', '"' . trim(ucfirst(strval(mb_strtolower($this->input->post('nombre'))))) . '" se agregó con éxito.', $data['regresar_a']);

			$this->construir_private_site_ui('notificaciones/agregar', $data);
		}
	}

	public function enviar_notificacion_segmento_usuarios_sin_compras_hace_dos_meses()
	{

		if ($this->input->post()) {
			$id = $this->input->post('id_2');
		} else {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo más tarde.', 'notificaciones');
		}

		$notificacion_row = $this->notificaciones_model->get_notificacion_por_id($id)->row();

		if (!$notificacion_row) {
			$this->mensaje_del_sistema('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor intentelo más tarde.', 'notificaciones');
		}

		//$to = array('17');

		$title = $notificacion_row->titulo;
		$message = $notificacion_row->mensaje;

		$img = '';

		$app_id = '66454c58-6e0b-4489-ba82-524c05331a3b';
		$app_key = 'YmNkMzhkMjYtM2U5NS00N2IyLThlNWEtYjg2NTE5YWFmNDg4';

		$msg = $message;

		$content = array(
			"es" => $msg,
			"en" => $msg
		);

		$headings = array(
			"es" => $title,
			"en" => $title
		);

		$list_usuarios_que_si_han_comprado_los_ultimos_dos_meses = $this->notificaciones_model->obtener_usuarios_que_si_han_comprado_los_ultimos_dos_meses();

		$array_usuarios_que_si_han_comprado_los_ultimos_dos_meses = array();
		foreach ($list_usuarios_que_si_han_comprado_los_ultimos_dos_meses->result() as $key => $value) {
			array_push($array_usuarios_que_si_han_comprado_los_ultimos_dos_meses, $value->id);
		}

		$lista_usuarios_que_no_han_comprado_los_ultimos_dos_meses = $this->notificaciones_model->obtener_usuarios_que_no_han_comprado_los_ultimos_dos_meses($array_usuarios_que_si_han_comprado_los_ultimos_dos_meses);

		$cont = 1;
		$array_usuarios_que_no_han_comprado_los_ultimos_dos_meses = array();
		foreach ($lista_usuarios_que_no_han_comprado_los_ultimos_dos_meses->result() as $key => $value) {
			array_push($array_usuarios_que_no_han_comprado_los_ultimos_dos_meses, $value->id);
		}

		$to = array('17');

		$title = $notificacion_row->titulo;
		$message = $notificacion_row->mensaje;

		$img = '';

		$app_id = '66454c58-6e0b-4489-ba82-524c05331a3b';
		$app_key = 'YmNkMzhkMjYtM2U5NS00N2IyLThlNWEtYjg2NTE5YWFmNDg4';

		$msg = $message;

		$content = array(
			"es" => $msg,
			"en" => $msg
		);

		$headings = array(
			"es" => $title,
			"en" => $title
		);

		if ($img == '') {

			$fields = array(
				'app_id' => $app_id,
				"headings" => $headings,
				'include_external_user_ids' => $to,
				'contents' => $content,
				'large_icon' => "",
				'content_available' => true,
			);

		} else {

			$ios_img = array(
				"id1" => $img
			);

			$fields = array(
				'app_id' => $app_id,
				"headings" => $headings,
				'include_external_user_ids' => $to,
				'contents' => $content,
				"big_picture" => $img,
				'large_icon' => "",
				'content_available' => true,
				"ios_attachments" => $ios_img
			);

		}

		$headers = array(
			'Authorization: Basic ' . $app_key . '',
			'accept: application/json',
			'content-type: application/json'
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		$result = curl_exec($ch);

		curl_close($ch);


		$this->notificaciones_model->update_notificacion($id, array('no_envios' => $notificacion_row->no_envios + 1, 'fecha_actualizacion' => date('Y-m-d H:i:s')));

		$this->mensaje_del_sistema('MENSAJE_EXITO', 'Notificación enviada con éxito: ' . $title, 'notificaciones');
	}

	public function notificacion_clase($id)
	{

		if ($this->input->post()) {
			$id = $this->input->post('id');
		}

		$data['pagina_titulo'] = 'Notificacar a clase';
		$data['pagina_menu_notificaciones'] = true;

		$data['controlador'] = 'notificaciones/notificacion_clase';
		$data['regresar_a'] = 'clases';
		$controlador_js = 'notificaciones/notificacion_clase';

		$this->form_validation->set_rules('titulo', 'Título', 'trim|required|min_length[1]|max_length[120]');
		$this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|required|min_length[1]|max_length[240]');

		$data['styles'] = array(
		);

		$data['scripts'] = array(
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$clase_row = $this->clases_model->obtener_por_id($id)->row();

		$cupos_list = json_decode($clase_row->cupo_lugares);

		$usuarios_ids = array();

		foreach ($cupos_list as $value) {
			if (!empty($value->nombre_usuario)) {
				$usuarios_ids[] = $value->nombre_usuario;
			}
		}

		$data['usuarios'] = $this->usuarios_model->obtener_todos();

		$data['clase_row'] = $clase_row;
		$data['usuarios_ids'] = $usuarios_ids;

		if ($this->form_validation->run() == false) {

			$this->construir_private_site_ui('notificaciones/notificacion_clase', $data);

		} else {

			$to = $usuarios_ids;

			$title = $this->input->post('titulo');
			$message = $this->input->post('mensaje');

			$img = '';

			$app_id = '66454c58-6e0b-4489-ba82-524c05331a3b';
			$app_key = 'YmNkMzhkMjYtM2U5NS00N2IyLThlNWEtYjg2NTE5YWFmNDg4';

			$msg = $message;

			$content = array(
				"es" => $msg,
				"en" => $msg
			);

			$headings = array(
				"es" => $title,
				"en" => $title
			);

			if ($img == '') {

				$fields = array(
					'app_id' => $app_id,
					"headings" => $headings,
					'include_external_user_ids' => $to,
					'contents' => $content,
					'large_icon' => "",
					'content_available' => true,
				);

			} else {

				$ios_img = array(
					"id1" => $img
				);

				$fields = array(
					'app_id' => $app_id,
					"headings" => $headings,
					'include_external_user_ids' => $to,
					'contents' => $content,
					"big_picture" => $img,
					'large_icon' => "",
					'content_available' => true,
					"ios_attachments" => $ios_img
				);

			}

			$headers = array(
				'Authorization: Basic ' . $app_key . '',
				'accept: application/json',
				'content-type: application/json'
			);

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

			$result = curl_exec($ch);

			curl_close($ch);

			$this->mensaje_del_sistema('MENSAJE_EXITO', 'Notificación enviada con exito', $data['regresar_a']);

			$this->construir_private_site_ui('notificaciones/notificacion_clase', $data);

		}
	}

}
