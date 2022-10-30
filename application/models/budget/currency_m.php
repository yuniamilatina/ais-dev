<?php

class currency_m extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    private $tm_currency = 'CPL.TM_CURRENCY';
    
    function get_all_currency() {
        return $this->db->query("select * from CPL.TM_CURRENCY where BIT_FLG_DEL !='1'")->result();
    }
    
    function save($data) {
        $this->db->insert($this->tm_currency, $data);
    }

    function get_data_currency($id) {
        $this->db->where('INT_ID_CURRENCY', $id);
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_currency);
    }
    
    function get_rate_currency($id) {
        return $this->db->query("select NUM_IDR_CURRENCY from CPL.TM_CURRENCY where INT_ID_CURRENCY = '$id'")->row();
    }
    
    function get_id_currency($curr) {
        return $this->db->query("select INT_ID_CURRENCY from CPL.TM_CURRENCY where CHR_CURRENCY = '$curr'")->row();
    }

    function update($data, $id) {
        $this->db->where('INT_ID_CURRENCY', $id);
        $this->db->update($this->tm_currency, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'BIT_FLG_DEL' => '1', 
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));
        $this->db->where('INT_ID_CURRENCY', $id);
        $this->db->update($this->tm_currency, $data);
    }

    function get_new_id_currency() {
        return $this->db->query('select max(INT_ID_CURRENCY) as a from CPL.TM_CURRENCY')->row()->a + 1;
    }

}

?>
