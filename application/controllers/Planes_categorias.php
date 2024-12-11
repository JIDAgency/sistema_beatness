<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controlador para la gestión de las categorías de planes.
 * 
 * Este controlador permite:
 * - Listar las categorías de planes
 * - Ver tanto las categorías activas como las suspendidas
 * - Crear nuevas categorías
 * - Editar categorías existentes
 * 
 * Depende de múltiples modelos para manejar datos relacionados con planes, usuarios, sucursales, etc.
 */
class Planes_categorias extends MY_Controller
{
    /**
     * Constructor de la clase.
     * 
     * Se cargan los modelos necesarios para las operaciones de planes, categorías, usuarios, etc.
     */
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
        $this->load->model('planes_categorias_model');
        $this->load->model('sucursales_model');
    }

    /**
     * Muestra la página principal de las categorías de planes.
     * 
     * Incluye la vista principal con la tabla de categorías.
     */
    public function index()
    {
        // Datos para la vista
        $data['pagina_titulo'] = 'Categorías de planes';
        $data['pagina_subtitulo'] = 'Registro de categorías de planes';
        $data['pagina_menu_planes_categorias'] = true;
        $data['controlador'] = 'planes_categorias';
        $data['ir_a'] = 'planes_categorias/crear';
        $data['regresar_a'] = 'inicio';
        $controlador_js = 'planes_categorias/index';

        // Estilos y Scripts para la tabla
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => $controlador_js . '.js'),
        );

        // Construye la vista privada
        $this->construir_private_site_ui('planes_categorias/index', $data);
    }

    /**
     * Obtiene la información de las categorías de planes (activas) en formato JSON para poblar la tabla DataTables.
     * 
     * Este método es llamado usualmente mediante una petición AJAX.
     */
    public function obtener_tabla_index()
    {
        // Parámetros de DataTables
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        // Obtener datos desde el modelo
        $planes_categorias_list = $this->planes_categorias_model->get_planes_categorias();

        $data = [];
        foreach ($planes_categorias_list->result() as $plan_categoria) {
            // Opciones de acción para cada fila
            $opciones = '<a href="' . site_url("planes_categorias/editar/" . $plan_categoria->id) . '">Editar</a>';

            $data[] = array(
                'opciones' => $opciones,
                'id' => $plan_categoria->id,
                'url_banner' => '<img src="' . base_url('almacenamiento/planes_categorias/' . $plan_categoria->url_banner) . '" class="img-fluid">',
                'orden' => !empty($plan_categoria->orden) ? $plan_categoria->orden : '',
                'nombre' => !empty($plan_categoria->nombre) ? ucfirst($plan_categoria->nombre) : '',
                'identificador' => !empty($plan_categoria->identificador) ? $plan_categoria->identificador : '',
                'estatus' => !empty($plan_categoria->estatus) ? ucfirst($plan_categoria->estatus) : '',
                'fecha_registro' => (!empty($plan_categoria->fecha_registro) ? date('d/m/Y', strtotime($plan_categoria->fecha_registro)) : ''),
            );
        }

        // Resultado en formato requerido por DataTables
        $result = array(
            'draw' => $draw,
            'recordsTotal' => $planes_categorias_list->num_rows(),
            'recordsFiltered' => $planes_categorias_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    /**
     * Obtiene la información de las categorías de planes suspendidas en formato JSON para poblar la tabla DataTables.
     * 
     * Este método es llamado usualmente mediante una petición AJAX.
     */
    public function obtener_tabla_index_suspendidos()
    {
        // Parámetros de DataTables
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        // Obtener datos desde el modelo
        $planes_categorias_suspendidas_list = $this->planes_categorias_model->get_planes_categorias_suspendidas();

        $data = [];
        foreach ($planes_categorias_suspendidas_list->result() as $plan_categoria) {
            // Opciones de acción para cada fila
            $opciones = '<a href="' . site_url("planes_categorias/editar/" . $plan_categoria->id) . '">Editar</a>';

            $data[] = array(
                'opciones' => $opciones,
                'id' => $plan_categoria->id,
                'url_banner' => '<img src="' . base_url('almacenamiento/planes_categorias/' . $plan_categoria->url_banner) . '" class="img-fluid">',
                'orden' => !empty($plan_categoria->orden) ? $plan_categoria->orden : '',
                'nombre' => !empty($plan_categoria->nombre) ? ucfirst($plan_categoria->nombre) : '',
                'identificador' => !empty($plan_categoria->identificador) ? $plan_categoria->identificador : '',
                'estatus' => !empty($plan_categoria->estatus) ? ucfirst($plan_categoria->estatus) : '',
                'fecha_registro' => (!empty($plan_categoria->fecha_registro) ? date('d/m/Y', strtotime($plan_categoria->fecha_registro)) : ''),
            );
        }

        // Resultado en formato requerido por DataTables
        $result = array(
            'draw' => $draw,
            'recordsTotal' => $planes_categorias_suspendidas_list->num_rows(),
            'recordsFiltered' => $planes_categorias_suspendidas_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    /**
     * Muestra el formulario de creación de una nueva categoría de planes.
     * 
     * Valida el formulario y, si es correcto, crea un nuevo registro en la base de datos.
     */
    public function crear()
    {
        // Datos para la vista
        $data['pagina_titulo'] = 'Agregar';
        $data['pagina_subtitulo'] = 'Agregar categoría de panes';
        $data['pagina_menu_planes_categorias'] = true;
        $data['controlador'] = 'planes_categorias/crear';
        $data['ir_a'] = 'planes_categorias';
        $data['regresar_a'] = 'planes_categorias';
        $controlador_js = 'planes_categorias/crear';

        $data['menu_wrokflow_activo'] = true;
        $data['pagina_titulo'] = 'Crear plan-categoria';

        $data['styles'] = array();
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => $controlador_js . '.js'),
        );

        // Reglas de validación
        $this->form_validation->set_rules('nombre', 'nombre de la categoria', 'required');
        $this->form_validation->set_rules('orden', 'orden', 'required');

        // Mostrar formulario en caso de que no se cumpla la validación
        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('planes_categorias/crear', $data);
        } else {
            // Si la validación es exitosa, procesamos la imagen si existe
            if (isset($_FILES) && $_FILES['url_banner']['error'] == '0') {
                // Configuración de carga de imagen
                $config['upload_path']   = './almacenamiento/planes_categorias/';
                $config['allowed_types'] = 'jpg';
                $config['max_width'] = 1200;
                $config['max_height'] = 1200;
                $config['max_size'] = '600';
                $config['overwrite']     = true;
                $config['encrypt_name']  = true;
                $config['remove_spaces'] = true;

                if (!is_dir($config['upload_path'])) {
                    $this->mensaje_del_sistema('MENSAJE_ERROR', 'La carpeta de carga no existe.&nbsp(1)', $data['controlador']);
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('url_banner')) {
                    $this->mensaje_del_sistema('MENSAJE_ERROR', $this->upload->display_errors() . '&nbsp(2)', $data['controlador']);
                } else {
                    $data_imagen = $this->upload->data();
                    $nombre_img_plan = $data_imagen['file_name'];
                }
            } else {
                // Si no se sube imagen, se asigna una por defecto
                $nombre_img_plan = 'default.jpg';
            }

            // Generar identificador único
            $fecha_registro = date('Y-m-d H:i:s');
            $key_1 = 'planes_categorias-' . date('Y-m-d-H-i-s', strtotime($fecha_registro));
            $identificador_1 = hash('crc32b', $key_1);

            // Datos a guardar
            $data_1 = array(
                'identificador' => $identificador_1,
                'nombre' => $this->input->post('nombre'),
                'url_banner' => $nombre_img_plan,
                'orden' => $this->input->post('orden'),
                'estatus' => $this->input->post('estatus'),
                'fecha_registro' => $fecha_registro,
            );

            // Insertar en la base de datos
            if ($this->planes_categorias_model->crear($data_1)) {
                $this->mensaje_del_sistema('MENSAJE_EXITO', 'La categoría de planes se ha agregado correctamente.', $data['ir_a']);
            }

            $this->construir_private_site_ui('planes_categorias/crear', $data);
        }
    }

    /**
     * Muestra el formulario de edición de una categoría de planes existente.
     * 
     * Valida el formulario y, si es correcto, actualiza el registro en la base de datos.
     * 
     * @param int|null $id Identificador de la categoría a editar.
     */
    public function editar($id = null)
    {
        // Si se recibe post, sobreescribir el ID
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        // Datos para la vista
        $data['pagina_titulo'] = 'Agregar';
        $data['pagina_subtitulo'] = 'Agregar categoría de panes';
        $data['pagina_menu_planes_categorias'] = true;
        $data['menu_wrokflow_activo'] = true;
        $data['controlador'] = 'planes_categorias/editar/' . $id;
        $data['ir_a'] = 'planes_categorias/editar/' . $id;
        $data['regresar_a'] = 'planes_categorias';
        $controlador_js = 'planes_categorias/editar';

        // Reglas de validación
        $this->form_validation->set_rules('nombre', 'nombre de la categoria', 'required');
        $this->form_validation->set_rules('orden', 'orden', 'required');

        // Scripts para validación
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'planes_categorias/editar.js'),
        );

        // Obtener la categoría a editar
        $plan_categoria_a_editar_row = $this->planes_categorias_model->obtener_por_id($id)->row();
        if (!$plan_categoria_a_editar_row) {
            $this->mensaje_del_sistema('MENSAJE_ERROR', 'La carpeta de carga no existe&nbsp(1)', $data['regresar_a']);
        }

        $planes_en_categoria_list = $this->planes_categorias_model->obtener_planes_de_la_categoria_list($id)->result();

        // Obtener lista de sucursales (si aplica para vista)
        $sucursales_list = $this->sucursales_model->get_todas_las_sucursales()->result();
        $data['sucursales_list'] = $sucursales_list;
        $data['plan_categoria_a_editar_row'] = $plan_categoria_a_editar_row;
        $data['planes_en_categoria_list'] = $planes_en_categoria_list;

        // Mostrar formulario si validación no supera
        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('planes_categorias/editar', $data);
        } else {
            // Procesar imagen si se ha subido
            if (isset($_FILES) && $_FILES['url_banner']['error'] == '0') {
                // Configuración de carga
                $config['upload_path']   = './almacenamiento/planes_categorias/';
                $config['allowed_types'] = 'jpg';
                $config['max_width'] = 1200;
                $config['max_height'] = 1200;
                $config['max_size'] = '600';
                $config['overwrite']     = true;
                $config['encrypt_name']  = true;
                $config['remove_spaces'] = true;

                if (!is_dir($config['upload_path'])) {
                    $this->mensaje_del_sistema('MENSAJE_ERROR', 'La carpeta de carga no existe.&nbsp(2)', $data['controlador']);
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('url_banner')) {
                    $this->mensaje_del_sistema('MENSAJE_ERROR', $this->upload->display_errors() . '&nbsp(3)', $data['controlador']);
                } else {
                    // Borrar imagen previa si existe y no es la default
                    if ($plan_categoria_a_editar_row->url_banner && $plan_categoria_a_editar_row->url_banner != 'default.jpg') {
                        $url_imagen_a_borrar = 'almacenamiento/planes_categorias' . $plan_categoria_a_editar_row->url_banner;
                        $imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
                        unlink($imagen_a_borrar);
                    }

                    $data_imagen = $this->upload->data();
                    $nombre_img_perfil = $data_imagen['file_name'];
                }
            } else {
                // Mantener la imagen actual si no se sube nada
                $nombre_img_perfil = $plan_categoria_a_editar_row->url_banner;
            }

            // Datos a actualizar
            $data_1 = array(
                'nombre' => $this->input->post('nombre'),
                'orden' => $this->input->post('orden'),
                'estatus' => $this->input->post('estatus'),
                'url_banner' => $nombre_img_perfil,
            );

            // Actualizar en base de datos
            if ($this->planes_categorias_model->editar($id, $data_1)) {
                $this->mensaje_del_sistema('MENSAJE_EXITO', 'La categoría de planes se ha editado correctamente.', $data['ir_a']);
            }

            $this->construir_private_site_ui('planes_categorias/editar', $data);
        }
    }
}
