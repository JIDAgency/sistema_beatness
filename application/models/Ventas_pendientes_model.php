<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ventas_pendientes_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Método para obtener todas las ventas pendientes
    public function obtener_todas()
    {
        $query = $this->db->get('ventas_pendientes');
        return $query;
    }

    // Función para obtener un registro por ID
    public function obtener_por_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ventas_pendientes');
        return $query->row();
    }

    // Método para insertar una nueva venta pendiente
    public function insertar($data)
    {
        return $this->db->insert('ventas_pendientes', $data);
    }

    // Método para migrar una venta pendiente que han sido aprobadas
    public function migrar($data)
    {
        return $this->db->insert('ventas', $data);
    }

    // Método para actualizar una venta pendiente
    public function actualizar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ventas_pendientes', $data);
    }

    // Método para borrar una venta pendiente
    public function borrar($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('ventas_pendientes');
    }

    public function obtener_todas_con_detalles($start_date = null, $end_date = null)
    {
        $this->db
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
                t6.dominio_id as plan_dominio_id
            ")
            ->from("ventas_pendientes t1")
            ->join("metodos_pago t2", "t1.metodo_id = t2.id", "left")
            ->join("usuarios t3", "t1.usuario_id = t3.id", "left")
            ->join("sucursales t4", "t1.sucursal_id = t4.id", "left")
            ->join("asignaciones t5", "t1.asignacion_id = t5.id", "left")
            ->join("planes t6", "t5.plan_id = t6.id", "left");

        if ($start_date) {
            $this->db->where('DATE_FORMAT(t1.fecha_venta, "%Y-%m-%d") >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('DATE_FORMAT(t1.fecha_venta, "%Y-%m-%d") <=', $end_date);
        }

        $query = $this->db->get();

        return $query;
    }
}
