<?php

class problem_type_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'helpdesk_ticket/problem_type_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('helpdesk_ticket/problem_type_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('36');

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
        $data['data'] = $this->problem_type_m->get_problem_type();
        $data['content'] = 'helpdesk_ticket/problem_type/manage_problem_type_v';
        $data['title'] = 'Manage Problem Type';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(36);

        $this->load->view($this->layout, $data);
    }

//    function select_by_id($id_problem_type, $msg = NULL) {
//        $this->role_module_m->authorization('1');
//        if ($msg == 1) {
//            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving success </strong> Moving data success </div >";
//        } elseif ($msg == 4) {
//            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving failed </strong> You must select at least one data </div >";
//        } else {
//            $msg = NULL;
//        }
//
//        $data['msg'] = $msg;
//        $data['data'] = $this->problem_type_m->get_data_problem_type($id_problem_type)->row();
//        $data['content'] = 'helpdesk_ticket/problem_type/view_problem_type_v';
//        $data['title'] = 'View helpdesk_ticket';
//        
//        $data['app'] = $this->role_module_m->get_app();
//        $data['module'] = $this->role_module_m->get_module();
//        $data['function'] = $this->role_module_m->get_function();
//        
//        $this->load->view($this->layout, $data);
//    }

    function create_problem_type() {
        $this->role_module_m->authorization('36');
        $data['content'] = 'helpdesk_ticket/problem_type/create_problem_type_v';
        $data['title'] = 'Create Helpdesk Ticket';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(36);

        $this->load->view($this->layout, $data);
    }

    function save_problem_type() {
        $this->form_validation->set_rules('CHR_PROBLEM_TYPE', 'Problem Type Initial', 'required|min_length[3]|max_length[3]|callback_check_id_problem_type|trim');
        $this->form_validation->set_rules('CHR_PROBLEM_TYPE_DESC', 'Problem Type Desc', 'required|max_length[50]|trim');

        $id_problem_type = $this->problem_type_m->generate_id_problem_type();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_problem_type();
        } else {
            $data = array(
                'INT_ID_PROBLEM_TYPE' => $id_problem_type,
                'CHR_PROBLEM_TYPE' => strtoupper($this->input->post('CHR_PROBLEM_TYPE')),
                'CHR_PROBLEM_TYPE_DESC' => $this->input->post('CHR_PROBLEM_TYPE_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 0
            );
            $this->problem_type_m->save_problem_type($data);
            $this->log_m->add_log('39', $id_problem_type);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function check_id_problem_type($id_problem_type) {
        $return_value = $this->problem_type_m->check_id_problem_type($id_problem_type);
        if ($return_value) {
            $this->form_validation->set_message('check_id_problem_type', 'Sorry, This initial already exists, please choose another one');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_problem_type($id_problem_type) {
        $this->role_module_m->authorization('36');
        $data['data'] = $this->problem_type_m->get_data_problem_type($id_problem_type)->row();
        $data['content'] = 'helpdesk_ticket/problem_type/edit_problem_type_v';
        $data['title'] = 'Edit Problem Type';

        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(36);

        $this->load->view($this->layout, $data);
    }

    function update_problem_type() {
        $this->form_validation->set_rules('CHR_PROBLEM_TYPE', 'Problem Type Initial', 'required|min_length[3]|max_length[3]|trim');
        $this->form_validation->set_rules('CHR_PROBLEM_TYPE_DESC', 'Problem Type Desc', 'required|max_length[50]|trim');

        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_problem_type($this->input->post('INT_ID_PROBLEM_TYPE'));
        } else {
            $data = array(
                'CHR_PROBLEM_TYPE' => strtoupper($this->input->post('CHR_PROBLEM_TYPE')),
                'CHR_PROBLEM_TYPE_DESC' => $this->input->post('CHR_PROBLEM_TYPE_DESC'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->problem_type_m->update_problem_type($data, $this->input->post('INT_ID_PROBLEM_TYPE'));
            $this->log_m->add_log('40', $this->input->post('INT_ID_PROBLEM_TYPE'));

            redirect($this->back_to_manage . 2);
        }
    }

    function delete_problem_type($id_problem_type) {
        $this->role_module_m->authorization('36');
        $this->problem_type_m->delete_problem_type($id_problem_type);
        $this->log_m->add_log('41', $id_problem_type);
        redirect($this->back_to_manage . $msg = 3);
    }

}
