<?php

class goods_movement_l_m extends CI_Model {

    private $tabel = 'TT_GOODS_MOVEMENT_L';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }
    
    function get_detail_goods_movement_l($work_center, $part_no, $batch) {
        $sql = "SELECT TOP 1 CHR_SLOC_FROM, CHR_SLOC_TO, CHR_SER_NO FROM $this->tabel WHERE CHR_USER = '$work_center' AND CHR_PART_NO = '$part_no' AND CHR_SER_NO = '$batch'
                ORDER BY CHR_TIME_ENTRY DESC";

        return $this->db->query($sql);
    }

    
    
}
