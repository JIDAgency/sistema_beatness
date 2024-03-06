<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends MY_Controller {

	public function __construct()
	{
        parent::__construct();

        $this->load->model('asignaciones_model');
        $this->load->model('usuarios_model');
		$this->load->model('tarjetas_model');
		$this->load->model('planes_model');
        
	}

	public function index()
	{
		$data['menu_usuario_perfil_activo'] = true;
		$data['pagina_titulo'] = 'Perfil';
		
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		
        /** JS propio del controlador */
        $controlador_js = "usuario/perfil/index";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/css/pages/users.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/perfil';
        $data['regresar_a'] = 'usuario/inicio';

        $this->form_validation->set_rules('correo', 'Correo electrónico', 'required|is_unique_for_edit[usuarios.correo.'.$this->session->userdata('id').']');
        $this->form_validation->set_rules('nombre', 'Nombre/s', 'required');
        $this->form_validation->set_rules('apellido_paterno', 'Apellido paterno', 'required');
        $this->form_validation->set_rules('no_telefono', 'Número celular', 'required|numeric');
        $this->form_validation->set_rules('genero', 'Genero', 'required');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required');
        
        $data_usuario_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

        if (!$data_usuario_row) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
            redirect($data['regresar_a']);
        }

        $data['data_usuario_row'] = $data_usuario_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_usuario_ui('usuario/perfil/index', $data);

        } else {

            $data_usuario = array(
                'correo' => $this->input->post('correo'),
                'nombre_completo' => $this->input->post('nombre'),
                'apellido_paterno' => $this->input->post('apellido_paterno'),
                'apellido_materno' => $this->input->post('apellido_materno'),
                'no_telefono' => $this->input->post('no_telefono'),
                'genero' => $this->input->post('genero'),
                'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_nacimiento')))),
            );

            if ($this->usuarios_model->editar($this->session->userdata['id'], $data_usuario)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'Los datos de su cuenta de usuario han sido actualizados con éxito.');
                redirect($data['controlador']);
            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
                redirect($data['controlador']);
            }

            $this->construir_private_usuario_ui('usuario/perfil/index', $data);

        }

    }
    
    public function cambiar_contrasenia()
    {
        $data['menu_usuario_perfil_activo'] = true;
		$data['pagina_titulo'] = 'Cambiar contraseña';
		
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		
        /** JS propio del controlador */
        $controlador_js = "usuario/perfil/cambiar_contrasenia";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/css/pages/users.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/perfil/cambiar_contrasenia';
        $data['regresar_a'] = 'usuario/perfil';

        $this->form_validation->set_rules('contrasena_actual', 'Contraseña actual', 'required');
        $this->form_validation->set_rules('contrasena_nueva', 'Nueva contraseña', 'required|matches[confirmar_contrasena]');
        $this->form_validation->set_rules('confirmar_contrasena', 'Confirmar nueva contraseña', 'required');
        
        $data_usuario_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

        if (!$data_usuario_row) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
            redirect($data['regresar_a']);
        }

        $data['data_usuario_row'] = $data_usuario_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_usuario_ui('usuario/perfil/cambiar_contrasenia', $data);

        } else {

            $validar_data_usuario_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

            if (!$validar_data_usuario_row) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
                redirect($data['regresar_a']);
            }

            if (password_verify($this->input->post('contrasena_nueva'), $validar_data_usuario_row->contrasena_hash)) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'La nueva contraseña no debe coincidir con la contraseña actual, por favor revise sus credenciales.');
                redirect($data['controlador']);
            }

            // Validar que la contraseña anterior sea la correcta
            if (password_verify($this->input->post('contrasena_actual'), $validar_data_usuario_row->contrasena_hash)) {
                // Actualizar contrasena
                if ($this->usuarios_model->editar($this->session->userdata('id'), array('contrasena_hash' => password_hash($this->input->post('contrasena_nueva'), PASSWORD_DEFAULT)))) {
                    $this->session->set_flashdata('MENSAJE_EXITO', 'La contrasena ha sido actualizada correctamente.');
                    redirect($data['controlador']);
                } else {
                    $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
                    redirect($data['controlador']);
                }
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', 'La contraseña actual no coincide, por favor revise sus credenciales.');
                redirect($data['controlador']);
            }

            $this->construir_private_usuario_ui('usuario/perfil/cambiar_contrasenia', $data);

        }
    }

	public function metodos_pago()
	{
		$data['menu_usuario_perfil_activo'] = true;
        $data['pagina_titulo'] = 'Mis métodos de pago';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "usuario/perfil/metodos_pago";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/css/pages/users.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/perfil/metodos_pago';
        $data['regresar_a'] = 'usuario/perfil';

        // Cargar data
        $data_asignacion_row = $this->asignaciones_model->get_asignaciones_para_clases_online_activas_por_usuario_id($this->session->userdata('id'))->row();

        $tarjetas_registradas_list = $this->tarjetas_model->get_tarjetas_por_usuario_id($this->session->userdata('id'));

        /*if ($tarjetas_registradas_list->num_rows() <= 0){
            $this->session->set_flashdata('MENSAJE_INFO', 'Para proceder con el pago es necesario registrar un método de pago.');
            redirect('usuario/perfil/nuevo_metodo_pago');
        }*/

        $data['datos_asignacion_row'] = $data_asignacion_row;
        $data['tarjetas_registradas_list'] = $tarjetas_registradas_list;

        $this->construir_private_usuario_ui('usuario/perfil/metodos_pago', $data);
    }
    
    public function nuevo_metodo_pago()
    {
        $data['menu_usuario_perfil_activo'] = true;
        $data['pagina_titulo'] = 'Agregar método de pago';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "usuario/perfil/nuevo_metodo_pago";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/css/pages/users.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'),
            array('es_rel' => false, 'src' => 'https://openpay.s3.amazonaws.com/openpay.v1.min.js'),
            array('es_rel' => false, 'src' => 'https://openpay.s3.amazonaws.com/openpay-data.v1.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/card/jquery.card.js'),
            array('es_rel' => true, 'src' => 'openpay/openpay.js'),
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/perfil/nuevo_metodo_pago';
        $data['regresar_a'] = 'usuario/perfil/metodos_pago';

        $this->form_validation->set_rules('token_id', 'token_id', 'required');

        $this->load->library('openpagos');

        $datos_del_usuario_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

        if (!$datos_del_usuario_row->openpay_cliente_id) {

            $registro_cliente_openpay = $this->openpagos->crear_un_nuevo_cliente_en_openpay($datos_del_usuario_row->id, $datos_del_usuario_row->nombre_completo, $datos_del_usuario_row->apellido_paterno, $datos_del_usuario_row->correo, $datos_del_usuario_row->no_telefono);
            
            if (!$registro_cliente_openpay) {
                // Ocurrió un error
                //$this->session->set_flashdata('MENSAJE_ERROR',  'Error al realizar la compra.');
            }
    
            if (preg_match('/ERROR/i', $registro_cliente_openpay)) {
                //$this->session->set_flashdata('MENSAJE_ERROR',  $registro_cliente_openpay);
            } else {
                $this->usuarios_model->editar($this->session->userdata('id'), array('openpay_cliente_id' => $registro_cliente_openpay->id));
                //$this->session->set_flashdata('MENSAJE_EXITO',  'Registro de cliente: '.$registro_cliente_openpay->id);
            }

        } else {

            //$this->session->set_flashdata('MENSAJE_EXITO',  'El cliente ya cuenta con un ID en Openpay.');

        }
        
        $tarjetas_registradas_list = $this->tarjetas_model->get_tarjetas_por_usuario_id($this->session->userdata('id'));

        if ($tarjetas_registradas_list->num_rows() >= 3){
            $this->session->set_flashdata('MENSAJE_INFO', 'Usted cuenta con 3 métodos de pago registrados. Para continuar elimine uno de los métodos de pago.');
            redirect($data['regresar_a']);
        }

        if ($this->form_validation->run() == false) {

            $this->construir_private_usuario_ui('usuario/perfil/nuevo_metodo_pago', $data);

        } else {
            $validar_datos_del_usuario_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

            if (!$validar_datos_del_usuario_row AND !$validar_datos_del_usuario_row->openpay_cliente_id) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
                redirect($data['regresar_a']);
            }

            $respuesta_openpay = $this->openpagos->crear_una_tarjeta_con_token_de_cliente_en_openpay($validar_datos_del_usuario_row->openpay_cliente_id, $this->input->post('token_id'), $this->input->post('deviceIdHiddenFieldName'));

            if (!$respuesta_openpay) {
                // Ocurrió un error
                $this->session->set_flashdata('MENSAJE_ERROR',  'Al parecer hubo un error al intentar registrar una nueva tarjeta, por favor intentelo mas tarde.');
                redirect($data['regresar_a']);

            }

            if (preg_match('/ERROR/i', $respuesta_openpay)) {
                $this->session->set_flashdata('MENSAJE_ERROR',  $respuesta_openpay);
                redirect($data['regresar_a']);
            }
            
            $openpay_tarjeta_id = $respuesta_openpay->id;

            $data_tarjeta = array(
                'usuario_id' => $this->session->userdata('id'),
                'openpay_cliente_id' => $validar_datos_del_usuario_row->openpay_cliente_id,
                'openpay_tarjeta_id' => $openpay_tarjeta_id,
                'openpay_holder_name' => $this->input->post('name'),
                'terminacion_card_number' => substr(str_replace(' ', '', $this->input->post('number')), -4),
                'openpay_expiration_month' => substr(str_replace(' ', '', $this->input->post('expiry')), 0, 2),
                'openpay_expiration_year' => substr(str_replace(' ', '', $this->input->post('expiry')), -2),
                'fecha_registro' => date('Y-m-d H:i:s'),
                'brand' => $respuesta_openpay->brand,
                'banco' => $respuesta_openpay->bank_name,
                'banco_code' => $respuesta_openpay->bank_code,
                'allows_charges' => $respuesta_openpay->allows_charges,
                'allows_payouts' => $respuesta_openpay->allows_payouts
            );

            if($this->tarjetas_model->insert_tarjeta($data_tarjeta)){
                $this->session->set_flashdata('MENSAJE_EXITO', 'Se ha registrado el método de pago ****'.substr(str_replace(' ', '', $this->input->post('number')), -4).'.');
                redirect($data['regresar_a']);
            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (002)');
                redirect($data['regresar_a']);
            }

            $this->construir_private_usuario_ui('usuario/perfil/nuevo_metodo_pago', $data);

        }
    }

    public function eliminar_metodo_pago($openpay_tarjeta_id = null)
    {
        if (!$openpay_tarjeta_id) {

            if ($this->input->post()) {

                $openpay_tarjeta_id = $this->input->post('openpay_tarjeta_id');
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
                redirect('usuario/perfil/metodos_pago');
            }
        }

        $validar_datos_cliente = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

        if (!$validar_datos_cliente){
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (002)');
            redirect('usuario/perfil/metodos_pago');
        }

        $data_tarjeta_row = $this->tarjetas_model->get_tarjeta_por_openpay_id_por_usuario_id($openpay_tarjeta_id, $this->session->userdata('id'))->row();

        if (!$data_tarjeta_row){
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (003)');
            redirect('usuario/perfil/metodos_pago');
        }

        $validar_si_la_tarjeta_esta_en_uso = $this->asignaciones_model->get_asignacion_por_usuario_id_y_openpay_tarjeta_id($data_tarjeta_row->openpay_tarjeta_id, $this->session->userdata('id'))->row();

        if ($validar_si_la_tarjeta_esta_en_uso){
            $this->session->set_flashdata('MENSAJE_INFO', 'Esta tarjeta se encuentra en uso actualmente por su suscripción.');
            redirect('usuario/perfil/metodos_pago');
        }

        $data_tarjeta = array(
            'estatus' => 'eliminado',
        );

        if ($this->tarjetas_model->update_tarjeta($data_tarjeta_row->id, $data_tarjeta)) {
            //$this->session->set_flashdata('MENSAJE_EXITO', 'Estatus de tarjeta actualizado con éxito.');
            //redirect('usuario/perfil/metodos_pago');
        } else {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (004)');
            redirect('usuario/perfil/metodos_pago');
        }

        $this->load->library('openpagos');

        $respuesta_openpay = $this->openpagos->eliminar_una_tarjeta_en_openpay($validar_datos_cliente->openpay_cliente_id, $data_tarjeta_row->openpay_tarjeta_id);

        if ($respuesta_openpay){

            if (preg_match('/ERROR/i', $respuesta_openpay)) {
                $this->session->set_flashdata('MENSAJE_ERROR',  $respuesta_openpay);
                redirect('usuario/perfil/metodos_pago');
            }

            $this->session->set_flashdata('MENSAJE_EXITO', 'La tarjeta con terminación ****'.$data_tarjeta_row->terminacion_card_number.' ha sido eliminada con éxito.');
            redirect('usuario/perfil/metodos_pago');
        } else {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (005)');
            redirect('usuario/perfil/metodos_pago');
        }

        $this->session->set_flashdata('MENSAJE_INFO', 'Ejecución terminada');
        redirect('usuario/perfil/metodos_pago');
    }

    public function planes()
    {
        $data['menu_usuario_perfil_activo'] = true;
        $data['pagina_titulo'] = 'Mis planes y suscripciones.';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "usuario/perfil/planes";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/css/pages/users.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/perfil/planes';
        $data['regresar_a'] = 'usuario/perfil';

        //Cargar datos
        $data_suscripcion_row = $this->asignaciones_model->get_asignacion_activa_de_tipo_suscripcion_con_detalles_por_usuario_id($this->session->userdata('id'))->row();

        if (!$data_suscripcion_row) {
            //$this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
            $data_suscripcion_fd_row = $this->asignaciones_model->get_asignacion_activa_de_tipo_suscripcion_hecha_por_frontdesk_con_detalles_por_usuario_id($this->session->userdata('id'))->row();
            $data['data_suscripcion_fd_row'] = $data_suscripcion_fd_row;
        }

        //$tarjetas_registradas_list = $this->tarjetas_model->get_tarjetas_por_usuario_id($this->session->userdata('id'));

        /*if ($tarjetas_registradas_list->num_rows() <= 0){
            $this->session->set_flashdata('MENSAJE_INFO', 'Para proceder con el pago es necesario registrar un método de pago.');
            redirect($data['regresar_a']);
        }*/

        //$data['tarjetas_registradas_list'] = $tarjetas_registradas_list;


        $data['data_suscripcion_row'] = $data_suscripcion_row;

        $this->construir_private_usuario_ui('usuario/perfil/planes', $data);
    }

    public function cambiar_metodo_pago($suscripcion_id = null)
    {

        if (!$suscripcion_id) {

            if ($this->input->post()) {

                $suscripcion_id = $this->input->post('suscripcion_id');
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
                redirect('usuario/perfil/planes');
            }
        }

        $data['menu_usuario_perfil_activo'] = true;
        $data['pagina_titulo'] = 'Cambiar método de pago';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "usuario/perfil/cambiar_metodo_pago";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/css/pages/users.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/perfil/cambiar_metodo_pago/'.$suscripcion_id;
        $data['regresar_a'] = 'usuario/perfil/planes';
        
        $this->form_validation->set_rules('suscripcion_id', 'Suscripción', 'required');
        $this->form_validation->set_rules('metodo_pago', 'Método de pago', 'required');

        $tarjetas_registradas_list = $this->tarjetas_model->get_tarjetas_por_usuario_id($this->session->userdata('id'));

        if ($tarjetas_registradas_list->num_rows() <= 0){
            $this->session->set_flashdata('MENSAJE_INFO', 'Para proceder con el cambio es necesario registrar un método de pago.');
            redirect($data['regresar_a']);
        }

        $data_suscripcion_row = $this->asignaciones_model->get_asignacion_activa_de_tipo_suscripcion_con_detalles_por_suscripcion_id_y_usuario_id($suscripcion_id, $this->session->userdata('id'))->row();

        if (!$data_suscripcion_row){
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (001)');
            redirect($data['regresar_a']);
        }

        $data['tarjetas_registradas_list'] = $tarjetas_registradas_list;
        $data['data_suscripcion_row'] = $data_suscripcion_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_usuario_ui('usuario/perfil/cambiar_metodo_pago', $data);

        } else {

            $validar_data_suscripcion_row = $this->asignaciones_model->get_asignacion_activa_de_tipo_suscripcion_con_detalles_por_suscripcion_id_y_usuario_id($suscripcion_id, $this->session->userdata('id'))->row();
            
            if (!$validar_data_suscripcion_row){
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (002)');
                redirect($data['controlador']);
            }

            $metodo_de_pago_seleccionado = $this->tarjetas_model->get_tarjeta_id_por_usuario_id($this->input->post('metodo_pago'), $this->session->userdata('id'))->row();

            if (!$metodo_de_pago_seleccionado){
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (003)');
                redirect($data['controlador']);
            }

            $this->load->library('openpagos');
            
            $respuesta_openpay = $this->openpagos->actualizar_una_suscripcion($metodo_de_pago_seleccionado->openpay_tarjeta_id, $validar_data_suscripcion_row->openpay_suscripcion_id, $validar_data_suscripcion_row->openpay_cliente_id);

            if (!$respuesta_openpay) {
                // Ocurrió un error
                $this->session->set_flashdata('MENSAJE_ERROR',  'Al parecer ocurrió un error, por favor intentelo mas tarde. (004)');
                redirect($data['controlador']);

            }

            if (preg_match('/ERROR/i', $respuesta_openpay)) {
                $this->session->set_flashdata('MENSAJE_ERROR',  'Tarjeta: '.$metodo_de_pago_seleccionado->openpay_tarjeta_id.' | Suscripcion: '.$validar_data_suscripcion_row->openpay_suscripcion_id.' | Cliente: '.$validar_data_suscripcion_row->openpay_cliente_id.' '.$respuesta_openpay);
                redirect($data['controlador']);
            }

            $data_suscripcion = array(
                'openpay_tarjeta_id' => $metodo_de_pago_seleccionado->openpay_tarjeta_id,
            );

            if ($this->asignaciones_model->editar($validar_data_suscripcion_row->id, $data_suscripcion)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'El método de pago de la suscripción ha sido actualizado con éxito.');
                redirect($data['regresar_a']);
            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer ocurrió un error, por favor intentelo mas tarde. (004)');
                redirect($data['controlador']);
            }

            $this->construir_private_usuario_ui('usuario/perfil/cambiar_metodo_pago', $data);
        }
    }

    public function cancelar_suscripcion()
    {
        # code...
    }
}
