<?php
	/**
	* 
	*/
	class measurement_device_m extends CI_Model
	{
		
		private $tabel = 'dbo.TM_MEASUREMENT_DEVICE';

	    function get_device() {
	        $query = $this->db->query("SELECT * from ".$this->tabel." where INT_FLG_DEL = 0");
	        return $query->result();
	    }

	    function save_device($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_device($id) {
	        $query = $this->db->query("SELECT *  FROM ".$this->tabel." WHERE INT_DEVICE_ID = " . $id . "");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function update($data, $id) {
	        $this->db->where('INT_DEVICE_ID', $id);
	        $this->db->update($this->tabel, $data);
	    }
	}
?>