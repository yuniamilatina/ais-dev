<?php

class ines_digital_c extends CI_Controller
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
        $this->load->view('pes/ines_digital_v', $data);
    }

    public function dandoriSetupChute()
    {
        $work_center = $this->input->post('work_center');
        $data = array('status' => false, 'cavity_flag' => false, 'message' => '');

        $data_setup_chute = $this->setup_chute_m->getSetupChutebyWorkCenter($work_center);
        if ($data_setup_chute->num_rows() > 0) {

            $data['status'] = true;

            $flag_cav = 1;
            foreach ($data_setup_chute->result() as $row) {

                if ($flag_cav == 1) {
                    $data['back_no'] = $row->CHR_BACK_NO;
                    $data['part_no'] = $row->CHR_PART_NO;
                    $data['part_name'] = $row->CHR_PART_NAME;
                    $data['cycle_time'] = $row->INT_CYCLE_TIME;
                    $data['takt_time'] = 0;
                    $data['pv'] = $row->CHR_PV;
                    $data['uom'] = $row->CHR_PART_UOM;
                    $data['qty_box'] = $row->INT_QTY_PER_BOX;
                    $data['planning'] = $row->INT_LOT_SIZE;
                    $data['actual'] = $row->INT_ACTUAL_KANBAN;
                    $data['qty_act_product'] = $row->INT_ACTUAL_PCS;
                    $data['prod_order_no'] = $row->CHR_PRD_ORDER_NO;
                    $data['prod_order_no_reff'] = $row->CHR_PRD_ORDER_NO_REFF;
                    $data['pv_cavity'] = '';
                    $data['back_no_cavity'] = '';
                    $data['part_no_cavity'] = '';
                    $data['part_name_cavity'] = '';
                    $data['prod_order_no_cavity'] = '';
                    $data['prod_order_no_reff_cavity'] = '';
                    $data['conjunction'] = '';
                } else {
                    $data['cavity_flag'] = true;

                    $data_process_part_cavity = $this->process_part_m->get_data_part_by_work_center_and_part($work_center, $row->CHR_PART_NO);
                    if ($data_process_part_cavity->num_rows() > 0) {
                        $pv_cavity = $data_process_part_cavity->row()->CHR_PV;
                    } else {
                        $pv_cavity = NULL;
                    }

                    $data['pv_cavity'] = $pv_cavity;
                    $data['back_no_cavity'] = $row->CHR_BACK_NO;
                    $data['part_no_cavity'] = $row->CHR_PART_NO;
                    $data['part_name_cavity'] = $row->CHR_PART_NAME;
                    $data['prod_order_no_cavity'] = $row->CHR_PRD_ORDER_NO;
                    $data['prod_order_no_reff_cavity'] = $row->CHR_PRD_ORDER_NO_REFF;
                    $data['conjunction'] = ' / ';
                }

                $flag_cav++;
            }
        } else {
            $data['message'] = 'Setup chute tidak ditemukan';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function insertTpr()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $work_center = $this->input->post('work_center');
        $type_shift = $this->input->post('type_shift');
        $shift = $this->input->post('shift');
        $target = trim($this->input->post('target'));
        $planning = $this->input->post('planning');
        $uom = trim($this->input->post('uom'));
        $man_power = intval($this->input->post('man_power'));
        $npk = $this->input->post('npk');
        $username = $this->input->post('username');
        $production_date = $this->input->post('production_date');
        $array_cavity = $this->input->post('array_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $x = 0;

        $this->prod_result_m->update_flag_is_finished_cavity($wo_number);

        foreach (json_decode($array_cavity) as $row) {

            $total_dandori = $this->prod_result_m->get_sequence_by_wo($wo_number);

            $data['CHR_PLANT'] = '600';
            $data['CHR_USER'] = $username;
            $data['CHR_CREATED_BY'] =  $username;
            $data['INT_TARGET'] = $target;
            $data['INT_QTY_PLAN'] = $planning;
            $data['CHR_WO_NUMBER'] = $wo_number;
            $data['CHR_DATE'] = $production_date;
            $data['CHR_BACK_NO'] = $row->CHR_BACK_NO;
            $data['CHR_PART_NO'] = $row->CHR_PART_NO;
            $data['CHR_PART_NAME'] = $row->CHR_PART_NAME;
            $data['CHR_PV'] = $row->CHR_PV;
            $data['CHR_UOM'] = $uom;
            $data['INT_MP'] = $man_power;
            $data['CHR_WORK_CENTER'] = $work_center;
            $data['INT_BULAN'] = intval(date('m'));
            $data['INT_TAHUN'] = intval(date('Y'));
            $data['CHR_SHIFT'] = $shift;
            $data['CHR_WORK_DAY'] = $this->prod_result_m->get_current_day();
            $data['CHR_WORK_TIME_START'] = date('H') . '00';
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
            $data['INT_NG_OTHERS_REV'] = $total_dandori;

            $exist = $this->prod_result_m->cek_exist_data($data);
            if ($exist == 0) {
                
                $id_number = $this->prod_result_m->save_trans($data);

                if ($x == 0) {
                    $json_data['int_number'] = $id_number;
                    $json_data['total_dandori'] = $total_dandori;
                    $json_data['int_number_cavity'] = NULL;
                    $json_data['total_dandori_cavity'] = NULL;
                } else {
                    $json_data['int_number_cavity'] = $id_number;
                    $json_data['total_dandori_cavity'] = $total_dandori;
                }

                $id_setup_chute = $this->setup_chute_m->get_id_setup_chute($row->CHR_PRD_ORDER_NO);

                $data_history = array(
                    'CHR_WO_NUMBER' => $wo_number,
                    'INT_PLAN' => $planning,
                    'INT_DANDORI' => $total_dandori,
                    'INT_ID_SETUP_CHUTE' => $id_setup_chute,
                    'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                    'INT_QTY_PERSCAN' => 0,
                    'CHR_PART_NO' => $row->CHR_PART_NO,
                    'CHR_BACK_NO' => $row->CHR_BACK_NO,
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

            if(substr($work_center,0, 1) == 'P'){
                $this->setup_chute_m->updateDandoriSetupChute($work_center, $id_setup_chute, $row->CHR_PRD_ORDER_NO);
            }else{
                $this->setup_chute_m->update_dandori_setup_chute($work_center, $id_setup_chute, $row->CHR_PRD_ORDER_NO);
            }
            
            $this->dandori_board_m->update_dandori_board($row->CHR_PRD_ORDER_NO, $work_center, $row->CHR_PART_NO);
            $this->dandori_board_m->generateCheckPointDandori($row->CHR_PRD_ORDER_NO, $work_center, $row->CHR_PART_NO);
            $x++;
        }

        if ('IS_AJAX') {
            echo json_encode($json_data);
        }
    }

    public function updateTpr()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $planning = $this->input->post('planning');
        $actual = $this->input->post('actual');
        $part_no = $this->input->post('part_no');
        $barcode = $this->input->post('barcode');
        $username = $this->input->post('username');
        $qty_box = $this->input->post('qty_box');
        $prod_order_no = $this->input->post('prod_order_no');
        $array_cavity = $this->input->post('array_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        foreach (json_decode($array_cavity) as $row) {

            $this->prod_result_m->updateProductionResult($qty_box, $row->INT_NUMBER);
            $this->setup_chute_m->update_actual_lot($work_center, $row->CHR_PRD_ORDER_NO);

            $data_history = array(
                'CHR_WO_NUMBER' => $wo_number,
                'INT_PLAN' => $planning - $actual,
                'INT_DANDORI' => $row->INT_TOTAL_DANDORI,
                'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($row->CHR_PRD_ORDER_NO),
                'INT_QTY_PERSCAN' => intval($qty_box),
                'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                'CHR_PART_NO' => $row->CHR_PART_NO,
                'CHR_BACK_NO' => $row->CHR_BACK_NO,
                'CHR_DATE' => $date,
                'CHR_SHIFT' => $shift,
                'CHR_WORK_CENTER' => $work_center,
                'INT_NUMBER_REF' => $row->INT_NUMBER,
                'CHR_BARCODE_KANBAN' => $barcode,
                'CHR_STATUS_DATA' => 'UPDATE',
                'CHR_CREATED_BY' => $username,
                'CHR_CREATED_DATE' => $date_entry,
                'CHR_CREATED_TIME' => $time_entry
            );

            $this->history_in_line_scan_m->save($data_history);
        }

        $data_total     = $this->prod_result_m->get_data_production_by_wo($wo_number);
        $data_dandori   = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);
        $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute_kanban($prod_order_no);

        $json_data = array(
            'actual' => $data_setup_chute->ACTUAL_KANBAN,
            'total_per_dandori' => $data_dandori->INT_TOTAL_QTY,
            'total_ok' => $data_total->INT_TOTAL_QTY,
            'qty_per_box' => $qty_box,
            'qty_act_product' => $data_setup_chute->ACTUAL_PART
        );

        echo json_encode($json_data);
    }

    public function updateActualSetupChute()
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

        $this->setup_chute_m->update_actual_lot_product($work_center, $prod_order_no);

        $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
        $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);
        $data_dandori = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);

        $json_data = array(
            'actual' => $data_setup_chute->ACTUAL_KANBAN,
            'total_per_dandori' => $data_dandori->INT_TOTAL_QTY,
            'total_ok' => $data_total->INT_TOTAL_QTY,
            'qty_per_box' => $qty_per_box,
            'qty_act_product' => $data_setup_chute->ACTUAL_PART
        );

        echo json_encode($json_data);
    }

    public function updateRetail()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $shift = substr($wo_number, -1);
        $date = substr($wo_number, -15, 8);
        $work_center = substr($wo_number, 0, -16);
        $username = $this->input->post('username');
        $qty_box = $this->input->post('qty_box');
        $qty_retail = $this->input->post('qty_retail');
        $planning = $this->input->post('planning');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $array_cavity = $this->input->post('array_cavity');

        foreach (json_decode($array_cavity) as $row) {

            $data_one_way_kanban = $this->one_way_kanban_m->get_one_way_kanban_printed_by_prd_order($row->CHR_PRD_ORDER_NO);

            if ($data_one_way_kanban) {

                $allow_retail = $this->history_in_line_scan_m->get_sum_qty_by_work_order_ogawa($wo_number, $qty_retail, $qty_box, $row->CHR_BACK_NO, $row->INT_NUMBER);

                if ($allow_retail == 0) {

                    $this->setup_chute_m->update_eceran_setup_chute($row->CHR_PRD_ORDER_NO, $qty_retail);

                    $update = array(
                        'INT_ACTUAL' => $qty_retail,
                        'INT_TOTAL_QTY' => $qty_retail
                    );

                    $this->prod_result_m->updateProductionResult($update, $row->INT_NUMBER);

                    $data_history = array(
                        'CHR_WO_NUMBER' => $wo_number,
                        'INT_PLAN' => $planning,
                        'INT_DANDORI' => $row->INT_DANDORI,
                        'INT_ID_SETUP_CHUTE' => $this->setup_chute_m->get_id_setup_chute($row->CHR_PRD_ORDER_NO),
                        'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                        'INT_QTY_PERSCAN' => intval($qty_retail),
                        'CHR_PART_NO' => $row->CHR_PART_NO,
                        'CHR_BACK_NO' => $row->CHR_BACK_NO,
                        'CHR_DATE' => $date,
                        'CHR_SHIFT' => $shift,
                        'CHR_WORK_CENTER' => $work_center,
                        'INT_NUMBER_REF' => $row->INT_NUMBER,
                        'CHR_BARCODE_KANBAN' => $row->CHR_PRD_ORDER_NO . ' ' . $data_one_way_kanban->CHR_SERIAL,
                        'CHR_STATUS_DATA' => 'ECERAN',
                        'CHR_CREATED_BY' => $username,
                        'CHR_CREATED_DATE' => $date_entry,
                        'CHR_CREATED_TIME' => $time_entry
                    );

                    $this->history_in_line_scan_m->save($data_history);

                    $json_data = array(
                        'total_ok' => $this->prod_result_m->get_data_production_by_wo($wo_number)->INT_TOTAL_QTY,
                        'qty_act_product' => $this->setup_chute_m->get_actual_setup_chute($row->CHR_PRD_ORDER_NO)->ACTUAL_PART,
                        'status' => true
                    );
                } else {
                    $qty_allow = (int) $qty_box - 1;
                    $json_data['message'] = 'Tidak bisa menginput lebih dari ' . $qty_allow . ' Piece(s)';
                    $json_data['status'] = false;
                }
            } else {
                $json_data['message'] = 'Data one way kanban tidak ada.';
                $json_data['status'] = false;
            }
        }

        echo json_encode($json_data);
    }

    public function insertReject()
    {
        $wo_number = $this->input->post('wo_number');
        $qty = $this->input->post('qty');
        $ng = $this->input->post('ng');
        $prod_order_no = $this->input->post('prod_order_no');
        $array_cavity = $this->input->post('array_cavity');

        $data_setup_chute = $this->setup_chute_m->get_actual_setup_chute($prod_order_no);

        if ($qty > ((int)$data_setup_chute->INT_QTY_PER_BOX - (int)$data_setup_chute->ACTUAL_PART)) {
            $json_data['status'] = false;
            $json_data['message'] = 'Inputan NG tidak boleh melebihi ' . ((int)$data_setup_chute->INT_QTY_PER_BOX - (int)$data_setup_chute->ACTUAL_PART) . ' pcs ';
        } else {

            foreach (json_decode($array_cavity) as $row) {

                $data = $this->prod_result_m->get_auto_data_production($wo_number, $row->CHR_BACK_NO);

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
            }

            $data_json['total_ng'] = $this->prod_result_m->get_total_reject($wo_number);
            $json_data['status'] = true;
        }

        echo json_encode($data_json);
    }

    public function getLabelOneWayKanban()
    {
        $id_setup_chute = trim($this->input->post('id_setup_chute'));

        $history = $this->one_way_kanban_m->get_label_one_way_by_id_setup_chute($id_setup_chute);

        $data = '';

        if ($history->num_rows() > 0) {
            $data .= "<table>";
        } else {
            $data = 'NO DATA ONE WAY KANBAN';
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
