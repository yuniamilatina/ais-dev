<?php
	/**
	* 
	*/
	class mold_m extends CI_Model
	{
		
		private $tabel = 'dbo.TM_MOLD';

	    function get_mold() {
	        $query = $this->db->query("SELECT * from dbo.TM_MOLD");
	        return $query->result();
	    }

	    function get_mold_detail($id) {
	        $query = $this->db->query("SELECT * from dbo.TM_MOLD INNER JOIN dbo.TM_MOLD_DETAIL ON dbo.TM_MOLD.CHR_CODE_MOLD = dbo.TM_MOLD_DETAIL.CHR_CODE_MOLD WHERE dbo.TM_MOLD.CHR_CODE_MOLD = '".$id."' AND dbo.TM_MOLD.INT_FLAG_DELETE = '1' AND dbo.TM_MOLD_DETAIL.INT_FLAG_DELETE = '1'");
	        return $query->result();
	    }

	    function check_code($id) {
	        $query = $this->db->query("select CHR_CODE_MOLD from TM_MOLD where CHR_CODE_MOLD = '" . $id . "'")->row_array();
	        $code = $query['CHR_CODE_MOLD'];
	        return $code;
	    }

	    function check_name($id) {
	        $query = $this->db->query("select CHR_MOLD_NAME from TM_MOLD where CHR_CODE_MOLD = '" . $id . "'")->row_array();
	        $code = $query['CHR_MOLD_NAME'];
	        return $code;
	    }

	    function check_part($id, $part, $wc) {
	        $query = $this->db->query("select CHR_PART_NO from TM_MOLD_DETAIL where CHR_CODE_MOLD = '" . $id . "' AND CHR_PART_NO = '$part' AND INT_FLAG_DELETE = 0 AND CHR_WORK_CENTER = '".$wc."'")->row_array();
	        $code = $query['CHR_PART_NO'];
	        return $code;
	    }

	    function save_mold($data) {
	        $this->db->insert($this->tabel, $data);
	    }

	    function save_mold_detail($data1) {
	        $this->db->insert('dbo.TM_MOLD_DETAIL', $data1);
	    }

	    function get_data_mold($id) {
	        $query = $this->db->query("SELECT * FROM dbo.TM_MOLD WHERE CHR_CODE_MOLD = '" . $id . "' AND INT_FLAG_DELETE = '1'");

	        if ($query->num_rows() > 0) {
	            return $query;
	        } else {
	            return 0;
	        }
	    }

	    // function get_data_part(){

	    // }
	    
	    function get_part(){
	    	$query = $this->db->query("SELECT TOP (200) TM_PROCESS_PARTS.CHR_PLANT, TM_PROCESS_PARTS.CHR_WORK_CENTER AS WorkCenter, TM_PROCESS_PARTS.CHR_PART_NO AS PartNo, TM_PARTS.CHR_PART_NAME AS PartName, TM_PROCESS_PARTS.CHR_PV, TM_PROCESS_PARTS.CHR_SLOC_TO, TM_PROCESS_PARTS.CHR_FLAG_DELETE, TM_PROCESS_PARTS.CHR_DATE, TM_PROCESS_PARTS.CHR_PERSON_RESPONSIBLE, TM_PROCESS_PARTS.CHR_AREA, TM_PROCESS_PARTS.CHR_TYPE, TM_KANBAN.CHR_BACK_NO AS BackNo FROM TM_PROCESS_PARTS INNER JOIN  TM_KANBAN ON TM_PROCESS_PARTS.CHR_PART_NO = TM_KANBAN.CHR_PART_NO INNER JOIN TM_PARTS ON TM_PROCESS_PARTS.CHR_PART_NO = TM_PARTS.CHR_PART_NO WHERE (TM_PROCESS_PARTS.CHR_WORK_CENTER LIKE '%PC%') AND (TM_KANBAN.CHR_KANBAN_TYPE = '1') ORDER BY TM_PROCESS_PARTS.CHR_PART_NO ASC");
	    	return $query->result();
	    }

	    function get_part_update($id){
	    	$query = $this->db->query("SELECT TOP (200) TM_PROCESS_PARTS.CHR_PLANT, TM_PROCESS_PARTS.CHR_WORK_CENTER AS WorkCenter, TM_PROCESS_PARTS.CHR_PART_NO AS PartNo, TM_PARTS.CHR_PART_NAME AS PartName, TM_PROCESS_PARTS.CHR_PV, TM_PROCESS_PARTS.CHR_SLOC_TO, TM_PROCESS_PARTS.CHR_FLAG_DELETE, TM_PROCESS_PARTS.CHR_DATE, TM_PROCESS_PARTS.CHR_PERSON_RESPONSIBLE, TM_PROCESS_PARTS.CHR_AREA, TM_PROCESS_PARTS.CHR_TYPE, TM_KANBAN.CHR_BACK_NO AS BackNo FROM TM_PROCESS_PARTS INNER JOIN  TM_KANBAN ON TM_PROCESS_PARTS.CHR_PART_NO = TM_KANBAN.CHR_PART_NO INNER JOIN TM_PARTS ON TM_PROCESS_PARTS.CHR_PART_NO = TM_PARTS.CHR_PART_NO WHERE (TM_PROCESS_PARTS.CHR_WORK_CENTER LIKE '%PC%') AND (TM_KANBAN.CHR_KANBAN_TYPE = '1') AND NOT EXISTS(SELECT CHR_WORK_CENTER, CHR_PART_NO FROM TM_MOLD_DETAIL WHERE TM_MOLD_DETAIL.CHR_WORK_CENTER = TM_PROCESS_PARTS.CHR_WORK_CENTER AND TM_MOLD_DETAIL.CHR_PART_NO = TM_PROCESS_PARTS.CHR_PART_NO AND TM_MOLD_DETAIL.INT_FLAG_DELETE = 1) ORDER BY TM_PROCESS_PARTS.CHR_PART_NO ASC");
	    	return $query->result();
	    }

	    function delete($id, $flag) {
	        $data = array('INT_FLAG_DELETE' => $flag);

	        $this->db->where('CHR_CODE_MOLD', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function delete_mold_detail($id, $partno, $wc) {
	        $data = array('CHR_CODE_MOLD' => $id, 'RTRIM(CHR_PART_NO)' => $partno, 'CHR_WORK_CENTER' => $wc);
	        $this->db->delete('TM_MOLD_DETAIL', $data);
	    }

	    function update($data, $id) {
	        $this->db->where('CHR_CODE_MOLD', $id);
	        $this->db->update($this->tabel, $data);
	    }

	    function update_part($data, $id, $part, $wc) {
	        $this->db->where('CHR_CODE_MOLD', $id);
	        $this->db->where('CHR_PART_NO', $part);
	        $this->db->where('CHR_WORK_CENTER', $wc);
	        $this->db->update('TM_MOLD_DETAIL', $data);
	    }

	}
?>