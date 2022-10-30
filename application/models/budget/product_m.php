<?php

class product_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_product = 'CPL.TM_PRODUCT';

    function get_product() {
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_product)->result();
    }

    function save($data) {
        $this->db->insert($this->tm_product, $data);
    }

    function get_data_product($id) {
        $this->db->where('INT_ID_PRODUCT', $id);
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_product);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_PRODUCT', $id);
        $this->db->update($this->tm_product, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'BIT_FLG_DEL' => '1', 
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));
        $this->db->where('INT_ID_PRODUCT', $id);
        $this->db->update($this->tm_product, $data);
    }

    function get_new_id_product() {
        return $this->db->query('select max(INT_ID_PRODUCT) as a from CPL.TM_PRODUCT')->row()->a + 1;
    }

}

?>
