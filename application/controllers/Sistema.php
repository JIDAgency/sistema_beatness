<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sistema extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('usuarios_model');
    }

    public function change_password($id = null)
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        $usuario_row = $this->usuarios_model->obtener_usuario_por_id($id)->row();

        // Establecer validaciones
        $this->form_validation->set_rules('id', 'id', 'required');
        $this->form_validation->set_rules('contrasenia', 'Contraseña nueva', 'required|min_length[8]');
        $this->form_validation->set_rules('contrasenia_valida', 'Validar contraseña nueva', 'required|matches[contrasenia]|min_length[8]');

        // Inicializar vista, scripts
        $data['menu_sistema_activo'] = true;
        $data['pagina_titulo'] = 'Asignar nueva contraseña';

        /** Configuracion del formulario */
        $data['controlador'] = 'sistema/change_password/'.$usuario_row->id;
        $data['regresar_a'] = 'clientes';

        /** Se agrega el controlador JavaScript que usará el controlador */
        $controlador_js = "sistema/change_password";

        /** Asigna los componentes (estilos y librerías) que se utilizaran en la vista */
        $data['styles'] = array(
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        if (!$usuario_row) {
            $this->session->set_flashdata('MENSAJE_INFO', 'El cliente que intenta editar no existe.');
            redirect('clientes');
        }

        $data['usuario_row'] = $usuario_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('sistema/change_password', $data);

        } else {

            if ($this->usuarios_model->editar($usuario_row->id, array('contrasena_hash' => password_hash($this->input->post('contrasenia'), PASSWORD_DEFAULT)))) {

                $this->session->set_flashdata('MENSAJE_EXITO', 'La contraseña del usuario '.$usuario_row->correo.' #'.$usuario_row->id.' ha sido cambiada correctamente.');
                redirect("clientes");
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                redirect("clientes");
            }

            $this->construir_private_site_ui('sistema/change_password', $data);

        }

    }


    public function asignar_contrasenia_2($usuario_a_editar_id = null)
    {
        if ($this->input->post()) {
            $usuario_a_editar_id = $this->input->post('id');
        }

        /** Asignar los datos del menú y el encabezado */
        $data['menu_sistema_activo'] = true;
        $data['pagina_titulo'] = 'Asignar nueva contraseña';

        /** Asignar las variables que reciben los mensajes de sistema */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** Se agrega el controlador JavaScript que usará el controlador */
        $controlador_js = "sistema/asignar_contrasenia";

        /** Asigna los componentes (estilos y librerías) que se utilizaran en la vista */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        $this->form_validation->set_rules('password', 'Contraseña nueva', 'required|min_length[8]');
        $this->form_validation->set_rules('password_validation', 'Validar contraseña', 'required|matches[password]|min_length[8]');

        /** Configuracion del formulario */
        $data['controlador'] = 'sistema/asignar_contrasenia/'.$usuario_a_editar_id;
        $data['regresar_a'] = 'clientes';

        $administrativo_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();
        $usuario_row = $this->usuarios_model->obtener_usuario_por_id($usuario_a_editar_id)->row();

        $data['usuario_row'] = $usuario_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('sistema/asignar_contrasenia', $data);

        } else {

            if(!$this->input->post()){

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                redirect("clientes");
            }


            if ($this->usuarios_model->editar($usuario_row->id, array('contrasena_hash' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)))) {

                $this->session->set_flashdata('MENSAJE_EXITO', 'La contraseña del usuario '.$usuario_row->correo.' #'.$usuario_row->id.' ha sido cambiada correctamente.');
                redirect("clientes");
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                redirect("clientes");
            }

        
            $this->construir_private_site_ui('sistema/asignar_contrasenia', $data);

        }

    }
    
    public function cambiar_contrasena()
    {
        /** Carga los datos del menu */
        $data['menu_sistema_activo'] = true;
        $data['pagina_titulo'] = 'Cambiar contraseña';

        /** Mensajes personalizados */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
        
        /** JS propio del controlador */
        $controlador_js = "sistema/cambiar_contrasena";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'sistema/cambiar_contrasena';
        if (es_superadministrador() OR es_administrador() OR es_asesor()) {
            $data['regresar_a'] = 'inicio';
        } elseif (es_inversionista()) {
            $data['regresar_a'] = 'inversionista/portafolios';
        }
        
        $this->form_validation->set_rules('password', 'Contraseña actual', 'required');
        $this->form_validation->set_rules('password', 'Contraseña nueva', 'required|min_length[8]');
        $this->form_validation->set_rules('password_validation', 'Validar contraseña', 'required|matches[password]|min_length[8]');

        if ($this->form_validation->run() == false) {

            $this->construir_ui('sistema/cambiar_contrasena', $data);

        } else {


            if(!$this->input->post()){

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                redirect($data['regresar_a']);
            }
            
            $usuario_a_modificar = $this->usuarios_model->get_usuario_por_id($this->session->userdata('usuario_id'))->row();

            if(!$usuario_a_modificar){

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                redirect($data['regresar_a']);
            }

            if(password_verify($this->input->post('password_actual'), $usuario_a_modificar->password)){

                if (!password_verify($this->input->post('password'), $usuario_a_modificar->password)) {
                    $data_usuario = array(
                        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    );
        
                    if(!$data_usuario){
        
                        $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                        redirect($data['regresar_a']);
                    }
        
                    if ($this->usuarios_model->update_usuario($this->session->userdata('usuario_id'), $data_usuario)) {
        
                        $this->session->set_flashdata('MENSAJE_EXITO', 'La contraseña de su cuenta ha sido cambiada correctamente.');
                        redirect($data['regresar_a']);
                    } else {
        
                        $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                        redirect($data['regresar_a']);
                    }
                } else {
                    $this->session->set_flashdata('MENSAJE_INFO', 'No es posible usar la misma contraseña que la anterior, por favor inténtelo de nuevo.');
                    redirect('sistema/cambiar_contrasena');
                }
                
            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer su contraseña actual no coincide, por favor inténtelo de nuevo.');
                redirect('sistema/cambiar_contrasena');
            }

            $this->construir_ui('sistema/cambiar_contrasena', $data);
        }
    }
}