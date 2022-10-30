<?php

class ines_injection_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('part/process_part_m');
        $this->load->model('pes/prod_result_m');
        $this->load->model('pes/history_in_line_scan_m');
        $this->load->model('part/part_m');
        $this->load->model('kanban/kanban_m');
        $this->load->model('pes/cavity_m');
    }

    public function line($work_center = null) {
        $data['work_center'] = $work_center;
        $this->load->view('pes/ines_injection_v', $data);
    }

    public function insertTpr() {
        $wo_number = trim($this->input->post('wo_number'));
        $work_center = $this->input->post('work_center');
        $type_shift = $this->input->post('type_shift'); 
        $shift = $this->input->post('shift');
        $back_no = $this->input->post('back_no');
        $part_no = trim($this->input->post('part_no'));
        $part_name = trim($this->input->post('part_name'));
        $target = trim($this->input->post('target'));
        $takt_time = trim($this->input->post('takt_time'));
        $cycle_time = trim($this->input->post('cycle_time'));
        $pv = trim($this->input->post('pv'));
        $uom = trim($this->input->post('uom'));
        $planning = $this->input->post('planning');  
        $actual = $this->input->post('actual');
        $man_power = intval($this->input->post('man_power'));
        $npk = $this->input->post('npk'); 
        $username = $this->input->post('username'); 
        $phone = $this->input->post('phone');
        $production_date = $this->input->post('production_date'); 
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $cavity_flag = trim($this->input->post('cavity_flag'));
        $part_no_cavity = trim($this->input->post('part_no_cavity'));
        $part_name_cavity = trim($this->input->post('part_name_cavity'));
        $back_no_cavity = $this->input->post('back_no_cavity');
        $cycle_time_cavity = trim($this->input->post('cycle_time_cavity'));
        $pv_cavity = trim($this->input->post('pv_cavity'));
        $uom_cavity = trim($this->input->post('uom_cavity'));
        
        $total_dandori = $this->prod_result_m->get_sequence_by_wo($wo_number);

        $validate_pn = $this->prod_result_m->check_phantom($part_no);
        if ($validate_pn == 0) {
            $validate = 'Y';
        } else {
            $validate = 'P';
        }

        $data['CHR_USER'] = $username;
        $data['CHR_CREATED_BY'] =  $username;
        $data['INT_TARGET'] = $target;
        $data['INT_QTY_PLAN'] = $planning;
        $data['CHR_WO_NUMBER'] = $wo_number;
        $data['CHR_DATE'] = $production_date;
        $data['CHR_PLANT'] = '600';
        $data['CHR_BACK_NO'] = $back_no;
        $data['CHR_PART_NO'] = $part_no;
        $data['CHR_PART_NAME'] = $part_name;
        $data['CHR_WORK_CENTER'] = $work_center;
        $data['INT_BULAN'] = intval(date('m'));
        $data['INT_TAHUN'] = intval(date('Y'));
        $data['CHR_SHIFT'] = $shift;
        $data['CHR_WORK_DAY'] = $this->prod_result_m->get_current_day();
        $data['CHR_WORK_TIME_START'] = date('H') . '00';
        $data['INT_MP'] = $man_power;
        $data['INT_ACTUAL'] = 0;
        $data['INT_QTY_OK'] = 0;
        $data['INT_TOTAL_QTY'] = 0;
        $data['CHR_IP'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $data['CHR_DATE_ENTRY'] = $date_entry;
        $data['CHR_TIME_ENTRY'] = $time_entry;
        $data['INT_NPK'] = $npk;
        $data['CHR_VALIDATE'] = $validate;
        $data['CHR_SHIFT_TYPE'] = $type_shift;
        $data['CHR_STATUS_MOBILE'] = 'I';
        $data['CHR_PV'] = $pv;
        $data['CHR_UOM'] = $uom;
        $data['INT_NG_OTHERS_REV'] = $total_dandori;

        $exist = $this->prod_result_m->cek_exist_data($data);
        if ($exist == 0) {
            $this->prod_result_m->update_flag_is_finished_cavity($wo_number);
            $id_number = $this->prod_result_m->save_trans($data);

            $data_history = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_PLAN' => $planning,
                'INT_DANDORI' => $total_dandori,
                'INT_QTY_PERSCAN' => 0,
                'CHR_PART_NO' => $part_no,
                'CHR_BACK_NO' => $back_no,
                'CHR_DATE' => $production_date,
                'CHR_SHIFT' => $shift,
                'CHR_WORK_CENTER' => $work_center,
                'INT_NUMBER_REF' => $id_number,
                'CHR_STATUS_DATA' => 'CREATE', 
                'CHR_CREATED_BY' => $username,
                'CHR_CREATED_DATE' => $date_entry,
                'CHR_CREATED_TIME' => $time_entry
            );

            $this->history_in_line_scan_m->save($data_history);
        }

        $master_cavity = $this->cavity_m->get_data_part_no($part_no);
        if ($master_cavity->num_rows() > 0) {

            $total_dandori_cavity = $this->prod_result_m->get_sequence_by_wo($wo_number);

            $validate_pn = $this->prod_result_m->check_phantom($part_no_cavity);
            if ($validate_pn == 0) {
                $validate = 'Y';
            } else {
                $validate = 'P';
            }

            $data_cavity['CHR_USER'] = $username;
            $data_cavity['CHR_CREATED_BY'] =  $username;
            $data_cavity['INT_TARGET'] = $target;
            $data_cavity['INT_QTY_PLAN'] = $planning;
            $data_cavity['CHR_WO_NUMBER'] = $wo_number;
            $data_cavity['CHR_DATE'] = $production_date;
            $data_cavity['CHR_PLANT'] = '600';
            $data_cavity['CHR_BACK_NO'] = $back_no_cavity; //$detail_part->row()->BACK_NO; 
            $data_cavity['CHR_PART_NO'] = $part_no_cavity; //$detail_part->row()->PART_NO; 
            $data_cavity['CHR_PART_NAME'] = $part_name_cavity; //$detail_part->row()->CHR_PART_NAME; 
            $data_cavity['CHR_WORK_CENTER'] = $work_center;
            $data_cavity['INT_BULAN'] = intval(date('m'));
            $data_cavity['INT_TAHUN'] = intval(date('Y'));
            $data_cavity['CHR_SHIFT'] = $shift;
            $data_cavity['CHR_WORK_DAY'] = $this->prod_result_m->get_current_day();
            $data_cavity['CHR_WORK_TIME_START'] = date('H') . '00';
            $data_cavity['INT_MP'] = $man_power;
            $data_cavity['INT_ACTUAL'] = 0;
            $data_cavity['INT_QTY_OK'] = 0;
            $data_cavity['INT_TOTAL_QTY'] = 0;
            $data_cavity['CHR_IP'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $data_cavity['CHR_DATE_ENTRY'] = $date_entry;
            $data_cavity['CHR_TIME_ENTRY'] = $time_entry;
            $data_cavity['INT_NPK'] = $npk;
            $data_cavity['CHR_VALIDATE'] = $validate;
            $data_cavity['CHR_SHIFT_TYPE'] = $type_shift;
            $data_cavity['CHR_STATUS_MOBILE'] = 'I';
            $data_cavity['CHR_PV'] = $pv_cavity;
            $data_cavity['CHR_UOM'] = $uom_cavity;
            $data_cavity['INT_NG_OTHERS_REV'] = $total_dandori_cavity;

            $exist_cavity = $this->prod_result_m->cek_exist_data($data_cavity);
            if ($exist_cavity == 0) {
                $int_number_cavity = $this->prod_result_m->save_trans($data_cavity);
                
                $data_history_cavity = array(
                    'CHR_WO_NUMBER' => $wo_number,
                    'INT_PLAN' => $planning,
                    'INT_DANDORI' => $total_dandori_cavity,
                    'INT_QTY_PERSCAN' => 0,
                    'CHR_PART_NO' => $part_no_cavity,
                    'CHR_BACK_NO' => $back_no_cavity,
                    'CHR_DATE' => $production_date,
                    'CHR_SHIFT' => $shift,
                    'CHR_WORK_CENTER' => $work_center,
                    'INT_NUMBER_REF' => $int_number_cavity,
                    'CHR_STATUS_DATA' => 'CREATE', 
                    'CHR_CREATED_BY' => $username,
                    'CHR_CREATED_DATE' => $date_entry,
                    'CHR_CREATED_TIME' => $time_entry
                );
                
                $this->history_in_line_scan_m->save($data_history_cavity);
            }
        }else{
            $int_number_cavity = $id_number;
            $total_dandori_cavity = $total_dandori;
        }

        $json_data = array(
            'int_number' => $id_number,
            'int_number_cavity' => $int_number_cavity,
            'total_dandori' =>$total_dandori,
            'total_dandori_cavity' =>$total_dandori_cavity
        );

        if ('IS_AJAX') {
            echo json_encode($json_data);
        }
    }

    public function updateTpr() {
        $wo_number = trim($this->input->post('wo_number'));
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $int_number = $this->input->post('int_number');
        $int_number_cavity = $this->input->post('int_number_cavity');
        $total_dandori = $this->input->post('total_dandori'); 
        $total_dandori_cavity = $this->input->post('total_dandori_cavity'); 
        $actual = $this->input->post('actual');
        $part_no = $this->input->post('part_no');
        $back_no = $this->input->post('back_no');
        $type = $this->input->post('type');
        $id_kanban = intval($this->input->post('id_kanban'));
        $serial = $this->input->post('serial');
        $planning = $this->input->post('planning');
        $username = $this->input->post('username'); 
        $cavity_flag = $this->input->post('cavity_flag');
        $back_no_cavity = $this->input->post('back_no_cavity');
        $part_no_cavity = $this->input->post('part_no_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $qty_per_box = $this->kanban_m->get_kanban_qty($back_no, $type, $id_kanban, $serial);
        $data = $this->prod_result_m->get_auto_data_production($wo_number, $back_no);

        $update = array(
            'INT_ACTUAL' => $qty_per_box,
            'INT_TOTAL_QTY' => $qty_per_box,
            'CHR_COMPLETE' => NULL
        );

        $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);

        $data_history = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_PLAN' => $planning - $actual,
            'INT_DANDORI' => $total_dandori,
            'INT_QTY_PERSCAN' => intval($qty_per_box),
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
            'INT_NUMBER_REF' => $int_number,
            'CHR_BARCODE_KANBAN' => $id_kanban.' '.$type.' '.$serial,
            'CHR_STATUS_DATA' => 'UPDATE', 
            'CHR_CREATED_BY' => $username,
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_in_line_scan_m->save($data_history);

        $master_cavity = $this->cavity_m->get_data_part_no($part_no);
        if ($master_cavity->num_rows() > 0) {

            $data_cavity = $this->prod_result_m->get_auto_data_production($wo_number, $back_no_cavity); 

            $update_cavity = array(
                'INT_ACTUAL' => 0,
                'INT_TOTAL_QTY' => $qty_per_box,
                'CHR_COMPLETE' => NULL
            );

            $this->prod_result_m->update_production_result($update_cavity, $data_cavity->INT_NUMBER, trim($data_cavity->CHR_IP), $wo_number);
        
            $data_history_cavity = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_PLAN' => $planning - $actual,
                'INT_DANDORI' => $total_dandori_cavity,
                'INT_QTY_PERSCAN' => intval($qty_per_box),
                'CHR_PART_NO' => $part_no_cavity,
                'CHR_BACK_NO' => $back_no_cavity,
                'CHR_DATE' => $date,
                'CHR_SHIFT' => $shift,
                'CHR_WORK_CENTER' => $work_center,
                'INT_NUMBER_REF' => $int_number_cavity,
                'CHR_BARCODE_KANBAN' => '',
                'CHR_STATUS_DATA' => 'UPDATE', 
                'CHR_CREATED_BY' => $username,
                'CHR_CREATED_DATE' => $date_entry,
                'CHR_CREATED_TIME' => $time_entry
            );
    
            $this->history_in_line_scan_m->save($data_history_cavity);

            $qty_per_box = $qty_per_box * 2; //cavity

        }
        
        $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
        $data_dandori = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);
        
        $json_data = array(
            'actual' => $data_dandori->INT_ACTUAL,
            'total_per_dandori' => $data_dandori->INT_TOTAL_QTY,
            'total_ok' => $data_total->INT_TOTAL_QTY,
            'qty_per_box' => $qty_per_box
        );

        echo json_encode($json_data);
    }

    public function insertReject() {
        $wo_number = $this->input->post('wo_number');
        $qty = $this->input->post('qty');
        $ng = $this->input->post('ng');
        $back_no = $this->input->post('back_no');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $back_no);

        $update['INT_NG_PRC'] = 0;
        $update['INT_NG_SETUP'] = 0;
        $update['INT_NG_BRKNTEST'] = 0;
        $update['INT_NG_TRIAL'] = 0;
        $update['NG_CODE'] = NULL;

        if ($ng == 'INT_NG_BRKNTEST') {
            $update['INT_NG_PRC'] = $data->INT_NG_PRC;
            $update['INT_NG_SETUP'] = $data->INT_NG_SETUP;
            $update['INT_NG_BRKNTEST'] = $data->INT_NG_BRKNTEST + $qty;
            $update['INT_NG_TRIAL'] = $data->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG2';
        } else if ($ng == 'INT_NG_SETUP') {
            $update['INT_NG_PRC'] = $data->INT_NG_PRC;
            $update['INT_NG_SETUP'] = $data->INT_NG_SETUP + $qty;
            $update['INT_NG_BRKNTEST'] = $data->INT_NG_BRKNTEST;
            $update['INT_NG_TRIAL'] = $data->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG3';
        } else {
            $update['INT_NG_PRC'] = $data->INT_NG_PRC + $qty;
            $update['INT_NG_SETUP'] = $data->INT_NG_SETUP;
            $update['INT_NG_BRKNTEST'] = $data->INT_NG_BRKNTEST;
            $update['INT_NG_TRIAL'] = $data->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG1';
        }

        $update['INT_TOTAL_NG'] = $qty;
        $update['INT_ACTUAL'] = $qty;

        $this->prod_result_m->update_production_result_ng($update, $data->INT_NUMBER, trim($data->CHR_IP));
        $data_json['total_ng'] = $this->prod_result_m->get_total_reject($wo_number);

        echo json_encode($data_json);
    }

    public function updateRetail() {
        $wo_number = trim($this->input->post('wo_number'));
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $username = $this->input->post('username');
        $qty_per_box = $this->input->post('qty_per_box');
        $qty_retail = $this->input->post('qty_retail');
        $back_no = $this->input->post('back_no');
        $cavity_flag = $this->input->post('cavity_flag');
        $planning = $this->input->post('planning');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $actual = $this->input->post('actual');

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $back_no);
        $allow_retail = $this->history_in_line_scan_m->get_sum_qty_by_work_order($wo_number, $qty_retail, $qty_per_box, $back_no, $data->INT_NUMBER);

        if ($allow_retail == 0) {

            $update = array(
                'INT_ACTUAL' => $qty_retail,
                'INT_TOTAL_QTY' => $qty_retail,
                'CHR_COMPLETE' => NULL
            );

            $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);

            $data_history = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_PLAN' => $planning - $actual,
                'INT_DANDORI' => $data->INT_NG_OTHERS_REV,
                'INT_QTY_PERSCAN' => intval($qty_retail),
                'CHR_PART_NO' => $data->CHR_PART_NO,
                'CHR_BACK_NO' => $back_no,
                'CHR_DATE' => $date,
                'CHR_SHIFT' => $shift,
                'CHR_WORK_CENTER' => $work_center,
                'INT_NUMBER_REF' => $data->INT_NUMBER,
                'CHR_STATUS_DATA' => 'ECERAN', 
                'CHR_CREATED_BY' => $username,
                'CHR_CREATED_DATE' => $date_entry,
                'CHR_CREATED_TIME' => $time_entry
            );

            $this->history_in_line_scan_m->save($data_history);

            $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
            $data_dandori = $this->prod_result_m->get_total_per_dandori($data->CHR_PART_NO, $wo_number);

            $json_data = array(
                'total_per_dandori' => $data_dandori->INT_TOTAL_QTY,
                'total_ok' => $data_total->INT_TOTAL_QTY,
                'message' => false,
                'status' => true
            );

        } else {
            $qty_allow = (int) $qty_per_box - 1;

            $json_data = array(
                'message' => 'Tidak bisa menginput lebih dari ' . $qty_allow . ' Piece(s)',
                'status' => false
            );
        }

        echo json_encode($json_data);
    }

}