<?php defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones_model extends CI_Model
{

    /** Metodos Basicos [Inicio] */
    public function get_notificaciones()
    {
        $query = $this->db
            ->get('notificaciones');

        return $query;
    }

    public function get_notificacion_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('notificaciones');

        return $query;
    }

    public function insert_notificacion($data)
    {
        $query = $this->db
            ->insert('notificaciones', $data);

        return $query;
    }

    public function insert_matriz_notificaciones($data)
    {
        $query = $this->db
            ->insert_batch('notificaciones', $data);

        return $query;
    }

    public function update_notificacion($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('notificaciones', $data);

        return $query;
    }
    /** Metodos Basicos [Fin] */

    public function obtener_usuarios_que_si_han_comprado_los_ultimos_dos_meses()
    {
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

    public function obtener_usuarios_que_no_han_comprado_los_ultimos_dos_meses($array)
    {
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

    public function obtener_usuarios_puebla_que_si_han_reservado_hace_una_semana()
    {
        $fecha_dos_meses = date("Y-m-d", strtotime("-5 days"));
        $query = $this->db
            ->where("t1.sucursal_id", 2)
            ->select("
            t1.*,
            t2.id as reservacion_id,
            t2.fecha_creacion as reservacion_fecha_creacion,
        ")
            ->from("usuarios t1")
            ->join("reservaciones t2", "t1.id = t2.usuario_id", "left")
            ->where("DATE_FORMAT(t2.fecha_creacion,'%Y-%m-%d') >=", $fecha_dos_meses)
            ->group_by("t1.id")
            ->order_by("t1.id")
            ->get();

        return $query;
    }

    public function obtener_usuarios_puebla_que_no_han_reservado_hace_una_semana($array)
    {
        $query = $this->db
            ->where("t1.sucursal_id", 2)
            ->select("
            t1.*,
            CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS usuarios_nombre,
            t2.id as reservacion_id,
            t2.fecha_creacion as reservacion_fecha_creacion,
            t3.descripcion as nombre_sucursal
        ")
            ->from("usuarios t1")
            ->join("reservaciones t2", "t1.id = t2.usuario_id", "left")
            ->join("sucursales t3", "t3.id = t1.sucursal_id")
            ->where_not_in('t1.id', $array)
            ->group_by("t1.id")
            ->order_by("t1.id")
            ->get();

        return $query;
    }

    public function obtener_usuarios_polanco_que_si_han_reservado_hace_una_semana()
    {
        $fecha_dos_meses = date("Y-m-d", strtotime("-5 days"));
        $query = $this->db
            ->where("t1.sucursal_id", 3)
            ->select("
            t1.*,
            t2.id as reservacion_id,
            t2.fecha_creacion as reservacion_fecha_creacion,
        ")
            ->from("usuarios t1")
            ->join("reservaciones t2", "t1.id = t2.usuario_id", "left")
            ->where("DATE_FORMAT(t2.fecha_creacion,'%Y-%m-%d') >=", $fecha_dos_meses)
            ->group_by("t1.id")
            ->order_by("t1.id")
            ->get();

        return $query;
    }

    public function obtener_usuarios_polanco_que_no_han_reservado_hace_una_semana($array)
    {
        $query = $this->db
            ->where("t1.sucursal_id", 3)
            ->select("
            t1.*,
            CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS usuarios_nombre,
            t2.id as reservacion_id,
            t2.fecha_creacion as reservacion_fecha_creacion,
            t3.descripcion as nombre_sucursal
        ")
            ->from("usuarios t1")
            ->join("reservaciones t2", "t1.id = t2.usuario_id", "left")
            ->join("sucursales t3", "t3.id = t1.sucursal_id")
            ->where_not_in('t1.id', $array)
            ->group_by("t1.id")
            ->order_by("t1.id")
            ->get();

        return $query;
    }

    public function obtener_usuarios_puebla_que_si_han_comprado_los_ultimos_dos_meses()
    {
        $fecha_dos_meses = date("Y-m-d", strtotime("-2 months"));
        $query = $this->db
            ->where("t1.sucursal_id", 2)
            ->select("
            t1.*,
            CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS usuarios_nombre,
            t2.id as asignaciones_id,
            t2.fecha_activacion as asignaciones_fecha_activacion,
            t3.descripcion as nombre_sucursal
        ")
            ->from("usuarios t1")
            ->join("asignaciones t2", "t1.id = t2.usuario_id", "left")
            ->join("sucursales t3", "t3.id = t1.sucursal_id")
            ->where("DATE_FORMAT(t2.fecha_activacion,'%Y-%m-%d') >=", $fecha_dos_meses)
            ->group_by("t1.id")
            ->order_by("t1.id")
            ->get();

        return $query;
    }

    public function obtener_usuarios_puebla_que_no_han_comprado_los_ultimos_dos_meses($array)
    {
        $query = $this->db
            ->where("t1.sucursal_id", 2)
            ->select("
            t1.*,
            CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS usuarios_nombre,
            t2.id as asignaciones_id,
            t2.nombre as asignaciones_nombre,
            t2.fecha_activacion as asignaciones_fecha_activacion,
            t3.descripcion as nombre_sucursal
        ")
            ->from("usuarios t1")
            ->join("asignaciones t2", "t1.id = t2.usuario_id", "left")
            ->join("sucursales t3", "t3.id = t1.sucursal_id")
            ->where_not_in('t1.id', $array)
            ->group_by("t1.id")
            ->order_by("t1.id")
            ->get();

        return $query;
    }

    public function obtener_usuarios_polanco_que_si_han_comprado_los_ultimos_dos_meses()
    {
        $fecha_dos_meses = date("Y-m-d", strtotime("-2 months"));
        $query = $this->db
            ->where("t1.sucursal_id", 3)
            ->select("
            t1.*,
            CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS usuarios_nombre,
            t2.id as asignaciones_id,
            t2.fecha_activacion as asignaciones_fecha_activacion,
            t3.descripcion as nombre_sucursal
            ")
            ->from("usuarios t1")
            ->join("asignaciones t2", "t1.id = t2.usuario_id", "left")
            ->join("sucursales t3", "t3.id = t1.sucursal_id")
            ->where("DATE_FORMAT(t2.fecha_activacion, '%Y-%m-%d') >=", $fecha_dos_meses)
            ->group_by("t1.id")
            ->order_by("t1.id")
            ->get();
        return $query;
    }

    public function obtener_usuarios_polanco_que_no_han_comprado_los_ultimos_dos_meses($array)
    {
        $query = $this->db
            ->where("t1.sucursal_id", 3)
            ->select("
            t1.*,
            CONCAT(COALESCE(t1.nombre_completo, 'N/D'), ' ', COALESCE(t1.apellido_paterno, 'N/D'), ' ', COALESCE(t1.apellido_materno, 'N/D')) AS usuarios_nombre,
            t2.id as asignaciones_nombre,
            t2.fecha_activacion as asignaciones_fecha_activacion,
            t3.descripcion as nombre_sucursal
            ")
            ->from("usuarios t1")
            ->join("asignaciones t2", "t1.id = t2.usuario_id", "left")
            ->join("sucursales t3", "t3.id = t1.sucursal_id")
            ->where_not_in('t1.id', $array)
            ->group_by("t1.id")
            ->order_by("t1.id")
            ->get();
        return $query;
    }
}
