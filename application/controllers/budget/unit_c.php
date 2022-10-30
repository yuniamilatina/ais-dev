<?php

class unit_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/unit_c/index/';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('budget/unit_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('20');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something is not right. </div >";
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(20);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Unit of Measurement';
        $data['msg'] = $msg;
        $data['data'] = $this->unit_m->get_unit();
        $data['subcontent'] = NULL;
        $data['content'] = 'budget/unit/manage_unit_v';
        $this->load->view($this->layout, $data);
    }
    
    function show_create() {
        echo $this->load->view('budget/unit/create_unit_v');
    }

    function cancel_create() {
        echo null;
    }

    function save_unit() {
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_SATUAN' => $this->unit_m->get_new_id_unit(),
            'CHR_SATUAN' => strtoupper($this->input->post('CHR_UNIT')),
            'CHR_SATUAN_DESC' => $this->input->post('CHR_UNIT_DESC'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0
        );
        $this->unit_m->save($data);
        //$this->log_m->add_log('36', $data['INT_ID_UNIT']);
        $this->index('1');
    }

    //Checking unit 
    function check_id($id) {
        $return_value = $this->unit_m->check_id($id);
        if ($return_value) {
            $this->form_validation->set_message('check_id', "Sorry, Your data Unit already exists, please choose another one");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_unit($id) {
        $this->role_module_m->authorization('21');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(20);

        $data['data'] = $this->unit_m->get_unit();
        $data['unit'] = $this->unit_m->get_data_unit($id)->row();
        $data['title'] = 'Edit Unit';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/unit/edit_unit_v';
        $data['content'] = 'budget/unit/manage_unit_v';
        $this->load->view($this->layout, $data);
    }
    
    function update_unit() {
        $id = $this->input->post('INT_ID_UNIT');
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_SATUAN' => $id,
            'CHR_SATUAN' => strtoupper($this->input->post('CHR_UNIT')),
            'CHR_SATUAN_DESC' => $this->input->post('CHR_UNIT_DESC'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His')
        );
        $this->unit_m->update($data, $id);
        $this->log_m->add_log('34', $id);
        $this->index('2');
    }

    function delete_unit($id) {
        $this->role_module_m->authorization('20');
        $this->unit_m->delete($id);
        $this->log_m->add_log('35', $id);
        $this->index('3');
    }

}

?>
