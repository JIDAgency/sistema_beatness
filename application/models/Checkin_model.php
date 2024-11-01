<?php defined('BASEPATH') or exit('No direct script access allowed');

class Checkin_model extends CI_Model
{
    public function obtener_todos_checkins() 
    {
        $query = $this->db
            ->get('checkin');
        return $query;
    }
}
