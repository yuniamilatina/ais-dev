<?php

class good_movement_m extends CI_Model {

    function get_data_scan_out($start_date, $finish_date) {
        $stored_procedure = "EXEC GOM.zsp_get_stock_out ?,?";
        $param = array(
            'start_date' => $start_date,
            'finish_date' => $finish_date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }

    function get_data_summary_scan_out($start_date, $finish_date) {
        $stored_procedure = "EXEC GOM.zsp_get_stock_out_summary ?,?";
        $param = array(
            'start_date' => $start_date,
            'finish_date' => $finish_date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
    
    function get_data_sto_raw_mtrl($pic_sto, $start_date, $finish_date) {
        $stored_procedure = "EXEC GOM.zsp_get_rm_sto ?,?,?";
        $param = array(
            'pic_sto' => $pic_sto,
            'start_date' => $start_date,
            'finish_date' => $finish_date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
	
    function get_all_scan_out_rm($start_date, $finish_date) {
        $stored_procedure = "EXEC GOM.zsp_get_sco_rfid_rm_all ?,?";
        $param = array(
            'start_date' => $start_date,
            'finish_date' => $finish_date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
    
    function get_data_scan_out_rm($pic_sto, $start_date, $finish_date) {
        $stored_procedure = "EXEC GOM.zsp_get_sco_rfid_rm ?,?,?";
        $param = array(
            'pic_sto' => $pic_sto,
            'start_date' => $start_date,
            'finish_date' => $finish_date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
    
    function get_data_sto_raw_mtrl_detail($id, $date) {
        $stored_procedure = "EXEC GOM.zsp_get_rm_sto_detail ?,?";
        $param = array(            
            'id' => $id,
            'date' => $date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
	
	function get_data_scan_out_rm_detail($id, $date) {
        $stored_procedure = "EXEC GOM.zsp_get_sco_rfid_rm_detail ?,?";
        $param = array(            
            'id' => $id,
            'date' => $date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
    
    function get_data_sto_raw_mtrl_dtl_excel($id_sto, $date_sto,$time_sto) {
        $stored_procedure = "EXEC GOM.zsp_get_rm_sto_dtl_excel ?,?,?";
        $param = array(            
            'id_sto' => $id_sto,
			'date_sto' => $date_sto,
            'time_sto' => $time_sto);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
	
	function get_data_scan_out_rm_dtl_excel($id_scr, $date_scr,$time_scr) {
        $stored_procedure = "EXEC GOM.zsp_get_sco_rfid_rm_dtl_excel ?,?,?";
        $param = array(            
            'id_scr' => $id_scr,
			'date_scr' => $date_scr,
            'time_scr' => $time_scr);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
    
    function get_data_scan_out_plastic($start_date, $finish_date) {
        $stored_procedure = "EXEC GOM.zsp_get_stock_out_plastic ?,?";
        $param = array(
            'start_date' => $start_date,
            'finish_date' => $finish_date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }
    
    function get_data_summary_scan_out_plastic($start_date, $finish_date) {
        $stored_procedure = "EXEC GOM.zsp_get_stock_out_plastic_summary ?,?";
        $param = array(
            'start_date' => $start_date,
            'finish_date' => $finish_date);

        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }

}
