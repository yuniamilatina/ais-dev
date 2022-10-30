<?php

class project_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tm_project = 'CPL.TM_PROJECT';
    private $tt_pp = 'CPL.TT_PROJECT_PRODUCT';

    function get_project() {
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_project)->result();
    }

    function save($data) {
        $this->db->insert($this->tm_project, $data);
    }

    function get_data_project($id) {
        $this->db->where('INT_ID_PROJECT', $id);
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_project);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_PROJECT', $id);
        $this->db->update($this->tm_project, $data);
    }

    function delete($id) {
        $session = $this->session->all_userdata();
        $data = array(
            'BIT_FLG_DEL' => '1',
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));
        $this->db->where('INT_ID_PROJECT', $id);
        $this->db->update($this->tm_project, $data);
    }    

    function get_new_id_project() {
        return $this->db->query('select max(INT_ID_PROJECT) as a from CPL.TM_PROJECT')->row()->a + 1;
    }

    public function get_project_name() {
        $this->db->select('INT_ID_PROJECT', 'CHR_PROJECT_DESC');
        $this->db->where('BIT_FLG_DEL !=', '1');
        return $this->db->get($this->tm_project)->result();
    }

    function get_data_product($id) {

        return $this->db->query('select a.INT_ID_PROJECT, a.INT_ID_PRODUCT, b.CHR_PRODUCT, b.CHR_PRODUCT_DESC
                                from CPL.TT_PROJECT_PRODUCT a, CPL.TM_PRODUCT b
                                where a.INT_ID_PRODUCT=b.INT_ID_PRODUCT and a.INT_ID_PROJECT =' . $id)->result();
    }

    function save_project_product($product, $project, $name) {
        $data = array(
            'INT_ID_PROJECT' => $project,
            'INT_ID_PRODUCT' => $product,
            'CHR_CREATE_BY' => $name,
            'CHR_CREATE_DATE' => date('Ymd'),
            'CHR_CREATE_TIME' => date('His'));
        $this->db->insert($this->tt_pp, $data);
    }

    function delete_project_product($project) {
        $this->db->where('INT_ID_PROJECT', $project);
        $this->db->delete($this->tt_pp);
    }
    function if_exist($id) {
        $this->db->where('INT_ID_PROJECT', $id);
        $x = $this->db->get($this->tt_pp);
        if ($x->num_rows() == 0) {
            return false;
        } else {
            return TRUE;
        }
    }

}

?>
