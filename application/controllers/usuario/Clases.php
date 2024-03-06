<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clases extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->load->model('asignaciones_model');
        $this->load->model('clases_en_linea_model');
        $this->load->model('disciplinas_model');
		$this->load->model('planes_model');
		$this->load->model('rel_corporativo_usuarios_model');
        
	}

    public function index()
	{
        $data['menu_usuario_clases_activo'] = true;
        $data['pagina_titulo'] = 'Disciplinas Online';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "usuario/clases/index";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/clases/index';
        $data['regresar_a'] = 'usuario/inicio';
        
        $disciplinas_online_list = $this->disciplinas_model->get_lista_de_disciplinas_online()->result();

        $data['disciplinas_online_list'] = $disciplinas_online_list;

        $this->construir_private_usuario_ui('usuario/clases/index', $data);
    }

	public function online($id = null)
	{
        $data['menu_usuario_clases_activo'] = true;
        $data['pagina_titulo'] = 'Clases Online';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "usuario/clases/online";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
        );

        $data['scripts'] = array(
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/clases/online';
        $data['regresar_a'] = 'usuario/clases';

        if ($this->input->post()) {
            $id = $this->input->post('id');
        }
        $disciplinas_online_list = $this->disciplinas_model->get_lista_de_disciplinas_online()->result();
        
        $disciplina_seleccionada = "";

        foreach ($disciplinas_online_list as $disciplina_row) {
            
            if ($disciplina_row->id == $id) {
                $disciplina_seleccionada = $disciplina_row->nombre;
            }
        }

        $clases_por_streaming_list = $this->clases_en_linea_model->get_clases_online_por_sucursal_id($id)->result();
		$planes_para_clases_online = $this->planes_model->get_planes_online_disponibles_para_venta()->result();

        $data['parametro_de_la_vista_anterior'] = $id;
        $data['disciplina_seleccionada'] = $disciplina_seleccionada;
        $data['clases_por_streaming_list'] = $clases_por_streaming_list;
        $data['planes_para_clases_online'] = $planes_para_clases_online;

        $this->construir_private_usuario_ui('usuario/clases/online', $data);
    }

    public function ver($id = null, $vista_anterior = null)
    {
        $data['menu_usuario_clases_activo'] = true;
        $data['pagina_titulo'] = 'Streaming de clase';

        $data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
        $data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');

        /** JS propio del controlador */
        $controlador_js = "usuario/clases/ver";

        /** Carga todas los estilos y librerias */
        $data['styles'] = array(
            array('es_rel' => false, 'href' => base_url() . 'app-assets/vendors/css/tables/datatable/datatables.min.css'),
        );

        $data['scripts'] = array(
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/tables/datatable/datatables.min.js'),
            array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
        );

        /** Configuracion del formulario */
        $data['controlador'] = 'usuario/clases/ver';
        $data['regresar_a'] = 'usuario/clases/online/'.$vista_anterior;

        if ($this->input->post()) {
            $id = $this->input->post('id');
            $vista_anterior = $this->input->post('vista_anterior');
        }

        $usuario_id = $this->session->userdata('id');
        
        $check_si_es_corporativo = $this->rel_corporativo_usuarios_model->get_rel_corporativo_usuario_por_usuario_id($this->session->userdata('id'))->row();

        if (isset($check_si_es_corporativo) AND !empty($check_si_es_corporativo)){
            $usuario_id = $check_si_es_corporativo->corporativo_id;
        }

        //Antes que nada, revisar que tenga un plan adecuado para consultar las clases online...
        $asignacion_requerida = $this->asignaciones_model->get_asignaciones_para_clases_online_activas_por_usuario_id($usuario_id)->row();

        if (!$asignacion_requerida) {
                    
            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer no cuenta con una suscripción, por favor haga clic en <a class="text-uppercase text-white" href="'.site_url('usuario/comprar_planes').'"><u>Tienda.</u></a>');
            redirect($data['regresar_a']);
        }

        if ($asignacion_requerida->suscripcion_estatus_del_pago == 'rechazado') {
                    
            $this->session->set_flashdata('MENSAJE_INFO', '¡Oh no! Parece que necesitas actualizar el método de pago de tu suscripción, por favor haga clic en <a class="text-uppercase text-white" href="'.site_url('usuario/perfil/planes').'"><u>Planes y suscripciones.</u></a>');
            redirect($data['regresar_a']);
        }

        $clase_por_streaming_row = $this->clases_en_linea_model->get_clase_streaming_por_id($id)->row();

        if(!$clase_por_streaming_row){

            $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
            redirect($data['regresar_a']);
        }

        $cupos_lugares_list = json_decode($clase_por_streaming_row->cupo_lugares);

        $comparacion_cupo = array();

        foreach ($cupos_lugares_list as $cupo_lugar_row) {
           array_push($comparacion_cupo, $cupo_lugar_row->id_usuario);
        }

        if (!in_array($this->session->userdata('id'), $comparacion_cupo)) {

            $lugar = array(
                'no_lugar' => max($comparacion_cupo)+1,
                'esta_reservado' => true,
                'id_usuario' => $this->session->userdata('id'),
                'nombre_usuario' => $this->session->userdata('nombre_completo'),
            );

            array_push($cupos_lugares_list, $lugar);

            $cupo_lugares_json = json_encode($cupos_lugares_list);
            
            $data_clase = array(
                'reservados' => $clase_por_streaming_row->reservados+1,
                'cupo_lugares' => $cupo_lugares_json,
                
            );

            $data_asingacion = array(
                'clases_usadas' => $asignacion_requerida->clases_usadas + 1,
            );
            
            if (!$this->asignaciones_model->editar($asignacion_requerida->id, $data_asingacion)) {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                redirect($data['regresar_a']);
            }

            if (!$this->clases_en_linea_model->update_clase_streaming($id, $data_clase)) {

                $this->session->set_flashdata('MENSAJE_ERROR', 'Al parecer hubo un error, por favor intentelo mas tarde.');
                redirect($data['regresar_a']);
            }
        }

        $data['clase_por_streaming_row'] = $clase_por_streaming_row;

        $this->construir_private_usuario_ui('usuario/clases/ver', $data);
    }
}