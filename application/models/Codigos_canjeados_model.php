<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Codigos_canjeados_model extends CI_Model {
    /** Funciones básicas */

    public function get_codigos_canjeados() {
        $query = $this->db
            ->get('codigos_canjeados');

        return $query;
    }

    /** Método para obtener una fila por su id */
    public function get_codigo_canjeado_por_id($id) {
        $query = $this->db
            ->where('id', intval($id))
            ->get('codigos_canjeados');
        
        return $query;
    }

    /** Método para crear una nueva fila */
    public function insert_codigo_canjeado($data) {
        $query = $this->db
            ->insert('codigos_canjeados', $data);

        return $query;
    }

    /** Método para editar una fila existente */
    public function update_codigo_canjeado($id, $data) {
        $query = $this->db
            ->where('id', $id)
            ->update('codigos_canjeados', $data);

        return $query;
    }
    
    /** Funciones personalizadas */

    public function obtener_codigo_canjeado_por_codigo($codigo) {
        $query = $this->db
            ->where('codigo', trim(strval(mb_strtolower($codigo))))
            ->get('codigos_canjeados');
        
        return $query;
    }

    public function obtener_codigo_canjeado_por_usuario_id($usuario_id) {
        $query = $this->db
            ->where('usuario_id', $usuario_id)
            ->get('codigos_canjeados');
        
        return $query;
    }

    public function obtener_codigo_canjeado_por_codigo_y_usuario_id($codigo, $usuario_id) {
        $query = $this->db
            ->where('codigo', trim(strval(mb_strtolower($codigo))))
            ->where('usuario_id', $usuario_id)
            ->get('codigos_canjeados');
        
        return $query;
    }
}
