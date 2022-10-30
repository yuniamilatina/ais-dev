<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class logs_in_line_scan_c extends CI_Controller
{

    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/logs_in_line_scan_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    public function check_session()
    {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    public function index($work_center = null, $msg = null)
    {
        $this->check_session();

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Manage Log In Line Scan';
        $data['content'] = 'prd/logs_in_line_scan_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(321);
        $data['news'] = $this->news_m->get_news();

        if($work_center == null){
            $work_center = $this->direct_backflush_general_m->get_top_work_center_using_samalona();
        }
        
        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_using_samalona();
        $data['work_center'] = $work_center;

        $data['data'] = $this->logs_in_line_scan_m->get_data_log_ines_by_work_center($work_center, date('Ymd'));
        $this->load->view($this->layout, $data);
    }

}
