<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
//Add By xcx 20190507
class inhouse_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = '/calysta/inhouse_c/index/';
    // private $back_to_index = '/patricia/alat_ukur_c';

    public function __construct() {
        parent::__construct();
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('calysta/inhouse_m');
        $this->load->model('calysta/progress_m');
        $this->load->library('fpdf/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
         
    }
    function index($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(306);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Data Inhouse';
        $data['data'] = $this->inhouse_m->get_device();
        
        $project = $this->input->post("CHR_KATEGORI");
        $data['dropdown'] = $this->inhouse_m->getDropdown($project);
        $data['project_name'] = $this->inhouse_m->getProject();
        

        
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
        $data['content'] = 'calysta/inhouse_v';
        $this->load->view($this->layout, $data);
    }
    
    function create_part_inhouse($msg = NULL) {
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(306);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Create Data Inhouse';
        $data['data'] = $this->inhouse_m->get_device();

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
        $data['content'] = 'calysta/create_data_inhouse_v';
        $this->load->view($this->layout, $data);
    }

    function delete($id)
    {

        $date = date('Ymd');
         $this->db->query("UPDATE TM_SEQUENCE_01 set INT_SERIAL_NUMBER  = INT_SERIAL_NUMBER - 1 WHERE CHR_KEY1='IH' AND CHR_DATE_CREATED = '$date' ");
        $data = array(
                'INT_FLG_DEL' => 1);
        $msg = 3;
            $this->inhouse_m->update($data, $id);
            redirect('calysta/inhouse_c');
    }

    function save_device()
    {
        // $CHR_PROG_RM = substr($this->input->post('CHR_PROG_RM'),0,4) . substr($this->input->post('CHR_PROG_RM'),5,2) . substr($this->input->post('CHR_PROG_RM'),8,2);
        // print_r($CHR_PROG_RM);
        // exit();
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
        $x1 = $_POST['CHR_DIM1'];
        $x2 = $_POST['CHR_DIM2'];
        $a = $p.' '.$x1.' '.$l.' '.$x1.' '.$t;
        $b = $d.' '.$x2.' '.$td;
        $dim = trim($a.$b);
        
    

        $tm_sequence = $this->db->query("SELECT * 
                                        FROM TM_SEQUENCE_01 
                                        WHERE CHR_DATE_CREATED = '$date' AND 
                                            CHR_PROCESS_TYPE = 'tm_number'");
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
            $this->db->query("INSERT INTO TM_SEQUENCE_01 (CHR_COD_EXE, CHR_KEY1, CHR_DATE_CREATED,CHR_PROCESS_TYPE, INT_SERIAL_NUMBER) VALUES ('TM_NUMBER','IH','$date', 'tm_number', 1);");
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
        $tm_no = "IH" . date('ymd') .$this->input->post('CHR_TM_NUMBER'). $x . $tm;
        
        // ----------------------------------------------------------------------
       
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');

        

        $fileName = $_FILES['CHR_IMG_DWG']['name'];

       

        $config = array(
            'upload_path' => 'assets/img/calysta/ih/',
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
        $CHR_PROG_MC1 = substr($this->input->post('CHR_PROG_MC1'),0,4) . substr($this->input->post('CHR_PROG_MC1'),5,2) . substr($this->input->post('CHR_PROG_MC1'),8,2);
        $CHR_PROG_HT = substr($this->input->post('CHR_PROG_HT'),0,4) . substr($this->input->post('CHR_PROG_HT'),5,2) . substr($this->input->post('CHR_PROG_HT'),8,2);
        $CHR_PROG_SG = substr($this->input->post('CHR_PROG_SG'),0,4) . substr($this->input->post('CHR_PROG_SG'),5,2) . substr($this->input->post('CHR_PROG_SG'),8,2);
        $CHR_PROG_WC = substr($this->input->post('CHR_PROG_WC'),0,4) . substr($this->input->post('CHR_PROG_WC'),5,2) . substr($this->input->post('CHR_PROG_WC'),8,2);
        $CHR_PROG_QC = substr($this->input->post('CHR_PROG_QC'),0,4) . substr($this->input->post('CHR_PROG_QC'),5,2) . substr($this->input->post('CHR_PROG_QC'),8,2);
        $CHR_PROG_MC2 = substr($this->input->post('CHR_PROG_MC2'),0,4) . substr($this->input->post('CHR_PROG_MC2'),5,2) . substr($this->input->post('CHR_PROG_MC2'),8,2);
        $CHR_PROG_FIN = substr($this->input->post('CHR_PROG_FIN'),0,4) . substr($this->input->post('CHR_PROG_FIN'),5,2) . substr($this->input->post('CHR_PROG_FIN'),8,2);
        
        $data = array(
            'CHR_PROJECT_NAME' => $this->input->post('CHR_PROJECT_NAME'),
            'CHR_ITEM' => $this->input->post('CHR_ITEM'),
            'CHR_PART_NAME' => $this->input->post('CHR_PART_NAME'),
            'CHR_TM_NUMBER' => $tm_no,
            'CHR_MODEL' => $this->input->post('CHR_MODEL'),
            'CHR_MAT' => $this->input->post('CHR_MAT'),
            'CHR_SUPPLIER' => 'INHOUSE',
            'INT_QTY' => $this->input->post('INT_QTY'),
            'CHR_DIMENSI' => $dim,
            'CHR_CREATED_DATE' => $tgl,
            'CHR_CREATED_TIME' => $time,
            'CHR_PROG_RM' => $CHR_PROG_RM,
            'CHR_PROG_MC1' => $CHR_PROG_MC1,
            'CHR_PROG_HT' => $CHR_PROG_HT,
            'CHR_PROG_SG' => $CHR_PROG_SG,
            'CHR_PROG_WC' => $CHR_PROG_WC,
            'CHR_PROG_QC' => $CHR_PROG_QC,
            'CHR_PROG_MC2' => $CHR_PROG_MC2,
            'CHR_PROG_FIN' => $CHR_PROG_FIN,
            'INT_WEIGHT' => $this->input->post('CHR_WEIGHT'),
            'CHR_IMG_DWG' => $inputFileName,
            'INT_FLG_DEL' => 0);  
                        
     $data_tt = array(
        'CHR_TM_NUMBER' => $tm_no,
         'CHR_PROJECT' => $this->input->post('CHR_TM_NUMBER'),
         'CHR_PROJECT_NAME' => $this->input->post('CHR_PROJECT_NAME'),
          'INT_FLG_DEL' => 0);

        $data_tw = array(
        'CHR_TM_NUMBER' => $tm_no,
        'CHR_START_MC1' => '',
        'CHR_START_SG' => '',
        'CHR_START_WC' => '',
        'CHR_START_MC2' => '',
        'CHR_STATUS_MC1' => '',
        'CHR_STATUS_SG' => '',
        'CHR_STATUS_WC' => '',
        'CHR_STATUS_MC2' => '',
        'CHR_TOTAL' => '',
        'INT_FLG_DEL' => 0
        );
        
            $this->load->library('ciqrcode');
            $params['data'] = "$tm_no";
            $params['level'] = 'B';
            $params['size'] = 2;
            $params['savename'] = 'assets/img/calysta/qrcode_ih/' . $tm_no . '.png';    
            $this->ciqrcode->generate($params);
    
        $this->inhouse_m->save_device($data);
        $this->inhouse_m->save($data_tt);
        $this->inhouse_m->save_data($data_tw);
        redirect('calysta/inhouse_c');
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
                'CHR_PROJECT_NAME' => $this->input->post('CHR_PROJECT_NAME'),
                'CHR_ITEM' => $this->input->post('CHR_ITEM'),
                'CHR_PART_NAME' => $this->input->post('CHR_PART_NAME'),
                'CHR_MODEL' => $this->input->post('CHR_MODEL'),
                'CHR_MAT' => $this->input->post('CHR_MAT'),
                'INT_QTY' => $this->input->post('INT_QTY'),
                'CHR_DIMENSI' => $this->input->post('CHR_DIMENSI'),
                'INT_WEIGHT' => $this->input->post('INT_WEIGHT'),
                'INT_FLG_DEL' => 0);
            $this->inhouse_m->update($data,$id);
            redirect('calysta/inhouse_c');
    }
     function excel_check_list()
    {
         $this->load->library('excel');
       
        $data1 = $this->input->post('CHR_KATEGORI');
        $data2 = $this->input->post('CHR_PROJECT');
       
        $data = $this->inhouse_m->get_checksheet_by_data($data1,$data2);
        
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Part Inhouse");
        $objPHPExcel->getProperties()->setSubject("Report Part Inhouse");
        $objPHPExcel->getProperties()->setDescription("Report Part Inhouse");


        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
       
         
       
        

        $StyleJudul = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
         $Style1 = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 16,
                'color' => array('rgb' => 'FFFFFF'),
                'name'  => 'Times New Roman'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
             'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'DC143C')
                 )
        );
        $StyleIsi = array(
            'font'  => array(
                'bold'  => false,
                'size'  => 10,
                'name'  => 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );
         $StyleIsi1 = array(
            'font'  => array(
                'bold'  => false,
                'size'  => 10,
                'name'  => 'Courier New'),
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,)
        );
        $AllStyle = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        ); 
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'NEW PROJECT');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($Style1);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', strtoupper($data2));
        $objPHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($Style1);
         
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No');
        $objPHPExcel->getActiveSheet()->getStyle("A3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Item');
        $objPHPExcel->getActiveSheet()->getStyle("B3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'TM Number');
        $objPHPExcel->getActiveSheet()->getStyle("C3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Part Name');
        $objPHPExcel->getActiveSheet()->getStyle("D3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Model');
        $objPHPExcel->getActiveSheet()->getStyle("E3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Mat');
        $objPHPExcel->getActiveSheet()->getStyle("F3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Supplier');
        $objPHPExcel->getActiveSheet()->getStyle("G3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Qty');
        $objPHPExcel->getActiveSheet()->getStyle("H3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Dimensi');
        $objPHPExcel->getActiveSheet()->getStyle("I3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'Target');
        $objPHPExcel->getActiveSheet()->getStyle("J3")->applyFromArray($StyleJudul);
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'COST');
        $objPHPExcel->getActiveSheet()->getStyle("K3")->applyFromArray($StyleJudul);
      
        $baris = 4;
        foreach($data as $tr)
        {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $baris-3);
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
            $objPHPExcel->getActiveSheet()->getStyle("J".$baris)->applyFromArray($StyleIsi);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, trim($tr->COST));
        $objPHPExcel->getActiveSheet()->getStyle("K".$baris)->applyFromArray($StyleIsi1)->getNumberFormat()->setFormatCode('Rp'.' '.'#,##0');
            $baris++;
        }
        $objPHPExcel->getActiveSheet()->getStyle("A3:K".$baris)->applyFromArray($AllStyle);
        $filename = "Data Inhouse". "-" . date("Y/m/d") . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }  
    
    function pdf_part($id) {
            
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetMargins(4, 4, 4, 0);
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Courier', 'B', 11);
        
       $query = $this->db->query("SELECT CHR_TM_NUMBER, CHR_PART_NAME, SUBSTRING(CHR_PROG_FIN,7,2)+'/'+SUBSTRING(CHR_PROG_FIN,5,2)+'/'+
SUBSTRING(CHR_PROG_FIN,0,5) as CHR_PROG_FIN,CHR_MODEL, CHR_IMG_DWG, CHR_PROJECT_NAME FROM TM_PART_INHOUSE WHERE INT_NO_PART ='$id'")->result();
             
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
        $pdf->Cell(45, 4, substr($query[0]->CHR_MODEL,0,22), "B", 1, 'L');

        $pdf->SetX($x_kanban2 + 16);
        $pdf->SetFont('Courier', '', 8);
        $pdf->MultiCell(45, 5, $query[0]->CHR_PROG_FIN, 0, "L", 0);
        
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,-18, $query[0]->CHR_PROJECT_NAME .' : '. $query[0]->CHR_PART_NAME,0,0,'C');
        $pdf->line(290, 20, 12, 20);

        $pdf->SetY($y_kanban2 + 1);
        $pdf->SetX($x_kanban2);
        $pdf->SetFont('Courier', '', 7);
        $image1 = base_url("/assets/img/calysta/qrcode_ih"). "/" . $query[0]->CHR_TM_NUMBER. ".png";
        $pdf->Image($image1, $pdf->GetX() + 1, $pdf->GetY(), 14, 14);

        $pdf->SetFont('Courier', '', 9);
        $image2 = $query[0]->CHR_IMG_DWG;
        $pdf->Image($image2, $pdf->GetX(), $pdf->GetY() + 20, 290, 180);
     
        $pdf->Output();
    }
    
    function get_data_dropdown(){
        $project = $this->input->post("CHR_KATEGORI");

        $dropdown = $this->inhouse_m->getDropdown($project);
        $data = '';
        
          foreach($dropdown as $row) { 
         $data .="<option value='$row->CHR_PROJECT_NAME'>".$row->CHR_PROJECT_NAME."</option>";
            }
       
        $json_data = array('data' => $data);

        echo json_encode($json_data);
    }
}
?>