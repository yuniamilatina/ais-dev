<?php
	/**
	* 
	*/
	class report_checksheet_m extends CI_Model
	{
		
		private $tabel = 'TT_DETAIL_CHECKSHEET';

		function save($data) {
			$this->db->insert($this->tabel, $data);
		}

		function update($data, $id, $id_spec) {
			$this->db->where('INT_ID_CHECKSHEET', $id);
			$this->db->where('INT_SPECIFICATION_ID', $id_spec);
			$this->db->update($this->tabel, $data);
		}

		function delete($id, $id_spec) {
			$data = array('INT_FLG_DEL' => 1);

			$this->db->where('INT_ID_CHECKSHEET', $id);
			$this->db->where('INT_SPECIFICATION_ID', $id_spec);
			$this->db->update($this->tabel, $data);
		}

	    function get_checksheet() {
	        $query = $this->db->query("SELECT c.CHR_PDS_NUMBER, ISNULL(c.CHR_LOAD_NUMBER,'-') AS CHR_LOAD_NUMBER, b.CHR_ID_PART,a.CHR_CREATED_DATE,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR, c.CHR_STATUS
								FROM TT_CHECK_SHEET as a 
								INNER JOIN TM_STO as b 
								on a.CHR_COMPONENT_ID = b.CHR_ID_PART 
								AND a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR
								INNER JOIN TM_RECEIVING as c on c.CHR_PART_ID = b.CHR_ID_PART AND a.INT_RECEIVING = c.INT_RECEIVING_ID
								WHERE b.CHR_KODE_VENDOR in (SELECT distinct chr_supplier_id FROM TT_PURCHASE_RECEIPT_H) 
								group by c.CHR_PDS_NUMBER, c.CHR_LOAD_NUMBER, b.CHR_ID_PART,a.CHR_CREATED_DATE,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR, c.CHR_STATUS 
								Order by a.CHR_CREATED_DATE DESC");
	        return $query->result();
		}	 
		
		function get_checksheet_by_date2($date2) {
	        $query = $this->db->query("SELECT b.CHR_ID_PART,a.CHR_CREATED_DATE,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR
								FROM TT_CHECK_SHEET as a 
								INNER JOIN TM_STO as b 
								on a.CHR_COMPONENT_ID = b.CHR_ID_PART 
								AND a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR
								WHERE a.CHR_CREATED_DATE <= '$date2' 
								group by b.CHR_ID_PART,a.CHR_CREATED_DATE,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR Order by a.CHR_CREATED_DATE DESC");
	        return $query->result();
		}
		
	    function get_checksheet_by_date1($date1) {
	        $query = $this->db->query("SELECT b.CHR_ID_PART,a.CHR_CREATED_DATE,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR
								FROM TT_CHECK_SHEET as a 
								INNER JOIN TM_STO as b 
								on a.CHR_COMPONENT_ID = b.CHR_ID_PART 
								AND a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR
								WHERE  a.CHR_CREATED_DATE >= '$date1' 
								group by b.CHR_ID_PART,a.CHR_CREATED_DATE,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR Order by a.CHR_CREATED_DATE DESC");
	        return $query->result();
		}
		
	    function get_checksheet_by_date($date1,$date2) {
	        $query = $this->db->query("SELECT b.CHR_ID_PART,a.CHR_CREATED_DATE,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR
								FROM TT_CHECK_SHEET as a INNER JOIN TM_STO as b 
								on a.CHR_COMPONENT_ID = b.CHR_ID_PART 
								AND a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR
								WHERE a.CHR_CREATED_DATE >= '$date1' and a.CHR_CREATED_DATE <= '$date2'
								group by b.CHR_ID_PART,a.CHR_CREATED_DATE,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR Order by a.CHR_CREATED_DATE DESC");
	        return $query->result();
	    }	
		
	    function get_data($date,$partno, $pds_no){
	    	 $query = $this->db->query("SELECT c.CHR_PDS_NUMBER, c.CHR_STATUS, a.CHR_ID_PART_HYP,a.CHR_BACK_NO,a.CHR_NAMA_PART,a.CHR_NAMA_VENDOR FROM TM_STO as a 
								INNER JOIN TT_CHECK_SHEET as b  on a.CHR_ID_PART = b.CHR_COMPONENT_ID and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR
								INNER JOIN TM_RECEIVING c ON c.INT_RECEIVING_ID = b.INT_RECEIVING
								WHERE b.CHR_COMPONENT_ID = '$partno' and b.CHR_CREATED_DATE = '$date' AND  c.CHR_PDS_NUMBER = '$pds_no'
								group by  a.CHR_ID_PART_HYP,a.CHR_BACK_NO,a.CHR_NAMA_PART,a.CHR_NAMA_VENDOR, c.CHR_PDS_NUMBER, c.CHR_STATUS");
	        return $query->result();	
		}
		
	    function get_detil_checksheet($date,$partno){
	    	$query = $this->db->query("SELECT  d.CHR_UNIT,c.INT_SPECIFICATION_ID,c.CHR_SPECIFICATION,c.DEC_STD,c.DEC_TOLERANSI_MAX,DEC_TOLERANSI_MIN,c.DEC_STD_MAX,c.DEC_STD_MIN FROM TT_DETAIL_CHECKSHEET as a 
								INNER JOIN TT_CHECK_SHEET as b on a.INT_ID_CHECKSHEET = b.INT_CHECKSHEET_ID 
								INNER JOIN TM_SPECIFICATION as c on a.INT_SPECIFICATION_ID = c.INT_SPECIFICATION_ID
								INNER JOIN TM_MEASUREMENT_DEVICE as d on c.INT_DEVICE_ID = d.INT_DEVICE_ID
								WHERE b.CHR_COMPONENT_ID = '$partno' and b.CHR_CREATED_DATE = '$date' 
								AND d.INT_FLG_DEL = 0 AND c.INT_FLG_DEL = 0 
								AND b.INT_STATUS = 0
								group by d.CHR_UNIT,b.CHR_CREATED_DATE,c.CHR_SPECIFICATION,c.DEC_STD,c.DEC_TOLERANSI_MIN,
								c.DEC_TOLERANSI_MAX,c.DEC_STD_MAX,c.DEC_STD_MIN,c.INT_SPECIFICATION_ID
								ORDER BY c.CHR_SPECIFICATION");
	        return $query->result();
		}
		
	    function get_spec_load($partno){
	    	$query = $this->db->query("SELECT a.CHR_SPECIFICATION,a.DEC_STD,a.DEC_TOLERANSI_MAX,a.DEC_TOLERANSI_MIN,a.DEC_STD_MAX,a.DEC_STD_MIN, d.CHR_UNIT 
								FROM TM_SPECIFICATION as a 
								INNER JOIN TM_MEASUREMENT_DEVICE as d on a.INT_DEVICE_ID = d.INT_DEVICE_ID
								WHERE a.CHR_COMPONENT_ID = '$partno' 
								AND a.INT_FLG_DEL = 0 AND d.INT_FLG_DEL = 0 
								group by a.CHR_SPECIFICATION,a.DEC_STD,a.DEC_TOLERANSI_MIN,a.DEC_TOLERANSI_MAX,a.DEC_STD_MAX,a.DEC_STD_MIN,d.CHR_UNIT");
	        return $query->result();
		}
		
	    function get_nilai_spek($idspek, $date, $partno){
	    	$query = $this->db->query("SELECT a.DEC_NILAI
								FROM TT_DETAIL_CHECKSHEET as a 
								INNER JOIN TM_SPECIFICATION as b on a.INT_SPECIFICATION_ID = b.INT_SPECIFICATION_ID
								INNER JOIN TT_CHECK_SHEET as c on c.INT_CHECKSHEET_ID = a.INT_ID_CHECKSHEET
								WHERE a.INT_SPECIFICATION_ID = '$idspek' and c.CHR_CREATED_DATE = '$date' and c.CHR_COMPONENT_ID= '$partno'
								AND C.INT_STATUS = 0
								AND b.INT_FLG_DEL = 0");
	        return $query->result();
		}

		function get_checksheet_detail($date, $partno){
					$query = $this->db->query("SELECT S.CHR_SPECIFICATION , DEC_NILAI, DEC_STD, DEC_TOLERANSI_MAX, DEC_TOLERANSI_MIN FROM TT_DETAIL_CHECKSHEET DC 
					INNER JOIN TT_CHECK_SHEET CS ON DC.INT_ID_CHECKSHEET = CS.INT_CHECKSHEET_ID  
					INNER JOIN TM_SPECIFICATION S ON DC.INT_SPECIFICATION_ID = S.INT_SPECIFICATION_ID
					WHERE CS.CHR_COMPONENT_ID = '$partno' AND CS.CHR_CREATED_DATE  = '$date'  
					AND S.INT_FLG_DEL = 0 
					AND CS.INT_STATUS = 0
					ORDER BY S.CHR_SPECIFICATION, CS.CHR_CREATED_DATE ASC, CS.CHR_CREATED_TIME ASC");
	        return $query->result();
		}
		
	    function get_jumlah_sampel($date,$partno){
	    	$query = $this->db->query("SELECT count(b.INT_CHECKSHEET_ID) as a FROM TT_CHECK_SHEET as b WHERE b.CHR_CREATED_DATE  = '$date' 
			and b.CHR_COMPONENT_ID= '$partno' 
			AND b.INT_STATUS = 0
			group by CHR_COMPONENT_ID");
	        return $query->row()->a;
		}
		
	}
?>