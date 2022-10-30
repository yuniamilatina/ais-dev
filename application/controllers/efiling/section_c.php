<?php

class section_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'efiling/section_c/index/';
    private $role = 6;

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('organization/subsection_m');
        $this->load->model('organization/section_m');
        $this->load->model('budget/costcenter_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/log_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    //show all data
    function index($msg = NULL) {
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
		$id_section = $this->section_m->get_section($name);
		if($id_role == 6) {
			$data['data'] = $this->subsection_m->get_subsection_by_id_section($id_section);
			$data['data_id_section'] = $id_section;
			$data['data_name_section'] = $this->section_m->get_name_section($id_section);
			$data['data_role'] = $id_role;
			$data['content'] = 'efiling/subsection/manage_subsection_v';
			$data['title'] = 'Sub Section';
			
			$data['app'] = $this->role_module_m->get_app();
			$data['module'] = $this->role_module_m->get_module();
			$data['function'] = $this->role_module_m->get_function();
			$data['sidebar']=  $this->role_module_m->side_bar(65);
			
			$this->load->view($this->layout, $data);
		}
		else {
			$data['data'] = $this->section_m->get_section_a($id_dept);
			$data['content'] = 'efiling/section/manage_section_v';
			$data['title'] = 'Manage Section';
			
			$data['app'] = $this->role_module_m->get_app();
			$data['module'] = $this->role_module_m->get_module();
			$data['function'] = $this->role_module_m->get_function();
			$data['sidebar']=  $this->role_module_m->side_bar(65);
			
			$this->load->view($this->layout, $data);
		}
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('65');
		$data['data'] = $this->sub_section_m->get_subsection($id);
		
		$data['data_section'] = $this->section_m->get_name_section($id);
		
        //$data['data'] = $this->section_m->get_data_section($id)->row();
        $data['content'] = 'efiling/subsection/manage_subsection_v';
        //$data['data_subsection'] = $this->subsection_m->get_subsection_by_section($id);
        //$data['data_section'] = $this->section_m->get_section();
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);
        
        $data['title'] = 'View Section';
        $data['msg']=null;
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_section() {
        $this->role_module_m->authorization('65');
        $data['data_dept'] = $this->dept_m->get_dept();
        $data['content'] = 'efiling/section/create_section_v';
        $data['data_costcenter'] = $this->costcenter_m->get_costcenter();
        $data['title'] = 'Create Section';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);
        
        $this->load->view($this->layout, $data);
    }

    function initialSection() {
        $id_dept = $this->input->post('id', TRUE);
        $output = $this->dept_m->get_name_dept($id_dept);
        echo trim($output) . '-';
    }

    //saving data
    function save_section() {
        $this->form_validation->set_rules('CHR_SECTION', 'Section', 'required|min_length[7]|max_length[7]|callback_check_id_section|trim');
        $this->form_validation->set_rules('CHR_SECTION_DESC', 'Section Desc', 'required');

        $id = $this->section_m->generate_id_section();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_section();
        } else {
            $data = array(
                'INT_ID_SECTION' => $id,
                'CHR_SECTION' => strtoupper($this->input->post('CHR_SECTION')),
                'CHR_SECTION_DESC' => $this->input->post('CHR_SECTION_DESC'),
                'INT_ID_COST_CENTER' => $this->input->post('INT_ID_COST_CENTER'),
                'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 0
            );
            $this->section_m->save($data);
            $this->log_m->add_log('48', $id);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking Section id
    function check_id_section($id) {
        $return_value = $this->section_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //prepare to editing
    function edit_section($id) {
        $this->role_module_m->authorization('65');
        $data['data'] = $this->section_m->get_data_section($id)->row();
        $data['content'] = 'efiling/section/edit_section_v';
        $data['data_dept'] = $this->dept_m->get_dept();
        $data['data_costcenter'] = $this->costcenter_m->get_costcenter();
        $data['title'] = 'Edit Section';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);
        
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_section() {
        $id = $this->input->post('INT_ID_SECTION');

        $this->form_validation->set_rules('CHR_SECTION', 'Section', 'required|min_length[7]|max_length[7]|trim');
        $this->form_validation->set_rules('CHR_SECTION_DESC', 'Section Desc', 'required');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_section($id);
        } else {
            $data = array(
                'CHR_SECTION' => strtoupper($this->input->post('CHR_SECTION')),
                'CHR_SECTION_DESC' => $this->input->post('CHR_SECTION_DESC'),
                'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT'),
                'INT_ID_COST_CENTER' => $this->input->post('INT_ID_COST_CENTER'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->section_m->update($data, $id);
            $this->log_m->add_log('49', $id);

            redirect($this->back_to_manage . $msg = 2);
        }
    }

    //deleting data
    function delete_section($id) {
        $this->role_module_m->authorization('65');
        $this->section_m->delete($id);
        $this->log_m->add_log('50', $id);
        redirect($this->back_to_manage . $msg = 3);
    }
}
