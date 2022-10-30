<?php

class role_c extends CI_Controller {
    
    private $layout = '/template/head';
    private $back_to_manage = 'role_module/role_c/index/';
    
    public function __construct() {
        parent::__construct();
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
        $data['data'] = $this->role_m->select_all();
        $data['data_function'] = $this->role_m->get_data_function();
        $data['content'] = 'app/role/manage_role_v';
        $data['title'] = 'Manage Role';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(1);
        
        $this->load->view($this->layout, $data);
        
    }

    function save_role() {
        $this->form_validation->set_rules('CHR_ROLE', 'Role', 'required|min_length[5]|max_length[30]');
        $id = $this->role_m->get_new_id_role();
        $session = $this->session->all_userdata();        
        $data = array(
            'INT_ID_ROLE' => $id,
            'CHR_ROLE' => $this->input->post('CHR_ROLE'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date("Ymd"),
            'CHR_CREATE_TIME' => date ("His"),
            'CHR_MODI_BY' => NULL,
            'CHR_MODI_DATE' => NULL,
            'CHR_MODI_TIME' => NULL,
            'BIT_FLG_DEL' => 0
            
        );
        $this->role_m->save($data);
        redirect($this->back_to_manage . $msg = 1);        
    }

    function edit_role($id) {
	$this->role_module_m->authorization('15');
        $data['data'] = $this->role_m->get_data_role($id)->row();
        
        $data['data_edit'] = $this->role_m->get_data_role_module($id);
        $data['function'] = $this->role_m->get_data_function_edit();
    
        $data['content'] = 'role_module/role/edit_role_v';
        $data['title'] = 'Edit Function';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(1);
		
        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_role() {
        $id = $this->input->post('INT_ID_ROLE');
        $this->form_validation->set_rules('CHR_ROLE', 'Role', 'required|min_length[5]|max_length[30]');
        $session = $this->session->all_userdata(); 
        if ($this->form_validation->run() == FALSE) {
            $this->edit_role($id);
        } else {
            $data = array(
                'CHR_ROLE' => $this->input->post('CHR_ROLE'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date ("His")	
            );
            $this->role_m->update($data, $id);
            //$this->log_m->add_log('40', $id);
            redirect($this->back_to_manage . $msg = 2);
        }
    }
    
    function delete_role($id) {
        //$this->role_module_m->authorization('1');
        $this->role_m->delete($id);
        redirect($this->back_to_manage . $msg = 3);
    }

}
