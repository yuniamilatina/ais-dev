<?php

class purchase_request_detail_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'budget/purchase_request_c/add_pureq_detail/';
    private $back_to_view = 'budget/purchase_request_c/view_detail_purchase_request/';
    private $back_to_edit = 'budget/purchase_request_c/edit_purchase_request/';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/purchase_request_detail_m');
        $this->load->model('budget/purchase_request_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
    }

    function remove_budget($no_budget, $no_pureq_temp, $budget_type, $section, $dept) {
        $this->purchase_request_detail_m->delete_detail($no_budget, $no_pureq_temp);
        redirect($this->back_to_manage . $no_budget . '/' . '0' . '/' . $budget_type. '/' .$section .'/'.$dept.'/'.'3');
    }

    function edit_purchase_request_detail($no_budget, $no_purchase_request) {
        $this->role_module_m->authorization('31');
        $this->load->model('budget/unit_m');


        $data['title'] = 'Edit Purchase Request';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(31);
        $data['news'] = $this->news_m->get_news();
        $data['width'] = 'class="col-md-6"';

        $data['data_unit'] = $this->unit_m->get_unit();
        $data['data'] = $this->purchase_request_m->get_data_purchase_request($no_purchase_request)->row();
        $data['data_pr'] = $this->purchase_request_detail_m->get_purchase_request_detail($no_purchase_request);
        $data['data_detail'] = $this->purchase_request_detail_m->get_data_purchase_request_detail($no_budget, $no_purchase_request)->row();

        $data['content'] = 'budget/purchase_request/edit_purchase_request_v';
        $data['subcontent'] = 'budget/purchase_request/edit_purchase_request_detail_v';

        $this->load->view($this->layout, $data);
    }

    function update_purchase_request_detail() {
        $data_detail = array(
            'CHR_PURCHASE_ITEM' => $this->input->post('CHR_PURCHASE_ITEM'),
            'INT_QUANTITY' => $this->input->post('INT_QUANTITY'),
            'DEC_PRICE_PER_UNIT' => $this->input->post('DEC_PRICE_PER_UNIT'),
            'CHR_SUPPLIER_NAME' => $this->input->post('CHR_SUPPLIER_NAME'),
            'CHR_REMARK' => $this->input->post('CHR_REMARK'),
            'INT_QUANTITY' => $this->input->post('INT_QUANTITY'),
            'INT_MONTH_ESTIMATE' => $this->input->post('INT_MONTH_ESTIMATE'),
            'CHR_REQUESTOR' => $this->input->post('CHR_REQUESTOR')
        );

        $this->purchase_request_detail_m->update($data_detail, $this->input->post('INT_NO_BUDGET'), $this->input->post('INT_NO_PUREQ'));

        $total = $this->input->post('DEC_TOTAL') + $this->input->post('DEC_PRICE_PER_UNIT') - $this->input->post('DEC_PRICE_PER_LIST_OLD');
        $data = array(
            'DEC_TOTAL' => + $total
        );

        $this->purchase_request_m->update($data, $this->input->post('INT_NO_PUREQ'));

        redirect($this->back_to_edit . '/' . $this->input->post('INT_NO_PUREQ'));
    }

    function update_purchase_requset_detail($no_budget, $no_pureq_temp) {
        $no_pureq_temp = $this->generated_id();

        $data = array(
            'CHR_PURCHASE_ITEM' => '',
            'INT_QUANTITY' => NULL,
            'DEC_PRICE_PER_UNIT' => NULL
        );

        $this->purchase_request_detail_m->update($data, $no_budget, $no_pureq_temp);
    }

    function generated_id_purchase_request_temp() {
        $query = $this->db->query('select max(INT_NO_PUREQ_TEMP) as a from TW_BUDGET_PUREQ_BUDGET')->row()->a + 1;
        return $query;
    }

    function remove_pureq_budget($no_budget, $no_pureq_temp) {
        $this->purchase_request_detail_m->delete($no_budget, $no_pureq_temp);
    }

}

?>
