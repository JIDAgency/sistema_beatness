<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendario_model extends CI_Model
{

    public function obtener_disciplinas()
    {
        $query = $this->db
            ->select('
                t1.*,
            ')
            ->from('disciplinas t1')
            ->get();

        return $query->result();
    }

    public function obtener_clases_semana_actual()
    {
        // Obtener la fecha de inicio y fin de la semana actual
        $fecha_inicio_semana = date('Y-m-d', strtotime('Monday this week'));
        $fecha_fin_semana = date('Y-m-d', strtotime('Friday this week'));
        $fecha_inicio_fin_de_semana = date('Y-m-d', strtotime('Saturday this week'));
        $fecha_fin_fin_de_semana = date('Y-m-d', strtotime('Sunday this week'));

        // Consulta para obtener las clases de la semana actual
        $query = $this->db
            ->select('
                t1.*,
                DATE_FORMAT(t1.inicia,"%H:%i") as hora_clase
            ')
            ->from('clases t1')
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") >=', $fecha_inicio_semana)
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") <=', $fecha_fin_semana)
            ->order_by('hora_clase', 'asc') // Ordenar por fecha de inicio
            ->get();

        return $query->result_array();
    }

    public function obtener_clases_semana_actual_por_disciplina_id($disciplina_id)
    {
        // Obtener la fecha de inicio y fin de la semana actual
        $fecha_inicio_semana = date('Y-m-d', strtotime('Monday this week'));
        $fecha_fin_semana = date('Y-m-d', strtotime('Friday this week'));

        // Consulta para obtener las clases de la semana actual
        $query = $this->db
            ->select('
                t1.*,
                DATE_FORMAT(t1.inicia,"%H:%i") as hora_clase
            ')
            ->from('clases t1')
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") >=', $fecha_inicio_semana)
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") <=', $fecha_fin_semana)
            ->order_by('hora_clase', 'asc') // Ordenar por fecha de inicio
            ->get();

        return $query->result_array();
    }

    public function obtener_clases_fin_de_semana_actual()
    {
        // Obtener la fecha de inicio y fin de la semana actual
        $fecha_inicio_semana = date('Y-m-d', strtotime('Saturday this week'));
        $fecha_fin_semana = date('Y-m-d', strtotime('Sunday this week'));

        // Consulta para obtener las clases de la semana actual
        $query = $this->db
            ->select('
                        t1.*,
                        DATE_FORMAT(t1.inicia,"%H:%i") as hora_clase
                    ')
            ->from('clases t1')
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") >=', $fecha_inicio_semana)
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") <=', $fecha_fin_semana)
            ->order_by('hora_clase', 'asc') // Ordenar por fecha de inicio
            ->get();

        return $query->result_array();
    }
}
