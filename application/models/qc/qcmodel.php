<?php

class qcmodel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function search($delivery){
        $this->db->like('CHR_DEL_NO', $delivery, 'both');

        return $this->db->get('TT_DELIVERY')->result();
    }

}
    