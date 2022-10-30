<?php
	/**
	* 
	*/
	class award_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'company_profile/award_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('company_profile/award_m');
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
	        $data['data'] = $this->award_m->get_award();
	        $data['content'] = 'company_profile/award/manage_award_v';
	        $data['title'] = 'Manage  Award';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(133);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_award() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'company_profile/award/create_award_v';
	        $data['title'] = 'Create Award';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(133);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_award() {
        	$tgl = date_create($this->input->post('CHR_AWARD_DATE'));
			$date = date_format($tgl,"Ymd");

			$maxsize = 5000000;
	    	$size = $_FILES['uploadFoto']['size'];
			$ekstensi = array('png','jpg','jpeg');
			$namaF = $_FILES['uploadFoto']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFoto']['tmp_name'];						
						
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					move_uploaded_file($file_tmp,DOCUP.'/awards/'.$namaF);
					$data = array(
		            	'CHR_AWARD_NAME' => $this->input->post('CHR_AWARD_NAME'),
		            	'CHR_AWARD_DESC' => $this->input->post('CHR_AWARD_DESC'),
		            	'CHR_AWARD_CATEGORY' => $this->input->post('CHR_AWARD_CATEGORY'),
		            	'CHR_AWARD_DATE' => $date,
		            	'CHR_AWARD_PHOTO' => $namaF,
		            	'INT_STATUS' => 1
		            );
		            $this->award_m->save_award($data);
		            redirect($this->back_to_manage . $msg = 1);
				} else {
					redirect($this->back_to_manage . $msg = 15);
				}
			}			
            

	    }

	    //prepare to editing
	    function edit_award($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->award_m->get_data_award($id)->row();
	        $data['content'] = 'company_profile/award/edit_award_v';
	        $data['title'] = 'Edit  Award';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(133);
			$data['ddl'] = $this->award_m->get_award_category();

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_award() {
	        $id = $this->input->post('INT_ID_AWARD');
	        $msg = 2;

	        $tgl = date_create($this->input->post('CHR_AWARD_DATE'));
			$date = date_format($tgl,"Ymd");

			$maxsize = 5000000;
	    	$size = $_FILES['uploadFoto']['size'];
			$ekstensi = array('png','jpg','jpeg');
			$namaF = $_FILES['uploadFoto']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFoto']['tmp_name'];

			if($namaF == ""){
				$namaF = $this->input->post('CHR_AWARD_PHOTO_OLD');
				$data = array(
	            	'CHR_AWARD_NAME' => $this->input->post('CHR_AWARD_NAME'),
	            	'CHR_AWARD_DESC' => $this->input->post('CHR_AWARD_DESC'),
	            	'CHR_AWARD_CATEGORY' => $this->input->post('CHR_AWARD_CATEGORY'),
	            	'CHR_AWARD_DATE' => $date,
	            	'CHR_AWARD_PHOTO' => $namaF,
	            	'INT_STATUS' => 1
	            );

	            $this->award_m->update($data, $id);

	            redirect($this->back_to_manage . $msg);
			}						
						
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					move_uploaded_file($file_tmp,DOCUP.'/awards/'.$namaF);
					$data = array(
		            	'CHR_AWARD_NAME' => $this->input->post('CHR_AWARD_NAME'),
		            	'CHR_AWARD_DESC' => $this->input->post('CHR_AWARD_DESC'),
		            	'CHR_AWARD_CATEGORY' => $this->input->post('CHR_AWARD_CATEGORY'),
		            	'CHR_AWARD_DATE' => $date,
		            	'CHR_AWARD_PHOTO' => $namaF,
		            	'INT_STATUS' => 1
		            );

		            $this->award_m->update($data, $id);

		            redirect($this->back_to_manage . $msg);
				} else {
					redirect($this->back_to_manage . $msg = 15);
				}
			}						
					
	    }

	    function delete_award($id) {
	        $this->role_module_m->authorization('3');
	        $this->award_m->delete($id);
	        redirect($this->back_to_manage . $msg = 3);
	    }
	}
?>