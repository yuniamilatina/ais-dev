<?php

class activity_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'eci/activity_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('eci/activity_m');
        $this->load->model('eci/eci_l_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('143');
        $this->log_m->add_log(14, NULL);
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
        $data['sidebar'] = $this->role_module_m->side_bar(145);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage ECI Category';
        $data['msg'] = $msg;
        $data['data'] = $this->activity_m->find_trans("*", "INT_ID_ACTIVITY<>0", "INT_ID_ACTIVITY");
        $data['content'] = 'eci/activity/manage_activity_v';
        $this->load->view($this->layout, $data);
    }

    function save_activity() {
        $this->role_module_m->authorization('143');

        $this->form_validation->set_rules('activity_name', 'ACTIVITY NAME', 'required|callback_check_id|trim');
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'CHR_ACTIVITY_NAME' => strtoupper($this->input->post('activity_name')),
                'CHR_USR_ENTRY' => $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His')
            );
            $this->activity_m->add_trans($data);
            redirect("eci/activity_c/index/1", "refresh");
        }
    }

    function save_activity_popup() {
        $this->role_module_m->authorization('143');

        $this->form_validation->set_rules('activity_name', 'ACTIVITY NAME', 'required|callback_check_id|trim');
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'CHR_ACTIVITY_NAME' => strtoupper($this->input->post('activity_name')),
                'CHR_USR_ENTRY' => $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His')
            );
            $this->activity_m->add_trans($data);
            redirect("eci/schedule_c/activity_project/0/NULL");
        }
    }

    function update_activity() {
        $this->role_module_m->authorization('143');
        $id = $this->input->post('id_activity');
        $session = $this->session->all_userdata();
        $this->form_validation->set_rules('activity_name', 'ACTIVITY', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'CHR_ACTIVITY_NAME' => strtoupper($this->input->post('activity_name')),
                'CHR_USR_UPDATE' => $session['NPK'],
                'CHR_DATE_UPDATE' => date('Ymd'),
                'CHR_TIME_UPDATE' => date('His')
            );
            $this->activity_m->update_trans($data, " INT_ID_ACTIVITY = " . $id . "");

            $data2 = array(
                'CHR_ACTIVITY_NAME' => strtoupper($this->input->post('activity_name'))
            );
            $this->eci_l_m->update_trans_l($data2, " INT_ID_ACTIVITY = " . $id . "");

            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_activity($id) {
        $this->role_module_m->authorization('143');
        $this->activity_m->delete_trans($id);
        redirect("eci/activity_c/index/3", "refresh");
    }

    function getUpdate() {
        $this->role_module_m->authorization('143');
        $id_activity = $this->input->post("id_activity");
        $get_data = $this->activity_m->find_trans("*", "INT_ID_ACTIVITY = " . $id_activity . "");
        $data = "";
        $data .= form_open('eci/activity_c/update_activity', 'class="form-horizontal"');
        $data .= '      
					<input name="id_activity" class="form-control" required type="hidden" value="' . $get_data[0]->INT_ID_ACTIVITY . '">
					<div class="form-group">
						<label class="col-sm-4 control-label">ACTIVITY NAME</label>
						<div class="col-sm-8">
							<input name="activity_name" id="activity_name" autofocus class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;float:left;" value="' . trim($get_data[0]->CHR_ACTIVITY_NAME) . '">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-push-4">
							<div class="btn-group">
								<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
				';
        $data .= anchor('eci/activity_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
        $data .= '          </div>
						</div>
					</div> 
				';
        $data .= form_close();
        echo $data;
    }

    function check_id($id) {
        $this->role_module_m->authorization('143');
        $return_value = $this->activity_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }
    

}

?>
