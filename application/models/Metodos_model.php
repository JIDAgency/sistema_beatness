<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metodos_model extends CI_Model {
    public function obtener_todos() {
        $query = $this->db
            ->order_by('nombre', 'asc')
            ->get('metodos_pago');
        return $query;
    }

    public function obtener_para_filtro() {
        $query = $this->db
            ->distinct()  // Asegura que los resultados sean únicos
            ->select("t1.metodo_id, t2.*")
            ->from('ventas t1')
            ->join('metodos_pago t2', 't1.metodo_id = t2.id')
            ->get();
        return $query;
    }

    public function obtener_todos_los_activos() {
        $query = $this->db
            ->where('estatus', 'activo')
            ->order_by('nombre', 'asc')
            ->get('metodos_pago');
        return $query;
    }
}
