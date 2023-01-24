<?php

class master_employee_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'aorta/master_employee_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('aorta/master_employee_m');
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/master_data_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    function index($msg = NULL, $id_dept = NULL) {
        $this->role_module_m->authorization('9');
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
        
        $user_session = $this->session->all_userdata();        
        if($id_dept == NULL){
            $id_dept = $user_session["DEPT"];
        }
        
        $dept = $this->master_data_m->replacer_dept_prd($id_dept);
        $sect = $this->master_data_m->get_section($id_dept);

        if($dept == 'MIS'){
            $dept = 'MISY';
        } else if($dept == 'OMD'){
            $dept = 'KZN';
        } else if($dept = 'BRP'){
            $dept = 'PRD1';
        } else if($dept = 'ERP'){
            $dept = 'PRD3';
        } else if($dept = 'MFG'){
            $dept = 'PRD4';
        } else if($dept = 'PPC'){
            $dept = 'PPIC';
        }
        
        $role = $user_session["ROLE"];
        $data['all_dept'] = $this->dept_m->get_dept(); 

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(28);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Employee';
        $data['msg'] = $msg;
        $data['id_dept'] = $id_dept;
        $data['sect'] = $sect;
        $data['data'] = $this->master_employee_m->get_employee($dept);
        $data['content'] = 'aorta/employee/manage_employee_v';
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('9');
        $data['data'] = $this->budgetsubcategory_m->get_data($id)->row();
        $data['content'] = 'budget/masterbudget/budgetsubcategory/view_budgetsubcategory_v';
        $data['title'] = 'View Budget Sub category';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(28);
        $data['news'] = $this->news_m->get_news();


        $this->load->view($this->layout, $data);
    }

    function create_employee() {
        $this->role_module_m->authorization('9');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(28);
        $data['news'] = $this->news_m->get_news();

        $data['data_group'] = $this->master_data_m->get_group();
        $data['data_dept'] = $this->master_data_m->get_dept();
        $data['data_sect'] = $this->master_data_m->get_sect();
        $data['data_subsect'] = $this->master_data_m->get_subsect();

        $data['title'] = 'Create New Employee';
        $data['content'] = 'aorta/employee/create_employee_v';

        $this->load->view($this->layout, $data);
    }

    function save_employee() {
        $this->form_validation->set_rules('NPK', 'NPK', 'required|min_length[4]|max_length[6]|callback_check_id|trim');
        $this->form_validation->set_rules('NPK', 'NPK', 'required');

        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_employee();
        } else {
            $data = array(
                'NPK' => $this->input->post('NPK'),
                'NAMA' => strtoupper($this->input->post('NAME')),
                'KD_GROUP' => $this->input->post('GROUP'),
                'KD_DEPT' => $this->input->post('DEPT'),
                'KD_SECTION' => $this->input->post('SECTION'),
                'KD_SUB_SECTION' => $this->input->post('SUBSECTION'),
                'OPER_ENTRY' => $session['USERNAME'],
                'TGL_ENTRY' => date('Ymd'),
                'JAM_ENTRY' => date('His'),
                'FLAG_DELETE' => 0
            );
            $this->master_employee_m->save($data);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking Section 
    function check_id($id) {
        $return_value = $this->budgetsubcategory_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_employee($npk) {
        $this->role_module_m->authorization('9');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(28);
        $data['news'] = $this->news_m->get_news();
        $data['data_group'] = $this->master_data_m->get_group();
        $data['data_dept'] = $this->master_data_m->get_dept();
        $data['data_sect'] = $this->master_data_m->get_sect();
        $data['data_subsect'] = $this->master_data_m->get_subsect();

        $data['title'] = 'Edit Budget Sub category';
        $data['content'] = 'aorta/employee/edit_employee_v';

        $data['data'] = $this->master_employee_m->get_employee_by_npk($npk);

        $this->load->view($this->layout, $data);
    }

    function update_employee() {
        $npk = $this->input->post('NPK');
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('NAME', 'Name', 'required|min_length[2]|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_employee($npk);
        } else {
            $data = array(
                'NAMA' => strtoupper($this->input->post('NAME')),
                'KD_GROUP' => $this->input->post('GROUP'),
                'KD_DEPT' => $this->input->post('DEPT'),
                'KD_SECTION' => $this->input->post('SECTION'),
                'KD_SUB_SECTION' => $this->input->post('SUBSECTION'),
                'OPER_EDIT' => $session['USERNAME'],
                'TGL_EDIT' => date('Ymd'),
                'JAM_EDIT' => date('His')
            );
            $this->master_employee_m->update($data, $npk);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_employee($npk) {
        $this->role_module_m->authorization('9');
        $this->master_employee_m->delete($npk);
        redirect($this->back_to_manage . $msg = 2);
    }
    
    function enable_employee($npk) {
        $this->role_module_m->authorization('9');
        $this->master_employee_m->enable($npk);
        redirect($this->back_to_manage . $msg = 2);
    }

}

?>
