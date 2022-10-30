<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class error_log_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //chart
    function select_summary_error_log_by_classname() {
        $stored_procedure = "EXEC INV.zsp_get_summary_error_log_by_classname";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    //total row
    function select_total_row() {
        $stored_procedure = "EXEC INV.zsp_get_summary_error_log_by_classname";

        $query = $this->db->query($stored_procedure);
        return $query->num_rows();
    }
    
    //grid table
    function get_error_log() {
        $stored_procedure = "EXEC INV.zsp_get_error_log";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    //Get count data error log
    function total_data_error_log() {
        $stored_procedure = "EXEC INV.zsp_get_summary_error_log";

        $query = $this->db->query($stored_procedure);
        return $query->row();
    }
    
    public function get_log_error_production() {
        $this->db->where('CHR_STATUS', 'E');
        $this->db->order_by('INT_NUMBER', 'asc');
        return $this->db->get('TT_PRODUCTION_RESULT')->result();
    }

    public function get_log_error_po_gr() {
        return $this->db->query("SELECT  a.CHR_PDS_NO, a.INT_PDS_DELNO, a.CHR_UPLOAD, a.CHR_REMARKS, b.INT_PDS_LINENO, b.CHR_PART_NO, b.INT_RECQTY
                            FROM  TT_PURCHASE_RECEIPT_H AS a INNER JOIN
                            TT_PURCHASE_RECEIPT_L AS b ON a.CHR_PDS_NO = b.CHR_PDS_NO
                            WHERE     (a.CHR_UPLOAD = 'E')  ")->result();
    }

    public function get_log_error_movement() { //UPDATE ILHAM, ADD VALUATION CLASS NAME
        return $this->db->query("SELECT b.CHR_DATE_UPLOAD, b.CHR_TIME_UPLOAD, 
                        b.CHR_UPLOAD, b.CHR_STATUS, b.CHR_MESSAGE, 
                        b.CHR_PART_NO, b.CHR_SLOC_FROM, b.CHR_SLOC_TO, 
                        b.INT_TOTAL_QTY, b.CHR_UOM 
                        FROM TT_GOODS_MOVEMENT_H AS a INNER JOIN TT_GOODS_MOVEMENT_L AS b ON 
                        a.INT_NUMBER = b.INT_NUMBER 
                        WHERE (b.CHR_STATUS = 'E')")->result();
    }
    
    
}

?>
