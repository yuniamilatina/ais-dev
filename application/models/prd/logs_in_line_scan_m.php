<?php

class logs_in_line_scan_m extends CI_Model {

    private $tabel = 'PRD.TT_IN_LINE_SCAN_LOGS';

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

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_log_ines_by_work_center($work_center, $date) {

        $query = "SELECT * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center' AND CHR_CREATED_DATE = '$date'";

        return $this->db->query($query)->result();

    }

}
