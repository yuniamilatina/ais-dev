<?php

class message_display_prod_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'display_prod/message_display_prod_c/index/';
    private $home = '/basis/home_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('display_prod/message_display_prod_m');
        $this->load->model('display_prod/master_message_m');
        $this->load->model('organization/dept_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('14');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Line yang dipilih belum produksi, pastikan Line yang pilih sudah produksi</div >";
        }

        $session = $this->session->all_userdata();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(155);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Display Message';
        $data['msg'] = $msg;

        $data['data'] = $this->message_display_prod_m->get_data_message($session['DEPT']);
        $data['content'] = 'display_prod/manage_message_display_v';
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_message() {
        $this->role_module_m->authorization('14');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(155);
        $session = $this->session->all_userdata();
        $dept = $session['DEPT'];

        $data['title'] = 'Create Message';
        $data['work_center_all'] = $this->message_display_prod_m->get_all_work_center_by_dept($dept);
        $data['getMessage'] = $this->master_message_m->get_data_message();

        $data['content'] = 'display_prod/create_message_display_v';
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_message() {
        $wcenter = trim($this->input->post('CHR_WORK_CENTER'));
        //$shift = $this->input->post('CHR_SHIFT');
        $target = $this->input->post('CHR_TARGET_SOLVE');
        $message = $this->input->post('CHR_MESSAGE');
        $message_free = $this->input->post('CHR_MESSAGE_FREE');
        $check = $this->input->post('INT_FLG_CHECK');
        $session = $this->session->all_userdata();

        if($message){
            $message_save = $message;
        }else{
            $message_save = $message_free;
        }

        if (date('G') < 6) {
            $date = date('Ymd', strtotime(date('Ymd') . ' - 1 days'));
        } else {
            $date = date('Ymd');
        }

        $data_prod = $this->db->query("SELECT TOP 1 CHR_WO_NUMBER FROM PRD.TM_PRODUCTION_ACTIVITY WHERE CHR_WORK_CENTER = '$wcenter' and CHR_DATE = '$date' ORDER BY CHR_CREATED_TIME DESC");
        
        if ($data_prod->num_rows() > 0){
            $get_data = $data_prod->row();
            $wo = trim($get_data->CHR_WO_NUMBER);
        }else{
            redirect($this->back_to_manage . $msg = 4);
        }
        
        $futureDate = strtotime(date('Ymd His')) + (60 * $target);
        $formatDateTarget = date("H:i:s", $futureDate);

        $data = array(
            'CHR_WO_NUMBER' => $wo,
            'CHR_MESSAGE' => $message_save,
            'INT_ID_DEPT' => $session['DEPT'],
            'CHR_TARGET_SOLVE' => $formatDateTarget,
            'CHR_CREATED_BY' => $session['USERNAME'],
            'CHR_CREATED_DATE' => date("Ymd"),
            'CHR_CREATED_TIME' => date("His")
        );
        $this->message_display_prod_m->save($data);
        redirect($this->back_to_manage . $msg = 1);
    }

    //prepare to editing
    function edit_message($id) {
        $date = date('d-m-Y');
        $data['date'] = $date;
        $this->role_module_m->authorization('155');
        $data['data'] = $this->message_display_prod_m->get_data_message_by_id($id)->row();

        $data['content'] = 'display_prod/edit_message_display_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(155);

        $data['title'] = 'Edit Message Display';
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_message() {
        $id = $this->input->post('INT_ID');
        $wo = $this->input->post('CHR_WO_NUMBER');

        $data = array(
            'CHR_WO_NUMBER' => $wo,
            //'CHR_TARGET_SOLVE' => $this->input->post('CHR_TARGET_SOLVE'),
            'CHR_MESSAGE' => $this->input->post('CHR_MESSAGE'),
        );
        $this->message_display_prod_m->update($data, $id);
        redirect($this->back_to_manage . $msg = 2);
    }

    //deleting data
    function delete_message($id) {
        $this->message_display_prod_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
