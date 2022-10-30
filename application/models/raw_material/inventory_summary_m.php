<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class inventory_summary_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //get acquired date
    function select_acquired_date_summary_inventory() {
        $query = $this->db->query("SELECT TOP 1 CHR_CREATE_DATE, CHR_CREATE_TIME 
                    FROM TT_NEGATIVE_STOCK_SUMMARY 
                    ORDER BY CHR_CREATE_DATE DESC");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }
    
    //chart line
    function select_summary_inventory_by_date() {
        $stored_procedure = "EXEC INV.zsp_get_summary_negative_stock";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    //get acquired date
    function select_acquired_date_summary_inventory_exceed_stock() {
        $query = $this->db->query("SELECT TOP 1 CHR_CREATE_DATE, CHR_CREATE_TIME 
                    FROM TT_EXCEEDED_STOCK_SUMMARY 
                    ORDER BY CHR_CREATE_DATE DESC");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }
    
    //chart line
    function select_summary_inventory_by_date_exceed_stock() {
        $stored_procedure = "EXEC INV.zsp_get_summary_exceeded_stock";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
}