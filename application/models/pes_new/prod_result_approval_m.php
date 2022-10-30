<?php

class prod_result_approval_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function approve_by_leader($data) {
        $this->db->insert('TT_PRODUCTION_RESULT_APPROVAL', $data);
    }

       function get_stat_approve_by_leader($date, $shift, $w_center) {
        $query = $this->db->query("SELECT INT_STAT_LEADER FROM TT_PRODUCTION_RESULT_APPROVAL
                WHERE CHR_WORK_CENTER = '$w_center' AND CHR_SHIFT = '$shift' AND CHR_DATE = '$date'
                AND INT_STAT_LEADER = 1");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_stat_approve_by_spv($date, $shift, $w_center) {
        $query = $this->db->query("SELECT INT_STAT_SPV FROM TT_PRODUCTION_RESULT_APPROVAL
                WHERE CHR_WORK_CENTER = '$w_center' AND CHR_SHIFT = '$shift' AND CHR_DATE = '$date'
                AND INT_STAT_SPV = 1");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_stat_approve_by_mgr($date, $shift, $w_center) {
        $query = $this->db->query("SELECT INT_STAT_MGR FROM TT_PRODUCTION_RESULT_APPROVAL
                WHERE CHR_WORK_CENTER = '$w_center' AND CHR_SHIFT = '$shift' AND CHR_DATE = '$date'
                AND INT_STAT_MGR = 1");
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    //add by toro 2016-12-09
    function unapprove_by_spv($data) {
        $wo = $data['CHR_WO_NUMBER'];
        $user = $this->session->userdata('USERNAME');
        $time = date('His');
        $date = date('Ymd');

        $this->db->query("UPDATE TT_PRODUCTION_RESULT_APPROVAL SET INT_STAT_LEADER = 0, CHR_MODI_BY = '$user',
                CHR_MODI_TIME = '$time', CHR_MODI_DATE = '$date'
                WHERE CHR_WO_NUMBER = '$wo'");
    }

}
