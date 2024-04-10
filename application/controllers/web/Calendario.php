<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Calendario extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Carga el modelo de clases
        $this->load->model('calendario_model');
    }

    public function index($disciplina = null)
    {
        $disciplinas_list = $this->calendario_model->obtener_disciplinas();


        $clases_fin_de_semana = $this->calendario_model->obtener_clases_fin_de_semana_actual();

        $horarios_fin_de_semana = array();


        // Llenar el array con las clases
        foreach ($clases_fin_de_semana as $clase) {
            $hora_inicio = date('g:i A', strtotime($clase['inicia']));
            $dia_semana = date('D', strtotime($clase['inicia']));
            $horarios_fin_de_semana[$hora_inicio][$dia_semana] = $clase['instructor_id'] . ' ' . $clase['id'];
        }

        $data['disciplinas_list'] = $disciplinas_list;
        $data['horarios_fin_de_semana'] = $horarios_fin_de_semana;

        // Cargar la vista
        $this->load->view('web/calendario/index', $data);
    }

    public function dibujar_tabla_calendario($disciplina_id = null)
    {
        // Obtener las clases de la semana actual desde el modelo
        $clases_semana = $this->calendario_model->obtener_clases_semana_actual_por_disciplina_id($disciplina_id);

        // Array para organizar las clases por hora y día
        $horarios_semana = array();

        // Llenar el array con las clases
        foreach ($clases_semana as $clase) {
            $hora_inicio = date('g:i A', strtotime($clase['inicia']));
            $dia_semana = date('D', strtotime($clase['inicia']));
            $horarios_semana[$hora_inicio][$dia_semana] = $clase['instructor_id'] . ' ' . $clase['id'];
        }

        $response = array('success' => true, 'data' => $horarios_semana);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
