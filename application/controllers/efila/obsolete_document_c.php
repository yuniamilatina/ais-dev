<?php
	/**
	* 
	*/
	class obsolete_document_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'efila/obsolete_document_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('efila/obsolete_document_m');
	        $this->load->model('basis/role_module_m');
	        $this->load->model('portal/news_m');
	        $this->load->model('portal/notification_m');
	        // $this->load->model('asset/obsolete_document_m');
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
	        $data['data'] = $this->obsolete_document_m->get_obsolete();
	        $data['content'] = 'efila/obsolete_document/manage_obsolete_document_v';
	        $data['title'] = 'Manage Obsolete Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(263);

	        $this->load->view($this->layout, $data);
	    }

	    function list_document() {
	        $this->role_module_m->authorization('3');

	        $data['doc'] = $this->obsolete_document_m->get_doc();
	        $data['content'] = 'efila/obsolete_document/list_obsolete_document_v';
	        $data['title'] = 'Manage Obsolete Document';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(263);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_obsolete_document($id, $msg = NULL) {
	    	if ($msg == 1) {
	            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times</button><strong>Creating failed </strong> Create at least one <strong>reason</strong> </div >";
	        }
	        $data['msg'] = $msg;
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'efila/obsolete_document/create_obsolete_document_v';
	        $data['title'] = 'Obsolete Document';
	        $data['iddoc'] = $id;
	        $data['doc'] = $this->obsolete_document_m->get_doc_obs($id);
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(263);

	        $this->load->view($this->layout, $data);
	    }

	    // function detail_obsolete($id) {
	    //     $this->role_module_m->authorization('3');

	    //     $data['back'] = $this->obsolete_document_m->get_obsolete_back($id);
	    //     $data['content'] = 'efila/obsolete_document/obsolete_detail_v';
	    //     $data['title'] = 'Obsolete Document Detail';
	    //     $data['news'] = $this->news_m->get_news();
	    //     $data['app'] = $this->role_module_m->get_app();
	    //     $data['module'] = $this->role_module_m->get_module();
	    //     $data['function'] = $this->role_module_m->get_function();
	    //     $data['sidebar'] = $this->role_module_m->side_bar(263);

	    //     $this->load->view($this->layout, $data);
	    // }

	    //saving data
	    function save_obsolete_document() {
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
	    	if(isset($_POST['reason_list'])){
				$data = array(
					'INT_ID_DOCUMENT' => $this->input->post("INT_ID_DOCUMENT"),
					'INT_ID_DEPT' => $dept,
					'INT_ID_SECTION' => $sec,
					'CHR_CREATED_DATE' => $tgl,
	            	'CHR_CREATED_TIME' => $time,
	            	'CHR_CREATED_BY' => $username
				);
				$this->obsolete_document_m->save_obsolete($data);

				$idrev = 0;
	            $idr = $this->obsolete_document_m->get_id_obs();
	            foreach ($idr as $isi) {
	            	$idrev = $isi->id;
	            }
	            foreach ($_POST['reason_list'] as $res) {
	            	$data3 = array(
	            		'INT_ID_OBSOLETE' => $idrev,
	            		'CHR_BACKGROUND' => $res 
	            	);
	            	$this->obsolete_document_m->save_background($data3);
	            }
	            redirect($this->back_to_manage . $msg = 1);
            } else {
            	redirect('efila/obsolete_document_c/create_obsolete_document/' . $this->input->post('INT_ID_DOCUMENT'). '/'. $msg = 1);
            }	       
	    }


	    function delete_obsolete_document($id) {
	        $this->role_module_m->authorization('3');
	        
	        $this->obsolete_document_m->delete_detail($id);
	        $this->obsolete_document_m->delete($id);
	        redirect($this->back_to_manage . $msg = 3);
	    }

	    function save_reason() {
	    	$this->role_module_m->authorization('3');
	        $data = array(
	        	'INT_ID_OBSOLETE' => $this->input->post('INT_ID_OBSOLETE'),
	        	'CHR_BACKGROUND' => $this->input->post('CHR_BACKGROUND')
	        );
	        $this->obsolete_document_m->save_background($data);
	        $obs = $this->input->post('INT_ID_OBSOLETE');
	        redirect('efila/obsolete_document_c/detail_obsolete_edit/'.$obs."/". $msg = 1);
	    }

	    function delete_obsolete_back($id, $idobs) {
	        $this->role_module_m->authorization('3');
	        
	        $this->obsolete_document_m->delete_back($id);
	        redirect('efila/obsolete_document_c/detail_obsolete_edit/' . $idobs . '/' . $msg = 3);
	    }

	    function propose_obsolete_document($id) {
	        $this->role_module_m->authorization('3');
	        $this->obsolete_document_m->propose($id);
	        $max = $this->obsolete_document_m->get_id_notif();
	        $maxid = 0;
	        foreach ($max as $key) {
	        	$maxid = $key->MAX_ID;
	        }
	        $maxid = $maxid + 1;
	        $npk = "";
	        $npkk = $this->obsolete_document_m->get_npk_manager();
	        foreach ($npkk as $key) {
	        	$npk = $key->CHR_NPK;
	        }
	        $dept = "";
	        $dpt = $this->obsolete_document_m->get_notif_dept();
	        foreach ($dpt as $key) {
	        	$dept = $key->CHR_DEPT;
	        }
	        $data = array(
	        	'INT_ID_NOTIF' => $maxid,
	        	'CHR_NPK' => $npk,
	        	'INT_ID_APP' => 36,
	        	'CHR_NOTIF_TITLE' => "Approve Obsolete Document",
        		'CHR_NOTIF_DESC' => "Approve Obsolete Document From Department ".$dept,
        		'CHR_LINK' => "efila/approval_obsolete_manager_c",
        		'CHR_CREATED_BY' => "EFILA ".$dept,
        		'CHR_CREATED_DATE' => $tgl,
        		'CHR_CREATED_TIME' => $time
	        );
	        $this->obsolete_document_m->save_notif($data);
	        redirect($this->back_to_manage . $msg = 2);
	    }

	    function detail_obsolete($id, $msg=NULL) {
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
	        $data['back'] = $this->obsolete_document_m->get_obsolete_back($id);
	        $data['content'] = 'efila/obsolete_document/obsolete_detail_v';
	        $data['title'] = 'Obsolete Document Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(263);

	        $this->load->view($this->layout, $data);
	    }

	    function detail_obsolete_edit($id, $msg=NULL) {
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
	        $data['obs'] = $id;
	        $data['back'] = $this->obsolete_document_m->get_obsolete_back($id);
	        $data['content'] = 'efila/obsolete_document/obsolete_detail_edit_v';
	        $data['title'] = 'Obsolete Document Detail';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(263);

	        $this->load->view($this->layout, $data);
	    }

	    function view_doc($doc) {
	    	var_dump(shell_exec('/opt/libreoffice5.4/program/soffice --headless "-env:UserInstallation=file:///tmp/LibreOffice_Conversion_${USER}" --convert-to pdf:writer_pdf_Export --outdir "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/" "/var/www/aisin-web/AIS_PP/assets/Document/Master_list/'.$doc.'" 2>&1'));
	    	$filename = explode(".", $doc);
	    	redirect(base_url()."assets/Document/Master_list/".$filename[0].".pdf");
	    }
	}
?>