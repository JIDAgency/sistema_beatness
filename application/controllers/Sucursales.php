<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sucursales extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sucursales_model');
        $this->load->model('disciplinas_model');
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
            array('es_rel' => true, 'src' => 'sucursales/index.js'),
        );

        $data['menu_sucursales_activo'] = true;
        $data['pagina_titulo'] = 'Sucursales';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $this->construir_private_site_ui('sucursales/index', $data);
    }

    /** JSON encoder para la tabla de Usuarios */
    public function load_lista_de_todas_las_sucursales_de_la_plantilla_para_datatable()
    {

        $sucursales_list = $this->sucursales_model->get_todas_las_sucursales()->result();

        $result = array();

        foreach ($sucursales_list as $sucursales_row) {

            $menu = '<a href="' . site_url("sucursales/editar/") . $sucursales_row->id . '">Editar</a>';

            $result[] = array(
                "listar_id" => $sucursales_row->id,
                "listar_nombre" => $sucursales_row->nombre . ' [' . $sucursales_row->locacion . ']',
                "listar_orden_mostrar" => $sucursales_row->orden_mostrar . ' º',
                "listar_visible_app" => ucfirst($sucursales_row->visible_app),
                "listar_estatus" => ucfirst($sucursales_row->estatus),
                "listar_opciones" => $menu,
            );
        }

        echo json_encode(array("data" => $result));
    }

    public function crear()
    {
        // Inicializar vista, scripts y catálogos
        $data['menu_sucursales_activo'] = true;
        $data['pagina_titulo'] = 'Crear sucursal';

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'sucursales/crear.js'),
        );

        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la disciplina', 'required');
        $this->form_validation->set_rules('locacion', 'locacion', 'required');
        $this->form_validation->set_rules('descripcion', 'descripcion de sucursal', 'required');
        $this->form_validation->set_rules('direccion', 'direccion', 'required');
        $this->form_validation->set_rules('url', 'url', 'required');
        $this->form_validation->set_rules('url_whatsapp', 'whatsapp', 'required');
        $this->form_validation->set_rules('url_ubicacion', 'ubicacion', 'required');
        $this->form_validation->set_rules('url_logo', 'logotipo', 'required');
        $this->form_validation->set_rules('url_banner', 'banner', 'required');
        $this->form_validation->set_rules('orden_mostrar', 'orden', 'required');
        $this->form_validation->set_rules('visible_app', 'visible_app', 'required');
        $this->form_validation->set_rules('estatus', 'seleccione un estatus', 'required');


        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('sucursales/crear', $data);
        } else {

            $data = array(
                'nombre' => $this->input->post('nombre'),
                'locacion' => $this->input->post('locacion'),
                'descripcion' => $this->input->post('descripcion'),
                'direccion' => $this->input->post('direccion'),
                'url' => $this->input->post('url'),
                'url_whatsapp' => $this->input->post('url_whatsapp'),
                'url_ubicacion' => $this->input->post('url_ubicacion'),
                'url_logo' => $this->input->post('url_logo'),
                'url_banner' => $this->input->post('url_banner'),
                'orden_mostrar' => $this->input->post('orden_mostrar'),
                'visible_app' => $this->input->post('visible_app'),
                'estatus' => $this->input->post('estatus'),

            );

            if ($this->sucursales_model->insert_sucursal($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La sucursal se ha creado correctamente.');
                redirect('sucursales/index');
            }

            $this->construir_private_site_ui('sucursales/crear', $data);
        }
    }


    public function editar($id = null)
    {
        // Inicializar vista, scripts y catálogos
        $data['menu_sucursales_activo'] = true;
        $data['pagina_titulo'] = 'Editar sucursal';

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'sucursales/editar.js'),
        );

        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la disciplina', 'required');
        $this->form_validation->set_rules('locacion', 'locacion', 'required');
        $this->form_validation->set_rules('descripcion', 'descripcion de sucursal', 'required');
        $this->form_validation->set_rules('direccion', 'direccion', 'required');
        $this->form_validation->set_rules('url', 'url', 'required');
        $this->form_validation->set_rules('url_whatsapp', 'whatsapp', 'required');
        $this->form_validation->set_rules('url_ubicacion', 'ubicacion', 'required');
        $this->form_validation->set_rules('url_logo', 'logotipo', 'required');
        $this->form_validation->set_rules('url_banner', 'banner', 'required');
        $this->form_validation->set_rules('orden_mostrar', 'orden', 'required');
        $this->form_validation->set_rules('visible_app', 'visible_app', 'required');
        $this->form_validation->set_rules('estatus', 'seleccione un estatus', 'required');

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        // Verificar que la membresía a editar exista, obtener sus datos y pasarlos a la vista
        $sucursal_a_editar_row = $this->sucursales_model->get_sucursal_por_id($id)->row();

        if (!$sucursal_a_editar_row) {
            $this->session->set_flashdata('MENSAJE_INFO', '¡Oops!, Al parecer la sucursal que intenta consultar no existe.');
            redirect('sucursales/index');
        }

        $data['sucursal_a_editar_row'] = $sucursal_a_editar_row;

        if ($this->form_validation->run() == false) {

            $this->construir_private_site_ui('sucursales/editar', $data);
        } else {

            $data = array(
                'nombre' => $this->input->post('nombre'),
                'locacion' => $this->input->post('locacion'),
                'descripcion' => $this->input->post('descripcion'),
                'direccion' => $this->input->post('direccion'),
                'url' => $this->input->post('url'),
                'url_whatsapp' => $this->input->post('url_whatsapp'),
                'url_ubicacion' => $this->input->post('url_ubicacion'),
                'url_logo' => $this->input->post('url_logo'),
                'url_banner' => $this->input->post('url_banner'),
                'orden_mostrar' => $this->input->post('orden_mostrar'),
                'visible_app' => $this->input->post('visible_app'),
                'estatus' => $this->input->post('estatus'),

            );

            if ($this->sucursales_model->update_sucursal($id, $data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La sucursal se ha editado correctamente.');
                redirect('sucursales/index');
            }

            $this->construir_private_site_ui('sucursales/editar', $data);
        }
    }
}
