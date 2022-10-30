<?php

class coil_used_c extends CI_Controller
{
    /* -- define constructor -- */

    private $layout = '/template/head';
    private $back_to_manage = 'raw_material/coil_used_c/new_coil_used/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('raw_material/coil_used_m');
        $this->load->model('goods_movement/goods_movement_l_m');
        $this->load->model('goods_movement/goods_movement_h_m');
        $this->load->config('pdf_config');
        $this->load->library('fpdf/fpdf');
        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
    }

    public function new_coil_used($period = null, $msg = NULL)
    {

        if ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success </strong> The data is successfully updated </div >";
        }

        $data['msg'] = $msg;
        $data['title'] = 'Coil Used';
        $data['content'] = 'raw_material/coil_used/coil_used_new_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(235);
        $data['news'] = $this->news_m->get_news();

        if ($period == null) {
            $period = date('Ym');
        }

        $data['period'] = $period;
        $data['data_coil'] = $this->coil_used_m->get_new_coil_used($period);
        $this->load->view($this->layout, $data);
    }

    public function history_coil_used()
    {
        $data['title'] = 'Coil Used';
        $data['content'] = 'raw_material/coil_used/coil_used_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(236);
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

        $data['data_coil'] = $this->coil_used_m->get_history_coil_used($date_from, $date_to);
        $this->load->view($this->layout, $data);
    }

    public function report_coil_used()
    {
        $data['title'] = 'Coil Used';
        $data['content'] = 'raw_material/coil_used/report_coil_used_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(237);
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

        $data['data_coil'] = $this->coil_used_m->get_history_coil_used($date_from, $date_to);
        $this->load->view($this->layout, $data);
    }

    public function edit_coil($id)
    {
        $data['title'] = 'Coil Used';
        $data['content'] = 'raw_material/coil_used/edit_coil_used_v';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(235);
        $data['news'] = $this->news_m->get_news();

        $data['data'] = $this->coil_used_m->get_data_coil_used_by_id($id);
        $this->load->view($this->layout, $data);
    }

    public function update_coil_used()
    {
        $part_no_rm = $this->input->post('CHR_PART_NO_RM');
        $pds_no = $this->input->post('CHR_PDS_NO');
        $serial_no = $this->input->post('CHR_SERIAL_NO');
        $ser_no = $this->input->post('CHR_BATCH');
        $weight = $this->input->post('INT_WEIGHT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        if ($this->input->post('CHR_ACTUAL_UOM') == 'KG') {
            $actual_weight = $this->input->post('INT_WEIGHT_ACTUAL') * 1000;
        } else {
            $actual_weight = $this->input->post('INT_WEIGHT_ACTUAL');
        }

        $data = array(
            'INT_WEIGHT_ACTUAL' => $actual_weight
        );

        $this->db->trans_begin(); # Starting Transaction
        $this->db->trans_strict(FALSE);

        //save to tt_good_movement_h
        $data_good_movement_h = array(
            'CHR_PLANT' => "600",
            'CHR_DATE' => $date_entry,
            'CHR_TYPE_TRANS' => "STRM",
            'CHR_MVMT_TYPE' => "311",
            'CHR_IP' => $_SERVER['REMOTE_ADDR'],
            'CHR_USER' => $this->session->userdata('USERNAME'),
            'CHR_NPK' => $this->session->userdata('NPK'),
            'CHR_DATE_ENTRY' => $date_entry,
            'CHR_TIME_ENTRY' => $time_entry,
            'CHR_VALIDATE' => "X"
        );

        $getInt_Number = $this->goods_movement_h_m->save($data_good_movement_h);

        if ($weight > $actual_weight) {
            //save to tt_good_movement_l 
            $data_good_movement_l = array(
                'INT_NUMBER' => $getInt_Number,
                'CHR_PART_NO' => $part_no_rm,
                'CHR_SLOC_FROM' => 'WH00',
                'CHR_SLOC_TO' => "WP01",
                'INT_TOTAL_QTY' => (float) $actual_weight,
                'CHR_UOM' => 'G',
                'CHR_BACK_NO' => $part_no_rm,
                'INT_QTY_PER_BOX' => 0,
                'INT_QTY_BOX' => 0,
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => $this->session->userdata('USERNAME'),
                'CHR_DATE_ENTRY' => $date_entry,
                'CHR_TIME_ENTRY' => $time_entry,
                'CHR_PDS_NO' => $pds_no,
                'CHR_SER_NO' => $ser_no,
                'CHR_PART_NO_DASH' => $part_no_rm
            );

            $this->goods_movement_l_m->save($data_good_movement_l);
        } else {
            //save to tt_good_movement_l 
            $data_good_movement_l = array(
                'INT_NUMBER' => $getInt_Number,
                'CHR_PART_NO' => $part_no_rm,
                'CHR_SLOC_FROM' => 'WP01',
                'CHR_SLOC_TO' => "WH00",
                'INT_TOTAL_QTY' => (float) $actual_weight,
                'CHR_UOM' => 'G',
                'CHR_BACK_NO' => $part_no_rm,
                'INT_QTY_PER_BOX' => 0,
                'INT_QTY_BOX' => 0,
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => $this->session->userdata('USERNAME'),
                'CHR_DATE_ENTRY' => $date_entry,
                'CHR_TIME_ENTRY' => $time_entry,
                'CHR_PDS_NO' => $pds_no,
                'CHR_SER_NO' => $ser_no,
                'CHR_PART_NO_DASH' => $part_no_rm
            );

            $this->goods_movement_l_m->save($data_good_movement_l);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        $this->coil_used_m->update_actual($data, $this->input->post('INT_ID'));
        redirect($this->back_to_manage . 2);
    }

    function print_coil($int_id = null, $date_from = null, $date_to = null)
    {
        $prepared_name = $this->session->userdata('USERNAME');

        if ($int_id == null && $date_from == null && $date_to == null) {
            $data_pls = $this->db->query(";WITH cte AS
                (
                    SELECT *,
                        ROW_NUMBER() OVER (PARTITION BY [CHR_PART_NO_RM] , [CHR_PDS_NO] , [CHR_SERIAL_NO] , [CHR_BATCH]    ORDER BY CHR_CREATED_DATE) AS rn
                    FROM PRD.TT_COIL_USED where INT_FLG_READ = '0' AND INT_STATUS = '3'
                )
                SELECT INT_ID
                , CHR_WO_NUMBER
                ,CHR_PART_NO_RM
                ,CHR_PART_NO
                ,CHR_PART_NO_MATE
                ,CHR_WORK_CENTER
                ,CHR_PDS_NO
                ,CHR_SERIAL_NO
                ,CHR_BATCH
                ,INT_WEIGHT_TOTAL
                ,CHR_DATE_KANBAN
                ,CAST(INT_WEIGHT/1000 AS INT) AS INT_WEIGHT
                ,INT_WEIGHT_ACTUAL/1000 AS INT_WEIGHT_ACTUAL
                ,CHR_SLOC
                ,INT_STATUS
                ,INT_RECOVERY
                ,CHR_CREATED_BY
                ,CHR_CREATED_DATE
                ,CHR_CREATED_TIME
                ,CHR_MODIFIED_BY
                ,CHR_MODIFIED_DATE
                ,CHR_MODIFIED_TIME
                ,INT_FLG_DEL
                ,INT_FLG_READ
                FROM cte
                WHERE rn = 1 
                ORDER BY CHR_CREATED_DATE DESC, CHR_CREATED_TIME DESC")->result();
            $this->db->query("UPDATE  PRD.TT_COIL_USED
                          SET   INT_FLG_READ = '1'  where INT_FLG_READ = '0' and INT_STATUS = '3';");
        } elseif ($date_from != null && $date_to != null) {
            $data_pls = $this->db->query("select INT_ID
            , CHR_WO_NUMBER
            ,CHR_PART_NO_RM
            ,CHR_PART_NO
            ,CHR_PART_NO_MATE
            ,CHR_WORK_CENTER
            ,CHR_PDS_NO
            ,CHR_SERIAL_NO
            ,CHR_BATCH
            ,INT_WEIGHT_TOTAL
            ,CHR_DATE_KANBAN
            ,CAST(INT_WEIGHT/1000 AS INT) AS INT_WEIGHT
            ,INT_WEIGHT_ACTUAL/1000 AS INT_WEIGHT_ACTUAL
            ,CHR_SLOC
            ,INT_STATUS
            ,INT_RECOVERY
            ,CHR_CREATED_BY
            ,CHR_CREATED_DATE
            ,CHR_CREATED_TIME
            ,CHR_MODIFIED_BY
            ,CHR_MODIFIED_DATE
            ,CHR_MODIFIED_TIME
            ,INT_FLG_DEL
            ,INT_FLG_READ from PRD.TT_COIL_USED where CHR_MODIFIED_DATE between '$date_from' and '$date_to'")->result();
        } else {
            $data_pls = $this->db->query("select INT_ID
            , CHR_WO_NUMBER
            ,CHR_PART_NO_RM
            ,CHR_PART_NO
            ,CHR_PART_NO_MATE
            ,CHR_WORK_CENTER
            ,CHR_PDS_NO
            ,CHR_SERIAL_NO
            ,CHR_BATCH
            ,INT_WEIGHT_TOTAL
            ,CHR_DATE_KANBAN
            ,CAST(INT_WEIGHT/1000 AS INT) AS INT_WEIGHT
            ,INT_WEIGHT_ACTUAL/1000 AS INT_WEIGHT_ACTUAL
            ,CHR_SLOC
            ,INT_STATUS
            ,INT_RECOVERY
            ,CHR_CREATED_BY
            ,CHR_CREATED_DATE
            ,CHR_CREATED_TIME
            ,CHR_MODIFIED_BY
            ,CHR_MODIFIED_DATE
            ,CHR_MODIFIED_TIME
            ,INT_FLG_DEL
            ,INT_FLG_READ from PRD.TT_COIL_USED where INT_ID = '$int_id' ")->result();
            $this->db->query("UPDATE  PRD.TT_COIL_USED
                          SET   INT_FLG_READ = '1' 
                          WHERE   INT_ID = '$int_id' ;");
        }
        //--------------------------------------------------------------------//        
        //--------------------------------------------------------------------//
        //--------------------------------------------------------------------//
        $pdf = new FPDF('L', 'mm', array(50, 96));
        //        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->SetMargins(1, 0.5, 1, 0);
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Courier', '', 11);

        foreach ($data_pls as $key => $data_order) {
            $pds_no = trim($data_order->CHR_PDS_NO);
            $part_no = trim($data_order->CHR_PART_NO_RM);
            $batch = trim($data_order->CHR_BATCH);

            //weight from ines manufaktur

            if ($data_order->INT_WEIGHT_ACTUAL == NULL || $data_order->INT_WEIGHT_ACTUAL == '') {
                $weight = $data_order->INT_WEIGHT;
            } else {
                $weight = $data_order->INT_WEIGHT_ACTUAL;
            }

            if (strlen((int)$weight) == 1) {
                $weight_print = '000' . (int)$weight;
            } elseif (strlen((int)$weight) == 2) {
                $weight_print = '00' . (int)$weight;
            } elseif (strlen((int)$weight) == 3) {
                $weight_print = '0' . (int)$weight;
            } else {
                $weight_print = (int)$weight;
            }
            $this->make_qrcode_process(trim($data_order->CHR_SERIAL_NO), trim($data_order->CHR_PART_NO_RM), $weight_print, trim($data_order->CHR_DATE_KANBAN), trim($data_order->CHR_BATCH), trim($data_order->CHR_PDS_NO));
            $date_return = date("Y-m-d", strtotime($data_order->CHR_CREATED_DATE));
            $time_return = date("H:i:s", strtotime($data_order->CHR_CREATED_TIME));
            $tot_kaban_part = COUNT($data_pls);
            $x_kanban1 = $pdf->GetX();
            $y_kanban1 = $pdf->GetY();
            $pdf->Cell(94, 49, "", 1, 1, 'L');
            $pdf->SetY($y_kanban1 + 1);
            $pdf->SetX($x_kanban1 + 1);
            $x_kanban2 = $pdf->GetX();
            $y_kanban2 = $pdf->GetY();
            $pdf->Cell(92, 47, "", 1, 1, 'L');
            $pdf->SetY($y_kanban2);
            $pdf->SetX($x_kanban2);
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(61, 6, "PT AISIN INDONESIA", "B", 0, 'L');
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(31, 6, trim($data_order->CHR_BATCH), "B", 1, 'R');
            $pdf->SetX($x_kanban2);
            $x_kanban3 = $pdf->GetX();
            $y_kanban3 = $pdf->GetY();
            $pdf->Cell(31, 4, "Return Time", "B", 1, 'L');
            $pdf->SetX($x_kanban2);
            $pdf->SetFont('Courier', 'B', 7.1);
            $pdf->Cell(31, 4, "$date_return" . "($time_return)", "B", 1, 'L');
            $pdf->SetFont('Courier', '', 7);
            $pdf->SetX($x_kanban2);
            $pdf->Cell(31, 4, "Part No/Name", "B", 1, 'L');
            $pdf->SetX($x_kanban2);
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(31, 5, "$data_order->CHR_PART_NO_RM", "", 1, '');
            $pdf->SetX($x_kanban2);
            $CUR_Y = $pdf->GetY();
            //get part name 
            $get_part_name = $this->db->query("select CHR_PART_NAME from TM_PARTS WHERE CHR_PART_NO = '$data_order->CHR_PART_NO_RM'")->row();
            $pdf->MultiCell(31, 3, "$get_part_name->CHR_PART_NAME", 0, 'L', 0);
            $pdf->SetXY($x_kanban2, $CUR_Y);
            $pdf->Cell(31, 9, "", "B", 1, 'L');
            $pdf->SetX($x_kanban2);
            $pdf->SetFont('Courier', '', 7);
            $pdf->Cell(10, 5, "Weight :", "B", 0, '');
            $pdf->SetFont('Courier', 'B', 9);

            $pdf->Cell(21, 5, "$weight_print KG", "B", 1, '');
            $pdf->SetFont('Courier', '', 7);
            $pdf->SetX($x_kanban2);
            $pdf->Cell(16, 5, "PDS:", "B", 0, 'L');
            $pdf->SetFont('Courier', 'B', 9, 'L');
            $pdf->Cell(15, 5, trim($data_order->CHR_PDS_NO), "B", 1, 'R');
            $pdf->SetFont('Courier', '', 7);
            $pdf->SetX($x_kanban2);
            $pdf->Cell(62, 5, "Print Date : " . date('M d , Y') . " (" . date('h:i') . ")", "B", 1, 'L');
            $pdf->SetY($y_kanban3);
            $pdf->SetX($x_kanban2 + 31);
            $pdf->SetFont('Courier', 'B', 32);
            $pdf->Cell(31, 14, trim($data_order->CHR_PART_NO_RM), 1, 1, 'C');
            $pdf->SetFont('Courier', '', 7);
            $pdf->SetX($x_kanban2 + 31);
            $image1 = "./assets/barcode/return_coil/qrcode" . $pds_no . $part_no . $batch . ".png";
            $pdf->Image($image1, $pdf->GetX() + 5, $pdf->GetY(), 22, 21);
            $pdf->Cell(31, 22, "", 1, 1, 'L');
            $pdf->SetY($y_kanban3);
            $pdf->SetX($x_kanban2 + 31 + 31);
            $pdf->SetFont('Courier', 'B', 11);
            $pdf->Cell(30, 5, "RETURN", "B", 1, 'C');
            $pdf->SetX(66);
            $pdf->SetFont('Courier', 'B', 14);
            $CUR_Y = $pdf->GetY();
            //GET RACK LOCATION
            $get_rack = $this->db->query("select CHR_STO_LOCT , CHR_REC_AREA from TM_COIL_ESTIMATION where CHR_ID_PART = '$data_order->CHR_PART_NO_RM'")->row();
            $pdf->MultiCell(30, 4.67, "$data_order->CHR_WORK_CENTER", 0, 'C', 0);
            $pdf->SetXY($x_kanban2 + 31 + 31, $CUR_Y);
            $pdf->Cell(30, 16, "", "B", 1, 'L');
            $pdf->SetX($x_kanban2 + 31 + 31);

            $pdf->SetFont('Courier', 'B', 9);
            $pdf->Cell(10, 7.5, '', "B", 0, 'L'); //kalo g dapet error /$get_rack->CHR_REC_AREA
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(20, 7.5, "", "B", 1, 'C');
            $pdf->SetX($x_kanban2 + 31 + 31);
            $pdf->SetFont('Courier', 'B', 9);
            $pdf->Cell(10, 7.5, '', "B", 0, 'L'); //kalo g dapet error /$get_rack->CHR_STO_LOCT
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(20, 7.5, "", "B", 1, 'L');
            $pdf->SetX($x_kanban2 + 31 + 31);
            $pdf->SetFont('Courier', '', 7);
            $pdf->Cell(17, 5, "Serial No : ", "B", 0, 'R');
            $pdf->SetFont('Courier', 'B', 8);
            $pdf->Cell(13, 5, trim($data_order->CHR_SERIAL_NO), "B", 0, 'R');
            if ($key <> (count($data_pls) - 1)) {
                $pdf->AddPage();
            }
        }
        $pdf->output();
    }

    public function make_qrcode_process($no_serial, $part_no, $weight, $date, $batch, $pds_no)
    {
        $this->load->library('ciqrcode');
        $params['data'] = "$no_serial $part_no $weight $date $batch $pds_no";
        $params['level'] = 'B';
        $params['size'] = 2;
        $params['savename'] = 'assets/barcode/return_coil/qrcode' . $pds_no . $part_no . $batch . '.png';
        $this->ciqrcode->generate($params);
    }

    //loop3r 20220122
    public function checkCoilUsed()
    {
        $work_center = $this->input->post('work_center');

        $data = array('status' => false, 'message' => false);

        $last_used_komp = $this->coil_used_m->get_detail_last_used_komp($work_center);

        if ($last_used_komp->num_rows() > 0) {
            if ($last_used_komp->row()->INT_WEIGHT > 0 && $last_used_komp->row()->INT_STATUS == 1) {
                $data['message'] = 'Apakah coil ' . $last_used_komp->row()->CHR_PART_NO_RM .
                    ' sebelumnya, dengan berat : ' . number_format($last_used_komp->row()->INT_WEIGHT) . ' G , akan digunakan kembali?';
            } else {
                $data['status'] = $last_used_komp->row();
            }
        } else {
            $data['status'] = true;
        }

        echo json_encode($data);
    }

    //loop3r 20220122
    public function updateCoilStatus()
    {
        $work_center = $this->input->post('work_center');
        $sloc = $this->input->post('sloc');

        $last_used_komp = $this->coil_used_m->get_detail_last_used_komp($work_center);

        $data_update_coil_used = array(
            'INT_STATUS' => 3, //to WP01
            'CHR_SLOC' => $sloc,
            'CHR_MODIFIED_BY' => $sloc,
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );

        $id_update_coil_used = array(
            'INT_ID' => $last_used_komp->row()->INT_ID
        );

        $this->coil_used_m->update($data_update_coil_used, $id_update_coil_used);

        echo json_encode(true);
    }
}
