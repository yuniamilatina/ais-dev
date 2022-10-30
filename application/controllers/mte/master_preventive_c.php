<?php

class master_preventive_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mte/preventive_schedule_m');
        $this->load->model('mte/master_preventive_m');
	    $this->load->model('basis/role_module_m');
	    $this->load->model('portal/news_m');
	    $this->load->model('portal/notification_m');
    }

    private $layout = '/template/head';
    private $back_to_manage = 'mte/master_preventive_c/index/';
    private $back_to_manage_act = 'mte/master_preventive_c/manage_activities/';
    private $back_to_manage_drw = 'mte/master_preventive_c/manage_drawing/';
    private $back_to_manage_wi = 'mte/master_preventive_c/manage_manual/';


    function index($msg = NULL, $group_line = NULL) {
        $this->role_module_m->authorization('10');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Executing error !</strong> Something is not right. </div >";
        } else {
            $msg = NULL;
        }

        if($group_line == '' || $group_line == NULL){
            $group_line = 1;
        }

        if($group_line == 1){
            $group_code = "A";
            $group_type = "MOLD";
        } else if($group_line == 2){
            $group_code = "B";
            $group_type = "DIES STP";
        } else if($group_line == 3){
            $group_code = "C";
            $group_type = "DIES DF";
        } else if($group_line == 4){
            $group_code = "D";
            $group_type = "MACHINE";
        } else if($group_line == 5){
            $group_code = "E";
            $group_type = "JIG (STROKE)";
        } else if($group_line == 6){
            $group_code = "F";
            $group_type = "ELECTRODE";
        } else if($group_line == 7){
            $group_code = "G";
            $group_type = "JIG (SCHEDULE)";
        } else if($group_line == 8){
            $group_code = "H";
            $group_type = "POKAYOKE";
        }

        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(333);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Checksheet Preventive';
        $data['msg'] = $msg;
        $data['data'] = $this->master_preventive_m->get_checksheet($group_code);
        $data['subcontent'] = NULL;
        $data['content'] = 'mte/manage_checksheet_v';
        $this->load->view($this->layout, $data);
    }

    function show_create() {
        $group_line = $this->input->post('id_type');
        if($group_line == 1){
            $group_code = "A";
            $group_type = "MOLD";
        } else if($group_line == 2){
            $group_code = "B";
            $group_type = "DIES STP";
        } else if($group_line == 3){
            $group_code = "C";
            $group_type = "DIES DF";
        } else if($group_line == 4){
            $group_code = "D";
            $group_type = "MACHINE";
        } else if($group_line == 5){
            $group_code = "E";
            $group_type = "JIG (STROKE)";
        } else if($group_line == 6){
            $group_code = "F";
            $group_type = "ELECTRODE";
        } else if($group_line == 7){
            $group_code = "G";
            $group_type = "JIG (SCHEDULE)";
        } else if($group_line == 8){
            $group_code = "H";
            $group_type = "POKAYOKE";
        }

        $data['list_part'] = $this->master_preventive_m->get_part_by_type($group_code);

        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;
        
        echo $this->load->view('mte/create_checksheet_v', $data);
    }

    function show_create_drawing() {
        $group_line = $this->input->post('id_type');
        if($group_line == 1){
            $group_code = "A";
            $group_type = "MOLD";
        } else if($group_line == 2){
            $group_code = "B";
            $group_type = "DIES STP";
        } else if($group_line == 3){
            $group_code = "C";
            $group_type = "DIES DF";
        } else if($group_line == 4){
            $group_code = "D";
            $group_type = "MACHINE";
        } else if($group_line == 5){
            $group_code = "E";
            $group_type = "JIG (STROKE)";
        } else if($group_line == 6){
            $group_code = "F";
            $group_type = "ELECTRODE";
        } else if($group_line == 7){
            $group_code = "G";
            $group_type = "JIG (SCHEDULE)";
        } else if($group_line == 8){
            $group_code = "H";
            $group_type = "POKAYOKE";
        }

        $data['list_part'] = $this->master_preventive_m->get_part_by_type($group_code);

        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;
        
        echo $this->load->view('mte/create_drawing_v', $data);
    }

    function show_create_manual() {
        $group_line = $this->input->post('id_type');
        if($group_line == 1){
            $group_code = "A";
            $group_type = "MOLD";
        } else if($group_line == 2){
            $group_code = "B";
            $group_type = "DIES STP";
        } else if($group_line == 3){
            $group_code = "C";
            $group_type = "DIES DF";
        } else if($group_line == 4){
            $group_code = "D";
            $group_type = "MACHINE";
        } else if($group_line == 5){
            $group_code = "E";
            $group_type = "JIG (STROKE)";
        } else if($group_line == 6){
            $group_code = "F";
            $group_type = "ELECTRODE";
        } else if($group_line == 7){
            $group_code = "G";
            $group_type = "JIG (SCHEDULE)";
        } else if($group_line == 8){
            $group_code = "H";
            $group_type = "POKAYOKE";
        }

        $data['list_part'] = $this->master_preventive_m->get_part_by_type($group_code);

        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;
        
        echo $this->load->view('mte/create_manual_v', $data);
    }

    function cancel_create() {
        echo null;
    }

    function cancel_edit_drawing() {
        echo null;
    }

    function save_checksheet() {
        $session = $this->session->all_userdata();
        $group_line = $this->input->post('GROUP_LINE');
        $type = $this->input->post('GROUP_CODE');

        $date_now = date('Ymd');
        $time_now = date('His');
        $get_last_no = $this->master_preventive_m->get_last_no_checksheet($date_now);
        $last_no = 0;
        if($get_last_no->num_rows() > 0){
            $exist_no = substr($get_last_no->row()->CHR_CHECKSHEET_CODE,15,3);
            $last_no = (int)$exist_no + 1;            
        } else {
            $last_no = $last_no + 1;
        }
        $new_no = sprintf("%03d", $last_no);
        $check_code = 'CSH/' . $type . '/' . $date_now . '/' . $new_no;
        
        $part = $this->input->post('opt_radio');
        if($part == '0'){
            $id_part = $this->input->post('PART_CODE');
        } else {
            $id_part = NULL;
        }
        
        $data = array(
            'CHR_TYPE' => $type,
            'INT_ID_PART' => $id_part,
            'CHR_CHECKSHEET_CODE' => $check_code,
            'CHR_CHECKSHEET_NAME' => $this->input->post('CHECKSHEET_NAME'),
            'CHR_CREATED_BY' => $session['USERNAME'],
            'CHR_CREATED_DATE' => date('Ymd'),
            'CHR_CREATED_TIME' => date('His')
        );
        $this->master_preventive_m->save($data);

        redirect($this->back_to_manage . $msg = 1 . '/' . $group_line);
    }

    function edit_checksheet($id) {
        $this->role_module_m->authorization('10');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(333);
        $data['news'] = $this->news_m->get_news();

        $get_checksheet = $this->master_preventive_m->get_checksheet_by_id($id)->row();
        $data['checksheet'] = $get_checksheet;

        $group_code = $get_checksheet->CHR_TYPE;
        if($group_code == "A"){
            $group_line = 1;
            $group_type = "MOLD";
        } else if($group_code == "B"){
            $group_line = 2;
            $group_type = "DIES STP";
        } else if($group_code == "C"){
            $group_line = 3;
            $group_type = "DIES DF";
        } else if($group_code == "D"){
            $group_line = 4;
            $group_type = "MACHINE";
        } else if($group_code == "E"){
            $group_line = 5;
            $group_type = "JIG (STROKE)";
        } else if($group_code == "F"){
            $group_line = 6;
            $group_type = "ELECTRODE";
        } else if($group_code == "G"){
            $group_line = 7;
            $group_type = "JIG (SCHEDULE)";
        } else if($group_code == "H"){
            $group_line = 8;
            $group_type = "POKAYOKE";
        }

        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;

        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['data'] = $this->master_preventive_m->get_checksheet($group_code);
        $data['list_part'] = $this->master_preventive_m->get_part_by_type($group_code);
        $data['title'] = 'Edit Checksheet';
        $data['msg'] = NULL;
        $data['subcontent'] = 'mte/edit_checksheet_v';
        $data['content'] = 'mte/manage_checksheet_v';
        $this->load->view($this->layout, $data);
    }

    function update_checksheet() {
        $id = $this->input->post('ID_CHECKSHEET');
        $session = $this->session->all_userdata();

        $group_line = $this->input->post('GROUP_LINE');
        $type = $this->input->post('GROUP_CODE');

        $part = $this->input->post('opt_radio');
        if($part == '0'){
            $id_part = $this->input->post('PART_CODE');
        } else {
            $id_part = NULL;
        }

        $data = array(
            'INT_ID_PART' => $id_part,
            'CHR_CHECKSHEET_NAME' => $this->input->post('CHECKSHEET_NAME'),
            'CHR_MODIFIED_BY' => $session['USERNAME'],
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );
        $this->master_preventive_m->update($data, $id);

        redirect($this->back_to_manage . $msg = 2 . '/' . $group_line);
    }
    
    function disable_checksheet($id,  $group_line) {
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        $this->db->query("UPDATE MTE.TM_CHECKSHEET_PREVENTIVE 
                            SET INT_FLG_DEL = 1,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID = '$id'");
        redirect($this->back_to_manage . $msg = 2 . '/' . $group_line);
    }
    
    function enable_checksheet($id,  $group_line) {
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        $this->db->query("UPDATE MTE.TM_CHECKSHEET_PREVENTIVE 
                            SET INT_FLG_DEL = 0,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID = '$id'");
        redirect($this->back_to_manage . $msg = 2 . '/' . $group_line);
    }

    function manage_activities($msg, $id) {
        
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Executing error !</strong> Something is not right. </div >";
        } else {
            $msg = NULL;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(333);
        $data['news'] = $this->news_m->get_news();

        $get_checksheet = $this->master_preventive_m->get_checksheet_by_id($id)->row();
        $data['checksheet'] = $get_checksheet;

        $group_code = $get_checksheet->CHR_TYPE;
        if($group_code == "A"){
            $group_line = 1;
            $group_type = "MOLD";
        } else if($group_code == "B"){
            $group_line = 2;
            $group_type = "DIES STP";
        } else if($group_code == "C"){
            $group_line = 3;
            $group_type = "DIES DF";
        } else if($group_code == "D"){
            $group_line = 4;
            $group_type = "MACHINE";
        } else if($group_code == "E"){
            $group_line = 5;
            $group_type = "JIG (STROKE)";
        } else if($group_code == "F"){
            $group_line = 6;
            $group_type = "ELECTRODE";
        } else if($group_code == "G"){
            $group_line = 7;
            $group_type = "JIG (SCHEDULE)";
        } else if($group_code == "H"){
            $group_line = 8;
            $group_type = "POKAYOKE";
        }

        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;

        $data['data'] = $this->master_preventive_m->get_activities_by_id_checksheet($id);
        $data['title'] = 'Manage Activities';
        $data['msg'] = NULL;
        $data['content'] = 'mte/manage_preventive_activities_v';
        $this->load->view($this->layout, $data);
    }

    function add_main_activity() {
        $id_checksheet = $this->input->post('ID_CHECKSHEET');
        $session = $this->session->all_userdata();
        $cs = $this->master_preventive_m->get_checksheet_by_id($id_checksheet)->row();

        for($i=1; $i<=5; $i++){
            $activity = $this->input->post('ACTIVITY_' . $i);
            if($activity != NULL || $activity != ""){
                $get_last_seq = $this->master_preventive_m->get_last_seq_activity_by_id_checksheet($id_checksheet);
                $new_seq = $i;
                if($get_last_seq->num_rows() > 0){
                    $last_seq = $get_last_seq->row()->INT_SEQUENCE;
                    $new_seq = $last_seq + 1;
                }
                $data = array(
                    'INT_ID_CHECKSHEET' => $id_checksheet,
                    'CHR_CHECKSHEET_CODE' => $cs->CHR_CHECKSHEET_CODE,
                    'CHR_ACTIVITY_CODE' => $cs->CHR_CHECKSHEET_CODE . '-' . $new_seq,
                    'INT_SEQUENCE' => $new_seq,
                    'CHR_ACTIVITY' => trim($activity),
                    'CHR_CREATED_BY' => $session['USERNAME'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );
                $this->master_preventive_m->save_activity($data);
            }            
        }        

        redirect($this->back_to_manage_act . $msg = 1 . '/' . $id_checksheet);
    }

    function add_activity_detail() {
        $id_checksheet = $this->input->post('ID_CHECKSHEET');
        $id_act = $this->input->post('ID_ACTIVITY');
        $session = $this->session->all_userdata();
        $act = $this->master_preventive_m->get_activity_by_id($id_act);

        for($i=1; $i<=5; $i++){
            $activity_detail = $this->input->post('ACTIVITY_DETAIL_' . $i);
            $item_check = $this->input->post('ITEM_CHECK_' . $i);
            $tool = $this->input->post('TOOL_' . $i);
            $std_check = $this->input->post('STD_CHECK_' . $i);
            if($activity_detail != NULL || $activity_detail != ""){
                $get_last_seq = $this->master_preventive_m->get_last_seq_activity_detail_by_id_activity($id_act);
                $new_seq = $i;
                if($get_last_seq->num_rows() > 0){
                    $last_seq = $get_last_seq->row()->INT_SEQUENCE;
                    $new_seq = $last_seq + 1;
                }
                $data = array(
                    'INT_ID_ACTIVITY' => $id_act,
                    'CHR_ACTIVITY_CODE' => $act->CHR_ACTIVITY_CODE,
                    'INT_SEQUENCE' => $new_seq,
                    'CHR_ACTIVITY_DETAIL' => trim($activity_detail),
                    'CHR_ITEM_CHECK' => trim($item_check),
                    'CHR_TOOL' => trim($tool),
                    'CHR_STD_CHECK' => trim($std_check),
                    'CHR_CREATED_BY' => $session['USERNAME'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );
                $this->master_preventive_m->save_activity_detail($data);
            }            
        }        

        redirect($this->back_to_manage_act . $msg = 1 . '/' . $id_checksheet);
    }

    function update_activity() {
        $id_checksheet = $this->input->post('ID_CHECKSHEET');
        $id_act = $this->input->post('ID_ACTIVITY');
        $session = $this->session->all_userdata();

        // $seq = $this->input->post('SEQUENCE_' . $id_act);
        $activity = $this->input->post('ACTIVITY_' . $id_act);

        $data = array(
            // 'INT_SEQUENCE' => $seq,
            'CHR_ACTIVITY' => $activity,
            'CHR_MODIFIED_BY' => $session['USERNAME'],
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );
        $this->master_preventive_m->update_activity($data, $id_act);

        redirect($this->back_to_manage_act . $msg = 1 . '/' . $id_checksheet);
    }

    function update_activity_detail() {
        $id_checksheet = $this->input->post('ID_CHECKSHEET');
        $id_act = $this->input->post('ID_ACTIVITY');
        $id_act_detail = $this->input->post('ID_ACTIVITY_DETAIL');
        $session = $this->session->all_userdata();

        // $seq = $this->input->post('SEQUENCE_' . $id_act);
        $activity_detail = $this->input->post('ACTIVITY_DETAIL_' . $id_act_detail);
        $item_check = $this->input->post('ITEM_CHECK_' . $id_act_detail);
        $tool = $this->input->post('TOOL_' . $id_act_detail);
        $std_check = $this->input->post('STD_CHECK_' . $id_act_detail);

        $data = array(
            // 'INT_SEQUENCE' => $seq,
            'CHR_ACTIVITY_DETAIL' => trim($activity_detail),
            'CHR_ITEM_CHECK' => trim($item_check),
            'CHR_TOOL' => trim($tool),
            'CHR_STD_CHECK' => trim($std_check),
            'CHR_MODIFIED_BY' => $session['USERNAME'],
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );
        $this->master_preventive_m->update_activity_detail($data, $id_act_detail);

        redirect($this->back_to_manage_act . $msg = 1 . '/' . $id_checksheet);
    }

    function delete_activity($id_checksheet, $id_act) {
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');

        $get_act = $this->master_preventive_m->get_activity_by_id($id_act);
        $seq = $get_act->INT_SEQUENCE;

        //===== Update SEQUENCE Other Activity pada TM_ACTIVITY_PREVENTIVE
        $this->db->query("UPDATE MTE.TM_ACTIVITY_PREVENTIVE 
                            SET INT_SEQUENCE = INT_SEQUENCE - 1,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID_CHECKSHEET = '$id_checksheet' AND INT_SEQUENCE > '$seq' AND INT_FLG_DEL = '0'");

        //===== Update FLAG DELETE pada TM_ACTIVITY_PREVENTIVE
        $this->db->query("UPDATE MTE.TM_ACTIVITY_PREVENTIVE 
                            SET INT_FLG_DEL = 1,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID = '$id_act'");

        //===== Update FLAG DELETE pada TM_ACTIVITY_PREVENTIVE_DETAIL
        $this->db->query("UPDATE MTE.TM_ACTIVITY_PREVENTIVE_DETAIL
                            SET INT_FLG_DEL = 1,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID_ACTIVITY = '$id_act'");

        redirect($this->back_to_manage_act . $msg = 3 . '/' . $id_checksheet);
    }

    function delete_activity_detail($id_checksheet, $id_act, $id_act_detail) {
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');

        $get_act = $this->master_preventive_m->get_activity_detail_by_id($id_act_detail);
        $seq = $get_act->INT_SEQUENCE;

        //===== Update SEQUENCE Other Activity pada TM_ACTIVITY_PREVENTIVE
        $this->db->query("UPDATE MTE.TM_ACTIVITY_PREVENTIVE_DETAIL 
                            SET INT_SEQUENCE = INT_SEQUENCE - 1,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID_ACTIVITY = '$id_act' AND INT_SEQUENCE > '$seq' AND INT_FLG_DEL = '0'");

        //===== Update FLAG DELETE pada TM_ACTIVITY_PREVENTIVE
        $this->db->query("UPDATE MTE.TM_ACTIVITY_PREVENTIVE_DETAIL 
                            SET INT_FLG_DEL = 1,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID = '$id_act_detail'");

        redirect($this->back_to_manage_act . $msg = 3 . '/' . $id_checksheet);
    }

    function manage_drawing($msg = NULL, $group_line = NULL) {
        $this->role_module_m->authorization('10');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Executing error !</strong> Something is not right. </div >";
        } else {
            $msg = NULL;
        }

        if($group_line == '' || $group_line == NULL){
            $group_line = 1;
        }

        if($group_line == 1){
            $group_code = "A";
            $group_type = "MOLD";
        } else if($group_line == 2){
            $group_code = "B";
            $group_type = "DIES STP";
        } else if($group_line == 3){
            $group_code = "C";
            $group_type = "DIES DF";
        } else if($group_line == 4){
            $group_code = "D";
            $group_type = "MACHINE";
        } else if($group_line == 5){
            $group_code = "E";
            $group_type = "JIG (STROKE)";
        } else if($group_line == 6){
            $group_code = "F";
            $group_type = "ELECTRODE";
        } else if($group_line == 7){
            $group_code = "G";
            $group_type = "JIG (SCHEDULE)";
        } else if($group_line == 8){
            $group_code = "H";
            $group_type = "POKAYOKE";
        }

        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(334);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Drawing';
        $data['msg'] = $msg;
        $data['data'] = $this->master_preventive_m->get_drawing($group_code);
        $data['subcontent'] = NULL;
        $data['content'] = 'mte/manage_drawing_v';
        $this->load->view($this->layout, $data);
    }

    function edit_drawing($id) {
        $this->role_module_m->authorization('10');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(334);
        $data['news'] = $this->news_m->get_news();

        $get_drawing = $this->master_preventive_m->get_drawing_by_id($id);
        $data['drawing'] = $get_drawing;

        $group_code = $get_drawing->CHR_TYPE;
        if($group_code == "A"){
            $group_line = 1;
            $group_type = "MOLD";
        } else if($group_code == "B"){
            $group_line = 2;
            $group_type = "DIES STP";
        } else if($group_code == "C"){
            $group_line = 3;
            $group_type = "DIES DF";
        } else if($group_code == "D"){
            $group_line = 4;
            $group_type = "MACHINE";
        } else if($group_code == "E"){
            $group_line = 5;
            $group_type = "JIG";
        } else if($group_code == "F"){
            $group_line = 6;
            $group_type = "ELECTRODE";
        } else if($group_code == "G"){
            $group_line = 7;
            $group_type = "JIG (SCHEDULE)";
        } else if($group_code == "H"){
            $group_line = 8;
            $group_type = "POKAYOKE";
        }

        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;

        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['data'] = $this->master_preventive_m->get_drawing($group_code);
        $data['list_part'] = $this->master_preventive_m->get_part_by_type($group_code);
        $data['title'] = 'Edit Drawing';
        $data['msg'] = NULL;
        $data['subcontent'] = 'mte/edit_drawing_v';
        $data['content'] = 'mte/manage_drawing_v';
        $this->load->view($this->layout, $data);
    }

    function manage_manual($msg = NULL, $group_line = NULL, $manual_type = NULL) {
        $this->role_module_m->authorization('10');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>x</button><strong>Executing error !</strong> Something is not right. </div >";
        } else {
            $msg = NULL;
        }

        if($group_line == '' || $group_line == NULL){
            $group_line = 1;
        }

        if($group_line == 1){
            $group_code = "A";
            $group_type = "MOLD";
        } else if($group_line == 2){
            $group_code = "B";
            $group_type = "DIES STP";
        } else if($group_line == 3){
            $group_code = "C";
            $group_type = "DIES DF";
        } else if($group_line == 4){
            $group_code = "D";
            $group_type = "MACHINE";
        } else if($group_line == 5){
            $group_code = "E";
            $group_type = "JIG (STROKE)";
        } else if($group_line == 6){
            $group_code = "F";
            $group_type = "ELECTRODE";
        } else if($group_line == 7){
            $group_code = "G";
            $group_type = "JIG (SCHEDULE)";
        } else if($group_line == 8){
            $group_code = "H";
            $group_type = "POKAYOKE";
        }

        if($manual_type == '' || $manual_type == NULL){
            $manual_type = 'WIS';
        }

        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;
        $data['manual_type'] = $manual_type;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(335);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Manual (WI & FT)';
        $data['msg'] = $msg;
        $data['data'] = $this->master_preventive_m->get_manual($group_code, $manual_type);
        $data['subcontent'] = NULL;
        $data['content'] = 'mte/manage_manual_v';
        $this->load->view($this->layout, $data);
    }

    function save_drawing() {
        $session = $this->session->all_userdata();
        $group_line = $this->input->post('GROUP_LINE');
        $type = $this->input->post('GROUP_CODE');

        $date_now = date('Ymd');
        $time_now = date('His');
        $get_last_no = $this->master_preventive_m->get_last_no_drawing($date_now);
        $last_no = 0;
        if($get_last_no->num_rows() > 0){
            $exist_no = substr($get_last_no->row()->CHR_DRAWING_CODE,15,3);
            $last_no = (int)$exist_no + 1;            
        } else {
            $last_no = $last_no + 1;
        }
        $new_no = sprintf("%03d", $last_no);
        $drw_code = 'DRW/' . $type . '/' . $date_now . '/' . $new_no;
        
        $id_part = $this->input->post('PART_CODE');

        $maxsize = 1500;
	    $size = $_FILES['DRAWING']['size'];
		$ekstension = array('jpg', 'png', 'pdf');
		$file_name =  trim($id_part) . '_' . $_FILES['DRAWING']['name'];
		$x = explode('.',$file_name);
		$eksten = strtolower(end($x));
        $file_tmp = $_FILES['DRAWING']['tmp_name'];
        
        if(in_array($eksten, $ekstension) === true) {
			if($size <= $maxsize){
				move_uploaded_file($file_tmp,DOCROOT_PREV.'/assets/images/drw/'.$file_name);
				$data = array(
                    'CHR_TYPE' => $type,
                    'INT_ID_PART' => $id_part,
                    'CHR_DRAWING_CODE' => $drw_code,
                    'CHR_DRAWING_NAME' => trim($this->input->post('DRAWING_NAME')),
                    'CHR_DRAWING_TYPE' => trim(strtoupper($this->input->post('DRAWING_TYPE'))),
                    'CHR_FILE_DRAWING' => $file_name,
                    'CHR_CREATED_BY' => $session['USERNAME'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );
                $this->master_preventive_m->save_drawing($data);

		        redirect($this->back_to_manage_drw . $msg = 1 . '/' . $group_line);
			} else {
                redirect($this->back_to_manage_drw . $msg = 12 . '/' . $group_line);
			}
		} else {
            redirect($this->back_to_manage_drw . $msg = 12 . '/' . $group_line);
        }
    }

    function update_drawing() {
        $session = $this->session->all_userdata();
        $id_drw = $this->input->post('ID_DRAWING');
        $group_line = $this->input->post('GROUP_LINE');
        $type = $this->input->post('GROUP_CODE');

        $date_now = date('Ymd');
        $time_now = date('His');
        
        $id_part = $this->input->post('PART_CODE');

        $maxsize = 1500;
	    $size = $_FILES['DRAWING']['size'];
		$ekstension = array('jpg', 'png', 'pdf');
		$file_name = trim($id_part) . '_' . $_FILES['DRAWING']['name'];
		$x = explode('.',$file_name);
		$eksten = strtolower(end($x));
        $file_tmp = $_FILES['DRAWING']['tmp_name'];
        
        if($file_name == ""){
            $data = array(
                'INT_ID_PART' => $id_part,
                'CHR_DRAWING_NAME' => $this->input->post('DRAWING_NAME'),
                'CHR_DRAWING_TYPE' => $this->input->post('DRAWING_TYPE'),
                'CHR_MODIFIED_BY' => $session['USERNAME'],
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His')
            );

            $this->master_preventive_m->update_drawing($data, $id_drw);

            redirect($this->back_to_manage_drw . $msg = 2 . '/' . $group_line);
        } else {
            if(in_array($eksten, $ekstension) === true) {
                if($size <= $maxsize){
                    move_uploaded_file($file_tmp,DOCROOT_PREV.'/assets/images/drw/'.$file_name);
                    $data = array(
                        'INT_ID_PART' => $id_part,
                        'CHR_DRAWING_NAME' => trim($this->input->post('DRAWING_NAME')),
                        'CHR_DRAWING_TYPE' => trim(strtoupper($this->input->post('DRAWING_TYPE'))),
                        'CHR_FILE_DRAWING' => $file_name,
                        'CHR_MODIFIED_BY' => $session['USERNAME'],
                        'CHR_MODIFIED_DATE' => date('Ymd'),
                        'CHR_MODIFIED_TIME' => date('His')
                    );
                    $this->master_preventive_m->update_drawing($data, $id_drw);
    
                    redirect($this->back_to_manage_drw . $msg = 2 . '/' . $group_line);
                } else {
                    redirect($this->back_to_manage_drw . $msg = 12 . '/' . $group_line);
                }
            } else {
                redirect($this->back_to_manage_drw . $msg = 12 . '/' . $group_line);
            }
        }        
    }

    function disable_drawing($id,  $group_line) {
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        $this->db->query("UPDATE MTE.TM_DRAWING 
                            SET INT_FLG_DEL = 1,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID = '$id'");
        redirect($this->back_to_manage_drw . $msg = 2 . '/' . $group_line);
    }
    
    function enable_drawing($id,  $group_line) {
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        $this->db->query("UPDATE MTE.TM_DRAWING 
                            SET INT_FLG_DEL = 0,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID = '$id'");
        redirect($this->back_to_manage_drw . $msg = 2 . '/' . $group_line);
    }

    function save_manual() {
        $session = $this->session->all_userdata();
        $group_line = $this->input->post('GROUP_LINE');
        $type = $this->input->post('GROUP_CODE');
        $wi_group = $this->input->post('MANUAL_GROUP');

        $date_now = date('Ymd');
        $time_now = date('His');
        $get_last_no = $this->master_preventive_m->get_last_no_manual($date_now);
        $last_no = 0;
        if($get_last_no->num_rows() > 0){
            $exist_no = substr($get_last_no->row()->CHR_WI_CODE,15,3);
            $last_no = (int)$exist_no + 1;            
        } else {
            $last_no = $last_no + 1;
        }
        $new_no = sprintf("%03d", $last_no);
        $wi_code = $wi_group . '/' . $type . '/' . $date_now . '/' . $new_no;
        
        $part = $this->input->post('opt_radio');
        if($part == '0'){
            $id_part = $this->input->post('PART_CODE');
        } else {
            $id_part = NULL;
        }

        $maxsize = 1500;
	    $size = $_FILES['MANUAL_IMG']['size'];
		$ekstension = array('jpg', 'png', 'pdf');
		$file_name = $_FILES['MANUAL_IMG']['name'];
		$x = explode('.',$file_name);
		$eksten = strtolower(end($x));
        $file_tmp = $_FILES['MANUAL_IMG']['tmp_name'];
        
        if(in_array($eksten, $ekstension) === true) {
			if($size <= $maxsize){
				move_uploaded_file($file_tmp,DOCROOT_PREV.'/assets/images/wi/'.$file_name);
				$data = array(
                    'CHR_TYPE' => $type,
                    'INT_ID_PART' => $id_part,
                    'CHR_WI_GROUP' => $wi_group,
                    'CHR_WI_CODE' => $wi_code,
                    'CHR_WI_NAME' => trim($this->input->post('MANUAL_NAME')),
                    'CHR_WI_TYPE' => trim(strtoupper($this->input->post('MANUAL_TYPE'))),
                    'CHR_FILE_WI' => $file_name,
                    'CHR_CREATED_BY' => $session['USERNAME'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );
                $this->master_preventive_m->save_manual($data);

		        redirect($this->back_to_manage_wi . $msg = 1 . '/' . $group_line . '/' . $wi_group);
			} else {
                print_r('NG1');
                exit();
                redirect($this->back_to_manage_wi . $msg = 12 . '/' . $group_line . '/' . $wi_group);
			}
		} else {
            print_r('NG2');
            exit();
            redirect($this->back_to_manage_wi . $msg = 12 . '/' . $group_line . '/' . $wi_group);
        }
    }

    function edit_manual($id) {
        $this->role_module_m->authorization('10');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(335);
        $data['news'] = $this->news_m->get_news();

        $get_manual = $this->master_preventive_m->get_manual_by_id($id);
        $data['manual'] = $get_manual;
        $manual_type = $get_manual->CHR_WI_GROUP;
        $data['manual_type'] = $manual_type;

        $group_code = $get_manual->CHR_TYPE;
        if($group_code == "A"){
            $group_line = 1;
            $group_type = "MOLD";
        } else if($group_code == "B"){
            $group_line = 2;
            $group_type = "DIES STP";
        } else if($group_code == "C"){
            $group_line = 3;
            $group_type = "DIES DF";
        } else if($group_code == "D"){
            $group_line = 4;
            $group_type = "MACHINE";
        } else if($group_code == "E"){
            $group_line = 5;
            $group_type = "JIG (STROKE)";
        } else if($group_code == "F"){
            $group_line = 6;
            $group_type = "ELECTRODE";
        } else if($group_code == "G"){
            $group_line = 7;
            $group_type = "JIG (SCHEDULE)";
        } else if($group_code == "H"){
            $group_line = 8;
            $group_type = "POKAYOKE";
        }

        $data['group_line'] = $group_line;
        $data['group_type'] = $group_type;
        $data['group_code'] = $group_code;

        $data['all_group_line'] = $this->preventive_schedule_m->get_all_product_group_custom();
        $data['data'] = $this->master_preventive_m->get_manual($group_code, $manual_type);
        $data['list_part'] = $this->master_preventive_m->get_part_by_type($group_code);
        $data['title'] = 'Edit Manual';
        $data['msg'] = NULL;
        $data['subcontent'] = 'mte/edit_manual_v';
        $data['content'] = 'mte/manage_manual_v';
        $this->load->view($this->layout, $data);
    }

    function update_manual() {
        $session = $this->session->all_userdata();
        $id_wi = $this->input->post('ID_MANUAL');
        $group_line = $this->input->post('GROUP_LINE');
        $type = $this->input->post('GROUP_CODE');
        $manual_group = $this->input->post('MANUAL_GROUP');

        $date_now = date('Ymd');
        $time_now = date('His');
        
        $part = $this->input->post('opt_radio');
        if($part == '0'){
            $id_part = $this->input->post('PART_CODE');
        } else {
            $id_part = NULL;
        }

        $maxsize = 1500;
	    $size = $_FILES['MANUAL_IMG']['size'];
		$ekstension = array('jpg', 'png', 'pdf');
		$file_name = $_FILES['MANUAL_IMG']['name'];
		$x = explode('.',$file_name);
		$eksten = strtolower(end($x));
        $file_tmp = $_FILES['MANUAL_IMG']['tmp_name'];
        
        if($file_name == ""){
            $data = array(
                'INT_ID_PART' => $id_part,
                'CHR_WI_NAME' => $this->input->post('MANUAL_NAME'),
                'CHR_WI_TYPE' => $this->input->post('MANUAL_TYPE'),
                'CHR_MODIFIED_BY' => $session['USERNAME'],
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His')
            );

            $this->master_preventive_m->update_manual($data, $id_wi);

            redirect($this->back_to_manage_wi . $msg = 2 . '/' . $group_line . '/' . $manual_group);
        } else {
            if(in_array($eksten, $ekstension) === true) {
                if($size <= $maxsize){
                    move_uploaded_file($file_tmp,DOCROOT_PREV.'/assets/images/wi/'.$file_name);
                    $data = array(
                        'INT_ID_PART' => $id_part,
                        'CHR_WI_NAME' => trim($this->input->post('MANUAL_NAME')),
                        'CHR_WI_TYPE' => trim(strtoupper($this->input->post('MANUAL_TYPE'))),
                        'CHR_FILE_WI' => $file_name,
                        'CHR_MODIFIED_BY' => $session['USERNAME'],
                        'CHR_MODIFIED_DATE' => date('Ymd'),
                        'CHR_MODIFIED_TIME' => date('His')
                    );
                    $this->master_preventive_m->update_manual($data, $id_wi);
    
                    redirect($this->back_to_manage_wi . $msg = 2 . '/' . $group_line . '/' . $manual_group);
                } else {
                    redirect($this->back_to_manage_wi . $msg = 12 . '/' . $group_line . '/' . $manual_group);
                }
            } else {
                redirect($this->back_to_manage_wi . $msg = 12 . '/' . $group_line . '/' . $manual_group);
            }
        }        
    }

    function disable_manual($id,  $group_line, $manual_group) {
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        $this->db->query("UPDATE MTE.TM_WI 
                            SET INT_FLG_DEL = 1,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID = '$id'");
        redirect($this->back_to_manage_wi . $msg = 2 . '/' . $group_line . '/' . $manual_group);
    }
    
    function enable_manual($id,  $group_line) {
        $session = $this->session->all_userdata();
        $pic = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');
        $this->db->query("UPDATE MTE.TM_WI 
                            SET INT_FLG_DEL = 0,
                                CHR_MODIFIED_BY = '$pic',
                                CHR_MODIFIED_DATE = '$date',
                                CHR_MODIFIED_TIME = '$time'
                        WHERE INT_ID = '$id'");
        redirect($this->back_to_manage_wi . $msg = 2 . '/' . $group_line . '/' . $manual_group);
    }

}

?>
