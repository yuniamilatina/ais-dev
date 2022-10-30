<?php

class ines_c extends CI_Controller {

    private $layout = '/template/head_blank';
    private $back_to_manage = 'ines/ines_c/index/';
    public $id_app = '27';
    public $id_module = '14';
    public $id_function = '55';

    public function __construct() {
        parent::__construct();
        $this->load->model('ines/ines_m');
        $this->load->model('asset/asset_m');
        $this->load->model('organization/dept_m');
        $this->load->model('helpdesk_ticket/prover_m');
        
    }

    function index($msg = NULL) {

        $this->role_module_m->authorization('3');

        $this->load->model('portal/notification_m');
        $session = $this->session->all_userdata();

        $this->notification_m->has_be_read_by_npk_and_function($session['NPK'],$this->id_function );

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->ines_m->get_inlinescan();
        $data['content'] = 'ines/manage_ines_v';
        $data['title'] = 'Manage  In Line Scan';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar($this->id_function);

        $this->load->view($this->layout, $data);
    }
    
    function get_data_device(){
        $data_device['data'] = $this->ines_m->get_inlinescan();

        echo json_encode($data_device);
    }

    function select_by_id($id, $msg = NULL) {
        $this->role_module_m->authorization('3');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['msg'] = $msg;
        $data['data'] = $this->ines_m->get_data_inlinescan($id)->row();
        $data['data_ines'] = $this->ines_m->get_inlinescan();
        $data['content'] = 'ines/view_ines_v';
        $data['title'] = 'View In Line Scan';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar($this->id_function);

        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_ines() {
        $this->role_module_m->authorization('3');
        $data['content'] = 'ines/create_ines_v';
        $data['title'] = 'Create Production Asset';

        $data['data_asset'] = $this->ines_m->get_asset();
        $data['data_work_center'] = $this->ines_m->get_work_center_device();
        $data['dept'] = $this->dept_m->get_all_dept();
        $data['data_group_product'] = $this->ines_m->get_group_product();
        
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar($this->id_function);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_ines() {
        $this->form_validation->set_rules('CHR_IP', 'IP Address', 'required');
        $this->form_validation->set_rules('CHR_USAGE', 'Usage', 'required');

        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_ines();
        } else {
            $data = array(
                'INT_ID_ASSET' => strtoupper($this->input->post('INT_ID_ASSET')),
                'CHR_WORK_CENTER' => strtoupper($this->input->post('CHR_WORK_CENTER')),
                'CHR_GROUP_PRODUCT' => $this->input->post('CHR_GROUP_PRODUCT'),
                'CHR_ASSET_CODE' => strtoupper($this->input->post('CHR_ASSET_CODE')),
                'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT'),
                'CHR_IP' => $this->input->post('CHR_IP'),
                'CHR_PORT' => $this->input->post('CHR_PORT'),
                'CHR_URL' => $this->input->post('CHR_URL'),
                'CHR_USAGE' => $this->input->post('CHR_USAGE'),
                'CHR_CREATED_BY' => $session['USERNAME']
            );
            $this->ines_m->save_ines($data);

            $result = $this->prover_m->get_prover();
            foreach ($result as $row) {
                $seq_id = $this->notification_m->generate_id();

                $data_notif = array(
                    'INT_ID_NOTIF' => $seq_id,
                    'CHR_NPK' => $row->CHR_NPK,
                    'INT_ID_APP' => $this->id_app,
                    'INT_ID_MODULE' => $this->id_module,
                    'INT_ID_FUNCTION' => $this->id_function,
                    'CHR_NOTIF_TITLE' => 'Open Ticket By ' . trim($session['USERNAME']),
                    'CHR_NOTIF_DESC' => 'Registration Device',
                    'CHR_LINK' => "ines/ines_c",
                    'CHR_CREATED_BY' => 'System',
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );

                $this->notification_m->insert_notification($data_notif);
            }

//            $this->log_m->add_log('39', $id);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //prepare to editing
    function edit_ines($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->ines_m->get_data_inlinescan($id)->row();
        $data['content'] = 'ines/edit_ines_v';
        $data['title'] = 'Edit Production Asset';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar($this->id_function);
        
        $data['row_data_ines'] = $this->ines_m->get_data_detail_inlinescan($id);
        $data['data_group_product'] = $this->ines_m->get_group_product();
        $data['data_asset'] = $this->ines_m->get_asset();
        $data['data_work_center'] = $this->ines_m->get_work_center_device();
        $data['dept'] = $this->dept_m->get_all_dept();

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_ines() {
        $id = $this->input->post('INT_ID');
        $msg = 2;

        $this->form_validation->set_rules('CHR_IP', 'IP Address', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_ines($id);
        } else {
            $data = array(
                'INT_ID_ASSET' => strtoupper($this->input->post('INT_ID_ASSET')),
                'CHR_WORK_CENTER' => strtoupper($this->input->post('CHR_WORK_CENTER')),
                'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT'),
                'CHR_GROUP_PRODUCT' => $this->input->post('CHR_GROUP_PRODUCT'),
                'CHR_ASSET_CODE' => strtoupper($this->input->post('CHR_ASSET_CODE')),
                'CHR_IP' => $this->input->post('CHR_IP'),
                'CHR_PORT' => $this->input->post('CHR_PORT'),
                'CHR_URL' => $this->input->post('CHR_URL'),
                'CHR_USAGE' => $this->input->post('CHR_USAGE'),
            );
            $this->ines_m->update($data, $id);
//            $this->log_m->add_log('40', $id);
            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_ines($id) {
        $this->role_module_m->authorization('3');
        $this->ines_m->delete($id);
//        $this->log_m->add_log('41', $id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
