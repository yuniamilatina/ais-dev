<?php

class part_label_m extends CI_Model {

    private $tabel = 'part_label';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $db_production = $this->load->database("db_production", TRUE);

        $db_production->insert($this->tabel, $data);
    }

    function update($data, $part_no) {
        $db_production = $this->load->database("db_production", TRUE);

        $db_production->where('part_no', $part_no);
        $db_production->update($this->tabel, $data);
    }

    function check_existing_part_label($part_no){
        $db_production = $this->load->database("db_production", TRUE);

        $query = $db_production->query("SELECT * FROM $this->tabel WHERE part_no = '$part_no'");

        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function get_data_part_label_by_work_center($work_center){
        $db_production = $this->load->database("db_production", TRUE);

        $query = $db_production->query("SELECT * FROM $this->tabel WHERE sloc = '$work_center'");

        return $query->result();
    }

}
