<?php

class dept_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'organization/dept_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('organization/groupdept_m');
        $this->load->model('organization/section_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('3');


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
        $data['data'] = $this->dept_m->get_dept();
        $data['content'] = 'organization/dept/manage_dept_v';
        $data['title'] = 'Manage Group Department';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(3);
        
        $this->load->view($this->layout, $data);
    }

    function select_by_id($id, $msg = NULL) {
        $this->role_module_m->authorization('3');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['msg'] = $msg;
        $data['data'] = $this->dept_m->get_data_dept($id)->row();
        $data['data_section'] = $this->section_m->get_section_by_dept($id);
        $data['data_dept'] = $this->dept_m->get_dept();
        $data['content'] = 'organization/dept/view_dept_v';
        $data['title'] = 'View Group Department';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(3);
        
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_dept() {
        $this->role_module_m->authorization('3');
        $data['content'] = 'organization/dept/create_dept_v';
        $data['title'] = 'Create Dept';
        $data['data_groupdept'] = $this->groupdept_m->get_groupdept();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(3);
        
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_dept() {
        $this->form_validation->set_rules('CHR_DEPT', 'Group Department Initial', 'required|min_length[3]|max_length[3]|callback_check_id_dept|trim');
        $this->form_validation->set_rules('CHR_DEPT_DESC', 'Group Department Desc', 'required');

        $id = $this->dept_m->generate_id_dept();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_dept();
        } else {
            $data = array(
                'INT_ID_DEPT' => $id,
                'CHR_DEPT' => strtoupper($this->input->post('CHR_DEPT')),
                'CHR_DEPT_DESC' => $this->input->post('CHR_DEPT_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'INT_ID_GROUP_DEPT' => $this->input->post('INT_ID_GROUP_DEPT'),
                'BIT_FLG_DEL' => 0
            );
            $this->dept_m->save_dept($data);
            $this->log_m->add_log('39', $id);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking dept id
    function check_id_dept($id) {
        $return_value = $this->dept_m->check_id_dept($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id_dept', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //prepare to editing
    function edit_dept($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->dept_m->get_data_dept($id)->row();
        $data['content'] = 'organization/dept/edit_dept_v';
        $data['title'] = 'Edit Group Department';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(3);
        
        $data['data_groupdept'] = $this->groupdept_m->get_groupdept();
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_dept() {
        $id = $this->input->post('INT_ID_DEPT');
        $msg = 2;

        $this->form_validation->set_rules('CHR_DEPT', 'Group Department Initial', 'required|min_length[3]|max_length[3]|trim');
        $this->form_validation->set_rules('CHR_DEPT_DESC', 'Group Department Desc', 'required');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_dept($id);
        } else {
            $data = array(
                'CHR_DEPT' => strtoupper($this->input->post('CHR_DEPT')),
                'CHR_DEPT_DESC' => $this->input->post('CHR_DEPT_DESC'),
                'INT_ID_GROUP_DEPT' => $this->input->post('INT_ID_GROUP_DEPT'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->dept_m->update($data, $id);
            $this->log_m->add_log('40', $id);

            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_dept($id) {
        $this->role_module_m->authorization('3');
        $this->dept_m->delete($id);
        $this->log_m->add_log('41', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function moving_dept() {
        $id = $this->input->post('INT_ID_DEPT');
        $checked = $this->input->post('case');
        $data = array(
            'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT_NEW')
        );

        if ($checked == null) {
            redirect('organization/dept_c/select_by_id/' . $id . '/' . 4);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->section_m->update($data, $checked[$i]);
        }
        redirect('organization/dept_c/select_by_id/' . $id . '/' . 1);
    }
}
