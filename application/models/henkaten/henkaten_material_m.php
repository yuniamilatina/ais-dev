<?php

class henkaten_material_m extends CI_Model {

    private $tabel = 'PRD.TM_HENKATEN_MATERIAL';

    function get_henkaten_material() {
        $stored_procedure = "SELECT * FROM $this->tabel WHERE INT_FLG_DEL = 0";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    function get_quality_problem_perday() {
        $stored_procedure = "EXEC QUA.zsp_get_all_quality_problem_perday";

        $query = $this->db->query($stored_procedure);
        return $query->result();
    }
    
    function get_problem_count(){
        $stored_procedure = "EXEC QUA.zsp_get_all_quality_problem";

        $query = $this->db->query($stored_procedure);
        return $query->num_rows();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_quality_problem_by_id($id) {
        $stored_procedure = "EXEC QUA.zsp_get_quality_problem_by_id ?";
        $param = array(
            'id' => $id);

        $query = $this->db->query($stored_procedure, $param);
        return $query->row();
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function is_complete($id){
        $data = array('INT_STATUS' => 2);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function update($data, $id) {
        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

}
