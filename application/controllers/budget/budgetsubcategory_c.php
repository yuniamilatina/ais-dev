<?php

class budgetsubcategory_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/budgetsubcategory_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budgetgroup_m');
        $this->load->model('budget/budgetsubcategory_m');
        $this->load->model('budget/budgetcategory_m');
        $this->load->model('budget/budgetcategory_a3_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    function index($msg = NULL) {
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

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(9);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Budget Sub category';
        $data['msg'] = $msg;
        $data['data'] = $this->budgetsubcategory_m->get_budgetsubcategory();
        $data['content'] = 'budget/masterbudget/budgetsubcategory/manage_budgetsubcategory_v';
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
        $data['sidebar'] = $this->role_module_m->side_bar(9);
        $data['news'] = $this->news_m->get_news();


        $this->load->view($this->layout, $data);
    }

    function create_budgetsubcategory() {
        $this->role_module_m->authorization('9');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(9);
        $data['news'] = $this->news_m->get_news();

        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory();
        $data['data_category_a3'] = $this->budgetcategory_a3_m->get_budgetcategory_a3();

        $data['title'] = 'Create Budget Sub category';
        $data['content'] = 'budget/masterbudget/budgetsubcategory/create_budgetsubcategory_v';

        $this->load->view($this->layout, $data);
    }

    function save_budgetsubcategory() {
        $this->form_validation->set_rules('CHR_BUDGET_SUB_CATEGORY', 'Budget Sub category', 'required|min_length[7]|max_length[7]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_BUDGET_SUB_CATEGORY_DESC', 'Budget Sub category Desc', 'required');

        $id = $this->budgetsubcategory_m->generate_id_budgetsubcategory();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_budgetsubcategory();
        } else {
            $data = array(
                'INT_ID_BUDGET_SUB_CATEGORY' => $id,
                'CHR_BUDGET_SUB_CATEGORY' => strtoupper($this->input->post('CHR_BUDGET_SUB_CATEGORY')),
                'CHR_BUDGET_SUB_CATEGORY_DESC' => $this->input->post('CHR_BUDGET_SUB_CATEGORY_DESC'),
                'INT_ID_BUDGET_CATEGORY' => $this->input->post('INT_ID_BUDGET_CATEGORY'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date('Ymd'),
                'CHR_CREATE_TIME' => date('His'),
                'BIT_FLG_DEL' => 0
            );
            $this->budgetsubcategory_m->save($data);
            $this->log_m->add_log('3', $data['INT_ID_BUDGET_SUB_CATEGORY']);
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

    function edit_budgetsubcategory($id) {
        $this->role_module_m->authorization('9');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(9);
        $data['news'] = $this->news_m->get_news();
        $data['data_budgetcategory'] = $this->budgetcategory_m->get_budgetcategory();
        $data['data_category_a3'] = $this->budgetcategory_a3_m->get_budgetcategory_a3();

        $data['title'] = 'Edit Budget Sub category';
        $data['content'] = 'budget/masterbudget/budgetsubcategory/edit_budgetsubcategory_v';

        $data['data'] = $this->budgetsubcategory_m->get_data($id)->row();

        $this->load->view($this->layout, $data);
    }

    function update_budgetsubcategory() {
        $id = $this->input->post('INT_ID_BUDGET_SUB_CATEGORY');
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_BUDGET_SUB_CATEGORY', 'Budget', 'required|min_length[7]|max_length[7]|trim');
        $this->form_validation->set_rules('CHR_BUDGET_SUB_CATEGORY_DESC', 'Budget Desc', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_budgetsubcategory($id);
        } else {
            $data = array(
                'CHR_BUDGET_SUB_CATEGORY' => strtoupper($this->input->post('CHR_BUDGET_SUB_CATEGORY')),
                'CHR_BUDGET_SUB_CATEGORY_DESC' => $this->input->post('CHR_BUDGET_SUB_CATEGORY_DESC'),
                'INT_ID_BUDGET_CATEGORY' => $this->input->post('INT_ID_BUDGET_CATEGORY'),
                'INT_ID_CATEGORY_A3' => $this->input->post('INT_ID_BUDGET_CATEGORY_A3'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date('Ymd'),
                'CHR_MODI_TIME' => date('His'),
            );
            $this->budgetsubcategory_m->update($data, $id);
            $this->log_m->add_log('4', $data['INT_ID_BUDGET_SUB_CATEGORY']);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function delete_budgetsubcategory($id) {
        $this->role_module_m->authorization('9');
        $this->budgetsubcategory_m->delete($id);
        $this->log_m->add_log('5', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}

?>
