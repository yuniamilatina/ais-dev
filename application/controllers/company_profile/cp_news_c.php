<?php
	/**
	* 
	*/
	class cp_news_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'company_profile/cp_news_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('company_profile/cp_news_m');
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
	        } elseif ($msg == 15) {
	            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Your File is Too Large! </strong> </div >";
	        }
	        $data['msg'] = $msg;
	        $data['data'] = $this->cp_news_m->get_news();
	        $data['content'] = 'company_profile/cp_news/manage_news_v';
	        $data['title'] = 'Manage  news';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(135);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_news() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'company_profile/cp_news/create_news_v';
	        $data['title'] = 'Create News';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(135);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_news() {
	        
			$session = $this->session->all_userdata();
			$date = date("Ymd");
			$today1 = date("Y-m-d-H-i-s");
			$maxsize = 5000000;
			$ekstensi = array('png','jpg','jpeg');
	    	$size = $_FILES['uploadFoto']['size'];
			$namafile = $_FILES['uploadFoto']['name'];
			$namaF = $today1.$namafile;
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFoto']['tmp_name'];
			
			preg_replace('/<br(\s+)?\/?>/i', "\n", $_POST['CHR_NEWS_DETAIL']);
			$lines = explode("\n", $_POST['CHR_NEWS_DETAIL']);
			$headline="";
			
			if ( !empty($lines) ) {
				$no =1;
			  foreach ( $lines as $line ) {
			  	if($no==4)
			  	{
			  		break;
			  	}
			    $headline= $headline.$line ;
			    $no++;
			  }
			}
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					move_uploaded_file($file_tmp,DOCUP.'/cp_news/'.$namaF);
					$data = array(
		            	'CHR_NEWS_TITLE' => $this->input->post('CHR_NEWS_TITLE'),
		            	'CHR_NEWS_DETAIL' => $this->input->post('CHR_NEWS_DETAIL'),
						'CHR_NEWS_HIGHLIGHT' => $headline,
		            	'CHR_CREATED_DATE' => $date,
						'CHR_CREATED_BY' => $session['USERNAME'],
		            	'CHR_NEWS_PHOTO' => $namaF,
		            	'INT_STATUS' => 1
		            );
		            $this->cp_news_m->save_news($data);
		            redirect($this->back_to_manage . $msg = 1);	
				} else {
					redirect($this->back_to_manage . $msg = 15);
				}
			}						
	    }

	    //prepare to editing
	    function edit_news($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->cp_news_m->get_data_news($id)->row();
	        $data['content'] = 'company_profile/cp_news/edit_news_v';
	        $data['title'] = 'Edit  News';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(135);

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_news() {
	        $id = $this->input->post('INT_ID_NEWS');
	        $msg = 2;

	        $date = date("Ymd");
			$today1 = date("Y-m-d-H-i-s");
			$maxsize = 5000000;
	    	$size = $_FILES['uploadFoto']['size'];
			$ekstensi = array('png','jpg','jpeg');
			$namafile = $_FILES['uploadFoto']['name'];
			$namaF = $today1.$namafile;
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFoto']['tmp_name'];
			$session = $this->session->all_userdata();
			//$s = nl2br($_POST['CHR_NEWS_DETAIL']);
			$lines = explode("\n", $_POST['CHR_NEWS_DETAIL']);
			$headline="";
			if ( !empty($lines) ) {
				$no =1;
			  foreach ( $lines as $line ) {
			  	if($no==4)
			  	{
			  		break;
			  	}
			    $headline= $headline.$line ;
			    $no++;
			  }
			}
			if($$namafile == ""){
				$namaF = $this->input->post('CHR_NEWS_PHOTO_OLD');
				$data = array(
		            	'CHR_NEWS_TITLE' => $this->input->post('CHR_NEWS_TITLE'),
		            	'CHR_NEWS_DETAIL' => $this->input->post('CHR_NEWS_DETAIL'),
						'CHR_NEWS_HIGHLIGHT' => $headline,
		            	'CHR_CREATED_DATE' => $date,
						'CHR_CREATED_BY' => $session['USERNAME'],
		            	'CHR_NEWS_PHOTO' => $namaF,
		            	'INT_STATUS' => 1
		            );

		            $this->cp_news_m->update($data, $id);

		            redirect($this->back_to_manage . $msg);
			}						
						
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					if(move_uploaded_file($file_tmp,DOCUP.'/cp_news/'.$namaF))
					{
						echo "a";
					}
					$data = array(
		            	'CHR_NEWS_TITLE' => $this->input->post('CHR_NEWS_TITLE'),
		            	'CHR_NEWS_DETAIL' => $this->input->post('CHR_NEWS_DETAIL'),
						'CHR_NEWS_HIGHLIGHT' => $headline,
		            	'CHR_CREATED_DATE' => $date,
						'CHR_CREATED_BY' => $session['USERNAME'],
		            	'CHR_NEWS_PHOTO' => $namaF,
		            	'INT_STATUS' => 1
		            );

		            $this->cp_news_m->update($data, $id);

		            redirect($this->back_to_manage . $msg);
				} else {
					redirect($this->back_to_manage . $msg = 15);
				}
			}						
	    }

	    function delete_news($id) {
	        $this->role_module_m->authorization('3');
	        $this->cp_news_m->delete($id);
	        redirect($this->back_to_manage . $msg = 3);
	    }
	    
	}
?>