<?php

class costcenter_m extends CI_Model {

    private $tabel = 'CPL.TM_COST_CENTER';

    function get_costcenter() {
        $hasil = $this->db->query("select * from CPL.TM_COST_CENTER where BIT_FLG_DEL = 0");
        return $hasil->result();
    }
    
    function get_costcenter_by_section($id) {
        $hasil = $this->db->query("select INT_ID_COST_CENTER, CHR_COST_CENTER, CHR_COST_CENTER_DESC from CPL.TM_COST_CENTER where INT_ID_COST_CENTER IN (SELECT INT_ID_COST_CENTER FROM TM_SECTION WHERE INT_ID_SECTION = '$id')");
        return $hasil->result();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }
    
    function get_data($id) {
        $hasil = $this->db->query("select INT_ID_COST_CENTER, CHR_COST_CENTER, CHR_COST_CENTER_DESC "
                . "from CPL.TM_COST_CENTER where BIT_FLG_DEL = 0 and INT_ID_COST_CENTER = '" . $id . "'");
        return $hasil;
    }
    
   
    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_COST_CENTER', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_COST_CENTER', $id);
        $this->db->update($this->tabel, $data);
    }
    
    function check_id($id) {
        $find_id = $this->db->query("select * from CPL.TM_COST_CENTER where INT_ID_COST_CENTER = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
    
    function generate_id_cc() {
        $query1 = $this->db->query("select count(INT_ID_COST_CENTER) as 'id' from CPL.TM_COST_CENTER ")->row_array();
        $query2 = $this->db->query("select top 1 INT_ID_COST_CENTER as 'id' from CPL.TM_COST_CENTER order by INT_ID_COST_CENTER desc")->row_array();
        
        $count = $query1['id'];
        $id = $query2['id'];
        intval($query1);

        if ($count < 1) {
            $id_akhir = 100;
        } else if($count > 1 || $count < 899){
            $id_akhir = $id + 1;
        } else {
            echo 'Id has expired please inform to administrator';
            exit();
        }

        return $id_akhir;
    }

}
