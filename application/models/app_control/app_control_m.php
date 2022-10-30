<?php

class app_control_m extends CI_Model {

    private $tabel = 'INV.TM_APP_CONTROL';

    function get_data_app_control($date_now) {
        $stored_procedure = "EXEC INV.zsp_get_summary_app_control";
        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
}
