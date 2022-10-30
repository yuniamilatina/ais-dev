<?php

class budget_tax_m extends CI_Model {

    private $tm_seq = 'CPL.TM_SEQ_NUMBER';
    private $tt_tax = 'CPL.TT_BUDGET_TAX';
    private $tw_tax = 'CPL.TW_BUDGET_TAX';

    function save_temp($data) {
        $this->db->insert($this->tw_tax, $data);
    }
    
    function save($data) {
        $this->db->insert($this->tt_tax, $data);
    }    
    
    function delete_existing_template($CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $this->db->query("delete from CPL.TW_BUDGET_TAX WHERE (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_SECT = $INT_SECT) AND (INT_DEPT = $INT_DEPT)  AND (INT_DIV = '$INT_DIV')");
    }
    
    function get_detail_tax($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("select * from  CPL.TT_BUDGET_TAX where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV') order by CHR_NO_BUDGET asc")->result();
    }
    
    function get_sum_tax($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM
            FROM CPL.TT_BUDGET_TAX
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }

    function get_detail_confirm_tax($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select * from  CPL.TW_BUDGET_TAX where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV')")->result();
    }

    function get_sum_amt_confirm_tax($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select SUM(MON_AMT_SUM) as sum from CPL.TW_BUDGET_TAX where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV')")->result();
    }

    function delete_existing_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV) {
        $this->db->query("delete from CPL.TT_BUDGET_TAX WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND  (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_SECT = $INT_SECT) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV')");
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
    
    function get_detail_tax_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("select * from  CPL.TT_BUDGET_TAX where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')")->result();
    }
    
    function get_sum_tax_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB';
        return $this->db->query("SELECT INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM
            FROM CPL.TT_BUDGET_TAX
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }

}

?>
 