<?php

class feedback_recovery_prod_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'display_prod/feedback_recovery_prod_c/index/';
    private $home = '/basis/home_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('display_prod/feedback_recovery_prod_m');
        $this->load->model('pes/production_activity_m');
    }

    function index($date = NULL, $msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating Failed</strong> Line yang dipilih belum produksi, pastikan Line yang pilih sudah produksi</div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating Failed</strong> Data waktu kurang tepat, mohon diperiksa kembali </div >";
        } 

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(157);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Problem & Corrective Act.';
        $data['msg'] = $msg;
        
        if($date == '' || $date == null){
            $date = date('Ym');
        }

        $data['date'] = $date;
        $data['data'] = $this->feedback_recovery_prod_m->get_data_problem_and_recovery($date);
        $data['content'] = 'display_prod/feedback/manage_feedback_recovery_v';
        $this->load->view($this->layout, $data);
    }

    function create_feedback($work_center = NULL) {
        $this->role_module_m->authorization('14');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(157);
        $data['title'] = 'Create Problem & Corrective Action';
        $session = $this->session->all_userdata();

        $data['last_all_wo_number'] = $this->production_activity_m->get_last_ines_activity();
        $data['wo_number'] = $this->production_activity_m->get_last_ines_activity_by_work_center($work_center);
        $data['npk'] = $session['NPK'];
        $data['username'] = $session['USERNAME'];

        $data['content'] = 'display_prod/feedback/create_feedback_recovery_v';
        $this->load->view($this->layout, $data);
    }

    function save_feedback() {
        $wo_number = $this->input->post('CHR_WO_NUMBER');
        $problem = $this->input->post('CHR_PROBLEM');
        $username = $this->input->post('CHR_USERNAME');
        $npk = $this->input->post('CHR_NPK');
        $corrective_action = $this->input->post('CHR_CORRECTIVE_ACTION');
        $starthour = $this->input->post('START_HOUR');
        $startminute = $this->input->post('START_MINUTE');
        $endhour = $this->input->post('END_HOUR');
        $endminute = $this->input->post('END_MINUTE');

        if(strlen($starthour) == 1){
            $starthour = '0'.$starthour;
        }else{
            $starthour = $starthour;
        }

        if(strlen($startminute) == 1){
            $startminute = '0'.$startminute;
        }else{
            $startminute = $startminute;
        }

        if(strlen($endhour) == 1){
            $endhour = '0'.$endhour;
        }else{
            $endhour = $endhour;
        }

        if(strlen($endminute) == 1){
            $endminute = '0'.$endminute;
        }else{
            $endminute = $endminute;
        }

        $data_feedback = array(
            'CHR_WO_NUMBER' => $wo_number,
            'CHR_PROBLEM' => $problem,
            'CHR_CORRECTIVE_ACTION' => $corrective_action,
            'CHR_START' => $starthour.':'.$startminute.':00',
            'CHR_END' => $endhour.':'.$endminute.':00',
            'CHR_CREATED_BY' => $username,
            'CHR_CREATED_DATE' => date("Ymd"),
            'CHR_CREATED_TIME' => date("His")
        );

        $this->feedback_recovery_prod_m->save($data_feedback);
               
        redirect($this->back_to_manage.date("Ym").'/'.$msg = 1);
    }

    function edit_feedback($id) {
        $date = date('d-m-Y');
        $data['date'] = $date;
        $data['data'] = $this->feedback_recovery_prod_m->get_data_problem_and_recovery_by_id($id)->row();

        $data['content'] = 'display_prod/feedback/edit_feedback_recovery_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(157);

        $data['title'] = 'Edit Feedback Recovery';
        $this->load->view($this->layout, $data);
    }

    function update_feedback() {
        $id = $this->input->post('INT_ID');

        $session = $this->session->all_userdata();

        $problem = $this->input->post('CHR_PROBLEM');
        $corrective_action = $this->input->post('CHR_CORRECTIVE_ACTION');

        $starthour = $this->input->post('START_HOUR');
        $startminute = $this->input->post('START_MINUTE');
        $endhour = $this->input->post('END_HOUR');
        $endminute = $this->input->post('END_MINUTE');

        if ($endhour < $starthour){
            redirect($this->back_to_manage . $msg = 5);
        }

        if ($endhour > 23){
            redirect($this->back_to_manage . $msg = 5);
        }

        if ($endminute > 59){
            redirect($this->back_to_manage . $msg = 5);
        }

        if (date('G') < 6) {
            $date = date('Ymd', strtotime(date('Ymd') . ' - 1 days'));
        } else {
            $date = date('Ymd');
        }

        $data_prod = $this->db->query("SELECT TOP 1 CHR_WO_NUMBER FROM TT_PRODUCTION_RESULT WHERE CHR_WORK_CENTER = '$wcenter' and CHR_DATE = '$date' ORDER BY CHR_CREATED_TIME DESC");
        
        if ($data_prod->num_rows() > 0){
            $get_data = $data_prod->row();
            $wo = trim($get_data->CHR_WO_NUMBER);
        }else{
            $wo = $wcenter.'/'.date('Ymd');
        }

        if(strlen($endhour) == 1){
            $endhour = '0'.$endhour;
        }else{
            $endhour = $endhour;
        }

        if(strlen($endminute) == 1){
            $endminute = '0'.$endminute;
        }else{
            $endminute = $endminute;
        }

        $data_feedback = array(
            // 'CHR_PROBLEM' => $problem,
            // 'CHR_CORRECTIVE_ACTION' => $corrective_action,
            'CHR_END' => $endhour.':'.$endminute.':00'//,
            // 'INT_ID_DEPT' => $session['DEPT']  
        );

        $this->feedback_recovery_prod_m->update_time($data_feedback, $id);
               
        redirect($this->back_to_manage . $msg = 2);
    }

    function delete_feedback($id) {
        $this->feedback_recovery_prod_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
