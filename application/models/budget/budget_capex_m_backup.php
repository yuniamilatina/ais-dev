<?php

class budget_capex_m extends CI_Model {

    private $tm_seq = 'CPL.TM_SEQ_NUMBER';
    private $tt_capex = 'CPL.TT_BUDGET_CAPEX';
    private $tw_capex = 'CPL.TW_BUDGET_CAPEX';

    function save_temp($data) {
        $this->db->insert($this->tw_capex, $data);
    }
    
    function save($data) {
        $this->db->insert($this->tt_capex, $data);
    }    
    
    function delete_existing_temp($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_DEPT, $INT_SECT, $INT_COSTCENTER, $CHR_BUDGET_TYPE) {
        $this->db->query("delete from CPL.TW_BUDGET_CAPEX WHERE (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_COST_CENTER = '$INT_COSTCENTER') AND (INT_SECT = '$INT_SECT') AND (INT_DEPT = '$INT_DEPT') AND (INT_DIV = '$INT_DIV') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')");
    }
    
    function get_detail_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select * from  CPL.TT_BUDGET_CAPEX where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV')")->result();
    }
    
    function get_sum_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("SELECT INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                      SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM,
                      SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, 
                      SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06,
                      SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, 
                      SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM
            FROM CPL.TT_BUDGET_CAPEX
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }
    
    function get_sum_capex_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("SELECT INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                      SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM,
                      SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, 
                      SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06,
                      SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, 
                      SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM
            FROM CPL.TT_BUDGET_CAPEX
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }

    function get_detail_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select * from  CPL.TW_BUDGET_CAPEX where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV')")->result();
    }

    function get_sum_amt_confirm_capex($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select SUM(MON_AMT_SUM) as sum from CPL.TW_BUDGET_CAPEX where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV')")->result();
    }

//    function delete_existing_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV) {
//        $this->db->query("delete from CPL.TT_BUDGET_CAPEX WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND  (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_SECT = $INT_SECT) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV')");
//    }

    function get_no_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV) {
        $budget_number = $this->db->query("SELECT INT_NO_BUDGET FROM CPL.TM_SEQ_NUMBER WHERE (CHR_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND (CHR_TIPE_BUDGET = '$CHR_BUDGET_TYPE') AND (INT_DIV = '$INT_DIV') AND (INT_DEPT = '$INT_DEPT')")->row();
        if (count($budget_number) == 0) {
            $data = array(
                'CHR_FISCAL_YEAR' => $INT_ID_FISCAL_YEAR,
                'CHR_STAT_REV' => $CHR_STAT_REV,
                'CHR_TIPE_BUDGET' => $CHR_BUDGET_TYPE,
                'INT_DIV' => $INT_DIV,
                'INT_DEPT' => $INT_DEPT,
                'INT_SECT' => $INT_SECT
            );
            $this->db->insert($this->tm_seq, $data);
        }

        $get_sect = $this->db->query("SELECT CHR_SECTION FROM TM_SECTION WHERE INT_ID_SECTION = '$INT_SECT'")->row();
        $sect = $get_sect->CHR_SECTION;
        $year_bgt = substr($INT_ID_FISCAL_YEAR, -2);
        $budget_number_val = sprintf("%'.05d\n", $budget_number->INT_NO_BUDGET);
        if($CHR_STAT_REV == 'RMB'){
            $budget_number_val = "$CHR_BUDGET_TYPE/$sect/$CHR_STAT_REV/$year_bgt" . $budget_number_val;
        } else {
            $budget_number_val = "$CHR_BUDGET_TYPE/$sect/$year_bgt" . $budget_number_val;
        }

        $this->db->query("update CPL.TM_SEQ_NUMBER set INT_NO_BUDGET = INT_NO_BUDGET + 1 WHERE (CHR_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND (CHR_TIPE_BUDGET = '$CHR_BUDGET_TYPE') AND (INT_DIV = '$INT_DIV') AND (INT_DEPT = '$INT_DEPT')");
        return $budget_number_val;
    }
    
    function get_summary_capex($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT) {
        return $this->db->query("SELECT CHR_NO_BUDGET, CHR_BUDGET_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC,
                                        INT_FLG_CIP, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM,                                        
                                        SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, 
                                        SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06,
                                        SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, 
                                        SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                                        SUM(INT_QTY_SUM) AS INT_QTY_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT')
                                GROUP BY CHR_NO_BUDGET, CHR_BUDGET_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC, INT_FLG_CIP, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN")->result();
    }
    
    function get_summary_capex_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT) {
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM,
                                        SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, 
                                        SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06,
                                        SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, 
                                        SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                                        SUM(INT_QTY_SUM) AS INT_QTY_SUM
                                FROM(SELECT CHR_NO_BUDGET, CHR_BUDGET_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM,
                                        SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, 
                                        SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06,
                                        SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, 
                                        SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                                        SUM(INT_QTY_SUM) AS INT_QTY_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT')
                                GROUP BY CHR_NO_BUDGET, CHR_BUDGET_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC) AS SUMMARY_TABLE")->result();
    }
    
    function get_detail_capex_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select * from  CPL.TT_BUDGET_CAPEX where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV')")->result();
    }
    
    //====================== SUMMARY BUDGET ---- ADMIN ===========================//
    function get_summary_capex_div_admin($INT_ID_FISCAL_YEAR) {
        return $this->db->query("SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_CAPEX.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC")->result();
    }

    function get_summary_capex_group_admin($INT_ID_FISCAL_YEAR) {
        return $this->db->query("SELECT CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_CAPEX.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                GROUP BY CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC")->result();
    }
    
    function get_summary_capex_dept_admin($INT_ID_FISCAL_YEAR) {
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_CAPEX.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }

    function get_summary_capex_admin_total($INT_ID_FISCAL_YEAR) {
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_CAPEX.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }

//====================== END SUMMARY BUDGET ---- ADMIN =======================//
//====================== SUMMARY BUDGET ---- DIREKTUR ========================//
    function get_summary_capex_div_dir($INT_ID_FISCAL_YEAR, $INT_DIV) {
        return $this->db->query("SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_CAPEX.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV')
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC")->result();
    }

    function get_summary_capex_group_dir($INT_ID_FISCAL_YEAR, $INT_DIV) {
        return $this->db->query("SELECT CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_CAPEX.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV')
                                GROUP BY CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC")->result();
    }
    
    function get_summary_capex_dept_dir($INT_ID_FISCAL_YEAR, $INT_DIV) {
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_CAPEX.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }

    function get_summary_capex_dir_total($INT_ID_FISCAL_YEAR, $INT_DIV) {
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_CAPEX.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }
//====================== END SUMMARY BUDGET ---- DIREKTUR ====================//
//====================== SUMMARY BUDGET ---- GM ==============================//
    function get_summary_capex_group_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP) {
        return $this->db->query("SELECT CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_CAPEX.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP')
                                GROUP BY CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC")->result();
    }
    
    function get_summary_capex_dept_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP) {
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_CAPEX.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }

    function get_summary_capex_gm_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP) {
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_CAPEX.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }
//====================== END SUMMARY BUDGET ---- GM ==========================//
//====================== SUMMARY BUDGET ---- MAN =============================//
    function get_summary_capex_dept_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT) {
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_CAPEX.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }
    
    function get_summary_capex_man_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT) {
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_CAPEX
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_CAPEX.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }
//====================== END SUMMARY BUDGET ---- MAN =========================//
}

?>
 