<?php

class budgetproduct_m extends CI_Model {

    private $table = 'TW_BUDGET_PRODUCT';

    function prepare_save($product, $id, $name) {
        $this->db->set('INT_NO_BUDGET_CPX_TEMP', $id);
        $this->db->set('INT_ID_PRODUCT', $product);
        $this->db->set('CHR_CREATE_BY', $name);
        $this->db->set('CHR_CREATE_DATE', date('Ymd'));
        $this->db->set('CHR_CREATE_TIME', date('His'));

        $this->db->insert($this->table);
    }

    function get_data_product($id) {
        $query = $this->db->query("select a.INT_ID_PRODUCT, a.INT_NO_BUDGET_CPX_TEMP, b.CHR_PRODUCT, b.CHR_PRODUCT_DESC 
            from TW_BUDGET_PRODUCT a,TM_PRODUCT b,TW_BUDGET_CAPEX c 
            where a.INT_ID_PRODUCT=b.INT_ID_PRODUCT and a.INT_NO_BUDGET_CPX_TEMP=c.INT_NO_BUDGET_CPX_TEMP and
            a.INT_NO_BUDGET_CPX_TEMP = '" . $id . "'");
        return $query->result();
    }
    
    function get_data_product_close($id) {
        $query = $this->db->query("select a.INT_ID_PRODUCT, a.INT_NO_BUDGET_CPX, b.CHR_PRODUCT, b.CHR_PRODUCT_DESC 
            from TT_BUDGET_PRODUCT a,TM_PRODUCT b,TT_BUDGET_CAPEX c 
            where a.INT_ID_PRODUCT=b.INT_ID_PRODUCT and a.INT_NO_BUDGET_CPX=c.INT_NO_BUDGET_CPX and
            a.INT_NO_BUDGET_CPX = '" . $id . "'");
        return $query->result();
    }

    function cek_product_close($no_budget) {
        $query = $this->db->query("select INT_ID_PRODUCT from TT_BUDGET_PRODUCT where INT_NO_BUDGET_CPX = '" . $no_budget . "'");
        if ($query->num_rows() != 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    
    function cek_product($no_budget) {
        $query = $this->db->query("select * from TW_BUDGET_PRODUCT where INT_NO_BUDGET_CPX_TEMP = '".$no_budget."'");
        if ($query->num_rows() != 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    
    function get_current_data_product($id) {
        $this->db->select('INT_ID_PRODUCT');
        $this->db->from('TW_BUDGET_PRODUCT');
        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $id);
        $query = $this->db->get()->result();

        $this->db->select('INT_ID_PRODUCT, CHR_PRODUCT, CHR_PRODUCT_DESC');
        $this->db->from('TM_PRODUCT');
        $this->db->where('BIT_FLG_DEL', 0);
        foreach ($query as $row) {
            $this->db->where("INT_ID_PRODUCT <>'" . $row->INT_ID_PRODUCT . "'");
        }

        $query_in_query = $this->db->get()->result();
        return $query_in_query;
    }

    function delete($id, $no) {
        $this->db->where('INT_ID_PRODUCT', $id);
        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $no);
        $this->db->delete($this->table);
    }

}

?>
