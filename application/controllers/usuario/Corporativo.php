<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Corporativo extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('asignaciones_model');
        $this->load->model('usuarios_model');
        $this->load->model('rel_corporativo_usuarios_model');

        if (!es_corporativo()) {
            redirect();
        }
    }

    public function index()
    {
        $id = $this->session->userdata("id");

        $data['menu_usuario_corporativo'] = true;
		$data['pagina_titulo'] = 'Corporativo';

		//revisar
		$data['controlador'] = 'usuario/corporativo/index';
		$data['regresar_a'] = 'usuario/corporativo';
		$controlador_js = "usuario/corporativo/index";

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
  
        // Cargar estilos y scripts
        $data['styles'] = array(
        );
        $data['scripts'] = array(
            array('es_rel' => true, 'src' => $controlador_js.'.js'),
        );

        $corporativo_row = $this->usuarios_model->get_usuario_corporativo_por_id($id)->row();
        $suscripcion_row = $this->asignaciones_model->get_asignaciones_para_clases_online_activas_por_usuario_id($id)->row();
        $usuarios_list = $this->rel_corporativo_usuarios_model->get_los_usuarios_corporativos_por_corporativo_id($id)->result();

        $data["corporativo_row"] = $corporativo_row;
        $data["suscripcion_row"] = $suscripcion_row;
        $data["usuarios_list"] = $usuarios_list;

        $this->construir_private_usuario_ui('usuario/corporativo/index', $data);

    }

    public function editar($id = null)
    {
        if ($this->input->post()) {
			$id = $this->input->post('id');
		}

        $relacion_row = $this->rel_corporativo_usuarios_model->get_rel_corporativo_usuario_por_usuario_id($id)->row();

        $data['menu_usuario_corporativo'] = true;
		$data['pagina_titulo'] = 'Editar usuario';

		//revisar
		$data['controlador'] = 'usuario/corporativo/editar/'.$id;
		$data['regresar_a'] = "usuario/corporativo";
		$controlador_js = "usuario/corporativo/editar";

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
  
        // Cargar estilos y scripts
        $data['styles'] = array(
        );
        $data['scripts'] = array(
            array('es_rel' => true, 'src' => $controlador_js.'.js'),
        );

        $this->form_validation->set_rules('correo', 'correo electrónico', 'required|is_unique_for_edit[usuarios.correo.'.$id.']');
        $this->form_validation->set_rules('nombre_completo', 'nombre completo', 'required');
        $this->form_validation->set_rules('apellido_paterno', 'apellido paterno', 'required');

        $usuario_row = $this->usuarios_model->obtener_usuario_por_id($id)->row();

        $data['usuario_row'] = $usuario_row;
        $data['relacion_row'] = $relacion_row;

        if ($this->form_validation->run() == false) {
            
            $this->construir_private_usuario_ui('usuario/corporativo/editar', $data);

        } else {

            $data = array(
                'correo' => $this->input->post('correo'),
                'nombre_completo' => $this->input->post('nombre_completo'),
                'apellido_paterno' => $this->input->post('apellido_paterno'),
                'apellido_materno' => $this->input->post('apellido_materno'),
                'no_telefono' => $this->input->post('no_telefono'),
            );

            
            if ($this->usuarios_model->editar($usuario_row->id, $data)) {

                $this->session->set_flashdata('MENSAJE_EXITO', 'Los datos del usuario #'.$usuario_row->id.' se han actualizado correctamente.');
                redirect(site_url("usuario/corporativo"));
                
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (1)');
                redirect(site_url("usuario/corporativo"));

            }

            $this->construir_private_usuario_ui('usuario/corporativo/editar', $data);
        }

    }

    public function password($id = null)
    {
        if ($this->input->post()) {
			$id = $this->input->post('id');
		}

        $relacion_row = $this->rel_corporativo_usuarios_model->get_rel_corporativo_usuario_por_usuario_id($id)->row();

        $data['menu_usuario_corporativo'] = true;
		$data['pagina_titulo'] = 'Cambiar contraseña';

		//revisar
		$data['controlador'] = 'usuario/corporativo/password/'.$id;
		$data['regresar_a'] = "usuario/corporativo";
		$controlador_js = "usuario/corporativo/password";

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
  
        // Cargar estilos y scripts
        $data['styles'] = array(
        );
        $data['scripts'] = array(
            array('es_rel' => true, 'src' => $controlador_js.'.js'),
        );

        $this->form_validation->set_rules('password', 'Nueva contraseña', 'required|min_length[8]');
        $this->form_validation->set_rules('password_validation', 'Validar nueva contraseña', 'required|matches[password]|min_length[8]');

        $usuario_row = $this->usuarios_model->obtener_usuario_por_id($id)->row();

        $data['usuario_row'] = $usuario_row;
        $data['relacion_row'] = $relacion_row;

        if ($this->form_validation->run() == false) {
            
            $this->construir_private_usuario_ui('usuario/corporativo/password', $data);

        } else {

            if ($this->usuarios_model->editar($usuario_row->id, array('contrasena_hash' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)))) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'Los datos del usuario #'.$usuario_row->id.' se han actualizado correctamente.');
                redirect(site_url("usuario/corporativo"));
            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (1)');
                redirect(site_url("usuario/corporativo"));
            }


            $this->construir_private_usuario_ui('usuario/corporativo/password', $data);
        }
    }
}
