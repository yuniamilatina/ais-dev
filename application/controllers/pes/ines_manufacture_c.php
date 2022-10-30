<?php

class ines_manufacture_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('kanban/kanban_m');
        $this->load->model('pes/prod_result_m');
        $this->load->model('pes/cavity_m');
        $this->load->model('raw_material/coil_used_m');
        $this->load->model('pes/rm_responsible_m');
        $this->load->model('pes/history_scan_kanban_komponen_m');
        $this->load->model('pes/history_in_line_scan_m');
        $this->load->model('goods_movement/goods_movement_l_m');
        $this->load->model('goods_movement/goods_movement_h_m');
    }

    public function line($work_center = null) {
        $data['work_center'] = $work_center;
        $this->load->view('pes/ines_manufacture_v', $data);
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

        $array_back_no = $this->input->post('array_back_no');

        $cavity_flag = trim($this->input->post('cavity_flag'));
        $part_no_cavity = trim($this->input->post('part_no_cavity'));
        $part_name_cavity = trim($this->input->post('part_name_cavity'));
        $back_no_cavity = $this->input->post('back_no_cavity');
        $cycle_time_cavity = trim($this->input->post('cycle_time_cavity'));
        $pv_cavity = trim($this->input->post('pv_cavity'));
        $uom_cavity = trim($this->input->post('uom_cavity'));

        $total_dandori = $this->prod_result_m->get_sequence_by_wo($wo_number);

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
        $data['CHR_VALIDATE'] = 'Y';
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

            $data_cavity['CHR_USER'] = $username;
            $data_cavity['CHR_CREATED_BY'] =  $username;
            $data_cavity['INT_TARGET'] = $target;
            $data_cavity['INT_QTY_PLAN'] = $planning;
            $data_cavity['CHR_WO_NUMBER'] = $wo_number;
            $data_cavity['CHR_DATE'] = $production_date;
            $data_cavity['CHR_PLANT'] = '600';
            $data_cavity['CHR_BACK_NO'] = $back_no_cavity;  
            $data_cavity['CHR_PART_NO'] = $part_no_cavity;   
            $data_cavity['CHR_PART_NAME'] = $part_name_cavity;
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
            $data_cavity['CHR_VALIDATE'] = 'Y';
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
        $planning = $this->input->post('planning');
        $actual = $this->input->post('actual');
        $part_no = $this->input->post('part_no');
        $back_no = $this->input->post('back_no');
        $id_kanban = intval($this->input->post('id_kanban'));
        $type = $this->input->post('type');
        $serial = $this->input->post('serial');
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

            $this->prod_result_m->update_production_result($update_cavity, $data_cavity->INT_NUMBER, trim($data_cavity->CHR_IP),  $wo_number);
        
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
        } else if ($ng == 'INT_NG_MATERIAL_ASAL') {
            $update['INT_NG_PRC'] = $data->INT_NG_PRC;
            $update['INT_NG_SETUP'] = $data->INT_NG_SETUP + $qty;
            $update['INT_NG_BRKNTEST'] = $data->INT_NG_BRKNTEST;
            $update['INT_NG_TRIAL'] = $data->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG6';
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

    public function getDetailCoil() {
        $serial = $this->input->post('serial');
        $back_no_coil = $this->input->post('back_no');
        $weight_total = intval($this->input->post('qty'));
        $tgl = $this->input->post('tgl');
        $batch = $this->input->post('code');
        $pds = $this->input->post('pds');
        $part_no = $this->input->post('part_no');
        $part_no_cavity = $this->input->post('part_no_cavity');
        $wo_number = $this->input->post('wo_number');
        $work_center = $this->input->post('work_center');
        $part_no_rm =  '';
        $data['status'] = false;
        $data['status_cavity'] = true;
        $data['qty_weight'] = 0;
        $data['cavity_flag'] = false;

        $bom = $this->rm_responsible_m->get_detail_kanban($back_no_coil, $part_no);
        if ($bom->num_rows() > 0) {
            $part_no_rm = trim(strtoupper($bom->row()->CHR_PART_NO_RM));

            $coil_used = $this->coil_used_m->get_detail_kanban_komp($part_no_rm, $work_center, $pds, $batch, $serial);

            if ($coil_used->num_rows() > 0) {

            //    if ($coil_used->row()->INT_WEIGHT < 0) {
            //        $data['message'] = 'Berat komponen ' . $coil_used->row()->INT_WEIGHT . ' G, mohon gunakan kanban lain';
            //    } else {
            //        $data['qty_weight'] = number_format((double) $coil_used->row()->INT_WEIGHT);
            //        $data['status'] = true;
            //    }

                $data['qty_weight'] = number_format((double) $coil_used->row()->INT_WEIGHT);
                $data['status'] = true;
            } else {
                $data['qty_weight'] = number_format((double) $bom->row()->INT_WEIGHT);
                $data['status'] = true;
            }
        } else {
            $mapping_correct = $this->rm_responsible_m->get_correct_detail_kanban($part_no);
            if ($mapping_correct->num_rows() > 0) {
                $data['message'] = 'kanban coil tidak sesuai, part '.$part_no.' seharusnya menggunakan coil ' . $mapping_correct->row()->CHR_PART_NO_RM;
            } else {
                $data['message'] = 'Data Coil tidak ditemukan untuk part ' . $part_no;
            }
        }

        $master_cavity = $this->cavity_m->get_data_part_no($part_no);

        if ($master_cavity->num_rows() > 0) {
            $data['cavity_flag'] = true;
            $data['status_cavity'] = false;

            $bom_cavity = $this->rm_responsible_m->get_detail_kanban($back_no_coil, $part_no_cavity);
            if ($bom_cavity->num_rows() > 0) {

                if ($part_no_rm == trim(strtoupper($bom_cavity->row()->CHR_PART_NO_RM))) {
                    $data['status_cavity'] = true;
                } else {
                    $data['message_cavity'] = 'Mapping part cavity '.$part_no.' tidak sesuai dengan part '. $part_no_cavity;
                }
            } else {
                $mapping_correct_cavity = $this->rm_responsible_m->get_correct_detail_kanban($part_no_cavity);

                if ($mapping_correct_cavity->num_rows() > 0) {
                    $data['message_cavity'] = 'kanban coil tidak sesuai, part '. $part_no_cavity .' seharusnya menggunakan coil '. $mapping_correct->row()->CHR_PART_NO_RM;;
                } else {
                    $data['message_cavity'] = 'Data Coil tidak ditemukan untuk part ' . $part_no_cavity;
                }
            }
        }

        echo json_encode($data);
    }

    public function checkCoilUsed() {
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

    public function insertMovement() {
        $work_center = $this->input->post('work_center');
        $wo_number = $this->input->post('wo_number');
        $serial = $this->input->post('serial');
        $back_no_coil = $this->input->post('back_no_coil');
        $weight_total = intval($this->input->post('qty'));
        $tgl = $this->input->post('tgl');
        $batch = $this->input->post('code');
        $pds = $this->input->post('pds');
        $qty = $this->input->post('qty');
        $username = $this->input->post('username');
        $cavity_flag = $this->input->post('cavity_flag');
        $part_no = $this->input->post('part_no');
        $part_no_cavity = $this->input->post('part_no_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $bom = $this->coil_used_m->get_detail_kanban_komp($back_no_coil, $work_center, $pds, $batch, $serial);

        if ($bom->num_rows() > 0) {

            $data_update_coil_used = array(
                'INT_STATUS' => 3,
                'CHR_MODIFIED_BY' => 'Reuse',
                'CHR_MODIFIED_DATE' => $date_entry,
                'CHR_MODIFIED_TIME' => $time_entry
            );

            $id_update = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_ID' => $bom->row()->INT_ID
            );

            $this->coil_used_m->update($data_update_coil_used, $id_update);

            $weight_total = (double) $bom->row()->INT_WEIGHT;
            $recovery = $bom->row()->INT_RECOVERY + 1;
        } else {
            $weight_total = (double) $weight_total * 1000;
            $recovery = 0;
        }

        $data_coil_used = array(
            'CHR_WO_NUMBER' => $wo_number,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PART_NO_RM' => $back_no_coil,
            'CHR_PART_NO' => $part_no,
            'CHR_PART_NO_MATE' => $part_no_cavity,
            'CHR_PDS_NO' => $pds,
            'CHR_DATE_KANBAN' => $tgl,
            'CHR_SERIAL_NO' => $serial,
            'CHR_BATCH' => $batch,
            'INT_WEIGHT_TOTAL' => $weight_total,
            'INT_WEIGHT' => $weight_total,
            'INT_STATUS' => 1,  
            'INT_RECOVERY' => $recovery,
            'CHR_CREATED_BY' => $username,
            'CHR_MODIFIED_BY' => 'Recenlty Use',
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $id_coil = $this->coil_used_m->save($data_coil_used);

        $data_history_component = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_NUMBER_REF' => $id_coil,
            'CHR_BARCODE_KOMPONEN' => $serial . ' ' . $back_no_coil . ' ' . $qty . ' ' . $tgl . ' ' . $batch . ' ' . $pds,
            'INT_WEIGHT_TOTAL' => $weight_total,
            'INT_WEIGHT' => $weight_total,
            'CHR_CREATED_BY' => 'insertMovement',
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_scan_kanban_komponen_m->save($data_history_component);

        $data['qty_weight'] = number_format($weight_total);

        //===== Open Comment by ANU for movement part from WH to WP - 20211008 =====//
        if ($bom->num_rows() > 0) {

            if( trim($bom->row()->CHR_SLOC) == 'WH00' ){
                
                $this->db->trans_begin(); # Starting Transaction
                $this->db->trans_strict(FALSE);
                $data_good_movement_h = array(
                    'CHR_PLANT' => "600",
                    'CHR_DATE' => $date_entry,
                    'CHR_TYPE_TRANS' => "STRM",
                    'CHR_MVMT_TYPE' => "311",
                    'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                    'CHR_USER' => 'WEB-ID01',
                    'CHR_NPK' => $work_center,
                    'CHR_DATE_ENTRY' => $date_entry,
                    'CHR_TIME_ENTRY' => $time_entry,
                    'CHR_VALIDATE' => "X"
                );

                $getInt_Number = $this->goods_movement_h_m->save($data_good_movement_h);

                $data_good_movement_l = array(
                    'INT_NUMBER' => $getInt_Number,
                    'CHR_PART_NO' => $back_no_coil,
                    'CHR_SLOC_FROM' => 'WH00', //$sloc_from,
                    'CHR_SLOC_TO' => "WP01",
                    'INT_TOTAL_QTY' => (double) $bom->row()->INT_WEIGHT,
                    'CHR_UOM' => 'G',
                    'CHR_BACK_NO' => $back_no_coil,
                    'INT_QTY_PER_BOX' => 0,
                    'INT_QTY_BOX' => 0,
                    'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                    'CHR_USER' => $work_center,
                    'CHR_DATE_ENTRY' => $date_entry,
                    'CHR_TIME_ENTRY' => $time_entry,
                    'CHR_PDS_NO' => $pds,
                    'CHR_SER_NO' => $batch,
                    'CHR_PART_NO_DASH' => $back_no_coil
                );

                $this->goods_movement_l_m->save($data_good_movement_l);

                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }

        } else {

            $this->db->trans_begin();
            $this->db->trans_strict(FALSE);

            $data_good_movement_h = array(
                'CHR_PLANT' => "600",
                'CHR_DATE' => $date_entry,
                'CHR_TYPE_TRANS' => "STRM",
                'CHR_MVMT_TYPE' => "311",
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => 'WEB-ID01',
                'CHR_NPK' => $work_center,
                'CHR_DATE_ENTRY' => $date_entry,
                'CHR_TIME_ENTRY' => $time_entry,
                'CHR_VALIDATE' => "X"
            );

            $getInt_Number = $this->goods_movement_h_m->save($data_good_movement_h);

            $data_good_movement_l = array(
                'INT_NUMBER' => $getInt_Number,
                'CHR_PART_NO' => $back_no_coil,
                'CHR_SLOC_FROM' => "WH00",
                'CHR_SLOC_TO' => "WP01",
                'INT_TOTAL_QTY' => (double) $weight_total, //convert to gram
                'CHR_UOM' => 'G',
                'CHR_BACK_NO' => $back_no_coil,
                'INT_QTY_PER_BOX' => 0,
                'INT_QTY_BOX' => 0,
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => $work_center,
                'CHR_DATE_ENTRY' => $date_entry,
                'CHR_TIME_ENTRY' => $time_entry,
                'CHR_PDS_NO' => $pds,
                'CHR_SER_NO' => $batch,
                'CHR_PART_NO_DASH' => $back_no_coil
            );

            $this->goods_movement_l_m->save($data_good_movement_l);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }
        //===== End open comment =====//

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function updateMovement() {
        $serial = $this->input->post('serial');
        $back_no_coil = $this->input->post('back_no_coil');
        $tgl = $this->input->post('tgl');
        $batch = $this->input->post('code');
        $pds = $this->input->post('pds');
        $qty = $this->input->post('qty');

        $wo_number = $this->input->post('wo_number');
        $work_center = $this->input->post('work_center');
        $username = $this->input->post('username');
        $part_no = $this->input->post('part_no');
        $back_no = $this->input->post('back_no');
        $qty_weight = $this->input->post('qty_weight');
        $cavity_flag = $this->input->post('cavity_flag');
        $qty_per_box = $this->input->post('qty_per_box'); //if cavity this param was multiply
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $data = array('status' => false, 'qty_weight' => 0);

        $kanban = $this->rm_responsible_m->get_detail_kanban($back_no_coil, $part_no);
        $kanban_komp = $this->coil_used_m->get_detail_kanban_komp($back_no_coil, $work_center, $pds, $batch, $serial);

        if ($kanban_komp->num_rows() > 0) {

            $weight = (double) $kanban_komp->row()->INT_WEIGHT - ($qty_per_box * (double) $kanban->row()->INT_WEIGHT);

            $data_update = array(
                'CHR_MODIFIED_BY' => 'In Use (scan)',
                'CHR_MODIFIED_DATE' => $date_entry,
                'CHR_MODIFIED_TIME' => $time_entry,
                'INT_WEIGHT' => $weight
            );

            $id_update = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_ID' => $kanban_komp->row()->INT_ID,
                'INT_STATUS' => 1
            );

            $this->coil_used_m->update($data_update, $id_update);

            $data_history_component = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_NUMBER_REF' => $kanban_komp->row()->INT_ID,
                'CHR_BARCODE_KOMPONEN' => $serial . ' ' . $back_no_coil . ' ' . $qty . ' ' . $tgl . ' ' . $batch . ' ' . $pds,
                'INT_WEIGHT_TOTAL' => (double) $kanban_komp->row()->INT_WEIGHT_TOTAL,
                'INT_WEIGHT' => $weight,
                'CHR_CREATED_BY' => 'updateMovement',
                'CHR_CREATED_DATE' => $date_entry,
                'CHR_CREATED_TIME' => $time_entry
            );

            $this->history_scan_kanban_komponen_m->save($data_history_component);

            $data['status'] = true;
            $data['qty_weight'] = number_format($weight);
        } else {
            $data['message'] = 'Data detail kanban komponen tidak ada';
            $data['qty_weight'] = $qty_weight;
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function addMovement() {
        $serial = $this->input->post('serial');
        $back_no_coil = $this->input->post('back_no_coil');
        $weight_total = intval($this->input->post('qty'));
        $tgl = $this->input->post('tgl');
        $batch = $this->input->post('code');
        $pds = $this->input->post('pds');
        $qty = $this->input->post('qty');
        $work_center = $this->input->post('work_center');
        $wo_number = $this->input->post('wo_number');
        $username = $this->input->post('username');
        $cavity_flag = $this->input->post('cavity_flag');
        $part_no = $this->input->post('part_no');
        $part_no_cavity = $this->input->post('part_no_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $bom = $this->coil_used_m->get_detail_kanban_komp($back_no_coil, $work_center, $pds, $batch, $serial);

        if ($bom->num_rows() > 0) {
            $data_update_coil_used = array(
                'INT_STATUS' => 3,
                'CHR_MODIFIED_BY' => 'Reuse after add',
                'CHR_MODIFIED_DATE' => $date_entry,
                'CHR_MODIFIED_TIME' => $time_entry
            );

            $id_update = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_ID' => $bom->row()->INT_ID
            );

            $this->coil_used_m->update($data_update_coil_used, $id_update);

            $weight_total = (double) $bom->row()->INT_WEIGHT;
            $recovery = $bom->row()->INT_RECOVERY + 1;
        } else {
            $weight_total = (double) $weight_total * 1000;
            $recovery = 0;
        }

        $data_coil_used = array(
            'CHR_WO_NUMBER' => $wo_number,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PART_NO_RM' => $back_no_coil,
            'CHR_PART_NO' => $part_no,
            'CHR_PART_NO_MATE' => $part_no_cavity,
            'CHR_PDS_NO' => $pds,
            'CHR_DATE_KANBAN' => $tgl,
            'CHR_SERIAL_NO' => $serial,
            'CHR_BATCH' => $batch,
            'INT_WEIGHT_TOTAL' => $weight_total,
            'INT_WEIGHT' => $weight_total,
            'INT_STATUS' => 1, //INSERT
            'CHR_SLOC' => 'WP01',
            'INT_RECOVERY' => $recovery,
            'CHR_CREATED_BY' => $username,
            'CHR_MODIFIED_BY' => 'Add Coil',
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $id_coil = $this->coil_used_m->save($data_coil_used);

        $data_history_component = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_NUMBER_REF' => $id_coil,
            'CHR_BARCODE_KOMPONEN' => $serial . ' ' . $back_no_coil . ' ' . $qty . ' ' . $tgl . ' ' . $batch . ' ' . $pds,
            'INT_WEIGHT_TOTAL' => $weight_total,
            'INT_WEIGHT' => $weight_total,
            'CHR_CREATED_BY' => 'addMovement',
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_scan_kanban_komponen_m->save($data_history_component);

        $data['qty_weight'] = number_format($weight_total);

        //===== Open Comment by ANU for movement part from WH to WP - 20211008 =====//
        if ($bom->num_rows() > 0) {

            if( trim($bom->row()->CHR_SLOC) == 'WH00' ){
                
                $this->db->trans_begin(); # Starting Transaction
                $this->db->trans_strict(FALSE);

                $data_good_movement_h = array(
                    'CHR_PLANT' => "600",
                    'CHR_DATE' => $date_entry,
                    'CHR_TYPE_TRANS' => "STRM",
                    'CHR_MVMT_TYPE' => "311",
                    'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                    'CHR_USER' => 'WEB-ID01',
                    'CHR_NPK' => $work_center,
                    'CHR_DATE_ENTRY' => $date_entry,
                    'CHR_TIME_ENTRY' => $time_entry,
                    'CHR_VALIDATE' => "X"
                );

                $getInt_Number = $this->goods_movement_h_m->save($data_good_movement_h);

                $data_good_movement_l = array(
                    'INT_NUMBER' => $getInt_Number,
                    'CHR_PART_NO' => $back_no_coil,
                    'CHR_SLOC_FROM' => 'WH00', //$sloc_from,
                    'CHR_SLOC_TO' => "WP01",
                    'INT_TOTAL_QTY' => (double) $bom->row()->INT_WEIGHT,
                    'CHR_UOM' => 'G',
                    'CHR_BACK_NO' => $back_no_coil,
                    'INT_QTY_PER_BOX' => 0,
                    'INT_QTY_BOX' => 0,
                    'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                    'CHR_USER' => $work_center,
                    'CHR_DATE_ENTRY' => $date_entry,
                    'CHR_TIME_ENTRY' => $time_entry,
                    'CHR_PDS_NO' => $pds,
                    'CHR_SER_NO' => $batch,
                    'CHR_PART_NO_DASH' => $back_no_coil
                );

                $this->goods_movement_l_m->save($data_good_movement_l);

                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }

        } else {

            $this->db->trans_begin();
            $this->db->trans_strict(FALSE);

            $data_good_movement_h = array(
                'CHR_PLANT' => "600",
                'CHR_DATE' => $date_entry,
                'CHR_TYPE_TRANS' => "STRM",
                'CHR_MVMT_TYPE' => "311",
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => 'WEB-ID01',
                'CHR_NPK' => $work_center,
                'CHR_DATE_ENTRY' => $date_entry,
                'CHR_TIME_ENTRY' => $time_entry,
                'CHR_VALIDATE' => "X"
            );

            $getInt_Number = $this->goods_movement_h_m->save($data_good_movement_h);

            $data_good_movement_l = array(
                'INT_NUMBER' => $getInt_Number,
                'CHR_PART_NO' => $back_no_coil,
                'CHR_SLOC_FROM' => "WH00",
                'CHR_SLOC_TO' => "WP01",
                'INT_TOTAL_QTY' => (double) $weight_total, //convert to gram
                'CHR_UOM' => 'G',
                'CHR_BACK_NO' => $back_no_coil,
                'INT_QTY_PER_BOX' => 0,
                'INT_QTY_BOX' => 0,
                'CHR_IP' => $_SERVER['REMOTE_ADDR'],
                'CHR_USER' => $work_center,
                'CHR_DATE_ENTRY' => $date_entry,
                'CHR_TIME_ENTRY' => $time_entry,
                'CHR_PDS_NO' => $pds,
                'CHR_SER_NO' => $batch,
                'CHR_PART_NO_DASH' => $back_no_coil
            );

            $this->goods_movement_l_m->save($data_good_movement_l);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }
        //===== End open comment =====//

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function returnGoodMovement() {
        $wo_number = $this->input->post('wo_number');
        $work_center = $this->input->post('work_center');
        $back_no_coil = $this->input->post('back_no_coil');
        $qty_weight = $this->input->post('qty_weight');
        $cavity_flag = $this->input->post('cavity_flag');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $last_used_komp = $this->coil_used_m->get_detail_last_used_komp($work_center);

        //update status = 3
        $data_update_coil_used = array(
            'INT_STATUS' => 3, //return as good
            'CHR_SLOC' => "WH00",
            'CHR_MODIFIED_BY' => 'Return to WH00',
            'CHR_MODIFIED_DATE' => $date_entry,
            'CHR_MODIFIED_TIME' => $time_entry
        );

        $id_update_coil_used = array(
            'INT_ID' => $last_used_komp->row()->INT_ID
        );

        $this->coil_used_m->update($data_update_coil_used, $id_update_coil_used);

        // if ((double)$last_used_komp->row()->INT_WEIGHT > 0){
        //     $this->db->trans_begin();
        //     $this->db->trans_strict(FALSE);

        //     $data_good_movement_h = array(
        //         'CHR_PLANT' => "600",
        //         'CHR_DATE' => $date_entry,
        //         'CHR_TYPE_TRANS' => "STRM",
        //         'CHR_MVMT_TYPE' => "312", //its was 311
        //         'CHR_IP' => $_SERVER['REMOTE_ADDR'],
        //         'CHR_USER' => 'WEB-ID01',
        //         'CHR_NPK' => $work_center,
        //         'CHR_DATE_ENTRY' => $date_entry,
        //         'CHR_TIME_ENTRY' => $time_entry,
        //         'CHR_VALIDATE' => "X"
        //     );

        //     $getInt_Number = $this->goods_movement_h_m->save($data_good_movement_h);

        //     $data_good_movement_l = array(
        //         'INT_NUMBER' => $getInt_Number,
        //         'CHR_PART_NO' => $last_used_komp->row()->CHR_PART_NO_RM,
        //         'CHR_SLOC_FROM' => "WH00",
        //         'CHR_SLOC_TO' => "WP01",
        //         'INT_TOTAL_QTY' => (double) $last_used_komp->row()->INT_WEIGHT,
        //         'CHR_UOM' => 'G',
        //         'CHR_BACK_NO' => $last_used_komp->row()->CHR_PART_NO_RM,
        //         'INT_QTY_PER_BOX' => 0,
        //         'INT_QTY_BOX' => 0,
        //         'CHR_IP' => $_SERVER['REMOTE_ADDR'],
        //         'CHR_USER' => $work_center,
        //         'CHR_DATE_ENTRY' => $date_entry,
        //         'CHR_TIME_ENTRY' => $time_entry,
        //         'CHR_PDS_NO' => $last_used_komp->row()->CHR_PDS_NO,
        //         'CHR_SER_NO' => $last_used_komp->row()->CHR_BATCH,
        //         'CHR_PART_NO_DASH' => $last_used_komp->row()->CHR_PART_NO_RM
        //     );

        //     $this->goods_movement_l_m->save($data_good_movement_l);

        //     $this->db->trans_complete();
        //     if ($this->db->trans_status() === FALSE) {
        //         $this->db->trans_rollback();
        //         $data = 'gagal di return';
        //     } else {
        //         $this->db->trans_commit();
        //         $data = 'berhasil di return';
        //     }
        // }

        $data = true;
        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function regardAsReject() {
        $wo_number = $this->input->post('wo_number');
        $work_center = $this->input->post('work_center');
        $back_no_coil = $this->input->post('back_no_coil');
        $qty_weight = $this->input->post('qty_weight');
        $cavity_flag = $this->input->post('cavity_flag');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $last_used_komp = $this->coil_used_m->get_detail_last_used_komp($work_center);

        //update status = 3
        $data_update_coil_used = array(
            'INT_STATUS' => 3, //to WP01
            'CHR_SLOC' => "WP01",
            'CHR_MODIFIED_BY' => 'Done in WP01',
            'CHR_MODIFIED_DATE' => $date_entry,
            'CHR_MODIFIED_TIME' => $time_entry
        );

        $id_update_coil_used = array(
            'INT_ID' => $last_used_komp->row()->INT_ID
        );

        $this->coil_used_m->update($data_update_coil_used, $id_update_coil_used);
        
        echo json_encode(true);
    }

    public function insertRejectCoil(){
        $work_center = $this->input->post('work_center');
        $wo_number = $this->input->post('wo_number');
        $part_no = $this->input->post('part_no');
        $qty_ng = $this->input->post('qty_ng');

        $serial = $this->input->post('serial');
        $back_no_coil = $this->input->post('back_no');
        $tgl = $this->input->post('tgl');
        $batch = $this->input->post('code');
        $pds = $this->input->post('pds');
        $qty = $this->input->post('qty');

        $date_entry = date('Ymd');
        $time_entry = date('His');
        $data['qty_weight'] = 0;
        $data['status'] = false;

        $bom = $this->rm_responsible_m->get_detail_kanban($back_no_coil, $part_no);

        if ($bom->num_rows() > 0) {

            $bom_coil = $this->coil_used_m->get_detail_kanban_komp($bom->row()->CHR_PART_NO_RM, $work_center, $pds, $batch, $serial);
            if ($bom_coil->num_rows() > 0) {

                $weight = (double) $bom_coil->row()->INT_WEIGHT - ($qty_ng * (double) $bom->row()->INT_WEIGHT);

                $data_update = array(
                    'CHR_MODIFIED_BY' => 'In Use (Reject)',
                    'CHR_MODIFIED_DATE' => $date_entry,
                    'CHR_MODIFIED_TIME' => $time_entry,
                    'INT_WEIGHT' => $weight
                );

                $id_update = array(
                    'CHR_WO_NUMBER' => $wo_number,
                    'INT_ID' => $bom_coil->row()->INT_ID,
                    'INT_STATUS' => 1
                );

                $this->coil_used_m->update($data_update, $id_update);

                $data_history_component = array(
                    'CHR_WO_NUMBER' => $wo_number,
                    'INT_NUMBER_REF' => $bom_coil->row()->INT_ID,
                    'CHR_BARCODE_KOMPONEN' => $serial . ' ' . $back_no_coil . ' ' . $qty . ' ' . $tgl . ' ' . $batch . ' ' . $pds,
                    'INT_WEIGHT_TOTAL' => (double) $bom_coil->row()->INT_WEIGHT_TOTAL,
                    'INT_WEIGHT' => $weight,
                    'CHR_CREATED_BY' => 'insertRejectCoil',
                    'CHR_CREATED_DATE' => $date_entry,
                    'CHR_CREATED_TIME' => $time_entry
                );

                $this->history_scan_kanban_komponen_m->save($data_history_component);

                $data['status'] = true;
                $data['qty_weight'] = number_format((double) $bom_coil->row()->INT_WEIGHT - ($qty_ng * (double) $bom->row()->INT_WEIGHT));
            } else {
                $data['message'] = 'Data ng detail coil tidak ada';
            }
        } else {
            $mapping_correct = $this->rm_responsible_m->get_correct_detail_kanban($part_no);
            if ($mapping_correct->num_rows() > 0) {
                $data['message'] = 'kanban coil tidak sesuai, part '.$part_no.' seharusnya menggunakan coil ' . $mapping_correct->row()->CHR_PART_NO_RM;
            } else {
                $data['message'] = 'Data Coil tidak ditemukan untuk part ' . $part_no;
            }

        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }

    }

    public function updateCoilRetail() {
        $serial = $this->input->post('serial');
        $back_no_coil = $this->input->post('back_no');
        $tgl = $this->input->post('tgl');
        $batch = $this->input->post('code');
        $pds = $this->input->post('pds');
        $qty = $this->input->post('qty');

        $wo_number = $this->input->post('wo_number');
        $npk = $this->input->post('npk');
        $part_no= $this->input->post('part_no');
        $work_center = substr(trim($wo_number), 0, -16);
        $qty_retail = $this->input->post('qty_retail');
        $cavity_flag = $this->input->post('cavity_flag');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $data['status'] = false;
        $data['qty_weight'] = 0;

        $bom = $this->rm_responsible_m->get_detail_kanban($back_no_coil, $part_no);

        if ($bom->num_rows() > 0) {

            $bom_coil = $this->coil_used_m->get_detail_kanban_komp($back_no_coil, $work_center, $pds, $batch, $serial);

            if ($bom_coil->num_rows() > 0) {

                $weight = (double) $bom_coil->row()->INT_WEIGHT - ($qty_retail * (double) $bom->row()->INT_WEIGHT);

                $data_update = array(
                    'CHR_MODIFIED_BY' => 'In Use (Separate)',
                    'CHR_MODIFIED_DATE' => $date_entry,
                    'CHR_MODIFIED_TIME' => $time_entry,
                    'INT_WEIGHT' => $weight
                );

                $id_update = array(
                    'CHR_WO_NUMBER' => $wo_number,
                    'INT_ID' => $bom_coil->row()->INT_ID,
                    'INT_STATUS' => 1
                );

                $this->coil_used_m->update($data_update, $id_update);

                $data_history_component = array(
                    'CHR_WO_NUMBER' => $wo_number,
                    'INT_NUMBER_REF' => $bom_coil->row()->INT_ID,
                    'CHR_BARCODE_KOMPONEN' => $serial . ' ' . $back_no_coil . ' ' . $qty . ' ' . $tgl . ' ' . $batch . ' ' . $pds,
                    'INT_WEIGHT_TOTAL' => (double) $bom_coil->row()->INT_WEIGHT_TOTAL,
                    'INT_WEIGHT' => $weight,
                    'CHR_CREATED_BY' => 'updateCoilRetail',
                    'CHR_CREATED_DATE' => $date_entry,
                    'CHR_CREATED_TIME' => $time_entry
                );

                $this->history_scan_kanban_komponen_m->save($data_history_component);

                $data['status'] = true;
                $data['qty_weight'] = number_format($weight);
            } else {
                $data['message'] = 'Data detail kanban komponen tidak ada';
            }
        } else {

            $mapping_correct = $this->rm_responsible_m->get_correct_detail_kanban($part_no);
            if ($mapping_correct->num_rows() > 0) {
                $data['message'] = 'kanban coil tidak sesuai, part '.$part_no.' seharusnya menggunakan coil ' . $mapping_correct->row()->CHR_PART_NO_RM;
            } else {
                $data['message'] = 'Data Coil tidak ditemukan untuk part ' . $part_no;
            }
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

}