<?php

class pos_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'efiling/pos_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/section_m');
        $this->load->model('organization/subsection_m');
		$this->load->model('efiling/pos_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    //show all data
    function index($msg = NULL, $id_subsection) {
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
        $data['data'] = $this->pos_m->get_pos_by_id_subsection($id_subsection);
		$id_section = $this->subsection_m->get_id_section_by_id_subsection($id_subsection);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
        $data['content'] = 'efiling/pos/manage_pos_v';
        $data['title'] = 'Pos';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //prepare to create
    function create_pos($id_subsection) {
        $this->role_module_m->authorization('65');
		$id_section = $this->subsection_m->get_id_section_by_id_subsection($id_subsection);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
        $data['content'] = 'efiling/pos/create_pos_v';
        $data['title'] = 'Create Pos';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //saving data
    function save_pos($id_subsection) {
        //$this->form_validation->set_rules('CHR_POS_TITLE', 'Sub section', 'required|min_length[7]|max_length[7]|callback_check_id_subsection|trim');
        $this->form_validation->set_rules('INT_POS_NUMBER', 'Pos Number', 'required|integer');
		$this->form_validation->set_rules('CHR_POS_TITLE', 'Pos Title', 'required');

        $id_pos = $this->pos_m->generate_id_pos();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_pos($id_subsection);
        } else {
            $data = array(
                'INT_ID_POS' => $id_pos,
                'INT_POS_NUMBER' => $this->input->post('INT_POS_NUMBER'),
                'CHR_POS_TITLE' => $this->input->post('CHR_POS_TITLE'),
                'INT_ID_SUB_SECTION' => $this->input->post('INT_ID_SUB_SECTION'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 0
            );
            $this->pos_m->save($data);
            $this->log_m->add_log('48', $id_pos);
            redirect($this->back_to_manage . $msg = 1 . "/" . $id_subsection);
        }
    }

    //Checking Sub section id
    function check_id_pos($id) {
        $return_value = $this->pos_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Id already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //prepare to editing
    function edit_pos($id_pos) {
        $this->role_module_m->authorization('65');
        $data['data'] = $this->pos_m->get_data_pos($id_pos)->row();
        $id_subsection = $this->pos_m->get_id_subsection_by_id_pos($id_pos);
		$id_section = $this->pos_m->get_id_section_by_id_pos($id_pos);
		$data['data_id_section'] = $id_section;
		$data['data_name_section'] = $this->section_m->get_name_section($id_section);
		$data['data_id_subsection'] = $id_subsection;
		$data['data_name_subsection'] = $this->subsection_m->get_name_subsection($id_subsection);
		$data['content'] = 'efiling/pos/edit_pos_v';
        $data['data_subsection'] = $this->subsection_m->get_subsection();
        $data['title'] = 'Edit Pos';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar']=  $this->role_module_m->side_bar(65);

        $this->load->view($this->layout, $data);
    }

    //updating data
    function update_pos() {
        $id_pos = $this->input->post('INT_ID_POS');

		$this->form_validation->set_rules('INT_POS_NUMBER', 'Pos Number', 'required|integer');
		$this->form_validation->set_rules('CHR_POS_TITLE', 'Pos Title', 'required');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_pos($id_pos);
        } else {
            $data = array(
                'INT_POS_NUMBER' => $this->input->post('INT_POS_NUMBER'),
                'CHR_POS_TITLE' => $this->input->post('CHR_POS_TITLE'),
                'INT_ID_SUB_SECTION' => $this->input->post('INT_ID_SUB_SECTION'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->pos_m->update($data, $id_pos);
            $this->log_m->add_log('49', $id_pos);

            redirect($this->back_to_manage . $msg = 2 . "/" . $this->input->post('INT_ID_SUB_SECTION'));
        }
    }

    //deleting data
    function delete_pos($id_pos) {
        $this->role_module_m->authorization('65');
		$id_subsection = $this->pos_m->get_id_subsection_by_id_pos($id_pos);
        $this->pos_m->delete($id_pos);
        $this->log_m->add_log('50', $id_pos);
        redirect($this->back_to_manage . $msg = 3 . "/" . $id_subsection);
    }

}
