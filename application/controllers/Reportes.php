<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reportes extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

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

		$data['styles'] = array();

		$data['scripts'] = array(
			array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
		);

		$this->construir_private_site_ui('reportes/index', $data);
	}

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
		);

		$data['scripts'] = array(
			array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
		);

		$periodo_inicia = (new DateTime('2023-01-01'))->modify('first day of this month');
		$periodo_fin = (new DateTime(date('Y-m-d')))->modify('first day of next month');
		$periodo_set = DateInterval::createFromDateString('1 month');

		$data['periodo'] = new DatePeriod($periodo_inicia, $periodo_set, $periodo_fin);

		$reporte_list = $this->reportes_model->obtener_reporte_de_instructores_por_mes(date('Y-m'))->result();
		$data['reporte_list'] = $reporte_list;

		$this->construir_private_site_ui('reportes/reporte_instructores', $data);
	}

	public function obtener_tabla_reporte_instructores_por_mes($fechaYm) {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

		$reporte_list = $this->reportes_model->obtener_reporte_de_instructores_por_mes($fechaYm);

        $data = [];
		
        foreach ($reporte_list->result() as $reporte_key => $reporte_value) {
            $data[] = array(
                'id' => $reporte_key+1,
				'instructor_nombre' => ucwords($reporte_value->instructor_nombre).' #'.$reporte_value->instructor_id,
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

	public function obtener_tabla_reporte_instructores_entre_fechas($fecha_inicio, $fecha_fin) {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

		$reporte_list = $this->reportes_model->obtener_reporte_de_instructores_entre_fechas($fecha_inicio, $fecha_fin);

        $data = [];
		
        foreach ($reporte_list->result() as $reporte_key => $reporte_value) {
            $data[] = array(
                'id' => $reporte_key+1,
				'instructor_nombre' => ucwords($reporte_value->instructor_nombre).' #'.$reporte_value->instructor_id,
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
