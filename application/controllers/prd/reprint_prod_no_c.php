<?php

class reprint_prod_no_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'prd/reprint_prod_no_c/index/';
    //private $back_to_approve = 'helpdesk_ticket/helpdesk_ticket_c/prepare_approve_ticket/';
    public $id_function = '288';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('prd/check_prodno_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/user_m');
        $this->load->model('portal/notification_m');
        //$this->load->model('helpdesk_ticket/problem_type_m');
        //$this->load->model('helpdesk_ticket/prover_m');
        $this->load->model('portal/news_m');
    }

    function index($msg = NULL)
    {
        $this->role_module_m->authorization(288);

        // $session = $this->session->all_userdata();
        // $this->notification_m->has_be_read_by_npk_and_function($session['NPK'],$this->id_function );

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        }
        $finishdate = date("Ymd");
        $startdate = date('Ymd', strtotime($finishdate . ' -61 day'));

        $data['msg'] = $msg;
        $data['data'] = $this->check_prodno_m->get_data_prodno($startdate, $finishdate);
        $data['content'] = 'prd/reprint_prodno/manage_prodno_v';
        $data['title'] = 'Daftar Prod Nomor Yang Bisa Direprint';

        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(288);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function edit_data($id, $area)
    {
        $data['content'] = 'prd/reprint_prodno/edit_prodno_v';
        $data['title'] = 'Edit Data Production Nomor';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(288);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->check_prodno_m->get_data_by_id($id, $area);

        $this->load->view($this->layout, $data);
    }

    function print_kanban($id, $area, $status)
    {
        $data_array = array(
            'CHR_FLAG_SPOOLING' => $status
        );

        $this->check_prodno_m->update1($data_array, $id, $area);
        redirect($this->back_to_manage . $msg = 2);
    }

    function update_data()
    {
        $this->form_validation->set_rules('CHR_REPRINT', 'Status Reprint', 'required|char|max_length[1]|min_length[1]');
        $date = date("Ymd");
        $time = date("His");
        // $pno = $this->input->post('CHR_PNO');
        // $pno = trim($pno);
        $prodno = $this->input->post('chr_prodno');
        $area = $this->input->post('CHR_AREA');
        $id = $this->input->post('chr_id');
        $print = $this->input->post('CHR_REPRINT');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_data($id, $area);
        } else {
            $data_array = array(
                'CHR_FLAG_SPOOLING' => $print
            );

            $this->check_prodno_m->update($data_array, $prodno, $area);
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    //===== Update by ANU --- 20201113 =====//
    function print_kanban_new($id, $area, $status)
    {
        $data = $this->check_prodno_m->get_data_by_id($id, $area);

        $prodno = $data->CHR_PRD_ORDER_NO;
        // echo $status;
        // exit();

        $data_array = array(
            'CHR_FLAG_SPOOLING' => $status
        );

        $this->check_prodno_m->update($data_array, $prodno, $area);
        redirect($this->back_to_manage . $msg = 2);
    }
}
