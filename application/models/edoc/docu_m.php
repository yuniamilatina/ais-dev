<?php

class docu_m extends CI_Model {

     private $tabel = 'TM_DOC';

    function get_doc() {
        $query = $this->db->query("select INT_ID_DOC, CHR_DOC_TITLE, INT_DOC_HOUR, INT_DOC_MINUTE, INT_DOC_SECOND, BIT_ACTIVE, BIT_TYPE
			from TM_DOC
			where BIT_FLG_DEL = 0
			order by BIT_TYPE desc");
        return $query->result();
    }
	
	function get_video() {
        $query = $this->db->query("select INT_ID_DOC, CHR_DOC_TITLE, CHR_FILE_LOC
			from TM_DOC
			where BIT_TYPE = 0
			and BIT_FLG_DEL = 0");
        return $query->result();
    }
	
	function get_latest_doc_by_id_pos($id) {
        $query = $this->db->query("select a.INT_ID_POS_DOC, a.INT_ID_POS, b.INT_POS_NUMBER, b.CHR_POS_TITLE, a.INT_ID_DOC, c.CHR_DOC_TITLE, a.CHR_UPLOAD_BY, a.CHR_UPLOAD_DATE, a.CHR_UPLOAD_TIME, a.CHR_FILE_LOC
			from TT_POS_DOC a, TM_POS b, TM_DOC c
			where a.INT_ID_POS = b.INT_ID_POS
			and a.INT_ID_DOC = c.INT_ID_DOC
			and a.CHR_UPLOAD_DATE + a.CHR_UPLOAD_TIME IN (
				select max( CHR_UPLOAD_DATE+CHR_UPLOAD_TIME )
				from TT_POS_DOC
				where INT_ID_POS = '" . $id . "'
				group by INT_ID_DOC
				)
			order by a.INT_ID_DOC ASC , a.CHR_UPLOAD_DATE + a.CHR_UPLOAD_TIME DESC ");
        return $query->result();
    }
	
	function get_doc_history_by_id_pos_id_doc($id_pos, $id_doc) {
        $query = $this->db->query("select a.INT_ID_POS_DOC, a.INT_ID_POS, b.INT_POS_NUMBER, b.CHR_POS_TITLE, a.INT_ID_DOC, c.CHR_DOC_TITLE, a.CHR_UPLOAD_BY, a.CHR_UPLOAD_DATE, a.CHR_UPLOAD_TIME, a.CHR_FILE_LOC
			from TT_POS_DOC a, TM_POS b, TM_DOC c
			where a.INT_ID_POS = b.INT_ID_POS
			and a.INT_ID_DOC = c.INT_ID_DOC
			and a.INT_ID_POS = '" . $id_pos . "'
			and a.INT_ID_DOC = '" . $id_doc . "'
			order by a.CHR_UPLOAD_DATE + a.CHR_UPLOAD_TIME DESC ");
        return $query->result();
    }
	
	function get_id_subsection_by_id_pos_doc($id) {
        $query = $this->db->query("select INT_ID_SUB_SECTION from TM_POS where INT_ID_POS = '" . $id . "'")->result();
        $id_subsection = $query[0]->INT_ID_SUB_SECTION;
        return $id_subsection;
    }
	
	function get_id_section_by_id_pos_doc($id) {
        $query = $this->db->query("select b.INT_ID_SECTION
			from TM_POS a, TM_SUB_SECTION b
			where a.INT_ID_SUB_SECTION = b.INT_ID_SUB_SECTION
			and a.INT_ID_POS = '" . $id . "'")->result();
        $id_section = $query[0]->INT_ID_SECTION;
        return $id_section;
    }
	
    function get_name_file($id) {
        $query = $this->db->query("select CHR_DOC_TITLE from TM_DOC where INT_ID_DOC = '" . $id . "'")->result();
        $name = $query[0]->CHR_DOC_TITLE;
        return $name;
    }
	
	function get_location_file($id) {
        $query = $this->db->query("select CHR_FILE_LOC from TM_DOC where INT_ID_DOC = '" . $id . "'")->result();
        $location = $query[0]->CHR_FILE_LOC;
        return $location;
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }
	
	function update($data, $id) {
        $this->db->where('INT_ID_DOC', $id);
        $this->db->update($this->tabel, $data);
    }
	
	function update_false($data) {
        $this->db->update($this->tabel, $data);
    }

    function get_data_category($id) {
        $query = $this->db->query("select INT_ID_DOC, CHR_DOC_TITLE, INT_DOC_HOUR, INT_DOC_MINUTE, INT_DOC_SECOND
            from TM_DOC
            where BIT_FLG_DEL = 0
			and INT_ID_DOC = '" . $id . "'");
        return $query;
    }
    
    function get_pos_by_subsection($id) {
        $query = $this->db->query("select INT_ID_POS, INT_POS_NUMBER, CHR_POS_TITLE from TM_POS where BIT_FLG_DEL = 0 and INT_ID_SUB_SECTION = '" . $id . "'")->result();
        return $query;
    }

    function generate_id_docu() {
        return $this->db->query('select max(INT_ID_DOC) as a from TM_DOC')->row()->a + 1;
    }
	
	function getDuration($file){
		if (file_exists($file)){
			 ## open and read video file
			$handle = fopen($file, "r");
			## read video file size
			$contents = fread($handle, filesize($file));
			fclose($handle);
			$make_hexa = hexdec(bin2hex(substr($contents,strlen($contents)-3)));
			$timehours = 0; $timeminutes = 0; $timeseconds = 0;
			if (strlen($contents) > $make_hexa){
				$pre_duration = hexdec(bin2hex(substr($contents,strlen($contents)-$make_hexa,3))) ;
				$post_duration = $pre_duration/1000;
				$timehours = $post_duration/3600;
				$timeminutes =($post_duration % 3600)/60;
				$timeseconds = ($post_duration % 3600) % 60;
				$timehours = explode(".", $timehours);
				$timeminutes = explode(".", $timeminutes);
				$timeseconds = explode(".", $timeseconds);
				$duration = $timehours[0]. ":" . $timeminutes[0]. ":" . $timeseconds[0];
			}
			return $timeminutes[0];
		}
		else {
			return false;
		}
    }

}
