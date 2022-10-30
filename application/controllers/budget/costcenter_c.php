<?php

class costcenter_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/costcenter_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/costcenter_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/log_m');
        $this->load->model('portal/news_m');
    }

    //show all data
    function index($msg = NULL) {
        $this->role_module_m->authorization('13');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(13);
        $data['news'] = $this->news_m->get_news();


        $data['msg'] = $msg;

        $data['data'] = $this->costcenter_m->get_costcenter();
        $data['content'] = 'budget/costcenter/manage_costcenter_v';
        $data['title'] = 'Manage Cost Center';
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id_costcenter($id, $msg = null) {
        $this->load->model('organization/section_m');
        $this->role_module_m->authorization('13');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['msg'] = $msg;
        $data['data'] = $this->costcenter_m->get_data($id)->row();
        $data['data_section'] = $this->section_m->get_section_by_costcenter($id);
        $data['data_costcenter'] = $this->costcenter_m->get_costcenter();
        $data['content'] = 'budget/costcenter/view_costcenter_v';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(13);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'View Cost Center';

        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_costcenter() {
        $this->role_module_m->authorization('13');
        $data['content'] = 'budget/costcenter/create_costcenter_v';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(13);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Create Cost Center';

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_costcenter() {
        $this->form_validation->set_rules('CHR_COST_CENTER', 'Cost Center', 'required|min_length[6]|max_length[6]|callback_check_id|trim');
        $this->form_validation->set_rules('CHR_COST_CENTER_DESC', 'Cost Center Desc');

        $id = $this->costcenter_m->generate_id_cc();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_costcenter();
        } else {
            $data = array(
                'INT_ID_COST_CENTER' => $id,
                'CHR_COST_CENTER' => strtoupper($this->input->post('CHR_COST_CENTER')),
                'CHR_COST_CENTER_DESC' => $this->input->post('CHR_COST_CENTER_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 0
            );
            $this->costcenter_m->save($data);
            $this->log_m->add_log('51', $this->input->post('INT_ID_COST_CENTER'));
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking Cost Center id
    function check_id($id) {
        $return_value = $this->costcenter_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //prepare to editing
    function edit_costcenter($id) {
        $this->role_module_m->authorization('13');
        $data['data'] = $this->costcenter_m->get_data($id)->row();
        $data['content'] = 'budget/costcenter/edit_costcenter_v';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(13);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Edit Cost Center';
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_costcenter() {

        $id = $this->input->post('INT_ID_COST_CENTER');


        $this->form_validation->set_rules('CHR_COST_CENTER_DESC', 'Cost Center Desc');
        $this->form_validation->set_rules('CHR_COST_CENTER', 'Cost Center', 'required|min_length[6]|max_length[6]|trim');


        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_costcenter($id);
        } else {
            $data = array(
                'CHR_COST_CENTER' => strtoupper($this->input->post('CHR_COST_CENTER')),
                'CHR_COST_CENTER_DESC' => $this->input->post('CHR_COST_CENTER_DESC'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->costcenter_m->update($data, $id);
            $this->log_m->add_log('52', $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    //deleting data
    function delete_costcenter($id) {
        $this->role_module_m->authorization('13');
        $this->costcenter_m->delete($id);
        $this->log_m->add_log('53', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

    function moving_costcenter() {
        $this->load->model('organization/section_m');
        $id = $this->input->post('INT_ID_COST_CENTER');
        $data = array(
            'INT_ID_COST_CENTER' => $this->input->post('INT_ID_COST_CENTER_NEW')
        );
        $checked = $this->input->post('case');

        if ($checked == null) {
            redirect('budget/costcenter_c/select_by_id_costcenter/' . $id . '/' . 4);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->section_m->update($data, $checked[$i]);
        }
        redirect('budget/costcenter_c/select_by_id_costcenter/' . $id . '/' . 1);
    }

}
