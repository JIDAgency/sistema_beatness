<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rel_planes_categorias_model extends CI_Model
{

    /** Métodos Básicos [Inicio] */
    public function obtener_rel_planes_categorias()
    {
        $query = $this->db
            ->get('rel_planes_categorias');

        return $query;
    }

    public function obtener_rel_plan_categoria_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('rel_planes_categorias');

        return $query;
    }

    public function obtener_rel_plan_categoria_por_identificador($identificador)
    {
        $query = $this->db
            ->where('identificador', $identificador)
            ->get('rel_planes_categorias');

        return $query;
    }

    public function insertar_rel_plan_categoria($data)
    {
        $query = $this->db
            ->insert('rel_planes_categorias', $data);

        return $query;
    }

    public function insertar_matriz_rel_planes_categorias($data)
    {
        $query = $this->db
            ->insert_batch('rel_planes_categorias', $data);

        return $query;
    }

    public function actualizar_rel_plan_categoria_por_id($id, $data)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->update('rel_planes_categorias', $data);

        return $query;
    }

    public function actualizar_rel_plan_categoria_por_identificador($identificador, $data)
    {
        $query = $this->db
            ->where('identificador', $identificador)
            ->update('rel_planes_categorias', $data);

        return $query;
    }
    /** Métodos Básicos [Fin] */
}
