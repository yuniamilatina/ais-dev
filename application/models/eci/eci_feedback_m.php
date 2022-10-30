<?php

class eci_feedback_m extends CI_Model {

    private $tabel = "TT_ECI_FEEDBACK";

    public function __construct() {
        parent::__construct();
    }

    function check_feedback_by_ecid_activity_and_revise($id_eci, $rev, $id_activity) {
        $query = $this->db->query("select * from TT_ECI_FEEDBACK WHERE CHR_ID_ECI = '$id_eci' AND INT_REV = '$rev' AND INT_ID_ACTIVITY='$id_activity'");

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function get_feed_back_by_date_now($date) {
        $query = $this->db->query("Select top(1)* from TT_ECI_FEEDBACK where CHR_DATE_ENTRY = '$date' ORDER BY CHR_FILENAME DESC");
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

}
