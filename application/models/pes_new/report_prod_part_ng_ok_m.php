<?php

class report_prod_part_ng_ok_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //PART
    function select_data_prod_entry_by_date_and_dept_and_work_center($date, $dept_id, $work_center) {
        $period = intval($date);

        $stored_procedure = "EXEC PRODUCTION.zsp_get_qty_part_ok_ng ?,?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept_id,
            'work_center' => $work_center);

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //PART
    function select_count_by_date_and_dept_and_work_center($date, $dept_id, $work_center) {
        $period = intval($date);

        $stored_procedure = "EXEC PRODUCTION.zsp_get_qty_part_ok_ng ?,?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept_id,
            'work_center' => $work_center);

        $query = $this->db->query($stored_procedure, $param);

        return $query->num_rows();
    }

    //additional
    function get_all_work_center_by_dept($dept_crop) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("select DISTINCT(CHR_WORK_CENTER) FROM TM_PROCESS_PARTS WHERE CHR_PERSON_RESPONSIBLE = $dept_crop ORDER BY CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select DISTINCT(CHR_WORK_CENTER) FROM TM_PROCESS_PARTS ORDER BY CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_top_work_center_by_dept($dept_crop) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("select TOP(1) PR.CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop
					ORDER BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select TOP(1) PR.CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
					ORDER BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

}
?>

