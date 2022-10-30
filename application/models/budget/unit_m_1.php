<?php

class unit_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_unit = 'CPL.TM_SATUAN';

    function get_unit() {
        return $this->db->query("select * from CPL.TM_SATUAN where BIT_FLG_DEL  = 0 and INT_ID_SATUAN != 0")->result();
    }

    function save($data) {
        $this->db->insert($this->tm_unit, $data);
    }

    function get_data_unit($id) {
        $this->db->where('INT_ID_SATUAN', $id);
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_unit);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_SATUAN', $id);
        $this->db->update($this->tm_unit, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'BIT_FLG_DEL' => 1,
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));
        $this->db->where('INT_ID_SATUAN', $id);
        $this->db->update($this->tm_unit, $data);
    }

    function get_new_id_unit() {
        return $this->db->query('select max(INT_ID_SATUAN) as a from CPL.TM_SATUAN')->row()->a + 1;
    }
    
    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_SATUAN where CHR_SATUAN = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

}

?>
