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

        $fecha_lunes = date('Y-m-d', strtotime($fecha_actual . ' -' . ($numero_dia_actual - 1) . ' days'));
        $fecha_domingo = date('Y-m-d', strtotime($fecha_actual . ' +' . (7 - $numero_dia_actual) . ' days'));
        $fecha_lunes_siguente = date('Y-m-d', strtotime($fecha_actual . ' +' . (8 - $numero_dia_actual) . ' days'));
        $fecha_domingo_siguente = date('Y-m-d', strtotime($fecha_actual . ' +' . (14 - $numero_dia_actual) . ' days'));

        // Imprimir las fechas de lunes a domingo
        // echo "Lunes: " . date('d/m/Y', strtotime($fecha_lunes)) . "\n";
        // echo "Martes: " . date('d/m/Y', strtotime($fecha_lunes . ' +1 days')) . "\n";
        // echo "Miércoles: " . date('d/m/Y', strtotime($fecha_lunes . ' +2 days')) . "\n";
        // echo "Jueves: " . date('d/m/Y', strtotime($fecha_lunes . ' +3 days')) . "\n";
        // echo "Viernes: " . date('d/m/Y', strtotime($fecha_lunes . ' +4 days')) . "\n";
        // echo "Sábado: " . date('d/m/Y', strtotime($fecha_lunes . ' +5 days')) . "\n";
        // echo "Domingo: " . date('d/m/Y', strtotime($fecha_domingo)) . "\n";

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

        // Fecha actual
        $fecha_actual = date('Y-m-d');

        // Obtener el número de día de la semana actual (1 para lunes, 7 para domingo)
        $numero_dia_actual = date('N', strtotime($fecha_actual));

        $fecha_lunes = date('Y-m-d', strtotime($fecha_actual . ' -' . ($numero_dia_actual - 1) . ' days'));

        $contenido = '';

        $contenido .= '
        <table class="semana responsive">
            <thead>
                <tr>
                    <th class="blue lighten-3">Horario</th>
                    <th class=""><a href="">Lun <br>' . date('d M', strtotime($fecha_lunes)) . '</a></th>
                    <th class=""><a href="">Mar <br>' . date('d M', strtotime($fecha_lunes . ' +1 days')) . '</a></th>
                    <th class=""><a href="">Mie <br>' . date('d M', strtotime($fecha_lunes . ' +2 days')) . '</a></th>
                    <th class=""><a href="">Jue <br>' . date('d M', strtotime($fecha_lunes . ' +3 days')) . '</a></th>
                    <th class=""><a href="">Vie <br>' . date('d M', strtotime($fecha_lunes . ' +4 days')) . '</a></th>
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
            $contenido .= '<td class="blue lighten-3"><small>' . $hora . '</small></td>';
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

    public function obtener_clases_semana_actual_por_disciplina_id_para_dia($disciplina_id = null)
    {
        $clases_semana = $this->calendario_model->obtener_clases_semana_actual_por_disciplina_id($disciplina_id);

        $horarios_semana = array();

        foreach ($clases_semana as $clase) {
            $hora_inicio = date('g:i A', strtotime($clase['inicia']));
            $dia_semana = date('D', strtotime($clase['inicia']));
            $horarios_semana[$hora_inicio][$dia_semana] = $clase['instructor_nombre'];
        }

        // Fecha actual
        $fecha_actual = date('Y-m-d');

        // Obtener el número de día de la semana actual (1 para lunes, 7 para domingo)
        $numero_dia_actual = date('N', strtotime($fecha_actual));

        $fecha_lunes = date('Y-m-d', strtotime($fecha_actual . ' -' . ($numero_dia_actual - 1) . ' days'));

        // Dia lunes inicio
        $contenido_lunes = '';

        $contenido_lunes .= '
        <table class="semana responsive">
            <tbody>
        ';

        // $contenido_lunes .= $this->obtener_titulos_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            // if ($es_tarde && ($ciclo_es_tarde === false)) {
            //     $contenido_lunes .= '<tr>';
            //     $contenido_lunes .= '<th><small> </small></th>';
            //     foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
            //         $contenido_lunes .= '<th><small> </small></th>';
            //     }
            //     $contenido_lunes .= '</tr>';
            //     $ciclo_es_tarde = true;
            // }

            $contenido_lunes .= '<tr>';
            $contenido_lunes .= '<th class="blue lighten-3"><small>' . $hora . '</small></th>';
            foreach (['Mon'] as $dia) {
                $contenido_lunes .= '<th class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></th>';
            }
            $contenido_lunes .= '</tr>';
        }

        $contenido_lunes .= '
            </tbody>
        </table>
        ';

        // Dia lunes fin

        // Dia martes inicio
        $contenido_martes = '';

        $contenido_martes .= '
        <table class="semana responsive">
            <tbody>
        ';

        // $contenido_martes .= $this->obtener_titulos_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            // if ($es_tarde && ($ciclo_es_tarde === false)) {
            //     $contenido_martes .= '<tr>';
            //     $contenido_martes .= '<th><small> </small></th>';
            //     foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
            //         $contenido_martes .= '<th><small> </small></th>';
            //     }
            //     $contenido_martes .= '</tr>';
            //     $ciclo_es_tarde = true;
            // }

            $contenido_martes .= '<tr>';
            $contenido_martes .= '<th class="blue lighten-3"><small>' . $hora . '</small></th>';
            foreach (['Tue'] as $dia) {
                $contenido_martes .= '<th class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></th>';
            }
            $contenido_martes .= '</tr>';
        }

        $contenido_martes .= '
            </tbody>
        </table>
        ';
        // Dia martes fin

        // Dia miercoles inicio
        $contenido_miercoles = '';

        $contenido_miercoles .= '
        <table class="semana responsive">
            <tbody>
        ';

        // $contenido_miercoles .= $this->obtener_titulos_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            // if ($es_tarde && ($ciclo_es_tarde === false)) {
            //     $contenido_miercoles .= '<tr>';
            //     $contenido_miercoles .= '<th><small> </small></th>';
            //     foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
            //         $contenido_miercoles .= '<th><small> </small></th>';
            //     }
            //     $contenido_miercoles .= '</tr>';
            //     $ciclo_es_tarde = true;
            // }

            $contenido_miercoles .= '<tr>';
            $contenido_miercoles .= '<th class="blue lighten-3"><small>' . $hora . '</small></th>';
            foreach (['Wed'] as $dia) {
                $contenido_miercoles .= '<th class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></th>';
            }
            $contenido_miercoles .= '</tr>';
        }

        $contenido_miercoles .= '
            </tbody>
        </table>
        ';
        // Dia miercoles fin

        // Dia jueves inicio
        $contenido_jueves = '';

        $contenido_jueves .= '
        <table class="semana responsive">
            <tbody>
        ';

        // $contenido_jueves .= $this->obtener_titulos_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            // if ($es_tarde && ($ciclo_es_tarde === false)) {
            //     $contenido_jueves .= '<tr>';
            //     $contenido_jueves .= '<th><small> </small></th>';
            //     foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
            //         $contenido_jueves .= '<th><small> </small></th>';
            //     }
            //     $contenido_jueves .= '</tr>';
            //     $ciclo_es_tarde = true;
            // }

            $contenido_jueves .= '<tr>';
            $contenido_jueves .= '<th class="blue lighten-3"><small>' . $hora . '</small></th>';
            foreach (['Thu'] as $dia) {
                $contenido_jueves .= '<th class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></th>';
            }
            $contenido_jueves .= '</tr>';
        }

        $contenido_jueves .= '
            </tbody>
        </table>
        ';
        // Dia jueves fin

        // Dia viernes inicio
        $contenido_viernes = '';

        $contenido_viernes .= '
        <table class="semana responsive">
            <tbody>
        ';

        // $contenido_viernes .= $this->obtener_titulos_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            // if ($es_tarde && ($ciclo_es_tarde === false)) {
            //     $contenido_viernes .= '<tr>';
            //     $contenido_viernes .= '<th><small> </small></th>';
            //     foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dia) {
            //         $contenido_viernes .= '<th><small> </small></th>';
            //     }
            //     $contenido_viernes .= '</tr>';
            //     $ciclo_es_tarde = true;
            // }

            $contenido_viernes .= '<tr>';
            $contenido_viernes .= '<th class="blue lighten-3"><small>' . $hora . '</small></th>';
            foreach (['Fri'] as $dia) {
                $contenido_viernes .= '<th class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></th>';
            }
            $contenido_viernes .= '</tr>';
        }

        $contenido_viernes .= '
            </tbody>
        </table>
        ';
        // Dia viernes fin

        $data_dias = array($contenido_lunes, $contenido_martes, $contenido_miercoles, $contenido_jueves, $contenido_viernes);

        $response = array('success' => true, 'data' => $data_dias);

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

        // Fecha actual
        $fecha_actual = date('Y-m-d');

        // Obtener el número de día de la semana actual (1 para lunes, 7 para domingo)
        $numero_dia_actual = date('N', strtotime($fecha_actual));

        $fecha_lunes = date('Y-m-d', strtotime($fecha_actual . ' -' . ($numero_dia_actual - 1) . ' days'));
        $fecha_domingo = date('Y-m-d', strtotime($fecha_actual . ' +' . (7 - $numero_dia_actual) . ' days'));

        $contenido = '';

        $contenido .= '
        <table class="semana">
            <thead>
                <tr>
                    <th class="blue lighten-3">Horario</th>
                    <th class=""><a href="">Sab <br>' . date('d M', strtotime($fecha_lunes . ' +5 days')) . '</a></th>
                    <th class=""><a href="">Dom <br>' . date('d M', strtotime($fecha_domingo)) . '</a></th>
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
            $contenido .= '<td class="blue lighten-3"><small>' . $hora . '</small></td>';
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

    public function obtener_clases_fin_de_semana_actual_por_disciplina_id_para_dia($disciplina_id = null)
    {
        $clases_semana = $this->calendario_model->obtener_clases_fin_de_semana_actual_por_disciplina_id($disciplina_id);

        $horarios_semana = array();

        foreach ($clases_semana as $clase) {
            $hora_inicio = date('g:i A', strtotime($clase['inicia']));
            $dia_semana = date('D', strtotime($clase['inicia']));
            $horarios_semana[$hora_inicio][$dia_semana] = $clase['instructor_nombre'];
        }

        // Fecha actual
        $fecha_actual = date('Y-m-d');

        // Obtener el número de día de la semana actual (1 para lunes, 7 para domingo)
        $numero_dia_actual = date('N', strtotime($fecha_actual));

        $fecha_lunes = date('Y-m-d', strtotime($fecha_actual . ' -' . ($numero_dia_actual - 1) . ' days'));
        $fecha_domingo = date('Y-m-d', strtotime($fecha_actual . ' +' . (7 - $numero_dia_actual) . ' days'));

        // Dia sabado inicio
        $contenido_sabado = '';

        $contenido_sabado .= '
        <table class="semana">
            <tbody>
        ';

        // $contenido_sabado .= $this->obtener_titulos_fin_de_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            // if ($es_tarde && ($ciclo_es_tarde === false)) {
            //     $contenido_sabado .= '<tr>';
            //     $contenido_sabado .= '<td><small> </small></td>';
            //     foreach (['Sat', 'Sun'] as $dia) {
            //         $contenido_sabado .= '<td><small> </small></td>';
            //     }
            //     $contenido_sabado .= '</tr>';
            //     $ciclo_es_tarde = true;
            // }

            $contenido_sabado .= '<tr>';
            $contenido_sabado .= '<th class="blue lighten-3"><small>' . $hora . '</small></th>';
            foreach (['Sat'] as $dia) {
                $contenido_sabado .= '<th class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></th>';
            }
            $contenido_sabado .= '</tr>';
        }

        $contenido_sabado .= '
            </tbody>
        </table>
        ';
        // Dia sabado fin

        // Dia domingo inicio
        $contenido_domingo = '';

        $contenido_domingo .= '
        <table class="semana">
            <tbody>
        ';

        // $contenido_domingo .= $this->obtener_titulos_fin_de_semana($disciplina_id);

        $ciclo_es_tarde = false;

        foreach ($horarios_semana as $hora => $clases_dia) {

            $hora_formato_24 = date('H', strtotime($hora));
            $es_tarde = $hora_formato_24 >= 14;

            // if ($es_tarde && ($ciclo_es_tarde === false)) {
            //     $contenido_domingo .= '<tr>';
            //     $contenido_domingo .= '<td><small> </small></td>';
            //     foreach (['Sat', 'Sun'] as $dia) {
            //         $contenido_domingo .= '<td><small> </small></td>';
            //     }
            //     $contenido_domingo .= '</tr>';
            //     $ciclo_es_tarde = true;
            // }

            $contenido_domingo .= '<tr>';
            $contenido_domingo .= '<th class="blue lighten-3"><small>' . $hora . '</small></th>';
            foreach (['Sun'] as $dia) {
                $contenido_domingo .= '<th class=""><small>' . ($clases_dia[$dia] ?? '/') . '</small></th>';
            }
            $contenido_domingo .= '</tr>';
        }

        $contenido_domingo .= '
            </tbody>
        </table>
        ';
        // Dia domingo fin

        $data_dias = array($contenido_sabado, $contenido_domingo);

        $response = array('success' => true, 'data' => $data_dias);

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

        // Fecha actual
        $fecha_actual = date('Y-m-d');

        // Obtener el número de día de la semana actual (1 para lunes, 7 para domingo)
        $numero_dia_actual = date('N', strtotime($fecha_actual));

        $fecha_lunes = date('Y-m-d', strtotime($fecha_actual . ' -' . ($numero_dia_actual - 1) . ' days'));
        $fecha_domingo = date('Y-m-d', strtotime($fecha_actual . ' +' . (7 - $numero_dia_actual) . ' days'));
        $fecha_lunes_siguente = date('Y-m-d', strtotime($fecha_actual . ' +' . (8 - $numero_dia_actual) . ' days'));
        $fecha_domingo_siguente = date('Y-m-d', strtotime($fecha_actual . ' +' . (14 - $numero_dia_actual) . ' days'));

        $contenido = '
        <table class="semana responsive">
            <thead>
                <tr>
                    <th class="blue lighten-3">Horario</th>
                    <th class="">Lun <br>' . date('d M', strtotime($fecha_lunes_siguente)) . '</th>
                    <th class="">Mar <br>' . date('d M', strtotime($fecha_lunes_siguente . ' +1 days')) . '</th>
                    <th class="">Mie <br>' . date('d M', strtotime($fecha_lunes_siguente . ' +2 days')) . '</th>
                    <th class="">Jue <br>' . date('d M', strtotime($fecha_lunes_siguente . ' +3 days')) . '</th>
                    <th class="">Vie <br>' . date('d M', strtotime($fecha_lunes_siguente . ' +4 days')) . '</th>
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
            $contenido .= '<td class="blue lighten-3"><small>' . $hora . '</small></td>';
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

        // Fecha actual
        $fecha_actual = date('Y-m-d');

        // Obtener el número de día de la semana actual (1 para lunes, 7 para domingo)
        $numero_dia_actual = date('N', strtotime($fecha_actual));

        $fecha_lunes = date('Y-m-d', strtotime($fecha_actual . ' -' . ($numero_dia_actual - 1) . ' days'));
        $fecha_domingo = date('Y-m-d', strtotime($fecha_actual . ' +' . (7 - $numero_dia_actual) . ' days'));
        $fecha_lunes_siguente = date('Y-m-d', strtotime($fecha_actual . ' +' . (8 - $numero_dia_actual) . ' days'));
        $fecha_domingo_siguente = date('Y-m-d', strtotime($fecha_actual . ' +' . (14 - $numero_dia_actual) . ' days'));

        $contenido = '
        <table class="semana">
            <thead>
                <tr>
                    <th class="blue lighten-3">Horario</th>
                    <th class="">Sab <br>' . date('d M', strtotime($fecha_lunes_siguente . ' +5 days')) . '</th>
                    <th class="">Dom <br>' . date('d M', strtotime($fecha_domingo_siguente)) . '</th>
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
            $contenido .= '<td class="blue lighten-3"><small>' . $hora . '</small></td>';
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
                <th class=""><small></small></th>
                <th class=""><small><span class="blue lighten-3">LEGS &<br>BOOTY</span></small></th>
                <th class=""><small><span class="blue lighten-3">PUSH<br>DAY</span></small></th>
                <th class=""><small><span class="blue lighten-3">LEG DAY</span></small></th>
                <th class=""><small><span class="blue lighten-3">PULL<br>DAY</span></small></th>
                <th class=""><small><span class="blue lighten-3">BOOTY</span></small></th>
            </tr>
            ';
        } elseif (in_array($disciplina_id, array(10))) {
            $response = '
            <tr>
                <th class=""><small></small></th>
                <th class=""><small><span class="blue lighten-3">LEGS &<br>BOOTY</span></small></th>
                <th class=""><small><span class="blue lighten-3">UPPER<br>BODY</span></small></th>
                <th class=""><small><span class="blue lighten-3">KILLER<br>ABS</span></small></th>
                <th class=""><small><span class="blue lighten-3">ARMS<br>& BOOTY</span></small></th>
                <th class=""><small><span class="blue lighten-3">FULL<br>BODY &#x1F525;</span></small></th>
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
                    <th class=""><small></small></th>
                    <th class=""><small><span class="blue lighten-3">UPPER<br>BODY</span></small></th>
                    <th class=""><small><span class="blue lighten-3">FULL<br>BODY</span></small></th>
                </tr>
            ';
        } elseif (in_array($disciplina_id, array(10))) {
            $response = '
                <tr>
                    <th class=""><small></small></th>
                    <th class=""><small><span class="blue lighten-3">ABS<br>& BOOTY &#x1F525;</span></small></th>
                    <th class=""><small><span class="blue lighten-3">FULL<br>BODY</span></small></th>
                </tr>
            ';
        }
        return $response;
    }
}
