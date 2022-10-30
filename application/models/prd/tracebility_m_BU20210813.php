<?php

class tracebility_m extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function get_data_tracebility() {
        $sql = "SELECT TOP 1 C.CHR_PRD_ORDER_NO, C.CHR_BACK_NO_FG, A.CHR_TANGGAL ,A.CHR_LAST_TIME, C.CHR_PART_NO_FG FROM TT_HISTORY_SCAN_KANBAN A
                    INNER JOIN TM_KANBAN B ON B.INT_KANBAN_NO = SUBSTRING(A.CHR_BARCODE,1,6)
                    INNER JOIN PRD.TT_ELINA_H C ON C.CHR_PART_NO_FG = B.CHR_PART_NO 
                                WHERE 
                                A.CHR_TANGGAL = '01092018' AND 
                                A.CHR_LAST_TIME LIKE '08:5%' AND 
                                B.INT_KANBAN_NO = SUBSTRING(A.CHR_BARCODE,1,6) AND
                                C.CHR_DATE_FINISH_PREPARE = '20180901'";
        return $this->db->query($sql)->row();
    }

    function get_detail_data($prd_order) {
        $sql = "SELECT HIS.CHR_PART_NO, L.CHR_PART_NAME, HIS.INT_QTY_PCS, HIS.CHR_PDS_NO, HIS.CHR_DATE_PDS, HIS.CHR_TIME_PDS, HIS.CHR_SOURCE FROM PRD.TT_ELINA_HISTORY HIS
                        INNER JOIN PRD.TT_ELINA_L L ON L.CHR_PART_NO = HIS.CHR_PART_NO
                        WHERE HIS.CHR_PRD_ORDER_NO = '$prd_order'
                        GROUP BY  HIS.CHR_PART_NO, L.CHR_PART_NAME, HIS.INT_QTY_PCS, HIS.CHR_PDS_NO, HIS.CHR_DATE_PDS, HIS.CHR_TIME_PDS, HIS.CHR_SOURCE";
        return $this->db->query($sql)->result();
    }

    function get_data_tester($date, $hour) {
        $sql = "SELECT TOP 1 * FROM PRD.TT_DATA_TESTER 
                                WHERE CHR_CREATED_DATE = '$date' AND 
                                    CHR_CREATED_TIME LIKE '$hour%'";
        return $this->db->query($sql)->row();
    }

    //=== Update by ANU -- 20181112
    function get_data_tester_new($year, $month, $day, $h, $m, $s) {
        $sql = "SELECT TOP 1 * FROM PRD.TT_DATA_TESTER 
                                WHERE CHR_YEAR = '$year' AND CHR_MONTH = '$month' AND CHR_DAY = '$day'  
                                    AND CHR_HOUR = '$h' AND CHR_MINUTE = '$m' AND CHR_SECOND = '$s'";
        return $this->db->query($sql)->row();
    }

    function get_elina_h($prd_order) {
        $sql = "SELECT TOP 1 * FROM PRD.TT_ELINA_H 
                                WHERE CHR_PRD_ORDER_NO = '$prd_order'";
        return $this->db->query($sql)->row();
    }

    //=== Update by ANU -- 20191209
    function get_data_trace_forward($qrcode) {

        // $stored_procedure = "EXEC PRD.zsp_get_traceability_forward ?";
        // $param = array(
        //     'QRCODE' => $qrcode
        // );

        // $query = $this->db->query($stored_procedure, $param);
        $query = $this->db->query("EXEC PRD.zsp_get_traceability_forward '$qrcode'");
        return $query;

        // if($query->num_rows() > 0){
        //     return $query->row();
        // } else {
        //     return NULL;
        // }
        
    }

    //=== Update by ANU -- 20200917
    function get_data_trace_forward_v2($qrcode) {

        // $stored_procedure = "EXEC PRD.zsp_get_traceability_forward ?";
        // $param = array(
        //     'QRCODE' => $qrcode
        // );

        // $query = $this->db->query($stored_procedure, $param);
        $query = $this->db->query("EXEC PRD.zsp_get_traceability_forward_v2 '$qrcode'");
        return $query;

        // if($query->num_rows() > 0){
        //     return $query->row();
        // } else {
        //     return NULL;
        // }
        
    }

    function get_data_tester_ascc05($year, $month, $day, $h, $m, $s) {
        $db_iot = $this->load->database("db_iot", TRUE);
        $sql = "SELECT TOP 1 * FROM ASCC05.TT_DATA_TESTER 
                                WHERE CHR_YEAR = '$year' AND CHR_MONTH = '$month' AND CHR_DAY = '$day'  
                                    AND CHR_HOUR = '$h' AND CHR_MINUTE = '$m' AND CHR_SECOND = '$s'";
        return $db_iot->query($sql)->row();
    }

    function get_work_center_ascc(){
        $query = $this->db->query("SELECT CHR_WCENTER CHR_WORK_CENTER 
                FROM TM_DIRECT_BACKFLUSH_GENERAL WHERE CHR_WCENTER LIKE 'ASCC%' GROUP BY CHR_WCENTER ORDER BY CHR_WCENTER ASC");

        return $query->result();
    }

    function get_data_trace_forward_ascc($qrcode, $work_center) {

        if($work_center == 'ASCC05'){
            $query = $this->db->query("EXEC PRD.zsp_get_traceability_forward_ascc05 '$qrcode'");
        } else {
            $query = $this->db->query("EXEC PRD.zsp_get_traceability_forward_ascc05 '$qrcode'");
        }
        
        return $query;

        // if($query->num_rows() > 0){
        //     return $query->row();
        // } else {
        //     return NULL;
        // }
        
    }
}