<?php

class division_m extends CI_Model {

    private $tabel = 'TM_DIVISION';

    function get_division() {
        $query = $this->db->query("select a.INT_ID_DIVISION, a.CHR_DIVISION, a.CHR_DIVISION_DESC, b.CHR_COMPANY_DESC 
            from TM_DIVISION a, TM_COMPANY b where a.INT_ID_COMPANY = b.INT_ID_COMPANY and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_name_division($id) {
        $query = $this->db->query("select CHR_DIVISION from TM_DIVISION where INT_ID_DIVISION = '" . $id . "'")->row_array();
        $division = $query['CHR_DIVISION'];
        return $division;
    }

    function get_desc_division($id) {
        $query = $this->db->query("select CHR_DIVISION_DESC from TM_DIVISION where INT_ID_DIVISION = '" . $id . "'")->row_array();
        $division = $query['CHR_DIVISION_DESC'];
        return $division;
    }

    function save_division($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_division($id) {
        $query = $this->db->query("select INT_ID_DIVISION, CHR_DIVISION ,CHR_DIVISION_DESC,INT_ID_COMPANY from TM_DIVISION where BIT_FLG_DEL = 0 and INT_ID_DIVISION = '" . $id . "'");
        return $query;
    }

    function get_data_division_by_company($id) {
        $query = $this->db->query("select INT_ID_DIVISION, CHR_DIVISION ,CHR_DIVISION_DESC from TM_DIVISION where BIT_FLG_DEL = 0 and INT_ID_COMPANY = '" . $id . "'");
        return $query;
    }
    
    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_DIVISION', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_DIVISION', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id_division($id) {
        $find_id = $this->db->query("select * from TM_DIVISION where CHR_DIVISION = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_division() {
        return $this->db->query('select max(INT_ID_DIVISION) as a from TM_DIVISION')->row()->a + 1;
    }
    
//======================== UPDATE 16/07/2017 ---- FOR BUDGET =================//
    function get_division_by_dept($id_dept) {
        $query = $this->db->query("select a.INT_ID_DIVISION, a.CHR_DIVISION ,a.CHR_DIVISION_DESC,a.INT_ID_COMPANY from TM_DIVISION as a 
                                left join TM_GROUP_DEPT as b on a.INT_ID_DIVISION = b.INT_ID_DIVISION
                                left join TM_DEPT as c on b.INT_ID_GROUP_DEPT = c.INT_ID_GROUP_DEPT
                                where a.BIT_FLG_DEL = 0 and c.INT_ID_DEPT = '$id_dept'")->row();
        return $query;
    }
    
    function get_division_for_directmaterial() {
        $query = $this->db->query("select a.INT_ID_DIVISION, a.CHR_DIVISION, a.CHR_DIVISION_DESC, b.CHR_COMPANY_DESC 
            from TM_DIVISION a, TM_COMPANY b where a.INT_ID_COMPANY = b.INT_ID_COMPANY and a.INT_ID_DIVISION = '1' and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

}
