<?php

class groupdept_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'organization/groupdept_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/division_m');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('2');

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
        $data['data'] = $this->groupdept_m->get_groupdept();
        $data['content'] = 'organization/groupdept/manage_groupdept_v';
        $data['title'] = 'Manage Group Department';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(2);
        
        $this->load->view($this->layout, $data);
    }

    function select_by_id($id, $msg = NULL) {
        $this->role_module_m->authorization('2');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['msg'] = $msg;
        $data['data'] = $this->groupdept_m->get_data_groupdept($id)->row();
        $data['data_dept'] = $this->dept_m->get_dept_by_groupdept($id);
        $data['data_groupdept'] = $this->groupdept_m->get_groupdept();
        $data['content'] = 'organization/groupdept/view_groupdept_v';
        $data['title'] = 'View Group Department';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(2);
        
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_groupdept() {
        $this->role_module_m->authorization('2');
        $data['content'] = 'organization/groupdept/create_groupdept_v';
        $data['title'] = 'Create Group Dept';
        $data['data_division'] = $this->division_m->get_division();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(2);
        
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_groupdept() {
        $this->form_validation->set_rules('CHR_GROUP_DEPT', 'Group Department Initial', 'required|min_length[7]|max_length[10]|callback_check_id_groupdept|trim');
        $this->form_validation->set_rules('CHR_GROUP_DEPT_DESC', 'Group Department Desc', 'required');

        $id = $this->groupdept_m->generate_id_groupdept();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_groupdept();
        } else {
            $data = array(
                'INT_ID_GROUP_DEPT' => $id,
                'CHR_GROUP_DEPT' => strtoupper($this->input->post('CHR_GROUP_DEPT')),
                'CHR_GROUP_DEPT_DESC' => $this->input->post('CHR_GROUP_DEPT_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'INT_ID_DIVISION' => $this->input->post('INT_ID_DIVISION'),
                'BIT_FLG_DEL' => 0
            );
            $this->groupdept_m->save_groupdept($data);
            $this->log_m->add_log('39', $id);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking groupdept id
    function check_id_groupdept($id) {
        $return_value = $this->groupdept_m->check_id_groupdept($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id_groupdept', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //prepare to editing
    function edit_groupdept($id) {
        $this->role_module_m->authorization('2');
        $data['data'] = $this->groupdept_m->get_data_groupdept($id)->row();
        $data['content'] = 'organization/groupdept/edit_groupdept_v';
        $data['title'] = 'Edit Group Department';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(2);
        
        $data['data_division'] = $this->division_m->get_division();
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_groupdept() {
        $id = $this->input->post('INT_ID_GROUP_DEPT');
        $msg = 2;

        $this->form_validation->set_rules('CHR_GROUP_DEPT', 'Group Department Initial', 'required|min_length[7]|max_length[10]|trim');
        $this->form_validation->set_rules('CHR_GROUP_DEPT_DESC', 'Group Department Desc', 'required');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_groupdept($id);
        } else {
            $data = array(
                'CHR_GROUP_DEPT' => strtoupper($this->input->post('CHR_GROUP_DEPT')),
                'CHR_GROUP_DEPT_DESC' => $this->input->post('CHR_GROUP_DEPT_DESC'),
                'INT_ID_DIVISION' => $this->input->post('INT_ID_DIVISION'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->groupdept_m->update($data, $id);
            $this->log_m->add_log('40', $id);

            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_groupdept($id) {
        $this->role_module_m->authorization('2');
        $this->groupdept_m->delete($id);
        $this->log_m->add_log('41', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function moving_groupdept() {
        $id = $this->input->post('INT_ID_GROUP_DEPT');
        $checked = $this->input->post('case');
        $data = array(
            'INT_ID_GROUP_DEPT' => $this->input->post('INT_ID_GROUP_DEPT_NEW')
        );

        if ($checked == null) {
            redirect('organization/groupdept_c/select_by_id/' . $id . '/' . 4);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->dept_m->update($data, $checked[$i]);
        }
        redirect('organization/groupdept_c/select_by_id/' . $id . '/' . 1);
    }

}
