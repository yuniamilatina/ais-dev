<?php

class donation_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_donation = 'CPL.TM_DONATION';

    function get_donation() {
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_donation)->result();
    }

    function save($data) {
        $this->db->insert($this->tm_donation, $data);
    }

    function get_data_donation($id) {
        $this->db->where('INT_ID_DONATION', $id);
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_donation);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_DONATION', $id);
        $this->db->update($this->tm_donation, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'BIT_FLG_DEL' => '1', 
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));
        $this->db->where('INT_ID_DONATION', $id);
        $this->db->update($this->tm_donation, $data);
    }

    function get_new_id_donation() {
        return $this->db->query('select max(INT_ID_DONATION) as a from CPL.TM_DONATION')->row()->a + 1;
    }

}

?>
