<?php

class master_preventive_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_checksheet = 'MTE.TM_CHECKSHEET_PREVENTIVE';
    private $tm_activity = 'MTE.TM_ACTIVITY_PREVENTIVE';
    private $tm_activity_detail = 'MTE.TM_ACTIVITY_PREVENTIVE_DETAIL';
    private $tm_drawing = 'MTE.TM_DRAWING';
    private $tm_wi = 'MTE.TM_WI';

    function get_checksheet($type) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_CHECKSHEET_PREVENTIVE
                            WHERE CHR_TYPE = '$type'");
        return $sql->result();
    }

    function get_drawing($type) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_DRAWING
                            WHERE CHR_TYPE = '$type'");
        return $sql->result();
    }

    function get_drawing_by_id($id) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_DRAWING
                            WHERE INT_ID = '$id'");
        return $sql->row();
    }

    function get_manual_by_id($id) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_WI
                            WHERE INT_ID = '$id'");
        return $sql->row();
    }

    function get_manual($type, $group) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_WI
                            WHERE CHR_TYPE = '$type' AND CHR_WI_GROUP = '$group'");
        return $sql->result();
    }

    function get_part_by_type($type) {
        $sql = $this->db->query("SELECT * FROM TM_PARTS_MTE
                            WHERE CHR_TYPE = '$type' AND INT_FLAG_DELETE = '0'");
        return $sql->result();
    }

    function get_last_no_checksheet($date) {
        $sql = $this->db->query("SELECT TOP 1 CHR_CHECKSHEET_CODE FROM MTE.TM_CHECKSHEET_PREVENTIVE
                            WHERE CHR_CREATED_DATE = '$date' ORDER BY CHR_CHECKSHEET_CODE DESC");
        return $sql;
    }

    function get_last_no_drawing($date) {
        $sql = $this->db->query("SELECT TOP 1 CHR_DRAWING_CODE FROM MTE.TM_DRAWING
                            WHERE CHR_CREATED_DATE = '$date' ORDER BY CHR_DRAWING_CODE DESC");
        return $sql;
    }

    function get_last_no_manual($date) {
        $sql = $this->db->query("SELECT TOP 1 CHR_WI_CODE FROM MTE.TM_WI
                            WHERE CHR_CREATED_DATE = '$date' ORDER BY CHR_WI_CODE DESC");
        return $sql;
    }

    function save($data) {
        $this->db->insert($this->tm_checksheet, $data);
    }

    function save_drawing($data) {
        $this->db->insert($this->tm_drawing, $data);
    }

    function save_manual($data) {
        $this->db->insert($this->tm_wi, $data);
    }

    function save_activity($data) {
        $this->db->insert($this->tm_activity, $data);
    }

    function save_activity_detail($data) {
        $this->db->insert($this->tm_activity_detail, $data);
    }

    function get_checksheet_by_id($id) {
        $this->db->where('INT_ID', $id);
        return $this->db->get($this->tm_checksheet);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tm_checksheet, $data);
    }

    function update_activity($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tm_activity, $data);
    }

    function update_activity_detail($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tm_activity_detail, $data);
    }

    function update_drawing($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tm_drawing, $data);
    }

    function update_manual($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tm_wi, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'INT_FLG_DEL' => '1',
            'CHR_MODIFIED_BY' => $session['USERNAME'],
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His'));
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tm_checksheet, $data);
    }

    function get_activities_by_id_checksheet($id) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE
                            WHERE INT_ID_CHECKSHEET = '$id' AND INT_FLG_DEL = '0'");
        return $sql->result();
    }

    function get_last_seq_activity_by_id_checksheet($id) {
        $sql = $this->db->query("SELECT TOP 1 * FROM MTE.TM_ACTIVITY_PREVENTIVE
                            WHERE INT_ID_CHECKSHEET = '$id' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE DESC");
        return $sql;
    }

    function get_last_seq_activity_detail_by_id_activity($id) {
        $sql = $this->db->query("SELECT TOP 1 * FROM MTE.TM_ACTIVITY_PREVENTIVE_DETAIL
                            WHERE INT_ID_ACTIVITY = '$id' AND INT_FLG_DEL = '0' ORDER BY INT_SEQUENCE DESC");
        return $sql;
    }

    function get_activity_by_id($id) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE
                            WHERE INT_ID = '$id' AND INT_FLG_DEL = '0'");
        return $sql->row();
    }

    function get_activity_by_id_checksheet_and_sequence($id_checksheet, $sequence) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE
                            WHERE INT_ID_CHECKSHEET = '$id' AND INT_SEQUENCE > '$sequence' AND INT_FLG_DEL = '0'");
        return $sql;
    }

    function get_activity_detail_by_id($id) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE_DETAIL
                            WHERE INT_ID = '$id' AND INT_FLG_DEL = '0'");
        return $sql->row();
    }

}

?>
