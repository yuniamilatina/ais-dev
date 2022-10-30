<?php

class check_part_elina_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/check_part_elina_c/index/';
    //private $back_to_approve = 'helpdesk_ticket/helpdesk_ticket_c/prepare_approve_ticket/';
    public $id_function = '283';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/check_order_part_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/user_m');
        $this->load->model('portal/notification_m');
        //$this->load->model('helpdesk_ticket/problem_type_m');
        //$this->load->model('helpdesk_ticket/prover_m');
        $this->load->model('portal/news_m');
        
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization(283);
        
        $session = $this->session->all_userdata();
        $this->notification_m->has_be_read_by_npk_and_function($session['NPK'],$this->id_function );

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        }
//        $finishdate = date("Ymd");
//        $startdate = date('Ymd', strtotime($finishdate . ' -1 day'));
        
        $data['msg'] = $msg;
        $data['data'] = $this->check_order_part_m->get_data_order_fg();
        $data['content'] = 'prd/check_part/manage_cek_order_v';
        $data['title'] = 'Data Part Kosong Order Elina';
        $data['user'] = $session['NPK'];
        
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(283);
        $data['news'] = $this->news_m->get_news();
        
        $this->load->view($this->layout, $data);
    }
    
    function edit_data($prdno,$partno) {
        $data['content'] = 'prd/check_part/edit_data_order_v';
        $data['title'] = 'Edit Data Order Elina';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(283);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->check_order_part_m->get_data_by_id($prdno,$partno);

        $this->load->view($this->layout, $data);
    }
    
    function update_data_part() {
        $this->form_validation->set_rules('CHR_STOCK', 'Aktual Stock', 'required|integer|char|max_length[6]|min_length[1]');
        $datenow = date('Ymd');
        $pno = $this->input->post('CHR_PNO');
        $pno = trim($pno);
//        $bno = $this->input->post('CHR_BNO');
        $prod = $this->input->post('chr_prodno');
        $wkctr = substr($prod,0,6);
        $sloc = $this->input->post('chr_sloc');
        $stock = $this->input->post('CHR_STOCK');
                
        if ($this->form_validation->run() == FALSE) {
            $this->edit_data($prod,$pno);
        } else {
            $data_array = array(
                'INT_PART_QTY' => $stock
            );

            $this->check_order_part_m->update($data_array, $prod,$pno,$sloc,$wkctr);

            // $this->db->query("UPDATE PRD.TT_ELINA_H SET CHR_FLAG='0' WHERE CHR_FLAG='9' AND CHR_DATE_ORDER='$datenow'");            
            redirect($this->back_to_manage . $msg = 2);
        }
    }
}
