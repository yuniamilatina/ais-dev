<?php

class purchase_request_detail_m extends CI_Model {

    private $table = 'TW_BUDGET_PUREQ_BUDGET';
    private $table_tt = 'TT_BUDGET_PUREQ_BUDGET';

    //show all detail tewe
    function get_purchase_request_detail_temp() {
        $query = $this->db->query("select a.INT_NO_PUREQ_TEMP, a.INT_NO_BUDGET, a.DEC_PRICE_PER_UNIT, a.CHR_PURCHASE_ITEM,a.INT_QUANTITY, a.DEC_PRICE_PER_UNIT*a.INT_QUANTITY as TOTAL,
            a.INT_ID_UNIT, a.CHR_SUPPLIER_NAME, a.CHR_REQUESTOR
            from TW_BUDGET_PUREQ_BUDGET a,TT_BUDGET b
            where b.INT_NO_BUDGET = a.INT_NO_BUDGET");

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return true;
        }
    }

    //data detail tt
    function get_purchase_request_detail($no_purchase_request) {
        $query = $this->db->query("select a.INT_NO_PUREQ, a.INT_NO_BUDGET, a.DEC_PRICE_PER_UNIT, a.CHR_PURCHASE_ITEM,a.INT_QUANTITY, a.DEC_PRICE_PER_UNIT*a.INT_QUANTITY as TOTAL, 
		 CASE a.INT_MONTH_ESTIMATE
            WHEN '1' THEN 'Jan'  
            WHEN '2' THEN 'Feb' 
            WHEN '3' THEN 'Mar' 
            WHEN '4' THEN 'Apr' 
            WHEN '5' THEN 'May' 
            WHEN '6' THEN 'Jun' 
            WHEN '7' THEN 'Jul' 
            WHEN '8' THEN 'Aug' 
            WHEN '9' THEN 'Sep' 
            WHEN '10' THEN 'Oct'
            WHEN '11' THEN 'Nov' 
            ELSE 'Dec' END as INT_MONTH_ESTIMATE, b.CHR_BUDGET_NAME,
            a.INT_ID_UNIT, a.CHR_SUPPLIER_NAME, a.CHR_REQUESTOR, a.CHR_REMARK
            from TT_BUDGET_PUREQ_BUDGET a,TT_BUDGET b
            where b.INT_NO_BUDGET = a.INT_NO_BUDGET and a.INT_NO_PUREQ = $no_purchase_request");

        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return true;
        }
    }

    //data detail tt
    function get_data_purchase_request_detail($no_budget, $no_purchase_request) {
        $query = $this->db->query("select a.INT_NO_PUREQ, a.INT_NO_BUDGET, a.DEC_PRICE_PER_UNIT, a.CHR_PURCHASE_ITEM,a.INT_QUANTITY,
            a.INT_ID_UNIT, a.CHR_SUPPLIER_NAME, a.CHR_REQUESTOR, a.CHR_REMARK
            from TT_BUDGET_PUREQ_BUDGET a,TT_BUDGET b
            where b.INT_NO_BUDGET = a.INT_NO_BUDGET and a.INT_NO_PUREQ = '" . $no_purchase_request . "' and a.INT_NO_BUDGET = '" . $no_budget . "'");

        if ($query->num_rows() >= 1) {
            return $query;
        } else {
            return true;
        }
    }

    //ada tidaknya tw
    function get_flag_exixs() {
        $query = $this->db->query("select a.INT_NO_PUREQ_TEMP, a.INT_NO_BUDGET
            from TW_BUDGET_PUREQ_BUDGET a,TT_BUDGET b
            where b.INT_NO_BUDGET = a.INT_NO_BUDGET");

        if ($query->num_rows() >= 1) {
            return false;
        } else {
            return true;
        }
    }

    function get_limit_budget($no_budget) {
        $query = $this->db->query("select sum(DEC_PRICE_PER_UNIT) as total from TT_BUDGET_PUREQ_BUDGET where INT_NO_BUDGET = '" . $no_budget . "'")->row_array();
        $total = $query['total'];
        return $total;
    }

    function get_limit_purchase() {
        $query = $this->db->query("select sum(DEC_PRICE_PER_UNIT) as total from TW_BUDGET_PUREQ_BUDGET")->row_array();
        $total = $query['total'];
        return $total;
    }

    public function get_budget($fiscal, $cip, $section) {
        $this->db->select('a.INT_NO_BUDGET');
        $this->db->from('TT_BUDGET_PUREQ_BUDGET a');
        $this->db->join('TT_BUDGET_PUREQ b', 'a.INT_NO_PUREQ = b.INT_NO_PUREQ', 'left');
        $this->db->where('INT_ID_FISCAL_YEAR', $fiscal);
        $query = $this->db->get()->result();

        $this->db->select('a.INT_NO_BUDGET, a.INT_NO_BUDGET_CPX, a.CHR_BUDGET_NAME, c.CHR_FISCAL_YEAR, b.INT_QUANTITY, b.INT_MONTH_PLAN,
                d.CHR_SECTION, a.DEC_TOTAL');
        $this->db->from('TT_BUDGET a');
        $this->db->join('TT_BUDGET_CAPEX b', 'a.INT_NO_BUDGET_CPX = b.INT_NO_BUDGET_CPX', 'left');
        $this->db->join('TM_FISCAL c', 'a.INT_ID_FISCAL_YEAR = c.INT_ID_FISCAL_YEAR', 'left');
        $this->db->join('TM_SECTION d', 'a.INT_ID_SECTION = d.INT_ID_SECTION', 'left');
        $this->db->where('a.INT_ID_SECTION', $section);
        $this->db->where('BIT_FLG_CIP', $cip);
        foreach ($query as $row) {
            $where = "(INT_NO_BUDGET <>'" . $row->INT_NO_BUDGET . "')";
            $this->db->where($where);
        }

        $query_in_query = $this->db->get()->result();
        return $query_in_query;
    }

    function get_budget_e($fiscal, $section, $filter) {
        $query = "select a.INT_NO_BUDGET, a.INT_ID_FISCAL_YEAR, a.CHR_BUDGET_NAME, b.CHR_BUDGET_SUB_CATEGORY,
                b.CHR_BUDGET_SUB_CATEGORY_DESC, a.INT_ID_UNIT, a.DEC_TOTAL
                from TT_BUDGET a, TM_BUDGET_SUB_CATEGORY b
                where a.BIT_FLG_CPX=0 
                and a.INT_ID_BUDGET_SUB_CATEGORY=b.INT_ID_BUDGET_SUB_CATEGORY
                and a.INT_ID_FISCAL_YEAR=$fiscal and a.INT_ID_SECTION=$section";
        if ($filter != NULL && $filter != 0) {
            $query = "select a.INT_NO_BUDGET, a.INT_ID_FISCAL_YEAR, a.CHR_BUDGET_NAME, b.CHR_BUDGET_SUB_CATEGORY,
                b.CHR_BUDGET_SUB_CATEGORY_DESC, a.INT_ID_UNIT, a.DEC_TOTAL
                from TT_BUDGET a, TM_BUDGET_SUB_CATEGORY b, TM_BUDGET_CATEGORY c
                where a.BIT_FLG_CPX=0 
                and a.INT_ID_BUDGET_SUB_CATEGORY=b.INT_ID_BUDGET_SUB_CATEGORY
                and b.INT_ID_BUDGET_CATEGORY = c.INT_ID_BUDGET_CATEGORY
                and c.INT_ID_BUDGET_TYPE=$filter
                and a.INT_ID_FISCAL_YEAR=$fiscal and a.INT_ID_SECTION=$section";
        }
        return $this->db->query($query)->result();
    }

    function get_minus_budget_e($fiscal, $section) {
        return $this->db->query("select a.INT_NO_BUDGET, sum(a.DEC_TOTAL) as DEC_TOTAL
                            from TT_BUDGET_PUREQ_BUDGET a, TT_BUDGET_PUREQ b
                            where b.BIT_FLG_DEL=0 and b.INT_ID_SECTION=$section and b.BIT_FLG_CPX=0
                            and b.INT_ID_FISCAL_YEAR=$fiscal and a.INT_NO_PUREQ=b.INT_NO_PUREQ
                            group by a.INT_NO_BUDGET")->result();
    }

    function get_total_remain($fiscal, $section) {
        return $this->db->query("select sum(a.DEC_TOTAL) as DEC_TOTAL
                                from TT_BUDGET_PUREQ_BUDGET a, TT_BUDGET_PUREQ b
                                where b.BIT_FLG_DEL=0 and b.INT_ID_SECTION=$section and b.BIT_FLG_CPX=0
                                and b.INT_ID_FISCAL_YEAR=$fiscal and a.INT_NO_PUREQ=b.INT_NO_PUREQ")->row()->DEC_TOTAL;
    }

    function get_total_budget($fiscal, $section) {
        return $this->db->query("select sum(a.DEC_TOTAL) as DEC_TOTAL
                                from TT_BUDGET a, TM_BUDGET_SUB_CATEGORY b
                                where a.BIT_FLG_CPX=0 
                                and a.INT_ID_BUDGET_SUB_CATEGORY=b.INT_ID_BUDGET_SUB_CATEGORY
                                and a.INT_ID_FISCAL_YEAR=$fiscal and a.INT_ID_SECTION=$section")->row()->DEC_TOTAL;
    }

    function get_temp_table($section) {
        $this->db->where('INT_ID_SECTION', $section);
        return $this->db->get('TW_BUDGET_PUREQ_EXPENSE')->result();
    }

    function get_temp_table_total($section) {
        return $this->db->query("select sum(DEC_TOTAL) as TOTAL
                                from TW_BUDGET_PUREQ_EXPENSE
                                where INT_ID_SECTION=$section")->row()->TOTAL;
    }

    function get_budget_head_e($id, $fiscal) {
        return $this->db->query("select a.INT_NO_BUDGET, a.INT_ID_UNIT, a.CHR_BUDGET_NAME, b.DEC_MONEY_PER_UNIT,
                                a.DEC_TOTAL, c.CHR_FISCAL_YEAR_START, c.CHR_FISCAL_YEAR_END
                                from TT_BUDGET a, TM_FISCAL c, TT_BUDGET_EXPENSE b,
                                    (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                                    from TT_BUDGET_EXPENSE
                                    where BIT_FLG_DEL=0 and INT_ID_FISCAL_YEAR=$fiscal
                                    and INT_NO_BUDGET_EXP=$id
                                    group by INT_NO_BUDGET_EXP) d
                                where a.INT_ID_FISCAL_YEAR=$fiscal and a.INT_NO_BUDGET=$id
                                and a.INT_ID_FISCAL_YEAR=c.INT_ID_FISCAL_YEAR
                                and a.INT_NO_BUDGET=b.INT_NO_BUDGET_EXP
                                and a.BIT_FLG_CPX=0
                                and d.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP
                                and d.INT_REVISE=b.INT_REVISE")->row();
    }

    function get_budget_head_minus_e($id, $fiscal) {
        return $this->db->query("select a.INT_NO_BUDGET, sum(a.DEC_TOTAL) as DEC_TOTAL
                                from TT_BUDGET_PUREQ_BUDGET a, TT_BUDGET_PUREQ b
                                where b.BIT_FLG_DEL=0 and b.BIT_FLG_CPX=0
                                and b.INT_ID_FISCAL_YEAR=$fiscal and a.INT_NO_PUREQ=b.INT_NO_PUREQ
                                and a.INT_NO_BUDGET=$id
                                group by a.INT_NO_BUDGET")->row()->DEC_TOTAL;
    }

    function save_temp_pureq_expense($data) {
        $this->db->insert('TW_BUDGET_PUREQ_EXPENSE', $data);
    }

    function delete_temp_pureq_expense($section) {
        $this->db->where('INT_ID_SECTION', $section);
        $this->db->delete('TW_BUDGET_PUREQ_EXPENSE');
    }

    function get_total_qty_real($id) {
        return $this->db->query("select COUNT(b.INT_QUANTITY) as INT_QUANTITY
                                from TT_BUDGET_PUREQ a, TT_BUDGET_PUREQ_BUDGET b
                                where a.INT_NO_PUREQ=b.INT_NO_PUREQ
                                and b.INT_NO_BUDGET=$id")->row()->INT_QUANTITY;
    }

    function get_budget_detail_e($id, $fiscal, $eos) {
        if ($eos == 'e') {
            $query = "select a.INT_NO_BUDGET, d.INT_MONTH_PLAN,d.DEC_MONEY_EXPENSE
                    from TT_BUDGET a, TT_BUDGET_EXPENSE b, 
                    (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                        from TT_BUDGET_EXPENSE
                        where BIT_FLG_DEL=0 and INT_ID_FISCAL_YEAR=$fiscal 
                        and INT_NO_BUDGET_EXP=$id
                        group by INT_NO_BUDGET_EXP) c, TT_BUDGET_PURE_EXPENSE d
                    where a.INT_ID_FISCAL_YEAR=$fiscal and a.INT_NO_BUDGET=$id 
                    and BIT_FLG_CPX=0 
                    and a.INT_NO_BUDGET=b.INT_NO_BUDGET_EXP
                    and b.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                    and c.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP
                    and c.INT_REVISE=b.INT_REVISE
                    and c.INT_REVISE=d.INT_REVISE";
        } else {
            $query = "select a.INT_NO_BUDGET, d.INT_MONTH_PLAN,d.INT_QUANTITY
                    from TT_BUDGET a, TT_BUDGET_EXPENSE b, 
                    (select INT_NO_BUDGET_EXP, MAX(INT_REVISE) as INT_REVISE
                        from TT_BUDGET_EXPENSE
                        where BIT_FLG_DEL=0 and INT_ID_FISCAL_YEAR=$fiscal 
                        and INT_NO_BUDGET_EXP=$id 
                        group by INT_NO_BUDGET_EXP) c, TT_BUDGET_SUBEXPENSE d
                    where a.INT_ID_FISCAL_YEAR=$fiscal and a.INT_NO_BUDGET=$id 
                    and BIT_FLG_CPX=0 
                    and a.INT_NO_BUDGET=b.INT_NO_BUDGET_EXP
                    and b.INT_NO_BUDGET_EXP=d.INT_NO_BUDGET_EXP
                    and c.INT_NO_BUDGET_EXP=b.INT_NO_BUDGET_EXP
                    and c.INT_REVISE=b.INT_REVISE
                    and c.INT_REVISE=d.INT_REVISE";
        }
        return $this->db->query($query)->result();
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function save_pureq_detail_expense($data) {
        $this->db->insert('TT_BUDGET_PUREQ_BUDGET', $data);
    }

    //pindah dari tw ke tt
    function saving($no_purchase_request) {
        $this->db->select('INT_NO_BUDGET, DEC_PRICE_PER_UNIT,INT_QUANTITY,CHR_PURCHASE_ITEM');
        $this->db->from('TW_BUDGET_PUREQ_BUDGET');
        $query_pureq_temp = $this->db->get()->result_array();

        foreach ($query_pureq_temp as $row) {
            $data = array(
                'INT_NO_PUREQ' => $no_purchase_request,
                'INT_NO_BUDGET' => $row['INT_NO_BUDGET'],
                'DEC_PRICE_PER_UNIT' => $row['DEC_PRICE_PER_UNIT'],
                'INT_QUANTITY' => $row['INT_QUANTITY'],
                'CHR_PURCHASE_ITEM' => $row['CHR_PURCHASE_ITEM']
            );

            $this->db->insert('TT_BUDGET_PUREQ_BUDGET', $data);
        }

        $total = $this->get_limit_purchase();
        $data_pureq = array('DEC_TOTAL' => $total);
        $this->purchase_request_m->update($data_pureq, $no_purchase_request);
    }

    function update_temp($data, $no_budget, $no_pureq_temp) {
        $this->db->where('INT_NO_BUDGET', $no_budget);
        $this->db->where('INT_NO_PUREQ_TEMP', $no_pureq_temp);
        $this->db->update($this->table, $data
        );
    }

    function update($data, $no_budget, $no_pureq_temp) {
        $this->db->where('INT_NO_BUDGET', $no_budget);
        $this->db->where('INT_NO_PUREQ', $no_pureq_temp);
        $this->db->update('TT_BUDGET_PUREQ_BUDGET', $data
        );
    }

    //delete all tw
    function delete() {
        $this->db->query('delete from TW_BUDGET_PUREQ_BUDGET');
    }

    function delete_detail($no_budget, $no_pureq_temp) {
        $this->db->where('INT_NO_BUDGET', $no_budget);
        $this->db->where('INT_NO_PUREQ_TEMP', $no_pureq_temp);
        $this->db->delete('TW_BUDGET_PUREQ_BUDGET');
    }
    
}

?>
