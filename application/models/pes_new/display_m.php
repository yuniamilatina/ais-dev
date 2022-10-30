<?php

class display_m extends CI_Model {
    /* -- define  -- */
    public $db_1;
    private $tbl_name = "t_line";
    /*private $tbl_trans = "PES_TT_PROD_RESULT";
	
	private $tbl_trans_aiierp = "TT_PRODUCTION_RESULT";
	private $tbl_goodsmovement_aiierp = "TT_GOODS_MOVEMENT";
	*/
    /* private $tbl_temp = "so_temp_freeze";
      private	$tbl_lock = "so_freeze_lock"; */

    /* -- define construct -- */

    public function __construct() {
        parent::__construct();
        //$dbmssql_pes = $this->load->database('dbmssql_pes', TRUE);
        //$this->db_1 = $this->load->database('display', TRUE);
        
        //$this->db_x = $this->load->database('dbmssql_erp', TRUE);

        //$active_group = 'dbmssql_pes';
        //$active_record = TRUE;
    }

    public function activeRec() {
        $this->db_x->select("*", false);
        $this->db_x->where("CHR_PART_NO = 'MA13'");
        $this->db_x->ORDER_BY("CHR_PART_NO");
        $a = $this->db_x->get("TT_PURCHASE_ORDER_L")->result();
        return $a;
    }

    /* -- define method-method -- */

    public function findBySql($sql) {
        $db_1 = $this->load->database('display', TRUE);
        
        $query = $db_1->query($sql);

        return $query->result();
    }

    public function exeBySql($sql) {
        $db_1 = $this->load->database('display', TRUE);
        
        $query = $db_1->query($sql);

        //return $query->result();
    }
/*
    public function find() {
        $this->db_1->select("*", false);
        
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
         
        $a = $this->db_1->get($this->tbl_name)->result();

        return $a;
    }
*/

	public function find($select='',$where='',$order='',$limit='',$start='0',$group='',$join=''){
                $db_1 = $this->load->database('display', TRUE);
            
		if(!empty($select)) $db_1->select($select,false);
		if(!empty($where)) $db_1->where($where);
		if(!empty($order)) $db_1->order_by($order);
		if(!empty($limit)) $db_1->limit($limit,$start);
		if(!empty($group)) $db_1->group_by($group);
		
		if(!empty($join)&&is_array($join)){
			if(!empty($join['table']) && !empty($join['on'])) {
				$join = array($join);
			}
			
			foreach($join as $item){
				if(!empty($item['table']) && !empty($item['on'])) {
					if(!empty($item['pos'])){
						$db_1->join($item['table'],$item['on'],$item['pos']);
					}else{
						$db_1->join($item['table'],$item['on']);
					}
				}
			}
		}
		
		return $db_1->get($this->tbl_name)->result();
	}
    function add($data) {
        if (is_array($data)) {
            return $this->db_1->insert($this->tbl_name, $data);
        }

        return false;
    }

    function batch_add($data) {
        if (is_array($data)) {
            return $this->db_1->insert_batch($this->tbl_name, $data);
        }

        return false;
    }

    public function is_exist($where = '') {
        $this->db_1->where($where);
        $this->db_1->limit('1');
        $q = $this->db_1->get($this->tbl_name);

        $data = $q->row();
        return !empty($data);
    }

    public function update($data, $where) {
        if (is_array($data)) {
            return $this->db_1->update($this->tbl_name, $data, $where);
        }

        return false;
    }

    public function delete($where) {
        return $this->db_1->delete($this->tbl_name, $where);

        return false;
    }

    public function find_trans($select = '', $where = '', $order = '', $limit = '', $start = '0', $group = '', $join = '') {
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
		
        return $this->db_1->get($this->tbl_trans)->result();
		//return $this->db_1->get($this->tbl_name)->result();
    }

    function add_trans($data) {
        if (is_array($data)) {
            return $this->db_1->insert($this->tbl_trans, $data);
        }

        return false;
    }

    public function update_trans($data, $where) {
        if (is_array($data)) {
            return $this->db_1->update($this->tbl_trans, $data, $where);
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