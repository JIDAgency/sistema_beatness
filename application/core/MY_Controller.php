<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        
        parent::__construct();
        
        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_TIME,"es_ES.UTF-8");

        $this->config->load('b3studio', true);

        // Cargando librerías comunes a utilizar
        $this->load->library('session');
        $this->load->library('form_validation');
        // Cargando helpers comunes a utilizar
        $this->load->helper(array('url','identidad','form'));
        // Cargando el manejador de la base de datos
        $this->load->database();
    }

    protected function construir_public_ui($contenido, $data = null)
    {        
		$this->load->view('_layout/public/header', $data);
        $this->load->view($contenido, $data);
        $this->load->view('_layout/public/footer', $data);
    }


    protected function construir_private_site_ui($content, $data = null)
    {
        if (!$this->session->userdata['en_sesion'] == true) {
            redirect('cuenta/iniciar_sesion');
        }
        
        $this->verificar_token_web();

        //Validar rol de la sesión
        if (es_cliente()){
            redirect('usuario/inicio');
        }
        if (es_instructor()){
            redirect('usuario/inicio');
        } 
        if ($this->session->userdata("id") == "5409") {
            redirect('instructor/inicio');
        }

        // Cargar datos del usuario en sesión
        $data['nombre_completo'] = $this->session->userdata['nombre_completo'];

        $this->load->view('_comun/cabecera_fixed', $data);
        $this->load->view($content, $data);
        $this->load->view('_comun/pie_pagina', $data);
    }

    protected function construir_private_usuario_ui($content, $data = null)
    {
        if (!$this->session->userdata['en_sesion'] == true) {
            redirect('cuenta/iniciar_sesion');
        }
        
        $this->verificar_token_web();

        //Validar rol de la sesión
        if (es_superadministrador()){
            redirect('inicio');
        }
        if (es_administrador()){
            redirect('inicio');
        }
        if (es_frontdesk()){
            redirect('inicio');
        }
        if ($this->session->userdata("id") == "5409") {
            redirect('instructor/inicio');
        }

        // Cargar datos del usuario en sesión
        $data['nombre_completo'] = $this->session->userdata['nombre_completo'];

        $this->load->model('asignaciones_model');

        $plan_online = $this->asignaciones_model->get_asignaciones_para_clases_online_activas_por_usuario_id($this->session->userdata('id'))->row();
        
        if (!$plan_online) {
            $data['tiene_suscripcion_activa'] = 'cancelado';
            $data['plan_online_text'] = '¡Activar mi plan!';
            $data['plan_online_url'] = 'usuario/shop';
        } elseif ($plan_online->suscripcion_estatus_del_pago == 'rechazado') {
            $data['tiene_suscripcion_activa'] = 'rechazado';
            $data['plan_online_text'] = '¡Actualiza tu método de pago!';
            $data['plan_online_url'] = 'usuario/shop';
        } elseif ($plan_online->suscripcion_estatus_del_pago == 'pagado') {
            $data['tiene_suscripcion_activa'] = 'activo';
            $data['plan_online_text'] = '¡Tu plan está activo!';
            $data['plan_online_url'] = 'usuario/clases';
        } elseif ($plan_online->suscripcion_estatus_del_pago == 'prueba') {
            $data['tiene_suscripcion_activa'] = 'activo';
            $data['plan_online_text'] = '¡Tu plan está activo!';
            $data['plan_online_url'] = 'usuario/clases';
        }

        //$this->load->library('openpagos');
        //$this->openpagos->eliminar_un_cliente_en_openpay('a7zmlju7yeb781vlzimr');
        //$this->openpagos->eliminar_un_cliente_en_openpay('alzlvqcxdksy3m1zoxe7');
        //$this->openpagos->eliminar_una_tarjeta_en_openpay('aeru51gvqwt5z0smbqem', 'kmpqxahyfu4hjknfjdgb');
        $this->load->view('_comun/cabecera2', $data);
        $this->load->view($content, $data);
        $this->load->view('_comun/pie_pagina2', $data);
    }

    protected function instructor_ui($content, $data = null)
    {

        if (!$this->session->userdata['en_sesion'] == true) {
            redirect('cuenta/iniciar_sesion');
        }
        
        $this->verificar_token_web();

        if (!es_instructor()){
            redirect('usuario/inicio');
        }
        //Validar rol de la sesión
        if (es_superadministrador()){
            redirect('inicio');
        }
        if (es_administrador()){
            redirect('inicio');
        }
        if (es_frontdesk()){
            redirect('inicio');
        }
        if (es_cliente()){
            redirect('usuario/inicio');
        }

        // Cargar datos del usuario en sesión
        $data['nombre_completo'] = $this->session->userdata['nombre_completo'];

        $this->load->view('_comun/instructor/header', $data);
        $this->load->view($content, $data);
        $this->load->view('_comun/instructor/footer', $data);
    }


    public function verificar_token_web()
    {
        $this->load->model("usuarios_model");

        $verificacion_token = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata['id'])->row();
        if ($verificacion_token->token_web != $this->session->userdata['token_web']) {
            redirect('cuenta/cerrar_sesion');
        }
        return;
    }

    public function mensaje_del_sistema($tipo = null, $mensaje = null, $redirect = null)
    {
        $this->session->set_flashdata(''.$tipo.'', ''.$mensaje.'');
        redirect($redirect);
    }
}
