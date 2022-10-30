<?php

class customer_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all_customer_by_date($start_date, $finish_date) {
        $query = $this->db->query("SELECT C.CHR_CUST_NO, C.CHR_CUST_NAME FROM 
            TM_CUST C INNER JOIN TT_DELIVERY D ON C.CHR_CUST_NO = D.CHR_CUS_NO 
            WHERE D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date'
            GROUP BY C.CHR_CUST_NO, C.CHR_CUST_NAME ORDER BY C.CHR_CUST_NAME");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_customer_by_date($start_date, $finish_date) {
        $query = $this->db->query("SELECT TOP 1 C.CHR_CUST_NO , C.CHR_CUST_NAME
            FROM TM_CUST C INNER JOIN TT_DELIVERY D ON C.CHR_CUST_NO = D.CHR_CUS_NO 
            WHERE D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date'
            GROUP BY C.CHR_CUST_NO, C.CHR_CUST_NAME ORDER BY C.CHR_CUST_NAME");

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_CUST_NO;
        } else {
            return 0;
        }
    }
    
    function get_all_customer_by_date_and_period($period) {
        $query = $this->db->query("SELECT C.CHR_CUST_NO, C.CHR_CUST_NAME FROM 
            TM_CUST C INNER JOIN TT_DELIVERY D ON C.CHR_CUST_NO = D.CHR_CUS_NO 
            WHERE LEFT(D.CHR_DEL_DATE,6) = '$period'
            GROUP BY C.CHR_CUST_NO, C.CHR_CUST_NAME ORDER BY C.CHR_CUST_NAME");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_customer_by_date_and_period($period) {
        $query = $this->db->query("SELECT TOP 1 C.CHR_CUST_NO , C.CHR_CUST_NAME
            FROM TM_CUST C INNER JOIN TT_DELIVERY D ON C.CHR_CUST_NO = D.CHR_CUS_NO 
            WHERE LEFT(D.CHR_DEL_DATE,6) = '$period'
            GROUP BY C.CHR_CUST_NO, C.CHR_CUST_NAME ORDER BY C.CHR_CUST_NAME");

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_CUST_NO;
        } else {
            return 0;
        }
    }
    
    function get_all_cust_dest_by_date($start_date, $finish_date) {
        $query = $this->db->query("SELECT C.CHR_CUST_NO, C.CHR_CUST_NAME FROM 
            TM_CUST C INNER JOIN TT_DELIVERY D ON C.CHR_CUST_NO = D.CHR_CUS_DEST 
            WHERE D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date'
            GROUP BY C.CHR_CUST_NO, C.CHR_CUST_NAME ORDER BY C.CHR_CUST_NAME");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_cust_dest_by_date($start_date, $finish_date) {
        $query = $this->db->query("SELECT TOP 1 C.CHR_CUST_NO 
            FROM TM_CUST C INNER JOIN TT_DELIVERY D ON C.CHR_CUST_NO = D.CHR_CUS_DEST 
            WHERE D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date'
            GROUP BY C.CHR_CUST_NO");

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_CUST_NO;
        } else {
            return 0;
        }
    }

    function get_all_cust_dest_by_date_and_period($period) {
        $query = $this->db->query("SELECT C.CHR_CUST_NO, C.CHR_CUST_NAME FROM 
            TM_CUST C INNER JOIN TT_DELIVERY D ON C.CHR_CUST_NO = D.CHR_CUS_DEST 
            WHERE LEFT(D.CHR_DEL_DATE,6) = '$period'
            GROUP BY C.CHR_CUST_NO, C.CHR_CUST_NAME ORDER BY C.CHR_CUST_NAME");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_cust_dest_by_date_and_period($period) {
        $query = $this->db->query("SELECT TOP 1 C.CHR_CUST_NO , C.CHR_CUST_NAME
            FROM TM_CUST C INNER JOIN TT_DELIVERY D ON C.CHR_CUST_NO = D.CHR_CUS_DEST 
            WHERE LEFT(D.CHR_DEL_DATE,6) = '$period'
            GROUP BY C.CHR_CUST_NO, C.CHR_CUST_NAME ORDER BY C.CHR_CUST_NAME");

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_CUST_NO;
        } else {
            return 0;
        }
    }
    
}
?>

