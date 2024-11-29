<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Server extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reservaciones_model');
        $this->load->model('asignaciones_model');
        $this->load->model('clases_model');
        $this->load->model('usuarios_model');
    }

    public function index()
    {
        //$this->terminar_caducadas();
        //$this->terminar_clases_caducadas();
        //$this->terminar_planes_caducadas();
    }

    public function terminar_caducadas()
    {
        $todas_las_reservaciones = $this->reservaciones_model->obtener_todas_activas();

        foreach ($todas_las_reservaciones->result() as $reservacion_activa) {
            $clase_a_consultar = $this->clases_model->obtener_por_id($reservacion_activa->clase_id)->row();

            $fecha_clase = $clase_a_consultar->inicia;
            $fecha_limite_clase = strtotime('+120 minutes', strtotime($fecha_clase));

            if ($reservacion_activa->estatus == 'Activa') {

                if (strtotime('now') >= $fecha_limite_clase) {

                    $reservacion = $this->reservaciones_model->editar($reservacion_activa->id, array(
                        'estatus' => 'Terminada',
                    ));

                    echo "Terminada la reservacion: " . $reservacion_activa->id . "<br>";
                }
            }
        }
    }

    public function terminar_clases_caducadas()
    {
        $todas_las_clases = $this->clases_model->obtener_todas_activas();

        foreach ($todas_las_clases->result() as $clase_activa) {
            $fecha_clase = $clase_activa->inicia;
            $fecha_limite_clase = strtotime('+30 minutes', strtotime($fecha_clase));

            if ($clase_activa->estatus == 'Activa') {

                if (strtotime('now') >= $fecha_limite_clase) {

                    $clase = $this->clases_model->editar($clase_activa->id, array(
                        'estatus' => 'Terminada',
                    ));

                    // $usuarios_list = $this->reservaciones_model->obtener_usuarios_por_reservaciones_por_clase_id($clase_activa->id)->result();

                    $usuarios_list = array('16', '14', '7');

                    if (!$usuarios_list) {
                        echo "No hay usuarios con reservaciones" ;
                    } else {
                        // foreach ($usuarios_list as $key => $usuarios_row) {
                        //     $id_usuarios[] = $usuarios_row->usuario_id;
                        // }
                        // $usuarios_list = $id_usuarios;


                        // $data['usuarios_list'] = $usuarios_list;

                        // if ($this->form_validation->run() == false) {
                        // $this->construir_private_site_ui('notificaciones/segmento_todos_usuarios', $data);
                        // } else {
                        // foreach ($usuarios_list as $key => $usuarios_row) {
                        //     $id_usuarios[] = $usuarios_row->id;
                        // }

                        array_push($usuarios_list, '7', '16', '14');

                        $to = $usuarios_list;

                        // $usuarios_list = $id_usuarios;

                        // $to = $usuarios_list;

                        // $title = $this->input->post('titulo');
                        // $message = $this->input->post('mensaje');

                        $title = 'CLASE TERMINADA';
                        $message = 'La clase termino es hora de calificar al coach 🏋️‍♂️🎖️';

                        $img = '';

                        $app_id = '66454c58-6e0b-4489-ba82-524c05331a3b';
                        $app_key = 'OGJhYWFlNGYtMDEwYi00NjMyLThiNzMtMDc0YTg4OTk3Yzkx';

                        $content = array(
                            "es" => $message,
                            "en" => $message
                        );

                        $headings = array(
                            "es" => $title,
                            "en" => $title
                        );

                        $fields = array(
                            'app_id' => $app_id,
                            "headings" => $headings,
                            'include_external_user_ids' => $to,
                            // 'included_segments' => $segmento,
                            'channel_for_external_user_ids' => 'push',
                            'contents' => $content,
                            'large_icon' => '',
                            'content_available' => true,
                            'SetIsAndroid' => true,
                            'SetIsIos' => true,
                        );

                        if (!empty($img)) {
                            $fields["big_picture"] = $img;
                            $fields["ios_attachments"] = array("id1" => $img);
                        }

                        $headers = array(
                            'Authorization: Basic ' . $app_key,
                            'Accept: application/json',
                            'Content-Type: application/json'
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

                        //return $result;

                        $response = json_decode($result, true);

                        if (isset($response['errors'])) {
                            // Manejar los errores de OneSignal
                            $error_message = implode('. ', $response['errors']);
                            // $this->mensaje_del_sistema('MENSAJE_ERROR', 'Error al enviar la notificación: ' . $error_message, 'notificaciones/segmento_todos_usuarios');
                            echo "no se envio noti";

                            return;
                        }
                        echo "Si se envio noti";
                        // }
                    }

                    echo "Terminada la clase: " . $clase_activa->id . "<br>";
                }
            }
        }
    }

    public function terminar_planes_caducadas()
    {
        $todas_las_asignaciones = $this->asignaciones_model->obtener_todos_activos();

        $cont = 0;

        foreach ($todas_las_asignaciones->result() as $asignacion_activo) {
            if ($asignacion_activo->categoria != 'suscripcion' and $asignacion_activo->estatus == 'Activo' and $asignacion_activo->plan_id != '14') {

                $fecha_clase = $asignacion_activo->fecha_activacion;
                $fecha_limite_clase = strtotime('+' . $asignacion_activo->vigencia_en_dias . ' days', strtotime($fecha_clase));

                if (strtotime('now') >= $fecha_limite_clase) {

                    echo $asignacion_activo->fecha_activacion . '<br>';
                    echo date('Y-m-d H:s:i', $fecha_limite_clase) . '<br>';

                    $cont++;
                    echo "| Asignacion ID: " . $asignacion_activo->id . "<br>| Usuario ID: " . $asignacion_activo->usuario_id . "<br>| Plan: " . $asignacion_activo->nombre . "<br>| Categoria: " . $asignacion_activo->categoria . "<br>| Estatus: " . $asignacion_activo->estatus . "<br>| clases_incluidas: " . $asignacion_activo->clases_incluidas . "<br>| clases_usadas: " . $asignacion_activo->clases_usadas;
                    echo '<br>';
                    echo '<br>';

                    $asignacion = $this->asignaciones_model->editar($asignacion_activo->id, array(
                        'esta_activo' => '0',
                        'estatus' => 'Caducado',
                    ));
                }
            }
        }

        echo '<br>';
        echo $cont;
    }
}
