<?php

class ng_unbalance_m extends CI_Model {

    private $table_trans ="TT_UNBALANCE";
    private $table_mov_h ="TT_GOODS_MOVEMENT_H";
    private $table_mov_l ="TT_GOODS_MOVEMENT_L";

    public function __construct() {
        parent::__construct();
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->table_trans, $data);
    }
    
    function get_part_unbalance() {
        $query = $this->db->query("SELECT DISTINCT CHR_BACK_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE = '1'");
        return $query->result();
    }
    
    function get_part_no($back_no) {
        $query = $this->db->query("SELECT DISTINCT CHR_PART_NO as part_no FROM TM_KANBAN WHERE CHR_BACK_NO = '$back_no'");
        return $query->row();
    }
    
    function get_part_name($part_no) {
        $query = $this->db->query("SELECT DISTINCT TM_PARTS.CHR_PART_NAME as part_name
                    FROM TM_STOCK
                    FULL JOIN TM_PARTS ON TM_PARTS.CHR_PART_NO = TM_STOCK.CHR_PART_NO 
                    WHERE TM_STOCK.CHR_PART_NO='$part_no'");
        return $query->row();
    }
    
    function get_part_name_update($id) {
        $query = $this->db->query("SELECT CHR_PART_NAME as part_name FROM TT_UNBALANCE WHERE INT_ID ='$id'");
        return $query->row();
    }
    
    function save_unb($data) {
        $this->db->insert($this->table_trans, $data);
    }
    
    function save_movement_h($data) {
        $this->db->insert($this->table_mov_h, $data);
    }
    
    function save_movement_l($data) {
        $this->db->insert($this->table_mov_l, $data);
    }
    
    function get_header_key($date,$remarks) {
        $query = $this->db->query("SELECT TOP 1 INT_NUMBER FROM TT_GOODS_MOVEMENT_H WHERE CHR_REMARKS ='$remarks' AND CHR_DATE ='$date'
                                   ORDER BY INT_NUMBER DESC");
        
        return $query->row();
    }
    function get_data_unbalance($date,$shift) {
        $query = $this->db->query("SELECT * FROM TT_UNBALANCE WHERE CHR_DATE ='$date' AND CHR_SHIFT = '$shift' ");
        return $query->result();        
    }
}
