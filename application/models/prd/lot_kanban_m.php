<?php

class lot_kanban_m extends CI_Model {

    private $tabel = 'PRD.TT_LOT_KANBAN';

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
        $date = date('Ymd');
        $time = date('His');
        $session = $this->session->all_userdata();
        $user = $session['NPK'];
        $data = array(
            'CHR_MODIFIED_BY' => $user,
            'CHR_MODIFIED_DATE' => $date,
            'CHR_MODIFIED_TIME' => $time,
            'INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_sequence_lot_kanban($work_center) {
        $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS, CHR_DATE, INT_FLG_SO FROM $this->tabel 
            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '0' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC";

        return $this->db->query($sql)->result();
    }

    function get_detail_sequence_lot_kanban_by_id($id) {
        $sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS, CHR_DATE FROM $this->tabel 
            WHERE INT_ID = '$id' AND INT_FLG_PRD = '0' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC";

        return $this->db->query($sql)->row();
    }
   
    function get_sequence_lot_kanban_by_period($period, $work_center){
	$sql = "SELECT INT_ID, INT_SEQUENCE, CHR_WORK_CENTER, CHR_PART_NO, INT_LOT_SIZE, INT_QTY_PER_BOX, INT_QTY_PCS, CHR_DATE FROM $this->tabel 
            WHERE CHR_DATE LIKE '$periode%' AND CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '0' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE ASC";
        return $this->db->query($sql)->result();
    }
    
    function get_all_part_no_by_wc($wc) {
        $sql = "SELECT DISTINCT CHR_PART_NO FROM TM_PROCESS_PARTS
            WHERE CHR_WORK_CENTER = '$wc' AND CHR_PV = '0001' ORDER BY CHR_PART_NO ASC";

        return $this->db->query($sql)->result();
    }
    
    function get_back_no_by_part_no($part_no) {
        $sql = "SELECT DISTINCT CHR_BACK_NO FROM TM_KANBAN
            WHERE CHR_PART_NO = '$part_no'";

        return $this->db->query($sql)->row();
    }
    
    function update_sequence($new_seq, $id, $date, $time, $user) {
        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = '$new_seq', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE INT_ID = '$id'");
    }

    function update_new_sequence($new_lot, $qty_per_box, $new_seq, $id, $date, $time, $user) {
        $new_pcs = $new_lot * $qty_per_box;
        $sql = $this->db->query("UPDATE $this->tabel SET INT_LOT_SIZE = '$new_lot', INT_QTY_PER_BOX = '$qty_per_box', INT_QTY_PCS = '$new_pcs', INT_SEQUENCE = '$new_seq', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE INT_ID = '$id'");
    }
    
    function update_sequence_other($work_center, $old_seq, $new_seq, $date, $time, $user) {
        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE + 1), CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE >= '$new_seq' AND INT_SEQUENCE < '$old_seq'");
    }
    
    function update_sequence_other_2($work_center, $old_seq, $new_seq, $date, $time, $user) {
        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE - 1), CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE > '$old_seq' AND INT_SEQUENCE <= '$new_seq'");
    }
    
    function update_sequence_other_3($work_center, $new_seq, $date, $time, $user) {
        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE + 1), CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE >= '$new_seq'");
    }
    
    function update_sequence_other_4($work_center, $seq, $date, $time, $user) {
        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE - 1), CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE CHR_WORK_CENTER = '$work_center' AND INT_SEQUENCE > '$seq'");
    }
    
    function insert_special_order($data) {
        $this->db->insert($this->tabel, $data);
    }
    
    function get_last_sequence($work_center) {
        $sql = "SELECT TOP 1 INT_SEQUENCE FROM $this->tabel 
            WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = '0' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE DESC";
        return $this->db->query($sql)->row();
    }
    
    function update_sequence_other_higher($wcenter, $old_seq, $date, $time, $user) {
        $sql = $this->db->query("UPDATE $this->tabel SET INT_SEQUENCE = (INT_SEQUENCE - 1), CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE CHR_WORK_CENTER = '$wcenter' AND INT_SEQUENCE > '$old_seq'");
    }
    
    function update_move_sequence($wcenter, $new_lot, $qty_per_box, $new_seq, $id, $date, $time, $user) {
        $new_pcs = $new_lot * $qty_per_box;
        $sql = $this->db->query("UPDATE $this->tabel SET CHR_WORK_CENTER = '$wcenter', INT_LOT_SIZE = '$new_lot', INT_QTY_PER_BOX = '$qty_per_box', INT_QTY_PCS = '$new_pcs', INT_SEQUENCE = '$new_seq', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE INT_ID = '$id'");
    }

    function get_data_additional_info_kanban($work_center) {
        $sql = $this->db->query("SELECT A.INT_ID, A.CHR_PART_NO, A.CHR_WORK_CENTER, A.CHR_KANBAN_ADDITIONAL_INFO, B.CHR_BACK_NO, B.INT_QTY_PER_BOX, B.CHR_KANBAN_TYPE, A.INT_FLAG_DELETE
                FROM PRD.TM_KANBAN_ADDITIONAL_INFO A
                LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
                WHERE A.CHR_WORK_CENTER = '$work_center' AND A.INT_FLAG_DELETE = 0
                ORDER BY A.CHR_PART_NO");
        return $sql->result();
    }

    function insert_additional_info_kanban($data) {
        $this->db->insert('PRD.TM_KANBAN_ADDITIONAL_INFO', $data);
    }

    
    function update_flag_delete_add_info_kanban($id, $date, $time, $user) {
        $sql = $this->db->query("UPDATE PRD.TM_KANBAN_ADDITIONAL_INFO SET INT_FLAG_DELETE = '1', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE INT_ID = '$id'");
    }

    function update_add_info_kanban($id, $info, $date, $time, $user) {
        $sql = $this->db->query("UPDATE PRD.TM_KANBAN_ADDITIONAL_INFO SET CHR_KANBAN_ADDITIONAL_INFO = '$info', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE INT_ID = '$id'");
    }

    function get_data_part_by_dept($id_dept)
    {
        return $this->db->query("SELECT DISTINCT P.CHR_PART_NO, K.CHR_BACK_NO FROM TM_PARTS P
                                    INNER JOIN (SELECT CHR_PART_NO, CHR_BACK_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE IN ('1','5')) K ON P.CHR_PART_NO = K.CHR_PART_NO
                                    INNER JOIN (SELECT A.CHR_PART_NO, B.INT_DEPT FROM TM_PROCESS_PARTS A
                                    LEFT JOIN TM_DIRECT_BACKFLUSH_GENERAL B ON A.CHR_WORK_CENTER = B.CHR_WCENTER WHERE B.INT_DEPT = '$id_dept') PP
                                    ON P.CHR_PART_NO = PP.CHR_PART_NO
                                GROUP BY P.CHR_PART_NO, K.CHR_BACK_NO")->result();
    }

    function get_data_overstock_parts_by_dept($id_dept)
    {
        return $this->db->query("SELECT DISTINCT P.INT_ID, P.CHR_PART_NO, P.CHR_NOTES, P.INT_FLG_DELETE, K.CHR_BACK_NO FROM PRD.TT_PARTS_OVERSTOCK P
                INNER JOIN (SELECT CHR_PART_NO, CHR_BACK_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE IN ('1','5')) K ON P.CHR_PART_NO = K.CHR_PART_NO
                INNER JOIN (SELECT A.CHR_PART_NO, B.INT_DEPT FROM TM_PROCESS_PARTS A
                LEFT JOIN TM_DIRECT_BACKFLUSH_GENERAL B ON A.CHR_WORK_CENTER = B.CHR_WCENTER WHERE B.INT_DEPT = '$id_dept') AS PP
                ON P.CHR_PART_NO = PP.CHR_PART_NO
                WHERE P.INT_FLG_DELETE = '0'");
    }

    function insert_overstock_parts($data) {
        $this->db->insert('PRD.TT_PARTS_OVERSTOCK', $data);
    }

    function update_flag_delete_overstock_parts($id, $date, $time, $user) {
        $sql = $this->db->query("UPDATE PRD.TT_PARTS_OVERSTOCK SET INT_FLG_DELETE = '1', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE INT_ID = '$id'");
    }

    function update_overstock_parts($id, $info, $date, $time, $user) {
        $sql = $this->db->query("UPDATE PRD.TT_PARTS_OVERSTOCK SET CHR_NOTES = '$info', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE INT_ID = '$id'");
    }

    function check_existing_part_no_overstock($part_no) {
        return $sql = $this->db->query("SELECT * FROM PRD.TT_PARTS_OVERSTOCK WHERE CHR_PART_NO = '$part_no' AND INT_FLG_DELETE = '0'")->num_rows();
    }

    function update_flag_delete_overstock_parts_by_part_no($part_no, $date, $time, $user) {
        $sql = $this->db->query("UPDATE PRD.TT_PARTS_OVERSTOCK SET INT_FLG_DELETE = '1', CHR_MODIFIED_BY = '$user', CHR_MODIFIED_DATE = '$date', 
                CHR_MODIFIED_TIME = '$time' WHERE CHR_PART_NO = '$part_no' AND INT_FLG_DELETE = '0'");
    }

}
