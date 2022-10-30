<?php

class budgetsubgroup_m extends CI_Model {

    private $table = 'CPL.TM_BUDGET_SUB_GROUP';

    function get_budgetsubgroup() {
        $query = $this->db->query("select a.INT_ID_BUDGET_SUB_GROUP, a.CHR_BUDGET_SUB_GROUP, a.CHR_BUDGET_SUB_GROUP_DESC, b.CHR_BUDGET_GROUP 
            from CPL.TM_BUDGET_SUB_GROUP a, CPL.TM_BUDGET_GROUP b where a.INT_ID_BUDGET_GROUP=b.INT_ID_BUDGET_GROUP and a.BIT_FLG_DEL = 0 order by CHR_BUDGET_SUB_GROUP");
        return $query->result();
    }

    function get_init_budgetsubgroup($id) {
        $query = $this->db->query("select CHR_BUDGET_SUB_GROUP from CPL.TM_BUDGET_SUB_GROUP where INT_ID_BUDGET_SUB_GROUP = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_SUB_GROUP'];
        return $part_of;
    }

    function get_desc_budgetsubgroup($id) {
        $query = $this->db->query("select CHR_BUDGET_SUB_GROUP_DESC from CPL.TM_BUDGET_SUB_GROUP where INT_ID_BUDGET_SUB_GROUP = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_SUB_GROUP_DESC'];
        return $part_of;
    }
    
    function get_budgetsubgroup_by_budgetgroup($id){
        $query = $this->db->query("select INT_ID_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP_DESC from CPL.TM_BUDGET_SUB_GROUP where BIT_FLG_DEL = 0 and INT_ID_BUDGET_GROUP = '".$id."'");
        return $query->result();
    }

    function get_budgetgroup_by_budgetsubgroup($id) {
        $query = $this->db->query("select INT_ID_BUDGET_GROUP from CPL.TM_BUDGET_SUB_GROUP where INT_ID_BUDGET_SUB_GROUP = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_BUDGET_GROUP'];
        return $part_of;
    }
    
    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function get_data($id) {
        $query = $this->db->query("select a.INT_ID_BUDGET_SUB_GROUP, a.CHR_BUDGET_SUB_GROUP, a.CHR_BUDGET_SUB_GROUP_DESC, a.INT_ID_BUDGET_GROUP, b.CHR_BUDGET_GROUP 
            from CPL.TM_BUDGET_SUB_GROUP a, CPL.TM_BUDGET_GROUP b where a.INT_ID_BUDGET_GROUP=b.INT_ID_BUDGET_GROUP and a.INT_ID_BUDGET_SUB_GROUP = '" . $id . "' and a.BIT_FLG_DEL = 0");
        return $query;
    }

    function update($data, $id) {
        $this->db->where('INT_ID_BUDGET_SUB_GROUP', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => '1');
        $this->db->where('INT_ID_BUDGET_SUB_GROUP', $id);
        $this->db->update($this->table, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_BUDGET_SUB_GROUP where CHR_BUDGET_SUB_GROUP = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    //id group 1-9
    function generate_id_budgetsubgroup() {
        return $this->db->query('select max(INT_ID_BUDGET_SUB_GROUP) as a from CPL.TM_BUDGET_SUB_GROUP')->row()->a + 1;
    }
    
    function get_exp_subgroup(){
        return $this->db->query("select INT_ID_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP_DESC from CPL.TM_BUDGET_SUB_GROUP where INT_ID_BUDGET_GROUP=2")->result();
    }
    
    function get_subgroup_exp_amount(){
        return $this->db->query("select INT_ID_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP, CHR_BUDGET_SUB_GROUP_DESC from CPL.TM_BUDGET_SUB_GROUP where INT_ID_BUDGET_SUB_GROUP = '2'")->result();
    }

}

?>
