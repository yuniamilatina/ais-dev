<?php

class customer_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/customer_m');
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
        $data['sidebar'] = $this->role_module_m->side_bar(203);
        
        $data['title'] = 'Manage Customer';
        $data['msg'] = $msg;
        $data['subcontent'] = NULL;
        $data['data'] = $this->customer_m->get_customer();
        $data['content'] = 'budget/customer/manage_customer_v';
        $this->load->view($this->layout, $data);
    }

    function show_create() {
        $data['customer'] = $this->customer_m->get_customer();
        echo $this->load->view('budget/customer/create_customer_v');
    }

    function cancel_create() {
        echo null;
    }

    function create_customer() {
        $this->role_module_m->authorization('12');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(203);
        
        $data['msg'] = NULL;
        $data['title'] = 'Create Customer';
        $data['data'] = $this->customer_m->get_customer();
        //$data['project'] = $this->project_m->get_project();
        $data['subcontent'] = 'budget/customer/create_customer_v';
        $data['content'] = 'budget/customer/manage_customer_v';

        $this->load->view($this->layout, $data);
    }

    function save_customer() {
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_CUSTOMER' => $this->customer_m->get_new_id_customer(),
            'CHR_CUSTOMER' => strtoupper($this->input->post('CHR_CUSTOMER')),
            'CHR_CUSTOMER_DESC' => $this->input->post('CHR_CUSTOMER_DESC'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0
        );
        $this->customer_m->save($data);
        //$this->log_m->add_log('27', $data['INT_ID_CUSTOMER']);
        $this->index('1');
    }

    function edit_customer($id) {
        $this->role_module_m->authorization('12');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(203);
        
        //$data['project'] = $this->project_m->get_project();
        $data['data'] = $this->customer_m->get_customer();
        $data['customer'] = $this->customer_m->get_data_customer($id)->row();
        $data['title'] = 'Edit Customer';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/customer/edit_customer_v';
        $data['content'] = 'budget/customer/manage_customer_v';

        $this->load->view($this->layout, $data);
    }

    function update_customer() {
        $id = $this->input->post('INT_ID_CUSTOMER');
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_CUSTOMER' => $this->input->post('INT_ID_CUSTOMER'),
            'CHR_CUSTOMER' => strtoupper($this->input->post('CHR_CUSTOMER')),
            'CHR_CUSTOMER_DESC' => $this->input->post('CHR_CUSTOMER_DESC'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His')
        );
        $this->customer_m->update($data, $id);
        //$this->log_m->add_log('28', $id);
        $this->index('2');
    }

    function delete_customer($id) {
        $this->role_module_m->authorization('12');
        $this->customer_m->delete($id);
        //$this->log_m->add_log('29', $id);
        $this->index('3');
    }

}

?>
