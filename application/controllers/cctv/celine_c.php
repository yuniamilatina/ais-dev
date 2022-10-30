<?php

class celine_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($group_line = null) {
        $this->check_session();
        $content = 'cctv/'.$group_line.'_v';
        $data['title'] = "Celine $group_line";

        $this->load->view($content, $data);
    }

    // function newCeline()
    // {
    	
    //     $data['title'] = 'Celine - CCTV in Line';
    // 	$content = 'cctv/celine_new_v';
    // 	$this->load->view($content, $data);
    // }
   
}
