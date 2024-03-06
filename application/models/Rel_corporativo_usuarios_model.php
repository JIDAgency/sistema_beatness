<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rel_corporativo_usuarios_model extends CI_Model {

    /** Metodos Basicos [Inicio] */
    
    public function get_rel_corporativo_usuarios(){
        $query = $this->db
            ->get('rel_corporativo_usuarios');

        return $query;
    }

    public function get_rel_corporativo_por_id($id)
    {
        $query = $this->db
            ->where('id', intval($id))
            ->get('rel_corporativo_usuarios');
        
        return $query;
    }

    public function insert_rel_corporativo_usuario($data)
    {
        $query = $this->db
            ->insert('rel_corporativo_usuarios', $data);

        return $query;
    }

    public function insert_matriz_rel_corporativo_usuarios($data)
    {
        $query = $this->db
            ->insert_batch('rel_corporativo_usuarios', $data);

        return $query;
    }

    public function update_rel_corporativo_usuario($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('rel_corporativo_usuarios', $data);

        return $query;
    }

    /** Metodos Basicos [Fin] */

    public function get_rel_corporativo_usuario_por_usuario_id($usuario_id)
    {
        $query = $this->db
            ->where('usuario_id', intval($usuario_id))
            ->where('estatus', strval("activo"))
            ->get('rel_corporativo_usuarios');
        
        return $query;
    }

    public function get_los_usuarios_corporativos_por_corporativo_id($id)
    {
        $query = $this->db->select("
                t2.*,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS nombre,
                t3.tipo as rol
            ")
            ->from("rel_corporativo_usuarios t1")
            ->join("usuarios t2", "t1.usuario_id = t2.id")
            ->join("roles t3", "t2.rol_id = t3.id")
            //->where('t2.rol_id', intval(6))
            ->where('t1.corporativo_id', intval($id))
            ->get();

        return $query;
    }
}
