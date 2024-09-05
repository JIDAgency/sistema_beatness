<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reportes extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('clases_model');
		$this->load->model('reportes_model');
	}

	public function index()
	{
		$data['pagina_titulo'] = 'Reportes';
		$data['pagina_subtitulo'] = 'Reportes';
		$data['pagina_menu_reportes'] = true;

		$data['controlador'] = 'reportes';
		$data['regresar_a'] = 'inicio';
		$controlador_js = "reportes/index";

		// Cargar estilos y scripts
		$data['styles'] = array();
		$data['scripts'] = array(
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js'),
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/jquery.knob.min.js'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/cards/card-statistics.js'),
			array('es_rel' => true, 'src' => 'reportes/reservaciones.js'),
		);

		$data['reporte_1'] = $this->reportes_model->reporte_1();
		$data['reporte_2'] = $this->reportes_model->reporte_2();
		$data['reporte_3'] = $this->reportes_model->reporte_3();
		$data['reporte_4'] = $this->reportes_model->reporte_4();
		$data['reporte_5'] = $this->reportes_model->reporte_5();
		$data['reporte_6'] = $this->reportes_model->reporte_6();

		$obtener_usuarios_que_compraron_primera_clase = $this->reportes_model->obtener_usuarios_que_compraron_primera_clase();
		$obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan = $this->reportes_model->obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan();

		$data["obtener_usuarios_que_compraron_primera_clase"] = $obtener_usuarios_que_compraron_primera_clase;
		$data["obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan"] = $obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan;


		$obtener_usuarios_que_compraron_primera_clase_puebla = $this->reportes_model->obtener_usuarios_que_compraron_primera_clase_puebla();
		$obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_puebla = $this->reportes_model->obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_puebla();

		$data["obtener_usuarios_que_compraron_primera_clase_puebla"] = $obtener_usuarios_que_compraron_primera_clase_puebla;
		$data["obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_puebla"] = $obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_puebla;

		$obtener_usuarios_que_compraron_primera_clase_polanco = $this->reportes_model->obtener_usuarios_que_compraron_primera_clase_polanco();
		$obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_polanco = $this->reportes_model->obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_polanco();

		$data["obtener_usuarios_que_compraron_primera_clase_polanco"] = $obtener_usuarios_que_compraron_primera_clase_polanco;
		$data["obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_polanco"] = $obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_polanco;

		// Planes
		$data["reporte_planes"] = $this->reportes_model->obtene_reporte_planes();
		$data["reporte_planes_por_anho"] = $this->reportes_model->obtene_reporte_planes_por_anho();

		// Reservaciones 
		$data["reservaciones_numero_total"] = $this->reportes_model->get_reservaciones_numero_total();
		$data["reservaciones_numero_terminadas"] = $this->reportes_model->get_reservaciones_numero_terminadas();
		$data["reservaciones_numero_activas"] = $this->reportes_model->get_reservaciones_numero_activas();
		$data["reservaciones_numero_canceladas"] = $this->reportes_model->get_reservaciones_numero_canceladas();

		// Ventas 
		$data["ventas_numero_total"] = $this->reportes_model->get_ventas_numero_total();
		$data["ventas_numero_vendidas"] = $this->reportes_model->get_ventas_numero_vendidas();
		$data["ventas_numero_canceladas"] = $this->reportes_model->get_ventas_numero_canceladas();
		$data["ventas_numero_reembolsos"] = $this->reportes_model->get_ventas_numero_reembolsos();
		$data["ventas_numero_pruebas"] = $this->reportes_model->get_ventas_numero_pruebas();

		$this->construir_private_site_ui('reportes/index', $data);
	}

	// Vista de graficas de reservaciones incio
	public function reservaciones()
	{
		$data['pagina_titulo'] = 'Reservaciones';
		$data['pagina_subtitulo'] = 'Reservaciones';
		$data['pagina_menu_reportes'] = true;

		$data['controlador'] = 'reportes/reservaciones';
		$data['regresar_a'] = 'reportes';
		$controlador_js = "reportes/reservaciones";

		// Cargar estilos y scripts
		$data['styles'] = array();
		$data['scripts'] = array(
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js'),
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/jquery.knob.min.js'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/cards/card-statistics.js'),
			array('es_rel' => true, 'src' => 'reportes/reservaciones.js'),
		);

		// Planes
		$data["reporte_planes"] = $this->reportes_model->obtene_reporte_planes();
		$data["reporte_planes_por_anho"] = $this->reportes_model->obtene_reporte_planes_por_anho();

		// Reservaciones 
		$data["reservaciones_numero_total"] = $this->reportes_model->get_reservaciones_numero_total();
		$data["reservaciones_numero_terminadas"] = $this->reportes_model->get_reservaciones_numero_terminadas();
		$data["reservaciones_numero_activas"] = $this->reportes_model->get_reservaciones_numero_activas();
		$data["reservaciones_numero_canceladas"] = $this->reportes_model->get_reservaciones_numero_canceladas();

		// Ventas 
		$data["ventas_numero_total"] = $this->reportes_model->get_ventas_numero_total();
		$data["ventas_numero_vendidas"] = $this->reportes_model->get_ventas_numero_vendidas();
		$data["ventas_numero_canceladas"] = $this->reportes_model->get_ventas_numero_canceladas();
		$data["ventas_numero_reembolsos"] = $this->reportes_model->get_ventas_numero_reembolsos();
		$data["ventas_numero_pruebas"] = $this->reportes_model->get_ventas_numero_pruebas();

		$this->construir_private_site_ui('reportes/reservaciones', $data);
	}
	public function grafica_numero_de_reservaciones_por_mes()
	{
		$start = (new DateTime('2024-03-01'))->modify('first day of this month');
		$end = (new DateTime(date('Y-m-d')))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period = new DatePeriod($start, $interval, $end);
		$period = array_reverse(iterator_to_array($period));

		$etiquetas = array();
		$datos = array();

		// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor

		foreach ($period as $fecha_row) {
			array_push($etiquetas, strftime("%B %Y", strtotime($fecha_row->format("Y-m"))));
			array_push($datos, $this->reportes_model->get_reservaciones_numero_del_mes($fecha_row->format("Y-m")));
		}

		// Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
		$respuesta = [
			"etiquetas" => $etiquetas,
			"datos" => $datos,
		];

		echo json_encode($respuesta);
	}
	// Vista de graficas de reservaciones fin

	// Vista de grafica de ventas inicio
	public function reporte_ventas()
	{
		$data['pagina_titulo'] = 'Ventas';
		$data['pagina_subtitulo'] = 'Ventas';
		$data['pagina_menu_reportes'] = true;

		$data['controlador'] = 'reportes/reporte_ventas';
		$data['regresar_a'] = 'reportes';
		$controlador_js = "reportes/reporte_ventas";

		// Cargar estilos y scripts
		$data['styles'] = array();
		$data['scripts'] = array(
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js'),
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/jquery.knob.min.js'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/cards/card-statistics.js'),
			array('es_rel' => true, 'src' => 'reportes/reporte_ventas.js'),
		);

		// Planes
		$data["reporte_planes"] = $this->reportes_model->obtene_reporte_planes();
		$data["reporte_planes_por_anho"] = $this->reportes_model->obtene_reporte_planes_por_anho();

		// Reservaciones 
		$data["reservaciones_numero_total"] = $this->reportes_model->get_reservaciones_numero_total();
		$data["reservaciones_numero_terminadas"] = $this->reportes_model->get_reservaciones_numero_terminadas();
		$data["reservaciones_numero_activas"] = $this->reportes_model->get_reservaciones_numero_activas();
		$data["reservaciones_numero_canceladas"] = $this->reportes_model->get_reservaciones_numero_canceladas();

		// Ventas 
		$data["ventas_numero_total"] = $this->reportes_model->get_ventas_numero_total();
		$data["ventas_numero_vendidas"] = $this->reportes_model->get_ventas_numero_vendidas();
		$data["ventas_numero_canceladas"] = $this->reportes_model->get_ventas_numero_canceladas();
		$data["ventas_numero_reembolsos"] = $this->reportes_model->get_ventas_numero_reembolsos();
		$data["ventas_numero_pruebas"] = $this->reportes_model->get_ventas_numero_pruebas();

		$this->construir_private_site_ui('reportes/reporte_ventas', $data);
	}
	public function grafica_numero_de_ventas_por_mes()
	{
		$start = (new DateTime('2024-01-01'))->modify('first day of this month');
		$end = (new DateTime(date('Y-m-d')))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period = new DatePeriod($start, $interval, $end);
		$period = array_reverse(iterator_to_array($period));

		$etiquetas = array();
		$datos = array();

		// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor

		foreach ($period as $fecha_row) {
			array_push($etiquetas, strftime("%B %Y", strtotime($fecha_row->format("Y-m"))));
			array_push($datos, $this->reportes_model->get_ventas_numero_del_mes($fecha_row->format("Y-m")));
		}

		// Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
		$respuesta = [
			"etiquetas" => $etiquetas,
			"datos" => $datos,
		];

		echo json_encode($respuesta);
	}
	// Vista de grafica de ventas fin

	// Vista de grafica de vendedores inicio
	public function vendedores()
	{
		$data['pagina_titulo'] = 'Vendedores';
		$data['pagina_subtitulo'] = 'Vendedores';
		$data['pagina_menu_reportes'] = true;

		$data['controlador'] = 'reportes/vendedores';
		$data['regresar_a'] = 'reportes';
		$controlador_js = "reportes/vendedores";

		// Cargar estilos y scripts
		$data['styles'] = array();
		$data['scripts'] = array(
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js'),
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/jquery.knob.min.js'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/cards/card-statistics.js'),
			array('es_rel' => true, 'src' => 'reportes/vendedores.js'),
		);

		// Planes
		$data["reporte_planes"] = $this->reportes_model->obtene_reporte_planes();
		$data["reporte_planes_por_anho"] = $this->reportes_model->obtene_reporte_planes_por_anho();

		// Reservaciones 
		$data["reservaciones_numero_total"] = $this->reportes_model->get_reservaciones_numero_total();
		$data["reservaciones_numero_terminadas"] = $this->reportes_model->get_reservaciones_numero_terminadas();
		$data["reservaciones_numero_activas"] = $this->reportes_model->get_reservaciones_numero_activas();
		$data["reservaciones_numero_canceladas"] = $this->reportes_model->get_reservaciones_numero_canceladas();

		// Ventas 
		$data["ventas_numero_total"] = $this->reportes_model->get_ventas_numero_total();
		$data["ventas_numero_vendidas"] = $this->reportes_model->get_ventas_numero_vendidas();
		$data["ventas_numero_canceladas"] = $this->reportes_model->get_ventas_numero_canceladas();
		$data["ventas_numero_reembolsos"] = $this->reportes_model->get_ventas_numero_reembolsos();
		$data["ventas_numero_pruebas"] = $this->reportes_model->get_ventas_numero_pruebas();

		$this->construir_private_site_ui('reportes/vendedores', $data);
	}
	public function grafica_numero_de_ventas_por_vendedor_por_mes()
	{
		$start = (new DateTime('2024-01-01'))->modify('first day of this month');
		$end = (new DateTime(date('Y-m-d')))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period = new DatePeriod($start, $interval, $end);
		$period = array_reverse(iterator_to_array($period));

		$etiquetas = array();
		$datos = array();

		// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor

		foreach ($period as $fecha_row) {
			//array_push($etiquetas, strftime("%B %Y", strtotime($fecha_row->format("Y-m"))));
			//array_push($datos, "|");
			foreach ($this->reportes_model->get_ventas_numero_vendidas_por_vendedor_del_mes($fecha_row->format("Y-m"))->result() as $key => $value) {
				array_push($etiquetas, $value->sucursal_nombre . " - " . $value->sucursal_locacion . " | " . $value->vendedor . " | " . strftime("%B %Y", strtotime($fecha_row->format("Y-m"))));
				array_push($datos, $value->total);
			}
		}

		// Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
		$respuesta = [
			"etiquetas" => $etiquetas,
			"datos" => $datos,
		];

		echo json_encode($respuesta);
	}
	// Vista de grafica de vendedores fin

	// Vista de grafica de reservaciones por cliente inicio
	public function reservaciones_por_cliente()
	{
		$data['pagina_titulo'] = 'Reservaciones';
		$data['pagina_subtitulo'] = 'Reporte reservaciones por cliente';
		$data['menu_reportes'] = true;

		$data['controlador'] = 'reportes/reservaciones_por_cliente';
		$data['regresar_a'] = 'reportes';
		$controlador_js = "reportes/reservaciones_por_cliente";

		$data['styles'] = array(
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chart.js'),
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels'),
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$this->construir_private_site_ui('reportes/reservaciones_por_cliente', $data);
	}
	public function obtener_reservaciones_agrupadas_por_usuario()
	{
		$fecha_inicio = $this->input->get('fecha_inicio');
		$fecha_fin = $this->input->get('fecha_fin');
		$sucursal = $this->input->get('sucursal');

		try {
			$reservaciones = $this->reportes_model->obtener_reservaciones_agrupadas_por_usuario($fecha_inicio, $fecha_fin, $sucursal);
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($reservaciones));
		} catch (Exception $e) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['error' => $e->getMessage()]));
		}
	}
	// Vista de grafica de reservaciones por cliente fin

	public function reporte_instructores()
	{
		$data['pagina_titulo'] = 'Reporte de instructores';
		$data['pagina_subtitulo'] = 'Reporte de instructores';
		$data['pagina_menu_reportes'] = true;

		$data['controlador'] = 'reportes/reporte_instructores';
		$data['regresar_a'] = 'reportes';
		$controlador_js = "reportes/reporte_instructores";

		$data['styles'] = array(
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chart.js'),
			array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels'),
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$periodo_inicia = (new DateTime('2023-01-01'))->modify('first day of this month');
		$periodo_fin = (new DateTime(date('Y-m-d')))->modify('first day of next month');
		$periodo_set = DateInterval::createFromDateString('1 month');

		$data['periodo'] = new DatePeriod($periodo_inicia, $periodo_set, $periodo_fin);

		$reporte_list = $this->reportes_model->obtener_reporte_de_instructores_por_mes(date('Y-m'))->result();
		$data['reporte_list'] = $reporte_list;

		$this->construir_private_site_ui('reportes/reporte_instructores', $data);
	}

	public function obtener_clases_impartidas_agrupadas_por_instructor()
	{
		$fecha_inicio = $this->input->get('fecha_inicio');
		$fecha_fin = $this->input->get('fecha_fin');
		$sucursal = $this->input->get('sucursal');

		try {
			$clases = $this->reportes_model->obtener_clases_impartidas_agrupadas_por_instructor($fecha_inicio, $fecha_fin, $sucursal);
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($clases));
		} catch (Exception $e) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['error' => $e->getMessage()]));
		}
	}

	public function obtener_tabla_reporte_instructores_por_mes($fechaYm)
	{
		$draw = intval($this->input->post('draw'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));

		$reporte_list = $this->reportes_model->obtener_reporte_de_instructores_por_mes($fechaYm);

		$data = [];

		foreach ($reporte_list->result() as $reporte_key => $reporte_value) {
			$data[] = array(
				'id' => $reporte_key + 1,
				'instructor_nombre' => ucwords($reporte_value->instructor_nombre) . ' #' . $reporte_value->instructor_id,
				'total_clases' => $reporte_value->total_clases,
				'total_reservado' => $reporte_value->total_reservado,
			);
		}

		$result = array(
			'draw' => $draw,
			'recordsTotal' => $reporte_list->num_rows(),
			'recordsFiltered' => $reporte_list->num_rows(),
			'data' => $data
		);

		echo json_encode($result);
		exit();
	}

	public function obtener_tabla_reporte_instructores_entre_fechas($fecha_inicio, $fecha_fin)
	{
		$draw = intval($this->input->post('draw'));
		$start = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));

		$reporte_list = $this->reportes_model->obtener_reporte_de_instructores_entre_fechas($fecha_inicio, $fecha_fin);

		$data = [];

		foreach ($reporte_list->result() as $reporte_key => $reporte_value) {
			$data[] = array(
				'id' => $reporte_key + 1,
				'instructor_nombre' => ucwords($reporte_value->instructor_nombre) . ' #' . $reporte_value->instructor_id,
				'total_clases' => $reporte_value->total_clases,
				'total_reservado' => $reporte_value->total_reservado,
			);
		}

		$result = array(
			'draw' => $draw,
			'recordsTotal' => $reporte_list->num_rows(),
			'recordsFiltered' => $reporte_list->num_rows(),
			'data' => $data
		);

		echo json_encode($result);
		exit();
	}
}
