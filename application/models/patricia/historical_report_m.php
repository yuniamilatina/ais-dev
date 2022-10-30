<?php
	/**
	* 
	*/
	class historical_report_m extends CI_Model
	{
		

	    function get_historical()
	    {
	    	$query = $this->db->query("select c.INT_TR_ID, b.CHR_ID_PART_HYP,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR,r.CHR_CREATED_DATE,r.CHR_MODIFIED_DATE,r.CHR_STATUS
from TM_RECEIVING as r  join TM_STO as b on r.CHR_PART_ID = b.CHR_ID_PART
left join TT_TECH_REPORT as c on c.CHR_COMPONENT_ID = b.CHR_ID_PART and c.CHR_TR_DATE =r.CHR_MODIFIED_DATE order by r.CHR_MODIFIED_DATE DESC");
	        return $query->result();
	    }
	    function get_historical_by_date($date1,$date2,$status)
	    {
	    	$query = $this->db->query("select c.INT_TR_ID, b.CHR_ID_PART_HYP,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR,r.CHR_CREATED_DATE,r.CHR_STATUS 
from TM_RECEIVING as r  join TM_STO as b on r.CHR_PART_ID = b.CHR_ID_PART 
left join TT_TECH_REPORT as c on c.CHR_COMPONENT_ID = b.CHR_ID_PART and c.CHR_TR_DATE =r.CHR_MODIFIED_DATE    where r.CHR_CREATED_DATE >= $date1 and r.CHR_CREATED_DATE <= $date2 and r.CHR_STATUS like '".$status."%' order by r.CHR_MODIFIED_DATE  DESC");
	        return $query->result();
	    }
	    function get_historical_by_status($status)
	    {
	    	$query = $this->db->query("select c.INT_TR_ID, b.CHR_ID_PART_HYP,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR,r.CHR_CREATED_DATE,r.CHR_STATUS 
from TM_RECEIVING as r  join TM_STO as b on r.CHR_PART_ID = b.CHR_ID_PART 
left join TT_TECH_REPORT as c on c.CHR_COMPONENT_ID = b.CHR_ID_PART and c.CHR_TR_DATE =r.CHR_MODIFIED_DATE   where r.CHR_STATUS like '".$status."%'");
	        return $query->result();
	    }
	    function get_historical_by_date1($date1,$status)
	    {
	    	$query = $this->db->query("select c.INT_TR_ID, b.CHR_ID_PART_HYP,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR,r.CHR_CREATED_DATE,r.CHR_STATUS 
from TM_RECEIVING as r  join TM_STO as b on r.CHR_PART_ID = b.CHR_ID_PART 
left join TT_TECH_REPORT as c on c.CHR_COMPONENT_ID = b.CHR_ID_PART and c.CHR_TR_DATE =r.CHR_MODIFIED_DATE   where r.CHR_CREATED_DATE >= $date1  and r.CHR_STATUS like '".$status."%'");
	        return $query->result();
	    }
	    function get_historical_by_date2($date2,$status)
	    {
	    	$query = $this->db->query("select c.INT_TR_ID, b.CHR_ID_PART_HYP,b.CHR_ID_PART,b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR,r.CHR_CREATED_DATE,r.CHR_STATUS 
from TM_RECEIVING as r  join TM_STO as b on r.CHR_PART_ID = b.CHR_ID_PART 
left join TT_TECH_REPORT as c on c.CHR_COMPONENT_ID = b.CHR_ID_PART and c.CHR_TR_DATE =r.CHR_MODIFIED_DATE   where  r.CHR_CREATED_DATE <= $date2 and r.CHR_STATUS like '".$status."%'");
	        return $query->result();
	    }

	    
	}
?>