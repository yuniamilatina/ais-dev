<?php

class stock_opname_c extends CI_Controller
{

    private $layout = '/template/head';
    private $layout_blank = '/template/head_blank';
    private $back_to_search = 'inventory/stock_opname_c/search_stock_opname/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventory/stock_opname_m');
    }

    public function index($chute = null)
    {
        $this->role_module_m->authorization('187');

        $data['title'] = 'Stock Opname';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(187);
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'inventory/stock_opname_v';

        $data['role'] = $this->session->userdata('ROLE');

        $data['all_chute'] = $this->stock_opname_m->get_chute();

        if ($chute == null || $chute == '') {
            $chute = $this->stock_opname_m->get_top_chute();
        }
        $data['chute'] = $chute;

        //$data['acquired_date'] = $this->stock_opname_m->select_acquired_date();
        $data['data_stock_opname'] = $this->stock_opname_m->select_data_stock_opname($chute);

        $data['data_stock_opname_entry'] = $this->stock_opname_m->select_data_stock_opname_entry();

        $this->load->view($this->layout, $data);
    }

    function prepare_edit_stock_opname($msg = null)
    {
        $this->role_module_m->authorization('187');

        $data['title'] = 'Stock Opname Updater';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(175);
        $data['msg'] = $msg;
        $data['news'] = $this->news_m->get_news();
        $data['content'] = 'inventory/stock_opname_update_v';

        $data['role'] = $this->session->userdata('ROLE');

        $data['all_chute'] = $this->stock_opname_m->get_chute();
        $data['chute'] = $this->stock_opname_m->get_top_chute();

        $data['data_stock_opname'] = $this->stock_opname_m->select_data_stock_opname_by_chute($data['chute']);

        $this->load->view($this->layout_blank, $data);
    }

    function search_stock_opname($chute_id = null, $msg = NULL)
    {
        $this->role_module_m->authorization('187');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } elseif ($msg == 14) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        }

        $data['title'] = 'Stock Opname Updater';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(175);
        $data['news'] = $this->news_m->get_news();
        $data['msg'] = $msg;
        $data['content'] = 'inventory/stock_opname_update_v';

        $data['all_chute'] = $this->stock_opname_m->get_chute();
        $data['chute'] = $chute_id;

        $data['data_stock_opname'] = $this->stock_opname_m->select_data_stock_opname_by_chute($data['chute']);

        $this->load->view($this->layout_blank, $data);
    }

    function edit_stock_opname($no_seri, $partno)
    {

        $no_seri = str_replace('%20', ' ', $no_seri);

        $data['title'] = 'Stock Opname Updater';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(175);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->stock_opname_m->select_data_stock_opname_by_id($no_seri, $partno);

        $data['content'] = 'inventory/edit_stock_opname_v';

        $this->load->view($this->layout, $data);
    }

    function update_stock_opname()
    {
        $part_no_id = $this->input->post("CHR_PART_NO_OLD");
        $back_no_id = $this->input->post("CHR_BACK_NO_OLD");
        $serial = $this->input->post("CHR_SERI");
        $qty = $this->input->post("INT_QTY");
        $multiplier = $this->input->post("INT_BOX");
        $eceran = $this->input->post("INT_ECERAN");
        $backno = $this->input->post("CHR_BACK_NO");
        $partno = $this->input->post("CHR_PART_NO");
        $partname = $this->input->post("CHR_PART_NAME");
        $chute = $this->input->post("CHR_CHUTE");

        $user_session = $this->session->all_userdata();

        $data['Info_Before_Update'] = $part_no_id . '#' . $back_no_id . '#' . $serial;
        $data['NPK_Update'] = $user_session['USERNAME'];
        $data['Tgl_Update'] = date('Ymd');
        $data['Waktu_Update'] = date('His');
        $data['Multiplier'] = $multiplier;
        $data['Eceran'] = $eceran;
        $data['Qty'] = $qty;
        $data['P_Name'] = $partname;

        $id['No_Seri'] = $serial;
        $id['B_No'] = $back_no_id;
        $id['P_No'] = $part_no_id;

        $this->stock_opname_m->update($data, $id);

        redirect($this->back_to_search . $chute . '/' . $msg = 2);
    }

    function print_stock_opname()
    {
        $this->load->library('excel');
        $chute = $this->input->post("CHUTE");

        //$acquired_date = $this->stock_opname_m->select_acquired_date();
        $data_stock_opname = $this->stock_opname_m->select_data_stock_opname($chute);
        $data_stock_opname_entry = $this->stock_opname_m->select_data_stock_opname_entry();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("Report Stock Opname");
        $objPHPExcel->getProperties()->setSubject("Report Stock Opname");
        $objPHPExcel->getProperties()->setDescription("Report Stock Opname");
        //Set Properties
        //sheet 1
        $width = 8;
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Scan Result');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(16);

        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('H1:K1');

        $objPHPExcel->getActiveSheet()->getStyle("A3:O3")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("H1:K1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Acquired Date: ' . date("d-m-Y"));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Sloc');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Qty');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Box');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Eceran');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Total Qty');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', 'Sub Area');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', 'Chute');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Status Sto');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', 'Scanned by');
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'Scanned Date');
        $objPHPExcel->getActiveSheet()->setCellValue('O3', 'Scanned Time');
        $objPHPExcel->getActiveSheet()->setCellValue('P3', 'Doc');

        $e = 4;
        $no = 1;
        foreach ($data_stock_opname as $row) {
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->P_No);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("C$e", $row->P_Name, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->B_No);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->S_Location);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->Qty);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->Multiplier);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->eceran);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->sum_total);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $row->SUBAREA);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $row->Chute);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", "Scan");
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $row->username);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $row->Tgl);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $row->Waktu);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $row->CHR_ID_DOC);
            $e++;
            $no++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A3:P$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


        //sheet 1
        $subtitle = 1;
        $second_data = 3;
        $width = 8;
        $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('Entry Result');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth($width);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(16);

        //SETUP EXCEL
        //HEADER
        $objPHPExcel->getActiveSheet()->mergeCells("A$subtitle:D$subtitle");
        $objPHPExcel->getActiveSheet()->mergeCells("H$subtitle:K$subtitle");

        $objPHPExcel->getActiveSheet()->getStyle("A$second_data:U$second_data")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("A$subtitle:D$subtitle")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle("H$subtitle:K$subtitle")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //TABLE HEADER
        $objPHPExcel->getActiveSheet()->setCellValue("A$subtitle", 'Acquired Date: ' . date("d-m-Y"));
        $objPHPExcel->getActiveSheet()->setCellValue("A$second_data", 'No.');
        $objPHPExcel->getActiveSheet()->setCellValue("B$second_data", 'Part No');
        $objPHPExcel->getActiveSheet()->setCellValue("C$second_data", 'Part Name');
        $objPHPExcel->getActiveSheet()->setCellValue("D$second_data", 'Back No');
        $objPHPExcel->getActiveSheet()->setCellValue("E$second_data", 'Sloc');
        $objPHPExcel->getActiveSheet()->setCellValue("F$second_data", 'Qty');
        $objPHPExcel->getActiveSheet()->setCellValue("G$second_data", 'Box');
        $objPHPExcel->getActiveSheet()->setCellValue("H$second_data", 'Eceran');
        $objPHPExcel->getActiveSheet()->setCellValue("I$second_data", 'Total Qty');
        $objPHPExcel->getActiveSheet()->setCellValue("J$second_data", 'Uom');
        $objPHPExcel->getActiveSheet()->setCellValue("K$second_data", 'Address');
        $objPHPExcel->getActiveSheet()->setCellValue("L$second_data", 'Page');
        $objPHPExcel->getActiveSheet()->setCellValue("M$second_data", 'No of Page');
        $objPHPExcel->getActiveSheet()->setCellValue("N$second_data", 'Sub Area');
        $objPHPExcel->getActiveSheet()->setCellValue("O$second_data", 'Chute');
        $objPHPExcel->getActiveSheet()->setCellValue("P$second_data", 'lso_qty_box');
        $objPHPExcel->getActiveSheet()->setCellValue("Q$second_data", 'lso_qty_eceran');
        $objPHPExcel->getActiveSheet()->setCellValue("R$second_data", 'lso_acc_qty_box');
        $objPHPExcel->getActiveSheet()->setCellValue("S$second_data", 'lso_acc_qty_eceran');
        $objPHPExcel->getActiveSheet()->setCellValue("T$second_data", 'lso_acc_total');
        $objPHPExcel->getActiveSheet()->setCellValue("U$second_data", 'lso_acc_diff');

        $e = 4;
        $no = 1;
        foreach ($data_stock_opname_entry as $row) {
            $total = ($row->lso_amount_pcs_in_box * $row->lso_amount_box) + $row->lso_amount_pcs;
            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", $row->lso_back_no);
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", $row->lso_no_sap);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->lso_part_name);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->lso_sloc);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->lso_amount_pcs_in_box);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->lso_amount_box);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->lso_amount_pcs);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $total);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $row->lso_unit);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $row->lso_address);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $row->lso_page);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $row->no_of_page);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $row->lso_area);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $row->lso_area_sto);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $row->Iso_qty_box);
            $objPHPExcel->getActiveSheet()->setCellValue("Q$e", $row->Iso_qty_eceran);
            $objPHPExcel->getActiveSheet()->setCellValue("R$e", $row->lso_acc_qty_box);
            $objPHPExcel->getActiveSheet()->setCellValue("S$e", $row->lso_acc_qty_eceran);
            $objPHPExcel->getActiveSheet()->setCellValue("T$e", $row->lso_acc_total);
            $objPHPExcel->getActiveSheet()->setCellValue("U$e", $row->lso_acc_diff);
            $e++;
            $no++;
        }

        $objPHPExcel->getActiveSheet()->getStyle("A$second_data:U$e")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $filename = "Report_Stock_Opname_Acquired_Date_at-" . date("d-m-Y") . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function weekly_sto()
    {
        $data['title'] = 'Report Weekly Stokc Opname';
        $data['content'] = 'inventory/stock_opname_weekl_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(241);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post("filter") == 1) {
            $date_from = date("Ymd", strtotime($this->input->post("CHR_DATE_FROM")));
            $date_to = date("Ymd", strtotime($this->input->post("CHR_DATE_TO")));
        } else {
            $date_from = date("Ymd");
            $date_to = date("Ymd");
        }

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;


        $data['data_sto'] = $this->stock_opname_m->get_weekly_sto($date_from, $date_to);
        $this->load->view($this->layout, $data);
    }
}
