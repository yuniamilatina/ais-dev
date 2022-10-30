<?php
	/**
	* 
	*/
	class inhouse_m extends CI_Model
	{
		
		private $tabel = 'dbo.TM_PART_INHOUSE';
        private $tabel1 = 'dbo.TM_SEQUENCE_01';
        private $tabel3 = 'dbo.TT_PROGRESS_PART_INHOUSE';
        private $tabel4 = 'dbo.TW_PART_INHOUSE';

	    function get_device() {
	        $query = $this->db->query("SELECT INT_NO_PART, INT_WEIGHT, CHR_ITEM, CHR_TM_NUMBER, CHR_PROJECT_NAME, CHR_PART_NAME, CHR_MODEL, CHR_MAT, CHR_SUPPLIER, INT_QTY, CHR_DIMENSI, CASE
            WHEN LEFT(CHR_DIMENSI,2) = 'XX'  THEN ''
            WHEN RIGHT(CHR_DIMENSI,1) = 'X'  THEN ''
            ELSE CHR_DIMENSI
            END AS CHR_DIMENSI , CHR_PROG_RM, CHR_PROG_MC1, CHR_PROG_HT, CHR_PROG_SG, CHR_PROG_WC, CHR_PROG_MC2, CHR_PROG_QC, 
			--SUBSTRING(CHR_PROG_FIN,9,2)+'/'+SUBSTRING(CHR_PROG_FIN,6,2)+'/'+SUBSTRING(CHR_PROG_FIN,3,2) as CHR_PROG_FIN 
			--SUBSTRING(CHR_PROG_FIN,1,2)+'/'+SUBSTRING(CHR_PROG_FIN,4,2)+'/'+SUBSTRING(CHR_PROG_FIN,7,4) as CHR_PROG_FIN
			SUBSTRING(CHR_PROG_FIN,6,2)+'/'+SUBSTRING(CHR_PROG_FIN,5,2)+'/'+SUBSTRING(CHR_PROG_FIN,1,4) as CHR_PROG_FIN
			from ".$this->tabel." where INT_FLG_DEL = 0");
	        return $query->result();
	    }

	    function save_device($data) {
	        $this->db->insert($this->tabel, $data);
	    }
       	function save($data_tt) {
	        $this->db->insert($this->tabel3, $data_tt);
	    }
        function save_data($data_tw) {
	        $this->db->insert($this->tabel4, $data_tw);
	    }
	    function get_data_device($id) {
	        
            $query = $this->db->query("SELECT *  FROM  $this->tabel WHERE INT_NO_PART = " . $id . "");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }
        
        
        function getDropdown($project){
            $query = $this->db->query("SELECT DISTINCT CHR_PROJECT_NAME from ".$this->tabel." where INT_FLG_DEL = 0 AND SUBSTRING(CHR_TM_NUMBER,9,2) ='$project' ");
            return $query->result();
        }
        function getCode(){
            $query = $this->db->query("SELECT SUBSTRING(CHR_TM_NUMBER,9,2) as CHR_TM_NUMBER from TM_PART_INHOUSE where INT_FLG_DEL = 0");
            return $query->result();
        }
         function getProject(){
            $query = $this->db->query("select distinct case 
         when SUBSTRING(CHR_TM_NUMBER,9,2) = 01 THEN 'Project Desain'
		 when SUBSTRING(CHR_TM_NUMBER,9,2) = 02 THEN 'Dies MTE'
		 when SUBSTRING(CHR_TM_NUMBER,9,2) = 03 THEN 'Engineering'
		 when SUBSTRING(CHR_TM_NUMBER,9,2) = 04 THEN 'Quality'
		 when SUBSTRING(CHR_TM_NUMBER,9,2) = 05 THEN 'Production'
         END
         AS PROJECT from TM_PART_INHOUSE  where INT_FLG_DEL = 0");
            return $query->result();
        }
        function get_data_project($listproject){
            $query = $this->db->query("SELECT DISTINCT CHR_PROJECT_NAME from ".$this->tabel." where CHR_PROJECT_NAME = '$listproject' AND INT_FLG_DEL = 0");
            return $query->result();
        }
        
	    function update($data, $id) {
            
	        $this->db->where('INT_NO_PART', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function get_checksheet_by_data($data1,$data2) {
	        $query = $this->db->query("select a.CHR_ITEM, a.CHR_TM_NUMBER, a.CHR_PROJECT_NAME, a.CHR_PART_NAME, a.CHR_MODEL, a.CHR_MAT, a.CHR_SUPPLIER, a.INT_QTY, a.CHR_DIMENSI, a.CHR_PROG_RM, a.CHR_PROG_MC1, a.CHR_PROG_HT, a.CHR_PROG_SG, a.CHR_PROG_WC, a.CHR_PROG_MC2, a.CHR_PROG_QC, SUBSTRING(a.CHR_PROG_FIN,9,2) +'/'+ SUBSTRING(a.CHR_PROG_FIN,6,2) +'/'+ SUBSTRING(a.CHR_PROG_FIN,3,2) as CHR_PROG_FIN, a.INT_WEIGHT * 25000 + (CASE WHEN DATEDIFF(minute, b.CHR_START_MC1, b.CHR_STATUS_MC1) < 0 THEN 0 ELSE DATEDIFF(minute, b.CHR_START_MC1, b.CHR_STATUS_MC1) * 3330 END
            + CASE WHEN DATEDIFF(minute, b.CHR_START_SG, b.CHR_STATUS_SG) < 0 THEN 0 ELSE DATEDIFF(minute, b.CHR_START_SG, b.CHR_STATUS_SG) * 1250 END
            + CASE WHEN DATEDIFF(minute, b.CHR_START_WC, b.CHR_STATUS_WC) < 0 THEN 0 ELSE DATEDIFF(minute, b.CHR_START_WC, b.CHR_STATUS_WC) * 4170 END
            + CASE WHEN DATEDIFF(minute, b.CHR_START_MC2, b.CHR_STATUS_MC2) < 0 THEN 0 ELSE DATEDIFF(minute, b.CHR_START_MC2, b.CHR_STATUS_MC2) * 4170 END) AS COST
  from dbo.TM_PART_INHOUSE a
                INNER JOIN dbo.TW_PART_INHOUSE b
                ON a.CHR_TM_NUMBER = b.CHR_TM_NUMBER AND 
		 SUBSTRING(a.CHR_TM_NUMBER,9,2) = '$data1' and REPLACE(a.CHR_PROJECT_NAME, ' ','') = REPLACE('$data2', ' ','')
  and a.INT_FLG_DEL = 0  Order by a.CHR_CREATED_DATE ASC");
	        return $query->result();
	    }	    
    }
?>