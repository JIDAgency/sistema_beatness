<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ventas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('asignaciones_model');
        $this->load->model('disciplinas_model');
        $this->load->model('metodos_model');
        $this->load->model('planes_model');
        $this->load->model('sucursales_model');
        $this->load->model('usuarios_model');
        $this->load->model('ventas_model');
    }

    /** Vistas */

    public function index($var = null)
    {
        /** Carga los datos del menu */
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Ventas';

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "ventas/index";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),

        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'ventas';
        $data['regresar_a'] = 'inicio';

        /** Contenido de la vista */
        $start = (new DateTime('2019-01-07'))->modify('first day of this month');
        $end = (new DateTime(date('Y-m-d')))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');

        $data['period'] = new DatePeriod($start, $interval, $end);

        $resultados_mes_actual = $this->get_numeros_de_ventas_del_mes_para_fd_con_permisos_vista();

        $data['resultados_mes_actual'] = $resultados_mes_actual;

        $this->construir_private_site_ui('ventas/index', $data);
    }

    /** Esta función consulta los datos necesarios de JS en formato JSON desde controlador para el REPORTE de ventas mensual. */
    public function get_numeros_de_ventas_del_mes_para_fd_con_permisos($mes_a_consultar = null)
    {

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        if ($mes_a_consultar == null) {
            $ventas_list = $this->ventas_model->get_lista_de_ventas_del_mes_para_fd_global($curr_date)->result();
            $mes_reportado = $curr_date;
        } else {
            $ventas_list = $this->ventas_model->get_lista_de_ventas_del_mes_para_fd_global($mes_a_consultar)->result();
            $mes_reportado = $mes_a_consultar;
        }

        /** Datos generales [inicio] */
        /** Numeros */
        $no_ventas_total = 0;
        $no_ventas_canceladas_total = 0;
        $no_ventas_efectivo = 0;
        $no_ventas_tarjeta = 0;
        $no_ventas_openpay = 0;
        $no_ventas_openpay_b3 = 0;
        $no_ventas_openpay_insan3 = 0;
        $no_ventas_b3family = 0;
        $no_ventas_suscripcion = 0;
        $no_periodos_prueba_suscripcion = 0;
        /** Totales en $$ */
        $ventas_total = 0;
        $ventas_efectivo = 0;
        $ventas_tarjeta = 0;
        $ventas_openpay = 0;
        $ventas_openpay_b3 = 0;
        $ventas_openpay_insan3 = 0;
        $ventas_b3family = 0;
        $ventas_suscripcion = 0;
        $periodos_prueba_suscripcion = 0;
        /** Datos generales [fin] */

        /** Datos B3 [inicio] */
        /** Numeros */
        $b3_no_ventas_total = 0;
        $b3_no_ventas_efectivo = 0;
        $b3_no_ventas_tarjeta = 0;
        $b3_no_ventas_openpay = 0;
        $b3_no_ventas_b3family = 0;
        $b3_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $b3_ventas_total = 0;
        $b3_ventas_efectivo = 0;
        $b3_ventas_tarjeta = 0;
        $b3_ventas_openpay = 0;
        $b3_ventas_b3family = 0;
        $b3_ventas_suscripcion = 0;
        /** Datos B3 [fin] */

        /** Datos VELA [inicio] */
        /** Numeros */
        $vela_no_ventas_total = 0;
        $vela_no_ventas_efectivo = 0;
        $vela_no_ventas_tarjeta = 0;
        $vela_no_ventas_openpay = 0;
        $vela_no_ventas_b3family = 0;
        $vela_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $vela_ventas_total = 0;
        $vela_ventas_efectivo = 0;
        $vela_ventas_tarjeta = 0;
        $vela_ventas_openpay = 0;
        $vela_ventas_b3family = 0;
        $vela_ventas_suscripcion = 0;
        /** Datos VELA [fin] */

        /** Datos DORADO [inicio] */
        /** Numeros */
        $dorado_no_ventas_total = 0;
        $dorado_no_ventas_efectivo = 0;
        $dorado_no_ventas_tarjeta = 0;
        $dorado_no_ventas_openpay = 0;
        $dorado_no_ventas_b3family = 0;
        $dorado_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $dorado_ventas_total = 0;
        $dorado_ventas_efectivo = 0;
        $dorado_ventas_tarjeta = 0;
        $dorado_ventas_openpay = 0;
        $dorado_ventas_b3family = 0;
        $dorado_ventas_suscripcion = 0;
        /** Datos DORADO [fin] */

        /** Datos insan3 [inicio] */
        /** Numeros */
        $insan3_no_ventas_total = 0;
        $insan3_no_ventas_efectivo = 0;
        $insan3_no_ventas_tarjeta = 0;
        $insan3_no_ventas_openpay = 0;
        $insan3_no_ventas_b3family = 0;
        $insan3_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $insan3_ventas_total = 0;
        $insan3_ventas_efectivo = 0;
        $insan3_ventas_tarjeta = 0;
        $insan3_ventas_openpay = 0;
        $insan3_ventas_b3family = 0;
        $insan3_ventas_suscripcion = 0;
        /** Datos insan3 [fin] */

        foreach ($ventas_list as $venta_row) {
            /** Totales */
            if ($venta_row->estatus != "Cancelada") {
                $no_ventas_total++;
                $ventas_total += $venta_row->total;
            }

            if ($venta_row->estatus == "Cancelada") {
                $no_ventas_canceladas_total++;
            }

            /** Metodos de pago generales*/
            if ($venta_row->metodo_de_pago == "Efectivo") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_efectivo++;
                    $ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_tarjeta++;
                    $ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay++;
                    $ventas_openpay += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay" and $venta_row->plan_dominio_id == "1") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay_b3++;
                    $ventas_openpay_b3 += $venta_row->total;

                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay" and $venta_row->plan_dominio_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay_insan3++;
                    $ventas_openpay_insan3 += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_b3family++;
                    $ventas_b3family += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Suscripción") {

                if ($venta_row->estatus == "Vendido") {
                    $no_ventas_suscripcion++;
                    $ventas_suscripcion += $venta_row->total;

                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
                if ($venta_row->estatus == "prueba") {
                    $no_periodos_prueba_suscripcion++;
                    $periodos_prueba_suscripcion += $venta_row->total;
                }
            }

            /** Metodos de pago B3*/

            if (in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_efectivo++;
                    $b3_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_tarjeta++;
                    $b3_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_b3family++;
                    $b3_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago VELA*/

            if ($venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_total++;
                    $vela_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_efectivo++;
                    $vela_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_tarjeta++;
                    $vela_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_b3family++;
                    $vela_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago DORADO*/

            if ($venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_total++;
                    $dorado_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_efectivo++;
                    $dorado_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_tarjeta++;
                    $dorado_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_b3family++;
                    $dorado_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago insan3*/

            if ($venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_total++;
                    $insan3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_efectivo++;
                    $insan3_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_tarjeta++;
                    $insan3_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_b3family++;
                    $insan3_ventas_b3family += $venta_row->total;
                }
            }
        }

        $resultado = array(
            /** Totales */
            "mes_reportado" => $mes_reportado,

            /** Metodos de pago generales*/
            "no_ventas" => $no_ventas_total,
            "ventas_total" => "$ " . number_format($ventas_total, 2, '.', ','),

            "no_ventas_canceladas_total" => $no_ventas_canceladas_total,

            "no_ventas_efectivo" => $no_ventas_efectivo,
            "ventas_efectivo" => "$ " . number_format($ventas_efectivo, 2, '.', ','),

            "no_ventas_tarjeta" => $no_ventas_tarjeta,
            "ventas_tarjeta" => "$ " . number_format($ventas_tarjeta, 2, '.', ','),

            "no_ventas_openpay" => $no_ventas_openpay,
            "ventas_openpay" => "$ " . number_format($ventas_openpay, 2, '.', ','),

            "no_ventas_openpay_b3" => $no_ventas_openpay_b3,
            "ventas_openpay_b3" => "$ " . number_format($ventas_openpay_b3, 2, '.', ','),

            "no_ventas_openpay_insan3" => $no_ventas_openpay_insan3,
            "ventas_openpay_insan3" => "$ " . number_format($ventas_openpay_insan3, 2, '.', ','),

            "no_ventas_b3family" => $no_ventas_b3family,
            "ventas_b3family" => "$ " . number_format($ventas_b3family, 2, '.', ','),

            "no_ventas_suscripcion" => $no_ventas_suscripcion,
            "ventas_suscripcion" => "$ " . number_format($ventas_suscripcion, 2, '.', ','),

            "no_periodos_prueba_suscripcion" => $no_periodos_prueba_suscripcion,
            "periodos_prueba_suscripcion" => "$ " . number_format($periodos_prueba_suscripcion, 2, '.', ','),

            /** Metodos de pago VELA*/
            "b3_no_ventas_total" => $b3_no_ventas_total,
            "b3_ventas_total" => "$ " . number_format($b3_ventas_total, 2, '.', ','),

            "b3_no_ventas_efectivo" => $b3_no_ventas_efectivo,
            "b3_ventas_efectivo" => "$ " . number_format($b3_ventas_efectivo, 2, '.', ','),

            "b3_no_ventas_tarjeta" => $b3_no_ventas_tarjeta,
            "b3_ventas_tarjeta" => "$ " . number_format($b3_ventas_tarjeta, 2, '.', ','),

            "b3_no_ventas_b3family" => $b3_no_ventas_b3family,
            "b3_ventas_b3family" => "$ " . number_format($b3_ventas_b3family, 2, '.', ','),

            /** Metodos de pago VELA*/
            "vela_no_ventas_total" => $vela_no_ventas_total,
            "vela_ventas_total" => "$ " . number_format($vela_ventas_total, 2, '.', ','),

            "vela_no_ventas_efectivo" => $vela_no_ventas_efectivo,
            "vela_ventas_efectivo" => "$ " . number_format($vela_ventas_efectivo, 2, '.', ','),

            "vela_no_ventas_tarjeta" => $vela_no_ventas_tarjeta,
            "vela_ventas_tarjeta" => "$ " . number_format($vela_ventas_tarjeta, 2, '.', ','),

            "vela_no_ventas_b3family" => $vela_no_ventas_b3family,
            "vela_ventas_b3family" => "$ " . number_format($vela_ventas_b3family, 2, '.', ','),

            /** Metodos de pago DORADO*/
            "dorado_no_ventas_total" => $dorado_no_ventas_total,
            "dorado_ventas_total" => "$ " . number_format($dorado_ventas_total, 2, '.', ','),

            "dorado_no_ventas_efectivo" => $dorado_no_ventas_efectivo,
            "dorado_ventas_efectivo" => "$ " . number_format($dorado_ventas_efectivo, 2, '.', ','),

            "dorado_no_ventas_tarjeta" => $dorado_no_ventas_tarjeta,
            "dorado_ventas_tarjeta" => "$ " . number_format($dorado_ventas_tarjeta, 2, '.', ','),

            "dorado_no_ventas_b3family" => $dorado_no_ventas_b3family,
            "dorado_ventas_b3family" => "$ " . number_format($dorado_ventas_b3family, 2, '.', ','),

            /** Metodos de pago insan3*/
            "insan3_no_ventas_total" => $insan3_no_ventas_total,
            "insan3_ventas_total" => "$ " . number_format($insan3_ventas_total, 2, '.', ','),

            "insan3_no_ventas_efectivo" => $insan3_no_ventas_efectivo,
            "insan3_ventas_efectivo" => "$ " . number_format($insan3_ventas_efectivo, 2, '.', ','),

            "insan3_no_ventas_tarjeta" => $insan3_no_ventas_tarjeta,
            "insan3_ventas_tarjeta" => "$ " . number_format($insan3_ventas_tarjeta, 2, '.', ','),

            "insan3_no_ventas_b3family" => $insan3_no_ventas_b3family,
            "insan3_ventas_b3family" => "$ " . number_format($insan3_ventas_b3family, 2, '.', ','),
        );

        echo json_encode(array("data" => $resultado));
        exit();
    }

    /** Esta función consulta los datos necesarios desde controlador para el REPORTE de ventas mensual. */
    public function get_numeros_de_ventas_del_mes_para_fd_con_permisos_vista($mes_a_consultar = null)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m');

        if ($mes_a_consultar == null) {
            $ventas_list = $this->ventas_model->get_lista_de_ventas_del_mes_para_fd_global($curr_date)->result();
            $mes_reportado = $curr_date;
        } else {
            $ventas_list = $this->ventas_model->get_lista_de_ventas_del_mes_para_fd_global($mes_a_consultar)->result();
            $mes_reportado = $mes_a_consultar;
        }

        /** Datos generales [inicio] */
        /** Numeros */
        $no_ventas_total = 0;
        $no_ventas_canceladas_total = 0;
        $no_ventas_efectivo = 0;
        $no_ventas_tarjeta = 0;
        $no_ventas_openpay = 0;
        $no_ventas_openpay_b3 = 0;
        $no_ventas_openpay_insan3 = 0;
        $no_ventas_b3family = 0;
        $no_ventas_suscripcion = 0;
        $no_periodos_prueba_suscripcion = 0;
        /** Totales en $$ */
        $ventas_total = 0;
        $ventas_efectivo = 0;
        $ventas_tarjeta = 0;
        $ventas_openpay = 0;
        $ventas_openpay_b3 = 0;
        $ventas_openpay_insan3 = 0;
        $ventas_b3family = 0;
        $ventas_suscripcion = 0;
        $periodos_prueba_suscripcion = 0;
        /** Datos generales [fin] */

        /** Datos B3 [inicio] */
        /** Numeros */
        $b3_no_ventas_total = 0;
        $b3_no_ventas_efectivo = 0;
        $b3_no_ventas_tarjeta = 0;
        $b3_no_ventas_openpay = 0;
        $b3_no_ventas_b3family = 0;
        $b3_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $b3_ventas_total = 0;
        $b3_ventas_efectivo = 0;
        $b3_ventas_tarjeta = 0;
        $b3_ventas_openpay = 0;
        $b3_ventas_b3family = 0;
        $b3_ventas_suscripcion = 0;
        /** Datos B3 [fin] */

        /** Datos VELA [inicio] */
        /** Numeros */
        $vela_no_ventas_total = 0;
        $vela_no_ventas_efectivo = 0;
        $vela_no_ventas_tarjeta = 0;
        $vela_no_ventas_openpay = 0;
        $vela_no_ventas_b3family = 0;
        $vela_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $vela_ventas_total = 0;
        $vela_ventas_efectivo = 0;
        $vela_ventas_tarjeta = 0;
        $vela_ventas_openpay = 0;
        $vela_ventas_b3family = 0;
        $vela_ventas_suscripcion = 0;
        /** Datos VELA [fin] */

        /** Datos DORADO [inicio] */
        /** Numeros */
        $dorado_no_ventas_total = 0;
        $dorado_no_ventas_efectivo = 0;
        $dorado_no_ventas_tarjeta = 0;
        $dorado_no_ventas_openpay = 0;
        $dorado_no_ventas_b3family = 0;
        $dorado_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $dorado_ventas_total = 0;
        $dorado_ventas_efectivo = 0;
        $dorado_ventas_tarjeta = 0;
        $dorado_ventas_openpay = 0;
        $dorado_ventas_b3family = 0;
        $dorado_ventas_suscripcion = 0;
        /** Datos DORADO [fin] */

        /** Datos insan3 [inicio] */
        /** Numeros */
        $insan3_no_ventas_total = 0;
        $insan3_no_ventas_efectivo = 0;
        $insan3_no_ventas_tarjeta = 0;
        $insan3_no_ventas_openpay = 0;
        $insan3_no_ventas_b3family = 0;
        $insan3_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $insan3_ventas_total = 0;
        $insan3_ventas_efectivo = 0;
        $insan3_ventas_tarjeta = 0;
        $insan3_ventas_openpay = 0;
        $insan3_ventas_b3family = 0;
        $insan3_ventas_suscripcion = 0;
        /** Datos insan3 [fin] */

        foreach ($ventas_list as $venta_row) {
            /** Totales */
            if ($venta_row->estatus != "Cancelada") {
                $no_ventas_total++;
                $ventas_total += $venta_row->total;
            }

            if ($venta_row->estatus == "Cancelada") {
                $no_ventas_canceladas_total++;
            }

            /** Metodos de pago generales*/
            if ($venta_row->metodo_de_pago == "Efectivo") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_efectivo++;
                    $ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_tarjeta++;
                    $ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay++;
                    $ventas_openpay += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay" and $venta_row->plan_dominio_id == "1") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay_b3++;
                    $ventas_openpay_b3 += $venta_row->total;

                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay" and $venta_row->plan_dominio_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay_insan3++;
                    $ventas_openpay_insan3 += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_b3family++;
                    $ventas_b3family += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Suscripción") {

                if ($venta_row->estatus == "Vendido") {
                    $no_ventas_suscripcion++;
                    $ventas_suscripcion += $venta_row->total;

                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
                if ($venta_row->estatus == "prueba") {
                    $no_periodos_prueba_suscripcion++;
                    $periodos_prueba_suscripcion += $venta_row->total;
                }
            }

            /** Metodos de pago B3*/

            if (in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_efectivo++;
                    $b3_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_tarjeta++;
                    $b3_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_b3family++;
                    $b3_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago VELA*/

            if ($venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_total++;
                    $vela_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_efectivo++;
                    $vela_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_tarjeta++;
                    $vela_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_b3family++;
                    $vela_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago DORADO*/

            if ($venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_total++;
                    $dorado_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_efectivo++;
                    $dorado_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_tarjeta++;
                    $dorado_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_b3family++;
                    $dorado_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago insan3*/

            if ($venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_total++;
                    $insan3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_efectivo++;
                    $insan3_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_tarjeta++;
                    $insan3_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_b3family++;
                    $insan3_ventas_b3family += $venta_row->total;
                }
            }
        }

        $resultado = array(
            /** Totales */
            "mes_reportado" => $mes_reportado,

            /** Metodos de pago generales*/
            "no_ventas" => $no_ventas_total,
            "ventas_total" => "$ " . number_format($ventas_total, 2, '.', ','),

            "no_ventas_canceladas_total" => $no_ventas_canceladas_total,

            "no_ventas_efectivo" => $no_ventas_efectivo,
            "ventas_efectivo" => "$ " . number_format($ventas_efectivo, 2, '.', ','),

            "no_ventas_tarjeta" => $no_ventas_tarjeta,
            "ventas_tarjeta" => "$ " . number_format($ventas_tarjeta, 2, '.', ','),

            "no_ventas_openpay" => $no_ventas_openpay,
            "ventas_openpay" => "$ " . number_format($ventas_openpay, 2, '.', ','),

            "no_ventas_openpay_b3" => $no_ventas_openpay_b3,
            "ventas_openpay_b3" => "$ " . number_format($ventas_openpay_b3, 2, '.', ','),

            "no_ventas_openpay_insan3" => $no_ventas_openpay_insan3,
            "ventas_openpay_insan3" => "$ " . number_format($ventas_openpay_insan3, 2, '.', ','),

            "no_ventas_b3family" => $no_ventas_b3family,
            "ventas_b3family" => "$ " . number_format($ventas_b3family, 2, '.', ','),

            "no_ventas_suscripcion" => $no_ventas_suscripcion,
            "ventas_suscripcion" => "$ " . number_format($ventas_suscripcion, 2, '.', ','),

            "no_periodos_prueba_suscripcion" => $no_periodos_prueba_suscripcion,
            "periodos_prueba_suscripcion" => "$ " . number_format($periodos_prueba_suscripcion, 2, '.', ','),

            /** Metodos de pago B3*/
            "b3_no_ventas_total" => $b3_no_ventas_total,
            "b3_ventas_total" => "$ " . number_format($b3_ventas_total, 2, '.', ','),

            "b3_no_ventas_efectivo" => $b3_no_ventas_efectivo,
            "b3_ventas_efectivo" => "$ " . number_format($b3_ventas_efectivo, 2, '.', ','),

            "b3_no_ventas_tarjeta" => $b3_no_ventas_tarjeta,
            "b3_ventas_tarjeta" => "$ " . number_format($b3_ventas_tarjeta, 2, '.', ','),

            "b3_no_ventas_b3family" => $b3_no_ventas_b3family,
            "b3_ventas_b3family" => "$ " . number_format($b3_ventas_b3family, 2, '.', ','),

            /** Metodos de pago VELA*/
            "vela_no_ventas_total" => $vela_no_ventas_total,
            "vela_ventas_total" => "$ " . number_format($vela_ventas_total, 2, '.', ','),

            "vela_no_ventas_efectivo" => $vela_no_ventas_efectivo,
            "vela_ventas_efectivo" => "$ " . number_format($vela_ventas_efectivo, 2, '.', ','),

            "vela_no_ventas_tarjeta" => $vela_no_ventas_tarjeta,
            "vela_ventas_tarjeta" => "$ " . number_format($vela_ventas_tarjeta, 2, '.', ','),

            "vela_no_ventas_b3family" => $vela_no_ventas_b3family,
            "vela_ventas_b3family" => "$ " . number_format($vela_ventas_b3family, 2, '.', ','),

            /** Metodos de pago DORADO*/
            "dorado_no_ventas_total" => $dorado_no_ventas_total,
            "dorado_ventas_total" => "$ " . number_format($dorado_ventas_total, 2, '.', ','),

            "dorado_no_ventas_efectivo" => $dorado_no_ventas_efectivo,
            "dorado_ventas_efectivo" => "$ " . number_format($dorado_ventas_efectivo, 2, '.', ','),

            "dorado_no_ventas_tarjeta" => $dorado_no_ventas_tarjeta,
            "dorado_ventas_tarjeta" => "$ " . number_format($dorado_ventas_tarjeta, 2, '.', ','),

            "dorado_no_ventas_b3family" => $dorado_no_ventas_b3family,
            "dorado_ventas_b3family" => "$ " . number_format($dorado_ventas_b3family, 2, '.', ','),

            /** Metodos de pago insan3*/
            "insan3_no_ventas_total" => $insan3_no_ventas_total,
            "insan3_ventas_total" => "$ " . number_format($insan3_ventas_total, 2, '.', ','),

            "insan3_no_ventas_efectivo" => $insan3_no_ventas_efectivo,
            "insan3_ventas_efectivo" => "$ " . number_format($insan3_ventas_efectivo, 2, '.', ','),

            "insan3_no_ventas_tarjeta" => $insan3_no_ventas_tarjeta,
            "insan3_ventas_tarjeta" => "$ " . number_format($insan3_ventas_tarjeta, 2, '.', ','),

            "insan3_no_ventas_b3family" => $insan3_no_ventas_b3family,
            "insan3_ventas_b3family" => "$ " . number_format($insan3_ventas_b3family, 2, '.', ','),
        );

        return array("data" => $resultado);
        exit();
    }

    /** Esta función consulta los datos necesarios de JS en formato JSON desde controlador para el REPORTE de ventas diario. */
    public function get_numeros_de_ventas_del_dia_para_fd_con_permisos($dia_a_consultar = null)
    {

        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d');

        if ($dia_a_consultar == null) {
            $ventas_list = $this->ventas_model->get_lista_de_ventas_del_dia_para_fd_global($curr_date)->result();
            $mes_reportado = $curr_date;
        } else {
            $ventas_list = $this->ventas_model->get_lista_de_ventas_del_dia_para_fd_global($dia_a_consultar)->result();
            $mes_reportado = $dia_a_consultar;
        }

        /** Datos generales [inicio] */
        /** Numeros */
        $no_ventas_total = 0;
        $no_ventas_canceladas_total = 0;
        $no_ventas_efectivo = 0;
        $no_ventas_tarjeta = 0;
        $no_ventas_openpay = 0;
        $no_ventas_openpay_b3 = 0;
        $no_ventas_openpay_insan3 = 0;
        $no_ventas_b3family = 0;
        $no_ventas_suscripcion = 0;
        $no_periodos_prueba_suscripcion = 0;
        /** Totales en $$ */
        $ventas_total = 0;
        $ventas_efectivo = 0;
        $ventas_tarjeta = 0;
        $ventas_openpay = 0;
        $ventas_openpay_b3 = 0;
        $ventas_openpay_insan3 = 0;
        $ventas_b3family = 0;
        $ventas_suscripcion = 0;
        $periodos_prueba_suscripcion = 0;
        /** Datos generales [fin] */

        /** Datos B3 [inicio] */
        /** Numeros */
        $b3_no_ventas_total = 0;
        $b3_no_ventas_efectivo = 0;
        $b3_no_ventas_tarjeta = 0;
        $b3_no_ventas_openpay = 0;
        $b3_no_ventas_b3family = 0;
        $b3_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $b3_ventas_total = 0;
        $b3_ventas_efectivo = 0;
        $b3_ventas_tarjeta = 0;
        $b3_ventas_openpay = 0;
        $b3_ventas_b3family = 0;
        $b3_ventas_suscripcion = 0;
        /** Datos B3 [fin] */

        /** Datos VELA [inicio] */
        /** Numeros */
        $vela_no_ventas_total = 0;
        $vela_no_ventas_efectivo = 0;
        $vela_no_ventas_tarjeta = 0;
        $vela_no_ventas_openpay = 0;
        $vela_no_ventas_b3family = 0;
        $vela_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $vela_ventas_total = 0;
        $vela_ventas_efectivo = 0;
        $vela_ventas_tarjeta = 0;
        $vela_ventas_openpay = 0;
        $vela_ventas_b3family = 0;
        $vela_ventas_suscripcion = 0;
        /** Datos VELA [fin] */

        /** Datos DORADO [inicio] */
        /** Numeros */
        $dorado_no_ventas_total = 0;
        $dorado_no_ventas_efectivo = 0;
        $dorado_no_ventas_tarjeta = 0;
        $dorado_no_ventas_openpay = 0;
        $dorado_no_ventas_b3family = 0;
        $dorado_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $dorado_ventas_total = 0;
        $dorado_ventas_efectivo = 0;
        $dorado_ventas_tarjeta = 0;
        $dorado_ventas_openpay = 0;
        $dorado_ventas_b3family = 0;
        $dorado_ventas_suscripcion = 0;
        /** Datos DORADO [fin] */

        /** Datos insan3 [inicio] */
        /** Numeros */
        $insan3_no_ventas_total = 0;
        $insan3_no_ventas_efectivo = 0;
        $insan3_no_ventas_tarjeta = 0;
        $insan3_no_ventas_openpay = 0;
        $insan3_no_ventas_b3family = 0;
        $insan3_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $insan3_ventas_total = 0;
        $insan3_ventas_efectivo = 0;
        $insan3_ventas_tarjeta = 0;
        $insan3_ventas_openpay = 0;
        $insan3_ventas_b3family = 0;
        $insan3_ventas_suscripcion = 0;
        /** Datos insan3 [fin] */

        foreach ($ventas_list as $venta_row) {
            /** Totales */
            if ($venta_row->estatus != "Cancelada") {
                $no_ventas_total++;
                $ventas_total += $venta_row->total;
            }

            if ($venta_row->estatus == "Cancelada") {
                $no_ventas_canceladas_total++;
            }

            /** Metodos de pago generales*/
            if ($venta_row->metodo_de_pago == "Efectivo") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_efectivo++;
                    $ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_tarjeta++;
                    $ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay++;
                    $ventas_openpay += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay" and $venta_row->plan_dominio_id == "1") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay_b3++;
                    $ventas_openpay_b3 += $venta_row->total;

                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay" and $venta_row->plan_dominio_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay_insan3++;
                    $ventas_openpay_insan3 += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_b3family++;
                    $ventas_b3family += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Suscripción") {

                if ($venta_row->estatus == "Vendido") {
                    $no_ventas_suscripcion++;
                    $ventas_suscripcion += $venta_row->total;

                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
                if ($venta_row->estatus == "prueba") {
                    $no_periodos_prueba_suscripcion++;
                    $periodos_prueba_suscripcion += $venta_row->total;
                }
            }

            /** Metodos de pago B3*/

            if (in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_efectivo++;
                    $b3_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_tarjeta++;
                    $b3_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_b3family++;
                    $b3_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago VELA*/

            if ($venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_total++;
                    $vela_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_efectivo++;
                    $vela_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_tarjeta++;
                    $vela_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_b3family++;
                    $vela_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago DORADO*/

            if ($venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_total++;
                    $dorado_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_efectivo++;
                    $dorado_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_tarjeta++;
                    $dorado_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_b3family++;
                    $dorado_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago insan3*/

            if ($venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_total++;
                    $insan3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_efectivo++;
                    $insan3_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_tarjeta++;
                    $insan3_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_b3family++;
                    $insan3_ventas_b3family += $venta_row->total;
                }
            }
        }

        $resultado = array(
            /** Totales */
            "mes_reportado" => $mes_reportado,

            /** Metodos de pago generales*/
            "no_ventas" => $no_ventas_total,
            "ventas_total" => "$ " . number_format($ventas_total, 2, '.', ','),

            "no_ventas_canceladas_total" => $no_ventas_canceladas_total,

            "no_ventas_efectivo" => $no_ventas_efectivo,
            "ventas_efectivo" => "$ " . number_format($ventas_efectivo, 2, '.', ','),

            "no_ventas_tarjeta" => $no_ventas_tarjeta,
            "ventas_tarjeta" => "$ " . number_format($ventas_tarjeta, 2, '.', ','),

            "no_ventas_openpay" => $no_ventas_openpay,
            "ventas_openpay" => "$ " . number_format($ventas_openpay, 2, '.', ','),

            "no_ventas_openpay_b3" => $no_ventas_openpay_b3,
            "ventas_openpay_b3" => "$ " . number_format($ventas_openpay_b3, 2, '.', ','),

            "no_ventas_openpay_insan3" => $no_ventas_openpay_insan3,
            "ventas_openpay_insan3" => "$ " . number_format($ventas_openpay_insan3, 2, '.', ','),

            "no_ventas_b3family" => $no_ventas_b3family,
            "ventas_b3family" => "$ " . number_format($ventas_b3family, 2, '.', ','),

            "no_ventas_suscripcion" => $no_ventas_suscripcion,
            "ventas_suscripcion" => "$ " . number_format($ventas_suscripcion, 2, '.', ','),

            "no_periodos_prueba_suscripcion" => $no_periodos_prueba_suscripcion,
            "periodos_prueba_suscripcion" => "$ " . number_format($periodos_prueba_suscripcion, 2, '.', ','),

            /** Metodos de pago B3*/
            "b3_no_ventas_total" => $b3_no_ventas_total,
            "b3_ventas_total" => "$ " . number_format($b3_ventas_total, 2, '.', ','),

            "b3_no_ventas_efectivo" => $b3_no_ventas_efectivo,
            "b3_ventas_efectivo" => "$ " . number_format($b3_ventas_efectivo, 2, '.', ','),

            "b3_no_ventas_tarjeta" => $b3_no_ventas_tarjeta,
            "b3_ventas_tarjeta" => "$ " . number_format($b3_ventas_tarjeta, 2, '.', ','),

            "b3_no_ventas_b3family" => $b3_no_ventas_b3family,
            "b3_ventas_b3family" => "$ " . number_format($b3_ventas_b3family, 2, '.', ','),

            /** Metodos de pago VELA*/
            "vela_no_ventas_total" => $vela_no_ventas_total,
            "vela_ventas_total" => "$ " . number_format($vela_ventas_total, 2, '.', ','),

            "vela_no_ventas_efectivo" => $vela_no_ventas_efectivo,
            "vela_ventas_efectivo" => "$ " . number_format($vela_ventas_efectivo, 2, '.', ','),

            "vela_no_ventas_tarjeta" => $vela_no_ventas_tarjeta,
            "vela_ventas_tarjeta" => "$ " . number_format($vela_ventas_tarjeta, 2, '.', ','),

            "vela_no_ventas_b3family" => $vela_no_ventas_b3family,
            "vela_ventas_b3family" => "$ " . number_format($vela_ventas_b3family, 2, '.', ','),

            /** Metodos de pago DORADO*/
            "dorado_no_ventas_total" => $dorado_no_ventas_total,
            "dorado_ventas_total" => "$ " . number_format($dorado_ventas_total, 2, '.', ','),

            "dorado_no_ventas_efectivo" => $dorado_no_ventas_efectivo,
            "dorado_ventas_efectivo" => "$ " . number_format($dorado_ventas_efectivo, 2, '.', ','),

            "dorado_no_ventas_tarjeta" => $dorado_no_ventas_tarjeta,
            "dorado_ventas_tarjeta" => "$ " . number_format($dorado_ventas_tarjeta, 2, '.', ','),

            "dorado_no_ventas_b3family" => $dorado_no_ventas_b3family,
            "dorado_ventas_b3family" => "$ " . number_format($dorado_ventas_b3family, 2, '.', ','),

            /** Metodos de pago insan3*/
            "insan3_no_ventas_total" => $insan3_no_ventas_total,
            "insan3_ventas_total" => "$ " . number_format($insan3_ventas_total, 2, '.', ','),

            "insan3_no_ventas_efectivo" => $insan3_no_ventas_efectivo,
            "insan3_ventas_efectivo" => "$ " . number_format($insan3_ventas_efectivo, 2, '.', ','),

            "insan3_no_ventas_tarjeta" => $insan3_no_ventas_tarjeta,
            "insan3_ventas_tarjeta" => "$ " . number_format($insan3_ventas_tarjeta, 2, '.', ','),

            "insan3_no_ventas_b3family" => $insan3_no_ventas_b3family,
            "insan3_ventas_b3family" => "$ " . number_format($insan3_ventas_b3family, 2, '.', ','),
        );

        echo json_encode(array("data" => $resultado));
        exit();
    }

    /** Esta función consulta los datos necesarios desde controlador para el REPORTE de ventas diario. */
    public function get_numeros_de_ventas_del_dia_para_fd_con_permisos_vista($dia_a_consultar = null)
    {
        $date = new DateTime("now");
        $curr_date = $date->format('Y-m-d');

        if ($dia_a_consultar == null) {
            $ventas_list = $this->ventas_model->get_lista_de_ventas_del_dia_para_fd_global($curr_date)->result();
            $mes_reportado = $curr_date;
        } else {
            $ventas_list = $this->ventas_model->get_lista_de_ventas_del_dia_para_fd_global($dia_a_consultar)->result();
            $mes_reportado = $dia_a_consultar;
        }

        /** Datos generales [inicio] */
        /** Numeros */
        $no_ventas_total = 0;
        $no_ventas_canceladas_total = 0;
        $no_ventas_efectivo = 0;
        $no_ventas_tarjeta = 0;
        $no_ventas_openpay = 0;
        $no_ventas_openpay_b3 = 0;
        $no_ventas_openpay_insan3 = 0;
        $no_ventas_b3family = 0;
        $no_ventas_suscripcion = 0;
        $no_periodos_prueba_suscripcion = 0;
        /** Totales en $$ */
        $ventas_total = 0;
        $ventas_efectivo = 0;
        $ventas_tarjeta = 0;
        $ventas_openpay = 0;
        $ventas_openpay_b3 = 0;
        $ventas_openpay_insan3 = 0;
        $ventas_b3family = 0;
        $ventas_suscripcion = 0;
        $periodos_prueba_suscripcion = 0;
        /** Datos generales [fin] */

        /** Datos B3 [inicio] */
        /** Numeros */
        $b3_no_ventas_total = 0;
        $b3_no_ventas_efectivo = 0;
        $b3_no_ventas_tarjeta = 0;
        $b3_no_ventas_openpay = 0;
        $b3_no_ventas_b3family = 0;
        $b3_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $b3_ventas_total = 0;
        $b3_ventas_efectivo = 0;
        $b3_ventas_tarjeta = 0;
        $b3_ventas_openpay = 0;
        $b3_ventas_b3family = 0;
        $b3_ventas_suscripcion = 0;
        /** Datos B3 [fin] */

        /** Datos VELA [inicio] */
        /** Numeros */
        $vela_no_ventas_total = 0;
        $vela_no_ventas_efectivo = 0;
        $vela_no_ventas_tarjeta = 0;
        $vela_no_ventas_openpay = 0;
        $vela_no_ventas_b3family = 0;
        $vela_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $vela_ventas_total = 0;
        $vela_ventas_efectivo = 0;
        $vela_ventas_tarjeta = 0;
        $vela_ventas_openpay = 0;
        $vela_ventas_b3family = 0;
        $vela_ventas_suscripcion = 0;
        /** Datos VELA [fin] */

        /** Datos DORADO [inicio] */
        /** Numeros */
        $dorado_no_ventas_total = 0;
        $dorado_no_ventas_efectivo = 0;
        $dorado_no_ventas_tarjeta = 0;
        $dorado_no_ventas_openpay = 0;
        $dorado_no_ventas_b3family = 0;
        $dorado_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $dorado_ventas_total = 0;
        $dorado_ventas_efectivo = 0;
        $dorado_ventas_tarjeta = 0;
        $dorado_ventas_openpay = 0;
        $dorado_ventas_b3family = 0;
        $dorado_ventas_suscripcion = 0;
        /** Datos DORADO [fin] */

        /** Datos insan3 [inicio] */
        /** Numeros */
        $insan3_no_ventas_total = 0;
        $insan3_no_ventas_efectivo = 0;
        $insan3_no_ventas_tarjeta = 0;
        $insan3_no_ventas_openpay = 0;
        $insan3_no_ventas_b3family = 0;
        $insan3_no_ventas_suscripcion = 0;
        /** Totales en $$ */
        $insan3_ventas_total = 0;
        $insan3_ventas_efectivo = 0;
        $insan3_ventas_tarjeta = 0;
        $insan3_ventas_openpay = 0;
        $insan3_ventas_b3family = 0;
        $insan3_ventas_suscripcion = 0;
        /** Datos insan3 [fin] */

        foreach ($ventas_list as $venta_row) {
            /** Totales */
            if ($venta_row->estatus != "Cancelada") {
                $no_ventas_total++;
                $ventas_total += $venta_row->total;
            }

            if ($venta_row->estatus == "Cancelada") {
                $no_ventas_canceladas_total++;
            }

            /** Metodos de pago generales*/
            if ($venta_row->metodo_de_pago == "Efectivo") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_efectivo++;
                    $ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_tarjeta++;
                    $ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay++;
                    $ventas_openpay += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay" and $venta_row->plan_dominio_id == "1") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay_b3++;
                    $ventas_openpay_b3 += $venta_row->total;

                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Openpay" and $venta_row->plan_dominio_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_openpay_insan3++;
                    $ventas_openpay_insan3 += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family") {
                if ($venta_row->estatus != "Cancelada") {
                    $no_ventas_b3family++;
                    $ventas_b3family += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Suscripción") {

                if ($venta_row->estatus == "Vendido") {
                    $no_ventas_suscripcion++;
                    $ventas_suscripcion += $venta_row->total;

                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
                if ($venta_row->estatus == "prueba") {
                    $no_periodos_prueba_suscripcion++;
                    $periodos_prueba_suscripcion += $venta_row->total;
                }
            }

            /** Metodos de pago B3*/

            if (in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_total++;
                    $b3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_efectivo++;
                    $b3_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_tarjeta++;
                    $b3_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and in_array($venta_row->sucursal_id, array(2, 3))) {
                if ($venta_row->estatus != "Cancelada") {
                    $b3_no_ventas_b3family++;
                    $b3_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago VELA*/

            if ($venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_total++;
                    $vela_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_efectivo++;
                    $vela_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_tarjeta++;
                    $vela_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "2") {
                if ($venta_row->estatus != "Cancelada") {
                    $vela_no_ventas_b3family++;
                    $vela_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago DORADO*/

            if ($venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_total++;
                    $dorado_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_efectivo++;
                    $dorado_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_tarjeta++;
                    $dorado_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "3") {
                if ($venta_row->estatus != "Cancelada") {
                    $dorado_no_ventas_b3family++;
                    $dorado_ventas_b3family += $venta_row->total;
                }
            }

            /** Metodos de pago insan3*/

            if ($venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_total++;
                    $insan3_ventas_total += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Efectivo" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_efectivo++;
                    $insan3_ventas_efectivo += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "Tarjeta crédito" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_tarjeta++;
                    $insan3_ventas_tarjeta += $venta_row->total;
                }
            }

            if ($venta_row->metodo_de_pago == "B3 Family" and $venta_row->sucursal_id == "5") {
                if ($venta_row->estatus != "Cancelada") {
                    $insan3_no_ventas_b3family++;
                    $insan3_ventas_b3family += $venta_row->total;
                }
            }
        }

        $resultado = array(
            /** Totales */
            "mes_reportado" => $mes_reportado,

            /** Metodos de pago generales*/
            "no_ventas" => $no_ventas_total,
            "ventas_total" => "$ " . number_format($ventas_total, 2, '.', ','),

            "no_ventas_canceladas_total" => $no_ventas_canceladas_total,

            "no_ventas_efectivo" => $no_ventas_efectivo,
            "ventas_efectivo" => "$ " . number_format($ventas_efectivo, 2, '.', ','),

            "no_ventas_tarjeta" => $no_ventas_tarjeta,
            "ventas_tarjeta" => "$ " . number_format($ventas_tarjeta, 2, '.', ','),

            "no_ventas_openpay" => $no_ventas_openpay,
            "ventas_openpay" => "$ " . number_format($ventas_openpay, 2, '.', ','),

            "no_ventas_openpay_b3" => $no_ventas_openpay_b3,
            "ventas_openpay_b3" => "$ " . number_format($ventas_openpay_b3, 2, '.', ','),

            "no_ventas_openpay_insan3" => $no_ventas_openpay_insan3,
            "ventas_openpay_insan3" => "$ " . number_format($ventas_openpay_insan3, 2, '.', ','),

            "no_ventas_b3family" => $no_ventas_b3family,
            "ventas_b3family" => "$ " . number_format($ventas_b3family, 2, '.', ','),

            "no_ventas_suscripcion" => $no_ventas_suscripcion,
            "ventas_suscripcion" => "$ " . number_format($ventas_suscripcion, 2, '.', ','),

            "no_periodos_prueba_suscripcion" => $no_periodos_prueba_suscripcion,
            "periodos_prueba_suscripcion" => "$ " . number_format($periodos_prueba_suscripcion, 2, '.', ','),

            /** Metodos de pago B3*/
            "b3_no_ventas_total" => $b3_no_ventas_total,
            "b3_ventas_total" => "$ " . number_format($b3_ventas_total, 2, '.', ','),

            "b3_no_ventas_efectivo" => $b3_no_ventas_efectivo,
            "b3_ventas_efectivo" => "$ " . number_format($b3_ventas_efectivo, 2, '.', ','),

            "b3_no_ventas_tarjeta" => $b3_no_ventas_tarjeta,
            "b3_ventas_tarjeta" => "$ " . number_format($b3_ventas_tarjeta, 2, '.', ','),

            "b3_no_ventas_b3family" => $b3_no_ventas_b3family,
            "b3_ventas_b3family" => "$ " . number_format($b3_ventas_b3family, 2, '.', ','),

            /** Metodos de pago VELA*/
            "vela_no_ventas_total" => $vela_no_ventas_total,
            "vela_ventas_total" => "$ " . number_format($vela_ventas_total, 2, '.', ','),

            "vela_no_ventas_efectivo" => $vela_no_ventas_efectivo,
            "vela_ventas_efectivo" => "$ " . number_format($vela_ventas_efectivo, 2, '.', ','),

            "vela_no_ventas_tarjeta" => $vela_no_ventas_tarjeta,
            "vela_ventas_tarjeta" => "$ " . number_format($vela_ventas_tarjeta, 2, '.', ','),

            "vela_no_ventas_b3family" => $vela_no_ventas_b3family,
            "vela_ventas_b3family" => "$ " . number_format($vela_ventas_b3family, 2, '.', ','),

            /** Metodos de pago DORADO*/
            "dorado_no_ventas_total" => $dorado_no_ventas_total,
            "dorado_ventas_total" => "$ " . number_format($dorado_ventas_total, 2, '.', ','),

            "dorado_no_ventas_efectivo" => $dorado_no_ventas_efectivo,
            "dorado_ventas_efectivo" => "$ " . number_format($dorado_ventas_efectivo, 2, '.', ','),

            "dorado_no_ventas_tarjeta" => $dorado_no_ventas_tarjeta,
            "dorado_ventas_tarjeta" => "$ " . number_format($dorado_ventas_tarjeta, 2, '.', ','),

            "dorado_no_ventas_b3family" => $dorado_no_ventas_b3family,
            "dorado_ventas_b3family" => "$ " . number_format($dorado_ventas_b3family, 2, '.', ','),

            /** Metodos de pago insan3*/
            "insan3_no_ventas_total" => $insan3_no_ventas_total,
            "insan3_ventas_total" => "$ " . number_format($insan3_ventas_total, 2, '.', ','),

            "insan3_no_ventas_efectivo" => $insan3_no_ventas_efectivo,
            "insan3_ventas_efectivo" => "$ " . number_format($insan3_ventas_efectivo, 2, '.', ','),

            "insan3_no_ventas_tarjeta" => $insan3_no_ventas_tarjeta,
            "insan3_ventas_tarjeta" => "$ " . number_format($insan3_ventas_tarjeta, 2, '.', ','),

            "insan3_no_ventas_b3family" => $insan3_no_ventas_b3family,
            "insan3_ventas_b3family" => "$ " . number_format($insan3_ventas_b3family, 2, '.', ','),
        );

        return array("data" => $resultado);
        exit();
    }

    /** Esta función consulta los datos necesarios para la TABLA de ventas mensual. */
    public function get_lista_de_ventas_del_mes_para_fd_con_permisos($mes_a_consultar = null)
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $list = array();

        $date = new DateTime("now");

        if ($mes_a_consultar == null) {
            $mes_a_consultar = $date->format('Y-m');
        }

        $ventas_list = $this->ventas_model->get_lista_de_ventas_del_mes_para_fd_global($mes_a_consultar)->result();

        $attr = array(
            'target' => '_blank',
        );

        foreach ($ventas_list as $venta_row) {

            $opciones = "
            " . ($venta_row->estatus == "Vendido" ? anchor('ventas/ticket/' . $venta_row->id, ' Imprimir ticket', $attr) : $venta_row->estatus) . "
            |
            " . anchor('ventas/cambiar_fecha_venta/' . $venta_row->id, ' Cambiar fecha de venta', $attr) . "
            |
            " . ($venta_row->estatus == "Vendido" ? anchor('ventas/cancelar/' . $venta_row->id, ' Cancelar') : $venta_row->estatus) . "
        ";

            $list[] = array(
                "id" => $venta_row->id,
                "concepto" => $venta_row->concepto,
                "metodo_de_pago" => $venta_row->metodo_de_pago,
                "comprador" => $venta_row->comprador . " #" . $venta_row->usuario_id,
                "categoria" => ucwords($venta_row->categoria),
                "estatus" => ucwords($venta_row->estatus),
                "costo" => $venta_row->costo,
                "cantidad" => $venta_row->cantidad,
                "total" => $venta_row->total,
                "fecha_venta" => date("d/m/Y H:i:s", strtotime($venta_row->fecha_venta)),
                "usuario_id" => "#" . $venta_row->usuario_id,
                "comprador_correo" => $venta_row->comprador_correo,
                "comprador_nombre_completo" => $venta_row->comprador_nombre_completo,
                "asignacion_id" => "#" . $venta_row->asignacion_id,
                "asignacion" => $venta_row->asignacion_nombre . " #" . $venta_row->asignacion_plan_id,
                "asignacion_vigencia_en_dias" => $venta_row->asignacion_vigencia_en_dias . " día/s",
                "asignacion_clases_del_plan" => ($venta_row->asignacion_plan_id != 14 ? $venta_row->asignacion_clases_usadas . "/" . $venta_row->asignacion_clases_incluidas . " Clases reservadas" : $venta_row->asignacion_clases_usadas . " Video-clases vistas"),
                "asignacion_openpay_suscripcion_id" => ($venta_row->asignacion_openpay_suscripcion_id != "" ? $venta_row->asignacion_openpay_suscripcion_id . ' | <a href="https://dashboard.openpay.mx/subscriptions/' . $venta_row->asignacion_openpay_suscripcion_id . '" target=”_blank”>Ver</a>' : "N/A"),
                "asignacion_openpay_cliente_id" => ($venta_row->asignacion_openpay_cliente_id != "" ? $venta_row->asignacion_openpay_cliente_id . ' | <a href="https://dashboard.openpay.mx/customers/' . $venta_row->asignacion_openpay_cliente_id . '" target=”_blank”>Ver</a>'  : "N/A"),
                "asignacion_suscripcion_estatus_del_pago" => ($venta_row->asignacion_suscripcion_estatus_del_pago != "" ? ucwords($venta_row->asignacion_suscripcion_estatus_del_pago) : "N/A"),
                "asignacion_suscripcion_fecha_de_actualizacion" => $venta_row->asignacion_suscripcion_fecha_de_actualizacion != "0000-00-00 00:00:00" ? date("d/m/Y", strtotime($venta_row->asignacion_suscripcion_fecha_de_actualizacion)) : "N/A",
                "sucursal" => $venta_row->sucursal_nombre . " " . $venta_row->sucursal_locacion,
                "vendedor" => $venta_row->vendedor,
                "opciones" => $opciones,
            );
        }

        $resultado = array(
            "draw" => $draw,
            "recordsTotal" => count($list),
            "recordsFiltered" => count($list),
            "data" => $list
        );

        echo json_encode($resultado);
        exit();
    }

    /** Esta función consulta los datos necesarios para la TABLA de ventas diarias. */
    public function get_lista_de_ventas_del_dia_para_fd_con_permisos($dia_a_consultar = null)
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $list = array();

        $date = new DateTime("now");

        if ($dia_a_consultar == null) {
            $dia_a_consultar = $date->format('Y-m-d');
        }

        $ventas_list = $this->ventas_model->get_lista_de_ventas_del_dia_para_fd_global($dia_a_consultar)->result();

        $attr = array(
            'target' => '_blank',
        );

        foreach ($ventas_list as $venta_row) {

            $opciones = "
            " . ($venta_row->estatus == "Vendido" ? anchor('ventas/ticket/' . $venta_row->id, ' Imprimir ticket', $attr) : $venta_row->estatus) . "
            |
            " . ($venta_row->estatus == "Vendido" ? anchor('ventas/cancelar/' . $venta_row->id, ' Cancelar') : $venta_row->estatus) . "
        ";

            $list[] = array(
                "id" => $venta_row->id,
                "concepto" => $venta_row->concepto,
                "metodo_de_pago" => $venta_row->metodo_de_pago,
                "comprador" => $venta_row->comprador . " #" . $venta_row->usuario_id,
                "categoria" => ucwords($venta_row->categoria),
                "estatus" => ucwords($venta_row->estatus),
                "costo" => $venta_row->costo,
                "cantidad" => $venta_row->cantidad,
                "total" => $venta_row->total,
                "fecha_venta" => date("d/m/Y H:i:s", strtotime($venta_row->fecha_venta)),
                "usuario_id" => "#" . $venta_row->usuario_id,
                "comprador_correo" => $venta_row->comprador_correo,
                "comprador_nombre_completo" => $venta_row->comprador_nombre_completo,
                "asignacion_id" => "#" . $venta_row->asignacion_id,
                "asignacion" => $venta_row->asignacion_nombre . " #" . $venta_row->asignacion_plan_id,
                "asignacion_vigencia_en_dias" => $venta_row->asignacion_vigencia_en_dias . " día/s",
                "asignacion_clases_del_plan" => ($venta_row->asignacion_plan_id != 14 ? $venta_row->asignacion_clases_usadas . "/" . $venta_row->asignacion_clases_incluidas . " Clases reservadas" : $venta_row->asignacion_clases_usadas . " Video-clases vistas"),
                "asignacion_openpay_suscripcion_id" => ($venta_row->asignacion_openpay_suscripcion_id != "" ? $venta_row->asignacion_openpay_suscripcion_id . ' | <a href="https://dashboard.openpay.mx/subscriptions/' . $venta_row->asignacion_openpay_suscripcion_id . '" target=”_blank”>Ver</a>' : "N/A"),
                "asignacion_openpay_cliente_id" => ($venta_row->asignacion_openpay_cliente_id != "" ? $venta_row->asignacion_openpay_cliente_id . ' | <a href="https://dashboard.openpay.mx/customers/' . $venta_row->asignacion_openpay_cliente_id . '" target=”_blank”>Ver</a>'  : "N/A"),
                "asignacion_suscripcion_estatus_del_pago" => ($venta_row->asignacion_suscripcion_estatus_del_pago != "" ? ucwords($venta_row->asignacion_suscripcion_estatus_del_pago) : "N/A"),
                "asignacion_suscripcion_fecha_de_actualizacion" => $venta_row->asignacion_suscripcion_fecha_de_actualizacion != "0000-00-00 00:00:00" ? date("d/m/Y", strtotime($venta_row->asignacion_suscripcion_fecha_de_actualizacion)) : "N/A",
                "sucursal" => $venta_row->sucursal_nombre . " " . $venta_row->sucursal_locacion,
                "vendedor" => $venta_row->vendedor,
                "opciones" => $opciones,
            );
        }

        $resultado = array(
            "draw" => $draw,
            "recordsTotal" => count($list),
            "recordsFiltered" => count($list),
            "data" => $list
        );

        echo json_encode($resultado);
        exit();
    }

    public function frontdesk($var = null)
    {
        /** Carga los datos del menu */
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'FrontDesk';

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "ventas/frontdesk";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),

        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'frontdesk';
        $data['regresar_a'] = 'inicio';

        /** Contenido de la vista */
        $start = (new DateTime(date('Y-m-d')))->modify('first day of this month');
        $end = (new DateTime(date('Y-m-d')))->modify('next day');
        $interval = DateInterval::createFromDateString('1 day');

        $data['period'] = new DatePeriod($start, $interval, $end);

        $resultados_mes_actual = $this->get_numeros_de_ventas_del_dia_para_fd_con_permisos_vista();

        $data['resultados_mes_actual'] = $resultados_mes_actual;

        $this->construir_private_site_ui('ventas/frontdesk', $data);
    }

    /** Vistas para las ventas normales [Inicio] */
    public function index_anterior()
    {

        /** Carga a la vista la información del menú y del título de pestaña */
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Ventas';

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "ventas/index";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $data['ventas_del_dia'] = $this->ventas_model->get_feed_ventas_numero_de_ventas_del_dia();
        $data['canceladas_del_dia'] = $this->ventas_model->get_feed_ventas_numero_de_ventas_canceladas_del_dia();

        $data['total_ventas_del_dia_con_openpay_general'] = 0; //$this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_con_openpay()->row()->total;
        $data['total_efectivo_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia()->row()->total;
        $data['total_tarjeta_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia()->row()->total;
        $data['total_openpay_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_openpay_del_dia()->row()->total;

        $data['total_ventas_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_sin_openay(2)->row()->total;
        $data['total_efectivo_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia(2)->row()->total;
        $data['total_tarjeta_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia(2)->row()->total;

        $data['total_ventas_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_sin_openay(3)->row()->total;
        $data['total_efectivo_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia(3)->row()->total;
        $data['total_tarjeta_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia(3)->row()->total;

        $this->construir_private_site_ui('ventas/index', $data);
    }

    public function index_vela()
    {

        /** Carga a la vista la información del menú y del título de pestaña */
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Ventas';

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "ventas/index_vela";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $data['ventas_del_dia'] = $this->ventas_model->get_feed_ventas_numero_de_ventas_del_dia(2);
        $data['canceladas_del_dia'] = $this->ventas_model->get_feed_ventas_numero_de_ventas_canceladas_del_dia(2);

        $data['total_ventas_del_dia_con_openpay_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_con_openpay()->row()->total;
        $data['total_efectivo_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia()->row()->total;
        $data['total_tarjeta_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia()->row()->total;
        $data['total_openpay_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_openpay_del_dia()->row()->total;

        $data['total_ventas_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_sin_openay(2)->row()->total;
        $data['total_efectivo_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia(2)->row()->total;
        $data['total_tarjeta_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia(2)->row()->total;

        $data['total_ventas_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_sin_openay(3)->row()->total;
        $data['total_efectivo_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia(3)->row()->total;
        $data['total_tarjeta_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia(3)->row()->total;

        $this->construir_private_site_ui('ventas/index', $data);
    }

    public function index_dorado()
    {

        /** Carga a la vista la información del menú y del título de pestaña */
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Ventas';

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "ventas/index_dorado";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );


        $data['total_ventas_del_dia_con_openpay_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_con_openpay()->row()->total;
        $data['total_efectivo_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia()->row()->total;
        $data['total_tarjeta_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia()->row()->total;
        $data['total_openpay_del_dia_general'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_openpay_del_dia()->row()->total;

        $data['total_ventas_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_sin_openay(2)->row()->total;
        $data['total_efectivo_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia(2)->row()->total;
        $data['total_tarjeta_del_dia_vela'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia(2)->row()->total;

        $data['total_ventas_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_del_dia_sin_openay(3)->row()->total;
        $data['total_efectivo_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia(3)->row()->total;
        $data['total_tarjeta_del_dia_dorado'] = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_tarjeta_del_dia(3)->row()->total;

        $this->construir_private_site_ui('ventas/index', $data);
    }
    /** Vistas para las ventas normales [Fin] */

    /** Vistas para las suscripciones [Inicio] */
    public function suscripciones($var = null)
    {
        /** Carga a la vista la información del menú y del título de pestaña */
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Ventas de suscripciones';

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "ventas/suscripciones";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('ventas/suscripciones', $data);
    }
    /** Vistas para las suscripciones [Fin] */

    /** Metodos */

    /** Métodos para las ventas de suscripciones [Inicio] */
    public function listar_las_ventas_de_suscripciones()
    {
        $suscripciones_list = $this->ventas_model->get_todas_las_ventas_de_suscripciones()->result();

        $result = array();

        foreach ($suscripciones_list as $suscripcion_row) {

            $result[] = array(
                'id' => $suscripcion_row->id,
                'concepto' => $suscripcion_row->concepto,
                'cliente' => $suscripcion_row->nombre_cliente . ' #' . $suscripcion_row->usuario_id,
                'asignacion_id' => $suscripcion_row->asignacion_id,
                'metodo' => $suscripcion_row->metodo_pago,
                'costo' => $suscripcion_row->costo,
                'cantidad' => $suscripcion_row->cantidad,
                'total' => $suscripcion_row->total,
                'estatus' => $suscripcion_row->estatus,
                'fecha_venta' => date('d/m/Y H:i:s', strtotime($suscripcion_row->fecha_venta)),
                'vendedor' => $suscripcion_row->vendedor,
                'asignacion_suscripcion_id' => $suscripcion_row->asignacion_suscripcion_id,
                'asignacion_plan_id' => $suscripcion_row->asignacion_plan_id,
                'asignacion_clases_usadas' => $suscripcion_row->asignacion_clases_usadas,
                'asignacion_estatus_del_pago' => ucwords($suscripcion_row->asignacion_estatus_del_pago),
                'asignacion_estatus' => $suscripcion_row->asignacion_estatus,
            );
        }

        echo json_encode(array("data" => $result));
    }
    /** Métodos para las ventas de suscripciones [Fin] */

    public function listar_las_ventas_de_admin_front()
    {
        $ventas_list = $this->ventas_model->get_lista_de_todas_las_ventas_de_hoy_para_admin_front()->result();

        $var = 1;
        $result = array();

        foreach ($ventas_list as $ventas_row) {

            $result[] = array(
                'listar_id' => $ventas_row->listar_id,
                'listar_concepto' => $ventas_row->listar_concepto,
                'listar_usuario' => $ventas_row->listar_usuario,
                'listar_metodo_nombre' => $ventas_row->listar_metodo_nombre,
                'listar_costo' => $ventas_row->listar_costo,
                'listar_cantidad' => $ventas_row->listar_cantidad,
                'listar_total' => $ventas_row->listar_total,
                'listar_estatus' => $ventas_row->listar_estatus . '<br>' . ($ventas_row->listar_estatus == "Vendido" ? anchor('ventas/cancelar/' . $ventas_row->listar_id, 'Cancelar') : $ventas_row->listar_estatus),
                'listar_asignacion' => $ventas_row->listar_asignacion,
                'listar_clases_incluidas' => $ventas_row->listar_clases_incluidas,
                'listar_clases_usadas' => $ventas_row->listar_clases_usadas,
                'listar_clases_restantes' => $ventas_row->listar_clases_restantes,
                'listar_vigencia_en_dias' => $ventas_row->listar_vigencia_en_dias,
                'listar_fecha_activacion' => $ventas_row->listar_fecha_activacion,
                'listar_sucursales_locacion' => $ventas_row->listar_sucursales_locacion,
                'listar_vendedor' => $ventas_row->listar_vendedor,
                'listar_fecha_venta' => $ventas_row->listar_fecha_venta,
            );
        }

        echo json_encode(array("data" => $result));
    }

    public function listar_las_ventas_de_VELA_front()
    {
        $ventas_list = $this->ventas_model->get_lista_de_todas_las_ventas_de_hoy_para_VELA_front()->result();

        $var = 1;
        $result = array();

        foreach ($ventas_list as $ventas_row) {

            $result[] = array(
                'listar_id' => $ventas_row->listar_id,
                'listar_concepto' => $ventas_row->listar_concepto,
                'listar_usuario' => $ventas_row->listar_usuario,
                'listar_metodo_nombre' => $ventas_row->listar_metodo_nombre,
                'listar_costo' => $ventas_row->listar_costo,
                'listar_cantidad' => $ventas_row->listar_cantidad,
                'listar_total' => $ventas_row->listar_total,
                'listar_estatus' => $ventas_row->listar_estatus . '<br>' . ($ventas_row->listar_estatus == "Vendido" ? anchor('ventas/cancelar/' . $ventas_row->listar_id, 'Cancelar') : $ventas_row->listar_estatus),
                'listar_asignacion' => $ventas_row->listar_asignacion,
                'listar_clases_incluidas' => $ventas_row->listar_clases_incluidas,
                'listar_clases_usadas' => $ventas_row->listar_clases_usadas,
                'listar_clases_restantes' => $ventas_row->listar_clases_restantes,
                'listar_vigencia_en_dias' => $ventas_row->listar_vigencia_en_dias,
                'listar_fecha_activacion' => $ventas_row->listar_fecha_activacion,
                'listar_sucursales_locacion' => $ventas_row->listar_sucursales_locacion,
                'listar_vendedor' => $ventas_row->listar_vendedor,
                'listar_fecha_venta' => $ventas_row->listar_fecha_venta,
            );
        }

        echo json_encode(array("data" => $result));
    }

    public function listar_las_ventas_de_DORADA_front()
    {
        $ventas_list = $this->ventas_model->get_lista_de_todas_las_ventas_de_hoy_para_DORADA_front()->result();

        $var = 1;
        $result = array();

        foreach ($ventas_list as $ventas_row) {

            $result[] = array(
                'listar_id' => $ventas_row->listar_id,
                'listar_concepto' => $ventas_row->listar_concepto,
                'listar_usuario' => $ventas_row->listar_usuario,
                'listar_metodo_nombre' => $ventas_row->listar_metodo_nombre,
                'listar_costo' => $ventas_row->listar_costo,
                'listar_cantidad' => $ventas_row->listar_cantidad,
                'listar_total' => $ventas_row->listar_total,
                'listar_estatus' => $ventas_row->listar_estatus . '<br>' . ($ventas_row->listar_estatus == "Vendido" ? anchor('ventas/cancelar/' . $ventas_row->listar_id, 'Cancelar') : $ventas_row->listar_estatus),
                'listar_asignacion' => $ventas_row->listar_asignacion,
                'listar_clases_incluidas' => $ventas_row->listar_clases_incluidas,
                'listar_clases_usadas' => $ventas_row->listar_clases_usadas,
                'listar_clases_restantes' => $ventas_row->listar_clases_restantes,
                'listar_vigencia_en_dias' => $ventas_row->listar_vigencia_en_dias,
                'listar_fecha_activacion' => $ventas_row->listar_fecha_activacion,
                'listar_sucursales_locacion' => $ventas_row->listar_sucursales_locacion,
                'listar_vendedor' => $ventas_row->listar_vendedor,
                'listar_fecha_venta' => $ventas_row->listar_fecha_venta,
            );
        }

        echo json_encode(array("data" => $result));
    }
    /** //////////////////////////////////////////////////////////////////////////// Métodos para cargar los datos de las tablas //////////////////////////////////////////////////////////////////////////// */


    public function index_2()
    {
        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => 'ventas/index.js'),
        );
        $total = 0;
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Ventas';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        //$ventas = $this->ventas_model->obtener_todas();
        $ventas = $this->ventas_model->obtener_todas_para_front();

        /*foreach ($ventas->result() as $venta) {
        $total = $total + $venta->total;
    }
    $data['total'] = $total;*/

        $data['ventas'] = $ventas;
        $data['asignaciones'] = $this->asignaciones_model->obtener_todos()->result();
        $this->construir_private_site_ui('ventas/index', $data);
    }

    public function crear()
    {

        if (es_frontdesk()) {
            $regresar_a = "ventas/frontdesk";
        } elseif (es_superadministrador() or es_administrador()) {
            $regresar_a = "ventas";
        }

        $sucursales_list = $this->sucursales_model->get_sucursales_para_select_de_ventas()->result();

        if (!$sucursales_list) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que existan sucursales disponibles para hacer una venta.');
            redirect($regresar_a);
        }

        $data['sucursales_list'] = $sucursales_list;

        // Validar que existan planes disponibles
        $planes = $this->planes_model->get_planes_disponibles_para_venta_en_frontdesk();

        if ($planes->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que existan planes disponibles para hacer una venta.');
            redirect($regresar_a);
        }

        $data['planes'] = $planes;

        // Validar que existan usuarios disponibles
        //$usuarios = $this->usuarios_model->obtener_todos();
        $usuarios = $this->usuarios_model->obtener_todos_ventas_frontdesk();

        if ($usuarios->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que existan clientes disponibles para hacer una venta.');
            redirect($regresar_a);
        }

        $data['usuarios'] = $usuarios;

        // Validar que existan metodos de pago disponibles
        $metodos_pago = $this->metodos_model->obtener_todos_los_activos();

        if ($metodos_pago->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que existan métodos de pago disponibles para hacer una venta.');
            redirect($regresar_a);
        }

        $data['metodos_pago'] = $metodos_pago;

        // Establecer validaciones
        $this->form_validation->set_rules('seleccionar_sucursal', 'Sucursal', 'required');
        $this->form_validation->set_rules('seleccionar_plan', 'Producto', 'required');
        $this->form_validation->set_rules('seleccionar_cliente', 'Nombre', 'required');
        $this->form_validation->set_rules('metodo_pago', 'Metodo de Pago', 'required');
        $this->form_validation->set_rules('inicia_date', 'Fecha de inicio', 'required');
        $this->form_validation->set_rules('inicia_time', 'Hora de inicio', 'required');

        // Inicializar vista y scripts
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Nueva venta';
        $regresar_a = "ventas";
        $data['regresar_a'] = $regresar_a;

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => 'ventas/crear.js'),
        );


        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('ventas/crear', $data);
        } else {

            // Preparar datos para hacer el insert en la bd
            $plan_a_comprar = $this->planes_model->obtener_por_id($this->input->post('seleccionar_plan'))->row();
            // Obtener las disciplinas que el plan a comprar tiene para as�� saber de cu��les disciplinas tiene derecho
            // el comprador de reservar clases
            $disciplinas = $this->planes_model->obtener_disciplinas_por_plan_id($plan_a_comprar->id)->result();
            $disciplinasIds = array();

            foreach ($disciplinas as $key => $value) {
                array_push($disciplinasIds, $value->disciplina_id);
            }

            if ($plan_a_comprar->categoria == 'online') {
                // Agregar plan al usuario
                $asignacion_creada = $this->asignaciones_model->crear(array(
                    'usuario_id' => $this->input->post('seleccionar_cliente'),
                    'plan_id' => $plan_a_comprar->id,
                    'nombre' => $plan_a_comprar->nombre,
                    'clases_incluidas' => $plan_a_comprar->clases_incluidas,
                    'disciplinas' => implode('|', $disciplinasIds),
                    'vigencia_en_dias' => $plan_a_comprar->vigencia_en_dias,
                    'es_ilimitado' => !empty($plan_a_comprar->es_ilimitado) ? $plan_a_comprar->es_ilimitado : 'no',
                    'suscripcion_estatus_del_pago' => 'pagado',
                    'suscripcion_fecha_de_actualizacion' => date('Y-m-d H:i:s'),
                    'esta_activo' => '1',
                    'fecha_activacion' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time'),
                ));
            } else {
                // Agregar plan al usuario
                $asignacion_creada = $this->asignaciones_model->crear(array(
                    'usuario_id' => $this->input->post('seleccionar_cliente'),
                    'plan_id' => $plan_a_comprar->id,
                    'nombre' => $plan_a_comprar->nombre,
                    'clases_incluidas' => $plan_a_comprar->clases_incluidas,
                    'disciplinas' => implode('|', $disciplinasIds),
                    'vigencia_en_dias' => $plan_a_comprar->vigencia_en_dias,
                    'es_ilimitado' => !empty($plan_a_comprar->es_ilimitado) ? $plan_a_comprar->es_ilimitado : 'no',
                    'esta_activo' => '1',
                    'fecha_activacion' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time'),
                ));
            }


            if (!$asignacion_creada) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo realizar la asignación del plan al usuario que realizó la compra');
                redirect($regresar_a);
            }

            $obetener_id_asignacion = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();

            $vendedor = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

            $total_venta = $plan_a_comprar->costo;
            if ($this->input->post('metodo_pago') == 5) {
                $total_venta = 0.00;
            }

            $data = array(
                'concepto' => $plan_a_comprar->nombre,
                'sucursal_id' => $this->input->post('seleccionar_sucursal'),
                'usuario_id' => $this->input->post('seleccionar_cliente'),
                'asignacion_id' => $obetener_id_asignacion->id,
                'metodo_id' => $this->input->post('metodo_pago'),
                'costo' => $plan_a_comprar->costo,
                'cantidad' => 1,
                'total' => $total_venta,
                'vendedor' => $this->session->userdata('id') . ' ' . $vendedor->nombre_completo . ' ' . $vendedor->apellido_paterno . ' ' . $vendedor->apellido_materno,
            );

            if ($this->ventas_model->crear($data)) {
                $obetener_id_venta = $this->ventas_model->obtener_por_id($this->db->insert_id())->row();
                $this->session->set_flashdata('MENSAJE_EXITO', 'La venta #' . $obetener_id_venta->id . ' ha sido registrada correctamente. <a href="' . site_url("ventas/ticket/" . $obetener_id_venta->id) . '" class="white" target="_blank" rel="noopener noreferrer"><b><em><u><i class="fa fa-print"></i> Imprimir ticket</u></em></b></a>');
                redirect($regresar_a);
            }

            $this->construir_private_site_ui('ventas/crear', $data);
        }
    }

    public function crear_personalizada()
    {
        if (es_frontdesk()) {
            $regresar_a = "ventas/frontdesk";
        } elseif (es_superadministrador() or es_administrador()) {
            $regresar_a = "ventas";
        }

        $sucursales_list = $this->sucursales_model->get_sucursales_para_select_de_ventas()->result();

        if (!$sucursales_list) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que existan sucursales disponibles para hacer una venta.');
            redirect($regresar_a);
        }

        $data['sucursales_list'] = $sucursales_list;

        // Validar que existan planes disponibles
        $planes = $this->planes_model->get_planes_disponibles_para_venta_en_frontdesk();

        if ($planes->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect($regresar_a);
        }

        $data['planes'] = $planes;

        // Validar que existan usuarios disponibles
        //$usuarios = $this->usuarios_model->obtener_todos();
        $usuarios = $this->usuarios_model->obtener_todos_ventas_frontdesk();

        if ($usuarios->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect($regresar_a);
        }

        $data['usuarios'] = $usuarios;

        // Validar que existan metodos de pago disponibles
        $metodos_pago = $this->metodos_model->obtener_todos();

        if ($metodos_pago->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect($regresar_a);
        }

        $data['metodos_pago'] = $metodos_pago;
        // Establecer validaciones
        $this->form_validation->set_rules('seleccionar_sucursal', 'Sucursal', 'required');
        $this->form_validation->set_rules('plan_personalizado_nombre', 'Nombre del plan', 'required');
        $this->form_validation->set_rules('plan_personalizado_clases_incluidas', 'Numero de clases a incluir', 'required');
        $this->form_validation->set_rules('plan_personalizado_vigencia_en_dias', 'Vigencia en dias', 'required');
        $this->form_validation->set_rules('plan_personalizado_costo_plan', 'Asignar costo', 'required');
        $this->form_validation->set_rules('inicia_date', 'Fecha de inicio', 'required');
        $this->form_validation->set_rules('inicia_time', 'Hora de inicio', 'required');
        $this->form_validation->set_rules('seleccionar_cliente', 'Nombre', 'required');
        $this->form_validation->set_rules('metodo_pago', 'Metodo de Pago', 'required');

        // Inicializar vista y scripts
        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Nueva venta';

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => 'ventas/crear_personalizada.js'),

        );
        $data['disciplinas'] = $this->disciplinas_model->get_disciplinas_para_venta_personalizada();

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('ventas/crear_personalizada', $data);
        } else {

            // Preparar datos para hacer el insert en la bd

            $disciplinasIds = array();

            foreach ($this->input->post('disciplinas') as $k => $v) {
                array_push($disciplinasIds, $v);
            }

            if (empty($disciplinasIds)) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Debe seleccionar al menos una disciplina para poder vender un plan personalizado, por favor inténtelo de nuevo.');
                redirect($regresar_a);
            }

            // Agregar plan al usuario
            $asignacion_creada = $this->asignaciones_model->crear(array(
                'usuario_id' => $this->input->post('seleccionar_cliente'),
                'plan_id' => '1',
                'nombre' => $this->input->post('plan_personalizado_nombre'),
                'clases_incluidas' => $this->input->post('plan_personalizado_clases_incluidas'),
                'disciplinas' => implode('|', $disciplinasIds),
                'vigencia_en_dias' => $this->input->post('plan_personalizado_vigencia_en_dias'),
                'esta_activo' => '1',
                'fecha_activacion' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time'),
            ));


            if (!$asignacion_creada) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo realizar la asignación del plan al usuario que realizó la compra');
                redirect($regresar_a);
            }
            $obetener_id_asignacion = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();

            $vendedor = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

            $total_venta = $this->input->post('plan_personalizado_costo_plan');
            if ($this->input->post('metodo_pago') == 5) {
                $total_venta = 0.00;
            }

            $data = array(
                'concepto' => $this->input->post('plan_personalizado_nombre'),
                'sucursal_id' => $this->input->post('seleccionar_sucursal'),
                'usuario_id' => $this->input->post('seleccionar_cliente'),
                'asignacion_id' => $obetener_id_asignacion->id,
                'metodo_id' => $this->input->post('metodo_pago'),
                'costo' => $this->input->post('plan_personalizado_costo_plan'),
                'cantidad' => 1,
                'total' => $total_venta,
                'vendedor' => $this->session->userdata('id') . ' ' . $vendedor->nombre_completo . ' ' . $vendedor->apellido_paterno . ' ' . $vendedor->apellido_materno,
            );

            if ($this->ventas_model->crear($data)) {
                $obetener_id_venta = $this->ventas_model->obtener_por_id($this->db->insert_id())->row();
                $this->session->set_flashdata('MENSAJE_EXITO', 'La venta #' . $obetener_id_venta->id . ' se ha creado correctamente.');
                redirect($regresar_a);
            }

            $this->construir_private_site_ui('ventas/crear_personalizada', $data);
        }
    }

    public function ticket($id = null)
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        $venta_row = $this->ventas_model->obtener_venta_por_id($id)->row();

        $data["empresa"] = "BEATNESS FRANQUICIAS S.A. DE C.V.";
        $data["regimen_fiscal"] = "RÉGIMEN GENERAL DE LEY PERSONAS MORALES";
        $data["rfc"] = "RFC: BFR1810156I4";
        $data["domicilio_fiscal"] = "CALLE LAMARTINE 205
    POLANCO V SECCION DELEGACIÓN MIGUEL HIDALGO 
    CDMX CODIGO POSTAL 11560";
        $data["fecha"] = date("d/m/Y - h:i a");

        $data["no_venta"] = "No. Venta: " . $venta_row->id;
        $data["sucursal_locacion"] = $venta_row->sucursal_locacion;
        $data["usuario_nombre"] = $venta_row->usuario_nombre;
        $data["metodo_pago_nombre"] = $venta_row->metodo_pago_nombre;
        $data["vendedor"] = preg_replace('/[0-9]+/', '', $venta_row->vendedor);
        $data["fecha_venta"] = date("d/m/Y - h:i a", strtotime($venta_row->fecha_venta));

        $data["cantidad"] = $venta_row->cantidad;
        $data["concepto"] = $venta_row->concepto;
        $data["costo"] = $venta_row->costo;
        $data["total"] = $venta_row->total;
        $total_letras = $this->numletras($venta_row->total, 1);;
        $data["total_letras"] = $total_letras;
        $data["website"] = "sensoriastudio.mx";

        $this->load->view('ventas/ticket', $data);
    }

    public function cambiar_fecha_venta($id = null)
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        $data['menu_ventas_activo'] = true;
        $data['pagina_titulo'] = 'Cambiar fecha de venta';

        $data['controlador'] = 'ventas/cambiar_fecha_venta/' . $id;
        $data['regresar_a'] = 'ventas';
        $controlador_js = "ventas/cambiar_fecha_venta";

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $data['styles'] = array();
        $data['scripts'] = array(
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        //$this->form_validation->set_rules('correo', 'Correo electrónico de administrador', 'trim|required');
        //$this->form_validation->set_rules('contrasena_hash', 'Contraseña', 'trim|required');
        $this->form_validation->set_rules('venta_date', 'Fecha de venta', 'trim|required');
        $this->form_validation->set_rules('venta_time', 'Hora de venta', 'trim|required');

        if (!$id) {
            $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (1)');
            redirect('ventas');
        }

        $venta_row = $this->ventas_model->obtener_venta_por_id($id)->row();

        $data['venta_row'] = $venta_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('ventas/cambiar_fecha_venta', $data);
        } else {

            if ($this->input->post('correo') and $this->input->post('contrasena_hash')) {

                $administrador_row = $this->usuarios_model->obtener_usuario_por_correo($this->input->post('correo'))->row();

                if ($administrador_row) {
                    if (password_verify($this->input->post('contrasena_hash'), $administrador_row->contrasena_hash)) {
                        if (!in_array($administrador_row->rol_id, array('2', '4'), true)) {
                            $this->session->set_flashdata('MENSAJE_INFO', '¡Oops! Al parecer esta no es una cuenta de administrador, por favor inténtelo de nuevo. (5)');
                            redirect('ventas');
                        }
                    } else {
                        $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (4)');
                        redirect('ventas');
                    }
                } else {
                    $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (3)');
                    redirect('ventas');
                }
            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (2)');
                redirect('ventas');
            }

            $data_venta = array(
                'fecha_venta' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('venta_date')))) . 'T' . $this->input->post('venta_time'),

            );

            if ($data_venta) {

                if ($this->ventas_model->editar($venta_row->id, $data_venta)) {
                    $this->session->set_flashdata('MENSAJE_EXITO', 'La fecha de la venta #' . $venta_row->id . ' ha sido modificada correctamente');
                    redirect('ventas');
                } else {
                    $mensaje_sistema_tipo = "MENSAJE_ERROR";
                    $mensaje_sistema = "¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (5)";
                }
            } else {
                $mensaje_sistema_tipo = "MENSAJE_ERROR";
                $mensaje_sistema = "¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (4)";
            }

            $this->session->set_flashdata($mensaje_sistema_tipo, $mensaje_sistema);
            redirect($data['regresar_a']);

            $this->construir_private_site_ui('ventas/cambiar_fecha_venta', $data);
        }
    }

    public function cancelar($id = null)
    {

        if (es_frontdesk()) {
            $regresar_a = "ventas/frontdesk";
        } elseif (es_superadministrador() or es_administrador()) {
            $regresar_a = "ventas";
        }

        $venta_a_cancelar = $this->ventas_model->venta_a_cancelar_por_id($id)->row();

        if (!$venta_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar la venta que desea cancelar o ya ha sido cancelada, verifique de nuevo.');
            redirect("ventas/index");
        }
        /*if ($venta_a_cancelar) {
        $this->session->set_flashdata('MENSAJE_INFO', 'Si se pudo encontrar la venta que desea cancelar.');
        redirect($regresar_a);
    }*/

        $asignacion_a_cancelar = $this->asignaciones_model->obtener_por_id($venta_a_cancelar->asignacion_id)->row();

        if (!$asignacion_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se pudo encontrar la asignacion que desea cancelar o ya ha sido cancelada, verifique de nuevo.');
            redirect($regresar_a);
        }
        /*if ($asignacion_a_cancelar) {
        $this->session->set_flashdata('MENSAJE_INFO', 'Si se pudo encontrar la asignacion que desea cancelar.');
        redirect($regresar_a);
    }*/

        if ($asignacion_a_cancelar->clases_usadas > 0) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'El usuario ya ha realizado reservaciones con este plan, por favor primero cancele las reservaciones si es que estas no han caducado.');
            redirect($regresar_a);
        }
        /*if ($asignacion_a_cancelar->clases_usadas == 0) {
        $this->session->set_flashdata('MENSAJE_INFO', 'No hay reservaciones con este plan');
        redirect($regresar_a);
    }*/

        if ($asignacion_a_cancelar->suscripcion_estatus_del_pago == 'pagado') {
            $data_asignacion = array(
                'clases_incluidas' => '0',
                'suscripcion_estatus_del_pago' => 'cancelado',
                'suscripcion_fecha_de_actualizacion' => date('Y-m-d H:i:s'),
                'esta_activo' => '0',
                'vigencia_en_dias' => 'vigencia_en_dias',
                'estatus' => 'Cancelado',
            );
        } else {
            $data_asignacion = array(
                'clases_incluidas' => '0',
                'esta_activo' => '0',
                'vigencia_en_dias' => 'vigencia_en_dias',
                'estatus' => 'Cancelado',
            );
        }

        if (!$this->asignaciones_model->editar($asignacion_a_cancelar->id, $data_asignacion)) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La asignación no se ha editado correctamente');
            redirect($regresar_a);
        }

        $data_venta = array(
            'total' => '0',
            'estatus' => 'Cancelada',
        );

        if ($this->ventas_model->editar($venta_a_cancelar->id, $data_venta)) {
            $this->session->set_flashdata('MENSAJE_EXITO', 'La CANCELACIÓN venta #' . $venta_a_cancelar->id . ' se ha hecho correctamente.');
            redirect($regresar_a);
        }

        $this->construir_private_site_ui('ventas/index');
    }

    public function genera_asignaciones_por_id_para_todas_las_ventas()
    {
        $ventas = $this->ventas_model->obtener_todas()->result();
        foreach ($ventas as $venta) {
            $data = array(
                'asignacion_id' => $venta->id,
            );
            $this->ventas_model->genera_asignaciones_por_id_para_todas_las_ventas($venta->id, $data);
        }
        redirect("ventas/index");
    }

    public function aplicar_redirect()
    {
        if (es_superadministrador() or es_administrador()) {
            redirect("ventas/index");
        } elseif (es_frontdesk()) {
            if ($this->session->userdata('sucursal_asignada') == 2) {
                redirect('ventas/index_vela');
            } elseif ($this->session->userdata('sucursal_asignada') == 3) {
                redirect('ventas/index_dorado');
            }
        }
    }

    public function prueba_funcion()
    {
        $result = $this->ventas_model->get_feed_ventas_suma_de_ventas_en_efectivo_del_dia()->row();
        echo $result->total;
    }

    function search()
    {
        $this->load->model('ventas_model');
        if (isset($_GET['term'])) {

            $q = mb_strtolower($_GET['term']);
            $this->ventas_model->autosearch($q);
        }
    }

    function numletras($numero, $_moneda)
    {

        switch ($_moneda) {
            case 1:
                $_nommoneda = 'PESOS';
                break;
            case 2:
                $_nommoneda = 'DÓLARES';
                break;
        }

        $tempnum = explode('.', $numero);

        if ($tempnum[0] !== "") {
            $numf = $this->milmillon($tempnum[0]);

            if ($numf == "UNO") {
                $numf = substr($numf, 0, -1);
            }

            $TextEnd = $numf . ' ';
            $TextEnd .= $_nommoneda . ' CON ';
        }
        if ($tempnum[1] == "" || $tempnum[1] >= 100) {
            $tempnum[1] = "00";
        }

        $TextEnd .= $tempnum[1];
        $TextEnd .= "/100";

        return $TextEnd;
    }

    function unidad($numuero)
    {
        switch ($numuero) {
            case 9: {
                    $numu = "NUEVE";
                    break;
                }
            case 8: {
                    $numu = "OCHO";
                    break;
                }
            case 7: {
                    $numu = "SIETE";
                    break;
                }
            case 6: {
                    $numu = "SEIS";
                    break;
                }
            case 5: {
                    $numu = "CINCO";
                    break;
                }
            case 4: {
                    $numu = "CUATRO";
                    break;
                }
            case 3: {
                    $numu = "TRES";
                    break;
                }
            case 2: {
                    $numu = "DOS";
                    break;
                }
            case 1: {
                    $numu = "UNO";
                    break;
                }
            case 0: {
                    $numu = "";
                    break;
                }
        }

        return $numu;
    }

    function decena($numdero)
    {
        if ($numdero >= 90 && $numdero <= 99) {
            $numd = "NOVENTA ";
            if ($numdero > 90) {
                $numd = $numd . "Y " . ($this->unidad($numdero - 90));
            }
        } else if ($numdero >= 80 && $numdero <= 89) {
            $numd = "OCHENTA ";
            if ($numdero > 80) {
                $numd = $numd . "Y " . ($this->unidad($numdero - 80));
            }
        } else if ($numdero >= 70 && $numdero <= 79) {
            $numd = "SETENTA ";
            if ($numdero > 70) {
                $numd = $numd . "Y " . ($this->unidad($numdero - 70));
            }
        } else if ($numdero >= 60 && $numdero <= 69) {
            $numd = "SESENTA ";
            if ($numdero > 60) {
                $numd = $numd . "Y " . ($this->unidad($numdero - 60));
            }
        } else if ($numdero >= 50 && $numdero <= 59) {
            $numd = "CINCUENTA ";
            if ($numdero > 50) {
                $numd = $numd . "Y " . ($this->unidad($numdero - 50));
            }
        } else if ($numdero >= 40 && $numdero <= 49) {
            $numd = "CUARENTA ";
            if ($numdero > 40) {
                $numd = $numd . "Y " . ($this->unidad($numdero - 40));
            }
        } else if ($numdero >= 30 && $numdero <= 39) {
            $numd = "TREINTA ";
            if ($numdero > 30) {
                $numd = $numd . "Y " . ($this->unidad($numdero - 30));
            }
        } else if ($numdero >= 20 && $numdero <= 29) {
            if ($numdero == 20) {
                $numd = "VEINTE ";
            } else {
                $numd = "VEINTI" . ($this->unidad($numdero - 20));
            }
        } else if ($numdero >= 10 && $numdero <= 19) {
            switch ($numdero) {
                case 10: {
                        $numd = "DIEZ ";
                        break;
                    }
                case 11: {
                        $numd = "ONCE ";
                        break;
                    }
                case 12: {
                        $numd = "DOCE ";
                        break;
                    }
                case 13: {
                        $numd = "TRECE ";
                        break;
                    }
                case 14: {
                        $numd = "CATORCE ";
                        break;
                    }
                case 15: {
                        $numd = "QUINCE ";
                        break;
                    }
                case 16: {
                        $numd = "DIECISEIS ";
                        break;
                    }
                case 17: {
                        $numd = "DIECISIETE ";
                        break;
                    }
                case 18: {
                        $numd = "DIECIOCHO ";
                        break;
                    }
                case 19: {
                        $numd = "DIECINUEVE ";
                        break;
                    }
            }
        } else {
            $numd = $this->unidad($numdero);
        }

        return $numd;
    }

    function centena($numc)
    {
        if ($numc >= 100) {
            if ($numc >= 900 && $numc <= 999) {
                $numce = "NOVECIENTOS ";
                if ($numc > 900) {
                    $numce = $numce . ($this->decena($numc - 900));
                }
            } else if ($numc >= 800 && $numc <= 899) {
                $numce = "OCHOCIENTOS ";
                if ($numc > 800) {
                    $numce = $numce . ($this->decena($numc - 800));
                }
            } else if ($numc >= 700 && $numc <= 799) {
                $numce = "SETECIENTOS ";
                if ($numc > 700) {
                    $numce = $numce . ($this->decena($numc - 700));
                }
            } else if ($numc >= 600 && $numc <= 699) {
                $numce = "SEISCIENTOS ";
                if ($numc > 600) {
                    $numce = $numce . ($this->decena($numc - 600));
                }
            } else if ($numc >= 500 && $numc <= 599) {
                $numce = "QUINIENTOS ";
                if ($numc > 500) {
                    $numce = $numce . ($this->decena($numc - 500));
                }
            } else if ($numc >= 400 && $numc <= 499) {
                $numce = "CUATROCIENTOS ";
                if ($numc > 400) {
                    $numce = $numce . ($this->decena($numc - 400));
                }
            } else if ($numc >= 300 && $numc <= 399) {
                $numce = "TRESCIENTOS ";
                if ($numc > 300) {
                    $numce = $numce . ($this->decena($numc - 300));
                }
            } else if ($numc >= 200 && $numc <= 299) {
                $numce = "DOSCIENTOS ";
                if ($numc > 200) {
                    $numce = $numce . ($this->decena($numc - 200));
                }
            } else if ($numc >= 100 && $numc <= 199) {
                if ($numc == 100) {
                    $numce = "CIEN ";
                } else {
                    $numce = "CIENTO " . ($this->decena($numc - 100));
                }
            }
        } else {
            $numce = $this->decena($numc);
        }

        return $numce;
    }

    function miles($nummero)
    {
        if ($nummero >= 1000 && $nummero < 2000) {
            $numm = "MIL " . ($this->centena($nummero % 1000));
        }
        if ($nummero >= 2000 && $nummero < 10000) {
            $numm = $this->unidad(Floor($nummero / 1000)) . " MIL " . ($this->centena($nummero % 1000));
        }
        if ($nummero < 1000) {
            $numm = $this->centena($nummero);
        }
        return $numm;
    }

    function decmiles($numdmero)
    {
        if ($numdmero == 10000) {
            $numde = "DIEZ MIL";
        }
        if ($numdmero > 10000 && $numdmero < 20000) {
            $numde = $this->decena(Floor($numdmero / 1000)) . "MIL " . ($this->centena($numdmero % 1000));
        }
        if ($numdmero >= 20000 && $numdmero < 100000) {
            $numde = $this->decena(Floor($numdmero / 1000)) . " MIL " . ($this->miles($numdmero % 1000));
        }
        if ($numdmero < 10000) {
            $numde = $this->miles($numdmero);
        }

        return $numde;
    }

    function cienmiles($numcmero)
    {
        if ($numcmero == 100000) {
            $num_letracm = "CIEN MIL";
        }
        if ($numcmero >= 100000 && $numcmero < 1000000) {
            $num_letracm = $this->centena(Floor($numcmero / 1000)) . " MIL " . ($this->centena($numcmero % 1000));
        }
        if ($numcmero < 100000) {
            $num_letracm = $this->decmiles($numcmero);
        }

        return $num_letracm;
    }

    function millon($nummiero)
    {
        if ($nummiero >= 1000000 && $nummiero < 2000000) {
            $num_letramm = "UN MILLON " . ($this->cienmiles($nummiero % 1000000));
        }
        if ($nummiero >= 2000000 && $nummiero < 10000000) {
            $num_letramm = $this->unidad(Floor($nummiero / 1000000)) . " MILLONES " . ($this->cienmiles($nummiero % 1000000));
        }
        if ($nummiero < 1000000) {
            $num_letramm = $this->cienmiles($nummiero);
        }

        return $num_letramm;
    }

    function decmillon($numerodm)
    {
        if ($numerodm == 10000000) {
            $num_letradmm = "DIEZ MILLONES";
        }
        if ($numerodm > 10000000 && $numerodm < 20000000) {
            $num_letradmm = $this->decena(Floor($numerodm / 1000000)) . "MILLONES " . ($this->cienmiles($numerodm % 1000000));
        }
        if ($numerodm >= 20000000 && $numerodm < 100000000) {
            $num_letradmm = $this->decena(Floor($numerodm / 1000000)) . " MILLONES " . ($this->millon($numerodm % 1000000));
        }
        if ($numerodm < 10000000) {
            $num_letradmm = $this->millon($numerodm);
        }

        return $num_letradmm;
    }

    function cienmillon($numcmeros)
    {
        if ($numcmeros == 100000000) {
            $num_letracms = "CIEN MILLONES";
        }
        if ($numcmeros >= 100000000 && $numcmeros < 1000000000) {
            $num_letracms = $this->centena(Floor($numcmeros / 1000000)) . " MILLONES " . ($this->millon($numcmeros % 1000000));
        }
        if ($numcmeros < 100000000) {
            $num_letracms = $this->decmillon($numcmeros);
        }

        return $num_letracms;
    }

    function milmillon($nummierod)
    {
        if ($nummierod >= 1000000000 && $nummierod < 2000000000) {
            $num_letrammd = "MIL " . ($this->cienmillon($nummierod % 1000000000));
        }
        if ($nummierod >= 2000000000 && $nummierod < 10000000000) {
            $num_letrammd = $this->unidad(Floor($nummierod / 1000000000)) . " MIL " . ($this->cienmillon($nummierod % 1000000000));
        }
        if ($nummierod < 1000000000) {
            $num_letrammd = $this->cienmillon($nummierod);
        }

        return $num_letrammd;
    }
}
