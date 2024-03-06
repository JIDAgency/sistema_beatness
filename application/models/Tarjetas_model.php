<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarjetas_model extends CI_Model
{
    public function get_todas_las_tarjetas()
    {
        $query = $this->db
            ->get('tarjetas');

        return $query;
    }

    public function get_tarjeta_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('tarjetas');

        return $query;
    }

    public function insert_tarjeta($data)
    {
        $query = $this->db
            ->insert('tarjetas', $data);

        return $query;
    }

    public function update_tarjeta($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('tarjetas', $data);

        return $query;
    }

    public function delete_tarjeta($id)
    {
        $this->db->where('id', $id)->delete('tarjetas');
        {return true;}
    }

    /** Shop methods */
        public function get_tarjetas_por_usuario_id($id = null)
        {
            $query = $this->db
            ->where('usuario_id', intval($id))
            ->where('estatus', 'activo')
            ->get('tarjetas');

            return $query;
        }

        public function get_tarjeta_id_por_usuario_id($tarjeta_id, $usuario_id)
        {
            $query = $this->db
            ->where('id', intval($tarjeta_id))
            ->where('usuario_id', intval($usuario_id))
            ->where('estatus', 'activo')
            ->get('tarjetas');

            return $query;
        }

        public function get_tarjeta_por_openpay_id_por_usuario_id($tarjeta_id, $usuario_id)
        {
            $query = $this->db
            ->where('openpay_tarjeta_id', $tarjeta_id)
            ->where('usuario_id', intval($usuario_id))
            ->where('estatus', 'activo')
            ->get('tarjetas');

            return $query;
        }
    /** Shop methods */
}