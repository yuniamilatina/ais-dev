<?php

class scan_raw_material_sto_c extends CI_Controller
{

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('basis/role_module_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
        $this->load->model('raw_material/raw_material_sto_m');
        $this->load->model('raw_material/good_movement_m');
        $this->load->model('prd/direct_backflush_general_m');
    }

    public function index()
    {
        $data['content'] = 'raw_material/report_scan_raw_material_sto_v';
        $data['title'] = 'REPORT QCWIS';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(142);
        $data['news'] = $this->news_m->get_news();

        $date = date('Y') . date('m');
        $data['selected_date'] = $date;
        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $data['all_work_centers'] = $data_work_center;
        $work_center = $this->direct_backflush_general_m->get_top_work_center();
        $data['wc'] = $work_center;
        $allpartno = $this->raw_material_sto_m->get_partno_by_wc();
        $data['partno'] = $allpartno;
        $item_cek = $this->raw_material_sto_m->get_item_cek($work_center, $allpartno);
        $data['item'] = $item_cek;
        // $data['partno'] = $partno;
        // $data['item'] = $item;

        $data['data_range'] = $this->raw_material_sto_m->select_data_range_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_max'] = $this->raw_material_sto_m->select_data_max_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_min'] = $this->raw_material_sto_m->select_data_min_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_ok'] = $this->raw_material_sto_m->select_data_ok_by_date_dept($date, $work_center, $allpartno, $item_cek);
        $data['data_yes'] = $this->raw_material_sto_m->select_data_yes_by_date_dept($date, $work_center, $allpartno, $item_cek);

        $this->load->view($this->layout, $data);
    }

    public function search_qcwis($date = '', $wc = '', $partno = '', $item = '')
    {
        $data['content'] = 'raw_material/report_scan_raw_material_sto_v';
        $data['title'] = 'REPORT QCWIS';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(142);
        $data['news'] = $this->news_m->get_news();

        $data_work_center = $this->direct_backflush_general_m->get_all_work_center();
        $data['all_work_centers'] = $data_work_center;
        $work_center = $this->direct_backflush_general_m->get_top_work_center();
        $data['work_center'] = $work_center;
        $allpartno = $this->raw_material_sto_m->get_partno_by_wc();
        $data['allpartno'] = $allpartno;
        $item_cek = $this->raw_material_sto_m->get_item_cek($wc, $partno);
        $data['all_item_cek'] = $item_cek;
        $data['selected_date'] = $date;
        $data['wc'] = $wc;
        $data['partno'] = $partno;
        $data['item'] = $item;

        $data['data_range'] = $this->raw_material_sto_m->select_data_range_by_date_dept($date, $wc, $partno, $item);
        $data['data_max'] = $this->raw_material_sto_m->select_data_max_by_date_dept($date, $wc, $partno, $item);
        $data['data_min'] = $this->raw_material_sto_m->select_data_min_by_date_dept($date, $wc, $partno, $item);
        $data['data_ok'] = $this->raw_material_sto_m->select_data_ok_by_date_dept($date, $wc, $partno, $item);
        $data['data_yes'] = $this->raw_material_sto_m->select_data_yes_by_date_dept($date, $wc, $partno, $item);

        $this->load->view($this->layout, $data);
    }

    function get_range($date, $wc, $partno, $item)
    {
        $data['content'] = 'raw_material/report_range_qcwis';

        $data['data_range'] = $this->raw_material_sto_m->select_data_range_by_date_dept($date, $wc, $partno, $item);
        $get_line = $this->raw_material_sto_m->get_data_range_by_row($date, $wc, $partno, $item);
        $uom = trim($get_line->CHR_UOM_SL);
        $data['uom'] = $uom;
        $stra = trim($get_line->CHR_STRATEGY);
        $data['stra'] = $stra;
        $lot = trim($get_line->CHR_LOT_NOMOR);
        $data['lot'] = $lot;
        $lsl = trim($get_line->CHR_LSL);
        $data['lsl'] = $lsl;
        $lsl_lim = $lsl - 0.3;
        $data['lsl_lim'] = $lsl_lim;
        $usl = trim($get_line->CHR_USL);
        $data['usl'] = $usl;
        $usl_lim = $usl + 0.3;
        $data['usl_lim'] = $usl_lim;
        $tsl = trim($get_line->CHR_TARGET_SL);
        $data['tsl'] = $tsl;
        $rsl = trim($get_line->CHR_RANGE_SL);
        $data['upp'] = $tsl + $rsl;
        $data['low'] = $tsl - $rsl;

        $this->load->view($this->layout_blank, $data);
    }

    function get_max($date, $wc, $partno, $item)
    {
        $data['content'] = 'raw_material/report_max_qcwis';

        $data['data_max'] = $this->raw_material_sto_m->select_data_max_by_date_dept($date, $wc, $partno, $item);
        $get_line = $this->raw_material_sto_m->get_data_max_by_row($date, $wc, $partno, $item);
        $uom = trim($get_line->CHR_UOM_SL);
        $data['uom'] = $uom;
        $stra = trim($get_line->CHR_STRATEGY);
        $data['stra'] = $stra;
        $lot = trim($get_line->CHR_LOT_NOMOR);
        $data['lot'] = $lot;
        $lsl = trim($get_line->CHR_LSL);
        $data['lsl'] = $lsl;
        $usl = trim($get_line->CHR_USL);
        $data['usl'] = $usl;
        $usl_lim = $usl + 2.3;
        $data['usl_lim'] = $usl_lim;
        $lsl_lim = $usl - 10;
        $data['lsl_lim'] = $lsl_lim;
        $tsl = trim($get_line->CHR_TARGET_SL);
        $data['tsl'] = $tsl;
        $rsl = trim($get_line->CHR_RANGE_SL);
        $data['upp'] = $tsl + $rsl;
        $data['low'] = $tsl - $rsl;

        $this->load->view($this->layout_blank, $data);
    }

    function get_min($date, $wc, $partno, $item)
    {
        $data['content'] = 'raw_material/report_min_qcwis';

        $data['data_min'] = $this->raw_material_sto_m->select_data_min_by_date_dept($date, $wc, $partno, $item);
        $get_line = $this->raw_material_sto_m->get_data_min_by_row($date, $wc, $partno, $item);
        $uom = trim($get_line->CHR_UOM_SL);
        $data['uom'] = $uom;
        $stra = trim($get_line->CHR_STRATEGY);
        $data['stra'] = $stra;
        $lot = trim($get_line->CHR_LOT_NOMOR);
        $data['lot'] = $lot;
        $lsl = trim($get_line->CHR_LSL);
        $data['lsl'] = $lsl;
        $lsl_lim = $lsl - 2.3;
        $data['lsl_lim'] = $lsl_lim;
        $usl_lim = $lsl + 10;
        $data['usl_lim'] = $usl_lim;
        $usl = trim($get_line->CHR_USL);
        $data['usl'] = $usl;
        $tsl = trim($get_line->CHR_TARGET_SL);
        $data['tsl'] = $tsl;
        $rsl = trim($get_line->CHR_RANGE_SL);
        $data['upp'] = $tsl + $rsl;
        $data['low'] = $tsl - $rsl;

        $this->load->view($this->layout_blank, $data);
    }

    function get_ok($date, $wc, $partno, $item)
    {
        $data['content'] = 'raw_material/report_ok_qcwis';

        $data['data_ok'] = $this->raw_material_sto_m->select_data_ok_by_date_dept($date, $wc, $partno, $item);

        $this->load->view($this->layout_blank, $data);
    }

    function get_yes($date, $wc, $partno, $item)
    {
        $data['content'] = 'raw_material/report_yes_qcwis';

        $data['data_yes'] = $this->raw_material_sto_m->select_data_yes_by_date_dept($date, $wc, $partno, $item);

        $this->load->view($this->layout_blank, $data);
    }

    function firstSunday($date)
    {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Sunday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    function firstSaturday($date)
    {
        for ($day = 1; $day <= 7; $day++) {
            $dd = strftime("%A", strtotime($date . '-' . $day));
            if ($dd == 'Saturday') {
                return strftime("%Y-%m-%d", strtotime($date . '-' . $day));
            }
        }
    }

    public function detail($id = null, $date = null, $time = null)
    {
        //$id = $this->input->get(rtrim('id'));
        //$date = $this->input->get('date');
        $b = $this->uri->segment(4);
        $a = $this->uri->segment(5);
        $c = $this->uri->segment(6);
        $data['content'] = 'raw_material/report_scan_raw_material_sto_detail_v';
        $data['title'] = 'Stock Opname Raw Material';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(142);
        $data['news'] = $this->news_m->get_news();
        //        $data['data_scan_out'] = $this->good_movement_m->get_data_scan_out($start_date, $finish_date);
        //        $data['data_scan_out_summary'] = $this->good_movement_m->get_data_summary_scan_out($start_date, $finish_date);
        //$data['data_rm_sto_detail_mnu'] = $this->good_movement_m->get_data_sto_raw_mtrl_mnu($id, $date);
        $data['data_rm_sto_detail'] = $this->good_movement_m->get_data_sto_raw_mtrl_detail($id, $date);

        $data['id'] = $b;
        $data['date'] = $a;
        $data['time'] = $c;
        $this->load->view($this->layout, $data);
    }

    public function print_report_rm_sto()
    {
        $this->load->library('excel');
        $id_sto = $this->input->post('id_sto');
        $date_sto = $this->input->post('date_sto');
        $time_sto = $this->input->post('time_sto');

        $year_only = substr($date_sto, 0, 4);
        $date_only = substr($date_sto, 4, 2);

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


        $data_rm_sto_dtl_excel = $this->good_movement_m->get_data_sto_raw_mtrl_dtl_excel($id_sto, $date_sto, $time_sto);

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Raw Material Stock Material");
        $objPHPExcel->getProperties()->setSubject("Report Raw Material Stock Material");
        $objPHPExcel->getProperties()->setDescription("Report Raw Material Stock Material");
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
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'REPORT HASIL STOCK OPNAME HARIAN ' . date("d-M-Y", strtotime($date_sto)) . ' PUKUL ' . date("H:i:s", strtotime($time_sto)));
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
                $objPHPExcel->getActiveSheet()->setCellValue("B$e", trim($row->CHR_SER_NO) . " " . trim($row->CHR_BACK_NO) . " " . trim($row->CHR_WEIGHT) . " " . trim($row->CHR_REC_DATE) . " " . trim($row->CHR_SCI_NO) . " " . trim($row->CHR_PDS_NO));
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


        $filename = trim("RM_STO-" . trim($row->CHR_NAME) . "-" . trim($row->INT_STO_ID)) . "-" . trim($row->CHR_TIME) . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }
}
