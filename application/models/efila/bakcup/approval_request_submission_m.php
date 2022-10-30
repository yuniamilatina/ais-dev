<?php
	/**
	* 
	*/
	class approval_request_submission_m extends CI_Model
	{
		
		private $table = 'MSU.TT_REQUEST_DOC';
		private $table_detail = 'MSU.TT_DETAIL_REQUEST';

		//Approval Manager

		function get_request_manager() {
			$dept = $this->session->userdata('DEPT');
			$query = $this->db->query("SELECT r.INT_ID_REQUEST ,r.CHR_NPK, r.CHR_NAME, c.CHR_CATEGORY_NAME, r.CHR_CREATED_DATE FROM MSU.TT_REQUEST_DOC r JOIN MSU.TM_CATEGORY_DOC c ON r.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE r.INT_ID_DEPT = $dept AND r.INT_APPROVED_MANAGER IS NULL");
			return $query->result();
		}


	    //Approval GM

	    function get_request_gm() {
	    	$gd = $this->session->userdata("GROUPDEPT");
	    	$query = $this->db->query("SELECT r.INT_ID_REQUEST ,r.CHR_NPK, r.CHR_NAME, c.CHR_CATEGORY_NAME, r.CHR_CREATED_DATE FROM MSU.TT_REQUEST_DOC r JOIN MSU.TM_CATEGORY_DOC c ON r.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE r.INT_ID_DEPT IN(SELECT d.INT_ID_DEPT FROM TM_DEPT d WHERE d.INT_ID_GROUP_DEPT = $gd) AND r.INT_APPROVED_MANAGER = 1 AND r.INT_APPROVED_GM IS NULL");
	    	return $query->result();
	    }

	    //Approval MSU

	    function get_request_msu() {
	    	$query = $this->db->query("SELECT r.INT_ID_REQUEST ,r.CHR_NPK, r.CHR_NAME, c.CHR_CATEGORY_NAME, r.CHR_CREATED_DATE FROM MSU.TT_REQUEST_DOC r JOIN MSU.TM_CATEGORY_DOC c ON r.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE r.INT_APPROVED_MANAGER = 1 AND r.INT_APPROVED_GM = 1 AND r.INT_APPROVED_MSU IS NULL");
	    	return $query->result();
	    }

	    //Get Detail & Save Approval

		function get_request_detail($id) {
			$query = $this->db->query("SELECT * FROM MSU.TT_DETAIL_REQUEST WHERE INT_ID_REQUEST = $id");
			return $query->result();
		}

		function save_approval($id, $data) {
	        $this->db->where('INT_ID_REQUEST', $id);
	        $this->db->update($this->table, $data);
	    }
	}
?>