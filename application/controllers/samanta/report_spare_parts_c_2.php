<?php

class report_spare_parts_c_2 extends CI_Controller {

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_manage = 'samanta/report_spare_parts_c_2/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('samanta/spare_parts_m');
        $this->load->model('pes_new/production_result_m');
        $this->load->model('samanta/report_spare_parts_m');
        $this->load->config('pdf_config');
        $this->load->library('fpdf/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
    }

    public function index($msg = NULL) {
        $this->role_module_m->authorization('16');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button>Data <strong>tidak ditemukan </strong>silahkan pilih periode yang lain</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        }
        $data['msg'] = $msg;
        
        $data['title'] = 'Spare Parts Report';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(227);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'samanta/report_spare_parts_v_2';
        
                // $date_now = date("Ymd");
        // $date = substr($date_now,6);
        $date = date('Y') . date('m');
        $loc = '';
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $get_amount_inventory = $this->report_spare_parts_m->get_amount_inventory_total();
        $inventory = $get_amount_inventory->TOTAL_INVENTORY;

        $get_amount_in = $this->report_spare_parts_m->get_amount_in($date,$loc);
        if ($get_amount_in->num_rows() > 0) {  
            $get_amount_in = $get_amount_in->row(); 
            $total_in = $get_amount_in->CHR_AMOUNT_IN;
        } else { 
            $total_in = 0; 
        }

        $get_amount_out = $this->report_spare_parts_m->get_amount_out($date,$loc);
        if ($get_amount_out->num_rows() > 0) {
            $get_amount_out = $get_amount_out->row();
            $total_out = $get_amount_out->CHR_AMOUNT_OUT;
        } else { 
            $total_out = 0; 
        }
        $data['w_sloc'] = $this->spare_parts_m->get_all_sloc();
        $loc_1 = $this->spare_parts_m->get_top1_sloc();

        $data['sloc2'] = '';
        $data['total_in'] = $total_in;
        $data['total_out'] = $total_out;
        $data['inventory'] = $inventory;

        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;
        
        $data['role'] = $this->session->userdata('ROLE');
        $data['sum_date_this_month'] = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));      

        $data['data_spare_parts_in'] = $this->report_spare_parts_m->data_spare_parts_in($date,$loc);
        $data['data_spare_parts_out'] = $this->report_spare_parts_m->data_spare_parts_out($date,$loc);
        // CC
        $data['data_cc_in'] = $this->report_spare_parts_m->data_cc_in($date,$loc);
        $data['data_cc_out'] = $this->report_spare_parts_m->data_cc_out($date,$loc);
        // DL
        $data['data_dl_in'] = $this->report_spare_parts_m->data_dl_in($date,$loc);
        $data['data_dl_out'] = $this->report_spare_parts_m->data_dl_out($date,$loc);
        // BP
        $data['data_bp_in'] = $this->report_spare_parts_m->data_bp_in($date,$loc);
        $data['data_bp_out'] = $this->report_spare_parts_m->data_bp_out($date,$loc);
        // DF
        $data['data_df_in'] = $this->report_spare_parts_m->data_df_in($date,$loc);
        $data['data_df_out'] = $this->report_spare_parts_m->data_df_out($date,$loc);
        // AL
        $data['data_al_in'] = $this->report_spare_parts_m->data_al_in($date,$loc);
        $data['data_al_out'] = $this->report_spare_parts_m->data_al_out($date,$loc);
        $this->load->view($this->layout, $data);
    }

    public function search($date = '', $loc ='', $msg=NULL) {
        $this->role_module_m->authorization('16');

        $date_now = date('Y') . date('m');

        $data['content'] = 'samanta/report_spare_parts_v_2';
        $data['title'] = 'Spare Parts Report';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(227);
        $data['news'] = $this->news_m->get_news();
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        
        if ($date == $date_now) {
            if ($loc == '') {
                $get_amount_inventory = $this->report_spare_parts_m->get_amount_inventory_total();
                $inventory = $get_amount_inventory->TOTAL_INVENTORY;
            } else { 
                $get_amount_inventory = $this->report_spare_parts_m->get_amount_inventory($loc);
                $inventory = $get_amount_inventory->TOTAL_INVENTORY;
            }
        } else {
            if ($loc == '') {
                $get_amount_inventory = $this->report_spare_parts_m->get_amount_inventory_total_history($date);
                if ($get_amount_inventory == NULL) {
                    $inventory = 0;
                } else {
                    $inventory = $get_amount_inventory->TOTAL_INVENTORY;
                }
            } else { 
                $get_amount_inventory = $this->report_spare_parts_m->get_amount_inventory_history($date, $loc);
                if ($get_amount_inventory == '0') {
                    $inventory = 0;
                } else {
                    $inventory = $get_amount_inventory->TOTAL_INVENTORY;
                }
            }
        }

        $get_amount_in = $this->report_spare_parts_m->get_amount_in($date,$loc);
        if ($get_amount_in->num_rows() > 0) {  
            $get_amount_in = $get_amount_in->row(); 
            $total_in = $get_amount_in->CHR_AMOUNT_IN;
        } else { 
            $total_in = 0; 
        }

        $get_amount_out = $this->report_spare_parts_m->get_amount_out($date,$loc);
        if ($get_amount_out->num_rows() > 0) {
            $get_amount_out = $get_amount_out->row();
            $total_out = $get_amount_out->CHR_AMOUNT_OUT;
        } else { 
            $total_out = 0; 
        }
        $data['w_sloc'] = $this->spare_parts_m->get_all_sloc();
        $data['sloc2'] = $loc;
        $data['total_in'] = $total_in;
        $data['total_out'] = $total_out;
        $data['inventory'] = $inventory;

        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;
        
        $data['role'] = $this->session->userdata('ROLE');
        $data['sum_date_this_month'] = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
        $data['first_sunday'] = $this->firstSunday(substr($date, 0, 4) . '-' . substr($date, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($date, 0, 4) . '-' . substr($date, 4, 2));

        $data['data_spare_parts_in'] = $this->report_spare_parts_m->data_spare_parts_in($date,$loc);
        $data['data_spare_parts_out'] = $this->report_spare_parts_m->data_spare_parts_out($date,$loc);
        // CC
        $data['data_cc_in'] = $this->report_spare_parts_m->data_cc_in($date,$loc);
        $data['data_cc_out'] = $this->report_spare_parts_m->data_cc_out($date,$loc);
        // DL
        $data['data_dl_in'] = $this->report_spare_parts_m->data_dl_in($date,$loc);
        $data['data_dl_out'] = $this->report_spare_parts_m->data_dl_out($date,$loc);
        // BP
        $data['data_bp_in'] = $this->report_spare_parts_m->data_bp_in($date,$loc);
        $data['data_bp_out'] = $this->report_spare_parts_m->data_bp_out($date,$loc);
        // DF
        $data['data_df_in'] = $this->report_spare_parts_m->data_df_in($date,$loc);
        $data['data_df_out'] = $this->report_spare_parts_m->data_df_out($date,$loc);
        // AL
        $data['data_al_in'] = $this->report_spare_parts_m->data_al_in($date,$loc);
        $data['data_al_out'] = $this->report_spare_parts_m->data_al_out($date,$loc);
        
        $data['msg'] = $msg;
        $this->load->view($this->layout, $data);
    }

    function firstSunday($date) {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Sunday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function firstSaturday($date) {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Saturday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    // add fitur download excel
    // by   : IJA
    // date : 15.04.2019
    // start
    function export_report_all_data(){
        $this->load->library('excel');
        
        $list_data = $this->spare_parts_m->get_data_all_spare_parts_excel();
        $date_now = date("d-M-Y  H:i:s"); 

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $sheetProperties = $objPHPExcel->getProperties();
        $sheetProperties->setCreator(trim($this->session->userdata('USERNAME')));
        $sheetProperties->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $sheetProperties->setTitle("ALL SPARE PARTS DATA");
        $sheetProperties->setSubject("ALL SPARE PARTS DATA");
        $sheetProperties->setDescription("ALL SPARE PARTS DATA");
                
        //Header TR
        $sheetActivate = $objPHPExcel->getActiveSheet();
        $sheetActivate->setCellValue('A1', 'LIST SPARE PARTS PT AISIN INDONESIA');
        $sheetActivate->setCellValue('A3', 'Print Date : '.$date_now);
        $sheetActivate->setCellValue('A4', 'No');
        $sheetActivate->setCellValue('B4', 'Aii Spare Part No');
        $sheetActivate->setCellValue('C4', 'Spare Part Name');
        $sheetActivate->setCellValue('D4', 'Specification');
        $sheetActivate->setCellValue('E4', 'Component');
        $sheetActivate->setCellValue('F4', 'Model');
        $sheetActivate->setCellValue('G4', 'Back No');
        $sheetActivate->setCellValue('H4', 'Qty Use (pcs)');
        $sheetActivate->setCellValue('I4', 'Qty Min (pcs)');
        $sheetActivate->setCellValue('J4', 'Qty Max (pcs)');
        $sheetActivate->setCellValue('K4', 'Actual Stock');
        $sheetActivate->setCellValue('L4', 'Price');
        $sheetActivate->setCellValue('M4', 'Amount');
        $sheetActivate->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetActivate->getStyle("A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetActivate->getStyle("A4:M4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $sheetActivate->getStyle('A1')->getFont()->setBold(true)->setSize(20);
        $sheetActivate->getStyle('A3')->getFont()->setItalic(true);

        $sheetActivate->getColumnDimension('A')->setWidth(6);
        $sheetActivate->getColumnDimension('B')->setWidth(15);
        $sheetActivate->getColumnDimension('C')->setWidth(30);
        $sheetActivate->getColumnDimension('D')->setWidth(20);
        $sheetActivate->getColumnDimension('E')->setWidth(14);
        $sheetActivate->getColumnDimension('F')->setWidth(11);
        $sheetActivate->getColumnDimension('G')->setWidth(15);
        $sheetActivate->getColumnDimension('H')->setWidth(12);
        $sheetActivate->getColumnDimension('I')->setWidth(13);
        $sheetActivate->getColumnDimension('J')->setWidth(13);
        $sheetActivate->getColumnDimension('K')->setWidth(11);
        $sheetActivate->getColumnDimension('L')->setWidth(12);
        $sheetActivate->getColumnDimension('M')->setWidth(14);
        
        $sheetActivate->mergeCells('A1:M2');
        $sheetActivate->mergeCells('A3:M3');
        //$objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        //$objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
        //$objPHPExcel->getActiveSheet()->mergeCells('02:03');
        
        //Value of All Cells
        $e = 5;
        $i = 5;
        $no = 1;
        foreach($list_data as $data) {
            $sheetActivate->setCellValue('A'.$i, $no);
            $sheetActivate->setCellValue('B'.$i, trim($data->CHR_PART_NO));
            $sheetActivate->setCellValue('C'.$i, trim($data->CHR_SPARE_PART_NAME));
            $sheetActivate->setCellValue('D'.$i, trim($data->CHR_SPECIFICATION));
            $sheetActivate->setCellValue('E'.$i, trim($data->CHR_COMPONENT));
            $sheetActivate->setCellValue('F'.$i, trim($data->CHR_MODEL));
            $sheetActivate->setCellValue('G'.$i, trim($data->CHR_BACK_NO));        
            $sheetActivate->setCellValue('H'.$i, $data->INT_QTY_USE);                
            $sheetActivate->setCellValue('I'.$i, $data->INT_QTY_MIN);        
            $sheetActivate->setCellValue('J'.$i, $data->INT_QTY_MAX);
            $sheetActivate->setCellValue('K'.$i, $data->INT_QTY_ACT);        
            $sheetActivate->setCellValue('L'.$i, $data->CHR_PRICE);
            $sheetActivate->setCellValue('M'.$i, $data->Amount);
            /*$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $data->MNY_FEBRUARY);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $data->MNY_MARCH);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $data->MNY_TOTAL_AMOUNT);*/
            
            $i++;
            $no++;
        }
        $sheetActivate->getStyle("A".$e.":K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetActivate->getStyle("L".$e.":M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            ),
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 11,
                'name'  => 'Calibri'
            )
        );


        
        $sheetActivate->getStyle("A4:M4")->applyFromArray($styleArray2);
        
        $filename = "ALL SPARE PARTS DATA.xls";
        
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function generate_detail($tanggal2, $opt_sloc){
        $this->load->library('excel');
        if (is_null($opt_sloc) || $opt_sloc=='arch' || $opt_sloc=='') {
            $list_data = $this->spare_parts_m->get_data_detail_all_per_month($tanggal2);
        }
        else {
            $list_data = $this->spare_parts_m->get_data_detail_per_sloc_per_month($tanggal2, $opt_sloc);
        }

        $date_now = date("d-M-Y  H:i:s"); 

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $sheetProperties = $objPHPExcel->getProperties();
        $sheetProperties->setCreator(trim($this->session->userdata('USERNAME')));
        $sheetProperties->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $sheetProperties->setTitle("DETAIL TRANSACTION");
        $sheetProperties->setSubject("DETAIL TRANSACTION");
        $sheetProperties->setDescription("DETAIL TRANSACTION");
                
        //Header TR
        $sheetActivate = $objPHPExcel->getActiveSheet();
        $sheetActivate->setCellValue('A1', 'DETAIL TRANSACTION SPARE PARTS PT AISIN INDONESIA');
        $sheetActivate->setCellValue('A3', 'Download Date : '.$date_now);
        $sheetActivate->setCellValue('A4', 'No');
        $sheetActivate->setCellValue('B4', 'Aii Spare Part No');        
        $sheetActivate->setCellValue('C4', 'Rack No');
        $sheetActivate->setCellValue('D4', 'Spare Part Name');
        $sheetActivate->setCellValue('E4', 'Specification');
        $sheetActivate->setCellValue('F4', 'Location From');
        $sheetActivate->setCellValue('G4', 'Location To');
        $sheetActivate->setCellValue('H4', 'Transaction');
        $sheetActivate->setCellValue('I4', 'Qty');
        $sheetActivate->setCellValue('J4', 'UoM');
        $sheetActivate->setCellValue('K4', 'Entried By');
        $sheetActivate->setCellValue('L4', 'Entried Date');
        $sheetActivate->setCellValue('M4', 'Entried Time');

        $sheetActivate->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetActivate->getStyle("A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetActivate->getStyle("A4:M4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $sheetActivate->getStyle('A1')->getFont()->setBold(true)->setSize(20);
        $sheetActivate->getStyle('A3')->getFont()->setItalic(true);

        $sheetActivate->getColumnDimension('A')->setWidth(6);
        $sheetActivate->getColumnDimension('B')->setWidth(15);
        $sheetActivate->getColumnDimension('C')->setWidth(10);
        $sheetActivate->getColumnDimension('D')->setWidth(30);
        $sheetActivate->getColumnDimension('E')->setWidth(39);
        $sheetActivate->getColumnDimension('F')->setWidth(13);
        $sheetActivate->getColumnDimension('G')->setWidth(13);
        $sheetActivate->getColumnDimension('H')->setWidth(15);
        $sheetActivate->getColumnDimension('I')->setWidth(10);
        $sheetActivate->getColumnDimension('J')->setWidth(10);
        $sheetActivate->getColumnDimension('K')->setWidth(15);
        $sheetActivate->getColumnDimension('L')->setWidth(15);
        $sheetActivate->getColumnDimension('M')->setWidth(15);
        
        $sheetActivate->mergeCells('A1:M2');
        $sheetActivate->mergeCells('A3:M3');
        //$objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
        //$objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
        //$objPHPExcel->getActiveSheet()->mergeCells('02:03');
        
        //Value of All Cells
        $e = 5;
        $i = 5;
        $no = 1;
        foreach($list_data as $data) {
            $sheetActivate->setCellValue('A'.$i, $no);
            $sheetActivate->setCellValue('B'.$i, trim($data->CHR_PART_NO));
            $sheetActivate->setCellValue('C'.$i, trim($data->CHR_RACK_NO));
            $sheetActivate->setCellValue('D'.$i, trim($data->CHR_SPARE_PART_NAME));
            $sheetActivate->setCellValue('E'.$i, trim($data->CHR_SPECIFICATION));
            $sheetActivate->setCellValue('F'.$i, trim($data->CHR_LOCATION_FROM));
            $sheetActivate->setCellValue('G'.$i, trim($data->CHR_LOCATION_TO));
            $sheetActivate->setCellValue('H'.$i, $data->CHR_TYPE_TRANS);
            $sheetActivate->setCellValue('I'.$i, $data->INT_QTY);
            $sheetActivate->setCellValue('J'.$i, $data->CHR_UOM);
            $sheetActivate->setCellValue('K'.$i, $data->CHR_ENTRIED_BY);
            $sheetActivate->setCellValue('L'.$i, $data->CHR_ENTRIED_DATE);
            $sheetActivate->setCellValue('M'.$i, $data->CHR_ENTRIED_TIME);
            $i++;
            $no++;
        }
        $sheetActivate->getStyle("A".$e.":C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetActivate->getStyle("D".$e.":E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheetActivate->getStyle("F".$e.":K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheetActivate->getStyle("L".$e.":M".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            ),
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 11,
                'name'  => 'Calibri'
            )
        );

        $sheetActivate->getStyle("A4:M4")->applyFromArray($styleArray2);

        $filename = "Transaction_Detail_Sparepart.xls";        
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function generate_report_pdf($tanggal){
        $date_now = date('Y') . date('m');
        $db_samanta = $this->load->database("samanta", TRUE);
        // $index = 1;
        // $index_page = 1;
        if (substr($tanggal,4,2) == '01') { 
            $date_report = 'JAN ' . substr($tanggal,0,4); 
        }
        else if (substr($tanggal,4,2) == '02') { $date_report = 'FEB ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '03') { $date_report = 'MAR ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '04') { $date_report = 'APR ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '05') { $date_report = 'MAY ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '06') { $date_report = 'JUN ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '07') { $date_report = 'JUL ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '08') { $date_report = 'AUG ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '09') { $date_report = 'SEP ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '10') { $date_report = 'OCT ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '11') { $date_report = 'NOV ' . substr($tanggal,0,4); }
        else if (substr($tanggal,4,2) == '12') { $date_report = 'DEC ' . substr($tanggal,0,4); }

        $pdf = new FPDF('P', 'mm', 'A3');
        //MARGIN (kiri, atas, kanan, bawah)
        $pdf->SetMargins(10, 10, 10, 0);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Courier', '', 11);

        //$pdf->Image('logo.png',80,8,33);

        if ($tanggal == $date_now) {
            $data_part = $db_samanta->query("SELECT DISTINCT C.CHR_SLOC, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_SPECIFICATION,  
                                                    (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, C.INT_QTY AS INT_QTY_ACT,  
                                                    (CONVERT(FLOAT,A.CHR_PRICE)*C.INT_QTY) AS AMOUNT
                                                    FROM TM_SPARE_PARTS A
                                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                                    WHERE A.CHR_FLAG_DELETE = 'F' and A.CHR_PART_TYPE = 1
                                                    ORDER BY C.CHR_SLOC, A.CHR_PART_NO")->result();

            $total = $db_samanta->query("SELECT SUM(CONVERT(FLOAT,A.CHR_PRICE)*C.INT_QTY) AS total_amount
                                                    FROM TM_SPARE_PARTS A
                                                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                                                    WHERE A.CHR_FLAG_DELETE = 'F' AND A.CHR_PART_TYPE = 1")->row();            
        } else {            
            $data_part = $db_samanta->query("SELECT CHR_SLOC, CHR_PART_NO, CHR_BACK_NO, CHR_SPARE_PART_NAME, CHR_SPECIFICATION, CHR_PRICE, INT_QTY_ACT, INT_AMOUNT AS AMOUNT
                                                FROM TT_INV_HISTORY_LIST WHERE DATE = '$tanggal'")->result();
            $total = $db_samanta->query("SELECT INT_TOTAL_AMOUNT_INV AS total_amount
                                            FROM TT_INV_HISTORY WHERE SLOC = 'ACC' AND DATE = '$tanggal'")->row();
            
            if ($total == NULL) {
                redirect($this->back_to_manage . $msg = 1);
            }
        }

        // Title
        $pdf->SetFillColor(24,116,205);
        $pdf->SetTextColor(255);
        //$pdf->SetDrawColor(128,0,0);
        $pdf->SetLineWidth(0,2);
        $pdf->SetFont('','B', 15);
        $pdf->Cell(278, 10, "INVENTORY DIES MAINTENANCE (STANDARD PARTS > 1 MIO) " . $date_report, 0, 0, 'C', true);
        $pdf->Ln();
        $pdf->Ln(2);

        $w = array(10,7,26,20,60,90,20,20,25);
        // Header
        $pdf->SetFillColor(126, 192, 238);
        $pdf->SetTextColor(255);
        //$pdf->SetDrawColor(128,0,0);
        $pdf->SetLineWidth(0,2);
        $pdf->SetFont('Arial','B', 8);
        $pdf->Cell($w[0], 5, "AREA", 1, 0, 'C', true);
        $pdf->Cell($w[1], 5, "NO", 1, 0, 'C', true);
        $pdf->Cell($w[2], 5, "PART NO", 1, 0, 'C', true);
        $pdf->Cell($w[3], 5, "BACK NO", 1, 0, 'C', true);
        $pdf->Cell($w[4], 5, "DIES NAME", 1, 0, 'C', true);
        $pdf->Cell($w[5], 5, "SPECIFICATION", 1, 0, 'C', true);
        $pdf->Cell($w[6], 5, "PRICE", 1, 0, 'C', true);
        $pdf->Cell($w[7], 5, "STOCK QTY", 1, 0, 'C', true);
        $pdf->Cell($w[8], 5, "AMOUNT", 1, 0, 'C', true);
        $pdf->Ln();

        // Content
        $pdf->SetFillColor(224,235,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','', 7);
        $fill=false;
        $x=1;
        foreach($data_part as $row) {
            $pdf->Cell($w[0],4,trim($row->CHR_SLOC),'LR',0,'C',$fill);
            $pdf->Cell($w[1],4,$x,'LR',0,'C',$fill);
            $pdf->Cell($w[2],4,trim($row->CHR_PART_NO),'LR',0,'C',$fill);
            $pdf->Cell($w[3],4," " . trim($row->CHR_BACK_NO),'LR',0,'L',$fill);
            $pdf->Cell($w[4],4,"  " . trim($row->CHR_SPARE_PART_NAME),'LR',0,'L',$fill);
            $pdf->Cell($w[5],4,"  " . trim($row->CHR_SPECIFICATION),'LR',0,'L',$fill);
            $pdf->Cell($w[6],4,number_format($row->CHR_PRICE),'LR',0,'R',$fill);
            $pdf->Cell($w[7],4,number_format($row->INT_QTY_ACT),'LR',0,'R',$fill);
            $pdf->Cell($w[8],4,number_format($row->AMOUNT),'LR',0,'R',$fill);
            $pdf->Ln();
            $fill=!$fill;
            $x++;
        }
        $pdf->Cell(array_sum($w),0,'','T');
        $pdf->Ln();

        // total amount
        $w = array(10,7,26,20,60,90,20,20,25);

        $pdf->SetFont('Arial','B', 8);
        $x_kanban2 = $pdf->GetX();
        $pdf->SetX($x_kanban2 + 233);
        $pdf->Cell(20, 5, "TOTAL :", 0, 0, 'C', true);
        $pdf->Cell(25, 5, number_format($total->total_amount), 0, 0, 'R', true);

        $pdf->Ln(10);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial','', 8);
        $pdf->Cell(16, 5, "LEGEND :", 0, 0, 'L', true);
        $pdf->Cell(30, 5, "MT01 - Dies Maintenance Warehouse", 0, 0, 'L', true);
        $pdf->Ln();
        $x_kanban2 = $pdf->GetX();
        $pdf->SetX($x_kanban2 + 16);
        $pdf->Cell(30, 5, "MT02 - Door Frame Maintenance Warehouse", 0, 0, 'L', true);
        $pdf->Ln();
        // Footer
        
        $pdf->SetFillColor(207, 207, 207);
        $pdf->SetTextColor(0);
        $pdf->SetLineWidth(0,2);
        $pdf->SetFont('Arial','', 7);
        $x_kanban2 = $pdf->GetX();
        $pdf->SetX($x_kanban2 + 150);
        $pdf->Cell(25, 5, "APPROVED BY", 1, 0, 'C', true);
        $pdf->Cell(50, 5, "CHECKED BY", 1, 0, 'C', true);
        $pdf->Cell(50, 5, "PREPARED BY", 1, 0, 'C', true);
        $pdf->Ln();

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $pdf->SetLineWidth(0,2);
        $pdf->SetFont('Arial','', 7);
        $pdf->SetX($x_kanban2 + 150);
        $pdf->Cell(25, 15, "", 1, 0, 'C', true);
        $pdf->Cell(25, 15, "", 1, 0, 'C', true);
        $pdf->Cell(25, 15, "", 1, 0, 'C', true);
        $pdf->Cell(25, 15, "", 1, 0, 'C', true);
        $pdf->Cell(25, 15, "", 1, 0, 'C', true);
        $pdf->Ln();

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $pdf->SetLineWidth(0,2);
        $pdf->SetFont('Arial','', 7);
        $pdf->SetX($x_kanban2 + 150);
        $pdf->Cell(25, 5, "Arief Widodo", 1, 0, 'C', true);
        $pdf->Cell(25, 5, "Antonius D.H.", 1, 0, 'C', true);
        $pdf->Cell(25, 5, "Deni S.", 1, 0, 'C', true);
        $pdf->Cell(25, 5, "Rudi R.", 1, 0, 'C', true);
        $pdf->Cell(25, 5, "Dodi D.", 1, 0, 'C', true);

        $pdf->Output();
    }
}
