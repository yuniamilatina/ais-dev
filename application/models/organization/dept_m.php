<?php

class dept_m extends CI_Model {

    private $tabel = 'TM_DEPT';

    function get_dept() {
        $query = $this->db->query("SELECT a.INT_ID_DEPT, a.CHR_DEPT, a.CHR_DEPT_DESC, b.CHR_GROUP_DEPT 
            FROM TM_DEPT a, TM_GROUP_DEPT b where a.INT_ID_GROUP_DEPT = b.INT_ID_GROUP_DEPT and a.BIT_FLG_DEL = 0");
        return $query->result();
    }

    function get_name_dept($id) {
        $query = $this->db->query("SELECT CHR_DEPT FROM TM_DEPT where INT_ID_DEPT = '" . $id . "'")->row_array();
        $dept = $query['CHR_DEPT'];
        return $dept;
    }

    function get_desc_dept($id) {
        $query = $this->db->query("SELECT CHR_DEPT_DESC FROM TM_DEPT where INT_ID_DEPT = '" . $id . "'")->row_array();
        $dept = $query['CHR_DEPT_DESC'];
        return $dept;
    }

    function save_dept($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_top_data_dept() {
        $query = $this->db->query("SELECT TOP 1 INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC, INT_ID_GROUP_DEPT FROM TM_DEPT WHERE INT_ID_DEPT <> 0");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_top_data_dept_by_groupdept($id) {
        $query = $this->db->query("SELECT TOP 1 INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC, INT_ID_GROUP_DEPT FROM TM_DEPT 
        WHERE INT_ID_GROUP_DEPT = $id AND BIT_FLG_DEL = 0 ");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_top_data_dept_by_division($id) {
        $query = $this->db->query("SELECT TOP 1 INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC, INT_ID_GROUP_DEPT FROM TM_DEPT WHERE INT_ID_GROUP_DEPT IN (
            SELECT INT_ID_GROUP_DEPT FROM TM_GROUP_DEPT WHERE INT_ID_DIVISION = $id AND SUBSTRING(CHR_GROUP_DEPT,7,3) <> 'BOD') AND BIT_FLG_DEL = 0 ");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_data_dept($id) {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC, INT_ID_GROUP_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = '$id'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_dept_by_division_id($id) {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC FROM TM_DEPT WHERE INT_ID_GROUP_DEPT IN (
            SELECT INT_ID_GROUP_DEPT FROM TM_GROUP_DEPT WHERE INT_ID_DIVISION = $id AND SUBSTRING(CHR_GROUP_DEPT,7,3) <> 'BOD') AND BIT_FLG_DEL = 0 ")->result();
        return $query;
    }

    function get_dept_by_groupdept($id) {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC FROM TM_DEPT where BIT_FLG_DEL = 0 and INT_ID_GROUP_DEPT = '" . $id . "'")->result();
        return $query;
    }

    function get_dept_by_dept($id) {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC FROM TM_DEPT where BIT_FLG_DEL = 0 and INT_ID_DEPT = '" . $id . "'")->result();
        return $query;
    }

    function get_groupdept_by_dept($id) {
        $query = $this->db->query("SELECT INT_ID_GROUP_DEPT FROM TM_DEPT where INT_ID_DEPT = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_GROUP_DEPT'];
        return $part_of;
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('INT_ID_DEPT', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_DEPT', $id);
        $this->db->update($this->tabel, $data);
    }

    function check_id_dept($id) {
        $find_id = $this->db->query("SELECT * FROM TM_DEPT where CHR_DEPT = '" . $id . "'");
        if ($find_id->num_rows() > 0) {
            return $find_id->result();
        }
        return false;
    }

    function generate_id_dept() {
        return $this->db->query('SELECT max(INT_ID_DEPT) as a FROM TM_DEPT')->row()->a + 1;
    }

    function get_dept_from_sect($sect) {
        return $this->db->query('SELECT INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC FROM TM_DEPT')->row();
    }

    function get_dept_id($sect) {
        return $this->db->query("SELECT a.INT_ID_DEPT FROM TM_DEPT a, TM_SECTION b 
                                where a.INT_ID_DEPT=b.INT_ID_DEPT and b.INT_ID_SECTION=$sect")->row();
    }

    function get_all_prod_dept() {
        $query = $this->db->query("SELECT INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC FROM TM_DEPT WHERE INT_ID_DEPT IN (21,23)")->result();
        return $query;
    }

    function get_top_prod_dept() {
        $query = $this->db->query("SELECT TOP (1) INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC FROM TM_DEPT WHERE INT_ID_DEPT IN (21,24)");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_all_dvc_dept() {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT, CHR_DEPT_DESC FROM TM_DEPT WHERE INT_ID_DEPT IN (21,20,23,24)")->result();
        return $query;
    }

    function get_all(){
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT, CHR_DEPT_DESC FROM TM_DEPT WHERE INT_ID_DEPT IN (21,22,23,24)
        UNION 
        SELECT 25, 'ALL', 'ALL' FROM TM_DEPT ")->result();
        return $query;
    }

    function get_all_dept() {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT, CHR_DEPT_DESC FROM TM_DEPT where CHR_DEPT <> '' AND BIT_FLG_DEL = 0")->result();
        return $query;
    }
    
    function get_all_dept_plant() {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT, CHR_DEPT_DESC FROM TM_DEPT where CHR_DEPT is not null AND BIT_FLG_DEL = 0 and INT_ID_GROUP_DEPT IN (SELECT INT_ID_GROUP_DEPT FROM TM_GROUP_DEPT where INT_ID_DIVISION = '3')")->result();
        return $query;
    }

    function  get_all_dept_aorta() {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT * FROM TM_DEP")->result();
        return $query;
    }


    
//===================== UPDATE 16/07/2017 --- FOR BUDGET =====================//
    function get_name_dept_arr($id) {
        $dept = $this->db->query("SELECT INT_ID_DEPT , CHR_DEPT , CHR_DEPT_DESC FROM TM_DEPT where INT_ID_DEPT = '" . $id . "' ")->result();

        return $dept;
    }

    function get_name_section_budget($id) {
        $dept = $this->db->query("SELECT     INT_ID_SECTION, CHR_SECTION, CHR_SECTION_DESC
                            FROM         TM_SECTION
                            WHERE     (INT_ID_DEPT = $id) AND (CHR_FLAG_ACT_BUDGET = '1')")->result();

        return $dept;
    }
    
    function get_dept_by_division($id_div) {
        $query = $this->db->query("SELECT INT_ID_DEPT, CHR_DEPT ,CHR_DEPT_DESC FROM TM_DEPT where BIT_FLG_DEL = 0
                                and INT_ID_GROUP_DEPT IN (SELECT INT_ID_GROUP_DEPT FROM TM_GROUP_DEPT where INT_ID_DIVISION = '$id_div')")->result();
        return $query;
    }
    
    function get_gm_div($kode_dept) {
        $query = $this->db->query("SELECT TM_DEPT.INT_ID_GROUP_DEPT, TM_GROUP_DEPT.INT_ID_DIVISION FROM TM_DEPT INNER JOIN  TM_GROUP_DEPT ON TM_DEPT.INT_ID_GROUP_DEPT = TM_GROUP_DEPT.INT_ID_GROUP_DEPT WHERE (TM_DEPT.BIT_FLG_DEL = 0) AND TM_DEPT.INT_ID_DEPT = '$kode_dept'");

        return $query;
    }
    
    function get_id_groupdept_by_dept($dept) {
        $query = $this->db->query("SELECT INT_ID_GROUP_DEPT FROM TM_DEPT where CHR_DEPT LIKE '" . $dept . "' AND BIT_FLG_DEL = '0'")->row_array();
        $id_group = $query['INT_ID_GROUP_DEPT'];
        return $id_group;
    }
    
    function get_id_div_by_dept($dept) {
        $query = $this->db->query("SELECT B.INT_ID_DIVISION FROM TM_DEPT as A
                                inner join TM_GROUP_DEPT as B on B.INT_ID_GROUP_DEPT = A.INT_ID_GROUP_DEPT
                                where A.CHR_DEPT LIKE '" . $dept . "' AND A.BIT_FLG_DEL = '0' AND B.BIT_FLG_DEL = '0'")->row_array();
        $id_group = $query['INT_ID_DIVISION'];
        return $id_group;
    }

    function get_id_dept_by_dept($dept) {
        $query = $this->db->query("SELECT INT_ID_DEPT FROM TM_DEPT where CHR_DEPT LIKE '%$dept%' AND BIT_FLG_DEL = '0'");
        if($query->num_rows() > 0){
            $id_dept = $query->row()->INT_ID_DEPT;
        } else {
            $id_dept = '';
        }        
        return $id_dept;
    }

    function get_id_dept_by_dept_ais($dept_ais) {
        $query = $this->db->query("SELECT INT_ID_DEPT FROM TM_DEPT where CHR_DEPT = '$dept' AND BIT_FLG_DEL = '0'");
        if($query->num_rows() > 0){
            $id_dept = $query->row()->INT_ID_DEPT;
        } else {
            $id_dept = '';
        }        
        return $id_dept;
    }

    function get_id_div_by_id_dept($id_dept) {
        $query = $this->db->query("SELECT B.INT_ID_DIVISION FROM TM_DEPT as A
                                inner join TM_GROUP_DEPT as B on B.INT_ID_GROUP_DEPT = A.INT_ID_GROUP_DEPT
                                where A.INT_ID_DEPT = '" . $id_dept . "' AND A.BIT_FLG_DEL = '0' AND B.BIT_FLG_DEL = '0'")->row_array();
        $id_group = $query['INT_ID_DIVISION'];
        return $id_group;
    }

    // function get_id_groupdept_by_dept_ais($dept) {
    //     $query = $this->db->query("SELECT INT_ID_GROUP_DEPT FROM TM_DEPT where CHR_DEPT LIKE '" . $dept . "%' AND BIT_FLG_DEL = '0'")->row();
    //     $id_group = $query->INT_ID_GROUP_DEPT;
    //     return $id_group;
    // }

}
