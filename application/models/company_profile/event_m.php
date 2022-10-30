<?php
	/**
	* 
	*/
	class event_m extends CI_Model
	{
		
		private $tabel = 'GAF.TM_EVENT';

	    function get_event() {
	        $query = $this->db->query("SELECT INT_ID_EVENT, CHR_EVENT_NAME, CHR_EVENT_DESC, CHR_EVENT_DATE,
	        	CHR_EVENT_PHOTO from GAF.TM_EVENT WHERE INT_STATUS = '1'");
	        return $query->result();
	    }

	    function save_event($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_event($id) {
	        $query = $this->db->query("SELECT INT_ID_EVENT, CHR_EVENT_NAME, CHR_EVENT_DESC, CHR_EVENT_DATE, CHR_EVENT_PHOTO FROM GAF.TM_EVENT WHERE INT_ID_EVENT = '" . $id . "' AND INT_STATUS = '1'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function delete($id) {
	        $data = array('INT_STATUS' => 0);

	        $this->db->where('INT_ID_EVENT', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_EVENT', $id);
	        $this->db->update($this->tabel, $data);
	    }
	}
?>