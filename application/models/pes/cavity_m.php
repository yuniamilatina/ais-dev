<?php

class cavity_m extends CI_Model {

    private $tabel = 'PRD.TM_CAVITY';

    public function __construct() {
        parent::__construct();
    }

    function get_data_by_id($id) {
        return $this->db->query("SELECT * FROM $this->tabel WHERE INT_ID = $id")->row();
    }

    function get_data($work_center) {
        return $this->db->query("SELECT * FROM $this->tabel WHERE  INT_FLG_DEL = 0")->result();
    }

    function get_data_part_no($part_no) {
        return $this->db->query("SELECT RTRIM(CHR_PART_NO) CHR_PART_NO, RTRIM(CHR_PART_NO_MATE) CHR_PART_NO_MATE FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND (CHR_PART_NO = '$part_no' OR CHR_PART_NO_MATE = '$part_no')");
    }

    function get_existing_part_no_cavity($part_no) {
        return $this->db->query("SELECT RTRIM(CHR_PART_NO) CHR_PART_NO, RTRIM(CHR_PART_NO_MATE) CHR_PART_NO_MATE FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND CHR_PART_NO = '$part_no' ");
    }

    function get_flag_cavity($part_no){
        $data = $this->db->query("SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0 AND (CHR_PART_NO = '$part_no' OR CHR_PART_NO_MATE = '$part_no')");

        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

}
