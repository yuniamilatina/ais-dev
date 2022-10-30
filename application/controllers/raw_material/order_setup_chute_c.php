<?php

class order_setup_chute_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'raw_material/order_setup_chute_c/index/';
    //private $back_to_approve = 'helpdesk_ticket/helpdesk_ticket_c/prepare_approve_ticket/';

    public function __construct() {
        parent::__construct();
        $this->load->model('raw_material/raw_material_m');
        $this->load->model('basis/log_m');
        $this->load->model('basis/role_module_m');

        //$this->load->model('helpdesk_ticket/problem_type_m');
        //$this->load->model('helpdesk_ticket/prover_m');
        $this->load->model('portal/news_m');
        $this->load->model('portal/notification_m');
    }

    function index($msg = NULL,$start_date = null, $finish_date = null) {
        $this->role_module_m->authorization('33');

        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 4) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Data Already Exist !</strong> Silahkan input data part yang lainnya</div >";
        }
        if ($this->input->post('btn_submit')) {
            $start_date = $this->input->post('start_date');
            $finish_date = $this->input->post('finish_date');
            $start_date = date("Ymd", strtotime($start_date));
            $finish_date = date("Ymd", strtotime($finish_date));
        }
        if ($start_date == null and $finish_date == null) {
            $start_date = date("Ymd");
            $finish_date = date("Ymd");
        } elseif ($start_date == null) {
            $start_date = date("Ymd");
        } elseif ($finish_date == null) {
            $finish_date = date("Ymd");
        }
        
        $data['start_date'] = date("d-m-Y", strtotime($start_date));
        $data['finish_date'] = date("d-m-Y", strtotime($finish_date));
        $data['msg'] = $msg;
        $data['data'] = $this->raw_material_m->get_data_order_fg($start_date, $finish_date);
        $data['content'] = 'raw_material/data_order_digital_setup_fg_v';
        $data['title'] = 'Data Order Setup Chute Digital';
        $data['app'] = $this->role_module_m->get_app();
        $data['news'] = $this->news_m->get_news();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(255);
        $data['news'] = $this->news_m->get_news();
        
        $this->load->view($this->layout, $data);
    }
    
    function view_data_order($id) {
        $data['content'] = 'raw_material/view_order_digital_setup_fg';
        $data['title'] = 'View Data Order Setup Chute Digital';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(255);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->raw_material_m->get_data_by_id($id);

        $this->load->view($this->layout, $data);
    }
    
    function update_data_per_model() {
        $this->form_validation->set_rules('CHR_STD', 'Std Day', 'required|integer|char|max_length[4]|min_length[1]');
        $this->form_validation->set_rules('CHR_LOT', 'Lot Size', 'required|integer|char|max_length[4]|min_length[1]');
        $this->form_validation->set_rules('CHR_MIN', 'Stk Min', 'required|integer|char|max_length[4]|min_length[1]');
        
        $pno = $this->input->post('CHR_PNO');
        $pno = trim($pno);
//        $bno = $this->input->post('CHR_BNO');
        $std = $this->input->post('CHR_STD');
        $lot = $this->input->post('CHR_LOT');
        $min = $this->input->post('CHR_MIN');
//        $flag= strtoupper($flag);
        
        if ($this->form_validation->run() == FALSE) {
            $this->edit_data_per_model($pno);
        } else {
            $data_array = array(
                'CHR_LOTSIZE' => $lot,                
                'CHR_STDDAY' => $std,
                'CHR_STK_MIN' => $min
            );

            $this->raw_material_m->update($data_array, $pno);
            redirect($this->back_to_manage . $msg = 2);
        }
    }
    
    function create_backno_subcont() {
        $this->role_module_m->authorization('33');

        $data['content'] = 'raw_material/create_backno_subcont_v';
        $data['title'] = 'Create Back No Subcont';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(194);
        $data['news'] = $this->news_m->get_news();

        //$data['data_problem_type'] = $this->problem_type_m->get_problem_type();
        //$data['data_prover'] = $this->prover_m->get_prover();

        $this->load->view($this->layout, $data);
    }

    function save_backno_subcont() {
        $this->load->model('basis/user_m');
        $date = date("Ymd");
        $time = date("His");
        //$session = $this->session->all_userdata();

        $this->form_validation->set_rules('CHR_BACKNO', 'Back No Subcont', 'required|trim|min_length[1]|max_length[4]|');
        //$this->form_validation->set_rules('CHR_ASSET_NAME', 'Asset name', 'required|trim|min_length[5]|max_length[20]|');

        //$id_ticket = $this->helpdesk_ticket_m->generate_id_helpdesk_ticket();

        if ($this->form_validation->run() == FALSE) {
            $this->create_backno_subcont();
        } else {
            $data = array(
                //'INT_ID_TICKET' => $id_ticket,
                //'CHR_PROBLEM_TITLE' => $this->input->post('CHR_PROBLEM_TITLE'),
                'CHR_BACK_NO' => $this->input->post('CHR_BACKNO'),
                'BIT_FLG_DEL' => 0,
                'CHR_CREATE_DATE' => $date,
                'CHR_CREATE_TIME' => $time
                
            );
            $this->db->trans_start();
            $this->raw_material_m->save_backno_subcont($data);
            //$this->log_m->add_log('84', $id_ticket);
            $this->db->trans_complete();
            redirect($this->back_to_manage . $msg = 1);
        }
    }

    function delete_backno_subcont() {
        $this->role_module_m->authorization('33');
        $id = $this->input->get('id');
        $this->db->trans_start();
        $this->raw_material_m->delete_backno_subcont($id);
        //$this->log_m->add_log('86', $id);
        $this->db->trans_complete();
        redirect($this->back_to_manage . $msg = 3);
    }

    public function print_helpdesk_ticket($no_ticket) {
        $this->load->library('fpdf17/fpdf');

        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
        $this->load->model('helpdesk_ticket/problem_type_m');
        $this->load->model('helpdesk_ticket/prover_m');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/user_m');

        $session = $this->session->all_userdata();
        $head = $this->helpdesk_ticket_m->get_data_helpdesk_ticket($no_ticket)->row();

        $this->fpdf->Open();
        $pdf = new FPDF("P", "cm", "A4");
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->SetDrawColor(0);

        $pdf->Cell(19, 0.7, 'PT AISIN INDONESIA', 0, 0, 'C');

        $pdf->Ln();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(19, 0.7, 'Ejip Industrial Park Plot 5J Cikarang Selatan - Bekasi', 0, 0, 'C');


        /* Fungsi Line untuk membuat garis */
        $pdf->Line(1, 2.5, 20, 2.5);

        $pdf->Ln(1);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(19, 1, 'HELPDESK TICKET', 0, 0, 'C');

        $pdf->Ln(1);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(15, 1, 'NPK : ' . $head->CHR_NPK, 0, 0, 'L');
        $pdf->Cell(15, 1, 'DEPARTMENT : ' . $head->CHR_DEPT, 0, 0, 'L');

        $start_date = date("d/M/Y h:i", strtotime($head->DAT_START_DATE));

        $pdf->Ln();
        $pdf->Cell(15, 0.2, 'TICKET NO : ' . $head->INT_ID_TICKET, 0, 0, 'L');
        $pdf->Cell(15, 0.2, 'DATE : ' . $start_date, 0, 0, 'L');

        $pdf->Ln(1);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(5, 0.2, 'PROBLEM TITLE : ' . trim($head->CHR_ASSET_NAME) . "-" . trim($head->CHR_PROBLEM_TITLE) . "[ " . trim($head->CHR_PROBLEM_TYPE_DESC) . "] ", 0, 0, 'L');
        $pdf->Ln(1);
        $pdf->Cell(5, 0.2, 'DESCRIPTION : ' . trim($head->CHR_PROBLEM_DESC), 0, 0, 'L');

        /* setting posisi footer 3 cm dari bawah */
        $pdf->SetY(-3);

        /* setting font untuk footer */
        $pdf->SetFont('helvetica', '', 10);

        /* setting cell untuk waktu pencetakan */
        $pdf->Cell(9.5, 0.5, 'Printed on : ' . date('d/m/Y H:i') . ' | Created by : ' . $session['USERNAME'] . '', 0, 'LR', 'L');

        /* setting cell untuk page number */
        $pdf->Cell(9.5, 0.5, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 0, 'R');

        /* generate pdf jika semua konstruktor, data yang akan ditampilkan, dll sudah selesai */
        $filename = trim($head->CHR_NPK) . "|" . trim($head->CHR_DEPT) . "|" . trim($head->DAT_START_DATE) . ".pdf";
        $pdf->Output($filename, 'I');
    }

    //    function print_helpdesk_ticke1t($no_ticket) {
    //        $this->load->library('PHPExcel');
    //
		//        $this->load->model('helpdesk_ticket/problem_type_m');
    //        $this->load->model('helpdesk_ticket/prover_m');
    //        $this->load->model('organization/dept_m');
    //        $this->load->model('basis/user_m');
    //        $objTpl = PHPExcel_IOFactory::load('./assets/template/ticketing.xls');
    //
		//        $data = $this->helpdesk_ticket_m->get_data_helpdesk_ticket($no_ticket)->row();
    //
		//        $objTpl->setActiveSheetIndex(0);
    //
		//        $objTpl->getActiveSheet()->setCellValue('C2', trim($data->CHR_NPK));
    //        $objTpl->getActiveSheet()->setCellValue('C3', trim($data->CHR_DEPT));
    //        $objTpl->getActiveSheet()->setCellValue("H2", $data->INT_ID_TICKET);
    //        $objTpl->getActiveSheet()->setCellValue("H3", trim($data->CHR_PROBLEM_TYPE_DESC));
    //        $objTpl->getActiveSheet()->setCellValue("H4", date('d-M-Y'));
    //        $objTpl->getActiveSheet()->setCellValue("C6", trim($data->CHR_ASSET_NAME) . " " . trim($data->CHR_PROBLEM_TITLE));
    //        $objTpl->getActiveSheet()->setCellValue("C7", trim($data->CHR_PROBLEM_DESC));
    //        $objTpl->getActiveSheet()->setCellValue("C14", trim($data->CHR_CREATE_DATE));
    //
		//        $filename = $no_ticket . "/" . trim($data->CHR_CREATE_DATE) . "/" . trim($data->CHR_DEPT) . ".xls";
    //
		//        ob_end_clean();
    //        header('Content-Type: application/vnd.ms-excel');
    //        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
    //        header('Cache-Control: max-age=0');
    //
		//        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
    //        $objWriter->save('php://output');
    //    }

    function print_report_helpdesk_ticket_by_dept() {
        $this->role_module_m->authorization('38');
        $this->load->library('PHPExcel');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/user_m');
        $objTpl = PHPExcel_IOFactory::load('./assets/template/rpt_helpdesk_ticket.xls');

        $this->form_validation->set_rules('INT_ID_DEPT', 'Department', 'required');

        $month = $this->input->post('INT_MONTH');
        $year = $this->input->post('INT_YEAR');
        $id_dept = $this->input->post('INT_ID_DEPT');

        if ($this->input->post('INT_ID_DEPT') == NULL) {

            $date = $year . $month;
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_date($date);
            //echo var_dump($this->helpdesk_ticket_m->get_helpdesk_ticket_by_date($date));exit();
            $param = '';
            $param_detail = '';
            $filename = trim($year) . "/" . $month . ".xls";
        } else {

            $date = $year . "-" . $month;
            //echo $this->input->post('INT_ID_DEPT'); exit();
            $test = $this->input->post('INT_ID_DEPT');
            //echo $date; exit();
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_dept($test, $date);
            //echo var_dump($this->helpdesk_ticket_m->get_helpdesk_ticket_by_dept("21", $date)); exit();
            //	echo var_dump($data);exit();
            $param = 'DEPARTMENT :';
            $param_detail = $this->dept_m->get_desc_dept($id_dept);
            $filename = trim($year) . "/" . $month . "/" . $id_dept . ".xls";
        }

        if ($month == '01') {
            $full_month = 'JANUARY';
        } else if ($month == '02') {
            $full_month = 'FEBRUARY';
        } else if ($month == '03') {
            $full_month = 'MARCH';
        } else if ($month == '04') {
            $full_month = 'APRIL';
        } else if ($month == '05') {
            $full_month = 'MAY';
        } else if ($month == '06') {
            $full_month = 'JUNE';
        } else if ($month == '07') {
            $full_month = 'JULY';
        } else if ($month == '08') {
            $full_month = 'AUGUST';
        } else if ($month == '09') {
            $full_month = 'SEPTEMBER';
        } else if ($month == '10') {
            $full_month = 'OCTOBER';
        } else if ($month == '11') {
            $full_month = 'SEPTEMBER';
        } else if ($month == '12') {
            $full_month = 'DECEMBER';
        }

        $objTpl->setActiveSheetIndex(0);
        $objTpl->getActiveSheet()->setCellValue('A2', 'LAPORAN HELPDESK TICKET :' . $full_month . '/' . $year);
        $objTpl->getActiveSheet()->setCellValue('A3', $param . $param_detail);

        $e = 5;
        $jum = 1;
        foreach ($data as $row) {
            //echo $finishtime = substr($row->DAT_FINISH_DATE,12,8)." ".substr($row->DAT_FINISH_DATE,24,2); exit();
            $startdate = substr($row->DAT_START_DATE, 0, 11);
            $starttime = substr($row->DAT_START_DATE, 12, 8) . " " . substr($row->DAT_START_DATE, 24, 2);
            $finishdate = substr($row->DAT_FINISH_DATE, 0, 11);
            $finishtime = substr($row->DAT_FINISH_DATE, 12, 8) . " " . substr($row->DAT_FINISH_DATE, 24, 2);

            if ($row->INT_STATUS == "0") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Wait Approve";
            } else if ($row->INT_STATUS == "1") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Waiting";
            } else if ($row->INT_STATUS == "5") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Pending";
            } else if ($row->INT_STATUS == "2") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Progress";
            } else if ($row->INT_STATUS == "4") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Rejected";
            } else {
                $status1 = "Solved";
            }

            $objTpl->getActiveSheet()->setCellValue("A$e", $jum);
            $objTpl->getActiveSheet()->setCellValue("B$e", trim($row->CHR_USERNAME));
            $objTpl->getActiveSheet()->setCellValue("C$e", trim($row->INT_ID_TICKET));
            $objTpl->getActiveSheet()->setCellValue("D$e", trim($row->CHR_PROBLEM_TYPE_DESC));
            $objTpl->getActiveSheet()->setCellValue("E$e", trim($row->CHR_ASSET_NAME));
            $objTpl->getActiveSheet()->setCellValue("F$e", trim($row->CHR_PROBLEM_TITLE));
            $objTpl->getActiveSheet()->setCellValue("G$e", trim($row->CHR_PROBLEM_DESC));
            $objTpl->getActiveSheet()->setCellValue("H$e", trim($startdate));
            $objTpl->getActiveSheet()->setCellValue("I$e", trim($starttime));
            $objTpl->getActiveSheet()->setCellValue("J$e", trim($finishdate));
            $objTpl->getActiveSheet()->setCellValue("K$e", trim($finishtime));
            $objTpl->getActiveSheet()->setCellValue("L$e", trim($status1));
            $objTpl->getActiveSheet()->setCellValue("M$e", trim($row->CHR_PROVER_DESC));
            $objTpl->getActiveSheet()->setCellValue("N$e", trim($row->CHR_DEPT_DESC));

            $e = $e + 1;
            $jum = $jum + 1;
        }

        //sheet2
        if ($this->input->post('INT_ID_DEPT') == NULL) {

            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_group_by_dept($date);
            $filename = trim($year) . "/" . $month . ".xls";
        } else {

            $date = $year . $month;
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_group_by_dept1($date);
            //echo var_dump($data);exit();
            $filename = trim($year) . "/" . $month . ".xls";
        }

        //echo $this->input->post('INT_ID_DEPT'); 

        $objTpl->setActiveSheetIndex(1);
        $objTpl->getActiveSheet()->setCellValue('A2', 'LAPORAN HELPDESK TICKET :' . $full_month . '/' . $year);
        $objTpl->getActiveSheet()->setCellValue('A4', 'Department');
        $pol = $this->input->post('INT_ID_DEPT');
        $el = 5;
        foreach ($data as $row) {
            if ($row->INT_ID_DEPT == $pol) {
                $objTpl->getActiveSheet()->setCellValue("A$el", trim($row->CHR_DEPT));
                $objTpl->getActiveSheet()->setCellValue("B$el", trim($row->total));
                $el = $el + 1;
            }
        }

        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
        $objWriter->save('php://output');
    }

    function print_report_helpdesk_ticket_by_type() {
        $this->role_module_m->authorization('38');
        $this->load->library('PHPExcel');
        $this->load->model('helpdesk_ticket/problem_type_m');
        $this->load->model('basis/user_m');
        $objTpl = PHPExcel_IOFactory::load('./assets/template/rpt_helpdesk_ticket.xls');

        //$this->form_validation->set_rules('INT_ID_PROBLEM_TYPE', 'Type of Problem', 'required');

        $month = $this->input->post('INT_MONTH');
        $year = $this->input->post('INT_YEAR');
        $id_problem_type = $this->input->post('INT_ID_PROBLEM_TYPE');
        $date = $year . $month;
        //echo $this->input->post('INT_ID_PROBLEM_TYPE'); exit();
        if ($this->input->post('INT_ID_PROBLEM_TYPE') == NULL) {
            $date = $year . $month;
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_date($date);
            $param = '';
            $param_detail = '';
            $filename = trim($year) . "/" . $month . ".xls";
        } else {
            $date = $year . "-" . $month;
            $type = $this->input->post('INT_ID_PROBLEM_TYPE');
            //echo $date; exit();
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_by_problem($type, $date);
            $param = 'TYPE OF PROBLEM :';
            $param_detail = $this->problem_type_m->get_desc_problem_type($id_problem_type);
            //echo $this->input->post('INT_ID_PROBLEM_TYPE'); exit();
            $filename = trim($year) . "/" . $month . "/" . $id_problem_type . ".xls";
        }

        //        if ($this->form_validation->run() == FALSE) {
        //            $this->prepare_report_ticket();
        //        } else {


        if ($month == '01') {
            $full_month = 'JANUARY';
        } else if ($month == '02') {
            $full_month = 'FEBRUARY';
        } else if ($month == '03') {
            $full_month = 'MARCH';
        } else if ($month == '04') {
            $full_month = 'APRIL';
        } else if ($month == '05') {
            $full_month = 'MAY';
        } else if ($month == '06') {
            $full_month = 'JUNE';
        } else if ($month == '07') {
            $full_month = 'JULY';
        } else if ($month == '08') {
            $full_month = 'AUGUST';
        } else if ($month == '09') {
            $full_month = 'SEPTEMBER';
        } else if ($month == '10') {
            $full_month = 'OCTOBER';
        } else if ($month == '11') {
            $full_month = 'SEPTEMBER';
        } else if ($month == '12') {
            $full_month = 'DECEMBER';
        }

        $objTpl->setActiveSheetIndex(0);

        $objTpl->getActiveSheet()->setCellValue('A2', 'LAPORAN HELPDESK TICKET :' . $full_month . '/' . $year);
        $objTpl->getActiveSheet()->setCellValue('A3', $param . $param_detail);

        $e = 5;
        $jum = 1;
        foreach ($data as $row) {

            //echo var_dump($row);exit();
            $startdate = substr($row->DAT_START_DATE, 0, 11);
            $starttime = substr($row->DAT_START_DATE, 12, 8) . " " . substr($row->DAT_START_DATE, 24, 2);
            $finishdate = substr($row->DAT_FINISH_DATE, 0, 11);
            $finishtime = substr($row->DAT_FINISH_DATE, 12, 8) . " " . substr($row->DAT_FINISH_DATE, 24, 2);

            //if($finishdate == ""){
            //	$finishdate = "-";
            //	$finishtime = "-";
            //	$status1 = "Pending";
            //} else {
            //	$status1 = "";
            //}

            if ($row->INT_STATUS == "0") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Wait Approve";
            } else if ($row->INT_STATUS == "1") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Waiting";
            } else if ($row->INT_STATUS == "5") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Pending";
            } else if ($row->INT_STATUS == "2") {
                $finishdate = "-";
                $finishtime = "-";
                $status1 = "Progress";
            } else if ($row->INT_STATUS == "4") {
                $status1 = "Rejected";
            } else {
                $status1 = "Solved";
            }



            $objTpl->getActiveSheet()->setCellValue("A$e", $jum);
            $objTpl->getActiveSheet()->setCellValue("B$e", trim($row->CHR_USERNAME));
            $objTpl->getActiveSheet()->setCellValue("C$e", trim($row->INT_ID_TICKET));
            $objTpl->getActiveSheet()->setCellValue("D$e", trim($row->CHR_PROBLEM_TYPE_DESC));
            $objTpl->getActiveSheet()->setCellValue("E$e", trim($row->CHR_ASSET_NAME));
            $objTpl->getActiveSheet()->setCellValue("F$e", trim($row->CHR_PROBLEM_TITLE));
            $objTpl->getActiveSheet()->setCellValue("G$e", trim($row->CHR_PROBLEM_DESC));
            $objTpl->getActiveSheet()->setCellValue("H$e", trim($startdate));
            $objTpl->getActiveSheet()->setCellValue("I$e", trim($starttime));
            $objTpl->getActiveSheet()->setCellValue("J$e", trim($finishdate));
            $objTpl->getActiveSheet()->setCellValue("K$e", trim($finishtime));
            $objTpl->getActiveSheet()->setCellValue("L$e", trim($status1));
            $objTpl->getActiveSheet()->setCellValue("M$e", trim($row->CHR_PROVER_DESC));
            $objTpl->getActiveSheet()->setCellValue("N$e", trim($row->CHR_DEPT_DESC));

            $e = $e + 1;
            $jum = $jum + 1;
        }

        //sheet2
        if ($this->input->post('INT_ID_PROBLEM_TYPE') == NULL) {
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_group_by_type($date);
            $filename = trim($year) . "/" . $month . ".xls";
        } else {

            $date = $year . $month;
            $data = $this->helpdesk_ticket_m->get_helpdesk_ticket_group_by_type1($date);
            //echo var_dump($data);exit();
            $filename = trim($year) . "/" . $month . ".xls";
        }

        $objTpl->setActiveSheetIndex(1);
        $objTpl->getActiveSheet()->setCellValue('A2', 'LAPORAN HELPDESK TICKET :' . $full_month . '/' . $year);
        $objTpl->getActiveSheet()->setCellValue('A4', 'Type of Problem');
        $pol = $this->input->post('INT_ID_PROBLEM_TYPE');
        $el = 5;
        foreach ($data as $row) {
            if ($row->INT_ID_PROBLEM_TYPE == $pol) {
                $objTpl->getActiveSheet()->setCellValue("A$el", trim($row->CHR_PROBLEM_TYPE_DESC));
                $objTpl->getActiveSheet()->setCellValue("B$el", trim($row->total));
                $el = $el + 1;
            }
        }

        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . trim($filename) . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');
        $objWriter->save('php://output');
        //}
    }

    function prepare_report_ticket() {
        $this->role_module_m->authorization('35');
        $this->load->model('organization/dept_m');

        $data['data_problem_type'] = $this->problem_type_m->get_problem_type();
        $data['data_dept'] = $this->dept_m->get_dept();

        $data['data'] = $this->helpdesk_ticket_m->get_close_helpdesk_ticket();
        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/report_helpdesk_ticket_v';

        $data['title'] = 'Report Helpdesk Ticket';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(35);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    function get_latest_ticket() {
        $this->load->model('helpdesk_ticket/helpdesk_ticket_m');

        $data['data_problem_type'] = $this->problem_type_m->get_problem_type();
        $data['data_dept'] = $this->dept_m->get_dept();

        $data['data'] = $this->helpdesk_ticket_m->get_close_helpdesk_ticket();
        $data['content'] = 'helpdesk_ticket/helpdesk_ticket/report_helpdesk_ticket_v';

        $data['title'] = 'Report Helpdesk Ticket';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(35);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

}
