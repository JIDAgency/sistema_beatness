<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Server extends CI_Controller
{
    // Propiedad para controlar si se registran o no los logs.
    private $logging_enabled = false;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('reservaciones_model');
        $this->load->model('asignaciones_model');
        $this->load->model('clases_model');
        $this->load->model('usuarios_model');
        $this->load->model('planes_model');
    }

    /**
     * Activa los logs.
     */
    public function enable_logs()
    {
        $this->logging_enabled = true;
        $this->_log_custom('info', 'Logs activados.');
    }

    /**
     * Desactiva los logs.
     */
    public function disable_logs()
    {
        // No se registra el mensaje de desactivación para evitar escribir después de desactivar.
        $this->logging_enabled = false;
    }

    /**
     * Función privada que encapsula log_message() según el estado de $logging_enabled.
     *
     * @param string $level Nivel del log (e.g., 'error', 'info', etc.)
     * @param string $message Mensaje a registrar.
     */
    private function _log_custom($level, $message)
    {
        if ($this->logging_enabled) {
            log_message($level, $message);
        }
    }

    /**
     * Método index: Se puede usar para ejecutar todas las tareas a la vez.
     * Desde cron se recomienda invocar este método para ejecutar las funciones necesarias.
     */
    public function index()
    {
        // Descomenta las siguientes líneas para ejecutar las funciones cuando se invoque este método.
        // $this->terminar_caducadas();
        // $this->terminar_clases_caducadas();
        // $this->terminar_planes_caducadas();
        // $this->dias_restantes();
    }

    /**
     * Termina las reservaciones caducadas.
     *
     * @throws Exception Si falla la obtención de reservaciones o alguna actualización.
     */
    public function terminar_caducadas()
    {
        try {
            $todas_las_reservaciones = $this->reservaciones_model->obtener_todas_activas();

            if (!$todas_las_reservaciones) {
                throw new Exception('No se pudieron obtener reservaciones activas.');
            }

            // Iniciamos una transacción para agrupar las actualizaciones.
            $this->db->trans_start();

            foreach ($todas_las_reservaciones->result() as $reservacion_activa) {
                $clase_a_consultar = $this->clases_model->obtener_por_id($reservacion_activa->clase_id)->row();

                if (!$clase_a_consultar) {
                    $this->_log_custom('error', 'No se encontró la clase para la reservacion ID: ' . $reservacion_activa->id);
                    continue;
                }

                $fecha_clase = $clase_a_consultar->inicia;
                $fecha_limite_clase = strtotime('+120 minutes', strtotime($fecha_clase));

                if ($reservacion_activa->estatus == 'Activa' && time() >= $fecha_limite_clase) {
                    $resultado = $this->reservaciones_model->editar($reservacion_activa->id, ['estatus' => 'Terminada']);

                    if (!$resultado) {
                        throw new Exception('Error al actualizar la reservacion: ' . $reservacion_activa->id);
                    }
                    $this->_log_custom('info', 'Terminada la reservacion: ' . $reservacion_activa->id);
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $error = $this->db->error();
                throw new Exception('Error en la transacción de terminar_caducadas: ' . json_encode($error));
            }
        } catch (Exception $e) {
            $this->_log_custom('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * Termina las clases caducadas y envía notificaciones.
     *
     * @throws Exception Si ocurre un error al actualizar la clase o enviar la notificación.
     */
    public function terminar_clases_caducadas()
    {
        try {
            $todas_las_clases = $this->clases_model->obtener_todas_activas();

            if (!$todas_las_clases) {
                throw new Exception('No se pudieron obtener clases activas.');
            }

            foreach ($todas_las_clases->result() as $clase_activa) {
                $fecha_clase = $clase_activa->inicia;
                $fecha_limite_clase = strtotime('+30 minutes', strtotime($fecha_clase));

                if ($clase_activa->estatus == 'Activa' && time() >= $fecha_limite_clase) {
                    // Transacción para actualizar el estado de la clase.
                    $this->db->trans_start();
                    $resultado = $this->clases_model->editar($clase_activa->id, ['estatus' => 'Terminada']);
                    $this->db->trans_complete();

                    if (!$resultado || $this->db->trans_status() === FALSE) {
                        $error = $this->db->error();
                        throw new Exception('Error al actualizar la clase ' . $clase_activa->id . ': ' . json_encode($error));
                    }
                    $this->_log_custom('info', 'Terminada la clase: ' . $clase_activa->id);

                    // Obtener lista de usuarios (aquí se usa un array fijo, se recomienda hacerlo dinámico).
                    $usuarios_list = ['16', '14', '7'];

                    if (empty($usuarios_list)) {
                        throw new Exception('No hay usuarios con reservaciones para la clase: ' . $clase_activa->id);
                    } else {
                        // Evitar duplicados.
                        array_push($usuarios_list, '7', '16', '14');
                        $to = array_unique($usuarios_list);

                        $title   = 'CLASE TERMINADA';
                        $message = 'La clase termino es hora de calificar al coach 🏋️‍♂️🎖️';
                        $img     = '';

                        $app_id  = '66454c58-6e0b-4489-ba82-524c05331a3b';
                        $app_key = 'OGJhYWFlNGYtMDEwYi00NjMyLThiNzMtMDc0YTg4OTk3Yzkx';

                        $content = [
                            "es" => $message,
                            "en" => $message
                        ];

                        $headings = [
                            "es" => $title,
                            "en" => $title
                        ];

                        $fields = [
                            'app_id'                    => $app_id,
                            "headings"                  => $headings,
                            'include_external_user_ids' => $to,
                            'channel_for_external_user_ids' => 'push',
                            'contents'                  => $content,
                            'large_icon'                => '',
                            'content_available'         => true,
                            'SetIsAndroid'              => true,
                            'SetIsIos'                  => true,
                        ];

                        if (!empty($img)) {
                            $fields["big_picture"]     = $img;
                            $fields["ios_attachments"] = ["id1" => $img];
                        }

                        $headers = [
                            'Authorization: Basic ' . $app_key,
                            'Accept: application/json',
                            'Content-Type: application/json'
                        ];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://onesignal.com/api/v1/notifications');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

                        $result = curl_exec($ch);
                        $curl_error = curl_error($ch);
                        curl_close($ch);

                        if ($result === false) {
                            throw new Exception('Error al enviar notificación via cURL para la clase ' . $clase_activa->id . ': ' . $curl_error);
                        } else {
                            $response = json_decode($result, true);
                            if (isset($response['errors'])) {
                                $error_message = implode('. ', $response['errors']);
                                throw new Exception('Error al enviar notificación para la clase ' . $clase_activa->id . ': ' . $error_message);
                            } else {
                                $this->_log_custom('info', 'Notificación enviada correctamente para la clase: ' . $clase_activa->id);
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $this->_log_custom('error', 'terminar_clases_caducadas - ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Termina las asignaciones (planes) caducadas.
     *
     * @throws Exception Si falla la actualización de alguna asignación o la transacción.
     */
    public function terminar_planes_caducadas()
    {
        try {
            $todas_las_asignaciones = $this->asignaciones_model->obtener_todos_activos();

            if (!$todas_las_asignaciones) {
                throw new Exception('No se pudieron obtener asignaciones activas.');
            }

            $cont = 0;
            // Iniciamos una transacción para agrupar las actualizaciones.
            $this->db->trans_start();

            foreach ($todas_las_asignaciones->result() as $asignacion_activo) {
                if ($asignacion_activo->categoria != 'suscripcion' && $asignacion_activo->estatus == 'Activo' && $asignacion_activo->plan_id != '14') {
                    $fecha_clase = $asignacion_activo->fecha_activacion;
                    $fecha_limite_clase = strtotime('+' . $asignacion_activo->vigencia_en_dias . ' days', strtotime($fecha_clase));

                    if (time() >= $fecha_limite_clase) {
                        $this->_log_custom('info', 'Fecha de activación: ' . $asignacion_activo->fecha_activacion);
                        $this->_log_custom('info', 'Fecha límite: ' . date('Y-m-d H:i:s', $fecha_limite_clase));
                        $cont++;
                        $this->_log_custom(
                            'info',
                            "| Asignacion ID: " . $asignacion_activo->id .
                                " | Usuario ID: " . $asignacion_activo->usuario_id .
                                " | Plan: " . $asignacion_activo->nombre .
                                " | Categoria: " . $asignacion_activo->categoria .
                                " | Estatus: " . $asignacion_activo->estatus .
                                " | Clases Incluidas: " . $asignacion_activo->clases_incluidas .
                                " | Clases Usadas: " . $asignacion_activo->clases_usadas
                        );

                        if (!$this->asignaciones_model->editar($asignacion_activo->id, [
                            'esta_activo' => '0',
                            'estatus'     => 'Caducado'
                        ])) {
                            throw new Exception('Error al actualizar la asignacion ID: ' . $asignacion_activo->id);
                        }
                    }
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $error = $this->db->error();
                throw new Exception('Error en la transacción de terminar_planes_caducadas: ' . json_encode($error));
            }

            $this->_log_custom('info', 'Total de asignaciones caducadas: ' . $cont);
        } catch (Exception $e) {
            $this->_log_custom('error', 'terminar_planes_caducadas - ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza los días restantes del año en los planes 138 y 139.
     *
     * @throws Exception Si falla la actualización de alguno de los planes.
     */
    public function dias_restantes()
    {
        try {
            $dias_transcurridos = date('z') + 1;
            $dias_restantes = 365 - $dias_transcurridos;
            $data = ['clases_incluidas' => $dias_restantes, 'vigencia_en_dias' => $dias_restantes];

            // Agrupamos ambas actualizaciones en una transacción.
            $this->db->trans_start();
            $result1 = $this->planes_model->editar('138', $data);
            $result2 = $this->planes_model->editar('139', $data);
            $this->db->trans_complete();

            if (!$result1 || !$result2 || $this->db->trans_status() === FALSE) {
                $error = $this->db->error();
                throw new Exception('Error al actualizar los días restantes para los planes 138 o 139: ' . json_encode($error));
            }

            $this->_log_custom('info', 'Días restantes del año: ' . $dias_restantes);
        } catch (Exception $e) {
            $this->_log_custom('error', 'dias_restantes - ' . $e->getMessage());
            throw $e;
        }
    }
}
