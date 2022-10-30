<?php

class machine_tester_m extends CI_Model {

    private $tabel = 'PRD.TT_MACHINE_TESTER';

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

    function get_data_machine_tester() {
        $sql = "SELECT INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, CHR_DATE FROM $this->table 
            WHERE INT_FLG_DEL = 0";

        return $this->db->query($sql)->result();
    }

    function get_detail_machine_tester_by_date_and_work_center($date, $work_center) {
        $sql = "SELECT INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, CHR_DATE FROM $this->table 
            WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' AND CHR_DATE = '$date'";

        return $this->db->query($sql)->row();
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

}
