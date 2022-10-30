<?php

class pcb_m extends CI_Model {

    private $tabel = 'TM_PCB';
	
	function get_section() {
        $query = $this->db->query("select INT_ID_SECTION, CHR_SECTION, CHR_SECTION_DESC
            from TM_SECTION
            where BIT_FLG_DEL = 0
			and INT_ID_DEPT = 23");
        return $query->result();
    }
	
	function get_sub_section($id) {
        $query = $this->db->query("select INT_ID_SUB_SECTION, CHR_SUB_SECTION, CHR_SUB_SECTION_DESC
            from TM_SUB_SECTION
            where BIT_FLG_DEL = 0
			and INT_ID_SECTION = " . $id . "");
        return $query->result();
    }
	
	function get_pos($id) {
        $query = $this->db->query("select INT_ID_POS, INT_POS_NUMBER, CHR_POS_TITLE
            from TM_POS
            where BIT_FLG_DEL = 0
			and INT_ID_SUB_SECTION = " . $id . "");
        return $query->result();
    }
	
	function get_list_pcb($id) {
        $query = $this->db->query("select distinct a.INT_ID_POS, c.INT_POS_NUMBER, c.CHR_POS_TITLE, a.INT_ID_PCB, b.CHR_PCB_TITLE
			from TT_POS_PCB a, TM_PCB b, TM_POS c
			where a.INT_ID_PCB = b.INT_ID_PCB
			and a.INT_ID_POS = c.INT_ID_POS
			and a.BIT_FLG_DEL = 0
			and a.INT_ID_POS = " . $id . "");
        return $query->result();
    }
	
    function get_pcb($id1, $id2) {
        $query = $this->db->query("select a.INT_ID_POS_PCB, a.INT_ID_POS, c.INT_POS_NUMBER, c.CHR_POS_TITLE, a.INT_ID_PCB, b.CHR_PCB_TITLE, a.CHR_UPLOAD_DATE, a.CHR_UPLOAD_TIME, a.CHR_FILE_LOC
			from TT_POS_PCB a, TM_PCB b, TM_POS c
			where a.INT_ID_PCB = b.INT_ID_PCB
			and a.INT_ID_POS = c.INT_ID_POS
			and a.BIT_FLG_DEL = 0
			and a.INT_ID_POS = " . $id1 . "
			and a.INT_ID_PCB = " . $id2 . "
			order by a.CHR_UPLOAD_DATE,a.CHR_UPLOAD_TIME desc");
        return $query->result();
    }
	
	function save($data) {
        $this->db->insert($this->tabel, $data);
    }
	
	function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_PCB', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_PCB', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from TM_PCB where CHR_PCB_TITLE = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_section() {
        return $this->db->query('select max(INT_ID_PCB) as a from TM_PCB')->row()->a + 1;
    }

    /* function get_name_section($id) {
        $query = $this->db->query("select CHR_SECTION from TM_SECTION where INT_ID_SECTION = '" . $id . "'")->row_array();
        $section = $query['CHR_SECTION'];
        return $section;
    }

    function get_desc_section($id) {
        $query = $this->db->query("select CHR_SECTION_DESC from TM_SECTION where INT_ID_SECTION = '" . $id . "'")->row_array();
        $section = $query['CHR_SECTION_DESC'];
        return $section;
    }
    
    function get_section_by_costcenter($id_costcenter) {
        $query = $this->db->query("select b.INT_ID_SECTION, b.CHR_SECTION, b.CHR_SECTION_DESC from TM_COST_CENTER a, TM_SECTION b where a.INT_ID_COST_CENTER=b.INT_ID_COST_CENTER and a.INT_ID_COST_CENTER = '" . $id_costcenter . "' and a.BIT_FLG_DEL = 0");
        return $query->result();
    }
    
    function get_costcenter_by_section($id_section) {
        $query = $this->db->query("select a.INT_ID_COST_CENTER from TM_COST_CENTER a,TM_SECTION b where a.INT_ID_COST_CENTER = b.INT_ID_COST_CENTER and b.INT_ID_SECTION = '" . $id_section . "' and a.BIT_FLG_DEL = 0")->row_array();
        $cost_center = $query['INT_ID_COST_CENTER'];
        return $cost_center;
    } */
    
    /* function get_section_by_dept($id) {
        $query = $this->db->query("select INT_ID_SECTION, CHR_SECTION ,CHR_SECTION_DESC from TM_SECTION where BIT_FLG_DEL = 0 and INT_ID_DEPT = '" . $id . "'")->result();
        return $query;
    }
    
    function get_dept_by_section($id) {
        $query = $this->db->query("select INT_ID_DEPT from TM_SECTION where INT_ID_SECTION = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_DEPT'];
        return $part_of;
    } */

    /* function get_user_section($npk){
        return $this->db->query("select b.INT_ID_SECTION, b.CHR_SECTION, b.CHR_SECTION_DESC, c.INT_ID_DEPT, c.CHR_DEPT, c.CHR_DEPT_DESC
                                from TM_USER a, TM_SECTION b, TM_DEPT c
                                where a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=c.INT_ID_DEPT and a.CHR_NPK='$npk'")->row();
    }
    function get_section_org($sect){
        return $this->db->query("select INT_ID_SECTION, CHR_SECTION, CHR_SECTION_DESC from TM_SECTION where INT_ID_SECTION=$sect")->row();
    } */
}
