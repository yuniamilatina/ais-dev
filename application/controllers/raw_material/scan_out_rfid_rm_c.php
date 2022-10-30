<?php

class scan_out_rfid_rm_c extends CI_Controller
{

    private $layout = '/template/head';
    private $back_to_manage = 'raw_material/scan_out_rfid_rm_c/index/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('basis/role_module_m');
        $this->load->model('organization/dept_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
        $this->load->model('raw_material/raw_material_sto_m');
        $this->load->model('raw_material/raw_material_m');
        $this->load->model('raw_material/good_movement_m');
    }

    public function index($msg = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Berhasil Non-aktif</strong></div >";
        } elseif ($msg == 5) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Data Aktif Kembali</strong></div >";
        } elseif ($msg == 6) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Gagal simpan data </div >";
        }

        $data['content'] = 'raw_material/report_scan_out_rfid_v';
        $data['title'] = 'Master Data User Quinsa';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(183);
        $data['news'] = $this->news_m->get_news();
        $data['data'] = $this->raw_material_sto_m->get_user();
        $data['msg'] = $msg;

        $this->load->view($this->layout, $data);
    }

    function create_user()
    {
        // $this->role_module_m->authorization('14');
        $row = $this->dept_m->get_top_prod_dept()->row();
        $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
        // $data['data_section'] = $this->section_m->get_section();
        $data['data_npk'] = $this->raw_material_sto_m->get_npk();
        $all_work_centers = $this->raw_material_m->get_all_work_center_by_dept($responsible);
        $data['data_line'] = $all_work_centers;
        // $data['data_groupdept'] = $this->groupdept_m->get_groupdept();
        // $data['data_div'] = $this->division_m->get_division();
        // $data['data_company'] = $this->company_m->get_company();
        // $data['data_subsection'] = $this->subsection_m->get_subsection();

        // $data['data_role'] = $this->role_m->select_role();

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(183);
        $data['news'] = $this->news_m->get_news();

        $data['title'] = 'Create User Quinsa';
        $data['content'] = 'raw_material/create_user_v';
        $this->load->view($this->layout, $data);
    }

    public function save_user()
    {
        $npk = trim($this->input->post('CHR_NPK'));
        $dept = trim($this->input->post('CHR_DEPT'));
        // $line = trim($this->input->post('CHR_LINE'));
        $session = $this->session->all_userdata();
        $username = $this->raw_material_sto_m->get_nama($npk);

        $data = $this->raw_material_sto_m->check_data($npk);
        if ($data == 0) {
            $data = array(
                'CHR_NPK' => trim($npk),
                'CHR_NAME' => trim($username),
                'CHR_DEPT' => trim($dept),
                // 'CHR_LINE' => trim($line),
                'CHR_CREATED_BY' => $session['NPK'],
                'CHR_CREATED_DATE' => date("Ymd"),
                'CHR_CREATED_TIME' => date("His")
            );
            $this->raw_material_sto_m->save($data);
            redirect($this->back_to_manage . $msg = 1);
        } else {
            redirect($this->back_to_manage . $msg = 6);
        }
    }

    function edit_user($id)
    {
        // $this->role_module_m->authorization('3');
        $data['data'] = $this->raw_material_sto_m->get_data($id);
        $row = $this->dept_m->get_top_prod_dept()->row();
        $responsible = '01' . substr($row->CHR_DEPT, 2, 1);
        $all_work_centers = $this->raw_material_m->get_all_work_center_by_dept($responsible);
        $data['data_line'] = $all_work_centers;

        $data['content'] = 'raw_material/edit_user_v';
        $data['title'] = 'Edit Data User';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(183);

        $this->load->view($this->layout, $data);
    }

    public function update_user()
    {
        $id = trim($this->input->post('CHR_ID'));
        $dept = trim($this->input->post('CHR_DEPT'));
        $line = trim($this->input->post('CHR_LINE'));
        $session = $this->session->all_userdata();
        // $username = $this->raw_material_sto_m->get_nama($npk);

        $data = array(
            // 'CHR_NPK' => trim($npk),
            // 'CHR_NAME' => trim($username),
            'CHR_DEPT' => trim($dept),
            'CHR_LINE' => trim($line),
            'CHR_MODIFIED_BY' => $session['NPK'],
            'CHR_MODIFIED_DATE' => date("Ymd"),
            'CHR_MODIFIED_TIME' => date("His")
        );
        $this->raw_material_sto_m->edit_data($data, $id);
        redirect($this->back_to_manage . $msg = 2);
    }

    function delete_user($doc_id)
    {
        $this->raw_material_sto_m->delete_user($doc_id);
        redirect($this->back_to_manage . $msg = 4);
    }

    function undel_user($doc_id)
    {
        $this->raw_material_sto_m->undel_user($doc_id);
        redirect($this->back_to_manage . $msg = 5);
    }

    public function detail($id = null, $date = null, $time = null)
    {
        //$id = $this->input->get(rtrim('id'));
        //$date = $this->input->get('date');
        $b = $this->uri->segment(4);
        $a = $this->uri->segment(5);
        $c = $this->uri->segment(6);
        $data['content'] = 'raw_material/report_scan_out_rfid_detail_v';
        $data['title'] = 'Scan Out RIFD Raw Material';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(183);
        $data['news'] = $this->news_m->get_news();
        //        $data['data_scan_out'] = $this->good_movement_m->get_data_scan_out($start_date, $finish_date);
        //        $data['data_scan_out_summary'] = $this->good_movement_m->get_data_summary_scan_out($start_date, $finish_date);
        //$data['data_rm_sto_detail_mnu'] = $this->good_movement_m->get_data_sto_raw_mtrl_mnu($id, $date);
        $data['data_rm_sto_detail'] = $this->good_movement_m->get_data_scan_out_rm_detail($id, $date);

        $data['id'] = $b;
        $data['date'] = $a;
        $data['time'] = $c;
        $this->load->view($this->layout, $data);
    }

    public function print_report_scanout()
    {
        $this->load->library('excel');
        $id_scr = $this->input->post('id_scr');
        $date_scr = $this->input->post('date_scr');
        $time_scr = $this->input->post('time_scr');

        $year_only = substr($date_scr, 0, 4);
        $date_only = substr($date_scr, 4, 2);

        if ($date_only == '01') {
            $period = 'January-' . $year_only;
        } else if ($date_only == '02') {
            $period = 'February-' . $year_only;
        } else if ($date_only == '03') {
            $period = 'March-' . $year_only;
        } else if ($date_only == '04') {
            $period = 'April-' . $year_only;
        } else if ($date_only == '05') {
            $period = 'May-' . $year_only;
        } else if ($date_only == '06') {
            $period = 'June-' . $year_only;
        } else if ($date_only == '07') {
            $period = 'July-' . $year_only;
        } else if ($date_only == '08') {
            $period = 'August-' . $year_only;
        } else if ($date_only == '09') {
            $period = 'September-' . $year_only;
        } else if ($date_only == '10') {
            $period = 'October-' . $year_only;
        } else if ($date_only == '11') {
            $period = 'November-' . $year_only;
        } else {
            $period = 'December-' . $year_only;
        }


        $data_rm_sto_dtl_excel = $this->good_movement_m->get_data_scan_out_rm_dtl_excel($id_scr, $date_scr, $time_scr);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Scan Out RFID Raw Material");
        $objPHPExcel->getProperties()->setSubject("Report Scan Out RFID Raw Material");
        $objPHPExcel->getProperties()->setDescription("Report Scan Out RFID Raw Material");
        // Set Properties
        //SETUP EXCEL        

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'REPORT HASIL SCAN OUT TANGGAL ' . date("d-M-Y", strtotime($date_scr)) . ' PUKUL ' . date("H:i:s", strtotime($time_scr)));
        //HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Barcode ID');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Tipe Supplier');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Storage Location');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Receiving Area');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'ID RFID');
        //$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Tipe Supplier');
        //$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Storage Location');
        //$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Receiving Area');
        $objPHPExcel->getActiveSheet()->getStyle("A2:F2")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $e = 3;
        $no = 1;
        if ($data_rm_sto_dtl_excel == 0) {
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", "");
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", "");
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", "");
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", "");
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", "");
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", "");
            //$objPHPExcel->getActiveSheet()->setCellValue("G$e", "");
            //$objPHPExcel->getActiveSheet()->setCellValue("H$e", "");
            //$objPHPExcel->getActiveSheet()->setCellValue("I$e", "");
            $e++;
        } else {
            foreach ($data_rm_sto_dtl_excel as $row) {
                $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
                $objPHPExcel->getActiveSheet()->setCellValue("B$e", trim($row->CHR_SERIAL_NO) . " " . trim($row->CHR_BACK_NO) . " " . trim(sprintf("%04s", $row->CHR_WEIGHT)) . " " . trim($row->CHR_DATE_RECEIVED) . " " . trim($row->CHR_SCI_NO) . " " . trim($row->CHR_PDS_NO));
                $objPHPExcel->getActiveSheet()->setCellValue("C$e", $row->CHR_TIPE_SUPP);
                $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_STO_LOCT);
                $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_REC_AREA);
                $objPHPExcel->getActiveSheet()->setCellValue("F$e", substr($row->CHR_RFID, 22, 6));
                //$objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CHR_TIPE_SUPP);
                //$objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->CHR_STO_LOCT);
                //$objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->CHR_REC_AREA);
                $e++;
                $no++;
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle("A2:F2")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A2:F$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


        $filename = trim("RM_SCR-" . trim($row->CHR_NAME) . "-" . trim($row->INT_SCR_ID)) . "-" . trim($row->CHR_TIME) . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
}
