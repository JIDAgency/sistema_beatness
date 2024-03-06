<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pre_registro extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->config->load('b3studio', true);

        $this->load->model('colaboradores_sucursales_model');

        $this->load->library('facebook');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('email');

        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('string');

        $this->load->database();
        $this->load->model("usuarios_model");

        redirect(base_url());
    }

    public function index()
    {
		$data['pagina_titulo'] = 'Insan3 | Pre-registro';

		$data['controlador'] = 'pre_registro/index';
		$data['regresar_a'] = 'pre_registro';
		$controlador_js = "pre_registro/index";

		$data['styles'] = array(
		);
		$data['scripts'] = array(
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        // Establecer validaciones
        $this->form_validation->set_rules('correo', 'Correo electrónico', 'trim|required|valid_email|max_length[100]|matches[verificar_correo]');
        $this->form_validation->set_rules('verificar_correo', 'Verificar correo electrónico', 'required');
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'required|matches[verificar_contrasena]|min_length[8]');
        $this->form_validation->set_rules('verificar_contrasena', 'Confirmar contraseña', 'required');
        $this->form_validation->set_rules('no_telefono', 'Teléfono celular', 'trim|required|min_length[10]');
        $this->form_validation->set_rules('nombre_completo', 'Nombre', 'required|max_length[50]');
        $this->form_validation->set_rules('apellido_paterno', 'Apellido Paterno', 'required|max_length[50]');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('pre_registro/index' ,$data);

        } else {

            if ($this->config->item('recaptcha_validar', 'b3studio')) {
                // Validar reCAPTCHA
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $this->config->item('recaptcha_api_url', 'b3studio'),
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => http_build_query(array(
                        'secret' => $this->config->item('recaptcha_secret', 'b3studio'),
                        'response' => $this->input->post('g-recaptcha-response'),
                    )),
                ));
                $respuesta_recatpcha = curl_exec($curl);
                log_message('debug', print_r($respuesta_recatpcha, true));
                if (curl_error($curl)) {
                    log_message('debug', print_r(curl_error($curl), true));
                }
                log_message('debug', print_r(curl_getinfo($curl), true));
                curl_close($curl);
            }

            $verificar_correo = $this->db->query('SELECT * FROM `usuarios` WHERE BINARY `correo` = ' . $this->db->escape($this->input->post('correo')) . ' AND `rol_id` IN (1,2,3,4,5,6)')->row();

            if (!$verificar_correo) {
                //$data['mensaje_info'] = '¡Oops!, Al parecer esta cuenta de correo ya ha sido registrada.';
                //$this->load->view('pre_registro/index' ,$data);


                $verificar_fecha_nacimiento = new DateTime($this->input->post('fecha_nacimiento'));

                $edad_limite = new DateTime('-13 years');
                if($verificar_fecha_nacimiento  >= $edad_limite){
                    $data['mensaje_info'] = '¡Oops!, Debes ser mayor de 13 años de edad.';
                    $this->load->view('pre_registro/index' ,$data);
                }

                // Preparar datos para hacer el insert en la bd
                $data = array(
                    'dominio' => 'insan3',
                    'notificacion_insan3' => 'si',
                    'correo' => $this->input->post('correo'),
                    'contrasena_hash' => password_hash($this->input->post('contrasena'), PASSWORD_DEFAULT),
                    'no_telefono' => str_replace(' ', '', $this->input->post('no_telefono')),
                    'nombre_completo' => $this->input->post('nombre_completo'),
                    'apellido_paterno' => $this->input->post('apellido_paterno'),
                    'apellido_materno' => $this->input->post('apellido_materno'),
                    'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_nacimiento')))),
                    'fecha_registro' => date('Y-m-d H:i:s'),
                    'rol_id' => $this->config->item('id_rol_cliente', 'b3studio'), // Los usuarios que se registren por si mismos desde la página serán, por defecto, usuarios de tipo 'cliente'
                );

                if ($this->db->insert('usuarios', $data)) {
                    redirect('pre_registro/proximamente');
                }
            } else {
                // Preparar datos para hacer el insert en la bd
                $data = array(
                    'no_telefono' => str_replace(' ', '', $this->input->post('no_telefono')),
                    'nombre_completo' => $this->input->post('nombre_completo'),
                    'apellido_paterno' => $this->input->post('apellido_paterno'),
                    'apellido_materno' => $this->input->post('apellido_materno'),
                    'notificacion_insan3' => 'si',
                    'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_nacimiento')))),
                );

                if ($this->db->where('id', $verificar_correo->id)->update('usuarios', $data)) {
                    redirect('pre_registro/proximamente/true');
                }
            }

            $data['mensaje_error'] = '¡Oops!, Al parecer ha ocurrido un error. Por favor inténtalo más tarde.';
            $this->load->view('pre_registro/index' ,$data);
        }    
    }
    
    public function proximamente($var = null)
    {   
        $data["var"] = $var;

        $this->load->view('pre_registro/proximamente' ,$data);
    }
}
