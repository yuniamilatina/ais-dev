<?php

class approval_m extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
    }

    function getApproval($wo, $status=NULL){
        $sql = "SELECT a.*, c.CHR_WORK_TIME_END FROM TT_PRODUCTION_RESULT a 
				LEFT JOIN TT_PRODUCTION_WO b 
                ON a.CHR_WO_NUMBER = b.CHR_WO_NUMBER 
				LEFT JOIN TM_WORK_TIME c 
                ON (c.CHR_WORK_SHIFT=a.CHR_SHIFT AND c.CHR_WORK_DAY=a.CHR_WORK_DAY 
                AND c.CHR_WORK_TIME_START=a.CHR_WORK_TIME_START)
               
                WHERE  a.CHR_WO_NUMBER ='".trim($wo)."'  AND a.CHR_UPDATE_REPAIR IS NULL ";
        if(!$status) $sql .= " AND b.CHR_STATUS IS NULL"; 

        $sql .=" ORDER BY a.CHR_WORK_TIME_START ASC";

        return $this->db->query($sql);
    }
	function getApprovalRole($wo,$person, $status=NULL){ 
        $sql = "SELECT a.*, c.CHR_WORK_TIME_END FROM TT_PRODUCTION_RESULT a 
				INNER JOIN TM_PROCESS
				ON a.CHR_WORK_CENTER = TM_PROCESS.CHR_WORK_CENTER
				LEFT JOIN TT_PRODUCTION_WO b 
                ON a.CHR_WO_NUMBER = b.CHR_WO_NUMBER 
				LEFT JOIN TM_WORK_TIME c 
                ON (c.CHR_WORK_SHIFT=a.CHR_SHIFT AND c.CHR_WORK_DAY=a.CHR_WORK_DAY 
                AND c.CHR_WORK_TIME_START=a.CHR_WORK_TIME_START)
               
                WHERE  a.CHR_WO_NUMBER ='".trim($wo)."'  AND a.CHR_UPDATE_REPAIR IS NULL 
				and TM_PROCESS.CHR_PERSON_RESPONSIBLE = '".$person."'";
        if($status) $sql .= " AND b.CHR_STATUS = 'X'"; 

        $sql .=" ORDER BY a.CHR_WORK_TIME_START ASC"; 

        return $this->db->query($sql);
    }

    function getTMNG(){
        return $this->db->query('SELECT * FROM TM_NG WHERE CHR_FLAG_DELETE IS NULL');
    }

    function getLineStop(){
        return $this->db->query('SELECT * FROM TM_LINE_STOP WHERE CHR_FLAG_DELETE IS NULL');
    }

    function getValueNGRepair($int_number, $ng_category, $responsible){
        if($responsible=='014'){
            $sql = "SELECT b.INT_NUMBER as INT_NUMBER_NG, b.INT_TOTAL_QTY as INT_TOTAL_QTY_NG, a.CHR_AREA,  b.CHR_NG_CATEGORY_CODE
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

    function getIntLS($int_number){ 
        $sql = "SELECT SUM(INT_MENIT) as INT_MENIT FROM TT_PRODUCTION_LINE_STOP WHERE INT_NUMBER=$int_number AND CHR_IND_LINE_STOP='X'";
        return $this->db->query($sql);
    }

    function geCountLS($int_number){
        $sql = "SELECT SUM(INT_MENIT) as INT_TOTAL_LINE_STOP FROM TT_PRODUCTION_LINE_STOP WHERE INT_NUMBER=$int_number";
		return $this->db->query($sql);
    }

    function getIntCT($chr_wc){
        $sql =  "SELECT INT_CT FROM TM_TARGET_PRODUCTION a INNER JOIN TT_PRODUCTION_RESULT b
                ON b.INT_BULAN=a.INT_BULAN AND a.INT_TAHUN=b.INT_TAHUN AND a.CHR_WORK_CENTER=b.CHR_WORK_CENTER
                WHERE b.CHR_WORK_CENTER = '$chr_wc' AND a.CHR_FLAG_DELETE IS NULL";

        return $this->db->query($sql);
    }

    function getActual($time, $date, $wc){
        $sql = "SELECT SUM(INT_TOTAL_QTY) as INT_TOTAL_QTY FROM TT_PRODUCTION_RESULT
                WHERE CHR_WORK_TIME_START='$time' AND CHR_DATE='$date' AND CHR_WORK_CENTER='$wc'";

        return $this->db->query($sql);
    }

     function getWO($keyword){
        $now = date('Ymd');
        $yes = date('Ymd',strtotime("-1 days"));

        $sql = "SELECT TOP 5 * FROM (SELECT DISTINCT(a.CHR_WO_NUMBER) FROM TT_PRODUCTION_RESULT a 
                INNER JOIN TT_PRODUCTION_WO b ON b.CHR_WO_NUMBER=a.CHR_WO_NUMBER
                WHERE b.CHR_STATUS IS NULL AND a.CHR_WO_NUMBER LIKE '$keyword%'
                AND a.CHR_DATE IN ('$now ','$yes')) as TT_PRODUCTION_RESULT";

        return $this->db->query($sql);
    }

    function countWO($keyword){
        $now = date('Ymd');
        $yes = date('Ymd',strtotime("-1 days"));
        $sql = "SELECT COUNT(DISTINCT(a.CHR_WO_NUMBER)) as n
                FROM TT_PRODUCTION_RESULT a INNER JOIN TT_PRODUCTION_WO b
                ON b.CHR_WO_NUMBER=a.CHR_WO_NUMBER
                WHERE b.CHR_STATUS IS NULL 
                AND a.CHR_WO_NUMBER LIKE '$keyword%'
                AND a.CHR_DATE IN ('$now ','$yes')";
        return $this->db->query($sql);
    }
	//add by reza
	public function findBySql($sql) {
		$query = $this->db->query($sql);
        return $query;//->result();
	}
	//end

}
    