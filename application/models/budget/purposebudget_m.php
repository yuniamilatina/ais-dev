<?php

class purposebudget_m extends CI_Model {

    private $table = 'CPL.TM_PURPOSE';

    function get_purposebudget() {
        $hasil = $this->db->query("select INT_ID_PURPOSE, CHR_PURPOSE, CHR_PURPOSE_DESC
            from CPL.TM_PURPOSE where BIT_FLG_DEL = 0");
        return $hasil->result();
    }
    
    function get_purposebudget_capex() {
        $hasil = $this->db->query("select INT_ID_PURPOSE, CHR_PURPOSE, CHR_PURPOSE_DESC
            from CPL.TM_PURPOSE where BIT_FLG_DEL = 0 and CHR_PURPOSE like 'PCA%'");
        return $hasil->result();
    }
    
    function get_purposebudget_by_code($code) {
        $hasil = $this->db->query("select INT_ID_PURPOSE, CHR_PURPOSE, CHR_PURPOSE_DESC
            from CPL.TM_PURPOSE where BIT_FLG_DEL = 0 and CHR_PURPOSE = '$code'");
        return $hasil->row();
    }
    
    function get_purposebudget_capex_by_category($category) {
        if($category == 1){
            $hasil = $this->db->query("select INT_ID_PURPOSE, CHR_PURPOSE, CHR_PURPOSE_DESC
                from CPL.TM_PURPOSE where BIT_FLG_DEL = 0 and CHR_PURPOSE IN ('PCA01','PCA02','PCA03','PCA04','PCA05','PCA06')");
            return $hasil->result();
        } else {
            $hasil = $this->db->query("select INT_ID_PURPOSE, CHR_PURPOSE, CHR_PURPOSE_DESC
                from CPL.TM_PURPOSE where BIT_FLG_DEL = 0 and CHR_PURPOSE IN ('PCA07')");
            return $hasil->result();
        }        
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function get_data_purposebudget($id) {
        $query = $this->db->query("select a.INT_ID_PURPOSE, a.CHR_PURPOSE, a.CHR_PURPOSE_DESC 
            from CPL.TM_PURPOSE a where a.BIT_FLG_DEL = 0 and a.INT_ID_PURPOSE = '" . $id . "'");
        return $query;
    }

    function update($data, $id) {
        $this->db->where('INT_ID_PURPOSE', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => '1');
        $this->db->where('INT_ID_PURPOSE', $id);
        $this->db->update($this->table, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_PURPOSE where INT_ID_PURPOSE = '" . $id . "' ");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    //id group 3 digit angka (400-599)
    function generate_id_purposebudget() {
        $query1 = $this->db->query("select count(INT_ID_PURPOSE) as 'id' from CPL.TM_PURPOSE")->row_array();
        $query2 = $this->db->query("select top 1 INT_ID_PURPOSE as 'id' from CPL.TM_PURPOSE order by INT_ID_PURPOSE desc")->row_array();

        $count = $query1['id'];
        $id = $query2['id'];
        intval($query1);

        if ($count < 1) {
            $id_akhir = 1;
        } else if ($count > 1 || $count < 100) {
            $id_akhir = $id + 1;
        } else {
            echo 'Id has expired please inform to your administrator';
            exit();
        }

        return $id_akhir;
    }
    
    // ---------------------------- // EDIT BY ANP // ------------------------//
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
    
    function get_costcenter($sect){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $costcenter = $bgt_aii->query("SELECT CHR_USERID,
                                              CHR_KODE_COSTCENTER
                                       FROM BDGT_TM_USER 
                                       WHERE CHR_DETILGROUP = '$sect'")->row();
        return $costcenter;
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
    
    function get_dept($kode_dept){
        $get_dept = $this->db->query("SELECT CHR_DEPT
                                          FROM TM_DEPT
                                          WHERE INT_ID_DEPT = '$kode_dept'")->row();
        return $get_dept;
    }
    
    function get_kode_group($dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $get_group = $bgt_aii->query("SELECT CHR_KODE_GROUP
                                          FROM BDGT_TM_DEPARTMENT
                                          WHERE CHR_KODE_DEPARTMENT = '$dept'")->row();
        return $get_group;
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
    
    function get_list_section($kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $list_sect = $bgt_aii->query("SELECT CHR_DETILGROUP, CHR_USER_DESC
                                      FROM BDGT_TM_USER 
                                      WHERE CHR_DEPARTMENT = '$kode_dept'
                                      ORDER BY CHR_DETILGROUP DESC")->result();
            
            return $list_sect;
    }
    
    function get_all_budget_type(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_type = $bgt_aii->query("SELECT CHR_BUDGET_TYPE, 
                                            CHR_BUDGET_TYPE_DESC
                                     FROM BDGT_TM_BUDGET_TYPE 
                                     WHERE CHR_FLG_DELETE <> 1")->result();
        return $bgt_type;
    }

    //===== START PROPOSE HERE ======//    
    function get_list_master_budget($fiscal_start, $fiscal_end, $budget_type, $dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $list_master_budget = $bgt_aii->query("SELECT CHR_FLG_CIP,CHR_FLG_USED,CHR_DESC_BUDGET,
                                                           CHR_TAHUN_BUDGET,CHR_KODE_TYPE_BUDGET,
                                                           CHR_KODE_DEPARTMENT,CHR_NO_BUDGET,
                                                           MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,
                                                           MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                           MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                           0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15,
                                                           CHR_FLG_CANCEL,CHR_FLG_APPROVAL_PROCESS,
                                                           CHR_FLG_CHANGE_AMOUNT, CHR_FLG_RESCHEDULE
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                          AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                                          AND CHR_KODE_DEPARTMENT LIKE '$dept%'
                                                UNION 
                                                SELECT CHR_FLG_CIP,CHR_FLG_USED,CHR_DESC_BUDGET,
                                                           CHR_TAHUN_BUDGET,CHR_KODE_TYPE_BUDGET,
                                                           CHR_KODE_DEPARTMENT,CHR_NO_BUDGET,
                                                           0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,0 AS MON_LIMBLN04,
                                                           0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,
                                                           0 AS MON_LIMBLN09,0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                           MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15, 
                                                           CHR_FLG_CANCEL, CHR_FLG_APPROVAL_PROCESS,
                                                           CHR_FLG_CHANGE_AMOUNT, CHR_FLG_RESCHEDULE
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                          AND CHR_TAHUN_ACTUAL = '$fiscal_end'
                                                          AND CHR_KODE_DEPARTMENT LIKE '$dept%'
                                                ORDER BY CHR_KODE_DEPARTMENT,CHR_NO_BUDGET")->result();
            return $list_master_budget;
        } else {
            $list_master_budget = $bgt_aii->query("SELECT CHR_DESC_BUDGET,CHR_TAHUN_BUDGET,CHR_KODE_TYPE_BUDGET,
                                                           CHR_KODE_DEPARTMENT,BDGT_START.CHR_NO_BUDGET,
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
                                                FROM (SELECT MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,
                                                           MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                           MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                           0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                          AND CHR_TAHUN_ACTUAL = '$fiscal_start'
                                                          AND CHR_NO_BUDGET = '$no_budget'
                                                UNION 
                                                SELECT  0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,0 AS MON_LIMBLN04,
                                                           0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,
                                                           0 AS MON_LIMBLN09,0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                           MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                          AND CHR_TAHUN_ACTUAL = '$fiscal_end'
                                                          AND CHR_NO_BUDGET = '$no_budget'
                                                          ) AS TM_BUDGET_CAPEX_DETAIL")->row();
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
    
    function update_master_budget($data, $budget_type, $budget_no) {
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
    
    function save_propose_unbudget($data, $budget_type) {
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == "CAPEX"){
            $tabel_master = "BDGT_TM_BUDGET_CAPEX";
            $bgt_aii->insert($tabel_master, $data);
        } else {
            $tabel_master = "BDGT_TM_BUDGET_EXPENSE";
            $bgt_aii->insert($tabel_master, $data);
        }        
    }

}

?>
