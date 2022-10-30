<?php

class master_employee_m extends CI_Model {

    private $table = 'TM_KRY';

    function get_employee($dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE FROM TM_KRY WHERE KD_DEPT = '$dept'");
        return $query->result();
    }
    
    function get_employee_by_npk($npk) {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE FROM TM_KRY WHERE NPK = '$npk' AND FLAG_DELETE <> '1'");
        return $query->row();
    }

    function save($data) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert($this->table, $data);
    }
    
    function update($data, $npk) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->where('NPK', $npk);
        $aortadb->update($this->table, $data);
    }

    function delete($npk) {
        $aortadb = $this->load->database("aorta", TRUE);
        $data = array('FLAG_DELETE' => '1');
        $aortadb->where('NPK', $npk);
        $aortadb->update($this->table, $data);
    }
    
    function enable($npk) {
        $aortadb = $this->load->database("aorta", TRUE);
        $data = array('FLAG_DELETE' => '0');
        $aortadb->where('NPK', $npk);
        $aortadb->update($this->table, $data);
    }

}

?>
