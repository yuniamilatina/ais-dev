<?php
	/**
	* 
	*/
	class category_doc_m extends CI_Model
	{
		
		private $tabel = 'MSU.TM_CATEGORY_DOC';

	    function get_category_doc() {
	        $query = $this->db->query("SELECT * from MSU.TM_CATEGORY_DOC WHERE INT_STATUS != '0'");
	        return $query->result();
	    }

	    // function get_name_asset($id) {
	    //     $query = $this->db->query("select CHR_ASSET from TM_ASSET where INT_ID = '" . $id . "'")->row_array();
	    //     $asset = $query['CHR_ASSET'];
	    //     return $asset;
	    // }

	    function save_category_doc($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_category_doc($id) {
	        $query = $this->db->query("SELECT * FROM MSU.TM_CATEGORY_DOC WHERE INT_ID_CATEGORY = '" . $id . "' AND INT_STATUS != '0'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function delete($id) {
	        $data = array('INT_STATUS' => 0);

	        $this->db->where('INT_ID_CATEGORY', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_CATEGORY', $id);
	        $this->db->update($this->tabel, $data);
	    }

	}
?>