<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reportes_model extends CI_Model
{

    function obtener_reporte_de_instructores_entre_fechas($fecha_inicio, $fecha_fin)
    {
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

    function obtener_reporte_de_instructores_por_mes($fecha)
    {
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

    function reporte_1()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_2()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $this->db->where('rol_id', '1');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_3()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $this->db->where('rol_id', '1');
        $this->db->where('gympass_user_id IS NOT NULL');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_4()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $this->db->where('rol_id', '1');
        $this->db->where('gympass_user_id IS NULL');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_5()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios t1');
        $this->db->join('asignaciones t2', 't1.id = t2.usuario_id');
        $this->db->where('t1.rol_id', '1');
        $this->db->where('t2.estatus', 'Activo');
        $this->db->where('t2.nombre !=', 'CLASE FITPASS CLASSIC PUEBLA');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_6()
    {
        $this->db->select('COUNT(DISTINCT t1.id) as total');
        $this->db->from('usuarios t1');
        $this->db->join('asignaciones t2', 't1.id = t2.usuario_id');
        $this->db->where('t2.estatus', 'Activo');
        $this->db->where('t2.nombre !=', 'CLASE FITPASS CLASSIC PUEBLA');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }
}
