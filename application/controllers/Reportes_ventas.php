<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reportes_ventas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ventas_model');
        $this->load->model('planes_model');
        $this->load->model('usuarios_model');
        $this->load->model('metodos_model');
        $this->load->model('asignaciones_model');
        $this->load->model('disciplinas_model');
    }

    public function index()
    {
        $data['menu_reportes_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Reporte de ventas';
        $data['pagina_subtitulo'] = 'Reporte de ventas';

        $data['controlador'] = 'reportes_ventas';
        $data['regresar_a'] = 'ventas';
        $controlador_js = "reportes_ventas/index";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('reportes_ventas/index', $data);
    }

    public function obtener_tabla_index()
    {
        $this->load->model('reportes_ventas_model');

        // Validación y conversión de parámetros de entrada
        $draw   = (int)$this->input->post("draw");
        $start  = (int)$this->input->post("start");
        $length = (int)$this->input->post("length");

        // Se asume que el modelo Ventas_model tiene el método obtener_todas()
        $ventas_list = $this->reportes_ventas_model->obtener_todas();
        $data = [];

        if ($ventas_list && $ventas_list->num_rows() > 0) {
            foreach ($ventas_list->result() as $key => $venta) {
                // Formatear las fechas usando setlocale (ajusta la configuración regional según tu entorno)
                setlocale(LC_ALL, "es_ES");
                $fechaVentaFormateada = strftime("%d de %B del %Y<br>%T", strtotime($venta->fecha_venta));
                $fechaActivacionFormateada = strftime("%d de %B del %Y<br>%T", strtotime($venta->fecha_activacion));

                // Preparar la fila de datos para DataTables
                // Dentro del foreach, al preparar la fila:
                $clases_comb = $venta->clases_usadas . "/" . $venta->clases_incluidas;
                $data[] = [
                    "id"                  => $venta->id,
                    "producto"            => mb_strtoupper($venta->concepto) . " #" . $venta->asignacion_id,
                    "producto"            => mb_strtoupper($venta->concepto) . " #" . $venta->asignacion_id,
                    "metodo"              => mb_strtoupper($venta->metodo),
                    "sucursales_locacion" => $venta->sucursales_locacion,
                    "fecha_venta"         => $fechaVentaFormateada,
                    "costo"               => '$' . number_format($venta->costo, 2),
                    "total"               => '$' . number_format($venta->total, 2),
                    "cliente"             => $venta->usuario . " #" . $venta->usuario_id,
                    "cantidad"            => $venta->cantidad,
                    "vendedor"            => $venta->vendedor,
                    "estatus"             => $venta->estatus,
                    "clases"              => $clases_comb, // Nueva columna combinada
                    "vigencia_en_dias"    => $venta->vigencia_en_dias,
                    "fecha_activacion"    => $fechaActivacionFormateada
                ];
            }
        }

        // Preparar respuesta para DataTables
        $result = [
            "draw"            => $draw,
            "recordsTotal"    => ($ventas_list) ? $ventas_list->num_rows() : 0,
            "recordsFiltered" => ($ventas_list) ? $ventas_list->num_rows() : 0,
            "data"            => $data
        ];

        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }


    public function ventas_puebla()
    {
        $data['menu_reportes_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Reportes de ventas Puebla ';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => 'reportes_ventas/ventas_puebla.js'),
        );

        //Variables
        $total_de_ventas = 0;
        $total_de_ventas_puebla = 0;
        $meses_b3 = array();
        $total_meses_b3 = array();

        //Obtener los meses del inicio 2019-01-14 en adelante
        $fecha_inicio = (new DateTime('2019-1-14'))->modify('first day of this month');
        $fecha_actual = (new DateTime(date('Y-m-d')))->modify('first day of next month');
        $intervalo = DateInterval::createFromDateString('1 month');
        $periodo = new DatePeriod($fecha_inicio, $intervalo, $fecha_actual);

        foreach ($periodo as $meses_del_periodo) {
            array_push($meses_b3, $meses_del_periodo->format("Y-m"));
        }

        $todas_las_ventas_registradas = $this->ventas_model->obtener_todas();
        $todas_las_ventas_registradas_puebla = $this->ventas_model->obtener_ventas_puebla();
        $metodos_pago = $this->metodos_model->obtener_para_filtro()->result();

        $data['metodos_pago'] = $metodos_pago;
        $data['todas_las_ventas_registradas'] = $todas_las_ventas_registradas;
        $data['todas_las_ventas_registradas_puebla'] = $todas_las_ventas_registradas_puebla;

        //Recorrido de todas las ventas PUEBLA
        foreach ($todas_las_ventas_registradas->result() as $ventas_row) {
            //El total de historico de todas las ventas PUEBLA
            $total_de_ventas = $total_de_ventas + $ventas_row->total;
        }

        //Recorrido de todas las ventas PUEBLA
        foreach ($todas_las_ventas_registradas_puebla->result() as $ventas_row) {
            //El total de historico de todas las ventas PUEBLA
            $total_de_ventas_puebla = $total_de_ventas_puebla + $ventas_row->total;
        }

        $data['total_de_ventas'] = $total_de_ventas;
        $data['total_de_ventas_puebla'] = $total_de_ventas_puebla;

        $this->construir_private_site_ui('reportes_ventas/ventas_puebla', $data);
    }

    public function ventas_polanco()
    {
        $data['menu_reportes_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Reportes de ventas Polanco ';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => 'reportes_ventas/ventas_polanco.js'),
        );

        //Variables
        $total_de_ventas = 0;
        $total_de_ventas_polanco = 0;
        $meses_b3 = array();
        $total_meses_b3 = array();

        //Obtener los meses del inicio 2019-01-14 en adelante
        $fecha_inicio = (new DateTime('2019-1-14'))->modify('first day of this month');
        $fecha_actual = (new DateTime(date('Y-m-d')))->modify('first day of next month');
        $intervalo = DateInterval::createFromDateString('1 month');
        $periodo = new DatePeriod($fecha_inicio, $intervalo, $fecha_actual);

        foreach ($periodo as $meses_del_periodo) {
            array_push($meses_b3, $meses_del_periodo->format("Y-m"));
        }

        $todas_las_ventas_registradas = $this->ventas_model->obtener_todas();
        $todas_las_ventas_registradas_polanco = $this->ventas_model->obtener_ventas_polanco();
        $metodos_pago = $this->metodos_model->obtener_para_filtro()->result();

        $data['metodos_pago'] = $metodos_pago;
        $data['todas_las_ventas_registradas'] = $todas_las_ventas_registradas;
        $data['todas_las_ventas_registradas_polanco'] = $todas_las_ventas_registradas_polanco;

        //Recorrido de todas las ventas polanco
        foreach ($todas_las_ventas_registradas->result() as $ventas_row) {
            //El total de historico de todas las ventas polanco
            $total_de_ventas = $total_de_ventas + $ventas_row->total;
        }

        //Recorrido de todas las ventas polanco
        foreach ($todas_las_ventas_registradas_polanco->result() as $ventas_row) {
            //El total de historico de todas las ventas polanco
            $total_de_ventas_polanco = $total_de_ventas_polanco + $ventas_row->total;
        }

        $data['total_de_ventas'] = $total_de_ventas;
        $data['total_de_ventas_polanco'] = $total_de_ventas_polanco;

        $this->construir_private_site_ui('reportes_ventas/ventas_polanco', $data);
    }

    public function cancelar($id = null)
    {

        $venta_a_cancelar = $this->ventas_model->venta_a_cancelar_por_id($id)->row();

        if (!$venta_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar la venta que desea cancelar o ya ha sido cancelada, verifique de nuevo.');
            redirect('reportes_ventas/index');
        }
        /*if ($venta_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Si se pudo encontrar la venta que desea cancelar.');
            redirect('reportes_ventas/index');
        }*/

        $asignacion_a_cancelar = $this->asignaciones_model->obtener_por_id($venta_a_cancelar->asignacion_id)->row();

        if (!$asignacion_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar la asignacion que desea cancelar o ya ha sido cancelada, verifique de nuevo.');
            redirect('reportes_ventas/index');
        }
        /*if ($asignacion_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Si se pudo encontrar la asignacion que desea cancelar.');
            redirect('reportes_ventas/index');
        }*/

        if ($asignacion_a_cancelar->clases_usadas > 0) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'El usuario ya ha realizado reservaciones con este plan, por favor primero cancele las reservaciones si es que estas no han caducado.');
            redirect('reportes_ventas/index');
        }
        /*if ($asignacion_a_cancelar->clases_usadas == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'No hay reservaciones con este plan');
            redirect('reportes_ventas/index');
        }*/

        $data_asignacion = array(
            'clases_incluidas' => '0',
            'esta_activo' => '0',
            'vigencia_en_dias' => 'vigencia_en_dias',
            'estatus' => 'Cancelado',
        );

        if (!$this->asignaciones_model->editar($asignacion_a_cancelar->id, $data_asignacion)) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La asignación no se ha editado correctamente');
            redirect('reportes_ventas/index');
        }

        $data_venta = array(
            'total' => '0',
            'estatus' => 'Cancelada',
        );

        if ($this->ventas_model->editar($venta_a_cancelar->id, $data_venta)) {
            $this->session->set_flashdata('MENSAJE_EXITO', 'La CANCELACIÓN venta #' . $venta_a_cancelar->id . ' se ha hecho correctamente.');
            redirect('reportes_ventas/index');
        }

        $data[] = '';
        $this->construir_private_site_ui('reportes_ventas/crear_personalizada', $data);
    }


    function debug_to_console($data = null)
    {

        $output = $data;

        if (is_array($output)) {
            $output = implode(',', $output);
        }

        echo "<script>console.log( 'Que vas a probar: " . $output . "' );</script>";
    }
}
