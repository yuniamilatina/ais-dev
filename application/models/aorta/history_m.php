<?php

class history_m extends CI_Model {

    private $tabel = 'TT_HISTORY';
    private $history_balancing = 'TT_LOG_HISTORY_BALANCING';

    function save($data) {
        $aortadb = $this->load->database("aorta", TRUE);
        
        $aortadb->insert($this->tabel, $data);
    }

    function save_history_balancing($data) {
        $aortadb = $this->load->database("aorta", TRUE);
        
        $aortadb->insert($this->history_balancing, $data);
    }

    function get_data_log_balancing($dept, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        return $aortadb->query("SELECT K.KD_SECTION, * FROM TT_LOG_HISTORY_BALANCING L INNER JOIN TM_KRY K ON K.NPK COLLATE Latin1_General_CI_AS = L.CHR_NPK COLLATE Latin1_General_CI_AS
        WHERE CHR_DEPT = '$dept' AND CHR_PERIOD = '$period' ORDER BY CHR_CREATED_DATE, CHR_CREATED_TIME")->result();
    }


}
