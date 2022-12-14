<?php

class budget_sales_m extends CI_Model {

    private $tm_seq = 'CPL.TM_SEQ_NUMBER';
    private $tt_sales = 'CPL.TT_BUDGET_SALES';
    private $tw_sales = 'CPL.TW_BUDGET_SALES';

    function save_temp($data) {
        $this->db->insert($this->tw_sales, $data);
    }
    
    function save($data) {
        $this->db->insert($this->tt_sales, $data);
    }    
    
    function delete_existing_template($CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $this->db->query("delete from CPL.TW_BUDGET_SALES WHERE     (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_SECT = $INT_SECT) AND (INT_DEPT = $INT_DEPT)  AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY')");
    }
    
    function get_detail_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("select * from  CPL.TT_BUDGET_SALES where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')")->result();
    }
    
    function get_sum_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, CHR_BUDGET_CATEGORY, 
                      SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, 
                      SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, 
                      SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, 
                      SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                      SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                      SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, 
                      SUM(FLT_PRC_BLN01) AS FLT_PRC_BLN01, SUM(FLT_PRC_BLN02) AS FLT_PRC_BLN02, SUM(FLT_PRC_BLN03) AS FLT_PRC_BLN03, SUM(FLT_PRC_BLN04) AS FLT_PRC_BLN04, 
                      SUM(FLT_PRC_BLN05) AS FLT_PRC_BLN05, SUM(FLT_PRC_BLN06) AS FLT_PRC_BLN06, SUM(FLT_PRC_BLN07) AS FLT_PRC_BLN07, SUM(FLT_PRC_BLN08) AS FLT_PRC_BLN08, 
                      SUM(FLT_PRC_BLN09) AS FLT_PRC_BLN09, SUM(FLT_PRC_BLN10) AS FLT_PRC_BLN10, SUM(FLT_PRC_BLN11) AS FLT_PRC_BLN11, SUM(FLT_PRC_BLN12) AS FLT_PRC_BLN12, 
                      SUM(FLT_PRC_SUM) AS FLT_PRC_SUM,
                      SUM(FLT_RAT_BLN01) AS FLT_RAT_BLN01, SUM(FLT_RAT_BLN02) AS FLT_RAT_BLN02, SUM(FLT_RAT_BLN03) AS FLT_RAT_BLN03, SUM(FLT_RAT_BLN04) AS FLT_RAT_BLN04, 
                      SUM(FLT_RAT_BLN05) AS FLT_RAT_BLN05, SUM(FLT_RAT_BLN06) AS FLT_RAT_BLN06, SUM(FLT_RAT_BLN07) AS FLT_RAT_BLN07, SUM(FLT_RAT_BLN08) AS FLT_RAT_BLN08, 
                      SUM(FLT_RAT_BLN09) AS FLT_RAT_BLN09, SUM(FLT_RAT_BLN10) AS FLT_RAT_BLN10, SUM(FLT_RAT_BLN11) AS FLT_RAT_BLN11, SUM(FLT_RAT_BLN12) AS FLT_RAT_BLN12, 
                      SUM(FLT_RAT_SUM) AS FLT_RAT_SUM,
                      SUM(FLT_APR_BLN01) AS FLT_APR_BLN01, SUM(FLT_APR_BLN02) AS FLT_APR_BLN02, SUM(FLT_APR_BLN03) AS FLT_APR_BLN03, SUM(FLT_APR_BLN04) AS FLT_APR_BLN04, 
                      SUM(FLT_APR_BLN05) AS FLT_APR_BLN05, SUM(FLT_APR_BLN06) AS FLT_APR_BLN06, SUM(FLT_APR_BLN07) AS FLT_APR_BLN07, SUM(FLT_APR_BLN08) AS FLT_APR_BLN08, 
                      SUM(FLT_APR_BLN09) AS FLT_APR_BLN09, SUM(FLT_APR_BLN10) AS FLT_APR_BLN10, SUM(FLT_APR_BLN11) AS FLT_APR_BLN11, SUM(FLT_APR_BLN12) AS FLT_APR_BLN12, 
                      SUM(FLT_APR_SUM) AS FLT_APR_SUM
            FROM CPL.TT_BUDGET_SALES
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, CHR_BUDGET_CATEGORY, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }

    function get_detail_confirm_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select * from  CPL.TW_BUDGET_SALES where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY')")->result();
    }

    function get_sum_amt_confirm_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select CHR_ORG_CURR, SUM(MON_AMT_SUM) as sum from CPL.TW_BUDGET_SALES where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') group by CHR_ORG_CURR")->result();
    }

    function delete_existing_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $CHR_STAT_REV) {
        $this->db->query("delete from CPL.TT_BUDGET_SALES WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND  (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_SECT = $INT_SECT) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')");
    }

    function get_no_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV) {
        $budget_type = $this->db->query("select CHR_BUDGET_TYPE from CPL.TM_BUDGET_TYPE where INT_ID_BUDGET_TYPE = '$INT_ID_BUDGET_TYPE'")->row();
        $CHR_TIPE_BUDGET = $budget_type->CHR_BUDGET_TYPE;
        $budget_number = $this->db->query("SELECT INT_NO_BUDGET FROM  CPL.TM_SEQ_NUMBER WHERE (CHR_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND (CHR_TIPE_BUDGET = '$CHR_TIPE_BUDGET') AND (INT_DIV = '$INT_DIV')")->row();
        if (count($budget_number) == 0) {
            $data = array(
                'CHR_FISCAL_YEAR' => $INT_ID_FISCAL_YEAR,
                'CHR_STAT_REV' => $CHR_STAT_REV,
                'CHR_TIPE_BUDGET' => $CHR_TIPE_BUDGET,
                'INT_DIV' => $INT_DIV,
                'INT_DEPT' => $INT_DEPT,
                'INT_SECT' => $INT_SECT
            );
            $this->db->insert($this->tm_seq, $data);
        }

        $get_div = $this->db->query("SELECT CHR_DIVISION FROM TM_DIVISION WHERE INT_ID_DIVISION = '$INT_DIV'")->row();
        $get_dept = $this->db->query("SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = '$INT_DEPT'")->row();
        $get_sect = $this->db->query("SELECT CHR_SECTION FROM TM_SECTION WHERE INT_ID_SECTION = '$INT_SECT'")->row();

        $div = $get_div->CHR_DIVISION;
        $dept = $get_dept->CHR_DEPT;
        $sect = $get_sect->CHR_SECTION;
        $year_bgt = substr($INT_ID_FISCAL_YEAR, -2);
        $budget_number_val = sprintf("%'.05d\n", $budget_number->INT_NO_BUDGET);
        if($CHR_STAT_REV == 'RMB'){
            $budget_number_val = "$CHR_TIPE_BUDGET/$sect/$CHR_STAT_REV/$year_bgt" . $budget_number_val;
        } else {
            $budget_number_val = "$CHR_TIPE_BUDGET/$sect/$year_bgt" . $budget_number_val;
        }
        
        $this->db->query("update CPL.TM_SEQ_NUMBER set INT_NO_BUDGET = INT_NO_BUDGET + 1 WHERE (CHR_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND (CHR_TIPE_BUDGET = '$CHR_TIPE_BUDGET') AND (INT_DIV = '$INT_DIV')");
        return $budget_number_val;
    }
    
    function get_sub_category_sales_product_aii($INT_ID_BUDGET_CATEGORY) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY_DESC 
                                FROM CPL.TT_BUDGET_SALES 
                                WHERE CHR_BUDGET_CATEGORY IN (SELECT CHR_BUDGET_CATEGORY FROM CPL.TM_BUDGET_CATEGORY WHERE INT_ID_BUDGET_CATEGORY = '$INT_ID_BUDGET_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')")->result();
    }
    
    function get_detail_sales_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_CATEGORY) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("select * from  CPL.TT_BUDGET_SALES where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')")->result();
    }
    
    function get_sum_sales_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_CATEGORY) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, CHR_BUDGET_CATEGORY, 
                      SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, 
                      SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, 
                      SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, 
                      SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                      SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                      SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, 
                      SUM(FLT_PRC_BLN01) AS FLT_PRC_BLN01, SUM(FLT_PRC_BLN02) AS FLT_PRC_BLN02, SUM(FLT_PRC_BLN03) AS FLT_PRC_BLN03, SUM(FLT_PRC_BLN04) AS FLT_PRC_BLN04, 
                      SUM(FLT_PRC_BLN05) AS FLT_PRC_BLN05, SUM(FLT_PRC_BLN06) AS FLT_PRC_BLN06, SUM(FLT_PRC_BLN07) AS FLT_PRC_BLN07, SUM(FLT_PRC_BLN08) AS FLT_PRC_BLN08, 
                      SUM(FLT_PRC_BLN09) AS FLT_PRC_BLN09, SUM(FLT_PRC_BLN10) AS FLT_PRC_BLN10, SUM(FLT_PRC_BLN11) AS FLT_PRC_BLN11, SUM(FLT_PRC_BLN12) AS FLT_PRC_BLN12, 
                      SUM(FLT_PRC_SUM) AS FLT_PRC_SUM,
                      SUM(FLT_RAT_BLN01) AS FLT_RAT_BLN01, SUM(FLT_RAT_BLN02) AS FLT_RAT_BLN02, SUM(FLT_RAT_BLN03) AS FLT_RAT_BLN03, SUM(FLT_RAT_BLN04) AS FLT_RAT_BLN04, 
                      SUM(FLT_RAT_BLN05) AS FLT_RAT_BLN05, SUM(FLT_RAT_BLN06) AS FLT_RAT_BLN06, SUM(FLT_RAT_BLN07) AS FLT_RAT_BLN07, SUM(FLT_RAT_BLN08) AS FLT_RAT_BLN08, 
                      SUM(FLT_RAT_BLN09) AS FLT_RAT_BLN09, SUM(FLT_RAT_BLN10) AS FLT_RAT_BLN10, SUM(FLT_RAT_BLN11) AS FLT_RAT_BLN11, SUM(FLT_RAT_BLN12) AS FLT_RAT_BLN12, 
                      SUM(FLT_RAT_SUM) AS FLT_RAT_SUM,
                      SUM(FLT_APR_BLN01) AS FLT_APR_BLN01, SUM(FLT_APR_BLN02) AS FLT_APR_BLN02, SUM(FLT_APR_BLN03) AS FLT_APR_BLN03, SUM(FLT_APR_BLN04) AS FLT_APR_BLN04, 
                      SUM(FLT_APR_BLN05) AS FLT_APR_BLN05, SUM(FLT_APR_BLN06) AS FLT_APR_BLN06, SUM(FLT_APR_BLN07) AS FLT_APR_BLN07, SUM(FLT_APR_BLN08) AS FLT_APR_BLN08, 
                      SUM(FLT_APR_BLN09) AS FLT_APR_BLN09, SUM(FLT_APR_BLN10) AS FLT_APR_BLN10, SUM(FLT_APR_BLN11) AS FLT_APR_BLN11, SUM(FLT_APR_BLN12) AS FLT_APR_BLN12, 
                      SUM(FLT_APR_SUM) AS FLT_APR_SUM
            FROM CPL.TT_BUDGET_SALES
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, CHR_BUDGET_CATEGORY, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }
    
    function get_subcategory_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY){
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_SUB_CATEGORY FROM CPL.TT_BUDGET_SALES WHERE INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY' AND (CHR_STAT_REV = '$CHR_STAT_REV')")->result();
    }
    
    function get_purpose_sales($INT_ID_FISCAL_YEAR, $CHR_BUDGET_CATEGORY){
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT DISTINCT CHR_PURPOSE FROM CPL.TT_BUDGET_SALES WHERE INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY' AND (CHR_STAT_REV = '$CHR_STAT_REV')")->result();
    }
    
    function get_sales_by_subcategory($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_BUDGET_CATEGORY, $CHR_SUB_CATEGORY) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT CHR_BUDGET_SUB_CATEGORY_DESC, CHR_PURPOSE, CHR_CODE_UNIQ_PRODUCT, CHR_CODE_UNIQ_CUSTOMER,
                      SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, 
                      SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, 
                      SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, 
                      SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                      SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                      SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM                      
            FROM CPL.TT_BUDGET_SALES
            where (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DEPT = '$INT_DEPT') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (CHR_BUDGET_SUB_CATEGORY = '$CHR_SUB_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_SUB_CATEGORY_DESC, CHR_PURPOSE, CHR_CODE_UNIQ_PRODUCT, CHR_CODE_UNIQ_CUSTOMER")->result();
    }
    
    function get_sales_by_purpose($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_BUDGET_CATEGORY, $CHR_PURPOSE) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT CHR_PURPOSE, CHR_CODE_UNIQ_CUSTOMER, CHR_CUSTOMER_NAME,
                      SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, 
                      SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, 
                      SUM(INT_QTY_BLN09) AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, 
                      SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                      SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                      SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM                      
            FROM CPL.TT_BUDGET_SALES
            where (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DEPT = '$INT_DEPT') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (CHR_PURPOSE = '$CHR_PURPOSE') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_PURPOSE, CHR_CODE_UNIQ_CUSTOMER, CHR_CUSTOMER_NAME")->result();
    }
    
    function get_sales_tooling($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_BUDGET_CATEGORY) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT CHR_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY_DESC, CHR_PROJECT_NAME, CHR_CUSTOMER_NAME,
                      SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                      SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                      SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM                      
            FROM CPL.TT_BUDGET_SALES
            where (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DEPT = '$INT_DEPT') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY_DESC, CHR_PROJECT_NAME, CHR_CUSTOMER_NAME")->result();
    }
    
    function get_status_approve_gm($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $CHR_BUDGET_CATEGORY, $INT_DIV, $INT_DEPT) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("select CHR_FLAG_APP_GM from  CPL.TT_BUDGET_SALES where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_BUDGET_CATEGORY = '$CHR_BUDGET_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV') group by CHR_FLAG_APP_GM")->row();
    }

}

?>
 