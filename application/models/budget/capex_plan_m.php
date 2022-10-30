<?php

class capex_plan_m extends CI_Model {

    private $table = 'TT_BUDGET';

    //show capex plan
    function get_capex_plan_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET,a.INT_NO_BUDGET_CPX, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, 
            c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY_DESC, k.CHR_BUDGET_CATEGORY,k.CHR_BUDGET_CATEGORY_DESC,
            d.CHR_DEPT_DESC, a.DEC_TOTAL
            from TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d,
                 TM_BUDGET_CATEGORY k,TM_BUDGET_SUB_CATEGORY l
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY");
        return $query->result();
    }
    
    //get capex temp by root
//    function get_capex_plan_to_commit_by_admin($fiscal) {
//        $query = $this->db->query("select f.CHR_GROUP_DEPT,f.CHR_GROUP_DEPT_DESC, 
//            c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,f.INT_ID_GROUP_DEPT, b.INT_STATUS,
//            sum( a.DEC_TOTAL ) as total
//             from TT_BUDGET a, TT_BUDGET_CAPEX b, TM_FISCAL c,TM_DEPT d, TM_SECTION e,TM_GROUP_DEPT f,TM_DIVISION g
//             where a.INT_NO_BUDGET_CPX = b.INT_NO_BUDGET_CPX and b.INT_APPROVE1 = 1 and b.INT_APPROVE2 = 1 and b.INT_APPROVE3 = 1 and
//             a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR and a.INT_ID_SECTION = e.INT_ID_SECTION
//             and e.INT_ID_DEPT = d.INT_ID_DEPT and d.INT_ID_GROUP_DEPT = f.INT_ID_GROUP_DEPT and f.INT_ID_DIVISION = g.INT_ID_DIVISION 
//             and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' 
//             group by f.CHR_GROUP_DEPT_DESC, b.INT_STATUS, c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,f.INT_ID_GROUP_DEPT,f.CHR_GROUP_DEPT");
//        return $query->result();
//    }

    //get data by section to report ,,,can....
    function get_capex_plan_by_section($section, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR,c.INT_ID_DEPT,
            c.CHR_SECTION,c.CHR_SECTION_DESC,d.CHR_BUDGET_SUB_CATEGORY_DESC, e.CHR_PURPOSE_DESC,d.INT_ID_BUDGET_CATEGORY,f.CHR_BUDGET_CATEGORY_DESC,
            CASE h.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, 
            CASE h.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE h.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL,
            CASE h.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW,
            LEFT(h.CHR_DEPCI_DATE,4) as tahun,
            CASE RIGHT(h.CHR_DEPCI_DATE,2) 
            WHEN '01' THEN 'Jan' 
            WHEN '02' THEN 'Feb' 
            WHEN '03' THEN 'Mar' 
            WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' 
            WHEN '06' THEN 'Jun' 
            WHEN '07' THEN 'Jul' 
            WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' 
            WHEN '10' THEN 'Oct'
            WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END +'-'+ LEFT(h.CHR_DEPCI_DATE,4) AS depresiasi,
            a.DEC_TOTAL, g.CHR_DEPT, h.INT_MONTH_PLAN
            from TT_BUDGET a, TT_BUDGET_CAPEX h,TM_FISCAL b, TM_SECTION c, TM_BUDGET_SUB_CATEGORY d, TM_PURPOSE e, TM_BUDGET_CATEGORY f, TM_DEPT g
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_SECTION = c.INT_ID_SECTION and c.INT_ID_DEPT = g.INT_ID_DEPT
            and a.INT_ID_SECTION = '" . $section . "' and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and a.INT_NO_BUDGET_CPX = h.INT_NO_BUDGET_CPX
            and h.INT_ID_PURPOSE=e.INT_ID_PURPOSE and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY and d.INT_ID_BUDGET_CATEGORY=f.INT_ID_BUDGET_CATEGORY and h.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_capex_plan_by_manager($dept, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET,a.INT_NO_BUDGET_CPX, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, f.CHR_PURPOSE_DESC,
            c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY_DESC, k.CHR_BUDGET_CATEGORY,k.CHR_BUDGET_CATEGORY_DESC,
            d.CHR_DEPT_DESC, a.DEC_TOTAL,
            CASE e.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, 
            CASE e.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE e.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL,
            CASE e.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW,
            LEFT(e.CHR_DEPCI_DATE,4) as tahun,
            CASE RIGHT(e.CHR_DEPCI_DATE,2) 
            WHEN '01' THEN 'Jan' 
            WHEN '02' THEN 'Feb' 
            WHEN '03' THEN 'Mar' 
            WHEN '04' THEN 'Apr' 
            WHEN '05' THEN 'May' 
            WHEN '06' THEN 'Jun' 
            WHEN '07' THEN 'Jul' 
            WHEN '08' THEN 'Aug' 
            WHEN '09' THEN 'Sep' 
            WHEN '10' THEN 'Oct'
            WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END +'-'+ LEFT(e.CHR_DEPCI_DATE,4) AS depresiasi,
            e.INT_MONTH_PLAN
            from TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TT_BUDGET_CAPEX e, TM_PURPOSE f,
                 TM_BUDGET_CATEGORY k,TM_BUDGET_SUB_CATEGORY l
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION
                and c.INT_ID_DEPT = d.INT_ID_DEPT and c.INT_ID_DEPT = '" . $dept . "'
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and a.INT_NO_BUDGET_CPX = e.INT_NO_BUDGET_CPX and e.INT_ID_PURPOSE = f.INT_ID_PURPOSE");
        return $query->result();
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function get_data($no_budget) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, 
            c.CHR_SECTION_DESC, d.CHR_DEPT_DESC, l.CHR_BUDGET_SUB_CATEGORY_DESC,k.CHR_BUDGET_CATEGORY_DESC, g.CHR_PURPOSE_DESC,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, 
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_GROUP_DEPT e, TM_DIVISION f, TM_PURPOSE g,
                 TM_BUDGET_GROUP h,TM_BUDGET_SUBGROUP i,TM_BUDGET_TYPE j,TM_BUDGET_CATEGORY k,TM_BUDGET_SUB_CATEGORY l
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and a.INT_ID_DEPT = d.INT_ID_DEPT
                and a.INT_ID_GROUP_DEPT = e.INT_ID_GROUP_DEPT
                and a.INT_ID_DIVISION = f.INT_ID_DIVISION
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_ID_BUDGET_GROUP = h.INT_ID_BUDGET_GROUP
                and a.INT_ID_BUDGET_SUBGROUP = i.INT_ID_BUDGET_SUBGROUP
                and a.INT_ID_BUDGET_TYPE = j.INT_ID_BUDGET_TYPE
                and a.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and a.BIT_FLG_DEL = 0 and a.INT_NO_BUDGET_CPX = '" . $no_budget . "'");
        return $query;
    }

    function get_data_capex($no_budget) {
        $query = $this->db->query("select a.INT_NO_BUDGET, a.CHR_BUDGET_NAME, a.DEC_TOTAL,b.INT_QUANTITY,
            a.INT_ID_SECTION, a.INT_ID_FISCAL_YEAR, a.DEC_TOTAL - a.DEC_TOTAL * 0.3 as LIMIT
            from TT_BUDGET a,TT_BUDGET_CAPEX b, TM_SECTION c
            where a.INT_ID_SECTION = c.INT_ID_SECTION
                and b.BIT_FLG_DEL = 0 and a.INT_NO_BUDGET_CPX = b.INT_NO_BUDGET_CPX and a.INT_NO_BUDGET_CPX = '" . $no_budget . "'");
        return $query;
    }
    
    function get_total_capex_plan_by_manager($id_dept ,$id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT and
                d.INT_ID_DEPT = '" . $id_dept . "'")->row_array();
        $total_plan = $query['total_plan'];
        return $total_plan;
    }
    
    function get_total_capex_plan_by_gm($id_groupdept ,$id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from 
            TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_GROUP_DEPT e
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and d.INT_ID_GROUP_DEPT = e.INT_ID_GROUP_DEPT and
                e.INT_ID_GROUP_DEPT = '" . $id_groupdept . "'")->row_array();
        $total_plan = $query['total_plan'];
        return $total_plan;
    }
    
    function get_total_capex_plan_by_supervisor($id_section ,$id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from 
            TT_BUDGET a,TM_FISCAL b, TM_SECTION c
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION  and
                c.INT_ID_SECTION = '" . $id_section . "'")->row_array();
        $total = $query['total_plan'];
        return $total;
    }
    
    function get_total_capex_plan_by_dept($id_dept ,$id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from 
            TT_BUDGET a,TM_FISCAL b, TM_SECTION c, TM_DEPT d
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION  and
                c.INT_ID_DEPT = d.INT_ID_DEPT  and
                d.INT_ID_DEPT = '" . $id_dept . "'")->row_array();
        $total_plan = $query['total_plan'];
        return $total_plan;
    }
    
    function get_total_capex_plan_by_admin($id_fiscal){
        $query = $this->db->query("select sum(a.DEC_TOTAL) as total_plan from 
            TT_BUDGET a,TM_FISCAL b
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $id_fiscal . "'")->row_array();
        $total_plan = $query['total_plan'];
        return $total_plan;
    }
    
    function update_capex_plan($data,$id_fiscal){
        $this->db->select('INT_NO_BUDGET_CPX');
        $this->db->from('TT_BUDGET');
        $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
        $query_budget = $this->db->get()->result_array();
        
        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX', $row['INT_NO_BUDGET_CPX']);
            $this->db->update('TT_BUDGET_CAPEX', $data);
        }
    }

    function generated_id() {
        $count_id = $this->db->query("select count(INT_NO_BUDGET_CPX) as 'id' from TT_BUDGET where LEFT(INT_NO_BUDGET_CPX,2) = RIGHT(year(getdate()),2)")->row_array();
        $jumlah = $count_id['id'];
        intval($count_id);
        $jumlah += 1;
        strval($jumlah);

        if (strlen($jumlah) == 1) {
            $id_akhir = '000' . $jumlah;
        } else if (strlen($jumlah) == 2) {
            $id_akhir = '00' . $jumlah;
        } else if (strlen($jumlah) == 3) {
            $id_akhir = '0' . $jumlah;
        } else if (strlen($jumlah) == 4) {
            $id_akhir = $jumlah;
        }

        return $id_akhir;
    }

}

?>
