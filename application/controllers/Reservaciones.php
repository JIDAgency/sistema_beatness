<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservaciones extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('asignaciones_model');
        $this->load->model('clases_model');
        $this->load->model('reservaciones_model');
	}

	public function index()
    {

        $data['menu_reservaciones_activo'] = true;
        $data['pagina_titulo'] = 'Lista de reservaciones';

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
            array('es_rel' => true, 'src' => 'reservaciones/index.js'),

        );

        //$data['reservaciones'] = $this->reservaciones_model->obtener_todas_con_detalle();
        $data['reservaciones'] = $this->reservaciones_model->obtener_todas_para_front_con_detalle();

        $this->construir_private_site_ui('reservaciones/index', $data);
    }
    
    public function cancelar($id = null)
    {
        $reservacion_a_cancelar = $this->reservaciones_model->obtener_reservacion_por_id($id)->row();

        if (!$reservacion_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar la reservación que desea cancelar o ya ha sido cancelada, verifique de nuevo.');
            redirect('reservaciones/index');
        }

        if ($reservacion_a_cancelar->asistencia != "asistencia") {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación ha sido marcada con una inasistencia, por tal motivo no se puede cancelar.');
            redirect('reservaciones/index');
        }

        $plan_cliente = $this->asignaciones_model->obtener_por_id($reservacion_a_cancelar->asignaciones_id)->row();
        
        if (!$plan_cliente) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar el plan del cliente con el que hizo la reservación.');
            redirect('reservaciones/index');
        }
        /*if ($plan_cliente) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Si se pudo encontrar el plan del cliente con el que hizo la reservación.');
            redirect('reservaciones/index');
        }*/

        /*if ($plan_cliente->esta_activo == 1) {
            $this->session->set_flashdata('MENSAJE_INFO', 'El plan del cliente SI se encuentra activo.');
            redirect('reservaciones/index');
        }*/

        $clase_a_modificar = $this->clases_model->obtener_por_id($reservacion_a_cancelar->clase_id)->row();

        if (!$clase_a_modificar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se ha podido encontrar la clase que se ha reservado.');
            redirect('reservaciones/index');
        }
        /*if ($clase_a_modificar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Si se ha podido encontrar la clase que se ha reservado.');
            redirect('reservaciones/index');
        }*/

        $fecha_clase = $clase_a_modificar->inicia;
        $fecha_limite_clase = strtotime($fecha_clase);

        // if (strtotime('-72 hours', strtotime('now')) > $fecha_limite_clase) {
        //     $this->session->set_flashdata('MENSAJE_ERROR', 'La clase ya ha transcurrido hace 48 horas, por lo que no se puede cancelar la reservación.');
        //     redirect('reservaciones/index');
        // } 
        /*else{
            $this->session->set_flashdata('MENSAJE_INFO', 'La clase aun no ha transcurrido, por lo que Si se puede cancelar la reservación.. '.$fecha_vigencia);
            redirect('reservaciones/index');
        }*/

        //$reservaciones_duplicadas = $this->reservaciones_model->obtener_reservacion_por_cliente_y_clase($reservacion_a_cancelar->usuario_id, $reservacion_a_cancelar->clase_id);

        /*if ($plan_cliente->esta_activo) {

            $fecha_activacion = $plan_cliente->fecha_activacion;
            log_message('debug', $fecha_activacion);

            $fecha_vigencia = strtotime($fecha_activacion . ' + ' . $plan_cliente->vigencia_en_dias . ' days');
            log_message('debug', $fecha_vigencia);
            log_message('debug', strtotime('now'));

            if (strtotime('now') > $fecha_vigencia) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'El plan ha expirado.');
                redirect('reservaciones/index');
            } 

        } else { // Si no está activo
            $this->session->set_flashdata('MENSAJE_ERROR', 'El plan no se encuentra activado.');
            redirect('reservaciones/index');
        }*/

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

        $clases_usadas = $plan_cliente->clases_usadas - $clase_a_modificar->intervalo_horas;
        $reservado = $clase_a_modificar->reservado - 1;

        if ($plan_cliente->esta_activo == 0) {
            // Actualizar el plan del cliente y la clase para que se establezca que una clase ha sido usada
            if (!$this->asignaciones_model->editar($plan_cliente->id, array('nombre' => $plan_cliente->nombre.' - REACTIVADO', 'clases_usadas' => $clases_usadas, 'vigencia_en_dias' => $plan_cliente->vigencia_en_dias+35, 'esta_activo' => 1, 'estatus' => 'Activo')) ||
                !$this->clases_model->editar($clase_a_modificar->id, array('reservado' => $reservado, 'cupo_lugares' => $cupo_lugares_json))) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación no pudo ser cancelada.');
                redirect('reservaciones/index');
            }
        } else {
            // Actualizar el plan del cliente y la clase para que se establezca que una clase ha sido usada
            if (!$this->asignaciones_model->editar($plan_cliente->id, array('clases_usadas' => $clases_usadas)) ||
                !$this->clases_model->editar($clase_a_modificar->id, array('reservado' => $reservado, 'cupo_lugares' => $cupo_lugares_json))) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación no pudo ser cancelada.');
                redirect('reservaciones/index');
            }
        }

        // modificar reservación
        $reservacion = $this->reservaciones_model->editar($id, array(
            'asistencia' => 'cancelada',
            'estatus' => 'Cancelada',
        ));

        if (!$reservacion) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación no pudo ser cancelada.');
            redirect('reservaciones/index');
        }

        $this->session->set_flashdata('MENSAJE_EXITO', 'La reservación ha sido cancelada correctamente.');
        redirect('reservaciones/index');
    }
    
    public function retirar_reservacion($id = null)
    {
        $reservacion_a_cancelar = $this->reservaciones_model->obtener_reservacion_por_id($id)->row();

        if (!$reservacion_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar la reservación que desea cancelar o ya ha sido cancelada, verifique de nuevo.');
            redirect('reservaciones/index');
        }
        /*if ($reservacion_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Si se pudo encontrar la reservación que desea cancelar.');
            redirect('reservaciones/index');
        }*/

        $plan_cliente = $this->asignaciones_model->obtener_por_id($reservacion_a_cancelar->asignaciones_id)->row();
        
        if (!$plan_cliente) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar el plan del cliente con el que hizo la reservación.');
            redirect('reservaciones/index');
        }
        /*if ($plan_cliente) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Si se pudo encontrar el plan del cliente con el que hizo la reservación.');
            redirect('reservaciones/index');
        }*/

        /*if ($plan_cliente->esta_activo == 0) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Lo sentimos,el plan del cliente ya no se encuentra activo.');
            redirect('reservaciones/index');
        }*/

        /*if ($plan_cliente->esta_activo == 1) {
            $this->session->set_flashdata('MENSAJE_INFO', 'El plan del cliente SI se encuentra activo.');
            redirect('reservaciones/index');
        }*/

        $clase_a_modificar = $this->clases_model->obtener_por_id($reservacion_a_cancelar->clase_id)->row();

        if (!$clase_a_modificar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se ha podido encontrar la clase que se ha reservado.');
            redirect('reservaciones/index');
        }
        /*if ($clase_a_modificar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Si se ha podido encontrar la clase que se ha reservado.');
            redirect('reservaciones/index');
        }*/

        $fecha_clase = $clase_a_modificar->inicia;
        $fecha_limite_clase = strtotime($fecha_clase);

        if (strtotime('-48 hours', strtotime('now')) > $fecha_limite_clase) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La clase ya ha transcurrido hace 48 horas, por lo que no se puede retirar la reservación.');
            redirect('reservaciones/index');
        } /*else{
            $this->session->set_flashdata('MENSAJE_INFO', 'La clase aun no ha transcurrido, por lo que Si se puede cancelar la reservación.. '.$fecha_vigencia);
            redirect('reservaciones/index');
        }*/

        //$reservaciones_duplicadas = $this->reservaciones_model->obtener_reservacion_por_cliente_y_clase($reservacion_a_cancelar->usuario_id, $reservacion_a_cancelar->clase_id);

        /*if ($plan_cliente->esta_activo) {

            $fecha_activacion = $plan_cliente->fecha_activacion;
            log_message('debug', $fecha_activacion);

            $fecha_vigencia = strtotime($fecha_activacion . ' + ' . $plan_cliente->vigencia_en_dias . ' days');
            log_message('debug', $fecha_vigencia);
            log_message('debug', strtotime('now'));

            if (strtotime('now') > $fecha_vigencia) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'El plan ha expirado.');
                redirect('reservaciones/index');
            } 

        } else { // Si no está activo
            $this->session->set_flashdata('MENSAJE_ERROR', 'El plan no se encuentra activado.');
            redirect('reservaciones/index');
        }*/

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
            redirect('reservaciones/index');
        }

        // modificar reservación
        $reservacion = $this->reservaciones_model->editar($id, array(
            'asistencia' => 'inasistencia',
        ));

        if (!$reservacion) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación no pudo ser retirada.');
            redirect('reservaciones/index');
        }

        $this->session->set_flashdata('MENSAJE_EXITO', 'La reservación ha sido retirada correctamente.');
        redirect('reservaciones/index');
    }
}
