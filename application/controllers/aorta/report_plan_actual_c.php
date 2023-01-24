<?php

class report_plan_actual_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/report_m');
    }

    function index($periode = null, $id_dept = null, $id_section = null, $id_subsect = null) {
        $this->role_module_m->authorization('165');

        $data['title'] = 'Report Overtime';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(228);

        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/report_plan_actual_v';

        if ($periode == null) {
            $selected_date = date("Ym");
        } else {
            $selected_date = $periode;
        }
        
        if ($id_section == null || $id_section == 'ALL') {
            $id_section = '';
        }
        
        if ($id_subsect == null || $id_subsect == 'ALL') {
            $id_subsect = '';
        }
        
        $data['holiday'] = $this->report_m->get_holiday($selected_date);

        if ($this->session->userdata('ROLE') == 1 || $this->session->userdata('NPK') == '0483' || $this->session->userdata('NPK') == '0483a') { // Admin
            if($id_dept != NULL){
                $id_dept = $id_dept;                
            } else {
                $id_dept = $this->session->userdata('DEPT');
            }
            
            $row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_karyawan = $this->report_m->get_data_karyawan($id_dept, $id_section, $id_subsect);
            
        } else if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 6 ||  $this->session->userdata('ROLE') == 39 || $this->session->userdata('ROLE') == 45) { // Manager
            $id_dept = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_karyawan = $this->report_m->get_data_karyawan($id_dept, $id_section, $id_subsect);
            
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
            $data_karyawan = $this->report_m->get_data_karyawan($id_dept, $id_section, $id_subsect);
            
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
            $data_karyawan = $this->report_m->get_data_karyawan($id_dept, $id_section, $id_subsect);
        } else {
            $id_dept = $this->session->userdata('DEPT');
            if($id_dept == '24'){
                $id_dept = '23';
            }
            $row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_karyawan = $this->report_m->get_data_karyawan($id_dept, $id_section, $id_subsect);
        }
        
        $data['all_dept'] = $all_dept; //List Dept
        $data['all_work_centers'] = $all_work_centers; //List Section
        $data['all_lines'] = $all_lines; //List Sub section atau Line
        $data['all_karyawan'] = $data_karyawan; //List Karyawan
        
        $data['id_dept'] = $id_dept;
        $data['id_section'] = $id_section;
        $data['id_subsect'] = $id_subsect;
        $data['selected_date'] = $selected_date;
        $data['role'] = $this->session->userdata('ROLE');
        $data['npk'] = $this->session->userdata('NPK');
        $this->load->view($this->layout, $data);
    }

    function export_ot_plan_actual() {
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
        
        $dept_desc = trim($this->report_m->replacer_dept($dept_selected));
              
        $list_karyawan = $this->report_m->get_data_karyawan($dept_selected, $sect_selected, $subsect_selected);      
                
        $year_only = substr($date_selected, 0, 4);
        $month_only = substr($date_selected, 4, 2); 
                        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/aorta/report/Template_Report_Plan_vs_Actual.xls");
        
        $row = 8;
        $seq = 1;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('PLAN VS ACTUAL');
        $active_sheet->setCellValue("B2", "REPORT OVERTIME PLAN VS ACTUAL : " . strtoupper(date("F", mktime(null, null, null, $month_only))) . " " . $year_only);
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $dept_desc);
        $active_sheet->setCellValue("B4", "Print Date : " . date('d-m-Y') . " " . date("H:i:s"));
        
        foreach ($list_karyawan as $kry) {            
            $active_sheet->setCellValue("B$row", "$seq");
            $active_sheet->setCellValue("C$row", "$kry->NPK");
            $active_sheet->setCellValue("D$row", "$kry->NAMA");
            $active_sheet->setCellValue("E$row", "$kry->KD_SECTION");
            $active_sheet->setCellValue("F$row", "$kry->KD_SUB_SECTION");
            
            $ot = $aortadb->query("EXEC zsp_get_overtime_plan_vs_actual '$date_selected', '$kry->NPK', '$kry->KD_DEPT', '$kry->KD_SECTION', ''")->row();               
            
            if(count($ot) != 0){
                $active_sheet->setCellValue("G$row", number_format($ot->PLAN_01/60,2,'.',','));
                $active_sheet->setCellValue("H$row", number_format($ot->HOUR_01/60,2,'.',','));
                $active_sheet->setCellValue("I$row", number_format($ot->PLAN_02/60,2,'.',','));
                $active_sheet->setCellValue("J$row", number_format($ot->HOUR_02/60,2,'.',','));
                $active_sheet->setCellValue("K$row", number_format($ot->PLAN_03/60,2,'.',','));
                $active_sheet->setCellValue("L$row", number_format($ot->HOUR_03/60,2,'.',','));
                $active_sheet->setCellValue("M$row", number_format($ot->PLAN_04/60,2,'.',','));
                $active_sheet->setCellValue("N$row", number_format($ot->HOUR_04/60,2,'.',','));
                $active_sheet->setCellValue("O$row", number_format($ot->PLAN_05/60,2,'.',','));
                $active_sheet->setCellValue("P$row", number_format($ot->HOUR_05/60,2,'.',','));
                $active_sheet->setCellValue("Q$row", number_format($ot->PLAN_06/60,2,'.',','));
                $active_sheet->setCellValue("R$row", number_format($ot->HOUR_06/60,2,'.',','));
                $active_sheet->setCellValue("S$row", number_format($ot->PLAN_07/60,2,'.',','));
                $active_sheet->setCellValue("T$row", number_format($ot->HOUR_07/60,2,'.',','));
                $active_sheet->setCellValue("U$row", number_format($ot->PLAN_08/60,2,'.',','));
                $active_sheet->setCellValue("V$row", number_format($ot->HOUR_08/60,2,'.',','));
                $active_sheet->setCellValue("W$row", number_format($ot->PLAN_09/60,2,'.',','));
                $active_sheet->setCellValue("X$row", number_format($ot->HOUR_09/60,2,'.',','));
                $active_sheet->setCellValue("Y$row", number_format($ot->PLAN_10/60,2,'.',','));
                $active_sheet->setCellValue("Z$row", number_format($ot->HOUR_10/60,2,'.',','));
                $active_sheet->setCellValue("AA$row", number_format($ot->PLAN_11/60,2,'.',','));
                $active_sheet->setCellValue("AB$row", number_format($ot->HOUR_11/60,2,'.',','));
                $active_sheet->setCellValue("AC$row", number_format($ot->PLAN_12/60,2,'.',','));
                $active_sheet->setCellValue("AD$row", number_format($ot->HOUR_12/60,2,'.',','));
                $active_sheet->setCellValue("AE$row", number_format($ot->PLAN_13/60,2,'.',','));
                $active_sheet->setCellValue("AF$row", number_format($ot->HOUR_13/60,2,'.',','));
                $active_sheet->setCellValue("AG$row", number_format($ot->PLAN_14/60,2,'.',','));
                $active_sheet->setCellValue("AH$row", number_format($ot->HOUR_14/60,2,'.',','));
                $active_sheet->setCellValue("AI$row", number_format($ot->PLAN_15/60,2,'.',','));
                $active_sheet->setCellValue("AJ$row", number_format($ot->HOUR_15/60,2,'.',','));
                $active_sheet->setCellValue("AK$row", number_format($ot->PLAN_16/60,2,'.',','));
                $active_sheet->setCellValue("AL$row", number_format($ot->HOUR_16/60,2,'.',','));
                $active_sheet->setCellValue("AM$row", number_format($ot->PLAN_17/60,2,'.',','));
                $active_sheet->setCellValue("AN$row", number_format($ot->HOUR_17/60,2,'.',','));
                $active_sheet->setCellValue("AO$row", number_format($ot->PLAN_18/60,2,'.',','));
                $active_sheet->setCellValue("AP$row", number_format($ot->HOUR_18/60,2,'.',','));
                $active_sheet->setCellValue("AQ$row", number_format($ot->PLAN_19/60,2,'.',','));
                $active_sheet->setCellValue("AR$row", number_format($ot->HOUR_19/60,2,'.',','));
                $active_sheet->setCellValue("AS$row", number_format($ot->PLAN_20/60,2,'.',','));
                $active_sheet->setCellValue("AT$row", number_format($ot->HOUR_20/60,2,'.',','));
                $active_sheet->setCellValue("AU$row", number_format($ot->PLAN_21/60,2,'.',','));
                $active_sheet->setCellValue("AV$row", number_format($ot->HOUR_21/60,2,'.',','));
                $active_sheet->setCellValue("AW$row", number_format($ot->PLAN_22/60,2,'.',','));
                $active_sheet->setCellValue("AX$row", number_format($ot->HOUR_22/60,2,'.',','));
                $active_sheet->setCellValue("AY$row", number_format($ot->PLAN_23/60,2,'.',','));
                $active_sheet->setCellValue("AZ$row", number_format($ot->HOUR_23/60,2,'.',','));
                $active_sheet->setCellValue("BA$row", number_format($ot->PLAN_24/60,2,'.',','));
                $active_sheet->setCellValue("BB$row", number_format($ot->HOUR_24/60,2,'.',','));
                $active_sheet->setCellValue("BC$row", number_format($ot->PLAN_25/60,2,'.',','));
                $active_sheet->setCellValue("BD$row", number_format($ot->HOUR_25/60,2,'.',','));
                $active_sheet->setCellValue("BE$row", number_format($ot->PLAN_26/60,2,'.',','));
                $active_sheet->setCellValue("BF$row", number_format($ot->HOUR_26/60,2,'.',','));
                $active_sheet->setCellValue("BG$row", number_format($ot->PLAN_27/60,2,'.',','));
                $active_sheet->setCellValue("BH$row", number_format($ot->HOUR_27/60,2,'.',','));
                $active_sheet->setCellValue("BI$row", number_format($ot->PLAN_28/60,2,'.',','));
                $active_sheet->setCellValue("BJ$row", number_format($ot->HOUR_28/60,2,'.',','));
                $active_sheet->setCellValue("BK$row", number_format($ot->PLAN_29/60,2,'.',','));
                $active_sheet->setCellValue("BL$row", number_format($ot->HOUR_29/60,2,'.',','));
                $active_sheet->setCellValue("BM$row", number_format($ot->PLAN_30/60,2,'.',','));
                $active_sheet->setCellValue("BN$row", number_format($ot->HOUR_30/60,2,'.',','));
                $active_sheet->setCellValue("BO$row", number_format($ot->PLAN_31/60,2,'.',','));
                $active_sheet->setCellValue("BP$row", number_format($ot->HOUR_31/60,2,'.',','));
                $active_sheet->setCellValue("BQ$row", number_format($ot->TOT_PLAN/60,2,'.',','));
                $active_sheet->setCellValue("BR$row", number_format($ot->TOT_HOUR/60,2,'.',','));
            } else {
                $active_sheet->setCellValue("G$row", "0");
                $active_sheet->setCellValue("H$row", "0");
                $active_sheet->setCellValue("I$row", "0");
                $active_sheet->setCellValue("J$row", "0");
                $active_sheet->setCellValue("K$row", "0");
                $active_sheet->setCellValue("L$row", "0");
                $active_sheet->setCellValue("M$row", "0");
                $active_sheet->setCellValue("N$row", "0");
                $active_sheet->setCellValue("O$row", "0");
                $active_sheet->setCellValue("P$row", "0");
                $active_sheet->setCellValue("Q$row", "0");
                $active_sheet->setCellValue("R$row", "0");
                $active_sheet->setCellValue("S$row", "0");
                $active_sheet->setCellValue("T$row", "0");
                $active_sheet->setCellValue("U$row", "0");
                $active_sheet->setCellValue("V$row", "0");
                $active_sheet->setCellValue("W$row", "0");
                $active_sheet->setCellValue("X$row", "0");
                $active_sheet->setCellValue("Y$row", "0");
                $active_sheet->setCellValue("Z$row", "0");
                $active_sheet->setCellValue("AA$row", "0");
                $active_sheet->setCellValue("AB$row", "0");
                $active_sheet->setCellValue("AC$row", "0");
                $active_sheet->setCellValue("AD$row", "0");
                $active_sheet->setCellValue("AE$row", "0");
                $active_sheet->setCellValue("AF$row", "0");
                $active_sheet->setCellValue("AG$row", "0");
                $active_sheet->setCellValue("AH$row", "0");
                $active_sheet->setCellValue("AI$row", "0");
                $active_sheet->setCellValue("AJ$row", "0");
                $active_sheet->setCellValue("AK$row", "0");
                $active_sheet->setCellValue("AL$row", "0");
                $active_sheet->setCellValue("AM$row", "0");
                $active_sheet->setCellValue("AN$row", "0");
                $active_sheet->setCellValue("AO$row", "0");
                $active_sheet->setCellValue("AP$row", "0");
                $active_sheet->setCellValue("AQ$row", "0");
                $active_sheet->setCellValue("AR$row", "0");
                $active_sheet->setCellValue("AS$row", "0");
                $active_sheet->setCellValue("AT$row", "0");
                $active_sheet->setCellValue("AU$row", "0");
                $active_sheet->setCellValue("AV$row", "0");
                $active_sheet->setCellValue("AW$row", "0");
                $active_sheet->setCellValue("AX$row", "0");
                $active_sheet->setCellValue("AY$row", "0");
                $active_sheet->setCellValue("AZ$row", "0");
                $active_sheet->setCellValue("BA$row", "0");
                $active_sheet->setCellValue("BB$row", "0");
                $active_sheet->setCellValue("BC$row", "0");
                $active_sheet->setCellValue("BD$row", "0");
                $active_sheet->setCellValue("BE$row", "0");
                $active_sheet->setCellValue("BF$row", "0");
                $active_sheet->setCellValue("BG$row", "0");
                $active_sheet->setCellValue("BH$row", "0");
                $active_sheet->setCellValue("BI$row", "0");
                $active_sheet->setCellValue("BJ$row", "0");
                $active_sheet->setCellValue("BK$row", "0");
                $active_sheet->setCellValue("BL$row", "0");
                $active_sheet->setCellValue("BM$row", "0");
                $active_sheet->setCellValue("BN$row", "0");
                $active_sheet->setCellValue("BO$row", "0");
                $active_sheet->setCellValue("BP$row", "0");
                $active_sheet->setCellValue("BQ$row", "0");
                $active_sheet->setCellValue("BR$row", "0");
            }
            
            $seq++;
            $row++;
        }

        $active_sheet->getStyle("B8:BR$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $row_min = $row - 1;
        $active_sheet->setCellValue("G$row", "=SUM(G8:G$row_min)");
        $active_sheet->setCellValue("H$row", "=SUM(H8:H$row_min)");
        $active_sheet->setCellValue("I$row", "=SUM(I8:I$row_min)");
        $active_sheet->setCellValue("J$row", "=SUM(J8:J$row_min)");
        $active_sheet->setCellValue("K$row", "=SUM(K8:K$row_min)");
        $active_sheet->setCellValue("L$row", "=SUM(L8:L$row_min)");
        $active_sheet->setCellValue("M$row", "=SUM(M8:M$row_min)");
        $active_sheet->setCellValue("N$row", "=SUM(N8:N$row_min)");
        $active_sheet->setCellValue("O$row", "=SUM(O8:O$row_min)");
        $active_sheet->setCellValue("P$row", "=SUM(P8:P$row_min)");
        $active_sheet->setCellValue("Q$row", "=SUM(Q8:Q$row_min)");
        $active_sheet->setCellValue("R$row", "=SUM(R8:R$row_min)");
        $active_sheet->setCellValue("S$row", "=SUM(S8:S$row_min)");
        $active_sheet->setCellValue("T$row", "=SUM(T8:T$row_min)");
        $active_sheet->setCellValue("U$row", "=SUM(U8:U$row_min)");
        $active_sheet->setCellValue("V$row", "=SUM(V8:V$row_min)");
        $active_sheet->setCellValue("W$row", "=SUM(W8:W$row_min)");
        $active_sheet->setCellValue("X$row", "=SUM(X8:X$row_min)");
        $active_sheet->setCellValue("Y$row", "=SUM(Y8:Y$row_min)");
        $active_sheet->setCellValue("Z$row", "=SUM(Z8:Z$row_min)");
        $active_sheet->setCellValue("AA$row", "=SUM(AA8:AA$row_min)");
        $active_sheet->setCellValue("AB$row", "=SUM(AB8:AB$row_min)");
        $active_sheet->setCellValue("AC$row", "=SUM(AC8:AC$row_min)");
        $active_sheet->setCellValue("AD$row", "=SUM(AD8:AD$row_min)");
        $active_sheet->setCellValue("AE$row", "=SUM(AE8:AE$row_min)");
        $active_sheet->setCellValue("AF$row", "=SUM(AF8:AF$row_min)");
        $active_sheet->setCellValue("AG$row", "=SUM(AG8:AG$row_min)");
        $active_sheet->setCellValue("AH$row", "=SUM(AH8:AH$row_min)");
        $active_sheet->setCellValue("AI$row", "=SUM(AI8:AI$row_min)");
        $active_sheet->setCellValue("AJ$row", "=SUM(AJ8:AJ$row_min)");
        $active_sheet->setCellValue("AK$row", "=SUM(AK8:AK$row_min)");
        $active_sheet->setCellValue("AL$row", "=SUM(AL8:AL$row_min)");
        $active_sheet->setCellValue("AM$row", "=SUM(AM8:AM$row_min)");
        $active_sheet->setCellValue("AN$row", "=SUM(AN8:AN$row_min)");
        $active_sheet->setCellValue("AO$row", "=SUM(AO8:AO$row_min)");
        $active_sheet->setCellValue("AP$row", "=SUM(AP8:AP$row_min)");
        $active_sheet->setCellValue("AQ$row", "=SUM(AQ8:AQ$row_min)");
        $active_sheet->setCellValue("AR$row", "=SUM(AR8:AR$row_min)");
        $active_sheet->setCellValue("AS$row", "=SUM(AS8:AS$row_min)");
        $active_sheet->setCellValue("AT$row", "=SUM(AT8:AT$row_min)");
        $active_sheet->setCellValue("AU$row", "=SUM(AU8:AU$row_min)");
        $active_sheet->setCellValue("AV$row", "=SUM(AV8:AV$row_min)");
        $active_sheet->setCellValue("AW$row", "=SUM(AW8:AW$row_min)");
        $active_sheet->setCellValue("AX$row", "=SUM(AX8:AX$row_min)");
        $active_sheet->setCellValue("AY$row", "=SUM(AY8:AY$row_min)");
        $active_sheet->setCellValue("AZ$row", "=SUM(AZ8:AZ$row_min)");
        $active_sheet->setCellValue("BA$row", "=SUM(BA8:BA$row_min)");
        $active_sheet->setCellValue("BB$row", "=SUM(BB8:BB$row_min)");
        $active_sheet->setCellValue("BC$row", "=SUM(BC8:BC$row_min)");
        $active_sheet->setCellValue("BD$row", "=SUM(BD8:BD$row_min)");
        $active_sheet->setCellValue("BE$row", "=SUM(BE8:BE$row_min)");
        $active_sheet->setCellValue("BF$row", "=SUM(BF8:BF$row_min)");
        $active_sheet->setCellValue("BG$row", "=SUM(BG8:BG$row_min)");
        $active_sheet->setCellValue("BH$row", "=SUM(BH8:BH$row_min)");
        $active_sheet->setCellValue("BI$row", "=SUM(BI8:BI$row_min)");
        $active_sheet->setCellValue("BJ$row", "=SUM(BJ8:BJ$row_min)");
        $active_sheet->setCellValue("BK$row", "=SUM(BK8:BK$row_min)");
        $active_sheet->setCellValue("BL$row", "=SUM(BL8:BL$row_min)");
        $active_sheet->setCellValue("BM$row", "=SUM(BM8:BM$row_min)");
        $active_sheet->setCellValue("BN$row", "=SUM(BN8:BN$row_min)");
        $active_sheet->setCellValue("BO$row", "=SUM(BO8:BO$row_min)");
        $active_sheet->setCellValue("BP$row", "=SUM(BP8:BP$row_min)");
        $active_sheet->setCellValue("BQ$row", "=SUM(BQ8:BQ$row_min)");
        $active_sheet->setCellValue("BR$row", "=SUM(BR8:BR$row_min)");
        
        $active_sheet->mergeCells("B$row:F$row");
        $active_sheet->setCellValue("B$row", "TOTAL");
        $active_sheet->getStyle("B$row:BR$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $active_sheet->getStyle("B$row:BR$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));
        
        ob_end_clean();
        $filename = "Report OT Plan vs Actual - $dept_desc - $date_selected.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
