<?php

class welcome_board_m extends CI_Model {

    private $tabel = 'TT_CONTROL_WB';

    function __construct() {
        parent::__construct();
    }

    function update_stat($param) {
        if ($param == NULL) {
            $data = array('CHR_STAT' => 0);

            $this->db->update($this->tabel, $data);
        } else {
            $data = array('CHR_STAT' => $param);

            $this->db->update($this->tabel, $data);
        }
    }

}
?>

