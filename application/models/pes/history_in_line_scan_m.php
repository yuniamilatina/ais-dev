<?php

class history_in_line_scan_m extends CI_Model {

    private $tabel = 'TT_HISTORY_IN_LINE_SCAN';

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
    
    function get_sum_qty_by_work_order($wo, $qty_eceran, $qty_per_box, $back_no, $number_ref){
        $stored_procedure = "EXEC PRD.zsp_get_allowance_to_input_retail_part ?, ?, ?, ?, ?";
        $param = array(
            'wo' => $wo,
            'qty_eceran' => $qty_eceran,
            'qty_per_box' => $qty_per_box,
            'back_no' => $back_no,
            'number_ref' => $number_ref
            );
        
        $query = $this->db->query($stored_procedure, $param);

        return $query->row()->STATUS_ALLOWENCE;
    }

    function get_sum_qty_by_work_order_ogawa($wo, $qty_eceran, $qty_per_box, $back_no, $number_ref){
        $stored_procedure = "EXEC PRD.zsp_get_allowance_to_input_retail_part_ogawa ?, ?, ?, ?, ?";
        $param = array(
            'wo' => $wo,
            'qty_eceran' => $qty_eceran,
            'qty_per_box' => $qty_per_box,
            'back_no' => $back_no,
            'number_ref' => $number_ref
            );
        
        $query = $this->db->query($stored_procedure, $param);

        return $query->row()->STATUS_ALLOWENCE;
    }
    
    function get_history_scan_kanban_by_barcode($barcode){
        $query = $this->db->query("SELECT * FROM TT_HISTORY_SCAN_KANBAN WHERE CHR_BARCODE = '$barcode'")->row();

        return $query;
    }

    function get_last_dandori_history(){
        $query = $this->db->query("SELECT TOP 1 INT_DANDORI, CHR_PART_NO, CHR_CREATED_DATE, CHR_CREATED_TIME, CHR_STATUS_DATA 
            FROM TT_HISTORY_IN_LINE_SCAN 
            WHERE CHR_WO_NUMBER = '$wo_number' 
            ORDER BY INT_DANDORI DESC")->row();

        return $query;
    }

    function update_history_scan_kanban_by_barcode($barcode){
        $time = date('H:i:s');
        $date = date('dmY');
        
        $this->db->query("UPDATE TT_HISTORY_SCAN_KANBAN SET CHR_LAST_TIME = '$time', CHR_TANGGAL = '$date' WHERE CHR_BARCODE = '$barcode'");
    }

    function insert_history_scan_kanban($barcode){
        $time = date('H:i:s');
        $date = date('dmY');
        
        $this->db->query("INSERT INTO TT_HISTORY_SCAN_KANBAN (CHR_BARCODE, CHR_LAST_TIME, CHR_TANGGAL) VALUES ('$barcode', '$time', '$date')");
    }
}
