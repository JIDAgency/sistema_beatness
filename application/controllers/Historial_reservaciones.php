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

        $start = (new DateTime('2024-04-04'))->modify('first day of this month');
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

        if (!$reservaciones_del_mes_list) {
            exit();
        }

        $data_reservaciones = array();

        foreach ($reservaciones_del_mes_list->result() as $reservacion_del_mes_row) {

            $data_reservaciones[] = array(
                "id" => $reservacion_del_mes_row->id,
                "clase" => $reservacion_del_mes_row->clase,
                "usuario" => $reservacion_del_mes_row->usuario,
                "disciplina" => $reservacion_del_mes_row->disciplina,
                "no_lugar" => $reservacion_del_mes_row->no_lugar,
                "asistencia" => $reservacion_del_mes_row->asistencia,
                "horario" => $reservacion_del_mes_row->horario,
                "estatus" => $reservacion_del_mes_row->estatus,
                "opciones" => anchor('historial_reservaciones/retirar_reservacion/' . $reservacion_del_mes_row->id, '<span style="color: red;">Inasistencia</span>'),
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

    /**
     * Marcar una reservación como inasistencia.
     *
     * Esta función marca una reservación específica como inasistencia, actualiza el estado de la clase y el plan del cliente.
     * Se asegura de que todas las operaciones se realicen dentro de una transacción para mantener la integridad de los datos.
     *
     * @param int|null $id El ID de la reservación a marcar como inasistencia.
     * @return void Redirige a la página de historial de reservaciones con un mensaje de éxito o error.
     */
    public function retirar_reservacion($id = null)
    {
        // Iniciar la transacción
        $this->db->trans_begin();

        try {
            // Validar que se haya proporcionado un ID de reservación
            if (is_null($id)) {
                throw new Exception('ID de reservación inválido. Por favor, inténtelo nuevamente.');
            }

            // Obtener la reservación a marcar como inasistencia
            $reservacion_a_marcar = $this->reservaciones_model->obtener_reservacion_por_id_para_retirar($id)->row();

            if (!$reservacion_a_marcar) {
                throw new Exception('La reservación no existe o ya ha sido procesada.');
            }

            // Verificar permisos y estado de asistencia si el usuario no es superadministrador
            if (!es_superadministrador()) {
                if ($reservacion_a_marcar->asistencia === 'asistencia') {
                    throw new Exception('La reservación ya ha sido marcada como asistida. Solicite la intervención de un administrador para realizar esta acción.');
                }
            }

            // Obtener el plan del cliente asociado a la reservación
            $plan_cliente = $this->asignaciones_model->obtener_por_id($reservacion_a_marcar->asignaciones_id)->row();

            if (!$plan_cliente) {
                throw new Exception('No se pudo encontrar el plan del cliente asociado a esta reservación.');
            }

            // Obtener la clase asociada a la reservación
            $clase_a_modificar = $this->clases_model->obtener_por_id($reservacion_a_marcar->clase_id)->row();

            if (!$clase_a_modificar) {
                throw new Exception('No se ha encontrado la clase asociada a esta reservación.');
            }

            // Verificar si la clase ha pasado el límite para marcar como inasistencia, solo si no es superadministrador
            if (!es_superadministrador()) {
                $fecha_clase = strtotime($clase_a_modificar->inicia);
                $fecha_actual = time();

                // Definir el límite de tiempo (48 horas después de la clase)
                $limite_retiro = strtotime('+48 hours', $fecha_clase);

                if ($fecha_actual > $limite_retiro) {
                    throw new Exception('No se puede registrar una inasistencia porque han pasado más de 48 horas desde la clase. Solicite la intervención de un administrador para realizar esta acción.');
                }
            }

            // Decodificar el JSON de cupo de lugares
            $cupo_lugares = json_decode($clase_a_modificar->cupo_lugares);

            // Verificar y actualizar el estado del lugar reservado
            $lugar_encontrado = false;
            foreach ($cupo_lugares as $lugar) {
                if ($lugar->no_lugar == $reservacion_a_marcar->no_lugar) {
                    $lugar->esta_reservado = false;
                    $lugar->nombre_usuario = '';
                    $lugar_encontrado = true;
                    break;
                }
            }

            if (!$lugar_encontrado) {
                throw new Exception('No se pudo encontrar el lugar reservado para esta reservación.');
            }

            // Codificar nuevamente el JSON de cupo de lugares
            $cupo_lugares_json = json_encode($cupo_lugares);

            // Actualizar contadores de la clase
            $reservado = $clase_a_modificar->reservado - 1;
            $inasistencias = $clase_a_modificar->inasistencias + 1;

            // Preparar datos para actualizar el plan del cliente y la clase
            $datos_plan = array(
                'clases_usadas' => $plan_cliente->clases_usadas - 1 // Asumiendo que se retira una clase usada
            );

            $datos_clase = array(
                'reservado' => $reservado,
                'inasistencias' => $inasistencias,
                'cupo_lugares' => $cupo_lugares_json
            );

            // Actualizar el plan del cliente
            $actualizar_plan = $this->asignaciones_model->editar($plan_cliente->id, $datos_plan);
            if (!$actualizar_plan) {
                throw new Exception('No se pudo actualizar el plan del cliente.');
            }

            // Actualizar la clase
            $actualizar_clase = $this->clases_model->editar($clase_a_modificar->id, $datos_clase);
            if (!$actualizar_clase) {
                throw new Exception('No se pudo actualizar la clase asociada a esta reservación.');
            }

            // Actualizar el estado de la reservación a 'inasistencia'
            $datos_reservacion = array(
                'asistencia' => 'inasistencia',
                //'fecha_retirada' => date('Y-m-d H:i:s') // Opcional: registrar cuándo se marcó la inasistencia
            );

            $actualizar_reservacion = $this->reservaciones_model->editar($id, $datos_reservacion);
            if (!$actualizar_reservacion) {
                throw new Exception('No se pudo actualizar el estado de la reservación a inasistencia.');
            }

            // Verificar el estado de la transacción
            if ($this->db->trans_status() === FALSE) {
                // Si algo falló en la transacción
                throw new Exception('Ocurrió un error durante el proceso. La reservación no pudo ser marcada como inasistencia.');
            }

            // Completar la transacción
            $this->db->trans_commit();

            // Establecer mensaje de éxito
            $this->session->set_flashdata('MENSAJE_EXITO', 'La reservación ha sido marcada como inasistencia correctamente.');
        } catch (Exception $e) {
            // Revertir la transacción en caso de cualquier error
            if ($this->db->trans_status() !== FALSE) {
                $this->db->trans_rollback();
            }

            // Establecer mensaje de error
            $this->session->set_flashdata('MENSAJE_ERROR', $e->getMessage());
        }

        // Redirigir al historial de reservaciones
        redirect('historial_reservaciones/index');
    }
}
