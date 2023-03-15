<?php

class user_m extends CI_Model {

    private $tabel = 'TM_USER';

    function get_user() {
        $hasil = $this->db->query("select  a.CHR_NPK, a.CHR_USERNAME,c.CHR_ROLE, c.INT_ID_ROLE,
                                    d.CHR_DEPT,e.CHR_GROUP_DEPT, h.CHR_COMPANY_DESC,
                                    isnull(f.CHR_SECTION,'-') AS CHR_SECTION,
                                    isnull(g.CHR_SUB_SECTION,'-') AS CHR_SUB_SECTION,h.CHR_COMPANY ,b.CHR_DIVISION
                            from TM_USER a LEFT JOIN TM_DEPT d ON a.INT_ID_DEPT = d.INT_ID_DEPT
                                                       INNER JOIN TM_ROLE c ON a.INT_ID_ROLE = c.INT_ID_ROLE
                                                       LEFT JOIN TM_SECTION f ON a.INT_ID_SECTION = f.INT_ID_SECTION
                                                       LEFT JOIN TM_GROUP_DEPT e ON a.INT_ID_GROUP_DEPT = e.INT_ID_GROUP_DEPT
                                                       LEFT JOIN TM_SUB_SECTION g ON a.INT_ID_SUB_SECTION = g.INT_ID_SUB_SECTION
                                                       LEFT JOIN TM_COMPANY h ON a.INT_ID_COMPANY = h.INT_ID_COMPANY
                                                       LEFT JOIN TM_DIVISION b ON a.INT_ID_DIVISION = b.INT_ID_DIVISION
                            where a.BIT_FLG_DEL = 0");
        //var_dump($hasil);die();
        return $hasil->result();
    }

    function save($data) {
        $this->db->insert($this->tabel, $data);
    }

    function get_data($id) {
        $hasil = $this->db->query("select b.INT_ID_DIVISION, d.INT_ID_DEPT, e.INT_ID_GROUP_DEPT, g.INT_ID_SUB_SECTION,
                            f.INT_ID_SECTION,
                            a.CHR_NPK, UPPER(a.CHR_USERNAME) AS CHR_USERNAME,c.CHR_ROLE, c.INT_ID_ROLE,
                            d.CHR_DEPT,e.CHR_GROUP_DEPT, a.CHR_REGIS_DATE,
                            m.CHR_MODULE, fun.CHR_FUNCTION,
                            isnull(f.CHR_SECTION,'-') AS CHR_SECTION,
                            isnull(g.CHR_SUB_SECTION,'-') AS CHR_SUB_SECTION,h.CHR_COMPANY_DESC ,b.CHR_DIVISION
                    from TM_USER a INNER JOIN TM_ROLE c ON a.INT_ID_ROLE = c.INT_ID_ROLE
                                               INNER JOIN TT_ROLE_MODULE rm ON rm.INT_ID_ROLE = c.INT_ID_ROLE AND rm.INT_ID_FUNCTION = rm.INT_ID_FUNCTION
                                               INNER JOIN TM_FUNCTION fun ON fun.INT_ID_FUNCTION = rm.INT_ID_FUNCTION 
                                               INNER JOIN TM_MODULE m ON m.INT_ID_MODULE = fun.INT_ID_MODULE
                                               LEFT JOIN TM_DEPT d ON a.INT_ID_DEPT = d.INT_ID_DEPT
                                               LEFT JOIN TM_SECTION f ON a.INT_ID_SECTION = f.INT_ID_SECTION
                                               LEFT JOIN TM_GROUP_DEPT e ON a.INT_ID_GROUP_DEPT = e.INT_ID_GROUP_DEPT
                                               LEFT JOIN TM_SUB_SECTION g ON a.INT_ID_SUB_SECTION = g.INT_ID_SUB_SECTION
                                               LEFT JOIN TM_COMPANY h ON a.INT_ID_COMPANY = h.INT_ID_COMPANY
                                               LEFT JOIN TM_DIVISION b ON a.INT_ID_DIVISION = b.INT_ID_DIVISION
                    where a.CHR_NPK = '$id'");

        return $hasil;
    }

    function get_data_user($npk) {
        $query = $this->db->query("SELECT CHR_NPK, CHR_USERNAME, CHR_REGIS_DATE, CHR_PASS, CHR_CONTACT FROM  TM_USER WHERE CHR_NPK = '$npk' AND BIT_FLG_DEL = 0  ");
        return $query;
    }

    function get_data_user_by_username($username) {
        $query = $this->db->query(" SELECT U.CHR_NPK, U.CHR_USERNAME, U.CHR_EMAIL, D.CHR_DEPT, D.INT_ID_DEPT
                                    FROM  TM_USER  U 
                                    INNER JOIN TM_DEPT D ON D.INT_ID_DEPT = U.INT_ID_DEPT
                                    WHERE U.CHR_USERNAME = '$username'");
        return $query;
    }

    function get_dept_by_npk($npk) {
        $query = $this->db->query("select INT_ID_DEPT from TM_USER where CHR_NPK = '$npk'");

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $part_of = $data['INT_ID_DEPT'];
            return $part_of;
        } else {
            return 0;
        }
    }

    function delete($id) {
        $data = array('BIT_FLG_DEL' => 1);

        $this->db->where('CHR_NPK', $id);
        $this->db->update($this->tabel, $data);
    }

    function update($data, $id) {
        $this->db->where('CHR_NPK', $id);
        $this->db->update($this->tabel, $data);
    }

    public function check_username($username) {
        $this->db->where('CHR_USERNAME', $username);
        $find_user = $this->db->get($this->tabel);
        return $find_user->result();
    }

    public function check_npk($npk) {
        $this->db->where('CHR_NPK', $npk);
        $find_npk = $this->db->get($this->tabel);
        return $find_npk->result();
    }

    function get_user_org($npk) {
        $npk = trim($npk);
        return $this->db->query("select a.INT_ID_SECTION,a.CHR_SECTION, b.INT_ID_DEPT,b.CHR_DEPT, c.INT_ID_GROUP_DEPT,c.CHR_GROUP_DEPT, 
                                d.CHR_DIVISION, d.INT_ID_DIVISION, f.INT_ID_COMPANY, f.CHR_COMPANY
                                from TM_SECTION a, TM_DEPT b, TM_GROUP_DEPT c, TM_DIVISION d, TM_USER e, TM_COMPANY f
                                where e.INT_ID_DEPT=b.INT_ID_DEPT and e.INT_ID_GROUP_DEPT=c.INT_ID_GROUP_DEPT  
                                and e.INT_ID_DIVISION=d.INT_ID_DIVISION and d.INT_ID_COMPANY=f.INT_ID_COMPANY and a.INT_ID_SECTION=e.INT_ID_SECTION 
                                and e.CHR_NPK='$npk'")->row();
    }

    function get_npk_dept($id_dept) {
        $query = $this->db->query(" SELECT CHR_NPK
                                    FROM  TM_USER
                                    WHERE INT_ID_DEPT = '$id_dept' AND (INT_ID_ROLE = '5' OR INT_ID_ROLE = '10' OR INT_ID_ROLE = '39' OR INT_ID_ROLE = '45') AND BIT_FLG_DEL = '0' AND BIT_FLG_ACTIVE = '1'")->result();
        return $query;
    }
    
    function get_npk_groupdept($id_group) {
        $query = $this->db->query(" SELECT CHR_NPK
                                    FROM  TM_USER
                                    WHERE INT_ID_GROUP_DEPT = '$id_group' AND INT_ID_ROLE = '4' AND BIT_FLG_DEL = '0' AND BIT_FLG_ACTIVE = '1'")->result();
        return $query;
    }
    
    function get_npk_div($id_div) {
        $query = $this->db->query(" SELECT CHR_NPK
                                    FROM  TM_USER
                                    WHERE INT_ID_DIVISION = '$id_div' AND INT_ID_ROLE = '3' AND BIT_FLG_DEL = '0' AND BIT_FLG_ACTIVE = '1'")->result();
        return $query;
    }

    function get_all_user(){
        return $this->db->query("SELECT CHR_NPK, CHR_USERNAME FROM TM_USER WHERE BIT_FLG_DEL = 0 AND CHR_NPK <> 'Loop3r' ")->result();
    }

    function get_user_name_by_npk($npk){
        return $this->db->query("SELECT * FROM TM_USER WHERE CHR_NPK = '$npk'");
    }

    function get_npk($npk) {
        $query = $this->db->query("SELECT 1 FROM TM_USER WHERE CHR_NPK = '$npk'");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
