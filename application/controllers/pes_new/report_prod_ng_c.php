<?php

class report_prod_ng_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function index() {
        $data['title'] = 'Report Prod NG';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(125);
        $data['news'] = $this->news_m->get_news(); 
        $data['year'] = date('Y');
        $data['content'] = 'pes_new/report_prod_ng_v';

        $this->load->view($this->layout, $data);
    }
    
    public function update_data_ng() {
        $user = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $periode = date('Ym');
        
        $db_report = $this->load->database("db_report", TRUE);
        $db_report->query("EXEC zsp_update_report_ng_per_periode '$periode','$date','$time','$user'");
        
        redirect("pes_new/report_prod_ng_c", "refresh");
    }
    
    public function report_ng_by_amount() {
        $data['title'] = 'Report Prod NG by Amount';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(123);
        $data['news'] = $this->news_m->get_news();
        $data['year'] = date('Y');
        $data['content'] = 'pes_new/report_prod_ng_amount_v';

        $this->load->view($this->layout, $data);
    }
    
    public function report_ng_by_qty() {
        $data['title'] = 'Report Prod NG by Qty';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(124);
        $data['news'] = $this->news_m->get_news();
        $data['year'] = date('Y');
        $data['content'] = 'pes_new/report_prod_ng_qty_v';

        $this->load->view($this->layout, $data);
    }

    public function update_data_ng_amount() {
        $user = $this->session->userdata('USERNAME');
        $date = date('Ymd');
        $time = date('His');
        $periode = date('Ym');
        
        $db_report = $this->load->database("db_report", TRUE);
        $db_report->query("EXEC zsp_update_report_ng_per_periode '$periode','$date','$time','$user'");
        
        redirect("pes_new/report_prod_ng_c/report_ng_by_amount", "refresh");
    }
    
    function export_data_ng() {
       
        $row = 6;
        $db_report = $this->load->database("db_report", TRUE);
        $year = $this->input->post("year");
        $month = $this->input->post("month");
        $periode = $year . $month;
        if($month == 'all'){
            $periode = $year;
        }

        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/Template_Report_NG_Amount.xls");

        $seq = 1;
        $objPHPExcel->getActiveSheet()->setCellValue("B2", "Report Production NG by Amount " . $year . "/" . $month);        
        $detail_ng = $db_report->query("SELECT CHR_DATE, CHR_WORK_CENTER, CHR_PART_NO, CHR_BACK_NO, CHR_PART_NAME, "
                . "AMO_PRICE_PER_UNIT, INT_QTY_OK, INT_NG_PRC, INT_NG_BRKNTEST, INT_NG_SETUP, INT_NG_TRIAL "
                . "FROM TR_PROD_RESULT WHERE CHR_DATE LIKE '$periode%'")->result();
        
        foreach ($detail_ng as $value) {
            $amo_ok = $value->AMO_PRICE_PER_UNIT * $value->INT_QTY_OK;
            $tot_ng = $value->INT_NG_PRC + $value->INT_NG_BRKNTEST + $value->INT_NG_SETUP + $value->INT_NG_TRIAL;
            $amo_ng_prc = $value->AMO_PRICE_PER_UNIT * $value->INT_NG_PRC;
            $amo_ng_brkntest = $value->AMO_PRICE_PER_UNIT * $value->INT_NG_BRKNTEST;
            $amo_ng_setup = $value->AMO_PRICE_PER_UNIT * $value->INT_NG_SETUP;
            $amo_ng_trial = $value->AMO_PRICE_PER_UNIT * $value->INT_NG_TRIAL;
            $tot_amo_ng = $amo_ng_prc + $amo_ng_brkntest + $amo_ng_setup + $amo_ng_trial;
            
            $objPHPExcel->getActiveSheet()->setCellValue("B$row", "$seq");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row", "$value->CHR_DATE");
            $objPHPExcel->getActiveSheet()->setCellValue("D$row", "$value->CHR_WORK_CENTER");
            $objPHPExcel->getActiveSheet()->setCellValue("E$row", "$value->CHR_PART_NO");
            $objPHPExcel->getActiveSheet()->setCellValue("F$row", "$value->CHR_BACK_NO");
            $objPHPExcel->getActiveSheet()->setCellValue("G$row", "$value->CHR_PART_NAME");
            $objPHPExcel->getActiveSheet()->setCellValue("H$row", "$value->AMO_PRICE_PER_UNIT");
            $objPHPExcel->getActiveSheet()->setCellValue("I$row", "$value->INT_QTY_OK");
            $objPHPExcel->getActiveSheet()->setCellValue("J$row", "$amo_ok");
            $objPHPExcel->getActiveSheet()->setCellValue("K$row", "$value->INT_NG_PRC");
            $objPHPExcel->getActiveSheet()->setCellValue("L$row", "$value->INT_NG_BRKNTEST");
            $objPHPExcel->getActiveSheet()->setCellValue("M$row", "$value->INT_NG_SETUP");
            $objPHPExcel->getActiveSheet()->setCellValue("N$row", "$value->INT_NG_TRIAL");
            $objPHPExcel->getActiveSheet()->setCellValue("O$row", "$tot_ng");
            $objPHPExcel->getActiveSheet()->setCellValue("P$row", "$amo_ng_prc");
            $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "$amo_ng_brkntest");
            $objPHPExcel->getActiveSheet()->setCellValue("R$row", "$amo_ng_setup");
            $objPHPExcel->getActiveSheet()->setCellValue("S$row", "$amo_ng_trial");
            $objPHPExcel->getActiveSheet()->setCellValue("T$row", "$tot_amo_ng");

            $seq++;
            $row++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("B6:T$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $row++;
        $row_min = $row - 1;
        $objPHPExcel->getActiveSheet()->setCellValue("I$row", "=SUM(I8:I$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("J$row", "=SUM(J8:J$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("K$row", "=SUM(K8:K$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("L$row", "=SUM(L8:L$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("M$row", "=SUM(M8:M$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("N$row", "=SUM(N8:N$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("O$row", "=SUM(O8:O$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("P$row", "=SUM(P8:P$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("Q$row", "=SUM(Q8:Q$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("R$row", "=SUM(R8:R$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("S$row", "=SUM(S8:S$row_min)");
        $objPHPExcel->getActiveSheet()->setCellValue("T$row", "=SUM(T8:T$row_min)");
        $objPHPExcel->getActiveSheet()->getStyle("B6:T$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
        ));
        $objPHPExcel->getActiveSheet()->mergeCells("B$row:H$row");
        $objPHPExcel->getActiveSheet()->setCellValue("B$row", "TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle("B$row:T$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $objPHPExcel->getActiveSheet()->getStyle("B$row:T$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));
        
        ob_end_clean();
        $filename = "Report Production NG by Amount - $periode.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
