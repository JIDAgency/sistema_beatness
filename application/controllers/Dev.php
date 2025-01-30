<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dev extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('user_agent');
    }

    public function index()
    {
        echo 'Dev';
        echo '<br>';
        $this->db->select('t1.*');
        $this->db->from('asignaciones t1');
        $this->db->join('planes t2', 't2.id = t1.plan_id', 'left');
        $this->db->where('t1.esta_activo', '1');
        $this->db->where('t2.sucursal_id', '2');
        $this->db->where_not_in('t1.plan_id', array('103', '108'));
        //$this->db->where('t1.id', '15804');
        $this->db->order_by('id', 'desc');
        $asignaciones_list = $this->db->get()->result();
        $cont = 0;
        foreach ($asignaciones_list as $asignacion_key => $asignacion_value) {
            echo 'ID: ' . $asignacion_value->id;
            echo '<br>';
            echo 'Plan ID: ' . $asignacion_value->plan_id;
            echo '<br>';
            echo 'Disciplinas: ' . $asignacion_value->disciplinas;
            echo '<br>';
            echo 'Disciplinas: 2|3|4|5|6|7|22|23';
            // echo '<br>';
            // echo 'Update: ' . $this->db
            //     ->where('id', $asignacion_value->id)
            //     ->update('asignaciones', array('disciplinas' => '2|3|4|5|6|7|22|23'));
            echo '<br>';
            echo '<br>';
            $cont++;
        }
        echo 'Planes: ' . $cont;
    }
}

// Planes activos: 2069
// Planes activos de puebla: 798
// Planes activos modificados de puebla: 794
// Disciplinas: 2|3|4|5|6|7|22|23