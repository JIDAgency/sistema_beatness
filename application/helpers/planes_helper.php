<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('registrar_promocion_primera_clase')) {
    /**
     * Registra la promoción "Primera Clase" para un usuario, creando una asignación y una venta promocional.
     * Además, registra el uso del correo en la tabla de promociones para evitar duplicados.
     * Todo el proceso se ejecuta en una transacción separada, de modo que si falla no interfiere con el registro principal.
     *
     * @param int    $usuario_id   ID del usuario
     * @param int    $sucursal_id  ID de la sucursal
     * @param string $correo       Correo electrónico del usuario
     * @param bool   $enabled      Si true, se registra la promoción; si false, se ignora.
     * @return mixed               Devuelve el ID de la asignación creada o false si no se registró la promoción.
     */
    function registrar_promocion_primera_clase($usuario_id, $sucursal_id, $correo, $enabled = true)
    {
        // Si la promoción no está habilitada, no se hace nada.
        if (!$enabled) {
            return true;
        }

        $CI = &get_instance();
        // Cargar los modelos necesarios
        $CI->load->model('asignaciones_model');
        $CI->load->model('planes_model');
        $CI->load->model('ventas_model');

        // Verificar si el correo ya ha usado la promoción "primera_clase"
        $CI->db->where('correo', $correo);
        $CI->db->where('tipo', 'primera_clase');
        $query = $CI->db->get('registro_promociones');
        if ($query->num_rows() > 0) {
            // Ya se aplicó la promoción para este correo, se evita duplicidad.
            return false;
        }

        $concepto = "PRIMERA CLASE POR REGISTRO";

        // Obtener los planes activos para la sucursal (si los hay)
        $planes = $CI->planes_model->get_planes_activos_por_sucursal($sucursal_id);
        $disciplinas = "";
        if ($planes && $planes->num_rows() > 0) {
            $plan_ids = array();
            foreach ($planes->result() as $plan) {
                $plan_ids[] = $plan->id;
            }
            $disciplinas = implode('|', $plan_ids);
        }

        // Iniciar una transacción separada para el proceso promocional
        $CI->db->trans_start();

        // Preparar los datos para la asignación promocional
        $asignacion_data = array(
            'usuario_id'        => $usuario_id,
            'plan_id'           => 1, // Valor de ejemplo; ajústalo según tu lógica
            'nombre'            => $concepto,
            'clases_incluidas'  => 1,
            'clases_usadas'     => 0,
            'periodo_de_prueba' => 0,
            'vigencia_en_dias'  => 15,  // Vigencia de 15 días (ajustable)
            'es_ilimitado'      => 'no',
            'disciplinas'       => $disciplinas,
            'categoria'         => 'plan',
            'fecha_activacion'  => date('Y-m-d H:i:s'),
            'esta_activo'       => 1,
            'estatus'           => 'Activo'
        );

        $resultado_asignacion = $CI->asignaciones_model->crear($asignacion_data);
        if (!$resultado_asignacion) {
            $CI->db->trans_rollback();
            // Si falla la creación de la asignación, se retorna false pero no interfiere con el registro principal.
            return false;
        }
        $asignacion_id = $CI->db->insert_id();

        // Determinar el método de pago según la sucursal:
        // Por ejemplo: si la sucursal es 2 (Puebla) => "Primera Clase Puebla" (id 17); de lo contrario => "Primera Clase Polanco" (id 18)
        $metodo_pago_id = ($sucursal_id == 2) ? 17 : 18;

        // Registrar la venta promocional (incluso si es 0)
        $venta_data = array(
            'sucursal_id'   => $sucursal_id,
            'usuario_id'    => $usuario_id,
            'asignacion_id' => $asignacion_id,
            'metodo_id'     => $metodo_pago_id,
            'concepto'      => $concepto,
            'costo'         => 0.00,
            'cantidad'      => 1,
            'total'         => 0.00,
            'categoria'     => 'plan',
            'vendedor'      => 'Promoción', // Indica el origen de la venta
            'estatus'       => 'Vendido',
            'fecha_venta'   => date('Y-m-d H:i:s')
        );

        $resultado_venta = $CI->ventas_model->crear($venta_data);
        // Si la venta falla, no se interrumpe el proceso principal

        // Registrar el uso de la promoción en la tabla "registro_promociones"
        $data_promocion = array(
            'correo' => $correo,
            'tipo'   => 'primera_clase'
        );
        $CI->db->insert('registro_promociones', $data_promocion);

        $CI->db->trans_complete();

        // Si la transacción falló en alguna parte, se retorna false (aunque no afectará el registro principal)
        if ($CI->db->trans_status() === FALSE) {
            return false;
        }

        return $asignacion_id;
    }
}
