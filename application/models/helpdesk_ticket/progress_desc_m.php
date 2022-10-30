<?php

class progress_desc_m extends CI_Model {

    private $tabel = 'MIS.TT_HELPDESK_PROGRESS_DESC';

    function get_progress_desc() {
        $query = $this->db->query("select INT_ID_PROGRESS,CHR_PROGRESS_DATE,CHR_PROGRESS_DESC from MIS.TT_HELPDESK_PROGRESS_DESC");
        return $query->result();
    }

    function get_data_progress_desc_by_ticket($id) {
        $query = $this->db->query("select a.INT_ID_PROGRESS, a.INT_FLG_DONE, a.INT_ID_TICKET, a.INT_ID_PROGRESS, a.CHR_PROGRESS_DATE,a.CHR_PROGRESS_DESC, p.CHR_PROVER_DESC
                FROM MIS.TT_HELPDESK_PROGRESS_DESC a 
                INNER JOIN MIS.TM_HELPDESK_PROVER p ON a.INT_ID_PROVER = p.INT_ID_PROVER
                WHERE a.INT_ID_TICKET = '$id' ORDER BY a.INT_ID_PROGRESS DESC");
        return $query->result();
    }

     function get_count_progress_desc_by_ticket($id) {
        $query = $this->db->query("select a.INT_ID_PROGRESS, a.INT_FLG_DONE, a.INT_ID_TICKET, a.INT_ID_PROGRESS, a.CHR_PROGRESS_DATE,a.CHR_PROGRESS_DESC, p.CHR_PROVER_DESC
                FROM MIS.TT_HELPDESK_PROGRESS_DESC a 
                INNER JOIN MIS.TM_HELPDESK_PROVER p ON a.INT_ID_PROVER = p.INT_ID_PROVER
                WHERE a.INT_ID_TICKET = '$id' ORDER BY a.INT_ID_PROGRESS ASC");
        return $query->num_rows();
    }

    function save_progress_desc($data) {
        $this->db->insert($this->tabel, $data);
    }

    function close_ticket($id) {
        $data = array(
            'INT_FLG_DONE' => 1
        );
        $this->db->where('INT_ID_PROGRESS', $id);
        $this->db->update($this->tabel, $data);
    }

    function not_close_ticket($id) {
        $data = array(
            'INT_FLG_DONE' => 0
        );
        $this->db->where('INT_ID_PROGRESS', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete_progress_desc($id) {
        $this->db->where('INT_ID_PROGRESS', $id);
        $this->db->delete($this->tabel);
    }

    function update_progress_desc($data, $id) {
        $this->db->where('INT_ID_PROGRESS', $id);
        $this->db->update($this->tabel, $data);
    }

    function generate_id_progress_desc() {
        return $this->db->query('select max(INT_ID_PROGRESS) as a from MIS.TT_HELPDESK_PROGRESS_DESC')->row()->a + 1;
    }

}
