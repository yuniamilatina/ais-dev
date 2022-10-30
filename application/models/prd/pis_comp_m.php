<?php

class pis_comp_m extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    function get_pis_comp() {
        // $sql = "SELECT KANBAN.CHR_PART_NO, KANBAN.CHR_BACK_NO, PART.CHR_PART_NAME, KANBAN.CHR_RAKNO, KANBAN.CHR_IMAGE_PIS_URL FROM TM_KANBAN KANBAN
        //                 INNER JOIN TM_PARTS PART ON PART.CHR_PART_NO = KANBAN.CHR_PART_NO
        //                 WHERE (KANBAN.CHR_KANBAN_TYPE = '0' OR KANBAN.CHR_BACK_NO LIKE 'EF%' OR KANBAN.CHR_BACK_NO LIKE 'EQ%' OR KANBAN.CHR_BACK_NO LIKE 'EE%') AND KANBAN.CHR_IMAGE_PIS_URL IS NOT NULL";
        $sql = "SELECT KANBAN.CHR_PART_NO, KANBAN.CHR_BACK_NO, PART.CHR_PART_NAME, KANBAN.CHR_RAKNO, KANBAN.CHR_IMAGE_PIS_URL FROM TM_KANBAN KANBAN
                        INNER JOIN TM_PARTS PART ON PART.CHR_PART_NO = KANBAN.CHR_PART_NO
                        WHERE KANBAN.CHR_KANBAN_TYPE IN ('0','1') AND KANBAN.CHR_IMAGE_PIS_URL IS NOT NULL";
        return $this->db->query($sql)->result();
    }

    function get_kanban_data() {
        //$sql = "SELECT DISTINCT * FROM TM_KANBAN WHERE (CHR_KANBAN_TYPE = '0' OR CHR_BACK_NO LIKE 'EF%' OR CHR_BACK_NO LIKE 'EQ%' OR CHR_BACK_NO LIKE 'EE%') AND CHR_IMAGE_PIS_URL IS NULL";
        $sql = "SELECT DISTINCT * FROM TM_KANBAN WHERE CHR_KANBAN_TYPE IN ('0','1') AND CHR_IMAGE_PIS_URL IS NULL";
        return $this->db->query($sql)->result();
    }

    function get_data($id) {
        $query = $this->db->query("SELECT TOP(1) * FROM TM_KANBAN WHERE CHR_BACK_NO = '$id' AND CHR_IMAGE_PIS_URL IS NOT NULL");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    public function get_part_no($back_no){
        $query = $this->db->query("SELECT TOP(1) CHR_PART_NO FROM TM_KANBAN WHERE CHR_BACK_NO = '$back_no'");
        return $query->result();
    }

    public function delete_pis($back_no){
        $query = $this->db->query("UPDATE TABLE TM_KANBAN SET CHR_IMAGE_PIS_URL = NULL WHERE CHR_BACK_NO = '$back_no'");
    }

    //function get_detail_pis_comp_by_date_and_work_center($date, $work_center) {
    //    $sql = "SELECT INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, INT_QTY_PCS, INT_QTY_BOX FROM $this->table 
    //        WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center'";

    //    return $this->db->query($sql)->row();
    //}

}
