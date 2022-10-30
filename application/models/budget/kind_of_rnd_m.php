<?php

class kind_of_rnd_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_rnd = 'CPL.TM_KIND_OF_RND';

    function get_rnd() {
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_rnd)->result();
    }

    function save($data) {
        $this->db->insert($this->tm_rnd, $data);
    }

    function get_data_rnd($id) {
        $this->db->where('INT_ID_RND', $id);
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_rnd);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_RND', $id);
        $this->db->update($this->tm_rnd, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'BIT_FLG_DEL' => '1', 
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));
        $this->db->where('INT_ID_RND', $id);
        $this->db->update($this->tm_rnd, $data);
    }

    function get_new_id_rnd() {
        return $this->db->query('select max(INT_ID_RND) as a from CPL.TM_KIND_OF_RND')->row()->a + 1;
    }

}

?>
