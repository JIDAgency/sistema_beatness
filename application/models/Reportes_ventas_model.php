<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reportes_ventas_model extends CI_Model
{
    public function obtener_todas()
    {
        $this->db->select(
            "ventas.*,
         asignaciones.clases_incluidas,
         asignaciones.clases_usadas,
         asignaciones.vigencia_en_dias,
         asignaciones.fecha_activacion,
         CONCAT(
            COALESCE(usuarios.nombre_completo, 'N/D'), ' ', 
            COALESCE(usuarios.apellido_paterno, 'N/D'), ' ', 
            COALESCE(usuarios.apellido_materno, 'N/D')
         ) as usuario,
         sucursales.locacion as sucursales_locacion,
         metodos_pago.nombre as metodo"
        )
            ->from("ventas")
            ->join("asignaciones", "ventas.asignacion_id = asignaciones.id")
            ->join("usuarios", "ventas.usuario_id = usuarios.id")
            ->join("metodos_pago", "ventas.metodo_id = metodos_pago.id")
            ->join("sucursales", "ventas.sucursal_id = sucursales.id");

        $resultados = $this->db->get();
        return $resultados;
    }
}
