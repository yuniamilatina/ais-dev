<?php

class line_stop_prod_m extends CI_Model {

    private $tabel = 'TT_LINE_STOP_PROD';
    private $tabel_master = 'TM_LINE_STOP';

    public function __construct() {
        parent::__construct();
    }

    function get_data_line_stop($codels) {
        $data_ls = $this->db->query("SELECT CHR_LINE_STOP FROM $this->tabel_master WHERE CHR_LINE_CODE = '$codels'");

        return trim($data_ls->row()->CHR_LINE_STOP);
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    //delete sooon
    // function update_ls_duration($data, $id) {

    //     $wo_number = $id['CHR_WO_NUMBER'];
    //     $ls_code = $id['CHR_LINE_CODE'];

    //     $ls_duration = $data['INT_MINUTES_TIME'];
    //     $total_ls_duration = $data['INT_TOTAL_LINE_STOP'];

    //     $this->db->query("UPDATE TT_LINE_STOP_PROD SET INT_MINUTES_TIME = '$ls_duration', INT_TOTAL_LINE_STOP = '$total_ls_duration'
    //         WHERE INT_ID_LINE_STOP = 
    //         (
    //         SELECT TOP 1 INT_ID_LINE_STOP
    //         FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo_number' AND CHR_LINE_CODE='$ls_code'
    //         ORDER BY INT_ID_LINE_STOP DESC)"
    //     );

    // }

    //delete sooon
    // function update_ls_waiting_duration($data, $id) {

    //     $wo_number = $id['CHR_WO_NUMBER'];
    //     $ls_code = $id['CHR_LINE_CODE'];
    //     $ls_waiting_duration = $data['INT_DURASI_WAITING'];

    //     $this->db->query("UPDATE TT_LINE_STOP_PROD SET INT_DURASI_WAITING = '$ls_waiting_duration'
    //         WHERE INT_ID_LINE_STOP = 
    //         (
    //         SELECT TOP 1 INT_ID_LINE_STOP
    //         FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo_number' AND CHR_LINE_CODE='$ls_code'
    //         ORDER BY INT_ID_LINE_STOP DESC)"
    //     );

    // }

    function update_duration_line_stop($data, $id) {

        $wo_number = $id['CHR_WO_NUMBER'];
        $ls_code = $id['CHR_LINE_CODE'];

        $waiting_duration = $data['INT_DURASI_WAITING'];
        $repair_duration = $data['INT_DURASI_REPAIR'];
        $problem_duration = $data['INT_DURASI_LS'];
        $waiting_duration_second = $data['INT_TOTAL_DURASI_WAITING'];
        $repair_duration_second = $data['INT_TOTAL_DURASI_REPAIR'];
        $problem_duration_second = $data['INT_TOTAL_DURASI_LS'];

        $this->db->query("UPDATE TT_LINE_STOP_PROD SET 
            INT_DURASI_WAITING = '$waiting_duration', 
            INT_DURASI_REPAIR = '$repair_duration',  
            INT_DURASI_LS = '$problem_duration',
            INT_TOTAL_DURASI_WAITING = $waiting_duration_second,
            INT_TOTAL_DURASI_REPAIR = $repair_duration_second,
            INT_TOTAL_DURASI_LS = $problem_duration_second
            WHERE INT_ID_LINE_STOP = 
            ( 
                SELECT TOP 1 INT_ID_LINE_STOP
                FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo_number' AND CHR_LINE_CODE='$ls_code'
                ORDER BY INT_ID_LINE_STOP DESC
            )"
        );

    }

    //delete sooon
    // function update_ls_repair_duration($data, $id) {

    //     $wo_number = $id['CHR_WO_NUMBER'];
    //     $ls_code = $id['CHR_LINE_CODE'];
    //     $ls_repair_duration = $data['INT_DURASI_REPAIR'];
    //     $ls_duration = $data['INT_MINUTES_TIME'];
    //     $total_ls_duration = $data['INT_TOTAL_LINE_STOP'];

    //     $this->db->query("UPDATE TT_LINE_STOP_PROD SET INT_DURASI_REPAIR = '$ls_repair_duration',  
    //         INT_MINUTES_TIME = '$ls_duration',  INT_TOTAL_LINE_STOP = '$total_ls_duration'
    //         WHERE INT_ID_LINE_STOP = 
    //         (
    //         SELECT TOP 1 INT_ID_LINE_STOP
    //         FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo_number' AND CHR_LINE_CODE='$ls_code'
    //         ORDER BY INT_ID_LINE_STOP DESC)"
    //     );

    // }

    // function geCountLS($wo) {
    //     return $this->db->query("SELECT SUM(INT_MINUTES_TIME) as INT_TOTAL_LINE_STOP FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo'");
    // }

    function start_line_stop($wo, $work_center, $shift, $dateprod, $codels) {
        $date = date('Ymd');
        $time = date('His');
        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $data = $this->db->query("SELECT TOP 1 INT_NUMBER, CHR_IP FROM TT_PRODUCTION_RESULT
                WHERE CHR_WO_NUMBER = '$wo' 
                AND CHR_IP = '$ip'
                AND CHR_STATUS_MOBILE = 'I' 
                ORDER BY INT_NUMBER DESC");

        if ($data->num_rows() > 0) {
            $int_number = $data->row()->INT_NUMBER;
        } else {
            $int_number = '';
        }

        $this->db->query("INSERT INTO TT_LINE_STOP_PROD (CHR_LINE_CODE, INT_NUMBER, CHR_WO_NUMBER, CHR_WORK_CENTER, CHR_DATE, CHR_SHIFT, CHR_CREATED_DATE, CHR_CREATED_TIME, CHR_START_DATE, CHR_START_TIME)
                VALUES ('$codels', '$int_number' , '$wo', '$work_center', '$dateprod', '$shift', '$date', '$time', '$date', '$time')");

        return true;
    }

    function geCountFollowup($wo) {
        $array_error = $this->db->query("SELECT ISNULL(SUM(INT_DURASI_REPAIR),0) AS INT_TOTAL_DURASI_REPAIR FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo' AND CHR_LINE_CODE IN ('LS5','LS4')");

        if ($array_error->num_rows() > 0) {
            return $array_error->row_array();
        } else {
            return 0;
        }
    }

//20170826
    function geCountWaiting($wo) {
        $array_error = $this->db->query("SELECT ISNULL(SUM(INT_DURASI_WAITING),0) AS INT_TOTAL_DURASI_WAITIING FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER='$wo' AND CHR_LINE_CODE IN ('LS5','LS4')");

        if ($array_error->num_rows() > 0) {
            return $array_error->row_array();
        } else {
            return 0;
        }
    }

//20170822
    function getLineStopMachine($wo, $codels) {
        $array_error = $this->db->query("SELECT TOP 1 CHR_WAITING_DATE + CHR_WAITING_TIME AS DATETIME_WAITING, * FROM TT_LINE_STOP_PROD WHERE CHR_WO_NUMBER =  '$wo' AND CHR_LINE_CODE =  '$codels' ORDER BY INT_ID_LINE_STOP DESC");

        if ($array_error->num_rows() > 0) {
            return $array_error->row_array();
        } else {
            return 0;
        }
    }

//20170822
    function update_total_line_stop_machine($total, $wo) {
        $this->db->query("UPDATE TT_LINE_STOP_PROD SET INT_TOTAL_DURASI_REPAIR = '$total'
                WHERE CHR_WO_NUMBER = '$wo' AND CHR_LINE_CODE IN ('LS5','LS4')");
    }

//20170826
    function update_total_waiting_machine($total, $wo) {
        $this->db->query("UPDATE TT_LINE_STOP_PROD SET INT_TOTAL_DURASI_WAITIING = '$total'
                WHERE CHR_WO_NUMBER = '$wo' AND CHR_LINE_CODE IN ('LS5','LS4')");
    }

    function get_data_summary_line_stop($wo){
        $stored_procedure = "EXEC PRD.zsp_get_history_line_stop_ines ?";
        $param = array(
            'wo' => $wo
        );
        return $this->db->query($stored_procedure, $param)->row();
    }

    function get_line_stop_by_wc_and_date($work_center, $date){

        return $query = $this->db->query("SELECT A.CHR_LINE_CODE, B.CHR_LINE_STOP, ROUND(CAST(SUM(CAST(INT_TOTAL_DURASI_LS AS FLOAT))/60 AS FLOAT),1) AS TOTAL_LINE_STOP
           FROM TT_LINE_STOP_PROD A
           LEFT JOIN TM_LINE_STOP B ON A.CHR_LINE_CODE = B.CHR_LINE_CODE
           WHERE CHR_WORK_CENTER = '$work_center' AND SUBSTRING(CHR_WO_NUMBER,8,8) = '$date'
           GROUP BY A.CHR_LINE_CODE, B.CHR_LINE_STOP")->result();
    }

    function get_detail_line_stop_by_wc_and_date($date, $work_center){

        $query = $this->db->query("SELECT CHR_WO_NUMBER,  CASE INT_SHIFT_TYPE WHEN 1 THEN 'L' ELSE 'N' END AS FLG_SHIFT, A.CHR_LINE_CODE, B.CHR_LINE_STOP, 
            ROUND(CAST(INT_TOTAL_DURASI_LS AS FLOAT)/60,1) AS INT_DURASI_LS, 
            ROUND(CAST(INT_TOTAL_DURASI_WAITING AS FLOAT)/60,1) AS INT_DURASI_WAITING, 
            ROUND(CAST(INT_TOTAL_DURASI_REPAIR AS FLOAT)/60,1) AS INT_DURASI_REPAIR
            FROM TT_LINE_STOP_PROD A
            LEFT JOIN TM_LINE_STOP B ON A.CHR_LINE_CODE = B.CHR_LINE_CODE
            WHERE CHR_WORK_CENTER = '$work_center' AND SUBSTRING(CHR_WO_NUMBER,8,8) = '$date' ORDER BY CHR_WO_NUMBER ASC");
           
        return $query->result();
    }

    function get_data_ls_subassy($date) {
        return $this->db->query("SELECT INT_ID_LINE_STOP, ML.CHR_LINE_STOP,  CHR_WORK_CENTER, CHR_DATE, CHR_SHIFT, INT_SHIFT_TYPE, 
            CHR_START_TIME, CHR_STOP_TIME, CHR_WAITING_TIME, CHR_FOLLOWUP_TIME, ISNULL(CHR_FOLLOWUP_BY,'-') CHR_FOLLOWUP_BY, CHR_CREATED_BY
            FROM TT_LINE_STOP_PROD LS INNER JOIN TM_LINE_STOP ML 
            ON LS.CHR_LINE_CODE = ML.CHR_LINE_CODE
            WHERE LS.CHR_LINE_CODE IN ('LS4', 'LS5') AND CHR_STOP_TIME IS NULL AND CONVERT(varchar(10),(dateadd(dd, +1, CHR_DATE )),112) >= '$date' AND 
            CHR_WORK_CENTER IN (
                SELECT CHR_WCENTER AS CHR_WORK_CENTER FROM TM_DIRECT_BACKFLUSH_GENERAL WHERE CHR_WCENTER NOT IN  (SELECT CHR_WORK_CENTER FROM TM_INLINE_SCAN GROUP BY CHR_WORK_CENTER) 
            AND INT_LIVE = 1)")->result();
    }
    
}
