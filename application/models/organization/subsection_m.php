<?php

class subsection_m extends CI_Model {

     private $tabel = 'TM_SUB_SECTION';

    function get_subsection() {
        $query = $this->db->query("select a.INT_ID_SUB_SECTION, a.CHR_SUB_SECTION, a.CHR_SUB_SECTION_DESC, b.CHR_SECTION, b.INT_ID_SECTION
            from TM_SUB_SECTION a, TM_SECTION b
            where a.INT_ID_SECTION = b.INT_ID_SECTION and a.BIT_FLG_DEL = 0");
        return $query->result();
    }
	
	function get_subsection_by_id_section($id) {
        $query = $this->db->query("select a.INT_ID_SUB_SECTION, a.CHR_SUB_SECTION, a.CHR_SUB_SECTION_DESC, b.CHR_SECTION, b.INT_ID_SECTION
            from TM_SUB_SECTION a, TM_SECTION b
            where a.INT_ID_SECTION = b.INT_ID_SECTION
			and a.BIT_FLG_DEL = 0
			and a.INT_ID_SECTION = '" . $id . "'");
        return $query->result();
    }
	
	function get_id_section_by_id_subsection($id) {
        $query = $this->db->query("select INT_ID_SECTION from TM_SUB_SECTION where INT_ID_SUB_SECTION = '" . $id . "'")->result();
        $id_section = $query[0]->INT_ID_SECTION;
        return $id_section;
    }
	
    function get_name_subsection($id) {
        $query = $this->db->query("select CHR_SUB_SECTION from TM_SUB_SECTION where INT_ID_SUB_SECTION = '" . $id . "'")->result();
        $subsection = $query[0]->CHR_SUB_SECTION;
        return $subsection;
    }

    function get_desc_subsection($id) {
        $query = $this->db->query("select CHR_SUB_SECTION_DESC from TM_SUB_SECTION where INT_ID_SUB_SECTION = '" . $id . "'")->row_array();
        $subsection = $query['CHR_SUB_SECTION_DESC'];
        return $subsection;
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_subsection($id) {
        $query = $this->db->query("select a.INT_ID_SUB_SECTION, a.CHR_SUB_SECTION ,a.CHR_SUB_SECTION_DESC, b.CHR_SECTION, b.INT_ID_SECTION
            from TM_SUB_SECTION a, TM_SECTION b, TM_COST_CENTER c
            where a.INT_ID_SECTION = b.INT_ID_SECTION and a.BIT_FLG_DEL = 0 and a.INT_ID_SUB_SECTION = '" . $id . "'");
        return $query;
    }
    
    function get_subsection_by_section($id) {
        $query = $this->db->query("select INT_ID_SUB_SECTION, CHR_SUB_SECTION ,CHR_SUB_SECTION_DESC from TM_SUB_SECTION where BIT_FLG_DEL = 0 and INT_ID_SECTION = '" . $id . "'")->result();
        return $query;
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_SUB_SECTION', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_SUB_SECTION', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from TM_SUB_SECTION where CHR_SUB_SECTION = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_subsection() {
        return $this->db->query('select max(INT_ID_SUB_SECTION) as a from TM_SUB_SECTION')->row()->a + 1;
    }

}
