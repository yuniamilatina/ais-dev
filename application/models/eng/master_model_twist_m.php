<?php

class master_model_twist_m extends CI_Model {

    private $tabel = 'PRD.TM_MASTER_MODEL';

// Ambil Data Model
    function get_master_twist() {
        $query = $this->db->query("SELECT 
        INT_ID,
        CHR_CREATED_BY,
        CHR_CREATED_DATE,
        CHR_CREATED_TIME,
        CHR_WORK_CENTER,
        CHR_PART_NO,
        CHR_MODEL,
        CHR_MARKING,
        CHR_MODEL_DESCRIPTION,
        BIT_FLG_DEL,
        
        LEFT(CHR_CREATED_TIME,2) +':'+SUBSTRING(CHR_CREATED_TIME,3,2)+':'+ RIGHT(CHR_CREATED_TIME, 2) AS CREATE_TIME,
        RIGHT(CHR_CREATED_DATE,2) +'/'+SUBSTRING(CHR_CREATED_DATE,5,2)+'/'+ LEFT(CHR_CREATED_DATE, 4) AS CREATE_DATE
        FROM PRD.TM_MASTER_MODEL  WHERE BIT_FLG_DEL ='0'");
        return $query->result();
    }

// Simpan Model
    function save_master_model_twist($data) {
        $this->db->insert($this->tabel, $data);
    }
// get data twist
    function get_data_twist($id) {
        $query = $this->db->query("SELECT 
        INT_ID, CHR_CREATED_BY, 
        CHR_CREATED_DATE, 
        CHR_CREATED_TIME,
        CHR_WORK_CENTER,
        CHR_PART_NO, 
        CHR_MODEL, 
        CHR_MARKING, 
        CHR_MODEL_DESCRIPTION, 
        BIT_FLG_DEL
        FROM PRD.TM_MASTER_MODEL WHERE BIT_FLG_DEL = 0 AND INT_ID = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_data_detail_twist($id) {
        $query = $this->db->query("SELECT 
        INT_ID, 
        CHR_CREATE_BY, 
        CHR_CREATED_DATE, 
        CHR_CREATED_TIME,
        CHR_WORK_CENTER,
        CHR_PART_NO, 
        CHR_MODEL, 
        CHR_MARKING, 
        CHR_MODEL_DESCRIPTION, 
        BIT_FLG_DEL
        FROM PRD.TM_MASTER_MODEL WHERE BIT_FLG_DEL = 0 AND INT_ID = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }
}
