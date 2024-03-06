<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuraciones_model extends CI_Model
{
    /** Funciones básicas */

    public function get_todas_las_configuraciones()
    {
        $query = $this->db
            ->get('configuraciones');

        return $query;
    }

    /** Método para obtener una fila por su id */
    public function get_configuracion_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('configuraciones');
        
        return $query;
    }

    /** Método para crear una nueva fila */
    public function insert_configuracion($data)
    {
        $query = $this->db
            ->insert('configuraciones', $data);

        return $query;
    }

    /** Método para editar una fila existente */
    public function update_configuracion($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('configuraciones', $data);

        return $query;
    }
    
    /** Funciones personalizadas */

    public function get_configuracion_por_configuracion($configuracion)
    {
        $query = $this->db
            ->where('configuracion', $configuracion)
            ->get('configuraciones');
        
        return $query;
    }

    public function update_configuracion_por_configuracion($configuracion, $data)
    {
        $query = $this->db
            ->where('configuracion', $configuracion)
            ->update('configuraciones', $data);

        return $query;
    }
}