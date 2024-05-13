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
        $data['pagina_titulo'] = 'Categorías de planes';
        $data['pagina_subtitulo'] = 'Registro de categorías de planes';
        $data['pagina_menu_planes_categorias'] = true;

        $data['controlador'] = 'planes_categorias';
        $data['ir_a'] = 'planes_categorias/crear';
        $data['regresar_a'] = 'inicio';
        $controlador_js = 'planes_categorias/index';

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
                'estatus' => !empty($plan_categoria->estatus) ? $plan_categoria->estatus : '',
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
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        $this->form_validation->set_rules('nombre', 'nombre de la categoria', 'required');
        $this->form_validation->set_rules('orden', 'orden', 'required');

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('planes_categorias/crear', $data);
        } else {

            if (isset($_FILES) && $_FILES['url_banner']['error'] == '0') {

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

                $nombre_img_plan = 'default.jpg';
            }

            $fecha_registro = date('Y-m-d H:i:s');
            $key_1 = 'planes_categorias-' . date('Y-m-d-H-i-s', strtotime($fecha_registro));
            $identificador_1 = hash('crc32b', $key_1);

            $data_1 = array(
                'identificador' => $identificador_1,
                'nombre' => $this->input->post('nombre'),
                'url_banner' => $nombre_img_plan,
                'orden' => $this->input->post('orden'),
                'estatus' => $this->input->post('estatus'),
                'fecha_registro' => $fecha_registro,
            );

            if ($this->planes_categorias_model->crear($data_1)) {
                $this->mensaje_del_sistema('MENSAJE_EXITO', 'La categoría de planes se ha agregado correctamente.', $data['ir_a']);
            }

            $this->construir_private_site_ui('planes_categorias/crear', $data);
        }
    }

    public function editar($id = null)
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        $data['pagina_titulo'] = 'Agregar';
        $data['pagina_subtitulo'] = 'Agregar categoría de panes';
        $data['pagina_menu_planes_categorias'] = true;
        $data['menu_wrokflow_activo'] = true;

        $data['controlador'] = 'planes_categorias/editar/' . $id;
        $data['ir_a'] = 'planes_categorias/editar/' . $id;
        $data['regresar_a'] = 'planes_categorias';
        $controlador_js = 'planes_categorias/editar';

        $this->form_validation->set_rules('nombre', 'nombre de la categoria', 'required');
        $this->form_validation->set_rules('orden', 'orden', 'required');

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'planes_categorias/editar.js'),

        );

        $plan_categoria_a_editar_row = $this->planes_categorias_model->obtener_por_id($id)->row();

        if (!$plan_categoria_a_editar_row) {
            $this->mensaje_del_sistema('MENSAJE_ERROR', 'La carpeta de carga no existe&nbsp(1)', $data['regresar_a']);
        }

        $sucursales_list = $this->sucursales_model->get_todas_las_sucursales()->result();

        $data['sucursales_list'] = $sucursales_list;
        $data['plan_categoria_a_editar_row'] = $plan_categoria_a_editar_row;

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('planes_categorias/editar', $data);
        } else {

            if (isset($_FILES) && $_FILES['url_banner']['error'] == '0') {

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

                    if ($plan_categoria_a_editar_row->url_banner and $plan_categoria_a_editar_row->url_banner != 'default.jpg') {
                        $url_imagen_a_borrar = 'almacenamiento/planes_categorias' . $plan_categoria_a_editar_row->url_banner;
                        $imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
                        unlink($imagen_a_borrar);
                    }

                    $data_imagen = $this->upload->data();
                    $nombre_img_perfil = $data_imagen['file_name'];
                }
            } else {

                $nombre_img_perfil = $plan_categoria_a_editar_row->url_banner;
            }

            $data_1 = array(
                'nombre' => $this->input->post('nombre'),
                'orden' => $this->input->post('orden'),
                'estatus' => $this->input->post('estatus'),
                'url_banner' => $nombre_img_perfil,
            );


            if ($this->planes_categorias_model->editar($id, $data_1)) {
                $this->mensaje_del_sistema('MENSAJE_EXITO', 'La categoría de planes se ha editado correctamente.', $data['ir_a']);
            }

            $this->construir_private_site_ui('planes_categorias/editar', $data);
        }
    }
}
