<?php

class eci_l_m extends CI_Model {

    private $tbl_trans = "TT_ECI_H";
    private $tbl_trans_l = "TT_ECI_L";
    private $tbl_feedback = "TT_ECI_FEEDBACK";
    private $tbl_portal = "TT_PORTAL_NOTIFICATION";

    public function __construct() {
        parent::__construct();
    }

    function find_trans($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        if (!empty($select)) {
            $this->db->select($select, false);
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($order)) {
            $this->db->order_by($order);
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        if (!empty($group)) {
            $this->db->group_by($group);
        }

        if (!empty($join) && is_array($join)) {
            if (!empty($join['table']) && !empty($join['on'])) {
                $join = array($join);
            }
            foreach ($join as $item) {
                if (!empty($item['table']) && !empty($item['on'])) {
                    if (!empty($item['pos'])) {
                        $this->db->join($item['table'], $item['on'], $item['pos']);
                    } else {
                        $this->db->join($item['table'], $item['on']);
                    }
                }
            }
        }
        return $this->db->get($this->tbl_trans_l)->result();
    }

    function add_trans($data) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->insert($this->tbl_trans_l, $data);
        }
        return false;
    }

    function add_notif($data) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->insert($this->tbl_portal, $data);
        }
        return false;
    }

    function update_trans_h($data, $where) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans, $data, $where);
        }
        return false;
    }

    function update_trans_l($data, $where) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans_l, $data, $where);
        }
        return false;
    }

    function update_publish($data, $where) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans_l, $data, $where);
        }
        return false;
    }

    function update_revision($data, $where) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans_l, $data, $where);
        }
        return false;
    }

    function delete_revision($id_eci, $id_act, $id_user, $pidbek) {
        $this->db->query("DELETE FROM TT_ECI_FEEDBACK WHERE CHR_ID_ECI = " . $id_eci . " AND INT_ID_ACTIVITY = " . $id_act . " AND CHR_USR_ENTRY = " . $id_user . " AND INT_FEEDBACK = " . $pidbek . "");
    }

    function update_feedback($ideci, $idact, $iduser) {

        //$this->db->query("UPDATE TT_ECI_L SET CHR_DATE_START='" . $startdate . "', CHR_TIME_START='" . $starttime . "', INT_STATUS_COLOR = '2' WHERE CHR_ID_ECI=" . $id . " AND INT_ID_ECI_LINE =".$line."");
        $this->db->query("update TT_ECI_FEEDBACK SET CHR_APPROVE_BY_ADMIN = 1 WHERE CHR_ID_ECI = '" . $ideci . "' AND INT_ID_ACTIVITY = '" . $idact . "' AND CHR_USR_ENTRY = '" . $iduser . "'");
        //update TT_ECI_FEEDBACK SET CHR_APPROVE_BY_ADMIN = 1 WHERE CHR_ID_ECI='3' AND INT_ID_ACTIVITY = '121' AND CHR_USR_ENTRY='0486'
    }

    function update_feedback2($data, $where) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->update($this->tbl_feedback, $data, $where);
        }
        return false;
    }

    function delete_trans_h($id) {
        $this->db->where('CHR_ID_ECI', $id);
        $this->db->delete($this->tbl_trans);
    }

    function delete_trans_l($id) {
        $this->db->where('CHR_ID_ECI', $id);
        $this->db->delete($this->tbl_trans_l);
    }

    function delete_activity($id, $line) {
        $this->db->query("DELETE FROM TT_ECI_L WHERE CHR_ID_ECI = " . $id . " AND INT_ID_ECI_LINE = " . $line . "");
    }

    function delete_activity_child($id, $parent) {
        $this->db->query("DELETE FROM TT_ECI_L WHERE CHR_ID_ECI = " . $id . " AND CHR_ID_DEPENDEN = " . $parent . "");
    }

    function check_id_line($id) {
        return $this->db->query("select count(INT_ID_ECI_LINE) as a from TT_ECI_L where CHR_ID_ECI = " . $id . "")->row();
    }

    function generate_id_line($id) {
        return $this->db->query("select max(INT_ID_ECI_LINE) as a from TT_ECI_L where CHR_ID_ECI  = " . $id . "")->row()->a + 1;
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from TT_ECI_L where CHR_ACTIVITY_NAME = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function start_activity($id, $line) {
        $startdate = date("Ymd");
        $starttime = date("His");
        $this->db->query("UPDATE TT_ECI_L SET CHR_DATE_START='" . $startdate . "', CHR_TIME_START='" . $starttime . "', INT_STATUS_COLOR = '2' WHERE CHR_ID_ECI=" . $id . " AND INT_ID_ECI_LINE =" . $line . "");
    }

    function deactivate_activity($id, $line) {
        $this->db->query("UPDATE TT_ECI_L SET CHR_FLG_ACTIVE='0' WHERE CHR_ID_ECI=" . $id . " and INT_ID_ECI_LINE=" . $line . "");
    }

    function get_data_activity($id, $line) {
        $query = $this->db->query("SELECT a.CHR_ID_ECI, a.INT_REV, a.CHR_FLG_ACTIVE, a.INT_ID_ACTIVITY, a.CHR_ACTIVITY_NAME, a.CHR_START_DATE, a.CHR_DUE_DATE, 
		a.CHR_PIC_NPK, a.CHR_PIC_NAME, a.CHR_PIC_DEPT, a.CHR_FLG_PUBLISH, a.CHR_USR_ENTRY, a.CHR_USR_UPDATE, a.INT_ID_ECI_LINE, 
		a.CHR_DATE_UPDATE, a.CHR_TIME_UPDATE FROM TT_ECI_L a WHERE INT_ID_ECI_LINE = '" . $line . "' and CHR_ID_ECI = '" . $id . "'");
        return $query;
    }

    function edit_activity1() {
        $query = $this->db->query("UPDATE TT_ECI_L SET INT_ID_ACTIVITY='" . $id_activity . "', CHR_ACTIVITY_NAME='" . $activity_name .
                "',INT_DURATION='" . $duration . "', CHR_START_DATE='" . $start_date . "',  CHR_DUE_DATE='" . $due_date . "', CHR_PIC_NPK= '" . $pic_npk .
                "', CHR_PIC_NAME='" . $pic_name . "', CHR_PIC_MAIL='" . $pic_mail . "', CHR_PIC_SUPERIOR='" . $pic_superior .
                "', CHR_PIC_SUPERIOR_MAIL='" . $pic_sup_mail . "', CHR_PIC_DEPT='" . $pic_dept . "' WHERE CHR_ID_ECI='" . $id_eci . "' AND INT_ID_ACTIVITY='" . $id_activity . "';");
    }

    function edit_activity($data, $array) {

        $this->db->where($array);
        $this->db->update($this->tbl_trans_l, $data);
    }

    function check_feedback($ideci, $idact) {
        $find_feed = $this->db->query("select * from TT_ECI_FEEDBACK where CHR_ID_ECI = '" . $ideci . "' AND INT_ID_ACTIVITY = '" . $idact . "'");
        if ($find_feed->num_rows() > 0) {
            return $find_feed->result();
        }
        return false;
    }

    public function find_notif($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        $db_1 = $this->load->database();

        if (!empty($select))
            $this->db->select($select, false);
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order))
            $this->db->order_by($order);
        if (!empty($limit))
            $this->db->limit($limit, $start);
        if (!empty($group))
            $this->db->group_by($group);

        if (!empty($join) && is_array($join)) {
            if (!empty($join['table']) && !empty($join['on'])) {
                $join = array($join);
            }

            foreach ($join as $item) {
                if (!empty($item['table']) && !empty($item['on'])) {
                    if (!empty($item['pos'])) {
                        $this->db->join($item['table'], $item['on'], $item['pos']);
                    } else {
                        $this->db->join($item['table'], $item['on']);
                    }
                }
            }
        }

        return $this->db->get($this->tbl_portal)->result();
        //return $this->db_1->get($this->tbl_name)->result();
    }

    public function find_trans_d($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        $db_1 = $this->load->database();

        if (!empty($select))
            $this->db->select($select, false);
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order))
            $this->db->order_by($order);
        if (!empty($limit))
            $this->db->limit($limit, $start);
        if (!empty($group))
            $this->db->group_by($group);

        if (!empty($join) && is_array($join)) {
            if (!empty($join['table']) && !empty($join['on'])) {
                $join = array($join);
            }

            foreach ($join as $item) {
                if (!empty($item['table']) && !empty($item['on'])) {
                    if (!empty($item['pos'])) {
                        $this->db->join($item['table'], $item['on'], $item['pos']);
                    } else {
                        $this->db->join($item['table'], $item['on']);
                    }
                }
            }
        }

        return $this->db->get($this->tbl_trans_l)->result();
        //return $this->db_1->get($this->tbl_name)->result();
    }

    function get_trans_data($id_eci) {
        $query = $this->db->query("SELECT * FROM TT_ECI_L a WHERE CHR_ID_ECI = '" . $id_eci . "'  AND CHR_FLG_PUBLISH='1' ORDER BY INT_SEQ ASC");
        return $query;
    }

    function check_sequence_by_id($id) {
        
    }

    function update_sequence($id) {
        $stored_procedure = "ECI.zsp_update_sequence_activity_eci_by_eci_id ? ";
        $param = array(
            'eci_id' => $id);

        $this->db->query($stored_procedure, $param);
    }

    function get_list_activity_data()
    {
        
    }
    
    
    function get_feedback_data(){
        return $this->db->query("SELECT  TT_ECI_FEEDBACK.CHR_ID_ECI, TT_ECI_FEEDBACK.INT_REV, TT_ECI_FEEDBACK.INT_ID_ACTIVITY, TT_ECI_H.CHR_NAME,
			TT_ECI_FEEDBACK.INT_FEEDBACK, TT_ECI_FEEDBACK.CHR_TITTLE, TT_ECI_FEEDBACK.CHR_USR_ENTRY, TT_ECI_FEEDBACK.INT_FEEDBACK, TT_ECI_FEEDBACK.CHR_APPROVE_BY_ADMIN, TT_ECI_FEEDBACK.CHR_FILENAME, TT_ECI_FEEDBACK.CHR_COMMENT, TT_ECI_L.CHR_ACTIVITY_NAME,
			TT_ECI_L.CHR_PIC_NAME, TT_ECI_H.CHR_NAME from TT_ECI_L INNER JOIN TT_ECI_FEEDBACK ON TT_ECI_L.INT_ID_ACTIVITY = TT_ECI_FEEDBACK.INT_ID_ACTIVITY and TT_ECI_L.CHR_ID_ECI = TT_ECI_FEEDBACK.CHR_ID_ECI 
			INNER JOIN TT_ECI_H ON TT_ECI_H.CHR_ID_ECI = TT_ECI_FEEDBACK.CHR_ID_ECI")->result();
    }
    
    function reject_feedback($id, $id_act, $id_user) {
        $seq_reject = $this->db->query("select max(INT_STAT_REJECTED) as a from TT_ECI_L WHERE CHR_ID_ECI= $id and INT_ID_ACTIVITY= $id_act AND CHR_PIC_NPK = '$id_user'")->row()->a + 1;
     
        $this->db->query("UPDATE TT_ECI_L SET CHR_FLG_ATTTACH=NULL, FLT_PROGRESS = NULL, INT_FLG_REJECTED = 1, INT_STAT_REJECTED = $seq_reject, CHR_FLG_MAIL_SENT = 0, CHR_DATE_MAIL_SENT = 0 WHERE CHR_ID_ECI= $id and INT_ID_ACTIVITY= $id_act AND CHR_PIC_NPK = '$id_user'");
    }

    function get_list_data_eci($eci_id){
        return $this->db->query("SELECT * FROM TT_ECI_L WHERE CHR_ID_ECI = $eci_id AND CHR_FLG_PUBLISH = 1 
                       ORDER BY INT_SEQ ASC")->result();
    }

    function get_data_no_list($eci_id,$dependen_id){
        return $this->db->query("SELECT INT_SEQ as a FROM TT_ECI_L WHERE CHR_ID_ECI = $eci_id AND CHR_FLG_PUBLISH = 1 and INT_ID_ECI_LINE = $dependen_id")->row()->a;
    }

    function get_data_root_parent($eci_id,$dependen_id){
        return $this->db->query("SELECT INT_SEQ, CHR_ID_DEPENDEN FROM TT_ECI_L WHERE CHR_ID_ECI = $eci_id AND CHR_FLG_PUBLISH = 1 and INT_ID_ECI_LINE = $dependen_id")->result();
    }


    function listpic(){
        return $this->db->query("SELECT INT_ID_PIC,CHR_NPK, CHR_NAME FROM TM_ECI_PIC ORDER BY CHR_NAME ASC")->result();
    }

}
