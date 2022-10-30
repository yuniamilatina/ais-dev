<?php

class reprint_voucher_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_search = 'inventory/reprint_voucher_c/search_sto_data/';

    public function __construct() {
        parent::__construct();
        $this->load->model('inventory/stock_opname_m');
    }

    public function index($msg = null){
        $this->role_module_m->authorization('292');

        $data['title'] = 'Voucher List Stock Opname';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(292);
        $data['msg'] = $msg;
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'inventory/voucher_list_v';
        
        $data['role'] = $this->session->userdata('ROLE');
        $data['all_chute'] = $this->stock_opname_m->get_chute();
        $data['chute'] = $this->stock_opname_m->get_top_chute();

        $data['data_stock_opname'] = $this->stock_opname_m->data_id_sto_by_chute($data['chute']);

        $this->load->view($this->layout, $data);
    }

    function search_sto_data($chute_id = null, $msg = NULL) {
        $this->role_module_m->authorization('292');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['title'] = 'Stock Opname Updater';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(292);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['content'] = 'inventory/voucher_list_v';

        $data['all_chute'] = $this->stock_opname_m->get_chute();
        $data['chute'] = $chute_id;

        $data['data_stock_opname'] = $this->stock_opname_m->data_id_sto_by_chute($data['chute']);

        $this->load->view($this->layout, $data);
    }

    function update_data_sto(){
        $iddoc = $this->input->post("CHR_IDDOC");
        $flag = $this->input->post("CHR_FLAG");
        $chute = $this->input->post("CHR_CHUTE");

        // $data['CHR_ID_DOC'] = $iddoc;
        $data['flag_spooling'] = $flag;
        $id['CHR_ID_DOC'] = $iddoc;

        $this->stock_opname_m->upt_print($data, $id);

        redirect($this->back_to_search.$chute.'/'.$msg = 2);
    }
}