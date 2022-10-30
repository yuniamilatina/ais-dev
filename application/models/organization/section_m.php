<?php

class section_m extends CI_Model {

     private $tabel = 'TM_SECTION';

    function get_section() {
        $query = $this->db->query("select a.INT_ID_SECTION, a.CHR_SECTION, a.CHR_SECTION_DESC, b.CHR_DEPT, c.CHR_COST_CENTER
            from TM_SECTION a, TM_DEPT b, CPL.TM_COST_CENTER c 
            where a.INT_ID_DEPT = b.INT_ID_DEPT and a.INT_ID_COST_CENTER = c.INT_ID_COST_CENTER and a.BIT_FLG_DEL = 0
            ORDER BY a.CHR_SECTION, a.CHR_SECTION_DESC ASC");
			//var_dump($query);die();
        return $query->result();
    }
	
    function get_section_a() {
        $query = $this->db->query("select a.INT_ID_SECTION, a.CHR_SECTION, a.CHR_SECTION_DESC, b.CHR_DEPT, c.CHR_COST_CENTER
            from TM_SECTION a, TM_DEPT b, CPL.TM_COST_CENTER c 
            where a.INT_ID_DEPT = b.INT_ID_DEPT
			and a.INT_ID_COST_CENTER = c.INT_ID_COST_CENTER
			and a.BIT_FLG_DEL = 0
			and a.INT_ID_DEPT = 23");
        return $query->result();
    }
	
    function get_id_section($id) {
        $query = $this->db->query("select INT_ID_SECTION from TM_SECTION where INT_ID_SECTION = '" . $id . "'")->result();
		var_dump($query);die();
        $section = $query[0]->CHR_SECTION;
        return $section;
    }
	
    function get_name_section($id) {
		$query = $this->db->query("select CHR_SECTION from TM_SECTION where INT_ID_SECTION = '" . $id . "'")->result();
        $section = $query[0]->CHR_SECTION;
        return $section;
    }

    function get_desc_section($id) {
        $query = $this->db->query("select CHR_SECTION_DESC from TM_SECTION where INT_ID_SECTION = '" . $id . "'")->row_array();
        $section = $query['CHR_SECTION_DESC'];
        return $section;
    }
    
    function get_section_by_costcenter($id_costcenter) {
        $query = $this->db->query("select b.INT_ID_SECTION, b.CHR_SECTION, b.CHR_SECTION_DESC from CPL.TM_COST_CENTER a, TM_SECTION b where a.INT_ID_COST_CENTER=b.INT_ID_COST_CENTER and a.INT_ID_COST_CENTER = '" . $id_costcenter . "' and a.BIT_FLG_DEL = 0 ");
        return $query->result();
    }
    
    function get_costcenter_by_section($id_section) {
        $query = $this->db->query("select a.INT_ID_COST_CENTER from CPL.TM_COST_CENTER a,TM_SECTION b where a.INT_ID_COST_CENTER = b.INT_ID_COST_CENTER and b.INT_ID_SECTION = '" . $id_section . "' and a.BIT_FLG_DEL = 0")->row_array();
        $cost_center = $query['INT_ID_COST_CENTER'];
        return $cost_center;
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_section($id) {
        $query = $this->db->query("select a.INT_ID_SECTION, a.CHR_SECTION ,a.CHR_SECTION_DESC, b.CHR_DEPT, b.CHR_DEPT_DESC, b.INT_ID_DEPT, c.CHR_COST_CENTER, c.INT_ID_COST_CENTER 
            from TM_SECTION a, TM_DEPT b, CPL.TM_COST_CENTER c
            where a.INT_ID_DEPT = b.INT_ID_DEPT and a.INT_ID_COST_CENTER = c.INT_ID_COST_CENTER and a.BIT_FLG_DEL = 0 and a.INT_ID_SECTION = '" . $id . "'");
        return $query;
    }
    
    function get_section_by_dept($id) {
        $query = $this->db->query("select INT_ID_SECTION, CHR_SECTION ,CHR_SECTION_DESC from TM_SECTION where BIT_FLG_DEL = 0 and INT_ID_DEPT = '" . $id . "'")->result();
        return $query;
    }

    function get_top_section_by_dept($id) {
        $query = $this->db->query("select TOP 1 INT_ID_SECTION, CHR_SECTION ,CHR_SECTION_DESC from TM_SECTION where BIT_FLG_DEL = 0 and INT_ID_DEPT = '" . $id . "'")->row();
        return $query;
    }
    
    
    function get_dept_by_section($id) {
        $query = $this->db->query("select INT_ID_DEPT from TM_SECTION where INT_ID_SECTION = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_DEPT'];
        return $part_of;
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_SECTION', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_SECTION', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from TM_SECTION where CHR_SECTION = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_section() {
        return $this->db->query('select max(INT_ID_SECTION) as a from TM_SECTION')->row()->a + 1;
    }
    
    function get_user_section($npk){
        return $this->db->query("select b.INT_ID_SECTION, b.CHR_SECTION, b.CHR_SECTION_DESC, c.INT_ID_DEPT, c.CHR_DEPT, c.CHR_DEPT_DESC
                                from TM_USER a, TM_SECTION b, TM_DEPT c
                                where a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=c.INT_ID_DEPT and a.CHR_NPK='$npk'")->row();
    }
    function get_section_org($sect){
        return $this->db->query("select INT_ID_SECTION, CHR_SECTION, CHR_SECTION_DESC from TM_SECTION where INT_ID_SECTION=$sect")->row();
    }
    
//==================== UPDATE 16/07/2017 ---- FOR BUDGET =====================//
    function get_section_by_dept_budget($id) {
        $query = $this->db->query("select INT_ID_SECTION, CHR_SECTION ,CHR_SECTION_DESC from TM_SECTION where BIT_FLG_DEL = 0 and INT_ID_DEPT = '" . $id . "' and CHR_FLAG_ACT_BUDGET='1'")->result();
        return $query;
    }
    
    function get_name_section_budget($id) {
	$query = $this->db->query("select CHR_SECTION from TM_SECTION where CHR_FLAG_ACT_BUDGET = '1' AND INT_ID_SECTION = '" . $id . "' AND BIT_FLG_DEL = '0'")->result();
        $section = $query[0]->CHR_SECTION;
        return $section;
    }

    function get_desc_section_budget($id) {
        $query = $this->db->query("select CHR_SECTION_DESC from TM_SECTION where CHR_FLAG_ACT_BUDGET = '1' AND INT_ID_SECTION = '" . $id . "' AND BIT_FLG_DEL = '0'")->row_array();
        $section = $query['CHR_SECTION_DESC'];
        return $section;
    }
    

}
