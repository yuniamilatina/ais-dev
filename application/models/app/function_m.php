<?php

class function_m extends CI_Model {

    private $tabel = 'TM_FUNCTION';
    
    function get_function() {
        $query = $this->db->query("select * from TM_FUNCTION WHERE INT_ID_FUNCTION <> 0");
        return $query->result();
    }
    
    function get_new_id_function() {
        return $this->db->query('select max(INT_ID_FUNCTION) as a from TM_FUNCTION')->row()->a + 1;
    }
    
    function get_data_function($id_function) {
        $query = $this->db->query("select INT_ID_FUNCTION, INT_ID_MODULE, CHR_FUNCTION, CHR_URL from TM_FUNCTION where INT_ID_FUNCTION = '" . $id_function . "'");
        return $query;
    }
    
    function get_data_module() {
        $query = $this->db->query("select INT_ID_MODULE, CHR_MODULE, INT_LEVEL from TM_MODULE");
        return $query->result();
    }
    
    function get_data_edit_module($id) {
        $query = $this->db->query("select TM_FUNCTION.INT_ID_MODULE, TM_MODULE.CHR_MODULE from TM_MODULE "
                . "inner join TM_FUNCTION on TM_MODULE.INT_ID_MODULE = TM_FUNCTION.INT_ID_MODULE where TM_FUNCTION.INT_ID_FUNCTION = '" . $id . "'");
       
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }
    
    function save_function($data) {
        $this->db->insert($this->tabel, $data);
    }
    
    
    
    function update_function($data, $id) {
        $this->db->where('INT_ID_FUNCTION', $id);
        $this->db->update($this->tabel, $data);
    }

    function delete_function($id) {
        $query = $this->db->query("delete from TM_FUNCTION where INT_ID_FUNCTION = '". $id ."'");
        return $query;
    }
    
}
