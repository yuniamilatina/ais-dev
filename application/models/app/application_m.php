<?php

class application_m extends CI_Model {

    private $tabel = 'TM_APPLICATION';

    function get_application() {
        $query = $this->db->query("select * from TM_APPLICATION WHERE INT_ID_APP <> 0");
        return $query->result();
    }

    function save_application($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_application($id) {
        $query = $this->db->query("select INT_ID_APP, CHR_APP, CHR_ICON from TM_APPLICATION where INT_ID_APP = '" . $id . "'");
        return $query;
    }
    
    function delete_application($id) {
        $query = $this->db->query("delete from TM_APPLICATION where INT_ID_APP = '". $id ."'");
        return $query;
    }

    function update_application($data, $id) {
        $this->db->where('INT_ID_APP', $id);
        $this->db->update($this->tabel, $data);
    }

    function generate_id_app() {
        return $this->db->query('select max(INT_ID_APP) as a from TM_APPLICATION')->row()->a + 1;
    }

}
