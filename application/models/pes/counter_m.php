<?php

class counter_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getDetailKanban($code, $serial, $tipe) {
        $sql = "SELECT a.CHR_KANBAN_TYPE, a.INT_KANBAN_NO, a.CHR_SLOC_TO, c.CHR_PART_NAME, a.CHR_PART_NO, a.CHR_BACK_NO, 
                a.CHR_WORK_CENTER, b.INT_NUM_SERIAL, b.INT_QTY_PER_BOX
                FROM TM_KANBAN a LEFT JOIN TM_KANBAN_SERIAL b
                ON a.INT_KANBAN_NO=b.INT_KANBAN_NO
                LEFT JOIN TM_PARTS c ON a.CHR_PART_NO=c.CHR_PART_NO 
                WHERE a.INT_KANBAN_NO=$code AND b.INT_NUM_SERIAL=$serial AND a.CHR_KANBAN_TYPE='$tipe'";

        return $this->db->query($sql);
    }

    function getEstimate($wc) {
        $sql = "SELECT TOP(1) INT_CT FROM TM_TARGET_PRODUCTION a, TT_PRODUCTION_WO b
                WHERE a.CHR_WORK_CENTER=b.CHR_WORK_CENTER AND a.INT_TAHUN=" . date('Y') . " AND a.INT_BULAN=" . date('m') . " 
                AND b.CHR_WORK_CENTER='" . $wc . "' AND a.CHR_FLAG_DELETE IS NULL";
        return $this->db->query($sql);
    }

    function get_production_wo($keyword, $wc) {
        $now = date('Ymd');
        $yes = date('Ymd', strtotime("-1 days"));

        $sql = "SELECT TOP 10 * FROM (SELECT DISTINCT(CHR_WO_NUMBER) FROM TT_PRODUCTION_WO  
                WHERE CHR_STATUS IS NULL AND CHR_WO_NUMBER LIKE '$keyword%'
                AND CHR_DATE IN ('$now ','$yes')) TT_PRODUCTION_WO";

        return $this->db->query($sql);
    }

    function countPWO($keyword, $wc) {
        $now = date('Ymd');
        $yes = date('Ymd', strtotime("-1 days"));

        $sql = "SELECT COUNT(DISTINCT(a.CHR_WO_NUMBER)) as n
                FROM TT_PRODUCTION_RESULT a INNER JOIN TT_PRODUCTION_WO b
                ON b.CHR_WO_NUMBER=a.CHR_WO_NUMBER
                WHERE b.CHR_STATUS IS NULL 
                AND a.CHR_WO_NUMBER LIKE '$keyword%'
                AND a.CHR_DATE IN ('$now ','$yes')";
        return $this->db->query($sql);
    }

    function getReject($keyword) {
        $sql = "SELECT TOP 3 CHR_REJECT_CODE, CHR_REJECT_TYPE FROM TM_REJECT WHERE CHR_FLAG_DELETE IS NULL 
                AND CHR_REJECT_TYPE LIKE '$keyword%' ORDER BY CHR_REJECT_TYPE ASC";
        return $this->db->query($sql);
    }

    function countReject($keyword) {
        $sql = "SELECT COUNT(CHR_REJECT_CODE) as n
                  FROM TM_REJECT WHERE CHR_REJECT_TYPE LIKE '$keyword%'";
        return $this->db->query($sql);
    }

    //revise by Ilham 21-02-2018
    //add parameter for get data Production Version
    function getProcessPart($wc, $part_no) {
        $sql = "SELECT * FROM TM_PROCESS_PARTS WHERE CHR_WORK_CENTER='$wc' AND
                CHR_PART_NO='$part_no' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE = '')";
        return $this->db->query($sql);
    }

    function getOUM($partno) {
        $sql = "SELECT * FROM TM_PARTS WHERE CHR_PART_NO='$partno'";
        return $this->db->query($sql);
    }

    function getCurrDay() {
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

    //add by BugsMaker 11-10-2016
    // function get_all_history_by_wc_and_shift_and_date($wo) {
    //     $stored_procedure = "EXEC PRODUCTION.zsp_get_top_ten_latest_inline_scan ?";
    //     $param = array('wo' => $wo);
    //     $query = $this->db->query($stored_procedure, $param);

    //     return $query;
    // }

    //add by BugsMaker 18-10-2016
    function get_total_dandori_by_wo($wo) {
        $query = $this->db->query("select TOP 1 INT_NG_OTHERS_REV AS TOTAL_ROW from TT_PRODUCTION_RESULT 
            where CHR_WO_NUMBER = '$wo' ORDER BY INT_NUMBER DESC");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }
    
    //add by BugsMaker 14-10-2016
    // function update_flag_is_finished($wo) {
    //     $stored_procedure = "EXEC PRODUCTION.zsp_update_flag_x_for_finished_prod ?";
    //     $param = array('wo' => $wo);
    //     $this->db->query($stored_procedure, $param);
    // }
    
    // //add by BugsMaker 02-11-2016
    // function update_flag_by_work_center($wc) {
    //     $stored_procedure = "EXEC PRODUCTION.zsp_update_flag_x_for_all ?";
    //     $param = array('wc' => $wc);
    //     $this->db->query($stored_procedure, $param);
    // }
    
}

