<?php

class stock_out_manual_m extends CI_Model {
        
    function addStock($data, $table){
        if (is_array($data)) {
            $sap = $this->load->database('zsap',TRUE);
            $sap->insert($table, $data);
        }

    }
    function check_id_line($id){
        $sap = $this->load->database('zsap',TRUE);
        $find_id = $this->db->query("select * from TW_STOCK_OUT_MANUAL where CHR_BACK_NO = '" . $id . "'");
        
        if ($find_id->num_rows() > 1) {
            return true;
        }
        return false;
    }
    public function findBySql($sql) {
       $sap = $this->load->database('zsap',TRUE);
        
        $query = $sap->query($sql);

        return $query->result();
    }
    function getSloc(){
        $sap = $this->load->database('zsap',TRUE);       
        //update by Ilham 27-02-2018 --> update query only WP01 & PP02 can be show on get Sloc
        $query = $sap->query("select distinct CHR_SLOC from TM_PARTS_SLOC where CHR_SLOC = 'WP01' OR CHR_SLOC = 'PP02' order by CHR_SLOC desc")->result();
        $loc= array('-SELECT-');
        for ($i = 0; $i < count($query); $i++)
        {
            array_push($loc, $query[$i]->CHR_SLOC);
        }            
        return $query;
    }

    function addProduct($data, $table){
        if (is_array($data)) {
            $sap = $this->load->database('zsap',TRUE);
            $sap->insert($table, $data);
        }

    }

    public function DeleteData($sql){
    $sap = $this->load->database('zsap',TRUE);
        $query = $sap->query($sql);
    return $query;
    }
}
?>