<?php
	class master_list_obsolete_m extends CI_Model
	{
		
		//private $tabel = 'MSU.TM_MASTER_LiST_OBSOLETE';

	    function get_master_list_obsolete() {
	        $query = $this->db->query("SELECT DE.CHR_DEPT, D.CHR_NO_DOC, D.CHR_DOCUMENT_NAME, D.CHR_DOCUMENT_DESC, C.CHR_CATEGORY_NAME, D.INT_REVISION, D.CHR_DOC FROM MSU.TT_OBSOLETE_DOC O JOIN MSU.TM_DOCUMENT D ON O.INT_ID_DOCUMENT = D.INT_ID_DOCUMENT JOIN TM_DEPT DE ON O.INT_ID_DEPT = DE.INT_ID_DEPT JOIN MSU.TM_CATEGORY_DOC C ON D.INT_ID_CATEGORY = C.INT_ID_CATEGORY WHERE O.INT_APPROVED_MSU = 1");
	        return $query->result();
	    }

	    // function get_name_asset($id) {
	    //     $query = $this->db->query("select CHR_ASSET from TM_ASSET where INT_ID = '" . $id . "'")->row_array();
	    //     $asset = $query['CHR_ASSET'];
	    //     return $asset;
	    // }

	    // function save_master_list_obsolete($data) {
	    //     $this->db->insert($this->tabel, $data);
	    // }

	    // function get_data_master_list_obsolete($id) {
	    //     $query = $this->db->query("SELECT * FROM MSU.TM_MASTER_LiST_OBSOLETE WHERE INT_ID_CATEGORY = '" . $id . "' AND INT_STATUS != '0'");

	    //     if ($query->num_rows() > 0) {
	    //         return $query;
	    //     } else {
	    //         return 0;
	    //     }
	    // }

	    // function delete($id) {
	    //     $data = array('INT_STATUS' => 0);

	    //     $this->db->where('INT_ID_CATEGORY', $id);
	    //     $this->db->update($this->tabel, $data);
	    // }

	    // function update($data, $id) {
	    //     $this->db->where('INT_ID_CATEGORY', $id);
	    //     $this->db->update($this->tabel, $data);
	    // }

	}
?>