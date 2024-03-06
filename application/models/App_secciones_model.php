<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_secciones_model extends CI_Model {

    /** Metodos Basicos [Inicio] */
    public function get_app_secciones(){
        $query = $this->db
            ->get('app_secciones');

        return $query;
    }

    public function get_app_seccion_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('app_secciones');
        
        return $query;
    }

    public function insert_app_seccion($data)
    {
        $query = $this->db
            ->insert('app_secciones', $data);

        return $query;
    }

    public function insert_matriz_app_secciones($data)
    {
        $query = $this->db
            ->insert_batch('app_secciones', $data);

        return $query;
    }

    public function insert_matriz_app_secciones_imagenes($data)
    {
        $query = $this->db
            ->insert_batch('app_secciones', $data);

        return $query;
    }

    public function update_app_seccion($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('app_secciones', $data);

        return $query;
    }
    /** Metodos Basicos [Fin] */
    
    public function get_app_seccion_por_seccion($seccion)
    {
        $query = $this->db
            ->where('seccion', $seccion)
            ->get('app_secciones');
        
        return $query;
    }

}
