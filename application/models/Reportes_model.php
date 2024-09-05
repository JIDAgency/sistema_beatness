<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reportes_model extends CI_Model
{

    public function obtener_usuarios_que_compraron_primera_clase()
    {
        $query = $this->db
            ->select("t1.*")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where('DATE_FORMAT(t2.fecha_venta,"%Y-%m")', date('Y-m', strtotime('2024-08')))
            ->where_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->where('t2.estatus !=', 'Cancelada')
            ->get();

        $num_rows = $query->num_rows();

        return $num_rows;
    }

    public function obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan()
    {
        $subquery = $this->db
            ->select("t1.id")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where('DATE_FORMAT(t2.fecha_venta,"%Y-%m")', date('Y-m', strtotime('2024-08')))
            ->where_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->where('t2.estatus !=', 'Cancelada')
            ->group_by("t1.id")
            ->get_compiled_select();

        $query = $this->db
            ->select("t1.*, COUNT(t2.id) as total_compras")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where("t1.id IN ($subquery)", null, false)
            ->where_not_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->group_by("t1.id")
            ->having("total_compras >", 1)
            ->get();

        $num_rows = $query->num_rows();

        return $num_rows;
    }

    public function obtener_usuarios_que_compraron_primera_clase_puebla()
    {
        $query = $this->db
            ->select("t1.*")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where('DATE_FORMAT(t2.fecha_venta,"%Y-%m")', date('Y-m', strtotime('2024-08')))
            ->where_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->where('t4.sucursal_id', 2)
            ->where('t2.estatus !=', 'Cancelada')
            ->get();

        $num_rows = $query->num_rows();

        return $num_rows;
    }

    public function obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_puebla()
    {
        $subquery = $this->db
            ->select("t1.id")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where('DATE_FORMAT(t2.fecha_venta,"%Y-%m")', date('Y-m', strtotime('2024-08')))
            ->where_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->where('t4.sucursal_id', 2)
            ->where('t2.estatus !=', 'Cancelada')
            ->group_by("t1.id")
            ->get_compiled_select();

        $query = $this->db
            ->select("t1.*, COUNT(t2.id) as total_compras")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where("t1.id IN ($subquery)", null, false)
            ->where_not_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->group_by("t1.id")
            ->having("total_compras >", 1)
            ->get();

        $num_rows = $query->num_rows();

        return $num_rows;
    }

    public function obtener_usuarios_que_compraron_primera_clase_polanco()
    {
        $query = $this->db
            ->select("t1.*")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where('DATE_FORMAT(t2.fecha_venta,"%Y-%m")', date('Y-m', strtotime('2024-08')))
            ->where_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->where('t4.sucursal_id', 3)
            ->where('t2.estatus !=', 'Cancelada')
            ->get();

        $num_rows = $query->num_rows();

        return $num_rows;
    }

    public function obtener_usuarios_que_compraron_primera_clase_y_compraron_otro_plan_polanco()
    {
        $subquery = $this->db
            ->select("t1.id")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where('DATE_FORMAT(t2.fecha_venta,"%Y-%m")', date('Y-m', strtotime('2024-08')))
            ->where_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->where('t4.sucursal_id', 3)
            ->where('t2.estatus !=', 'Cancelada')
            ->group_by("t1.id")
            ->get_compiled_select();

        $query = $this->db
            ->select("t1.*, COUNT(t2.id) as total_compras")
            ->from("usuarios t1")
            ->join("ventas t2", "t2.usuario_id = t1.id")
            ->join("asignaciones t3", "t3.id = t2.asignacion_id")
            ->join("planes t4", "t4.id = t3.plan_id")
            ->where("t1.id IN ($subquery)", null, false)
            ->where_not_in('t4.nombre', array('PRIMERA CLASE PUEBLA', 'PRIMERA CLASE POLANCO'))
            ->group_by("t1.id")
            ->having("total_compras >", 1)
            ->get();

        $num_rows = $query->num_rows();

        return $num_rows;
    }









    function obtener_reporte_de_instructores_entre_fechas($fecha_inicio, $fecha_fin)
    {
        $query = $this->db
            ->where('t1.estatus !=', 'Cancelada')
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") >=', date('Y-m-d', strtotime($fecha_inicio)))
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m-%d") <=', date('Y-m-d', strtotime($fecha_fin)))
            //->where('t1.reservado >=', 3)
            ->select("
                t1.instructor_id, SUM(t1.reservado) as total_reservado,
                t1.instructor_id, COUNT(t1.instructor_id) as total_clases,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as instructor_nombre,
            ")
            ->from("clases t1")
            ->join("usuarios t2", "t2.id = t1.instructor_id")
            ->group_by('t1.instructor_id')
            ->order_by('t2.nombre_completo', 'asc')
            ->get();

        return $query;
    }

    function obtener_reporte_de_instructores_por_mes($fecha)
    {
        $query = $this->db
            ->where('t1.estatus !=', 'Cancelada')
            ->where('DATE_FORMAT(t1.inicia,"%Y-%m")', $fecha)
            //->where('t1.reservado >=', 3)
            ->select("
                t1.instructor_id, SUM(t1.reservado) as total_reservado,
                t1.instructor_id, COUNT(t1.instructor_id) as total_clases,
                CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D'), ' ', COALESCE(t2.apellido_materno, 'N/D')) as instructor_nombre,
            ")
            ->from("clases t1")
            ->join("usuarios t2", "t2.id = t1.instructor_id")
            ->group_by('t1.instructor_id')
            ->order_by('t2.nombre_completo', 'asc')
            ->get();

        return $query;
    }

    function reporte_1()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_2()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $this->db->where('rol_id', '1');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_3()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $this->db->where('rol_id', '1');
        $this->db->where('gympass_user_id IS NOT NULL');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_4()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $this->db->where('rol_id', '1');
        $this->db->where('gympass_user_id IS NULL');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_5()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios t1');
        $this->db->join('asignaciones t2', 't1.id = t2.usuario_id');
        $this->db->where('t1.rol_id', '1');
        $this->db->where('t2.estatus', 'Activo');
        $this->db->where('t2.nombre !=', 'CLASE FITPASS CLASSIC PUEBLA');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    function reporte_6()
    {
        $this->db->select('COUNT(DISTINCT t1.id) as total');
        $this->db->from('usuarios t1');
        $this->db->join('asignaciones t2', 't1.id = t2.usuario_id');
        $this->db->where('t2.estatus', 'Activo');
        $this->db->where('t2.nombre !=', 'CLASE FITPASS CLASSIC PUEBLA');
        $query = $this->db->get();
        $result = $query->row();
        return $result->total;
    }

    public function obtene_reporte_planes()
    {
        $query = $this->db
            ->where('t1.clases_incluidas >', 0)
            ->where('t1.clases_incluidas <=', 400)
            ->select('t1.clases_incluidas, COUNT(t1.clases_incluidas) as cantidad')
            ->from('asignaciones t1')
            ->group_by('t1.clases_incluidas')
            ->order_by('cantidad', 'desc')
            ->get();

        return $query->result();
    }

    public function obtene_reporte_planes_por_anho()
    {
        $query = $this->db
            ->where('t1.clases_incluidas >', 0)
            ->where('t1.clases_incluidas <=', 400)
            ->select('t1.clases_incluidas, YEAR(t1.fecha_activacion) as anho, COUNT(*) as cantidad')
            ->from('asignaciones t1')
            ->group_by('t1.clases_incluidas, anho')
            ->order_by('anho', 'desc')

            ->order_by('cantidad', 'desc')
            ->get();

        return $query->result();
    }

    function get_reservaciones_numero_total()
    {
        $query = $this->db
            ->where_not_in("estatus", "Cancelada")
            ->count_all_results('reservaciones');

        return $query;
    }

    function get_reservaciones_numero_activas()
    {
        $query = $this->db
            ->where("estatus", "Activa")
            ->count_all_results('reservaciones');

        return $query;
    }

    function get_reservaciones_numero_terminadas()
    {
        $query = $this->db
            ->where("estatus", "Terminada")
            ->count_all_results('reservaciones');

        return $query;
    }

    function get_reservaciones_numero_canceladas()
    {
        $query = $this->db
            ->where("estatus", "Cancelada")
            ->count_all_results('reservaciones');

        return $query;
    }

    function get_reservaciones_numero_del_mes($mes_a_consultar)
    {
        $query = $this->db
            ->where_in("estatus", array("Activa", "Terminada"))
            ->where("DATE_FORMAT(fecha_creacion,'%Y-%m')", $mes_a_consultar)
            ->count_all_results('reservaciones');

        return $query;
    }

    /** Ventas */

    function get_ventas_numero_total()
    {
        $query = $this->db
            ->where_not_in("estatus", "Cancelada")
            ->count_all_results('ventas');

        return $query;
    }

    function get_ventas_numero_vendidas()
    {
        $query = $this->db
            ->where("estatus", "Vendido")
            ->count_all_results('ventas');

        return $query;
    }

    function get_ventas_numero_canceladas()
    {
        $query = $this->db
            ->where("estatus", "Cancelada")
            ->count_all_results('ventas');

        return $query;
    }

    function get_ventas_numero_reembolsos()
    {
        $query = $this->db
            ->where("estatus", "Reembolso")
            ->count_all_results('ventas');

        return $query;
    }

    function get_ventas_numero_pruebas()
    {
        $query = $this->db
            ->where("estatus", "prueba")
            ->count_all_results('ventas');

        return $query;
    }

    function get_ventas_numero_del_mes($mes_a_consultar)
    {
        $query = $this->db
            ->where_in("estatus", array("Vendido", "prueba"))
            ->where("DATE_FORMAT(fecha_venta,'%Y-%m')", $mes_a_consultar)
            ->count_all_results('ventas');

        return $query;
    }

    function get_ventas_numero_vendidas_por_vendedor()
    {
        $query = $this->db
            ->select('vendedor, COUNT(vendedor) as total, sucursal_id')
            ->where_in("estatus", array("Vendido", "prueba"))
            ->group_by('vendedor')
            ->order_by('sucursal_id', 'asc')
            ->order_by('vendedor', 'asc')
            //->get('ventas', 10);
            ->get('ventas');

        return $query;
    }


    function get_ventas_numero_vendidas_por_vendedor_del_mes($mes_a_consultar)
    {
        $query = $this->db
            ->select('t1.vendedor, COUNT(t1.vendedor) as total, t2.nombre as sucursal_nombre, t2.locacion as sucursal_locacion,')
            ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m')", $mes_a_consultar)
            ->where_in("t1.estatus", array("Vendido", "prueba"))
            ->group_by('t1.vendedor')
            ->order_by('t1.sucursal_id', 'asc')
            ->order_by('t1.vendedor', 'asc')
            ->from("ventas t1")
            ->join("sucursales t2", "t1.sucursal_id = t2.id")
            //->get('ventas', 10);
            ->get();

        return $query;
    }

    public function obtener_reservaciones_agrupadas_por_usuario($fecha_inicio, $fecha_fin, $sucursal_id)
    {
        $this->db->select("
            t2.id as id,
            t2.correo as email,
            COUNT(t1.usuario_id) as total_reservaciones
        ");
        $this->db->from("reservaciones t1");
        $this->db->join("usuarios t2", "t2.id = t1.usuario_id");
        $this->db->join("clases t3", "t3.id = t1.clase_id");
        $this->db->join("disciplinas t4", "t4.id = t3.disciplina_id");
        $this->db->where("t3.inicia >=", $fecha_inicio);
        $this->db->where("t3.inicia <=", $fecha_fin);
        if ($sucursal_id != -1) {
            $this->db->where("t4.sucursal_id", $sucursal_id);
        }
        $this->db->group_by("t2.correo");
        $this->db->order_by("total_reservaciones", "desc");

        $query = $this->db->get();
        return $query->result();
    }

    public function obtener_clases_impartidas_agrupadas_por_instructor($fecha_inicio, $fecha_fin, $sucursal_id)
    {
        $this->db->select("
            t2.id as id,
            t2.correo as email,
            COUNT(t1.instructor_id) as total_clases,
            SUM(t1.reservado) as total_reservado,
        ");
        $this->db->from("clases t1");
        $this->db->join("usuarios t2", "t2.id = t1.instructor_id");
        $this->db->join("disciplinas t4", "t4.id = t1.disciplina_id");
        $this->db->where("t1.inicia >=", $fecha_inicio);
        $this->db->where("t1.inicia <=", $fecha_fin);
        if ($sucursal_id != -1) {
            $this->db->where("t4.sucursal_id", $sucursal_id);
        }
        $this->db->group_by("t2.correo");
        $this->db->order_by("total_clases", "desc");

        $query = $this->db->get();
        return $query->result();
    }
}
