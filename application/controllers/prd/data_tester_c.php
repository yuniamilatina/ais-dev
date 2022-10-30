<?php

class Data_tester_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/data_tester_m');
    }

    public function index($date = null) {

        $data['title'] = 'Report Data Tester';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(69);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'prd/data_tester/data_tester_v';
        $date_fix = date('d-m-Y');
        $data['start_date'] = $date_fix;
        $data['end_date'] = $date_fix;

        $start_date = substr($date_fix, 6, 4) . substr($date_fix, 3, 2)  . substr($date_fix, 0, 2);
        $end_date = substr($date_fix, 6, 4) . substr($date_fix, 3, 2)  . substr($date_fix, 0, 2);

        $data['data'] = $this->data_tester_m->select_data_tester_base_on_range_date($start_date, $end_date);

        $this->load->view($this->layout, $data);
    }

    function search_data(){

        $start_date_fix = $this->input->post('CHR_START_DATE');
        $end_date_fix = $this->input->post('CHR_END_DATE');

        $data['title'] = 'Report Data Tester';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(69);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'prd/data_tester/data_tester_v';

        $data['start_date'] = $start_date_fix;
        $data['end_date'] = $end_date_fix;

        $start_date = substr($start_date_fix, 6, 4) . substr($start_date_fix, 3, 2)  . substr($start_date_fix, 0, 2);
        $end_date = substr($end_date_fix, 6, 4) . substr($end_date_fix, 3, 2)  . substr($end_date_fix, 0, 2);

        $data['data'] = $this->data_tester_m->select_data_tester_base_on_range_date($start_date, $end_date);

        $this->load->view($this->layout, $data);
    }

    // function generate_data_tester($msg = null){

    //     if ($msg == 1) {
    //         $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
    //     } 

    //     $data['msg'] = $msg;
    //     $data['title'] = 'Generate Data Tester';
    //     $data['app'] = $this->role_module_m->get_app();
    //     $data['module'] = $this->role_module_m->get_module();
    //     $data['function'] = $this->role_module_m->get_function();
    //     $data['sidebar'] = $this->role_module_m->side_bar(69);
    //     $data['news'] = $this->news_m->get_news();
    //     $data['content'] = 'prd/data_tester/generate_data_tester_v';
    //     $data['data'] = $this->data_tester_m->get_summary_data_tester();

    //     $this->load->view($this->layout, $data);
        
    // }

    // function detail_generate_data_tester_by_timestamp($timestamp = null){

    //     $data['title'] = 'Generate Data Tester';
    //     $data['app'] = $this->role_module_m->get_app();
    //     $data['module'] = $this->role_module_m->get_module();
    //     $data['function'] = $this->role_module_m->get_function();
    //     $data['sidebar'] = $this->role_module_m->side_bar(69);
    //     $data['news'] = $this->news_m->get_news();
    //     $data['content'] = 'prd/data_tester/generate_detail_data_tester_v';
        
    //     $data['data'] = $this->data_tester_m->get_data_tester_by_timestamp($timestamp)->result();

    //     $this->load->view($this->layout, $data);
        
    // }

    // function detail_generate_data_tester_by_date($date = null){

    //     $data['title'] = 'Generate Data Tester';
    //     $data['app'] = $this->role_module_m->get_app();
    //     $data['module'] = $this->role_module_m->get_module();
    //     $data['function'] = $this->role_module_m->get_function();
    //     $data['sidebar'] = $this->role_module_m->side_bar(69);
    //     $data['news'] = $this->news_m->get_news();
    //     $data['content'] = 'prd/data_tester/generate_detail_data_tester_v';
        
    //     $data['data'] = $this->data_tester_m->get_data_tester_by_date($date)->result();

    //     $this->load->view($this->layout, $data);
        
    // }

    // function generate_data($date = null, $flg = null){
    //     $this->load->helper(array('url','download'));				

    //     $data = $this->data_tester_m->get_data_tester_by_date($date, null);
    //     $filename = '5011_TRACEABILITY_'.$date.date('His');

    //     $output = null;
    //     $x = 1;
    //     foreach ($data->result() as $isi) {
    //         if($data->num_rows() == $x){
    //             $output .= $isi->CHR_BARCODE_PRODUCT."\t".trim($isi->CHR_PRD_ORDER_NO)."\t".trim($isi->CHR_PDS_NO)."\t".trim($isi->TIMESTAMP)."\t".trim($isi->CHR_DEL_NO);
    //         }else{
    //             $output .= $isi->CHR_BARCODE_PRODUCT."\t".trim($isi->CHR_PRD_ORDER_NO)."\t".trim($isi->CHR_PDS_NO)."\t".trim($isi->TIMESTAMP)."\t".trim($isi->CHR_DEL_NO)."\r\n";
    //         }
    //         $x++;
    //     }

    //     $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "AIS_PP/assets/file/traceability/". $filename,"wb");
    //     // $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "shared/". $filename,"wb");
    //     $result = fwrite($fp,$output);
    //     fclose($fp);

    //     //update generated
    //     $this->data_tester_m->update_flag_generated($date);

    //     redirect('prd/data_tester_c/generate_data_tester/',1);
        
    // }

    public function checkScanProductBarcode()
    {
        $this->load->model('prd/logs_in_line_scan_m');
        
        $barcode_product = trim($this->input->post('barcode_product'));
        $back_no = $this->input->post('back_no');
        $part_no = $this->input->post('part_no');
        $prod_order_no = $this->input->post('prod_order_no');
        $work_center = $this->input->post('work_center');

        $data = array('status' => false, 'message' => false);

        $data_product = $this->data_tester_m->get_data_tester_by_barcode($work_center, $barcode_product, 0);

        if ($data_product->num_rows() > 0) {
            $data_scan_product = $this->data_tester_m->get_data_tester_by_barcode($work_center, $barcode_product, 1);

            if ($data_scan_product->num_rows() > 0) {
                $data['message'] = "Data product " . $barcode_product . " sudah pernah dipindai";

                $log_data = array(
                    'CHR_CREATED_BY' => 'checkScanProductBarcode',
                    'CHR_WORK_CENTER' => $work_center,
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'CHR_PART_NO' => $part_no,
                    'CHR_MESSAGE' => $data['message'],
                    'CHR_BARCODE' => $barcode_product
                );
                $this->logs_in_line_scan_m->save($log_data);
            } else {

                $data_tester_model = $this->data_tester_m->get_data_tester_by_barcode_and_part_no($work_center, $barcode_product, $part_no);
                if ($data_tester_model->num_rows() > 0) {
                    $data['status'] = true;
                } else {
                    $data['message'] = 'Pastikan master model untuk ' . $part_no . ' sudah dimapping.';

                    $log_data = array(
                        'CHR_CREATED_BY' => 'checkScanProductBarcode',
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_PRD_ORDER_NO' => $prod_order_no,
                        'CHR_PART_NO' => $part_no,
                        'CHR_MESSAGE' => $data['message'],
                        'CHR_BARCODE' => $barcode_product
                    );
                    $this->logs_in_line_scan_m->save($log_data);
                }
            }
        } else {

            if ($work_center == 'ASDL06') {
                $data['message'] = "Barcode produk " . $barcode_product . " dengan model " . $back_no . " tidak terdaftar pada traceability line " . $work_center;
            } else {
                $data['message'] = "Barcode produk " . $barcode_product . " dengan model " . substr($barcode_product, -3) . " tidak terdaftar pada traceability line " . $work_center;
            }

            $log_data = array(
                'CHR_CREATED_BY' => 'checkScanProductBarcode',
                'CHR_WORK_CENTER' => $work_center,
                'CHR_PRD_ORDER_NO' => $prod_order_no,
                'CHR_PART_NO' => $part_no,
                'CHR_MESSAGE' => $data['message'],
                'CHR_BARCODE' => $barcode_product
            );
            $this->logs_in_line_scan_m->save($log_data);
        }

        echo json_encode($data);
    }
}
