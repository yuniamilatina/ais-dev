<?php

class production_result_history_m extends CI_Model {

    private $tabel = 'TT_PRODUCTION_RESULT_HISTORY';

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
