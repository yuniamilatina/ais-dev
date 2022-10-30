<?php

class ines_ogawa_trial_c extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('part/process_part_m');
        $this->load->model('part/part_customer_m');

        $this->load->model('pes/prod_result_m');
        $this->load->model('pes/history_in_line_scan_m');

        $this->load->model('prd/setup_chute_m');
        $this->load->model('prd/one_way_kanban_m');
        $this->load->model('prd/data_tester_m');
        $this->load->model('prd/logs_in_line_scan_m');
        $this->load->model('prd/dandori_board_m');
    }

    public function index($work_center = null)
    {
        $data['work_center'] = $work_center;
        $this->load->view('pes/ines_setup_chute_v', $data);
    }

    public function line($work_center = null)
    {
        $data['work_center'] = $work_center;
        $this->load->view('pes/ines_ogawa_trial_v', $data);
    }

    public function getSetupChute()
    {
        $production_date = '';
        $work_center = $this->input->post('work_center');
        $data = array('status' => false, 'message' => false);

        $data_setup_chute = $this->setup_chute_m->update_setup_chute_ready_to_use($work_center, $production_date);

        if ($data_setup_chute->num_rows() > 0) {
            $data['status'] = true;
        } else {
            $data['message'] = 'Setup chute tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function dandoriSetupChute()
    {
        $work_center = $this->input->post('work_center');

        $data = array('status' => false, 'flg_method' => false);

        $data_setup_chute = $this->setup_chute_m->get_top_1_setup_chute_by_work_center_and_date($work_center);
        if ($data_setup_chute->num_rows() > 0) {

            $method_flg = $this->process_part_m->get_data_process_part_by_partno($data_setup_chute->row()->CHR_PART_NO, $work_center);

            if ($method_flg == 1) {
                $method = 'Scan Label';
            } else if ($method_flg == 2) {
                $method = 'Scan Product';
            } else {
                $method = 'Scan Kanban';
            }

            $data = array(
                'flg_method' => $method_flg,
                'method' => $method,
                'status' => true,
                'back_no' => $data_setup_chute->row()->CHR_BACK_NO,
                'part_no' => $data_setup_chute->row()->CHR_PART_NO,
                'part_name' => $data_setup_chute->row()->CHR_PART_NAME,
                'cycle_time' => $data_setup_chute->row()->INT_CYCLE_TIME,
                'pv' => $data_setup_chute->row()->CHR_PV,
                'uom' => $data_setup_chute->row()->CHR_PART_UOM,
                'qty_box' => $data_setup_chute->row()->INT_QTY_PER_BOX,
                'planning' => $data_setup_chute->row()->INT_LOT_SIZE,
                'actual' => $data_setup_chute->row()->INT_ACTUAL_KANBAN,
                'qty_act_product' => $data_setup_chute->row()->INT_ACTUAL_PCS,
                'prod_order_no' => $data_setup_chute->row()->CHR_PRD_ORDER_NO,
                'prod_order_no_reff' => $data_setup_chute->row()->CHR_PRD_ORDER_NO_REFF
            );
        } else {
            $data['message'] = 'Sorry, Setup Chute Not Found';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function getExistingLabel()
    {
        $part_no = $this->input->post('part_no');
        $work_center = $this->input->post('work_center');
        $data['status'] = false;

        $data_shipping_part = $this->process_part_m->get_data_part_customer_by_work_center($part_no, $work_center);
        if ($data_shipping_part) {
            $data['status'] = true;
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function compareLabel()
    {
        $part_no = $this->input->post('part_no');
        $label_barcode = trim($this->input->post('label_barcode'));
        $work_center = trim($this->input->post('work_center'));
        $data['status'] = false;

        $label_barcode_array =  (explode(" ", $label_barcode));
        $part_no_cust = trim(str_replace('%', ' ', $label_barcode_array[0]));
        $part_no_cust = trim(str_replace('L', ' ', $part_no_cust));
        $part_no_cust = trim(str_replace('Q', ' ', $part_no_cust));

        if (strlen($part_no_cust) > 12) {
            $part_no_cust = substr($part_no_cust, 0, 12);
        }

        $match_flag = $this->part_customer_m->verify_part_no_with_customer($part_no, $part_no_cust);
        if ($match_flag) {
            $data['status'] = true;
        } else {
            $data['message'] = 'Part ' . $part_no . ' not match with cust part no ' . $part_no_cust;
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function getOrderNo()
    {
        $work_center = $this->input->post('work_center');
        $prod_order_no = $this->input->post('prod_order_no');
        $data['status'] = false;

        $data_setup_chute = $this->setup_chute_m->get_ready_prod($work_center);

        if ($data_setup_chute) {
            if (trim($data_setup_chute->CHR_PRD_ORDER_NO) == trim($prod_order_no)) {
                $data['status'] = true;
            } else {
                $data['message'] = 'Production Order Number ' . $prod_order_no . ' tidak sesuai, mohon scan kanban ' . trim($data_setup_chute->CHR_PRD_ORDER_NO);
            }
        } else {
            $data['message'] = 'Barcode tidak dikenali, mohon scan kanban ' . trim($data_setup_chute->CHR_PRD_ORDER_NO);
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function checkScanProductBarcode()
    {
        $barcode_product = trim($this->input->post('barcode_product'));
        $back_no = $this->input->post('back_no');
        $part_no = $this->input->post('part_no');
        $prod_order_no = $this->input->post('prod_order_no');
        $work_center = $this->input->post('work_center');

        $data = array('status' => false, 'message' => false);

        $data_product = $this->data_tester_m->get_data_tester_by_barcode($work_center, $barcode_product, 0);

        if ($data_product->num_rows() > 0) {
            $data_scan_product = $this->data_tester_m->get_data_tester_by_barcode($work_center, $barcode_product, 1);

            if ($data_scan_product->num_rows() > 0) {
                $data['message'] = "Data product " . $barcode_product . " sudah pernah dipindai";

                $log_data = array(
                    'CHR_CREATED_BY' => 'checkScanProductBarcode',
                    'CHR_WORK_CENTER' => $work_center,
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'CHR_PART_NO' => $part_no,
                    'CHR_MESSAGE' => $data['message'],
                    'CHR_BARCODE' => $barcode_product
                );
                $this->logs_in_line_scan_m->save($log_data);
            } else {

                $data_tester_model = $this->data_tester_m->get_data_tester_by_barcode_and_part_no($work_center, $barcode_product, $part_no);
                if ($data_tester_model->num_rows() > 0) {
                    $data['status'] = true;
                } else {
                    $data['message'] = 'Pastikan master model untuk ' . $part_no . ' sudah dimapping.';

                    $log_data = array(
                        'CHR_CREATED_BY' => 'checkScanProductBarcode',
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_PRD_ORDER_NO' => $prod_order_no,
                        'CHR_PART_NO' => $part_no,
                        'CHR_MESSAGE' => $data['message'],
                        'CHR_BARCODE' => $barcode_product
                    );
                    $this->logs_in_line_scan_m->save($log_data);
                }
            }
        } else {

            if ($work_center == 'ASDL06') {
                $data['message'] = "Barcode produk " . $barcode_product . " dengan model " . $back_no . " tidak terdaftar pada traceability line " . $work_center;
            } else {
                $data['message'] = "Barcode produk " . $barcode_product . " dengan model " . substr($barcode_product, -3) . " tidak terdaftar pada traceability line " . $work_center;
            }

            $log_data = array(
                'CHR_CREATED_BY' => 'checkScanProductBarcode',
                'CHR_WORK_CENTER' => $work_center,
                'CHR_PRD_ORDER_NO' => $prod_order_no,
                'CHR_PART_NO' => $part_no,
                'CHR_MESSAGE' => $data['message'],
                'CHR_BARCODE' => $barcode_product
            );
            $this->logs_in_line_scan_m->save($log_data);
        }

        echo json_encode($data);
    }

    public function insertTpr()
    {
        $work_center = $this->input->post('work_center');
        $wo_number = trim($this->input->post('wo_number'));
        $type_shift = $this->input->post('type_shift');
        $shift = str_replace('SHIFT', '', $this->input->post('shift'));
        $back_no = $this->input->post('back_no');
        $part_no = trim($this->input->post('part_no'));
        $part_name = trim($this->input->post('part_name'));
        $qty_per_box = $this->input->post('qty_per_box');
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
        $prod_order_no = $this->input->post('prod_order_no');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $total_dandori = $this->prod_result_m->get_sequence_by_wo($wo_number);

        $data['CHR_USER'] = $username;
        $data['CHR_CREATED_BY'] =  $username;
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

        $data_history = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_PLAN' => $planning - $actual,
            'INT_DANDORI' => $total_dandori,
            'CHR_PRD_ORDER_NO' => $prod_order_no,
            'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($prod_order_no),
            'INT_QTY_PERSCAN' => 0,
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_DATE' => $production_date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_STATUS_DATA' => 'CREATE',
            'CHR_CREATED_BY' => $username,
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $exist = $this->prod_result_m->cek_exist_data($data);
        if ($exist == 0) {
            $this->prod_result_m->update_flag_is_finished($wo_number);
            $id_number = $this->prod_result_m->save_trans($data);
            $this->history_in_line_scan_m->save($data_history);

            $this->setup_chute_m->update_dandori_setup_chute($work_center, $production_date, $prod_order_no);
            $this->dandori_board_m->update_dandori_board($work_center, $part_no);
        }

        $json_data = array(
            'int_number' => $id_number,
            'total_dandori' => $total_dandori
        );

        if ('IS_AJAX') {
            echo json_encode($json_data);
        }
    }

    public function printOneWayKanban()
    {
        $work_center = $this->input->post('work_center');
        $prod_order_no = $this->input->post('prod_order_no');
        $npk = $this->input->post('npk');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $json_data['status'] = true;

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

        // //========== Add Additional Info Kanban - ANU 20210414 ==========//
        $cek_add_info = $this->setup_chute_m->get_additional_info_kanban($part_no);
        $add_info = '';
        if ($cek_add_info->num_rows() > 0) {
            $add_info = $cek_add_info->row()->CHR_KANBAN_ADDITIONAL_INFO;
        }
        // //===============================================================//

        $check_kanban = $this->one_way_kanban_m->get_serial_by_order_no($prod_order_no);
        if ($check_kanban == 0) {
            //Insert to table one way kanban, loop depend on lot size
            for ($i = 1; $i <= $lot_size; $i++) {
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
                $this->one_way_kanban_m->save($data_row);

                $this->load->library('ciqrcode');
                $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $prod_order_no) . '_' . $back_no . '_' . $serial . '.png';
                $this->ciqrcode->generate($params);
            }

            //===== Add logic for trial - By ANU 20220118
            if($work_center == 'SACC03'){ //=== Change work center trial
                $fp = fsockopen("172.16.31.52", 1234, $errno, $errstr, 5); //=== Print from laptop ANU
            } else {
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE
            }

            if (!$fp) {
                $json_data['status'] = false;
                $json_data['message'] =  $errno . ' - ' . $errstr;
            } else {
                $out = "OK|$prod_order_no|$part_no|$back_no|00001|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                fclose($fp);
            }
        } else {

            //add by toro 20210809
            for ($i = 1; $i <= $lot_size; $i++) {
                $serial = sprintf('%05u', $i);

                $this->load->library('ciqrcode');
                $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $prod_order_no) . '_' . $back_no . '_' . $serial . '.png';
                $this->ciqrcode->generate($params);
            }

            //===== Add logic for trial - By ANU 20220118
            if($work_center == 'SACC03'){ //=== Change work center trial
                $fp = fsockopen("172.16.31.52", 1234, $errno, $errstr, 5); //=== Print from laptop ANU
            } else {
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE
            }

            if (!$fp) {
                $json_data['status'] = false;
                $json_data['message'] =  $errno . ' - ' . $errstr;
            } else {
                $out = "OK|$prod_order_no|$part_no|$back_no|00001|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                fclose($fp);
            }

            // $json_data['status'] = false;
            // $json_data['message'] = 'Kanban one way sudah pernah dicetak';
        }

        echo json_encode($json_data);
    }

    public function insertOneWaykanban()
    {
        $work_center = $this->input->post('work_center');
        $prod_order_no = $this->input->post('prod_order_no');
        $npk = $this->input->post('npk');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $json_data['status'] = true;

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

        // //========== Add Additional Info Kanban - ANU 20210414 ==========//
        $cek_add_info = $this->setup_chute_m->get_additional_info_kanban($part_no);
        $add_info = '';
        if ($cek_add_info->num_rows() > 0) {
            $add_info = $cek_add_info->row()->CHR_KANBAN_ADDITIONAL_INFO;
        }
        // //===============================================================//

        $check_kanban = $this->one_way_kanban_m->get_serial_by_order_no($prod_order_no);
        if ($check_kanban == 0) {
            //Insert to table one way kanban, loop depend on lot size
            for ($i = 1; $i <= $lot_size; $i++) {
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
                $this->one_way_kanban_m->save($data_row);

                $this->load->library('ciqrcode');
                $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $prod_order_no) . '_' . $back_no . '_' . $serial . '.png';
                $this->ciqrcode->generate($params);
            }
        } else {

            //add by toro 20210809
            for ($i = 1; $i <= $lot_size; $i++) {
                $serial = sprintf('%05u', $i);

                $this->load->library('ciqrcode');
                $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $prod_order_no) . '_' . $back_no . '_' . $serial . '.png';
                $this->ciqrcode->generate($params);
            }

            // $json_data['status'] = false;
            // $json_data['message'] = 'Kanban one way sudah pernah disimpan';
        }

        echo json_encode($json_data);
    }

    public function updateProduct()
    {
        $prod_order_no = trim($this->input->post('prod_order_no'));
        $wo_number = trim($this->input->post('wo_number'));
        $work_center = substr(trim($this->input->post('wo_number')), 0, -16);
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $barcode_product = trim($this->input->post('barcode_product'));
        $back_no = trim($this->input->post('back_no'));
        $part_no = $this->input->post('part_no');
        $planning = $this->input->post('planning');
        $username = $this->input->post('username');
        $total_dandori = $this->input->post('total_dandori');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $update['INT_ACTUAL'] = 1;
        //20211102
        $update['INT_TOTAL_QTY'] = 1; //0

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $back_no);
        $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);
        $this->setup_chute_m->update_actual_pcs($prod_order_no);
        $this->data_tester_m->update_flag_scan_product($work_center, $prod_order_no, $barcode_product);

        $data_history = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_PLAN' => $planning,
            'INT_DANDORI' => $total_dandori,
            'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($prod_order_no),
            'CHR_PRD_ORDER_NO' => $prod_order_no,
            'INT_QTY_PERSCAN' => 1,
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
            'INT_NUMBER_REF' => $this->prod_result_m->get_id_production($wo_number, $back_no),
            'CHR_BARCODE_KANBAN' => $barcode_product,
            'CHR_STATUS_DATA' => 'UPDATE',
            'CHR_CREATED_BY' => $username,
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_in_line_scan_m->save($data_history);

        $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
        $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);

        $data_json = array(
            'actual' => $data_setup_chute->ACTUAL_KANBAN,
            'qty_act_product' => $data_setup_chute->ACTUAL_PART,
            'total_ok' => $data_total->INT_TOTAL_QTY
        );

        echo json_encode($data_json);
    }

    public function updateTPR()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $int_number = $this->input->post('int_number');
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $username = $this->input->post('username');
        $total_dandori = $this->input->post('total_dandori');
        $actual = $this->input->post('actual');
        $part_no = $this->input->post('part_no');
        $back_no = $this->input->post('back_no');
        $order_code = $this->input->post('order_code');
        $serial_no_kanban = $this->input->post('serial_no_kanban');
        $planning = $this->input->post('planning');
        $prod_order_no = $this->input->post('prod_order_no');
        $qty_per_box = $this->input->post('qty_per_box');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $status = true;
        $message = '';

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $back_no);

        $update['INT_ACTUAL'] = $qty_per_box;
        $update['INT_TOTAL_QTY'] = $qty_per_box;

        $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);
        $this->setup_chute_m->update_actual_lot($work_center, $prod_order_no);

        $data_one_way_kanban = $this->one_way_kanban_m->get_new_data_one_way_kanban($prod_order_no);
        if ($data_one_way_kanban->num_rows() > 0) {

            $serial = $data_one_way_kanban->row()->CHR_SERIAL;
            $query_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban_update($work_center, $prod_order_no, $serial);
            if ($query_kbn->num_rows() > 0) {
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

                //===== Add logic for trial - By ANU 20220118
                if($work_center == 'SACC03'){ //=== Change work center trial
                    $fp = fsockopen("172.16.31.52", 1234, $errno, $errstr, 5); //=== Print from laptop ANU
                } else {
                    $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE
                }

                if (!$fp) {
                    $status = false;
                    $message =  $errno . ' - ' . $errstr;
                } else {
                    $out = "OK|$prod_order_no|$part_no|$back_no|$serial_oneway|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    $status = true;
                    fclose($fp);

                    $data_update_one_way_kanban = array(
                        'INT_FLG_SCANNED' => 1,
                        'CHR_MODIFIED_DATE' => $date_entry,
                        'CHR_MODIFIED_TIME' => $time_entry
                    );
                    $id = array(
                        'CHR_PRD_ORDER_NO' => $order_code,
                        'CHR_SERIAL' => $serial_no_kanban
                    );
                    $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);
                }
            }
        }

        $data_history = array(
            'CHR_WO_NUMBER' => $wo_number,
            'INT_PLAN' => $planning - $actual,
            'INT_DANDORI' => $total_dandori,
            'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($prod_order_no),
            'CHR_PRD_ORDER_NO' => $prod_order_no,
            'INT_QTY_PERSCAN' => intval($qty_per_box),
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
            'INT_NUMBER_REF' => $int_number,
            'CHR_BARCODE_KANBAN' => $order_code . ' ' . $serial_no_kanban,
            'CHR_STATUS_DATA' => 'UPDATE',
            'CHR_CREATED_BY' => $username,
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_in_line_scan_m->save($data_history);

        $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
        $data_dandori = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);
        $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute_kanban($prod_order_no);

        $json_data = array(
            'actual' => $data_setup_chute->ACTUAL_KANBAN,
            'total_per_dandori' => $data_dandori->INT_TOTAL_QTY,
            'total_ok' => $data_total->INT_TOTAL_QTY,
            'qty_per_box' => $qty_per_box,
            'qty_act_product' => $data_setup_chute->ACTUAL_PART,
            'status' => $status,
            'message' => $message
        );

        echo json_encode($json_data);
    }

    public function updateTprProduct()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $work_center = substr($wo_number, 0, -16);
        $actual = $this->input->post('actual');
        $part_no = $this->input->post('part_no');
        $back_no = $this->input->post('back_no');
        $barcode_product = $this->input->post('barcode_product');
        $planning = $this->input->post('planning');
        $prod_order_no = $this->input->post('prod_order_no');
        $qty_per_box = $this->input->post('qty_per_box');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $status = true;
        $message = '';

        //20211102
        //$data = $this->prod_result_m->get_auto_data_production($wo_number, $back_no);
        // $update['INT_ACTUAL'] = 0;
        // $update['INT_TOTAL_QTY'] = 0; //$qty_per_box;
        // $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);

        $this->setup_chute_m->update_actual_lot_product($work_center, $prod_order_no);

        //===== EDIT FOR PRINT RECOVERY BY ANU --- 20200204 =====//
        $cek_recovery = $this->setup_chute_m->get_status_recovery_by_prod_no($prod_order_no);
        if ($cek_recovery->INT_FLG_RECOVERY == 1) {
            // $prod_order_no_print = substr($cek_recovery->CHR_PRD_ORDER_NO_REFF,0,19);
            $prod_order_no_print = $prod_order_no; //=== Update 20200922 - ANU
        } else {
            $prod_order_no_print = $prod_order_no;
        }
        //===== END UPDATE =====//

        $data_one_way_kanban = $this->one_way_kanban_m->get_new_data_one_way_kanban($prod_order_no_print);

        if ($data_one_way_kanban->num_rows() > 0) {

            $serial = $data_one_way_kanban->row()->CHR_SERIAL;

            $query_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban_update($work_center, $prod_order_no_print, $serial);

            if ($query_kbn->num_rows() > 0) {
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

                //===== Add logic for trial - By ANU 20220118
                if($work_center == 'SACC03'){ //=== Change work center trial
                    $fp = fsockopen("172.16.31.52", 1234, $errno, $errstr, 5); //=== Print from laptop ANU
                } else {
                    $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE
                }

                if (!$fp) {
                    $status = false;
                    $message =  $errno . ' - ' . $errstr;
                } else {
                    $out = "OK|$prod_order_no_print|$part_no|$back_no|$serial_oneway|$part_no_cust|$lot_size|$qty_per_box_print|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    $status = true;
                    fclose($fp);
                }
            }
        } else {
            $message = 'Data kanban product untuk prd no : ' . $prod_order_no_print . ', tidak tercreate ';
        }

        $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
        $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);
        $data_dandori = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);

        $json_data = array(
            'actual' => $data_setup_chute->ACTUAL_KANBAN,
            'total_per_dandori' => $data_dandori->INT_TOTAL_QTY,
            'total_ok' => $data_total->INT_TOTAL_QTY,
            'qty_per_box' => $qty_per_box,
            'qty_act_product' => $data_setup_chute->ACTUAL_PART,
            'status' => $status,
            'message' => $message
        );

        echo json_encode($json_data);
    }

    public function reprintKanban()
    {
        $work_center = $this->input->post('work_center');
        $prod_order_no = $this->input->post('prod_order_no');
        $json_data['status'] = false;

        $data = $this->one_way_kanban_m->get_one_way_kanban_data_by_order_no($prod_order_no, $work_center);
        if ($data) {
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

            //===== Add logic for trial - By ANU 20220118
            if($work_center == 'SACC03'){ //=== Change work center trial
                $fp = fsockopen("172.16.31.52", 1234, $errno, $errstr, 5); //=== Print from laptop ANU
            } else {
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE
            }

            if (!$fp) {
                $json_data['message'] =  $errno . ' - ' . $errstr;
            } else {
                $out = "OK|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                $json_data['status'] = true;
                fclose($fp);
            }
        } else {
            $json_data['message'] = 'Data kanban tidak ter-create.';
        }

        echo json_encode($json_data);
    }

    public function insertReject()
    {
        $int_number = $this->input->post('int_number');
        $wo_number = $this->input->post('wo_number');
        $qty = $this->input->post('qty');
        $ng = $this->input->post('ng');
        $back_no = $this->input->post('back_no');
        $work_center = $this->input->post('work_center');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $prod_order_no = $this->input->post('prod_order_no');

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

        $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);

        if ($qty > ((int)$data_setup_chute->INT_QTY_PER_BOX - (int)$data_setup_chute->ACTUAL_PART)) {
            $json_data['status'] = false;
            $json_data['message'] = 'Inputan NG tidak boleh melebihi ' . ((int)$data_setup_chute->INT_QTY_PER_BOX - (int)$data_setup_chute->ACTUAL_PART) . ' pcs ';
        } else {
            $json_data['status'] = true;
            $this->prod_result_m->update_production_result_ng($update, $data->INT_NUMBER, trim($data->CHR_IP));
            $data_json['total_ng'] = $this->prod_result_m->get_total_reject($wo_number);
        }

        echo json_encode($json_data);
    }

    public function CheckScanOneWayKanban($barcode)
    {

        $data = array('status' => true);

        $barcode = str_replace("-", "/", $barcode);
        $barcode = str_replace("-", "/", $barcode);
        $barcode = str_replace("%20%20%20%20%20%20", " ", $barcode);
        $barcode = str_replace("%20%20%20%20%20", " ", $barcode);
        $barcode = str_replace("%20%20%20", " ", $barcode);
        $barcode = str_replace("%20%20", " ", $barcode);
        $barcode = str_replace("%20", " ", $barcode);

        $dataSerial = explode(" ", $barcode);

        if (count($dataSerial) == 4 || count($dataSerial) == 5) {

            $compare_ord_no = $this->setup_chute_m->compareOrderNoRunning($dataSerial[0]);

            if ($compare_ord_no) {

                $data_kanban = $this->one_way_kanban_m->get_history_scan_kanban_by_order_no($dataSerial[0], $dataSerial[1]);

                if ($data_kanban) {
                    $data['status'] = false;
                } else {
                    $data['message'] = "Prod order no " . $dataSerial[0] . " dengan serial " . $dataSerial[1] . " Sudah pernah dipindai / diecer atau tidak ditemukan";
                }

            } else {
                $data['message'] = "Prod order no " . $dataSerial[0] . " telah discan atau tidak sesuai dengan Prd order no yang sedang berjalan";
            }
        } else {
            $data['message'] = "Salah memindai kanban, array " . $dataSerial . " pastikan kanban produksi yang dipindai - " . $barcode;
        }

        echo json_encode($data);
    }

    public function stopSetupChute()
    {
        $work_center = $this->input->post('work_center');
        $date = '';

        $this->setup_chute_m->update_setup_chute_not_use($work_center, $date);

        $this->db->query("DELETE PRD.TW_DANDORI_BOARD WHERE CHR_WORK_CENTER = '$work_center'");

        if ('IS_AJAX') {
            echo json_encode(true);
        }
    }

    public function checkUncompletedSetupChute()
    {
        $work_center = trim($this->input->post('work_center'));
        $data_json['status'] = true;

        $data_uncomplete_lot = $this->setup_chute_m->get_uncomplete_lot_data_new($work_center);

        if ($data_uncomplete_lot->num_rows() > 0) {
            $data_json['status'] = false;
            $data_uncomplete = $data_uncomplete_lot->row();
            $data_json['message'] = 'Kanban kurang ' . $data_uncomplete_lot->row()->INT_LOT_SIZE_ACTUAL . ' Lot, untuk bisa Dandori silahkan hubungi PPIC';

            //===== FUNCTION FOR PRINT UNCOMPLETE KANBAN --- EDIT BY ANU - 20200204 =====//
            // $data_uncomplete = $this->prod_result_m->get_last_data_prod_order($wo_number, $back_no);
            if ($data_uncomplete->INT_FLG_RECOVERY == 1) {
                $prod_order_no = substr($data_uncomplete->CHR_PRD_ORDER_NO_REFF, 0, 19);
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

            if ($qty_diff_ecer > 0) {
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

                //===== Add logic for trial - By ANU 20220118
                if($work_center == 'SACC03'){ //=== Change work center trial
                    $fp = fsockopen("172.16.31.52", 1234, $errno, $errstr, 5); //=== Print from laptop ANU
                } else {
                    $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE
                }

                if (!$fp) {
                    $json_data['status'] = false;
                    $json_data['message'] =  $errno . ' - ' . $errstr;
                } else {
                    $out = "NG|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_diff_ecer|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    $json_data['status'] = true;

                    //=== DI COMMENT UNTUK DI LOCK AGAR KETIKA DANDORI UNCOMPLETE HARUS HUB PPC ===//
                    //=== DI UNCOMMENT UNTUK UNLOCK AGAR MP PRODUKSI BISA DANDORI TANPA HUB PPC ===//
                    $update_finish = array(
                        'INT_FLG_ADJUST_FINISH' => 1,
                        'CHR_NOTES_UNCOMPLETE' => 'Print Uncomplete',
                        'CHR_EDITED_BY' => 'System',
                        'CHR_EDITED_DATE' => date('Ymd'),
                        'CHR_EDITED_TIME' => date('His')
                    );

                    $this->setup_chute_m->update_by_prod_order_no($data_uncomplete->CHR_PRD_ORDER_NO, $update_finish);

                    fclose($fp);
                }
            }

            //===== END FUNCTION FOR PRINT UNCOMPLETE KANBAN --- EDIT BY ANU - 20200204 =====//
        }

        if ('IS_AJAX') {
            echo json_encode($data_json);
        }
    }

    public function updateRetail()
    {
        $int_number = $this->input->post('int_number');
        $wo_number = trim($this->input->post('wo_number'));
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $username = $this->input->post('username');
        $total_dandori = $this->input->post('total_dandori');
        $qty_per_box = $this->input->post('qty_per_box');
        $qty_retail = $this->input->post('qty_retail');
        $back_no = $this->input->post('back_no');
        $part_no = $this->input->post('part_no');
        $planning = $this->input->post('planning');
        $prod_order_no = $this->input->post('prod_order_no');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $back_no);
        $data_one_way_kanban = $this->one_way_kanban_m->get_one_way_kanban_printed_by_prd_order($prod_order_no);

        if ($data_one_way_kanban) {
            $allow_retail = $this->history_in_line_scan_m->get_sum_qty_by_work_order_ogawa($wo_number, $qty_retail, $qty_per_box, $back_no, $data->INT_NUMBER);

            if ($allow_retail == 0) {

                $this->setup_chute_m->update_eceran_setup_chute($prod_order_no, $qty_retail);

                $update = array(
                    'INT_ACTUAL' => $qty_retail,
                    'INT_TOTAL_QTY' => $qty_retail
                );

                $this->prod_result_m->update_production_result($update, $data->INT_NUMBER, trim($data->CHR_IP), $wo_number);

                $data_history = array(
                    'CHR_WO_NUMBER' => $wo_number,
                    'INT_PLAN' => $planning,
                    'INT_DANDORI' => $total_dandori,
                    'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($prod_order_no),
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'INT_QTY_PERSCAN' => intval($qty_retail),
                    'CHR_PART_NO' => $part_no,
                    'CHR_BACK_NO' => $back_no,
                    'CHR_DATE' => $date,
                    'CHR_SHIFT' => $shift,
                    'CHR_WORK_CENTER' => $work_center,
                    'INT_NUMBER_REF' => $int_number,
                    'CHR_BARCODE_KANBAN' => $data_one_way_kanban->CHR_PRD_ORDER_NO . ' ' . $data_one_way_kanban->CHR_SERIAL,
                    'CHR_STATUS_DATA' => 'ECERAN',
                    'CHR_CREATED_BY' => $username,
                    'CHR_CREATED_DATE' => $date_entry,
                    'CHR_CREATED_TIME' => $time_entry
                );

                $this->history_in_line_scan_m->save($data_history);

                $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
                $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);
                $data_dandori = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);

                $json_data = array(
                    'total_ok' => $data_total->INT_TOTAL_QTY,
                    'qty_act_product' => $data_setup_chute->ACTUAL_PART,
                    'status' => true
                );
            } else {
                $qty_allow = (int) $qty_per_box - 1;
                $json_data['message'] = 'Tidak bisa menginput lebih dari ' . $qty_allow . ' Piece(s)';
                $json_data['status'] = false;
            }
        } else {
            $json_data['message'] = 'Data one way kanban tidak ada.';
            $json_data['status'] = false;
        }

        echo json_encode($json_data);
    }

    public function printOneWayKanbanManual()
    {
        $id = $this->input->post('id');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $work_center = null;

        $data = $this->one_way_kanban_m->get_one_way_kanban_data_by_id($id);

        if ($data) {
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

            //===== Add logic for trial - By ANU 20220118
            if($work_center == 'SACC03'){ //=== Change work center trial
                $fp = fsockopen("172.16.31.52", 1234, $errno, $errstr, 5); //=== Print from laptop ANU
            } else {
                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE
            }

            if (!$fp) {
                $json_data['message'] =  $errno . ' - ' . $errstr;
                $json_data['status'] =  false;
            } else {
                $out = "OK|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                $json_data['status'] = true;
                fclose($fp);
            }
        } else {
            $json_data['message'] = 'Data kanban tidak tercreate.';
        }

        echo json_encode($json_data);
    }

    public function getLabelOneWayKanban()
    {
        $id_setup_chute = trim($this->input->post('id_setup_chute'));

        $history = $this->one_way_kanban_m->get_label_one_way_by_id_setup_chute($id_setup_chute);

        $data = '';

        if ($history->num_rows() > 0) {
            $data .= "<table>";
        } else {
            $data = 'NO HISTORY LABEL';
        }

        if ($history->num_rows() > 0 && $history->num_rows() < 11) {
            $x = 0;
            $data .= "<tr>";
            foreach ($history->result() as $value) {
                $data .= "<td>$value->CHR_SERIAL</td>";
                $x++;
            }
            $data .= "</tr>";
        } else if ($history->num_rows() > 10 && $history->num_rows() < 21) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 20 && $history->num_rows() < 31) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 30 && $history->num_rows() < 41) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 40 && $history->num_rows() < 51) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 50 && $history->num_rows() < 61) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 60 && $history->num_rows() < 71) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 60) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 61) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        } else {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 60) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else if ($x > 60 && $x < 71) {
                    if ($x == 61) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == 70) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                } else {
                    if ($x == 71) {
                        $data .= "<tr><td>$value->CHR_SERIAL</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_SERIAL</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_SERIAL</td>";
                    }
                }
            }
        }


        if ($history->num_rows() > 0) {
            $data .= "</table>";
        }

        $data_send = str_replace('\/', '/', $data);

        if ('IS_AJAX') {
            echo json_encode($data_send);
        }
    }
}
