<?php

//Add By xcx 20190507
class supplier_report_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/patricia/supplier_report_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('patricia/supplier_report_m');
    }

    function index() {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(77);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Supplier Performance';
        $date = date('Y');
        $supplier='';
        $data['list_supplier'] = $this->supplier_report_m->get_supplier();
        $data['daftarsupplier'] = $this->supplier_report_m->get_supplier_ck($date,$supplier);
        $data['data'] = $this->supplier_report_m->get_performance_tren($supplier,$date);
        $data['datadetil'] = $this->supplier_report_m->get_detil($date,$supplier);

        $data['msg'] = '';
        $data['selected_date'] = $date;
        $data['selected_supplier'] = '';
        $data['content'] = 'patricia/report/supplier_report_v';
        //print_r( $data['data']) ;
        $this->load->view($this->layout, $data);
    }
    // function search($date,$supplier = '')
    // {
    //     $data['app'] = $this->role_module_m->get_app();
    //     $data['module'] = $this->role_module_m->get_module();
    //     $data['function'] = $this->role_module_m->get_function();
    //     $data['sidebar'] = $this->role_module_m->side_bar(77);
    //     $data['news'] = $this->news_m->get_news();
    //     $data['title'] = 'Report Supplier Performance';
    //     $data['msg'] = 0;
    //     $data['list_supplier'] = $this->supplier_report_m->get_supplier();
    //     $data['data'] = $this->supplier_report_m->get_performance_by_date($date,$supplier);
    //     $data['datadetil'] = $this->supplier_report_m->get_detil($date,$supplier);
    //     $data['selected_date'] = $date;
    //     $data['selected_supplier'] = $supplier;
    //     $data['content'] = 'patricia/report/supplier_report_v';
    //     $this->load->view($this->layout, $data);
    // }
    function search()
    {
        $date = $this->input->post('date');
        $supplier = $this->input->post('supplier');
        // $supplier = '';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(77);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Supplier Performance';
        $data['msg'] = 0;
        $data['list_supplier'] = $this->supplier_report_m->get_supplier();
        $data['data'] = $this->supplier_report_m->get_performance_tren($supplier,$date);
        $data['datadetil'] = $this->supplier_report_m->get_detil($date,$supplier);
        $data['selected_date'] = $date;
        $data['selected_supplier'] = $supplier;
        $data['content'] = 'patricia/report/supplier_report_v';
        $data['daftarsupplier'] = $this->supplier_report_m->get_supplier_ck($date,$supplier);
        $this->load->view($this->layout, $data);
    }
    
}
?>