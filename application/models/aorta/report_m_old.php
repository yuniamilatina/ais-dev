<?php

class Master_data_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function replacer_dept_prd($kode_dept) {
        $dept = $this->db->query("select CHR_DEPT from TM_DEPT where INT_ID_DEPT = '$kode_dept'")->row();
        if (count($dept) > 0) {
            $dept_kode = $dept->CHR_DEPT;
        }
        $dept_kode = str_replace("PR", "PRD", $dept_kode);
        return $dept_kode;
    }

    function get_section($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        $section = $aortadb->query("select KODE, NAMA_SECTION from TM_SECTION where KODE_DEP = '$dept_kode'")->result();
        return $section;
    }

    function get_data_karyawan($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        $data_karyawan = $aortadb->query("SELECT     NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE, OPER_ENTRY , salary , position
            FROM         TM_KRY
            WHERE     (KD_DEPT = '$dept_kode') AND (FLAG_DELETE = '0')
            ORDER BY KD_SECTION, KD_SUB_SECTION, NPK")->result();
        return $data_karyawan;
    }

}
?>

