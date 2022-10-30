<?php

class report_overtime_perdept_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/master_prod_target_m');
    }

    function index($periode = null, $id_dept = null) {
        $this->role_module_m->authorization('162');
        $data['title'] = 'Report Overtime Per Dept';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(162);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/report_overtime_per_dept_v';

        if ($periode == null) {
            $selected_date = date("Ym");
        } else {
            $selected_date = $periode;
        }

        $data['holiday'] = $this->master_prod_target_m->get_holiday($selected_date);

        if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 39 || $this->session->userdata('ROLE') == 6 || $this->session->userdata('ROLE') == 45) { // Manager
            // $id_dept = $this->session->userdata('DEPT');
            $data['overtime_quota'] = $this->master_prod_target_m->get_overtime_quota_by_dept($selected_date, $id_dept);
            $data['overtime_summary'] = $this->master_prod_target_m->get_overtime_summary_dept($selected_date, $id_dept);
        } else if ($this->session->userdata('ROLE') == 62) { //SPV Task Force
            $data['overtime_quota'] = $this->master_prod_target_m->get_overtime_quota_by_dept($selected_date, $id_dept);
            $data['overtime_summary'] = $this->master_prod_target_m->get_overtime_summary_dept($selected_date, $id_dept);
        } else if ($this->session->userdata('ROLE') == 3 || $this->session->userdata('ROLE') == 4 || $this->session->userdata('ROLE') == 1 || $this->session->userdata('ROLE') == 14){ // GM & BOD
            $data['overtime_quota'] = $this->master_prod_target_m->get_overtime_quota_by_dept($selected_date, $id_dept);
            $data['overtime_summary'] = $this->master_prod_target_m->get_overtime_summary_dept($selected_date, $id_dept);
        }

        $choose_line = $this->master_prod_target_m->get_overtime_summary_dept($selected_date, $id_dept);

        // $all_dept_prod = $this->dept_m->get_all_prod_dept(); //===== Khusus Prod
        $all_dept_prod = $this->dept_m->get_all_dept_plant();
        $data['choose_dept'] = $choose_line;
        $data['all_dept_prod'] = $all_dept_prod;
        $data['id_dept'] = $id_dept;
        $data['selected_date'] = $selected_date;
        $data['role'] = $this->session->userdata('ROLE');
        $this->load->view($this->layout, $data);
    }
    
    function print_report_overtime() {
        $aortadb = $this->load->database("aorta", TRUE);
        $this->load->library('excel');
        
        $date_selected = $this->input->post('CHR_DATE_SELECTED');
        $dept_selected = $this->input->post('CHR_DEPT_SELECTED');
        
        $dept_desc = trim($this->master_prod_target_m->replacer_dept_prd($dept_selected));
              
        $overtime_summary = $this->master_prod_target_m->get_overtime_summary_dept($date_selected, $dept_selected);
               
        $year_only = substr($date_selected, 0, 4);
        $date_only = substr($date_selected, 4, 2); 
                        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Overtime per Dept");
        $objPHPExcel->getProperties()->setSubject("Report Overtime per Dept");
        $objPHPExcel->getProperties()->setDescription("Report Overtime per Dept");
        
        // Set Properties
        //SETUP EXCEL
        $width = 10;
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth($width);
        
        //SETUP EXCEL
        //TITLE
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Report Overtime per Department');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:AJ1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Dept');
        if($dept_selected == '' || $dept_selected == 'ALL' || $dept_selected == null){
            $objPHPExcel->getActiveSheet()->setCellValue('B2', ': ALL');
        } else{
            $objPHPExcel->getActiveSheet()->setCellValue('B2', ': ' . $dept_desc);
        }        
        
        //SETUP EXCEL
        //TITLE
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true)->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true)->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('A4:AJ5')->getFont()->setBold(true)->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle("A4:AJ5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A4:AJ4")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
        //MERGE TABLE
        $objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
        $objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
        $objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
        $objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
        $objPHPExcel->getActiveSheet()->mergeCells('F4:AJ4');        
        
        //TABLE OVERTIME
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Department');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Criteria');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', '');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Date');
        $objPHPExcel->getActiveSheet()->setCellValue('F5', '1');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', '2');
        $objPHPExcel->getActiveSheet()->setCellValue('H5', '3');
        $objPHPExcel->getActiveSheet()->setCellValue('I5', '4');
        $objPHPExcel->getActiveSheet()->setCellValue('J5', '5');
        $objPHPExcel->getActiveSheet()->setCellValue('K5', '6');
        $objPHPExcel->getActiveSheet()->setCellValue('L5', '7');
        $objPHPExcel->getActiveSheet()->setCellValue('M5', '8');
        $objPHPExcel->getActiveSheet()->setCellValue('N5', '9');
        $objPHPExcel->getActiveSheet()->setCellValue('O5', '10');
        $objPHPExcel->getActiveSheet()->setCellValue('P5', '11');
        $objPHPExcel->getActiveSheet()->setCellValue('Q5', '12');
        $objPHPExcel->getActiveSheet()->setCellValue('R5', '13');
        $objPHPExcel->getActiveSheet()->setCellValue('S5', '14');
        $objPHPExcel->getActiveSheet()->setCellValue('T5', '15');
        $objPHPExcel->getActiveSheet()->setCellValue('U5', '16');
        $objPHPExcel->getActiveSheet()->setCellValue('V5', '17');
        $objPHPExcel->getActiveSheet()->setCellValue('W5', '18');
        $objPHPExcel->getActiveSheet()->setCellValue('X5', '19');
        $objPHPExcel->getActiveSheet()->setCellValue('Y5', '20');
        $objPHPExcel->getActiveSheet()->setCellValue('Z5', '21');
        $objPHPExcel->getActiveSheet()->setCellValue('AA5', '22');
        $objPHPExcel->getActiveSheet()->setCellValue('AB5', '23');
        $objPHPExcel->getActiveSheet()->setCellValue('AC5', '24');
        $objPHPExcel->getActiveSheet()->setCellValue('AD5', '25');
        $objPHPExcel->getActiveSheet()->setCellValue('AE5', '26');
        $objPHPExcel->getActiveSheet()->setCellValue('AF5', '27');
        $objPHPExcel->getActiveSheet()->setCellValue('AG5', '28');
        $objPHPExcel->getActiveSheet()->setCellValue('AH5', '29');
        $objPHPExcel->getActiveSheet()->setCellValue('AI5', '30');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ5', '31');

        $e = 6;
        $p = 7;
        $no = 1;
        foreach ($overtime_summary as $row) {
            $merge_no = $e+10;
            $objPHPExcel->getActiveSheet()->mergeCells("A$e:A$merge_no");
            $objPHPExcel->getActiveSheet()->mergeCells("B$e:B$merge_no");
            
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->KD_DEPT);
            
            // e = 6
            //---------MAN POWER------------------------------------------
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", 'Man Power (MP)');            
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", '-');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AH$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AI$e", $row->MP);
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", $row->MP);
            
            //---------PLAN BY WO---MAN HOUR (MH)-------------------------           
            
            if($row->PLAN_BY_WO <= 0){
                $plan_wo = 0;
            }else{
                $plan_wo = $row->PLAN_BY_WO;
            }

            if($row->WORKING_DAY == 0){
                $wd = 20;
            }else{
                $wd = $row->WORKING_DAY;
            }

            if($row->MP == 0){
                $mp = 1;
            }else{
                $mp = $row->MP;
            }
            
            $max_ot_per_day = 3.5*$mp;
            $max_ot_holiday = 8*$mp;
            $ot_day = $plan_wo / $max_ot_per_day;
            $ot_per_day = $plan_wo / $wd;
            $plan_wo_array = array();
            if ($ot_day <= $wd) {
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $plan_wo_array[] = $ot_per_day;
                    }else{
                        $plan_wo_array[] = 0;
                    }                                                    
                }
            }else{
                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $plan_wo_array[] = $max_ot_per_day;
                    }else{
                        if($ot_holiday >= $max_ot_holiday){
                            $plan_wo_array[] = $max_ot_holiday;
                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                            $plan_wo_array[] = $ot_holiday;
                        }else{
                            $plan_wo_array[] = 0;
                        }
                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                    }
                }
            }
            
            $e = $e+1; // e = 7
            $merge_plan = $e+1;
            $objPHPExcel->getActiveSheet()->mergeCells("C$e:C$merge_plan");
            
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", 'OT Plan');            
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'MH');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->PLAN_BY_WO);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $plan_wo_array[0]);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $plan_wo_array[1]);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $plan_wo_array[2]);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $plan_wo_array[3]);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $plan_wo_array[4]);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $plan_wo_array[5]);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $plan_wo_array[6]);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $plan_wo_array[7]);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $plan_wo_array[8]);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $plan_wo_array[9]);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $plan_wo_array[10]);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $plan_wo_array[11]);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $plan_wo_array[12]);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $plan_wo_array[13]);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $plan_wo_array[14]);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $plan_wo_array[15]);
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", $plan_wo_array[16]);
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", $plan_wo_array[17]);
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", $plan_wo_array[18]);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", $plan_wo_array[19]);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", $plan_wo_array[20]);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", $plan_wo_array[21]);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", $plan_wo_array[22]);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", $plan_wo_array[23]);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", $plan_wo_array[24]);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", $plan_wo_array[25]);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", $plan_wo_array[26]);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", $plan_wo_array[27]);
            if (array_key_exists('28', $plan_wo_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", $plan_wo_array[28]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", '0');
            }
            if (array_key_exists('29', $plan_wo_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", $plan_wo_array[29]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", '0');
            }
            if (array_key_exists('30', $plan_wo_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", $plan_wo_array[30]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", '0');
            }
            
            
            //---------PLAN BY WO---AMOUNT------------------------------------------
            
            if($row->PLAN_BY_WO <= 0){
                $plan_wo = 0;
            }else{
                $plan_wo = $row->PLAN_BY_WO;
            }

            if($row->WORKING_DAY == 0){
                $wd = 20;
            }else{
                $wd = $row->WORKING_DAY;
            }

            if($row->MP == 0){
                $mp = 1;
            }else{
                $mp = $row->MP;
            }

            $max_ot_per_day = 3.5*$mp;
            $max_ot_holiday = 8*$mp;
            $ot_day = $plan_wo / $max_ot_per_day;
            $ot_per_day = $plan_wo / $wd;
            $amount = $row->AVG_TUL;
            $amount_array = array();

            if($ot_day <= $wd){
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $amount_array[] = number_format($amount*2*$ot_per_day*0.006,2,',','.');
                    } else {
                        $amount_array[] = '0,00';
                    }

                }
            }else{
                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $amount_array[] = number_format($amount*2*$max_ot_per_day*0.006,2,',','.');
                    } else {
                        if($ot_holiday >= $max_ot_holiday){
                            $amount_array[] = number_format($amount*2*$max_ot_holiday*0.006,2,',','.');
                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                            $amount_array[] = number_format($amount*2*$ot_holiday*0.006,2,',','.');
                        }else{
                            $amount_array[] = '0,00';
                        }
                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                    }        
                }
            }
            
            $e = $e+1; // e = 8
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'Amount');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", number_format($amount*2*$plan_wo*0.006,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $amount_array[0]);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $amount_array[1]);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $amount_array[2]);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $amount_array[3]);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $amount_array[4]);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $amount_array[5]);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $amount_array[6]);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $amount_array[7]);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $amount_array[8]);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $amount_array[9]);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $amount_array[10]);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $amount_array[11]);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $amount_array[12]);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $amount_array[13]);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $amount_array[14]);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $amount_array[15]);
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", $amount_array[16]);
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", $amount_array[17]);
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", $amount_array[18]);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", $amount_array[19]);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", $amount_array[20]);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", $amount_array[21]);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", $amount_array[22]);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", $amount_array[23]);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", $amount_array[24]);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", $amount_array[25]);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", $amount_array[26]);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", $amount_array[27]);
            if (array_key_exists('28', $amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", $amount_array[28]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", '0,00');
            }
            if (array_key_exists('29', $amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", $amount_array[29]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", '0,00');
            }
            if (array_key_exists('30', $amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", $amount_array[30]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", '0,00');
            }        
                
            //---------ACTUAL OT---MAN HOUR (MH)------------------------------------
            
            $actual_hour = $aortadb->query("EXEC zsp_get_actual_overtime_hour_dept '$date_selected', '" . $row->KD_DEPT . "'")->row();
            
            $e = $e+1; // e = 9
            $merge_actual = $e+1;
            $objPHPExcel->getActiveSheet()->mergeCells("C$e:C$merge_actual");
            
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", 'Actual');
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'MH');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->TOT_DURASI_OVERTIME);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $actual_hour->HOUR_01);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $actual_hour->HOUR_02);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $actual_hour->HOUR_03);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $actual_hour->HOUR_04);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $actual_hour->HOUR_05);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $actual_hour->HOUR_06);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $actual_hour->HOUR_07);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $actual_hour->HOUR_08);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $actual_hour->HOUR_09);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $actual_hour->HOUR_10);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $actual_hour->HOUR_11);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $actual_hour->HOUR_12);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $actual_hour->HOUR_13);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $actual_hour->HOUR_14);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $actual_hour->HOUR_15);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $actual_hour->HOUR_16);
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", $actual_hour->HOUR_17);
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", $actual_hour->HOUR_18);
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", $actual_hour->HOUR_19);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", $actual_hour->HOUR_20);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", $actual_hour->HOUR_21);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", $actual_hour->HOUR_22);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", $actual_hour->HOUR_23);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", $actual_hour->HOUR_24);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", $actual_hour->HOUR_25);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", $actual_hour->HOUR_26);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", $actual_hour->HOUR_27);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", $actual_hour->HOUR_28);
            $objPHPExcel->getActiveSheet()->setCellValue("AH$e", $actual_hour->HOUR_29);
            $objPHPExcel->getActiveSheet()->setCellValue("AI$e", $actual_hour->HOUR_30);
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", $actual_hour->HOUR_31);
            
            //---------ACTUAL OT---AMOUNT------------------------------------------
            
            $actual_amount = $aortadb->query("EXEC zsp_get_actual_overtime_amount_dept '$date_selected', '" . $row->KD_DEPT . "'")->row();
            
            $e = $e+1; // e = 10
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'Amount');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", number_format($row->TOT_AMOUNT_OVERTIME,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", number_format($actual_amount->AMO_01,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", number_format($actual_amount->AMO_02,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", number_format($actual_amount->AMO_03,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", number_format($actual_amount->AMO_04,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", number_format($actual_amount->AMO_05,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", number_format($actual_amount->AMO_06,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", number_format($actual_amount->AMO_07,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", number_format($actual_amount->AMO_08,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", number_format($actual_amount->AMO_09,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", number_format($actual_amount->AMO_10,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", number_format($actual_amount->AMO_11,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", number_format($actual_amount->AMO_12,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", number_format($actual_amount->AMO_13,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", number_format($actual_amount->AMO_14,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", number_format($actual_amount->AMO_15,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", number_format($actual_amount->AMO_16,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", number_format($actual_amount->AMO_17,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", number_format($actual_amount->AMO_18,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", number_format($actual_amount->AMO_19,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", number_format($actual_amount->AMO_20,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", number_format($actual_amount->AMO_21,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", number_format($actual_amount->AMO_22,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", number_format($actual_amount->AMO_23,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", number_format($actual_amount->AMO_24,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", number_format($actual_amount->AMO_25,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", number_format($actual_amount->AMO_26,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", number_format($actual_amount->AMO_27,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", number_format($actual_amount->AMO_28,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AH$e", number_format($actual_amount->AMO_29,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AI$e", number_format($actual_amount->AMO_30,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", number_format($actual_amount->AMO_31,2,',','.'));
            
            //---------ACCUMULATIVE PLAN---MAN HOUR (MH)--------------------------------
            
            if($row->PLAN_BY_WO <= 0){
                $plan_wo = 0;
            }else{
                $plan_wo = $row->PLAN_BY_WO;
            }

            if($row->WORKING_DAY == 0){
                $wd = 20;
            }else{
                $wd = $row->WORKING_DAY;
            }

            if($row->MP == 0){
                $mp = 1;
            }else{
                $mp = $row->MP;
            }

            $max_ot_per_day = 3.5*$mp;
            $max_ot_holiday = 8*$mp;
            $ot_day = $plan_wo / $max_ot_per_day;
            $ot_per_day = $plan_wo / $wd;
            $plan_accu = 0;
            $plan_accu_array = array();
            
            if($ot_day <= $wd){
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $plan_accu = $plan_accu + $ot_per_day;
                        $plan_accu_array[] = number_format($plan_accu,0,',','.');    
                    } else {
                        $plan_accu_array[] = number_format($plan_accu,0,',','.');
                    }

                }
            }else{
                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $plan_accu = $plan_accu + $max_ot_per_day;    
                        $plan_accu_array[] = number_format($plan_accu,0,',','.');
                    }else{
                        if($ot_holiday >= $max_ot_holiday){
                            $plan_accu = $plan_accu + $max_ot_holiday;
                            $plan_accu_array[] = number_format($plan_accu,0,',','.');
                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                            $plan_accu = $plan_accu + $ot_holiday;
                            $plan_accu_array[] = number_format($plan_accu,0,',','.');
                        }else{
                            $plan_accu_array[] = number_format($plan_accu,0,',','.');
                        }
                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                    }
                }
            }
            
            $e = $e+1; // e = 11
            $merge_accu_plan = $e+1;
            $objPHPExcel->getActiveSheet()->mergeCells("C$e:C$merge_accu_plan");
            
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", 'Accumulative Plan');
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'MH');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", number_format($plan_wo,0,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $plan_accu_array[0]);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $plan_accu_array[1]);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $plan_accu_array[2]);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $plan_accu_array[3]);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $plan_accu_array[4]);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $plan_accu_array[5]);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $plan_accu_array[6]);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $plan_accu_array[7]);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $plan_accu_array[8]);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $plan_accu_array[9]);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $plan_accu_array[10]);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $plan_accu_array[11]);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $plan_accu_array[12]);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $plan_accu_array[13]);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $plan_accu_array[14]);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $plan_accu_array[15]);
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", $plan_accu_array[16]);
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", $plan_accu_array[17]);
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", $plan_accu_array[18]);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", $plan_accu_array[19]);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", $plan_accu_array[20]);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", $plan_accu_array[21]);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", $plan_accu_array[22]);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", $plan_accu_array[23]);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", $plan_accu_array[24]);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", $plan_accu_array[25]);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", $plan_accu_array[26]);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", $plan_accu_array[27]);
            if (array_key_exists('28', $plan_accu_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", $plan_accu_array[28]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", '0');
            }
            if (array_key_exists('29', $plan_accu_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", $plan_accu_array[29]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", '0');
            }
            if (array_key_exists('30', $plan_accu_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", $plan_accu_array[30]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", '0');
            }
            
            //---------ACCUMULATIVE PLAN---AMOUNT------------------------------------
            
            if($row->PLAN_BY_WO <= 0){
                $plan_wo = 0;
            }else{
                $plan_wo = $row->PLAN_BY_WO;
            }

            if($row->WORKING_DAY == 0){
                $wd = 20;
            }else{
                $wd = $row->WORKING_DAY;
            }

            if($row->MP == 0){
                $mp = 1;
            }else{
                $mp = $row->MP;
            }

            $max_ot_per_day = 3.5*$mp;
            $max_ot_holiday = 8*$mp;
            $ot_day = $plan_wo / $max_ot_per_day;
            $ot_per_day = $plan_wo / $wd;
            $plan_amount = 0;
            $plan_accu_amount_array = array();
            
            if($ot_day <= $wd){
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $plan_amount = $plan_amount + ($amount*2*$ot_per_day*0.006);
                        $plan_accu_amount_array[] = number_format($plan_amount,2,',','.');
                    } else {
                        $plan_accu_amount_array[] = number_format($plan_amount,2,',','.');
                    }

                }
            }else{
                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $plan_amount = $plan_amount + ($amount*2*$max_ot_per_day*0.006);
                        $plan_accu_amount_array[] = number_format($plan_amount,2,',','.');
                    } else {
                        if($ot_holiday >= $max_ot_holiday){
                            $plan_amount = $plan_amount + ($amount*2*$max_ot_holiday*0.006);
                            $plan_accu_amount_array[] = number_format($plan_amount,2,',','.');
                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                            $plan_amount = $plan_amount + ($amount*2*$ot_holiday*0.006);
                            $plan_accu_amount_array[] = number_format($plan_amount,2,',','.');
                        }else{
                            $plan_accu_amount_array[] = '0,00';
                        }
                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                    }        
                }                                                
            }
            
            $e = $e+1; // e = 12
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'Amount');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", number_format($amount*2*$plan_wo*0.006,2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $plan_accu_amount_array[0]);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $plan_accu_amount_array[1]);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $plan_accu_amount_array[2]);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $plan_accu_amount_array[3]);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $plan_accu_amount_array[4]);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $plan_accu_amount_array[5]);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $plan_accu_amount_array[6]);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $plan_accu_amount_array[7]);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $plan_accu_amount_array[8]);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $plan_accu_amount_array[9]);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $plan_accu_amount_array[10]);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $plan_accu_amount_array[11]);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $plan_accu_amount_array[12]);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $plan_accu_amount_array[13]);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $plan_accu_amount_array[14]);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $plan_accu_amount_array[15]);
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", $plan_accu_amount_array[16]);
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", $plan_accu_amount_array[17]);
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", $plan_accu_amount_array[18]);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", $plan_accu_amount_array[19]);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", $plan_accu_amount_array[20]);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", $plan_accu_amount_array[21]);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", $plan_accu_amount_array[22]);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", $plan_accu_amount_array[23]);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", $plan_accu_amount_array[24]);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", $plan_accu_amount_array[25]);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", $plan_accu_amount_array[26]);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", $plan_accu_amount_array[27]);
            if (array_key_exists('28', $plan_accu_amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", $plan_accu_amount_array[28]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", '0,00');
            }
            if (array_key_exists('29', $plan_accu_amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", $plan_accu_amount_array[29]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", '0,00');
            }
            if (array_key_exists('30', $plan_accu_amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", $plan_accu_amount_array[30]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", '0,00');
            }
            
            //---------ACCUMULATIVE ACTUAL---MAN HOUR (MH)-----------------------------
            
            $actual_hour = $aortadb->query("EXEC zsp_get_actual_overtime_hour_dept '$date_selected', '" . $row->KD_DEPT . "'")->row();
            $actual_hour_accu = 0;
            
            $e = $e+1; // e = 13
            $merge_accu_actual = $e+1;
            $objPHPExcel->getActiveSheet()->mergeCells("C$e:C$merge_accu_actual");
            
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", 'Accumulative Actual');
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'MH');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", number_format($actual_hour->HOUR_TOTAL,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_01;
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_02;
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_03;
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_04;
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_05;
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_06;
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_07;
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_08;
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_09;
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_10;
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_11;
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_12;
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_13;
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_14;
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_15;
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_16;
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_17;
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_18;
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_19;
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_20;
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_21;
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_22;
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_23;
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_24;
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_25;
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_26;
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_27;
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_28;
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_29;
            $objPHPExcel->getActiveSheet()->setCellValue("AH$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_30;
            $objPHPExcel->getActiveSheet()->setCellValue("AI$e", number_format($actual_hour_accu,0,',','.'));
            $actual_hour_accu = $actual_hour_accu + $actual_hour->HOUR_31;
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", number_format($actual_hour_accu,0,',','.'));
            
            //---------ACCUMULATIVE ACTUAL---AMOUNT-----------------------------
            
            $actual_amount = $aortadb->query("EXEC zsp_get_actual_overtime_amount_dept '$date_selected', '" . $row->KD_DEPT . "'")->row();
            $actual_amount_accu = 0;
            
            $e = $e+1; // e = 14
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'Amount');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", number_format($actual_amount->AMOUNT_TOTAL,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_01;
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_02;
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_03;
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_04;
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_05;
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_06;
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_07;
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_08;
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_09;
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_10;
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_11;
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_12;
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_13;
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_14;
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_15;
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_16;
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_17;
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_18;
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_19;
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_20;
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_21;
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_22;
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_23;
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_24;
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_25;
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_26;
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_27;
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_28;
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_29;
            $objPHPExcel->getActiveSheet()->setCellValue("AH$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_30;
            $objPHPExcel->getActiveSheet()->setCellValue("AI$e", number_format($actual_amount_accu,2,',','.'));
            $actual_amount_accu = $actual_amount_accu + $actual_amount->AMO_31;
            $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", number_format($actual_amount_accu,2,',','.'));
            
            //---------BALANCE OT VS ACTUAL---MAN HOUR (MH)-----------------------------
            
            if($row->PLAN_BY_WO <= 0){
                $plan_wo = 0;
            }else{
                $plan_wo = $row->PLAN_BY_WO;
            }

            if($row->WORKING_DAY == 0){
                $wd = 20;
            }else{
                $wd = $row->WORKING_DAY;
            }

            if($row->MP == 0){
                $mp = 1;
            }else{
                $mp = $row->MP;
            }

            $max_ot_per_day = 3.5*$mp;
            $max_ot_holiday = 8*$mp;
            $ot_day = $plan_wo / $max_ot_per_day;
            $ot_per_day = $plan_wo / $wd;
            $actual_duration = $row->TOT_DURASI_OVERTIME;
            $balance_ot_hour = $plan_wo - $actual_duration;
            $balance_hour_array = array();
            
            if($ot_day <= $wd){
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $act_hour = 'HOUR_'.$day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $balance_ot = $ot_per_day - $actual_hour->$act_hour ;
                        $balance_hour_array[] = number_format($balance_ot,0,',','.');
                    } else {
                        $balance_hour_array[] = number_format(0 - $actual_hour->$act_hour,0,',','.');
                    }
                }
            }else{
                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $balance_ot = $max_ot_per_day - $actual_hour->$act_hour ;    
                        $balance_hour_array[] = number_format($balance_ot,0,',','.');
                    }else{
                        if($ot_holiday >= $max_ot_holiday){
                            $$balance_ot = $max_ot_holiday - $actual_hour->$act_hour ;
                            $balance_hour_array[] = number_format($balance_ot,0,',','.');
                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                            $balance_ot = $ot_holiday - $actual_hour->$act_hour ;;
                            $balance_hour_array[] = number_format($balance_ot,0,',','.');
                        }else{
                            $balance_hour_array[] = number_format($balance_ot,0,',','.');
                        }
                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                    }
                }
            }
            
            $e = $e+1; // e = 15
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", 'Balance OT Plan vs Actual');
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'MH');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", number_format($balance_ot_hour,0,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $balance_hour_array[0]);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $balance_hour_array[1]);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $balance_hour_array[2]);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $balance_hour_array[3]);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $balance_hour_array[4]);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $balance_hour_array[5]);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $balance_hour_array[6]);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $balance_hour_array[7]);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $balance_hour_array[8]);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $balance_hour_array[9]);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $balance_hour_array[10]);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $balance_hour_array[11]);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $balance_hour_array[12]);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $balance_hour_array[13]);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $balance_hour_array[14]);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $balance_hour_array[15]);
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", $balance_hour_array[16]);
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", $balance_hour_array[17]);
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", $balance_hour_array[18]);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", $balance_hour_array[19]);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", $balance_hour_array[20]);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", $balance_hour_array[21]);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", $balance_hour_array[22]);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", $balance_hour_array[23]);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", $balance_hour_array[24]);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", $balance_hour_array[25]);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", $balance_hour_array[26]);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", $balance_hour_array[27]);
            if (array_key_exists('28', $balance_hour_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", $balance_hour_array[28]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", '0');
            }
            if (array_key_exists('29', $balance_hour_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", $balance_hour_array[29]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", '0');
            }
            if (array_key_exists('30', $balance_hour_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", $balance_hour_array[30]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", '0');
            }
            
            //---------BALANCE OT VS ACTUAL---AMOUNT-----------------------------
            
            if($row->PLAN_BY_WO <= 0){
                $plan_wo = 0;
            }else{
                $plan_wo = $row->PLAN_BY_WO;
            }

            if($row->WORKING_DAY == 0){
                $wd = 20;
            }else{
                $wd = $row->WORKING_DAY;
            }

            if($row->MP == 0){
                $mp = 1;
            }else{
                $mp = $row->MP;
            }

            $max_ot_per_day = 3.5*$mp;
            $max_ot_holiday = 8*$mp;
            $ot_day = $plan_wo / $max_ot_per_day;
            $ot_per_day = $plan_wo / $wd;
            $amount = $row->AVG_TUL;
            $balance_ot_amount = ($amount*2*$plan_wo*0.006)-$actual_amount->AMOUNT_TOTAL;
            $balance_amount_array = array();
                        
            if($ot_day <= $wd){
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $act_amount = 'AMO_'.$day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $balance_ot_amount = ($amount*2*$ot_per_day*0.006) - $actual_amount->$act_amount ;
                        $balance_amount_array[] = number_format($balance_ot_amount,2,',','.');
                    } else {
                        $balance_amount_array[] = number_format(0 - $actual_amount->$act_amount,2,',','.');
                    }
                }
            }else{
                $ot_holiday = $plan_wo - ($max_ot_per_day * $wd);
                for ($index = 1; $index < (date("t", strtotime($date_selected . "01")) + 1); $index++) {
                    $day = sprintf("%02d", $index);
                    $date = $date_selected . $day;
                    $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                                    . "WHERE TGL_LIBUR LIKE '$date%'")->num_rows();
                    if ($holiday == 0) {
                        $balance_ot_amount = ($amount*2*$max_ot_per_day*0.006) - $actual_amount->$act_amount ;    
                        $balance_amount_array[] = number_format($balance_ot_amount,2,',','.');
                    }else{
                        if($ot_holiday >= $max_ot_holiday){
                            $balance_ot_amount = ($amount*2*$max_ot_holiday*0.006) - $actual_amount->$act_amount ;
                            $balance_amount_array[] = number_format($balance_ot_amount,2,',','.');
                        }else if($ot_holiday < $max_ot_holiday && $ot_holiday > 0){
                            $balance_ot_amount = ($amount*2*$ot_holiday*0.006) - $actual_amount->$act_amount ;
                            $balance_amount_array[] = number_format($balance_ot_amount,2,',','.');
                        }else{
                            $balance_amount_array[] = number_format($balance_ot_amount,2,',','.');
                        }
                        $ot_holiday = $ot_holiday - $max_ot_holiday;
                    }
                }
            }
            
            $e = $e+1; // e = 16
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", 'Balance ACC Plan vs Actual');
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", 'Amount');
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", number_format((($amount*2*$plan_wo*0.006)-$actual_amount->AMOUNT_TOTAL),2,',','.'));
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $balance_amount_array[0]);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $balance_amount_array[1]);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $balance_amount_array[2]);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $balance_amount_array[3]);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $balance_amount_array[4]);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $balance_amount_array[5]);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $balance_amount_array[6]);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $balance_amount_array[7]);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $balance_amount_array[8]);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $balance_amount_array[9]);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $balance_amount_array[10]);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $balance_amount_array[11]);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $balance_amount_array[12]);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $balance_amount_array[13]);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $balance_amount_array[14]);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $balance_amount_array[15]);
            $objPHPExcel->getActiveSheet()->setCellValue("V$e", $balance_amount_array[16]);
            $objPHPExcel->getActiveSheet()->setCellValue("W$e", $balance_amount_array[17]);
            $objPHPExcel->getActiveSheet()->setCellValue("X$e", $balance_amount_array[18]);
            $objPHPExcel->getActiveSheet()->setCellValue("Y$e", $balance_amount_array[19]);
            $objPHPExcel->getActiveSheet()->setCellValue("Z$e", $balance_amount_array[20]);
            $objPHPExcel->getActiveSheet()->setCellValue("AA$e", $balance_amount_array[21]);
            $objPHPExcel->getActiveSheet()->setCellValue("AB$e", $balance_amount_array[22]);
            $objPHPExcel->getActiveSheet()->setCellValue("AC$e", $balance_amount_array[23]);
            $objPHPExcel->getActiveSheet()->setCellValue("AD$e", $balance_amount_array[24]);
            $objPHPExcel->getActiveSheet()->setCellValue("AE$e", $balance_amount_array[25]);
            $objPHPExcel->getActiveSheet()->setCellValue("AF$e", $balance_amount_array[26]);
            $objPHPExcel->getActiveSheet()->setCellValue("AG$e", $balance_amount_array[27]);
            if (array_key_exists('28', $balance_amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", $balance_amount_array[28]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AH$e", '0,00');
            }
            if (array_key_exists('29', $balance_amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", $balance_amount_array[29]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AI$e", '0,00');
            }
            if (array_key_exists('30', $balance_amount_array)) {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", $balance_amount_array[30]);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue("AJ$e", '0,00');
            }                 
                        
            $e++;
            $no++;
        }
        
        $border = $e-1;
        $objPHPExcel->getActiveSheet()->getStyle("A6:B$border")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C6:C$border")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle("D6:D$border")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("E6:AJ$border")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle("A6:C$border")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        
        $objPHPExcel->getActiveSheet()->getStyle("A4:AJ$border")->applyFromArray($styleArray);
        
        if($dept_desc == '' || $dept_desc == null){
            $filename = "OT Report-ALL DEPT-" . trim($date_selected) . "-" . date("Y/m/d") . ".xlt";
        } else {
            $filename = "OT Report-" . trim($dept_desc) . "-" . trim($date_selected) . "-" . date("Y/m/d") . ".xlt";
        }
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
