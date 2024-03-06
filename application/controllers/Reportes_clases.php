<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reportes_clases extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('clases_model');
        $this->load->model('disciplinas_model');
        $this->load->model('usuarios_model');
    }

    public function index()
    {
        $data['menu_reportes_clases_activo'] = true;
        $data['pagina_titulo'] = 'Reportes de clases ';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
			array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
			array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),            
            array('es_rel' => true, 'src' => 'reportes_clases/index.js'),
        );

        $start = (new DateTime('2019-01-01'))->modify('first day of this month');
        $end = (new DateTime(date('Y-m-d')))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');

        $data['period'] = new DatePeriod($start, $interval, $end);

        $this->construir_private_site_ui('reportes_clases/index', $data);
    }

    public function get_reporte_de_clases_del_mes_dinamico($mes_a_consultar = null)
    {
        $draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        
        $clases_del_mes_list = $this->clases_model->get_reporte_de_clases_del_mes_dinamico($mes_a_consultar);
        
        $usuarios = $this->usuarios_model->obtener_todos();

        if(!$clases_del_mes_list){
            exit();
        }

        $data_clases = array();

        foreach($clases_del_mes_list->result() as $clase_del_mes_row){

            $cupo_lugares_list = json_decode($clase_del_mes_row->cupo_lugares);

            $lista_lugares = '';

            foreach ($cupo_lugares_list as $cupo_lugares_row) {
                $texto_lugar = '';
                if ($cupo_lugares_row->nombre_usuario) {
                    foreach ($usuarios->result() as $usuario){
                        if ($cupo_lugares_row->nombre_usuario == $usuario->id) {
                            $texto_lugar = 'Lugar: '.$cupo_lugares_row->no_lugar.' |  Cliente: '.$cupo_lugares_row->nombre_usuario.' - '.$usuario->nombre_completo.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno;
                            $lista_lugares = $lista_lugares.'<br>'.$texto_lugar;
                        }
                    }
                    if (!is_numeric($cupo_lugares_row->nombre_usuario)) {
                        $texto_lugar = 'Lugar: '.$cupo_lugares_row->no_lugar.' |  Cliente: '.$cupo_lugares_row->nombre_usuario;
                        $lista_lugares = $lista_lugares.'<br>'.$texto_lugar;
                    }
                }
            } 

            $data_clases[] = array(
                "id" => $clase_del_mes_row->id,		
                "identificador" => $clase_del_mes_row->identificador,	
                "disciplina" => $clase_del_mes_row->subdisciplina_id != 0 ? $clase_del_mes_row->disciplina.' | '.$clase_del_mes_row->disciplina.' GODIN' : $clase_del_mes_row->disciplina,
                "instructor" => $clase_del_mes_row->instructor,	
                "cupo" => $clase_del_mes_row->cupo,	
                "reservado" => $clase_del_mes_row->reservado,	
                "inicia" => $clase_del_mes_row->inicia,	
                "lista_lugares" => $lista_lugares,
                "inasistencias" => $clase_del_mes_row->inasistencias,	
                "estatus" => $clase_del_mes_row->estatus,	

            );
        }

		$resultado = array(
			"draw" => $draw,
			"recordsTotal" => $clases_del_mes_list->num_rows(),
			"recordsFiltered" => $clases_del_mes_list->num_rows(),
			"data" => $data_clases
		);

		echo json_encode($resultado);
		exit();
    }

    function debug_to_console($data = null) {

        $output = $data;

        if ( is_array( $output ) )
        {
            $output = implode( ',', $output);
        }

        echo "<script>console.log( 'Que vas a probar: " . $output . "' );</script>";
    }
}