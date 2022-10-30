<?php

class propose_budget_m extends CI_Model {

    // ---------------------------- // EDIT BY ANP // ------------------------//
    function get_all_dept(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT")->result();
        return $all_dept;
    }
    
    function get_kode_group($dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $get_group = $bgt_aii->query("SELECT CHR_KODE_GROUP
                                          FROM BDGT_TM_DEPARTMENT
                                          WHERE CHR_KODE_DEPARTMENT = '$dept'")->row();
        return $get_group;
    }

    function get_group_dept($kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $group_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT
                                    WHERE CHR_KODE_GROUP = '$kode_group' AND CHR_KODE_DEPARTMENT NOT IN ('QAS','QSY')")->result();
        return $group_dept;
    }
    
    function get_user_dept($id_dept){
        $kode_dept_ais = $this->db->query("SELECT CHR_DEPT
                                           FROM TM_DEPT
                                           WHERE INT_ID_DEPT = '$id_dept'")->row();        
        return $kode_dept_ais;
    }
    
    function get_list_section($kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $list_sect = $bgt_aii->query("SELECT CHR_DETILGROUP, CHR_USER_DESC
                                      FROM BDGT_TM_USER 
                                      WHERE CHR_DEPARTMENT = '$kode_dept'
                                      ORDER BY CHR_DETILGROUP DESC")->result();
            
        return $list_sect;
    }
    
    function get_costcenter($sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $costcenter = $bgt_aii->query("SELECT CHR_USERID,
                                              CHR_KODE_COSTCENTER
                                       FROM BDGT_TM_USER 
                                       WHERE CHR_DETILGROUP = '$sect'")->row();
        return $costcenter;
    }
        
    function get_all_budget_type(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_type = $bgt_aii->query("SELECT CHR_BUDGET_TYPE, 
                                            CHR_BUDGET_TYPE_DESC
                                     FROM BDGT_TM_BUDGET_TYPE 
                                     WHERE CHR_FLG_DELETE <> 1")->result();
        return $bgt_type;
    }
    
    function get_exist_unbudget($bgt_type, $year, $dept, $sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($bgt_type == "CAPEX"){
            $unbudget = $bgt_aii->query("SELECT CHR_NO_BUDGET 
                                        FROM BDGT_TM_BUDGET_CAPEX 
                                        WHERE CHR_KODE_DEPARTMENT = '$dept' 
                                            AND CHR_KODE_SECTION = '$sect'
                                            AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                            AND CHR_FLG_UNBUDGET = '1' 
                                            AND CHR_TAHUN_BUDGET = '$year' 
                                        ORDER BY RIGHT(CHR_NO_BUDGET, 6) DESC")->row();
            return $unbudget;
        } else {
            $unbudget = $bgt_aii->query("SELECT CHR_NO_BUDGET 
                                        FROM BDGT_TM_BUDGET_EXPENSE
                                        WHERE CHR_KODE_DEPARTMENT = '$dept' 
                                            AND CHR_KODE_SECTION = '$sect'
                                            AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                            AND CHR_FLG_UNBUDGET = '1' 
                                            AND CHR_TAHUN_BUDGET = '$year' 
                                        ORDER BY RIGHT(CHR_NO_BUDGET, 6) DESC")->row();
            return $unbudget;
        }
    }
    
    function get_prefix($bgt_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $prefix = $bgt_aii->query("SELECT CHR_PREFIX_BUDGET 
                                   FROM BDGT_TM_BUDGET_TYPE 
                                   WHERE CHR_BUDGET_TYPE='$bgt_type' AND CHR_FLG_DELETE = '0'")->row();
        return $prefix;        
    }
    
    function get_list_category($bgt_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $list_category = $bgt_aii->query("SELECT CHR_KODE_SUBCATEGORY_BUDGET,
                                                CHR_DESC_SUBCATEGORY_BUDGET 
                                         FROM BDGT_TM_SUBCATEGORY_BUDGET 
                                         WHERE CHR_GROUP_TYPE = '$bgt_type' 
                                           AND CHR_FLG_DELETE = 0 
                                           AND CHR_FLG_ACTIVE = 1")->result();
        return $list_category;
    }
    
    function get_list_purpose(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $list_purpose = $bgt_aii->query("SELECT CHR_KODE_PURPOSE_BUDGET,
                                                 CHR_DESC_PURPOSE_BUDGET 
                                          FROM BDGT_TM_PURPOSE_BUDGET
                                          WHERE CHR_FLG_DELETE = '0'")->result();
        return $list_purpose;
    }
    
    function get_list_project(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $list_project = $bgt_aii->query("SELECT CHR_PROJECT_NUMBER,
                                                CHR_PROJECT_NAME 
                                         FROM BDGT_TM_PROJECT")->result();
        return $list_project;
    }
    
    function get_list_budget_proposed($no_propose){
        $all_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_NO_BUDGET, CHR_BUDGET_TYPE, CHR_TRANS_DATE, CHR_DEPT, 
                                            CHR_YEAR_ACTUAL, CHR_MONTH_ACTUAL, CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE,
                                            MON_LIMIT_BLN, MON_REAL_BLN, MON_PROPOSE_BLN
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE ='$no_propose'")->result();
        return $all_propose;
    }
    
    function get_list_budget_proposed_gm($no_propose){
        $all_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_NO_BUDGET, CHR_BUDGET_TYPE, CHR_TRANS_DATE, CHR_DEPT, 
                                            CHR_YEAR_ACTUAL, CHR_MONTH_ACTUAL, CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE,
                                            MON_PROPOSE_BLN
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE ='$no_propose'
                                            AND CHR_FLG_PROPOSED = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $all_propose;
    }
    
    function get_list_budget_proposed_bod($no_propose){
        $all_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_NO_BUDGET, CHR_BUDGET_TYPE, CHR_TRANS_DATE, CHR_DEPT, 
                                            CHR_YEAR_ACTUAL, CHR_MONTH_ACTUAL, CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE,
                                            MON_PROPOSE_BLN, INT_QTY, CHR_FLG_RESCHEDULE, CHR_FLG_UNBUDGET, CHR_FLG_CHANGE_AMOUNT
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE ='$no_propose'
                                            AND CHR_FLG_PROPOSED = '1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $all_propose;
    }
    
    function get_all_propose($fiscal_start, $kode_dept, $year, $month){
        $all_propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_DEPT, 
                                            CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE, CHR_FLG_SWITCH  
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_DEPT = '$kode_dept'
                                            AND CHR_YEAR_BUDGET = '$fiscal_start'
                                            AND CHR_YEAR_PROPOSE = '$year'
                                            AND CHR_MONTH_PROPOSE ='$month'
                                            AND CHR_FLG_DELETE_PROP <> '1'")->result();
        return $all_propose;
    }
    
    function get_all_propose_gm($fiscal_start, $kode_dept, $year, $month){
        $all_propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_DEPT, 
                                            CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE  
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_DEPT = '$kode_dept'
                                            AND CHR_YEAR_BUDGET = '$fiscal_start'
                                            AND CHR_YEAR_PROPOSE = '$year'
                                            AND CHR_MONTH_PROPOSE ='$month'
                                            AND CHR_FLG_SWITCH = '1'")->result();
        return $all_propose;
    }
    
    function get_all_propose_bod($fiscal_start, $kode_dept, $year, $month){
        $all_propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_DEPT, 
                                            CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE  
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_DEPT = '$kode_dept'
                                            AND CHR_YEAR_BUDGET = '$fiscal_start'
                                            AND CHR_YEAR_PROPOSE = '$year'
                                            AND CHR_MONTH_PROPOSE ='$month'
                                            AND CHR_FLG_SWITCH = '2'")->result();
        return $all_propose;
    }
    
    function get_propose($no_propose){
        $propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_DEPT, CHR_YEAR_BUDGET, 
                                            CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE 
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
        return $propose;
    }
    
    function get_summary_propose($no_propose){
        $sum_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_DEPT, CHR_BUDGET_TYPE, 
                                            SUM(MON_PLAN_BLN) AS TOT_PLAN_BLN, SUM(MON_LIMIT_BLN) AS TOT_LIM_BLN, 
                                            SUM(MON_REAL_BLN) AS TOT_REAL_BLN, SUM(MON_PROPOSE_BLN) AS TOT_PROPOSE_BLN
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                        GROUP BY CHR_NO_PROPOSE, CHR_DEPT, CHR_BUDGET_TYPE")->result();
        return $sum_propose;
    }
    
    function get_all_budget($fiscal_start, $kode_dept, $year, $month){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
                                            CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT, 
                                            MON_BLN$month AS TOT_PLAN, 
                                            (MON_BLN$month * 0.7) AS TOT_LIMIT,
                                            MON_OPRBLN$month AS TOT_REAL 
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_TAHUN_ACTUAL = '$year' 
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                            AND MON_BLN$month <> 0 
                                            AND CHR_FLG_APPROVAL_PROCESS <> 1 
                                            AND CHR_FLG_DELETE <> 1
                                            AND CHR_FLG_CANCEL <> 1
                                            AND CHR_FLG_USED <> 1
                                    UNION 
                                    SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
                                            CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                            MON_BLN$month AS TOT_PLAN, 
                                            (MON_BLN$month * 0.7) AS TOT_LIMIT,
                                            MON_OPRBLN$month AS TOT_REAL 
                                    FROM BDGT_TM_BUDGET_EXPENSE 
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_TAHUN_ACTUAL = '$year' 
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                            AND MON_BLN$month <> 0 
                                            AND CHR_FLG_APPROVAL_PROCESS <> 1
                                            AND CHR_FLG_DELETE <> 1
                                            AND CHR_FLG_CANCEL <> 1")->result();
        return $all_budget;
    }
    
    function get_exist_budget($fiscal_start, $kode_dept, $year, $month, $no_budget){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
                                           CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT, 
                                           TOT_PLAN, TOT_LIMIT, TOT_REAL 
                                    FROM (SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
                                                 CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT, 
                                                 MON_BLN$month AS TOT_PLAN, MON_BLN$month * 0.7 AS TOT_LIMIT, MON_OPRBLN$month AS TOT_REAL 
                                          FROM DB_BUDGET_AII.dbo.BDGT_TM_BUDGET_CAPEX 
                                          WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                               AND CHR_TAHUN_ACTUAL = '$year' 
                                               AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                               AND MON_BLN$month <> 0 
                                               AND CHR_FLG_APPROVAL_PROCESS <> 1 
                                               AND CHR_FLG_DELETE <> 1
                                               AND CHR_FLG_CANCEL <> 1
                                               AND CHR_FLG_USED <> 1
                                         UNION 
                                         SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
                                                CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                MON_BLN$month AS TOT_PLAN, (MON_BLN$month * 0.7) AS TOT_LIMIT, MON_OPRBLN$month AS TOT_REAL 
                                         FROM DB_BUDGET_AII.dbo.BDGT_TM_BUDGET_EXPENSE 
                                         WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                              AND CHR_TAHUN_ACTUAL = '$year' 
                                              AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                              AND MON_BLN$month <> 0 
                                              AND CHR_FLG_APPROVAL_PROCESS <> 1
                                              AND CHR_FLG_DELETE <> 1
                                              AND CHR_FLG_CANCEL <> 1) AS AB
                                    WHERE CHR_NO_BUDGET NOT IN ($no_budget)")->result();
                                                        //AND CHR_FLG_PROPOSED <> '2'")->result();
        return $all_budget;
    }
    
//    function get_budget_other_month($fiscal_start, $kode_dept, $bgt_type, $year, $month){
//        $bgt_aii = $this->load->database("bgt_aii", TRUE);
//        if($bgt_type == "CAPEX"){
//            $list_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
//                                                CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT, 
//                                                MON_BLN$month AS TOT_PLAN, 
//                                                (MON_BLN$month * 0.7) AS TOT_LIMIT,
//                                                MON_OPRBLN$month AS TOT_REAL 
//                                    FROM BDGT_TM_BUDGET_CAPEX 
//                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
//                                            AND CHR_TAHUN_ACTUAL = '$year' 
//                                            AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                            AND MON_BLN$month <> 0 
//                                            AND CHR_FLG_APPROVAL_PROCESS <> 1 
//                                            AND CHR_FLG_DELETE <> 1
//                                            AND CHR_FLG_CANCEL <> 1
//                                            AND CHR_FLG_USED <> 1
//                                            AND CHR_NO_BUDGET NOT IN (SELECT CHR_NO_BUDGET 
//                                                                    FROM DB_AIS_DEV.CPL.TW_PROPOSE_BUDGET 
//                                                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
//                                                                            AND CHR_BUDGET_TYPE = 'CAPEX'
//                                                                            AND CHR_YEAR_ACTUAL = '$year'
//                                                                            AND CHR_MONTH_ACTUAL = '$month'
//                                                                            AND CHR_FLG_DELETE = 0)")->result();
//            return $list_budget;
//        } else {
//           $list_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
//                                                CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
//                                                MON_BLN$month AS TOT_PLAN, 
//                                                (MON_BLN$month * 0.7) AS TOT_LIMIT,
//                                                MON_OPRBLN$month AS TOT_REAL 
//                                    FROM BDGT_TM_BUDGET_EXPENSE 
//                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
//                                            AND CHR_TAHUN_ACTUAL = '$year' 
//                                            AND CHR_KODE_DEPARTMENT = '$kode_dept'
//                                            AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
//                                            AND MON_BLN$month <> 0 
//                                            AND CHR_FLG_APPROVAL_PROCESS <> 1
//                                            AND CHR_FLG_DELETE <> 1
//                                            AND CHR_FLG_CANCEL <> 1
//                                            AND CHR_NO_BUDGET NOT IN (SELECT CHR_NO_BUDGET 
//                                                                    FROM DB_AIS_DEV.CPL.TW_PROPOSE_BUDGET 
//                                                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
//                                                                            AND CHR_BUDGET_TYPE = '$bgt_type'
//                                                                            AND CHR_YEAR_ACTUAL = '$year'
//                                                                            AND CHR_MONTH_ACTUAL = '$month'
//                                                                            AND CHR_FLG_DELETE = 0)")->result();
//            return $list_budget; 
//        }        
//    }
    function get_exist_no_budget_prop ($fiscal_start, $kode_dept, $bgt_type, $year, $month){
        $exist_no_budget = $this->db->query("SELECT CHR_NO_BUDGET 
                                            FROM CPL.TW_PROPOSE_BUDGET 
                                            WHERE CHR_YEAR_BUDGET = '$fiscal_start'
                                                    AND CHR_BUDGET_TYPE LIKE '$bgt_type%'
                                                    AND CHR_YEAR_ACTUAL = '$year'
                                                    AND CHR_MONTH_ACTUAL = '$month'
                                                    AND (CHR_FLG_DELETE = '0' AND CHR_FLG_SWITCH <> '3')")->result();
        return $exist_no_budget;
    }
    
    function get_budget_other_month($fiscal_start, $kode_dept, $bgt_type, $year, $month, $no_budget){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($bgt_type == "CAPEX"){
            $list_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
                                                CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT, 
                                                MON_BLN$month AS TOT_PLAN, 
                                                MON_LIMBLN$month AS TOT_LIMIT,
                                                MON_OPRBLN$month AS TOT_REAL,
                                                0 AS TOT_QTY
                                    FROM BDGT_TM_BUDGET_CAPEX
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_TAHUN_ACTUAL = '$year' 
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                            AND MON_LIMBLN$month <> '0' 
                                            AND CHR_FLG_APPROVAL_PROCESS <> '1' 
                                            AND CHR_FLG_DELETE <> '1'
                                            AND CHR_FLG_CANCEL <> '1'
                                            --AND CHR_FLG_USED <> '1'
                                            AND CHR_NO_BUDGET NOT IN ($no_budget)")->result();
            return $list_budget;
        } else {
           $list_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
                                                CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                MON_BLN$month AS TOT_PLAN, 
                                                MON_LIMBLN$month AS TOT_LIMIT,
                                                MON_OPRBLN$month AS TOT_REAL,
                                                INT_QTY_LIMBLN$month AS TOT_QTY
                                    FROM BDGT_TM_BUDGET_EXPENSE
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_TAHUN_ACTUAL = '$year' 
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                            AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                            AND MON_LIMBLN$month <> '0' 
                                            AND CHR_FLG_APPROVAL_PROCESS <> '1'
                                            AND CHR_FLG_DELETE <> '1'
                                            AND CHR_FLG_CANCEL <> '1'
                                            AND CHR_NO_BUDGET NOT IN ($no_budget)")->result();
            return $list_budget; 
        }        
    }
    
    function get_exist_no_propose($fiscal_start, $year, $month, $kode_dept){
        $exist_no = $this->db->query("SELECT TOP 1 CHR_NO_PROPOSE
                                    FROM CPL.TW_PROPOSE_BUDGET
                                    WHERE CHR_YEAR_BUDGET = '$fiscal_start'
                                        AND CHR_DEPT = '$kode_dept'
                                        AND CHR_YEAR_PROPOSE = '$year'
                                        AND CHR_MONTH_PROPOSE = '$month'
                                    ORDER BY INT_ID_PROPOSE DESC")->row();
        return $exist_no;
    }
    
    function insert_reschedule($prop_budget) {
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->insert($tabel_master, $prop_budget);              
    }
    
    function save_propose_budget($propose) {
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->insert($tabel_master, $propose);              
    }
    
    function update_proposed_budget($proposed, $no_propose, $no_budget, $year, $month) {
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);
        $this->db->where('CHR_NO_BUDGET', $no_budget);
        $this->db->where('CHR_YEAR_ACTUAL', $year);
        $this->db->where('CHR_MONTH_ACTUAL', $month);
        $this->db->update($tabel_master, $proposed);              
    }
    
    function approved_propose_budget_gm($proposed, $no_propose, $no_budget, $year, $month) {
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);
        $this->db->where('CHR_NO_BUDGET', $no_budget);
        $this->db->where('CHR_YEAR_ACTUAL', $year);
        $this->db->where('CHR_MONTH_ACTUAL', $month);
        $this->db->update($tabel_master, $proposed);              
    }
    
    function approved_propose_budget_bod($proposed, $no_propose, $no_budget, $year, $month) {
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);
        $this->db->where('CHR_NO_BUDGET', $no_budget);
        $this->db->where('CHR_YEAR_ACTUAL', $year);
        $this->db->where('CHR_MONTH_ACTUAL', $month);
        $this->db->update($tabel_master, $proposed);              
    }
    
    function update_master_budget($update_master, $no_budget, $budget_type, $year_prop) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $tabel_master = "BDGT_TM_BUDGET_CAPEX";
            $bgt_aii->where('CHR_NO_BUDGET', $no_budget);
            $bgt_aii->update($tabel_master, $update_master);
        } else {
            $tabel_master = "BDGT_TM_BUDGET_EXPENSE";
            $bgt_aii->where('CHR_NO_BUDGET', $no_budget);
            $bgt_aii->where('CHR_TAHUN_ACTUAL', $year_prop);
            $bgt_aii->update($tabel_master, $update_master);
        }                     
    }
    
    function update_flag_master_budget($update_flag, $no_budget, $budget_type) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $tabel_master = "BDGT_TM_BUDGET_CAPEX";
            $bgt_aii->where('CHR_NO_BUDGET', $no_budget);
            $bgt_aii->update($tabel_master, $update_flag);
        } else {
            $tabel_master = "BDGT_TM_BUDGET_EXPENSE";
            $bgt_aii->where('CHR_NO_BUDGET', $no_budget);
            $bgt_aii->update($tabel_master, $update_flag);
        }                     
    }
    
    function update_switch_propose($switch, $no_propose){
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);        
        $this->db->update($tabel_master, $switch);    
    }
    
    // --------------- GET DETAIL PROPOSE ------------------------------------//
    function get_propose_capex($no_propose){
        $prop_capex = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'CAPEX'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_capex;
    }
    
    function get_propose_repma($no_propose){
        $prop_repma = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'REPMA'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_repma;
    }
    
    function get_propose_tooeq($no_propose){
        $prop_tooeq = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'TOOEQ'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_tooeq;
    }
    
    function get_propose_offeq($no_propose){
        $prop_offeq = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'OFFEQ'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_offeq;
    }
    
    function get_propose_trial($no_propose){
        $prop_trial = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'TRIAL'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_trial;
    }
    
    function get_propose_empwa($no_propose){
        $prop_empwa = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'EMPWA'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_empwa;
    }
    
    function get_propose_engfe($no_propose){
        $prop_engfe = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'ENGFE'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_engfe;
    }
    
    function get_propose_itexp($no_propose){
        $prop_itexp = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'ITEXP'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_itexp;
    }
    
    function get_propose_renta($no_propose){
        $prop_renta = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'RENTA'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_renta;
    }
    
    function get_propose_rndev($no_propose){
        $prop_rndev = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'RNDEV'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_rndev;
    }
    
    function get_propose_donat($no_propose){
        $prop_donat = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'DONAT'
                                        ORDER BY CHR_NO_BUDGET")->result();
        return $prop_donat;
    }
    //--------------------- END DETAIL OF PROPOSE ----------------------------//
    
    //--------------------- DETAIL PROPOSE BY GM -----------------------------//
    function get_propose_capex_gm($no_propose){
        $prop_capex = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'CAPEX'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_capex;
    }
    
    function get_propose_repma_gm($no_propose){
        $prop_repma = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'REPMA'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_repma;
    }
    
    function get_propose_tooeq_gm($no_propose){
        $prop_tooeq = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'TOOEQ'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_tooeq;
    }
    
    function get_propose_offeq_gm($no_propose){
        $prop_offeq = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'OFFEQ'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_offeq;
    }
    
    function get_propose_trial_gm($no_propose){
        $prop_trial = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'TRIAL'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_trial;
    }
    
    function get_propose_empwa_gm($no_propose){
        $prop_empwa = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'EMPWA'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_empwa;
    }
    
    function get_propose_engfe_gm($no_propose){
        $prop_engfe = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ENGFE'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_engfe;
    }
    
    function get_propose_itexp_gm($no_propose){
        $prop_itexp = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ITEXP'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_itexp;
    }
    
    function get_propose_renta_gm($no_propose){
        $prop_renta = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RENTA'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_renta;
    }
    
    function get_propose_rndev_gm($no_propose){
        $prop_rndev = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RNDEV'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_rndev;
    }
    
    function get_propose_donat_gm($no_propose){
        $prop_donat = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'DONAT'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM <> '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_donat;
    }
    //--------------------- END DETAIL PROPOSE BY GM -------------------------//
    
    //--------------------- DETAIL PROPOSE BY BOD -----------------------------//
    function get_propose_capex_bod($no_propose){
        $prop_capex = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'CAPEX'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_capex;
    }
    
    function get_propose_repma_bod($no_propose){
        $prop_repma = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'REPMA'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_repma;
    }
    
    function get_propose_tooeq_bod($no_propose){
        $prop_tooeq = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'TOOEQ'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_tooeq;
    }
    
    function get_propose_offeq_bod($no_propose){
        $prop_offeq = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'OFFEQ'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();;
        return $prop_offeq;
    }
    
    function get_propose_trial_bod($no_propose){
        $prop_trial = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'TRIAL'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_trial;
    }
    
    function get_propose_empwa_bod($no_propose){
        $prop_empwa = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'EMPWA'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_empwa;
    }
    
    function get_propose_engfe_bod($no_propose){
        $prop_engfe = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ENGFE'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_engfe;
    }
    
    function get_propose_itexp_bod($no_propose){
        $prop_itexp = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ITEXP'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_itexp;
    }
    
    function get_propose_renta_bod($no_propose){
        $prop_renta = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RENTA'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_renta;
    }
    
    function get_propose_rndev_bod($no_propose){
        $prop_rndev = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RNDEV'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_rndev;
    }
    
    function get_propose_donat_bod($no_propose){
        $prop_donat = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'DONAT'
                                            AND CHR_FLG_PROPOSED ='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                        ORDER BY MON_PROPOSE_BLN DESC, CHR_NO_BUDGET")->result();
        return $prop_donat;
    }
    //--------------------- END DETAIL PROPOSE BY BOD -------------------------//
    
    function save_master_unbudget($data_unb, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $tabel_master = "BDGT_TM_BUDGET_CAPEX";
            $bgt_aii->insert($tabel_master, $data_unb);
        } else {
            $tabel_master = "BDGT_TM_BUDGET_EXPENSE";
            $bgt_aii->insert($tabel_master, $data_unb);
        }        
    }
    
    function save_propose_unbudget($proposed_unb){
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->insert($tabel_master, $proposed_unb);      
    }
    
    function check_switch($no_propose){
        $switch = $this->db->query("SELECT CHR_FLG_SWITCH 
                                        FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
        return $switch;
    }
    
    function delete_propose_budget($del_proposed, $no_propose){
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);        
        $this->db->update($tabel_master, $del_proposed);
    }
    
    //--------------------- DETAIL BUDGET PLAN PER MONTH ---------------------//
    function get_budget_detail($year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                     SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                     SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                     SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                     SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15 
                                            FROM (SELECT ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       0 AS PBLN13,0 AS PBLN14,0 AS PBLN15 
                                                FROM BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                     AND CHR_TAHUN_ACTUAL = '$year_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                UNION
                                                SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03, 
                                                       0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                       0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                       0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,
                                                       ISNULL(SUM(MON_BLN02),0) AS PBLN14,
                                                       ISNULL(SUM(MON_BLN03),0) AS PBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                      AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                      AND CHR_FLG_DELETE = '0'  
                                                      AND CHR_FLG_FOR_AIIA = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,
                                                                    MON_BLN01,MON_BLN02,MON_BLN03,
                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
                                                                    MON_BLN10,MON_BLN11,MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$year_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_DELETE = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //--------------------- DETAIL BUDGET LIMIT PER MONTH --------------------//
    function get_budget_limit($year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_limit = $bgt_aii->query("SELECT SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                       SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                       SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                       SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                       SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15 
                                            FROM(SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                        0 AS PBLN13,0 AS PBLN14,0 AS PBLN15 
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                       AND CHR_TAHUN_ACTUAL = '$year_start' 
                                                       AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                 UNION 
                                                 SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                        0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                        0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                       AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                       AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_limit;
        } else {
            $budget_limit = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                        AND CHR_TAHUN_ACTUAL = '$year_start' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                        AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_limit;
        }
    }
    
    //---------------------- DETAIL ACTUAL PER MONTH ----------------------//
    function get_actual_real($year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                 ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                 ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                 ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                 ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                 ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                 ISNULL(SUM(OPRBLN11),0) AS OPRBLN13, ISNULL(SUM(OPRBLN12),0) AS OPRBLN14,
                                                 ISNULL(SUM(OPRBLN11),0) AS OPRBLN15
                                          FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01 AS OPRBLN01, MON_OPRBLN02 AS OPRBLN02, 
                                                     MON_OPRBLN03 AS OPRBLN03, MON_OPRBLN04 AS OPRBLN04, 
                                                     MON_OPRBLN05 AS OPRBLN05, MON_OPRBLN06 AS OPRBLN06, 
                                                     MON_OPRBLN07 AS OPRBLN07, MON_OPRBLN08 AS OPRBLN08, 
                                                     MON_OPRBLN09 AS OPRBLN09, MON_OPRBLN10 AS OPRBLN10, 
                                                     MON_OPRBLN11 AS OPRBLN11, MON_OPRBLN12 AS OPRBLN12,
                                                     0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$year_start'
                                                      AND CHR_TAHUN_ACTUAL = '$year_start'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0') ACTUAL_CURR_YEAR
                                          LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                            MON_OPRBLN01 AS OPRBLN13, 
                                                            MON_OPRBLN02 AS OPRBLN14, 
                                                            MON_OPRBLN03 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$year_start'
                                                      AND CHR_TAHUN_ACTUAL = '$year_end'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0') ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $actual_real;
        } else {
            $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                 ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                 ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                 ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                 ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                 ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                 ISNULL(SUM(OPRBLN11),0) AS OPRBLN13, ISNULL(SUM(OPRBLN12),0) AS OPRBLN14,
                                                 ISNULL(SUM(OPRBLN11),0) AS OPRBLN15
                                          FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01 AS OPRBLN01, MON_OPRBLN02 AS OPRBLN02, 
                                                     MON_OPRBLN03 AS OPRBLN03, MON_OPRBLN04 AS OPRBLN04, 
                                                     MON_OPRBLN05 AS OPRBLN05, MON_OPRBLN06 AS OPRBLN06, 
                                                     MON_OPRBLN07 AS OPRBLN07, MON_OPRBLN08 AS OPRBLN08, 
                                                     MON_OPRBLN09 AS OPRBLN09, MON_OPRBLN10 AS OPRBLN10, 
                                                     MON_OPRBLN11 AS OPRBLN11, MON_OPRBLN12 AS OPRBLN12,
                                                     0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_EXPENSE
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$year_start'
                                                      AND CHR_TAHUN_ACTUAL = '$year_start'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_PROJECT = '0' ) ACTUAL_CURR_YEAR
                                          LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                            MON_OPRBLN01 AS OPRBLN13, 
                                                            MON_OPRBLN02 AS OPRBLN14, 
                                                            MON_OPRBLN03 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_EXPENSE
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$year_start'
                                                      AND CHR_TAHUN_ACTUAL = '$year_end'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_PROJECT = '0') ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $actual_real;
        }
    }
    
    //--------------------- DETAIL ACTUAL GR PER MONTH -----------------------//
    function get_actual_gr($start_date, $end_date, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_CAPEX 
                                            WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_BDGT_DEPT = '$kode_dept')")->row();
            return $actual_gr;
        } else {
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_BDGT_DEPT = '$kode_dept') ")->row();
            return $actual_gr;
        }            
    }
    
    function get_all_propose_budget($no_propose){
        $all_prop = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                        ORDER BY CHR_BUDGET_TYPE, CHR_NO_BUDGET")->result();
        return $all_prop;
    }
    
    function get_all_propose_budget_unb($no_propose){
        $all_prop = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_FLG_UNBUDGET = '1'
                                        ORDER BY CHR_BUDGET_TYPE, CHR_NO_BUDGET")->result();
        return $all_prop;
    }
    
    function get_only_propose_budget($no_propose){
        $all_prop = $this->db->query("SELECT * FROM CPL.TW_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_FLG_PROPOSED = '1'
                                        ORDER BY CHR_BUDGET_TYPE, CHR_NO_BUDGET")->result();
        return $all_prop;
    }
    
    //--------------------- END OF PROPOSE BUDGET ----------------------------//

    //===== START PROPOSE HERE WITH OLD FLOW - ANU 20220214 ======//   

    function get_list_master_budget($fiscal_start, $fiscal_end, $budget_type, $dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $list_master_budget = $bgt_aii->query("SELECT CHR_FLG_CIP,CHR_FLG_USED,CHR_DESC_BUDGET,
                                                           CHR_TAHUN_BUDGET,CHR_KODE_TYPE_BUDGET,
                                                           CHR_KODE_DEPARTMENT,CHR_NO_BUDGET,
                                                           MON_BLN01,MON_BLN02,MON_BLN03,MON_BLN04,
                                                           MON_BLN05,MON_BLN06,MON_BLN07,MON_BLN08,
                                                           MON_BLN09,MON_BLN10,MON_BLN11,MON_BLN12,
                                                           MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                           MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,
                                                           MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                           MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                           MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15, 
                                                           CHR_FLG_CANCEL,CHR_FLG_APPROVAL_PROCESS,
                                                           CHR_FLG_CHANGE_AMOUNT, CHR_FLG_RESCHEDULE
                                                FROM BDGT_TM_BUDGET_CAPEX
                                                WHERE CHR_KODE_DEPARTMENT LIKE '$dept%'
                                                        AND CHR_TAHUN_BUDGET = '$fiscal_start'          
                                                ORDER BY CHR_KODE_DEPARTMENT,CHR_NO_BUDGET")->result();
            return $list_master_budget;
        } else {
            $list_master_budget = $bgt_aii->query("SELECT CHR_DESC_BUDGET,CHR_TAHUN_BUDGET,CHR_KODE_TYPE_BUDGET,
                                                           CHR_KODE_DEPARTMENT,BDGT_START.CHR_NO_BUDGET,
                                                           MON_BLN01,MON_BLN02,MON_BLN03,MON_BLN04,
                                                           MON_BLN05,MON_BLN06,MON_BLN07,MON_BLN08,
                                                           MON_BLN09,MON_BLN10,MON_BLN11,MON_BLN12,
                                                           MON_BLN13,MON_BLN14,MON_BLN15,
                                                           INT_QTY_BLN01,INT_QTY_BLN02,INT_QTY_BLN03,INT_QTY_BLN04,
                                                           INT_QTY_BLN05,INT_QTY_BLN06,INT_QTY_BLN07,INT_QTY_BLN08,
                                                           INT_QTY_BLN09,INT_QTY_BLN10,INT_QTY_BLN11,INT_QTY_BLN12,
                                                           INT_QTY_BLN13,INT_QTY_BLN14,INT_QTY_BLN15,
                                                           MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,
                                                           MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                           MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                           MON_LIMBLN13,MON_LIMBLN14,MON_LIMBLN15,
                                                           INT_QTY_LIMBLN01,INT_QTY_LIMBLN02,INT_QTY_LIMBLN03,INT_QTY_LIMBLN04,
                                                           INT_QTY_LIMBLN05,INT_QTY_LIMBLN06,INT_QTY_LIMBLN07,INT_QTY_LIMBLN08,
                                                           INT_QTY_LIMBLN09,INT_QTY_LIMBLN10,INT_QTY_LIMBLN11,INT_QTY_LIMBLN12,
                                                           INT_QTY_LIMBLN13,INT_QTY_LIMBLN14,INT_QTY_LIMBLN15,
                                                           CHR_FLG_CANCEL,CHR_FLG_APPROVAL_PROCESS,
                                                           CHR_FLG_CHANGE_AMOUNT, CHR_FLG_RESCHEDULE
                                                FROM (SELECT CHR_KODE_ITEM AS CHR_DESC_BUDGET,
                                                                CHR_TAHUN_BUDGET,CHR_KODE_TYPE_BUDGET,
                                                                CHR_KODE_DEPARTMENT,CHR_NO_BUDGET,
                                                                MON_BLN01,MON_BLN02,MON_BLN03,MON_BLN04,
                                                                MON_BLN05,MON_BLN06,MON_BLN07,MON_BLN08,
                                                                MON_BLN09,MON_BLN10,MON_BLN11,MON_BLN12,
                                                                INT_QTY_BLN01,INT_QTY_BLN02,INT_QTY_BLN03,INT_QTY_BLN04,
                                                                INT_QTY_BLN05,INT_QTY_BLN06,INT_QTY_BLN07,INT_QTY_BLN08,
                                                                INT_QTY_BLN09,INT_QTY_BLN10,INT_QTY_BLN11,INT_QTY_BLN12,
                                                                MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,
                                                                MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                                MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                                INT_QTY_LIMBLN01,INT_QTY_LIMBLN02,INT_QTY_LIMBLN03,INT_QTY_LIMBLN04,
                                                                INT_QTY_LIMBLN05,INT_QTY_LIMBLN06,INT_QTY_LIMBLN07,INT_QTY_LIMBLN08,
                                                                INT_QTY_LIMBLN09,INT_QTY_LIMBLN10,INT_QTY_LIMBLN11,INT_QTY_LIMBLN12,
                                                                CHR_FLG_CANCEL,CHR_FLG_APPROVAL_PROCESS,
                                                                CHR_FLG_CHANGE_AMOUNT, CHR_FLG_RESCHEDULE
                                                        FROM BDGT_TM_BUDGET_EXPENSE 
                                                        WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                                AND CHR_KODE_DEPARTMENT LIKE '$dept%') BDGT_START  
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                                INT_QTY_BLN01 AS INT_QTY_BLN13,INT_QTY_BLN02 AS INT_QTY_BLN14,INT_QTY_BLN03 AS INT_QTY_BLN15,
                                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                                INT_QTY_LIMBLN01 AS INT_QTY_LIMBLN13,INT_QTY_LIMBLN02 AS INT_QTY_LIMBLN14,INT_QTY_LIMBLN03 AS INT_QTY_LIMBLN15 
                                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                                            WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                                        AND CHR_TAHUN_ACTUAL = '$fiscal_end'
                                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                                        AND CHR_KODE_DEPARTMENT LIKE '$dept%') BDGT_NEXT  ON BDGT_START.CHR_NO_BUDGET = BDGT_NEXT.CHR_NO_BUDGET")->result();
            return $list_master_budget;
        }
        
    }

    function get_detail_budget_by_no($fiscal_start, $fiscal_end, $budget_type, $no_budget){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $get_detail_budget = $bgt_aii->query("SELECT SUM(MON_LIMBLN01) AS PBLN01,SUM(MON_LIMBLN02) AS PBLN02,SUM(MON_LIMBLN03) AS PBLN03,SUM(MON_LIMBLN04) AS PBLN04,
                                                       SUM(MON_LIMBLN05) AS PBLN05,SUM(MON_LIMBLN06) AS PBLN06,SUM(MON_LIMBLN07) AS PBLN07,SUM(MON_LIMBLN08) AS PBLN08,
                                                       SUM(MON_LIMBLN09) AS PBLN09,SUM(MON_LIMBLN10) AS PBLN10,SUM(MON_LIMBLN11) AS PBLN11,SUM(MON_LIMBLN12) AS PBLN12,
                                                       SUM(MON_LIMBLN13) AS PBLN13,SUM(MON_LIMBLN14) AS PBLN14,SUM(MON_LIMBLN15) AS PBLN15
                                                FROM (SELECT 0 AS MON_LIMBLN01,0 AS MON_LIMBLN02, 0 AS MON_LIMBLN03,MON_LIMBLN04,
                                                           MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                           MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                           MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_NO_BUDGET = '$no_budget'
                                                          AND CHR_TAHUN_BUDGET = '$fiscal_start') AS TM_BUDGET_CAPEX_DETAIL")->row();
            return $get_detail_budget;
        } else {
            $get_detail_budget = $bgt_aii->query("SELECT SUM(MON_LIMBLN01) AS PBLN01,SUM(MON_LIMBLN02) AS PBLN02,SUM(MON_LIMBLN03) AS PBLN03,SUM(MON_LIMBLN04) AS PBLN04,
                                                       SUM(MON_LIMBLN05) AS PBLN05,SUM(MON_LIMBLN06) AS PBLN06,SUM(MON_LIMBLN07) AS PBLN07,SUM(MON_LIMBLN08) AS PBLN08,
                                                       SUM(MON_LIMBLN09) AS PBLN09,SUM(MON_LIMBLN10) AS PBLN10,SUM(MON_LIMBLN11) AS PBLN11,SUM(MON_LIMBLN12) AS PBLN12,
                                                       SUM(MON_LIMBLN13) AS PBLN13,SUM(MON_LIMBLN14) AS PBLN14,SUM(MON_LIMBLN15) AS PBLN15
                                                FROM (SELECT MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,
                                                           MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                           MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                           0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                FROM BDGT_TM_BUDGET_EXPENSE 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                          AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                                          AND CHR_NO_BUDGET = '$no_budget'
                                                UNION 
                                                SELECT  0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,0 AS MON_LIMBLN04,
                                                           0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,
                                                           0 AS MON_LIMBLN09,0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                           MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15
                                                FROM BDGT_TM_BUDGET_EXPENSE 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                          AND CHR_TAHUN_ACTUAL = '$fiscal_end'
                                                          AND CHR_NO_BUDGET = '$no_budget'
                                                          ) AS TM_BUDGET_EXPENSE_DETAIL")->row();
            return $get_detail_budget;
        }        
    }

    function get_list_dept($role, $kode_group, $dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($role == '1'){
            $list_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT
                                          FROM  BDGT_TM_DEPARTMENT")->result();
            
            return $list_dept;
        } else if($role == '4'){
            $list_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT
                                          FROM  BDGT_TM_DEPARTMENT
                                          WHERE CHR_KODE_GROUP = '$kode_group'")->result();
            
            return $list_dept;
        } else if($role == '5'){            
            $list_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT
                                          FROM  BDGT_TM_DEPARTMENT
                                          WHERE CHR_KODE_DEPARTMENT LIKE '$dept%'")->result();
            
            return $list_dept;
        }
    }

    function get_dept($kode_dept){
        $get_dept = $this->db->query("SELECT CHR_DEPT
                                          FROM TM_DEPT
                                          WHERE INT_ID_DEPT = '$kode_dept'")->row();
        return $get_dept;
    }

    function get_curr_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $get_curr_budget = $bgt_aii->query("SELECT CHR_FLG_PROJECT,
                                                        CHR_DESC_PROJECT,
                                                        CHR_FLG_RESCHEDULE,
                                                        CHR_FLG_CHANGE_AMOUNT,
                                                        CHR_FLG_UNBUDGET,
                                                        CHR_DESC_BUDGET,
                                                        CHR_TAHUN_BUDGET,
                                                        CHR_KODE_TYPE_BUDGET,
                                                        CHR_KODE_DEPARTMENT,
                                                        CHR_NO_BUDGET,
                                                        MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,
                                                        MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                        MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15,
                                                        0 AS INT_QTY_LIMBLN01,0 AS INT_QTY_LIMBLN02,0 AS INT_QTY_LIMBLN03,0 AS INT_QTY_LIMBLN04,0 AS INT_QTY_LIMBLN05,0 AS INT_QTY_LIMBLN06,
                                                        0 AS INT_QTY_LIMBLN07,0 AS INT_QTY_LIMBLN08,0 AS INT_QTY_LIMBLN09,0 AS INT_QTY_LIMBLN10,0 AS INT_QTY_LIMBLN11,0 AS INT_QTY_LIMBLN12,
                                                        0 AS INT_QTY_LIMBLN13,0 AS INT_QTY_LIMBLN14,0 AS INT_QTY_LIMBLN15,
                                                        CHR_FLG_CANCEL,
                                                        CHR_FLG_APPROVAL_PROCESS
                                             FROM BDGT_TM_BUDGET_CAPEX 
                                             WHERE CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                       AND CHR_NO_BUDGET = '$no_budget'
                                             UNION
                                             SELECT CHR_FLG_PROJECT,
                                                        CHR_DESC_PROJECT,
                                                        CHR_FLG_RESCHEDULE,
                                                        CHR_FLG_CHANGE_AMOUNT,
                                                        CHR_FLG_UNBUDGET,
                                                        CHR_DESC_BUDGET,
                                                        CHR_TAHUN_BUDGET,
                                                        CHR_KODE_TYPE_BUDGET,
                                                        CHR_KODE_DEPARTMENT,
                                                        CHR_NO_BUDGET,
                                                        0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,0 AS MON_LIMBLN04,
                                                        0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,
                                                        0 AS MON_LIMBLN09,0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                        0 AS INT_QTY_LIMBLN01,0 AS INT_QTY_LIMBLN02,0 AS INT_QTY_LIMBLN03,0 AS INT_QTY_LIMBLN04,0 AS INT_QTY_LIMBLN05,0 AS INT_QTY_LIMBLN06,
                                                        0 AS INT_QTY_LIMBLN07,0 AS INT_QTY_LIMBLN08,0 AS INT_QTY_LIMBLN09,0 AS INT_QTY_LIMBLN10,0 AS INT_QTY_LIMBLN11,0 AS INT_QTY_LIMBLN12,
                                                        0 AS INT_QTY_LIMBLN13,0 AS INT_QTY_LIMBLN14,0 AS INT_QTY_LIMBLN15,
                                                        CHR_FLG_CANCEL, CHR_FLG_APPROVAL_PROCESS
                                             FROM BDGT_TM_BUDGET_CAPEX 
                                             WHERE CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                       AND CHR_NO_BUDGET = '$no_budget'")->row();
            return $get_curr_budget;
        } else {
            $get_curr_budget = $bgt_aii->query("SELECT CHR_FLG_PROJECT,
                                                     CHR_DESC_PROJECT,
                                                     CHR_FLG_RESCHEDULE,
                                                     CHR_FLG_CHANGE_AMOUNT,
                                                     CHR_FLG_UNBUDGET,
                                                     CHR_DESC_BUDGET,
                                                     CHR_TAHUN_BUDGET,
                                                     CHR_KODE_TYPE_BUDGET,
                                                     CHR_KODE_DEPARTMENT,
                                                     BDGT_CURR.CHR_NO_BUDGET,
                                                     MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                     MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                     MON_LIMBLN13,MON_LIMBLN14,MON_LIMBLN15,
                                                     INT_QTY_LIMBLN01,INT_QTY_LIMBLN02,INT_QTY_LIMBLN03,INT_QTY_LIMBLN04,INT_QTY_LIMBLN05,INT_QTY_LIMBLN06,
                                                     INT_QTY_LIMBLN07,INT_QTY_LIMBLN08,INT_QTY_LIMBLN09,INT_QTY_LIMBLN10,INT_QTY_LIMBLN11,INT_QTY_LIMBLN12,
                                                     INT_QTY_LIMBLN13,INT_QTY_LIMBLN14,INT_QTY_LIMBLN15,
                                                     CHR_FLG_CANCEL, 
                                                     CHR_FLG_APPROVAL_PROCESS
                                             FROM (SELECT CHR_FLG_PROJECT,
                                                         CHR_DESC_PROJECT,
                                                         CHR_FLG_RESCHEDULE,
                                                         CHR_FLG_CHANGE_AMOUNT,
                                                         CHR_FLG_UNBUDGET,
                                                         CHR_KODE_ITEM AS CHR_DESC_BUDGET,
                                                         CHR_TAHUN_BUDGET,
                                                         CHR_KODE_TYPE_BUDGET,
                                                         CHR_KODE_DEPARTMENT,
                                                         CHR_NO_BUDGET,
                                                         MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                         MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                         INT_QTY_LIMBLN01,INT_QTY_LIMBLN02,INT_QTY_LIMBLN03,INT_QTY_LIMBLN04,INT_QTY_LIMBLN05,INT_QTY_LIMBLN06,
                                                         INT_QTY_LIMBLN07,INT_QTY_LIMBLN08,INT_QTY_LIMBLN09,INT_QTY_LIMBLN10,INT_QTY_LIMBLN11,INT_QTY_LIMBLN12,
                                                         CHR_FLG_CANCEL, 
                                                         CHR_FLG_APPROVAL_PROCESS 
                                                     FROM BDGT_TM_BUDGET_EXPENSE 
                                                     WHERE CHR_TAHUN_ACTUAL = '$fiscal_start') BDGT_CURR
                                             LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                             MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                             INT_QTY_LIMBLN01 AS INT_QTY_LIMBLN13,INT_QTY_LIMBLN02 AS INT_QTY_LIMBLN14,INT_QTY_LIMBLN03 AS INT_QTY_LIMBLN15 
                                                     FROM BDGT_TM_BUDGET_EXPENSE 
                                                     WHERE CHR_TAHUN_ACTUAL = '$fiscal_end') BDGT_NEXT ON BDGT_CURR.CHR_NO_BUDGET = BDGT_NEXT.CHR_NO_BUDGET
                                             WHERE BDGT_CURR.CHR_NO_BUDGET = '$no_budget'
                                             ORDER BY BDGT_CURR.CHR_NO_BUDGET")->row();
            return $get_curr_budget;
        }
     }

     function get_no_revisi($budget_no){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $no_revisi = $bgt_aii->query("SELECT INT_NO_REVISI
                                      FROM BDGT_TT_MASTER_CHANGELOG 
                                      WHERE CHR_NO_BUDGET = '$budget_no' ORDER BY INT_NO_REVISI DESC")->row();
        return $no_revisi;
    }

    function get_year_actual_cpx($budget_no){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $year_act = $bgt_aii->query("SELECT CHR_TAHUN_ACTUAL 
                                     FROM BDGT_TM_BUDGET_CAPEX  
                                     WHERE CHR_NO_BUDGET = '$budget_no'")->row();
        return $year_act;
    }

    function save_revision_budget($data) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $tabel_changelog = "BDGT_TT_MASTER_CHANGELOG";
        $bgt_aii->insert($tabel_changelog, $data);
    }

    function update_master_budget_new($data, $budget_type, $budget_no) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);        
        if($budget_type == "CAPEX"){
            $tabel_capex = "BDGT_TM_BUDGET_CAPEX";
            $bgt_aii->where('CHR_NO_BUDGET', $budget_no);
            $bgt_aii->update($tabel_capex, $data);
        } else {
            $tabel_expense = "BDGT_TM_BUDGET_EXPENSE";
            $bgt_aii->where('CHR_NO_BUDGET', $budget_no);
            $bgt_aii->update($tabel_expense, $data);
        }
        
    }
    
    //===== END PROPOSE HERE WITH OLD FLOW - ANU 20220214 ======//
    
}

?>
