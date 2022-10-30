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

        $query = $this->db->query("EXEC PRD.zsp_get_traceability_forward_ascc05 '$qrcode'");
        
        return $query;

        // if($query->num_rows() > 0){
        //     return $query->row();
        // } else {
        //     return NULL;
        // }
        
    }

    function get_top_part_no_by_work_center($work_center){
        $part_no = $this->part_m->get_top_part_by_work_center($work_center);
        $data_part_no = $this->db->query("SELECT TOP 1 RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO
                                    FROM TM_PARTS P
                                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                                WHERE K.CHR_KANBAN_TYPE  = 5 AND PP.CHR_WORK_CENTER = '$work_center'
                                ORDER BY P.CHR_PART_NO")->row();
        return $data_part_no;

    }

    function get_part_no_by_work_center($work_center){
        $part_no = $this->part_m->get_top_part_by_work_center($work_center);
        $data_part_no = $this->db->query("SELECT RTRIM(P.CHR_PART_NO) CHR_PART_NO, RTRIM(K.CHR_BACK_NO) CHR_BACK_NO
                                    FROM TM_PARTS P
                                    INNER JOIN TM_PROCESS_PARTS PP ON PP.CHR_PART_NO = P.CHR_PART_NO
                                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO
                                WHERE K.CHR_KANBAN_TYPE  = 5 AND PP.CHR_WORK_CENTER = '$work_center'
                                ORDER BY P.CHR_PART_NO")->result();
        return $data_part_no;

    }

    function get_traceability_by_part_no_fg($work_center, $part_no, $start_date, $end_date) { 
        $work_center = strtolower($work_center);       
        if($work_center == 'ascd02'){
            $sql = $this->db->query("EXEC QUA.zsp_get_traceability_data_" . $work_center . " '$part_no','$start_date','$end_date'");
        } else {
            $db_iot = $this->load->database("db_iot", TRUE);
            $sql = $db_iot->query("EXEC zsp_get_traceability_data_" . $work_center . " '$part_no','$start_date','$end_date'");
        }
        
        return $sql->result();        
    }

    function get_data_elina_by_lot_no($prd_order){
        $prd_order = str_replace("-","/",$prd_order);
        $data_elina = $this->db->query("SELECT L.CHR_PRD_ORDER_NO, L.CHR_PART_NO, L.CHR_BACK_NO, L.CHR_PART_NAME, EH.CHR_PDS_NO, EH.CHR_DATE_PDS, EH.CHR_TIME_PDS, EH.INT_QTY_PCS, EH.CHR_SOURCE, EH.CHR_BARCODE, 
                            EH.CHR_PREPARE_AREA, EH.CHR_NPK, L.CHR_FLAG_SCAN, L.CHR_DATE_SCAN, L.CHR_TIME_SCAN
                            FROM PRD.TT_ELINA_L L
                            LEFT JOIN PRD.TT_ELINA_HISTORY EH ON L.CHR_PRD_ORDER_NO = EH.CHR_PRD_ORDER_NO AND L.CHR_PART_NO = EH.CHR_PART_NO 
                            WHERE EH.CHR_PRD_ORDER_NO = '$prd_order'");
        return $data_elina;

    }

    function get_data_quinsa_by_lot_no($prd_order){
        $prd_order = str_replace("-","/",$prd_order);
        $db_qua = $this->load->database("dbqua", TRUE);
        $data_quinsa = $db_qua->query("SELECT A.CHR_DOC_ID, A.CHR_REF_MASTER, A.CHR_LOT_NOMOR, A.CHR_PARTNO, A.CHR_PART_NM, A.CHR_MODEL_NM, A.CHR_EXEC_BY, A.CHR_INSPEC_TYPE, 
                        A.CHR_DIEHIGH, A.CHR_STATUS, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, B.CHR_SEQ, B.CHR_RECORD_TYPE, B.CHR_DEVICE_ID, B.CHR_SAMPLING,
                        B.CHR_REPETITION, B.CHR_CHECK_POINT, B.CHR_TYPE, B.CHR_SPECIAL_CHAR, B.CHR_CONTROL, B.CHR_TARGET_SL, B.CHR_RANGE_SL, B.CHR_LSL, B.CHR_USL, 
                        B.CHR_UOM_SL, B.CHR_TARGET_CL, B.CHR_RANGE_CL, B.CHR_LCL, B.CHR_UCL, B.CHR_UOM_CL, B.CHR_QLT_CL, B.CHR_QLT_VAL, B.CHR_RESULT, B.CHR_STATUS, B.CHR_STRATEGY
                    FROM   TT_QUA_INSPECTION_H A
                    LEFT JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID = B.CHR_DOC_ID 
                    WHERE A.CHR_LOT_NOMOR = '$prd_order'");
        return $data_quinsa;

    }

    function get_data_tester_by_line($barcode, $work_center) {

        $db_iot = $this->load->database("db_iot", TRUE);
        $data = $db_iot->query("SELECT TOP 1 * FROM $work_center.TT_DATA_TESTER WHERE CHR_UNIQUE_NUMBER LIKE '$barcode%'");

        if($data->num_rows() > 0){
            return $data->row();
        } else {
            return false;
        }

    }

}