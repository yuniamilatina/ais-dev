<?php

class group_line_m extends CI_Model {

    private $tabel = 'PRD.TM_GROUP_LINE';

    //this
    function get_data_group_product($id) {
        $query = $this->db->query("SELECT INT_ID, CHR_PRODUCT_GROUP  FROM $this->tabel WHERE INT_ID = '$id'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    //this
    function get_all_prod_group_product() {
        $query = $this->db->query("SELECT INT_ID, CHR_PRODUCT_GROUP FROM $this->tabel ORDER BY CHR_PRODUCT_GROUP ASC")->result();
        return $query;
    }

    function get_all_prod_group_product_custom() {
        $query = $this->db->query("SELECT INT_ID, CHR_PRODUCT_GROUP FROM $this->tabel UNION SELECT 0, 'ALL' FROM $this->tabel")->result();
        return $query;
    }

    //this
    function get_top_prod_group_product() {
        $query = $this->db->query("SELECT TOP (1) INT_ID, CHR_PRODUCT_GROUP FROM $this->tabel ORDER BY CHR_PRODUCT_GROUP ASC");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }
    

}
