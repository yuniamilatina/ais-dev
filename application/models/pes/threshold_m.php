<?php

class threshold_m extends CI_Model {

    private $tabel = 'PRD.TM_THRESHOLD_REPORT';

    public function __construct() {
        parent::__construct();
    }
    
    function get_data_threshold($desc) {
        $query = $this->db->query("SELECT TOP 1 INT_THRESHOLD FROM $this->tabel WHERE CHR_CREATED_BY = '$desc' AND INT_FLG_DELETE = 0");

        return $query->row()->INT_THRESHOLD;
    }


}
