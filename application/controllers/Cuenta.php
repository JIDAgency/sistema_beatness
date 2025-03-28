<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller Cuenta
 *
 * Maneja autenticación, registro, recuperación de contraseña,
 * integración con Facebook y cierre de sesión.
 *
 * @package    Sistema_Beatness
 * @subpackage Controllers
 */
class Cuenta extends CI_Controller
{
    // -------------------------------------------------------------------------
    // Constructor e Inicialización
    // -------------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();

        // Cargar configuración y recursos
        $this->config->load('b3studio', true);

        // Modelos
        $this->load->model('colaboradores_sucursales_model');
        $this->load->model("usuarios_model");

        // Librerías
        $this->load->library('facebook');
        $this->load->library('session');
        $this->load->library('form_validation');

        // Helpers
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('string');

        // Base de datos
        $this->load->database();
    }

    // -------------------------------------------------------------------------
    // Redirección Inicial
    // -------------------------------------------------------------------------
    public function index()
    {
        redirect("cuenta/iniciar_sesion");
    }

    // -------------------------------------------------------------------------
    // Autenticación de Usuarios
    // -------------------------------------------------------------------------
    public function iniciar_sesion()
    {
        // Validación de formulario
        $this->form_validation->set_rules('correo', 'correo electrónico', 'required');
        $this->form_validation->set_rules('contrasena', 'contraseña', 'required');

        if ($this->form_validation->run() == false) {
            // Si ya hay sesión activa en este sistema, redirigir según rol
            if (
                $this->session->userdata('en_sesion') &&
                $this->session->userdata('sitio') == $this->config->item('sistema_id', 'b3studio')
            ) {
                $usuario_row = $this->db->query(
                    'SELECT * FROM `usuarios` WHERE `id` = ' . $this->session->userdata('id')
                )->row();

                if ($usuario_row->estatus == "activo") {
                    // Roles de tipo administrador y similares
                    if (in_array($this->session->userdata('rol_id'), array('2', '4', '5', '7'), true)) {
                        redirect('inicio');
                    }
                    // Roles de tipo cliente/instructor/corporativo
                    elseif (in_array($this->session->userdata('rol_id'), array('1', '3', '6'), true)) {
                        // Ahora, si el rol es 3 (Instructor) se redirige a la sección de instructores
                        if ($this->session->userdata('rol_id') == 3) {
                            redirect('instructor/inicio');
                        } else {
                            redirect('usuario/inicio');
                        }
                    }
                } else {
                    $this->session->sess_destroy();
                    $data['mensaje_error'] = 'Este usuario se encuentra suspendido, por favor comuníquese con la administración para cualquier aclaración.';
                    $this->load->view('cuenta/iniciar_sesion_2', $data);
                    return;
                }
            }
            $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
            $this->load->view('cuenta/iniciar_sesion_2', $data);
            return;
        }

        // Si la validación pasó, se procede a validar las credenciales
        $query = $this->db->query(
            'SELECT * FROM `usuarios` WHERE BINARY `correo` = ' .
                $this->db->escape($this->input->post('correo')) .
                ' AND `rol_id` IN (1,2,3,4,5,6,7)'
        );

        if ($query->num_rows()) {
            $data_usuario = $query->row();

            if ($data_usuario->estatus != "activo") {
                $data['mensaje_error'] = 'Este usuario se encuentra suspendido, por favor comuníquese con la administración para cualquier aclaración.';
                $this->load->view('cuenta/iniciar_sesion_2', $data);
                return;
            }

            // Verificar contraseña para clientes, instructores y corporativos
            if (
                password_verify($this->input->post('contrasena'), $data_usuario->contrasena_hash) &&
                in_array($data_usuario->rol_id, array('1', '3', '6'), true)
            ) {
                $token_web = $this->_actualizar_token($data_usuario->id);
                if (!$token_web) {
                    $data['mensaje_error'] = '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (1)';
                    $this->load->view('cuenta/iniciar_sesion_2', $data);
                    return;
                }

                // Si el rol es Instructor (3), redirigir a la sección de instructores
                if ($data_usuario->rol_id == 3) {
                    $this->_preparar_datos_sesion($data_usuario->correo, $data_usuario->nombre_completo, $data_usuario->rol_id, $data_usuario->id, $data_usuario->nombre_imagen_avatar, NULL, $token_web);
                    redirect('instructor/inicio');
                } else {
                    $this->_preparar_datos_sesion($data_usuario->correo, $data_usuario->nombre_completo, $data_usuario->rol_id, $data_usuario->id, $data_usuario->nombre_imagen_avatar, NULL, $token_web);
                    redirect('usuario/inicio');
                }
            }
            // Verificar contraseña para administradores
            elseif (
                password_verify($this->input->post('contrasena'), $data_usuario->contrasena_hash) &&
                in_array($data_usuario->rol_id, array('2', '4', '5', '7'), true)
            ) {
                $token_web = $this->_actualizar_token($data_usuario->id);
                if (!$token_web) {
                    $data['mensaje_error'] = '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (1)';
                    $this->load->view('cuenta/iniciar_sesion_2', $data);
                    return;
                }
                // Verificar si hay sucursal asignada
                $sucursal_asignada_row = $this->colaboradores_sucursales_model->get_colaborador_sucursal_por_id($data_usuario->id)->row();
                $sucursal = $sucursal_asignada_row ? $sucursal_asignada_row->sucursal_id : NULL;
                $this->_preparar_datos_sesion($data_usuario->correo, $data_usuario->nombre_completo, $data_usuario->rol_id, $data_usuario->id, $data_usuario->nombre_imagen_avatar, $sucursal, $token_web);
                redirect('inicio');
            }
        }
        $data['mensaje_error'] = 'El usuario y/o contraseña ingresados son incorrectos';
        $this->load->view('cuenta/iniciar_sesion_2', $data);
    }

    /**
     * Redirección de prueba para autorizar sesión.
     *
     * @param string $correo Correo de prueba
     * @param string $token Token de prueba
     */
    public function redirect_test($correo = "lalogqs@gmail.com", $token = "4b187a5d4a1474d06d5247c8ada4a65dddcb99c0")
    {
        redirect(site_url("cuenta/autorizar_sesion/" . $correo . "/" . $token));
    }

    /**
     * Autoriza la sesión a partir de correo y token.
     *
     * Si se envían datos por POST, los usa; de lo contrario, utiliza los parámetros de la URL.
     *
     * @param string $correo Correo codificado en base64
     * @param string $token  Token enviado
     */
    public function autorizar_sesion($correo, $token)
    {
        // Cargar modelos necesarios
        $this->load->model("usuarios_model");
        $this->load->model("colaboradores_sucursales_model");

        if ($this->input->post()) {
            $correo = $this->input->post("correo");
            $token = $this->input->post("token");
        }

        $usuario_row = $this->usuarios_model->get_usuario_por_correo_y_token(base64_decode($correo), $token)->row();

        if (!$usuario_row) {
            $data['mensaje_error'] = '¡Oops!, Al parecer hubo un error al intentar iniciar sesión, por favor intentelo mas tarde.';
            $this->load->view('cuenta/iniciar_sesion_2', $data);
            return;
        }

        $token_web = $this->_actualizar_token($usuario_row->id);

        if (!$token_web) {
            $data['mensaje_error'] = '¡Oops!, Al parecer hubo un error al actualizar el token, por favor intentelo mas tarde.';
            $this->load->view('cuenta/iniciar_sesion_2', $data);
            return;
        }

        $this->_redirigir_segun_rol($usuario_row, $token_web, 'usuario/inicio');
    }

    /**
     * Autoriza sesión para compras.
     *
     * Funcionalidad similar a autorizar_sesion pero redirige a la sección de compras para usuarios de rol 1 y 3.
     *
     * @param string $correo Correo codificado en base64
     * @param string $token  Token enviado
     */
    public function autorizar_sesion_compras($correo, $token)
    {
        $this->load->model("usuarios_model");
        $this->load->model("colaboradores_sucursales_model");

        if ($this->input->post()) {
            $correo = $this->input->post("correo");
            $token = $this->input->post("token");
        }

        $usuario_row = $this->usuarios_model->get_usuario_por_correo_y_token(base64_decode($correo), $token)->row();

        if (!$usuario_row) {
            $data['mensaje_error'] = '¡Oops!, Al parecer hubo un error al intentar iniciar sesión, por favor intentelo mas tarde.';
            $this->load->view('cuenta/iniciar_sesion_2', $data);
            return;
        }

        $token_web = $this->_actualizar_token($usuario_row->id);

        if (!$token_web) {
            $data['mensaje_error'] = '¡Oops!, Al parecer hubo un error al actualizar el token, por favor intentelo mas tarde.';
            $this->load->view('cuenta/iniciar_sesion_2', $data);
            return;
        }

        // En este caso, para roles 1 y 3 se redirige a 'usuario/shop'
        if ($usuario_row->rol_id == 1 || $usuario_row->rol_id == 3) {
            $this->_preparar_datos_sesion($usuario_row->correo, $usuario_row->nombre_completo, $usuario_row->rol_id, $usuario_row->id, $usuario_row->nombre_imagen_avatar, NULL, $token_web);
            redirect('usuario/shop');
        } elseif (in_array($usuario_row->rol_id, array('2', '4', '5'), true)) {
            $sucursal_asignada_row = $this->colaboradores_sucursales_model->get_colaborador_sucursal_por_id($usuario_row->id)->row();
            $sucursal = $sucursal_asignada_row ? $sucursal_asignada_row->sucursal_id : NULL;
            $this->_preparar_datos_sesion($usuario_row->correo, $usuario_row->nombre_completo, $usuario_row->rol_id, $usuario_row->id, $usuario_row->nombre_imagen_avatar, $sucursal, $token_web);
            redirect('inicio');
        } else {
            $data['mensaje_error'] = '¡Oops!, Al parecer hubo un error al intentar iniciar sesión, por favor intentelo mas tarde.';
            $this->load->view('cuenta/iniciar_sesion_2', $data);
        }
    }

    // -------------------------------------------------------------------------
    // Registro de Usuarios
    // -------------------------------------------------------------------------
    public function registrar()
    {
        $data['pagina_menu_registrar'] = true;
        $data['pagina_titulo'] = 'registrar';
        $data['controlador'] = 'cuenta/registrar';
        $data['regresar_a'] = 'inicio';
        $controlador_js = "cuenta/registrar";

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info']  = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $data['styles']  = array();
        $data['scripts'] = array(
            array('es_rel' => true, 'src' => $controlador_js . '.js'),
        );

        // Validaciones del formulario
        $this->form_validation->set_rules('no_telefono', 'Teléfono', 'trim|required|numeric|min_length[10]|max_length[10]|is_unique[usuarios.no_telefono]');
        $this->form_validation->set_rules('correo', 'Email', 'required|valid_email|max_length[100]|is_unique[usuarios.correo]');
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'required');
        $this->form_validation->set_rules('nombre_completo', 'Nombre', 'required|max_length[50]');
        $this->form_validation->set_rules('apellido_paterno', 'Apellido Paterno', 'required|max_length[50]');
        $this->form_validation->set_rules('apellido_materno', 'Apellido Materno', 'max_length[50]');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required');
        $this->form_validation->set_rules('genero', 'Género', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('cuenta/registrar');
            return;
        }

        // Validar reCAPTCHA si está habilitado
        if ($this->config->item('recaptcha_validar', 'b3studio')) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL            => $this->config->item('recaptcha_api_url', 'b3studio'),
                CURLOPT_POST           => 1,
                CURLOPT_POSTFIELDS     => http_build_query(array(
                    'secret'   => $this->config->item('recaptcha_secret', 'b3studio'),
                    'response' => $this->input->post('g-recaptcha-response'),
                )),
            ));
            $respuesta_recatpcha = curl_exec($curl);
            log_message('debug', print_r($respuesta_recatpcha, true));
            if (curl_error($curl)) {
                log_message('debug', print_r(curl_error($curl), true));
            }
            log_message('debug', print_r(curl_getinfo($curl), true));
            curl_close($curl);
        }

        // Preparar datos para insertar en la BD
        $data_insert = array(
            'no_telefono'     => $this->input->post('no_telefono'),
            'correo'          => $this->input->post('correo'),
            'contrasena_hash' => password_hash($this->input->post('contrasena'), PASSWORD_DEFAULT),
            'nombre_completo' => $this->input->post('nombre_completo'),
            'apellido_paterno' => $this->input->post('apellido_paterno'),
            'apellido_materno' => $this->input->post('apellido_materno'),
            'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_nacimiento')))),
            'genero'          => $this->input->post('genero'),
            'fecha_registro'  => date('Y-m-d H:i:s'),
            'rol_id'          => $this->config->item('id_rol_cliente', 'b3studio'),
        );

        if ($this->db->insert('usuarios', $data_insert)) {
            $query = $this->db->query(
                'SELECT * FROM `usuarios` WHERE BINARY `correo` = ' .
                    $this->db->escape($data_insert['correo'])
            );
            $data_usuario = $query->row();
            $this->_preparar_datos_sesion(
                $data_usuario->correo,
                $data_usuario->nombre_completo,
                $data_usuario->rol_id,
                $data_usuario->id,
                $data_usuario->nombre_imagen_avatar,
                NULL,
                ''
            );
            redirect('usuario/shop/seleccionar_metodo/14');
            return;
        }
        $this->load->view('cuenta/registrar', array('mensaje_error' => 'Ha ocurrido un error al intentar realizar el registro, por favor inténtelo más tarde'));
    }

    // -------------------------------------------------------------------------
    // Integración con Facebook
    // -------------------------------------------------------------------------
    public function iniciar_sesion_facebook()
    {
        if ($this->facebook->is_authenticated()) {
            $user = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,locale,cover,picture');
            if (!isset($user['error'])) {
                $usuario_facebook = $this->db->get_where('usuarios', array('facebook_id' => $user['id']));

                if ($usuario_facebook->num_rows() > 0) {
                    $data = array(
                        'nombre_completo'  => $user['first_name'],
                        'apellido_paterno' => $user['last_name'],
                        'correo'           => $user['email'],
                    );
                    $this->db->where('facebook_id', $user['id']);
                    if (!$this->db->update('usuarios', $data)) {
                        redirect('cuenta/cerrar_sesion');
                        return;
                    }
                } else {
                    $this->load->helper('string');
                    $data = array(
                        'nombre_completo'  => $user['first_name'],
                        'apellido_paterno' => $user['last_name'],
                        'correo'           => $user['email'],
                        'facebook_id'      => $user['id'],
                        'rol_id'           => $this->config->item('id_rol_cliente', 'b3studio'),
                    );
                    if (!$this->db->insert('usuarios', $data)) {
                        redirect('cuenta/cerrar_sesion');
                        return;
                    }
                }

                $usuario_facebook = $this->db->get_where('usuarios', array('facebook_id' => $user['id']))->row();
                $this->_preparar_datos_sesion(
                    $usuario_facebook->correo,
                    $usuario_facebook->nombre_completo,
                    $usuario_facebook->rol_id,
                    $usuario_facebook->id,
                    $usuario_facebook->nombre_imagen_avatar,
                    NULL,
                    ''
                );
                redirect('usuarios/index');
                return;
            }
        }
        redirect('cuenta/cerrar_sesion');
    }

    // -------------------------------------------------------------------------
    // Cierre de Sesión
    // -------------------------------------------------------------------------
    public function cerrar_sesion()
    {
        $this->session->sess_destroy();
        redirect('cuenta/iniciar_sesion');
    }

    // -------------------------------------------------------------------------
    // Recuperación de Contraseña
    // -------------------------------------------------------------------------
    public function olvido_contrasena()
    {
        // Redirigir a soporte vía WhatsApp
        redirect('https://api.whatsapp.com/send?phone=5212292653397&text=Hola%20Soporte%20Beatness,%20quiero%20solicitar%20restablecer%20la%20contraseña%20de%20mi%20cuenta.');

        $this->form_validation->set_rules('correo', 'Correo', 'required');
        if ($this->form_validation->run() == false) {
            $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
            $this->load->view('cuenta/olvido_contrasena', $data);
            return;
        }

        $this->load->model('usuarios_model');
        $usuario_a_recuperar_contrasena = $this->usuarios_model->obtener_usuario_por_correo($this->input->post('correo'))->row();
        if (!$usuario_a_recuperar_contrasena) {
            $this->load->view('cuenta/olvido_contrasena', array(
                'mensaje_error' => 'Este correo electrónico no se encuentra asociado a ninguna cuenta de ' . branding() . ', por favor corrobore sus datos.',
            ));
            return;
        }

        $this->load->library('email');
        $this->load->helper('string');
        $codigo = random_string('alnum', 50);

        if ($usuario_a_recuperar_contrasena->codigo_recuperar_contrasena == "") {
            if (!$this->usuarios_model->editar($usuario_a_recuperar_contrasena->id, array('codigo_recuperar_contrasena' => $codigo))) {
                $this->load->view('cuenta/olvido_contrasena', array(
                    'mensaje_error' => 'No se ha podido procesar la solicitud para recuperar contraseña, por favor intentelo mas tarde. (01)',
                ));
                return;
            }
        } else {
            $codigo = $usuario_a_recuperar_contrasena->codigo_recuperar_contrasena;
        }

        if (!$codigo) {
            $this->load->view('cuenta/olvido_contrasena', array(
                'mensaje_error' => 'No se ha podido procesar la solicitud para recuperar contraseña, por favor intentelo mas tarde. (02)',
            ));
            return;
        }

        $mensaje = $this->load->view('cuenta/templates/olvido_contrasena.tpl.php', array(
            'identidad' => $usuario_a_recuperar_contrasena->nombre_completo,
            'codigo'    => $codigo
        ), true);

        $this->email->initialize($this->config->item('email_config', 'b3studio'));
        $this->email->clear();
        $this->email->from($this->config->item('email_admin', 'b3studio'), $this->config->item('email_sitio_identificador', 'b3studio'));
        $this->email->to($usuario_a_recuperar_contrasena->correo);
        $this->email->subject('Restablece tu contraseña [' . date('d/m/Y - H:i') . ']');
        $this->email->message($mensaje);

        if (!$this->email->send()) {
            $this->load->view('cuenta/olvido_contrasena', array(
                'mensaje_error' => 'No se ha podido procesar la solicitud para recuperar contraseña, por favor intentelo mas tarde. (03)',
            ));
            return;
        }

        $this->load->view('cuenta/olvido_contrasena', array(
            'mensaje_exito' => 'Su solicitud de recuperación de contraseña ha sido enviada con éxito, por favor verifique su correo electrónico asociado.<br><br><small>(IMPORTANTE: El correo electrónico puede tardar un par de minutos en llegar a su bandeja de entrada.)</small>',
        ));
    }

    /**
     * Resetea la contraseña del usuario.
     *
     * @param string|null $codigo Código de recuperación
     */
    public function resetear_contrasena($codigo = null)
    {
        if (!$codigo) {
            show_404();
        }

        $this->load->model('usuarios_model');
        $usuario_a_recuperar_contrasena = $this->usuarios_model->obtener_usuario_por_codigo($codigo)->row();
        if (!$usuario_a_recuperar_contrasena) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'El código de recuperación ha caducado, por favor espere el último correo que solicito o verifique si ya realizó el cambio de contraseña.');
            redirect('cuenta/olvido_contrasena');
            return;
        }

        $this->form_validation->set_rules('contrasena_nueva', 'Nueva contraseña', 'required|matches[confirmar_contrasena_nueva]');
        $this->form_validation->set_rules('confirmar_contrasena_nueva', 'Confirmar nueva contraseña', 'required');

        if ($this->form_validation->run() == false) {
            $data['codigo'] = $codigo;
            $data['usuario_id'] = $usuario_a_recuperar_contrasena->id;
            $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
            $this->load->view('cuenta/resetear_contrasena', $data);
            return;
        }

        $actualizado = $this->usuarios_model->editar(
            $this->input->post('usuario_id'),
            array(
                'contrasena_hash'             => password_hash($this->input->post('contrasena_nueva'), PASSWORD_DEFAULT),
                'codigo_recuperar_contrasena'  => NULL,
                'no_recuperaciones_contrasena' => $usuario_a_recuperar_contrasena->no_recuperaciones_contrasena + 1
            )
        );

        if ($actualizado) {
            $this->session->set_flashdata('MENSAJE_EXITO', 'Contraseña ha sido modificada con éxito.');
            redirect('cuenta/iniciar_sesion');
        } else {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se ha podido procesar la solicitud para recuperar contraseña, por favor intentelo mas tarde. (04)');
            redirect('cuenta/iniciar_sesion/' . $codigo);
        }
    }

    // -------------------------------------------------------------------------
    // Función Privada para Preparar la Sesión
    // -------------------------------------------------------------------------
    private function _preparar_datos_sesion($correo, $nombre_completo, $rol_id, $id, $nombre_imagen_avatar, $sucursal_asignada, $token_web)
    {
        $sesion_data = array(
            'correo'                => $correo,
            'nombre_completo'       => $nombre_completo,
            'rol_id'                => $rol_id,
            'id'                    => $id,
            'nombre_imagen_avatar'  => $nombre_imagen_avatar,
            'sucursal_asignada'     => $sucursal_asignada,
            'token_web'             => $token_web,
            'sitio'                 => $this->config->item('sistema_id', 'b3studio'),
            'en_sesion'             => true,
        );

        $this->session->set_userdata($sesion_data);
    }

    /**
     * Genera un nuevo token, lo actualiza en la BD y lo retorna.
     *
     * @param int $usuario_id
     * @return string|false
     */
    private function _actualizar_token($usuario_id)
    {
        $token_web = bin2hex(openssl_random_pseudo_bytes(20));
        if ($this->usuarios_model->editar($usuario_id, array('token_web' => $token_web))) {
            return $token_web;
        }
        return false;
    }

    /**
     * Redirige según el rol del usuario.
     *
     * Para roles de tipo cliente/instructor/corporativo y administradores se separa la lógica.
     *
     * @param object $usuario    Objeto del usuario obtenido de la BD.
     * @param string $token_web  Token generado y actualizado.
     * @param string $destino_por_defecto Redirección por defecto para roles no diferenciados.
     */
    private function _redirigir_segun_rol($usuario, $token_web, $destino_por_defecto = 'usuario/inicio')
    {
        // Rol 3: Instructor
        if ($usuario->rol_id == 3) {
            $this->_preparar_datos_sesion(
                $usuario->correo,
                $usuario->nombre_completo,
                $usuario->rol_id,
                $usuario->id,
                $usuario->nombre_imagen_avatar,
                NULL,
                $token_web
            );
            redirect('instructor/inicio');
            return;
        }
        // Roles de tipo administrador (2,4,5,7)
        elseif (in_array($usuario->rol_id, array('2', '4', '5', '7'), true)) {
            $sucursal_asignada_row = $this->colaboradores_sucursales_model->get_colaborador_sucursal_por_id($usuario->id)->row();
            $sucursal = $sucursal_asignada_row ? $sucursal_asignada_row->sucursal_id : NULL;
            $this->_preparar_datos_sesion(
                $usuario->correo,
                $usuario->nombre_completo,
                $usuario->rol_id,
                $usuario->id,
                $usuario->nombre_imagen_avatar,
                $sucursal,
                $token_web
            );
            redirect('inicio');
            return;
        }
        // Para el resto (cliente, corporativo, etc.)
        else {
            $this->_preparar_datos_sesion(
                $usuario->correo,
                $usuario->nombre_completo,
                $usuario->rol_id,
                $usuario->id,
                $usuario->nombre_imagen_avatar,
                NULL,
                $token_web
            );
            redirect($destino_por_defecto);
        }
    }
}
