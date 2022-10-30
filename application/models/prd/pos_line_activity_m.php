<?php

class pos_line_activity_m extends CI_Model {

    private $tabel = 'PRD.TT_POS_LINE_ACTIVITY';

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

    function start_activity($wc, $pos, $npk) {

        $date = date('Ymd');
        $time = date('His');

        $stored_procedure = "EXEC PRD.zsp_merge_start_activity_pos_scan_material ?, ?, ?, ?, ?";

        $param = array(
            'work_center' => $wc,
            'pos' => $pos,
            'npk' => $npk,
            'date' => $date,
            'time' => $time
        );

        return $this->db->query($stored_procedure, $param);

    }

    
    
}
