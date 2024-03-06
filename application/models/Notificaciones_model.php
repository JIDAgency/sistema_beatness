<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones_model extends CI_Model {

    /** Metodos Basicos [Inicio] */
    public function get_notificaciones() {
        $query = $this->db
            ->get('notificaciones');

        return $query;
    }

    public function get_notificacion_por_id($id) {
        $query = $this->db
            ->where('id', intval($id))
            ->get('notificaciones');
        
        return $query;
    }

    public function insert_notificacion($data) {
        $query = $this->db
            ->insert('notificaciones', $data);

        return $query;
    }

    public function insert_matriz_notificaciones($data) {
        $query = $this->db
            ->insert_batch('notificaciones', $data);

        return $query;
    }

    public function update_notificacion($id, $data) {
        $query = $this->db
            ->where('id', $id)
            ->update('notificaciones', $data);

        return $query;
    }
    /** Metodos Basicos [Fin] */

    public function obtener_usuarios_que_si_han_comprado_los_ultimos_dos_meses() {
        $fecha_dos_meses = date("Y-m-d", strtotime("-2 months"));
        $query = $this->db
        ->select("
            t1.*,
            t2.id as asignaciones_id,
            t2.fecha_activacion as asignaciones_fecha_activacion,
        ")
        ->from("usuarios t1")
        ->join("asignaciones t2", "t1.id = t2.usuario_id", "left")
        ->where("DATE_FORMAT(t2.fecha_activacion,'%Y-%m-%d') >=", $fecha_dos_meses)
        ->group_by("t1.id")
        ->order_by("t1.id")
        ->get();

        return $query;
	}
    
    public function obtener_usuarios_que_no_han_comprado_los_ultimos_dos_meses($array) {
        $query = $this->db
        ->select("
            t1.*,
            t2.id as asignaciones_id,
            t2.nombre as asignaciones_nombre,
            t2.fecha_activacion as asignaciones_fecha_activacion,
        ")
        ->from("usuarios t1")
        ->join("asignaciones t2", "t1.id = t2.usuario_id", "left")
        ->where_not_in('t1.id', $array)
        ->group_by("t1.id")
        ->order_by("t1.id")
        ->get();

        return $query;
	}
}
