<?php
	/**
	* 
	*/
	class request_submission_m extends CI_Model
	{
		
		private $tabel = 'MSU.TT_REQUEST_DOC';
		private $tabel_detail = 'MSU.TT_DETAIL_REQUEST';

		function get_request() {
			$sec = $this->session->userdata('SECTION');
			$query = $this->db->query("SELECT r.INT_ID_REQUEST, r.CHR_NPK, r.CHR_NAME, r.CHR_CREATED_DATE, r.CHR_CREATED_TIME, c.CHR_CATEGORY_NAME, r.INT_STATUS, r.INT_ID_CATEGORY, r.INT_APPROVED_MANAGER, r.INT_APPROVED_GM, r.INT_APPROVED_MSU FROM MSU.TT_REQUEST_DOC r JOIN MSU.TM_CATEGORY_DOC c ON r.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE r.INT_ID_SECTION = $sec");
			return $query->result();
		}

		function get_request_detail($id) {
			$query = $this->db->query("SELECT * FROM MSU.TT_DETAIL_REQUEST WHERE INT_ID_REQUEST = $id");
			return $query->result();
		}

		function get_id_sub(){
    		$sec = $this->session->userdata("SECTION");
	    	$query = $this->db->query("SELECT MAX(INT_ID_REQUEST) as id FROM MSU.TT_REQUEST_DOC WHERE INT_ID_SECTION = '$sec'");
	    	return $query->result();
	    }

	    function get_category() {
	    	$query = $this->db->query("SELECT * FROM MSU.TM_CATEGORY_DOC WHERE INT_STATUS = 1");
	    	return $query->result();
	    }

		function save_request($data) {
	    	$this->db->insert($this->tabel, $data);
	    }

	    function save_request_detail($data) {
	    	$this->db->insert($this->tabel_detail, $data);
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_REQUEST', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function propose($id) {
	        $data = array('INT_STATUS' => 1);

	        $this->db->where('INT_ID_REQUEST', $id);
	        $this->db->update($this->tabel, $data);
	    }

	}
?>