<?php

class ines_m extends CI_Model {

    private $tabel = 'TM_INLINE_SCAN';

    function get_inlinescan() {
        $query = $this->db->query("SELECT INES.CHR_PORT, INES.CHR_URL, INES.CHR_LOCATION,INES.INT_ID, CASE WHEN INES.CHR_GROUP_PRODUCT IS NULL THEN 'OTHER' ELSE CHR_GROUP_PRODUCT END AS CHR_GROUP_PRODUCT,  INES.INT_ID_ASSET, 
                INES.CHR_WORK_CENTER, INES.CHR_IP, INES.CHR_ASSET_CODE,
        --A.CHR_ASSET_NAME,
                D.CHR_DEPT, INES.CHR_USAGE
                from TM_INLINE_SCAN INES 
                --INNER JOIN TM_ASSET A ON A.INT_ID = INES.INT_ID_ASSET
                INNER JOIN TM_DEPT D ON INES.INT_ID_DEPT = D.INT_ID_DEPT
                where INES.BIT_FLG_ACTIVE = 1 
                --AND A.BIT_FLG_DEL = 1
				ORDER BY D.CHR_DEPT, INES.CHR_WORK_CENTER ");
        return $query->result();
    }

    function get_workcenter_inlinescan() {
        $query = $this->db->query("SELECT CHR_WORK_CENTER from TM_INLINE_SCAN WHERE CHR_WORK_CENTER != 'OTHER' AND BIT_FLG_ACTIVE = 1 GROUP BY CHR_WORK_CENTER")->result();
        return $query;
    }

    function get_group_product(){
        $query = $this->db->query("SELECT CHR_GROUP_PRODUCT, REPLACE(CHR_GROUP_PRODUCT,'x','') CHR_GROUP_PRODUCT_NAME from TM_INLINE_SCAN GROUP BY CHR_GROUP_PRODUCT")->result();
        return $query;
    }
    
    function get_top_workcenter_inlinescan(){
        $query = $this->db->query("SELECT TOP 1 CHR_WORK_CENTER from TM_INLINE_SCAN WHERE CHR_WORK_CENTER != 'OTHER' GROUP BY CHR_WORK_CENTER")->row_array();
        return $query;
    }
    
    function get_name_inlinescan($id) {
        $query = $this->db->query("SELECT CHR_ASSET from TM_INLINE_SCAN where INT_ID = '" . $id . "'")->row_array();
        $asset = $query['CHR_ASSET'];
        return $asset;
    }

    function save_ines($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data_inlinescan($id) {
        $query = $this->db->query("SELECT INT_ID, CHR_PORT, CHR_URL, INT_ID_ASSET, CHR_WORK_CENTER, CHR_IP, INT_ID_DEPT, CHR_USAGE, CHR_GROUP_PRODUCT, CHR_ASSET_CODE
            from TM_INLINE_SCAN where BIT_FLG_ACTIVE = 1 and INT_ID = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_data_detail_inlinescan($id) {
        $query = $this->db->query("SELECT INT_ID, CHR_PORT, CHR_URL, INT_ID_ASSET, CHR_WORK_CENTER, CHR_IP, INT_ID_DEPT, CHR_USAGE, CHR_GROUP_PRODUCT, CHR_ASSET_CODE
            from TM_INLINE_SCAN where BIT_FLG_ACTIVE = 1 and INT_ID = '" . $id . "'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }
    
    function get_available_asset(){
        return $query = $this->db->query("SELECT INT_ID, CHR_ASSET_CODE, CHR_ASSET_NAME, CHR_ASSET_DESC FROM TM_ASSET WHERE BIT_FLG_DEL = 1 AND INT_ID NOT IN (
            SELECT INT_ID_ASSET FROM TM_INLINE_SCAN GROUP BY INT_ID_ASSET
        )")->result();
    }

    function get_asset(){
        return $query = $this->db->query("SELECT INT_ID, CHR_ASSET_CODE, CHR_ASSET_NAME, CHR_ASSET_DESC FROM TM_ASSET WHERE BIT_FLG_DEL = 1")->result();
    }
    
    function delete($id) {
        $data = array('BIT_FLG_ACTIVE' => 0);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id_inlinescan($id) {
        $find_id = $this->db->query("SELECT * from TM_INLINE_SCAN where INT_ID = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function get_work_center() {
        $query = $this->db->query("SELECT CHR_WCENTER from TM_DIRECT_BACKFLUSH_GENERAL WHERE CHR_WCENTER <> 'DELV01'");
        return $query->result();
    }

    function get_work_center_device(){
        $query = $this->db->query("SELECT CHR_WCENTER FROM TM_DIRECT_BACKFLUSH_GENERAL WHERE CHR_WCENTER <> 'DELV01'
                                    UNION 
                                    SELECT 'OTHER' CHR_WCENTER");

        return $query->result();
    }

}
