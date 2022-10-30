<?php

class budgetsubcategory_m extends CI_Model {

    private $table = 'CPL.TM_BUDGET_SUB_CATEGORY';

    function get_budgetsubcategory() {
        $query = $this->db->query("select a.INT_ID_BUDGET_SUB_CATEGORY, a.CHR_BUDGET_SUB_CATEGORY, a.CHR_BUDGET_SUB_CATEGORY_DESC, b.CHR_BUDGET_CATEGORY, isnull(c.CHR_CODE_CATEGORY_A3,'-') as CHR_CODE_CATEGORY_A3
            from CPL.TM_BUDGET_SUB_CATEGORY a
            left join CPL.TM_BUDGET_CATEGORY b on a.INT_ID_BUDGET_CATEGORY = b.INT_ID_BUDGET_CATEGORY
            left join CPL.TM_BUDGET_CATEGORY_A3 c on a.INT_ID_CATEGORY_A3 = c.INT_ID_CATEGORY_A3 
            where a.BIT_FLG_DEL = 0 order by a.CHR_BUDGET_SUB_CATEGORY");
        return $query->result();
    }

    function get_init_budgetsubcategory($id) {
        $query = $this->db->query("select CHR_BUDGET_SUB_CATEGORY from CPL.TM_BUDGET_SUB_CATEGORY where INT_ID_BUDGET_SUB_CATEGORY = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_SUB_CATEGORY'];
        return $part_of;
    }

    function get_desc_budgetsubcategory($id) {
        $query = $this->db->query("select CHR_BUDGET_SUB_CATEGORY_DESC from CPL.TM_BUDGET_SUB_CATEGORY where INT_ID_BUDGET_SUB_CATEGORY = '" . $id . "'")->row_array();
        $part_of = $query['CHR_BUDGET_SUB_CATEGORY_DESC'];
        return $part_of;
    }
    
    function get_budgetsubcategory_by_budgetcategory($id){
        $query = $this->db->query("select INT_ID_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY_DESC from CPL.TM_BUDGET_SUB_CATEGORY where BIT_FLG_DEL = 0 and INT_ID_BUDGET_CATEGORY = '".$id."'");
        return $query->result();
    }
    
    function get_budgetsubcategory_by_category_a3($id){
        $query = $this->db->query("select a.INT_ID_BUDGET_SUB_CATEGORY, a.CHR_BUDGET_SUB_CATEGORY, a.CHR_BUDGET_SUB_CATEGORY_DESC, b.CHR_BUDGET_CATEGORY
                                    from CPL.TM_BUDGET_SUB_CATEGORY a
                                    left join CPL.TM_BUDGET_CATEGORY b on a.INT_ID_BUDGET_CATEGORY = b.INT_ID_BUDGET_CATEGORY 
                                    where a.BIT_FLG_DEL = 0 and a.INT_ID_CATEGORY_A3 = '".$id."'
                                    order by a.CHR_BUDGET_SUB_CATEGORY");
        return $query->result();
    }
    
    function get_budgetcategory_by_budgetsubcategory($id) {
        $query = $this->db->query("select INT_ID_BUDGET_CATEGORY from CPL.TM_BUDGET_SUB_CATEGORY where INT_ID_BUDGET_SUB_CATEGORY = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_BUDGET_CATEGORY'];
        return $part_of;
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function get_data($id) {
        $query = $this->db->query("select a.INT_ID_BUDGET_SUB_CATEGORY, a.CHR_BUDGET_SUB_CATEGORY, a.CHR_BUDGET_SUB_CATEGORY_DESC, b.CHR_BUDGET_CATEGORY, a.INT_ID_BUDGET_CATEGORY, a.INT_ID_CATEGORY_A3
            from CPL.TM_BUDGET_SUB_CATEGORY a, CPL.TM_BUDGET_CATEGORY b where a.INT_ID_BUDGET_CATEGORY=b.INT_ID_BUDGET_CATEGORY and a.INT_ID_BUDGET_SUB_CATEGORY = '" . $id . "' and a.BIT_FLG_DEL = 0");
        return $query;
    }
    
    function get_id_subcategory($subcategory) {
        $query = $this->db->query("select INT_ID_BUDGET_SUB_CATEGORY
            from CPL.TM_BUDGET_SUB_CATEGORY where CHR_BUDGET_SUB_CATEGORY = '$subcategory' and BIT_FLG_DEL = 0")->row();
        return $query;
    }

    function update($data, $id) {
        $this->db->where('INT_ID_BUDGET_SUB_CATEGORY', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => '1');
        $this->db->where('INT_ID_BUDGET_SUB_CATEGORY', $id);
        $this->db->update($this->table, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_BUDGET_SUB_CATEGORY where CHR_BUDGET_SUB_CATEGORY = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    //id group 1-9
    function generate_id_budgetsubcategory() {
        return $this->db->query('select max(INT_ID_BUDGET_SUB_CATEGORY) as a from CPL.TM_BUDGET_SUB_CATEGORY')->row()->a + 1;
    }
    
    function get_budgetsubcategory_by_category($x){
        return $this->db->query("select INT_ID_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY_DESC
                                from CPL.TM_BUDGET_SUB_CATEGORY
                                where INT_ID_BUDGET_CATEGORY=$x")->result();
    }
    function test($x){
        return $this->db->query("select INT_ID_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY, CHR_BUDGET_SUB_CATEGORY_DESC
                                from CPL.TM_BUDGET_SUB_CATEGORY
                                where INT_ID_BUDGET_CATEGORY=$x")->num_rows;
    }

}

?>
