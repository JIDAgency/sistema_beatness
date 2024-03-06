<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Membresias extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('membresias_model');
    }

    public function index()
    {
        $data['membresias'] = $this->membresias_model->obtener_todas();

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => 'membresias/index.js'),
        );

        $data['menu_membresias_activo'] = true;
        $data['pagina_titulo'] = 'Membresías';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $this->construir_private_site_ui('membresias/index', $data);

    }

    public function crear()
    {
        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la membresía', 'required|is_unique[membresias.nombre]');
        $this->form_validation->set_rules('costo', 'costo', 'required');

        // Inicializar vista, scripts y catálogos
        $data['menu_membresias_activo'] = true;
        $data['pagina_titulo'] = 'Nueva membresía';
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'membresias/crear.js'),
        );

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('membresias/crear', $data);
        } else {
            // Preparar datos para hacer el insert en la bd
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'costo' => $this->input->post('costo'),
                'descripcion' => $this->input->post('descripcion'),
                'tipo' => $this->input->post('tipo'),
                'clases_incluidas' => $this->input->post('clases_incluidas'),
            );

            if ($this->membresias_model->crear($data)) {
                $this->session->set_flashdata('MENSAJE_EXITO', 'La membresía se ha creado correctamente.');
                redirect('membresias/index');
            }

            $this->construir_private_site_ui('membresias/crear', $data);
        }

    }

    public function editar($id = null)
    {
        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre de la membresía', 'required');
        $this->form_validation->set_rules('costo', 'costo', 'required');

        // Inicializar vista, scripts y catálogos
        $data['menu_membresias_activo'] = true;
        $data['pagina_titulo'] = 'Editar membresía';
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'membresias/editar.js'),

        );

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        if ($this->form_validation->run() == false) {

            // Verificar que la membresía a editar exista, obtener sus datos y pasarlos a la vista
            $membresia_a_editar = $this->membresias_model->obtener_por_id($id)->row();

            if (!$membresia_a_editar) {
                $this->session->set_flashdata('MENSAJE_INFO', 'La membresía que intenta editar no existe.');
                redirect('/membresias/index');
            }

            $data['membresia_a_editar'] = $membresia_a_editar;

            $this->construir_private_site_ui('membresias/editar', $data);

        } else {

            $data = array(
                'nombre' => $this->input->post('nombre'),
                'costo' => $this->input->post('costo'),
                'descripcion' => $this->input->post('descripcion'),
                'tipo' => $this->input->post('tipo'),
                'clases_incluidas' => $this->input->post('clases_incluidas'),
            );

            if ($this->membresias_model->editar($id, $data)) {
                log_message('debug', $this->db->last_query());
                $this->session->set_flashdata('MENSAJE_EXITO', 'La membresía se ha editado correctamente.');
                redirect('/membresias/index');
            }

            $this->construir_private_site_ui('membresias/editar', $data);

        }

    }

}
