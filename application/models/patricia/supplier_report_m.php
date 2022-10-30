<?php
	/**
	* 
	*/
	class supplier_report_m extends CI_Model
	{
		

	    function get_performance() {
	        $query = $this->db->query("select b.CHR_NAMA_VENDOR, 
(select COUNT(INT_CHECKSHEET_ID) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART where INT_STATUS = 1 and g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR group by g.CHR_NAMA_VENDOR) as berhasil,
(select COUNT(INT_CHECKSHEET_ID) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART where  g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR group by g.CHR_NAMA_VENDOR) as semua,
(select (Cast(COUNT(INT_CHECKSHEET_ID) as float)) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART where INT_STATUS = 1 and g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR group by g.CHR_NAMA_VENDOR)*100/(Cast(COUNT(a.INT_CHECKSHEET_ID) as float)) as hasil
from TT_CHECK_SHEET as a join TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART
group by b.CHR_NAMA_VENDOR");
	        return $query->result();
	    }
	    function get_performance_tren($supplier,$year) {
	    	$min = $year.'03';
	    	$max = ($year+1).'04';
	        $query = $this->db->query("select  b.CHR_NAMA_VENDOR ,left(a.CHR_CREATED_DATE,6) as Bulan, 
isnull((select COUNT(INT_CHECKSHEET_ID) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where INT_STATUS = 0 and g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR  and left(f.CHR_CREATED_DATE,6) = left(a.CHR_CREATED_DATE,6) group by g.CHR_NAMA_VENDOR),0) as berhasil,
isnull((select COUNT(INT_CHECKSHEET_ID) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where  g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR and left(f.CHR_CREATED_DATE,6) = left(a.CHR_CREATED_DATE,6) group by g.CHR_NAMA_VENDOR),0) as semua,
isnull((select (Cast(COUNT(INT_CHECKSHEET_ID) as float)) as benar from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where INT_STATUS = 0 and g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR  and left(f.CHR_CREATED_DATE,6) = left(a.CHR_CREATED_DATE,6) group by g.CHR_NAMA_VENDOR)/(select (Cast(COUNT(INT_CHECKSHEET_ID) as FLOAT)) as jumlah from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where  g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR and left(f.CHR_CREATED_DATE,6) = left(a.CHR_CREATED_DATE,6) group by g.CHR_NAMA_VENDOR),0) as hasil
from TT_CHECK_SHEET as a join TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR where left(a.CHR_CREATED_DATE,6) < '".$max."' and left(a.CHR_CREATED_DATE,6) > '".$min."' and b.CHR_KODE_VENDOR like '%".$supplier."%' group by  b.CHR_NAMA_VENDOR,left(a.CHR_CREATED_DATE,6)");
	        if ($query->num_rows() > 0) {
	            return $query->result();
	        } else {
	            return 0;
	        }
	    }
	    function get_performance_by_date($date,$supplier)
	    {
	    	$query = $this->db->query("select b.CHR_NAMA_VENDOR, 
isnull((select COUNT(INT_CHECKSHEET_ID) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where INT_STATUS = 0 and g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR and LEFT(f.CHR_CREATED_DATE,6) = $date group by g.CHR_NAMA_VENDOR),0) as berhasil,
isnull((select COUNT(INT_CHECKSHEET_ID) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where  g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR and LEFT(f.CHR_CREATED_DATE,6) = $date group by g.CHR_NAMA_VENDOR),0) as semua,
isnull((select (Cast(COUNT(INT_CHECKSHEET_ID) as float)) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where INT_STATUS = 0 and g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR  and LEFT(f.CHR_CREATED_DATE,6) = $date group by g.CHR_NAMA_VENDOR),0)*100/(Cast(COUNT(a.INT_CHECKSHEET_ID) as float)) as hasil
from TT_CHECK_SHEET as a join TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR where LEFT(a.CHR_CREATED_DATE,6) = $date and b.CHR_KODE_VENDOR like '%".$supplier."%' group by b.CHR_NAMA_VENDOR
");
	    	if ($query->num_rows() > 0) {
	            return $query->result();
	        } else {
	            return 0;
	        }
	    }
	    function get_detil($year,$supplier)
	    {
	    	$min = $year.'03';
	    	$max = ($year+1).'04';
	    	$query= $this->db->query("select b.CHR_ID_PART, b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR ,left(a.CHR_CREATED_DATE,6) as Bulan, 
isnull((select COUNT(INT_CHECKSHEET_ID) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where INT_STATUS = 0 and g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR  and left(f.CHR_CREATED_DATE,6) = left(a.CHR_CREATED_DATE,6) group by g.CHR_NAMA_VENDOR),0) as berhasil,
isnull((select COUNT(INT_CHECKSHEET_ID) from TT_CHECK_SHEET as f join TM_STO as g on f.CHR_COMPONENT_ID = g.CHR_ID_PART and f.CHR_KODE_VENDOR = g.CHR_KODE_VENDOR where  g.CHR_NAMA_VENDOR = b.CHR_NAMA_VENDOR and left(f.CHR_CREATED_DATE,6) = left(a.CHR_CREATED_DATE,6) group by g.CHR_NAMA_VENDOR),0) as semua
from TT_CHECK_SHEET as a join TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR where left(a.CHR_CREATED_DATE,6) < '".$max."' and left(a.CHR_CREATED_DATE,6) > '".$min."' and b.CHR_KODE_VENDOR like '%".$supplier."%' group by  b.CHR_NAMA_PART,b.CHR_NAMA_VENDOR,b.CHR_ID_PART,left(a.CHR_CREATED_DATE,6)");
	    	return $query->result();
	    }
	    function get_supplier()
	    {
	    	$query= $this->db->query("select a.CHR_KODE_VENDOR,a.CHR_NAMA_VENDOR from TM_STO as a group by a.CHR_NAMA_VENDOR,a.CHR_KODE_VENDOR");
	    	return $query->result();
	    }

	    function get_supplier_ck($year,$supplier)
	    {
	    	$min = $year.'03';
	    	$max = ($year+1).'04';
	    	$query= $this->db->query("select b.CHR_NAMA_VENDOR from TT_CHECK_SHEET as a join TM_STO as b on 
a.CHR_COMPONENT_ID = b.CHR_ID_PART and a.CHR_KODE_VENDOR = b.CHR_KODE_VENDOR 
where left(a.CHR_CREATED_DATE,6) < '".$max."'and left(a.CHR_CREATED_DATE,6) >'".$min."' and b.CHR_KODE_VENDOR like '%".$supplier."%'
group by b.CHR_NAMA_VENDOR ");
	    	return $query->result();
	    	
	    }
	    
	}
?>