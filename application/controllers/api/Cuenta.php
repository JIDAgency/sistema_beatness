<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Cuenta extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->config->load('b3studio', true);
        $this->load->database();
        $this->load->model('usuarios_model');
    }

    /* ====== Registro de usuario en la App ====== */

    /**
     * Función que registra a un usuario. Recibe el nombre completo, el apellido paterno, el correo y una
     * contraseña. Guarda al usuario nuevo, genera un token y lo envía de vuelta para futuras peticiones.
     *
     * @return mixed
     */
    public function registrar_usuario_post()
    {
        $datos_post = $this->post();

        // Verificar si los datos requeridos están presentes
        if (!$datos_post['nombre_completo'] || !$datos_post['no_telefono'] || !$datos_post['correo'] || !$datos_post['contrasena']) {
            $this->response(
                array(
                    'error' => true,
                    'mensaje' => 'Por favor complete todos los campos obligatorios para registrar su cuenta. (1)'
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }

        // Iniciar la transacción
        $this->db->trans_begin();

        try {

            // Verificar si el usuario existe con el número de teléfono
            $verificar_no_telefono_existente = $this->usuarios_model->verificar_no_telefono_existente($datos_post['no_telefono']);

            if ($verificar_no_telefono_existente) {
                // Si el número de teléfono ya está registrado, lanzar una excepción
                throw new Exception('Ya existe una cuenta registrada con este <b>número de teléfono</b>. Si olvidaste tu contraseña, puedes restablecerla a través de la opción "Olvidé mi contraseña". Si necesitas ayuda, por favor contáctanos. (2)', REST_Controller::HTTP_BAD_REQUEST);
            }

            // Verificar si el usuario existe con el correo electrónico
            $verificar_correo_existente = $this->usuarios_model->verificar_correo_existente($datos_post['correo']);

            if ($verificar_correo_existente) {
                // Si el correo electrónico ya está registrado, lanzar una excepción
                throw new Exception('Ya existe una cuenta registrada con esta dirección de <b>correo electrónico</b>. Si olvidaste tu contraseña, puedes restablecerla a través de la opción "Olvidé mi contraseña". Si necesitas ayuda, por favor contáctanos. (3)', REST_Controller::HTTP_BAD_REQUEST);
            }

            // Crear usuario
            $data_1 = array(
                'correo' => $datos_post['correo'],
                'contrasena_hash' => password_hash($datos_post['contrasena'], PASSWORD_DEFAULT),
                'nombre_completo' => $datos_post['nombre_completo'],
                'apellido_paterno' => $datos_post['apellido_paterno'],
                'apellido_materno' => $datos_post['apellido_materno'],
                'no_telefono' => $datos_post['no_telefono'],
                'codigo_postal' => $datos_post['codigo_postal'],
                'talla_calzado' => $datos_post['talla_calzado'],
                //'sucursal_id' => $datos_post['sucursal'],
                'rol_id' => 1, // Pertenece al rol de cliente por defecto
            );

            if (!$data_1) {
                // Si no se pudo crear el usuario, lanzar una excepción
                throw new Exception('Ha ocurrido un error al procesar el registro, por favor inténtenlo más tarde. (4)', REST_Controller::HTTP_BAD_REQUEST);
            }

            if (!$this->usuarios_model->crear($data_1)) {
                // Si no se pudo crear el usuario, lanzar una excepción
                throw new Exception('Ha ocurrido un error al procesar el registro, por favor inténtenlo más tarde. (5)', REST_Controller::HTTP_BAD_REQUEST);
            }

            $usuario_id = $this->db->insert_id();

            // Generar token
            $token = bin2hex(openssl_random_pseudo_bytes(20));

            // Actualizar el token del usuario recién creado
            if (!$this->usuarios_model->editar($usuario_id, array('token' => $token))) {
                // Si no se pudo actualizar el token, lanzar una excepción
                throw new Exception('Ha ocurrido un error al generar la sesión, por favor inténtenlo más tarde. (6)', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Confirmar la transacción
            $this->db->trans_commit();

            // Responder con éxito y devolver el token y el ID del usuario
            $this->response(
                array(
                    'error' => false,
                    'token' => $token,
                    'usuario_id' => $usuario_id,
                )
            );
        } catch (Exception $e) {
            // Deshacer la transacción en caso de error
            $this->db->trans_rollback();

            // Responder con el mensaje de error y el código de estado HTTP correspondiente
            $this->response(
                array(
                    'error' => true,
                    'mensaje' => $e->getMessage(),
                ),
                $e->getCode()
            );
        }
    }

    /**
     * Función que auntentica a un usuario; esta función deberá recibir un correo y una
     * contraseña, validar dicha información contra la base de datos de usuarios y generar un token para
     * subsecuentes peticiones del mismo usuario hacia la API
     *
     * @return void
     */
    public function login_post()
    {

        $datos_acceso = $this->post();

        // Validar que un correo y una contraseña han sido enviados
        if (!isset($datos_acceso['correo']) || !isset($datos_acceso['contrasena'])) {
            $respuesta = array(
                'error' => true,
                'mensaje' => 'La información enviada no es válida',
            );
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
        }

        // Validar que los datos de acceso sean correctos
        $usuario_registrado = $this->usuarios_model->obtener_usuario_por_correo($datos_acceso['correo'])->row();

        if (!$usuario_registrado || !password_verify($datos_acceso['contrasena'], $usuario_registrado->contrasena_hash)) {
            $respuesta = array(
                'error' => true,
                'mensaje' => 'El correo y/o contraseña no son válidos',
            );
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
        }

        if (!$usuario_registrado || $usuario_registrado->estatus == "suspendido") {
            $respuesta = array(
                'error' => true,
                'mensaje' => 'Este usuario se encuentra suspendido, por favor comuníquese con la administración para cualquier aclaración.',
            );
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
        }

        // Generar el token y guardarlo en la bd para futuras peticiones
        $token = bin2hex(openssl_random_pseudo_bytes(20));

        if (!$this->usuarios_model->editar($usuario_registrado->id, array('token' => $token))) {
            $respuesta = array(
                'error' => true,
                'mensaje' => 'Ha ocurrido un error al intentar ingresar al usuario, por favor inténtelo más tarde',
            );
            $this->response($respuesta, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }

        $respuesta = array(
            'error' => false,
            'token' => $token,
            'usuario_id' => $usuario_registrado->id,

        );

        $this->response($respuesta);
    }

    /**
     * Función que registra/loggea a un usuario usando el servicio de Facebook. Si el usuario
     * que utiliza esta función es nuevo (con base el userID recibido); entonces lo registra
     * y le permite el acceso; sino, entonces sólo actualiza sus datos y le permite el acceso.
     * Devuelve un token
     *
     * @return mixed
     */
    public function iniciar_con_facebook_post()
    {

        $datos_post = $this->post();

        if (!$datos_post['facebook_id']) {
            $this->response(
                array(
                    'error' => true,
                    'mensaje' => 'El facebook id es necesario para acceder a la aplicación utilizando el servicio de terceros Facebook',
                ),
                REST_Controller::HTTP_BAD_REQUEST
            );
        }

        // Buscar usuario por facebook id
        $usuario_facebook = $this->usuarios_model->obtener_por_facebook_id($datos_post['facebook_id'])->row();

        // Si existe ya un usuario con ese id de facebook, entonces actualizar sus datos
        if ($usuario_facebook) {

            if (
                !$this->usuarios_model->editar(
                    $usuario_facebook->id,
                    array(
                        'nombre_completo' => $datos_post['nombre_completo'],
                        'apellido_paterno' => $datos_post['apellido_paterno'],
                        'correo' => $datos_post['correo'],
                    )
                )
            ) {
                $this->response(
                    array(
                        'error' => true,
                        'mensaje' => 'Ha ocurrido un error al intentar entrar a la aplicación usando Facebook, por favor inténtalo más tarde',
                    ),
                    REST_Controller::HTTP_BAD_REQUEST
                );
            }
        } else { // si no, entoces registrar al usuario
            if (
                !$this->usuarios_model->crear(
                    array(
                        'nombre_completo' => $datos_post['nombre_completo'],
                        'apellido_paterno' => $datos_post['apellido_paterno'],
                        'correo' => $datos_post['correo'],
                        'facebook_id' => $datos_post['facebook_id'],
                        'rol_id' => $this->config->item('id_rol_cliente', 'b3studio'), // Los usuarios que se registren por si mismos desde la página serán, por
                        // defecto, usuarios de tipo 'cliente'
                    )
                )
            ) {
                $this->response(
                    array(
                        'error' => true,
                        'mensaje' => 'Ha ocurrido un error al intentar entrar a la aplicación usando Facebook, por favor inténtalo más tarde',
                    ),
                    REST_Controller::HTTP_BAD_REQUEST
                );
            }
        }

        // Obtener los nuevos datos del usaurio
        $usuario_facebook = $this->usuarios_model->obtener_por_facebook_id($datos_post['facebook_id'])->row();

        // Generar token
        $token = bin2hex(openssl_random_pseudo_bytes(20));

        if (!$this->usuarios_model->editar($usuario_facebook->id, array('token' => $token))) {
            $this->response(
                array(
                    'error' => true,
                    'mensaje' => 'Ha ocurrido un error al intentar entrar a la aplicación usando Facebook, por favor inténtalo más tarde',
                ),
                REST_Controller::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $this->response(
            array(
                'error' => false,
                'token' => $token,
                'usuario_id' => $usuario_facebook->id,
                'facebook_id' => $usuario_facebook->facebook_id,
            )
        );
    }
}
