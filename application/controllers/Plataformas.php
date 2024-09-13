<?php defined('BASEPATH') or exit('No direct script access allowed');

class Plataformas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Cargar estilos y scripts
        $data['styles'] = array();
        $data['scripts'] = array(
            array('es_rel' => false, 'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/charts/echarts/echarts.js'),
            array('es_rel' => false, 'src' => base_url() . 'app-assets/vendors/js/charts/chart.min.js'),
            array('es_rel' => true, 'src' => 'plataformas/index.js'),
        );

        $this->construir_public_ui('plataformas/index', $data);
    }
}
