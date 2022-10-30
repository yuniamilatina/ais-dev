<?php

class machine_m extends CI_Model {

    public $table = 'ENG.TM_MACHINE';

    public function get_data_machine_by_work_center($work_center) {
        $query = $this->db->query("SELECT TOP 1 * from $this->table where INT_FLG_DEL = 0 and CHR_WORK_CENTER =  '$work_center'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }

}

?>
