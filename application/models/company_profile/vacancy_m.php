<?php
	/**
	* 
	*/
	class vacancy_m extends CI_Model
	{
		
		private $tabel = 'HRD.TM_VACANCY';

	    function get_vacancy() {
	        $query = $this->db->query("SELECT * from HRD.TM_VACANCY");
	        return $query->result();
	    }

	    function save_vacancy($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_vacancy($id) {
	        $query = $this->db->query("SELECT INT_ID_VACANCY, CHR_VACANCY_NAME FROM HRD.TM_VACANCY WHERE INT_ID_VACANCY = '" . $id . "'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_VACANCY', $id);
	        $this->db->update($this->tabel, $data);
	    }
	}
?>