<?php

class doc_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'efiling/doc_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/section_m');
        $this->load->model('organization/subsection_m');
		$this->load->model('efiling/pos_m');
		$this->load->model('efiling/pos_doc_m');
		$this->load->model('efiling/doc_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
		$this->load->helper(array('form', 'url'));
    }

    //show all data
    function index($msg = NULL, $id_pos) {
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
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> You must upload videos in jpg, jpeg, png, gif format </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Maximum file size for upload is 2 MB </div >";
        } else {
            $msg = "";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->pos_doc_m->get_latest_doc_by_id_pos($id_pos);
		$id_subsection = $this->pos_m->get_id_subsection_by_id_pos($id_pos);
		$id_section = $this->pos_m->get_id_section_by_id_pos($id_pos);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
		$data['data_id_pos'] = $id_pos;
		$data['data_number_pos'] = $this->pos_m->get_number_pos($id_pos);
        
		$data['content'] = 'efiling/doc/manage_doc_v';
        $data['title'] = 'Doc';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }
	
	//show history
	function history($id_pos, $id_doc) {
        $this->role_module_m->authorization('65');

        $data['data'] = $this->pos_doc_m->get_doc_history_by_id_pos_id_doc($id_pos, $id_doc);
		$id_subsection = $this->pos_m->get_id_subsection_by_id_pos($id_pos);
		$id_section = $this->pos_m->get_id_section_by_id_pos($id_pos);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
		$data['data_id_pos'] = $id_pos;
		$data['data_number_pos'] = $this->pos_m->get_number_pos($id_pos);
		$data['data_id_doc'] = $id_doc;
		$data['data_name_doc'] = $this->pos_doc_m->get_name_doc($id_doc);
        
		$data['content'] = 'efiling/doc/history_doc_v';
        $data['title'] = 'Doc';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }
	
    //prepare to create
    function create_doc($msg = null, $id_pos) {
        $this->role_module_m->authorization('65');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = "";
        }
		
		$id_subsection = $this->pos_m->get_id_subsection_by_id_pos($id_pos);
		$id_section = $this->pos_m->get_id_section_by_id_pos($id_pos);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
		$data['data_id_pos'] = $id_pos;
		$data['data_number_pos'] = $this->pos_m->get_number_pos($id_pos);
		
		$data['data_doc'] = $this->doc_m->get_doc();
		$data['content'] = 'efiling/doc/create_doc_v';
        $data['title'] = 'Create Doc';
		$data['msg'] = $msg;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_doc($id_pos) {
		$this->form_validation->set_rules('CHR_DOC_TITLE', 'Doc Title', 'required|max_length[40]');
		$id_doc = $this->pos_doc_m->generate_id_doc();
		$session = $this->session->all_userdata();
		
        if ($this->form_validation->run() == FALSE) {
            $this->create_doc("",$id_pos);
        }
		
		if ($this->input->post('btn_submit')) {
			$file_name = $this->input->post('INT_ID_DOC') . "_" .date("Ymd") . "_" . date("His");
			
			//cek apakah sudah ada file yang dipilih?
            $fileName = $_FILES['import']['name'];
            
			$target_dir = "./assets/file/doc/";
			$target_file = $target_dir . basename($_FILES["import"]["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if (empty($fileName)) {
				redirect($this->back_to_manage . $msg = 10 . "/" . $id_pos);
            }
			if ($_FILES["import"]["size"] > 2000000) {
                redirect($this->back_to_manage . $msg = 12 . "/" . $id_pos);
            }
			if ($imageFileType != "jpg" && $imageFileType != "JPG" &&
				$imageFileType != "png" && $imageFileType != "PNG" &&
				$imageFileType != "jpeg" && $imageFileType != "JPEG" &&
				$imageFileType != "gif" && $imageFileType != "GIF") {
                redirect($this->back_to_manage . $msg = 11 . "/" . $id_pos);
            }
			
			else {
				//file untuk submit file image
				$config['upload_path'] = './assets/file/doc/';
				$config['file_name'] = $file_name;
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 3000;
				
				//code for upload with ci
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ($a = $this->upload->do_upload('import'))
					$this->upload->display_errors();
				$media = $this->upload->data('import');
				
				$data = array(
					'INT_ID_POS_DOC' => $id_doc,
					'INT_ID_POS' => $this->input->post('INT_ID_POS'),
					'INT_ID_DOC' => $this->input->post('INT_ID_DOC'),
					'CHR_UPLOAD_DATE' => date("Ymd"),
					'CHR_UPLOAD_TIME' => date("His"),
					'CHR_FILE_LOC' => $file_name,
					'BIT_FLG_DEL' => 0,
					'CHR_UPLOAD_BY' => $session['USERNAME']
				);
				$this->pos_doc_m->save($data);
				$this->log_m->add_log('48', $id_doc);
				redirect($this->back_to_manage . $msg = 1 . "/" . $id_pos);
			}
        }
    }
	
	//prepare to create
    function create_category($id_pos) {
        $this->role_module_m->authorization('65');
		
		$id_subsection = $this->pos_m->get_id_subsection_by_id_pos($id_pos);
		$id_section = $this->pos_m->get_id_section_by_id_pos($id_pos);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
		$data['data_id_pos'] = $id_pos;
		$data['data_number_pos'] = $this->pos_m->get_number_pos($id_pos);
		
		$data['content'] = 'efiling/doc/create_category_v';
        $data['title'] = 'Create Category Document';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }
	
	function save_category($id_pos) {

        $this->form_validation->set_rules('CHR_DOC_TITLE', 'Doc Title', 'required|max_length[40]');
		$this->form_validation->set_rules('INT_DOC_HOUR', 'Display Time Hour', 'integer|min_length[1]|max_length[2]');
		$this->form_validation->set_rules('INT_DOC_MINUTE', 'Display Time Minute', 'integer|min_length[1]|max_length[2]');
		$this->form_validation->set_rules('INT_DOC_SECOND', 'Display Time Second', 'integer|min_length[1]|max_length[2]');

        $id_docu = $this->doc_m->generate_id_docu();

        if ($this->form_validation->run() == FALSE) {
            $this->create_category();
        } else {
            $data = array(
                'INT_ID_DOC' => $id_docu,
                'CHR_DOC_TITLE' => $this->input->post('CHR_DOC_TITLE'),
                'BIT_ACTIVE' => 0,
                'BIT_TYPE' => 1,
                'BIT_FLG_DEL' => 0,
				'INT_DOC_HOUR' => $this->input->post('INT_DOC_HOUR'),
                'INT_DOC_MINUTE' => $this->input->post('INT_DOC_MINUTE'),
                'INT_DOC_SECOND' => $this->input->post('INT_DOC_SECOND')
            );
			$this->doc_m->save($data);
            //$this->doc_m->save_pos1($data);
			//$this->doc_m->save_pos2($data);
			//$this->doc_m->save_pos3($data);
            $this->log_m->add_log('48', $id_pos);
            redirect("efiling/doc_c/create_doc/1" . "/" . $id_pos);
        }
    }
	
	//prepare to editing
    function edit_category($id_pos) {
        $this->role_module_m->authorization('65');
        $data['data'] = $this->doc_m->get_data_category($id_pos)->row();
		$data['content'] = 'efiling/doc/edit_category_v';
        $data['title'] = 'Edit Category';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_category() {
        $id_docu = $this->input->post('INT_ID_DOC');

		$this->form_validation->set_rules('INT_DOC_HOUR', 'Display Time Hour', 'integer|min_length[1]|max_length[2]');
		$this->form_validation->set_rules('INT_DOC_MINUTE', 'Display Time Minute', 'integer|min_length[1]|max_length[2]');
		$this->form_validation->set_rules('INT_DOC_SECOND', 'Display Time Second', 'integer|min_length[1]|max_length[2]');
		
        if ($this->form_validation->run() == FALSE) {
            $this->edit_category($id_docu);
        } else {
            $data = array(
                'INT_DOC_HOUR' => $this->input->post('INT_DOC_HOUR'),
                'INT_DOC_MINUTE' => $this->input->post('INT_DOC_MINUTE'),
                'INT_DOC_SECOND' => $this->input->post('INT_DOC_SECOND')
            );
			$this->doc_m->update($data, $id_docu);
			//$this->doc_m->update_pos1($data, $id_docu);
			//$this->doc_m->update_pos2($data, $id_docu);
			//$this->doc_m->update_pos3($data, $id_docu);
            $this->log_m->add_log('49', $id_docu);

            redirect("efiling/setting_display_c/index/2");
        }
    }
}
