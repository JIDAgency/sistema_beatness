<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_config extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
		
		$this->load->model("app_secciones_model");

    }
    
    public function index()
    {
        $this->publicidad();
    }

    public function publicidad()
	{
		$data['menu_app_activo'] = true;
        $data['pagina_titulo'] = 'Sección de publicidad para la aplicación';

		//revisar
		$data['controlador'] = 'app/publicidad';
		$data['regresar_a'] = 'inicio';
		$controlador_js = "app/publi";

		$data['mensaje_exito'] = $this->session->flashdata('MENSAJE_EXITO');
        $data['mensaje_info'] = $this->session->flashdata('MENSAJE_INFO');
		$data['mensaje_error'] = $this->session->flashdata('MENSAJE_ERROR');
		
		$data['styles'] = array(
		);
		$data['scripts'] = array(
			array('es_rel' => true, 'src' => ''.$controlador_js.'.js'),
		);

		$this->form_validation->set_rules('url_imagen_boton', 'Imagen botón home (App)', 'trim');
		$this->form_validation->set_rules('url_boton', 'URL botón home (App)', 'trim');
		$this->form_validation->set_rules('url_imagen_page', 'Imagen sección descubre (App)', 'trim');
		$this->form_validation->set_rules('url_page', 'URL sección descubre (App)', 'trim');
		$this->form_validation->set_rules('url_imagen_vista', 'Imagen vista (Web)', 'trim');
		$this->form_validation->set_rules('url_vista', 'URL vista (Web)', 'trim');

		$publicidad_row = $this->app_secciones_model->get_app_seccion_por_seccion("publicidad")->row();

		$data["publicidad_row"] = $publicidad_row;

		if ($this->form_validation->run() == false) {

			$this->construir_private_site_ui('app/publicidad' ,$data);

        } else {

            if (isset($_FILES) && $_FILES['url_imagen_boton']['error'] == '0') {

				$config['upload_path']   = './almacenamiento/img_app/acerca/';
				$config['allowed_types'] = 'jpg';
                //$config['max_width'] = 810;
                //$config['max_height'] = 810;
				//$config['max_size'] = '600';
				$config['overwrite']     = true;
				$config['encrypt_name']  = true;
				$config['remove_spaces'] = true;

				if (!is_dir($config['upload_path'])) {
					$this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['controlador']));
				}

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('url_imagen_boton')) {

					$this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors()." Imagen botón home (App)", site_url($data['controlador']));

				} else {

					if ($publicidad_row->url_imagen_boton AND $publicidad_row->url_imagen_boton != "boton.jpg") {
						$url_imagen_a_borrar = "almacenamiento/img_app/acerca/".$publicidad_row->url_imagen_boton;
						$imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
						unlink($imagen_a_borrar);
						/*if(!unlink($imagen_a_borrar)){
							$this->mensaje_del_sistema("MENSAJE_ERROR", No fue posible eliminar la imagen anterior, site_url($data['controlador']));
						}*/
					}

					$data_imagen = $this->upload->data();
					$url_imagen_boton = $data_imagen['file_name'];

				}

			} else {

				$url_imagen_boton = $publicidad_row->url_imagen_boton;

			}

			if (isset($_FILES) && $_FILES['url_imagen_page']['error'] == '0') {

				$config['upload_path']   = './almacenamiento/img_app/acerca/';
				$config['allowed_types'] = 'jpg';
                //$config['max_width'] = 810;
                //$config['max_height'] = 810;
				//$config['max_size'] = '600';
				$config['overwrite']     = true;
				$config['encrypt_name']  = true;
				$config['remove_spaces'] = true;

				if (!is_dir($config['upload_path'])) {
					$this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['controlador']));
				}

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('url_imagen_page')) {

					$this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors()." Imagen sección descubre (App)", site_url($data['controlador']));

				} else {

					if ($publicidad_row->url_imagen_page AND $publicidad_row->url_imagen_page != "page.jpg") {
						$url_imagen_a_borrar = "almacenamiento/img_app/acerca/".$publicidad_row->url_imagen_page;
						$imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
						unlink($imagen_a_borrar);
						/*if(!unlink($imagen_a_borrar)){
							$this->mensaje_del_sistema("MENSAJE_ERROR", No fue posible eliminar la imagen anterior, site_url($data['controlador']));
						}*/
					}

					$data_imagen = $this->upload->data();
					$url_imagen_page = $data_imagen['file_name'];

				}

			} else {

				$url_imagen_page = $publicidad_row->url_imagen_page;

			}

			if (isset($_FILES) && $_FILES['url_imagen_vista']['error'] == '0') {

				$config['upload_path']   = './almacenamiento/img_app/acerca/';
				$config['allowed_types'] = 'jpg';
                //$config['max_width'] = 810;
                //$config['max_height'] = 810;
				//$config['max_size'] = '600';
				$config['overwrite']     = true;
				$config['encrypt_name']  = true;
				$config['remove_spaces'] = true;

				if (!is_dir($config['upload_path'])) {
					$this->mensaje_del_sistema("MENSAJE_ERROR", "La carpeta de carga no existe", site_url($data['controlador']));
				}

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('url_imagen_vista')) {

					$this->mensaje_del_sistema("MENSAJE_ERROR", $this->upload->display_errors()." Imagen vista (Web)", site_url($data['controlador']));

				} else {

					if ($publicidad_row->url_imagen_vista AND $publicidad_row->url_imagen_vista != "vista.jpg") {
						$url_imagen_a_borrar = "almacenamiento/img_app/acerca/".$publicidad_row->url_imagen_vista;
						$imagen_a_borrar = str_replace(base_url(), '', $url_imagen_a_borrar);
						unlink($imagen_a_borrar);
						/*if(!unlink($imagen_a_borrar)){
							$this->mensaje_del_sistema("MENSAJE_ERROR", No fue posible eliminar la imagen anterior, site_url($data['controlador']));
						}*/
					}

					$data_imagen = $this->upload->data();
					$url_imagen_vista = $data_imagen['file_name'];

				}

			} else {

				$url_imagen_vista = $publicidad_row->url_imagen_vista;

			}

			if (!$this->input->post("url_boton")) {
				$url_boton = null;
			} else {
				$url_boton = $this->input->post("url_boton");
			}
			if (!$this->input->post("url_page")) {
				$url_page = null;
			} else {
				$url_page = $this->input->post("url_page");
			}
			if (!$this->input->post("url_vista")) {
				$url_vista = null;
			} else {
				$url_vista = $this->input->post("url_vista");
			}

            $data = array(
                'url_imagen_boton' => $url_imagen_boton,
                'url_boton' => $url_boton,
                'url_imagen_page' => $url_imagen_page,
                'url_page' => $url_page,
                'url_imagen_vista' => $url_imagen_vista,
                'url_vista' => $url_vista,
                'estatus' => $this->input->post("estatus"),
            );

            if ($this->app_secciones_model->update_app_seccion($publicidad_row->id, $data)) {
				
                $this->session->set_flashdata('MENSAJE_EXITO', 'La sección de descubre (App y Web) ha sido modificada correctamente.');
                redirect('app/publicidad');
				
			}

			$this->construir_private_site_ui('app/publicidad' ,$data);

        }
	}
	
}
