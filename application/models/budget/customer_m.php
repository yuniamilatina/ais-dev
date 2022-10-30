<?php

class customer_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_customer = 'CPL.TM_CUSTOMER';

    function get_customer() {
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_customer)->result();
    }

    function save($data) {
        $this->db->insert($this->tm_customer, $data);
    }

    function get_data_customer($id) {
        $this->db->where('INT_ID_CUSTOMER', $id);
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_customer);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_CUSTOMER', $id);
        $this->db->update($this->tm_customer, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'BIT_FLG_DEL' => '1', 
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));
        $this->db->where('INT_ID_CUSTOMER', $id);
        $this->db->update($this->tm_customer, $data);
    }

    function get_new_id_customer() {
        return $this->db->query('select max(INT_ID_CUSTOMER) as a from CPL.TM_CUSTOMER')->row()->a + 1;
    }

}

?>
