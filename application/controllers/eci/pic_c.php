<?php

class pic_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'eci/pic_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('eci/pic_m');
        $this->load->model('eci/eci_l_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('56');
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
        $data['sidebar'] = $this->role_module_m->side_bar(56);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage ECI PIC';
        $data['msg'] = $msg;
        $data['data'] = $this->pic_m->find_trans("*", "INT_ID_PIC<>0", "CHR_NPK");
        $data['content'] = 'eci/pic/manage_pic_v';
        $this->load->view($this->layout, $data);
    }

    function save_pic() {
        $this->role_module_m->authorization('56');
        $this->form_validation->set_rules('CHR_NPK', 'Id Category', 'required|max_length[4]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_NAME', 'Category Desc', 'required');
        $this->form_validation->set_rules('CHR_DEPT', 'Category Desc', 'required|max_length[4]|trim');
        $id = $this->pic_m->generate_id_category();
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'INT_ID_PIC' => $id,
                'CHR_NPK' => $this->input->post('CHR_NPK'),
                'CHR_NAME' => strtoupper($this->input->post('CHR_NAME')),
                'CHR_DEPT' => strtoupper($this->input->post('CHR_DEPT')),
                'CHR_EMAIL' => $this->input->post('CHR_EMAIL'),
                'CHR_NAME_SUPERIOR' => strtoupper($this->input->post('CHR_NAME_SUPERIOR')),
                'CHR_EMAIL_SUPERIOR' => $this->input->post('CHR_EMAIL_SUPERIOR'),
                'CHR_USR_ENTRY' => $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His')
            );
            $this->pic_m->add_trans($data);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function update_pic() {
        $this->role_module_m->authorization('56');
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


            $data2 = array(
                'CHR_PIC_NAME' => strtoupper($this->input->post('CHR_NAME')),
                'CHR_PIC_DEPT' => strtoupper($this->input->post('CHR_DEPT')),
                'CHR_PIC_MAIL' => $this->input->post('CHR_EMAIL'),
                'CHR_PIC_SUPERIOR' => strtoupper($this->input->post('CHR_NAME_SUPERIOR')),
                'CHR_PIC_SUPERIOR_MAIL' => $this->input->post('CHR_EMAIL_SUPERIOR')
            );
            $this->eci_l_m->update_trans_l($data2, "CHR_PIC_NPK = '" . $npk . "'");

            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_pic($id) {
        $this->role_module_m->authorization('56');
        $this->pic_m->delete_trans($id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function getUpdate() {
        $this->role_module_m->authorization('56');
        $id_activity = $this->input->post("id_activity");
        $get_data = $this->pic_m->find_trans("*", "INT_ID_PIC = '" . $id_activity . "'");
        $data = "";
        $data .= form_open('eci/pic_c/update_pic', 'class="form-horizontal"');
        $data .= '
					<input name="INT_ID_PIC" class="form-control" required type="hidden" value="' . $get_data[0]->INT_ID_PIC . '">
					<div class="form-group">
						<label class="col-sm-4 control-label">NPK</label>
						<div class="col-sm-8">
							<input name="CHR_NPK" autofocus class="form-control" maxlength="4" required readonly type="text" style="width: 80px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_NPK) . '">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Nama</label>
						<div class="col-sm-8">
							<input name="CHR_NAME" class="form-control" maxlength="50" required type="text" style="width: 290px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_NAME) . '">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Dept</label>
						<div class="col-sm-8">
							<input name="CHR_DEPT" autofocus class="form-control" maxlength="4" required type="text" style="width: 80px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_DEPT) . '">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Email</label>
						<div class="col-sm-8">
							<input name="CHR_EMAIL" class="form-control" maxlength="50" style="width: 290px;" value="' . trim($get_data[0]->CHR_EMAIL) . '">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Nama Superior</label>
						<div class="col-sm-8">
							<input name="CHR_NAME_SUPERIOR" class="form-control" maxlength="50" style="width: 290px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_NAME_SUPERIOR) . '">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Email Superior</label>
						<div class="col-sm-8">
							<input name="CHR_EMAIL_SUPERIOR" class="form-control" maxlength="50" style="width: 290px;" value="' . trim($get_data[0]->CHR_EMAIL_SUPERIOR) . '">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-push-4">
							<div class="btn-group">
								<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
				';
        $data .= anchor('eci/pic_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
        $data .= '         	</div>
						</div>
					</div>
				';
        $data .= form_close();
        echo $data;
    }

    function check_id($id) {
        $this->role_module_m->authorization('56');
        $return_value = $this->pic_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function save_pic_popup() {
        $this->role_module_m->authorization('56');

        $id = $this->pic_m->generate_id_category();
        $session = $this->session->all_userdata();

        $data_user = $this->pic_m->get_data_user_by_npk($this->input->post('CHR_NPK'));

        $data = array(
            'INT_ID_PIC' => $id,
            'CHR_NPK' => $this->input->post('CHR_NPK'),
            'CHR_NAME' => strtoupper($data_user->CHR_USERNAME),
            'CHR_DEPT' => strtoupper($data_user->CHR_DEPT),
            'CHR_EMAIL' => strtoupper($data_user->CHR_EMAIL),
//            'CHR_NAME_SUPERIOR' => strtoupper($this->input->post('CHR_NAME_SUPERIOR')),
//            'CHR_EMAIL_SUPERIOR' => $this->input->post('CHR_EMAIL_SUPERIOR'),
            'CHR_USR_ENTRY' => $session['NPK'],
            'CHR_DATE_ENTRY' => date('Ymd'),
            'CHR_TIME_ENTRY' => date('His')
        );
        $this->pic_m->add_trans($data);
        redirect("eci/schedule_c/activity_project/0/NULL");
    }

}

?>
