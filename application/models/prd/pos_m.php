<?php

class pos_m extends CI_Model {

    private $tabel = 'PRD.TM_POS';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
        return $this->db->insert_id();
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_existing_pos($part_no, $work_center, $pos){

        return $this->db->query("SELECT CHR_POS_PRD FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 AND CHR_PART_NO = '$part_no'
            AND CHR_POS_PRD = '$pos'
            AND CHR_WORK_CENTER = '$work_center'")->result();
    }

    function get_pos_by_id($id) {
        $sql = "SELECT CHR_POS_PRD FROM $this->tabel WHERE INT_FLG_DEL = 0 AND INT_ID = '$id'";
        return $this->db->query($sql)->row()->CHR_POS_PRD;
    }

    function get_data_pos() {
        $sql = "SELECT INT_ID,INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, CHR_DATE FROM $this->tabel 
            WHERE INT_FLG_DEL = 0";

        return $this->db->query($sql)->result();
    }

    function get_detail_pos_by_id($id) {
        $sql = "SELECT INT_ID, BG.INT_DEPT, CHR_WORK_CENTER, CHR_PART_NO, CHR_IMG_FILE_NAME, CHR_POS_PRD, CHR_NOTE, INT_FLG_MODIFIED FROM $this->tabel P
            INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL BG ON BG.CHR_WCENTER = P.CHR_WORK_CENTER
            WHERE INT_FLG_DEL = 0 AND INT_ID = '$id'";

        return $this->db->query($sql)->row();
    }

    function get_data_pos_by_work_center($work_center){
        $sql = ";WITH CTE_PART_NO (CHR_PART_NO, CHR_BACK_NO) AS (
            SELECT CHR_PART_NO, CHR_BACK_NO FROM TM_KANBAN GROUP BY CHR_PART_NO, CHR_BACK_NO
            )
            
            SELECT INT_ID, P.CHR_WORK_CENTER, P.CHR_PART_NO, CHR_IMG_FILE_NAME, CHR_POS_PRD ,ISNULL(CHR_BACK_NO,'-')  CHR_BACK_NO, CHR_NOTE, INT_FLG_MODIFIED 
        FROM $this->tabel P LEFT JOIN CTE_PART_NO K ON K.CHR_PART_NO = P.CHR_PART_NO
            WHERE INT_FLG_DEL = 0 AND P.CHR_WORK_CENTER = '$work_center'
            ORDER BY CHR_POS_PRD ASC, P.CHR_PART_NO";

        return $this->db->query($sql)->result();
    }

    function get_pos_by_work_center_and_part_no($work_center, $part_no){
        $sql = "SELECT INT_ID, CHR_WORK_CENTER, CHR_PART_NO, CHR_IMG_FILE_NAME, CHR_POS_PRD FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 
            AND CHR_WORK_CENTER = '$work_center' AND CHR_PART_NO = '$part_no'";

        return $this->db->query($sql)->result();
    }

    function get_id_by_pos_and_part_and_work_center($pos, $part_no, $work_center){
        $query = $this->db->query("SELECT TOP 1 INT_ID FROM $this->tabel 
        WHERE INT_FLG_DEL = 0 
        AND CHR_WORK_CENTER = '$work_center' AND CHR_PART_NO = '$part_no' AND CHR_POS_PRD = '$pos'")->row();

        return $query->INT_ID;
    }

    function get_pos_by_work_center_and_part($work_center, $part_no){
        $sql = "SELECT CHR_POS_PRD FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 
            AND CHR_WORK_CENTER = '$work_center' AND CHR_PART_NO = '$part_no'
            GROUP BY CHR_POS_PRD";

        return $this->db->query($sql)->result();
    }

    function check_existing_pos_by_part_no($part_no){
        $sql = "SELECT TOP 1  1 FROM $this->tabel WHERE INT_FLG_DEL = 0 AND CHR_PART_NO = '$part_no'";

        return $this->db->query($sql);
    }

    function get_detail_pos_by_workcenter_and_pos($pos, $work_center){
        $query = $this->db->query("SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' AND CHR_POS_PRD = '$pos' AND CHR_PART_NO = 
            (SELECT CHR_PART_NO_FG FROM PRD.TT_PIS_POS_MATERIAL 
            WHERE CHR_WORK_CENTER = '$work_center' AND CHR_POS_PRD = '$pos' AND INT_FLG_ACTIVE = 1
            GROUP BY CHR_PART_NO_FG)");

        if($query->num_rows() > 0){
            return $query->row()->CHR_NOTE;
        }else{
            return false;
        }
    }

    function get_ddl_pos_by_work_center($work_center){
        return $this->db->query("SELECT CHR_POS_PRD FROM $this->tabel WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' GROUP BY CHR_POS_PRD ORDER BY CHR_POS_PRD")->result();
    }

    function get_top_pos_by_work_center($work_center){
        $query =  $this->db->query("SELECT TOP 1 CHR_POS_PRD FROM $this->tabel WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' ORDER BY CHR_POS_PRD")->row();

        return $query->CHR_POS_PRD;
    }

}
