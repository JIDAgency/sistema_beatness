<?php defined('BASEPATH') or exit('No direct script access allowed');

class Checkin_model extends CI_Model
{
    public function obtener_todos_checkin()
    {
        $query = $this->db
            ->get('checkin');
        return $query;
    }

    public function obtener_todos_checkins()
    {
        $query = $this->db
            ->select('t1.*, 
                CONCAT(COALESCE(t2.nombre_completo, \'N/D\'), \' \', COALESCE(t2.apellido_paterno, \'N/D\'), \' \', COALESCE(t2.apellido_materno, \'N/D\')) AS nombre_usuario,
                t2.nombre_imagen_avatar as usuario_nombre_imagen_avatar,
                t2.correo,
                ')
            ->from('checkin as t1')
            ->join('usuarios as t2', 't2.id = t1.usuario_id')
            ->get();
        return $query;
    }

    public function actualizar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('checkin', $data);
    }
}
