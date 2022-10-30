<?php

class report_quota_overtime_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/report_m');
    }

    function index($periode = null, $id_dept = null, $id_section = null, $id_subsect = null) {

        $data['title'] = 'Report Overtime';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(230);

        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/report_quota_overtime_v';

        if ($periode == null) {
            $periode = date("Ym");
        } else {
            $periode = $periode;
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
            
            
            $row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_karyawan = $this->report_m->get_quota_karyawan($periode, $id_dept, $id_section, $id_subsect);
            
        } else if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 39 || $this->session->userdata('ROLE') == 45) { // Manager
            $id_dept = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_karyawan = $this->report_m->get_quota_karyawan($periode, $id_dept, $id_section, $id_subsect);
            
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
            $data_karyawan = $this->report_m->get_quota_karyawan($periode, $id_dept, $id_section, $id_subsect);
            
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
            $data_karyawan = $this->report_m->get_quota_karyawan($periode, $id_dept, $id_section, $id_subsect);
        } else {
            $id_dept = $this->session->userdata('DEPT');
            if($id_dept == '24'){
                $id_dept = '23';
            }
            $row = $this->dept_m->get_data_dept($id_dept)->row();
            $all_dept = $this->dept_m->get_all_dept_plant();
            $all_work_centers = $this->report_m->get_section($id_dept);
            $all_lines = $this->report_m->get_sub_section($id_dept, $id_section);
            $data_karyawan = $this->report_m->get_quota_karyawan($periode, $id_dept, $id_section, $id_subsect);
        }
        
        $data['all_dept'] = $all_dept; //List Dept
        $data['all_work_centers'] = $all_work_centers; //List Section
        $data['all_lines'] = $all_lines; //List Sub section atau Line
        $data['all_karyawan'] = $data_karyawan; //List Karyawan
        
        $data['id_dept'] = $id_dept;
        $data['id_section'] = $id_section;
        $data['id_subsect'] = $id_subsect;
        $data['selected_date'] = $periode;
        $data['role'] = $this->session->userdata('ROLE');
        $data['npk'] = $this->session->userdata('NPK');
        $this->load->view($this->layout, $data);
    }

    function export_quota_overtime() {
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
              
        $list_karyawan = $this->report_m->get_quota_karyawan($date_selected, $dept_selected, $sect_selected, $subsect_selected);  
                
        $year_only = substr($date_selected, 0, 4);
        $month_only = substr($date_selected, 4, 2); 
                        
        $this->load->library('excel');
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        // Create new PHPExcel object

        $objPHPExcel = $objReader->load("assets/template/aorta/report/Template_Report_Quota_OT.xls");
        
        $row = 7;
        $seq = 1;
        $active_sheet = $objPHPExcel->setActiveSheetIndexByName('QUOTA OT');
        $active_sheet->setCellValue("B2", "REPORT OVERTIME : QUOTA USAGE " . strtoupper(date("F", mktime(null, null, null, $month_only))) . " " . $year_only);
        $active_sheet->setCellValue("B3", "DEPARTMENT : " . $dept_desc);
        $active_sheet->setCellValue("B4", "Print Date : " . date('d-m-Y') . " " . date("H:i:s"));
        
        foreach ($list_karyawan as $kry) {            
            $active_sheet->setCellValue("B$row", "$seq");
            $active_sheet->setCellValue("C$row", "$kry->NPK");
            $active_sheet->setCellValue("D$row", "$kry->NAMA");
            $active_sheet->setCellValue("E$row", "$kry->KD_SECTION");
            $active_sheet->setCellValue("F$row", "$kry->KD_SUB_SECTION");
            $active_sheet->setCellValue("G$row", "$kry->QUOTAPLAN1");
            $active_sheet->setCellValue("H$row", "$kry->QUOTA_STD");
            $active_sheet->setCellValue("I$row", "$kry->QUOTA_ADD");
            $active_sheet->setCellValue("J$row", "$kry->TOT_QUOTAPLAN");
            $active_sheet->setCellValue("K$row", "$kry->TERPAKAIPLAN1");
            $active_sheet->setCellValue("L$row", "$kry->TERPAKAIPLAN");
            $active_sheet->setCellValue("M$row", "$kry->TOT_TERPAKAIPLAN");
            $active_sheet->setCellValue("N$row", "$kry->SISAPLAN1");
            $active_sheet->setCellValue("O$row", "$kry->SISAPLAN");
            $active_sheet->setCellValue("P$row", "$kry->TOT_SISAPLAN");
            
            $seq++;
            $row++;
        }

        $active_sheet->getStyle("B7:P$row")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $row_min = $row - 1;
        $active_sheet->setCellValue("G$row", "=SUM(G7:G$row_min)");
        $active_sheet->setCellValue("H$row", "=SUM(H7:H$row_min)");
        $active_sheet->setCellValue("I$row", "=SUM(I7:I$row_min)");
        $active_sheet->setCellValue("J$row", "=SUM(J7:J$row_min)");
        $active_sheet->setCellValue("K$row", "=SUM(K7:K$row_min)");
        $active_sheet->setCellValue("L$row", "=SUM(L7:L$row_min)");
        $active_sheet->setCellValue("M$row", "=SUM(M7:M$row_min)");
        $active_sheet->setCellValue("N$row", "=SUM(N7:N$row_min)");
        $active_sheet->setCellValue("O$row", "=SUM(O7:O$row_min)");
        $active_sheet->setCellValue("P$row", "=SUM(P7:P$row_min)");
        
        $active_sheet->mergeCells("B$row:F$row");
        $active_sheet->setCellValue("B$row", "TOTAL");
        $active_sheet->getStyle("B$row:P$row")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('#CCCCCC');
        $active_sheet->getStyle("B$row:p$row")->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 12
            )
        ));
        
        ob_end_clean();
        $filename = "Report OT Quota Usage - $dept_desc - $date_selected.xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
