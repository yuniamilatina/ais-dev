<?php
	/**
	* 
	*/
	class vacancy_detail_m extends CI_Model
	{
		
		private $tabel = 'HRD.TM_VACANCY_DETAIL';

	    function get_vacancy_detail($id) {
	        $query = $this->db->query("SELECT * from HRD.TM_VACANCY_DETAIL d JOIN HRD.TM_VACANCY v ON d.INT_ID_VACANCY = v.INT_ID_VACANCY WHERE v.INT_ID_VACANCY = '" . $id . "'");
	        return $query->result();
	    }

	    function get_title($id){
	    	$query = $this->db->query("SELECT * FROM HRD.TM_VACANCY WHERE INT_ID_VACANCY = '" . $id . "'");
	    	return $query->result();
	    }

	    function save_vacancy_detail($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_vacancy_detail($id) {
	        $query = $this->db->query("SELECT INT_ID_VACANCY_DETAIL, INT_ID_VACANCY, CHR_DESCRIPTION FROM HRD.TM_VACANCY_DETAIL WHERE INT_ID_VACANCY_DETAIL = '" . $id . "'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_VACANCY_DETAIL', $id);
	        $this->db->update($this->tabel, $data);
	    }
	}
?>