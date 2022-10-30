<?php

class Master_data_stock_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function replacer_dept_prd($kode_dept) {
        $dept = $this->db->query("select CHR_DEPT from TM_DEPT where INT_ID_DEPT = '$kode_dept'")->row();
        //print_r($dept);
        //exit();
        if (count($dept) > 0) {
            $dept_kode = $dept->CHR_DEPT;
        } else {
            $dept_kode = $kode_dept;
        }
        $dept_kode = str_replace("PR", "PRD", $dept_kode);
        return $dept_kode;
    }

    function get_section($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        $section = $aortadb->query("select KODE, NAMA_SECTION from TM_SECTION where KODE_DEP = '$dept_kode' and NAMA_SECTION <> ''")->result();
        return $section;
    }

    function get_section_detail($kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        $section = $aortadb->query("select KODE, NAMA_SECTION from TM_SECTION where KODE_DEP = '$dept_kode' and NAMA_SECTION <> '' and KODE = '$id_section'")->result();
        return $section;
    }

    function get_data_karyawan($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        $data_karyawan = $aortadb->query("SELECT     NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE, OPER_ENTRY , salary , position , tunj_transport ,  tunj_jabatan
            FROM         TM_KRY
            WHERE     (KD_DEPT = '$dept_kode') AND (FLAG_DELETE = '0')
            ORDER BY KD_SECTION, KD_SUB_SECTION, NPK")->result();
        //print_r($dept_kode);
        //exit();
        return $data_karyawan;
    }
    
    function get_data_stock($kode_dept) {
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        $data_stock = $this->db->query("SELECT [INT_ID]
                                        ,[CHR_PART_NO]
                                        ,[CHR_BACK_NO]
                                        ,[CHR_PART_NAME]
                                        ,[CHR_SLOC]
                                        ,[INT_STD_STOCK]
                                        ,[INT_QTY_PER_BOX]
                                        ,[INT_QTY_TOTAL]
                                        ,[CHR_UOM]
                                        ,[INT_AMOUNT]
                                        ,[CHR_CREATED_BY]
                                        ,[CHR_CREATED_DATE]
                                        ,[CHR_CREATED_TIME]
                                        ,[INT_FLG_DEL]
                                        FROM TM_EXCEEDED_STOCK
                                        WHERE [INT_FLG_DEL] = '0'")->result();
        return $data_stock;
    }

}
