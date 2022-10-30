<?php

class eids_m extends CI_Model {

    private $tabel = 't_dokumen';

    function get_eids($type) {
        $eidsdb = $this->load->database("eids", TRUE);

        return $eidsdb->query("SELECT  * FROM t_dokumen WHERE doc_type = '$type' ORDER BY id_doc")->result();
    }

    function get_eids_type() {
        $eidsdb = $this->load->database("eids", TRUE);

        return $eidsdb->query("SELECT doc_type FROM t_tipe_dok")->result();
    }

    function get_name_eids($id) {
        $query = $this->eidsdb->query("select CHR_ASSET from TM_INLINE_SCAN where id_doc = '" . $id . "'")->row_array();
        $asset = $query['CHR_ASSET'];
        return $asset;
    }

    function save_eids($data) {
        $this->eidsdb->insert($this->tabel, $data);
    }

    function get_data_eids($id) {
        $query = $this->eidsdb->query("select id_doc, id_doc_ASSET, CHR_WORK_CENTER, CHR_IP, id_doc_DEPT, CHR_USAGE
            from TM_INLINE_SCAN where BIT_FLG_ACTIVE = 1 and id_doc = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }
    
    function delete($id) {
        $data = array('BIT_FLG_ACTIVE' => 1);

        $this->eidsdb->where('id_doc', $id);
        $this->eidsdb->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->eidsdb->where('id_doc', $id);
        $this->eidsdb->update($this->tabel, $data);
    }

    function check_id_eids($id) {
        $find_id = $this->eidsdb->query("select * from t_dokumen where id_doc = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function get_work_center() {
        $query = $this->eidsdb->query("select CHR_WCENTER from TM_DIRECT_BACKFLUSH_GENERAL");
        return $query->result();
    }

}
