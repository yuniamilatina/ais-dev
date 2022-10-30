<?php

class application_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'app/application_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('app/application_m');

    }

    function index($msg = NULL) {
        //$this->role_module_m->authorization('1');

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
        $data['data'] = $this->application_m->get_application();
        $data['content'] = 'app/application/manage_application_v';
        $data['title'] = 'Manage Application';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(178);
        
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_application() {
        //$this->role_module_m->authorization('177');
        $data['content'] = 'app/application/manage_misdoc_v';
        //$data['title'] = 'Create MIS Doc';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(178);
        
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_application() {
        $this->form_validation->set_rules('CHR_APP', 'Part No Assy Initial', 'required|min_length[5]|max_length[20]');
        
        $id = $this->application_m->generate_id_app();
        //$session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->create_application();
        } else {
            $data = array(
                'INT_ID_APP' => $id,
                'CHR_APP' => $this->input->post('CHR_APP'),
                'CHR_ICON' => $this->input->post('CHR_ICON')
               
            );
            $this->application_m->save_application($data);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    //prepare to editing
    function edit_application($id, $msg = NULL) {
        //$this->role_module_m->authorization('177');
        $data['data'] = $this->application_m->get_data_application($id)->row();
        $data['content'] = 'app/application/edit_application_v';
        $data['title'] = 'Edit Application';
        //$data['data_company'] = $this->company_m->get_company();
        $data['msg'] = $msg;
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(178);
        
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_application() {
        $id = $this->input->post('INT_ID_APP');
        $msg = 2;
        $this->form_validation->set_rules('CHR_APP', 'Application Name', 'required|min_length[5]|max_length[20]');
		
        //$session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_application($id);
        } else {
            $data = array(
                'CHR_APP' => $this->input->post('CHR_APP'),
                'CHR_ICON' => $this->input->post('CHR_ICON')			
            );
            $this->application_m->update_application($data, $id);
            //$this->log_m->add_log('40', $id);
            redirect($this->back_to_manage . $msg);
        }
    }

    function delete_application($id) {
        //$this->role_module_m->authorization('177');
        $this->application_m->delete_application($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
