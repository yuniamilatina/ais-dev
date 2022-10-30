<?php
	/**
	* 
	*/
	class revision_document_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'efila/revision_document_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('efila/revision_document_m');
	        $this->load->model('basis/role_module_m');
	        $this->load->model('portal/news_m');
	        $this->load->model('portal/notification_m');
	        // $this->load->model('asset/revision_document_m');
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
	        $data['data'] = $this->revision_document_m->get_revision();
	        $data['content'] = 'efila/revision_document/manage_revision_document_v';
	        $data['title'] = 'Manage Revision Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(262);

	        $this->load->view($this->layout, $data);
	    }

	    function list_document() {
	        $this->role_module_m->authorization('3');

	        $data['doc'] = $this->revision_document_m->get_doc();
	        $data['content'] = 'efila/revision_document/list_revision_document_v';
	        $data['title'] = 'Manage Revision Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(262);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_revision_document($id, $msg = NULL) {
	    	if ($msg == 1) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed </strong> Create at least one <strong>reason</strong> </div >";
	        }
	        $data['msg'] = $msg;
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'efila/revision_document/create_revision_document_v';
	        $data['title'] = 'Revision Document';
	        $data['iddoc'] = $id;
	        $data['doc'] = $this->revision_document_m->get_doc_rev($id);
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(262);

	        $this->load->view($this->layout, $data);
	    }

	    function detail_revision($id) {
	        $this->role_module_m->authorization('3');

	        $data['back'] = $this->revision_document_m->get_revision_back($id);
	        $data['change'] = $this->revision_document_m->get_revision_change($id);
	        $data['content'] = 'efila/revision_document/revision_detail_v';
	        $data['title'] = 'Revision Document Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(262);

	        $this->load->view($this->layout, $data);
	    }

	    function detail_revision_edit($id, $msg = NULL) {
	    	if ($msg == 1) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating success </strong> The data is successfully created </div >";
	        }
	    	elseif ($msg == 3) {
	            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Deleted success </strong> The data is successfully deleted </div >";
	        }
	        $this->role_module_m->authorization('3');
	        $data['msg'] = $msg;
	        $data['rev'] = $id;
	        $data['back'] = $this->revision_document_m->get_revision_back($id);
	        $data['change'] = $this->revision_document_m->get_revision_change($id);
	        $data['content'] = 'efila/revision_document/revision_detail_edit_v';
	        $data['title'] = 'Revision Document Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(262);

	        $this->load->view($this->layout, $data);
	    }

	    function delete_reason($id, $idrev) {
	    	$this->role_module_m->authorization('3');
	        $this->revision_document_m->delete_reason($id);
	        redirect('efila/revision_document_c/detail_revision_edit/'.$idrev."/". $msg = 3);
	    }

	    function save_reason() {
	    	$this->role_module_m->authorization('3');

	    	$data = array(
	        	'INT_ID_REVISION' => $this->input->post('INT_ID_REVISION'),
	        	'CHR_BACKGROUND' => $this->input->post('CHR_REASON')
	        );
	        $this->revision_document_m->save_reason($data);
	        $rev = $this->input->post('INT_ID_REVISION');
	        redirect('efila/revision_document_c/detail_revision_edit/'.$rev."/". $msg = 1);
	    }

	    function save_change() {
	    	$this->role_module_m->authorization('3');

	    	$data = array(
	        	'INT_ID_REVISION' => $this->input->post('INT_ID_REVISION'),
	        	'CHR_CHANGE' => $this->input->post('CHR_CHANGE')
	        );
	        $this->revision_document_m->save_change($data);
	        $rev = $this->input->post('INT_ID_REVISION');
	        redirect('efila/revision_document_c/detail_revision_edit/'.$rev."/". $msg = 1);
	    }

	    function delete_change($id, $idrev) {
	    	$this->role_module_m->authorization('3');
	        $this->revision_document_m->delete_change($id);
	        redirect('efila/revision_document_c/detail_revision_edit/'.$idrev."/". $msg = 3);
	    }

	    //saving data
	    function save_revision_document() {
	    	date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
	    	$today2 = date_create($today1);
	    	$tgl = date_format($today2,"Ymd");

	    	$time1 = date("H:i:s");
	    	$time2 = date_create($time1);
	    	$time = date_format($time2,"His");

	    	$tgle = date_create($this->input->post('CHR_EFFECTIVE_DATE'));
			$datee = date_format($tgle,"Ymd");

	    	$sec = $this->session->userdata("SECTION");
	    	$username = $this->session->userdata("USERNAME");
	    	$dept = $this->session->userdata("DEPT");
	    	
			$maxsize = 5000000;
	    	$size = $_FILES['CHR_DOC']['size'];
			$ekstensi = array('doc','docx','xls','xlsx');
			$namaF = $_FILES['CHR_DOC']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['CHR_DOC']['tmp_name'];						
			if(isset($_POST['reason_list'])){		
				if(in_array($eksten, $ekstensi)===true)
				{
					if($size <= $maxsize){
						move_uploaded_file($file_tmp,'./assets/Document/Revisi/'.$namaF);
						$fileN = $this->input->post('CHR_NO_DOC').'.'.$eksten;
						
						rename('./assets/Document/Revisi/'.$namaF, './assets/Document/Revisi/'.$fileN);
						$data = array(
			            	'CHR_DOCUMENT_NAME' => $this->input->post('CHR_DOCUMENT_NAME'),
			            	'CHR_NO_DOC' => $this->input->post('CHR_NO_DOC'),
			            	'CHR_MODIFIED_BY' => $username,
			            	'CHR_MODIFIED_DATE' => $tgl,
			            	'CHR_MODIFIED_TIME' => $time,
			            	'CHR_DOC' => $fileN,
			            	'INT_STATUS_APPROVED' => 0
			            );
			            $this->revision_document_m->update_doc($data, $this->input->post('INT_ID_DOCUMENT'));

			            $idreg = "";
			            $idr = $this->revision_document_m->get_id_regist($this->input->post('INT_ID_DOCUMENT'));
			            foreach ($idr as $key) {
			            	$idreg = $key->INT_ID_REGISTER;
			            }

			            $data2 = array(
			            	'CHR_EFFECTIVE_DATE' => $datee 
			            );
			            $this->revision_document_m->update_reg($data2, $idreg);
			            
		            	$data1 = array(
			            	'INT_ID_DOCUMENT' => $this->input->post('INT_ID_DOCUMENT'),
			            	'INT_ID_SECTION' => $sec,
			            	'INT_ID_DEPT' => $dept,
			            	'CHR_CREATED_BY' => $username,
			            	'CHR_CREATED_DATE' => $tgl,
			            	'CHR_CREATED_TIME' => $time,
			            	'INT_STATUS' => 0
			            );
			            $this->revision_document_m->save_revision($data1);

			            $idrev = 0;
			            $idr = $this->revision_document_m->get_id_rev();
			            foreach ($idr as $isi) {
			            	$idrev = $isi->id;
			            }

			            foreach ($_POST['desc_list'] as $desc) {
			            	$data2 = array(
			            		'INT_ID_REVISION' => $idrev,
			            		'CHR_CHANGE' => $desc
			            	);
			            	$this->revision_document_m->save_change($data2);
			            }

			            foreach ($_POST['reason_list'] as $res) {
			            	$data3 = array(
			            		'INT_ID_REVISION' => $idrev,
			            		'CHR_BACKGROUND' => $res
			            	);
			            	$this->revision_document_m->save_reason($data3);
			            }

			            redirect($this->back_to_manage . $msg = 1);
	            	}
	        	}
        	} else {
        		redirect('efila/revision_document_c/create_revision_document/' . $this->input->post('INT_ID_DOCUMENT'). '/'. $msg = 1);
        	}         
	    }

	    function delete_revision_document($id) {
	        $this->role_module_m->authorization('3');
	        $rev = $this->revision_document_m->get_revision_num($id);
	        $revision = NULL;
	        $iddoc = NULL;
	        foreach ($rev as $key) {
	        	$revision = $key->INT_REVISION - 1;
	        	$iddoc = $key->INT_ID_DOCUMENT;
	        }
	        $data = array(
		            	'CHR_MODIFIED_BY' => $username,
		            	'CHR_MODIFIED_DATE' => $tgl,
		            	'CHR_MODIFIED_TIME' => $time,
		            	'INT_REVISION' => $revision,
		            	'INT_STATUS_APPROVED' => 1
		            );
	        $this->revision_document_m->delete_detail($id);
	        $this->revision_document_m->delete($id);
	        $this->revision_document_m->update_doc($data, $iddoc);
	        redirect($this->back_to_manage . $msg = 3);
	    }

	    function propose_revision_document($id) {
	        $this->role_module_m->authorization('3');
	        $this->revision_document_m->propose($id);

	        date_default_timezone_set('Asia/Jakarta');
	    	$today1 = date("Y-m-d");
	    	$today2 = date_create($today1);
	    	$tgl = date_format($today2,"Ymd");

	    	$time1 = date("H:i:s");
	    	$time2 = date_create($time1);
	    	$time = date_format($time2,"His");
	        
	        $max = $this->revision_document_m->get_id_notif();
	        $maxid = 0;
	        foreach ($max as $key) {
	        	$maxid = $key->MAX_ID;
	        }
	        $maxid = $maxid + 1;
	        $npk = "";
	        $npkk = $this->revision_document_m->get_npk_manager();
	        foreach ($npkk as $key) {
	        	$npk = $key->CHR_NPK;
	        }
	        $dept = "";
	        $dpt = $this->revision_document_m->get_notif_dept();
	        foreach ($dpt as $key) {
	        	$dept = $key->CHR_DEPT;
	        }
	        $data = array(
	        	'INT_ID_NOTIF' => $maxid,
	        	'CHR_NPK' => $npk,
	        	'INT_ID_APP' => 36,
	        	'CHR_NOTIF_TITLE' => "Approve Revision Document",
        		'CHR_NOTIF_DESC' => "Approve Revision Document From Department ".$dept,
        		'CHR_LINK' => "efila/approval_revision_manager_c",
        		'CHR_CREATED_BY' => "EFILA ".$dept,
        		'CHR_CREATED_DATE' => $tgl,
        		'CHR_CREATED_TIME' => $time
	        );
	        $this->revision_document_m->save_notif($data);
	        redirect($this->back_to_manage . $msg = 2);
	    }

	    function view_doc($doc) {
	    	var_dump(shell_exec('/opt/libreoffice5.4/program/soffice --headless "-env:UserInstallation=file:///tmp/LibreOffice_Conversion_${USER}" --convert-to pdf:writer_pdf_Export --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/" "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/'.$doc.'" 2>&1'));
	    	$filename = explode(".", $doc);
	    	redirect(base_url()."assets/Document/Master_list/".$filename[0].".pdf");
	    }

	    function update_revision_document() {
	        $id = $this->input->post('INT_ID_REVISION');
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
	            	'CHR_MODIFIED_DATE' => $tgl,
	            	'CHR_MODIFIED_TIME' => $time,
	            	'CHR_MODIFIED_BY' => $username,
	            	'CHR_DOC' => $namaF
	            );

	            $this->revision_document_m->update_doc($data, $iddoc);

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

	            $this->revision_document_m->update_rev($data1, $this->input->post("INT_ID_REVISION"));

	            redirect($this->back_to_manage . $msg);
			}						
						
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					// echo $_FILES['uploadFile']['error'];
					// exit();
					// unlink(DOCROOT.'/assets/Document/Revisi/'.$namaF);
					$fileN = $this->input->post('CHR_NO_DOC').'.'.$eksten;
					copy($file_tmp,'./assets/Document/Revisi/'.$fileN);
					// rename(DOCROOT.'/assets/Document/Revisi/'.$namaF, DOCROOT.'/assets/Document/Revisi/'.$fileN);
					$data = array(
		            	'CHR_MODIFIED_DATE' => $tgl,
		            	'CHR_MODIFIED_TIME' => $time,
		            	'CHR_MODIFIED_BY' => $username,
		            	'CHR_DOC' => $fileN
		            );

		            $this->revision_document_m->update_doc($data, $iddoc);

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

		            $this->revision_document_m->update_rev($data1, $this->input->post("INT_ID_REVISION"));

	            	redirect($this->back_to_manage . $msg);
				}
			}							
	    }
	}
?>