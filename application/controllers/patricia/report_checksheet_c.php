<?php

//Add By xcx 20190507
class report_checksheet_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_index = '/patricia/report_checksheet_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('patricia/report_checksheet_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
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
        $data['sidebar'] = $this->role_module_m->side_bar(39);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Detail Checksheet';
        $data['data'] = $this->report_checksheet_m->get_checksheet();
        $data['msg'] = $msg;
        $data['selected_date_awal'] = '';
        $data['selected_date_akhir'] = '';
        $data['content'] = 'patricia/report/report_checksheet_v';
        $this->load->view($this->layout, $data);
    }
    function excel_check_list()
    {
        $data['selected_date_awal'] = $this->input->post('tanggal_awal');
        $data['selected_date_akhir'] = $this->input->post('tanggal_akhir');
        $date1= date("Ymd", strtotime($this->input->post('tanggal_awal'))) ;
        $date2 = date("Ymd", strtotime($this->input->post('tanggal_akhir')));
        if($date1 == '19700101' && $date2 != '19700101')
        {
            $data = $this->report_checksheet_m->get_checksheet_by_date2($date2);
        }
        else if($date1 != '19700101' && $date2 == '19700101')
        {
            $data = $this->report_checksheet_m->get_checksheet_by_date1($date1);
        }
        else if($date1 == '19700101' && $date2 == '19700101')
        {
            $data = $this->report_checksheet_m->get_checksheet();
        }
        else
        {
            $data = $this->report_checksheet_m->get_checksheet_by_date($date1,$date2);    
        }
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Detail Checksheet");
        $objPHPExcel->getProperties()->setSubject("Report Detail Checksheet");
        $objPHPExcel->getProperties()->setDescription("Report Detail Checksheet");


        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);

        

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
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Date');
        $objPHPExcel->getActiveSheet()->getStyle("B1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Part Number');
        $objPHPExcel->getActiveSheet()->getStyle("C1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Part Name');
        $objPHPExcel->getActiveSheet()->getStyle("D1")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Supplier');
        $objPHPExcel->getActiveSheet()->getStyle("E1")->applyFromArray($StyleJudul);

        $baris = 2;
        foreach($data as $tr)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $baris-1);
            $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, date("d F Y", strtotime($tr->CHR_CREATED_DATE)));
            $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("B".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, trim($tr->CHR_ID_PART));
            $objPHPExcel->getActiveSheet()->getStyle("C".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, trim($tr->CHR_NAMA_PART));
            $objPHPExcel->getActiveSheet()->getStyle('D'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, trim($tr->CHR_NAMA_VENDOR));
            $objPHPExcel->getActiveSheet()->getStyle('E'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("E".$baris)->applyFromArray($StyleIsi);
            $baris = $baris +1;
        }
        $objPHPExcel->getActiveSheet()->getStyle("A1:E".$baris)->applyFromArray($AllStyle);
        $filename = "Report Checksheet". "-" . date("Y/m/d") . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function excel_checksheet($date, $partno, $pds_no)
    {
        $header = $this->report_checksheet_m->get_data($date,$partno, $pds_no);
        $detil = $this->report_checksheet_m->get_detil_checksheet($date,$partno);
        $checksheet_detil = $this->report_checksheet_m->get_checksheet_detail($date,$partno);
        $loadtester = $this->report_checksheet_m->get_spec_load($partno);
        $sampel = $this->report_checksheet_m->get_jumlah_sampel($date,$partno);
    
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Detail Checksheet");
        $objPHPExcel->getProperties()->setSubject("Report Detail Checksheet");
        $objPHPExcel->getProperties()->setDescription("Report Detail Checksheet");

        // Set Properties
        $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('Data');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Sample');
        $kolomTitle =  array('B','C','D','E' );
        
        $barisload =3;
        for($i=0;$i<30;$i++)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$barisload, ($barisload-2));
            $barisload = $barisload +1;
        }
        $barisload =3;
        $indexColom=0;
        $no_data_sample = 30 - $sampel;
        $spesification = '';
        $y = 0;

        foreach ($checksheet_detil as $row) {
            
            $objPHPExcel->getActiveSheet()->setCellValue($kolomTitle[$indexColom].'2', 'Nilai'.$indexColom);
            $objPHPExcel->getActiveSheet()->setCellValue($kolomTitle[$indexColom].$barisload, $row->DEC_NILAI);
            $y++;
            $barisload++;

            if($y == $sampel){
                for($x=0; $x<$no_data_sample; $x++){
                    $objPHPExcel->getActiveSheet()->setCellValue($kolomTitle[$indexColom].$barisload, 0);
                    $barisload++;
                }
                $y = 0;
                $indexColom++;
                $barisload =3;
            }

        }

        //Setting Lebar Kolom
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(9);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(9);
        
        foreach(range('S','AA') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(8);
        }
        // foreach(range('S','AA') as $columnID) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(8);
        // }
        foreach(range('B','P') as $coloum) {
            $objPHPExcel->getActiveSheet()->getColumnDimension('A'.$coloum)->setWidth(8);

        }
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
        // Setting Tinggi Baris
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(61.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(16.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(27);
        $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(16.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(16.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(48);
        $objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('13')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('14')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('15')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('16')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('17')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('18')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('19')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('20')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('21')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('22')->setRowHeight(24);
        $objPHPExcel->getActiveSheet()->getRowDimension('23')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('24')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('25')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('26')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('27')->setRowHeight(18.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('28')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('29')->setRowHeight(18.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('30')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('31')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('32')->setRowHeight(18.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('33')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('34')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('35')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('36')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('37')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('38')->setRowHeight(18.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('39')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('40')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('41')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('42')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('43')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('44')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('45')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('46')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('47')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('48')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('49')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('50')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('51')->setRowHeight(18);
        $objPHPExcel->getActiveSheet()->getRowDimension('52')->setRowHeight(18.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('53')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('54')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('55')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('56')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('57')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('58')->setRowHeight(18.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('59')->setRowHeight(18.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('60')->setRowHeight(18.75);
        $objPHPExcel->getActiveSheet()->getRowDimension('61')->setRowHeight(19.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('62')->setRowHeight(16.50);
        $objPHPExcel->getActiveSheet()->getRowDimension('63')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('64')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('65')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('66')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('67')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getRowDimension('68')->setRowHeight(15);
        $objPHPExcel->getActiveSheet()->getRowDimension('69')->setRowHeight(15.75);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);

        // Border
        $BStyle = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle("K4:AJ5")->applyFromArray($BStyle);
        $objPHPExcel->getActiveSheet()->getStyle("K38:L42")->applyFromArray($BStyle);
        $objPHPExcel->getActiveSheet()->getStyle("AI63:AN68")->applyFromArray($BStyle);
        $OutsideStyle = array(
          'borders' => array(
            'outline' => array(
              'style' => PHPExcel_Style_Border::BORDER_THICK
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle("B4:AO69")->applyFromArray($OutsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("K4:AO5")->applyFromArray($OutsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("J7:AO61")->applyFromArray($OutsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("J7:J16")->applyFromArray($OutsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("J17:J61")->applyFromArray($OutsideStyle);

        $InsideStyle = array(
          'borders' => array(
            'inside' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $BottomStyle = array(
          'borders' => array(
            'bottom' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $BottomBoldStyle = array(
          'borders' => array(
            'bottom' => array(
              'style' => PHPExcel_Style_Border::BORDER_THICK
            )
          )
        );
        $objPHPExcel->getActiveSheet()->getStyle("K7:P16")->applyFromArray($OutsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("K7:P16")->applyFromArray($InsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("O7:AO22")->applyFromArray($InsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("K17:Q22")->applyFromArray($OutsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("K17:Q22")->applyFromArray($InsideStyle);
        $objPHPExcel->getActiveSheet()->getStyle("R22:AO22")->applyFromArray($BottomStyle);
        $objPHPExcel->getActiveSheet()->getStyle("N24:O61")->applyFromArray($BStyle);
        $objPHPExcel->getActiveSheet()->getStyle("N24:O61")->applyFromArray($BottomBoldStyle);


        $objPHPExcel->getActiveSheet()->mergeCells('AK4:AL5');
        $objPHPExcel->getActiveSheet()->mergeCells('J7:J16');
        $objPHPExcel->getActiveSheet()->mergeCells('J17:J61');
        $objPHPExcel->getActiveSheet()->mergeCells('AM4:AO5');
        $objPHPExcel->getActiveSheet()->mergeCells('O7:P8');
        for($i=7;$i<=22;$i++)
        {
            $objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':K'.($i+1).'');
            $objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':N'.($i+1).'');
            
            if($i>7)
            {
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$i.':R'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':S'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('T'.$i.':T'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('U'.$i.':U'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('V'.$i.':V'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('W'.$i.':W'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$i.':X'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('Y'.$i.':Y'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('Z'.$i.':Z'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AA'.$i.':AA'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AB'.$i.':AB'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AC'.$i.':AC'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AD'.$i.':AD'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AE'.$i.':AE'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AF'.$i.':AF'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AG'.$i.':AG'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AH'.$i.':AH'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AI'.$i.':AI'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AJ'.$i.':AJ'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AK'.$i.':AK'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AL'.$i.':AL'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AM'.$i.':AM'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AN'.$i.':AN'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AO'.$i.':AO'.($i+1).'');

                $objPHPExcel->getActiveSheet()->mergeCells('AP'.$i.':AP'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AQ'.$i.':AQ'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AR'.$i.':AR'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AS'.$i.':AS'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AT'.$i.':AT'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AU'.$i.':AU'.($i+1).'');
                $objPHPExcel->getActiveSheet()->mergeCells('AV'.$i.':AV'.($i+1).'');

            }
                

            $i=$i+1;
        }

        //$objPHPExcel->getActiveSheet()->mergeCells('P7:P8');
        $objPHPExcel->getActiveSheet()->mergeCells('Q7:Q8');

        $objPHPExcel->getActiveSheet()->mergeCells('K38:L38');        
        $objPHPExcel->getActiveSheet()->mergeCells('K39:L42');

        $objPHPExcel->getActiveSheet()->mergeCells('N24:N61');
        $objPHPExcel->getActiveSheet()->mergeCells('O24:O36');
        $objPHPExcel->getActiveSheet()->mergeCells('O37:O48');
        $objPHPExcel->getActiveSheet()->mergeCells('O49:O61');

        $objPHPExcel->getActiveSheet()->mergeCells('AI63:AN63');
        $objPHPExcel->getActiveSheet()->mergeCells('AI64:AJ64');
        $objPHPExcel->getActiveSheet()->mergeCells('AK64:AL64');
        $objPHPExcel->getActiveSheet()->mergeCells('AM64:AN64');
        $objPHPExcel->getActiveSheet()->mergeCells('AI65:AJ68');
        $objPHPExcel->getActiveSheet()->mergeCells('AK65:AL68');
        $objPHPExcel->getActiveSheet()->mergeCells('AM65:AN68');

        // Setting Header
        $style = array(
            'font' => array('bold' => true, 'size' => 48,'underline'=> true),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            ''
        );

        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'CHECKSHEET PEMERIKSAAN PART (VERIFIKASI)');
        $objPHPExcel->getActiveSheet()->getStyle("B2")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells('B2:AO2');

        $style = array(
            'font' => array('bold' => true, 'size' => 16),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
            ''
        );
        $objPHPExcel->getActiveSheet()->setCellValue('K4', 'SUPPLIER');
        $objPHPExcel->getActiveSheet()->getStyle("K4")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells('K4:P4');
        $objPHPExcel->getActiveSheet()->setCellValue('Q4', 'PART NUMBER');
        $objPHPExcel->getActiveSheet()->getStyle("Q4")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells('Q4:W4');
        $objPHPExcel->getActiveSheet()->setCellValue('X4', 'PART NAME');
        $objPHPExcel->getActiveSheet()->getStyle("X4")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells('X4:AE4');
        $objPHPExcel->getActiveSheet()->setCellValue('AF4', 'PDS NO.');
        $objPHPExcel->getActiveSheet()->getStyle("AF4")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells('AF4:AJ4');
        $objPHPExcel->getActiveSheet()->setCellValue('AI63', 'PT. AISIN INDONESIA');
        $objPHPExcel->getActiveSheet()->getStyle("AI63")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle("AI63")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('abacad');

        
        $style = array(
            'font' => array('bold' => false, 'size' => 12),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
            ''
        );
        $objPHPExcel->getActiveSheet()->setCellValue('AK4', 'BACK NO :');
        $objPHPExcel->getActiveSheet()->getStyle("AK4")->applyFromArray($style);

        $style = array(
            'font' => array('bold' => true, 'size' => 20),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
            ''
        );
        $objPHPExcel->getActiveSheet()->setCellValue('J7', 'VISUAL CHECK');
        $objPHPExcel->getActiveSheet()->getStyle("J7")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('J7')->getAlignment()->setTextRotation(90);
        $objPHPExcel->getActiveSheet()->setCellValue('J17', 'PERFORMANCE TEST');
        $objPHPExcel->getActiveSheet()->getStyle("J17")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('J17')->getAlignment()->setTextRotation(90);

        $style = array(
            'font' => array('bold' => false, 'size' => 12),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
            ''
        );
        $objPHPExcel->getActiveSheet()->setCellValue('K7', 'NO');
        $objPHPExcel->getActiveSheet()->getStyle("K7")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('L7', 'Point Check');
        $objPHPExcel->getActiveSheet()->getStyle("L7")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('O7', 'Standard');
        $objPHPExcel->getActiveSheet()->getStyle("O7")->applyFromArray($style);
        
        $style = array(
            'font' => array('bold' => true, 'size' => 18),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
            ''
        );
    
        $objPHPExcel->getActiveSheet()->setCellValue('K39', $sampel.' pc');
        $objPHPExcel->getActiveSheet()->getStyle("K39")->applyFromArray($style);

        $style = array(
            'font' => array('bold' => false, 'size' => 12),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
            ''
        );
        $objPHPExcel->getActiveSheet()->setCellValue('R8', 'DATE/ MONTH');
        $objPHPExcel->getActiveSheet()->getStyle("R8")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle("R8")->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->getStyle("R7:AO7")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#000');
        $objPHPExcel->getActiveSheet()->getStyle("R9:R22")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#000');

        $style = array(
            'font' => array('bold' => true, 'size' => 32),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
            ''
        );
        $objPHPExcel->getActiveSheet()->setCellValue('N24', 'CHART');
        $objPHPExcel->getActiveSheet()->getStyle("N24")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle('N24')->getAlignment()->setTextRotation(90);

        // isi
        $style = array(
                'font' => array('bold' => false, 'size' => 16),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
                ''
            );
        $no =1;
        $baris =9;
        foreach ($detil as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $no);
            $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $row->CHR_SPECIFICATION);
            $objPHPExcel->getActiveSheet()->getStyle("L".$baris)->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, number_format($row->DEC_STD, 2).' '.$row->CHR_UNIT);

            $objPHPExcel->getActiveSheet()->getStyle("O".$baris)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells('O'.$baris.':O'.($baris+1));
            $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->setCellValue('P'.$baris, ' + '.number_format($row->DEC_TOLERANSI_MAX, 2));
            $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->setCellValue('P'.($baris+1), ' - '.number_format($row->DEC_TOLERANSI_MIN, 2));
            $objPHPExcel->getActiveSheet()->getStyle("P".($baris+1))->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, $row->DEC_STD_MAX);
            $objPHPExcel->getActiveSheet()->getStyle("Q".$baris)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.($baris+1), $row->DEC_STD_MIN);
            $objPHPExcel->getActiveSheet()->getStyle("Q".($baris+1))->applyFromArray($style);

            $nilai = $this->report_checksheet_m->get_nilai_spek($row->INT_SPECIFICATION_ID,$date,$partno);
            $index_nilai=0;
            // $alphas = range('S', 'Z');
            $alphas = array( 
                0 => 'S',
                1 => 'T',
                2 => 'U',
                3 => 'V',
                4 => 'W',
                5 => 'X',
                6 => 'Y',
                7 => 'Z',
                8 => 'AA',
                9 => 'AB',
                10 => 'AC',
                11 => 'AD',
                12 => 'AE',
                13 => 'AF',
                14 => 'AG',
                15 => 'AH',
                16 => 'AI',
                17 => 'AJ',
                18 => 'AK',
                19 => 'AL',
                20 => 'AM',
                21 => 'AN',
                22 => 'AO',
                23 => 'AP',
                24 => 'AQ',
                25 => 'AR',
                26 => 'AS',
                27 => 'AT',
                28 => 'AU',
                29 => 'AV'
            );

            foreach ($nilai as $spek_nilai) {

                # code...
                $tanggal = array(
                    'font' => array('bold' => false, 'size' => 12),
                    'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
                    ''
                );
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$index_nilai].'8',date("d F Y", strtotime($date)));
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$index_nilai].'8')->applyFromArray($tanggal);

                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$index_nilai].$baris, $spek_nilai->DEC_NILAI);
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$index_nilai].$baris)->applyFromArray($style);
                $index_nilai=$index_nilai+1;

            }
            
            $baris=$baris+2;
            $no =$no+1;
        }

        $styleChart = array(
            'font' => array('bold' => true, 'size' => 24),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
            ''
        );
        $a =1;
        $baris = 24;
        $barisspek =17;
        //Data Series Label
        $dsl=array(
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'".'!B2', NULL, 1)
        );
        // Data Nilai X
        $xal=array(
            new PHPExcel_Chart_DataSeriesValues('String', "'Data'"."!A3:A32", NULL, 30),
        );
        $barisAkhir=0;
        foreach ($loadtester as $row) {
            if($a==2)
            {
                $baris=$baris+13;
            }
            else if($a==3)
            {
                $baris=$baris+12;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, $row->CHR_SPECIFICATION);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->applyFromArray($styleChart);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setTextRotation(90);

            $objPHPExcel->getActiveSheet()->setCellValue('K'.$barisspek, $no);
            $objPHPExcel->getActiveSheet()->getStyle("K".$barisspek)->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->setCellValue('L'.$barisspek, $row->CHR_SPECIFICATION);
            $objPHPExcel->getActiveSheet()->getStyle("L".$barisspek)->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->setCellValue('O'.$barisspek, number_format($row->DEC_STD, 2).' '.$row->CHR_UNIT);
            $objPHPExcel->getActiveSheet()->getStyle("O".$barisspek)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells('O'.$barisspek.':O'.($barisspek+1));
            $objPHPExcel->getActiveSheet()->getStyle('O'.$barisspek)->getAlignment()->setWrapText(true);

            // Nilai yang akan dipakai ke array
            $dsv=array(
                new PHPExcel_Chart_DataSeriesValues('Number', "'Data'"."!".$kolomTitle[($a-1)]."3:".$kolomTitle[($a-1)]."32", NULL, 30)
            );
            // new PHPExcel_Chart_DataSeriesValues('Number', 'C2:C32', NULL, 30),
            // new PHPExcel_Chart_DataSeriesValues('Number', 'D2:D32', NULL, 30),
            // Data Series Value
            $ds=new PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_LINECHART,PHPExcel_Chart_DataSeries::GROUPING_STANDARD,range(0, 0),null,$xal,$dsv
            );
            // Plot Area and Legend
            $pa=new PHPExcel_Chart_PlotArea(NULL, array($ds));
            // Set Chart
            $chart= new PHPExcel_Chart('chart1',null,null,$pa,true,0,NULL,NULL);

            $chart->setTopLeftPosition('P'.$baris);
            if($a==1||$a==3)
            {
                $barisAkhir=$baris+13;
            }
            else if($a==2)
            {
                $barisAkhir=$baris+12;
            }
            $chart->setBottomRightPosition('AO'.$barisAkhir);
            $objPHPExcel->getActiveSheet()->addChart($chart);

            $barisspek=$barisspek+2;
            $no =$no+1;
            $a++;
            
        }
        
        $objPHPExcel->getActiveSheet()->mergeCells('S8:'.$alphas[$index_nilai-1].'8');

        $style = array(
                'font' => array('bold' => true, 'size' => 18),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
                ''
            );

         foreach ($header as $rowdata) {

            $objPHPExcel->getActiveSheet()->mergeCells('K5:P5');
            $objPHPExcel->getActiveSheet()->setCellValue('K5', trim($rowdata->CHR_NAMA_VENDOR));
            $objPHPExcel->getActiveSheet()->getStyle("K5")->applyFromArray($style);

            $objPHPExcel->getActiveSheet()->setCellValue('Q5', trim($rowdata->CHR_ID_PART_HYP));
            $objPHPExcel->getActiveSheet()->getStyle("Q5")->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells('Q5:W5');

            $objPHPExcel->getActiveSheet()->setCellValue('X5', trim($rowdata->CHR_NAMA_PART));
            $objPHPExcel->getActiveSheet()->getStyle("X5")->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells('X5:AE5');

            $pds_string = $pds_no.':'.$rowdata->CHR_STATUS;

            $objPHPExcel->getActiveSheet()->setCellValue('AF5', $pds_string);
            $objPHPExcel->getActiveSheet()->getStyle("AF5")->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells('AF5:AJ5');

            $style = array(
                'font' => array('bold' => true, 'size' => 36),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
                ''
            );
            $objPHPExcel->getActiveSheet()->setCellValue('AM4',$rowdata->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->getStyle("AM4")->applyFromArray($style);
         }

        $style = array(
            'font' => array('bold' => false, 'size' => 14),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER),
            ''
        );
        $objPHPExcel->getActiveSheet()->setCellValue('K38', 'SAMPLE');
        $objPHPExcel->getActiveSheet()->getStyle("K38")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('AI64', 'Approved');
        $objPHPExcel->getActiveSheet()->getStyle("AI64")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('AK64', 'Checked');
        $objPHPExcel->getActiveSheet()->getStyle("AK64")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('AM64', 'Prepared');
        $objPHPExcel->getActiveSheet()->getStyle("AM64")->applyFromArray($style);

        $filename = "Report Checksheet". "-" . date("Y/m/d").$partno . ".xlsx";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
    
}
?>