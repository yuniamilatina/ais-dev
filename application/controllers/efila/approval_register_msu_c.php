<?php
	/**
	* 
	*/
	class approval_register_msu_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'efila/approval_register_msu_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('efila/approval_register_document_m');
	        $this->load->model('basis/role_module_m');
	        $this->load->model('portal/news_m');
	        $this->load->model('portal/notification_m');
	        // $this->load->model('asset/document_m');
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
	        } elseif ($msg == 13) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating error !</strong> Document number already exist </div >";
	        } elseif ($msg == 15) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Updating error !</strong> Please fill document number at least <strong>11 digits</strong> </div >";
	        }
	        $data['msg'] = $msg;
	        $data['data'] = $this->approval_register_document_m->get_register_msu();
	        $data['data1'] = $this->approval_register_document_m->get_register_std_msu();
	        $data['no_doc'] = $this->approval_register_document_m->get_no_doc();
	        $data['content'] = 'efila/approval_msu/approval_register_v';
	        $data['title'] = 'Approval Register Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(272);

	        $this->load->view($this->layout, $data);
	    }

	    function detail_register($id) {
	        $this->role_module_m->authorization('3');

	        $data['dist'] = $this->approval_register_document_m->get_register_dist($id);
	        $data['supp'] = $this->approval_register_document_m->get_register_supp($id);
	        $data['req'] = $this->approval_register_document_m->get_request_detail($id);
	        $data['content'] = 'efila/approval_msu/register_detail_v';
	        $data['title'] = 'Register Document Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(273);

	        $this->load->view($this->layout, $data);
	    }


	    //updating data
	    function update_approval_msu($status) {
	        $msg = 2;

	        date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");

			$max = $this->approval_register_document_m->get_id_notif();
	        $maxid = 0;
	        foreach ($max as $key) {
	        	$maxid = $key->MAX_ID;
	        }
	        $maxid = $maxid + 1;
	        $dept = "";
	        $dpt = $this->approval_register_document_m->get_notif_dept();
	        foreach ($dpt as $key) {
	        	$dept = $key->CHR_DEPT;
	        }
			
	        if($this->input->post('CHR_NO_DOC')){
	        	$no = "A";
	        	$no_doc = $this->approval_register_document_m->check_no_doc($this->input->post('CHR_CATEGORY_NAME').$this->input->post('CHR_NO_DOC'));
	        	foreach ($no_doc as $key) {
	        		$no = $key->CHR_NO_DOC;
	        	}
	        	// echo $no;
	        	// exit();
	            $nodoc = $this->input->post('CHR_CATEGORY_NAME').$this->input->post('CHR_NO_DOC');
	            if(strlen($nodoc) >= 11){
		        	if($no == "A"){
		        		$id = $this->input->post('INT_ID_REGISTER');
		        		$efd = "";
		        		$idr = $this->approval_register_document_m->get_effective_date($id);
		        		foreach ($idr as $key) {
		        			$efd = $key->CHR_EFFECTIVE_DATE;
		        		}

			        	$data = array(
			            	'INT_APPROVED_MSU' => $status,
			            	'CHR_APPROVED_MSU_DATE' => $tgl,
			            	'CHR_APPROVED_MSU_TIME' => $time,
			            	'CHR_APPROVED_MSU_BY' => $this->session->userdata("USERNAME")
			            );
			            $id1 = $this->input->post('INT_ID_DOCUMENT');
			            $doc = $this->approval_register_document_m->get_filename($id1);
			            $document = NULL;
			            foreach ($doc as $key) {
			            	$document = $key->CHR_DOC;
			            }
			            $row = explode(".", $document);
			            $extensi = $row[1];
						
						// ---------------------------- DONT DELETE - ORIGINAL PATH BEFORE EDIT----------------------------------------- //
						// rename('./assets/Document/Register/'.$document, './assets/Document/Master_list/'.$nodoc.'.'.$extensi);
						// ------------------------------------------------------------------------------------------------------------- //
						
						rename('./assets/Document/Register/'.$document, './assets/Document/Master_list/Original_file/'.$nodoc.'.'.$extensi);
			            // exit();
			            $data1 = array(
			            	'CHR_NO_DOC' => $nodoc,
			            	'CHR_DOC' => $nodoc.'.'.$extensi,
			            	// 'CHR_PIC' => $this->session->userdata('USERNAME'),
			            	'INT_STATUS_APPROVED' => 1,
			            	'INT_REVISION' => 0,
			            	'CHR_EFFECTIVE_DATE' => $efd
			            );
			            $this->approval_register_document_m->update_no_doc($id1, $data1);

				        $npk = "";
				        $npkk = $this->approval_register_document_m->get_npk($id);
				        foreach ($npkk as $key) {
				        	$npk = $key->CHR_NPK;
				        }
			            
				        $cate = $this->approval_register_document_m->get_cat_name($id);
				        $cat = "";
				        foreach ($cate as $key) {
				        	$cat = $key->CHR_CATEGORY_NAME;
				        }
				        $data1 = array(
				        	'INT_ID_NOTIF' => $maxid,
				        	'CHR_NPK' => $npk,
				        	'INT_ID_APP' => 36,
				        	'CHR_NOTIF_TITLE' => "New Register Document Approved",
			        		'CHR_NOTIF_DESC' => "New Register Document Approved",
			        		'CHR_LINK' => "efila/register_document_c",
			        		'CHR_CREATED_BY' => "EFILA ".$dept,
			        		'CHR_CREATED_DATE' => $tgl,
			        		'CHR_CREATED_TIME' => $time
				        );
				        $this->approval_register_document_m->save_notif($data1);

		        	} else {
		        		redirect('efila/approval_register_msu_c/index/'. $msg = 13);
		        	}
		        } else {
		        	redirect('efila/approval_register_msu_c/index/'. $msg = 15);
		        }
	        } elseif($this->input->post('CHR_INFO')) {
	        	$id = $this->input->post('INT_ID_REGISTER');
	        	$data = array(
	            	'INT_APPROVED_MSU' => $status,
	            	'CHR_APPROVED_MSU_DATE' => $tgl,
	            	'CHR_APPROVED_MSU_TIME' => $time,
	            	'CHR_APPROVED_MSU_BY' => $this->session->userdata("USERNAME"),
	            	'CHR_INFO' => $this->input->post('CHR_INFO')
	            );
	        	$npk = "";
		        $npkk = $this->approval_register_document_m->get_npk($id);
		        foreach ($npkk as $key) {
		        	$npk = $key->CHR_NPK;
		        }
	            $data1 = array(
		        	'INT_ID_NOTIF' => $maxid,
		        	'CHR_NPK' => $npk,
		        	'INT_ID_APP' => 36,
		        	'CHR_NOTIF_TITLE' => "New Register Document Rejected",
	        		'CHR_NOTIF_DESC' => "New Register Document Rejected By MSU",
	        		'CHR_LINK' => "efila/register_document_c",
	        		'CHR_CREATED_BY' => "EFILA ".$dept,
	        		'CHR_CREATED_DATE' => $tgl,
	        		'CHR_CREATED_TIME' => $time
		        );
	            $this->approval_register_document_m->save_notif($data1);
	        }

            $this->approval_register_document_m->save_approval($id, $data);

            redirect('efila/approval_register_msu_c/index/'. $msg);					
	    }

	    function view_doc($doc) {
	    	var_dump(shell_exec('/opt/libreoffice5.4/program/soffice --headless "-env:UserInstallation=file:///tmp/LibreOffice_Conversion_${USER}" --convert-to pdf:writer_pdf_Export --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Register/" "/var/www/aisin-web/AIS_PP/assets/Document/Register/'.$doc.'" 2>&1'));
	    	$filename = explode(".", $doc);
	    	redirect(base_url()."assets/Document/Register/".$filename[0].".pdf");
	    }
	}
?>