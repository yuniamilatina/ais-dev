<?php
	/**
	* 
	*/
	class create_data_outhouse_m extends CI_Model
	{
		
		private $tabel = 'dbo.TT_PROGRESS';

	    function get_device() {
	        $query = $this->db->query("SELECT * from ".$this->tabel." where INT_FLG_DEL = 1");
	        return $query->result();
	    }

	    function save_device($data) {
	        $this->db->insert($this->tabel, $data);
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
	}
?>