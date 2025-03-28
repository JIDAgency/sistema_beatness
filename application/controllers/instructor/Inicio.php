<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends MY_Controller
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


        $this->load->model('instructor_model');
    }

    public function index()
    {
        $data['menu_instructor_inicio'] = true;
        $data['pagina_titulo'] = 'Inicio';

        //revisar
        $data['controlador'] = 'instructor/inicio';
        $data['regresar_a'] = 'instructor/inicio';
        $controlador_js = "instructor/inicio/index";

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        // Cargar estilos y scripts
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js'),
            array('es_rel' => true, 'src' => $controlador_js . '.js'),
        );

        $this->instructor_ui('instructor/inicio/index', $data);
    }

    public function obtener_tabla_index()
    {
        $instructor_id = $this->session->userdata('id');
        $clases_list = $this->instructor_model->clases_obtener_por_instructor_id($instructor_id)->result();

        // Obtén todos los usuarios y crea un mapa: id => nombre completo
        $usuarios = $this->usuarios_model->obtener_todos()->result();
        $usuarios_map = array();
        foreach ($usuarios as $u) {
            $usuarios_map[$u->id] = $u->nombre_completo . " " . $u->apellido_paterno . " " . $u->apellido_materno;
        }

        $result = array();
        foreach ($clases_list as $clase_key => $clase_value) {
            $reservaciones = "";
            $i = 0;
            $lugares_list = json_decode($clase_value->cupo_lugares);
            if (is_array($lugares_list)) {
                foreach ($lugares_list as $lugar) {
                    if (!empty($lugar->nombre_usuario)) {
                        $i++;
                        if (is_numeric($lugar->nombre_usuario) && isset($usuarios_map[$lugar->nombre_usuario])) {
                            $nombre_cliente = $usuarios_map[$lugar->nombre_usuario];
                        } else {
                            $nombre_cliente = "#" . $lugar->nombre_usuario;
                        }
                        $reservaciones .= $i . "-. Lugar: " . $lugar->no_lugar . " | Cliente: " . mb_strtoupper($nombre_cliente) . "<br>";
                    }
                }
            }

            $result[] = array(
                'id'             => $clase_key + 1,
                'estatus'        => $clase_value->estatus,
                'disciplina'     => $clase_value->disciplina_nombre,
                'dificultad'     => $clase_value->dificultad,
                'fecha'          => date("Y-m-d", strtotime($clase_value->inicia)),
                'horario'        => date("H:i", strtotime($clase_value->inicia)),
                'cupos'          => $clase_value->reservado . '/' . $clase_value->cupo,
                'reservaciones'  => $reservaciones,
            );
        }

        echo json_encode($result);
    }
}
