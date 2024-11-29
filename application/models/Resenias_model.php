<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Resenias_model extends CI_Model
{

    public function agregar($data) 
    {
        return $this->db->insert('resenias', $data);
    }
}
