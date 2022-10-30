<?php

class module_m extends CI_Model {

    private $tabel = 'TM_MODULE';
    
    function get_module() {
        $query = $this->db->query("SELECT * FROM TM_MODULE M INNER JOIN TM_APPLICATION A ON M.INT_ID_APP = A.INT_ID_APP WHERE INT_ID_MODULE <> 0");
        return $query->result();
    }
    
    function get_new_id_module() {
        return $this->db->query('SELECT max(INT_ID_MODULE) as a FROM TM_MODULE')->row()->a + 1;
    }
    
    function get_data_app() {
        $query = $this->db->query("SELECT INT_ID_APP, CHR_APP, CHR_ICON FROM TM_APPLICATION");
        return $query->result();
    }
    
    function get_data_level() {
        $query = $this->db->query("SELECT INT_LEVEL, case when INT_LEVEL = 0 then 'Module' else 'Sub Module' end as A "
                . "FROM TM_MODULE WHERE INT_LEVEL IS NOT NULL group by INT_LEVEL");
        return $query->result();
    }
    
    function save_module($data) {
        $this->db->insert($this->tabel, $data);
    }
    
    function get_data_module($id) {
        $query = $this->db->query("SELECT INT_ID_MODULE, INT_ID_APP, CHR_MODULE, INT_LEVEL FROM TM_MODULE WHERE INT_ID_MODULE = '" . $id . "'");
        return $query;
    }
    
    function get_data_edit_app($id) {
        $query = $this->db->query("SELECT TM_MODULE.INT_ID_APP, TM_APPLICATION.CHR_APP FROM TM_APPLICATION "
                . "inner join TM_MODULE on TM_APPLICATION.INT_ID_APP = TM_MODULE.INT_ID_APP WHERE TM_MODULE.INT_ID_MODULE = '" . $id . "'");
       
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }
    
    function get_data_edit_level($id_level) {
        $query = $this->db->query("SELECT INT_LEVEL FROM TM_MODULE WHERE INT_ID_MODULE = '" . $id_level . "' AND INT_LEVEL IS NOT NULL group by INT_LEVEL");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }
    
    function update_module($data, $id) {
        $this->db->WHERE('INT_ID_MODULE', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_name_asset($id) {
        $query = $this->db->query("SELECT CHR_ASSET FROM TM_ASSET WHERE INT_ID = '" . $id . "'")->row_array();
        $asset = $query['CHR_ASSET'];
        return $asset;
    }

    function save_asset($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_asset($id) {
        $query = $this->db->query("SELECT INT_ID, CHR_ASSET_CODE, CHR_ASSET_NAME, CHR_ASSET_DESC
            FROM TM_ASSET WHERE BIT_FLG_DEL = 1 and INT_ID = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function delete_module($id) {
        $query = $this->db->query("delete FROM TM_MODULE WHERE INT_ID_MODULE = '". $id ."'");
        return $query;
    }
    
    function update($data, $id) {
        $this->db->WHERE('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

}
