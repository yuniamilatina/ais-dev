<?php

class prodmasdat_m extends CI_Model {
    /* -- define  -- */
    //public $db_1;
    //private $tbl_name = "TM_PES_PART";
   // private $tbl_trans = "TT_PES_PROD_RESULT";
	
    public function __construct() {
        parent::__construct();
		
    }

    /* -- define method-method -- */

	function addProduct($data, $table){
		if (is_array($data)) {
			$sap = $this->load->database('zsap',TRUE);
			$sap->insert($table, $data);
        }

	}
/////////////////////____STOP LINE____////////////////////////////	
	function update_stop_line($data, $id) {
		//var_dump($data->CHR_LINE_CODE);	
		$sap = $this->load->database('zsap',TRUE);
       	$sap->where('CHR_LINE_CODE', $id);
        $sap->update('TM_LINE_STOP', $data);
		//$query = $sap->query($querys);
			return $sap;

    }
	function get_data($id) {
		$sap = $this->load->database('zsap',TRUE);
        $query = $sap->query("select CHR_LINE_CODE, CHR_LINE_STOP , CHR_LINE_CAT 
            from TM_LINE_STOP where CHR_LINE_CODE = '" . $id . "' ");
        return $query;
    }
	function check_id_line($id) {
		$sap = $this->load->database('zsap',TRUE);
        $find_id = $this->db->query("select * from TM_LINE_STOP where CHR_LINE_CODE = '" . $id . "'");
		
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
	function delete_linestop($id){
		$sap = $this->load->database('zsap',TRUE);
        $update_id = $sap->query("update TM_LINE_STOP set CHR_FLAG_DELETE = 'X' where CHR_LINE_CODE = '" . $id . "'");
		return $update_id;
	}
/////////////////////____REJECT_____////////////////////////////	
	function get_data_edit_reject($id) {
		$sap = $this->load->database('zsap',TRUE);
        $query = $sap->query("select CHR_REJECT_CODE, CHR_REJECT_TYPE, CHR_REJECT_GROUP_CODE , CHR_REJECT_GROUP 
            from TM_REJECT where CHR_REJECT_CODE = '" . $id . "' ");
        return $query;
    }
	function get_data_desc_kat($id) {
		$sap = $this->load->database('zsap',TRUE);
        $query = $sap->query("select distinct CHR_REJECT_GROUP 
            from TM_REJECT where CHR_REJECT_GROUP_CODE = '" . $id . "' ");
        print_r($query);
		return $query->result();
    }
	function update_reject($data, $id) {
		//var_dump($data, $id );	
		$sap = $this->load->database('zsap',TRUE);
       	$sap->where('CHR_REJECT_CODE', $id);
        $sap->update('TM_REJECT', $data);
		//$query = $sap->query($querys);
			return $sap;
    }
	function check_id_reject($id) {
		$sap = $this->load->database('zsap',TRUE);
        $find_id = $this->db->query("select * from TM_REJECT where CHR_REJECT_CODE = '" . $id . "'");
		
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
	function delete_reject($id){
		$sap = $this->load->database('zsap',TRUE);
        $update_id = $sap->query("update TM_REJECT set CHR_FLAG_DELETE = 'X' where CHR_REJECT_CODE = '" . $id . "'");
		return $update_id;
	}
/////////////////////______NG_______////////////////////////////
	function get_data_edit_ng($id) {
		$sap = $this->load->database('zsap',TRUE);
        $query = $sap->query("select CHR_NG_CATEGORY_CODE, CHR_NG_CATEGORY
            from TM_NG where CHR_NG_CATEGORY_CODE = '" . $id . "' ");
        return $query;
    }	
	function update_ng($data, $id) {
		//var_dump($data, $id );	
		$sap = $this->load->database('zsap',TRUE);
       	$sap->where('CHR_NG_CATEGORY_CODE', $id);
        $sap->update('TM_NG', $data);
		//$query = $sap->query($querys);
			return $sap;
    }
	function check_id_ng($id) {
		$sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("select * from TM_NG where CHR_NG_CATEGORY_CODE = '" . $id . "'");
		//var_dump($find_id );
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
	function delete_ng($id){
		$sap = $this->load->database('zsap',TRUE);
        $update_id = $sap->query("update TM_NG set CHR_FLAG_DELETE = 'X' where CHR_NG_CATEGORY_CODE = '" . $id . "'");
		return $update_id;
	}
/////////////////______WORK_TIME______////////////////////////
	function get_distinct_time($table) {
		$sap = $this->load->database('zsap',TRUE);
		return $sap->get($table)->result();
	}
	
	function get_data_work_time($id) {
		$sap = $this->load->database('zsap',TRUE);
        $query = $sap->query("select CHR_REJECT_CODE, CHR_REJECT_TYPE, CHR_REJECT_GROUP_CODE , CHR_REJECT_GROUP 
            from TM_REJECT where CHR_REJECT_CODE = '" . $id . "' ");
        return $query;
    }
	function get_cb_time() {
		$sap = $this->load->database('zsap',TRUE);
		$tmp = $sap->query("select distinct CHR_WORK_TIME from TM_WORK_TIME");
		foreach($tmp->result() as $row){
			$cb_time[] = $row;
			}
		
        return $cb_time;
	}
	function get_cb_shift() {
		$sap = $this->load->database('zsap',TRUE);
		$cb_time = $sap->query("select TIME from TV_WORK_TIME");
        return $cb_time;
	}
/////////////////______TARGET PRODUCTION______////////////////////////	
	function update_target_prod($data, $id1, $id2, $id3) {
		//var_dump($data, $id );	
		$sap = $this->load->database('zsap',TRUE);
       	$sap->where('INT_BULAN', $id1);
		$sap->where('INT_TAHUN', $id2);
		$sap->where('CHR_WORK_CENTER', $id3);
        $sap->update('TM_TARGET_PRODUCTION', $data);
			
			return $sap;
    }
	function check_id_tgt_prd($bln, $thn, $wc) {
		$sap = $this->load->database('zsap',TRUE);
        $find_id = $this->db->query("select * from TM_TARGET_PRODUCTION where INT_BULAN = '" . $bln . "' and INT_TAHUN = '" . $thn . "'		and CHR_WORK_CENTER = '" . $wc . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
/////////////////______AREA______////////////////////////
	function check_id_area($id) {
		$sap = $this->load->database('zsap',TRUE);
        $find_id = $sap->query("select * from TM_AREA where CHR_AREA = '" . $id . "'");
		//var_dump($find_id );
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
	function delete_area($id){
		$sap = $this->load->database('zsap',TRUE);
        $update_id = $sap->query("update TM_AREA set CHR_FLAG_DELETE = 'X' where CHR_AREA = '" . $id . "'");
		return $update_id;
	}		
	function update_area($data, $id) {
		//var_dump($data, $id );	
		$sap = $this->load->database('zsap',TRUE);
       	$sap->where('CHR_AREA', $id);
        $sap->update('TM_AREA', $data);
		//$query = $sap->query($querys);
			return $sap;
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	public function updateBySql($sql) {
		$sap = $this->load->database('zsap',TRUE);
		$query = $sap->query($sql);
	}
	
	public function findBySql($sql) {
       $sap = $this->load->database('zsap',TRUE);
        
        $query = $sap->query($sql);

        return $query->result();
    }
	function check_id($id) {
		$sap = $this->load->database('zsap',TRUE);
        $find_id = $this->db->query("select * from TM_NG where CHR_NG_CATEGORY_CODE = '" . $id . "'");
		
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }
	public function find($select='',$where='',$order='',$limit='',$start='0',$group='',$join=''){
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
		//var_dump($this->tbl_name);die();
		return $this->db->get("TM_PES_PART")->result();
		
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	public function update_master($data, $where, $tables) {		
		$sap = $this->load->database('zsap',TRUE);
        if (is_array($data)) {
            return $sap->update($tables, $data, $where);
        }

        return false;
    }
    function add($data) {
        if (is_array($data)) {
            return $this->db->insert($this->tbl_name, $data);
        }

        return false;
    }

    function batch_add($data) {
        if (is_array($data)) {
            return $this->db_1->insert_batch($this->tbl_name, $data);
        }

        return false;
    }

    

    public function update($data, $where) {
		$sap = $this->load->database('zsap',TRUE);
        if (is_array($data)) {
            return $sap->update("TM_PES_PART", $data, $where);
        }

        return false;
    }

    public function delete($where) {
        return $this->db->delete($this->tbl_name, $where);

        return false;
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
	
    function add_trans_aiierp($data) {
        if (is_array($data)) {
            return $this->db_x->insert($this->tbl_trans_aiierp, $data);
        }

        return false;
    }

    public function update_trans_aiierp($data, $where) {
        if (is_array($data)) {
            return $this->db_x->update($this->tbl_trans_aiierp, $data, $where);
        }

        return false;
    }
	
	
    function add_goodsmovement_aiierp($data) {
        if (is_array($data)) {
            return $this->db_x->insert($this->tbl_goodsmovement_aiierp, $data);
        }

        return false;
    }

    public function update_goodsmovement_aiierp($data, $where) {
        if (is_array($data)) {
            return $this->db_x->update($this->tbl_goodsmovement_aiierp, $data, $where);
        }

        return false;
    }
	
	public function exeBySqlAIIERP($sql) {
        $query = $this->db_x->query($sql);

        //return $query->result();
    }
	
	
    public function find_trans_aiierp($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
		if(!empty($select)) $this->db_1->select($select,false);
		if(!empty($where)) $this->db_1->where($where);
		if(!empty($order)) $this->db_1->order_by($order);
		if(!empty($limit)) $this->db_1->limit($limit,$start);
		if(!empty($group)) $this->db_1->group_by($group);
		
		if(!empty($join)&&is_array($join)){
			if(!empty($join['table']) && !empty($join['on'])) {
				$join = array($join);
			}
			
			foreach($join as $item){
				if(!empty($item['table']) && !empty($item['on'])) {
					if(!empty($item['pos'])){
						$this->db_1->join($item['table'],$item['on'],$item['pos']);
					}else{
						$this->db_1->join($item['table'],$item['on']);
					}
				}
			}
		}
		
        return $this->db_x->get($this->tbl_trans_aiierp)->result();
		//return $this->db_1->get($this->tbl_name)->result();
    }
	

}

/* End of file freeze_model.php */
/* Location : application/models/freeze_model.php */