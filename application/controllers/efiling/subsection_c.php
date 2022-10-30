<?php

class subsection_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'efiling/subsection_c/index/';

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
    function index($msg = NULL , $id_section) {
        $this->role_module_m->authorization('65');

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
		$session = $this->session->all_userdata();
		$name = $session['USERNAME'];
		$id_role = $this->section_m->get_role($name);
		$id_dept = $this->section_m->get_dept($name);
        //$data['data'] = $this->subsection_m->get_subsection();
		$data['data_role'] = $id_role;
		$data['data'] = $this->subsection_m->get_subsection_by_id_section($id_section);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
        $data['content'] = 'efiling/subsection/manage_subsection_v';
        $data['title'] = 'Sub Section';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_subsection($id_section) {
        $this->role_module_m->authorization('65');
        $data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
        $data['content'] = 'efiling/subsection/create_subsection_v';
        $data['title'] = 'Create Sub section';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_subsection($id_section) {
        $this->form_validation->set_rules('CHR_SUB_SECTION', 'Sub section', 'required|min_length[7]|max_length[7]|callback_check_id_subsection|trim');
        $this->form_validation->set_rules('CHR_SUB_SECTION_DESC', 'Sub section Desc', 'required');

        $id_subsection = $this->subsection_m->generate_id_subsection();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_subsection($id_section);
        } else {
            $data = array(
                'INT_ID_SUB_SECTION' => $id_subsection,
                'CHR_SUB_SECTION' => strtoupper($this->input->post('CHR_SUB_SECTION')),
                'CHR_SUB_SECTION_DESC' => $this->input->post('CHR_SUB_SECTION_DESC'),
                'INT_ID_SECTION' => $this->input->post('INT_ID_SECTION'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 0
            );
            $this->subsection_m->save($data);
            $this->log_m->add_log('48', $id_subsection);
            redirect($this->back_to_manage . $msg = 1 . "/" . $id_section);
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
    function edit_subsection($id_subsection) {
        $this->role_module_m->authorization('65');
        $data['data'] = $this->subsection_m->get_data_subsection($id_subsection)->row();
		$id_section = $this->subsection_m->get_id_section_by_id_subsection($id_subsection);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_section'] = $this->section_m->get_section();		
        $data['content'] = 'efiling/subsection/edit_subsection_v';
        $data['title'] = 'Edit Sub section';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_subsection() {
        $id_subsection = $this->input->post('INT_ID_SUB_SECTION');

        $this->form_validation->set_rules('CHR_SUB_SECTION', 'Sub section', 'required|min_length[7]|max_length[7]|trim');
        $this->form_validation->set_rules('CHR_SUB_SECTION_DESC', 'Sub section Desc', 'required');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_subsection($id_subsection);
        } else {
            $data = array(
                'CHR_SUB_SECTION' => strtoupper($this->input->post('CHR_SUB_SECTION')),
                'CHR_SUB_SECTION_DESC' => $this->input->post('CHR_SUB_SECTION_DESC'),
                'INT_ID_SECTION' => $this->input->post('INT_ID_SECTION'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->subsection_m->update($data, $id_subsection);
            $this->log_m->add_log('49', $id_subsection);

            redirect($this->back_to_manage . $msg = 2 . "/" . $this->input->post('INT_ID_SECTION'));
        }
    }

    //deleting data
    function delete_subsection($id_subsection) {
        $this->role_module_m->authorization('65');
		$id_section = $this->subsection_m->get_id_section_by_id_subsection($id_subsection);
        $this->subsection_m->delete($id_subsection);
        $this->log_m->add_log('50', $id_subsection);
        redirect($this->back_to_manage . $msg = 3 . "/" . $id_section);
    }

}
