<?php

class pos_history_scan_m extends CI_Model {

    private $tabel = 'PRD.TT_POS_HISTORY_SCAN';

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

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data($data){
        $wc = $data['CHR_WORK_CENTER']; 
        $pos = $data['CHR_POS_PRD']; 
        $prd_order_no = $data['CHR_PRD_ORDER_NO']; 
        $kanban = $data['CHR_BARCODE']; 

        $query = $this->db->query("SELECT * FROM $this->tabel WHERE CHR_WORK_CENTER = '$wc' AND CHR_POS_PRD = '$pos' AND CHR_BARCODE = '$kanban' AND CHR_PRD_ORDER_NO = '$prd_order_no'");

        return $query;
    }
}
