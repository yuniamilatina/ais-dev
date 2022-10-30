<?php

class pos_coordinate_m extends CI_Model {

    private $tabel = 'PRD.TM_POS_COORDINATE';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id) {
        $this->db->where('INT_ID', $id);
        $this->db->delete($this->tabel);
    }

    function check_exist_coordinate_by_id($id){
        $query = $this->db->get_where($this->tabel,  array('INT_ID_POS' => $id));
        if($query->num_rows() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    function get_coordinate_dandori_board($id) {
        $sql = "SELECT * FROM $this->tabel WHERE INT_ID_POS = '$id'";

        return $this->db->query($sql)->result();
    }

}
