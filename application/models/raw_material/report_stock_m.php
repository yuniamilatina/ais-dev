<?php

class report_stock_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Get all data inventory
    function select_data_stock() {
        $this->db->select("STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, STO.CHR_MAT_TYPE, CHR_MAT_TYPE_NAME,
                                        CASE WHEN K.CHR_BACK_NO = '' THEN '-' ELSE ISNULL(K.CHR_BACK_NO,'-') END AS CHR_BACK_NO, 
                                        ISNULL(P.CHR_PART_NAME,'-') AS CHR_PART_NAME,
                                        STO.INT_TOTAL_QTY, ISNULL(P.CHR_PART_UOM,'-') AS CHR_PART_UOM,

                                        (CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY) AS CHR_TOTAL_PRICE,
                                        CONVERT(float,CHR_STD_PRICE) * 100 AS CHR_STD_PRICE

                                        FROM TM_STOCK STO 
                                        LEFT JOIN TM_KANBAN K 
                                        ON K.CHR_PART_NO = STO.CHR_PART_NO  
                                        LEFT JOIN TM_PARTS P
                                        ON P.CHR_PART_NO = STO.CHR_PART_NO");
        $this->db->where('STO.INT_FLAG_DELETE = 0  AND STO.INT_TOTAL_QTY <> 0');
        $this->db->group_by('K.CHR_PART_NO, STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, STO.CHR_MAT_TYPE, STO.CHR_MAT_TYPE_NAME,
                            K.CHR_BACK_NO, 
                            P.CHR_PART_NAME,
                            STO.INT_TOTAL_QTY, P.CHR_PART_UOM,
                            P.CHR_PART_UOM,CHR_STD_PRICE,STO.CHR_PRICE_UNIT');
        $query = $this->db->get();
        return $query->result();
    }

    //Get all data inventory
    function select_data_stock_top1000() {
        $this->db->select("STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, STO.CHR_MAT_TYPE, CHR_MAT_TYPE_NAME,
                                        CASE WHEN K.CHR_BACK_NO = '' THEN '-' ELSE ISNULL(K.CHR_BACK_NO,'-') END AS CHR_BACK_NO, 
                                        ISNULL(P.CHR_PART_NAME,'-') AS CHR_PART_NAME,
                                        STO.INT_TOTAL_QTY, ISNULL(P.CHR_PART_UOM,'-') AS CHR_PART_UOM,
                                     
                                        (CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY) AS CHR_TOTAL_PRICE,

                                        CONVERT(float,CHR_STD_PRICE) * 100 AS CHR_STD_PRICE
                                        FROM TM_STOCK STO 
                                        LEFT JOIN TM_KANBAN K 
                                        ON K.CHR_PART_NO = STO.CHR_PART_NO  
                                        LEFT JOIN TM_PARTS P
                                        ON P.CHR_PART_NO = STO.CHR_PART_NO");
        $this->db->where('STO.INT_FLAG_DELETE = 0  AND STO.INT_TOTAL_QTY <> 0');
        $this->db->group_by('K.CHR_PART_NO, STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, STO.CHR_MAT_TYPE, STO.CHR_MAT_TYPE_NAME,
                            K.CHR_BACK_NO, 
                            P.CHR_PART_NAME,
                            STO.INT_TOTAL_QTY, P.CHR_PART_UOM,
                            P.CHR_PART_UOM,CHR_STD_PRICE,CHR_PRICE_UNIT');
        $query = $this->db->get();
        return $query->result();
    }
    
    //Get all data inventory
    function total_data_stock() {
        $this->db->select("SUM((CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY)) AS TOTAL
                                FROM TM_STOCK STO 
                                LEFT JOIN TM_PARTS P
                                ON P.CHR_PART_NO = STO.CHR_PART_NO");
        $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0');

        $query = $this->db->get();
        return $query->row();
    }

    //get negatif and non negatif
    function select_data_stock_by($param, $sloc) {
        if ($sloc != NULL) {
            if ($param == true) {
                $this->db->select("STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, CHR_MAT_TYPE, CHR_MAT_TYPE_NAME,
                                        CASE WHEN K.CHR_BACK_NO = '' THEN '-' ELSE ISNULL(K.CHR_BACK_NO,'-') END AS CHR_BACK_NO,  
                                        ISNULL(P.CHR_PART_NAME,'-') AS CHR_PART_NAME,
                                        STO.INT_TOTAL_QTY, ISNULL(P.CHR_PART_UOM,'-') AS CHR_PART_UOM,
                                        (CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY) AS CHR_TOTAL_PRICE,
                                        CONVERT(float,CHR_STD_PRICE) * 100 AS CHR_STD_PRICE
                                        FROM TM_STOCK STO 
                                        LEFT JOIN TM_KANBAN K 
                                        ON K.CHR_PART_NO = STO.CHR_PART_NO  
                                        LEFT JOIN TM_PARTS P
                                        ON P.CHR_PART_NO = STO.CHR_PART_NO");
                $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0 AND STO.INT_TOTAL_QTY < 0');
                $this->db->where_in('STO.CHR_SLOC', $sloc);
                $this->db->group_by('K.CHR_PART_NO, STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, STO.CHR_MAT_TYPE, STO.CHR_MAT_TYPE_NAME,
                            K.CHR_BACK_NO, 
                            P.CHR_PART_NAME,
                            STO.INT_TOTAL_QTY, P.CHR_PART_UOM,
                            P.CHR_PART_UOM,CHR_STD_PRICE,CHR_PRICE_UNIT');
            } else {
                $this->db->select("STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, CHR_MAT_TYPE, CHR_MAT_TYPE_NAME,
                                        CASE WHEN K.CHR_BACK_NO = '' THEN '-' ELSE ISNULL(K.CHR_BACK_NO,'-') END AS CHR_BACK_NO, 
                                        ISNULL(P.CHR_PART_NAME,'-') AS CHR_PART_NAME,
                                        STO.INT_TOTAL_QTY, ISNULL(P.CHR_PART_UOM,'-') AS CHR_PART_UOM,
                                        (CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY) AS CHR_TOTAL_PRICE,
                                        CONVERT(float,CHR_STD_PRICE) * 100 AS CHR_STD_PRICE
                                        FROM TM_STOCK STO 
                                        LEFT JOIN TM_KANBAN K 
                                        ON K.CHR_PART_NO = STO.CHR_PART_NO  
                                        LEFT JOIN TM_PARTS P
                                        ON P.CHR_PART_NO = STO.CHR_PART_NO");
                $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0');
                $this->db->where_in('STO.CHR_SLOC', $sloc);
                $this->db->group_by('K.CHR_PART_NO, STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, STO.CHR_MAT_TYPE, STO.CHR_MAT_TYPE_NAME,
                            K.CHR_BACK_NO, 
                            P.CHR_PART_NAME,
                            STO.INT_TOTAL_QTY, P.CHR_PART_UOM,
                            P.CHR_PART_UOM,CHR_STD_PRICE,CHR_PRICE_UNIT');
            }
        } else {
            if ($param == true) {
                $this->db->select("STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, CHR_MAT_TYPE, CHR_MAT_TYPE_NAME,
                                        CASE WHEN K.CHR_BACK_NO = '' THEN '-' ELSE ISNULL(K.CHR_BACK_NO,'-') END AS CHR_BACK_NO, 
                                        ISNULL(P.CHR_PART_NAME,'-') AS CHR_PART_NAME,
                                        STO.INT_TOTAL_QTY, ISNULL(P.CHR_PART_UOM,'-') AS CHR_PART_UOM,
                                        (CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY) AS CHR_TOTAL_PRICE,
                                        CONVERT(float,CHR_STD_PRICE) * 100 AS CHR_STD_PRICE
                                        FROM TM_STOCK STO 
                                        LEFT JOIN TM_KANBAN K 
                                        ON K.CHR_PART_NO = STO.CHR_PART_NO  
                                        LEFT JOIN TM_PARTS P
                                        ON P.CHR_PART_NO = STO.CHR_PART_NO");
                $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0 AND STO.INT_TOTAL_QTY < 0');
                $this->db->group_by('K.CHR_PART_NO, STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, STO.CHR_MAT_TYPE, STO.CHR_MAT_TYPE_NAME,
                            K.CHR_BACK_NO, 
                            P.CHR_PART_NAME,
                            STO.INT_TOTAL_QTY, P.CHR_PART_UOM,
                            P.CHR_PART_UOM,CHR_STD_PRICE,CHR_PRICE_UNIT');
            } else {
                $this->db->select("STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, CHR_MAT_TYPE, CHR_MAT_TYPE_NAME,
                                        CASE WHEN K.CHR_BACK_NO = '' THEN '-' ELSE ISNULL(K.CHR_BACK_NO,'-') END AS CHR_BACK_NO, 
                                        ISNULL(P.CHR_PART_NAME,'-') AS CHR_PART_NAME,
                                        STO.INT_TOTAL_QTY, ISNULL(P.CHR_PART_UOM,'-') AS CHR_PART_UOM,
                                        (SELECT (CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY) AS CHR_TOTAL_PRICE,
                                        CONVERT(float,CHR_STD_PRICE) * 100 AS CHR_STD_PRICE
                                        FROM TM_STOCK STO 
                                        LEFT JOIN TM_KANBAN K 
                                        ON K.CHR_PART_NO = STO.CHR_PART_NO  
                                        LEFT JOIN TM_PARTS P
                                        ON P.CHR_PART_NO = STO.CHR_PART_NO");
                $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0');
                $this->db->group_by('K.CHR_PART_NO, STO.CHR_PART_NO, STO.CHR_VAL_CLASS, STO.CHR_VAL_CLASS_NAME, STO.CHR_SLOC, STO.CHR_MAT_TYPE, STO.CHR_MAT_TYPE_NAME,
                            K.CHR_BACK_NO, 
                            P.CHR_PART_NAME,
                            STO.INT_TOTAL_QTY, P.CHR_PART_UOM,
                            P.CHR_PART_UOM,CHR_STD_PRICE,CHR_PRICE_UNIT');
            }
        }

        $query = $this->db->get();
        return $query->result();
    }

    function total_data_stock_by($param, $sloc) {
        if ($sloc != NULL) {
            if ($param == true) {
                $this->db->select("SUM((CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY)) AS TOTAL
                                FROM TM_STOCK STO 
                                LEFT JOIN TM_PARTS P
                                ON P.CHR_PART_NO = STO.CHR_PART_NO");
                $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0 AND STO.INT_TOTAL_QTY < 0');
                $this->db->where_in('STO.CHR_SLOC', $sloc);
            } else {
                $this->db->select("SUM((CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY)) AS TOTAL
                                FROM TM_STOCK STO 
                                LEFT JOIN TM_PARTS P
                                ON P.CHR_PART_NO = STO.CHR_PART_NO");
                $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0');
                $this->db->where_in('STO.CHR_SLOC', $sloc);
            }
        } else {
            if ($param == true) {
                $this->db->select("SUM((CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY)) AS TOTAL
                                FROM TM_STOCK STO 
                                LEFT JOIN TM_PARTS P
                                ON P.CHR_PART_NO = STO.CHR_PART_NO");
                $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0 AND STO.INT_TOTAL_QTY < 0');
            } else {
                $this->db->select("SUM((CONVERT(FLOAT,STO.CHR_STD_PRICE)* 100) / (CAST(STO.CHR_PRICE_UNIT AS INT)) * (STO.INT_TOTAL_QTY)) AS TOTAL
                                FROM TM_STOCK STO 
                                LEFT JOIN TM_PARTS P
                                ON P.CHR_PART_NO = STO.CHR_PART_NO");
                $this->db->where('STO.INT_FLAG_DELETE = 0 AND STO.INT_TOTAL_QTY <> 0');
            }
        }

        $query = $this->db->get();
        return $query->row();
    }

    //get acquired date
    function select_acquired_date() {
        $query = $this->db->query("SELECT CHR_MODIFED_DATE, CHR_MODIFED_TIME
                            FROM TM_STOCK   
                            WHERE INT_FLAG_DELETE = 0 AND INT_TOTAL_QTY <> 0
                            GROUP BY CHR_MODIFED_DATE, CHR_MODIFED_TIME 
                            ORDER BY CHR_MODIFED_DATE, CHR_MODIFED_TIME DESC");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }
    
    //load to sql
    function is_load_to_sql() {
        $query = $this->db->query("SELECT CHR_STAT FROM TW_INTERFACE_STOCK WHERE CHR_PROCESS_NAME = 'INVENTORY_STOCK'")->row_array();

        return $query['CHR_STAT'];
    }
    
    //load to sql
    function is_load_to_sql_inout() {
        $query = $this->db->query("SELECT CHR_STAT FROM TW_INTERFACE_STOCK WHERE LTRIM(CHR_PROCESS_NAME) = 'IN_OUT_STOCK'")->row_array();

        return $query['CHR_STAT'];
    }

}
?>

