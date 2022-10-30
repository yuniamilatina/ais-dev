<?php

class module_c extends CI_Controller {
    
    private $layout = '/template/head';
    private $back_to_manage = 'role_module/module_c/index/';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('app/module_m');
    }
    
    function index($msg = NULL) {
        //$this->role_module_m->authorization('15');
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
        $data['data'] = $this->module_m->get_module();
        $data['content'] = 'app/module/manage_module_v';
        $data['title'] = 'Manage Module';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(177);
        // $data['data_application'] = $this->module_m->get_data_app();
        
        $this->load->view($this->layout, $data);
    }
    
    function save_module() {
        $this->form_validation->set_rules('CHR_MODULE', 'Module', 'required|min_length[5]|max_length[20]');
        $id = $this->module_m->get_new_id_module();
        //$session = $this->session->all_userdata();
        $data = array(
            'INT_ID_MODULE' => $id,
            'INT_ID_APP' => $this->input->post('INT_ID_APP'),
            'CHR_MODULE' => $this->input->post('CHR_MODULE'),
            'INT_LEVEL' => $this->input->post('INT_LEVEL')
        );
        $this->module_m->save_module($data);
        redirect($this->back_to_manage . $msg = 1);        
    }

    function edit_module($id) {
	$this->role_module_m->authorization('15');
        $data['data'] = $this->module_m->get_data_module($id)->row();
        
        $data['data_application'] = $this->module_m->get_data_app();
        $data['row_data_app'] = $this->module_m->get_data_edit_app($id);
        
        $data['data_level'] = $this->module_m->get_data_level();
        $data['row_data_level'] = $this->module_m->get_data_edit_level($id);
        
        $data['content'] = 'app/module/edit_module_v';
        $data['title'] = 'Edit Module';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(177);
		
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_module() {
        $id = $this->input->post('INT_ID_MODULE');
        $this->form_validation->set_rules('CHR_MODULE', 'MODULE', 'required|min_length[5]|max_length[25]');
		
        //$session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_module($id);
        } else {
            $data = array(    
                'INT_ID_APP' => $this->input->post('INT_ID_APP'),
                'CHR_MODULE' => $this->input->post('CHR_MODULE'),
                'INT_LEVEL' => $this->input->post('INT_LEVEL')			
            );
            $this->module_m->update_module($data, $id);
            //$this->log_m->add_log('40', $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }
    
    function delete_module($id) {
        //$this->role_module_m->authorization('1');
        $this->module_m->delete_module($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
