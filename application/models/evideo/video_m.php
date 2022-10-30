<?php

class video_m extends CI_Model {

     private $tabel = 'TM_VIDEO';

    function get_video() {
        $query = $this->db->query("select INT_ID_VIDEO, CHR_VIDEO_DESC, CHR_FILE_LOC
			from TM_VIDEO
			where BIT_FLG_DEL = 0");
        return $query->result();
    }
	
	function get_desc_video($id) {
        $query = $this->db->query("select CHR_VIDEO_DESC
			from TM_VIDEO
			where BIT_FLG_DEL = 0 and INT_ID_VIDEO = '" . $id . "'")->result();
        $desc = $query[0]->CHR_VIDEO_DESC;
        return $desc;
    }
	
	function get_location_video($id) {
        $query = $this->db->query("select CHR_FILE_LOC
			from TM_VIDEO
			where BIT_FLG_DEL = 0 and INT_ID_VIDEO = '" . $id . "'")->result();
        $location = $query[0]->CHR_FILE_LOC;
        return $location;
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_SECTION', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_SECTION', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from TM_VIDEO where CHR_VIDEO_DESC = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_video() {
        return $this->db->query('select max(INT_ID_VIDEO) as a from TM_VIDEO')->row()->a + 1;
    }
    
    function get_user_section($npk){
        return $this->db->query("select b.INT_ID_SECTION, b.CHR_SECTION, b.CHR_SECTION_DESC, c.INT_ID_DEPT, c.CHR_DEPT, c.CHR_DEPT_DESC
                                from TM_USER a, TM_SECTION b, TM_DEPT c
                                where a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=c.INT_ID_DEPT and a.CHR_NPK='$npk'")->row();
    }
    function get_section_org($sect){
        return $this->db->query("select INT_ID_SECTION, CHR_SECTION, CHR_SECTION_DESC from TM_SECTION where INT_ID_SECTION=$sect")->row();
    }
    

}
