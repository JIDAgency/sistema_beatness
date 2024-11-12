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

    public function clases_por_semana($disciplina)
    {
        // Calcular la fecha de inicio y fin (7 días antes y 7 días después de hoy)
        $fecha_inicio_periodo = date('Y-m-d', strtotime('-2 days'));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+2 days'));

        // Consulta para obtener las clases en el periodo de 7 días antes y 7 días después
        $query = $this->db
            ->where('DATE_FORMAT(t1.inicia, "%Y-%m-%d") >=', $fecha_inicio_periodo)
            ->where('DATE_FORMAT(t1.inicia, "%Y-%m-%d") <=', $fecha_fin_periodo)
            ->where('t3.gympass_product_id', $disciplina)
            ->select('
                t1.*,
                DATE_FORMAT(t1.inicia, "%d/%m/%Y %h:%i %p") as formato_fecha_inicia,
                DATE_FORMAT(t1.inicia, "%H:%i") as hora_clase,
                t3.nombre as disciplinas_nombre,
                CONCAT(COALESCE(t2.nombre_completo, "N/D")) as instructor_nombre
            ')
            ->from('clases t1')
            ->join("usuarios t2", "t2.id = t1.instructor_id")
            ->join('disciplinas t3', "t3.id = t1.disciplina_id")
            ->order_by('t1.inicia', 'asc') // Ordenar por hora de inicio
            ->get();

        return $query;
    }
}
