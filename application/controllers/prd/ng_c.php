<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ng_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/ng_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/ng_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index() {
        $this->check_session();

        $data['title'] = 'NG Notes';
        $data['content'] = 'prd/ng/report_ng_v';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(330);
        $data['news'] = $this->news_m->get_news();

        $date = $this->input->post('CHR_DATE');
        $period = substr($this->input->post('CHR_DATE'),0,6);
        $work_center = $this->input->post('CHR_WORK_CENTER');

        if($date == null || $date == ''){
            $date = date('Ymd');
        }

        if($period == null || $period == ''){
            $period = date('Ym');
        }

        if($work_center == null || $work_center ==  ''){
            $work_center = 'ALL';
        }

        $data_work_center = $this->direct_backflush_general_m->get_all_work_center_ines();

        $data['data_work_center'] = $data_work_center;
        $data['date'] = $date;
        $data['period'] = $period;
        $data['work_center'] = $work_center;
        $data['data'] = $this->ng_m->get_data_ng_by_date_and_workcenter($date, $work_center);
        $data['data_monthly'] = $this->ng_m->get_data_ng_by_period_and_workcenter($period, $work_center);
        $this->load->view($this->layout, $data);
    }
}
