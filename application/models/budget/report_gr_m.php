<?php

class report_gr_m extends CI_Model {

    private $table = 'BDGT_TM_BUDGET_CAPEX';

    function get_user_dept($id_dept){
        $kode_dept_ais = $this->db->query("SELECT CHR_DEPT
                                           FROM TM_DEPT
                                           WHERE INT_ID_DEPT = '$id_dept'")->row();
        
        return $kode_dept_ais;
    }
    
    function get_user_sect($id_sect){
        $kode_sect_ais = $this->db->query("SELECT CHR_SECTION
                                           FROM TM_SECTION
                                           WHERE INT_ID_SECTION = '$id_sect'")->row();
        
        return $kode_sect_ais;
    }
    
    function get_budget_type(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $bgt_type = $bgt_aii->query("SELECT CHR_BUDGET_TYPE, 
                                            CHR_BUDGET_TYPE_DESC
                                     FROM BDGT_TM_BUDGET_TYPE 
                                     WHERE CHR_FLG_DELETE <> 1")->result();
        return $bgt_type;
    }
    
    function get_all_dept(){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        $all_dept = $bgt_aii->query("SELECT CHR_KODE_DEPARTMENT, CHR_DEPARTMENT_DESCRIPTION
                                    FROM BDGT_TM_DEPARTMENT")->result();
        return $all_dept;
    }
    
    function get_all_sect($year, $bgt_type, $kode_dept){
        $bgt_aii = $this->load->database("bgt_aii", TRUE);
        if($bgt_type == 'CAPEX'){
            $all_sect = $bgt_aii->query("SELECT DISTINCT CHR_KODE_SECTION
                                        FROM BDGT_TM_BUDGET_CAPEX
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND CHR_KODE_TYPE_BUDGET = 'CAPEX'
                                        AND CHR_TAHUN_BUDGET = '$year'")->result();
            return $all_sect;
        } else {
            $all_sect = $bgt_aii->query("SELECT DISTINCT CHR_KODE_SECTION
                                        FROM BDGT_TM_BUDGET_EXPENSE
                                        WHERE CHR_KODE_DEPARTMENT = '$kode_dept'
                                        AND CHR_KODE_TYPE_BUDGET = '$bgt_type'
                                        AND CHR_TAHUN_BUDGET = '$year'")->result();
            return $all_sect;
        }
    }
    
	function get_gr_actual_expense($year_bgt, $year_end_bgt, $bgt_type, $kode_dept, $kode_sect){
		$bgt_aii = $this->load->database("bgt_aii", TRUE);
		if($kode_sect == NULL || $kode_sect == ''){
			$usage = $bgt_aii->query("select case when CHR_SECTION is null then 'TOTAL' else CHR_SECTION end as CHR_SECTION,
									SUM(case when CHR_MONTH = '$year_bgt'+'04' then MNY_TOTAL else 0 end) as MNY_APRIL,
									SUM(case when CHR_MONTH = '$year_bgt'+'05' then MNY_TOTAL else 0 end) as MNY_MAY,
									SUM(case when CHR_MONTH = '$year_bgt'+'06' then MNY_TOTAL else 0 end) as MNY_JUNE,
									SUM(case when CHR_MONTH = '$year_bgt'+'07' then MNY_TOTAL else 0 end) as MNY_JULY,
									SUM(case when CHR_MONTH = '$year_bgt'+'08' then MNY_TOTAL else 0 end) as MNY_AUGUST,
									SUM(case when CHR_MONTH = '$year_bgt'+'09' then MNY_TOTAL else 0 end) as MNY_SEPTEMBER,
									SUM(case when CHR_MONTH = '$year_bgt'+'10' then MNY_TOTAL else 0 end) as MNY_OCTOBER,
									SUM(case when CHR_MONTH = '$year_bgt'+'11' then MNY_TOTAL else 0 end) as MNY_NOVEMBER,
									SUM(case when CHR_MONTH = '$year_bgt'+'12' then MNY_TOTAL else 0 end) as MNY_DECEMBER,
									SUM(case when CHR_MONTH = '$year_end_bgt'+'01' then MNY_TOTAL else 0 end) as MNY_JANUARY,
									SUM(case when CHR_MONTH = '$year_end_bgt'+'02' then MNY_TOTAL else 0 end) as MNY_FEBRUARY,
									SUM(case when CHR_MONTH = '$year_end_bgt'+'03' then MNY_TOTAL else 0 end) as MNY_MARCH,
									SUM(case when CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$year_bgt'+'04') and CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$year_end_bgt'+'03') then MNY_TOTAL else 0 end) as MNY_TOTAL_AMOUNT
									from (
									select DISTINCT CASE WHEN A.CHR_BDGT_SEC IS NULL THEN 'zOTHER' ELSE A.CHR_BDGT_SEC END as CHR_SECTION, 
										LEFT(A.BUDAT,6) as CHR_MONTH, 
										sum(A.DMBTR) as MNY_TOTAL
									from
									BDGT_TT_REPORT_EXPENSES as A 
									left join BDGT_TM_GL_ACCOUNT as B on A.SAKTO = B.CHR_GL_ACCOUNT_CROP
									left join BDGT_TM_BUDGET_TYPE as C on B.CHR_KODE_CATEGORY = C.CHR_BUDGET_TYPE 
									left join BDGT_TM_FISCAL_YEAR as D on LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_START or  LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_END
									where D.CHR_FISCAL_YEAR = '$year_bgt'+' - '+ '$year_end_bgt' 
									and A.CHR_BDGT_DEPT LIKE '%'+'$kode_dept'+'%' 
									--and A.CHR_BDGT_SEC LIKE '%'+'$kode_sect'+'%'
									--and A.CHR_BDGT_SEC IS NOT NULL 
									and C.CHR_BUDGET_TYPE = '$bgt_type'
									GROUP BY A.CHR_BDGT_SEC, A.BUDAT
									) summ
									GROUP BY ROLLUP(CHR_SECTION)")->result();
		} else {
			$usage = $bgt_aii->query("select case when CHR_SECTION is null then 'TOTAL' else CHR_SECTION end as CHR_SECTION,
									SUM(case when CHR_MONTH = '$year_bgt'+'04' then MNY_TOTAL else 0 end) as MNY_APRIL,
									SUM(case when CHR_MONTH = '$year_bgt'+'05' then MNY_TOTAL else 0 end) as MNY_MAY,
									SUM(case when CHR_MONTH = '$year_bgt'+'06' then MNY_TOTAL else 0 end) as MNY_JUNE,
									SUM(case when CHR_MONTH = '$year_bgt'+'07' then MNY_TOTAL else 0 end) as MNY_JULY,
									SUM(case when CHR_MONTH = '$year_bgt'+'08' then MNY_TOTAL else 0 end) as MNY_AUGUST,
									SUM(case when CHR_MONTH = '$year_bgt'+'09' then MNY_TOTAL else 0 end) as MNY_SEPTEMBER,
									SUM(case when CHR_MONTH = '$year_bgt'+'10' then MNY_TOTAL else 0 end) as MNY_OCTOBER,
									SUM(case when CHR_MONTH = '$year_bgt'+'11' then MNY_TOTAL else 0 end) as MNY_NOVEMBER,
									SUM(case when CHR_MONTH = '$year_bgt'+'12' then MNY_TOTAL else 0 end) as MNY_DECEMBER,
									SUM(case when CHR_MONTH = '$year_end_bgt'+'01' then MNY_TOTAL else 0 end) as MNY_JANUARY,
									SUM(case when CHR_MONTH = '$year_end_bgt'+'02' then MNY_TOTAL else 0 end) as MNY_FEBRUARY,
									SUM(case when CHR_MONTH = '$year_end_bgt'+'03' then MNY_TOTAL else 0 end) as MNY_MARCH,
									SUM(case when CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$year_bgt'+'04') and CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$year_end_bgt'+'03') then MNY_TOTAL else 0 end) as MNY_TOTAL_AMOUNT
									from (
									select DISTINCT CASE WHEN A.CHR_BDGT_SEC IS NULL THEN 'zOTHER' ELSE A.CHR_BDGT_SEC END as CHR_SECTION, 
										LEFT(A.BUDAT,6) as CHR_MONTH, 
										sum(A.DMBTR) as MNY_TOTAL
									from
									BDGT_TT_REPORT_EXPENSES as A 
									left join BDGT_TM_GL_ACCOUNT as B on A.SAKTO = B.CHR_GL_ACCOUNT_CROP
									left join BDGT_TM_BUDGET_TYPE as C on B.CHR_KODE_CATEGORY = C.CHR_BUDGET_TYPE 
									left join BDGT_TM_FISCAL_YEAR as D on LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_START or  LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_END
									where D.CHR_FISCAL_YEAR = '$year_bgt'+' - '+ '$year_end_bgt' 
									and A.CHR_BDGT_DEPT LIKE '%'+'$kode_dept'+'%' 
									and A.CHR_BDGT_SEC LIKE '%'+'$kode_sect'+'%'
									--and A.CHR_BDGT_SEC IS NOT NULL 
									and C.CHR_BUDGET_TYPE = '$bgt_type'
									GROUP BY A.CHR_BDGT_SEC, A.BUDAT
									) summ
									GROUP BY ROLLUP(CHR_SECTION)")->result();
		}
		
        return $usage;
        
    }
	
	function get_gr_actual_expense_detail($year_bgt, $year_end_bgt, $bgt_type, $kode_dept, $kode_sect){
		$bgt_aii = $this->load->database("bgt_aii", TRUE);
		if($kode_sect == NULL || $kode_sect == ''){
			$usage = $bgt_aii->query("select A.BEDNR as CHR_NO_PR, A.CHR_NO_BUDGET as CHR_NO_BUDGET, A.TXZ01 as CHR_ITEM_DESC, A.SAKTO as CHR_GL_ACCOUNT,
									A.KOSTL as CHR_COST_CENTER_SAP, A.BUDAT as CHR_GR_DATE, A.DMBTR as MNY_AMOUNT, A.NAME1 as CHR_SUPPLIER, A.AFNAM as CHR_PIC 
									from
									BDGT_TT_REPORT_EXPENSES as A 
									left join BDGT_TM_GL_ACCOUNT as B on A.SAKTO = B.CHR_GL_ACCOUNT_CROP
									left join BDGT_TM_BUDGET_TYPE as C on B.CHR_KODE_CATEGORY = C.CHR_BUDGET_TYPE 
									left join BDGT_TM_FISCAL_YEAR as D on LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_START or  LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_END
									where D.CHR_FISCAL_YEAR = '$year_bgt'+' - '+ '$year_end_bgt' 
									and A.CHR_BDGT_DEPT LIKE '%'+'$kode_dept'+'%' 
									--and A.CHR_BDGT_SEC LIKE '%'+'$kode_sect'+'%'
									--and A.CHR_BDGT_SEC IS NOT NULL 
									and C.CHR_BUDGET_TYPE = '$bgt_type'
									and CAST (A.BUDAT as datetime) between Cast('$year_bgt'+'0401' as datetime) and Cast('$year_end_bgt'+'0331' as datetime)")->result();
		} else {
			$usage = $bgt_aii->query("select A.BEDNR as CHR_NO_PR, A.CHR_NO_BUDGET as CHR_NO_BUDGET, A.TXZ01 as CHR_ITEM_DESC, A.SAKTO as CHR_GL_ACCOUNT,
									A.KOSTL as CHR_COST_CENTER_SAP, A.BUDAT as CHR_GR_DATE, A.DMBTR as MNY_AMOUNT, A.NAME1 as CHR_SUPPLIER, A.AFNAM as CHR_PIC 
									from
									BDGT_TT_REPORT_EXPENSES as A 
									left join BDGT_TM_GL_ACCOUNT as B on A.SAKTO = B.CHR_GL_ACCOUNT_CROP
									left join BDGT_TM_BUDGET_TYPE as C on B.CHR_KODE_CATEGORY = C.CHR_BUDGET_TYPE 
									left join BDGT_TM_FISCAL_YEAR as D on LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_START or  LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_END
									where D.CHR_FISCAL_YEAR = '$year_bgt'+' - '+ '$year_end_bgt' 
									and A.CHR_BDGT_DEPT LIKE '%'+'$kode_dept'+'%' 
									and A.CHR_BDGT_SEC LIKE '%'+'$kode_sect'+'%'
									--and A.CHR_BDGT_SEC IS NOT NULL 
									and C.CHR_BUDGET_TYPE = '$bgt_type'
									and CAST (A.BUDAT as datetime) between Cast('$year_bgt'+'0401' as datetime) and Cast('$year_end_bgt'+'0331' as datetime)")->result();
		}
		
        return $usage;
        
    }
	
	
	
	function get_gr_actual_capex($year_bgt, $year_end_bgt, $bgt_type, $kode_dept, $kode_sect){
		$bgt_aii = $this->load->database("bgt_aii", TRUE);
		if($kode_sect == NULL || $kode_sect == ''){
			$usage = $bgt_aii->query("select case when CHR_SECTION is null then 'TOTAL' else CHR_SECTION end as CHR_SECTION,
										SUM(case when CHR_MONTH = '$year_bgt'+'04' then MNY_TOTAL else 0 end) as MNY_APRIL,
										SUM(case when CHR_MONTH = '$year_bgt'+'05' then MNY_TOTAL else 0 end) as MNY_MAY,
										SUM(case when CHR_MONTH = '$year_bgt'+'06' then MNY_TOTAL else 0 end) as MNY_JUNE,
										SUM(case when CHR_MONTH = '$year_bgt'+'07' then MNY_TOTAL else 0 end) as MNY_JULY,
										SUM(case when CHR_MONTH = '$year_bgt'+'08' then MNY_TOTAL else 0 end) as MNY_AUGUST,
										SUM(case when CHR_MONTH = '$year_bgt'+'09' then MNY_TOTAL else 0 end) as MNY_SEPTEMBER,
										SUM(case when CHR_MONTH = '$year_bgt'+'10' then MNY_TOTAL else 0 end) as MNY_OCTOBER,
										SUM(case when CHR_MONTH = '$year_bgt'+'11' then MNY_TOTAL else 0 end) as MNY_NOVEMBER,
										SUM(case when CHR_MONTH = '$year_bgt'+'12' then MNY_TOTAL else 0 end) as MNY_DECEMBER,
										SUM(case when CHR_MONTH = '$year_end_bgt'+'01' then MNY_TOTAL else 0 end) as MNY_JANUARY,
										SUM(case when CHR_MONTH = '$year_end_bgt'+'02' then MNY_TOTAL else 0 end) as MNY_FEBRUARY,
										SUM(case when CHR_MONTH = '$year_end_bgt'+'03' then MNY_TOTAL else 0 end) as MNY_MARCH,
										SUM(case when CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$year_bgt'+'04') and CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$year_end_bgt'+'03') then MNY_TOTAL else 0 end) as MNY_TOTAL_AMOUNT
										from (
										select DISTINCT CASE WHEN A.CHR_BDGT_SEC IS NULL THEN 'zOTHER' ELSE A.CHR_BDGT_SEC END as CHR_SECTION, 
											LEFT(A.BUDAT,6) as CHR_MONTH, 
											sum(A.GR_VAL) as MNY_TOTAL
										from
										BDGT_TT_REPORT_CAPEX as A 
										left join BDGT_TM_GL_ACCOUNT as B on A.SAKTO = B.CHR_GL_ACCOUNT_CROP
										left join BDGT_TM_BUDGET_TYPE as C on B.CHR_KODE_CATEGORY = C.CHR_BUDGET_TYPE 
										left join BDGT_TM_FISCAL_YEAR as D on LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_START or  LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_END
										where D.CHR_FISCAL_YEAR = '$year_bgt'+' - '+ '$year_end_bgt' 
										and A.CHR_BDGT_DEPT LIKE '%'+'$kode_dept'+'%' 
										--and A.CHR_BDGT_SEC LIKE '%'+'$kode_sect'+'%'
										--and A.CHR_BDGT_SEC IS NOT NULL 
										--and C.CHR_BUDGET_TYPE = '$bgt_type'
										GROUP BY A.CHR_BDGT_SEC, A.BUDAT
										) summ
										GROUP BY ROLLUP(CHR_SECTION)")->result();
		} else {
			$usage = $bgt_aii->query("select case when CHR_SECTION is null then 'TOTAL' else CHR_SECTION end as CHR_SECTION,
										SUM(case when CHR_MONTH = '$year_bgt'+'04' then MNY_TOTAL else 0 end) as MNY_APRIL,
										SUM(case when CHR_MONTH = '$year_bgt'+'05' then MNY_TOTAL else 0 end) as MNY_MAY,
										SUM(case when CHR_MONTH = '$year_bgt'+'06' then MNY_TOTAL else 0 end) as MNY_JUNE,
										SUM(case when CHR_MONTH = '$year_bgt'+'07' then MNY_TOTAL else 0 end) as MNY_JULY,
										SUM(case when CHR_MONTH = '$year_bgt'+'08' then MNY_TOTAL else 0 end) as MNY_AUGUST,
										SUM(case when CHR_MONTH = '$year_bgt'+'09' then MNY_TOTAL else 0 end) as MNY_SEPTEMBER,
										SUM(case when CHR_MONTH = '$year_bgt'+'10' then MNY_TOTAL else 0 end) as MNY_OCTOBER,
										SUM(case when CHR_MONTH = '$year_bgt'+'11' then MNY_TOTAL else 0 end) as MNY_NOVEMBER,
										SUM(case when CHR_MONTH = '$year_bgt'+'12' then MNY_TOTAL else 0 end) as MNY_DECEMBER,
										SUM(case when CHR_MONTH = '$year_end_bgt'+'01' then MNY_TOTAL else 0 end) as MNY_JANUARY,
										SUM(case when CHR_MONTH = '$year_end_bgt'+'02' then MNY_TOTAL else 0 end) as MNY_FEBRUARY,
										SUM(case when CHR_MONTH = '$year_end_bgt'+'03' then MNY_TOTAL else 0 end) as MNY_MARCH,
										SUM(case when CONVERT(INT, CHR_MONTH) >= CONVERT(INT, '$year_bgt'+'04') and CONVERT(INT, CHR_MONTH) <= CONVERT(INT, '$year_end_bgt'+'03') then MNY_TOTAL else 0 end) as MNY_TOTAL_AMOUNT
										from (
										select DISTINCT CASE WHEN A.CHR_BDGT_SEC IS NULL THEN 'zOTHER' ELSE A.CHR_BDGT_SEC END as CHR_SECTION, 
											LEFT(A.BUDAT,6) as CHR_MONTH, 
											sum(A.GR_VAL) as MNY_TOTAL
										from
										BDGT_TT_REPORT_CAPEX as A 
										left join BDGT_TM_GL_ACCOUNT as B on A.SAKTO = B.CHR_GL_ACCOUNT_CROP
										left join BDGT_TM_BUDGET_TYPE as C on B.CHR_KODE_CATEGORY = C.CHR_BUDGET_TYPE 
										left join BDGT_TM_FISCAL_YEAR as D on LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_START or  LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_END
										where D.CHR_FISCAL_YEAR = '$year_bgt'+' - '+ '$year_end_bgt' 
										and A.CHR_BDGT_DEPT LIKE '%'+'$kode_dept'+'%' 
										and A.CHR_BDGT_SEC LIKE '%'+'$kode_sect'+'%'
										--and A.CHR_BDGT_SEC IS NOT NULL 
										--and C.CHR_BUDGET_TYPE = '$bgt_type'
										GROUP BY A.CHR_BDGT_SEC, A.BUDAT
										) summ
										GROUP BY ROLLUP(CHR_SECTION)")->result();
		}
		return $usage;
        
    }
	
	function get_gr_actual_capex_detail($year_bgt, $year_end_bgt, $bgt_type, $kode_dept, $kode_sect){
		$bgt_aii = $this->load->database("bgt_aii", TRUE);
		if($kode_sect == NULL || $kode_sect == ''){
			$usage = $bgt_aii->query("select  A.BEDNR as CHR_NO_PR, A.CHR_NO_BUDGET as CHR_NO_BUDGET, A.TXT50 as CHR_ITEM_DESC, A.SAKTO as CHR_GL_ACCOUNT,
										A.KOSTL as CHR_COST_CENTER_SAP, A.BUDAT as CHR_GR_DATE, A.GR_VAL as MNY_AMOUNT, A.NAME1 as CHR_SUPPLIER, A.AFNAM as CHR_PIC 
										from
										BDGT_TT_REPORT_CAPEX as A 
										left join BDGT_TM_GL_ACCOUNT as B on A.SAKTO = B.CHR_GL_ACCOUNT_CROP
										left join BDGT_TM_BUDGET_TYPE as C on B.CHR_KODE_CATEGORY = C.CHR_BUDGET_TYPE 
										left join BDGT_TM_FISCAL_YEAR as D on LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_START or  LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_END
										where D.CHR_FISCAL_YEAR = '$year_bgt'+' - '+ '$year_end_bgt' 
										and A.CHR_BDGT_DEPT LIKE '%'+'$kode_dept'+'%' 
										--and A.CHR_BDGT_SEC LIKE '%'+'$kode_sect'+'%'
										--and A.CHR_BDGT_SEC IS NOT NULL 
										--and C.CHR_BUDGET_TYPE = '$bgt_type'
										and CAST (A.BUDAT as datetime) between Cast('$year_bgt'+'0401' as datetime) and Cast('$year_end_bgt'+'0331' as datetime)")->result();
		} else {
			$usage = $bgt_aii->query("select  A.BEDNR as CHR_NO_PR, A.CHR_NO_BUDGET as CHR_NO_BUDGET, A.TXT50 as CHR_ITEM_DESC, A.SAKTO as CHR_GL_ACCOUNT,
										A.KOSTL as CHR_COST_CENTER_SAP, A.BUDAT as CHR_GR_DATE, A.GR_VAL as MNY_AMOUNT, A.NAME1 as CHR_SUPPLIER, A.AFNAM as CHR_PIC 
										from
										BDGT_TT_REPORT_CAPEX as A 
										left join BDGT_TM_GL_ACCOUNT as B on A.SAKTO = B.CHR_GL_ACCOUNT_CROP
										left join BDGT_TM_BUDGET_TYPE as C on B.CHR_KODE_CATEGORY = C.CHR_BUDGET_TYPE 
										left join BDGT_TM_FISCAL_YEAR as D on LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_START or  LEFT(A.BUDAT, 4) = D.CHR_FISCAL_YEAR_END
										where D.CHR_FISCAL_YEAR = '$year_bgt'+' - '+ '$year_end_bgt' 
										and A.CHR_BDGT_DEPT LIKE '%'+'$kode_dept'+'%' 
										and A.CHR_BDGT_SEC LIKE '%'+'$kode_sect'+'%'
										--and A.CHR_BDGT_SEC IS NOT NULL 
										--and C.CHR_BUDGET_TYPE = '$bgt_type'
										and CAST (A.BUDAT as datetime) between Cast('$year_bgt'+'0401' as datetime) and Cast('$year_end_bgt'+'0331' as datetime)")->result();
		}
		return $usage;
        
    }

}

?>
