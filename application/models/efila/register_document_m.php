<?php
	/**
	* 
	*/
	class register_document_m extends CI_Model
	{
		
		private $tabel = 'MSU.TT_REGISTER_DOC';

		function get_regist() {
			$sec = $this->session->userdata('SECTION');
			$query = $this->efila->query("SELECT reg.INT_ID_REGISTER, reg.CHR_CREATED_BY, reg.CHR_CREATED_DATE, reg.CHR_INFO, doc.CHR_DOCUMENT_NAME, doc.CHR_DOCUMENT_DESC, doc.CHR_DOC, doc.CHR_NO_DOC, doc.INT_ID_DOCUMENT, cat.CHR_CATEGORY_NAME, reg.INT_APPROVED_MANAGER, reg.INT_APPROVED_GM, reg.INT_APPROVED_MSU, reg.INT_STATUS, reg.CHR_SCOPE, reg.CHR_EFFECTIVE_DATE FROM MSU.TT_REGISTER_DOC reg JOIN MSU.TM_DOCUMENT doc ON reg.INT_ID_DOC = doc.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC cat ON doc.INT_ID_CATEGORY = cat.INT_ID_CATEGORY WHERE doc.INT_ID_SECTION = $sec ORDER BY reg.INT_ID_REGISTER DESC");
			return $query->result();
		}

		function get_request($req) {
			$query = $this->db->query("SELECT req.INT_ID_REQUEST, cat.INT_ID_CATEGORY, cat.CHR_CATEGORY_NAME FROM MSU.TT_REQUEST_DOC req JOIN MSU.TM_CATEGORY_DOC cat ON req.INT_ID_CATEGORY = cat.INT_ID_CATEGORY WHERE req.INT_ID_REQUEST = $req");
			return $query->result();
		}

		function get_dept() {
			$query = $this->db->query("SELECT INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC FROM TM_DEPT WHERE INT_ID_DEPT != 0");
			return $query->result();
		}

		function get_doc() {
			$query = $this->db->query("SELECT INT_ID_DOCUMENT, INT_ID_CATEGORY, CHR_DOCUMENT_NAME, CHR_DOCUMENT_DESC, CHR_NO_DOC FROM MSU.TM_DOCUMENT WHERE INT_STATUS_APPROVED = 1");
			return $query->result();
		}

		function get_id_doc(){
    		$sec = $this->session->userdata("SECTION");
	    	$query = $this->db->query("SELECT MAX(INT_ID_DOCUMENT) as id FROM MSU.TM_DOCUMENT WHERE INT_ID_SECTION = '$sec'");
	    	return $query->result();
	    }

	    function get_id_reg(){
    		$sec = $this->session->userdata("SECTION");
	    	$query = $this->db->query("SELECT MAX(reg.INT_ID_REGISTER) as id FROM MSU.TT_REGISTER_DOC reg JOIN MSU.TM_DOCUMENT doc ON reg.INT_ID_DOC = doc.INT_ID_DOCUMENT WHERE doc.INT_ID_SECTION = '$sec'");
	    	return $query->result();
	    }
		
		function save_doc($data) {
	    	$this->db->insert('MSU.TM_DOCUMENT', $data);
	    }

		function save_regist($data) {
	    	$this->db->insert($this->tabel, $data);
	    }

	    function save_supp($data) {
	    	$this->db->insert('MSU.TT_SUPPORT_DOC', $data);
	    }

	    function save_dist($data) {
	    	$this->db->insert('MSU.TT_REGIST_DISTRIBUTION', $data);
	    }

	    // function update($data, $id) {
	    //     $this->db->where('INT_ID_REQUEST', $id);
	    //     $this->db->update($this->tabel, $data);
	    // }

	    function propose($id, $iddoc) {
	        $data = array(
	        	'INT_STATUS' => 1,
	        	'INT_APPROVED_MANAGER' => NULL,
	        	'INT_APPROVED_GM' => NULL,
	        	'INT_APPROVED_MSU' => NULL
	        );

	        $this->db->where('INT_ID_REGISTER', $id);
	        $this->db->update($this->tabel, $data);

	        $data1 = array('INT_STATUS' => 1);
	        $this->db->where('INT_ID_DOCUMENT', $iddoc);
	        $this->db->update('MSU.TM_DOCUMENT', $data1);
	    }

	    function get_category() {
	    	$query = $this->db->query("SELECT * FROM MSU.TM_CATEGORY_DOC WHERE INT_STATUS = 1");
	    	return $query->result();
	    }

	    function get_register_dist($id) {
			$query = $this->db->query("SELECT d.CHR_DEPT, d.CHR_DEPT_DESC, r.INT_ID_DIST FROM MSU.TT_REGIST_DISTRIBUTION r JOIN TM_DEPT d ON r.INT_ID_DEPT = d.INT_ID_DEPT WHERE r.INT_ID_REGISTER = $id");
			return $query->result();
		}

		function get_register_supp($id) {
			$query = $this->db->query("SELECT d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC, d.CHR_DOC, s.INT_ID_DOCUMENT FROM MSU.TT_SUPPORT_DOC s JOIN MSU.TM_DOCUMENT d ON s.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT WHERE s.INT_ID_REGISTER = $id");
			return $query->result();
		}

		function get_request_detail($id) {
			$query = $this->db->query("SELECT * FROM MSU.TT_DETAIL_REQUEST WHERE INT_ID_REGISTER = $id");
			return $query->result();
		}

		function save_request_detail($data) {
	    	$this->db->insert('MSU.TT_DETAIL_REQUEST', $data);
	    }

		function update_doc($data, $id) {
			$this->db->where('INT_ID_DOCUMENT', $id);
			$this->db->update('MSU.TM_DOCUMENT', $data);
		}

		function update_reg($data, $id) {
			$this->db->where('INT_ID_REGISTER', $id);
			$this->db->update('MSU.TT_REGISTER_DOC', $data);
		}

		function delete_doc($id) {
			$this->db->where('INT_ID_DOCUMENT', $id);
			$this->db->delete('MSU.TM_DOCUMENT');
		}

		function delete($id) {
			$this->db->where('INT_ID_REGISTER', $id);
			$this->db->delete('MSU.TT_REGIST_DISTRIBUTION');

			$this->db->where('INT_ID_REGISTER', $id);
			$this->db->delete('MSU.TT_SUPPORT_DOC');

			$this->db->where('INT_ID_REGISTER', $id);
			$this->db->delete('MSU.TT_DETAIL_REQUEST');

			$this->db->where('INT_ID_REGISTER', $id);
			$this->db->delete('MSU.TT_REGISTER_DOC');
		}

		function delete_reason($id) {
			$this->db->where('INT_ID_DETAIL', $id);
			$this->db->delete('MSU.TT_DETAIL_REQUEST');
		}

		function save_reason($data) {
			$this->db->insert('MSU.TT_DETAIL_REQUEST', $data);
		}

		function delete_dist($id) {
			$this->db->where('INT_ID_DIST', $id);
			$this->db->delete('MSU.TT_REGIST_DISTRIBUTION');
		}

		// function save_dist($data) {
		// 	$this->db->insert('MSU.TT_REGIST_DISTRIBUTION', $data);
		// }

		function delete_support($id, $regist) {
			$this->db->where('INT_ID_REGISTER', $regist);
			$this->db->where('INT_ID_DOCUMENT', $id);
			$this->db->delete('MSU.TT_SUPPORT_DOC');
		}

		function save_support($data) {
			$this->db->insert('MSU.TT_SUPPORT_DOC', $data);
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