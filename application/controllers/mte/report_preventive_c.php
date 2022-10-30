<?php

class report_preventive_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('mte/preventive_schedule_m');
    }

    function index(){

    }

    public function report_preventive($date = '', $group_line = '') {
        $data['title'] = 'Report Preventive';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(256);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_preventive_v';

        if($date == '' || $date == NULL){
            $date = date('Y') . date('m');
        }
        if($group_line == '' || $group_line == NULL){
            $group_line = 1;
        }
        
        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['group_line'] = $group_line;
        $data['selected_date'] = $date;

        $data['get_data_preventive_mte_report_daily'] = $this->preventive_schedule_m->get_data_preventive_mte_report_daily($date, $group_line);
        
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $this->load->view($this->layout, $data);
    }

    function firstSunday($date)
    {
        for($day = 1; $day <= 7; $day++){
            $dd = strftime("%A",strtotime($date.'-'.$day));
            if($dd == 'Sunday'){
                return strftime("%Y-%m-%d",strtotime($date.'-'.$day));
            }
        }
    }
    
    function firstSaturday($date)
    {
        for($day = 1; $day <= 7; $day++){
            $dd = strftime("%A",strtotime($date.'-'.$day));
            if($dd == 'Saturday'){
                return strftime("%Y-%m-%d",strtotime($date.'-'.$day));
            }
        }
    }

    public function report_preventive_all($msg = NULL, $group_line = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;/button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Your part code is exist </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Preventive telah diupdate !</strong> selesai melakukan preventive </div >";
        } else {
            $msg = "";
        }

        $data['title'] = 'Data Preventive';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(319);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        //$data['content'] = 'mte/report_preventive_all_v';
        $data['content'] = 'mte/report_preventive_all_new_v';

        if($group_line == '' || $group_line == NULL){
            $group_line = 1;
        }
        
        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['group_line'] = $group_line;

        //$data['get_all_data_preventive_mte'] = $this->preventive_schedule_m->get_all_data_preventive_mte($group_line);
        $data['get_all_data_preventive_mte'] = $this->preventive_schedule_m->get_all_data_preventive_mte_new($group_line);

        $this->load->view($this->layout, $data);
    }

    public function report_history_preventive($group_line = '', $month = '') {
        $data['title'] = 'Data Preventive';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(319);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_history_preventive_v';

        if($group_line == '' || $group_line == NULL){
            $group_line = 1;
        }

        if($month == '' || $month == NULL){
            $month = date('Ym');
        }
        
        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['group_line'] = $group_line;
        $data['month'] = $month;

        // $data['get_data_history_preventive'] = $this->preventive_schedule_m->get_data_history_preventive($group_line);
        $data['get_data_history_preventive'] = $this->preventive_schedule_m->get_data_history_preventive_by_month($group_line, $month);

        $this->load->view($this->layout, $data);
    }

    public function report_history_repair($group_line = '', $month = '') {
        $data['title'] = 'Data Repair';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(331);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_history_repair_v';

        if($group_line == '' || $group_line == NULL){
            $group_line = 6;
        }

        if($month == '' || $month == NULL){
            $month = date('Ym');
        }
        
        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['group_line'] = $group_line;
        $data['month'] = $month;

        // $data['get_data_history_repair'] = $this->preventive_schedule_m->get_data_history_repair($group_line);
        $data['get_data_history_repair'] = $this->preventive_schedule_m->get_data_history_repair_by_month($group_line, $month);

        $this->load->view($this->layout, $data);
    }

    function update_history_repair() {
        $session = $this->session->all_userdata();
        $user = $this->session->userdata('NPK');
        
        $id = $this->input->post('id_repair');
        $group_line = $this->input->post('id_group');
        $period = $this->input->post('period');
        $problem = $this->input->post('problem');
        $action = $this->input->post('action');

        $datenow = date('Ymd');
        $timenow = date('His');

        //===== Update into TT_PREVENTIVE_DETAIL
        $this->db->query("UPDATE MTE.TT_REPAIR_PREVENTIVE SET CHR_PROBLEM = '$problem', CHR_ACTION = '$action', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$datenow', CHR_MODIFIED_TIME = '$timenow' WHERE INT_ID = '$id'");

        redirect('mte/report_preventive_c/report_history_repair/' . $group_line . '/' . $period);
    }
}
