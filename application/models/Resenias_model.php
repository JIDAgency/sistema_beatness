<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resenias_model extends CI_Model
{

    public function agregar($data) 
    {
        return $this->db->insert('resenias', $data);
    }

    public function obtener_tabla_resenias() 
    {
        // return $this->db->get('resenias');
        $query = $this->db
            ->select('t1.*,
                      t2.nombre_completo as coach,
                      t3.dificultad,
                      t4.nombre')
            ->from('resenias t1')
            ->join('usuarios t2', 't2.id = t1.instructor_id')
            ->join('clases t3', 't3.id = t1.clase_id')
            ->join('disciplinas t4', 't4.id = t3.disciplina_id')
            ->get();

        return $query;
    }

    public function obtener_por_clase_id($id)
    {
        $query = $this->db
            ->where('t1.clase_id', $id)
            ->select('t1.*,
                      t2.dificultad,
                      t2.inicia,
                      t3.nombre,
                      t4.nombre_completo as coach,
                      t4.correo as coach_correo,
                      t4.nombre_imagen_avatar as coach_foto,
            ')
            ->from('resenias t1')
            ->join('clases t2', "t2.id = t1.clase_id")
            ->join('disciplinas t3', "t3.id = t2.disciplina_id")
            ->join('usuarios t4', "t4.id = t2.instructor_id")
            ->order_by('t1.id', 'desc')
            ->limit(5)
            ->get();
        return $query;
    }

    public function obtener_por_coach_id($id)
    {
        $query = $this->db
            ->where('t1.instructor_id', $id)
            ->select('t1.*,
                      t2.dificultad,
                      t2.inicia,
                      t3.nombre,
                      t4.nombre_completo as coach,
                      t4.correo as coach_correo,
                      t4.nombre_imagen_avatar as coach_foto,
            ')
            ->from('resenias t1')
            ->join('clases t2', "t2.id = t1.clase_id")
            ->join('disciplinas t3', "t3.id = t2.disciplina_id")
            ->join('usuarios t4', "t4.id = t2.instructor_id")
            ->order_by('t1.id', 'desc')
            ->limit(5)
            ->get(); 
        return $query;
    }
}
