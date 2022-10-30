<?php

class inventory_exceeded_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //chart
    function select_summary_inventory_by_prod() {
        $stored_procedure = "EXEC INV.zsp_get_exceeded_stock_summary_by_dept";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //total row
    function select_total_row() {
        $stored_procedure = "EXEC INV.zsp_get_exceeded_stock_summary_by_dept";

        $query = $this->db->query($stored_procedure);
        return $query->num_rows();
    }

    //grid table
    function select_data_inventory_by_prod() {
        $stored_procedure = "EXEC INV.zsp_get_exceeded_stock_detail";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //Get all data inventory
    function total_data_stock() {
        $stored_procedure = "EXEC INV.zsp_get_exceeded_stock_summary";

        $query = $this->db->query($stored_procedure);
        return $query->row();
    }

}
?>

