<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clases extends MY_Controller
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
        $this->load->model('filtros_model');
        $this->load->model('clases_categorias_model');
    }

    public function crear()
    {
        $data['pagina_titulo'] = 'Nueva clase';
        $data['pagina_subtitulo'] = 'Crear nueva clase';
        $data['pagina_clases'] = true;
        $data['menu_clases_activo'] = true;

        $data['controlador'] = 'clases/crear';
        $data['regresar_a'] = 'clases';
        $controlador_js = "clases/crear";

        // Obtener la semana actual (Lunes - Domingo)
        $current_week_start = new DateTime();
        $current_week_start->modify('monday this week');
        $current_week_end = clone $current_week_start;
        $current_week_end->modify('sunday this week');

        $current_week = $current_week_start->format('Y-m-d') . ' al ' . $current_week_end->format('Y-m-d');

        // Obtener la semana siguiente (Lunes - Domingo)
        $next_week_start = new DateTime();
        $next_week_start->modify('monday next week');
        $next_week_end = clone $next_week_start;
        $next_week_end->modify('sunday next week');

        $next_week = $next_week_start->format('Y-m-d') . ' al ' . $next_week_end->format('Y-m-d');

        // Pasar las semanas al select
        $data['weeks'] = [
            'actual' => $current_week,
            'siguiente' => $next_week
        ];

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/timedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/timedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        // Establecer validaciones
        $this->form_validation->set_rules('disciplina_id', 'Disciplina', 'required');
        $this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
        $this->form_validation->set_rules('cupo', 'Cupo', 'required');
        $this->form_validation->set_rules('inicia_date', 'Fecha', 'required');
        $this->form_validation->set_rules('inicia_time', 'Hora', 'required');
        $this->form_validation->set_rules('distribucion_lugares', 'Distribución de lugares', 'required');
        $this->form_validation->set_rules('intervalo_horas', 'Intervalo en horas');
        $this->form_validation->set_rules('dificultad', 'Dificultad', 'required');

        $sucursal = $this->session->userdata('filtro_clase_sucursal') ?: null;
        $disciplina = $this->session->userdata('filtro_clase_disciplina') ?: null;
        $semana = $this->session->userdata('filtro_clase_semana') ?: null;

        if ($sucursal !== null && $disciplina === null && $semana === null) { // Sucursal seleccionada, sin disciplina y sin semana

            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal($sucursal);
        } elseif ($sucursal !== null && $disciplina !== null && $semana === null) { // Sucursal y disciplina seleccionadas, sin semana

            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal_disciplina($disciplina, $sucursal);
        } elseif ($sucursal !== null && $disciplina === null && $semana !== null) { // Sucursal seleccionada y semana seleccionada

            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal_semana($sucursal, $semana);
        } elseif ($disciplina !== null && $sucursal === null && $semana === null) { // Disciplina seleccionada, sin sucursal y sin semana

            $calendario = $this->clases_model->obtener_calendario_crear_por_disciplina($disciplina);
        } elseif ($disciplina !== null && $sucursal === null && $semana !== null) { // Disciplina y Semana seleccionada sin sucursal

            $calendario = $this->clases_model->obtener_calendario_crear_por_disciplina_semana($disciplina, $semana);
        } elseif ($semana !== null && $sucursal === null && $disciplina === null) { // Solo la semana seleccionada, sin sucursal ni disciplina

            $calendario = $this->clases_model->obtener_calendario_crear_por_semana($semana);
        } elseif ($sucursal !== null && $disciplina !== null && $semana !== null) { // Todos los filtros seleccionados

            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal_disciplina_semana($sucursal, $disciplina, $semana);
        } else { // Sin filtros o valores por defecto

            $calendario = $this->clases_model->obtener_calendario_crear();
        }

        // Inicializar array con días de la semana
        $dias_semana = [
            'clase_lunes' => [],
            'clase_martes' => [],
            'clase_miercoles' => [],
            'clase_jueves' => [],
            'clase_viernes' => [],
            'clase_sabado' => [],
            'clase_domingo' => []
        ];

        foreach ($calendario->result() as $clase) {
            $hora = date('h:i A', strtotime($clase->inicia)); // Formatear hora
            $dia_semana = strtolower(date('N', strtotime($clase->inicia))); // Obtener el día de la semana (1 para lunes, 7 para domingo)

            switch ($dia_semana) {
                case 1:
                    $dias_semana['clase_lunes'][$hora] = $clase->instructor_nombre;
                    break;
                case 2:
                    $dias_semana['clase_martes'][$hora] = $clase->instructor_nombre;
                    break;
                case 3:
                    $dias_semana['clase_miercoles'][$hora] = $clase->instructor_nombre;
                    break;
                case 4:
                    $dias_semana['clase_jueves'][$hora] = $clase->instructor_nombre;
                    break;
                case 5:
                    $dias_semana['clase_viernes'][$hora] = $clase->instructor_nombre;
                    break;
                case 6:
                    $dias_semana['clase_sabado'][$hora] = $clase->instructor_nombre;
                    break;
                case 7:
                    $dias_semana['clase_domingo'][$hora] = $clase->instructor_nombre;
                    break;
            }
        }

        $data['dias_semana'] = $dias_semana;

        $sucursal = $this->session->userdata('filtro_clase_sucursal') ?: null;
        $disciplina = $this->session->userdata('filtro_clase_disciplina') ?: null;
        $semana = $this->session->userdata('filtro_clase_semana') ?: null;

        if ($sucursal !== null && $disciplina === null && $semana === null) { // Sucursal seleccionada, sin disciplina y sin semana

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_sucursal($sucursal)->result();
        } elseif ($sucursal !== null && $disciplina !== null && $semana === null) { // Sucursal y disciplina seleccionadas, sin semana

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_sucursal_disciplina($disciplina, $sucursal)->result();
        } elseif ($sucursal !== null && $disciplina === null && $semana !== null) { // Sucursal seleccionada y semana seleccionada

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_sucursal_semana($sucursal, $semana)->result();
        } elseif ($disciplina !== null && $sucursal === null && $semana === null) { // Disciplina seleccionada, sin sucursal y sin semana

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_disciplina($disciplina)->result();
        } elseif ($disciplina !== null && $sucursal === null && $semana !== null) { // Disciplina y Semana seleccionada sin sucursal

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_disciplina_semana($disciplina, $semana)->result();
        } elseif ($semana !== null && $sucursal === null && $disciplina === null) { // Solo la semana seleccionada, sin sucursal ni disciplina

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_semana($semana)->result();
        } elseif ($sucursal !== null && $disciplina !== null && $semana !== null) { // Todos los filtros seleccionados

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_sucursal_disciplina_semana($sucursal, $disciplina, $semana)->result();
        } else { // Sin filtros o valores por defecto

            $clases_list = $this->clases_model->obtener_ultimas_5_clases()->result();
        }

        $grupo_muscular_list = $this->clases_categorias_model->obtener_todas()->result();

        // Validar que existan usuarios en el rol de instructores
        $instructores = $this->usuarios_model->obtener_todos_instructores();

        if ($instructores->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos algún instructor registrado para poder crear la clase.');
            redirect('clases/index');
        }

        // Validar que existan disciplinas disponibles
        $disciplinas = $this->disciplinas_model->get_lista_de_disciplinas_para_crear_y_editar_clases();

        if ($disciplinas->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect('clases/index');
        }

        $sucursales_list = $this->filtros_model->obtener_sucursales()->result();
        $disciplinas_list = $this->filtros_model->obtener_disciplinas()->result();

        $data['sucursales_list'] = $sucursales_list;
        $data['disciplinas_list'] = $disciplinas_list;

        $data['grupo_muscular_list'] = $grupo_muscular_list;
        $data['clases_list'] = $clases_list;
        $data['instructores'] = $instructores;
        $data['disciplinas'] = $disciplinas;

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('clases/crear', $data);
        } else {

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

            // $valor5 = $this->input->post('dificultad');
            // $valor5 = preg_replace('/(á|é|í|ó|ú|ñ|ä|ë|ï|ö|\.|ü)/iu', '', $valor5);
            // $valor5 = substr($valor5, 0, 2);

            // $valor5 = $this->input->post('dificultad');
            // $acentos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
            // $sin_acentos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
            // $valor5 = str_replace($acentos, $sin_acentos, $valor5);
            // $valor5 = strtoupper(substr($valor5, 0, 2));

            $valor = $this->input->post('dificultad');
            // Separar la cadena en palabras
            $palabras = explode(' ', $valor);

            // Obtener la primera palabra
            $primera_palabra = $palabras[0];
            $segunda_palabra = $palabras[1];

            // Obtener las dos primeras letras de la primera palabra
            $primeras_dos_letras = substr($primera_palabra, 0, 2);

            // Obtener la última letra de la primera palabra
            $primera_letra = substr($segunda_palabra, 0, 1);

            // Concatenar las letras para formar la nueva cadena
            $cadena = $primeras_dos_letras . $primera_letra;

            $valor5 = $cadena;

            $identificador = $valor1 . $valor2 . $valor3 . $valor4 . '00' . $valor5;

            $cupo_lugares = array();
            // Crear un arreglo de arreglos para llevar un registro mas detallado del cupo
            for ($i = 1; $i <= $this->input->post('cupo'); $i++) {
                $lugar = array(
                    'no_lugar' => $i,
                    'esta_reservado' => false,
                    'nombre_usuario' => '',
                );

                array_push($cupo_lugares, $lugar);
            }

            $cupo_lugares_json = json_encode($cupo_lugares);

            if (strtotime($this->input->post('inicia_time')) <= strtotime('12:00')) {
                $img_acceso = base_url() . 'almacenamiento/img_app/img_acceso/acceso-matutino.png';
            } elseif (strtotime($this->input->post('inicia_time')) >= strtotime('12:01')) {
                $img_acceso = base_url() . 'almacenamiento/img_app/img_acceso/acceso-vespertino.png';
            }

            $dificultad_id = $this->input->post('dificultad');
            // list($dificultad_id, $dificultad_nombre) = explode('|', $dificultad);

            $dificulta_nombre = $this->clases_categorias_model->obtener_nombre_dificultad_por_id($dificultad_id)->row();

            $hora_de_incio = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time');
            $fecha_numerica_de_la_clase = date(DATE_ISO8601, strtotime($hora_de_incio));
            // Preparar los datos a insertar
            $data = array(
                'identificador' => $identificador,
                'disciplina_id' => $this->input->post('disciplina_id'),
                'instructor_id' => $this->input->post('instructor_id'),
                'cupo' => $this->input->post('cupo'),
                'img_acceso' => $img_acceso,
                'inicia' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time'),
                'inicia_ionic' => $fecha_numerica_de_la_clase,
                'intervalo_horas' => 1,
                'distribucion_imagen' => $this->input->post('distribucion_imagen'),
                'distribucion_lugares' => $this->input->post('distribucion_lugares'),
                'dificultad' => $dificulta_nombre->nombre,
                'clase_categoria_id' => $dificultad_id,
                'cupo_lugares' => $cupo_lugares_json,
            );

            if ($this->clases_model->crear($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La clase se ha creado correctamente.');
                redirect('clases/crear');
            }

            // Si algo falla regresar a la vista de crear
            $this->construir_private_site_ui('clases/crear', $data);
        }
    }

    public function obtener_clases_filtradas()
    {
        $sucursal_id = $this->input->get('filtro_clase_sucursal');
        $disciplina_id = $this->input->get('filtro_clase_disciplina');

        $sucursal = $this->session->userdata('filtro_clase_sucursal') ?: null;
        $disciplina = $this->session->userdata('filtro_clase_disciplina') ?: null;
        $semana = $this->session->userdata('filtro_clase_semana') ?: null;

        if ($sucursal !== null && $disciplina === null && $semana === null) { // Sucursal seleccionada, sin disciplina y sin semana

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_sucursal($sucursal)->result();
        } elseif ($sucursal !== null && $disciplina !== null && $semana === null) { // Sucursal y disciplina seleccionadas, sin semana

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_sucursal_disciplina($disciplina, $sucursal->result());
        } elseif ($sucursal !== null && $disciplina === null && $semana !== null) { // Sucursal seleccionada y semana seleccionada

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_sucursal_semana($sucursal, $semana)->result();
        } elseif ($disciplina !== null && $sucursal === null && $semana === null) { // Disciplina seleccionada, sin sucursal y sin semana

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_disciplina($disciplina)->result();
        } elseif ($disciplina !== null && $sucursal === null && $semana !== null) { // Disciplina y Semana seleccionada sin sucursal

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_disciplina_semana($disciplina, $semana)->result();
        } elseif ($semana !== null && $sucursal === null && $disciplina === null) { // Solo la semana seleccionada, sin sucursal ni disciplina

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_semana($semana)->result();
        } elseif ($sucursal !== null && $disciplina !== null && $semana !== null) { // Todos los filtros seleccionados

            $clases_list = $this->clases_model->obtener_ultimas_5_clases_por_sucursal_disciplina_semana($sucursal, $disciplina, $semana)->result();
        } else { // Sin filtros o valores por defecto

            $clases_list = $this->clases_model->obtener_ultimas_5_clases()->result();
        }

        $clases = $clases_list;

        // Enviar la respuesta en formato JSON
        echo json_encode(['clases' => $clases]);
    }

    public function obtener_horarios_clases()
    {
        $draw = intval($this->input->post('draw'));
        
        $sucursal_id = $this->input->get('filtro_clase_sucursal');
        $disciplina_id = $this->input->get('filtro_clase_disciplina');

        $sucursal = $this->session->userdata('filtro_clase_sucursal') ?: null;
        $disciplina = $this->session->userdata('filtro_clase_disciplina') ?: null;
        $semana = $this->session->userdata('filtro_clase_semana') ?: null;

        if ($sucursal !== null && $disciplina === null && $semana === null) { // Sucursal seleccionada, sin disciplina y sin semana

            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal($sucursal);
        } elseif ($sucursal !== null && $disciplina !== null && $semana === null) { // Sucursal y disciplina seleccionadas, sin semana

            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal_disciplina($disciplina, $sucursal);
        } elseif ($sucursal !== null && $disciplina === null && $semana !== null) { // Sucursal seleccionada y semana seleccionada

            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal_semana($sucursal, $semana);
        } elseif ($disciplina !== null && $sucursal === null && $semana === null) { // Disciplina seleccionada, sin sucursal y sin semana

            $calendario = $this->clases_model->obtener_calendario_crear_por_disciplina($disciplina);
        } elseif ($disciplina !== null && $sucursal === null && $semana !== null) { // Disciplina y Semana seleccionada sin sucursal

            $calendario = $this->clases_model->obtener_calendario_crear_por_disciplina_semana($disciplina, $semana);
        } elseif ($semana !== null && $sucursal === null && $disciplina === null) { // Solo la semana seleccionada, sin sucursal ni disciplina

            $calendario = $this->clases_model->obtener_calendario_crear_por_semana($semana);
        } elseif ($sucursal !== null && $disciplina !== null && $semana !== null) { // Todos los filtros seleccionados

            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal_disciplina_semana($sucursal, $disciplina, $semana);
        } else { // Sin filtros o valores por defecto

            $calendario = $this->clases_model->obtener_calendario_crear();
        }

        $data = [];
        // Inicializar array con días de la semana
        $dias_semana = [
            'clase_lunes' => [],
            'clase_martes' => [],
            'clase_miercoles' => [],
            'clase_jueves' => [],
            'clase_viernes' => [],
            'clase_sabado' => [],
            'clase_domingo' => []
        ];

        foreach ($calendario->result() as $clase) {
            $hora = date('h:i A', strtotime($clase->inicia)); // Formatear hora
            $dia_semana = strtolower(date('N', strtotime($clase->inicia))); // Obtener el día de la semana (1 para lunes, 7 para domingo)

            switch ($dia_semana) {
                case 1:
                    $dias_semana['clase_lunes'][$hora] = $clase->instructor_nombre;
                    break;
                case 2:
                    $dias_semana['clase_martes'][$hora] = $clase->instructor_nombre;
                    break;
                case 3:
                    $dias_semana['clase_miercoles'][$hora] = $clase->instructor_nombre;
                    break;
                case 4:
                    $dias_semana['clase_jueves'][$hora] = $clase->instructor_nombre;
                    break;
                case 5:
                    $dias_semana['clase_viernes'][$hora] = $clase->instructor_nombre;
                    break;
                case 6:
                    $dias_semana['clase_sabado'][$hora] = $clase->instructor_nombre;
                    break;
                case 7:
                    $dias_semana['clase_domingo'][$hora] = $clase->instructor_nombre;
                    break;
            }
        }

        // Crear un array que combine todos los horarios posibles de lunes a domingo
        $todos_los_horarios = array_merge(
            $dias_semana['clase_lunes'],
            $dias_semana['clase_martes'],
            $dias_semana['clase_miercoles'],
            $dias_semana['clase_jueves'],
            $dias_semana['clase_viernes'],
            $dias_semana['clase_sabado'],
            $dias_semana['clase_domingo']
        );

        // Generar el arreglo final de datos para la tabla
        foreach ($todos_los_horarios as $hora => $instructor) {
            $data[] = [
                'hora' => $hora,
                'clase_lunes' => $dias_semana['clase_lunes'][$hora] ?? '',
                'clase_martes' => $dias_semana['clase_martes'][$hora] ?? '',
                'clase_miercoles' => $dias_semana['clase_miercoles'][$hora] ?? '',
                'clase_jueves' => $dias_semana['clase_jueves'][$hora] ?? '',
                'clase_viernes' => $dias_semana['clase_viernes'][$hora] ?? '',
                'clase_sabado' => $dias_semana['clase_sabado'][$hora] ?? '',
                'clase_domingo' => $dias_semana['clase_domingo'][$hora] ?? ''
            ];
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $calendario->num_rows(),
            'recordsFiltered' => $calendario->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    public function obtener_calendario_crear()
    {
        $draw = intval($this->input->post('draw'));
        // $calendario = $this->clases_model->obtener_calendario_crear()->result();

        if (($this->session->userdata('filtro_clase_sucursal') != 0) and ($this->session->userdata('filtro_clase_disciplina') == 0)) {
            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal($this->session->userdata('filtro_clase_disciplina'));
        } else if ((($this->session->userdata('filtro_clase_sucursal') == null) and ($this->session->userdata('filtro_clase_disciplina') != null)) || (($this->session->userdata('filtro_clase_sucursal') == 0) and ($this->session->userdata('filtro_clase_disciplina') != 0))) {
            $calendario = $this->clases_model->obtener_calendario_crear_por_disciplina($this->session->userdata('filtro_clase_disciplina'));
        } else if (($this->session->userdata('filtro_clase_sucursal') != null) and ($this->session->userdata('filtro_clase_disciplina') != null) and ($this->session->userdata('filtro_clase_sucursal') != 0) and ($this->session->userdata('filtro_clase_disciplina') != 0)) {
            $calendario = $this->clases_model->obtener_calendario_crear_por_sucursal_disciplina($this->session->userdata('filtro_clase_disciplina'), $this->session->userdata('filtro_clase_sucursal'));
        } else if ((($this->session->userdata('filtro_clase_sucursal') == null) and ($this->session->userdata('filtro_clase_disciplina') == null)) || (($this->session->userdata('filtro_clase_sucursal') == 0) and ($this->session->userdata('filtro_clase_disciplina') == 0))) {
            $calendario = $this->clases_model->obtener_calendario_crear();
        }

        $data = [];
        // Inicializar array con días de la semana
        $dias_semana = [
            'clase_lunes' => [],
            'clase_martes' => [],
            'clase_miercoles' => [],
            'clase_jueves' => [],
            'clase_viernes' => [],
            'clase_sabado' => [],
            'clase_domingo' => []
        ];

        foreach ($calendario->result() as $clase) {
            $hora = date('h:i A', strtotime($clase->inicia)); // Formatear hora
            $dia_semana = strtolower(date('N', strtotime($clase->inicia))); // Obtener el día de la semana (1 para lunes, 7 para domingo)

            switch ($dia_semana) {
                case 1:
                    $dias_semana['clase_lunes'][$hora] = $clase->instructor_nombre;
                    break;
                case 2:
                    $dias_semana['clase_martes'][$hora] = $clase->instructor_nombre;
                    break;
                case 3:
                    $dias_semana['clase_miercoles'][$hora] = $clase->instructor_nombre;
                    break;
                case 4:
                    $dias_semana['clase_jueves'][$hora] = $clase->instructor_nombre;
                    break;
                case 5:
                    $dias_semana['clase_viernes'][$hora] = $clase->instructor_nombre;
                    break;
                case 6:
                    $dias_semana['clase_sabado'][$hora] = $clase->instructor_nombre;
                    break;
                case 7:
                    $dias_semana['clase_domingo'][$hora] = $clase->instructor_nombre;
                    break;
            }
        }

        // Crear un array que combine todos los horarios posibles de lunes a domingo
        $todos_los_horarios = array_merge(
            $dias_semana['clase_lunes'],
            $dias_semana['clase_martes'],
            $dias_semana['clase_miercoles'],
            $dias_semana['clase_jueves'],
            $dias_semana['clase_viernes'],
            $dias_semana['clase_sabado'],
            $dias_semana['clase_domingo']
        );

        // Generar el arreglo final de datos para la tabla
        foreach ($todos_los_horarios as $hora => $instructor) {
            $data[] = [
                'hora' => $hora,
                'clase_lunes' => $dias_semana['clase_lunes'][$hora] ?? '',
                'clase_martes' => $dias_semana['clase_martes'][$hora] ?? '',
                'clase_miercoles' => $dias_semana['clase_miercoles'][$hora] ?? '',
                'clase_jueves' => $dias_semana['clase_jueves'][$hora] ?? '',
                'clase_viernes' => $dias_semana['clase_viernes'][$hora] ?? '',
                'clase_sabado' => $dias_semana['clase_sabado'][$hora] ?? '',
                'clase_domingo' => $dias_semana['clase_domingo'][$hora] ?? ''
            ];
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $calendario->num_rows(),
            'recordsFiltered' => $calendario->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    public function obtener_dificultades_por_disciplina()
    {
        $disciplina_id = $this->input->post('disciplina_id');
        $dificultades = $this->clases_categorias_model->obtener_dificultades($disciplina_id)->result();

        echo json_encode($dificultades);
    }

    function search_reservar()
    {
        $this->load->model('clases_model');
        if (isset($_GET['term'])) {
            $q = mb_strtolower($_GET['term']);
            $this->clases_model->autosearch($q);
        }
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Clases';
        $data['pagina_subtitulo'] = 'Registro de clases';
        $data['menu_clases_activo'] = true;

        $data['controlador'] = 'clases';
        $data['ir_a'] = 'clases/crear';
        $data['regresar_a'] = 'inicio';
        $controlador_js = 'clases/index';

        // Obtener la semana actual (Lunes - Domingo)
        $current_week_start = new DateTime();
        $current_week_start->modify('monday this week');
        $current_week_end = clone $current_week_start;
        $current_week_end->modify('sunday this week');

        $current_week = $current_week_start->format('Y-m-d') . ' al ' . $current_week_end->format('Y-m-d');

        // Obtener la semana siguiente (Lunes - Domingo)
        $next_week_start = new DateTime();
        $next_week_start->modify('monday next week');
        $next_week_end = clone $next_week_start;
        $next_week_end->modify('sunday next week');

        $next_week = $next_week_start->format('Y-m-d') . ' al ' . $next_week_end->format('Y-m-d');

        // Pasar las semanas al select
        $data['weeks'] = [
            'actual' => $current_week,
            'siguiente' => $next_week
        ];

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/moment.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $sucursales_list = $this->filtros_model->obtener_sucursales()->result();
        $disciplinas_list = $this->filtros_model->obtener_disciplinas()->result();

        $data['sucursales_list'] = $sucursales_list;
        $data['disciplinas_list'] = $disciplinas_list;

        $this->construir_private_site_ui('clases/index', $data);
    }

    public function obtener_tabla_index()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $sucursal = $this->session->userdata('filtro_clase_sucursal') ?: null;
        $disciplina = $this->session->userdata('filtro_clase_disciplina') ?: null;
        $semana = $this->session->userdata('filtro_clase_semana') ?: null;

        if ($sucursal !== null && $disciplina === null && $semana === null) { // Sucursal seleccionada, sin disciplina y sin semana

            $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle_por_sucursal($sucursal);
        } elseif ($sucursal !== null && $disciplina !== null && $semana === null) { // Sucursal y disciplina seleccionadas, sin semana

            $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle_por_sucursal_disciplina($disciplina, $sucursal);
        } elseif ($sucursal !== null && $disciplina === null && $semana !== null) { // Sucursal seleccionada y semana seleccionada

            $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle_por_sucursal_semana($sucursal, $semana);
        } elseif ($disciplina !== null && $sucursal === null && $semana === null) { // Disciplina seleccionada, sin sucursal y sin semana

            $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle_por_disciplina($disciplina);
        } elseif ($disciplina !== null && $sucursal === null && $semana !== null) { // Disciplina y Semana seleccionada sin sucursal

            $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle_por_disciplina_semana($disciplina, $semana);
        } elseif ($semana !== null && $sucursal === null && $disciplina === null) { // Solo la semana seleccionada, sin sucursal ni disciplina

            $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle_por_semana($semana);
        } elseif ($sucursal !== null && $disciplina !== null && $semana !== null) { // Todos los filtros seleccionados

            $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle_por_sucursal_disciplina_semana($sucursal, $disciplina, $semana);
        } else { // Sin filtros o valores por defecto

            $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle();
        }

        $data = [];

        foreach ($clases_list->result() as $clase) {
            $fecha = strtotime($clase->inicia);
            $fecha_espaniol = strftime("%d de %B del %Y<br>%T", $fecha);

            // if ($clase->intervalo_horas != 1) {
            //     $intervalo_horas = $clase->intervalo_horas;
            // } else {
            //     $intervalo_horas = $clase->intervalo_horas;
            // }
            $intervalo_horas = $clase->intervalo_horas;

            $opciones = '';
            $fecha_de_clase = '';
            $fecha_limite_de_clase = '';

            if ($clase->estatus != 'Cancelada') {

                $fecha_de_clase = $clase->inicia;
                $fecha_limite_de_clase = strtotime('+48 hours', strtotime($fecha_de_clase));

                if ((strtotime('now') < $fecha_limite_de_clase) and ($clase->reservado < $clase->cupo)) {
                    $opciones = anchor('clases/reservar/' . $clase->id, 'Reservar');
                    $opciones .= ' | ';
                }

                $opciones .= anchor('clases/editar/' . $clase->id, 'Editar');
            }
            // if ($clase->estatus == 'Activa') {
            //     // $opciones .= '<a href="' . site_url('clases/duplicar_clase/' . $clase->id) . '"><span>Duplicar</span></a>';
            //     $opciones .= ' | ';
            //     $opciones .= '<a href="" class="clonar-row" data-id="' . $clase->id . '"><span>Duplicar</span></a>';
            // }
            if ($clase->reservado == 0) {
                if ($clase->estatus == 'Activa') {
                    $opciones .= ' | ';
                    $opciones .= '<a href="' . site_url('clases/cancelar/' . $clase->id) . '"><span class="red">Cancelar</span></a>';
                    $opciones .= '  |  ';
                    $opciones .= '<a href="" class="delete-row" data-id="' . $clase->id . '"><span class="red">Borrar</span></a>';
                }
                if ($clase->reservado == 0 and $clase->estatus == 'Cancelada') {
                    $opciones .= '<a href="" class="delete-row" data-id="' . $clase->id . '"><span class="red">Borrar</span></a>';
                }
            }

            $cupos_restantes = $clase->cupo - $clase->reservado;

            $data[] = array(
                'opciones' => $opciones,
                'id' => $clase->id,
                // 'estatus' => !empty($clase->estatus) ? ucwords($clase->estatus) : '',
                'identificador' => !empty($clase->identificador) ? $clase->identificador : '',
                'disciplina_id' => $clase->disciplina_nombre,
                'dificultad' => !empty($clase->dificultad) ? mb_strtoupper($clase->dificultad) : '',
                'inicia' => (!empty($clase->inicia) ? date('Y-m-d', strtotime($clase->inicia)) : ''),
                'horario' => (!empty($clase->inicia) ? date('h:i A', strtotime($clase->inicia)) : ''),
                // 'horario_esp' => !empty($fecha_espaniol) ? ucfirst($fecha_espaniol) : '',
                'instructor_id' => !empty($clase->instructor_nombre) ? ($clase->instructor_nombre) : '',
                'cupo' => !empty($clase->cupo) ? ucfirst($cupos_restantes . ' / ' . $clase->cupo) : '',
                'intervalo_horas' => !empty($intervalo_horas) ? mb_strtoupper($intervalo_horas) : '',
                // 'cupo_restantes' => !empty($clase->cupo - $clase->reservado) ? $clase->cupo - $clase->reservado : '',
                // 'cupo_original' => !empty($clase->cupo) ? ucfirst($clase->cupo) : '',
                // 'cupo_reservado' => !empty($clase->reservado) ? ucfirst($clase->reservado) : 0,
                // 'inasistencias' => !empty($clase->inasistencias) ? ucfirst($clase->inasistencias) : 0,
                'sucursal' => !empty($clase->sucursal_nombre . ' [' . $clase->sucursal_locacion . ']') ? $clase->sucursal_nombre . ' [' . $clase->sucursal_locacion . ']' : '',
                'estatus' => !empty($clase->estatus) ? '<span class="' . $this->getStatusClass($clase->estatus) . '">' . ucwords($clase->estatus) . '</span>' : '',
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

    // Función para obtener la clase CSS basada en el estatus
    private function getStatusClass($status)
    {
        switch ($status) {
            case 'Activa':
                return 'text-success'; // Verde
            case 'Cancelada':
                return 'text-danger'; // Rojo
            case 'Terminada':
                return 'text-muted'; // Gris
            default:
                return ''; // Sin color
        }
    }

    public function obtener_disciplinas()
    {
        $sucursal_id = $this->input->post('sucursal_id');

        $disciplinas = $this->filtros_model->obtener_disciplinas($sucursal_id);

        $data = [];
        foreach ($disciplinas->result() as $disciplina) {
            $data[] = array(
                'id' => $disciplina->id,
                'nombre' => $disciplina->nombre
            );
        }

        echo json_encode($data);
        exit();
    }

    public function guardar_seleccion()
    {
        if ($this->input->is_ajax_request()) {

            $sucursal_seleccionada = $this->input->post('filtro_clase_sucursal');
            $this->session->set_userdata('filtro_clase_sucursal', $sucursal_seleccionada);

            $this->session->set_userdata('filtro_clase_disciplina', 0);

            // $disciplina_seleccionada = $this->input->post('filtro_clase_disciplina');
            // $this->session->set_userdata('filtro_clase_disciplina', $disciplina_seleccionada);

            echo json_encode(['status' => 'success']);

            $this->construir_private_site_ui('clases/index');
        } else {
            show_error('Acceso no permitido', 403);
        }
    }

    public function guardar_seleccion_disciplina()
    {
        if ($this->input->is_ajax_request()) {

            $disciplina_seleccionada = $this->input->post('filtro_clase_disciplina');
            $this->session->set_userdata('filtro_clase_disciplina', $disciplina_seleccionada);

            echo json_encode(['status' => 'success']);

            $this->construir_private_site_ui('clases/index');
        } else {
            show_error('Acceso no permitido', 403);
        }
    }

    public function guardar_seleccion_semana()
    {
        if ($this->input->is_ajax_request()) {

            $semana_seleccionada = $this->input->post('filtro_clase_semana');
            $this->session->set_userdata('filtro_clase_semana', $semana_seleccionada);

            echo json_encode(['status' => 'success']);

            $this->construir_private_site_ui('clases/index');
        } else {
            show_error('Acceso no permitido', 403);
        }
    }

    public function duplicar_clase($id = null)
    {
        // Obtener la clase que se desea duplicar
        $clase = $this->clases_model->obtener_por_id($id)->row();
        // Obtener todas las clases para verificar duplicados
        $clases_list = $this->clases_model->obtener_todas_para_front_con_detalle();

        // Verificar si la clase existe
        if (!$clase) {
            // Redireccionar si no se encuentra la clase
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se ha podido encontrar la clase que desea clonar.');
            redirect(site_url('clases'));
        }

        // Obtener el número de duplicación actual
        preg_match('/DUP(\d+)$/', $clase->identificador, $matches);
        $numero_duplicado = isset($matches[1]) ? intval($matches[1]) : 1;

        // Construir el nuevo identificador
        $identificador_nuevo = preg_replace('/\sDUP\d+$/', '', $clase->identificador) . ' DUP' . ($numero_duplicado + 1);

        // Verificar si el identificador ya existe, si es así, incrementar el número
        while ($this->identificador_existente($identificador_nuevo, $clases_list)) {
            $numero_duplicado++;
            $identificador_nuevo = preg_replace('/\sDUP\d+$/', '', $clase->identificador) . ' DUP' . ($numero_duplicado + 1);
        }

        // Resto del código para crear la clase duplicada
        $fecha_registro = date("Y-m-d H:i:s");
        $key_1 = "clases-" . date("Y-m-d-H-i-s", strtotime($fecha_registro));
        $identificador_1 = hash("crc32b", $key_1);

        $cupo_lugares = array();
        // Crear un arreglo de arreglos para llevar un registro más detallado del cupo
        for ($i = 1; $i <= $clase->cupo; $i++) {
            $lugar = array(
                'no_lugar' => $i,
                'esta_reservado' => false,
                'nombre_usuario' => '',
            );

            array_push($cupo_lugares, $lugar);
        }

        $cupo_lugares_json = json_encode($cupo_lugares);

        // Crear la clase duplicada
        $clase_a_clonar = $this->clases_model->crear_duplicado(
            array(
                'identificador' => $identificador_nuevo,
                'disciplina_id' => $clase->disciplina_id,
                'instructor_id' => $clase->instructor_id,
                'cupo' => $clase->cupo,
                'img_acceso' => $clase->img_acceso,
                'inicia' => $clase->inicia,
                'inicia_ionic' => $clase->inicia_ionic,
                'intervalo_horas' => $clase->intervalo_horas,
                'distribucion_imagen' => $clase->distribucion_imagen,
                'distribucion_lugares' => $clase->distribucion_lugares,
                'dificultad' => $clase->dificultad,
                'cupo_lugares' => $cupo_lugares_json,
            )
        );

        // Redireccionar después de crear la clase duplicada
        // if ($clase_a_clonar) {
        //     redirect(site_url('clases'));
        // }
        // $draw = intval($this->input->post('draw'));

        $fecha = strtotime($clase->inicia);
        $fecha_espaniol = strftime("%d de %B del %Y<br>%T", $fecha);

        if ($clase_a_clonar) {
            $new_class = $this->clases_model->obtener_por_id($clase_a_clonar)->row();

            if ($new_class->intervalo_horas != 1) {
                $intervalo_horas = $clase->intervalo_horas . " hrs.";
            } else {
                $intervalo_horas = $clase->intervalo_horas . " hr.";
            }

            $data = array(
                'id' => $new_class->id,
                'identificador' => !empty($new_class->identificador) ? $new_class->identificador : '',
                'disciplina_id' => $new_class->disciplina_nombre,
                'dificultad' => !empty($new_class->dificultad) ? mb_strtoupper($new_class->dificultad) : '',
                'inicia' => (!empty($new_class->inicia) ? date('d/m/Y H:i:s', strtotime($new_class->inicia)) : ''),
                'horario_esp' => !empty($fecha_espaniol) ? ucfirst($fecha_espaniol) : '',
                'instructor_id' => !empty($new_class->instructor) ? $new_class->instructor : '',
                'cupo' => !empty($new_class->cupo) ? ucfirst($new_class->cupo) : '',
                'estatus' => !empty($new_class->estatus) ? ucwords($new_class->estatus) : '',
                'intervalo_horas' => !empty($intervalo_horas) ? mb_strtoupper($intervalo_horas) : '',
                'cupo_restantes' => !empty($new_class->cupo - $new_class->reservado) ? $new_class->cupo - $new_class->reservado : '',
                'cupo_original' => !empty($new_class->cupo) ? ucfirst($new_class->cupo) : '',
                'cupo_reservado' => !empty($new_class->reservado) ? ucfirst($new_class->reservado) : 0,
                'inasistencias' => !empty($new_class->inasistencias) ? ucfirst($new_class->inasistencias) : 0,
                'sucursal' => !empty($clase->sucursal_nombre . ' [' . $clase->sucursal_locacion . ']') ? $clase->sucursal_nombre . ' [' . $clase->sucursal_locacion . ']' : '',
                'opciones' => ''
            );

            $result = array(
                'data' => $data
            );

            echo json_encode(['success' => true, 'data' => $result]);
        }

        // Redireccionar si falla la creación de la clase duplicada
        // $this->session->set_flashdata('MENSAJE_ERROR', 'La clase ' . $id . ' no ha podido ser clonada.');
        // redirect(site_url('clases'));
    }

    // Función para verificar si un identificador ya existe en la lista de clases
    private function identificador_existente($identificador, $clases_list)
    {
        foreach ($clases_list->result() as $clases_row) {
            if ($clases_row->identificador === $identificador) {
                return true;
            }
        }
        return false;
    }

    public function actualizar()
    {
        $identificador = $this->input->post('identificador');
        $columna = $this->input->post('columna'); // Índice de la columna
        $nuevoValor = $this->input->post('nuevoValor');

        $clase = $this->clases_model->obtener_clase_por_identificador_para_sku($identificador)->row();

        // Creacion de identificador con nomenclatura
        if ($columna == 'disciplina_id') {
            $disciplina = $this->disciplinas_model->obtener_por_id($nuevoValor)->row();
        } else {
            $disciplina = $this->disciplinas_model->obtener_por_id($clase->disciplina_id)->row();
        }

        if ($columna == 'instructor_id') {
            $instructor = $this->usuarios_model->obtener_instructor_por_id($nuevoValor)->row();
        } else {
            $instructor = $this->usuarios_model->obtener_instructor_por_id($clase->instructor_id)->row();
        }

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

        if ($columna == 'inicia') {

            $dt = new DateTime($nuevoValor);
            $formattedDateTime = $dt->format('YmdHis');

            // Asignar el valor convertido a las variables correspondientes
            $valor3 = $dt->format('Ymd'); // Resultado: '20240602'
            $valor4 = $dt->format('His'); // Resultado: '180000'
        } else {

            $dt = new DateTime($clase->inicia);
            $formattedDateTime = $dt->format('YmdHis');

            // Asignar el valor convertido a las variables correspondientes
            $valor3 = $dt->format('Ymd'); // Resultado: '20240602'
            $valor4 = $dt->format('His'); // Resultado: '180000'
        }

        if ($columna == 'dificultad') {
            // $valor5 = $nuevoValor;
            // $valor5 = preg_replace('/(á|é|í|ó|ú|ñ|ä|ë|ï|ö|\.|ü)/iu', '', $valor5);
            // $valor5 = substr($valor5, 0, 2);

            // $valor5 = $nuevoValor;
            // $acentos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
            // $sin_acentos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
            // $valor5 = str_replace($acentos, $sin_acentos, $valor5);
            // $valor5 = strtoupper(substr($valor5, 0, 2));

            $valor = $nuevoValor;
            // Separar la cadena en palabras
            $palabras = explode(' ', $valor);

            // Obtener la primera palabra
            $primera_palabra = $palabras[0];
            $segunda_palabra = $palabras[1];

            // Obtener las dos primeras letras de la primera palabra
            $primeras_dos_letras = substr($primera_palabra, 0, 2);

            // Obtener la última letra de la primera palabra
            $primera_letra = substr($segunda_palabra, 0, 1);

            // Concatenar las letras para formar la nueva cadena
            $cadena = $primeras_dos_letras . $primera_letra;

            $valor5 = $cadena;
        } else {
            // $valor5 = $clase->dificultad;
            // $valor5 = preg_replace('/(á|é|í|ó|ú|ñ|ä|ë|ï|ö|\.|ü)/iu', '', $valor5);
            // $valor5 = substr($valor5, 0, 2);

            // $valor5 = $clase->dificultad;
            // $acentos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
            // $sin_acentos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
            // $valor5 = str_replace($acentos, $sin_acentos, $valor5);
            // $valor5 = strtoupper(substr($valor5, 0, 2));

            $valor = $clase->dificultad;
            // Separar la cadena en palabras
            $palabras = explode(' ', $valor);

            // Obtener la primera palabra
            $primera_palabra = $palabras[0];
            $segunda_palabra = $palabras[1];

            // Obtener las dos primeras letras de la primera palabra
            $primeras_dos_letras = substr($primera_palabra, 0, 2);

            // Obtener la última letra de la primera palabra
            $primera_letra = substr($segunda_palabra, 0, 1);

            // Concatenar las letras para formar la nueva cadena
            $cadena = $primeras_dos_letras . $primera_letra;

            $valor5 = $cadena;
        }

        $identificador_nuevo = $valor1 . $valor2 . $valor3 . $valor4 . $valor5;
        // FIN de creacion de identificador

        $clase_existente = $this->clases_model->obtener_clase_por_identificador_para_sku($identificador_nuevo)->row();

        if ($clase_existente) {

            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Datos ya existentes')));
        } else {

            if ($columna == 'inicia') {
                // Extraer la hora de la cadena de fecha
                $hora = substr($nuevoValor, 11, 5); // Obtiene "07:30"
                $horaNumerica = intval(substr($hora, 0, 2)); // Obtiene "07" y lo convierte a entero

                // Determinar si es AM o PM
                if ($horaNumerica < 12) {

                    $data_1 = array(
                        'identificador' => $identificador_nuevo,
                        $columna => $nuevoValor,
                        'inicia_ionic' => $nuevoValor,
                        'img_acceso' => 'https://beatness.com.mx/almacenamiento/img_app/img_acceso/acceso-matutino.png'
                    );
                } else {
                    $data_1 = array(
                        'identificador' => $identificador_nuevo,
                        $columna => $nuevoValor,
                        'inicia_ionic' => $nuevoValor,
                        'img_acceso' => 'https://beatness.com.mx/almacenamiento/img_app/img_acceso/acceso-vespertino.png'
                    );
                }
            } else {
                $data_1 = array(
                    'identificador' => $identificador_nuevo,
                    $columna => $nuevoValor,
                );
            }

            $this->clases_model->actualizar_clase_por_identificador($identificador, $data_1);

            // Devolver una respuesta JSON con éxito
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success', 'message' => 'Dato actualizado', 'nuevo_identificador' => $identificador_nuevo)));
        }
    }

    public function obtener_opciones_select_disciplina()
    {

        $disciplinas = $this->disciplinas_model->get_lista_de_todas_las_disciplinas();

        $data = [];
        foreach ($disciplinas->result() as $disciplina) {

            $data[] = array(
                'nombre' => $disciplina->nombre,
                'valor' => $disciplina->id
            );
        }

        echo json_encode($data);
        exit();

        // echo json_encode(select_disciplina());
        // exit();
    }

    public function obtener_opciones_select_instructor()
    {
        $instructores = $this->usuarios_model->obtener_todos_instructores();

        $data = [];
        foreach ($instructores->result() as $instructor) {
            $nombre = trim("{$instructor->nombre_completo} {$instructor->apellido_paterno} {$instructor->apellido_materno}");
            $nombre = preg_replace('/\s+/', ' ', $nombre);

            $data[] = array(
                'nombre' => mb_strtoupper($nombre),
                'valor' => $instructor->id
            );
        }

        echo json_encode($data);
        exit();

        // echo json_encode(select_instructor());
        // exit();
    }

    public function obtener_opciones_select_dificultad()
    {
        // $dificultades = $this->clases_model->obtener_dificultades();

        // $data = [];
        // foreach ($dificultades->result() as $dificultad) {
        //     $data[] = array(
        //         'nombre' => $dificultad->dificultad,
        //         'valor' => $dificultad->dificultad
        //     );
        // }

        // echo json_encode($data);
        // exit();

        echo json_encode(select_dificultad());
        exit();
    }

    public function crear_clases()
    {
        // Validar que existan usuarios en el rol de instructores
        $instructores = $this->usuarios_model->obtener_todos_instructores();

        // Validar que existan disciplinas disponibles
        $disciplinas = $this->disciplinas_model->obtener_todas();

        if ($instructores->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos algún instructor registrado para poder crear la clase.');
            redirect('clases/index');
        }

        if ($disciplinas->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect('clases/index');
        }

        $data['instructores'] = $instructores;

        $data['disciplinas'] = $disciplinas;

        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Nueva clase';

        $data['styles'] = array();
        $data['scripts'] = array(
            array('es_rel' => true, 'src' => 'clases/crear_clases.js'),
        );

        $this->construir_private_site_ui('clases/crear_clases', $data);
    }

    public function editar($id = null)
    {
        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Validar que existan usuarios en el rol de instructores
        $instructores = $this->usuarios_model->obtener_todos_instructores();
        $data['usuarios'] = $this->usuarios_model->obtener_todos();

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

        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Editar clase';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/timedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/timedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => 'clases/editar.js'),
        );

        $grupo_muscular_list = $this->clases_categorias_model->obtener_todas()->result();
        $data['grupo_muscular_list'] = $grupo_muscular_list;

        // $disciplina_id = $this->input->post('disciplina_id');
        // $dificultades = $this->clases_categorias_model->obtener_dificultades($disciplina_id)->result();

        // Establecer validaciones
        $this->form_validation->set_rules('disciplina_id', 'Disciplina', 'required');
        $this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
        $this->form_validation->set_rules('cupo', 'Cupo', 'required');
        $this->form_validation->set_rules('inicia_date', 'Fecha', 'required');
        $this->form_validation->set_rules('inicia_time', 'Hora', 'required');
        $this->form_validation->set_rules('intervalo_horas', 'Intervalo en horas', 'required');
        $this->form_validation->set_rules('distribucion_lugares', 'Distribución de lugares', 'required');
        $this->form_validation->set_rules('dificultad', 'Dificultad', 'required');

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        if ($this->form_validation->run() == false) {

            $clase_a_editar = $this->clases_model->obtener_por_id($id)->row();

            if (!$clase_a_editar) {
                $this->session->set_flashdata('MENSAJE_INFO', 'La clase que intenta editar no existe.');
                redirect('clases/index');
            }

            $data['clase_a_editar'] = $clase_a_editar;

            $this->construir_private_site_ui('clases/editar', $data);
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

            // $valor5 = $this->input->post('dificultad');
            // $valor5 = preg_replace('/(á|é|í|ó|ú|ñ|ä|ë|ï|ö|\.|ü)/iu', '', $valor5);
            // $valor5 = substr($valor5, 0, 2);

            // $valor5 = $this->input->post('dificultad');
            // $acentos = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú');
            // $sin_acentos = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U');
            // $valor5 = str_replace($acentos, $sin_acentos, $valor5);
            // $valor5 = strtoupper(substr($valor5, 0, 2));

            $valor = $this->input->post('dificultad');
            // Separar la cadena en palabras
            $palabras = explode(' ', $valor);

            // Obtener la primera palabra
            $primera_palabra = $palabras[0];
            $segunda_palabra = $palabras[1];

            // Obtener las dos primeras letras de la primera palabra
            $primeras_dos_letras = substr($primera_palabra, 0, 2);

            // Obtener la última letra de la primera palabra
            $primera_letra = substr($segunda_palabra, 0, 1);

            // Concatenar las letras para formar la nueva cadena
            $cadena = $primeras_dos_letras . $primera_letra;

            $valor5 = $cadena;

            $identificador = $valor1 . $valor2 . $valor3 . $valor4 . '00' . $valor5;

            $clase_existente = $this->clases_model->obtener_clase_por_identificador_para_sku($identificador)->row();

            if (strtotime($this->input->post('inicia_time')) <= strtotime('12:00')) {
                $img_acceso = base_url() . 'almacenamiento/img_app/img_acceso/acceso-matutino.png';
            } elseif (strtotime($this->input->post('inicia_time')) >= strtotime('12:01')) {
                $img_acceso = base_url() . 'almacenamiento/img_app/img_acceso/acceso-vespertino.png';
            }

            // $dificultad = $this->input->post('dificultad');
            // list($dificultad_id, $dificultad_nombre) = explode('|', $dificultad);

            $dificultad = $this->clases_categorias_model->obtener_nombre_dificultad($this->input->post('dificultad'))->row();

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
                    'img_acceso' => $img_acceso,
                    'inicia' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('inicia_date')))) . 'T' . $this->input->post('inicia_time'),
                    'inicia_ionic' => $fecha_numerica_de_la_clase,
                    'intervalo_horas' => $this->input->post('intervalo_horas'),
                    'distribucion_imagen' => $this->input->post('distribucion_imagen'),
                    'distribucion_lugares' => $this->input->post('distribucion_lugares'),
                    'dificultad' => $dificultad->nombre,
                    'clase_categoria_id' => $this->input->post('dificultad'),
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

    public function reservar($id = null)
    {

        $data['clase_a_reservar'] = $this->clases_model->obtener_todas_con_detalle_por_id($id)->row();

        // Validar que existan usuarios disponibles
        $usuarios = $this->usuarios_model->obtener_todos();

        if ($usuarios->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
            redirect('clases/index');
        }

        $data['usuarios'] = $usuarios;

        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Nueva reservacion';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/timedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/js/easyautocomplete/easy-autocomplete.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/js/easyautocomplete/easy-autocomplete.themes.min.css'),
            array('es_rel' => false, 'href' => 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/timedropper.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/easyautocomplete/jquery.easy-autocomplete.min.js'),
            array('es_rel' => false, 'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'),
            array('es_rel' => false, 'src' => 'https://code.jquery.com/ui/1.10.2/jquery-ui.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js'),
            array('es_rel' => true, 'src' => 'clases/reservar.js'),
        );

        $this->form_validation->set_rules('usuario_id', 'Cliente', 'required');
        $this->form_validation->set_rules('no_lugar', 'Lugar', 'required');

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        if ($this->form_validation->run() == false) {
            $clase_a_reservar = $this->clases_model->obtener_todas_con_detalle_por_id($id)->row();

            if (!$clase_a_reservar) {
                $this->session->set_flashdata('MENSAJE_INFO', 'La clase que intenta editar no existe.');
                redirect('clases/index');
            }

            $data['clase_a_reservar'] = $clase_a_reservar;

            $this->construir_private_site_ui('clases/reservar', $data);
        } else {
            $clase_a_reservar = $this->clases_model->obtener_por_id($this->input->post('clase_id'))->row();

            if (!$clase_a_reservar) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'La clase a reservar no se encuentra.');
                redirect('clases/index');
            }

            if ($clase_a_reservar->cupo - $clase_a_reservar->reservado <= 0) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'La clase no cuenta con lugares disponibles.');
                redirect('clases/index');
            }
            /**
             * Aqui se cambia el tiempo maximo que tienen para cargar unareservacion desde sistema
             * Actualmente esta configurado en 12 hrs. a mas tardar.
             */

            $fecha_de_clase = $clase_a_reservar->inicia;
            $fecha_limite_de_clase = strtotime('+48 hours', strtotime($fecha_de_clase));

            if (strtotime('now') > $fecha_limite_de_clase) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'Solo tiene un límite de 48 horas para generar una reservaciones después de que la clase ya ha concluido.');
                redirect('clases/index');
            }

            $asignaciones_por_cliente = $this->asignaciones_model->obtener_activos_por_usuario_id($this->input->post('usuario_id'));

            if ($asignaciones_por_cliente->num_rows() == 0) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'El usuario que seleccionó no cuenta con planes adquiridos aun.');
                redirect('clases/index');
            }

            foreach ($asignaciones_por_cliente->result() as $asignacion) {

                $fecha_de_asignacion = $asignacion->fecha_activacion;
                $fecha_limite_de_asignacion = strtotime('+' . $asignacion->vigencia_en_dias . ' days', strtotime($fecha_de_asignacion));

                if (strtotime('now') < $fecha_limite_de_asignacion) {
                    /*$this->session->set_flashdata('MENSAJE_ERROR', 'El plan del usuario seleccionado ya ha vencido el '.date('Y-m-d H:i:s',$fecha_limite_de_asignacion).', por favor notifique al usuario');
                    redirect('clases/index');*/

                    if ($asignacion->clases_incluidas - $asignacion->clases_usadas >= $clase_a_reservar->intervalo_horas) {
                        /*$this->session->set_flashdata('MENSAJE_ERROR', 'El usuario aún cuenta con clase disponibles para reservar.');
                        redirect('clases/index');*/

                        $disciplinas_ids_asignacion = explode('|', $asignacion->disciplinas);

                        foreach ($disciplinas_ids_asignacion as $disciplina) {
                            if ($clase_a_reservar->disciplina_id == $disciplina or $clase_a_reservar->subdisciplina_id == $disciplina) {

                                // Establecer como ocupado/reservado el lugar que se seleccionó
                                $cupo_lugares = $clase_a_reservar->cupo_lugares;
                                $cupo_lugares = json_decode($cupo_lugares);

                                foreach ($cupo_lugares as $lugar) {
                                    if ($lugar->no_lugar == $this->input->post('no_lugar')) {
                                        if ($lugar->esta_reservado) {
                                            $this->session->set_flashdata('MENSAJE_ERROR', 'El lugar seleccionado ya se encuentra reservado.');
                                            redirect('clases/index');
                                        }
                                        $lugar->esta_reservado = true;
                                        $lugar->nombre_usuario = $this->input->post('usuario_id');
                                    }
                                }

                                $cupo_lugares_json = json_encode($cupo_lugares);

                                $clases_usadas = $asignacion->clases_usadas + $clase_a_reservar->intervalo_horas;
                                $reservado = $clase_a_reservar->reservado + 1;

                                // Actualizar el plan del cliente y la clase para que se establezca que una clase ha sido usada
                                if (
                                    !$this->asignaciones_model->editar($asignacion->id, array('clases_usadas' => $clases_usadas)) ||
                                    !$this->clases_model->editar($clase_a_reservar->id, array('reservado' => $reservado, 'cupo_lugares' => $cupo_lugares_json))
                                ) {
                                    $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación no pudo ser creada.');
                                    redirect('clases/index');
                                }

                                // Crear reservación
                                $reservacion = $this->reservaciones_model->crear(
                                    array(
                                        'usuario_id' => $this->input->post('usuario_id'),
                                        'clase_id' => $clase_a_reservar->id,
                                        'asignaciones_id' => $asignacion->id,
                                        'no_lugar' => $this->input->post('no_lugar'),
                                    )
                                );

                                if (!$reservacion) {
                                    $this->session->set_flashdata('MENSAJE_ERROR', 'La reservación no pudo ser creada.');
                                    redirect('clases/index');
                                }

                                $this->session->set_flashdata('MENSAJE_EXITO', 'La reservación se ha realizado con éxito. Para ID ' . $this->input->post('usuario_id') . ' con el Lugar: ' . $this->input->post('no_lugar'));
                                redirect('clases/reservar/' . $id);
                            }
                        }
                    }
                }
            }
            $this->session->set_flashdata('MENSAJE_ERROR', 'Por favor revise que el usuario cuente con algún plan adecuado para hacer una reservación o que la clase tengan lugares disponibles');
            redirect('clases/index');
        }
    }

    public function generar_horarios_ionic()
    {
        $clases_a_modificar = $this->clases_model->obtener_todas();

        if ($clases_a_modificar->num_rows() == 0) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se han podido encontrar todas las clases a las que se les generará el horario.');
            redirect('clases/index');
        }
        /*if ($clases_a_modificar != 0) {
            $this->session->set_flashdata('MENSAJE_INFO', 'Si se han podido encontrar todas las clases a las que se les generará el horario.');
            redirect('clases/index');
        }*/

        foreach ($clases_a_modificar->result() as $clase) {
            $hora_de_incio = $clase->inicia;
            $fecha_numerica_de_la_clase = date(DATE_ISO8601, strtotime($hora_de_incio));

            $imprimir = $clase->id . ' -- ' . $clase->inicia . ' -- ' . $fecha_numerica_de_la_clase;
            $this->debug_to_console($imprimir);

            $generar_fechas_bonitas = $this->clases_model->editar(
                $clase->id,
                array(
                    'inicia_ionic' => $fecha_numerica_de_la_clase,
                )
            );

            if (!$generar_fechas_bonitas) {
                $this->session->set_flashdata('MENSAJE_ERROR', 'La clase no pudo ser modificada.');
                redirect('reservaciones/index');
            }
        }

        $this->session->set_flashdata('MENSAJE_EXITO', 'Las clases SI pudieron ser modificadas.');
        redirect('reservaciones/index');
    }

    function debug_to_console($data = null)
    {

        $output = $data;

        if (is_array($output)) {
            $output = implode(',', $output);
        }

        echo "<script>console.log( 'Que vas a probar: " . $output . "' );</script>";
    }

    public function cancelar($id = null)
    {
        $clase = $this->clases_model->obtener_por_id($id)->row();

        if (!$clase) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'No se han podido encontrar todas las clases que desea cancelar.');
            redirect('clases/index');
        }

        if ($clase->reservado > 0) {
            $this->session->set_flashdata('MENSAJE_ERROR', 'La clase que intenta cancelar ya tiene reservaciones hechas, por favor cancele todas las reservaciones antes de cancelar esta clase.');
            redirect('clases/index');
        }

        $identificador = $clase->identificador;

        $identificador_cancelado = $identificador . ' CANCELADO';

        $clase_a_cancelar = $this->clases_model->editar(
            $id,
            array(
                'identificador' => $identificador_cancelado,
                'estatus' => 'Cancelada',
            )
        );

        if ($clase_a_cancelar) {
            $this->session->set_flashdata('MENSAJE_EXITO', 'La clase ' . $id . ' ha sido cancelada.');
            redirect('clases/index');
        }

        $this->session->set_flashdata('MENSAJE_ERROR', 'La clase ' . $id . ' no ha podido ser cancelada.');
        redirect('clases/index');
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

        $result = $this->clases_model->borrar($id);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        // $this->session->set_flashdata('MENSAJE_ERROR', 'La clase ' . $id . ' no ha podido ser borrada.');
        // redirect('clases/index');
    }

    /** Módulo de Clases Online [Inicio] */

    /**
     * Prueba de clases por streaming
     */

    public function index_clases_en_linea()
    {

        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Clases por Streaming';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "clases/index_clases_en_linea";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'clases/index_clases_en_linea';
        $data['regresar_a'] = 'inicio';

        $this->construir_private_site_ui('clases/index_clases_en_linea', $data);
    }

    public function nueva_clase_streaming()
    {
        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Nueva clase por streaming';


        /** JS propio del controlador */
        $controlador_js = "clases/nueva_clase_streaming";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );


        /** Configuracion del formulario */
        $data['controlador'] = 'clases/nueva_clase_streaming';
        $data['regresar_a'] = 'clases/index_clases_en_linea';

        $this->form_validation->set_rules('identificador', 'Identificador', 'required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
        $this->form_validation->set_rules('url_video', 'Url del video', 'required');
        $this->form_validation->set_rules('url_preview', 'Nombre del archivo de imagen', 'required');
        $this->form_validation->set_rules('tematica', 'Temática', 'required');
        $this->form_validation->set_rules('disciplina_id', 'Disciplina', 'required');
        $this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
        $this->form_validation->set_rules('duracion', 'Duración', 'required');
        $this->form_validation->set_rules('fecha_transmision', 'Fecha', 'required');
        $this->form_validation->set_rules('estatus', 'Estatus', 'required');

        $instructores_list = $this->usuarios_model->obtener_todos_instructores()->result();
        $disciplinas_list = $this->disciplinas_model->get_disciplinas_para_clases_online()->result();

        $data['instructores_list'] = $instructores_list;
        $data['disciplinas_list'] = $disciplinas_list;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('clases/nueva_clase_streaming', $data);
        } else {

            $cupo_lugares = array();

            $lugar = array(
                'no_lugar' => 0,
                'esta_reservado' => false,
                'id_usuario' => '0',
                'nombre_usuario' => 'Control',
            );

            array_push($cupo_lugares, $lugar);

            $cupo_lugares_json = json_encode($cupo_lugares);

            $data_clase = array(
                'identificador' => $this->input->post('identificador'),
                'descripcion' => $this->input->post('descripcion'),
                'url_video' => $this->input->post('url_video'),
                'url_preview' => $this->input->post('url_preview'),
                'tematica' => $this->input->post('tematica'),
                'disciplina_id' => $this->input->post('disciplina_id'),
                'instructor_id' => $this->input->post('instructor_id'),
                'duracion' => $this->input->post('duracion'),
                'fecha_clase' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_transmision')))) . 'T00:00',
                'cupo_lugares' => $cupo_lugares_json,
                'estatus' => $this->input->post('estatus'),
                'fecha_registro' => date('Y-m-d H:i:s'),
            );

            if (!$data_clase) {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. 1');
                redirect($data['regresar_a']);
            }

            if ($this->clases_en_linea_model->insert_clase_streaming($data_clase)) {

                $this->session->set_flashdata('MENSAJE_EXITO', 'La clase por streaming #' . $this->db->insert_id() . ' ha sido registrada correctamente.');
                redirect($data['regresar_a']);
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. 2');
                redirect($data['regresar_a']);
            }

            $this->construir_private_site_ui('clases/nueva_clase_streaming', $data);
        }
    }

    public function editar_clase_streaming($id = null)
    {

        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Editar clase por streaming';


        /** JS propio del controlador */
        $controlador_js = "clases/editar_clase_streaming";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        /** Configuracion del formulario */
        $data['controlador'] = 'clases/editar_clase_streaming/' . $id;
        $data['regresar_a'] = 'clases/index_clases_en_linea';

        $this->form_validation->set_rules('identificador', 'Identificador', 'required');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required');
        $this->form_validation->set_rules('url_video', 'Url del video', 'required');
        $this->form_validation->set_rules('url_preview', 'Nombre del archivo de imagen', 'required');
        $this->form_validation->set_rules('tematica', 'Temática', 'required');
        $this->form_validation->set_rules('disciplina_id', 'Disciplina', 'required');
        $this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
        $this->form_validation->set_rules('duracion', 'Duración', 'required');
        $this->form_validation->set_rules('fecha_transmision', 'Fecha', 'required');
        $this->form_validation->set_rules('estatus', 'Estatus', 'required');

        $clase_a_editar = $this->clases_en_linea_model->get_clase_streaming_por_id($id)->row();

        $instructores_list = $this->usuarios_model->obtener_todos_instructores()->result();
        $disciplinas_list = $this->disciplinas_model->get_disciplinas_para_clases_online()->result();

        $data['clase_a_editar'] = $clase_a_editar;
        $data['instructores_list'] = $instructores_list;
        $data['disciplinas_list'] = $disciplinas_list;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('clases/editar_clase_streaming', $data);
        } else {

            $data_clase = array(
                'identificador' => $this->input->post('identificador'),
                'descripcion' => $this->input->post('descripcion'),
                'url_video' => $this->input->post('url_video'),
                'url_preview' => $this->input->post('url_preview'),
                'tematica' => $this->input->post('tematica'),
                'disciplina_id' => $this->input->post('disciplina_id'),
                'instructor_id' => $this->input->post('instructor_id'),
                'duracion' => $this->input->post('duracion'),
                'fecha_clase' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('fecha_transmision')))) . 'T00:00',
                'estatus' => $this->input->post('estatus'),
            );

            if (!$data_clase) {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. 1');
                redirect($data['regresar_a']);
            }

            if ($this->clases_en_linea_model->update_clase_streaming($id, $data_clase)) {

                $this->session->set_flashdata('MENSAJE_EXITO', 'La clase por streaming #' . $id . ' ha sido editada correctamente.');
                redirect($data['regresar_a']);
            } else {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde. 2');
                redirect($data['regresar_a']);
            }

            $this->construir_private_site_ui('clases/editar_clase_streaming', $data);
        }
    }

    /** Módulo de Clases Online [Fin] */

    /** Métodos Tablas (Inicio) //////////////////////////////////////////////////////////////////////////// */

    /** JSON encoder DINAMICO para la tabla de Portafolios de Inversion */
    public function load_lista_de_todas_las_clases_por_streaming_con_detalles_para_datatables()
    {
        $clases_por_streaming_list = $this->clases_en_linea_model->get_todas_las_clases_en_linea_con_detalles()->result();

        $result = array();

        foreach ($clases_por_streaming_list as $clase_por_streaming) {

            $menu = '
                    <!-- /btn-group -->
                        <button type="button" class="btn btn-light btn-icon dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . site_url('clases/editar_clase_streaming/') . $clase_por_streaming->id . '">Editar</a>
                        </div>
                    <!-- /btn-group -->
                ';

            $cupos_lugares_list = json_decode($clase_por_streaming->cupo_lugares);
            $cupos = "";
            foreach ($cupos_lugares_list as $cupo_lugar_row) {
                $cupos = $cupos . '<br>Lugar: ' . $cupo_lugar_row->no_lugar . ' | Usuario: ' . $cupo_lugar_row->nombre_usuario . ' #' . $cupo_lugar_row->id_usuario;
            }

            $result[] = array(
                "id" => $clase_por_streaming->id,
                "identificador" => $clase_por_streaming->identificador,
                "disciplina" => $clase_por_streaming->disciplina,
                "tematica" => $clase_por_streaming->tematica,
                "instructor" => $clase_por_streaming->instructor,
                "fecha_clase" => date('d/m/Y', strtotime($clase_por_streaming->fecha_clase)),
                "estatus" => ucfirst($clase_por_streaming->estatus),
                "opciones" => $menu,
                "descripcion" => $clase_por_streaming->descripcion,
                "url_preview" => $clase_por_streaming->url_preview,
                "url_video" => $clase_por_streaming->url_video,
                "duracion" => $clase_por_streaming->duracion,
                "reservados" => $clase_por_streaming->reservados,
                "fecha_registro" => date('d/m/Y H:i', strtotime($clase_por_streaming->fecha_registro)),

            );
        }

        echo json_encode(array("data" => $result));
    }

    /** Métodos Tablas (Fin) //////////////////////////////////////////////////////////////////////////// */

    public function agregar_cupo($clase_id = null)
    {
        if (!$clase_id) {
            $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (1)');
            redirect('clases/editar/' . $clase_id);
        }

        $clase_row = $this->clases_model->obtener_por_id($clase_id)->row();

        if (!$clase_row) {
            $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (2)');
            redirect('clases/editar/' . $clase_id);
        }

        if ($clase_row->estatus != "Activa") {
            $this->session->set_flashdata('MENSAJE_INFO', '¡Oops! Al parecer esta clase #' . $clase_row->id . ' ya no se encuentra activa y ha sido marcada como: ' . $clase_row->estatus . '. (3)');
            redirect('clases/editar/' . $clase_id);
        }

        $cupo_actualizado = $clase_row->cupo + 1;

        $cupo_lugares = json_decode($clase_row->cupo_lugares);
        //$max_lugar = max(array_column($cupo_lugares, 'no_lugar')) + 1;

        $no_lugar_array = array();

        foreach ($cupo_lugares as $cupo_lugar_row) {
            array_push($no_lugar_array, $cupo_lugar_row->no_lugar);
        }

        $max_lugar = max($no_lugar_array) + 1;

        if ($cupo_actualizado != $max_lugar or $cupo_actualizado > $max_lugar) {
            $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (4)');
            redirect('clases/editar/' . $clase_id);
        }
        /*else {
            $this->session->set_flashdata('MENSAJE_INFO', ''.$max_lugar.'');
            redirect('clases/editar/'.$clase_id);
        }*/

        $lugar = array(
            'no_lugar' => $cupo_actualizado,
            'esta_reservado' => false,
            'nombre_usuario' => '',
        );

        array_push($cupo_lugares, $lugar);
        $cupo_lugares_json = json_encode($cupo_lugares);

        $data_clase = array(
            'cupo' => $cupo_actualizado,
            'cupo_lugares' => $cupo_lugares_json,
        );

        if ($this->clases_model->editar($clase_row->id, $data_clase)) {
            $this->session->set_flashdata('MENSAJE_EXITO', 'La clase #' . $clase_row->id . ' ha sido modificada con éxito. Cupo actualizado de ' . $clase_row->cupo . ' a ' . $cupo_actualizado . '.');
            redirect('clases/editar/' . $clase_id);
        }

        $this->session->set_flashdata('MENSAJE_ERROR', '¡Oops! Al parecer ha ocurrido un error, por favor intentelo más tarde. (4)');
        redirect('clases/editar/' . $clase_id);
    }
}
