<?php

class doc_m extends CI_Model {

     private $tabel = 'TT_POS_DOC';

    function get_doc() {
        $query = $this->db->query("select INT_ID_DOC, CHR_DOC_TITLE
			from TM_DOC
			where BIT_FLG_DEL = 0
			and BIT_TYPE = 1
			order by CHR_DOC_TITLE asc");
        return $query->result();
    }
	
	function get_latest_doc_by_id_pos($id) {
        $query = $this->db->query("select a.INT_ID_POS_DOC, a.INT_ID_POS, b.INT_POS_NUMBER, b.CHR_POS_TITLE, a.INT_ID_DOC, c.CHR_DOC_TITLE, a.CHR_UPLOAD_BY, a.CHR_UPLOAD_DATE, a.CHR_UPLOAD_TIME, a.CHR_FILE_LOC
			from TT_POS_DOC a, TM_POS b, TM_DOC c
			where a.INT_ID_POS = b.INT_ID_POS
			and a.INT_ID_DOC = c.INT_ID_DOC
			and c.BIT_TYPE = 1
			and a.CHR_UPLOAD_DATE + a.CHR_UPLOAD_TIME IN (
				select max( CHR_UPLOAD_DATE+CHR_UPLOAD_TIME )
				from TT_POS_DOC
				where INT_ID_POS = '" . $id . "'
				group by INT_ID_DOC
				)
			order by a.INT_ID_DOC ASC , a.CHR_UPLOAD_DATE + a.CHR_UPLOAD_TIME DESC ");
        return $query->result();
    }
	
	function get_doc_history_by_id_pos_id_doc($id_pos, $id_doc) {
        $query = $this->db->query("select a.INT_ID_POS_DOC, a.INT_ID_POS, b.INT_POS_NUMBER, b.CHR_POS_TITLE, a.INT_ID_DOC, c.CHR_DOC_TITLE, a.CHR_UPLOAD_BY, a.CHR_UPLOAD_DATE, a.CHR_UPLOAD_TIME, a.CHR_FILE_LOC
			from TT_POS_DOC a, TM_POS b, TM_DOC c
			where a.INT_ID_POS = b.INT_ID_POS
			and a.INT_ID_DOC = c.INT_ID_DOC
			and a.INT_ID_POS = '" . $id_pos . "'
			and a.INT_ID_DOC = '" . $id_doc . "'
			order by a.CHR_UPLOAD_DATE + a.CHR_UPLOAD_TIME DESC ");
        return $query->result();
    }
	
	function get_id_subsection_by_id_pos_doc($id) {
        $query = $this->db->query("select INT_ID_SUB_SECTION from TM_POS where INT_ID_POS = '" . $id . "'")->result();
        $id_subsection = $query[0]->INT_ID_SUB_SECTION;
        return $id_subsection;
    }
	
	function get_id_section_by_id_pos_doc($id) {
        $query = $this->db->query("select b.INT_ID_SECTION
			from TM_POS a, TM_SUB_SECTION b
			where a.INT_ID_SUB_SECTION = b.INT_ID_SUB_SECTION
			and a.INT_ID_POS = '" . $id . "'")->result();
        $id_section = $query[0]->INT_ID_SECTION;
        return $id_section;
    }
	
    function get_name_doc($id) {
        $query = $this->db->query("select CHR_DOC_TITLE from TM_DOC where INT_ID_DOC = '" . $id . "'")->row_array();
        $pos = $query['CHR_DOC_TITLE'];
        return $pos;
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_pos($id) {
        $query = $this->db->query("select a.INT_ID_POS, a.INT_POS_NUMBER, a.CHR_POS_TITLE, b.INT_ID_SUB_SECTION, b.CHR_SUB_SECTION, b.CHR_SUB_SECTION_DESC
            from TM_POS a, TM_SUB_SECTION b
            where a.INT_ID_SUB_SECTION = b.INT_ID_SUB_SECTION
			and a.BIT_FLG_DEL = 0
			and a.INT_ID_POS = '" . $id . "'");
        return $query;
    }
    
    function get_pos_by_subsection($id) {
        $query = $this->db->query("select INT_ID_POS, INT_POS_NUMBER, CHR_POS_TITLE from TM_POS where BIT_FLG_DEL = 0 and INT_ID_SUB_SECTION = '" . $id . "'")->result();
        return $query;
    }

    function generate_id_doc() {
        return $this->db->query('select max(INT_ID_POS_DOC) as a from TT_POS_DOC')->row()->a + 1;
    }

}
