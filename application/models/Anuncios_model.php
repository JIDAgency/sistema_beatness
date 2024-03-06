<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncios_model extends CI_Model {

    /** Metodos Basicos [Inicio] */
    public function get_anuncios(){
        $query = $this->db
            ->get('anuncios');

        return $query;
    }

    public function get_anuncio_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('anuncios');
        
        return $query;
    }

    public function insert_anuncio($data)
    {
        $query = $this->db
            ->insert('anuncios', $data);

        return $query;
    }

    public function insert_matriz_anuncios($data)
    {
        $query = $this->db
            ->insert_batch('anuncios', $data);

        return $query;
    }

    public function insert_matriz_anuncios_imagenes($data)
    {
        $query = $this->db
            ->insert_batch('anuncios_imagenes', $data);

        return $query;
    }

    public function update_anuncio($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('anuncios', $data);

        return $query;
    }
    /** Metodos Basicos [Fin] */

    public function get_anuncio_por_tipo($tipo)
    {
        $query = $this->db
            ->where('tipo', strval($tipo))
            ->get('anuncios');
        
        return $query;
    }
}