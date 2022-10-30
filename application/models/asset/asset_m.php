<?php

class asset_m extends CI_Model {

    private $tabel = 'TM_ASSET';

    function get_asset() {
        $query = $this->db->query("select INT_ID, CHR_ASSET_CODE, CHR_ASSET_NAME, CHR_ASSET_DESC
            from TM_ASSET where BIT_FLG_DEL = 1");
        return $query->result();
    }

    function get_name_asset($id) {
        $query = $this->db->query("select CHR_ASSET from TM_ASSET where INT_ID = '" . $id . "'")->row_array();
        $asset = $query['CHR_ASSET'];
        return $asset;
    }

    function save_asset($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_asset($id) {
        $query = $this->db->query("select INT_ID, CHR_ASSET_CODE, CHR_ASSET_NAME, CHR_ASSET_DESC
            from TM_ASSET where BIT_FLG_DEL = 1 and INT_ID = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 0);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id_asset($id) {
        $find_id = $this->db->query("select * from TM_ASSET where CHR_ASSET_CODE = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

}
