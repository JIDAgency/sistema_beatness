<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('roles_model');
        $this->load->model('sucursales_model');
        $this->load->model('colaboradores_sucursales_model');
    }

    public function index()
    {

        if (!es_superadministrador()) {
            // Mostrar vista de "no permitido"
        }

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => 'usuarios/index.js'),
        );

        $data['menu_usuarios_activo'] = true;
        $data['pagina_titulo'] = 'Usuarios';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $this->construir_private_site_ui('usuarios/index', $data);

    }

    public function load_lista_de_todos_los_colaboradores_para_datatable()
    {
        $usuarios_list = $this->usuarios_model->get_lista_de_todos_los_colaboradores_limitada()->result();

        $result = array();
        
        foreach ($usuarios_list as $usuario_row) {
            
            $menu = '<a href="'.site_url("usuarios/editar_usuario/").$usuario_row->listar_id.'">Editar</a>';

            $result[] = array(
				"listar_id" => $usuario_row->listar_id,
				"listar_nombre_completo" => $usuario_row->listar_nombre_completo,
				"listar_correo" => $usuario_row->listar_correo,
				"listar_no_telefono" => $usuario_row->listar_no_telefono,
				"listar_tipo" => $usuario_row->listar_tipo,
				"listar_locacion" => $usuario_row->listar_locacion,
				"listar_opciones" => $menu,
            );
            
        }

        echo json_encode(array("data" => $result));
    }

    public function crear_usuario()
    {
        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Establecer validaciones
        $this->form_validation->set_rules('contrasena', 'contraseña', 'required');
        $this->form_validation->set_rules('correo', 'correo electrónico', 'required|valid_email|is_unique_for_user_email[usuarios.correo]');
        $this->form_validation->set_rules('rol_id', 'rol', 'required');
        $this->form_validation->set_rules('nombre_completo', 'nombre completo', 'required');
        $this->form_validation->set_rules('apellido_paterno', 'apellido paterno', 'required');

        // Inicializar vista, scripts y catálogos
        $data['menu_usuarios_activo'] = true;
        $data['pagina_titulo'] = 'Nuevo usuario';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => true, 'src' => 'usuarios/crear.js'),

        );
        
        $roles_list = $this->roles_model->get_todos_los_roles_tipo_administrador()->result();
        $sucursales_list = $this->sucursales_model->get_sucursales_disponibles()->result();

        $data['roles'] = $roles_list;
        $data['sucursales'] = $sucursales_list;
        $data['controlador'] = 'usuarios/crear_usuario';

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('usuarios/crear_usuario', $data);
        } else {
            // Preparar datos para hacer el insert en la bd
            $rol_asignado = $this->input->post('rol_id');

            if (isset($_FILES) && $_FILES['nombre_imagen_avatar']['error'] == '0') {

				$config['upload_path']   =  './subidas/perfil/';
                $config['allowed_types'] = 'jpg';
                $config['max_width'] = 1200;
                $config['max_height'] = 1200;
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

            $data = array(
                'contrasena_hash' => password_hash($this->input->post('contrasena'), PASSWORD_DEFAULT),
                'correo' => $this->input->post('correo'),
                'rol_id' => $rol_asignado,
                'nombre_completo' => $this->input->post('nombre_completo'),
                'apellido_paterno' => $this->input->post('apellido_paterno'),
                'apellido_materno' => $this->input->post('apellido_materno'),
                'no_telefono' => $this->input->post('no_telefono'),
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
            );

            if ($this->usuarios_model->crear($data)) {

                if ($rol_asignado == 5) {

                    $data_colaborador_sucursal = array(
                        'colaborador_id' => $this->db->insert_id(),
                        'sucursal_id' => $this->input->post('sucursal_id'),
                    );
    
                    $this->colaboradores_sucursales_model->insert_colaborador_sucursal($data_colaborador_sucursal);
    
                }

                $this->session->set_flashdata('MENSAJE_EXITO', 'El usuario se ha creado correctamente.');
                redirect('usuarios/index');
            }

            $this->construir_private_site_ui('usuarios/crear_usuario', $data);
        }

    }

    public function editar_usuario($id = null)
    {
        
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Establecer validaciones
        $this->form_validation->set_rules('correo', 'correo electrónico', 'required');
        $this->form_validation->set_rules('rol_id', 'rol', 'required');
        $this->form_validation->set_rules('nombre_completo', 'nombre completo', 'required');
        $this->form_validation->set_rules('apellido_paterno', 'apellido paterno', 'required');

        // Inicializar vista, scripts y catálogos
        $data['controlador'] = 'usuarios/editar_usuario/'.$id;
        $data['menu_usuarios_activo'] = true;
        $data['pagina_titulo'] = 'Editar administrador';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => true, 'src' => 'usuarios/editar.js'),

        );


        // Verificar que el usuario a editar exista, obtener sus datos y pasarlos a la vista
        $usuario_a_editar = $this->usuarios_model->obtener_colaborador_por_id($id)->row();

        if (!$usuario_a_editar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'El usuario que intenta editar no existe.');
            redirect('/usuarios/index');
        }

        $data['usuario_a_editar'] = $usuario_a_editar;

        $roles_list = $this->roles_model->get_todos_los_roles_tipo_administrador()->result();
        $sucursales_list = $this->sucursales_model->get_sucursales_disponibles()->result();

        $data['roles'] = $roles_list;
        $data['sucursales'] = $sucursales_list;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('usuarios/editar_usuario', $data);

        } else {

            log_message('debug', print_r($this->input->post(), true));

            $rol_asignado = $this->input->post('rol_id');

            if (isset($_FILES) && $_FILES['nombre_imagen_avatar']['error'] == '0') {

				$config['upload_path']   =  './subidas/perfil/';
                $config['allowed_types'] = 'jpg';
                $config['max_width'] = 1200;
                $config['max_height'] = 1200;
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

					if ($usuario_a_editar->nombre_imagen_avatar AND $usuario_a_editar->nombre_imagen_avatar != "default.jpg") {
						$url_imagen_a_borrar = "subidas/perfil/".$usuario_a_editar->nombre_imagen_avatar;
						$imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
						unlink($imagen_a_borrar);
					}

					$data_imagen = $this->upload->data();
					$nombre_foto = $data_imagen['file_name'];

				}

			} else {
				$nombre_foto = $usuario_a_editar->nombre_imagen_avatar;
			}

            $data = array(
                'correo' => $this->input->post('correo'),
                'rol_id' => $rol_asignado,
                'nombre_completo' => $this->input->post('nombre_completo'),
                'apellido_paterno' => $this->input->post('apellido_paterno'),
                'apellido_materno' => $this->input->post('apellido_materno'),
                'no_telefono' => $this->input->post('no_telefono'),
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
            );

            if ($this->usuarios_model->editar($id, $data)) {

                $existe_relacion = $this->colaboradores_sucursales_model->get_colaborador_sucursal_por_id($id)->row();

                if ($rol_asignado == 5) {
    
                    $data_colaborador_sucursal = array(
                        'colaborador_id' => $id,
                        'sucursal_id' => $this->input->post('sucursal_id'),
                    );
    
    
                    if ($existe_relacion){
                        $this->colaboradores_sucursales_model->delete_colaborador_sucursal_por_id($id);
                    }
    
                    $this->colaboradores_sucursales_model->insert_colaborador_sucursal($data_colaborador_sucursal);
    
                } elseif ($rol_asignado != 5) {
    
                    if ($existe_relacion){
                        $this->colaboradores_sucursales_model->delete_colaborador_sucursal_por_id($id);
                    }
    
                }

                $this->session->set_flashdata('MENSAJE_EXITO', 'El usuario se ha editado correctamente.');
                log_message('debug', $this->db->last_query());
                log_message('debug', "sdsd");
                redirect('/usuarios/index');
            }

            $this->construir_private_site_ui('usuarios/editar_usuario', $data);

        }

    }

    public function perfil()
    {
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/css/pages/users.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/toastr.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/css/plugins/extensions/toastr.css'),
            array('es_rel' => false, 'href' => 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.min.css'),

        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/toastr.min.js'),
            array('es_rel' => false, 'src' => 'https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.min.js'),
            array('es_rel' => true, 'src' => 'usuarios/perfil.js'),

        );
        $data['pagina_titulo'] = 'Perfil de usuario';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $data['pill_seleccionado'] = 1;

        if (!empty($this->session->flashdata('PILL_SELECCIONADO'))) {
            $data['pill_seleccionado'] = $this->session->flashdata('PILL_SELECCIONADO');
        }

        if (!empty($this->session->flashdata('PILL_SELECCIONADO'))) {
            $data['pill_seleccionado'] = $this->session->flashdata('PILL_SELECCIONADO');
        }

        // Obtener usuario en sesión
        $usuario_en_sesion = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata['id'])->row();

        $data['usuario_en_sesion'] = $usuario_en_sesion;
        $data['validation_errors'] = $this->session->flashdata('VALIDATION_ERRORS');

        if (in_array($this->session->userdata['rol_id'], array('2', '4'))) {
            $this->construir_private_site_ui('usuarios/perfil', $data);
        }if (in_array($this->session->userdata['rol_id'], array('1', '3'))) {
            $this->construir_private_usuario_ui('usuarios/perfil', $data);
        }
    }

    public function actualizar_datos_personales() {
        $data['controlador'] = 'usuarios/perfil';

        $this->form_validation->set_rules('nombre_completo', 'nombre completo', 'required');
        $this->form_validation->set_rules('apellido_paterno', 'apellido paterno', 'required');

        $usuario_en_sesion = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata['id'])->row();

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('VALIDATION_ERRORS', validation_errors());
            redirect('usuarios/perfil');
        } else {

            if (isset($_FILES) && $_FILES['nombre_imagen_avatar']['error'] == '0') {

				$config['upload_path']   =  './subidas/perfil/';
                $config['allowed_types'] = 'jpg';
                $config['max_width'] = 1200;
                $config['max_height'] = 1200;
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

					if ($usuario_en_sesion->nombre_imagen_avatar AND $usuario_en_sesion->nombre_imagen_avatar != "default.jpg") {
						$url_imagen_a_borrar = "subidas/perfil/".$usuario_en_sesion->nombre_imagen_avatar;
						$imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
						unlink($imagen_a_borrar);
					}

					$data_imagen = $this->upload->data();
					$nombre_foto = $data_imagen['file_name'];

				}

			} else {
				$nombre_foto = $usuario_en_sesion->nombre_imagen_avatar;
			}
            $data = array(
                'nombre_completo' => $this->input->post('nombre_completo'),
                'apellido_paterno' => $this->input->post('apellido_paterno'),
                'apellido_materno' => $this->input->post('apellido_materno'),
                'no_telefono' => $this->input->post('no_telefono'),
                'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_nacimiento')))),
                'rfc' => $this->input->post('rfc'),
                'genero' => $this->input->post('genero'),
                'calle' => $this->input->post('calle'),
                'numero' => $this->input->post('numero'),
                'colonia' => $this->input->post('colonia'),
                'ciudad' => $this->input->post('ciudad'),
                'estado' => $this->input->post('estado'),
                'pais' => $this->input->post('pais'),
                'nombre_imagen_avatar' => $nombre_foto
            );

            if ($this->usuarios_model->editar($this->session->userdata['id'], $data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'Los datos del perfil han sido actualizados exitosamente.');

            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Ha ocurrido un error al intentar actualizar los dato del perfil; por favor inténtelo más tarde');

            }

            redirect('usuarios/perfil');
        }
    }

    public function cambiar_contrasena()
    {
        $this->form_validation->set_rules('contrasena_actual', 'Contraseña actual', 'required');
        $this->form_validation->set_rules('contrasena_nueva', 'Contraseña nueva', 'required|matches[confirmar_contrasena]');
        $this->form_validation->set_rules('confirmar_contrasena', 'Confirmar contraseña', 'required');

        $this->session->set_flashdata('PILL_SELECCIONADO', 3);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('VALIDATION_ERRORS', validation_errors());
            redirect('usuarios/perfil');

        } else {
            $this->load->model('usuarios_model');
            // Obtener contrasena de usuario en sesión
            $usuario_en_sesion = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata['id'])->row();

            // Validar que la contraseña anterior sea la correcta
            if (password_verify($this->input->post('contrasena_actual'), $usuario_en_sesion->contrasena_hash)) {
                // Actualizar contrasena
                if ($this->usuarios_model->editar($usuario_en_sesion->id, array('contrasena_hash' => password_hash($this->input->post('contrasena_nueva'), PASSWORD_DEFAULT)))) {
                    $this->session->set_flashdata('MENSAJE_EXITO', 'La contrasena ha sido actualizada correctamente');
                }
            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', 'La contrasena actual ingresada no es correcta');
            }

            redirect('usuarios/perfil');
        }

    }

    public function subir_imagen()
    {
        
        // Establecer la cabecera para devolver la respuesta en formato json
        header('Content-Type: application/json');

        // Establecer la configuración de subidor de archivos
        $config['upload_path'] = './subidas/perfil/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 100;
        $config['max_width'] = 400;
        $config['max_height'] = 400;
        $config['overwrite'] = true;
        $config['max_filename'] = 100;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('img_perfil')) {
            // Enviar el error al usuario
            http_response_code(500);
            $errores = array('error' => $this->upload->display_errors());
            echo json_encode($errores);

        } else {

            // Guardar nombre de la imagen, borrar el archivo anterior y
            // actualizar la ruta de la imagen en la sesión del usuario actual
            $nombre_archivo = $this->upload->data('file_name');

            if ($this->usuarios_model->editar($this->session->userdata['id'], array('nombre_imagen_avatar' => $nombre_archivo))) {

                if ($nombre_archivo != $this->session->userdata['nombre_imagen_avatar'] && $this->config->item('imagen_perfil_por_defecto', 'b3studio') != $this->session->userdata['nombre_imagen_avatar']) {
                    unlink('./subidas/perfil/' . $this->session->userdata['nombre_imagen_avatar']);
                    $this->session->userdata['nombre_imagen_avatar'] = $nombre_archivo;
                }

            }

            echo json_encode('Imagen guardada exitosamente');
        }
    }

}
