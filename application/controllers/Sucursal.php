<?php
/**
 * Created by PhpStorm.
 * User: Cody
 * Date: 29/08/2018
 * Time: 10:39 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursal extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();

		//error_log(print_r($this->session->userdata, TRUE));

		if (!$this->session->userdata['en_sesion'] == TRUE) {
			redirect('cuenta/iniciar_sesion');
		}

	}

	public function index()
	{
		$view_data['sucursales'] = $this->db->query("SELECT t1.*, 
															CONCAT(COALESCE(t2.nombre_completo, 'N/D'), ' ', COALESCE(t2.apellido_paterno, 'N/D')) AS gerente
													 FROM sucursales AS t1
													 JOIN usuarios AS t2 ON t1.usuario_id = t2.id");


		$this->load->view('sucursal/index', $view_data);
	}

	public function crear()
	{

		// Validar primero que haya usuarios en el rol de administrador dado
		// que es requerido que cada sucursal a crear tenga asignado un gerente
		$administradores = $this->db->get_where('usuarios', array('rol_id' => 2));

		if ($administradores->num_rows() == 0) {
			redirect('sucursal/index');
		}

		// Establecer validaciones
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('usuario_id', 'Gerente', 'required');

		// Pasar catálogo de administradores a la vista
		$view_data['administradores'] = $administradores;

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('sucursal/crear', $view_data);

		} else {

			// Preparar el array con los datos a insertar
			$data = array(
				'nombre' => $this->input->post('nombre'),
				'usuario_id' => $this->input->post('usuario_id'),
				'telefono' => $this->input->post('telefono'),
				'calle' => $this->input->post('calle'),
				'numero' => $this->input->post('numero'),
				'ciudad' => $this->input->post('ciudad'),
				'colonia' => $this->input->post('colonia'),
				'estado' => $this->input->post('estado'),
				'pais' => $this->input->post('pais')
			);

			if ($this->db->insert('sucursales', $data)) {
				redirect('sucursal/index');
			}

			$this->load->view('sucursal/crear', $view_data);
		}


	}


	public function editar($id = null)
	{
		// Establecer validaciones
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('usuario_id', 'Gerente', 'required');

		// Pasar catálogo de administradores a la vista
		$view_data['administradores'] =  $this->db->get_where('usuarios', array('rol_id' => 2));

		if ($this->input->post()) {
			$id = $this->input->post('id');
		}


		if ($this->form_validation->run() == FALSE) {

			// Verificar que la sucursal a editar existe, obtener sus datos y pasar dichos
			// datos a la vista
			$sucursal_a_editar = $this->db->get_where('sucursales', array('id' => intval($id)));

			error_log($this->db->last_query());

			if (!$sucursal_a_editar) {
				redirect('sucursal/index');
			}

			$view_data['sucursal_a_editar'] = $sucursal_a_editar->row();

			$this->load->view('sucursal/editar', $view_data);

		} else {

			$data = array(
				'nombre' => $this->input->post('nombre'),
				'usuario_id' => $this->input->post('usuario_id'),
				'telefono' => $this->input->post('telefono'),
				'calle' => $this->input->post('calle'),
				'numero' => $this->input->post('numero'),
				'ciudad' => $this->input->post('ciudad'),
				'colonia' => $this->input->post('colonia'),
				'estado' => $this->input->post('estado'),
				'pais' => $this->input->post('pais')
			);

			if ($this->db->update('sucursales', $data, 'id = ' . $id)) {
				redirect('sucursal/index');
			}

			$this->load->view('sucursal/editar', $view_data);
		}
	}
}
