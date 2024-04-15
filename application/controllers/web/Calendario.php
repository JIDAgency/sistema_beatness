<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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

        $data['disciplinas_list'] = $disciplinas_list;

        $this->load->view('web/calendario/index', $data);
    }

    public function obtener_clases_semana_actual_por_disciplina_id($disciplina_id = null)
    {
        $clases_semana = $this->calendario_model->obtener_clases_semana_actual_por_disciplina_id($disciplina_id);

        $horarios_semana = array();

        foreach ($clases_semana as $clase) {
            $hora_inicio = date('g:i A', strtotime($clase['inicia']));
            $dia_semana = date('D', strtotime($clase['inicia']));
            $horarios_semana[$hora_inicio][$dia_semana] = $clase['instructor_nombre'];
        }

        $contenido = '
        <table class="semana responsive">
            <thead>
                <tr>
                    <th class="">Horario</th>
                    <th class="">Lun</th>
                    <th class="">Mar</th>
                    <th class="">Mie</th>
                    <th class="">Jue</th>
                    <th class="">Vie</th>
                </tr>
            </thead>
            <tbody>
        ';

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            if ($es_tarde && ($ciclo_es_tarde === false)) {
                $contenido .= '<tr>';
                $contenido .= '<td> </td>';
                foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
                    $contenido .= '<td> </td>';
                }
                $contenido .= '</tr>';
                $ciclo_es_tarde = true;
            }

            $contenido .= '<tr>';
            $contenido .= '<td class="">' . $hora . '</td>';
            foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
                $contenido .= '<td class="">' . ($clases_dia[$dia] ?? '/') . '</td>';
            }
            $contenido .= '</tr>';
        }

        $contenido .= '
            </tbody>
        </table>
        ';

        $response = array('success' => true, 'data' => $contenido);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function obtener_clases_fin_de_semana_actual_por_disciplina_id($disciplina_id = null)
    {
        $clases_semana = $this->calendario_model->obtener_clases_fin_de_semana_actual_por_disciplina_id($disciplina_id);

        $horarios_semana = array();

        foreach ($clases_semana as $clase) {
            $hora_inicio = date('g:i A', strtotime($clase['inicia']));
            $dia_semana = date('D', strtotime($clase['inicia']));
            $horarios_semana[$hora_inicio][$dia_semana] = $clase['instructor_nombre'];
        }

        $contenido = '
        <table class="semana">
            <thead>
                <tr>
                    <th class="">Horario</th>
                    <th class="">Sab</th>
                    <th class="">Dom</th>
                </tr>
            </thead>
            <tbody>
        ';

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            if ($es_tarde && ($ciclo_es_tarde === false)) {
                $contenido .= '<tr>';
                $contenido .= '<td> </td>';
                foreach (['Sat', 'Sun'] as $dia) {
                    $contenido .= '<td> </td>';
                }
                $contenido .= '</tr>';
                $ciclo_es_tarde = true;
            }

            $contenido .= '<tr>';
            $contenido .= '<td class="">' . $hora . '</td>';
            foreach (['Sat', 'Sun'] as $dia) {
                $contenido .= '<td class="">' . ($clases_dia[$dia] ?? '/') . '</td>';
            }
            $contenido .= '</tr>';
        }

        $contenido .= '
            </tbody>
        </table>
        ';

        $response = array('success' => true, 'data' => $contenido);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
