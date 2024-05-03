<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planes_categorias extends MY_Controller
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
        $this->load->model('planes_categorias_model');
        $this->load->model('sucursales_model');
    }

    public function index()
    {
        $data['menu_discplinas_activo'] = true;
        $data['pagina_titulo'] = 'Lista de planes-categorias';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
        $controlador_js = "planes_categorias/index";

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->construir_private_site_ui('planes_categorias/index', $data);
    }

    public function obtener_tabla_index()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $planes_categorias_list = $this->planes_categorias_model->get_planes_categorias();

        $data = [];

        foreach ($planes_categorias_list->result() as $plan_categoria) {

            $opciones = '<a href="' . site_url("planes_categorias/editar/") . $plan_categoria->id . '">Editar</a>';

            $data[] = array(
                'id' => $plan_categoria->id,
                'identificador' => !empty($plan_categoria->identificador) ? $plan_categoria->identificador : '',
                'nombre' => !empty($plan_categoria->nombre) ? ucfirst($plan_categoria->nombre) : '',
                'orden' => !empty($plan_categoria->orden) ? $plan_categoria->orden : '',
                'fecha_registro' => (!empty($plan_categoria->fecha_registro) ? date('Y/m/d H:i:s', strtotime($plan_categoria->fecha_registro)) : ''),
                'opciones' => $opciones,
            );
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $planes_categorias_list->num_rows(),
            'recordsFiltered' => $planes_categorias_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    public function crear()
    {
        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la categoria', 'required');
        $this->form_validation->set_rules('orden', 'orden', 'required');

        // Inicializar vista, scripts
        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Crear plan-categoria';

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'planes_categorias/crear.js'),

        );

        // Validar que existan disciplinas disponibles
        // $disciplinas = $this->disciplinas_model->get_lista_de_disciplinas_para_crear_y_editar_clases();

        // if ($disciplinas->num_rows() == 0) {
        //     $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
        //     redirect('planes_categorias/index');
        // }

        // $data['disciplinas'] = $disciplinas;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('planes_categorias/crear', $data);
        } else {

            if (isset($_FILES) && $_FILES['url_banner']['error'] == '0') {

                $config['upload_path']   = './almacenamiento/categoria_planes/';
                $config['allowed_types'] = 'jpg';
                // $config['max_width'] = 1200;
                // $config['max_height'] = 1200;
                // $config['max_size'] = '600';
                $config['overwrite']     = true;
                $config['encrypt_name']  = true;
                $config['remove_spaces'] = true;

                if (!is_dir($config['upload_path'])) {
                    $this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['planes_categorias/index']));
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('url_banner')) {

                    $this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors(), site_url($data['planes_categorias/index']));
                } else {
                    $data_imagen = $this->upload->data();
                    $nombre_img_plan = $data_imagen['file_name'];
                }
            } else {

                $nombre_img_plan = 'default.jpg';
            }

            $fecha_registro = date("Y-m-d H:i:s");
            $key_1 = "planes_categorias-" . date("Y-m-d-H-i-s", strtotime($fecha_registro));
            $identificador = hash("crc32b", $key_1);

            // Preparar datos para hacer el insert en la bd
            $data = array(
                'identificador' => $identificador,
                'nombre' => $this->input->post('nombre'),
                'url_banner' => $nombre_img_plan,
                'orden' => $this->input->post('orden'),
                'fecha_registro' => $fecha_registro,
            );

            if ($this->planes_categorias_model->crear($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'El plan - categoria se ha creado correctamente.');
                redirect('planes_categorias/index');
            }

            $this->construir_private_site_ui('planes_categorias/crear', $data);
        }
    }

    public function editar($id = null)
    {
        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la categoria', 'required');
        $this->form_validation->set_rules('orden', 'orden', 'required');

        // Inicializar vista, scripts y catálogos
        $data['menu_clases_activo'] = true;
        $data['pagina_titulo'] = 'Editar categorias';
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'categorias/editar.js'),

        );

        // $disciplinas = $this->disciplinas_model->get_lista_de_disciplinas_para_crear_y_editar_clases();

        // if ($disciplinas->num_rows() == 0) {
        //     $this->session->set_flashdata('MENSAJE_INFO', 'Es necesario que exista por lo menos alguna disciplina disponible para poder crear la clase.');
        //     redirect('planes_categorias/index');
        // }

        // $data['disciplinas'] = $disciplinas;

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        $plan_categoria_a_editar_row = $this->planes_categorias_model->obtener_por_id($id)->row();

        $sucursales_list = $this->sucursales_model->get_todas_las_sucursales()->result();

        $data['sucursales_list'] = $sucursales_list;

        if (!$plan_categoria_a_editar_row) {
            $this->session->set_flashdata('MENSAJE_INFO', 'La categoria que intenta editar no existe.');
            redirect('/planes_categorias/index');
        }

        $data['plan_categoria_a_editar_row'] = $plan_categoria_a_editar_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('planes_categorias/editar', $data);
        } else {

            if (isset($_FILES) && $_FILES['url_banner']['error'] == '0') {

                $config['upload_path']   = './almacenamiento/categoria_planes/';
                $config['allowed_types'] = 'jpg';
                // $config['max_width'] = 1200;
                // $config['max_height'] = 1200;
                // $config['max_size'] = '600';
                $config['overwrite']     = true;
                $config['encrypt_name']  = true;
                $config['remove_spaces'] = true;

                if (!is_dir($config['upload_path'])) {
                    $this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['controlador']));
                }

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('url_banner')) {

                    $this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors(), site_url($data['controlador']));
                } else {

                    if ($plan_categoria_a_editar_row->url_banner and $plan_categoria_a_editar_row->url_banner != "default.jpg") {
                        $url_imagen_a_borrar = "almacenamiento/categoria_planes" . $plan_categoria_a_editar_row->url_banner;
                        $imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
                        unlink($imagen_a_borrar);
                    }

                    $data_imagen = $this->upload->data();
                    $nombre_img_perfil = $data_imagen['file_name'];
                }
            } else {

                $nombre_img_perfil = $plan_categoria_a_editar_row->url_banner;
            }

            $data = array(
                'nombre' => $this->input->post('nombre'),
                'orden' => $this->input->post('orden'),
                'url_banner' => $nombre_img_perfil,
            );


            if ($this->planes_categorias_model->editar($id, $data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La categoria se ha editado correctamente.');
                redirect('/planes_categorias/index');
            }

            $this->construir_private_site_ui('planes_categorias/editar', $data);
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
