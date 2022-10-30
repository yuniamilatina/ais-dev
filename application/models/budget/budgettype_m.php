<?php

class budgettype_m extends CI_Model {

    private $table = 'CPL.TM_BUDGET_TYPE';

    function get_budgettype() {
        $query = $this->db->query("select a.INT_ID_BUDGET_TYPE, a.CHR_BUDGET_TYPE, a.CHR_BUDGET_TYPE_DESC, b.CHR_BUDGET_SUB_GROUP
            from CPL.TM_BUDGET_TYPE a, CPL.TM_BUDGET_SUB_GROUP b where a.INT_ID_BUDGET_SUB_GROUP =b.INT_ID_BUDGET_SUB_GROUP and a.BIT_FLG_DEL = 0
            order by b.CHR_BUDGET_SUB_GROUP, a.CHR_BUDGET_TYPE");
        return $query->result();
    }
    
    function get_budgettype_expense($section, $fiscal) {
        return $this->db->query("select a.INT_ID_BUDGET_TYPE, a.CHR_BUDGET_TYPE, a.CHR_BUDGET_TYPE_DESC
                    from CPL.TM_BUDGET_TYPE a,
                    (select q.INT_ID_BUDGET_TYPE, q.CHR_BUDGET_TYPE, q.CHR_BUDGET_TYPE_DESC
                    from TT_BUDGET x, TM_BUDGET_SUB_CATEGORY y, TM_BUDGET_CATEGORY z, TM_BUDGET_TYPE q
                    where x.INT_ID_BUDGET_SUB_CATEGORY=y.INT_ID_BUDGET_SUB_CATEGORY
                    and y.INT_ID_BUDGET_CATEGORY=z.INT_ID_BUDGET_CATEGORY
                    and z.INT_ID_BUDGET_TYPE=q.INT_ID_BUDGET_TYPE
                    and y.BIT_FLG_DEL=0 and x.BIT_FLG_CPX=0
                    and x.INT_ID_FISCAL_YEAR=$fiscal and x.INT_ID_SECTION=$section
                    group by q.INT_ID_BUDGET_TYPE, q.CHR_BUDGET_TYPE, q.CHR_BUDGET_TYPE_DESC) b
                    where a.INT_ID_BUDGET_TYPE =b.INT_ID_BUDGET_TYPE 
                    and a.BIT_FLG_DEL=0")->result();
    }
    
    function get_budgettype_top_one() {
        $query = $this->db->query("select top 1 INT_ID_BUDGET_TYPE from CPL.TM_BUDGET_TYPE where BIT_FLG_DEL = 0")->row_array();
        $part_of = $query['INT_ID_BUDGET_TYPE'];
        return $part_of;
    }

    function get_init_budgettype($id) {
        $query = $this->db->query("select CHR_BUDGET_TYPE from CPL.TM_BUDGET_TYPE where INT_ID_BUDGET_TYPE = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_TYPE'];
        return $part_of;
    }

    function get_desc_budgettype($id) {
        $query = $this->db->query("select CHR_BUDGET_TYPE_DESC from CPL.TM_BUDGET_TYPE where INT_ID_BUDGET_TYPE = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_TYPE_DESC'];
        return $part_of;
    }

    function get_budgettype_by_budgetsubgroup($id) {
        $query = $this->db->query("select INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, CHR_BUDGET_TYPE_DESC from CPL.TM_BUDGET_TYPE where BIT_FLG_DEL = 0 and INT_ID_BUDGET_SUB_GROUP = '" . $id . "'");
        return $query->result();
    }
    
    function get_budgetsubgroup_by_budgettype($id) {
        $query = $this->db->query("select INT_ID_BUDGET_SUB_GROUP from CPL.TM_BUDGET_TYPE where INT_ID_BUDGET_TYPE = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_BUDGET_SUB_GROUP'];
        return $part_of;
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function get_data($id) {
        $query = $this->db->query("select INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, INT_ID_BUDGET_SUB_GROUP, CHR_BUDGET_TYPE_DESC 
            from CPL.TM_BUDGET_TYPE where INT_ID_BUDGET_TYPE = '" . $id . "' and BIT_FLG_DEL = 0");
        return $query;
    }

    function update($data, $id) {
        $this->db->where('INT_ID_BUDGET_TYPE', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => '1');
        $this->db->where('INT_ID_BUDGET_TYPE', $id);
        $this->db->update($this->table, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_BUDGET_TYPE where CHR_BUDGET_TYPE = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    //id group 1-9
    function generate_id_budgettype() {
        return $this->db->query('select max(INT_ID_BUDGET_TYPE) as a from CPL.TM_BUDGET_TYPE')->row()->a + 1;
    }

    function get_budget_type_expense(){
        return $this->db->query("select INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, CHR_BUDGET_TYPE_DESC
                                from CPL.TM_BUDGET_TYPE  
                                where INT_ID_BUDGET_SUB_GROUP = 2 
                                and BIT_FLG_DEL = 0")->result();
    }
    
    function get_budget_type_subexpense($dept){
        return $this->db->query("select a.INT_ID_BUDGET_TYPE, a.CHR_BUDGET_TYPE, a.CHR_BUDGET_TYPE_DESC
                                from CPL.TM_BUDGET_TYPE a, TT_DEPT_SUBEXPENSE b
                                where a.INT_ID_BUDGET_SUB_GROUP = 3 
                                and a.BIT_FLG_DEL = 0 and a.INT_ID_BUDGET_TYPE=b.INT_ID_BUDGET_TYPE and b.INT_ID_DEPT=$dept")->result();
    }
    
//===================== UPDATE 16/07/2017 ---- FOR BUDGET ====================//
    function get_budget_type_expense_by_amount() {
        return $this->db->query("SELECT  INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, CHR_BUDGET_TYPE_DESC
                                FROM         CPL.TM_BUDGET_TYPE
                                WHERE     (INT_ID_BUDGET_SUB_GROUP = 2) AND (BIT_FLG_DEL = 0)")->result();
    }

    function get_budget_type_expense_by_basic_unit() {
        return $this->db->query("SELECT  INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, CHR_BUDGET_TYPE_DESC
                                FROM         CPL.TM_BUDGET_TYPE
                                WHERE     (INT_ID_BUDGET_SUB_GROUP = 3) AND (BIT_FLG_DEL = 0) ORDER BY CHR_BUDGET_TYPE_DESC")->result();
    }

    function get_budget_type($budget_type) {
        return $this->db->query("SELECT     INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, CHR_BUDGET_TYPE_DESC
                FROM         CPL.TM_BUDGET_TYPE
                WHERE     (INT_ID_BUDGET_TYPE = $budget_type)")->row();
    }
    
    function get_authorize_budgettype_basic_unit($kode_dept) {
        return $this->db->query("SELECT     A.INT_ID_BUDGET_TYPE, A.CHR_BUDGET_TYPE, B.CHR_BUDGET_TYPE_DESC
                FROM         CPL.TT_MAPPING_AUTHORIZE_EXPENSE AS A
                LEFT JOIN CPL.TM_BUDGET_TYPE AS B ON A.INT_ID_BUDGET_TYPE = B.INT_ID_BUDGET_TYPE
                WHERE     (A.INT_ID_DEPT = '$kode_dept') AND (a.INT_ID_BUDGET_SUB_GROUP = '3') AND (A.INT_FLG_PLANNING = '1')")->result();
    }
    
    function get_authorize_budgettype_amount($kode_dept) {
        return $this->db->query("SELECT     A.INT_ID_BUDGET_TYPE, A.CHR_BUDGET_TYPE, B.CHR_BUDGET_TYPE_DESC
                FROM         CPL.TT_MAPPING_AUTHORIZE_EXPENSE AS A
                LEFT JOIN CPL.TM_BUDGET_TYPE AS B ON A.INT_ID_BUDGET_TYPE = B.INT_ID_BUDGET_TYPE
                WHERE     (A.INT_ID_DEPT = '$kode_dept') AND (a.INT_ID_BUDGET_SUB_GROUP = '2') AND (A.INT_FLG_PLANNING = '1')")->result();
    }
    
}

?>
