<?php

class master_model_twist_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'eng/master_model_twist_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('eng/master_model_twist_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('part/process_part_m');

    }

    function index($msg = NULL) {

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
        $data['data'] = $this->master_model_twist_m->get_master_twist();  
        $data['content'] = 'eng/master_model_twist_v';
        $data['title'] = 'Manage Master Model Twist';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(99);

        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_master_model_twist() {
        $this->role_module_m->authorization('1');
        $data['content'] = 'eng/create_master_model_twist_v';
        $data['title'] = 'Create Master Model Twist';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(99);
        
        $data['all_work_centers'] = $this->direct_backflush_general_m->get_all_work_center_ines();
        $data['part_no_aisin'] = $this->process_part_m->get_data_part_by_workcenter('ASCA01');

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_master_model_twist() {
        $this->form_validation->set_rules('CHR_MODEL', 'Master Model Program', 'required');
        $this->form_validation->set_rules('CHR_MARKING', 'Marking Product', 'required');
        $this->form_validation->set_rules('CHR_PART_NO', 'Part Number', 'required');
        $this->form_validation->set_rules('CHR_MODEL_DESCRIPTION', 'Master Model Description', 'required');

        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_master_model_twist();
        } else {
            $data = array(
                'CHR_CREATED_BY' => $session['USERNAME'],
                'CHR_MODEL' => strtoupper($this->input->post('CHR_MODEL')),
                'CHR_WORK_CENTER' => strtoupper($this->input->post('CHR_WORK_CENTER')),
                'CHR_PART_NO' => strtoupper($this->input->post('CHR_PART_NO')),
                'CHR_MARKING' => strtoupper($this->input->post('CHR_MARKING')),
                'CHR_MODEL_DESCRIPTION' => strtoupper($this->input->post('CHR_MODEL_DESCRIPTION')),
                'BIT_FLG_DEL' => 0
            );
            $this->master_model_twist_m->save_master_model_twist($data);
            redirect($this->back_to_manage . $msg = 1);
        }

    }

    //Checking twist id
    function check_id_twist($id) {
        $return_value = $this->master_model_twist_m->check_id_twist($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id_twist', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }
    //prepare to editing
    function edit_master_model_twist($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->master_model_twist_m->get_data_twist($id)->row();
        $data['content'] = 'eng/edit_master_model_v';
        $data['title'] = 'Edit Master Model Twist';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(99);
   
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_master_model_twist() {
        $id = $this->input->post('INT_ID');
        $msg = 2;

        $this->form_validation->set_rules('CHR_MODEL', 'Master Model Program','required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_master_model_twist($id);
        } else {
            $data = array(
                'CHR_WORK_CENTER' => strtoupper($this->input->post('CHR_WORK_CENTER')),
                'CHR_MODEL' => strtoupper($this->input->post('CHR_MODEL')),
                'CHR_MODEL_DESCRIPTION' => strtoupper($this->input->post('CHR_MODEL_DESCRIPTION')),
                'CHR_PART_NO' => strtoupper($this->input->post('CHR_PART_NO')),
                'CHR_MARKING' => strtoupper($this->input->post('CHR_MARKING')),
            );
            $this->master_model_twist_m->update($data, $id);
            
        }
        redirect($this->back_to_manage . $msg);
    }

    //delete data
    function delete_master_model_twist($id) {
        $this->role_module_m->authorization('3');
        $this->master_model_twist_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
