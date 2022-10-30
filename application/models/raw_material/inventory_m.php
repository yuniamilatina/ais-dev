<?php

class inventory_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //chart
    function select_summary_inventory_by_prod() {
        $stored_procedure = "EXEC INV.zsp_get_negative_stock_summary_by_dept";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //total row
    function select_total_row() {
        $stored_procedure = "EXEC INV.zsp_get_negative_stock_summary_by_dept";

        $query = $this->db->query($stored_procedure);
        return $query->num_rows();
    }

    //grid table
    function select_data_inventory_by_prod() {
        $stored_procedure = "EXEC INV.zsp_get_negative_stock_detail";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //Get all data inventory
    function total_data_stock() {
        $stored_procedure = "EXEC INV.zsp_get_negative_stock_summary";

        $query = $this->db->query($stored_procedure);
        return $query->row();
    }
    
    //Get all data inventory
    function check_stat_in_out_tmstock() {
        $query = "select CHR_STAT from  TW_INTERFACE_STOCK where CHR_PROCESS_NAME = 'IN_OUT_STOCK'";

        $stat = $this->db->query($query)->row();
        return $stat->CHR_STAT;
    }

    function select_detail_part_in_out($part_no) {
        $query = $this->db->query("SELECT DISTINCT P.CHR_PART_NAME, K.CHR_BACK_NO, OI.CHR_PART_NO, OI.CHR_SLOC, CHR_MOV_TYPE, INT_TOTAL, CHR_FLG, DATE_1, DATE_2, DATE_3, DATE_4, DATE_5, DATE_6, DATE_7, DATE_8, DATE_9, 
						  DATE_10, DATE_11, DATE_12, DATE_13, DATE_14, DATE_15, DATE_16, DATE_17, DATE_18, DATE_19, DATE_20, DATE_21, DATE_22, DATE_23, DATE_24, DATE_25, 
						  DATE_26, DATE_27, DATE_28, DATE_29, DATE_30, DATE_31, FLT_AVE, FLT_PRICE, S.CHR_STD_PRICE
                                    FROM TW_DETAIL_IN_OUT OI 
                                    INNER JOIN TM_STOCK S ON OI.CHR_PART_NO = S.CHR_PART_NO AND S.CHR_SLOC = OI.CHR_SLOC
                                    AND S.CHR_SLOC IN ('WP01','PP01','PP02','PP03') AND S.CHR_PART_NO = '$part_no'
                                    INNER JOIN TM_PARTS P ON P.CHR_PART_NO = S.CHR_PART_NO 
                                    INNER JOIN TM_KANBAN K ON K.CHR_PART_NO = P.CHR_PART_NO  AND P.CHR_BACK_NO = K.CHR_BACK_NO
                                    ");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

}
?>

