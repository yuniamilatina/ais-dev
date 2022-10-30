<?php

class report_summary_overtime_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/report_m');
    }

    function index($year = null, $id_dept = null, $id_section = null, $id_subsect = null) {
        $this->role_module_m->authorization('165');
        $this->session->userdata('user_id');

        $data['title'] = 'Report Overtime';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(229);

        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/report_summary_overtime_v';

        if ($year == null) {
            $year = date("Y");
        } else {
            $year = $year;
        }
        
        if ($id_section == null || $id_section == 'ALL') {
            $id_section = '';
        }
        
        if ($id_subsect == null || $id_subsect == 'ALL') {
            $id_subsect = '';
        }

        if ($this->session->userdata('ROLE') == 1 || $this->session->userdata('NPK') == '0483' || $this->session->userdata('NPK') == '0483a') { // Admin
            if($id_dept != NULL){
                $id_dept = $id_dept;
            } else {
                $id_dept = $this->session->userdata('DEPT');
            }
            
            //$row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_ot = $this->report_m->get_data_overtime($id_dept, $id_section, $id_subsect);
            
        } else if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 39 || $this->session->userdata('ROLE') == 45) { // Manager
            $id_dept = $this->session->userdata('DEPT');
            //$row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_ot = $this->report_m->get_data_overtime($id_dept, $id_section, $id_subsect);
            
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
            $data_ot = $this->report_m->get_data_overtime($id_dept, $id_section, $id_subsect);
            
        } else if ($this->session->userdata('ROLE') == 3 || $this->session->userdata('ROLE') == 100){ //Director          
            $id_div = $this->session->userdata('DIVISION');            
            $all_dept = $this->dept_m->get_dept_by_division($id_div);
            
            if($id_dept != NULL){
                $id_dept = $id_dept;
            } else {
                $id_dept = $all_dept[0]->INT_ID_DEPT;                
            } 
            
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_ot = $this->report_m->get_data_overtime($id_dept, $id_section, $id_subsect);
        } else {
            $id_dept = $this->session->userdata('DEPT');
            //$row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_ot = $this->report_m->get_data_overtime($id_dept, $id_section, $id_subsect);
        }
        
        $data['all_dept'] = $all_dept; //List Dept
        $data['all_work_centers'] = $all_work_centers; //List Section
        $data['all_lines'] = $all_lines; //List Sub section atau Line
        $data['all_overtime'] = $data_ot; //List OT
        
        $data['id_dept'] = $id_dept;
        $data['kd_dept'] = $this->report_m->replacer_dept($id_dept);
        $data['id_section'] = $id_section;
        $data['id_subsect'] = $id_subsect;
        $data['year'] = $year;
        $data['role'] = $this->session->userdata('ROLE');
        $data['npk'] = $this->session->userdata('NPK');
        $this->load->view($this->layout, $data);
    }
    
    public function get_data_perdate() {
        $aortadb = $this->load->database("aorta", TRUE);
        $year = trim($this->input->post('year_click'));
        $month = date('m', strtotime(trim($this->input->post('month_click'))));
        $month_name = trim($this->input->post('month_click'));
        $dept = trim($this->input->post('dept_click'));
        $sect = trim($this->input->post('sect_click'));
        $subsect = trim($this->input->post('subsect_click')); 
//        print_r($month);
//        exit();
        
        $data = "";
        $data .= "<script type='text/javascript'>";
        $data .= "var chart1; ";
        $data .= "$(document).ready(function () {";
        $data .= "chart1 = new Highcharts.Chart({";
        $data .= "chart: {renderTo: 'container', type: 'area', plotBorderWidth: 1},credits: {enabled: false},legend: {borderColor: '#cccccc',borderWidth: 1,borderRadius: 3},tooltip:{split: true,valueSuffix:''},";
        $data .= "title: {text: ''}, xAxis: {categories: ['1', '2', '3', '4', '5', '6','7', '8', '9', '10', '11', '12','13', '14', '15', '16', '17', '18','19', '20', '21', '22', '23', '24', '25', '26', '27','28', '29', '30', '31']},";
        $data .= "yAxis: {title: {text: 'Hour '}},series: [";
        $data .= "{name: 'PLAN OT (". $month_name .")',data: [";
        for ($x = 1; $x < 32; $x++) {
            $date = $year . $month . sprintf("%02d", $x);
            $ot_plan = $aortadb->query("SELECT SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE KD_DEPT = '$dept' AND KD_SECTION LIKE '$sect%' AND KD_SUB_SECTION LIKE '$subsect%' AND TGL_OVERTIME LIKE '$date%'")->row();
            if($x != 31){
                if($ot_plan->RENC_DURASI_OV_TIME == NULL){
                    $data .= '0,';
                } else {
                    $data .= $ot_plan->RENC_DURASI_OV_TIME . ',';
                }                
            } else {
                if($ot_plan->RENC_DURASI_OV_TIME == NULL){
                    $data .= '0';
                } else {
                    $data .= $ot_plan->RENC_DURASI_OV_TIME;
                }                
            }
        }
        $data .= "]},";
        $data .= "{name: 'REAL OT (". $month_name .")',data: [";
        for ($x = 1; $x < 32; $x++) {
            $date = $year . $month . sprintf("%02d", $x);
            $ot_real = $aortadb->query("SELECT SUM(CAST((CASE WHEN REAL_DURASI_OV_TIME = '' THEN 0 ELSE REAL_DURASI_OV_TIME END) AS DECIMAL(10,2)))/60 AS REAL_DURASI_OV_TIME FROM TT_KRY_OVERTIME WHERE KD_DEPT = '$dept' AND KD_SECTION LIKE '$sect%' AND KD_SUB_SECTION LIKE '$subsect%' AND TGL_OVERTIME LIKE '$date%'")->row();
            if($x != 31){
                if($ot_real->REAL_DURASI_OV_TIME == NULL){
                    $data .= '0,';
                } else {
                    $data .= $ot_real->REAL_DURASI_OV_TIME . ',';
                }                
            } else {
                if($ot_real->REAL_DURASI_OV_TIME == NULL){
                    $data .= '0';
                } else {
                    $data .= $ot_real->REAL_DURASI_OV_TIME; 
                }
            }
        }
        $data .= "]}";

        $data .= "] }); });</script>";

        echo $data;
    }

    function export_summary_ot() {
        $aortadb = $this->load->database("aorta", TRUE);
        
        $year_selected = $this->input->post('CHR_YEAR_SELECTED');
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
              
        $data_ot = $this->report_m->get_data_overtime($dept_selected, $sect_selected, $subsect_selected);      
                               
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object
        
        //$objPHPExcel = $objReader->load("assets/template/aorta/report/Template_Report_Summary_OT.xls");
        $objPHPExcel = $objReader->load("assets/template/aorta/report/Template_Report_Summary_OT_New.xls");
        
        $row = 8;
        $seq = 1;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('PLAN VS ACTUAL');
        $active_sheet->setCellValue("B2", "REPORT SUMMARY OVERTIME PLAN VS ACTUAL : " . $year_selected);
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $dept_desc);
        $active_sheet->setCellValue("B4", "Print Date : " . date('d-m-Y') . " " . date("H:i:s"));
        
        foreach ($data_ot as $data) {            
            $active_sheet->setCellValue("B$row", "$seq");
            $active_sheet->setCellValue("C$row", "$data->KD_SECTION");
            $active_sheet->setCellValue("D$row", "$data->KD_SUB_SECTION");
            
            $ot = $aortadb->query("EXEC zsp_get_summary_overtime_plan_vs_actual '$year_selected', '$data->KD_DEPT', '$data->KD_SECTION', '$data->KD_SUB_SECTION'")->row(); //actual
            $ot_plan = $aortadb->query("EXEC zsp_get_summary_overtime_plan_vs_actual_2 '$year_selected', '$data->KD_DEPT', '$data->KD_SECTION', '$data->KD_SUB_SECTION'")->row(); //plan
            
            if(count($ot_plan) != 0){
                // With NUMBER FORMAT
                // $active_sheet->setCellValue("E$row", number_format($ot_plan->PLAN_01,2,'.',','));
                // $active_sheet->setCellValue("G$row", number_format($ot_plan->PLAN_02,2,'.',','));
                // $active_sheet->setCellValue("I$row", number_format($ot_plan->PLAN_03,2,'.',','));
                // $active_sheet->setCellValue("K$row", number_format($ot_plan->PLAN_04,2,'.',','));
                // $active_sheet->setCellValue("M$row", number_format($ot_plan->PLAN_05,2,'.',','));
                // $active_sheet->setCellValue("O$row", number_format($ot_plan->PLAN_06,2,'.',','));
                // $active_sheet->setCellValue("Q$row", number_format($ot_plan->PLAN_07,2,'.',','));
                // $active_sheet->setCellValue("S$row", number_format($ot_plan->PLAN_08,2,'.',','));
                // $active_sheet->setCellValue("U$row", number_format($ot_plan->PLAN_09,2,'.',','));
                // $active_sheet->setCellValue("W$row", number_format($ot_plan->PLAN_10,2,'.',','));
                // $active_sheet->setCellValue("Y$row", number_format($ot_plan->PLAN_11,2,'.',','));
                // $active_sheet->setCellValue("AA$row", number_format($ot_plan->PLAN_12,2,'.',','));
                // $active_sheet->setCellValue("AC$row", number_format($ot_plan->TOT_PLAN,2,'.',','));

                //Without NUMBER FORMAT
                $active_sheet->setCellValue("E$row", $ot_plan->PLAN_01);
                $active_sheet->setCellValue("G$row", $ot_plan->PLAN_02);
                $active_sheet->setCellValue("I$row", $ot_plan->PLAN_03);
                $active_sheet->setCellValue("K$row", $ot_plan->PLAN_04);
                $active_sheet->setCellValue("M$row", $ot_plan->PLAN_05);
                $active_sheet->setCellValue("O$row", $ot_plan->PLAN_06);
                $active_sheet->setCellValue("Q$row", $ot_plan->PLAN_07);
                $active_sheet->setCellValue("S$row", $ot_plan->PLAN_08);
                $active_sheet->setCellValue("U$row", $ot_plan->PLAN_09);
                $active_sheet->setCellValue("W$row", $ot_plan->PLAN_10);
                $active_sheet->setCellValue("Y$row", $ot_plan->PLAN_11);
                $active_sheet->setCellValue("AA$row", $ot_plan->PLAN_12);
                $active_sheet->setCellValue("AC$row", $ot_plan->TOT_PLAN);
            } else {
                $active_sheet->setCellValue("E$row", "0");
                $active_sheet->setCellValue("G$row", "0");
                $active_sheet->setCellValue("I$row", "0");
                $active_sheet->setCellValue("K$row", "0");
                $active_sheet->setCellValue("M$row", "0");
                $active_sheet->setCellValue("O$row", "0");
                $active_sheet->setCellValue("Q$row", "0");
                $active_sheet->setCellValue("S$row", "0");
                $active_sheet->setCellValue("U$row", "0");
                $active_sheet->setCellValue("W$row", "0");
                $active_sheet->setCellValue("Y$row", "0");
                $active_sheet->setCellValue("AA$row", "0");
                $active_sheet->setCellValue("AC$row", "0");
            }
            
            if(count($ot) != 0){
                // With NUMBER FORMAT
                // $active_sheet->setCellValue("F$row", number_format($ot->HOUR_01,2,'.',','));
                // $active_sheet->setCellValue("H$row", number_format($ot->HOUR_02,2,'.',','));
                // $active_sheet->setCellValue("J$row", number_format($ot->HOUR_03,2,'.',','));
                // $active_sheet->setCellValue("L$row", number_format($ot->HOUR_04,2,'.',','));
                // $active_sheet->setCellValue("N$row", number_format($ot->HOUR_05,2,'.',','));
                // $active_sheet->setCellValue("P$row", number_format($ot->HOUR_06,2,'.',','));
                // $active_sheet->setCellValue("R$row", number_format($ot->HOUR_07,2,'.',','));
                // $active_sheet->setCellValue("T$row", number_format($ot->HOUR_08,2,'.',','));
                // $active_sheet->setCellValue("V$row", number_format($ot->HOUR_09,2,'.',','));
                // $active_sheet->setCellValue("X$row", number_format($ot->HOUR_10,2,'.',','));
                // $active_sheet->setCellValue("Z$row", number_format($ot->HOUR_11,2,'.',','));
                // $active_sheet->setCellValue("AB$row", number_format($ot->HOUR_12,2,'.',','));
                // $active_sheet->setCellValue("AD$row", number_format($ot->TOT_HOUR,2,'.',','));

                // Without NUMBER FORMAT
                $active_sheet->setCellValue("F$row", $ot->HOUR_01);
                $active_sheet->setCellValue("H$row", $ot->HOUR_02);
                $active_sheet->setCellValue("J$row", $ot->HOUR_03);
                $active_sheet->setCellValue("L$row", $ot->HOUR_04);
                $active_sheet->setCellValue("N$row", $ot->HOUR_05);
                $active_sheet->setCellValue("P$row", $ot->HOUR_06);
                $active_sheet->setCellValue("R$row", $ot->HOUR_07);
                $active_sheet->setCellValue("T$row", $ot->HOUR_08);
                $active_sheet->setCellValue("V$row", $ot->HOUR_09);
                $active_sheet->setCellValue("X$row", $ot->HOUR_10);
                $active_sheet->setCellValue("Z$row", $ot->HOUR_11);
                $active_sheet->setCellValue("AB$row", $ot->HOUR_12);
                $active_sheet->setCellValue("AD$row", $ot->TOT_HOUR);
            } else {
                $active_sheet->setCellValue("F$row", "0");
                $active_sheet->setCellValue("H$row", "0");
                $active_sheet->setCellValue("J$row", "0");
                $active_sheet->setCellValue("L$row", "0");
                $active_sheet->setCellValue("N$row", "0");
                $active_sheet->setCellValue("P$row", "0");
                $active_sheet->setCellValue("R$row", "0");
                $active_sheet->setCellValue("T$row", "0");
                $active_sheet->setCellValue("V$row", "0");
                $active_sheet->setCellValue("X$row", "0");
                $active_sheet->setCellValue("Z$row", "0");
                $active_sheet->setCellValue("AB$row", "0");
                $active_sheet->setCellValue("AD$row", "0");
            }
            
            $seq++;
            $row++;
        }

        $active_sheet->getStyle("B8:AD$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $row_min = $row - 1;
        $active_sheet->setCellValue("E$row", "=SUM(E8:E$row_min)");
        $active_sheet->setCellValue("F$row", "=SUM(F8:F$row_min)");
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
        
        $active_sheet->mergeCells("B$row:D$row");
        $active_sheet->setCellValue("B$row", "TOTAL");
        $active_sheet->getStyle("B$row:AD$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $active_sheet->getStyle("B$row:AD$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));
        
        ob_end_clean();
        $filename = "Report Summary OT Plan vs Actual - $dept_desc - $year_selected.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
