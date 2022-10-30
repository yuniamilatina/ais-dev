<?php

class report_prod_line_ng_ok_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //DATA LINE OK NG
    function select_data_prod_entry_by_date_and_dept_and_work_center($date, $dept_id) {
        $period = intval($date);

        $stored_procedure = "EXEC PRODUCTION.zsp_get_qty_per_work_center ?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept_id);

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //DIAGRAM LINE
    function select_total_part_work_center_by_dept_and_date_and_work_center($date, $dept_crop, $work_center) {
        $work_center_string = "'" . $work_center . "'";

        $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY, 
                                           RIGHT(PR.CHR_DATE,2) AS CHR_DATE
                                    FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                    WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string
                                    GROUP BY PR.CHR_WORK_CENTER,PR.CHR_DATE");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
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

