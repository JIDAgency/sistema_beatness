<?php
defined('BASEPATH') or exit('No direct script access allowed');

class comprar_planes_pagoopenpay extends MY_Controller
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
        $data['menu_usuario_comprar_planes_pagoopenpay_activo'] = true;
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

            redirect('usuario/shop/confirmacion/'.$obetener_id_asignacion->id);

        }

    }
}
