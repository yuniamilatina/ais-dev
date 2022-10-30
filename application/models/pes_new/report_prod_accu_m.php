<?php

class report_prod_accu_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function select_total_by_date_and_dept($date, $dept_crop) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                            FROM TT_PRODUCTION_RESULT PR 
                                            INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                            INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                            WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop ");
        } else {
            $query = $this->db->query("SELECT SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                            FROM TT_PRODUCTION_RESULT PR 
                                            INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                            INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                            WHERE LEFT(PR.CHR_DATE,6) = $date");
        }
        
        return $query->row_array();
    }

    //grid data ACCU
    function select_data_prod_entry_by_date_and_dept($date, $dept_crop) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                            PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, SUM(PR.INT_NG_PRC) AS INT_NG_PRC, SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL, SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG
                                            FROM TT_PRODUCTION_RESULT PR 
                                            INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                            INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                            WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                                                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE ORDER BY PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                            PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, SUM(PR.INT_NG_PRC) AS INT_NG_PRC, SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL, SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG
                                            FROM TT_PRODUCTION_RESULT PR 
                                            INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                            INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                            WHERE LEFT(PR.CHR_DATE,6) = $date GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                                                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE ORDER BY PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_BACK_NO");
        }

        return $query->result();
    }

    //total
    function select_total_by_date_and_dept_and_work_center($date, $dept_crop, $work_center) {
        $work_center_string = "'" . $work_center . "'";
        
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                            FROM TT_PRODUCTION_RESULT PR 
                                            INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                            INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                            WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PP.CHR_WORK_CENTER = $work_center_string");
        } else {
            $query = $this->db->query("SELECT SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                            FROM TT_PRODUCTION_RESULT PR 
                                            INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                            INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                            WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_WORK_CENTER = $work_center_string");
        }
        
        return $query->row_array();
    }
    
    //ACCU
    function select_data_prod_entry_by_date_and_dept_and_work_center($date, $dept_crop, $work_center) {
        $work_center_string = "'" . $work_center . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE, PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, SUM(PR.INT_NG_PRC) AS INT_NG_PRC, SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
		SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
		SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL, SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PP.CHR_WORK_CENTER = $work_center_string
                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE
                    ORDER BY PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE, PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, SUM(PR.INT_NG_PRC) AS INT_NG_PRC, SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
		SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
		SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL, SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1) 
                    WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_WORK_CENTER = $work_center_string
                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE
                    ORDER BY PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_BACK_NO");
        }

        return $query->result();
    }

    //DIAGRAM ACCU
    function select_total_part_work_center_by_dept_and_date($date, $dept_crop) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop
									GROUP BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date 
									GROUP BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //ACCU
    function select_total_part_work_center_by_dept_and_date_and_work_center($date, $dept_crop, $work_center) {
        $work_center_string = "'" . $work_center . "'";
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY)+ SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string
										GROUP BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY)+ SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_WORK_CENTER = $work_center_string 
										GROUP BY PR.CHR_WORK_CENTER");
        }
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
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop
					ORDER BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select TOP(1) PR.CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER
					ORDER BY PR.CHR_WORK_CENTER");
        }

        return $query->row_array();
    }

    function get_period_work_center_by_dept($dept_crop) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT DISTINCT PR.CHR_DATE FROM TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER WHERE PP.CHR_PERSON_RESPONSIBLE = $dept_crop
					ORDER BY PR.CHR_DATE");
        } else {
            $query = $this->db->query("SELECT DISTINCT PR.CHR_DATE FROM TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER
					ORDER BY PR.CHR_DATE");
        }

        return $query->result();
    }

}
?>

