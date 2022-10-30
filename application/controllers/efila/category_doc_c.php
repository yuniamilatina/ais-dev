<?php
	/**
	* 
	*/
	class category_doc_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'efila/category_doc_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('efila/category_doc_m');
	        $this->load->model('basis/role_module_m');
	        $this->load->model('portal/news_m');
	        $this->load->model('portal/notification_m');
	        // $this->load->model('asset/category_doc_m');
	    }

	    function index($msg = NULL) {
	        $this->role_module_m->authorization('3');

	        if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success </strong> The data is successfully created </div >";
	        } elseif ($msg == 2) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating success </strong> The data is successfully updated </div >";
	        } elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        } elseif ($msg == 4) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Choosing failed </strong> You must select at least one data</div >";
	        } elseif ($msg == 12) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Executing error !</strong> Something error with parameter </div >";
	        }
	        $data['msg'] = $msg;
	        $data['data'] = $this->category_doc_m->get_category_doc();
	        $data['content'] = 'efila/category_doc/manage_category_doc_v';
	        $data['title'] = 'Manage  Category Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(276);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_category_doc() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'efila/category_doc/create_category_doc_v';
	        $data['title'] = 'Create Category Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(276);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_category_doc() {
	    	date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");

			$data = array(
            	'CHR_CATEGORY_NAME' => $this->input->post('CHR_CATEGORY_NAME'),
            	'CHR_CATEGORY_DESC' => $this->input->post('CHR_CATEGORY_DESC'),
            	'CHR_CREATED_BY' => $this->session->userdata('USERNAME'),
            	'CHR_CREATED_DATE' => $tgl,
            	'CHR_CREATED_TIME' => $time,
            	'INT_STATUS' => 1
            );
            $this->category_doc_m->save_category_doc($data);
            redirect($this->back_to_manage . $msg = 1);         
	    }

	    //prepare to editing
	    function edit_category_doc($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->category_doc_m->get_data_category_doc($id)->row();
	        $data['content'] = 'efila/category_doc/edit_category_doc_v';
	        $data['title'] = 'Edit  Category Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(276);

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_category_doc() {
	        $id = $this->input->post('INT_ID_CATEGORY');
	        $msg = 2;

	        date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");
			
			$data = array(
            	'CHR_CATEGORY_DESC' => $this->input->post('CHR_CATEGORY_DESC'),
            	'CHR_MODIFIED_DATE' => $date,
            	'CHR_MODIFIED_TIME' => $time
            );

            $this->category_doc_m->update($data, $id);

            redirect($this->back_to_manage . $msg);					
	    }

	    function delete_category_doc($id) {
	        $this->role_module_m->authorization('3');
	        $this->category_doc_m->delete($id);
	        redirect($this->back_to_manage . $msg = 3);
	    }
	}
?>