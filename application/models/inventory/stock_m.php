<?php

class stock_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //chart
    function select_summary_inventory_by_prod()
    {
        $stored_procedure = "EXEC PPC.zsp_get_negative_stock_summary_by_dept";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //chart line
    function select_summary_inventory_by_date()
    {
        $stored_procedure = "EXEC INV.zsp_get_summary_negative_stock";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //total row
    function select_total_row()
    {
        $stored_procedure = "EXEC PPC.zsp_get_negative_stock_summary_by_dept";

        $query = $this->db->query($stored_procedure);
        return $query->num_rows();
    }

    //grid table
    function select_data_inventory_by_prod()
    {
        $stored_procedure = "EXEC PPC.zsp_get_negative_stock_detail";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //Get all data inventory
    function total_data_stock()
    {
        $stored_procedure = "EXEC PPC.zsp_get_negative_stock_summary";

        $query = $this->db->query($stored_procedure);
        return $query->row();
    }

    //chart
    function select_summary_exceeded_inventory_by_prod()
    {
        $stored_procedure = "EXEC PPC.zsp_get_exceeded_stock_summary_by_dept";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //total row
    function select_total_exceeded_row()
    {
        $stored_procedure = "EXEC PPC.zsp_get_exceeded_stock_summary_by_dept";

        $query = $this->db->query($stored_procedure);
        return $query->num_rows();
    }

    //grid table
    function select_data_exceeded_inventory_by_prod()
    {
        $stored_procedure = "EXEC PPC.zsp_get_exceeded_stock_detail";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //Get all data inventory
    function total_data_exceeded_stock()
    {
        $stored_procedure = "EXEC PPC.zsp_get_exceeded_stock_summary";

        $query = $this->db->query($stored_procedure);
        return $query->row();
    }


    //get acquired date
    function select_acquired_date_summary_inventory()
    {
        $query = $this->db->query("SELECT TOP 1 CHR_CREATE_DATE, CHR_CREATE_TIME 
                    FROM TT_NEGATIVE_STOCK_SUMMARY 
                    ORDER BY CHR_CREATE_DATE DESC");

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }



    //get acquired date
    function select_acquired_date_summary_inventory_exceed_stock()
    {
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
    function select_summary_inventory_by_date_exceed_stock()
    {
        $stored_procedure = "EXEC INV.zsp_get_summary_exceeded_stock";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    //Get all data inventory
    function check_stat_in_out_tmstock()
    {
        $query = "select CHR_STAT from  TW_INTERFACE_STOCK where CHR_PROCESS_NAME = 'IN_OUT_STOCK'";

        $stat = $this->db->query($query)->row();
        return $stat->CHR_STAT;
    }
}
