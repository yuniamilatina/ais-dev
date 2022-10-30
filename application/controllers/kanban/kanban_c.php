<?php

class kanban_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'kanban/kanban_c/index/';
    private $layout_blank = '/template/head_blank';
    public function __construct() {
        parent::__construct();
        $this->load->model('kanban/kanban_m');
    }

    function index($msg = NULL) {
        $this->role_module_m->authorization('3');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        // $data['data'] = $this->kanban_m->get_all_kanban();
        $data['content'] = 'kanban/manage_kanban_v';
        $data['title'] = 'Manage Kanban';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(188);

        $this->load->view($this->layout, $data);
    }

    function refresh_table() {
        $FILTER = $this->input->post("FILTER");
        $FILTER = str_replace(' ', '_', $FILTER);
        $url_iframe = site_url("kanban/kanban_c/refresh_table_page/$FILTER");
                

        $data = array(
            'url_iframe' => $url_iframe
        );

//====== Either you can print value or you can send value to database
        echo json_encode($data);
    }

    function refresh_table_page( $FILTER = null, $msg=null) {
        $this->role_module_m->authorization('3');
        $user_session = $this->session->all_userdata();
        $FILTER = str_replace('_', ' ', $FILTER);
        $data['FILTER'] = $FILTER;
       
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-warning'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Choosing failed </strong> You must select at least one data</div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something error with parameter </div >";
        }
        $data['msg'] = $msg;
        $data['data'] = $this->kanban_m->get_filter_kanban($FILTER);
        $data['title'] = 'Manage Kanban';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(188); 

        // $data['data'] = $this->spare_parts_rack_m->get_rack_filter($FILTER);
        //$data['data'] = $this->spare_parts_m->get_rack_filter($INT_ID_OPT_WCENTER,$FILTER);

        // $pic = $this->session->userdata('NPK');
        $data['content'] = 'kanban/refresh_manage_kanban_v';
        
          

        $this->load->view($this->layout_blank, $data);
    }

    function print_kanban() {
        $this->load->library('excel');
        $get_data_kanban = $this->kanban_m->get_all_kanban();

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set properties
        $objPHPExcel->getProperties()->setCreator(trim('KANBAN MASTER'));
        $objPHPExcel->getProperties()->setLastModifiedBy(trim($this->session->userdata('USERNAME')));
        $objPHPExcel->getProperties()->setTitle("KANBAN MASTER");
        $objPHPExcel->getProperties()->setSubject("KANBAN MASTER");
        $objPHPExcel->getProperties()->setDescription("KANBAN MASTER");
        // Set Properties
        
        //SETUP EXCEL
        $width = 14;
        $objPHPExcel->setActiveSheetIndex();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->setTitle('STO List'); //sheetname

        //SETUP EXCEL
        //HEADER
        $worksheet->setCellValue('A1', 'KANBAN MASTER');
        //$worksheet->getStyle("B1:D1")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        //HEADER
        //TABLE PRODUCTION QTY
        $worksheet->getStyle("A2:P2")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFFF');

        $worksheet->setCellValue('A2', 'No.');
        $worksheet->setCellValue('B2', 'Part No');
        $worksheet->setCellValue('C2', 'Back No');
        $worksheet->setCellValue('D2', 'Kanban type');
        $worksheet->setCellValue('E2', 'WC Vendor');
        $worksheet->setCellValue('F2', 'Sloc From');
        $worksheet->setCellValue('G2', 'Sloc To');
        $worksheet->setCellValue('H2', 'Box Type');
        $worksheet->setCellValue('I2', 'Qty Per Box');
        $worksheet->setCellValue('J2', 'Cust Part No');
        $worksheet->setCellValue('K2', 'Last Serial');
        $worksheet->setCellValue('L2', 'Side');
        $worksheet->setCellValue('M2', 'Created Date');
        $worksheet->setCellValue('N2', 'Changed Time');
        $worksheet->setCellValue('O2', 'Deleted Date');
        $worksheet->setCellValue('P2', 'Deleted Flag');

        $e = 3;
        $no = 1;
        foreach ($get_data_kanban as $row) {
            $date_create = date("d-m-Y", strtotime($row->CHR_DATE_CREATE));
            $date_change = date("d-m-Y", strtotime($row->CHR_DATE_CHANGE));
            $date_delete = date("d-m-Y", strtotime($row->CHR_DATE_DEL));

            $objPHPExcel->getActiveSheet()->setCellValue("A$e", $no);
            $objPHPExcel->getActiveSheet()->setCellValue("B$e", trim($row->CHR_PART_NO));
            $objPHPExcel->getActiveSheet()->setCellValue("C$e", $row->CHR_BACK_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("D$e", $row->CHR_KANBAN_TYPE);
            $objPHPExcel->getActiveSheet()->setCellValue("E$e", $row->CHR_WC_VENDOR);
            $objPHPExcel->getActiveSheet()->setCellValue("F$e", $row->CHR_SLOC_FROM);
            $objPHPExcel->getActiveSheet()->setCellValue("G$e", $row->CHR_SLOC_TO);
            $objPHPExcel->getActiveSheet()->setCellValue("H$e", $row->CHR_BOX_TYPE);
            $objPHPExcel->getActiveSheet()->setCellValue("I$e", $row->INT_QTY_PER_BOX);
            $objPHPExcel->getActiveSheet()->setCellValue("J$e", $row->CHR_CUST_PART_NO);
            $objPHPExcel->getActiveSheet()->setCellValue("K$e", $row->INT_LAST_SERIAL);
            $objPHPExcel->getActiveSheet()->setCellValue("L$e", $row->CHR_SIDE);
            $objPHPExcel->getActiveSheet()->setCellValue("M$e", $date_create);
            $objPHPExcel->getActiveSheet()->setCellValue("N$e", $date_change);
            $objPHPExcel->getActiveSheet()->setCellValue("O$e", $date_delete);
            $objPHPExcel->getActiveSheet()->setCellValue("P$e", $row->CHR_FLAG_DELETE);
            $e++;
            $no++;
        }

        $filename = 'Master_kanban_Date_' . date("Ymd") . ".xlt";
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
    }

}
