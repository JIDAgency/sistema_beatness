<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Descarga extends MY_Controller {

	public function __construct()
	{
        parent::__construct();

		$this->load->library('user_agent');
    }
    
    public function index() {
		if ($this->agent->is_mobile('iphone') OR $this->agent->is_mobile('ipad')) {
			header('Location: https://apps.apple.com/mx/app/pentha/id1659682019');
		} elseif ($this->agent->is_mobile()) {
			header('Location: https://play.google.com/store/apps/details?id=mx.pentha');
		}

		$data['pagina_titulo'] = 'Descarga';

		$this->construir_public_ui('descarga/index', $data);
	}
	
}
