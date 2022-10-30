<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class manage_part_wcenter_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/manage_part_wcenter_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/manage_part_wcenter_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('organization/dept_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = null, $part_no = null) {
        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        
        $back_no = '';

        $data['msg'] = $msg;
        $data['title'] = 'Manage Part to Work Center';
        $data['content'] = 'prd/manage_part_wcenter/manage_part_wcenter_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(72);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->manage_part_wcenter_m->get_data_part_no($part_no, $back_no);
        
        $this->load->view($this->layout, $data);
    }

    function search_part_no($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $part_no = $this->input->post('CHR_PART_NO');
        $back_no = $this->input->post('CHR_BACK_NO');
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(72);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Part to Work Center';
        $data['msg'] = $msg;

        $data['data'] = $this->manage_part_wcenter_m->get_data_part_no($part_no, $back_no);

        $data['content'] = 'prd/manage_part_wcenter/manage_part_wcenter_v';
        $this->load->view($this->layout, $data);
    }
    
    function update_part($part_no = null, $wcenter = null, $status = null){
        $user_session = $this->session->all_userdata(); 
        
        $this->manage_part_wcenter_m->update($part_no, $wcenter, $status);

        //redirect($this->back_to_manage . $msg = 2 . '/' . $part_no);
        redirect($this->back_to_manage . $msg = 2);
    }
    
}

?>
