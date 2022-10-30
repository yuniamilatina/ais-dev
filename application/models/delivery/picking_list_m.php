<?php

class picking_list_m extends CI_Model {  
    
    function __construct() {
        parent::__construct();
    }
    
    function select_pickup_export($start_date, $finish_date, $start_time, $finish_time) {
        $start_date_param = $start_date.$start_time;        
        $finish_date_param = $finish_date.$finish_time;

        $query = $this->db->query("SELECT PU.CHR_IDPACKING, PU.CHR_IDPALLET,PU.CHR_NPK, C.CHR_CUST_NAME, PU.CHR_NOPO_CUST, 
	U.CHR_USERNAME,RIGHT(PU.CHR_DATE_SCAN,2) + '-' + SUBSTRING(PU.CHR_DATE_SCAN,5,2) + '-' + LEFT(PU.CHR_DATE_SCAN,4) AS CHR_DATE_SCAN, PU.CHR_TIME_SCAN
        FROM TT_PACKING_UPLOAD PU
                INNER JOIN TM_CUST C ON C.CHR_CUST_NO = PU.CHR_CUST_CODE
                --INNER JOIN TT_GOODS_MOVEMENT_H GMH ON PU.CHR_IDPACKING = GMH.CHR_REMARKS 
                LEFT JOIN TT_GOODS_MOVEMENT_H GMH ON PU.CHR_IDPACKING = GMH.CHR_REMARKS 
                LEFT JOIN TM_NAME_EMPLOYEE U ON U.CHR_NPK = PU.CHR_NPK
                WHERE 
                --LEFT(GMH.CHR_REMARKS,4) = 'PACK' AND 
                PU.CHR_DATE_SCAN + PU.CHR_TIME_SCAN  >= '$start_date_param'
                AND PU.CHR_DATE_SCAN + PU.CHR_TIME_SCAN  <= '$finish_date_param'
        GROUP BY PU.CHR_IDPACKING, PU.CHR_IDPALLET,PU.CHR_NPK,
        U.CHR_USERNAME,PU.CHR_DATE_SCAN, PU.CHR_TIME_SCAN, C.CHR_CUST_NAME, PU.CHR_NOPO_CUST
        ORDER BY PU.CHR_DATE_SCAN, PU.CHR_TIME_SCAN");

        return $query->result();
    }
    
    function delete($id_packing){
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('CHR_IDPACKING', $id_packing);
        $this->db->update('TT_PACKING_UPLOAD', $data);
    }

    function get_list_data_packing_by_idpallet($start_date, $end_date, $list_pallet){
        $data = $this->db->query("SELECT CHR_IDPALLET, A.CHR_PART_NO, B.CHR_PART_NAME, A.CHR_BACK_NO, A.CHR_PARTNO_CUST, A.CHR_NOPO_CUST, A.CHR_CUST_CODE, CHR_DATE_DELIVERY, 
                                CHR_INVOICE_NO, CHR_PEB_NO, CHR_CONTAINER_NO, CHR_VESSEL_NO, CHR_DATE_DELIVERY_PEB, 
                                A.INT_QTY_PER_BOX, INT_QTY_PREPARE, CHR_COUNTRY, CHR_PALLET_SIZE
                                FROM TT_PACKING_UPLOAD A
                                LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                                WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_IDPALLET IN ($list_pallet) AND A.INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1' ORDER BY CHR_IDPALLET"); 
        return $data->result();
    }

    function get_list_data_packing_by_po($start_date, $end_date, $list_po){
        $data = $this->db->query("SELECT CHR_IDPALLET, A.CHR_PART_NO, B.CHR_PART_NAME, A.CHR_BACK_NO, A.CHR_PARTNO_CUST, A.CHR_NOPO_CUST, A.CHR_CUST_CODE, CHR_DATE_DELIVERY, 
                            CHR_INVOICE_NO, CHR_PEB_NO, CHR_CONTAINER_NO, CHR_VESSEL_NO, CHR_DATE_DELIVERY_PEB, 
                            A.INT_QTY_PER_BOX, INT_QTY_PREPARE, CHR_COUNTRY, CHR_PALLET_SIZE
                            FROM TT_PACKING_UPLOAD A 
                            LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                            WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_NOPO_CUST IN ($list_po) AND A.INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1' ORDER BY CHR_IDPALLET"); 
        return $data->result();
    }

    function get_list_data_packing_by_inc($start_date, $end_date, $list_inv){
        $data = $this->db->query("SELECT CHR_IDPALLET, A.CHR_PART_NO, B.CHR_PART_NAME, A.CHR_BACK_NO, A.CHR_PARTNO_CUST, A.CHR_NOPO_CUST, A.CHR_CUST_CODE, CHR_DATE_DELIVERY, 
                            CHR_INVOICE_NO, CHR_PEB_NO, CHR_CONTAINER_NO, CHR_VESSEL_NO, CHR_DATE_DELIVERY_PEB, 
                            A.INT_QTY_PER_BOX, INT_QTY_PREPARE, CHR_COUNTRY, CHR_PALLET_SIZE
                            FROM TT_PACKING_UPLOAD A
                            LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                            WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_INVOICE_NO IN ($list_inv) AND A.INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1' ORDER BY CHR_IDPALLET"); 
        return $data->result();
    }

    function get_summ_export_by_partno_by_idpallet($start_date, $end_date, $list_pallet){
        $data = $this->db->query("SELECT SUBSTRING(CHR_CUST_CODE,1,5) + RTRIM(A.CHR_PART_NO) AS ID, A.CHR_PART_NO, A.CHR_BACK_NO, CHR_PARTNO_CUST, RTRIM(B.CHR_PART_NAME) AS PART_NAME, CHR_CUST_CODE, A.INT_QTY_PER_BOX, SUM((INT_QTY_PREPARE/A.INT_QTY_PER_BOX)) AS QTY_BOX, SUM(INT_QTY_PREPARE) AS QTY_PCS
                                    FROM TT_PACKING_UPLOAD A  
                                    LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                                    WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_IDPALLET IN ($list_pallet) AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'
                                    GROUP By A.CHR_PART_NO, A.CHR_BACK_NO, CHR_PARTNO_CUST, B.CHR_PART_NAME, CHR_CUST_CODE, A.INT_QTY_PER_BOX");
        return $data->result();
    }

    function get_summ_export_by_partno_by_po($start_date, $end_date, $list_po){
        $data = $this->db->query("SELECT SUBSTRING(CHR_CUST_CODE,1,5) + RTRIM(A.CHR_PART_NO) AS ID, A.CHR_PART_NO, A.CHR_BACK_NO, CHR_PARTNO_CUST, RTRIM(B.CHR_PART_NAME) AS PART_NAME, CHR_CUST_CODE, A.INT_QTY_PER_BOX, SUM((INT_QTY_PREPARE/A.INT_QTY_PER_BOX)) AS QTY_BOX, SUM(INT_QTY_PREPARE) AS QTY_PCS
                                    FROM TT_PACKING_UPLOAD A  
                                    LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                                    WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_NOPO_CUST IN ($list_po) AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'
                                    GROUP By A.CHR_PART_NO, A.CHR_BACK_NO, CHR_PARTNO_CUST, B.CHR_PART_NAME, CHR_CUST_CODE, A.INT_QTY_PER_BOX");
        return $data->result();
    }

    function get_summ_export_by_partno_by_inv($start_date, $end_date, $list_inv){
        $data = $this->db->query("SELECT SUBSTRING(CHR_CUST_CODE,1,5) + RTRIM(A.CHR_PART_NO) AS ID, A.CHR_PART_NO, A.CHR_BACK_NO, CHR_PARTNO_CUST, RTRIM(B.CHR_PART_NAME) AS PART_NAME, CHR_CUST_CODE, A.INT_QTY_PER_BOX, SUM((INT_QTY_PREPARE/A.INT_QTY_PER_BOX)) AS QTY_BOX, SUM(INT_QTY_PREPARE) AS QTY_PCS
                                    FROM TT_PACKING_UPLOAD A  
                                    LEFT JOIN TM_PARTS B ON A.CHR_PART_NO = B.CHR_PART_NO
                                    WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_INVOICE_NO IN ($list_inv) AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'
                                    GROUP By A.CHR_PART_NO, A.CHR_BACK_NO, CHR_PARTNO_CUST, B.CHR_PART_NAME, CHR_CUST_CODE, A.INT_QTY_PER_BOX");
        return $data->result();
    }

    function get_list_selected_pallet_by_idpallet($start_date, $end_date, $list_pallet){
        $data = $this->db->query("SELECT DISTINCT CHR_IDPALLET FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_IDPALLET IN ($list_pallet) AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1' ORDER BY CHR_IDPALLET");
        return $data->result();
    }

    function get_list_selected_pallet_by_po($start_date, $end_date, $list_po){
        $data = $this->db->query("SELECT DISTINCT CHR_IDPALLET FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_NOPO_CUST IN ($list_po) AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1' ORDER BY CHR_IDPALLET");
        return $data->result();
    }

    function get_list_selected_pallet_by_inv($start_date, $end_date, $list_inv){
        $data = $this->db->query("SELECT DISTINCT CHR_IDPALLET FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND CHR_INVOICE_NO IN ($list_inv) AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1' ORDER BY CHR_IDPALLET");
        return $data->result();
    }

    function get_list_idpallet($start_date, $end_date){
        $data = $this->db->query("SELECT DISTINCT CHR_IDPALLET FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'");
        return $data->result();
    }

    function get_list_po_no($start_date, $end_date){
        $data = $this->db->query("SELECT DISTINCT CHR_NOPO_CUST FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'");
        return $data->result();
    }

    function get_list_inv_no($start_date, $end_date){
        $data = $this->db->query("SELECT DISTINCT CHR_INVOICE_NO FROM TT_PACKING_UPLOAD WHERE (CHR_DATE_DELIVERY BETWEEN '$start_date' AND '$end_date') AND INT_FLG_DEL = '0' AND CHR_PREPARE_STATUS = '1'");
        return $data->result();
    }

    function get_history_movement_by_date($start_date, $end_date){
        $data = $this->db->query("SELECT X.CHR_IDPALLET_WH, X.CHR_IDPACKING, X.CHR_IDPALLET, X.INT_NOPALLET, X.CHR_PART_NO, X.CHR_BACK_NO, X.CHR_PART_NAME, X.CHR_PARTNO_CUST, X.CHR_PALLET_SIZE, X.INT_QTY_PREPARE, X.INT_QTY_PER_BOX, X.CHR_DATE_DELIVERY, X.CHR_NOPO_CUST,
                                            X.CHR_TYPE AS TYPE_OUT, X.CHR_SLOC_FROM AS SLOC_FROM_OUT, X.CHR_SLOC_TO AS SLOC_TO_OUT, X.INT_QTY AS QTY_OUT, X.INT_FLG_MOVE AS FLG_MOVE_OUT, X.INT_ID_MOVEMENT AS ID_MOVE_OUT, X.CHR_CREATED_DATE AS DATE_OUT, X.CHR_CREATED_TIME AS TIME_OUT,
                                            Y.CHR_TYPE AS TYPE_IN, Y.CHR_SLOC_FROM AS SLOC_FROM_IN, Y.CHR_SLOC_TO AS SLOC_TO_IN, Y.INT_QTY AS QTY_IN, Y.INT_FLG_MOVE AS FLG_MOVE_IN, Y.INT_ID_MOVEMENT AS ID_MOVE_IN, Y.CHR_CREATED_DATE AS DATE_IN, Y.CHR_CREATED_TIME AS TIME_IN
                                    FROM (SELECT A.CHR_IDPALLET_WH, A.CHR_IDPALLET, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_TYPE, A.CHR_SLOC_FROM, A.CHR_SLOC_TO, A.INT_QTY, A.INT_FLG_MOVE, A.INT_ID_MOVEMENT, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME,
                                            B.CHR_IDPACKING, B.INT_NOPALLET, B.CHR_PARTNO_CUST, B.CHR_PALLET_SIZE, B.INT_QTY_PREPARE, B.INT_QTY_PER_BOX, B.CHR_DATE_DELIVERY, B.CHR_NOPO_CUST, C.CHR_PART_NAME
                                        FROM TT_HISTORY_MOVEMENT_PALLET A 
                                        LEFT JOIN TT_PACKING_UPLOAD B ON A.CHR_IDPALLET = B.CHR_IDPALLET AND A.CHR_PART_NO = B.CHR_PART_NO
                                        LEFT JOIN TM_PARTS C ON A.CHR_PART_NO = C.CHR_PART_NO
                                        WHERE (A.CHR_TYPE = 'OUT') AND (A.CHR_CREATED_DATE BETWEEN '$start_date' AND '$end_date') AND (A.INT_FLG_DEL = '0')) AS X
                                    LEFT JOIN (SELECT CHR_IDPALLET_WH, CHR_IDPALLET, CHR_PART_NO, CHR_TYPE, CHR_SLOC_FROM, CHR_SLOC_TO, INT_QTY, INT_FLG_MOVE, INT_ID_MOVEMENT, CHR_CREATED_DATE, CHR_CREATED_TIME
                                            FROM TT_HISTORY_MOVEMENT_PALLET
                                            WHERE (CHR_TYPE = 'IN')) AS Y ON X.CHR_IDPALLET_WH = Y.CHR_IDPALLET_WH AND X.CHR_IDPALLET = Y.CHR_IDPALLET AND X.CHR_PART_NO = Y.CHR_PART_NO");
        return $data;
    }

}
