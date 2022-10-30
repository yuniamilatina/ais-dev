<?php

class goods_movement_h_m extends CI_Model {

    private $tabel = 'TT_GOODS_MOVEMENT_H';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
        return $this->db->insert_id();
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    
    
}
