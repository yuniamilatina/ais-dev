<?php

class kanban_m extends CI_Model {

    private $tabel = 'TM_KANBAN';

    function get_500_kanban() {
        $query = $this->db->query("SELECT TOP 500 ISNULL(PR.CHR_WORK_CENTER,'-') CHR_WORK_CENTER, K.*, P.CHR_PART_NAME  FROM TM_KANBAN K 
        LEFT JOIN TM_PARTS P ON P.CHR_PART_NO = K.CHR_PART_NO
        LEFT JOIN TM_PROCESS_PARTS PR ON PR.CHR_PART_NO = K.CHR_PART_NO
        ORDER BY K.CHR_BACK_NO, K.CHR_KANBAN_TYPE");
        return $query->result();
    }

    function get_all_kanban() {
        // $query = $this->db->query("SELECT ISNULL(PR.CHR_WORK_CENTER,'-') CHR_WORK_CENTER, K.*, P.CHR_PART_NAME  FROM TM_KANBAN K 
        // LEFT JOIN TM_PARTS P ON P.CHR_PART_NO = K.CHR_PART_NO
        // LEFT JOIN TM_PROCESS_PARTS PR ON PR.CHR_PART_NO = K.CHR_PART_NO
        // -- WHERE K.CHR_KANBAN_TYPE = 5
        // ORDER BY K.CHR_BACK_NO, K.CHR_KANBAN_TYPE");
        $query = $this->db->query("SELECT K.*, P.CHR_PART_NAME  FROM TM_KANBAN K 
                                            LEFT JOIN TM_PARTS P ON P.CHR_PART_NO = K.CHR_PART_NO
                                            ORDER BY K.CHR_BACK_NO, K.CHR_KANBAN_TYPE");
        return $query->result();
    }
    
    function get_filter_kanban($filter) {
        ini_set('memory_limit', '-1');
        
        // $query = $this->db->query("SELECT P.CHR_PART_NAME,ISNULL(PR.CHR_WORK_CENTER,'-') CHR_WORK_CENTER, K.*  FROM TM_KANBAN K 
        // LEFT JOIN TM_PARTS P ON P.CHR_PART_NO = K.CHR_PART_NO
        // LEFT JOIN TM_PROCESS_PARTS PR ON PR.CHR_PART_NO = K.CHR_PART_NO
        // where K.CHR_PART_NO like '%".$filter."%' or K.CHR_BACK_NO like '%".$filter."%' or P.CHR_PART_NAME like '%".$filter."%'
        // ORDER BY K.CHR_BACK_NO, K.CHR_KANBAN_TYPE");
        $query = $this->db->query("SELECT P.CHR_PART_NAME, K.*  FROM TM_KANBAN K 
        LEFT JOIN TM_PARTS P ON P.CHR_PART_NO = K.CHR_PART_NO
        where K.CHR_PART_NO like '%".$filter."%' or K.CHR_BACK_NO like '%".$filter."%' or P.CHR_PART_NAME like '%".$filter."%'
        ORDER BY K.CHR_BACK_NO, K.CHR_KANBAN_TYPE");
        return $query->result();
    }

    function get_detail_part($part_no){
        $query = $this->db->query("SELECT TOP 1 * FROM TM_PARTS P
        INNER JOIN TM_KANBAN K ON P.CHR_PART_NO = K.CHR_PART_NO WHERE P.CHR_PART_NO = '$part_no' ");

        return $query;
    }

    function get_detail_kanban_by_barcode($no_kanban, $serial, $tipe) {
        $stored_procedure = "EXEC PRD.zsp_get_detail_kanban_by_barcode ?, ?, ?";
        $param = array(
            'no_kanban' => $no_kanban,
            'serial' => $serial,
            'tipe' => $tipe
        );
        return $this->db->query($stored_procedure, $param);
    }

    //===== OGAWA PROJECT - Get One Way Kanban =====//
    function get_detail_kanban_by_barcode_oneway($no_kanban, $serial, $tipe) {
        $stored_procedure = "EXEC PRD.zsp_get_detail_kanban_by_barcode_oneway ?, ?, ?";
        $param = array(
            'no_kanban' => $no_kanban,
            'serial' => $serial,
            'tipe' => $tipe
        );
        return $this->db->query($stored_procedure, $param);
    }
    //===== END OGAWA PROJECT - Get One Way Kanban =====//

    function get_kanban_qty($backno, $type_kanban, $kanban_no, $serial) {
        $exist = $this->db->query("SELECT TOP 1 INT_QTY_PER_BOX FROM TM_KANBAN_SERIAL WHERE INT_KANBAN_NO = $kanban_no AND INT_NUM_SERIAL = $serial");

        if ($exist->num_rows() > 0) {
            $row = $exist->row_array();
            return $row['INT_QTY_PER_BOX'];
        } else {
            $kanban_master = $this->db->query("SELECT TOP 1 INT_QTY_PER_BOX FROM TM_KANBAN WHERE CHR_BACK_NO = '$backno' AND CHR_KANBAN_TYPE = $type_kanban");
            if ($kanban_master->num_rows() > 0) {
                $row = $kanban_master->row_array();
                return $row['INT_QTY_PER_BOX'];
            } else {
                return 1;
            }
        }
    }


    function get_kanban_by_id($id, $type, $serial){
        $query = $this->db->query("SELECT TOP 1 * FROM TM_KANBAN WHERE INT_KANBAN_NO = '$id' AND CHR_KANBAN_TYPE ='$type'");
        return $query->row();
    }

    function get_kanban_by_backno($backno){
        $query = $this->db->query("SELECT TOP 1 * FROM TM_KANBAN WHERE CHR_BACK_NO = '$backno'");
        return $query->row();
    }

    function get_kanban_by_barcode($id, $type, $serial){
        $query = $this->db->query("SELECT TOP 1 * FROM TM_KANBAN WHERE INT_KANBAN_NO = '$id' AND CHR_KANBAN_TYPE ='$type'");
        return $query;
    }

    function get_kanban_return_by_backno($backno){
        $query = $this->db->query("SELECT TOP 1 * FROM TM_KANBAN WHERE CHR_BACK_NO ='$backno'");
        return $query;
    }

    function get_data_by_partno($part_no){
        $query = $this->db->query("SELECT TOP 1 * FROM TM_KANBAN WHERE CHR_PART_NO = '$part_no' ");
        return $query;
    }

    function get_kanban_serial_by_barcode($id, $type, $serial){
        $query = $this->db->query("SELECT TOP 1 REPLACE(CHR_CUS_PART_NO,'-','') CHR_CUS_PART_NO, S.CHR_CUS_NO FROM TM_KANBAN K INNER JOIN TM_KANBAN_SERIAL S ON K.INT_KANBAN_NO = S.INT_KANBAN_NO
            WHERE K.INT_KANBAN_NO = '$id' AND K.CHR_KANBAN_TYPE ='$type' AND S.INT_NUM_SERIAL = '$serial'");
        return $query;
    }

    function get_cust_by_barcode($id, $type, $serial){
        $query = $this->db->query("SELECT TOP 1 REPLACE(CHR_CUS_PART_NO,'-','') CHR_CUS_PART_NO, S.CHR_CUS_NO FROM TM_KANBAN K INNER JOIN TM_KANBAN_SERIAL S ON K.INT_KANBAN_NO = S.INT_KANBAN_NO
            WHERE K.INT_KANBAN_NO = '$id' AND K.CHR_KANBAN_TYPE ='$type' AND S.INT_NUM_SERIAL = '$serial'");
        return $query;
    }
}
