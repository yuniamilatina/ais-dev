<?php

class inventory_exceed_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('raw_material/inventory_exceeded_m');
        $this->load->model('raw_material/inventory_summary_m');
        $this->load->model('raw_material/inventory_m');
        $this->load->model('organization/dept_m');
        $this->load->model('raw_material/report_stock_m');
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->log_m->add_log(12, NULL);
        $this->session->userdata('user_id');

        $data['title'] = 'Report Exceeded Stock';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(160);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'raw_material/report_inventory_exceeded_v';

        $data['role'] = $this->session->userdata('ROLE');
        $data['acquired_date'] = $this->report_stock_m->select_acquired_date();
        $data['acquired_date_summary'] = $this->inventory_summary_m->select_acquired_date_summary_inventory();

        $data['load_to_sql'] = $this->report_stock_m->is_load_to_sql();
        $data['stat_in_out'] = $this->inventory_m->check_stat_in_out_tmstock();
        $data['data_summary_inventory_by_prod'] = $this->inventory_exceeded_m->select_summary_inventory_by_prod();
        $data['data_data_inventory_by_prod'] = $this->inventory_exceeded_m->select_data_inventory_by_prod();
        $data['data_summary_inventory_by_date'] = $this->inventory_summary_m->select_summary_inventory_by_date();
        $data['total_row'] = $this->inventory_exceeded_m->select_total_row();
        $data['total'] = $this->inventory_exceeded_m->total_data_stock();
        $date = date('Y') . date('m');
        $data['selected_date'] = $date;

        $this->load->view($this->layout, $data);
    }

    function chart_per_unit() {
        $this->role_module_m->authorization('16');
        $this->log_m->add_log(12, NULL);
        $this->session->userdata('user_id');

        $data['title'] = 'Report Exceeded Stock';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(160);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'raw_material/report_inventory_exceeded_chart_qty_v';

        $data['role'] = $this->session->userdata('ROLE');
        $data['acquired_date'] = $this->report_stock_m->select_acquired_date();
        $data['acquired_date_summary'] = $this->inventory_summary_m->select_acquired_date_summary_inventory();

        $data['load_to_sql'] = $this->report_stock_m->is_load_to_sql();
        $data['stat_in_out'] = $this->inventory_m->check_stat_in_out_tmstock();
        $data['data_summary_inventory_by_prod'] = $this->inventory_exceeded_m->select_summary_inventory_by_prod();
        $data['data_data_inventory_by_prod'] = $this->inventory_exceeded_m->select_data_inventory_by_prod();
        $data['data_summary_inventory_by_date'] = $this->inventory_summary_m->select_summary_inventory_by_date();
        $data['total_row'] = $this->inventory_exceeded_m->select_total_row();
        $data['total'] = $this->inventory_exceeded_m->total_data_stock();
        $date = date('Y') . date('m');
        $data['selected_date'] = $date;

        $this->load->view("/template/head_blank", $data);
    }

    function print_inventory_exceed() {
        $this->load->library('excel');

        $acquired_date = $this->report_stock_m->select_acquired_date();
        $data_inventory_by_prod = $this->inventory_exceeded_m->select_data_inventory_by_prod();
        $stat_in_out = $this->inventory_m->check_stat_in_out_tmstock();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Exceeded Stock");
        $objPHPExcel->getProperties()->setSubject("Report Exceeded Stock");
        $objPHPExcel->getProperties()->setDescription("Report Exceeded Stock");
        //Set Properties
        //SETUP EXCEL
        $width = 8;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(21);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(16);

        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Acquired Date: ' . date("j/F/Y", strtotime($acquired_date['CHR_MODIFED_DATE'])) . ' ' . date("H:i:s", strtotime($acquired_date['CHR_MODIFED_TIME'])));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Class');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Sloc');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'UOM');
        if ($stat_in_out == 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Qty Beginning Balance');
            $objPHPExcel->getActiveSheet()->setCellValue('J3', 'Qty In');
            $objPHPExcel->getActiveSheet()->setCellValue('K3', 'Qty Out');
        }
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Qty Stock');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'Amount stock');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'Qty max std');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'Amount max std');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'Qty diff');
        $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'Amount diff');

        $e = 4;
        $no = 1;
        foreach ($data_inventory_by_prod as $row) {
            $end_bal = intval($row->INT_QTY_STOCK);
            $qty_in = intval($row->CHR_TRANS_IN);
            $qty_out = intval($row->CHR_TRANS_OUT);
            $begin_bal = $end_bal - $qty_in + $qty_out;
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->DEPT);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("C$e", $row->CHR_PART_NO, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CLASSNAME);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->CHR_SLOC);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->CHR_PART_UOM);
            if ($stat_in_out == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue("I$e", $begin_bal);
                $objPHPExcel->getActiveSheet()->setCellValue("J$e", $qty_in);
                $objPHPExcel->getActiveSheet()->setCellValue("K$e", $qty_out);
            }
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $end_bal);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $row->AMOUNT_STOCK);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $row->INT_QTY_UPLOAD);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $row->AMOUNT_UPLOAD);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $row->INT_TOTAL_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $row->AMOUNT);
            $e++;
            $no++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A3:Q$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Exceeded_Stock_Acquired_Date_at-" . trim($acquired_date['CHR_MODIFED_DATE']).'_'.trim($acquired_date['CHR_MODIFED_TIME']) . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
