<?php

class error_log_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('error_log/error_log_m');
        $this->load->model('pes_new/cogi_m');
    }

    private $layout = '/template/head';

    public function index() {
        $this->role_module_m->authorization('224');

        $data['title'] = 'Report Error Log & COGI';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(224);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'error_log/report_error_log_v';

        $data['role'] = $this->session->userdata('ROLE');
        
        $data['data_chart_error_log'] = $this->error_log_m->select_summary_error_log_by_classname();
        $data['data_error_log'] = $this->error_log_m->get_error_log();
        $data['total_row'] = $this->error_log_m->select_total_row();
        $data['total'] = $this->error_log_m->total_data_error_log();
       
        //COGI
        $data['data_chart_cogi'] = $this->cogi_m->select_summary_cogi_by_classname();
        $data['data_cogi'] = $this->cogi_m->get_cogi();
        $data['total_row_cogi'] = $this->cogi_m->select_total_row();
        $data['total_cogi'] = $this->cogi_m->total_data_cogi();

        $this->load->view($this->layout, $data);
    }

    function print_error_log() {
        $this->load->library('excel');

        $data_error_log = $this->error_log_m->get_error_log();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Error Log");
        $objPHPExcel->getProperties()->setSubject("Report Error Log");
        $objPHPExcel->getProperties()->setDescription("Report Error Log");
        //Set Properties
        //SETUP EXCEL
        $width = 8;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(32);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(60);


        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Acquired Date: ' . date("j/F/Y") . ' ' . date("H:i:s"));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Val Class');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'UOM');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Error Type');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Trans. Date');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'Work Center');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'Sloc From');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Sloc To');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'PDS');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'PL No');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'Total Qty');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'Message');

        $e = 4;
        $no = 1;
        foreach ($data_error_log as $row) {
            
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->CHR_DEPT);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("C$e", $row->CHR_BACK_NO, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->CHR_VAL_CLASS_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CHR_PART_UOM);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->ERROR_TYPE);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->CHR_DATE_ENTRY);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $row->CHR_WORK_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $row->CHR_SLOC_FROM);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $row->CHR_SLOC_TO);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $row->CHR_PDS_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $row->CHR_DEL_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $row->INT_TOTAL_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $row->CHR_MESSAGE);

            $e++;
            $no++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A3:P$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Error_Log_Acquired_Date_at-" . date('Ymd') . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
    //COGI
    function print_cogi() {
        $this->load->library('excel');

        $data_cogi = $this->cogi_m->get_cogi();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Cogi");
        $objPHPExcel->getProperties()->setSubject("Report Cogi");
        $objPHPExcel->getProperties()->setDescription("Report Cogi");
        //Set Properties
        //SETUP EXCEL
        $width = 8;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(34);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(60);

        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Acquired Date: ' . date("j/F/Y") . ' ' . date("H:i:s"));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Total Qty');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'UOM');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Sloc');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Message');

        $e = 4;
        $no = 1;
        foreach ($data_cogi as $row) {
            
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->CHR_DEPT);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("C$e", $row->CHR_BACK_NO, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->INT_TOTAL_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CHR_UOM);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->CHR_SLOC);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->CHR_MESSAGE);

            $e++;
            $no++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A3:I$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Cogi_Acquired_Date_at-" . date('Ymd') . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
    function print_detail_cogi() {
        $this->load->library('excel');

        $data_cogi = $this->cogi_m->get_cogi();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Cogi");
        $objPHPExcel->getProperties()->setSubject("Report Cogi");
        $objPHPExcel->getProperties()->setDescription("Report Cogi");
        //Set Properties
        //SETUP EXCEL
        $width = 8;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(34);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(60);

        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Acquired Date: ' . date("j/F/Y") . ' ' . date("H:i:s"));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'UOM');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Total Qty');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Sloc');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Message');

        $e = 4;
        $no = 1;
        foreach ($data_cogi as $row) {
            
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->CHR_DEPT);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("C$e", $row->CHR_BACK_NO, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->INT_TOTAL_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CHR_UOM);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->CHR_SLOC);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->CHR_MESSAGE);

            $e++;
            $no++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A3:I$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Cogi_Acquired_Date_at-" . date('Ymd') . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    function error_production($msg = NULL) {
        redirect("fail_c");
        $this->role_module_m->authorization('99');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(99);

        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Error Log Production';
        $data['data'] = $this->error_log_m->get_log_error_production();
        $data['content'] = 'error_log/error_log_production_v';
        $this->load->view($this->layout, $data);
    }

    function error_po_gr($msg = NULL) {
redirect("fail_c");
        $this->role_module_m->authorization('100');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(100);

        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Error Log PO - GR';
        $data['data'] = $this->error_log_m->get_log_error_po_gr();
        $data['content'] = 'error_log/error_log_po_gr_v';
        $this->load->view($this->layout, $data);
    }

    function error_movement($msg = NULL) {
        redirect("fail_c");
        $this->role_module_m->authorization('101');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(101);

        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Error Log Movement';
        $data['data'] = $this->error_log_m->get_log_error_movement();
        $data['content'] = 'error_log/error_log_movement_v';
        $this->load->view($this->layout, $data);
    }

}

?>
