<?php
	/**
	* 
	*/
	class product_m extends CI_Model
	{
		
		private $tabel = 'HRD.TM_PRODUCT';
		private $tabel1 = 'HRD.TM_PRODUCT_CATEGORY';

	    function get_product() {
	        $query = $this->db->query("SELECT * from HRD.TM_PRODUCT p JOIN HRD.TM_PRODUCT_CATEGORY c on p.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE p.INT_STATUS = '1'");
	        return $query->result();
	    }

	    function get_product_category() {
	        $query = $this->db->query("SELECT INT_ID_CATEGORY, CHR_CATEGORY_NAME from HRD.TM_PRODUCT_CATEGORY WHERE INT_STATUS = '1'");
	        return $query->result();
	    }

	    function save_product($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function get_data_product($id) {
	        $query = $this->db->query("SELECT INT_ID_PRODUCT, INT_ID_CATEGORY, CHR_PRODUCT_NAME, CHR_PRODUCT_DESC, CHR_PRODUCT_PHOTO FROM HRD.TM_PRODUCT WHERE INT_ID_PRODUCT = '" . $id . "' AND INT_STATUS = '1'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function delete($id) {
	        $data = array('INT_STATUS' => 0);

	        $this->db->where('INT_ID_PRODUCT', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_PRODUCT', $id);
	        $this->db->update($this->tabel, $data);
	    }

	}
?>