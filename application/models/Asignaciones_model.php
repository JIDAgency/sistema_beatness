<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asignaciones_model extends CI_Model
{
    public function obtener_datos_tabla_control()
    {
        return $this->db
        ->order_by('t1.id', 'desc')
        ->select("
            t1.*,
            CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as cliente_nombre,
            t2.correo as cliente_correo,
        ")
        ->from('asignaciones t1')
        ->join("usuarios t2", "t1.usuario_id = t2.id")
        ->get();
    }

    public function obtener_todos()
    {
        return $this->db->get('asignaciones');
    }

    public function obtener_todos_para_front()
    {
        return $this->db
        ->select("
        t1.*,
        CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS nombre_cliente
        ")
        ->from('asignaciones t1')
        ->join("usuarios t2", "t1.usuario_id = t2.id")
        ->get();
    }

    public function obtener_todos_para_front_de_insan3()
    {
        $query = $this->db
            ->where('t3.sucursal_id','5')
            ->or_like('t1.nombre','INSAN3')
            ->select("
                t1.*,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS nombre_cliente
            ")
            ->from('asignaciones t1')
            ->join("usuarios t2", "t1.usuario_id = t2.id")
            ->join("ventas t3", "t1.id = t3.asignacion_id", 'inner')
            ->get();

        return $query;
    }

    public function obtener_por_id($id)
    {
        return $this->db->where('id', intval($id))->get('asignaciones');
    }

    /*public function obtener_por_usuario_id($usuario_id)
    {
        $this->db->select("t1.*,
        t2.descripcion as descripcion,
        t2.terminos_condiciones as terminos
        ")
            ->from("asignaciones t1")
            ->join("planes t2", "t1.plan_id = t2.id")
            ->where("esta_activo",1)
            ->where("usuario_id", intval($usuario_id));
        $resultados = $this->db->get();
        return $resultados;    
    }*/

    /**
     * Se cambio este método para que la app pudiera consumir del plan más viejo 
     * al mas reciente que el usuario tenga en su lista de planes.
     */
    public function obtener_por_usuario_id($usuario_id)
    {
        $this->db->select("t1.*,
        t2.descripcion as descripcion,
        t2.terminos_condiciones as terminos
        ")
            ->from("asignaciones t1")
            ->join("planes t2", "t1.plan_id = t2.id")
            ->where("esta_activo",1)
            ->where("usuario_id", intval($usuario_id))
            ->order_by("(t1.clases_incluidas-t1.clases_usadas)", "desc");
        $resultados = $this->db->get();
        return $resultados;    
    }

    public function obtener_activos_por_usuario_id($usuario_id)
    {
        $this->db->select("t1.*,
        t2.descripcion as descripcion,
        t2.terminos_condiciones as terminos
        ")
            ->from("asignaciones t1")
            ->join("planes t2", "t1.plan_id = t2.id")
            ->where("esta_activo",1)
            ->where("estatus","Activo")
            ->where("usuario_id", intval($usuario_id))
            ->order_by("(t1.clases_incluidas-t1.clases_usadas)", "asc");
        $resultados = $this->db->get();
        return $resultados;    
    }

    public function crear($data)
    {
        //$data['fecha_activacion'] = date('Y-m-d H:i:s');
        return $this->db->insert('asignaciones', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('asignaciones', $data);
    }

    public function activar_plan($id)
    {
        $data['fecha_activacion'] = date('Y-m-d H:i:s');
        $data['esta_activo'] = 1;
        $this->db->where('id', $id);
        return $this->db->update('asignaciones', $data);
    }

    public function asignacion_a_cancelar_por_id($id)
    {
        return $this->db->where('id', intval($id))->where('estatus', 'Activo')->get('asignaciones');
    }

    public function obtener_todos_activos()
    {
        return $this->db->where('estatus', 'Activo')->get('asignaciones');
    }

    /** Funcion para clases ONLINE */
    public function get_asignaciones_para_clases_online_activas_por_usuario_id($id)
    {
        $query = $this->db
            ->where('t1.usuario_id', intval($id))
            ->where('t1.estatus', 'Activo')
            ->where_in('t1.suscripcion_estatus_del_pago', array('pagado', 'prueba'))
            ->where('t2.categoria', 'online')
            ->select('
                t1.*
            ')
            ->from('asignaciones t1')
            ->join('planes t2', 't1.plan_id = t2.id')
            ->get();

        return $query;
    }

    /** Métodos necesarios para las suscripciones (Inicio) */
        public function get_asignacion_por_suscripcion_id($suscripcion_id)
        {
            $query = $this->db
            
                ->where('openpay_suscripcion_id', $suscripcion_id)
                ->get('asignaciones');

            return $query;
        }

        public function get_asignacion_por_usuario_id_y_openpay_tarjeta_id($openpay_tarjeta_id, $usuario_id)
        {
            //Este método es para validar que la tarjeta que se eliminara, no se encuentre relacionada con algún plan del usuario (suscripción).

            $query = $this->db
            
                ->where('usuario_id', intval($usuario_id))
                ->where('openpay_tarjeta_id', $openpay_tarjeta_id)
                ->get('asignaciones');

            return $query;
        }

        public function get_asignacion_activa_de_tipo_suscripcion_con_detalles_por_usuario_id($id)
        {

            $query = $this->db
                ->order_by("(t1.fecha_activacion)", "desc")
                ->where('t1.usuario_id', intval($id))
                ->where('t1.estatus', 'Activo')
                ->where_in('t1.suscripcion_estatus_del_pago', array('pagado', 'prueba', 'rechazado'))
                ->where('t2.categoria', 'online')
                ->select('
                    t1.*,
                    t3.terminacion_card_number as terminacion_tarjeta,
                    t3.openpay_expiration_month as mes_expiracion,
                    t3.openpay_expiration_year as anio_expiracion,
                ')
                ->from('asignaciones t1')
                ->join('planes t2', 't1.plan_id = t2.id')
                ->join('tarjetas t3', 't1.openpay_tarjeta_id = t3.openpay_tarjeta_id')
                ->get();

            return $query;

        }

        public function get_asignacion_activa_de_tipo_suscripcion_hecha_por_frontdesk_con_detalles_por_usuario_id($id)
        {

            $query = $this->db
                ->where('t1.usuario_id', intval($id))
                ->where('t1.estatus', 'Activo')
                ->where_in('t1.suscripcion_estatus_del_pago', array('pagado', 'prueba', 'rechazado'))
                ->where('t2.categoria', 'online')
                ->select('
                    t1.*,
                    t4.nombre as modalidad,
                ')
                ->from('asignaciones t1')
                ->join('planes t2', 't1.plan_id = t2.id')
                ->join('ventas t3', 't1.id = t3.asignacion_id')
                ->join('metodos_pago t4', 't3.metodo_id = t4.id')
                ->get();

            return $query;

        }

        public function get_asignacion_activa_de_tipo_suscripcion_con_detalles_por_suscripcion_id_y_usuario_id($openpay_tarjeta_id, $id)
        {

            $query = $this->db
                ->where('t1.usuario_id', intval($id))
                ->where('t1.openpay_suscripcion_id', $openpay_tarjeta_id)
                ->where('t1.estatus', 'Activo')
                ->where_in('t1.suscripcion_estatus_del_pago', array('pagado', 'prueba', 'rechazado'))
                ->where('t2.categoria', 'online')
                ->select('
                    t1.*,
                    t3.terminacion_card_number as terminacion_tarjeta,
                    t3.openpay_expiration_month as mes_expiracion,
                    t3.openpay_expiration_year as anio_expiracion,
                ')
                ->from('asignaciones t1')
                ->join('planes t2', 't1.plan_id = t2.id')
                ->join('tarjetas t3', 't1.openpay_tarjeta_id = t3.openpay_tarjeta_id')
                ->get();

            return $query;

        }
    /** Métodos necesarios para las suscripciones (Fin) */

    /** Métodos para actualizar la información de los planes pausados durante el Covid (Inicio) */

        public function get_todas_las_asignaciones_activas_sin_suscripciones()
        {
            $query = $this->db
                ->where('estatus', 'Activo')
                ->where('esta_activo', '1')
                ->where('categoria', 'plan')
                ->where('plan_id !=', '14')
                ->get('asignaciones');

            return $query;
        }

        public function get_todas_las_godin_activas()
        {
            $query = $this->db
                ->where('t1.estatus', 'Activo')
                ->where('t1.esta_activo', '1')
                ->where('t1.categoria', 'plan')
                ->where('t2.categoria', 'godin')
                ->select("
                    t1.*,
                    CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) AS nombre_cliente,
                    t3.correo as correo,
                ")
                ->from('asignaciones t1')
                ->join('planes t2', 't1.plan_id = t2.id')
                ->join("usuarios t3", "t1.usuario_id = t3.id")
                ->get();

            return $query;
        }

    /** Métodos para actualizar la información de los planes pausados durante el Covid (Fin) */

    /** Metodos de asignaciones - suscripciones */

    public function get_todas_las_suscripciones()
    {
        $query = $this->db
            ->where('t1.categoria', 'suscripcion')
            ->select("
                t1.*,
                t3.correo as cliente_correo,
                CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) AS cliente_nombre,
            ")
            ->from('asignaciones t1')
            ->join('planes t2', 't1.plan_id = t2.id')
            ->join("usuarios t3", "t1.usuario_id = t3.id")
            ->get();

        return $query;
    }

    public function get_suscripciones()
    {
        $query = $this->db
        ->order_by("t1.id", "desc")
        ->where_in('t1.plan_id', array(14))
        ->where('t1.openpay_suscripcion_id !=', '')
        //->where('t1.openpay_estatus', null)
        //->limit(30)
        ->select("
            t1.*,
            t2.correo as cliente_correo,
            CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS cliente_nombre,
        ")
        ->from('asignaciones t1')
        ->join("usuarios t2", "t1.usuario_id = t2.id")
        ->get();

        return $query;
    }

    public function get_suscripciones_por_id($id)
    {
        $query = $this->db
        ->where('t1.id', $id)
        ->where_in('t1.plan_id', array(14))
        ->where('t1.openpay_suscripcion_id !=', '')
        ->order_by("t1.id", "desc")
        //->limit(5)
        ->select("
            t1.*,
            t2.correo as cliente_correo,
            CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS cliente_nombre,
        ")
        ->from('asignaciones t1')
        ->join("usuarios t2", "t1.usuario_id = t2.id")
        ->get();

        return $query;
    }

    public function obtener_tabla_index_planes_activos_por_cliente() {
        $query = $this->db
            ->where("t1.estatus", "Activo")
            ->select("
                t1.*,
                t2.id as usuarios_id,
                t2.correo as usuarios_correo,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuarios_nombre,
            ")
            ->from("asignaciones t1")
            ->join("usuarios t2", "t2.id = t1.usuario_id")
            ->order_by("t2.correo", "asc")
            ->get();
        return $query;
    }

    public function obtener_tabla_index_planes_por_caducar_por_cliente() {
        $query = $this->db
            ->where("t1.estatus", "Activo")
            ->where("DATE_FORMAT(DATE_ADD(t1.fecha_activacion, INTERVAL t1.vigencia_en_dias DAY),'%Y-%m-%d') <=", date('Y-m-d', strtotime('+7 days')))
            ->select("
                t1.*,
                t2.id as usuarios_id,
                t2.correo as usuarios_correo,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuarios_nombre,
                DATE_FORMAT(DATE_ADD(t1.fecha_activacion, INTERVAL t1.vigencia_en_dias DAY),'%Y-%m-%d') as asignaciones_fecha_finalizacion
            ")
            ->from("asignaciones t1")
            ->join("usuarios t2", "t2.id = t1.usuario_id")
            ->order_by("t2.correo", "asc")
            ->get();
        return $query;
    }

    public function obtener_tabla_index_planes_caducados_por_cliente() {
        $query = $this->db
            ->where("t1.estatus", "Caducado")
            ->or_where("t1.estatus", "Cancelado")
            ->select("
                t1.*,
                t2.id as usuarios_id,
                t2.correo as usuarios_correo,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) AS usuarios_nombre,
            ")
            ->from("asignaciones t1")
            ->join("usuarios t2", "t2.id = t1.usuario_id")
            ->order_by("t2.correo", "asc")
            ->get();
        return $query;
    }
}
