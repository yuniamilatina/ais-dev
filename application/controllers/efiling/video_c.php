<?php

class video_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'efiling/video_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/log_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
		$this->load->model('efiling/doc_m');
		$this->load->model('efiling/pos_m');
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
        $data['data'] = $this->doc_m->get_video();
        $data['content'] = 'efiling/video/manage_video_v';
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
		$data['desc'] = $this->doc_m->get_name_file($id);
        $data['location'] = $this->doc_m->get_location_file($id);
        $data['content'] = 'efiling/video/play_video_v';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(66);
        
        $data['title'] = 'Play Video';
        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_video($msg = null) {
        $this->role_module_m->authorization('65');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 10) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> You must choose file first </div >";
        } elseif ($msg == 11) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> You must upload videos in mp4 format </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Maximum file size for upload is 20 MB </div >";
        } else {
            $msg = "";
        }
		
		$data['data_doc'] = $this->doc_m->get_video();
		$data['content'] = 'efiling/video/create_video_v';
        $data['title'] = 'Create Video';
		$data['msg'] = $msg;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_video() {
		$this->form_validation->set_rules('CHR_DOC_TITLE', 'Doc Title', 'required|max_length[40]');
		$id_doc = $this->doc_m->generate_id_docu();
		$session = $this->session->all_userdata();
		
        if ($this->form_validation->run() == FALSE) {
            $this->create_video("");
        }
		
		if ($this->input->post('btn_submit')) {
			$file_name = $id_doc . "_" .date("Ymd") . "_" . date("His");
			
			//cek apakah sudah ada file yang dipilih?
            $fileName = $_FILES['import']['name'];
            
			$target_dir = "./assets/file/doc/";
			$target_file = $target_dir . basename($_FILES["import"]["name"]);
			$videoFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if (empty($fileName)) {
				redirect($this->back_to_manage . $msg = 10);
            }
			if ($_FILES["import"]["size"] > 20000000) {
                redirect($this->back_to_manage . $msg = 12);
            }
			if ($videoFileType != "mp4" && $videoFileType != "MP4") {
                redirect($this->back_to_manage . $msg = 11);
            }
			
			else {
				//file untuk submit file image
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
				
				$data = array(
					'INT_ID_DOC' => $id_doc,
					'CHR_DOC_TITLE' => $this->input->post('CHR_DOC_TITLE'),
					'CHR_FILE_LOC' => $file_name,
					'BIT_FLG_DEL' => 0,
					'BIT_ACTIVE' => 0,
					'BIT_TYPE' => 0,
					'INT_DOC_HOUR' => $this->input->post('INT_DOC_HOUR'),
					'INT_DOC_MINUTE' => $this->input->post('INT_DOC_MINUTE'),
					'INT_DOC_SECOND' => $this->input->post('INT_DOC_SECOND')
				);
				$this->doc_m->save($data);
				//$this->doc_m->save_pos1($data);
				//$this->doc_m->save_pos2($data);
				//$this->doc_m->save_pos3($data);
				
				$this->log_m->add_log('48', $id_doc);
				redirect($this->back_to_manage . $msg = 1);
			}
        }
    }
}