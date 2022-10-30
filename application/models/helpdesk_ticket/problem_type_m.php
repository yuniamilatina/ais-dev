<?php

class problem_type_m extends CI_Model {

    private $tabel = 'MIS.TM_HELPDESK_PROBLEM_TYPE';

    function get_problem_type() {
        $query = $this->db->query("select INT_ID_PROBLEM_TYPE,CHR_PROBLEM_TYPE,CHR_PROBLEM_TYPE_DESC from MIS.TM_HELPDESK_PROBLEM_TYPE where BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_name_problem_type($id_problem_type) {
        $query = $this->db->query("select CHR_PROBLEM_TYPE from MIS.TM_HELPDESK_PROBLEM_TYPE where INT_ID_PROBLEM_TYPE = '" . $id_problem_type . "'")->row_array();
        $helpdesk_ticket = $query['CHR_PROBLEM_TYPE'];
        return $helpdesk_ticket;
    }

    function get_desc_problem_type($id_problem_type) {
        $query = $this->db->query("select CHR_PROBLEM_TYPE_DESC from MIS.TM_HELPDESK_PROBLEM_TYPE where INT_ID_PROBLEM_TYPE = '" . $id_problem_type . "'")->row_array();
        $helpdesk_ticket = $query['CHR_PROBLEM_TYPE_DESC'];
        return $helpdesk_ticket;
    }

    function save_problem_type($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_problem_type($id_problem_type) {
        $query = $this->db->query("select INT_ID_PROBLEM_TYPE, CHR_PROBLEM_TYPE,CHR_PROBLEM_TYPE_DESC from MIS.TM_HELPDESK_PROBLEM_TYPE where BIT_FLG_DEL = 0 and INT_ID_PROBLEM_TYPE = '" . $id_problem_type . "'");
        return $query;
    }

    function delete_problem_type($id_problem_type) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_PROBLEM_TYPE', $id_problem_type);
        $this->db->update($this->tabel, $data);
    }

    function update_problem_type($data, $id_problem_type) {
        $this->db->where('INT_ID_PROBLEM_TYPE', $id_problem_type);
        $this->db->update($this->tabel, $data);
    }

    function check_id_problem_type($id_problem_type) {
        $find_id = $this->db->query("select CHR_PROBLEM_TYPE from MIS.TM_HELPDESK_PROBLEM_TYPE where CHR_PROBLEM_TYPE = '" . $id_problem_type . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_problem_type() {
        return $this->db->query('select max(INT_ID_PROBLEM_TYPE) as a from MIS.TM_HELPDESK_PROBLEM_TYPE')->row()->a + 1;
    }

}
