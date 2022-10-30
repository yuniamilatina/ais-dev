<?php

class pos_m extends CI_Model {

     private $tabel = 'TM_POS';

    function get_pos() {
        $query = $this->db->query("select a.INT_ID_POS, a.INT_POS_NUMBER, a.CHR_POS_TITLE, b.INT_ID_SUB_SECTION, b.CHR_SUB_SECTION, b.CHR_SUB_SECTION_DESC, b.INT_ID_SECTION
            from TM_POS a, TM_SUB_SECTION b
            where a.INT_ID_SUB_SECTION = b.INT_ID_SUB_SECTION
			and a.BIT_FLG_DEL = 0");
        return $query->result();
    }
	
	function get_pos_per_sub_section() {
        $query = $this->db->query("select a.CHR_SECTION_DESC, b.CHR_SUB_SECTION, c.INT_POS_NUMBER, c.CHR_POS_TITLE, c.INT_ID_POS
			from TM_SECTION a, TM_SUB_SECTION b, TM_POS c
			where a.INT_ID_SECTION = b.INT_ID_SECTION
			and b.INT_ID_SUB_SECTION = c.INT_ID_SUB_SECTION");
        return $query->result();
    }
	
	function get_pos_video_per_sub_section() {
        $query = $this->db->query("select a.CHR_SECTION_DESC, b.CHR_SUB_SECTION, c.INT_POS_NUMBER, c.CHR_POS_TITLE, c.INT_ID_POS, d.INT_ID_VIDEO, d.CHR_VIDEO_DESC
			from TM_SECTION a, TM_SUB_SECTION b, TM_POS c, TM_VIDEO d
			where a.INT_ID_SECTION = b.INT_ID_SECTION
			and b.INT_ID_SUB_SECTION = c.INT_ID_SUB_SECTION
			and c.INT_SET_ID_VIDEO = d.INT_ID_VIDEO");
        return $query->result();
    }
	
	function get_pos_by_id_subsection($id) {
        $query = $this->db->query("select a.INT_ID_POS, a.INT_POS_NUMBER, a.CHR_POS_TITLE, b.INT_ID_SUB_SECTION, b.CHR_SUB_SECTION, b.CHR_SUB_SECTION_DESC, b.INT_ID_SECTION
            from TM_POS a, TM_SUB_SECTION b
            where a.INT_ID_SUB_SECTION = b.INT_ID_SUB_SECTION
			and a.BIT_FLG_DEL = 0
			and b.INT_ID_SUB_SECTION = '" . $id . "'");
        return $query->result();
    }
	
	function get_id_subsection_by_id_pos($id) {
        $query = $this->db->query("select INT_ID_SUB_SECTION from TM_POS where INT_ID_POS = '" . $id . "'")->result();
        $id_subsection = $query[0]->INT_ID_SUB_SECTION;
        return $id_subsection;
    }
	
	function get_id_section_by_id_pos($id) {
        $query = $this->db->query("select b.INT_ID_SECTION
			from TM_POS a, TM_SUB_SECTION b
			where a.INT_ID_SUB_SECTION = b.INT_ID_SUB_SECTION
			and a.INT_ID_POS = '" . $id . "'")->result();
        $id_section = $query[0]->INT_ID_SECTION;
        return $id_section;
    }
	
    function get_number_pos($id) {
        $query = $this->db->query("select INT_POS_NUMBER from TM_POS where INT_ID_POS = '" . $id . "'")->row_array();
        $pos = $query['INT_POS_NUMBER'];
        return $pos;
    }

    function get_title_pos($id) {
        $query = $this->db->query("select CHR_POS_TITLE from TM_POS where INT_ID_POS = '" . $id . "'")->row_array();
        $pos = $query['CHR_POS_TITLE'];
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

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_POS', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_POS', $id);
        $this->db->update($this->tabel, $data);
    }

    /*function check_id($id) {
        $find_id = $this->db->query("select * from TM_POS where CHR_POS_TITLE = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }*/

    function generate_id_pos() {
        return $this->db->query('select max(INT_ID_POS) as a from TM_POS')->row()->a + 1;
    }

}
