<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planes extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('codigos_model');
        $this->load->model('planes_model');
        $this->load->model('disciplinas_model');
        $this->load->model('planes_categorias_model');
    }

    public function subir_imagen($id = null)
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        $data['menu_wrokflow_activo'] = true;
        $data['pagina_titulo'] = 'Locales';

        //revisar
        $data['controlador'] = 'planes/subir_imagen/' . $id;
        $data['regresar_a'] = 'planes';
        $controlador_js = "planes/subir_imagen";

        $disciplinas_list = $this->disciplinas_model->obtener_todas();
        $plan_row = $this->planes_model->obtener_por_id($id)->row();

        $data["disciplinas_list"] = $disciplinas_list;
        $data["plan_row"] = $plan_row;

        $data["upload_path"] = "almacenamiento/planes";
        $data["allowed_types"] = "jpg";
        $data["max_size"] = "400"; // max_size in kb 
        $data["max_width"] = 1800;
        $data["max_height"] = 1250;
        $data["overwrite"] = true;
        $data["max_filename"] = 100;
        $data["file_name"] = $_FILES["file"]["name"];

        if ($this->input->post('upload') != NULL) {

            $data = array();

            if (!empty($_FILES['file']['name'])) {
                // Set preference 
                $config["upload_path"] = "almacenamiento/planes";
                $config["allowed_types"] = "jpg";
                $config["max_size"] = "400"; // max_size in kb 
                $config["max_width"] = 1800;
                $config["max_height"] = 1250;
                $config["overwrite"] = true;
                $config["max_filename"] = 100;
                $config["file_name"] = $_FILES["file"]["name"];

                // Load upload library 
                $this->load->library('upload', $config);

                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];

                    if (!$this->planes_model->editar($plan_row->id, array("url_infoventa" => base_url() . "almacenamiento/planes/" . $filename))) {
                        redirect(site_url($data['regresar_a']));
                    }

                    $data['response'] = 'successfully uploaded ' . $filename;
                } else {
                    http_response_code(500);
                    $data['response'] = $this->upload->display_errors();
                }
            } else {
                $data['response'] = 'failed';
            }

            // load view 
            $this->construir_private_site_ui('planes/subir_imagen', $data);
        } else {

            // load view 
            $this->construir_private_site_ui('planes/subir_imagen', $data);
        }
    }

    public function prueba()
    {
        // load base_url  
        $this->load->helper('url');

        // Check form submit or not 
        if ($this->input->post('upload') != NULL) {
            $data = array();
            if (!empty($_FILES['file']['name'])) {
                // Set preference 
                $config['upload_path'] = 'uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '100'; // max_size in kb 
                $config['file_name'] = $_FILES['file']['name'];

                // Load upload library 
                $this->load->library('upload', $config);

                // File upload
                if ($this->upload->do_upload('file')) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                    $data['response'] = 'successfully uploaded ' . $filename;
                } else {
                    $data['response'] = 'failed';
                }
            } else {
                $data['response'] = 'failed';
            }
            // load view 
            $this->load->view('user_view', $data);
            $this->construir_private_site_ui('planes/index', $data);
        } else {
            // load view 
            $this->load->view('user_view');
            //$this->construir_private_site_ui('planes/index', $data);
        }
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
            array('es_rel' => true, 'src' => 'planes/index.js'),
        );

        $data['menu_wrokflow_activo'] = true;
        $data['pagina_titulo'] = 'Planes';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $this->construir_private_site_ui('planes/index', $data);
    }

    /** Metodos para formato JSON de las datatables */

    /** JSON encoder para la tabla de clientes */
    public function load_lista_de_todos_los_planes_para_datatable()
    {


        $planes_list = $this->planes_model->get_lista_de_todos_los_planes_limitada()->result();


        $result = array();

        foreach ($planes_list as $plan_row) {



            if ($plan_row->listar_activo == 1) {
                $menu = '<a href="' . site_url("planes/editar/") . $plan_row->listar_id . '">Editar</a>
                |
                <a href="' . site_url("planes/desactivar/") . $plan_row->listar_id . '">Desactivar</a>
                ';
            } elseif ($plan_row->listar_activo == 0) {
                $menu = '<a href="' . site_url("planes/editar/") . $plan_row->listar_id . '">Editar</a>
                |
                <a href="' . site_url("planes/activar/") . $plan_row->listar_id . '">Activar</a>
                ';
            }

            $result[] = array(
                "listar_id" => $plan_row->listar_id,
                "listar_nombre_completo" => mb_strtoupper($plan_row->listar_nombre_completo),
                "listar_orden_venta" => $plan_row->listar_orden_venta,
                "listar_clases_incluidas" => $plan_row->listar_clases_incluidas,
                "listar_vigencia_en_dias" => $plan_row->listar_vigencia_en_dias,
                'codigo' => mb_strtoupper($plan_row->codigo),
                "listar_costo" => $plan_row->listar_costo,
                "es_ilimitado" => $plan_row->es_ilimitado,
                "es_primera" => $plan_row->es_primera,
                "es_estudiante" => $plan_row->es_estudiante,
                "listar_activo" => $plan_row->listar_activo == 1 ? 'Activo' : 'Suspendido',
                "listar_opciones" => $menu,
            );
        }

        echo json_encode(array("data" => $result));
    }

    public function crear()
    {
        /** Carga los mensajes de validaciones para ser usados por los controladores */
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre del plan', 'trim|required|is_unique[planes.nombre]');
        $this->form_validation->set_rules('sku', 'SKU del plan', 'trim|required|is_unique[planes.nombre]');
        $this->form_validation->set_rules('clases_incluidas', 'clases incluidas', 'trim|required');
        $this->form_validation->set_rules('vigencia_en_dias', 'vigencia en días ', 'trim|required');
        $this->form_validation->set_rules('costo', 'costo', 'trim|required');
        $this->form_validation->set_rules('orden_venta', 'Orden de venta', 'trim|required');
        $this->form_validation->set_rules('ilimitado', 'ilimitado', 'required');
        $this->form_validation->set_rules('es_primera', 'es_primera', 'required');
        $this->form_validation->set_rules('es_estudiante', 'es_estudiante', 'required');
        $this->form_validation->set_rules('activado', 'activado', 'required');
        $this->form_validation->set_rules('codigo', 'Código', 'trim');
        $this->form_validation->set_rules('url_infoventa', 'Imagen de información', 'trim');

        // Inicializar vista, scripts y catálogos
        $data['controlador'] = 'planes/crear';
        $data['menu_wrokflow_activo'] = true;
        $data['pagina_titulo'] = 'Nuevo plan';
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/extensions/datedropper.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/datedropper.min.js'),
            array('es_rel' => true, 'src' => 'planes/crear.js'),
        );


        $data['disciplinas'] = $this->disciplinas_model->obtener_todas()->result();
        $data['categorias'] = $this->planes_categorias_model->obtener_todas()->result();

        $codigos_list = $this->codigos_model->get_codigos_activos();
        $data['codigos_list'] = $codigos_list;

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('planes/crear', $data);
        } else {

            if (isset($_FILES) && $_FILES['url_infoventa']['error'] == '0') {

                $config['upload_path'] = './almacenamiento/planes/';
                $config['allowed_types'] = 'jpg';
                //$config['max_width'] = 810;
                //$config['max_height'] = 810;
                $config['max_size'] = '600';
                $config['overwrite'] = true;
                $config['encrypt_name'] = true;
                $config['remove_spaces'] = true;

                if (!is_dir($config['upload_path'])) {
                    $this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['controlador']));
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('url_infoventa')) {

                    $this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors(), site_url($data['controlador']));
                } else {

                    $data_imagen = $this->upload->data();
                    $url_infoventa = base_url('almacenamiento/planes/' . $data_imagen['file_name']);
                }
            } else {
                $url_infoventa = base_url('almacenamiento/planes/default.jpg');
            }

            $this->session->set_flashdata('codigo', $this->input->post('codigo'));

            if ($this->session->userdata("sucursal_asignada")) {
                $dominio_id = $this->session->userdata("sucursal_asignada");
            } else {
                $dominio_id = 2;
            }

            $fecha_registro = date("Y-m-d H:i:s");
            $key_1 = "planes_categorias-" . date("Y-m-d-H-i-s", strtotime($fecha_registro));
            $identificador = hash("crc32b", $key_1);

            // Preparar datos para hacer el insert en la bd
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'sku' => $this->input->post('sku'),
                'dominio_id' => $dominio_id,
                'clases_incluidas' => $this->input->post('clases_incluidas'),
                'vigencia_en_dias' => $this->input->post('vigencia_en_dias'),
                'es_ilimitado' => $this->input->post('ilimitado'),
                'costo' => $this->input->post('costo'),
                'orden_venta' => $this->input->post('orden_venta'),
                'es_primera' => $this->input->post('es_primera'),
                'es_estudiante' => $this->input->post('es_estudiante'),
                'activado' => $this->input->post('activado'),
                'codigo' => $this->input->post('codigo'),
                'terminos_condiciones' => $this->input->post('terminos_condiciones'),
                'url_infoventa' => $url_infoventa,
                'descripcion' => $this->input->post('descripcion'),
            );

            if ($this->planes_model->crear($data)) {

                $plan_id = $this->db->insert_id();

                // Añadir las disciplinas seleccionadas
                foreach ($this->input->post('disciplinas') as $k => $v) {
                    $this->planes_model->agregar_disciplina(array('plan_id' => $plan_id, 'disciplina_id' => $v));
                }

                // Añadir las categorias seleccionadas
                foreach ($this->input->post('categorias') as $k => $v) {
                    $this->planes_model->agregar_categoria(array('identificador' => $identificador, 'plan_id' => $plan_id, 'categoria_id' => $v));
                }

                $this->session->set_flashdata('MENSAJE_EXITO', 'El plan se ha creado correctamente.');
                redirect('planes/index');
            }

            $this->construir_private_site_ui('planes/crear', $data);
        }
    }

    public function editar($id = null)
    {

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        // Inicializar vista, scripts y catálogos
        $data['menu_wrokflow_activo'] = true;
        $data['pagina_titulo'] = 'Editar plan';

        $data['controlador'] = 'planes/editar/' . $id;
        $data['regresar_a'] = 'planes';
        $controlador_js = "planes/editar";

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => true, 'src' => 'planes/editar.js'),

        );

        // Establecer validaciones
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('url_infoventa', 'Imagen de información', 'trim');
        $this->form_validation->set_rules('nombre', 'nombre', 'trim|required');
        $this->form_validation->set_rules('sku', 'SKU', 'trim|required');
        $this->form_validation->set_rules('clases_incluidas', 'clases incluidas', 'trim|required');
        $this->form_validation->set_rules('vigencia_en_dias', 'vigencia en días ', 'trim|required');
        $this->form_validation->set_rules('costo', 'costo', 'trim|required');
        $this->form_validation->set_rules('orden_venta', 'Orden de venta', 'trim|required');
        $this->form_validation->set_rules('ilimitado', 'Ilimitado', 'trim|required');
        $this->form_validation->set_rules('es_primera', 'Es primera', 'trim|required');
        $this->form_validation->set_rules('es_estudiante', 'Es estudiante', 'trim|required');
        $this->form_validation->set_rules('activado', 'Activado', 'trim|required');
        $this->form_validation->set_rules('codigo', 'Código', 'trim');
        $this->form_validation->set_rules('disciplinas[]', 'disciplinas', 'trim');
        $this->form_validation->set_rules('categorias[]', 'categorias', 'trim');
        $this->form_validation->set_rules('terminos_condiciones', 'términos y condiciones', 'trim');
        $this->form_validation->set_rules('descripcion', 'descripción', 'trim');

        $data['disciplinas'] = $this->disciplinas_model->obtener_todas()->result();
        $data['categorias'] = $this->planes_categorias_model->obtener_todas()->result();

        // Verificar que el plan a editar exista, obtener sus datos y pasarlos a la vista
        $plan_a_editar = $this->planes_model->obtener_por_id($id)->row();

        if (!$plan_a_editar) {
            $this->session->set_flashdata('MENSAJE_INFO', 'El plan que intenta editar no existe.');
            redirect('/planes/index');
        }

        $codigos_list = $this->codigos_model->get_codigos_activos();

        $data['codigos_list'] = $codigos_list;
        $data['plan_a_editar'] = $plan_a_editar;
        $data['disciplinas_seleccionadas'] = $this->planes_model->obtener_disciplinas_por_plan_id($id)->result();
        $data['categorias_seleccionadas'] = $this->planes_model->obtener_categorias_por_plan_id($id)->result();

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('planes/editar', $data);
        } else {

            if (isset($_FILES) && $_FILES['url_infoventa']['error'] == '0') {

                $config['upload_path'] = './almacenamiento/planes/';
                $config['allowed_types'] = 'jpg';
                //$config['max_width'] = 810;
                //$config['max_height'] = 810;
                $config['max_size'] = '600';
                $config['overwrite'] = true;
                $config['encrypt_name'] = true;
                $config['remove_spaces'] = true;

                if (!is_dir($config['upload_path'])) {
                    $this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['controlador']));
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('url_infoventa')) {

                    $this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors() . " Imagen", site_url($data['controlador']));
                } else {

                    if ($plan_a_editar->url_infoventa and $plan_a_editar->url_infoventa != base_url('almacenamiento/planes/default.jpg')) {
                        $url_imagen_a_borrar = $plan_a_editar->url_infoventa;
                        $imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
                        unlink($imagen_a_borrar);
                    }

                    $data_imagen = $this->upload->data();

                    $url_infoventa = base_url('almacenamiento/planes/' . $data_imagen['file_name']);
                }
            } else {

                $url_infoventa = $plan_a_editar->url_infoventa;
            }

            $fecha_registro = date("Y-m-d H:i:s");
            $key_1 = "planes_categorias-" . date("Y-m-d-H-i-s", strtotime($fecha_registro));
            $identificador = hash("crc32b", $key_1);

            $data = array(
                'url_infoventa' => $url_infoventa,
                'nombre' => $this->input->post('nombre'),
                'sku' => $this->input->post('sku'),
                'clases_incluidas' => $this->input->post('clases_incluidas'),
                'vigencia_en_dias' => $this->input->post('vigencia_en_dias'),
                'costo' => $this->input->post('costo'),
                'orden_venta' => $this->input->post('orden_venta'),
                'es_ilimitado' => $this->input->post('ilimitado'),
                'es_primera' => $this->input->post('es_primera'),
                'es_estudiante' => $this->input->post('es_estudiante'),
                'activado' => $this->input->post('activado'),
                'codigo' => $this->input->post('codigo'),
                'terminos_condiciones' => $this->input->post('terminos_condiciones'),
                'descripcion' => $this->input->post('descripcion'),
            );

            if ($this->planes_model->editar($id, $data)) {

                // Añadir las disciplinas seleccionadas
                if ($this->planes_model->eliminar_disciplinas($id)) {
                    foreach ($this->input->post('disciplinas') as $k => $v) {
                        $this->planes_model->agregar_disciplina(array('plan_id' => $id, 'disciplina_id' => $v));
                    }
                }

                // Añadir las categorias seleccionadas
                if ($this->planes_model->eliminar_categorias($id)) {
                    foreach ($this->input->post('categorias') as $k => $v) {
                        $this->planes_model->agregar_categoria(array('identificador' => $identificador, 'plan_id' => $id, 'categoria_id' => $v));
                    }
                }

                $this->session->set_flashdata('MENSAJE_EXITO', 'El plan se ha editado correctamente.');
                redirect('/planes/index');
            }

            $this->construir_private_site_ui('planes/editar', $data);
        }
    }

    public function activar($id = null)
    {
        $data = array(
            'activado' => 1,
        );
        $this->planes_model->activar($id, $data);
        redirect('planes/index');
    }

    public function desactivar($id = null)
    {
        $data = array(
            'activado' => 0,
        );
        $this->planes_model->desactivar($id, $data);
        redirect('planes/index');
    }
}
