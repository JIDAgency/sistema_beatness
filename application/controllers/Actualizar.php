<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Actualizar extends CI_Controller 
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('asignaciones_model');
    }
    
    public function index()
    {      
        //$this->actualizar_asignaciones_covid();
        redirect(base_url());
    }

    /*public function actualizar_asignaciones_covid()
    {
        $asignaciones_list = $this->asignaciones_model->get_todas_las_asignaciones_activas_sin_suscripciones()->result();
        $cont = 1;
        $result_procesados = 0;
        $result_no_procesados = 0;

        echo '<========================= Ejecución =========================>';
        echo '<br>';
        echo '<br>';

        foreach ($asignaciones_list as $asignacion_row) {
            
            echo $cont.' - '.$asignacion_row->nombre.' #'.$asignacion_row->id.' C.I.: '.$asignacion_row->clases_incluidas.' C.U.: '.$asignacion_row->clases_usadas.' Fecha de activación: '.date('d/m/Y', strtotime($asignacion_row->fecha_activacion));
            echo '<br>';

            if ($asignacion_row->clases_incluidas > $asignacion_row->clases_usadas) {

                echo 'Fecha de activación actualizada: '.date('d/m/Y H:i:s', strtotime('2020-09-15 07:00:00')).'<br>';

                $asignacion = $this->asignaciones_model->editar($asignacion_row->id, array(
                    'fecha_activacion' => '2020-09-15 07:00:00',
                ));

                $result_procesados++;
                echo 'Procesado... #'.$result_procesados;
            } else {
                $result_no_procesados++;
                echo 'No procesado... #'.$result_no_procesados;
            }

            echo '<br>';
            echo '<br>';
            $cont++;
        }

        echo 'Terminado <br>';
        echo 'Procesados: '.$result_procesados.'<br>';
        echo 'No procesados: '.$result_no_procesados.'<br>';

        $asignaciones_list_comprobacion = $this->asignaciones_model->get_todas_las_asignaciones_activas_sin_suscripciones()->result();
        
        $cont = 1;
        $result_procesados = 0;
        $result_no_procesados = 0;

        echo '<br>';
        echo '<========================= Comprobación =========================>';
        echo '<br>';
        echo '<br>';

        foreach ($asignaciones_list_comprobacion as $asignacion_row_comprobacion) {
            
            echo $cont.' - '.$asignacion_row_comprobacion->nombre.' #'.$asignacion_row_comprobacion->id.' C.I.: '.$asignacion_row_comprobacion->clases_incluidas.' C.U.: '.$asignacion_row_comprobacion->clases_usadas.' Fecha de activación: '.date('d/m/Y', strtotime($asignacion_row_comprobacion->fecha_activacion));
            echo '<br>';
            if ($asignacion_row_comprobacion->clases_incluidas > $asignacion_row_comprobacion->clases_usadas) {
                $result_procesados++;
                echo 'Procesado... #'.$result_procesados;
            } else {
                $result_no_procesados++;
                echo 'No procesado... #'.$result_no_procesados;
            }
            echo '<br>';
            echo '<br>';

            $cont++;
        }
        
    }*/

}