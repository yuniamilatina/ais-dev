<?php

class budgettype_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/budgettype_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budgetsubgroup_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('7');
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
        $data['sidebar'] = $this->role_module_m->side_bar(7);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Budget Type';
        $data['msg'] = $msg;
        $data['data'] = $this->budgettype_m->get_budgettype();
        $data['content'] = 'budget/masterbudget/budgettype/manage_budgettype_v';
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('7');
        $data['data'] = $this->budgettype_m->get_data($id)->row();
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory_by_budgettype($id);
        $data['content'] = 'budget/masterbudget/budgettype/view_budgettype_v';
        $data['title'] = 'View Budget Type';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(7);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function create_budgettype() {
        $this->role_module_m->authorization('7');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(7);
        $data['data_budgetsubgroup'] = $this->budgetsubgroup_m->get_budgetsubgroup();
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Create Budget Type';
        $data['content'] = 'budget/masterbudget/budgettype/create_budgettype_v';

        $this->load->view($this->layout, $data);
    }

    function save_budgettype() {
        $this->form_validation->set_rules('CHR_BUDGET_TYPE', 'Budget Type', 'required|min_length[5]|max_length[5]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_BUDGET_TYPE_DESC', 'Budget Type Desc', 'required');

        $id = $this->budgettype_m->generate_id_budgettype();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_budgettype();
        } else {
            $data = array(
                'INT_ID_BUDGET_TYPE' => $id,
                'CHR_BUDGET_TYPE' => strtoupper($this->input->post('CHR_BUDGET_TYPE')),
                'CHR_BUDGET_TYPE_DESC' => $this->input->post('CHR_BUDGET_TYPE_DESC'),
                'INT_ID_BUDGET_SUB_GROUP' => $this->input->post('INT_ID_BUDGET_SUBGROUP'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date('Ymd'),
                'CHR_CREATE_TIME' => date('His'),
                'BIT_FLG_DEL' => 0
            );
            $this->budgettype_m->save($data);
            $this->log_m->add_log('3', $data['INT_ID_BUDGET_TYPE']);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking Section 
    function check_id($id) {
        $return_value = $this->budgettype_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_budgettype($id) {
        $this->role_module_m->authorization('7');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(7);
        $data['data_budgettype'] = $this->budgettype_m->get_data($id);
        $data['data_budgetsubgroup'] = $this->budgetsubgroup_m->get_budgetsubgroup();
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Edit Budget Type';
        $data['content'] = 'budget/masterbudget/budgettype/edit_budgettype_v';

        $data['data'] = $this->budgettype_m->get_data($id)->row();

        $this->load->view($this->layout, $data);
    }

    function update_budgettype() {
        $id = $this->input->post('INT_ID_BUDGET_TYPE');
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_BUDGET_TYPE', 'Budget', 'required|min_length[5]|max_length[5]|trim');
        $this->form_validation->set_rules('CHR_BUDGET_TYPE_DESC', 'Budget Desc', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_budgettype($id);
        } else {
            $data = array(
                'CHR_BUDGET_TYPE' => strtoupper($this->input->post('CHR_BUDGET_TYPE')),
                'CHR_BUDGET_TYPE_DESC' => $this->input->post('CHR_BUDGET_TYPE_DESC'),
                'INT_ID_BUDGET_SUB_GROUP' => $this->input->post('INT_ID_BUDGET_SUBGROUP'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His'),
            );
            $this->budgettype_m->update($data, $id);
            $this->log_m->add_log('4', $data['INT_ID_BUDGET_TYPE']);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_budgettype($id) {
        $this->role_module_m->authorization('7');
        $this->budgettype_m->delete($id);
        $this->log_m->add_log('5', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}

?>
