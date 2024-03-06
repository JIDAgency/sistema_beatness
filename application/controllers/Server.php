<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Server extends CI_Controller 
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('reservaciones_model');
        $this->load->model('asignaciones_model');
        $this->load->model('clases_model');
	}
    
    public function index() {      
        //$this->terminar_caducadas();
        //$this->terminar_clases_caducadas();
        //$this->terminar_planes_caducadas();
    }

    public function terminar_caducadas() {
        $todas_las_reservaciones = $this->reservaciones_model->obtener_todas_activas();

        foreach($todas_las_reservaciones->result() as $reservacion_activa) {
            $clase_a_consultar = $this->clases_model->obtener_por_id($reservacion_activa->clase_id)->row();

            $fecha_clase = $clase_a_consultar->inicia;
            $fecha_limite_clase = strtotime('+120 minutes', strtotime($fecha_clase));

            if ($reservacion_activa->estatus == 'Activa') {
                
                if (strtotime('now') >= $fecha_limite_clase) {

                    $reservacion = $this->reservaciones_model->editar($reservacion_activa->id, array(
                        'estatus' => 'Terminada',
                    ));

                    echo "Terminada la reservacion: ".$reservacion_activa->id."<br>";
                }
            }
        }
    }

    public function terminar_clases_caducadas() {
        $todas_las_clases = $this->clases_model->obtener_todas_activas();

        foreach($todas_las_clases->result() as $clase_activa) {
            $fecha_clase = $clase_activa->inicia;
            $fecha_limite_clase = strtotime('+30 minutes', strtotime($fecha_clase));

            if ($clase_activa->estatus == 'Activa') {
                
                if (strtotime('now') >= $fecha_limite_clase) {

                    $clase = $this->clases_model->editar($clase_activa->id, array(
                        'estatus' => 'Terminada',
                    ));

                    echo "Terminada la clase: ".$clase_activa->id."<br>";
                }
            }
        }
    }

    public function terminar_planes_caducadas() {
        $todas_las_asignaciones = $this->asignaciones_model->obtener_todos_activos();

        $cont = 0;

        foreach($todas_las_asignaciones->result() as $asignacion_activo) {
            if ($asignacion_activo->categoria != 'suscripcion' AND $asignacion_activo->estatus == 'Activo' AND $asignacion_activo->plan_id != '14') {

                $fecha_clase = $asignacion_activo->fecha_activacion;
                $fecha_limite_clase = strtotime('+'.$asignacion_activo->vigencia_en_dias.' days', strtotime($fecha_clase));

                if (strtotime('now') >= $fecha_limite_clase) {

                    echo $asignacion_activo->fecha_activacion.'<br>';
                    echo date('Y-m-d H:s:i', $fecha_limite_clase).'<br>';

                    $cont++;
                    echo "| Asignacion ID: ".$asignacion_activo->id."<br>| Usuario ID: ".$asignacion_activo->usuario_id."<br>| Plan: ".$asignacion_activo->nombre."<br>| Categoria: ".$asignacion_activo->categoria."<br>| Estatus: ".$asignacion_activo->estatus."<br>| clases_incluidas: ".$asignacion_activo->clases_incluidas."<br>| clases_usadas: ".$asignacion_activo->clases_usadas;
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