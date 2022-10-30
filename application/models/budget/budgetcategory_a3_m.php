<?php

class budgetcategory_a3_m extends CI_Model {

    private $table = 'CPL.TM_BUDGET_CATEGORY_A3';

    function get_budgetcategory_a3() {
        $query = $this->db->query("select a.INT_ID_CATEGORY_A3, a.CHR_CODE_CATEGORY_A3, a.CHR_DESC_CATEGORY_A3, b.CHR_BUDGET_GROUP
            from CPL.TM_BUDGET_CATEGORY_A3 a, CPL.TM_BUDGET_GROUP b where a.INT_ID_BUDGET_GROUP = b.INT_ID_BUDGET_GROUP and a.INT_FLG_DELETE = 0 order by a.CHR_CODE_CATEGORY_A3");
        return $query->result();
    }
    
    function get_budget_group(){
        $query = $this->db->query("select INT_ID_BUDGET_GROUP, CHR_BUDGET_GROUP, CHR_BUDGET_GROUP_DESC
            from CPL.TM_BUDGET_GROUP where BIT_FLG_DEL = 0");
        return $query->result();
    }
    
    function generate_id_budgetcategory_a3() {
        return $this->db->query('select max(INT_ID_CATEGORY_A3) as a from CPL.TM_BUDGET_CATEGORY_A3')->row()->a + 1;
    }
     
    function get_budgetcategory_capex() {
        $query = $this->db->query("select a.INT_ID_BUDGET_CATEGORY, a.CHR_BUDGET_CATEGORY, a.CHR_BUDGET_CATEGORY_DESC, b.CHR_BUDGET_TYPE 
            from CPL.TM_BUDGET_CATEGORY a, CPL.TM_BUDGET_TYPE b where a.INT_ID_BUDGET_TYPE =b.INT_ID_BUDGET_TYPE and b.INT_ID_BUDGET_TYPE=1 and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_init_budgetcategory($id) {
        $query = $this->db->query("select CHR_BUDGET_CATEGORY from CPL.TM_BUDGET_CATEGORY where INT_ID_BUDGET_CATEGORY = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_CATEGORY'];
        return $part_of;
    }

    function get_desc_budgetcategory($id) {
        $query = $this->db->query("select CHR_BUDGET_CATEGORY_DESC from CPL.TM_BUDGET_CATEGORY where INT_ID_BUDGET_CATEGORY = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_CATEGORY_DESC'];
        return $part_of;
    }
    
    function get_budgetcategory_by_budgettype($id){
        $query = $this->db->query("select INT_ID_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC from CPL.TM_BUDGET_CATEGORY where BIT_FLG_DEL = 0 and INT_ID_BUDGET_TYPE = '".$id."'");
        return $query->result();
    }
    
    function get_budgettype_by_budgetcategory($id) {
        $query = $this->db->query("select INT_ID_BUDGET_TYPE from CPL.TM_BUDGET_CATEGORY where INT_ID_BUDGET_CATEGORY = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_BUDGET_TYPE'];
        return $part_of;
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function get_data($id) {
        $query = $this->db->query("select INT_ID_CATEGORY_A3, CHR_CODE_CATEGORY_A3, CHR_DESC_CATEGORY_A3, INT_ID_BUDGET_GROUP 
            from CPL.TM_BUDGET_CATEGORY_A3 where INT_ID_CATEGORY_A3 = '" . $id . "' and INT_FLG_DELETE = 0");
        return $query;
    }

    function update($data, $id) {
        $this->db->where('INT_ID_CATEGORY_A3', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => '1');
        $this->db->where('INT_ID_BUDGET_CATEGORY', $id);
        $this->db->update($this->table, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_BUDGET_CATEGORY_A3 where CHR_CODE_CATEGORY_A3 = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    
}

?>
