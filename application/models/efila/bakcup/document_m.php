<?php
	/**
	* 
	*/
	class document_m extends CI_Model
	{
		
		private $tabel = 'MSU.TM_DOCUMENT';

	    function get_document() {
	    	// $sec = $this->session->userdata("SECTION");
	        $query = $this->db->query("SELECT d.CHR_EFFECTIVE_DATE, d.INT_ID_DOCUMENT, d.CHR_DOCUMENT_NAME, d.INT_ID_CATEGORY, d.CHR_PIC, "
                        . "d.CHR_NO_DOC, d.INT_REVISION, d.CHR_DOC, c.CHR_CATEGORY_NAME, de.CHR_DEPT "
                        . "FROM MSU.TM_DOCUMENT d "
                        . "JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY "
                        . "JOIN TM_SECTION s ON d.INT_ID_SECTION = s.INT_ID_SECTION "
                        . "JOIN TM_DEPT de ON s.INT_ID_DEPT = de.INT_ID_DEPT "
                        . "JOIN MSU.TT_REGISTER_DOC reg ON d.INT_ID_DOCUMENT = reg.INT_ID_DOC "
                        . "WHERE d.INT_STATUS = 1 AND d.INT_STATUS_APPROVED = 1");
	        // $query = $this->db->query("MSU.zsp_select_dist_document");
	        return $query->result_array();
	    }

	    function get_document_by_catdept($id, $dept) {
	    	// $sec = $this->session->userdata("SECTION");
	        $query = $this->db->query("SELECT d.CHR_EFFECTIVE_DATE, d.INT_ID_DOCUMENT, d.CHR_DOCUMENT_NAME, d.INT_ID_CATEGORY, d.CHR_PIC, d.CHR_NO_DOC, d.INT_REVISION, d.CHR_DOC, c.CHR_CATEGORY_NAME, de.CHR_DEPT FROM MSU.TM_DOCUMENT d JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY JOIN TM_SECTION s ON d.INT_ID_SECTION = s.INT_ID_SECTION JOIN TM_DEPT de ON s.INT_ID_DEPT = de.INT_ID_DEPT JOIN MSU.TT_REGISTER_DOC reg ON d.INT_ID_DOCUMENT = reg.INT_ID_DOC WHERE d.INT_STATUS = 1 AND d.INT_STATUS_APPROVED = 1 AND d.INT_ID_CATEGORY = $id AND de.INT_ID_DEPT = $dept");
	        // $query = $this->db->query("MSU.zsp_select_dist_document_bycat @category=$id");
	        return $query->result_array();
	    }

	    function get_document_by_cat($id) {
	    	// $sec = $this->session->userdata("SECTION");
	        $query = $this->db->query("SELECT d.CHR_EFFECTIVE_DATE, d.INT_ID_DOCUMENT, d.CHR_DOCUMENT_NAME, d.INT_ID_CATEGORY, d.CHR_PIC, d.CHR_NO_DOC, d.INT_REVISION, d.CHR_DOC, c.CHR_CATEGORY_NAME, de.CHR_DEPT FROM MSU.TM_DOCUMENT d JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY JOIN TM_SECTION s ON d.INT_ID_SECTION = s.INT_ID_SECTION JOIN TM_DEPT de ON s.INT_ID_DEPT = de.INT_ID_DEPT JOIN MSU.TT_REGISTER_DOC reg ON d.INT_ID_DOCUMENT = reg.INT_ID_DOC WHERE d.INT_STATUS = 1 AND d.INT_STATUS_APPROVED = 1 AND d.INT_ID_CATEGORY = $id");
	        // $query = $this->db->query("MSU.zsp_select_dist_document_bycat @category=$id");
	        return $query->result_array();
	    }

	    function get_document_by_dept($dept) {
	    	// $sec = $this->session->userdata("SECTION");
	        $query = $this->db->query("SELECT d.CHR_EFFECTIVE_DATE, d.INT_ID_DOCUMENT, d.CHR_DOCUMENT_NAME, d.INT_ID_CATEGORY, d.CHR_PIC, d.CHR_NO_DOC, d.INT_REVISION, d.CHR_DOC, c.CHR_CATEGORY_NAME, de.CHR_DEPT FROM MSU.TM_DOCUMENT d JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY JOIN TM_SECTION s ON d.INT_ID_SECTION = s.INT_ID_SECTION JOIN TM_DEPT de ON s.INT_ID_DEPT = de.INT_ID_DEPT JOIN MSU.TT_REGISTER_DOC reg ON d.INT_ID_DOCUMENT = reg.INT_ID_DOC WHERE d.INT_STATUS = 1 AND d.INT_STATUS_APPROVED = 1 AND de.INT_ID_DEPT = $dept");
	        // $query = $this->db->query("MSU.zsp_select_dist_document_bycat @category=$id");
	        return $query->result_array();
	    }

	    function get_distribution_dept() {
	    	$query = $this->db->query("SELECT DOC.INT_ID_DOCUMENT, D.INT_ID_DEPT FROM MSU.TT_REGIST_DISTRIBUTION D JOIN MSU.TT_REGISTER_DOC R ON D.INT_ID_REGISTER = R.INT_ID_REGISTER JOIN MSU.TM_DOCUMENT DOC ON R.INT_ID_DOC = DOC.INT_ID_DOCUMENT WHERE DOC.INT_STATUS_APPROVED = 1");
	    	return $query->result();
	    }

	    function get_list_document() {
	    	$dep = $this->session->userdata("DEPT");
	        $query = $this->db->query("SELECT d.INT_ID_DOCUMENT, d.CHR_DOCUMENT_NAME, d.CHR_DOCUMENT_DESC, d.INT_ID_CATEGORY, d.CHR_CREATED_BY, d.CHR_DOC, c.CHR_CATEGORY_NAME FROM MSU.TM_DOCUMENT d JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE d.INT_STATUS = 1 AND d.INT_STATUS_APPROVED = 1 AND d.INT_ID_SECTION IN (SELECT INT_ID_SECTION FROM TM_SECTION WHERE INT_ID_DEPT = $dep)");
	        return $query->result();
	    }

	    function get_category() {
	    	$query = $this->db->query("SELECT * FROM MSU.TM_CATEGORY_DOC WHERE INT_STATUS = 1");
	    	return $query->result();
	    }

	    function get_id_doc(){
    		$sec = $this->session->userdata("SECTION");
	    	$query = $this->db->query("SELECT MAX(INT_ID_DOCUMENT) as id FROM MSU.TM_DOCUMENT WHERE INT_ID_SECTION = '$sec'");
	    	return $query->result();
	    }

	    function get_dept_name() {
	    	$id = $this->session->userdata('DEPT');
	    	$query = $this->db->query("SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = $id");
	    	return $query->result();
	    }

	    function get_department() {
	    	$query = $this->db->query("SELECT * FROM TM_DEPT WHERE BIT_FLG_DEL = 0");
	    	return $query->result();
	    }

	    function save_document($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function save_approval($data) {
	        $this->db->insert('MSU.TT_APPROVAL_DOC', $data);
	    }

	    function save_revision($data) {
	        $this->db->insert('MSU.TT_APPROVAL_DOC', $data);
	    }

	    function get_data_document($id) {
	    	$sec = $this->session->userdata("SECTION");
	        $query = $this->db->query("SELECT INT_ID_DOCUMENT, INT_ID_SECTION, CHR_AWARD_NAME, CHR_AWARD_DESC, INT_ID_CATEGORY, CHR_DOCUMENT_NAME, CHR_DOCUMENT_DESC, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, CHR_MODIFIED_BY, CHR_MODIFIED_DATE, CHR_MODIFIED_TIME, CHR_DOC FROM MSU.TM_DOCUMENT WHERE INT_ID_DOCUMENT = '" . $id . "' AND INT_STATUS = '1' AND INT_ID_SECTION = '$sec'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function delete($id) {
	        $data = array('INT_STATUS' => 0);

	        $this->db->where('INT_ID_DOCUMENT', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function update($data, $id) {
	        $this->db->where('INT_ID_DOCUMENT', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    //Approval Manager

	    function get_section() {
	    	$dept = $this->session->userdata("DEPT");
	    	$query = $this->db->query("SELECT s.INT_ID_SECTION AS ID_SECTION, s.CHR_SECTION AS NAME, s.CHR_SECTION_DESC AS DESCRIPTION FROM TM_SECTION s JOIN TM_DEPT d ON s.INT_ID_DEPT = d.INT_ID_DEPT WHERE d.INT_ID_DEPT = '$dept'");
	    	return $query->result();
	    }

	    function get_doc_list($sec) {
	    	$query = $this->db->query("SELECT a.INT_ID AS ID, d.CHR_DOCUMENT_NAME AS DOC_NAME, d.CHR_DOCUMENT_DESC AS DOC_DESC, c.CHR_CATEGORY_NAME AS CAT_NAME, d.CHR_DOC AS DOC, d.CHR_CREATED_BY AS CREA_BY, a.CHR_INFORMATION AS INFO, 
				CASE 
					WHEN a.INT_TYPE = 1 THEN 'Apply Document' 
					WHEN a.INT_TYPE = 2 THEN 'Revision Document' 
					WHEN a.INT_TYPE = 3 THEN 'Obsolete Document'
					WHEN a.INT_TYPE = 4 THEN 'Copy Document'
				END AS TIPE
				FROM MSU.TT_APPROVAL_DOC AS a JOIN MSU.TM_DOCUMENT AS d ON a.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY 
				WHERE d.INT_ID_SECTION = '$sec' AND a.INT_APPROVED_MANAGER IS NULL");
	    	return $query->result();	
	    }

	    function approval_manager($id, $data) {
	    	$this->db->where('INT_ID', $id);
	    	$this->db->update('MSU.TT_APPROVAL_DOC', $data);
	    }

	    function get_sec($id) {
	    	$query = $this->db->query("SELECT d.INT_ID_SECTION AS ID FROM MSU.TT_APPROVAL_DOC a JOIN MSU.TM_DOCUMENT d ON a.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT WHERE a.INT_ID = $id");
	    	return $query->result();
	    }

	    function get_approved_doc($sec) {
	    	$query = $this->db->query("SELECT a.INT_ID AS ID, d.CHR_DOCUMENT_NAME AS DOC_NAME, d.CHR_DOCUMENT_DESC AS DOC_DESC, c.CHR_CATEGORY_NAME AS CAT_NAME, d.CHR_DOC AS DOC, d.CHR_CREATED_BY AS CREA_BY FROM MSU.TT_APPROVAL_DOC AS a JOIN MSU.TM_DOCUMENT AS d ON a.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE d.INT_ID_SECTION = '$sec' AND a.INT_APPROVED_MANAGER = 1");
	    	return $query->result();
	    }

	    //Approval GM
	    function get_section_gm() {
	    	$gd = $this->session->userdata("GROUPDEPT");
	    	$query = $this->db->query("SELECT s.INT_ID_SECTION AS ID_SECTION, s.CHR_SECTION AS NAME, s.CHR_SECTION_DESC AS DESCRIPTION FROM TM_SECTION s JOIN TM_DEPT d ON s.INT_ID_DEPT = d.INT_ID_DEPT JOIN TM_GROUP_DEPT g ON g.INT_ID_GROUP_DEPT = d.INT_ID_GROUP_DEPT WHERE g.INT_ID_GROUP_DEPT = '$gd'");
	    	return $query->result();
	    }

	    function get_doc_list_gm($sec) {
	    	$query = $this->db->query("SELECT a.INT_ID AS ID, d.CHR_DOCUMENT_NAME AS DOC_NAME, d.CHR_DOCUMENT_DESC AS DOC_DESC, c.CHR_CATEGORY_NAME AS CAT_NAME, d.CHR_DOC AS DOC, d.CHR_CREATED_BY AS CREA_BY, a.CHR_INFORMATION AS INFO FROM MSU.TT_APPROVAL_DOC AS a JOIN MSU.TM_DOCUMENT AS d ON a.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE d.INT_ID_SECTION = '$sec' AND a.INT_APPROVED_MANAGER = 1 AND a.INT_APPROVED_GM IS NULL");
	    	return $query->result();	
	    }

	    function approval_gm($id, $data) {
	    	$this->db->where('INT_ID', $id);
	    	$this->db->update('MSU.TT_APPROVAL_DOC', $data);
	    }

	    function get_approved_doc_gm($sec) {
	    	$query = $this->db->query("SELECT a.INT_ID AS ID, d.CHR_DOCUMENT_NAME AS DOC_NAME, d.CHR_DOCUMENT_DESC AS DOC_DESC, c.CHR_CATEGORY_NAME AS CAT_NAME, d.CHR_DOC AS DOC, d.CHR_CREATED_BY AS CREA_BY FROM MSU.TT_APPROVAL_DOC AS a JOIN MSU.TM_DOCUMENT AS d ON a.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE d.INT_ID_SECTION = '$sec' AND a.INT_APPROVED_MANAGER = 1 AND a.INT_APPROVED_GM = 1");
	    	return $query->result();
	    }

	    //Approval MSU
	    function get_section_msu() {
	    	$query = $this->db->query("SELECT s.INT_ID_SECTION AS ID_SECTION, s.CHR_SECTION AS NAME, s.CHR_SECTION_DESC AS DESCRIPTION FROM TM_SECTION s JOIN TM_DEPT d ON s.INT_ID_DEPT = d.INT_ID_DEPT");
	    	return $query->result();
	    }

	    function get_doc_list_msu($sec) {
	    	$query = $this->db->query("SELECT a.INT_ID AS ID, d.CHR_DOCUMENT_NAME AS DOC_NAME, d.CHR_DOCUMENT_DESC AS DOC_DESC, c.CHR_CATEGORY_NAME AS CAT_NAME, d.CHR_DOC AS DOC, d.CHR_CREATED_BY AS CREA_BY, a.CHR_INFORMATION AS INFO FROM MSU.TT_APPROVAL_DOC AS a JOIN MSU.TM_DOCUMENT AS d ON a.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE d.INT_ID_SECTION = '$sec' AND a.INT_APPROVED_MANAGER = 1 AND a.INT_APPROVED_GM = 1 AND a.INT_APPROVED_MSU IS NULL");
	    	return $query->result();	
	    }

	    function get_approved_doc_msu() {
	    	$query = $this->db->query("SELECT a.INT_ID AS ID, d.CHR_DOCUMENT_NAME AS DOC_NAME, d.CHR_DOCUMENT_DESC AS DOC_DESC, c.CHR_CATEGORY_NAME AS CAT_NAME, d.CHR_DOC AS DOC, d.CHR_CREATED_BY AS CREA_BY FROM MSU.TT_APPROVAL_DOC AS a JOIN MSU.TM_DOCUMENT AS d ON a.INT_ID_DOCUMENT = d.INT_ID_DOCUMENT JOIN MSU.TM_CATEGORY_DOC c ON d.INT_ID_CATEGORY = c.INT_ID_CATEGORY WHERE a.INT_APPROVED_MANAGER = 1 AND a.INT_APPROVED_GM = 1 AND a.INT_APPROVED_MSU = 1");
	    	return $query->result();
	    }

	    function approval_msu($id, $data) {
	    	$this->db->where('INT_ID', $id);
	    	$this->db->update('MSU.TT_APPROVAL_DOC', $data);
	    }

	    function get_doc_rev($no) {
	    	$query = $this->db->query("SELECT INT_REVISION FROM MSU.TM_DOCUMENT WHERE CHR_NO_DOC = '$no'");
	    	return $query->result();
	    }

	    function get_effective_date($no) {
	    	$query = $this->db->query("SELECT r.CHR_EFFECTIVE_DATE FROM MSU.TT_REGISTER_DOC r JOIN MSU.TM_DOCUMENT d ON r.INT_ID_DOC = d.INT_ID_DOCUMENT WHERE d.CHR_NO_DOC = '$no'");
	    	return $query->result();
	    }
	}
?>