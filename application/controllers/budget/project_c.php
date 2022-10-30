<?php

class project_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/project_m');
        $this->load->model('budget/product_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
    }

    private $layout = '/template/head';

    function index($msg = NULL) {
        $this->role_module_m->authorization('11');
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
        $data['sidebar'] = $this->role_module_m->side_bar(11);

        $data['product'] = $this->product_m->get_product();
        $data['title'] = 'Manage Project';
        $data['msg'] = $msg;
        $data['subcontent'] = NULL;
        $data['data'] = $this->project_m->get_project();
        $data['content'] = 'budget/project/manage_project_v';
        $this->load->view($this->layout, $data);
    }

    function save_project() {
        $session = $this->session->all_userdata();
        $product = $this->input->post('INT_ID_PRODUCT');
        $data = array(
            'INT_ID_PROJECT' => $this->project_m->get_new_id_project(),
            'CHR_PROJECT' => strtoupper($this->input->post('CHR_PROJECT')),
            'CHR_PROJECT_DESC' => $this->input->post('CHR_PROJECT_DESC'),
            'CHR_CUSTOMER' => $this->input->post('CHR_CUSTOMER'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0,
            'BIT_FLG_NEW_PROJECT' => $this->input->post('INT_FLG_NEW'),
            'CHR_MASSPRO_DATE' => $this->input->post('CHR_MASSPRO_YEAR') . $this->input->post('CHR_MASSPRO_MONTH') . '01'
        );
        $this->project_m->save($data);
        $this->log_m->add_log('24', $data['INT_ID_PROJECT']);

        if ($product != NULL) {
            for ($i = 0; $i < count($product); $i++) {
                $this->project_m->save_project_product($product[$i], $data['INT_ID_PROJECT'], $session['USERNAME']);
            }
        }
        $this->index('1');
    }

    function create_project() {
        $this->role_module_m->authorization('11');
        $data['product'] = $this->product_m->get_product();
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(11);
        
        $data['data'] = $this->project_m->get_project();
        $data['title'] = 'Create Project';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/project/create_project_v';
        $data['content'] = 'budget/project/manage_project_v';

        $this->load->view($this->layout, $data);
    }

    function get_project_detail($id) {
        $this->role_module_m->authorization('11');
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(11);
        
        $data['data'] = $this->project_m->get_project();
        $data['project'] = $this->project_m->get_data_project($id)->row();
        $data['title'] = 'Project Detail';
        $data['msg'] = NULL;
        $data['project_product'] = $this->project_m->get_data_product($id);
        $data['subcontent'] = 'budget/project/view_project_v';
        $data['content'] = 'budget/project/manage_project_v';

        $this->load->view($this->layout, $data);
    }

    function edit_project($id) {
        $this->role_module_m->authorization('11');
        $data['product'] = $this->product_m->get_product();
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(11);
        
        $data['data'] = $this->project_m->get_project();
        $data['project'] = $this->project_m->get_data_project($id)->row();
        $data['title'] = 'Edit Project';
        $data['msg'] = NULL;
        $data['project_product'] = $this->project_m->get_data_product($id);
        $data['subcontent'] = 'budget/project/edit_project_v';
        $data['content'] = 'budget/project/manage_project_v';

        $this->load->view($this->layout, $data);
    }

    function update_project() {
        $id = trim($this->input->post('INT_ID_PROJECT'));
        $product = $this->input->post('INT_ID_PRODUCT');
        $session = $this->session->all_userdata();
        $data = array(
            'CHR_PROJECT' => strtoupper($this->input->post('CHR_PROJECT')),
            'CHR_PROJECT_DESC' => $this->input->post('CHR_PROJECT_DESC'),
            'CHR_CUSTOMER' => $this->input->post('CHR_CUSTOMER'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'),
            'BIT_FLG_NEW_PROJECT' => $this->input->post('INT_FLG_NEW'),
            'CHR_MASSPRO_DATE' => $this->input->post('CHR_MASSPRO_YEAR') . $this->input->post('CHR_MASSPRO_MONTH') . '01'
        );
        $this->project_m->update($data, $id);
        $this->log_m->add_log('25', $id);
        if ($this->project_m->if_exist($id)) {
            $this->project_m->delete_project_product($id);
        }if ($product != NULL) {
            for ($i = 0; $i < count($product); $i++) {
                $this->project_m->save_project_product($product[$i], $id, $session['USERNAME']);
            }
        }

        $this->index('2');
    }

    function delete_project($id) {
        $this->role_module_m->authorization('11');
        $this->project_m->delete($id);
        $this->project_m->delete_project_product($id);
        $this->log_m->add_log('26', $id);
        $this->index('3');
    }

}

?>
