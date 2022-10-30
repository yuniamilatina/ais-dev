<?php

class attendance_m extends CI_Model {

    private $table_attendance = 'GAF.TT_ATTENDANCE';

    function __construct() {
        parent::__construct();
    }

    function get_data_attendance() {
        return $this->db->query("SELECT * FROM $this->table_attendance WHERE INT_FLG_DEL = 1")->result();
    }

    function get_data_attendance_by_id_reserv($id) {
        return $query = $this->db->query("SELECT * FROM $this->table_attendance where CHR_ID_RESERV = '$id'")->result();
    }

    function save($data) {
        $this->db->insert($this->table_attendance, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 0);
        $this->db->where('INT_ID', $id);
        $this->db->update($this->table_attendance, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->table_attendance, $data);
    }

}
