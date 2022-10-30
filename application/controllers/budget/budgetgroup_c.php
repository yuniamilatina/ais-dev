<?php

class budgetgroup_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/budgetgroup_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budgetgroup_m');
        $this->load->model('budget/budgetsubgroup_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('5');
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
        $data['sidebar'] = $this->role_module_m->side_bar(5);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Budget Group';
        $data['msg'] = $msg;
        $data['data'] = $this->budgetgroup_m->get_budgetgroup();
        $data['content'] = 'budget/masterbudget/budgetgroup/manage_budgetgroup_v';
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('5');
        $data['data'] = $this->budgetgroup_m->get_data($id)->row();
        $data['data_budgetsubgroup'] = $this->budgetsubgroup_m->get_budgetsubgroup_by_budgetgroup($id);
        $data['content'] = 'budget/masterbudget/budgetgroup/view_budgetgroup_v';
        $data['title'] = 'View Budget Group';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(5);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function create_budgetgroup() {
        $this->role_module_m->authorization('5');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(5);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Create Budget Group';
        $data['content'] = 'budget/masterbudget/budgetgroup/create_budgetgroup_v';

        $this->load->view($this->layout, $data);
    }

    function save_budgetgroup() {
        $this->form_validation->set_rules('CHR_BUDGET_GROUP', 'Budget Group', 'required|min_length[5]|max_length[5]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_BUDGET_GROUP_DESC', 'Budget Group Desc', 'required');

        $id = $this->budgetgroup_m->generate_id_budgetgroup();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_budgetgroup();
        } else {
            $data = array(
                'INT_ID_BUDGET_GROUP' => $id,
                'CHR_BUDGET_GROUP' => strtoupper($this->input->post('CHR_BUDGET_GROUP')),
                'CHR_BUDGET_GROUP_DESC' => $this->input->post('CHR_BUDGET_GROUP_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date('Ymd'),
                'CHR_CREATE_TIME' => date('His'),
                'BIT_FLG_DEL' => 0
            );
            $this->budgetgroup_m->save($data);
            $this->log_m->add_log('3', $data['INT_ID_BUDGET_GROUP']);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking Section 
    function check_id($id) {
        $return_value = $this->budgetgroup_m->check_id($id, $this->level);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_budgetgroup($id) {
        $this->role_module_m->authorization('5');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(5);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Edit Budget Group';
        $data['content'] = 'budget/masterbudget/budgetgroup/edit_budgetgroup_v';

        $data['data'] = $this->budgetgroup_m->get_data($id)->row();

        $this->load->view($this->layout, $data);
    }

    function update_budgetgroup() {
        $id = $this->input->post('INT_ID_BUDGET_GROUP');
        $level = $this->level;
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_BUDGET_GROUP', 'Budget', 'required|min_length[5]|max_length[5]|trim');
        $this->form_validation->set_rules('CHR_BUDGET_GROUP_DESC', 'Budget Desc', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_budgetgroup($id, $level);
        } else {
            $data = array(
                'CHR_BUDGET_GROUP' => strtoupper($this->input->post('CHR_BUDGET_GROUP')),
                'CHR_BUDGET_GROUP_DESC' => $this->input->post('CHR_BUDGET_GROUP_DESC'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His'),
            );
            $this->budgetgroup_m->update($data, $id);
            $this->log_m->add_log('4', $data['INT_ID_BUDGET_GROUP']);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_budgetgroup($id) {
        $this->role_module_m->authorization('5');
        $this->budgetgroup_m->delete($id);
        $this->log_m->add_log('5', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}

?>
