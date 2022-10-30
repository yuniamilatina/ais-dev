<?php

class company_m extends CI_Model {

    private $tabel = 'TM_COMPANY';

    function get_company() {
        $query = $this->db->query("select * from TM_COMPANY where BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_name_company($id) {
        $query = $this->db->query("select CHR_COMPANY from TM_COMPANY where INT_ID_COMPANY = '" . $id . "'")->row_array();
        $company = $query['CHR_COMPANY'];
        return $company;
    }

    function get_desc_company($id) {
        $query = $this->db->query("select CHR_COMPANY_DESC from TM_COMPANY where INT_ID_COMPANY = '" . $id . "'")->row_array();
        $company = $query['CHR_COMPANY_DESC'];
        return $company;
    }

    function save_company($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_company($id) {
        $query = $this->db->query("select INT_ID_COMPANY, CHR_COMPANY ,CHR_COMPANY_DESC from TM_COMPANY where BIT_FLG_DEL = 0 and INT_ID_COMPANY = '" . $id . "'");
        return $query;
    }

    function delete_company($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_COMPANY', $id);
        $this->db->update($this->tabel, $data);
    }

    function update_company($data, $id) {
        $this->db->where('INT_ID_COMPANY', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id_company($id) {
        $find_id = $this->db->query("select CHR_COMPANY from TM_COMPANY where CHR_COMPANY = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_company() {
        return $this->db->query('select max(INT_ID_COMPANY) as a from TM_COMPANY')->row()->a + 1;
    }

}
