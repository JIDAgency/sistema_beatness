<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Membresias_model extends CI_Model
{
    public function obtener_todas()
    {
        return $this->db->get('membresias');
    }

    public function obtener_por_id($id)
    {
        return $this->db->where('id', intval($id))->get('membresias');
    }

    public function crear($data)
    {
        return $this->db->insert('membresias', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('membresias', $data);
    }

}