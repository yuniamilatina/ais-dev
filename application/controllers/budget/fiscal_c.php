<?php

class fiscal_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/fiscal_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    private $layout = '/template/head';

    function index($msg = NULL) {
        $this->role_module_m->authorization('10');
//        $data['active']=  $this->role_module_m->which_active('10');

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
        $data['sidebar'] = $this->role_module_m->side_bar(10);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Manage Fiscal Year';
        $data['msg'] = $msg;
        $data['data'] = $this->fiscal_m->get_fiscal();
        $data['subcontent'] = NULL;
        $data['content'] = 'budget/fiscal/manage_fiscal_v';
        $this->load->view($this->layout, $data);
    }

    function show_create() {
        echo $this->load->view('budget/fiscal/create_fiscal_v');
    }

    function cancel_create() {
        echo null;
    }

    function save_fiscal() {
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_FISCAL_YEAR' => $this->fiscal_m->get_new_id_fiscal(),
            'CHR_FISCAL_YEAR' => $this->input->post('FISCAL_YEAR'),
            'CHR_FISCAL_YEAR_START' => $this->input->post('START'),
            'CHR_FISCAL_YEAR_END' => $this->input->post('END'),
            'CHR_MONTH_START' => $this->input->post('M_START'),
            'CHR_MONTH_END' => $this->input->post('M_END'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0
        );
        $this->fiscal_m->save($data);
        $this->log_m->add_log('21', $data['INT_ID_FISCAL_YEAR']);
        $this->index('1');
    }

    function edit_fiscal($id) {
        $this->role_module_m->authorization('10');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(10);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->fiscal_m->get_all_fiscal();
        $data['fiscal'] = $this->fiscal_m->get_data_fiscal($id)->row();
        $data['title'] = 'Edit Fiscal Year';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/fiscal/edit_fiscal_v';
        $data['content'] = 'budget/fiscal/manage_fiscal_v';
        $this->load->view($this->layout, $data);
    }

    function update_fiscal() {
        $id = $this->input->post('ID_FISCAL_YEAR');
        $session = $this->session->all_userdata();
        $data = array(
            'CHR_FISCAL_YEAR' => $this->input->post('FISCAL_YEAR'),
            'CHR_FISCAL_YEAR_START' => $this->input->post('START'),
            'CHR_FISCAL_YEAR_END' => $this->input->post('END'),
            'CHR_MONTH_START' => $this->input->post('M_START'),
            'CHR_MONTH_END' => $this->input->post('M_END'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His')
        );
        $this->fiscal_m->update($data, $id);
        $this->log_m->add_log('22', $id);
        $this->index('2');
    }

    function delete_fiscal($id) {
        $this->role_module_m->authorization('10');
        $this->fiscal_m->delete($id);
        $this->log_m->add_log('23', $id);
        $this->index('3');
    }
    
    function enable_fiscal($id) {
        $this->db->query("UPDATE CPL.TM_FISCAL SET BIT_FLG_ACTIVE = 1 WHERE INT_ID_FISCAL_YEAR = '$id'");
        $this->index('2');
    }
    
    function disable_fiscal($id) {
        $this->db->query("UPDATE CPL.TM_FISCAL SET BIT_FLG_ACTIVE = 0 WHERE INT_ID_FISCAL_YEAR = '$id'");
        $this->index('2');
    }

}

?>
