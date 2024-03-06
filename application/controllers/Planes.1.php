<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Planes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('planes_model');
        $this->load->model('disciplinas_model');
    }

    public function index()
    {
        $data['planes'] = $this->planes_model->obtener_todos();

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => 'planes/index.js'),
        );

        $data['menu_planes_activo'] = true;
        $data['pagina_titulo'] = 'Planes';
        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        $this->construir_private_site_ui('planes/index', $data);

    }

    public function crear()
    {
        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre del plan', 'required|is_unique[planes.nombre]');
        $this->form_validation->set_rules('costo', 'costo', 'required');

        // Inicializar vista, scripts y catálogos
        $data['menu_planes_activo'] = true;
        $data['pagina_titulo'] = 'Nuevo plan';
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'planes/crear.js'),
        );
        $data['disciplinas'] = $this->disciplinas_model->obtener_todas();

        if ($this->form_validation->run() == false) {
            $this->construir_private_site_ui('planes/crear', $data);
        } else {
            // Preparar datos para hacer el insert en la bd
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'costo' => $this->input->post('costo'),
                'terminos_condiciones' => $this->input->post('terminos_condiciones'),
                'vigencia_en_dias' => $this->input->post('vigencia_en_dias'),
                'clases_incluidas' => $this->input->post('clases_incluidas'),
            );

            if ($this->planes_model->crear($data)) {

                $plan_id = $this->db->insert_id();

                // Añadir las disciplinas seleccionadas
                foreach ($this->input->post('disciplinas') as $k => $v) {
                    $this->planes_model->agregar_disciplina(array('plan_id' => $plan_id, 'disciplina_id' => $v));
                }

                $this->session->set_flashdata('MENSAJE_EXITO', 'El plan se ha creado correctamente.');
                redirect('planes/index');
            }

            $this->construir_private_site_ui('planes/crear', $data);
        }

    }

    public function editar($id = null)
    {
        // Establecer validaciones
        $this->form_validation->set_rules('nombre', 'nombre del plan', 'required');
        $this->form_validation->set_rules('costo', 'costo', 'required');

        // Inicializar vista, scripts y catálogos
        $data['menu_planes_activo'] = true;
        $data['pagina_titulo'] = 'Editar plan';
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js'),
            array('es_rel' => false, 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js'),
            array('es_rel' => true, 'src' => 'planes/editar.js'),

        );
        $data['disciplinas'] = $this->disciplinas_model->obtener_todas();

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }

        if ($this->form_validation->run() == false) {

            // Verificar que el plan a editar exista, obtener sus datos y pasarlos a la vista
            $plan_a_editar = $this->planes_model->obtener_por_id($id)->row();

            if (!$plan_a_editar) {
                $this->session->set_flashdata('MENSAJE_INFO', 'El plan que intenta editar no existe.');
                redirect('/planes/index');
            }

            $data['plan_a_editar'] = $plan_a_editar;
            $data['disciplinas_seleccionadas'] = $this->planes_model->obtener_disciplinas_por_plan_id($id);

            $this->construir_private_site_ui('planes/editar', $data);

        } else {

            $data = array(
                'nombre' => $this->input->post('nombre'),
                'costo' => $this->input->post('costo'),
                'terminos_condiciones' => $this->input->post('terminos_condiciones'),
                'vigencia_en_dias' => $this->input->post('vigencia_en_dias'),
                'clases_incluidas' => $this->input->post('clases_incluidas'),
            );

            if ($this->planes_model->editar($id, $data)) {

                // Añadir las disciplinas seleccionadas
                if ($this->planes_model->eliminar_disciplinas($id)) {
                    foreach ($this->input->post('disciplinas') as $k => $v) {
                        $this->planes_model->agregar_disciplina(array('plan_id' => $id, 'disciplina_id' => $v));
                    }
                }

                $this->session->set_flashdata('MENSAJE_EXITO', 'El plan se ha editado correctamente.');
                redirect('/planes/index');
            }

            $this->construir_private_site_ui('planes/editar', $data);

        }

    }

}
