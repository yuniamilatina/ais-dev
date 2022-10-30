<?php

//Add By xcx 20190507
class technical_report_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/patricia/technical_report_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('patricia/technical_report_m');
        $this->load->library('excel');
    }

    function index($msg = NULL) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong>  The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } 
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(76);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Technical Report';
        $data['data'] = $this->technical_report_m->get_technical();
        $data['msg'] = $msg;
        $data['selected_date_awal'] = '';
        $data['selected_date_akhir'] = '';

        $data['content'] = 'patricia/report/technical_report_v';
        $this->load->view($this->layout, $data);
    }

    function excel_technical_list(){
        $data['selected_date_awal'] = $this->input->post('tanggal_awal');
        $data['selected_date_akhir'] = $this->input->post('tanggal_akhir');
        $date1= date("Ymd", strtotime($this->input->post('tanggal_awal'))) ;
        $date2 = date("Ymd", strtotime($this->input->post('tanggal_akhir')));
        
        if($date1 == '19700101' && $date2 != '19700101'){
            $data = $this->technical_report_m->get_technical_by_date2($date2);
        } else if($date1 != '19700101' && $date2 == '19700101'){
            $data = $this->technical_report_m->get_technical_by_date1($date1);
        } else if($date1 == '19700101' && $date2 == '19700101'){
            $data = $this->technical_report_m->get_technical();
        } else {
            $data = $this->technical_report_m->get_technical_by_date($date1,$date2);    
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Technical Report");
        $objPHPExcel->getProperties()->setSubject("Technical Report");
        $objPHPExcel->getProperties()->setDescription("Technical Report");


        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);

        

        $StyleJudul = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $StyleIsi = array(
            'font'  => array(
                'bold'  => false,
                'size'  => 10,
                'name'  => 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
        $AllStyle = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'TR Number');
        $objPHPExcel->getActiveSheet()->getStyle("B1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Problem Experience');
        $objPHPExcel->getActiveSheet()->getStyle("C1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Problem Rank');
        $objPHPExcel->getActiveSheet()->getStyle("D1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Part Number');
        $objPHPExcel->getActiveSheet()->getStyle("E1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Part Name');
        $objPHPExcel->getActiveSheet()->getStyle("F1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Supplier');
        $objPHPExcel->getActiveSheet()->getStyle("G1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Date');
        $objPHPExcel->getActiveSheet()->getStyle("H1")->applyFromArray($StyleJudul);

        $baris = 2;
        foreach($data as $tr)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $baris-1);
            $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $tr->CHR_TR_NO);
            $objPHPExcel->getActiveSheet()->getStyle("B".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $tr->CHR_PROB_EXP);
            $objPHPExcel->getActiveSheet()->getStyle("C".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, $tr->CHR_PROB_RANK);
            $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, trim($tr->CHR_ID_PART));
            $objPHPExcel->getActiveSheet()->getStyle("E".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, trim($tr->CHR_NAMA_PART));
            $objPHPExcel->getActiveSheet()->getStyle('F'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $tr->CHR_NAMA_VENDOR);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("G".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$baris,date("d F Y", strtotime($tr->CHR_TR_DATE)));
            $objPHPExcel->getActiveSheet()->getStyle("H".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->getAlignment()->setWrapText(true);
            $baris = $baris +1;
        }
        $objPHPExcel->getActiveSheet()->getStyle("A1:H".$baris)->applyFromArray($AllStyle);
        $filename = "Technical Report". "-" . date("Y/m/d") . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    function excel_technical($id)
    {
        $this->role_module_m->authorization('76');
        $data = $this->technical_report_m-> get_data_tr($id);

        //
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Technical Report");
        $objPHPExcel->getProperties()->setSubject("Technical Report");
        $objPHPExcel->getProperties()->setDescription("Technical Report");

        // Setting Lebar Kolom
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(6.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(9);

         // Setting Tinggi Baris
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(9);
        $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('13')->setRowHeight(21.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('14')->setRowHeight(28.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('15')->setRowHeight(25.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('16')->setRowHeight(25.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('17')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('18')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('19')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('20')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('21')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('22')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('23')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('24')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('25')->setRowHeight(36);
        $objPHPExcel->getActiveSheet()->getRowDimension('26')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension('27')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension('28')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension('29')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('30')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('31')->setRowHeight(90);
        $objPHPExcel->getActiveSheet()->getRowDimension('32')->setRowHeight(18);

        // Border
        $AllStyle = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );

        $LeftStyle = array(
          'borders' => array(
            'left' => array('style' => PHPExcel_Style_Border::BORDER_NONE
          )
        )
        );
        $InsideStyle = array(
            'borders' => array(
                    'inside' => array('style' => PHPExcel_Style_Border::BORDER_NONE
                )
            )
        );
        $rightStyle = array(
          'borders' => array(
            'right' => array('style' => PHPExcel_Style_Border::BORDER_NONE
          )
        )
        );
        $objPHPExcel->getActiveSheet()->getStyle("J2:N3")->applyFromArray($AllStyle);
        $objPHPExcel->getActiveSheet()->getStyle("A5:N31")->applyFromArray($AllStyle);

        $objPHPExcel->getActiveSheet()->getStyle("C6")->applyFromArray($rightStyle);
        $objPHPExcel->getActiveSheet()->getStyle("C7")->applyFromArray($rightStyle);
        $objPHPExcel->getActiveSheet()->getStyle("C8")->applyFromArray($rightStyle);
        $objPHPExcel->getActiveSheet()->getStyle("C9")->applyFromArray($rightStyle);
        $objPHPExcel->getActiveSheet()->getStyle("C10")->applyFromArray($rightStyle);
        $objPHPExcel->getActiveSheet()->getStyle("D6")->applyFromArray($LeftStyle);
        $objPHPExcel->getActiveSheet()->getStyle("D7")->applyFromArray($LeftStyle);
        $objPHPExcel->getActiveSheet()->getStyle("D8")->applyFromArray($LeftStyle);
        $objPHPExcel->getActiveSheet()->getStyle("D9")->applyFromArray($LeftStyle);
        $objPHPExcel->getActiveSheet()->getStyle("D10")->applyFromArray($LeftStyle);
        $objPHPExcel->getActiveSheet()->getStyle("A12:C15")->applyFromArray($InsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("D12:E15")->applyFromArray($InsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("F12:H15")->applyFromArray($InsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("I12:K15")->applyFromArray($InsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("L12:N15")->applyFromArray($InsideStyle);

        // Merge
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('E2:I2');
        $objPHPExcel->getActiveSheet()->mergeCells('E3:I3');
        $objPHPExcel->getActiveSheet()->mergeCells('K2:N2');
        $objPHPExcel->getActiveSheet()->mergeCells('K3:N3');
        $objPHPExcel->getActiveSheet()->mergeCells('A5:N5');
        for($i=6;$i<=10;$i++)
        {
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':B'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':K'.$i);
        }


        $objPHPExcel->getActiveSheet()->mergeCells('L6:N6');
        $objPHPExcel->getActiveSheet()->mergeCells('L7:N10');
        for($i=11;$i<=15;$i++)
        {
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$i.':E'.$i);
            $objPHPExcel->getActiveSheet()->mergeCells('F'.$i.':H'.$i);
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A16:N16');
        $objPHPExcel->getActiveSheet()->mergeCells('A17:N25');

        $objPHPExcel->getActiveSheet()->mergeCells('A26:B28');
        $objPHPExcel->getActiveSheet()->mergeCells('C26:G26');
        $objPHPExcel->getActiveSheet()->mergeCells('C27:G27');
        $objPHPExcel->getActiveSheet()->mergeCells('C28:G28');
        $objPHPExcel->getActiveSheet()->mergeCells('H26:J26');
        $objPHPExcel->getActiveSheet()->mergeCells('K26:N26');
        $objPHPExcel->getActiveSheet()->mergeCells('H27:N27');
        $objPHPExcel->getActiveSheet()->mergeCells('H28:N28');

        $objPHPExcel->getActiveSheet()->mergeCells('A29:B30');
        $objPHPExcel->getActiveSheet()->mergeCells('C29:G30');
        $objPHPExcel->getActiveSheet()->mergeCells('H29:N29');
        $objPHPExcel->getActiveSheet()->mergeCells('H30:I30');
        $objPHPExcel->getActiveSheet()->mergeCells('J30:L30');
        $objPHPExcel->getActiveSheet()->mergeCells('M30:N30');

        $objPHPExcel->getActiveSheet()->mergeCells('A31:D31');
        $objPHPExcel->getActiveSheet()->mergeCells('F31:G31');
        $objPHPExcel->getActiveSheet()->mergeCells('H31:I31');
        $objPHPExcel->getActiveSheet()->mergeCells('J31:L31');
        $objPHPExcel->getActiveSheet()->mergeCells('M31:N31');
        $objPHPExcel->getActiveSheet()->mergeCells('A32:N32');

        $objPHPExcel->getActiveSheet()->mergeCells('I12:K15');
        $objPHPExcel->getActiveSheet()->mergeCells('I11:K11');
        $objPHPExcel->getActiveSheet()->mergeCells('L12:N15');
        $objPHPExcel->getActiveSheet()->mergeCells('L11:N11');

        // Header
        $profil1 = array(
            'font' => array(
                'bold' => false, 
                'size' => 12,
                'name'=> 'Courier New'),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,)
        );
        $profil2 = array(
            'font' => array(
                'bold' => false, 
                'size' => 8,
                'name'=> 'Courier New'),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,)
        );
        $style10 = array(
            'font' => array(
                'bold' => false, 
                'size' => 10,
                'name'=> 'Courier New'),
            'alignment' => array(
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,)
        );
        $style10center = array(
            'font' => array(
                'bold' => false, 
                'size' => 10,
                'name'=> 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,)
        );
        $style10topleft= array(
            'font' => array(
                'bold' => false, 
                'size' => 10,
                'name'=> 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP,)
        );
        $style10topcenter= array(
            'font' => array(
                'bold' => false, 
                'size' => 10,
                'name'=> 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP,)
        );
        $style14 = array(
            'font' => array(
                'bold' => false, 
                'size' => 14,
                'name'=> 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,)
        );
        $style14Left = array(
            'font' => array(
                'bold' => false, 
                'size' => 14,
                'name'=> 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,)
        );
        $StyleJudul = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 20,
                'name'  => 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        $style9 = array(
            'font' => array(
                'bold' => false, 
                'size' => 9,
                'name'=> 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,)
        );
        $style72 = array(
            'font' => array(
                'bold' => true, 
                'size' => 72,
                'name'=> 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,)
        );
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'PT. AISIN INDONESIA');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($profil1);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Plot 5J Kawasan EJIP Lemah Abang');
        $objPHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($profil2);
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Bekasi 17550 Telp 8970909');
        $objPHPExcel->getActiveSheet()->getStyle("A3")->applyFromArray($profil2);
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'TECHNICAL REPORT');
        $objPHPExcel->getActiveSheet()->getStyle("E2")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'TO');
        $objPHPExcel->getActiveSheet()->getStyle("J2")->applyFromArray($style10);

        $objPHPExcel->getActiveSheet()->getStyle("J2")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'ATTN');
        $objPHPExcel->getActiveSheet()->getStyle("J3")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("J3")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'QA DEPT');
        $objPHPExcel->getActiveSheet()->getStyle("K3")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'PROBLEM INFORMATION');
        $objPHPExcel->getActiveSheet()->getStyle("A5")->applyFromArray($style14);
        $objPHPExcel->getActiveSheet()->getStyle("A5")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');

        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'ISSUE DATE');
        $objPHPExcel->getActiveSheet()->getStyle("A6")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("A6")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');

        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'TR NO.');
        $objPHPExcel->getActiveSheet()->getStyle("A7")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("A7")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');

        $objPHPExcel->getActiveSheet()->setCellValue('A8', 'PART NO');
        $objPHPExcel->getActiveSheet()->getStyle("A8")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("A8")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');

        $objPHPExcel->getActiveSheet()->setCellValue('A9', 'PART NAME');
        $objPHPExcel->getActiveSheet()->getStyle("A9")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("A9")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('A10', 'QUANTITY');
        $objPHPExcel->getActiveSheet()->getStyle("A10")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("A10")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');

        $objPHPExcel->getActiveSheet()->setCellValue('L6', 'PROBLEM RANK');
        $objPHPExcel->getActiveSheet()->getStyle("L6")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->getStyle("L6")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');

        $objPHPExcel->getActiveSheet()->setCellValue('A11', 'DEFFECT TYPE');
        $objPHPExcel->getActiveSheet()->getStyle("A11")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("A11")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('D11', 'PROBLEM EXPERIENCED');
        $objPHPExcel->getActiveSheet()->getStyle("D11")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("D11")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('F11', 'LOCATION');
        $objPHPExcel->getActiveSheet()->getStyle("F11")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("F11")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('I11', 'STANDARD PART');
        $objPHPExcel->getActiveSheet()->getStyle("I11")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->getStyle("I11")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('25963c');

        $objPHPExcel->getActiveSheet()->setCellValue('L11', 'ACTUAL PART');
        $objPHPExcel->getActiveSheet()->getStyle("L11")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->getStyle("L11")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ff1c1c');

        $objPHPExcel->getActiveSheet()->setCellValue('A26', 'NEXT ACTION                 ( 4-3-2 SYSTEM )');
        $objPHPExcel->getActiveSheet()->getStyle("A26")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->getStyle('A26')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("A26")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('C26', '4H : TEMPORARY ACTION');
        $objPHPExcel->getActiveSheet()->getStyle("C26")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("C26")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('C27', '3D : SUBMIT PRE - REPORT');
        $objPHPExcel->getActiveSheet()->getStyle("C27")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("C27")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('C28', '2W : SUBMIT FINAL A3 REPORT');
        $objPHPExcel->getActiveSheet()->getStyle("C28")->applyFromArray($style10);
        $objPHPExcel->getActiveSheet()->getStyle("C28")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');
        $objPHPExcel->getActiveSheet()->setCellValue('A29', 'MONITORING IMPROVEMENT ACTIVITY');
        $objPHPExcel->getActiveSheet()->getStyle('A29')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle("A29")->applyFromArray($style9);

        $objPHPExcel->getActiveSheet()->setCellValue('H29', 'QUALITY');
        $objPHPExcel->getActiveSheet()->getStyle("H29")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->getStyle("H29")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffe01c');

        $objPHPExcel->getActiveSheet()->setCellValue('H30', 'APPROVED');
        $objPHPExcel->getActiveSheet()->getStyle("H30")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->setCellValue('J30', 'CHECKED');
        $objPHPExcel->getActiveSheet()->getStyle("J30")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->setCellValue('M30', 'PREPARED');
        $objPHPExcel->getActiveSheet()->getStyle("M30")->applyFromArray($style10center);

        $objPHPExcel->getActiveSheet()->setCellValue('C6', ':');
        $objPHPExcel->getActiveSheet()->getStyle("C6")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->setCellValue('C7', ':');
        $objPHPExcel->getActiveSheet()->getStyle("C7")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->setCellValue('C8', ':');
        $objPHPExcel->getActiveSheet()->getStyle("C8")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->setCellValue('C9', ':');
        $objPHPExcel->getActiveSheet()->getStyle("C9")->applyFromArray($style10center);
        $objPHPExcel->getActiveSheet()->setCellValue('C10', ':');
        $objPHPExcel->getActiveSheet()->getStyle("C10")->applyFromArray($style10center);

        $objPHPExcel->getActiveSheet()->setCellValue('A31', 'COMMENT');
        $objPHPExcel->getActiveSheet()->getStyle("A31")->applyFromArray($style10topleft);
        $objPHPExcel->getActiveSheet()->setCellValue('E31', 'Date');
        $objPHPExcel->getActiveSheet()->getStyle("E31")->applyFromArray($style10topcenter);
        $objPHPExcel->getActiveSheet()->setCellValue('F31', 'PIC');
        $objPHPExcel->getActiveSheet()->getStyle("F31")->applyFromArray($style10topcenter);


        // set Image 
        $gdImage = imagecreatefrompng(DOCIMG.'/image/patricia/TR/approved.png');
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('approved image');$objDrawing->setDescription('approved image');
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(100);
        $objDrawing->setOffsetX(15);
        $objDrawing->setOffsetY(15);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $gdImage = imagecreatefrompng(DOCIMG.'/image/patricia/TR/approved.png');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setCoordinates('H31');
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('approved image');$objDrawing->setDescription('approved image');
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(100);
        $objDrawing->setOffsetX(15);
        $objDrawing->setOffsetY(15);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $gdImage = imagecreatefrompng(DOCIMG.'/image/patricia/TR/checked.png');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setCoordinates('J31');
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('approved image');$objDrawing->setDescription('approved image');
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(100);
        $objDrawing->setOffsetX(15);
        $objDrawing->setOffsetY(15);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $gdImage = imagecreatefrompng(DOCIMG.'/image/patricia/TR/prepared.png');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setCoordinates('M31');

        // isi
        foreach ($data as $row) {
            # code...
            $objPHPExcel->getActiveSheet()->setCellValue('K2', $row->CHR_NAMA_VENDOR);
            $objPHPExcel->getActiveSheet()->getStyle("K2")->applyFromArray($style10);
            $objPHPExcel->getActiveSheet()->setCellValue('D6', date("d F Y", strtotime($row->CHR_TR_DATE)));
            $objPHPExcel->getActiveSheet()->getStyle("D6")->applyFromArray($style10);
            $objPHPExcel->getActiveSheet()->setCellValue('D7', $row->CHR_TR_NO);
            $objPHPExcel->getActiveSheet()->getStyle("D7")->applyFromArray($style10);
            $objPHPExcel->getActiveSheet()->setCellValue('D8',  $row->CHR_ID_PART_HYP);
            $objPHPExcel->getActiveSheet()->getStyle("D8")->applyFromArray($style10);
            $objPHPExcel->getActiveSheet()->setCellValue('D9', $row->CHR_NAMA_PART);
            $objPHPExcel->getActiveSheet()->getStyle("D9")->applyFromArray($style10);
            $objPHPExcel->getActiveSheet()->setCellValue('D10', $row->INT_QUANTITY.' PCS');
            $objPHPExcel->getActiveSheet()->getStyle("D10")->applyFromArray($style10);
            $objPHPExcel->getActiveSheet()->setCellValue('L7', $row->CHR_PROB_RANK);
            $objPHPExcel->getActiveSheet()->getStyle("L7")->applyFromArray($style72);

            

            // $objPHPExcel->getActiveSheet()->setCellValue("A1", $objRichText);
            if('VISUAL'== $row->CHR_DEFECT_TYPE)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));

                $text2 = $objRichText->createTextRun(' VISUAL');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('A12', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("A12")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' VISUAL');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('A12', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("A12")->applyFromArray($style10);
            }

            if('DIMENSION/FUNCTION'==$row->CHR_DEFECT_TYPE)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' DIMENSION/FUNCTION');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));

                $objPHPExcel->getActiveSheet()->setCellValue('A13', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("A13")->applyFromArray($style10);
                
            }
            else
            {

                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' DIMENSION/FUNCTION');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('A13',  $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("A13")->applyFromArray($style10);
                
            }

            
            if('SPECIAL PROCESS'==$row->CHR_DEFECT_TYPE)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' SPECIAL PROCESS');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('A14',$objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("A14")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' SPECIAL PROCESS');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('A14', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("A14")->applyFromArray($style10);
                
            }
            if('OTHER'==$row->CHR_DEFECT_TYPE)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' OTHER');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('A15', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("A15")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' OTHER');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('A15',$objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("A15")->applyFromArray($style10);
                
            }

            if('FIRST TIME'==$row->CHR_PROB_EXP)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' FIRST TIME');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('D12', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("D12")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' FIRST TIME');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('D12',$objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("D12")->applyFromArray($style10);
                
            }
            if('PREVIOUS'==$row->CHR_PROB_EXP)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' PREVIOUS');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('D13', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("D13")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' PREVIOUS');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('D13',$objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("D13")->applyFromArray($style10);
                
            }


            // Location
            if('RECEIVING'==$row->CHR_LOC)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' RECEIVING');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('F12',$objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("F12")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' RECEIVING');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('F12', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("F12")->applyFromArray($style10);
                
            }
            if('PRODUCTION'==$row->CHR_LOC)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' PRODUCTION');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('F13', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("F13")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' PRODUCTION');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('F13',$objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("F13")->applyFromArray($style10);
                
            }

            if('PDI'==$row->CHR_LOC)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' PDI');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('F14', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("F14")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' PDI');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('F14',$objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("F14")->applyFromArray($style10);
                
            }
            if('CUSTOMER'==$row->CHR_LOC)
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' R');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' CUSTOMER');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('F15', $objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("F15")->applyFromArray($style10);
                
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $text1 = $objRichText->createTextRun(' £');
                $text1->getFont()->applyFromArray(array(  "size" => 10, "name" => "Wingdings 2"));
                $text2 = $objRichText->createTextRun(' CUSTOMER');
                $text2->getFont()->applyFromArray(array(  "size" => 10, "name" => "Courier New"));
                $objPHPExcel->getActiveSheet()->setCellValue('F15',$objRichText);
                $objPHPExcel->getActiveSheet()->getStyle("F15")->applyFromArray($style10);
                
            }

            $objPHPExcel->getActiveSheet()->setCellValue('I12', $row->CHR_STD_PART);
            $objPHPExcel->getActiveSheet()->getStyle("I12")->applyFromArray($style10center);
            $objPHPExcel->getActiveSheet()->getStyle('I12')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->setCellValue('L12',$row->CHR_ACT_PART);
            $objPHPExcel->getActiveSheet()->getStyle("L12")->applyFromArray($style10center);
            $objPHPExcel->getActiveSheet()->getStyle('L12')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->setCellValue('A16', 'PROBLEM INFORMATION : '.$row->CHR_PROB_INFO);
            $objPHPExcel->getActiveSheet()->getStyle("A16")->applyFromArray($style14Left);
            $objPHPExcel->getActiveSheet()->getStyle("A16")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('b7b5b5');

            $objPHPExcel->getActiveSheet()->setCellValue('H26',date("d-M-Y", strtotime($row->CHR_TR_DATE)));
            $objPHPExcel->getActiveSheet()->getStyle("H26")->applyFromArray($style10center);

            $objPHPExcel->getActiveSheet()->setCellValue('K26',date("H:i", strtotime($row->CHR_TEMP_ACTION)));
            $objPHPExcel->getActiveSheet()->getStyle("K26")->applyFromArray($style10center);

            $objPHPExcel->getActiveSheet()->setCellValue('H27',date("d-M-Y", strtotime($row->CHR_SUBMIT_PRE)));
            $objPHPExcel->getActiveSheet()->getStyle("H27")->applyFromArray($style10center);

            $objPHPExcel->getActiveSheet()->setCellValue('H28',date("d-M-Y", strtotime($row->CHR_SUBMIT_FINAL)));
            $objPHPExcel->getActiveSheet()->getStyle("H28")->applyFromArray($style10center);

            $objPHPExcel->getActiveSheet()->setCellValue('C29',date("d-M-Y", strtotime($row->CHR_MONITOR_IMPROV)));
            $objPHPExcel->getActiveSheet()->getStyle("C29")->applyFromArray($style10center);

            $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
            $objDrawing->setName('approved image');$objDrawing->setDescription('approved image');
            $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
            $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);

            $objDrawing->setOffsetX(15);
            $objDrawing->setOffsetY(15);
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

            $gdImage = imagecreatefromjpeg(DOCIMG.'/image/patricia/TR/'.$row->CHR_IMAGE);
            
            $objDrawing->setImageResource($gdImage);
            $objDrawing->setCoordinates('A17');
            $objDrawing->setHeight(400);
            // $objDrawing->setWidth(400);
        }
            

        $filename = "Technical Report". "-" . date("Y/m/d").$partno . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
}
?>