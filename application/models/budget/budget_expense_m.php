<?php

class budget_expense_m extends CI_Model {

    private $tt_budget = 'CPL.TT_BUDGET';
    private $tm_seq = 'CPL.TM_SEQ_NUMBER';
    private $tt_expense = 'CPL.TT_BUDGET_EXPENSE';
    private $tw_expense = 'CPL.TW_BUDGET_EXPENSE';
    private $tt_pure_expense = 'CPL.TT_BUDGET_PURE_EXPENSE';
    private $tt_subexpense = 'CPL.TT_BUDGET_SUBEXPENSE';
    private $tt_pureq_pure_expense = 'CPL.TT_BUDGET_PUREQ_PURE_EXPENSE';
    private $tt_pureq_subexpense = 'CPL.TT_BUDGET_PUREQ_SUBEXPENSE';

    function save_temp($data) {
        $this->db->insert($this->tw_expense, $data);
    }

    function save($data) {
        $this->db->insert($this->tt_expense, $data);
    }

    function get_sequence_budget_no($type_expense, $section, $fiscal_year) {
        $data = $this->db->query("SELECT CAST(RIGHT(RTRIM(CHR_NO_BUDGET),5) AS INT) CHR_NO_BUDGET FROM $this->tt_expense WHERE INT_ID_FISCAL_YEAR = $fiscal_year");

        if ($data->num_rows() > 0) {

            $row = $data->row_array();
            $budget_sequence = $row['CHR_NO_BUDGET'];

            if (strlen($budget_sequence + 1) == 1) {
                $int = $budget_sequence + 1;
                $seq = '0000' . $int;
            } else if (strlen($budget_sequence + 1) == 2) {
                $int = $budget_sequence + 1;
                $seq = '000' . $int;
            } else if (strlen($budget_sequence + 1) == 3) {
                $int = $budget_sequence + 1;
                $seq = '00' . $int;
            } else if (strlen($budget_sequence + 1) == 4) {
                $int = $budget_sequence + 1;
                $seq = '0' . $int;
            } else {
                $seq = $budget_sequence + 1;
            }


            return $type_expense . '/' . $section . '/' . date('y') . $seq;
        } else {
            return $type_expense . '/' . $section . '/' . date('y') . '00001';
        }
    }

    function get_all_budget_expense_header($fiscal, $id = null) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case 1:
                return $this->db->query("SELECT * FROM CPL.TT_BUDGET_EXPENSE")->row();
                break;
            case 2:
                return $this->db->query("select f.INT_ID_COMPANY, f.CHR_COMPANY, f.CHR_COMPANY_DESC, 
                                        SUM(a.DEC_TOTAL)as DEC_TOTAL, 
                                MAX(a.INT_REVISE) INT_REVISE, MAX(a.INT_APPROVE) as INT_APPROVE
                                from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT d, TM_DIVISION e, TM_COMPANY f,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                        from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT q, TM_DIVISION w
                                        where  x.INT_ID_FISCAL_YEAR='$fiscal'
                                        and x.INT_ID_SECTION=y.INT_ID_SECTION
                                        and y.INT_ID_DEPT=z.INT_ID_DEPT
                                        and z.INT_ID_GROUP_DEPT=q.INT_ID_GROUP_DEPT
                                        and q.INT_ID_DIVISION=w.INT_ID_DIVISION
                                        and w.INT_ID_COMPANY='$id'
                                        group by INT_NO_BUDGET_EXP) x
                                where a.INT_ID_SECTION=b.INT_ID_SECTION
                                and b.INT_ID_SECTION=a.INT_ID_SECTION
                                and b.INT_ID_DEPT=c.INT_ID_DEPT
                                and c.INT_ID_GROUP_DEPT=d.INT_ID_GROUP_DEPT
                                and d.INT_ID_DIVISION=e.INT_ID_DIVISION
                                and e.INT_ID_COMPANY=f.INT_ID_COMPANY
                                and f.INT_ID_COMPANY='$id'
                                    and a.INT_APPROVE>0
                                and a.INT_FLG_DEL=0  
                                and x.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP 
                                and x.INT_REVISE=a.INT_REVISE
                                and a.INT_ID_FISCAL_YEAR='$fiscal'
                                group by f.INT_ID_COMPANY, f.CHR_COMPANY, f.CHR_COMPANY_DESC")->row();
                break;
            case 3:
                return $this->db->query("select e.INT_ID_DIVISION, e.CHR_DIVISION, e.CHR_DIVISION_DESC, 
                                        SUM(a.DEC_TOTAL)as DEC_TOTAL, 
                                MAX(a.INT_REVISE) INT_REVISE, MAX(a.INT_APPROVE) as INT_APPROVE
                                from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT d, TM_DIVISION e,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                        from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT q
                                        where  x.INT_ID_FISCAL_YEAR='$fiscal'
                                        and x.INT_ID_SECTION=y.INT_ID_SECTION
                                        and y.INT_ID_DEPT=z.INT_ID_DEPT
                                        and z.INT_ID_GROUP_DEPT=q.INT_ID_GROUP_DEPT
                                        and q.INT_ID_DIVISION='$id'
                                        group by INT_NO_BUDGET_EXP) x
                                where a.INT_ID_SECTION=b.INT_ID_SECTION
                                and b.INT_ID_SECTION=a.INT_ID_SECTION
                                and b.INT_ID_DEPT=c.INT_ID_DEPT
                                and c.INT_ID_GROUP_DEPT=d.INT_ID_GROUP_DEPT
                                and d.INT_ID_DIVISION=e.INT_ID_DIVISION
                                and e.INT_ID_DIVISION='$id'
                                and a.INT_FLG_DEL=0  
                                and x.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP 
                                and x.INT_REVISE=a.INT_REVISE
                                and a.INT_ID_FISCAL_YEAR='$fiscal'
                                group by e.INT_ID_DIVISION, e.CHR_DIVISION, e.CHR_DIVISION_DESC")->row();
                break;
            case 4:
                return $this->db->query("select d.INT_ID_GROUP_DEPT, d.CHR_GROUP_DEPT, d.CHR_GROUP_DEPT_DESC, 
                                        SUM(a.DEC_TOTAL)as DEC_TOTAL, 
                                MAX(a.INT_REVISE) INT_REVISE, MAX(a.INT_APPROVE) as INT_APPROVE
                                from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT d,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                        from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                        where  x.INT_ID_FISCAL_YEAR='$fiscal'
                                        and x.INT_ID_SECTION=y.INT_ID_SECTION
                                        and y.INT_ID_DEPT=z.INT_ID_DEPT
                                        and z.INT_ID_GROUP_DEPT='$id'
                                        group by INT_NO_BUDGET_EXP) x
                                where a.INT_ID_SECTION=b.INT_ID_SECTION
                                and b.INT_ID_SECTION=a.INT_ID_SECTION
                                and b.INT_ID_DEPT=c.INT_ID_DEPT
                                and c.INT_ID_GROUP_DEPT=d.INT_ID_GROUP_DEPT
                                and d.INT_ID_GROUP_DEPT='$id'
                                and a.INT_FLG_DEL=0  
                                and x.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP 
                                and x.INT_REVISE=a.INT_REVISE
                                and a.INT_ID_FISCAL_YEAR='$fiscal'
                                group by d.INT_ID_GROUP_DEPT, d.CHR_GROUP_DEPT, d.CHR_GROUP_DEPT_DESC")->row();
                break;
            case 5:
                return $this->db->query("select c.INT_ID_DEPT, c.CHR_DEPT, c.CHR_DEPT_DESC, SUM(a.DEC_TOTAL)as DEC_TOTAL, 
                                MAX(a.INT_REVISE) INT_REVISE, MAX(a.INT_APPROVE) as INT_APPROVE
                                from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                        from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                        where  x.INT_ID_FISCAL_YEAR='$fiscal'
                                        and x.INT_ID_SECTION=y.INT_ID_SECTION
                                        and y.INT_ID_DEPT='$id'
                                        group by INT_NO_BUDGET_EXP) x
                                where a.INT_ID_SECTION=b.INT_ID_SECTION
                                and b.INT_ID_SECTION=a.INT_ID_SECTION
                                and b.INT_ID_DEPT=c.INT_ID_DEPT
                                and c.INT_ID_DEPT='$id'
                                and a.INT_FLG_DEL=0  
                                and x.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP 
                                and x.INT_REVISE=a.INT_REVISE
                                and a.INT_ID_FISCAL_YEAR='$fiscal'
                                group by c.INT_ID_DEPT, c.CHR_DEPT, c.CHR_DEPT_DESC")->row();
                break;
            case 6:
                return $this->db->query("select b.INT_ID_SECTION, b.CHR_SECTION_DESC,b.CHR_SECTION, SUM(a.DEC_TOTAL)as DEC_TOTAL, 
                                MAX(a.INT_REVISE) INT_REVISE, MAX(a.INT_APPROVE) as INT_APPROVE
                                from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b,
                                        (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                        from CPL.TT_BUDGET_EXPENSE
                                        where  INT_ID_FISCAL_YEAR='$fiscal'
                                        and INT_ID_SECTION='$id'
                                        group by INT_NO_BUDGET_EXP) x
                                where a.INT_ID_SECTION=b.INT_ID_SECTION
                                and b.INT_ID_SECTION='$id'
                                and a.INT_FLG_DEL=0  
                                and x.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP 
                                and x.INT_REVISE=a.INT_REVISE
                                and a.INT_ID_FISCAL_YEAR='$fiscal'
                                group by b.INT_ID_SECTION, b.CHR_SECTION_DESC,b.CHR_SECTION")->row();
                break;
            default:
                break;
        }
    }

    function get_data_status_org($fiscal, $id = NULL) { //status app
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case '1':
                return $this->db->query("select  x.INT_ID_DIVISION, max(x.INT_APPROVE) as INT_APPROVE
                                        from	
                                            (select f.INT_ID_DIVISION, a.INT_APPROVE
                                            from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT e, TM_DIVISION f,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT q, TM_DIVISION w
                                                    where    x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                    and z.INT_ID_GROUP_DEPT=q.INT_ID_GROUP_DEPT
                                                    and q.INT_ID_DIVISION=w.INT_ID_DIVISION
                                                    and w.INT_ID_COMPANY=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=c.INT_ID_DEPT
                                            and a.INT_FLG_DEL=0  
                                            and d.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP and d.INT_REVISE=a.INT_REVISE
                                            and c.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT and a.INT_ID_FISCAL_YEAR=$fiscal
                                            and e.INT_ID_DIVISION=f.INT_ID_DIVISION
                                            and f.INT_ID_COMPANY=$id
                                            group by f.INT_ID_DIVISION, a.INT_APPROVE) x
                                        group by INT_ID_DIVISION")->result();
                break;
            case '2':
                return $this->db->query("select  x.INT_ID_DIVISION, max(x.INT_APPROVE) as INT_APPROVE
                                        from	
                                            (select f.INT_ID_DIVISION, a.INT_APPROVE
                                            from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT e, TM_DIVISION f,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT q, TM_DIVISION w
                                                    where    x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                    and z.INT_ID_GROUP_DEPT=q.INT_ID_GROUP_DEPT
                                                    and q.INT_ID_DIVISION=w.INT_ID_DIVISION
                                                    and w.INT_ID_COMPANY=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=c.INT_ID_DEPT
                                            and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                            and d.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP and d.INT_REVISE=a.INT_REVISE
                                            and c.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT and a.INT_ID_FISCAL_YEAR=$fiscal
                                            and e.INT_ID_DIVISION=f.INT_ID_DIVISION
                                            and f.INT_ID_COMPANY=$id
                                            group by f.INT_ID_DIVISION, a.INT_APPROVE) x
                                        group by INT_ID_DIVISION")->result();
                break;
            case '3':
                return $this->db->query("select  x.INT_ID_GROUP_DEPT, max(x.INT_APPROVE) as INT_APPROVE
                                        from	
                                            (select e.INT_ID_GROUP_DEPT, a.INT_APPROVE
                                            from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT e,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT q
                                                    where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                    and z.INT_ID_GROUP_DEPT=q.INT_ID_GROUP_DEPT
                                                    and q.INT_ID_DIVISION=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=c.INT_ID_DEPT
                                            and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                            and d.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP and d.INT_REVISE=a.INT_REVISE
                                            and c.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT and a.INT_ID_FISCAL_YEAR=$fiscal
                                            and e.INT_ID_DIVISION=$id
                                            group by e.INT_ID_GROUP_DEPT, a.INT_APPROVE) x
                                        group by INT_ID_GROUP_DEPT")->result();
                break;
            case '4':
                return $this->db->query("select  x.INT_ID_DEPT, max(x.INT_APPROVE) as INT_APPROVE
                                        from	
                                            (select c.INT_ID_DEPT, a.INT_APPROVE
                                            from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                                    where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                    and z.INT_ID_GROUP_DEPT=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=c.INT_ID_DEPT
                                            and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                            and d.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP and d.INT_REVISE=a.INT_REVISE
                                            and c.INT_ID_GROUP_DEPT=$id and a.INT_ID_FISCAL_YEAR=$fiscal
                                            group by c.INT_ID_DEPT, a.INT_APPROVE) x
                                        group by INT_ID_DEPT")->result();
                break;
            case '5':
                return $this->db->query("select  x.INT_ID_SECTION, max(x.INT_APPROVE) as INT_APPROVE
                                        from	
                                            (select b.INT_ID_SECTION, a.INT_APPROVE
                                            from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, 
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                                    where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=$id
                                            and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                            and d.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP and d.INT_REVISE=a.INT_REVISE
                                            and a.INT_ID_FISCAL_YEAR=$fiscal
                                            group by b.INT_ID_SECTION, a.INT_APPROVE) x
                                        group by INT_ID_SECTION")->result();
                break;
        }
    }

    function get_all_budget_expense($fiscal, $id = NULL) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case '1':
                return $this->db->query("select v.INT_ID_DIVISION, v.CHR_DIVISION, v.CHR_DIVISION_DESC, SUM(v.TOTAL) as TOTAL
                                        from
                                            (SELECT f.INT_ID_DIVISION, f.CHR_DIVISION, f.CHR_DIVISION_DESC, 
                                                c.INT_APPROVE,c.INT_LOCK, sum(c.DEC_TOTAL) as TOTAL
                                            FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c, TM_GROUP_DEPT e, TM_DIVISION f,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w, TM_DIVISION q
                                                    where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                    and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT 
                                                    and w.INT_ID_DIVISION=q.INT_ID_DIVISION
                                                    and q.INT_ID_COMPANY=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
                                            and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
                                            and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal 
                                            and a.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT and e.INT_ID_DIVISION=f.INT_ID_DIVISION
                                            and f.INT_ID_COMPANY=$id
                                            GROUP BY f.INT_ID_DIVISION, f.CHR_DIVISION, f.CHR_DIVISION_DESC, c.INT_APPROVE, c.INT_LOCK) v
                                        GROUP BY v.INT_ID_DIVISION, v.CHR_DIVISION, v.CHR_DIVISION_DESC")->result();
                break;
            case '2':
                return $this->db->query("select v.INT_ID_DIVISION, v.CHR_DIVISION, v.CHR_DIVISION_DESC, SUM(v.TOTAL) as TOTAL
                                        from
                                            (SELECT f.INT_ID_DIVISION, f.CHR_DIVISION, f.CHR_DIVISION_DESC, 
                                                c.INT_APPROVE,c.INT_LOCK, sum(c.DEC_TOTAL) as TOTAL
                                            FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c, TM_GROUP_DEPT e, TM_DIVISION f,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w, TM_DIVISION q
                                                    where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                    and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT 
                                                    and w.INT_ID_DIVISION=q.INT_ID_DIVISION
                                                    and q.INT_ID_COMPANY=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
                                            and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
                                            and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal 
                                            and a.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT and e.INT_ID_DIVISION=f.INT_ID_DIVISION
                                            and f.INT_ID_COMPANY=$id
                                            GROUP BY f.INT_ID_DIVISION, f.CHR_DIVISION, f.CHR_DIVISION_DESC, c.INT_APPROVE, c.INT_LOCK) v
                                        GROUP BY v.INT_ID_DIVISION, v.CHR_DIVISION, v.CHR_DIVISION_DESC")->result();
                break;
            case '3':
                return $this->db->query("select v.INT_ID_GROUP_DEPT, v.CHR_GROUP_DEPT, v.CHR_GROUP_DEPT_DESC, SUM(v.TOTAL) as TOTAL
                                        from
                                            (SELECT e.INT_ID_GROUP_DEPT, e.CHR_GROUP_DEPT, e.CHR_GROUP_DEPT_DESC, 
                                                c.INT_APPROVE,c.INT_LOCK, sum(c.DEC_TOTAL) as TOTAL
                                            FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c, TM_GROUP_DEPT e,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w
                                                    where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                    and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT 
                                                    and w.INT_ID_DIVISION=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
                                            and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
                                            and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal 
                                            and a.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT and e.INT_ID_DIVISION=$id
                                            GROUP BY e.INT_ID_GROUP_DEPT, e.CHR_GROUP_DEPT, e.CHR_GROUP_DEPT_DESC, c.INT_APPROVE, c.INT_LOCK) v
                                        GROUP BY v.INT_ID_GROUP_DEPT, v.CHR_GROUP_DEPT, v.CHR_GROUP_DEPT_DESC")->result();
                break;
            case '4':
                return $this->db->query("select v.INT_ID_DEPT, v.CHR_DEPT, v.CHR_DEPT_DESC, SUM(v.TOTAL) as TOTAL
                                        from
                                            (SELECT a.INT_ID_DEPT,c.INT_APPROVE,c.INT_LOCK, a.CHR_DEPT,a.CHR_DEPT_DESC, sum(c.DEC_TOTAL) as TOTAL
                                            FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                                    where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                    and z.INT_ID_GROUP_DEPT=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
                                            and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
                                            and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal and a.INT_ID_GROUP_DEPT=$id 
                                            GROUP BY a.CHR_DEPT,a.CHR_DEPT_DESC,a.INT_ID_DEPT, c.INT_APPROVE, c.INT_LOCK) v
                                        GROUP BY v.INT_ID_DEPT, v.CHR_DEPT, v.CHR_DEPT_DESC")->result();
                break;
//                return $this->db->query("SELECT a.INT_ID_DEPT,c.INT_APPROVE,c.INT_LOCK, a.CHR_DEPT,a.CHR_DEPT_DESC, sum(c.DEC_TOTAL) as TOTAL
//                                        FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c,
//                                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
//                                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
//                                                where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
//                                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
//                                                and z.INT_ID_GROUP_DEPT=$id
//                                                group by x.INT_NO_BUDGET_EXP) d
//                                        where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
//                                        and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
//                                        and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal and a.INT_ID_GROUP_DEPT=$id 
//                                        GROUP BY a.CHR_DEPT,a.CHR_DEPT_DESC,a.INT_ID_DEPT, c.INT_APPROVE, c.INT_LOCK")->result();
//                break;
            case '5':
                return $this->db->query("select v.INT_ID_SECTION, v.CHR_SECTION, v.CHR_SECTION_DESC, SUM(v.TOTAL) as TOTAL
                                        from
                                            (SELECT b.INT_ID_SECTION,c.INT_APPROVE,c.INT_LOCK, b.CHR_SECTION,b.CHR_SECTION_DESC, sum(c.DEC_TOTAL) as TOTAL
                                            FROM TM_SECTION b, CPL.TT_BUDGET_EXPENSE c,
                                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                    from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                                    where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                    and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
                                                    group by x.INT_NO_BUDGET_EXP) d
                                            where  b.INT_ID_DEPT=$id and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
                                            and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
                                            and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal
                                            GROUP BY b.INT_ID_SECTION, b.CHR_SECTION,b.CHR_SECTION_DESC, c.INT_APPROVE, c.INT_LOCK) v
                                        GROUP BY v.INT_ID_SECTION, v.CHR_SECTION, v.CHR_SECTION_DESC")->result();
                break;
//                return $this->db->query("SELECT b.INT_ID_SECTION,c.INT_APPROVE,c.INT_LOCK, b.CHR_SECTION,b.CHR_SECTION_DESC, sum(c.DEC_TOTAL) as TOTAL
//                                        FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c, 
//                                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
//                                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
//                                                where x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
//                                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
//                                                group by x.INT_NO_BUDGET_EXP) d
//                                        where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>=0
//                                        and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
//                                        and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal and a.INT_ID_DEPT=$id
//                                        GROUP BY b.CHR_SECTION,b.CHR_SECTION_DESC,b.INT_ID_SECTION, c.INT_APPROVE, c.INT_LOCK")->result();
//                break;
            case '6':
                return $this->db->query("select a.INT_NO_BUDGET_EXP, a.INT_REVISE, a.DEC_TOTAL, a.CHR_BUDGET_DESC, 
                                        a.INT_APPROVE, a.DEC_TOTAL, a.INT_ID_UOM,a.INT_LOCK, a.INT_UNBUDGET, 
                                        a.CHR_ALLOCATE, c.CHR_BUDGET_SUB_CATEGORY_DESC, d.CHR_FISCAL_YEAR
                                        from CPL.TT_BUDGET_EXPENSE a, CPL.TM_BUDGET_SUB_CATEGORY c, CPL.TM_FISCAL d, 
                                            (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                            from CPL.TT_BUDGET_EXPENSE
                                            where INT_ID_SECTION=$id  and INT_ID_FISCAL_YEAR=$fiscal
                                            group by INT_NO_BUDGET_EXP) e
                                        where c.INT_ID_BUDGET_SUB_CATEGORY=a.INT_ID_BUDGET_SUB_CATEGORY
                                        and d.INT_ID_FISCAL_YEAR=a.INT_ID_FISCAL_YEAR 
                                        and a.INT_FLG_DEL=0 
                                        and e.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP and e.INT_REVISE=a.INT_REVISE
                                        and a.INT_ID_FISCAL_YEAR=$fiscal and a.INT_ID_SECTION=$id 
                                        order by INT_NO_BUDGET_EXP DESC")->result();
                break;
            default:
                break;
        }
    }

    function get_unbudget_expense($fiscal, $id = null) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case '1':
                return $this->db->query("select a.INT_NO_BUDGET_EXP, a.INT_REVISE, a.DEC_TOTAL, a.CHR_BUDGET_DESC, 
                                        a.CHR_ALLOCATE, a.INT_ID_UOM, b.CHR_FISCAL_YEAR, 
                                        a.CHR_BUDGET_DESC, a.CHR_BUDGET_DESC, c.CHR_SECTION, d.CHR_BUDGET_SUB_CATEGORY,
                                        c.CHR_SECTION_DESC, d.CHR_BUDGET_SUB_CATEGORY_DESC
                                        from CPL.TT_BUDGET_EXPENSE a, CPL.TM_FISCAL b, TM_SECTION c, CPL.TM_BUDGET_SUB_CATEGORY d,
                                                (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                                from CPL.TT_BUDGET_EXPENSE
                                                where INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                                                group by INT_NO_BUDGET_EXP) e
                                        where a.INT_ID_FISCAL_YEAR=b.INT_ID_FISCAL_YEAR and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and a.INT_ID_BUDGET_SUB_CATEGORY=d.INT_ID_BUDGET_SUB_CATEGORY 
                                        and e.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP and e.INT_REVISE=a.INT_REVISE
                                        and a.INT_UNBUDGET=0 and a.INT_FLG_DEL = 0 and a.INT_ID_FISCAL_YEAR=$fiscal")->result();
                break;
            case '2':
                return $this->db->query("SELECT f.INT_ID_DIVISION,c.INT_APPROVE, c.INT_LOCK, f.CHR_DIVISION, f.CHR_DIVISION, 
                                        sum(c.DEC_TOTAL) as TOTAL
                                        FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c, TM_GROUP_DEPT e, TM_DIVISION f,
                                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w, TM_DIVISION q
                                                where x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                                and w.INT_ID_DIVISION=q.INT_ID_DIVISION
                                                and q.INT_ID_COMPANY=$id
                                                group by x.INT_NO_BUDGET_EXP) d
                                        where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
                                        and a.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT
                                        and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
                                        and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal and e.INT_ID_DIVISION=f.INT_ID_DIVISION and f.INT_ID_COMPANY=$id 
                                        GROUP BY f.INT_ID_DIVISION,f.CHR_DIVISION,f.CHR_DIVISION, c.INT_APPROVE, c.INT_LOCK")->result();
                break;
            case '3':
                return $this->db->query("SELECT e.INT_ID_GROUP_DEPT,c.INT_APPROVE,c.INT_LOCK, e.CHR_GROUP_DEPT,e.CHR_GROUP_DEPT_DESC, 
                                        sum(c.DEC_TOTAL) as TOTAL
                                        FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c, TM_GROUP_DEPT e,
                                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w
                                                where x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                                and w.INT_ID_DIVISION=$id
                                                group by x.INT_NO_BUDGET_EXP) d
                                        where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
                                        and a.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT
                                        and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
                                        and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal and e.INT_ID_DIVISION=$id 
                                        GROUP BY e.INT_ID_GROUP_DEPT,e.CHR_GROUP_DEPT,e.CHR_GROUP_DEPT_DESC, c.INT_APPROVE, c.INT_LOCK")->result();
                break;
            case '4':
                return $this->db->query("SELECT a.INT_ID_DEPT,c.INT_APPROVE,c.INT_LOCK, a.CHR_DEPT,a.CHR_DEPT_DESC, sum(c.DEC_TOTAL) as TOTAL
                                        FROM TM_DEPT a, TM_SECTION b, CPL.TT_BUDGET_EXPENSE c,
                                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                                where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                                and z.INT_ID_GROUP_DEPT=$id
                                                group by x.INT_NO_BUDGET_EXP) d
                                        where  b.INT_ID_DEPT=a.INT_ID_DEPT and c.INT_ID_SECTION=b.INT_ID_SECTION and c.INT_APPROVE>0
                                        and d.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and d.INT_REVISE=c.INT_REVISE
                                        and c.INT_FLG_DEL=0 and c.INT_UNBUDGET=0 and c.INT_ID_FISCAL_YEAR=$fiscal and a.INT_ID_GROUP_DEPT=$id 
                                        GROUP BY a.CHR_DEPT,a.CHR_DEPT_DESC,a.INT_ID_DEPT, c.INT_APPROVE, c.INT_LOCK")->result();
                break;
            case '5':
                return $this->db->query("SELECT a.INT_NO_BUDGET_EXP, a.CHR_BUDGET_DESC, a.DEC_TOTAL, a.INT_REVISE, a.CHR_ALLOCATE,
                                        a.INT_APPROVE, a.INT_ID_BUDGET_SUB_CATEGORY, a.INT_ID_UOM, a.INT_ID_SECTION,
                                        b.CHR_SECTION, e.CHR_BUDGET_SUB_CATEGORY_DESC, e.CHR_BUDGET_SUB_CATEGORY
                                        FROM CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, CPL.TM_BUDGET_SUB_CATEGORY e, TM_DEPT c, 
                                                (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                                where x.INT_UNBUDGET=1 and x.INT_ID_FISCAL_YEAR=$fiscal
                                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
                                                group by x.INT_NO_BUDGET_EXP
                                                ) d
                                        WHERE a.INT_ID_SECTION=b.INT_ID_SECTION and b.INT_ID_DEPT=c.INT_ID_DEPT
                                        and a.INT_APPROVE>=0 and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=1
                                        and a.INT_ID_FISCAL_YEAR=$fiscal and c.INT_ID_DEPT=$id
                                        and d.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP and d.INT_REVISE=a.INT_REVISE
                                        and e.INT_ID_BUDGET_SUB_CATEGORY=a.INT_ID_BUDGET_SUB_CATEGORY
                                        order by a.INT_NO_BUDGET_EXP desc")->result();
                break;

            default:
                break;
        }
    }

    function save_expense($data) {
        $this->db->insert($this->tt_expense, $data);
    }

    function save_final_expense($data_final) {
        $this->db->insert($this->tt_budget, $data_final);
    }

    function get_new_id_budget() {
        return $this->db->query('select max(INT_NO_BUDGET_EXP) as a from CPL.TT_BUDGET_EXPENSE')->row()->a + 1;
    }

    function check_any_id() {
        $query = $this->db->query("select INT_NO_BUDGET_EXP
                                from CPL.TT_BUDGET_EXPENSE");
        if ($query->num_rows > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function save_expense_detail($data_detail, $x) {
        if ($x == 'e') {
            $this->db->insert($this->tt_pure_expense, $data_detail);
        } else {
            $this->db->insert($this->tt_subexpense, $data_detail);
        }
    }

    function save_expense_detail_for_pureq($data_detail, $x) {
        if ($x == 'e') {
            $this->db->insert($this->tt_pureq_pure_expense, $data_detail);
        } else {
            $this->db->insert($this->tt_pureq_subexpense, $data_detail);
        }
    }

    function get_expense_head_details($id, $rev) {
        return $this->db->query("select a.INT_NO_BUDGET_EXP, a.CHR_BUDGET_DESC, a.INT_APPROVE, a.INT_REVISE, a.CHR_NPK, 
                                a.DEC_MONEY_PER_UNIT, a.DEC_TOTAL, a.INT_REVISE,
                                a.INT_LOCK, a.CHR_ALLOCATE,  a.INT_FLG_DEL,
                                c.CHR_FISCAL_YEAR, c.CHR_FISCAL_YEAR_START, c.CHR_FISCAL_YEAR_END, c.INT_ID_FISCAL_YEAR,
                                c.CHR_MONTH_START, c.CHR_MONTH_END,
                                d.CHR_BUDGET_SUB_CATEGORY, d.CHR_BUDGET_SUB_CATEGORY_DESC,
                                e.CHR_BUDGET_CATEGORY, e.CHR_BUDGET_CATEGORY_DESC,
                                f.CHR_SECTION, f.CHR_SECTION_DESC, f.INT_ID_SECTION,
                                g.CHR_DEPT, g.CHR_DEPT_DESC, g.INT_ID_DEPT,
                                h.CHR_COST_CENTER, h.CHR_COST_CENTER_DESC,
                                i.CHR_BUDGET_TYPE_DESC, i.CHR_BUDGET_TYPE,
                                j.CHR_UNIT_DESC, j.CHR_UNIT, j.INT_ID_UOM
                                from CPL.TT_BUDGET_EXPENSE a,  CPL.TM_FISCAL c, CPL.TM_BUDGET_SUB_CATEGORY
                                d, TM_BUDGET_CATEGORY e,TM_SECTION f, TM_DEPT g, TM_COST_CENTER h, 
                                TM_BUDGET_TYPE i, TM_UNIT j
                                where 
                                a.INT_FLG_DEL=0 and a.INT_ID_FISCAL_YEAR=c.INT_ID_FISCAL_YEAR and a.INT_ID_SECTION=f.INT_ID_SECTION
                                and f.INT_ID_SECTION=h.INT_ID_COST_CENTER and f.INT_ID_DEPT=g.INT_ID_DEPT
                                and d.INT_ID_BUDGET_SUB_CATEGORY=a.INT_ID_BUDGET_SUB_CATEGORY
                                and d.INT_ID_BUDGET_CATEGORY=e.INT_ID_BUDGET_CATEGORY
                                and a.INT_ID_UOM=j.INT_ID_UOM and e.INT_ID_BUDGET_TYPE=i.INT_ID_BUDGET_TYPE
                                and a.INT_NO_BUDGET_EXP=$id and a.INT_REVISE=$rev")->row();
    }

    function get_expense_details($id, $rev, $x) {
        if ($x == 'e') {
            $this->db->where('INT_NO_BUDGET_EXP', $id);
            $this->db->where('INT_FLG_DEL', 0);
            $this->db->where('INT_REVISE', $rev);
            return $this->db->get($this->tt_pure_expense)->result();
        } else {
            $this->db->where('INT_NO_BUDGET_EXP', $id);
            $this->db->where('INT_FLG_DEL', 0);
            $this->db->where('INT_REVISE', $rev);
            return $this->db->get($this->tt_subexpense)->result();
        }
    }

    function get_expense_details_with_del($id, $rev, $x) {
        if ($x == 'e') {
            $this->db->where('INT_NO_BUDGET_EXP', $id);
            $this->db->where('INT_REVISE', $rev);
            return $this->db->get($this->tt_pure_expense)->result();
        } else {
            $this->db->where('INT_NO_BUDGET_EXP', $id);
            $this->db->where('INT_REVISE', $rev);
            return $this->db->get($this->tt_subexpense)->result();
        }
    }

    function delete_expense($id, $rev, $x) {
        $session = $this->session->all_userdata();
        $data = array(
            'INT_FLG_DEL' => 1,
            'CHR_MODI_BY' => $session['USERNAME'],
            'CHR_MODI_DATE' => date('Ymd'),
            'CHR_MODI_TIME' => date('His'));

        $this->db->where('INT_NO_BUDGET_EXP', $id);
        $this->db->where('INT_REVISE', $rev);
        $this->db->update($this->tt_expense, $data);
        if ($x == 'e') {
            $this->db->where('INT_NO_BUDGET_EXP', $id);
            $this->db->where('INT_REVISE', $rev);
            $this->db->update($this->tt_pure_expense, $data);
        } else if ($x == 's') {
            $this->db->where('INT_NO_BUDGET_EXP', $id);
            $this->db->where('INT_REVISE', $rev);
            $this->db->update($this->tt_subexpense, $data);
        }
    }

    function update_expense_detail($id, $rev, $month, $details, $type) {
        if ($type == 'e') {
            $this->db->where('INT_NO_BUDGET_EXP', $id);
            $this->db->where('INT_MONTH_PLAN', $month);
            $this->db->where('INT_REVISE', $rev);
            $this->db->update($this->tt_pure_expense, $details);
        } else {
            $this->db->where('INT_NO_BUDGET_EXP', $id);
            $this->db->where('INT_MONTH_PLAN', $month);
            $this->db->where('INT_REVISE', $rev);
            $this->db->update($this->tt_subexpense, $details);
        }
    }

    function get_amount_expense_detail($id, $rev, $x) {
        if ($x == 'e') {
            return $this->db->query("select DEC_MONEY_EXPENSE
                                    from CPL.TT_BUDGET_PURE_EXPENSE
                                    where INT_NO_BUDGET_EXP=$id and INT_REVISE=$rev and INT_FLG_DEL=0")->result();
        } elseif ($x == 's') {
            return $this->db->query("select INT_QUANTITY
                                    from CPL.TT_BUDGET_SUBEXPENSE 
                                    where INT_NO_BUDGET_EXP=$id and INT_REVISE=$rev and INT_FLG_DEL=0")->result();
        }
    }

    function get_price_per_unit($id, $rev) {
        return $this->db->query("select DEC_MONEY_PER_UNIT 
                                from CPL.TT_BUDGET_EXPENSE
                                where INT_NO_BUDGET_EXP=$id and INT_REVISE=$rev and INT_FLG_DEL=0")->row()->DEC_MONEY_PER_UNIT;
    }

    function is_pure_expense($id) {
        $x = $this->db->query("select INT_ID_UOM from CPL.TT_BUDGET_EXPENSE where INT_NO_BUDGET_EXP=" . $id)->row();
        if (trim($x->INT_ID_UOM) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update_total($data, $id, $rev) {
        $this->db->where('INT_NO_BUDGET_EXP', $id);
        $this->db->where('INT_REVISE', $rev);
        $this->db->update($this->tt_expense, $data);
    }

    function update_expense($id, $rev, $details) {
        $this->db->where('INT_NO_BUDGET_EXP', $id);
        $this->db->where('INT_REVISE', $rev);
        $this->db->update($this->tt_expense, $details);
    }

    function get_dept_from_expense($id) {
        return $this->db->query("select b.INT_ID_DEPT
                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c
                        where a.INT_ID_SECTION=c.INT_ID_SECTION and c.INT_ID_DEPT=b.INT_ID_DEPT
                        and a.INT_NO_BUDGET_EXP=$id")->row();
    }

    function get_new_money_subexpense($id, $rev) {
        $data = $this->db->query("select INT_QUANTITY
                                from CPL.TT_BUDGET_SUBEXPENSE
                                where INT_FLG_DEL=0 and INT_REVISE=$rev and INT_NO_BUDGET_EXP=$id")->result();
        $num = 0;
        foreach ($data as $value) {
            $num = $num + $value->INT_QUANTITY;
        }
        return $num;
    }

    function commit_expense($id, $fiscal) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case 1:
                $query = "";
                break;
            case 2:
                $query = "UPDATE a
                        SET a.INT_APPROVE=11, a.INT_LOCK=1,
                        a.CHR_MODI_BY='" . $session['USERNAME'] . "',  
                        a.CHR_MODI_DATE=" . date('Ymd') . ",
                        a.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT d, TM_DIVISION f, 
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w, TM_DIVISION q
                                where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                and w.INT_ID_DIVISION=q.INT_ID_DIVISION
                                and q.INT_ID_COMPANY=$id
                                group by x.INT_NO_BUDGET_EXP) e
                        WHERE a.INT_FLG_DEL=0 
                        and a.INT_ID_SECTION = b.INT_ID_SECTION
                        and b.INT_ID_DEPT = c.INT_ID_DEPT
                        and c.INT_ID_GROUP_DEPT = d.INT_ID_GROUP_DEPT
                        and d.INT_ID_DIVISION=f.INT_ID_DIVISION
                        and f.INT_ID_COMPANY=$id
                        and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal
                        and a.INT_NO_BUDGET_EXP=e.INT_NO_BUDGET_EXP and a.INT_REVISE=e.INT_REVISE";
                break;
            case 3:
                $query = "UPDATE a
                        SET a.INT_APPROVE=10, a.INT_LOCK=1,
                        a.CHR_MODI_BY='" . $session['USERNAME'] . "',  
                        a.CHR_MODI_DATE=" . date('Ymd') . ",
                        a.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT d,
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w
                                where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                and w.INT_ID_DIVISION=$id
                                group by x.INT_NO_BUDGET_EXP) e
                        WHERE d.INT_ID_DIVISION=$id and a.INT_FLG_DEL=0 
                        and a.INT_ID_SECTION = b.INT_ID_SECTION
                        and b.INT_ID_DEPT = c.INT_ID_DEPT
                        and c.INT_ID_GROUP_DEPT = d.INT_ID_GROUP_DEPT
                        and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal
                        and a.INT_NO_BUDGET_EXP=e.INT_NO_BUDGET_EXP and a.INT_REVISE=e.INT_REVISE";
                break;
            case 4:
                $query = "UPDATE a
                        SET a.INT_APPROVE=7, a.INT_LOCK=1,
                        a.CHR_MODI_BY='" . $session['USERNAME'] . "',  
                        a.CHR_MODI_DATE=" . date('Ymd') . ",
                        a.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c,
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                and z.INT_ID_GROUP_DEPT=$id
                                group by x.INT_NO_BUDGET_EXP) d
                        WHERE c.INT_ID_GROUP_DEPT=$id and a.INT_FLG_DEL=0 
                        and a.INT_ID_SECTION = b.INT_ID_SECTION
                        and b.INT_ID_DEPT = c.INT_ID_DEPT
                        and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal
                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP and a.INT_REVISE=d.INT_REVISE";
                break;
            case 5:
                $query = "UPDATE a
                        SET a.INT_APPROVE=4, a.INT_LOCK=1,
                        a.CHR_MODI_BY='" . $session['USERNAME'] . "',  
                        a.CHR_MODI_DATE=" . date('Ymd') . ",
                        a.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE a, TM_SECTION b,
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                where x.INT_FLG_DEL=0 and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
                                group by x.INT_NO_BUDGET_EXP) c
                        WHERE b.INT_ID_DEPT=$id and a.INT_FLG_DEL=0
                        and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal
                        and a.INT_ID_SECTION = b.INT_ID_SECTION
                        and a.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and a.INT_REVISE=c.INT_REVISE";
                break;
            case 6:
                $query = "UPDATE a
                        SET a.INT_APPROVE=1, a.INT_LOCK=1,
                        a.CHR_MODI_BY='" . $session['USERNAME'] . "', 
                        a.CHR_MODI_DATE=" . date('Ymd') . ",
                        a.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE a, 
                            (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                from CPL.TT_BUDGET_EXPENSE
                                where INT_ID_SECTION=$id and INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                                group by INT_NO_BUDGET_EXP) b
                        WHERE a.INT_ID_SECTION=$id and a.INT_FLG_DEL=0
                        and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal
                        and a.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP and a.INT_REVISE=b.INT_REVISE";
                break;
            default:
                break;
        }
        $this->db->query($query);
    }

    function reject_expense($id, $fiscal) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case 1:
                $query = "";
                break;
            case 3:
                $query = "UPDATE EX
                        SET EX.INT_APPROVE=6, EX.INT_LOCK=1,
                        EX.CHR_MODI_BY='" . $session['USERNAME'] . "',  
                        EX.CHR_MODI_DATE=" . date('Ymd') . ",
                        EX.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE EX, TM_SECTION SE, TM_DEPT DE,
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                                and z.INT_ID_GROUP_DEPT=$id
                                group by x.INT_NO_BUDGET_EXP) b
                        WHERE DE.INT_ID_GROUP_DEPT=$id and EX.INT_FLG_DEL=0 and EX.INT_UNBUDGET=0
                        and EX.INT_ID_SECTION = SE.INT_ID_SECTION
                        and SE.INT_ID_DEPT = DE.INT_ID_DEPT and EX.INT_ID_FISCAL_YEAR=$fiscal
                        and b.INT_NO_BUDGET_EXP=EX.INT_NO_BUDGET_EXP and b.INT_REVISE=EX.INT_REVISE";

                break;
            case 4:
                $query = "UPDATE EX
                        SET EX.INT_APPROVE=6, EX.INT_LOCK=1,
                        EX.CHR_MODI_BY='" . $session['USERNAME'] . "',
                        EX.CHR_MODI_DATE=" . date('Ymd') . ",
                        EX.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE EX, TM_SECTION SE, 
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                where  x.INT_FLG_DEL=0 and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
                                group by x.INT_NO_BUDGET_EXP) c
                        WHERE SE.INT_ID_DEPT=$id and EX.INT_FLG_DEL=0 and EX.INT_UNBUDGET=0 and EX.INT_ID_FISCAL_YEAR=$fiscal
                        and EX.INT_ID_SECTION = SE.INT_ID_SECTION 
                        and c.INT_NO_BUDGET_EXP=EX.INT_NO_BUDGET_EXP and c.INT_REVISE=EX.INT_REVISE";
                $all_rejected = "select a.*
                                from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b,
                                    (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                        from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                        where x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                        and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
                                        group by x.INT_NO_BUDGET_EXP) c
                                where a.INT_ID_SECTION=b.INT_ID_SECTION
                                and b.INT_ID_DEPT=$id and a.INT_FLG_DEL=0
                                and a.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP and a.INT_REVISE=c.INT_REVISE
                                and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal";
                break;
            case 5:
                $query = "UPDATE a
                        SET INT_APPROVE=3, INT_LOCK=1,
                        a.CHR_MODI_BY='" . $session['USERNAME'] . "', 
                        a.CHR_MODI_DATE=" . date('Ymd') . ",
                        a.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE a, 
                            (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                from CPL.TT_BUDGET_EXPENSE
                                where INT_ID_SECTION=$id and  INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                                group by INT_NO_BUDGET_EXP) b
                        WHERE b.INT_REVISE=a.INT_REVISE and b.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP 
                        and a.INT_ID_SECTION=$id and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal";
                $all_rejected = "select a.*
                                from CPL.TT_BUDGET_EXPENSE a,
                                    (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                        from CPL.TT_BUDGET_EXPENSE
                                        where INT_ID_SECTION=$id and INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                                        group by INT_NO_BUDGET_EXP) b
                                where a.INT_ID_SECTION=$id and a.INT_FLG_DEL=0 
                                and b.INT_REVISE=a.INT_REVISE and a.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP
                                and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal";
                break;
            default:
                break;
        }
        $this->db->query($query);
        return $this->db->query($all_rejected)->result();
    }

    function get_reject_detail($id, $rev, $x) {
        if ($x == 'e') {
            $table = "CPL.TT_BUDGET_PURE_EXPENSE";
        } else {
            $table = "CPL.TT_BUDGET_SUBEXPENSE";
        }
        return $this->db->query("select b.*
                    from CPL.TT_BUDGET_EXPENSE a, $table b
                    where a.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP and a.INT_REVISE=b.INT_REVISE
                    and a.INT_FLG_DEL=0 and a.INT_NO_BUDGET_EXP=$id and a.INT_REVISE=$rev")->result();
    }

    function unlock_expense($id, $fiscal) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case 1:
                $query = "";
                break;
            case 3:
                $query = "UPDATE EX
                        SET EX.INT_LOCK=0,
                        EX.CHR_MODI_BY='" . $session['USERNAME'] . "',  
                        EX.CHR_MODI_DATE=" . date('Ymd') . ",
                        EX.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE EX, TM_SECTION SE, TM_DEPT DE,
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                            where x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                            and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                            and z.INT_ID_GROUP_DEPT=$id
                            group by x.INT_NO_BUDGET_EXP) b
                        WHERE DE.INT_ID_GROUP_DEPT=$id and EX.INT_FLG_DEL=0 and EX.INT_UNBUDGET=0
                        and EX.INT_ID_SECTION = SE.INT_ID_SECTION
                        and SE.INT_ID_DEPT = DE.INT_ID_DEPT and EX.INT_ID_FISCAL_YEAR=$fiscal
                        and b.INT_NO_BUDGET_EXP=EX.INT_NO_BUDGET_EXP and b.INT_REVISE=EX.INT_REVISE";
                break;
            case 4:
                $query = "UPDATE EX
                        SET EX.INT_LOCK=0,
                        EX.CHR_MODI_BY='" . $session['USERNAME'] . "',
                        EX.CHR_MODI_DATE=" . date('Ymd') . ",
                        EX.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE EX, TM_SECTION SE, 
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                            where  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                            and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
                            group by x.INT_NO_BUDGET_EXP) b 
                        WHERE SE.INT_ID_DEPT=$id and EX.INT_FLG_DEL=0 and EX.INT_UNBUDGET=0 and EX.INT_ID_FISCAL_YEAR=$fiscal
                        and EX.INT_ID_SECTION = SE.INT_ID_SECTION 
                        and b.INT_NO_BUDGET_EXP=EX.INT_NO_BUDGET_EXP and b.INT_REVISE=EX.INT_REVISE";
                break;
            case 5:
                $query = "UPDATE a
                        SET INT_LOCK=0,
                        a.CHR_MODI_BY='" . $session['USERNAME'] . "', 
                        a.CHR_MODI_DATE=" . date('Ymd') . ",
                        a.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE a, 
                            (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                            from CPL.TT_BUDGET_EXPENSE
                            where INT_ID_SECTION=$id and  INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                            group by INT_NO_BUDGET_EXP) b
                        WHERE b.INT_REVISE=a.INT_REVISE and b.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP 
                        and a.INT_ID_SECTION=$id and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal";
                break;
            default:
                break;
        }
        $this->db->query($query);
    }

    function approve_expense($id, $fiscal) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case 1:
                $query = "";
                break;
            case 3:
                $query = "UPDATE EX
                        SET EX.INT_APPROVE=8, EX.INT_LOCK=1,
                        EX.CHR_MODI_BY='" . $session['USERNAME'] . "',  
                        EX.CHR_MODI_DATE=" . date('Ymd') . ",
                        EX.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE EX, TM_SECTION SE, TM_DEPT DE,
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                            where x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                            and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=z.INT_ID_DEPT
                            and z.INT_ID_GROUP_DEPT=$id
                            group by x.INT_NO_BUDGET_EXP) b 
                        WHERE DE.INT_ID_GROUP_DEPT=$id and EX.INT_FLG_DEL=0 and EX.INT_UNBUDGET=0
                        and EX.INT_ID_SECTION = SE.INT_ID_SECTION
                        and SE.INT_ID_DEPT = DE.INT_ID_DEPT and EX.INT_ID_FISCAL_YEAR=$fiscal
                        and b.INT_NO_BUDGET_EXP=EX.INT_NO_BUDGET_EXP and b.INT_REVISE=EX.INT_REVISE";
                break;
            case 4:
                $query = "UPDATE EX
                        SET EX.INT_APPROVE=5, EX.INT_LOCK=1,
                        EX.CHR_MODI_BY='" . $session['USERNAME'] . "',
                        EX.CHR_MODI_DATE=" . date('Ymd') . ",
                        EX.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE EX, TM_SECTION SE, 
                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                            where x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                            and x.INT_ID_SECTION=y.INT_ID_SECTION and y.INT_ID_DEPT=$id
                            group by x.INT_NO_BUDGET_EXP) b 
                        WHERE SE.INT_ID_DEPT=$id and EX.INT_FLG_DEL=0 and EX.INT_UNBUDGET=0 and EX.INT_ID_FISCAL_YEAR=$fiscal
                        and EX.INT_ID_SECTION = SE.INT_ID_SECTION 
                        and b.INT_NO_BUDGET_EXP=EX.INT_NO_BUDGET_EXP and b.INT_REVISE=EX.INT_REVISE";
                break;
            case 5:
                $query = "UPDATE a
                        SET a.INT_APPROVE=2, a.INT_LOCK=1, 
                        a.CHR_MODI_BY='" . $session['USERNAME'] . "', 
                        a.CHR_MODI_DATE=" . date('Ymd') . ",
                        a.CHR_MODI_TIME=" . date('His') . "
                        FROM CPL.TT_BUDGET_EXPENSE a, 
                            (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                            from CPL.TT_BUDGET_EXPENSE
                            where INT_ID_SECTION=$id and INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                            group by INT_NO_BUDGET_EXP) b
                        WHERE b.INT_REVISE=a.INT_REVISE and b.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP 
                        and a.INT_ID_SECTION=$id and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal";
                break;
            default:
                break;
        }
        $this->db->query($query);
    }

    function get_revise_status($fiscal, $id) {
        return $this->db->query("select count(a.INT_APPROVE) as REVISE
                                from CPL.TT_BUDGET_EXPENSE a,
                                (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                    from CPL.TT_BUDGET_EXPENSE
                                    where INT_ID_SECTION=$id and INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                                    group by INT_NO_BUDGET_EXP) b
                                where (INT_APPROVE=3 or INT_APPROVE=6 or INT_APPROVE=9) 
                                and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal
                                and a.INT_ID_SECTION=$id and a.INT_LOCK=0
                                and a.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP and a.INT_REVISE=b.INT_REVISE")->row()->REVISE;
    }

    function get_unbudget_status($fiscal, $id) {
        return $this->db->query("select count(a.INT_APPROVE) as REVISE
                                from CPL.TT_BUDGET_EXPENSE a,
                                    (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE, INT_APPROVE
                                    from CPL.TT_BUDGET_EXPENSE
                                    where INT_ID_SECTION=$id and INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                                    group by INT_NO_BUDGET_EXP, INT_APPROVE) b
                                where a.INT_APPROVE=11
                                and a.INT_FLG_DEL=0  and a.INT_ID_FISCAL_YEAR=$fiscal
                                and a.INT_ID_SECTION=$id 
                                and a.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP and a.INT_REVISE=b.INT_REVISE")->row()->REVISE;
    }

    function get_commited_status($fiscal, $id) {
        $session = $this->session->all_userdata();
        switch ($session['ROLE']) {
            case 1:

                break;
            case 2:
                $all_bud = $this->db->query("select count(a.INT_NO_BUDGET_EXP) as BUDGET
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c, TM_GROUP_DEPT e, TM_DIVISION f,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w, TM_DIVISION q
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                            and w.INT_ID_DIVISION=q.INT_ID_DIVISION
                                            and q.INT_ID_COMPANY=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT
                                        and e.INT_ID_DIVISION=f.INT_ID_DIVISION
                                        and f.INT_ID_COMPANY=$id")->row()->BUDGET;
                $ready = $this->db->query("select count(a.INT_APPROVE) as READY
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c, TM_GROUP_DEPT e,TM_DIVISION f,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w, TM_DIVISION q
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                            and w.INT_ID_DIVISION=q.INT_ID_DIVISION
                                            and q.INT_ID_COMPANY=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 10 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT
                                        and e.INT_ID_DIVISION=f.INT_ID_DIVISION
                                        and f.INT_ID_COMPANY=$id")->row()->READY;

                if ($all_bud == $ready) {
                    return '1';
                } else {
                    return '0';
                }
                break;
            case 3:
                $all_bud = $this->db->query("select count(a.INT_NO_BUDGET_EXP) as BUDGET
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c, TM_GROUP_DEPT e,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                            and w.INT_ID_DIVISION=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT
                                        and e.INT_ID_DIVISION=$id")->row()->BUDGET;
                $ready = $this->db->query("select count(a.INT_APPROVE) as READY
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c, TM_GROUP_DEPT e,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                            and w.INT_ID_DIVISION=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 8 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT
                                        and e.INT_ID_DIVISION=$id")->row()->READY;

                if ($all_bud == $ready) {
                    return '1';
                } else {
                    $commited = $this->db->query("select count(a.INT_APPROVE) as COMMITED
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c, TM_GROUP_DEPT e,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                            and w.INT_ID_DIVISION=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 10 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT
                                        and e.INT_ID_DIVISION=$id")->row()->COMMITED;
                    if ($commited > 0) {
                        return '2';
                    } else {
                        $need_approve = $this->db->query("select count(a.INT_APPROVE) as N
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c, TM_GROUP_DEPT e,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                            and w.INT_ID_DIVISION=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 7 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=e.INT_ID_GROUP_DEPT
                                        and e.INT_ID_DIVISION=$id")->row()->N;
                        if ($need_approve == 0) {
                            return '2';
                        } else {
                            return '0';
                        }
                    }
                }
                break;
            case 4:
                $all_bud = $this->db->query("select count(a.INT_NO_BUDGET_EXP) as BUDGET
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT  
                                            and z.INT_ID_GROUP_DEPT=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=$id")->row()->BUDGET;
                $ready = $this->db->query("select count(a.INT_APPROVE) as READY
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 5 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=$id")->row()->READY;

                if ($all_bud == $ready) {
                    return '1';
                } else {
                    $commited = $this->db->query("select count(a.INT_APPROVE) as COMMITED
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 7 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=$id")->row()->COMMITED;
                    if ($commited > 0) {
                        return '2';
                    } else {
                        $need_approve = $this->db->query("select count(a.INT_APPROVE) as N
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=z.INT_ID_DEPT
                                            and z.INT_ID_GROUP_DEPT=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 4 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_GROUP_DEPT=$id")->row()->N;
                        if ($need_approve == 0) {
                            return '2';
                        } else {
                            return '0';
                        }
                    }
                }

                break;
            case 5:
                $all_bud = $this->db->query("select count(a.INT_NO_BUDGET_EXP) as BUDGET
                                        from CPL.TT_BUDGET_EXPENSE  a, TM_DEPT b, TM_SECTION c,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_DEPT=$id")->row()->BUDGET;
                //approved by dept, ready to comm
                $ready = $this->db->query("select count(a.INT_APPROVE) as COMMITED
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c,
                                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 2 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_DEPT=$id")->row()->COMMITED;

                if ($all_bud == $ready) { //ready to comm 
                    return '1';
                } else {
                    //comm by dept
                    $commited = $this->db->query("select count(a.INT_APPROVE) as COMMITED
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c,
                                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 4 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_DEPT=$id")->row()->COMMITED;
                    if ($commited > 0) { // w8 for commit
                        return '2';
                    } else {
                        $need_approve = $this->db->query("select count(a.INT_APPROVE) as N
                                        from CPL.TT_BUDGET_EXPENSE a, TM_DEPT b, TM_SECTION c,
                                            (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE
                                            from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y
                                            where x.INT_ID_SECTION=y.INT_ID_SECTION
                                            and  x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                            and y.INT_ID_DEPT=$id
                                            group by x.INT_NO_BUDGET_EXP) d
                                        where a.INT_APPROVE = 1 
                                        and a.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                                        and a.INT_REVISE=d.INT_REVISE
                                        and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0
                                        and a.INT_ID_FISCAL_YEAR=$fiscal 
                                        and a.INT_ID_SECTION=c.INT_ID_SECTION 
                                        and c.INT_ID_DEPT=b.INT_ID_DEPT
                                        and b.INT_ID_DEPT=$id")->row()->N;
                        if ($need_approve == 0) {// some budget is rejected
                            return '2';
                        } else {
                            return '0';
                        }
                    }
                }

                break;
            case 6:
                return $this->db->query("select count(a.INT_APPROVE) as COMMITED
                                from CPL.TT_BUDGET_EXPENSE a,
                                    (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                    from CPL.TT_BUDGET_EXPENSE
                                    where INT_ID_SECTION=$id and  INT_UNBUDGET=0 and INT_ID_FISCAL_YEAR=$fiscal
                                    group by INT_NO_BUDGET_EXP) b
                                where a.INT_APPROVE <> 0 and a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 and a.INT_ID_FISCAL_YEAR=$fiscal 
                                and a.INT_ID_SECTION=$id and a.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP and a.INT_REVISE=b.INT_REVISE")->row();
                break;
            default:
                break;
        }
    }

    function get_final_expense($id, $fiscal) {
        return $this->db->query("select a.INT_NO_BUDGET_EXP, a.INT_REVISE, a.INT_ID_FISCAL_YEAR, a.INT_ID_SECTION,
                                a.INT_ID_BUDGET_SUB_CATEGORY, a.INT_ID_UOM, a.CHR_BUDGET_DESC, a.DEC_TOTAL
                                from CPL.TT_BUDGET_EXPENSE a, TM_SECTION b, TM_DEPT c, TM_GROUP_DEPT d, TM_DIVISION e,
                                        (select x.INT_NO_BUDGET_EXP, MAX(x.INT_REVISE) as INT_REVISE                                            
                                        from CPL.TT_BUDGET_EXPENSE x, TM_SECTION y, TM_DEPT z, TM_GROUP_DEPT w, TM_DIVISION q
                                        where x.INT_ID_SECTION=y.INT_ID_SECTION
                                        and x.INT_UNBUDGET=0 and x.INT_ID_FISCAL_YEAR=$fiscal
                                        and y.INT_ID_DEPT=z.INT_ID_DEPT
                                        and z.INT_ID_GROUP_DEPT=w.INT_ID_GROUP_DEPT
                                        and w.INT_ID_DIVISION=q.INT_ID_DIVISION
                                        and q.INT_ID_COMPANY=$id
                                        group by x.INT_NO_BUDGET_EXP) f
                                where a.INT_FLG_DEL=0 and a.INT_UNBUDGET=0 
                                and a.INT_NO_BUDGET_EXP=f.INT_NO_BUDGET_EXP
                                and a.INT_REVISE=f.INT_REVISE
                                and a.INT_ID_FISCAL_YEAR=$fiscal 
                                and a.INT_ID_SECTION=b.INT_ID_SECTION 
                                and c.INT_ID_DEPT=b.INT_ID_DEPT
                                and c.INT_ID_GROUP_DEPT=d.INT_ID_GROUP_DEPT
                                and e.INT_ID_DIVISION=d.INT_ID_DIVISION
                                and e.INT_ID_COMPANY=$id")->result();
    }

    function get_total_qty_plan($id) {
        return $this->db->query("select COUNT(b.INT_QUANTITY) as INT_QUANTITY
                                from CPL.TT_BUDGET_EXPENSE a, CPL.TT_BUDGET_SUBEXPENSE b,
                                    (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                    from CPL.TT_BUDGET_EXPENSE
                                    where   INT_ID_FISCAL_YEAR=2 
                                    and INT_NO_BUDGET_EXP=$id
                                    group by INT_NO_BUDGET_EXP) c
                                where b.INT_NO_BUDGET_EXP=a.INT_NO_BUDGET_EXP
                                and a.INT_REVISE=b.INT_REVISE
                                and a.INT_NO_BUDGET_EXP=c.INT_NO_BUDGET_EXP
                                and c.INT_REVISE=a.INT_REVISE
                                and a.INT_FLG_DEL=0 and a.INT_NO_BUDGET_EXP=$id")->row()->INT_QUANTITY;
    }

    function delete_existing_template($CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {        
        $this->db->query("delete from CPL.TW_BUDGET_EXPENSE WHERE  (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_SECT = $INT_SECT) AND (INT_DEPT = $INT_DEPT)  AND (INT_DIV = '$INT_DIV') ");
    }

    function get_detail_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("select * from  CPL.TT_BUDGET_EXPENSE where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV') order by CHR_NO_BUDGET")->result();
    }
    
    function get_detail_expense_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("select * from  CPL.TT_BUDGET_EXPENSE where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_FLAG_APP_GM == '1') AND (CHR_STAT_REV = '$CHR_STAT_REV') order by CHR_NO_BUDGET")->result();
    }

    function get_detail_expense_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("select * from  CPL.TT_BUDGET_EXPENSE where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV') order by CHR_NO_BUDGET")->result();
    }
    
    function get_detail_expense_sect($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("select * from  CPL.TT_BUDGET_EXPENSE where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (INT_SECT = '$INT_SECT') AND (CHR_STAT_REV = '$CHR_STAT_REV') order by CHR_NO_BUDGET")->result();
    }
    
    function get_detail_expense_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("select * from  CPL.TT_BUDGET_EXPENSE where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV') order by CHR_NO_BUDGET")->result();
    }
    
    function get_detail_expense_all_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("select * from  CPL.TT_BUDGET_EXPENSE where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (CHR_STAT_REV = '$CHR_STAT_REV') order by CHR_NO_BUDGET")->result();
    }

    function get_sum_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) 
                      AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, 
                      SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) 
                      AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, SUM(FLT_ADD_BLN01) AS FLT_ADD_BLN01, SUM(FLT_ADD_BLN02) AS FLT_ADD_BLN02, SUM(FLT_ADD_BLN03) 
                      AS FLT_ADD_BLN03, SUM(FLT_ADD_BLN04) AS FLT_ADD_BLN04, SUM(FLT_ADD_BLN05) AS FLT_ADD_BLN05, SUM(FLT_ADD_BLN06) AS FLT_ADD_BLN06, 
                      SUM(FLT_ADD_BLN07) AS FLT_ADD_BLN07, SUM(FLT_ADD_BLN08) AS FLT_ADD_BLN08, SUM(FLT_ADD_BLN09) AS FLT_ADD_BLN09, SUM(FLT_ADD_BLN10) 
                      AS FLT_ADD_BLN10, SUM(FLT_ADD_BLN11) AS FLT_ADD_BLN11, SUM(FLT_ADD_BLN12) AS FLT_ADD_BLN12, SUM(FLT_ADD_SUM) AS FLT_ADD_SUM
            FROM CPL.TT_BUDGET_EXPENSE
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }
    
    function get_sum_expense_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) 
                      AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, 
                      SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) 
                      AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, SUM(FLT_ADD_BLN01) AS FLT_ADD_BLN01, SUM(FLT_ADD_BLN02) AS FLT_ADD_BLN02, SUM(FLT_ADD_BLN03) 
                      AS FLT_ADD_BLN03, SUM(FLT_ADD_BLN04) AS FLT_ADD_BLN04, SUM(FLT_ADD_BLN05) AS FLT_ADD_BLN05, SUM(FLT_ADD_BLN06) AS FLT_ADD_BLN06, 
                      SUM(FLT_ADD_BLN07) AS FLT_ADD_BLN07, SUM(FLT_ADD_BLN08) AS FLT_ADD_BLN08, SUM(FLT_ADD_BLN09) AS FLT_ADD_BLN09, SUM(FLT_ADD_BLN10) 
                      AS FLT_ADD_BLN10, SUM(FLT_ADD_BLN11) AS FLT_ADD_BLN11, SUM(FLT_ADD_BLN12) AS FLT_ADD_BLN12, SUM(FLT_ADD_SUM) AS FLT_ADD_SUM
            FROM CPL.TT_BUDGET_EXPENSE
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') AND (CHR_FLAG_APP_GM == '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }

    function get_sum_expense_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) 
                      AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, 
                      SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) 
                      AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, SUM(FLT_ADD_BLN01) AS FLT_ADD_BLN01, SUM(FLT_ADD_BLN02) AS FLT_ADD_BLN02, SUM(FLT_ADD_BLN03) 
                      AS FLT_ADD_BLN03, SUM(FLT_ADD_BLN04) AS FLT_ADD_BLN04, SUM(FLT_ADD_BLN05) AS FLT_ADD_BLN05, SUM(FLT_ADD_BLN06) AS FLT_ADD_BLN06, 
                      SUM(FLT_ADD_BLN07) AS FLT_ADD_BLN07, SUM(FLT_ADD_BLN08) AS FLT_ADD_BLN08, SUM(FLT_ADD_BLN09) AS FLT_ADD_BLN09, SUM(FLT_ADD_BLN10) 
                      AS FLT_ADD_BLN10, SUM(FLT_ADD_BLN11) AS FLT_ADD_BLN11, SUM(FLT_ADD_BLN12) AS FLT_ADD_BLN12, SUM(FLT_ADD_SUM) AS FLT_ADD_SUM
            FROM CPL.TT_BUDGET_EXPENSE
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }
    
    function get_sum_expense_sect($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) 
                      AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, 
                      SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) 
                      AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, SUM(FLT_ADD_BLN01) AS FLT_ADD_BLN01, SUM(FLT_ADD_BLN02) AS FLT_ADD_BLN02, SUM(FLT_ADD_BLN03) 
                      AS FLT_ADD_BLN03, SUM(FLT_ADD_BLN04) AS FLT_ADD_BLN04, SUM(FLT_ADD_BLN05) AS FLT_ADD_BLN05, SUM(FLT_ADD_BLN06) AS FLT_ADD_BLN06, 
                      SUM(FLT_ADD_BLN07) AS FLT_ADD_BLN07, SUM(FLT_ADD_BLN08) AS FLT_ADD_BLN08, SUM(FLT_ADD_BLN09) AS FLT_ADD_BLN09, SUM(FLT_ADD_BLN10) 
                      AS FLT_ADD_BLN10, SUM(FLT_ADD_BLN11) AS FLT_ADD_BLN11, SUM(FLT_ADD_BLN12) AS FLT_ADD_BLN12, SUM(FLT_ADD_SUM) AS FLT_ADD_SUM
            FROM CPL.TT_BUDGET_EXPENSE
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (INT_SECT = '$INT_SECT') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }
    
    function get_sum_expense_dept_cpl($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) 
                      AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, 
                      SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) 
                      AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, SUM(FLT_ADD_BLN01) AS FLT_ADD_BLN01, SUM(FLT_ADD_BLN02) AS FLT_ADD_BLN02, SUM(FLT_ADD_BLN03) 
                      AS FLT_ADD_BLN03, SUM(FLT_ADD_BLN04) AS FLT_ADD_BLN04, SUM(FLT_ADD_BLN05) AS FLT_ADD_BLN05, SUM(FLT_ADD_BLN06) AS FLT_ADD_BLN06, 
                      SUM(FLT_ADD_BLN07) AS FLT_ADD_BLN07, SUM(FLT_ADD_BLN08) AS FLT_ADD_BLN08, SUM(FLT_ADD_BLN09) AS FLT_ADD_BLN09, SUM(FLT_ADD_BLN10) 
                      AS FLT_ADD_BLN10, SUM(FLT_ADD_BLN11) AS FLT_ADD_BLN11, SUM(FLT_ADD_BLN12) AS FLT_ADD_BLN12, SUM(FLT_ADD_SUM) AS FLT_ADD_SUM
            FROM CPL.TT_BUDGET_EXPENSE
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }
    
    function get_sum_expense_all_dept($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) 
                      AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, 
                      SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) 
                      AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, SUM(FLT_ADD_BLN01) AS FLT_ADD_BLN01, SUM(FLT_ADD_BLN02) AS FLT_ADD_BLN02, SUM(FLT_ADD_BLN03) 
                      AS FLT_ADD_BLN03, SUM(FLT_ADD_BLN04) AS FLT_ADD_BLN04, SUM(FLT_ADD_BLN05) AS FLT_ADD_BLN05, SUM(FLT_ADD_BLN06) AS FLT_ADD_BLN06, 
                      SUM(FLT_ADD_BLN07) AS FLT_ADD_BLN07, SUM(FLT_ADD_BLN08) AS FLT_ADD_BLN08, SUM(FLT_ADD_BLN09) AS FLT_ADD_BLN09, SUM(FLT_ADD_BLN10) 
                      AS FLT_ADD_BLN10, SUM(FLT_ADD_BLN11) AS FLT_ADD_BLN11, SUM(FLT_ADD_BLN12) AS FLT_ADD_BLN12, SUM(FLT_ADD_SUM) AS FLT_ADD_SUM
            FROM CPL.TT_BUDGET_EXPENSE
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (CHR_STAT_REV = '$CHR_STAT_REV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR")->result();
    }

    function get_detail_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select * from  CPL.TW_BUDGET_EXPENSE where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV')")->result();
    }

    function get_sum_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("SELECT     INT_SECT, INT_DEPT, INT_DIV, INT_ID_FISCAL_YEAR, CHR_BUDGET_TYPE, SUM(INT_QTY_BLN01) AS INT_QTY_BLN01, SUM(INT_QTY_BLN02) 
                      AS INT_QTY_BLN02, SUM(INT_QTY_BLN03) AS INT_QTY_BLN03, SUM(INT_QTY_BLN04) AS INT_QTY_BLN04, SUM(INT_QTY_BLN05) AS INT_QTY_BLN05, 
                      SUM(INT_QTY_BLN06) AS INT_QTY_BLN06, SUM(INT_QTY_BLN07) AS INT_QTY_BLN07, SUM(INT_QTY_BLN08) AS INT_QTY_BLN08, SUM(INT_QTY_BLN09) 
                      AS INT_QTY_BLN09, SUM(INT_QTY_BLN10) AS INT_QTY_BLN10, SUM(INT_QTY_BLN11) AS INT_QTY_BLN11, SUM(INT_QTY_BLN12) AS INT_QTY_BLN12, 
                      SUM(INT_QTY_SUM) AS INT_QTY_SUM, SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) 
                      AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06,
                       SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, 
                      SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                      SUM(MON_AMT_SUM) AS MON_AMT_SUM, SUM(FLT_ADD_BLN01) AS FLT_ADD_BLN01, SUM(FLT_ADD_BLN02) AS FLT_ADD_BLN02, SUM(FLT_ADD_BLN03) 
                      AS FLT_ADD_BLN03, SUM(FLT_ADD_BLN04) AS FLT_ADD_BLN04, SUM(FLT_ADD_BLN05) AS FLT_ADD_BLN05, SUM(FLT_ADD_BLN06) AS FLT_ADD_BLN06, 
                      SUM(FLT_ADD_BLN07) AS FLT_ADD_BLN07, SUM(FLT_ADD_BLN08) AS FLT_ADD_BLN08, SUM(FLT_ADD_BLN09) AS FLT_ADD_BLN09, SUM(FLT_ADD_BLN10) 
                      AS FLT_ADD_BLN10, SUM(FLT_ADD_BLN11) AS FLT_ADD_BLN11, SUM(FLT_ADD_BLN12) AS FLT_ADD_BLN12, SUM(FLT_ADD_SUM) AS FLT_ADD_SUM
            FROM CPL.TW_BUDGET_EXPENSE
            where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV')
            GROUP BY CHR_BUDGET_TYPE, INT_ID_FISCAL_YEAR, INT_DEPT, INT_SECT, INT_DIV")->result();
    }

    function get_sum_amt_confirm_expense($INT_ID_FISCAL_YEAR, $CHR_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT) {
        return $this->db->query("select CHR_ORG_CURR , SUM(MON_AMT_SUM) as sum from CPL.TW_BUDGET_EXPENSE where (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_ID_FISCAL_YEAR = $INT_ID_FISCAL_YEAR) AND (INT_DEPT = $INT_DEPT) AND (INT_SECT = $INT_SECT) AND (INT_DIV = '$INT_DIV') group by CHR_ORG_CURR")->result();
    }

    function delete_existing_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV) {
        $this->db->query("delete from CPL.TT_BUDGET_EXPENSE WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND  (CHR_BUDGET_TYPE = '$CHR_BUDGET_TYPE') AND (INT_SECT = $INT_SECT) AND (INT_DEPT = $INT_DEPT) AND (INT_DIV = '$INT_DIV')");
    }

    function get_no_budget($INT_ID_FISCAL_YEAR, $INT_ID_BUDGET_TYPE, $INT_DIV, $INT_DEPT, $INT_SECT, $CHR_BUDGET_TYPE, $CHR_STAT_REV) {
        $budget_type = $this->db->query("select CHR_BUDGET_TYPE from CPL.TM_BUDGET_TYPE where INT_ID_BUDGET_TYPE = '$INT_ID_BUDGET_TYPE'")->row();
        $CHR_TIPE_BUDGET = $budget_type->CHR_BUDGET_TYPE;
        $budget_number = $this->db->query("SELECT INT_NO_BUDGET FROM  CPL.TM_SEQ_NUMBER WHERE (CHR_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND (CHR_TIPE_BUDGET = '$CHR_TIPE_BUDGET') AND (INT_DIV = '$INT_DIV')")->row();
        if (count($budget_number) == 0) {
            $data = array(
                'CHR_FISCAL_YEAR' => $INT_ID_FISCAL_YEAR,
                'CHR_STAT_REV' => $CHR_STAT_REV,
                'CHR_TIPE_BUDGET' => $CHR_TIPE_BUDGET,
                'INT_DIV' => $INT_DIV,
                'INT_DEPT' => $INT_DEPT,
                'INT_SECT' => $INT_SECT
            );
            $this->db->insert($this->tm_seq, $data);
        }

        $get_div = $this->db->query("SELECT CHR_DIVISION FROM TM_DIVISION WHERE INT_ID_DIVISION = '$INT_DIV'")->row();
        $get_dept = $this->db->query("SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = '$INT_DEPT'")->row();
        $get_sect = $this->db->query("SELECT CHR_SECTION FROM TM_SECTION WHERE INT_ID_SECTION = '$INT_SECT'")->row();

        $div = $get_div->CHR_DIVISION;
        $dept = $get_dept->CHR_DEPT;
        $sect = $get_sect->CHR_SECTION;
        $year_bgt = substr($INT_ID_FISCAL_YEAR, -2);
        $budget_number_val = sprintf("%'.05d\n", $budget_number->INT_NO_BUDGET);
        if($CHR_STAT_REV == 'RMB'){
            $budget_number_val = "$CHR_TIPE_BUDGET/$sect/$CHR_STAT_REV/$year_bgt" . $budget_number_val;
        } else {
            $budget_number_val = "$CHR_TIPE_BUDGET/$sect/$year_bgt" . $budget_number_val;
        }
        

        $this->db->query("update CPL.TM_SEQ_NUMBER set INT_NO_BUDGET = INT_NO_BUDGET + 1 WHERE (CHR_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV') AND (CHR_TIPE_BUDGET = '$CHR_TIPE_BUDGET') AND (INT_DIV = '$INT_DIV')");
        return $budget_number_val;
    }

//====================== SUMMARY BUDGET ---- ADMIN ===========================//
    function get_summary_expense_div_admin($INT_ID_FISCAL_YEAR) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC
                                UNION
                                SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC) AS SUMMARY_DIVISION 
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC")->result();
    }

    function get_summary_expense_group_admin($INT_ID_FISCAL_YEAR) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC
                                UNION
                                SELECT CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC) AS SUMMARY_GROUP 
                                GROUP BY CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC")->result();
    }
    
    function get_summary_expense_dept_admin($INT_ID_FISCAL_YEAR) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC
                                UNION
                                SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC) AS SUMMARY_DEPT 
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }

    function get_summary_expense_admin_total($INT_ID_FISCAL_YEAR) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC
                                UNION
                                SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }

    function get_summary_expense_foh($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV') 
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE")->result();
    }

    function get_summary_expense_foh_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }

    function get_summary_expense_opx($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE")->result();
    }

    function get_summary_expense_opx_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }    
    

//====================== END SUMMARY BUDGET ---- ADMIN =======================//
//====================== SUMMARY BUDGET ---- ADMIN CPL =======================//
    function get_summary_expense_div_admin_cpl($INT_ID_FISCAL_YEAR) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC
                                UNION
                                SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC) AS SUMMARY_DIVISION 
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC")->result();
    }

    function get_summary_expense_group_admin_cpl($INT_ID_FISCAL_YEAR) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC
                                UNION
                                SELECT CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC) AS SUMMARY_GROUP 
                                GROUP BY CHR_GROUP_DEPT,CHR_GROUP_DEPT_DESC")->result();
    }
    
    function get_summary_expense_dept_admin_cpl($INT_ID_FISCAL_YEAR) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC
                                UNION
                                SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC) AS SUMMARY_DEPT 
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }

    function get_summary_expense_admin_total_cpl($INT_ID_FISCAL_YEAR) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC
                                UNION
                                SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }    
    
    function get_summary_expense_foh_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE")->result();
    }
    
    function get_summary_expense_foh_total_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }
    
    function get_summary_expense_opx_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_MAN, CHR_FLAG_APP_GM, CHR_FLAG_APP_DIR, CHR_FLAG_APP_COMPLETE")->result();
    }
    
    function get_summary_expense_opx_total_cpl($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }
//====================== END SUMMARY BUDGET ---- ADMIN CPL ===================//
//====================== SUMMARY BUDGET ---- DIREKTUR ========================//
    function get_summary_expense_div_dir($INT_ID_FISCAL_YEAR, $INT_DIV) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC
                                UNION
                                SELECT CHR_DIVISION, CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC) AS SUMMARY_DIVISION 
                                GROUP BY CHR_DIVISION, CHR_DIVISION_DESC")->result();
    }

    function get_summary_expense_group_dir($INT_ID_FISCAL_YEAR, $INT_DIV) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC
                                UNION
                                SELECT CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC) AS SUMMARY_GROUP 
                                GROUP BY CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC")->result();
    }
    
    function get_summary_expense_dept_dir($INT_ID_FISCAL_YEAR, $INT_DIV) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC
                                UNION
                                SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC) AS SUMMARY_DEPT 
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }

    function get_summary_expense_dir_total($INT_ID_FISCAL_YEAR, $INT_DIV) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC
                                UNION
                                SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }

    function get_summary_expense_foh_dir($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN")->result();
    }

    function get_summary_expense_foh_total_dir($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }

    function get_summary_expense_opx_dir($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN")->result();
    }

    function get_summary_expense_opx_total_dir($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_GM = '1') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }

//====================== END SUMMARY BUDGET ---- DIREKTUR ====================//
//====================== SUMMARY BUDGET ---- GM ==============================//
    function get_summary_expense_group_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC
                                UNION
                                SELECT CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_GROUP_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC) AS SUMMARY_GROUP 
                                GROUP BY CHR_GROUP_DEPT, CHR_GROUP_DEPT_DESC")->result();
    }
    
    function get_summary_expense_dept_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC
                                UNION
                                SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC) AS SUMMARY_DEPT
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }

    function get_summary_expense_gm_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC
                                UNION
                                SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }

    function get_summary_expense_foh_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC,CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN")->result();
    }

    function get_summary_expense_foh_total_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }

    function get_summary_expense_opx_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN")->result();
    }

    function get_summary_expense_opx_total_gm($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_FLAG_APP_MAN = '1') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }

//====================== END SUMMARY BUDGET ---- GM ==========================//
//====================== SUMMARY BUDGET ---- MAN =============================//
    function get_summary_expense_dept_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM (SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC
                                UNION
                                SELECT CHR_DEPT,CHR_DEPT_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DEPT ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DEPT = TM_DEPT.INT_ID_DEPT
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC) AS SUMMARY_DEPT
                                GROUP BY CHR_DEPT,CHR_DEPT_DESC")->result();
    }
    
    function get_summary_expense_man_total($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM 
                                (SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC
                                UNION
                                SELECT CHR_DIVISION_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                LEFT JOIN TM_DIVISION ON CPL.TT_BUDGET_EXPENSE_AMOUNT.INT_DIV = TM_DIVISION.INT_ID_DIVISION
                                WHERE (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_DIVISION_DESC) AS TABLE_TOT_DIVISION")->result();
    }
    
    function get_summary_expense_foh_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN")->result();
    }

    function get_summary_expense_foh_total_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }

    function get_summary_expense_opx_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN
                                UNION
                                SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_FLAG_APP_DIR, CHR_FLAG_APP_GM, CHR_FLAG_APP_MAN")->result();
    }

    function get_summary_expense_opx_total_man($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $INT_SECT) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                    SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC
                                    UNION
                                    SELECT CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC,
                                            SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                            SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                            SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                            SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                    FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                    where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (INT_SECT LIKE '$INT_SECT%') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                    GROUP BY CHR_BUDGET_CATEGORY, CHR_BUDGET_CATEGORY_DESC) AS TABLE_SUMMARY_OPX")->result();
    }

//====================== END SUMMARY BUDGET ---- MAN =========================//
    
    function get_category_expense_foh($INT_ID_FISCAL_YEAR){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR'  AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR'  AND (CHR_STAT_REV = '$CHR_STAT_REV') ) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_opx($INT_ID_FISCAL_YEAR){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR'  AND (CHR_STAT_REV = '$CHR_STAT_REV') 
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND (CHR_STAT_REV = '$CHR_STAT_REV')) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_foh_cpl($INT_ID_FISCAL_YEAR){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV')) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_opx_cpl($INT_ID_FISCAL_YEAR){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV')) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_foh_dept($INT_ID_FISCAL_YEAR, $INT_DEPT){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_DEPT = '$INT_DEPT' AND (CHR_STAT_REV = '$CHR_STAT_REV') 
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_DEPT = '$INT_DEPT' AND (CHR_STAT_REV = '$CHR_STAT_REV')) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_foh_dept_cpl($INT_ID_FISCAL_YEAR, $INT_DEPT){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_DEPT = '$INT_DEPT' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV') 
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_DEPT = '$INT_DEPT' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV') ) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_opx_dept($INT_ID_FISCAL_YEAR, $INT_DEPT){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_DEPT = '$INT_DEPT' AND (CHR_STAT_REV = '$CHR_STAT_REV') 
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_DEPT = '$INT_DEPT' AND (CHR_STAT_REV = '$CHR_STAT_REV') ) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_opx_dept_cpl($INT_ID_FISCAL_YEAR, $INT_DEPT){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_DEPT = '$INT_DEPT' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV') 
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_DEPT = '$INT_DEPT' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV') ) AS ALL_CATEGORY")->result();
    }
    
    function get_expense_foh_by_category($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_CATEGORY) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_BUDGET_CATEGORY = '$CHR_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC
                                UNION
                                SELECT CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'FOH%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_BUDGET_CATEGORY = '$CHR_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC) AS SUMMARY_TABLE
                                GROUP BY CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC")->result();
    }
    
    function get_expense_opx_by_category($INT_ID_FISCAL_YEAR, $INT_DIV, $INT_GROUP, $INT_DEPT, $CHR_CATEGORY) {
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM (SELECT CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_BUDGET_CATEGORY = '$CHR_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC
                                UNION
                                SELECT CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC,
                                        SUM(MON_AMT_BLN01) AS MON_AMT_BLN01, SUM(MON_AMT_BLN02) AS MON_AMT_BLN02, SUM(MON_AMT_BLN03) AS MON_AMT_BLN03, SUM(MON_AMT_BLN04) AS MON_AMT_BLN04, 
                                        SUM(MON_AMT_BLN05) AS MON_AMT_BLN05, SUM(MON_AMT_BLN06) AS MON_AMT_BLN06, SUM(MON_AMT_BLN07) AS MON_AMT_BLN07, SUM(MON_AMT_BLN08) AS MON_AMT_BLN08, 
                                        SUM(MON_AMT_BLN09) AS MON_AMT_BLN09, SUM(MON_AMT_BLN10) AS MON_AMT_BLN10, SUM(MON_AMT_BLN11) AS MON_AMT_BLN11, SUM(MON_AMT_BLN12) AS MON_AMT_BLN12, 
                                        SUM(MON_AMT_SUM) AS MON_AMT_SUM
                                FROM CPL.TT_BUDGET_EXPENSE_AMOUNT
                                where (CHR_BUDGET_CATEGORY like 'OPX%') AND (INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR') AND (INT_DIV = '$INT_DIV') AND (INT_GROUP_DEPT = '$INT_GROUP') AND (INT_DEPT = '$INT_DEPT') AND (CHR_BUDGET_CATEGORY = '$CHR_CATEGORY') AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                GROUP BY CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC) AS SUMMARY_TABLE
                                GROUP BY CHR_CODE_CATEGORY_A3_DESC, CHR_BUDGET_CATEGORY_DESC, CHR_BUDGET_SUB_CATEGORY_DESC")->result();
    }
    
    function get_category_expense_foh_group($INT_ID_FISCAL_YEAR, $INT_GROUP){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_GROUP_DEPT = '$INT_GROUP' AND (CHR_STAT_REV = '$CHR_STAT_REV') 
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_GROUP_DEPT = '$INT_GROUP' AND (CHR_STAT_REV = '$CHR_STAT_REV')) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_foh_group_cpl($INT_ID_FISCAL_YEAR, $INT_GROUP){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_GROUP_DEPT = '$INT_GROUP' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'FOH%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_GROUP_DEPT = '$INT_GROUP' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV')) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_opx_group($INT_ID_FISCAL_YEAR, $INT_GROUP){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_GROUP_DEPT = '$INT_GROUP' AND (CHR_STAT_REV = '$CHR_STAT_REV')  
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_GROUP_DEPT = '$INT_GROUP' AND (CHR_STAT_REV = '$CHR_STAT_REV')) AS ALL_CATEGORY")->result();
    }
    
    function get_category_expense_opx_group_cpl($INT_ID_FISCAL_YEAR, $INT_GROUP){
        $CHR_STAT_REV = 'RMB'; //'NEW'
        return $this->db->query("SELECT DISTINCT CHR_BUDGET_CATEGORY
                                 FROM (SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_GROUP_DEPT = '$INT_GROUP' AND CHR_FLAG_APP_GM = '1'  AND (CHR_STAT_REV = '$CHR_STAT_REV')
                                        UNION 
                                       SELECT CHR_BUDGET_CATEGORY FROM CPL.TT_BUDGET_EXPENSE_AMOUNT WHERE CHR_BUDGET_CATEGORY LIKE 'OPX%' AND INT_ID_FISCAL_YEAR = '$INT_ID_FISCAL_YEAR' AND INT_GROUP_DEPT = '$INT_GROUP' AND CHR_FLAG_APP_GM = '1' AND (CHR_STAT_REV = '$CHR_STAT_REV')) AS ALL_CATEGORY")->result();
    }

    function cek_match_sub_category($kode_sub, $sub_cat){
        return $this->db->query("SELECT * FROM CPL.TM_BUDGET_SUB_CATEGORY WHERE CHR_BUDGET_SUB_CATEGORY = '$kode_sub' AND CHR_BUDGET_SUB_CATEGORY_DESC = '$sub_cat'")->num_rows();
    }

    function cek_match_category($kode_cat, $cat){
        return $this->db->query("SELECT * FROM CPL.TM_BUDGET_CATEGORY WHERE CHR_BUDGET_CATEGORY = '$kode_cat' AND CHR_BUDGET_CATEGORY_DESC = '$cat'")->num_rows();
    }

    function cek_match_category_a3($kode_a3, $cat_a3){
        return $this->db->query("SELECT * FROM CPL.TM_BUDGET_CATEGORY_A3 WHERE CHR_CODE_CATEGORY_A3 = '$kode_a3' AND CHR_DESC_CATEGORY_A3 = '$cat_a3'")->num_rows();
    }
    
}

?>
 