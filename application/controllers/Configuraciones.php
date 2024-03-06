<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuraciones extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model("configuraciones_model");
	}

    public function index()
    {
        /** Carga los datos del menu */
        $data['menu_configuraciones_activo'] = true;
        $data['pagina_titulo'] = 'Configuraciones de sistema';

        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "configuraciones/index";

         /** Carga todas los estilos y librerias */
         $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),

        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'configuraciones';
        $data['regresar_a'] = 'inicio';

        $this->form_validation->set_rules('app_cancelar_reservacion_hrs', 'Tiempo para cancelar reservación', 'required');
        $this->form_validation->set_rules('app_prevenir_cancelacion_hrs_estatus', 'Estatus de la configuración para horario de cancelación', 'required');
        $this->form_validation->set_rules('app_prevenir_cancelacion_hrs_valor_1', 'Hora de inicio para horario de cancelación', 'required');
        $this->form_validation->set_rules('app_prevenir_cancelacion_hrs_valor_2', 'Hora de fin para horario de cancelación', 'required');

        /** Data */
        $app_cancelar_reservacion_hrs = $this->configuraciones_model->get_configuracion_por_configuracion("app_cancelar_reservacion_hrs")->row();
        $app_prevenir_cancelacion_hrs = $this->configuraciones_model->get_configuracion_por_configuracion("app_prevenir_cancelacion_hrs")->row();

        $data['app_cancelar_reservacion_hrs'] = $app_cancelar_reservacion_hrs;
        $data['app_prevenir_cancelacion_hrs'] = $app_prevenir_cancelacion_hrs;

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('configuraciones/index', $data);
        } else {
            $mensaje_log = "";
            
            if ($app_cancelar_reservacion_hrs->valor_1 != $this->input->post("app_cancelar_reservacion_hrs")) {
                if ($this->configuraciones_model->update_configuracion_por_configuracion($app_cancelar_reservacion_hrs->configuracion, array('valor_1' => $this->input->post("app_cancelar_reservacion_hrs")))) {
                    $mensaje_log = $mensaje_log.'La configuración '.$app_cancelar_reservacion_hrs->nombre.' se ha modificado con éxito.<br>';
                }
            }

            if ($app_prevenir_cancelacion_hrs->estatus_1 != $this->input->post("app_prevenir_cancelacion_hrs_estatus") OR $app_prevenir_cancelacion_hrs->valor_1 != date("H:i", strtotime($this->input->post("app_prevenir_cancelacion_hrs_valor_1"))) OR $app_prevenir_cancelacion_hrs->valor_2 != date("H:i", strtotime($this->input->post("app_prevenir_cancelacion_hrs_valor_2"))) ) {

                $data = array(
                    'estatus_1' => $this->input->post("app_prevenir_cancelacion_hrs_estatus"),
                    'valor_1' => date("H:i", strtotime($this->input->post("app_prevenir_cancelacion_hrs_valor_1"))),
                    'valor_2' => date("H:i", strtotime($this->input->post("app_prevenir_cancelacion_hrs_valor_2"))),
                );

                if ($this->configuraciones_model->update_configuracion_por_configuracion($app_prevenir_cancelacion_hrs->configuracion, $data)) {
                    $mensaje_log = $mensaje_log.'La configuración '.$app_prevenir_cancelacion_hrs->nombre.' se ha modificado con éxito.<br>';
                }
            }

            if ($app_cancelar_reservacion_hrs->valor_1 == $this->input->post("app_cancelar_reservacion_hrs") AND
                $app_prevenir_cancelacion_hrs->estatus_1 == $this->input->post("app_prevenir_cancelacion_hrs_estatus") AND
                $app_prevenir_cancelacion_hrs->valor_1 == date("H:i", strtotime($this->input->post("app_prevenir_cancelacion_hrs_valor_1"))) AND
                $app_prevenir_cancelacion_hrs->valor_2 == date("H:i", strtotime($this->input->post("app_prevenir_cancelacion_hrs_valor_2")))
            ) {
                $this->session->set_flashdata('MENSAJE_INFO', 'No se ha realizado ningún cambio en las configuraciones.');
            } else {
                $this->session->set_flashdata('MENSAJE_EXITO', $mensaje_log);
            }
            
            redirect("configuraciones");

            $this->construir_private_site_ui('configuraciones/index', $data);
        }
    }
}
