<?php
defined('BASEPATH') or exit('No direct script access allowed');

class codigos_model extends CI_Model
{
    /** Funciones básicas */

    public function get_codigos()
    {
        $query = $this->db
            ->get('codigos');

        return $query;
    }

    /** Método para obtener una fila por su id */
    public function get_codigo_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('codigos');
        
        return $query;
    }

    /** Método para crear una nueva fila */
    public function insert_codigo($data)
    {
        $query = $this->db
            ->insert('codigos', $data);

        return $query;
    }

    /** Método para editar una fila existente */
    public function update_codigo($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('codigos', $data);

        return $query;
    }
    
    /** Funciones personalizadas */

    public function get_codigos_activos() {
        $query = $this->db
            ->where('estatus', 'activo')
            ->get('codigos');

        return $query;
    }

    public function obtener_codigo_por_codigo($codigo) {
        $query = $this->db
            ->where('codigo', trim(strval(mb_strtolower($codigo))))
            ->get('codigos');
        
        return $query;
    }

    public function obtener_codigo_por_identificador($identificador) {
        $query = $this->db
            ->where('identificador', trim(strval($identificador)))
            ->get('codigos');
        
        return $query;
    }

    public function eliminar_codigo_por_identificador($identificador) {
        $query = $this->db
            ->where('identificador', trim(strval($identificador)))
            ->delete('codigos');

        return $query;
    }
}
