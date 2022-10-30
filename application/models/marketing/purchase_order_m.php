<?php

class purchase_order_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //grid table
    function select_data_purchase_order($cus_po, $cus_no) {
        return $this->db->query("SELECT L.CHR_DOK_TO, L.CHR_CUS_PART_NO, L.CHR_PART_NAME,  H.CHR_CUS_PO, L.INT_TOT_QTY, 
                    ISNULL(SUM(DI.INT_ACTUAL_DEL),0) AS INT_ACTUAL_DEL, 
                    ISNULL(SUM(DI.INT_ACTUAL_DEL),0)- L.INT_TOT_QTY AS INT_BALANCE
                    FROM TT_CUST_FORECAST_L L
                    INNER JOIN TT_CUST_FORECAST_H H ON L.CHR_SO_NO = H.CHR_SO_NO
                    INNER JOIN TT_DELIVERY D ON D.CHR_PO_NO = H.CHR_CUS_PO AND D.CHR_CUS_NO = H.CHR_CUST_NO AND D.CHR_GI_DEL = 'C'
                    AND L.CHR_DOK_TO = D.CHR_DOK_NO
                    LEFT JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO AND L.CHR_CUS_PART_NO = DI.CHR_CUST_PART_NO
                    WHERE H.CHR_CUS_PO = '$cus_po' AND D.CHR_CUS_NO LIKE '$cus_no' 
                        AND DI.INT_ACTUAL_DEL > 0
                        AND DI.CHR_DELETE_FLAG IS NULL
                        AND D.CHR_DELETE_FLAG IS NULL
                        AND D.CHR_GI_DEL = 'C'
                    GROUP BY L.CHR_CUS_PART_NO, L.CHR_PART_NAME,  H.CHR_CUS_PO, L.INT_TOT_QTY , L.CHR_DOK_TO")->result();
    }

    function get_all_cust_no_by_date($start_date, $finish_date) {
        $query = $this->db->query("SELECT H.CHR_CUS_PO
                    FROM TT_CUST_FORECAST_L L
                    INNER JOIN TT_CUST_FORECAST_H H ON L.CHR_SO_NO = H.CHR_SO_NO
                    INNER JOIN TT_DELIVERY D ON D.CHR_PO_NO = H.CHR_CUS_PO AND D.CHR_CUS_NO = H.CHR_CUST_NO AND D.CHR_GI_DEL = 'C'
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE H.CHR_START_DATE >= '$start_date' AND H.CHR_END_DATE <= '$finish_date' 
                    GROUP BY  H.CHR_CUS_PO ORDER BY H.CHR_CUS_PO");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_cust_no_by_date($start_date, $finish_date) {
        $query = $this->db->query("SELECT TOP 1 H.CHR_CUS_PO
                    FROM TT_CUST_FORECAST_L L
                    INNER JOIN TT_CUST_FORECAST_H H ON L.CHR_SO_NO = H.CHR_SO_NO
                    INNER JOIN TT_DELIVERY D ON D.CHR_PO_NO = H.CHR_CUS_PO AND D.CHR_CUS_NO = H.CHR_CUST_NO AND D.CHR_GI_DEL = 'C'
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE H.CHR_START_DATE >= '$start_date' AND H.CHR_END_DATE <= '$finish_date' 
                    GROUP BY  H.CHR_CUS_PO ORDER BY H.CHR_CUS_PO");

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_CUS_PO;
        } else {
            return 0;
        }
    }

    function get_all_cust_po_by_cust($cus_no) {
        $stored_procedure = "EXEC DEL.zsp_get_customer_po_c_type ?";
        $param = array(
            'cus_no' => $cus_no);

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_cut_po_by_cust($cus_no) {
        $stored_procedure = "EXEC DEL.zsp_get_top_1_customer_po_c_type ?";
        $param = array(
            'cus_no' => $cus_no);

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_CUS_PO;
        } else {
            return 0;
        }
    }

    function get_all_cust_no() {
        $query = $this->db->query("SELECT CHR_CUS_NO FROM TT_DELIVERY GROUP BY CHR_CUS_NO ORDER BY CHR_CUS_NO");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_cust_no() {
        $query = $this->db->query("SELECT TOP 1 CHR_CUS_NO FROM TT_DELIVERY GROUP BY CHR_CUS_NO ORDER BY CHR_CUS_NO");

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_CUS_NO;
        } else {
            return 0;
        }
    }

}
?>

