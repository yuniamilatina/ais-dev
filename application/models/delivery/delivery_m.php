<?php

class delivery_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //grid table spesific date
    function select_data_actual_delivery($start_date, $finish_date, $cust, $ship, $cus_po, $cus_part_no) {
        //echo 'startdate#'.$start_date, 'finihdate#'.$finish_date, 'cust#'.$cust, 'ship#'.$ship, 'cuspo#'.$cus_po, 'custpart#'.$cus_part_no;
        //exit();
        if ($cus_po == '' && $ship == '' && $cus_part_no == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust ?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_id' => $cust);
        } else if ($cus_po == '' && $cust == '' && $cus_part_no == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust_dest ?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_dest_id' => $ship);
        } else if ($cus_po == '' && $cus_part_no == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust_dest_and_cust ?,?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_dest_id' => $ship,
                'cust_id' => $cust);
        } else if ($cus_part_no == '' && $ship == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust_and_po ?,?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_id' => $cust,
                'cus_po' => $cus_po);
        } else if ($cus_part_no == '' && $cust == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust_dest_and_po ?,?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_dest_id' => $ship,
                'cus_po' => $cus_po);
        } else if ($cus_part_no == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust_dest_and_cust_and_po ?,?,?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_dest_id' => $ship,
                'cust_id' => $cust,
                'cus_po' => $cus_po);
        } else if ($ship == '') {
            
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust_and_po_and_part ?,?,?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_id' => $cust,
                'cus_po' => $cus_po,
                'cus_part_no' => $cus_part_no);
        } else if ($ship == '' && $cus_po == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust_and_part ?,?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_id' => $cust,
                'cus_part_no' => $cus_part_no);
        } else {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_date_and_cust_dest_and_cust_and_po_and_part ?,?,?,?,?,?";
            $param = array(
                'start_date' => $start_date,
                'finish_date' => $finish_date,
                'cust_dest_id' => $ship,
                'cust_id' => $cust,
                'cus_po' => $cus_po,
                'cus_part_no' => $cus_part_no);
        }

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //grid table period
    function select_data_actual_delivery_by_period($period, $cust, $ship, $cus_po, $cus_part_no) {
//        echo $period,'per', $cust,'cust', $ship,'ship', $cus_po,'po', $cus_part_no;
//        exit();

        if ($cus_po == '' && $ship == '' && $cus_part_no == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust ?,?"; ///udah
            $param = array(
                'period' => $period,
                'cust_id' => $cust);
        } else if ($cus_po == '' && $cust == '' && $cus_part_no == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust_dest ?,?"; //udah
            $param = array(
                'period' => $period,
                'cust_dest_id' => $ship);
        } else if ($cus_po == '' && $cus_part_no == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust_dest_and_cust ?,?,?"; //udah
            $param = array(
                'period' => $period,
                'cust_dest_id' => $ship,
                'cust_id' => $cust);
        } else if ($cus_part_no == '' && $ship == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust_and_po ?,?,?"; //udah
            $param = array(
                'period' => $period,
                'cust_id' => $cust,
                'cus_po' => $cus_po);
        } else if ($cus_part_no == '' && $cust == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust_dest_and_po ?,?,?"; //udah
            $param = array(
                'period' => $period,
                'cust_dest_id' => $ship,
                'cus_po' => $cus_po);
        } else if ($cus_part_no == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust_dest_and_cust_and_po ?,?,?,?";
            $param = array(
                'period' => $period,
                'cust_dest_id' => $ship,
                'cust_id' => $cust,
                'cus_po' => $cus_po);
        } else if ($ship == '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust_and_po_and_part ?,?,?,?";
            $param = array(
                'period' => $period,
                'cust_id' => $cust,
                'cus_po' => $cus_po,
                'cus_part_no' => $cus_part_no);
        } else if ($ship == '' && $cus_po = '') {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust_and_part ?,?,?";
            $param = array(
                'period' => $period,
                'cust_id' => $cust,
                'cus_part_no' => $cus_part_no);
        } else {
            $stored_procedure = "MKT.zsp_get_data_delivery_actual_by_period_and_cust_dest_and_cust_and_po_and_part ?,?,?,?,?";
            $param = array(
                'period' => $period,
                'cust_dest_id' => $ship,
                'cust_id' => $cust,
                'cus_po' => $cus_po,
                'cus_part_no' => $cus_part_no);
        }

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_all_cust_po_by_date_and_customer_and_customer_dest($start_date, $finish_date, $cust, $ship) {
        if ($ship == '') {
            $query = $this->db->query("SELECT D.CHR_PO_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_PO_NO <> '' 
                    AND D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date' 
                    AND D.CHR_CUS_NO = '$cust'
                    GROUP BY  D.CHR_PO_NO");
        } else if ($cust == '') {
            $query = $this->db->query("SELECT D.CHR_PO_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_PO_NO <> '' 
                    AND D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date' 
                    AND D.CHR_CUS_DEST = '$ship'
                    GROUP BY  D.CHR_PO_NO");
        } else {
            $query = $this->db->query("SELECT D.CHR_PO_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_PO_NO <> '' 
                    AND D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date' 
                    AND D.CHR_CUS_NO = '$cust' AND D.CHR_CUS_DEST = '$ship'
                    GROUP BY  D.CHR_PO_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_cust_po_by_date_and_customer_and_customer_des($start_date, $finish_date, $cust, $ship) {
        $query = $this->db->query("SELECT TOP 1 D.CHR_PO_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_PO_NO <> '' 
                    AND D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date' 
                        AND D.CHR_CUS_NO = '$cust' AND	D.CHR_CUS_DEST = '$ship'
                    GROUP BY  D.CHR_PO_NO");

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_PO_NO;
        } else {
            return 0;
        }
    }

    function get_all_cust_po_by_date_and_customer_and_customer_dest_and_period($period, $cust, $ship) {
        if ($ship == '') {
            $query = $this->db->query("SELECT D.CHR_PO_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_PO_NO <> '' 
                        AND LEFT(D.CHR_DEL_DATE,6) = '$period'
                        AND D.CHR_CUS_NO = '$cust' 
                        AND D.CHR_PO_NO IS NOT NULL AND D.CHR_PO_NO <> ''
                    GROUP BY  D.CHR_PO_NO ORDER BY D.CHR_PO_NO");
        } else if ($cust == '') {
            $query = $this->db->query("SELECT D.CHR_PO_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_PO_NO <> '' 
                        AND LEFT(D.CHR_DEL_DATE,6) = '$period'
                        AND D.CHR_CUS_DEST = '$ship'
                        AND D.CHR_PO_NO IS NOT NULL AND D.CHR_PO_NO <> ''
                    GROUP BY  D.CHR_PO_NO ORDER BY D.CHR_PO_NO");
        } else {
            $query = $this->db->query("SELECT D.CHR_PO_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_PO_NO <> '' 
                        AND LEFT(D.CHR_DEL_DATE,6) = '$period'
                        AND D.CHR_CUS_NO = '$cust' AND	D.CHR_CUS_DEST = '$ship'
                        AND D.CHR_PO_NO IS NOT NULL AND D.CHR_PO_NO <> ''
                    GROUP BY  D.CHR_PO_NO ORDER BY D.CHR_PO_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_cust_po_by_date_and_customer_and_customer_des_and_period($period, $cust, $ship) {
        $query = $this->db->query("SELECT TOP 1 D.CHR_PO_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_PO_NO <> '' 
                        AND LEFT(D.CHR_DEL_DATE,6) = '$period' 
                        AND D.CHR_CUS_NO = '$cust' AND	D.CHR_CUS_DEST = '$ship'
                    GROUP BY  D.CHR_PO_NO");

        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->CHR_PO_NO;
        } else {
            return 0;
        }
    }

    function get_all_cust_part_no($start_date, $finish_date, $cust, $ship, $cus_po) {
        if ($ship == '') {
            $query = $this->db->query("SELECT DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date' 
                        AND D.CHR_CUS_NO = '$cust' 
                        AND D.CHR_PO_NO = '$cus_po'
                    GROUP BY DI.CHR_CUST_PART_NO ORDER BY DI.CHR_CUST_PART_NO");
        } else if ($cust == '') {
            $query = $this->db->query("SELECT DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date' 
                        AND D.CHR_CUS_DEST = '$ship'
                        AND D.CHR_PO_NO = '$cus_po'
                    GROUP BY DI.CHR_CUST_PART_NO ORDER BY DI.CHR_CUST_PART_NO");
        } else if ($ship == '' && $cus_po == '') {
            $query = $this->db->query("SELECT DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date' 
                        AND D.CHR_CUS_NO = '$cust'
                    GROUP BY DI.CHR_CUST_PART_NO ORDER BY DI.CHR_CUST_PART_NO");
        } else {
            $query = $this->db->query("SELECT DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE D.CHR_DEL_DATE >= '$start_date' AND D.CHR_DEL_DATE <= '$finish_date' 
                        AND D.CHR_CUS_NO = '$cust' AND	D.CHR_CUS_DEST = '$ship'
                        AND D.CHR_PO_NO = '$cus_po'
                    GROUP BY DI.CHR_CUST_PART_NO ORDER BY DI.CHR_CUST_PART_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_all_cust_part_no_by_period($period, $cust, $ship, $cus_po) {
        if ($ship == '') {
            $query = $this->db->query("SELECT DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE LEFT(D.CHR_DEL_DATE,6) = '$period' 
                        AND D.CHR_CUS_NO = '$cust'
                        AND D.CHR_PO_NO = '$cus_po'
                    GROUP BY DI.CHR_CUST_PART_NO ORDER BY DI.CHR_CUST_PART_NO");
        } else if ($cust == '') {
            $query = $this->db->query("SELECT DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE LEFT(D.CHR_DEL_DATE,6) = '$period' 
                        AND D.CHR_CUS_DEST = '$ship'
                        AND D.CHR_PO_NO = '$cus_po'
                    GROUP BY DI.CHR_CUST_PART_NO ORDER BY DI.CHR_CUST_PART_NO");
        } else if ($ship == '' && $cus_po == '') {
            $query = $this->db->query("SELECT DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE LEFT(D.CHR_DEL_DATE,6) = '$period' 
                        AND D.CHR_CUS_NO = '$cust'
                    GROUP BY DI.CHR_CUST_PART_NO ORDER BY DI.CHR_CUST_PART_NO");
        } else {
            $query = $this->db->query("SELECT DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE LEFT(D.CHR_DEL_DATE,6) = '$period' 
                        AND D.CHR_CUS_NO = '$cust' AND	D.CHR_CUS_DEST = '$ship'
                        AND D.CHR_PO_NO = '$cus_po'
                    GROUP BY DI.CHR_CUST_PART_NO ORDER BY DI.CHR_CUST_PART_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_first_cust_part_no_by_period($period, $cust, $ship, $cus_po) {
        $query = $this->db->query("SELECT TOP 1 DI.CHR_CUST_PART_NO
                    FROM TT_DELIVERY D
                    INNER JOIN TT_DELIVERY_ITEM DI ON D.CHR_DEL_NO = DI.CHR_DEL_NO
                    WHERE LEFT(D.CHR_DEL_DATE,6) = '$period' 
                        AND D.CHR_CUS_NO = '$cust' AND	D.CHR_CUS_DEST = '$ship'
                        AND D.CHR_PO_NO = '$cus_po'
                    GROUP BY DI.CHR_CUST_PART_NO");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

}
?>

