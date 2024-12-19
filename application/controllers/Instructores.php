<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instructores extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->model('resenias_model');
    }

    public function index()
    {
        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
        
        $data['instructores'] = $this->usuarios_model->obtener_todos_instructores();

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => 'instructores/index.js'),
        );

        $data['menu_instructores_activo'] = true;
        $data['pagina_titulo'] = 'Instructores';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $this->construir_private_site_ui('instructores/index', $data);

    }

    public function crear()
    {

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Establecer validaciones
        $this->form_validation->set_rules('correo', 'correo electrónico', 'required|is_unique[usuarios.correo]');
        $this->form_validation->set_rules('contrasena', 'contraseña', 'required');
        $this->form_validation->set_rules('nombre_completo', 'nombre completo', 'required');
        //$this->form_validation->set_rules('apellido_paterno', 'apellido paterno', 'required');

        // Inicializar vista y scripts
        $data['menu_instructores_activo'] = true;
        $data['pagina_titulo'] = 'Nuevo instructor';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => true, 'src' => 'instructores/crear.js'),

        );

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('instructores/crear', $data);
        } else {

            if (isset($_FILES) && $_FILES['nombre_imagen_avatar']['error'] == '0') {

				$config['upload_path']   = './subidas/perfil/';
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
					$nombre_img_perfil = $data_imagen['file_name'];
				}

			} else {

				$nombre_img_perfil = 'default.jpg';

			}

            // Preparar datos para hacer el insert en la bd
            $data = array(
                'contrasena_hash' => password_hash($this->input->post('contrasena'), PASSWORD_DEFAULT),
                'correo' => $this->input->post('correo'),
                'rol_id' => 3, // Este usuario pertenece al rol con id 3 (Instructor)
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
                'nombre_imagen_avatar' => $nombre_img_perfil,
            );

            if ($this->usuarios_model->crear($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'El instructor se ha creado correctamente.');
                redirect('instructores/index');
            }

            $this->construir_private_site_ui('instructores/crear', $data);
        }

    }

    public function editar($id = null) {
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Establecer validaciones
        $this->form_validation->set_rules('correo', 'correo electrónico', 'required');
        $this->form_validation->set_rules('nombre_completo', 'nombre completo', 'required');
        //$this->form_validation->set_rules('apellido_paterno', 'apellido paterno', 'required');

        // Inicializar vista, scripts
        $data['menu_instructores_activo_activo'] = true;
        $data['pagina_titulo'] = 'Editar instructor';

        $data['controlador'] = 'instructores/editar/'.$id;
		$data['regresar_a'] = 'instructores';
		$controlador_js = "instructores/editar";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => true, 'src' => 'instructores/editar.js'),
        );

        // Verificar que el usuario a editar exista, obtener sus datos y pasarlos a la vista
        $instructor_a_editar = $this->usuarios_model->obtener_usuario_por_id($id)->row();
        
        if (!$instructor_a_editar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'El instructor que intenta editar no existe.');
            redirect('/instructores/index');
        }

        $resenias = $this->resenias_model->obtener_por_coach_id($id)->result();
        $data['resenias'] = $resenias;

        $data['instructor_a_editar'] = $instructor_a_editar;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('instructores/editar', $data);

        } else {

            if (isset($_FILES) && $_FILES['nombre_imagen_avatar']['error'] == '0') {

				$config['upload_path']   = './subidas/perfil/';
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

					if ($instructor_a_editar->nombre_imagen_avatar AND $instructor_a_editar->nombre_imagen_avatar != "b3-default.jpg") {
						$url_imagen_a_borrar = "subidas/perfil".$instructor_a_editar->nombre_imagen_avatar;
						$imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
						unlink($imagen_a_borrar);
					}

					$data_imagen = $this->upload->data();
					$nombre_img_perfil = $data_imagen['file_name'];

				}

			} else {

				$nombre_img_perfil = $instructor_a_editar->nombre_imagen_avatar;

			}

            $data = array(
                'correo' => $this->input->post('correo'),
                'rol_id' => 3, // Este usuario pertenece al rol con id 3 (Instructor)
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
                'nombre_imagen_avatar' => $nombre_img_perfil,
            );

            if ($this->usuarios_model->editar($id, $data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'El instructor se ha editado correctamente.');
                redirect('instructores/index');
            }

            $this->construir_private_site_ui('instructores/editar', $data);

        }

    }

}
