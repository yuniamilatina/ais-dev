<?php

class report_movement_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function select_data_movement_part_by_period($period){
        $query = $this->db->query("select *
                                    from TT_REPORT_MOVEMENT
                                    where CHR_PERIODE = $period");
        
        return $query->result();
    }

    function select_data_sum_movement_part_by_period($period){
         $query = $this->db->query("select *
                                    from TT_SUM_REPORT_MOVEMENT
                                    where CHR_PERIODE = $period");
        
        return $query->row();
    }
}
?>

