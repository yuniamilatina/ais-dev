<?php
	/**
	* 
	*/
	class cp_news_m extends CI_Model
	{
		
		private $tabel = 'GAF.TM_NEWS';

	    function get_news() {
	        $query = $this->db->query("SELECT INT_ID_NEWS, CHR_NEWS_TITLE, CHR_NEWS_HIGHLIGHT, CHR_NEWS_DETAIL,
	        	CHR_NEWS_PHOTO, CHR_CREATED_BY, CHR_CREATED_DATE, INT_STATUS from GAF.TM_NEWS WHERE INT_STATUS = '1'");
	        return $query->result();
	    }

	    function save_news($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_news($id) {
	        $query = $this->db->query("SELECT INT_ID_NEWS, CHR_NEWS_TITLE, CHR_NEWS_HIGHLIGHT, CHR_NEWS_DETAIL,
	        	CHR_NEWS_PHOTO, CHR_CREATED_BY, CHR_CREATED_DATE, INT_STATUS from GAF.TM_NEWS WHERE INT_ID_NEWS = '" . $id . "' AND INT_STATUS = '1'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function delete($id) {
	        $data = array('INT_STATUS' => 0);

	        $this->db->where('INT_ID_NEWS', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_NEWS', $id);
	        $this->db->update($this->tabel, $data);
	    }
	}
?>