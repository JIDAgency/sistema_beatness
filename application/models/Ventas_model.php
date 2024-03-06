<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ventas_model extends CI_Model
{

    /** //////////////////////////////////////////////////////////////////////////// Nuevos métodos para el sistema (Mejora de la calidad de programación del sistema //////////////////////////////////////////////////////////////////////////// */
    /** //////////////////////////////////////////////////////////////////////////// Métodos para cargar las listas del panel de ventas //////////////////////////////////////////////////////////////////////////// */
    
    /** Este modelo consulta los datos necesarios para la TABLA de ventas mensual. */
    public function get_lista_de_ventas_del_mes_para_fd_global($mes_a_consultar)
    {
        if (es_frontdesk()) {
            if ($this->session->userdata('sucursal_asignada') == 2) {

                $query = $this->db
                    ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m')", $mes_a_consultar)
                    ->where_in('t1.sucursal_id', array(1,2))
                    ->select("
                        t1.*,

                        t2.nombre as metodo_de_pago,

                        t3.nombre_completo as comprador,
                        t3.correo as comprador_correo,
                        CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as comprador_nombre_completo,
                        
                        t4.nombre as sucursal_nombre,
                        t4.locacion as sucursal_locacion,

                        t5.plan_id as asignacion_plan_id,
                        t5.nombre as asignacion_nombre,
                        t5.vigencia_en_dias as asignacion_vigencia_en_dias,
                        t5.clases_incluidas as asignacion_clases_incluidas,
                        t5.clases_usadas as asignacion_clases_usadas,
                        t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
                        t5.openpay_cliente_id as asignacion_openpay_cliente_id,
                        t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
                        t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
                        t6.dominio_id as plan_dominio_id,
                    ")
                    ->from("ventas t1")
                    ->join("metodos_pago t2", "t1.metodo_id = t2.id")
                    ->join("usuarios t3", "t1.usuario_id = t3.id")
                    ->join("sucursales t4", "t1.sucursal_id = t4.id")
                    ->join("asignaciones t5", "t1.asignacion_id = t5.id")
                    ->join("planes t6", "t5.plan_id = t6.id")
                    ->get();

            } elseif ($this->session->userdata('sucursal_asignada') == 3) {
                $query = $this->db
                    ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m')", $mes_a_consultar)
                    ->where_in('t1.sucursal_id', array(1,3))
                    ->select("
                        t1.*,

                        t2.nombre as metodo_de_pago,

                        t3.nombre_completo as comprador,
                        t3.correo as comprador_correo,
                        CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as comprador_nombre_completo,
                        
                        t4.nombre as sucursal_nombre,
                        t4.locacion as sucursal_locacion,

                        t5.plan_id as asignacion_plan_id,
                        t5.nombre as asignacion_nombre,
                        t5.vigencia_en_dias as asignacion_vigencia_en_dias,
                        t5.clases_incluidas as asignacion_clases_incluidas,
                        t5.clases_usadas as asignacion_clases_usadas,
                        t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
                        t5.openpay_cliente_id as asignacion_openpay_cliente_id,
                        t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
                        t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
                        t6.dominio_id as plan_dominio_id,
                    ")
                    ->from("ventas t1")
                    ->join("metodos_pago t2", "t1.metodo_id = t2.id")
                    ->join("usuarios t3", "t1.usuario_id = t3.id")
                    ->join("sucursales t4", "t1.sucursal_id = t4.id")
                    ->join("asignaciones t5", "t1.asignacion_id = t5.id")
                    ->join("planes t6", "t5.plan_id = t6.id")
                    ->get();
            } elseif ($this->session->userdata('sucursal_asignada') == 5) {
                $query = $this->db
                    ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m')", $mes_a_consultar)
                    ->group_start()
                        ->where_in('t7.disciplina_id', array(16))
                        ->or_where('t1.sucursal_id', 5)
                    ->group_end()
                    ->select("
                        t1.*,

                        t2.nombre as metodo_de_pago,

                        t3.nombre_completo as comprador,
                        t3.correo as comprador_correo,
                        CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as comprador_nombre_completo,
                        
                        t4.nombre as sucursal_nombre,
                        t4.locacion as sucursal_locacion,

                        t5.plan_id as asignacion_plan_id,
                        t5.nombre as asignacion_nombre,
                        t5.vigencia_en_dias as asignacion_vigencia_en_dias,
                        t5.clases_incluidas as asignacion_clases_incluidas,
                        t5.clases_usadas as asignacion_clases_usadas,
                        t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
                        t5.openpay_cliente_id as asignacion_openpay_cliente_id,
                        t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
                        t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
                        t6.dominio_id as plan_dominio_id,
                    ")
                    ->from("ventas t1")
                    ->join("metodos_pago t2", "t1.metodo_id = t2.id")
                    ->join("usuarios t3", "t1.usuario_id = t3.id")
                    ->join("sucursales t4", "t1.sucursal_id = t4.id")
                    ->join("asignaciones t5", "t1.asignacion_id = t5.id")
                    ->join("planes t6", "t5.plan_id = t6.id")
                    ->join("planes_disciplinas t7", "t6.id = t7.plan_id")
                    ->group_by('t1.id')
                ->get();
                // Este metodo fue modificado para que el se pueda consultar la sucursal a travez de las asignaciones
            }
        } elseif (es_superadministrador() OR es_administrador()) {
            $query = $this->db
                ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m')", $mes_a_consultar)
                ->select("
                    t1.*,

                    t2.nombre as metodo_de_pago,

                    t3.nombre_completo as comprador,
                    t3.correo as comprador_correo,
                    CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as comprador_nombre_completo,
                    
                    t4.nombre as sucursal_nombre,
                    t4.locacion as sucursal_locacion,

                    t5.plan_id as asignacion_plan_id,
                    t5.nombre as asignacion_nombre,
                    t5.vigencia_en_dias as asignacion_vigencia_en_dias,
                    t5.clases_incluidas as asignacion_clases_incluidas,
                    t5.clases_usadas as asignacion_clases_usadas,
                    t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
                    t5.openpay_cliente_id as asignacion_openpay_cliente_id,
                    t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
                    t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
                    t6.dominio_id as plan_dominio_id,
                ")
                ->from("ventas t1")
                ->join("metodos_pago t2", "t1.metodo_id = t2.id")
                ->join("usuarios t3", "t1.usuario_id = t3.id")
                ->join("sucursales t4", "t1.sucursal_id = t4.id")
                ->join("asignaciones t5", "t1.asignacion_id = t5.id")
                ->join("planes t6", "t5.plan_id = t6.id")
                ->get();
        }

        return $query;
    }

    /** Este modelo consulta los datos necesarios para la TABLA de ventas diarias. */
    public function get_lista_de_ventas_del_dia_para_fd_global($dia_a_consultar)
    {
        if (es_frontdesk()) {
            if ($this->session->userdata('sucursal_asignada') == 2) {

                $query = $this->db
                    ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m-%d')", $dia_a_consultar)
                    ->where_in('t1.sucursal_id', array(1,2))
                    ->select("
                        t1.*,

                        t2.nombre as metodo_de_pago,

                        t3.nombre_completo as comprador,
                        t3.correo as comprador_correo,
                        CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as comprador_nombre_completo,
                        
                        t4.nombre as sucursal_nombre,
                        t4.locacion as sucursal_locacion,

                        t5.plan_id as asignacion_plan_id,
                        t5.nombre as asignacion_nombre,
                        t5.vigencia_en_dias as asignacion_vigencia_en_dias,
                        t5.clases_incluidas as asignacion_clases_incluidas,
                        t5.clases_usadas as asignacion_clases_usadas,
                        t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
                        t5.openpay_cliente_id as asignacion_openpay_cliente_id,
                        t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
                        t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
                        t6.dominio_id as plan_dominio_id,
                    ")
                    ->from("ventas t1")
                    ->join("metodos_pago t2", "t1.metodo_id = t2.id")
                    ->join("usuarios t3", "t1.usuario_id = t3.id")
                    ->join("sucursales t4", "t1.sucursal_id = t4.id")
                    ->join("asignaciones t5", "t1.asignacion_id = t5.id")
                    ->join("planes t6", "t5.plan_id = t6.id")
                    ->get();

            } elseif ($this->session->userdata('sucursal_asignada') == 3) {

                $query = $this->db
                ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m-%d')", $dia_a_consultar)
                ->where_in('t1.sucursal_id', array(1,3))
                ->select("
                    t1.*,

                    t2.nombre as metodo_de_pago,

                    t3.nombre_completo as comprador,
                    t3.correo as comprador_correo,
                    CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as comprador_nombre_completo,
                    
                    t4.nombre as sucursal_nombre,
                    t4.locacion as sucursal_locacion,

                    t5.plan_id as asignacion_plan_id,
                    t5.nombre as asignacion_nombre,
                    t5.vigencia_en_dias as asignacion_vigencia_en_dias,
                    t5.clases_incluidas as asignacion_clases_incluidas,
                    t5.clases_usadas as asignacion_clases_usadas,
                    t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
                    t5.openpay_cliente_id as asignacion_openpay_cliente_id,
                    t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
                    t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
                    t6.dominio_id as plan_dominio_id,
                ")
                ->from("ventas t1")
                ->join("metodos_pago t2", "t1.metodo_id = t2.id")
                ->join("usuarios t3", "t1.usuario_id = t3.id")
                ->join("sucursales t4", "t1.sucursal_id = t4.id")
                ->join("asignaciones t5", "t1.asignacion_id = t5.id")
                ->join("planes t6", "t5.plan_id = t6.id")
                ->get();

            } elseif ($this->session->userdata('sucursal_asignada') == 5) {

                $query = $this->db
                ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m-%d')", $dia_a_consultar)
                ->group_start()
                    ->where_in('t7.disciplina_id', array(16))
                    ->or_where('t1.sucursal_id', 5)
                ->group_end()
                ->select("
                    t1.*,

                    t2.nombre as metodo_de_pago,

                    t3.nombre_completo as comprador,
                    t3.correo as comprador_correo,
                    CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as comprador_nombre_completo,
                    
                    t4.nombre as sucursal_nombre,
                    t4.locacion as sucursal_locacion,

                    t5.plan_id as asignacion_plan_id,
                    t5.nombre as asignacion_nombre,
                    t5.vigencia_en_dias as asignacion_vigencia_en_dias,
                    t5.clases_incluidas as asignacion_clases_incluidas,
                    t5.clases_usadas as asignacion_clases_usadas,
                    t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
                    t5.openpay_cliente_id as asignacion_openpay_cliente_id,
                    t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
                    t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
                    t6.dominio_id as plan_dominio_id,
                ")
                ->from("ventas t1")
                ->join("metodos_pago t2", "t1.metodo_id = t2.id")
                ->join("usuarios t3", "t1.usuario_id = t3.id")
                ->join("sucursales t4", "t1.sucursal_id = t4.id")
                ->join("asignaciones t5", "t1.asignacion_id = t5.id")
                ->join("planes t6", "t5.plan_id = t6.id")
                ->join("planes_disciplinas t7", "t6.id = t7.plan_id")
                ->group_by('t1.id')
                ->get();

            }
        } elseif (es_superadministrador() OR es_administrador() OR es_operaciones()) {

            $query = $this->db
                ->where("DATE_FORMAT(t1.fecha_venta,'%Y-%m-%d')", $dia_a_consultar)
                ->select("
                    t1.*,

                    t2.nombre as metodo_de_pago,

                    t3.nombre_completo as comprador,
                    t3.correo as comprador_correo,
                    CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as comprador_nombre_completo,
                    
                    t4.nombre as sucursal_nombre,
                    t4.locacion as sucursal_locacion,

                    t5.plan_id as asignacion_plan_id,
                    t5.nombre as asignacion_nombre,
                    t5.vigencia_en_dias as asignacion_vigencia_en_dias,
                    t5.clases_incluidas as asignacion_clases_incluidas,
                    t5.clases_usadas as asignacion_clases_usadas,
                    t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
                    t5.openpay_cliente_id as asignacion_openpay_cliente_id,
                    t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
                    t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
                    t6.dominio_id as plan_dominio_id,
                ")
                ->from("ventas t1")
                ->join("metodos_pago t2", "t1.metodo_id = t2.id")
                ->join("usuarios t3", "t1.usuario_id = t3.id")
                ->join("sucursales t4", "t1.sucursal_id = t4.id")
                ->join("asignaciones t5", "t1.asignacion_id = t5.id")
                ->join("planes t6", "t5.plan_id = t6.id")
                ->get();

        }

        return $query;
    }
    
    
    public function get_lista_de_todas_las_ventas_de_hoy_para_admin_front()
    {
        $start_date = strtotime("-7 days", strtotime(date('Y-m-d')));
        $end_date = strtotime("+1 days", strtotime(date('Y-m-d')));

        $query = $this->db
        ->where('t1.fecha_venta BETWEEN "'. date('Y-m-d', $start_date). '" and "'. date('Y-m-d', $end_date).'"')
        ->select("
            t1.id as listar_id,
            t1.concepto as listar_concepto,
            CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' #', COALESCE(t3.id, 'N/D')) as listar_usuario,
            t4.nombre as listar_metodo_nombre,
            t1.costo as listar_costo,
            t1.cantidad as listar_cantidad,
            t1.total as listar_total,
            t1.estatus as listar_estatus,
            CONCAT('#', COALESCE(t1.asignacion_id, 'N/D')) as listar_asignacion,
            t5.clases_incluidas as listar_clases_incluidas,
            t5.clases_usadas as listar_clases_usadas,
            (t5.clases_incluidas-t5.clases_usadas) as listar_clases_restantes,
            t5.vigencia_en_dias as listar_vigencia_en_dias,
            t5.fecha_activacion as listar_fecha_activacion,
            t2.locacion as listar_sucursales_locacion,
            t1.vendedor as listar_vendedor,
            t1.fecha_venta as listar_fecha_venta,
        ")
        ->from("ventas t1")
        ->join("sucursales t2", "t1.sucursal_id = t2.id")
        ->join("usuarios t3", "t1.usuario_id = t3.id")
        ->join("metodos_pago t4", "t1.metodo_id = t4.id")
        ->join("asignaciones t5", "t1.asignacion_id = t5.id")
        ->get();

        return $query;
    }

    public function get_lista_de_todas_las_ventas_de_hoy_para_VELA_front()
    {
        $start_date = strtotime("-7 days", strtotime(date('Y-m-d')));
        $end_date = strtotime("+1 days", strtotime(date('Y-m-d')));

        $query = $this->db
        ->where('t1.fecha_venta BETWEEN "'. date('Y-m-d', $start_date). '" and "'. date('Y-m-d', $end_date).'"')
        ->where_in('t1.sucursal_id', array(1,2))
        ->select("
            t1.id as listar_id,
            t1.concepto as listar_concepto,
            CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' #', COALESCE(t3.id, 'N/D')) as listar_usuario,
            t4.nombre as listar_metodo_nombre,
            t1.costo as listar_costo,
            t1.cantidad as listar_cantidad,
            t1.total as listar_total,
            t1.estatus as listar_estatus,
            CONCAT('#', COALESCE(t1.asignacion_id, 'N/D')) as listar_asignacion,
            t5.clases_incluidas as listar_clases_incluidas,
            t5.clases_usadas as listar_clases_usadas,
            (t5.clases_incluidas-t5.clases_usadas) as listar_clases_restantes,
            t5.vigencia_en_dias as listar_vigencia_en_dias,
            t5.fecha_activacion as listar_fecha_activacion,
            t2.locacion as listar_sucursales_locacion,
            t1.vendedor as listar_vendedor,
            t1.fecha_venta as listar_fecha_venta,
        ")
        ->from("ventas t1")
        ->join("sucursales t2", "t1.sucursal_id = t2.id")
        ->join("usuarios t3", "t1.usuario_id = t3.id")
        ->join("metodos_pago t4", "t1.metodo_id = t4.id")
        ->join("asignaciones t5", "t1.asignacion_id = t5.id")
        ->get();

        return $query;
    }

    public function get_lista_de_todas_las_ventas_de_hoy_para_DORADA_front()
    {
        $start_date = strtotime("-7 days", strtotime(date('Y-m-d')));
        $end_date = strtotime("+1 days", strtotime(date('Y-m-d')));

        $query = $this->db
        ->where('t1.fecha_venta BETWEEN "'. date('Y-m-d', $start_date). '" and "'. date('Y-m-d', $end_date).'"')
        ->where_in('t1.sucursal_id', array(1,3))
        ->select("
            t1.id as listar_id,
            t1.concepto as listar_concepto,
            CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' #', COALESCE(t3.id, 'N/D')) as listar_usuario,
            t4.nombre as listar_metodo_nombre,
            t1.costo as listar_costo,
            t1.cantidad as listar_cantidad,
            t1.total as listar_total,
            t1.estatus as listar_estatus,
            CONCAT('#', COALESCE(t1.asignacion_id, 'N/D')) as listar_asignacion,
            t5.clases_incluidas as listar_clases_incluidas,
            t5.clases_usadas as listar_clases_usadas,
            (t5.clases_incluidas-t5.clases_usadas) as listar_clases_restantes,
            t5.vigencia_en_dias as listar_vigencia_en_dias,
            t5.fecha_activacion as listar_fecha_activacion,
            t2.locacion as listar_sucursales_locacion,
            t1.vendedor as listar_vendedor,
            t1.fecha_venta as listar_fecha_venta,
        ")
        ->from("ventas t1")
        ->join("sucursales t2", "t1.sucursal_id = t2.id")
        ->join("usuarios t3", "t1.usuario_id = t3.id")
        ->join("metodos_pago t4", "t1.metodo_id = t4.id")
        ->join("asignaciones t5", "t1.asignacion_id = t5.id")
        ->get();

        return $query;
    }

    /** Métodos para el Feed de Inicio //////////////////////////////////////////////////////////////////////////// */

    /** Administrador ------------- */
    public function get_feed_inicio_ventas_suma_de_ventas_del_dia_superadmin($start_date, $end_date)
    {        
        $query = $this->db
        ->select_sum('total')
        ->where('fecha_venta BETWEEN "'. date('Y-m-d', $start_date). '" and "'. date('Y-m-d', $end_date).'"')
        ->where('estatus', 'Vendido')
        ->from('ventas')
        ->get();

        return $query;
    }

    public function get_feed_inicio_ventas_suma_de_ventas_del_dia_admin($start_date, $end_date)
    {
        $array_sucursales = array(1, 2, 3);
        
        $query = $this->db
        ->select_sum('total')
        ->where('fecha_venta BETWEEN "'. date('Y-m-d', $start_date). '" and "'. date('Y-m-d', $end_date).'"')
        ->where('estatus', 'Vendido')
        ->where_in('sucursal_id', $array_sucursales)
        ->from('ventas')
        ->get();

        return $query;
    }

    /** Métodos para el Feed de Inicio //////////////////////////////////////////////////////////////////////////// */

    /** Métodos para el Feed de ventas //////////////////////////////////////////////////////////////////////////// */

    public function get_feed_ventas_suma_de_ventas_del_dia_sin_openay($sucursal = null)
    {
        if (!$sucursal) {
            $array_sucursales = array(1, 2, 3);
        } elseif ($sucursal == 2) {
            $array_sucursales = array(1, 2);
        } elseif ($sucursal == 3) {
            $array_sucursales = array(1, 3);
        }
        
        $query = $this->db
        ->select_sum('total')
        ->where('DATE_FORMAT(fecha_venta,"%Y-%m-%d")', date('Y-m-d'))
        ->where('estatus', 'Vendido')
        ->where('metodo_id !=', '3')
        ->where_in('sucursal_id', $array_sucursales)
        ->from('ventas')
        ->get();

        return $query;
    }

    public function get_feed_ventas_suma_de_ventas_del_dia_con_openpay($sucursal = null)
    {
        if (!$sucursal) {
            $array_sucursales = array(1, 2, 3);
        } elseif ($sucursal == 2) {
            $array_sucursales = array(1, 2);
        } elseif ($sucursal == 3) {
            $array_sucursales = array(1, 3);
        }
        
        $query = $this->db
        //->select_sum('total')
        ->where('DATE_FORMAT(fecha_venta,"%Y-%m-%d")', date('Y-m-d'))
        ->where('estatus', 'Vendido')
        ->where_in('sucursal_id', $array_sucursales)
        ->from('ventas')
        ->get();

        return $query;
    }

    public function get_feed_ventas_suma_de_ventas_en_efectivo_del_dia($sucursal = null)
    {
        if (!$sucursal) {
            $array_sucursales = array(1, 2, 3);
        } elseif ($sucursal == 2) {
            $array_sucursales = array(1, 2);
        } elseif ($sucursal == 3) {
            $array_sucursales = array(1, 3);
        }
        
        $query = $this->db
        ->select_sum('total')
        ->where('DATE_FORMAT(fecha_venta,"%Y-%m-%d")', date('Y-m-d'))
        ->where('metodo_id', 1)
        ->where('estatus', 'Vendido')
        ->where_in('sucursal_id', $array_sucursales)
        ->from('ventas')
        ->get();

        return $query;
    }

    public function get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia($sucursal = null)
    {
        if (!$sucursal) {
            $array_sucursales = array(1, 2, 3);
        } elseif ($sucursal == 2) {
            $array_sucursales = array(1, 2);
        } elseif ($sucursal == 3) {
            $array_sucursales = array(1, 3);
        }
        
        $query = $this->db
        ->select_sum('total')
        ->where('DATE_FORMAT(fecha_venta,"%Y-%m-%d")', date('Y-m-d'))
        ->where('metodo_id', 2)
        ->where('estatus', 'Vendido')
        ->where_in('sucursal_id', $array_sucursales)
        ->from('ventas')
        ->get();

        return $query;
    }

    public function get_feed_ventas_suma_de_ventas_en_openpay_del_dia($sucursal = null)
    {
        if (!$sucursal) {
            $array_sucursales = array(1, 2, 3);
        } elseif ($sucursal == 2) {
            $array_sucursales = array(1, 2);
        } elseif ($sucursal == 3) {
            $array_sucursales = array(1, 3);
        }
        
        $query = $this->db
        ->select_sum('total')
        ->where('DATE_FORMAT(fecha_venta,"%Y-%m-%d")', date('Y-m-d'))
        ->where('metodo_id', 3)
        ->where('estatus', 'Vendido')
        ->where_in('sucursal_id', $array_sucursales)
        ->from('ventas')
        ->get();

        return $query;
    }

    public function get_feed_ventas_numero_de_ventas_del_dia($sucursal = null)
    {
        if (!$sucursal) {
            $array_sucursales = array(1, 2, 3);
        } elseif ($sucursal == 2) {
            $array_sucursales = array(1, 2);
        } elseif ($sucursal == 3) {
            $array_sucursales = array(1, 3);
        }
        
        $query = $this->db
        ->where('DATE_FORMAT(fecha_venta,"%Y-%m-%d")', date('Y-m-d'))
        ->where('estatus', 'Vendido')
        ->where_in('sucursal_id', $array_sucursales)
        ->count_all_results('ventas');

        return $query;
    }

    public function get_feed_ventas_numero_de_ventas_canceladas_del_dia($sucursal = null)
    {
        if (!$sucursal) {
            $array_sucursales = array(1, 2, 3);
        } elseif ($sucursal == 2) {
            $array_sucursales = array(1, 2);
        } elseif ($sucursal == 3) {
            $array_sucursales = array(1, 3);
        }

        $query = $this->db
        ->where('DATE_FORMAT(fecha_venta,"%Y-%m-%d")', date('Y-m-d'))
        ->where('estatus', 'Cancelada')
        ->where_in('sucursal_id', $array_sucursales)
        ->count_all_results('ventas');

        return $query;
    }

    /** Métodos para el Feed de ventas //////////////////////////////////////////////////////////////////////////// */

    /** //////////////////////////////////////////////////////////////////////////// Métodos para cargar las listas del panel de ventas //////////////////////////////////////////////////////////////////////////// */
    

    public function obtener_todas()
    {
        $this->db->select("t1.*,
        t2.clases_incluidas as clases_incluidas,
        t2.clases_usadas as clases_usadas,
        t2.vigencia_en_dias as vigencia_en_dias,
        t2.fecha_activacion as fecha_activacion,
        CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as usuario,
        t5.locacion as sucursales_locacion,
        t4.nombre as metodo");
        $this->db->from("ventas t1");
        $this->db->join("asignaciones t2", "t1.asignacion_id = t2.id");
        $this->db->join("usuarios t3", "t1.usuario_id = t3.id");
        $this->db->join("metodos_pago t4", "t1.metodo_id = t4.id");
        $this->db->join("sucursales t5", "t1.sucursal_id = t5.id");
        $resultados = $this->db->get();
        return $resultados;
    }

    public function obtener_todas_para_front()
    {
        $this->db->select("t1.*,
            t2.clases_incluidas as clases_incluidas,
            t2.clases_usadas as clases_usadas,
            t2.vigencia_en_dias as vigencia_en_dias,
            t2.fecha_activacion as fecha_activacion,
            CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as usuario,
            t4.nombre as metodo
        ");
        $this->db->from("ventas t1");
        $this->db->join("asignaciones t2", "t1.asignacion_id = t2.id");
        $this->db->join("usuarios t3", "t1.usuario_id = t3.id");
        $this->db->join("metodos_pago t4", "t1.metodo_id = t4.id");
        $this->db->where("t1.fecha_venta >= CURDATE() - INTERVAL 7 DAY");
        $resultados = $this->db->get();
        return $resultados;
    }

    public function obtener_por_id($id)
    {
        return $this->db->where('id', intval($id))->get('ventas');
    }

    public function obtener_venta_por_id($id)
    {
        $query = $this->db
        ->where('t1.id', intval($id))
        ->select("
            t1.*,

            t2.nombre as metodo_pago_nombre,

            t3.nombre_completo as comprador,
            t3.correo as comprador_correo,
            CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as usuario_nombre,
            
            t4.nombre as sucursal_nombre,
            t4.locacion as sucursal_locacion,

            t5.plan_id as asignacion_plan_id,
            t5.nombre as asignacion_nombre,
            t5.vigencia_en_dias as asignacion_vigencia_en_dias,
            t5.clases_incluidas as asignacion_clases_incluidas,
            t5.clases_usadas as asignacion_clases_usadas,
            t5.openpay_suscripcion_id as asignacion_openpay_suscripcion_id,
            t5.openpay_cliente_id as asignacion_openpay_cliente_id,
            t5.suscripcion_estatus_del_pago as asignacion_suscripcion_estatus_del_pago,
            t5.suscripcion_fecha_de_actualizacion as asignacion_suscripcion_fecha_de_actualizacion,
        ")
        ->from("ventas t1")
        ->join("metodos_pago t2", "t1.metodo_id = t2.id")
        ->join("usuarios t3", "t1.usuario_id = t3.id")
        ->join("sucursales t4", "t1.sucursal_id = t4.id")
        ->join("asignaciones t5", "t1.asignacion_id = t5.id")
        ->get();

        return $query;
    }

    public function crear($data)
    {
        $data['fecha_venta'] = date('Y-m-d H:i:s');

        return $this->db->insert('ventas', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ventas', $data);
    }

    public function venta_a_cancelar_por_id($id)
    {
        $this->db->where('id', $id);
        $this->db->where('estatus', 'Vendido');
        return $this->db->get('ventas');
    }

    public function genera_asignaciones_por_id_para_todas_las_ventas($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ventas', $data);
    }

    public function autosearch($q){
        $this->db->or_like('nombre_completo', $q)
        ->or_like('apellido_paterno', $q)
        ->or_like('apellido_materno', $q);
        $query = $this->db->get('usuarios');
        if($query->num_rows() > 0){
          foreach ($query->result_array() as $row){
            $new_row['label']= $row['id'].' -- '.$row['nombre_completo'].' '.$row['apellido_paterno'].' '.$row['apellido_materno'];
            $new_row['value']= '';
            $new_row['ref']= $row['id'];
            $row_set[] = $new_row;
          }
          echo json_encode($row_set); //format the array into json data
        }
    }
    
    /** Métodos para las ventas de suscripciones [Inicio] */
        public function get_todas_las_ventas_de_suscripciones()
        {
            $query = $this->db
                ->where('t1.categoria', 'suscripcion')
                ->select("
                    t1.*,
                    t2.openpay_suscripcion_id as asignacion_suscripcion_id,
                    t2.openpay_plan_id as asignacion_plan_id,
                    t2.clases_usadas as asignacion_clases_usadas,
                    t2.suscripcion_estatus_del_pago as asignacion_estatus_del_pago,
                    t2.estatus as asignacion_estatus,
                    CONCAT(COALESCE(t3.nombre_completo, 'N/D'), ' ', COALESCE(t3.apellido_paterno, 'N/D'), ' ', COALESCE(t3.apellido_materno, 'N/D')) as nombre_cliente,
                    t4.nombre as metodo_pago,
                ")
                ->from("ventas t1")
                ->join("asignaciones t2", "t1.asignacion_id = t2.id")
                ->join("usuarios t3", "t1.usuario_id = t3.id")
                ->join("metodos_pago t4", "t1.metodo_id = t4.id")
                ->get();

            return $query;
        }
    /** Métodos para las ventas de suscripciones [Fin] */
}
