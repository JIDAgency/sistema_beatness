<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clases_model extends CI_Model
{

    /** Funciones generales (Inicio) */
    /** Funciones generales (Fin) */

    /** Funciones de clases controller (Inicio) */

    public function obtener_todas_para_front_con_detalle($sucursal_id = null)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        if ($this->session->userdata('sucursal_asignada') != null) {
            $sucursal_id = $this->session->userdata('sucursal_asignada');
        }

        if (!$sucursal_id) {
            $query = $this->db
                ->where("DATE_FORMAT(t1.inicia,'%Y-%m-%d') >=", date('Y-m-d', strtotime('-15 days')))
                ->select("
                        t1.*,
                        t2.nombre as disciplina_nombre,
                        t3.nombre as sucursal_nombre,
                        t3.locacion as sucursal_locacion,
                        CONCAT(COALESCE(t4.nombre_completo, 'N/D'), ' ', COALESCE(t4.apellido_paterno, 'N/D')) as instructor_nombre
                    ")
                ->from('clases t1')
                ->join("disciplinas t2", "t1.disciplina_id = t2.id")
                ->join("sucursales t3", "t2.sucursal_id = t3.id")
                ->join("usuarios t4", "t1.instructor_id = t4.id")
                ->get();
        } else {
            $query = $this->db
                ->where("DATE_FORMAT(t1.inicia,'%Y-%m-%d') >=", date('Y-m-d', strtotime('-15 days')))
                ->where('t3.id', $sucursal_id)
                ->select("
                        t1.*,
                        t2.nombre as disciplina_nombre,
                        t3.nombre as sucursal_nombre,
                        t3.locacion as sucursal_locacion,
                        CONCAT(COALESCE(t4.nombre_completo, 'N/D'), ' ', COALESCE(t4.apellido_paterno, 'N/D')) as instructor_nombre
                    ")
                ->from('clases t1')
                ->join("disciplinas t2", "t1.disciplina_id = t2.id")
                ->join("sucursales t3", "t2.sucursal_id = t3.id")
                ->join("usuarios t4", "t1.instructor_id = t4.id")
                ->get();
        }

        return $query;
    }

    public function obtener_todas_para_front_con_detalle_por_sucursal($sucursal_id = null)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        if ($this->session->userdata('filtro_clase_sucursal') != null) {
            $sucursal_id = $this->session->userdata('filtro_clase_sucursal');
        }

        $query = $this->db
            ->where("DATE_FORMAT(t1.inicia,'%Y-%m-%d') >=", date('Y-m-d', strtotime('-15 days')))
            ->where('t3.id', $sucursal_id)
            ->select("
                        t1.*,
                        t2.nombre as disciplina_nombre,
                        t3.nombre as sucursal_nombre,
                        t3.locacion as sucursal_locacion,
                        CONCAT(COALESCE(t4.nombre_completo, 'N/D'), ' ', COALESCE(t4.apellido_paterno, 'N/D')) as instructor_nombre
                    ")
            ->from('clases t1')
            ->join("disciplinas t2", "t1.disciplina_id = t2.id")
            ->join("sucursales t3", "t2.sucursal_id = t3.id")
            ->join("usuarios t4", "t1.instructor_id = t4.id")
            ->get();

        return $query;
    }

    public function obtener_todas_para_front_con_detalle_por_sucursal_disciplina($sucursal_id = null, $disciplina_id = null)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        if ($this->session->userdata('filtro_clase_sucursal') != null) {
            $sucursal_id = $this->session->userdata('filtro_clase_sucursal');
            $disciplina_id = $this->session->userdata('filtro_clase_disciplina');
        }
        $query = $this->db
            ->where("DATE_FORMAT(t1.inicia,'%Y-%m-%d') >=", date('Y-m-d', strtotime('-15 days')))
            ->where('t2.sucursal_id', $sucursal_id)
            ->where('t2.id', $disciplina_id)
            ->select("
                        t1.*,
                        t2.nombre as disciplina_nombre,
                        t3.nombre as sucursal_nombre,
                        t3.locacion as sucursal_locacion,
                        CONCAT(COALESCE(t4.nombre_completo, 'N/D'), ' ', COALESCE(t4.apellido_paterno, 'N/D')) as instructor_nombre
                    ")
            ->from('clases t1')
            ->join("disciplinas t2", "t1.disciplina_id = t2.id")
            ->join("sucursales t3", "t2.sucursal_id = t3.id")
            ->join("usuarios t4", "t1.instructor_id = t4.id")
            ->get();

        return $query;
    }

    public function obtener_todas_para_front_con_detalle_por_disciplina($disciplina_id = null)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        if ($this->session->userdata('filtro_clase_disciplina') != null) {
            $disciplina_id = $this->session->userdata('filtro_clase_disciplina');
        }

        if (!$disciplina_id) {
            $query = $this->db
                ->where("DATE_FORMAT(t1.inicia,'%Y-%m-%d') >=", date('Y-m-d', strtotime('-15 days')))
                ->select("
                        t1.*,
                        t2.nombre as disciplina_nombre,
                        t3.nombre as sucursal_nombre,
                        t3.locacion as sucursal_locacion,
                        CONCAT(COALESCE(t4.nombre_completo, 'N/D'), ' ', COALESCE(t4.apellido_paterno, 'N/D')) as instructor_nombre
                    ")
                ->from('clases t1')
                ->join("disciplinas t2", "t1.disciplina_id = t2.id")
                ->join("sucursales t3", "t2.sucursal_id = t3.id")
                ->join("usuarios t4", "t1.instructor_id = t4.id")
                ->get();
        } else {
            $query = $this->db
                ->where("DATE_FORMAT(t1.inicia,'%Y-%m-%d') >=", date('Y-m-d', strtotime('-15 days')))
                ->where('t2.id', $disciplina_id)
                ->select("
                        t1.*,
                        t2.nombre as disciplina_nombre,
                        t3.nombre as sucursal_nombre,
                        t3.locacion as sucursal_locacion,
                        CONCAT(COALESCE(t4.nombre_completo, 'N/D'), ' ', COALESCE(t4.apellido_paterno, 'N/D')) as instructor_nombre
                    ")
                ->from('clases t1')
                ->join("disciplinas t2", "t1.disciplina_id = t2.id")
                ->join("sucursales t3", "t2.sucursal_id = t3.id")
                ->join("usuarios t4", "t1.instructor_id = t4.id")
                ->get();
        }

        return $query;
    }

    /** Funciones de clases controller (Fin) */

    public function obtener_todas()
    {
        return $this->db->get('clases');
    }

    public function obtener_todas_con_detalle()
    {
        return $this->db->query("SELECT t1.*,
            CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuario,
            t3.nombre AS disciplina
            FROM clases AS t1
            JOIN usuarios AS t2 ON t1.instructor_id = t2.id
            JOIN disciplinas AS t3 ON t1.disciplina_id = t3.id");
    }



    public function obtener_todas_con_detalle_por_id($id)
    {
        return $this->db->query("SELECT t1.*,
            CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuario,
            t3.nombre AS disciplina
            FROM clases AS t1
            JOIN usuarios AS t2 ON t1.instructor_id = t2.id
            JOIN disciplinas AS t3 ON t1.disciplina_id = t3.id
            WHERE t1.id =" . intval($id) . "");
    }

    public function obtener_por_id($id)
    {
        return $this->db->select('
                t1.*, 
                CONCAT(COALESCE(t2.nombre_completo, \'N/D\'), \' \', COALESCE(t2.apellido_paterno, \'N/D\'), \' \', COALESCE(t2.apellido_materno, \'N/D\')) AS instructor,
                t2.nombre_imagen_avatar as usuario_nombre_imagen_avatar
            ')
            ->from('clases as t1')
            ->join('usuarios as t2', 't2.id = t1.instructor_id')
            ->where('t1.id', intval($id))
            ->get();
    }

    public function obtener_clase_por_identificador($identificador)
    {
        return $this->db->select('
                t1.*, 
                CONCAT(COALESCE(t2.nombre_completo, \'N/D\'), \' \', COALESCE(t2.apellido_paterno, \'N/D\'), \' \', COALESCE(t2.apellido_materno, \'N/D\')) AS instructor,
                t2.nombre_imagen_avatar as usuario_nombre_imagen_avatar
            ')
            ->from('clases as t1')
            ->join('usuarios as t2', 't2.id = t1.instructor_id')
            ->where('t1.identificador', intval($identificador))
            ->get();
    }

    public function obtener_por_disciplina_id($disciplina_id)
    {
        return $this->db->query("SELECT t1.*,
								 CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuario,
                                 t3.nombre AS disciplina
						  FROM clases AS t1
                          JOIN usuarios AS t2 ON t1.instructor_id = t2.id
                          JOIN disciplinas AS t3 ON t1.disciplina_id = t3.id
                          WHERE t1.disciplina_id =" . $disciplina_id . "
                          ORDER BY t1.inicia");
    }

    public function obtener_por_disciplina_id_y_fecha_inicio($disciplina_id, $fecha_inicio)
    {
        log_message('debug', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));

        return $this->db->query("SELECT t1.*,
								 CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D')) AS usuario,
                                 t3.nombre AS disciplina
						  FROM clases AS t1
                          JOIN usuarios AS t2 ON t1.instructor_id = t2.id
                          JOIN disciplinas AS t3 ON t1.disciplina_id = t3.id
                          WHERE t1.disciplina_id =" . $disciplina_id . " AND DATE(t1.inicia) = DATE(" . $this->db->escape($fecha_inicio) . ") AND t1.inicia >= NOW()
                          ORDER BY t1.inicia");
    }

    public function obtener_por_disciplina_id_y_fecha_inicio_y_fecha_final($disciplina_id, $fecha_inicio, $fecha_final)
    {
        log_message('debug', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_final = date('Y-m-d', strtotime($fecha_final));

        return $this->db->query("SELECT t1.*,
								 t2.nombre_completo AS usuario,
                                 CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D')) AS instructor,
                                 t3.nombre AS disciplina
						  FROM clases AS t1
                          JOIN usuarios AS t2 ON t1.instructor_id = t2.id
                          JOIN disciplinas AS t3 ON t1.disciplina_id = t3.id
                          WHERE t1.disciplina_id =" . $disciplina_id . " AND DATE(t1.inicia) >= DATE(" . $this->db->escape($fecha_inicio) . ") AND DATE(t1.inicia) <= DATE(" . $this->db->escape($fecha_final) . ") AND t1.estatus != 'Cancelada' OR t1.subdisciplina_id =" . $disciplina_id . " AND DATE(t1.inicia) >= DATE(" . $this->db->escape($fecha_inicio) . ") AND DATE(t1.inicia) <= DATE(" . $this->db->escape($fecha_final) . ") AND t1.estatus != 'Cancelada'
                          ORDER BY t1.inicia");
    }

    public function crear($data)
    {
        return $this->db->insert('clases', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('clases', $data);
    }

    public function borrar($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('clases'); {
            return true;
        }
    }

    public function autosearch($q)
    {
        $this->db->or_like('nombre_completo', $q)
            ->or_like('apellido_paterno', $q)
            ->or_like('apellido_materno', $q);
        $query = $this->db->get('usuarios');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = $row['id'] . ' -- ' . $row['nombre_completo'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'];
                $new_row['value'] = '';
                $new_row['ref'] = $row['id'];
                $row_set[] = $new_row;
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function obtener_todas_activas()
    {
        return $this->db->where('estatus', 'Activa')->get('clases');
    }

    /**
     * Nuevos Metodos
     * Segunda etapa Oct 2019
     * Revision: Eduardo GQ
     */

    public function get_reporte_de_clases_del_mes_dinamico($mes_a_consultar = null)
    {

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        if ($mes_a_consultar == null) {
            $query = $this->db
                ->select("
                    t1.*,
                    t2.nombre as disciplina,
                    CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D')) as instructor
                ")
                ->from('clases t1')
                ->join("disciplinas t2", "t1.disciplina_id = t2.id")
                ->join("usuarios t3", "t1.instructor_id = t3.id")
                ->where("DATE_FORMAT(t1.inicia,'%Y-%m')", $curr_date)
                ->get();
        } else {
            $query = $this->db
                ->select("
                    t1.*,
                    t2.nombre as disciplina,
                    CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D')) as instructor
                ")
                ->from('clases t1')
                ->join("disciplinas t2", "t1.disciplina_id = t2.id")
                ->join("usuarios t3", "t1.instructor_id = t3.id")
                ->where("DATE_FORMAT(t1.inicia,'%Y-%m')", $mes_a_consultar)
                ->get();
        }

        return $query;
    }

    public function get_numero_de_clases_de_esta_semana()
    {
        $query = null;

        $date = new DateTime("now");
        $curr_date = $date->format('Y-W');

        $query = $this->db
            ->where('DATE_FORMAT(inicia,"%Y-%u")', $curr_date)
            ->where('estatus', 'Activa')
            ->count_all_results('clases');

        return $query;
    }

    public function actualizar_clase_por_identificador($identificador, $data)
    {
        $query = $this->db
            ->where('identificador', $identificador)
            ->update('clases', $data);

        return $query;
    }

    public function obtener_dificultades()
    {
        $query = $this->db
            ->distinct()
            ->select("t1.dificultad")
            ->from('clases t1')
            ->get();
        return $query;
    }
}
