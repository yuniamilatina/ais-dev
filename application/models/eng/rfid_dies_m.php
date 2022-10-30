<?php

class rfid_dies_m extends CI_Model {

    private $tabel = 'ENG.TT_DIES_PART';

// Ambil Data Model
    function get_master_rfid_dies() {
        $query = $this->db->query("SELECT     
        INT_ID_PART_DIES, 
        CHR_PART_NO,
        CHR_BACK_NO, 
        CHR_PART_MODEL, 
        CHR_DIES_CODE, 
        CHR_RFID_CODE, 
        CHR_CREATED_BY, 
        CHR_CREATED_DATE, 
        CHR_CREATED_TIME, 
        CHR_MODIFIED_BY, 
        CHR_MODIFIED_DATE, 
        CHR_MODIFIED_TIME, 
        INT_FLG_DEL,

        LEFT(CHR_CREATED_TIME,2) +':'+SUBSTRING(CHR_CREATED_TIME,3,2)+':'+ RIGHT(CHR_CREATED_TIME, 2) AS CREATE_TIME,
        RIGHT(CHR_CREATED_DATE,2) +'/'+SUBSTRING(CHR_CREATED_DATE,5,2)+'/'+ LEFT(CHR_CREATED_DATE, 4) AS CREATE_DATE

        FROM ENG.TT_DIES_PART  WHERE INT_FLG_DEL ='0'");
        return $query->result();
    }

// Simpan Model
    function save_master_rfid_dies($data) {
        $this->db->insert($this->tabel, $data);
    }
// get data twist
    function get_data_rfid_dies($id) {
        $query = $this->db->query("SELECT 
        INT_ID_PART_DIES, 
        CHR_PART_NO,
        CHR_BACK_NO, 
        CHR_PART_MODEL, 
        CHR_DIES_CODE, 
        CHR_RFID_CODE, 
        CHR_CREATED_BY, 
        CHR_CREATED_DATE, 
        CHR_CREATED_TIME, 
        CHR_MODIFIED_BY, 
        CHR_MODIFIED_DATE, 
        CHR_MODIFIED_TIME, 
        INT_FLG_DEL
        FROM ENG.TT_DIES_PART WHERE INT_FLG_DEL = 0 AND CHR_PART_NO = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_data_detail_twist($id) {
        $query = $this->db->query("SELECT 
        INT_ID_PART_DIES, 
        CHR_PART_NO,
        CHR_BACK_NO, 
        CHR_PART_MODEL, 
        CHR_DIES_CODE, 
        CHR_RFID_CODE, 
        CHR_CREATED_BY, 
        CHR_CREATED_DATE, 
        CHR_CREATED_TIME, 
        CHR_MODIFIED_BY, 
        CHR_MODIFIED_DATE, 
        CHR_MODIFIED_TIME, 
        INT_FLG_DEL
        FROM ENG.TT_DIES_PART WHERE INT_FLG_DEL = 0 AND CHR_PART_NO = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function update($data, $id) {
        $this->db->where('CHR_PART_NO', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('CHR_PART_NO', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_dies_by_partno($partno){
        $query = $this->db->query("SELECT TOP 1 * FROM $this->tabel WHERE INT_FLG_DEL = 0 AND CHR_PART_NO = '$partno'");

        if ($query->num_rows() > 0) {
            return $query->row()->INT_ID_PART_DIES;
        } else {
            return 0;
        }
    }
}
