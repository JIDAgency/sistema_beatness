<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require_once APPPATH . 'third_party/vendor/autoload.php';
require APPPATH . 'third_party/vendor/openpay/sdk/Openpay.php';

class Comprar extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('planes_model');
        $this->load->model('usuarios_model');
        $this->load->model('asignaciones_model');
        $this->load->model('ventas_model');
    }

    public function index($id = null)
    {
        // Cargar estilos y scripts
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'),
            array('es_rel' => false, 'src' => 'https://openpay.s3.amazonaws.com/openpay.v1.min.js'),
            array('es_rel' => false, 'src' => 'https://openpay.s3.amazonaws.com/openpay-data.v1.min.js'),
            array('es_rel' => true, 'src' => 'openpay/openpay.js'),
        );

        $data['planes'] = $this->planes_model->obtener_por_id($id)->result();
        $data['menu_usuario_comprar_activo'] = true;
        $data['pagina_titulo'] = 'Pagar con Openpay';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Validar que el plan a pagar y el usuario que lo va a pagar existan en la base de datos
        if ($id) {
            $plan_id = $id;
        } else {
            $plan_id = $this->input->post('plan_id');
        }

        // Se asumirá que el usuario que está en sesión es el comprador; a pesar que utilice una tarjeta
        // de la que no es propietario
        //AQUI ESTA LA FALLA
        $usuario_id = $this->session->userdata['id'];

        $plan_a_comprar = $this->planes_model->obtener_por_id($plan_id)->row();
		$comprador = $this->usuarios_model->obtener_usuario_por_id($usuario_id)->row();


        if (!$plan_a_comprar || !$comprador) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'El plan a comprar o el comprador que intenta realizar la compra no existen más en la base de datos.');
            redirect('usuario/comprar_planes');
        }

        if ($id) {
            $data['plan_id'] = $plan_a_comprar->id;
            $this->construir_private_usuario_ui('usuario/comprar_planes_pagoopenpay', $data);
        } else {

            // Obtener las disciplinas que el plan a comprar tiene para así saber de cuáles disciplinas tiene derecho
            // el comprador de reservar clases
            $disciplinas = $this->planes_model->obtener_disciplinas_por_plan_id($plan_a_comprar->id)->result();
            $disciplinasIds = array();

            foreach ($disciplinas as $key => $value) {
                array_push($disciplinasIds, $value->disciplina_id);
            }

            $this->load->library('openpagos');
            $this->openpagos->cargar_datos_comprador($comprador->nombre_completo, $comprador->correo, $comprador->apellido_paterno);

            $resultado_openpay = $this->openpagos->aplicar_cargo_con_tarjeta($this->input->post('token_id'), $plan_a_comprar->costo, $plan_a_comprar->nombre, $this->input->post('deviceIdHiddenFieldName'));

            if (!$resultado_openpay) {
                // Ocurrió un error
                $this->session->set_flashdata('MENSAJE_ERROR',  'Error al realizar la compra.');
                redirect('usuario/comprar_planes');
    
            }

            if ($resultado_openpay['error']) {
            // Ocurrió un error
            $this->session->set_flashdata('MENSAJE_ERROR',  $resultado_openpay['mensaje']);
            redirect('usuario/comprar_planes');

            }

            // Agregar plan al usuario
            $this->asignaciones_model->crear(array(
                'usuario_id' => $comprador->id,
                'plan_id' => $plan_a_comprar->id,
                'nombre' => $plan_a_comprar->nombre,
                'clases_incluidas' => $plan_a_comprar->clases_incluidas,
                'disciplinas' => implode('|', $disciplinasIds),
				'vigencia_en_dias' => $plan_a_comprar->vigencia_en_dias,
                'esta_activo' => '1',
                'fecha_activacion' => date('Y-m-d H:i:s'),
            ));

            $obetener_id_asignacion = $this->asignaciones_model->obtener_por_id($this->db->insert_id())->row();

             // Registrar la venta
             $this->ventas_model->crear(array(
                 'concepto' => $plan_a_comprar->nombre,
                 'usuario_id' => $comprador->id,
                 'asignacion_id' => $obetener_id_asignacion->id,
                 'metodo_id' => 3,
                 'costo' => $plan_a_comprar->costo,
                 'cantidad' => 1,
                 'total' => $plan_a_comprar->costo,
                 'vendedor' => 'Compra desde el sitio web',
             ));

            redirect('usuario/comprar_planes_confirmarpago');

        }

    }

    public function suscripcion($id = null)
    {
        $data['menu_usuario_comprar_suscripcion_activo'] = true;
        $data['pagina_titulo'] = 'Pagar con Openpay';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Cargar estilos y scripts
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'),
            array('es_rel' => false, 'src' => 'https://openpay.s3.amazonaws.com/openpay.v1.min.js'),
            array('es_rel' => false, 'src' => 'https://openpay.s3.amazonaws.com/openpay-data.v1.min.js'),
            array('es_rel' => true, 'src' => 'openpay/openpay.js'),
        );

        $this->load->config('openpagos');
        
        $openpay = Openpay::getInstance($this->config->item('comercio_id'), $this->config->item('llave_privada'));

        Openpay::setProductionMode($this->config->item('establecer_modo_produccion'));

        $findDataRequest = array(
            'creation[gte]' => '2020-01-01',
            'creation[lte]' => '2020-06-11',
            'offset' => 0,
            'limit' => 100
        );
        
        $customerList = $openpay->customers->getList($findDataRequest);
        
        /** Eliminar un cliente */
        //$customer = $openpay->customers->get('ahv4lvm8uinbe9bxokqa');
        //$customer->delete();

        /** Registrar Clientes */
        /*$customerData = array(
            'external_id' => '1',
            'name' => 'customer name',
            'last_name' => '',
            'email' => 'customer_email@me.com',
            'requires_account' => false,
            'phone_number' => '44209087654',
            'address' => array(
                'line1' => 'Calle 10',
                'line2' => 'col. san pablo',
                'line3' => 'entre la calle 1 y la 2',
                'state' => 'Queretaro',
                'city' => 'Queretaro',
                'postal_code' => '76000',
                'country_code' => 'MX'
             )
          );
       
        $customer = $openpay->customers->add($customerData);*/

        $cardDataRequest = array(
            'holder_name' => 'Mi cliente uno',
            'card_number' => '4111111111111111',
            'cvv2' => '123',
            'expiration_month' => '12',
            'expiration_year' => '15');
        
        $customer = $openpay->customers->get('aywlgeg8frxmtcafk4qi');
        $card = $customer->cards->add($cardDataRequest);

        $data['customerList'] = $customerList;

        $this->construir_private_usuario_ui('usuario/comprar_suscripcion', $data);
    }
}
