<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clases_categorias_model extends CI_Model
{
    public function obtener_todas()
    {
        $query = $this->db
            ->select('t1.*')
            ->from("clases_categorias t1")
            ->get();

        return $query;
    }

    public function crear($data)
    {
        return $this->db->insert('clases_categorias', $data);
    }

    public function obtener_por_id($id)
    {
        return $this->db->select('
                t1.*, 
                t3.nombre as disciplina_nombre,
                ')
            ->from('clases_categorias as t1')
            ->join("disciplinas t3", "t1.disciplina_id = t3.id")
            ->where('t1.id', intval($id))
            ->get();
    }
}
