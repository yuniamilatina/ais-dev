<?php

class change_status_elina_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'prd/change_status_elina_c/index/';
    //private $back_to_approve = 'helpdesk_ticket/helpdesk_ticket_c/prepare_approve_ticket/';
    public $id_function = '171';

    public function __construct() {
        parent::__construct();
        $this->load->model('prd/change_status_elina_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');
        $this->load->model('basis/user_m');
        $this->load->model('portal/notification_m');
        //$this->load->model('helpdesk_ticket/problem_type_m');
        //$this->load->model('helpdesk_ticket/prover_m');
        $this->load->model('portal/news_m');
        $this->load->model('mrp/manage_mrp_m');
        
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization(171);
        
        $session = $this->session->all_userdata();
        $this->notification_m->has_be_read_by_npk_and_function($session['NPK'],$this->id_function );

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        }
//        $finishdate = date("Ymd");
//        $startdate = date('Ymd', strtotime($finishdate . ' -1 day'));
        
        $data['msg'] = $msg;
        $data['data'] = $this->change_status_elina_m->get_stat_order();
        $data['content'] = 'prd/change_stat/manage_stat_elina_v';
        $data['title'] = 'Explode ELINA by Digital Chute';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(171);
        $data['news'] = $this->news_m->get_news();
        
        $this->load->view($this->layout, $data);
    }
    
    function edit_data($prdno,$partno) {
        $data['content'] = 'prd/change_stat/edit_stat_elina_v';
        $data['title'] = 'Edit Explode Material';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(171);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->change_status_elina_m->get_data_by_id($prdno,$partno);

        $this->load->view($this->layout, $data);
    }
    
    function update_data_stat() {
        $this->form_validation->set_rules('CHR_STOCK', 'Aktual Stock', 'required|integer|char|max_length[5]|min_length[1]');
        $datenow = date('Ymd');
        $pno = $this->input->post('CHR_PNO');
        $pno = trim($pno);
//        $bno = $this->input->post('CHR_BNO');
        $prod = $this->input->post('chr_prodno');
        $wkctr = substr($prod,0,6);
        $sloc = $this->input->post('chr_sloc');
        $stock = $this->input->post('CHR_STOCK');
                
        if ($this->form_validation->run() == FALSE) {
            $this->edit_data($prod,$pno);
        } else {
            $data_array = array(
                'INT_PART_QTY' => $stock
            );

            $this->change_status_elina_m->update($data_array, $prod,$pno,$sloc,$wkctr);

            // $this->db->query("UPDATE PRD.TT_ELINA_H SET CHR_FLAG='0' WHERE CHR_FLAG='9' AND CHR_DATE_ORDER='$datenow'");            
            redirect($this->back_to_manage . $msg = 2);
        }
    }

    function export_explode_setup_chute() {        
        $this->load->library('excel');
        
        $list_data = $this->change_status_elina_m->get_result_explode_setup_chute();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set Properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("EXPLODE SETUP CHUTE");
        $objPHPExcel->getProperties()->setSubject("EXPLODE SETUP CHUTE");
        $objPHPExcel->getProperties()->setDescription("EXPLODE SETUP CHUTE");
                
        //Header TR
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'NO');
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'WORK CENTER');
        $objPHPExcel->getActiveSheet()->getStyle("B2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'PROD ORDER NO');
        $objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'SEQUENCE');
        $objPHPExcel->getActiveSheet()->getStyle("D2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'PART NO FG');
        $objPHPExcel->getActiveSheet()->getStyle("E2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'BACK NO FG');
        $objPHPExcel->getActiveSheet()->getStyle("F2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'PART NO COMP');
        $objPHPExcel->getActiveSheet()->getStyle("G2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'BACK NO COMP)');
        $objPHPExcel->getActiveSheet()->getStyle("H2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'QTY ORDER (BOX)');
        $objPHPExcel->getActiveSheet()->getStyle("I2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'QTY ORDER (PCS)');
        $objPHPExcel->getActiveSheet()->getStyle("J2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'AREA');
        $objPHPExcel->getActiveSheet()->getStyle("K2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                

        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true)->setSize(12);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        
        //Value of All Cells
        $i = 3;
        $no = 1;
        foreach($list_data as $data){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $data->CHR_WORK_CT);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data->CHR_PRD_ORDER_NO);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data->CHR_SEQ);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data->PN_FG);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $data->BN_FG);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $data->PN_COMP);                
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $data->BN_COMP);        
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $data->INT_ORDER_BOX);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $data->INT_ORDER_PCS);      
            $area = '';
            if($data->CHR_PREPARE_AREA == 'A'){
                $area = 'CKD';
            } else if($data->CHR_PREPARE_AREA == 'B'){
                $area = 'OH';
            } else {
                $area = 'IH';
            }
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $area);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("G".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            
            $i++;
            $no++;
        }
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $styleArray2 = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '99CCFF')
            )
        );
        
        $filename = "Result Explode Setup Chute ". date('Ymd') ." " . date('H:i:s') . ".xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    function optimize_capacity($msg = NULL, $month = NULL, $group_prd = NULL) {
        $this->role_module_m->authorization(171);
        
        if($msg == 0){
            $msg = NULL;
        }

        $session = $this->session->all_userdata();
        $this->notification_m->has_be_read_by_npk_and_function($session['NPK'],$this->id_function );
               
        $data['msg'] = $msg;
        if ($group_prd == NULL || $group_prd == '') {
            $group_prd = $this->manage_mrp_m->get_top_group_prd()->row()->CHR_GROUP_PRODUCT_CODE;
        }

        if ($month == NULL || $month == '') {
            $month = date('Ym') + 1;
        }

        // print_r($month);
        // exit();

        $all_group_prd = $this->manage_mrp_m->get_all_group_prd();

        // $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_group_prd($group_prd);
        $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_group_prd_v2($group_prd);
        $all_work_centers_mfg = $this->manage_mrp_m->get_all_work_center_mfg_by_group_prd_v2($group_prd);

        // $all_order = $this->manage_mrp_m->get_all_order_type($group_prd, $month);
        // $all_order = $this->manage_mrp_m->get_all_order_type();
        $all_order = $this->manage_mrp_m->get_all_order_type_v2($group_prd);
        
        // $all_capacity = $this->manage_mrp_m->get_all_capacity($group_prd);
        
        $data['all_group_prd'] = $all_group_prd->result();
        $data['all_work_centers'] = $all_work_centers->result();
        $data['all_work_centers_mfg'] = $all_work_centers_mfg->result();
        $data['all_order'] = $all_order;
        // $data['all_capacity'] = $all_capacity;
        $data['group_prd'] = $group_prd;
        $data['month'] = $month;

        $data['content'] = 'mrp/explode_material/optimize_capacity_v';
        $data['title'] = 'Optimize Capacity';
        
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(351);
        $data['news'] = $this->news_m->get_news();
        
        $this->load->view($this->layout, $data);
    }

    function filter_optimize_capacity() {
        $this->role_module_m->authorization(171);        
        $session = $this->session->all_userdata();
        $mrp_d = $this->load->database("mrp_d", TRUE);

        $group_prd = $this->input->post('group_prd');
        $month = $this->input->post('period');

        $all_group_prd = $this->manage_mrp_m->get_all_group_prd();

        $all_work_centers = $this->manage_mrp_m->get_all_work_center_by_group_prd_v2($group_prd);
        foreach($all_work_centers->result() as $wc){
            $wc_fg = trim($wc->CHR_WORK_CENTER);
            $wc_fg_prior = $this->input->post('line_' . $wc_fg);
            $wc_fg_cap = $this->input->post('cap_' . $wc_fg);

            $mrp_d->query("UPDATE TW_OPTIMIZE_CAPACITY SET INT_CAPACITY = '$wc_fg_cap', INT_PRIORITY = '$wc_fg_prior' WHERE CHR_CATEGORY = 'WORK_CENTER' AND CHR_ITEM = '$wc_fg'");
        }

        $all_work_centers_mfg = $this->manage_mrp_m->get_all_work_center_mfg_by_group_prd_v2($group_prd);
        foreach($all_work_centers_mfg->result() as $mfg){
            $wc_mfg = trim($mfg->CHR_WORK_CENTER);
            $wc_mfg_prior = $this->input->post('line_mfg_' . trim(str_replace(" ", "_", $wc_mfg)));
            $wc_mfg_cap = $this->input->post('cap_mfg_' . trim(str_replace(" ", "_", $wc_mfg)));
            // print_r($wc_mfg_prior);
            // exit();

            $mrp_d->query("UPDATE TW_OPTIMIZE_CAPACITY SET INT_CAPACITY = '$wc_mfg_cap', INT_PRIORITY = '$wc_mfg_prior' WHERE CHR_CATEGORY = 'WORK_CENTER_MFG' AND CHR_ITEM = '$wc_mfg'");
        }


        $all_order = $this->manage_mrp_m->get_all_order_type_v2($group_prd);
        foreach($all_order as $ord){
            $type = trim($ord->CHR_TYPE);
            $ord_prior = $this->input->post('type_' . $type);

            $mrp_d->query("UPDATE TW_OPTIMIZE_CAPACITY SET INT_PRIORITY = '$ord_prior' WHERE CHR_CATEGORY = 'ORDER' AND CHR_ITEM = '$type'");
        }

        redirect('prd/change_status_elina_c/optimize_capacity/0/' . $month . '/' . $group_prd);
    }

    function upload_list_part($id_dept = null, $msg= null) {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 13) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Lot Reason empty !</strong>Please, Fill the reason of additional quota</div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>File not Found !</strong>Choose your file to be upload</div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['month'] = date('Ym');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(351);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Upload List Part';
        $data['msg'] = $msg;

        $data['id_dept'] = $id_dept;
        $data['increment'] = 0;
        $data['data'] = array(); 

        $data['content'] = 'mrp/explode_material/upload_list_part_v';
        $this->load->view($this->layout, $data);
    }

    function download_template_list_optimize_parts() {
        $this->load->helper('download');

        ob_clean();

        $name = 'template_list_optimize_part.xlsx';
        $data = file_get_contents("assets/template/production/$name");

        force_download($name, $data);
    }

    function confirm_upload_list_optimize_parts(){
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('upload');
 
        $month = $this->input->post('PERIOD');
        $upload_date = date('Ymd');
        
        // print_r($month);
        // exit();
 
         $fileName = $_FILES['upload_list_optimize_parts']['name'];
         if (empty($fileName)) {
             redirect('prd/change_status_elina_c/upload_list_part/' . $msg = 14);
         }
 
         //file untuk submit file excel
         $config['upload_path'] = './assets/file/prd/';
         $config['file_name'] = $fileName;
         $config['allowed_types'] = 'xls|xlsx';
         $config['max_size'] = 10000;
 
         //code for upload with ci
         $this->upload->initialize($config);
         if ($a = $this->upload->do_upload('upload_list_optimize_parts'))
             $this->upload->display_errors();
         $media = $this->upload->data('upload_list_optimize_parts');
         $inputFileName = './assets/file/prd/' . $media['file_name'];
 
         //  Read  Excel workbook
         try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
         } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
         }

        //Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
 
        $rowHeader = $sheet->rangeToArray('A1:' . $highestColumn . '1', NULL, TRUE, FALSE);
 
        $no = $rowHeader[0][0];
        $part_no = $rowHeader[0][1];
        $wcenter = $rowHeader[0][2];
        $wcenter_mfg = $rowHeader[0][3];
        $type = $rowHeader[0][4];
        $qty = $rowHeader[0][5];
             
        $i = 0;
        if (trim($no) == 'No' && trim($part_no) == 'Part No' && trim($wcenter) == 'Work Center FG' && trim($wcenter_mfg) == 'Work Center MFG' && trim($type) == 'Order Type' && trim($qty) == 'Qty Order') {
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
 
                $data[$i]['FLG_DELETE'] = 0;
                $data[$i]['ERROR_MESSAGE'] = NULL;
                $data[$i]['WARNING_MESSAGE'] = NULL;
 
                // $flag_existing = $this->part_m->check_existing_part_no($rowData[0][1]);
                // if(!$flag_existing){
                //     $data[$i]['FLG_DELETE'] = 1;
                //     $data[$i]['ERROR_MESSAGE'] = 'Part No : '.$rowData[0][1]. ' tidak terdaftar';
                // }

                $exist_month = $this->change_status_elina_m->check_existing_period($month);
                if($exist_month > 0){
                    $data[$i]['WARNING_MESSAGE'] = 'Period : '.$month. ' sudah ada, save akan merevisi existing data';
                }
                
                $data[$i]['CHR_PART_NO'] = $rowData[0][1];
                $data[$i]['CHR_WORK_CENTER'] = $rowData[0][2];
                $data[$i]['CHR_WORK_CENTER_MFG'] = $rowData[0][3];
                $data[$i]['CHR_TYPE'] = $rowData[0][4];
                $data[$i]['INT_QTY_ORDER'] = $rowData[0][5];
 
                $i++;
            }
 
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Uploading success </strong> The temporary data is successfully created, to confirm click save at the bellow</div >";
            
            $data_view['month'] = $month;
            $data_view['app'] = $this->role_module_m->get_app();
            $data_view['module'] = $this->role_module_m->get_module();
            $data_view['function'] = $this->role_module_m->get_function();
            $data_view['sidebar'] = $this->role_module_m->side_bar(351);
            $data_view['news'] = $this->news_m->get_news();
            $data_view['title'] = 'Upload List Optimize Parts';
            $data_view['msg'] = $msg;
            
 
            $data_view['increment'] = $i;
            $data_view['data'] = $data;
 
            $data_view['content'] = 'mrp/explode_material/upload_list_part_v';
            $this->load->view($this->layout, $data_view);
 
        } else {
            redirect('prd/change_status_elina_c/upload_list_part/' . $msg = 15);
        }
         
     }

     function save_list_optimize_parts() {
        $tableRow = $this->input->post("tableRow");
        $month = $this->input->post('MONTH');
        $created_by = $this->session->userdata('USERNAME');

        $session = $this->session->all_userdata();
        $name = $session['USERNAME'];
        $date = date('Ymd');
        $time = date('His');

        foreach ($tableRow as $row) {
            if($row['FLG_DELETE'] == 0){ 
                $this->change_status_elina_m->update_flag_delete_list_part($month);

                $data_parts['CHR_MONTH'] = $month;
                $data_parts['CHR_PART_NO'] = $row['CHR_PART_NO'];
                $data_parts['CHR_WORK_CENTER'] = $row['CHR_WORK_CENTER'];
                $data_parts['CHR_WORK_CENTER_MFG'] = $row['CHR_WORK_CENTER_MFG'];
                $data_parts['CHR_TYPE'] = $row['CHR_TYPE'];
                $data_parts['INT_QTY_ORDER'] = $row['INT_QTY_ORDER'];
                $data_parts['CHR_CREATED_BY'] = $name;
                $data_parts['CHR_CREATED_DATE'] = $date;
                $data_parts['CHR_CREATED_TIME'] = $time;

                $this->change_status_elina_m->insert_overstock_parts($data_parts);
            }
        }

        redirect('prd/change_status_elina_c/optimize_capacity/0/' . $month, 'refresh');
    }

}
