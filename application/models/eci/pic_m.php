<?php

class pic_m extends CI_Model {

    private $tbl_trans = "TM_ECI_PIC";

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

    function get_pic_by_id($id) {
        return $this->db->query("select * from TM_ECI_PIC where INT_ID_PIC = $id")->row();
    }

    function get_data_pic() {
        return $this->db->query('select INT_ID_PIC, CHR_NPK, CHR_NAME, CHR_DEPT from TM_ECI_PIC where CHR_FLG_DELETE = 1')->result();
    }
    
    function get_data_pic_user() {
        return $this->db->query('SELECT U.CHR_NPK, UPPER(U.CHR_USERNAME) CHR_USERNAME, U.CHR_EMAIL, D.CHR_DEPT, D.INT_ID_DEPT
                    FROM  TM_USER U 
                    LEFT JOIN TM_DEPT D ON D.INT_ID_DEPT = U.INT_ID_DEPT
                            WHERE U.CHR_NPK NOT IN (
                            SELECT CHR_NPK FROM TM_ECI_PIC where CHR_FLG_DELETE = 1
                            ) ')->result();
    }

    function get_data_user_by_npk($npk){
         return $this->db->query("SELECT U.CHR_NPK, UPPER(U.CHR_USERNAME) CHR_USERNAME , U.CHR_EMAIL, D.CHR_DEPT, D.INT_ID_DEPT
                FROM  TM_USER U 
                INNER JOIN TM_DEPT D ON D.INT_ID_DEPT = U.INT_ID_DEPT
                WHERE U.CHR_NPK = '$npk'")->row();
    }
    
    function get_data_pic_by_dept($dept) {
        return $this->db->query("select INT_ID_PIC, CHR_NPK, CHR_NAME, CHR_DEPT from TM_ECI_PIC where CHR_FLG_DELETE = 1 AND CHR_DEPT = '$dept'")->result();
    }

    function get_data_dept_pic() {
        return $this->db->query('select DISTINCT CHR_DEPT from TM_ECI_PIC where CHR_FLG_DELETE = 1')->result();
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

    function delete_trans($id) {
        $this->db->where('INT_ID_PIC', $id);
        $this->db->delete($this->tbl_trans);
    }

    function generate_id_category() {
        return $this->db->query('select max(INT_ID_PIC) as a from TM_ECI_PIC')->row()->a + 1;
    }

    function check_id($id) {
        $find_id = $this->db->query("select * from TM_ECI_PIC where CHR_NPK = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

}
