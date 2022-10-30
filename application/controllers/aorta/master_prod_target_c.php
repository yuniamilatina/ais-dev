<?php

class Master_prod_target_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/master_prod_target_m');
    }

    public function prod_target($periode = null, $id_dept = null, $id_section = null, $id_subsect = null) {
        $this->role_module_m->authorization('151');
        $this->log_m->add_log(9, NULL);
        $this->session->userdata('user_id');

        $data['title'] = 'Master Production Target';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(163);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/master_prod_target_v';
        $ymd = date("Ymd");
        $date = date("Ym");
        
        if ($periode == null || $periode == '') {
            $date_selected = date("Ym");
        } else {
            $date_selected = $periode;
        }
        
        //print_r($id_dept);
        //exit();
       
        $data['selected_date'] = $date_selected;
        $data_karyawan = array();

        if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 39) { //Manager
            $data['id_prod'] = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $kode_dept = $this->session->userdata('DEPT');
            $all_work_centers = $this->master_prod_target_m->get_section($kode_dept);
            $all_lines = $this->master_prod_target_m->get_sub_section($kode_dept,$id_section);
            $dept_name = $row->CHR_DEPT;
            $data_karyawan = $this->master_prod_target_m->get_data_karyawan($kode_dept);
            $data_prod_target = $this->master_prod_target_m->get_prod_target($kode_dept, $date_selected, $id_section, $id_subsect);
        } else if ($this->session->userdata('ROLE') == 4 || $this->session->userdata('ROLE') == 3 || $this->session->userdata('ROLE') == 1 || $this->session->userdata('ROLE') == 62) { //GM od Director or Root or Task Force
            $data['id_prod'] = $id_dept;
            $kode_dept = $id_dept;
            $dept_name =  'ALL';
            $all_work_centers = $this->master_prod_target_m->get_section($id_dept);
            $all_lines = $this->master_prod_target_m->get_sub_section($kode_dept,$id_section);
            $data_prod_target = $this->master_prod_target_m->get_prod_target($kode_dept, $date_selected, $id_section, $id_subsect);
        }
//
//        if ($this->session->userdata('ROLE') == 3) {
//            $data['get_chart'] = $this->master_data_m->get_chart_bod_prd($selected_date);
//        }
        
        if($kode_dept == '' || $kode_dept == null || $kode_dept == 'ALL'){
            $id_section = 'ALL';
            $choose_work_centers = $all_work_centers;
        }else{
            if ($id_section == NULL || $id_section == '' || $id_section == 'ALL') {
                $choose_work_centers = $all_work_centers;
            } else {
                if($id_subsect == NULL || $id_subsect == '' || $id_subsect == 'ALL'){
                    $choose_work_centers = $this->master_prod_target_m->get_section_detail($kode_dept, $id_section, $id_subsect = null);
                }else{
                    $choose_work_centers = $this->master_prod_target_m->get_section_detail($kode_dept, $id_section, $id_subsect);
                }
                
            }
        }
        
        //print_r($choose_work_centers);
        //echo '<br>';
        //print_r($id_section);
        //exit(); 
        
        $data['kode_dept'] = $kode_dept;
        $data['data_karyawan'] = $data_karyawan;
        
        $data['data_prod_target'] = $data_prod_target;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_lines'] = $all_lines;
        $data['all_dept_prod'] = $this->dept_m->get_all_prod_dept();

        $data['id_dept'] = $id_dept;
        $data['id_section'] = $id_section;
        $data['id_subsect'] = $id_subsect;
        
        $data['date'] = date('d/m/Y');
        $data['fulldate'] = date('Ymd');
        $data['work_center'] = 'ALL';
        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        //$data['d'] = '';
        //$data['shift'] = '';
        $data['dept_name'] = $dept_name;
        $data['role'] = $this->session->userdata('ROLE');

        $this->load->view($this->layout, $data);
    }

    public function generate_template($dept) {
        $this->load->library('excel');

        //get data
        $dept_desc = $this->master_prod_target_m->replacer_dept_prd($dept);
        //$list_prod_target = $this->master_prod_target_m->get_prod_target($dept_desc, date("Ym"), $id_section = null, $id_subsect = null);
        $list_prod_target = $this->master_prod_target_m->get_all_section_per_dept($dept_desc);
        
        //print_r(date("Ym"));
        //exit();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Template Upload Master Monthly Production Target");
        $objPHPExcel->getProperties()->setSubject("Template Upload Master Monthly Production Target");
        $objPHPExcel->getProperties()->setDescription("Template Upload Master Monthly Production Target");

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Template Upload Master Monthly Production Target');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', ': ' . $dept_desc);

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(13);

        //Header Table
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Section');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Line');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Loading WO');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'MP');
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Sigma CT');
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Plan Shift');
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'Working Days');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );


        for ($index = "A"; $index < "I"; $index++) {
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->getFont()->setBold(true);
        }

        //data
        $row_no = 5;
        $no = 1;
        foreach ($list_prod_target as $value) {

            $objPHPExcel->getActiveSheet()->setCellValue("A$row_no", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$row_no", $value->KD_SECTION);//$value->CHR_SECTION);
            $objPHPExcel->getActiveSheet()->setCellValue("C$row_no", $value->KD_SUB_SECTION);//$value->CHR_LINE);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row_no", '');//$value->INT_LOAD);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row_no", '');//$value->INT_MP);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row_no", '');//$value->INT_CT);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row_no", '');//$value->INT_PLAN_SHIFT);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row_no", '');//$value->INT_WD);

            for ($index = "A"; $index < "I"; $index++) {
                $objPHPExcel->getActiveSheet()->getStyle($index . $row_no)->applyFromArray($styleArray);
                //if ($index <> "C") {
                    $objPHPExcel->getActiveSheet()->getStyle($index . $row_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //}
            }

            $row_no++;
            $no++;
        }

        $filename = "Template Upload Monthly Prod Target.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function upload_template_prod_target() {
        $aortadb = $this->load->database("aorta", TRUE);
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        
        $aortadb->query("TRUNCATE TABLE TW_PRODUCTION_TARGET");
        $pic = $this->session->userdata('NPK');
        $dept = $this->session->userdata('DEPT');
        $dept_desc = $this->master_prod_target_m->replacer_dept_prd($dept);
        
        $date_now = date("Ymd");
        $time_now = date("His");
        
        if ($this->input->post("upload_button") == 1) {
            $fileName = $_FILES['import_prod_target']['name'];
            $periode = $this->input->post('periode');
            
            if (empty($fileName)) {
                echo '<script>alert("Anda Belum Memilih File Untuk diupload");</script>';
                redirect('aorta/master_prod_target_c/prod_target', 'refresh');
            }
            // File for submit Excel file
            $config['upload_path'] = './assets/files/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = '*';
            $config['max_size'] = 10000;

            // Code for upload with CI
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('import_prod_target')){
               $this->upload->display_errors();
               exit();
            }   
            $media = $this->upload->data('import_prod_target');
            $inputFileName = './assets/files/' . $media['file_name'];
            
            // Read Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
            //$this->db->trans_rollback();
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            
            $x = 0;
            $y = 0;
            $rowHeader = $sheet->rangeToArray('A2:' . $highestColumn . '2', NULL, TRUE, FALSE);
            if ($rowHeader[0][0] == "Dept") {
                for ($row = 5; $row <= $highestRow; $row++) {
                    $error_msg = "";
                    $error_stat = 0;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    
                    //"CHR_SECTION"=>$rowData[0][1],
                    $section = $rowData[0][1];
                    //"CHR_LINE"=>$rowData[0][2],
                    $line = $rowData[0][2];
                    //"INT_LOAD"=>$rowData[0][4],
                    $load_wo = $rowData[0][3];
                    //"INT_MP"=>$rowData[0][5],
                    $mp = $rowData[0][4];
                    //"INT_CT"=>$rowData[0][6],
                    $ct = $rowData[0][5];
                    //"INT_PLAN_SHIFT"=>$rowData[0][6],
                    $plan_shift = $rowData[0][6];
                    //"INT_WD"=>$rowData[0][7],
                    $wd = $rowData[0][7];
                               
                 // Check database
                    $sql = "SELECT * FROM TM_PRODUCTION_TARGET WHERE CHR_SECTION = '$section' AND CHR_LINE = '$line' AND CHR_DATE_PERIODE = '$periode'";
                    $get_data = $aortadb->query($sql)->result();
                    $cek_data = $aortadb->query($sql)->num_rows();
                    if ($cek_data > 0) {
                        foreach ($get_data as $sql_data){
                            $error_stat = 1;
                            $error_msg = " Section $section dan Line $line sudah pernah diinputkan pada Monthly Target dengan Periode $periode ";
                            }
                    }
                        
                            // Check data type INT_LOAD
                            if (!is_numeric($load_wo)) {
                                $error_stat = 2;
                                $error_msg = " Pastikan tipe data Loading WO adalah NUMBER. ";
                            }

                            // Check data type INT_MP
                            if (!is_numeric($mp)) {
                                $error_stat = 2;
                                $error_msg = " Pastikan tipe data MP adalah NUMBER. ";
                            }
                            
                            // Check data type INT_CT
                            if (!is_numeric($ct)) {
                                $error_stat = 2;
                                $error_msg = " Pastikan tipe data Sigma CT adalah NUMBER. ";
                            }

                            // Check data type INT_PLAN_SHIFT
                            if (!is_numeric($plan_shift)) {
                                $error_stat = 2;
                                $error_msg = " Pastikan tipe data Plan Shift adalah NUMBER. ";
                            }

                            // Check data type INT_WD
                            if (!is_numeric($wd)) {
                                $error_stat = 2;
                                $error_msg = " Pastikan tipe data Working Days adalah NUMBER. ";
                            }
                            
                            if($ct == 0 || $mp == 0){
                                $target_prod = null;
                                $mh_pcs = null;
                                $error_stat = 2;
                                $error_msg = " Pastikan data Sigma CT dan MP tidak 0. ";                                
                            }else{
                                $target_prod = round((3600/($ct/$mp))*7.4*$plan_shift*$wd);
                                $mh_pcs = round($ct/3600,3);
                            }
                            
                            $load_wo = round($load_wo);
                            $ct = round($ct);

                            // Insert into DB TW_PRODUCTION_TARGET
                            $insert_target = "INSERT INTO TW_PRODUCTION_TARGET (CHR_DEPT, CHR_SECTION, CHR_LINE, CHR_DATE_PERIODE, INT_TARGET_PRD, INT_LOAD, INT_MP, "
                                    . "INT_CT, FLT_MH_PCS, CHR_DATE_UPLOAD, CHR_TIME_UPLOAD, INT_PLAN_SHIFT, INT_WD, STATUS_ERROR, MESSAGE) "
                                    . "VALUES ('$dept_desc', '$section', '$line', '$periode', '$target_prod', '$load_wo', '$mp', '$ct',"
                                    . "'$mh_pcs', $date_now, '$time_now', '$plan_shift', '$wd', '$error_stat' , '$error_msg');";
                            $aortadb->query($insert_target);
                }
                //exit();
                redirect("aorta/master_prod_target_c/data_target_confirmation", "refresh");
            }else {
                echo "<script>alert('Maaf data yang Anda masukan salah. Pastikan Anda menggunakan template dari sistem')</script>";
            }
                   
        }
    }
    
    public function data_target_confirmation() {
        $this->role_module_m->authorization('151');
        $this->log_m->add_log(9, NULL);
        $aortadb = $this->load->database("aorta", TRUE);
        $pic = $this->session->userdata('NPK');

        $date_now = date("Ymd");
        $time_now = date("His");

        $data['content'] = 'aorta/confirm_prod_target_list_v';
        $data['title'] = 'Confirm Master Monthly Production Target';

        $prod_target_list = $aortadb->query("SELECT * FROM  TW_PRODUCTION_TARGET")->result();
        if (count($prod_target_list) == 0) {
            redirect("aorta/master_prod_target_c/prod_target", "refresh");
        }

        // Cek upload OK
        $cek_upload_total = $aortadb->query("SELECT * FROM TW_PRODUCTION_TARGET")->num_rows();
        $cek_upload_ok = $aortadb->query("SELECT * FROM TW_PRODUCTION_TARGET WHERE STATUS_ERROR = '0'")->num_rows();
        $cek_upload_error = $aortadb->query("SELECT * FROM TW_PRODUCTION_TARGET WHERE STATUS_ERROR = '2'")->num_rows();

        if ($this->input->post("btn-confirm") != '') {

            $range = 0;
            foreach ($prod_target_list as $value_list) {

                $dept = trim($value_list->CHR_DEPT);
                $section = trim($value_list->CHR_SECTION);
                $line = trim($value_list->CHR_LINE);
                $periode = trim($value_list->CHR_DATE_PERIODE);
                $target_prod = trim($value_list->INT_TARGET_PRD);
                $load_wo = trim($value_list->INT_LOAD);
                $mp = trim($value_list->INT_MP);
                $ct = trim($value_list->INT_CT);
                $mh_pcs = trim($value_list->FLT_MH_PCS);
                $plan_shift = trim($value_list->INT_PLAN_SHIFT);
                $wd = trim($value_list->INT_WD);
                $date = trim($value_list->CHR_DATE_UPLOAD);
                $time = trim($value_list->CHR_TIME_UPLOAD);

                $cek_exist = $aortadb->query("SELECT * FROM TM_PRODUCTION_TARGET WHERE CHR_DEPT = '$dept' AND CHR_SECTION = '$section' AND CHR_LINE = '$line' AND CHR_DATE_PERIODE = '$periode'")->num_rows();
                if($cek_exist > 0){
                    $aortadb->query("UPDATE TM_PRODUCTION_TARGET SET INT_TARGET_PRD = '$target_prod',"
                        . "INT_LOAD = '$load_wo', INT_MP = '$mp', INT_CT = '$ct', FLT_MH_PCS = '$mh_pcs', CHR_DATE_UPLOAD = '$date_now',"
                        . "CHR_TIME_UPLOAD = '$time_now', INT_PLAN_SHIFT = '$plan_shift', INT_WD = '$wd', INT_FLG_DEL = '0' WHERE CHR_DEPT = '$dept' AND CHR_SECTION = '$section' AND CHR_LINE = '$line' AND CHR_DATE_PERIODE = '$periode';");
                    $range++;
                }else{
                    $aortadb->query("INSERT INTO TM_PRODUCTION_TARGET (CHR_DEPT, CHR_SECTION, CHR_LINE, CHR_DATE_PERIODE, INT_TARGET_PRD,"
                        . "INT_LOAD, INT_MP, INT_CT, FLT_MH_PCS, INT_PLAN_SHIFT, INT_WD, CHR_UPLOAD_BY, CHR_DATE_UPLOAD, CHR_TIME_UPLOAD, INT_FLG_DEL) "
                        . "VALUES ('$dept', '$section', '$line', '$periode', '$target_prod', '$load_wo', '$mp', '$ct', '$mh_pcs', '$plan_shift', '$wd', '$pic', '$date_now', '$time_now', '0')");
                    $range++;
                }
                
            }
            $aortadb->query("TRUNCATE TABLE TW_PRODUCTION_TARGET");

            redirect("aorta/master_prod_target_c/prod_target", "refresh");
        }

        $data['prod_target_list'] = $prod_target_list;
        $data['cek_upload_total'] = $cek_upload_total;
        $data['cek_upload_ok'] = $cek_upload_ok;
        $data['cek_upload_error'] = $cek_upload_error;

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(163);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }
    
}
