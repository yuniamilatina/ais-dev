<?php

class manifest_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('delivery/manifest_m');
    }

    public function delivery_delay_and_partial($msg = null) {
        $data['title'] = 'Manifest';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(173);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['content'] = 'delivery/manage_delay_and_partial_delivery_v.php';

        $data['data'] = $this->manifest_m->get_data_delivery_delay_and_partial();
        $data['data_detail'] = $this->manifest_m->get_data_delivery_delay_and_partial_detail();

        $this->load->view($this->layout, $data);
    }

    public function receive_delay_and_partial($msg = null) {
        $data['title'] = 'Manifest';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(174);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['content'] = 'delivery/manage_delay_and_partial_receive_v.php';

        $data['data'] = $this->manifest_m->get_data_receive_delay_and_partial();

        $this->load->view($this->layout, $data);
    }

    public function view_detail_manifest() {
        $sm = $this->input->post("sm");
        $data_detail = $this->manifest_m->get_data_manifest_by_sm($sm);
        $data = "";
        $i = 1;
        foreach ($data_detail as $isi) {
            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>$isi->CHR_PART_NO_DASH</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'><strong>$isi->CHR_PART_NO_CUST</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->CHR_PART_NAME</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->INT_PLAN_KANBAN . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . str_replace(".000", "", $isi->INT_PLAN_QTY) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->INT_DEL_KANBAN . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->INT_DEL_QTY . "</td>";
            if ((int) str_replace(".000", "", $isi->INT_PLAN_QTY) <> $isi->INT_DEL_QTY) {
                $data .= "<td style='vertical-align: middle;text-align:center;background-color: #d9534f;color:white;'>NG</td>";
            } else {
                $data .= "<td style='vertical-align: middle;text-align:center;background-color: #5cb85c;color:white;'>OK</td>";
            }
            $data .= "</tr>";

            $i++;
        }
        echo $data;
    }

    public function view_detail_manifest_close() {
        $sm = $this->input->post("sm");
        $data_detail = $this->manifest_m->get_data_manifest_by_sm($sm);
        $data = "";
        $i = 1;
        foreach ($data_detail as $isi) {
            $data .= "<tr class='gradeX'>";
            $data .= "<td>$i</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'><strong>$isi->CHR_PART_NO_DASH</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:left'><strong>$isi->CHR_PART_NO_CUST</strong></td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>$isi->CHR_PART_NAME</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->INT_PLAN_KANBAN . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . str_replace(".000", "", $isi->INT_PLAN_QTY) . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->INT_DEL_KANBAN . "</td>";
            $data .= "<td style='vertical-align: middle;text-align:center'>" . $isi->INT_DEL_QTY . "</td>";
            if ((int) str_replace(".000", "", $isi->INT_PLAN_QTY) <> $isi->INT_DEL_QTY) {
                $data .= "<td style='vertical-align: middle;text-align:center;'>"
                        . "<input  type='text' class='feedbacksm' required='required' name='" . trim($isi->CHR_PART_NO_CUST) . "' minlength='10'>"
                        . "<input  type='text' name='po_cust' style='display:none' value='$isi->CHR_PO_NO'>"
                        . "<input  type='text' name='sm_cust' style='display:none' value='$isi->CHR_SM_NO'>"
                        . "</td>";
            } else {
                $data .= "<td style='vertical-align: middle;text-align:center;background-color: #5cb85c;color:white;'>OK</td>";
            }
            $data .= "</tr>";

            $i++;
        }
        echo $data;
    }

    function update_receive_do() {
        
    }

    public function close_manifest_wcmnt() {
        $no_po = trim($this->input->GET("po_cust"));
        $no_sm = trim($this->input->GET("sm_cust"));
        $data_detail = $this->manifest_m->get_data_manifest_ng($no_sm);
        foreach ($data_detail as $value) {
            $pno_cust = trim($value->CHR_PART_NO_CUST);
            $feedback = trim($this->input->GET("$pno_cust"));
            $this->manifest_m->update_detail_manifest($no_sm, $no_po, $pno_cust, $feedback);
        }
        $this->manifest_m->update_header_manifest($no_sm, $no_po);
        echo $no_sm;
    }

    public function search_actual_manifest() {
        $this->role_module_m->authorization('173');

        $data['title'] = 'Actual manifest';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(173);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'delivery/actual_manifest_v';

        $cus_po = $this->input->post('CHR_PO_NO');
        $cust = $this->input->post('CHR_CUS_NO');
        $ship = $this->input->post('CHR_SHIP_NO');
        $cus_part_no = $this->input->post('CHR_CUST_PART_NO');
        $data['cust_po'] = $cus_po;
        $data['customer'] = $cust;
        $data['cus_dest'] = $ship;
        $data['part_no_cust'] = $cus_part_no;

        $check_cust_dest = $this->input->post('CHR_CUST_DEST_CHECK');
        $check_cust = $this->input->post('CHR_CUSTOMER_CHECK');

        if ($check_cust_dest == '') {
            $data['cust_dest_value'] = 'false';
        } else {
            $data['cust_dest_value'] = $check_cust_dest;
        }
        if ($check_cust == '') {
            $data['customer_value'] = 'false';
        } else {
            $data['customer_value'] = $check_cust;
        }

        if ($check_cust == 'true') {
            $data['customer_status'] = "enabled style='width:300px;background:#FFFFFF;'";
            $data['customer_check'] = 'checked';
        } else {
            $data['customer_status'] = "disabled style='width:300px;background:#EEEEEE;'";
            $data['customer_check'] = 'unchecked';
        }

        if ($check_cust_dest == 'true') {
            $data['custdest_status'] = "enabled style='width:300px;background:#FFFFFF;'";
            $data['custdest_check'] = 'checked';
        } else {
            $data['custdest_status'] = "disabled style='width:300px;background:#EEEEEE;'";
            $data['custdest_check'] = 'unchecked';
        }

        $check_po = $this->input->post('CHR_PO_NO_CHECK');
        if ($check_po == 'true') {
            $data['po_value'] = 'true';
            $data['po_check'] = 'checked';
            $data['po_status'] = "enabled style='width:250px;background:#FFFFFF;'";
        } else {
            $data['po_value'] = 'false';
            $data['po_check'] = 'unchecked';
            $data['po_status'] = "disabled style='width:250px;background:#EEEEEE;'";
        }

        $check_part_no = $this->input->post('CHR_CUST_PART_NO_CHECK');
        if ($check_part_no == 'true') {
            $data['part_no_value'] = 'true';
            $data['part_no_check'] = 'checked';
            $data['part_no_status'] = "enabled style='width:200px;background:#FFFFFF;'";
        } else {
            $data['part_no_value'] = 'false';
            $data['part_no_check'] = 'unchecked';
            $data['part_no_status'] = "disabled style='width:200px;background:#EEEEEE;'";
        }
        if ($this->input->post('INT_FLG_STATUS_RADIO') == null || $this->input->post('INT_FLG_STATUS_RADIO') == '') {
            $data['end_date_picker'] = 'enabled';
            $data['start_date_picker'] = 'enabled';
            $data['radio_date_status'] = 'checked';
            $data['radio_period_status'] = 'unchecked';
            $data['period_picker'] = 'disabled';
            $data['value_status_radio'] = 'date';
            $data['period'] = date('m-Y');
            $start_date = date('Ymd', strtotime($this->input->post('CHR_START_PERIOD')));
            $finish_date = date('Ymd', strtotime($this->input->post('CHR_END_PERIOD')));
            $data['start_date'] = $this->input->post('CHR_START_PERIOD');
            $data['finish_date'] = $this->input->post('CHR_END_PERIOD');
            $data['data_manifest'] = $this->manifest_m->select_data_actual_manifest($start_date, $finish_date, $cust, $ship, $cus_po, $cus_part_no);
            $data['all_cust_po'] = $this->manifest_m->get_all_cust_po_by_date_and_customer_and_customer_dest($start_date, $finish_date, $cust, $ship);
            $data['all_customer'] = $this->customer_m->get_all_customer_by_date($start_date, $finish_date);
            $data['all_cust_dest'] = $this->customer_m->get_all_cust_dest_by_date($start_date, $finish_date);
            $data['all_part_no_cust'] = $this->manifest_m->get_all_cust_part_no($start_date, $finish_date, $cust, $ship, $cus_po);
        }

        if ($this->input->post('INT_FLG_STATUS_RADIO') == 'date') {
//            echo 'date';exit();
            $data['end_date_picker'] = 'enabled';
            $data['start_date_picker'] = 'enabled';
            $data['radio_date_status'] = 'checked';
            $data['radio_period_status'] = 'unchecked';
            $data['period_picker'] = 'disabled';
            $data['value_status_radio'] = 'date';
            $data['period'] = date('m-Y');
            $start_date = date('Ymd', strtotime($this->input->post('CHR_START_PERIOD')));
            $finish_date = date('Ymd', strtotime($this->input->post('CHR_END_PERIOD')));
            $data['start_date'] = $this->input->post('CHR_START_PERIOD');
            $data['finish_date'] = $this->input->post('CHR_END_PERIOD');
            $data['data_manifest'] = $this->manifest_m->select_data_actual_manifest($start_date, $finish_date, $cust, $ship, $cus_po, $cus_part_no);
            $data['all_cust_po'] = $this->manifest_m->get_all_cust_po_by_date_and_customer_and_customer_dest($start_date, $finish_date, $cust, $ship);
            $data['all_customer'] = $this->customer_m->get_all_customer_by_date($start_date, $finish_date);
            $data['all_cust_dest'] = $this->customer_m->get_all_cust_dest_by_date($start_date, $finish_date);
            $data['all_part_no_cust'] = $this->manifest_m->get_all_cust_part_no($start_date, $finish_date, $cust, $ship, $cus_po);
        }

        if ($this->input->post('INT_FLG_STATUS_RADIO') == 'period') {
            //echo 'period';exit();
            $data['end_date_picker'] = 'disabled';
            $data['start_date_picker'] = 'disabled';
            $explode_period = explode('-', $this->input->post('CHR_PERIOD'));
            $period = $explode_period[1] . $explode_period[0];
            $data['radio_date_status'] = 'unchecked';
            $data['radio_period_status'] = 'checked';
            $data['period_picker'] = 'enabled';
            $data['value_status_radio'] = 'period';
            $data['period'] = $this->input->post('CHR_PERIOD');
            $data['start_date'] = date('d-m-Y');
            $data['finish_date'] = date('d-m-Y');
            $data['data_manifest'] = $this->manifest_m->select_data_actual_manifest_by_period($period, $cust, $ship, $cus_po, $cus_part_no);
            $data['all_cust_po'] = $this->manifest_m->get_all_cust_po_by_date_and_customer_and_customer_dest_and_period($period, $cust, $ship);
            $data['all_customer'] = $this->customer_m->get_all_customer_by_date_and_period($period);
            $data['all_cust_dest'] = $this->customer_m->get_all_cust_dest_by_date_and_period($period);
            $data['all_part_no_cust'] = $this->manifest_m->get_all_cust_part_no_by_period($period, $cust, $ship, $cus_po);
        }

        $this->load->view($this->layout, $data);
    }

    function print_actual_manifest() {
        ini_set('memory_limit', '2048M');
        $this->load->library('excel');

        $cus_po = $this->input->post('CHR_PO_NO_EXCEL');
        $cust = $this->input->post('CHR_CUS_NO_EXCEL');
        $ship = $this->input->post('CHR_SHIP_NO_EXCEL');
        $cus_part_no = $this->input->post('CHR_CUST_PART_NO_EXCEL');
        if ($this->input->post('INT_FLG_STATUS_RADIO_EXCEL') == 'date') {
            $start_date = date('Ymd', strtotime($this->input->post('CHR_START_PERIOD_EXCEL')));
            $finish_date = date('Ymd', strtotime($this->input->post('CHR_END_PERIOD_EXCEL')));
            $data_manifest = $this->manifest_m->select_data_actual_manifest($start_date, $finish_date, $cust, $ship, $cus_po, $cus_part_no);
        }

        if ($this->input->post('INT_FLG_STATUS_RADIO_EXCEL') == 'period') {
            $explode_period = explode('-', $this->input->post('CHR_PERIOD_EXCEL'));
            $period = $explode_period[1] . $explode_period[0];
            $data_manifest = $this->manifest_m->select_data_actual_manifest_by_period($period, $cust, $ship, $cus_po, $cus_part_no);
        }

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Actual manifest Part");
        $objPHPExcel->getProperties()->setSubject("Report Actual manifest Part");
        $objPHPExcel->getProperties()->setDescription("Report Actual manifest Part");
        //Set Properties
        //sheet 1
        $width = 16;
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Actual manifest Part');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(28);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(34);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth($width);

        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');

        $objPHPExcel->getActiveSheet()->getStyle("A3:N3")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');
        $objPHPExcel->getActiveSheet()->getStyle("A3:N3")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Acquired Date: ' . date('d-M-Y'));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'PO No');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'manifest No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'PDS No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Cust No');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Cust Desc');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Ship To');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Ship To Desc');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Dock');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'manifest Date');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'Part No Aisin');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Part No Customer');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'Qty manifest');

        $e = 4;
        $no = 1;
        foreach ($data_manifest as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->CHR_PO_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", $row->CHR_DEL_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_PDS_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_CUS_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->CUST_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CHR_CUS_DEST);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->CUST_DEST_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->CHR_DOK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $row->CHR_DEL_DATE_ACT);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $row->CHR_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $row->CHR_CUST_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $row->INT_ACTUAL_DEL);
            $e++;
            $no++;
        }

        $e = $e - 1;
        $objPHPExcel->getActiveSheet()->getStyle("A3:N$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Actual_manifest_Part_Acquired_Date_at-" . date('Ymd') . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
