<?php
	/**
	* 
	*/
	class request_submission_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'efila/request_submission_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('efila/request_submission_m');
	        $this->load->model('basis/role_module_m');
	        $this->load->model('portal/news_m');
	        $this->load->model('portal/notification_m');
	        // $this->load->model('asset/request_submission_m');
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
	        $data['data'] = $this->request_submission_m->get_request();
	        $data['cat'] = $this->request_submission_m->get_category();
	        $data['content'] = 'efila/request_submission/manage_request_submission_v';
	        $data['title'] = 'Manage  Category Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(269);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_request_submission() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'efila/request_submission/create_request_submission_v';
	        $data['title'] = 'Create Category Document';
	        $data['cat'] = $this->request_submission_m->get_category();
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(269);

	        $this->load->view($this->layout, $data);
	    }

	    function detail_request($id) {
	        $this->role_module_m->authorization('3');

	        $data['data'] = $this->request_submission_m->get_request_detail($id);
	        $data['content'] = 'efila/request_submission/request_detail_v';
	        $data['title'] = 'Request Submission Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(269);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_request_submission() {
	    	date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");

			$data = array(
            	'CHR_NPK' => $this->session->userdata('NPK'),
            	'CHR_NAME' => $this->session->userdata('USERNAME'),
            	'INT_ID_DEPT' => $this->session->userdata('DEPT'),
            	'INT_ID_SECTION' => $this->session->userdata('SECTION'),
            	'INT_ID_CATEGORY' => $this->input->post('INT_ID_CATEGORY'),
            	'CHR_CREATED_DATE' => $tgl,
            	'CHR_CREATED_TIME' => $time,
            	'INT_STATUS' => 0
            );
            $this->request_submission_m->save_request($data);

            $id = 0;
            $idsub = $this->request_submission_m->get_id_sub();
            foreach ($idsub as $isi) {
            	$id = $isi->id;
            }

            foreach ($_POST['reason_list'] as $reason) {
            	$data1 = array(
            		'INT_ID_REQUEST' => $id,
            		'CHR_REASON' => $reason 
            	);
            	$this->request_submission_m->save_request_detail($data1);
            }
            redirect($this->back_to_manage . $msg = 1);         
	    }

	    //updating data
	    function update_request_submission() {
	        $id = $this->input->post('INT_ID_REQUEST');
	        $msg = 2;

	        date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");
			
			$data = array(
            	'INT_ID_CATEGORY' => $this->input->post('INT_ID_CATEGORY'),
            	'CHR_MODIFIED_DATE' => $tgl,
            	'CHR_MODIFIED_TIME' => $time
            );

            $this->request_submission_m->update($data, $id);

            redirect($this->back_to_manage . $msg);					
	    }

	    function delete_request_submission($id) {
	        $this->role_module_m->authorization('3');
	        $this->request_submission_m->delete($id);
	        redirect($this->back_to_manage . $msg = 3);
	    }

	    function propose_request_submission($id) {
	        $this->role_module_m->authorization('3');
	        $this->request_submission_m->propose($id);
	        redirect($this->back_to_manage . $msg = 2);
	    }
	}
?>