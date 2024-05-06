<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sucursales_model extends CI_Model
{

    /** Funciones generales (Inicio) */
    public function get_todas_las_sucursales()
    {
        $query = $this->db
            ->get('sucursales');

        return $query;
    }

    /** Método para obtener una fila por su id */
    public function get_sucursal_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('sucursales');

        return $query;
    }

    /** Método para crear una nueva fila */
    public function insert_sucursal($data)
    {
        $query = $this->db
            ->insert('sucursales', $data);

        return $query;
    }

    /** Método para editar una fila existente */
    public function update_sucursal($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('sucursales', $data);

        return $query;
    }
    /** Funciones generales (Fin) */

    /** Funciones de ventas controller (Inicio) */
    public function get_sucursales_para_select_de_ventas()
    {
        $query = $this->db
            ->where_in('id', array('2', '3', '4'))
            ->where('estatus', 'activo')
            ->from('sucursales')
            ->order_by("orden_mostrar", "asc")
            ->get();

        return $query;
    }
    /** Funciones de ventas controller (Fin) */

    public function get_sucursales_disponibles()
    {
        $query = $this->db
            ->where('id !=', 1)
            ->where('estatus', 'activo')
            ->from('sucursales')
            ->order_by("orden_mostrar", "asc")
            ->get();
        return $query;
    }

    public function obtener_sucurales_disponibles_para_app()
    {
        $query = $this->db
            ->where('id !=', 1)
            ->where('estatus', 'activo')
            ->where('visible_app', 'si')
            ->from('sucursales')
            ->order_by("orden_mostrar", "asc")
            ->get();
        return $query;
    }
}
