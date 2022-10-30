<?php

class report_budget_m extends CI_Model {

    private $table = 'BDGT_TM_BUDGET_CAPEX';

    function get_user_dept($id_dept){
        $kode_dept_ais = $this->db->query("SELECT CHR_DEPT
                                           FROM TM_DEPT
                                           WHERE INT_ID_DEPT = '$id_dept'")->row();
        
        return $kode_dept_ais;
    }
    
    function get_user_sect($id_sect){
        $kode_sect_ais = $this->db->query("SELECT CHR_SECTION
                                           FROM TM_SECTION
                                           WHERE INT_ID_SECTION = '$id_sect'")->row();
        
        return $kode_sect_ais;
    }
    
    function get_budget_type(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_type = $bgt_aii->query("SELECT CHR_BUDGET_TYPE, 
                                            CHR_BUDGET_TYPE_DESC
                                     FROM BDGT_TM_BUDGET_TYPE 
                                     WHERE CHR_FLG_DELETE <> 1")->result();
        return $bgt_type;
    }

    function get_budget_type_expense(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_type = $bgt_aii->query("SELECT CHR_BUDGET_TYPE, 
                                            CHR_BUDGET_TYPE_DESC
                                     FROM BDGT_TM_BUDGET_TYPE 
                                     WHERE CHR_BUDGET_TYPE NOT IN ('CAPEX','CONSU','EMPWA') AND CHR_FLG_DELETE <> 1")->result();
        return $bgt_type;
    }

    function get_all_group(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_group = $bgt_aii->query("SELECT DISTINCT CHR_KODE_GROUP, CASE WHEN CHR_KODE_GROUP = '001' THEN 'PRODUCTION' WHEN CHR_KODE_GROUP = '003' THEN 'SUPPORTING' WHEN CHR_KODE_GROUP = '004' THEN 'PPIC' END AS CHR_GROUP_DESC
                                    FROM BDGT_TM_DEPARTMENT")->result();
        return $all_group;
    }
    
    function get_all_dept(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT")->result();
        return $all_dept;
    }
    
    function get_all_sect($year, $bgt_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($bgt_type == 'CAPEX'){
            $all_sect = $bgt_aii->query("SELECT DISTINCT CHR_KODE_SECTION
                                        FROM BDGT_TM_BUDGET_CAPEX
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                        AND CHR_TAHUN_BUDGET = '$year'")->result();
            return $all_sect;
        } else {
            $all_sect = $bgt_aii->query("SELECT DISTINCT CHR_KODE_SECTION
                                        FROM BDGT_TM_BUDGET_EXPENSE
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                        AND CHR_TAHUN_BUDGET = '$year'")->result();
            return $all_sect;
        }
    }
    
    function get_group_dept($kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $group_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT
                                    WHERE CHR_KODE_GROUP = '$kode_group'")->result();
        return $group_dept;
    }

    function get_group_dept_new($kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $group_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT
                                    WHERE CHR_KODE_GROUP = '$kode_group' AND CHR_KODE_DEPARTMENT NOT IN ('QCO','QSY')")->result();
        return $group_dept;
    }
    
    //---------------------- REPORT BUDGET DETAIL ----------------------------//
    function get_report_budget($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_CANCEL, CHR_FLG_APPROVAL_PROCESS, CHR_FLG_CIP, CHR_FLG_USED,
                                                     SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                     SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                     SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                     SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                     SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15,
                                                     SUM(LBLN01) AS LBLN01,SUM(LBLN02) AS LBLN02,SUM(LBLN03) AS LBLN03,
                                                     SUM(LBLN04) AS LBLN04,SUM(LBLN05) AS LBLN05,SUM(LBLN06) AS LBLN06,
                                                     SUM(LBLN07) AS LBLN07,SUM(LBLN08) AS LBLN08,SUM(LBLN09) AS LBLN09,
                                                     SUM(LBLN10) AS LBLN10,SUM(LBLN11) AS LBLN11,SUM(LBLN12) AS LBLN12,
                                                     SUM(LBLN13) AS LBLN13,SUM(LBLN14) AS LBLN14,SUM(LBLN15) AS LBLN15,
                                                     SUM(OBLN01) AS OBLN01,SUM(OBLN02) AS OBLN02,SUM(OBLN03) AS OBLN03,
                                                     SUM(OBLN04) AS OBLN04,SUM(OBLN05) AS OBLN05,SUM(OBLN06) AS OBLN06,
                                                     SUM(OBLN07) AS OBLN07,SUM(OBLN08) AS OBLN08,SUM(OBLN09) AS OBLN09,
                                                     SUM(OBLN10) AS OBLN10,SUM(OBLN11) AS OBLN11,SUM(OBLN12) AS OBLN12,
                                                     SUM(OBLN13) AS OBLN13,SUM(OBLN14) AS OBLN14,SUM(OBLN15) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_CANCEL, CHR_FLG_APPROVAL_PROCESS, CHR_FLG_CIP, CHR_FLG_USED,
                                                       0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                       0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                       0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_CANCEL, CHR_FLG_APPROVAL_PROCESS, CHR_FLG_USED, CHR_FLG_CIP) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_CANCEL, CHR_FLG_APPROVAL_PROCESS, CHR_FLG_USED, CHR_FLG_CIP")->result();
            return $budget_detail;
        } else if ($bgt_type == 'CONSU'){
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, 
                                                     BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, BDGT_CURR_YEAR.CHR_DESC_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET, BDGT_CURR_YEAR.CHR_FLG_CANCEL, BDGT_CURR_YEAR.CHR_FLG_APPROVAL_PROCESS,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_CANCEL, CHR_FLG_APPROVAL_PROCESS,
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
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_BUDGET, BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET, BDGT_CURR_YEAR.CHR_FLG_CANCEL, BDGT_CURR_YEAR.CHR_FLG_APPROVAL_PROCESS")->result();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, 
                                                     BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, BDGT_CURR_YEAR.CHR_DESC_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET, BDGT_CURR_YEAR.CHR_FLG_CANCEL, BDGT_CURR_YEAR.CHR_FLG_APPROVAL_PROCESS,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET, CHR_FLG_CANCEL, CHR_FLG_APPROVAL_PROCESS,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_BUDGET, BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET, BDGT_CURR_YEAR.CHR_FLG_CANCEL, BDGT_CURR_YEAR.CHR_FLG_APPROVAL_PROCESS")->result();
            return $budget_detail;
        }
        
    }
    
    function get_report_budget_per_group($fiscal_start, $fiscal_end, $bgt_type, $kode_group) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CASE WHEN CHR_KODE_GROUP = '001' THEN 'PRODUCTION' WHEN CHR_KODE_GROUP = '003' THEN 'SUPPORTING' WHEN CHR_KODE_GROUP = '004' THEN 'PPIC' END AS CHR_KODE_GROUP, CHR_KODE_TYPE_BUDGET,
                                                     SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                     SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                     SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                     SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                     SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15,
                                                     SUM(LBLN01) AS LBLN01,SUM(LBLN02) AS LBLN02,SUM(LBLN03) AS LBLN03,
                                                     SUM(LBLN04) AS LBLN04,SUM(LBLN05) AS LBLN05,SUM(LBLN06) AS LBLN06,
                                                     SUM(LBLN07) AS LBLN07,SUM(LBLN08) AS LBLN08,SUM(LBLN09) AS LBLN09,
                                                     SUM(LBLN10) AS LBLN10,SUM(LBLN11) AS LBLN11,SUM(LBLN12) AS LBLN12,
                                                     SUM(LBLN13) AS LBLN13,SUM(LBLN14) AS LBLN14,SUM(LBLN15) AS LBLN15,
                                                     SUM(OBLN01) AS OBLN01,SUM(OBLN02) AS OBLN02,SUM(OBLN03) AS OBLN03,
                                                     SUM(OBLN04) AS OBLN04,SUM(OBLN05) AS OBLN05,SUM(OBLN06) AS OBLN06,
                                                     SUM(OBLN07) AS OBLN07,SUM(OBLN08) AS OBLN08,SUM(OBLN09) AS OBLN09,
                                                     SUM(OBLN10) AS OBLN10,SUM(OBLN11) AS OBLN11,SUM(OBLN12) AS OBLN12,
                                                     SUM(OBLN13) AS OBLN13,SUM(OBLN14) AS OBLN14,SUM(OBLN15) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                       0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                       0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                       0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                      AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                      AND CHR_FLG_DELETE = '0'  
                                                      AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_KODE_GROUP, CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else if($bgt_type == 'ALL'){
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, CASE WHEN BDGT_CURR_YEAR.CHR_KODE_GROUP = '001' THEN 'PRODUCTION' WHEN BDGT_CURR_YEAR.CHR_KODE_GROUP = '003' THEN 'SUPPORTING' WHEN CHR_KODE_GROUP = '004' THEN 'PPIC' END AS CHR_KODE_GROUP, 'EXPENSE' AS CHR_KODE_TYPE_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                                                     AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_GROUP")->result();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, CASE WHEN BDGT_CURR_YEAR.CHR_KODE_GROUP = '001' THEN 'PRODUCTION' WHEN BDGT_CURR_YEAR.CHR_KODE_GROUP = '003' THEN 'SUPPORTING' WHEN CHR_KODE_GROUP = '004' THEN 'PPIC' END AS CHR_KODE_GROUP, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                                                AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_GROUP, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        }
        
    }
    
    function get_report_budget_per_dept($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $kode_dept) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET,
                                                        SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                        SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                        SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                        SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                        SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15,
                                                        SUM(LBLN01) AS LBLN01,SUM(LBLN02) AS LBLN02,SUM(LBLN03) AS LBLN03,
                                                        SUM(LBLN04) AS LBLN04,SUM(LBLN05) AS LBLN05,SUM(LBLN06) AS LBLN06,
                                                        SUM(LBLN07) AS LBLN07,SUM(LBLN08) AS LBLN08,SUM(LBLN09) AS LBLN09,
                                                        SUM(LBLN10) AS LBLN10,SUM(LBLN11) AS LBLN11,SUM(LBLN12) AS LBLN12,
                                                        SUM(LBLN13) AS LBLN13,SUM(LBLN14) AS LBLN14,SUM(LBLN15) AS LBLN15,
                                                        SUM(OBLN01) AS OBLN01,SUM(OBLN02) AS OBLN02,SUM(OBLN03) AS OBLN03,
                                                        SUM(OBLN04) AS OBLN04,SUM(OBLN05) AS OBLN05,SUM(OBLN06) AS OBLN06,
                                                        SUM(OBLN07) AS OBLN07,SUM(OBLN08) AS OBLN08,SUM(OBLN09) AS OBLN09,
                                                        SUM(OBLN10) AS OBLN10,SUM(OBLN11) AS OBLN11,SUM(OBLN12) AS OBLN12,
                                                        SUM(OBLN13) AS OBLN13,SUM(OBLN14) AS OBLN14,SUM(OBLN15) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                        0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                        0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                        0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                        ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                        ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                        ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                        ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start'  
                                                        AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                        AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                        AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                        AND CHR_FLG_DELETE = '0'  
                                                        AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else if($bgt_type == 'ALL'){
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, 'EXPENSE' AS CHR_KODE_TYPE_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_GROUP LIKE '$kode_group%' 
                                                                     AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                                AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT")->result();
            return $budget_detail;            
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_GROUP LIKE '$kode_group%' 
                                                                     AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                                AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        }
        
    }
    
    function get_report_budget_per_sect($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET,
                                                        SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                        SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                        SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                        SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                        SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15,
                                                        SUM(LBLN01) AS LBLN01,SUM(LBLN02) AS LBLN02,SUM(LBLN03) AS LBLN03,
                                                        SUM(LBLN04) AS LBLN04,SUM(LBLN05) AS LBLN05,SUM(LBLN06) AS LBLN06,
                                                        SUM(LBLN07) AS LBLN07,SUM(LBLN08) AS LBLN08,SUM(LBLN09) AS LBLN09,
                                                        SUM(LBLN10) AS LBLN10,SUM(LBLN11) AS LBLN11,SUM(LBLN12) AS LBLN12,
                                                        SUM(LBLN13) AS LBLN13,SUM(LBLN14) AS LBLN14,SUM(LBLN15) AS LBLN15,
                                                        SUM(OBLN01) AS OBLN01,SUM(OBLN02) AS OBLN02,SUM(OBLN03) AS OBLN03,
                                                        SUM(OBLN04) AS OBLN04,SUM(OBLN05) AS OBLN05,SUM(OBLN06) AS OBLN06,
                                                        SUM(OBLN07) AS OBLN07,SUM(OBLN08) AS OBLN08,SUM(OBLN09) AS OBLN09,
                                                        SUM(OBLN10) AS OBLN10,SUM(OBLN11) AS OBLN11,SUM(OBLN12) AS OBLN12,
                                                        SUM(OBLN13) AS OBLN13,SUM(OBLN14) AS OBLN14,SUM(OBLN15) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                        0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                        0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                        0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                        ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                        ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                        ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                        ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                        AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                        AND CHR_KODE_SECTION LIKE '$kode_sect%' 
                                                        AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_CANCEL = '0'  
                                                        AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else if($bgt_type == 'ALL'){
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, 'EXPENSE' AS CHR_KODE_TYPE_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION")->result();
            return $budget_detail;
        } else if($bgt_type == 'CONSU') {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        }
        
    }
    
    //--------------------- REPORT BUDGET SUMMARY CHART ----------------------//
    function get_report_budget_man($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION,   
                                                        SUM(PBLN01 + PBLN02 + PBLN03 + PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN13 + PBLN14 + PBLN15 ) AS TOT_PLAN,
                                                        SUM(RBLN01 + RBLN02 + RBLN03 + RBLN04 + RBLN05 + RBLN06 + RBLN07 + RBLN08 + RBLN09 + RBLN10 + RBLN11 + RBLN12 + RBLN13 + RBLN14 + RBLN15 ) AS TOT_REV,
                                                        SUM(LBLN01 + LBLN02 + LBLN03 + LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN13 + LBLN14 + LBLN15 ) AS TOT_LIMIT,
                                                        SUM(OBLN01 + OBLN02 + OBLN03 + OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN13 + OBLN14 + OBLN15 ) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                        0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                        0 AS RBLN01,0 AS RBLN02,0 AS RBLN03,
                                                        ISNULL(SUM(MON_REV01BLN04),0) AS RBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS RBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS RBLN06,
                                                        ISNULL(SUM(MON_REV01BLN07),0) AS RBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS RBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS RBLN09,
                                                        ISNULL(SUM(MON_REV01BLN10),0) AS RBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS RBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS RBLN12,
                                                        ISNULL(SUM(MON_REV01BLN01),0) AS RBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS RBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS RBLN15,
                                                        0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                        0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                        ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                        ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                        ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                        ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                        AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                        AND CHR_FLG_DELETE = '0'  
                                                        AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else if($bgt_type == 'ALL'){
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, 'EXPENSE' AS CHR_KODE_TYPE_BUDGET, 
                                                       ISNULL(SUM(MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15),0) AS TOT_PLAN,
                                                       ISNULL(SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15),0) AS TOT_LIMIT,
                                                       ISNULL(SUM(MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15),0) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION")->result();
            return $budget_detail;            
        } else if($bgt_type == 'CONSU') {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                       ISNULL(SUM(MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15),0) AS TOT_PLAN,
                                                       ISNULL(SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15),0) AS TOT_LIMIT,
                                                       ISNULL(SUM(MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15),0) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET,
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
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                       ISNULL(SUM(MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15),0) AS TOT_PLAN,
                                                       ISNULL(SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15),0) AS TOT_LIMIT,
                                                       ISNULL(SUM(MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15),0) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_SECTION, CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_SECTION, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        }
        
    }
    
    function get_report_budget_gm($fiscal_start, $fiscal_end, $bgt_type, $kode_group, $kode_dept) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET,   
                                                        SUM(PBLN01 + PBLN02 + PBLN03 + PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN13 + PBLN14 + PBLN15 ) AS TOT_PLAN,
                                                        SUM(LBLN01 + LBLN02 + LBLN03 + LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN13 + LBLN14 + LBLN15 ) AS TOT_LIMIT,
                                                        SUM(OBLN01 + OBLN02 + OBLN03 + OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN13 + OBLN14 + OBLN15 ) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                        0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                        0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                        0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                        ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                        ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                        ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                        ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                        AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                        AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                        AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                        AND CHR_FLG_DELETE = '0'  
                                                        AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else if($bgt_type == 'ALL'){
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_GROUP, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, 'EXPENSE' AS CHR_KODE_TYPE_BUDGET, 
                                                       ISNULL(SUM(MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15),0) AS TOT_PLAN,
                                                       ISNULL(SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15),0) AS TOT_LIMIT,
                                                       ISNULL(SUM(MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15),0) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_GROUP LIKE '$kode_group%' 
                                                                     AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                                AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_GROUP, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT")->result();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_GROUP, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                       ISNULL(SUM(MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15),0) AS TOT_PLAN,
                                                       ISNULL(SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15),0) AS TOT_LIMIT,
                                                       ISNULL(SUM(MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15),0) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_GROUP LIKE '$kode_group%' 
                                                                     AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                                AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_GROUP, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        }
        
    }
    
    function get_report_budget_bod($fiscal_start, $fiscal_end, $bgt_type, $kode_div, $kode_group) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_KODE_DIVISI, CASE WHEN CHR_KODE_GROUP = '001' THEN 'PRODUCTION' WHEN CHR_KODE_GROUP = '003' THEN 'SUPPORTING' WHEN CHR_KODE_GROUP = '004' THEN 'PPIC' END AS CHR_KODE_GROUP, CHR_KODE_TYPE_BUDGET,   
                                                        SUM(PBLN01 + PBLN02 + PBLN03 + PBLN04 + PBLN05 + PBLN06 + PBLN07 + PBLN08 + PBLN09 + PBLN10 + PBLN11 + PBLN12 + PBLN13 + PBLN14 + PBLN15 ) AS TOT_PLAN,
                                                        SUM(LBLN01 + LBLN02 + LBLN03 + LBLN04 + LBLN05 + LBLN06 + LBLN07 + LBLN08 + LBLN09 + LBLN10 + LBLN11 + LBLN12 + LBLN13 + LBLN14 + LBLN15 ) AS TOT_LIMIT,
                                                        SUM(OBLN01 + OBLN02 + OBLN03 + OBLN04 + OBLN05 + OBLN06 + OBLN07 + OBLN08 + OBLN09 + OBLN10 + OBLN11 + OBLN12 + OBLN13 + OBLN14 + OBLN15 ) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DIVISI, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                        0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                        0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                        0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                        ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                        ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                        ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                        ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                        AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                                        AND CHR_KODE_DIVISI = '$kode_div'                                                       
                                                        AND CHR_KODE_GROUP LIKE '$kode_group%'
                                                        AND CHR_FLG_DELETE = '0'  
                                                        AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DIVISI, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                        CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_KODE_DIVISI, CHR_KODE_GROUP, CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else if($bgt_type == 'ALL'){
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DIVISI, CASE WHEN BDGT_CURR_YEAR.CHR_KODE_GROUP = '001' THEN 'PRODUCTION' WHEN BDGT_CURR_YEAR.CHR_KODE_GROUP = '003' THEN 'SUPPORTING' WHEN CHR_KODE_GROUP = '004' THEN 'PPIC' END AS CHR_KODE_GROUP, 'EXPENSE' AS CHR_KODE_TYPE_BUDGET, 
                                                       ISNULL(SUM(MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15),0) AS TOT_PLAN,
                                                       ISNULL(SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15),0) AS TOT_LIMIT,
                                                       ISNULL(SUM(MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15),0) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_KODE_DIVISI, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                                                     AND CHR_KODE_DIVISI = '$kode_div'
                                                                     AND CHR_KODE_GROUP LIKE '$kode_group%'                                                                      
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end'
                                                                AND CHR_KODE_DIVISI = '$kode_div' 
                                                                AND CHR_KODE_GROUP LIKE '$kode_group%'                                                                 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DIVISI, BDGT_CURR_YEAR.CHR_KODE_GROUP")->result();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DIVISI, CASE WHEN BDGT_CURR_YEAR.CHR_KODE_GROUP = '001' THEN 'PRODUCTION' WHEN BDGT_CURR_YEAR.CHR_KODE_GROUP = '003' THEN 'SUPPORTING' WHEN CHR_KODE_GROUP = '004' THEN 'PPIC' END AS CHR_KODE_GROUP, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                       ISNULL(SUM(MON_BLN01 + MON_BLN02 + MON_BLN03 + MON_BLN04 + MON_BLN05 + MON_BLN06 + MON_BLN07 + MON_BLN08 + MON_BLN09 + MON_BLN10 + MON_BLN11 + MON_BLN12 + MON_BLN13 + MON_BLN14 + MON_BLN15),0) AS TOT_PLAN,
                                                       ISNULL(SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 + MON_LIMBLN13 + MON_LIMBLN14 + MON_LIMBLN15),0) AS TOT_LIMIT,
                                                       ISNULL(SUM(MON_OPRBLN01 + MON_OPRBLN02 + MON_OPRBLN03 + MON_OPRBLN04 + MON_OPRBLN05 + MON_OPRBLN06 + MON_OPRBLN07 + MON_OPRBLN08 + MON_OPRBLN09 + MON_OPRBLN10 + MON_OPRBLN11 + MON_OPRBLN12 + MON_OPRBLN13 + MON_OPRBLN14 + MON_OPRBLN15),0) AS TOT_ACTUAL
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_KODE_DIVISI, CHR_KODE_GROUP, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, CHR_NO_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                                                     AND CHR_KODE_DIVISI = '$kode_div'
                                                                     AND CHR_KODE_GROUP LIKE '$kode_group%'                                                                      
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                                                AND CHR_KODE_DIVISI = '$kode_div' 
                                                                AND CHR_KODE_GROUP LIKE '$kode_group%'                                                                 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DIVISI, BDGT_CURR_YEAR.CHR_KODE_GROUP, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        }
        
    }
    //--------------------- END REPORT BUDGET --------------------------------//
    
    function get_summary_budget_type($fiscal_start, $fiscal_end, $kode_dept, $bgt_type) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, 
                                                    SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                    SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                    SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                    SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                    SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15,
                                                    SUM(LBLN01) AS LBLN01,SUM(LBLN02) AS LBLN02,SUM(LBLN03) AS LBLN03,
                                                    SUM(LBLN04) AS LBLN04,SUM(LBLN05) AS LBLN05,SUM(LBLN06) AS LBLN06,
                                                    SUM(LBLN07) AS LBLN07,SUM(LBLN08) AS LBLN08,SUM(LBLN09) AS LBLN09,
                                                    SUM(LBLN10) AS LBLN10,SUM(LBLN11) AS LBLN11,SUM(LBLN12) AS LBLN12,
                                                    SUM(LBLN13) AS LBLN13,SUM(LBLN14) AS LBLN14,SUM(LBLN15) AS LBLN15,
                                                    SUM(OBLN01) AS OBLN01,SUM(OBLN02) AS OBLN02,SUM(OBLN03) AS OBLN03,
                                                    SUM(OBLN04) AS OBLN04,SUM(OBLN05) AS OBLN05,SUM(OBLN06) AS OBLN06,
                                                    SUM(OBLN07) AS OBLN07,SUM(OBLN08) AS OBLN08,SUM(OBLN09) AS OBLN09,
                                                    SUM(OBLN10) AS OBLN10,SUM(OBLN11) AS OBLN11,SUM(OBLN12) AS OBLN12,
                                                    SUM(OBLN13) AS OBLN13,SUM(OBLN14) AS OBLN14,SUM(OBLN15) AS OBLN15
                                        FROM (SELECT CHR_KODE_TYPE_BUDGET,                                                        
                                                    0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                    ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                    ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                    ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                    ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                    0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                    ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                    ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                    ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                    ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                    0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                    ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                    ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                    ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                    ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                            FROM BDGT_TM_BUDGET_CAPEX 
                                            WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                    AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                    AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                    AND CHR_FLG_DELETE = '0'  
                                                    AND CHR_FLG_FOR_AIIA = '0'
                                            GROUP BY CHR_KODE_TYPE_BUDGET) AS BDGT_TM_BUDGET_CAPEX
                                            GROUP BY CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_NO_BUDGET, CHR_KODE_TYPE_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_DELETE = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,CHR_KODE_TYPE_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_DELETE = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET")->result();
            return $budget_detail;
        }
        
    }
    
    function get_list_pr_header($year_bgt, $bgt_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $usage = $bgt_aii->query("SELECT CHR_KODE_TRANSAKSI, CHR_KODE_DEPARTMENT, CHR_NO_BUDGET, MON_AMOUNT_BUDGET, CHR_FLG_APPROVE_BOD, CHR_FLG_APPROVE_BOD, CHR_DATE_BOD, CHR_FLG_APPROVE_MAN, CHR_DATE_MAN, CHR_FLG_APPROVE_GM, CHR_DATE_GM,
                                    CHR_FLG_ACC, CHR_DATE_ACC, CHR_ASSET_NO, CHR_FLG_VP, CHR_DATE_VP, CHR_FLG_PRESDIR, CHR_DATE_PRESDIR, CHR_FLG_GUDTOOL, CHR_DATE_GUDTOOL, CHR_PR_NO, CHR_FLG_PURC, CHR_DATE_PURC, CHR_PO_NO
                                FROM BDGT_TT_BUDGET_PR_HEADER
                                WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND CHR_FLG_DELETE = '0'
                                        AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                        AND CHR_TAHUN_BUDGET= '$year_bgt'
                                ORDER BY CHR_KODE_TRANSAKSI")->result();
        return $usage;
        
    }
    
    function get_no_budget_by_pr($bgt_type, $no_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($bgt_type == 'CAPEX'){
            $usage = $bgt_aii->query("SELECT TOP 1 A.CHR_NO_BUDGET, B.CHR_DESC_BUDGET, MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12 AS TOT_BUDGET
                                FROM BDGT_TT_BUDGET_PR_DETAIL AS A
                                LEFT JOIN BDGT_TM_BUDGET_CAPEX AS B ON A.CHR_NO_BUDGET = B.CHR_NO_BUDGET
                                WHERE A.CHR_KODE_TRANSAKSI = '$no_transaksi'")->row();
        } else {
            $usage = $bgt_aii->query("SELECT A.CHR_NO_BUDGET, B.CHR_KODE_ITEM AS CHR_DESC_BUDGET, SUM(MON_LIMBLN01 + MON_LIMBLN02 + MON_LIMBLN03 + MON_LIMBLN04 + MON_LIMBLN05 + MON_LIMBLN06 + MON_LIMBLN07 + MON_LIMBLN08 + MON_LIMBLN09 + MON_LIMBLN10 + MON_LIMBLN11 + MON_LIMBLN12) AS TOT_BUDGET
                                FROM BDGT_TT_BUDGET_PR_HEADER AS A
                                LEFT JOIN BDGT_TM_BUDGET_EXPENSE AS B ON A.CHR_NO_BUDGET = B.CHR_NO_BUDGET
                                WHERE A.CHR_KODE_TRANSAKSI = '$no_transaksi'
                                GROUP BY A.CHR_NO_BUDGET, B.CHR_KODE_ITEM")->row();
        }        
        return $usage;
    }
    
    function get_list_pr_detail($no_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $usage = $bgt_aii->query("SELECT A.[CHR_KODE_TRANSAKSI], A.[CHR_TGL_TRANS], B.[CHR_NO_BUDGET],A.[CHR_TGL_TRANS], B.[CHR_TGL_ESTIMASI_KEDATANGAN],
                                        A.[CHR_KODE_DEPARTMENT], A.[CHR_USERID], A.[CHR_FLG_APPROVE_BOD], B.[INT_KODE_ITEM], A.[MON_AMOUNT_BUDGET],
                                        B.[CHR_PURCHASE_PART], B.[INT_QTY], B.[CHR_UNIT], B.[CHR_SUPPLIER_NAME], B.[MON_UNIT_PRICE_SUPPLIER],B.[MON_TOTAL_PRICE_SUPPLIER], B.[CHR_REMARK]
                                FROM [BDGT_TT_BUDGET_PR_HEADER] AS A
                                INNER JOIN [BDGT_TT_BUDGET_PR_DETAIL] AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                WHERE A.[CHR_KODE_TRANSAKSI] = '$no_transaksi'")->result();
        return $usage;
        
    }
    
    function get_usage_budget($year_bgt, $bgt_type, $kode_dept, $kode_sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $usage = $bgt_aii->query("SELECT A.[CHR_KODE_TRANSAKSI], A.[CHR_TGL_TRANS], B.[CHR_NO_BUDGET],A.[CHR_TGL_TRANS], B.[CHR_TGL_ESTIMASI_KEDATANGAN],
                                        A.[CHR_KODE_DEPARTMENT], A.[CHR_USERID], A.[CHR_FLG_APPROVE_BOD], A.[CHR_FLG_APPROVE_MAN], A.[CHR_FLG_APPROVE_GM], A.[CHR_DATE_BOD], A.[CHR_DATE_MAN], A.[CHR_DATE_GM],B.[INT_KODE_ITEM], A.[MON_AMOUNT_BUDGET],
                                        B.[CHR_PURCHASE_PART], B.[INT_QTY], B.[CHR_UNIT], B.[CHR_SUPPLIER_NAME], B.[MON_UNIT_PRICE_SUPPLIER],B.[MON_TOTAL_PRICE_SUPPLIER], B.[CHR_REMARK],
                                        A.[CHR_FLG_ACC], A.[CHR_DATE_ACC], A.[CHR_ASSET_NO], A.[CHR_FLG_VP], A.[CHR_DATE_VP], A.[CHR_FLG_PRESDIR], A.[CHR_DATE_PRESDIR],
                                        A.[CHR_FLG_GUDTOOL], A.[CHR_DATE_GUDTOOL], A.[CHR_PR_NO], A.[CHR_FLG_PURC], A.[CHR_DATE_PURC], A.[CHR_PO_NO],
                                        A.[CHR_DATE_MAN_IN], A.[CHR_DATE_GM_IN], A.[CHR_DATE_BOD_IN], A.[CHR_DATE_ACC_IN], A.[CHR_DATE_VP_IN], A.[CHR_DATE_PRESDIR_IN], A.[CHR_DATE_GUDTOOL_IN], A.[CHR_DATE_PURC_IN]
                                FROM [BDGT_TT_BUDGET_PR_HEADER] AS A
                                INNER JOIN [BDGT_TT_BUDGET_PR_DETAIL] AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                WHERE A.[CHR_KODE_DEPARTMENT] = '$kode_dept'
                                        AND SUBSTRING(B.CHR_NO_BUDGET, 7, 7) LIKE '$kode_sect%'
                                        --AND CHR_FLG_DELETE = '0'
                                        AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                        AND CHR_TAHUN_BUDGET= '$year_bgt'
                                ORDER BY A.CHR_KODE_TRANSAKSI, B.INT_KODE_ITEM")->result();
        return $usage;
        
    }
    
    function cek_status_gr($bgt_type, $no_trans, $part){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $gr = $bgt_aii->query("SELECT CHR_NO_BUDGET, BUDAT 
                                FROM BDGT_TT_REPORT_CAPEX 
                                WHERE (BEDNR LIKE '%$no_trans%') AND (TXZ01 LIKE '%$part%')")->row();
            return $gr;            
        } else {
            $gr = $bgt_aii->query("SELECT CHR_NO_BUDGET, BUDAT 
                                FROM BDGT_TT_REPORT_EXPENSES 
                                WHERE (BEDNR LIKE '%$no_trans%')")->row(); //AND (TXZ01 LIKE '%$part%')                                
            return $gr;
        }
    }
    
    //------------------- END ------------------------//
    
    //get data by section to report ,,,can....
    function get_capex_plan_by_section($section, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR,c.INT_ID_DEPT,
            c.CHR_SECTION,c.CHR_SECTION_DESC,d.CHR_BUDGET_SUB_CATEGORY_DESC, e.CHR_PURPOSE_DESC,d.INT_ID_BUDGET_CATEGORY,f.CHR_BUDGET_CATEGORY_DESC,
            CASE h.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, 
            CASE h.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE h.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL,
            CASE h.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW,
            LEFT(h.CHR_DEPCI_DATE,4) as tahun,
            CASE RIGHT(h.CHR_DEPCI_DATE,2) 
            WHEN '01' THEN 'Jan' 
            WHEN '02' THEN 'Feb' 
            WHEN '03' THEN 'Mar' 
            WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' 
            WHEN '06' THEN 'Jun' 
            WHEN '07' THEN 'Jul' 
            WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' 
            WHEN '10' THEN 'Oct'
            WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END +'-'+ LEFT(h.CHR_DEPCI_DATE,4) AS depresiasi,
            a.DEC_TOTAL, g.CHR_DEPT, h.INT_MONTH_PLAN
            from TT_BUDGET a, TT_BUDGET_CAPEX h,TM_FISCAL b, TM_SECTION c, TM_BUDGET_SUB_CATEGORY d, TM_PURPOSE e, TM_BUDGET_CATEGORY f, TM_DEPT g
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_SECTION = c.INT_ID_SECTION and c.INT_ID_DEPT = g.INT_ID_DEPT
            and a.INT_ID_SECTION = '" . $section . "' and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and a.INT_NO_BUDGET_CPX = h.INT_NO_BUDGET_CPX
            and h.INT_ID_PURPOSE=e.INT_ID_PURPOSE and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY and d.INT_ID_BUDGET_CATEGORY=f.INT_ID_BUDGET_CATEGORY and h.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_capex_plan_by_manager($dept, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET,a.INT_NO_BUDGET_CPX, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, f.CHR_PURPOSE_DESC,
            c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY_DESC, k.CHR_BUDGET_CATEGORY,k.CHR_BUDGET_CATEGORY_DESC,
            d.CHR_DEPT_DESC, a.DEC_TOTAL,
            CASE e.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, 
            CASE e.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE e.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL,
            CASE e.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW,
            LEFT(e.CHR_DEPCI_DATE,4) as tahun,
            CASE RIGHT(e.CHR_DEPCI_DATE,2) 
            WHEN '01' THEN 'Jan' 
            WHEN '02' THEN 'Feb' 
            WHEN '03' THEN 'Mar' 
            WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' 
            WHEN '06' THEN 'Jun' 
            WHEN '07' THEN 'Jul' 
            WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' 
            WHEN '10' THEN 'Oct'
            WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END +'-'+ LEFT(e.CHR_DEPCI_DATE,4) AS depresiasi,
            e.INT_MONTH_PLAN
            from TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TT_BUDGET_CAPEX e, TM_PURPOSE f,
                 TM_BUDGET_CATEGORY k,TM_BUDGET_SUB_CATEGORY l
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION
                and c.INT_ID_DEPT = d.INT_ID_DEPT and c.INT_ID_DEPT = '" . $dept . "'
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and a.INT_NO_BUDGET_CPX = e.INT_NO_BUDGET_CPX and e.INT_ID_PURPOSE = f.INT_ID_PURPOSE");
        return $query->result();
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function get_data($no_budget) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, 
            c.CHR_SECTION_DESC, d.CHR_DEPT_DESC, l.CHR_BUDGET_SUB_CATEGORY_DESC,k.CHR_BUDGET_CATEGORY_DESC, g.CHR_PURPOSE_DESC,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, 
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_GROUP_DEPT e, TM_DIVISION f, TM_PURPOSE g,
                 TM_BUDGET_GROUP h,TM_BUDGET_SUBGROUP i,TM_BUDGET_TYPE j,TM_BUDGET_CATEGORY k,TM_BUDGET_SUB_CATEGORY l
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and a.INT_ID_DEPT = d.INT_ID_DEPT
                and a.INT_ID_GROUP_DEPT = e.INT_ID_GROUP_DEPT
                and a.INT_ID_DIVISION = f.INT_ID_DIVISION
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_ID_BUDGET_GROUP = h.INT_ID_BUDGET_GROUP
                and a.INT_ID_BUDGET_SUBGROUP = i.INT_ID_BUDGET_SUBGROUP
                and a.INT_ID_BUDGET_TYPE = j.INT_ID_BUDGET_TYPE
                and a.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and a.BIT_FLG_DEL = 0 and a.INT_NO_BUDGET_CPX = '" . $no_budget . "'");
        return $query;
    }

    function get_data_capex($no_budget) {
        $query = $this->db->query("select a.INT_NO_BUDGET, a.CHR_BUDGET_NAME, a.DEC_TOTAL,b.INT_QUANTITY,
            a.INT_ID_SECTION, a.INT_ID_FISCAL_YEAR, a.DEC_TOTAL - a.DEC_TOTAL * 0.3 as LIMIT
            from TT_BUDGET a,TT_BUDGET_CAPEX b, TM_SECTION c
            where a.INT_ID_SECTION = c.INT_ID_SECTION
                and b.BIT_FLG_DEL = 0 and a.INT_NO_BUDGET_CPX = b.INT_NO_BUDGET_CPX and a.INT_NO_BUDGET_CPX = '" . $no_budget . "'");
        return $query;
    }
    
    function get_total_capex_plan_by_manager($id_dept ,$id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT and
                d.INT_ID_DEPT = '" . $id_dept . "'")->row_array();
        $total_plan = $query['total_plan'];
        return $total_plan;
    }
    
    function get_total_capex_plan_by_gm($id_groupdept ,$id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from 
            TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_GROUP_DEPT e
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and d.INT_ID_GROUP_DEPT = e.INT_ID_GROUP_DEPT and
                e.INT_ID_GROUP_DEPT = '" . $id_groupdept . "'")->row_array();
        $total_plan = $query['total_plan'];
        return $total_plan;
    }
    
    function get_total_capex_plan_by_supervisor($id_section ,$id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from 
            TT_BUDGET a,TM_FISCAL b, TM_SECTION c
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION  and
                c.INT_ID_SECTION = '" . $id_section . "'")->row_array();
        $total = $query['total_plan'];
        return $total;
    }
    
    function get_total_capex_plan_by_dept($id_dept ,$id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from 
            TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION  and
                c.INT_ID_DEPT = d.INT_ID_DEPT  and
                d.INT_ID_DEPT = '" . $id_dept . "'")->row_array();
        $total_plan = $query['total_plan'];
        return $total_plan;
    }
    
    function get_total_capex_plan_by_admin($id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from 
            TT_BUDGET a,TM_FISCAL b
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'")->row_array();
        $total_plan = $query['total_plan'];
        return $total_plan;
    }
    
    function update_capex_plan($data,$id_fiscal){
        $this->db->select('INT_NO_BUDGET_CPX');
        $this->db->from('TT_BUDGET');
        $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
        $query_budget = $this->db->get()->result_array();
        
        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX', $row['INT_NO_BUDGET_CPX']);
            $this->db->update('TT_BUDGET_CAPEX', $data);
        }
    }

    function generated_id() {
        $count_id = $this->db->query("select count(INT_NO_BUDGET_CPX) as 'id' from TT_BUDGET where LEFT(INT_NO_BUDGET_CPX,2) = RIGHT(year(getdate()),2)")->row_array();
        $jumlah = $count_id['id'];
        intval($count_id);
        $jumlah += 1;
        strval($jumlah);

        if (strlen($jumlah) == 1) {
            $id_akhir = '000' . $jumlah;
        } else if (strlen($jumlah) == 2) {
            $id_akhir = '00' . $jumlah;
        } else if (strlen($jumlah) == 3) {
            $id_akhir = '0' . $jumlah;
        } else if (strlen($jumlah) == 4) {
            $id_akhir = $jumlah;
        }

        return $id_akhir;
    }
    
    
    //---------------------- DETAIL PLAN PER MONTH PER DIVISION ----------------------//
    function get_new_budget_detail_bod($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                        SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                        SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                        SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                        SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15 
                                            FROM (SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15 
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$tahun'  
                                                        AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                        AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                        AND CHR_FLG_DELETE = '0'  
                                                        AND CHR_FLG_FOR_AIIA = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_detail;
        } else if($budget_type == 'CONSU') {
            $budget_detail = $bgt_aii->query("SELECT ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,
                                                                    MON_BLN01,MON_BLN02,MON_BLN03,
                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
                                                                    MON_BLN10 AS MON_BLN10,MON_BLN11 AS MON_BLN11,MON_BLN12 AS MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                       WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                                     AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                                     AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                     AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                                AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
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
                                                                    MON_BLN10 AS MON_BLN10,MON_BLN11 AS MON_BLN11,MON_BLN12 AS MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                                     AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                                     AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                     AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                                AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //---------------------- DETAIL PLAN PER MONTH PER GROUP ----------------------//
    function get_new_budget_detail_gm($tahun, $year_start, $year_end, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT SUM(MON_BLN04) AS PBLN04,SUM(MON_BLN05) AS PBLN05,SUM(MON_BLN06) AS PBLN06,
                                                     SUM(MON_BLN07) AS PBLN07,SUM(MON_BLN08) AS PBLN08,SUM(MON_BLN09) AS PBLN09,
                                                     SUM(MON_BLN10) AS PBLN10,SUM(MON_BLN11) AS PBLN11,SUM(MON_BLN12) AS PBLN12,
                                                     SUM(MON_BLN01) AS PBLN13,SUM(MON_BLN02) AS PBLN14,SUM(MON_BLN03) AS PBLN15
                                            FROM  BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                     AND CHR_KODE_GROUP = '$kode_group' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else if ($budget_type == 'CONSU'){
            $budget_detail = $bgt_aii->query("SELECT ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,
                                                                    MON_BLN01,MON_BLN02,MON_BLN03,
                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
                                                                    MON_BLN10 AS MON_BLN10,MON_BLN11 AS MON_BLN11,MON_BLN12 AS MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                       WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                                     AND CHR_KODE_GROUP = '$kode_group' 
                                                                     AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                     AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_GROUP = '$kode_group' 
                                                                AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
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
                                                                    MON_BLN10 AS MON_BLN10,MON_BLN11 AS MON_BLN11,MON_BLN12 AS MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                                     AND CHR_KODE_GROUP = '$kode_group' 
                                                                     AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                     AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_GROUP = '$kode_group' 
                                                                AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //---------------------- DETAIL ACTUAL PR PER MONTH PER GROUP ----------------------//
    function get_new_actual_real_gm($tahun, $year_start, $year_end, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $act_periode = date("Ym");
        $periode_smt2 = $tahun . '10';
        if ($budget_type == 'CAPEX'){
            $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(MON_OPRBLN04_GM),0) AS OPRBLN04, 
                                                 ISNULL(SUM(MON_OPRBLN05_GM),0) AS OPRBLN05, ISNULL(SUM(MON_OPRBLN06_GM),0) AS OPRBLN06, 
                                                 ISNULL(SUM(MON_OPRBLN07_GM),0) AS OPRBLN07, ISNULL(SUM(MON_OPRBLN08_GM),0) AS OPRBLN08, 
                                                 ISNULL(SUM(MON_OPRBLN09_GM),0) AS OPRBLN09, ISNULL(SUM(MON_OPRBLN10_GM),0) AS OPRBLN10, 
                                                 ISNULL(SUM(MON_OPRBLN11_GM),0) AS OPRBLN11, ISNULL(SUM(MON_OPRBLN12_GM),0) AS OPRBLN12,
                                                 ISNULL(SUM(MON_OPRBLN01_GM),0) AS OPRBLN13, ISNULL(SUM(MON_OPRBLN02_GM),0) AS OPRBLN14, 
                                                 ISNULL(SUM(MON_OPRBLN03_GM),0) AS OPRBLN15
                                          FROM  BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_GROUP = '$kode_group'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
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
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_MAN AS OPRBLN13, 
                                                                MON_OPRBLN02_MAN AS OPRBLN14, 
                                                                MON_OPRBLN03_MAN AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_GROUP = '$kode_group'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
        }
    }
    
    //-------------------- DETAIL BUDGET REVISI PER MONTH PER GROUP --------------------//
    function get_new_budget_detail_rev_gm($tahun, $year_start, $year_end, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                         AND CHR_KODE_GROUP = '$kode_group' 
                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                         AND CHR_FLG_DELETE = '0' 
                                         AND CHR_FLG_CANCEL = '0' 
                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else if($budget_type == 'CONSU'){
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_consumable_rev_by_group '$year_start', '$year_end', '$budget_type', '$kode_group', ''")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_group '$year_start', '$year_end', '$budget_type', '$kode_group', ''")->row();
            return $budget_detail;
        }
    }
    
    //------------------------ DETAIL PLAN PER MONTH PER DEPT -----------------------//
    function get_new_budget_detail($tahun, $year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                        SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                        SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                        SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                        SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15 
                                            FROM (SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15 
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                        AND CHR_FLG_DELETE = '0'  
                                                        AND CHR_FLG_UNBUDGET = '0' 
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
                                                                    MON_BLN10 AS MON_BLN10,MON_BLN11 AS MON_BLN11,MON_BLN12 AS MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                     AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                     AND CHR_FLG_REV = '0' 
                                                                     AND CHR_FLG_UNBUDGET = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                AND CHR_FLG_REV = '0'
                                                                AND CHR_FLG_UNBUDGET = '0' ) BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //---------------------- DETAIL PLAN REV PER MONTH PER DEPT ---------------------//
    function get_new_budget_detail_rev($tahun, $year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                         AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                         AND CHR_FLG_DELETE = '0' 
                                         AND CHR_FLG_CANCEL = '0'
                                         AND CHR_FLG_UNBUDGET = '0' 
                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else if ($budget_type == 'CONSU'){
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_consumable_rev_by_dept '$year_start', '$year_end', '$budget_type', '$kode_dept', ''")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_dept '$year_start', '$year_end', '$budget_type', '$kode_dept', ''")->row();
            return $budget_detail;
        }
    }
    
    //---------------------- DETAIL ACTUAL PR PER MONTH PER DEPT ----------------------//
    function get_new_actual_real($tahun, $year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $act_periode = date("Ym");
        $periode_smt2 = $tahun . '10';
        if ($budget_type == 'CAPEX'){
                $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(MON_OPRBLN04_MAN),0) AS OPRBLN04, 
                                                 ISNULL(SUM(MON_OPRBLN05_MAN),0) AS OPRBLN05, ISNULL(SUM(MON_OPRBLN06_MAN),0) AS OPRBLN06, 
                                                 ISNULL(SUM(MON_OPRBLN07_MAN),0) AS OPRBLN07, ISNULL(SUM(MON_OPRBLN08_MAN),0) AS OPRBLN08, 
                                                 ISNULL(SUM(MON_OPRBLN09_MAN),0) AS OPRBLN09, ISNULL(SUM(MON_OPRBLN10_MAN),0) AS OPRBLN10, 
                                                 ISNULL(SUM(MON_OPRBLN11_MAN),0) AS OPRBLN11, ISNULL(SUM(MON_OPRBLN12_MAN),0) AS OPRBLN12,
                                                 ISNULL(SUM(MON_OPRBLN01_MAN),0) AS OPRBLN13, ISNULL(SUM(MON_OPRBLN02_MAN),0) AS OPRBLN14, 
                                                 ISNULL(SUM(MON_OPRBLN03_MAN),0) AS OPRBLN15
                                          FROM  BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
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
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
        }
    }
    
    //------------------------ DETAIL PLAN PER MONTH PER SECT -----------------------//
    function get_new_budget_detail_sect($tahun, $year_start, $year_end, $budget_type, $kode_dept, $kode_sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                    SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                    SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                    SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                    SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15 
                                        FROM (SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                    ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                    ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                    ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                    ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15 
                                            FROM BDGT_TM_BUDGET_CAPEX 
                                            WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                    AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                    AND CHR_KODE_SECTION = '$kode_sect'
                                                    AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                    AND CHR_FLG_DELETE = '0'  
                                                    AND CHR_FLG_UNBUDGET = '0' 
                                                    AND CHR_FLG_FOR_AIIA = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_detail;
        } else if ($budget_type == 'CONSU'){
            $budget_detail = $bgt_aii->query("SELECT ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,
                                                                    MON_BLN01,MON_BLN02,MON_BLN03,
                                                                    MON_BLN04,MON_BLN05,MON_BLN06,
                                                                    MON_BLN07,MON_BLN08,MON_BLN09,
                                                                    MON_BLN10 AS MON_BLN10,MON_BLN11 AS MON_BLN11,MON_BLN12 AS MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                       WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                     AND CHR_KODE_SECTION = '$kode_sect'
                                                                     AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                     AND CHR_FLG_REV = '0' 
                                                                     AND CHR_FLG_UNBUDGET = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                AND CHR_KODE_SECTION = '$kode_sect'
                                                                AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                AND CHR_FLG_REV = '0'
                                                                AND CHR_FLG_UNBUDGET = '0' ) BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
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
                                                                    MON_BLN10 AS MON_BLN10,MON_BLN11 AS MON_BLN11,MON_BLN12 AS MON_BLN12 
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                     AND CHR_KODE_SECTION = '$kode_sect'
                                                                     AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                     AND CHR_FLG_REV = '0' 
                                                                     AND CHR_FLG_UNBUDGET = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                AND CHR_KODE_SECTION = '$kode_sect'
                                                                AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%' 
                                                                AND CHR_FLG_REV = '0'
                                                                AND CHR_FLG_UNBUDGET = '0' ) BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //---------------------- DETAIL PLAN REV PER MONTH PER SECT ---------------------//
    function get_new_budget_detail_rev_sect($tahun, $year_start, $year_end, $budget_type, $kode_dept, $kode_sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                    FROM BDGT_TM_BUDGET_CAPEX 
                                    WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                         AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                         AND CHR_KODE_SECTION = '$kode_sect'
                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                         AND CHR_FLG_DELETE = '0' 
                                         AND CHR_FLG_CANCEL = '0'
                                         AND CHR_FLG_UNBUDGET = '0' 
                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else if ($budget_type == 'CONSU'){
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_consumable_rev_by_sect '$year_start', '$year_end', '$budget_type', '$kode_dept', ''")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_sect '$year_start', '$year_end', '$budget_type', '$kode_dept', ''")->row();
            return $budget_detail;
        }
    }
    
    //---------------------- DETAIL ACTUAL PR PER MONTH PER SECT ----------------------//
    function get_new_actual_real_sect($tahun, $year_start, $year_end, $budget_type, $kode_dept, $kode_sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $act_periode = date("Ym");
        $periode_smt2 = $tahun . '10';
        if ($budget_type == 'CAPEX'){
                $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(MON_OPRBLN04_MAN),0) AS OPRBLN04, 
                                                 ISNULL(SUM(MON_OPRBLN05_MAN),0) AS OPRBLN05, ISNULL(SUM(MON_OPRBLN06_MAN),0) AS OPRBLN06, 
                                                 ISNULL(SUM(MON_OPRBLN07_MAN),0) AS OPRBLN07, ISNULL(SUM(MON_OPRBLN08_MAN),0) AS OPRBLN08, 
                                                 ISNULL(SUM(MON_OPRBLN09_MAN),0) AS OPRBLN09, ISNULL(SUM(MON_OPRBLN10_MAN),0) AS OPRBLN10, 
                                                 ISNULL(SUM(MON_OPRBLN11_MAN),0) AS OPRBLN11, ISNULL(SUM(MON_OPRBLN12_MAN),0) AS OPRBLN12,
                                                 ISNULL(SUM(MON_OPRBLN01_MAN),0) AS OPRBLN13, ISNULL(SUM(MON_OPRBLN02_MAN),0) AS OPRBLN14, 
                                                 ISNULL(SUM(MON_OPRBLN03_MAN),0) AS OPRBLN15
                                          FROM  BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                     AND CHR_KODE_SECTION = '$kode_sect'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $actual_real;
        } else if ($budget_type == 'CONSU'){
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
                                                     FROM BDGT_TM_BUDGET_CONSUMABLE
                                                     WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_KODE_SECTION = '$kode_sect'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_MAN AS OPRBLN13, 
                                                                MON_OPRBLN02_MAN AS OPRBLN14, 
                                                                MON_OPRBLN03_MAN AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_CONSUMABLE
                                                     WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_KODE_SECTION = '$kode_sect'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                     FROM BDGT_TM_BUDGET_CONSUMABLE
                                                     WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_KODE_SECTION = '$kode_sect'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_MAN AS OPRBLN13, 
                                                                MON_OPRBLN02_MAN AS OPRBLN14, 
                                                                MON_OPRBLN03_MAN AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_CONSUMABLE
                                                     WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_KODE_SECTION = '$kode_sect'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
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
                                                         AND CHR_KODE_SECTION = '$kode_sect'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                         AND CHR_KODE_SECTION = '$kode_sect'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                         AND CHR_KODE_SECTION = '$kode_sect'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                         AND CHR_KODE_SECTION = '$kode_sect'
                                                          AND CHR_KODE_TYPE_BUDGET LIKE '$budget_type%'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
        }
    }
    
    //---------------------- REPORT BUDGET DETAIL SMT1 -----------------------//
    function get_report_budget_smt1($fiscal_start, $fiscal_end, $bgt_type, $kode_dept, $kode_sect) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($bgt_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                     SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                     SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                     SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                     SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                     SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15,
                                                     SUM(LBLN01) AS LBLN01,SUM(LBLN02) AS LBLN02,SUM(LBLN03) AS LBLN03,
                                                     SUM(LBLN04) AS LBLN04,SUM(LBLN05) AS LBLN05,SUM(LBLN06) AS LBLN06,
                                                     SUM(LBLN07) AS LBLN07,SUM(LBLN08) AS LBLN08,SUM(LBLN09) AS LBLN09,
                                                     SUM(LBLN10) AS LBLN10,SUM(LBLN11) AS LBLN11,SUM(LBLN12) AS LBLN12,
                                                     SUM(LBLN13) AS LBLN13,SUM(LBLN14) AS LBLN14,SUM(LBLN15) AS LBLN15,
                                                     SUM(OBLN01) AS OBLN01,SUM(OBLN02) AS OBLN02,SUM(OBLN03) AS OBLN03,
                                                     SUM(OBLN04) AS OBLN04,SUM(OBLN05) AS OBLN05,SUM(OBLN06) AS OBLN06,
                                                     SUM(OBLN07) AS OBLN07,SUM(OBLN08) AS OBLN08,SUM(OBLN09) AS OBLN09,
                                                     SUM(OBLN10) AS OBLN10,SUM(OBLN11) AS OBLN11,SUM(OBLN12) AS OBLN12,
                                                     SUM(OBLN13) AS OBLN13,SUM(OBLN14) AS OBLN14,SUM(OBLN15) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                       CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
                                                       0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                                       0 AS LBLN01,0 AS LBLN02,0 AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN15,
                                                       0 AS OBLN01,0 AS OBLN02,0 AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET) AS BDGT_TM_BUDGET_CAPEX
                                                GROUP BY CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET")->result();
            return $budget_detail;
        } else if($bgt_type == 'CONSU') {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, 
                                                     BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, BDGT_CURR_YEAR.CHR_DESC_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_REV = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_BUDGET, BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET")->result();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, 
                                                     BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, BDGT_CURR_YEAR.CHR_DESC_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                                       ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15,
                                                       ISNULL(SUM(MON_LIMBLN01),0) AS LBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS LBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS LBLN03,
                                                       ISNULL(SUM(MON_LIMBLN04),0) AS LBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS LBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS LBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS LBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS LBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS LBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS LBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS LBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS LBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS LBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS LBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS LBLN15,
                                                       ISNULL(SUM(MON_OPRBLN01),0) AS OBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS OBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS OBLN03,
                                                       ISNULL(SUM(MON_OPRBLN04),0) AS OBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS OBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS OBLN06,
                                                       ISNULL(SUM(MON_OPRBLN07),0) AS OBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS OBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS OBLN09,
                                                       ISNULL(SUM(MON_OPRBLN10),0) AS OBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS OBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS OBLN12,
                                                       ISNULL(SUM(MON_OPRBLN13),0) AS OBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS OBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS OBLN15
                                            FROM (SELECT CHR_TAHUN_BUDGET, CHR_NO_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_TYPE_BUDGET, 
                                                     CHR_KODE_ITEM AS CHR_DESC_BUDGET, CHR_DESC_PROJECT, CHR_KODE_SUBCATEGORY_BUDGET,
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
                                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                     AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                     AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                     AND CHR_FLG_REV = '0') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,
                                                                MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15,
                                                                MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                                MON_OPRBLN01 AS MON_OPRBLN13,MON_OPRBLN02 AS MON_OPRBLN14,MON_OPRBLN03 AS MON_OPRBLN15
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                                AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                                AND CHR_KODE_SECTION LIKE '$kode_sect%'
                                                                AND CHR_KODE_TYPE_BUDGET = '$bgt_type' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET
                                            GROUP BY BDGT_CURR_YEAR.CHR_TAHUN_BUDGET, BDGT_CURR_YEAR.CHR_NO_BUDGET, BDGT_CURR_YEAR.CHR_KODE_DEPARTMENT, BDGT_CURR_YEAR.CHR_KODE_TYPE_BUDGET, 
                                                     BDGT_CURR_YEAR.CHR_DESC_BUDGET, BDGT_CURR_YEAR.CHR_DESC_PROJECT, BDGT_CURR_YEAR.CHR_KODE_SUBCATEGORY_BUDGET")->result();
            return $budget_detail;
        }
        
    }

    function get_pr_outstanding($fiscal_start, $fiscal_end, $bgt_type, $dept, $sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $outstd_pr = $bgt_aii->query("select distinct case when CHR_KODE_DEPARTMENT is null then 'TOTAL' else CHR_KODE_DEPARTMENT end as CHR_KODE_DEPARTMENT, CHR_DETILGROUP,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'04' then MNY_TOTAL else 0 end) as PR04,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'05' then MNY_TOTAL else 0 end) as PR05,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'06' then MNY_TOTAL else 0 end) as PR06,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'07' then MNY_TOTAL else 0 end) as PR07,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'08' then MNY_TOTAL else 0 end) as PR08,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'09' then MNY_TOTAL else 0 end) as PR09,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'10' then MNY_TOTAL else 0 end) as PR10,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'11' then MNY_TOTAL else 0 end) as PR11,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'12' then MNY_TOTAL else 0 end) as PR12,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'01' then MNY_TOTAL else 0 end) as PR13,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'02' then MNY_TOTAL else 0 end) as PR14,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'03' then MNY_TOTAL else 0 end) as PR15,
                                                        SUM(case when CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$fiscal_start'+'04') and CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$fiscal_end'+'03') then MNY_TOTAL else 0 end) as PR_TOT
                                                        from (
                                                        select /*DISTINCT*/ A.CHR_KODE_DEPARTMENT, 
                                                            LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6) as CHR_MONTH, 
                                                            C.CHR_DETILGROUP,
                                                            sum(B.MON_TOTAL_PRICE_SUPPLIER) as MNY_TOTAL
                                                        from
                                                        BDGT_TT_BUDGET_PR_HEADER as A 
                                                        left join BDGT_TT_BUDGET_PR_DETAIL as B on A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                                        left join BDGT_TM_USER as C on A.CHR_USERID = C.CHR_USERID 
                                                        where A.CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                        and A.CHR_KODE_DEPARTMENT LIKE '%$dept%'
                                                        and C.CHR_DETILGROUP LIKE '%$sect%'
                                                        and A.CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                                        and A.CHR_FLG_DELETE = '0'
                                                        and A.CHR_FLG_APPROVE_BOD = '0'
                                                        GROUP BY A.CHR_KODE_DEPARTMENT, LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6), C.CHR_DETILGROUP
                                                        ) summ									
                                                        GROUP BY CHR_KODE_DEPARTMENT, CHR_DETILGROUP");
        
        return $outstd_pr;
    }

    function get_pr_outstanding_by_no_budget($fiscal_start, $fiscal_end, $bgt_type, $dept, $sect, $no_budget){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $outstd_pr = $bgt_aii->query("select distinct case when CHR_KODE_DEPARTMENT is null then 'TOTAL' else CHR_KODE_DEPARTMENT end as CHR_KODE_DEPARTMENT, CHR_DETILGROUP, CHR_NO_BUDGET,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'04' then MNY_TOTAL else 0 end) as PR04,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'05' then MNY_TOTAL else 0 end) as PR05,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'06' then MNY_TOTAL else 0 end) as PR06,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'07' then MNY_TOTAL else 0 end) as PR07,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'08' then MNY_TOTAL else 0 end) as PR08,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'09' then MNY_TOTAL else 0 end) as PR09,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'10' then MNY_TOTAL else 0 end) as PR10,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'11' then MNY_TOTAL else 0 end) as PR11,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'12' then MNY_TOTAL else 0 end) as PR12,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'01' then MNY_TOTAL else 0 end) as PR13,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'02' then MNY_TOTAL else 0 end) as PR14,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'03' then MNY_TOTAL else 0 end) as PR15,
                                                        SUM(case when CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$fiscal_start'+'04') and CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$fiscal_end'+'03') then MNY_TOTAL else 0 end) as PR_TOT
                                                        from (
                                                        select /*DISTINCT*/ A.CHR_KODE_DEPARTMENT, 
                                                            LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6) as CHR_MONTH, 
                                                            C.CHR_DETILGROUP,
                                                            B.CHR_NO_BUDGET,
                                                            sum(B.MON_TOTAL_PRICE_SUPPLIER) as MNY_TOTAL
                                                        from
                                                        BDGT_TT_BUDGET_PR_HEADER as A 
                                                        left join BDGT_TT_BUDGET_PR_DETAIL as B on A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                                        left join BDGT_TM_USER as C on A.CHR_USERID = C.CHR_USERID 
                                                        where A.CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                        and A.CHR_KODE_DEPARTMENT LIKE '%$dept%'
                                                        and C.CHR_DETILGROUP LIKE '%$sect%'
                                                        and A.CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                                        and A.CHR_FLG_DELETE = '0'
                                                        and A.CHR_FLG_APPROVE_BOD = '0'
                                                        and B.CHR_NO_BUDGET = '$no_budget'
                                                        GROUP BY A.CHR_KODE_DEPARTMENT, LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6), C.CHR_DETILGROUP, B.CHR_NO_BUDGET
                                                        ) summ									
                                                        GROUP BY CHR_KODE_DEPARTMENT, CHR_DETILGROUP, CHR_NO_BUDGET");
        
        return $outstd_pr;
    }

    function get_pr_outstanding_by_dept($fiscal_start, $fiscal_end, $bgt_type, $group, $dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $outstd_pr = $bgt_aii->query("select distinct case when CHR_KODE_DEPARTMENT is null then 'TOTAL' else CHR_KODE_DEPARTMENT end as CHR_KODE_DEPARTMENT,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'04' then MNY_TOTAL else 0 end) as PR04,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'05' then MNY_TOTAL else 0 end) as PR05,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'06' then MNY_TOTAL else 0 end) as PR06,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'07' then MNY_TOTAL else 0 end) as PR07,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'08' then MNY_TOTAL else 0 end) as PR08,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'09' then MNY_TOTAL else 0 end) as PR09,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'10' then MNY_TOTAL else 0 end) as PR10,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'11' then MNY_TOTAL else 0 end) as PR11,
                                                        SUM(case when CHR_MONTH = '$fiscal_start'+'12' then MNY_TOTAL else 0 end) as PR12,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'01' then MNY_TOTAL else 0 end) as PR13,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'02' then MNY_TOTAL else 0 end) as PR14,
                                                        SUM(case when CHR_MONTH = '$fiscal_end'+'03' then MNY_TOTAL else 0 end) as PR15,
                                                        SUM(case when CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$fiscal_start'+'04') and CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$fiscal_end'+'03') then MNY_TOTAL else 0 end) as PR_TOT
                                                        from (
                                                        select /*DISTINCT*/ A.CHR_KODE_DEPARTMENT, 
                                                            LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6) as CHR_MONTH,
                                                            sum(B.MON_TOTAL_PRICE_SUPPLIER) as MNY_TOTAL
                                                        from
                                                        BDGT_TT_BUDGET_PR_HEADER as A 
                                                        left join BDGT_TT_BUDGET_PR_DETAIL as B on A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                                        where A.CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                        and A.CHR_KODE_GROUP LIKE '%$group%'
                                                        and A.CHR_KODE_DEPARTMENT LIKE '%$dept%'
                                                        and A.CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                                        and A.CHR_FLG_APPROVE_BOD = '0'
                                                        GROUP BY A.CHR_KODE_DEPARTMENT, LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6)
                                                        ) summ									
                                                        GROUP BY CHR_KODE_DEPARTMENT");
        
        return $outstd_pr;
    }

    function update_progress_mgr($kode_trans, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_DATE_MAN_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_gm($kode_trans, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_DATE_GM_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_dir($kode_trans, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_DATE_BOD_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_acc($kode_trans, $flag, $date, $asset_no, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_FLG_ACC = '$flag', CHR_DATE_ACC = '$date', CHR_ASSET_NO = '$asset_no', CHR_DATE_ACC_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_acc_v2($kode_trans, $flag, $date, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_FLG_ACC = '$flag', CHR_DATE_ACC = '$date', CHR_DATE_ACC_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_vp($kode_trans, $flag, $date, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_FLG_VP = '$flag', CHR_DATE_VP = '$date', CHR_DATE_VP_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_presdir($kode_trans, $flag, $date, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_FLG_PRESDIR = '$flag', CHR_DATE_PRESDIR = '$date', CHR_DATE_PRESDIR_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_gudtool($kode_trans, $flag, $date, $pr_no, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_FLG_GUDTOOL = '$flag', CHR_DATE_GUDTOOL = '$date', CHR_PR_NO = '$pr_no', CHR_DATE_GUDTOOL_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_gudtool_v2($kode_trans, $flag, $date, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_FLG_GUDTOOL = '$flag', CHR_DATE_GUDTOOL = '$date', CHR_DATE_GUDTOOL_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_purc($kode_trans, $flag, $date, $po_no, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_FLG_PURC = '$flag', CHR_DATE_PURC = '$date', CHR_PO_NO = '$po_no', CHR_DATE_PURC_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_purc_v2($kode_trans, $flag, $date, $date_in){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->query("UPDATE BDGT_TT_BUDGET_PR_HEADER SET CHR_FLG_PURC = '$flag', CHR_DATE_PURC = '$date', CHR_DATE_PURC_IN = '$date_in' WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");
    }

    function update_progress_all($kode_trans, $data){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_aii->where('CHR_KODE_TRANSAKSI', $kode_trans);
        $bgt_aii->update('BDGT_TT_BUDGET_PR_HEADER', $data);
    }

    function get_data_pr_by_trans_code($kode_trans){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $data = $bgt_aii->query("SELECT * FROM BDGT_TT_BUDGET_PR_HEADER WHERE CHR_KODE_TRANSAKSI = '$kode_trans'");

        return $data->row();
    }

    function get_list_pr_no($year_bgt, $bgt_type, $kode_dept, $kode_sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $usage = $bgt_aii->query("SELECT DISTINCT A.[CHR_KODE_TRANSAKSI]
                            FROM [BDGT_TT_BUDGET_PR_HEADER] AS A
                            INNER JOIN [BDGT_TT_BUDGET_PR_DETAIL] AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                            WHERE A.[CHR_KODE_DEPARTMENT] = '$kode_dept'
                                    AND SUBSTRING(B.CHR_NO_BUDGET, 7, 7) LIKE '$kode_sect%'
                                    AND A.CHR_FLG_DELETE = '0'
                                    AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                    AND CHR_TAHUN_BUDGET= '$year_bgt'
                            ORDER BY A.CHR_KODE_TRANSAKSI")->result();
        return $usage;
        
    }

}

?>
