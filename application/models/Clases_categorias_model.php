<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clases_categorias_model extends CI_Model
{
    public function obtener_todas()
    {
        $query = $this->db
            ->select('t1.*,
            t2.nombre as nombre_disciplina')
            ->from("clases_categorias t1")
            ->join("disciplinas t2", "t2.id = t1.disciplina_id")
            ->get();

        return $query;
    }

    public function obtener_dificultades($disciplina_id)
    {
        $query = $this->db
            ->where('t1.disciplina_id', $disciplina_id)
            ->select('t1.*,
            t2.nombre as nombre_disciplina')
            ->from("clases_categorias t1")
            ->join("disciplinas t2", "t2.id = t1.disciplina_id")
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

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('clases_categorias', $data);
    }

    public function borrar($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('clases_categorias'); {
            return true;
        }
    }
}
