<?php

class report_overtime_weekly_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/report_m');
    }

    function index($selected_date = null, $id_dept = null, $id_section = null, $id_subsect = null) {
        $this->role_module_m->authorization('165');
        $this->session->userdata('user_id');

        $data['title'] = 'Report Overtime';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(231);

        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/report_overtime_weekly_v';

        if ($selected_date == null) {
            $selected_date = date("Ym");
        } else {
            $selected_date = $selected_date;
        }
        
        if ($id_section == null || $id_section == 'ALL') {
            $id_section = '';
        }
        
        if ($id_subsect == null || $id_subsect == 'ALL') {
            $id_subsect = '';
        }
        
        //first monday in month selected
        $month = substr($selected_date, 0, 4) . '-' .substr($selected_date, 4, 2);
        $first_monday = date("Ymd", strtotime("first monday $month"));
        
        //start_date and end_date
        //week 0
        $start_date0 = date('Ymd', strtotime('-7 day', strtotime($first_monday)));
        $end_date0 = date('Ymd', strtotime('-1 day', strtotime($first_monday)));
        //week 1
        $start_date1 = $first_monday;
        $end_date1 = date('Ymd', strtotime('+7 day', strtotime($first_monday)));
        //week 2
        $start_date2 = date('Ymd', strtotime('+8 day', strtotime($first_monday)));
        $end_date2 = date('Ymd', strtotime('+14 day', strtotime($first_monday)));
        //week 3
        $start_date3 = date('Ymd', strtotime('+15 day', strtotime($first_monday)));
        $end_date3 = date('Ymd', strtotime('+21 day', strtotime($first_monday)));
        //week 4
        $start_date4 = date('Ymd', strtotime('+22 day', strtotime($first_monday)));
        $end_date4 = date('Ymd', strtotime('+28 day', strtotime($first_monday)));
        //week 5
        $start_date5 = date('Ymd', strtotime('+29 day', strtotime($first_monday)));
        $end_date5 = date('Ymd', strtotime('+35 day', strtotime($first_monday)));

        if ($this->session->userdata('ROLE') == 1 || $this->session->userdata('NPK') == '0483' || $this->session->userdata('NPK') == '0483a') { // Admin
            if($id_dept != NULL){
                $id_dept = $id_dept;
            } else {
                $id_dept = $this->session->userdata('DEPT');
            }
            
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $dept_ot = $this->report_m->get_dept_ot($selected_date, $id_dept, $id_section, $id_subsect); 
            
        } else if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 39 || $this->session->userdata('ROLE') == 45) { // Manager
            $id_dept = $this->session->userdata('DEPT');
            
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $dept_ot = $this->report_m->get_dept_ot($selected_date, $id_dept, $id_section, $id_subsect); 
            
        } else if ($this->session->userdata('ROLE') == 4) { //GM
            $id_group = $this->session->userdata('GROUPDEPT');
            $all_dept = $this->dept_m->get_dept_by_groupdept($id_group);
            
            if($id_dept != NULL){
                $id_dept = $id_dept;
            } else {
                $id_dept = $all_dept[0]->INT_ID_DEPT;                
            }            
            
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $dept_ot = $this->report_m->get_dept_ot($selected_date, $id_dept, $id_section, $id_subsect); 
            
        } else if ($this->session->userdata('ROLE') == 3){ //Director          
            $id_div = $this->session->userdata('DIVISION');            
            $all_dept = $this->dept_m->get_dept_by_division($id_div);
            
            if($id_dept != NULL){
                $id_dept = $id_dept;
            } else {
                $id_dept = $all_dept[0]->INT_ID_DEPT;                
            } 
            
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $dept_ot = $this->report_m->get_dept_ot($selected_date, $id_dept, $id_section, $id_subsect); 
        } else {
            $id_dept = $this->session->userdata('DEPT');
            
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $dept_ot = $this->report_m->get_dept_ot($selected_date, $id_dept, $id_section, $id_subsect);
        }
        
        $data['all_dept'] = $all_dept; //List Dept
        $data['all_work_centers'] = $all_work_centers; //List Section
        $data['all_lines'] = $all_lines; //List Sub section atau Line
        $data['dept_ot'] = $dept_ot; //List Sub section atau Line
        
        //start date and end date
        $data['start_date0'] = $start_date0;
        $data['end_date0'] = $end_date0;
        $data['start_date1'] = $start_date1;
        $data['end_date1'] = $end_date1;
        $data['start_date2'] = $start_date2;
        $data['end_date2'] = $end_date2;
        $data['start_date3'] = $start_date3;
        $data['end_date3'] = $end_date3;
        $data['start_date4'] = $start_date4;
        $data['end_date4'] = $end_date4;
        $data['start_date5'] = $start_date5;
        $data['end_date5'] = $end_date5;
        
        $data['id_dept'] = $id_dept;
        $data['kd_dept'] = $this->report_m->replacer_dept($id_dept);
        $data['id_section'] = $id_section;
        $data['id_subsect'] = $id_subsect;
        $data['selected_date'] = $selected_date;
        
        $data['role'] = $this->session->userdata('ROLE');
        $data['npk'] = $this->session->userdata('NPK');
        $this->load->view($this->layout, $data);
    }

    function export_ot_weekly() {
        $aortadb = $this->load->database("aorta", TRUE);
        
        $date_selected = $this->input->post('CHR_DATE_SELECTED');
        $dept_selected = $this->input->post('CHR_DEPT_SELECTED');
        $sect_selected = $this->input->post('CHR_SECTION_SELECTED');
        if($sect_selected == NULL || $sect_selected == 'ALL'){
            $sect_selected = '';
        }
        $subsect_selected = $this->input->post('CHR_SUBSECTION_SELECTED');
        if($subsect_selected == NULL || $subsect_selected == 'ALL'){
            $subsect_selected = '';
        }
        
        //first monday in month selected
        $month = substr($date_selected, 0, 4) . '-' .substr($date_selected, 4, 2);
        $first_monday = date("Ymd", strtotime("first monday $month"));
        
        //start_date and end_date
        //week 0
        $start_date0 = date('Ymd', strtotime('-7 day', strtotime($first_monday)));
        $end_date0 = date('Ymd', strtotime('-1 day', strtotime($first_monday)));
        //week 1
        $start_date1 = $first_monday;
        $end_date1 = date('Ymd', strtotime('+7 day', strtotime($first_monday)));
        //week 2
        $start_date2 = date('Ymd', strtotime('+8 day', strtotime($first_monday)));
        $end_date2 = date('Ymd', strtotime('+14 day', strtotime($first_monday)));
        //week 3
        $start_date3 = date('Ymd', strtotime('+15 day', strtotime($first_monday)));
        $end_date3 = date('Ymd', strtotime('+21 day', strtotime($first_monday)));
        //week 4
        $start_date4 = date('Ymd', strtotime('+22 day', strtotime($first_monday)));
        $end_date4 = date('Ymd', strtotime('+28 day', strtotime($first_monday)));
        //week 5
        $start_date5 = date('Ymd', strtotime('+29 day', strtotime($first_monday)));
        $end_date5 = date('Ymd', strtotime('+35 day', strtotime($first_monday)));
        
        $dept_desc = trim($this->report_m->replacer_dept($dept_selected));
              
        $dept_ot = $this->report_m->get_dept_ot($date_selected, $dept_selected, $sect_selected, $subsect_selected);      
                               
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/aorta/report/Template_Report_Weekly_OT.xls");
        
        $row = 8;
        $seq = 1;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('WEEKLY_OT');
        $active_sheet->setCellValue("B2", "REPORT OVERTIME WEEKLY : " . strtoupper(date("F", mktime(null, null, null, substr($date_selected, 4, 2)))) . " " . substr($date_selected, 0, 4));
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $dept_desc);
        $active_sheet->setCellValue("B4", "Print Date : " . date('d-m-Y') . " " . date("H:i:s"));
        
        $active_sheet->setCellValue("I5", strtoupper(date("F", mktime(null, null, null, substr($date_selected, 4, 2)))) . " " . substr($date_selected, 0, 4));
        $active_sheet->setCellValue("F6", "(" . date('Y/m/d', strtotime($start_date0)) . " - " . date('Y/m/d', strtotime($end_date0)) . ")");
        $active_sheet->setCellValue("I6", "WEEK 1 (" . date('Y/m/d', strtotime($start_date1)) . " - " . date('Y/m/d', strtotime($end_date1)) . ")");
        $active_sheet->setCellValue("L6", "WEEK 2 (" . date('Y/m/d', strtotime($start_date2)) . " - " . date('Y/m/d', strtotime($end_date2)) . ")");
        $active_sheet->setCellValue("O6", "WEEK 3 (" . date('Y/m/d', strtotime($start_date3)) . " - " . date('Y/m/d', strtotime($end_date3)) . ")");
        $active_sheet->setCellValue("R6", "WEEK 4 (" . date('Y/m/d', strtotime($start_date4)) . " - " . date('Y/m/d', strtotime($end_date4)) . ")");
        $active_sheet->setCellValue("U6", "(" . date('Y/m/d', strtotime($start_date5)) . " - " . date('Y/m/d', strtotime($end_date5)) . ")");
        
        foreach ($dept_ot as $data) {            
            $active_sheet->setCellValue("B$row", "$seq");
            $active_sheet->setCellValue("C$row", "$data->KD_DEPT");
            $active_sheet->setCellValue("D$row", "$data->KD_SECTION");
            $active_sheet->setCellValue("E$row", "$data->KD_SUB_SECTION");
            
            //week 0
            $week0 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date0', '$end_date0', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
            if(count($week0) != 0){
                $active_sheet->setCellValue("F$row", number_format($week0->MP_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("G$row", number_format($week0->OT_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("H$row", number_format($week0->MH_PER_DAY,2,'.',','));               
            } else {
                $active_sheet->setCellValue("F$row", "0");
                $active_sheet->setCellValue("G$row", "0");
                $active_sheet->setCellValue("H$row", "0");
            }
            
            //week 1
            $week1 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date1', '$end_date1', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
            if(count($week1) != 0){
                $active_sheet->setCellValue("I$row", number_format($week1->MP_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("J$row", number_format($week1->OT_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("K$row", number_format($week1->MH_PER_DAY,2,'.',','));               
            } else {
                $active_sheet->setCellValue("I$row", "0");
                $active_sheet->setCellValue("J$row", "0");
                $active_sheet->setCellValue("K$row", "0");
            }
            
            //week 2
            $week2 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date2', '$end_date2', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
            if(count($week2) != 0){
                $active_sheet->setCellValue("L$row", number_format($week2->MP_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("M$row", number_format($week2->OT_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("N$row", number_format($week2->MH_PER_DAY,2,'.',','));               
            } else {
                $active_sheet->setCellValue("L$row", "0");
                $active_sheet->setCellValue("M$row", "0");
                $active_sheet->setCellValue("N$row", "0");
            }
            
            //week 3
            $week3 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date3', '$end_date3', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
            if(count($week3) != 0){
                $active_sheet->setCellValue("O$row", number_format($week3->MP_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("P$row", number_format($week3->OT_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("Q$row", number_format($week3->MH_PER_DAY,2,'.',','));               
            } else {
                $active_sheet->setCellValue("O$row", "0");
                $active_sheet->setCellValue("P$row", "0");
                $active_sheet->setCellValue("Q$row", "0");
            }
            
            //week 4
            $week4 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date4', '$end_date4', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
            if(count($week4) != 0){
                $active_sheet->setCellValue("R$row", number_format($week4->MP_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("S$row", number_format($week4->OT_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("T$row", number_format($week4->MH_PER_DAY,2,'.',','));               
            } else {
                $active_sheet->setCellValue("R$row", "0");
                $active_sheet->setCellValue("S$row", "0");
                $active_sheet->setCellValue("T$row", "0");
            }
            
            //week 5
            $week5 = $aortadb->query("EXEC zsp_get_overtime_weekly '$start_date5', '$end_date5', '$data->KD_DEPT%', '$data->KD_SECTION%', '$data->KD_SUB_SECTION%'")->row();
            if(count($week5) != 0){
                $active_sheet->setCellValue("U$row", number_format($week5->MP_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("V$row", number_format($week5->OT_PER_DAY,2,'.',','));
                $active_sheet->setCellValue("W$row", number_format($week5->MH_PER_DAY,2,'.',','));               
            } else {
                $active_sheet->setCellValue("U$row", "0");
                $active_sheet->setCellValue("V$row", "0");
                $active_sheet->setCellValue("W$row", "0");
            }           
            
            $seq++;
            $row++;
        }

        $active_sheet->getStyle("B8:W$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $row_min = $row - 1;
        $active_sheet->setCellValue("F$row", "=AVERAGE(F8:F$row_min)");
        $active_sheet->setCellValue("G$row", "=AVERAGE(G8:G$row_min)");
        $active_sheet->setCellValue("H$row", "=AVERAGE(H8:H$row_min)");
        $active_sheet->setCellValue("I$row", "=AVERAGE(I8:I$row_min)");
        $active_sheet->setCellValue("J$row", "=AVERAGE(J8:J$row_min)");
        $active_sheet->setCellValue("K$row", "=AVERAGE(K8:K$row_min)");
        $active_sheet->setCellValue("L$row", "=AVERAGE(L8:L$row_min)");
        $active_sheet->setCellValue("M$row", "=AVERAGE(M8:M$row_min)");
        $active_sheet->setCellValue("N$row", "=AVERAGE(N8:N$row_min)");
        $active_sheet->setCellValue("O$row", "=AVERAGE(O8:O$row_min)");
        $active_sheet->setCellValue("P$row", "=AVERAGE(P8:P$row_min)");
        $active_sheet->setCellValue("Q$row", "=AVERAGE(Q8:Q$row_min)");
        $active_sheet->setCellValue("R$row", "=AVERAGE(R8:R$row_min)");
        $active_sheet->setCellValue("S$row", "=AVERAGE(S8:S$row_min)");
        $active_sheet->setCellValue("T$row", "=AVERAGE(T8:T$row_min)");
        $active_sheet->setCellValue("U$row", "=AVERAGE(U8:U$row_min)");
        $active_sheet->setCellValue("V$row", "=AVERAGE(V8:V$row_min)");
        $active_sheet->setCellValue("W$row", "=AVERAGE(W8:W$row_min)");
        
        $active_sheet->mergeCells("B$row:E$row");
        $active_sheet->setCellValue("B$row", "AVERAGE");
        $active_sheet->getStyle("B$row:W$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $active_sheet->getStyle("B$row:W$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));
        
        ob_end_clean();
        $filename = "Report Weekly OT - $dept_desc - $date_selected.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
