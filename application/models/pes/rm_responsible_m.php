<?php

class rm_responsible_m extends CI_Model {

    private $tabel = 'TM_RM_RESPONSIBLE';

    public function __construct() {
        parent::__construct();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where($id);
        $this->db->update($this->tabel, $data);
    }
    
    function get_detail_kanban($back_no_komponen, $part_no) {
        $sql = "SELECT RTRIM(RM.CHR_PART_NO_RM) CHR_PART_NO_RM, RM.CHR_PART_SFG, 
        CASE RTRIM(P.CHR_PART_UOM) WHEN 'KG' 
                THEN CAST(RM.INT_WEIGHT AS DECIMAL(18, 3)) * 1000 
                ELSE CAST(RM.INT_WEIGHT AS DECIMAL(18, 3)) 
        END AS INT_WEIGHT,
        RTRIM(P.CHR_PART_UOM) AS CHR_PART_UOM 
        FROM $this->tabel RM  
	INNER JOIN TM_PARTS P ON P.CHR_PART_NO = RM.CHR_PART_NO_RM  
        WHERE RM.CHR_PART_NO_RM IN 
        (SELECT CHR_PART_NO FROM TM_PARTS WHERE (CHR_BACK_NO = '$back_no_komponen') OR (CHR_PART_NO = '$back_no_komponen')) 
        AND RM.CHR_PART_SFG = '$part_no'
        GROUP BY RM.CHR_PART_NO_RM, RM.CHR_PART_SFG, RM.INT_WEIGHT, P.CHR_PART_NO, P.CHR_PART_UOM ";

        return $this->db->query($sql);
    }
    
    function get_correct_detail_kanban($part_no) {
        $sql = "SELECT RM.CHR_PART_NO_RM, RM.CHR_PART_SFG, RM.INT_WEIGHT, P.CHR_PART_NO, P.CHR_PART_UOM FROM $this->tabel RM  
	    INNER JOIN TM_PARTS P ON P.CHR_PART_NO = RM.CHR_PART_SFG 
        WHERE RM.CHR_PART_SFG = '$part_no'
        GROUP BY RM.CHR_PART_NO_RM, RM.CHR_PART_SFG, RM.INT_WEIGHT, P.CHR_PART_NO, P.CHR_PART_UOM";

        return $this->db->query($sql);
    }
}
