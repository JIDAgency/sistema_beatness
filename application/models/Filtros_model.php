<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Filtros_model extends CI_Model
{
    public function obtener_sucursales()
    {
        $query = $this->db
            ->where("t1.id != 1")
            ->select('
                t1.id,
                t1.locacion
            ')
            ->from('sucursales t1')
            ->get();

        return $query;
    }

    public function obtener_disciplinas($sucursal_id = null)
    {
        if ($this->session->userdata('filtro_clase_sucursal') == null || $this->session->userdata('filtro_clase_sucursal') == 0) {
            $query = $this->db
                ->where("t1.id != 1")
                ->select('
                t1.id,
                t1.sucursal_id,
                t1.nombre
            ')
                ->from('disciplinas t1')
                ->get();

            return $query;
        } else {
            if ($this->session->userdata('filtro_clase_sucursal') != null) {
                $sucursal_id = $this->session->userdata('filtro_clase_sucursal');
            }

            $query = $this->db
                ->where("t1.id != 1")
                ->where("sucursal_id", $sucursal_id)
                ->select('
                    t1.id,
                    t1.sucursal_id,
                    t1.nombre
                ')
                ->from('disciplinas t1')
                ->get();

            return $query;
        }
    }
}
