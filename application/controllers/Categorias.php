<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categorias extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('clases_model');
        $this->load->model('disciplinas_model');
        $this->load->model('usuarios_model');
        $this->load->model('asignaciones_model');
        $this->load->model('reservaciones_model');
        $this->load->model('clases_en_linea_model');
        $this->load->model('categorias_model');
        $this->load->model('sucursales_model');
    }

    public function index()
    {
        $data['menu_instructores_activo'] = true;
        $data['pagina_titulo'] = 'Lista de disciplinas-categorias';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
        $controlador_js = "categorias/index";

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('categorias/index', $data);
    }

    public function obtener_tabla_index()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $categorias_list = $this->categorias_model->get_categorias();

        $data = [];

        foreach ($categorias_list->result() as $categoria) {

            $opciones = '<a href="' . site_url("categorias/editar/") . $categoria->id . '">Editar</a>';

            $data[] = array(
                'id' => $categoria->id,
                'gympass_class_id' => !empty($categoria->gympass_class_id) ? $categoria->gympass_class_id : '',
                'gympass_product_id' => $categoria->gympass_product_id,
                'gympass_gym_id' => !empty($categoria->gympass_gym_id) ? ucwords($categoria->gympass_gym_id) : '',
                'disciplina' => !empty($categoria->disciplina_id) ? ucwords($categoria->disciplina_id) : '',
                'nombre' => !empty($categoria->nombre) ? ucfirst($categoria->nombre) : '',
                'descripcion' => !empty($categoria->descripcion) ? $categoria->descripcion : '',
                'notas' => !empty($categoria->notas) ? ucfirst($categoria->notas) : '',
                'reservable' => !empty($categoria->reservable) ? mb_strtoupper($categoria->reservable) : '',
                'visible' => !empty($categoria->visible) ? mb_strtoupper($categoria->visible) : '',
                'virtual' => !empty($categoria->virtual) ? mb_strtoupper($categoria->virtual) : '',
                'fecha_registro' => (!empty($categoria->fecha_registro) ? date('Y/m/d H:i:s', strtotime($categoria->fecha_registro)) : ''),
                'opciones' => $opciones,
            );
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $categorias_list->num_rows(),
            'recordsFiltered' => $categorias_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    public function crear()
    {
        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la categoria', 'required');
        $this->form_validation->set_rules('descripcion', 'descripcion', 'required');
        $this->form_validation->set_rules('notas', 'notas', 'required');
        $this->form_validation->set_rules('reservable', 'reservable', 'required');
        $this->form_validation->set_rules('visible', 'visible', 'required');
        $this->form_validation->set_rules('virtual', 'virtual', 'required');
        $this->form_validation->set_rules('disciplina_id', 'Disciplina', 'required');

        // Inicializar vista, scripts
        $data['menu_instructores_activo'] = true;
        $data['pagina_titulo'] = 'Crear categoria';

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'categorias/crear.js'),

        );

        // Validar que existan disciplinas disponibles
        $disciplinas = $this->disciplinas_model->get_lista_de_disciplinas_para_crear_y_editar_clases();

        if ($disciplinas->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect('clases/index');
        }

        $data['disciplinas'] = $disciplinas;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('categorias/crear', $data);
        } else {
            // Preparar datos para hacer el insert en la bd
            $data = array(
                'gympass_class_id' => 1000000000001,
                'gympass_product_id' => $this->input->post('disciplina_id'),
                'gympass_gym_id' => '60',
                'disciplina_id' => $this->input->post('disciplina_id'),
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'notas' => $this->input->post('notas'),
                'reservable' => $this->input->post('reservable'),
                'visible' => $this->input->post('visible'),
                'virtual' => $this->input->post('virtual'),
            );

            if ($this->categorias_model->crear($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La categoria se ha creado correctamente.');
                redirect('categorias/index');
            }

            $this->construir_private_site_ui('categorias/crear', $data);
        }
    }

    public function editar($id = null)
    {
         // Establecer validaciones
         $this->form_validation->set_rules('nombre', 'nombre de la categoria', 'required');
         $this->form_validation->set_rules('descripcion', 'descripcion', 'required');
         $this->form_validation->set_rules('notas', 'notas', 'required');
         $this->form_validation->set_rules('reservable', 'reservable', 'required');
         $this->form_validation->set_rules('visible', 'visible', 'required');
         $this->form_validation->set_rules('virtual', 'virtual', 'required');
        $this->form_validation->set_rules('disciplina_id', 'Disciplina', 'required');

        // Inicializar vista, scripts y catálogos
        $data['menu_instructores_activo'] = true;
        $data['pagina_titulo'] = 'Editar categorias';
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'categorias/editar.js'),

        );

        $disciplinas = $this->disciplinas_model->get_lista_de_disciplinas_para_crear_y_editar_clases();

        if ($disciplinas->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect('clases/index');
        }

        $data['disciplinas'] = $disciplinas;

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        if ($this->form_validation->run() == false) {

            // Verificar que la membresía a editar exista, obtener sus datos y pasarlos a la vista
            $categoria_a_editar_row = $this->categorias_model->obtener_por_id($id)->row();

            $sucursales_list = $this->sucursales_model->get_todas_las_sucursales()->result();

            $data['sucursales_list'] = $sucursales_list;

            if (!$categoria_a_editar_row) {
                $this->session->set_flashdata('MENSAJE_INFO', 'La categoria que intenta editar no existe.');
                redirect('/categorias/index');
            }

            $data['categoria_a_editar_row'] = $categoria_a_editar_row;

            $this->construir_private_site_ui('categorias/editar', $data);
        } else {

            $data = array(
                'gympass_product_id' => $this->input->post('disciplina_id'),
                'disciplina_id' => $this->input->post('disciplina_id'),
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'notas' => $this->input->post('notas'),
                'reservable' => $this->input->post('reservable'),
                'visible' => $this->input->post('visible'),
                'virtual' => $this->input->post('virtual'),
            );


            if ($this->categorias_model->editar($id, $data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La categoria se ha editado correctamente.');
                redirect('/categorias/index');
            }

            $this->construir_private_site_ui('categorias/editar', $data);
        }
    }

    public function borrar($id = null)
    {
        $clase = $this->clases_model->obtener_por_id($id)->row();

        if (!$clase) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se han podido encontrar todas las clases que desea borrar.');
            redirect('clases/index');
        }

        if ($clase->reservado > 0) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La clase que intenta borrar ya tiene reservaciones hechas.');
            redirect('clases/index');
        }

        if ($this->clases_model->borrar($id)) {
            redirect('clases/index');
        }

        $this->session->set_flashdata('MENSAJE_ERROR', 'La clase ' . $id . ' no ha podido ser borrada.');
        redirect('clases/index');
    }
}
