<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Filtros_model extends CI_Model
{
    public function obtener_sucursales() {
        $query = $this->db
            ->where("t1.id != 1" )
            ->select('
                t1.id,
                t1.locacion
            ')
            ->from('sucursales t1')
            ->get();

        return $query;
    }
}
