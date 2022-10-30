<?php

class groupdept_m extends CI_Model {

    private $tabel = 'TM_GROUP_DEPT';

    function get_groupdept() {
        $query = $this->db->query("select a.INT_ID_GROUP_DEPT, a.CHR_GROUP_DEPT, a.CHR_GROUP_DEPT_DESC, b.CHR_DIVISION 
            from TM_GROUP_DEPT a, TM_DIVISION b where a.INT_ID_DIVISION = b.INT_ID_DIVISION and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_name_groupdept($id) {
        $query = $this->db->query("select CHR_GROUP_DEPT from TM_GROUP_DEPT where INT_ID_GROUP_DEPT = '" . $id . "'")->row_array();
        $groupdept = $query['CHR_GROUP_DEPT'];
        return $groupdept;
    }

    function get_desc_groupdept($id) {
        $query = $this->db->query("select CHR_GROUP_DEPT_DESC from TM_GROUP_DEPT where INT_ID_GROUP_DEPT = '" . $id . "'")->row_array();
        $groupdept = $query['CHR_GROUP_DEPT_DESC'];
        return $groupdept;
    }

    function save_groupdept($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_groupdept($id) {
        $query = $this->db->query("select INT_ID_GROUP_DEPT,SUBSTRING(CHR_GROUP_DEPT,7,3) GROUP_DEPT,  CHR_GROUP_DEPT ,CHR_GROUP_DEPT_DESC, INT_ID_DIVISION from TM_GROUP_DEPT where BIT_FLG_DEL = 0 and INT_ID_GROUP_DEPT = '" . $id . "'");
        return $query;
    }

    function get_groupdept_by_division($id) {
        $query = $this->db->query("select INT_ID_GROUP_DEPT, CHR_GROUP_DEPT ,CHR_GROUP_DEPT_DESC from TM_GROUP_DEPT where BIT_FLG_DEL = 0 and INT_ID_DIVISION = '" . $id . "'")->result();
        return $query;
    }

    function get_division_by_groupdept($id) {
        $query = $this->db->query("select INT_ID_DIVISION from TM_GROUP_DEPT where INT_ID_GROUP_DEPT = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_DIVISION'];
        return $part_of;
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_GROUP_DEPT', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_GROUP_DEPT', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id_groupdept($id) {
        $find_id = $this->db->query("select * from TM_GROUP_DEPT where CHR_GROUP_DEPT = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_groupdept() {
        return $this->db->query('select max(INT_ID_GROUP_DEPT) as a from TM_GROUP_DEPT')->row()->a + 1;
    }

    function get_gdept_from_dept($dept) {
        return $this->db->query('select INT_ID_GROUP_DEPT, CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC from TM_DEPT')->row();
    }

    function get_gdept_id($dept) {
        return $this->db->query("select a.INT_ID_GROUP_DEPT, a.INT_ID_DIVISION from TM_DEPT b, TM_GROUP_DEPT a 
                                where a.INT_ID_GROUP_DEPT=b.INT_ID_GROUP_DEPT and b.INT_ID_DEPT=$dept")->row();
    }

}
