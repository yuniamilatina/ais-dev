<?php

class prod_entry_purging_m extends CI_Model {

    
    private $tbl_name ="PRD.TM_PART_PURGING";
    private $tbl_transaksi ="PRD.TT_PURGING";
    private $tbl_history ="PRD.TT_HIS_PURGING";
    private $tbl_save_move_l ="TT_GOODS_MOVEMENT_L";
    private $tbl_save_move_h ="TT_GOODS_MOVEMENT_H";

    public function __construct() {
        parent::__construct();
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tbl_transaksi, $data);
    }
    
    //===== EDIT TIO
    function get_part_purging() {
        $query = $this->db->query("SELECT  TM_STOCK.CHR_PART_NO
                    FROM TM_STOCK
                    WHERE CHR_VAL_CLASS_NAME LIKE '%plastic%' and CHR_SLOC ='WP01'");

        return $query->result();
    }
    
    function get_part_name($part_no) {
        $query = $this->db->query("SELECT  TM_STOCK.CHR_PART_NO,TM_PARTS.CHR_PART_NAME as part_name
                    FROM TM_STOCK
                    FULL JOIN TM_PARTS ON TM_PARTS.CHR_PART_NO = TM_STOCK.CHR_PART_NO 
                    WHERE CHR_VAL_CLASS_NAME LIKE '%plastic%' and CHR_SLOC ='WP01' AND TM_STOCK.CHR_PART_NO='$part_no'");

        return $query->row();
    }
    
    function save($data) {
        $this->db->insert($this->tbl_transaksi, $data);
    }
    function save_history($data) {
        $this->db->insert($this->tbl_history, $data);
    }
        function save_movement_h($data) {
        $this->db->insert($this->tbl_save_move_h, $data);
    }
    function save_movement_l($data) {
        $this->db->insert($this->tbl_save_move_l, $data);
    }
    function get_header_key($date,$remarks) {
        $query = $this->db->query("SELECT TOP 1 INT_NUMBER FROM TT_GOODS_MOVEMENT_H WHERE CHR_REMARKS ='$remarks' AND CHR_DATE ='$date'
                                   ORDER BY INT_NUMBER DESC");
        
        return $query->row();
    }
    function get_data_purging($date,$shift) {
        $query = $this->db->query("SELECT * FROM PRD.TT_PURGING WHERE CHR_DATE_PURGING ='$date' AND CHR_SHIFT = '$shift' ");

        return $query->result();
        
    }
    
//    function get_data_purging($date,$shift) {
//        $query = $this->db->query("SELECT *, LEFT(CHR_CREATED_TIME,2) + ':' + SUBSTRING(CHR_CREATED_TIME,3,2) + ':' + RIGHT (CHR_CREATED_TIME,2) AS CHR_CREATED_TIMED
//                                   FROM PRD.TT_PURGE_HISTORY WHERE CHR_DATE_PURGING ='$date' AND CHR_SHIFT = '$shift'");
//
//        return $query->result();
//        
//    }
}
