<?php defined('BASEPATH') or exit('No direct script access allowed');

class Planes_model extends CI_Model
{

    // ===> Endpoint Stripe (Inicio)
    public function obtener_plan_por_id_para_stripe($id)
    {
        $query = $this->db
            ->where('t1.id', $id)
            ->select('
                t1.*,
                t2.motor_pago as sucursales_motor_pago
            ')
            ->from('planes t1')
            ->join('sucursales t2', 't2.id = t1.sucursal_id', 'left')
            ->get();

        return $query;
    }

    // ===> Endpoint Stripe (Fin)

    /** Nuevos metodos */

    /** Obtener todos los registros de la tabla de usuarios */
    public function get_lista_de_todos_los_planes()
    {
        $query = $this->db->get('planes');
        return $query;
    }

    /** Obtener todos los usuarios con el rol de cliente limitada a datos específicos*/
    public function get_lista_de_todos_los_planes_limitada()
    {
        $url = '<a href="' . site_url("inicio/index") . '"><i class="ft-eye"></i> Detalles</a>';

        $query = $this->db
            ->where('activado', 1)
            ->order_by('t1.id', 'desc')
            ->select("
                t1.id as listar_id,
                CONCAT(COALESCE(t1.sku, 'N/D'), ' - ', COALESCE(t1.nombre, 'N/D')) AS listar_nombre_completo,
                t1.orden_venta as listar_orden_venta,
                t1.clases_incluidas as listar_clases_incluidas,
                t1.vigencia_en_dias as listar_vigencia_en_dias,
                t1.codigo as codigo,
                t1.costo as listar_costo,
                t1.es_ilimitado,
                t1.sucursal_id,
                t1.es_primera,
                t1.es_estudiante,
                t1.es_empresarial,
                t1.pagar_en,
                t1.activado as listar_activo,
                t1.url_infoventa,
                t2.descripcion as sucursal_nombre,
            ")
            ->from('planes t1')
            ->join('sucursales t2', 't2.id = t1.sucursal_id')
            ->get();

        return $query;
    }

    public function get_lista_de_todos_los_planes_suspendidos_limitada()
    {
        $url = '<a href="' . site_url("inicio/index") . '"><i class="ft-eye"></i> Detalles</a>';

        $query = $this->db
            ->where('activado', 0)
            ->order_by('t1.id', 'desc')
            ->select("
                t1.id as listar_id,
                CONCAT(COALESCE(t1.sku, 'N/D'), ' - ', COALESCE(t1.nombre, 'N/D')) AS listar_nombre_completo,
                t1.orden_venta as listar_orden_venta,
                t1.clases_incluidas as listar_clases_incluidas,
                t1.vigencia_en_dias as listar_vigencia_en_dias,
                t1.codigo as codigo,
                t1.costo as listar_costo,
                t1.es_ilimitado,
                t1.es_primera,
                t1.es_estudiante,
                t1.es_empresarial,
                t1.pagar_en,
                t1.activado as listar_activo,
                t1.url_infoventa,
                t2.descripcion as sucursal_nombre,
            ")
            ->from('planes t1')
            ->join('sucursales t2', 't2.id = t1.sucursal_id')
            ->get();

        return $query;
    }

    /** Metodos viejos ****************************************************************************************** */
    public function obtener_todos()
    {
        $this->db->from('planes');
        $this->db->order_by("costo", "desc");
        return $this->db->get();
    }

    public function obtener_todos_para_venta()
    {
        $this->db->from('planes');
        $this->db->order_by("orden_venta", "asc");
        $this->db->where('nombre !=', 'Sin plan');
        $this->db->where('activado', '1');
        //$this->db->where('subscripcion', '0');
        return $this->db->get();
    }

    public function obtener_por_id($id)
    {
        return $this->db->where('id', intval($id))->get('planes');
    }

    public function obtener_asignaciones_por_id($id)
    {
        return $this->db->where('usuario_id', intval($id))->get('asignaciones');
    }

    public function crear($data)
    {
        return $this->db->insert('planes', $data);
    }

    public function editar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('planes', $data);
    }

    public function agregar_disciplina($data)
    {
        return $this->db->insert('planes_disciplinas', $data);
    }

    public function agregar_categoria($data)
    {
        return $this->db->insert('rel_planes_categorias', $data);
    }

    public function eliminar_disciplinas($plan_id)
    {
        $this->db->where('plan_id', intval($plan_id));
        return $this->db->delete('planes_disciplinas');
    }

    public function eliminar_categorias($plan_id)
    {
        $this->db->where('plan_id', intval($plan_id));
        return $this->db->delete('rel_planes_categorias');
    }

    public function obtener_disciplinas_por_plan_id($plan_id)
    {
        $this->db->where('plan_id', intval($plan_id));
        return $this->db->get('planes_disciplinas');
    }

    public function obtener_categorias_por_plan_id($plan_id)
    {
        $this->db->where('plan_id', intval($plan_id));
        return $this->db->get('rel_planes_categorias');
    }

    public function obtener_disciplinas_con_detalle_por_plan_id($plan_id)
    {
        $this->db->select('disciplinas.*')
            ->from('disciplinas')
            ->join('planes_disciplinas', 'disciplinas.id = planes_disciplinas.disciplina_id')
            ->join('planes', 'planes.id = planes_disciplinas.plan_id')
            ->where('planes.id', intval($plan_id));
        return $this->db->get();
    }

    public function activar($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('planes', $data); {
            return true;
        }
    }

    public function desactivar($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('planes', $data); {
            return true;
        }
    }

    /**
     * Nuevos metodos Oct 2019
     */

    public function get_planes_normales_disponibles_para_venta()
    {
        $query = $this->db->from('planes')
            ->order_by("orden_venta", "asc")
            ->where('nombre !=', 'Sin plan')
            ->where('categoria', 'normal')
            ->where('activado', '1')
            ->get();

        return $query;
    }

    public function get_planes_online_disponibles_para_venta()
    {
        $query = $this->db->from('planes')
            ->order_by("orden_venta", "asc")
            ->where('nombre !=', 'Sin plan')
            ->where('categoria', 'online')
            ->where('activado', '1')
            ->get();

        return $query;
    }

    public function get_plan_de_suscripcion_para_venta_por_id($id)
    {
        $query = $this->db->from('planes')
            ->where('nombre !=', 'Sin plan')
            ->where('categoria', 'online')
            ->where('activado', '1')
            ->where('id', $id)
            ->get();

        return $query;
    }

    public function get_planes_godin_disponibles_para_venta()
    {
        $query = $this->db->from('planes')
            ->order_by("orden_venta", "asc")
            ->where('nombre !=', 'Sin plan')
            ->where('categoria', 'godin')
            ->where('activado', '1')
            ->get();

        return $query;
    }

    /** 
     * Actualización de métodos jul-2020 (Separación de métodos para planes a la venta de la App, Frontdesk y Panel de clientes).
     * Revisión: Eduardo G.Q.
     */

    public function get_planes_disponibles_para_venta_en_frontdesk()
    {
        $query = $this->db->from('planes')
            ->order_by("orden_venta", "asc")
            ->where('nombre !=', 'Sin plan')
            ->where_in('categoria', array('normal', 'godin', 'online'))
            ->where('activado', '1')
            ->get();

        return $query;
    }

    public function get_planes_disponibles_para_venta_en_la_app()
    {
        $query = $this->db
            ->where('t1.nombre !=', 'Sin plan')
            ->where_in('t1.categoria', array('normal', 'godin'))
            ->where('t1.activado', '1')
            ->select('
                t1.*,
                t3.sucursal_id as disciplinas_sucursal_id,
                t4.categoria_id as rel_planes_categorias_categoria_id,
                t5.url_whatsapp as sucursales_url_whatsapp,
                t5.motor_pago as sucursales_motor_pago
            ')
            ->from('planes t1')
            ->join('planes_disciplinas t2', 't2.plan_id = t1.id')
            ->join('disciplinas t3', 't3.id = t2.disciplina_id')
            ->join('rel_planes_categorias t4', 't4.plan_id = t1.id')
            ->join('sucursales t5', 't5.id = t3.sucursal_id')
            ->group_by(array("t1.id", "t3.sucursal_id", "t4.categoria_id"))
            ->order_by("t1.orden_venta", "asc")
            ->get();

        return $query;
    }

    /** Insane plan */
    public function get_plan_row_disponible_para_venta_en_la_app()
    {
        $query = $this->db
            ->where('id', '1')
            ->where('activado', '1')
            ->where_in('categoria', array('normal', 'godin'))
            ->where('nombre !=', 'Sin plan')
            ->from('planes')
            ->order_by("orden_venta", "asc")
            ->get();

        return $query;
    }

    public function get_planes_disponibles_para_venta_en_el_sistema_de_clientes()
    {
        $query = $this->db->from('planes')
            ->order_by("orden_venta", "asc")
            ->where('nombre !=', 'Sin plan')
            ->where_in('categoria', array('online'))
            ->where('activado', '1')
            ->get();

        return $query;
    }

    public function obtener_planes_sin_codigo()
    {
        $query = $this->db
            ->where('codigo', null)
            ->get('planes');

        return $query;
    }

    public function obtener_planes_por_codigo($codigo)
    {
        $query = $this->db
            ->where('codigo', $codigo)
            ->get('planes');

        return $query;
    }

    public function obtener_planes_con_codigo()
    {
        $query = $this->db
            ->where('codigo !=', null)
            ->get('planes');

        return $query;
    }
}
