<?php

class budgetgroup_m extends CI_Model {

    private $table = 'CPL.TM_BUDGET_GROUP';

    function get_budgetgroup() {
        $query = $this->db->query("select INT_ID_BUDGET_GROUP, CHR_BUDGET_GROUP, CHR_BUDGET_GROUP_DESC from CPL.TM_BUDGET_GROUP where BIT_FLG_DEL = 0 order by CHR_BUDGET_GROUP");
        return $query->result();
    }

    function get_init_budgetgroup($id) {
        $query = $this->db->query("select CHR_BUDGET_GROUP from CPL.TM_BUDGET_GROUP where INT_ID_BUDGET_GROUP = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_GROUP'];
        return $part_of;
    }

    function get_desc_budgetgroup($id) {
        $query = $this->db->query("select CHR_BUDGET_GROUP_DESC from CPL.TM_BUDGET_GROUP where INT_ID_BUDGET_GROUP = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_GROUP_DESC'];
        return $part_of;
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function get_data($id) {
        $query = $this->db->query("select INT_ID_BUDGET_GROUP, CHR_BUDGET_GROUP ,CHR_BUDGET_GROUP_DESC 
            from CPL.TM_BUDGET_GROUP where INT_ID_BUDGET_GROUP = '" . $id . "' and BIT_FLG_DEL = 0");
        return $query;
    }

    function update($data, $id) {
        $this->db->where('INT_ID_BUDGET_GROUP', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => '1');
        $this->db->where('INT_ID_BUDGET_GROUP', $id);
        $this->db->update($this->table, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_BUDGET_GROUP where CHR_BUDGET_GROUP = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    //id group 1-9
    function generate_id_budgetgroup() {
        return $this->db->query('select max(INT_ID_BUDGET_GROUP) as a from CPL.TM_BUDGET_GROUP')->row()->a + 1;
    }

}

?>
