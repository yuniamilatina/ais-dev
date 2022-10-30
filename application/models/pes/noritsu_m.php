<?php

//20180416 bugsmaker
class noritsu_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $tabel = 'PRD.TT_NORITSU';

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

}
