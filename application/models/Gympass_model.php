<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gympass_model extends CI_Model
{
    // ====== Disciplinas ======

    function disciplinas_obtener()
    {
        $query = $this->db
            ->get('disciplinas');

        return $query;
    }

    public function disciplina_editar($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('disciplinas', $data);

        return $query;
    }

    public function disciplina_esta_vinculado($gympass_product_id, $id)
    {
        $query = $this->db
            ->from('disciplinas')
            ->where('gympass_product_id', $gympass_product_id)
            ->where('id !=', $id)
            ->get();
        return $query->num_rows() > 0;
    }

    // ====== Categorías ======

    public function categorias_obtener()
    {
        $query = $this->db
            ->select('
                t1.*,
                t2.nombre as disciplinas_nombre,
                t2.gympass_product_id as disciplinas_gympass_product_id,
            ')
            ->from('clases_categorias t1')
            ->join("disciplinas t2", "t2.id = t1.disciplina_id")
            ->get();

        return $query;
    }

    public function categorias_obtener_por_id($id)
    {
        $query = $this->db
            ->where('t1.id', $id)
            ->select('
            t1.*,
            t2.nombre as disciplinas_nombre,
            t2.gympass_product_id as disciplinas_gympass_product_id,
        ')
            ->from('clases_categorias t1')
            ->join("disciplinas t2", "t2.id = t1.disciplina_id")
            ->get();

        return $query;
    }

    public function categoria_actualizar_por_id($id, $data)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->update('clases_categorias', $data);

        return $query;
    }


    // ====== Clases ======

    public function clases_obtener_activas()
    {
        $query = $this->db
            ->where('t1.estatus', 'Activa')
            ->select('
                t1.*,
                t2.nombre as disciplinas_nombre,
                CONCAT(COALESCE(t3.nombre_completo, "N/D"), " ", COALESCE(t3.apellido_paterno, "N/D")) as instructores_nombre,
                t4.locacion as sucursales_locacion,
            ')
            ->from('clases t1')
            ->join("disciplinas t2", "t2.id = t1.disciplina_id")
            ->join("usuarios t3", "t3.id = t1.instructor_id")
            ->join("sucursales t4", "t4.id = t2.sucursal_id")
            ->get();

        return $query;
    }
}
