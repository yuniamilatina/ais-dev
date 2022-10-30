<?php

class category_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'eci/category_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('eci/category_m');
        $this->load->model('basis/log_m');
        $this->load->model('eci/eci_h_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('143');
        $this->log_m->add_log(15, NULL);
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
        $data['sidebar'] = $this->role_module_m->side_bar(143);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage ECI Category';
        $data['msg'] = $msg;
        $data['data'] = $this->category_m->find_trans("*", "INT_ID_CATEGORY<>0", "INT_ID_CATEGORY");
        $data['content'] = 'eci/category/manage_category_v';
        $this->load->view($this->layout, $data);
    }

    function save_category() {
        $this->role_module_m->authorization('143');
        $this->form_validation->set_rules('CHR_CODE_CATEGORY', 'Id Category', 'required|max_length[6]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_CATEGORY_NAME', 'Category Desc', 'required');
        $id = $this->category_m->generate_id_category();
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'INT_ID_CATEGORY' => $id,
                'CHR_CODE_CATEGORY' => strtoupper($this->input->post('CHR_CODE_CATEGORY')),
                'CHR_CATEGORY_NAME' => strtoupper($this->input->post('CHR_CATEGORY_NAME')),
                'CHR_USR_ENTRY' => $session['NPK'],
                'CHR_DATE_ENTRY' => date('Ymd'),
                'CHR_TIME_ENTRY' => date('His')
            );
            $this->category_m->add_trans($data);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function update_category() {
        $this->role_module_m->authorization('143');
        $id = $this->input->post('INT_ID_CATEGORY');
        $session = $this->session->all_userdata();
        $this->form_validation->set_rules('CHR_CODE_CATEGORY', 'Code Category', 'required|max_length[6]|trim');
        $this->form_validation->set_rules('CHR_CATEGORY_NAME', 'Category Desc', 'required');
        if ($this->form_validation->run() == FALSE) {
            redirect($this->back_to_manage . $msg = 12);
        } else {
            $data = array(
                'CHR_CODE_CATEGORY' => strtoupper($this->input->post('CHR_CODE_CATEGORY')),
                'CHR_CATEGORY_NAME' => strtoupper($this->input->post('CHR_CATEGORY_NAME')),
                'CHR_USR_UPDATE' => $session['NPK'],
                'CHR_DATE_UPDATE' => date('Ymd'),
                'CHR_TIME_UPDATE' => date('His')
            );

//            $this->category_m->update_trans($data, " INT_ID_CATEGORY = '".$id."'");
            $this->category_m->update_category($data, $id);

            $data2 = array(
                'CHR_CATEGORY_NAME' => strtoupper($this->input->post('CHR_CATEGORY_NAME'))
            );
            $this->eci_h_m->update_trans_h($data2, " ID_CATEGORY = '" . $id . "'");


            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_category($id) {
        $this->role_module_m->authorization('143');
        $this->category_m->delete_trans($id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function getUpdate() {
        $this->role_module_m->authorization('143');
        $id_activity = $this->input->post("id_activity");
        $get_data = $this->category_m->find_trans("*", "INT_ID_CATEGORY = " . $id_activity . "");
        $data = "";
        $data .= form_open('eci/category_c/update_category', 'class="form-horizontal"');
        $data .= '      
					<input name="INT_ID_CATEGORY" class="form-control" required type="hidden" value="' . $get_data[0]->INT_ID_CATEGORY . '">
					<div class="form-group">
						<label class="col-sm-4 control-label">Category Initial</label>
						<div class="col-sm-8">
							<input name="CHR_CODE_CATEGORY" autofocus class="form-control" maxlength="6" required type="text" style="width: 80px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_CODE_CATEGORY) . '">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Category Description</label>
						<div class="col-sm-8">
							<input name="CHR_CATEGORY_NAME" class="form-control" maxlength="20" required type="text" style="width: 290px;text-transform: uppercase;" value="' . trim($get_data[0]->CHR_CATEGORY_NAME) . '">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-push-4">
							<div class="btn-group">
								<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
				';
        $data .= anchor('eci/category_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
        $data .= '      	</div>
						</div>
					</div> 
				';
        $data .= form_close();
        echo $data;
    }

    function check_id($id) {
        $this->role_module_m->authorization('143');
        $return_value = $this->category_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>
