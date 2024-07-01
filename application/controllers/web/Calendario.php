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
        $data['pagina_titulo'] = 'Calendario';
        $data['pagina_subtitulo'] = '';
        $data['pagina_menu_calendario'] = true;

        $data['controlador'] = 'web/calendario';
        $data['regresar_a'] = 'web/calendario';
        $controlador_js = "web/calendario/index";

        $data['styles'] = array(
            array('es_rel' => true, 'href' => 'web/calendario/index.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );

        // Fecha actual
        $fecha_actual = date('Y-m-d');

        // Obtener el número de día de la semana actual (1 para lunes, 7 para domingo)
        $numero_dia_actual = date('N', strtotime($fecha_actual));

        // Calcular la fecha del lunes de la semana actual
        $fecha_lunes = date('Y-m-d', strtotime($fecha_actual . ' -' . ($numero_dia_actual - 1) . ' days'));

        // Calcular la fecha del domingo de la semana actual
        $fecha_domingo = date('Y-m-d', strtotime($fecha_actual . ' +' . (7 - $numero_dia_actual) . ' days'));
        $fecha_lunes_siguente = date('Y-m-d', strtotime($fecha_actual . ' +' . (8 - $numero_dia_actual) . ' days'));
        $fecha_domingo_siguente = date('Y-m-d', strtotime($fecha_actual . ' +' . (14 - $numero_dia_actual) . ' days'));

        $disciplinas_list = $this->calendario_model->obtener_disciplinas();

        $data['disciplinas_list'] = $disciplinas_list;

        $data['fecha_lunes'] = $fecha_lunes; 
        $data['fecha_domingo'] = $fecha_domingo;
        $data['fecha_lunes_siguente'] = $fecha_lunes_siguente;
        $data['fecha_domingo_siguente'] = $fecha_domingo_siguente;

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

        $contenido = '';

        $contenido .= '
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

        $contenido .= $this->obtener_titulos_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            if ($es_tarde && ($ciclo_es_tarde === false)) {
                $contenido .= '<tr>';
                $contenido .= '<td><small> </small></td>';
                foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
                    $contenido .= '<td><small> </small></td>';
                }
                $contenido .= '</tr>';
                $ciclo_es_tarde = true;
            }

            $contenido .= '<tr>';
            $contenido .= '<td class=""><small>' . $hora . '</small></td>';
            foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
                $contenido .= '<td class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></td>';
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

        $contenido = '';

        $contenido .= '
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

        $contenido .= $this->obtener_titulos_fin_de_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            if ($es_tarde && ($ciclo_es_tarde === false)) {
                $contenido .= '<tr>';
                $contenido .= '<td><small> </small></td>';
                foreach (['Sat', 'Sun'] as $dia) {
                    $contenido .= '<td><small> </small></td>';
                }
                $contenido .= '</tr>';
                $ciclo_es_tarde = true;
            }

            $contenido .= '<tr>';
            $contenido .= '<td class=""><small>' . $hora . '</small></td>';
            foreach (['Sat', 'Sun'] as $dia) {
                $contenido .= '<td class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></td>';
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

    public function obtener_clases_semana_siguiente_por_disciplina_id($disciplina_id = null)
    {
        $clases_semana = $this->calendario_model->obtener_clases_semana_siguiente_por_disciplina_id($disciplina_id);

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

        $contenido .= $this->obtener_titulos_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            if ($es_tarde && ($ciclo_es_tarde === false)) {
                $contenido .= '<tr>';
                $contenido .= '<td><small> </small></td>';
                foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
                    $contenido .= '<td><small> </small></td>';
                }
                $contenido .= '</tr>';
                $ciclo_es_tarde = true;
            }

            $contenido .= '<tr>';
            $contenido .= '<td class=""><small>' . $hora . '</small></td>';
            foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
                $contenido .= '<td class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></td>';
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

    public function obtener_clases_fin_de_semana_siguiente_por_disciplina_id($disciplina_id = null)
    {
        $clases_semana = $this->calendario_model->obtener_clases_fin_de_semana_siguiente_por_disciplina_id($disciplina_id);

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

        $contenido .= $this->obtener_titulos_fin_de_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            if ($es_tarde && ($ciclo_es_tarde === false)) {
                $contenido .= '<tr>';
                $contenido .= '<td><small> </small></td>';
                foreach (['Sat', 'Sun'] as $dia) {
                    $contenido .= '<td><small> </small></td>';
                }
                $contenido .= '</tr>';
                $ciclo_es_tarde = true;
            }

            $contenido .= '<tr>';
            $contenido .= '<td class=""><small>' . $hora . '</small></td>';
            foreach (['Sat', 'Sun'] as $dia) {
                $contenido .= '<td class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></td>';
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

    public function obtener_titulos_semana($disciplina_id)
    {
        if (in_array($disciplina_id, array(3))) {
            $response = '
            <tr>
                <td class=""><small></small></td>
                <td class=""><small><span class="blue lighten-3">LEGS &<br>BOOTY</span></small></td>
                <td class=""><small><span class="blue lighten-3">PUSH<br>DAY</span></small></td>
                <td class=""><small><span class="blue lighten-3">LEG DAY</span></small></td>
                <td class=""><small><span class="blue lighten-3">PULL<br>DAY</span></small></td>
                <td class=""><small><span class="blue lighten-3">BOOTY</span></small></td>
            </tr>
            ';
        } elseif (in_array($disciplina_id, array(10))) {
            $response = '
            <tr>
                <td class=""><small></small></td>
                <td class=""><small><span class="blue lighten-3">LEGS &<br>BOOTY</span></small></td>
                <td class=""><small><span class="blue lighten-3">UPPER<br>BODY</span></small></td>
                <td class=""><small><span class="blue lighten-3">KILLER<br>ABS</span></small></td>
                <td class=""><small><span class="blue lighten-3">ARMS<br>& BOOTY</span></small></td>
                <td class=""><small><span class="blue lighten-3">FULL<br>BODY &#x1F525;</span></small></td>
            </tr>
            ';
        }
        return $response;
    }

    public function obtener_titulos_fin_de_semana($disciplina_id)
    {
        if (in_array($disciplina_id, array(3))) {
            $response = '
                <tr>
                    <td class=""><small></small></td>
                    <td class=""><small><span class="blue lighten-3">UPPER<br>BODY</span></small></td>
                    <td class=""><small><span class="blue lighten-3">FULL<br>BODY</span></small></td>
                </tr>
            ';
        } elseif (in_array($disciplina_id, array(10))) {
            $response = '
                <tr>
                    <td class=""><small></small></td>
                    <td class=""><small><span class="blue lighten-3">ABS<br>& BOOTY &#x1F525;</span></small></td>
                    <td class=""><small><span class="blue lighten-3">FULL<br>BODY</span></small></td>
                </tr>
            ';
        }
        return $response;
    }
}
