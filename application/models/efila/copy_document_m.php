<?php
	/**
	* 
	*/
	class copy_document_m extends CI_Model
	{
		
		private $tabel = 'MSU.TT_COPY_DOC';

		function get_doc() {
			$dept = $this->session->userdata('DEPT');
			$query = $this->db->query("SELECT d.INT_ID_DOCUMENT, d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC, d.INT_ID_CATEGORY, d.CHR_CREATED_BY, d.CHR_DOC, c.CHR_CATEGORY_NAME, d.CHR_NO_DOC, d.INT_REVISION FROM MSU.TM_DOCUMENT d JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE d.INT_STATUS = 1 AND d.INT_STATUS_APPROVED = 1 AND d.INT_ID_SECTION IN (SELECT INT_ID_SECTION FROM TM_SECTION WHERE INT_ID_DEPT = $dept)");
			return $query->result();
		}

		function get_copy() {
			$sec = $this->session->userdata('SECTION');
			$query = $this->db->query("SELECT R.INT_ID_COPY, D.INT_ID_DOCUMENT, D.CHR_NO_DOC, D.CHR_DOCUMENT_NAME, D.INT_REVISION, C.CHR_CATEGORY_NAME, D.CHR_MODIFIED_BY, D.CHR_DOC, R.INT_APPROVED_MANAGER, R.INT_APPROVED_SPV, R.INT_APPROVED_MSU, R.INT_STATUS, R.CHR_INFO, R.CHR_CREATED_BY, R.INT_TYPE, R.INT_TOTAL FROM MSU.TT_COPY_DOC R JOIN MSU.TM_DOCUMENT D ON R.INT_ID_DOCUMENT = D.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC C ON D.INT_ID_CATEGORY = C.INT_ID_CATEGORY WHERE R.INT_ID_SECTION = $sec ORDER BY R.INT_ID_COPY DESC");
			return $query->result();
		}
		
		function save_copy($data) {
	    	$this->db->insert($this->tabel, $data);
	    }

	    function save_background($data) {
	    	$this->db->insert('MSU.TT_COPY_BACK', $data);
	    }

	    function propose($id) {
	    	$data = array(
	    		'INT_STATUS' => 1,
    			'INT_APPROVED_SPV' => NULL,
    			'INT_APPROVED_MSU' => NULL
	    	);

	        $this->db->where('INT_ID_COPY', $id);
	        $this->db->update($this->tabel, $data);
	    }

		function get_doc_copy($id) {
			$query = $this->db->query("SELECT * FROM MSU.TM_DOCUMENT WHERE INT_ID_DOCUMENT = $id");
			return $query->result();
		}

		function get_id_copy(){
    		$sec = $this->session->userdata("SECTION");
	    	$query = $this->db->query("SELECT MAX(rev.INT_ID_COPY) as id FROM MSU.TT_COPY_DOC rev JOIN MSU.TM_DOCUMENT doc ON rev.INT_ID_DOCUMENT = doc.INT_ID_DOCUMENT WHERE doc.INT_ID_SECTION = '$sec'");
	    	return $query->result();
	    }

	    function get_copy_back($id) {
	    	$query = $this->db->query("SELECT * FROM MSU.TT_COPY_BACK WHERE INT_ID_COPY = $id");
	    	return $query->result();
	    }

	    function get_copy_num($id) {
	    	$query = $this->db->query("SELECT D.INT_ID_DOCUMENT, D.INT_REVISION FROM MSU.TM_DOCUMENT D JOIN MSU.TT_COPY_DOC R ON D.INT_ID_DOCUMENT = R.INT_ID_DOCUMENT WHERE R.INT_ID_COPY = $id");
	    	return $query->result();
	    }

	    function delete($id) {
	    	$this->db->where('INT_ID_COPY', $id);
	    	$this->db->delete('MSU.TT_COPY_DOC');
	    }

	    function delete_detail($id) {
	    	$this->db->where('INT_ID_COPY', $id);
	    	$this->db->delete('MSU.TT_COPY_BACK');
	    }

	    function update_doc($data, $id) {
			$this->db->where('INT_ID_DOCUMENT', $id);
			$this->db->update('MSU.TM_DOCUMENT', $data);
		}

		function update_copy($data, $id) {
			$this->db->where('INT_ID_COPY', $id);
			$this->db->update('MSU.TT_COPY_DOC', $data);
		}

		function delete_back($id) {
	    	$this->db->where('INT_ID_BACKGROUND', $id);
	    	$this->db->delete('MSU.TT_COPY_BACK');
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

		function get_npk_spv($sec) {
			// $dept = $this->session->userdata("SECTION");
			$query = $this->db->query("SELECT U.CHR_NPK FROM TM_USER U JOIN TM_SECTION D ON U.INT_ID_SECTION = D.INT_ID_SECTION JOIN TM_ROLE R ON U.INT_ID_ROLE = R.INT_ID_ROLE WHERE U.INT_ID_ROLE = 6 OR U.INT_ID_ROLE = 27 OR U.INT_ID_ROLE = 30 OR U.INT_ID_ROLE = 32 OR U.INT_ID_ROLE = 40 AND U.INT_ID_SECTION = $sec");
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