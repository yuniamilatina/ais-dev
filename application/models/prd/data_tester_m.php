<?php

class data_tester_m extends CI_Model
{

    private $table_name = 'PRD.TT_DATA_TESTER';
    private $tables_name = 'TT_DATA_TESTER';

    public function __construct()
    {
        parent::__construct();
    }

    function save($data)
    {
        $this->db->insert($this->table_name, $data);
    }

    function update($data, $id)
    {
        $this->db->where($id);
        $this->db->update($this->table_name, $data);
    }

    function delete($id)
    {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->table_name, $data);
    }

    function select_data_tester_base_on_range_date($start_date, $end_date)
    {
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
    function get_data_tester_by_barcode_and_part_no($work_center, $barcode_product, $part_no)
    {
        $year = '20' . substr($barcode_product, 0, 2);
        $month = (int)substr($barcode_product, 2, 2);
        $day = (int)substr($barcode_product, 4, 2);
        $hour = (int)substr($barcode_product, 6, 2);
        $minute = (int)substr($barcode_product, 8, 2);
        $second = (int)substr($barcode_product, 10, 2);
        $model = (int)substr($barcode_product, -3);
        $part_no = substr(trim($part_no), 0, 11);

        $scheme = $work_center;

        if ($work_center == 'ASCD02') {
            $scheme = 'PRD';
        }

        $query = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name DT 
            INNER JOIN DB_AIS.PRD.TM_MASTER_MODEL MM ON DT.CHR_MASTER_NO = MM.CHR_MODEL
            WHERE LEFT(CHR_PRD_ORDER_NO,6) = '$work_center' AND CHR_YEAR = '$year' AND CHR_MONTH = $month 
            AND CHR_DAY = $day AND CHR_HOUR = $hour AND CHR_MINUTE = $minute AND CHR_SECOND = $second AND CHR_MASTER_NO = $model 
            AND MM.CHR_PART_NO = '$part_no' AND MM.CHR_WORK_CENTER = '$work_center' AND MM.BIT_FLG_DEL = 0 
            GROUP BY CHR_PRD_ORDER_NO";

        //===== Update for new program tester - by ANU 20211006 =====//
        $query_new = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name DT 
            INNER JOIN DB_AIS.PRD.TM_MASTER_MODEL MM ON DT.CHR_MASTER_NO = MM.CHR_MODEL
            WHERE LEFT(CHR_PRD_ORDER_NO,6) = '$work_center' AND CHR_UNIQUE_NUMBER = '$barcode_product'
            AND MM.CHR_PART_NO = '$part_no' AND MM.CHR_WORK_CENTER = '$work_center' AND MM.BIT_FLG_DEL = 0 
            GROUP BY CHR_PRD_ORDER_NO";
        //===== End update =====// 

        //===== Update for new program tester - by TOROSSS 20220520 =====//
        $query_hybrid = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name DT 
            INNER JOIN DB_AIS.PRD.TM_MASTER_MODEL MM ON DT.CHR_MASTER_NO = MM.CHR_MODEL
            WHERE LEFT(CHR_PRD_ORDER_NO,6) = '$work_center' 
            AND CHR_UNIQUE_NUMBER LIKE '$barcode_product%'
            -- AND RIGHT(RTRIM(CHR_UNIQUE_NUMBER),22) LIKE RIGHT(RTRIM('$barcode_product%'),23)
            AND MM.CHR_PART_NO = '$part_no' AND MM.CHR_WORK_CENTER = '$work_center' AND MM.BIT_FLG_DEL = 0 
            GROUP BY CHR_PRD_ORDER_NO";
        //===== End update =====// 

        if ($work_center == 'ASCD02') {
            $result = $this->db->query($query);
        }
        else if ($work_center == 'ASDL06' || $work_center == 'ASIM04') { //===== Update for new program tester - by ANU 20211006 =====//
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query_new);
        }
        else if ($work_center == 'ASHV01') {
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query_hybrid);
        }
        else {
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query);
        }
        return $result;
    }

    //get scanned product by barcode from ines ogawa
    function get_data_tester_by_barcode($work_center, $barcode_product, $flg_scan)
    {
        $year = '20' . substr($barcode_product, 0, 2);
        $month = (int)substr($barcode_product, 2, 2);
        $day = (int)substr($barcode_product, 4, 2);
        $hour = (int)substr($barcode_product, 6, 2);
        $minute = (int)substr($barcode_product, 8, 2);
        $second = (int)substr($barcode_product, 10, 2);
        $model = (int)substr($barcode_product, -3);

        $scheme = $work_center;

        if ($work_center == 'ASCD02') {
            $scheme = 'PRD';
        }

        $query = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name
            WHERE INT_FLG_SCAN = $flg_scan AND  LEFT(CHR_PRD_ORDER_NO,6) = '$work_center' AND CHR_YEAR = '$year' AND CHR_MONTH = $month 
            AND CHR_DAY = $day AND CHR_HOUR = $hour AND CHR_MINUTE = $minute AND CHR_SECOND = $second AND CHR_MASTER_NO = $model 
            GROUP BY CHR_PRD_ORDER_NO";

        //===== Update for new program tester - by ANU 20211006 =====//
        $query_new = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name
            WHERE INT_FLG_SCAN = $flg_scan AND  LEFT(CHR_PRD_ORDER_NO,6) = '$work_center'
            AND CHR_UNIQUE_NUMBER = '$barcode_product'
            GROUP BY CHR_PRD_ORDER_NO";
        //===== End update =====//

        //===== Update for new program tester - by TOROSS 20220520 =====//
        $query_hybrid = "SELECT CHR_PRD_ORDER_NO FROM $scheme.$this->tables_name
                WHERE INT_FLG_SCAN = $flg_scan AND  LEFT(CHR_PRD_ORDER_NO,6) = '$work_center'
                AND CHR_UNIQUE_NUMBER LIKE '$barcode_product%'
                -- AND RIGHT(RTRIM(CHR_UNIQUE_NUMBER),22) LIKE RIGHT(RTRIM('$barcode_product%'),23)
                GROUP BY CHR_PRD_ORDER_NO";
        //===== End update =====//

        if ($work_center == 'ASCD02') {
            $result = $this->db->query($query);
        } else if ($work_center == 'ASDL06' || $work_center == 'ASIM04') { //===== Update for new program tester - by ANU 20211006 =====//
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query_new);
        } else if ($work_center == 'ASHV01') { //===== Update for new program tester - by TOROSS 20220520 =====//
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query_hybrid);
        } else {
            $db_iot = $this->load->database("db_iot", TRUE);
            $result = $db_iot->query($query);
        }
        return $result;
    }

    //update product by barcode from ines ogawa
    function update_flag_scan_product($work_center, $prod_order_no, $barcode_product)
    {
        $date = date('Ymd');
        $time = date('His');
        $id = '';
        $year = '20' . substr($barcode_product, 0, 2);
        $month = (int)substr($barcode_product, 2, 2);
        $day = (int)substr($barcode_product, 4, 2);
        $hour = (int)substr($barcode_product, 6, 2);
        $minute = (int)substr($barcode_product, 8, 2);
        $second = (int)substr($barcode_product, 10, 2);
        $model = (int)substr($barcode_product, -3);

        $scheme = $work_center;

        if ($work_center == 'ASCD02') {
            $scheme = 'PRD';
        }

        $data_one_way_normal = $this->db->query("SELECT TOP 1 CHR_SERIAL, INT_ID 
            FROM PRD.TT_ONE_WAY_KANBAN WHERE CHR_PRD_ORDER_NO = '$prod_order_no' AND INT_FLG_PRINT = 0 ORDER BY INT_ID ASC");

        if ($data_one_way_normal->num_rows() > 0) {
            $id = $data_one_way_normal->row()->INT_ID;
        } else {
            $data_one_way_abnormal = $this->db->query("SELECT TOP 1 CHR_SERIAL, INT_ID  FROM PRD.TT_ONE_WAY_KANBAN WHERE CHR_PRD_ORDER_NO = '$prod_order_no'
            ORDER BY INT_ID ASC");
            $id = $data_one_way_abnormal->row()->INT_ID;
        }

        $query = "UPDATE $scheme.$this->tables_name
            SET INT_FLG_SCAN = 1,  CHR_MODIFIED_BY = '$prod_order_no',  CHR_MODIFIED_DATE = '$date',   CHR_MODIFIED_TIME = '$time', INT_ID_ONE_WAY_KANBAN = '$id'
            WHERE  LEFT(CHR_PRD_ORDER_NO,6) = '$work_center' AND CHR_YEAR = '$year' AND CHR_MONTH = '$month' AND CHR_DAY = '$day' AND CHR_HOUR = '$hour' 
            AND CHR_MINUTE = '$minute' AND CHR_SECOND = '$second' AND CHR_MASTER_NO = $model";

        //===== Update for new program tester - by ANU 20211006 =====//
        $query_new = "UPDATE $scheme.$this->tables_name
            SET INT_FLG_SCAN = 1,  CHR_MODIFIED_BY = '$prod_order_no',  CHR_MODIFIED_DATE = '$date',   CHR_MODIFIED_TIME = '$time', INT_ID_ONE_WAY_KANBAN = '$id'
            WHERE  LEFT(CHR_PRD_ORDER_NO,6) = '$work_center'
            AND CHR_UNIQUE_NUMBER = '$barcode_product'";
        //===== End update =====// 

        //===== Update for new program tester - by TOROSSS 20220520 =====//
        $query_hybrid = "UPDATE $scheme.$this->tables_name
                SET INT_FLG_SCAN = 1,  CHR_MODIFIED_BY = '$prod_order_no',  CHR_MODIFIED_DATE = '$date',   CHR_MODIFIED_TIME = '$time', INT_ID_ONE_WAY_KANBAN = '$id'
                WHERE  LEFT(CHR_PRD_ORDER_NO,6) = '$work_center'
                AND CHR_UNIQUE_NUMBER LIKE '$barcode_product%'
                -- AND RIGHT(RTRIM(CHR_UNIQUE_NUMBER),22) LIKE RIGHT(RTRIM('$barcode_product%'),23)
                ";
                
        //===== End update =====// 

        if ($work_center == 'ASCD02') {
            $this->db->query($query);
        }
        //===== Update for new program tester - by ANU 20211006 =====//
        else if ($work_center == 'ASDL06' || $work_center == 'ASIM04') {
            $db_iot = $this->load->database("db_iot", TRUE);
            $db_iot->query($query_new);
        }
        else if ($work_center == 'ASHV01') { 
            $db_iot = $this->load->database("db_iot", TRUE);
            $db_iot->query($query_hybrid);
        } 
        else {
            $db_iot = $this->load->database("db_iot", TRUE);
            $db_iot->query($query);
        }
    }
}
