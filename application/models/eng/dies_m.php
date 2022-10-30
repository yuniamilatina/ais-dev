<?php

class dies_m extends CI_Model {

    private $tabel = 'ENG.TM_DIES';

    function get_dies() {
        $query = $this->db->query("SELECT     
        INT_ID,
        CHR_DIES_CODE, 
        CHR_DIES_NAME,
        CHR_DIES_DESC
        FROM ENG.TM_DIES  WHERE INT_FLG_DEL ='0'");
        return $query->result();
    }

    function save_dies($data) {
        $this->db->insert($this->tabel, $data);
    }

    function check_dies($code){
        $query = $this->db->query("SELECT * FROM ENG.TM_DIES WHERE INT_FLG_DEL = 0 AND CHR_DIES_CODE = '$code'");

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_data_by_id($id){
        $query = $this->db->query("SELECT TOP 1 CHR_DIES_CODE FROM ENG.TM_DIES WHERE INT_FLG_DEL = 0 AND INT_ID = $id");

        return $query->row()->CHR_DIES_CODE;
    }

    function get_data_dies() {
        $query = $this->db->query("SELECT INT_ID, CHR_DIES_CODE FROM ENG.TM_DIES WHERE INT_FLG_DEL = 0");

        return $query->result();
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

}
