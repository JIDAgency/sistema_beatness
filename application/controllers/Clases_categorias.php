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
        $this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
        $this->form_validation->set_rules('cupo', 'Cupo', 'required');
        $this->form_validation->set_rules('inicia_date', 'Fecha', 'required');
        $this->form_validation->set_rules('inicia_time', 'Hora', 'required');
        $this->form_validation->set_rules('intervalo_horas', 'Intervalo en horas', 'required');
        $this->form_validation->set_rules('distribucion_lugares', 'Distribución de lugares', 'required');
        //$this->form_validation->set_rules('dificultad', 'Dificultad', 'required');

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        if ($this->form_validation->run() == false) {

            $clase_a_editar = $this->clases_categorias_model->obtener_por_id($id)->row();

            if (!$clase_a_editar) {
                $this->session->set_flashdata('MENSAJE_INFO', 'La clase que intenta editar no existe.');
                redirect('clases/index');
            }

            $data['clase_a_editar'] = $clase_a_editar;

            $this->construir_private_site_ui('clases_categorias/editar', $data);
        } else {
            // Preparar los datos a insertar
            // log_message('debug', print_r($this->input->post(), true));

            $disciplina = $this->disciplinas_model->obtener_por_id($this->input->post('disciplina_id'))->row();
            $instructor = $this->usuarios_model->obtener_instructor_por_id($this->input->post('instructor_id'))->row();

            $valor = $disciplina->nombre;
            // Separar la cadena en palabras
            $palabras = explode(' ', $valor);

            // Obtener la primera palabra
            $primera_palabra = $palabras[0];

            // Obtener las dos primeras letras de la primera palabra
            $primeras_dos_letras = substr($primera_palabra, 0, 2);

            // Obtener la última letra de la primera palabra
            $ultima_letra = substr($primera_palabra, -1);

            // Concatenar las letras para formar la nueva cadena
            $cadena_resultante = $primeras_dos_letras . $ultima_letra;

            $valor1 = $cadena_resultante;

            $valor2 = $instructor->nombre; // Suponiendo que estás obteniendo el valor del select mediante un formulario POST
            // Eliminar caracteres acentuados y especiales
            $valor2 = preg_replace('/(á|é|í|ó|ú|ñ|ä|ë|ï|ö|\.|ü)/iu', '', $valor2);
            // Conservar solo la primera letra de cada palabra y convertirla a mayúsculas
            $valor2 = preg_replace_callback('/[A-Za-z]+/iu', function ($match) {
                return strtoupper(trim($match[0])[0]);
            }, $valor2);
            // Eliminar espacios en blanco
            $valor2 = preg_replace('/\s/', '', $valor2);

            $valor3 = $this->input->post('inicia_date');
            $valor3 = preg_replace('/\D/', '', $valor3);

            $valor4 = $this->input->post('inicia_time');
            $valor4 = preg_replace('/\D/', '', $valor4);

            $valor5 = $this->input->post('dificultad');
            $valor5 = preg_replace('/(á|é|í|ó|ú|ñ|ä|ë|ï|ö|\.|ü)/iu', '', $valor5);
            $valor5 = substr($valor5, 0, 2);

            $valor5 = $this->input->post('dificultad');
            $acentos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
            $sin_acentos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
            $valor5 = str_replace($acentos, $sin_acentos, $valor5);
            $valor5 = strtoupper(substr($valor5, 0, 2));

            $identificador = $valor1 . $valor2 . $valor3 . $valor4 . '00' . $valor5;

            $clase_existente = $this->clases_model->obtener_clase_por_identificador_para_sku($identificador)->row();

            if ($clase_existente and ($clase_existente->intervalo_horas == $this->input->post('intervalo_horas')) and ($clase_existente->distribucion_imagen == $this->input->post('distribucion_imagen')) and ($clase_existente->distribucion_lugares == $this->input->post('distribucion_lugares'))) {
                $this->session->set_flashdata('MENSAJE_INFO', 'La clase con los nuevos datos ya existe.');
                redirect('clases/index');
            } else {
                $hora_de_incio = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time');
                $fecha_numerica_de_la_clase = date(DATE_ISO8601, strtotime($hora_de_incio));

                $data = array(
                    'identificador' => $identificador,
                    'disciplina_id' => $this->input->post('disciplina_id'),
                    //'disciplina_id' => $disciplina_id,
                    //'subdisciplina_id' => $subdisciplina_id,
                    'instructor_id' => $this->input->post('instructor_id'),
                    'cupo' => $this->input->post('cupo'),
                    'inicia' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time'),
                    'inicia_ionic' => $fecha_numerica_de_la_clase,
                    'intervalo_horas' => $this->input->post('intervalo_horas'),
                    'distribucion_imagen' => $this->input->post('distribucion_imagen'),
                    'distribucion_lugares' => $this->input->post('distribucion_lugares'),
                    'dificultad' => $this->input->post('dificultad'),
                );

                // Insertar nueva disciplina
                if ($this->clases_model->editar($id, $data)) {
                    $this->session->set_flashdata('MENSAJE_EXITO', 'La clase se ha editado correctamente.');
                    redirect('clases/index');
                }

                // Si algo falla regresar a la vista de editar
                $this->construir_private_site_ui('clases/editar', $data);
            }
        }
    }
}
