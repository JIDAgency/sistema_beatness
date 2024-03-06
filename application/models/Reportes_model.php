<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reportes_model extends CI_Model {

    function obtener_reporte_de_instructores_entre_fechas($fecha_inicio, $fecha_fin) {
        $query = $this->db
            ->where('t1.estatus !=', 'Cancelada')
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") >=', date('Y-m-d', strtotime($fecha_inicio)))
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") <=', date('Y-m-d', strtotime($fecha_fin)))
            //->where('t1.reservado >=', 3)
            ->select("
                t1.instructor_id, SUM(t1.reservado) as total_reservado,
                t1.instructor_id, COUNT(t1.instructor_id) as total_clases,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as instructor_nombre,
            ")
            ->from("clases t1")
            ->join("usuarios t2", "t2.id = t1.instructor_id")
            ->group_by('t1.instructor_id')
            ->order_by('t2.nombre_completo', 'asc')
            ->get();

        return $query;
    }

    function obtener_reporte_de_instructores_por_mes($fecha) {
        $query = $this->db
            ->where('t1.estatus !=', 'Cancelada')
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m")', $fecha)
            //->where('t1.reservado >=', 3)
            ->select("
                t1.instructor_id, SUM(t1.reservado) as total_reservado,
                t1.instructor_id, COUNT(t1.instructor_id) as total_clases,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as instructor_nombre,
            ")
            ->from("clases t1")
            ->join("usuarios t2", "t2.id = t1.instructor_id")
            ->group_by('t1.instructor_id')
            ->order_by('t2.nombre_completo', 'asc')
            ->get();

        return $query;
    }
}
