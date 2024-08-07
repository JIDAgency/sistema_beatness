<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Disciplinas_model extends CI_Model
{

    /** Nuevos metodos */

    /** Clases ONLINE */

    public function get_lista_de_disciplinas_online()
    {
        /*$query = $this->db
            ->where('sucursal_id', '1')
            ->where('id !=', '1')
            ->where('estatus', 'activo')
            ->get('disciplinas');*/
        $query = $this->db
            ->where('t1.sucursal_id', '1')
            ->where('t1.id !=', '1')
            ->where('t1.estatus', 'activo')
            ->select('
                t1.*,
                COUNT(t2.id) as cont,
            ')
            ->from('disciplinas t1')
            ->join('clases_streaming t2', 't2.disciplina_id = t1.id', 'left')
            ->group_by('t1.id')
            ->order_by('COUNT(t2.id)', 'desc')
            ->get();

        return $query;
    }

    /** Obtener todos los registros de la tabla de disciplinas */
    public function get_lista_de_todas_las_disciplinas()
    {
        $query = $this->db->get('disciplinas');
        return $query;
    }

    /** Obtener todas las disciplinas con la sucursal limitada a datos específicos*/
    public function get_lista_de_todas_las_disciplinas_limitada()
    {

        $query = $this->db
            ->order_by('t1.id', 'desc')
            ->select("
                t1.id as listar_id,
                t1.gympass_product_id as listar_gympass_product_id,
                t1.nombre as listar_nombre,
                CONCAT(COALESCE(t2.nombre, 'N/D'), ' - ', COALESCE(t2.locacion, 'N/D')) as listar_sucursal,
                t1.mostrar_en_app,
                t1.mostrar_en_web,
                t1.es_ilimitado,
                t1.formato,
                CONCAT(UPPER(SUBSTRING(t1.estatus, 1, 1)),LOWER(SUBSTRING(t1.estatus FROM 2))) as listar_estatus,
            ")
            ->from('disciplinas t1')
            ->join('sucursales t2', 't1.sucursal_id = t2.id')
            ->get();

        return $query;
    }

    /** //////////////////////////////////////////////////////////////////////////// Metodos del sistema //////////////////////////////////////////////////////////////////////////// */
    /** ////////////////////////////////////////////////////////////////////////////  Metodos para clases //////////////////////////////////////////////////////////////////////////// */
    public function get_lista_de_disciplinas_para_crear_y_editar_clases()
    {
        return $this->db
            ->get('disciplinas');
    }
    /** ////////////////////////////////////////////////////////////////////////////  Metodos para clases //////////////////////////////////////////////////////////////////////////// */
    /** //////////////////////////////////////////////////////////////////////////// Metodos del sistema //////////////////////////////////////////////////////////////////////////// */
    /** //////////////////////////////////////////////////////////////////////////// Métodos básicos para la APP //////////////////////////////////////////////////////////////////////////// */

    public function obtener_disponibles_por_sucursal($id)
    {
        $query = $this->db
            ->from('disciplinas')
            ->where('estatus', 'activo')
            ->where('sucursal_id', intval($id))
            ->where('mostrar_en_app', 'si')
            ->get();
        return $query;
    }

    /** Disciplinas para clases Online */
    public function get_disciplinas_para_clases_online()
    {
        $query = $this->db
            ->where_in('id', ['10', '11', '12', '13', '14'])
            ->get('disciplinas');

        return $query;
    }

    public function get_disciplinas_para_venta_personalizada()
    {
        $query = $this->db
            ->where('estatus', 'activo')
            ->where('sucursal_id !=', '1')
            ->get('disciplinas');

        return $query;
    }

    /**
     * App
     */

    public function obtener_disciplinas_para_app()
    {
        $query = $this->db
            ->where('estatus', 'activo')
            ->where('mostrar_en_app', 'si')
            ->get('disciplinas');

        return $query;

        /** ====== Query anterior de app v.2.3.3 ======  */
        /*
        return $this->db
        ->where('estatus', 'activo')
        ->where_in('id', ['2','5','8','9','15','16'])
        ->get('disciplinas');
        */
    }

    public function obtener_por_nombre($nombre)
    {
        $query = $this->db
            ->where('nombre', $nombre)
            ->select('t1.id')
            ->from('disciplinas t1')
            ->get();
        return $query;
    }

    /** Viejos metodos ****************************************************************************************** */
    public function obtener_todas()
    {
        return $this->db->where('estatus', 'activo')->get('disciplinas');
    }

    public function obtener_por_id($id)
    {
        return $this->db->where('id', intval($id))->get('disciplinas');
    }

    public function crear($data)
    {
        return $this->db->insert('disciplinas', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('disciplinas', $data);
    }

    public function obtener_disciplinas_por_id($id) {
        $this->db->where_in('id', $id);
        $query = $this->db->get('disciplinas');
        return $query->result();
    }
}
