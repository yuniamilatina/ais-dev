<?php

class production_result_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $tabel = 'TT_PRODUCTION_RESULT';

    function check_phantom($part_no) {
        $query = $this->db->query("SELECT * FROM TM_PHANTOM WHERE CHR_PART_NO = '$part_no'");
        
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    
    function save_trans($data) {
        return $this->db->insert($this->tabel, $data);
    }

    function save_history($data) {
        $work_center = $data['CHR_WORK_CENTER'];
        $wo_no = $data['CHR_WO_NUMBER'];
        $shift = $data['CHR_SHIFT'];
        $date = $data['CHR_DATE'];
        $qty = $data['INT_TOTAL_QTY'];
        $part_no = $data['CHR_PART_NO'];
        $back_no = $data['CHR_BACK_NO'];
        $npk = $data['INT_NPK'];

        $this->db->query("INSERT INTO TT_HISTORY_IN_LINE_SCAN (CHR_WO_NUMBER, INT_QTY_PERSCAN, CHR_PART_NO, CHR_BACK_NO, CHR_DATE, CHR_SHIFT, 
            CHR_WORK_CENTER, CHR_CREATED_BY, CHR_STATUS_DATA)
            VALUES ('$wo_no', $qty, '$part_no', '$back_no', '$date', '$shift', 
                '$work_center', '$npk' , 'CREATE')");
    }

    // function save_display($data) {
    //     $work_center = $data['CHR_WORK_CENTER'];
    //     $qty = $data['INT_TOTAL_QTY'];
    //     $part_no = $data['CHR_PART_NO'];
    //     $part_name = $data['CHR_PART_NAME'];
    //     $back_no = $data['CHR_BACK_NO'];
    //     $npk = $data['INT_NPK'];
    //     $mp = $data['INT_MAN_POWER'];
    //     $ct = $data['INT_CYCLE_TIME'];

    //     $array_user = $this->db->query("SELECT CHR_USERNAME, CHR_CONTACT AS CHR_HP_NO FROM TM_USER WHERE CHR_NPK = '$npk'");

    //     if ($array_user->num_rows() > 0) {
    //         $data_user = $array_user->row_array();
    //         $lastman = $data_user['CHR_USERNAME'];
    //         $contact = $data_user['CHR_HP_NO'];
    //     } else {
    //         $lastman = '';
    //         $contact = '';
    //     }

    //     $db_display = $this->get_db_display($work_center);

    //     $time = date('H:i');

    //     $db_display->query("UPDATE `disp_ops_master` SET
    //     `int_prdcount` = ( int_prdcount + $qty), int_qty_per_box = $qty , 
    //     `int_cycle_time` = $ct,
    //     `chr_part_name` = '$part_name', `chr_pno` = '$part_no', `chr_backno` = '$back_no',
    //     `chr_created_time` = '$time', `chr_npk` = '$npk', `chr_lastman` = '$lastman',
    //     `chr_no_hp` = '$contact', `int_man_power` = $mp
    //     WHERE chr_wcenter = '$work_center' ");
        
    // }
 
    // function save($data) {
    //     $work_center = $data['CHR_WORK_CENTER'];
    //     $wo_no = $data['CHR_WO_NUMBER'];
    //     $shift = $data['CHR_SHIFT'];
    //     $date = $data['CHR_DATE'];
    //     $qty = $data['INT_TOTAL_QTY'];
    //     $part_no = $data['CHR_PART_NO'];
    //     $part_name = $data['CHR_PART_NAME'];
    //     $back_no = $data['CHR_BACK_NO'];
    //     $npk = $data['INT_NPK'];
    //     $mp = $data['INT_MAN_POWER'];

    //     $this->db->query("INSERT INTO TT_HISTORY_IN_LINE_SCAN (CHR_WO_NUMBER, INT_QTY_PERSCAN, CHR_PART_NO, CHR_BACK_NO, CHR_DATE, CHR_SHIFT, 
    //         CHR_WORK_CENTER, CHR_CREATED_BY, CHR_STATUS_DATA)
    //         VALUES ('$wo_no', $qty, '$part_no', '$back_no', '$date', '$shift', 
    //             '$work_center', '$npk' , 'CREATE')");

    //     $array_user = $this->db->query("SELECT CHR_USERNAME, CHR_CONTACT AS CHR_HP_NO FROM TM_USER WHERE CHR_NPK = '$npk'");

    //     if ($array_user->num_rows() > 0) {
    //         $data_user = $array_user->row_array();
    //         $lastman = $data_user['CHR_USERNAME'];
    //         $contact = $data_user['CHR_HP_NO'];
    //     } else {
    //         $lastman = '';
    //         $contact = '';
    //     }

    //     $db_display = $this->get_db_display($work_center);

    //     $time = date('H:i');
    //     $db_display->query("UPDATE `disp_ops_master` SET
    //                 `int_total_pos` = $qty, 
    //                 `int_dandori_standard` = (int_dandori_standard + 1),
    //                 `int_prdcount` = ( int_prdcount + $qty), int_qty_per_box = $qty , 
    //                 `chr_part_name` = '$part_name', `chr_pno` = '$part_no', `chr_backno` = '$back_no',
    //                 `chr_created_time` = '$time', `chr_npk` = '$npk', `chr_lastman` = '$lastman',
    //                 `chr_no_hp` = '$contact', `int_man_power` = $mp
    //                 WHERE chr_wcenter = '$work_center' ");
    // }

    // function update($data) {
    //     //add by BugsMaker 20170412
    //     $wo_no = $data['CHR_WO_NUMBER'];
    //     $qty = $data['INT_QTY_PERSCAN'];
    //     $work_center = $data['CHR_WORK_CENTER'];
    //     $date = $data['CHR_DATE'];
    //     $shift = $data['CHR_SHIFT'];
    //     $back_no = $data['CHR_BACK_NO'];
    //     $int_number_ref = $data['INT_NUMBER_REF'];
    //     $barcode = $data['CHR_BARCODE_KANBAN'];
    //     $time = date('H:i');

    //     $data_history = $this->db->query("SELECT TOP 1 * FROM TT_HISTORY_IN_LINE_SCAN WHERE CHR_WO_NUMBER = '$wo_no' AND CHR_BACK_NO = '$back_no'");

    //     //insert ke history per1scan
    //     if ($data_history->num_rows() > 0) {
    //         $row_history = $data_history->row_array();
    //         $history_part_no = $row_history['CHR_PART_NO'];
    //         $history_created_by = $row_history['CHR_CREATED_BY'];
    //     } else {
    //         $history_part_no = '-';
    //         $history_created_by = '-';
    //     }

    //     $this->db->query("INSERT INTO TT_HISTORY_IN_LINE_SCAN (CHR_WO_NUMBER, INT_QTY_PERSCAN, CHR_PART_NO, CHR_BACK_NO, CHR_DATE, CHR_SHIFT, 
    //         CHR_WORK_CENTER, CHR_CREATED_BY, CHR_BARCODE_KANBAN, INT_NUMBER_REF, CHR_STATUS_DATA)
    //         VALUES ('$wo_no', '$qty', '$history_part_no',
    //             '$back_no', '$date', '$shift', '$work_center', '$history_created_by',
    //             '$barcode', '$int_number_ref', 'UPDATE' )");

    //     $db_display = $this->get_db_display($work_center);

    //     $query_prod = $this->db->query("select ISNULL(SUM(INT_TOTAL_QTY),0) AS INT_TOTAL_QTY from TT_PRODUCTION_RESULT where CHR_WO_NUMBER = '$wo_no' GROUP BY CHR_WO_NUMBER");

    //     if ($query_prod->num_rows() > 0) {
    //         $row_part = $query_prod->row_array();
    //         $total_qty = $row_part['INT_TOTAL_QTY'];
    //     } else {
    //         $total_qty = 0;
    //     }

    //     //Update ke display
    //     $db_display->query("UPDATE `disp_ops_master` SET `int_prdcount` = $total_qty, `chr_created_time` = '$time', `int_flg_panel` = 1 WHERE chr_wcenter = '$work_center' ");
    // }

    // function update_display($work_center, $wo_no, $part_no){ //add 20180703 not used
    //     $db_display = $this->get_db_display($work_center);
    //     $time = date('H:i');

    //     $query_prod = $this->db->query("SELECT ISNULL(SUM(INT_ACTUAL),0) AS INT_TOTAL_QTY from TT_PRODUCTION_RESULT where CHR_WO_NUMBER = '$wo_no' GROUP BY CHR_WO_NUMBER")->row();

    //     $query_prod_per_dandori = $this->db->query("SELECT TOP 1 CHR_WO_NUMBER, CHR_PART_NO, INT_NG_OTHERS_REV  ,
    //             ISNULL(SUM(INT_TOTAL_QTY),0) AS INT_QTY_PERPART, 
    //             ISNULL(SUM(INT_TOTAL_NG),0) AS INT_NG_PERPART
    //             FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo_no' AND CHR_PART_NO = '$part_no'
    //             GROUP BY CHR_WO_NUMBER, CHR_PART_NO, INT_NG_OTHERS_REV
    //             ORDER BY CONVERT(INT,INT_NG_OTHERS_REV) DESC");

    //     if ($query_prod_per_dandori->num_rows() > 0) {
    //         $qty = $query_prod_per_dandori->row()->INT_QTY_PERPART;
    //         $dandori =$query_prod_per_dandori->row()->INT_NG_OTHERS_REV;
    //     } else {
    //         $dandori = 0;
    //         $qty = 0;
    //     }

    //     //Update ke display //add 20180703 add param part_no
    //     $db_display->query("UPDATE `disp_ops_master` SET `int_prdcount` = $query_prod->INT_TOTAL_QTY, `chr_created_time` = '$time', `int_flg_panel` = 1 , 
    //             `int_total_pos` = $qty, 
    //             `int_dandori_standard` = $dandori
    //             WHERE chr_wcenter = '$work_center' ");
    // }

    // function update_master_display($work_center, $wo_no, $part_no){ //add 20180703 add param part_no
    //     $db_display = $this->get_db_display($work_center);
    //     $time = date('H:i');

    //     $query_prod = $this->db->query("SELECT ISNULL(SUM(INT_ACTUAL),0) AS INT_TOTAL_QTY from TT_PRODUCTION_RESULT where CHR_WO_NUMBER = '$wo_no' GROUP BY CHR_WO_NUMBER")->row();

    //     $query_prod_per_dandori = $this->db->query("SELECT TOP 1 CHR_WO_NUMBER, CHR_PART_NO, INT_NG_OTHERS_REV  ,
    //             ISNULL(SUM(INT_TOTAL_QTY),0) AS INT_QTY_PERPART, 
    //             ISNULL(SUM(INT_TOTAL_NG),0) AS INT_NG_PERPART
    //             FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo_no' AND CHR_PART_NO = '$part_no'
    //             GROUP BY CHR_WO_NUMBER, CHR_PART_NO, INT_NG_OTHERS_REV
    //             ORDER BY CONVERT(INT,INT_NG_OTHERS_REV) DESC");

    //     if ($query_prod_per_dandori->num_rows() > 0) {
    //         $qty = $query_prod_per_dandori->row()->INT_QTY_PERPART;
    //         $dandori =$query_prod_per_dandori->row()->INT_NG_OTHERS_REV;
    //     } else {
    //         $dandori = 0;
    //         $qty = 0;
    //     }

    //     //Update ke display //add 20180703 add param part_no
    //     $db_display->query("UPDATE `disp_ops_master` SET `int_prdcount` = $query_prod->INT_TOTAL_QTY, `chr_created_time` = '$time', `int_flg_panel` = 1 , 
    //             `int_total_pos` = $qty, 
    //             `int_dandori_standard` = $dandori
    //             WHERE chr_wcenter = '$work_center' ");
    // }

    function insert_history($data) {
        //add by BugsMaker 20170412
        $wo_no = $data['CHR_WO_NUMBER'];
        $qty = $data['INT_QTY_PERSCAN'];
        $work_center = $data['CHR_WORK_CENTER'];
        $date = $data['CHR_DATE'];
        $shift = $data['CHR_SHIFT'];
        $back_no = $data['CHR_BACK_NO'];
        $int_number_ref = $data['INT_NUMBER_REF'];
        $barcode = $data['CHR_BARCODE_KANBAN'];
        $time = date('H:i');

        $data_history = $this->db->query("SELECT TOP 1 * FROM TT_HISTORY_IN_LINE_SCAN WHERE CHR_WO_NUMBER = '$wo_no' AND CHR_BACK_NO = '$back_no'");

        //insert ke history per1scan
        if ($data_history->num_rows() > 0) {
            $row_history = $data_history->row_array();
            $history_part_no = $row_history['CHR_PART_NO'];
            $history_created_by = $row_history['CHR_CREATED_BY'];
        } else {
            $history_part_no = '-';
            $history_created_by = '-';
        }

        $this->db->query("INSERT INTO TT_HISTORY_IN_LINE_SCAN (CHR_WO_NUMBER, INT_QTY_PERSCAN, CHR_PART_NO, CHR_BACK_NO, CHR_DATE, CHR_SHIFT, 
            CHR_WORK_CENTER, CHR_CREATED_BY, CHR_BARCODE_KANBAN, INT_NUMBER_REF, CHR_STATUS_DATA)
            VALUES ('$wo_no', '$qty', '$history_part_no',
                '$back_no', '$date', '$shift', '$work_center', '$history_created_by',
                '$barcode', '$int_number_ref', 'UPDATE' )");

    }

    function update_production_result($data, $id, $ip, $wo_number) {
        $actual = $data['INT_ACTUAL'];
        $total = $data['INT_TOTAL_QTY'];
        $qty_ok = $data['INT_ACTUAL'];

        $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_TOTAL_QTY = (INT_TOTAL_QTY + $total), INT_QTY_OK = (INT_QTY_OK + $qty_ok), INT_ACTUAL = (INT_ACTUAL + $actual) WHERE INT_NUMBER = $id AND CHR_IP = '$ip'");

        return $this->db->query("SELECT TOP 1 INT_NG_OTHERS_REV , SUM(INT_TOTAL_QTY) INT_TOTAL_QTY 
        FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo_number'
        GROUP BY INT_NG_OTHERS_REV
        ORDER BY CONVERT(INT,INT_NG_OTHERS_REV) DESC")->row();
    }

    //edited by bugsmaker 20180521
    function get_total_per_dandori($part_no, $wo_number){

        //add by bugsMaker 20180725
        $stored_procedure = "EXEC PRD.zsp_get_dandori_actual_total_qty_by_wo ?";
        $param = array(
            'wo_number' => $wo_number
        );
        return $this->db->query($stored_procedure, $param)->row();
    }

    //add by BugsMaker 20170612
    function update_production_result_ng($data, $id, $ip) {
        $total_ng = $data['INT_TOTAL_NG'];
//        $actual = $data['INT_ACTUAL'];
        $ng_prc = $data['INT_NG_PRC'];
        $ng_setup = $data['INT_NG_SETUP'];
        $ng_brkntest = $data['INT_NG_BRKNTEST'];
        $ng_trial = $data['INT_NG_TRIAL'];
        $date = date('Ymd');
        $time = date('His');

        //add by BugsMaker 20170612
        $ng_category = $data['NG_CODE'];
        $this->db->query("INSERT INTO TT_NG_OTHER (INT_ID_PRODUCTION_RESULT, CHR_NG_CATEGORY_CODE, INT_QTY_NG, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME )
        VALUES ('$id', '$ng_category', '$total_ng', 'system', '$date', '$time' )");

        return $this->db->query("UPDATE TT_PRODUCTION_RESULT SET
                INT_NG_PRC = $ng_prc,
                INT_NG_SETUP = $ng_setup,
                INT_NG_BRKNTEST = $ng_brkntest,
                INT_NG_TRIAL = $ng_trial,
                INT_TOTAL_NG =  (INT_TOTAL_NG + $total_ng)
                WHERE INT_NUMBER = $id AND CHR_IP = '$ip'");
    }

    function check_ng_by_id_production($id, $ng_category){
        return $this->db->query("SELECT TOP 1 * FROM TT_NG_OTHER  WHERE INT_ID_PRODUCTION_RESULT = $id AND CHR_NG_CATEGORY_CODE = '$ng_category' AND INT_QTY_NG <> 0");
    }

    function check_ng_by_wo_and_part($workcenter, $date, $shift, $partno, $ng_category){
        return $this->db->query("SELECT TOP 1 * FROM TT_NG_OTHER 
        WHERE CHR_NG_CATEGORY_CODE = '$ng_category' 
        AND INT_ID_PRODUCTION_RESULT IN ( SELECT TOP 1 INT_NUMBER FROM TT_PRODUCTION_RESULT 
        WHERE CHR_WORK_CENTER = '$workcenter' AND CHR_DATE = '$date' AND CHR_SHIFT = '$shift' AND CHR_PART_NO = '$partno')");
    }

    function get_data_production_by_wo($workcenter, $date, $shift, $partno){
        $data = $this->db->query("SELECT TOP 1 * FROM TT_PRODUCTION_RESULT 
        WHERE CHR_WORK_CENTER = '$workcenter' AND CHR_DATE = '$date' AND CHR_SHIFT = '$shift' AND CHR_PART_NO = '$partno' ");
        
        if($data->num_rows() > 0){
            return $data->row();
        }else{
            return false;
        }
    }

    function update_notes($data){

        $date = date('Ymd');
        $time = date('His');
        $id = $data['INT_NUMBER'];
        $notes = $data['CHR_NOTES'];
        $ng_category = $data['CHR_NG_CATEGORY_CODE'];
        $user = $data['CHR_MODIFIED_BY'];

        return $this->db->query("UPDATE TT_NG_OTHER SET CHR_NOTES = '$notes', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', CHR_MODIFIED_TIME = '$time'
        WHERE INT_ID_PRODUCTION_RESULT = $id AND CHR_NG_CATEGORY_CODE = '$ng_category'");
    }

    function add_notes($data){

        $id = $data['INT_ID_PRODUCTION_RESULT'];
        $notes = $data['CHR_NOTES'];
        $ng_category = $data['CHR_NG_CATEGORY_CODE'];
        $total_ng = $data['INT_QTY_NG'];
        $user = $data['CHR_CREATED_BY'];
        $date = date('Ymd');
        $time = date('His');

        $this->db->query("INSERT INTO TT_NG_OTHER 
        (INT_ID_PRODUCTION_RESULT, CHR_NG_CATEGORY_CODE, INT_QTY_NG, CHR_NOTES, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, CHR_MODIFIED_BY, CHR_MODIFIED_DATE, CHR_MODIFIED_TIME )
        VALUES ('$id', '$ng_category', '$total_ng', '$notes', '$user', '$date', '$time', '$user', '$date', '$time' )");
    }

    function get_id_production($work_order, $back_no) {
        $data = $this->db->query("SELECT TOP 1 * FROM TT_PRODUCTION_RESULT
                WHERE CHR_WO_NUMBER = '$work_order' 
                AND CHR_STATUS_MOBILE = 'I'
                AND CHR_BACK_NO = '$back_no'
                ORDER BY INT_NUMBER DESC")->row();

        return $data;
    }

    function get_id_production_display($work_order, $back_no){
        $data = $this->db->query("SELECT TOP 1 * FROM TT_PRODUCTION_RESULT
                WHERE CHR_WO_NUMBER = '$work_order' 
                AND CHR_STATUS_MOBILE = 'I'
                AND CHR_BACK_NO = '$back_no'
                AND CHR_IP <> 'DB-ID03'
                ORDER BY INT_NUMBER DESC")->row();

        return $data;
    }

    //add by BugsMaker 20170612
    function get_data_production($id) {
        $data = $this->db->query("SELECT * FROM TT_PRODUCTION_RESULT
                WHERE INT_NUMBER = $id")->row();

        return $data;
    }

    function getProductionById($id) {
        return $this->db->query("SELECT *, INT_NG_PRC + INT_NG_BRKNTEST  + INT_NG_SETUP + INT_NG_TRIAL AS TOTAL_NG FROM TT_PRODUCTION_RESULT WHERE INT_NUMBER = $id");
    }

    function get_kanban_qty($backno, $type_kanban, $kanban_no, $serial) {
        $exist = $this->db->query("SELECT TOP 1 INT_QTY_PER_BOX FROM TM_KANBAN_SERIAL WHERE INT_KANBAN_NO = $kanban_no AND INT_NUM_SERIAL = $serial");

        if ($exist->num_rows() > 0) {
            $row = $exist->row_array();
            return $row['INT_QTY_PER_BOX'];
        } else {
            $kanban_master = $this->db->query("SELECT TOP 1 INT_QTY_PER_BOX FROM TM_KANBAN WHERE CHR_BACK_NO = '$backno' AND CHR_KANBAN_TYPE = $type_kanban");
            if ($kanban_master->num_rows() > 0) {
                $row = $kanban_master->row_array();
                return $row['INT_QTY_PER_BOX'];
            } else {
                return 1;
            }
        }
    }

    //2017-01-07 add by BugsMaker
    function cek_exist_data($data) {
        $wo_no = $data['CHR_WO_NUMBER'];
        $ip = $data['CHR_IP'];
        $date_entry = $data['CHR_DATE_ENTRY'];
        $time_entry = $data['CHR_TIME_ENTRY'];
        $back_no = $data['CHR_BACK_NO'];
        $npk = $data['INT_NPK'];

        $exist = $this->db->query("SELECT TOP 1 * FROM TT_PRODUCTION_RESULT 
                                    WHERE CHR_WO_NUMBER = '$wo_no' 
                                    AND CHR_BACK_NO = '$back_no'
                                    AND CHR_DATE_ENTRY = '$date_entry'
                                    AND CHR_TIME_ENTRY = '$time_entry' 
                                    AND INT_NPK = '$npk'
                                    AND CHR_IP = '$ip'");

        if ($exist->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    //Add By BugsMaker 2017 01 20
    function activating_printing($work_center, $partno, $ip) {
        $date_entry = date('Ymd');
        $time_entry = date('His');

        // $db_timbangan = $this->get_db_timbangan($ip);
        // $db_timbangan->query("UPDATE tm_timbangan_status SET INT_FLG_PRINT = 1 WHERE INT_ID = 1 ");

        $this->db->query("INSERT INTO PRD.TT_REPRINT_LABEL 
            (CHR_WO_NUMBER, CHR_PART_NO, CHR_WORK_CENTER, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME)
            VALUES 
            ('lihat core', '$partno', '$work_center', '$ip', '$date_entry', '$time_entry' )");
    }


    function get_all_history_dandory($wo) {
        return $this->db->query("SELECT CONVERT(INT, INT_NG_OTHERS_REV) SEQ, 
        '<button class=button-prod value='+ CHR_BACK_NO + '><span style=font-weight:300>'+ CHR_BACK_NO+'</span> '+ CONVERT(VARCHAR(10),SUM(INT_TOTAL_QTY)) + ' </button>' CHR_BACK_NO
            FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo'
            GROUP BY CONVERT(INT, INT_NG_OTHERS_REV), CHR_BACK_NO
            ORDER BY CONVERT(INT, INT_NG_OTHERS_REV) ASC
        ");
    }

    function get_detail_kanban($no_kanban, $serial, $tipe) {
        //add by bugsMaker 20171206
        $stored_procedure = "EXEC PRD.zsp_get_detail_kanban_by_barcode ?, ?, ?";
        $param = array(
            'no_kanban' => $no_kanban,
            'serial' => $serial,
            'tipe' => $tipe
        );
        return $this->db->query($stored_procedure, $param);
    }

     //20180731
    function get_sequence_dandori_by_wo($wo){
        return $this->db->query("SELECT TOP 1 ISNULL(INT_NG_OTHERS_REV,0) + 1 AS INT_NG_OTHERS_REV FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo' ORDER BY CHR_CREATED_DATE DESC, CHR_CREATED_TIME DESC");
    }

    //20180731
    function get_current_day() {
        $day['Sunday'] = 'MINGGU';
        $day['Monday'] = 'SENIN';
        $day['Tuesday'] = 'SELASA';
        $day['Wednesday'] = 'RABU';
        $day['Thursday'] = 'KAMIS';
        $day['Friday'] = 'JUMAT';
        $day['Saturday'] = 'SABTU';

        return $day[date("l")];
    }

    //add by BugsMaker 27-09-2016
    function get_total_actual_by_shift($wo) {
        $query = $this->db->query("select ISNULL(SUM(INT_TOTAL_QTY),0) AS INT_TOTAL_QTY, ISNULL(SUM(INT_TOTAL_NG),0) AS INT_TOTAL_NG from TT_PRODUCTION_RESULT where CHR_WO_NUMBER = '$wo' GROUP BY CHR_WO_NUMBER");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function get_npk($npk) {
        $query = $this->db->query("SELECT 1 FROM TM_USER WHERE CHR_NPK = '$npk'");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

     //add by BugsMaker 18-10-2016
     function get_total_dandori_by_wo($wo) {
        $query = $this->db->query("SELECT TOP 1 INT_NG_OTHERS_REV AS TOTAL_ROW  from TT_PRODUCTION_RESULT 
            where CHR_WO_NUMBER = '$wo' ORDER BY INT_NUMBER DESC");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    //add by BugsMaker 08-11-2017
    function get_detail_part($part_no) {
        $query = $this->db->query("SELECT TOP 1 * FROM TM_PARTS P
                INNER JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO WHERE P.CHR_PART_NO = '$part_no' ");

        return $query;
    }

    //add by BugsMaker 04-04-2018
    function get_detail_part_cavity($part_no){
        $query = $this->db->query("SELECT TOP 1 * FROM TM_PARTS P
        INNER JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO WHERE P.CHR_PART_NO = '$part_no' ");

        return $query;
    }

    function start_production($wo_number) {
        $shift = substr(trim($wo_number), -1);
        $date = substr(trim($wo_number), -15, 8);
        $work_center = substr(trim($wo_number), 0, -16);
        $date = date('Ymd');
        $time = date('His');

        $this->db->query("INSERT INTO PRD.TM_PRODUCTION_ACTIVITY (INT_SHIFT, CHR_WORK_CENTER, CHR_DATE, CHR_WO_NUMBER, CHR_CREATED_DATE, CHR_CREATED_TIME) 
        VALUES ('$shift','$work_center','$date','$wo_number', '$date', '$time')");
    }

    function stop_production($wo_number) {
        $date = date('Ymd');
        $time = date('His');

        $stored_procedure = "EXEC PRD.zsp_stop_and_summarize_production ?, ?, ?";

        $param = array(
            'wo_number' => $wo_number,
            'date' => $date,
            'time' => $time
        );

        $this->db->query($stored_procedure, $param);
    }

    function check_status_interface_by_wo($date, $shift, $work_center){
        $query = $this->db->query("SELECT * FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '$date' AND CHR_SHIFT = '$shift' AND CHR_WORK_CENTER = '$work_center' AND (CHR_STATUS = '5' or CHR_STATUS_NG = '5')");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_data_by_part($date, $shift, $wcenter, $part_number, $int_number) {
        $query = $this->db->query("SELECT INT_NUMBER, CHR_WO_NUMBER, CHR_DATE, CHR_PLANT, CHR_BACK_NO, CHR_PART_NO, CHR_PART_NAME, CHR_WORK_CENTER, INT_BULAN, 
                      INT_TAHUN, CHR_PV, CHR_TYPE, CHR_SHIFT, CHR_WORK_DAY, CHR_WORK_TIME_START, INT_MP, INT_TARGET, INT_ACTUAL, INT_QTY_OK, INT_TOTAL_QTY, 
                      CHR_UOM, INT_CHOKOTEI, CHR_IP, CHR_USER, INT_NPK, CHR_VALIDATE, CHR_NPK_VALIDATE, CHR_IPUP, CHR_USERUP, CHR_DATE_UPLOAD, 
                      CHR_TIME_UPLOAD, CHR_UPLOAD, CHR_STATUS, CHR_MESSAGE, CHR_MATDOC, CHR_STATUS_MOBILE, CHR_UPDATE_REPAIR, INT_NUMBER_REVERSED, 
                      CHR_PROCESS_PROD_COUNTER, CHR_REVERSE, CHR_COMPLETE, INT_QTY_PLAN, CHR_DATE_ENTRY, CHR_TIME_ENTRY, INT_NG_PRC, INT_NG_BRKNTEST, 
                      INT_NG_SETUP, INT_NG_TRIAL
                      FROM         TT_PRODUCTION_RESULT
                      WHERE     (CHR_DATE = '$date') AND (CHR_SHIFT = '$shift') AND (CHR_WORK_CENTER = '$wcenter') AND (CHR_PART_NO = '$part_number') and INT_NUMBER = '$int_number'");

        return $query->result();
    }

    function get_last_prodution($date, $shift, $work_center){
        $query = $this->db->query("SELECT TOP 1 * FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '$date' AND CHR_SHIFT = '$shift' AND CHR_WORK_CENTER = '$work_center' ORDER BY INT_NUMBER DESC");

        return $query;
    }

    

}
