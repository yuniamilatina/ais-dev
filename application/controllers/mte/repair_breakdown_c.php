<?php

class Repair_breakdown_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct() {
        parent::__construct();
        $this->load->model('mte/repair_breakdown_m');
    }

    public function index() {

        $data['title'] = 'Report Line Stop Machine';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(226);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'mte/report_line_stop_v';

        $date = date('Y') . date('m');

        // $data['data_line_stop_machine_by_period'] = $this->repair_breakdown_m->select_data_line_stop_machine_by_period($date, $id_product_group);

        $this->load->view($this->layout, $data);
    }

    public function save_repair_breakdown(){
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['NPK'];

        $periode = $this->input->post('CHR_PERIODE');
        $prod_group = $this->input->post('INT_ID_PRODUCT_GROUP');

        $id = $this->input->post('INT_ID_LINE_STOP');
        $id_machine = $this->input->post('INT_ID_MACHINE');
        $problem = $this->input->post('CHR_PROBLEM');
        $problem_desc = $this->input->post('CHR_PROBLEM_DESC');
        $corrective_action = $this->input->post('CHR_CORRECTIVE_ACTION');
        $flg_sparepart = $this->input->post('INT_FLG_SPAREPART');
        $id_sparepart = $this->input->post('INT_ID_SPAREPART');
        $qty = $this->input->post('INT_QTY');
        $note = $this->input->post('CHR_NOTE');

        $data = array(
            'INT_ID_LINE_STOP' => $id,
            'INT_ID_MACHINE' => $id_machine,
            'CHR_PROBLEM' => $problem,
            'CHR_PROBLEM_DESC' => $problem_desc,
            'CHR_CORRECTIVE_ACTION' => $corrective_action,
            'INT_FLG_SPAREPART' => $flg_sparepart,
            'INT_ID_SPAREPART' => $id_sparepart,
            'INT_QTY' => $qty,
            'CHR_NOTE' => $note
        );
        $this->repair_breakdown_m->save($data);

        redirect('mte/report_line_stop_c/search_line_stop_machine/' . $periode . '/' . $prod_group, 'refresh');
    }

}
