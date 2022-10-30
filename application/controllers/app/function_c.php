<?php

class function_c extends CI_Controller {
    
    private $layout = '/template/head';
    private $back_to_manage = 'app/function_c/index/';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('app/function_m');
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
        $data['data'] = $this->function_m->get_function();
        $data['content'] = 'app/function/manage_function_v';
        $data['title'] = 'Manage Functional';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(179);
        $data['data_module'] = $this->function_m->get_data_module();       
        
        $this->load->view($this->layout, $data);
        
    }

    function save_function() {
        $this->form_validation->set_rules('CHR_FUNCTION', 'Function', 'required|min_length[5]|max_length[50]');
        $id = $this->function_m->get_new_id_function();
        //$session = $this->session->all_userdata();        
        $data = array(
            'INT_ID_FUNCTION' => $id,
            'INT_ID_MODULE' => $this->input->post('INT_ID_MODULE'),
            'CHR_FUNCTION' => $this->input->post('CHR_FUNCTION'),
            'CHR_URL' => $this->input->post('CHR_URL')
        );
        $this->function_m->save_function($data);
        redirect($this->back_to_manage . $msg = 1);        
    }

    function edit_function($id) {
	$this->role_module_m->authorization('15');
        $data['data'] = $this->function_m->get_data_function($id)->row();
        
        $data['data_module'] = $this->function_m->get_data_module();
        $data['row_data_module'] = $this->function_m->get_data_edit_module($id);
        
        $data['content'] = 'app/function/edit_function_v';
        $data['title'] = 'Edit Function';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(179);
		
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_function() {
        $id = $this->input->post('INT_ID_FUNCTION');
        $this->form_validation->set_rules('CHR_FUNCTION', 'Function', 'required|min_length[5]|max_length[50]');
		
        //$session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_function($id);
        } else {
            $data = array(    
                'INT_ID_MODULE' => $this->input->post('INT_ID_MODULE'),
                'CHR_FUNCTION' => $this->input->post('CHR_FUNCTION'),
                'CHR_URL' => $this->input->post('CHR_URL')			
            );
            $this->function_m->update_function($data, $id);
            //$this->log_m->add_log('40', $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }
    
    function delete_function($id) {
        //$this->role_module_m->authorization('1');
        $this->function_m->delete_function($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
