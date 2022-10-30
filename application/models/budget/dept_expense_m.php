<?php

class dept_expense_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tt_de = 'TT_DEPT_EXPENSE';
    private $tt_ds = 'TT_DEPT_SUBEXPENSE';
    private $tm_group = 'TM_GROUP';

    function get_dept_expense($id) {
        $this->db->select('INT_ID_DEPT,INT_ID_BUDGET_CATEGORY');
        $this->db->where('INT_ID_DEPT', $id);
        return $this->db->get($this->tt_de)->result();
    }
    
    function get_dept_subexpense($id) {
        $this->db->select('INT_ID_DEPT,INT_ID_BUDGET_TYPE');
        $this->db->where('INT_ID_DEPT', $id);
        return $this->db->get($this->tt_ds)->result();
    }

    function get_dept_expense_detail($id) {
        return $this->db->query("select c.INT_ID_DEPT, c.INT_ID_BUDGET_CATEGORY, a.CHR_DEPT, a.CHR_DEPT_DESC, b.CHR_BUDGET_CATEGORY, b.CHR_BUDGET_CATEGORY_DESC
                                from TM_BUDGET_CATEGORY b, TM_DEPT a, TT_DEPT_EXPENSE c
                                where a.INT_ID_DEPT=c.INT_ID_DEPT 
                                and b.INT_ID_BUDGET_CATEGORY=c.INT_ID_BUDGET_CATEGORY 
                                and c.INT_ID_DEPT='$id'")->result();
    }
    function get_dept_subexpense_detail($id) {
        return $this->db->query("select c.INT_ID_DEPT, c.INT_ID_BUDGET_TYPE, a.CHR_DEPT, a.CHR_DEPT_DESC, b.CHR_BUDGET_TYPE, b.CHR_BUDGET_TYPE_DESC
                                from TM_BUDGET_TYPE b, TM_DEPT a, TT_DEPT_SUBEXPENSE c
                                where a.INT_ID_DEPT=c.INT_ID_DEPT 
                                and b.INT_ID_BUDGET_TYPE=c.INT_ID_BUDGET_TYPE
                                and c.INT_ID_DEPT='$id'")->result();
    }

    function get_dept_expense_for_dll($id,$x) {
        
        return $this->db->query("select c.INT_ID_BUDGET_CATEGORY, b.CHR_BUDGET_CATEGORY, b.CHR_BUDGET_CATEGORY_DESC, b.INT_ID_BUDGET_TYPE
                                from TM_BUDGET_CATEGORY b, TT_DEPT_EXPENSE c
                                 where b.INT_ID_BUDGET_CATEGORY=c.INT_ID_BUDGET_CATEGORY and c.INT_ID_DEPT=$id and b.INT_ID_BUDGET_TYPE=$x ")->result();
    }
    function get_dept_subexpense_for_dll($id,$x) {
        return $this->db->query("select c.INT_ID_BUDGET_SUB_CATEGORY, b.CHR_BUDGET_SUB_CATEGORY, b.CHR_BUDGET_SUB_CATEGORY_DESC, b.INT_ID_BUDGET_CATEGORY
                                from TM_BUDGET_SUB_CATEGORY b, TT_DEPT_SUBEXPENSE c
                                 where b.INT_ID_BUDGET_SUB_CATEGORY=c.INT_ID_BUDGET_SUB_CATEGORY and c.INT_ID_DEPT=$id and b.INT_ID_BUDGET_CATEGORY=$x")->result();
    }

    function get_pure_expense_sub() {
        return $this->db->query("select INT_ID_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, INT_ID_BUDGET_TYPE
                                from TM_BUDGET_CATEGORY
                                where INT_ID_BUDGET_TYPE ='6' or INT_ID_BUDGET_TYPE='10'")->result();
    }
    
    function get_subexpense_sub() {
        return $this->db->query("select INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, CHR_BUDGET_TYPE_DESC, INT_ID_BUDGET_SUBGROUP
                                from TM_BUDGET_TYPE
                                where INT_ID_BUDGET_SUBGROUP='3'")->result();
    }

    function get_pure_expense() {
        return $this->db->query("select INT_ID_BUDGET_TYPE, CHR_BUDGET_TYPE, CHR_BUDGET_TYPE_DESC, INT_ID_BUDGET_SUBGROUP 
                                from TM_BUDGET_TYPE
                                where INT_ID_BUDGET_SUBGROUP ='2'")->result();
    }
    function get_subexpense() {
        return $this->db->query("select INT_ID_BUDGET_SUBGROUP, CHR_BUDGET_SUBGROUP, CHR_BUDGET_SUBGROUP_DESC
                                from TM_BUDGET_SUBGROUP
                                where INT_ID_BUDGET_SUBGROUP ='3'")->result();
    }

//    function get_detail($id) {
//        $this->db->where('INT_ID_GROUP', $id);
//        return $this->db->get($this->tm_group)->row();
//    }

    function delete_dept_expense($id) {
        $this->db->where('INT_ID_DEPT', $id);
        $this->db->delete('TT_DEPT_EXPENSE');
    }
    function delete_dept_subexpense($id) {
        $this->db->where('INT_ID_DEPT', $id);
        $this->db->delete('TT_DEPT_SUBEXPENSE');
    }

    function save_dept_expense($dept, $expense, $name) {
        $this->db->set('INT_ID_DEPT', $dept);
        $this->db->set('INT_ID_BUDGET_CATEGORY', $expense);
        $this->db->set('CHR_CREATE_BY', $name);
        $this->db->set('CHR_CREATE_DATE', date('Ymd'));
        $this->db->set('CHR_CREATE_TIME', date('His'));
        $this->db->insert($this->tt_de);
    }
    function save_dept_subexpense($dept, $subexpense, $name) {
        $this->db->set('INT_ID_DEPT', $dept);
        $this->db->set('INT_ID_BUDGET_TYPE', $subexpense);
        $this->db->set('CHR_CREATE_BY', $name);
        $this->db->set('CHR_CREATE_DATE', date('Ymd'));
        $this->db->set('CHR_CREATE_TIME', date('His'));
        $this->db->insert($this->tt_ds);
    }

    function if_exist($id) {
        $this->db->where('INT_ID_DEPT', $id);
        $x = $this->db->get($this->tt_de);
        if ($x->num_rows() == 0) {
            return false;
        } else {
            return TRUE;
        }
    }
    function if_exist_sub($id) {
        $this->db->where('INT_ID_DEPT', $id);
        $x = $this->db->get($this->tt_ds);
        if ($x->num_rows() == 0) {
            return false;
        } else {
            return TRUE;
        }
    }

}

?>
