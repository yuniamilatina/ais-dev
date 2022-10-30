<?php
	/**
	* 
	*/
	class obsolete_document_m extends CI_Model
	{
		
		private $tabel = 'MSU.TT_OBSOLETE_DOC';

		function get_doc() {
			$dept = $this->session->userdata('DEPT');
			$query = $this->db->query("SELECT d.INT_ID_DOCUMENT, d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC, d.INT_ID_CATEGORY, d.CHR_CREATED_BY, d.CHR_DOC, c.CHR_CATEGORY_NAME, d.CHR_NO_DOC FROM MSU.TM_DOCUMENT d JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE d.INT_STATUS = 1 AND d.INT_STATUS_APPROVED = 1 AND d.INT_ID_SECTION IN (SELECT INT_ID_SECTION FROM TM_SECTION WHERE INT_ID_DEPT = $dept)");
			return $query->result();
		}

		function get_obsolete() {
			$sec = $this->session->userdata('SECTION');
			$query = $this->db->query("SELECT R.INT_ID_OBSOLETE, D.INT_ID_DOCUMENT, D.CHR_NO_DOC, D.CHR_DOCUMENT_NAME, D.INT_REVISION, C.CHR_CATEGORY_NAME, D.CHR_CREATED_BY, D.CHR_DOC, R.INT_APPROVED_MSU, R.INT_STATUS, R.INT_APPROVED_MANAGER FROM MSU.TT_OBSOLETE_DOC R JOIN MSU.TM_DOCUMENT D ON R.INT_ID_DOCUMENT = D.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC C ON D.INT_ID_CATEGORY = C.INT_ID_CATEGORY WHERE R.INT_ID_SECTION = $sec ORDER BY R.INT_ID_OBSOLETE DESC");
			return $query->result();
		}
		
		function save_obsolete($data) {
	    	$this->db->insert($this->tabel, $data);
	    }

	    function save_background($data) {
	    	$this->db->insert('MSU.TT_OBSOLETE_BACK', $data);
	    }

	    // function save_desc($data) {
	    // 	$this->db->insert('MSU.TT_OBSOLETE_BACK', $data);
	    // }

	    function update_doc($data, $id) {
	    	$this->db->where('INT_ID_DOCUMENT', $id);
	    	$this->db->update('MSU.TM_DOCUMENT', $data);
	    }

	    function propose($id) {
	    	$data = array(
	    		'INT_STATUS' => 1,
	    		'INT_APPROVED_MANAGER' => NULL,
	    		'INT_APPROVED_MSU' => NULL
	    	);

	        $this->db->where('INT_ID_OBSOLETE', $id);
	        $this->db->update($this->tabel, $data);
	    }

		function get_doc_obs($id) {
			$query = $this->db->query("SELECT * FROM MSU.TM_DOCUMENT WHERE INT_ID_DOCUMENT = $id");
			return $query->result();
		}

		function get_id_obs(){
    		$sec = $this->session->userdata("SECTION");
	    	$query = $this->db->query("SELECT MAX(rev.INT_ID_OBSOLETE) as id FROM MSU.TT_OBSOLETE_DOC rev JOIN MSU.TM_DOCUMENT doc ON rev.INT_ID_DOCUMENT = doc.INT_ID_DOCUMENT WHERE doc.INT_ID_SECTION = '$sec'");
	    	return $query->result();
	    }

	    function get_obsolete_back($id) {
	    	$query = $this->db->query("SELECT * FROM MSU.TT_OBSOLETE_BACK WHERE INT_ID_OBSOLETE = $id");
	    	return $query->result();
	    }

	    function delete($id) {
	    	$this->db->where('INT_ID_OBSOLETE', $id);
	    	$this->db->delete('MSU.TT_OBSOLETE_DOC');
	    }

	    function delete_detail($id) {
	    	$this->db->where('INT_ID_OBSOLETE', $id);
	    	$this->db->delete('MSU.TT_OBSOLETE_BACK');
	    }

	    function delete_back($id) {
	    	$this->db->where('INT_ID_BACKGROUND', $id);
	    	$this->db->delete('MSU.TT_OBSOLETE_BACK');
	    }

	    //Notification
		function get_id_notif() {
			$query = $this->db->query("SELECT MAX(INT_ID_NOTIF) AS MAX_ID FROM TT_PORTAL_NOTIFICATION");
			return $query->result();
		}

		function get_npk_manager() {
			$dept = $this->session->userdata("DEPT");
			$query = $this->db->query("SELECT U.CHR_NPK FROM TM_USER U JOIN TM_DEPT D ON U.INT_ID_DEPT = D.INT_ID_DEPT JOIN TM_ROLE R ON U.INT_ID_ROLE = R.INT_ID_ROLE WHERE U.INT_ID_ROLE = 5 AND U.INT_ID_DEPT = $dept");
			return $query->result();
		}

		function get_notif_dept() {
			$dept = $this->session->userdata("DEPT");
			$query = $this->db->query("SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = $dept");
			return $query->result();
		}

		function save_notif($data) {
			$this->db->insert('TT_PORTAL_NOTIFICATION', $data);
		}
	}
?>