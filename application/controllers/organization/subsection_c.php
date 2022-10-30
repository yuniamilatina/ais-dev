<?php

class subsection_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'organization/subsection_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/section_m');
        $this->load->model('organization/subsection_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    //show all data
    function index($msg = NULL) {
        $this->role_module_m->authorization('4');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->subsection_m->get_subsection();
        $data['content'] = 'organization/subsection/manage_subsection_v';
        $data['title'] = 'Manage Sub section';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(25);

        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('4');
        $data['data'] = $this->subsection_m->get_data_subsection($id)->row();
        $data['content'] = 'organization/subsection/view_subsection_v';
        $data['data_section'] = $this->section_m->get_section();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(25);

        $data['title'] = 'View Sub section';
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_subsection() {
        $this->role_module_m->authorization('4');
        $data['data_section'] = $this->section_m->get_section();
        $data['content'] = 'organization/subsection/create_subsection_v';
        $data['title'] = 'Create Sub section';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(25);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_subsection() {
        $this->form_validation->set_rules('CHR_SUB_SECTION', 'Sub section', 'required|min_length[7]|max_length[7]|callback_check_id_subsection|trim');
        $this->form_validation->set_rules('CHR_SUB_SECTION_DESC', 'Sub section Desc', 'required');

        $id = $this->subsection_m->generate_id_subsection();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_subsection();
        } else {
            $data = array(
                'INT_ID_SUB_SECTION' => $id,
                'CHR_SUB_SECTION' => strtoupper($this->input->post('CHR_SUB_SECTION')),
                'CHR_SUB_SECTION_DESC' => $this->input->post('CHR_SUB_SECTION_DESC'),
                'INT_ID_SECTION' => $this->input->post('INT_ID_SECTION'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 0
            );
            $this->subsection_m->save($data);
            $this->log_m->add_log('48', $id);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking Sub section id
    function check_id_subsection($id) {
        $return_value = $this->subsection_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //prepare to editing
    function edit_subsection($id) {
        $this->role_module_m->authorization('4');
        $data['data'] = $this->subsection_m->get_data_subsection($id)->row();
        $data['content'] = 'organization/subsection/edit_subsection_v';
        $data['data_section'] = $this->section_m->get_section();
        $data['title'] = 'Edit Sub section';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(25);

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_subsection() {
        $id = $this->input->post('INT_ID_SUB_SECTION');
        $msg = 2;

        $this->form_validation->set_rules('CHR_SUB_SECTION', 'Sub section', 'required|min_length[7]|max_length[7]|trim');
        $this->form_validation->set_rules('CHR_SUB_SECTION_DESC', 'Sub section Desc', 'required');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_subsection($id, $this->role);
        } else {
            $data = array(
                'CHR_SUB_SECTION' => strtoupper($this->input->post('CHR_SUB_SECTION')),
                'CHR_SUB_SECTION_DESC' => $this->input->post('CHR_SUB_SECTION_DESC'),
                'INT_ID_SECTION' => $this->input->post('INT_ID_SECTION'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->subsection_m->update($data, $id);
            $this->log_m->add_log('49', $id);

            redirect($this->back_to_manage . $msg);
        }
    }

    //deleting data
    function delete_subsection($id) {
        $this->role_module_m->authorization('4');
        $this->subsection_m->delete($id);
        $this->log_m->add_log('50', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
