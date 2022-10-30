<?php

class budgetcategory_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/budgetcategory_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budgetsubcategory_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/budgettype_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('8');
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
        $data['sidebar'] = $this->role_module_m->side_bar(8);
        $data['news'] = $this->news_m->get_news();


        $data['title'] = 'Manage Budget Group';
        $data['msg'] = $msg;
        $data['data'] = $this->budgetcategory_m->get_budgetcategory();
        $data['content'] = 'budget/masterbudget/budgetcategory/manage_budgetcategory_v';
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('8');
        $data['data'] = $this->budgetcategory_m->get_data($id)->row();
        $data['data_budgetsubcategory'] = $this->budgetsubcategory_m->get_budgetsubcategory_by_budgetcategory($id);
        $data['content'] = 'budget/masterbudget/budgetcategory/view_budgetcategory_v';
        $data['title'] = 'View Budget Group';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(8);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function create_budgetcategory() {
        $this->role_module_m->authorization('8');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(8);
        $data['news'] = $this->news_m->get_news();

        $data['data_budgettype'] = $this->budgettype_m->get_budgettype();


        $data['title'] = 'Create Budget Group';
        $data['content'] = 'budget/masterbudget/budgetcategory/create_budgetcategory_v';

        $this->load->view($this->layout, $data);
    }

    function save_budgetcategory() {
        $this->form_validation->set_rules('CHR_BUDGET_CATEGORY', 'Budget Group', 'required|min_length[7]|max_length[7]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_BUDGET_CATEGORY_DESC', 'Budget Group Desc', 'required');

        $id = $this->budgetcategory_m->generate_id_budgetcategory();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_budgetcategory();
        } else {
            $data = array(
                'INT_ID_BUDGET_CATEGORY' => $id,
                'CHR_BUDGET_CATEGORY' => strtoupper($this->input->post('CHR_BUDGET_CATEGORY')),
                'CHR_BUDGET_CATEGORY_DESC' => $this->input->post('CHR_BUDGET_CATEGORY_DESC'),
                'INT_ID_BUDGET_TYPE' => $this->input->post('INT_ID_BUDGET_TYPE'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date('Ymd'),
                'CHR_CREATE_TIME' => date('His'),
                'BIT_FLG_DEL' => 0
            );
            $this->budgetcategory_m->save($data);
            $this->log_m->add_log('3', $data['INT_ID_BUDGET_CATEGORY']);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking Section 
    function check_id($id) {
        $return_value = $this->budgetcategory_m->check_id($id, $this->level);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_budgetcategory($id) {
        $this->role_module_m->authorization('8');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(8);
        $data['news'] = $this->news_m->get_news();
        $data['data_budgettype'] = $this->budgettype_m->get_budgettype();

        $data['title'] = 'Edit Budget Group';
        $data['content'] = 'budget/masterbudget/budgetcategory/edit_budgetcategory_v';

        $data['data'] = $this->budgetcategory_m->get_data($id)->row();

        $this->load->view($this->layout, $data);
    }

    function update_budgetcategory() {
        $id = $this->input->post('INT_ID_BUDGET_CATEGORY');
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_BUDGET_CATEGORY', 'Budget', 'required|min_length[7]|max_length[7]|trim');
        $this->form_validation->set_rules('CHR_BUDGET_CATEGORY_DESC', 'Budget Desc', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_budgetcategory($id);
        } else {
            $data = array(
                'CHR_BUDGET_CATEGORY' => strtoupper($this->input->post('CHR_BUDGET_CATEGORY')),
                'CHR_BUDGET_CATEGORY_DESC' => $this->input->post('CHR_BUDGET_CATEGORY_DESC'),
                'INT_ID_BUDGET_TYPE' => $this->input->post('INT_ID_BUDGET_TYPE'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His'),
            );
            $this->budgetcategory_m->update($data, $id);
            $this->log_m->add_log('4', $data['INT_ID_BUDGET_CATEGORY']);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_budgetcategory($id) {
        $this->role_module_m->authorization('8');
        $this->budgetcategory_m->delete($id);
        $this->log_m->add_log('5', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}

?>
