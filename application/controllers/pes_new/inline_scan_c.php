<?php

class Inline_scan_c extends CI_Controller {

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();

        $this->load->model('pes_new/prod_result_approval_m');
        $this->load->model('pes/production_result_history_m');
        $this->load->model('pes/production_result_m');
        $this->load->model('pes/ng_m');
        $this->load->model('pes/line_stop_m');
        $this->load->model('part/process_part_m');
        $this->load->model('pes/prod_result_m');
    }

    public function index() {
        
    }

    //add Javascript 
    public function addNgOthers() {
        $data = " ";
        $back_no = $this->input->post('backNo');
        $part_name = $this->input->post('partName');
        $PV = $this->input->post('PV');
        $iii = $this->input->post('iii');

        $tot_qty_ng = $this->input->post('qty');
        $cpu_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $npk = $this->session->userdata('NPK');
        $user_name = $this->session->userdata('USERNAME');

        $waktu_picking = $this->input->post('waktu_picking');
        $partNo = trim($this->input->post('partNo'));
        $qty = $this->input->post('qty');
        $reason_id = $this->input->post('reason_id');
        $reason = $this->input->post('reason');
        $date_entry1 = $this->input->post('date');
        $int_number_ng = $this->input->post('int_number');

        $date_explode = explode("/", $date_entry1);

        $date_entry = $date_explode[2] . $date_explode[1] . $date_explode[0];
        $yearNow = $date_explode[2];
        $shift = $this->input->post('shift');
        $workCenter = $this->input->post('workCenter');
        $monthNow = date("m", strtotime($date_entry));

        $date_now = date("Ymd");
        $time_now = date("His");

        //adding by Ilham 26.05.2017 for Standardization Routing Project 
        $validate_pn = $this->process_part_m->check_part_no($partNo);
        if ($validate_pn == 0) {
            $validate_pn = 'X';
        } else {
            $validate_pn = 'P';
        }

        //cek ke tt_prod result
        $cek_prod_res = $this->db->query("select * from TT_PRODUCTION_RESULT where CHR_DATE = '$date_entry' and CHR_WORK_CENTER = '$workCenter' and CHR_PART_NO = '$partNo' and CHR_SHIFT = '$shift'")->result();
        if (count($cek_prod_res) == 0) {
            //insert TT_PROD_RESULT
            $this->db->query("INSERT INTO TT_PRODUCTION_RESULT (CHR_WO_NUMBER, CHR_DATE, CHR_PLANT, CHR_BACK_NO, "
                    . "CHR_PART_NO, CHR_PART_NAME, CHR_WORK_CENTER, INT_BULAN, INT_TAHUN, CHR_PV, CHR_SHIFT, CHR_WORK_DAY, "
                    . "CHR_WORK_TIME_START, INT_TOTAL_QTY, CHR_UOM, CHR_IP, CHR_USER, INT_NPK, CHR_VALIDATE, CHR_NPK_VALIDATE, "
                    . "CHR_IPUP, CHR_USERUP, CHR_DATE_UPLOAD, CHR_TIME_UPLOAD, CHR_UPLOAD, CHR_STATUS, CHR_MESSAGE, CHR_MATDOC, "
                    . "CHR_STATUS_MOBILE, CHR_REVERSE, CHR_DATE_ENTRY, CHR_TIME_ENTRY, INT_NG_PRC, INT_NG_BRKNTEST, INT_NG_SETUP, "
                    . "INT_NG_TRIAL ,INT_NG_OTHERS , INT_TOTAL_NG ) "
                    . "VALUES ('-', '$date_entry', '600', '$back_no', "
                    . "'$partNo', '$part_name', '$workCenter', $monthNow, $yearNow, '$PV', '$shift', '-', "
                    . "'-', 0, 'PC', '$cpu_name', '$user_name', '$npk', '$validate_pn', 'SYS', "
                    . "'-', '-', '-', '-', '-', '-', ' ', ' ',"
                    . " 'D', '0', '$date_now', '$time_now', $tot_qty_ng, 0, 0, "
                    . "0 ,0 , $tot_qty_ng );");

            //ambil id
            $getIdPrd = $this->db->query("SELECT TOP (1) INT_NUMBER FROM TT_PRODUCTION_RESULT ORDER BY INT_NUMBER DESC")->result();
            $id_prd = $getIdPrd[0]->INT_NUMBER;

            //INSERT TT_NG_OTHE
            $this->db->query("INSERT INTO TT_NG_OTHER (INT_ID_PRODUCTION_RESULT, CHR_NG_CATEGORY_CODE, INT_QTY_NG, CHR_CREATED_BY, CHR_CREATED_DATE , CHR_CREATED_TIME) VALUES ($id_prd, '$reason_id', $qty , '$npk' , '$date_now' , '$time_now');");
            //$this->db->query("");
        } else {
            $id_prd = $cek_prod_res[0]->INT_NUMBER;
            $cek_NG_others = $this->db->query("SELECT * FROM TT_NG_OTHER WHERE (INT_ID_PRODUCTION_RESULT = $int_number_ng) AND CHR_NG_CATEGORY_CODE = '$reason_id'")->result();

            if (count($cek_NG_others) == 0) {
                //insert
                //ambil sum ng others
                $this->db->query("INSERT INTO TT_NG_OTHER (INT_ID_PRODUCTION_RESULT, CHR_NG_CATEGORY_CODE, INT_QTY_NG, CHR_CREATED_BY , CHR_CREATED_DATE , CHR_CREATED_TIME) VALUES ($int_number_ng, '$reason_id', $qty , '$npk' , '$date_now' , '$time_now');");
                $sum_ng_others = $this->db->query("select sum(int_qty_ng) as 'qty_total' from TT_NG_OTHER   WHERE (INT_ID_PRODUCTION_RESULT = $int_number_ng) ")->result();
                $qty_prc = 0;
                if (count($sum_ng_others) > 0) {
                    $qty_prc = $sum_ng_others[0]->qty_total;
                }
                $tot_qty_ng = $cek_prod_res[0]->INT_NG_BRKNTEST + $cek_prod_res[0]->INT_NG_SETUP + $cek_prod_res[0]->INT_NG_TRIAL + $qty_prc;

                $chr_status_ng_upload_sap = $cek_prod_res[0]->CHR_STATUS_NG;
                if ($chr_status_ng_upload_sap == "S") { //|| $chr_status_ng_upload_sap == "5"
                    $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC_REV = INT_NG_PRC, INT_NG_BRKNTEST_REV = INT_NG_BRKNTEST, INT_NG_SETUP_REV = INT_NG_SETUP, INT_NG_TRIAL_REV = INT_NG_TRIAL ,INT_TOTAL_NG_REV = INT_TOTAL_NG WHERE INT_NUMBER = $int_number_ng;");
                    $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng , CHR_REVERSE_NG = 'R' , CHR_STATUS_NG = 'R', CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now'   WHERE  INT_NUMBER=$int_number_ng;");
                } else {
                    $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng , CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now'  WHERE  INT_NUMBER=$int_number_ng;");
                }

                $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng , CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now' WHERE  INT_NUMBER=$int_number_ng;");
            } else {
                $this->db->query("UPDATE TT_NG_OTHER SET INT_QTY_NG=$qty , CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now'  WHERE  INT_ID_PRODUCTION_RESULT=$id_prd and CHR_NG_CATEGORY_CODE = '$reason_id';");

                $sum_ng_others = $this->db->query("select sum(int_qty_ng) as 'qty_total' from TT_NG_OTHER   WHERE (INT_ID_PRODUCTION_RESULT = $int_number_ng) ")->result();
                $qty_prc = 0;
                if (count($sum_ng_others) > 0) {
                    $qty_prc = $sum_ng_others[0]->qty_total;
                }
                $tot_qty_ng = $cek_prod_res[0]->INT_NG_BRKNTEST + $cek_prod_res[0]->INT_NG_SETUP + $cek_prod_res[0]->INT_NG_TRIAL + $qty_prc;


                $chr_status_ng_upload_sap = $cek_prod_res[0]->CHR_STATUS_NG;
                if ($chr_status_ng_upload_sap == "S") { //|| $chr_status_ng_upload_sap == "5"
                    $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC_REV = INT_NG_PRC, INT_NG_BRKNTEST_REV = INT_NG_BRKNTEST, INT_NG_SETUP_REV = INT_NG_SETUP, INT_NG_TRIAL_REV = INT_NG_TRIAL ,INT_TOTAL_NG_REV = INT_TOTAL_NG WHERE INT_NUMBER = $int_number_ng;");
                    $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng, CHR_REVERSE_NG = 'R' , CHR_STATUS_NG = 'R', CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now'   WHERE  INT_NUMBER=$int_number_ng;");
                } else {
                    $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng, CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now'  WHERE  INT_NUMBER=$int_number_ng;");
                }
            }
        }

        //ambil table

        $getTableNGOthers = $this->db->query("select TT_NG_OTHER.* , TM_NG.CHR_NG_CATEGORY_CODE , TM_NG.CHR_NG_CATEGORY  from TT_NG_OTHER 
                inner join TM_NG
                on TT_NG_OTHER.CHR_NG_CATEGORY_CODE = TM_NG.CHR_NG_CATEGORY_CODE
                where (INT_ID_PRODUCTION_RESULT = $int_number_ng) AND TM_NG.CHR_NG_CATEGORY_CODE NOT IN ('NG2' , 'NG3' , 'NG4' ) order by INT_ID_OTHER asc")->result();
        $no = 1;
        $data .= "<thead>
                        <tr>
                            <th style='text-align:center;'>No</th>
                            <th style='text-align:center;'>Reason</th>
                            <th style='text-align:center;'>Qty</th>
                            <th style='text-align:center;'>Option</th>
                        </tr>
                      </thead><tbody>";
        $total_ng = 0;
        foreach ($getTableNGOthers as $valueNGOthers) {
            $total_ng = $valueNGOthers->INT_QTY_NG + $total_ng;
            $data .= "<tr>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$no</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$valueNGOthers->CHR_NG_CATEGORY</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$valueNGOthers->INT_QTY_NG</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;' onclick=\"deleteNG($valueNGOthers->INT_ID_PRODUCTION_RESULT , '$valueNGOthers->CHR_NG_CATEGORY_CODE', '$partNo')\"> <span class='btn bg-red'>Delete</span></td>";
            $data .= "</tr>";
            $no++;
        }
        $data .= "</tbody>";

        echo json_encode(array("a" => $data, "b" => $total_ng));
    }

    public function deleteNG() {
        $date_now = date("Ymd");
        $time_now = date("His");
        $npk = $this->session->userdata('NPK');
        $id_prd = $this->input->post('idPrd');
        $idNGCat = trim($this->input->post('idNGCat'));
        $cek_prod_res = $this->db->query("select * from TT_PRODUCTION_RESULT where INT_NUMBER = '$id_prd' ")->result();
        $this->db->query("DELETE FROM TT_NG_OTHER WHERE  INT_ID_PRODUCTION_RESULT=$id_prd and CHR_NG_CATEGORY_CODE = '$idNGCat';");


        $sum_ng_others = $this->db->query("select sum(int_qty_ng) as 'qty_total' from TT_NG_OTHER   WHERE (INT_ID_PRODUCTION_RESULT = $id_prd) ")->result();
        $qty_prc = 0;
        if (count($sum_ng_others) > 0 and $sum_ng_others[0]->qty_total <> NULL) {
            $qty_prc = $sum_ng_others[0]->qty_total;
        }
        $tot_qty_ng = $cek_prod_res[0]->INT_NG_BRKNTEST + $cek_prod_res[0]->INT_NG_SETUP + $cek_prod_res[0]->INT_NG_TRIAL + $qty_prc;

        $chr_status_ng_upload_sap = $cek_prod_res[0]->CHR_STATUS_NG;
        if ($chr_status_ng_upload_sap == "S") { //|| $chr_status_ng_upload_sap == "5"
            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC_REV = INT_NG_PRC, INT_NG_BRKNTEST_REV = INT_NG_BRKNTEST, INT_NG_SETUP_REV = INT_NG_SETUP, INT_NG_TRIAL_REV = INT_NG_TRIAL ,INT_TOTAL_NG_REV = INT_TOTAL_NG WHERE INT_NUMBER = $id_prd;");
            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng , CHR_REVERSE_NG = 'R' , CHR_STATUS_NG = 'R', CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now'  WHERE  INT_NUMBER=$id_prd;");
        } else {
            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng, CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now'  WHERE  INT_NUMBER=$id_prd;");
        }
        $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng, CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now' WHERE  INT_NUMBER=$id_prd;");
    }

    public function refreshTableNG() {
        $data = ' ';
        $tot_qty_ng = $this->input->post('qty');
        $cpu_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $npk = $this->session->userdata('NPK');
        $user_name = $this->session->userdata('USERNAME');
        $waktu_picking = $this->input->post('waktu_picking');
        $partNo = trim($this->input->post('partNo'));
        $date_entry1 = $this->input->post('date');
        $date_explode = explode("/", $date_entry1);
        $date_entry = $date_explode[2] . $date_explode[1] . $date_explode[0];
        $yearNow = $date_explode[2];
        $shift = $this->input->post('shift');
        $workCenter = $this->input->post('workCenter');
        $int_number = $this->input->post('int_number');

        $cek_prod_res = $this->db->query("SELECT * from TT_PRODUCTION_RESULT where CHR_DATE = '$date_entry' and CHR_WORK_CENTER = '$workCenter' and CHR_PART_NO = '$partNo' and CHR_SHIFT = '$shift'")->result();
        if (count($cek_prod_res) == 0) {
            $id_prd = '';
        } else {
            $id_prd = $cek_prod_res[0]->INT_NUMBER;
        }

        $getTableNGOthers = $this->db->query("SELECT TT_NG_OTHER.* , RTRIM(TM_NG.CHR_NG_CATEGORY_CODE) CHR_NG_CATEGORY_CODE, TM_NG.CHR_NG_CATEGORY  from TT_NG_OTHER 
                INNER JOIN TM_NG 
                ON TT_NG_OTHER.CHR_NG_CATEGORY_CODE = TM_NG.CHR_NG_CATEGORY_CODE
                where (INT_ID_PRODUCTION_RESULT = $int_number) AND TM_NG.CHR_NG_CATEGORY_CODE NOT IN ('NG2' , 'NG3' , 'NG4' )")->result();
        $no = 1;
        $data .= "<thead>
                        <tr>
                            <th style='text-align:center;'>No</th>
                            <th style='text-align:center;'>Reason</th>
                            <th style='text-align:center;'>Qty</th>
                            <th style='text-align:center;'>Option</th>
                        </tr>
                      </thead><tbody>";
        $total_ng = 0;
        foreach ($getTableNGOthers as $valueNGOthers) {
            $total_ng = $valueNGOthers->INT_QTY_NG + $total_ng;
            $data .= "<tr>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$no</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$valueNGOthers->CHR_NG_CATEGORY</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$valueNGOthers->INT_QTY_NG</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;' onclick=\"deleteNG($valueNGOthers->INT_ID_PRODUCTION_RESULT , '$valueNGOthers->CHR_NG_CATEGORY_CODE' , '$partNo')\"> <span class='btn bg-red'>Delete</span></td>";
            $data .= "</tr>";
            $no++;
        }
        $data .= "</tbody>";
        echo json_encode(array("a" => $data, "b" => $total_ng));
    }

    public function form($date = '', $shift = '', $w_center = '', $set = '', $filter = '') {
        $this->role_module_m->authorization('32');
        $id_dept = $this->session->userdata('DEPT');

        if ($date == "" || $shift == "" || $w_center == "" || $set == "") {
            $date = date("Ymd");
            $shift = "1";
            
            $get_wcenter = $this->db->query("SELECT TOP 1 RTRIM(CHR_WORK_CENTER) CHR_WORK_CENTER FROM TM_INLINE_SCAN WHERE INT_ID_DEPT = '$id_dept' GROUP BY CHR_WORK_CENTER ORDER BY CHR_WORK_CENTER ASC")->row();
            $w_center = $get_wcenter->CHR_WORK_CENTER;


            if ($w_center != '') {
                redirect("pes_new/inline_scan_c/form/$date/1/$w_center/0", "refresh");
            } else {
                redirect("fail_c/auth"); 
            }
        }

        $wcenters = $this->db->query("SELECT RTRIM(CHR_WORK_CENTER) CHR_WORK_CENTER FROM TM_INLINE_SCAN WHERE INT_ID_DEPT = '$id_dept' AND CHR_WORK_CENTER <> 'OTHER' GROUP BY CHR_WORK_CENTER ORDER BY CHR_WORK_CENTER ASC")->result();
        $masterNg = $this->ng_m->get_all_ng();
        $parts = $this->process_part_m->get_part_by_wo($date, $id_dept, $shift, $w_center);
        $part_by_wc = $this->process_part_m->get_part_by_wo_exclude($date, $id_dept, $shift, $w_center);
        
        $data['defaultSearch'] = 'back_number';
        $data['date'] = substr($this->uri->segment(4), 6, 2) . "/" . substr($this->uri->segment(4), 4, 2) . "/" . substr($this->uri->segment(4), 0, 4);
        $data['date_l'] = $this->uri->segment(4);
        $data['shift'] = $this->uri->segment(5);
        $data['wcenter_l'] = $this->uri->segment(6);
        $data['set'] = $this->uri->segment(7);
        $data['part_by_wc'] = $part_by_wc;
        $data['parts'] = $parts;
        $data['wcenters'] = $wcenters;
        $data['footer'] = '1';
        $data['masterNg'] = $masterNg;

        //add by toro --  unapprove 2016-12-09
        $data['stat_approve_by_leader'] = $this->prod_result_approval_m->get_stat_approve_by_leader($date, $shift, $w_center);
        $data['role'] = $this->session->userdata('ROLE');

        if (empty($apps)) {
            $data['apps'] = 0;
        } else {
            if ($apps[0]->CHR_FLG_APPROVE_SPV + $apps[0]->CHR_FLG_APPROVE_KADEPT + $apps[0]->CHR_FLG_APPROVE_GM <> 0) {
                $data['apps'] = 1;
            } else {
                $data['apps'] = 0;
            }
        }

        if ($this->input->post('btn_save') != '') {
            $this->_process($this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6));
        }

        // $this->session->userdata('user_id');
        $data['content'] = 'pes_new/entry_ines_v';
        $data['title'] = 'Edit & Approve In Line Scan';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(140);
        $data['news'] = $this->news_m->get_news();

        $this->load->view($this->layout, $data);
    }

    public function recapReject($date = '', $shift = '', $w_center = '', $set = '') {

        $date_now = date('Ymd');
        $time_his = date('H:i:s');
        $user_name = $this->session->userdata('USERNAME');

        if ($date == "" || $shift == "" || $w_center == "" || $set == "") {
            $date = date("Ymd");
            $shift = "1";
            $w_center = $this->db->query("SELECT TOP 1 RTRIM(CHR_WORK_CENTER) CHR_WORK_CENTER FROM TM_INLINE_SCAN GROUP BY CHR_WORK_CENTER ORDER BY CHR_WORK_CENTER ASC")->row()->CHR_WORK_CENTER;
        }

        if ($this->input->post('save') != '') {

            $arr_int_number = $this->input->post('int_number');
            $arr_qty_ng_proses = $this->input->post('qty_ng_proses');
            $arr_qty_ng_btest = $this->input->post('qty_ng_btest');
            $arr_qty_ng_setup = $this->input->post('qty_ng_setup');
            $arr_qty_ng_trial = $this->input->post('qty_ng_trial');

            for ($i = 1; $i <= $this->input->post('i'); $i++) {
                $int_number = $arr_int_number[$i];

                $qty_ng_proses = str_replace(".", "", $arr_qty_ng_proses[$i]);
                $qty_ng_btest = str_replace(".", "", $arr_qty_ng_btest[$i]);
                $qty_ng_setup = str_replace(".", "", $arr_qty_ng_setup[$i]);
                $qty_ng_trial = str_replace(".", "", $arr_qty_ng_trial[$i]);
                $tot_qty_ng = $qty_ng_proses + $qty_ng_btest + $qty_ng_setup + $qty_ng_trial;
               
                if ($tot_qty_ng > 0) {
                    $cek_interface_ng = $this->db->query("SELECT * FROM  TT_PRODUCTION_RESULT WHERE (CHR_STATUS_NG = 'S' OR CHR_STATUS_NG = '5') and INT_NUMBER = '$int_number'");
                    if ($cek_interface_ng->num_rows() > 0) {
                        $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC_REV = INT_NG_PRC, INT_NG_BRKNTEST_REV = INT_NG_BRKNTEST, INT_NG_SETUP_REV = INT_NG_SETUP, INT_NG_TRIAL_REV = INT_NG_TRIAL ,INT_TOTAL_NG_REV = INT_TOTAL_NG, CHR_REVERSE_NG = 'R' , CHR_STATUS_NG = 'R' WHERE INT_NUMBER = $int_number");
                    } 
                    $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_ng_proses, INT_NG_BRKNTEST=$qty_ng_btest, INT_NG_SETUP=$qty_ng_setup, INT_NG_TRIAL=$qty_ng_trial , INT_TOTAL_NG=$tot_qty_ng, CHR_MODIFIED_BY = '$user_name', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_his' WHERE INT_NUMBER=$int_number");
                }
            }
        }

        $data['defaultSearch'] = 'back_number';
        $data['date'] = substr($this->uri->segment(4), 6, 2) . "/" . substr($this->uri->segment(4), 4, 2) . "/" . substr($this->uri->segment(4), 0, 4);
        $data['date_l'] = $this->uri->segment(4);
        $data['shift'] = $this->uri->segment(5);
        $data['wcenter_l'] = $this->uri->segment(6);
        $data['set'] = $this->uri->segment(7);
        $data['part_by_wc'] = $this->process_part_m->getPartByWoExclude($date, $shift, $w_center);
        $data['parts'] = $this->process_part_m->getPartByWo($date, $shift, $w_center);
        $data['wcenters'] = $this->db->query("SELECT RTRIM(CHR_WORK_CENTER) CHR_WORK_CENTER FROM TM_INLINE_SCAN WHERE CHR_WORK_CENTER <> 'OTHER' GROUP BY CHR_WORK_CENTER ORDER BY CHR_WORK_CENTER ASC")->result();
        $data['masterNg'] = $this->ng_m->get_all_ng();

        $data['content'] = 'pes_new/recap_ines_v';
        $data['title'] = 'Recap In Line Scan';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(140);
        $data['news'] = array();

        $this->load->view($this->layout, $data);
    }

    public function addNgProcess() {
        $data = " ";
        $tot_qty_ng = 0;
        $partNo = trim($this->input->post('partNo'));
        $qty = $this->input->post('qty');
        $reason_id = $this->input->post('reason_id');
        $npk = $this->session->userdata('NPK');
        $int_number_ng = $this->input->post('int_number');

        $date_now = date("Ymd");
        $time_now = date("His");

        $cek_prod_res = $this->production_result_m->getProductionById($int_number_ng );

        if($qty > 0){
            $cek_NG_others = $this->db->query("SELECT * FROM TT_NG_OTHER WHERE INT_ID_PRODUCTION_RESULT = $int_number_ng AND CHR_NG_CATEGORY_CODE = '$reason_id'");

            if ($cek_NG_others->num_rows() == 0) {
                $this->db->query("INSERT INTO TT_NG_OTHER (INT_ID_PRODUCTION_RESULT, CHR_NG_CATEGORY_CODE, INT_QTY_NG, CHR_CREATED_BY , CHR_CREATED_DATE , CHR_CREATED_TIME) VALUES ($int_number_ng, '$reason_id', $qty , '$npk' , '$date_now' , '$time_now');");
            } else {
                $this->db->query("UPDATE TT_NG_OTHER SET INT_QTY_NG=$qty , CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now'  WHERE  INT_ID_PRODUCTION_RESULT=$int_number_ng and CHR_NG_CATEGORY_CODE = '$reason_id';");
            }

            $qty_prc = $this->db->query("SELECT SUM(INT_QTY_NG) AS INT_QTY_NG FROM TT_NG_OTHER  WHERE INT_ID_PRODUCTION_RESULT = $int_number_ng ")->row()->INT_QTY_NG;
            $tot_qty_ng = $cek_prod_res->row()->INT_NG_BRKNTEST + $cek_prod_res->row()->INT_NG_SETUP + $cek_prod_res->row()->INT_NG_TRIAL + $qty_prc;

            if ($cek_prod_res->row()->CHR_STATUS_NG == "S" || $cek_prod_res->row()->CHR_STATUS_NG == "5") {
                $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC_REV = INT_NG_PRC, INT_NG_BRKNTEST_REV = INT_NG_BRKNTEST, INT_NG_SETUP_REV = INT_NG_SETUP, INT_NG_TRIAL_REV = INT_NG_TRIAL ,INT_TOTAL_NG_REV = INT_TOTAL_NG, CHR_REVERSE_NG = 'R' , CHR_STATUS_NG = 'R' WHERE INT_NUMBER = $int_number_ng;");
            }

            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_prc, INT_TOTAL_NG=$tot_qty_ng , CHR_MODIFIED_BY = '$npk' , CHR_MODIFIED_DATE = '$date_now' , CHR_MODIFIED_TIME = '$time_now' WHERE  INT_NUMBER=$int_number_ng;");
        }

        $getTableNGOthers = $this->db->query("SELECT TT_NG_OTHER.* , TM_NG.CHR_NG_CATEGORY_CODE , TM_NG.CHR_NG_CATEGORY  from TT_NG_OTHER 
                inner join TM_NG on TT_NG_OTHER.CHR_NG_CATEGORY_CODE = TM_NG.CHR_NG_CATEGORY_CODE
                where (INT_ID_PRODUCTION_RESULT = $int_number_ng) AND TM_NG.CHR_NG_CATEGORY_CODE NOT IN ('NG2' , 'NG3' , 'NG4' ) order by INT_ID_OTHER asc")->result();
        $no = 1;
        $data .= "<thead>
                        <tr>
                            <th style='text-align:center;'>No</th>
                            <th style='text-align:center;'>Reason</th>
                            <th style='text-align:center;'>Qty</th>
                            <th style='text-align:center;'>Option</th>
                        </tr>
                      </thead><tbody>";
        $total_ng = 0;
        foreach ($getTableNGOthers as $valueNGOthers) {
            $total_ng = $valueNGOthers->INT_QTY_NG + $total_ng;
            $data .= "<tr>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$no</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$valueNGOthers->CHR_NG_CATEGORY</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$valueNGOthers->INT_QTY_NG</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;' onclick=\"deleteNG($valueNGOthers->INT_ID_PRODUCTION_RESULT , '$valueNGOthers->CHR_NG_CATEGORY_CODE', '$partNo')\"> <span class='btn bg-red'>Delete</span></td>";
            $data .= "</tr>";
            $no++;
        }
        $data .= "</tbody>";

        echo json_encode(array("a" => $data, "b" => $total_ng));
    }

    public function inputNgProcess() {
        $data = ' ';
        $partNo = trim($this->input->post('partNo'));
        $int_number = $this->input->post('int_number');

        $getTableNGOthers = $this->db->query("SELECT TT_NG_OTHER.* , RTRIM(TM_NG.CHR_NG_CATEGORY_CODE) CHR_NG_CATEGORY_CODE, TM_NG.CHR_NG_CATEGORY  from TT_NG_OTHER 
                INNER JOIN TM_NG 
                ON TT_NG_OTHER.CHR_NG_CATEGORY_CODE = TM_NG.CHR_NG_CATEGORY_CODE
                where (INT_ID_PRODUCTION_RESULT = $int_number) AND TM_NG.CHR_NG_CATEGORY_CODE NOT IN ('NG2' , 'NG3' , 'NG4' )")->result();
        $no = 1;
        $data .= "<thead>
                        <tr>
                            <th style='text-align:center;'>No</th>
                            <th style='text-align:center;'>Reason</th>
                            <th style='text-align:center;'>Qty</th>
                            <th style='text-align:center;'>Option</th>
                        </tr>
                      </thead><tbody>";
        $total_ng = 0;
        foreach ($getTableNGOthers as $valueNGOthers) {
            $total_ng = $valueNGOthers->INT_QTY_NG + $total_ng;
            $data .= "<tr>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$no</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$valueNGOthers->CHR_NG_CATEGORY</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;'>$valueNGOthers->INT_QTY_NG</td>";
            $data .= "<td style='text-align:center;vertical-align: middle;' onclick=\"deleteNG($valueNGOthers->INT_ID_PRODUCTION_RESULT , '$valueNGOthers->CHR_NG_CATEGORY_CODE' , '$partNo')\"> <span class='btn bg-red'>Delete</span></td>";
            $data .= "</tr>";
            $no++;
        }
        $data .= "</tbody>";
        echo json_encode(array("a" => $data, "b" => $total_ng));
    }

    private function _process($date, $shift, $wcenter) {
        date_default_timezone_set("Asia/Jakarta");

        $wo_number = $wcenter . '/' . $date . '/' . 'SHIFT' . $shift;
        $date_now = date('Ymd');
        $monthNow = date("m", strtotime($date));
        $yearNow = date("Y", strtotime($date));
        $time_now = sprintf("%06s", date('His'));
        $cpu_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $npk = $this->session->userdata('NPK');
        $user_name = $this->session->userdata('USERNAME');
        $arr_int_number = $this->input->post('int_number');
        $arr_part_number = $this->input->post('part_number');
        $arr_part_number_hyp = $this->input->post('part_number_hyp');
        $arr_back_number = $this->input->post('back_number');
        $arr_wcenter_form = $this->input->post('wcenter');
        $arr_wcenter_mn = $this->input->post('wcenter_mn');
        $arr_PV = $this->input->post('pv');
        $arr_part_name = $this->input->post('part_name');
        $arr_qty_ok = $this->input->post('qty_ok');
        $arr_qty_ng_proses = $this->input->post('qty_ng_proses');
        $arr_qty_ng_btest = $this->input->post('qty_ng_btest');
        $arr_qty_ng_setup = $this->input->post('qty_ng_setup');
        $arr_qty_ng_trial = $this->input->post('qty_ng_trial');
        $time_his = date('H:i:s');

        for ($i = 1; $i <= $this->input->post('i'); $i++) {
            $part_number = $arr_part_number[$i];
            $part_number_hyp = $arr_part_number_hyp[$i];
            $back_number = $arr_back_number[$i];
            $wcenter_form = $arr_wcenter_form[$i];
            $wcenter_mn = $arr_wcenter_mn[$i];
            $PV = $arr_PV[$i];
            $part_name = $arr_part_name[$i];
            $int_number = $arr_int_number[$i];

            $qty_ok = str_replace(".", "", $arr_qty_ok[$i]);
            $qty_ng_proses = str_replace(".", "", $arr_qty_ng_proses[$i]);
            $qty_ng_btest = str_replace(".", "", $arr_qty_ng_btest[$i]);
            $qty_ng_setup = str_replace(".", "", $arr_qty_ng_setup[$i]);
            $qty_ng_trial = str_replace(".", "", $arr_qty_ng_trial[$i]);

            $cek_prd_res = $this->production_result_m->get_data_by_part($date, $shift, $wcenter, $part_number, $int_number);
            
            // =========================================================== //
            // Add by Ilham Januardy
            // 17.03.2020
            // start
            $validate_pn = $this->prod_result_m->check_phantom($part_number);
            if ($validate_pn == 0) {
                $validate = 'X';
            } else {
                $validate = 'P';
            }
            // end

            if (count($cek_prd_res) == 0) {
                $tot_qty_ng = $qty_ng_proses + $qty_ng_btest + $qty_ng_setup + $qty_ng_trial;

                if ($qty_ok + $qty_ng_proses + $qty_ng_btest + $qty_ng_setup + $qty_ng_trial != 0) {
                    //SAVE HISTORY
                    $data_prod_result = array(
                        'CHR_WO_NUMBER' => $wo_number,
                        'CHR_DATE' => $date,
                        'CHR_PLANT' => '600',
                        'CHR_BACK_NO' => $back_number,
                        'CHR_PART_NO' => $part_number,
                        'CHR_PART_NAME' => $part_name,
                        'CHR_WORK_CENTER' => $wcenter,
                        'INT_BULAN' => $monthNow,
                        'INT_TAHUN' => $yearNow,
                        'CHR_PV' => $PV,
                        'CHR_SHIFT' => $shift,
                        'CHR_WORK_DAY' => '-',
                        'CHR_WORK_TIME_START' => '-',
                        'INT_TOTAL_QTY' => $qty_ok,
                        'CHR_UOM' => 'PC',
                        'CHR_IP' => $cpu_name,
                        'CHR_USER' => $user_name,
                        'INT_NPK' => $npk,
                        'CHR_VALIDATE' => $validate,
                        'CHR_NPK_VALIDATE' => 'SYS',
                        'CHR_IPUP' => '-',
                        'CHR_USERUP' => '-',
                        'CHR_DATE_UPLOAD' => '-',
                        'CHR_TIME_UPLOAD' => '-',
                        'CHR_UPLOAD' => '-',
                        'CHR_STATUS' => '-',
                        'CHR_MESSAGE' => ' ',
                        'CHR_MATDOC' => ' ',
                        'CHR_STATUS_MOBILE' => 'DE',
                        'CHR_REVERSE' => '0',
                        'CHR_DATE_ENTRY' => $date_now,
                        'CHR_TIME_ENTRY' => $time_now,
                        'INT_NG_PRC' => $qty_ng_proses,
                        'INT_NG_BRKNTEST' => $qty_ng_btest,
                        'INT_NG_SETUP' => $qty_ng_setup,
                        'INT_NG_TRIAL' => $qty_ng_trial,
                        'INT_TOTAL_NG' => $tot_qty_ng,
                        'CHR_MODIFIED_BY' => $user_name,
                        'CHR_MODIFIED_DATE' => $date_now,
                        'CHR_MODIFIED_TIME' => $time_his
                    );
                    $this->production_result_m->save_trans($data_prod_result);

                    //SAVE HISTORY
                    $data_history = array(
                        'CHR_DATE' => $date,
                        'CHR_PLANT' => '600',
                        'CHR_BACK_NO' => $back_number,
                        'CHR_PART_NO' => $part_number,
                        'CHR_PART_NAME' => $part_name,
                        'CHR_WORK_CENTER' => $wcenter,
                        'INT_BULAN' => $monthNow,
                        'INT_TAHUN' => $yearNow,
                        'CHR_PV' => $PV,
                        'CHR_SHIFT' => $shift,
                        'INT_TOTAL_QTY' => $qty_ok,
                        'CHR_IP' => $cpu_name,
                        'CHR_USER' => $user_name,
                        'INT_NPK' => $npk,
                        'CHR_DATE_ENTRY' => $date_now,
                        'CHR_TIME_ENTRY' => $time_now,
                        'INT_NG_PRC' => $qty_ng_proses,
                        'INT_NG_BRKNTEST' => $qty_ng_btest,
                        'INT_NG_SETUP' => $qty_ng_setup,
                        'INT_NG_TRIAL' => $qty_ng_trial,
                        'INT_TOTAL_NG' => $tot_qty_ng
                    );
                    $this->production_result_history_m->save($data_history);
                }
            } else {
                if ($qty_ok + $qty_ng_proses + $qty_ng_btest + $qty_ng_setup + $qty_ng_trial != (($cek_prd_res[0]->INT_TOTAL_QTY) + ($cek_prd_res[0]->INT_NG_PRC) + ($cek_prd_res[0]->INT_NG_BRKNTEST) + ($cek_prd_res[0]->INT_NG_SETUP) + ($cek_prd_res[0]->INT_NG_TRIAL))) {
                    //cek untuk production result
                    if ($qty_ok <> $cek_prd_res[0]->INT_TOTAL_QTY) {
                        //cek apakah qty Ok sudah ke interface atau belum??
                        $cek_interface = $this->db->query("SELECT * FROM  TT_PRODUCTION_RESULT WHERE (CHR_DATE = '$date') AND (CHR_SHIFT = '$shift') AND (CHR_WORK_CENTER = '$wcenter') AND (CHR_PART_NO = '$part_number') AND (CHR_STATUS = 'S' OR CHR_STATUS = '5') and INT_NUMBER = '$int_number'")->result();
                        if (count($cek_interface) == 0) {
                            //update langsung
                            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_TOTAL_QTY=$qty_ok, CHR_MODIFIED_BY = '$user_name', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_his' WHERE  INT_NUMBER=$int_number");
                        } else {
                            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_TOTAL_QTY_REV=INT_TOTAL_QTY, CHR_MODIFIED_BY = '$user_name', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_his' WHERE  INT_NUMBER = $int_number");
                            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_TOTAL_QTY=$qty_ok, CHR_REVERSE = 'R' , CHR_STATUS = 'R', CHR_MODIFIED_BY = '$user_name', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_his' WHERE INT_NUMBER=$int_number");
                        }
                    }

                    if ($qty_ng_proses + $qty_ng_btest + $qty_ng_setup + $qty_ng_trial <> ($cek_prd_res[0]->INT_NG_PRC) + ($cek_prd_res[0]->INT_NG_BRKNTEST) + ($cek_prd_res[0]->INT_NG_SETUP) + ($cek_prd_res[0]->INT_NG_TRIAL)) {
                        //cek apakah qty NG sudah ke interface atau belum?
                        $cek_interface_ng = $this->db->query("SELECT * FROM  TT_PRODUCTION_RESULT WHERE (CHR_DATE = '$date') AND (CHR_SHIFT = '$shift') AND (CHR_WORK_CENTER = '$wcenter') AND (CHR_PART_NO = '$part_number') AND (CHR_STATUS_NG = 'S' OR CHR_STATUS_NG = '5') and INT_NUMBER = '$int_number'")->result();
                        $tot_qty_ng = $qty_ng_proses + $qty_ng_btest + $qty_ng_setup + $qty_ng_trial;
                        if (count($cek_interface_ng) == 0) {
                            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_ng_proses, INT_NG_BRKNTEST=$qty_ng_btest, INT_NG_SETUP=$qty_ng_setup, INT_NG_TRIAL=$qty_ng_trial , INT_TOTAL_NG=$tot_qty_ng, CHR_MODIFIED_BY = '$user_name', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_his' WHERE INT_NUMBER=$int_number");
                        } else {
                            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC_REV = INT_NG_PRC, INT_NG_BRKNTEST_REV = INT_NG_BRKNTEST, INT_NG_SETUP_REV = INT_NG_SETUP, INT_NG_TRIAL_REV = INT_NG_TRIAL ,INT_TOTAL_NG_REV = INT_TOTAL_NG, CHR_MODIFIED_BY = '$user_name', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_his' WHERE INT_NUMBER = $int_number");
                            $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_NG_PRC=$qty_ng_proses, INT_NG_BRKNTEST=$qty_ng_btest, INT_NG_SETUP=$qty_ng_setup, INT_NG_TRIAL=$qty_ng_trial, CHR_REVERSE_NG = 'R' , CHR_STATUS_NG = 'R' , INT_TOTAL_NG = $tot_qty_ng, CHR_MODIFIED_BY = '$user_name', CHR_MODIFIED_DATE = '$date_now', CHR_MODIFIED_TIME = '$time_his' WHERE INT_NUMBER=$int_number");
                        }
                    }


                    //add by toro 2016-09-16
                    $tot_qty_ng = $qty_ng_proses + $qty_ng_btest + $qty_ng_setup + $qty_ng_trial;

                    //SAVE HISTORY
                    $data_history = array(
                        'CHR_DATE' => $date,
                        'CHR_PLANT' => '600',
                        'CHR_BACK_NO' => $back_number,
                        'CHR_PART_NO' => $part_number,
                        'CHR_PART_NAME' => $part_name,
                        'CHR_WORK_CENTER' => $wcenter,
                        'INT_BULAN' => $monthNow,
                        'INT_TAHUN' => $yearNow,
                        'CHR_PV' => $PV,
                        'CHR_SHIFT' => $shift,
                        'INT_TOTAL_QTY' => $qty_ok,
                        'CHR_IP' => $cpu_name,
                        'CHR_USER' => $user_name,
                        'INT_NPK' => $npk,
                        'CHR_DATE_ENTRY' => $date_now,
                        'CHR_TIME_ENTRY' => $time_now,
                        'INT_NG_PRC' => $qty_ng_proses,
                        'INT_NG_BRKNTEST' => $qty_ng_btest,
                        'INT_NG_SETUP' => $qty_ng_setup,
                        'INT_NG_TRIAL' => $qty_ng_trial,
                        'INT_TOTAL_NG' => $tot_qty_ng
                    );
                    $this->production_result_history_m->save($data_history);
                }
            }
        }
        redirect('pes_new/inline_scan_c/form/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6) . '/' . $this->uri->segment(7));
    }
    
    private function _redirect_if_not_logged_in() {
        if ($this->session->userdata('role_id') == '') {
            redirect('login/form');
        }
    }

    function add_list_part_by_wc() {
        $back_no = trim($this->input->post('back_no'));
        $work_center = trim($this->input->post('work_center'));
        $date = $this->input->post('date');
        $shift = trim($this->input->post('shift'));
        $set = $this->input->post('set');
        $dandori = 1;
        $shift_type = 'L';

        $data_part = $this->process_part_m->get_data_part_by_back_no($back_no, $work_center);

        $data_production = $this->production_result_m->get_last_prodution($date, $shift, $work_center);
        if($data_production->num_rows() > 0){
            $dandori = $data_production->row()->INT_NG_OTHERS_REV;
            $shift_type = $data_production->row()->CHR_SHIFT_TYPE;
        }

        // =========================================================== //
        // Add by Aditya Nur P
        // 04.05.2021
        // start
        $part_number = trim($data_part->CHR_PART_NO);
        $validate_pn = $this->prod_result_m->check_phantom($part_number);
        if ($validate_pn == 0) {
            $validate = 'X';
        } else {
            $validate = 'P';
        }
        // end

        $data = array(
            'CHR_WO_NUMBER' => $work_center . '/' . $date . '/SHIFT' . $shift,
            'CHR_DATE' => $date,
            'INT_BULAN' => date('n'),
            'INT_TAHUN' => date('Y'),
            'CHR_SHIFT_TYPE' => $shift_type,
            'CHR_SHIFT' => $shift,
            'CHR_PLANT' => '600',
            'CHR_WORK_CENTER' => $work_center,
            'CHR_PV' => $data_part->CHR_PV,
            'CHR_PART_NO' => $data_part->CHR_PART_NO,
            'CHR_BACK_NO' => $back_no,
            'CHR_PART_NAME' => $data_part->CHR_PART_NAME,
            'CHR_UOM' => '-',
            'CHR_DATE_ENTRY' => date('Ymd'),
            'CHR_TIME_ENTRY' => date('His'),
            'CHR_IP' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
            'CHR_USER' => $this->session->userdata('USERNAME'),
            'INT_NPK' => $this->session->userdata('NPK'),
            'CHR_VALIDATE' => $validate,
            'CHR_STATUS_MOBILE' => 'DE',
            'CHR_CREATED_BY' => 'ManualAddPart',
            'INT_NG_OTHERS_REV' => $dandori
        );

        $this->production_result_m->save_trans($data);

        redirect("pes_new/inline_scan_c/form/$date/$shift/$work_center/$set");
    }

    function approve_by_leader() {
        $work_center = trim($this->input->post('work_center'));
        $date = $this->input->post('date');
        $shift = trim($this->input->post('shift'));
        $set = $this->input->post('set');

        $data = array(
            'CHR_WO_NUMBER' => $work_center . '/' . $date . '/SHIFT' . $shift,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center,
            'CHR_CREATE_BY' => $this->session->userdata('USERNAME'),
            'CHR_CREATE_TIME' => date('His'),
            'INT_STAT_LEADER' => 1
        );

        $this->prod_result_approval_m->approve_by_leader($data);

        redirect("pes_new/inline_scan_c/form/$date/$shift/$work_center/$set");
    }

    //Add by toro 2016-12-09
    function unapprove_by_spv() {
        $work_center = trim($this->input->post('work_center'));
        $date = $this->input->post('date');
        $shift = trim($this->input->post('shift'));
        $set = $this->input->post('set');

        $data = array(
            'CHR_WO_NUMBER' => $work_center . '/' . $date . '/SHIFT' . $shift,
            'CHR_DATE' => $date,
            'CHR_SHIFT' => $shift,
            'CHR_WORK_CENTER' => $work_center
        );

        $this->prod_result_approval_m->unapprove_by_spv($data);

        redirect("pes_new/inline_scan_c/form/$date/$shift/$work_center/$set");
    }

    function check_status_interface() {
        $date = trim($this->input->post('date'));
        $shift = trim($this->input->post('shift'));
        $work_center = trim($this->input->post('work_center'));

        $exist = $this->production_result_m->check_status_interface_by_wo($date, $shift, $work_center);

        echo json_encode($exist);
    }

    function save_notes(){

        $id = $this->input->post('id');
        $notes = trim($this->input->post('notes'));
        $ngtype = trim($this->input->post('ngtype'));

        //check id existing
        $ng_existing = $this->production_result_m->check_ng_by_id_production($id, $ngtype);
        if($ng_existing->num_rows() > 0){
            $data = array(
                'INT_NUMBER' => $id,
                'CHR_NOTES' => $notes,
                'CHR_NG_CATEGORY_CODE' => $ngtype,
                'CHR_MODIFIED_BY' => $this->session->userdata('USERNAME')
            );
    
            $this->production_result_m->update_notes($data);
            $error = false;
        }else{
            $data_prd_result = $this->production_result_m->get_data_production($id);

            if($ngtype == 'NG1'){
                $total_ng = $data_prd_result->INT_NG_PRC;
            }else if($ngtype == 'NG2'){
                $total_ng =  $data_prd_result->INT_NG_BRKNTEST;
            }else if($ngtype == 'NG3'){
                $total_ng =  $data_prd_result->INT_NG_SETUP;
            }else{
                $total_ng =  $data_prd_result->INT_NG_TRIAL;
            }
            
            if($total_ng == 0){
                $error = true;
            }else{
                $data = array(
                    'INT_ID_PRODUCTION_RESULT' => $id,
                    'CHR_NOTES' => $notes,
                    'CHR_NG_CATEGORY_CODE' => $ngtype,
                    'INT_QTY_NG' => $total_ng,
                    'CHR_CREATED_BY' => $this->session->userdata('USERNAME')
                );
    
                $this->production_result_m->add_notes($data);
    
                $error = false;
            }

        }

        if ('IS_AJAX') {
            echo json_encode($error);
        }
    }

    function get_notes_by_id(){
        $id = $this->input->post('id');
        $ngtype = trim($this->input->post('ngtype'));

        $data = '';
        $ng_existing = $this->production_result_m->check_ng_by_id_production($id, $ngtype);
        if($ng_existing->num_rows() > 0){
            $data = $ng_existing->row()->CHR_NOTES;
        }

        if ('IS_AJAX') {
            echo json_encode($data);
        }
    }

}
