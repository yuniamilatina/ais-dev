<?php

class export_m extends CI_Model {
    /* -- define  -- */
    private $tbl_trans = "TT_EFAKTUR_SCAN_IN_HEADER";
    private $tbl_trans_detil = "TT_EFAKTUR_SCAN_IN_DETIL";
    
    private $tbl_out_header = "TW_EFAKTUR_EXPORT_OUT_HEADER";
    private $tbl_out_header_lt = "TW_EFAKTUR_EXPORT_OUT_HEADER_LT";
    private $tbl_out_detil = "TW_EFAKTUR_EXPORT_OUT_DETIL";
    /* -- define construct -- */

    public function __construct() {
        parent::__construct();
        //$dbmssql_pes = $this->load->database();
        
        //$this->db_x = $this->load->database('dbmssql_erp', TRUE);

        //$active_group = 'dbmssql_pes';
        //$active_record = TRUE;
    }
    
    public function findBySql($sql) {
        $db_1 = $this->load->database();
        
        $query = $this->db->query($sql);

        return $query->result();
    }
    
    public function select_data_in($zuonr_low, $zuonr_high, $budat_low, $budat_high)
    {
            // ZFM_RCS12001
            $this->sapconn->new_function('ZFM_RYA_EFAKTUR_IN');
            $this->sapconn->import('LV_ZUONR_LOW', $zuonr_low);
            $this->sapconn->import('LV_ZUONR_HIGH', $zuonr_high);
            $this->sapconn->import('LV_BUDAT_LOW', $budat_low);
            $this->sapconn->import('LV_BUDAT_HIGH', $budat_high);
            
            $this->sapconn->call();
            $data = $this->sapconn->fetch('GI_OUT');

           
            return $data;

    }
    
    public function select_data_out($inv_no_low, $inv_no_high)
    {
            // ZFM_RCS12001
            $this->sapconn->new_function('ZFM_WDE_EFAKTUR_OUT_R0');
            $this->sapconn->import('GV_INV_NO_LOW', $inv_no_low);
            $this->sapconn->import('GV_INV_NO_HIGH', $inv_no_high);
            
            $this->sapconn->call();
            $data['HEADERDATA'] = $this->sapconn->fetch('O_HEADERDATA');
            $data['LINEDATA'] = $this->sapconn->fetch('O_LINEDATA');
            $data['TAXDATA'] = $this->sapconn->fetch('O_TAXDATA');
            
            return $data;

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
    
    public function find_trans_detil($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
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
		
        return $this->db->get($this->tbl_trans_detil)->result();
		//return $this->db_1->get($this->tbl_name)->result();
    }
    
    function add_trans_detil($data) {
        $db_1 = $this->load->database();
        
        if (is_array($data)) {
            return $this->db->insert($this->tbl_trans_detil, $data);
        }

        return false;
    }

    public function update_trans_detil($data, $where) {
        $db_1 = $this->load->database();
        
        
        if (is_array($data)) {
            return $this->db->update($this->tbl_trans_detil, $data, $where);
        }

        return false;
    }
    
    
    function add_out_header($data) {
        $db_1 = $this->load->database();
        
        if (is_array($data)) {
            return $this->db->insert($this->tbl_out_header, $data);
        }

        return false;
    }
    
    function delete_out_header($where) {
        return $this->db->delete($this->tbl_out_header, $where);

        return false;
    }
    
    function add_out_header_lt($data) {
        $db_1 = $this->load->database();
        
        if (is_array($data)) {
            return $this->db->insert($this->tbl_out_header_lt, $data);
        }

        return false;
    }
    
    function delete_out_header_lt($where) {
        return $this->db->delete($this->tbl_out_header_lt, $where);

        return false;
    }
    
    function add_out_detil($data) {
        $db_1 = $this->load->database();
        
        if (is_array($data)) {
            return $this->db->insert($this->tbl_out_detil, $data);
        }

        return false;
    }
    
    function delete_out_detil($where) {
        return $this->db->delete($this->tbl_out_detil, $where);

        return false;
    }
    
}

/* End of file freeze_model.php */
/* Location : application/models/freeze_model.php */