<?php

class prod_result_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $tabel = 'TT_PRODUCTION_RESULT';

    function check_phantom($part_no) {
        $query = $this->db->query("SELECT * FROM TM_PHANTOM WHERE CHR_PART_NO = '$part_no' AND INT_FLG_DEL = '0'");
        
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    
    function save_trans($data) {
        $this->db->insert($this->tabel, $data);
        return $this->db->insert_id();
    }
    
    function update_production_result($data, $id, $ip, $wo_number) {
        $actual = $data['INT_ACTUAL'];
        $total = $data['INT_TOTAL_QTY'];
        $qty_ok = $data['INT_ACTUAL'];

        $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_TOTAL_QTY = (INT_TOTAL_QTY + $total), INT_QTY_OK = (INT_QTY_OK + $qty_ok), INT_ACTUAL = (INT_ACTUAL + $actual) WHERE INT_NUMBER = $id AND CHR_IP = '$ip'");
    }
        
    function updateProductionResult($qty_box, $id) {
        $this->db->query("UPDATE TT_PRODUCTION_RESULT SET INT_TOTAL_QTY = (INT_TOTAL_QTY + $qty_box), INT_QTY_OK = (INT_QTY_OK + $qty_box), INT_ACTUAL = (INT_ACTUAL + $qty_box) WHERE INT_NUMBER = $id");
    }

    function get_total_per_dandori($part_no, $wo_number){

        $stored_procedure = "EXEC PRD.zsp_get_dandori_actual_total_qty_by_wo ?";
        $param = array(
            'wo_number' => $wo_number
        );
        return $this->db->query($stored_procedure, $param)->row();
    }

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

    function get_auto_data_production($work_order, $back_no) {
        $data = $this->db->query("SELECT TOP 1 * FROM TT_PRODUCTION_RESULT
                WHERE CHR_WO_NUMBER = '$work_order' 
                AND CHR_STATUS_MOBILE = 'I'
                AND CHR_BACK_NO = '$back_no'
                ORDER BY INT_NUMBER DESC")->row();

        return $data;
    }

    function get_manual_data_production($work_order, $back_no){
        $data = $this->db->query("SELECT TOP 1 * FROM TT_PRODUCTION_RESULT
                WHERE CHR_WO_NUMBER = '$work_order' 
                AND CHR_STATUS_MOBILE = 'I'
                AND CHR_BACK_NO = '$back_no'
                AND CHR_IP <> 'DB-ID03'
                ORDER BY INT_NUMBER DESC")->row();

        return $data;
    }

    function get_id_production($work_order, $back_no){
        $data = $this->db->query("SELECT TOP 1 INT_NUMBER FROM TT_PRODUCTION_RESULT
                WHERE CHR_WO_NUMBER = '$work_order' 
                AND CHR_STATUS_MOBILE = 'I'
                AND CHR_BACK_NO = '$back_no'
                AND CHR_IP <> 'DB-ID03'
                ORDER BY INT_NUMBER DESC")->row();

        return $data->INT_NUMBER;
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

    function save_history_reprint($wo_number, $work_center, $partno, $username) {
        $date_entry = date('Ymd');
        $time_entry = date('His');

        $this->db->query("INSERT INTO PRD.TT_REPRINT_LABEL 
            (CHR_WO_NUMBER, CHR_PART_NO, CHR_WORK_CENTER, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME)
            VALUES 
            ('$wo_number', '$partno', '$work_center', '$username', '$date_entry', '$time_entry' )");
    }

    function get_all_history_dandory($wo) {
        return $this->db->query(";WITH CTE ( INT_NUMBER, CHR_BACK_NO, INT_DANDORI ) AS (
            SELECT TOP 1 INT_NUMBER, CHR_BACK_NO, INT_NG_OTHERS_REV FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo' 
            ORDER BY INT_NUMBER DESC
        )
        
        SELECT CONVERT(INT, PR.INT_DANDORI) SEQ, 
        '<button onclick=history_prdorder_no('''+ CONVERT(VARCHAR(200), H.CHR_WO_NUMBER) +''') class=button-prod style=width:160px value='''+ PR.CHR_BACK_NO + '''><div style=font-weight:300>'+ PR.CHR_BACK_NO+'</div> </button>' CHR_BACK_NO
            FROM CTE PR 
            INNER JOIN TT_HISTORY_IN_LINE_SCAN H 
            ON 
            CONVERT(INT, PR.INT_DANDORI) = H.INT_DANDORI AND CHR_WO_NUMBER = '$wo' 
            WHERE 
            H.CHR_STATUS_DATA = 'CREATE'
            GROUP BY CONVERT(INT, PR.INT_DANDORI), PR.CHR_BACK_NO, H.CHR_WO_NUMBER
            ORDER BY CONVERT(INT, PR.INT_DANDORI) ASC");
    }

    function get_detail_kanban($no_kanban, $serial, $tipe) {
        $stored_procedure = "EXEC PRD.zsp_get_detail_kanban_by_barcode ?, ?, ?";
        $param = array(
            'no_kanban' => $no_kanban,
            'serial' => $serial,
            'tipe' => $tipe
        );
        return $this->db->query($stored_procedure, $param);
    }

    function get_sequence_dandori_by_wo($wo){
        return $this->db->query("SELECT TOP 1 ISNULL(INT_NG_OTHERS_REV,0) + 1 AS INT_NG_OTHERS_REV FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo' ORDER BY CAST(INT_NG_OTHERS_REV AS INT) DESC");
    }

    function get_sequence_by_wo($wo){
        $query = $this->db->query("SELECT TOP 1 ISNULL(INT_NG_OTHERS_REV,0) + 1 AS INT_NG_OTHERS_REV FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo' ORDER BY CAST(INT_NG_OTHERS_REV AS INT) DESC");
    
        if ($query->num_rows() > 0) {
            return $query->row()->INT_NG_OTHERS_REV; 
        } else {
            return 1;
        }

    }

    function get_data_production_by_wo($wo){
        return $this->db->query("SELECT ISNULL(SUM(INT_TOTAL_QTY),0) AS INT_TOTAL_QTY from TT_PRODUCTION_RESULT where CHR_WO_NUMBER = '$wo' GROUP BY CHR_WO_NUMBER")->row();
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
        $query = $this->db->query("SELECT ISNULL(SUM(INT_TOTAL_QTY),0) AS INT_TOTAL_QTY, ISNULL(SUM(INT_TOTAL_NG),0) AS INT_TOTAL_NG from TT_PRODUCTION_RESULT where CHR_WO_NUMBER = '$wo' GROUP BY CHR_WO_NUMBER");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    //add by BugsMaker 11-10-2016
    function get_all_history_by_wc_and_shift_and_date($wo) {
        $stored_procedure = "EXEC PRD.zsp_get_top_ten_latest_inline_scan ?";
        $param = array('wo' => $wo);
        $query = $this->db->query($stored_procedure, $param);

        return $query;
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

    //add by BugsMaker 14-10-2016
    function update_flag_is_finished($wo) {
        $stored_procedure = "EXEC PRD.zsp_update_flag_x_for_finished_prod ?";
        $param = array('wo' => $wo);
        $this->db->query($stored_procedure, $param);
    }

    //add by BugsMaker 20180420
    function update_flag_is_finished_cavity($wo) {
        $stored_procedure = "EXEC PRD.zsp_update_flag_x_for_finished_prod_cavity ?";
        $param = array('wo' => $wo);
        $this->db->query($stored_procedure, $param);
    }

    //add by BugsMaker 02-11-2016
    function update_flag_by_work_center($wc) {
        $stored_procedure = "EXEC PRD.zsp_update_flag_x_for_all ?";
        $param = array('wc' => $wc);
        $this->db->query($stored_procedure, $param);
    }

    //add by BugsMaker 20180420
    function update_flag_by_work_center_cavity($wc) {
        $stored_procedure = "EXEC PRD.zsp_update_flag_x_for_all_cavity ?";
        $param = array('wc' => $wc);
        $this->db->query($stored_procedure, $param);
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

    function get_total_reject($wo_number){
        $query = $this->db->query("SELECT SUM(INT_TOTAL_NG) INT_TOTAL_NG FROM TT_PRODUCTION_RESULT WHERE CHR_WO_NUMBER = '$wo_number' ")->row();

        return $query->INT_TOTAL_NG;
    }

    function start_production($wo_number, $flag_shift) {
        $shift = substr(trim($wo_number), -1);
        $date = substr(trim($wo_number), -15, 8);
        $work_center = substr(trim($wo_number), 0, -16);
        $datenow = date('Ymd');
        $timenow = date('His');

        //select by date and shift
        $data_exist = $this->db->query("SELECT * FROM PRD.TM_PRODUCTION_ACTIVITY WHERE CHR_WORK_CENTER = '$work_center' AND CHR_DATE = '$date' AND INT_SHIFT = '$shift'");
        if ($data_exist->num_rows() > 0) {
            $this->db->query("UPDATE PRD.TM_PRODUCTION_ACTIVITY SET CHR_CREATED_DATE = '$datenow', CHR_CREATED_TIME = '$timenow' , INT_FLG_SHIFT = '$flag_shift' WHERE CHR_WORK_CENTER = '$work_center' AND CHR_DATE = '$date' AND INT_SHIFT = '$shift' ");
        } else {
            $this->db->query("INSERT INTO PRD.TM_PRODUCTION_ACTIVITY (INT_SHIFT, CHR_WORK_CENTER, CHR_DATE, INT_FLG_SHIFT, CHR_WO_NUMBER, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME) 
            VALUES ('$shift','$work_center','$date','$flag_shift','$wo_number', '0', '$datenow', '$timenow')");
        }

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

    //delete soon
    function insert_display_to_server($chr_doc_id, $int_prdplan, $int_plan_tt, $int_prdtarget) {

        $date = date('Ymd');
        $time = date('His');
        $total = $this->db->query("SELECT ISNULL(SUM(INT_TOTAL_QTY),0) AS INT_TOTAL_QTY from TT_PRODUCTION_RESULT where CHR_WO_NUMBER = '$chr_doc_id' GROUP BY CHR_WO_NUMBER");
    
        $actual_total = 0;

        if($total->num_rows() > 0){
            $actual_total = $total->row()->INT_TOTAL_QTY;
        }

        $query = $this->db->query("UPDATE PRD.TM_PRODUCTION_ACTIVITY SET 
        INT_ACTUAL = '$actual_total',
        INT_PLAN_CT = '$int_prdplan',
        INT_PLAN_TT = '$int_plan_tt',
        INT_TARGET = '$int_prdtarget',
        CHR_MODIFIED_BY = '5',
        CHR_MODIFIED_DATE = '$date',
        CHR_MODIFIED_TIME = '$time'
        WHERE CHR_WO_NUMBER = '$chr_doc_id' ");

        return $query;
    }

    //delete soon
    function insert_plan_display_to_server($wo_number, $plan_ct, $plan_tt, $total) {
        $query = $this->db->query("UPDATE PRD.TM_PRODUCTION_ACTIVITY SET  INT_ACTUAL = '$total', INT_PLAN_CT = '$plan_ct' WHERE  CHR_WO_NUMBER = '$wo_number' ");
        return $query;
    }

}
