<?php

class product_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/product_m');
        $this->load->model('budget/project_m');
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
        $data['sidebar'] = $this->role_module_m->side_bar(12);
        
        $data['title'] = 'Manage Product';
        $data['msg'] = $msg;
        $data['subcontent'] = NULL;
        $data['data'] = $this->product_m->get_product();
        $data['content'] = 'budget/product/manage_product_v';
        $this->load->view($this->layout, $data);
    }

    function show_create() {
        $data['project'] = $this->project_m->get_project();
        echo $this->load->view('budget/product/create_product_v');
    }

    function cancel_create() {
        echo null;
    }

    function create_product() {
        $this->role_module_m->authorization('12');

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(12);
        
        $data['msg'] = NULL;
        $data['title'] = 'Create Product';
        $data['data'] = $this->product_m->get_product();
        $data['project'] = $this->project_m->get_project();
        $data['subcontent'] = 'budget/product/create_product_v';
        $data['content'] = 'budget/product/manage_product_v';

        $this->load->view($this->layout, $data);
    }

    function save_product() {
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_PRODUCT' => $this->product_m->get_new_id_product(),
            'CHR_PRODUCT' => strtoupper($this->input->post('CHR_PRODUCT')),
            'CHR_PRODUCT_DESC' => $this->input->post('CHR_PRODUCT_DESC'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0
        );
        $this->product_m->save($data);
        $this->log_m->add_log('27', $data['INT_ID_PRODUCT']);
        $this->index('1');
    }

    function edit_product($id) {
        $this->role_module_m->authorization('12');
       $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(12);
        
        $data['project'] = $this->project_m->get_project();
        $data['data'] = $this->product_m->get_product();
        $data['product'] = $this->product_m->get_data_product($id)->row();
        $data['title'] = 'Edit Product';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/product/edit_product_v';
        $data['content'] = 'budget/product/manage_product_v';

        $this->load->view($this->layout, $data);
    }

    function update_product() {
        $id = $this->input->post('INT_ID_PRODUCT');
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_PRODUCT' => $this->input->post('INT_ID_PRODUCT'),
            'CHR_PRODUCT' => strtoupper($this->input->post('CHR_PRODUCT')),
            'CHR_PRODUCT_DESC' => $this->input->post('CHR_PRODUCT_DESC'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His')
        );
        $this->product_m->update($data, $id);
        $this->log_m->add_log('28', $id);
        $this->index('2');
    }

    function delete_product($id) {
        $this->role_module_m->authorization('12');
        $this->product_m->delete($id);
        $this->log_m->add_log('29', $id);
        $this->index('3');
    }

}

?>
