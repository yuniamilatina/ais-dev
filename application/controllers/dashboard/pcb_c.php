<?php

class Pcb_c extends CI_Controller {

    private $layout_blank = '/template/head_blank';

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $data['title'] = 'Production Activity';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(83);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'PCB';
        $data['content'] = 'dashboard/pcb_v';
    
        $this->load->view($this->layout_blank, $data);
    }

}

