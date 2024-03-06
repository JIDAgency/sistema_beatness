<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Historial_reservaciones extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reservaciones_model');
        $this->load->model('asignaciones_model');
        $this->load->model('clases_model');
    }

    public function index()
    {
        $data['menu_historial_reservaciones_activo'] = true;
        $data['pagina_titulo'] = 'Historial de reservaciones ';
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
            array('es_rel' => true, 'src' => 'historial_reservaciones/index.js'),
        );

        $start = (new DateTime('2019-01-01'))->modify('first day of this month');
        $end = (new DateTime(date('Y-m-d')))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');

        $data['period'] = new DatePeriod($start, $interval, $end);

        $this->construir_private_site_ui('historial_reservaciones/index', $data);
    }

    public function get_reporte_de_reservaciones_del_mes_dinamico($mes_a_consultar = null)
    {
        $draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        
        $reservaciones_del_mes_list = $this->reservaciones_model->get_reporte_de_reservaciones_del_mes_dinamico($mes_a_consultar);

        if(!$reservaciones_del_mes_list){
            exit();
        }

        $data_reservaciones = array();

        foreach($reservaciones_del_mes_list->result() as $reservacion_del_mes_row){

            $data_reservaciones[] = array(
                "id" => $reservacion_del_mes_row->id,
                "clase" => $reservacion_del_mes_row->clase,
                "usuario" => $reservacion_del_mes_row->usuario,
                "disciplina" => $reservacion_del_mes_row->disciplina,
                "no_lugar" => $reservacion_del_mes_row->no_lugar,
                "asistencia" => $reservacion_del_mes_row->asistencia,
                "horario" => $reservacion_del_mes_row->horario,
                "estatus" => $reservacion_del_mes_row->estatus,
                "opciones" => anchor('historial_reservaciones/retirar_reservacion/'.$reservacion_del_mes_row->id, '<span style="color: red;">Retirar</span>'),
            );
        }

		$resultado = array(
			"draw" => $draw,
			"recordsTotal" => $reservaciones_del_mes_list->num_rows(),
			"recordsFiltered" => $reservaciones_del_mes_list->num_rows(),
			"data" => $data_reservaciones
		);

		echo json_encode($resultado);
		exit();
    }

    public function retirar_reservacion($id = null)
    {
        $reservacion_a_cancelar = $this->reservaciones_model->obtener_reservacion_por_id_para_retirar($id)->row();

        if (!$reservacion_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación ya ha sido marcada con inasistencia, verifique de nuevo.');
            redirect('historial_reservaciones/index');
        }

        $plan_cliente = $this->asignaciones_model->obtener_por_id($reservacion_a_cancelar->asignaciones_id)->row();
        
        if (!$plan_cliente) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar el plan del cliente con el que hizo la reservación.');
            redirect('historial_reservaciones/index');
        }

        $clase_a_modificar = $this->clases_model->obtener_por_id($reservacion_a_cancelar->clase_id)->row();

        if (!$clase_a_modificar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se ha podido encontrar la clase que se ha reservado.');
            redirect('historial_reservaciones/index');
        }

        $fecha_clase = $clase_a_modificar->inicia;
        $fecha_limite_clase = strtotime($fecha_clase);

        if (strtotime('-72 hours', strtotime('now')) > $fecha_limite_clase) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La clase ya ha transcurrido hace 48 horas, por lo que no se puede retirar la reservación.');
            redirect('historial_reservaciones/index');
        }

        // Establecer como desocupado
        $cupo_lugares = $clase_a_modificar->cupo_lugares;
        $cupo_lugares = json_decode($cupo_lugares);

        foreach ($cupo_lugares as $lugar) {
            if ($lugar->no_lugar == $reservacion_a_cancelar->no_lugar) {
                $lugar->esta_reservado = false;
                $lugar->nombre_usuario = '';
            }
        }

        $cupo_lugares_json = json_encode($cupo_lugares);

        $clases_usadas = $plan_cliente->clases_usadas;
        $reservado = $clase_a_modificar->reservado - 1;
        $inasistencias = $clase_a_modificar->inasistencias + 1;

        // Actualizar el plan del cliente y la clase para que se establezca que una clase ha sido usada
        if (!$this->asignaciones_model->editar($plan_cliente->id, array('clases_usadas' => $clases_usadas)) ||
            !$this->clases_model->editar($clase_a_modificar->id, array('reservado' => $reservado,'inasistencias' => $inasistencias, 'cupo_lugares' => $cupo_lugares_json))) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación no pudo ser retirada.');
            redirect('historial_reservaciones/index');
        }

        // modificar reservación
        $reservacion = $this->reservaciones_model->editar($id, array(
            'asistencia' => 'inasistencia',
        ));

        if (!$reservacion) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación no pudo ser retirada.');
            redirect('historial_reservaciones/index');
        }

        $this->session->set_flashdata('MENSAJE_EXITO', 'La reservación ha sido retirada correctamente.');
        redirect('historial_reservaciones/index');
    }
}