<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categorias_model extends CI_Model
{
    /** Funciones básicas */

    public function get_categorias()
    {
        $query = $this->db
            ->get('categorias');

        return $query;
    }

    /** Método para obtener una fila por su id */
    public function get_categoria_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('categorias');
        
        return $query;
    }

    /** Método para crear una nueva fila */
    public function insert_categoria($data)
    {
        $query = $this->db
            ->insert('categorias', $data);

        return $query;
    }

    /** Método para editar una fila existente */
    public function update_categoria($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('categorias', $data);

        return $query;
    }
    
    /** Funciones personalizadas */

    public function get_categorias_activos() {
        $query = $this->db
            ->where('estatus', 'activo')
            ->get('categorias');

        return $query;
    }

    public function obtener_categoria_por_codigo($codigo) {
        $query = $this->db
            ->where('codigo', trim(strval(mb_strtolower($codigo))))
            ->get('categorias');
        
        return $query;
    }

    public function obtener_categoria_por_identificador($identificador) {
        $query = $this->db
            ->where('identificador', trim(strval($identificador)))
            ->get('categorias');
        
        return $query;
    }

    public function eliminar_categoria_por_identificador($identificador) {
        $query = $this->db
            ->where('identificador', trim(strval($identificador)))
            ->delete('categorias');

        return $query;
    }

    public function obtener_por_id($id)
    {
        return $this->db->where('id', intval($id))->get('categorias');
    }

    public function crear($data)
    {
        return $this->db->insert('categorias', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('categorias', $data);
    }
}
