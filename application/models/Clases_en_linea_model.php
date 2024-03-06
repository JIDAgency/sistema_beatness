<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clases_en_linea_model extends CI_Model
{

    /** Sistema (Inicio) |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */

    /** Métodos generales (Inicio) //////////////////////////////////////////////////////////////////////////// */

        /** Método para obtener todas las filas en una lista */
        public function get_todas_las_clases_streaming()
        {
            $query = $this->db
                ->get('clases_streaming');

            return $query;
        }

        /** Método para obtener una fila por su id */
        public function get_clase_streaming_por_id($id)
        {
            $query = $this->db
                ->where('id', intval($id))
                ->get('clases_streaming');
            
            return $query;
        }

        /** Método para crear una nueva fila */
        public function insert_clase_streaming($data)
        {
            $query = $this->db
                ->insert('clases_streaming', $data);

            return $query;
        }

        /** Método para editar una fila existente */
        public function update_clase_streaming($id, $data)
        {
            $query = $this->db
                ->where('id', $id)
                ->update('clases_streaming', $data);

            return $query;
        }

    /** Métodos generales (Fin) //////////////////////////////////////////////////////////////////////////// */

    /**
     * Clases Online
     */
    public function get_todas_las_clases_en_linea_con_detalles()
    {
        $query = $this->db
            ->select("
                t1.*,
                t2.nombre as disciplina,
                CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D')) as instructor
            ")
            ->from('clases_streaming t1')
            ->join("disciplinas t2", "t1.disciplina_id = t2.id")
            ->join("usuarios t3", "t1.instructor_id = t3.id")
            ->get();

        return $query;
    }

    public function get_clases_online_por_sucursal_id($id = null)
    {
        $query = $this->db
            ->where('disciplina_id', $id)
            ->where('estatus', 'activo')
            ->order_by('identificador','desc')
            ->get('clases_streaming');

        return $query;
    }
}
