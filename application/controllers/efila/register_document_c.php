<?php
	/**
	* 
	*/
	class register_document_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'efila/register_document_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('efila/register_document_m');
	        $this->load->model('basis/role_module_m');
	        $this->load->model('portal/news_m');
	        $this->load->model('portal/notification_m');
	        // $this->load->model('asset/register_document_m');
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
	        $data['data'] = $this->register_document_m->get_regist();
	        $data['content'] = 'efila/register_document/manage_register_document_v';
	        $data['title'] = 'Manage Register Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(261);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_register_document($msg = NULL) {
	    	if ($msg == 1) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed </strong> Create at least one <strong>reason</strong> </div >";
	        }
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'efila/register_document/create_register_document_v';
	        $data['title'] = 'Register Document';
	        $data['msg'] = $msg;
	        $data['dept'] = $this->register_document_m->get_dept();
	        $data['doc'] = $this->register_document_m->get_doc();
	        $data['cat'] = $this->register_document_m->get_category();
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(261);

	        $this->load->view($this->layout, $data);
	    }

	    // function detail_regist($id) {
	    //     $this->role_module_m->authorization('3');

	    //     $data['data'] = $this->register_document_m->get_request_detail($id);
	    //     $data['content'] = 'efila/register_document/request_detail_v';
	    //     $data['title'] = 'Request Submission Detail';
	    //     $data['news'] = $this->news_m->get_news();
	    //     $data['app'] = $this->role_module_m->get_app();
	    //     $data['module'] = $this->role_module_m->get_module();
	    //     $data['function'] = $this->role_module_m->get_function();
	    //     $data['sidebar'] = $this->role_module_m->side_bar(261);

	    //     $this->load->view($this->layout, $data);
	    // }

	    //saving data
	    function save_register_document() {
	    	date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
	    	$today2 = date_create($today1);
	    	$tgl = date_format($today2,"Ymd");

	    	$time1 = date("H:i:s");
	    	$time2 = date_create($time1);
	    	$time = date_format($time2,"His");
	    	$sec = $this->session->userdata("SECTION");
	    	$username = $this->session->userdata("USERNAME");
	    	$dept = $this->session->userdata("DEPT");
	    	
			$maxsize = 5000000;
	    	$size = $_FILES['uploadFile']['size'];
			$ekstensi = array('doc','docx','xls','xlsx');
			$namaF = $_FILES['uploadFile']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFile']['tmp_name'];

			//$count = 0;
			
			if(isset($_POST['reason_list'])){
				if(in_array($eksten, $ekstensi)===true)
				{
					if($size <= $maxsize){
						// echo $namaF;
						move_uploaded_file($file_tmp,'./assets/Document/Register/'.$namaF);
						$namafile = preg_replace('/\s+/', '', $namaF);
						rename('./assets/Document/Register/'.$namaF, './assets/Document/Register/'.$namafile);
						// echo $namafile;
						// exit();
						$data = array(
			            	'CHR_DOCUMENT_NAME' => $this->input->post('CHR_DOCUMENT_NAME'),
			            	'CHR_DOCUMENT_DESC' => $this->input->post('CHR_DOCUMENT_DESC'),
			            	'CHR_CREATED_BY' => $username,
			            	'CHR_CREATED_DATE' => $tgl,
			            	'CHR_CREATED_TIME' => $time,
			            	'INT_ID_SECTION' => $sec,
			            	'INT_ID_CATEGORY' => $this->input->post('INT_ID_CATEGORY'),
			            	'CHR_DOC' => $namafile,
			            	'INT_STATUS' => 0
			            );
			            $this->register_document_m->save_doc($data);

			            $iddoc = 0;
			            $id = $this->register_document_m->get_id_doc();
			            foreach ($id as $isi) {
			            	$iddoc = $isi->id;
			            }
			            $tgle = date_create($this->input->post('CHR_EFFECTIVE_DATE'));
						$datee = date_format($tgle,"Ymd");

		            	$data1 = array(
			            	'INT_ID_DOC' => $iddoc,
			            	'CHR_EFFECTIVE_DATE' => $datee,
			            	'CHR_SCOPE' => $this->input->post('CHR_SCOPE'),
			            	'INT_ID_SECTION' => $sec,
			            	'INT_ID_DEPT' => $dept,
			            	'CHR_NPK' => $this->session->userdata('NPK'),
			            	'CHR_CREATED_BY' => $username,
			            	'CHR_CREATED_DATE' => $tgl,
			            	'CHR_CREATED_TIME' => $time,
			            	'INT_STATUS' => 0
			            );
			            $this->register_document_m->save_regist($data1);

			            $idreg = 0;
			            $idr = $this->register_document_m->get_id_reg();
			            foreach ($idr as $isi) {
			            	$idreg = $isi->id;
			            }

			            foreach ($_POST['iddept'] as $dep) {
			            	$data2 = array(
			            		'INT_ID_REGISTER' => $idreg,
			            		'INT_ID_DEPT' => $dep 
			            	);
			            	$this->register_document_m->save_dist($data2);
			            }

			            foreach ($_POST['iddoc'] as $doc) {
			            	$data3 = array(
			            		'INT_ID_REGISTER' => $idreg,
			            		'INT_ID_DOCUMENT' => $doc 
			            	);
			            	$this->register_document_m->save_supp($data3);
			            }

			            foreach ($_POST['reason_list'] as $reason) {
			            	$data4 = array(
			            		'INT_ID_REGISTER' => $idreg,
			            		'CHR_REASON' => $reason 
			            	);
			            	$this->register_document_m->save_request_detail($data4);
			            }

			            redirect($this->back_to_manage . $msg = 1);
	            	}
	        	} 
			} else {
	        		redirect('efila/register_document_c/create_register_document/' . $msg = 1);
	        	}
			         
	    }

	    //updating data
	    function update_register_document() {
	        $id = $this->input->post('INT_ID_REGISTER');
	        $iddoc = $this->input->post('INT_ID_DOCUMENT');
	        $msg = 2;

	        date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
	    	$today2 = date_create($today1);
	    	$tgl = date_format($today2,"Ymd");

	    	$time1 = date("H:i:s");
	    	$time2 = date_create($time1);
	    	$time = date_format($time2,"His");
	    	$sec = $this->session->userdata("SECTION");
	    	$username = $this->session->userdata("USERNAME");

			$maxsize = 5000000;
	    	$size = $_FILES['uploadFile']['size'];
			$ekstensi = array('doc','docx','xls','xlsx');
			$namaF = $_FILES['uploadFile']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFile']['tmp_name'];
			// echo $_FILES['uploadFile']['error'];
			// exit();

			if($namaF == ""){
				$namaF = $this->input->post('DOC_OLD');
				$data = array(
	            	'CHR_DOCUMENT_NAME' => $this->input->post('CHR_DOCUMENT_NAME'),
	            	'CHR_DOCUMENT_DESC' => $this->input->post('CHR_DOCUMENT_DESC'),
	            	'CHR_MODIFIED_DATE' => $tgl,
	            	'CHR_MODIFIED_TIME' => $time,
	            	'CHR_MODIFIED_BY' => $username,
	            	'CHR_DOC' => $namaF
	            );

	            $this->register_document_m->update_doc($data, $iddoc);
	            $tgle = date_create($this->input->post('CHR_EFFECTIVE_DATE'));
				$datee = date_format($tgle,"Ymd");
	            $data1 = array(
	            	'CHR_SCOPE' => $this->input->post('CHR_SCOPE'),
	            	'CHR_EFFECTIVE_DATE' => $datee,
	            	'INT_APPROVED_MANAGER' => NULL,
	            	'INT_APPROVED_GM' => NULL,
	            	'INT_APPROVED_MSU' => NULL,
	            	'CHR_APPROVED_MANAGER_BY' => NULL,
	            	'CHR_APPROVED_MANAGER_DATE' => NULL,
	            	'CHR_APPROVED_MANAGER_TIME' => NULL,
	            	'CHR_APPROVED_GM_BY' => NULL,
	            	'CHR_APPROVED_GM_DATE' => NULL,
	            	'CHR_APPROVED_GM_TIME' => NULL,
	            	'CHR_APPROVED_MSU_BY' => NULL,
	            	'CHR_APPROVED_MSU_DATE' => NULL,
	            	'CHR_APPROVED_MSU_TIME' => NULL,
	            	'INT_STATUS' => 0 
	            );

	            $this->register_document_m->update_reg($data1, $this->input->post("INT_ID_REGISTER"));

	            redirect($this->back_to_manage . $msg);
			}						
						
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					move_uploaded_file($file_tmp,'./assets/Document/Register/'.$namaF);
					$namafile = preg_replace('/\s+/', '', $namaF);
					rename('./assets/Document/Register/'.$namaF, './assets/Document/Register/'.$namafile);
					// $filee = trim($namaF);
					$data = array(
		            	'CHR_DOCUMENT_NAME' => $this->input->post('CHR_DOCUMENT_NAME'),
		            	'CHR_DOCUMENT_DESC' => $this->input->post('CHR_DOCUMENT_DESC'),
		            	'CHR_MODIFIED_DATE' => $tgl,
		            	'CHR_MODIFIED_TIME' => $time,
		            	'CHR_MODIFIED_BY' => $username,
		            	'CHR_DOC' => $namafile 
		            );

		            $this->register_document_m->update_doc($data, $iddoc);

		            $data1 = array(
		            	'INT_APPROVED_MANAGER' => NULL,
		            	'INT_APPROVED_GM' => NULL,
		            	'INT_APPROVED_MSU' => NULL,
		            	'CHR_APPROVED_MANAGER_BY' => NULL,
		            	'CHR_APPROVED_MANAGER_DATE' => NULL,
		            	'CHR_APPROVED_MANAGER_TIME' => NULL,
		            	'CHR_APPROVED_GM_BY' => NULL,
		            	'CHR_APPROVED_GM_DATE' => NULL,
		            	'CHR_APPROVED_GM_TIME' => NULL,
		            	'CHR_APPROVED_MSU_BY' => NULL,
		            	'CHR_APPROVED_MSU_DATE' => NULL,
		            	'CHR_APPROVED_MSU_TIME' => NULL,
		            	'INT_STATUS' => 0 
		            );

		            $this->register_document_m->update_reg($data1, $this->input->post("INT_ID_REGISTER"));

	            	redirect($this->back_to_manage . $msg);
				}
			}							
	    }

	    function delete_register_document($id, $iddoc) {
	        $this->role_module_m->authorization('3');
	        $this->register_document_m->delete($id);
	        $this->register_document_m->delete_doc($iddoc);
	        redirect($this->back_to_manage . $msg = 3);
	    }

	    function propose_register_document($id, $iddoc) {
	        $this->role_module_m->authorization('3');
	        $this->register_document_m->propose($id, $iddoc);
	        date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
	    	$today2 = date_create($today1);
	    	$tgl = date_format($today2,"Ymd");

	    	$time1 = date("H:i:s");
	    	$time2 = date_create($time1);
	    	$time = date_format($time2,"His");
	        
	        $max = $this->register_document_m->get_id_notif();
	        $maxid = 0;
	        foreach ($max as $key) {
	        	$maxid = $key->MAX_ID;
	        }
	        $maxid = $maxid + 1;
	        $npk = "";
	        $npkk = $this->register_document_m->get_npk_manager();
	        foreach ($npkk as $key) {
	        	$npk = $key->CHR_NPK;
	        }
	        $dept = "";
	        $dpt = $this->register_document_m->get_notif_dept();
	        foreach ($dpt as $key) {
	        	$dept = $key->CHR_DEPT;
	        }
	        $data = array(
	        	'INT_ID_NOTIF' => $maxid,
	        	'CHR_NPK' => $npk,
	        	'INT_ID_APP' => 36,
	        	'CHR_NOTIF_TITLE' => "Approve New Register Document",
        		'CHR_NOTIF_DESC' => "Approve New Register Document From Department ".$dept,
        		'CHR_LINK' => "efila/approval_register_manager_c",
        		'CHR_CREATED_BY' => "EFILA ".$dept,
        		'CHR_CREATED_DATE' => $tgl,
        		'CHR_CREATED_TIME' => $time
	        );
	        $this->register_document_m->save_notif($data);
	        redirect($this->back_to_manage . $msg = 2);
	    }

	    function detail_register($id) {
	        $this->role_module_m->authorization('3');

	        $data['dist'] = $this->register_document_m->get_register_dist($id);
	        $data['supp'] = $this->register_document_m->get_register_supp($id);
	        $data['req'] = $this->register_document_m->get_request_detail($id);
	        $data['content'] = 'efila/register_document/register_detail_v';
	        $data['title'] = 'Register Document Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(261);

	        $this->load->view($this->layout, $data);
	    }

	    function detail_edit_register($id, $msg = NULL) {
	    	if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success </strong> The data is successfully created </div >";
	        }
	    	elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        }
	        $this->role_module_m->authorization('3');
	        $data['msg'] = $msg;
	        $data['regist'] = $id;
	        $data['dist'] = $this->register_document_m->get_register_dist($id);
	        $data['supp'] = $this->register_document_m->get_register_supp($id);
	        $data['req'] = $this->register_document_m->get_request_detail($id);
	        $data['doc'] = $this->register_document_m->get_doc();
	        $data['dept'] = $this->register_document_m->get_dept();
	        $data['content'] = 'efila/register_document/register_detail_edit_v';
	        $data['title'] = 'Register Document Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(261);

	        $this->load->view($this->layout, $data);
	    }

	    function delete_reason($id, $regist) {
	    	$this->role_module_m->authorization('3');
	        $this->register_document_m->delete_reason($id);
	        redirect('efila/register_document_c/detail_edit_register/'.$regist."/". $msg = 3);
	    }

	    function delete_dist($id, $regist) {
	    	$this->role_module_m->authorization('3');
	        $this->register_document_m->delete_dist($id);
	        redirect('efila/register_document_c/detail_edit_register/'.$regist."/". $msg = 3);
	    }

	    function delete_support($id, $regist) {
	    	$this->role_module_m->authorization('3');
	        $this->register_document_m->delete_support($id, $regist);
	        redirect('efila/register_document_c/detail_edit_register/'.$regist."/". $msg = 3);
	    }

	    function save_reason() {
	    	$this->role_module_m->authorization('3');
	        $data = array(
	        	'INT_ID_REGISTER' => $this->input->post('INT_ID_REGISTER'),
	        	'CHR_REASON' => $this->input->post('CHR_REASON')
	        );
	        $this->register_document_m->save_reason($data);
	        $regist = $this->input->post('INT_ID_REGISTER');
	        redirect('efila/register_document_c/detail_edit_register/'.$regist."/". $msg = 1);
	    }

	    function save_support() {
	    	$this->role_module_m->authorization('3');
	        $data = array(
	        	'INT_ID_REGISTER' => $this->input->post('INT_ID_REGISTER'),
	        	'INT_ID_DOCUMENT' => $this->input->post('INT_ID_DOCUMENT')
	        );
	        $this->register_document_m->save_support($data);
	    }

	    function save_dist() {
	    	$this->role_module_m->authorization('3');
	        $data = array(
	        	'INT_ID_REGISTER' => $this->input->post('INT_ID_REGISTER'),
	        	'INT_ID_DEPT' => $this->input->post('INT_ID_DEPT')
	        );
	        $this->register_document_m->save_dist($data);
	    }

	    function view_doc($doc) {
	    	shell_exec('start /wait soffice --headless --convert-to pdf --outdir "C:/xampp/htdocs/AIS/assets/Document/Register/" "C:/xampp/htdocs/AIS/assets/Document/Register/'.$doc.'"');
	    	$filename = explode(".", $doc);
	    	redirect(base_url()."assets/Document/Register/".$filename[0].".pdf");
	    }
	}
?>