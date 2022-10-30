<?php
	/**
	* 
	*/
	class outhouse_m extends CI_Model
	{
		
		private $tabel = 'dbo.TM_PART_OUTHOUSE';
        private $tabel1 = 'dbo.TM_SEQUENCE_01';
        private $tabel3 = 'dbo.TT_PROGRESS_PART_OUTHOUSE';

	    function get_device() {
	        $query = $this->db->query("SELECT * from ".$this->tabel." where INT_FLG_DEL = 0");
	        return $query->result();
	    }

	    function save_device($data) {
	        $this->db->insert($this->tabel, $data);
	    }
       function save($data_tt) {
	        $this->db->insert($this->tabel3, $data_tt);
	    }
	    function get_data_device($id) {
	        
            $query = $this->db->query("SELECT *  FROM ".$tabel." WHERE INT_NO_PART = " . $id . "");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function update($data, $id) {
            
	        $this->db->where('INT_NO_PART', $id);
	        $this->db->update($this->tabel, $data);
	    }
         function get_checksheet() {
	        $query = $this->db->query("select CHR_ITEM, CHR_TM_NUMBER, CHR_PART_NAME, CHR_MODEL, CHR_MAT, CHR_SUPPLIER, INT_QTY, CHR_DIMENSI, CHR_PROG_RM, CHR_PROG_DELIVERY, CHR_PROG_RECEIVING, CHR_PROG_FIN from TM_PART_OUTHOUSE");
	    }
        function get_checksheet_by_date2($date2) {
	        $query = $this->db->query("select CHR_ITEM, CHR_TM_NUMBER, CHR_PART_NAME, CHR_MODEL, CHR_MAT, CHR_SUPPLIER, INT_QTY, CHR_DIMENSI, CHR_PROG_RM, CHR_PROG_DELIVERY, CHR_PROG_RECEIVING, CHR_PROG_FIN from TM_PART_OUTHOUSE where CHR_CREATED_DATE <= $date2 and INT_FLG_DEL = 0 Order by CHR_CREATED_DATE ASC");
	        return $query->result();
	    }
	    function get_checksheet_by_date1($date1) {
	       $query = $this->db->query("select CHR_ITEM, CHR_TM_NUMBER, CHR_PART_NAME, CHR_MODEL, CHR_MAT, CHR_SUPPLIER, INT_QTY, CHR_DIMENSI, CHR_PROG_RM, CHR_PROG_DELIVERY, CHR_PROG_RECEIVING, CHR_PROG_FIN from TM_PART_OUTHOUSE where CHR_CREATED_DATE >= $date1 and INT_FLG_DEL = 0 Order by CHR_CREATED_DATE ASC");
	        return $query->result();
	    }
	    function get_checksheet_by_date($date1,$date2) {
	        $query = $this->db->query("select CHR_ITEM, CHR_TM_NUMBER, CHR_PART_NAME, CHR_MODEL, CHR_MAT, CHR_SUPPLIER, INT_QTY, CHR_DIMENSI, CHR_PROG_RM, CHR_PROG_DELIVERY, CHR_PROG_RECEIVING, CHR_PROG_FIN from TM_PART_OUTHOUSE where CHR_CREATED_DATE >= $date1 and CHR_CREATED_DATE <= $date2 and INT_FLG_DEL = 0  Order by CHR_CREATED_DATE ASC");
	        return $query->result();
	    }	    
    }
?>