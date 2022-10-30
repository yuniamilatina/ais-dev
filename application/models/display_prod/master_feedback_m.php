<?php

class master_feedback_m extends CI_Model {

    private $tabel = "PRD.TM_FEEDBACK_DISPLAY";

    public function __construct() {
        parent::__construct();
    }
    
    function get_data_feedback() {
        return $query = $this->db->query("select * from $this->tabel WHERE INT_FLG_DEL = 0 ")->result();
    }
    
    function save($data) {
        $this->db->insert($this->tabel, $data);
    }
    
    function delete($id) {
        $data = array('INT_FLG_DEL' => 0);
    
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function get_data_feedback_by_id($id) {
        $query = $this->db->query("select * from $this->tabel WHERE INT_ID = $id");
        return $query;
    }
    
}