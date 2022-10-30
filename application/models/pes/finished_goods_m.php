<?php

class Finished_goods_m extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
    }

    function getProdResult($backno, $tanggal, $person){ //
        $backno = str_replace(";", "','", $backno);
        $backno = "('$backno')";
        $tanggal = explode("/", $tanggal);
        $date = $tanggal[2].$tanggal[0].$tanggal[1];

        $sql = "SELECT a.*, c.CHR_WORK_TIME_END FROM TT_PRODUCTION_RESULT a 
                LEFT JOIN TM_WORK_TIME c 
                ON (c.CHR_WORK_SHIFT=a.CHR_SHIFT AND c.CHR_WORK_DAY=a.CHR_WORK_DAY 
                AND c.CHR_WORK_TIME_START=a.CHR_WORK_TIME_START) 
                LEFT JOIN TM_PROCESS b
                ON (b.CHR_WORK_CENTER = a.CHR_WORK_CENTER) 
                WHERE a.CHR_VALIDATE IS NULL AND  
                a.CHR_BACK_NO IN $backno AND a.CHR_DATE='$date'  AND a.CHR_VALIDATE IS NULL AND a.CHR_STATUS_MOBILE ='M' AND
                b.CHR_PERSON_RESPONSIBLE = '$person'            
                ORDER BY a.CHR_WORK_TIME_START ASC";			
        //echo $sql;
        return $this->db->query($sql);
    }
	function getProdResultNoRoles($backno, $tanggal){ 
        $backno = str_replace(";", "','", $backno);
        $backno = "('$backno')";
        $tanggal = explode("/", $tanggal);
        $date = $tanggal[2].$tanggal[0].$tanggal[1];

        $sql = "SELECT a.*, c.CHR_WORK_TIME_END FROM TT_PRODUCTION_RESULT a 

				LEFT JOIN TM_WORK_TIME c 
                ON (c.CHR_WORK_SHIFT=a.CHR_SHIFT AND c.CHR_WORK_DAY=a.CHR_WORK_DAY 
                AND c.CHR_WORK_TIME_START=a.CHR_WORK_TIME_START)
                WHERE a.CHR_VALIDATE IS NULL AND  
                a.CHR_BACK_NO IN $backno AND a.CHR_DATE='$date'  AND a.CHR_VALIDATE IS NULL AND a.CHR_STATUS_MOBILE ='M' 
				ORDER BY a.CHR_WORK_TIME_START ASC";		
        //echo $sql;
        return $this->db->query($sql);
    }

    function getProdResultBackNoOld($backno, $tanggal){ 
        $backno=$backno;
        // $backno = str_replace(";", "','", $backno);
        // $backno = "('$backno')";
        $tanggal = explode("/", $tanggal);
        $date = $tanggal[2].$tanggal[0].$tanggal[1];
        $sql ="SELECT CHR_WORK_CENTER FROM TT_PRODUCTION_RESULT WHERE CHR_VALIDATE IS NULL AND CHR_BACK_NO = '$backno' AND CHR_DATE='$date' AND CHR_VALIDATE IS NULL AND CHR_STATUS_MOBILE ='M' ORDER BY CHR_WORK_TIME_START ASC"; 
        $query = $this->db->query($sql);
        return $query->result();   
        
    }

    function getProdResultBackNoNew($backno2, $tanggal){ 
        $backno2=$backno2;
        // $backno = str_replace(";", "','", $backno);
        // $backno = "('$backno')";
        $tanggal = explode("/", $tanggal);
        $date = $tanggal[2].$tanggal[0].$tanggal[1];
        $sql ="SELECT CHR_WORK_CENTER FROM TT_PRODUCTION_RESULT WHERE CHR_VALIDATE IS NULL AND CHR_BACK_NO = '$backno2' AND CHR_DATE='$date' AND CHR_VALIDATE IS NULL AND CHR_STATUS_MOBILE ='M' ORDER BY CHR_WORK_TIME_START ASC"; 
        $query = $this->db->query($sql);
        return $query->result();   
        
    }

    function getarea($backno,$tanggal) { 
        $backno=$backno;
        $tanggal = explode("/", $tanggal);
        $date = $tanggal[2].$tanggal[0].$tanggal[1];      
        $sql = "SELECT DISTINCT 
                         TT_PRODUCTION_RESULT.CHR_BACK_NO, TT_PRODUCTION_RESULT.CHR_DATE, TT_PRODUCTION_RESULT.CHR_STATUS_MOBILE, 
                         TM_PROCESS_PARTS.CHR_WORK_CENTER, TM_AREA.CHR_AREA, TM_AREA.CHR_DESC_AREA, TM_AREA.CHR_FLAG_DELETE, 
                         TM_PROCESS_PARTS.CHR_AREA AS Expr1
FROM            TT_PRODUCTION_RESULT INNER JOIN
                         TM_PROCESS_PARTS ON TT_PRODUCTION_RESULT.CHR_WORK_CENTER = TM_PROCESS_PARTS.CHR_WORK_CENTER INNER JOIN
                         TM_AREA ON TM_PROCESS_PARTS.CHR_AREA = TM_AREA.CHR_AREA
WHERE        (TT_PRODUCTION_RESULT.CHR_BACK_NO = '$backno') AND (TT_PRODUCTION_RESULT.CHR_DATE = '$date') AND 
                         (TT_PRODUCTION_RESULT.CHR_STATUS_MOBILE = 'M')";
        return $this->db->query($sql)->result();
        
    }

    function getTMNG(){
		$sql= "SELECT * FROM TM_NG WHERE CHR_NG_CATEGORY_CODE != '' AND CHR_FLAG_DELETE IS NULL";
        return $this->db->query($sql);
    }

    function getLineStop(){
        return $this->db->query('SELECT * FROM TM_LINE_STOP WHERE CHR_FLAG_DELETE IS NULL');
    }

    function getValueNGRepair($int_number, $ng_category, $responsible){
        if($responsible=='014'){
            $sql = "SELECT b.INT_NUMBER as INT_NUMBER_NG, b.INT_TOTAL_QTY as INT_TOTAL_QTY_NG, b.CHR_NG_CATEGORY_CODE
                    FROM TT_NG_RECORD_H a LEFT JOIN TT_NG_RECORD_L b ON a.INT_NUMBER=b.INT_NUMBER
                    WHERE b.CHR_NG_CATEGORY_CODE='$ng_category' AND a.INT_NUMBER_PROD='$int_number'";
        } else {
            $sql = "SELECT INT_NUMBER as INT_NUMBER_NG, INT_TOTAL_QTY_NG, CHR_NG_CATEGORY_CODE FROM TT_PRODUCTION_REPAIR WHERE INT_NUMBER='$int_number' AND CHR_NG_CATEGORY_CODE='$ng_category'";
        }
        return $this->db->query($sql);
    }

    function getValueLS($int_number, $line_code){
        $sql = "SELECT * FROM TT_PRODUCTION_LINE_STOP WHERE INT_NUMBER='$int_number' AND CHR_LINE_CODE='$line_code'";
        
        return $this->db->query($sql);
    }

}
    