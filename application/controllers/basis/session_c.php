<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class session_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index() {
        $this->check_session();
    }
}
?>
