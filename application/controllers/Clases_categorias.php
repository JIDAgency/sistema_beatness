<?php defined('BASEPATH') or exit('No direct script access allowed');

class Clases_categorias extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('codigos_model');
        $this->load->model('codigos_canjeados_model');
        $this->load->model('planes_model');
        $this->load->model('usuarios_model');
        $this->load->model('disciplinas_model');
        $this->load->model('clases_model');
        $this->load->model('clases_categorias_model');
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Categorias de clases';
        $data['pagina_menu_clases_categorias'] = true;

        $data['controlador'] = 'clases_categorias';
        $data['regresar_a'] = 'inicio';
        $controlador_js = 'clases_categorias/index';

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('clases_categorias/index', $data);
    }

    public function obtener_tabla_index()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $clases_list = $this->clases_categorias_model->obtener_todas();
        $data = [];

        foreach ($clases_list->result() as $clase) {

            $opciones = '';
            $opciones .= anchor('clases_categorias/editar/' . $clase->id, 'Editar');
            // $opciones .= '<a href="' . site_url('clases/duplicar_clase/' . $clase->id) . '"><span>Duplicar</span></a>';
            // $opciones .= ' | ';
            // $opciones .= '<a href="" class="clonar-row" data-id="' . $clase->id . '"><span>Duplicar</span></a>';
            $opciones .= '  |  ';
            $opciones .= '<a href="" class="delete-row" data-id="' . $clase->id . '"><span class="red">Borrar</span></a>';

            $data[] = array(
                'id' => $clase->id,
                'disciplina_id' => $clase->disciplina_id,
                'gympass_id' => !empty($clase->gympass_id) ? mb_strtoupper($clase->gympass_id) : '',
                'nombre' => !empty($clase->nombre) ? mb_strtoupper($clase->nombre) : '',
                'descripcion' => !empty($clase->descripcion) ? ($clase->descripcion) : '',
                'nota' => !empty($clase->nota) ? ucfirst($clase->nota) : '',
                'estatus' => !empty($clase->estatus) ? ucwords($clase->estatus) : '',
                'opciones' => $opciones,
            );
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $clases_list->num_rows(),
            'recordsFiltered' => $clases_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    public function crear()
    {
        // Validar que existan usuarios en el rol de instructores
        $instructores = $this->usuarios_model->obtener_todos_instructores();

        if ($instructores->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos algún instructor registrado para poder crear la clase.');
            redirect('clases/index');
        }

        $data['instructores'] = $instructores;

        // Validar que existan disciplinas disponibles
        $disciplinas = $this->disciplinas_model->get_lista_de_disciplinas_para_crear_y_editar_clases();

        if ($disciplinas->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect('clases/index');
        }

        $data['disciplinas'] = $disciplinas;
        $data['gympass'] = $disciplinas;

        $data['pagina_menu_clases_categorias'] = true;
        $data['pagina_titulo'] = 'Nueva categoria de clase';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/timedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/timedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => 'clases_categorias/crear.js'),
        );

        // Establecer validaciones
        $this->form_validation->set_rules('disciplina_id', 'Disciplina', 'required');
        // $this->form_validation->set_rules('gympass_id', 'Gympass', 'required');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
        $this->form_validation->set_rules('nota', 'Nota', 'required');
        $this->form_validation->set_rules('estatus', 'Estatus', 'required');

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('clases_categorias/crear', $data);
        } else {

            $fecha_registro = date("Y-m-d H:i:s");
            $fecha = date("Y-m-d-H-i-s", strtotime($fecha_registro));

            $cupo_lugares = array();
            // Crear un arreglo de arreglos para llevar un registro mas detallado del cupo
            // {"id":1712,"name":"BÁSICO","slug":"basico","description":"Clase orientada a principiantes que cubre los fundamentos del ejercicio y el entrenamiento físico.","notes":"Perfecto para aquellos que están comenzando su viaje de fitness. Las clases son de 1 hora.","bookable":true,"visible":true,"product_id":120,"gym_id":60,"reference":"1","created_at":"2024-04-30T00:26:08Z[UTC]","system_id":81}
            $gympass = array(
                'id' => '',
                'name' => $this->input->post('nombre'),
                'slug' => strtolower($this->input->post('nombre')),
                'description' => $this->input->post('descripcion'),
                'notes' => $this->input->post('nota'),
                'bookable' => true,
                'visible' => true,
                'product_id' => '120',
                'gym_id' => '60',
                'reference' => '',
                'created_at' => strval($fecha_registro),
                'system_id' => '81',
            );

            array_push($gympass);

            $gympass_json = json_encode($gympass);
            // Preparar los datos a insertar
            $data = array(
                'disciplina_id' => $this->input->post('disciplina_id'),
                // 'gympass_id' => $this->input->post('gympass_id'),
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'nota' => $this->input->post('nota'),
                'gympass_json' => $gympass_json,
                'estatus' => $this->input->post('estatus'),
            );

            if ($this->clases_categorias_model->crear($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La clase se ha creado correctamente.');
                redirect('clases_categorias/index');
            }

            // Si algo falla regresar a la vista de crear
            $this->construir_private_site_ui('clases_categorias/crear', $data);
        }
    }

    public function editar($id = null)
    {
        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Validar que existan disciplinas disponibles
        $disciplinas = $this->disciplinas_model->get_lista_de_disciplinas_para_crear_y_editar_clases();

        if ($disciplinas->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect('clases_categorias/index');
        }

        $data['disciplinas'] = $disciplinas;

        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Editar categoria de clase';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/timedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/timedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => 'clases_categorias/editar.js'),
        );

        // Establecer validaciones
        $this->form_validation->set_rules('disciplina_id', 'Disciplina', 'required');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
        $this->form_validation->set_rules('nota', 'Nota', 'required');
        $this->form_validation->set_rules('estatus', 'Estatus', 'required');
        //$this->form_validation->set_rules('dificultad', 'Dificultad', 'required');

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        if ($this->form_validation->run() == false) {

            $clase_a_editar = $this->clases_categorias_model->obtener_por_id($id)->row();

            if (!$clase_a_editar) {
                $this->session->set_flashdata('MENSAJE_INFO', 'La clase que intenta editar no existe.');
                redirect('clases_categorias/index');
            }

            $data['clase_a_editar'] = $clase_a_editar;

            $this->construir_private_site_ui('clases_categorias/editar', $data);
        } else {
            // Preparar los datos a insertar
            // log_message('debug', print_r($this->input->post(), true));

            $data = array(
                'disciplina_id' => $this->input->post('disciplina_id'),
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'nota' => $this->input->post('nota'),
                'estatus' => $this->input->post('estatus'),
            );

            // Insertar nueva disciplina
            if ($this->clases_categorias_model->editar($id, $data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La clase se ha editado correctamente.');
                redirect('clases_categorias/index');
            }

            // Si algo falla regresar a la vista de editar
            $this->construir_private_site_ui('clases_categorias/editar', $data);
        }
    }

    public function borrar($id = null)
    {
        $clase = $this->clases_model->obtener_por_id($id)->row();

        if (!$clase) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se han podido encontrar todas las clases que desea borrar.');
            redirect('clases_categorias/index');
        }

        if ($clase->reservado > 0) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La clase que intenta borrar ya tiene reservaciones hechas.');
            redirect('clases_categorias/index');
        }

        $result = $this->clases_model->borrar($id);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        // $this->session->set_flashdata('MENSAJE_ERROR', 'La clase ' . $id . ' no ha podido ser borrada.');
        // redirect('clases_categorias/index');
    }
}
