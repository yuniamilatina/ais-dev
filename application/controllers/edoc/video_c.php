<?php

class video_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'edoc/video_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/log_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
		$this->load->model('edoc/docu_m');
		$this->load->model('edoc/pos_m');
    }

    //show all data
    function index($msg = NULL) {
        $this->role_module_m->authorization('66');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->docu_m->get_video();
        $data['content'] = 'edoc/video/manage_video_v';
        $data['title'] = 'Show Video';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(66);
        
        $this->load->view($this->layout, $data);
    }

    //view by id
    function select_by_id($id) {
        $this->role_module_m->authorization('66');
		$data['desc'] = $this->docu_m->get_name_file($id);
        $data['location'] = $this->docu_m->get_location_file($id);
        $data['content'] = 'edoc/video/play_video_v';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(66);
        
        $data['title'] = 'Play Video';
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_video($msg = null) {
        $this->role_module_m->authorization('66');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 10) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> You must choose file first </div >";
        } elseif ($msg == 11) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> You must upload videos in .mp4 format </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Maximum file size for upload is 20 MB </div >";
        } else {
            $msg = "";
        }
		
        $data['content'] = 'edoc/video/create_video_v';
        $data['title'] = 'Create Video';
        
		$data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(66);
        
        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_video() {
        $this->form_validation->set_rules('CHR_DOC_TITLE', 'Doc Title', 'required|max_length[40]');
		$this->form_validation->set_rules('INT_DOC_HOUR', 'Display Time Hour', 'integer|min_length[1]|max_length[2]');
		$this->form_validation->set_rules('INT_DOC_MINUTE', 'Display Time Hour', 'integer|min_length[1]|max_length[2]');
		$this->form_validation->set_rules('INT_DOC_SECOND', 'Display Time Hour', 'integer|min_length[1]|max_length[2]');

        $id_docu = $this->docu_m->generate_id_docu();
		
		if ($this->form_validation->run() == FALSE) {
            $this->create_video();
        }
		
		if ($this->input->post('btn_submit')) {
			$file_name = date("Ymd") . "_" . date("His");
			
			//cek apakah sudah ada file yang dipilih?
            $fileName = $_FILES['import']['name'];
			
			$target_dir = "./assets/file/doc/";
			$target_file = $target_dir . basename($_FILES["import"]["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            if (empty($fileName)) {
                redirect("edoc/video_c/create_video/" . $msg = 10);
            }
			if ($imageFileType != "mp4") {
                redirect("edoc/video_c/create_video/" . $msg = 11);
            }
			if ($_FILES["import"]["size"] > 20000000) {
                redirect("edoc/video_c/create_video/" . $msg = 12);
            }
			else {
				//file untuk submit file video
				$config['upload_path'] = './assets/file/doc/';
				$config['file_name'] = $file_name;
				$config['allowed_types'] = 'mp4';
				$config['max_size'] = 20000000;
				
				//code for upload with ci
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ($a = $this->upload->do_upload('import'))
					$this->upload->display_errors();
				$media = $this->upload->data('import');
				
				//$targetFile = $target_dir . $file_name . ".mp4";
				//echo $this->docu_m->getDuration($targetFile);
				//exit();
				
				$data = array(
					'INT_ID_DOC' => $id_docu,
					'CHR_DOC_TITLE' => $this->input->post('CHR_DOC_TITLE'),
					'CHR_FILE_LOC' => $file_name,
					'INT_DOC_HOUR' => $this->input->post('INT_DOC_HOUR'),
					'INT_DOC_MINUTE' => $this->input->post('INT_DOC_MINUTE'),
					'INT_DOC_SECOND' => $this->input->post('INT_DOC_SECOND'),
					'BIT_FLG_DEL' => 0,
					'BIT_ACTIVE' => 0,
					'BIT_TYPE' => 0
				);
				$this->docu_m->save($data);
				$this->log_m->add_log('48', $id_video);
				redirect($this->back_to_manage . $msg = 1);
			}
        }
    }

    //deleting data
    function delete_section($id) {
        $this->role_module_m->authorization('66');
        $this->section_m->delete($id);
        $this->log_m->add_log('50', $id);
        redirect($this->back_to_manage . $msg = 3);
    }
}
