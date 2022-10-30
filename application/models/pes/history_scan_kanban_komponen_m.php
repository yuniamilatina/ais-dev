<?php

class history_scan_kanban_komponen_m extends CI_Model {

    private $tabel = 'PRD.TT_HISTORY_SCAN_KANBAN_KOMPONEN';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

}
