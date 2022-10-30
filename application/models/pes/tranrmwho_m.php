<?php

class Tranrmwho_m extends CI_Model {
    /* -- define  -- */
    // public $db_1;
    // private $tbl_name = "TM_PES_PART";
    // private $tbl_trans = "TT_PES_PROD_RESULT";
   // private $db_sap;
	
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

    public function findBySql($sql) {
       $sap = $this->load->database('zsap',TRUE);
        
        $query = $sap->query($sql);

        return $query->result();
    }

    function addId() {
        $sap = $this->load->database('zsap',TRUE);
        return $sap->query('select max(CHR_NUMBER_ITEM) as a from TW_GOODS_MOVEMENT_L')->row()->a + 1;
    }

    function addNumber() {
        $sap = $this->load->database('zsap',TRUE);
        return $sap->query('select max(CHR_NUMBER) as b from TW_GOODS_MOVEMENT_L')->row()->b + 1;
    }

    function add($data) {
        if (is_array($data)) {
            return $this->db->insert($this->tbl_name, $data);
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
	

}

/* End of file freeze_model.php */
/* Location : application/models/freeze_model.php */