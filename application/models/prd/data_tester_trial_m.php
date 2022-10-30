<?php

class data_tester_trial_m extends CI_Model {

    private $table_name = 'PRD.TT_DATA_TESTER';
    private $tables_name = 'TT_DATA_TESTER';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->table_name, $data);
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->table_name, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->table_name, $data);
    }

    function get_summary_data_tester(){

        $query = $this->db->query("SELECT CHR_CREATED_DATE ,ISNULL(INT_FLG_GENERATED,'0') INT_FLG_GENERATED , ISNULL(CHR_GENERATED,'-') CHR_GENERATED FROM  PRD.TT_DATA_TESTER 
        WHERE INT_FLG_SCAN = 1 GROUP BY CHR_CREATED_DATE , INT_FLG_GENERATED, CHR_GENERATED ORDER BY CHR_CREATED_DATE DESC");
        return $query->result();
    }

    function get_data_tester_by_date($date){

        $query = $this->db->query("SELECT TOP 60 SUBSTRING(CHR_YEAR,3,2) +  
            CASE WHEN LEN(CHR_MONTH) =  1 THEN '0' + CHR_MONTH ELSE CHR_MONTH END + 
            CASE WHEN LEN(CHR_DAY) =  1 THEN '0' + CHR_DAY ELSE CHR_DAY END + 
            CASE WHEN LEN(CHR_HOUR) =  1 THEN '0' + CHR_HOUR ELSE CHR_HOUR END +
            CASE WHEN LEN(CHR_MINUTE) =  1 THEN '0' + CHR_MINUTE ELSE CHR_MINUTE END +
            CASE WHEN LEN(CHR_SECOND) =  1 THEN '0' + CHR_SECOND ELSE CHR_SECOND END +
            '0' + CHR_MASTER_NO AS CHR_BARCODE_PRODUCT, DT.CHR_MODIFIED_BY AS CHR_PRD_ORDER_NO, DT.CHR_CREATED_DATE + '' + DT.CHR_CREATED_TIME AS TIMESTAMP, 
            '6200013787' AS CHR_PDS_NO, 'SJ/20/041227' AS CHR_DEL_NO
            FROM  PRD.TT_DATA_TESTER DT INNER JOIN PRD.TT_ONE_WAY_KANBAN OWK ON DT.INT_ID_ONE_WAY_KANBAN = OWK.INT_ID 
            WHERE DT.CHR_MODIFIED_BY IS NOT NULL AND DT.CHR_CREATED_DATE LIKE '20200407%' ORDER BY CHR_PRD_ORDER_NO DESC");
        return $query;

        // $query = $this->db->query("
        // ;WITH CTE_HISTORY (CHR_PRD_ORDER_NO, CHR_SERIAL, CHR_DEL_NO, CHR_PDS_NO) AS (
        //     SELECT CHR_PRD_ORDER_NO, CHR_SERIAL, 'SJ/' + SUBSTRING(D.CHR_DEL_DATE,3,2) +'/'+ SUBSTRING(D.CHR_DEL_NO,5,6), CHR_PDS_NO 
        //     FROM PRD.TT_ONE_WAY_KANBAN OWK 
        //     INNER JOIN TT_HISTORY_SCAN_KANBAN_SD H ON OWK.CHR_PRD_ORDER_NO +' '+ OWK.CHR_SERIAL = H.CHR_BARCODE
        //     INNER JOIN TT_DELIVERY D ON D.CHR_DEL_NO = H.CHR_DEL_NO
        // )
        
        // SELECT SUBSTRING(CHR_YEAR,3,2) +  
        //             CASE WHEN LEN(CHR_MONTH) =  1 THEN '0' + CHR_MONTH ELSE CHR_MONTH END + 
        //             CASE WHEN LEN(CHR_DAY) =  1 THEN '0' + CHR_DAY ELSE CHR_DAY END + 
        //             CASE WHEN LEN(CHR_HOUR) =  1 THEN '0' + CHR_HOUR ELSE CHR_HOUR END +
        //             CASE WHEN LEN(CHR_MINUTE) =  1 THEN '0' + CHR_MINUTE ELSE CHR_MINUTE END +
        //             CASE WHEN LEN(CHR_SECOND) =  1 THEN '0' + CHR_SECOND ELSE CHR_SECOND END +
        //             '0' + CHR_MASTER_NO AS CHR_BARCODE_PRODUCT , 
        //             DT.CHR_PRD_ORDER_NO ,
        //     CHR_CREATED_DATE + CHR_CREATED_TIME AS TIMESTAMP,
        //     ISNULL(CHR_DEL_NO,'-') CHR_DEL_NO, ISNULL(CHR_PDS_NO,'-')  CHR_PDS_NO
        // FROM PRD.TT_DATA_TESTER DT 
        // INNER JOIN CTE_HISTORY H ON DT.CHR_PRD_ORDER_NO = H.CHR_PRD_ORDER_NO
        // WHERE DT.CHR_CREATED_DATE = '$date' 
        // GROUP BY SUBSTRING(CHR_YEAR,3,2) +  
        //             CASE WHEN LEN(CHR_MONTH) =  1 THEN '0' + CHR_MONTH ELSE CHR_MONTH END + 
        //             CASE WHEN LEN(CHR_DAY) =  1 THEN '0' + CHR_DAY ELSE CHR_DAY END + 
        //             CASE WHEN LEN(CHR_HOUR) =  1 THEN '0' + CHR_HOUR ELSE CHR_HOUR END +
        //             CASE WHEN LEN(CHR_MINUTE) =  1 THEN '0' + CHR_MINUTE ELSE CHR_MINUTE END +
        //             CASE WHEN LEN(CHR_SECOND) =  1 THEN '0' + CHR_SECOND ELSE CHR_SECOND END +
        //             '0' + CHR_MASTER_NO, DT.CHR_PRD_ORDER_NO,
        //     CHR_CREATED_DATE + CHR_CREATED_TIME,CHR_DEL_NO, CHR_PDS_NO
        // ORDER BY CHR_CREATED_DATE + CHR_CREATED_TIME ASC
        // ");

        // return $query;
    }

    function get_data_tester_by_timestamp($timestamp){

        $query = $this->db->query("SELECT ROW_NUMBER() OVER(ORDER BY INT_ID ASC) AS NOROW, SUBSTRING(CHR_YEAR,3,2) +  
            CASE WHEN LEN(CHR_MONTH) =  1 THEN '0' + CHR_MONTH ELSE CHR_MONTH END + 
            CASE WHEN LEN(CHR_DAY) =  1 THEN '0' + CHR_DAY ELSE CHR_DAY END + 
            CASE WHEN LEN(CHR_HOUR) =  1 THEN '0' + CHR_HOUR ELSE CHR_HOUR END +
            CASE WHEN LEN(CHR_MINUTE) =  1 THEN '0' + CHR_MINUTE ELSE CHR_MINUTE END +
            CASE WHEN LEN(CHR_SECOND) =  1 THEN '0' + CHR_SECOND ELSE CHR_SECOND END +
            '0' + CHR_MASTER_NO AS CHR_BARCODE_PRODUCT, 
            CHR_CREATED_DATE + '' + CHR_CREATED_TIME AS TIMESTAMP, 
            CHR_MODIFIED_BY AS CHR_PRD_ORDER_NO,
            ISNULL(INT_FLG_GENERATED,'0') INT_FLG_GENERATED
            FROM  PRD.TT_DATA_TESTER WHERE CHR_GENERATED = '$timestamp'
            ORDER BY INT_ID ASC");

        return $query;
    }

    function update_flag_generated($date){
        $data = array(
            'INT_FLG_GENERATED' => 1,
            'CHR_GENERATED' => date('YmdHis')
        );

        $this->db->where('CHR_CREATED_DATE', $date);
        $this->db->where('INT_FLG_GENERATED', '0');
        $this->db->update($this->table_name, $data);
    }

    function select_data_tester_base_on_range_date($start_date, $end_date){
        $query = $this->db->query("SELECT ROW_NUMBER() OVER(ORDER BY DT.INT_ID ASC) AS NOROW, SC.CHR_PRD_ORDER_NO,CHR_COUNTER,CHR_PART_NO, CHR_BACK_NO ,CHR_MODEL,
            SUBSTRING(CHR_YEAR,3,2) + 
            CASE LEN(CHR_MONTH) WHEN 1 THEN '0' + CHR_MONTH ELSE CHR_MONTH END +
            CASE LEN(CHR_DAY) WHEN 1 THEN '0' + CHR_DAY ELSE CHR_DAY END +
            CASE LEN(CHR_HOUR) WHEN 1 THEN '0' + CHR_HOUR ELSE CHR_HOUR END +
            CASE LEN(CHR_MINUTE) WHEN 1 THEN '0' + CHR_MINUTE ELSE CHR_MINUTE END +
            CASE LEN(CHR_SECOND) WHEN 1 THEN '0' + CHR_SECOND ELSE CHR_SECOND END 
            AS CHR_BARCODE
            ,CHR_LOW_K1_UPP ,CHR_LOW_K1 ,CHR_LOW_K1_LOW 
            ,CHR_LOW_H1_UPP ,CHR_LOW_H1 ,CHR_LOW_H1_LOW
            ,CHR_HIGH_H1_UPP,CHR_HIGH_H1,CHR_HIGH_H1_LOW
            ,CHR_HIGH_H2_UPP,CHR_HIGH_H2,CHR_HIGH_H2_LOW
            ,CHR_HIGH_K1_UPP,CHR_HIGH_K1,CHR_HIGH_K1_LOW
            ,CHR_HIGH_K2_UPP,CHR_HIGH_K2,CHR_HIGH_K2_LOW
            ,CHR_HIGH_K3_UPP,CHR_HIGH_K3,CHR_HIGH_K3_LOW
            ,CHR_HIGH_K4_UPP,CHR_HIGH_K4,CHR_HIGH_K4_LOW, DT.CHR_CREATED_DATE 
            FROM PRD.TT_DATA_TESTER DT 
            INNER JOIN PRD.TT_SETUP_CHUTE SC 
            ON DT.CHR_PRD_ORDER_NO = SC.CHR_PRD_ORDER_NO
            WHERE SC.INT_FLG_DEL = 0 AND DT.CHR_CREATED_DATE >= '$start_date' AND DT.CHR_CREATED_DATE <= '$end_date'");

        return $query->result();
    }

    //get scanned product by barcode from ines ogawa
    function get_data_tester_by_barcode_and_part_no($work_center, $barcode_product, $part_no){
        $year = '20'.substr($barcode_product, 0, 2);
        $month = (int)substr($barcode_product, 2, 2);
        $day = (int)substr($barcode_product, 4, 2);
        $hour = (int)substr($barcode_product, 6, 2);
        $minute = (int)substr($barcode_product, 8, 2);
        $second = (int)substr($barcode_product, 10, 2);
        $model = (int)substr($barcode_product, -3);
        $part_no = substr(trim($part_no), 0, 11);

        $scheme = $work_center;

        if($work_center == 'ASCD02'){
            $scheme = 'PRD';
        }
        
        $query = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name DT 
            INNER JOIN DB_AIS.PRD.TM_MASTER_MODEL MM ON DT.CHR_MASTER_NO = MM.CHR_MODEL
            WHERE CHR_PRD_ORDER_NO like '$work_center%' AND CHR_YEAR = '$year' AND CHR_MONTH = $month 
            AND CHR_DAY = $day AND CHR_HOUR = $hour AND CHR_MINUTE = $minute AND CHR_SECOND = $second AND CHR_MASTER_NO = $model 
            AND MM.CHR_PART_NO = '$part_no' AND MM.CHR_WORK_CENTER = '$work_center' AND MM.BIT_FLG_DEL = 0 
            GROUP BY CHR_PRD_ORDER_NO";

        //===== Update for new program tester - by ANU 20211006 =====//
        $query_new = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name DT 
            INNER JOIN DB_AIS.PRD.TM_MASTER_MODEL MM ON DT.CHR_MASTER_NO = MM.CHR_MODEL
            WHERE CHR_PRD_ORDER_NO like '$work_center%' AND CHR_UNIQUE_NUMBER = '$barcode_product'
            AND MM.CHR_PART_NO = '$part_no' AND MM.CHR_WORK_CENTER = '$work_center' AND MM.BIT_FLG_DEL = 0 
            GROUP BY CHR_PRD_ORDER_NO";
        //===== End update =====// 
        
        if($work_center == 'ASCD02'){
            $result = $this->db->query($query);
        }
        //===== Update for new program tester - by ANU 20211006 =====//
        else if($work_center == 'ASDL06' || $work_center == 'ASIM04'){
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query_new);
        }
        //===== End update =====// 
        else{
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query);
        }
        return $result;
    }

    //get scanned product by barcode from ines ogawa
    function get_data_tester_by_barcode($work_center, $barcode_product, $flg_scan){
        $year = '20'.substr($barcode_product, 0, 2);
        $month = (int)substr($barcode_product, 2, 2);
        $day = (int)substr($barcode_product, 4, 2);
        $hour = (int)substr($barcode_product, 6, 2);
        $minute = (int)substr($barcode_product, 8, 2);
        $second = (int)substr($barcode_product, 10, 2);
        $model = (int)substr($barcode_product, -3);

        $scheme = $work_center;

        if($work_center == 'ASCD02'){
            $scheme = 'PRD';
        }
        
        $query = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name
            WHERE INT_FLG_SCAN = $flg_scan AND  CHR_PRD_ORDER_NO like '$work_center%' AND CHR_YEAR = '$year' AND CHR_MONTH = $month 
            AND CHR_DAY = $day AND CHR_HOUR = $hour AND CHR_MINUTE = $minute AND CHR_SECOND = $second AND CHR_MASTER_NO = $model 
            GROUP BY CHR_PRD_ORDER_NO";

        //===== Update for new program tester - by ANU 20211006 =====//
        $query_new = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name
            WHERE INT_FLG_SCAN = $flg_scan AND  CHR_PRD_ORDER_NO like '$work_center%' 
            AND CHR_UNIQUE_NUMBER = '$barcode_product'
            GROUP BY CHR_PRD_ORDER_NO";
        //===== End update =====// 
        
        if($work_center == 'ASCD02'){
            $result = $this->db->query($query);
        }
        //===== Update for new program tester - by ANU 20211006 =====//
        else if($work_center == 'ASDL06' || $work_center == 'ASIM04'){
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query_new);
        }
        //===== End update =====// 
        else{
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query);
        }
        return $result;
    }

    //update product by barcode from ines ogawa
    function update_flag_scan_product($work_center, $prod_order_no, $barcode_product){
        $date = date('Ymd');
        $time = date('His');
        $id = '';
        $year = '20'.substr($barcode_product, 0, 2);
        $month = (int)substr($barcode_product, 2, 2);
        $day = (int)substr($barcode_product, 4, 2);
        $hour = (int)substr($barcode_product, 6, 2);
        $minute = (int)substr($barcode_product, 8, 2);
        $second = (int)substr($barcode_product, 10, 2);
        $model = (int)substr($barcode_product, -3);

        $scheme = $work_center;

        if($work_center == 'ASCD02'){
            $scheme = 'PRD';
        }

        $data_one_way_normal = $this->db->query("SELECT TOP 1 CHR_SERIAL, INT_ID 
            FROM PRD.TT_ONE_WAY_KANBAN WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_PRINT = 0 ORDER BY INT_ID ASC");

        if($data_one_way_normal->num_rows() > 0){
            $id = $data_one_way_normal->row()->INT_ID;
        }else{
            $data_one_way_abnormal = $this->db->query("SELECT TOP 1 CHR_SERIAL, INT_ID  FROM PRD.TT_ONE_WAY_KANBAN WHERE CHR_PRD_ORDER_NO = '$prod_order_no'
            ORDER BY INT_ID ASC");
            $id = $data_one_way_abnormal->row()->INT_ID;
        }

        $query = "UPDATE $scheme.$this->tables_name
            SET INT_FLG_SCAN = 1,  CHR_MODIFIED_BY = '$prod_order_no',  CHR_MODIFIED_DATE = '$date',   CHR_MODIFIED_TIME = '$time', INT_ID_ONE_WAY_KANBAN = '$id'
            WHERE  CHR_PRD_ORDER_NO like '$work_center%' AND CHR_YEAR = '$year' AND CHR_MONTH = '$month' AND CHR_DAY = '$day' AND CHR_HOUR = '$hour' 
            AND CHR_MINUTE = '$minute' AND CHR_SECOND = '$second' AND CHR_MASTER_NO = $model";

        //===== Update for new program tester - by ANU 20211006 =====//
        $query_new = "UPDATE $scheme.$this->tables_name
            SET INT_FLG_SCAN = 1,  CHR_MODIFIED_BY = '$prod_order_no',  CHR_MODIFIED_DATE = '$date',   CHR_MODIFIED_TIME = '$time', INT_ID_ONE_WAY_KANBAN = '$id'
            WHERE  CHR_PRD_ORDER_NO like '$work_center%' 
            AND CHR_UNIQUE_NUMBER = '$barcode_product'";
        //===== End update =====// 

        if($work_center == 'ASCD02'){
            $this->db->query($query);
        }
        //===== Update for new program tester - by ANU 20211006 =====//
        else if($work_center == 'ASDL06' || $work_center == 'ASIM04'){
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query_new);
        }
        //===== End update =====// 
        else{
            $db_iot = $this->load->database("db_iot", TRUE);
            $db_iot->query($query);
        }

    }
   

}