<?php

class dies_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'eng/dies_c/index/';
    private $back_to_manage_dies = 'eng/dies_c/master_dies/';

    public function __construct() {
        parent::__construct();
        $this->load->model('eng/rfid_dies_m');
        $this->load->model('eng/dies_m');

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
        $data['data'] = $this->rfid_dies_m->get_master_rfid_dies();  
        $data['content'] = 'eng/master_rfid_dies_v';
        $data['title'] = 'Manage Master RFID Dies';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(312);

        $this->load->view($this->layout, $data);
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] == '') {
            redirect(base_url('index.php/login_c'));
        }
    }

    //prepare to create
    function create_master_rfid_dies() {
        $data['content'] = 'eng/create_master_rfid_dies_v';
        $data['title'] = 'Create Master RFID Dies';

        $data['dies'] = $this->dies_m->get_data_dies();

        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(312);
        
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_master_rfid_dies() {
        $this->form_validation->set_rules('CHR_PART_NO', 'Part Number', 'required|callback_check_id_rfid_dies|trim');
        $this->form_validation->set_rules('CHR_BACK_NO', 'Back Number', 'required|trim');
        $this->form_validation->set_rules('CHR_PART_MODEL', 'Product Marking', 'required|trim');

        // $id = $this->division_m->generate_id_division();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_master_rfid_dies();
        } else {
            $data = array(
                'INT_ID_PART_DIES' => $this->input->post('INT_ID_PART_DIES'),
                'CHR_CREATED_BY' => $session['USERNAME'],
                'CHR_PART_NO' => strtoupper($this->input->post('CHR_PART_NO')),
                'CHR_BACK_NO' => strtoupper($this->input->post('CHR_BACK_NO')),
                'CHR_PART_MODEL' => strtoupper($this->input->post('CHR_PART_MODEL')),
                'CHR_DIES_CODE' => $this->dies_m->get_data_by_id($this->input->post('INT_ID_PART_DIES')),
                'CHR_RFID_CODE' => strtoupper($this->input->post('CHR_RFID_CODE')),
                'INT_FLG_DEL' => 0
            );
            $this->rfid_dies_m->save_master_rfid_dies($data);
            $this->log_m->add_log('39', $id);
            redirect($this->back_to_manage . $msg = 1);
        }

    }

    //Checking twist id
    function check_id_rfid_dies($id) {
        $return_value = $this->rfid_dies_m->check_id_rfid_dies($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id_twist', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }
    //prepare to editing
    function edit_master_rfid_dies($id) {
        $this->role_module_m->authorization('3');
        $data['data'] = $this->rfid_dies_m->get_data_rfid_dies($id)->row();
        $data['content'] = 'eng/edit_master_rfid_dies_v';
        $data['title'] = 'Edit Master RFID Dies';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(312);
   
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_master_rfid_dies() {
        $id = $this->input->post('CHR_PART_NO');
        $msg = 2;

        $this->form_validation->set_rules('CHR_PART_MODEL', 'Product Marking','required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_master_rfid_dies($id);
        } else {
            $data = array(
                'CHR_MODIFIED_BY' => $session['USERNAME'],
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His'),
                'INT_ID_PART_DIES' => strtoupper($this->input->post('INT_ID_PART_DIES')),
                'CHR_PART_NO' => strtoupper($this->input->post('CHR_PART_NO')),
                'CHR_BACK_NO' => strtoupper($this->input->post('CHR_BACK_NO')),
                'CHR_PART_MODEL' => strtoupper($this->input->post('CHR_PART_MODEL')),
                'CHR_DIES_CODE' => strtoupper($this->input->post('CHR_DIES_CODE')),
                'CHR_RFID_CODE' => strtoupper($this->input->post('CHR_RFID_CODE')),
            );
            $this->rfid_dies_m->update($data, $id);
            
        }
        redirect($this->back_to_manage . $msg);
    }

    //delete data
    function delete_master_rfid_dies($id) {
        $this->role_module_m->authorization('3');
        $this->rfid_dies_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

    //MASTER DIES
    function master_dies($msg = NULL) {

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Duplicate data</strong> The data is unsuccessfully created </div >";
        }

        $data['msg'] = $msg;
        $data['data'] = $this->dies_m->get_dies();  
        $data['content'] = 'eng/master_dies_v';
        $data['title'] = 'Manage Master Dies';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(311);

        $this->load->view($this->layout, $data);
    }

    function save_dies() {
        $session = $this->session->all_userdata();

        $return_value = $this->dies_m->check_dies(strtoupper($this->input->post('CHR_DIES_CODE')));

        if ($return_value == TRUE) {
            $this->master_dies(4);
        } else {
            $data = array(
                'CHR_CREATED_BY' => $session['USERNAME'],
                'CHR_CREATED_DATE' => date('Ymd'),
                'CHR_CREATED_TIME' => date('His'),
                'CHR_DIES_CODE' => strtoupper($this->input->post('CHR_DIES_CODE')),
                'CHR_DIES_NAME' => strtoupper($this->input->post('CHR_DIES_NAME')),
                'CHR_DIES_DESC' => strtoupper($this->input->post('CHR_DIES_DESC')),
                'INT_FLG_DEL' => 0
            );
            $this->dies_m->save_dies($data);
            redirect($this->back_to_manage_dies . $msg = 1);
        }
            
    }

    function update_dies() {
        $dies_name = $this->input->post('CHR_DIES_NAME');
        $dies_desc = $this->input->post('CHR_DIES_DESC');

        $id = array(
            'INT_ID' => $this->input->post('INT_ID'),
        );

        $data = array(
            'CHR_MODIFIED_BY' => $session['USERNAME'],
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His'),
            'CHR_DIES_NAME' => strtoupper($dies_name),
            'CHR_DIES_DESC' => strtoupper($dies_desc)
        );

        $this->dies_m->update($data, $id);

        redirect($this->back_to_manage_dies . 2);
    }

    function delete_dies($id) {
        $this->dies_m->delete($id);
        redirect($this->back_to_manage_dies . $msg = 3);
    }

}
