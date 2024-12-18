<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('sucursales_model');
    }

    // ============================================================
    // =============== CATEGORÍA: FUNCIONES PRINCIPALES ===========
    // ============================================================

    /** 
     * Index (Vista principal)
     * Muestra la lista principal de clientes activos.
     * Prioridad: Alta.
     */
    public function index()
    {
        $data['menu_clientes_activo'] = true;
        $data['pagina_titulo'] = 'Lista de clientes';

        $data['controlador'] = 'clientes';
        $data['regresar_a'] = 'inicio';
        $controlador_js = "clientes/index";

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('clientes/index', $data);
    }

    /**
     * crear
     * Función para mostrar el formulario y procesar la creación de un nuevo cliente.
     * Prioridad: Alta.
     */
    public function crear()
    {
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // MODIFICACIÓN: Se agrega 'valid_email' y 'numeric' y callback para vigencia estudiante.
        // Se mantiene is_unique para correo.
        $this->form_validation->set_rules('contrasena', 'contraseña', 'required');
        $this->form_validation->set_rules('correo', 'correo electrónico', 'required|valid_email|is_unique[usuarios.correo]');
        $this->form_validation->set_rules('nombre_completo', 'nombre completo', 'required');
        $this->form_validation->set_rules('apellido_paterno', 'apellido paterno', 'required');
        $this->form_validation->set_rules('no_telefono', 'número de teléfono', 'numeric'); // MODIFICACIÓN: agregado numeric
        $this->form_validation->set_rules('es_estudiante', '¿Es estudiante?', 'required');
        // MODIFICACIÓN: Se remueve el required directo y se valida con callback
        $this->form_validation->set_rules('es_estudiante_vigencia', 'Vigencia de estudiante', 'callback_check_es_estudiante_vigencia');
        $this->form_validation->set_rules('es_empresarial', '¿Pertenece a una empresa?', 'required');
        $this->form_validation->set_rules('sucursal_id', 'Sucursal favorita', 'required');

        $data['controlador'] = 'clientes/crear';
        $data['menu_clientes_activo'] = true;
        $data['pagina_titulo'] = 'Nuevo cliente';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => true, 'src' => 'clientes/crear.js'),
        );

        $sucursal_list = $this->sucursales_model->get_sucursales_para_select_de_ventas()->result();
        $data['sucursal_list'] = $sucursal_list;

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('clientes/crear', $data);
        } else {

            if ($this->session->userdata('sucursal_asignada') == 5) {
                $dominio = 'beatness';
            } else {
                $dominio = 'beatness';
            }

            if (isset($_FILES) && $_FILES['nombre_imagen_avatar']['error'] == '0') {

                $config['upload_path']   =  './subidas/perfil/';
                $config['allowed_types'] = 'jpg';
                $config['max_size'] = '600';
                $config['overwrite']     = true;
                $config['encrypt_name']  = true;
                $config['remove_spaces'] = true;

                if (!is_dir($config['upload_path'])) {
                    $this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['controlador']));
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('nombre_imagen_avatar')) {
                    $this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors(), site_url($data['controlador']));
                } else {
                    $data_imagen = $this->upload->data();
                    $nombre_foto = $data_imagen['file_name'];
                }
            } else {
                $nombre_foto = "default.jpg";
            }

            $nombre_archivo = time() . '.jpg';

            $data = array(
                'contrasena_hash' => password_hash($this->input->post('contrasena'), PASSWORD_DEFAULT),
                'correo' => $this->input->post('correo'),
                'rol_id' => 1,
                'sucursal_id' => $this->input->post('sucursal_id'),
                'nombre_completo' => $this->input->post('nombre_completo'),
                'apellido_paterno' => $this->input->post('apellido_paterno'),
                'apellido_materno' => $this->input->post('apellido_materno'),
                'no_telefono' => $this->input->post('no_telefono'),
                'es_estudiante' => $this->input->post('es_estudiante'),
                'es_estudiante_vigencia' => $this->input->post('es_estudiante_vigencia'),
                'es_empresarial' => $this->input->post('es_empresarial'),
                'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_nacimiento')))),
                'rfc' => $this->input->post('rfc'),
                'genero' => $this->input->post('genero'),
                'calle' => $this->input->post('calle'),
                'numero' => $this->input->post('numero'),
                'colonia' => $this->input->post('colonia'),
                'ciudad' => $this->input->post('ciudad'),
                'estado' => $this->input->post('estado'),
                'pais' => $this->input->post('pais'),
                'nombre_imagen_avatar' => $nombre_foto,
                'dominio' => $dominio
            );

            if (!$data) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ha ocurrido un error, por favor inténtelo mas tarde.');
                redirect('clientes/crear');
            }

            if ($this->usuarios_model->crear($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'El cliente se ha creado correctamente.');
                redirect('clientes/index');
            }

            $this->construir_private_site_ui('clientes/crear', $data);
        }
    }

    /**
     * editar
     * Función para mostrar el formulario y procesar la edición de un cliente existente.
     * Prioridad: Alta.
     */
    public function editar($id = null)
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // MODIFICACIÓN: Agregar valid_email y callback unique_email_edit
        $this->form_validation->set_rules('correo', 'correo electrónico', 'required|valid_email|callback_unique_email_edit[' . $id . ']');
        $this->form_validation->set_rules('nombre_completo', 'nombre completo', 'required');
        $this->form_validation->set_rules('apellido_paterno', 'apellido paterno', 'required');
        $this->form_validation->set_rules('no_telefono', 'número de teléfono', 'numeric'); // MODIFICACIÓN: agregado numeric
        $this->form_validation->set_rules('es_estudiante', '¿Es estudiante?', 'required');
        // MODIFICACIÓN: Uso del mismo callback para vigencia estudiante
        $this->form_validation->set_rules('es_estudiante_vigencia', 'Vigencia de estudiante', 'callback_check_es_estudiante_vigencia');
        $this->form_validation->set_rules('es_empresarial', '¿Pertenece a una empresa?', 'required');
        $this->form_validation->set_rules('sucursal_id', 'Sucursal favorita', 'required');

        $data['menu_clientes_activo_activo'] = true;
        $data['pagina_titulo'] = 'Editar cliente';

        $data['controlador'] = 'clientes/editar/' . $id;
        $data['regresar_a'] = 'clientes';
        $controlador_js = "clientes/editar";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => true, 'src' => 'clientes/editar.js')
        );

        $cliente_a_editar = $this->usuarios_model->obtener_usuario_por_id($id)->row();

        if (!$cliente_a_editar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'El cliente que intenta editar no existe.');
            redirect('/clientes/index');
        }
        $data['cliente_a_editar'] = $cliente_a_editar;

        $sucursal_list = $this->sucursales_model->get_sucursales_para_select_de_ventas()->result();
        $data['sucursal_list'] = $sucursal_list;

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('clientes/editar', $data);
        } else {
            if (isset($_FILES) && $_FILES['nombre_imagen_avatar']['error'] == '0') {
                $config['upload_path']   = './subidas/perfil/';
                $config['allowed_types'] = 'jpg';
                $config['max_size'] = '600';
                $config['overwrite']     = true;
                $config['encrypt_name']  = true;
                $config['remove_spaces'] = true;

                if (!is_dir($config['upload_path'])) {
                    $this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['controlador']));
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('nombre_imagen_avatar')) {
                    $this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors(), site_url($data['controlador']));
                } else {
                    // Borrar imagen anterior sólo si se sube una nueva y no es la default
                    if ($cliente_a_editar->nombre_imagen_avatar && $cliente_a_editar->nombre_imagen_avatar != "default.jpg") {
                        $url_imagen_a_borrar = "subidas/perfil/" . $cliente_a_editar->nombre_imagen_avatar;
                        @unlink($url_imagen_a_borrar); // MODIFICACIÓN: Eliminar imagen anterior sólo aquí
                    }

                    $data_imagen = $this->upload->data();
                    $nombre_foto = $data_imagen['file_name'];
                }
            } else {
                $nombre_foto = $cliente_a_editar->nombre_imagen_avatar;
            }

            $nombre_archivo = time() . '.jpg';

            $data = array(
                'correo' => $this->input->post('correo'),
                'rol_id' => 1,
                'sucursal_id' => $this->input->post('sucursal_id'),
                'nombre_completo' => $this->input->post('nombre_completo'),
                'apellido_paterno' => $this->input->post('apellido_paterno'),
                'apellido_materno' => $this->input->post('apellido_materno'),
                'no_telefono' => $this->input->post('no_telefono'),
                'es_estudiante' => $this->input->post('es_estudiante'),
                'es_estudiante_vigencia' => $this->input->post('es_estudiante_vigencia'),
                'es_empresarial' => $this->input->post('es_empresarial'),
                'nombre_imagen_avatar' => $nombre_foto,
                'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_nacimiento')))),
                'rfc' => $this->input->post('rfc'),
                'genero' => $this->input->post('genero'),
                'calle' => $this->input->post('calle'),
                'numero' => $this->input->post('numero'),
                'colonia' => $this->input->post('colonia'),
                'ciudad' => $this->input->post('ciudad'),
                'estado' => $this->input->post('estado'),
                'pais' => $this->input->post('pais'),
                'estatus' => $this->input->post('estatus')
            );

            if ($this->usuarios_model->editar($id, $data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'El cliente se ha editado correctamente.');
                redirect('/clientes/index');
            }

            $this->construir_private_site_ui('clientes/editar', $data);
        }
    }

    // ============================================================
    // ========== CATEGORÍA: FUNCIONES DE DATOS PARA TABLAS =======
    // ============================================================

    /**
     * get_lista_de_clientes
     * Función para poblar el DataTable de clientes activos.
     * Prioridad: Alta en relación con el Index.
     */
    public function get_lista_de_clientes()
    {
        $usuarios_list = $this->usuarios_model->get_lista_de_clientes_activos_con_limitacion_de_datos()->result();
        $result = array();

        foreach ($usuarios_list as $usuario_row) {
            if ($usuario_row->es_estudiante == 'si') {
                $vigencia = (!empty($usuario_row->es_estudiante_vigencia) ? date('d/m/Y', strtotime($usuario_row->es_estudiante_vigencia)) : '');
            } else {
                $vigencia = '-';
            }

            $menu = '
                    <a href="' . site_url("clientes/editar/") . $usuario_row->id . '">Editar</a>    
                    |
                    <a href="' . site_url("sistema/change_password/") . $usuario_row->id . '">Cambiar contraseña</a>
                    |
                    <a href="#" onclick="suspender(' . $usuario_row->id . ');return false;">Suspender</a>
                ';

            $result[] = array(
                "opciones" => $menu,
                "id" => !empty($usuario_row->id) ? $usuario_row->id : null,
                "nombre_completo" => !empty($usuario_row->nombre_completo) ? $usuario_row->nombre_completo : null,
                "correo" => !empty($usuario_row->correo) ? $usuario_row->correo : null,
                "no_telefono" => !empty($usuario_row->no_telefono) ? $usuario_row->no_telefono : null,
                "sucursal_id" => !empty($usuario_row->nombre_sucursal) ? strtoupper($usuario_row->nombre_sucursal) : null,
                "fecha_registro" => !empty($usuario_row->fecha_registro) ? $usuario_row->fecha_registro : null,
                "es_estudiante" => !empty($usuario_row->es_estudiante) ? ucfirst($usuario_row->es_estudiante) : null,
                "es_estudiante_vigencia" => $vigencia,
                "es_empresarial" => !empty($usuario_row->es_empresarial) ? ucfirst($usuario_row->es_empresarial) : null,
                "dominio" => !empty($usuario_row->dominio) ? ucfirst($usuario_row->dominio) : null,
                "estatus" => !empty($usuario_row->estatus) ? ucfirst($usuario_row->estatus) : null,
            );
        }

        echo json_encode(array("data" => $result));
    }

    /**
     * get_lista_de_clientes_suspendidos
     * Función para poblar el DataTable de clientes suspendidos.
     * Prioridad: Secundaria.
     */
    public function get_lista_de_clientes_suspendidos()
    {
        $usuarios_list = $this->usuarios_model->get_lista_de_clientes_suspendidos_con_limitacion_de_datos()->result();
        $result = array();

        foreach ($usuarios_list as $usuario_row) {
            $menu = '
                    <a href="' . site_url("clientes/editar/") . $usuario_row->id . '">Editar</a>    
                    |
                    <a href="' . site_url("sistema/change_password/") . $usuario_row->id . '">Cambiar contraseña</a>
                    |
                    <a href="#" onclick="activar(' . $usuario_row->id . ');return false;">Activar</a>
                ';

            $result[] = array(
                "id" => !empty($usuario_row->id) ? $usuario_row->id : null,
                "nombre_completo" => !empty($usuario_row->nombre_completo) ? $usuario_row->nombre_completo : null,
                "correo" => !empty($usuario_row->correo) ? $usuario_row->correo : null,
                "no_telefono" => !empty($usuario_row->no_telefono) ? $usuario_row->no_telefono : null,
                "es_estudiante" => !empty($usuario_row->es_estudiante) ? ucfirst($usuario_row->es_estudiante) : null,
                "dominio" => !empty($usuario_row->dominio) ? ucfirst($usuario_row->dominio) : null,
                "estatus" => !empty($usuario_row->estatus) ? ucfirst($usuario_row->estatus) : null,
                "fecha_registro" => !empty($usuario_row->fecha_registro) ? $usuario_row->fecha_registro : null,
                "opciones" => $menu,
            );
        }

        echo json_encode(array("data" => $result));
    }

    // ============================================================
    // ======== CATEGORÍA: FUNCIONES DE ESTATUS Y REPORTES ========
    // ============================================================

    /**
     * suspendidos
     * Vista principal de clientes suspendidos.
     */
    public function suspendidos()
    {
        $data['menu_clientes_activo'] = true;
        $data['pagina_titulo'] = 'Lista de clientes suspendidos';

        $data['controlador'] = 'clientes/suspendidos';
        $data['regresar_a'] = 'clientes';
        $controlador_js = "clientes/suspendidos";

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('clientes/suspendidos', $data);
    }

    /**
     * reporte_activos
     * Genera la vista con reporte de clientes activos.
     */
    public function reporte_activos()
    {
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => 'clientes/reporte_activos.js'),
        );

        $data['menu_clientes_activo'] = true;
        $data['pagina_titulo'] = 'Clientes';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $clientes_list = $this->usuarios_model->obtener_reporte_de_clientes_activos()->result();
        $data["clientes_list"] = $clientes_list;

        $this->construir_private_site_ui('clientes/reporte_activos', $data);
    }

    // ============================================================
    // ========= CATEGORÍA: FUNCIONES UTILITARIAS Y AJAX ==========
    // ============================================================

    /**
     * suspender
     * Cambia el estatus de un cliente a suspendido.
     */
    public function suspender($id = null)
    {
        $data = array('estatus' => 'suspendido',);

        if (!$this->usuarios_model->editar_cliente($id, $data)) {
            echo json_encode(array("status" => false));
        } else {
            echo json_encode(array("status" => true));
        }
    }

    /**
     * activar
     * Cambia el estatus de un cliente a activo.
     */
    public function activar($id = null)
    {
        $data = array('estatus' => 'activo',);

        if (!$this->usuarios_model->editar_cliente($id, $data)) {
            echo json_encode(array("status" => false));
        } else {
            echo json_encode(array("status" => true));
        }
    }

    /**
     * guardar_foto
     * Guarda una foto base64 decodificada en el servidor.
     */
    public function guardar_foto()
    {
        $imagenData = $this->input->post('imagen_data');
        $imagen_decodificada = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagenData));
        $nombre_archivo = time() . '.jpg';
        file_put_contents('./subidas/perfil/' .  $nombre_archivo,  $imagen_decodificada);
    }

    /**
     * actualizar
     * Actualiza un dato específico de un usuario vía AJAX.
     */
    public function actualizar()
    {
        $identificador = $this->input->post('identificador');
        $columna = $this->input->post('columna');
        $nuevoValor = $this->input->post('nuevoValor');

        $data_1 = array($columna => $nuevoValor,);
        $this->usuarios_model->actualizar_usuario_por_identificador($identificador, $data_1);
        echo json_encode(array('status' => 'success', 'message' => 'Dato actualizado'));
    }

    /**
     * obtener_opciones_select_sucursal
     * Retorna en JSON las opciones de sucursales.
     */
    public function obtener_opciones_select_sucursal()
    {
        $sucursales = $this->sucursales_model->get_sucursales_para_select_de_ventas();
        $data = [];
        foreach ($sucursales->result() as $sucursal) {
            $data[] = array(
                'nombre' => $sucursal->descripcion,
                'valor' => $sucursal->id
            );
        }

        echo json_encode($data);
        exit();
    }

    // ============================================================
    // ========== CATEGORÍA: FUNCIONES DE DEPURACIÓN Y CB =========
    // ============================================================

    /**
     * debug_to_console
     * Función de depuración.
     */
    function debug_to_console($data = null)
    {
        $output = $data;
        if (is_array($output)) {
            $output = implode(',', $output);
        }
        echo "<script>console.log( 'Que vas a probar: " . $output . "' );</script>";
    }

    // ============================================================
    // ================== CALLBACKS DE VALIDACIÓN =================
    // ============================================================

    // MODIFICACIÓN: Callback para verificar vigencia de estudiante
    // Solo es requerida si es_estudiante = 'si'
    public function check_es_estudiante_vigencia($str)
    {
        if ($this->input->post('es_estudiante') == 'si' && empty($str)) {
            $this->form_validation->set_message('check_es_estudiante_vigencia', 'La {field} es obligatoria cuando es estudiante.');
            return false;
        }
        return true;
    }

    // MODIFICACIÓN: Callback para verificar unicidad del correo en editar
    // Excluye al usuario actual para evitar conflicto
    public function unique_email_edit($email, $id)
    {
        // Verifica si el correo ya existe en otro usuario que no sea el actual
        $usuario = $this->usuarios_model->obtener_usuario_por_correo($email)->row();
        if ($usuario && $usuario->id != $id) {
            $this->form_validation->set_message('unique_email_edit', 'El {field} ya está registrado en otro usuario.');
            return false;
        }
        return true;
    }
}
