<?php

class schedule_m extends CI_Model {
    /* -- define  -- */
    private $tbl_trans = "TT_ECI_H";
    private $tbl_trans_d = "TT_ECI_L";
    private $tbl_trans_mail = "TT_MAIL_SENT";
    //private $tbl_trans_detil = " TT_EFAKTUR_SCAN_IN_DETIL";
    /* -- define construct -- */

    public function __construct() {
        parent::__construct();

    }
    
    public function findBySql($sql) {
        $db_1 = $this->load->database();
        
        $query = $this->db->query($sql);

        return $query->result();
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
    
    public function insert_mail_publish($data){
        $db_1 = $this->load->database();
        
        if (is_array($data)) {
            return $this->db->insert($this->tbl_trans_mail, $data);
        }

        return false;
    }
    
    
    public function find_trans_d($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
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
		
        return $this->db->get($this->tbl_trans_d)->result();
		//return $this->db_1->get($this->tbl_name)->result();
    }
    

    function add_trans_d($data) {
        $db_1 = $this->load->database();
        
        if (is_array($data)) {
            return $this->db->insert($this->tbl_trans_d, $data);
        }

        return false;
    }

    public function update_trans_d($data, $where) {
        $db_1 = $this->load->database();
        
        
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans_d, $data, $where);
        }

        return false;
    }
}

/* End of file freeze_model.php */
/* Location : application/models/freeze_model.php */