<?php
	/**
	* 
	*/
	class approval_obsolete_document_m extends CI_Model
	{
		
		private $table = 'MSU.TT_OBSOLETE_DOC';

	    //Approval MSU
		function get_obsolete_manager() {
	    	$query = $this->db->query("SELECT D.INT_ID_DOCUMENT, D.CHR_NO_DOC, D.CHR_DOCUMENT_NAME, D.INT_REVISION, C.CHR_CATEGORY_NAME, R.CHR_CREATED_BY, R.CHR_CREATED_DATE, D.CHR_DOC, R.INT_ID_OBSOLETE FROM MSU.TM_DOCUMENT D JOIN MSU.TM_CATEGORY_DOC C ON D.INT_ID_CATEGORY = C.INT_ID_CATEGORY JOIN MSU.TT_OBSOLETE_DOC R ON R.INT_ID_DOCUMENT = D.INT_ID_DOCUMENT WHERE R.INT_APPROVED_MANAGER IS NULL AND R.INT_STATUS = 1");
	    	return $query->result();
	    }

	    function get_obsolete_msu() {
	    	$query = $this->db->query("SELECT D.INT_ID_DOCUMENT, D.CHR_NO_DOC, D.CHR_DOCUMENT_NAME, D.INT_REVISION, C.CHR_CATEGORY_NAME, R.CHR_CREATED_BY, R.CHR_CREATED_DATE, D.CHR_DOC, R.INT_ID_OBSOLETE FROM MSU.TM_DOCUMENT D JOIN MSU.TM_CATEGORY_DOC C ON D.INT_ID_CATEGORY = C.INT_ID_CATEGORY JOIN MSU.TT_OBSOLETE_DOC R ON R.INT_ID_DOCUMENT = D.INT_ID_DOCUMENT WHERE R.INT_APPROVED_MSU IS NULL AND R.INT_APPROVED_MANAGER = 1 AND R.INT_STATUS = 1");
	    	return $query->result();
	    }

	    //Get Detail & Save Approval

		function get_obsolete_back($id) {
	    	$query = $this->db->query("SELECT * FROM MSU.TT_OBSOLETE_BACK WHERE INT_ID_OBSOLETE = $id");
	    	return $query->result();
	    }

		function get_filename($id) {
			$query = $this->db->query("SELECT * FROM MSU.TM_DOCUMENT WHERE INT_ID_DOCUMENT = $id");
			return $query->result();
		}

		function save_approval($id, $data) {
	        $this->db->where('INT_ID_OBSOLETE', $id);
	        $this->db->update($this->table, $data);
	    }

	    function update_doc($id, $data) {
	    	$this->db->where('INT_ID_DOCUMENT', $id);
	        $this->db->update('MSU.TM_DOCUMENT', $data);
	    }

	    //Notification
		function get_id_notif() {
			$query = $this->db->query("SELECT MAX(INT_ID_NOTIF) AS MAX_ID FROM TT_PORTAL_NOTIFICATION");
			return $query->result();
		}

		// function get_npk_gm() {
		// 	$gdept = $this->session->userdata("GROUPDEPT");
		// 	$query = $this->db->query("SELECT U.CHR_NPK FROM TM_USER U JOIN TM_GROUP_DEPT D ON U.INT_ID_GROUP_DEPT = D.INT_ID_GROUP_DEPT JOIN TM_ROLE R ON U.INT_ID_ROLE = R.INT_ID_ROLE WHERE U.INT_ID_ROLE = 4 AND U.INT_ID_GROUP_DEPT = $gdept");
		// 	return $query->result();
		// }

		function get_notif_dept() {
			$dept = $this->session->userdata("DEPT");
			$query = $this->db->query("SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = $dept");
			return $query->result();
		}

		function save_notif($data) {
			$this->db->insert('TT_PORTAL_NOTIFICATION', $data);
		}

		function get_cat_name($id) {
			$query = $this->db->query("SELECT C.CHR_CATEGORY_NAME FROM MSU.TT_OBSOLETE_DOC R JOIN MSU.TM_DOCUMENT D ON R.INT_ID_DOCUMENT = D.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC C ON D.INT_ID_CATEGORY = C.INT_ID_CATEGORY WHERE R.INT_ID_OBSOLETE = $id");
			return $query->result();
		}

		function get_npk($id) {
			$query = $this->db->query("SELECT U.CHR_NPK FROM MSU.TT_OBSOLETE_DOC R JOIN TM_USER U ON R.CHR_CREATED_BY = U.CHR_USERNAME WHERE R.INT_ID_OBSOLETE = $id");
			return $query->result();
		}
	}
?>