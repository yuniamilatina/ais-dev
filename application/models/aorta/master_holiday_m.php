<?php

class master_holiday_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_holiday = 'TM_HOLIDAY';

    function get_holiday($year) {
        $aortadb = $this->load->database("aorta", TRUE);
        $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, STATUS_LB, CHR_TIPE_LB FROM TM_HOLIDAY WHERE TGL_LIBUR LIKE '$year%'")->result();
        return $holiday;
    }

    function save($data) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert($this->tm_holiday, $data);
    }

    function get_data_holiday($tgl) {
        $aortadb = $this->load->database("aorta", TRUE);
        $holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, STATUS_LB, CHR_TIPE_LB FROM TM_HOLIDAY WHERE TGL_LIBUR = '$tgl'");
        return $holiday;
    }

    function update($data, $tgl) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->where('TGL_LIBUR', $tgl);
        $aortadb->update($this->tm_holiday, $data);
    }

    function delete($tgl) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->query("DELETE FROM TM_HOLIDAY WHERE TGL_LIBUR = '$tgl'");
    }
    
}

?>
