<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
//Add By xcx 20190507
class outhouse_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = '/calysta/outhouse_c/index/';
    // private $back_to_index = '/patricia/alat_ukur_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('calysta/outhouse_m');
        $this->load->model('calysta/progress_m');
        $this->load->library('fpdf/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
         
    }
    function index($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(307);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Data outhouse';
        $data['data'] = $this->outhouse_m->get_device();
       
        
        if ($msg == 1) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
            } elseif ($msg == 2) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
            } elseif ($msg == 3) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
            } elseif ($msg == 4) {
                $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
            } elseif ($msg == 12) {
                $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
            }
        $data['msg'] = $msg;
        $data['content'] = 'calysta/outhouse_v';
        $this->load->view($this->layout, $data);
    }
    
    function create_part_outhouse($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(307);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Create Data outhouse';
        $data['data'] = $this->outhouse_m->get_device();

        if ($msg == 1) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
            } elseif ($msg == 2) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
            } elseif ($msg == 3) {
                $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
            } elseif ($msg == 4) {
                $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
            } elseif ($msg == 12) {
                $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
            }
        $data['msg'] = $msg;
        $data['content'] = 'calysta/create_data_outhouse_v';
        $this->load->view($this->layout, $data);
    }

    function delete($id)
    {
         $this->db->query("UPDATE TM_SEQUENCE_01 set INT_SERIAL_NUMBER  = INT_SERIAL_NUMBER - 1 WHERE CHR_KEY1='OH' AND CHR_DATE_CREATED = '$date' ");
        $data = array(
                'INT_FLG_DEL' => 1);
        $msg = 3;
            $this->outhouse_m->update($data, $id);
            redirect('calysta/outhouse_c');
    }

    function save_device()
    {
        date_default_timezone_set('Asia/Jakarta');
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");

        $time1 = date("H:i:s");
        $time2 = date_create($time1);
        $time = date_format($time2,"His");
       
        $date = date('Ymd');
        $time = date('His');
        $stat_x = 0;

        $p = $this->input->post('CHR_DIMENSI_P');
        $l = $this->input->post('CHR_DIMENSI_L');
        $t = $this->input->post('CHR_DIMENSI_T');
        $d = $this->input->post('CHR_DIMENSI_D');
        $td = $this->input->post('CHR_DIMENSI_Td');
        $x1 = $this->input->post('CHR_DIM1');
        $x2 = $this->input->post('CHR_DIM2');
        $a = $p.' '.$x1.' '.$l.' '.$x1.' '.$t;
        $b = $d.' '.$x2.' '.$td;
        $dim = trim($a.$b);

        $tm_sequence = $this->db->query("SELECT * 
                                        FROM TM_SEQUENCE_01 
                                        WHERE CHR_DATE_CREATED = '$date' AND 
                                            CHR_PROCESS_TYPE = 'tm_number' ");
//--------------------------------------------------------------------//                    
        if ($tm_sequence->num_rows() > 0) {
            $tm = $tm_sequence->result();
            $tm = $tm[0]->INT_SERIAL_NUMBER;
            $tm = $tm + 1;

            $this->db->query("UPDATE TM_SEQUENCE_01 
                        set INT_SERIAL_NUMBER      = '$tm' 
                        WHERE CHR_DATE_CREATED     = '$date' AND 
                            CHR_PROCESS_TYPE = 'tm_number' ");
        } else {
            $this->db->query("INSERT INTO TM_SEQUENCE_01 (CHR_COD_EXE, CHR_KEY1, CHR_DATE_CREATED,CHR_PROCESS_TYPE, INT_SERIAL_NUMBER) VALUES ('TM_NUMBER','OH','$date', 'tm_number', 1);");
            $tm = 1;
        }
        $len_tm_num = strlen($tm);
        switch ($len_tm_num) {
            case 0:
                $x = "00";
                break;
            case 1:
                $x = "00";
                break;
            case 2:
                $x = "0";
                break;
            case 3:
                $x = "0";
                break;
            case 4:
                $x = "";
                break;
            default:
                break;
        }
        $tm_no = "OH" . date('ymd') .$this->input->post('CHR_TM_NUMBER'). $x . $tm;
        
        // ----------------------------------------------------------------------
       
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        // $cust_part_no = $this->input->post('CHR_CUS_PART_NO');
        // $upload_date = date('Ymd');
        // $upload_time = date('His');

        $fileName = $_FILES['CHR_IMG_DWG']['name'];

        // if (empty($fileName)) {
        //     redirect($this->back_to_upload.$msg = 14);
        // }

        $config = array(
            'upload_path' => 'assets/img/calysta/oh/',
            'allowed_types' => "gif|JPG|jpg|png|jpeg",
            'overwrite' => TRUE,
            'max_size' => "2000"//2048000,
            //'file_name' = $fileName;
            );

        //code for upload with ci
        $this->upload->initialize($config);
        if ($a = $this->upload->do_upload('CHR_IMG_DWG'))
        $this->upload->display_errors();
        $media = $this->upload->data('CHR_IMG_DWG');
        $inputFileName = $config['upload_path'] . $media['file_name'];
        
        $CHR_PROG_RM = substr($this->input->post('CHR_PROG_RM'),0,4) . substr($this->input->post('CHR_PROG_RM'),5,2) . substr($this->input->post('CHR_PROG_RM'),8,2);
        $CHR_PROG_DELIVERY = substr($this->input->post('CHR_PROG_DELIVERY'),0,4) . substr($this->input->post('CHR_PROG_DELIVERY'),5,2) . substr($this->input->post('CHR_PROG_DELIVERY'),8,2);
        $CHR_PROG_RECEIVING = substr($this->input->post('CHR_PROG_RECEIVING'),0,4) . substr($this->input->post('CHR_PROG_RECEIVING'),5,2) . substr($this->input->post('CHR_PROG_RECEIVING'),8,2);
        $CHR_PROG_FIN = substr($this->input->post('CHR_PROG_FIN'),0,4) . substr($this->input->post('CHR_PROG_FIN'),5,2) . substr($this->input->post('CHR_PROG_FIN'),8,2);
        
        $data = array(
            'CHR_ITEM' => $this->input->post('CHR_ITEM'),
            'CHR_PART_NAME' => $this->input->post('CHR_PART_NAME'),
            'CHR_TM_NUMBER' => $tm_no,
            'CHR_MODEL' => $this->input->post('CHR_MODEL'),
            'CHR_MAT' => $this->input->post('CHR_MAT'),
            'CHR_SUPPLIER' => $this->input->post('CHR_SUPPLIER'),
            'INT_QTY' => $this->input->post('INT_QTY'),
            'CHR_DIMENSI' => $dim, //$this->input->post('CHR_DIMENSI'),
            'CHR_CREATED_DATE' => $tgl,
            'CHR_CREATED_TIME' => $time,
            'CHR_PROG_RM' => $CHR_PROG_RM,
            'CHR_PROG_DELIVERY' => $CHR_PROG_DELIVERY,
            'CHR_PROG_RECEIVING' => $CHR_PROG_RECEIVING,
            'CHR_PROG_FIN' => $CHR_PROG_FIN,
            'CHR_IMG_DWG' => $inputFileName,
            'INT_FLG_DEL' => 0);  
                        
         $data_tt = array(
              'CHR_TM_NUMBER' => $tm_no,
              'CHR_PART_NAME' => $this->input->post('CHR_PART_NAME'),
              'INT_FLG_DEL' => 0);

            $this->load->library('ciqrcode');
            $params['data'] = "$tm_no";
            $params['level'] = 'B';
            $params['size'] = 2;
            $params['savename'] = 'assets/img/calysta/qrcode_oh/' . $tm_no . '.png';    
            $this->ciqrcode->generate($params);
    
        $this->outhouse_m->save_device($data);
        $this->outhouse_m->save($data_tt);
        redirect('calysta/outhouse_c');
    }
    function update()
    {   
        date_default_timezone_set('Asia/Jakarta');
        $today1 = date("Y-m-d");
        $today2 =date_create($today1);
        $tgl = date_format($today2,"Ymd");

        $time1 = date("H:i:s");
        $time2 = date_create($time1);
        $time = date_format($time2,"His");
        $id = $id = $this->input->post('INT_NO_PART');
       
        
        $data = array(
            'CHR_ITEM' => $this->input->post('CHR_ITEM'),
            'CHR_PART_NAME' => $this->input->post('CHR_PART_NAME'),
            'CHR_TM_NUMBER' => $tm_no,
            'CHR_MODEL' => $this->input->post('CHR_MODEL'),
            'CHR_MAT' => $this->input->post('CHR_MAT'),
            'CHR_SUPPLIER' => $this->input->post('CHR_SUPPLIER'),
            'INT_QTY' => $this->input->post('INT_QTY'),
            'CHR_DIMENSI' => $this->input->post('CHR_DIMENSI'),
            'CHR_CREATED_DATE' => $tgl,
            'CHR_CREATED_TIME' => $time,
            'CHR_PROG_RM' => $this->input->post('CHR_PROG_RM'),
            'CHR_PROG_DELIVERY' => $this->input->post('CHR_PROG_DELIVERY'),
            'CHR_PROG_RECEIVING' => $this->input->post('CHR_PROG_RECEIVING'),
            'CHR_PROG_FIN' => $this->input->post('CHR_PROG_FIN'),
            'CHR_IMG_DWG' => $inputFileName,
            'INT_FLG_DEL' => 0);
        $this->outhouse_m->update($data,$id);
        redirect('calysta/outhouse_c');
    }
     function excel_check_list()
    {
         $this->load->library('excel');
        $data['selected_date_awal'] = $this->input->post('tanggal_awal');
        $data['selected_date_akhir'] = $this->input->post('tanggal_akhir');
        $date1= date("Ymd", strtotime($this->input->post('tanggal_awal'))) ;
        $date2 = date("Ymd", strtotime($this->input->post('tanggal_akhir')));
        if($date1 == '19700101' && $date2 != '19700101')
        {
            $data = $this->outhouse_m->get_checksheet_by_date2($date2);
        }
        
        else if($date1 != '19700101' && $date2 == '19700101')
        {
            $data = $this->outhouse_m->get_checksheet_by_date1($date1);
        }
        else if($date1 == '19700101' && $date2 == '19700101')
        {
            $data = $this->outhouse_m->get_checksheet();
        }
        else
        {
            $data = $this->outhouse_m->get_checksheet_by_date($date1,$date2);    
        }
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Part outhouse");
        $objPHPExcel->getProperties()->setSubject("Report Part outhouse");
        $objPHPExcel->getProperties()->setDescription("Report Part outhouse");


        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
       
        

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
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
        $objPHPExcel->getActiveSheet()->getStyle("A4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Item');
        $objPHPExcel->getActiveSheet()->getStyle("B4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'TM Number');
        $objPHPExcel->getActiveSheet()->getStyle("C4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Part Name');
        $objPHPExcel->getActiveSheet()->getStyle("D4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Model');
        $objPHPExcel->getActiveSheet()->getStyle("E4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Mat');
        $objPHPExcel->getActiveSheet()->getStyle("F4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Supplier');
        $objPHPExcel->getActiveSheet()->getStyle("G4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'Qty');
        $objPHPExcel->getActiveSheet()->getStyle("H4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('I4', 'Dimensi');
        $objPHPExcel->getActiveSheet()->getStyle("I4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('J4', 'Target');
        $objPHPExcel->getActiveSheet()->getStyle("J4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('K4', 'RM');
        $objPHPExcel->getActiveSheet()->getStyle("K4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('L4', 'MC1');
        $objPHPExcel->getActiveSheet()->getStyle("L4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('M4', 'HT');
        $objPHPExcel->getActiveSheet()->getStyle("M4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('N4', 'SG');
        $objPHPExcel->getActiveSheet()->getStyle("N4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('O4', 'WC');
        $objPHPExcel->getActiveSheet()->getStyle("O4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('P4', 'MC2');
        $objPHPExcel->getActiveSheet()->getStyle("P4")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('Q4', 'QC');
        $objPHPExcel->getActiveSheet()->getStyle("Q4")->applyFromArray($StyleJudul);
       
        $baris = 5;
        foreach($data as $tr)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $baris-4);
            $objPHPExcel->getActiveSheet()->getStyle("A".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, trim($tr->CHR_ITEM));
            $objPHPExcel->getActiveSheet()->getStyle("B".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, trim($tr->CHR_TM_NUMBER));
            $objPHPExcel->getActiveSheet()->getStyle("C".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, trim($tr->CHR_PART_NAME));
            $objPHPExcel->getActiveSheet()->getStyle("D".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, trim($tr->CHR_MODEL));
            $objPHPExcel->getActiveSheet()->getStyle("E".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, trim($tr->CHR_MAT));
            $objPHPExcel->getActiveSheet()->getStyle("F".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, trim($tr->CHR_SUPPLIER));
            $objPHPExcel->getActiveSheet()->getStyle("G".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, trim($tr->INT_QTY));
            $objPHPExcel->getActiveSheet()->getStyle("H".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, trim($tr->CHR_DIMENSI));
            $objPHPExcel->getActiveSheet()->getStyle("I".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, date($tr->CHR_PROG_FIN));
            $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("J".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, date($tr->CHR_PROG_RM));
            $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, date($tr->CHR_PROG_MC1));
            $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("L".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, date($tr->CHR_PROG_HT));
            $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("M".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$baris, date ($tr->CHR_PROG_SG));
            $objPHPExcel->getActiveSheet()->getStyle('N'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("N".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$baris, date($tr->CHR_PROG_WC));
            $objPHPExcel->getActiveSheet()->getStyle('O'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("O".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$baris, date($tr->CHR_PROG_MC2));
            $objPHPExcel->getActiveSheet()->getStyle('P'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("P".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$baris, date($tr->CHR_PROG_QC));
            $objPHPExcel->getActiveSheet()->getStyle('Q'.$baris)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle("Q".$baris)->applyFromArray($StyleIsi);
            $baris = $baris + 1;
        }
        $objPHPExcel->getActiveSheet()->getStyle("A4:Q".$baris)->applyFromArray($AllStyle);
        $filename = "Data outhouse". "-" . date("Y/m/d") . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }  
    
    function pdf_part($id) {
            
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetMargins(4, 4, 4, 0);
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Courier', '', 11);
        
       $query = $this->db->query("SELECT CHR_TM_NUMBER, CHR_PART_NAME, CHR_PROG_FIN, 
       CHR_MODEL, CHR_IMG_DWG FROM TM_PART_outhouse WHERE INT_NO_PART ='$id'")->result();

        //cell kotakan luar
        $x_kanban1 = $pdf->GetX();
        $y_kanban1 = $pdf->GetY();
        
        $pdf->Cell(16, 0, "", "", 0, 'L');
        $pdf->Cell(45, 16, "", 1, 1, 'L'); // ukuran kotak luar
        
        $pdf->SetY($y_kanban1); // jarak kotak luar dan dalam
        $pdf->SetX($x_kanban1);

        //column 1
        //cell kotakan dalam
        $x_kanban2 = $pdf->GetX();
        $y_kanban2 = $pdf->GetY();

        $pdf->Cell(16, 16, "", 1, 1, 'L'); //ukuran kotak dalam
        $pdf->SetY($y_kanban2);
        $pdf->SetX($x_kanban2);

        $pdf->SetX($x_kanban2 + 16);
        $pdf->SetFont('Courier', 'B', 10);
        $pdf->Cell(45, 5, $query[0]->CHR_TM_NUMBER, "B", 1, 'L');
        
        $pdf->SetX($x_kanban2 + 16);
        $pdf->SetFont('Courier', '', 9);
        $pdf->Cell(45, 5, $query[0]->CHR_MODEL, "B", 1, 'L');

        $pdf->SetX($x_kanban2 + 16);
        $pdf->SetFont('Courier', 'I', 8);
        $pdf->MultiCell(45, 5, $query[0]->CHR_PROG_FIN, 0, "L", 0);

        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,-18, $query[0]->CHR_PART_NAME,0,0,'C');
        $pdf->line(290, 20, 12, 20);

        $pdf->SetY($y_kanban2 + 1);
        $pdf->SetX($x_kanban2);
        $pdf->SetFont('Courier', '', 7);
        $image1 = base_url("/assets/img/calysta/qrcode_oh" ) ."/". $query[0]->CHR_TM_NUMBER . ".png";
        $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 14, 14);

        $pdf->SetFont('Courier', '', 9);
        $image2 = $query[0]->CHR_IMG_DWG;
        $pdf->Image($image2, $pdf->GetX(), $pdf->GetY() + 20, 290, 180);

        $pdf->Output();
    }
    
}
?>