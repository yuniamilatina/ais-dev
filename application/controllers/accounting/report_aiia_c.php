<?php

class report_aiia_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/accounting/report_aiia_c/';

    public function __construct() {
        parent::__construct();
        $this->load->model('part/part_m');
        $this->load->model('accounting/report_aiia_m');
        $this->load->model('organization/dept_m');
    }

    // function index($periode = NULL) {
        
    //     if($periode == NULL){
    //         $periode = date("Ym");
    //     }
        
    //     $data['app'] = $this->role_module_m->get_app();
    //     $data['module'] = $this->role_module_m->get_module();
    //     $data['function'] = $this->role_module_m->get_function();
    //     $data['sidebar'] = $this->role_module_m->side_bar(326);
    //     $data['news'] = $this->news_m->get_news();
    //     $data['title'] = 'Report Delivery AIIA';

    //     $data['periode'] = $periode;
    //     $data['start_date'] = $start_date;
    //     $data['end_date'] = $end_date;
    //     $data['data'] = $this->report_aiia_m->get_data_delivery_aiia($periode);
    //     $data['stat_del'] = $this->report_aiia_m->get_status_delete_sj()->INT_FLG_ACTIVE;

    //     $data['content'] = 'accounting/reporting/report_aiia_v';
    //     $this->load->view($this->layout, $data);
    // }

    function index($start_date = NULL, $end_date = NULL) {
        
        if($start_date == NULL){
            $start_date = date("Ym") . '01';
        }

        if($end_date == NULL){
            $end_date = date("Ymd");
        }
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(326);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Delivery AIIA';

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['data'] = $this->report_aiia_m->get_data_delivery_aiia_by_date($start_date, $end_date);
        $data['stat_backdate'] = $this->report_aiia_m->get_status_backdate_sj()->INT_FLG_ACTIVE;
        $data['stat_del'] = $this->report_aiia_m->get_status_delete_sj()->INT_FLG_ACTIVE;

        $data['content'] = 'accounting/reporting/report_aiia_v';
        $this->load->view($this->layout, $data);
    }

    function update_function_backdate($stat = NULL, $start_date = NULL, $end_date = NULL) {
        if($start_date == NULL){
            $start_date = date("Ym") . '01';
        }

        if($end_date == NULL){
            $end_date = date("Ymd");
        }

        $date_now = date("Ymd");
        $time_now = date("His");

        $user_session = $this->session->all_userdata();
        $user = $user_session['USERNAME'];

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(326);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Delivery AIIA';

        $this->db->query("UPDATE TM_FI_FUNCTION_STATE SET INT_FLG_ACTIVE = '$stat', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' WHERE CHR_FUNCTION_CODE = 'BACDT'");

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['data'] = $this->report_aiia_m->get_data_delivery_aiia_by_date($start_date, $end_date);
        $data['stat_del'] = $this->report_aiia_m->get_status_delete_sj()->INT_FLG_ACTIVE;
        $data['stat_backdate'] = $this->report_aiia_m->get_status_backdate_sj()->INT_FLG_ACTIVE;

        $data['content'] = 'accounting/reporting/report_aiia_v';
        $this->load->view($this->layout, $data);
    }

    function update_function_delete($stat = NULL, $start_date = NULL, $end_date = NULL) {
        if($start_date == NULL){
            $start_date = date("Ym") . '01';
        }

        if($end_date == NULL){
            $end_date = date("Ymd");
        }

        $date_now = date("Ymd");
        $time_now = date("His");

        $user_session = $this->session->all_userdata();
        $user = $user_session['USERNAME'];

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(326);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Delivery AIIA';

        $this->db->query("UPDATE TM_FI_FUNCTION_STATE SET INT_FLG_ACTIVE = '$stat', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_now' WHERE CHR_FUNCTION_CODE = 'DELDO'");

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['data'] = $this->report_aiia_m->get_data_delivery_aiia_by_date($start_date, $end_date);
        $data['stat_del'] = $this->report_aiia_m->get_status_delete_sj()->INT_FLG_ACTIVE;
        $data['stat_backdate'] = $this->report_aiia_m->get_status_backdate_sj()->INT_FLG_ACTIVE;

        $data['content'] = 'accounting/reporting/report_aiia_v';
        $this->load->view($this->layout, $data);
    }

    function search_report_by_date() {
        
        $start_date = date("Ymd", strtotime($this->input->post("START_DATE")));
        $end_date = date("Ymd", strtotime($this->input->post("END_DATE")));

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(326);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Report Delivery AIIA';

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['data'] = $this->report_aiia_m->get_data_delivery_aiia_by_date($start_date, $end_date);
        $data['stat_del'] = $this->report_aiia_m->get_status_delete_sj()->INT_FLG_ACTIVE;
        $data['stat_backdate'] = $this->report_aiia_m->get_status_backdate_sj()->INT_FLG_ACTIVE;

        $data['content'] = 'accounting/reporting/report_aiia_v';
        $this->load->view($this->layout, $data);
    }

    function export_rekap_delivery_aiia($periode){
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 2;
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load("assets/template/Template_rekap_delivery_aiia.xls");
        
        $rekap_delivery = $this->report_aiia_m->get_rekap_delivery_aiia($periode);
        $no = 1;
        foreach ($rekap_delivery as $tr) {
                       
            $objPHPExcel->getActiveSheet()->setCellValue("A$row", $tr->CHR_DEL_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", $tr->CHR_PICKING_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", $tr->CHR_BILL_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", $tr->CHR_DEST_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", $tr->CHR_GATE_ID);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tr->INT_DELETE_FLAG);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tr->CHR_DELIVERY_DATE);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tr->CHR_PDS_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tr->CHR_BILL_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tr->CHR_DEST_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tr->CHR_DEL_TYPE_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tr->CHR_KAT_PART);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tr->CHR_KAT_PART_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tr->CHR_PO_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tr->CHR_PICK_TIME);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tr->INT_DEL_ITEM);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tr->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", $tr->CHR_NO_FORECAST);
            $objPHPExcel->getActiveSheet()->setCellValue("S$row", $tr->CHR_FORE_ITM);
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", $tr->CHR_CUS_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("U$row", $tr->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("V$row", $tr->INT_TOT_KANBAN);
            $objPHPExcel->getActiveSheet()->setCellValue("W$row", $tr->INT_QTY_KANBAN);
            $objPHPExcel->getActiveSheet()->setCellValue("X$row", $tr->INT_TOT_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$row", $tr->CHR_PART_UOM);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$row", $tr->Expr2);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$row", $tr->Expr3);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$row", $tr->Expr4);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$row", $tr->Expr5);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$row", $tr->Expr6);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$row", $tr->CHR_SAP_DEL_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$row", $tr->CHR_SAP_DEL_ITEM);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$row", $tr->CHR_SAP_MATDOC_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("AH$row", $tr->CHR_SAP_PO_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("AI$row", $tr->CHR_SAP_PO_ITEM);
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", $tr->CHR_SAP_MATDOC_YEAR);

            $no++;
            $row++;
        }
        
        ob_end_clean();
        $filename = "Rekap Delivery AIIA Periode - $periode.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function export_rekap_delivery_aiia_new($start_date, $end_date){
        $user_session = $this->session->all_userdata();
        $role = $user_session['ROLE'];
        $row = 2;

        $start_date = date("Ymd", strtotime($start_date));
        $end_date = date("Ymd", strtotime($end_date));
        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        
        $objPHPExcel = $objReader->load("assets/template/Template_rekap_delivery_aiia.xls");
        
        $rekap_delivery = $this->report_aiia_m->get_rekap_delivery_aiia_by_date($start_date, $end_date);
        $no = 1;
        foreach ($rekap_delivery as $tr) {
                       
            $objPHPExcel->getActiveSheet()->setCellValue("A$row", $tr->CHR_DEL_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", $tr->CHR_PICKING_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", $tr->CHR_BILL_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", $tr->CHR_DEST_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", $tr->CHR_GATE_ID);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", $tr->INT_DELETE_FLAG);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", $tr->CHR_DELIVERY_DATE);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", $tr->CHR_PDS_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", $tr->CHR_BILL_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", $tr->CHR_DEST_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", $tr->CHR_DEL_TYPE_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", $tr->CHR_KAT_PART);
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", $tr->CHR_KAT_PART_DESC);
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", $tr->CHR_PO_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", $tr->CHR_PICK_TIME);
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", $tr->INT_DEL_ITEM);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", $tr->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", $tr->CHR_NO_FORECAST);
            $objPHPExcel->getActiveSheet()->setCellValue("S$row", $tr->CHR_FORE_ITM);
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", $tr->CHR_CUS_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("U$row", $tr->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("V$row", $tr->INT_TOT_KANBAN);
            $objPHPExcel->getActiveSheet()->setCellValue("W$row", $tr->INT_QTY_KANBAN);
            $objPHPExcel->getActiveSheet()->setCellValue("X$row", $tr->INT_TOT_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$row", $tr->CHR_PART_UOM);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$row", $tr->Expr2);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$row", $tr->Expr3);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$row", $tr->Expr4);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$row", $tr->Expr5);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$row", $tr->Expr6);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$row", $tr->CHR_SAP_DEL_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$row", $tr->CHR_SAP_DEL_ITEM);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$row", $tr->CHR_SAP_MATDOC_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("AH$row", $tr->CHR_SAP_PO_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("AI$row", $tr->CHR_SAP_PO_ITEM);
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$row", $tr->CHR_SAP_MATDOC_YEAR);

            $no++;
            $row++;
        }
        
        ob_end_clean();
        $filename = "Rekap Delivery AIIA Periode ($start_date - $end_date).xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
}
