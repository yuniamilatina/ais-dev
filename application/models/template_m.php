<?php

class prodmasdat_m extends CI_Model {
    /* -- define  -- */
    public $db_1;
    private $tbl_name = "TM_PES_PART";
    private $tbl_trans = "TT_PES_PROD_RESULT";
    
	
    public function __construct() {
        parent::__construct();
		
    }

    public function activeRec() {
        $this->db_x->select("*", false);
        $this->db_x->where("CHR_PART_NO = 'MA13'");
        $this->db_x->ORDER_BY("CHR_PART_NO");
        $a = $this->db_x->get("TT_PURCHASE_ORDER_L")->result();
        return $a;
    }

    /* -- define method-method -- */

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
        if (is_array($data)) {
            return $this->db->update($this->tbl_name, $data, $where);
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
	
	
   
	

}

/* End of file freeze_model.php */
/* Location : application/models/freeze_model.php */