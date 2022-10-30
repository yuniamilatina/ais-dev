<?php

class prover_m extends CI_Model {

    private $tabel = 'MIS.TM_HELPDESK_PROVER';

    function get_prover() {
        $query = $this->db->query("SELECT p.INT_ID_PROVER, p.CHR_PROVER, p.CHR_PROVER_DESC,
                u.CHR_NPK
            FROM MIS.TM_HELPDESK_PROVER p
            INNER JOIN TM_USER u ON p.CHR_NPK_PROVER = u.CHR_NPK AND u.BIT_FLG_DEL = 0
            WHERE p.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_name_prover($id) {
        $query = $this->db->query("select CHR_PROVER from MIS.TM_HELPDESK_PROVER where INT_ID_PROVER = '" . $id . "'")->row_array();
        $helpdesk_ticket = $query['CHR_PROVER'];
        return $helpdesk_ticket;
    }

    function get_desc_prover($id) {
        $query = $this->db->query("select CHR_PROVER_DESC from MIS.TM_HELPDESK_PROVER where INT_ID_PROVER = '" . $id . "'")->row_array();
        $helpdesk_ticket = $query['CHR_PROVER_DESC'];
        return $helpdesk_ticket;
    }

    function save_prover($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_prover($id) {
        $query = $this->db->query("select INT_ID_PROVER, CHR_PROVER,CHR_PROVER_DESC from MIS.TM_HELPDESK_PROVER where BIT_FLG_DEL = 0 and INT_ID_PROVER = '" . $id . "'");
        return $query;
    }

    function delete_prover($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_PROVER', $id);
        $this->db->update($this->tabel, $data);
    }

    function update_prover($data, $id) {
        $this->db->where('INT_ID_PROVER', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id_prover($id) {
        $find_id = $this->db->query("select CHR_PROVER from MIS.TM_HELPDESK_PROVER where CHR_PROVER = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    
    function get_id_prover_by_npk($npk){
        $query = $this->db->query("select INT_ID_PROVER from MIS.TM_HELPDESK_PROVER where CHR_NPK_PROVER = '$npk'")->row_array();
        $result = $query['INT_ID_PROVER'];
        return $result;
    }

    function generate_id_prover() {
        return $this->db->query('select max(INT_ID_PROVER) as a from MIS.TM_HELPDESK_PROVER')->row()->a + 1;
    }

}
