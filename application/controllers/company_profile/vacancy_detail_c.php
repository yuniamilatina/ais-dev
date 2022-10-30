<?php
	/**
	* 
	*/
	class vacancy_detail_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'company_profile/vacancy_detail_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('company_profile/vacancy_detail_m');
	    }

	    function index($id, $msg = NULL) {
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
	        $data['data'] = $this->vacancy_detail_m->get_vacancy_detail($id);
	        $data['content'] = 'company_profile/vacancy_detail/manage_vacancy_detail_v';
	        $data['title'] = 'Manage Requirements';
	        $data['vacancy'] = $this->vacancy_detail_m->get_title($id);
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(189);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_vacancy_detail($id) {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'company_profile/vacancy_detail/create_vacancy_detail_v';
	        $data['title'] = 'Create Vacancy Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(189);
	        $data['id'] = $id;

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_vacancy_detail() {
	        $id = $this->input->post('INT_ID_VACANCY');
            $data = array(
            	'INT_ID_VACANCY' => $this->input->post('INT_ID_VACANCY'),
            	'CHR_CATEGORY' => $this->input->post('CHR_CATEGORY'),
            	'CHR_DESCRIPTION' => $this->input->post('CHR_DESCRIPTION'));
            $this->vacancy_detail_m->save_vacancy_detail($data);
            redirect($this->back_to_manage . $id . "/" . $msg = 1);
	    }

	    //prepare to editing
	    function edit_vacancy_detail($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->vacancy_detail_m->get_data_vacancy_detail($id)->row();
	        $data['content'] = 'company_profile/vacancy_detail/edit_vacancy_detail_v';
	        $data['title'] = 'Edit  vacancy_detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(189);

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_vacancy_detail() {
	        $id = $this->input->post('INT_ID_VACANCY_DETAIL');
	        $id2 = $this->input->post('INT_ID_VACANCY');
	        $msg = 2;

            $data = array(
            	'INT_ID_VACANCY' => $this->input->post('INT_ID_VACANCY'),
            	'CHR_CATEGORY' => $this->input->post('CHR_CATEGORY'),
            	'CHR_DESCRIPTION' => $this->input->post('CHR_DESCRIPTION')
            );

            $this->vacancy_detail_m->update($data, $id);

            redirect($this->back_to_manage . $id2 . "/" . $msg);
	    }
	}
?>