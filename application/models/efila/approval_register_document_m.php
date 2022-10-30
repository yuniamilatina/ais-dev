<?php
	/**
	* 
	*/
	class approval_register_document_m extends CI_Model
	{
		
		private $table = 'TT_REGISTER_DOC';

		//Approval Manager

		function get_register_manager() {
			$dept = $this->session->userdata('DEPT');
			$query = $this->db->query("SELECT r.INT_ID_REGISTER, r.CHR_NPK, r.CHR_EFFECTIVE_DATE, r.CHR_SCOPE, r.CHR_CREATED_BY, r.CHR_CREATED_DATE, d.CHR_DOC, c.CHR_CATEGORY_NAME, d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC FROM TT_REGISTER_DOC r JOIN TM_DOCUMENT d ON r.INT_ID_DOC = d.INT_ID_DOCUMENT JOIN TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE r.INT_ID_DEPT =  $dept AND r.INT_APPROVED_MANAGER IS NULL AND r.INT_STATUS = 1");
			return $query->result();
		}


	    //Approval GM

	    function get_register_gm() {
	    	$gd = $this->session->userdata("GROUPDEPT");
	    	$query = $this->db->query("SELECT r.INT_ID_REGISTER, r.CHR_NPK, r.CHR_EFFECTIVE_DATE, r.CHR_SCOPE, r.CHR_CREATED_BY, r.CHR_CREATED_DATE, d.CHR_DOC, c.CHR_CATEGORY_NAME, d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC FROM TT_REGISTER_DOC r JOIN TM_DOCUMENT d ON r.INT_ID_DOC = d.INT_ID_DOCUMENT JOIN TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE r.INT_ID_DEPT IN(SELECT d.INT_ID_DEPT FROM TM_DEPT d WHERE d.INT_ID_GROUP_DEPT = $gd) AND r.INT_APPROVED_MANAGER = 1 AND r.INT_APPROVED_GM IS NULL AND r.INT_STATUS = 1 AND c.CHR_CATEGORY_NAME != 'STD'");
	    	return $query->result();
	    }

	    //Approval MSU

	    function get_register_msu() {
	    	$query = $this->db->query("SELECT r.INT_ID_REGISTER, r.CHR_NPK, r.CHR_EFFECTIVE_DATE, r.CHR_SCOPE, r.CHR_CREATED_BY, r.CHR_CREATED_DATE, d.CHR_DOC, c.CHR_CATEGORY_NAME, d.INT_ID_DOCUMENT, c.INT_ID_CATEGORY, dep.CHR_DEPT, d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC FROM TT_REGISTER_DOC r JOIN TM_DOCUMENT d ON r.INT_ID_DOC = d.INT_ID_DOCUMENT JOIN TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY JOIN TM_DEPT dep ON dep.INT_ID_DEPT = r.INT_ID_DEPT WHERE r.INT_APPROVED_MANAGER = 1 AND r.INT_APPROVED_GM = 1 AND r.INT_APPROVED_MSU IS NULL AND r.INT_STATUS = 1 AND c.CHR_CATEGORY_NAME != 'STD'");
	    	return $query->result();
	    }

	    function get_register_std_msu() {
	    	$query = $this->db->query("SELECT r.INT_ID_REGISTER, r.CHR_NPK, r.CHR_EFFECTIVE_DATE, r.CHR_SCOPE, r.CHR_CREATED_BY, r.CHR_CREATED_DATE, d.CHR_DOC, c.CHR_CATEGORY_NAME, d.INT_ID_DOCUMENT, c.INT_ID_CATEGORY, dep.CHR_DEPT, d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC FROM TT_REGISTER_DOC r JOIN TM_DOCUMENT d ON r.INT_ID_DOC = d.INT_ID_DOCUMENT JOIN TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY JOIN TM_DEPT dep ON dep.INT_ID_DEPT = r.INT_ID_DEPT WHERE r.INT_APPROVED_MANAGER = 1 AND r.INT_APPROVED_MSU IS NULL AND r.INT_STATUS = 1 AND c.CHR_CATEGORY_NAME = 'STD'");
	    	return $query->result();
	    }

	    //Get Detail & Save Approval

		function get_register_dist($id) {
			$query = $this->db->query("SELECT d.CHR_DEPT, d.CHR_DEPT_DESC FROM TT_REGIST_DISTRIBUTION r JOIN TM_DEPT d ON r.INT_ID_DEPT = d.INT_ID_DEPT WHERE r.INT_ID_REGISTER = $id");
			return $query->result();
		}

		function get_register_supp($id) {
			$query = $this->db->query("SELECT d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC, d.CHR_DOC FROM TT_SUPPORT_DOC s JOIN TM_DOCUMENT d ON s.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT WHERE s.INT_ID_REGISTER = $id");
			return $query->result();
		}

		function get_request_detail($id) {
			$query = $this->db->query("SELECT * FROM TT_DETAIL_REQUEST WHERE INT_ID_REGISTER = $id");
			return $query->result();
		}

		function get_filename($id) {
			$query = $this->db->query("SELECT CHR_DOC FROM TM_DOCUMENT WHERE INT_ID_DOCUMENT = $id");
			return $query->result();
		}

		function save_approval($id, $data) {
	        $this->db->where('INT_ID_REGISTER', $id);
	        $this->db->update($this->table, $data);
	    }

	    function update_no_doc($id, $data) {
	    	$this->db->where('INT_ID_DOCUMENT', $id);
	        $this->db->update('TM_DOCUMENT', $data);
	    }

	    function check_no_doc($no) {
	    	$query = $this->db->query("SELECT CHR_NO_DOC FROM TM_DOCUMENT WHERE CHR_NO_DOC = '$no'");
	    	return $query->result();
	    }

	    function get_effective_date($id) {
			$query = $this->db->query("SELECT CHR_EFFECTIVE_DATE FROM TT_REGISTER_DOC WHERE INT_ID_DOC = $id");
			return $query->result();
		}

	    //Notification
		function get_id_notif() {
			$query = $this->db->query("SELECT MAX(INT_ID_NOTIF) AS MAX_ID FROM TT_PORTAL_NOTIFICATION");
			return $query->result();
		}

		function get_npk_gm() {
			$gdept = $this->session->userdata("GROUPDEPT");
			$query = $this->db->query("SELECT U.CHR_NPK FROM TM_USER U JOIN TM_GROUP_DEPT D ON U.INT_ID_GROUP_DEPT = D.INT_ID_GROUP_DEPT JOIN TM_ROLE R ON U.INT_ID_ROLE = R.INT_ID_ROLE WHERE U.INT_ID_ROLE = 4 AND U.INT_ID_GROUP_DEPT = $gdept");
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

		function get_cat_name($id) {
			$query = $this->db->query("SELECT C.CHR_CATEGORY_NAME FROM TT_REGISTER_DOC R JOIN TM_DOCUMENT D ON R.INT_ID_DOC = D.INT_ID_DOCUMENT JOIN TM_CATEGORY_DOC C ON D.INT_ID_CATEGORY = C.INT_ID_CATEGORY WHERE R.INT_ID_REGISTER = $id");
			return $query->result();
		}

		function get_npk($id) {
			$query = $this->db->query("SELECT CHR_NPK FROM TT_REGISTER_DOC WHERE INT_ID_REGISTER = $id");
			return $query->result();
		}

		//Save PIC
		function get_id_doc($id) {
			$query = $this->db->query("SELECT D.INT_ID_DOCUMENT FROM TM_DOCUMENT D JOIN TT_REGISTER_DOC R ON R.INT_ID_DOC = D.INT_ID_DOCUMENT WHERE R.INT_ID_REGISTER = $id");
			$id_doc = "";
			foreach ($query->result() as $key) {
				$id_doc = $key->INT_ID_DOCUMENT;
			}
			return $id_doc;
		}

		function update_doc($id, $data) {
			$this->db->where('INT_ID_DOCUMENT', $id);
			$this->db->update('TM_DOCUMENT', $data);
		}

		//Validasi no dokumen
		function get_no_doc(){
			$query = $this->db->query("SELECT * FROM TM_DOCUMENT");
			return $query->result();
		}
	}
?>