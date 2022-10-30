<?php

class ines_c extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('kanban/kanban_m');
        $this->load->model('part/process_part_m');
        $this->load->model('part/part_customer_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('pes/line_stop_prod_m');
        $this->load->model('pes/prod_result_m');
        $this->load->model('pes/history_in_line_scan_m');
        $this->load->model('part/part_m');
        $this->load->model('pes/cavity_m');
        $this->load->model('pes/production_activity_m');
        $this->load->model('pes/target_production_m');
        $this->load->model('basis/user_m');
        $this->load->model('eng/rfid_dies_m');
        $this->load->model('prd/dandori_board_m');
    }

    public function registration()
    {
        $shift = $this->input->post('shift');
        $type_shift = $this->input->post('type_shift');
        $work_center = $this->input->post('work_center');
        $npk = $this->input->post('npk');
        $username = null;
        $phone = null;

        if ($type_shift == 'L') {
            $flag_shift = 1;
        } else {
            $flag_shift = 0;
        }

        if ($shift == 3) {
            if (date('G') >= 0 && date('G') < 6) {
                $production_date = date('Ymd', strtotime(date('Ymd') . '-1 days'));
            } else {
                $production_date = date('Ymd');
            }
        } else {
            $production_date = date('Ymd');
        }

        $wo_number = $work_center . '/' . $production_date . '/SHIFT' . $shift;

        $this->prod_result_m->start_production($wo_number, $flag_shift);

        if (strlen((int)$npk) == 3) {
            $npk = '0' . (int)$npk;
        }

        $data_user = $this->user_m->get_data_user($npk);
        if ($data_user->num_rows() > 0) {
            $username = $data_user->row()->CHR_USERNAME;
            $phone = $data_user->row()->CHR_CONTACT;
        }

        $data_target = $this->target_production_m->get_target_production_work_center($work_center);
        if ($data_target->num_rows() > 0) {
            $takt_time = $data_target->row()->INT_TT;
            $target = $data_target->row()->INT_TARGET_PRODUCTION;
            $std_mp = $data_target->row()->INT_STD_MP;
        } else {
            $takt_time = 0;
            $target = 0;
            $std_mp = 0;
        }

        $data = array(
            'wo_number' => $wo_number,
            'date' => $production_date,
            'shift' => $shift,
            'flag_shift' => $flag_shift,
            'work_center' => $work_center,
            'target' => $target,
            'cycle_time' => 0,
            'takt_time' => $takt_time,
            'std_mp' => $std_mp,
            'username' => $username,
            'npk' => $npk,
            'phone' => $phone
        );

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //20211216
    public function get_master_mp()
    {
        $part_no = $this->input->post('part_no');
        $work_center = $this->input->post('work_center');
        $data_part = $this->process_part_m->get_master_mp_by_part($work_center, $part_no);

        $data = '';
        foreach ($data_part as $row) {
            $data .= "<option value='$row->INT_MP'>" . $row->INT_MP . "</option>";
        }

        echo json_encode($data);
    }

    //20211216
    public function get_master_ct()
    {
        $part_no = $this->input->post('part_no');
        $work_center = $this->input->post('work_center');
        $man_power = $this->input->post('man_power');
        $data = $this->process_part_m->get_master_ct_by_mppart($work_center, $part_no, $man_power);

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //20211217
    public function checkFlgScanSetupChute()
    {
        $work_center = $this->input->post('work_center');

        $data['status'] = $this->direct_backflush_general_m->getFlagScan($work_center);

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function get_detail_kanban()
    {
        $id_kanban = $this->input->post('id_kanban');
        $serial = $this->input->post('serial');
        $type = $this->input->post('type');
        $work_center = $this->input->post('work_center');

        $data = array('status' => false, 'message' => false, 'data_dies' => 0, 'cavity_flag' => false);

        $data_kanban = $this->kanban_m->get_detail_kanban_by_barcode($id_kanban, $serial, $type);

        if ($data_kanban->num_rows() > 0) {
            $part_no = trim($data_kanban->row()->CHR_PART_NO);

            $data_process_part = $this->process_part_m->get_data_part_by_work_center_and_part($work_center, $part_no);
            if ($data_process_part->num_rows() > 0) {

                $data['status'] = true;
                $data['part_no'] = $data_kanban->row()->CHR_PART_NO;
                $data['back_no'] = $data_kanban->row()->CHR_BACK_NO;
                $data['part_name'] = $data_kanban->row()->CHR_PART_NAME;
                $data['qty_box'] = $data_kanban->row()->INT_QTY_PER_BOX;
                $data['qty_per_box'] = $data_kanban->row()->INT_QTY_PER_BOX;
                $data['storage_loc_to'] = $data_kanban->row()->CHR_SLOC_TO;
                $data['uom'] = $data_kanban->row()->CHR_PART_UOM;
                $data['pv'] = $data_process_part->row()->CHR_PV;
                $data['cycle_time'] = $data_process_part->row()->INT_CYCLE_TIME;
                $data['takt_time'] = 0;
                $data['data_dies'] = $this->rfid_dies_m->get_data_dies_by_partno($part_no);

                $master_cavity = $this->cavity_m->get_data_part_no($part_no);

                if ($master_cavity->num_rows() > 0) {

                    if (trim(strtoupper($part_no)) == trim(strtoupper($master_cavity->row()->CHR_PART_NO))) {
                        $detail_part = $this->kanban_m->get_detail_part($master_cavity->row()->CHR_PART_NO_MATE);
                    } else {
                        $detail_part = $this->kanban_m->get_detail_part($master_cavity->row()->CHR_PART_NO);
                    }

                    if ($detail_part->num_rows() > 0) {

                        $data['back_no_cavity'] = $detail_part->row()->CHR_BACK_NO;
                        $data['part_no_cavity'] = $detail_part->row()->CHR_PART_NO;
                        $data['part_name_cavity'] = $detail_part->row()->CHR_PART_NAME;
                        $data['qty_per_box_cavity'] = $detail_part->row()->INT_QTY_PER_BOX;
                        $data['uom_cavity'] = $detail_part->row()->CHR_PART_UOM;
                        $data['cavity_flag'] = true;

                        $data_process_part_cavity = $this->process_part_m->get_data_part_by_work_center_and_part($work_center, $detail_part->row()->CHR_PART_NO);
                        if ($data_process_part_cavity->num_rows() > 0) {
                            $data['pv_cavity'] = $data_process_part_cavity->row()->CHR_PV;
                            $data['cycle_time_cavity'] = $data_process_part_cavity->row()->INT_CYCLE_TIME;
                            $data['takt_time_cavity'] = 0;
                        } else {
                            $data['pv_cavity'] = NULL;
                            $data['cycle_time_cavity'] = 0;
                            $data['takt_time_cavity'] = 0;
                        }
                    } else {
                        $data['message'] = 'Data P/N : ' . $part_no . ' cavity, tidak ditemukan.';
                    }
                }
            } else {
                $data['message'] = 'P/N : ' . $part_no . ' tidak terdaftar di Line ' . $work_center;
            }
        } else {
            $data['message'] = 'Data kanban tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function check_kanban()
    {
        $id_kanban = $this->input->post('id_kanban');
        $serial = $this->input->post('serial');
        $type = $this->input->post('type');
        $work_center = $this->input->post('work_center');
        $part_no = $this->input->post('part_no');
        $data['status'] = false;

        $data_kanban = $this->kanban_m->get_detail_kanban_by_barcode($id_kanban, $serial, $type);

        if ($data_kanban->num_rows() > 0) {
            if (trim($data_kanban->row()->CHR_PART_NO) == $part_no) {
                $data_process_part = $this->process_part_m->get_data_part_by_work_center_and_part($work_center, $part_no);
                if ($data_process_part->num_rows() > 0) {
                    $data['status'] = true;
                } else {
                    $data['message'] = 'P/N : ' . $part_no . ' tidak terdaftar di Line ' . $work_center;
                }
            } else {
                $data['message'] = 'Kanban yang dipindai tidak sesuai.';
            }
        } else {
            $data['message'] = 'Barcode yang dipindai tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function startProblem()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $shift = substr(trim($this->input->post('wo_number')), -1);
        $date = substr(trim($this->input->post('wo_number')), -15, 8);
        $work_center = substr(trim($this->input->post('wo_number')), 0, -16);
        $ls = $this->input->post('ls');
        $npk = $this->input->post('npk');
        $int_number = $this->input->post('int_number');
        $date = date('Ymd');
        $time = date('His');

        $data_ls = array(
            'CHR_LINE_CODE' => $ls,
            'INT_NUMBER' => $int_number,
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

        $data = $this->line_stop_prod_m->get_data_line_stop($ls);

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function startCall()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $work_center = substr(trim($this->input->post('wo_number')), 0, -16);
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

    public function startRepair()
    {
        $ls = trim($this->input->post('ls'));
        $wo_number = trim($this->input->post('wo_number'));
        $work_center = substr(trim($this->input->post('wo_number')), 0, -16);
        $npk = $this->input->post('npk');
        $datenow = date('Ymd');
        $timenow = date('His');

        $data_line_stop = $this->line_stop_prod_m->getLineStopMachine($wo_number, $ls);

        if (date('YmdHis') < $data_line_stop['DATETIME_WAITING']) {
            $timenow = $data_line_stop['CHR_WAITING_TIME'];
        }

        $data_update = array(
            'CHR_FOLLOWUP_BY' => $npk,
            'CHR_FOLLOWUP_DATE' => $datenow,
            'CHR_FOLLOWUP_TIME' => $timenow
        );

        $id_update = array(
            'CHR_WO_NUMBER' => $data_line_stop['CHR_WO_NUMBER'],
            'CHR_LINE_CODE' => $data_line_stop['CHR_LINE_CODE'],
            'INT_ID_LINE_STOP' => $data_line_stop['INT_ID_LINE_STOP']
        );

        $this->line_stop_prod_m->update($data_update, $id_update);

        echo json_encode(true);
    }

    public function stopProblem()
    {
        $ls = $this->input->post('ls');
        $wo_number = trim($this->input->post('wo_number'));
        $npk = $this->input->post('npk');
        $work_center = substr(trim($this->input->post('wo_number')), 0, -16);

        $data_line_stop = $this->line_stop_prod_m->getLineStopMachine($wo_number, $ls);

        $json_data = array('ls_code' => $ls, 'status' => false);

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

    public function get_total_actual_by_shift()
    {
        $wo_number = $this->input->post('wo_number');

        $row_part = $this->prod_result_m->get_total_actual_by_shift($wo_number);
        $data['total_pieces'] = 'TOTAL OK : ' . $row_part['INT_TOTAL_QTY'] . ' /Pcs';
        $data['total_ng'] = 'TOTAL NG : ' . $row_part['INT_TOTAL_NG'] . ' /Pcs';
        if ($data == NULL) {
            $data['total_pieces'] = 'TOTAL OK : 0 /Pcs';
            $data['total_ng'] = 'TOTAL NG : 0 /Pcs';
        }

        $row_count = $this->prod_result_m->get_total_dandori_by_wo($wo_number);
        $data['total_row'] = 'TOTAL DANDORI : ' . $row_count['TOTAL_ROW'];
        if ($data['total_row'] == NULL) {
            $data['total_row'] = 'TOTAL DANDORI : 0';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    public function checkNpk()
    {
        $npk = (int)$this->input->post('npk');

        if (strlen($npk) == 3) {
            $npk_string = '0' . $npk;
        } else if (strlen($npk) == 2) {
            $npk_string = '00' . $npk;
        } else if (strlen($npk) == 1) {
            $npk_string = '000' . $npk;
        } else {
            $npk_string = $npk;
        }

        $data_user = $this->user_m->get_user_name_by_npk($npk_string);

        if ($data_user->num_rows() > 0) {
            $data_json['status'] = true;
            $data_json['username'] = trim($data_user->row()->CHR_USERNAME);
            $data_json['npk'] = trim($data_user->row()->CHR_NPK);
        } else {
            $data_json['message'] = 'NPK yang anda masukan tidak terdaftar';
            $data_json['status'] = false;
        }

        if ('IS_AJAX') {
            echo json_encode($data_json);
        }
    }

    public function get_history()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $history = $this->prod_result_m->get_all_history_by_wc_and_shift_and_date($wo_number);

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

    public function get_all_history_dandory()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $history = $this->prod_result_m->get_all_history_dandory($wo_number);

        $data = '';

        if ($history->num_rows() > 0) {
            $data .= "<table>";
        } else {
            $data = 'NO HISTORY DANDORI';
        }

        if ($history->num_rows() > 0 && $history->num_rows() < 11) {
            $x = 0;
            $data .= "<tr>";
            foreach ($history->result() as $value) {
                $data .= "<td>$value->CHR_BACK_NO</td>";
                $x++;
            }
            $data .= "</tr>";
        } else if ($history->num_rows() > 10 && $history->num_rows() < 21) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 20 && $history->num_rows() < 31) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 30 && $history->num_rows() < 41) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 40 && $history->num_rows() < 51) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 50 && $history->num_rows() < 61) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else if ($history->num_rows() > 60 && $history->num_rows() < 71) {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 60) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 61) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                }
            }
        } else {
            $x = 0;
            foreach ($history->result() as $value) {
                $x++;
                if ($x > 0 && $x < 11) {
                    if ($x == 1) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 10) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 10 && $x < 21) {
                    if ($x == 11) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 20) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 20 && $x < 31) {
                    if ($x == 21) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 30) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 30 && $x < 41) {
                    if ($x == 31) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 40) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 40 && $x < 51) {
                    if ($x == 41) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 50) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 50 && $x < 61) {
                    if ($x == 51) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 60) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else if ($x > 60 && $x < 71) {
                    if ($x == 61) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == 70) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
                    }
                } else {
                    if ($x == 71) {
                        $data .= "<tr><td>$value->CHR_BACK_NO</td>";
                    } else if ($x == $history->num_rows()) {
                        $data .= "<td>$value->CHR_BACK_NO</td></tr>";
                    } else {
                        $data .= "<td>$value->CHR_BACK_NO</td>";
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

    public function save_history_reprint()
    {

        $wo_number = $this->input->post('wo_number');
        $work_center = $this->input->post('work_center');
        $part_no = trim($this->input->post('part_no'));
        $username = trim($this->input->post('username'));

        $this->prod_result_m->save_history_reprint($wo_number, $work_center, $part_no, $username);

        if ('IS_AJAX') {
            echo json_encode(true);
        }
    }

    public function send_to_sap_by_wo()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $this->prod_result_m->update_flag_is_finished_cavity($wo_number);

        if ('IS_AJAX') {
            echo json_encode(true);
        }
    }

    public function send_to_sap_by_line()
    {
        $work_center = trim($this->input->post('work_center'));
        $this->prod_result_m->update_flag_by_work_center_cavity($work_center);

        if ('IS_AJAX') {
            echo json_encode(true);
        }
    }

    public function updateDurationLineStop()
    {
        $id_ls = trim($this->input->post('id_ls'));
        $wo_number = trim($this->input->post('wo_number'));

        $waiting_duration_second = $this->input->post('waiting_duration_second') / 60;
        $repair_duration_second = $this->input->post('repair_duration_second') / 60;
        $problem_duration_second = $this->input->post('problem_duration_second') / 60;

        $data = array(
            'INT_DURASI_REPAIR' => (int)$repair_duration_second,
            'INT_DURASI_WAITING' => (int)$waiting_duration_second,
            'INT_DURASI_LS' => (int)$problem_duration_second,
            'INT_TOTAL_DURASI_WAITING' => (int)$this->input->post('waiting_duration_second'),
            'INT_TOTAL_DURASI_REPAIR' => (int)$this->input->post('repair_duration_second'),
            'INT_TOTAL_DURASI_LS' => (int)$this->input->post('problem_duration_second')
        );

        $id = array(
            'CHR_WO_NUMBER' => $wo_number,
            'CHR_LINE_CODE' => $id_ls
        );

        $this->line_stop_prod_m->update_duration_line_stop($data, $id);

        echo json_encode(true);
    }

    public function updateActivityDetail()
    {
        $data_array[] = $this->input->post('data');

        $status_existing = $this->production_activity_m->checkExistingbyWO($data_array[0]['wo_number'], $data_array[0]['pr_sequence']);

        if ($status_existing == true) {
            echo json_encode(true);
        } else {
            if ($data_array[0]['stop_change'] == '0000-00-00 00:00:00') {
                echo json_encode(true);
            } else {
                $data_detail = array(
                    'CHR_WO_NUMBER' => $data_array[0]['wo_number'],
                    'INT_PR_SEQUENCE' => $data_array[0]['pr_sequence'],
                    'CHR_WORK_CENTER' => $data_array[0]['work_center'],
                    'INT_MP' => $data_array[0]['man_power'],
                    'INT_CT' => $data_array[0]['cycle_time'],
                    'INT_TT' => $data_array[0]['takt_time'],
                    'CHR_PART_NO' => $data_array[0]['part_no'],
                    'INT_PLAN_CT' => $data_array[0]['plan_hour'],
                    'INT_TOTAL_OK' => $data_array[0]['qty_hour'],
                    'INT_TOTAL_NG' => $data_array[0]['ng_hour'],
                    'CHR_START_CHANGE' => $data_array[0]['start_change'],
                    'CHR_STOP_CHANGE' => $data_array[0]['stop_change']
                );

                $this->production_activity_m->insert_detail($data_detail);

                echo json_encode($data_detail);
            }
        }
    }

    public function updateActivity()
    {
        $data_array[] = $this->input->post('data');

        if ($data_array[0]['start_break4'] == '') {
            $data_array[0]['start_break4'] = NULL;
        }
        if ($data_array[0]['stop_break4'] == '') {
            $data_array[0]['stop_break4'] = NULL;
        }
        if ($data_array[0]['start_break3'] == '') {
            $data_array[0]['start_break3'] = NULL;
        }
        if ($data_array[0]['stop_break3'] == '') {
            $data_array[0]['stop_break3'] = NULL;
        }

        $data = array(
            'INT_TARGET' => $data_array[0]['target'],
            'INT_PLAN_CT' => $data_array[0]['plan_ct'],
            'INT_PLAN_TT' => $data_array[0]['plan_tt'],
            'INT_ACTUAL' => $data_array[0]['total_ok'],
            'INT_TOTAL_OK' => $data_array[0]['total_ok'],
            'INT_TOTAL_NG' => $data_array[0]['total_ng'],
            'CHR_START_PROD' => $data_array[0]['start_prod'],
            'CHR_STOP_PROD' => $data_array[0]['stop_prod'],
            'CHR_START_MEETING' => $data_array[0]['start_meeting'],
            'CHR_STOP_MEETING' => $data_array[0]['stop_meeting'],
            'CHR_START_BREAK1' => $data_array[0]['start_break1'],
            'CHR_STOP_BREAK1' => $data_array[0]['stop_break1'],
            'CHR_START_BREAK2' => $data_array[0]['start_break2'],
            'CHR_STOP_BREAK2' => $data_array[0]['stop_break2'],
            'CHR_START_BREAK3' => $data_array[0]['start_break3'],
            'CHR_STOP_BREAK3' => $data_array[0]['stop_break3'],
            'CHR_START_BREAK4' => $data_array[0]['start_break4'],
            'CHR_STOP_BREAK4' => $data_array[0]['stop_break4'],
            'CHR_START_CLEANING' => $data_array[0]['start_cleaning'],
            'CHR_STOP_CLEANING' => $data_array[0]['stop_cleaning'],
            'INT_OPERATING_TIME' => $data_array[0]['plant_operating_time'],
            'INT_UNPLANNED_DOWNTIME' => $data_array[0]['unplanned_downtime'],
            'INT_PLANNED_DOWNTIME' => $data_array[0]['planned_downtime'],
            'INT_PRODUCTION_TIME' => $data_array[0]['planned_production_time'],
            'INT_PRODUCTION_RUNTIME' => $data_array[0]['production_runtime'],
            'INT_TARGET_RUNTIME' => $data_array[0]['target_runtime'],
            'INT_AVAILABILITY' => $data_array[0]['availability'],
            'INT_PRODUCTIVITY' => $data_array[0]['productivity'],
            'INT_QUALITY' => $data_array[0]['quality'],
            'INT_OEE' => $data_array[0]['oee']
        );

        $id['CHR_WO_NUMBER'] =  $data_array[0]['wo_number'];

        $this->production_activity_m->update($data, $id);

        echo json_encode($data);
    }

    public function updateLastActivity()
    {
        $data_array[] = $this->input->post('data');

        if ($data_array[0]['start_break4'] == '') {
            $data_array[0]['start_break4'] = NULL;
        }
        if ($data_array[0]['stop_break4'] == '') {
            $data_array[0]['stop_break4'] = NULL;
        }
        if ($data_array[0]['start_break3'] == '') {
            $data_array[0]['start_break3'] = NULL;
        }
        if ($data_array[0]['stop_break3'] == '') {
            $data_array[0]['stop_break3'] = NULL;
        }

        $data = array(
            'INT_TARGET' => $data_array[0]['target'],
            'INT_PLAN_CT' => $data_array[0]['plan_ct'],
            'INT_PLAN_TT' => $data_array[0]['plan_tt'],
            'INT_ACTUAL' => $data_array[0]['total_ok'],
            'INT_TOTAL_OK' => $data_array[0]['total_ok'],
            'INT_TOTAL_NG' => $data_array[0]['total_ng'],
            'CHR_START_PROD' => $data_array[0]['start_prod'],
            'CHR_STOP_PROD' => $data_array[0]['stop_prod'],
            'CHR_START_MEETING' => $data_array[0]['start_meeting'],
            'CHR_STOP_MEETING' => $data_array[0]['stop_meeting'],
            'CHR_START_BREAK1' => $data_array[0]['start_break1'],
            'CHR_STOP_BREAK1' => $data_array[0]['stop_break1'],
            'CHR_START_BREAK2' => $data_array[0]['start_break2'],
            'CHR_STOP_BREAK2' => $data_array[0]['stop_break2'],
            'CHR_START_BREAK3' => $data_array[0]['start_break3'],
            'CHR_STOP_BREAK3' => $data_array[0]['stop_break3'],
            'CHR_START_BREAK4' => $data_array[0]['start_break4'],
            'CHR_STOP_BREAK4' => $data_array[0]['stop_break4'],
            'CHR_START_CLEANING' => $data_array[0]['start_cleaning'],
            'CHR_STOP_CLEANING' => $data_array[0]['stop_cleaning'],
            'INT_OPERATING_TIME' => $data_array[0]['plant_operating_time'],
            'INT_UNPLANNED_DOWNTIME' => $data_array[0]['unplanned_downtime'],
            'INT_PLANNED_DOWNTIME' => $data_array[0]['planned_downtime'],
            'INT_PRODUCTION_TIME' => $data_array[0]['planned_production_time'],
            'INT_PRODUCTION_RUNTIME' => $data_array[0]['production_runtime'],
            'INT_TARGET_RUNTIME' => $data_array[0]['target_runtime'],
            'INT_AVAILABILITY' => $data_array[0]['availability'],
            'INT_PRODUCTIVITY' => $data_array[0]['productivity'],
            'INT_QUALITY' => $data_array[0]['quality'],
            'INT_OEE' => $data_array[0]['oee'],
            'CHR_MODIFIED_BY' => 'Finish',
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );

        $id['CHR_WO_NUMBER'] =  $data_array[0]['wo_number'];

        $this->production_activity_m->update($data, $id);

        if ($data_array[0]['pr_sequence'] != '' || $data_array[0]['pr_sequence'] != NULL) {

            $data_detail = array(
                'CHR_WO_NUMBER' => $data_array[0]['wo_number'],
                'INT_PR_SEQUENCE' => $data_array[0]['pr_sequence'],
                'CHR_WORK_CENTER' => $data_array[0]['work_center'],
                'INT_MP' => $data_array[0]['man_power'],
                'INT_CT' => $data_array[0]['cycle_time'],
                'INT_TT' => $data_array[0]['takt_time'],
                'CHR_PART_NO' => $data_array[0]['part_no'],
                'INT_PLAN_CT' => $data_array[0]['plan_hour'],
                'INT_TOTAL_OK' => $data_array[0]['qty_hour'],
                'INT_TOTAL_NG' => $data_array[0]['ng_hour'],
                'CHR_START_CHANGE' => $data_array[0]['start_change'],
                'CHR_STOP_CHANGE' => $data_array[0]['stop_change']
            );

            $this->dandori_board_m->delete($data_array[0]['work_center']);

            $this->production_activity_m->insert_detail($data_detail);
        }

        echo json_encode($data);
    }

    public function insertTpr()
    {
        $work_center = $this->input->post('work_center');
        $wo_number = trim($this->input->post('wo_number'));
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
            $this->prod_result_m->update_flag_is_finished($wo_number);
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

        $json_data = array(
            'int_number' => $id_number,
            'total_dandori' => $total_dandori
        );

        if ('IS_AJAX') {
            echo json_encode($json_data);
        }
    }

    public function updateTpr()
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
        $planning = $this->input->post('planning');
        $type = $this->input->post('type');
        $id_kanban = intval($this->input->post('id_kanban'));
        $serial = $this->input->post('serial');
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $data = $this->prod_result_m->get_auto_data_production($wo_number, $back_no);
        $qty_per_box = $this->kanban_m->get_kanban_qty($back_no, $type, $id_kanban, $serial);

        $update['INT_ACTUAL'] = $qty_per_box;
        $update['INT_TOTAL_QTY'] = $qty_per_box;
        $update['CHR_COMPLETE'] = NULL;

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
            'CHR_BARCODE_KANBAN' => $id_kanban . ' ' . $type . ' ' . $serial,
            'CHR_STATUS_DATA' => 'UPDATE',
            'CHR_CREATED_BY' => $username,
            'CHR_CREATED_DATE' => $date_entry,
            'CHR_CREATED_TIME' => $time_entry
        );

        $this->history_in_line_scan_m->save($data_history);

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

    public function updateRetail()
    {
        $wo_number = trim($this->input->post('wo_number'));
        $int_number = $this->input->post('int_number');
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
        $date_entry = date('Ymd');
        $time_entry = date('His');

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
                'INT_PLAN' => $planning,
                'INT_DANDORI' => $total_dandori,
                'INT_QTY_PERSCAN' => intval($qty_retail),
                'CHR_PART_NO' => $part_no,
                'CHR_BACK_NO' => $back_no,
                'CHR_DATE' => $date,
                'CHR_SHIFT' => $shift,
                'CHR_WORK_CENTER' => $work_center,
                'INT_NUMBER_REF' => $int_number,
                'CHR_BARCODE_KANBAN' => 'Eceran',
                'CHR_STATUS_DATA' => 'CREATE',
                'CHR_CREATED_BY' => $username,
                'CHR_CREATED_DATE' => $date_entry,
                'CHR_CREATED_TIME' => $time_entry
            );

            $this->history_in_line_scan_m->save($data_history);

            $data_total = $this->prod_result_m->get_data_production_by_wo($wo_number);
            $data_dandori = $this->prod_result_m->get_total_per_dandori($part_no, $wo_number);

            $json_data = array(
                'total_per_dandori' => $data_dandori->INT_TOTAL_QTY,
                'total_ok' => $data_total->INT_TOTAL_QTY,
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
}
