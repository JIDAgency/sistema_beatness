<?php defined('BASEPATH') or exit('No direct script access allowed');

class Totalpass_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function obtener_token()
    {
        $query = $this->db
            ->where('configuracion', 'totalpass_token')
            ->get('configuraciones');

        return $query;
    }

    public function guardar_token($data)
    {
        $query = $this->db
            ->where('configuracion', 'totalpass_token')
            ->update('configuraciones', $data);

        return $query;
    }

    // ====== Clases (Inicio) ======

    public function clases_obtener_activas()
    {
        $query = $this->db
            ->where('t1.estatus', 'Activa')
            ->where('t2.totalpass_plan_id IS NOT NULL')
            ->where('t2.totalpass_plan_id !=', 0)
            ->select('
                t1.*,
                t2.nombre as disciplinas_nombre,
                CONCAT(COALESCE(t3.nombre_completo, "N/D"), " ", COALESCE(t3.apellido_paterno, "N/D")) as instructores_nombre,
                t4.locacion as sucursales_locacion,
            ')
            ->from('clases t1')
            ->join("disciplinas t2", "t2.id = t1.disciplina_id")
            ->join("usuarios t3", "t3.id = t1.instructor_id")
            ->join("sucursales t4", "t4.id = t2.sucursal_id")
            ->get();

        return $query;
    }

    public function clases_obtener_por_id($id)
    {
        $query = $this->db
            ->where('t1.estatus', 'Activa')
            ->where('t1.id', $id)
            ->select('
                t1.*,
                t2.nombre as disciplinas_nombre,
                CONCAT(COALESCE(t3.nombre_completo, "N/D"), " ", COALESCE(t3.apellido_paterno, "N/D")) as instructores_nombre,
                t4.locacion as sucursales_locacion,
            ')
            ->from('clases t1')
            ->join("disciplinas t2", "t2.id = t1.disciplina_id")
            ->join("usuarios t3", "t3.id = t1.instructor_id")
            ->join("sucursales t4", "t4.id = t2.sucursal_id")
            ->get();

        return $query;
    }

    public function clases_actualizar_por_id($id, $data)
    {
        $query =  $this->db
            ->where('id', $id)
            ->update('clases', $data);

        return $query;
    }

    // ====== Clases (Fin) ======

}
