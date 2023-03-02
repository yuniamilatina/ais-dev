<?php

class delivery_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('delivery/delivery_m');
        $this->load->model('marketing/purchase_order_m');
        $this->load->model('marketing/customer_m');
    }

    public function index() {
        
    }

    public function actual_delivery() {
        $this->role_module_m->authorization('193');

        $data['title'] = 'Actual Delivery';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(193);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'delivery/actual_delivery_v';
        $start_date = date('Ymd');
        $period = date('Ym');
        $finish_date = $start_date;


        $data['period'] = date('m-Y');
        $data['start_date'] = date('d-m-Y');
        $data['finish_date'] = date('d-m-Y');
        $data['radio_date_status'] = 'unchecked';
        $data['radio_period_status'] = 'checked';
        $data['customer_check'] = 'checked';
        $data['customer_status'] = "enabled style='width:300px;background:#FFFFFF;'";
        $data['custdest_check'] = 'unchecked';
        $data['custdest_status'] = "disabled style='width:300px;background:#EEEEEE;'";
        $data['end_date_picker'] = 'disabled';
        $data['start_date_picker'] = 'disabled';
        $data['period_picker'] = 'enabled';
        $data['value_status_radio'] = 'period';
        $data['cust_dest_value'] = 'false';
        $data['customer_value'] = 'true';
        $data['po_value'] = 'false';
        $data['po_status'] = 'disabled';
        $data['part_no_value'] = 'false';
        $data['part_no_status'] = "disabled style='width:200px;background:#EEEEEE;'";
        $data['part_no_check'] = 'unchecked';
        $data['po_check'] = 'unchecked';

        $data['customer'] = $this->customer_m->get_first_customer_by_date_and_period($period);
        $cust = $data['customer'];
        $data['cus_dest'] = $this->customer_m->get_first_cust_dest_by_date_and_period($period);
        $ship = $data['cus_dest'];
        $data['cust_po'] =  '';//$this->delivery_m->get_first_cust_po_by_date_and_customer_and_customer_des_and_period($period, $cust, $ship);
        $cus_po = $data['cust_po'];
        $data['part_no_cust'] = ''; //$this->delivery_m->get_first_cust_part_no_by_period($period, $cust, $ship, $cus_po);
        $cus_part_no = $data['part_no_cust'];

        $data['all_cust_po'] = $this->delivery_m->get_all_cust_po_by_date_and_customer_and_customer_dest_and_period($period, $cust, $ship);
        $data['all_customer'] = $this->customer_m->get_all_customer_by_date_and_period($period);
        $data['all_cust_dest'] = $this->customer_m->get_all_cust_dest_by_date_and_period($period);
        $data['all_part_no_cust'] = $this->delivery_m->get_all_cust_part_no_by_period($period, $cust, $ship, $cus_po);

        $data['data_delivery'] =  Array();//$this->delivery_m->select_data_actual_delivery_by_period($period, $cust, $ship, $cus_po, $cus_part_no);

        $this->load->view($this->layout, $data);
    }

    public function search_actual_delivery() {
        $this->role_module_m->authorization('193');

        $data['title'] = 'Actual Delivery';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(193);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'delivery/actual_delivery_v';

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
            $data['data_delivery'] = $this->delivery_m->select_data_actual_delivery($start_date, $finish_date, $cust, $ship, $cus_po, $cus_part_no);
            $data['all_cust_po'] = $this->delivery_m->get_all_cust_po_by_date_and_customer_and_customer_dest($start_date, $finish_date, $cust, $ship);
            $data['all_customer'] = $this->customer_m->get_all_customer_by_date($start_date, $finish_date);
            $data['all_cust_dest'] = $this->customer_m->get_all_cust_dest_by_date($start_date, $finish_date);
            $data['all_part_no_cust'] = $this->delivery_m->get_all_cust_part_no($start_date, $finish_date, $cust, $ship, $cus_po);
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
            $data['data_delivery'] = $this->delivery_m->select_data_actual_delivery($start_date, $finish_date, $cust, $ship, $cus_po, $cus_part_no);
            $data['all_cust_po'] = $this->delivery_m->get_all_cust_po_by_date_and_customer_and_customer_dest($start_date, $finish_date, $cust, $ship);
            $data['all_customer'] = $this->customer_m->get_all_customer_by_date($start_date, $finish_date);
            $data['all_cust_dest'] = $this->customer_m->get_all_cust_dest_by_date($start_date, $finish_date);
            $data['all_part_no_cust'] = $this->delivery_m->get_all_cust_part_no($start_date, $finish_date, $cust, $ship, $cus_po);
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
            $data['data_delivery'] = $this->delivery_m->select_data_actual_delivery_by_period($period, $cust, $ship, $cus_po, $cus_part_no);
            $data['all_cust_po'] = $this->delivery_m->get_all_cust_po_by_date_and_customer_and_customer_dest_and_period($period, $cust, $ship);
            $data['all_customer'] = $this->customer_m->get_all_customer_by_date_and_period($period);
            $data['all_cust_dest'] = $this->customer_m->get_all_cust_dest_by_date_and_period($period);
            $data['all_part_no_cust'] = $this->delivery_m->get_all_cust_part_no_by_period($period, $cust, $ship, $cus_po);
        }

        $this->load->view($this->layout, $data);
    }

    function print_actual_delivery() {
        ini_set('memory_limit','2048M');
        $this->load->library('excel');

        $cus_po = $this->input->post('CHR_PO_NO_EXCEL');
        $cust = $this->input->post('CHR_CUS_NO_EXCEL');
        $ship = $this->input->post('CHR_SHIP_NO_EXCEL');
        $cus_part_no = $this->input->post('CHR_CUST_PART_NO_EXCEL');
        if ($this->input->post('INT_FLG_STATUS_RADIO_EXCEL') == 'date') {
            $start_date = date('Ymd', strtotime($this->input->post('CHR_START_PERIOD_EXCEL')));
            $finish_date = date('Ymd', strtotime($this->input->post('CHR_END_PERIOD_EXCEL')));
            $data_delivery = $this->delivery_m->select_data_actual_delivery($start_date, $finish_date, $cust, $ship, $cus_po, $cus_part_no);
        }

        if ($this->input->post('INT_FLG_STATUS_RADIO_EXCEL') == 'period') {
            $explode_period = explode('-', $this->input->post('CHR_PERIOD_EXCEL'));
            $period = $explode_period[1] . $explode_period[0];
            $data_delivery = $this->delivery_m->select_data_actual_delivery_by_period($period, $cust, $ship, $cus_po, $cus_part_no);
        }

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Actual Delivery Part");
        $objPHPExcel->getProperties()->setSubject("Report Actual Delivery Part");
        $objPHPExcel->getProperties()->setDescription("Report Actual Delivery Part");
        //Set Properties
        //sheet 1
        $width = 16;
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Actual Delivery Part');
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
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Delivery No');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'PDS No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Cust No');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Cust Desc');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Ship To');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Ship To Desc');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Dock');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'Delivery Date');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'Part No Aisin');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Part No Customer');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'Qty Delivery');

        $e = 4;
        $no = 1;
        foreach ($data_delivery as $row) {
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

        $filename = "Report_Actual_Delivery_Part_Acquired_Date_at-" . date('Ymd') . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //range date
    function update_filter_cust() {
        $start_date = date('Ymd', strtotime($this->input->post('start_date')));
        $finish_date = date('Ymd', strtotime($this->input->post('end_date')));

        $all_customer = $this->customer_m->get_all_customer_by_date($start_date, $finish_date);

        $data = "";
        $data .= "<select name='CHR_CUS_NO' class='ddl3' id='filter_cus' style='height: 30px;width:300px;'>";
        if ($all_customer == 0) {
            $data .= "<option value=0>&nbsp;&nbsp; --Tidak ada Customer--</option>";
        } else {
            foreach ($all_customer as $row) {
                $data .= "<option value=" . trim($row->CHR_CUST_NO) . ">&nbsp;&nbsp;" . trim($row->CHR_CUST_NAME) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    function update_filter_cust_dest() {
        $start_date = date('Ymd', strtotime($this->input->post('start_date')));
        $finish_date = date('Ymd', strtotime($this->input->post('end_date')));

        $all_customer = $this->customer_m->get_all_cust_dest_by_date($start_date, $finish_date);

        $data = "";
        $data .= "<select name='CHR_SHIP_NO' class='ddl3' id='filter_ship' style='height: 30px;width:300px;'>";
        if ($all_customer == 0) {
            $data .= "<option value=0>&nbsp;&nbsp; --Tidak ada Customer--</option>";
        } else {
            foreach ($all_customer as $row) {
                $data .= "<option value=" . trim($row->CHR_CUST_NO) . ">&nbsp;&nbsp;" . trim($row->CHR_CUST_NAME) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    function update_filter_cus_po() {
        $start_date = date('Ymd', strtotime($this->input->post('start_date')));
        $finish_date = date('Ymd', strtotime($this->input->post('end_date')));
        $cust = $this->input->post('cust');
        $ship = $this->input->post('ship');

        $all_cus_po = $this->delivery_m->get_all_cust_po_by_date_and_customer_and_customer_dest($start_date, $finish_date, $cust, $ship);

        $data = "";
        $data .= "<select name='CHR_PO_NO' class='ddl3' id='filter_cus_po' style='height: 30px;width:300px;'>";
        if ($all_cus_po == 0) {
            $data .= "<option value=0>&nbsp;&nbsp; --Tidak ada Cust PO--</option>";
        } else {
            foreach ($all_cus_po as $row) {
                $data .= "<option value=" . trim($row->CHR_PO_NO) . ">&nbsp;&nbsp;" . trim($row->CHR_PO_NO) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    function update_filter_part_no_cust() {
        $start_date = date('Ymd', strtotime($this->input->post('start_date')));
        $finish_date = date('Ymd', strtotime($this->input->post('end_date')));
        $cust = $this->input->post('cust');
        $ship = $this->input->post('ship');
        $cus_po = $this->input->post('cus_po');

        $all_cus_part_no = $this->delivery_m->get_all_cust_part_no($start_date, $finish_date, $cust, $ship, $cus_po);

        $data = "";
        $data .= "<select name='CHR_CUST_PART_NO' id='filter_part_no_cust' class='ddl3' style='height: 30px;width:300px;'>";
        if ($all_cus_part_no == 0) {
            $data .= "<option value=0>&nbsp;&nbsp; --Tidak ada Part No Cust--</option>";
        } else {
            foreach ($all_cus_part_no as $row) {
                $data .= "<option value=" . trim($row->CHR_CUST_PART_NO) . ">&nbsp;&nbsp;" . trim($row->CHR_CUST_PART_NO) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    //periode
    function update_filter_cust_by_period() {
        $explode_period = explode('-', $this->input->post('period'));
        $period = $explode_period[1] . $explode_period[0];

        $all_customer = $this->customer_m->get_all_customer_by_date_and_period($period);

        $data = "";
        $data .= "<select name='CHR_CUS_NO' class='ddl3' id='filter_cus' style='height: 30px;width:300px;'>";
        if ($all_customer == 0) {
            $data .= "<option value=0>&nbsp;&nbsp; --Tidak ada Customer--</option>";
        } else {
            foreach ($all_customer as $row) {
                $data .= "<option value=" . trim($row->CHR_CUST_NO) . ">&nbsp;&nbsp;" . trim($row->CHR_CUST_NAME) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    function update_filter_cust_dest_by_period() {
        $explode_period = explode('-', $this->input->post('period'));
        $period = $explode_period[1] . $explode_period[0];

        $all_customer = $this->customer_m->get_all_cust_dest_by_date_and_period($period);

        $data = "";
        $data .= "<select name='CHR_SHIP_NO' class='ddl3' id='filter_ship' style='height: 30px;width:300px;'>";
        if ($all_customer == 0) {
            $data .= "<option value=0>&nbsp;&nbsp; --Tidak ada Customer--</option>";
        } else {
            foreach ($all_customer as $row) {
                $data .= "<option value=" . trim($row->CHR_CUST_NO) . ">&nbsp;&nbsp;" . trim($row->CHR_CUST_NAME) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    function update_filter_cus_po_by_period() {
        $explode_period = explode('-', $this->input->post('period'));
        $period = $explode_period[1] . $explode_period[0];
        $cust = $this->input->post('cust');
        $ship = $this->input->post('ship');

        $all_cus_po = $this->delivery_m->get_all_cust_po_by_date_and_customer_and_customer_dest_and_period($period, $cust, $ship);

        $data = "";
        $data .= "<select name='CHR_PO_NO' class='ddl3' id='filter_cus_po' style='height: 30px;width:300px;'>";
        if ($all_cus_po == 0) {
            $data .= "<option value=0>&nbsp;&nbsp; --Tidak ada Cust PO--</option>";
        } else {
            foreach ($all_cus_po as $row) {
                $data .= "<option value=" . trim($row->CHR_PO_NO) . ">&nbsp;&nbsp;" . trim($row->CHR_PO_NO) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    function update_filter_part_no_cust_by_period() {
        $explode_period = explode('-', $this->input->post('period'));
        $period = $explode_period[1] . $explode_period[0];
        $cust = $this->input->post('cust');
        $ship = $this->input->post('ship');
        $cus_po = $this->input->post('cus_po');

        $all_cus_part_no = $this->delivery_m->get_all_cust_part_no_by_period($period, $cust, $ship, $cus_po);

        $data = "";
        $data .= "<select name='CHR_CUST_PART_NO' id='filter_part_no_cust' class='ddl3' style='height: 30px;width:300px;'>";
        if ($all_cus_part_no == 0) {
            $data .= "<option value=0>&nbsp;&nbsp; --Tidak ada Part No Cust--</option>";
        } else {
            foreach ($all_cus_part_no as $row) {
                $data .= "<option value=" . trim($row->CHR_CUST_PART_NO) . ">&nbsp;&nbsp;" . trim($row->CHR_CUST_PART_NO) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    //ADD BY IRZA (POLMAN 2023)
    function manange_pn_replacer() {
        
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(375);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Part Number Replacer';

        $data['content'] = 'delivery/manage_part_number_replacer_v';
        $this->load->view($this->layout, $data);
    }

}
