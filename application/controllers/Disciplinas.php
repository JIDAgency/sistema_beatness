<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Disciplinas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('disciplinas_model');
        $this->load->model('sucursales_model');
    }

    public function index()
    {
        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => 'disciplinas/index.js'),
        );

        $data['menu_wrokflow_activo'] = true;
        $data['pagina_titulo'] = 'Disciplinas';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $this->construir_private_site_ui('disciplinas/index', $data);
    }

    /** Metodos para formato JSON de las datatables */

    /** JSON encoder para la tabla de clientes */
    public function load_lista_de_todas_las_disciplinas_para_datatable()
    {
        $disciplinas_list = $this->disciplinas_model->get_lista_de_todas_las_disciplinas_limitada()->result();

        $result = array();

        foreach ($disciplinas_list as $disciplina_row) {

            $menu = '<a href="' . site_url("disciplinas/editar/") . $disciplina_row->listar_id . '">Editar</a>';

            $result[] = array(
                "listar_id" => $disciplina_row->listar_id,
                "listar_gympass_product_id" => $disciplina_row->listar_gympass_product_id,
                "listar_nombre" => $disciplina_row->listar_nombre,
                "listar_sucursal" => $disciplina_row->listar_sucursal,
                "listar_es_ilimitado" => $disciplina_row->es_ilimitado,
                "listar_mostrar_app" => $disciplina_row->mostrar_en_app,
                "listar_mostrar_web" => $disciplina_row->mostrar_en_web,
                "listar_estatus" => $disciplina_row->listar_estatus,
                "listar_opciones" => $menu
            );
        }
        echo json_encode(array("data" => $result));
    }

    public function crear()
    {
        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la disciplina', 'required');
        $this->form_validation->set_rules('url_banner', 'banner', 'required');
        $this->form_validation->set_rules('url_titulo', 'titulo', 'required');
        $this->form_validation->set_rules('url_logo', 'logo', 'required');
        $this->form_validation->set_rules('sucursal_id', 'sucursal', 'required');
        $this->form_validation->set_rules('ilimitado', 'ilimitado', 'required');
        $this->form_validation->set_rules('mostrar_app', 'mostrar_app', 'required');
        $this->form_validation->set_rules('mostrar_web', 'mostrar_web', 'required');
        $this->form_validation->set_rules('estatus', 'estatus', 'required');
        $this->form_validation->set_rules('formato', 'formato', 'required');
        $this->form_validation->set_rules('gympass_gym_id', 'gympass_gym_id');

        // Inicializar vista, scripts
        $data['menu_wrokflow_activo'] = true;
        $data['pagina_titulo'] = 'Crear disciplina';

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'disciplinas/crear.js'),

        );

        $sucursales_list = $this->sucursales_model->get_todas_las_sucursales()->result();

        $data['sucursales_list'] = $sucursales_list;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('disciplinas/crear', $data);
        } else {
            // Preparar datos para hacer el insert en la bd
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'url_banner' => $this->input->post('url_banner'),
                'url_titulo' => $this->input->post('url_titulo'),
                'url_logo' => $this->input->post('url_logo'),
                'sucursal_id' => $this->input->post('sucursal_id'),
                'formato' => $this->input->post('formato'),
                'es_ilimitado' => $this->input->post('ilimitado'),
                'mostrar_en_app' => $this->input->post('mostrar_app'),
                'mostrar_en_web' => $this->input->post('mostrar_web'),
                'estatus' => $this->input->post('estatus'),
                'gympass_product_id' => $this->input->post('gympass_product_id'),
            );

            if ($this->disciplinas_model->crear($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La disciplina se ha creado correctamente.');
                redirect('disciplinas/index');
            }

            $this->construir_private_site_ui('disciplinas/crear', $data);
        }
    }

    public function editar($id = null)
    {

        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la disciplina', 'required');
        $this->form_validation->set_rules('url_banner', 'banner', 'required');
        $this->form_validation->set_rules('url_titulo', 'titulo', 'required');
        $this->form_validation->set_rules('url_logo', 'logotipo', 'required');
        $this->form_validation->set_rules('sucursal_id', 'sucursal', 'required');
        $this->form_validation->set_rules('ilimitado', 'ilimitado', 'required');
        $this->form_validation->set_rules('mostrar_app', 'mostrar_app', 'required');
        $this->form_validation->set_rules('mostrar_web', 'mostrar_web', 'required');
        $this->form_validation->set_rules('estatus', 'estatus', 'required');
        $this->form_validation->set_rules('formato', 'formato', 'required');
        $this->form_validation->set_rules('gympass_product_id', 'gympass_product_id');

        // Inicializar vista, scripts y catálogos
        $data['menu_wrokflow_activo'] = true;
        $data['pagina_titulo'] = 'Editar disciplina';
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'disciplinas/editar.js'),

        );

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        if ($this->form_validation->run() == false) {

            // Verificar que la membresía a editar exista, obtener sus datos y pasarlos a la vista
            $disciplina_a_editar_row = $this->disciplinas_model->obtener_por_id($id)->row();

            $sucursales_list = $this->sucursales_model->get_todas_las_sucursales()->result();

            $data['sucursales_list'] = $sucursales_list;

            if (!$disciplina_a_editar_row) {
                $this->session->set_flashdata('MENSAJE_INFO', 'La disciplina que intenta editar no existe.');
                redirect('/disciplinas/index');
            }

            $data['disciplina_a_editar_row'] = $disciplina_a_editar_row;

            $this->construir_private_site_ui('disciplinas/editar', $data);
        } else {

            $data = array(
                'nombre' => $this->input->post('nombre'),
                'url_banner' => $this->input->post('url_banner'),
                'url_titulo' => $this->input->post('url_titulo'),
                'url_logo' => $this->input->post('url_logo'),
                'sucursal_id' => $this->input->post('sucursal_id'),
                'formato' => $this->input->post('formato'),
                'es_ilimitado' => $this->input->post('ilimitado'),
                'mostrar_en_app' => $this->input->post('mostrar_app'),
                'mostrar_en_web' => $this->input->post('mostrar_web'),
                'estatus' => $this->input->post('estatus'),
                'gympass_product_id' => $this->input->post('gympass_product_id'),

            );


            if ($this->disciplinas_model->editar($id, $data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La disciplina se ha editado correctamente.');
                redirect('/disciplinas/index');
            }

            $this->construir_private_site_ui('disciplinas/editar', $data);
        }
    }
}
