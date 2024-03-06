<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Politica_de_privacidad extends MY_Controller {

	public function __construct() {
        parent::__construct();
	}

    public function index() {
        $this->load->view('politica_de_privacidad/index');
    }
}
