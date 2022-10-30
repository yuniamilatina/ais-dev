<?php

class Report_stock_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('raw_material/report_stock_m');
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->log_m->add_log(11, NULL);
        $this->session->userdata('user_id');

        $data['title'] = 'Report Stock';
        $data['content'] = 'raw_material/report_stock_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(139);
        $data['news'] = $this->news_m->get_news();
        $data['checkedPP01'] = '';
        $data['checkedPP02'] = '';
        $data['checkedPP03'] = '';
        $data['checkedPP04'] = '';
        $data['checkedPP05'] = '';
        $data['checkedWH00'] = '';
        $data['checkedWP01'] = '';
        $data['checkedRE01'] = '';
        $data['checkedWH20'] = '';
        $data['checkedWH30'] = '';
        $data['checkedNeg'] = '';

        $data['data_stock'] = $this->report_stock_m->select_data_stock();
        $data['total'] = $this->report_stock_m->total_data_stock();
        $data['acquired_date'] = $this->report_stock_m->select_acquired_date();
        $data['load_to_sql'] = $this->report_stock_m->is_load_to_sql();
        $this->load->view($this->layout, $data);
    }

    public function search_by() {
        $this->role_module_m->authorization('16');

        $sloc = NULL;
        if ($this->input->post('PP01') != '') {
            $data['checkedPP01'] = 'checked';
            $sloc[] = $this->input->post('PP01');
        } else {
            $data['checkedPP01'] = '';
        }
        if ($this->input->post('PP02') != '') {
            $data['checkedPP02'] = 'checked';
            $sloc[] = $this->input->post('PP02');
        } else {
            $data['checkedPP02'] = '';
        }
        if ($this->input->post('PP03') != '') {
            $data['checkedPP03'] = 'checked';
            $sloc[] = $this->input->post('PP03');
        } else {
            $data['checkedPP03'] = '';
        }
        if ($this->input->post('PP04') != '') {
            $data['checkedPP04'] = 'checked';
            $sloc[] = $this->input->post('PP04');
        } else {
            $data['checkedPP04'] = '';
        }
        if ($this->input->post('PP05') != '') {
            $data['checkedPP05'] = 'checked';
            $sloc[] = $this->input->post('PP05');
        } else {
            $data['checkedPP05'] = '';
        }
        if ($this->input->post('WH00') != '') {
            $data['checkedWH00'] = 'checked';
            $sloc[] = $this->input->post('WH00');
        } else {
            $data['checkedWH00'] = '';
        }
        if ($this->input->post('WP01') != '') {
            $data['checkedWP01'] = 'checked';
            $sloc[] = $this->input->post('WP01');
        } else {
            $data['checkedWP01'] = '';
        }
        if ($this->input->post('RE01') != '') {
            $data['checkedRE01'] = 'checked';
            $sloc[] = $this->input->post('RE01');
        } else {
            $data['checkedRE01'] = '';
        }
        if ($this->input->post('WH20') != '') {
            $data['checkedWH20'] = 'checked';
            $sloc[] = $this->input->post('WH20');
        } else {
            $data['checkedWH20'] = '';
        }
        if ($this->input->post('WH30') != '') {
            $data['checkedWH30'] = 'checked';
            $sloc[] = $this->input->post('WH30');
        } else {
            $data['checkedWH30'] = '';
        }
        if ($this->input->post('isNegatife') != '') {
            $data['checkedNeg'] = 'checked';
        } else {
            $data['checkedNeg'] = '';
        }

        $data['content'] = 'raw_material/report_stock_v';
        $data['title'] = 'Report Stock';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(139);
        $data['news'] = $this->news_m->get_news();

        $data['data_stock'] = $this->report_stock_m->select_data_stock_by($this->input->post('isNegatife'), $sloc);
        $data['total'] = $this->report_stock_m->total_data_stock_by($this->input->post('isNegatife'), $sloc);
        $data['acquired_date'] = $this->report_stock_m->select_acquired_date();
        $data['load_to_sql'] = $this->report_stock_m->is_load_to_sql();
        $this->load->view($this->layout, $data);
    }

    function download() {
        $this->load->library('excel');
        //ini_set('memory_limit', '1024M'); // or you could use 1G

        $data_stock = $this->report_stock_m->select_data_stock_top1000();
//        $data['total'] = $this->report_stock_m->total_data_stock();
//        $data['acquired_date'] = $this->report_stock_m->select_acquired_date();
//        $data['load_to_sql'] = $this->report_stock_m->is_load_to_sql();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Stock");
        $objPHPExcel->getProperties()->setSubject("Report Stock");
        $objPHPExcel->getProperties()->setDescription("Report Stock");
        // Set Properties
        //SETUP EXCEL
        $width = 10;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth($width);

        //SETUP EXCEL
        //HEADER
//        $objPHPExcel->getActiveSheet()->mergeCells('C1:D1');
//        $objPHPExcel->getActiveSheet()->mergeCells('K1:L1');
//        $objPHPExcel->getActiveSheet()->mergeCells('M1:O1');
//        $objPHPExcel->getActiveSheet()->mergeCells('V1:W1');
//        $objPHPExcel->getActiveSheet()->mergeCells('X1:Z1');
//
//        $objPHPExcel->getActiveSheet()->getStyle("B1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//        $objPHPExcel->getActiveSheet()->getStyle("F1:H1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//        $objPHPExcel->getActiveSheet()->getStyle("K1:O1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//        $objPHPExcel->getActiveSheet()->getStyle("V1:Z1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        //HEADER
        //TABLE PRODUCTION QTY
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'SLOC');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Mat Type Name');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Total Qty');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Unit');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Amount');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Std. Cost');

        $e = 2;
        $no = 1;
        foreach ($data_stock as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", $row->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_SLOC);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->CHR_MAT_TYPE_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->INT_TOTAL_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->CHR_PART_UOM);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->CHR_TOTAL_PRICE);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $row->CHR_STD_PRICE);

            $e++;
            $no++;
        }

        $e = $e - 1;
        $objPHPExcel->getActiveSheet()->getStyle("A1:J$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

        $filename = 'Report Data Stock - '.date("Y/m/d") . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
