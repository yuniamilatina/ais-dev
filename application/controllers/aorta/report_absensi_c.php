<?php

class report_absensi_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/report_m');
    }

    function index($periode = null, $day = null, $id_dept = null, $id_section = null, $id_subsect = null) {
        $this->role_module_m->authorization('165');
        $this->session->userdata('user_id');

        $data['title'] = 'Report Overtime';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(232);

        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/report_absensi_v';

        if ($periode == null) {
            $periode = date("Ym");     
        }
        
        if ($day == null) {
            $day = date("d");            
        }
        
        $selected_date = $periode.$day;
        
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
            $data_absen = $this->report_m->get_data_absensi($selected_date, $id_dept, $id_section, $id_subsect);
            
        } else if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 39 || $this->session->userdata('ROLE') == 45) { // Manager
            $id_dept = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_absen = $this->report_m->get_data_absensi($selected_date, $id_dept, $id_section, $id_subsect);
            
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
            $data_absen = $this->report_m->get_data_absensi($selected_date, $id_dept, $id_section, $id_subsect);
            
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
            $data_absen = $this->report_m->get_data_absensi($selected_date, $id_dept, $id_section, $id_subsect);
        } else {
            $id_dept = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_absen = $this->report_m->get_data_absensi($selected_date, $id_dept, $id_section, $id_subsect);
        }
        
        $data['all_dept'] = $all_dept; //List Dept
        $data['all_work_centers'] = $all_work_centers; //List Section
        $data['all_lines'] = $all_lines; //List Sub section atau Line
        $data['absensi_ot'] = $data_absen; //List Karyawan
        
        $data['id_dept'] = $id_dept;
        $data['id_section'] = $id_section;
        $data['id_subsect'] = $id_subsect;
        $data['periode'] = $periode;
        $data['day'] = $day;
        $data['selected_date'] = $selected_date;
        $data['role'] = $this->session->userdata('ROLE');
        $data['npk'] = $this->session->userdata('NPK');
        $this->load->view($this->layout, $data);
    }

    function export_absensi() {
        $aortadb = $this->load->database("aorta", TRUE);
        
        $month_selected = $this->input->post('CHR_MONTH_SELECTED');
        $day_selected = $this->input->post('CHR_DAY_SELECTED');
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
        $date_selected =  $month_selected . $day_selected;    
        $absensi_ot = $this->report_m->get_data_absensi($date_selected, $dept_selected, $sect_selected, $subsect_selected);      
                        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/aorta/report/Template_Report_Absensi_OT.xls");
        
        $row = 7;
        $seq = 1;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('ABSENSI');
        $active_sheet->setCellValue("B2", "REPORT ABSENSI OVERTIME : " . date('d-m-Y', strtotime($date_selected)));
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $dept_desc);
        $active_sheet->setCellValue("B4", "Print Date : " . date('d-m-Y'));
        
        foreach ($absensi_ot as $ot) {            
            $active_sheet->setCellValue("B$row", "$seq");
            $active_sheet->setCellValue("C$row", "$ot->NPK");
            $active_sheet->setCellValue("D$row", "$ot->NAMA");
            $active_sheet->setCellValue("E$row", "$ot->KD_DEPT");
            $active_sheet->setCellValue("F$row", "$ot->KD_SECTION");
            $active_sheet->setCellValue("G$row", "$ot->KD_SUB_SECTION");
            if($ot->HARI_KJ == 1){
               $active_sheet->setCellValue("H$row", 'LIBUR'); 
            } else {
               $active_sheet->setCellValue("H$row", 'NORMAL'); 
            }            
            
            $in = date('H:i:s', strtotime($ot->JAM_MASUK));
            $out = date('H:i:s', strtotime($ot->JAM_PULANG));
            $active_sheet->setCellValue("I$row", "$in");
            $active_sheet->setCellValue("J$row", "$out");
            
            $seq++;
            $row++;
        }
        
        $row_min = $row - 1;
        $active_sheet->getStyle("B7:J$row_min")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        ob_end_clean();
        $filename = "Report Absensi OT - $dept_desc - $date_selected.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
