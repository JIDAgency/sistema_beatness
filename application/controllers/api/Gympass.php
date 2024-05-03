<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Gympass extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function index_post()
    {
        $this->response(REST_Controller::HTTP_OK);
    }
}
