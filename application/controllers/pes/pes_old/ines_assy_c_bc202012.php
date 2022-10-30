<?php

class ines_assy_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('kanban/kanban_m');
        $this->load->model('part/process_part_m');
        $this->load->model('pes/target_production_m');
        $this->load->model('pes/line_stop_prod_m');
        $this->load->model('pes/prod_result_m');
        $this->load->model('pes/history_in_line_scan_m');
        $this->load->model('part/part_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('eng/rfid_dies_m');

        $this->load->model('basis/user_m');
        $this->load->model('prd/logs_in_line_scan_m');
    }

    public function line($wc = null) {
        $data['wc'] = $wc;
        $this->load->view('pes/ines_assy_v', $data);
    }

    public function get_detail_kanban() {
        $code = $this->input->post('code');
        $work_center = $this->input->post('wc');
        $serial = $this->input->post('serial');
        $tipe = $this->input->post('tipe');
        $wo = $this->input->post('wo');
        $dateprod = $this->input->post('dateprod');

        $data = array('kanban' => false, 'message' => false, 'count' => 0, 'data_dies' => 0);

        $data_kanban = $this->kanban_m->get_detail_kanban_by_barcode($code, $serial, $tipe);

        if ($data_kanban->num_rows() > 0) {
            $part_no = trim($data_kanban->row()->CHR_PART_NO);

            $data_process_part = $this->process_part_m->get_data_part_by_work_center_and_part($work_center, $part_no);
            if ($data_process_part->num_rows() > 0) {
                $data['kanban'] = $data_kanban->row();
                $data['data_dies'] = $this->rfid_dies_m->get_data_dies_by_partno($part_no);
            } else {
                $data['message'] = 'Part No : '.$part_no.' tidak terdaftar di Line '.$work_center;
            }
        } else {
            $data['message'] = 'Data kanban tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function check_kanban() {
        $code = $this->input->post('code');
        $backno = $this->input->post('backno');
        $serial = $this->input->post('serial');
        $tipe = $this->input->post('tipe');
        $wc = $this->input->post('wc');

        $data = array('kanban' => false);

        $kanban = $this->kanban_m->get_detail_kanban_by_barcode($code, $serial, $tipe);

        if ($kanban->num_rows() > 0) {
            if (trim($kanban->row()->CHR_BACK_NO) != $backno) {
                $data['message'] = 'Back Number tidak sesuai.';
            } else {
                $data['kanban'] = true;
            }
        } else {
            $data['message'] = 'Kanban tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    function insert_tpr() {
        $wo_no = trim($this->input->post('wo'));
        $part_no = trim($this->input->post('partno'));
        $part_name = trim($this->input->post('descpart'));
        $planning = $this->input->post('planning');  
        $actual = $this->input->post('actual');
        $qty_per_box = $this->input->post('qty_kanban');
        $back_no = $this->input->post('backno');
        $wc = $this->input->post('wc');
        $mp = intval($this->input->post('mp'));
        $npk = $this->input->post('npk'); 
        $dateprod = $this->input->post('dateprod'); 
        $type_shift = $this->input->post('type_shift'); 
        $shift = str_replace('SHIFT', '', $this->input->post('shift'));
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $month = date('m');
        $target = 0;
        $contact = '';
        $ct = 0;

        $data_target = $this->target_production_m->get_target_production_by_period_and_work_center($month, $wc);
        if ($data_target->num_rows() > 0) {
            $data['INT_TARGET'] = trim($data_target->row()->INT_TARGET_PER_SHIFT);
        } else {
            $data['INT_TARGET'] = $target;
        }

        $process_part = $this->process_part_m->get_detail_process_part($wc, $part_no);
        if ($process_part->num_rows() > 0) {
            $data['CHR_PV'] = $process_part->row()->CHR_PV;
            $ct = $process_part->row()->INT_CYCLE_TIME;
        }

        $data_uom = $this->part_m->get_OUM_by_part($part_no);
        if ($data_uom->num_rows() > 0) {
            $data['CHR_UOM'] = trim($data_uom->row()->CHR_PART_UOM);
        }

        $data_user = $this->user_m->get_user_name_by_npk($npk);
        if ($data_user->num_rows() > 0) {
            $data['CHR_USER'] = trim($data_user->row()->CHR_USERNAME); // add by BugsMaker 16/01/2017
            $data['CHR_CREATED_BY'] = trim($data_user->row()->CHR_USERNAME);
            $contact = trim($data_user->row()->CHR_CONTACT);
        }else{
            $data['CHR_USER'] = $npk;
            $data['CHR_CREATED_BY'] =  $npk;
            $contact = 'N/A';
        }

        $data_dandori_sequence = $this->prod_result_m->get_sequence_dandori_by_wo($wo_no);
        if ($data_dandori_sequence->num_rows() > 0) {
            $data['INT_NG_OTHERS_REV'] = $data_dandori_sequence->row()->INT_NG_OTHERS_REV; 
        } else {
            $data['INT_NG_OTHERS_REV'] = 1;
        }

        // =========================================================== //
        // Add by Ilham Januardy
        // 17.03.2020
        // start
        $validate_pn = $this->prod_result_m->check_phantom($part_no);
        if ($validate_pn == 0) {
            $validate = 'Y';
        } else {
            $validate = 'P';
        }
        // end

        $data['INT_QTY_PLAN'] = $planning;
        $data['CHR_WO_NUMBER'] = $wo_no;
        $data['CHR_DATE'] = $dateprod;
        $data['CHR_PLANT'] = '600';
        $data['CHR_BACK_NO'] = $back_no;
        $data['CHR_PART_NO'] = $part_no;
        $data['CHR_PART_NAME'] = $part_name;
        $data['CHR_WORK_CENTER'] = $wc;
        $data['INT_BULAN'] = intval(date('m'));
        $data['INT_TAHUN'] = intval(date('Y'));
        $data['CHR_SHIFT'] = $shift;
        $data['CHR_WORK_DAY'] = $this->prod_result_m->get_current_day();
        $data['CHR_WORK_TIME_START'] = date('H') . '00';
        $data['INT_MP'] = $mp;
        $data['INT_ACTUAL'] = 0; 
        $data['INT_QTY_OK'] = 0; 
        $data['INT_TOTAL_QTY'] = 0; 
        $data['CHR_IP'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $data['CHR_DATE_ENTRY'] = $date_entry; 
        $data['CHR_TIME_ENTRY'] = $time_entry; 
        $data['INT_NPK'] = $npk; 
        // $data['CHR_VALIDATE'] = 'Y';
        $data['CHR_VALIDATE'] = $validate;
        $data['CHR_SHIFT_TYPE'] = $type_shift;
        $data['CHR_STATUS_MOBILE'] = 'I';

        //get data las hour scan and update to 

        $data_history = array(
            'CHR_WO_NUMBER' => $wo_no,
            'INT_PLAN' => $planning,
            'INT_DANDORI' => $data['INT_NG_OTHERS_REV'],
            'INT_QTY_PERSCAN' => 0,
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_DATE' => $dateprod,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $wc,
            'CHR_STATUS_DATA' => 'CREATE', 
            'CHR_CREATED_BY' => $data['CHR_CREATED_BY'],
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $exist = $this->prod_result_m->cek_exist_data($data);
        if ($exist == 0) {
            $this->prod_result_m->update_flag_is_finished($wo_no);

            $id_number = $this->prod_result_m->save_trans($data);
            $this->history_in_line_scan_m->save($data_history);
        }

        $json_data['int_number'] = $id_number;
        $json_data['display'] = array(
            'INT_TOTAL_QTY' => 0,
            'INT_QTY_KANBAN' => $qty_per_box,
            'CHR_WORK_CENTER' => $wc,
            'INT_DANDORI' =>$data['INT_NG_OTHERS_REV'],
            'CHR_PART_NO' => $part_no,
            'CHR_PART_NAME' => $part_name,
            'CHR_BACK_NO' => $back_no,
            'INT_MAN_POWER' => $mp,
            'INT_NPK' => $npk,
            'CHR_USERNAME' => $data['CHR_CREATED_BY'],
            'CHR_CONTACT' => $contact,
            'INT_CYCLE_TIME' => $ct,
            'CHR_CREATED_TIME' => $time_entry,
            'CHR_SHIFT' => $shift,
            'CHR_SHIFT_TYPE' => $type_shift
        );

        if ('IS_AJAX') {
            echo json_encode($json_data);
        }
    }

    function update_tpr() {
        $wo_number = trim($this->input->post('documentno'));
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $actual = $this->input->post('actual');
        $total_actual = $this->input->post('total_actual');
        $part_no = $this->input->post('partno');
        $backno = $this->input->post('backno');
        $type_kanban = $this->input->post('kanban_type');
        $kanban_no = intval($this->input->post('kanban_no'));
        $serial = $this->input->post('serial_no_kanban');
        $planning = $this->input->post('planning'); 
        $qty_per_box = $this->input->post('qty_kanban');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        
        $json_data = array('prod_result' => false);

        $kanban = $this->prod_result_m->get_kanban_qty($backno, $type_kanban, $kanban_no, $serial);
        $data = $this->prod_result_m->get_auto_data_production($wo_number, $backno);

        $update['INT_ACTUAL'] = $kanban; 
        $update['INT_TOTAL_QTY'] = $kanban;
        $update['CHR_COMPLETE'] = NULL; 

        $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);

        $previous_history_data = $this->prod_result_m->get_manual_data_production($wo_number, $backno);
        
        $data_history = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_PLAN' => $planning - $actual,
            'INT_DANDORI' => $previous_history_data->INT_NG_OTHERS_REV,
            'INT_QTY_PERSCAN' => intval($qty_per_box),
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $backno,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
            'INT_NUMBER_REF' => $previous_history_data->INT_NUMBER,
            'CHR_BARCODE_KANBAN' => $kanban_no.' '.$type_kanban.' '.$serial,
            'CHR_STATUS_DATA' => 'UPDATE', 
            'CHR_CREATED_BY' => $previous_history_data->CHR_CREATED_BY,
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_in_line_scan_m->save($data_history);

        $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);

        $json_data['prod_result'] = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);
        $json_data['display'] = array(
            'INT_DANDORI' => $data->INT_NG_OTHERS_REV,
            'INT_TOTAL_QTY' => $data_total->INT_TOTAL_QTY,
            'INT_QTY_PERPART' => $data->INT_TOTAL_QTY,
            'CHR_CREATED_TIME' => date('Hi'),
            'CHR_WORK_CENTER' => $work_center,
            'CHR_SHIFT' => $shift,
            'CHR_SHIFT_TYPE' => $previous_history_data->CHR_SHIFT_TYPE
        );

        echo json_encode($json_data);
    }

    function insertng() {
        $wo_number = $this->input->post('wo');
        $qty = $this->input->post('qty');
        $ng = $this->input->post('ng');
        $backno = $this->input->post('backno');
        $partno = $this->input->post('partno');
        $wc = $this->input->post('wc');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $prsdata = $this->prod_result_m->get_auto_data_production($wo_number, $backno);

        $update['INT_NG_PRC'] = 0;
        $update['INT_NG_SETUP'] = 0;
        $update['INT_NG_BRKNTEST'] = 0;
        $update['INT_NG_TRIAL'] = 0;
        // $update['INT_NG_UNBALANCE'] = 0;
        // $update['INT_NG_MATERIAL_ASAL'] = 0;
        $update['NG_CODE'] = NULL;

        if ($ng == 'INT_NG_TRIAL') {
            $update['INT_NG_PRC'] = $prsdata->INT_NG_PRC;
            $update['INT_NG_SETUP'] = $prsdata->INT_NG_SETUP;
            $update['INT_NG_BRKNTEST'] = $prsdata->INT_NG_BRKNTEST;
            $update['INT_NG_TRIAL'] = $prsdata->INT_NG_TRIAL + $qty;
            $update['NG_CODE'] = 'NG4';
        } else if ($ng == 'INT_NG_BRKNTEST') {
            $update['INT_NG_PRC'] = $prsdata->INT_NG_PRC;
            $update['INT_NG_SETUP'] = $prsdata->INT_NG_SETUP;
            $update['INT_NG_BRKNTEST'] = $prsdata->INT_NG_BRKNTEST + $qty;
            $update['INT_NG_TRIAL'] = $prsdata->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG2';
        } else if ($ng == 'INT_NG_SETUP') {
            $update['INT_NG_PRC'] = $prsdata->INT_NG_PRC;
            $update['INT_NG_SETUP'] = $prsdata->INT_NG_SETUP + $qty;
            $update['INT_NG_BRKNTEST'] = $prsdata->INT_NG_BRKNTEST;
            $update['INT_NG_TRIAL'] = $prsdata->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG3';
        } else if ($ng == 'INT_NG_UNBALANCE') {
            $update['INT_NG_PRC'] = $prsdata->INT_NG_PRC + $qty;
            $update['INT_NG_SETUP'] = $prsdata->INT_NG_SETUP;
            $update['INT_NG_BRKNTEST'] = $prsdata->INT_NG_BRKNTEST;
            $update['INT_NG_TRIAL'] = $prsdata->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG5';
        } else if ($ng == 'INT_NG_MATERIAL_ASAL') {
            $update['INT_NG_PRC'] = $prsdata->INT_NG_PRC;
            $update['INT_NG_SETUP'] = $prsdata->INT_NG_SETUP + $qty;
            $update['INT_NG_BRKNTEST'] = $prsdata->INT_NG_BRKNTEST;
            $update['INT_NG_TRIAL'] = $prsdata->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG6';
        } else {
            $update['INT_NG_PRC'] = $prsdata->INT_NG_PRC + $qty;
            $update['INT_NG_SETUP'] = $prsdata->INT_NG_SETUP;
            $update['INT_NG_BRKNTEST'] = $prsdata->INT_NG_BRKNTEST;
            $update['INT_NG_TRIAL'] = $prsdata->INT_NG_TRIAL;
            $update['NG_CODE'] = 'NG1';
        }

        $update['INT_TOTAL_NG'] = $qty;
        $update['INT_ACTUAL'] = $qty;

        $ret['status'] = $this->prod_result_m->update_production_result_ng($update, $prsdata->INT_NUMBER, trim($prsdata->CHR_IP));

        echo json_encode($ret);
    }

    function start_line_stop() {
        $wo_number = trim($this->input->post('documentno'));
        $shift = substr(trim($this->input->post('documentno')), -1);
        $date = substr(trim($this->input->post('documentno')), -15, 8);
        $work_center = substr(trim($this->input->post('documentno')), 0, -16);
        $line_stop_code = $this->input->post('templs');
        $npk = $this->input->post('npk');
        $int_number = $this->input->post('int_number');
        $date = date('Ymd');
        $time = date('His');

        $data_ls = array(
            'CHR_LINE_CODE' => $line_stop_code,
            // 'INT_NUMBER' => $int_number,
            'CHR_WO_NUMBER' => $wo_number,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_CREATED_BY' => $npk,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time,
            'CHR_START_DATE' => $date,
            'CHR_START_TIME' => $time
        );

        $this->line_stop_prod_m->save($data_ls);

        $data = $this->line_stop_prod_m->get_data_line_stop($line_stop_code);
      
        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    function start_waiting_mte() {
        $wo_number = trim($this->input->post('documentno'));
        $work_center = substr(trim($this->input->post('documentno')), 0, -16);
        $line_stop_code = $this->input->post('ls');

        $data_line_stop = $this->line_stop_prod_m->getLineStopMachine($wo_number, $line_stop_code);

        $data_update = array(
            'CHR_WAITING_DATE' => date('Ymd'),
            'CHR_WAITING_TIME' => date('His')
        );

        $id_update = array(
            'CHR_WO_NUMBER' => $data_line_stop['CHR_WO_NUMBER'],
            'CHR_LINE_CODE' => $data_line_stop['CHR_LINE_CODE'],
            'INT_ID_LINE_STOP' => $data_line_stop['INT_ID_LINE_STOP']
        );

        $this->line_stop_prod_m->update($data_update, $id_update);

        if ('IS_AJAX') {
            echo json_encode(true);
        }
    }

    function insertWaitingMTE(){
        $codeLs = trim($this->input->post('ls'));
        $wo = trim($this->input->post('documentno'));
        $work_center = substr(trim($this->input->post('documentno')), 0, -16);
        $npk_followup = (int)$this->input->post('npk_followup');
        $datenow = date('Ymd');
        $timenow = date('His');

        if(strlen((string)$npk_followup) == 3){
            $npk_string = '0'.$npk_followup;
        }else if(strlen((string)$npk_followup) == 2){
            $npk_string = '00'.$npk_followup;
        }else if(strlen((string)$npk_followup) == 1){
            $npk_string = '000'.$npk_followup;
        }else{
            $npk_string = $npk_followup;
        }

        $data_user = $this->user_m->get_user_name_by_npk($npk_string);
        if ($data_user->num_rows() > 0) {
            $data['CHR_USER'] = trim($data_user->row()->CHR_USERNAME); 
        }else{
            $data['CHR_USER'] = $npk_string;
        }

        $data_line_stop = $this->line_stop_prod_m->getLineStopMachine($wo, $codeLs);

        if(date('YmdHis') < $data_line_stop['DATETIME_WAITING']){
            $timenow = $data_line_stop['CHR_WAITING_TIME'];
        }

        $data_update = array(
            'CHR_FOLLOWUP_BY' => $npk_string,
            'CHR_FOLLOWUP_DATE' => $datenow,
            'CHR_FOLLOWUP_TIME' => $timenow
        );

        $id_update = array(
            'CHR_WO_NUMBER' => $data_line_stop['CHR_WO_NUMBER'],
            'CHR_LINE_CODE' => $data_line_stop['CHR_LINE_CODE'],
            'INT_ID_LINE_STOP' => $data_line_stop['INT_ID_LINE_STOP']
        );

        $this->line_stop_prod_m->update($data_update, $id_update);

        echo json_encode($data);
    }
    
    function insertFollowUP() {
        $codeLs = trim($this->input->post('ls'));
        $wo = trim($this->input->post('documentno'));
        $work_center = substr(trim($this->input->post('documentno')), 0, -16);

        $data_line_stop = $this->line_stop_prod_m->getLineStopMachine($wo, $codeLs);

        $data_update = array(
            'CHR_STOP_DATE' => date('Ymd'),
            'CHR_STOP_TIME' => date('His')
        );

        $id_update = array(
            'CHR_WO_NUMBER' => $data_line_stop['CHR_WO_NUMBER'],
            'CHR_LINE_CODE' => $data_line_stop['CHR_LINE_CODE'],
            'INT_ID_LINE_STOP' => $data_line_stop['INT_ID_LINE_STOP']
        );

        $this->line_stop_prod_m->update($data_update, $id_update);

        $json_code = true;

        echo json_encode($json_code);
    }

    function insertLS() {
        $codeLs = $this->input->post('ls');
        $wo = trim($this->input->post('documentno'));
        $npk = $this->input->post('npk');
        $work_center = substr(trim($this->input->post('documentno')), 0, -16);

        $data_line_stop = $this->line_stop_prod_m->getLineStopMachine($wo, $codeLs);

        $json_data = array('ls_code' => $codeLs, 'wo' => $wo, 'status' => false);

        $this->db->trans_begin();

        $data_update = array(
            'CHR_MODIFIED_BY' => $npk,
            'CHR_STOP_DATE' => date('Ymd'),
            'CHR_STOP_TIME' => date('His'),
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );

        $id_update = array(
            'CHR_WO_NUMBER' => $data_line_stop['CHR_WO_NUMBER'],
            'CHR_LINE_CODE' => $data_line_stop['CHR_LINE_CODE'],
            'INT_ID_LINE_STOP' => $data_line_stop['INT_ID_LINE_STOP']
        );

        $this->line_stop_prod_m->update($data_update, $id_update);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $json_data['status'] = true;
        }

        echo json_encode($json_data);
    }

    public function update_ls_to_server(){
        $ls_code = trim($this->input->post('ls_code'));
        $wo = trim($this->input->post('wo'));
        $ls_duration = $this->input->post('ls_duration') / 60;

        $data_update = array(
            'INT_MINUTES_TIME' => (int)$ls_duration,
            'INT_TOTAL_LINE_STOP' => (int)$ls_duration
        );

        $id_update = array(
            'CHR_WO_NUMBER' => $wo,
            'CHR_LINE_CODE' => $ls_code
        );

        $this->line_stop_prod_m->update_ls_duration($data_update, $id_update);

        echo json_encode(true);
    }
    
    public function update_waiting_ls_to_server(){
        $ls_code = trim($this->input->post('ls_code'));
        $wo = trim($this->input->post('wo'));
        $wait_duration = $this->input->post('wait_duration') /60;

        $data_update = array(
            'INT_DURASI_WAITING' => (int)$wait_duration
        );

        $id_update = array(
            'CHR_WO_NUMBER' => $wo,
            'CHR_LINE_CODE' => $ls_code
        );

        $this->line_stop_prod_m->update_ls_waiting_duration($data_update, $id_update);

        echo json_encode(true);
    }

    public function update_repair_ls_to_server(){
        $ls_code = trim($this->input->post('ls_code'));
        $wo = trim($this->input->post('wo'));
        $repair_duration = $this->input->post('repair_duration')/60;
        $ls_duration = $this->input->post('ls_duration')/60;

        $data_update = array(
            'INT_DURASI_REPAIR' => (int)$repair_duration,
            'INT_MINUTES_TIME' => (int)$ls_duration,
            'INT_TOTAL_LINE_STOP' => (int)$ls_duration
        );

        $id_update = array(
            'CHR_WO_NUMBER' => $wo,
            'CHR_LINE_CODE' => $ls_code
        );

        $this->line_stop_prod_m->update_ls_repair_duration($data_update, $id_update);

        echo json_encode(true);
    }

    function set_scan_serial($serial) {
        $this->session->sess_expiration = '86400';
        $sesserial[$serial] = true;
        $this->session->set_userdata($sesserial);

        $serial = str_replace("%20", " ", $serial);
        $cek = $this->history_in_line_scan_m->get_history_scan_kanban_by_barcode($serial);
        if ($cek) {
            $this->history_in_line_scan_m->update_history_scan_kanban_by_barcode($serial);
        } else {
            $this->history_in_line_scan_m->insert_history_scan_kanban($serial);
        }
    }

    function get_scan_serial($serial) {

        $data = array('kanban' => TRUE, 'message' => false);
        $serial = str_replace("%20", " ", $serial);
        $dataSerial = explode(" ", $serial);
        
        $remark = $this->direct_backflush_general_m->get_routing_by_kanban($dataSerial[0], $dataSerial[1]);

        if ($remark->CHR_REMARK) {
            $cekHistory = $this->history_in_line_scan_m->get_history_scan_kanban_by_barcode($serial);

            if ($cekHistory) {
                $valWaktu2 = trim($remark->CHR_REMARK);
                $currentTime = date('Ymd H:i:s');
                $tanggal1 = trim($cekHistory->CHR_TANGGAL);

                $tgl = substr($tanggal1, 0, 2);
                $bln = substr($tanggal1, 2, 2);
                $thn = substr($tanggal1, 4, 4);
                $tglJam = $tgl . "-" . $bln . "-" . $thn . " " . trim($cekHistory->CHR_LAST_TIME);
                $lastTime = strtotime("+$valWaktu2 minutes", strtotime($tglJam));
                $lastTimes = date('Ymd H:i:s', $lastTime);

                if (strtotime($currentTime) < strtotime($lastTimes)) {
                    $data['message'] = "Kanban sudah di Scan, harap scan kembali pada " . $lastTimes . "";
                } else {
                    $data['kanban'] = false;
                }
            } else {
                $data['kanban'] = false;
            }
        } else {
            $data['message'] = "Data Routing/Time Belum di Maintain";
        }

        echo json_encode($data);
    }

    public function get_total_actual_by_shift() {
        $wo = $this->input->post('wo');

        $row_part = $this->prod_result_m->get_total_actual_by_shift($wo);
        $data['total_pieces'] = 'TOTAL OK : ' . $row_part['INT_TOTAL_QTY'] . ' /Pcs';
        $data['total_ng'] = 'TOTAL NG : ' . $row_part['INT_TOTAL_NG'] . ' /Pcs';
        if ($data == NULL) {
            $data['total_pieces'] = 'TOTAL OK : 0 /Pcs';
            $data['total_ng'] = 'TOTAL NG : 0 /Pcs';
        }

        $row_count = $this->prod_result_m->get_total_dandori_by_wo($wo);
        $data['total_row'] = 'TOTAL DANDORI : ' . $row_count['TOTAL_ROW'];
        if ($data['total_row'] == NULL) {
            $data['total_row'] = 'TOTAL DANDORI : 0';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function get_total_ls_by_shift() {
        $wo = $this->input->post('wo');

        $data_ls = $this->line_stop_prod_m->get_data_summary_line_stop($wo);
        $data['total_ls_plan'] = 'PLAN LS : ' . $data_ls->PLAN . ' m';
        $data['total_ls_unplan'] = 'UNPLAN LS : ' . $data_ls->UNPLAN. ' m';

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function check_npk() {
        $npk = (int)$this->input->post('npk');

        if(strlen($npk) == 3){
            $npk_string = '0'.$npk;
        }else if(strlen($npk) == 2){
            $npk_string = '00'.$npk;
        }else if(strlen($npk) == 1){
            $npk_string = '000'.$npk;
        }else{
            $npk_string = $npk;
        }

        $data = $this->user_m->get_npk($npk_string);

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function get_history() {
        $wo = trim($this->input->post('wo'));
        $history = $this->prod_result_m->get_all_history_by_wc_and_shift_and_date($wo);

        if ($history->num_rows() > 0) {
            $data['total_history'] = $history->num_rows();

            $x = 0;
            foreach ($history->result() as $value) {
                $param_label[$x] = trim($value->CHR_BACK_NO);
                $param_qty[$x] = trim($value->INT_QTY_OK);
                $x++;
            }

            $data['label_history'] = $param_label;
            $data['qty_history'] = $param_qty;
        } else {
            $data = 0;
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function update_flag_is_finished() {
        $wo = trim($this->input->post('wo'));
        $this->prod_result_m->update_flag_is_finished($wo);

        $data = $wo . ' was flaged with X ';

        $work_center = substr($wo, 0, -16);

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function get_date_prod() {
        $shift_selected = str_replace('SHIFT', '', $this->input->post('choose_shift'));
        $work_center = $this->input->post('wc');
        $npk = $this->input->post('npk');
        $shift_type = $this->input->post('type_shift');

        if ($shift_type == 'L'){
            $flag_shift = 1;
        }else{
            $flag_shift = 0;
        }

        if ($shift_selected == 3) {
            if (date('G') >= 0 && date('G') < 6) {
                $dateprod = date('Ymd', strtotime(date('Ymd') . '-1 days'));
            } else {
                $dateprod = date('Ymd');
            }
        } else {
            $dateprod = date('Ymd');
        }

        $wo_number = $work_center . '/' . $dateprod . '/SHIFT' . $shift_selected;

        $this->prod_result_m->start_production($wo_number, $flag_shift);

        $username = null;
        $data_user = $this->user_m->get_data_user($npk);
        if($data_user->num_rows() > 0){
            $username = $data_user->row()->CHR_USERNAME;
        }

        $data_target = $this->target_production_m->get_target_production_work_center($work_center);
        if ($data_target->num_rows() > 0) {
            $ct = $data_target->row()->INT_CT;
            $tt = $data_target->row()->INT_TT;
            $target = $data_target->row()->INT_TARGET_PRODUCTION;
        } else {
            $ct = 0;
            $tt = 0;
            $target = 0;
        }

        $json_data['data_display'] = array(
            'CHR_WO_NUMBER' => $wo_number,
            'CHR_DATE' => $dateprod,
            'INT_SHIFT' => $shift_selected,
            'CHR_SHIFT' => $this->input->post('choose_shift'),
            'INT_SHIFT_TYPE' => $flag_shift,
            'CHR_WORK_CENTER' => $work_center,
            'INT_CT' => $ct,
            'INT_TT' => $tt,
            'INT_TARGET_PER_SHIFT' => $target,
            'CHR_USERNAME' => $username
        );

        if ('IS_AJAX') {
            echo json_encode($json_data);
        }
    }

    function stop_produce() {
        $documentno = $this->input->post('documentno');
        $codeLs = $this->input->post('ls');
        $work_center = $this->input->post('wc');
        $date = $this->input->post('date');

        $this->prod_result_m->stop_production($documentno);

        $check = $this->line_stop_prod_m->getLineStopMachine($documentno, $codeLs);
        if ($check == 0) {
            $data = true;
        } else {
            $data_update = array(
                'CHR_CREATED_BY' => 'Force LS',
                'CHR_STOP_DATE' => date('Ymd'),
                'CHR_STOP_TIME' => date('His')
            );
            $id_update = array(
                'CHR_WO_NUMBER' => $documentno,
                'CHR_LINE_CODE' => $check['CHR_LINE_CODE'],
                'INT_ID_LINE_STOP' => $check['INT_ID_LINE_STOP']
            );

            $this->line_stop_prod_m->update($data_update, $id_update);

            $data = array(
                'CHR_WORK_CENTER'=> $work_center
            );
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    function insert_display_to_server() {
        $chr_doc_id = $this->input->post('chr_doc_id');
        $int_prdplan = $this->input->post('int_prdplan');
        $int_prdtarget = $this->input->post('int_prdtarget');
        $int_plan_tt = $this->input->post('int_plan_tt');
        $INT_JAM1 = $this->input->post('INT_JAM1');
        $INT_JAM2 = $this->input->post('INT_JAM2');
        $INT_JAM3 = $this->input->post('INT_JAM3');
        $INT_JAM4 = $this->input->post('INT_JAM4');
        $INT_JAM5 = $this->input->post('INT_JAM5');
        $INT_JAM6 = $this->input->post('INT_JAM6');
        $INT_JAM7 = $this->input->post('INT_JAM7');
        $INT_JAM8 = $this->input->post('INT_JAM8');
        $INT_JAM9 = $this->input->post('INT_JAM9');
        $INT_JAM10 = $this->input->post('INT_JAM10');
        $INT_JAM11 = $this->input->post('INT_JAM11');
        $INT_JAM12 = $this->input->post('INT_JAM12');
        $INT_ACT1 = $this->input->post('INT_ACT1');
        $INT_ACT2 = $this->input->post('INT_ACT2');
        $INT_ACT3 = $this->input->post('INT_ACT3');
        $INT_ACT4 = $this->input->post('INT_ACT4');
        $INT_ACT5 = $this->input->post('INT_ACT5');
        $INT_ACT6 = $this->input->post('INT_ACT6');
        $INT_ACT7 = $this->input->post('INT_ACT7');
        $INT_ACT8 = $this->input->post('INT_ACT8');
        $INT_ACT9 = $this->input->post('INT_ACT9');
        $INT_ACT10 = $this->input->post('INT_ACT10');
        $INT_ACT11 = $this->input->post('INT_ACT11');
        $INT_ACT12 = $this->input->post('INT_ACT12');

        $result = $this->prod_result_m->insert_display_to_server($chr_doc_id, $int_prdplan, $int_plan_tt, $int_prdtarget, $INT_JAM1, $INT_JAM2, $INT_JAM3, $INT_JAM4, $INT_JAM5, $INT_JAM6, $INT_JAM7,
    $INT_JAM8, $INT_JAM9, $INT_JAM10, $INT_JAM11, $INT_JAM12, $INT_ACT1, $INT_ACT2, $INT_ACT3, $INT_ACT4, $INT_ACT5, $INT_ACT6, $INT_ACT7, $INT_ACT8, $INT_ACT9,
    $INT_ACT10, $INT_ACT11, $INT_ACT12);

        if ('IS_AJAX') {
            echo json_encode($result);
        }
    }

    //add by BugsMaker 02-11-2016
    public function update_flag_by_work_center() {
        $this->prod_result_m->update_flag_by_work_center($this->input->post('wc'));

        $data = $this->input->post('wc') . ' is flaged with X ';

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    function save_history_reprint() {
        $this->prod_result_m->save_history_reprint($this->input->post('wc'), trim($this->input->post('partno')), gethostbyaddr($_SERVER['REMOTE_ADDR']));

        if ('IS_AJAX') {
            echo json_encode(true);
        }
    }

    function get_all_history_dandory() {
        $wo = trim($this->input->post('wo'));
        $history = $this->prod_result_m->get_all_history_dandory($wo);

        $data = '';
        
        if ($history->num_rows() > 0){
            $data .="<table>";
        }else{
            $data = 'NO HISTORY KANBAN';
        }
        
        if ($history->num_rows() > 0 && $history->num_rows() < 11) {
            $x = 0;
            $data .="<tr>";
            foreach ($history->result() as $value) {
                $data .="<td>$value->CHR_BACK_NO</td>";
                $x++;
            }
            $data .="</tr>";
        } else if ($history->num_rows() > 10 && $history->num_rows() < 21) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 20 && $history->num_rows() < 31) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 30 && $history->num_rows() < 41) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 40 && $history->num_rows() < 51) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 50 && $history->num_rows() < 61) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 60 && $history->num_rows() < 71) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 60) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 61) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 60) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 60 && $x < 71) {
                    if ($x == 61) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 70) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 71) {
                        $data .="<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        }

        
        if ($history->num_rows() > 0){
            $data .="</table>";
        }

        $data_send = str_replace('\/', '/', $data);

        if ('IS_AJAX') {
            echo json_encode($data_send);
        }
    }
    
    //add by bugsmaker 2017-11-02
    function update_tpr_eceran() {
        $wo_number = trim($this->input->post('documentno'));
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $qty_per_box = $this->input->post('qty_per_box');
        $qty_eceran = $this->input->post('qty_eceran');
        $backno = $this->input->post('backno');
        $part_no = $this->input->post('partno');
        $planning = $this->input->post('planning');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $json_data = array('prod_result' => false, 'message' => false);

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $backno);
        $allow_retail = $this->history_in_line_scan_m->get_sum_qty_by_work_order($wo_number, $qty_eceran, $qty_per_box, $backno, $data->INT_NUMBER);

        if ($allow_retail == 0) {

            $update = array(
                'INT_ACTUAL' => $qty_eceran,
                'INT_TOTAL_QTY' => $qty_eceran,
                'CHR_COMPLETE' => NULL
            );

            $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);

            $data_history = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_PLAN' => $planning,
                'INT_DANDORI' => $data->INT_NG_OTHERS_REV,
                'INT_QTY_PERSCAN' => intval($qty_eceran),
                'CHR_PART_NO' => $part_no,
                'CHR_BACK_NO' => $backno,
                'CHR_DATE' => $date,
                'CHR_SHIFT' => $shift,
                'CHR_WORK_CENTER' => $work_center,
                'INT_NUMBER_REF' => $data->INT_NUMBER,
                'CHR_BARCODE_KANBAN' => 'Eceran',
                'CHR_STATUS_DATA' => 'CREATE', 
                'CHR_CREATED_BY' => $data->CHR_CREATED_BY,
                'CHR_CREATED_DATE' => $date_entry,
                'CHR_CREATED_TIME' => $time_entry
            );

            $this->history_in_line_scan_m->save($data_history);

            $json_data['prod_result'] = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);

        } else {
            $qty_allow = (int) $qty_per_box - 1;
            $json_data['message'] = 'Tidak bisa menginput lebih dari ' . $qty_allow . ' Piece(s)';
            $json_data['prod_result'] = false;
        }

        echo json_encode($json_data);
    }

}
