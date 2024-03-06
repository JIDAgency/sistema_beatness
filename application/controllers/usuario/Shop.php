<?php
defined('BASEPATH') or exit('No direct script access allowed');
    
class Shop extends MY_Controller{

	public function __construct()
	{
        parent::__construct();
        $this->load->library('openpagos');
        
        $this->load->model('asignaciones_model');
		$this->load->model('planes_model');
		$this->load->model('tarjetas_model');
        $this->load->model('usuarios_model');
        $this->load->model('ventas_model');
	}

	public function index($regresar_a = null)
	{
        $data['controlador'] = 'usuario/shop';

        if ($this->input->post()) {
            $regresar_a = $this->input->post('regresar_a');
        }

        if ($regresar_a) {
            $data['regresar_a'] = $regresar_a;
        } else {
            $data['regresar_a'] = 'usuario/inicio';
        }

		$data['menu_usuario_shop_activo'] = true;
		$data['pagina_titulo'] = 'Shop';
		
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

		$controlador_js = "usuario/shop/index";

		$data['styles'] = array(
        );
        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
		);

        $suscripciones_list = $this->planes_model->get_planes_disponibles_para_venta_en_el_sistema_de_clientes()->result();        
        $planes_list = $this->planes_model->get_planes_normales_disponibles_para_venta()->result();
        
		$data['suscripciones_list'] = $suscripciones_list;
		$data['planes_list'] = $planes_list;

        $this->construir_private_usuario_ui('usuario/shop/index', $data);
    }
    
    public function seleccionar_metodo($id = null)
    {
        $this->form_validation->set_rules('id', 'Plan seleccionado', 'required');
        /*
        $this->form_validation->set_rules('name', 'Nombre en la tarjeta', 'required');
        $this->form_validation->set_rules('number', 'Número de tarjeta', 'required');
        $this->form_validation->set_rules('cvc', 'Código de verificación', 'required');
        $this->form_validation->set_rules('expiry', 'Fecha de vencimiento', 'required');
        */

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        $data['controlador'] = 'usuario/shop/seleccionar_metodo/'.$id;
        $data['regresar_a'] = 'usuario/shop';

        $data['menu_usuario_shop_activo'] = true;
		$data['pagina_titulo'] = 'Seleccionar método de pago';
		
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

		$controlador_js = "usuario/shop/seleccionar_metodo";

		$data['styles'] = array(
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'),
            array('es_rel' => false, 'src' => 'https://openpay.s3.amazonaws.com/openpay.v1.min.js'),
            array('es_rel' => false, 'src' => 'https://openpay.s3.amazonaws.com/openpay-data.v1.min.js'),
            array('es_rel' => true, 'src' => 'openpay/openpay.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/card/jquery.card.js'),
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        $validar_suscripcion_row = $this->planes_model->get_plan_de_suscripcion_para_venta_por_id($id)->row();

        if (!$validar_suscripcion_row AND $validar_suscripcion_row != $id) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer el plan seleccionado no está disponible, por favor intente con otro.');
            redirect($data['regresar_a']);
        }
        
        $tarjetas_registradas_list = $this->tarjetas_model->get_tarjetas_por_usuario_id($this->session->userdata('id'));

        $datos_del_usuario_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

        if (!$datos_del_usuario_row->openpay_cliente_id) {

            $registro_cliente_openpay = $this->openpagos->crear_un_nuevo_cliente_en_openpay($datos_del_usuario_row->id, $datos_del_usuario_row->nombre_completo, $datos_del_usuario_row->apellido_paterno, $datos_del_usuario_row->correo, $datos_del_usuario_row->no_telefono);
            
            if (!$registro_cliente_openpay) {
                // Ocurrió un error
                $this->session->set_flashdata('MENSAJE_ERROR',  'Error al realizar la compra.');
            }

            if (preg_match('/ERROR/i', $registro_cliente_openpay)) {
                $this->session->set_flashdata('MENSAJE_ERROR',  $registro_cliente_openpay);
            } else {
                $this->usuarios_model->editar($this->session->userdata('id'), array('openpay_cliente_id' => $registro_cliente_openpay->id));
                $this->session->set_flashdata('MENSAJE_EXITO',  'Registro de cliente: '.$registro_cliente_openpay->id);
            }
            
        } else {

            //$this->session->set_flashdata('MENSAJE_EXITO',  'El cliente ya cuenta con un ID en Openpay.');

        }
        
        $data['tarjetas_registradas_list'] = $tarjetas_registradas_list;
        $data['suscripcion_row'] = $validar_suscripcion_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_usuario_ui('usuario/shop/seleccionar_metodo', $data);
        } else {
            
            $datos_del_usuario_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

            if (!$datos_del_usuario_row AND !$datos_del_usuario_row->openpay_cliente_id) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. (01)');
                redirect($data['regresar_a']);
            }

            //$respuesta_openpay = $this->openpagos->crear_una_tarjeta_de_cliente_en_openpay($datos_del_usuario_row->openpay_cliente_id, $this->input->post('name'), str_replace(' ', '', $this->input->post('number')), $this->input->post('cvc'), substr(str_replace(' ', '', $this->input->post('expiry')), 0, 2), substr(str_replace(' ', '', $this->input->post('expiry')), -2));
            $respuesta_openpay = $this->openpagos->crear_una_tarjeta_con_token_de_cliente_en_openpay($datos_del_usuario_row->openpay_cliente_id, $this->input->post('token_id'), $this->input->post('deviceIdHiddenFieldName'));

            if (!$respuesta_openpay) {
                // Ocurrió un error
                $this->session->set_flashdata('MENSAJE_ERROR',  'Al parecer hubo un error al intentar registrar una nueva tarjeta, por favor intentelo mas tarde.');
                redirect($data['controlador']);

            } 
            if (preg_match('/ERROR/i', $respuesta_openpay)) {
                $this->session->set_flashdata('MENSAJE_ERROR',  $respuesta_openpay);
                    redirect($data['controlador']);
            }
            
            $openpay_tarjeta_id = $respuesta_openpay->id;

            $data_tarjeta = array(
                'usuario_id' => $this->session->userdata('id'),
                'openpay_cliente_id' => $datos_del_usuario_row->openpay_cliente_id,
                'openpay_tarjeta_id' => $openpay_tarjeta_id,
                'openpay_holder_name' => $this->input->post('name'),
                'terminacion_card_number' => substr(str_replace(' ', '', $this->input->post('number')), -4),
                'openpay_expiration_month' => substr(str_replace(' ', '', $this->input->post('expiry')), 0, 2),
                'openpay_expiration_year' => substr(str_replace(' ', '', $this->input->post('expiry')), -2),
                'fecha_registro' => date('Y-m-d H:i:s'),
            );

            if($this->tarjetas_model->insert_tarjeta($data_tarjeta)){
                $this->session->set_flashdata('MENSAJE_EXITO', 'Se ha registrado el método de pago.');
                redirect('usuario/shop/proceder_pago/'.$id.'/'.$this->db->insert_id());
            } else {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. (02)');
                redirect($data['regresar_a']);
            }

            $this->construir_private_usuario_ui('usuario/shop/seleccionar_metodo', $data);
        }

    }

    public function proceder_pago($id = null, $tarjeta = null)
    {
        $this->form_validation->set_rules('id', 'Plan seleccionado', 'required');
        /*
        $this->form_validation->set_rules('name', 'Nombre en la tarjeta', 'required');
        $this->form_validation->set_rules('number', 'Número de tarjeta', 'required');
        $this->form_validation->set_rules('cvc', 'Código de verificación', 'required');
        $this->form_validation->set_rules('expiry', 'Fecha de vencimiento', 'required');
        */

        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tarjeta = $this->input->post('tarjeta');
        }

        if (!$tarjeta) {
            $data['controlador'] = 'usuario/shop/proceder_pago/'.$id;
        } else {
            $data['controlador'] = 'usuario/shop/proceder_pago/'.$id.'/'.$tarjeta;
        }

        $data['regresar_a'] = 'usuario/shop/seleccionar_metodo/'.$id;

        $data['menu_usuario_shop_activo'] = true;
		$data['pagina_titulo'] = 'Seleccionar método de pago';
		
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

		$controlador_js = "usuario/shop/seleccionar_metodo";

		$data['styles'] = array(
        );
        $data['scripts'] = array(

            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/card/jquery.card.js'),
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        $validar_suscripcion_row = $this->planes_model->get_plan_de_suscripcion_para_venta_por_id($id)->row();

        if (!$validar_suscripcion_row AND $validar_suscripcion_row != $id) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer el plan seleccionado no está disponible, por favor intente con otro.');
            redirect($data['regresar_a']);
        }
        
        $tarjetas_registradas_list = $this->tarjetas_model->get_tarjetas_por_usuario_id($this->session->userdata('id'));

        if ($tarjetas_registradas_list->num_rows() <= 0){
            $this->session->set_flashdata('MENSAJE_INFO', 'Para proceder con el pago es necesario registrar un método de pago.');
            redirect($data['regresar_a']);
        }

        $data['tarjeta'] = $tarjeta;
        $data['tarjetas_registradas_list'] = $tarjetas_registradas_list;
        $data['suscripcion_row'] = $validar_suscripcion_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_usuario_ui('usuario/shop/proceder_pago', $data);
        } else {
            $metodo_de_pago_seleccionado = $this->tarjetas_model->get_tarjeta_id_por_usuario_id($this->input->post('metodo_pago'), $this->session->userdata('id'))->row();

            /** Validamos que la tarjeta seleccionada sea realmente de este usuario. */
            if ($metodo_de_pago_seleccionado) {

                $datos_del_usuario_row = $this->usuarios_model->obtener_usuario_por_id($this->session->userdata('id'))->row();

                if (!$datos_del_usuario_row AND !$datos_del_usuario_row->openpay_cliente_id) {
                    $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. (01)');
                    redirect($data['regresar_a']);
                }

                $this->load->library('openpagos');
            
                $respuesta_openpay = $this->openpagos->crear_una_nueva_suscripcion_en_openpay($validar_suscripcion_row->openpay_plan_id, $metodo_de_pago_seleccionado->openpay_tarjeta_id, $datos_del_usuario_row->openpay_cliente_id);

                if (!$respuesta_openpay) {
                    // Ocurrió un error
                    $this->session->set_flashdata('MENSAJE_ERROR',  'Error al crear un nuevo cliente en OpenPay.');
                    redirect($data['controlador']);

                } 
                if (preg_match('/ERROR/i', $respuesta_openpay)) {
                    $this->session->set_flashdata('MENSAJE_ERROR',  $respuesta_openpay);
                    redirect($data['controlador']);
                }
                
                $openpay_suscripcion_id = $respuesta_openpay->id;

                $disciplinas = $this->planes_model->obtener_disciplinas_por_plan_id($validar_suscripcion_row->id)->result();
                $disciplinasIds = array();

                foreach ($disciplinas as $key => $value) {
                    array_push($disciplinasIds, $value->disciplina_id);
                }

                /** Se crean y validan todos los arreglos de datos a guardar. */
                $data_asignacion = array(
                    'usuario_id' => $this->session->userdata('id'),
                    'plan_id' => $validar_suscripcion_row->id,
                    'openpay_suscripcion_id' => $openpay_suscripcion_id,
                    'openpay_cliente_id' => $datos_del_usuario_row->openpay_cliente_id,
                    'openpay_tarjeta_id' => $metodo_de_pago_seleccionado->openpay_tarjeta_id,
                    'openpay_plan_id' => $validar_suscripcion_row->openpay_plan_id,
                    'nombre' => $validar_suscripcion_row->nombre,
                    'clases_incluidas' => $validar_suscripcion_row->clases_incluidas,
                    'disciplinas' => implode('|', $disciplinasIds),
                    'categoria' => 'suscripcion',
                    'vigencia_en_dias' => $validar_suscripcion_row->vigencia_en_dias,
                    'esta_activo' => '1',
                    'fecha_activacion' => date('Y-m-d H:i:s'),
                    'suscripcion_estatus_del_pago' => 'prueba',

                );

                if ($data_asignacion) {

                    /** Creamos la asignación del plan al usuario. */
                    if ($this->asignaciones_model->crear($data_asignacion)) {

                        $obetener_id_asignacion = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();

                        /** Se crean y validan todos los arreglos de datos a guardar. */
                        $data_venta = array(
                            'concepto' => $validar_suscripcion_row->nombre,
                            'usuario_id' => $this->session->userdata('id'),
                            'asignacion_id' => $obetener_id_asignacion->id,
                            'metodo_id' => 7,
                            'costo' => $validar_suscripcion_row->costo,
                            'cantidad' => 1,
                            'total' => 0,
                            'estatus' => 'prueba',
                            'vendedor' => 'Sistema de suscripciones',
                        );

                        if ($data_venta) {
                            /** Creamos la venta del plan al usuario. */
                            if ($this->ventas_model->crear($data_venta)) {

                                $this->session->set_flashdata('MENSAJE_EXITO', 'Compra realizada con éxito, ahora puedes disfrutar de tus clases en línea.');
                                redirect('usuario/shop/confirmacion/'.$obetener_id_asignacion->id);

                            } else {

                                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. (05)');
                                redirect($data['regresar_a']);

                            }
                        } else {

                            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. (04)');
                            redirect($data['regresar_a']);
                            
                        }
                    } else {

                        $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. (03)');
                        redirect($data['regresar_a']);
                    }
                } else {

                    $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. (02)');
                    redirect($data['regresar_a']);
                }
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. (01)');
                redirect($data['regresar_a']);
            }
            
            $this->construir_private_usuario_ui('usuario/shop/proceder_pago', $data);
        }
    }

    public function actualizar_sub()
    {
        $this->load->library('openpagos');
            
        $respuesta_openpay = $this->openpagos->actualizar_una_suscripcion();

        $data['resultado'] = $respuesta_openpay;

        $this->construir_private_usuario_ui('usuario/shop/actualizar_sub', $data);

    }

    public function confirmacion($id = null)
    {

        if ($this->input->post()) {
			$id = $this->input->post('id');
		}
		
		$data['menu_usuario_comprar_plan_activo'] = true;
        $data['pagina_titulo'] = 'Comprar Plan';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $asignacion = $this->asignaciones_model->obtener_por_id($id)->row();

        $data['asignacion'] = $asignacion;
        
        $this->construir_private_usuario_ui('usuario/shop/confirmacion', $data);
    }
}
