<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Endpoint extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->model("app_secciones_model");
        $this->load->model("asignaciones_model");
        $this->load->model("anuncios_model");
        $this->load->model("clases_model");
        $this->load->model("codigos_canjeados_model");
        $this->load->model("codigos_model");
        $this->load->model("configuraciones_model");
        $this->load->model("disciplinas_model");
        $this->load->model("planes_categorias_model");
        $this->load->model("planes_model");
        $this->load->model("rel_planes_categorias_model");
        $this->load->model("reservaciones_model");
        $this->load->model("sucursales_model");
        $this->load->model("tarjetas_model");
        $this->load->model("usuarios_model");
        $this->load->model("ventas_model");
        $this->load->model("resenias_model");
    }

    public function cargo_con_stripe_post()
    {

        $datos_post = $this->post();
        $asignaciones_id = null;

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        // Es necesario el id del plan y el id del usuario al cual se le va a asignar dicho plan, además del
        // source id y del id del dispositivo
        if (!$datos_post['plan_id'] || !$datos_post['usuario_id'] || !$datos_post['card_token']) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'No se realizó el cargo',
                'mensaje' => 'envío de datos inválidos'
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Obtener plan_row del plan a agregar
        $plan_row = $this->planes_model->obtener_plan_por_id_para_stripe($datos_post['plan_id'])->row();

        if (!$plan_row) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'No se realizó el cargo',
                'mensaje' => 'El plan que intenta agregar ya no existe'
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $disciplinas = $this->planes_model->obtener_disciplinas_por_plan_id($plan_row->id)->result();

        $disciplinas_array = array();

        foreach ($disciplinas as $key => $value) {
            array_push($disciplinas_array, $value->disciplina_id);
        }

        $this->load->library('stripe_lib', array('sucursal_motor_pago' => $plan_row->sucursales_motor_pago));

        $resultado_cargo = $this->stripe_lib->cargo(
            bcmul($plan_row->costo, 100),
            $plan_row->nombre,
            null,
            $plan_row->sku,
            $usuario_valido->correo,
            $datos_post['card_token']
        );

        if (!$resultado_cargo['error']) {

            if (!$this->asignaciones_model->crear(array(
                'usuario_id' => $usuario_valido->id,
                'plan_id' => $plan_row->id,
                'nombre' => $plan_row->nombre,
                'clases_incluidas' => $plan_row->clases_incluidas,
                'disciplinas' => implode('|', $disciplinas_array),
                'vigencia_en_dias' => $plan_row->vigencia_en_dias,
                'es_ilimitado' => !empty($plan_row->es_ilimitado) ? $plan_row->es_ilimitado : 'no',
                'fecha_activacion' => date('Y-m-d H:i:s'),
                'esta_activo' => 1
            ))) {
                //$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor intentelo mas tarde. (2)', 'usuario/shop');
                $this->response(array(
                    'error' => true,
                    'mostrar_mensaje' => true,
                    'titulo' => 'No se realizó el cargo',
                    'mensaje' => 'Ha ocurrido un error, por favor intentelo mas tarde. (2)'
                ), REST_Controller::HTTP_BAD_REQUEST);
            }

            $asignacion_row = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();

            if (!$this->ventas_model->crear(array(
                'concepto' => $plan_row->nombre,
                'usuario_id' => $usuario_valido->id,
                'asignacion_id' => $asignacion_row->id,
                'asignaciones_id' => $asignaciones_id,
                'metodo_id' => 10,
                'costo' => $plan_row->costo,
                'cantidad' => 1,
                'total' => $plan_row->costo,
                'vendedor' => 'Compra desde la aplicación'
            ))) {
                //$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor intentelo mas tarde. (3)', 'usuario/shop');
                $this->response(array(
                    'error' => true,
                    'mostrar_mensaje' => true,
                    'titulo' => 'No se realizó el cargo',
                    'mensaje' => 'Ha ocurrido un error, por favor intentelo mas tarde. (3)'
                ), REST_Controller::HTTP_BAD_REQUEST);
            }

            $this->response(array(
                'mensaje' => 'El plan se agregó correctamente al cliente'
            ), REST_Controller::HTTP_CREATED);
        } else {
            //$this->mensaje_del_sistema('MENSAJE_ERROR', 'Compra error', 'usuario/inicio');
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'No se realizó el cargo',
                'mensaje' => $resultado_cargo['mensaje']
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }



















    // ====== Perfil (Inicio) ======
    /**
     * Obtiene los datos del usuario autenticado
     *
     * @return void
     */
    public function datos_usuario_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if ($usuario_valido) {
            $datos_usuario = $this->usuarios_model->obtener_usuario_para_app($datos_get['token'], $datos_get['usuario_id'])->row();
        } else {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Token y/o usuario inválido',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->response($datos_usuario);
    }

    /**
     * Cambia el nombre del usuario
     *
     * @return void
     */
    public function cambiar_nombre_post()
    {
        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!$this->usuarios_model->editar(
            $usuario_valido->id,
            array(
                'nombre_completo' => $datos_post['nombre_completo'],
                'apellido_paterno' => $datos_post['apellido_paterno'],
                'apellido_materno' => $datos_post['apellido_materno'],
            )
        )) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El nombre no pudo ser cambiado; por favor inténtelo más tarde',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response(array(
            'mensaje' => 'El nombre se cambio exitosamente',
        ), REST_Controller::HTTP_OK);
    }

    /**
     * Cambia el número de teléfono del usuario
     *
     * @return void
     */
    public function cambiar_no_telefono_post()
    {
        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!$this->usuarios_model->editar(
            $usuario_valido->id,
            array(
                'no_telefono' => $datos_post['no_telefono'],
            )
        )) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El número de teléfono no pudo ser cambiado; por favor inténtelo más tarde',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response(array(
            'mensaje' => 'El número de teléfono se cambio exitosamente',
        ), REST_Controller::HTTP_OK);
    }

    /**
     * Cambia la sucursal del usuario
     *
     * @return void
     */
    public function cambiar_sucursal_post()
    {
        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!$this->usuarios_model->editar(
            $usuario_valido->id,
            array(
                'sucursal_id' => $datos_post['sucursal_id'],
            )
        )) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La sucursal no pudo ser cambiada; por favor inténtelo más tarde',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response(array(
            'mensaje' => 'La sucrusal se cambio exitosamente',
        ), REST_Controller::HTTP_OK);
    }

    public function cambiar_contrasena_post()
    {

        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!$datos_post['contrasena_actual'] || !$datos_post['contrasena_nueva'] || !$datos_post['confirmar_contrasena']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Por favor verifique que haya enviado todos los datos requeridos',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        if ($datos_post['contrasena_nueva'] != $datos_post['confirmar_contrasena']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Las contraseña nueva y la contraseña a confirmar deben coincidir',
            ), REST_Controller::HTTP_CONFLICT);
        }

        // Validar que la contraseña anterior sea la correcta
        /*if (!password_verify($datos_post['contrasena_nueva'], $usuario_valido->contrasena_hash)) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La contraseña actual ingresada no es correcta',
            ), REST_Controller::HTTP_CONFLICT);
        }*/

        if (!password_verify($datos_post['contrasena_actual'], $usuario_valido->contrasena_hash)) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La contraseña actual ingresada no es correcta',
            ), REST_Controller::HTTP_CONFLICT);
        }

        // Actualizar contrasena
        if (!$this->usuarios_model->editar($usuario_valido->id, array('contrasena_hash' => password_hash($datos_post['contrasena_nueva'], PASSWORD_DEFAULT)))) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Ha ocurrido un error al intentar cambiar la contraseña; por favor inténtelo más tarde',
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->response(array(
            'mensaje' => 'La contraseña ha sido cambiada exitosamente',
        ), REST_Controller::HTTP_OK);
    }

    function eliminar_cuenta_post()
    {

        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!$this->usuarios_model->editar(
            $usuario_valido->id,
            array(
                'correo' => $usuario_valido->id . "@user.deleted",
                'contrasena_hash' => null,
                'rol_id' => 1,
                'nombre_completo' => null,
                'apellido_paterno' => null,
                'apellido_materno' => null,
                'no_telefono' => null,
                'rfc' => null,
                'genero' => "H",
                'calle' => null,
                'numero' => null,
                'colonia' => null,
                'ciudad' => null,
                'estado' => null,
                'pais' => null,
                'token' => null,
                'token_web' => null,
                'codigo_recuperar_contrasena' => null,
                'estatus' => "suspendido",
            )
        )) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Error al eliminar cuenta, por favor inténtelo más tarde',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response(array(
            'mensaje' => 'Cuenta eliminada con éxito.',
        ), REST_Controller::HTTP_OK);
    }

    // ====== Perfil (Fin) ======

    /* ====== Métodos para la nueva funcionalidad de compras en la app con categorías Mayo 2024 (Inicio) ====== */
    public function obtener_sucurales_disponibles_para_app_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $sucursales_list = $this->sucursales_model->obtener_sucurales_disponibles_para_app()->result();

        $this->response($sucursales_list);
    }

    public function obtener_categorias_planes_por_sucursal_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if (!$usuario_valido) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Sin acceso autorizado.',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $planes_categorias = $this->planes_categorias_model->obtener_categorias_planes_por_sucursal()->result();

        if (!$planes_categorias) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'No hay categorías activas, por favor intentelo más tarde.',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($planes_categorias);
    }

    public function planes_disponibles_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $asignaciones_list = $this->asignaciones_model->obtener_asignaciones_por_usuario_id($usuario_valido->id)->result();

        $reservaciones_list = $this->reservaciones_model->obtener_reservacion_para_cliente($usuario_valido->id)->result();

        $validar_canje_list = $this->codigos_canjeados_model->obtener_codigo_canjeado_por_usuario_id($usuario_valido->id)->result();

        $codigos_canjeados_array = array();

        foreach ($validar_canje_list as $key => $value) {
            array_push($codigos_canjeados_array, $value->codigo);
        }

        //$planes = $this->planes_model->obtener_todos()->result();
        $planes = $this->planes_model->get_planes_disponibles_para_venta_en_la_app()->result();

        $planes_con_disciplinas = array();

        foreach ($planes as $plan) {

            if (!empty($asignaciones_list) and $plan->es_primera == 'si') {
                continue; // Esto saltará la iteración actual y pasará a la siguiente
            }

            if ($usuario_valido->es_estudiante == 'no' and $plan->es_estudiante == 'si') {
                continue;
            }

            if ($usuario_valido->es_empresarial == 'no' and $plan->es_empresarial == 'si') {
                continue;
            }

            if ($plan->mostrar_en_app == 'no') {
                continue;
            }

            if (in_array($plan->codigo, $codigos_canjeados_array) or !$plan->codigo) {
                if ($reservaciones_list) {

                    $plan_con_disciplinas = new stdClass();
                    $plan_con_disciplinas->id = $plan->id;
                    $plan_con_disciplinas->dominio_id = $plan->dominio_id;
                    $plan_con_disciplinas->sku = $plan->sku;
                    $plan_con_disciplinas->nombre = $plan->nombre;
                    $plan_con_disciplinas->descripcion = $plan->descripcion;
                    $plan_con_disciplinas->clases_incluidas = $plan->clases_incluidas;
                    $plan_con_disciplinas->vigencia_en_dias = $plan->vigencia_en_dias;
                    $plan_con_disciplinas->costo = $plan->costo;
                    $plan_con_disciplinas->subscripcion = $plan->subscripcion;
                    $plan_con_disciplinas->terminos_condiciones = $plan->terminos_condiciones;
                    $plan_con_disciplinas->url_infoventa = $plan->url_infoventa;
                    $plan_con_disciplinas->pagar_en = $plan->pagar_en;
                    $plan_con_disciplinas->url_pago = $plan->url_pago;

                    $disciplinas = $this->planes_model->obtener_disciplinas_con_detalle_por_plan_id($plan->id)->result();

                    $disciplinas_por_plan = array();

                    foreach ($disciplinas as $disciplina) {
                        $disciplina_por_plan = new stdClass();
                        $disciplina_por_plan->id = $disciplina->id;
                        $disciplina_por_plan->nombre = $disciplina->nombre;
                        array_push($disciplinas_por_plan, $disciplina_por_plan);
                    }

                    $plan_con_disciplinas->disciplinas = $disciplinas_por_plan;

                    array_push($planes_con_disciplinas, $plan_con_disciplinas);

                    $plan_con_disciplinas->disciplinas_sucursal_id = $plan->disciplinas_sucursal_id;
                    $plan_con_disciplinas->rel_planes_categorias_categoria_id = $plan->rel_planes_categorias_categoria_id;
                    $plan_con_disciplinas->sucursales_url_whatsapp = $plan->sucursales_url_whatsapp;
                    $plan_con_disciplinas->sucursales_motor_pago = $plan->sucursales_motor_pago;
                } elseif (!$reservaciones_list) {

                    $plan_con_disciplinas = new stdClass();
                    $plan_con_disciplinas->id = $plan->id;
                    $plan_con_disciplinas->dominio_id = $plan->dominio_id;
                    $plan_con_disciplinas->sku = $plan->sku;
                    $plan_con_disciplinas->nombre = $plan->nombre;
                    $plan_con_disciplinas->descripcion = $plan->descripcion;
                    $plan_con_disciplinas->clases_incluidas = $plan->clases_incluidas;
                    $plan_con_disciplinas->vigencia_en_dias = $plan->vigencia_en_dias;
                    $plan_con_disciplinas->costo = $plan->costo;
                    $plan_con_disciplinas->subscripcion = $plan->subscripcion;
                    $plan_con_disciplinas->terminos_condiciones = $plan->terminos_condiciones;
                    $plan_con_disciplinas->url_infoventa = $plan->url_infoventa;
                    $plan_con_disciplinas->pagar_en = $plan->pagar_en;
                    $plan_con_disciplinas->url_pago = $plan->url_pago;


                    $disciplinas = $this->planes_model->obtener_disciplinas_con_detalle_por_plan_id($plan->id)->result();

                    $disciplinas_por_plan = array();

                    foreach ($disciplinas as $disciplina) {
                        $disciplina_por_plan = new stdClass();
                        $disciplina_por_plan->id = $disciplina->id;
                        $disciplina_por_plan->nombre = $disciplina->nombre;
                        array_push($disciplinas_por_plan, $disciplina_por_plan);
                    }

                    $plan_con_disciplinas->disciplinas = $disciplinas_por_plan;

                    array_push($planes_con_disciplinas, $plan_con_disciplinas);

                    $plan_con_disciplinas->disciplinas_sucursal_id = $plan->disciplinas_sucursal_id;
                    $plan_con_disciplinas->rel_planes_categorias_categoria_id = $plan->rel_planes_categorias_categoria_id;
                    $plan_con_disciplinas->sucursales_url_whatsapp = $plan->sucursales_url_whatsapp;
                    $plan_con_disciplinas->sucursales_motor_pago = $plan->sucursales_motor_pago;
                }
            }
        }

        $this->response($planes_con_disciplinas);
    }

    /* ====== Métodos para la nueva funcionalidad de compras en la app con categorías Mayo 2024 (Fin) ====== */

    /* ====== Métodos para la nueva funcionalidad de reservar en la app Mayo 2024 (Inicio) ====== */

    public function reservar_clase_post()
    {
        $datos_post = $this->post();

        try {
            // Validar que el cliente que realiza la petición esté autenticado
            $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

            // Verificar existencia de parámetros
            if (!isset($datos_post['asignacion_id'])) {
                throw new Exception('Se requiere el id del plan del usuario que se utilizará para hacer la reservación');
            }

            // Verificar existencia del plan del cliente
            $plan_cliente = $this->asignaciones_model->obtener_por_id($datos_post['asignacion_id'])->row();

            if (!$plan_cliente) {
                throw new Exception('El plan para el cliente que busca no existe');
            }

            // Verificar existencia de clase y lugar
            if (!isset($datos_post['clase_id']) || (!isset($datos_post['no_lugar']) || $datos_post['no_lugar'] == 0)) {
                throw new Exception('Se requiere el id de la clase y el num del lugar de la clase a reservar');
            }
            $clase_a_reservar = $this->clases_model->obtener_por_id($datos_post['clase_id'])->row();
            if (!$clase_a_reservar) {
                throw new Exception('La clase que busca no existe');
            }

            // Validar tiempo de la clase
            $fecha_de_clase = $clase_a_reservar->inicia;
            $fecha_limite_de_clase = strtotime('+15 minutes', strtotime($fecha_de_clase));
            if (strtotime('now') > $fecha_limite_de_clase) {
                throw new Exception('Lo sentimos, la clase que desea reservar está por comenzar, por favor seleccione otro horario.');
            }

            // Verificar límite de reservaciones
            $reservacion_existente = $this->reservaciones_model->obtener_reservacion_por_cliente_y_clase($datos_post['usuario_id'], $datos_post['clase_id']);

            $verificacion_de_reservaciones_hoy = $this->reservaciones_model->obtener_verificacion_de_reservaciones_hoy($datos_post['usuario_id'], date('Y-m-d', strtotime($fecha_de_clase)));

            if ($reservacion_existente->num_rows() >= 1) {
                throw new Exception('Has alcanzado el límite de reservaciones para esta clase.<br>' . date('d/m/Y H:i a', strtotime($fecha_de_clase)) . '');
            }

            // if ($plan_cliente->es_ilimitado != 'si') {
            //     if ($verificacion_de_reservaciones_hoy) {
            //         throw new Exception('Has alcanzado el límite de reservaciones para este día.<br>' . date('d/m/Y', strtotime($fecha_de_clase)) . '');
            //     }
            // }

            // Validar plan del cliente
            if (($plan_cliente->clases_incluidas - $plan_cliente->clases_usadas) < $clase_a_reservar->intervalo_horas) {
                throw new Exception('No cuenta con las clases suficientes en su plan');
            }

            $disciplinas_ids_asignacion = explode('|', $plan_cliente->disciplinas);

            if (
                !is_array($disciplinas_ids_asignacion) ||
                (!in_array($clase_a_reservar->disciplina_id, $disciplinas_ids_asignacion) &&
                    !in_array($clase_a_reservar->subdisciplina_id, $disciplinas_ids_asignacion))
            ) {
                throw new Exception('El plan seleccionado no puede ser usado para la disciplina a la que pertenece la clase a reservar');
            }

            // Verificar estado del plan
            if ($plan_cliente->esta_activo) {
                $fecha_vigencia = strtotime($plan_cliente->fecha_activacion . ' + ' . $plan_cliente->vigencia_en_dias . ' days');
                if (strtotime('now') > $fecha_vigencia) {
                    throw new Exception('El plan ha expirado, por favor utilice otro');
                }
            } else {
                $this->asignaciones_model->activar_plan($plan_cliente->id);
            }

            // Establecer como ocupado/reservado el lugar que se seleccionó
            $cupo_lugares = json_decode($clase_a_reservar->cupo_lugares);
            foreach ($cupo_lugares as $lugar) {
                if ($lugar->no_lugar == $datos_post['no_lugar']) {
                    if ($lugar->esta_reservado) {
                        throw new Exception('El lugar seleccionado ya se encuentra reservado');
                    }
                    $lugar->esta_reservado = true;
                    $lugar->nombre_usuario = $usuario_valido->id;
                }
            }

            // Actualizar el plan del cliente y la clase
            $clases_usadas = $plan_cliente->clases_usadas + $clase_a_reservar->intervalo_horas;
            $reservado = $clase_a_reservar->reservado + 1;
            if (
                !$this->asignaciones_model->editar($plan_cliente->id, array('clases_usadas' => $clases_usadas)) ||
                !$this->clases_model->editar($clase_a_reservar->id, array('reservado' => $reservado, 'cupo_lugares' => json_encode($cupo_lugares)))
            ) {
                throw new Exception('La reservación no pudo ser creada');
            }

            // Crear reservación
            $reservacion = $this->reservaciones_model->crear(array(
                'usuario_id' => $usuario_valido->id,
                'clase_id' => $clase_a_reservar->id,
                'asignaciones_id' => $plan_cliente->id,
                'no_lugar' => $datos_post['no_lugar'],
            ));

            if (!$reservacion) {
                throw new Exception('La reservación no pudo ser creada');
            }

            // Obtener la reservación recién creada
            $reservacion_creada = $this->reservaciones_model->obtener_por_id($this->db->insert_id())->row();

            $this->response($reservacion_creada);
        } catch (Exception $e) {
            $this->response(array(
                'error' => true,
                'mensaje' => $e->getMessage(),
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /* ====== Métodos para la nueva funcionalidad de reservar en la app Mayo 2024 (Fin) ====== */

    /** ============ Módulo de compras (INICIO) ============ */
    public function registrar_usuario_en_openpay_post()
    {

        /** Recibir mensaje del api */
        $datos_post = $this->post();

        /** Validar que el usuario esté autenticado en la aplicación */
        $validar_usuario = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!$validar_usuario) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'Ocurrió un error',
                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (1)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        } else {

            if (!$validar_usuario->openpay_cliente_id) {

                $this->load->library('openpagos');

                $registrar_usuario_en_openpay = $this->openpagos->crear_un_nuevo_cliente_en_openpay($validar_usuario->id, $validar_usuario->nombre_completo, $validar_usuario->apellido_paterno, $validar_usuario->correo, $validar_usuario->no_telefono);

                if (!$registrar_usuario_en_openpay) {
                    $this->response(array(
                        'error' => true,
                        'mostrar_mensaje' => true,
                        'titulo' => 'Ocurrió un error',
                        'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (2)',
                    ), REST_Controller::HTTP_BAD_REQUEST);
                }

                if (preg_match('/ERROR/i', $registrar_usuario_en_openpay)) {
                    $this->response(array(
                        'error' => true,
                        'mostrar_mensaje' => true,
                        'titulo' => 'Ocurrió un error',
                        'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (3)',
                    ), REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    if ($this->usuarios_model->editar($validar_usuario->id, array('openpay_cliente_id' => $registrar_usuario_en_openpay->id))) {
                        $this->response(array(
                            'mensaje' => 'Bienvenido, administra tus métodos de pago.',
                        ), REST_Controller::HTTP_OK);
                    } else {
                        $this->response(array(
                            'error' => true,
                            'mostrar_mensaje' => true,
                            'titulo' => 'Ocurrió un error',
                            'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (3)',
                        ), REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            }
        }
    }

    public function obtener_metodos_pago_por_usuario_get()
    {

        /** Recibir mensaje del api */
        $datos_get = $this->get();

        /** Validar que el usuario esté autenticado en la aplicación */
        $validar_usuario = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if (!$validar_usuario) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'Ocurrió un error',
                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (1)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $tarjetas_list = $this->tarjetas_model->get_tarjetas_por_usuario_id($validar_usuario->id)->result();

        if (!$tarjetas_list) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => '',
                'mensaje' => 'Bienvenido, agrega un método de pago.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->response($tarjetas_list);
    }

    public function agregar_metodos_pago_por_usuario_post()
    {

        /** Recibir mensaje del api */
        $datos_get = $this->post();
        $this->load->library('openpagos');

        /** Validar que el usuario esté autenticado en la aplicación */
        $validar_usuario = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if (!$validar_usuario) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'Ocurrió un error',
                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (1)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        /** ============ Se elimino esta parte del codigo por que hay que rehacerla bien ============ */
        /*
            $tarjetas_list = $this->tarjetas_model->get_tarjetas_por_usuario_id($validar_usuario->id)->result();

            if ($tarjetas_list) {

                $tarjetas_num = count(array_keys((array)$tarjetas_list));

                if ($tarjetas_num == 1) {
                    foreach ($tarjetas_list as $tarjeta_row) {
                        
                        $validar_si_la_tarjeta_esta_en_uso = $this->asignaciones_model->get_asignacion_por_usuario_id_y_openpay_tarjeta_id($tarjeta_row->openpay_tarjeta_id, $validar_usuario->id)->row();
                        
                        if (!$validar_si_la_tarjeta_esta_en_uso) {
                            
                            $data_tarjeta = array(
                                'estatus' => 'eliminado',
                            );
                    
                            if ($this->tarjetas_model->update_tarjeta($tarjeta_row->id, $data_tarjeta)) {

                                $respuesta_openpay = $this->openpagos->eliminar_una_tarjeta_en_openpay($validar_usuario->openpay_cliente_id, $tarjeta_row->openpay_tarjeta_id);
                                
                                if ($respuesta_openpay){

                                    if (preg_match('/ERROR/i', $respuesta_openpay)) {
                                        $this->response(array(
                                            'error' => true,
                                            'mostrar_mensaje' => true,
                                            'titulo' => 'Ocurrió un error',
                                            'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (2)',
                                        ), REST_Controller::HTTP_BAD_REQUEST);
                                    }

                                } else {
                                    $this->response(array(
                                        'error' => true,
                                        'mostrar_mensaje' => true,
                                        'titulo' => 'Ocurrió un error',
                                        'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (3)',
                                    ), REST_Controller::HTTP_BAD_REQUEST);
                                }
                            }
                        }
                    }
                }
            }
            */

        $respuesta_openpay = $this->openpagos->crear_una_tarjeta_con_token_de_cliente_en_openpay($validar_usuario->openpay_cliente_id, $datos_get['fuente_id'], $datos_get['dispositivo_id']);

        if (!$respuesta_openpay) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'Ocurrió un error',
                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (2)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        if (preg_match('/ERROR/i', $respuesta_openpay)) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'Ocurrió un error',
                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (3)<br><br>' . $respuesta_openpay,
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $openpay_tarjeta_id = $respuesta_openpay->id;

        $data_tarjeta = array(
            'usuario_id' => $validar_usuario->id,
            'openpay_cliente_id' => $validar_usuario->openpay_cliente_id,
            'openpay_tarjeta_id' => $openpay_tarjeta_id,
            'openpay_holder_name' => $respuesta_openpay->holder_name,
            'terminacion_card_number' => substr(str_replace(' ', '', $respuesta_openpay->card_number), -4),
            'openpay_expiration_month' => substr(str_replace(' ', '', $respuesta_openpay->expiration_month), 0, 2),
            'openpay_expiration_year' => substr(str_replace(' ', '', $respuesta_openpay->expiration_year), -2),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'brand' => $respuesta_openpay->brand,
            'banco' => $respuesta_openpay->bank_name,
            'banco_code' => $respuesta_openpay->bank_code,
            'allows_charges' => $respuesta_openpay->allows_charges,
            'allows_payouts' => $respuesta_openpay->allows_payouts
        );

        if ($this->tarjetas_model->insert_tarjeta($data_tarjeta)) {
            $this->response(array(
                'mensaje' => 'Método de pago guardado',
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'Ocurrió un error',
                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (4)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar_metodo_pago_por_usuario_post()
    {

        /** Recibir mensaje del api */
        $datos_get = $this->post();
        $this->load->library('openpagos');

        /** Validar que el usuario esté autenticado en la aplicación */
        $validar_usuario = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if (!$validar_usuario) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'Ocurrió un error',
                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (1)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $tarjeta_row = $this->tarjetas_model->get_tarjeta_por_openpay_id_por_usuario_id($datos_get['openpay_tarjeta_id'], $validar_usuario->id)->row();

        if ($tarjeta_row) {

            $validar_si_la_tarjeta_esta_en_uso = $this->asignaciones_model->get_asignacion_por_usuario_id_y_openpay_tarjeta_id($tarjeta_row->openpay_tarjeta_id, $validar_usuario->id)->row();

            if (!$validar_si_la_tarjeta_esta_en_uso) {

                $data_tarjeta = array(
                    'estatus' => 'eliminado',
                );

                if ($this->tarjetas_model->update_tarjeta($tarjeta_row->id, $data_tarjeta)) {

                    $respuesta_openpay = $this->openpagos->eliminar_una_tarjeta_en_openpay($validar_usuario->openpay_cliente_id, $tarjeta_row->openpay_tarjeta_id);

                    if ($respuesta_openpay) {

                        if (preg_match('/ERROR/i', $respuesta_openpay)) {
                            $this->response(array(
                                'error' => true,
                                'mostrar_mensaje' => true,
                                'titulo' => 'Ocurrió un error',
                                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (5)',
                            ), REST_Controller::HTTP_BAD_REQUEST);
                        }

                        $this->response($respuesta_openpay);
                    } else {
                        $this->response(array(
                            'error' => true,
                            'mostrar_mensaje' => true,
                            'titulo' => 'Ocurrió un error',
                            'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (4)',
                        ), REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            } else {
                $this->response(array(
                    'error' => true,
                    'mostrar_mensaje' => true,
                    'titulo' => 'Método de pago en uso',
                    'mensaje' => 'No fue posible eliminar este método de pago. Se encuentra vinculado a una suscripción.',
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'Ocurrió un error',
                'mensaje' => 'No fue posible procesar su solicitud, por favor intentelo más tarde. (2)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function compra_con_stripe_post()
    {

        $datos_post = $this->post();
        $asignaciones_id = null;

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        // Es necesario el id del plan y el id del usuario al cual se le va a asignar dicho plan, además del
        // source id y del id del dispositivo
        if (!$datos_post['plan_id'] || !$datos_post['usuario_id'] || !$datos_post['card_token']) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'No se realizó el cargo',
                'mensaje' => 'envío de datos inválidos'
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Obtener plan_row del plan a agregar
        $plan_row = $this->planes_model->obtener_por_id($datos_post['plan_id'])->row();

        if (!$plan_row) {
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'No se realizó el cargo',
                'mensaje' => 'El plan que intenta agregar ya no existe'
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $disciplinas = $this->planes_model->obtener_disciplinas_por_plan_id($plan_row->id)->result();

        $disciplinas_array = array();

        foreach ($disciplinas as $key => $value) {
            array_push($disciplinas_array, $value->disciplina_id);
        }

        $this->load->library('stripe_lib');

        $resultado_cargo = $this->stripe_lib->cargo(
            bcmul($plan_row->costo, 100),
            $plan_row->nombre,
            null,
            $plan_row->sku,
            $usuario_valido->correo,
            $datos_post['card_token']
        );

        if (!$resultado_cargo['error']) {

            if (!$this->asignaciones_model->crear(array(
                'usuario_id' => $usuario_valido->id,
                'plan_id' => $plan_row->id,
                'nombre' => $plan_row->nombre,
                'clases_incluidas' => $plan_row->clases_incluidas,
                'disciplinas' => implode('|', $disciplinas_array),
                'vigencia_en_dias' => $plan_row->vigencia_en_dias,
                'es_ilimitado' => !empty($plan_row->es_ilimitado) ? $plan_row->es_ilimitado : 'no',
                'fecha_activacion' => date('Y-m-d H:i:s'),
                'esta_activo' => 1
            ))) {
                //$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor intentelo mas tarde. (2)', 'usuario/shop');
                $this->response(array(
                    'error' => true,
                    'mostrar_mensaje' => true,
                    'titulo' => 'No se realizó el cargo',
                    'mensaje' => 'Ha ocurrido un error, por favor intentelo mas tarde. (2)'
                ), REST_Controller::HTTP_BAD_REQUEST);
            }

            $asignacion_row = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();

            if (!$this->ventas_model->crear(array(
                'concepto' => $plan_row->nombre,
                'usuario_id' => $usuario_valido->id,
                'asignacion_id' => $asignacion_row->id,
                'asignaciones_id' => $asignaciones_id,
                'metodo_id' => 10,
                'costo' => $plan_row->costo,
                'cantidad' => 1,
                'total' => $plan_row->costo,
                'vendedor' => 'Compra desde la aplicación'
            ))) {
                //$this->mensaje_del_sistema('MENSAJE_ERROR', 'Ha ocurrido un error, por favor intentelo mas tarde. (3)', 'usuario/shop');
                $this->response(array(
                    'error' => true,
                    'mostrar_mensaje' => true,
                    'titulo' => 'No se realizó el cargo',
                    'mensaje' => 'Ha ocurrido un error, por favor intentelo mas tarde. (3)'
                ), REST_Controller::HTTP_BAD_REQUEST);
            }

            $this->response(array(
                'mensaje' => 'El plan se agregó correctamente al cliente'
            ), REST_Controller::HTTP_CREATED);
        } else {
            //$this->mensaje_del_sistema('MENSAJE_ERROR', 'Compra error', 'usuario/inicio');
            $this->response(array(
                'error' => true,
                'mostrar_mensaje' => true,
                'titulo' => 'No se realizó el cargo',
                'mensaje' => $resultado_cargo['mensaje']
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /** PROCESO DE COMPRA CON TARJETA GUARDADA (METODO DE PAGO) */

    /**
     * Permite a un cliente adquirir/asignarse/comprar un plan
     */

    public function comprar_con_metodo_de_pago_y_cliente_guardado_en_openpay_post()
    {

        // Validar que el cliente que realiza la petición esté autenticado
        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        // Es necesario el id del plan y el id del usuario al cual se le va a asignar dicho plan, además del
        // source id y del id del dispositivo
        if (!$datos_post['plan_id'] || !$datos_post['usuario_id'] || !$datos_post['fuente_id'] || !$datos_post['dispositivo_id']) {
            $this->response(array(
                'error' => true,
                'titulo' => 'No fue posible realizar el cargo',
                'mensaje' => 'envío de datos inválidos',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Obtener datos del plan a agregar
        $plan_a_agregar = $this->planes_model->obtener_por_id($datos_post['plan_id'])->row();

        if (!$plan_a_agregar) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El plan que intenta agregar ya no existe',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $disciplinas = $this->planes_model->obtener_disciplinas_por_plan_id($plan_a_agregar->id)->result();

        $disciplinasIds = array();

        foreach ($disciplinas as $key => $value) {
            array_push($disciplinasIds, $value->disciplina_id);
        }

        // Realizar el cargo
        $this->load->library('openpagos');
        $this->openpagos->cargar_datos_comprador($usuario_valido->nombre_completo, $usuario_valido->correo, $usuario_valido->apellido_paterno, $usuario_valido->no_telefono);

        $resultado_openpay = $this->openpagos->aplicar_cargo_con_tarjeta_guardada($usuario_valido->openpay_cliente_id, $datos_post['fuente_id'], $plan_a_agregar->costo, $plan_a_agregar->nombre, $datos_post['dispositivo_id']);

        if ($resultado_openpay['error']) {

            // Ocurrió un error al intentar realizar el cargo
            $this->response(array(
                'error' => true,
                'mensaje' => $resultado_openpay['mensaje'],
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Agregar plan al usuario
        if (!$this->asignaciones_model->crear(array(
            'usuario_id' => $datos_post['usuario_id'],
            'plan_id' => $plan_a_agregar->id,
            'nombre' => $plan_a_agregar->nombre,
            'clases_incluidas' => $plan_a_agregar->clases_incluidas,
            'disciplinas' => implode('|', $disciplinasIds),
            'vigencia_en_dias' => $plan_a_agregar->vigencia_en_dias,
            'fecha_activacion' => date('Y-m-d H:i:s'),
            'esta_activo' => 1,
        ))) {

            $this->response(array(
                'error' => true,
                'mensaje' => 'Ha ocurrido un error al intentar agregar el plan al cliente',
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $obetener_id_asignacion = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();


        // Registrar la venta
        $this->ventas_model->crear(array(
            'concepto' => $plan_a_agregar->nombre,
            'usuario_id' => $datos_post['usuario_id'],
            'asignacion_id' => $obetener_id_asignacion->id,
            'metodo_id' => 3,
            'costo' => $plan_a_agregar->costo,
            'cantidad' => 1,
            'total' => $plan_a_agregar->costo,
            'vendedor' => 'Compra desde la aplicación',
        ));

        $this->response(array(
            'mensaje' => 'el plan se agregó correctamente al cliente',
        ), REST_Controller::HTTP_CREATED);
    }

    /** ============ Módulo de compras (FINAL) ============ */

    /**
     * Retorna la lista de los planes que un cliente ha adquirido (asignaciones)
     */
    public function seccion_descubre_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $descubre_row = $this->app_secciones_model->get_app_seccion_por_seccion("publicidad")->row();

        $this->response($descubre_row);
    }

    public function plan_row_disponible_get()
    {
        // Validar que el cliente que realiza la petición esté autenticado
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        //$planes = $this->planes_model->obtener_todos()->result();
        $plan_row = $this->planes_model->get_plan_row_disponible_para_venta_en_la_app()->row();

        $plan_con_disciplinas = new stdClass();
        $plan_con_disciplinas->id = $plan_row->id;
        $plan_con_disciplinas->dominio_id = $plan_row->dominio_id;
        $plan_con_disciplinas->sku = $plan_row->sku;
        $plan_con_disciplinas->nombre = $plan_row->nombre;
        $plan_con_disciplinas->descripcion = $plan_row->descripcion;
        $plan_con_disciplinas->clases_incluidas = $plan_row->clases_incluidas;
        $plan_con_disciplinas->vigencia_en_dias = $plan_row->vigencia_en_dias;
        $plan_con_disciplinas->costo = $plan_row->costo;
        $plan_con_disciplinas->subscripcion = $plan_row->subscripcion;
        $plan_con_disciplinas->terminos_condiciones = $plan_row->terminos_condiciones;
        $plan_con_disciplinas->url_infoventa = $plan_row->url_infoventa;

        $disciplinas = $this->planes_model->obtener_disciplinas_con_detalle_por_plan_id($plan_row->id)->result();

        $disciplinas_por_plan = array();

        foreach ($disciplinas as $disciplina) {
            $disciplina_por_plan = new stdClass();
            $disciplina_por_plan->id = $disciplina->id;
            $disciplina_por_plan->nombre = $disciplina->nombre;
            array_push($disciplinas_por_plan, $disciplina_por_plan);
        }

        $plan_con_disciplinas->disciplinas = $disciplinas_por_plan;

        $this->response($plan_con_disciplinas);
    }

    /**
     * Retorna la lista de los planes que un cliente ha adquirido (asignaciones)
     */
    public function asignaciones_por_cliente_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $asignaciones_por_cliente = $this->asignaciones_model->obtener_por_usuario_id($usuario_valido->id)->result();

        $resultado = array();

        foreach ($asignaciones_por_cliente as $asignacion_por_cliente_key => $asignacion_por_cliente_row) {;

            $disciplinas_ids = explode('|', $asignacion_por_cliente_row->disciplinas);

            // Obtenemos las disciplinas por sus IDs
            $disciplinas = $this->disciplinas_model->obtener_disciplinas_por_id($disciplinas_ids);

            // Creamos un array para almacenar los nombres de las disciplinas
            $disciplinas_nombres = [];

            foreach ($disciplinas as $disciplina) {
                $disciplinas_nombres[] = $disciplina->nombre;
            }

            $resultado[] = array(
                "id" => $asignacion_por_cliente_row->id,
                "usuario_id" => $asignacion_por_cliente_row->usuario_id,
                "plan_id" => $asignacion_por_cliente_row->plan_id,
                "nombre" => $asignacion_por_cliente_row->nombre,
                "clases_incluidas" => $asignacion_por_cliente_row->clases_incluidas,
                "clases_usadas" => $asignacion_por_cliente_row->clases_usadas,
                "periodo_de_prueba" => $asignacion_por_cliente_row->periodo_de_prueba,
                "vigencia_en_dias" => $asignacion_por_cliente_row->vigencia_en_dias,
                "disciplinas" => $asignacion_por_cliente_row->disciplinas,
                "disciplinas_perfil" => $disciplinas_nombres,
                "categoria" => $asignacion_por_cliente_row->categoria,
                "fecha_activacion" => date("d/m/Y", strtotime($asignacion_por_cliente_row->fecha_activacion)),
                "fecha_finalizacion" => date("d/m/Y", strtotime($asignacion_por_cliente_row->fecha_activacion . '+' . $asignacion_por_cliente_row->vigencia_en_dias . ' days')),
                "esta_activo" => $asignacion_por_cliente_row->esta_activo,
                "estatus" => $asignacion_por_cliente_row->estatus,
            );
        }

        $this->response($resultado);
    }

    /**
     * Permite a un cliente adquirir/asignarse/comprar un plan
     */
    public function asignar_plan_post()
    {
        // Validar que el cliente que realiza la petición esté autenticado
        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        // Es necesario el id del plan y el id del usuario al cual se le va a asignar dicho plan, además del
        // source id y del id del dispositivo
        if (!$datos_post['plan_id'] || !$datos_post['usuario_id'] || !$datos_post['fuente_id'] || !$datos_post['dispositivo_id']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'envío de datos inválidos',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Obtener datos del plan a agregar
        $plan_a_agregar = $this->planes_model->obtener_por_id($datos_post['plan_id'])->row();

        if (!$plan_a_agregar) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El plan que intenta agregar ya no existe',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $disciplinas = $this->planes_model->obtener_disciplinas_por_plan_id($plan_a_agregar->id)->result();

        $disciplinasIds = array();

        foreach ($disciplinas as $key => $value) {
            array_push($disciplinasIds, $value->disciplina_id);
        }

        // Realizar el cargo
        $this->load->library('openpagos');
        $this->openpagos->cargar_datos_comprador($usuario_valido->nombre_completo, $usuario_valido->correo, $usuario_valido->apellido_paterno, $usuario_valido->no_telefono);

        $resultado_openpay = $this->openpagos->aplicar_cargo_con_tarjeta($datos_post['fuente_id'], $plan_a_agregar->costo, $plan_a_agregar->nombre, $datos_post['dispositivo_id']);

        if ($resultado_openpay['error']) {

            // Ocurrió un error al intentar realizar el cargo
            $this->response(array(
                'error' => true,
                'mensaje' => $resultado_openpay['mensaje'],
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Agregar plan al usuario
        if (!$this->asignaciones_model->crear(array(
            'usuario_id' => $datos_post['usuario_id'],
            'plan_id' => $plan_a_agregar->id,
            'nombre' => $plan_a_agregar->nombre,
            'clases_incluidas' => $plan_a_agregar->clases_incluidas,
            'disciplinas' => implode('|', $disciplinasIds),
            'vigencia_en_dias' => $plan_a_agregar->vigencia_en_dias,
            'fecha_activacion' => date('Y-m-d H:i:s'),
            'esta_activo' => 1,
        ))) {

            $this->response(array(
                'error' => true,
                'mensaje' => 'Ha ocurrido un error al intentar agregar el plan al cliente',
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $obetener_id_asignacion = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();


        // Registrar la venta
        $this->ventas_model->crear(array(
            'concepto' => $plan_a_agregar->nombre,
            'usuario_id' => $datos_post['usuario_id'],
            'asignacion_id' => $obetener_id_asignacion->id,
            'metodo_id' => 3,
            'costo' => $plan_a_agregar->costo,
            'cantidad' => 1,
            'total' => $plan_a_agregar->costo,
            'vendedor' => 'Compra desde la aplicación',
        ));

        $this->response(array(
            'mensaje' => 'el plan se agregó correctamente al cliente',
        ), REST_Controller::HTTP_CREATED);
    }

    /**
     * Retorna la lista de las clases que están disponibles para reservar
     */
    public function clases_disponibles_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $clases = $this->clases_model->obtener_todas_con_detalle()->result();

        $this->response($clases);
    }

    /**
     * Activa un plan que algun cliente tenga
     */
    public function activar_plan_cliente_post()
    {
        // Validar que el cliente que realiza la petición esté autenticado
        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        $plan_cliente = $this->asignaciones_model->obtener_por_id($datos_post['asignacion_id'])->row();

        if (!$plan_cliente) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El plan para el cliente que intenta activar no existe',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        if (!$this->asignaciones_model->activar_plan($plan_cliente->id)) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Ha ocurrido un error y el plan no pudo ser activado',
            ), REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->response($plan_cliente);
    }

    /**
     * Cancela las reservaciones del usuario
     */
    public function cancelar_reservacion_por_id_post()
    {
        // Validar que el cliente que realiza la petición esté autenticado
        $datos_post = $this->post();

        if (!isset($datos_post['usuario_id'])) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el usuario de la reservación que que desea cancelar',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!isset($datos_post['reservacion_id'])) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el id de la reservación que desea cancelar.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $reservacion_a_cancelar = $this->reservaciones_model->obtener_reservacion_por_id($datos_post['reservacion_id'])->row();

        if (!$reservacion_a_cancelar) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'No se pudo encontrar la reservación que desea cancelar o ya ha sido cancelada, verifique de nuevo.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($reservacion_a_cancelar->asistencia != "asistencia") {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La reservación ha sido marcada con una inasistencia, por tal motivo no se puede cancelar.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $plan_cliente = $this->asignaciones_model->obtener_por_id($reservacion_a_cancelar->asignaciones_id)->row();

        if (!$plan_cliente) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'No se pudo encontrar el plan del cliente con el que hizo la reservación.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($plan_cliente->esta_activo == 0) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Lo sentimos,el plan del cliente ya no se encuentra activo.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $clase_a_modificar = $this->clases_model->obtener_por_id($reservacion_a_cancelar->clase_id)->row();

        if (!$clase_a_modificar) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'No se ha podido encontrar la clase que se ha reservado.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $app_cancelar_reservacion_hrs = $this->configuraciones_model->get_configuracion_por_configuracion("app_cancelar_reservacion_hrs")->row();

        $fecha_clase = $clase_a_modificar->inicia;
        $fecha_limite_clase = strtotime('-' . $app_cancelar_reservacion_hrs->valor_1 . ' hours', strtotime($fecha_clase));

        if (strtotime('now') > $fecha_limite_clase) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Las reservaciones solo se pueden cancelar ' . $app_cancelar_reservacion_hrs->valor_1 . ' horas antes de la clase.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $app_prevenir_cancelacion_hrs = $this->configuraciones_model->get_configuracion_por_configuracion("app_prevenir_cancelacion_hrs")->row();

        if ($app_prevenir_cancelacion_hrs->estatus_1 == "activo") {
            if (date('H:i', strtotime('now')) >= $app_prevenir_cancelacion_hrs->valor_1 or date('H:i', strtotime('now')) <= $app_prevenir_cancelacion_hrs->valor_2) {
                $this->response(array(
                    'error' => true,
                    'mensaje' => 'Las reservaciones no se podrán cancelar de ' . date("g:i A", strtotime("$app_prevenir_cancelacion_hrs->valor_1:00")) . ' a ' . date("g:i A", strtotime("$app_prevenir_cancelacion_hrs->valor_2:00")) . '.',
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        }

        if ($plan_cliente->esta_activo) {

            $fecha_activacion = $plan_cliente->fecha_activacion;
            log_message('debug', $fecha_activacion);

            $fecha_vigencia = strtotime($fecha_activacion . ' + ' . $plan_cliente->vigencia_en_dias . ' days');
            log_message('debug', $fecha_vigencia);
            log_message('debug', strtotime('now'));

            if (strtotime('now') > $fecha_vigencia) {
                $this->response(array(
                    'error' => true,
                    'mensaje' => 'El plan ha expirado.',
                ), REST_Controller::HTTP_BAD_REQUEST);
            } /*else{
                $this->session->set_flashdata('MENSAJE_INFO', 'El plan sigue activo y caduca el. '.$fecha_vigencia);
                redirect('reservaciones/index');
            }*/
        } else { // Si no está activo
            $this->response(array(
                'error' => true,
                'mensaje' => 'El plan no se encuentra activado.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Establecer como desocupado
        $cupo_lugares = $clase_a_modificar->cupo_lugares;
        $cupo_lugares = json_decode($cupo_lugares);

        foreach ($cupo_lugares as $lugar) {
            if ($lugar->no_lugar == $reservacion_a_cancelar->no_lugar) {
                $lugar->esta_reservado = false;
                $lugar->nombre_usuario = '';
            }
        }

        $cupo_lugares_json = json_encode($cupo_lugares);

        $clases_usadas = $plan_cliente->clases_usadas - $clase_a_modificar->intervalo_horas;
        $reservado = $clase_a_modificar->reservado - 1;

        // Actualizar el plan del cliente y la clase para que se establezca que una clase ha sido usada
        if (
            !$this->asignaciones_model->editar($plan_cliente->id, array('clases_usadas' => $clases_usadas)) ||
            !$this->clases_model->editar($clase_a_modificar->id, array('reservado' => $reservado, 'cupo_lugares' => $cupo_lugares_json))
        ) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La reservación no pudo ser cancelada.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // modificar reservación
        $reservacion = $this->reservaciones_model->editar($reservacion_a_cancelar->id, array(
            'asistencia' => 'cancelada',
            'estatus' => 'Cancelada',
        ));

        if (!$reservacion) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La reservación no pudo ser cancelada.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Calificar coach
     */
    public function calificar_coach_por_id_post()
    {
        // Validar que el cliente que realiza la petición esté autenticado
        $datos_post = $this->post();

        if (!isset($datos_post['usuario_id'])) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el usuario de la reservación que que desea cancelar',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!isset($datos_post['instructor_id'])) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el id del coach que desea calificar.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $coach_a_calificar = $this->usuarios_model->obtener_instructor_por_id($datos_post['instructor_id'])->row();

        if (!$coach_a_calificar) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'No se pudo encontrar la reservación que desea cancelar o ya ha sido cancelada, verifique de nuevo.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
        $fecha_registro = date("Y-m-d H:i:s");
        // modificar reservación

        $cambiarcalificada = $this->reservaciones_model->editar($datos_post['reservacionId'], array(
            'calificada' => 'si'
        ));

        if (!$cambiarcalificada) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El coach no pudo ser calificado.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $calificaion = $this->resenias_model->agregar(array(
            'reservacion_id' => $datos_post['reservacionId'],
            'clase_id' => $datos_post['claseId'],
            'usuario_id' => $datos_post['usuario_id'],
            'instructor_id' => $datos_post['instructor_id'],
            'calificacion' => $datos_post['selectedRating'],
            'nota' => $datos_post['reviewText'],
            'fecha_registro' => $fecha_registro,
        ));

        if (!$calificaion) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El coach no pudo ser calificado.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retorna las disciplinas disponibles en el sistema
     */
    public function sucursales_disponibles_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $sucursales_list = $this->sucursales_model->get_sucursales_disponibles()->result();

        $this->response($sucursales_list);
    }

    public function obtener_rel_planes_categorias_por_rel_plan_categoria()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $planes_categorias = $this->rel_planes_categorias_model->obtener_rel_planes_categorias()->result();

        $this->response($planes_categorias);
    }

    /**
     * Retorna las disciplinas disponibles en el sistema
     */
    public function disciplinas_disponibles_por_sucursal_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $disciplinas = $this->disciplinas_model->obtener_disponibles_por_sucursal($datos_get['sucursal_id'])->result();

        $this->response($disciplinas);
    }

    /**
     * Retorna las disciplinas disponibles en el sistema
     */
    public function disciplinas_disponibles_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        //$disciplinas = $this->disciplinas_model->obtener_todas()->result();
        $disciplinas = $this->disciplinas_model->obtener_disciplinas_para_app()->result();

        $this->response($disciplinas);
    }

    /**
     * Retornar las clases disponibles por disciplinas
     *
     * @return void
     */
    public function clases_por_disciplina_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if (!$datos_get['disciplina_id'] || !$datos_get['fecha_inicio']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el id de una disciplina y la fecha de inicio',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $clases_por_disciplina = $this->clases_model->obtener_por_disciplina_id_y_fecha_inicio($datos_get['disciplina_id'], $datos_get['fecha_inicio'])->result();

        log_message('debug', $this->db->last_query());

        $this->response($clases_por_disciplina);
    }

    /**
     * Retornar las clases disponibles por disciplinas
     *
     * @return void
     */

    public function clases_por_disciplina_y_semana_get()
    {
        setlocale(LC_ALL, "es_ES", "Spanish_Spain");
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if (!$datos_get['disciplina_id'] || !$datos_get['fecha_inicio'] || !$datos_get['fecha_final']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el id de una disciplina y la fecha de inicio',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $clases_list = $this->clases_model->obtener_por_disciplina_id_y_fecha_inicio_y_fecha_final($datos_get['disciplina_id'], $datos_get['fecha_inicio'], $datos_get['fecha_final'])->result();

        $result = array();

        foreach ($clases_list as $clases_row) {
            $result[] = array(
                "id" => $clases_row->id,
                "identificador" => $clases_row->identificador,
                "dificultad" => $clases_row->dificultad,
                "disciplina_id" => $clases_row->disciplina_id,
                "subdisciplina_id" => $clases_row->subdisciplina_id,
                "instructor_id" => $clases_row->instructor_id,
                "cupo" => $clases_row->cupo,
                "reservado" => $clases_row->reservado,
                "inasistencias" => $clases_row->inasistencias,
                "intervalo_horas" => $clases_row->intervalo_horas,
                "img_acceso" => $clases_row->img_acceso,
                "inicia" => $clases_row->inicia,
                "hora" => date('h:i a', strtotime($clases_row->inicia)),
                "fecha" => date('Y-m-d', strtotime($clases_row->inicia)),
                "dia_espanhol" =>  iconv('ISO-8859-2', 'UTF-8', strftime("%A", strtotime($clases_row->inicia))),
                "fecha_espanhol" =>  iconv('ISO-8859-2', 'UTF-8', strftime("%d de %B de %Y", strtotime($clases_row->inicia))),
                "inicia_ionic" => $clases_row->inicia_ionic,
                "distribucion_imagen" => $clases_row->distribucion_imagen,
                "distribucion_lugares" => $clases_row->distribucion_lugares,
                "cupo_lugares" => $clases_row->cupo_lugares,
                "estatus" => $clases_row->estatus,
                "usuario" => $clases_row->usuario,
                "instructor" => $clases_row->instructor,
                "disciplina" => $clases_row->disciplina,
            );
        }
        // echo json_encode(array("data" => $result));

        log_message('debug', $this->db->last_query());

        $this->response($result);
    }


    /**
     * Obtiene los datos de una clase en específico con base en el id de la clase
     */
    public function clase_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if (!$datos_get['clase_id']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el id de la clase a obtener',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $clase = $this->clases_model->obtener_por_id($datos_get['clase_id'])->row();

        if (!$clase) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La clase que busca no se encuentra en la base de datos',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $this->response($clase);
    }

    /**
     * Obtiene las reservaciones hechas por usuario
     */
    public function reservaciones_por_usuario_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $reservaciones_por_usuario = $this->reservaciones_model->obtener_reservacion_por_cliente($usuario_valido->id)->result();

        $this->response($reservaciones_por_usuario);
    }

    /**
     * Obtiene las reservaciones terminadas hechas por usuario
     */
    public function reservaciones_terminadas_por_usuario_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $reservaciones_terminadas_por_usuario = $this->reservaciones_model->obtener_reservacion_terminada_por_cliente($usuario_valido->id)->result();

        // $reservaciones_terminadas_por_usuario = $this->reservaciones_model->obtener_reservacion_terminada_por_cliente('2370')->result();

        $this->response($reservaciones_terminadas_por_usuario);
    }

    /**
     * Actualiza las reservaciones del servidor
     */
    /*public function comprobar_reservaciones_activas_post()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        if ($datos_get['usuario_id']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el id del usuario',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $reservaciones_activas = $this->reservaciones_model->obtener_activas()->result();
        
        foreach ($reservaciones_activas as $reservacion) {
            $clase_de_la_reservacion = $this->ventas_model->obtener_por_id($reservacion->clase_id)->row();

            $fecha_caducidad = $clase_de_la_reservacion->inicia;
            log_message('debug', $fecha_caducidad);

            $fecha_vigencia = strtotime($fecha_caducidad);
            log_message('debug', $fecha_vigencia);
            log_message('debug', strtotime('now'));

            if (strtotime('now') > $fecha_vigencia) {
                $data = array(
                    'estatus' => 'Caducada',
                );
                $this->reservaciones_model->caducar_reservacion($reservacion->id, $data);
            } /*else{
                
            }
        }

    }*/

    /**
     * Obtiene los datos del usuario autenticado
     *
     * @return void
     */
    public function aviso_clase_get()
    {
        $datos_get = $this->get();

        $usuario_valido = $this->_autenticar_usuario($datos_get['token'], $datos_get['usuario_id']);

        $anuncios_list = $this->anuncios_model->get_anuncio_por_tipo("aviso_clases")->row();

        $this->response($anuncios_list);
    }

    public function aplicar_cupon_post()
    {
        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!$usuario_valido) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Ha ocurrido un error, por favor intentelo mas tarde. (1)',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        if (!$datos_post['cupon']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Por favor ingrese un código valido. (1)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $codigo_row = $this->codigos_model->obtener_codigo_por_codigo($datos_post['cupon'])->row();

        if (!$codigo_row) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Por favor ingrese un código valido. (2)',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        if ($codigo_row === $datos_post['cupon']) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Por favor ingrese un código valido. (3)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $validar_canje = $this->codigos_canjeados_model->obtener_codigo_canjeado_por_codigo_y_usuario_id($datos_post['cupon'], $datos_post['usuario_id'])->row();

        if ($validar_canje) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Ya has canjeado este código.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $fecha_registro = date("Y-m-d H:i:s");
        $key = "clientes-" . date("Y-m-d-H-i-s", strtotime($fecha_registro));
        $identificador = hash("crc32b", $key);

        $data = array(
            'identificador' => $identificador,
            'usuario_id' => $usuario_valido->id,
            'codigo_id' => $codigo_row->id,
            'codigo' => $codigo_row->codigo,
            'estatus' => 'activo'
        );

        if (!$data) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Ha ocurrido un error, por favor intentelo mas tarde. (2)',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        if (!$this->codigos_canjeados_model->insert_codigo_canjeado($data)) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Ha ocurrido un error, por favor intentelo mas tarde. (3)',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $this->response(array(
            'mensaje' => 'El código ha sido aplicado con éxito. Has activado la tienda VIP, revisa los planes que tenemos disponibles para ti alístate para comenzar tu entrenamiento.',
        ), REST_Controller::HTTP_OK);
    }

    /**
     * Función privada utilitaria que autentica la petición/solicitud de
     * un usuario
     *
     * @param string $token
     * @param string $usuario_id
     * @return object
     */
    private function _autenticar_usuario($token = null, $usuario_id = null)
    {
        if (is_null($token) || is_null($usuario_id)) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Token y/o usuario inválido',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $usuario_valido = $this->usuarios_model->obtener_por_token_id($token, $usuario_id)->row();

        if (!$usuario_valido) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Token y/o usuario inválido',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($usuario_valido->token != $token) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Token y/o usuario inválido',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        return $usuario_valido;
    }

    /* ====== Deprecated ====== */

    /**
     * Permite a un cliente reservar una clase
     */
    public function reservar_clase_post_Deprecated()
    {
        /** Esto se bloqueó por el cierre de operaciones de Sensoria. */
        /*
        $this->response(array(
            'error' => true,
            'mensaje' => 'Por el momento no es posible realizar la reservación.',
        ), REST_Controller::HTTP_BAD_REQUEST);
        */
        // Validar que el cliente que realiza la petición esté autenticado
        $datos_post = $this->post();

        $usuario_valido = $this->_autenticar_usuario($datos_post['token'], $datos_post['usuario_id']);

        if (!isset($datos_post['asignacion_id'])) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el id del plan del usuario que se utilizará para hacer la reservación',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Verificar que se haya enviado un id del plan a utilizar y un id de clase válidos
        $plan_cliente = $this->asignaciones_model->obtener_por_id($datos_post['asignacion_id'])->row();

        if (!$plan_cliente) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El plan para el cliente que busca no existe',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        // Validar que se haya enviado la clase a reservar y el lugar seleccionado
        if (!isset($datos_post['clase_id']) || (!isset($datos_post['no_lugar']) || $datos_post['no_lugar'] == 0)) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Se requiere el id de la clase y el num del lugar de la clase a reservar',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $clase_a_reservar = $this->clases_model->obtener_por_id($datos_post['clase_id'])->row();

        if (!$clase_a_reservar) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La clase que busca no existe',
            ), REST_Controller::HTTP_NOT_FOUND);
        }

        $fecha_de_clase = $clase_a_reservar->inicia;
        $fecha_limite_de_clase = strtotime('+15 minutes', strtotime($fecha_de_clase));

        if (strtotime('now') > $fecha_limite_de_clase) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Lo sentimos, la clase que desea reservar esta por comenzar, por favor seleccione otro horario.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Validar que el usuario no haya reservado ya un lugar en esta clase
        $reservacion_existente = $this->reservaciones_model->obtener_reservacion_por_cliente_y_clase($datos_post['usuario_id'], $datos_post['clase_id']);

        //if ($reservacion_existente) {
        if ($reservacion_existente->num_rows() >= 1) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'Haz alcanzado el limite de reservaciones por clase.',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Verificar el plan; que tenga clases disponibles, que esté activo, que sea vigente y que la disciplina corresponda
        // a la de la clase que se quiere reservar (igual esto se podría hacer desde que el plan es seleccionado en el dispositivo
        // móvil, aunque no estaría de más otra verificación en el lado del servidor)
        if (($plan_cliente->clases_incluidas - $plan_cliente->clases_usadas) < $clase_a_reservar->intervalo_horas) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'No cuenta con las clases suficientes en su plan',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        $disciplinas_ids_asignacion = explode('|', $plan_cliente->disciplinas);

        if (!is_array($disciplinas_ids_asignacion)) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El plan seleccionado no puede ser usado para la disciplina a la que pertenece la clase a reservar',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        if (!in_array($clase_a_reservar->disciplina_id, $disciplinas_ids_asignacion) and !in_array($clase_a_reservar->subdisciplina_id, $disciplinas_ids_asignacion)) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'El plan seleccionado no puede ser usado para la disciplina a la que pertenece la clase a reservar',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        if ($plan_cliente->esta_activo) {

            $fecha_activacion = $plan_cliente->fecha_activacion;
            log_message('debug', $fecha_activacion);

            $fecha_vigencia = strtotime($fecha_activacion . ' + ' . $plan_cliente->vigencia_en_dias . ' days');
            log_message('debug', $fecha_vigencia);
            log_message('debug', strtotime('now'));

            if (strtotime('now') > $fecha_vigencia) {
                $this->response(array(
                    'error' => true,
                    'mensaje' => 'El plan ha expirado, por favor utilice otro',
                ), REST_Controller::HTTP_BAD_REQUEST);
            }
        } else { // Si no está activo entonces activarlo
            $this->asignaciones_model->activar_plan($plan_cliente->id);
        }

        // Establecer como ocupado/reservado el lugar que se seleccionó
        $cupo_lugares = $clase_a_reservar->cupo_lugares;
        $cupo_lugares = json_decode($cupo_lugares);

        foreach ($cupo_lugares as $lugar) {
            if ($lugar->no_lugar == $datos_post['no_lugar']) {
                if ($lugar->esta_reservado) {
                    $this->response(array(
                        'error' => true,
                        'mensaje' => 'El lugar seleccionado ya se encuentra reservado',
                    ), REST_Controller::HTTP_BAD_REQUEST);
                }
                $lugar->esta_reservado = true;
                $lugar->nombre_usuario = $usuario_valido->id;
            }
        }

        $cupo_lugares_json = json_encode($cupo_lugares);

        $clases_usadas = $plan_cliente->clases_usadas + $clase_a_reservar->intervalo_horas;
        $reservado = $clase_a_reservar->reservado + 1;

        // Actualizar el plan del cliente y la clase para que se establezca que una clase ha sido usada
        if (
            !$this->asignaciones_model->editar($plan_cliente->id, array('clases_usadas' => $clases_usadas)) ||
            !$this->clases_model->editar($clase_a_reservar->id, array('reservado' => $reservado, 'cupo_lugares' => $cupo_lugares_json))
        ) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La reservación no pudo ser creada',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Crear reservación
        $reservacion = $this->reservaciones_model->crear(array(
            'usuario_id' => $usuario_valido->id,
            'clase_id' => $clase_a_reservar->id,
            'asignaciones_id' => $plan_cliente->id,
            'no_lugar' => $datos_post['no_lugar'],
        ));

        if (!$reservacion) {
            $this->response(array(
                'error' => true,
                'mensaje' => 'La reservación no pudo ser creada',
            ), REST_Controller::HTTP_BAD_REQUEST);
        }

        // Obtener la reservación recién creada
        $reservacion_creada = $this->reservaciones_model->obtener_por_id($this->db->insert_id())->row();

        $this->response($reservacion_creada);
    }
}
