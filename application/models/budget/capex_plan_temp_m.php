<?php

class capex_plan_temp_m extends CI_Model {

    private $TW_CAPEX = 'TW_BUDGET_CAPEX';

    //manage capex temp by admin, will be approve
    function get_capex_plan_temp_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION,d.CHR_BUDGET_SUB_CATEGORY_DESC,f.CHR_BUDGET_CATEGORY, e.CHR_PURPOSE_DESC,d.INT_ID_BUDGET_CATEGORY,f.CHR_BUDGET_CATEGORY_DESC,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, 
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            g.CHR_DEPT,a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_BUDGET_SUB_CATEGORY d, TM_PURPOSE e, TM_BUDGET_CATEGORY f,TM_DEPT g
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_SECTION = c.INT_ID_SECTION
            and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and c.INT_ID_DEPT = g.INT_ID_DEPT and a.INT_STATUS = 0
            and a.INT_ID_PURPOSE=e.INT_ID_PURPOSE and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY and d.INT_ID_BUDGET_CATEGORY=f.INT_ID_BUDGET_CATEGORY and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //manage capex temp by supervisor, will be approve
    function get_capex_plan_temp_by_supervisor($section, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION,d.CHR_BUDGET_SUB_CATEGORY_DESC,f.CHR_BUDGET_CATEGORY, e.CHR_PURPOSE_DESC,d.INT_ID_BUDGET_CATEGORY,f.CHR_BUDGET_CATEGORY_DESC,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, 
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            g.CHR_DEPT,a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_BUDGET_SUB_CATEGORY d, TM_PURPOSE e, TM_BUDGET_CATEGORY f,TM_DEPT g
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_SECTION = c.INT_ID_SECTION and a.INT_STATUS = 0
            and a.INT_ID_SECTION = '" . $section . "' and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and c.INT_ID_DEPT = g.INT_ID_DEPT
            and a.INT_ID_PURPOSE=e.INT_ID_PURPOSE and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY and d.INT_ID_BUDGET_CATEGORY=f.INT_ID_BUDGET_CATEGORY and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //manage capex temp by manager, will be approve
    function get_capex_plan_temp_by_manager($dept, $fiscal) {
        $query = $this->db->query("select d.CHR_SECTION,max(a.INT_APPROVE1) as INT_APPROVE1, 
            c.INT_ID_FISCAL_YEAR,d.INT_ID_SECTION,
            sum( a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY ) as total
             from TW_BUDGET_CAPEX a,TM_FISCAL c,TM_SECTION d
             where 
             a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR 
             and a.INT_ID_SECTION = d.INT_ID_SECTION 
             and a.INT_STATUS = 0 and a.INT_APPROVE0 = 1
             and d.INT_ID_DEPT = '" . $dept . "' and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
             group by c.INT_ID_FISCAL_YEAR,d.INT_ID_SECTION,d.CHR_SECTION");
        return $query->result();
    }

    function get_capex_plan_temp_detail_by_manager($dept, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP,a.INT_APPROVE1, c.CHR_SECTION, a.CHR_BUDGET_NAME, INT_REVISE,
            a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT 
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_BUDGET_SUB_CATEGORY d, TM_PURPOSE e, TM_BUDGET_CATEGORY f,TM_DEPT g
            where 
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR 
            and a.INT_STATUS = 0 and a.INT_APPROVE0 = 1
            and  a.INT_ID_SECTION = c.INT_ID_SECTION
            and c.INT_ID_DEPT = g.INT_ID_DEPT and g.INT_ID_DEPT = '" . $dept . "' and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and c.INT_ID_DEPT = g.INT_ID_DEPT
            and a.INT_ID_PURPOSE=e.INT_ID_PURPOSE and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY and d.INT_ID_BUDGET_CATEGORY=f.INT_ID_BUDGET_CATEGORY 
            and a.BIT_FLG_DEL = 0 order by a.INT_ID_SECTION asc");
        return $query->result();
    }

    //manage capex temp by gm, will be approve
    function get_capex_plan_temp_by_gm($groupdept, $fiscal) {
        $query = $this->db->query("select d.CHR_DEPT, max(a.INT_APPROVE2) as INT_APPROVE2,
            c.INT_ID_FISCAL_YEAR,d.INT_ID_DEPT,
            sum( a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY ) as total
             from TW_BUDGET_CAPEX a,TM_FISCAL c,TM_DEPT d,TM_SECTION e,TM_GROUP_DEPT f
             where 
             a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR  
             and a.INT_STATUS = 0 and a.INT_APPROVE0 = 1
             and a.INT_ID_SECTION = e.INT_ID_SECTION and f.INT_ID_GROUP_DEPT = '" . $groupdept . "'
             and e.INT_ID_DEPT = d.INT_ID_DEPT and d.INT_ID_GROUP_DEPT = f.INT_ID_GROUP_DEPT and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
             group by c.INT_ID_FISCAL_YEAR,d.INT_ID_DEPT,d.CHR_DEPT");
        return $query->result();
    }

    function get_capex_plan_temp_detail_by_gm($group_dept, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP,a.INT_APPROVE2, b.CHR_FISCAL_YEAR,c.CHR_SECTION, INT_REVISE,
            a.CHR_BUDGET_NAME,
            a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT 
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_BUDGET_SUB_CATEGORY d, TM_PURPOSE e, TM_BUDGET_CATEGORY f,TM_DEPT g, TM_GROUP_DEPT h
            where
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR 
            and a.INT_STATUS = 0 and a.INT_APPROVE0 = 1
            and a.INT_ID_SECTION = c.INT_ID_SECTION
            and c.INT_ID_DEPT = g.INT_ID_DEPT 
            and g.INT_ID_GROUP_DEPT = h.INT_ID_GROUP_DEPT 
            and h.INT_ID_GROUP_DEPT = '" . $group_dept . "'
            and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' 
            and a.INT_ID_PURPOSE=e.INT_ID_PURPOSE and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY and d.INT_ID_BUDGET_CATEGORY=f.INT_ID_BUDGET_CATEGORY and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //manage capex temp by director, will be approve
    function get_capex_plan_temp_by_director($div, $fiscal) {
        $query = $this->db->query("select f.CHR_GROUP_DEPT, 
            c.INT_ID_FISCAL_YEAR,f.INT_ID_GROUP_DEPT,max(a.INT_APPROVE3) as INT_APPROVE3,
            sum( a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY ) as total
             from TW_BUDGET_CAPEX a,TM_FISCAL c,TM_DEPT d, TM_SECTION e,TM_GROUP_DEPT f,TM_DIVISION g
             where
             a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR  
             and a.INT_STATUS = 0 and a.INT_APPROVE0 = 1
             and a.INT_ID_SECTION = e.INT_ID_SECTION
             and e.INT_ID_DEPT = d.INT_ID_DEPT 
             and d.INT_ID_GROUP_DEPT = f.INT_ID_GROUP_DEPT and f.INT_ID_DIVISION = g.INT_ID_DIVISION 
             and g.INT_ID_DIVISION = '" . $div . "' 
             and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' 
             group by c.INT_ID_FISCAL_YEAR,f.INT_ID_GROUP_DEPT,f.CHR_GROUP_DEPT");
        return $query->result();
    }

    function get_capex_plan_temp_detail_by_director($division, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP,a.INT_APPROVE3, INT_REVISE,
            b.CHR_FISCAL_YEAR,c.CHR_SECTION,  a.CHR_BUDGET_NAME,
            a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT 
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_BUDGET_SUB_CATEGORY d, TM_PURPOSE e, TM_BUDGET_CATEGORY f,TM_DEPT g, TM_GROUP_DEPT h, TM_DIVISION i
            where
            a.INT_ID_FISCAL_YEAR = b.INT_ID_FISCAL_YEAR  
            and a.INT_STATUS = 0 and a.INT_APPROVE0 = 1
            and a.INT_ID_SECTION = c.INT_ID_SECTION
            and c.INT_ID_DEPT = g.INT_ID_DEPT 
            and g.INT_ID_GROUP_DEPT = h.INT_ID_GROUP_DEPT and h.INT_ID_DIVISION = i.INT_ID_DIVISION and i.INT_ID_DIVISION = '" . $division . "'
            and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' 
            and a.INT_ID_PURPOSE=e.INT_ID_PURPOSE and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY and d.INT_ID_BUDGET_CATEGORY=f.INT_ID_BUDGET_CATEGORY and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_capex_plan_temp_to_commit_by_admin($fiscal) {
        $query = $this->db->query("select g.CHR_DIVISION,c.CHR_FISCAL_YEAR,c.INT_ID_FISCAL_YEAR,g.INT_ID_DIVISION, a.INT_STATUS,
            sum( a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY ) as total
             from TW_BUDGET_CAPEX a,TM_FISCAL c,TM_DEPT d, TM_SECTION e,TM_GROUP_DEPT f,TM_DIVISION g
             where 
             a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR
             and a.INT_ID_SECTION = e.INT_ID_SECTION
             and a.INT_STATUS = 0 and a.INT_APPROVE0 = 1
             and e.INT_ID_DEPT = d.INT_ID_DEPT and d.INT_ID_GROUP_DEPT = f.INT_ID_GROUP_DEPT and f.INT_ID_DIVISION = g.INT_ID_DIVISION 
             and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'  
             group by c.CHR_FISCAL_YEAR, a.INT_STATUS ,c.INT_ID_FISCAL_YEAR,g.INT_ID_DIVISION,g.CHR_DIVISION");
        return $query->result();
    }

    function get_capex_plan_temp_detail_to_commit_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, b.CHR_FISCAL_YEAR,c.CHR_SECTION, INT_REVISE,a.CHR_BUDGET_NAME,
            a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT 
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_BUDGET_SUB_CATEGORY d, TM_PURPOSE e, TM_BUDGET_CATEGORY f,TM_DEPT g, TM_GROUP_DEPT h, TM_DIVISION i
            where
            a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_SECTION = c.INT_ID_SECTION
            and c.INT_ID_DEPT = g.INT_ID_DEPT 
            and a.INT_STATUS = 0 and a.INT_APPROVE0 = 1
            and g.INT_ID_GROUP_DEPT = h.INT_ID_GROUP_DEPT and h.INT_ID_DIVISION = i.INT_ID_DIVISION
            and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' 
            and a.INT_ID_PURPOSE=e.INT_ID_PURPOSE and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY and d.INT_ID_BUDGET_CATEGORY=f.INT_ID_BUDGET_CATEGORY and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_stat_commit($fiscal) {
        $query = $this->db->query("select INT_STATUS from TW_BUDGET_CAPEX 
            where INT_ID_FISCAL_YEAR = '" . $fiscal . "' group by INT_STATUS");

        if ($query->num_rows() != 0) {
            $result = $query->row_array();
            return $result['INT_STATUS'];
        } else {
            return 0;
        }
    }

    function get_permit_approve_by_admin($fiscal) {
        $query = $this->db->query("select INT_APPROVE0 from TW_BUDGET_CAPEX 
            where INT_ID_FISCAL_YEAR = '" . $fiscal . "' group by INT_APPROVE0");

        if ($query->num_rows() > 1) {
            $result = $query->row_array();
            return $result['INT_APPROVE0'];
        } else {
            return 0;
        }
    }
    
    
    function get_permit_approve_by_director($fiscal) {
        $query = $this->db->query("select INT_APPROVE2 from TW_BUDGET_CAPEX 
            where INT_ID_FISCAL_YEAR = '" . $fiscal . "' group by INT_APPROVE2");

        if ($query->num_rows() > 1) {
            return 0;
        } else {
            $result = $query->row_array();
            return $result['INT_APPROVE2'];
        }
    }
    
    function get_permit_approve_by_gm($fiscal) {
        $query = $this->db->query("select INT_APPROVE1 from TW_BUDGET_CAPEX 
            where INT_ID_FISCAL_YEAR = '" . $fiscal . "' group by INT_APPROVE1");

        if ($query->num_rows() > 1) {
            return 0;
        } else {
            $result = $query->row_array();
            return $result['INT_APPROVE1'];
        }
    }
    
    function get_permit_approve_by_manager($fiscal) {
        $query = $this->db->query("select INT_APPROVE0 from TW_BUDGET_CAPEX 
            where INT_ID_FISCAL_YEAR = '" . $fiscal . "' group by INT_APPROVE0");

        if ($query->num_rows() > 1) {
            return 0;
        } else {
            $result = $query->row_array();
            return $result['INT_APPROVE0'];
        }
    }

//=============================================================manage=====================================
    //get capex temp who approve by director
    function get_capex_plan_temp_approve_by_director_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY, g.CHR_PURPOSE,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, g.CHR_PURPOSE_DESC, k.CHR_BUDGET_CATEGORY_DESC,l.CHR_BUDGET_SUB_CATEGORY_DESC,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,TM_BUDGET_SUB_CATEGORY l,TM_BUDGET_CATEGORY k
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_APPROVE1 = 1 and a.INT_APPROVE2 = 1 and a.INT_APPROVE3 = 1
                and a.INT_STATUS = 0
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get capex temp who approve by director
    function get_capex_plan_temp_approve_by_director_by_section($section, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY, g.CHR_PURPOSE,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, g.CHR_PURPOSE_DESC, k.CHR_BUDGET_CATEGORY_DESC,l.CHR_BUDGET_SUB_CATEGORY_DESC,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,TM_BUDGET_SUB_CATEGORY l,TM_BUDGET_CATEGORY k
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and a.INT_ID_SECTION = '" . $section . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_APPROVE1 = 1 and a.INT_APPROVE2 = 1 and a.INT_APPROVE3 = 1
                and a.INT_STATUS = 0
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get capex temp who approve by manager
    function get_capex_plan_temp_approve_by_manager_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY, g.CHR_PURPOSE,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, g.CHR_PURPOSE_DESC, k.CHR_BUDGET_CATEGORY_DESC,l.CHR_BUDGET_SUB_CATEGORY_DESC,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,TM_BUDGET_SUB_CATEGORY l,TM_BUDGET_CATEGORY k
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_APPROVE1 = 1 and a.INT_APPROVE2 != 1 and a.INT_APPROVE3 != 1
                and a.INT_STATUS = 0
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get capex temp who approve by manager
    function get_capex_plan_temp_approve_by_manager_by_section($section, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY, g.CHR_PURPOSE,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, g.CHR_PURPOSE_DESC, k.CHR_BUDGET_CATEGORY_DESC,l.CHR_BUDGET_SUB_CATEGORY_DESC,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,TM_BUDGET_SUB_CATEGORY l,TM_BUDGET_CATEGORY k
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and a.INT_ID_SECTION = '" . $section . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_APPROVE1 = 1 and a.INT_APPROVE2 != 1 and a.INT_APPROVE3 != 1
                and a.INT_STATUS = 0
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get capex temp who approve by no one
    function get_capex_plan_temp_approve_by_no_one_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY, g.CHR_PURPOSE,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, g.CHR_PURPOSE_DESC, k.CHR_BUDGET_CATEGORY_DESC,l.CHR_BUDGET_SUB_CATEGORY_DESC,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,TM_BUDGET_SUB_CATEGORY l,TM_BUDGET_CATEGORY k
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_APPROVE1 != 1 and a.INT_APPROVE2 != 1 and a.INT_APPROVE3 != 1
                and a.INT_STATUS = 0
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get capex temp who approve by no one
    function get_capex_plan_temp_approve_by_no_one_by_section($section, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY, g.CHR_PURPOSE,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, g.CHR_PURPOSE_DESC, k.CHR_BUDGET_CATEGORY_DESC,l.CHR_BUDGET_SUB_CATEGORY_DESC,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,TM_BUDGET_SUB_CATEGORY l,TM_BUDGET_CATEGORY k
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and a.INT_ID_SECTION = '" . $section . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_APPROVE1 != 1 and a.INT_APPROVE2 != 1 and a.INT_APPROVE3 != 1
                and a.INT_STATUS = 0
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get capex temp who approve by gm
    function get_capex_plan_temp_approve_by_gm_by_admin($fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY, g.CHR_PURPOSE,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, g.CHR_PURPOSE_DESC, k.CHR_BUDGET_CATEGORY_DESC,l.CHR_BUDGET_SUB_CATEGORY_DESC,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,TM_BUDGET_SUB_CATEGORY l,TM_BUDGET_CATEGORY k
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_APPROVE1 = 1 and a.INT_APPROVE2 = 1 and a.INT_APPROVE3 != 1
                and a.INT_STATUS = 0
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get capex temp who approve by gm
    function get_capex_plan_temp_approve_by_gm_by_section($section, $fiscal) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR, c.CHR_SECTION, d.CHR_DEPT, l.CHR_BUDGET_SUB_CATEGORY, g.CHR_PURPOSE,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, g.CHR_PURPOSE_DESC, k.CHR_BUDGET_CATEGORY_DESC,l.CHR_BUDGET_SUB_CATEGORY_DESC,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, 
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, 
            a.INT_APPROVE1,a.INT_APPROVE2,a.INT_APPROVE3,a.DEC_PRICE_PER_UNIT * a.INT_QUANTITY as DEC_PRICE_PER_UNIT,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW  
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,TM_BUDGET_SUB_CATEGORY l,TM_BUDGET_CATEGORY k
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_FISCAL_YEAR = '" . $fiscal . "' and a.INT_ID_SECTION = '" . $section . "'
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT 
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and a.INT_APPROVE1 = 1 and a.INT_APPROVE2 = 1 and a.INT_APPROVE3 != 1
                and a.INT_STATUS = 0
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    //get data capex plan temp
    function get_data_capex_plan_temp($no_budget) {
        $query = $this->db->query("select a.INT_NO_BUDGET_CPX_TEMP, a.CHR_BUDGET_NAME, b.CHR_FISCAL_YEAR,l.INT_ID_BUDGET_CATEGORY, a.INT_QUANTITY,
            CASE a.INT_MONTH_PLAN WHEN '1' THEN 'January' WHEN '2' THEN 'February' WHEN '3' THEN 'March' WHEN '4' THEN 'April' WHEN '5' THEN 'May' 
            WHEN '6' THEN 'June' WHEN '7' THEN 'July' WHEN '8' THEN 'August' WHEN '9' THEN 'September' WHEN '10' THEN 'October'
            WHEN '11' THEN 'November' ELSE 'December' END as INT_MONTH_PLAN,a.DEC_PRICE_PER_UNIT,
            c.CHR_SECTION_DESC, c.INT_ID_SECTION, d.INT_ID_DEPT, d.CHR_DEPT_DESC, l.CHR_BUDGET_SUB_CATEGORY_DESC,k.CHR_BUDGET_CATEGORY_DESC, g.CHR_PURPOSE_DESC,
            CASE a.BIT_FLG_CIP WHEN '0' THEN 'CIP' ELSE 'NOT CIP' END as BIT_FLG_CIP, a.BIT_FLG_CIP as CIP,
            CASE a.BIT_FLG_OWNER WHEN '0' THEN 'Aisin' ELSE 'Customer' END as BIT_FLG_OWNER, a.BIT_FLG_OWNER as OWNER,
            CASE a.BIT_FLG_LOCAL WHEN '0' THEN 'Local' ELSE 'Import' END as BIT_FLG_LOCAL, a.BIT_FLG_LOCAL as LOCAL,
            g.INT_ID_PURPOSE,l.INT_ID_BUDGET_SUB_CATEGORY,
            CASE a.INT_APPROVE1 WHEN '1' THEN 'Approve' WHEN '2' THEN 'Not Approve' ELSE '-' END as INT_APPROVE1,
            CASE a.INT_APPROVE2 WHEN '1' THEN 'Approve' WHEN '2' THEN 'Not Approve' ELSE '-' END as INT_APPROVE2,
            CASE a.INT_APPROVE3 WHEN '1' THEN 'Approve' WHEN '2' THEN 'Not Approve' ELSE '-' END as INT_APPROVE3,
            CASE a.BIT_FLG_NEW WHEN '0' THEN 'New' ELSE 'Over Carry' END as BIT_FLG_NEW, a.BIT_FLG_NEW as NEW
            from TW_BUDGET_CAPEX a,TM_FISCAL b, TM_SECTION c, TM_DEPT d, TM_PURPOSE g,
                 TM_BUDGET_CATEGORY k,TM_BUDGET_SUB_CATEGORY l
            where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR
                and a.INT_ID_SECTION = c.INT_ID_SECTION 
                and c.INT_ID_DEPT = d.INT_ID_DEPT
                and a.INT_ID_PURPOSE = g.INT_ID_PURPOSE 
                and l.INT_ID_BUDGET_CATEGORY = k.INT_ID_BUDGET_CATEGORY
                and a.INT_ID_BUDGET_SUB_CATEGORY = l.INT_ID_BUDGET_SUB_CATEGORY
                and a.BIT_FLG_DEL = 0 and a.INT_NO_BUDGET_CPX_TEMP = '" . $no_budget . "'");
        return $query;
    }

    //save
    function save($data) {
        $this->db->insert($this->TW_CAPEX, $data);
    }

    //update
    function update($data, $id) {
        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $id);
        $this->db->update($this->TW_CAPEX, $data);
    }

    //delete
    function delete($id) {
        $data = array('BIT_FLG_DEL' => '1');
        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $id);
        $this->db->update($this->TW_CAPEX, $data);
    }

    //create id
    function generated_id() {
        $query = $this->db->query("select top 1 INT_NO_BUDGET_CPX_TEMP as 'id' from TW_BUDGET_CAPEX where SUBSTRING(CAST(INT_NO_BUDGET_CPX_TEMP as char),2,2) = RIGHT(year(getdate()),2) order by INT_NO_BUDGET_CPX_TEMP desc");

        if ($query->num_rows() != 0) {
            $result = $query->row_array();
            $no_purchase_request = $result['id'];
            return $no_purchase_request + 1;
        } else {
            $no_purchase_request = '1' . date('y') . '0000';
            return $no_purchase_request;
        }
    }

}

?>
