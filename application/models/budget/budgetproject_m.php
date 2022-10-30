<?php

class budgetproject_m extends CI_Model {

    private $table = 'TW_BUDGET_PROJECT';

    function select_budgetproject() {
        $query = $this->db->query("select * from TW_BUDGET_PROJECT");
        return $query->result();
    }

    function save($data) {
        $this->db->insert($this->table, $data);
    }

    function prepare_save($project, $id, $name) {
        $this->db->set('INT_NO_BUDGET_CPX_TEMP', $id);
        $this->db->set('INT_ID_PROJECT', $project);
        $this->db->set('CHR_CREATE_BY', $name);
        $this->db->set('CHR_CREATE_DATE', date('Ymd'));
        $this->db->set('CHR_CREATE_TIME', date('His'));

        $this->db->insert($this->table);
    }
    
    function get_data_project($id) {
        $query = $this->db->query("select a.INT_ID_PROJECT, a.INT_NO_BUDGET_CPX_TEMP, b.CHR_PROJECT, b.CHR_PROJECT_DESC 
            from TW_BUDGET_PROJECT a,TM_PROJECT b,TW_BUDGET_CAPEX c 
            where a.INT_ID_PROJECT=b.INT_ID_PROJECT and a.INT_NO_BUDGET_CPX_TEMP=c.INT_NO_BUDGET_CPX_TEMP and
            a.INT_NO_BUDGET_CPX_TEMP = '" . $id . "'");
        return $query->result();
    }

    function get_data_project_close($id) {
        $query = $this->db->query("select a.INT_ID_PROJECT, a.INT_NO_BUDGET_CPX, b.CHR_PROJECT, b.CHR_PROJECT_DESC 
            from TT_BUDGET_PROJECT a,TM_PROJECT b,TT_BUDGET_CAPEX c 
            where a.INT_ID_PROJECT=b.INT_ID_PROJECT and a.INT_NO_BUDGET_CPX=c.INT_NO_BUDGET_CPX and
            a.INT_NO_BUDGET_CPX = '" . $id . "'");
        return $query->result();
    }

    function cek_project_close($no_budget) {
        $query = $this->db->query("select INT_ID_PROJECT from TT_BUDGET_PROJECT where INT_NO_BUDGET_CPX = '" . $no_budget . "'");
        if ($query->num_rows() != 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    
    function cek_project($no_budget) {
        $query = $this->db->query("select * from TW_BUDGET_PROJECT where INT_NO_BUDGET_CPX_TEMP = '" . $no_budget . "'");
        if ($query->num_rows() != 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    function get_current_data_project($id) {
        $this->db->select('INT_ID_PROJECT');
        $this->db->from('TW_BUDGET_PROJECT');
        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $id);
        $query = $this->db->get()->result();

        $this->db->select('INT_ID_PROJECT, CHR_PROJECT, CHR_PROJECT_DESC');
        $this->db->from('TM_PROJECT');
        foreach ($query as $row) {
            $this->db->where("INT_ID_PROJECT <>'" . $row->INT_ID_PROJECT . "'");
        }

        $query_in_query = $this->db->get()->result();
        return $query_in_query;
    }

    function delete($id, $no) {
        $this->db->where('INT_ID_PROJECT', $id);
        $this->db->where('INT_NO_BUDGET_CPX_TEMP', $no);
        $this->db->delete($this->table);
    }

}

?>
