<?php

class pos_material_m extends CI_Model {

    private $tabel = 'PRD.TM_POS_MATERIAL';
	 private $tabel_detail = 'PRD.TM_POS_MATERIAL_DETAIL';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

	function save_detail($data) {
        $this->db->insert($this->tabel_detail, $data);
    }
	
    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }

    function delete($id) {
        $data = array('INT_FLG_DEL' => 1);

        $this->db->where('INT_ID', $id);
        $this->db->update($this->tabel, $data);
    }

    function get_data_pos_material_by_work_center($work_center) {
        $sql = "SELECT INT_ID
                    ,CHR_WORK_CENTER
                    ,CHR_PART_NO_FG
                    ,CHR_PART_NO_COMP
                    ,CHR_BACK_NO_COMP
                    ,CHR_POS_PRD
                    ,INT_QTY_PCS
                    ,INT_FLG_IGNORE_SCAN
                    ,CHR_CREATED_BY
                    ,CHR_CREATED_DATE
                    ,CHR_CREATED_TIME
                    ,CHR_MODIFIED_BY
                    ,CHR_MODIFIED_DATE
                    ,CHR_MODIFIED_TIME
                    ,INT_FLG_DEL
            FROM $this->tabel 
            WHERE INT_FLG_DEL = 0
            AND CHR_WORK_CENTER = '$work_center'";

        return $this->db->query($sql)->result();
    }

    function get_list_material_by_part_no_comp($partno, $work_center, $pos, $prd_order_no){
        $query = $this->db->query("SELECT * FROM PRD.TT_ELINA_L L INNER JOIN PRD.TT_PIS_POS_MATERIAL PPM 
            ON L.CHR_PRD_ORDER_NO = PPM.CHR_PRD_ORDER_NO AND L.CHR_PART_NO = PPM.CHR_PART_NO_COMP
            WHERE PPM.CHR_PRD_ORDER_NO = '$prd_order_no' AND L.CHR_PART_NO = '$partno' 
            AND PPM.CHR_POS_PRD = '$pos' AND PPM.CHR_WORK_CENTER = '$work_center'");

        if($query->num_rows() > 0){
            return $query;
        }else{
            return $query = $this->db->query("SELECT * FROM PRD.TM_POS_MATERIAL_DETAIL WHERE CHR_PART_NO_SA = (
                SELECT CHR_PART_NO_SA FROM PRD.TM_POS_MATERIAL_DETAIL 
                WHERE CHR_PART_NO_COMP = '$partno'  AND CHR_POS_PRD = '$pos' AND CHR_WORK_CENTER = '$work_center')
                AND CHR_PART_NO_FG = ( 
                SELECT CHR_PART_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prd_order_no' AND INT_FLG_DEL = 0)");
        }
    }

    function get_data_pos_material_by_pos_material($work_center, $partno_comp, $prd_order_no, $pos){
        $query = $this->db->query("SELECT TOP 1 * FROM PRD.TM_POS_MATERIAL WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$work_center' 
            AND CHR_PART_NO_COMP = '$partno_comp' AND CHR_POS_PRD = '$pos'
            AND CHR_PART_NO_FG = (SELECT CHR_PART_NO FROM PRD.TT_SETUP_CHUTE WHERE CHR_PRD_ORDER_NO = '$prd_order_no' AND INT_FLG_DEL = 0)");

        return $query;
    }
   
    function get_data_pos_material_by_id($id){
        $sql = "SELECT 
        CASE WHEN CHR_BACK_NO_SA IS NULL THEN CHR_BACK_NO_COMP ELSE CHR_BACK_NO_SA END AS CHR_BACK_NO_COMPONEN ,
        CASE WHEN CHR_PART_NO_SA IS NULL THEN CHR_PART_NO_COMP ELSE CHR_PART_NO_SA END AS CHR_PART_NO_COMPONEN ,
        * FROM $this->tabel 
            WHERE INT_FLG_DEL = 0 
            AND INT_ID = '$id'";

        return $this->db->query($sql)->row();
    }

    function get_existing_data_pos_material($work_center, $part_no, $part_no_comp){
        return $this->db->query("SELECT * FROM $this->tabel WHERE CHR_WORK_CENTER = '$work_center' 
        AND CHR_PART_NO_FG = '$part_no' AND CHR_PART_NO_COMP = '$part_no_comp'")->result();
    }

    function check_existing_pos_material_by_part_no($part_no){
        return $this->db->query("SELECT TOP 1 1 FROM $this->tabel WHERE CHR_PART_NO_FG = '$part_no' AND INT_FLG_DEL = 0");
    }
	
	function delete_pos_material($part_no , $workcenter){
        $query = "DELETE FROM $this->tabel WHERE CHR_PART_NO_FG = '$part_no' and CHR_WORK_CENTER = '$workcenter' ";
        $this->db->query($query);
        
        $query = "DELETE FROM $this->tabel_detail WHERE CHR_PART_NO_FG = '$part_no' and CHR_WORK_CENTER = '$workcenter' ";
        $this->db->query($query);
    }
    
}
