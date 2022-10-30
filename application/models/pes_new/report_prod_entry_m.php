<?php

class report_prod_entry_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //grid data
    function select_data_prod_entry_by_date_and_dept($date, $dept_crop) { //ini dipake
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT 
		LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
		SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
		PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
		PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop 
                GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        } else {
            $query = $this->db->query("SELECT 
		LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
		SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
		PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
		PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE LEFT(PR.CHR_DATE,6) = $date 
                GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        }

        return $query->result();
    }

    function select_data_prod_entry_by_shift_and_dept($dept_crop, $shift) {
        $shift_string = "'" . $shift . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT 
		LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
		SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
		PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
		PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE PR.CHR_SHIFT = $shift_string AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        } else {
            $query = $this->db->query("SELECT 
		LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
		SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
		PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
		PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE PR.CHR_SHIFT = $shift_string GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        }
        return $query->result();
    }

    function select_data_prod_entry_by_shift_and_dept_and_workcenter($dept_crop, $shift, $work_center) {
        $shift_string = "'" . $shift . "'";
        $work_center_string = "'" . $work_center . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT 
		LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
		SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
		PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
		PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE PR.CHR_SHIFT = $shift_string AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string
                GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        } else {
            $query = $this->db->query("SELECT 
		LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
		SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
		PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
		PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE PR.CHR_SHIFT = $shift_string AND PR.CHR_WORK_CENTER = $work_center_string
                GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        }

        return $query->result();
    }

    //table date+period+shift
    function select_data_prod_entry_by_date_and_dept_and_shift_and_periode($date, $dept_crop, $shift, $periode) {
        $shift_string = "'" . $shift . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT 
		LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
		SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
		PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
		PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_SHIFT = $shift_string AND PR.CHR_DATE = $periode
                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        } else {
            $query = $this->db->query("SELECT 
		LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
		SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
		PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
		PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
		SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_SHIFT = $shift_string AND PR.CHR_DATE = $periode
                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        }

        return $query->result();
    }

    //table date+period
    function select_data_prod_entry_by_date_and_dept_and_periode($date, $dept_crop, $periode) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT 
                        LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                        SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                        PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                        PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                        SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                        SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                        SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                        SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                        SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                        SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                        SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                        SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_DATE = $periode
                        GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                        LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        } else {
            $query = $this->db->query("SELECT 
                        LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                        SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                        PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                        PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                        SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                        SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                        SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                        SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                        SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                        SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                        SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                        SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                    FROM TT_PRODUCTION_RESULT PR 
                    INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                    INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                    WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_DATE = $periode
                        GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                        LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
        }
        return $query->result();
    }

    //table wc+periode-shift
    function select_data_prod_entry_by_date_and_dept_and_periode_and_workcenter($date, $dept_crop, $periode, $work_center) {
        $work_center_string = "'" . $work_center . "'";
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            if ($work_center_string == 'ALL') {
                $query = $this->db->query("SELECT 
                        LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                        SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                        PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                        PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                        SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                        SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                        SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                        SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                        SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                        SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                        SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                        SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                        FROM TT_PRODUCTION_RESULT PR 
                                        INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                        INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                        WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                        LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            } else {
                $query = $this->db->query("SELECT 
                        LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                        SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                        PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                        PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                        SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                        SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                        SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                        SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                        SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                        SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                        SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                        SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                        FROM TT_PRODUCTION_RESULT PR 
                                        INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                        INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                        WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                        LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            }
        } else {
            if ($work_center_string == 'ALL') {
                $query = $this->db->query("SELECT 
                        LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                        SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                        PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                        PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                        SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                        SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                        SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                        SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                        SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                        SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                        SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                        SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                        FROM TT_PRODUCTION_RESULT PR 
                                        INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                        INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                        WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                        LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            } else {
                $query = $this->db->query("SELECT 
                        LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                        SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                        PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                        PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                        SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                        SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                        SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                        SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                        SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                        SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                        SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                        SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                        FROM TT_PRODUCTION_RESULT PR 
                                        INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                        INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                        WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE,
                        LEFT(PR.CHR_DATE,4),SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            }
        }
        return $query->result();
    }

    //table wc+periode-shift
    function select_data_prod_entry_by_date_and_dept_and_workcenter($date, $dept_crop, $work_center) { //
        $work_center_string = "'" . $work_center . "'";
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            if ($work_center_string == 'ALL') {
                $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                                                    SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                                    PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                                                    PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                                                    SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                                                    SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                                                    SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                                                    SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                        FROM TT_PRODUCTION_RESULT PR 
                                        INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                        INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                        WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop 
                                        GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, 
                                                    PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),
                                                    SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),
                                                    PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            } else {
                $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                                                    SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                                    PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                                                    PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                                                    SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                                                    SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                                                    SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                                                    SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
                                        FROM TT_PRODUCTION_RESULT PR 
                                        INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
                                        INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
                                        WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string 
                                        GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, 
                                                    PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),
                                                    SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),
                                                    PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            }
        } else {
            if ($work_center_string == 'ALL') {
                $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                                                    SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                                    PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                                                    PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                                                    SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                                                    SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                                                    SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                                                    SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
									FROM TT_PRODUCTION_RESULT PR 
									INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
									WHERE LEFT(PR.CHR_DATE,6) = $date
                                                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, 
                                                    PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),
                                                    SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),
                                                    PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            } else {
                $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                                                    SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                                    PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                                                    PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                                                    SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                                                    SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                                                    SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                                                    SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
									FROM TT_PRODUCTION_RESULT PR 
									INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_WORK_CENTER = $work_center_string
                                                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, 
                                                    PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),
                                                    SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),
                                                    PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            }
        }

        return $query->result();
    }

    //table wc+period
    function select_data_prod_entry_by_date_and_dept_and_shift_and_periode_and_workcenter($date, $dept_crop, $shift, $periode, $work_center) {
        $work_center_string = "'" . $work_center . "'";
        $shift_string = "'" . $shift . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            if ($work_center_string == 'ALL') {
                $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                                                    SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                                    PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                                                    PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                                                    SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                                                    SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                                                    SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                                                    SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
									FROM TT_PRODUCTION_RESULT PR 
									INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_SHIFT = $shift_string AND PR.CHR_DATE = $periode
                                                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, 
                                                    PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),
                                                    SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),
                                                    PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            } else {
                $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                                                    SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                                    PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                                                    PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                                                    SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                                                    SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                                                    SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                                                    SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
									FROM TT_PRODUCTION_RESULT PR 
									INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_SHIFT = $shift_string AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode
                                                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, 
                                                    PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),
                                                    SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),
                                                    PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            }
        } else {
            if ($work_center_string == 'ALL') {
                $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                                                    SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                                    PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                                                    PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                                                    SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                                                    SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                                                    SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                                                    SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
									FROM TT_PRODUCTION_RESULT PR 
									INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_SHIFT = $shift_string AND PR.CHR_DATE = $periode
                                                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, 
                                                    PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),
                                                    SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),
                                                    PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            } else {
                $query = $this->db->query("SELECT LEFT(PR.CHR_DATE,4) as CHR_ONLY_YEAR,SUBSTRING(PR.CHR_DATE,7,2) as CHR_ONLY_DATE,  
                                                    SUBSTRING(PR.CHR_DATE,5,2) as CHR_ONLY_MONTH, PP.CHR_PERSON_RESPONSIBLE,
                                                    PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, 
                                                    PR.CHR_DATE, PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, 
                                                    SUM(PR.INT_QTY_OK) AS INT_QTY_OK, 
                                                    SUM(PR.INT_NG_PRC) AS INT_NG_PRC, 
                                                    SUM(PR.INT_NG_BRKNTEST) AS INT_NG_BRKNTEST, 
                                                    SUM(PR.INT_NG_SETUP) AS INT_NG_SETUP, 
                                                    SUM(PR.INT_NG_TRIAL) AS INT_NG_TRIAL, 
                                                    SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY,
                                                    SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_NG,
                                                    SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL
									FROM TT_PRODUCTION_RESULT PR 
									INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									INNER JOIN TM_DEPT D ON LEFT(D.CHR_DEPT,2) = 'PR' AND RIGHT(CHR_DEPT,1) = RIGHT(PP.CHR_PERSON_RESPONSIBLE,1)
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_SHIFT = $shift_string AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode
                                                    GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, PR.CHR_BACK_NO, PR.CHR_PART_NAME, PR.CHR_DATE, 
                                                    PR.CHR_SHIFT, D.CHR_DEPT, PR.CHR_TYPE, LEFT(PR.CHR_DATE,4),
                                                    SUBSTRING(PR.CHR_DATE,7,2),SUBSTRING(PR.CHR_DATE,5,2),
                                                    PP.CHR_PERSON_RESPONSIBLE, RIGHT(PR.CHR_DATE,2)");
            }
        }

        return $query->result();
    }

    //diagram buat tampilan
    function select_total_part_work_center_by_dept_and_date($date, $dept_crop) { //ini dipake
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop GROUP BY PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date GROUP BY PR.CHR_BACK_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_shift_and_date($dept_crop, $shift) {
        $shift_string = "'" . $shift . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE PR.CHR_SHIFT = $shift_string AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop GROUP BY PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE PR.CHR_SHIFT = $shift_string  GROUP BY PR.CHR_BACK_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_shift_and_date_and_workcenter($dept_crop, $shift, $work_center) {
        $shift_string = "'" . $shift . "'";
        $work_center_string = "'" . $work_center . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE PR.CHR_SHIFT = $shift_string AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string GROUP BY PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE PR.CHR_SHIFT = $shift_string AND PR.CHR_WORK_CENTER = $work_center_string  GROUP BY PR.CHR_BACK_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_dept_and_date_and_shift_and_periode($date, $dept_crop, $shift, $periode) {
        $shift_string = "'" . $shift . "'";
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_SHIFT = $shift_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_SHIFT = $shift_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_BACK_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_dept_and_date_and_periode($date, $dept_crop, $periode) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_DATE = $periode GROUP BY PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_DATE = $periode GROUP BY PR.CHR_BACK_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //diagram wc+periode-shift
    function select_total_part_work_center_by_dept_and_date_and_shift_and_periode_and_workcenter($date, $dept_crop, $shift, $periode, $work_center) {
        $work_center_string = "'" . $work_center . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            if ($shift == 0) {
                $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode  GROUP BY PR.CHR_BACK_NO");
            } else {
                $shift_string = "'" . $shift . "'";

                $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_SHIFT = $shift_string AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode  GROUP BY PR.CHR_BACK_NO");
            }
        } else {
            if ($shift == 0) {
                $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode  GROUP BY PR.CHR_BACK_NO");
            } else {
                $shift_string = "'" . $shift . "'";

                $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_SHIFT = $shift_string AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_BACK_NO");
            }
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_prod_by_dept_and_date_and_workcenter($date, $dept_crop, $work_center) {
        $work_center_string = "'" . $work_center . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string GROUP BY PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_WORK_CENTER = $work_center_string GROUP BY PR.CHR_BACK_NO");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_dept_and_date_and_work_center_and_shift($date, $dept_crop, $work_center, $shift) {
        $work_center_string = "'" . $work_center . "'";
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_SHIFT = $shift GROUP BY PR.CHR_BACK_NO");
        } else {
            $query = $this->db->query("SELECT PR.CHR_BACK_NO, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_SHIFT = $shift  GROUP BY PR.CHR_BACK_NO");
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
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop
					ORDER BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select TOP(1) PR.CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
					ORDER BY PR.CHR_WORK_CENTER");
        }

        return $query->row_array();
    }

    function get_period_work_center_by_dept($dept_crop) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT DISTINCT PR.CHR_DATE FROM TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO WHERE PP.CHR_PERSON_RESPONSIBLE = $dept_crop
					ORDER BY PR.CHR_DATE");
        } else {
            $query = $this->db->query("SELECT DISTINCT PR.CHR_DATE FROM TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
					ORDER BY PR.CHR_DATE");
        }

        return $query->result();
    }

    //diagram buat tampilan si supervisor
    function select_total_part_work_center_by_dept_and_date_by_manager($date, $dept_crop) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop GROUP BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date  GROUP BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_shift_and_date_by_manager($dept_crop, $shift) {
        $shift_string = "'" . $shift . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE PR.CHR_SHIFT = $shift_string AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop GROUP BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE PR.CHR_SHIFT = $shift_string GROUP BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_dept_and_date_and_shift_and_periode_by_manager($date, $dept_crop, $shift, $periode) {
        $shift_string = "'" . $shift . "'";
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_SHIFT = $shift_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_SHIFT = $shift_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_dept_and_date_and_periode_by_manager($date, $dept_crop, $periode) {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //diagram wc+periode-shift
    function select_total_part_work_center_by_dept_and_date_and_shift_and_periode_and_workcenter_by_manager($date, $dept_crop, $shift, $periode, $work_center) {
        $work_center_string = "'" . $work_center . "'";

        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            if ($shift == 0) {
                $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER");
            } else {
                $shift_string = "'" . $shift . "'";

                $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_SHIFT = $shift_string AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER");
            }
        } else {
            if ($shift == 0) {
                $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER");
            } else {
                $shift_string = "'" . $shift . "'";

                $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
										FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
										WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_SHIFT = $shift_string AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_DATE = $periode GROUP BY PR.CHR_WORK_CENTER");
            }
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function select_total_part_work_center_by_dept_and_date_and_work_center_and_shift_by_manager($date, $dept_crop, $work_center, $shift) {
        $work_center_string = "'" . $work_center . "'";
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_SHIFT = $shift GROUP BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL_QTY
									FROM TT_PRODUCTION_RESULT PR INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
									WHERE LEFT(PR.CHR_DATE,6) = $date AND PR.CHR_WORK_CENTER = $work_center_string AND PR.CHR_SHIFT = $shift GROUP BY PR.CHR_WORK_CENTER");
        }
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

}
?>

