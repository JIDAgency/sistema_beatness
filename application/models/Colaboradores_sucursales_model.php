<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Colaboradores_sucursales_model extends CI_Model
{
	/** //////////////////////////////////////////////////////////////////////////// Métodos básicos //////////////////////////////////////////////////////////////////////////// */

    /** Método para obtener todas las filas en una lista */
    public function get_todos_los_colaboradores_sucursales(){
        $query = $this->db
            ->get('colaboradores_sucursales');

        return $query;
    }

    /** Método para obtener una fila por su id */
    public function get_colaborador_sucursal_por_id($id)
    {
        $query = $this->db
            ->where('colaborador_id', intval($id))
            ->get('colaboradores_sucursales');
        
        return $query;
    }

    /** Método para crear una nueva fila */
    public function insert_colaborador_sucursal($data)
    {
        $query = $this->db
            ->insert('colaboradores_sucursales', $data);

        return $query;
    }

    /** Método para editar una fila existente */
    public function update_colaborador_sucursal($id, $data)
    {
        $query = $this->db
            ->where('colaborador_id', intval($id))
            ->update('colaboradores_sucursales', $data);

        return $query;
    }

    public function delete_colaborador_sucursal_por_id($id)
    {
        $query = $this->db
            ->where('colaborador_id', intval($id))
            ->delete('colaboradores_sucursales');

        return $query;
    }

}