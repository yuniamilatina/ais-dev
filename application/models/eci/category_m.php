<?php

class category_m extends CI_Model {

    private $tbl_trans = "TM_ECI_CATEGORY";

    public function __construct() {
        parent::__construct();
    }

    function find_trans($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
        $db_1 = $this->load->database();
        if (!empty($select))
            $this->db->select($select, false);
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order))
            $this->db->order_by($order);
        if (!empty($limit))
            $this->db->limit($limit, $start);
        if (!empty($group))
            $this->db->group_by($group);
        if (!empty($join) && is_array($join)) {
            if (!empty($join['table']) && !empty($join['on'])) {
                $join = array($join);
            }
            foreach ($join as $item) {
                if (!empty($item['table']) && !empty($item['on'])) {
                    if (!empty($item['pos'])) {
                        $this->db->join($item['table'], $item['on'], $item['pos']);
                    } else {
                        $this->db->join($item['table'], $item['on']);
                    }
                }
            }
        }
        return $this->db->get($this->tbl_trans)->result();
    }

    function add_trans($data) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->insert($this->tbl_trans, $data);
        }
        return false;
    }

    function update_trans($data, $where) {
        $db_1 = $this->load->database();
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans, $data, $where);
        }
        return false;
    }

    function update_category($data, $id) {
        $this->db->where('INT_ID_CATEGORY', $id);
        $this->db->update($this->tbl_trans, $data);
    }

    function delete_trans($id) {
        $this->db->where('INT_ID_CATEGORY', $id);
        $this->db->delete($this->tbl_trans);
    }

    function generate_id_category() {
        return $this->db->query('select max(INT_ID_CATEGORY) as a from TM_ECI_CATEGORY')->row()->a + 1;
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from TM_ECI_CATEGORY where INT_ID_CATEGORY = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

}
