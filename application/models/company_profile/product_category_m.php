<?php
	/**
	* 
	*/
	class product_category_m extends CI_Model
	{
		
		private $tabel = 'HRD.TM_PRODUCT_CATEGORY';

	    function get_product_category() {
	        $query = $this->db->query("SELECT INT_ID_CATEGORY, CHR_CATEGORY_NAME, CHR_CATEGORY_PHOTO from HRD.TM_PRODUCT_CATEGORY WHERE INT_STATUS = '1'");
	        return $query->result();
	    }

	    function save_product_category($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_product_category($id) {
	        $query = $this->db->query("SELECT INT_ID_CATEGORY, CHR_CATEGORY_NAME, CHR_CATEGORY_PHOTO FROM HRD.TM_PRODUCT_CATEGORY WHERE INT_ID_CATEGORY = '" . $id . "' AND INT_STATUS = '1'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    
	    function update($data, $id) {
	        $this->db->where('INT_ID_CATEGORY', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function delete($id) {
	        $data = array('INT_STATUS' => 0);

	        $this->db->where('INT_ID_CATEGORY', $id);
	        $this->db->update('HRD.TM_PRODUCT', $data);

	        $this->db->where('INT_ID_CATEGORY', $id);
	        $this->db->update($this->tabel, $data);
	    }
	}
?>