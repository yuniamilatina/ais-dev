<?php
	/**
	* 
	*/
	class registration_m extends CI_Model
	{
		
		private $tabel = 'HRD.TT_REGISTRATION';

	    function get_registration() {
	        $query = $this->db->query("SELECT r.INT_ID_REG, r.INT_ID_VACANCY, r.CHR_NAME, r.CHR_PLACE, r.CHR_DATE, r.DEC_HEIGHT, r.DEC_WEIGHT, r.CHR_BLOOD_TYPE, r.CHR_SEX, r.CHR_RELIGION, r.CHR_NATION, r.CHR_KTP, r.CHR_KK, r.CHR_EMAIL, r.CHR_ADDRESS_KTP, r.CHR_ADDRESS_REGION, r.CHR_KK, r.CHR_EMAIL, r.CHR_PHONE, r.CHR_PHOTO, r.CHR_FINAL_ACADEMIC, r.CHR_UNIVERSITY, r.CHR_FACULTY, r.CHR_DEPARTEMENT, r.DEC_IPK, r.INT_STATUS AS STEP, v.CHR_VACANCY_NAME, v.INT_STATUS from HRD.TT_REGISTRATION r JOIN HRD.TM_VACANCY v ON r.INT_ID_VACANCY = v.INT_ID_VACANCY");
	        return $query->result();
	    }

	    function get_registration_bydate($start, $end) {
	    	$query = $this->db->query("SELECT r.INT_ID_REG, r.INT_ID_VACANCY, r.CHR_NAME, r.CHR_PLACE, r.CHR_DATE, r.DEC_HEIGHT, r.DEC_WEIGHT, r.CHR_BLOOD_TYPE, r.CHR_SEX, r.CHR_RELIGION, r.CHR_NATION, r.CHR_KTP, r.CHR_KK, r.CHR_EMAIL, r.CHR_ADDRESS_KTP, r.CHR_ADDRESS_REGION, r.CHR_KK, r.CHR_EMAIL, r.CHR_PHONE, r.CHR_PHOTO, r.CHR_FINAL_ACADEMIC, r.CHR_UNIVERSITY, r.CHR_FACULTY, r.CHR_DEPARTEMENT, r.DEC_IPK, r.INT_STATUS AS STEP, v.CHR_VACANCY_NAME, v.INT_STATUS from HRD.TT_REGISTRATION r JOIN HRD.TM_VACANCY v ON r.INT_ID_VACANCY = v.INT_ID_VACANCY WHERE r.CHR_REG_DATE >= $start AND r.CHR_REG_DATE <= $end");
	        return $query->result();
	    }

	    function get_data_registration($id) {
	        $query = $this->db->query("SELECT * FROM HRD.TT_REGISTRATION WHERE INT_ID_REG = '" . $id . "'");
 	
	        if ($query->num_rows() > 0) {
	            return $query->result();
	        } else {
	            return 0;
	        }
	    }

	    function get_email($id) {
	        $query = $this->db->query("SELECT * from HRD.TT_REGISTRATION r JOIN HRD.TM_VACANCY v ON r.INT_ID_VACANCY = v.INT_ID_VACANCY WHERE r.INT_ID_REG = '" . $id . "'");
 	
	        if ($query->num_rows() > 0) {
	            return $query->result();
	        } else {
	            return 0;
	        }
	    }

	    function accept($id, $tahap) {
	    	$tahap = $tahap + 1;
	        $data = array('INT_STATUS' => $tahap);

	        $this->db->where('INT_ID_REG', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_REG', $id); 
	        $this->db->update($this->tabel, $data);
	    }

	    function reject($id){
	    	$this->db->where('INT_ID_REG', $id);
	    	$this->db->delete($this->tabel);
	    }
	}
?>