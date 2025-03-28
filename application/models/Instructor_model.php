<?php defined('BASEPATH') or exit('No direct script access allowed');

class Instructor_model extends CI_Model
{
    function clases_obtener_por_instructor_id($instructor_id)
    {
        $this->db->select("
            t1.*,
            t2.nombre as disciplina_nombre,
            t3.nombre as sucursal_nombre,
            t3.locacion as sucursal_locacion,
            CONCAT(COALESCE(t4.nombre_completo, '\N/D'), ' ', COALESCE(t4.apellido_paterno, 'N/D')) as instructor_nombre
        ");
        $this->db->from('clases t1');
        $this->db->join('disciplinas t2', 't2.id = t1.disciplina_id', 'left');
        $this->db->join('sucursales t3', 't3.id = t2.sucursal_id', 'left');
        $this->db->join('usuarios t4', 't4.id = t1.instructor_id', 'left');
        $this->db->where('t1.instructor_id', $instructor_id);
        return $this->db->get();
    }

    public function obtener_clases_con_reservaciones($instructor_id)
    {
        // Obtener las clases del instructor (ya con joins que tengas definidos)
        $clases = $this->clases_obtener_por_instructor_id($instructor_id)->result();

        // Recopilar todos los IDs de usuario reservados de todas las clases
        $all_user_ids = array();
        foreach ($clases as $clase) {
            $lugares = json_decode($clase->cupo_lugares, true);
            if (is_array($lugares)) {
                foreach ($lugares as $lugar) {
                    if (isset($lugar['nombre_usuario']) && is_numeric($lugar['nombre_usuario'])) {
                        $all_user_ids[] = (int) $lugar['nombre_usuario'];
                    }
                }
            }
        }
        $all_user_ids = array_unique($all_user_ids);

        // Si se encontraron IDs, hacer una única consulta a la tabla de usuarios
        $usuarios_mapping = array();
        if (!empty($all_user_ids)) {
            $this->db->select("id, CONCAT(nombre_completo, ' ', apellido_paterno, ' ', apellido_materno) as nombre");
            $this->db->from('usuarios');
            $this->db->where_in('id', $all_user_ids);
            $usuarios_result = $this->db->get()->result();

            foreach ($usuarios_result as $u) {
                $usuarios_mapping[$u->id] = $u->nombre;
            }
        }

        // Agregar el nombre del cliente a cada reserva dentro de cada clase
        foreach ($clases as $clase) {
            $lugares = json_decode($clase->cupo_lugares, true);
            if (is_array($lugares)) {
                foreach ($lugares as &$lugar) {
                    if (isset($lugar['nombre_usuario']) && is_numeric($lugar['nombre_usuario'])) {
                        $user_id = (int) $lugar['nombre_usuario'];
                        $lugar['cliente_nombre'] = isset($usuarios_mapping[$user_id]) ? $usuarios_mapping[$user_id] : 'N/D';
                    }
                }
            }
            // Reemplazamos el JSON original por el array modificado
            $clase->cupo_lugares = $lugares;
        }
        return $clases;
    }
}
