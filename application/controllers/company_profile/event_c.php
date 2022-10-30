<?php
	/**
	* 
	*/
	class event_c extends CI_Controller
	{
		
		private $layout = '/template/head';
	    private $back_to_manage = 'company_profile/event_c/index/';

	    public function __construct() {
	        parent::__construct();
	        $this->load->model('company_profile/event_m');
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
	        $data['data'] = $this->event_m->get_event();
	        $data['content'] = 'company_profile/event/manage_event_v';
	        $data['title'] = 'Manage  event';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(91);

	        $this->load->view($this->layout, $data);
	    }

	    //prepare to create
	    function create_event() {
	        $this->role_module_m->authorization('3');
	        $data['content'] = 'company_profile/event/create_event_v';
	        $data['title'] = 'Create Event';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(91);

	        $this->load->view($this->layout, $data);
	    }

	    //saving data
	    function save_event() {
	        
        	$tgl = date_create($this->input->post('CHR_EVENT_DATE'));
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
					move_uploaded_file($file_tmp,DOCUP.'/event/'.$namaF);
					$data = array(
		            	'CHR_EVENT_NAME' => $this->input->post('CHR_EVENT_NAME'),
		            	'CHR_EVENT_DESC' => $this->input->post('CHR_EVENT_DESC'),
		            	'CHR_EVENT_DATE' => $date,
		            	'CHR_EVENT_PHOTO' => $namaF,
		            	'INT_STATUS' => 1
		            );
		            $this->event_m->save_event($data);
		            redirect($this->back_to_manage . $msg = 1);	
				} else {
					redirect($this->back_to_manage . $msg = 15);
				}
			}						
	    }

	    //prepare to editing
	    function edit_event($id) {
	        $this->role_module_m->authorization('3');
	        $data['data'] = $this->event_m->get_data_event($id)->row();
	        $data['content'] = 'company_profile/event/edit_event_v';
	        $data['title'] = 'Edit  Event';
	        $data['news'] = $this->news_m->get_news();
	        $data['app'] = $this->role_module_m->get_app();
	        $data['module'] = $this->role_module_m->get_module();
	        $data['function'] = $this->role_module_m->get_function();
	        $data['sidebar'] = $this->role_module_m->side_bar(91);

	        $this->load->view($this->layout, $data);
	    }

	    //updating data
	    function update_event() {
	        $id = $this->input->post('INT_ID_EVENT');
	        $msg = 2;

	        $tgl = date_create($this->input->post('CHR_EVENT_DATE'));
			$date = date_format($tgl,"Ymd");

			$maxsize = 5000000;
	    	$size = $_FILES['uploadFoto']['size'];
			$ekstensi = array('png','jpg','jpeg');
			$namaF = $_FILES['uploadFoto']['name'];
			$x = explode('.',$namaF);
			$eksten = strtolower(end($x));
			$file_tmp = $_FILES['uploadFoto']['tmp_name'];

			if($namaF == ""){
				$namaF = $this->input->post('CHR_EVENT_PHOTO_OLD');
				$data = array(
		            	'CHR_EVENT_NAME' => $this->input->post('CHR_EVENT_NAME'),
		            	'CHR_EVENT_DESC' => $this->input->post('CHR_EVENT_DESC'),
		            	'CHR_EVENT_DATE' => $date,
		            	'CHR_EVENT_PHOTO' => $namaF,
		            	'INT_STATUS' => 1
		            );

		            $this->event_m->update($data, $id);

		            redirect($this->back_to_manage . $msg);
			}						
						
			if(in_array($eksten, $ekstensi)===true)
			{
				if($size <= $maxsize){
					if(move_uploaded_file($file_tmp,DOCUP.'/event/'.$namaF))
					{
						echo "a";
					}
					$data = array(
		            	'CHR_EVENT_NAME' => $this->input->post('CHR_EVENT_NAME'),
		            	'CHR_EVENT_DESC' => $this->input->post('CHR_EVENT_DESC'),
		            	'CHR_EVENT_DATE' => $date,
		            	'CHR_EVENT_PHOTO' => $namaF,
		            	'INT_STATUS' => 1
		            );

		            $this->event_m->update($data, $id);

		            redirect($this->back_to_manage . $msg);
				} else {
					redirect($this->back_to_manage . $msg = 15);
				}
			}						
	    }

	    function delete_event($id) {
	        $this->role_module_m->authorization('3');
	        $this->event_m->delete($id);
	        redirect($this->back_to_manage . $msg = 3);
	    }
	    
	}
?>