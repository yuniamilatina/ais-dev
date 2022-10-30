<?php

class noritsu_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_data_noritsu($date, $work_center, $dept) {

        $stored_procedure = "EXEC PRD.zsp_get_data_noritsu ?,?,?";
        $param = array(
            'date' => $date,
            'work_center' => $work_center,
            'dept' => $dept);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();

    }

    function get_data_noritsu_detail($date, $part_no, $work_center, $dept){

        $stored_procedure = "EXEC PRD.zsp_get_data_noritsu_detail ?,?,?,?";
        $param = array(
            'date' => $date,
            'work_center' => $work_center,
            'part_no' => $part_no,
            'dept' => $dept
        );

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
    
}
?>

