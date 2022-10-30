<?php

class ng_m extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
    }
  
    function get_all_ng() {
        $query = $this->db->query("SELECT CHR_NG_CATEGORY_CODE, CHR_NG_CATEGORY, CHR_FLAG_DELETE FROM TM_NG order by CHR_NG_CATEGORY asc");

        return $query->result();
    }

}
    