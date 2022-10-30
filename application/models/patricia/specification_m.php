<?php
	/**
	* 
	*/
	class specification_m extends CI_Model
	{
		
		private $tabel = 'dbo.TM_SPECIFICATION';

	    function get_specification($id) {
	        $query = $this->db->query("SELECT DISTINCT a.CHR_SPEC_CODE,a.INT_INDEX,b.INT_DEVICE_ID,c.CHR_ID_PART,a.INT_SPECIFICATION_ID,b.CHR_DEVICE_DESC ,c.CHR_NAMA_PART, a.CHR_SPECIFICATION,a.DEC_STD_MAX,a.DEC_STD_MIN,a.DEC_STD , a.DEC_TOLERANSI_MAX,a.DEC_TOLERANSI_MIN, a.CHR_IMAGE FROM TM_SPECIFICATION as a  join TM_MEASUREMENT_DEVICE as b on a.INT_DEVICE_ID = b.INT_DEVICE_ID
				join TM_STO as c on a.CHR_COMPONENT_ID = c.CHR_ID_PART where a.INT_FLG_DEL = 0 and a.CHR_COMPONENT_ID =".$id." ");
	        return $query->result();
	    }
	    function get_component_spec() {
	        $query = $this->db->query("select a.CHR_ID_PART,a.CHR_NAMA_PART,a.CHR_BACK_NO
			from TM_STO as a join TM_SPECIFICATION as b on a.CHR_ID_PART=b.CHR_COMPONENT_ID where b.INT_FLG_DEL = 0
				group by a.CHR_ID_PART,a.CHR_NAMA_PART,CHR_BACK_NO");
	        return $query->result();
	    }

	    function save_specification($data) {
	        $this->db->insert($this->tabel, $data);
	    }
	    function get_component()
	    {
	    	$query = $this->db->query("SELECT DISTINCT CHR_ID_PART, CHR_NAMA_PART FROM TM_STO group by CHR_ID_PART,CHR_NAMA_PART");
       		return $query->result();
	    }
	    function get_device()
	    {
	    	$query = $this->db->query("SELECT DISTINCT INT_DEVICE_ID,CHR_DEVICE_DESC, CHR_MODEL,CHR_UNIT FROM TM_MEASUREMENT_DEVICE where INT_FLG_DEL= 0");
       		return $query->result();
	    }
	    function get_data_device($id) {
	        $query = $this->db->query("SELECT INT_DEVICE_ID, CHR_DEVICE_DESC,CHR_MODEL,CHR_UNIT  FROM ".$tabel." WHERE INT_DEVICE_ID = " . $id . "");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    function update($data, $id) {
	        $this->db->where('INT_SPECIFICATION_ID', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function get_max()
	    {
	    	 $query = $this->db->query("select max(isnull(a.CHR_SPEC_CODE,0)) as max from TM_SPECIFICATION as a")->row()->max;
	    	 return $query;
	    }
	    function get_index($id)
	    {
	    	$query = $this->db->query("SELECT INT_SPECIFICATION_ID, INT_INDEX  FROM ".$this->tabel." WHERE CHR_COMPONENT_ID = '" . $id . "' order by INT_INDEX ASC");

	        return $query->result();
	    }
	}
?>