<?php
	/**
	* 
	*/
	class approval_revision_gm_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'efila/approval_revision_gm_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('efila/approval_revision_document_m');
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
	        }
	        $data['msg'] = $msg;
	        $data['data'] = $this->approval_revision_document_m->get_revision_gm();
	        $data['content'] = 'efila/approval_gm/approval_revision_v';
	        $data['title'] = 'Approval Revision Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(271);

	        $this->load->view($this->layout, $data);
	    }

	    function detail_revision($id) {
	        $this->role_module_m->authorization('3');

	        $data['back'] = $this->approval_revision_document_m->get_revision_back($id);
	        $data['change'] = $this->approval_revision_document_m->get_revision_change($id);
	        $data['content'] = 'efila/approval_gm/revision_detail_v';
	        $data['title'] = 'Revision Document Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(271);

	        $this->load->view($this->layout, $data);
	    }


	    //updating data
	    function update_approval_gm($status, $id = NULL) {
	        $msg = 2;

	        date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
			$today2 =date_create($today1);
			$tgl = date_format($today2,"Ymd");

			$time1 = date("H:i:s");
			$time2 = date_create($time1);
			$time = date_format($time2,"His");

			$max = $this->approval_revision_document_m->get_id_notif();
	        $maxid = 0;
	        foreach ($max as $key) {
	        	$maxid = $key->MAX_ID;
	        }
	        $maxid = $maxid + 1;
	        
	        // $dept = "";
	        // $dpt = $this->approval_revision_document_m->get_notif_dept();
	        // foreach ($dpt as $key) {
	        // 	$dept = $key->CHR_DEPT;
	        // }
			
			if($this->input->post('CHR_INFO')) {
				$id = $this->input->post('INT_ID_REVISION');
				$npk = "";
		        $npkk = $this->approval_revision_document_m->get_npk($id);
		        foreach ($npkk as $key) {
		        	$npk = $key->CHR_NPK;
		        }
				$data = array(
	            	'INT_APPROVED_GM' => $status,
	            	'CHR_APPROVED_GM_DATE' => $tgl,
	            	'CHR_APPROVED_GM_TIME' => $time,
	            	'CHR_APPROVED_GM_BY' => $this->session->userdata("USERNAME"),
	            	'CHR_INFO' => $this->input->post('CHR_INFO'),
	            	'INT_STATUS' => 0
	            );
	            $data1 = array(
		        	'INT_ID_NOTIF' => $maxid,
		        	'CHR_NPK' => $npk,
		        	'INT_ID_APP' => 36,
		        	'CHR_NOTIF_TITLE' => "Revision Document Rejected",
	        		'CHR_NOTIF_DESC' => "Revision Document Rejected By Group Manager",
	        		'CHR_LINK' => "efila/revision_document_c",
	        		'CHR_CREATED_BY' => "EFILA",
	        		'CHR_CREATED_DATE' => $tgl,
	        		'CHR_CREATED_TIME' => $time
		        );
	            $this->approval_revision_document_m->save_notif($data1);
			} else {
				$data = array(
	            	'INT_APPROVED_GM' => $status,
	            	'CHR_APPROVED_GM_DATE' => $tgl,
	            	'CHR_APPROVED_GM_TIME' => $time,
	            	'CHR_APPROVED_GM_BY' => $this->session->userdata("USERNAME")
	            );

	            $cate = $this->approval_revision_document_m->get_cat_name($id);
		        $cat = "";
		        foreach ($cate as $key) {
		        	$cat = $key->CHR_CATEGORY_NAME;
		        }
		        
	        	$data1 = array(
		        	'INT_ID_NOTIF' => $maxid,
		        	'CHR_NPK' => '0334',
		        	'INT_ID_APP' => 36,
		        	'CHR_NOTIF_TITLE' => "Approve Revision Document",
	        		'CHR_NOTIF_DESC' => "Approve Revision Document From Department ".$dept,
	        		'CHR_LINK' => "efila/approval_revision_msu_c",
	        		'CHR_CREATED_BY' => "EFILA",
	        		'CHR_CREATED_DATE' => $tgl,
	        		'CHR_CREATED_TIME' => $time
		        );
	        
		        $this->approval_revision_document_m->save_notif($data1);
			}

            $this->approval_revision_document_m->save_approval($id, $data);

            redirect('efila/approval_revision_gm_c/index/'. $msg);					
	    }

	    function view_doc($doc) {
	    	var_dump(shell_exec('/opt/libreoffice5.4/program/soffice --headless "-env:UserInstallation=file:///tmp/LibreOffice_Conversion_${USER}" --convert-to pdf:writer_pdf_Export --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Revisi/" "/var/www/aisin-web/AIS_PP/assets/Document/Revisi/'.$doc.'" 2>&1'));
	    	$filename = explode(".", $doc);
	    	redirect(base_url()."assets/Document/Revisi/".$filename[0].".pdf");
	    }
	}
?>