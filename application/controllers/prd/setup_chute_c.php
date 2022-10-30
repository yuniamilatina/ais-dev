<?php

//Add By bugsMaker 20170812
class setup_chute_c extends CI_Controller
{

    private $layout = '/template/head';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('part/part_m');
        $this->load->model('prd/setup_chute_m');
        $this->load->model('organization/dept_m');
        $this->load->model('prd/direct_backflush_general_m');
        $this->load->model('prd/one_way_kanban_m');
    }

    function index($msg = NULL)
    {
        $session = $this->session->all_userdata();
        $role = $session['ROLE'];

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(52);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Setup Chute';
        $data['role'] = $role;
        $data['msg'] = $msg;

        if ($role == '17') {
            $id_dept = $this->session->userdata('DEPT');
        } else {
            $id_dept = $this->dept_m->get_top_prod_dept()->row()->INT_ID_DEPT;
        }

        $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['status'] = 0;

        //$data['data'] = $this->setup_chute_m->get_setup_chute($work_center); //==== before edit by ANU
        $data['flg_phantom'] = $this->setup_chute_m->check_phantom_elina($work_center);
        $data['data'] = $this->setup_chute_m->get_setup_chute_open($work_center);
        $data['max_seq'] = $this->setup_chute_m->get_total_sequence($work_center)->MAX_SEQ;

        $data['content'] = 'prd/setup_chute/manage_setup_chute_v';
        $this->load->view($this->layout, $data);
    }

    function search_setup_chute($msg = NULL, $id_dept = NULL, $work_center = NULL, $status = NULL)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Template Anda Salah atau sudah diubah, Silahkan Coba Lagi Dengan Template Yang Benar </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = NULL;
        }

        $session = $this->session->all_userdata();
        $role = $session['ROLE'];

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(52);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Manage Setup Chute';
        $data['msg'] = $msg;
        $data['role'] = $role;

        if ($id_dept == NULL || $id_dept == '') {
            $id_dept = '21';
        }

        if ($work_center == NULL) {
            $work_center = $this->direct_backflush_general_m->get_top_work_center_by_id_dept($id_dept);
        }

        if ($status == NULL) {
            $status = 0;
        }

        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);

        $data['flg_phantom'] = $this->setup_chute_m->check_phantom_elina($work_center);
        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;
        $data['status'] = $status;

        //$data['data'] = $this->setup_chute_m->get_setup_chute($work_center); //==== before edit by ANU
        if ($status == 0) {
            $data['data'] = $this->setup_chute_m->get_setup_chute_open($work_center);
        } else if ($status == 1) {
            $data['data'] = $this->setup_chute_m->get_setup_chute_close($work_center);
        } else {
            $data['data'] = $this->setup_chute_m->get_setup_chute_uncomplete($work_center);
        }

        $data['max_seq'] = $this->setup_chute_m->get_total_sequence($work_center)->MAX_SEQ;

        $data['content'] = 'prd/setup_chute/manage_setup_chute_v';
        $this->load->view($this->layout, $data);
    }

    function create_special_order($msg = null, $id_dept = null, $work_center = null)
    {
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Creating success </strong> The data is successfully created </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Updating success </strong> The data is successfully updated </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Deleted success </strong> The data is successfully deleted </div >";
        } elseif ($msg == 15) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Cannot find BACK NO </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>&times;</button><strong>Executing error !</strong> Something error with parameter </div >";
        } else {
            $msg = NULL;
        }

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(52);
        $data['news'] = $this->news_m->get_news();
        $data['title'] = 'Create Special order';
        $data['msg'] = $msg;

        $all_dept_prod = $this->dept_m->get_all_prod_dept();
        $all_work_centers = $this->direct_backflush_general_m->get_work_center_by_id_dept($id_dept);
        $all_part_no = $this->setup_chute_m->get_all_part_no_by_wc($work_center);
        $all_back_no = $this->setup_chute_m->get_all_back_no_by_wc($work_center);

        //$data['max_seq'] = count($this->setup_chute_m->get_setup_chute($work_center));
        $data['max_seq'] = count($this->setup_chute_m->get_setup_chute_open($work_center));

        $data['all_dept_prod'] = $all_dept_prod;
        $data['all_work_centers'] = $all_work_centers;
        $data['all_part_no'] = $all_part_no;
        $data['all_back_no'] = $all_back_no;
        $data['work_center'] = $work_center;
        $data['id_dept'] = $id_dept;

        $data['content'] = 'prd/setup_chute/create_special_order_v';
        $this->load->view($this->layout, $data);
    }

    function update_setup_chute()
    {
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['NPK'];

        $id = $this->input->post('INT_ID');
        $new_sequence = $this->input->post('INT_SEQUENCE');
        $part_no = $this->input->post('CHR_PART_NO');
        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = $this->input->post('CHR_WORK_CENTER');
        $old_sequence = $this->input->post('INT_OLD_SEQUENCE');

        $cav = 0;
        if (substr($work_center, 0, 1) == 'P') {
            $check_cav = $this->db->query("SELECT *
                            FROM PRD.TM_CAVITY WHERE (CHR_PART_NO = '$part_no' OR CHR_PART_NO_MATE = '$part_no') AND INT_FLG_DEL = '0'");
            if ($check_cav->num_rows() > 0) {
                $cav = 1;
            }
        }

        $loop = 1;
        if ($cav == 1) {
            $part = $this->db->query("SELECT CHR_PART_NO, CHR_PART_NO_MATE
                            FROM PRD.TM_CAVITY WHERE (CHR_PART_NO = '$part_no' OR CHR_PART_NO_MATE = '$part_no') AND INT_FLG_DEL = '0'");

            if ($part->num_rows() > 0) {
                $loop = 2;
                $check_cav = $this->db->query("select INT_CAVITY from PRD.TT_SETUP_CHUTE where INT_ID = '$id'")->row();
                $get_cav_mate =  $this->db->query("select INT_ID, INT_SEQUENCE from PRD.TT_SETUP_CHUTE where INT_ID <> '$check_cav->INT_CAVITY' and INT_CAVITY = '$check_cav->INT_CAVITY'")->row();
                $id_mate = $get_cav_mate->INT_ID;
                $old_seq_mate = $get_cav_mate->INT_SEQUENCE;
            }

            for ($i = 1; $i <= $loop; $i++) {
                if ($i == $loop) {
                    $id = $id_mate;

                    if ($new_sequence > $old_sequence) {
                        $old_sequence = $old_seq_mate - 1;
                        $new_sequence = $new_sequence;
                    } else if ($new_sequence < $old_sequence) {
                        $old_sequence = $old_seq_mate;
                        $new_sequence = $new_sequence + 1;
                    }
                }

                if ($old_sequence != $new_sequence) {
                    if ($old_sequence == 0) {
                        $this->setup_chute_m->update_sequence_other_from_zero($work_center, $old_sequence, $new_sequence, $date, $time, $user); //update another sequence
                    } else {
                        if ($new_sequence < $old_sequence) {
                            $this->setup_chute_m->update_sequence_smaller($work_center, $old_sequence, $new_sequence, $date, $time, $user); //update another sequence
                        } else if ($new_sequence > $old_sequence) {
                            $this->setup_chute_m->update_sequence_bigger($work_center, $old_sequence, $new_sequence, $date, $time, $user); //update another sequence
                        }
                    }

                    //===== Update for sequence lot 1-5
                    $flg_shortage = 0;
                    $flg_stock = 0;
                    $flg_prd = 0;
                    $notes = NULL;
                    if ($old_sequence <= 5) {
                        $flg_shortage = 1;
                        $data_detail = $this->setup_chute_m->get_detail_setup_chute_by_id($id);
                        if ($data_detail->CHR_NOTES == NULL || $data_detail->CHR_NOTES == '') {
                            $notes = $this->input->post('NOTES');
                        } else {
                            $notes = $data_detail->CHR_NOTES . ';' . $this->input->post('NOTES');
                        }

                        // if($new_sequence > 5){
                        if ($new_sequence > 10) { //===== Request OMD open until 10 --> Menghindari print kanban berulang
                            $cek_prepare = $this->setup_chute_m->check_prepare_elina($data_detail->CHR_PRD_ORDER_NO);
                            if ($cek_prepare->num_rows() == 0) {
                                // $flg_stock = 0;
                                // $this->setup_chute_m->delete_data_elina($data_detail->CHR_PRD_ORDER_NO); //delete elina
                                $flg_stock = $data_detail->CHR_STATUS_BOM; //ppic ga pengen print prodno lagi
                            } else {
                                $flg_stock = $data_detail->CHR_STATUS_BOM;
                            }
                        } else {
                            $flg_stock = $data_detail->CHR_STATUS_BOM;
                        }

                        if ($old_sequence == 0) {
                            $flg_prd = 1;
                        } else {
                            $flg_prd = $data_detail->INT_FLG_PRD;
                        }

                        $this->setup_chute_m->update_sequence_shortage($new_sequence, $id, $date, $time, $user, $flg_stock, $flg_shortage, $notes, $flg_prd); //update selected part no
                        //===== End update for sequence lot 1-5
                    } else {
                        $this->setup_chute_m->update_sequence($new_sequence, $id, $date, $time, $user); //update selected part no
                    }

                    // Verification to update BOM sequence six up
                    $seq_six_up = $this->setup_chute_m->get_sequence_six_up($work_center);
                    if ($seq_six_up->num_rows() > 0) {
                        foreach ($seq_six_up->result() as $six_up) {
                            $cek_prepare = $this->setup_chute_m->check_prepare_elina($six_up->CHR_PRD_ORDER_NO);
                            if ($cek_prepare->num_rows() == 0) {
                                // $this->setup_chute_m->delete_data_elina($six_up->CHR_PRD_ORDER_NO); //Delete elina
                                // $this->setup_chute_m->update_status_bom_six_up($six_up->INT_ID); //Update status BOM
                            }
                        }
                    }
                }
            }
        } else {
            if ($old_sequence != $new_sequence) {
                if ($old_sequence == 0) {
                    $this->setup_chute_m->update_sequence_other_from_zero($work_center, $old_sequence, $new_sequence, $date, $time, $user); //update another sequence
                } else {
                    if ($new_sequence < $old_sequence) {
                        $this->setup_chute_m->update_sequence_smaller($work_center, $old_sequence, $new_sequence, $date, $time, $user); //update another sequence
                    } else if ($new_sequence > $old_sequence) {
                        $this->setup_chute_m->update_sequence_bigger($work_center, $old_sequence, $new_sequence, $date, $time, $user); //update another sequence
                    }
                }

                //===== Update for sequence lot 1-5
                $flg_shortage = 0;
                $flg_stock = 0;
                $flg_prd = 0;
                $notes = NULL;
                if ($old_sequence <= 5) {
                    $flg_shortage = 1;
                    $data_detail = $this->setup_chute_m->get_detail_setup_chute_by_id($id);
                    if ($data_detail->CHR_NOTES == NULL || $data_detail->CHR_NOTES == '') {
                        $notes = $this->input->post('NOTES');
                    } else {
                        $notes = $data_detail->CHR_NOTES . ';' . $this->input->post('NOTES');
                    }

                    // if($new_sequence > 5){
                    if ($new_sequence > 10) { //===== Request OMD open until 10 --> Menghindari print kanban berulang
                        $cek_prepare = $this->setup_chute_m->check_prepare_elina($data_detail->CHR_PRD_ORDER_NO);
                        if ($cek_prepare->num_rows() == 0) {
                            // $flg_stock = 0;
                            // $this->setup_chute_m->delete_data_elina($data_detail->CHR_PRD_ORDER_NO); //delete elina
                            $flg_stock = $data_detail->CHR_STATUS_BOM; //ppic ga pengen print prodno lagi
                        } else {
                            $flg_stock = $data_detail->CHR_STATUS_BOM;
                        }
                    } else {
                        $flg_stock = $data_detail->CHR_STATUS_BOM;
                    }

                    if ($old_sequence == 0) {
                        $flg_prd = 1;
                    } else {
                        $flg_prd = $data_detail->INT_FLG_PRD;
                    }

                    $this->setup_chute_m->update_sequence_shortage($new_sequence, $id, $date, $time, $user, $flg_stock, $flg_shortage, $notes, $flg_prd); //update selected part no
                    //===== End update for sequence lot 1-5
                } else {
                    $this->setup_chute_m->update_sequence($new_sequence, $id, $date, $time, $user); //update selected part no
                }

                // Verification to update BOM sequence six up
                $seq_six_up = $this->setup_chute_m->get_sequence_six_up($work_center);
                if ($seq_six_up->num_rows() > 0) {
                    foreach ($seq_six_up->result() as $six_up) {
                        $cek_prepare = $this->setup_chute_m->check_prepare_elina($six_up->CHR_PRD_ORDER_NO);
                        if ($cek_prepare->num_rows() == 0) {
                            // $this->setup_chute_m->delete_data_elina($six_up->CHR_PRD_ORDER_NO); //Delete elina
                            // $this->setup_chute_m->update_status_bom_six_up($six_up->INT_ID); //Update status BOM
                        }
                    }
                }
            }
        }

        redirect('prd/setup_chute_c/search_setup_chute/2/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function save_special_order()
    {
        $session = $this->session->all_userdata();
        $date = date('Ymd');
        $time = date('His');
        $user = $session['NPK'];

        $new_sequence = $this->input->post('INT_SEQUENCE');
        $type = trim($this->input->post('CHR_TYPE'));

        if ($type == '1') {
            $back_no = trim($this->input->post('CHR_BACK_NO'));
            $get_part_no  = $this->db->query("SELECT DISTINCT CHR_PART_NO FROM TM_KANBAN WHERE CHR_BACK_NO = '$back_no'")->row();
            $part_no = $get_part_no->CHR_PART_NO;
        } else {
            $part_no = trim($this->input->post('CHR_PART_NO'));
        }

        $id_dept = $this->input->post('INT_ID_DEPT');
        $work_center = trim($this->input->post('CHR_WORK_CENTER'));
        $lot_size = $this->input->post('INT_LOT_SIZE');
        $qty_per_box = $this->input->post('INT_QTY_PER_BOX');

        //===== Additional Case Cavity
        $flg_cavity = 0;
        $int_cavity = 0;
        $part_no_mate = trim($this->input->post('CHR_PART_NO_MATE'));
        if (substr($work_center, 0, 1) == 'P') {
            if ($part_no_mate != "" && $part_no_mate != NULL) {
                $flg_cavity = 1;
            }
        }

        // if($user == '9172'){
        //     print_r($part_no_mate);
        //     exit();
        // }

        $cek_back_no = $this->setup_chute_m->get_back_no_by_part_no($part_no);
        if (count($cek_back_no) == 0) {
            redirect('prd/setup_chute_c/create_special_order/15/' . $id_dept . '/' . $work_center, 'refresh');
        } else {
            $back_no = $cek_back_no->CHR_BACK_NO;
        }
        $cek_last_wo_no = $this->setup_chute_m->get_last_wo_no($work_center, $date);

        if (count($cek_last_wo_no) == 0) {
            $new_wo_no = $work_center . '/' . $date . '/001';
            $no = 1;
        } else {
            $last_wo_no = $cek_last_wo_no->CHR_PRD_ORDER_NO;
            $no = substr($last_wo_no, -3);
            $new_no = sprintf("%03d", $no + 1);
            $new_wo_no = $work_center . '/' . $date . '/' . $new_no;
        }

        //===== Check Work Center Phantom ELINA - By ANU 20210609 =====//
        $cek_phantom_work_center = $this->setup_chute_m->check_work_center_phantom_elina($work_center);
        $stat_bom = 0;
        if ($cek_phantom_work_center->num_rows() > 0) {
            $stat_bom = 1;
        }
        //===== End Update =====//

        $this->setup_chute_m->update_sequence_after_so($work_center, $new_sequence, $date, $time, $user); //update another sequence

        $data_row = array(
            'INT_SEQUENCE' => $new_sequence,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_DATE' => $date,
            'CHR_PART_NO' => $part_no,
            'CHR_BACK_NO' => $back_no,
            'CHR_PRD_ORDER_NO' => $new_wo_no,
            'CHR_STATUS_BOM' => $stat_bom,
            'INT_LOT_SIZE' => $lot_size,
            'INT_LOT_SIZE_ACTUAL' => $lot_size,
            'INT_QTY_PER_BOX' => $qty_per_box,
            'INT_QTY_PCS' => $lot_size * $qty_per_box,
            'CHR_CREATED_BY' => $user,
            'CHR_CREATED_DATE' => $date,
            'CHR_CREATED_TIME' => $time,
            'INT_FLG_SO' => 1,
            'INT_FLG_PRD' => 1
        );
        $this->setup_chute_m->insert_special_order($data_row); //insert special order

        $get_id_chute = $this->setup_chute_m->get_last_id_chute(trim($new_wo_no));
        $int_cavity = $get_id_chute->INT_ID;

        $data_upd = array(
            'INT_CAVITY' => $int_cavity
        );
        $this->setup_chute_m->update_by_id($int_cavity, $data_upd); //update column int_cavity

        //==== Additional Case for Part Cavity
        if ($flg_cavity == 1) {
            $cek_back_no_mate = $this->setup_chute_m->get_back_no_by_part_no($part_no_mate);
            if (count($cek_back_no_mate) == 0) {
                redirect('prd/setup_chute_c/create_special_order/15/' . $id_dept . '/' . $work_center, 'refresh');
            } else {
                $back_no_mate = $cek_back_no_mate->CHR_BACK_NO;
            }

            $new_no_mate = sprintf("%03d", $no + 2);
            $new_wo_no_mate = $work_center . '/' . $date . '/' . $new_no_mate;

            $new_sequence_mate = $new_sequence + 1;
            $this->setup_chute_m->update_sequence_after_so($work_center, $new_sequence_mate, $date, $time, $user); //update another sequence

            $data_row = array(
                'INT_SEQUENCE' => $new_sequence_mate,
                'CHR_WORK_CENTER' => $work_center,
                'CHR_DATE' => $date,
                'CHR_PART_NO' => $part_no_mate,
                'CHR_BACK_NO' => $back_no_mate,
                'CHR_PRD_ORDER_NO' => $new_wo_no_mate,
                'CHR_STATUS_BOM' => $stat_bom,
                'INT_LOT_SIZE' => $lot_size,
                'INT_LOT_SIZE_ACTUAL' => $lot_size,
                'INT_QTY_PER_BOX' => $qty_per_box,
                'INT_QTY_PCS' => $lot_size * $qty_per_box,
                'CHR_CREATED_BY' => $user,
                'CHR_CREATED_DATE' => $date,
                'CHR_CREATED_TIME' => $time,
                'INT_FLG_SO' => 1,
                'INT_FLG_PRD' => 1,
                'INT_CAVITY' => $int_cavity
            );
            $this->setup_chute_m->insert_special_order($data_row); //insert special order
        }

        redirect('prd/setup_chute_c/search_setup_chute/1/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function delete_setup_chute($id)
    {
        $date = date('Ymd');
        $time = date('His');
        $session = $this->session->all_userdata();
        $user = $session['NPK'];

        $data = $this->setup_chute_m->get_detail_setup_chute_by_id($id);
        $work_center = $data->CHR_WORK_CENTER;
        $part_no = $data->CHR_PART_NO;

        //===== Check cavity
        if (substr($work_center, 0, 1) == 'P') {
            $check_cav = $this->db->query("SELECT *
                            FROM PRD.TM_CAVITY WHERE (CHR_PART_NO = '$part_no' OR CHR_PART_NO_MATE = '$part_no') AND INT_FLG_DEL = '0'");
            if ($check_cav->num_rows() > 0) {
                $get_id_mate = $this->db->query("SELECT TOP 1 *
                                FROM PRD.TT_SETUP_CHUTE WHERE INT_ID <> '$id' AND INT_CAVITY = '$id'");
                if ($get_id_mate->num_rows() > 0) {
                    $data_id_mate = $get_id_mate->row();
                    $id_mate = $data_id_mate->INT_ID;
                    $seq_mate = $data_id_mate->INT_SEQUENCE;

                    if ($seq_mate > 0) {
                        $this->setup_chute_m->update_sequence_after_delete($work_center, $seq_mate, $date, $time, $user);
                    }

                    $this->setup_chute_m->delete_data_elina($data_id_mate->CHR_PRD_ORDER_NO); //delete elina
                    $this->setup_chute_m->delete($id_mate, $date, $time, $user);
                }
            }
        }

        $seq = $data->INT_SEQUENCE;
        $id_dept = $this->direct_backflush_general_m->get_prod_by_work_center($work_center);

        if ($seq > 0) {
            $this->setup_chute_m->update_sequence_after_delete($work_center, $seq, $date, $time, $user);
        }

        $this->setup_chute_m->delete_data_elina($data->CHR_PRD_ORDER_NO); //delete elina
        $this->setup_chute_m->delete($id, $date, $time, $user);

        redirect('prd/setup_chute_c/search_setup_chute/3/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function get_part_name()
    {
        $part_no = $id = $this->input->post('part_no');
        $part = $this->db->query("SELECT RTRIM([TM_PARTS].[CHR_PART_NO]) AS CHR_PART_NO, RTRIM([TM_PARTS].[CHR_PART_NAME]) AS CHR_PART_NAME, RTRIM([TM_KANBAN].[CHR_BACK_NO]) AS CHR_BACK_NO
                            FROM [TM_PARTS]
                            LEFT JOIN [TM_KANBAN] ON [TM_KANBAN].[CHR_PART_NO] = [TM_PARTS].[CHR_PART_NO]
                            WHERE [TM_PARTS].[CHR_PART_NO] = '$part_no'")->row();
        $data = trim($part->CHR_BACK_NO) . ' / ' . trim($part->CHR_PART_NO) . ' - ' . trim($part->CHR_PART_NAME);

        echo  $data;
    }

    function get_qty_by_partno()
    {
        $part_no = $id = $this->input->post('pn');
        $part = $this->db->query("SELECT [TM_KANBAN].[INT_QTY_PER_BOX]
                            FROM [TM_PARTS]
                            LEFT JOIN [TM_KANBAN] ON [TM_KANBAN].[CHR_PART_NO] = [TM_PARTS].[CHR_PART_NO]
                            WHERE [TM_PARTS].[CHR_PART_NO] = '$part_no'")->row();
        $data = trim($part->INT_QTY_PER_BOX);

        echo  $data;
    }

    function get_part_name_by_back_no()
    {
        $back_no = $id = $this->input->post('back_no');
        $part = $this->db->query("SELECT RTRIM([TM_PARTS].[CHR_PART_NO]) AS CHR_PART_NO, RTRIM([TM_PARTS].[CHR_PART_NAME]) AS CHR_PART_NAME, RTRIM([TM_KANBAN].[CHR_BACK_NO]) AS CHR_BACK_NO
                            FROM [TM_PARTS]
                            LEFT JOIN [TM_KANBAN] ON [TM_KANBAN].[CHR_PART_NO] = [TM_PARTS].[CHR_PART_NO]
                            WHERE [TM_KANBAN].[CHR_BACK_NO] = '$back_no'")->row();
        $data = trim($part->CHR_BACK_NO) . ' / ' . trim($part->CHR_PART_NO) . ' - ' . trim($part->CHR_PART_NAME);

        echo  $data;
    }

    function get_qty_by_backno()
    {
        $back_no = $id = $this->input->post('bn');
        $part = $this->db->query("SELECT [TM_KANBAN].[INT_QTY_PER_BOX]
                            FROM [TM_PARTS]
                            LEFT JOIN [TM_KANBAN] ON [TM_KANBAN].[CHR_PART_NO] = [TM_PARTS].[CHR_PART_NO]
                            WHERE [TM_KANBAN].[CHR_BACK_NO] = '$back_no'")->row();
        $data = trim($part->INT_QTY_PER_BOX);

        echo  $data;
    }

    function check_cavity()
    {
        $part_no = $this->input->post('partno');
        $part = $this->db->query("SELECT CHR_PART_NO, CHR_PART_NO_MATE
                            FROM PRD.TM_CAVITY WHERE (CHR_PART_NO = '$part_no' OR CHR_PART_NO_MATE = '$part_no') AND INT_FLG_DEL = '0'");

        $data_x = array();
        $part_no_mate = '';
        if ($part->num_rows() > 0) {
            $data_part = $part->row();
            if (trim($data_part->CHR_PART_NO) == trim($part_no)) {
                $part_no_mate = trim($data_part->CHR_PART_NO_MATE);
                $detail_part = $this->db->query("SELECT TOP 1 A.CHR_PART_NO, A.CHR_BACK_NO, B.CHR_PART_NAME 
                            FROM TM_KANBAN A 
                            LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                            WHERE A.CHR_PART_NO = '$part_no_mate' AND A.CHR_KANBAN_TYPE = '1' AND A.CHR_FLAG_DELETE IS NULL");
                if ($detail_part->num_rows() > 0) {
                    $detail_data = $detail_part->row();
                    $data = trim($detail_data->CHR_BACK_NO) . ' / ' . trim($detail_data->CHR_PART_NO) . ' - ' . trim($detail_data->CHR_PART_NAME);
                } else {
                    $data = 'Kanban Not Registered';
                }
            } else if (trim($data_part->CHR_PART_NO_MATE) == trim($part_no)) {
                $part_no_mate = trim($data_part->CHR_PART_NO);
                $detail_part = $this->db->query("SELECT TOP 1 A.CHR_PART_NO, A.CHR_BACK_NO, B.CHR_PART_NAME 
                            FROM TM_KANBAN A 
                            LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                            WHERE A.CHR_PART_NO = '$part_no_mate' AND A.CHR_KANBAN_TYPE = '1' AND A.CHR_FLAG_DELETE IS NULL");
                if ($detail_part->num_rows() > 0) {
                    $detail_data = $detail_part->row();
                    $data = trim($detail_data->CHR_BACK_NO) . ' / ' . trim($detail_data->CHR_PART_NO) . ' - ' . trim($detail_data->CHR_PART_NAME);
                } else {
                    $data = 'Kanban Not Registered';
                }
            }
        } else {
            $data = 'ERR';
        }

        $data_x = array(
            'msg' => $data,
            'partno_mate' => $part_no_mate
        );

        echo json_encode($data_x);
    }

    function check_cavity_by_back_no()
    {
        $back_no = $this->input->post('backno');
        $get_part_no  = $this->db->query("SELECT DISTINCT CHR_PART_NO FROM TM_KANBAN WHERE CHR_BACK_NO = '$back_no'")->row();
        $part_no = $get_part_no->CHR_PART_NO;
        $part = $this->db->query("SELECT CHR_PART_NO, CHR_PART_NO_MATE
                            FROM PRD.TM_CAVITY WHERE (CHR_PART_NO = '$part_no' OR CHR_PART_NO_MATE = '$part_no') AND INT_FLG_DEL = '0'");

        $data_x = array();
        $part_no_mate = '';
        if ($part->num_rows() > 0) {
            $data_part = $part->row();
            if (trim($data_part->CHR_PART_NO) == trim($part_no)) {
                $part_no_mate = trim($data_part->CHR_PART_NO_MATE);
                $detail_part = $this->db->query("SELECT TOP 1 A.CHR_PART_NO, A.CHR_BACK_NO, B.CHR_PART_NAME 
                            FROM TM_KANBAN A 
                            LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                            WHERE A.CHR_PART_NO = '$part_no_mate' AND A.CHR_KANBAN_TYPE = '1' AND A.CHR_FLAG_DELETE IS NULL");
                if ($detail_part->num_rows() > 0) {
                    $detail_data = $detail_part->row();
                    $data = trim($detail_data->CHR_BACK_NO) . ' / ' . trim($detail_data->CHR_PART_NO) . ' - ' . trim($detail_data->CHR_PART_NAME);
                } else {
                    $data = 'Kanban Not Registered';
                }
            } else if (trim($data_part->CHR_PART_NO_MATE) == trim($part_no)) {
                $part_no_mate = trim($data_part->CHR_PART_NO);
                $detail_part = $this->db->query("SELECT TOP 1 A.CHR_PART_NO, A.CHR_BACK_NO, B.CHR_PART_NAME 
                            FROM TM_KANBAN A 
                            LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                            WHERE A.CHR_PART_NO = '$part_no_mate' AND A.CHR_KANBAN_TYPE = '1' AND A.CHR_FLAG_DELETE IS NULL");
                if ($detail_part->num_rows() > 0) {
                    $detail_data = $detail_part->row();
                    $data = trim($detail_data->CHR_BACK_NO) . ' / ' . trim($detail_data->CHR_PART_NO) . ' - ' . trim($detail_data->CHR_PART_NAME);
                } else {
                    $data = 'Kanban Not Registered';
                }
            }
        } else {
            $data = 'ERR';
        }

        $data_x = array(
            'msg' => $data,
            'partno_mate' => $part_no_mate
        );

        echo json_encode($data_x);
    }

    function dandory_oneway()
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $date = date('Ymd');
        $time = date('His');

        $order_no = "ASDF01/20180802/001";
        $wcenter = "ASDF01";
        $data = $this->db->query("SELECT INT_SEQUENCE, CHR_PART_NO, CHR_BACK_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS
                FROM PRD.TT_SETUP_CHUTE
                WHERE CHR_WORK_CENTER = '$wcenter' AND CHR_PRD_ORDER_NO = '$order_no'")->row();

        $part_no = $data->CHR_PART_NO;
        $back_no = $data->CHR_BACK_NO;
        $lot_size = $data->INT_LOT_SIZE;
        $qty_per_box = $data->INT_QTY_PER_BOX;
        $qty_pcs = $data->INT_QTY_PCS;

        $check_kanban = $this->db->query("SELECT CHR_SERIAL FROM PRD.TT_ONE_WAY_KANBAN WHERE CHR_PRD_ORDER_NO = '$order_no'")->num_rows();

        if ($check_kanban == 0) {
            for ($i = 1; $i <= $lot_size; $i++) {
                $serial = sprintf('%05u', $i);

                $data_row = array(
                    'CHR_SERIAL' => $serial,
                    'CHR_WORK_CENTER' => $wcenter,
                    'CHR_PRD_ORDER_NO' => $order_no,
                    'CHR_PART_NO' => $part_no,
                    'CHR_BACK_NO' => $back_no,
                    'INT_LOT_SIZE' => $lot_size,
                    'INT_QTY_PER_BOX' => $qty_per_box,
                    'INT_QTY_PCS' => $qty_pcs,
                    'CHR_CREATED_BY' => $user,
                    'CHR_CREATED_DATE' => $date,
                    'CHR_CREATED_TIME' => $time
                );
                $this->setup_chute_m->insert_one_way_kanban($data_row); //insert one way kanban

                $get_id_kanban = $this->db->query("SELECT INT_ID FROM PRD.TT_ONE_WAY_KANBAN WHERE CHR_PRD_ORDER_NO = '$order_no' AND CHR_SERIAL = '$serial'")->row();
                $id_kanban = sprintf('%06u', $get_id_kanban->INT_ID);
                $this->load->library('ciqrcode');
                $params['data'] = "$id_kanban x $serial";
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $order_no) . '_' . $back_no . '_' . $serial . '.png';
                $this->ciqrcode->generate($params);
            }

            redirect('prd/setup_chute_c/print_kanban/' . str_replace("/", "", $order_no) . '/' . $wcenter . '/00001');
        } else {
            print_r("KANBAN SUDAH DIPRINT");
            exit();
        }
    }

    function print_kanban($order_no = null, $wcenter = null, $serial_no = null)
    {
        if ($order_no == null) {
            $order_no = "ASDF01/20180802/001";
        } else {
            $order_no = substr($order_no, 0, 6) . '/' . substr($order_no, 6, 8) . '/' . substr($order_no, 14, 3);
        }

        if ($wcenter == null) {
            $wcenter = "ASDF01";
        }

        $data_kanban = $this->db->query("SELECT TOP 1 A.CHR_SERIAL, A.CHR_PART_NO, A.CHR_BACK_NO, A.INT_LOT_SIZE, A.INT_QTY_PER_BOX, A.INT_QTY_PCS, 
                    B.CHR_BOX_TYPE, B.CHR_SLOC_FROM, B.CHR_SLOC_TO,
                    C.CHR_PART_NAME,
                    D.CHR_CUS_PART_NO, D.CHR_CUS_NO
                FROM PRD.TT_ONE_WAY_KANBAN A 
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO AND A.CHR_BACK_NO = B.CHR_BACK_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                LEFT JOIN TM_SHIPPING_PARTS D ON A.CHR_PART_NO = D.CHR_PART_NO
                WHERE A.CHR_WORK_CENTER = '$wcenter' AND A.CHR_PRD_ORDER_NO = '$order_no' AND A.INT_FLG_PRINT = '0' ORDER BY CHR_SERIAL ASC");
        if ($data_kanban->num_rows() > 0) {
            $data = $data_kanban->row();
            $part_no = $data->CHR_PART_NO;
            $back_no = $data->CHR_BACK_NO;
            $lot_size = $data->INT_LOT_SIZE;
            $qty_per_box = $data->INT_QTY_PER_BOX;
            $qty_pcs = $data->INT_QTY_PCS;
            $box_type = $data->CHR_BOX_TYPE;
            $part_name = $data->CHR_PART_NAME;
            $part_no_cust = $data->CHR_CUS_PART_NO;
            $sloc_from = $data->CHR_SLOC_FROM;
            $sloc_to = $data->CHR_SLOC_TO;
            $cust_no = $data->CHR_CUS_NO;

            if ($serial_no == null) {
                $serial_no = $data->CHR_SERIAL;
            }

            $fp = fsockopen("172.16.6.41", 1234, $errno, $errstr, 30);

            if (!$fp) {
                echo "Tidak bisa akses ke print server, silahkan hubungi MIS <br>";
            } else {
                $out = "$wcenter|$order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name";
                fwrite($fp, $out);
                while (!feof($fp)) {
                    echo fgets($fp, 128);
                }
            }

            fclose($fp);

            print_r("PRINT SUCCESS");
            exit();
        } else {
            print_r("PRINT COMPLETED");
            exit();
        }
    }

    function reprint_kanban($order_no = null, $wcenter = null, $serial_no = null)
    {
        if ($order_no == null) {
            $order_no = "ASDF01/20180802/001";
        } else {
            $order_no = substr($order_no, 0, 6) . '/' . substr($order_no, 6, 8) . '/' . substr($order_no, 14, 3);
        }

        if ($wcenter == null) {
            $wcenter = "ASDF01";
        }

        $data = $this->db->query("SELECT TOP 1 A.CHR_SERIAL, A.CHR_PART_NO, A.CHR_BACK_NO, A.INT_LOT_SIZE, A.INT_QTY_PER_BOX, A.INT_QTY_PCS, 
                    B.CHR_BOX_TYPE, B.CHR_SLOC_FROM, B.CHR_SLOC_TO,
                    C.CHR_PART_NAME,
                    D.CHR_CUS_PART_NO, D.CHR_CUS_NO
                FROM PRD.TT_ONE_WAY_KANBAN A 
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO AND A.CHR_BACK_NO = B.CHR_BACK_NO
                LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                LEFT JOIN TM_SHIPPING_PARTS D ON A.CHR_PART_NO = D.CHR_PART_NO
                WHERE A.CHR_WORK_CENTER = '$wcenter' AND A.CHR_PRD_ORDER_NO = '$order_no' AND A.INT_FLG_PRINT = '1' ORDER BY CHR_SERIAL DESC")->row();

        $part_no = $data->CHR_PART_NO;
        $back_no = $data->CHR_BACK_NO;
        $lot_size = $data->INT_LOT_SIZE;
        $qty_per_box = $data->INT_QTY_PER_BOX;
        $qty_pcs = $data->INT_QTY_PCS;
        $box_type = $data->CHR_BOX_TYPE;
        $part_name = $data->CHR_PART_NAME;
        $part_no_cust = $data->CHR_CUS_PART_NO;
        $sloc_from = $data->CHR_SLOC_FROM;
        $sloc_to = $data->CHR_SLOC_TO;
        $cust_no = $data->CHR_CUS_NO;
        $serial_no = $data->CHR_SERIAL;

        $fp = fsockopen("172.16.6.41", 1234, $errno, $errstr, 30);

        if (!$fp) {
            echo "Tidak bisa akses ke print server, silahkan hubungi MIS <br>";
        } else {
            $out = "$wcenter|$order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name";
            fwrite($fp, $out);
            while (!feof($fp)) {
                echo fgets($fp, 128);
            }
        }

        fclose($fp);

        print_r("RE-PRINT SUCCESS");
        exit();
    }

    function adjust_finish_lot($id = NULL, $stat = NULL)
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $date = date('Ymd');
        $time = date('His');

        $data_detail = $this->setup_chute_m->get_detail_setup_chute_by_id($id);
        $work_center = $data_detail->CHR_WORK_CENTER;
        if ($stat == 0) {
            if ($data_detail->CHR_NOTES_UNCOMPLETE == NULL || $data_detail->CHR_NOTES_UNCOMPLETE == '') {
                $notes = 'Lock Dandori';
            } else {
                $notes = $data_detail->CHR_NOTES_UNCOMPLETE . '; Lock Dandori';
            }
        } else {
            if ($data_detail->CHR_NOTES_UNCOMPLETE == NULL || $data_detail->CHR_NOTES_UNCOMPLETE == '') {
                $notes = 'Unlock Dandori';
            } else {
                $notes = $data_detail->CHR_NOTES_UNCOMPLETE . '; Unlock Dandori';
            }
        }


        $id_dept = $this->direct_backflush_general_m->get_prod_by_work_center($work_center);

        $data = array(
            'INT_FLG_ADJUST_FINISH' => $stat,
            'CHR_NOTES_UNCOMPLETE' => $notes,
            'CHR_EDITED_BY' => $user,
            'CHR_EDITED_DATE' => $date,
            'CHR_EDITED_TIME' => $time
        );

        $this->setup_chute_m->update_by_id($id, $data);

        redirect('prd/setup_chute_c/search_setup_chute/2/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function rearrange_setup_chute($msg = NULL, $id_dept = NULL, $work_center = NULL)
    {
        $data_chute = $this->setup_chute_m->get_all_setup_chute_open($work_center);
        if ($data_chute->num_rows() > 0) {
            $seq = 1;
            foreach ($data_chute->result() as $data) {
                $id = $data->INT_ID;
                $update_chute = $this->setup_chute_m->rearrange_chute($id, $seq);
                $seq++;
            }
        }

        redirect('prd/setup_chute_c/search_setup_chute/2/' . $id_dept . '/' . $work_center, 'refresh');
    }

    function get_updated_chute()
    {
        $id = $this->input->post('id');
        $old_seq = $this->input->post('old_seq');

        $data_chute = $this->setup_chute_m->get_detail_setup_chute_by_id($id);
        $data = $data_chute->INT_SEQUENCE;

        echo $data;
    }

    function recovery_setup_chute($id = NULL)
    {
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $date = date('Ymd');
        $time = date('His');

        $get_data_uncomplete = $this->setup_chute_m->get_data_uncomplete_by_id($id);

        if ($get_data_uncomplete->num_rows() > 0) {
            $data = $get_data_uncomplete->row();
            if ($data->INT_RECOVERY > 0) {
                $prd_order_no_ori = substr($data->CHR_PRD_ORDER_NO_REFF, 0, 19);
                $prd_order_no_last_rec = $data->CHR_PRD_ORDER_NO;
            } else {
                $prd_order_no_ori = $data->CHR_PRD_ORDER_NO;
                $prd_order_no_last_rec = $data->CHR_PRD_ORDER_NO;
            }

            $work_center = $data->CHR_WORK_CENTER;
            $id_dept = $this->direct_backflush_general_m->get_prod_by_work_center($work_center);

            $qty_per_box = $data->INT_QTY_PER_BOX;
            $qty_plan = $data->INT_QTY_PCS;
            $qty_act = $data->INT_QTY_PCS_ACTUAL;
            //===== REMAIN QTY
            $qty_diff = $qty_plan - $qty_act;
            $lot_diff = floor($qty_diff / $qty_per_box);
            $qty_diff_ecer = $qty_diff % $qty_per_box;

            $new_wo_no = "";
            $new_wo_no2 = "";
            $cek_last_recovery_no = $this->setup_chute_m->get_last_recovery_no($prd_order_no_ori);
            if ($cek_last_recovery_no->num_rows() == 0) {
                $last_recovery = 0;
            } else {
                $last_recovery = $cek_last_recovery_no->row()->INT_RECOVERY;
            }

            $cek_last_wo_no = $this->setup_chute_m->get_last_wo_no($work_center, $date);
            $cek_last_sequence = $this->setup_chute_m->get_last_sequence($work_center, $date);
            $new_sequence = $cek_last_sequence->INT_SEQUENCE + 1;

            //===== Check Work Center Phantom ELINA - By ANU 20210609 =====//
            $cek_phantom_work_center = $this->setup_chute_m->check_work_center_phantom_elina($work_center);
            $stat_bom = 0;
            if ($cek_phantom_work_center->num_rows() > 0) {
                $stat_bom = 1;
            }
            //===== End Update =====//

            if ($lot_diff > 0) {
                if (count($cek_last_wo_no) == 0) {
                    $new_wo_no = $work_center . '/' . $date . '/001';
                    $data_row = array(
                        'INT_SEQUENCE' => $new_sequence,
                        'INT_RECOVERY' => $last_recovery + 1,
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_DATE' => $date,
                        'CHR_PART_NO' => $data->CHR_PART_NO,
                        'CHR_BACK_NO' => $data->CHR_BACK_NO,
                        'CHR_PRD_ORDER_NO' => $new_wo_no,
                        'CHR_STATUS_BOM' => $stat_bom,
                        'INT_LOT_SIZE' => $lot_diff,
                        'INT_LOT_SIZE_ACTUAL' => $lot_diff,
                        'INT_QTY_PER_BOX' => $qty_per_box,
                        'INT_QTY_PCS' => $lot_diff * $qty_per_box,
                        'INT_QTY_PCS_ACTUAL' => 0,
                        'CHR_CREATED_BY' => $user,
                        'CHR_CREATED_DATE' => $date,
                        'CHR_CREATED_TIME' => $time,
                        'INT_FLG_PRD' => 1,
                        'INT_FLG_RECOVERY' => 1,
                        'CHR_PRD_ORDER_NO_REFF' => $prd_order_no_ori . ';' . $prd_order_no_last_rec
                    );
                    $this->setup_chute_m->insert_special_order($data_row);

                    if ($qty_diff_ecer > 0) {
                        $new_wo_no2 = $work_center . '/' . $date . '/002';
                        $new_sequence = $new_sequence + 1;
                        $data_row = array(
                            'INT_SEQUENCE' => $new_sequence,
                            'INT_RECOVERY' => $last_recovery + 2,
                            'CHR_WORK_CENTER' => $work_center,
                            'CHR_DATE' => $date,
                            'CHR_PART_NO' => $data->CHR_PART_NO,
                            'CHR_BACK_NO' => $data->CHR_BACK_NO,
                            'CHR_PRD_ORDER_NO' => $new_wo_no2,
                            'CHR_STATUS_BOM' => $stat_bom,
                            'INT_LOT_SIZE' => 1,
                            'INT_LOT_SIZE_ACTUAL' => 1,
                            'INT_QTY_PER_BOX' => $qty_diff_ecer,
                            'INT_QTY_PCS' => $qty_diff_ecer,
                            'INT_QTY_PCS_ACTUAL' => 0,
                            'CHR_CREATED_BY' => $user,
                            'CHR_CREATED_DATE' => $date,
                            'CHR_CREATED_TIME' => $time,
                            'INT_FLG_PRD' => 1,
                            'INT_FLG_RECOVERY' => 1,
                            'CHR_PRD_ORDER_NO_REFF' => $prd_order_no_ori . ';' . $prd_order_no_last_rec
                        );
                        $this->setup_chute_m->insert_special_order($data_row);
                    }
                } else {
                    $last_wo_no = $cek_last_wo_no->CHR_PRD_ORDER_NO;
                    $no = substr($last_wo_no, -3);
                    $new_no = sprintf("%03d", $no + 1);
                    $new_wo_no = $work_center . '/' . $date . '/' . $new_no;

                    $data_row = array(
                        'INT_SEQUENCE' => $new_sequence,
                        'INT_RECOVERY' => $last_recovery + 1,
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_DATE' => $date,
                        'CHR_PART_NO' => $data->CHR_PART_NO,
                        'CHR_BACK_NO' => $data->CHR_BACK_NO,
                        'CHR_PRD_ORDER_NO' => $new_wo_no,
                        'CHR_STATUS_BOM' => $stat_bom,
                        'INT_LOT_SIZE' => $lot_diff,
                        'INT_LOT_SIZE_ACTUAL' => $lot_diff,
                        'INT_QTY_PER_BOX' => $qty_per_box,
                        'INT_QTY_PCS' => $lot_diff * $qty_per_box,
                        'INT_QTY_PCS_ACTUAL' => 0,
                        'CHR_CREATED_BY' => $user,
                        'CHR_CREATED_DATE' => $date,
                        'CHR_CREATED_TIME' => $time,
                        'INT_FLG_PRD' => 1,
                        'INT_FLG_RECOVERY' => 1,
                        'CHR_PRD_ORDER_NO_REFF' => $prd_order_no_ori . ';' . $prd_order_no_last_rec
                    );
                    $this->setup_chute_m->insert_special_order($data_row);

                    if ($qty_diff_ecer > 0) {
                        $new_no2 = sprintf("%03d", $new_no + 1);
                        $new_wo_no2 = $work_center . '/' . $date . '/' . $new_no2;
                        $new_sequence = $new_sequence + 1;
                        $data_row = array(
                            'INT_SEQUENCE' => $new_sequence,
                            'INT_RECOVERY' => $last_recovery + 2,
                            'CHR_WORK_CENTER' => $work_center,
                            'CHR_DATE' => $date,
                            'CHR_PART_NO' => $data->CHR_PART_NO,
                            'CHR_BACK_NO' => $data->CHR_BACK_NO,
                            'CHR_PRD_ORDER_NO' => $new_wo_no2,
                            'CHR_STATUS_BOM' => $stat_bom,
                            'INT_LOT_SIZE' => 1,
                            'INT_LOT_SIZE_ACTUAL' => 1,
                            'INT_QTY_PER_BOX' => $qty_diff_ecer,
                            'INT_QTY_PCS' => $qty_diff_ecer,
                            'INT_QTY_PCS_ACTUAL' => 0,
                            'CHR_CREATED_BY' => $user,
                            'CHR_CREATED_DATE' => $date,
                            'CHR_CREATED_TIME' => $time,
                            'INT_FLG_PRD' => 1,
                            'INT_FLG_RECOVERY' => 1,
                            'CHR_PRD_ORDER_NO_REFF' => $prd_order_no_ori . ';' . $prd_order_no_last_rec
                        );
                        $this->setup_chute_m->insert_special_order($data_row);
                    }
                }
            } else {
                if (count($cek_last_wo_no) == 0) {
                    $new_wo_no2 = $work_center . '/' . $date . '/001';
                    $data_row = array(
                        'INT_SEQUENCE' => $new_sequence,
                        'INT_RECOVERY' => $last_recovery + 1,
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_DATE' => $date,
                        'CHR_PART_NO' => $data->CHR_PART_NO,
                        'CHR_BACK_NO' => $data->CHR_BACK_NO,
                        'CHR_PRD_ORDER_NO' => $new_wo_no2,
                        'CHR_STATUS_BOM' => $stat_bom,
                        'INT_LOT_SIZE' => 1,
                        'INT_LOT_SIZE_ACTUAL' => 1,
                        'INT_QTY_PER_BOX' => $qty_diff_ecer,
                        'INT_QTY_PCS' => $qty_diff_ecer,
                        'INT_QTY_PCS_ACTUAL' => 0,
                        'CHR_CREATED_BY' => $user,
                        'CHR_CREATED_DATE' => $date,
                        'CHR_CREATED_TIME' => $time,
                        'INT_FLG_PRD' => 1,
                        'INT_FLG_RECOVERY' => 1,
                        'CHR_PRD_ORDER_NO_REFF' => $prd_order_no_ori . ';' . $prd_order_no_last_rec
                    );
                    $this->setup_chute_m->insert_special_order($data_row);
                } else {
                    $last_wo_no = $cek_last_wo_no->CHR_PRD_ORDER_NO;
                    $no = substr($last_wo_no, -3);
                    $new_no = sprintf("%03d", $no + 1);
                    $new_wo_no2 = $work_center . '/' . $date . '/' . $new_no;

                    $data_row = array(
                        'INT_SEQUENCE' => $new_sequence,
                        'INT_RECOVERY' => $last_recovery + 1,
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_DATE' => $date,
                        'CHR_PART_NO' => $data->CHR_PART_NO,
                        'CHR_BACK_NO' => $data->CHR_BACK_NO,
                        'CHR_PRD_ORDER_NO' => $new_wo_no2,
                        'CHR_STATUS_BOM' => $stat_bom,
                        'INT_LOT_SIZE' => 1,
                        'INT_LOT_SIZE_ACTUAL' => 1,
                        'INT_QTY_PER_BOX' => $qty_diff_ecer,
                        'INT_QTY_PCS' => $qty_diff_ecer,
                        'INT_QTY_PCS_ACTUAL' => 0,
                        'CHR_CREATED_BY' => $user,
                        'CHR_CREATED_DATE' => $date,
                        'CHR_CREATED_TIME' => $time,
                        'INT_FLG_PRD' => 1,
                        'INT_FLG_RECOVERY' => 1,
                        'CHR_PRD_ORDER_NO_REFF' => $prd_order_no_ori . ';' . $prd_order_no_last_rec
                    );
                    $this->setup_chute_m->insert_special_order($data_row);
                }
            }

            redirect('prd/setup_chute_c/search_setup_chute/1/' . $id_dept . '/' . $work_center . '/2', 'refresh');
        } else {
            // redirect('prd/setup_chute_c/search_setup_chute/1/' . $id_dept . '/' . $work_center . '/12', 'refresh');
        }
    }

    //loop3r 20220122
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

    //loop3r 20220122
    public function getSetupChute()
    {
        $work_center = $this->input->post('work_center');
        $data = array('status' => false, 'message' => false);

        $data_setup_chute = $this->setup_chute_m->update_setup_chute_ready_to_use($work_center, null);

        if ($data_setup_chute->num_rows() > 0) {
            $data['status'] = true;
        } else {
            $data['message'] = 'Setup chute tidak ditemukan.';
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

    //loop3r 20220122
    public function checkUncompletedSetupChute()
    {
        $work_center = trim($this->input->post('work_center'));
        $data_json['status'] = true;

        $data_uncomplete_lot = $this->setup_chute_m->get_uncomplete_lot_data_new($work_center);

        if ($data_uncomplete_lot->num_rows() > 0) {
            $data_json['status'] = false;
            $data_uncomplete = $data_uncomplete_lot->row();
            $data_json['message'] = 'Kanban kurang ' . $data_uncomplete_lot->row()->INT_LOT_SIZE_ACTUAL . ' Lot, No Produksi ini akan dianggap tidak komplit';

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

                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5);

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

                    $this->setup_chute_m->updateSetupChute($data_uncomplete->INT_CAVITY, $update_finish);

                    fclose($fp);
                }
            }
        }

        if ('IS_AJAX') {
            echo json_encode($data_json);
        }
    }

    //Loop3r 202201
    public function stopSetupChute()
    {
        $work_center = $this->input->post('work_center');
        $prod_order_no = $this->input->post('prod_order_no');

        $this->setup_chute_m->updateSetupChuteNotUse($work_center, $prod_order_no);
        echo json_encode(true);
    }

    //loop3r
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

        $cek_add_info = $this->setup_chute_m->get_additional_info_kanban($part_no);
        $add_info = '';
        if ($cek_add_info->num_rows() > 0) {
            $add_info = $cek_add_info->row()->CHR_KANBAN_ADDITIONAL_INFO;
        }

        $check_kanban = $this->one_way_kanban_m->checkExisting($prod_order_no);
        if ($check_kanban == false) {

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

            for ($i = 1; $i <= $lot_size; $i++) {
                $serial = sprintf('%05u', $i);

                $this->load->library('ciqrcode');
                $params['data'] = "$prod_order_no $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                $params['level'] = 'B';
                $params['size'] = 2;
                $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $prod_order_no) . '_' . $back_no . '_' . $serial . '.png';
                $this->ciqrcode->generate($params);
            }
        }

        echo json_encode($json_data);
    }

    //loop3r 20220122
    public function printOneWayKanbanCavity()
    {
        $work_center = $this->input->post('work_center');
        $npk = $this->input->post('npk');
        $array_cavity = $this->input->post('array_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $json_data['status'] = true;

        foreach (json_decode($array_cavity) as $row) {

            $data_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban($work_center, $row->CHR_PRD_ORDER_NO);

            $part_no = trim($data_kbn->CHR_PART_NO);
            $back_no = $data_kbn->CHR_BACK_NO;
            $lot_size = $data_kbn->INT_LOT_SIZE;
            $qty_per_box = trim($data_kbn->INT_QTY_PER_BOX);
            $qty_pcs = $data_kbn->INT_QTY_PCS;
            $box_type = trim($data_kbn->CHR_BOX_TYPE);
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

            $check_kanban = $this->one_way_kanban_m->checkExisting($row->CHR_PRD_ORDER_NO);
            if ($check_kanban == false) {

                //Insert to table one way kanban, loop depend on lot size
                for ($i = 1; $i <= $lot_size; $i++) {
                    $serial = sprintf('%05u', $i);

                    $data_row = array(
                        'CHR_SERIAL' => $serial,
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
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
                    $params['data'] = "$row->CHR_PRD_ORDER_NO $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                    $params['level'] = 'B';
                    $params['size'] = 2;
                    $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $row->CHR_PRD_ORDER_NO) . '_' . $back_no . '_' . $serial . '.png';
                    $this->ciqrcode->generate($params);
                }

                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5);
                if (!$fp) {
                    $json_data['status'] = false;
                    $json_data['message'] =  $errno . ' - ' . $errstr;

                    $data_update_one_way_kanban = array(
                        'CHR_ERROR_MESSAGE' => $errstr
                    );
                    $id = array(
                        'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                        'CHR_SERIAL' => '00001'
                    );
                    $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);
                
                } else {
                    $out = "OK|$row->CHR_PRD_ORDER_NO|$part_no|$back_no|00001|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    fclose($fp);
                }
            } else {

                $last_serial = $check_kanban->CHR_SERIAL;
                for ($i = 1; $i <= $lot_size; $i++) {
                    $serial = sprintf('%05u', $i);

                    $this->load->library('ciqrcode');
                    $params['data'] = "$row->CHR_PRD_ORDER_NO $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                    $params['level'] = 'B';
                    $params['size'] = 2;
                    $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $row->CHR_PRD_ORDER_NO) . '_' . $back_no . '_' . $serial . '.png';
                    $this->ciqrcode->generate($params);
                }

                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5);
                if (!$fp) {
                    $json_data['status'] = false;
                    $json_data['message'] =  $errno . ' - ' . $errstr;
                } else {
                    $out = "OK|$row->CHR_PRD_ORDER_NO|$part_no|$back_no|$last_serial|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    fclose($fp);
                    $json_data['message'] =  $out;
                }
            }
        }

        echo json_encode($json_data);
    }

    //loop3r 20220122
    public function printNextOneWayKanbanCavity()
    {

        $work_center = $this->input->post('work_center');
        $serial_no_kanban = $this->input->post('serial_no_kanban');
        $array_cavity = $this->input->post('array_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $json_data['status'] = true;

        foreach (json_decode($array_cavity) as $row) {

            $data_update_one_way_kanban = array(
                'INT_FLG_SCANNED' => 1,
                'CHR_MODIFIED_DATE' => $date_entry,
                'CHR_MODIFIED_TIME' => $time_entry
            );
            $id = array(
                'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                'CHR_SERIAL' => $serial_no_kanban
            );
            $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);

            $data_one_way_kanban = $this->one_way_kanban_m->get_new_data_one_way_kanban($row->CHR_PRD_ORDER_NO);
            if ($data_one_way_kanban->num_rows() > 0) {

                $serial = $data_one_way_kanban->row()->CHR_SERIAL;
                $query_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban_update($work_center, $row->CHR_PRD_ORDER_NO, $serial);
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
                    $part_no = $data_kbn->CHR_PART_NO;
                    $back_no = $data_kbn->CHR_BACK_NO;
                    $qty_box = $data_kbn->INT_QTY_PER_BOX;

                    $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE
                    if (!$fp) {
                        $json_data['status'] = false;
                        $json_data['message'] =  $errno . ' - ' . $errstr;;
                    } else {
                        $out = "OK|$row->CHR_PRD_ORDER_NO|$part_no|$back_no|$serial_oneway|$part_no_cust|$lot_size|$qty_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                        fwrite($fp, $out);
                        fclose($fp);
                    }
                }
            }
        }

        echo json_encode($json_data);
    }

    //loop3r 20220122
    public function printOneWayKanbanManual()
    {
        $id = $this->input->post('id');
        $date_entry = date('Ymd');
        $time_entry = date('His');

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

            $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5); //=== LIVE IP

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

    //Loop3r 202226
    public function reprintKanban()
    {
        $work_center = $this->input->post('work_center');
        $array_cavity = $this->input->post('array_cavity');
        $json_data['status'] = false;

        foreach (json_decode($array_cavity) as $row) {
            $data = $this->one_way_kanban_m->get_one_way_kanban_data_by_order_no($row->CHR_PRD_ORDER_NO, $work_center);
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

                $fp = fsockopen("192.168.0.223", 1234, $errno, $errstr, 5);

                if (!$fp) {
                    $json_data['message'] =  $errno . ' - ' . $errstr;
                } else {
                    $out = "OK|$row->CHR_PRD_ORDER_NO|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    $json_data['status'] = true;
                    fclose($fp);
                }
            } else {
                $json_data['message'] = 'Data kanban tidak ter-create.';
            }
        }

        echo json_encode($json_data);
    }

    //loop3r - trial new server print --> only method scan kanban & label
    public function printOneWayKanban()
    {
        $work_center = $this->input->post('work_center');
        $npk = $this->input->post('npk');
        $array_cavity = $this->input->post('array_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $json_data['status'] = true;

        foreach (json_decode($array_cavity) as $row) {

            $data_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban($work_center, $row->CHR_PRD_ORDER_NO);

            $part_no = trim($data_kbn->CHR_PART_NO);
            $back_no = $data_kbn->CHR_BACK_NO;
            $lot_size = $data_kbn->INT_LOT_SIZE;
            $qty_per_box = trim($data_kbn->INT_QTY_PER_BOX);
            $qty_pcs = $data_kbn->INT_QTY_PCS;
            $box_type = trim($data_kbn->CHR_BOX_TYPE);
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

            $check_kanban = $this->one_way_kanban_m->checkExisting($row->CHR_PRD_ORDER_NO);
            if ($check_kanban == false) {

                //Insert to table one way kanban, loop depend on lot size
                for ($i = 1; $i <= $lot_size; $i++) {
                    $serial = sprintf('%05u', $i);

                    $data_row = array(
                        'CHR_SERIAL' => $serial,
                        'CHR_WORK_CENTER' => $work_center,
                        'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
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
                    $params['data'] = "$row->CHR_PRD_ORDER_NO $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                    $params['level'] = 'B';
                    $params['size'] = 2;
                    $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $row->CHR_PRD_ORDER_NO) . '_' . $back_no . '_' . $serial . '.png';
                    $this->ciqrcode->generate($params);
                }

                $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 5);
                if (!$fp) {
                    $json_data['status'] = false;
                    $json_data['message'] =  $errno . ' - ' . $errstr;

                    $data_update_one_way_kanban = array(
                        'CHR_ERROR_MESSAGE' => $errstr
                    );
                    $id = array(
                        'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                        'CHR_SERIAL' => '00001'
                    );
                    $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);
                } else {
                    $out = "OK|$row->CHR_PRD_ORDER_NO|$part_no|$back_no|00001|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    fclose($fp);
                }
            } else {

                $last_serial = $check_kanban->CHR_SERIAL;
                // for ($i = 1; $i <= $lot_size; $i++) {
                //     $serial = sprintf('%05u', $i);

                //     $this->load->library('ciqrcode');
                //     $params['data'] = "$row->CHR_PRD_ORDER_NO $serial $part_no $qty_per_box $part_no_cust $add_info"; // ===== Add Additional Info Kanban
                //     $params['level'] = 'B';
                //     $params['size'] = 2;
                //     $params['savename'] = 'assets/file/qrcode_prd/' . str_replace("/", "", $row->CHR_PRD_ORDER_NO) . '_' . $back_no . '_' . $serial . '.png';
                //     $this->ciqrcode->generate($params);
                // }

                $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 5);
                if (!$fp) {
                    $json_data['status'] = false;
                    $json_data['message'] =  $errno . ' - ' . $errstr;

                    $data_update_one_way_kanban = array(
                        'CHR_ERROR_MESSAGE' => $errstr
                    );
                    $id = array(
                        'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                        'CHR_SERIAL' => $last_serial
                    );
                    $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);
                    
                } else {
                    $out = "OK|$row->CHR_PRD_ORDER_NO|$part_no|$back_no|$last_serial|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    fclose($fp);
                    $json_data['message'] =  $out;
                }
            }
        }

        echo json_encode($json_data);
    }

    //loop3r - trial new server print
    public function printNextOneWayKanban()
    {
        $work_center = $this->input->post('work_center');
        $serial_no_kanban = $this->input->post('serial_no_kanban');
        $array_cavity = $this->input->post('array_cavity');
        $date_entry = date('Ymd');
        $time_entry = date('His');
        $json_data['status'] = true;

        foreach (json_decode($array_cavity) as $row) {

            $data_update_one_way_kanban = array(
                'INT_FLG_SCANNED' => 1,
                'CHR_MODIFIED_DATE' => $date_entry,
                'CHR_MODIFIED_TIME' => $time_entry
            );
            $id = array(
                'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                'CHR_SERIAL' => $serial_no_kanban
            );
            $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);

            $data_one_way_kanban = $this->one_way_kanban_m->get_new_data_one_way_kanban($row->CHR_PRD_ORDER_NO);
            if ($data_one_way_kanban->num_rows() > 0) {

                $serial = $data_one_way_kanban->row()->CHR_SERIAL;
                $query_kbn = $this->setup_chute_m->get_setup_chute_for_one_way_kanban_update($work_center, $row->CHR_PRD_ORDER_NO, $serial);
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
                    $part_no = $data_kbn->CHR_PART_NO;
                    $back_no = $data_kbn->CHR_BACK_NO;
                    $qty_box = $data_kbn->INT_QTY_PER_BOX;

                    $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 5); //=== LIVE
                    if (!$fp) {
                        $json_data['status'] = false;
                        $json_data['message'] =  $errno . ' - ' . $errstr;

                        $data_update_one_way_kanban = array(
                            'CHR_ERROR_MESSAGE' => $errstr
                        );
                        $id = array(
                            'CHR_PRD_ORDER_NO' => $row->CHR_PRD_ORDER_NO,
                            'CHR_SERIAL' => $serial_oneway
                        );
                        $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);
                    } else {
                        $out = "OK|$row->CHR_PRD_ORDER_NO|$part_no|$back_no|$serial_oneway|$part_no_cust|$lot_size|$qty_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                        fwrite($fp, $out);
                        fclose($fp);
                    }
                }
            }
        }

        echo json_encode($json_data);
    }

    //loop3r - trial new server print
    public function printOneWayProduct()
    {

        $wo_number = trim($this->input->post('wo_number'));
        $work_center = substr($wo_number, 0, -16);
        $prod_order_no = $this->input->post('prod_order_no');
        $json_data['status'] = true;

        $cek_recovery = $this->setup_chute_m->get_status_recovery_by_prod_no($prod_order_no);
        if ($cek_recovery->INT_FLG_RECOVERY == 1) {
            $prod_order_no_print = $prod_order_no;
        } else {
            $prod_order_no_print = $prod_order_no;
        }

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
                $part_no = $data_kbn->CHR_PART_NO;
                $back_no = $data_kbn->CHR_BACK_NO;

                $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 5); //=== LIVE IP

                if (!$fp) {
                    $json_data['status'] = false;
                    $json_data['message'] =  $errno . ' - ' . $errstr;

                    $data_update_one_way_kanban = array(
                        'CHR_ERROR_MESSAGE' => $errstr
                    );
                    $id = array(
                        'CHR_PRD_ORDER_NO' => $prod_order_no_print,
                        'CHR_SERIAL' => $serial_oneway
                    );
                    $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);
                } else {
                    $out = "OK|$prod_order_no_print|$part_no|$back_no|$serial_oneway|$part_no_cust|$lot_size|$qty_per_box_print|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                    fwrite($fp, $out);
                    fclose($fp);
                }
            }
        }

        echo json_encode($json_data);
    }

    //loop3r - trial new server print
    public function printOneWayKanbanById()
    {
        $id = $this->input->post('id');

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

            $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 5); //=== LIVE IP

            if (!$fp) {
                $json_data['message'] =  $errno . ' - ' . $errstr;
                $json_data['status'] =  false;

                $data_update_one_way_kanban = array(
                    'CHR_ERROR_MESSAGE' => $errstr
                );
                $id = array(
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'CHR_SERIAL' => $serial_no
                );
                $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);
            } else {

                $data_update_one_way_kanban = array(
                    'CHR_ERROR_MESSAGE' => NULL
                );
                $id = array(
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'CHR_SERIAL' => $serial_no
                );
                $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);

                $out = "OK|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                $json_data['status'] = true;
                fclose($fp);
            }
        }

        echo json_encode($json_data);
    }

    //loop3r - trial new server print
    public function reprintOneWayKanban()
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

            $fp = fsockopen("192.168.0.204", 1234, $errno, $errstr, 5);

            if (!$fp) {
                $json_data['message'] =  $errno . ' - ' . $errstr;

                $data_update_one_way_kanban = array(
                    'CHR_ERROR_MESSAGE' => $errstr
                );
                $id = array(
                    'CHR_PRD_ORDER_NO' => $prod_order_no,
                    'CHR_SERIAL' => $serial_no
                );
                $this->one_way_kanban_m->update($data_update_one_way_kanban, $id);
            } else {
                $out = "OK|$prod_order_no|$part_no|$back_no|$serial_no|$part_no_cust|$lot_size|$qty_per_box|$box_type|$sloc_from|$sloc_to|$cust_no|$part_name|$rack_no";
                fwrite($fp, $out);
                $json_data['status'] = true;
                fclose($fp);
            }
        } else {
            $json_data['message'] = 'Tidak ditemukan kanban dengan order no ' . $prod_order_no;
        }

        echo json_encode($json_data);
    }
}
