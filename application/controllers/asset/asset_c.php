<?php

class asset_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'asset/asset_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
        $this->load->model('asset/asset_m');
    }

    function index($msg = NULL) {
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
        $data['msg'] = $msg;
        $data['data'] = $this->asset_m->get_asset();
        $data['content'] = 'asset/manage_asset_v';
        $data['title'] = 'Manage  Asset';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(54);

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
        $data['data'] = $this->asset_m->get_data_asset($id)->row();
        $data['data_asset'] = $this->asset_m->get_asset();
        $data['content'] = 'asset/view_asset_v';
        $data['title'] = 'View Asset';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(54);

        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_asset() {
        $this->role_module_m->authorization('3');
        $data['content'] = 'asset/create_asset_v';
        $data['title'] = 'Create Asset';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(54);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_asset() {
        $this->form_validation->set_rules('CHR_ASSET_CODE', 'Asset Code', 'required|min_length[5]|max_length[5]|callback_check_id_asset|trim');
        $this->form_validation->set_rules('CHR_ASSET_NAME', 'Asset Name', 'required');
        $this->form_validation->set_rules('CHR_ASSET_DESC', 'Asset Desc', 'required');

        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_asset();
        } else {
            $data = array(
                'CHR_ASSET_CODE' => strtoupper($this->input->post('CHR_ASSET_CODE')),
                'CHR_ASSET_NAME' => $this->input->post('CHR_ASSET_NAME'),
                'CHR_ASSET_DESC' => $this->input->post('CHR_ASSET_DESC'),
//                'CHR_CREATE_BY' => $session['USERNAME'],
//                'CHR_CREATE_DATE' => date("Ymd"),
//                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 1
            );
            $this->asset_m->save_asset($data);
//            $this->log_m->add_log('39', $id);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //Checking asset id
    function check_id_asset($id) {
        $return_value = $this->asset_m->check_id_asset($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id_asset', "Sorry, Asset Code already exists, please input another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //prepare to editing
    function edit_asset($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->asset_m->get_data_asset($id)->row();
        $data['content'] = 'asset/edit_asset_v';
        $data['title'] = 'Edit  Asset';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(54);

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_asset() {
        $id = $this->input->post('INT_ID');
        $msg = 2;

        $this->form_validation->set_rules('CHR_ASSET_CODE', ' Asset Code', 'required|min_length[5]|max_length[5]|trim');
        $this->form_validation->set_rules('CHR_ASSET_NAME', ' Asset name', 'required');
        $this->form_validation->set_rules('CHR_ASSET_DESC', ' Asset Desc', 'required');
        
        $session = $this->session->all_userdata();
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit_asset($id);
        } else {
            $data = array(
                'CHR_ASSET_CODE' => strtoupper($this->input->post('CHR_ASSET_CODE')),
                'CHR_ASSET_NAME' => $this->input->post('CHR_ASSET_NAME'),
                'CHR_ASSET_DESC' => $this->input->post('CHR_ASSET_DESC')
//                'CHR_MODI_BY' => $session['USERNAME'],
//                'CHR_MODI_DATE' => date("Ymd"),
//                'CHR_MODI_TIME' => date("His")
            );
            $this->asset_m->update($data, $id);
//            $this->log_m->add_log('40', $id);

            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_asset($id) {
        $this->role_module_m->authorization('3');
        $this->asset_m->delete($id);
//        $this->log_m->add_log('41', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
