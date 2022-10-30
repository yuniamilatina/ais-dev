<?php

class budgetcapexdetail_m extends CI_Model {

    private $table = 'TW_BUDGET_CAPEX_DETAIL';

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    //get detail
    function get_capex_plan_temp_detail($no_budget_temp) {
        $query = $this->db->query("select b.INT_NO_BUDGET_CPX_TEMP, b.INT_QUANTITY, b.DEC_PRICE_PER_UNIT, b.INT_REVISE,
            b.INT_APPROVE1,b.INT_APPROVE2,b.INT_APPROVE3,
            CASE b.INT_MONTH_PLAN 
            WHEN '1' THEN 'Jan' WHEN '2' THEN 'Feb' WHEN '3' THEN 'Mar' WHEN '4' THEN 'Apr' WHEN '5' THEN 'May' 
            WHEN '6' THEN 'Jun' WHEN '7' THEN 'Jul' WHEN '8' THEN 'Aug' WHEN '9' THEN 'Sep' WHEN '10' THEN 'Oct'
            WHEN '11' THEN 'Nov' ELSE 'Dec' END as INT_MONTH_PLAN, b.INT_APPROVE1,b.INT_APPROVE2,b.INT_APPROVE3,
            CASE b.INT_APPROVE1 WHEN '1' THEN 'Approve' WHEN '2' THEN 'Not Approve' ELSE '-' END as CHR_APPROVE1,
            CASE b.INT_APPROVE2 WHEN '1' THEN 'Approve' WHEN '2' THEN 'Not Approve' ELSE '-' END as CHR_APPROVE2,
            CASE b.INT_APPROVE3 WHEN '1' THEN 'Approve' WHEN '2' THEN 'Not Approve' ELSE '-' END as CHR_APPROVE3,
            (b.DEC_PRICE_PER_UNIT)*(b.INT_QUANTITY) as JUMLAH
            from TW_BUDGET_CAPEX_DETAIL b,TW_BUDGET_CAPEX a 
            where b.INT_NO_BUDGET_CPX_TEMP = a.INT_NO_BUDGET_CPX_TEMP and b.INT_NO_BUDGET_CPX_TEMP = '" . $no_budget_temp . "'");
        return $query->result();
    }

    function update($data, $no_budget_temp, $revise) {
        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $no_budget_temp);
        $this->db->where('INT_REVISE', $revise);
        $this->db->update($this->table, $data);
    }

    function approve($id_fiscal, $id_section) {
        $this->db->select('INT_NO_BUDGET_CPX_TEMP, INT_REVISE');
        $this->db->from('TW_BUDGET_CAPEX');
        $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
        $this->db->where('INT_ID_SECTION', $id_section);
        $query_budget = $this->db->get()->result_array();

        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 3) {
            $data = array(
                'INT_APPROVE3' => 1
            );
        } else if ($session['ROLE'] === 4) {
            $data = array(
                'INT_APPROVE2' => 1
            );
        } else if ($session['ROLE'] === 5) {
            $data = array(
                'INT_APPROVE1' => 1
            );
        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $data = array(
                'INT_APPROVE1' => 1,
                'INT_APPROVE2' => 1,
                'INT_APPROVE3' => 1
            );
        }

        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
            $this->db->where('INT_REVISE', $row['INT_REVISE']);
            $this->db->update('TW_BUDGET_CAPEX', $data);
        }

        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
            $this->db->where('INT_REVISE', $row['INT_REVISE']);
            $this->db->update($this->table, $data);
        }
    }

    function reject($no_budget_temp) {
        $session = $this->session->all_userdata();
        if ($session['ROLE'] === 3) {
            $data = array(
                'INT_APPROVE3' => 2
            );
        } else if ($session['ROLE'] === 4) {
            $data = array(
                'INT_APPROVE2' => 2
            );
        } else if ($session['ROLE'] === 5) {
            $data = array(
                'INT_APPROVE1' => 2
            );
        } else if ($session['ROLE'] === 1 || $session['ROLE'] === 2) {
            $data = array(
                'INT_APPROVE1' => 2,
                'INT_APPROVE2' => 2,
                'INT_APPROVE3' => 2
            );
        }
        
        $this->db->select('INT_REVISE');
        $this->db->from('TW_BUDGET_CAPEX');
        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $no_budget_temp);
        $query = $this->db->get()->row_array();

        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $no_budget_temp);
        $this->db->update('TW_BUDGET_CAPEX', $data);

        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $no_budget_temp);
        $this->db->where('INT_REVISE', $query['INT_REVISE']);
        $this->db->update($this->table, $data);
    }

    function approve_by_manager($id_fiscal, $id_section) {
        $this->db->select('INT_NO_BUDGET_CPX_TEMP, INT_REVISE');
        $this->db->from('TW_BUDGET_CAPEX');
        $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
        $this->db->where('INT_ID_SECTION', $id_section);
        $query_budget = $this->db->get()->result_array();

        $data = array(
            'INT_APPROVE1' => 1
        );

        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
            $this->db->where('INT_REVISE', $row['INT_REVISE']);
            $this->db->update('TW_BUDGET_CAPEX', $data);
        }

        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
            $this->db->where('INT_REVISE', $row['INT_REVISE']);
            $this->db->update($this->table, $data);
        }
    }

    function reject_by_manager($id_fiscal, $id_section) {
        $this->db->select('INT_NO_BUDGET_CPX_TEMP, INT_REVISE');
        $this->db->from('TW_BUDGET_CAPEX');
        $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
        $this->db->where('INT_ID_SECTION', $id_section);
        $query_budget = $this->db->get()->result_array();

        $data = array(
            'INT_APPROVE1' => 2
        );

        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
            $this->db->where('INT_REVISE', $row['INT_REVISE']);
            $this->db->update('TW_BUDGET_CAPEX', $data);
        }

        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
            $this->db->where('INT_REVISE', $row['INT_REVISE']);
            $this->db->update($this->table, $data);
        }
    }

    function approve_by_gm($id_fiscal, $id_dept) {
        $this->db->select('INT_ID_SECTION');
        $this->db->from('TM_SECTION');
        $this->db->where('INT_ID_DEPT', $id_dept);
        $query_section = $this->db->get()->result_array();

        $data = array(
            'INT_APPROVE2' => 1,
            'INT_APPROVE1' => 1
        );

        foreach ($query_section as $row) {
            $this->db->select('INT_NO_BUDGET_CPX_TEMP, INT_REVISE');
            $this->db->from('TW_BUDGET_CAPEX');
            $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
            $this->db->where('INT_ID_SECTION', $row['INT_ID_SECTION']);
            $query_budget = $this->db->get()->result_array();

            foreach ($query_budget as $row) {
                $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
                $this->db->where('INT_REVISE', $row['INT_REVISE']);
                $this->db->update('TW_BUDGET_CAPEX', $data);
            }

            foreach ($query_budget as $row) {
                $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
                $this->db->where('INT_REVISE', $row['INT_REVISE']);
                $this->db->update($this->table, $data);
            }
        }
    }

    function reject_by_gm($id_fiscal, $id_dept) {
        $this->db->select('INT_ID_SECTION');
        $this->db->from('TM_SECTION');
        $this->db->where('INT_ID_DEPT', $id_dept);
        $query_section = $this->db->get()->result_array();

        $data = array(
            'INT_APPROVE1' => 2,
            'INT_APPROVE2' => 2
        );

        foreach ($query_section as $row) {
            $this->db->select('INT_NO_BUDGET_CPX_TEMP, INT_REVISE');
            $this->db->from('TW_BUDGET_CAPEX');
            $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
            $this->db->where('INT_ID_SECTION', $row['INT_ID_SECTION']);
            $query_budget = $this->db->get()->result_array();

            foreach ($query_budget as $row) {
                $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
                $this->db->where('INT_REVISE', $row['INT_REVISE']);
                $this->db->update('TW_BUDGET_CAPEX', $data);
            }

            foreach ($query_budget as $row) {
                $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
                $this->db->where('INT_REVISE', $row['INT_REVISE']);
                $this->db->update($this->table, $data);
            }
        }
    }

    function approve_by_director($id_fiscal, $id_groupdept) {
        $this->db->select('INT_ID_DEPT');
        $this->db->from('TM_DEPT');
        $this->db->where('INT_ID_GROUP_DEPT', $id_groupdept);
        $query_dept = $this->db->get()->result_array();

        $data = array(
            'INT_APPROVE3' => 1,
            'INT_APPROVE2' => 1,
            'INT_APPROVE1' => 1
        );

        foreach ($query_dept as $row) {
            $this->db->select('INT_ID_SECTION');
            $this->db->from('TM_SECTION');
            $this->db->where('INT_ID_DEPT', $row['INT_ID_DEPT']);
            $query_section = $this->db->get()->result_array();

            foreach ($query_section as $row) {
                $this->db->select('INT_NO_BUDGET_CPX_TEMP, INT_REVISE, INT_QUANTITY');
                $this->db->from('TW_BUDGET_CAPEX');
                $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
                $this->db->where('INT_ID_SECTION', $row['INT_ID_SECTION']);
                $query_budget = $this->db->get()->result_array();

                foreach ($query_budget as $row) {
                    $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
                    $this->db->update('TW_BUDGET_CAPEX', $data);
                }

                foreach ($query_budget as $row) {
                    $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
                    $this->db->where('INT_REVISE', $row['INT_REVISE']);
                    $this->db->update($this->table, $data);
                }

//                foreach ($query_budget as $row) {
//                    $this->last_update_capex($data, $row['INT_NO_BUDGET_CPX_TEMP'], $row['INT_REVISE'], $row['INT_QUANTITY']);
//                }
            }
        }
    }

    function reject_by_director($id_fiscal, $id_groupdept) {
        $this->db->select('INT_ID_DEPT');
        $this->db->from('TM_DEPT');
        $this->db->where('INT_ID_GROUP_DEPT', $id_groupdept);
        $query_dept = $this->db->get()->result_array();

        $data = array(
            'INT_APPROVE3' => 2
        );

        foreach ($query_dept as $row) {
            $this->db->select('INT_ID_SECTION');
            $this->db->from('TM_SECTION');
            $this->db->where('INT_ID_DEPT', $row['INT_ID_DEPT']);
            $query_section = $this->db->get()->result_array();

            foreach ($query_section as $row) {
                $this->db->select('INT_NO_BUDGET_CPX_TEMP, INT_REVISE, INT_QUANTITY');
                $this->db->from('TW_BUDGET_CAPEX');
                $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
                $this->db->where('INT_ID_SECTION', $row['INT_ID_SECTION']);
                $query_budget = $this->db->get()->result_array();

                foreach ($query_budget as $row) {
                    $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
                    $this->db->update('TW_BUDGET_CAPEX', $data);
                }

                foreach ($query_budget as $row) {
                    $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
                    $this->db->where('INT_REVISE', $row['INT_REVISE']);
                    $this->db->update($this->table, $data);
                }
            }
        }
    }

    function last_update_capex($data, $no_budget_temp, $revise, $qty) {
        $this->load->model('budget/budgetproject_m');
        $this->load->model('budget/budgetproduct_m');

        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $no_budget_temp);
        $this->db->where('INT_REVISE', $revise);
        $this->db->update($this->table, $data);

        for ($i = 1; $i <= $qty; $i++) {
            $query_budget_head = $this->db->query("select * from TW_BUDGET_CAPEX where INT_NO_BUDGET_CPX_TEMP = '" . $no_budget_temp . "'")->result();

            foreach ($query_budget_head as $row) {

                $no_budget_perm = $this->generated_id();
                $no_budget_ori = $no_budget_perm + 1;

                $this->db->set('INT_NO_BUDGET_CPX', $no_budget_ori);
                $this->db->set('INT_NO_BUDGET_CPX_TEMP', $row->INT_NO_BUDGET_CPX_TEMP);
                $this->db->set('INT_ID_PURPOSE', $row->INT_ID_PURPOSE);
                $this->db->set('BIT_FLG_OWNER', $row->BIT_FLG_OWNER);
                $this->db->set('BIT_FLG_NEW', $row->BIT_FLG_NEW);
                $this->db->set('BIT_FLG_CIP', $row->BIT_FLG_CIP);
                $this->db->set('BIT_FLG_LOCAL', $row->BIT_FLG_LOCAL);
                $this->db->set('CHR_CREATE_BY', $row->CHR_CREATE_BY);
                $this->db->set('CHR_CREATE_DATE', $row->CHR_CREATE_DATE);
                $this->db->set('CHR_CREATE_TIME', $row->CHR_CREATE_TIME);
                $this->db->set('BIT_FLG_DEL', 0);
                $this->db->set('INT_MONTH_PLAN', $row->INT_MONTH_PLAN);
                $this->db->set('INT_QUANTITY', 1);
                $this->db->set('CHR_DEPCI_DATE', $row->CHR_DEPCI_DATE);
                $this->db->set('INT_APPROVE1', $row->INT_APPROVE1);
                $this->db->set('INT_APPROVE2', $row->INT_APPROVE2);
                $this->db->set('INT_APPROVE3', $row->INT_APPROVE3);

                $this->db->insert('TT_BUDGET_CAPEX');

                $this->db->set('INT_NO_BUDGET', $no_budget_ori);
                $this->db->set('INT_NO_BUDGET_CPX', $no_budget_ori);
                $this->db->set('CHR_BUDGET_NAME', $row->CHR_BUDGET_NAME);
                $this->db->set('INT_ID_UNIT', $row->INT_ID_UNIT);
                $this->db->set('INT_ID_BUDGET_SUB_CATEGORY', $row->INT_ID_BUDGET_SUB_CATEGORY);
                $this->db->set('INT_ID_SECTION', $row->INT_ID_SECTION);
                $this->db->set('INT_ID_FISCAL_YEAR', $row->INT_ID_FISCAL_YEAR);
                $this->db->set('BIT_FLG_CPX', 1);
                $this->db->set('DEC_TOTAL', $row->DEC_PRICE_PER_UNIT);

                $this->db->insert('TT_BUDGET');

                $project = $this->budgetproject_m->cek_project($no_budget_temp);
                if ($project != 0) {
                    $query_budget_project = $this->db->query("select * from TW_BUDGET_PROJECT where INT_NO_BUDGET_CPX_TEMP = '" . $no_budget_temp . "'")->result();

                    foreach ($query_budget_project as $row) {
                        $this->db->set('INT_NO_BUDGET_CPX', $no_budget_ori);
                        $this->db->set('INT_ID_PROJECT', $row->INT_ID_PROJECT);

                        $this->db->insert('TT_BUDGET_PROJECT');
                    }
                }

                $product = $this->budgetproduct_m->cek_product($no_budget_temp);
                if ($product != 0) {
                    $query_budget_product = $this->db->query("select * from TW_BUDGET_PRODUCT where INT_NO_BUDGET_CPX_TEMP = '" . $no_budget_temp . "'")->result();

                    foreach ($query_budget_product as $row) {
                        $this->db->set('INT_NO_BUDGET_CPX', $no_budget_ori);
                        $this->db->set('INT_ID_PRODUCT', $row->INT_ID_PRODUCT);

                        $this->db->insert('TT_BUDGET_PRODUCT');
                    }
                }
            }
        }
    }

    function recap_by_admin($id_fiscal) {
        $this->db->select('INT_NO_BUDGET_CPX_TEMP, INT_QUANTITY');
        $this->db->from('TW_BUDGET_CAPEX');
        $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
        $query_budget = $this->db->get()->result_array();

        foreach ($query_budget as $row) {
            $this->change_to_budget_permanent($row['INT_NO_BUDGET_CPX_TEMP'], $row['INT_QUANTITY']);
        }
    }

    function change_to_budget_permanent($no_budget_temp, $qty) {
        $this->load->model('budget/budgetproject_m');
        $this->load->model('budget/budgetproduct_m');

        $data = array(
            'INT_STATUS' => 1
        );

        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $no_budget_temp);
        $this->db->update('TW_BUDGET_CAPEX', $data);

        for ($i = 1; $i <= $qty; $i++) {
            $query_budget_head = $this->db->query("select * from TW_BUDGET_CAPEX where INT_NO_BUDGET_CPX_TEMP = '" . $no_budget_temp . "'")->result();

            foreach ($query_budget_head as $row) {

                $no_budget_perm = $this->generated_id();
                $no_budget_ori = $no_budget_perm + 1;

                $this->db->set('INT_NO_BUDGET_CPX', $no_budget_ori);
                $this->db->set('INT_NO_BUDGET_CPX_TEMP', $row->INT_NO_BUDGET_CPX_TEMP);
                $this->db->set('INT_ID_PURPOSE', $row->INT_ID_PURPOSE);
                $this->db->set('BIT_FLG_OWNER', $row->BIT_FLG_OWNER);
                $this->db->set('BIT_FLG_NEW', $row->BIT_FLG_NEW);
                $this->db->set('BIT_FLG_CIP', $row->BIT_FLG_CIP);
                $this->db->set('BIT_FLG_LOCAL', $row->BIT_FLG_LOCAL);
                $this->db->set('CHR_CREATE_BY', $row->CHR_CREATE_BY);
                $this->db->set('CHR_CREATE_DATE', $row->CHR_CREATE_DATE);
                $this->db->set('CHR_CREATE_TIME', $row->CHR_CREATE_TIME);
                $this->db->set('BIT_FLG_DEL', 0);
                $this->db->set('INT_MONTH_PLAN', $row->INT_MONTH_PLAN);
                $this->db->set('INT_QUANTITY', 1);
                $this->db->set('INT_STATUS', 1);
                $this->db->set('CHR_DEPCI_DATE', $row->CHR_DEPCI_DATE);
                $this->db->set('INT_APPROVE1', $row->INT_APPROVE1);
                $this->db->set('INT_APPROVE2', $row->INT_APPROVE2);
                $this->db->set('INT_APPROVE3', $row->INT_APPROVE3);

                $this->db->insert('TT_BUDGET_CAPEX');

                $this->db->set('INT_NO_BUDGET', $no_budget_ori);
                $this->db->set('INT_NO_BUDGET_CPX', $no_budget_ori);
                $this->db->set('CHR_BUDGET_NAME', $row->CHR_BUDGET_NAME);
                $this->db->set('INT_ID_UNIT', $row->INT_ID_UNIT);
                $this->db->set('INT_ID_BUDGET_SUB_CATEGORY', $row->INT_ID_BUDGET_SUB_CATEGORY);
                $this->db->set('INT_ID_SECTION', $row->INT_ID_SECTION);
                $this->db->set('INT_ID_FISCAL_YEAR', $row->INT_ID_FISCAL_YEAR);
                $this->db->set('BIT_FLG_CPX', 1);
                $this->db->set('DEC_TOTAL', $row->DEC_PRICE_PER_UNIT);

                $this->db->insert('TT_BUDGET');

                $project = $this->budgetproject_m->cek_project($no_budget_temp);
                if ($project != 0) {
                    $query_budget_project = $this->db->query("select * from TW_BUDGET_PROJECT where INT_NO_BUDGET_CPX_TEMP = '" . $no_budget_temp . "'")->result();

                    foreach ($query_budget_project as $row) {
                        $this->db->set('INT_NO_BUDGET_CPX', $no_budget_ori);
                        $this->db->set('INT_ID_PROJECT', $row->INT_ID_PROJECT);

                        $this->db->insert('TT_BUDGET_PROJECT');
                    }
                }

                $product = $this->budgetproduct_m->cek_product($no_budget_temp);
                if ($product != 0) {
                    $query_budget_product = $this->db->query("select * from TW_BUDGET_PRODUCT where INT_NO_BUDGET_CPX_TEMP = '" . $no_budget_temp . "'")->result();

                    foreach ($query_budget_product as $row) {
                        $this->db->set('INT_NO_BUDGET_CPX', $no_budget_ori);
                        $this->db->set('INT_ID_PRODUCT', $row->INT_ID_PRODUCT);

                        $this->db->insert('TT_BUDGET_PRODUCT');
                    }
                }
            }
        }
    }

    function commit_by_admin($id_fiscal) {
        $this->db->select('INT_NO_BUDGET_CPX_TEMP');
        $this->db->from('TW_BUDGET_CAPEX');
        $this->db->where('INT_ID_FISCAL_YEAR', $id_fiscal);
        $query_budget = $this->db->get()->result_array();

        $data = array(
            'INT_APPROVE0' => 1
        );

        foreach ($query_budget as $row) {
            $this->db->where('INT_NO_BUDGET_CPX_TEMP', $row['INT_NO_BUDGET_CPX_TEMP']);
            $this->db->update('TW_BUDGET_CAPEX', $data);
        }
    }

    function generated_id() {
        $query = $this->db->query("select top 1 INT_NO_BUDGET as 'id' from TT_BUDGET where SUBSTRING(CAST(INT_NO_BUDGET as char),1,1) = 1 and SUBSTRING(CAST(INT_NO_BUDGET as char),2,2) = RIGHT(year(getdate()),2) order by INT_NO_BUDGET desc");

        if ($query->num_rows() != 0) {
            $result = $query->row_array();
            $jumlah = $result['id'];
            return $jumlah;
        } else {
            return '1' . date('y') . '00000';
        }
    }

}

?>
