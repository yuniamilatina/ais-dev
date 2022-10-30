<?php

class company_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'organization/company_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/company_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('1');

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
        $data['data'] = $this->company_m->get_company();
        $data['content'] = 'organization/company/manage_company_v';
        $data['title'] = 'Manage Company';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(24);
        $data['news'] = $this->news_m->get_news();
        
        $this->load->view($this->layout, $data);
    }

    function select_by_id($id, $msg = NULL) {
        $this->load->model('organization/division_m');
        $this->role_module_m->authorization('1');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['msg'] = $msg;
        $data['data'] = $this->company_m->get_data_company($id)->row();
        $data['data_division'] = $this->division_m->get_data_division_by_company($id)->result();
        $data['data_company'] = $this->company_m->get_company();
        $data['content'] = 'organization/company/view_company_v';
        $data['title'] = 'View Company';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(24);
        
        $this->load->view($this->layout, $data);
    }

    function create_company() {
        $this->role_module_m->authorization('1');
        $data['content'] = 'organization/company/create_company_v';
        $data['title'] = 'Create Company';
        $data['company'] = $this->company_m->get_company();
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(24);
        
        $this->load->view($this->layout, $data);
    }

    function save_company() {
        $this->form_validation->set_rules('CHR_COMPANY', 'Company Initial', 'required|min_length[3]|max_length[3]|callback_check_id_company|trim');
        $this->form_validation->set_rules('CHR_COMPANY_DESC', 'Company Desc', 'required');

        $id = $this->company_m->generate_id_company();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_company();
        } else {
            $data = array(
                'INT_ID_COMPANY' => $id,
                'CHR_COMPANY' => strtoupper($this->input->post('CHR_COMPANY')),
                'CHR_COMPANY_DESC' => $this->input->post('CHR_COMPANY_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 0
            );
            $this->company_m->save_company($data);
            $this->log_m->add_log('39', $id);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function check_id_company($id) {
        $return_value = $this->company_m->check_id_company($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id_company', 'Sorry, This initial already exists, please choose another one');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_company($id) {
        $this->role_module_m->authorization('1');
        $data['data'] = $this->company_m->get_data_company($id)->row();
        $data['content'] = 'organization/company/edit_company_v';
        $data['title'] = 'Edit Company';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(24);
        
        $this->load->view($this->layout, $data);
    }

    function update_company() {
        $id = $this->input->post('INT_ID_COMPANY');
        $msg = 2;

        $this->form_validation->set_rules('CHR_COMPANY', 'Company Initial', 'required|min_length[3]|max_length[3]|trim');
        $this->form_validation->set_rules('CHR_COMPANY_DESC', 'Company Desc', 'required');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_company($id);
        } else {
            $data = array(
                'CHR_COMPANY' => strtoupper($this->input->post('CHR_COMPANY')),
                'CHR_COMPANY_DESC' => $this->input->post('CHR_COMPANY_DESC'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->company_m->update_company($data, $id);
            $this->log_m->add_log('40', $id);

            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_company($id) {
        $this->role_module_m->authorization('1');
        $this->company_m->delete_company($id);
        $this->log_m->add_log('41', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function moving_company() {
        $this->load->model('organization/division_m');
        $id = $this->input->post('INT_ID_COMPANY');
        $checked = $this->input->post('case');
        $data = array(
            'INT_ID_COMPANY' => $this->input->post('INT_ID_COMPANY_NEW')
        );

        if ($checked == null) {
            redirect('organization/company_c/select_by_id/' . $id . '/' . 4);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->division_m->update($data, $checked[$i]);
        }
        redirect('organization/company_c/select_by_id/' . $id . '/' . 1);
    }

}
