<?php

class prover_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'helpdesk_ticket/prover_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('helpdesk_ticket/prover_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('helpdesk_ticket/helpdesk_ticket_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('34');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['msg'] = $msg;
        $data['data'] = $this->prover_m->get_prover();
        $data['content'] = 'helpdesk_ticket/prover/manage_prover_v';
        $data['title'] = 'Manage Problem Solver';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(34);

        $this->load->view($this->layout, $data);
    }

    function view_detail_prover($id_prover, $msg = NULL) {
        $this->role_module_m->authorization('34');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Moving success </strong> Moving data success </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Moving failed </strong> You must select at least one data </div >";
        } else {
            $msg = NULL;
        }

        $data['data'] = $this->prover_m->get_data_prover($id_prover)->row();
        $data['data_prover'] = $this->prover_m->get_prover();
        $data['data_ticket'] = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_prover($id_prover);
        $data['content'] = 'helpdesk_ticket/prover/view_prover_v';

        $data['msg'] = $msg;
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'View Problem Solver';
        $data['sidebar'] = $this->role_module_m->side_bar(34);

        $this->load->view($this->layout, $data);
    }

    function create_prover() {
        $this->role_module_m->authorization('34');
        $data['content'] = 'helpdesk_ticket/prover/create_prover_v';
        $data['title'] = 'Create Problem Solver';
        $data['data_prover'] = $this->prover_m->get_prover();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['news'] = $this->news_m->get_news();
        $data['sidebar'] = $this->role_module_m->side_bar(34);

        $this->load->view($this->layout, $data);
    }

    function save_prover() {
        $this->form_validation->set_rules('CHR_PROVER', 'Problem Solver Initial', 'required|min_length[3]|max_length[4]|callback_check_id_prover|trim');
        $this->form_validation->set_rules('CHR_PROVER_DESC', 'Prover Description', 'required|max_length[20]|trim');

        $id_prover = $this->prover_m->generate_id_prover();
        $session = $this->session->all_userdata();

        if ($this->form_validation->run() == FALSE) {
            $this->create_prover();
        } else {
            $data = array(
                'INT_ID_PROVER' => $id_prover,
                'CHR_PROVER' => strtoupper($this->input->post('CHR_PROVER')),
                'CHR_PROVER_DESC' => $this->input->post('CHR_PROVER_DESC'),
                'CHR_CREATE_BY' => $session['USERNAME'],
                'CHR_CREATE_DATE' => date("Ymd"),
                'CHR_CREATE_TIME' => date("His"),
                'BIT_FLG_DEL' => 0
            );
            $this->prover_m->save_prover($data);
            $this->log_m->add_log('39', $id_prover);
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function check_id_prover($id_prover) {
        $return_value = $this->prover_m->check_id_prover($id_prover);
        if ($return_value) {
            $this->form_validation->set_message('check_id_prover', 'Sorry, This initial already exists, please choose another one');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function edit_prover($id_prover) {
        $this->role_module_m->authorization('34');
        $data['data'] = $this->prover_m->get_data_prover($id_prover)->row();
        $data['content'] = 'helpdesk_ticket/prover/edit_prover_v';
        $data['title'] = 'Edit Problem Solver';

        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(34);

        $this->load->view($this->layout, $data);
    }

    function update_prover() {
        $this->form_validation->set_rules('CHR_PROVER', 'Problem Solver Initial', 'required|min_length[3]|max_length[4]|trim');
        $this->form_validation->set_rules('CHR_PROVER_DESC', 'Prover Description', 'required|max_length[20]|trim');
        $session = $this->session->all_userdata();
        if ($this->form_validation->run() == FALSE) {
            $this->edit_prover($this->input->post('INT_ID_PROVER'));
        } else {
            $data = array(
                'CHR_PROVER' => strtoupper($this->input->post('CHR_PROVER')),
                'CHR_PROVER_DESC' => $this->input->post('CHR_PROVER_DESC'),
                'CHR_MODI_BY' => $session['USERNAME'],
                'CHR_MODI_DATE' => date("Ymd"),
                'CHR_MODI_TIME' => date("His")
            );
            $this->prover_m->update_prover($data, $this->input->post('INT_ID_PROVER'));
            $this->log_m->add_log('40', $this->input->post('INT_ID_PROVER'));
            redirect($this->back_to_manage . 2);
        }
    }

    function delete_prover($id_prover) {
        $this->role_module_m->authorization('34');
        $this->prover_m->delete_prover($id_prover);
        $this->log_m->add_log('41', $id_prover);
        redirect($this->back_to_manage . $msg = 3);
    }

    function moving_ticket() {
        $id_prover = $this->input->post('INT_ID_PROVER');
        $checked = $this->input->post('case');
        $data = array(
            'INT_ID_PROVER' => $this->input->post('INT_ID_PROVER_NEW')
        );

        if ($checked == null) {
            redirect('helpdesk_ticket/prover_c/view_detail_prover/' . $id_prover . '/' . 4);
        }

        for ($i = 0; $i < count($checked); $i++) {
            $this->helpdesk_ticket_m->update_helpdesk_ticket($data, $checked[$i]);
        }
        redirect('helpdesk_ticket/prover_c/view_detail_prover/' . $id_prover . '/' . 1);
    }

}
