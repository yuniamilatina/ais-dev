<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_m');
        $this->load->model('log_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] != '') {
            redirect(base_url('index.php/home_c'));
        } elseif (!$user_session['NPK']) {
            redirect(base_url('index.php/login_c'));
        }
    }
    
    function index($msg = null) {
        $data['msg'] = $msg;
        $data['title'] = 'Budget Login';
        $data['content'] = 'login/login_v';
        $this->load->view('/template/login_template', $data);
    }


}

?>
