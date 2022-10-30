<?php

class division_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'organization/division_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/division_m');
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/company_m');

        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('1');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['data'] = $this->division_m->get_division();
        $data['content'] = 'organization/division/manage_division_v';
        $data['title'] = 'Manage Division';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(1);
        
        $this->load->view($this->layout, $data);
    }

    function select_by_id($id, $msg = NULL) {
        $this->role_module_m->authorization('1');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['msg'] = $msg;
        $data['data'] = $this->division_m->get_data_division($id)->row();
        $data['data_groupdept'] = $this->groupdept_m->get_groupdept_by_division($id);
        $data['data_division'] = $this->division_m->get_division();
        $data['content'] = 'organization/division/view_division_v';
        $data['title'] = 'View Division';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(1);
        
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_division() {
        $this->role_module_m->authorization('1');
        $data['content'] = 'organization/division/create_division_v';
        $data['title'] = 'Create Division';
        $data['data_company'] = $this->company_m->get_company();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(1);
        
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_division() {
        $this->form_validation->set_rules('CHR_DIVISION', 'Division Initial', 'required|min_length[5]|max_length[5]|callback_check_id_division|trim');
        $this->form_validation->set_rules('CHR_DIVISION_DESC', 'Division Desc', 'required');

        $id = $this->division_m->generate_id_division();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_division();
        } else {
            $data = array(
                'INT_ID_DIVISION' => $id,
                'CHR_DIVISION' => strtoupper($this->input->post('CHR_DIVISION')),
                'CHR_DIVISION_DESC' => $this->input->post('CHR_DIVISION_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'INT_ID_COMPANY' => $this->input->post('INT_ID_COMPANY'),
                'BIT_FLG_DEL' => 0
            );
            $this->division_m->save_division($data);
            $this->log_m->add_log('39', $id);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking division id
    function check_id_division($id) {
        $return_value = $this->division_m->check_id_division($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id_division', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //prepare to editing
    function edit_division($id) {
        $this->role_module_m->authorization('1');
        $data['data'] = $this->division_m->get_data_division($id)->row();
        $data['content'] = 'organization/division/edit_division_v';
        $data['title'] = 'Edit Division';
        $data['data_company'] = $this->company_m->get_company();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(1);
        
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_division() {
        $id = $this->input->post('INT_ID_DIVISION');
        $msg = 2;

        $this->form_validation->set_rules('CHR_DIVISION', 'Division Initial', 'required|min_length[5]|max_length[5]|trim');
        $this->form_validation->set_rules('CHR_DIVISION_DESC', 'Division Desc', 'required');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_division($id);
        } else {
            $data = array(
                'CHR_DIVISION' => strtoupper($this->input->post('CHR_DIVISION')),
                'CHR_DIVISION_DESC' => $this->input->post('CHR_DIVISION_DESC'),
                'INT_ID_COMPANY' => $this->input->post('INT_ID_COMPANY'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->division_m->update($data, $id);
            $this->log_m->add_log('40', $id);

            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_division($id) {
        $this->role_module_m->authorization('1');
        $this->division_m->delete($id);
        $this->log_m->add_log('41', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function moving_division() {
        $id = $this->input->post('INT_ID_DIVISION');
        $checked = $this->input->post('case');
        $data = array(
            'INT_ID_DIVISION' => $this->input->post('INT_ID_DIVISION_NEW')
        );

        if ($checked == null) {
            redirect('organization/division_c/select_by_id/' . $id . '/' . 4);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->groupdept_m->update($data, $checked[$i]);
        }
        redirect('organization/division_c/select_by_id/' . $id . '/' . 1);
    }

}
