<?php

class report_amount_c extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('organization/dept_m');
        $this->load->model('aorta/master_data_m');
    }

    public function index($periode = null, $id_dept = null, $id_section = null) {
        $this->role_module_m->authorization('151');
        $this->session->userdata('user_id');

        $data['title'] = 'Master Data Employee';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(157);

        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/report_amount_v';

        $section = 'PISU';
        $dept = 'ERP';
        if ($periode == null) {
            $selected_date = date("Ym");
        } else {
            $selected_date = $periode;
        }

        if ($this->session->userdata('ROLE') == 1) { //Root
            $row = $this->dept_m->get_top_prod_dept()->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $data['id_prod'] = $row->INT_ID_DEPT;
            $data['data_prod_entry'] = $this->master_data_m->select_data_prod_entry_by_date_and_dept_and_work_center($date, $data['id_prod']);
        }
        if ($this->session->userdata('ROLE') == 5) { // Manager
            $data['id_prod'] = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $kode_dept = $this->session->userdata('DEPT');
            $all_work_centers = $this->master_data_m->get_section($kode_dept);
            $data_karyawan = $this->master_data_m->get_data_karyawan($kode_dept);

            $data['data_summary_plan'] = $this->master_data_m->select_summary_overtime_plan($selected_date, $dept, $section);
            $data['data_summary_real'] = $this->master_data_m->select_summary_overtime_real($selected_date, $dept, $section);
            $data['total_row'] = $this->master_data_m->total_row_summary($selected_date, $kode_dept, $section);
        }
        if ($this->session->userdata('ROLE') == 3 || $this->session->userdata('ROLE') == 39) { //Director
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $work_center = $this->report_prod_line_ng_ok_m->get_top_work_center_by_dept($responsible);

            $data['data_prod_entry'] = $this->report_prod_line_ng_ok_m->select_data_prod_entry_by_date_and_dept_and_work_center($date, $data['id_prod']);
        }
        if ($this->session->userdata('ROLE') == 4 ) { //GM
            $row = $this->dept_m->get_top_prod_dept()->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $work_center = $this->report_prod_line_ng_ok_m->get_top_work_center_by_dept($responsible);
            $data['id_prod'] = $row->INT_ID_DEPT;

            $data['data_prod_entry'] = $this->report_prod_line_ng_ok_m->select_data_prod_entry_by_date_and_dept_and_work_center($date, $data['id_prod']);
        }


        if ($id_section == null) {
            $chose_work_centers = $all_work_centers;
        } else {
            $chose_work_centers = $this->master_data_m->get_section_detail($kode_dept, $id_section);
        }

        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $data['all_work_centers'] = $all_work_centers;
        $data['chose_work_centers'] = $chose_work_centers;
        $data['all_dept_prod'] = $all_dept_prod;
        $data['id_dept'] = $id_dept;
        $data['id_section'] = $id_section;
        $data['first_sunday'] = $this->firstSunday(substr($periode, 0, 4) . '-' . substr($periode, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($periode, 0, 4) . '-' . substr($periode, 4, 2));
        $data['selected_date'] = $selected_date;
        $data['role'] = $this->session->userdata('ROLE');
        $this->load->view($this->layout, $data);
    }

    public function employee() {
        $this->role_module_m->authorization('151');
        $this->log_m->add_log(9, NULL);
        $this->session->userdata('user_id');

        $data['title'] = 'Master Data Employee';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(151);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'aorta/master_employee_v';
        $ymd = date("Ymd");
        $date = date("Ym");
        $data_karyawan = array();

        if ($this->session->userdata('ROLE') == 5) { //Manager
            $data['id_prod'] = $this->session->userdata('DEPT');
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $kode_dept = $this->session->userdata('DEPT');

            $all_work_centers = $this->master_data_m->get_section($kode_dept);
            $dept_name = $row->CHR_DEPT;
            $data_karyawan = $this->master_data_m->get_data_karyawan($kode_dept);
        }

        $data['kode_dept'] = $kode_dept;
        $data['data_karyawan'] = $data_karyawan;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_dept_prod'] = $this->dept_m->get_all_prod_dept();
        $data['date'] = date('d/m/Y');
        $data['fulldate'] = date('Ymd');
        $data['work_center'] = 'ALL';
        $data['selected_date_diagram'] = substr($date, 0, 4) . '/' . substr($date, 4, 2);
        $data['selected_date'] = $date;
        $data['d'] = '';
        $data['shift'] = '';
        $data['dept_name'] = $dept_name;
        $data['role'] = $this->session->userdata('ROLE');

        $this->load->view($this->layout, $data);
    }

    public function generate_template($dept) {
        $this->load->library('excel');

        //get data
        $dept_desc = $this->master_data_m->replacer_dept_prd($dept);
        $list_kry = $this->master_data_m->get_data_karyawan($dept);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Template upload master employee");
        $objPHPExcel->getProperties()->setSubject("Template upload master employee");
        $objPHPExcel->getProperties()->setDescription("Template upload master employee");

        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Template Upload Master Data Employee');
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', ': ' . $dept_desc);

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true)->setSize(13);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true)->setSize(13);

        //Header Table
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'NPK');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Nama');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Kode Dept');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Kode Group');
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Kode Section');
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Kode Sub Section');
        $objPHPExcel->getActiveSheet()->setCellValue('H4', "Position " . PHP_EOL . "(Operator / JP / Leader / SPV)");
        $objPHPExcel->getActiveSheet()->setCellValue('I4', "Salary " . PHP_EOL . "(Sample : 3500000)");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);


        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );


        for ($index = "A"; $index < "J"; $index++) {
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($index . "4")->getFont()->setBold(true);
        }

        //data
        $row_no = 5;
        $no = 1;
        foreach ($list_kry as $value) {

            $objPHPExcel->getActiveSheet()->setCellValue("A$row_no", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$row_no", "$value->NPK");
            $objPHPExcel->getActiveSheet()->setCellValue("C$row_no", $value->NAMA);
            $objPHPExcel->getActiveSheet()->setCellValue("D$row_no", $value->KD_DEPT);
            $objPHPExcel->getActiveSheet()->setCellValue("E$row_no", $value->KD_GROUP);
            $objPHPExcel->getActiveSheet()->setCellValue("F$row_no", $value->KD_SECTION);
            $objPHPExcel->getActiveSheet()->setCellValue("G$row_no", $value->KD_SUB_SECTION);
            $objPHPExcel->getActiveSheet()->setCellValue("H$row_no", $value->position);
            $objPHPExcel->getActiveSheet()->setCellValue("I$row_no", $value->salary);




            for ($index = "A"; $index < "J"; $index++) {
                $objPHPExcel->getActiveSheet()->getStyle($index . $row_no)->applyFromArray($styleArray);
                if ($index <> "C") {
                    $objPHPExcel->getActiveSheet()->getStyle($index . $row_no)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                }
            }

            $row_no++;
            $no++;
        }


        $filename = "Template Upload.xls";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

    public function upload_template_employee() {
        if ($this->input->post("upload-button") == 1) {

            //file untuk submit file excel
            $config['upload_path'] = './assets/files/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = 10000;

//--------------------------------------------------------------------//
            //code for upload with ci
            $this->load->library('upload');
            $this->upload->initialize($config);
//            if (!$this->upload->do_upload('import'))
//                $this->upload->display_errors();
            if ($a = $this->upload->do_upload('import_salary'))
                $this->upload->display_errors();
            $media = $this->upload->data('import_salary');
            $inputFileName = './assets/files/' . $media['file_name'];
//--------------------------------------------------------------------//
            //  Read  Excel workbook
            try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
//                $this->db->trans_rollback();
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $x = 0;
            $y = 0;


            $rowHeader = $sheet->rangeToArray('A0:' . $highestColumn . '6', NULL, TRUE, FALSE);
            echo $rowHeader[0][6];
        }
    }

    function firstSunday($date) {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Sunday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function firstSaturday($date) {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Saturday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    public function amount($periode = null, $id_dept = null, $id_section = null) {
        $this->role_module_m->authorization('151');

        if ($id_dept == null) {
            $id_dept = "ALL";
        }

        $data['title'] = 'Master Data Employee';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(158);
        $data['news'] = $this->news_m->get_news();
        
        if ($this->session->userdata('ROLE') == 3 || $this->session->userdata('ROLE') == 4) {
            $data['content'] = 'aorta/report_amount1bod_v';
        } else {
            $data['content'] = 'aorta/report_amount1_v';
        }
        
        $role = $this->session->userdata('ROLE');
        $dept = $this->session->userdata('DEPT');
        
        if ($periode == null) {
            $selected_date = date("Ym");
        } else {
            $selected_date = $periode;
        }
        
        $all_dept = $this->master_data_m->get_dept();

        if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 1 || $this->session->userdata('ROLE') == 14 || $this->session->userdata('ROLE') == 35 || $this->session->userdata('ROLE') == 33 || $this->session->userdata('ROLE') == 39) { // Manager
            $data['id_prod'] = $this->session->userdata('DEPT');

            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $kode_dept = $this->session->userdata('DEPT');
            $all_work_centers = $this->master_data_m->get_section($kode_dept);
            $data_karyawan = $this->master_data_m->get_data_karyawan($kode_dept);
            $all_dept_prod = $this->dept_m->get_all_dept();
            
            //NEW SCRIPT FOR CHART AND TABLE --- ANP
            $data['summary_ot_amount'] = $this->master_data_m->get_overtime_summary_by_section($selected_date, $dept, $id_section);
            $data['summary_ot_per_kry'] = $this->master_data_m->get_overtime_summary_per_kry($selected_date, $dept, $id_section);
            
            //OLD SCRIPT FOR CHART AND TABLE
            $data['get_report_amount'] = $this->master_data_m->get_report_amount($dept, $selected_date, $id_section);
            $data['get_chart'] = $this->master_data_m->get_chart($dept, $selected_date, $id_section);
        }
        if ($this->session->userdata('ROLE') == 3) { //Director
            $data['id_prod'] = $this->session->userdata('DEPT');
            $all_dept_prod = $this->dept_m->get_all_dept_aorta();
            $row = "";
            $all_work_centers = $this->master_data_m->get_section($id_dept);
            
            //NEW SCRIPT FOR CHART AND TABLE --- ANP
            $data['summary_ot_amount'] = $this->master_data_m->get_overtime_summary_by_dept_prd($selected_date, $id_dept, $id_section);
            $data['summary_ot_per_kry'] = $this->master_data_m->get_overtime_summary_per_kry_bod($selected_date, $id_dept, $id_section);
            
            //OLD SCRIPT FOR CHART AND TABLE
            $data['get_report_amount'] = $this->master_data_m->get_report_amount_bod($selected_date);
            $data['get_chart'] = $this->master_data_m->get_chart_bod_prd($selected_date);
        }

        if ($this->session->userdata('ROLE') == 4) { //GM
            $data['id_prod'] = $this->session->userdata('DEPT');
            $all_dept_prod = $this->dept_m->get_all_dept_aorta();
            $row = "";
            $all_work_centers = $this->master_data_m->get_section($id_dept);
            
            //NEW SCRIPT FOR CHART AND TABLE --- ANP
            $data['summary_ot_amount'] = $this->master_data_m->get_overtime_summary_by_dept_prd($selected_date, $id_dept, $id_section);
            $data['summary_ot_per_kry'] = $this->master_data_m->get_overtime_summary_per_kry_bod($selected_date, $id_dept, $id_section);
            
            //OLD SCRIPT FOR CHART AND TABLE
            $data['get_report_amount'] = $this->master_data_m->get_report_amount_bod($selected_date);
            $data['get_chart'] = $this->master_data_m->get_chart_bod_prd($selected_date);
        }

        $data['all_work_centers'] = $all_work_centers;
        $data['all_dept_prod'] = $all_dept_prod;
        $data['id_dept'] = $id_dept;
        $data['id_section'] = $id_section;
        $data['first_sunday'] = $this->firstSunday(substr($periode, 0, 4) . '-' . substr($periode, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($periode, 0, 4) . '-' . substr($periode, 4, 2));
        $data['selected_date'] = $selected_date;

        $data['role'] = $this->session->userdata('ROLE');
        $this->load->view($this->layout, $data);
    }

    public function amount_supporting($periode = null, $id_dept = null, $id_section = null) {
        $this->role_module_m->authorization('151');

        $data['title'] = 'Master Data Employee';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(158);
        $data['news'] = $this->news_m->get_news();
        
        if ($this->session->userdata('ROLE') == 3 || $this->session->userdata('ROLE') == 4) {
            $data['content'] = 'aorta/report_amount2bod_v';
        } else {
            $data['content'] = 'aorta/report_amount1_v';
        }
                    
        $role = $this->session->userdata('ROLE');
        $dept = $this->session->userdata('DEPT');

        if ($periode == null) {
            $selected_date = date("Ym");
        } else {
            $selected_date = $periode;
        }
        
        $all_dept = $this->master_data_m->get_dept();

        if ($this->session->userdata('ROLE') == 5 || $this->session->userdata('ROLE') == 1 || $this->session->userdata('ROLE') == 14 || $this->session->userdata('ROLE') == 35 || $this->session->userdata('ROLE') == 33 || $this->session->userdata('ROLE') == 39) { // Manager
            $data['id_prod'] = $this->session->userdata('DEPT');

            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
            $kode_dept = $this->session->userdata('DEPT');
            $all_work_centers = $this->master_data_m->get_section($kode_dept);
            $data_karyawan = $this->master_data_m->get_data_karyawan($kode_dept);
            $all_dept_prod = $this->dept_m->get_all_dept();
            
            //NEW SCRIPT FOR CHART AND TABLE --- ANP
            $data['summary_ot_amount'] = $this->master_data_m->get_overtime_summary_by_section($selected_date, $dept, $id_section);
            $data['summary_ot_per_kry'] = $this->master_data_m->get_overtime_summary_per_kry($selected_date, $dept, $id_section);
            
            //OLD SCRIPT FOR CHART AND TABLE
            $data['get_report_amount'] = $this->master_data_m->get_report_amount($dept, $selected_date, $id_section);
            $data['get_chart'] = $this->master_data_m->get_chart($dept, $selected_date, $id_section);
        }
        if ($this->session->userdata('ROLE') == 3) { //Director
            $data['id_prod'] = $this->session->userdata('DEPT');
            $data['id_dept'] = $id_dept; 
        }

        if ($this->session->userdata('ROLE') == 4) { //GM
            $data['id_prod'] = $this->session->userdata('DEPT');
            $data['id_dept'] = $id_dept;
        }

        $data['first_sunday'] = $this->firstSunday(substr($periode, 0, 4) . '-' . substr($periode, 4, 2));
        $data['first_saturday'] = $this->firstSaturday(substr($periode, 0, 4) . '-' . substr($periode, 4, 2));
        $data['selected_date'] = $selected_date;
        $data['role'] = $this->session->userdata('ROLE');
        if ($this->session->userdata('ROLE') == 3 || $this->session->userdata('ROLE') == 4) {
            
            //NEW SCRIPT FOR CHART AND TABLE --- ANP
            $data['summary_ot_amount'] = $this->master_data_m->get_overtime_summary_by_dept_spt($selected_date, $id_dept, $id_section);
            
            //OLD SCRIPT FOR CHART AND TABLE
            $data['get_chart'] = $this->master_data_m->get_chart_bod_spt($selected_date);
            $this->load->view("/template/head_blank", $data);
        } else {
            $this->load->view($this->layout, $data);
        }
    }

}
