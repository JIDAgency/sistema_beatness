<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkin_model');
        $this->load->model('clases_model');
        $this->load->model('reservaciones_model');
    }

    public function index()
    {
        $data['pagina_titulo'] = 'Checkin';
        $data['pagina_subtitulo'] = 'Registro de checkin';
        $data['menu_checkins_activo'] = true;

        $data['controlador'] = 'checkin';
        $data['ir_a'] = 'checkin/crear';
        $data['regresar_a'] = 'inicio';
        $controlador_js = 'checkin/index';

        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/forms/selects/select2.min.css'),
        );
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/extensions/moment.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/forms/select/select2.full.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/js/scripts/forms/select/form-select2.js'),
            array('es_rel' => true, 'src' => '' . $controlador_js . '.js'),
        );


        $this->construir_private_site_ui('checkin/index', $data);
    }

    public function obtener_tabla_index()
    {
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));

        $checkin_list = $this->checkin_model->obtener_todos_checkins();

        $data = [];



        foreach ($checkin_list->result() as $checkin) {

            $opciones = '';

            $opciones = '<a href="javascript:modal_registrar_checkin(' . $checkin->wellhub_product_id . ', ' . htmlspecialchars(json_encode(array(
                'usuario' => $checkin->usuario_id,
                'venta' => $checkin->venta_id,
                'asignacion' => $checkin->asignacion_id,
                'id' => $checkin->id,
            )), ENT_QUOTES, 'UTF-8') . ');">Checkin</a>';

            $data[] = array(
                'opciones' => $opciones,
                'id' => $checkin->id,
                'disciplina_wellhub' => $checkin->wellhub_product_id,
                'usuario_id' => !empty($checkin->nombre_usuario) ? $checkin->nombre_usuario . '|' . $checkin->correo . '| #' . $checkin->usuario_id : '',
                'venta_id' => !empty($checkin->venta_id) ? $checkin->venta_id : '',
                'asignacion_id' => !empty($checkin->asignacion_id) ? $checkin->asignacion_id : '',
                'reservacion_id' => !empty($checkin->reservacion_id) ? '<span class="text-success">Reservado</span>' : '<span class="text-danger">Sin reservar</span>',
                'descripcion' => !empty($checkin->descripcion) ? $checkin->descripcion : '',
                'timestamp' => !empty($checkin->timestamp) ? $checkin->timestamp : '',
                'estatus' => !empty($checkin->estatus) ? $checkin->estatus : '',
                'fecha_registro' => (!empty($checkin->fecha_registro) ? date('h:i A', strtotime($checkin->fecha_registro)) : ''),
            );
        }

        $result = array(
            'draw' => $draw,
            'recordsTotal' => $checkin_list->num_rows(),
            'recordsFiltered' => $checkin_list->num_rows(),
            'data' => $data
        );

        echo json_encode($result);
        exit();
    }

    public function clases_por_semana($disciplina)
    {
        $clases = $this->clases_model->clases_por_semana($disciplina)->result();

        echo json_encode(array_values($clases));
    }

    public function registrar_checkin_en_reservacion_y_clase()
    {
        $disciplina = $this->input->post('disciplina');
        $id = $this->input->post('id');
        $usuario = $this->input->post('usuario');
        $venta = $this->input->post('venta');
        $asignacion = $this->input->post('asignacion');
        $clase_id = $this->input->post('clase_id');
        $instructor_nombre = $this->input->post('instructor_nombre');
        $fecha_hora = $this->input->post('fecha_hora');
        $cupos = $this->input->post('cupos');

        $cupo_lugares = json_decode($cupos);
        usort($cupo_lugares, function ($a, $b) {
            return $b->no_lugar - $a->no_lugar;
        });

        $lugar_reservado = false;
        $no_lugar_reservado = 0;

        foreach ($cupo_lugares as &$lugar) {
            if (!$lugar->esta_reservado) {
                $lugar->esta_reservado = true;
                $lugar->nombre_usuario = $usuario;
                $no_lugar_reservado = $lugar->no_lugar;
                $lugar_reservado = true;
                break;
            }
        }

        if (!$lugar_reservado) {
            throw new Exception('No hay lugares disponibles para esta clase. Por favor, seleccione otra clase.', 1001);
        }

        $clase_a_reservar = $this->clases_model->obtener_todas_con_detalle_por_id($clase_id)->row();

        usort($cupo_lugares, function ($a, $b) {
            return $a->no_lugar - $b->no_lugar;
        });

        $cupos = json_encode($cupo_lugares);
        $reservado = $clase_a_reservar->reservado + 1;

        $clase = $this->clases_model->editar(
            $clase_id,
            array(
                'reservado' => $reservado,
                'cupo_lugares' => $cupos
            )
        );

        if (!$clase) {
            echo json_encode(['success' => false, 'message' => 'Error al guardar en la base de datos']);
        }

        $reservacion = $this->reservaciones_model->crear(
            array(
                'usuario_id' => $usuario,
                'clase_id' => $clase_id,
                'asignaciones_id' => $asignacion,
                'no_lugar' => $no_lugar_reservado,
            )
        );

        // Responder en JSON según el resultado
        if (!$reservacion) {
            echo json_encode(['success' => false, 'message' => 'Error al guardar en la base de datos']);
        }

        $reservacion_id = $this->reservaciones_model->obetener_id_para_checkin($usuario, $clase_id, $asignacion, $no_lugar_reservado)->row();

        $reservacion_checkin = $this->checkin_model->actualizar(
            $id,
            array(
                'reservacion_id' => $reservacion_id->id,
            )
        );

        // Responder en JSON según el resultado
        if (!$reservacion_checkin) {
            echo json_encode(['success' => false, 'message' => 'Error al guardar en la base de datos']);
        }

        echo json_encode(['success' => true]);
    }
}
