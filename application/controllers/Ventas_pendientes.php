<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ventas_pendientes extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ventas_pendientes_model');
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Ventas pendientes';
        $data['pagina_subtitulo'] = 'Registro de ventas pendientes de autorizar';
        $data['pagina_menu_clientes'] = true;

        $data['controlador'] = 'ventas_pendientes';
        $data['regresar_a'] = 'ventas';
        $controlador_js = "ventas_pendientes/index";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('ventas_pendientes/index', $data);
    }

    public function obtener_tabla_index()
    {
        // Obtener parámetros de DataTables
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        // Obtener datos de ventas pendientes con detalles
        $ventas = $this->ventas_pendientes_model->obtener_todas_con_detalles($start_date, $end_date)->result();

        // Paginar datos
        $totalRecords = count($ventas);

        // Preparar datos para DataTables
        $data = array();
        foreach ($ventas as $venta) {
            $row = array();
            switch ($venta->estatus_validacion) {
                case 'pendiente':
                    $row['opciones'] = '';
                    $row['opciones'] .= '<a href="javascript:void(0);" id="validar-btn-' . $venta->id . '" onclick="validar(' . $venta->id . ', this);">Validar</a>';
                    $row['opciones'] .= ' | ';
                    $row['opciones'] .= '<a href="javascript:void(0);" id="rechazar-btn-' . $venta->id . '" onclick="rechazar(' . $venta->id . ', this);">Rechazar</a>';
                    break;
                case 'rechazado':
                    $row['opciones'] = '<span class="text-danger">Rechazado</span>';
                    break;
                case 'aprobado':
                    $row['opciones'] = '<span class="text-success">Aprobado</span>';
                    break;
                default:
                    $row['opciones'] = '<span class="text-secondary">Desconocido</span>';
                    break;
            }
            $row['id'] = $venta->id;
            $row['estatus_validacion'] = mb_strtoupper($venta->estatus_validacion);
            $row['concepto'] = $venta->concepto;
            $row['venta_id'] = isset($venta->venta_id) && $venta->venta_id ? '<a href="' . site_url('ventas') . '" target="_blank" rel="noopener noreferrer">#' . $venta->venta_id . '</a>' : 'No asignado';
            $row['metodo_de_pago'] = $venta->metodo_de_pago;
            $row['comprador'] = $venta->comprador . " #" . $venta->usuario_id;
            $row['categoria'] = ucwords($venta->categoria);
            $row['estatus'] = ucwords($venta->estatus);
            $row['costo'] = $venta->costo;
            $row['cantidad'] = $venta->cantidad;
            $row['total'] = $venta->total;
            $row['fecha_venta'] = date("d/m/Y H:i:s", strtotime($venta->fecha_venta));
            $row['usuario_id'] = "#" . $venta->usuario_id;
            $row['comprador_correo'] = $venta->comprador_correo;
            $row['comprador_nombre_completo'] = $venta->comprador_nombre_completo;
            $row['asignacion_id'] = "#" . $venta->asignacion_id;
            $row['asignacion'] = $venta->asignacion_nombre . " #" . $venta->asignacion_plan_id;
            $row['asignacion_vigencia_en_dias'] = $venta->asignacion_vigencia_en_dias . " día/s";
            $row['asignacion_clases_del_plan'] = ($venta->asignacion_plan_id != 14 ? $venta->asignacion_clases_usadas . "/" . $venta->asignacion_clases_incluidas . " Clases reservadas" : $venta->asignacion_clases_usadas . " Video-clases vistas");
            $row['sucursal'] = $venta->sucursal_nombre . " " . $venta->sucursal_locacion;
            $row['vendedor'] = $venta->vendedor;
            $data[] = $row;
        }

        // Enviar respuesta en formato JSON
        $response = array(
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        );

        echo json_encode($response);
        exit();
    }

    public function obtener_datos_venta($id)
    {
        $venta = $this->ventas_pendientes_model->obtener_por_id_con_detalles($id)->row();
        if ($venta) {
            $precios = [
                'Bootcamp y Cycling Puebla' => 220.28,
                'Cycling Polanco' => 200.00,
                'Bootcamp Polanco' => 218.54
            ];

            $precio_asignado = $venta->total; // Valor por defecto

            if ($venta->sucursal_id == 2) {
                $precio_asignado = $precios['Bootcamp y Cycling Puebla'];
            } elseif ($venta->sucursal_id == 3) {
                if (strpos($venta->concepto, 'Cycling - Polanco') !== false) {
                    $precio_asignado = $precios['Cycling Polanco'];
                } elseif (strpos($venta->concepto, 'Bootcamp - Polanco') !== false) {
                    $precio_asignado = $precios['Bootcamp Polanco'];
                }
            }

            $response = [
                'status' => 'success',
                'data' => $venta,
                'precios' => $precios,
                'precio_asignado' => $precio_asignado
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Venta no encontrada #' . $id
            ];
        }

        echo json_encode($response);
    }

    public function validar()
    {
        $this->db->trans_begin(); // Iniciar transacción

        try {
            // Leer la entrada cruda (JSON)
            $input_data = json_decode($this->input->raw_input_stream, true);

            // Validar que el JSON se haya decodificado correctamente
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
            }

            // Tomar el ID y el precio modificado desde el JSON decodificado
            $id = $input_data['id'] ?? null;
            $precio_modificado = $input_data['precio_modificado'] ?? null;

            if (!$id || !$precio_modificado) {
                throw new Exception('ID o precio modificado no proporcionado');
            }

            // Lógica para actualizar el estatus a "APROBADO" y el precio modificado
            $actualizado = $this->ventas_pendientes_model->actualizar($id, [
                'estatus_validacion' => 'aprobado',
                'costo' => $precio_modificado,
                'total' => $precio_modificado,
                'revisor_id' => $this->session->userdata('id'),
                'revisor_correo' => $this->session->userdata('correo')
            ]);
            if (!$actualizado) {
                throw new Exception('Error al actualizar el estatus');
            }

            // Obtener el registro actualizado
            $dato_value = $this->ventas_pendientes_model->obtener_por_id($id);
            if (!$dato_value) {
                throw new Exception('Error al obtener el registro actualizado');
            }

            // Preparar los datos para la migración
            $venta_data = [
                'sucursal_id' => $dato_value->sucursal_id,
                'usuario_id' => $dato_value->usuario_id,
                'asignacion_id' => $dato_value->asignacion_id,
                'asignaciones_id' => $dato_value->asignaciones_id,
                'metodo_id' => $dato_value->metodo_id,
                'concepto' => $dato_value->concepto . ' REVISADA',
                'costo' => $dato_value->costo,
                'cantidad' => $dato_value->cantidad,
                'total' => $dato_value->total,
                'categoria' => $dato_value->categoria,
                'vendedor' => $dato_value->vendedor,
                'estatus' => 'Vendido', // Asumiendo que el estatus es "Vendido" al migrar
                'fecha_venta' => $dato_value->fecha_venta
            ];

            if (!$this->ventas_pendientes_model->migrar($venta_data)) {
                throw new Exception('Error al migrar la venta');
            }

            // Actualizar el campo venta_id en la tabla de ventas pendientes
            $actualizado = $this->ventas_pendientes_model->actualizar($id, ['venta_id' => $this->db->insert_id()]);
            if (!$actualizado) {
                throw new Exception('Error al actualizar el campo venta_id');
            }

            // Confirmar transacción
            $this->db->trans_commit();

            // Responder con el registro actualizado
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Validación exitosa',
                    'data' => [
                        'id' => $dato_value->id,
                        'estatus_validacion' => mb_strtoupper($dato_value->estatus_validacion)
                    ]
                ]));
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->db->trans_rollback();

            // Registrar el error para depuración
            log_message('error', 'Error en la validación: ' . $e->getMessage());

            // Responder con el mensaje de error
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }

    public function rechazar()
    {
        $this->db->trans_begin(); // Iniciar transacción

        try {
            // Leer la entrada cruda (JSON)
            $input_data = json_decode($this->input->raw_input_stream, true);

            // Validar que el JSON se haya decodificado correctamente
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
            }

            // Tomar el ID desde el JSON decodificado
            $id = $input_data['id'] ?? null;

            if (!$id) {
                throw new Exception('ID no proporcionado');
            }

            // Lógica para actualizar el estatus a "RECHAZADO"
            $actualizado = $this->ventas_pendientes_model->actualizar($id, ['estatus_validacion' => 'rechazado']);
            if (!$actualizado) {
                throw new Exception('Error al actualizar el estatus');
            }

            // Confirmar transacción
            $this->db->trans_commit();

            // Responder con el registro actualizado
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Rechazo exitoso'
                ]));
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->db->trans_rollback();

            // Registrar el error para depuración
            log_message('error', 'Error en el rechazo: ' . $e->getMessage());

            // Responder con el mensaje de error
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }
}
