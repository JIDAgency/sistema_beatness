<?php defined('BASEPATH') or exit('No direct script access allowed');

class Totalpass_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // ====== auth (Inicio) ======
    public function obtener_token($id)
    {
        $query = $this->db
            ->where('id', $id)
            ->get('disciplinas');

        return $query;
    }
    public function obtener_tokens()
    {
        $query = $this->db
            ->where('totalpass_partner_api_key IS NOT NULL')
            ->where('totalpass_place_api_key IS NOT NULL')
            ->get('disciplinas');

        return $query;
    }

    public function guardar_token($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('disciplinas', $data);

        return $query;
    }
    // ====== auth (Fin) ======

    // ====== disciplinas (Inicio) ======
    public function disciplinas_obtener()
    {
        $query = $this->db
            ->get('disciplinas');

        return $query;
    }

    public function disciplina_obtener_por_id($id)
    {
        $query = $this->db
            ->where('id', $id)
            ->get('disciplinas');

        return $query;
    }
    // ====== disciplinas (Fin) ======

    // ====== planes (Inicio) ======
    public function plan_obtener_por_id($id)
    {
        $query = $this->db
            ->where('id', $id)
            ->get('planes');

        return $query;
    }
    // ====== planes (Fin) ======

    // ====== asignaciones (Inicio) ======
    public function asignacion_insertar($data)
    {
        $query = $this->db
            ->insert('asignaciones', $data);

        return $query;
    }

    public function asignacion_obtener_por_id($id)
    {
        $query = $this->db
            ->where('id', $id)
            ->get('asignaciones');

        return $query;
    }

    public function asignacion_actualizar_por_id($id, $data)
    {
        $query =  $this->db
            ->where('id', $id)
            ->update('asignaciones', $data);

        return $query;
    }
    // ====== asignaciones (Fin) ======

    // ====== ventas (Fin) ======
    public function venta_insertar($data)
    {
        $query = $this->db
            ->insert('ventas', $data);

        return $query;
    }

    public function venta_obtener_por_id($id)
    {
        $query = $this->db
            ->where('id', $id)
            ->get('ventas');

        return $query;
    }

    public function venta_obtener_por_usuario_id_y_asignacion_id($usuario_id, $asignacion_id)
    {
        $query = $this->db
            ->where('usuario_id', $usuario_id)
            ->where('asignacion_id', $asignacion_id)
            ->get('ventas');

        return $query;
    }

    public function venta_actualizar_por_id($id, $data)
    {
        $query =  $this->db
            ->where('id', $id)
            ->update('ventas', $data);

        return $query;
    }
    // ====== ventas (Fin) ======

    // ====== clases (Inicio) ======

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

    public function clase_obtener_por_totalpass_eventOccurrenceUuid($totalpass_eventOccurrenceUuid)
    {
        $query = $this->db
            ->where('t1.totalpass_eventOccurrenceUuid', $totalpass_eventOccurrenceUuid)
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

    public function clase_actualizar_por_id($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('clases', $data);

        return $query;
    }
    // ====== clases (Fin) ======

    // ====== clientes (inicio) ======
    public function obtener_cliente_por_email($correo)
    {
        $query = $this->db
            ->where('correo', $correo)
            ->get('usuarios');

        return $query;
    }

    public function obtener_cliente_por_totalpass_user_code($totalpass_user_code)
    {
        $query = $this->db
            ->where('totalpass_user_code', $totalpass_user_code)
            ->get('usuarios');

        return $query;
    }

    public function insertar_usuario($data)
    {
        $query = $this->db
            ->insert('usuarios', $data);

        return $query;
    }

    public function actualizar_usuario_por_id($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('usuarios', $data);

        return $query;
    }
    // ====== clientes (Fin) ======

    // ====== reservaciones (Inicio) ======
    public function reservaciones_obtener_por_totalpass_slot_id($totalpass_slot_id)
    {
        $query = $this->db
            ->where('totalpass_slot_id', $totalpass_slot_id)
            ->where('estatus', 'Activa')
            ->get('reservaciones');

        return $query;
    }

    public function reservaciones_insertar($data)
    {
        $query = $this->db
            ->insert('reservaciones', $data);

        return $query;
    }

    public function reservaciones_actualizar_por_id($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('reservaciones', $data);

        return $query;
    }
    // ====== reservaciones (Fin) ======

    // ====== webhooks (Inicio) ======
    public function obtener_webhook_por_id($id)
    {
        $query = $this->db
            ->where('id', $id)
            ->get('totalpass_webhooks');

        return $query;
    }

    public function insertar_webhook($data)
    {
        $query = $this->db
            ->insert('totalpass_webhooks', $data);

        return $query;
    }

    public function webhook_actualizar_por_id($id, $data)
    {
        $query = $this->db
            ->where('id', $id)
            ->update('totalpass_webhooks', $data);

        return $query;
    }

    public function webhook_obtener_por_slot_id_y_tipo($slot_id, $tipo)
    {
        $query = $this->db
            ->where('slot_id', $slot_id)
            ->where('tipo', $tipo)
            ->get('totalpass_webhooks');

        return $query;
    }

    // ====== webhooks (Fin) ======

    public function obtener_reservaciones()
    {
        $query = $this->db
            ->where('t1.totalpass_slot_id IS NOT NULL')
            //->where('t1.estatus', 'Terminada')
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

        return $query;
    }
}
