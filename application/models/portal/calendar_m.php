<?php

class calendar_m extends CI_Model {
    /* -- define  -- */
    private $tbl_trans = "TM_PORTAL_CALENDAR";
    //private $tbl_trans_detil = " TT_EFAKTUR_SCAN_IN_DETIL";
    /* -- define construct -- */

    public function __construct() {
        parent::__construct();

    }
    

    
    public function find_trans($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
		$db_1 = $this->load->database();
        
                if(!empty($select)) $this->db->select($select,false);
		if(!empty($where)) $this->db->where($where);
		if(!empty($order)) $this->db->order_by($order);
		if(!empty($limit)) $this->db->limit($limit,$start);
		if(!empty($group)) $this->db->group_by($group);
		
		if(!empty($join)&&is_array($join)){
			if(!empty($join['table']) && !empty($join['on'])) {
				$join = array($join);
			}
			
			foreach($join as $item){
				if(!empty($item['table']) && !empty($item['on'])) {
					if(!empty($item['pos'])){
						$this->db->join($item['table'],$item['on'],$item['pos']);
					}else{
						$this->db->join($item['table'],$item['on']);
					}
				}
			}
		}
		
        return $this->db->get($this->tbl_trans)->result();
		//return $this->db_1->get($this->tbl_name)->result();
    }

    function add_trans($data) {
        $db_1 = $this->load->database();
        
        if (is_array($data)) {
            return $this->db->insert($this->tbl_trans, $data);
        }

        return false;
    }

    public function update_trans($data, $where) {
        $db_1 = $this->load->database();
        
        
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans, $data, $where);
        }

        return false;
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
    
    public function delete_trans($where) {
        return $this->db->delete($this->tbl_trans, $where);

        return false;
    }
    
}

/* End of file freeze_model.php */
/* Location : application/models/freeze_model.php */