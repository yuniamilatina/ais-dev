<?php

class new_propose_budget_m extends CI_Model {

    // ---------------------------- // EDIT BY ANP // ------------------------//
    function get_all_dept(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT")->result();
        return $all_dept;
    }
    
    function get_dept_desc($kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_DEPARTMENT = '$kode_dept'")->row();
        return $dept;
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
                                    WHERE CHR_KODE_GROUP = '$kode_group'")->result();
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
    
    function get_budget_type_prop($no_propose){
        $bgt_type = $this->db->query("SELECT CHR_BUDGET_TYPE, 
                                            CHR_BUDGET_TYPE_DESC
                                     FROM CPL.TM_BUDGET_TYPE 
                                     WHERE CHR_BUDGET_TYPE IN (SELECT DISTINCT CHR_BUDGET_TYPE FROM CPL.TT_DETAIL_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose') AND BIT_FLG_DEL <> 1")->result();
        return $bgt_type;
    }
    
    function summary_prop_by_budget_type($no_propose){
        $bgt_type = $this->db->query("SELECT CHR_BUDGET_TYPE, SUM(MON_PROPOSE_BLN) AS MON_PROPOSE_BLN
                                      FROM CPL.TT_DETAIL_PROPOSE_BUDGET 
                                      WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_FLG_DELETE <> '1'
                                      GROUP BY CHR_BUDGET_TYPE")->result();
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
        $all_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_NO_BUDGET, CHR_BUDGET_TYPE,
                                            MON_PLAN_BLN, MON_LIMIT_BLN, MON_REAL_BLN, MON_PROPOSE_BLN
                                        FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE ='$no_propose'")->result();
        return $all_propose;
    }
    
    function get_list_budget_type($no_propose){
        $all_propose = $this->db->query("SELECT DISTINCT CHR_BUDGET_TYPE
                                        FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE ='$no_propose'")->result();
        return $all_propose;
    }
    
    function get_list_budget_proposed_admin($no_propose){
        $all_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_NO_BUDGET, CHR_BUDGET_TYPE, CHR_DEPT, CHR_YEAR_ACTUAL, CHR_MONTH_ACTUAL,
                                            MON_PROPOSE_BLN, INT_QTY_PROPOSE, CHR_FLG_UNBUDGET, CHR_FLG_CHANGE_AMOUNT
                                        FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE ='$no_propose'
                                            AND CHR_FLG_PROPOSED = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $all_propose;
    }
    
    function get_list_budget_proposed_gm($no_propose){
        $all_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_NO_BUDGET, CHR_BUDGET_TYPE, CHR_DEPT, CHR_YEAR_ACTUAL, CHR_MONTH_ACTUAL,
                                            MON_PROPOSE_BLN, INT_QTY_PROPOSE, CHR_FLG_UNBUDGET, CHR_FLG_CHANGE_AMOUNT
                                        FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE ='$no_propose'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $all_propose;
    }
    
    function get_list_budget_proposed_bod($no_propose){
        $all_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_NO_BUDGET, CHR_BUDGET_TYPE, CHR_DEPT, CHR_YEAR_ACTUAL, CHR_MONTH_ACTUAL,
                                            MON_PROPOSE_BLN, INT_QTY_PROPOSE, CHR_FLG_UNBUDGET, CHR_FLG_CHANGE_AMOUNT
                                        FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE ='$no_propose'
                                            AND CHR_FLG_PROPOSED = '1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $all_propose;
    }
    
    function get_all_propose($fiscal_start, $kode_dept, $year, $month){
        $all_propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_TRANS_DATE, CHR_DEPT, 
                                            CHR_YEAR_BUDGET, CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE, CHR_FLG_SWITCH  
                                        FROM CPL.TT_HEADER_PROPOSE_BUDGET
                                        WHERE CHR_DEPT = '$kode_dept'
                                            AND CHR_YEAR_BUDGET = '$fiscal_start'
                                            AND CHR_YEAR_PROPOSE = '$year'
                                            AND CHR_MONTH_PROPOSE = '$month'
                                            AND CHR_FLG_DELETE_PROP <> 1")->result();
        return $all_propose;
    }
    
    function get_all_propose_admin($fiscal_start, $kode_dept, $year, $month){
        $all_propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_TRANS_DATE, CHR_DEPT, 
                                            CHR_YEAR_BUDGET, CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE, CHR_FLG_SWITCH  
                                        FROM CPL.TT_HEADER_PROPOSE_BUDGET
                                        WHERE CHR_DEPT = '$kode_dept'
                                            AND CHR_YEAR_BUDGET = '$fiscal_start'
                                            AND CHR_YEAR_PROPOSE = '$year'
                                            AND CHR_MONTH_PROPOSE = '$month'
                                            AND CHR_FLG_DELETE_PROP <> 1 
                                            AND CHR_FLG_SWITCH <> '0'")->result();
        return $all_propose;
    }
    
    function get_all_propose_gm($fiscal_start, $kode_dept, $year, $month){
        $all_propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_DEPT, CHR_FLG_SWITCH,
                                            CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE  
                                        FROM CPL.TT_HEADER_PROPOSE_BUDGET
                                        WHERE CHR_DEPT = '$kode_dept'
                                            AND CHR_YEAR_BUDGET = '$fiscal_start'
                                            AND CHR_YEAR_PROPOSE = '$year'
                                            AND CHR_MONTH_PROPOSE ='$month'
                                            AND CHR_FLG_DELETE_PROP <> 1 
                                            AND CHR_FLG_SWITCH >= '1'")->result();
        return $all_propose;
    }
    
    function get_all_propose_bod($fiscal_start, $kode_dept, $year, $month){
        $all_propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_DEPT, CHR_FLG_SWITCH,
                                            CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE  
                                        FROM CPL.TT_HEADER_PROPOSE_BUDGET
                                        WHERE CHR_DEPT = '$kode_dept'
                                            AND CHR_YEAR_BUDGET = '$fiscal_start'
                                            AND CHR_YEAR_PROPOSE = '$year'
                                            AND CHR_MONTH_PROPOSE ='$month'
                                            AND CHR_FLG_DELETE_PROP <> 1 
                                            AND CHR_FLG_SWITCH >= '2'")->result();
        return $all_propose;
    }
    
    function get_propose($no_propose){
        $propose = $this->db->query("SELECT DISTINCT CHR_NO_PROPOSE, CHR_DEPT, CHR_YEAR_BUDGET, 
                                            CHR_YEAR_PROPOSE, CHR_MONTH_PROPOSE, CHR_FLG_SWITCH
                                        FROM CPL.TT_HEADER_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
        return $propose;
    }
    
    function get_all_list_propose($no_propose){
        $sum_propose = $this->db->query("SELECT CHR_NO_PROPOSE, CHR_DEPT, CHR_BUDGET_TYPE,
                                            SUM(MON_PLAN_BLN) AS TOT_PLAN_BLN, SUM(MON_LIMIT_BLN) AS TOT_LIM_BLN, 
                                            SUM(MON_REAL_BLN) AS TOT_REAL_BLN, SUM(MON_PROPOSE_BLN) AS TOT_PROPOSE_BLN
                                        FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                        GROUP BY CHR_NO_PROPOSE, CHR_DEPT, CHR_BUDGET_TYPE")->result();
        return $sum_propose;
    }
    
    function get_all_budget_list_propose($no_propose){
        $sum_propose = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_FLG_DELETE <> '1'")->result();
        return $sum_propose;
    }
    
    function get_sum_no_budget($fiscal_start, $kode_dept, $bgt_type, $no_budget, $year, $month){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $fiscal_end = $fiscal_start + 1;
        if($bgt_type == 'CAPEX'){
            $detail_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT,
                                            MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 AS PBLN, 
                                            MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 AS LBLN,
                                            MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 AS OBLN 
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_NO_BUDGET = '$no_budget'
                                            --AND CHR_TAHUN_ACTUAL = '$year' 
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                            AND CHR_FLG_APPROVAL_PROCESS <> 1 
                                            AND CHR_FLG_DELETE <> 1
                                            AND CHR_FLG_CANCEL <> 1")->row();
        } else {
            $detail_budget = $bgt_aii->query("SELECT A.CHR_KODE_TYPE_BUDGET, A.CHR_NO_BUDGET, A.CHR_TAHUN_BUDGET, A.CHR_KODE_DEPARTMENT,
                                            MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15 AS PBLN, 
                                            MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15 AS LBLN,
                                            MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15 AS OBLN 
                                    FROM (SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, 
                                            MON_BLN01, MON_BLN02, MON_BLN03, MON_BLN04, MON_BLN05, MON_BLN06, MON_BLN07, MON_BLN08, MON_BLN09, MON_BLN10, MON_BLN11, MON_BLN12, 
                                            MON_LIMBLN01, MON_LIMBLN02, MON_LIMBLN03, MON_LIMBLN04, MON_LIMBLN05, MON_LIMBLN06, MON_LIMBLN07, MON_LIMBLN08, MON_LIMBLN09, MON_LIMBLN10, MON_LIMBLN11, MON_LIMBLN12,
                                            MON_OPRBLN01, MON_OPRBLN02, MON_OPRBLN03, MON_OPRBLN04, MON_OPRBLN05, MON_OPRBLN06, MON_OPRBLN07, MON_OPRBLN08, MON_OPRBLN09, MON_OPRBLN10, MON_OPRBLN11, MON_OPRBLN12 
                                    FROM BDGT_TM_BUDGET_EXPENSE AS A
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_NO_BUDGET = '$no_budget'
                                            AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                            AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                            AND CHR_FLG_APPROVAL_PROCESS <> 1 
                                            --AND CHR_FLG_DELETE <> 1
                                            AND CHR_FLG_CANCEL <> 1) AS A 
                                    LEFT JOIN (SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, 
                                            MON_BLN01 AS MON_BLN13, MON_BLN02 AS MON_BLN14, MON_BLN03 AS MON_BLN15,
                                            MON_LIMBLN01 AS MON_LIMBLN13, MON_LIMBLN02 AS MON_LIMBLN14, MON_LIMBLN03 AS MON_LIMBLN15,
                                            MON_OPRBLN01 AS MON_OPRBLN13, MON_OPRBLN02 AS MON_OPRBLN14, MON_OPRBLN03 AS MON_OPRBLN15
                                    FROM BDGT_TM_BUDGET_EXPENSE
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_NO_BUDGET = '$no_budget'
                                            AND CHR_TAHUN_ACTUAL = '$fiscal_end'
                                            AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                            AND CHR_FLG_APPROVAL_PROCESS <> 1 
                                            --AND CHR_FLG_DELETE <> 1
                                            AND CHR_FLG_CANCEL <> 1) AS B ON A.CHR_NO_BUDGET = B.CHR_NO_BUDGET")->row();
        }
        
        return $detail_budget;
    }
    
    function get_limit_bln_budget($fiscal_start, $kode_dept, $bgt_type, $no_budget, $year, $month){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($bgt_type == 'CAPEX'){
            $limit_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT,
                                            MON_LIMBLN$month AS LIMIT_BLN, MON_BLN$month AS PLAN_BLN, MON_OUTBLN$month AS OUT_BLN, 0 AS INT_QTY
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_NO_BUDGET = '$no_budget'
                                            --AND CHR_TAHUN_ACTUAL = '$year' 
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                            AND CHR_FLG_APPROVAL_PROCESS <> 1 
                                            AND CHR_FLG_DELETE <> 1
                                            AND CHR_FLG_CANCEL <> 1")->row();
        } else {
            $limit_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT,
                                            MON_LIMBLN$month AS LIMIT_BLN, MON_BLN$month AS PLAN_BLN, MON_OUTBLN$month AS OUT_BLN, INT_QTY_BLN$month AS INT_QTY 
                                    FROM BDGT_TM_BUDGET_EXPENSE 
                                    WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                            AND CHR_NO_BUDGET = '$no_budget'
                                            AND CHR_TAHUN_ACTUAL = '$year' 
                                            AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                            AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                            AND CHR_FLG_APPROVAL_PROCESS <> 1 
                                            --AND CHR_FLG_DELETE <> 1
                                            AND CHR_FLG_CANCEL <> 1")->row();
        }
        
        return $limit_budget;
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
    
//    function get_exist_budget($fiscal_start, $kode_dept, $year, $month){
//        $bgt_aii = $this->load->database("bgt_aii", TRUE);
//        $all_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
//                                           CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT, 
//                                           TOT_PLAN, TOT_LIMIT, TOT_REAL 
//                                    FROM (SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
//                                                 CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT, 
//                                                 MON_BLN$month AS TOT_PLAN, MON_BLN$month * 0.7 AS TOT_LIMIT, MON_OPRBLN$month AS TOT_REAL 
//                                          FROM DB_BUDGET_AII_DEV.dbo.BDGT_TM_BUDGET_CAPEX 
//                                          WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
//                                               AND CHR_TAHUN_ACTUAL = '$year' 
//                                               AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                               AND MON_BLN$month <> 0 
//                                               AND CHR_FLG_APPROVAL_PROCESS <> 1 
//                                               AND CHR_FLG_DELETE <> 1
//                                               AND CHR_FLG_CANCEL <> 1
//                                               AND CHR_FLG_USED <> 1
//                                         UNION 
//                                         SELECT CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET, CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_TAHUN_BUDGET, 
//                                                CHR_KODE_DEPARTMENT, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
//                                                MON_BLN$month AS TOT_PLAN, (MON_BLN$month * 0.7) AS TOT_LIMIT, MON_OPRBLN$month AS TOT_REAL 
//                                         FROM DB_BUDGET_AII_DEV.dbo.BDGT_TM_BUDGET_EXPENSE 
//                                         WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
//                                              AND CHR_TAHUN_ACTUAL = '$year' 
//                                              AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                              AND MON_BLN$month <> 0 
//                                              AND CHR_FLG_APPROVAL_PROCESS <> 1
//                                              AND CHR_FLG_DELETE <> 1
//                                              AND CHR_FLG_CANCEL <> 1) AS AB
//                                    WHERE CHR_NO_BUDGET NOT IN (SELECT CHR_NO_BUDGET 
//						FROM DB_AIS_DEV.CPL.TW_PROPOSE_BUDGET 
//						WHERE CHR_YEAR_BUDGET = '$fiscal_start' 
//							AND CHR_YEAR_PROPOSE = '$year' 
//							AND CHR_MONTH_PROPOSE = '$month'
//                                                        AND CHR_FLG_DELETE = '0')")->result();
//                                                        //AND CHR_FLG_PROPOSED <> '2')")->result();
//        return $all_budget;
//    }
    
    function get_exist_no_budget_prop($fiscal_start, $kode_dept, $bgt_type){
        $exist_no_budget = $this->db->query("SELECT CHR_NO_BUDGET 
                                            FROM CPL.TT_DETAIL_PROPOSE_BUDGET 
                                            WHERE CHR_BUDGET_TYPE LIKE '$bgt_type'
                                                  AND CHR_FLG_DELETE <> '1'
                                                  AND CHR_NO_PROPOSE IN (SELECT CHR_NO_PROPOSE 
                                                  FROM CPL.TT_HEADER_PROPOSE_BUDGET 
                                                  WHERE CHR_DEPT = '$kode_dept' AND CHR_YEAR_BUDGET = '$fiscal_start' AND CHR_FLG_SWITCH <> '3' AND CHR_FLG_DELETE_PROP <> '1')")->result();
        return $exist_no_budget;
    }
    
    function get_exist_all_no_budget($fiscal_start, $kode_dept){
        $exist_no_budget = $this->db->query("SELECT CHR_NO_BUDGET 
                                            FROM CPL.TT_DETAIL_PROPOSE_BUDGET 
                                            WHERE CHR_FLG_DELETE <> '1'
                                                  AND CHR_NO_PROPOSE IN (SELECT CHR_NO_PROPOSE 
                                                  FROM CPL.TT_HEADER_PROPOSE_BUDGET 
                                                  WHERE CHR_DEPT = '$kode_dept' AND CHR_YEAR_BUDGET = '$fiscal_start' AND CHR_FLG_SWITCH <> '3' AND CHR_FLG_DELETE_PROP <> '1')")->result();
        return $exist_no_budget;
    }
    
    function get_all_list_budget($fiscal, $kode_dept, $bgt_type, $no_budget, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $fis_start = substr($fiscal,0,4);
        $fis_end = substr($fiscal,4,4);
        if($bgt_type == "CAPEX"){
            if($act_periode < $periode_smt2){
                //===== BEFORE REVISE BUDGET SMT 2
                $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(OUTBLN04) AS PBLN04, SUM(OUTBLN05) AS PBLN05, SUM(OUTBLN06) AS PBLN06, SUM(OUTBLN07) AS PBLN07, 
                                                     SUM(OUTBLN08) AS PBLN08, SUM(OUTBLN09) AS PBLN09, SUM(OUTBLN10) AS PBLN10, SUM(OUTBLN11) AS PBLN11, 
                                                     SUM(OUTBLN12) AS PBLN12, SUM(OUTBLN01) AS PBLN01, SUM(OUTBLN02) AS PBLN02, SUM(OUTBLN03) AS PBLN03,
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN,
                                                     SUM(RBLN04 + RBLN05 + RBLN06 + RBLN07 + RBLN08 + RBLN09 + RBLN10 + RBLN11 + RBLN12 + RBLN01 + RBLN02 + RBLN03) AS TOT_REVISE,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_REV01BLN04),0) AS RBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS RBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS RBLN06,
                                                       ISNULL(SUM(MON_REV01BLN07),0) AS RBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS RBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS RBLN09,
                                                       ISNULL(SUM(MON_REV01BLN10),0) AS RBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS RBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS RBLN12,
                                                       ISNULL(SUM(MON_REV01BLN01),0) AS RBLN01,ISNULL(SUM(MON_REV01BLN02),0) AS RBLN02,ISNULL(SUM(MON_REV01BLN03),0) AS RBLN03,
                                                       ISNULL(SUM(MON_OUTBLN04),0) AS OUTBLN04,ISNULL(SUM(MON_OUTBLN05),0) AS OUTBLN05,ISNULL(SUM(MON_OUTBLN06),0) AS OUTBLN06,
                                                       ISNULL(SUM(MON_OUTBLN07),0) AS OUTBLN07,ISNULL(SUM(MON_OUTBLN08),0) AS OUTBLN08,ISNULL(SUM(MON_OUTBLN09),0) AS OUTBLN09,
                                                       ISNULL(SUM(MON_OUTBLN10),0) AS OUTBLN10,ISNULL(SUM(MON_OUTBLN11),0) AS OUTBLN11,ISNULL(SUM(MON_OUTBLN12),0) AS OUTBLN12,
                                                       ISNULL(SUM(MON_OUTBLN01),0) AS OUTBLN01,ISNULL(SUM(MON_OUTBLN02),0) AS OUTBLN02,ISNULL(SUM(MON_OUTBLN03),0) AS OUTBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT
                                                ) AS BDGT_TM_BUDGET_CAPEX
                                                WHERE CHR_NO_BUDGET NOT IN ($no_budget)
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT")->result();
            } else {
                //===== AFTER REVISE BUDGET SMT 2
                $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(OUTBLN04) AS PBLN04, SUM(OUTBLN05) AS PBLN05, SUM(OUTBLN06) AS PBLN06, SUM(OUTBLN07) AS PBLN07, 
                                                     SUM(OUTBLN08) AS PBLN08, SUM(OUTBLN09) AS PBLN09, SUM(OUTBLN10) AS PBLN10, SUM(OUTBLN11) AS PBLN11, 
                                                     SUM(OUTBLN12) AS PBLN12, SUM(OUTBLN01) AS PBLN01, SUM(OUTBLN02) AS PBLN02, SUM(OUTBLN03) AS PBLN03,
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN_ORI,
                                                     SUM(RBLN04 + RBLN05 + RBLN06 + RBLN07 + RBLN08 + RBLN09 + RBLN10 + RBLN11 + RBLN12 + RBLN01 + RBLN02 + RBLN03) AS TOT_PLAN,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_REV01BLN04),0) AS RBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS RBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS RBLN06,
                                                       ISNULL(SUM(MON_REV01BLN07),0) AS RBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS RBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS RBLN09,
                                                       ISNULL(SUM(MON_REV01BLN10),0) AS RBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS RBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS RBLN12,
                                                       ISNULL(SUM(MON_REV01BLN01),0) AS RBLN01,ISNULL(SUM(MON_REV01BLN02),0) AS RBLN02,ISNULL(SUM(MON_REV01BLN03),0) AS RBLN03,
                                                       ISNULL(SUM(MON_OUTBLN04),0) AS OUTBLN04,ISNULL(SUM(MON_OUTBLN05),0) AS OUTBLN05,ISNULL(SUM(MON_OUTBLN06),0) AS OUTBLN06,
                                                       ISNULL(SUM(MON_OUTBLN07),0) AS OUTBLN07,ISNULL(SUM(MON_OUTBLN08),0) AS OUTBLN08,ISNULL(SUM(MON_OUTBLN09),0) AS OUTBLN09,
                                                       ISNULL(SUM(MON_OUTBLN10),0) AS OUTBLN10,ISNULL(SUM(MON_OUTBLN11),0) AS OUTBLN11,ISNULL(SUM(MON_OUTBLN12),0) AS OUTBLN12,
                                                       ISNULL(SUM(MON_OUTBLN01),0) AS OUTBLN01,ISNULL(SUM(MON_OUTBLN02),0) AS OUTBLN02,ISNULL(SUM(MON_OUTBLN03),0) AS OUTBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT
                                                ) AS BDGT_TM_BUDGET_CAPEX
                                                WHERE CHR_NO_BUDGET NOT IN ($no_budget)
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT")->result();
            }
            
            return $list_budget;
        } else {
           $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                     CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(OUTBLN04) AS PBLN04, SUM(OUTBLN05) AS PBLN05, SUM(OUTBLN06) AS PBLN06, 
                                                     SUM(OUTBLN07) AS PBLN07, SUM(OUTBLN08) AS PBLN08, SUM(OUTBLN09) AS PBLN09, 
                                                     SUM(OUTBLN10) AS PBLN10, SUM(OUTBLN11) AS PBLN11, SUM(OUTBLN12) AS PBLN12, 
                                                     SUM(OUTBLN01) AS PBLN01, SUM(OUTBLN02) AS PBLN02, SUM(OUTBLN03) AS PBLN03,
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET AS CHR_TAHUN_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_NO_BUDGET AS CHR_NO_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT AS CHR_KODE_DEPARTMENT, 
                                                        BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET AS CHR_KODE_TYPE_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_DESC_BUDGET AS CHR_DESC_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_DESC_PROJECT AS CHR_DESC_PROJECT, 
                                                        BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET AS CHR_KODE_SUBCATEGORY_BUDGET,
                                                        BDGT_CURR_YEAR.CHR_FLG_UNBUDGET AS CHR_FLG_UNBUDGET, 
                                                        BDGT_CURR_YEAR.CHR_FLG_RESCHEDULE AS CHR_FLG_RESCHEDULE, 
                                                        BDGT_CURR_YEAR.CHR_FLG_CHANGE_AMOUNT AS CHR_FLG_CHANGE_AMOUNT,
                                                        ISNULL(MON_BLN04,0) AS PBLN04, ISNULL(MON_BLN05,0) AS PBLN05, ISNULL(MON_BLN06,0) AS PBLN06, 
                                                        ISNULL(MON_BLN07,0) AS PBLN07, ISNULL(MON_BLN08,0) AS PBLN08, ISNULL(MON_BLN09,0) AS PBLN09, 
                                                        ISNULL(MON_BLN10,0) AS PBLN10, ISNULL(MON_BLN11,0) AS PBLN11, ISNULL(MON_BLN12,0) AS PBLN12, 
                                                        ISNULL(MON_BLN01,0) AS PBLN01, ISNULL(MON_BLN02,0) AS PBLN02, ISNULL(MON_BLN03,0) AS PBLN03,
                                                        ISNULL(MON_OUTBLN04,0) AS OUTBLN04, ISNULL(MON_OUTBLN05,0) AS OUTBLN05, ISNULL(MON_OUTBLN06,0) AS OUTBLN06, 
                                                        ISNULL(MON_OUTBLN07,0) AS OUTBLN07, ISNULL(MON_OUTBLN08,0) AS OUTBLN08, ISNULL(MON_OUTBLN09,0) AS OUTBLN09, 
                                                        ISNULL(MON_OUTBLN10,0) AS OUTBLN10, ISNULL(MON_OUTBLN11,0) AS OUTBLN11, ISNULL(MON_OUTBLN12,0) AS OUTBLN12, 
                                                        ISNULL(MON_OUTBLN01,0) AS OUTBLN01, ISNULL(MON_OUTBLN02,0) AS OUTBLN02, ISNULL(MON_OUTBLN03,0) AS OUTBLN03,
                                                        ISNULL(MON_LIMBLN04,0) AS LBLN04, ISNULL(MON_LIMBLN05,0) AS LBLN05, ISNULL(MON_LIMBLN06,0) AS LBLN06, 
                                                        ISNULL(MON_LIMBLN07,0) AS LBLN07, ISNULL(MON_LIMBLN08,0) AS LBLN08, ISNULL(MON_LIMBLN09,0) AS LBLN09, 
                                                        ISNULL(MON_LIMBLN10,0) AS LBLN10, ISNULL(MON_LIMBLN11,0) AS LBLN11, ISNULL(MON_LIMBLN12,0) AS LBLN12, 
                                                        ISNULL(MON_LIMBLN01,0) AS LBLN01, ISNULL(MON_LIMBLN02,0) AS LBLN02, ISNULL(MON_LIMBLN03,0) AS LBLN03, 
                                                        ISNULL(MON_OPRBLN04,0) AS OBLN04, ISNULL(MON_OPRBLN05,0) AS OBLN05, ISNULL(MON_OPRBLN06,0) AS OBLN06, 
                                                        ISNULL(MON_OPRBLN07,0) AS OBLN07, ISNULL(MON_OPRBLN08,0) AS OBLN08, ISNULL(MON_OPRBLN09,0) AS OBLN09, 
                                                        ISNULL(MON_OPRBLN10,0) AS OBLN10, ISNULL(MON_OPRBLN11,0) AS OBLN11, ISNULL(MON_OPRBLN12,0) AS OBLN12, 
                                                        ISNULL(MON_OPRBLN01,0) AS OBLN01, ISNULL(MON_OPRBLN02,0) AS OBLN02, ISNULL(MON_OPRBLN03,0) AS OBLN03
                                                    FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                                    CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                                    CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                                    MON_BLN04, MON_BLN05, MON_BLN06,
                                                                    MON_BLN07, MON_BLN08, MON_BLN09,
                                                                    MON_BLN10, MON_BLN11, MON_BLN12,
                                                                    MON_OUTBLN04, MON_OUTBLN05, MON_OUTBLN06,
                                                                    MON_OUTBLN07, MON_OUTBLN08, MON_OUTBLN09,
                                                                    MON_OUTBLN10, MON_OUTBLN11, MON_OUTBLN12,
                                                                    MON_LIMBLN04, MON_LIMBLN05, MON_LIMBLN06,
                                                                    MON_LIMBLN07, MON_LIMBLN08, MON_LIMBLN09,
                                                                    MON_LIMBLN10, MON_LIMBLN11, MON_LIMBLN12,
                                                                    MON_OPRBLN04, MON_OPRBLN05, MON_OPRBLN06,
                                                                    MON_OPRBLN07, MON_OPRBLN08, MON_OPRBLN09,
                                                                    MON_OPRBLN10, MON_OPRBLN11, MON_OPRBLN12
                                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                                            WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                                    LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01, MON_BLN02, MON_BLN03,
                                                                MON_OUTBLN01, MON_OUTBLN02, MON_OUTBLN03,
                                                                MON_LIMBLN01, MON_LIMBLN02, MON_LIMBLN03,
                                                                MON_OPRBLN01, MON_OPRBLN02, MON_OPRBLN03
                                                            FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fis_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE
                                            WHERE CHR_NO_BUDGET NOT IN ($no_budget)
                                            GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                     CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT")->result();
            return $list_budget; 
        }        
    }
    
    function get_list_available_budget($fiscal, $kode_dept, $month, $no_budget){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $fis_start = substr($fiscal,0,4);
        $fis_end = substr($fiscal,4,4);
        $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                 CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                 SUM(OUTBLN04) AS PBLN04, SUM(OUTBLN05) AS PBLN05, SUM(OUTBLN06) AS PBLN06, SUM(OUTBLN07) AS PBLN07, 
                                                 SUM(OUTBLN08) AS PBLN08, SUM(OUTBLN09) AS PBLN09, SUM(OUTBLN10) AS PBLN10, SUM(OUTBLN11) AS PBLN11, 
                                                 SUM(OUTBLN12) AS PBLN12, SUM(OUTBLN01) AS PBLN01, SUM(OUTBLN02) AS PBLN02, SUM(OUTBLN03) AS PBLN03,
                                                 SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN,
                                                 SUM(RBLN04 + RBLN05 + RBLN06 + RBLN07 + RBLN08 + RBLN09 + RBLN10 + RBLN11 + RBLN12 + RBLN01 + RBLN02 + RBLN03) AS TOT_REVISE,
                                                 SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                 SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                        FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                   CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                   ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_REV01BLN04),0) AS RBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS RBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS RBLN06,
                                                   ISNULL(SUM(MON_REV01BLN07),0) AS RBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS RBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS RBLN09,
                                                   ISNULL(SUM(MON_REV01BLN10),0) AS RBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS RBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS RBLN12,
                                                   ISNULL(SUM(MON_REV01BLN01),0) AS RBLN01,ISNULL(SUM(MON_REV01BLN02),0) AS RBLN02,ISNULL(SUM(MON_REV01BLN03),0) AS RBLN03,
                                                   ISNULL(SUM(MON_OUTBLN04),0) AS OUTBLN04,ISNULL(SUM(MON_OUTBLN05),0) AS OUTBLN05,ISNULL(SUM(MON_OUTBLN06),0) AS OUTBLN06,
                                                   ISNULL(SUM(MON_OUTBLN07),0) AS OUTBLN07,ISNULL(SUM(MON_OUTBLN08),0) AS OUTBLN08,ISNULL(SUM(MON_OUTBLN09),0) AS OUTBLN09,
                                                   ISNULL(SUM(MON_OUTBLN10),0) AS OUTBLN10,ISNULL(SUM(MON_OUTBLN11),0) AS OUTBLN11,ISNULL(SUM(MON_OUTBLN12),0) AS OUTBLN12,
                                                   ISNULL(SUM(MON_OUTBLN01),0) AS OUTBLN01,ISNULL(SUM(MON_OUTBLN02),0) AS OUTBLN02,ISNULL(SUM(MON_OUTBLN03),0) AS OUTBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                   ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                   ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                   ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                   ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                   ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03
                                            FROM BDGT_TM_BUDGET_CAPEX 
                                            WHERE CHR_TAHUN_BUDGET = '$fis_start'
                                                 AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                 AND CHR_FLG_DELETE = '0'
                                                 AND CHR_FLG_CANCEL = '0'
                                                 AND CHR_FLG_FOR_AIIA = '0'
                                            GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                 CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT
                                            ) AS BDGT_TM_BUDGET_CAPEX
                                            WHERE CHR_NO_BUDGET NOT IN ($no_budget) AND OUTBLN$month <> '0'
                                            GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                 CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT
                                        UNION
                                        SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                     CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(OUTBLN04) AS PBLN04, SUM(OUTBLN05) AS PBLN05, SUM(OUTBLN06) AS PBLN06, 
                                                     SUM(OUTBLN07) AS PBLN07, SUM(OUTBLN08) AS PBLN08, SUM(OUTBLN09) AS PBLN09, 
                                                     SUM(OUTBLN10) AS PBLN10, SUM(OUTBLN11) AS PBLN11, SUM(OUTBLN12) AS PBLN12, 
                                                     SUM(OUTBLN01) AS PBLN01, SUM(OUTBLN02) AS PBLN02, SUM(OUTBLN03) AS PBLN03,
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET AS CHR_TAHUN_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_NO_BUDGET AS CHR_NO_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT AS CHR_KODE_DEPARTMENT, 
                                                        BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET AS CHR_KODE_TYPE_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_DESC_BUDGET AS CHR_DESC_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_DESC_PROJECT AS CHR_DESC_PROJECT, 
                                                        BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET AS CHR_KODE_SUBCATEGORY_BUDGET,
                                                        BDGT_CURR_YEAR.CHR_FLG_UNBUDGET AS CHR_FLG_UNBUDGET, 
                                                        BDGT_CURR_YEAR.CHR_FLG_RESCHEDULE AS CHR_FLG_RESCHEDULE, 
                                                        BDGT_CURR_YEAR.CHR_FLG_CHANGE_AMOUNT AS CHR_FLG_CHANGE_AMOUNT,
                                                        ISNULL(MON_BLN04,0) AS PBLN04, ISNULL(MON_BLN05,0) AS PBLN05, ISNULL(MON_BLN06,0) AS PBLN06, 
                                                        ISNULL(MON_BLN07,0) AS PBLN07, ISNULL(MON_BLN08,0) AS PBLN08, ISNULL(MON_BLN09,0) AS PBLN09, 
                                                        ISNULL(MON_BLN10,0) AS PBLN10, ISNULL(MON_BLN11,0) AS PBLN11, ISNULL(MON_BLN12,0) AS PBLN12, 
                                                        ISNULL(MON_BLN01,0) AS PBLN01, ISNULL(MON_BLN02,0) AS PBLN02, ISNULL(MON_BLN03,0) AS PBLN03,
                                                        ISNULL(MON_OUTBLN04,0) AS OUTBLN04, ISNULL(MON_OUTBLN05,0) AS OUTBLN05, ISNULL(MON_OUTBLN06,0) AS OUTBLN06, 
                                                        ISNULL(MON_OUTBLN07,0) AS OUTBLN07, ISNULL(MON_OUTBLN08,0) AS OUTBLN08, ISNULL(MON_OUTBLN09,0) AS OUTBLN09, 
                                                        ISNULL(MON_OUTBLN10,0) AS OUTBLN10, ISNULL(MON_OUTBLN11,0) AS OUTBLN11, ISNULL(MON_OUTBLN12,0) AS OUTBLN12, 
                                                        ISNULL(MON_OUTBLN01,0) AS OUTBLN01, ISNULL(MON_OUTBLN02,0) AS OUTBLN02, ISNULL(MON_OUTBLN03,0) AS OUTBLN03,
                                                        ISNULL(MON_LIMBLN04,0) AS LBLN04, ISNULL(MON_LIMBLN05,0) AS LBLN05, ISNULL(MON_LIMBLN06,0) AS LBLN06, 
                                                        ISNULL(MON_LIMBLN07,0) AS LBLN07, ISNULL(MON_LIMBLN08,0) AS LBLN08, ISNULL(MON_LIMBLN09,0) AS LBLN09, 
                                                        ISNULL(MON_LIMBLN10,0) AS LBLN10, ISNULL(MON_LIMBLN11,0) AS LBLN11, ISNULL(MON_LIMBLN12,0) AS LBLN12, 
                                                        ISNULL(MON_LIMBLN01,0) AS LBLN01, ISNULL(MON_LIMBLN02,0) AS LBLN02, ISNULL(MON_LIMBLN03,0) AS LBLN03, 
                                                        ISNULL(MON_OPRBLN04,0) AS OBLN04, ISNULL(MON_OPRBLN05,0) AS OBLN05, ISNULL(MON_OPRBLN06,0) AS OBLN06, 
                                                        ISNULL(MON_OPRBLN07,0) AS OBLN07, ISNULL(MON_OPRBLN08,0) AS OBLN08, ISNULL(MON_OPRBLN09,0) AS OBLN09, 
                                                        ISNULL(MON_OPRBLN10,0) AS OBLN10, ISNULL(MON_OPRBLN11,0) AS OBLN11, ISNULL(MON_OPRBLN12,0) AS OBLN12, 
                                                        ISNULL(MON_OPRBLN01,0) AS OBLN01, ISNULL(MON_OPRBLN02,0) AS OBLN02, ISNULL(MON_OPRBLN03,0) AS OBLN03
                                                    FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                                    CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                                    CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                                    MON_BLN04, MON_BLN05, MON_BLN06,
                                                                    MON_BLN07, MON_BLN08, MON_BLN09,
                                                                    MON_BLN10, MON_BLN11, MON_BLN12,
                                                                    MON_OUTBLN04, MON_OUTBLN05, MON_OUTBLN06,
                                                                    MON_OUTBLN07, MON_OUTBLN08, MON_OUTBLN09,
                                                                    MON_OUTBLN10, MON_OUTBLN11, MON_OUTBLN12,
                                                                    MON_LIMBLN04, MON_LIMBLN05, MON_LIMBLN06,
                                                                    MON_LIMBLN07, MON_LIMBLN08, MON_LIMBLN09,
                                                                    MON_LIMBLN10, MON_LIMBLN11, MON_LIMBLN12,
                                                                    MON_OPRBLN04, MON_OPRBLN05, MON_OPRBLN06,
                                                                    MON_OPRBLN07, MON_OPRBLN08, MON_OPRBLN09,
                                                                    MON_OPRBLN10, MON_OPRBLN11, MON_OPRBLN12
                                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                                            WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                                    LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01, MON_BLN02, MON_BLN03,
                                                                MON_OUTBLN01, MON_OUTBLN02, MON_OUTBLN03,
                                                                MON_LIMBLN01, MON_LIMBLN02, MON_LIMBLN03,
                                                                MON_OPRBLN01, MON_OPRBLN02, MON_OPRBLN03
                                                            FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fis_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE
                                            WHERE CHR_NO_BUDGET NOT IN ($no_budget) AND OUTBLN$month <> '0'
                                            GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                     CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT")->result();
        return $list_budget;    
    }
    
    function get_list_budget_per_month($fiscal, $kode_dept, $bgt_type, $month, $no_budget, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $fis_start = substr($fiscal,0,4);
        $fis_end = substr($fiscal,4,4);
        if($bgt_type == "CAPEX"){
            if($act_periode < $periode_smt2){
                //===== BEFORE REVISE BUDGET SMT 2
                $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(OUTBLN04) AS PBLN04, SUM(OUTBLN05) AS PBLN05, SUM(OUTBLN06) AS PBLN06, SUM(OUTBLN07) AS PBLN07, 
                                                     SUM(OUTBLN08) AS PBLN08, SUM(OUTBLN09) AS PBLN09, SUM(OUTBLN10) AS PBLN10, SUM(OUTBLN11) AS PBLN11, 
                                                     SUM(OUTBLN12) AS PBLN12, SUM(OUTBLN01) AS PBLN01, SUM(OUTBLN02) AS PBLN02, SUM(OUTBLN03) AS PBLN03,
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN,
                                                     SUM(RBLN04 + RBLN05 + RBLN06 + RBLN07 + RBLN08 + RBLN09 + RBLN10 + RBLN11 + RBLN12 + RBLN01 + RBLN02 + RBLN03) AS TOT_REVISE,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_REV01BLN04),0) AS RBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS RBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS RBLN06,
                                                       ISNULL(SUM(MON_REV01BLN07),0) AS RBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS RBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS RBLN09,
                                                       ISNULL(SUM(MON_REV01BLN10),0) AS RBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS RBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS RBLN12,
                                                       ISNULL(SUM(MON_REV01BLN01),0) AS RBLN01,ISNULL(SUM(MON_REV01BLN02),0) AS RBLN02,ISNULL(SUM(MON_REV01BLN03),0) AS RBLN03,
                                                       ISNULL(SUM(MON_OUTBLN04),0) AS OUTBLN04,ISNULL(SUM(MON_OUTBLN05),0) AS OUTBLN05,ISNULL(SUM(MON_OUTBLN06),0) AS OUTBLN06,
                                                       ISNULL(SUM(MON_OUTBLN07),0) AS OUTBLN07,ISNULL(SUM(MON_OUTBLN08),0) AS OUTBLN08,ISNULL(SUM(MON_OUTBLN09),0) AS OUTBLN09,
                                                       ISNULL(SUM(MON_OUTBLN10),0) AS OUTBLN10,ISNULL(SUM(MON_OUTBLN11),0) AS OUTBLN11,ISNULL(SUM(MON_OUTBLN12),0) AS OUTBLN12,
                                                       ISNULL(SUM(MON_OUTBLN01),0) AS OUTBLN01,ISNULL(SUM(MON_OUTBLN02),0) AS OUTBLN02,ISNULL(SUM(MON_OUTBLN03),0) AS OUTBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_CANCEL = '0'
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT
                                                ) AS BDGT_TM_BUDGET_CAPEX
                                                WHERE CHR_NO_BUDGET NOT IN ($no_budget) AND OUTBLN$month <> '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT")->result();
            } else {
                //===== AFTER REVISE BUDGET SMT 2
                $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(OUTBLN04) AS PBLN04, SUM(OUTBLN05) AS PBLN05, SUM(OUTBLN06) AS PBLN06, SUM(OUTBLN07) AS PBLN07, 
                                                     SUM(OUTBLN08) AS PBLN08, SUM(OUTBLN09) AS PBLN09, SUM(OUTBLN10) AS PBLN10, SUM(OUTBLN11) AS PBLN11, 
                                                     SUM(OUTBLN12) AS PBLN12, SUM(OUTBLN01) AS PBLN01, SUM(OUTBLN02) AS PBLN02, SUM(OUTBLN03) AS PBLN03,
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN_ORI,
                                                     SUM(RBLN04 + RBLN05 + RBLN06 + RBLN07 + RBLN08 + RBLN09 + RBLN10 + RBLN11 + RBLN12 + RBLN01 + RBLN02 + RBLN03) AS TOT_PLAN,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_REV01BLN04),0) AS RBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS RBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS RBLN06,
                                                       ISNULL(SUM(MON_REV01BLN07),0) AS RBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS RBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS RBLN09,
                                                       ISNULL(SUM(MON_REV01BLN10),0) AS RBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS RBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS RBLN12,
                                                       ISNULL(SUM(MON_REV01BLN01),0) AS RBLN01,ISNULL(SUM(MON_REV01BLN02),0) AS RBLN02,ISNULL(SUM(MON_REV01BLN03),0) AS RBLN03,
                                                       ISNULL(SUM(MON_OUTBLN04),0) AS OUTBLN04,ISNULL(SUM(MON_OUTBLN05),0) AS OUTBLN05,ISNULL(SUM(MON_OUTBLN06),0) AS OUTBLN06,
                                                       ISNULL(SUM(MON_OUTBLN07),0) AS OUTBLN07,ISNULL(SUM(MON_OUTBLN08),0) AS OUTBLN08,ISNULL(SUM(MON_OUTBLN09),0) AS OUTBLN09,
                                                       ISNULL(SUM(MON_OUTBLN10),0) AS OUTBLN10,ISNULL(SUM(MON_OUTBLN11),0) AS OUTBLN11,ISNULL(SUM(MON_OUTBLN12),0) AS OUTBLN12,
                                                       ISNULL(SUM(MON_OUTBLN01),0) AS OUTBLN01,ISNULL(SUM(MON_OUTBLN02),0) AS OUTBLN02,ISNULL(SUM(MON_OUTBLN03),0) AS OUTBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_CANCEL = '0'
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT
                                                ) AS BDGT_TM_BUDGET_CAPEX
                                                WHERE CHR_NO_BUDGET NOT IN ($no_budget) AND OUTBLN$month <> '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT")->result();
            }
            
            return $list_budget;
        } else {
           $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                     CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(OUTBLN04) AS PBLN04, SUM(OUTBLN05) AS PBLN05, SUM(OUTBLN06) AS PBLN06, 
                                                     SUM(OUTBLN07) AS PBLN07, SUM(OUTBLN08) AS PBLN08, SUM(OUTBLN09) AS PBLN09, 
                                                     SUM(OUTBLN10) AS PBLN10, SUM(OUTBLN11) AS PBLN11, SUM(OUTBLN12) AS PBLN12, 
                                                     SUM(OUTBLN01) AS PBLN01, SUM(OUTBLN02) AS PBLN02, SUM(OUTBLN03) AS PBLN03,
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET AS CHR_TAHUN_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_NO_BUDGET AS CHR_NO_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT AS CHR_KODE_DEPARTMENT, 
                                                        BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET AS CHR_KODE_TYPE_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_DESC_BUDGET AS CHR_DESC_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_DESC_PROJECT AS CHR_DESC_PROJECT, 
                                                        BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET AS CHR_KODE_SUBCATEGORY_BUDGET,
                                                        BDGT_CURR_YEAR.CHR_FLG_UNBUDGET AS CHR_FLG_UNBUDGET, 
                                                        BDGT_CURR_YEAR.CHR_FLG_RESCHEDULE AS CHR_FLG_RESCHEDULE, 
                                                        BDGT_CURR_YEAR.CHR_FLG_CHANGE_AMOUNT AS CHR_FLG_CHANGE_AMOUNT,
                                                        ISNULL(MON_BLN04,0) AS PBLN04, ISNULL(MON_BLN05,0) AS PBLN05, ISNULL(MON_BLN06,0) AS PBLN06, 
                                                        ISNULL(MON_BLN07,0) AS PBLN07, ISNULL(MON_BLN08,0) AS PBLN08, ISNULL(MON_BLN09,0) AS PBLN09, 
                                                        ISNULL(MON_BLN10,0) AS PBLN10, ISNULL(MON_BLN11,0) AS PBLN11, ISNULL(MON_BLN12,0) AS PBLN12, 
                                                        ISNULL(MON_BLN01,0) AS PBLN01, ISNULL(MON_BLN02,0) AS PBLN02, ISNULL(MON_BLN03,0) AS PBLN03,
                                                        ISNULL(MON_OUTBLN04,0) AS OUTBLN04, ISNULL(MON_OUTBLN05,0) AS OUTBLN05, ISNULL(MON_OUTBLN06,0) AS OUTBLN06, 
                                                        ISNULL(MON_OUTBLN07,0) AS OUTBLN07, ISNULL(MON_OUTBLN08,0) AS OUTBLN08, ISNULL(MON_OUTBLN09,0) AS OUTBLN09, 
                                                        ISNULL(MON_OUTBLN10,0) AS OUTBLN10, ISNULL(MON_OUTBLN11,0) AS OUTBLN11, ISNULL(MON_OUTBLN12,0) AS OUTBLN12, 
                                                        ISNULL(MON_OUTBLN01,0) AS OUTBLN01, ISNULL(MON_OUTBLN02,0) AS OUTBLN02, ISNULL(MON_OUTBLN03,0) AS OUTBLN03,
                                                        ISNULL(MON_LIMBLN04,0) AS LBLN04, ISNULL(MON_LIMBLN05,0) AS LBLN05, ISNULL(MON_LIMBLN06,0) AS LBLN06, 
                                                        ISNULL(MON_LIMBLN07,0) AS LBLN07, ISNULL(MON_LIMBLN08,0) AS LBLN08, ISNULL(MON_LIMBLN09,0) AS LBLN09, 
                                                        ISNULL(MON_LIMBLN10,0) AS LBLN10, ISNULL(MON_LIMBLN11,0) AS LBLN11, ISNULL(MON_LIMBLN12,0) AS LBLN12, 
                                                        ISNULL(MON_LIMBLN01,0) AS LBLN01, ISNULL(MON_LIMBLN02,0) AS LBLN02, ISNULL(MON_LIMBLN03,0) AS LBLN03, 
                                                        ISNULL(MON_OPRBLN04,0) AS OBLN04, ISNULL(MON_OPRBLN05,0) AS OBLN05, ISNULL(MON_OPRBLN06,0) AS OBLN06, 
                                                        ISNULL(MON_OPRBLN07,0) AS OBLN07, ISNULL(MON_OPRBLN08,0) AS OBLN08, ISNULL(MON_OPRBLN09,0) AS OBLN09, 
                                                        ISNULL(MON_OPRBLN10,0) AS OBLN10, ISNULL(MON_OPRBLN11,0) AS OBLN11, ISNULL(MON_OPRBLN12,0) AS OBLN12, 
                                                        ISNULL(MON_OPRBLN01,0) AS OBLN01, ISNULL(MON_OPRBLN02,0) AS OBLN02, ISNULL(MON_OPRBLN03,0) AS OBLN03
                                                    FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                                    CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                                    CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                                    MON_BLN04, MON_BLN05, MON_BLN06,
                                                                    MON_BLN07, MON_BLN08, MON_BLN09,
                                                                    MON_BLN10, MON_BLN11, MON_BLN12,
                                                                    MON_OUTBLN04, MON_OUTBLN05, MON_OUTBLN06,
                                                                    MON_OUTBLN07, MON_OUTBLN08, MON_OUTBLN09,
                                                                    MON_OUTBLN10, MON_OUTBLN11, MON_OUTBLN12,
                                                                    MON_LIMBLN04, MON_LIMBLN05, MON_LIMBLN06,
                                                                    MON_LIMBLN07, MON_LIMBLN08, MON_LIMBLN09,
                                                                    MON_LIMBLN10, MON_LIMBLN11, MON_LIMBLN12,
                                                                    MON_OPRBLN04, MON_OPRBLN05, MON_OPRBLN06,
                                                                    MON_OPRBLN07, MON_OPRBLN08, MON_OPRBLN09,
                                                                    MON_OPRBLN10, MON_OPRBLN11, MON_OPRBLN12
                                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                                            WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                                    LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01, MON_BLN02, MON_BLN03,
                                                                MON_OUTBLN01, MON_OUTBLN02, MON_OUTBLN03,
                                                                MON_LIMBLN01, MON_LIMBLN02, MON_LIMBLN03,
                                                                MON_OPRBLN01, MON_OPRBLN02, MON_OPRBLN03
                                                            FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fis_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE
                                            WHERE CHR_NO_BUDGET NOT IN ($no_budget) AND OUTBLN$month <> '0'
                                            GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                     CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT")->result();
            return $list_budget; 
        }        
    }
    
    function get_summary_budget_per_month($fiscal, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $fis_start = substr($fiscal,0,4);
        $fis_end = substr($fiscal,4,4);
        $summary_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET,
                                                     SUM(PBLN04) AS PBLN04, SUM(PBLN05) AS PBLN05, SUM(PBLN06) AS PBLN06, SUM(PBLN07) AS PBLN07, 
                                                     SUM(PBLN08) AS PBLN08, SUM(PBLN09) AS PBLN09, SUM(PBLN10) AS PBLN10, SUM(PBLN11) AS PBLN11, 
                                                     SUM(PBLN12) AS PBLN12, SUM(PBLN01) AS PBLN01, SUM(PBLN02) AS PBLN02, SUM(PBLN03) AS PBLN03,
                                                     SUM(OUTBLN04) AS OUTBLN04, SUM(OUTBLN05) AS OUTBLN05, SUM(OUTBLN06) AS OUTBLN06, SUM(OUTBLN07) AS OUTBLN07, 
                                                     SUM(OUTBLN08) AS OUTBLN08, SUM(OUTBLN09) AS OUTBLN09, SUM(OUTBLN10) AS OUTBLN10, SUM(OUTBLN11) AS OUTBLN11, 
                                                     SUM(OUTBLN12) AS OUTBLN12, SUM(OUTBLN01) AS OUTBLN01, SUM(OUTBLN02) AS OUTBLN02, SUM(OUTBLN03) AS OUTBLN03,
                                                     SUM(LBLN04) AS LBLN04, SUM(LBLN05) AS LBLN05, SUM(LBLN06) AS LBLN06, SUM(LBLN07) AS LBLN07, 
                                                     SUM(LBLN08) AS LBLN08, SUM(LBLN09) AS LBLN09, SUM(LBLN10) AS LBLN10, SUM(LBLN11) AS LBLN11, 
                                                     SUM(LBLN12) AS LBLN12, SUM(LBLN01) AS LBLN01, SUM(LBLN02) AS LBLN02, SUM(LBLN03) AS LBLN03,
                                                     SUM(OBLN04) AS OBLN04, SUM(OBLN05) AS OBLN05, SUM(OBLN06) AS OBLN06, SUM(OBLN07) AS OBLN07, 
                                                     SUM(OBLN08) AS OBLN08, SUM(OBLN09) AS OBLN09, SUM(OBLN10) AS OBLN10, SUM(OBLN11) AS OBLN11, 
                                                     SUM(OBLN12) AS OBLN12, SUM(OBLN01) AS OBLN01, SUM(OBLN02) AS OBLN02, SUM(OBLN03) AS OBLN03,
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN,
                                                     SUM(OUTBLN04 + OUTBLN05 + OUTBLN06 + OUTBLN07 + OUTBLN08 + OUTBLN09 + OUTBLN10 + OUTBLN11 + OUTBLN12 + OUTBLN01 + OUTBLN02 + OUTBLN03) AS TOT_OUT,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                       ISNULL(SUM(MON_OUTBLN04),0) AS OUTBLN04,ISNULL(SUM(MON_OUTBLN05),0) AS OUTBLN05,ISNULL(SUM(MON_OUTBLN06),0) AS OUTBLN06,
                                                       ISNULL(SUM(MON_OUTBLN07),0) AS OUTBLN07,ISNULL(SUM(MON_OUTBLN08),0) AS OUTBLN08,ISNULL(SUM(MON_OUTBLN09),0) AS OUTBLN09,
                                                       ISNULL(SUM(MON_OUTBLN10),0) AS OUTBLN10,ISNULL(SUM(MON_OUTBLN11),0) AS OUTBLN11,ISNULL(SUM(MON_OUTBLN12),0) AS OUTBLN12,
                                                       0 AS OUTBLN01,0 AS OUTBLN02,0 AS OUTBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       0 AS OBLN01,0 AS OBLN02,0 AS OBLN03
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT
                                                UNION
                                                SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                       0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                       0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                       0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       0 AS OUTBLN04,0 AS OUTBLN05,0 AS OUTBLN06,
                                                       0 AS OUTBLN07,0 AS OUTBLN08,0 AS OUTBLN09,
                                                       0 AS OUTBLN10,0 AS OUTBLN11,0 AS OUTBLN12,
                                                       ISNULL(SUM(MON_OUTBLN01),0) AS OUTBLN01,ISNULL(SUM(MON_OUTBLN02),0) AS OUTBLN02,ISNULL(SUM(MON_OUTBLN03),0) AS OUTBLN03,
                                                       0 AS LBLN04,0 AS LBLN05,0 AS LBLN06,
                                                       0 AS LBLN07,0 AS LBLN08,0 AS LBLN09,
                                                       0 AS LBLN10,0 AS LBLN11,0 AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LPBLN03,
                                                       0 AS OBLN04,0 AS OBLN05,0 AS OBLN06,
                                                       0 AS OBLN07,0 AS OBLN08,0 AS OBLN09,
                                                       0 AS OBLN10,0 AS OBLN11,0 AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                      AND CHR_TAHUN_ACTUAL = '$fis_end' 
                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                      AND CHR_FLG_DELETE = '0'  
                                                      AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_KODE_TYPE_BUDGET                                                
                                            UNION                                                
                                            SELECT CHR_KODE_TYPE_BUDGET, 
                                                     SUM(PBLN04) AS PBLN04, SUM(PBLN05) AS PBLN05, SUM(PBLN06) AS PBLN06, SUM(PBLN07) AS PBLN07, 
                                                     SUM(PBLN08) AS PBLN08, SUM(PBLN09) AS PBLN09, SUM(PBLN10) AS PBLN10, SUM(PBLN11) AS PBLN11, 
                                                     SUM(PBLN12) AS PBLN12, SUM(PBLN01) AS PBLN01, SUM(PBLN02) AS PBLN02, SUM(PBLN03) AS PBLN03,                                                     
                                                     SUM(OUTBLN04) AS OUTBLN04, SUM(OUTBLN05) AS OUTBLN05, SUM(OUTBLN06) AS OUTBLN06, SUM(OUTBLN07) AS OUTBLN07, 
                                                     SUM(OUTBLN08) AS OUTBLN08, SUM(OUTBLN09) AS OUTBLN09, SUM(OUTBLN10) AS OUTBLN10, SUM(OUTBLN11) AS OUTBLN11, 
                                                     SUM(OUTBLN12) AS OUTBLN12, SUM(OUTBLN01) AS OUTBLN01, SUM(OUTBLN02) AS OUTBLN02, SUM(OUTBLN03) AS OUTBLN03,                                                     
                                                     SUM(LBLN04) AS LBLN04, SUM(LBLN05) AS LBLN05, SUM(LBLN06) AS LBLN06, SUM(LBLN07) AS LBLN07, 
                                                     SUM(LBLN08) AS LBLN08, SUM(LBLN09) AS LBLN09, SUM(LBLN10) AS LBLN10, SUM(LBLN11) AS LBLN11, 
                                                     SUM(LBLN12) AS LBLN12, SUM(LBLN01) AS LBLN01, SUM(LBLN02) AS LBLN02, SUM(LBLN03) AS LBLN03,                                                     
                                                     SUM(OBLN04) AS OBLN04, SUM(OBLN05) AS OBLN05, SUM(OBLN06) AS OBLN06, SUM(OBLN07) AS OBLN07, 
                                                     SUM(OBLN08) AS OBLN08, SUM(OBLN09) AS OBLN09, SUM(OBLN10) AS OBLN10, SUM(OBLN11) AS OBLN11, 
                                                     SUM(OBLN12) AS OBLN12, SUM(OBLN01) AS OBLN01, SUM(OBLN02) AS OBLN02, SUM(OBLN03) AS OBLN03,                                                     
                                                     SUM(PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN01 + PBLN02 + PBLN03) AS TOT_PLAN,
                                                     SUM(OUTBLN04 + OUTBLN05 + OUTBLN06 + OUTBLN07 + OUTBLN08 + OUTBLN09 + OUTBLN10 + OUTBLN11 + OUTBLN12 + OUTBLN01 + OUTBLN02 + OUTBLN03) AS TOT_OUT,
                                                     SUM(LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN01 + LBLN02 + LBLN03) AS TOT_LIMIT,
                                                     SUM(OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN01 + OBLN02 + OBLN03) AS TOT_REAL
                                            FROM (SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET AS CHR_TAHUN_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_NO_BUDGET AS CHR_NO_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT AS CHR_KODE_DEPARTMENT, 
                                                        BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET AS CHR_KODE_TYPE_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_DESC_BUDGET AS CHR_DESC_BUDGET, 
                                                        BDGT_CURR_YEAR.CHR_DESC_PROJECT AS CHR_DESC_PROJECT, 
                                                        BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET AS CHR_KODE_SUBCATEGORY_BUDGET,
                                                        BDGT_CURR_YEAR.CHR_FLG_UNBUDGET AS CHR_FLG_UNBUDGET, 
                                                        BDGT_CURR_YEAR.CHR_FLG_RESCHEDULE AS CHR_FLG_RESCHEDULE, 
                                                        BDGT_CURR_YEAR.CHR_FLG_CHANGE_AMOUNT AS CHR_FLG_CHANGE_AMOUNT,
                                                        ISNULL(MON_BLN04,0) AS PBLN04, ISNULL(MON_BLN05,0) AS PBLN05, ISNULL(MON_BLN06,0) AS PBLN06, 
                                                        ISNULL(MON_BLN07,0) AS PBLN07, ISNULL(MON_BLN08,0) AS PBLN08, ISNULL(MON_BLN09,0) AS PBLN09, 
                                                        ISNULL(MON_BLN10,0) AS PBLN10, ISNULL(MON_BLN11,0) AS PBLN11, ISNULL(MON_BLN12,0) AS PBLN12, 
                                                        ISNULL(MON_BLN01,0) AS PBLN01, ISNULL(MON_BLN02,0) AS PBLN02, ISNULL(MON_BLN03,0) AS PBLN03,
                                                        ISNULL(MON_OUTBLN04,0) AS OUTBLN04, ISNULL(MON_OUTBLN05,0) AS OUTBLN05, ISNULL(MON_OUTBLN06,0) AS OUTBLN06, 
                                                        ISNULL(MON_OUTBLN07,0) AS OUTBLN07, ISNULL(MON_OUTBLN08,0) AS OUTBLN08, ISNULL(MON_OUTBLN09,0) AS OUTBLN09, 
                                                        ISNULL(MON_OUTBLN10,0) AS OUTBLN10, ISNULL(MON_OUTBLN11,0) AS OUTBLN11, ISNULL(MON_OUTBLN12,0) AS OUTBLN12, 
                                                        ISNULL(MON_OUTBLN01,0) AS OUTBLN01, ISNULL(MON_OUTBLN02,0) AS OUTBLN02, ISNULL(MON_OUTBLN03,0) AS OUTBLN03,
                                                        ISNULL(MON_LIMBLN04,0) AS LBLN04, ISNULL(MON_LIMBLN05,0) AS LBLN05, ISNULL(MON_LIMBLN06,0) AS LBLN06, 
                                                        ISNULL(MON_LIMBLN07,0) AS LBLN07, ISNULL(MON_LIMBLN08,0) AS LBLN08, ISNULL(MON_LIMBLN09,0) AS LBLN09, 
                                                        ISNULL(MON_LIMBLN10,0) AS LBLN10, ISNULL(MON_LIMBLN11,0) AS LBLN11, ISNULL(MON_LIMBLN12,0) AS LBLN12, 
                                                        ISNULL(MON_LIMBLN01,0) AS LBLN01, ISNULL(MON_LIMBLN02,0) AS LBLN02, ISNULL(MON_LIMBLN03,0) AS LBLN03, 
                                                        ISNULL(MON_OPRBLN04,0) AS OBLN04, ISNULL(MON_OPRBLN05,0) AS OBLN05, ISNULL(MON_OPRBLN06,0) AS OBLN06, 
                                                        ISNULL(MON_OPRBLN07,0) AS OBLN07, ISNULL(MON_OPRBLN08,0) AS OBLN08, ISNULL(MON_OPRBLN09,0) AS OBLN09, 
                                                        ISNULL(MON_OPRBLN10,0) AS OBLN10, ISNULL(MON_OPRBLN11,0) AS OBLN11, ISNULL(MON_OPRBLN12,0) AS OBLN12, 
                                                        ISNULL(MON_OPRBLN01,0) AS OBLN01, ISNULL(MON_OPRBLN02,0) AS OBLN02, ISNULL(MON_OPRBLN03,0) AS OBLN03
                                                    FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                                    CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                                    CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                                    MON_BLN04, MON_BLN05, MON_BLN06,
                                                                    MON_BLN07, MON_BLN08, MON_BLN09,
                                                                    MON_BLN10, MON_BLN11, MON_BLN12,
                                                                    MON_OUTBLN04, MON_OUTBLN05, MON_OUTBLN06,
                                                                    MON_OUTBLN07, MON_OUTBLN08, MON_OUTBLN09,
                                                                    MON_OUTBLN10, MON_OUTBLN11, MON_OUTBLN12,
                                                                    MON_LIMBLN04, MON_LIMBLN05, MON_LIMBLN06,
                                                                    MON_LIMBLN07, MON_LIMBLN08, MON_LIMBLN09,
                                                                    MON_LIMBLN10, MON_LIMBLN11, MON_LIMBLN12,
                                                                    MON_OPRBLN04, MON_OPRBLN05, MON_OPRBLN06,
                                                                    MON_OPRBLN07, MON_OPRBLN08, MON_OPRBLN09,
                                                                    MON_OPRBLN10, MON_OPRBLN11, MON_OPRBLN12
                                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                                            WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                                    LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01, MON_BLN02, MON_BLN03,
                                                                MON_OUTBLN01, MON_OUTBLN02, MON_OUTBLN03,
                                                                MON_LIMBLN01, MON_LIMBLN02, MON_LIMBLN03,
                                                                MON_OPRBLN01, MON_OPRBLN02, MON_OPRBLN03
                                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                                            WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fis_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE
                                            GROUP BY CHR_KODE_TYPE_BUDGET")->result();
            return $summary_budget;
    }
    
    function get_ori_plan_capex($fis_start, $year, $month, $dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $ori_plan = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, 
                                       ISNULL(SUM(MON_BLN$month),0) AS PBLN,
                                       ISNULL(SUM(MON_OUTBLN$month),0) AS OUTBLN,
                                       ISNULL(SUM(MON_LIMBLN$month),0) AS LBLN,
                                       ISNULL(SUM(MON_OPRBLN$month),0) AS OBLN
                                FROM BDGT_TM_BUDGET_CAPEX 
                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                     AND CHR_TAHUN_ACTUAL = '$year' 
                                     AND CHR_KODE_DEPARTMENT = '$dept' 
                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                     AND CHR_FLG_DELETE = '0' 
                                     AND CHR_FLG_FOR_AIIA = '0'
                                GROUP BY CHR_KODE_TYPE_BUDGET")->row();
        return $ori_plan;
    }
    
    function get_ori_plan_capex_fy($fis_start, $year, $month, $dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $ori_plan = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, 
                                       ISNULL(SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12),0) AS PBLN,
                                       ISNULL(SUM(MON_OUTBLN01+MON_OUTBLN02+MON_OUTBLN03+MON_OUTBLN04+MON_OUTBLN05+MON_OUTBLN06+MON_OUTBLN07+MON_OUTBLN08+MON_OUTBLN09+MON_OUTBLN10+MON_OUTBLN11+MON_OUTBLN12),0) AS OUTBLN,
                                       ISNULL(SUM(MON_LIMBLN01+MON_LIMBLN02+MON_LIMBLN03+MON_LIMBLN04+MON_LIMBLN05+MON_LIMBLN06+MON_LIMBLN07+MON_LIMBLN08+MON_LIMBLN09+MON_LIMBLN10+MON_LIMBLN11+MON_LIMBLN12),0) AS LBLN,
                                       ISNULL(SUM(MON_OPRBLN01+MON_OPRBLN02+MON_OPRBLN03+MON_OPRBLN04+MON_OPRBLN05+MON_OPRBLN06+MON_OPRBLN07+MON_OPRBLN08+MON_OPRBLN09+MON_OPRBLN10+MON_OPRBLN11+MON_OPRBLN12),0) AS OBLN
                                FROM BDGT_TM_BUDGET_CAPEX 
                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                     AND CHR_KODE_DEPARTMENT = '$dept' 
                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                     AND CHR_FLG_DELETE = '0' 
                                     AND CHR_FLG_FOR_AIIA = '0'
                                GROUP BY CHR_KODE_TYPE_BUDGET")->row();
        return $ori_plan;
    }
    
    function get_ori_plan_expense($fis_start, $year, $month, $dept, $bgt_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $ori_plan = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, 
                                       ISNULL(SUM(MON_BLN$month),0) AS PBLN,
                                       ISNULL(SUM(MON_OUTBLN$month),0) AS OUTBLN,
                                       ISNULL(SUM(MON_LIMBLN$month),0) AS LBLN,
                                       ISNULL(SUM(MON_OPRBLN$month),0) AS OBLN
                                FROM BDGT_TM_BUDGET_EXPENSE
                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                     AND CHR_TAHUN_ACTUAL = '$year' 
                                     AND CHR_KODE_DEPARTMENT = '$dept' 
                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                     AND CHR_FLG_DELETE = '0'
                                GROUP BY CHR_KODE_TYPE_BUDGET")->row();
        return $ori_plan;
    }
    
//    function get_detail_all_list_budget($fiscal, $kode_dept, $bgt_type, $no_propose){
//        $bgt_aii = $this->load->database("bgt_aii", TRUE);
//        $fis_start = substr($fiscal,0,4);
//        $fis_end = substr($fiscal,4,4);
//        if($bgt_type == "CAPEX"){
//            $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
//                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
//                                                     SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
//                                                     SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
//                                                     SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
//                                                     SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
//                                                     SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15,
//                                                     SUM(LBLN01) AS LBLN01,SUM(LBLN02) AS LBLN02,SUM(LBLN03) AS LBLN03,
//                                                     SUM(LBLN04) AS LBLN04,SUM(LBLN05) AS LBLN05,SUM(LBLN06) AS LBLN06,
//                                                     SUM(LBLN07) AS LBLN07,SUM(LBLN08) AS LBLN08,SUM(LBLN09) AS LBLN09,
//                                                     SUM(LBLN10) AS LBLN10,SUM(LBLN11) AS LBLN11,SUM(LBLN12) AS LBLN12,
//                                                     SUM(LBLN13) AS LBLN13,SUM(LBLN14) AS LBLN14,SUM(LBLN15) AS LBLN15,
//                                                     SUM(OBLN01) AS OBLN01,SUM(OBLN02) AS OBLN02,SUM(OBLN03) AS OBLN03,
//                                                     SUM(OBLN04) AS OBLN04,SUM(OBLN05) AS OBLN05,SUM(OBLN06) AS OBLN06,
//                                                     SUM(OBLN07) AS OBLN07,SUM(OBLN08) AS OBLN08,SUM(OBLN09) AS OBLN09,
//                                                     SUM(OBLN10) AS OBLN10,SUM(OBLN11) AS OBLN11,SUM(OBLN12) AS OBLN12,
//                                                     SUM(OBLN13) AS OBLN13,SUM(OBLN14) AS OBLN14,SUM(OBLN15) AS OBLN15
//                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
//                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
//                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
//                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
//                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
//                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
//                                                       0 AS PBLN13,0 AS PBLN14,0 AS PBLN15,
//                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
//                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
//                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
//                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
//                                                       0 AS LBLN13,0 AS LBLN14,0 AS LBLN15,
//                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
//                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
//                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
//                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
//                                                       0 AS OBLN13,0 AS OBLN14,0 AS OBLN15
//                                                FROM BDGT_TM_BUDGET_CAPEX 
//                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
//                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
//                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
//                                                     AND CHR_FLG_DELETE = '0' 
//                                                     AND CHR_FLG_FOR_AIIA = '0'
//                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
//                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET
//                                                UNION
//                                                SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
//                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
//                                                       0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
//                                                       0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
//                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
//                                                       0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,0 AS LBLN04,0 AS LBLN05,0 AS LBLN06,
//                                                       0 AS LBLN07,0 AS LBLN08,0 AS LBLN09,0 AS LBLN10,0 AS LBLN11,0 AS LBLN12,
//                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LPBLN15,
//                                                       0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,0 AS OBLN04,0 AS OBLN05,0 AS OBLN06,
//                                                       0 AS OBLN07,0 AS OBLN08,0 AS OBLN09,0 AS OBLN10,0 AS OBLN11,0 AS OBLN12,
//                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
//                                                FROM BDGT_TM_BUDGET_CAPEX 
//                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
//                                                      AND CHR_TAHUN_ACTUAL = '$fis_end' 
//                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
//                                                      AND CHR_FLG_DELETE = '0'  
//                                                      AND CHR_FLG_FOR_AIIA = '0'
//                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
//                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET) AS BDGT_TM_BUDGET_CAPEX
//                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
//                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET")->result();
//            return $list_budget;
//        } else {
//           $list_budget = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, 
//                                                     BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, BDGT_CURR_YEAR.CHR_DESC_BUDGET, 
//                                                     BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET,
//                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
//                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
//                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
//                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
//                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
//                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
//                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
//                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
//                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
//                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
//                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
//                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
//                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
//                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
//                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
//                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
//                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
//                                                                    MON_BLN01,MON_BLN02,MON_BLN03,
//                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
//                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
//                                                                    MON_BLN10,MON_BLN11,MON_BLN12,
//                                                                    MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
//                                                                    MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
//                                                                    MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
//                                                                    MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
//                                                                    MON_OPRBLN01,MON_OPRBLN02,MON_OPRBLN03,
//                                                                    MON_OPRBLN04,MON_OPRBLN05,MON_OPRBLN06,
//                                                                    MON_OPRBLN07,MON_OPRBLN08,MON_OPRBLN09,
//                                                                    MON_OPRBLN10,MON_OPRBLN11,MON_OPRBLN12
//                                                       FROM BDGT_TM_BUDGET_EXPENSE 
//                                                       WHERE CHR_TAHUN_BUDGET = '$fis_start' 
//                                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
//                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
//                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
//                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
//                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
//                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
//                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
//                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fis_start' 
//                                                                AND CHR_TAHUN_ACTUAL = '$fis_end' 
//                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
//                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
//                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
//                                                     BDGT_CURR_YEAR.CHR_DESC_BUDGET, BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET")->result();
//            return $list_budget; 
//        }        
//    }
    
    function get_all_list_budget_dept($fiscal, $kode_dept, $bgt_type, $no_propose){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $fis_start = substr($fiscal,0,4);
        $fis_end = substr($fiscal,4,4);
        if($bgt_type == "CAPEX"){
            $list_budget = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(PBLN01 + PBLN02 + PBLN03 + PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN13 + PBLN14 + PBLN15) AS TOT_PLAN,
                                                     SUM(LBLN01 + LBLN02 + LBLN03 + LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN13 + LBLN14 + LBLN15) AS TOT_LIMIT,
                                                     SUM(OBLN01 + OBLN02 + OBLN03 + OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN13 + OBLN14 + OBLN15) AS TOT_REAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       0 AS PBLN13,0 AS PBLN14,0 AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       0 AS LBLN13,0 AS LBLN14,0 AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       0 AS OBLN13,0 AS OBLN14,0 AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT
                                                UNION
                                                SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                       0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                       0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                       0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,0 AS LBLN04,0 AS LBLN05,0 AS LBLN06,
                                                       0 AS LBLN07,0 AS LBLN08,0 AS LBLN09,0 AS LBLN10,0 AS LBLN11,0 AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LPBLN15,
                                                       0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,0 AS OBLN04,0 AS OBLN05,0 AS OBLN06,
                                                       0 AS OBLN07,0 AS OBLN08,0 AS OBLN09,0 AS OBLN10,0 AS OBLN11,0 AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                      AND CHR_TAHUN_ACTUAL = '$fis_end' 
                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                      AND CHR_FLG_DELETE = '0'  
                                                      AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT")->result();
            return $list_budget;
        } else {
           $list_budget = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, 
                                                     BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, BDGT_CURR_YEAR.CHR_DESC_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET,
                                                     BDGT_CURR_YEAR.CHR_FLG_UNBUDGET, BDGT_CURR_YEAR.CHR_FLG_RESCHEDULE, BDGT_CURR_YEAR.CHR_FLG_CHANGE_AMOUNT,
                                                     SUM(MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15) AS TOT_PLAN,
                                                     SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15) AS TOT_LIMIT,
                                                     SUM(MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15) AS TOT_REAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                     CHR_FLG_UNBUDGET, CHR_FLG_RESCHEDULE, CHR_FLG_CHANGE_AMOUNT,
                                                                    MON_BLN01,MON_BLN02,MON_BLN03,
                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
                                                                    MON_BLN10,MON_BLN11,MON_BLN12,
                                                                    MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                                    MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                                    MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                                    MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                                    MON_OPRBLN01,MON_OPRBLN02,MON_OPRBLN03,
                                                                    MON_OPRBLN04,MON_OPRBLN05,MON_OPRBLN06,
                                                                    MON_OPRBLN07,MON_OPRBLN08,MON_OPRBLN09,
                                                                    MON_OPRBLN10,MON_OPRBLN11,MON_OPRBLN12
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fis_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fis_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fis_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_BUDGET, BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET,
                                                     BDGT_CURR_YEAR.CHR_FLG_UNBUDGET, BDGT_CURR_YEAR.CHR_FLG_RESCHEDULE, BDGT_CURR_YEAR.CHR_FLG_CHANGE_AMOUNT")->result();
            return $list_budget; 
        }        
    }
    
    //--------------------- DETAIL BUDGET PLAN PER MONTH ---------------------//
    function get_budget_plan($year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
//            $budget_detail = $bgt_aii->query("SELECT SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
//                                                     SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
//                                                     SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
//                                                     SUM(PBLN01) AS PBLN13,SUM(PBLN02) AS PBLN14,SUM(PBLN03) AS PBLN15
//                                            FROM (SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
//                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
//                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
//                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12
//                                                FROM BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$year_start' 
//                                                     AND CHR_TAHUN_ACTUAL = '$year_start' 
//                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
//                                                     AND CHR_FLG_DELETE = '0' 
//                                                     AND CHR_FLG_FOR_AIIA = '0'
//                                                UNION
//                                                SELECT ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03, 
//                                                       0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
//                                                       0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
//                                                       0 AS PBLN10,0 AS PBLN11,0 AS PBLN12
//                                                FROM BDGT_TM_BUDGET_CAPEX 
//                                                WHERE CHR_TAHUN_BUDGET = '$year_start' 
//                                                      AND CHR_TAHUN_ACTUAL = '$year_end' 
//                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept' 
//                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
//                                                      AND CHR_FLG_DELETE = '0'  
//                                                      AND CHR_FLG_FOR_AIIA = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            $budget_detail = $bgt_aii->query("SELECT SUM(MON_BLN04) AS PBLN04,SUM(MON_BLN05) AS PBLN05,SUM(MON_BLN06) AS PBLN06,
                                                     SUM(MON_BLN07) AS PBLN07,SUM(MON_BLN08) AS PBLN08,SUM(MON_BLN09) AS PBLN09,
                                                     SUM(MON_BLN10) AS PBLN10,SUM(MON_BLN11) AS PBLN11,SUM(MON_BLN12) AS PBLN12,
                                                     SUM(MON_BLN01) AS PBLN13,SUM(MON_BLN02) AS PBLN14,SUM(MON_BLN03) AS PBLN15
                                            FROM  BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT   ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,
                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
                                                                    MON_BLN10,MON_BLN11,MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$year_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET, MON_BLN01, MON_BLN02, MON_BLN03 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //------------------ DETAIL BUDGET PLAN PER MONTH GM ---------------------//
    function get_budget_plan_gm($year_start, $year_end, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT SUM(MON_BLN04) AS PBLN04,SUM(MON_BLN05) AS PBLN05,SUM(MON_BLN06) AS PBLN06,
                                                     SUM(MON_BLN07) AS PBLN07,SUM(MON_BLN08) AS PBLN08,SUM(MON_BLN09) AS PBLN09,
                                                     SUM(MON_BLN10) AS PBLN10,SUM(MON_BLN11) AS PBLN11,SUM(MON_BLN12) AS PBLN12,
                                                     SUM(MON_BLN01) AS PBLN13,SUM(MON_BLN02) AS PBLN14,SUM(MON_BLN03) AS PBLN15
                                            FROM  BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                     AND CHR_KODE_GROUP = '$kode_group' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT   ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,
                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
                                                                    MON_BLN10,MON_BLN11,MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$year_start' 
                                                                     AND CHR_KODE_GROUP = '$kode_group' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET, MON_BLN01, MON_BLN02, MON_BLN03 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                                AND CHR_KODE_GROUP = '$kode_group' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //------------------ DETAIL BUDGET REV PER MONTH GM ---------------------//
    function get_budget_rev_gm($year_start, $year_end, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                         AND CHR_KODE_GROUP = '$kode_group' 
                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                         AND CHR_FLG_DELETE = '0' 
                                         AND CHR_FLG_CANCEL = '0' 
                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_group '$year_start', '$year_end', '$budget_type', '$kode_group', ''")->row();
            return $budget_detail;
        }
    }
    
    //------------------ DETAIL BUDGET REV PER MONTH BOD ---------------------//
    function get_budget_rev_bod($year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                         AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                         AND CHR_FLG_DELETE = '0' 
                                         AND CHR_FLG_CANCEL = '0' 
                                         AND CHR_FLG_UNBUDGET = '0'
                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_plant '$year_start', '$year_end', '$budget_type', ''")->row();
            return $budget_detail;
        }
    }
    
    //------------------ DETAIL BUDGET REV PER MONTH ---------------------//
    function get_budget_rev($year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                         AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                         AND CHR_FLG_DELETE = '0' 
                                         AND CHR_FLG_CANCEL = '0'
                                         AND CHR_FLG_UNBUDGET = '0'
                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_dept '$year_start', '$year_end', '$budget_type', '$kode_dept', ''")->row();
            return $budget_detail;
        }
    }
    
    //------------------ DETAIL BUDGET PLAN PER MONTH BOD --------------------//
    function get_budget_plan_bod($year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT SUM(MON_BLN04) AS PBLN04,SUM(MON_BLN05) AS PBLN05,SUM(MON_BLN06) AS PBLN06,
                                                     SUM(MON_BLN07) AS PBLN07,SUM(MON_BLN08) AS PBLN08,SUM(MON_BLN09) AS PBLN09,
                                                     SUM(MON_BLN10) AS PBLN10,SUM(MON_BLN11) AS PBLN11,SUM(MON_BLN12) AS PBLN12,
                                                     SUM(MON_BLN01) AS PBLN13,SUM(MON_BLN02) AS PBLN14,SUM(MON_BLN03) AS PBLN15
                                            FROM  BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                     AND CHR_KODE_DIVISI = '001' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT   ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,
                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
                                                                    MON_BLN10,MON_BLN11,MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$year_start' 
                                                                     AND CHR_KODE_DIVISI = '001' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET, MON_BLN01, MON_BLN02, MON_BLN03 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                                AND CHR_KODE_DIVISI = '001' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //--------------------- DETAIL BUDGET LIMIT PER MONTH --------------------//
    function get_budget_limit($year_start, $year_end, $budget_type, $kode_dept, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_limit = $bgt_aii->query("SELECT SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                   SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                   SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                   SUM(PBLN01) AS PBLN13,SUM(PBLN02) AS PBLN14,SUM(PBLN03) AS PBLN15
                                            FROM(SELECT --0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                       AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_limit;
        } else {
            if($act_periode < $periode_smt2){
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
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_EXPENSE 
                                                      WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                            AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $budget_limit;
            } else {
                $budget_limit = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                                FROM (SELECT CHR_KODE_DEPARTMENT,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start'
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_DEPARTMENT,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
        }
    }
    
    //------------------ DETAIL BUDGET LIMIT PER MONTH GM --------------------//
    function get_budget_limit_gm($year_start, $year_end, $budget_type, $kode_group, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_limit = $bgt_aii->query("SELECT SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                   SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                   SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                   SUM(PBLN01) AS PBLN13,SUM(PBLN02) AS PBLN14,SUM(PBLN03) AS PBLN15
                                            FROM(SELECT ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                       AND CHR_KODE_GROUP = '$kode_group' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_limit;
        } else {
            if($act_periode < $periode_smt2){
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
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            AND CHR_KODE_GROUP = '$kode_group' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_EXPENSE 
                                                      WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                            AND CHR_KODE_GROUP = '$kode_group' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $budget_limit;
            } else {
                $budget_limit = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                                FROM (SELECT CHR_KODE_DEPARTMENT,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start'
                                                        AND CHR_KODE_GROUP = '$kode_group' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_DEPARTMENT,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                        AND CHR_KODE_GROUP = '$kode_group' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
        }
    }
    
    //------------------ DETAIL BUDGET LIMIT PER MONTH BOD -------------------//
    function get_budget_limit_bod($year_start, $year_end, $budget_type, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_limit = $bgt_aii->query("SELECT SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                   SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                   SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                   SUM(PBLN01) AS PBLN13,SUM(PBLN02) AS PBLN14,SUM(PBLN03) AS PBLN15
                                            FROM(SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                       AND CHR_TAHUN_ACTUAL = '$year_start' 
                                                       AND CHR_KODE_DIVISI = '001' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                 UNION 
                                                 SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                        0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                        0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                        0 AS PBLN10,0 AS PBLN11,0 AS PBLN12  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                       AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                       AND CHR_KODE_DIVISI = '001' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_limit;
        } else {
            if($act_periode < $periode_smt2){
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
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_EXPENSE 
                                                      WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                            AND CHR_KODE_DIVISI = '001'
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $budget_limit;
            } else {
                $budget_limit = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                                FROM (SELECT CHR_KODE_DEPARTMENT,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start'
                                                        AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_DEPARTMENT,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                        AND CHR_KODE_DIVISI = '001'
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
        }
    }
    
    //---------------------- DETAIL ACTUAL PER MONTH ----------------------//
    function get_actual_real($year_start, $year_end, $budget_type, $kode_dept, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){//            
            $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(MON_OPRBLN04),0) AS OPRBLN04, ISNULL(SUM(MON_OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(MON_OPRBLN06),0) AS OPRBLN06, 
                                                 ISNULL(SUM(MON_OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(MON_OPRBLN08),0) AS OPRBLN08, ISNULL(SUM(MON_OPRBLN09),0) AS OPRBLN09, 
                                                 ISNULL(SUM(MON_OPRBLN10),0) AS OPRBLN10, ISNULL(SUM(MON_OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(MON_OPRBLN12),0) AS OPRBLN12,
                                                 ISNULL(SUM(MON_OPRBLN01),0) AS OPRBLN13, ISNULL(SUM(MON_OPRBLN02),0) AS OPRBLN14, ISNULL(SUM(MON_OPRBLN03),0) AS OPRBLN15
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$year_start'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $actual_real;
        } else {
            if($act_periode < $periode_smt2){
                $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                     ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                     ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                     ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                     ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                     ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                     ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                                     ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                              FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01_MAN AS OPRBLN01, MON_OPRBLN02_MAN AS OPRBLN02, 
                                                         MON_OPRBLN03_MAN AS OPRBLN03, MON_OPRBLN04_MAN AS OPRBLN04, 
                                                         MON_OPRBLN05_MAN AS OPRBLN05, MON_OPRBLN06_MAN AS OPRBLN06, 
                                                         MON_OPRBLN07_MAN AS OPRBLN07, MON_OPRBLN08_MAN AS OPRBLN08, 
                                                         MON_OPRBLN09_MAN AS OPRBLN09, MON_OPRBLN10_MAN AS OPRBLN10, 
                                                         MON_OPRBLN11_MAN AS OPRBLN11, MON_OPRBLN12_MAN AS OPRBLN12
                                                         --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_MAN AS OPRBLN13, 
                                                                MON_OPRBLN02_MAN AS OPRBLN14, 
                                                                MON_OPRBLN03_MAN AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            } else {
                $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                     ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                     ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                     ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                     ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                     ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                     ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                                     ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                              FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01_MAN AS OPRBLN01, MON_OPRBLN02_MAN AS OPRBLN02, 
                                                         MON_OPRBLN03_MAN AS OPRBLN03, MON_OPRBLN04_MAN AS OPRBLN04, 
                                                         MON_OPRBLN05_MAN AS OPRBLN05, MON_OPRBLN06_MAN AS OPRBLN06, 
                                                         MON_OPRBLN07_MAN AS OPRBLN07, MON_OPRBLN08_MAN AS OPRBLN08, 
                                                         MON_OPRBLN09_MAN AS OPRBLN09, MON_OPRBLN10_MAN AS OPRBLN10, 
                                                         MON_OPRBLN11_MAN AS OPRBLN11, MON_OPRBLN12_MAN AS OPRBLN12
                                                         --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_MAN AS OPRBLN13, 
                                                                MON_OPRBLN02_MAN AS OPRBLN14, 
                                                                MON_OPRBLN03_MAN AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
        }
    }
    
    //------------------- DETAIL ACTUAL PER MONTH GM -------------------------//
    function get_actual_real_gm($year_start, $year_end, $budget_type, $kode_group, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(MON_OPRBLN04),0) AS OPRBLN04, ISNULL(SUM(MON_OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(MON_OPRBLN06),0) AS OPRBLN06, 
                                                 ISNULL(SUM(MON_OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(MON_OPRBLN08),0) AS OPRBLN08, ISNULL(SUM(MON_OPRBLN09),0) AS OPRBLN09, 
                                                 ISNULL(SUM(MON_OPRBLN10),0) AS OPRBLN10, ISNULL(SUM(MON_OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(MON_OPRBLN12),0) AS OPRBLN12,
                                                 ISNULL(SUM(MON_OPRBLN01),0) AS OPRBLN13, ISNULL(SUM(MON_OPRBLN02),0) AS OPRBLN14, ISNULL(SUM(MON_OPRBLN03),0) AS OPRBLN15
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_GROUP = '$kode_group'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$year_start'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $actual_real;
        } else {
            if($act_periode < $periode_smt2){
                $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                     ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                     ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                     ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                     ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                     ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                     ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                                     ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                              FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01_GM AS OPRBLN01, MON_OPRBLN02_GM AS OPRBLN02, 
                                                         MON_OPRBLN03_GM AS OPRBLN03, MON_OPRBLN04_GM AS OPRBLN04, 
                                                         MON_OPRBLN05_GM AS OPRBLN05, MON_OPRBLN06_GM AS OPRBLN06, 
                                                         MON_OPRBLN07_GM AS OPRBLN07, MON_OPRBLN08_GM AS OPRBLN08, 
                                                         MON_OPRBLN09_GM AS OPRBLN09, MON_OPRBLN10_GM AS OPRBLN10, 
                                                         MON_OPRBLN11_GM AS OPRBLN11, MON_OPRBLN12_GM AS OPRBLN12
                                                         --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_GROUP = '$kode_group'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_GM AS OPRBLN13, 
                                                                MON_OPRBLN02_GM AS OPRBLN14, 
                                                                MON_OPRBLN03_GM AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_GROUP = '$kode_group'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            } else {
                $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                     ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                     ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                     ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                     ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                     ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                     ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                                     ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                              FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01_GM AS OPRBLN01, MON_OPRBLN02_GM AS OPRBLN02, 
                                                         MON_OPRBLN03_GM AS OPRBLN03, MON_OPRBLN04_GM AS OPRBLN04, 
                                                         MON_OPRBLN05_GM AS OPRBLN05, MON_OPRBLN06_GM AS OPRBLN06, 
                                                         MON_OPRBLN07_GM AS OPRBLN07, MON_OPRBLN08_GM AS OPRBLN08, 
                                                         MON_OPRBLN09_GM AS OPRBLN09, MON_OPRBLN10_GM AS OPRBLN10, 
                                                         MON_OPRBLN11_GM AS OPRBLN11, MON_OPRBLN12_GM AS OPRBLN12
                                                         --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_GROUP = '$kode_group'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_GM AS OPRBLN13, 
                                                                MON_OPRBLN02_GM AS OPRBLN14, 
                                                                MON_OPRBLN03_GM AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_GROUP = '$kode_group'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
        }
    }
    
    //------------------- DETAIL ACTUAL PER MONTH BOD ------------------------//
    function get_actual_real_bod($year_start, $year_end, $budget_type, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(MON_OPRBLN04),0) AS OPRBLN04, ISNULL(SUM(MON_OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(MON_OPRBLN06),0) AS OPRBLN06, 
                                                 ISNULL(SUM(MON_OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(MON_OPRBLN08),0) AS OPRBLN08, ISNULL(SUM(MON_OPRBLN09),0) AS OPRBLN09, 
                                                 ISNULL(SUM(MON_OPRBLN10),0) AS OPRBLN10, ISNULL(SUM(MON_OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(MON_OPRBLN12),0) AS OPRBLN12,
                                                 ISNULL(SUM(MON_OPRBLN01),0) AS OPRBLN13, ISNULL(SUM(MON_OPRBLN02),0) AS OPRBLN14, ISNULL(SUM(MON_OPRBLN03),0) AS OPRBLN15
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DIVISI = '001'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$year_start'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $actual_real;
        } else {
            if($act_periode < $periode_smt2){
                $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                     ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                     ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                     ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                     ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                     ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                     ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                                     ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                              FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01_GM AS OPRBLN01, MON_OPRBLN02_GM AS OPRBLN02, 
                                                         MON_OPRBLN03_GM AS OPRBLN03, MON_OPRBLN04_GM AS OPRBLN04, 
                                                         MON_OPRBLN05_GM AS OPRBLN05, MON_OPRBLN06_GM AS OPRBLN06, 
                                                         MON_OPRBLN07_GM AS OPRBLN07, MON_OPRBLN08_GM AS OPRBLN08, 
                                                         MON_OPRBLN09_GM AS OPRBLN09, MON_OPRBLN10_GM AS OPRBLN10, 
                                                         MON_OPRBLN11_GM AS OPRBLN11, MON_OPRBLN12_GM AS OPRBLN12
                                                         --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DIVISI = '001'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_GM AS OPRBLN13, 
                                                                MON_OPRBLN02_GM AS OPRBLN14, 
                                                                MON_OPRBLN03_GM AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DIVISI = '001'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            } else {
                $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                     ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                     ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                     ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                     ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                     ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                     ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                                     ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                              FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01_GM AS OPRBLN01, MON_OPRBLN02_GM AS OPRBLN02, 
                                                         MON_OPRBLN03_GM AS OPRBLN03, MON_OPRBLN04_GM AS OPRBLN04, 
                                                         MON_OPRBLN05_GM AS OPRBLN05, MON_OPRBLN06_GM AS OPRBLN06, 
                                                         MON_OPRBLN07_GM AS OPRBLN07, MON_OPRBLN08_GM AS OPRBLN08, 
                                                         MON_OPRBLN09_GM AS OPRBLN09, MON_OPRBLN10_GM AS OPRBLN10, 
                                                         MON_OPRBLN11_GM AS OPRBLN11, MON_OPRBLN12_GM AS OPRBLN12
                                                         --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DIVISI = '001'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_GM AS OPRBLN13, 
                                                                MON_OPRBLN02_GM AS OPRBLN14, 
                                                                MON_OPRBLN03_GM AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DIVISI = '001'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$year_start'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
        }
    }
    
    //--------------------- DETAIL ACTUAL GR PER MONTH -----------------------//
    function get_actual_gr($start_date, $end_date, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_gr = $bgt_aii-> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_CAPEX 
                                            WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_BDGT_DEPT = '$kode_dept')")->row();
            return $actual_gr;
        } else {
            $actual_gr = $bgt_aii-> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_BDGT_DEPT = '$kode_dept') ")->row();
            return $actual_gr;
        }            
    }
    
    //--------------------- DETAIL ACTUAL GR PER MONTH BY GM -----------------//
    function get_actual_gr_by_gm($start_date, $end_date, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_gr = $bgt_aii-> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_CAPEX 
                                            WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group'))")->row();
            return $actual_gr;
        } else {
            $actual_gr = $bgt_aii-> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group')) ")->row();
            return $actual_gr;
        }            
    }
    
    //--------------------- DETAIL ACTUAL GR PER MONTH BY BOD ----------------//
    function get_actual_gr_by_bod($start_date, $end_date, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_gr = $bgt_aii-> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_CAPEX 
                                            WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT'))")->row();
            return $actual_gr;
        } else {
            $actual_gr = $bgt_aii-> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')) ")->row();
            return $actual_gr;
        }            
    }
    
    //----------------- DETAIL EST GR PER MONTH BY PROP ----------------------//
    function get_est_gr_prop($year_month, $budget_type, $kode_dept){
        $est_gr = $this->db->query("SELECT ISNULL(SUM(MON_PROPOSE_BLN),0) AS TOTAL
                                    FROM CPL.TT_DETAIL_PROPOSE_BUDGET 
                                    WHERE CHR_FLG_DELETE <> 1
                                        AND CHR_DEPT = '$kode_dept'
                                        AND CHR_BUDGET_TYPE = '$budget_type'
                                        AND CHR_ESTIMATE_GR_DATE = '$year_month'")->row();
        return $est_gr;         
    }
    
    //----------------- DETAIL EST GR PER MONTH BY PROP BY GM ----------------//
    function get_est_gr_prop_by_gm($year_month, $budget_type, $id_group){
        $est_gr = $this->db->query("SELECT ISNULL(SUM(MON_PROPOSE_BLN),0) AS TOTAL
                                    FROM CPL.TT_DETAIL_PROPOSE_BUDGET 
                                    WHERE CHR_FLG_DELETE <> 1
                                        AND CHR_DEPT IN (SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_GROUP_DEPT = '$id_group')
                                        AND CHR_BUDGET_TYPE = '$budget_type'
                                        AND CHR_ESTIMATE_GR_DATE = '$year_month'")->row();
        return $est_gr;         
    }
    
    //----------------- DETAIL EST GR PER MONTH BY PROP BY BOD ---------------//
    function get_est_gr_prop_by_bod($year_month, $budget_type){
        $est_gr = $this->db->query("SELECT ISNULL(SUM(MON_PROPOSE_BLN),0) AS TOTAL
                                    FROM CPL.TT_DETAIL_PROPOSE_BUDGET 
                                    WHERE CHR_FLG_DELETE <> 1
                                        AND CHR_DEPT IN (SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_GROUP_DEPT IN (SELECT INT_ID_GROUP_DEPT FROM TM_GROUP_DEPT WHERE INT_ID_DIVISION = '3'))
                                        AND CHR_BUDGET_TYPE = '$budget_type'
                                        AND CHR_ESTIMATE_GR_DATE = '$year_month'")->row();
        return $est_gr;         
    }
    
    //-------------------- DETAIL EST GR PER MONTH BY PR ---------------------//
    function get_est_gr_pr($year_month, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $est_gr = $bgt_aii->query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
                                    FROM BDGT_TT_BUDGET_PR_DETAIL
                                    WHERE CHR_TGL_ESTIMASI_KEDATANGAN LIKE '$year_month%'
                                        AND CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
                                                                FROM BDGT_TT_BUDGET_PR_HEADER
                                                                WHERE CHR_KODE_TYPE_BUDGET = '$budget_type' AND CHR_KODE_DEPARTMENT = '$kode_dept')")->row();
        return $est_gr;         
    }
    
    //-------------------- DETAIL EST GR PER MONTH BY PR BY GM ---------------//
    function get_est_gr_pr_by_gm($year_month, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $est_gr = $bgt_aii->query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
                                    FROM BDGT_TT_BUDGET_PR_DETAIL
                                    WHERE CHR_TGL_ESTIMASI_KEDATANGAN LIKE '$year_month%'
                                        AND CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
                                                                FROM BDGT_TT_BUDGET_PR_HEADER
                                                                WHERE CHR_KODE_TYPE_BUDGET = '$budget_type' AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group'))")->row();
        return $est_gr;         
    }
    
    //-------------------- DETAIL EST GR PER MONTH BY PR BY BOD --------------//
    function get_est_gr_pr_by_bod($year_month, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $est_gr = $bgt_aii->query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
                                    FROM BDGT_TT_BUDGET_PR_DETAIL
                                    WHERE CHR_TGL_ESTIMASI_KEDATANGAN LIKE '$year_month%'
                                        AND CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
                                                                FROM BDGT_TT_BUDGET_PR_HEADER
                                                                WHERE CHR_KODE_TYPE_BUDGET = '$budget_type' AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT'))")->row();
        return $est_gr;         
    }
    
    function get_exist_no_propose($fiscal_start, $year, $month, $kode_dept){
        $exist_no = $this->db->query("SELECT TOP 1 CHR_NO_PROPOSE
                                    FROM CPL.TT_HEADER_PROPOSE_BUDGET
                                    WHERE CHR_YEAR_BUDGET = '$fiscal_start'
                                        AND CHR_DEPT = '$kode_dept'
                                        AND CHR_YEAR_PROPOSE = '$year'
                                        AND CHR_MONTH_PROPOSE = '$month'
                                    ORDER BY INT_ID_HEADER_PROPOSE DESC")->row();
        return $exist_no;
    }
    
    function insert_reschedule($prop_budget) {
        $tabel_master = "CPL.TT_DETAIL_PROPOSE_BUDGET";
        $this->db->insert($tabel_master, $prop_budget);              
    }
    
    function insert_new_propose($data_propose) {
        $tabel_master = "CPL.TT_HEADER_PROPOSE_BUDGET";
        $this->db->insert($tabel_master, $data_propose);              
    }
    
    function insert_new_notes($no_propose) {
        $this->db->query("INSERT INTO CPL.TT_NOTES_PROPOSE_BUDGET (CHR_NO_PROPOSE) VALUES ('$no_propose')");              
    }
    
    function save_propose_budget($propose) {
        $tabel_master = "CPL.TW_PROPOSE_BUDGET";
        $this->db->insert($tabel_master, $propose);              
    }
    
    function update_proposed_budget($proposed, $no_propose, $no_budget) {
        $tabel_master = "CPL.TT_DETAIL_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);
        $this->db->where('CHR_NO_BUDGET', $no_budget);
        $this->db->update($tabel_master, $proposed);              
    }
    
    function update_notes_budget($notes, $no_propose) {
        $tabel_master = "CPL.TT_NOTES_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);
        $this->db->update($tabel_master, $notes);              
    }
    
    function delete_proposed_budget($no_propose, $no_budget) {
        $this->db->query("DELETE FROM CPL.TT_DETAIL_PROPOSE_BUDGET WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_NO_BUDGET = '$no_budget'");              
    }
    
    function approved_propose_budget_gm($proposed, $no_propose, $no_budget) {
        $tabel_master = "CPL.TT_DETAIL_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);
        $this->db->where('CHR_NO_BUDGET', $no_budget);
        $this->db->update($tabel_master, $proposed);              
    }
    
    function approved_propose_budget_bod($proposed, $no_propose, $no_budget) {
        $tabel_master = "CPL.TT_DETAIL_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);
        $this->db->where('CHR_NO_BUDGET', $no_budget);
        $this->db->update($tabel_master, $proposed);              
    }
    
    function update_master_budget($update_master, $no_budget, $budget_type, $year_prop, $fis_start) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $tabel_master = "BDGT_TM_BUDGET_CAPEX";
            $bgt_aii->where('CHR_NO_BUDGET', $no_budget);
            $bgt_aii->where('CHR_TAHUN_BUDGET', $fis_start);
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
    
    function update_header_propose($header, $no_propose){
        $tabel_master = "CPL.TT_HEADER_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);        
        $this->db->update($tabel_master, $header);    
    }
    
    // --------------- GET DETAIL PROPOSE ------------------------------------//
    function get_propose_capex($no_propose){
        $prop_capex = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'CAPEX'")->result();
        return $prop_capex;
    }
    
    function get_propose_repma($no_propose){
        $prop_repma = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'REPMA'")->result();
        return $prop_repma;
    }
    
    function get_propose_right($no_propose){
        $prop_right = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'RIGHT'")->result();
        return $prop_right;
    }
    
    function get_propose_tooeq($no_propose){
        $prop_tooeq = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'TOOEQ'")->result();
        return $prop_tooeq;
    }
    
    function get_propose_offeq($no_propose){
        $prop_offeq = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'OFFEQ'")->result();
        return $prop_offeq;
    }
    
    function get_propose_trial($no_propose){
        $prop_trial = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'TRIAL'")->result();
        return $prop_trial;
    }
    
    function get_propose_empwa($no_propose){
        $prop_empwa = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'EMPWA'")->result();
        return $prop_empwa;
    }
    
    function get_propose_engfe($no_propose){
        $prop_engfe = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'ENGFE'")->result();
        return $prop_engfe;
    }
    
    function get_propose_itexp($no_propose){
        $prop_itexp = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'ITEXP'")->result();
        return $prop_itexp;
    }
    
    function get_propose_renta($no_propose){
        $prop_renta = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'RENTA'")->result();
        return $prop_renta;
    }
    
    function get_propose_rndev($no_propose){
        $prop_rndev = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'RNDEV'")->result();
        return $prop_rndev;
    }
    
    function get_propose_donat($no_propose){
        $prop_donat = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'DONAT'")->result();
        return $prop_donat;
    }
    
    function get_propose_enter($no_propose){
        $prop_enter = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose' AND CHR_BUDGET_TYPE = 'ENTER'")->result();
        return $prop_enter;
    }
    //--------------------- END DETAIL OF PROPOSE ----------------------------//
    
    //--------------------- DETAIL PROPOSE BY GM -----------------------------//
    function get_propose_capex_gm($no_propose){
        $prop_capex = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'CAPEX'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_capex;
    }
    
    function get_propose_repma_gm($no_propose){
        $prop_repma = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'REPMA'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_repma;
    }
    
    function get_propose_right_gm($no_propose){
        $prop_right = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RIGHT'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_right;
    }
    
    function get_propose_tooeq_gm($no_propose){
        $prop_tooeq = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'TOOEQ'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_tooeq;
    }
    
    function get_propose_offeq_gm($no_propose){
        $prop_offeq = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'OFFEQ'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_offeq;
    }
    
    function get_propose_trial_gm($no_propose){
        $prop_trial = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'TRIAL'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_trial;
    }
    
    function get_propose_empwa_gm($no_propose){
        $prop_empwa = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'EMPWA'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_empwa;
    }
    
    function get_propose_engfe_gm($no_propose){
        $prop_engfe = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ENGFE'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_engfe;
    }
    
    function get_propose_itexp_gm($no_propose){
        $prop_itexp = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ITEXP'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_itexp;
    }
    
    function get_propose_renta_gm($no_propose){
        $prop_renta = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RENTA'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_renta;
    }
    
    function get_propose_rndev_gm($no_propose){
        $prop_rndev = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RNDEV'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_rndev;
    }
    
    function get_propose_donat_gm($no_propose){
        $prop_donat = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'DONAT'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_donat;
    }
    
    function get_propose_enter_gm($no_propose){
        $prop_enter = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ENTER'
                                            AND CHR_FLG_PROPOSED >= 1
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_enter;
    }
    //--------------------- END DETAIL PROPOSE BY GM -------------------------//
    
    //--------------------- DETAIL PROPOSE BY BOD -----------------------------//
    function get_propose_capex_bod($no_propose){
        $prop_capex = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'CAPEX'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_capex;
    }
    
    function get_propose_repma_bod($no_propose){
        $prop_repma = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'REPMA'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_repma;
    }
    
    function get_propose_right_bod($no_propose){
        $prop_right = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RIGHT'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_right;
    }
    
    function get_propose_tooeq_bod($no_propose){
        $prop_tooeq = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'TOOEQ'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_tooeq;
    }
    
    function get_propose_offeq_bod($no_propose){
        $prop_offeq = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'OFFEQ'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_offeq;
    }
    
    function get_propose_trial_bod($no_propose){
        $prop_trial = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'TRIAL'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_trial;
    }
    
    function get_propose_empwa_bod($no_propose){
        $prop_empwa = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'EMPWA'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_empwa;
    }
    
    function get_propose_engfe_bod($no_propose){
        $prop_engfe = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ENGFE'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_engfe;
    }
    
    function get_propose_itexp_bod($no_propose){
        $prop_itexp = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ITEXP'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_itexp;
    }
    
    function get_propose_renta_bod($no_propose){
        $prop_renta = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RENTA'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_renta;
    }
    
    function get_propose_rndev_bod($no_propose){
        $prop_rndev = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'RNDEV'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_rndev;
    }
    
    function get_propose_donat_bod($no_propose){
        $prop_donat = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'DONAT'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_donat;
    }
    
    function get_propose_enter_bod($no_propose){
        $prop_enter = $this->db->query("SELECT * FROM CPL.TT_DETAIL_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'
                                            AND CHR_BUDGET_TYPE = 'ENTER'
                                            AND CHR_FLG_PROPOSED >='1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_DELETE <> '1'")->result();
        return $prop_enter;
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
        $tabel_master = "CPL.TT_DETAIL_PROPOSE_BUDGET";
        $this->db->insert($tabel_master, $proposed_unb);      
    }
    
    function check_switch($no_propose){
        $switch = $this->db->query("SELECT CHR_FLG_SWITCH 
                                        FROM CPL.TT_HEADER_PROPOSE_BUDGET
                                        WHERE CHR_NO_PROPOSE = '$no_propose'")->row();
        return $switch;
    }
    
    function delete_list_propose_budget($del_list_proposed, $no_propose){
        $tabel_master = "CPL.TT_DETAIL_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);        
        $this->db->update($tabel_master, $del_list_proposed);
    }
    
    function delete_propose_budget($del_proposed, $no_propose){
        $tabel_master = "CPL.TT_HEADER_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);        
        $this->db->update($tabel_master, $del_proposed);
    }
    
    function cancel_list_propose_budget($cancel_list_proposed, $no_propose){
        $tabel_master = "CPL.TT_DETAIL_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);        
        $this->db->update($tabel_master, $cancel_list_proposed);
    }
    
    function cancel_propose_budget($cancel_proposed, $no_propose){
        $tabel_master = "CPL.TT_HEADER_PROPOSE_BUDGET";
        $this->db->where('CHR_NO_PROPOSE', $no_propose);        
        $this->db->update($tabel_master, $cancel_proposed);
    }
    
    //--------------------- END OF PROPOSE BUDGET ----------------------------//
    
}

?>
