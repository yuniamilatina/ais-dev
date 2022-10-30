<?php

class purchase_order_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('marketing/purchase_order_m');
    }

    public function index() {
        $this->role_module_m->authorization('192');

        $data['title'] = 'Control Status PO';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(192);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'marketing/purchase_order_v';

        $data['all_cust_no'] = $this->purchase_order_m->get_all_cust_no();
        $data['cust_no'] = $this->purchase_order_m->get_first_cust_no();
        $data['all_cust_po'] = $this->purchase_order_m->get_all_cust_po_by_cust($data['cust_no']);
        $data['cust_po'] = $this->purchase_order_m->get_first_cut_po_by_cust($data['cust_no']);
        $data['data_purchase_order'] = $this->purchase_order_m->select_data_purchase_order($data['cust_po'], $data['cust_no']);

        $this->load->view($this->layout, $data);
    }

    public function search_purchase_order() {
        $this->role_module_m->authorization('192');

        $data['title'] = 'Control Status PO';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(192);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'marketing/purchase_order_v';

        $data['cust_po'] = trim($this->input->post('CHR_CUS_PO'));
        $data['cust_no'] = trim($this->input->post('CHR_CUS_NO'));
        $data['all_cust_po'] = $this->purchase_order_m->get_all_cust_po_by_cust($data['cust_no']);
        $data['all_cust_no'] = $this->purchase_order_m->get_all_cust_no();
        $data['data_purchase_order'] = $this->purchase_order_m->select_data_purchase_order($data['cust_po'], $data['cust_no']);

        $this->load->view($this->layout, $data);
    }

    function update_filter() {
        $cust_no = $this->input->post('cust_no');

        $all_cust_po = $this->purchase_order_m->get_all_cust_po_by_cust($cust_no);

        $data = "";
        $data .= "<select name='CHR_CUS_PO' class='ddl3' id='e1' style='height: 30px;width:300px;'>";
        if ($all_cust_po == 0) {
            $data .= "<option value=0 selected>&nbsp;&nbsp; --Tidak ada PO--</option>";
        } else {
            foreach ($all_cust_po as $row) {
                $data .= "<option selected value=" . trim($row->CHR_CUS_PO) . ">&nbsp;&nbsp;" . trim($row->CHR_CUS_PO) . "</option>";
            }
        }
        $data .= "</select>";

        echo $data;
    }

    function print_purchase_order() {
        $this->load->library('excel');

        //$start_date = date('Ymd', strtotime($this->input->post('CHR_START_DATE_EXCEL')));
        //$finish_date = date('Ymd', strtotime($this->input->post('CHR_END_DATE_EXCEL')));
        $cus_po = $this->input->post('CHR_CUS_PO_EXCEL');
        $cus_no = $this->input->post('CHR_CUS_NO_EXCEL');

        $data_purchase_order = $this->purchase_order_m->select_data_purchase_order($cus_po, $cus_no);

// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Status PO");
        $objPHPExcel->getProperties()->setSubject("Report Status PO");
        $objPHPExcel->getProperties()->setDescription("Report Status PO");
//Set Properties
//sheet 1
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Status PO');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(42);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

//SETUP EXCEL
//HEADER
        //$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');

        $objPHPExcel->getActiveSheet()->getStyle("A3:H3")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        //$objPHPExcel->getActiveSheet()->getStyle("A1:B1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        //$objPHPExcel->getActiveSheet()->getStyle("C1:C1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A3:H3")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

//TABLE HEADER
        //$start = date('d-M-Y', strtotime($this->input->post('CHR_START_DATE_EXCEL')));
        //$end = date('d-M-Y', strtotime($this->input->post('CHR_END_DATE_EXCEL')));
        //$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Start Date: ' . $start);
        //$objPHPExcel->getActiveSheet()->setCellValue('C1', 'End Date: ' . $end);
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Part No Cust');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'PO Number');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Dok To');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Quantity PO');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Actual Delivery');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Balance');

        $e = 4;
        $no = 1;
        foreach ($data_purchase_order as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->CHR_CUS_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", $row->CHR_PART_NAME);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_CUS_PO);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_DOK_TO);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->INT_TOT_QTY);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->INT_ACTUAL_DEL);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->INT_BALANCE);
            $e++;
            $no++;
        }
        $e = $e - 1;
        $objPHPExcel->getActiveSheet()->getStyle("A3:H$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Status_PO_Acquired_Date_at-" . date('Ymd') . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}
