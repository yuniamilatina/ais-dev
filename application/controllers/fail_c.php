<?php

class fail_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/log_m');
    }

    function index() {
//        $this->log_m->add_log('404', NULL);
        $this->load->view('fail/404_v');
    }

    function auth() {
//        $this->log_m->add_log('404', NULL);
        $this->load->view('fail/auth_v');
    }

    function recontruction() {
        $this->load->view('fail/recontruction_v');
    }

}

?>
