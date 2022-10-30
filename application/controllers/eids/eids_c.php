<?php

class eids_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'eids/eids_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('eids/eids_m');
        $this->load->model('organization/dept_m');
    }

    function index($msg = NULL, $type = NULL) {
        $this->role_module_m->authorization('3');

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

        if($type == NULL){
            $type = 'ECI';
        }

        $data['msg'] = $msg;
        $data['data'] = $this->eids_m->get_eids($type);
        $data['content'] = 'eids/manage_eids_v';
        $data['title'] = 'EIDS';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(298);

        $data['type'] = $type;
        $data['all_type'] = $this->eids_m->get_eids_type();

        $this->load->view($this->layout, $data);
    }

    function select_by_id($id, $msg = NULL) {
        $this->role_module_m->authorization('3');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['msg'] = $msg;
        $data['data'] = $this->eids_m->get_data_eids($id)->row();
        $data['data_eids'] = $this->eids_m->get_eids();
        $data['content'] = 'eids/view_eids_v';
        $data['title'] = 'View In Line Scan';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(298);

        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_eids() {
        $this->role_module_m->authorization('3');
        $data['content'] = 'eids/create_eids_v';
        $data['title'] = 'Create Production Asset';

        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(298);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_eids() {
        $session = $this->session->all_userdata();

        // if ($this->form_validation->run() == FALSE) {
        //     $this->create_eids();
        // } else {
            $data = array(
                'doc_type' => strtoupper($this->input->post('doc_type')),
                'no_dok' => strtoupper($this->input->post('no_dok')),
                'CHR_CREATED_BY' => $session['USERNAME']
            );
            $this->eids_m->save_eids($data);
            exit();
            //redirect($this->back_to_manage . $msg = 1);
        // }
    }

    //prepare to editing
    function edit_eids($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->eids_m->get_data_eids($id)->row();
        $data['content'] = 'eids/edit_eids_v';
        $data['title'] = 'Edit Production Asset';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(298);
        
        $data['row_data_eids'] = $this->eids_m->get_data_detail_eids($id);
        
        $data['data_asset'] = $this->eids_m->get_available_asset();
        $data['data_work_center'] = $this->eids_m->get_work_center();
        $data['dept'] = $this->dept_m->get_all_prod_dept();

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_eids() {
        $id = $this->input->post('INT_ID');
        $msg = 2;

        $this->form_validation->set_rules('CHR_IP', 'IP Address', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_eids($id);
        } else {
            $data = array(
                'INT_ID_ASSET' => strtoupper($this->input->post('INT_ID_ASSET')),
                'CHR_WORK_CENTER' => strtoupper($this->input->post('CHR_WORK_CENTER')),
                'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT'),
                'CHR_IP' => $this->input->post('CHR_IP'),
                'CHR_USAGE' => $this->input->post('CHR_USAGE'),
            );
            $this->eids_m->update($data, $id);
//            $this->log_m->add_log('40', $id);
            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_eids($id) {
        $this->role_module_m->authorization('3');
        $this->eids_m->delete($id);
//        $this->log_m->add_log('41', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
