<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservaciones_model extends CI_Model
{

    public function obtener_todas()
    {
        $this->db->select("
            t1.*,
            t2.inicia as horario,
        ");
        $this->db->from("reservaciones t1");
        $this->db->join("clases t2", "t1.clase_id = t2.id");
        $resultados = $this->db->get();
        return $resultados;
        //return $this->db->get('reservaciones');
    }

    public function obtener_todas_con_detalle()
    {
        return $this->db->query("SELECT t1.*,
								 CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuario,
                                 t3.identificador AS clase,
                                 t3.inicia AS horario,
                                 t3.inicia_ionic AS inicia_ionic,
                                 t4.nombre AS disciplina
						  FROM reservaciones AS t1
                          JOIN usuarios AS t2 ON t1.usuario_id = t2.id
                          JOIN clases AS t3 ON t1.clase_id = t3.id
                          JOIN disciplinas AS t4 ON t3.disciplina_id = t4.id
                          ORDER BY t1.id DESC
                          ");
    }

    public function obetener_id_para_checkin($usuario, $clase_id, $asignacion, $no_lugar_reservado)
    {
        $query = $this->db
            ->where('t1.usuario_id', $usuario)
            ->where('t1.clase_id', $clase_id)
            ->where('t1.asignaciones_id', $asignacion)
            ->where('t1.no_lugar', $no_lugar_reservado)
            ->select('t1.id')
            ->from('reservaciones t1')
            ->limit(1)
            ->get();

        return $query;
    }

    public function obtener_todas_para_front_con_detalle($sucursal_id = null)
    {

        if ($this->session->userdata('sucursal_asignada') != null) {
            $sucursal_id = $this->session->userdata('sucursal_asignada');
        }

        if (!$sucursal_id) {
            $query = $this->db
                ->where('t1.estatus', 'Activa')
                ->select("
                    t1.*,
                    CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as cliente_nombre,
                    t3.identificador as clase,
                    t3.inicia as horario,
                    t3.inicia_ionic as inicia_ionic,
                    t4.nombre as disciplina,
                    t5.nombre as asignaciones_nombre,
                    t6.nombre as sucursal_nombre,
                    t6.locacion as sucursal_locacion
                ")
                ->from('reservaciones t1')
                ->join("usuarios t2", "t1.usuario_id = t2.id")
                ->join("clases t3", "t1.clase_id = t3.id")
                ->join("disciplinas t4", "t3.disciplina_id = t4.id")
                ->join("asignaciones t5", "t1.asignaciones_id = t5.id")
                ->join("sucursales t6", "t4.sucursal_id = t6.id")
                ->get();
        } else {
            $query = $this->db
                ->where('t1.estatus', 'Activa')
                ->where('t6.id', $sucursal_id)
                ->select("
                    t1.*,
                    CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as cliente_nombre,
                    t3.identificador as clase,
                    t3.inicia as horario,
                    t3.inicia_ionic as inicia_ionic,
                    t4.nombre as disciplina,
                    t5.nombre as asignaciones_nombre,
                    t6.nombre as sucursal_nombre,
                    t6.locacion as sucursal_locacion
                ")
                ->from('reservaciones t1')
                ->join("usuarios t2", "t1.usuario_id = t2.id")
                ->join("clases t3", "t1.clase_id = t3.id")
                ->join("disciplinas t4", "t3.disciplina_id = t4.id")
                ->join("asignaciones t5", "t1.asignaciones_id = t5.id")
                ->join("sucursales t6", "t4.sucursal_id = t6.id")
                ->get();
        }
        return $query;
    }

    public function obtener_reservacion_por_id($id)
    {
        return $this->db->where('id', $id)->where('estatus', 'Activa')->get('reservaciones');
    }

    public function obtener_reservacion_por_id_para_retirar($id)
    {
        return $this->db->where('id', $id)->get('reservaciones');
    }

    public function obtener_por_id($id)
    {
        $this->db->select("
        t1.*,
        CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as usuario,
        t3.identificador as clase,
        t3.inicia as horario,
        t3.inicia_ionic AS inicia_ionic,
        t3.dificultad as dificultad,
        t4.nombre as disciplina,
        t5.nombre_completo as instructor
        ");
        $this->db->from("reservaciones t1");
        $this->db->join("usuarios t2", "t1.usuario_id = t2.id");
        $this->db->join("clases t3", "t1.clase_id = t3.id");
        $this->db->join("disciplinas t4", "t3.disciplina_id = t4.id");
        $this->db->join("usuarios t5", "t3.instructor_id = t5.id");
        $this->db->where("t1.id =", $id);
        $resultados = $this->db->get();
        return $resultados;
    }

    public function obtener_reservacion_para_cliente($id)
    {
        return $this->db->where('usuario_id', $id)->get('reservaciones');
    }

    public function obtener_reservacion_por_cliente($id)
    {
        $this->db->select("
            t1.*,
            CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as usuario,
            t3.identificador as clase,
            t3.inicia as horario,
            t3.inicia_ionic AS inicia_ionic,
            t3.disciplina_id AS disciplina_id,
            t3.subdisciplina_id AS subdisciplina_id,
            t3.dificultad as dificultad,
            t4.nombre as disciplina,
            t6.nombre as sucursal_nombre,
            t6.descripcion as sucursal_descripcion,
            t6.direccion as sucursal_ubicacion,
            t6.url as sucursal_url,
            t6.url_whatsapp as sucursal_whatsapp,
            t6.url_ubicacion as sucursal_como_llegar,
            t6.url_logo as sucursal_url_logo,
            t6.url_animacion as sucursal_url_animacion,
            t5.nombre_imagen_avatar as foto_instructor,
            t3.img_acceso as img_acceso,
            CONCAT(COALESCE(t5.nombre_completo, 'N/D'), ' | ', COALESCE(t1.asistencia, 'N/D')) as instructor,
        ");
        $this->db->from("reservaciones t1");
        $this->db->join("usuarios t2", "t1.usuario_id = t2.id");
        $this->db->join("clases t3", "t1.clase_id = t3.id");
        $this->db->join("disciplinas t4", "t3.disciplina_id = t4.id");
        $this->db->join("usuarios t5", "t3.instructor_id = t5.id");
        $this->db->join("sucursales t6", "t4.sucursal_id = t6.id");
        $this->db->where("t1.usuario_id =", $id);
        $this->db->where("t1.estatus =", "Activa");
        $this->db->order_by("t3.inicia", "asc");
        $resultados = $this->db->get();
        return $resultados;
    }

    public function obtener_reservacion_terminada_por_cliente($id)
    {
        $this->db->select("
            t1.*,
            t3.identificador as clase,
            t3.inicia as horario,
            t3.inicia_ionic AS inicia_ionic,
            t3.disciplina_id AS disciplina_id,
            t3.subdisciplina_id AS subdisciplina_id,
            t3.dificultad as dificultad,
            t4.nombre as disciplina,
            t6.nombre as sucursal_nombre,
            t5.nombre_imagen_avatar as foto_instructor,
            t5.nombre_completo as instructor,
            t5.id as instructor_id,
        ");
        $this->db->from("reservaciones t1");
        $this->db->join("usuarios t2", "t1.usuario_id = t2.id");
        $this->db->join("clases t3", "t1.clase_id = t3.id");
        $this->db->join("disciplinas t4", "t3.disciplina_id = t4.id");
        $this->db->join("usuarios t5", "t3.instructor_id = t5.id");
        $this->db->join("sucursales t6", "t4.sucursal_id = t6.id");
        $this->db->where("t1.usuario_id =", $id);
        $this->db->where("t1.estatus =", "Terminada");
        $this->db->where("t1.calificada =", "no");
        $this->db->order_by("t1.id", "desc");
        $this->db->limit(5);
        $resultados = $this->db->get();
        return $resultados;
    }

    public function obtener_reservacion_terminada_de_semana_por_cliente($id)
    {
        $this->db->select("
            t1.*,
            t3.identificador as clase,
            t3.inicia as horario,
            t3.inicia_ionic AS inicia_ionic,
            t3.disciplina_id AS disciplina_id,
            t3.subdisciplina_id AS subdisciplina_id,
            t3.dificultad as dificultad,
            t4.nombre as disciplina,
            t6.nombre as sucursal_nombre,
            t5.nombre_imagen_avatar as foto_instructor,
            t5.nombre_completo as instructor,
            t5.id as instructor_id,
        ");
        $this->db->from("reservaciones t1");
        $this->db->join("usuarios t2", "t1.usuario_id = t2.id");
        $this->db->join("clases t3", "t1.clase_id = t3.id");
        $this->db->join("disciplinas t4", "t3.disciplina_id = t4.id");
        $this->db->join("usuarios t5", "t3.instructor_id = t5.id");
        $this->db->join("sucursales t6", "t4.sucursal_id = t6.id");
        $this->db->where("t1.usuario_id =", $id);
        $this->db->where("t1.estatus =", "Terminada");
        $this->db->where("t1.calificada =", "no");
        $this->db->where("YEAR(t3.inicia) =", date("Y"));
        $this->db->where("WEEK(t3.inicia, 1) =", date("W")); 
        $this->db->order_by("t1.id", "desc");
        $this->db->limit(1);
        $resultados = $this->db->get();
        return $resultados;
    }

    public function obtener_reservacion_por_cliente_y_clase($usuario_id, $clase_id)
    {
        return $this->db->where(array('usuario_id' => $usuario_id, 'clase_id' => $clase_id, 'estatus' => 'Activa'))->get('reservaciones');
    }

    public function crear($data)
    {
        $data['fecha_creacion'] = date('Y-m-d H:i:s');
        return $this->db->insert('reservaciones', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('reservaciones', $data);
    }

    public function obtener_todas_activas()
    {
        return $this->db->where('estatus', 'Activa')->get('reservaciones');
    }

    /**
     * Nuevos Metodos
     * Segunda etapa Oct 2019
     * Revision: Eduardo GQ
     */

    public function get_reporte_de_reservaciones_del_mes_dinamico($mes_a_consultar = null, $sucursal_id = null)
    {

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        if ($mes_a_consultar == null) {
            $mes_a_consultar = $curr_date;
        }

        if ($this->session->userdata('sucursal_asignada') != null) {
            $sucursal_id = $this->session->userdata('sucursal_asignada');
        }

        if (!$sucursal_id) {
            $query = $this->db
                ->select("
                        t1.*,
                        CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as usuario,
                        t3.identificador AS clase,
                        t3.inicia AS horario,
                        t4.nombre AS disciplina
                    ")
                ->from('reservaciones t1')
                ->join("usuarios t2", "t1.usuario_id = t2.id")
                ->join("clases t3", "t1.clase_id = t3.id")
                ->join("disciplinas t4", "t3.disciplina_id = t4.id")
                ->join("sucursales t5", "t4.sucursal_id = t5.id")
                ->where("DATE_FORMAT(t3.inicia,'%Y-%m')", $mes_a_consultar)
                ->get();
        } else {
            $query = $this->db
                ->where('t5.id', $sucursal_id)
                ->select("
                        t1.*,
                        CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as usuario,
                        t3.identificador AS clase,
                        t3.inicia AS horario,
                        t4.nombre AS disciplina
                    ")
                ->from('reservaciones t1')
                ->join("usuarios t2", "t1.usuario_id = t2.id")
                ->join("clases t3", "t1.clase_id = t3.id")
                ->join("disciplinas t4", "t3.disciplina_id = t4.id")
                ->join("sucursales t5", "t4.sucursal_id = t5.id")
                ->where("DATE_FORMAT(t3.inicia,'%Y-%m')", $mes_a_consultar)
                ->get();
        }

        return $query;
    }

    /*public function obtener_todas_con_detalle()
    {
        return $this->db->query("SELECT t1.*,
								 CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuario,
                                 t3.identificador AS clase,
                                 t3.inicia AS horario,
                                 t3.inicia_ionic AS inicia_ionic,
                                 t4.nombre AS disciplina
						  FROM reservaciones AS t1
                          JOIN usuarios AS t2 ON t1.usuario_id = t2.id
                          JOIN clases AS t3 ON t1.clase_id = t3.id
                          JOIN disciplinas AS t4 ON t3.disciplina_id = t4.id
                          ORDER BY t1.id DESC
                          ");
    }*/

    /**
     * Nuevos metodos 
     */

    public function get_numero_de_reservaciones_de_esta_semana_por_cliente_id($id)
    {
        $query = null;

        $date = new DateTime("now");
        $curr_date = $date->format('Y-W');

        $query = $this->db
            ->where('t1.estatus', 'Activa')
            ->where('t1.usuario_id', $id)
            ->where('DATE_FORMAT(t2.inicia,"%Y-%u")', $curr_date)
            ->select("
                t1.*,
                t2.inicia as horario,
            ")
            ->from("reservaciones t1")
            ->join("clases t2", "t1.clase_id = t2.id")
            ->count_all_results();

        return $query;
    }

    public function get_top_de_actividad_reservaciones($id)
    {
        $query = null;

        $count_index = 1;
        $count_repeated = 1;

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        $query = $this->db
            ->where('DATE_FORMAT(t2.inicia,"%Y-%m")', $curr_date)
            ->select("
                t1.*,
                t2.inicia as horario,
            ")
            ->from("reservaciones t1")
            ->join("clases t2", "t1.clase_id = t2.id")
            ->order_by("t1.usuario_id", "asc")
            ->get()->result();

        $list = array();
        foreach ($query as $row) {

            if (isset($list[$row->usuario_id])) {
                $list[$row->usuario_id]['top_points'] += 1;
            } else {
                $list[$row->usuario_id] = array(
                    "top_points" => '1',
                    "usuario_id" => $row->usuario_id,
                );
            }
        }

        arsort($list);
        $i = 1;
        $points = 0;

        foreach ($list as $value => $key) {

            if ($points != $key['top_points']) {
                $i += 1;
            }

            if ($key['usuario_id'] == $id) {
                $result = $i - 1;
            }

            $points = $key['top_points'];
        }

        return $result;
    }

    public function obtener_verificacion_de_reservaciones_hoy($usuario_id, $fecha_a_reservar)
    {
        // Consultar la base de datos para buscar reservaciones activas para el usuario y para hoy
        $query = $this->db
            ->where('t1.estatus', 'Activa')
            ->where('t1.usuario_id', $usuario_id)
            ->where('DATE_FORMAT(t2.inicia,"%Y-%m-%d")', $fecha_a_reservar)
            ->select("
                t1.*
            ")
            ->from("reservaciones t1")
            ->join("clases t2", "t2.id = t1.clase_id")
            ->get();

        // Verificar si se encontraron reservaciones para hoy
        if ($query->num_rows() > 0) {
            return true; // El usuario tiene al menos una reservación para hoy
        } else {
            return false; // El usuario no tiene reservaciones para hoy
        }
    }

    public function obtener_usuarios_puebla_sin_reservar_en_una_semana()
    {
        $query = $this->db
            ->where("t2.sucursal_id", 2)
            ->where("t2.id = t3.usuario_id")
            ->where("DATE_FORMAT(DATE_ADD(t1.fecha_activacion, INTERVAL t1.vigencia_en_dias DAY),'%Y-%m-%d') <=", date('Y-m-d', strtotime('+5 days')))
            ->select("
                t1.*,
                t2.id as usuarios_id,
                t2.correo as usuarios_correo,
                t2.sucursal_id,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuarios_nombre,
                DATE_FORMAT(DATE_ADD(t1.fecha_activacion, INTERVAL t1.vigencia_en_dias DAY),'%Y-%m-%d') as asignaciones_fecha_finalizacion,
                t3.descripcion as nombre_sucursal
                ")
            ->from("asignaciones t1")
            ->join("usuarios t2", "t2.id = t1.usuario_id")
            ->join("sucursales t3", "t3.id = t2.sucursal_id")
            ->order_by("t2.correo", "asc")
            ->get();
        return $query;
    }

    public function obtener_usuarios_por_reservaciones_por_clase_id($clase_id)
    {
        $query = $this->db
            ->where("t1.clase_id", $clase_id)
            ->select("t1.usuario_id")
            ->from("reservaciones t1")
            ->get();

        return $query;
    }
}
