<?php

class purchase_request_m extends CI_Model {

    private $table = 'TT_BUDGET_PUREQ';
    private $fiscal;
    private $section;
    private $no_purchase_request;

    function replacer_dept($kode_dept) {
        // $dept = $this->db->query("select CHR_DEPT from TM_DEPT where INT_ID_DEPT = '$kode_dept'")->row();
        // if (count($dept) > 0) {
        //     $dept_kode = $dept->CHR_DEPT;
        // }
        $dept_kode = $kode_dept;
        
        //===== Temporary replacement Dept
        if ($dept_kode == 'OMD') {
            $dept_kode = 'KZN';
        } else if($dept_kode == 'ERP') {
            $dept_kode = 'PR3';
        } else if($dept_kode == 'MFG') {
            $dept_kode = 'PR4';
        } else if($dept_kode == 'BRP') {
            $dept_kode = 'PR1';
        } else if($dept_kode == 'PCO') {
            $dept_kode = 'KQC';
        }
        //===== End

        //$dept_kode = str_replace("PR", "PRD", $dept_kode);

        return $dept_kode;
    }

    //get purchase request by admin
    function get_purchase_request_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_PUREQ, a.DEC_TOTAL, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, 
            CASE a.INT_MONTH_REAL 
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END AS INT_MONTH_REAL, a.INT_APPROVE1, a.INT_APPROVE2
            from TT_BUDGET_PUREQ a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }
    
    function get_purchase_request_approve_by_admin( $fiscal) {
        $query = $this->db->query("select d.CHR_DEPT,d.CHR_DEPT_DESC,a.INT_APPROVE2,
            c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,d.INT_ID_DEPT,
            sum( a.DEC_TOTAL ) as total
             from TT_BUDGET_PUREQ a,TM_FISCAL c,TM_DEPT d,TM_SECTION e,TM_GROUP_DEPT f
             where
             a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR
             and a.INT_ID_SECTION = e.INT_ID_SECTION
             and e.INT_ID_DEPT = d.INT_ID_DEPT and d.INT_ID_GROUP_DEPT = f.INT_ID_GROUP_DEPT and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
             group by d.CHR_DEPT_DESC,a.INT_APPROVE2, c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,d.INT_ID_DEPT,d.CHR_DEPT");
        return $query->result();
    }
    
    function get_purchase_request_detail_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_PUREQ, a.DEC_TOTAL, b.CHR_FISCAL_YEAR, 
            CASE a.INT_MONTH_REAL 
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END AS INT_MONTH_REAL, a.INT_APPROVE1, a.INT_APPROVE2
            from TT_BUDGET_PUREQ a,TM_FISCAL b
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //manage purchase request by supervisor, will be approve
    function get_purchase_request_by_supervisor($section, $fiscal) {
        return $this->db->query("select a.INT_NO_PUREQ, a.DEC_TOTAL, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, 
            CASE a.INT_MONTH_REAL 
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END AS INT_MONTH_REAL, a.INT_APPROVE1, a.INT_APPROVE2
                            from TT_BUDGET_PUREQ a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
                            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR 
                            and a.INT_ID_SECTION = $section and a.INT_ID_FISCAL_YEAR = $fiscal
                            and a.INT_ID_SECTION = c.INT_ID_SECTION 
                            and c.INT_ID_DEPT = d.INT_ID_DEPT
                            and a.BIT_FLG_DEL = 0")->result();
    }

    //manage purchase request by manager, will be approve
    function get_purchase_request_by_manager($dept, $fiscal) {
        $query = $this->db->query("select  d.CHR_SECTION, d.CHR_SECTION_DESC, a.INT_APPROVE1,
            c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,d.INT_ID_SECTION,
            sum( a.DEC_TOTAL ) as total
             from TT_BUDGET_PUREQ a,TM_FISCAL c,TM_SECTION d
             where
             a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR and
             a.INT_ID_SECTION = d.INT_ID_SECTION and
             d.INT_ID_DEPT = '" . $dept . "' and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
             group by d.CHR_SECTION_DESC,a.INT_APPROVE1, c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,d.INT_ID_SECTION,d.CHR_SECTION");
        return $query->result();
    }

    function get_purchase_request_detail_by_manager($dept, $fiscal) {
        $query = $this->db->query("select a.INT_NO_PUREQ, a.DEC_TOTAL, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, 
            CASE a.INT_MONTH_REAL 
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END AS INT_MONTH_REAL, a.INT_APPROVE1, a.INT_APPROVE2, a.DEC_TOTAL
            from TT_BUDGET_PUREQ a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT and
                d.INT_ID_DEPT = '" . $dept . "'
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //manage purchase request by gm, will be approve
    function get_purchase_request_by_gm($groupdept, $fiscal) {
        $query = $this->db->query("select d.CHR_DEPT,d.CHR_DEPT_DESC,a.INT_APPROVE2,
            c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,d.INT_ID_DEPT,
            sum( a.DEC_TOTAL ) as total
             from TT_BUDGET_PUREQ a,TM_FISCAL c,TM_DEPT d,TM_SECTION e,TM_GROUP_DEPT f
             where
             a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR
             and a.INT_ID_SECTION = e.INT_ID_SECTION
             and f.INT_ID_GROUP_DEPT = '" . $groupdept . "'
             and e.INT_ID_DEPT = d.INT_ID_DEPT and d.INT_ID_GROUP_DEPT = f.INT_ID_GROUP_DEPT and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
             group by d.CHR_DEPT_DESC,a.INT_APPROVE2, c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,d.INT_ID_DEPT,d.CHR_DEPT");
        return $query->result();
    }

    function get_purchase_request_detail_by_gm($groupdept, $fiscal) {
        $query = $this->db->query("select a.INT_NO_PUREQ, a.DEC_TOTAL, b.CHR_FISCAL_YEAR, d.CHR_DEPT, e.CHR_GROUP_DEPT, 
            CASE a.INT_MONTH_REAL 
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END AS INT_MONTH_REAL, a.INT_APPROVE1, a.INT_APPROVE2
            from TT_BUDGET_PUREQ a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_GROUP_DEPT e
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and d.INT_ID_GROUP_DEPT = e.INT_ID_GROUP_DEPT 
                and e.INT_ID_GROUP_DEPT = '" . $groupdept . "'
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

//=====================================
    
    //get purchase request who approve by no one
    function get_purchase_request_approved_by_no_one($fiscal) {
        $query = $this->db->query("select a.INT_NO_PUREQ,a.DEC_TOTAL, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT,
            CASE a.INT_MONTH_REAL 
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END AS INT_MONTH_REAL, a.INT_APPROVE1, a.INT_APPROVE2
            from TT_BUDGET_PUREQ a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and a.INT_APPROVE1 = 0 and a.INT_APPROVE2 = 0 
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get purchase request who approve by manager
    function get_purchase_request_approved_by_manager($fiscal) {
        $query = $this->db->query("select a.INT_NO_PUREQ,a.DEC_TOTAL, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT,
            CASE a.INT_MONTH_REAL 
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END AS INT_MONTH_REAL, a.INT_APPROVE1, a.INT_APPROVE2
            from TT_BUDGET_PUREQ a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and a.INT_APPROVE1 = 1 and a.INT_APPROVE2 != 1
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get purchase request who approve by gm
    function get_purchase_request_approved_by_gm($fiscal) {
        $query = $this->db->query("select a.INT_NO_PUREQ, a.DEC_TOTAL, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT,
            CASE a.INT_MONTH_REAL 
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct' WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END AS INT_MONTH_REAL, a.INT_APPROVE1, a.INT_APPROVE2
            from TT_BUDGET_PUREQ a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and a.INT_APPROVE1 = 1 and a.INT_APPROVE2 = 1
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get data purchase request by no purchase request
    function get_data_purchase_request($no_purchase_request) {
        $query = $this->db->query("select a.INT_NO_PUREQ,a.DEC_TOTAL,b.CHR_FISCAL_YEAR, c.CHR_SECTION_DESC,d.INT_ID_DEPT, d.CHR_DEPT_DESC, d.CHR_DEPT,
            CASE a.INT_MONTH_REAL
            WHEN '1' THEN 'January' WHEN '2' THEN 'February' WHEN '3' THEN 'March' WHEN '4' THEN 'April' WHEN '5' THEN 'May' 
            WHEN '6' THEN 'June' WHEN '7' THEN 'July' WHEN '8' THEN 'August' WHEN '9' THEN 'September' WHEN '10' THEN 'October'
            WHEN '11' THEN 'November' ELSE 'December' END as INT_MONTH_REAL,
            CASE a.INT_APPROVE1 WHEN '1' THEN 'Approve' WHEN '2' THEN 'Not Approve' ELSE '-' END as INT_APPROVE1,
            CASE a.INT_APPROVE2 WHEN '1' THEN 'Approve' WHEN '2' THEN 'Not Approve' ELSE '-' END as INT_APPROVE2
        from TT_BUDGET_PUREQ a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
        where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and a.BIT_FLG_DEL = 0 and a.INT_NO_PUREQ = '" . $no_purchase_request . "'");
        return $query;
    }

    function generated_id_purchase_request() {
        $query = $this->db->query("select top 1 INT_NO_PUREQ as 'id' from TT_BUDGET_PUREQ where SUBSTRING(CAST(INT_NO_PUREQ as char),1,2) = RIGHT(year(getdate()),2) order by INT_NO_PUREQ desc");

        if ($query->num_rows() != 0) {
            $result = $query->row_array();
            $no_purchase_request = $result['id'];
            return $no_purchase_request + 1;
        } else {
            $no_purchase_request = date('y') . '00000';
            return $no_purchase_request;
        }
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function update($data, $no_purchase_request) {
        $this->db->where('INT_NO_PUREQ', $no_purchase_request);
        $this->db->update($this->table, $data);
    }

    function delete($no_purchase_request) {
        $this->db->where('INT_NO_PUREQ', $no_purchase_request);
        $this->db->delete($this->table);
    }

    // function generated_id_purchase_request_temp() {
    //     $query = $this->db->query('select max(INT_NO_PUREQ_TEMP) as a from TW_BUDGET_PUREQ_BUDGET')->row()->a + 1;
    //     return $query;
    // }

    function check_quantity($no_budget, $quantity) {
        $qty = $this->db->query("select INT_QUANTITY from TT_BUDGET_CAPEX where INT_NO_BUDGET_CPX = '" . $no_budget . "'")->row_array();
        if ($qty['INT_QUANTITY'] < $quantity) {
            return true;
        }
        return false;
    }

    function check_mount($no_budget, $mount) {
        $qty = $this->db->query("select DEC_TOTAL from TT_BUDGET where INT_NO_BUDGET = '" . $no_budget . "'")->row_array();
        if ($qty['DEC_TOTAL'] < $mount) {
            return true;
        }
        return false;
    }
    
    //------------------------------------------------------------------------//
    //--------------------- // EDITED BY ANP // ------------------------------//
    //------------------------------------------------------------------------//
    
    function get_user_dept($id_dept){
        $kode_dept_ais = $this->db->query("SELECT CHR_DEPT
                                           FROM TM_DEPT
                                           WHERE INT_ID_DEPT = '$id_dept'")->row();
        
        return $kode_dept_ais;
    }
    
    function get_dept_name($kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        //$kode_dept = $this->replacer_dept($kode_dept);
        $dept_name = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                      FROM BDGT_TM_DEPARTMENT
                                      WHERE CHR_KODE_DEPARTMENT LIKE '$kode_dept%'")->row();
        return $dept_name;
    }
    
    function get_budget_type(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_type = $bgt_aii->query("SELECT CHR_BUDGET_TYPE, 
                                            CHR_BUDGET_TYPE_DESC
                                     FROM BDGT_TM_BUDGET_TYPE 
                                     WHERE CHR_FLG_DELETE <> 1")->result();
        return $bgt_type;
    }
    
    function get_bgt_type_name($budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_type_name = $bgt_aii->query("SELECT CHR_BUDGET_TYPE_DESC
                                          FROM BDGT_TM_BUDGET_TYPE
                                          WHERE CHR_BUDGET_TYPE = '$budget_type'")->row();
        return $bgt_type_name;
    }
    
    function get_group_dept_name($kode_group, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $group_name = $bgt_aii->query("SELECT CHR_GROUP_DESCRIPTION
                                        FROM BDGT_TM_DEPARTMENT
                                        WHERE CHR_KODE_GROUP = '$kode_group' AND CHR_KODE_DEPARTMENT = '$kode_dept'")->row();
        return $group_name;
    }
    
    function get_all_purchase_request($fiscal_start){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_pr = $bgt_aii->query("SELECT *
                                       FROM BDGT_TT_BUDGET_PR_HEADER
                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                       ORDER BY CHR_KODE_TRANSAKSI")->result();
        return $all_pr;
    }
    
    function get_pr_fiscal_year($kode_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $fiscal_year = $bgt_aii->query("SELECT CHR_FISCAL_YEAR
                                        FROM BDGT_TT_BUDGET_PR_HEADER
                                        WHERE CHR_KODE_TRANSAKSI = '$kode_transaksi'");
        return $fiscal_year;
    }
    
    function get_detail_transaksi_pr($kode_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $detail_trans = $bgt_aii->query("SELECT CHR_TGL_ESTIMASI_KEDATANGAN, 
                                                MON_TOTAL_PRICE_SUPPLIER, 
                                                INT_QTY, 
                                                CHR_NO_BUDGET 
                                        FROM BDGT_TT_BUDGET_PR_DETAIL 
                                        WHERE CHR_KODE_TRANSAKSI = '$kode_transaksi'")->result();
        return $detail_trans;
    }
    
    //--------------------- GET LIST KODE TRANS BY ADMIN ---------------------//
    function get_list_kode_trans($tahun, $budget_type, $status_bgt){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $kode_trans = $bgt_aii->query("SELECT DISTINCT CHR_KODE_TRANSAKSI, 
                                              CHR_FLG_APPROVE_MAN,
                                              CHR_FLG_APPROVE_GM,
                                              CHR_FLG_APPROVE_BOD,
                                              CHR_KODE_DEPARTMENT
                                       FROM BDGT_TT_BUDGET_PR_HEADER
                                       WHERE CHR_TAHUN_BUDGET = '$tahun'
                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                            AND CHR_FLG_DELETE = '0'
                                            AND CHR_FLG_APPROVE_BOD = '$status_bgt'
                                       ORDER BY CHR_KODE_TRANSAKSI")->result();
        return $kode_trans;
    }
    
    //--------------------- GET LIST KODE TRANS BY BOD ---------------------//
    function get_list_kode_trans_bod($tahun, $budget_type, $status_bgt){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $kode_trans = $bgt_aii->query("SELECT DISTINCT CHR_KODE_TRANSAKSI, 
                                              CHR_FLG_APPROVE_BOD, 
                                              CHR_KODE_DEPARTMENT
                                       FROM BDGT_TT_BUDGET_PR_HEADER
                                       WHERE CHR_TAHUN_BUDGET = '$tahun'
                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                            AND CHR_FLG_DELETE = '0'
                                            AND CHR_FLG_APPROVE_MAN = '1'
                                            AND CHR_FLG_APPROVE_GM = '1'
                                            AND CHR_FLG_APPROVE_BOD = '$status_bgt'
                                       ORDER BY CHR_KODE_TRANSAKSI")->result();
        return $kode_trans;
    }
    
    //--------------------- GET LIST KODE TRANS BY GM ---------------------//
    function get_list_kode_trans_gm($tahun, $budget_type, $status_bgt, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $kode_trans = $bgt_aii->query("SELECT DISTINCT CHR_KODE_TRANSAKSI, 
                                              CHR_FLG_APPROVE_GM, 
                                              CHR_KODE_DEPARTMENT
                                       FROM BDGT_TT_BUDGET_PR_HEADER
                                       WHERE CHR_TAHUN_BUDGET = '$tahun'
                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                            AND CHR_FLG_DELETE = '0'
                                            AND CHR_FLG_APPROVE_MAN = '1'
                                            AND CHR_FLG_APPROVE_GM = '$status_bgt'
                                            AND CHR_KODE_GROUP = '$kode_group'
                                       ORDER BY CHR_KODE_TRANSAKSI")->result();
        return $kode_trans;
    }
    
    //------------------- GET LIST KODE TRANS BY MANAGER ---------------------//
    function get_list_kode_trans_manager($tahun, $budget_type, $status_bgt, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $kode_trans = $bgt_aii->query("SELECT DISTINCT CHR_KODE_TRANSAKSI, 
                                              CHR_FLG_APPROVE_MAN, 
                                              CHR_KODE_DEPARTMENT
                                       FROM BDGT_TT_BUDGET_PR_HEADER
                                       WHERE CHR_TAHUN_BUDGET = '$tahun'
                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                            AND CHR_FLG_DELETE = '0'
                                            AND CHR_FLG_APPROVE_MAN = '$status_bgt'
                                            AND CHR_KODE_DEPARTMENT LIKE '$kode_dept%'
                                       ORDER BY CHR_KODE_TRANSAKSI")->result();
        return $kode_trans;
    }
    
    //------------------------ GET PR HEADER BY ADMIN --------------------------//    
    function get_pr_header_by_admin($tahun, $budget_type, $status_bgt, $kode_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($kode_transaksi == NULL){
            $pr_header_admin = '';
        } else {
            $pr_header_admin = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                           A.CHR_NO_BUDGET,
                                           A.CHR_KODE_GROUP,
                                           A.CHR_KODE_DEPARTMENT,
                                           B.CHR_DEPARTMENT_DESCRIPTION,
                                           A.CHR_TGL_TRANS,
                                           A.CHR_FISCAL_YEAR
                                    FROM BDGT_TT_BUDGET_PR_HEADER A
                                    LEFT JOIN BDGT_TM_DEPARTMENT B ON A.CHR_KODE_DEPARTMENT = B.CHR_KODE_DEPARTMENT
                                    WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                          AND A.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                          AND A.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                          AND A.CHR_FLG_APPROVE_BOD = '$status_bgt'")->row();
            return $pr_header_admin;
        }
    }
    
    //------------------------ GET PR HEADER BY BOD --------------------------//    
    function get_pr_header_by_bod($tahun, $budget_type, $status_bgt, $kode_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($kode_transaksi == NULL){
            $pr_header_bod = '';
        } else {
            $pr_header_bod = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                           A.CHR_NO_BUDGET,
                                           A.CHR_KODE_GROUP,
                                           A.CHR_KODE_DEPARTMENT,
                                           B.CHR_DEPARTMENT_DESCRIPTION,
                                           A.CHR_TGL_TRANS,
                                           A.CHR_FISCAL_YEAR
                                    FROM BDGT_TT_BUDGET_PR_HEADER A
                                    LEFT JOIN BDGT_TM_DEPARTMENT B ON A.CHR_KODE_DEPARTMENT = B.CHR_KODE_DEPARTMENT
                                    WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                          AND A.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                          AND A.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                          AND A.CHR_FLG_APPROVE_BOD = '$status_bgt'")->row();
            return $pr_header_bod;
        }
    } 
    
    //------------------------ GET PR HEADER BY GM --------------------------//    
    function get_pr_header_by_gm($tahun, $budget_type, $status_bgt, $kode_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($kode_transaksi == NULL){
            $pr_header_gm = '';
        } else {
            $pr_header_gm = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                           A.CHR_NO_BUDGET,
                                           A.CHR_KODE_GROUP,
                                           A.CHR_KODE_DEPARTMENT,
                                           B.CHR_DEPARTMENT_DESCRIPTION,
                                           A.CHR_TGL_TRANS,
                                           A.CHR_FISCAL_YEAR,
                                           A.CHR_FLG_APPROVE_BOD
                                    FROM BDGT_TT_BUDGET_PR_HEADER A
                                    LEFT JOIN BDGT_TM_DEPARTMENT B ON A.CHR_KODE_DEPARTMENT = B.CHR_KODE_DEPARTMENT
                                    WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                          AND A.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                          AND A.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                          AND A.CHR_FLG_APPROVE_GM = '$status_bgt'")->row();
            return $pr_header_gm;
        }
    }
    
    //---------------------- GET PR HEADER BY MANAGER ------------------------//    
    function get_pr_header_by_manager($tahun, $budget_type, $status_bgt, $kode_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($kode_transaksi == NULL){
            $pr_header_mgr = '';
        } else {
            $pr_header_mgr = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                           A.CHR_NO_BUDGET,
                                           A.CHR_KODE_GROUP,
                                           A.CHR_KODE_DEPARTMENT,
                                           B.CHR_DEPARTMENT_DESCRIPTION,
                                           A.CHR_TGL_TRANS,
                                           A.CHR_FISCAL_YEAR,
                                           A.CHR_FLG_APPROVE_GM,
                                           A.CHR_FLG_APPROVE_BOD
                                    FROM BDGT_TT_BUDGET_PR_HEADER A
                                    LEFT JOIN BDGT_TM_DEPARTMENT B ON A.CHR_KODE_DEPARTMENT = B.CHR_KODE_DEPARTMENT
                                    WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                          AND A.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                          AND A.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                          AND A.CHR_FLG_APPROVE_MAN = '$status_bgt'")->row();
            return $pr_header_mgr;
        }
    }
    
    //------------------------ GET LIST PR BY ADMIN --------------------------//
    function get_list_pr_by_admin($tahun, $budget_type, $kode_transaksi, $status_bgt){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == NULL){
            $budget_type = '';
        }
        
        if ($kode_transaksi == NULL){
            $kode_transaksi = '';
        }
        
        if($budget_type == 'CAPEX'){
            $list_pr_by_admin = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               SUM(C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_CAPEX C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_MAN = '$status_bgt'
                                        GROUP BY A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_admin;
        } else {
            $list_pr_by_admin = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               SUM(C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_EXPENSE C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_MAN = '$status_bgt'
                                        GROUP BY A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_admin;
        }
    }
    
    //------------------------ GET LIST PR BY BOD --------------------------//
    function get_list_pr_by_bod($tahun, $budget_type, $status_bgt, $kode_transaksi){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == NULL){
            $budget_type = '';
        }
        if ($status_bgt == NULL){
            $status_bgt = '';
        }
        if ($kode_transaksi == NULL){
            $kode_transaksi = '';
        }
        
        if($budget_type == 'CAPEX'){
            $list_pr_by_bod = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               --SUM(C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               --SUM(C.MON_REV01BLN01+C.MON_REV01BLN02+C.MON_REV01BLN03+C.MON_REV01BLN04+C.MON_REV01BLN05+C.MON_REV01BLN06+C.MON_REV01BLN07+C.MON_REV01BLN08+C.MON_REV01BLN09+C.MON_REV01BLN10+C.MON_REV01BLN11+C.MON_REV01BLN12) AS REVISI,
                                               --SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               --SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                               (C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               (C.MON_REV01BLN01+C.MON_REV01BLN02+C.MON_REV01BLN03+C.MON_REV01BLN04+C.MON_REV01BLN05+C.MON_REV01BLN06+C.MON_REV01BLN07+C.MON_REV01BLN08+C.MON_REV01BLN09+C.MON_REV01BLN10+C.MON_REV01BLN11+C.MON_REV01BLN12) AS REVISI,
                                               (C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               (C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_CAPEX C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_GM = '1'
                                              AND B.CHR_FLG_APPROVE_BOD = '$status_bgt'
                                        --GROUP BY A.CHR_KODE_TRANSAKSI, 
                                        --       A.CHR_NO_BUDGET,
                                        --       B.CHR_KODE_DEPARTMENT,
                                        --       A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                        --       A.CHR_PURCHASE_PART, 
                                        --       A.INT_QTY, 
                                        --       A.CHR_UNIT, 
                                        --       A.MON_TOTAL_PRICE_SUPPLIER,
                                        --       B.CHR_FLG_APPROVE_GM,
                                        --       B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_bod;
        } else {
            $list_pr_by_bod = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               SUM(C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_EXPENSE C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_GM = '1'
                                              AND B.CHR_FLG_APPROVE_BOD = '$status_bgt'
                                        GROUP BY A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_bod;
        }
    }    
    
    //------------------------ GET LIST PR BY GM --------------------------//    
    function get_list_pr_by_gm($tahun, $budget_type, $kode_transaksi, $status_bgt){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == NULL){
            $budget_type = '';
        }
        if ($status_bgt == NULL){
            $status_bgt = '';
        }
        if ($kode_transaksi == NULL){
            $kode_transaksi = '';
        }
        
        if($budget_type == 'CAPEX'){        
            $list_pr_by_gm = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               --SUM(C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               --SUM(C.MON_REV01BLN01+C.MON_REV01BLN02+C.MON_REV01BLN03+C.MON_REV01BLN04+C.MON_REV01BLN05+C.MON_REV01BLN06+C.MON_REV01BLN07+C.MON_REV01BLN08+C.MON_REV01BLN09+C.MON_REV01BLN10+C.MON_REV01BLN11+C.MON_REV01BLN12) AS REVISI,
                                               --SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               --SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                               (C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               (C.MON_REV01BLN01+C.MON_REV01BLN02+C.MON_REV01BLN03+C.MON_REV01BLN04+C.MON_REV01BLN05+C.MON_REV01BLN06+C.MON_REV01BLN07+C.MON_REV01BLN08+C.MON_REV01BLN09+C.MON_REV01BLN10+C.MON_REV01BLN11+C.MON_REV01BLN12) AS REVISI,
                                               (C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               (C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_CAPEX C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_GM = '$status_bgt'
                                        --GROUP BY A.CHR_KODE_TRANSAKSI, 
                                        --       A.CHR_NO_BUDGET,
                                        --       B.CHR_KODE_DEPARTMENT,
                                        --       A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                        --       A.CHR_PURCHASE_PART, 
                                        --       A.INT_QTY, 
                                        --       A.CHR_UNIT, 
                                        --       A.MON_TOTAL_PRICE_SUPPLIER,
                                        --       B.CHR_FLG_APPROVE_GM,
                                        --       B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_gm;
        } else {
            $list_pr_by_gm = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               SUM(C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_EXPENSE C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_GM = '$status_bgt'
                                        GROUP BY A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_gm;
        }
    }
    
    //----------------------- GET LIST PR BY MANAGER -------------------------//    
    function get_list_pr_by_manager($tahun, $budget_type, $kode_transaksi, $status_bgt){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == NULL){
            $budget_type = '';
        }
        if ($status_bgt == NULL){
            $status_bgt = '';
        }
        if ($kode_transaksi == NULL){
            $kode_transaksi = '';
        }
        
        if($budget_type == 'CAPEX'){        
            $list_pr_by_mgr = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               --SUM(C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               --SUM(C.MON_REV01BLN01+C.MON_REV01BLN02+C.MON_REV01BLN03+C.MON_REV01BLN04+C.MON_REV01BLN05+C.MON_REV01BLN06+C.MON_REV01BLN07+C.MON_REV01BLN08+C.MON_REV01BLN09+C.MON_REV01BLN10+C.MON_REV01BLN11+C.MON_REV01BLN12) AS REVISI,
                                               --SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               --SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                               (C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               (C.MON_REV01BLN01+C.MON_REV01BLN02+C.MON_REV01BLN03+C.MON_REV01BLN04+C.MON_REV01BLN05+C.MON_REV01BLN06+C.MON_REV01BLN07+C.MON_REV01BLN08+C.MON_REV01BLN09+C.MON_REV01BLN10+C.MON_REV01BLN11+C.MON_REV01BLN12) AS REVISI,
                                               (C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               (C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_CAPEX C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_MAN = '$status_bgt'
                                        --GROUP BY A.CHR_KODE_TRANSAKSI, 
                                        --       A.CHR_NO_BUDGET,
                                        --       B.CHR_KODE_DEPARTMENT,
                                        --       A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                        --       A.CHR_PURCHASE_PART, 
                                        --       A.INT_QTY, 
                                        --       A.CHR_UNIT, 
                                        --       A.MON_TOTAL_PRICE_SUPPLIER,
                                        --       B.CHR_FLG_APPROVE_MAN,
                                        --       B.CHR_FLG_APPROVE_GM,
                                        --       B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_mgr;
        } else {
            $list_pr_by_mgr = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.INT_KODE_ITEM,
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               SUM(C.MON_BLN01+C.MON_BLN02+C.MON_BLN03+C.MON_BLN04+C.MON_BLN05+C.MON_BLN06+C.MON_BLN07+C.MON_BLN08+C.MON_BLN09+C.MON_BLN10+C.MON_BLN11+C.MON_BLN12) AS BUDGET,
                                               SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_EXPENSE C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_MAN = '$status_bgt'
                                        GROUP BY A.CHR_KODE_TRANSAKSI, 
                                               A.INT_KODE_ITEM,
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_mgr;
        }
    }
    
    //----------------------- GET LIST PR BY MANAGER -------------------------//    
    function get_list_pr_rev_by_manager($tahun, $budget_type, $kode_transaksi, $status_bgt){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == NULL){
            $budget_type = '';
        }
        if ($status_bgt == NULL){
            $status_bgt = '';
        }
        if ($kode_transaksi == NULL){
            $kode_transaksi = '';
        }
        
        if($budget_type == 'CAPEX'){        
            $list_pr_by_mgr = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               SUM(C.MON_REV01BLN01+C.MON_REV01BLN02+C.MON_REV01BLN03+C.MON_REV01BLN04+C.MON_REV01BLN05+C.MON_REV01BLN06+C.MON_REV01BLN07+C.MON_REV01BLN08+C.MON_REV01BLN09+C.MON_REV01BLN10+C.MON_REV01BLN11+C.MON_REV01BLN12) AS BUDGET,
                                               SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_CAPEX C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_MAN = '$status_bgt'
                                        GROUP BY A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_mgr;
        } else {
            $list_pr_by_mgr = $bgt_aii->query("SELECT A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD,
                                               SUM(C.MON_REV01BLN01+C.MON_REV01BLN02+C.MON_REV01BLN03+C.MON_REV01BLN04+C.MON_REV01BLN05+C.MON_REV01BLN06+C.MON_REV01BLN07+C.MON_REV01BLN08+C.MON_REV01BLN09+C.MON_REV01BLN10+C.MON_REV01BLN11+C.MON_REV01BLN12) AS BUDGET,
                                               SUM(C.MON_LIMBLN01+C.MON_LIMBLN02+C.MON_LIMBLN03+C.MON_LIMBLN04+C.MON_LIMBLN05+C.MON_LIMBLN06+C.MON_LIMBLN07+C.MON_LIMBLN08+C.MON_LIMBLN09+C.MON_LIMBLN10+C.MON_LIMBLN11+C.MON_LIMBLN12) AS LIMIT,
                                               SUM(C.MON_OPRBLN01+C.MON_OPRBLN02+C.MON_OPRBLN03+C.MON_OPRBLN04+C.MON_OPRBLN05+C.MON_OPRBLN06+C.MON_OPRBLN07+C.MON_OPRBLN08+C.MON_OPRBLN09+C.MON_OPRBLN10+C.MON_OPRBLN11+C.MON_OPRBLN12) AS REALISASI
                                        FROM BDGT_TT_BUDGET_PR_DETAIL A
                                        LEFT JOIN BDGT_TT_BUDGET_PR_HEADER B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                        LEFT JOIN BDGT_TM_BUDGET_EXPENSE C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                        WHERE A.CHR_KODE_TRANSAKSI = '$kode_transaksi'
                                              AND B.CHR_TAHUN_BUDGET LIKE '$tahun%'
                                              AND B.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                              AND B.CHR_FLG_APPROVE_MAN = '$status_bgt'
                                        GROUP BY A.CHR_KODE_TRANSAKSI, 
                                               A.CHR_NO_BUDGET,
                                               B.CHR_KODE_DEPARTMENT,
                                               A.CHR_TGL_ESTIMASI_KEDATANGAN,
                                               A.CHR_PURCHASE_PART, 
                                               A.INT_QTY, 
                                               A.CHR_UNIT, 
                                               A.MON_TOTAL_PRICE_SUPPLIER,
                                               B.CHR_FLG_APPROVE_MAN,
                                               B.CHR_FLG_APPROVE_GM,
                                               B.CHR_FLG_APPROVE_BOD")->result();
            return $list_pr_by_mgr;
        }
    }
    
    //------------------- TOTAL ALL BUDGET PLAN DEPT -------------------------//
    function get_total_budget_plan($tahun, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTPLAN
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_UNBUDGET = '0'
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_budget;
        } else if($budget_type == 'CONSU') {
            $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTPLAN
                                                   FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                         AND CHR_FLG_REV = '0' 
                                                         AND CHR_FLG_UNBUDGET = '0'")->row();
            return $total_budget;
        } else {
            $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTPLAN
                                                   FROM BDGT_TM_BUDGET_EXPENSE 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                         AND CHR_FLG_REV = '0' 
                                                         AND CHR_FLG_UNBUDGET = '0'")->row();
            return $total_budget;
        }
    }
    
    //------------------- TOTAL ALL BUDGET REVISI DEPT -----------------------//
    function get_total_all_budget_revisi($tahun, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_budget = $bgt_aii->query("SELECT SUM(MON_REV01BLN01+MON_REV01BLN02+MON_REV01BLN03+MON_REV01BLN04+MON_REV01BLN05+MON_REV01BLN06+MON_REV01BLN07+MON_REV01BLN08+MON_REV01BLN09+MON_REV01BLN10+MON_REV01BLN11+MON_REV01BLN12) AS TOT_BGTREV
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         --AND CHR_FLG_CANCEL = '0' 
                                                         --AND CHR_FLG_UNBUDGET = '0'
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_budget;
        } else if($budget_type == 'CONSU') {
            $awal = $tahun . '0401';
            $akhir = $tahun . '0931';
            $total_budget = $bgt_aii->query("SELECT SUM(TOT_BGTREV) AS TOT_BGTREV
                                            FROM 
                                            (SELECT CHR_KODE_DEPARTMENT, SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTREV
                                            FROM BDGT_TM_BUDGET_CONSUMABLE 
                                            WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                 AND CHR_TAHUN_BUDGET = '$tahun'
                                                 AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                 --AND CHR_FLG_DELETE = '0' 
                                                 AND CHR_FLG_UNBUDGET = '0' 
                                                 AND CHR_FLG_CIP = '0'
                                                 AND CHR_FLG_REV = '1'
                                            GROUP BY CHR_KODE_DEPARTMENT
                                            UNION   
                                            SELECT CHR_BDGT_DEPT AS CHR_KODE_DEPARTMENT, ISNULL(SUM(DMBTR),0) AS TOT_BGTREV
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$awal' AND '$akhir') 
                                                  AND (CHR_BDGT_DEPT = '$kode_dept') 
                                            GROUP BY CHR_BDGT_DEPT) AS SUMMARY_REV")->row();
            return $total_budget;
        } else {
            $awal = $tahun . '0401';
            $akhir = $tahun . '0931';
            $total_budget = $bgt_aii->query("SELECT SUM(TOT_BGTREV) AS TOT_BGTREV
                                            FROM 
                                            (SELECT CHR_KODE_DEPARTMENT, SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTREV
                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                            WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                 AND CHR_TAHUN_BUDGET = '$tahun'
                                                 AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                 --AND CHR_FLG_DELETE = '0' 
                                                 AND CHR_FLG_UNBUDGET = '0' 
                                                 AND CHR_FLG_CIP = '0'
                                                 AND CHR_FLG_REV = '1'
                                            GROUP BY CHR_KODE_DEPARTMENT
                                            UNION   
                                            SELECT CHR_BDGT_DEPT AS CHR_KODE_DEPARTMENT, ISNULL(SUM(DMBTR),0) AS TOT_BGTREV
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$awal' AND '$akhir') 
                                                  AND (CHR_BDGT_DEPT = '$kode_dept') 
                                            GROUP BY CHR_BDGT_DEPT) AS SUMMARY_REV")->row();
            return $total_budget;
        }
    }
    
    //--------------------- TOTAL BUDGET PLAN DETAIL -------------------------//
    function get_total_budget($tahun, $budget_type, $kode_dept, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            if($act_periode < $periode_smt2){
                $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTPLAN
                                                       FROM BDGT_TM_BUDGET_CAPEX 
                                                       WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                             AND CHR_TAHUN_BUDGET = '$tahun'
                                                             AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                             AND CHR_FLG_DELETE = '0' 
                                                             AND CHR_FLG_UNBUDGET = '0' 
                                                             AND CHR_FLG_CIP = '0' 
                                                             AND CHR_FLG_FOR_AIIA = '0'")->row();
                return $total_budget;
            } else {
                $total_budget = $bgt_aii->query("SELECT SUM(MON_REV01BLN01+MON_REV01BLN02+MON_REV01BLN03+MON_REV01BLN04+MON_REV01BLN05+MON_REV01BLN06+MON_REV01BLN07+MON_REV01BLN08+MON_REV01BLN09+MON_REV01BLN10+MON_REV01BLN11+MON_REV01BLN12) AS TOT_BGTPLAN
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         --AND CHR_FLG_CANCEL = '0' 
                                                         AND CHR_FLG_UNBUDGET = '0' 
                                                         AND CHR_FLG_CIP = '0' 
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
                return $total_budget;
            }
        } else if($budget_type == 'CONSU') {
            $awal = $tahun . '0401';
            $akhir = $tahun . '0931';
            if($act_periode < $periode_smt2){
                $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTPLAN
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                       WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                             AND CHR_TAHUN_BUDGET = '$tahun'
                                                             AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                             --AND CHR_FLG_DELETE = '0' 
                                                             --AND CHR_FLG_CANCEL = '0'
                                                             AND CHR_FLG_REV = '0'
                                                             AND CHR_FLG_UNBUDGET = '0' 
                                                             AND CHR_FLG_CIP = '0'")->row();
                return $total_budget;
            } else {
                $total_budget = $bgt_aii->query("SELECT SUM(ISNULL(A.TOT_BGTREV,0)+ISNULL(B.TOT_BGTGR,0)) AS TOT_BGTPLAN
                                            FROM 
                                            ((SELECT CHR_KODE_DEPARTMENT, SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTREV
                                            FROM BDGT_TM_BUDGET_CONSUMABLE 
                                            WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                 AND CHR_TAHUN_BUDGET = '$tahun'
                                                 AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                 --AND CHR_FLG_DELETE = '0' 
                                                 AND CHR_FLG_UNBUDGET = '0' 
                                                 AND CHR_FLG_CIP = '0'
                                                 AND CHR_FLG_REV = '1'
                                            GROUP BY CHR_KODE_DEPARTMENT) AS A
                                            LEFT JOIN   
                                            (SELECT CHR_BDGT_DEPT, ISNULL(SUM(DMBTR),0) AS TOT_BGTGR
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$awal' AND '$akhir') 
                                                  AND (CHR_BDGT_DEPT = '$kode_dept') 
                                            GROUP BY CHR_BDGT_DEPT) AS B ON A.CHR_KODE_DEPARTMENT = B.CHR_BDGT_DEPT)")->row();
                return $total_budget;
            }
        } else {
            $awal = $tahun . '0401';
            $akhir = $tahun . '0931';
            if($act_periode < $periode_smt2){
                $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTPLAN
                                                       FROM BDGT_TM_BUDGET_EXPENSE 
                                                       WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                             AND CHR_TAHUN_BUDGET = '$tahun'
                                                             AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                             --AND CHR_FLG_DELETE = '0' 
                                                             --AND CHR_FLG_CANCEL = '0'
                                                             AND CHR_FLG_REV = '0'
                                                             AND CHR_FLG_UNBUDGET = '0' 
                                                             AND CHR_FLG_CIP = '0'")->row();
                return $total_budget;
            } else {
                $total_budget = $bgt_aii->query("SELECT SUM(ISNULL(A.TOT_BGTREV,0)+ISNULL(B.TOT_BGTGR,0)) AS TOT_BGTPLAN
                                            FROM 
                                            ((SELECT CHR_KODE_DEPARTMENT, SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTREV
                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                            WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                 AND CHR_TAHUN_BUDGET = '$tahun'
                                                 AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                 --AND CHR_FLG_DELETE = '0' 
                                                 AND CHR_FLG_UNBUDGET = '0' 
                                                 AND CHR_FLG_CIP = '0'
                                                 AND CHR_FLG_REV = '1'
                                            GROUP BY CHR_KODE_DEPARTMENT) AS A
                                            LEFT JOIN   
                                            (SELECT CHR_BDGT_DEPT, ISNULL(SUM(DMBTR),0) AS TOT_BGTGR
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$awal' AND '$akhir') 
                                                  AND (CHR_BDGT_DEPT = '$kode_dept') 
                                            GROUP BY CHR_BDGT_DEPT) AS B ON A.CHR_KODE_DEPARTMENT = B.CHR_BDGT_DEPT)")->row();
                return $total_budget;
            }
        }
    }
    
    function get_total_unbudget($tahun, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_unbudget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_UNBUDGET
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_UNBUDGET = '1' 
                                                         AND CHR_FLG_CIP = '0' 
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_unbudget;
        } else if($budget_type == 'CONSU') {
            $total_unbudget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_UNBUDGET
                                                   FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_UNBUDGET = '1' 
                                                         AND CHR_FLG_CIP = '0'")->row();
            return $total_unbudget;
        } else {
            $total_unbudget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_UNBUDGET
                                                   FROM BDGT_TM_BUDGET_EXPENSE 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_UNBUDGET = '1' 
                                                         AND CHR_FLG_CIP = '0'")->row();
            return $total_unbudget;
        }
    }
    
    function get_total_cip($tahun, $budget_type, $kode_dept, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            if($act_periode < $periode_smt2){
                $total_cip = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_CIPPLAN
                                                       FROM BDGT_TM_BUDGET_CAPEX 
                                                       WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                             AND CHR_TAHUN_BUDGET = '$tahun'
                                                             AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                             AND CHR_FLG_DELETE = '0' 
                                                             AND CHR_FLG_UNBUDGET = '0' 
                                                             AND CHR_FLG_CIP = '1' 
                                                             AND CHR_FLG_FOR_AIIA = '0'")->row();
                return $total_cip;
            } else {
                $total_cip = $bgt_aii->query("SELECT SUM(MON_REV01BLN01+MON_REV01BLN02+MON_REV01BLN03+MON_REV01BLN04+MON_REV01BLN05+MON_REV01BLN06+MON_REV01BLN07+MON_REV01BLN08+MON_REV01BLN09+MON_REV01BLN10+MON_REV01BLN11+MON_REV01BLN12) AS TOT_CIPPLAN
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_UNBUDGET = '0' 
                                                         AND CHR_FLG_CIP = '1' 
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
                return $total_cip;
            }
        } else if($budget_type == 'CONSU') {
            $total_cip = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_CIPPLAN
                                                   FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                         --AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_REV = '0'
                                                         AND CHR_FLG_UNBUDGET = '0' 
                                                         AND CHR_FLG_CIP = '1'")->row();
            return $total_cip;
        } else {
            $total_cip = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_CIPPLAN
                                                   FROM BDGT_TM_BUDGET_EXPENSE 
                                                   WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                         --AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_REV = '0'
                                                         AND CHR_FLG_UNBUDGET = '0' 
                                                         AND CHR_FLG_CIP = '1'")->row();
            return $total_cip;
        }
    }
    
    //-------------------- TOTAL AMOUNT REALISASI ----------------------------//
    function get_total_budget_real($tahun, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_budget_real = $bgt_aii->query("SELECT SUM(A.MON_TOTAL_PRICE_SUPPLIER) AS TOT_BUDGET_REAL 
                                                    FROM BDGT_TT_BUDGET_PR_DETAIL AS A
                                                    LEFT JOIN BDGT_TT_BUDGET_PR_HEADER AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                                    LEFT JOIN BDGT_TM_BUDGET_CAPEX AS C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                                    WHERE C.CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                          AND C.CHR_TAHUN_BUDGET = '$tahun'
                                                          AND C.CHR_KODE_DEPARTMENT = '$kode_dept'
                                                          AND B.CHR_FLG_APPROVE_MAN = '1'
                                                          AND C.CHR_FLG_DELETE = '0' 
                                                          AND C.CHR_FLG_CIP = '0'
                                                          AND C.CHR_FLG_UNBUDGET = '0' 
                                                          AND C.CHR_FLG_DELETE = '0' 
                                                          AND C.CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_budget_real;
        } else {
            $total_budget_real = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS TOT_BUDGET_REAL
                                                    FROM BDGT_TT_BUDGET_PR_DETAIL AS A 
                                                    LEFT JOIN BDGT_TT_BUDGET_PR_HEADER AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI 
                                                    LEFT JOIN BDGT_TM_BUDGET_EXPENSE AS C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET 
                                                    WHERE (C.CHR_TAHUN_BUDGET = '$tahun') 
                                                            AND (C.CHR_TAHUN_ACTUAL = '$tahun') 
                                                            AND (C.CHR_FLG_CIP = '0') 
                                                            AND (C.CHR_FLG_UNBUDGET = '0') 
                                                            --AND (C.CHR_FLG_DELETE = '0') 
                                                            AND (C.CHR_KODE_DEPARTMENT = '$kode_dept') 
                                                            AND (C.CHR_KODE_TYPE_BUDGET = '$budget_type')
                                                            AND (B.CHR_FLG_APPROVE_MAN = '1')")->row();
            return $total_budget_real;
        }
    }
    
    function get_total_unbudget_real($tahun, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_unbudget_real = $bgt_aii->query("SELECT SUM(A.MON_TOTAL_PRICE_SUPPLIER) AS TOT_UNBUDGET_REAL 
                                                    FROM BDGT_TT_BUDGET_PR_DETAIL AS A
                                                    LEFT JOIN BDGT_TT_BUDGET_PR_HEADER AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                                    LEFT JOIN BDGT_TM_BUDGET_CAPEX AS C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                                    WHERE C.CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                          AND C.CHR_TAHUN_BUDGET = '$tahun'
                                                          AND C.CHR_KODE_DEPARTMENT = '$kode_dept'
                                                          AND B.CHR_FLG_APPROVE_MAN = '1'
                                                          AND C.CHR_FLG_DELETE = '0' 
                                                          AND C.CHR_FLG_CIP = '0'
                                                          AND C.CHR_FLG_UNBUDGET = '1' 
                                                          AND C.CHR_FLG_DELETE = '0' 
                                                          AND C.CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_unbudget_real;
        } else {
            $total_unbudget_real = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS TOT_UNBUDGET_REAL
                                                    FROM BDGT_TT_BUDGET_PR_DETAIL AS A 
                                                    LEFT JOIN BDGT_TT_BUDGET_PR_HEADER AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI 
                                                    LEFT JOIN BDGT_TM_BUDGET_EXPENSE AS C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET 
                                                    WHERE (C.CHR_TAHUN_BUDGET = '$tahun') 
                                                            AND (C.CHR_TAHUN_ACTUAL = '$tahun') 
                                                            AND (C.CHR_FLG_CIP = '0') 
                                                            AND (C.CHR_FLG_UNBUDGET = '1') 
                                                            AND (C.CHR_FLG_DELETE = '0') 
                                                            AND (C.CHR_KODE_DEPARTMENT = '$kode_dept') 
                                                            AND (C.CHR_KODE_TYPE_BUDGET = '$budget_type')
                                                            AND (B.CHR_FLG_APPROVE_MAN = '1')")->row();
            return $total_unbudget_real;
        }
    }
    
    function get_total_cip_real($tahun, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_cip_real = $bgt_aii->query("SELECT SUM(A.MON_TOTAL_PRICE_SUPPLIER) AS TOT_CIP_REAL 
                                                    FROM BDGT_TT_BUDGET_PR_DETAIL AS A
                                                    LEFT JOIN BDGT_TT_BUDGET_PR_HEADER AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                                    LEFT JOIN BDGT_TM_BUDGET_CAPEX AS C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET
                                                    WHERE C.CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                          AND C.CHR_TAHUN_BUDGET = '$tahun'
                                                          AND C.CHR_KODE_DEPARTMENT = '$kode_dept'
                                                          AND B.CHR_FLG_APPROVE_MAN = '1'
                                                          AND C.CHR_FLG_DELETE = '0' 
                                                          AND C.CHR_FLG_CIP = '1'
                                                          AND C.CHR_FLG_UNBUDGET = '0' 
                                                          AND C.CHR_FLG_DELETE = '0' 
                                                          AND C.CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_cip_real;
        } else {
            $total_cip_real = $bgt_aii->query("SELECT SUM(MON_TOTAL_PRICE_SUPPLIER) AS TOT_CIP_REAL
                                                    FROM BDGT_TT_BUDGET_PR_DETAIL AS A 
                                                    LEFT JOIN BDGT_TT_BUDGET_PR_HEADER AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI 
                                                    LEFT JOIN BDGT_TM_BUDGET_EXPENSE AS C ON A.CHR_NO_BUDGET = C.CHR_NO_BUDGET 
                                                    WHERE (C.CHR_TAHUN_BUDGET = '$tahun') 
                                                            AND (C.CHR_TAHUN_ACTUAL = '$tahun') 
                                                            AND (C.CHR_FLG_CIP = '1') 
                                                            AND (C.CHR_FLG_UNBUDGET = '0') 
                                                            --AND (C.CHR_FLG_DELETE = '0') 
                                                            AND (C.CHR_KODE_DEPARTMENT = '$kode_dept') 
                                                            AND (C.CHR_KODE_TYPE_BUDGET = '$budget_type')
                                                            AND (B.CHR_FLG_APPROVE_MAN = '1')")->row();
            return $total_cip_real;
        }
    }
    
    //------------------ TOTAL BUDGET PLANT --------------------------//
    function get_total_budget_plant($tahun, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BUDGET_PLANT
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_UNBUDGET = '0'
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_budget;
        } else if ($budget_type == 'CONSU'){
            $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BUDGET_PLANT
                                               FROM BDGT_TM_BUDGET_CONSUMABLE 
                                               WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                     AND CHR_TAHUN_BUDGET = '$tahun'
                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                     --AND CHR_FLG_DELETE = '0'
                                                     AND CHR_FLG_REV = '0'
                                                     AND CHR_FLG_UNBUDGET = '0'")->row();
            return $total_budget;
        } else {
            $total_budget = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BUDGET_PLANT
                                               FROM BDGT_TM_BUDGET_EXPENSE 
                                               WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                     AND CHR_TAHUN_BUDGET = '$tahun'
                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                     --AND CHR_FLG_DELETE = '0'
                                                     AND CHR_FLG_REV = '0'
                                                     AND CHR_FLG_UNBUDGET = '0'")->row();
            return $total_budget;
        }
    }
    
    //------------------ TOTAL BUDGET PLANT --------------------------//
    function get_total_budget_revisi_plant($tahun, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_budget_group = $bgt_aii->query("SELECT SUM(MON_REV01BLN01+MON_REV01BLN02+MON_REV01BLN03+MON_REV01BLN04+MON_REV01BLN05+MON_REV01BLN06+MON_REV01BLN07+MON_REV01BLN08+MON_REV01BLN09+MON_REV01BLN10+MON_REV01BLN11+MON_REV01BLN12) AS TOT_BGTREV
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0'
                                                         --AND CHR_FLG_CANCEL = '0'
                                                         --AND CHR_FLG_UNBUDGET = '0' 
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_budget_group;
        } else if ($budget_type == 'CONSU'){
            $awal = $tahun . '0401';
            $akhir = $tahun . '0931';
            $total_budget_plant = $bgt_aii->query("SELECT SUM(TOT_BGTREV) AS TOT_BGTREV
                                            FROM 
                                            (SELECT CHR_KODE_DEPARTMENT, SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTREV
                                            FROM BDGT_TM_BUDGET_CONSUMABLE
                                            WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                 AND CHR_TAHUN_BUDGET = '$tahun'
                                                 AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                 --AND CHR_FLG_DELETE = '0' 
                                                 AND CHR_FLG_UNBUDGET = '0' 
                                                 AND CHR_FLG_CIP = '0'
                                                 AND CHR_FLG_REV = '1'
                                            GROUP BY CHR_KODE_DEPARTMENT
                                            UNION   
                                            SELECT CHR_BDGT_DEPT AS CHR_KODE_DEPARTMENT, ISNULL(SUM(DMBTR),0) AS TOT_BGTREV
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$awal' AND '$akhir') 
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')) 
                                            GROUP BY CHR_BDGT_DEPT) AS SUMMARY_REV")->row();
            return $total_budget_plant;
        } else {
            $awal = $tahun . '0401';
            $akhir = $tahun . '0931';
            $total_budget_plant = $bgt_aii->query("SELECT SUM(TOT_BGTREV) AS TOT_BGTREV
                                            FROM 
                                            (SELECT CHR_KODE_DEPARTMENT, SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTREV
                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                            WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                 AND CHR_TAHUN_BUDGET = '$tahun'
                                                 AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                 --AND CHR_FLG_DELETE = '0' 
                                                 AND CHR_FLG_UNBUDGET = '0' 
                                                 AND CHR_FLG_CIP = '0'
                                                 AND CHR_FLG_REV = '1'
                                            GROUP BY CHR_KODE_DEPARTMENT
                                            UNION   
                                            SELECT CHR_BDGT_DEPT AS CHR_KODE_DEPARTMENT, ISNULL(SUM(DMBTR),0) AS TOT_BGTREV
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$awal' AND '$akhir') 
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')) 
                                            GROUP BY CHR_BDGT_DEPT) AS SUMMARY_REV")->row();
            return $total_budget_plant;
        }
    }


    //------------------ TOTAL BUDGET GROUP --------------------------//
    function get_total_budget_group($tahun, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_budget_group = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BUDGET_GROUP
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_GROUP = '$kode_group'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         AND CHR_FLG_UNBUDGET = '0' 
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_budget_group;
        } else if ($budget_type == 'CONSU'){
            $total_budget_group = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BUDGET_GROUP
                                               FROM BDGT_TM_BUDGET_CONSUMABLE 
                                               WHERE CHR_KODE_GROUP = '$kode_group'
                                                     AND CHR_TAHUN_BUDGET = '$tahun'
                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                     --AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_REV = '0'
                                                     AND CHR_FLG_UNBUDGET = '0'")->row();
            return $total_budget_group;
        } else {
            $total_budget_group = $bgt_aii->query("SELECT SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BUDGET_GROUP
                                               FROM BDGT_TM_BUDGET_EXPENSE 
                                               WHERE CHR_KODE_GROUP = '$kode_group'
                                                     AND CHR_TAHUN_BUDGET = '$tahun'
                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                     --AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_REV = '0'
                                                     AND CHR_FLG_UNBUDGET = '0'")->row();
            return $total_budget_group;
        }
    }
    
    //------------------ TOTAL BUDGET GROUP --------------------------//
    function get_total_budget_revisi_group($tahun, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_budget_group = $bgt_aii->query("SELECT SUM(MON_REV01BLN01+MON_REV01BLN02+MON_REV01BLN03+MON_REV01BLN04+MON_REV01BLN05+MON_REV01BLN06+MON_REV01BLN07+MON_REV01BLN08+MON_REV01BLN09+MON_REV01BLN10+MON_REV01BLN11+MON_REV01BLN12) AS TOT_BGTREV
                                                   FROM BDGT_TM_BUDGET_CAPEX 
                                                   WHERE CHR_KODE_GROUP = '$kode_group'
                                                         AND CHR_TAHUN_BUDGET = '$tahun'
                                                         AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                         AND CHR_FLG_DELETE = '0' 
                                                         --AND CHR_FLG_CANCEL = '0'
                                                         --AND CHR_FLG_UNBUDGET = '0' 
                                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_budget_group;
        } else if ($budget_type == 'CONSU'){
            $awal = $tahun . '0401';
            $akhir = $tahun . '0931';
            $total_budget_group = $bgt_aii->query("SELECT SUM(TOT_BGTREV) AS TOT_BGTREV
                                            FROM 
                                            ((SELECT CHR_KODE_DEPARTMENT, SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTREV
                                            FROM BDGT_TM_BUDGET_CONSUMABLE
                                            WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group')
                                                 AND CHR_TAHUN_BUDGET = '$tahun'
                                                 AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                 --AND CHR_FLG_DELETE = '0' 
                                                 AND CHR_FLG_UNBUDGET = '0' 
                                                 AND CHR_FLG_CIP = '0'
                                                 AND CHR_FLG_REV = '1'
                                            GROUP BY CHR_KODE_DEPARTMENT
                                            UNION   
                                            SELECT CHR_BDGT_DEPT AS CHR_KODE_DEPARTMENT, ISNULL(SUM(DMBTR),0) AS TOT_BGTREV
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$awal' AND '$akhir') 
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group')) 
                                            GROUP BY CHR_BDGT_DEPT)) AS SUMMARY_REV")->row();
            return $total_budget_group;
        } else {
            $awal = $tahun . '0401';
            $akhir = $tahun . '0931';
            $total_budget_group = $bgt_aii->query("SELECT SUM(TOT_BGTREV) AS TOT_BGTREV
                                            FROM 
                                            ((SELECT CHR_KODE_DEPARTMENT, SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_BGTREV
                                            FROM BDGT_TM_BUDGET_EXPENSE 
                                            WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group')
                                                 AND CHR_TAHUN_BUDGET = '$tahun'
                                                 AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                 --AND CHR_FLG_DELETE = '0' 
                                                 AND CHR_FLG_UNBUDGET = '0' 
                                                 AND CHR_FLG_CIP = '0'
                                                 AND CHR_FLG_REV = '1'
                                            GROUP BY CHR_KODE_DEPARTMENT
                                            UNION   
                                            SELECT CHR_BDGT_DEPT AS CHR_KODE_DEPARTMENT, ISNULL(SUM(DMBTR),0) AS TOT_BGTREV
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$awal' AND '$akhir') 
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group')) 
                                            GROUP BY CHR_BDGT_DEPT)) AS SUMMARY_REV")->row();
            return $total_budget_group;
        }
    }
    
    //---------------- TOTAL REALISASI BY ANU UPDATE 04/07/2017 --------------//
    //----------------------- TOTAL REALISASI PLANT --------------------------//
    function get_new_total_real_plant($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_real_plant = $bgt_aii->query("SELECT SUM(MON_OPRBLN01+MON_OPRBLN02+MON_OPRBLN03+MON_OPRBLN04+MON_OPRBLN05+MON_OPRBLN06+MON_OPRBLN07+MON_OPRBLN08+MON_OPRBLN09+MON_OPRBLN10+MON_OPRBLN11+MON_OPRBLN12) AS TOT_REAL_PLANT
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_real_plant;
        } else if ($budget_type == 'CONSU'){
            $total_real_plant = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_REAL_PLANT
                                          FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                 ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                 ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                 ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                 ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                 ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                 ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                                 ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                          FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01 AS OPRBLN01, MON_OPRBLN02 AS OPRBLN02, 
                                                     MON_OPRBLN03 AS OPRBLN03, MON_OPRBLN04 AS OPRBLN04, 
                                                     MON_OPRBLN05 AS OPRBLN05, MON_OPRBLN06 AS OPRBLN06, 
                                                     MON_OPRBLN07 AS OPRBLN07, MON_OPRBLN08 AS OPRBLN08, 
                                                     MON_OPRBLN09 AS OPRBLN09, MON_OPRBLN10 AS OPRBLN10, 
                                                     MON_OPRBLN11 AS OPRBLN11, MON_OPRBLN12 AS OPRBLN12
                                                     --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_CONSUMABLE
                                                 WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0' 
                                                      ) ACTUAL_CURR_YEAR
                                          LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                            MON_OPRBLN01 AS OPRBLN13, 
                                                            MON_OPRBLN02 AS OPRBLN14, 
                                                            MON_OPRBLN03 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_CONSUMABLE
                                                 WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_plant;
        } else {
            $total_real_plant = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_REAL_PLANT
                                          FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                                 ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                                 ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                                 ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                                 ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                                 ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                                 ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                                 ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                          FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01 AS OPRBLN01, MON_OPRBLN02 AS OPRBLN02, 
                                                     MON_OPRBLN03 AS OPRBLN03, MON_OPRBLN04 AS OPRBLN04, 
                                                     MON_OPRBLN05 AS OPRBLN05, MON_OPRBLN06 AS OPRBLN06, 
                                                     MON_OPRBLN07 AS OPRBLN07, MON_OPRBLN08 AS OPRBLN08, 
                                                     MON_OPRBLN09 AS OPRBLN09, MON_OPRBLN10 AS OPRBLN10, 
                                                     MON_OPRBLN11 AS OPRBLN11, MON_OPRBLN12 AS OPRBLN12
                                                     --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_EXPENSE
                                                 WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0' 
                                                      ) ACTUAL_CURR_YEAR
                                          LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                            MON_OPRBLN01 AS OPRBLN13, 
                                                            MON_OPRBLN02 AS OPRBLN14, 
                                                            MON_OPRBLN03 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_EXPENSE
                                                 WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_plant;
        }
    }
    
    //---------------------- TOTAL REALISASI GROUP --------------------------//
    function get_new_total_real_group($tahun, $year_start, $year_end, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_real_group = $bgt_aii->query("SELECT SUM(MON_OPRBLN01_GM+MON_OPRBLN02_GM+MON_OPRBLN03_GM+MON_OPRBLN04_GM+MON_OPRBLN05_GM+MON_OPRBLN06_GM+MON_OPRBLN07_GM+MON_OPRBLN08_GM+MON_OPRBLN09_GM+MON_OPRBLN10_GM+MON_OPRBLN11_GM+MON_OPRBLN12_GM) AS TOT_REAL_GROUP
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_GROUP = '$kode_group'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_real_group;
        } else {
            $total_real_group = $bgt_aii->query("SELECT (OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_REAL_GROUP
                                          FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
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
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_group;
        }
    }
    
    //------------------------ TOTAL REALISASI BY DEPT -----------------------//
    function get_new_total_real_dept($tahun, $year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_real_dept = $bgt_aii->query("SELECT SUM(MON_OPRBLN01_MAN+MON_OPRBLN02_MAN+MON_OPRBLN03_MAN+MON_OPRBLN04_MAN+MON_OPRBLN05_MAN+MON_OPRBLN06_MAN+MON_OPRBLN07_MAN+MON_OPRBLN08_MAN+MON_OPRBLN09_MAN+MON_OPRBLN10_MAN+MON_OPRBLN11_MAN+MON_OPRBLN12_MAN) AS TOT_REAL_DEPT
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_real_dept;
        } else {
            $total_real_dept = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_REAL_DEPT
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_dept;
        }
    }
    //------------------------ END UPDATE REALISASI --------------------------//
    
    //------------------------ DETAIL BUDGET PER MONTH -----------------------//
    function get_budget_detail($year_start, $year_end, $budget_type, $kode_dept){
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
                                                FROM BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$year_start'
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
                                                                    MON_BLN10 AS MON_BLN10,MON_BLN11 AS MON_BLN11,MON_BLN12 AS MON_BLN12 
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
                                            FROM(SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15 
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$year_start' 
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
    
    //--------------------- DETAIL UNBUDGET PER MONTH --------------------//
    function get_unbudget_detail($year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $unbudget = $bgt_aii->query("SELECT SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
                                                       SUM(PBLN04) AS PBLN04,SUM(PBLN05) AS PBLN05,SUM(PBLN06) AS PBLN06,
                                                       SUM(PBLN07) AS PBLN07,SUM(PBLN08) AS PBLN08,SUM(PBLN09) AS PBLN09,
                                                       SUM(PBLN10) AS PBLN10,SUM(PBLN11) AS PBLN11,SUM(PBLN12) AS PBLN12,
                                                       SUM(PBLN13) AS PBLN13,SUM(PBLN14) AS PBLN14,SUM(PBLN15) AS PBLN15 
                                            FROM(SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                        ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                        ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15 
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                       AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '1') AS BDGT_TM_UNBUDGET_CAPEX")->row();
            return $unbudget;
        } else {
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
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
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$year_start' 
                                                        AND CHR_TAHUN_ACTUAL = '$year_end' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
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
                                          FROM (SELECT CHR_NO_BUDGET, 
                                                     0 AS OPRBLN01, 0 AS OPRBLN02, 0 AS OPRBLN03, 
                                                     MON_OPRBLN04 AS OPRBLN04, MON_OPRBLN05 AS OPRBLN05, MON_OPRBLN06 AS OPRBLN06, 
                                                     MON_OPRBLN07 AS OPRBLN07, MON_OPRBLN08 AS OPRBLN08, MON_OPRBLN09 AS OPRBLN09, 
                                                     MON_OPRBLN10 AS OPRBLN10, MON_OPRBLN11 AS OPRBLN11, MON_OPRBLN12 AS OPRBLN12,
                                                     MON_OPRBLN01 AS OPRBLN13, MON_OPRBLN02 AS OPRBLN14, MON_OPRBLN03 AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$year_start'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0') AS CAPEX")->row();
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
    
    //----------------- DETAIL BUDGET PER MONTH BY NO BUDGET -----------------//
    function get_budget_detail_by_no($budget_type, $budget_no){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT CHR_NO_BUDGET, CHR_DESC_BUDGET, 
                                                       MON_BLN01 AS JAN, MON_BLN02 AS FEB, 
                                                       MON_BLN03 AS MAR, MON_BLN04 AS APR, 
                                                       MON_BLN05 AS MEI, MON_BLN06 AS JUN, 
                                                       MON_BLN07 AS JUL, MON_BLN08 AS AGU, 
                                                       MON_BLN09 AS SEP, MON_BLN10 AS OKT, 
                                                       MON_BLN11 AS NOV, MON_BLN12 AS DES
                                            FROM BDGT_TM_BUDGET_CAPEX
                                            WHERE CHR_NO_BUDGET = '$budget_no'
                                                  AND CHR_FLG_DELETE = '0'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("SELECT CHR_NO_BUDGET, CHR_KODE_ITEM AS CHR_DESC_BUDGET, 
                                                       MON_BLN01 AS JAN, MON_BLN02 AS FEB, 
                                                       MON_BLN03 AS MAR, MON_BLN04 AS APR, 
                                                       MON_BLN05 AS MEI, MON_BLN06 AS JUN, 
                                                       MON_BLN07 AS JUL, MON_BLN08 AS AGU, 
                                                       MON_BLN09 AS SEP, MON_BLN10 AS OKT, 
                                                       MON_BLN11 AS NOV, MON_BLN12 AS DES
                                            FROM BDGT_TM_BUDGET_EXPENSE
                                            WHERE CHR_NO_BUDGET = '$budget_no'
                                                  AND CHR_FLG_DELETE = '0'")->row();
            return $budget_detail;
        }
    }
    
    //---------------- DETAIL ACTUAL PER MONTH BY NO BUDGET ------------------//
    function get_actual_detail_by_bgtno($budget_type, $budget_no){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_real = $bgt_aii->query("SELECT CHR_NO_BUDGET, 
                                                   SUM(MON_OPRBLN01) AS JAN, SUM(MON_OPRBLN02) AS FEB, 
                                                   SUM(MON_OPRBLN03) AS MAR, SUM(MON_OPRBLN04) AS APR, 
                                                   SUM(MON_OPRBLN05) AS MEI, SUM(MON_OPRBLN06) AS JUN, 
                                                   SUM(MON_OPRBLN07) AS JUL, SUM(MON_OPRBLN08) AS AGU, 
                                                   SUM(MON_OPRBLN09) AS SEP, SUM(MON_OPRBLN10) AS OKT, 
                                                   SUM(MON_OPRBLN11) AS NOV, SUM(MON_OPRBLN12) AS DES
                                            FROM BDGT_TM_BUDGET_CAPEX
                                            WHERE CHR_NO_BUDGET = '$budget_no'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_UNBUDGET = '0'
                                                  AND CHR_FLG_FOR_AIIA = '0'
                                            GROUP BY CHR_NO_BUDGET")->row();
            return $actual_real;
        } else {
            $actual_real = $bgt_aii->query("SELECT CHR_NO_BUDGET, 
                                                   SUM(MON_OPRBLN01) AS JAN, SUM(MON_OPRBLN02) AS FEB, 
                                                   SUM(MON_OPRBLN03) AS MAR, SUM(MON_OPRBLN04) AS APR, 
                                                   SUM(MON_OPRBLN05) AS MEI, SUM(MON_OPRBLN06) AS JUN, 
                                                   SUM(MON_OPRBLN07) AS JUL, SUM(MON_OPRBLN08) AS AGU, 
                                                   SUM(MON_OPRBLN09) AS SEP, SUM(MON_OPRBLN10) AS OKT, 
                                                   SUM(MON_OPRBLN11) AS NOV, SUM(MON_OPRBLN12) AS DES
                                            FROM BDGT_TM_BUDGET_EXPENSE
                                            WHERE CHR_NO_BUDGET = '$budget_no'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_UNBUDGET = '0'
                                            GROUP BY CHR_NO_BUDGET")->row();
            return $actual_real;
        }
    }    
    
    //---------------- GET LIST MASTER BUDGET REVISION -----------------------//
    function get_list_budget_rev($fiscal_start, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX') {
            $all_budget = $bgt_aii->query("SELECT DISTINCT CHR_NO_BUDGET,
                                                  CHR_DESC_BUDGET
                                       FROM BDGT_TM_BUDGET_CAPEX
                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                         AND CHR_FLG_APPROVAL_PROCESS = '1'
                                         --AND CHR_FLG_CANCEL = '0' 
                                         AND CHR_FLG_DELETE = '0'")->result();
            return $all_budget;
        } else {
            $all_budget = $bgt_aii->query("SELECT DISTINCT CHR_NO_BUDGET,
                                                  CHR_KODE_ITEM
                                       FROM BDGT_TM_BUDGET_EXPENSE
                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                         AND CHR_FLG_APPROVAL_PROCESS = '1' 
                                         --AND CHR_FLG_CANCEL = '0'
                                         AND CHR_FLG_DELETE = '0'")->result();
            return $all_budget;
        }        
    }
    
    //--------------------- GET CURRENT BUDGET PLAN --------------------------//
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
    
    //--------------------- GET REQUEST BUDGET PLAN --------------------------//
    function get_req_detail_budget($fiscal_start, $fiscal_end, $budget_type, $no_budget){
       $bgt_aii = $this->load->database("bgt_aii", TRUE);
       if($budget_type == 'CAPEX'){
           $get_req_budget = $bgt_aii->query("SELECT CHR_FLG_NOTES,
                                                   INT_NO_REVISI,
                                                   CHR_NO_BUDGET,
                                                       MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,
                                                       MON_LIMBLN05,MON_LIMBLN06,MON_LIMBLN07,MON_LIMBLN08,
                                                       MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                       0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15,
                                                       0 AS INT_QTY_LIMBLN01,0 AS INT_QTY_LIMBLN02,0 AS INT_QTY_LIMBLN03,0 AS INT_QTY_LIMBLN04,0 AS INT_QTY_LIMBLN05,0 AS INT_QTY_LIMBLN06,
                                                   0 AS INT_QTY_LIMBLN07,0 AS INT_QTY_LIMBLN08,0 AS INT_QTY_LIMBLN09,0 AS INT_QTY_LIMBLN10,0 AS INT_QTY_LIMBLN11,0 AS INT_QTY_LIMBLN12,
                                                   0 AS INT_QTY_LIMBLN13,0 AS INT_QTY_LIMBLN14,0 AS INT_QTY_LIMBLN15
                                            FROM BDGT_TT_MASTER_CHANGELOG 
                                            WHERE CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                      AND CHR_TAHUN_BUDGET = '$fiscal_start'
                                                      AND CHR_NO_BUDGET = '$no_budget'
                                            UNION
                                            SELECT CHR_FLG_NOTES,
                                                   INT_NO_REVISI,
                                                   CHR_NO_BUDGET,
                                                       0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,0 AS MON_LIMBLN04,
                                                       0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,
                                                       0 AS MON_LIMBLN09,0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                       MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                       0 AS INT_QTY_LIMBLN01,0 AS INT_QTY_LIMBLN02,0 AS INT_QTY_LIMBLN03,0 AS INT_QTY_LIMBLN04,0 AS INT_QTY_LIMBLN05,0 AS INT_QTY_LIMBLN06,
                                                   0 AS INT_QTY_LIMBLN07,0 AS INT_QTY_LIMBLN08,0 AS INT_QTY_LIMBLN09,0 AS INT_QTY_LIMBLN10,0 AS INT_QTY_LIMBLN11,0 AS INT_QTY_LIMBLN12,
                                                   0 AS INT_QTY_LIMBLN13,0 AS INT_QTY_LIMBLN14,0 AS INT_QTY_LIMBLN15
                                            FROM BDGT_TT_MASTER_CHANGELOG
                                            WHERE CHR_TAHUN_ACTUAL = '$fiscal_end'
                                                      AND CHR_TAHUN_BUDGET = '$fiscal_start' 
                                                      AND CHR_NO_BUDGET = '$no_budget'
                                            ORDER BY INT_NO_REVISI DESC")->row();
           return $get_req_budget;
       } else {
           $get_req_budget = $bgt_aii->query("SELECT CHR_TGL_TRANS,
                                                   CHR_FLG_NOTES,
                                                   INT_NO_REVISI,
                                                   BDGT_CURR.CHR_NO_BUDGET AS CHR_NO_BUDGET,
                                                   MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                   MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                   MON_LIMBLN13,MON_LIMBLN14,MON_LIMBLN15,
                                                   INT_QTY_LIMBLN01,INT_QTY_LIMBLN02,INT_QTY_LIMBLN03,INT_QTY_LIMBLN04,INT_QTY_LIMBLN05,INT_QTY_LIMBLN06,
                                                   INT_QTY_LIMBLN07,INT_QTY_LIMBLN08,INT_QTY_LIMBLN09,INT_QTY_LIMBLN10,INT_QTY_LIMBLN11,INT_QTY_LIMBLN12,
                                                   INT_QTY_LIMBLN13,INT_QTY_LIMBLN14,INT_QTY_LIMBLN15
                                            FROM (SELECT CHR_TGL_TRANS,
                                                         CHR_FLG_NOTES,
                                                         INT_NO_REVISI,
                                                         CHR_NO_BUDGET,
                                                         MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                         MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                         INT_QTY_LIMBLN01,INT_QTY_LIMBLN02,INT_QTY_LIMBLN03,INT_QTY_LIMBLN04,INT_QTY_LIMBLN05,INT_QTY_LIMBLN06,
                                                         INT_QTY_LIMBLN07,INT_QTY_LIMBLN08,INT_QTY_LIMBLN09,INT_QTY_LIMBLN10,INT_QTY_LIMBLN11,INT_QTY_LIMBLN12 
                                                  FROM BDGT_TT_MASTER_CHANGELOG 
                                                  WHERE CHR_TAHUN_ACTUAL = '$fiscal_start') BDGT_CURR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15,
                                                              INT_QTY_LIMBLN01 AS INT_QTY_LIMBLN13,INT_QTY_LIMBLN02 AS INT_QTY_LIMBLN14,INT_QTY_LIMBLN03 AS INT_QTY_LIMBLN15 
                                                        FROM BDGT_TT_MASTER_CHANGELOG 
                                                        WHERE CHR_TAHUN_ACTUAL = '$fiscal_end') BDGT_NEXT ON BDGT_CURR.CHR_NO_BUDGET = BDGT_NEXT.CHR_NO_BUDGET
                                            WHERE BDGT_CURR.CHR_NO_BUDGET = '$no_budget'
                                            ORDER BY INT_NO_REVISI DESC")->row();
           return $get_req_budget;
       }
    }
    
    //------------------ GET DETAIL BUDGET PLAN BY DEPT ----------------------//
    function get_detail_plan($fiscal_start, $fiscal_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
           $get_plan = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                           ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                           ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                           ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                           ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                           ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15
                                FROM (SELECT CHR_KODE_DEPARTMENT, 
                                           MON_BLN01,MON_BLN02,MON_BLN03,
                                           MON_BLN04,MON_BLN05,MON_BLN06,
                                           MON_BLN07,MON_BLN08,MON_BLN09,
                                           MON_BLN10,MON_BLN11,MON_BLN12,
                                           0 AS MON_BLN13, 0 AS MON_BLN14, 0 AS MON_BLN15
                                           FROM BDGT_TM_BUDGET_CAPEX
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_UNBUDGET = '0'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_FOR_AIIA = '0'
                                           UNION
                                           SELECT CHR_KODE_DEPARTMENT, 
                                               0 AS MON_BLN01,0 AS MON_BLN02,0 AS MON_BLN03,
                                               0 AS MON_BLN04,0 AS MON_BLN05,0 AS MON_BLN06,
                                               0 AS MON_BLN07,0 AS MON_BLN08,0 AS MON_BLN09,
                                               0 AS MON_BLN10,0 AS MON_BLN11,0 AS MON_BLN12,
                                               MON_BLN01 AS MON_BLN13, MON_BLN02 AS MON_BLN14, MON_BLN03 AS MON_BLN15
                                           FROM BDGT_TM_BUDGET_CAPEX
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_UNBUDGET = '0'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_FOR_AIIA = '0') AS TM_BUDGET_PLAN
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                        GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_plan;
       } else {
           $get_plan = $bgt_aii->query("SELECT DISTINCT CHR_KODE_DEPARTMENT, 
                                           ISNULL(SUM(MON_BLN01),0) AS PBLN01,ISNULL(SUM(MON_BLN02),0) AS PBLN02,ISNULL(SUM(MON_BLN03),0) AS PBLN03,
                                           ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                           ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                           ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                           ISNULL(SUM(MON_BLN13),0) AS PBLN13,ISNULL(SUM(MON_BLN14),0) AS PBLN14,ISNULL(SUM(MON_BLN15),0) AS PBLN15
                                FROM (SELECT CHR_KODE_DEPARTMENT, 
                                           MON_BLN01,MON_BLN02,MON_BLN03,
                                           MON_BLN04,MON_BLN05,MON_BLN06,
                                           MON_BLN07,MON_BLN08,MON_BLN09,
                                           MON_BLN10,MON_BLN11,MON_BLN12,
                                           0 AS MON_BLN13,0 AS MON_BLN14,0 AS MON_BLN15 
                                           FROM BDGT_TM_BUDGET_EXPENSE
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_UNBUDGET = '0'
                                                  AND CHR_FLG_DELETE = '0'
                                       UNION
                                       SELECT CHR_KODE_DEPARTMENT, 
                                           0 AS MON_BLN01,0 AS MON_BLN02,0 AS MON_BLN03,
                                           0 AS MON_BLN04,0 AS MON_BLN05,0 AS MON_BLN06,
                                           0 AS MON_BLN07,0 AS MON_BLN08,0 AS MON_BLN09,
                                           0 AS MON_BLN10,0 AS MON_BLN11,0 AS MON_BLN12,
                                           MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15
                                       FROM BDGT_TM_BUDGET_EXPENSE
                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                              AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                              AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                              AND CHR_FLG_UNBUDGET = '0'
                                              AND CHR_FLG_DELETE = '0') AS TM_BUDGET_PLAN
                                    WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                    GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_plan;
       }
    }
    
    //------------------ GET DETAIL BUDGET REV BY DEPT -----------------------//
    function get_detail_rev1($fiscal_start, $fiscal_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
           $get_rev1 = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                               ISNULL(SUM(MON_REV01BLN01),0) AS PBLN01,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN02,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN03,
                                               ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                               ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                               ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                               ISNULL(SUM(MON_REV01BLN13),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN14),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN15),0) AS PBLN15
                                    FROM (SELECT CHR_KODE_DEPARTMENT, 
                                               MON_REV01BLN01,MON_REV01BLN02,MON_REV01BLN03,
                                               MON_REV01BLN04,MON_REV01BLN05,MON_REV01BLN06,
                                               MON_REV01BLN07,MON_REV01BLN08,MON_REV01BLN09,
                                               MON_REV01BLN10,MON_REV01BLN11,MON_REV01BLN12,
                                               0 AS MON_REV01BLN13, 0 AS MON_REV01BLN14, 0 AS MON_REV01BLN15
                                               FROM BDGT_TM_BUDGET_CAPEX
                                               WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                      AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'
                                                      AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')
                                               UNION
                                               SELECT CHR_KODE_DEPARTMENT, 
                                                   0 AS MON_REV01BLN01,0 AS MON_REV01BLN02,0 AS MON_REV01BLN03,
                                                   0 AS MON_REV01BLN04,0 AS MON_REV01BLN05,0 AS MON_REV01BLN06,
                                                   0 AS MON_REV01BLN07,0 AS MON_REV01BLN08,0 AS MON_REV01BLN09,
                                                   0 AS MON_REV01BLN10,0 AS MON_REV01BLN11,0 AS MON_REV01BLN12,
                                                   MON_REV01BLN01 AS MON_REV01BLN13, MON_REV01BLN02 AS MON_REV01BLN14, MON_REV01BLN03 AS MON_REV01BLN15
                                               FROM BDGT_TM_BUDGET_CAPEX
                                               WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                      AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'
                                                      AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')) AS TM_BUDGET_REV
                                            WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                            GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_rev1;
       } else {
           $get_rev1 = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                           ISNULL(SUM(MON_REV01BLN01),0) AS PBLN01,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN02,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN03,
                                           ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                           ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                           ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                           ISNULL(SUM(MON_REV01BLN13),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN14),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN15),0) AS PBLN15
                                FROM (SELECT CHR_KODE_DEPARTMENT, 
                                           MON_REV01BLN01,MON_REV01BLN02,MON_REV01BLN03,
                                           MON_REV01BLN04,MON_REV01BLN05,MON_REV01BLN06,
                                           MON_REV01BLN07,MON_REV01BLN08,MON_REV01BLN09,
                                           MON_REV01BLN10,MON_REV01BLN11,MON_REV01BLN12,
                                           0 AS MON_REV01BLN13, 0 AS MON_REV01BLN14, 0 AS MON_REV01BLN15
                                           FROM BDGT_TM_BUDGET_EXPENSE
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')
                                       UNION
                                       SELECT CHR_KODE_DEPARTMENT, 
                                           0 AS MON_REV01BLN01,0 AS MON_REV01BLN02,0 AS MON_REV01BLN03,
                                           0 AS MON_REV01BLN04,0 AS MON_REV01BLN05,0 AS MON_REV01BLN06,
                                           0 AS MON_REV01BLN07,0 AS MON_REV01BLN08,0 AS MON_REV01BLN09,
                                           0 AS MON_REV01BLN10,0 AS MON_REV01BLN11,0 AS MON_REV01BLN12,
                                           MON_REV01BLN01 AS MON_REV01BLN13, MON_REV01BLN02 AS MON_REV01BLN14, MON_REV01BLN03 AS MON_REV01BLN15
                                       FROM BDGT_TM_BUDGET_EXPENSE
                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                              AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                              AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                              AND CHR_FLG_DELETE = '0'
                                              AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')) AS TM_BUDGET_REV
                                    WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                    GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_rev1;
       }
    }
    
    //------------------ GET DETAIL BUDGET LIMIT BY DEPT ---------------------//
    function get_detail_limit($fiscal_start, $fiscal_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
           $get_limit = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                           ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                           ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                           ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                           ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                           ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                FROM (SELECT CHR_KODE_DEPARTMENT, 
                                           MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                           MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                           MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                           MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                           0 AS MON_LIMBLN13, 0 AS MON_LIMBLN14, 0 AS MON_LIMBLN15
                                           FROM BDGT_TM_BUDGET_CAPEX
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_UNBUDGET = '0'
                                                  AND CHR_FLG_FOR_AIIA = '0'
                                                  AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')
                                           UNION
                                           SELECT CHR_KODE_DEPARTMENT, 
                                               0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,
                                               0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                               0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                               0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                               MON_LIMBLN01 AS MON_LIMBLN13, MON_LIMBLN02 AS MON_LIMBLN14, MON_LIMBLN03 AS MON_LIMBLN15 
                                           FROM BDGT_TM_BUDGET_CAPEX
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_UNBUDGET = '0'
                                                  AND CHR_FLG_FOR_AIIA = '0'
                                                  AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')) AS TM_BUDGET_LIMIT
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                        GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_limit;
       } else {
           $get_limit = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                               ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                               ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                               ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                               ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                               ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                    FROM (SELECT CHR_KODE_DEPARTMENT, 
                                               MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                               MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                               MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                               MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                               0 AS MON_LIMBLN13, 0 AS MON_LIMBLN14, 0 AS MON_LIMBLN15
                                               FROM BDGT_TM_BUDGET_EXPENSE
                                               WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                      AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')
                                           UNION
                                           SELECT CHR_KODE_DEPARTMENT,
                                               0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,
                                               0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                               0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                               0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                               MON_LIMBLN01 AS MON_LIMBLN13, MON_LIMBLN02 AS MON_LIMBLN14, MON_LIMBLN03 AS MON_LIMBLN15
                                           FROM BDGT_TM_BUDGET_EXPENSE
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                              AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_UNBUDGET = '0'
                                                  AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')) AS TM_BUDGET_LIMIT
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                        GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_limit;
       }
    }
    
    //-------------------- GET DETAIL UNBUDGET BY DEPT -----------------------//
    function get_detail_unbudget($fiscal_start, $fiscal_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
           $get_unbudget = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                           ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                           ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                           ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                           ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                           ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                FROM (SELECT CHR_KODE_DEPARTMENT, 
                                           MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                           MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                           MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                           MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                           0 AS MON_LIMBLN13, 0 AS MON_LIMBLN14, 0 AS MON_LIMBLN15
                                           FROM BDGT_TM_BUDGET_CAPEX
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_UNBUDGET = '1'
                                                  AND CHR_FLG_FOR_AIIA = '0'
                                                  AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')
                                           UNION
                                           SELECT CHR_KODE_DEPARTMENT, 
                                               0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,
                                               0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                               0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                               0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                               MON_LIMBLN01 AS MON_LIMBLN13, MON_LIMBLN02 AS MON_LIMBLN14, MON_LIMBLN03 AS MON_LIMBLN15
                                           FROM BDGT_TM_BUDGET_CAPEX
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_UNBUDGET = '1'
                                                  AND CHR_FLG_FOR_AIIA = '0'
                                                  AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')) AS TM_UNBUDGET
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                        GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_unbudget;
       } else {
           $get_unbudget = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                               ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                               ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                               ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                               ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                               ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                    FROM (SELECT CHR_KODE_DEPARTMENT, 
                                               MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                               MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                               MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                               MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                               0 AS MON_LIMBLN13, 0 AS MON_LIMBLN14, 0 AS MON_LIMBLN15
                                               FROM BDGT_TM_BUDGET_EXPENSE
                                               WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                      AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_UNBUDGET = '1'
                                                      AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')
                                           UNION
                                           SELECT CHR_KODE_DEPARTMENT, 
                                               0 AS MON_LIMBLN01,0 AS MON_LIMBLN02,0 AS MON_LIMBLN03,
                                               0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                               0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                               0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                               MON_LIMBLN01 AS MON_LIMBLN13, MON_LIMBLN02 AS MON_LIMBLN14, MON_LIMBLN03 AS MON_LIMBLN15
                                           FROM BDGT_TM_BUDGET_EXPENSE
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start' 
                                              AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_UNBUDGET = '1'
                                                  AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')) AS TM_UNBUDGET
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                        GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_unbudget;
       }
    }
    
    //------------------ GET DETAIL ACTUAL BY DEPT -----------------------//
    function get_detail_actual($fiscal_start, $fiscal_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == 'CAPEX'){
           $get_act = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                               ISNULL(SUM(MON_OPRBLN01),0) AS PBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS PBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS PBLN03,
                                               ISNULL(SUM(MON_OPRBLN04),0) AS PBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS PBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS PBLN06,
                                               ISNULL(SUM(MON_OPRBLN07),0) AS PBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS PBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS PBLN09,
                                               ISNULL(SUM(MON_OPRBLN10),0) AS PBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS PBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS PBLN12,
                                               ISNULL(SUM(MON_OPRBLN13),0) AS PBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS PBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS PBLN15
                                    FROM (SELECT CHR_KODE_DEPARTMENT, 
                                           MON_OPRBLN01,MON_OPRBLN02,MON_OPRBLN03,
                                           MON_OPRBLN04,MON_OPRBLN05,MON_OPRBLN06,
                                           MON_OPRBLN07,MON_OPRBLN08,MON_OPRBLN09,
                                           MON_OPRBLN10,MON_OPRBLN11,MON_OPRBLN12,
                                           0 AS MON_OPRBLN13, 0 AS MON_OPRBLN14, 0 AS MON_OPRBLN15
                                           FROM BDGT_TM_BUDGET_CAPEX
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_FOR_AIIA = '0'
                                           UNION
                                           SELECT CHR_KODE_DEPARTMENT, 
                                           0 AS MON_OPRBLN01,0 AS MON_OPRBLN02,0 AS MON_OPRBLN03,
                                           0 AS MON_OPRBLN04,0 AS MON_OPRBLN05,0 AS MON_OPRBLN06,
                                           0 AS MON_OPRBLN07,0 AS MON_OPRBLN08,0 AS MON_OPRBLN09,
                                           0 AS MON_OPRBLN10,0 AS MON_OPRBLN11,0 AS MON_OPRBLN12,
                                           MON_OPRBLN01 AS MON_OPRBLN13, MON_OPRBLN02 AS MON_OPRBLN14, MON_OPRBLN03 AS MON_OPRBLN15
                                           FROM BDGT_TM_BUDGET_CAPEX
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_FOR_AIIA = '0') AS TM_BUDGET_ACTUAL
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                        GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_act;
       } else {
           $get_act = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, 
                                           ISNULL(SUM(MON_OPRBLN01),0) AS PBLN01,ISNULL(SUM(MON_OPRBLN02),0) AS PBLN02,ISNULL(SUM(MON_OPRBLN03),0) AS PBLN03,
                                           ISNULL(SUM(MON_OPRBLN04),0) AS PBLN04,ISNULL(SUM(MON_OPRBLN05),0) AS PBLN05,ISNULL(SUM(MON_OPRBLN06),0) AS PBLN06,
                                           ISNULL(SUM(MON_OPRBLN07),0) AS PBLN07,ISNULL(SUM(MON_OPRBLN08),0) AS PBLN08,ISNULL(SUM(MON_OPRBLN09),0) AS PBLN09,
                                           ISNULL(SUM(MON_OPRBLN10),0) AS PBLN10,ISNULL(SUM(MON_OPRBLN11),0) AS PBLN11,ISNULL(SUM(MON_OPRBLN12),0) AS PBLN12,
                                           ISNULL(SUM(MON_OPRBLN13),0) AS PBLN13,ISNULL(SUM(MON_OPRBLN14),0) AS PBLN14,ISNULL(SUM(MON_OPRBLN15),0) AS PBLN15
                                FROM (SELECT CHR_KODE_DEPARTMENT, 
                                           MON_OPRBLN01,MON_OPRBLN02,MON_OPRBLN03,
                                           MON_OPRBLN04,MON_OPRBLN05,MON_OPRBLN06,
                                           MON_OPRBLN07,MON_OPRBLN08,MON_OPRBLN09,
                                           MON_OPRBLN10,MON_OPRBLN11,MON_OPRBLN12,
                                           0 AS MON_OPRBLN13, 0 AS MON_OPRBLN14, 0 AS MON_OPRBLN15
                                           FROM BDGT_TM_BUDGET_EXPENSE
                                           WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                                  AND CHR_TAHUN_ACTUAL = '$fiscal_start' 
                                                  AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                                  AND CHR_FLG_DELETE = '0'
                                                  AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')
                                       UNION
                                       SELECT CHR_KODE_DEPARTMENT, 
                                           0 AS MON_OPRBLN01,0 AS MON_OPRBLN02,0 AS MON_OPRBLN03,
                                           0 AS MON_OPRBLN04,0 AS MON_OPRBLN05,0 AS MON_OPRBLN06,
                                           0 AS MON_OPRBLN07,0 AS MON_OPRBLN08,0 AS MON_OPRBLN09,
                                           0 AS MON_OPRBLN10,0 AS MON_OPRBLN11,0 AS MON_OPRBLN12,
                                           MON_OPRBLN01 AS MON_OPRBLN13, MON_OPRBLN02 AS MON_OPRBLN14, MON_OPRBLN03 AS MON_OPRBLN15
                                       FROM BDGT_TM_BUDGET_EXPENSE
                                       WHERE CHR_TAHUN_BUDGET = '$fiscal_start'
                                              AND CHR_TAHUN_ACTUAL = '$fiscal_end' 
                                              AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                              AND CHR_FLG_DELETE = '0'
                                              AND CHR_FLG_APPROVAL_PROCESS NOT IN ('1','3')) AS TM_BUDGET_ACTUAL
                                    WHERE CHR_KODE_DEPARTMENT = '$kode_dept' 
                                    GROUP BY CHR_KODE_DEPARTMENT")->row();
           return $get_act;
       }
    }
    
    //------------------- NEW APPROVAL BUDGET --------------------------------//
    function get_all_dept(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT")->result();
        return $all_dept;
    }
    
    function get_all_budget($fiscal_start, $kode_dept, $year_act, $month){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_budget = $bgt_aii->query("SELECT CHR_KODE_TYPE_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT,
                                                    SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_PLAN,
                                                    SUM(MON_LIMBLN01+MON_LIMBLN02+MON_LIMBLN03+MON_LIMBLN04+MON_LIMBLN05+MON_LIMBLN06+MON_LIMBLN07+MON_LIMBLN08+MON_LIMBLN09+MON_LIMBLN10+MON_LIMBLN11+MON_LIMBLN12) AS TOT_LIMIT
                                    FROM BDGT_TM_BUDGET_CAPEX A 
                                    WHERE CHR_FLG_APPROVAL_PROCESS = 1 
                                    AND CHR_TAHUN_BUDGET = '$fiscal_start'
                                    AND CHR_TAHUN_ACTUAL = '$year_act' 
                                    AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                    AND MON_LIMBLN$month <> 0
                                    GROUP BY CHR_KODE_TYPE_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT
                                    UNION
                                    SELECT CHR_KODE_TYPE_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT,
                                                    SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_PLAN,
                                                    SUM(MON_LIMBLN01+MON_LIMBLN02+MON_LIMBLN03+MON_LIMBLN04+MON_LIMBLN05+MON_LIMBLN06+MON_LIMBLN07+MON_LIMBLN08+MON_LIMBLN09+MON_LIMBLN10+MON_LIMBLN11+MON_LIMBLN12) AS TOT_LIMIT
                                    FROM BDGT_TM_BUDGET_EXPENSE 
                                    WHERE CHR_FLG_APPROVAL_PROCESS = 1 
                                    AND CHR_TAHUN_BUDGET = '$fiscal_start' 
                                    AND CHR_TAHUN_ACTUAL = '$year_act'
                                    AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                    AND MON_LIMBLN$month <> 0
                                    GROUP BY CHR_KODE_TYPE_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT")->result();
        return $all_budget;
    }
    
    function get_all_detail_budget($fiscal_start, $kode_dept, $budget_type, $year_act, $month){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($budget_type == "CAPEX"){
            $all_budget = $bgt_aii->query("SELECT CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_DESC_BUDGET,
                                                    SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_PLAN,
                                                    SUM(MON_LIMBLN01+MON_LIMBLN02+MON_LIMBLN03+MON_LIMBLN04+MON_LIMBLN05+MON_LIMBLN06+MON_LIMBLN07+MON_LIMBLN08+MON_LIMBLN09+MON_LIMBLN10+MON_LIMBLN11+MON_LIMBLN12) AS TOT_LIMIT
                                    FROM BDGT_TM_BUDGET_CAPEX A 
                                    WHERE CHR_FLG_APPROVAL_PROCESS = 1 
                                        AND CHR_TAHUN_BUDGET = '$fiscal_start'
                                        AND CHR_TAHUN_ACTUAL = '$year_act'
                                        AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND MON_LIMBLN$month <> 0
                                    GROUP BY CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_DESC_BUDGET")->result();
            return $all_budget;
        } else {
            $all_budget = $bgt_aii->query("SELECT CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_ITEM AS CHR_DESC_BUDGET,
                                                    SUM(MON_BLN01+MON_BLN02+MON_BLN03+MON_BLN04+MON_BLN05+MON_BLN06+MON_BLN07+MON_BLN08+MON_BLN09+MON_BLN10+MON_BLN11+MON_BLN12) AS TOT_PLAN,
                                                    SUM(MON_LIMBLN01+MON_LIMBLN02+MON_LIMBLN03+MON_LIMBLN04+MON_LIMBLN05+MON_LIMBLN06+MON_LIMBLN07+MON_LIMBLN08+MON_LIMBLN09+MON_LIMBLN10+MON_LIMBLN11+MON_LIMBLN12) AS TOT_LIMIT
                                    FROM BDGT_TM_BUDGET_EXPENSE A 
                                    WHERE CHR_FLG_APPROVAL_PROCESS = 1 
                                        AND CHR_TAHUN_BUDGET = '$fiscal_start'
                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                        AND CHR_TAHUN_ACTUAL = '$year_act'
                                        AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND MON_LIMBLN$month <> 0
                                    GROUP BY CHR_NO_BUDGET, CHR_TAHUN_BUDGET, CHR_KODE_DEPARTMENT, CHR_KODE_ITEM")->result();
            return $all_budget;
        }        
    }  
    
    //--------------- NEW UPDATE BY ANU 04/07/2017 --- DEPT ------------------//
    //------------------------ DETAIL BUDGET PER MONTH -----------------------//
    function get_new_budget_detail($tahun, $year_start, $year_end, $budget_type, $kode_dept){
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
                                                FROM BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                     AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_UNBUDGET = '0' 
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
                                                WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                      AND CHR_KODE_DEPARTMENT = '$kode_dept' 
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
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0' 
                                                                     AND CHR_FLG_UNBUDGET = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
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
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0' 
                                                                     AND CHR_FLG_UNBUDGET = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_REV = '0'
                                                                AND CHR_FLG_UNBUDGET = '0' ) BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //---------------------- DETAIL BUDGET REV PER MONTH ---------------------//
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
                                         --AND CHR_FLG_CANCEL = '0'
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
    
    //--------------------- DETAIL BUDGET LIMIT PER MONTH --------------------//
    function get_new_budget_limit($tahun, $year_start, $year_end, $budget_type, $kode_dept, $act_periode, $periode_smt2){
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
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
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
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                       AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_limit;
        } else if ($budget_type == 'CONSU'){
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
                                                      FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_CONSUMABLE
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
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
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_DEPARTMENT,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
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
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_EXPENSE 
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
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
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_DEPARTMENT,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
        }
    }
    
    //--------------------- DETAIL UNBUDGET PER MONTH --------------------//
    function get_new_unbudget_detail($tahun, $year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $unbudget = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15
                                            FROM BDGT_TM_BUDGET_CAPEX 
                                            WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '1'")->row();
            return $unbudget;
        } else if ($budget_type == 'CONSU'){
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
        } else {
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                        AND CHR_KODE_DEPARTMENT = '$kode_dept' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
        }
    }
    
    //---------------------- DETAIL ACTUAL PER MONTH ----------------------//
    function get_new_actual_real($tahun, $year_start, $year_end, $budget_type, $kode_dept, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $actual_real = $bgt_aii->query("SELECT TOP 1 CASE WHEN CHR_KODE_DEPARTMENT IS NULL THEN 'TOTAL' ELSE CHR_KODE_DEPARTMENT END AS CHR_KODE_DEPARTMENT,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'04' THEN MON_PR ELSE 0 END) AS OPRBLN04,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'05' THEN MON_PR ELSE 0 END) AS OPRBLN05,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'06' THEN MON_PR ELSE 0 END) AS OPRBLN06,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'07' THEN MON_PR ELSE 0 END) AS OPRBLN07,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'08' THEN MON_PR ELSE 0 END) AS OPRBLN08,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'09' THEN MON_PR ELSE 0 END) AS OPRBLN09,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'10' THEN MON_PR ELSE 0 END) AS OPRBLN10,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'11' THEN MON_PR ELSE 0 END) AS OPRBLN11,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'12' THEN MON_PR ELSE 0 END) AS OPRBLN12,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'01' THEN MON_PR ELSE 0 END) AS OPRBLN13,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'02' THEN MON_PR ELSE 0 END) AS OPRBLN14,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'03' THEN MON_PR ELSE 0 END) AS OPRBLN15,
                                SUM(CASE WHEN CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$year_start'+'04') AND CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$year_end'+'03') THEN MON_PR ELSE 0 END) AS TOT_REAL_DEPT
                                FROM (
                                    SELECT A.CHR_KODE_DEPARTMENT, 
                                        LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6) AS CHR_MONTH, 
                                        SUM(B.MON_TOTAL_PRICE_SUPPLIER) AS MON_PR
                                    FROM BDGT_TT_BUDGET_PR_HEADER AS A 
                                    LEFT JOIN BDGT_TT_BUDGET_PR_DETAIL AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                    WHERE A.CHR_TAHUN_BUDGET = '$tahun'
                                        AND A.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                        AND A.CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND A.CHR_FLG_DELETE = '0'
                                        AND A.CHR_FLG_APPROVE_MAN = '1'
                                    GROUP BY A.CHR_KODE_DEPARTMENT, B.CHR_TGL_ESTIMASI_KEDATANGAN
                                ) SUMM
                                GROUP BY ROLLUP (CHR_KODE_DEPARTMENT)")->row();
        
        return $actual_real;
    }
    
    //--------------------- DETAIL ACTUAL GR PER MONTH -----------------------//
    function get_new_actual_gr($start_date, $end_date, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            // if($kode_dept == 'QCO'){
            //     $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
            //                                     FROM BDGT_TT_REPORT_CAPEX 
            //                                     WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_BDGT_DEPT IN ('QCO','QAS'))")->row();
            //     return $actual_gr;
            // } else {
                $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                                FROM BDGT_TT_REPORT_CAPEX 
                                                WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_BDGT_DEPT = '$kode_dept')")->row();
                return $actual_gr;
            // }
        } else {
            // if($kode_dept == 'QCO'){
            //     $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
            //                                     FROM BDGT_TT_REPORT_EXPENSES
            //                                     WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
            //                                                        FROM BDGT_TM_GL_ACCOUNT
            //                                                        WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
            //                                           AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
            //                                           AND (CHR_BDGT_DEPT IN ('QCO','QAS'))")->row();
            //     return $actual_gr;
            // } else {
                $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_BDGT_DEPT = '$kode_dept')")->row();
                return $actual_gr;
            // }
        }            
    }
    
    //------------ NEW UPDATE BY ANU 04/07/2017 --- GROUP DEPT ---------------//
    //------------------------ DETAIL BUDGET PER MONTH -----------------------//
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
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_GROUP = '$kode_group' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
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
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_GROUP = '$kode_group' 
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //-------------------- DETAIL BUDGET REVISI PER MONTH --------------------//
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
                                         --AND CHR_FLG_CANCEL = '0' 
                                         AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else if ($budget_type == 'CONSU'){
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_consumable_rev_by_group '$year_start', '$year_end', '$budget_type', '$kode_group', ''")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_group '$year_start', '$year_end', '$budget_type', '$kode_group', ''")->row();
            return $budget_detail;
        }
    }
    
    //--------------------- DETAIL BUDGET LIMIT PER MONTH --------------------//
    function get_new_budget_limit_gm($tahun, $year_start, $year_end, $budget_type, $kode_group, $act_periode, $periode_smt2){
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
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                       AND CHR_KODE_GROUP = '$kode_group' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                 UNION 
                                                 SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                        0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                        0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                       AND CHR_KODE_GROUP = '$kode_group' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0') AS BDGT_TM_BUDGET_CAPEX")->row();
            return $budget_limit;
        } else if ($budget_type == 'CONSU'){
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
                                                      FROM BDGT_TM_BUDGET_CONSUMABLE
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            AND CHR_KODE_GROUP = '$kode_group' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_CONSUMABLE
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
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
                                                FROM (SELECT CHR_KODE_GROUP,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        AND CHR_KODE_GROUP = '$kode_group' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_GROUP,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_KODE_GROUP = '$kode_group' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
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
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            AND CHR_KODE_GROUP = '$kode_group' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_EXPENSE 
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
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
                                                FROM (SELECT CHR_KODE_GROUP,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        AND CHR_KODE_GROUP = '$kode_group' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_GROUP,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_KODE_GROUP = '$kode_group' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
        }
    }
    
    //--------------------- DETAIL UNBUDGET PER MONTH --------------------//
    function get_new_unbudget_detail_gm($tahun, $year_start, $year_end, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $unbudget = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15 
                                            FROM BDGT_TM_BUDGET_CAPEX 
                                            WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_KODE_GROUP = '$kode_group' 
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '1'")->row();
            return $unbudget;
        } else if ($budget_type == 'CONSU'){
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                        AND CHR_KODE_GROUP = '$kode_group'
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                        AND CHR_KODE_GROUP = '$kode_group'
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
        } else {
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                        AND CHR_KODE_GROUP = '$kode_group'
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                        AND CHR_KODE_GROUP = '$kode_group'
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
        }
    }
    
    //---------------------- DETAIL ACTUAL PER MONTH ----------------------//
    function get_new_actual_real_gm($tahun, $year_start, $year_end, $budget_type, $kode_group, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $actual_real = $bgt_aii->query("SELECT TOP 1 CASE WHEN CHR_KODE_GROUP IS NULL THEN 'TOTAL' ELSE CHR_KODE_GROUP END AS CHR_KODE_GROUP,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'04' THEN MON_PR ELSE 0 END) AS OPRBLN04,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'05' THEN MON_PR ELSE 0 END) AS OPRBLN05,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'06' THEN MON_PR ELSE 0 END) AS OPRBLN06,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'07' THEN MON_PR ELSE 0 END) AS OPRBLN07,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'08' THEN MON_PR ELSE 0 END) AS OPRBLN08,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'09' THEN MON_PR ELSE 0 END) AS OPRBLN09,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'10' THEN MON_PR ELSE 0 END) AS OPRBLN10,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'11' THEN MON_PR ELSE 0 END) AS OPRBLN11,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'12' THEN MON_PR ELSE 0 END) AS OPRBLN12,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'01' THEN MON_PR ELSE 0 END) AS OPRBLN13,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'02' THEN MON_PR ELSE 0 END) AS OPRBLN14,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'03' THEN MON_PR ELSE 0 END) AS OPRBLN15,
                                SUM(CASE WHEN CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$year_start'+'04') AND CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$year_end'+'03') THEN MON_PR ELSE 0 END) AS TOT_REAL_GROUP
                                FROM (
                                    SELECT A.CHR_KODE_GROUP, 
                                        LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6) AS CHR_MONTH, 
                                        SUM(B.MON_TOTAL_PRICE_SUPPLIER) AS MON_PR
                                    FROM BDGT_TT_BUDGET_PR_HEADER AS A 
                                    LEFT JOIN BDGT_TT_BUDGET_PR_DETAIL AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                    WHERE A.CHR_TAHUN_BUDGET = '$tahun'
                                        AND A.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                        AND A.CHR_KODE_GROUP = '$kode_group'
                                        AND A.CHR_FLG_DELETE = '0'
                                        AND A.CHR_FLG_APPROVE_GM = '1'
                                    GROUP BY A.CHR_KODE_GROUP, B.CHR_TGL_ESTIMASI_KEDATANGAN
                                ) SUMM
                                GROUP BY ROLLUP (CHR_KODE_GROUP)")->row();
        
        return $actual_real;
    }
    
    //--------------------- DETAIL ACTUAL GR PER MONTH -----------------------//
    function get_new_actual_gr_gm($start_date, $end_date, $budget_type, $kode_dept, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_CAPEX 
                                            WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group'))")->row();
            return $actual_gr;
        } else {
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_KODE_GROUP = '$kode_group')) ")->row();
            return $actual_gr;
        }            
    }
    
    //------------ NEW UPDATE BY ANU 04/07/2017 --- DIV PLANT ----------------//
    //------------------------ DETAIL BUDGET PER MONTH -----------------------//
    function get_new_budget_detail_bod($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                    SUM(MON_BLN04) AS PBLN04,SUM(MON_BLN05) AS PBLN05,SUM(MON_BLN06) AS PBLN06,
                                                    SUM(MON_BLN07) AS PBLN07,SUM(MON_BLN08) AS PBLN08,SUM(MON_BLN09) AS PBLN09,
                                                    SUM(MON_BLN10) AS PBLN10,SUM(MON_BLN11) AS PBLN11,SUM(MON_BLN12) AS PBLN12,
                                                    SUM(MON_BLN01) AS PBLN13,SUM(MON_BLN02) AS PBLN14,SUM(MON_BLN03) AS PBLN15 
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                      AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
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
                                                                     AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_CONSUMABLE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
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
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //-------------------- DETAIL BUDGET REVISI PER MONTH --------------------//
    function get_new_budget_detail_rev_bod($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                 ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                                 ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                                 ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                                 ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                        FROM BDGT_TM_BUDGET_CAPEX 
                                        WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                             AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT') 
                                             AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                             AND CHR_FLG_DELETE = '0' 
                                             --AND CHR_FLG_CANCEL = '0' 
                                             AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $budget_detail;
        } else if ($budget_type == 'CONSU'){
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_consumable_rev_by_plant '$year_start', '$year_end', '$budget_type', ''")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_plant '$year_start', '$year_end', '$budget_type', ''")->row();
            return $budget_detail;
        }
    }
    
    //--------------------- DETAIL BUDGET LIMIT PER MONTH --------------------//
    function get_new_budget_limit_bod($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_limit = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                    SUM(MON_LIMBLN04) AS PBLN04,SUM(MON_LIMBLN05) AS PBLN05,SUM(MON_LIMBLN06) AS PBLN06,
                                                    SUM(MON_LIMBLN07) AS PBLN07,SUM(MON_LIMBLN08) AS PBLN08,SUM(MON_LIMBLN09) AS PBLN09,
                                                    SUM(MON_LIMBLN10) AS PBLN10,SUM(MON_LIMBLN11) AS PBLN11,SUM(MON_LIMBLN12) AS PBLN12,
                                                    SUM(MON_LIMBLN01) AS PBLN13,SUM(MON_LIMBLN02) AS PBLN14,SUM(MON_LIMBLN03) AS PBLN15  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '0'")->row();
            return $budget_limit;
        } else if ($budget_type == 'CONSU'){
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
                                                      FROM BDGT_TM_BUDGET_CONSUMABLE
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            --AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                            --AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $budget_limit;
            } else {
                $budget_limit = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                                FROM (SELECT CHR_KODE_DIVISI,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        --AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_DIVISI,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        --AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
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
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            --AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0' ) BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_EXPENSE 
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                            --AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $budget_limit;
            } else {
                $budget_limit = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                                FROM (SELECT CHR_KODE_DIVISI,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        --AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0' 
                                                  UNION ALL SELECT CHR_KODE_DIVISI,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        --AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
        }
    }
    
    //--------------------- DETAIL UNBUDGET PER MONTH --------------------//
    function get_new_unbudget_detail_bod($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $unbudget = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                    SUM(MON_LIMBLN04) AS PBLN04,SUM(MON_LIMBLN05) AS PBLN05,SUM(MON_LIMBLN06) AS PBLN06,
                                                    SUM(MON_LIMBLN07) AS PBLN07,SUM(MON_LIMBLN08) AS PBLN08,SUM(MON_LIMBLN09) AS PBLN09,
                                                    SUM(MON_LIMBLN10) AS PBLN10,SUM(MON_LIMBLN11) AS PBLN11,SUM(MON_LIMBLN12) AS PBLN12,
                                                    SUM(MON_LIMBLN01) AS PBLN13,SUM(MON_LIMBLN02) AS PBLN14,SUM(MON_LIMBLN03) AS PBLN15  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '1'")->row();
            return $unbudget;
        } else if ($budget_type == 'CONSU'){
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                        AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_CONSUMABLE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                        AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
        } else {
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                        AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                        AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
        }
    }
    
    //---------------------- DETAIL ACTUAL PER MONTH ----------------------//
    function get_new_actual_real_bod($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $actual_real = $bgt_aii->query("SELECT TOP 1 CASE WHEN CHR_KODE_DIV IS NULL THEN 'TOTAL' ELSE CHR_KODE_DIV END AS CHR_KODE_DIV,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'04' THEN MON_PR ELSE 0 END) AS OPRBLN04,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'05' THEN MON_PR ELSE 0 END) AS OPRBLN05,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'06' THEN MON_PR ELSE 0 END) AS OPRBLN06,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'07' THEN MON_PR ELSE 0 END) AS OPRBLN07,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'08' THEN MON_PR ELSE 0 END) AS OPRBLN08,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'09' THEN MON_PR ELSE 0 END) AS OPRBLN09,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'10' THEN MON_PR ELSE 0 END) AS OPRBLN10,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'11' THEN MON_PR ELSE 0 END) AS OPRBLN11,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'12' THEN MON_PR ELSE 0 END) AS OPRBLN12,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'01' THEN MON_PR ELSE 0 END) AS OPRBLN13,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'02' THEN MON_PR ELSE 0 END) AS OPRBLN14,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'03' THEN MON_PR ELSE 0 END) AS OPRBLN15,
                                SUM(CASE WHEN CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$year_start'+'04') AND CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$year_end'+'03') THEN MON_PR ELSE 0 END) AS TOT_REAL_PLANT
                                FROM (
                                    SELECT 'PLANT' AS CHR_KODE_DIV, 
                                        LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6) AS CHR_MONTH, 
                                        SUM(B.MON_TOTAL_PRICE_SUPPLIER) AS MON_PR
                                    FROM BDGT_TT_BUDGET_PR_HEADER AS A 
                                    LEFT JOIN BDGT_TT_BUDGET_PR_DETAIL AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                    WHERE A.CHR_TAHUN_BUDGET = '$tahun'
                                        AND A.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                        AND A.CHR_FLG_DELETE = '0'
                                        AND A.CHR_FLG_APPROVE_BOD = '1'
                                    GROUP BY B.CHR_TGL_ESTIMASI_KEDATANGAN
                                ) SUMM
                                GROUP BY ROLLUP (CHR_KODE_DIV)")->row();
        
        return $actual_real;

    }
    
    //--------------------- DETAIL ACTUAL GR PER MONTH -----------------------//
    function get_new_actual_gr_bod($start_date, $end_date, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_CAPEX 
                                            WHERE (BUDAT BETWEEN '$start_date' AND '$end_date')
                                                AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT'))")->row();
            return $actual_gr;
        } else {
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')) ")->row();
            return $actual_gr;
        }            
    }
    
    function get_estimate_date($kode_trans){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $est_date = $bgt_aii->query("SELECT TOP 1 CHR_TGL_ESTIMASI_KEDATANGAN 
                                    FROM BDGT_TT_BUDGET_PR_DETAIL
                                    WHERE CHR_KODE_TRANSAKSI = '$kode_trans'
                                    ORDER BY CHR_TGL_ESTIMASI_KEDATANGAN DESC")->row();
        return $est_date;
    }
    
    
    //------------------------ TOTAL REALISASI BUDGET NON CIP BY DEPT -----------------------//
    function get_new_total_real_dept_nonunbudget($tahun, $year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_real_dept = $bgt_aii->query("SELECT SUM(MON_OPRBLN01_MAN+MON_OPRBLN02_MAN+MON_OPRBLN03_MAN+MON_OPRBLN04_MAN+MON_OPRBLN05_MAN+MON_OPRBLN06_MAN+MON_OPRBLN07_MAN+MON_OPRBLN08_MAN+MON_OPRBLN09_MAN+MON_OPRBLN10_MAN+MON_OPRBLN11_MAN+MON_OPRBLN12_MAN) AS TOT_BUDGET_REAL
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_CIP = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_real_dept;
        } else if ($budget_type == 'CONSU'){
            $total_real_dept = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_BUDGET_REAL
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0' 
                                                      ) ACTUAL_CURR_YEAR
                                          LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                            MON_OPRBLN01_MAN AS OPRBLN13, 
                                                            MON_OPRBLN02_MAN AS OPRBLN14, 
                                                            MON_OPRBLN03_MAN AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_CONSUMABLE
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_CIP = '0'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_dept;
        } else {
            $total_real_dept = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_BUDGET_REAL
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                      AND CHR_FLG_UNBUDGET = '0'
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
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_CIP = '0'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_dept;
        }
    }
    //------------------------ END UPDATE REALISASI --------------------------//
    
    //------------------------ TOTAL REALISASI UNBUDGET CIP NON CIP BY DEPT -----------------------//
    function get_new_total_real_dept_unbudget($tahun, $year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_real_dept = $bgt_aii->query("SELECT SUM(MON_OPRBLN01_MAN+MON_OPRBLN02_MAN+MON_OPRBLN03_MAN+MON_OPRBLN04_MAN+MON_OPRBLN05_MAN+MON_OPRBLN06_MAN+MON_OPRBLN07_MAN+MON_OPRBLN08_MAN+MON_OPRBLN09_MAN+MON_OPRBLN10_MAN+MON_OPRBLN11_MAN+MON_OPRBLN12_MAN) AS TOT_UNBUDGET_REAL
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_UNBUDGET = '1'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_real_dept;
        } else if ($budget_type == 'CONSU'){
            $total_real_dept = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_UNBUDGET_REAL
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                      AND CHR_FLG_UNBUDGET = '1'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0' 
                                                      ) ACTUAL_CURR_YEAR
                                          LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                            MON_OPRBLN01_MAN AS OPRBLN13, 
                                                            MON_OPRBLN02_MAN AS OPRBLN14, 
                                                            MON_OPRBLN03_MAN AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_CONSUMABLE
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_dept;
        } else {
            $total_real_dept = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_UNBUDGET_REAL
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                      AND CHR_FLG_UNBUDGET = '1'
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
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_dept;
        }
    }
    //------------------------ END UPDATE REALISASI --------------------------//
    
    //------------------------ TOTAL REALISASI BUDGET CIP BY DEPT -----------------------//
    function get_new_total_real_dept_nonunbudget_cip($tahun, $year_start, $year_end, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $total_real_dept = $bgt_aii->query("SELECT SUM(MON_OPRBLN01_MAN+MON_OPRBLN02_MAN+MON_OPRBLN03_MAN+MON_OPRBLN04_MAN+MON_OPRBLN05_MAN+MON_OPRBLN06_MAN+MON_OPRBLN07_MAN+MON_OPRBLN08_MAN+MON_OPRBLN09_MAN+MON_OPRBLN10_MAN+MON_OPRBLN11_MAN+MON_OPRBLN12_MAN) AS TOT_CIP_REAL
                                          FROM BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_CIP = '1'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0'")->row();
            return $total_real_dept;
        } else if ($budget_type == 'CONSU'){
            $total_real_dept = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_CIP_REAL
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_CIP = '1'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0' 
                                                      ) ACTUAL_CURR_YEAR
                                          LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                            MON_OPRBLN01_MAN AS OPRBLN13, 
                                                            MON_OPRBLN02_MAN AS OPRBLN14, 
                                                            MON_OPRBLN03_MAN AS OPRBLN15
                                                 FROM BDGT_TM_BUDGET_CONSUMABLE
                                                 WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                                      AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_CIP = '1'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_dept;
        } else {
            $total_real_dept = $bgt_aii->query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOT_CIP_REAL
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_CIP = '1'
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
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                      AND CHR_FLG_UNBUDGET = '0'
                                                      AND CHR_FLG_CIP = '1'
                                                      --AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
            return $total_real_dept;
        }
    }
    //------------------------ END UPDATE REALISASI --------------------------//
    
    //----------------- REQUEST PAK ARIAWAN 05/06/2018 -----------------------//
    //--------------------- DETAIL TOP UP PER MONTH --------------------------//
    function get_new_topup_bod($year_start, $month, $budget_type, $kode_dept){
        $topup = $this->db->query("SELECT SUM(MON_PROPOSE_BLN) AS TOTAL_TOPUP 
                                    FROM CPL.TT_DETAIL_PROPOSE_BUDGET A 
                                    INNER JOIN CPL.TT_HEADER_PROPOSE_BUDGET B ON A.CHR_NO_PROPOSE = B.CHR_NO_PROPOSE
                                    WHERE B.CHR_YEAR_BUDGET = '$year_start' 
                                    AND B.CHR_MONTH_PROPOSE = '$month'
                                    AND A.CHR_BUDGET_TYPE = '$budget_type'
                                    --AND B.CHR_DEPT LIKE '$kode_dept%'
                                    AND B.CHR_FLG_SWITCH = '3'
                                    AND B.CHR_FLG_DELETE_PROP = '0'")->row();
        return $topup;
    }
    
    //------------------------ DETAIL BUDGET OGAWA ---------------------------//
    function get_new_budget_detail_ogawa($tahun, $year_start, $year_end, $budget_type){
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
                                                FROM BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                     AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT') 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                     AND CHR_DESC_BUDGET LIKE '%ogawa%'
                                                UNION
                                                SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03, 
                                                       0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                       0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                       0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,
                                                       ISNULL(SUM(MON_BLN02),0) AS PBLN14,
                                                       ISNULL(SUM(MON_BLN03),0) AS PBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                      AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                      AND CHR_FLG_DELETE = '0'  
                                                      AND CHR_FLG_FOR_AIIA = '0'
                                                      AND CHR_DESC_BUDGET LIKE '%ogawa%') AS BDGT_TM_BUDGET_CAPEX")->row();
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
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0'
                                                                     AND CHR_KODE_ITEM LIKE '%ogawa%') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_REV = '0'
                                                                AND CHR_KODE_ITEM LIKE '%ogawa%') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    //-------------------- DETAIL BUDGET REVISI PER MONTH --------------------//
    function get_new_budget_detail_rev_ogawa($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                 ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                                 ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                                 ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                                 ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                        FROM BDGT_TM_BUDGET_CAPEX 
                                        WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                             AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT') 
                                             AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                             AND CHR_FLG_DELETE = '0' 
                                             --AND CHR_FLG_CANCEL = '0' 
                                             AND CHR_FLG_FOR_AIIA = '0' 
                                             AND CHR_DESC_BUDGET LIKE '%ogawa%'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_ogawa '$year_start', '$year_end', '$budget_type', ''")->row();
            return $budget_detail;
        }
    }
    
    //--------------------- DETAIL BUDGET LIMIT PER MONTH --------------------//
    function get_new_budget_limit_ogawa($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2){
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
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                       AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_DESC_BUDGET LIKE '%ogawa%'
                                                 UNION 
                                                 SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                        0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                        0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                       AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_DESC_BUDGET LIKE '%ogawa%') AS BDGT_TM_BUDGET_CAPEX")->row();
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
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            --AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0'
                                                            AND CHR_KODE_ITEM LIKE '%ogawa%') BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_EXPENSE 
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                            --AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0'
                                                            AND CHR_KODE_ITEM LIKE '%ogawa%') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $budget_limit;
            } else {
                $budget_limit = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                                FROM (SELECT CHR_KODE_DIVISI,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        --AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0'
                                                        AND CHR_KODE_ITEM LIKE '%ogawa%'
                                                  UNION ALL SELECT CHR_KODE_DIVISI,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        --AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1'
                                                        AND CHR_KODE_ITEM LIKE '%ogawa%') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
        }
    }
    
    //--------------------- DETAIL UNBUDGET PER MONTH --------------------//
    function get_new_unbudget_detail_ogawa($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $unbudget = $bgt_aii->query("SELECT SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
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
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                       AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '1'
                                                       AND CHR_DESC_BUDGET LIKE '%ogawa%'
                                                 UNION 
                                                 SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                        0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                        0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                       AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '1'
                                                       AND CHR_DESC_BUDGET LIKE '%ogawa%') AS BDGT_TM_UNBUDGET_CAPEX")->row();
            return $unbudget;
        } else {
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                        AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1'
                                                        AND CHR_KODE_ITEM LIKE '%ogawa%') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                        AND CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1'
                                                        AND CHR_KODE_ITEM LIKE '%ogawa%') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
        }
    }
    
    //---------------------- DETAIL ACTUAL PER MONTH ----------------------//
    function get_new_actual_real_ogawa($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(MON_OPRBLN04_GM),0) AS OPRBLN04, 
                                                 ISNULL(SUM(MON_OPRBLN05_GM),0) AS OPRBLN05, ISNULL(SUM(MON_OPRBLN06_GM),0) AS OPRBLN06, 
                                                 ISNULL(SUM(MON_OPRBLN07_GM),0) AS OPRBLN07, ISNULL(SUM(MON_OPRBLN08_GM),0) AS OPRBLN08, 
                                                 ISNULL(SUM(MON_OPRBLN09_GM),0) AS OPRBLN09, ISNULL(SUM(MON_OPRBLN10_GM),0) AS OPRBLN10, 
                                                 ISNULL(SUM(MON_OPRBLN11_GM),0) AS OPRBLN11, ISNULL(SUM(MON_OPRBLN12_GM),0) AS OPRBLN12,
                                                 ISNULL(SUM(MON_OPRBLN01_GM),0) AS OPRBLN13, ISNULL(SUM(MON_OPRBLN02_GM),0) AS OPRBLN14, 
                                                 ISNULL(SUM(MON_OPRBLN03_GM),0) AS OPRBLN15
                                          FROM  BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0' 
                                                      AND CHR_DESC_BUDGET LIKE '%ogawa%'")->row();
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
                                                     WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          AND CHR_KODE_ITEM LIKE '%ogawa%'
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_GM AS OPRBLN13, 
                                                                MON_OPRBLN02_GM AS OPRBLN14, 
                                                                MON_OPRBLN03_GM AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          AND CHR_KODE_ITEM LIKE '%ogawa%'
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
                                                     WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          AND CHR_KODE_ITEM LIKE '%ogawa%'
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_GM AS OPRBLN13, 
                                                                MON_OPRBLN02_GM AS OPRBLN14, 
                                                                MON_OPRBLN03_GM AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          AND CHR_KODE_ITEM LIKE '%ogawa%'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
        }
    }
    
    //--------------------- DETAIL ACTUAL GR PER MONTH -----------------------//
    function get_new_actual_gr_ogawa($start_date, $end_date, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_CAPEX 
                                            WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_DESC_BUDGET LIKE '%ogawa%')
                                                AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT'))")->row();
            return $actual_gr;
        } else {
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_DESC_BUDGET LIKE '%ogawa%')
                                                  AND (CHR_BDGT_DEPT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')) ")->row();
            return $actual_gr;
        }            
    }
    
    //------------------------ DETAIL BUDGET 3 PILLAR ------------------------//
    //----- UPDATE BY ANU 22/10/2018 --- REQ MR ARIAWAN ----------------------//
    function get_new_budget_detail_3pillar($tahun, $year_start, $year_end, $budget_type){
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
                                                FROM BDGT_TM_BUDGET_CAPEX WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                     AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                     AND CHR_KODE_DEPARTMENT = 'KZN' 
                                                     AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                     AND CHR_FLG_DELETE = '0' 
                                                     AND CHR_FLG_FOR_AIIA = '0'
                                                     AND CHR_DESC_BUDGET LIKE '%pillar%'
                                                UNION
                                                SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03, 
                                                       0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                       0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                       0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                       ISNULL(SUM(MON_BLN01),0) AS PBLN13,
                                                       ISNULL(SUM(MON_BLN02),0) AS PBLN14,
                                                       ISNULL(SUM(MON_BLN03),0) AS PBLN15
                                                FROM BDGT_TM_BUDGET_CAPEX 
                                                WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                      AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                      AND CHR_KODE_DEPARTMENT = 'KZN'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                      AND CHR_FLG_DELETE = '0'  
                                                      AND CHR_FLG_FOR_AIIA = '0'
                                                      AND CHR_DESC_BUDGET LIKE '%pillar%') AS BDGT_TM_BUDGET_CAPEX")->row();
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
                                                                     AND CHR_KODE_DEPARTMENT = 'KZN'
                                                                     AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                     AND CHR_FLG_REV = '0'
                                                                     AND CHR_KODE_ITEM LIKE '%pillar%') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_BLN01 AS MON_BLN13,MON_BLN02 AS MON_BLN14,MON_BLN03 AS MON_BLN15 
                                                       FROM BDGT_TM_BUDGET_EXPENSE WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                                AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                                AND CHR_KODE_DEPARTMENT = 'KZN'
                                                                AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                                AND CHR_FLG_REV = '0'
                                                                AND CHR_KODE_ITEM LIKE '%pillar%') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $budget_detail;
        }
    }
    
    function get_new_budget_detail_rev_3pillar($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                 ISNULL(SUM(MON_REV01BLN04),0) AS PBLN04,ISNULL(SUM(MON_REV01BLN05),0) AS PBLN05,ISNULL(SUM(MON_REV01BLN06),0) AS PBLN06,
                                                 ISNULL(SUM(MON_REV01BLN07),0) AS PBLN07,ISNULL(SUM(MON_REV01BLN08),0) AS PBLN08,ISNULL(SUM(MON_REV01BLN09),0) AS PBLN09,
                                                 ISNULL(SUM(MON_REV01BLN10),0) AS PBLN10,ISNULL(SUM(MON_REV01BLN11),0) AS PBLN11,ISNULL(SUM(MON_REV01BLN12),0) AS PBLN12,
                                                 ISNULL(SUM(MON_REV01BLN01),0) AS PBLN13,ISNULL(SUM(MON_REV01BLN02),0) AS PBLN14,ISNULL(SUM(MON_REV01BLN03),0) AS PBLN15 
                                        FROM BDGT_TM_BUDGET_CAPEX 
                                        WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                             AND CHR_KODE_DEPARTMENT = 'KZN' 
                                             AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                             AND CHR_FLG_DELETE = '0' 
                                             --AND CHR_FLG_CANCEL = '0' 
                                             AND CHR_FLG_FOR_AIIA = '0' 
                                             AND CHR_DESC_BUDGET LIKE '%pillar%'")->row();
            return $budget_detail;
        } else {
            $budget_detail = $bgt_aii->query("EXEC zsp_get_detail_expense_rev_by_3pillar '$year_start', '$year_end', '$budget_type', ''")->row();
            return $budget_detail;
        }
    }
    
    function get_new_budget_limit_3pillar($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2){
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
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                       AND CHR_KODE_DEPARTMENT = 'KZN'
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_DESC_BUDGET LIKE '%pillar%'
                                                 UNION 
                                                 SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                        0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                        0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                       AND CHR_KODE_DEPARTMENT = 'KZN'
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_DESC_BUDGET LIKE '%pillar%') AS BDGT_TM_BUDGET_CAPEX")->row();
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
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                            AND CHR_KODE_DEPARTMENT = 'KZN'
                                                            --AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0'
                                                            AND CHR_KODE_ITEM LIKE '%pillar%') BDGT_CURR_YEAR
                                                LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                      FROM BDGT_TM_BUDGET_EXPENSE 
                                                      WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                            AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                            AND CHR_KODE_DEPARTMENT = 'KZN'
                                                            --AND CHR_KODE_DIVISI = '001' 
                                                            AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                            AND CHR_FLG_REV = '0'
                                                            AND CHR_KODE_ITEM LIKE '%pillar%') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $budget_limit;
            } else {
                $budget_limit = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                       ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                       ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                       ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                                FROM (SELECT CHR_KODE_DIVISI,
                                                            MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                            MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                            0 AS MON_LIMBLN10,0 AS MON_LIMBLN11,0 AS MON_LIMBLN12,
                                                            0 AS MON_LIMBLN13,0 AS MON_LIMBLN14,0 AS MON_LIMBLN15
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        AND CHR_KODE_DEPARTMENT = 'KZN'
                                                        --AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '0'
                                                        AND CHR_KODE_ITEM LIKE '%pillar%'
                                                  UNION ALL SELECT CHR_KODE_DIVISI,
                                                        0 AS MON_LIMBLN04,0 AS MON_LIMBLN05,0 AS MON_LIMBLN06,
                                                        0 AS MON_LIMBLN07,0 AS MON_LIMBLN08,0 AS MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12,
                                                        MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun'
                                                        AND CHR_KODE_DEPARTMENT = 'KZN'
                                                        --AND CHR_KODE_DIVISI = '001' 
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_REV = '1'
                                                        AND CHR_KODE_ITEM LIKE '%pillar%') AS BDGT_LIMIT")->row();
                return $budget_limit;
            }
        }
    }
    
    function get_new_actual_real_3pillar($tahun, $year_start, $year_end, $budget_type, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_real = $bgt_aii->query("SELECT ISNULL(SUM(MON_OPRBLN04_GM),0) AS OPRBLN04, 
                                                 ISNULL(SUM(MON_OPRBLN05_GM),0) AS OPRBLN05, ISNULL(SUM(MON_OPRBLN06_GM),0) AS OPRBLN06, 
                                                 ISNULL(SUM(MON_OPRBLN07_GM),0) AS OPRBLN07, ISNULL(SUM(MON_OPRBLN08_GM),0) AS OPRBLN08, 
                                                 ISNULL(SUM(MON_OPRBLN09_GM),0) AS OPRBLN09, ISNULL(SUM(MON_OPRBLN10_GM),0) AS OPRBLN10, 
                                                 ISNULL(SUM(MON_OPRBLN11_GM),0) AS OPRBLN11, ISNULL(SUM(MON_OPRBLN12_GM),0) AS OPRBLN12,
                                                 ISNULL(SUM(MON_OPRBLN01_GM),0) AS OPRBLN13, ISNULL(SUM(MON_OPRBLN02_GM),0) AS OPRBLN14, 
                                                 ISNULL(SUM(MON_OPRBLN03_GM),0) AS OPRBLN15
                                          FROM  BDGT_TM_BUDGET_CAPEX
                                                 WHERE CHR_KODE_DEPARTMENT = 'KZN'
                                                      AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                                      AND CHR_TAHUN_BUDGET = '$tahun'
                                                      AND CHR_FLG_DELETE = '0'
                                                      --AND CHR_FLG_PROJECT = '0'
                                                      AND CHR_FLG_FOR_AIIA = '0' 
                                                      AND CHR_DESC_BUDGET LIKE '%pillar%'")->row();
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
                                                     WHERE CHR_KODE_DEPARTMENT = 'KZN'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          AND CHR_KODE_ITEM LIKE '%pillar%'
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_GM AS OPRBLN13, 
                                                                MON_OPRBLN02_GM AS OPRBLN14, 
                                                                MON_OPRBLN03_GM AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DEPARTMENT = 'KZN'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          AND CHR_KODE_ITEM LIKE '%pillar%'
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
                                                     WHERE CHR_KODE_DEPARTMENT = 'KZN'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_start%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0' 
                                                          AND CHR_KODE_ITEM LIKE '%pillar%'
                                                          ) ACTUAL_CURR_YEAR
                                              LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                                MON_OPRBLN01_GM AS OPRBLN13, 
                                                                MON_OPRBLN02_GM AS OPRBLN14, 
                                                                MON_OPRBLN03_GM AS OPRBLN15
                                                     FROM BDGT_TM_BUDGET_EXPENSE
                                                     WHERE CHR_KODE_DEPARTMENT = 'KZN'
                                                          AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                          AND CHR_TAHUN_BUDGET = '$tahun'
                                                          AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                          --AND CHR_FLG_DELETE = '0'
                                                          --AND CHR_FLG_PROJECT = '0'
                                                          AND CHR_KODE_ITEM LIKE '%pillar%'
                                                          ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET")->row();
                return $actual_real;
            }
        }
    }
    
    function get_new_unbudget_detail_3pillar($tahun, $year_start, $year_end, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $unbudget = $bgt_aii->query("SELECT SUM(PBLN01) AS PBLN01,SUM(PBLN02) AS PBLN02,SUM(PBLN03) AS PBLN03,
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
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                       AND CHR_KODE_DEPARTMENT = 'KZN'
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '1'
                                                       AND CHR_DESC_BUDGET LIKE '%pillar%'
                                                 UNION 
                                                 SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                                        0 AS PBLN04,0 AS PBLN05,0 AS PBLN06,
                                                        0 AS PBLN07,0 AS PBLN08,0 AS PBLN09,
                                                        0 AS PBLN10,0 AS PBLN11,0 AS PBLN12,
                                                        ISNULL(SUM(MON_LIMBLN01),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN15  
                                                 FROM BDGT_TM_BUDGET_CAPEX 
                                                 WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                       AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                       AND CHR_KODE_DEPARTMENT = 'KZN'
                                                       AND CHR_KODE_TYPE_BUDGET = 'CAPEX' 
                                                       AND CHR_FLG_DELETE = '0'
                                                       AND CHR_FLG_UNBUDGET = '1'
                                                       AND CHR_DESC_BUDGET LIKE '%pillar%') AS BDGT_TM_UNBUDGET_CAPEX")->row();
            return $unbudget;
        } else {
            $unbudget = $bgt_aii->query("SELECT ISNULL(SUM(MON_LIMBLN01),0) AS PBLN01,ISNULL(SUM(MON_LIMBLN02),0) AS PBLN02,ISNULL(SUM(MON_LIMBLN03),0) AS PBLN03,
                                                   ISNULL(SUM(MON_LIMBLN04),0) AS PBLN04,ISNULL(SUM(MON_LIMBLN05),0) AS PBLN05,ISNULL(SUM(MON_LIMBLN06),0) AS PBLN06,
                                                   ISNULL(SUM(MON_LIMBLN07),0) AS PBLN07,ISNULL(SUM(MON_LIMBLN08),0) AS PBLN08,ISNULL(SUM(MON_LIMBLN09),0) AS PBLN09,
                                                   ISNULL(SUM(MON_LIMBLN10),0) AS PBLN10,ISNULL(SUM(MON_LIMBLN11),0) AS PBLN11,ISNULL(SUM(MON_LIMBLN12),0) AS PBLN12,
                                                   ISNULL(SUM(MON_LIMBLN13),0) AS PBLN13,ISNULL(SUM(MON_LIMBLN14),0) AS PBLN14,ISNULL(SUM(MON_LIMBLN15),0) AS PBLN15
                                            FROM (SELECT CHR_NO_BUDGET,MON_LIMBLN01,MON_LIMBLN02,MON_LIMBLN03,
                                                        MON_LIMBLN04,MON_LIMBLN05,MON_LIMBLN06,
                                                        MON_LIMBLN07,MON_LIMBLN08,MON_LIMBLN09,
                                                        MON_LIMBLN10,MON_LIMBLN11,MON_LIMBLN12 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_start%' 
                                                        AND CHR_KODE_DEPARTMENT = 'KZN'
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0' 
                                                        AND CHR_FLG_UNBUDGET = '1'
                                                        AND CHR_KODE_ITEM LIKE '%pillar%') BDGT_CURR_YEAR
                                            LEFT JOIN (SELECT CHR_NO_BUDGET,MON_LIMBLN01 AS MON_LIMBLN13,MON_LIMBLN02 AS MON_LIMBLN14,MON_LIMBLN03 AS MON_LIMBLN15 
                                                  FROM BDGT_TM_BUDGET_EXPENSE 
                                                  WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                                        AND CHR_TAHUN_ACTUAL LIKE '$year_end%' 
                                                        AND CHR_KODE_DEPARTMENT = 'KZN'
                                                        AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                                        AND CHR_FLG_DELETE = '0'
                                                        AND CHR_FLG_UNBUDGET = '1'
                                                        AND CHR_KODE_ITEM LIKE '%pillar%') BDGT_NEXT_YEAR ON BDGT_CURR_YEAR.CHR_NO_BUDGET = BDGT_NEXT_YEAR.CHR_NO_BUDGET")->row();
            return $unbudget;
        }
    }
    
    function get_new_actual_gr_3pillar($start_date, $end_date, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if ($budget_type == 'CAPEX'){
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(GR_VAL),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_CAPEX 
                                            WHERE (BUDAT BETWEEN '$start_date' AND '$end_date') AND (CHR_DESC_BUDGET LIKE '%pillar%')
                                                AND (CHR_BDGT_DEPT = 'KZN')")->row();
            return $actual_gr;
        } else {
            $actual_gr = $bgt_aii -> query("SELECT ISNULL(SUM(DMBTR),0) AS TOTAL
                                            FROM BDGT_TT_REPORT_EXPENSES
                                            WHERE (SAKTO IN (SELECT CHR_GL_ACCOUNT_CROP
                                                               FROM BDGT_TM_GL_ACCOUNT
                                                               WHERE (CHR_KODE_CATEGORY = '$budget_type') AND (CHR_FLG_DELETE = '0') )) 
                                                  AND (BUDAT BETWEEN '$start_date' AND '$end_date') 
                                                  AND (CHR_DESC_BUDGET LIKE '%pillar%')
                                                  AND (CHR_BDGT_DEPT = 'KZN') ")->row();
            return $actual_gr;
        }            
    }

    function get_limit_actual_real_gm($tahun, $start_date, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $actual_pr = $bgt_aii -> query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
                                            FROM BDGT_TT_BUDGET_PR_DETAIL
                                            WHERE (CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
                                                               FROM BDGT_TT_BUDGET_PR_HEADER
                                                               WHERE (CHR_FLG_APPROVE_GM = '1') 
                                                                    AND (CHR_FLG_DELETE = '0')
                                                                    AND (CHR_TAHUN_BUDGET = '$tahun')
                                                                    AND (CHR_DATE_GM >= '$start_date')
                                                                    AND (CHR_KODE_TYPE_BUDGET = '$budget_type'))
                                            )")->row();
        return $actual_pr;
    }

    function get_limit_actual_real_bod($tahun, $start_date, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $actual_pr = $bgt_aii -> query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
                                            FROM BDGT_TT_BUDGET_PR_DETAIL
                                            WHERE (CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
                                                               FROM BDGT_TT_BUDGET_PR_HEADER
                                                               WHERE (CHR_FLG_APPROVE_BOD = '1') 
                                                                    AND (CHR_FLG_DELETE = '0')
                                                                    AND (CHR_TAHUN_BUDGET = '$tahun')
                                                                    AND (CHR_DATE_BOD >= '$start_date')
                                                                    AND (CHR_KODE_TYPE_BUDGET = '$budget_type'))
                                            )")->row();
        return $actual_pr;
    }

    function get_limit_actual_real_man($tahun, $start_date, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $actual_pr = $bgt_aii -> query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
                                            FROM BDGT_TT_BUDGET_PR_DETAIL
                                            WHERE (CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
                                                               FROM BDGT_TT_BUDGET_PR_HEADER
                                                               WHERE (CHR_FLG_APPROVE_MAN = '1') 
                                                                    AND (CHR_FLG_DELETE = '0')
                                                                    AND (CHR_TAHUN_BUDGET = '$tahun')
                                                                    AND (CHR_DATE_MAN >= '$start_date')
                                                                    AND (CHR_KODE_TYPE_BUDGET = '$budget_type'))
                                            )")->row();
        return $actual_pr;
    }

    function get_limit_actual_real_gm_exp($tahun, $start_date, $budget_type, $group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $year_end = $tahun + 1;
        $actual_pr = $bgt_aii -> query("SELECT (OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOTAL
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
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
                                            WHERE CHR_KODE_GROUP = '$group'
                                                    AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                    AND CHR_TAHUN_BUDGET = '$tahun'
                                                    AND CHR_TAHUN_ACTUAL LIKE '$tahun%'
                                                    --AND CHR_FLG_DELETE = '0'
                                                    --AND CHR_FLG_PROJECT = '0' 
                                                    ) ACTUAL_CURR_YEAR
                                        LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                        MON_OPRBLN01_GM AS OPRBLN13, 
                                                        MON_OPRBLN02_GM AS OPRBLN14, 
                                                        MON_OPRBLN03_GM AS OPRBLN15
                                            FROM BDGT_TM_BUDGET_EXPENSE
                                            WHERE CHR_KODE_GROUP = '$group'
                                                    AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                    AND CHR_TAHUN_BUDGET = '$tahun'
                                                    AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                    --AND CHR_FLG_DELETE = '0'
                                                    --AND CHR_FLG_PROJECT = '0'
                                                    ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
        // $actual_pr = $bgt_aii -> query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
        //                                     FROM BDGT_TT_BUDGET_PR_DETAIL
        //                                     WHERE (CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
        //                                                     FROM BDGT_TT_BUDGET_PR_HEADER
        //                                                     WHERE (CHR_FLG_APPROVE_GM = '1') 
        //                                                             AND (CHR_FLG_DELETE = '0')
        //                                                             AND (CHR_TAHUN_BUDGET = '$tahun')
        //                                                             AND (CHR_KODE_TYPE_BUDGET = '$budget_type')
        //                                                             AND (CHR_KODE_GROUP = '$group'))
        //                                     )")->row();
        return $actual_pr;
    }

    function get_limit_actual_real_bod_exp($tahun, $start_date, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $year_end = $tahun + 1;
        $actual_pr = $bgt_aii -> query("SELECT (OPRBLN01+OPRBLN02+OPRBLN03+OPRBLN04+OPRBLN05+OPRBLN06+OPRBLN07+OPRBLN08+OPRBLN09+OPRBLN10+OPRBLN11+OPRBLN12+OPRBLN13+OPRBLN14+OPRBLN15) AS TOTAL
                                        FROM (SELECT ISNULL(SUM(OPRBLN01),0) AS OPRBLN01, ISNULL(SUM(OPRBLN02),0) AS OPRBLN02, 
                                            ISNULL(SUM(OPRBLN03),0) AS OPRBLN03, ISNULL(SUM(OPRBLN04),0) AS OPRBLN04, 
                                            ISNULL(SUM(OPRBLN05),0) AS OPRBLN05, ISNULL(SUM(OPRBLN06),0) AS OPRBLN06, 
                                            ISNULL(SUM(OPRBLN07),0) AS OPRBLN07, ISNULL(SUM(OPRBLN08),0) AS OPRBLN08, 
                                            ISNULL(SUM(OPRBLN09),0) AS OPRBLN09, ISNULL(SUM(OPRBLN10),0) AS OPRBLN10, 
                                            ISNULL(SUM(OPRBLN11),0) AS OPRBLN11, ISNULL(SUM(OPRBLN12),0) AS OPRBLN12,
                                            ISNULL(SUM(OPRBLN13),0) AS OPRBLN13, ISNULL(SUM(OPRBLN14),0) AS OPRBLN14,
                                            ISNULL(SUM(OPRBLN15),0) AS OPRBLN15
                                        FROM (SELECT CHR_NO_BUDGET, MON_OPRBLN01 AS OPRBLN01, MON_OPRBLN02 AS OPRBLN02, 
                                                MON_OPRBLN03 AS OPRBLN03, MON_OPRBLN04 AS OPRBLN04, 
                                                MON_OPRBLN05 AS OPRBLN05, MON_OPRBLN06 AS OPRBLN06, 
                                                MON_OPRBLN07 AS OPRBLN07, MON_OPRBLN08 AS OPRBLN08, 
                                                MON_OPRBLN09 AS OPRBLN09, MON_OPRBLN10 AS OPRBLN10, 
                                                MON_OPRBLN11 AS OPRBLN11, MON_OPRBLN12 AS OPRBLN12
                                                --0 AS OPRBLN13, 0 AS OPRBLN14, 0 AS OPRBLN15
                                            FROM BDGT_TM_BUDGET_EXPENSE
                                            WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                    AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                    AND CHR_TAHUN_BUDGET = '$tahun'
                                                    AND CHR_TAHUN_ACTUAL LIKE '$tahun%'
                                                    --AND CHR_FLG_DELETE = '0'
                                                    --AND CHR_FLG_PROJECT = '0' 
                                                    ) ACTUAL_CURR_YEAR
                                        LEFT JOIN (SELECT CHR_NO_BUDGET, 
                                                        MON_OPRBLN01 AS OPRBLN13, 
                                                        MON_OPRBLN02 AS OPRBLN14, 
                                                        MON_OPRBLN03 AS OPRBLN15
                                            FROM BDGT_TM_BUDGET_EXPENSE
                                            WHERE CHR_KODE_DEPARTMENT IN (SELECT CHR_KODE_DEPARTMENT FROM BDGT_TM_DEPARTMENT WHERE CHR_DIVISION = 'PLANT')
                                                    AND CHR_KODE_TYPE_BUDGET = '$budget_type'
                                                    AND CHR_TAHUN_BUDGET = '$tahun'
                                                    AND CHR_TAHUN_ACTUAL LIKE '$year_end%'
                                                    --AND CHR_FLG_DELETE = '0'
                                                    --AND CHR_FLG_PROJECT = '0'
                                                    ) ACTUAL_NEXT_YEAR ON ACTUAL_CURR_YEAR.CHR_NO_BUDGET = ACTUAL_NEXT_YEAR.CHR_NO_BUDGET) AS SUMMARY_TABLE")->row();
        // $actual_pr = $bgt_aii -> query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
        //                                 FROM BDGT_TT_BUDGET_PR_DETAIL
        //                                 WHERE (CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
        //                                                 FROM BDGT_TT_BUDGET_PR_HEADER
        //                                                 WHERE (CHR_FLG_APPROVE_BOD = '1') 
        //                                                         AND (CHR_FLG_DELETE = '0')
        //                                                         AND (CHR_TAHUN_BUDGET = '$tahun')
        //                                                         AND (CHR_KODE_TYPE_BUDGET = '$budget_type'))
        //                                     )")->row();
        return $actual_pr;
    }

    function get_limit_actual_real_man_exp($tahun, $start_date, $budget_type, $dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $year_end = $tahun + 1;
        $actual_pr = $bgt_aii -> query("SELECT ISNULL(SUM(MON_TOTAL_PRICE_SUPPLIER),0) AS TOTAL
                                            FROM BDGT_TT_BUDGET_PR_DETAIL
                                            WHERE (CHR_KODE_TRANSAKSI IN (SELECT CHR_KODE_TRANSAKSI
                                                               FROM BDGT_TT_BUDGET_PR_HEADER
                                                               WHERE (CHR_FLG_APPROVE_MAN = '1') 
                                                                    AND (CHR_FLG_DELETE = '0')
                                                                    AND (CHR_TAHUN_BUDGET = '$tahun')
                                                                    AND (CHR_KODE_TYPE_BUDGET = '$budget_type'))
                                            )")->row();
        return $actual_pr;
    }

    function get_budget_sales($tahun){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $sales = $bgt_aii -> query("SELECT MON_SALES_BLN04 AS PBLN04, MON_SALES_BLN05 AS PBLN05, MON_SALES_BLN06 AS PBLN06,
                                        MON_SALES_BLN07 AS PBLN07, MON_SALES_BLN08 AS PBLN08, MON_SALES_BLN09 AS PBLN09,
                                        MON_SALES_BLN10 AS PBLN10, MON_SALES_BLN11 AS PBLN11, MON_SALES_BLN12 AS PBLN12,
                                        MON_SALES_BLN01 AS PBLN13, MON_SALES_BLN02 AS PBLN14, MON_SALES_BLN03 AS PBLN15,
                                        MON_SALES_REV01BLN04 AS REVBLN04, MON_SALES_REV01BLN05 AS REVBLN05, MON_SALES_REV01BLN06 AS REVBLN06,
                                        MON_SALES_REV01BLN07 AS REVBLN07, MON_SALES_REV01BLN08 AS REVBLN08, MON_SALES_REV01BLN09 AS REVBLN09,
                                        MON_SALES_REV01BLN10 AS REVBLN10, MON_SALES_REV01BLN11 AS REVBLN11, MON_SALES_REV01BLN12 AS REVBLN12,
                                        MON_SALES_REV01BLN01 AS REVBLN13, MON_SALES_REV01BLN02 AS REVBLN14, MON_SALES_REV01BLN03 AS REVBLN15, 
                                        CHR_UPLOAD_DATE
                                            FROM BDGT_TM_BUDGET_SALES
                                            WHERE (CHR_TAHUN_BUDGET = '$tahun') AND (CHR_FLG_DELETE = '0')");
        if($sales->num_rows() > 0){
            return $sales->row();
        } else {
            return NULL;
        }        
    }

    function get_percentage_sales($tahun, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $sales = $bgt_aii -> query("SELECT FLT_PERCENT_BLN04 AS PBLN04, FLT_PERCENT_BLN05 AS PBLN05, FLT_PERCENT_BLN06 AS PBLN06,
                                        FLT_PERCENT_BLN07 AS PBLN07, FLT_PERCENT_BLN08 AS PBLN08, FLT_PERCENT_BLN09 AS PBLN09,
                                        FLT_PERCENT_BLN10 AS PBLN10, FLT_PERCENT_BLN11 AS PBLN11, FLT_PERCENT_BLN12 AS PBLN12,
                                        FLT_PERCENT_BLN01 AS PBLN13, FLT_PERCENT_BLN02 AS PBLN14, FLT_PERCENT_BLN03 AS PBLN15
                                            FROM BDGT_TM_SALES_PERCENTAGE
                                            WHERE (CHR_TAHUN_BUDGET = '$tahun') AND (CHR_KODE_TYPE_BUDGET = '$budget_type')");
        if($sales->num_rows() > 0){
            return $sales->row();
        } else {
            return NULL;
        }        
    }

    //---------------------- DETAIL BUDGET REV PER MONTH ---------------------//
    function get_new_budget_detail_rev_by_sales($tahun, $budget_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                             ISNULL(SUM(MON_BLN04),0) + ISNULL(SUM(MON_BLN05),0) + ISNULL(SUM(MON_BLN06),0) + 
                                             ISNULL(SUM(MON_BLN07),0) + ISNULL(SUM(MON_BLN08),0) + ISNULL(SUM(MON_BLN09),0) +
                                             ISNULL(SUM(MON_BLN10),0) + ISNULL(SUM(MON_BLN11),0) + ISNULL(SUM(MON_BLN12),0) +
                                             ISNULL(SUM(MON_BLN01),0) + ISNULL(SUM(MON_BLN02),0) + ISNULL(SUM(MON_BLN03),0) AS TOTAL_CR 
                                    FROM BDGT_TM_BUDGET_EXPENSE_AFTER_CR
                                    WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                         AND CHR_KODE_DEPARTMENT = '$kode_dept'
                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                         AND CHR_FLG_DELETE = '0'")->row();
        return $budget_detail;
    }

    function get_new_budget_detail_rev_gm_by_sales($tahun, $budget_type, $kode_group){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                             ISNULL(SUM(MON_BLN04),0) + ISNULL(SUM(MON_BLN05),0) + ISNULL(SUM(MON_BLN06),0) + 
                                             ISNULL(SUM(MON_BLN07),0) + ISNULL(SUM(MON_BLN08),0) + ISNULL(SUM(MON_BLN09),0) +
                                             ISNULL(SUM(MON_BLN10),0) + ISNULL(SUM(MON_BLN11),0) + ISNULL(SUM(MON_BLN12),0) +
                                             ISNULL(SUM(MON_BLN01),0) + ISNULL(SUM(MON_BLN02),0) + ISNULL(SUM(MON_BLN03),0) AS TOTAL_CR 
                                    FROM BDGT_TM_BUDGET_EXPENSE_AFTER_CR
                                    WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                         AND CHR_KODE_GROUP = '$kode_group'
                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                         AND CHR_FLG_DELETE = '0'")->row();
        return $budget_detail;
    }

    function get_new_budget_detail_rev_bod_by_sales($tahun, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                             ISNULL(SUM(MON_BLN04),0) + ISNULL(SUM(MON_BLN05),0) + ISNULL(SUM(MON_BLN06),0) + 
                                             ISNULL(SUM(MON_BLN07),0) + ISNULL(SUM(MON_BLN08),0) + ISNULL(SUM(MON_BLN09),0) +
                                             ISNULL(SUM(MON_BLN10),0) + ISNULL(SUM(MON_BLN11),0) + ISNULL(SUM(MON_BLN12),0) +
                                             ISNULL(SUM(MON_BLN01),0) + ISNULL(SUM(MON_BLN02),0) + ISNULL(SUM(MON_BLN03),0) AS TOTAL_CR
                                    FROM BDGT_TM_BUDGET_EXPENSE_AFTER_CR
                                    WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                         AND CHR_KODE_DIVISI = '001' 
                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                         AND CHR_FLG_DELETE = '0'")->row();
        return $budget_detail;
    }

    function get_total_amount_cr($tahun, $budget_type){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $budget_detail = $bgt_aii->query("SELECT 0 AS PBLN01,0 AS PBLN02,0 AS PBLN03,
                                             ISNULL(SUM(MON_BLN04),0) AS PBLN04,ISNULL(SUM(MON_BLN05),0) AS PBLN05,ISNULL(SUM(MON_BLN06),0) AS PBLN06,
                                             ISNULL(SUM(MON_BLN07),0) AS PBLN07,ISNULL(SUM(MON_BLN08),0) AS PBLN08,ISNULL(SUM(MON_BLN09),0) AS PBLN09,
                                             ISNULL(SUM(MON_BLN10),0) AS PBLN10,ISNULL(SUM(MON_BLN11),0) AS PBLN11,ISNULL(SUM(MON_BLN12),0) AS PBLN12,
                                             ISNULL(SUM(MON_BLN01),0) AS PBLN13,ISNULL(SUM(MON_BLN02),0) AS PBLN14,ISNULL(SUM(MON_BLN03),0) AS PBLN15,
                                             ISNULL(SUM(MON_BLN04),0) + ISNULL(SUM(MON_BLN05),0) + ISNULL(SUM(MON_BLN06),0) + 
                                             ISNULL(SUM(MON_BLN07),0) + ISNULL(SUM(MON_BLN08),0) + ISNULL(SUM(MON_BLN09),0) +
                                             ISNULL(SUM(MON_BLN10),0) + ISNULL(SUM(MON_BLN11),0) + ISNULL(SUM(MON_BLN12),0) +
                                             ISNULL(SUM(MON_BLN01),0) + ISNULL(SUM(MON_BLN02),0) + ISNULL(SUM(MON_BLN03),0) AS TOTAL_CR
                                    FROM BDGT_TM_BUDGET_EXPENSE_AFTER_CR
                                    WHERE CHR_TAHUN_BUDGET = '$tahun' 
                                         AND CHR_KODE_TYPE_BUDGET = '$budget_type' 
                                         AND CHR_FLG_DELETE = '0'")->row();
        return $budget_detail;
    }

    function get_ratio_sales($fiscal_start, $bgt_type){
        $db_report = $this->load->database("db_report", TRUE);
        if($bgt_type == "CONSU"){
            $query = $db_report->query("SELECT DEC_RATIO_PLANT AS DEC_RATIO
                                        FROM TM_BUDGET_RATIO
                                        WHERE CHR_FISCAL_YEAR = '$fiscal_start'
                                            AND CHR_BUDGET_TYPE = '$bgt_type'
                                            AND CHR_COST_CATEGORY = 'Variable Cost'");
        } else if($bgt_type == "OFFEQ" || $bgt_type == "ITEXP" || $bgt_type == "ENTER" || $bgt_type == "DONAT"  || $bgt_type == "RIGHT") {
            $query = $db_report->query("SELECT DEC_RATIO_PLANT AS DEC_RATIO
                                        FROM TM_BUDGET_RATIO
                                        WHERE CHR_FISCAL_YEAR = '$fiscal_start'
                                            AND CHR_BUDGET_TYPE = '$bgt_type'
                                            AND CHR_COST_CATEGORY = 'SGA Cost'");
        } else {
            $query = $db_report->query("SELECT DEC_RATIO_PLANT AS DEC_RATIO 
                                        FROM TM_BUDGET_RATIO
                                        WHERE CHR_FISCAL_YEAR = '$fiscal_start'
                                            AND CHR_BUDGET_TYPE = '$bgt_type'
                                            AND CHR_COST_CATEGORY = 'Fixed Cost'");
        }
        
        return $query->row();
    }

    //==== New function for TASK FORCE ====//
    function get_new_actual_real_v2($tahun, $year_start, $year_end, $budget_type, $kode_dept, $act_periode, $periode_smt2){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $actual_real = $bgt_aii->query("SELECT TOP 1 CASE WHEN CHR_KODE_DEPARTMENT IS NULL THEN 'TOTAL' ELSE CHR_KODE_DEPARTMENT END AS CHR_KODE_DEPARTMENT,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'04' THEN MON_PR ELSE 0 END) AS OPRBLN04,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'05' THEN MON_PR ELSE 0 END) AS OPRBLN05,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'06' THEN MON_PR ELSE 0 END) AS OPRBLN06,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'07' THEN MON_PR ELSE 0 END) AS OPRBLN07,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'08' THEN MON_PR ELSE 0 END) AS OPRBLN08,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'09' THEN MON_PR ELSE 0 END) AS OPRBLN09,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'10' THEN MON_PR ELSE 0 END) AS OPRBLN10,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'11' THEN MON_PR ELSE 0 END) AS OPRBLN11,
                                SUM(CASE WHEN CHR_MONTH = '$year_start'+'12' THEN MON_PR ELSE 0 END) AS OPRBLN12,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'01' THEN MON_PR ELSE 0 END) AS OPRBLN13,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'02' THEN MON_PR ELSE 0 END) AS OPRBLN14,
                                SUM(CASE WHEN CHR_MONTH = '$year_end'+'03' THEN MON_PR ELSE 0 END) AS OPRBLN15,
                                SUM(CASE WHEN CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$year_start'+'04') AND CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$year_end'+'03') THEN MON_PR ELSE 0 END) AS TOT_REAL_DEPT
                                FROM (
                                    SELECT A.CHR_KODE_DEPARTMENT, 
                                        LEFT(B.CHR_TGL_ESTIMASI_KEDATANGAN,6) AS CHR_MONTH, 
                                        SUM(B.MON_TOTAL_PRICE_SUPPLIER) AS MON_PR
                                    FROM BDGT_TT_BUDGET_PR_HEADER AS A 
                                    LEFT JOIN BDGT_TT_BUDGET_PR_DETAIL AS B ON A.CHR_KODE_TRANSAKSI = B.CHR_KODE_TRANSAKSI
                                    WHERE A.CHR_TAHUN_BUDGET = '$tahun'
                                        AND A.CHR_KODE_TYPE_BUDGET = '$budget_type'
                                        AND A.CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND A.CHR_FLG_DELETE = '0'
                                        AND A.CHR_FLG_APPROVE_MAN = '1'
                                    GROUP BY A.CHR_KODE_DEPARTMENT, B.CHR_TGL_ESTIMASI_KEDATANGAN
                                ) SUMM
                                GROUP BY ROLLUP (CHR_KODE_DEPARTMENT)");
        
        return $actual_real;
    }
    
}

?>
