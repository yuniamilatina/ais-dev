<?php

class prd_capacity_m extends CI_Model {

    private $tabel = 'PRD.TM_CAPACITY_PRD';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id) {
        $user_session = $this->session->all_userdata();
        $data = array('INT_FLG_DEL' => 1, 
            'CHR_MODIFIED_BY' => $user_session['USERNAME'],
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His'));

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_capacity() {
        $sql = "SELECT * FROM $this->tabel 
            WHERE INT_FLG_DEL = 0";

        return $this->db->query($sql)->result();
    }
    
    function get_data_capacity_by_dept($id_dept) {
        $sql = "SELECT * FROM $this->tabel 
            WHERE CHR_WORK_CENTER IN (SELECT CHR_WCENTER FROM TM_DIRECT_BACKFLUSH_GENERAL WHERE INT_DEPT = '$id_dept') AND INT_FLG_DEL = 0";

        return $this->db->query($sql)->result();
    }
    
    function get_detail_pos_by_id($id) {
        $sql = "SELECT INT_ID, CHR_WORK_CENTER, CHR_PART_NO, CHR_IMG_FILE_NAME, CHR_POS_PRD FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND INT_ID = '$id'";

        return $this->db->query($sql)->row();
    }
   
    function get_data_pos_by_period(){
        $sql = "SELECT INT_ID, CHR_WORK_CENTER, CHR_PART_NO, CHR_IMG_FILE_NAME, CHR_POS_PRD FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 ";

        return $this->db->query($sql)->result();
    }

    function get_pos_by_work_center_and_part_no($work_center, $part_no){
        $sql = "SELECT INT_ID, CHR_WORK_CENTER, CHR_PART_NO, CHR_IMG_FILE_NAME, CHR_POS_PRD FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 
            --AND CHR_WORK_CENTER = '$work_center' AND CHR_PART_NO = '$part_no'
            ";

        return $this->db->query($sql)->result();
    }
    
    function check_data_capacity($work_center, $shift){
        $sql = "SELECT * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center' AND INT_SHIFT = '$shift' AND INT_FLG_DEL = '0'";

        return $this->db->query($sql);
    }

}
