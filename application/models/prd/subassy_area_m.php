<?php

class subassy_area_m extends CI_Model
{

    private $table_master = 'PRD.TM_SUBASSY_PREPARE_AREA';

    function getAllDataSubAssyArea()
    {

        $query = $this->db->query("SELECT * FROM $this->table_master WHERE INT_FLG_DEL = 0");
        return $query->result();
    }

    function getDataSubAssyAreabyId($id)
    {

        $query = $this->db->query("SELECT * FROM $this->table_master WHERE INT_FLG_DEL = 0 AND INT_ID = '$id'");
        return $query->row();
    }

    function save($data)
    {

        $this->db->insert($this->table_master, $data);
    }

    function update($id, $data)
    {

        $this->db->where('INT_ID', $id);
        $this->db->update($this->table_master, $data);
    }

    function delete($id)
    {
        $data = array(
            'INT_FLG_DEL' => 1
        );


        $this->db->where('INT_ID', $id);
        $this->db->update($this->table_master, $data);
    }

    function generateSubAssyCode($workcenter, $pos){
        $query = $this->db->query("SELECT COUNT(*) + 1 CODE FROM $this->table_master 
        WHERE INT_FLG_DEL = 0 AND CHR_WORK_CENTER = '$workcenter' AND CHR_POS_PRD = '$pos'");

        if($query->num_rows() > 0){
            return $query->row()->CODE;
        }else{
            return 1;
        }
    }
}
