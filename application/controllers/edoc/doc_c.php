<?php

class doc_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'edoc/doc_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/section_m');
        $this->load->model('organization/subsection_m');
		$this->load->model('edoc/pos_m');
		$this->load->model('edoc/doc_m');
		$this->load->model('edoc/docu_m');
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
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->doc_m->get_latest_doc_by_id_pos($id_pos);
		$id_subsection = $this->pos_m->get_id_subsection_by_id_pos($id_pos);
		$id_section = $this->pos_m->get_id_section_by_id_pos($id_pos);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
		$data['data_id_pos'] = $id_pos;
		$data['data_number_pos'] = $this->pos_m->get_number_pos($id_pos);
        
		$data['content'] = 'edoc/doc/manage_doc_v';
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

        $data['data'] = $this->doc_m->get_doc_history_by_id_pos_id_doc($id_pos, $id_doc);
		$id_subsection = $this->pos_m->get_id_subsection_by_id_pos($id_pos);
		$id_section = $this->pos_m->get_id_section_by_id_pos($id_pos);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
		$data['data_id_pos'] = $id_pos;
		$data['data_number_pos'] = $this->pos_m->get_number_pos($id_pos);
		$data['data_id_doc'] = $id_doc;
		$data['data_name_doc'] = $this->doc_m->get_name_doc($id_doc);
        
		$data['content'] = 'edoc/doc/history_doc_v';
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
		$data['content'] = 'edoc/doc/create_doc_v';
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

        if ($this->form_validation->run() == FALSE) {
            $this->create_doc("",$id_pos);
        }
		
		if ($this->input->post('btn_submit')) {
            $id_doc = $this->doc_m->generate_id_doc();
			$session = $this->session->all_userdata();
			$file_name = $this->input->post('INT_ID_DOC') . "_" .date("Ymd") . "_" . date("His");
			
			//cek apakah sudah ada file yang dipilih?
            $fileName = $_FILES['import']['name'];
            if (empty($fileName)) {
                redirect("edoc/doc_c/create_doc/" . $msg = 12 . "/" . $id_pos);
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
				$this->doc_m->save($data);
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
		
		$data['content'] = 'edoc/doc/create_category_v';
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

        $id_docu = $this->docu_m->generate_id_docu();

        if ($this->form_validation->run() == FALSE) {
            $this->create_category();
        } else {
            $data = array(
                'INT_ID_DOC' => $id_docu,
                'CHR_DOC_TITLE' => $this->input->post('CHR_DOC_TITLE'),
                'INT_DOC_HOUR' => $this->input->post('INT_DOC_HOUR'),
				'INT_DOC_MINUTE' => $this->input->post('INT_DOC_MINUTE'),
				'INT_DOC_SECOND' => $this->input->post('INT_DOC_SECOND'),
                'BIT_ACTIVE' => 0,
                'BIT_TYPE' => 1,
                'BIT_FLG_DEL' => 0
            );
            $this->docu_m->save($data);
            $this->log_m->add_log('48', $id_pos);
            redirect("edoc/doc_c/create_doc/1" . "/" . $id_pos);
        }
    }
	
	//prepare to editing
    function edit_category($id_pos) {
        $this->role_module_m->authorization('65');
        $data['data'] = $this->docu_m->get_data_category($id_pos)->row();
		$data['content'] = 'edoc/doc/edit_category_v';
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
            $this->docu_m->update($data, $id_docu);
            $this->log_m->add_log('49', $id_docu);

            redirect("edoc/setting_display_c/index/2");
        }
    }
}
