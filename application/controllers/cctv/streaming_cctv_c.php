<?php

class streaming_cctv_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(150);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Celine';

        $data['content'] = 'cctv/streaming_cctv_v';
        $this->load->view($this->layout, $data);
    }
   
}
