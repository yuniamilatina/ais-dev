<?php

class ines_ogawa_spps_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pes/target_production_m');
        $this->load->model('pes/line_stop_prod_m');
        $this->load->model('pes/prod_result_m');
        $this->load->model('pes/history_in_line_scan_m');
        $this->load->model('basis/user_m');
        $this->load->model('prd/setup_chute_m');
        $this->load->model('prd/one_way_kanban_m');
        $this->load->model('prd/data_tester_m');
        $this->load->model('part/process_part_m');
        $this->load->model('part/part_customer_m');
        $this->load->model('prd/logs_in_line_scan_m');
    }

    public function line($work_center = null) {
        $data['wc'] = $work_center;
        // $this->load->view('pes/ines_ogawa_spps_v', $data);
    }

    public function dandori_setup_chute() {
        $work_center = $this->input->post('wc');
        $wo = $this->input->post('wo');
        $date = $this->input->post('dateprod');

        $data = array('data_chute' => false, 'methode_flag' => false, 'message' => false );

        $data_setup_chute = $this->setup_chute_m->get_top_1_setup_chute_by_work_center_and_date($work_center);
        if ($data_setup_chute->num_rows() > 0) {
            $data['data_chute'] = $data_setup_chute->row();
            $data['methode_flag'] = $this->process_part_m->get_data_process_part_by_partno($data_setup_chute->row()->CHR_PART_NO ,$work_center);
        }else{
            $data['message'] = 'Sorry, Setup Chute Not Found';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function check_existing_label(){
        $part_no = $this->input->post('partno');
        $work_center = $this->input->post('wc');

        $data = array('exist' => false);

        $data_shiping_part = $this->process_part_m->get_data_part_customer_by_work_center($part_no, $work_center);

        if($data_shiping_part){
            $data['exist'] = true;
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function compare_label() {
        $part_no = $this->input->post('partno');
        $abstrack_barcode = trim($this->input->post('label_barcode'));
        $work_center = trim($this->input->post('wc'));

        $abstrack_barcode_array =  (explode(" ",$abstrack_barcode));
        $part_no_cust_1 = trim(str_replace('%',' ',$abstrack_barcode_array[0]));
        $part_no_cust = trim(str_replace('L',' ',$part_no_cust_1));
        $part_no_cust = trim(str_replace('Q',' ',$part_no_cust));

        if(strlen($part_no_cust) > 12){
            $part_no_cust = substr($part_no_cust,0,12);
        }

        $data = array('match' => false, 'message' => false);

        $match_flag = $this->part_customer_m->verify_part_no_with_customer($part_no, $part_no_cust);

        if($match_flag){
            $data['match'] = true;
        }else{
            $data['message'] = 'Part '.$part_no.' not match with cust part no '. $part_no_cust;
            
            $log_data = array(
                'CHR_CREATED_BY' => 'compare_label',
                'CHR_WORK_CENTER' => $work_center, 
                'CHR_PART_NO' => $part_no ,
                'CHR_MESSAGE' => $data['message'], 
                'CHR_BARCODE' => $abstrack_barcode 
            );

            $this->logs_in_line_scan_m->save($log_data);
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function get_prd_order_no(){
        $work_center = $this->input->post('wc');
        $prod_order_no = $this->input->post('prod_order_no');

        $data = array('status' => false, 'prd_order_no' => '', 'message' => '');
        
        $flag_exist = $this->setup_chute_m->get_ready_prod($work_center); 

        if($flag_exist){
            if (trim($flag_exist->CHR_PRD_ORDER_NO) == trim($prod_order_no)) {
                $data['status'] = true;
                $data['prd_order_no'] = $prod_order_no;
            } else {
                $data['prd_order_no'] = trim($flag_exist->CHR_PRD_ORDER_NO);
                $data['message'] = 'Production Order Number tidak sesuai.';
            }
        }else{
            $data['prd_order_no'] = trim($flag_exist->CHR_PRD_ORDER_NO);
            $data['message'] = 'Production Order Number tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function check_kanban() {     
        
        $order_code = $this->input->post('order_code');
        $backno = $this->input->post('backno');
        $serial = $this->input->post('serial');
        $work_center = $this->input->post('wc');
        $prod_order_no = $this->input->post('prod_order_no');

        $data = array('kanban' => false, 'data' => false);

        if($order_code == $prod_order_no){
            $flag_exist = $this->one_way_kanban_m->get_verification_prd_order_no_by_orderno($order_code, $serial); 

            if ($flag_exist == true) {
                $data['kanban'] = true;
                $data['data'] = 'Order code : ' .$order_code.', serial : '. $serial;
            } else {
                $data['message'] = 'Kanban tidak ditemukan.';
            }

        } else {
            $data['message'] = 'Salah memindai kanban, pastikan kanban one way yang dipindai.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function check_product_by_barcode() {
        $barcode_product = $this->input->post('barcode_product');
        $backno = $this->input->post('backno');
        $part_no = $this->input->post('partno');
        $prd_order_no = $this->input->post('prd_order_no');
        $work_center = $this->input->post('wc');

        $data = array('status' => false, 'message' => false);

        if($prd_order_no != '' || $prd_order_no !=  NULL){
            $data_product = $this->data_tester_m->get_detail_product_by_barcode($work_center, $barcode_product);            

            if ($data_product->num_rows() > 0) {
                $data_scan_product = $this->data_tester_m->get_scan_product_by_barcode($work_center, $barcode_product);

                if ($data_scan_product->num_rows() > 0) {
                    $data['message'] = "Data product ".$barcode_product." sudah pernah dipindai";
                
                    $log_data = array( 
                        'CHR_CREATED_BY' => 'check_product_by_barcode',
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_PRD_ORDER_NO' => $prd_order_no,
                        'CHR_PART_NO' => $part_no ,
                        'CHR_MESSAGE' => $data['message'], 
                        'CHR_BARCODE' => $barcode_product 
                    );
                    
                    $this->logs_in_line_scan_m->save($log_data);
                
                }else{
                    $data['status'] = true;
                }
            } else {
                $data['message'] = "Data product ".$barcode_product." tidak terdaftar pada master traceability line ".$work_center;

                $log_data = array( 
                    'CHR_CREATED_BY' => 'check_product_by_barcode',
                    'CHR_WORK_CENTER' => $work_center, 
                    'CHR_PRD_ORDER_NO' => $prd_order_no, 
                    'CHR_PART_NO' => $part_no ,
                    'CHR_MESSAGE' => $data['message'], 
                    'CHR_BARCODE' => $barcode_product
                );

                $this->logs_in_line_scan_m->save($log_data);
            }
        }else{
            $data['message'] = "parameter prd order number tidak ada";
        }

        echo json_encode($data);
    }

    public function update_product(){
        $prod_order_no = trim($this->input->post('prod_order_no'));
        $wo_number = trim($this->input->post('documentno'));
        $work_center = substr(trim($this->input->post('documentno')), 0, -16);
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $barcode_product = trim($this->input->post('barcode_product'));
        $backno = trim($this->input->post('backno'));
        $part_no = $this->input->post('partno');
        $planning = $this->input->post('planning');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $data_json = array('status' => false, 'total_scan' => 0, 'message' => '');

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $backno);
        $data_json['problem'] = $data;

        $update['INT_ACTUAL'] = 1;
        $update['INT_TOTAL_QTY'] = 0;
        $update['CHR_COMPLETE'] = NULL;
        
        $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);
        $this->setup_chute_m->update_actual_pcs($prod_order_no);

        $data_tester = $this->data_tester_m->get_detail_product_by_barcode($work_center, $barcode_product);

        if($data_tester->num_rows() > 0){
            $data_json['status'] = true;
            $this->data_tester_m->update_flag_scan_product($work_center, $prod_order_no, $barcode_product);
            $data_json['data'] = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);
        }else{
            $data_json['message'] = 'Tidak ada data product '.$prod_order_no.'  dengan barcode '.$barcode_product ;

            $log_data = array( 
                'CHR_CREATED_BY' => 'update_product',
                'CHR_PRD_ORDER_NO' => $prod_order_no, 
                'CHR_WORK_CENTER' => $work_center, 
                'CHR_PART_NO' => $part_no ,
                'CHR_MESSAGE' => $data_json['message'], 
                'CHR_BARCODE' => $barcode_product 
            );
            $this->logs_in_line_scan_m->save($log_data);
        }

        //get latest scan result production
        $previous_history_data = $this->prod_result_m->get_manual_data_production($wo_number, $backno);

        $data_history = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_PLAN' => $planning,
            'INT_DANDORI' => $previous_history_data->INT_NG_OTHERS_REV,
            'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($prod_order_no),
            'CHR_PRD_ORDER_NO' => $prod_order_no,
            'INT_QTY_PERSCAN' => 1,
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $backno,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
            'INT_NUMBER_REF' => $previous_history_data->INT_NUMBER,
            'CHR_BARCODE_KANBAN' => $barcode_product,
            'CHR_STATUS_DATA' => 'UPDATE', 
            'CHR_CREATED_BY' => $previous_history_data->CHR_CREATED_BY,
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_in_line_scan_m->save($data_history);

        if ('IS_AJAX') {
            echo json_encode($data_json);
        }

    }

    function insert_tpr() {
        $wo_no = trim($this->input->post('wo'));
        $part_no = trim($this->input->post('partno'));
        $ct = trim($this->input->post('ct'));
        $pv = trim($this->input->post('pv'));
        $uom = trim($this->input->post('uom'));
        $part_name = trim($this->input->post('descpart'));
        $planning = $this->input->post('planning');  
        $actual = $this->input->post('actual');
        $qty_per_box = $this->input->post('qty_kanban');
        $back_no = $this->input->post('backno');
        $work_center = $this->input->post('wc');
        $mp = intval($this->input->post('mp'));
        $npk = $this->input->post('npk'); 
        $dateprod = $this->input->post('dateprod'); 
        $prod_order_no = $this->input->post('prod_order_no'); 
        $type_shift = $this->input->post('type_shift'); 
        $shift = str_replace('SHIFT', '', $this->input->post('shift'));
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $month = date('m');
        $target = 0;
        $contact = '';

        $data_target = $this->target_production_m->get_target_production_by_period_and_work_center($month, $work_center);
        if ($data_target->num_rows() > 0) {
            $data['INT_TARGET'] = trim($data_target->row()->INT_TARGET_PER_SHIFT);
        } else {
            $data['INT_TARGET'] = $target;
        }

        $data_user = $this->user_m->get_user_name_by_npk($npk);
        if ($data_user->num_rows() > 0) {
            $data['CHR_USER'] = trim($data_user->row()->CHR_USERNAME); 
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

        $data['INT_QTY_PLAN'] = $planning; 
        $data['CHR_WO_NUMBER'] = $wo_no;
        $data['CHR_DATE'] = $dateprod;
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
        $data['INT_MP'] = $mp;
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
        
        $data_history = array(
            'CHR_WO_NUMBER' => $wo_no,
            'INT_PLAN' => $planning,
            'INT_DANDORI' => $data['INT_NG_OTHERS_REV'],
            'CHR_PRD_ORDER_NO' => $prod_order_no,
            'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($prod_order_no),
            'INT_QTY_PERSCAN' => 0,
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_DATE' => $dateprod,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
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

            //merge into dandori board part no & img
            $data_board_dandori = $this->db->query("SELECT * FROM PRD.TW_DANDORI_BOARD WHERE CHR_WORK_CENTER = '$work_center'");
            if($data_board_dandori->num_rows() > 0){
                
                $data_pos = $this->db->query("SELECT TOP 1 CHR_WORK_CENTER, CHR_PART_NO, CHR_POS_PRD, CHR_IMG_FILE_NAME AS CHR_IMG_URL FROM PRD.TM_POS 
                    WHERE CHR_PART_NO = '$part_no' AND INT_FLG_DEL = 0 ORDER BY CONVERT(INT, CHR_POS_PRD) DESC");
                
                if($data_pos->num_rows() > 0){
                    $image_dandori_board = $data_pos->row()->CHR_IMG_URL;
                }else{
                    $image_dandori_board =  'assets/img/wi/no-image-available.jpg';
                }

                $data_dandori_board_parameter = array(
                    'CHR_PART_NO' => $part_no,
                    'CHR_IMG_URL' => $image_dandori_board
                );

                $this->db->where('CHR_WORK_CENTER', $work_center);
                $this->db->update('PRD.TW_DANDORI_BOARD', $data_dandori_board_parameter);

            }else{

                $data_pos = $this->db->query("SELECT TOP 1 CHR_WORK_CENTER, CHR_PART_NO, CHR_POS_PRD, CHR_IMG_FILE_NAME AS CHR_IMG_URL FROM PRD.TM_POS 
                WHERE CHR_PART_NO = '$part_no' AND INT_FLG_DEL = 0 ORDER BY CONVERT(INT, CHR_POS_PRD) DESC");

                if($data_pos->num_rows() > 0){
                    $image_dandori_board = $data_pos->row()->CHR_IMG_URL;
                }else{
                    $image_dandori_board =  'assets/img/wi/no-image-available.jpg';
                }

                $data_dandori_board_parameter = array(
                    'CHR_PART_NO' => $part_no,
                    'CHR_WORK_CENTER' => $work_center,
                    'CHR_IMG_URL' => $image_dandori_board
                );

                $this->db->insert('PRD.TW_DANDORI_BOARD', $data_dandori_board_parameter);
            }

            $this->setup_chute_m->update_dandori_setup_chute($work_center, $dateprod, $prod_order_no);
            
        }

        $json_data['int_number'] = $id_number;
        $json_data['display'] = array(
            'INT_TOTAL_QTY' => 0,
            'INT_QTY_KANBAN' => $qty_per_box,
            'CHR_WORK_CENTER' => $work_center,
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

    function print_one_way_kanban(){
        $work_center = $this->input->post('wc');
        $prod_order_no = $this->input->post('prod_order_no');
        $npk = $this->input->post('npk'); 
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $data_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban($work_center, $prod_order_no);

        $part_no = trim($data_kbn->CHR_PART_NO);
        $back_no = $data_kbn->CHR_BACK_NO;
        $lot_size = $data_kbn->INT_LOT_SIZE;
        $qty_per_box = trim($data_kbn->INT_QTY_PER_BOX);
        $qty_pcs = $data_kbn->INT_QTY_PCS;
        $box_type = $data_kbn->CHR_BOX_TYPE;
        $part_name = $data_kbn->CHR_PART_NAME;
        $part_no_cust = trim($data_kbn->CHR_CUS_PART_NO);
        $sloc_from = $data_kbn->CHR_SLOC_FROM;
        $sloc_to = $data_kbn->CHR_SLOC_TO;
        $cust_no = $data_kbn->CHR_CUS_NO;
        $rack_no = $data_kbn->CHR_RAKNO;

        $json_data = array('status' => true);

        $check_kanban = $this->one_way_kanban_m->get_serial_by_order_no($prod_order_no);
        if($check_kanban == 0){
            //Insert to table one way kanban, loop depend on lot size
            for($i = 1; $i <= $lot_size; $i++){
                $serial = sprintf('%05u', $i);                   

                $data_row = array(
                    'CHR_SERIAL' => $serial,
                    'CHR_WORK_CENTER' => $work_center,
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'CHR_PART_NO' => $part_no,
                    'CHR_BACK_NO' => $back_no,
                    'INT_LOT_SIZE' => $lot_size,
                    'INT_QTY_PER_BOX' => $qty_per_box,
                    'INT_QTY_PCS' => $qty_pcs,
                    'CHR_CREATED_BY' => $npk,
                    'CHR_CREATED_DATE' => $date_entry,
                    'CHR_CREATED_TIME' => $time_entry
                );   
                $this->one_way_kanban_m->save($data_row); //insert one way kanban
                
                // $get_id_kanban = $this->one_way_kanban_m->get_id_by_serial_and_order_no($prod_order_no, $serial);
                
                // $id_kanban  = sprintf('%06u', $get_id_kanban->INT_ID); 

                $this->load->library('ciqrcode');
                $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust";
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/","",$prod_order_no) . '_' . $back_no . '_' . $serial . '.png'; 
                $this->ciqrcode->generate($params);                    
            }
            
            //Trigger to print server print out kanban
            $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE IP

            if (!$fp) {
                $json_data['print_status'] =  $errno.' - '.$errstr;

                $log_data = array(
                    'CHR_CREATED_BY' => 'print_one_way_kanban',
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'CHR_WORK_CENTER' => $work_center, 
                    'CHR_PART_NO' => $part_no ,
                    'CHR_MESSAGE' => $json_data['print_status'], 
                    'CHR_BARCODE' => '' 
                );

                $this->logs_in_line_scan_m->save($log_data);

            } else {
                //$out = "$work_center|$prod_order_no|$part_no|$back_no|00001|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                $out = "OK|$prod_order_no|$part_no|$back_no|00001|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);

                $json_data['print_status'] = true;

                fclose($fp);
            }
            
        }else{
            $json_data['status'] = false;
            $json_data['message'] = 'Kanban one way sudah pernah dicetak';
        }

        echo json_encode($json_data);
    }

    function save_one_way_kanban(){
        $work_center = $this->input->post('wc');
        $prod_order_no = $this->input->post('prod_order_no');
        $npk = $this->input->post('npk'); 
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $data_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban($work_center, $prod_order_no);

        $part_no = trim($data_kbn->CHR_PART_NO);
        $back_no = $data_kbn->CHR_BACK_NO;
        $lot_size = $data_kbn->INT_LOT_SIZE;
        $qty_per_box = trim($data_kbn->INT_QTY_PER_BOX);
        $qty_pcs = $data_kbn->INT_QTY_PCS;
        $box_type = $data_kbn->CHR_BOX_TYPE;
        $part_name = $data_kbn->CHR_PART_NAME;
        $part_no_cust = trim($data_kbn->CHR_CUS_PART_NO);
        $sloc_from = $data_kbn->CHR_SLOC_FROM;
        $sloc_to = $data_kbn->CHR_SLOC_TO;
        $cust_no = $data_kbn->CHR_CUS_NO;

        $json_data = array('status' => true);

        $check_kanban = $this->one_way_kanban_m->get_serial_by_order_no($prod_order_no);
        if($check_kanban == 0){
            //Insert to table one way kanban, loop depend on lot size
            for($i = 1; $i <= $lot_size; $i++){
                $serial = sprintf('%05u', $i);                   

                $data_row = array(
                    'CHR_SERIAL' => $serial,
                    'CHR_WORK_CENTER' => $work_center,
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'CHR_PART_NO' => $part_no,
                    'CHR_BACK_NO' => $back_no,
                    'INT_LOT_SIZE' => $lot_size,
                    'INT_QTY_PER_BOX' => $qty_per_box,
                    'INT_QTY_PCS' => $qty_pcs,
                    'CHR_CREATED_BY' => $npk,
                    'CHR_CREATED_DATE' => $date_entry,
                    'CHR_CREATED_TIME' => $time_entry
                );   
                $this->one_way_kanban_m->save($data_row); //insert one way kanban
                
                $this->load->library('ciqrcode');
                $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust";
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/","",$prod_order_no) . '_' . $back_no . '_' . $serial . '.png'; 
                $this->ciqrcode->generate($params);                    
            }
        }else{
            $json_data['status'] = false;
            $json_data['message'] = 'Kanban oneway sudah pernah disimpan';
        }

        echo json_encode($json_data);
    }

    function update_tpr() {
        $wo_number = trim($this->input->post('documentno'));
        $shift = substr($wo_number, -1);
        $type_shift_nl = $this->input->post('type_shift');
        if($type_shift_nl == 'N'){
            $shift_type = 0;
        }else{
            $shift_type = 1;
        }
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $actual = $this->input->post('actual');
        $part_no = $this->input->post('partno');
        $backno = $this->input->post('backno');
        $order_code = $this->input->post('order_code');
        $kanban_serial = $this->input->post('serial_no_kanban');
        $planning = $this->input->post('planning');
        $prod_order_no = $this->input->post('prod_order_no');
        $qty_per_box = $this->input->post('qty_kanban');
        $date_entry = date('Ymd');
        $time_entry = date('His');
       
        $json_data = array('prod_result' => false, 'print_status' => false, 'message' => false);

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $backno);

        $update['INT_ACTUAL'] = $qty_per_box; 
        $update['INT_TOTAL_QTY'] = $qty_per_box;
        $update['CHR_COMPLETE'] = NULL;
        
        $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);
        $this->setup_chute_m->update_actual_lot($work_center, $prod_order_no);
        
        $data_one_way_kanban = $this->one_way_kanban_m->get_new_data_one_way_kanban($prod_order_no);

        if($data_one_way_kanban->num_rows() > 0){

            $serial = $data_one_way_kanban->row()->CHR_SERIAL;
            
            $query_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban_update($work_center, $prod_order_no, $serial);

            if($query_kbn->num_rows() > 0){
                $data_kbn = $query_kbn->row();
                $lot_size = $data_kbn->INT_LOT_SIZE;
                $qty_pcs = $data_kbn->INT_QTY_PCS;
                $box_type = $data_kbn->CHR_BOX_TYPE;
                $part_name = $data_kbn->CHR_PART_NAME;
                $part_no_cust = trim($data_kbn->CHR_CUS_PART_NO);
                $sloc_from = $data_kbn->CHR_SLOC_FROM;
                $sloc_to = $data_kbn->CHR_SLOC_TO;
                $cust_no = $data_kbn->CHR_CUS_NO;
                $serial_oneway = $data_kbn->CHR_SERIAL;
                $rack_no = $data_kbn->CHR_RAKNO;

                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5);

                if (!$fp) {
                    $json_data['print_status'] =  $errno.' - '.$errstr;

                    $log_data = array( 
                        'CHR_CREATED_BY' => 'update_tpr',
                        'CHR_PRD_ORDER_NO' => $prod_order_no,
                        'CHR_WORK_CENTER' => $work_center, 
                        'CHR_PART_NO' => $part_no ,
                        'CHR_MESSAGE' => $json_data['print_status'], 
                        'CHR_BARCODE' => '' 
                    );

                    $this->logs_in_line_scan_m->save($log_data);

                } else {
                    //$out = "$work_center|$prod_order_no|$part_no|$backno|$serial_oneway|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    $out = "OK|$prod_order_no|$part_no|$backno|$serial_oneway|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    
                    $json_data['print_status'] = true;

                    fclose($fp);
                }
            }

        }else{
            $json_data['print_status'] = true;
        }

        $previous_history_data = $this->prod_result_m->get_manual_data_production($wo_number, $backno);

        $data_history = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_PLAN' => $planning - $actual,
            'INT_DANDORI' => $previous_history_data->INT_NG_OTHERS_REV,
            'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($prod_order_no),
            'CHR_PRD_ORDER_NO' => $prod_order_no,
            'INT_QTY_PERSCAN' => intval($qty_per_box),
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $backno,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
            'INT_NUMBER_REF' => $previous_history_data->INT_NUMBER,
            'CHR_BARCODE_KANBAN' => $order_code.' '.$kanban_serial,
            'CHR_STATUS_DATA' => 'UPDATE', 
            'CHR_CREATED_BY' => $previous_history_data->CHR_CREATED_BY,
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_in_line_scan_m->save($data_history);
        
        $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
        
        $json_data['data'] = $this->setup_chute_m->get_actual_setup_chute_kanban($prod_order_no);
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
    
    function update_tpr_product() {
        $wo_number = trim($this->input->post('documentno'));
        $shift = substr($wo_number, -1);
        $type_shift_nl = $this->input->post('type_shift');
        if($type_shift_nl == 'N'){
            $shift_type = 0;
        }else{
            $shift_type = 1;
        }
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $actual = $this->input->post('actual');
        $part_no = $this->input->post('partno');
        $backno = $this->input->post('backno');
        $barcode_product = $this->input->post('barcode_product');
        $planning = $this->input->post('planning');
        $prod_order_no = $this->input->post('prod_order_no');
        $qty_per_box = $this->input->post('qty_kanban');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $json_data = array('prod_result' => false, 'print_status' => false, 'message' => false);

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $backno);

        $update['INT_ACTUAL'] = 0;
        $update['INT_TOTAL_QTY'] = $qty_per_box;
        $update['CHR_COMPLETE'] = 'X';
        
        $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);
        $this->setup_chute_m->update_actual_lot_product($work_center, $prod_order_no);

        //===== EDIT FOR PRINT RECOVERY BY ANU --- 20200204 =====//
        $cek_recovery = $this->setup_chute_m->get_status_recovery_by_prod_no($prod_order_no);
        if($cek_recovery->INT_FLG_RECOVERY == 1){
            //$prod_order_no_print = substr($cek_recovery->CHR_PRD_ORDER_NO_REFF,0,19);
            $prod_order_no_print = $prod_order_no; //Update 20200922 - By ANU
        } else {
            $prod_order_no_print = $prod_order_no;
        }
        //===== END UPDATE =====//

        $data_one_way_kanban = $this->one_way_kanban_m->get_new_data_one_way_kanban($prod_order_no_print);

        if($data_one_way_kanban->num_rows() > 0){

            $serial = $data_one_way_kanban->row()->CHR_SERIAL;

            $query_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban_update($work_center, $prod_order_no_print, $serial);

            if($query_kbn->num_rows() > 0){
                $data_kbn = $query_kbn->row();
                $lot_size = $data_kbn->INT_LOT_SIZE;
                $qty_pcs = $data_kbn->INT_QTY_PCS;
                $qty_per_box_print = $data_kbn->INT_QTY_PER_BOX;
                $box_type = $data_kbn->CHR_BOX_TYPE;
                $part_name = $data_kbn->CHR_PART_NAME;
                $part_no_cust = trim($data_kbn->CHR_CUS_PART_NO);
                $sloc_from = $data_kbn->CHR_SLOC_FROM;
                $sloc_to = $data_kbn->CHR_SLOC_TO;
                $cust_no = $data_kbn->CHR_CUS_NO;
                $serial_oneway = $data_kbn->CHR_SERIAL;
                $rack_no = $data_kbn->CHR_RAKNO;
    
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE IP
                    
                   if (!$fp) {
                       $json_data['print_status'] =  $errno.' - '.$errstr;

                       $log_data = array( 
                            'CHR_CREATED_BY' => 'update_tpr_product',
                            'CHR_PRD_ORDER_NO' => $prod_order_no,
                            'CHR_WORK_CENTER' => $work_center, 
                            'CHR_PART_NO' => $part_no ,
                            'CHR_MESSAGE' => $json_data['print_status'], 
                            'CHR_BARCODE' => '' 
                        );
                       $this->logs_in_line_scan_m->save($log_data);

                   } else {
                       //$out = "$work_center|$prod_order_no|$part_no|$backno|$serial_oneway|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                       $out = "OK|$prod_order_no_print|$part_no|$backno|$serial_oneway|$part_no_cust|$lot_size|$qty_per_box_print|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                       fwrite($fp, $out);
                       $json_data['print_status'] = true;

                       fclose($fp);
                   }
                 
            }

        }else{
            $json_data['message'] = 'Data kanban product untuk prd no : '.$prod_order_no_print.', tidak tercreate ';
        }

        $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
        
        $json_data['data'] = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);
        $json_data['prod_result'] = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);
        $json_data['display'] = array(
            'INT_DANDORI' => $data->INT_NG_OTHERS_REV,
            'INT_TOTAL_QTY' => $data_total->INT_TOTAL_QTY,
            'INT_QTY_PERPART' => $data->INT_TOTAL_QTY,
            'CHR_CREATED_TIME' => date('Hi'),
            'CHR_WORK_CENTER' => $work_center,
            'CHR_SHIFT' => $shift,
            'CHR_SHIFT_TYPE' => $shift_type
        );

        echo json_encode($json_data);
    }

    function reprint_kanban(){
        $wo_number = $this->input->post('wo');
        $prod_order_no = $this->input->post('prod_order_no');
        $backno = $this->input->post('backno');
        $part_no = $this->input->post('partno');
        $work_center = $this->input->post('wc');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $json_data = array('prod_order_no' => $prod_order_no, 'print_status' => false, 'message' => false);
        
        $data = $this->one_way_kanban_m->get_one_way_kanban_data_by_order_no($prod_order_no, $work_center);

        if($data){

            $part_no = trim($data->CHR_PART_NO);
            $back_no = $data->CHR_BACK_NO;
            $lot_size = $data->INT_LOT_SIZE;
            $qty_per_box = $data->INT_QTY_PER_BOX;
            $qty_pcs = $data->INT_QTY_PCS;
            $box_type = $data->CHR_BOX_TYPE;
            $part_name = $data->CHR_PART_NAME;
            $part_no_cust = trim($data->CHR_CUS_PART_NO);
            $sloc_from = $data->CHR_SLOC_FROM;
            $sloc_to = $data->CHR_SLOC_TO;
            $cust_no = $data->CHR_CUS_NO;
            $serial_no = $data->CHR_SERIAL;
            $rack_no = $data->CHR_RAKNO;
            
            $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE IP
            
            if (!$fp) {
                $json_data['print_status'] =  $errno.' - '.$errstr;

                $log_data = array( 
                    'CHR_CREATED_BY' => 'reprint_kanban',
                    'CHR_PRD_ORDER_NO' => $prod_order_no, 
                    'CHR_WORK_CENTER' => $work_center, 
                    'CHR_PART_NO' => $part_no ,
                    'CHR_MESSAGE' => $json_data['print_status'], 
                    'CHR_BARCODE' => '' 
                );
                $this->logs_in_line_scan_m->save($log_data);

            } else {
                $out = "OK|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                $json_data['print_status'] = true;

                fclose($fp);
            }
        }else{
            $json_data['message'] = 'Data kanban tidak tercreate.';
        }
        
        echo json_encode($json_data);
    }

    function insertng() {
        $wo_number = $this->input->post('wo');
        $qty = $this->input->post('qty');
        $ng = $this->input->post('ng');
        $backno = $this->input->post('backno');
        $part_no = $this->input->post('partno');
        $work_center = $this->input->post('wc');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $prod_order_no = $this->input->post('prod_order_no');

        $json_data = array('print_status' => false, 'message' => false);

        $prsdata = $this->prod_result_m->get_auto_data_production($wo_number, $backno);

        $update['INT_NG_PRC'] = 0;
        $update['INT_NG_SETUP'] = 0;
        $update['INT_NG_BRKNTEST'] = 0;
        $update['INT_NG_TRIAL'] = 0;
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

        // $log_data = array( 
        //     'CHR_CREATED_BY' => 'insertng',
        //     'CHR_PRD_ORDER_NO' => $prod_order_no, 
        //     'CHR_WORK_CENTER' => $work_center, 
        //     'CHR_WO_NUMBER' => $wo_number, 
        //     'CHR_PART_NO' => $part_no ,
        //     'CHR_MESSAGE' => 'qty :'. $qty . 'ng :' . $ng, 
        //     'CHR_BARCODE' => '' 
        // );
        // $this->logs_in_line_scan_m->save($log_data);

        
        //validate pcs qty ng > qty plan
        $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);

        if($qty > ((int)$data_setup_chute->INT_QTY_PER_BOX - (int)$data_setup_chute->ACTUAL_PART)){
            $json_data['status'] = false;
            $json_data['message'] = 'Inputan NG tidak boleh melebihi '. ((int)$data_setup_chute->INT_QTY_PER_BOX - (int)$data_setup_chute->ACTUAL_PART). ' pcs ';
        }else{
            $json_data['status'] = true;
            $this->prod_result_m->update_production_result_ng($update, $prsdata->INT_NUMBER, trim($prsdata->CHR_IP));
        
            //===== FUNCTION FOR PRINT UNCOMPLETE KANBAN --- EDIT BY ANU - 20200204 =====//
            // $data_uncomplete = $this->prod_result_m->get_last_data_prod_order($wo_number, $backno);
            // if($data_uncomplete->INT_FLG_RECOVERY == 1){
            //     $prod_order_no = substr($data_uncomplete->CHR_PRD_ORDER_NO_REFF,0,19);
            // } else {
            //     $prod_order_no = $data_uncomplete->CHR_PRD_ORDER_NO;
            // }

            // $qty_per_box = $data_uncomplete->INT_QTY_PER_BOX;
            // $qty_pcs = $data_uncomplete->INT_QTY_PCS;
            // $qty_act = $data_uncomplete->INT_QTY_PCS_ACTUAL;
            
            // $qty_diff = $qty_pcs - $qty_act;
            // $qty_diff_ecer = $qty_diff % $qty_per_box;

            // $lot_size = $data_uncomplete->INT_LOT_SIZE;
            // $back_no = $backno;
            // $box_type = "NG";
            // $part_name = $data_uncomplete->CHR_PART_NAME;
            // $part_no_cust = "-";
            // $sloc_from = "-";
            // $sloc_to = "-";
            // $cust_no = "-";
            // $serial_no = "-";
            // $rack_no = "-";
                
            // $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); 
                
            // if (!$fp) {
            //     $json_data['print_status'] =  $errno.' - '.$errstr;

            //     $log_data = array( 'CHR_CREATED_BY' => 'print_uncomplete_kanban','CHR_WORK_CENTER' => $work_center, 'CHR_PART_NO' => $part_no ,'CHR_MESSAGE' => $json_data['print_status'], 'CHR_BARCODE' => '' );
            //     $this->logs_in_line_scan_m->save($log_data);

            // } else {
            //     $out = "NG|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_diff_ecer|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
            //     fwrite($fp, $out);
            //     $json_data['print_status'] = true;

            //     fclose($fp);
            // }
            //===== END FUNCTION FOR PRINT UNCOMPLETE KANBAN --- EDIT BY ANU - 20200204 =====//
            
        }

        echo json_encode($json_data);
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
        // $npk_followup = $this->input->post('npk_followup');
        $work_center = substr(trim($this->input->post('documentno')), 0, -16);

        $data_line_stop = $this->line_stop_prod_m->getLineStopMachine($wo, $codeLs);

        $data_update = array(
            'CHR_STOP_DATE' => date('Ymd'),
            'CHR_STOP_TIME' => date('His')//,
            // 'CHR_FOLLOWUP_BY' => $npk_followup
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

    function set_scan_serial() {

        $order_code = $this->input->post('order_code');
        $serial = $this->input->post('serial_no_kanban');
        $date = date('Ymd');
        $time = date('His');

        $data = array(
            'INT_FLG_SCANNED' => 1,
            'CHR_MODIFIED_DATE' => $date,
            'CHR_MODIFIED_TIME' => $time
        );
        $id = array(
            'CHR_PRD_ORDER_NO' => $order_code,
            'CHR_SERIAL' => $serial
        );
        $this->one_way_kanban_m->update($data, $id);

        echo json_encode($id);
    }

    function get_scan_serial($serial) {

        $data = array('kanban' => TRUE, 'message' => false);

        $serial = str_replace("-", "/", $serial);
        $serial = str_replace("-", "/", $serial);
        $serial = str_replace("%20%20%20%20%20%20", " ", $serial);   
        $serial = str_replace("%20%20%20%20%20", " ", $serial);   
        $serial = str_replace("%20%20%20", " ", $serial);   
        $serial = str_replace("%20%20", " ", $serial);   
        $serial = str_replace("%20", " ", $serial);   

        $dataSerial = explode(" ", $serial);

        if(count($dataSerial) == 4 || count($dataSerial) == 5){

            $data_kanban = $this->one_way_kanban_m->get_history_scan_kanban_by_order_no($dataSerial[0], $dataSerial[1]);

            if($data_kanban){
                $data['kanban'] = false;
            }else{
                $data['message'] = "Prod order no " . $dataSerial[0] . " dengan serial " . $dataSerial[1] . " Sudah pernah dipindai / diecer";
            }

        }else{
           $data['message'] = "Salah memindai kanban, pastikan kanban produksi yang dipindai - ". $serial;
        }

        echo json_encode($data);
    }

    public function get_total_actual_by_shift() {
        $wo = $this->input->post('wo');

        $row_part = $this->prod_result_m->get_total_actual_by_shift($wo);
        $data['total_pieces'] = 'TOTAL OK: ' . $row_part['INT_TOTAL_QTY'] . ' /Pcs';
        $data['total_ng'] = 'TOTAL NG : ' . $row_part['INT_TOTAL_NG'] . ' /Pcs';
        if ($data == NULL) {
            $data['total_pieces'] = 'TOTAL OK: 0 /Pcs';
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

        if(strlen((string)$npk) == 3){
            $npk_string = '0'.$npk;
        }else if(strlen((string)$npk) == 2){
            $npk_string = '00'.$npk;
        }else if(strlen((string)$npk) == 1){
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

            $y = 0;
            foreach ($history->result() as $value) {
                $param_label[$y] = trim($value->CHR_BACK_NO);
                $param_qty[$y] = trim($value->INT_QTY_OK);
                $y++;
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

    public function registration() {
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

    function get_setup_chute(){
        $date = $this->input->post('date');
        $work_center = $this->input->post('wc');

        $data = array('chute' => false, 'message' => false );

        $data_setup_chute= $this->setup_chute_m->update_setup_chute_ready_to_use($work_center, $date);

        if ($data_setup_chute->num_rows() > 0) {
            $data['chute'] = true;
        } else {
            $data['message'] = 'Setup chute tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    function stop_produce() {
        $documentno = $this->input->post('documentno');
        $codeLs = $this->input->post('ls');
        $work_center = $this->input->post('wc');
        $date = $this->input->post('date');

        $this->setup_chute_m->update_setup_chute_not_use($work_center, $date);

        $this->prod_result_m->stop_production($documentno);

        //dandori board
        $this->db->query("DELETE PRD.TW_DANDORI_BOARD WHERE CHR_WORK_CENTER = '$work_center'");

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

    public function update_flag_by_work_center() {
        $this->prod_result_m->update_flag_by_work_center($this->input->post('wc'));

        $data = $this->input->post('wc') . ' is flaged with X ';

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function check_previous_complete_stat(){
        $work_center = trim($this->input->post('wc'));

        $data_array = array('data_chute' => false, 'message' => false);

        $data_uncomplete_lot = $this->setup_chute_m->get_uncomplete_lot_data_new($work_center);

        if($data_uncomplete_lot->num_rows() > 0){         
            $data_array['data_chute'] = $data_uncomplete_lot->row();
            $data_uncomplete = $data_uncomplete_lot->row();
            $data_array['message'] = 'Kanban kurang '.$data_uncomplete_lot->row()->INT_LOT_SIZE_ACTUAL.' Lot, untuk bisa Dandori silahkan hubungi PPIC';
        
            //===== FUNCTION FOR PRINT UNCOMPLETE KANBAN --- EDIT BY ANU - 20200204 =====//
            // $data_uncomplete = $this->prod_result_m->get_last_data_prod_order($wo_number, $backno);
            if($data_uncomplete->INT_FLG_RECOVERY == 1){
                $prod_order_no = substr($data_uncomplete->CHR_PRD_ORDER_NO_REFF,0,19);
                $data_outstd_qty = $this->setup_chute_m->get_outstd_qty_uncomplete($prod_order_no);
                $outstd_qty = $data_outstd_qty->row();

                $qty_per_box = $outstd_qty->INT_QTY_PER_BOX;
                $qty_pcs = $outstd_qty->INT_QTY_PCS;
                $qty_act = $outstd_qty->INT_QTY_PCS_ACTUAL_TOTAL;
                
                $qty_diff = $qty_pcs - $qty_act;
                $qty_diff_ecer = $qty_per_box - ($qty_diff % $qty_per_box);

            } else {
                $prod_order_no = $data_uncomplete->CHR_PRD_ORDER_NO;

                $qty_per_box = $data_uncomplete->INT_QTY_PER_BOX;
                $qty_pcs = $data_uncomplete->INT_QTY_PCS;
                $qty_act = $data_uncomplete->INT_QTY_PCS_ACTUAL;
                
                $qty_diff = $qty_pcs - $qty_act;
                $qty_diff_ecer = $qty_per_box - ($qty_diff % $qty_per_box);
            }            

            if($qty_diff_ecer > 0){
                $part_no = $data_uncomplete->CHR_PART_NO;
                $lot_size = $data_uncomplete->INT_LOT_SIZE;
                $back_no = $data_uncomplete->CHR_BACK_NO;
                $box_type = "NG";
                $part_name = $data_uncomplete->CHR_PART_NAME;
                $part_no_cust = "-";
                $sloc_from = "-";
                $sloc_to = "-";
                $cust_no = "-";
                $serial_no = "-";
                $rack_no = "-";
                    
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); 
                    
                if (!$fp) {
                    $json_data['print_status'] =  $errno.' - '.$errstr;

                    $log_data = array( 
                        'CHR_CREATED_BY' => 'print_uncomplete_kanban',
                        'CHR_PRD_ORDER_NO' => $prod_order_no, 
                        'CHR_WORK_CENTER' => $work_center, 
                        'CHR_PART_NO' => $part_no ,
                        'CHR_MESSAGE' => $json_data['print_status'], 
                        'CHR_BARCODE' => '' 
                    );

                    $this->logs_in_line_scan_m->save($log_data);

                } else {
                    $out = "NG|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_diff_ecer|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    $json_data['print_status'] = true;

                    //=== DI COMMENT UNTUK DI LOCK AGAR KETIKA DANDORI UNCOMPLETE HARUS HUB PPC ===//
                    //=== DI UNCOMMENT UNTUK UNLOCK AGAR MP PRODUKSI BISA DANDORI TANPA HUB PPC ===//
                    // $update_finish = array(
                    //     'INT_FLG_ADJUST_FINISH' => 1,
                    //     'CHR_NOTES_UNCOMPLETE' => 'Print Uncomplete',
                    //     'CHR_EDITED_BY' => 'System',
                    //     'CHR_EDITED_DATE' => date('Ymd'),
                    //     'CHR_EDITED_TIME' => date('His')
                    // );
            
                    // $this->setup_chute_m->update_by_prod_order_no($data_uncomplete->CHR_PRD_ORDER_NO, $update_finish);

                    fclose($fp);
                }
            }
            
            //===== END FUNCTION FOR PRINT UNCOMPLETE KANBAN --- EDIT BY ANU - 20200204 =====//
        }        

        if ('IS_AJAX') {
            echo json_encode($data_array);
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
        $prod_order_no = $this->input->post('prod_order_no');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $json_data = array('prod_result' => false, 'message' => false);

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $backno);
        
        $data_one_way_kanban = $this->one_way_kanban_m->get_one_way_kanban_printed_by_prd_order($prod_order_no);
        
        if($data_one_way_kanban){
            $allow_retail = $this->history_in_line_scan_m->get_sum_qty_by_work_order_ogawa($wo_number, $qty_eceran, $qty_per_box, $backno, $data->INT_NUMBER);

            if ($allow_retail == 0) {
    
                $reretail = $this->setup_chute_m->update_eceran_setup_chute($prod_order_no, $qty_eceran);

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
                    'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($prod_order_no),
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'INT_QTY_PERSCAN' => intval($qty_eceran),
                    'CHR_PART_NO' => $part_no,
                    'CHR_BACK_NO' => $backno,
                    'CHR_DATE' => $date,
                    'CHR_SHIFT' => $shift,
                    'CHR_WORK_CENTER' => $work_center,
                    'INT_NUMBER_REF' => $data->INT_NUMBER,
                    'CHR_BARCODE_KANBAN' => $data_one_way_kanban->CHR_PRD_ORDER_NO.' '.$data_one_way_kanban->CHR_SERIAL,
                    'CHR_STATUS_DATA' => 'ECERAN', 
                    'CHR_CREATED_BY' => $data->CHR_CREATED_BY,
                    'CHR_CREATED_DATE' => $date_entry,
                    'CHR_CREATED_TIME' => $time_entry
                );
    
                $this->history_in_line_scan_m->save($data_history);
                
                // if($reretail == 1){

                //     //FLAG SCANNED
                //     $data = array(
                //         'INT_FLG_SCANNED' => 1,
                //         'CHR_MODIFIED_DATE' => $date_entry,
                //         'CHR_MODIFIED_TIME' => $time_entry
                //     );

                //     $id = array(
                //         'INT_ID' => (int)$data_one_way_kanban->INT_ID,
                //         'CHR_SERIAL' => $data_one_way_kanban->CHR_SERIAL
                //     );

                //     $this->one_way_kanban_m->update($data, $id);
                    
                //     $data_one_way_kanban = $this->one_way_kanban_m->get_new_data_one_way_kanban($prod_order_no);

                //     if($data_one_way_kanban->num_rows() > 0){

                //         $serial = $data_one_way_kanban->row()->CHR_SERIAL;
                        
                //         $query_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban_update($work_center, $prod_order_no, $serial);

                //         if($query_kbn->num_rows() > 0){
                //             $data_kbn = $query_kbn->row();
                //             $lot_size = $data_kbn->INT_LOT_SIZE;
                //             $qty_pcs = $data_kbn->INT_QTY_PCS;
                //             $box_type = $data_kbn->CHR_BOX_TYPE;
                //             $part_name = $data_kbn->CHR_PART_NAME;
                //             $part_no_cust = trim($data_kbn->CHR_CUS_PART_NO);
                //             $sloc_from = $data_kbn->CHR_SLOC_FROM;
                //             $sloc_to = $data_kbn->CHR_SLOC_TO;
                //             $cust_no = $data_kbn->CHR_CUS_NO;
                //             $serial_oneway = $data_kbn->CHR_SERIAL;

                //             $fp = fsockopen("172.16.6.35", 1234, $errno, $errstr, 5);

                //             if (!$fp) {
                //                 $json_data['print_status'] =  $errno.' - '.$errstr;

                //                 $log_data = array( 'CHR_CREATED_BY' => 'update_tpr','CHR_WORK_CENTER' => $work_center, 'CHR_PART_NO' => $part_no ,'CHR_MESSAGE' => $json_data['print_status'], 'CHR_BARCODE' => '' );
                //                 $this->logs_in_line_scan_m->save($log_data);

                //             } else {
                //                 $out = "$work_center|$prod_order_no|$part_no|$backno|$serial_oneway|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name";
                //                 fwrite($fp, $out);
                                
                //                 $json_data['print_status'] = true;

                //                 fclose($fp);
                //             }
                //         }

                //     }else{
                //         $json_data['print_status'] = true;
                //     }
                // }
                
                $json_data['prod_result'] = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);
                $json_data['data'] = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);
    
            } else {
                $qty_allow = (int) $qty_per_box - 1;
                $json_data['message'] = 'Tidak bisa menginput lebih dari ' . $qty_allow . ' Piece(s)';
                $json_data['prod_result'] = false;
            }
        }else{
            $json_data['message'] = 'Data one way kanban tidak ada.';
            $json_data['prod_result'] = false;
        }

        

        echo json_encode($json_data);
    }
    
    function print_one_way_kanban_manual(){
        $id = $this->input->post('id');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $json_data = array('id' => $id, 'print_status' => false, 'message' => false);
        
        $data = $this->one_way_kanban_m->get_one_way_kanban_data_by_id($id);

        if($data){

            $part_no = trim($data->CHR_PART_NO);
            $back_no = $data->CHR_BACK_NO;
            $lot_size = $data->INT_LOT_SIZE;
            $qty_per_box = $data->INT_QTY_PER_BOX;
            $qty_pcs = $data->INT_QTY_PCS;
            $box_type = $data->CHR_BOX_TYPE;
            $part_name = $data->CHR_PART_NAME;
            $part_no_cust = trim($data->CHR_CUS_PART_NO);
            $sloc_from = $data->CHR_SLOC_FROM;
            $sloc_to = $data->CHR_SLOC_TO;
            $cust_no = $data->CHR_CUS_NO;
            $serial_no = $data->CHR_SERIAL;
            $rack_no = $data->CHR_RAKNO;
            $prod_order_no = $data->CHR_PRD_ORDER_NO;
            
            $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE IP
            
            if (!$fp) {
                $json_data['print_status'] =  $errno.' - '.$errstr;

                $log_data = array( 
                    'CHR_CREATED_BY' => 'print_one_way_kanban_manual',
                    'CHR_PRD_ORDER_NO' => $prod_order_no, 
                    'CHR_WORK_CENTER' => $work_center, 
                    'CHR_PART_NO' => $part_no ,
                    'CHR_MESSAGE' => $json_data['print_status'], 
                    'CHR_BARCODE' => '' 
                );
                $this->logs_in_line_scan_m->save($log_data);

            } else {
                $out = "OK|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                $json_data['print_status'] = true;

                fclose($fp);
            }
        }else{
            $json_data['message'] = 'Data kanban tidak tercreate.';
        }
        
        echo json_encode($json_data);
    }
    
    function get_label_one_way_by_id_setup_chute() {
        $id_setup_chute = trim($this->input->post('id_setup_chute'));

        $history = $this->one_way_kanban_m->get_label_one_way_by_id_setup_chute($id_setup_chute);

        $data = '';
        
        if ($history->num_rows() > 0){
            $data .="<table>";
        }else{
            $data = 'NO HISTORY LABEL';
        }
        
        if ($history->num_rows() > 0 && $history->num_rows() < 11) {
            $x = 0;
            $data .="<tr>";
            foreach ($history->result() as $value) {
                $data .="<td>$value->CHR_SERIAL</td>";
                $x++;
            }
            $data .="</tr>";
        } else if ($history->num_rows() > 10 && $history->num_rows() < 21) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 20 && $history->num_rows() < 31) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 30 && $history->num_rows() < 41) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 40 && $history->num_rows() < 51) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 50 && $history->num_rows() < 61) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 60 && $history->num_rows() < 71) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 60) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 61) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 60) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 60 && $x < 71) {
                    if ($x == 61) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 70) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 71) {
                        $data .="<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .="<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .="<td>$value->CHR_SERIAL</td>";
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

}
