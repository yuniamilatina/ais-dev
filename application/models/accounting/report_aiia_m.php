<?php

class report_aiia_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
   
    function get_data_delivery_aiia($periode){
        $data = $this->db->query("SELECT CHR_DEL_NO, CHR_PICKING_NO, CHR_BILL_NO, CHR_DEST_NO, CHR_GATE_ID, CHR_DOC_DATE, 
                                    CHR_DELIVERY_DATE, CHR_PDS_NO, CHR_ERROR_LOG, CHR_DEL_TYPE_DESC, CHR_BILL_NAME, CHR_DEST_NAME,
                                    CHR_KAT_PART, CHR_KAT_PART_DESC, CHR_PO_NO, CHR_TRUCK_DEL, CHR_CREATE_DATE, CHR_UPDATE_DATE,
                                    INT_DELETE_FLAG, INT_SEND_FLAG, INT_STATUS_ERROR
                                FROM TT_DELV_H
                                WHERE CHR_DELIVERY_DATE LIKE '$periode%'
                                ORDER BY CHR_DELIVERY_DATE DESC")->result();
        return $data;
    }

    function get_data_delivery_aiia_by_date($start_date, $end_date){
        $data = $this->db->query("SELECT CHR_DEL_NO, CHR_PICKING_NO, CHR_BILL_NO, CHR_DEST_NO, CHR_GATE_ID, CHR_DOC_DATE, 
                                    CHR_DELIVERY_DATE, CHR_PDS_NO, CHR_ERROR_LOG, CHR_DEL_TYPE_DESC, CHR_BILL_NAME, CHR_DEST_NAME,
                                    CHR_KAT_PART, CHR_KAT_PART_DESC, CHR_PO_NO, CHR_TRUCK_DEL, CHR_CREATE_DATE, CHR_UPDATE_DATE,
                                    INT_DELETE_FLAG, INT_SEND_FLAG, INT_STATUS_ERROR
                                FROM TT_DELV_H
                                WHERE CHR_DELIVERY_DATE BETWEEN '$start_date' AND '$end_date'
                                ORDER BY CHR_DELIVERY_DATE DESC")->result();
        return $data;
    }

    function get_rekap_delivery_aiia($periode){
        $data = $this->db->query("SELECT A.CHR_DEL_NO, A.CHR_PICKING_NO, A.CHR_BILL_NO, A.CHR_DEST_NO, A.CHR_GATE_ID, A.INT_DELETE_FLAG, A.CHR_DELIVERY_DATE, A.CHR_PDS_NO, A.CHR_BILL_NAME, 
                                        A.CHR_DEST_NAME, A.CHR_DEL_TYPE_DESC, A.CHR_KAT_PART, A.CHR_KAT_PART_DESC, A.CHR_PO_NO, A.CHR_PICK_TIME, B.INT_DEL_ITEM, B.CHR_PART_NO, B.CHR_NO_FORECAST, 
                                        B.CHR_FORE_ITM, B.CHR_CUS_PART_NO, B.CHR_PART_NAME, B.INT_TOT_KANBAN, B.INT_QTY_KANBAN, B.INT_TOT_QTY, B.CHR_PART_UOM, B.CHR_CREATE_PC AS Expr2, 
                                        B.CHR_CREATE_BY AS Expr3, B.CHR_UPDATE_BY AS Expr4, B.CHR_CREATE_DATE AS Expr5, B.CHR_UPDATE_DATE AS Expr6, B.CHR_SAP_DEL_NO, B.CHR_SAP_DEL_ITEM, 
                                        B.CHR_SAP_MATDOC_NO, B.CHR_SAP_PO_NO, B.CHR_SAP_PO_ITEM, B.CHR_SAP_MATDOC_YEAR
                                FROM TT_DELV_H AS A INNER JOIN TT_DELV_L AS B ON A.CHR_DEL_NO = B.CHR_DEL_NO
                                WHERE (A.CHR_DELIVERY_DATE LIKE '$periode%')")->result();
        return $data;
    }

    function get_rekap_delivery_aiia_by_date($start_date, $end_date){
        $data = $this->db->query("SELECT A.CHR_DEL_NO, A.CHR_PICKING_NO, A.CHR_BILL_NO, A.CHR_DEST_NO, A.CHR_GATE_ID, A.INT_DELETE_FLAG, A.CHR_DELIVERY_DATE, A.CHR_PDS_NO, A.CHR_BILL_NAME, 
                                        A.CHR_DEST_NAME, A.CHR_DEL_TYPE_DESC, A.CHR_KAT_PART, A.CHR_KAT_PART_DESC, A.CHR_PO_NO, A.CHR_PICK_TIME, B.INT_DEL_ITEM, B.CHR_PART_NO, B.CHR_NO_FORECAST, 
                                        B.CHR_FORE_ITM, B.CHR_CUS_PART_NO, B.CHR_PART_NAME, B.INT_TOT_KANBAN, B.INT_QTY_KANBAN, B.INT_TOT_QTY, B.CHR_PART_UOM, B.CHR_CREATE_PC AS Expr2, 
                                        B.CHR_CREATE_BY AS Expr3, B.CHR_UPDATE_BY AS Expr4, B.CHR_CREATE_DATE AS Expr5, B.CHR_UPDATE_DATE AS Expr6, B.CHR_SAP_DEL_NO, B.CHR_SAP_DEL_ITEM, 
                                        B.CHR_SAP_MATDOC_NO, B.CHR_SAP_PO_NO, B.CHR_SAP_PO_ITEM, B.CHR_SAP_MATDOC_YEAR
                                FROM TT_DELV_H AS A INNER JOIN TT_DELV_L AS B ON A.CHR_DEL_NO = B.CHR_DEL_NO
                                WHERE (A.CHR_DELIVERY_DATE BETWEEN '$start_date' AND '$end_date')")->result();
        return $data;
    }

    function get_status_delete_sj(){
        $data = $this->db->query("SELECT INT_FLG_ACTIVE FROM TM_FI_FUNCTION_STATE WHERE CHR_FUNCTION_CODE = 'DELDO'")->row();

        return $data;
    }

    function get_status_backdate_sj(){
        $data = $this->db->query("SELECT INT_FLG_ACTIVE FROM TM_FI_FUNCTION_STATE WHERE CHR_FUNCTION_CODE = 'BACDT'")->row();

        return $data;
    }
    
}
