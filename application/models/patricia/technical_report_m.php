<?php
	/**
	* 
	*/
	class technical_report_m extends CI_Model
	{
		
	    function get_technical() {
	        $query = $this->db->query("SELECT a.INT_TR_ID, a.CHR_COMPONENT_ID, a.CHR_TR_NO, a.CHR_PROB_EXP, a.CHR_PROB_RANK, a.CHR_TR_DATE,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR FROM TT_TECH_REPORT as a INNER JOIN TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR");
	        return $query->result();
		}
		
		function get_technical_by_date2($date2) {
	        $query = $this->db->query("SELECT a.INT_TR_ID, a.CHR_COMPONENT_ID, a.CHR_TR_NO, a.CHR_PROB_EXP, a.CHR_PROB_RANK, a.CHR_TR_DATE,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR FROM TT_TECH_REPORT as a INNER JOIN TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR 
	        	where a.CHR_TR_DATE <= $date2");
	        return $query->result();
		}
		
	    function get_technical_by_date1($date1) {
	        $query = $this->db->query("SELECT a.INT_TR_ID, a.CHR_COMPONENT_ID, a.CHR_TR_NO, a.CHR_PROB_EXP, a.CHR_PROB_RANK, a.CHR_TR_DATE,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR FROM TT_TECH_REPORT as a INNER JOIN TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR 
	        	where  a.CHR_TR_DATE >= $date1");
	        return $query->result();
		}
		
	    function get_technical_by_date($date1,$date2) {
	        $query = $this->db->query("SELECT a.INT_TR_ID, a.CHR_COMPONENT_ID, a.CHR_TR_NO, a.CHR_PROB_EXP, a.CHR_PROB_RANK, a.CHR_TR_DATE,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR FROM TT_TECH_REPORT as a INNER JOIN TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR 
	        	where a.CHR_TR_DATE >= $date1 and a.CHR_TR_DATE <= $date2");
	        return $query->result();
		}
		
	    function get_data_tr($id) {
			$query = $this->db->query("SELECT a.CHR_PROB_INFO, a.INT_TR_ID, a.CHR_DEFECT_TYPE, a.CHR_TR_NO, a.CHR_TR_DATE,c.CHR_ID_PART_HYP,c.CHR_NAMA_PART,c.CHR_NAMA_VENDOR,a.INT_QUANTITY, a.CHR_PROB_RANK,
								a.CHR_PROB_EXP,a.CHR_LOC,a.CHR_STD_PART,a.CHR_ACT_PART,a.CHR_IMAGE,a.CHR_TEMP_ACTION, a.CHR_TR_HOUR,a.CHR_SUBMIT_PRE,a.CHR_SUBMIT_FINAL,a.CHR_MONITOR_IMPROV
								FROM TT_TECH_REPORT as a left INNER JOIN TT_CHECK_SHEET as b on a.CHR_COMPONENT_ID = b.CHR_COMPONENT_ID
								left INNER JOIN TM_STO as c on c.CHR_ID_PART = b.CHR_COMPONENT_ID and c.CHR_KODE_VENDOR = a.CHR_KODE_VENDOR
								where a.INT_TR_ID= $id
								group by a.INT_TR_ID, a.CHR_DEFECT_TYPE, a.CHR_TR_NO, a.CHR_TR_DATE,c.CHR_ID_PART_HYP,c.CHR_NAMA_PART,a.INT_QUANTITY, a.CHR_PROB_RANK,a.CHR_PROB_EXP,a.CHR_LOC,c.CHR_NAMA_VENDOR,
								a.CHR_MONITOR_IMPROV,a.CHR_STD_PART,a.CHR_ACT_PART,a.CHR_IMAGE,a.CHR_TEMP_ACTION, a.CHR_TR_HOUR,a.CHR_SUBMIT_PRE,a.CHR_SUBMIT_FINAL,a.CHR_PROB_INFO");
	        return $query->result();
	    }

	    
	}
?>