<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planes_categorias_model extends CI_Model
{
    /** Funciones básicas */

    public function get_planes_categorias()
    {
        $query = $this->db
            ->get('planes_categorias');

        return $query;
    }

    /** Método para obtener una fila por su id */
    public function get_categoria_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('planes_categorias');

        return $query;
    }

    /** Método para crear una nueva fila */
    public function insert_categoria($data)
    {
        $query = $this->db
            ->insert('planes_categorias', $data);

        return $query;
    }

    /** Método para editar una fila existente */
    public function update_categoria($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('planes_categorias', $data);

        return $query;
    }

    /** Funciones personalizadas */

    public function obtener_categorias_planes_por_sucursal()
    {
        $query = $this->db
            ->where('t1.estatus', 'activo')
            ->select('
            t1.*,
            t4.sucursal_id as disciplinas_sucursal_id,
        ')
            ->from('planes_categorias t1')
            ->join('rel_planes_categorias t2', 't2.categoria_id = t1.id')
            ->join('planes_disciplinas t3', 't3.plan_id = t2.plan_id')
            ->join('disciplinas t4', 't4.id = t3.disciplina_id')
            ->group_by(array("t1.id", "t4.sucursal_id"))
            ->order_by('t1.orden', 'asc')
            ->get();

        return $query;
    }

    public function get_categorias_activos()
    {
        $query = $this->db
            ->where('estatus', 'activo')
            ->get('planes_categorias');

        return $query;
    }

    public function obtener_categoria_por_codigo($codigo)
    {
        $query = $this->db
            ->where('codigo', trim(strval(mb_strtolower($codigo))))
            ->get('planes_categorias');

        return $query;
    }

    public function obtener_categoria_por_identificador($identificador)
    {
        $query = $this->db
            ->where('identificador', trim(strval($identificador)))
            ->get('planes_categorias');

        return $query;
    }

    public function eliminar_categoria_por_identificador($identificador)
    {
        $query = $this->db
            ->where('identificador', trim(strval($identificador)))
            ->delete('planes_categorias');

        return $query;
    }

    public function obtener_todas()
    {
        return $this->db->get('planes_categorias');
    }

    public function obtener_por_id($id)
    {
        return $this->db->where('id', intval($id))->get('planes_categorias');
    }

    public function crear($data)
    {
        return $this->db->insert('planes_categorias', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('planes_categorias', $data);
    }
}
