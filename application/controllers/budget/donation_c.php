<?php

class donation_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/donation_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
    }

    private $layout = '/template/head';

    function index($msg = NULL) {
        $this->role_module_m->authorization('12');
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
        $data['sidebar'] = $this->role_module_m->side_bar(208);
        
        $data['title'] = 'Manage Donation';
        $data['msg'] = $msg;
        $data['subcontent'] = NULL;
        $data['data'] = $this->donation_m->get_donation();
        $data['content'] = 'budget/donation/manage_donation_v';
        $this->load->view($this->layout, $data);
    }

    function show_create() {
        $data['donation'] = $this->donation_m->get_donation();
        echo $this->load->view('budget/donation/create_donation_v');
    }

    function cancel_create() {
        echo null;
    }

    function create_donation() {
        $this->role_module_m->authorization('12');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(208);
        
        $data['msg'] = NULL;
        $data['title'] = 'Create Customer';
        $data['data'] = $this->donation_m->get_donation();
        //$data['project'] = $this->project_m->get_project();
        $data['subcontent'] = 'budget/donation/create_donation_v';
        $data['content'] = 'budget/donation/manage_donation_v';

        $this->load->view($this->layout, $data);
    }

    function save_donation() {
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_DONATION' => $this->donation_m->get_new_id_donation(),
            'CHR_DONATION' => strtoupper($this->input->post('CHR_DONATION')),
            'CHR_DONATION_DESC' => $this->input->post('CHR_DONATION_DESC'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0
        );
        $this->donation_m->save($data);
        //$this->log_m->add_log('27', $data['INT_ID_CUSTOMER']);
        $this->index('1');
    }

    function edit_donation($id) {
        $this->role_module_m->authorization('12');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(208);
        
        //$data['project'] = $this->project_m->get_project();
        $data['data'] = $this->donation_m->get_donation();
        $data['donation'] = $this->donation_m->get_data_donation($id)->row();
        $data['title'] = 'Edit Customer';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/donation/edit_donation_v';
        $data['content'] = 'budget/donation/manage_donation_v';

        $this->load->view($this->layout, $data);
    }

    function update_donation() {
        $id = $this->input->post('INT_ID_DONATION');
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_DONATION' => $this->input->post('INT_ID_DONATION'),
            'CHR_DONATION' => strtoupper($this->input->post('CHR_DONATION')),
            'CHR_DONATION_DESC' => $this->input->post('CHR_DONATION_DESC'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His')
        );
        $this->donation_m->update($data, $id);
        //$this->log_m->add_log('28', $id);
        $this->index('2');
    }

    function delete_donation($id) {
        $this->role_module_m->authorization('12');
        $this->donation_m->delete($id);
        //$this->log_m->add_log('29', $id);
        $this->index('3');
    }

}

?>
