<?php

class currency_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/currency_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
    }

    private $layout = '/template/head';

    function index($msg = NULL) {
        $this->role_module_m->authorization('21');
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
        $data['sidebar'] = $this->role_module_m->side_bar(21);

        $data['title'] = 'Manage Currency';
        $data['msg'] = $msg;
        $data['data'] = $this->currency_m->get_all_currency();
        $data['subcontent'] = NULL;
        $data['content'] = 'budget/currency/manage_currency_v';
        $this->load->view($this->layout, $data);
    }

    function show_create() {
        echo $this->load->view('budget/currency/create_currency_v');
    }

    function cancel_create() {
        echo null;
    }

    function save_currency() {
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_CURRENCY' => $this->currency_m->get_new_id_currency(),
            'CHR_CURRENCY' => strtoupper($this->input->post('CHR_CURRENCY')),
            'CHR_CURRENCY_DESC' => $this->input->post('CHR_CURRENCY_DESC'),
            'NUM_IDR_CURRENCY' => $this->input->post('NUM_IDR_CURRENCY'),
            'CHR_CREATE_BY' => $session['USERNAME'],
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'),
            'BIT_FLG_DEL' => 0
        );
        $this->currency_m->save($data);
        $this->log_m->add_log('36', $data['INT_ID_CURRENCY']);
        $this->index('1');
    }

    function edit_currency($id) {
        $this->role_module_m->authorization('21');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(21);

        $data['data'] = $this->currency_m->get_all_currency();
        $data['currency'] = $this->currency_m->get_data_currency($id)->row();
        $data['title'] = 'Edit Currency';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/currency/edit_currency_v';
        $data['content'] = 'budget/currency/manage_currency_v';
        $this->load->view($this->layout, $data);
    }

    function update_currency() {
        $id = $this->input->post('INT_ID_CURRENCY');
        $session = $this->session->all_userdata();
        $data = array(
            'INT_ID_CURRENCY' => $id,
            'CHR_CURRENCY' => strtoupper($this->input->post('CHR_CURRENCY')),
            'CHR_CURRENCY_DESC' => $this->input->post('CHR_CURRENCY_DESC'),
            'NUM_IDR_CURRENCY' => $this->input->post('NUM_IDR_CURRENCY'),
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His')
        );
        $this->currency_m->update($data, $id);
        $this->log_m->add_log('37', $id);
        $this->index('2');
    }

    function delete_currency($id) {
        $this->role_module_m->authorization('21');
        $data['sidebar'] = $this->role_module_m->side_bar(21);
        $this->currency_m->delete($id);
        $this->log_m->add_log('38', $id);
        $this->index('3');
    }

}

?>
