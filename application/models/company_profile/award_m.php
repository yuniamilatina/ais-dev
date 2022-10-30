<?php
	/**
	* 
	*/
	class award_m extends CI_Model
	{
		
		private $tabel = 'GAF.TM_AWARD';

	    function get_award() {
	        $query = $this->db->query("SELECT INT_ID_AWARD, CHR_AWARD_NAME, CHR_AWARD_DESC, CHR_AWARD_DATE,
	        	CHR_AWARD_CATEGORY,CHR_AWARD_PHOTO from GAF.TM_AWARD WHERE INT_STATUS = '1'");
	        return $query->result();
	    }

		function get_award_category() {
	        $query = $this->db->query("SELECT DISTINCT CHR_AWARD_CATEGORY from GAF.TM_AWARD");
	        return $query->result();
	    }
	    // function get_name_asset($id) {
	    //     $query = $this->db->query("select CHR_ASSET from TM_ASSET where INT_ID = '" . $id . "'")->row_array();
	    //     $asset = $query['CHR_ASSET'];
	    //     return $asset;
	    // }

	    function save_award($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_award($id) {
	        $query = $this->db->query("SELECT INT_ID_AWARD, CHR_AWARD_NAME, CHR_AWARD_DESC, CHR_AWARD_DATE, CHR_AWARD_CATEGORY, CHR_AWARD_PHOTO FROM GAF.TM_AWARD WHERE INT_ID_AWARD = '" . $id . "' AND INT_STATUS = '1'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function delete($id) {
	        $data = array('INT_STATUS' => 0);

	        $this->db->where('INT_ID_AWARD', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_AWARD', $id);
	        $this->db->update($this->tabel, $data);
	    }

	}
?>