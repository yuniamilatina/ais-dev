<?php

class schedule_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'eci/schedule_c/index/';
    public function __construct() {
        parent::__construct();
        $this->load->model('eci/pic_m');
        $this->load->model('eci/activity_m');
        $this->load->model('eci/category_m');
        $this->load->model('eci/eci_h_m');
        $this->load->model('eci/eci_l_m');
        $this->load->model('basis/user_m');
        $this->load->model('eci/eci_feedback_m');
        $this->load->library('PHPExcel');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('57');
        $this->log_m->add_log(23, NULL);
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data already inserted !</strong> You can revise with same project number </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(57);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Create Project';
        $data['msg'] = $msg;
        $data['get_cat'] = $this->category_m->find_trans("*", "INT_ID_CATEGORY<>0", "INT_ID_CATEGORY");
        $data['data'] = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0", "CHR_ID_ECI, INT_REV");
        $data['content'] = 'eci/schedule/create_new_v';
        $this->load->view($this->layout, $data);
    }

    function save_schedule() {
        $this->role_module_m->authorization('146');
        $this->form_validation->set_rules('eci_name', 'Id Category', 'required|max_length[40]|callback_check_id|trim');
        $id = $this->eci_h_m->generate_id_eci();
        $id_category = $this->input->post('category_h');
        $result = $this->db->query("select * from TM_ECI_CATEGORY where INT_ID_CATEGORY = '$id_category'")->row();
        $category_name = $result->CHR_CATEGORY_NAME;
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 4);
        } else {
            $data = array(
                'CHR_ID_ECI' => $id,
                'INT_TYPE' => $this->input->post('type_h'),
                'ID_CATEGORY' => $id_category,
                'CHR_CATEGORY_NAME' => $category_name,
                'CHR_NAME' => strtoupper($this->input->post('eci_name')),
                'CHR_CUSTOMER' => strtoupper($this->input->post('customer')),
                'CHR_FG_PARTNAME' => strtoupper($this->input->post('fg_partname')),
                'CHR_VEHICLE' => strtoupper($this->input->post('vehicle')),
                'CHR_CONTENT' => strtoupper($this->input->post('content_eci')),
                'CHR_START_DATE' => date("Ymd", strtotime($this->input->post('receive_date'))),
                'CHR_RECEIVE_DATE' => date("Ymd", strtotime($this->input->post('receive_date'))),
                'CHR_DUE_DATE' => date("Ymd", strtotime($this->input->post('implementing_date'))),
                'CHR_SHIPPING_DATE' => date("Ymd", strtotime($this->input->post('implementing_date'))),
                'CHR_CUST_REQ_DATE' => date("Ymd", strtotime($this->input->post('cust_date'))),
                'CHR_IMPLEMENTING_PLAN' => date("Ymd", strtotime($this->input->post('implementing_date'))),
                'CHR_USR_ENTRY' => $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His'),
                'INT_REV' => 0,
                'CHR_FLG_PUBLISH' => '1', //after
                //'CHR_FLG_PUBLISH' => '0', //before
                'CHR_STAT_FINISH' => '0',
                'CHR_INTERCHANGE' => $this->input->post('interchange_h'),
                'FLT_PROGRESS' => 0
            );
            $this->eci_h_m->add_trans($data);
            redirect('eci/schedule_c/activity_project/1/' . $id . '');
        }
    }
    function listpic(){
        $get_data = $this->eci_l_m->listpic();
        $data = array();
        foreach ($get_data as $row) {  
            $row_array['key'] = trim($row->INT_ID_PIC);//trim($row->INT_ID_ACTIVITY) . " - " . $def;
            $row_array['label'] = trim($row->CHR_NAME);
            
            array_push($data, $row_array);
        }
        echo json_encode($data);
    }
    function prepare_edit_project($eci_id) {
        $this->role_module_m->authorization('57');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(57);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Edit Project';

        $data['get_cat'] = $this->category_m->find_trans("*", "INT_ID_CATEGORY<>0", "INT_ID_CATEGORY");
        $data['data'] = $this->eci_h_m->get_eci_h_by_id($eci_id);
        $data['content'] = 'eci/schedule/edit_project_v';
        $this->load->view($this->layout, $data);
    }

    function update_schedule() {
        $this->role_module_m->authorization('146');
        $id_category = $this->input->post('category_h');
        $result = $this->db->query("select * from TM_ECI_CATEGORY where INT_ID_CATEGORY = '$id_category'")->row();
        $session = $this->session->all_userdata();

        $data = array(
            'INT_TYPE' => $this->input->post('type_h'),
            'ID_CATEGORY' => $this->input->post('category_h'),
            'CHR_CATEGORY_NAME' => $result->CHR_CATEGORY_NAME,
            'CHR_NAME' => strtoupper($this->input->post('eci_name')),
            'CHR_CUSTOMER' => strtoupper($this->input->post('customer')),
            'CHR_FG_PARTNAME' => strtoupper($this->input->post('fg_partname')),
            'CHR_VEHICLE' => strtoupper($this->input->post('vehicle')),
            'CHR_CONTENT' => strtoupper($this->input->post('content_eci')),
            'CHR_START_DATE' => date("Ymd", strtotime($this->input->post('receive_date'))),
            'CHR_RECEIVE_DATE' => date("Ymd", strtotime($this->input->post('receive_date'))),
            'CHR_DUE_DATE' => date("Ymd", strtotime($this->input->post('implementing_date'))),
            'CHR_SHIPPING_DATE' => date("Ymd", strtotime($this->input->post('implementing_date'))),
            'CHR_CUST_REQ_DATE' => date("Ymd", strtotime($this->input->post('cust_date'))),
            'CHR_IMPLEMENTING_PLAN' => date("Ymd", strtotime($this->input->post('implementing_date'))),
            'CHR_INTERCHANGE' => $this->input->post('interchange_h'),
            'CHR_USR_UPDATE' => $session['NPK'],
            'CHR_DATE_UPDATE' => date('Ymd'),
            'CHR_TIME_UPDATE' => date('His')
        );
        $this->eci_h_m->update_eci_h($data, $this->input->post('eci_id'));
        redirect('eci/schedule_c/index/2');
    }

    function revise_schedule() {
        $this->role_module_m->authorization('146');
        $id = $this->input->post('INT_ID_PIC');
        $npk = $this->input->post('CHR_NPK');
        $session = $this->session->all_userdata();
        $this->form_validation->set_rules('CHR_NPK', 'Id Category', 'required|max_length[4]|trim');
        $this->form_validation->set_rules('CHR_NAME', 'Category Desc', 'required');
        $this->form_validation->set_rules('CHR_DEPT', 'Category Desc', 'required|max_length[4]|trim');
        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'CHR_NAME' => strtoupper($this->input->post('CHR_NAME')),
                'CHR_DEPT' => strtoupper($this->input->post('CHR_DEPT')),
                'CHR_EMAIL' => $this->input->post('CHR_EMAIL'),
                'CHR_NAME_SUPERIOR' => strtoupper($this->input->post('CHR_NAME_SUPERIOR')),
                'CHR_EMAIL_SUPERIOR' => $this->input->post('CHR_EMAIL_SUPERIOR'),
                'CHR_USR_UPDATE' => $session['NPK'],
                'CHR_DATE_UPDATE' => date('Ymd'),
                'CHR_TIME_UPDATE' => date('His')
            );
            $this->pic_m->update_trans($data, " INT_ID_PIC = " . $id . "");
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_schedule($id_eci) {
        $this->role_module_m->authorization('146');
        $this->eci_h_m->delete_trans_l($id_eci);
        $this->eci_h_m->delete_trans_h($id_eci);
        redirect($this->back_to_manage . $msg = 3);
    }

    function getUpdate() {
        $this->role_module_m->authorization('146');
        $id_activity = $this->input->post("id_activity");
        $get_data = $this->eci_h_m->find_trans("*", "CHR_ID_ECI = '" . $id_activity . "'");
        $data = "";
        $data .= form_open('eci/schedule_c/revise_schedule', 'class="form-horizontal"');
        $data .= '
			<input name="CHR_ID_ECI" class="form-control" required type="hidden" value="' . $get_data[0]->CHR_ID_ECI . '">
			<div class=" form-group">
			<label class="col-sm-2 control-label">Project Type</label>
			<div class="col-sm-4">
			<input name="eci_name" id="type_h" class="form-control" readonly style="width:250px;text-transform: uppercase;" maxlength="40" required type="text" value="' . trim($get_data[0]->INT_TYPE) . '">
			</div>
			<label class="col-sm-2 control-label">Category</label>
			<div class="col-sm-4">
			<input name="eci_name" id="category_h" class="form-control" readonly style="width:250px;text-transform: uppercase;" maxlength="40" required type="text" value="' . trim($get_data[0]->CHR_CATEGORY_NAME) . '">
			</div>
			</div>
			<div class=" form-group">
			<label class="col-sm-2 control-label">Project / ECI Number</label>
			<div class="col-sm-4">
			<input name="eci_name" id="eci_name" class="form-control" readonly style="width:250px;text-transform: uppercase;" maxlength="40" required type="text" value="' . trim($get_data[0]->CHR_NAME) . '">
			</div>
			<label class="col-sm-2 control-label">Customer</label>
			<div class="col-sm-4">
			<input name="customer" id="customer" class="form-control" readonly style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="' . trim($get_data[0]->CHR_CUSTOMER) . '">
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label">FG Part Name</label>
			<div class="col-sm-4">   
			<input name="fg_partname" id="fg_partname" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="' . trim($get_data[0]->CHR_FG_PARTNAME) . '">
			</div>
			<label class="col-sm-2 control-label">Model</label>
			<div class="col-sm-4">
			<input name="vehicle" id="vehicle" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="50" required type="text" value="' . trim($get_data[0]->CHR_VEHICLE) . '">
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label">Contents</label>
			<div class="col-sm-4">   
			<input name="content_eci" id="content_eci" class="form-control" style="width:250px;text-transform: uppercase;" maxlength="80" required type="text" value="' . trim($get_data[0]->CHR_CONTENT) . '">
			</div>
			<label class="col-sm-2 control-label">Start Date</label>
			<div class="col-sm-4">
			<input onkeydown="return false" name="start_date" id="datepicker" class="form-control" required type="text" style="width: 125px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_START_DATE) . '">
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label">Receive Date</label>
			<div class="col-sm-4">
			<input onkeydown="return false" name="receive_date" id="datepicker1" class="form-control" required type="text" style="width: 125px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_RECEIVE_DATE) . '">
			
			</div>
			<label class="col-sm-2 control-label">Request Due Date</label>
			<div class="col-sm-4">
			<input onkeydown="return false" name="due_date" id="datepicker2" class="form-control" required type="text" style="width: 125px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_DUE_DATE) . '">
			</div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label">Cust Shipping Date</label>
			<div class="col-sm-4">
			<input onkeydown="return false" name="cust_shipping_date" id="datepicker3" class="form-control" required type="text" style="width: 125px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_SHIPPING_DATE) . '">
			</div>
			<label class="col-sm-2 control-label">Implementing Date</label>
			<div class="col-sm-4">
			<input onkeydown="return false" name="implementing_date" id="datepicker4" class="form-control" required type="text" style="width: 125px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_IMPLEMENTING_PLAN) . '">
			</div>
			</div>
			<div class="form-group">
			<div class="col-sm-8 col-sm-push-4">
			<div class="btn-group">
			<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Revise</button>
			';
        $data .= anchor('eci/schedule_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
        $data .= '         	</div>
			</div>
			</div>
			';
        $data .= form_close();
        echo $data;
    }

    function update_table() {
        $this->role_module_m->authorization('59');
        $id_eci = $this->input->post("id_eci");
        $get_data = $this->eci_l_m->find_trans("*", "CHR_ID_ECI = " . $id_eci . "");
        $data = "";
        $data .= '
			<table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
			<thead>
			<tr>
			<th>Activity</th>
			<th>PIC</th>
			<th>Department</th>
			<th>Start Date</th>
			<th>Due Date</th>
			<th>Actions</th>
			</tr>
			</thead>
			<tbody>';
        $i = 1;
        foreach ($get_data as $isi) {
            $data .= '<tr>';
            $data .= '<td>' . $isi->CHR_ACTIVITY_NAME . '</td>';
            $data .= '<td>' . $isi->CHR_PIC_NAME . '</td>';
            $data .= '<td>' . $isi->CHR_PIC_DEPT . '</td>';
            $data .= '<td>' . date("d-m-Y", strtotime($isi->CHR_START_DATE)) . '</td>';
            $data .= '<td>' . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . '</td>';
            $data .= '<td>';
            $data .= '<a href="' . base_url("index.php/eci/schedule_c/delete_schedule") . '/' . $isi->CHR_ID_ECI . '" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm("Are you sure want to delete this activity?");"><span class="fa fa-times"></span></a>';
            $data .= '</td>
				</tr>';
            $i++;
        }
        $data .= '</tbody>
			</table>
			';
        echo $data;
    }

    function update_table_1() {
        $this->role_module_m->authorization('59');
        $id_eci = $this->input->post("id_eci");
        if ($id_eci != "") {
            $get_data = $this->eci_l_m->find_trans("*", "CHR_ID_ECI = " . $id_eci . "AND CHR_FLG_PUBLISH = 0", "INT_SEQ ASC, CHR_START_DATE ASC, CHR_DATE_ENTRY DESC, CHR_TIME_ENTRY DESC");
            $data = "";
            $data .= '
				<table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
				<thead>
				<tr>
				<th>Seq</th>
				<th>Activity</th>
				<th>PIC</th>
				<th>Department</th>
				<th>Start Date</th>
				<th>Due Date</th>
				<th>Actions</th>
				</tr>
				</thead>
				<tbody>';
            $i = 1;
            foreach ($get_data as $isi) {
                $data .= '<tr>';
                $data .= '<td>' . $isi->INT_SEQ . '</td>';
                $data .= '<td>' . $isi->CHR_ACTIVITY_NAME . '</td>';
                $data .= '<td>' . $isi->CHR_PIC_NAME . '</td>';
                $data .= '<td>' . $isi->CHR_PIC_DEPT . '</td>';
                $data .= '<td>' . date("d-m-Y", strtotime($isi->CHR_START_DATE)) . '</td>';
                $data .= '<td>' . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . '</td>';
                $data .= '<td>';
                $data .= '<a href="' . base_url("index.php/eci/schedule_c/activity_editing") . '/' . $isi->CHR_ID_ECI . '/' . $isi->INT_ID_ECI_LINE . '"class="label label-warning" data-placement="right" data-toggle="tooltip" title="Edit This Activity" onclick="return confirm("Are you sure want to deactivate this activity?");"><span class="fa fa-pencil"></span></a>';
                $data .= '<a href="' . base_url("index.php/eci/schedule_c/delete_activity") . '/' . $isi->CHR_ID_ECI . '/' . $isi->INT_ID_ECI_LINE . '"class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm("Are you sure want to delete this activity?");"><span class="fa fa-times"></span></a>';
                $data .= '</td>
					</tr>';
                $i++;
            }
            $data .= '</tbody>
				</table>
				';
            echo $data;
        }
    }

    function update_table_2() {
        $this->role_module_m->authorization('59');
        $id_eci = trim($this->input->post("id_eci"));

        $get_data = $this->eci_l_m->find_trans("*", "CHR_ID_ECI = " . $id_eci . "", "INT_SEQ ASC, CHR_START_DATE ASC, CHR_DATE_ENTRY DESC, CHR_TIME_ENTRY DESC");

        $data = "";
        $data .= '
                <table id="dataTables3" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                <thead>
                <tr>
                <th>Seq</th>
                <th>Activity</th>
                <th>PIC</th>
                <th>Department</th>
                <th>Start Date</th>
                <th>Due Date</th>
                </tr>
                </thead>
                <tbody>';
        $i = 1;
        foreach ($get_data as $isi) {
            $data .= '<tr>';
            $data .= '<td>' . $isi->INT_SEQ . '</td>';
            $data .= '<td>' . $isi->CHR_ACTIVITY_NAME . '</td>';
            $data .= '<td>' . $isi->CHR_PIC_NAME . '</td>';
            $data .= '<td>' . $isi->CHR_PIC_DEPT . '</td>';
            $data .= '<td>' . date("d-m-Y", strtotime($isi->CHR_START_DATE)) . '</td>';
            $data .= '<td>' . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . '</td>';
//            $data .= '<td>';
//            $data .= '<a href="' . base_url("index.php/eci/schedule_c/activity_editing") . '/' . trim($isi->CHR_ID_ECI) . '/' . $isi->INT_ID_ECI_LINE . '"class="label label-warning" data-placement="right" data-toggle="tooltip" title="Edit This Activity" onclick="return confirm("Are you sure want to deactivate this activity?");"><span class="fa fa-pencil"></span></a>';
//            $data .= '<a href="' . base_url("index.php/eci/schedule_c/delete_activity") . '/' . trim($isi->CHR_ID_ECI) . '/' . $isi->INT_ID_ECI_LINE . '"class="label label-danger" data-placement="right" data-toggle="tooltip" title="Deactivate Activity" onclick="return confirm("Are you sure want to deactivate this activity?");"><span class="fa fa-times"></span></a>';
//            $data .= '</td>';
            $data .= '</tr>';
            $i++;
        }
        $data .= '</tbody>
                </table>
                ';
        echo $data;
    }

    function update_table_3() {
        $this->role_module_m->authorization('59');
        $id_eci = $this->input->post("id_eci");
        echo $id_eci;
        exit();
        $get_data = $this->eci_l_m->find_trans("*", "CHR_ID_ECI = " . $id_eci . "AND CHR_FLG_PUBLISH = 0", "INT_SEQ,CHR_START_DATE ASC");
        $data = "";
        $data .= '
			<table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
			<thead>
			<tr>
			<th>Seq</th>
			<th>Activity</th>
			<th>PIC</th>
			<th>Department</th>
			<th>Start Date</th>
			<th>Due Date</th>
			<th>Actions</th>
			</tr>
			</thead>
			<tbody>';
        $i = 1;
        foreach ($get_data as $isi) {
            $data .= '<tr>';
            $data .= '<td>' . $isi->INT_SEQ . '</td>';
            $data .= '<td>' . $isi->CHR_ACTIVITY_NAME . '</td>';
            $data .= '<td>' . $isi->CHR_PIC_NAME . '</td>';
            $data .= '<td>' . $isi->CHR_PIC_DEPT . '</td>';
            $data .= '<td>' . date("d-m-Y", strtotime($isi->CHR_START_DATE)) . '</td>';
            $data .= '<td>' . date("d-m-Y", strtotime($isi->CHR_DUE_DATE)) . '</td>';
            $data .= '<td>';
            $data .= '<a href="' . base_url("index.php/eci/schedule_c/activity_editing") . '/' . $isi->CHR_ID_ECI . '/' . $isi->INT_ID_ECI_LINE . '"class="label label-warning" data-placement="right" data-toggle="tooltip" title="Edit This Activity" onclick="return confirm("Are you sure want to deactivate this activity?");"><span class="fa fa-pencil"></span></a>';
            $data .= '<a href="' . base_url("index.php/eci/schedule_c/delete_activity") . '/' . $isi->CHR_ID_ECI . '/' . $isi->INT_ID_ECI_LINE . '"class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm("Are you sure want to delete this activity?");"><span class="fa fa-times"></span></a>';
            $data .= '</td>
				</tr>';
            $i++;
        }
        $data .= '</tbody>
			</table>
			';
        echo $data;
    }

    function check_id($id) {
        $this->role_module_m->authorization('146');
        $return_value = $this->eci_h_m->check_id($id);
        if ($return_value) {
            $this->form_validationform_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function activity_project($msg = NULL, $eci = NULL) {
        $this->log_m->add_log(24, NULL);
        $this->form_validation->set_rules('txtsequence', 'Txtsequence', 'required|numeric|xss_clean|min_length[3]');
        $this->role_module_m->authorization('59');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-success'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data already published !</strong> Notification sent to PIC </div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data has been revise !</strong> Now you can update activity project </div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>ECI not choose !</strong> Please select the Eci number </div >";
        }else {
            $msg = "";
        }

        $data['eci_id'] = trim($eci);
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(59);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Add Activity Project';
        $data['msg'] = $msg;
        $data['data_category'] = $this->category_m->find_trans("*", "INT_ID_CATEGORY<>0", "CHR_CATEGORY_NAME");
        $data['data_activity'] = $this->activity_m->get_data_activity();
        $data['data_user'] = $this->pic_m->get_data_pic_user();
        $data['data_pic'] = $this->pic_m->get_data_pic();
        $data['data_pic_dept'] = $this->pic_m->get_data_dept_pic();
        $data['data_eci'] = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0 AND CHR_FLG_DELETE=0", "CHR_ID_ECI, INT_REV");
        $data['data'] = $this->eci_l_m->find_trans("*", "CHR_ID_ECI<>0 AND CHR_ID_ECI=" . $eci . "", "CHR_ID_ECI, INT_REV, INT_SEQ");
        $data['content'] = 'eci/schedule/activity_project_v';
        $this->load->view($this->layout, $data);
    }

    function list_eci($msg = NULL) {
        $this->log_m->add_log(28, NULL);
        $this->role_module_m->authorization('147');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(147);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'List ECI';
        $data['msg'] = $msg;
        if ($this->session->userdata("ROLE") == 12) {
            $data['data'] = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0 AND CHR_FLG_DELETE=0 AND CHR_FLG_PUBLISH=1 ORDER BY CHR_DATE_ENTRY DESC");
        } else {
            $data['data'] = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0 AND CHR_FLG_DELETE=0 AND CHR_FLG_PUBLISH=1 ORDER BY CHR_DATE_ENTRY DESC");
        }

        $data['content'] = 'eci/schedule/eci_list_v';
        $data['hariini'] = date('d-M-Y');
        $eci_h = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0 AND CHR_FLG_DELETE=0 AND CHR_FLG_PUBLISH=1 ORDER BY CHR_DATE_ENTRY DESC");
        foreach ($eci_h as $rows) {

            $get_data = $this->eci_l_m->find_trans_d("*", "CHR_ID_ECI = '" . $rows->CHR_ID_ECI . "' AND CHR_FLG_PUBLISH='1' AND CHR_FLG_ATTTACH =NULL", "INT_SEQ ASC");

            foreach ($get_data as $row) {
                $end_date = date('Ymd', strtotime($row->CHR_DUE_DATE));
                $date_now = date('Ymd');

                $where = "CHR_ID_ECI = '" . $row->CHR_ID_ECI . "' AND INT_ID_ACTIVITY = '" . $row->INT_ID_ACTIVITY . "'";
                if ($date_now > $end_date) {
                    $data2 = array(
                        'INT_STATUS_COLOR' => 4 //Status 4 = Delay
                    );

                    $this->eci_l_m->update_trans_l($data2, $where);
                }
            }
        }

        $this->load->view($this->layout, $data);
    }



    function list_eci_second($msg = NULL) {
        $this->log_m->add_log(28, NULL);
        $this->role_module_m->authorization('147');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(147);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'List ECI';
        $data['msg'] = $msg;
        if ($this->session->userdata("ROLE") == 12) {
            $data['data'] = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0 AND CHR_FLG_DELETE=0 AND CHR_FLG_PUBLISH=1", "CHR_ID_ECI DESC");
        } else {
            $data['data'] = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0 AND CHR_FLG_DELETE=0 AND CHR_FLG_PUBLISH=1", "CHR_ID_ECI DESC");
        }

        $data['content'] = 'eci/schedule/eci_list_v_second';
        $data['hariini'] = date('d-M-Y');
        $eci_h = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0 AND CHR_FLG_DELETE=0 AND CHR_FLG_PUBLISH=1", "CHR_ID_ECI DESC");
        foreach ($eci_h as $rows) {

            $get_data = $this->eci_l_m->find_trans_d("*", "CHR_ID_ECI = '" . $rows->CHR_ID_ECI . "' AND CHR_FLG_PUBLISH='1' AND CHR_FLG_ATTTACH = 0", "INT_SEQ ASC");

            foreach ($get_data as $row) {
                $end_date = date('Ymd', strtotime($row->CHR_DUE_DATE));
                $date_now = date('Ymd');

                $where = "CHR_ID_ECI = '" . $row->CHR_ID_ECI . "' AND INT_ID_ACTIVITY = '" . $row->INT_ID_ACTIVITY . "'";
                if ($date_now > $end_date) {
                    $data2 = array(
                        'INT_STATUS_COLOR' => 4 //Status 4 = Delay
                    );

                    $this->eci_l_m->update_trans_l($data2, $where);
                }
            }
        }

        $this->load->view($this->layout, $data);
    }

    function list_activity() {
        $this->role_module_m->authorization('146');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(146);
        $data['title'] = 'Feedback Admin';
        $data['msg'] = $msg;

        //$data['data'] = $this->eci_l_m->get_feedback_data();
        $data['data'] = $this->eci_l_m->get_list_activity_data();

        $data['content'] = 'eci/schedule/list_activity_v';

        $this->load->view($this->layout, $data);
    }

    function delay_job($msg = NULL) {
        $this->log_m->add_log(26, NULL);
        $this->role_module_m->authorization('70');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(70);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['datenow'] = date('Ymd');
        $data['title'] = 'View Delay Job';
        $project = $this->db->query("select b.CHR_ID_ECI, b.INT_ID_ECI_LINE, b.FLT_PROGRESS, a.CHR_NAME, a.CHR_CATEGORY_NAME, a.CHR_CUSTOMER, a.CHR_FG_PARTNAME, a.CHR_VEHICLE, b.CHR_PIC_NAME,
			a.CHR_CONTENT, b.CHR_ACTIVITY_NAME, b.CHR_PIC_DEPT, b.INT_REV, b.CHR_START_DATE, b.CHR_DUE_DATE, b.INT_ID_ACTIVITY, b.CHR_DATE_START, b.CHR_TIME_START, b.INT_STATUS_COLOR
			from TT_ECI_H a, TT_ECI_L b 
			where b.CHR_FLG_PUBLISH = '1'
			and b.CHR_FLG_ACTIVE = '1'
                        and b.CHR_DUE_DATE <= CONVERT(char(10), DATEADD(day,0,GetDate()),112)
			and a.CHR_ID_ECI = b.CHR_ID_ECI ORDER BY CHR_DATE_START desc;")->result();
        $data['data'] = $project;
        $data['content'] = 'eci/schedule/delay_job_v';

        $this->load->view($this->layout, $data);
    }

    function view_project($msg = NULL) {
        $this->log_m->add_log(25, NULL);
        $this->role_module_m->authorization('68');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Give feedback success</strong> The Feedback successfully send </div >";
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(68);
        $data['news'] = $this->news_m->get_news();

        $data['msg'] = $msg;
        $npk = $this->session->userdata("NPK");
        $project = $this->db->query("select b.CHR_ID_ECI, b.INT_ID_ECI_LINE, b.FLT_PROGRESS, a.CHR_NAME, a.CHR_CATEGORY_NAME, a.CHR_CUSTOMER, a.CHR_FG_PARTNAME, a.CHR_VEHICLE,
			a.CHR_CONTENT, b.CHR_FLG_ATTTACH, b.INT_FLG_REJECTED, c.INT_FEEDBACK, b.CHR_ACTIVITY_NAME, b.INT_REV, b.CHR_START_DATE, b.CHR_DUE_DATE, b.INT_ID_ACTIVITY, b.CHR_DATE_START, b.CHR_TIME_START
                        from TT_ECI_H a 
                        INNER JOIN TT_ECI_L b ON a.CHR_ID_ECI = b.CHR_ID_ECI 
                        LEFT JOIN TT_ECI_FEEDBACK c ON a.CHR_ID_ECI = b.CHR_ID_ECI AND a.CHR_ID_ECI = c.CHR_ID_ECI and c.INT_ID_ACTIVITY = b.INT_ID_ACTIVITY 
                                                where b.CHR_PIC_NPK = '$npk'
                                                and b.CHR_FLG_PUBLISH = '1'
                                                and b.CHR_FLG_ACTIVE = '1'
                        ORDER BY b.CHR_START_DATE DESC")->result();

        $session = $this->session->all_userdata();
        if ($session['ROLE'] == '1' || $session['ROLE'] == '12') {
            $data['title'] = 'View Project Admin';
            $data['data'] = $project;
            $data['content'] = 'eci/schedule/view_project_by_admin_v';
        } else {
            $data['title'] = 'View Project';
            $data['data'] = $project;
            $data['content'] = 'eci/schedule/view_project_v';
        }

        $this->load->view($this->layout, $data);
    }

    function view_project_notif($id_notif, $ideci, $id_act) {
        $this->role_module_m->authorization('68');

        $this->notification_m->has_be_read($id_notif);

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(68);
        $data['news'] = $this->news_m->get_news();

        $data['msg'] = "";
        $npk = $this->session->userdata("NPK");

        $project = $this->db->query("select b.CHR_ID_ECI, b.INT_ID_ECI_LINE, b.FLT_PROGRESS, a.CHR_NAME, a.CHR_CATEGORY_NAME, a.CHR_CUSTOMER, a.CHR_FG_PARTNAME, a.CHR_VEHICLE,
			a.CHR_CONTENT, b.CHR_FLG_ATTTACH, b.INT_FLG_REJECTED, c.INT_FEEDBACK, b.CHR_ACTIVITY_NAME, b.INT_REV, b.CHR_START_DATE, b.CHR_DUE_DATE, b.INT_ID_ACTIVITY, b.CHR_DATE_START, b.CHR_TIME_START
			from TT_ECI_H a 
                        INNER JOIN TT_ECI_L b ON a.CHR_ID_ECI = b.CHR_ID_ECI 
                        LEFT JOIN TT_ECI_FEEDBACK c ON a.CHR_ID_ECI = b.CHR_ID_ECI AND a.CHR_ID_ECI = c.CHR_ID_ECI and c.INT_ID_ACTIVITY = b.INT_ID_ACTIVITY 
			where b.CHR_PIC_NPK = '$npk'
			and b.INT_ID_ACTIVITY = $id_act
			and b.CHR_ID_ECI = $ideci
			and b.CHR_FLG_PUBLISH = '1'
			and b.CHR_FLG_ACTIVE = '1'
			ORDER BY b.CHR_START_DATE DESC ;")->result();

        $session = $this->session->all_userdata();
        if ($session['ROLE'] == '1' || $session['ROLE'] == '12') {
            $data['title'] = 'View Project Admin';
            $data['data'] = $project;
            $data['content'] = 'eci/schedule/view_project_by_admin_v';
        } else {
            $data['title'] = 'View Project';
            $data['data'] = $project;
            $data['content'] = 'eci/schedule/view_project_v';
        }

        $this->load->view($this->layout, $data);
    }

    function save_activity() {
        $this->role_module_m->authorization('146');

        $id_eci = trim($this->input->post('project_n'));
        $id_activity = $this->input->post('activity');
        $id_pic = $this->input->post('pic');
        $duration = $this->input->post('due_date') - $this->input->post('start_date');
        $sequence = $this->input->post('txtsequence');
        

        if ($id_eci == null) {
            redirect("eci/schedule_c/activity_project/6/NULL");
        } else {
            $result_eci = $this->eci_h_m->get_eci_h_by_id($id_eci);
            $result_act = $this->activity_m->get_activity_by_id($id_activity);
            $result_pic = $this->pic_m->get_pic_by_id($id_pic);
        }

        $int_rev = $result_eci->INT_REV;
        $activity_name = $result_act->CHR_ACTIVITY_NAME;
        $pic_npk = $result_pic->CHR_NPK;
        $pic_name = $result_pic->CHR_NAME;
        $pic_mail = $result_pic->CHR_EMAIL;
        $pic_superior = $result_pic->CHR_NAME_SUPERIOR;
        $pic_sup_mail = $result_pic->CHR_EMAIL_SUPERIOR;
        $pic_dept = $result_pic->CHR_DEPT;
        $session = $this->session->all_userdata();

        if ($this->eci_l_m->check_id_line($id_eci) == '0') {
            $id_line = 1;
        } else {
            $id_line = $this->eci_l_m->generate_id_line($id_eci);
        }


        $data = array(
            'CHR_ID_ECI' => $id_eci,
            'INT_ID_ECI_LINE' => $id_line,
            'INT_REV' => $int_rev,
            'INT_ID_ACTIVITY' => $id_activity,
            'CHR_ACTIVITY_NAME' => $activity_name,
            'INT_DURATION' => $duration,
            'INT_SEQ' => $sequence,
            'CHR_START_DATE' => date("Ymd", strtotime($this->input->post('start_date'))),
            'CHR_DUE_DATE' => date("Ymd", strtotime($this->input->post('due_date'))),
            'CHR_PIC_NPK' => $pic_npk,
            'CHR_PIC_NAME' => $pic_name,
            'CHR_PIC_MAIL' => $pic_mail,
            'CHR_PIC_SUPERIOR' => $pic_superior,
            'CHR_PIC_SUPERIOR_MAIL' => $pic_sup_mail,
            'CHR_PIC_DEPT' => $pic_dept,
            'CHR_FLG_PUBLISH' => "0",
            'CHR_USR_ENTRY' => $session['NPK'],
            'CHR_DATE_ENTRY' => date('Ymd'),
            'CHR_TIME_ENTRY' => date('his'),
            'INT_STATUS_COLOR' => 1 //Status 1 = Ready to start
        );

        $this->eci_l_m->add_trans($data);
        $this->eci_l_m->update_sequence($id_eci);

        redirect("eci/schedule_c/activity_project/1/$id_eci");
    }

    function publish_activity() {
        $id_eci = trim($this->input->post('id_eci'));
        $session = $this->session->all_userdata();

        $result_eci = $this->eci_l_m->find_trans_d("*", "CHR_ID_ECI = $id_eci AND CHR_FLG_PUBLISH='0'", "INT_SEQ ASC");

        foreach ($result_eci as $row) {
            $id_activity = trim($row->INT_ID_ACTIVITY);
            $seq_id = $this->notification_m->generate_id();

            $data_notif = array(
                'INT_ID_NOTIF' => $seq_id,
                'CHR_NPK' => $row->CHR_PIC_NPK,
                'INT_ID_APP' => '10',
                'CHR_NOTIF_TITLE' => 'New ECI' . trim($row->CHR_ACTIVITY_NAME),
                'CHR_NOTIF_DESC' => "Publish ECI " . trim($row->CHR_ACTIVITY_NAME),
                'CHR_LINK' => "eci/schedule_c/view_project_notif/$seq_id/$id_eci/$id_activity",
                'CHR_CREATED_BY' => $session['USERNAME'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His')
            );

            $this->notification_m->insert_notification($data_notif);
        }

        $data = array(
            'CHR_FLG_PUBLISH' => "1",
        );
        $data2 = array(
            'CHR_FLG_PUBLISH' => "1",
        );

        $this->eci_h_m->update_trans_h($data, "CHR_ID_ECI = " . $id_eci . "");
        $this->eci_l_m->update_publish($data2, "CHR_ID_ECI = " . $id_eci . "");

        //email_sent("sudirmanhafidz1@gmail.com", "test cc", "subject test", "mencoba baru");

        redirect("eci/schedule_c/activity_project/4/$id_eci");
    }

    function notif_click($id_notif, $id_app) {
        $this->db->query("UPDATE TT_PORTAL_NOTIFICATION SET CHR_FLG_READ='1' WHERE  INT_ID_NOTIF=$id_notif AND INT_ID_APP = $id_app");

        redirect("eci/schedule_c/view_project");
    }

    function revise_activity() {
//        $id_eci = trim($this->input->post('id_eci'));project_n_1
        $id_eci = trim($this->input->post('project_n_1'));
        $result_eci_h = $this->db->query("select * from TT_ECI_H where CHR_ID_ECI = '$id_eci' order by CHR_ID_ECI desc")->row();
        $int_rev_h = $result_eci_h->INT_REV + 1;
        $this->db->query("UPDATE TT_ECI_L SET CHR_FLG_PUBLISH='0' WHERE  CHR_ID_ECI='$id_eci' ;");
        $this->db->query("UPDATE TT_ECI_H SET CHR_FLG_PUBLISH='0', INT_REV=$int_rev_h WHERE  CHR_ID_ECI='$id_eci' ;");

        redirect("eci/schedule_c/activity_project/5/$id_eci");
    }

    function delete_activity($id, $line) {
        $id_eci = trim($id);
        $this->role_module_m->authorization('146');
        $this->eci_l_m->delete_activity($id_eci, $line);
        $this->eci_l_m->update_sequence($id_eci);

        redirect("eci/schedule_c/activity_project/3/$id_eci");
    }

    function save_revise_activity() {
        $this->role_module_m->authorization('146');

        $id_eci = trim($this->input->post('project_n_1'));
        $id_activity = $this->input->post('activity');
        $id_pic = $this->input->post('pic');
        $sequence = $this->input->post('txtsequence');
        $duration = $this->input->post('due_date') - $this->input->post('start_date');

        $result_eci = $this->db->query("select * from TT_ECI_H where CHR_ID_ECI = $id_eci")->row();
        $result_eci_l = $this->db->query("select * from TT_ECI_l where CHR_ID_ECI = $id_eci")->row();
        $result_act = $this->db->query("select * from TM_ECI_ACTIVITY where INT_ID_ACTIVITY = $id_activity")->row();
        $result_pic = $this->db->query("select * from TM_ECI_PIC where INT_ID_PIC = $id_pic")->row();

        $int_rev = $result_eci->INT_REV;
        $int_rev2 = $result_eci_l->INT_REV;
        $activity_name = $result_act->CHR_ACTIVITY_NAME;
        $pic_npk = $result_pic->CHR_NPK;
        $pic_name = $result_pic->CHR_NAME;
        $pic_mail = $result_pic->CHR_EMAIL;
        $pic_superior = $result_pic->CHR_NAME_SUPERIOR;
        $pic_sup_mail = $result_pic->CHR_EMAIL_SUPERIOR;
        $pic_dept = $result_pic->CHR_DEPT;
        $session = $this->session->all_userdata();

        if ($this->eci_l_m->check_id_line($id_eci) == '0') {
            $id_line = 1;
        } else {
            $id_line = $this->eci_l_m->generate_id_line($id_eci);
        }

        $data = array(
            'CHR_ID_ECI' => $id_eci,
            'INT_ID_ECI_LINE' => $id_line,
            'INT_ID_ACTIVITY' => $id_activity,
            'CHR_ACTIVITY_NAME' => $activity_name,
            'INT_REV' => 0,
            'INT_DURATION' => $duration,
            'INT_SEQ' => $sequence,
            'CHR_START_DATE' => date("Ymd", strtotime($this->input->post('start_date'))),
            'CHR_DUE_DATE' => date("Ymd", strtotime($this->input->post('due_date'))),
            'CHR_PIC_NPK' => $pic_npk,
            'CHR_PIC_NAME' => $pic_name,
            'CHR_PIC_MAIL' => $pic_mail,
            'CHR_PIC_SUPERIOR' => $pic_superior,
            'CHR_PIC_SUPERIOR_MAIL' => $pic_sup_mail,
            'CHR_PIC_DEPT' => $pic_dept,
            'CHR_FLG_PUBLISH' => "0", //diubah jadi 
            'CHR_USR_ENTRY' => $session['NPK'],
            'CHR_DATE_ENTRY' => date('Ymd'),
            'CHR_TIME_ENTRY' => date('his'),
            'INT_STATUS_COLOR' => 1
        );

        $this->eci_l_m->add_trans($data);
        redirect("eci/schedule_c/activity_project/2/$id_eci");
    }

    function deactivate_activity($id, $line) {
        $this->role_module_m->authorization('146');
        $id_eci = trim($id);
        $this->eci_l_m->deactivate_activity($id_eci, $line);
        redirect("eci/schedule_c/activity_project/3/$id_eci");
    }

     function get_detil_eci() {
        $data = "";
        $date11 = date('Ymd');
        $id_eci = $this->input->post("id_activity");
        $id_eci = trim($id_eci);

       // $get_data = $this->eci_l_m->find_trans_d("*", "CHR_ID_ECI = '" . $id_eci . "' AND CHR_FLG_PUBLISH='1'", "INT_SEQ ASC");
        $get_data = $this->eci_l_m->get_list_data_eci($id_eci);
        
        $def = 1;
        $json_response = array();

        foreach ($get_data as $row) {
            $end_date = date('Ymd', strtotime($row->CHR_DUE_DATE));
            $row_array['id'] = trim($row->INT_ID_ACTIVITY) . " - " . $def;
            $row_array['start_date'] = substr($row->CHR_START_DATE, 0, 4) . "-" . substr($row->CHR_START_DATE, 4, 2) . "-" . substr($row->CHR_START_DATE, 6, 2) . " 00:00:00";
            $row_array['end_date'] = substr($end_date, 0, 4) . "-" . substr($end_date, 4, 2) . "-" . substr($end_date, 6, 2) . " 00:00:00";
            $row_array['due'] = trim($row->CHR_DUE_DATE);
            $row_array['text'] = trim($row->CHR_ACTIVITY_NAME);
            $row_array['dept'] = trim($row->CHR_PIC_DEPT);
            $row_array['no'] = $def;
            $row_array['color'] = trim($row->INT_STATUS_COLOR);
            $row_array['publish'] = trim($row->CHR_FLG_PUBLISH);
            $row_array['flt_prog'] = trim($row->FLT_PROGRESS);
            $row_array[''] = trim($row->CHR_FLG_PUBLISH);
            $row_array['pic'] = trim($row->CHR_PIC_NAME);
            $row_array['parent'] = trim($row->CHR_ID_DEPENDEN);
            $row_array['open'] = true;
            if ($row_array['start_date'] == NULL) {
                $row_array['status'] = "green";
            }
            $def = $def + 1;
            array_push($json_response, $row_array);
        }

        $md_array["data"] = $json_response;

        echo json_encode($md_array);
    }

    function detail_eci_2() {
        $data = "";
        $date11 = date('Ymd');
        $id_eci = $this->input->post("id_activity");
        $id_eci = trim($id_eci);
        //$id_eci = '7';

       // $get_data = $this->eci_l_m->find_trans_d("*", "CHR_ID_ECI = '" . $id_eci . "' AND CHR_FLG_PUBLISH='1'", "INT_SEQ ASC");
        $get_data = $this->eci_l_m->get_list_data_eci($id_eci);
        
        $def = 1;
        $json_response = array();

        foreach ($get_data as $row) {
            $end_date = date('Ymd', strtotime($row->CHR_DUE_DATE));
            $date_first = substr($row->CHR_START_DATE, 0, 4) . "-" . substr($row->CHR_START_DATE, 4, 2) . "-" . substr($row->CHR_START_DATE, 6, 2);
            $date_second = substr($end_date, 0, 4) . "-" . substr($end_date, 4, 2) . "-" . substr($end_date, 6, 2);
            $dateOne = new DateTime($date_first);
            $dateTwo = new DateTime($date_second);

            $diff = $dateTwo->diff($dateOne)->format("%a");
            
            $row_array['id'] = $row->INT_ID_ECI_LINE;//trim($row->INT_ID_ACTIVITY) . " - " . $def;
            $row_array['activity_id'] = trim($row->INT_ID_ACTIVITY);
            $row_array['eci_id'] = $id_eci;
            $row_array['start_date'] = substr($row->CHR_START_DATE, 0, 4) . "-" . substr($row->CHR_START_DATE, 4, 2) . "-" . substr($row->CHR_START_DATE, 6, 2) . " 00:00:00";
            $row_array['end_date'] = substr($end_date, 0, 4) . "-" . substr($end_date, 4, 2) . "-" . substr($end_date, 6, 2) . " 00:00:00";
            $row_array['due'] = trim($row->CHR_DUE_DATE);
            $row_array['duration'] = $diff;
            $row_array['open'] = true;
            $row_array['priority'] = '2';
            $row_array['text'] = utf8_encode(trim($row->CHR_ACTIVITY_NAME));
            $row_array['dept'] = trim($row->CHR_PIC_DEPT);
            if(trim($row->CHR_ID_DEPENDEN)=='0')
            {
                $row_array['no'] = trim($row->INT_SEQ);
            }
            else
            {
                $get_no = $this->eci_l_m->get_data_no_list($id_eci,trim($row->CHR_ID_DEPENDEN));
                $get_root_parent = $this->eci_l_m->get_data_root_parent($id_eci,trim($row->CHR_ID_DEPENDEN));
                if(trim($get_root_parent[0]->CHR_ID_DEPENDEN)=='0')
                {
                    $row_array['no'] = trim($get_no) . '.' . trim($row->INT_SEQ);
                }
                else
                {
                    $get_no_2 = $this->eci_l_m->get_data_no_list($id_eci,trim($get_root_parent[0]->CHR_ID_DEPENDEN));
                    $row_array['no'] = trim($get_no_2) . '.' . trim($get_no).'.'.trim($row->INT_SEQ);
                }
            }
            $row_array['color'] = trim($row->INT_STATUS_COLOR);
            $row_array['sequence'] = trim($row->INT_SEQ);
            $row_array['publish'] = trim($row->CHR_FLG_PUBLISH);
            $row_array['progress'] = trim($row->FLT_PROGRESS);
            $row_array[''] = trim($row->CHR_FLG_PUBLISH);
            $row_array['pic'] = trim($row->CHR_PIC_NAME);
            $row_array['parent'] = trim($row->CHR_ID_DEPENDEN);
            $row_array['open'] = true;
            if(is_null($row->CHR_INFORMATION))
            {
                $row_array['info'] = "";
                $row_array['information'] = "";
            }
            else 
            {
                //$row_array['info'] =implode(' ', array_slice(explode(' ', $row->CHR_INFORMATION), 0, 5)) . '...';
                if(strlen($row->CHR_INFORMATION)>25)
                {
                    $row_array['info'] = substr($row->CHR_INFORMATION, 0, 25) . '...';
                }
                else
                {
                    $row_array['info'] = $row->CHR_INFORMATION;
                }
                //$row_array['info'] = substr($row->CHR_INFORMATION, 0, 25) . '...';

                $row_array['information'] = $row->CHR_INFORMATION;
            }
            if ($row_array['start_date'] == NULL) {
                $row_array['status'] = "green";
            }
            $def = $def + 1;
            array_push($json_response, $row_array);
        }


        $md_array["data"] = $json_response;

        echo json_encode($md_array);
    }

    function update_progress(){
         $id_eci = $this->input->post("id_eci");
         $id_activity = $this->input->post("id_activity");
         $progress = $this->input->post("progress");

         $where = "CHR_ID_ECI = '" . $id_eci . "' AND INT_ID_ACTIVITY = '" . $id_activity . "'";
                    $data = array(
                        'FLT_PROGRESS' => $progress
                    );

        $this->eci_l_m->update_trans_l($data, $where);
                

    }

    function add_activity(){
        //$this->role_module_m->authorization('146');
        $id_eci = $this->input->post("id_eci");
        $id_activity = $this->input->post("id_activity");
        $id_pic = $this->input->post("pic");
        $duration = $this->input->post("due_date") - $this->input->post("start_date");
        $sequence = $this->input->post("txtsequence");
        $result_eci = $this->eci_h_m->get_eci_h_by_id($id_eci);
        $result_act = $this->activity_m->get_activity_by_id($id_activity);
        $result_pic = $this->pic_m->get_pic_by_id($id_pic);
        $parent = $this->input->post('parent');
        $information = $this->input->post('information');

            

        $int_rev = $result_eci->INT_REV;
        $activity_name = $result_act->CHR_ACTIVITY_NAME;
        $pic_npk = $result_pic->CHR_NPK;
        $pic_name = $result_pic->CHR_NAME;
        $pic_mail = $result_pic->CHR_EMAIL;
        $pic_superior = $result_pic->CHR_NAME_SUPERIOR;
        $pic_sup_mail = $result_pic->CHR_EMAIL_SUPERIOR;
        $pic_dept = $result_pic->CHR_DEPT;
        $session = $this->session->all_userdata();

        if ($this->eci_l_m->check_id_line($id_eci) == '0') {
            $id_line = 1;
        } else {
            $id_line = $this->eci_l_m->generate_id_line($id_eci);
        }


        $data = array(
            'CHR_ID_ECI' => $id_eci,
            'INT_ID_ECI_LINE' => $id_line,
            'INT_REV' => $int_rev,
            'INT_ID_ACTIVITY' => $id_activity,
            'CHR_ACTIVITY_NAME' => $activity_name,
            'INT_DURATION' => $duration,
            'INT_SEQ' => $sequence,
            'CHR_START_DATE' => date("Ymd", strtotime($this->input->post('start_date'))),
            'CHR_DUE_DATE' => date("Ymd", strtotime($this->input->post('due_date'))),
            'CHR_PIC_NPK' => $pic_npk,
            'CHR_PIC_NAME' => $pic_name,
            'CHR_PIC_MAIL' => $pic_mail,
            'CHR_PIC_SUPERIOR' => $pic_superior,
            'CHR_PIC_SUPERIOR_MAIL' => $pic_sup_mail,
            'CHR_PIC_DEPT' => $pic_dept,
            'CHR_FLG_PUBLISH' => "1",
            'CHR_USR_ENTRY' => $session['NPK'],
            'CHR_DATE_ENTRY' => date('Ymd'),
            'CHR_TIME_ENTRY' => date('his'),
            'CHR_ID_DEPENDEN' => $parent,
            'INT_STATUS_COLOR' => 1, //Status 1 = Ready to start
            'CHR_INFORMATION' => $information
        );

        $this->eci_l_m->add_trans($data);
        //$this->eci_l_m->update_sequence($id_eci);

        //redirect("eci/schedule_c/activity_project/1/$id_eci");          
    }

    function update_activity()
    {
        //$this->role_module_m->authorization('146');
        
        $id_eci = $this->input->post("id_eci");
        $id_activity = $this->input->post("id_activity");
        $line = $this->input->post('id_task');
        $id_pic = $this->input->post('pic');
        $int_seq = $this->input->post('txtsequence');
        $duration = $this->input->post('due_date') - $this->input->post('start_date');
        $information = $this->input->post('information');


        $result_eci = $this->eci_h_m->get_eci_h_by_id($id_eci);
        $result_act = $this->activity_m->get_activity_by_id($id_activity);
        $result_pic = $this->pic_m->get_pic_by_id($id_pic);

        $int_rev = $result_eci->INT_REV;
        $activity_name = $result_act->CHR_ACTIVITY_NAME;
        $pic_npk = $result_pic->CHR_NPK;
        $pic_name = $result_pic->CHR_NAME;
        $pic_mail = $result_pic->CHR_EMAIL;
        $pic_superior = $result_pic->CHR_NAME_SUPERIOR;
        $pic_sup_mail = $result_pic->CHR_EMAIL_SUPERIOR;
        $pic_dept = $result_pic->CHR_DEPT;
        $session = $this->session->all_userdata();
        $start_date = date("Ymd", strtotime($this->input->post('start_date')));
        $due_date = date("Ymd", strtotime($this->input->post('due_date')));

        $data = array(
            'INT_REV' => $int_rev,
            'INT_ID_ACTIVITY' => $id_activity,
            'CHR_ACTIVITY_NAME' => $activity_name,
            'INT_DURATION' => $duration,
            'CHR_START_DATE' => $start_date,
            'CHR_DUE_DATE' => $due_date,
            'INT_SEQ' => $int_seq,
            'CHR_PIC_NPK' => $pic_npk,
            'CHR_PIC_NAME' => $pic_name,
            'CHR_PIC_MAIL' => $pic_mail,
            'CHR_PIC_SUPERIOR' => $pic_superior,
            'CHR_PIC_SUPERIOR_MAIL' => $pic_sup_mail,
            'CHR_PIC_DEPT' => $pic_dept,
            'CHR_USR_UPDATE' => $session['NPK'],
            'CHR_DATE_UPDATE' => date('Ymd'),
            'CHR_TIME_UPDATE' => date('his'),
            'CHR_INFORMATION' => $information
        );

        $id_update = array(
            'CHR_ID_ECI' => $id_eci,
            'INT_ID_ECI_LINE' => $line,
        );

        $this->eci_l_m->edit_activity($data, $id_update);
        //$this->eci_l_m->update_sequence($id_eci);

        //redirect("eci/schedule_c/activity_project/2/$id_eci");
    }

     function remove_activity() {
        $id_eci = $this->input->post("id_eci");
        $id_task = $this->input->post("id_task");
        $parent = $this->input->post('parent');
        //$this->role_module_m->authorization('146');
        if($parent == 0 or is_null($parent))
        {
            $this->eci_l_m->delete_activity_child($id_eci, $id_task);
            $this->eci_l_m->delete_activity($id_eci, $id_task);
        }
        else
        {
            $this->eci_l_m->delete_activity($id_eci, $id_task);
        }
        //$this->eci_l_m->update_sequence($id_eci);

        //redirect("eci/schedule_c/activity_project/3/$id_eci");
    }

    function test_sp_eci($eci_id)
    {
        $this->eci_l_m->update_sequence($eci_id);
    }

    function detail_eci($id) {
        $data = "";
        $lock_role = 1;
        $date11 = date('Ymd');
        $id_eci = $id;
        $id_eci = trim($id_eci);
        $data['data_pic'] = $this->pic_m->get_data_pic();
        $data['data_pic_dept'] = $this->pic_m->get_data_dept_pic();
        $data['data_activity'] = $this->activity_m->get_data_activity();
        $result_eci = $this->eci_h_m->get_eci_h_by_id($id_eci);
        if(trim($result_eci->INT_TYPE) == "NEW PROJECT")
        {
            $data['eci_content'] = "New Project";
        }
        else
        {
            $data['eci_content'] = $result_eci->CHR_CONTENT;
        }
        $data['eci_model'] = $result_eci->CHR_VEHICLE;
        $data['eci_customer'] = $result_eci->CHR_CUSTOMER;
        $data['eci_category'] = utf8_encode($result_eci->CHR_CATEGORY_NAME);
        $data['eci_number'] = $result_eci->CHR_NAME;
        $data['eci_start_date'] = date("Y-m-d", strtotime($result_eci->CHR_START_DATE));
        $data['eci_end_date'] = date("Y-m-d", strtotime($result_eci->CHR_DUE_DATE));
        $data['eci_cust_date'] = date("Y-m-d", strtotime($result_eci->CHR_CUST_REQ_DATE));

       // $get_data = $this->eci_l_m->find_trans_d("*", "CHR_ID_ECI = '" . $id_eci . "' AND CHR_FLG_PUBLISH='1'", "INT_SEQ ASC");
        $get_data = $this->eci_l_m->get_list_data_eci($id_eci);
        $data['content'] = $id_eci;
        $role_user = $this->session->userdata("ROLE");
        $rm = $this->role_module_m->check_auth($role_user, '59');
        //print_r($rm);die();
        if (count($rm) == 0) {
            //redirect("fail_c/auth");
            $lock_role = 0;
        }
        $data['lock_role'] = $lock_role;
        $data['role'] = $role_user;
        $this->load->view('eci/schedule/eci_list_detail_v', $data);
    }

    function feedback_eci_user($id_eci, $rev, $id_activity, $msg = null) {
        $this->role_module_m->authorization('68');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }
        $npk_created = TRIM($this->session->userdata("NPK"));
        $get_eci_h = $this->db->query("select * from TT_ECI_H where CHR_ID_ECI ='$id_eci' ")->row();
        $get_eci_l = $this->db->query("select * from TT_ECI_L where CHR_ID_ECI ='$id_eci' and INT_ID_ACTIVITY = '$id_activity' ")->row();
        $get_feed_back = $this->db->query("select * from TT_ECI_FEEDBACK where TT_ECI_FEEDBACK.CHR_ID_ECI = '$id_eci' and TT_ECI_FEEDBACK.INT_ID_ACTIVITY = '$id_activity'")->result();
        $eci_activity = $get_eci_l->CHR_ACTIVITY_NAME;
        $npk_activity = TRIM($get_eci_l->CHR_PIC_NPK);

        $data['get_eci_h'] = $get_eci_h;
        $data['get_eci_l'] = $get_eci_l;
        $data['get_feed_back'] = $get_feed_back;
        $data['npk_activity'] = $npk_activity;
        $data['npk_created'] = $npk_created;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(68);

        $data['eci_activity'] = $eci_activity;
        $data['eci_id'] = $id_eci;
        $data['title'] = 'Project Feedback User';
        $data['msg'] = $msg;

        $data['data'] = $get_feed_back;

        $data['content'] = 'eci/schedule/feedback_eci_v';

        $this->load->view($this->layout, $data);
    }

    function feedback_eci($id_eci, $rev, $id_activity, $msg = null) {
        $this->role_module_m->authorization('68');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Upload Failed </strong> Please select file first before give feedback </div >";
        } else {
            $msg = "";
        }
        $npk_created = TRIM($this->session->userdata("NPK"));
        $get_eci_h = $this->db->query("select * from TT_ECI_H where CHR_ID_ECI ='$id_eci'")->row();
        $get_eci_l = $this->db->query("select * from TT_ECI_L where CHR_ID_ECI ='$id_eci' and INT_ID_ACTIVITY = '$id_activity' ")->row();
        $get_feed_back = $this->db->query("select * from TT_ECI_FEEDBACK where TT_ECI_FEEDBACK.CHR_ID_ECI = '$id_eci' and TT_ECI_FEEDBACK.INT_ID_ACTIVITY = '$id_activity'")->result();
        $eci_activity = $get_eci_l->CHR_ACTIVITY_NAME;
        $npk_activity = TRIM($get_eci_l->CHR_PIC_NPK);

        $data['get_eci_h'] = $get_eci_h;
        $data['get_eci_l'] = $get_eci_l;
        $data['get_feed_back'] = $get_feed_back;
        $data['npk_activity'] = $npk_activity;
        $data['npk_created'] = $npk_created;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(68);

        $data['eci_activity'] = $eci_activity;
        $data['eci_id'] = $id_eci;
        $data['title'] = 'Project Feedback Admin';
        $data['msg'] = $msg;

        $data['data'] = $get_feed_back;

        $data['content'] = 'eci/schedule/feedback_eci_v';

        $this->load->view($this->layout, $data);
    }

    function upload_data() {
        $this->load->library('upload');

        $npk_created = $this->session->userdata("NPK");
        $date = date("Ymd");
        $time = date("His");
        $url = $_SERVER['HTTP_REFERER'];
        $title = $this->input->post("title");
        $comment = $this->input->post("comment");
        $jum_file = $this->input->post("jum_file");
        $id_eci = $this->input->post("id_eci");
        $rev = $this->input->post("rev");
        $id_activity = $this->input->post("id_activity");

        $no_feedback = 1;
        $num_fb = $this->eci_feedback_m->check_feedback_by_ecid_activity_and_revise($id_eci, $rev, $id_activity);

        if ($num_fb == 0) {
            $data_fb[0] = 'fileeciuntukuploadsatufile';
        } else {
            $fb = $this->eci_feedback_m->get_feed_back_by_date_now($date);
            $data_fb = explode(".", $fb->CHR_FILENAME);
        }

        $no_feedback += substr(@$data_fb[0], 20);
        for ($index = 1; $index < ($jum_file + 1); $index++) {
            $fileName = $_FILES["file$index"]["name"];
            $fileName2 = explode(".", $fileName);
            $fileName = "eci_feedback$date" . $no_feedback . "." . @$fileName2[1];
            $file_name = "$fileName";
            $file_name = str_replace(" ", "_", $file_name);
            //            $file_name = "$id_eci-$rev-$id_activity-$fileName";
            $config['upload_path'] = "assets/file/eci_feedback/";
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'JPEG|jpg|png|gif|pdf|docx|doc|txt|rar|zip|7z|xlsx|xls|php';
            $config['max_size'] = 20000;

            if (@$fileName2[1] == null) {
                $file_name = "_";
            }

            $this->upload->initialize($config);
            if (!$this->upload->do_upload("file$index")) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                exit();
                redirect("eci/schedule_c/feedback_eci/$id_eci/$rev/$id_activity/4");
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            $media = $this->upload->data("file$index");

            $this->db->query("INSERT INTO TT_ECI_FEEDBACK (CHR_ID_ECI,INT_SEQ, INT_REV, INT_ID_ACTIVITY, INT_FEEDBACK, CHR_FILENAME, CHR_TITTLE,"
                    . " CHR_COMMENT, CHR_USR_ENTRY, CHR_DATE_ENTRY, CHR_TIME_ENTRY) VALUES ($id_eci, $index,$rev, $id_activity, $num_fb, '$file_name',"
                    . " '$title', '$comment', '$npk_created', '$date', '$time')");

            $this->db->query("UPDATE TT_ECI_L SET FLT_PROGRESS=1, CHR_FLG_ATTTACH='1'  WHERE  CHR_ID_ECI=$id_eci AND INT_REV=$rev AND INT_ID_ACTIVITY=$id_activity;");

            $no_feedback +=1;
        }

        $seq_id = $this->notification_m->generate_id();
        $result_act = $this->activity_m->get_activity_by_id($id_activity);
//        $result_pic = $this->pic_m->get_pic_by_id($iduser);
        $this->db->query("update TT_ECI_L set INT_STATUS_COLOR = 3 from TT_ECI_L where CHR_ID_ECI=  $id_eci AND INT_ID_ACTIVITY = $id_activity ");

        $data_notif = array(
            'INT_ID_NOTIF' => $seq_id,
            'CHR_NPK' => '0486',
            'INT_ID_APP' => '10',
            'CHR_NOTIF_TITLE' => 'New feedback Activity' . trim($result_act->CHR_ACTIVITY_NAME),
            'CHR_NOTIF_DESC' => "Feedback Activity " . trim($result_act->CHR_ACTIVITY_NAME),
            'CHR_LINK' => "eci/schedule_c/notif_click/$seq_id/10",
            'CHR_CREATED_BY' => '',
            'CHR_CREATED_DATE' => date('Ymd'),
            'CHR_CREATED_TIME' => date('His')
        );

        $this->notification_m->insert_notification($data_notif);


        redirect("eci/schedule_c/view_project/4");
    }

    function start_activity($ideci, $idline) {
        $this->role_module_m->authorization('68');
        $this->eci_l_m->start_activity($ideci, $idline);
        redirect('eci/schedule_c/view_project');
    }

    function activity_editing($id, $line) {
        $this->role_module_m->authorization('59');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(59);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Edit Activity';
        $data['data_category'] = $this->category_m->find_trans("*", "INT_ID_CATEGORY<>0", "CHR_CATEGORY_NAME");
        $data['data_activity'] = $this->activity_m->get_data_activity();
        $data['data_pic'] = $this->pic_m->find_trans("*", "INT_ID_PIC<>0", "CHR_DEPT");
        $data['data_eci'] = $this->eci_h_m->find_trans("*", "CHR_ID_ECI<>0", "CHR_ID_ECI, INT_REV");

        $getdata = $this->db->query("select * from TT_ECI_L where CHR_ID_ECI = $id and INT_ID_ECI_LINE = $line")->row();
        $getpic = $this->db->query("select * from TM_ECI_PIC where CHR_NAME = '" . $getdata->CHR_PIC_NAME . "' and CHR_DEPT = '" . $getdata->CHR_PIC_DEPT . "' ")->row();

        //$activity_current = getdata->CHR_ACTIVITY_NAME;
        $startdate_current = $getdata->CHR_START_DATE;
        $duedate_current = $getdata->CHR_DUE_DATE;
        $data['idecis'] = $id;
        $data['eci_line'] = $line;
        $data['int_seq'] = $getdata->INT_SEQ;
        $data['id_act'] = $getdata->INT_ID_ACTIVITY;
        $data['id_name_act'] = $getdata->CHR_ACTIVITY_NAME;
        $data['id_pic'] = $getpic->INT_ID_PIC;
        $data['dept'] = $getpic->CHR_DEPT;
        $data['data_pic'] = $this->pic_m->get_data_pic();
        $data['data_pic_dept'] = $this->pic_m->get_data_dept_pic();

        $data['startdate_current'] = date("d-m-Y", strtotime($startdate_current));
        $data['duedate_current'] = date("d-m-Y", strtotime($duedate_current));

        $result_eci = $this->db->query("select * from TT_ECI_H where CHR_ID_ECI = $id")->row();
        $data['eci_now'] = $result_eci->CHR_NAME;

        $data['data'] = $this->eci_l_m->get_data_activity($id, $line)->row();

        $data['content'] = 'eci/schedule/edit_activity_v';
        $this->load->view($this->layout, $data);
    }

    function edit_activity() {
        $this->role_module_m->authorization('146');

        $id_eci = trim($this->input->post('CHR_ID_ECIs'));
        $line = $this->input->post('INT_ID_ECI_LINEs');
        $id_activity = $this->input->post('activity');
        $id_pic = $this->input->post('pic');
        $int_seq = $this->input->post('txtsequence');
        $duration = $this->input->post('due_date') - $this->input->post('start_date');

        $result_eci = $this->eci_h_m->get_eci_h_by_id($id_eci);
        $result_act = $this->activity_m->get_activity_by_id($id_activity);
        $result_pic = $this->pic_m->get_pic_by_id($id_pic);

        $int_rev = $result_eci->INT_REV;
        $activity_name = $result_act->CHR_ACTIVITY_NAME;
        $pic_npk = $result_pic->CHR_NPK;
        $pic_name = $result_pic->CHR_NAME;
        $pic_mail = $result_pic->CHR_EMAIL;
        $pic_superior = $result_pic->CHR_NAME_SUPERIOR;
        $pic_sup_mail = $result_pic->CHR_EMAIL_SUPERIOR;
        $pic_dept = $result_pic->CHR_DEPT;
        $session = $this->session->all_userdata();
        $start_date = date("Ymd", strtotime($this->input->post('start_date')));
        $due_date = date("Ymd", strtotime($this->input->post('due_date')));

        $data = array(
            'INT_REV' => $int_rev,
            'INT_ID_ACTIVITY' => $id_activity,
            'CHR_ACTIVITY_NAME' => $activity_name,
            'INT_DURATION' => $duration,
            'CHR_START_DATE' => $start_date,
            'CHR_DUE_DATE' => $due_date,
            'INT_SEQ' => $int_seq,
            'CHR_PIC_NPK' => $pic_npk,
            'CHR_PIC_NAME' => $pic_name,
            'CHR_PIC_MAIL' => $pic_mail,
            'CHR_PIC_SUPERIOR' => $pic_superior,
            'CHR_PIC_SUPERIOR_MAIL' => $pic_sup_mail,
            'CHR_PIC_DEPT' => $pic_dept,
            'CHR_USR_UPDATE' => $session['NPK'],
            'CHR_DATE_UPDATE' => date('Ymd'),
            'CHR_TIME_UPDATE' => date('his'),
        );

        $id_update = array(
            'CHR_ID_ECI' => $id_eci,
            'INT_ID_ECI_LINE' => $line,
        );

        $this->eci_l_m->edit_activity($data, $id_update);
        $this->eci_l_m->update_sequence($id_eci);

        redirect("eci/schedule_c/activity_project/2/$id_eci");
    }

    function approve_feedback($msg = NULL) {
        $this->role_module_m->authorization('146');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(146);
        $data['title'] = 'Feedback Admin';
        $data['msg'] = $msg;

        $data['data'] = $this->eci_l_m->get_feedback_data();

        $data['content'] = 'eci/schedule/approve_feedback_v';

        $this->load->view($this->layout, $data);
    }

    function delete_eci($id) {
        $this->role_module_m->authorization('59');

        $data_update = array(
            'CHR_FLG_DELETE' => '1',
        );

        $this->db->query("DELETE TT_ECI_FEEDBACK WHERE CHR_ID_ECI ='$id'");
        $this->db->query("DELETE TT_ECI_L WHERE CHR_ID_ECI ='$id'");

        $this->eci_h_m->update_trans_h($data_update, " CHR_ID_ECI = '" . $id . "'");

        redirect($this->back_to_manage . $msg = 3);
    }

    function approval_feedback($ideci, $idact, $iduser, $intfeedback) {
        $this->log_m->add_log(27, NULL);
        $data_update1 = array(
            'CHR_APPROVE_BY_ADMIN' => 1,
        );

        $this->eci_l_m->update_feedback2($data_update1, "CHR_ID_ECI='" . $ideci . "' AND INT_ID_ACTIVITY = '" . $idact . "' AND CHR_USR_ENTRY='" . $iduser . "' AND INT_FEEDBACK='" . $intfeedback . "'");

        $data2 = array(
            'CHR_DATE_FINISH' => date('Ymd'),
            'INT_FLG_REJECTED' => 0,
            'INT_STATUS_COLOR' => 3,
        );

        $this->eci_l_m->update_trans_l($data2, "CHR_ID_ECI=  $ideci  AND INT_ID_ACTIVITY =  $idact   AND CHR_USR_ENTRY='$iduser'");

        $seq_id = $this->notification_m->generate_id();
        $result_act = $this->activity_m->get_activity_by_id($idact);
        $this->db->query("update TT_ECI_L set INT_STATUS_COLOR = 3 from TT_ECI_L where CHR_ID_ECI= $ideci  AND INT_ID_ACTIVITY =  $idact ");

        $data_notif = array(
            'INT_ID_NOTIF' => $seq_id,
            'CHR_NPK' => $iduser,
            'INT_ID_APP' => '10',
            'CHR_NOTIF_TITLE' => 'Approved feedback Activity' . trim($result_act->CHR_ACTIVITY_NAME),
            'CHR_NOTIF_DESC' => "Publish ECI " . trim($result_act->CHR_ACTIVITY_NAME),
            'CHR_LINK' => "eci/schedule_c/notif_click/$seq_id/10",
            'CHR_CREATED_BY' => '',
            'CHR_CREATED_DATE' => date('Ymd'),
            'CHR_CREATED_TIME' => date('His')
        );

        $this->notification_m->insert_notification($data_notif);
        redirect('eci/schedule_c/approve_feedback');
    }

    function reject_feedback($id_eci, $id_act, $id_user, $fidbek) {
        $this->eci_l_m->delete_revision($id_eci, $id_act, $id_user, $fidbek);
        $this->eci_l_m->reject_feedback($id_eci, $id_act, $id_user);

        $seq_id = $this->notification_m->generate_id();
        $result_act = $this->activity_m->get_activity_by_id($id_act);
        $result_pic = $this->pic_m->get_pic_by_id($id_user);

        $data_notif = array(
            'INT_ID_NOTIF' => $seq_id,
            'CHR_NPK' => $id_user,
            'INT_ID_APP' => '10',
            'CHR_NOTIF_TITLE' => 'Rejected ' . trim($result_act->CHR_ACTIVITY_NAME),
            'CHR_NOTIF_DESC' => "Rejected feedback Activity " . trim($result_act->CHR_ACTIVITY_NAME),
            'CHR_LINK' => "eci/schedule_c/view_project_notif/$seq_id/$id_eci/$id_act",
            'CHR_CREATED_BY' => $result_pic->CHR_NAME,
            'CHR_CREATED_DATE' => date('Ymd'),
            'CHR_CREATED_TIME' => date('His')
        );

        $this->notification_m->insert_notification($data_notif);
        redirect('eci/schedule_c/approve_feedback');
    }

    function get_pic_by_dept() {
        $dept = trim($this->input->post('dept'));

        $pics = $this->pic_m->get_data_pic_by_dept($dept);

        $data = "";
        foreach ($pics as $isi) {
            $data .= '<option value=' . $isi->INT_ID_PIC . '>&nbsp;&nbsp;&nbsp;&nbsp;' . trim($isi->CHR_NAME);
        }

        //echo json_encode($data);
        echo trim(json_encode($data), '"');
    }

    function print_eci($id) {
        $this->role_module_m->authorization('59');
        $msg = "";

        //$objReader = PHPExcel_IOFactory::createReader($objTpl, 'Excel2007');
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setIncludeCharts(TRUE);

        $objTpl = $objReader->load("./assets/template/eci_print2007.xlsx");

        //$objTpl = PHPExcel_IOFactory::load("./assets/template/eci_print.xlsx");
        $objTpl->setActiveSheetIndex(0);



        $view_data_h = $this->eci_h_m->find_trans('*', 'CHR_ID_ECI = "' . $id . '"');

        $objTpl->getActiveSheet()->setCellValue('E4', $view_data_h[0]->CHR_ID_ECI);
        $objTpl->getActiveSheet()->setCellValue('E5', $view_data_h[0]->CHR_NAME);
        $objTpl->getActiveSheet()->setCellValue('E6', $view_data_h[0]->CHR_CATEGORY_NAME);
        $objTpl->getActiveSheet()->setCellValue('E7', $view_data_h[0]->CHR_CUSTOMER);
        $objTpl->getActiveSheet()->setCellValue('E8', $view_data_h[0]->CHR_DUE_DATE);
        $objTpl->getActiveSheet()->setCellValue('E9', $view_data_h[0]->CHR_IMPLEMENTING_PLAN);
        $objTpl->getActiveSheet()->setCellValue('E10', $view_data_h[0]->CHR_INTERCHANGE);



        $view_data = $this->eci_l_m->find_trans('*', 'CHR_ID_ECI = "' . $id . '"');

        $i = 1;
        foreach ($view_data as $data):

            $status = "";
            if ($data->INT_STATUS_COLOR == 1)
                $status = "ready to start";
            if ($data->INT_STATUS_COLOR == 2)
                $status = "Started";
            if ($data->INT_STATUS_COLOR == 3)
                $status = "Finished";
            if ($data->INT_STATUS_COLOR == 4)
                $status = "Delayed";


            $objTpl->getActiveSheet()->setCellValue('A' . ($i + 16), $i);
            //$objTpl->getActiveSheet()->setCellValueExplicit('B' . ($i + 1), $data->CHR_KODE_JENIS_TRANS, PHPExcel_Cell_DataType::TYPE_STRING);

            $objTpl->getActiveSheet()->setCellValue('B' . ($i + 16), $data->CHR_ACTIVITY_NAME);
            $objTpl->getActiveSheet()->setCellValue('M' . ($i + 16), $data->CHR_PIC_NAME);
            //$objTpl->getActiveSheet()->setCellValue('T' . ($i + 16), date("Y-m-d", strtotime(substr($data->CHR_START_DATE, 0, 4) . "-" . substr($data->CHR_START_DATE, 4, 2) . "-" . substr($data->CHR_START_DATE, 6, 2))));
            //$objTpl->getActiveSheet()->setCellValue('U' . ($i + 16), substr($data->CHR_DUE_DATE, 0, 4) . "-" . substr($data->CHR_DUE_DATE, 4, 2) . "-" . substr($data->CHR_DUE_DATE, 6, 2));
            //$objTpl->getActiveSheet()->setCellValueExplicit('U' . ($i + 16), date("Y-m-d") );
            // $objTpl->getActiveSheet()->getStyle('U2:U20')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYMINUS );

            $dateValue = PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($data->CHR_START_DATE, 0, 4) . "-" . substr($data->CHR_START_DATE, 4, 2) . "-" . substr($data->CHR_START_DATE, 6, 2)));
            $objTpl->getActiveSheet()->setCellValue('P' . ($i + 16), $dateValue);
            $objTpl->getActiveSheet()->setCellValue('P' . ($i + 16), $dateValue);
            $dateValue = PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($data->CHR_DUE_DATE, 0, 4) . "-" . substr($data->CHR_DUE_DATE, 4, 2) . "-" . substr($data->CHR_DUE_DATE, 6, 2)));
            $objTpl->getActiveSheet()->setCellValue('T' . ($i + 16), $dateValue);
            $dateValue = PHPExcel_Shared_Date::PHPToExcel(strtotime(substr($data->CHR_DATE_FINISH, 0, 4) . "-" . substr($data->CHR_DATE_FINISH, 4, 2) . "-" . substr($data->CHR_DATE_FINISH, 6, 2)));
            $objTpl->getActiveSheet()->setCellValue('U' . ($i + 16), $dateValue);
            $objTpl->getActiveSheet()->setCellValue('V' . ($i + 16), trim($data->INT_DURATION) + 1);
            $objTpl->getActiveSheet()->setCellValue('W' . ($i + 16), $status);

            $i = $i + 1;
        endforeach;

        $filename = 'ECI_' . $id . '.xlsx'; //just some random filename
        ob_end_clean();
        header('application/vnd.openxmlformats-officedocument.spreadsheetml.template');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
        exit();

        redirect($this->back_to_manage . $msg = 2);
    }

    function download($id_eci, $rev, $id_activity, $int_feed) { //fungsi download
        $this->load->helper('download');

        $get_tittle = $this->db->query("select * from TT_ECI_FEEDBACK where CHR_ID_ECI='$id_eci' and  INT_REV = '$rev' and INT_ID_ACTIVITY = '$id_activity' and INT_FEEDBACK = '$int_feed'")->row();
        $name = $get_tittle->CHR_FILENAME;
        $path = 'assets/file/eci_feedback/' . $name;
        // check that file exists and is readable
        if (file_exists($path) && is_readable($path)) {
            $size = filesize($path);
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . $size);
            header('Content-Disposition: attachment; filename=' . $name);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            ob_clean();
            flush();
            readfile($path);
            exit;
        }
        //$data = file_get_contents("assets/file/eci_feedback/$name"); // filenya
        //force_download($name, $data);
    }

    //'smtp_host' => 'ssl://smtp.gmail.com',
    //       'smtp_port' => 465,
    function email_sent($to, $cc, $subject, $message) {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            //'smtp_host' => '192.1147.10.2',
            //'smtp_port' => 25,
            'smtp_user' => 'wildan.denny@aisin-indonesia.co.id', // here goes your mail 
            'smtp_pass' => 'Upunupun', // here goes your mail password 
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );


        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from("wildan.denny@aisin-indonesia.co.id", "PT AISIN INDONESIA");
        $this->email->to($to);
        $this->email->cc($cc);
        $this->email->bcc('');

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
        echo $this->email->print_debugger();
        exit();
    }

    function get_data_by_username(){
        $username = trim($this->input->post('username'));

        $pics = $this->user_m->get_data_pic_by_dept($username);

        $data = "";
        foreach ($pics as $isi) {
            $data .= '<option value=' . $isi->INT_ID_PIC . '>&nbsp;&nbsp;&nbsp;&nbsp;' . trim($isi->CHR_NAME);
        }

        echo json_encode($data);
    }
}

?>																					