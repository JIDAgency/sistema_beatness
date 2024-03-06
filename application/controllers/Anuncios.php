<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncios extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model("anuncios_model");
    }
    
    public function index()
    {
        $anuncio = $this->anuncios_model->get_anuncio_por_tipo("aviso_clases")->row();

        $data["anuncio"] = $anuncio;
        $this->construir_private_site_ui('anuncios/index', $data);
    }
}
