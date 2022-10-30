<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cogi_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //chart
    function select_summary_cogi_by_classname() {
        $stored_procedure = "EXEC PRD.zsp_get_summary_cogi_by_classname";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    //total row
    function select_total_row() {
        $stored_procedure = "EXEC PRD.zsp_get_summary_cogi_by_classname";

        $query = $this->db->query($stored_procedure);
        return $query->num_rows();
    }
    
   //grid table
    function get_cogi() {
        $stored_procedure = "EXEC PRD.zsp_get_cogi";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    
    //Get count data error log
    function total_data_cogi() {
        $stored_procedure = "EXEC PRD.zsp_get_summary_cogi";

        $query = $this->db->query($stored_procedure);
        return $query->row();
    }
    
    
}

?>
