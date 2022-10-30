<?php

class budgetcategory_m extends CI_Model {

    private $table = 'CPL.TM_BUDGET_CATEGORY';

    function get_budgetcategory() {
        $query = $this->db->query("select a.INT_ID_BUDGET_CATEGORY, a.CHR_BUDGET_CATEGORY, a.CHR_BUDGET_CATEGORY_DESC, b.CHR_BUDGET_TYPE 
            from CPL.TM_BUDGET_CATEGORY a, CPL.TM_BUDGET_TYPE b where a.INT_ID_BUDGET_TYPE =b.INT_ID_BUDGET_TYPE and a.BIT_FLG_DEL = 0
            order by a.CHR_BUDGET_CATEGORY");
        return $query->result();
    }
    
    function get_budgetcategory_capex() {
        $query = $this->db->query("select a.INT_ID_BUDGET_CATEGORY, a.CHR_BUDGET_CATEGORY, a.CHR_BUDGET_CATEGORY_DESC, b.CHR_BUDGET_TYPE 
            from CPL.TM_BUDGET_CATEGORY a, CPL.TM_BUDGET_TYPE b where a.INT_ID_BUDGET_TYPE =b.INT_ID_BUDGET_TYPE and b.INT_ID_BUDGET_TYPE=1 and a.BIT_FLG_DEL = 0");
        return $query->result();
    }
    
    function get_budgetcategory_sales() {
        $query = $this->db->query("select a.INT_ID_BUDGET_CATEGORY, a.CHR_BUDGET_CATEGORY, a.CHR_BUDGET_CATEGORY_DESC, b.CHR_BUDGET_TYPE 
            from CPL.TM_BUDGET_CATEGORY a, CPL.TM_BUDGET_TYPE b where a.INT_ID_BUDGET_TYPE =b.INT_ID_BUDGET_TYPE and b.INT_ID_BUDGET_TYPE=14 and a.BIT_FLG_DEL = 0");
        return $query->result();
    }
    
    function get_budgetcategory_expense_foh() {
        $query = $this->db->query("select CHR_BUDGET_CATEGORY 
            from CPL.TM_BUDGET_CATEGORY where CHR_BUDGET_CATEGORY like 'FOH%' and BIT_FLG_DEL = 0");
        return $query->result();
    }
    
    function get_budgetcategory_expense_opx() {
        $query = $this->db->query("select CHR_BUDGET_CATEGORY 
            from CPL.TM_BUDGET_CATEGORY where CHR_BUDGET_CATEGORY like 'OPX%' and BIT_FLG_DEL = 0");
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
    
    function get_budgetcategory_by_category_a3($id){
        $query = $this->db->query("select INT_ID_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC from CPL.TM_BUDGET_CATEGORY where BIT_FLG_DEL = 0 and INT_ID_CATEGORY_A3 = '".$id."'");
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
        $query = $this->db->query("select INT_ID_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, INT_ID_BUDGET_TYPE
            from CPL.TM_BUDGET_CATEGORY where INT_ID_BUDGET_CATEGORY = '" . $id . "' and BIT_FLG_DEL = 0");
        return $query;
    }
    
    function get_id_category($category) {
        $query = $this->db->query("select INT_ID_BUDGET_CATEGORY
            from CPL.TM_BUDGET_CATEGORY where CHR_BUDGET_CATEGORY = '" . $category . "' and BIT_FLG_DEL = 0")->row();
        return $query;
    }

    function update($data, $id) {
        $this->db->where('INT_ID_BUDGET_CATEGORY', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => '1');
        $this->db->where('INT_ID_BUDGET_CATEGORY', $id);
        $this->db->update($this->table, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_BUDGET_CATEGORY where CHR_BUDGET_CATEGORY = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    //id group 1-9
    function generate_id_budgetcategory() {
        return $this->db->query('select max(INT_ID_BUDGET_CATEGORY) as a from CPL.TM_BUDGET_CATEGORY')->row()->a + 1;
    }
    
    function get_budgettype_by_code_category($kode_category){
        return $this->db->query("select B.CHR_BUDGET_TYPE, B.CHR_BUDGET_TYPE_DESC from CPL.TM_BUDGET_CATEGORY as A left join CPL.TM_BUDGET_TYPE as B on A.INT_ID_BUDGET_TYPE = B.INT_ID_BUDGET_TYPE
                                    where A.CHR_BUDGET_CATEGORY = '" . $kode_category . "'")->row();
    }

}

?>
