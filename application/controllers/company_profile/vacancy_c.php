<?php
	/**
	* 
	*/
	class vacancy_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'company_profile/vacancy_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('company_profile/vacancy_m');
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
	        $data['data'] = $this->vacancy_m->get_vacancy();
	        $data['content'] = 'company_profile/vacancy/manage_vacancy_v';
	        $data['title'] = 'Manage  Vacancy';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(141);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_vacancy() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'company_profile/vacancy/create_vacancy_v';
	        $data['title'] = 'Create Vacancy';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(141);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_vacancy() {
	        
            $data = array(
            	'CHR_VACANCY_NAME' => $this->input->post('CHR_VACANCY_NAME'),
            	'INT_STATUS' => 1);
            $this->vacancy_m->save_vacancy($data);
            redirect($this->back_to_manage . $msg = 1);
	    }

	    //prepare to editing
	    function edit_vacancy($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->vacancy_m->get_data_vacancy($id)->row();
	        $data['content'] = 'company_profile/vacancy/edit_vacancy_v';
	        $data['title'] = 'Edit  vacancy';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(141);

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_vacancy() {
	        $id = $this->input->post('INT_ID_VACANCY');
	        $msg = 2;

            $data = array(
            	'CHR_VACANCY_NAME' => $this->input->post('CHR_VACANCY_NAME'),
            	'INT_STATUS' => 1
            );

            $this->vacancy_m->update($data, $id);

            redirect($this->back_to_manage . $msg);
	    }

	    function activate($id) {
	    	$data = array(
	    		'INT_STATUS' => 1);

	    	$this->vacancy_m->update($data, $id);
	    	redirect($this->back_to_manage . $msg);
	    }

	    function deactivate($id) {
	    	$data = array(
	    		'INT_STATUS' => 0);

	    	$this->vacancy_m->update($data, $id);
	    	redirect($this->back_to_manage . $msg);
	    }
	}
?>