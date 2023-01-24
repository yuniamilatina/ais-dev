<?php

class report_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function replacer_dept($kode_dept) {
        $dept = $this->db->query("select CHR_DEPT from TM_DEPT where INT_ID_DEPT = '$kode_dept'")->row();
        if (count($dept) > 0) {
            $dept_kode = $dept->CHR_DEPT;
        }
        
        //===== Temporary replacement Dept
        // if($dept_kode == 'QAS'){
        //     $dept_kode = 'QA';
        // } else if($dept_kode == 'OMD') {
        //     $dept_kode = 'KZN';
        // } else if($dept_kode == 'ERP') {
        //     $dept_kode = 'PR3';
        // } else if($dept_kode == 'MFG') {
        //     $dept_kode = 'PR4';
        // } else if($dept_kode == 'BRP') {
        //     $dept_kode = 'PR1';
        // } else if($dept_kode == 'PCO') {
        //     $dept_kode = 'PC';
        // } else if($dept_kode == 'PPC') {
        //     $dept_kode = 'PPIC';
        // } else if($dept_kode == 'MIS') {
        //     $dept_kode = 'MIS';
        // }
        //===== End

        // $dept_kode = str_replace("PR", "PRD", $dept_kode);

        return $dept_kode;
    }

    function get_section($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $section = $aortadb->query("select KODE, NAMA_SECTION from TM_SECTION where KODE_DEP = '$dept_kode'")->result();
        return $section;
    }

    function get_data_karyawan($kode_dept, $kode_sect, $kode_subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $data_karyawan = $aortadb->query("SELECT NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE, OPER_ENTRY, SALARY, POSITION
            FROM TM_KRY
            WHERE (KD_DEPT LIKE '$dept_kode%') AND (FLAG_DELETE = '0') AND (KD_SECTION LIKE '$kode_sect%') AND (KD_SUB_SECTION LIKE '$kode_subsect%')
            ORDER BY KD_SECTION, KD_SUB_SECTION, NPK")->result();
        return $data_karyawan;
    }
    
    //======================== UPDATE ANU 04/09/2017 =========================//
    function get_sub_section($kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $sub_section = $aortadb->query("select KODE, NAMA_SUBSECT, KODE_SEC from TM_SUBSECTION where KODE_SEC = '$id_section' and KODE <> ''")->result();
        return $sub_section;
    }
    
    function get_section_detail($kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $section = $aortadb->query("select KODE, NAMA_SECTION from TM_SECTION where KODE_DEP = '$dept_kode' and KODE = '$id_section'")->result();
        return $section;
    }
    
    function get_holiday($selected_date) {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY
                        WHERE TGL_LIBUR LIKE '$selected_date%'")->result();
        return $get_holiday;
    }
    
    function get_data_overtime($kode_dept, $kode_sect, $kode_subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $data_karyawan = $aortadb->query("SELECT DISTINCT KD_DEPT, KD_SECTION, KD_SUB_SECTION
            FROM TT_KRY_OVERTIME
            WHERE (KD_DEPT LIKE '$dept_kode%') AND (KD_SECTION LIKE '$kode_sect%') AND (KD_SUB_SECTION LIKE '$kode_subsect%')
            ORDER BY KD_DEPT, KD_SECTION, KD_SUB_SECTION")->result();
        return $data_karyawan;
    }
    
    function get_quota_karyawan($periode, $kode_dept, $kode_sect, $kode_subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $data_karyawan = $aortadb->query("SELECT A.NPK, A.NAMA, A.KD_GROUP, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, 
                                   B.QUOTA_STD, B.QUOTAPLAN, B.QUOTAPLAN1,
                                   (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) - CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2))) AS QUOTA_ADD,
                                   (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_QUOTAPLAN,
                                   ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS TERPAKAIPLAN, ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS TERPAKAIPLAN1,
                                   (CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_TERPAKAIPLAN,
                                   ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS SISAPLAN, ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS SISAPLAN1,
                                   (CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_SISAPLAN
                        FROM TM_KRY AS A
                        LEFT JOIN TT_QUOTA_KRY AS B ON A.NPK = B.NPK
                        WHERE (A.KD_DEPT LIKE '$dept_kode%') AND (A.FLAG_DELETE = '0') AND (A.KD_SECTION LIKE '$kode_sect%') AND (A.KD_SUB_SECTION LIKE '$kode_subsect%') AND (B.TAHUNBULAN LIKE '$periode%')
                        ORDER BY NPK")->result();
        return $data_karyawan;
    }
    
    function get_dept_ot($selected_date, $kode_dept, $kode_sect, $kode_subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $data_dept = $aortadb->query("SELECT DISTINCT KD_DEPT, KD_SECTION, KD_SUB_SECTION
                                    FROM TT_KRY_OVERTIME 
                                    WHERE TGL_OVERTIME LIKE '$selected_date%' 
                                            AND KD_DEPT LIKE '$dept_kode%'
                                            AND KD_SECTION LIKE '$kode_sect%'
                                            AND KD_SUB_SECTION LIKE '$kode_subsect%'")->result();
        return $data_dept;
    }
    
    function get_overtime_weekly($start_date, $end_date, $kode_dept, $kode_sect, $kode_subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $data_weekly = $aortadb->query("SELECT KD_DEPT, KD_SECTION, KD_SUB_SECTION, 
                                        CAST(COUNT(NPK) AS DECIMAL(10, 2)) / 7 AS MP_PER_DAY, 
                                        COALESCE(SUM(CAST(REAL_DURASI_OV_TIME AS DECIMAL(10, 2)))/60/7,0) AS OT_PER_DAY,
                                        COALESCE((SUM(CAST(REAL_DURASI_OV_TIME AS DECIMAL(10, 2))) + (COUNT(CASE WHEN HARI_KJ = 0 OR HARI_KJ = 3 THEN 1 ELSE NULL END) * 480))/(60*NULLIF(COUNT(CAST(REAL_DURASI_OV_TIME AS INT)), 0)), 0) AS MH_PER_DAY
                                    FROM TT_KRY_OVERTIME 
                                    WHERE TGL_OVERTIME BETWEEN '$start_date' AND '$end_date' 
                                            AND KD_DEPT LIKE '$dept_kode%'
                                            AND KD_SECTION LIKE '$kode_sect%'
                                            AND KD_SUB_SECTION LIKE '$kode_subsect%'
                                    GROUP BY KD_DEPT, KD_SECTION, KD_SUB_SECTION")->result();
        return $data_weekly;
    }
    
    function get_data_absensi($selected_date, $kode_dept, $kode_sect, $kode_subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept($kode_dept);
        $data_absen = $aortadb->query("SELECT DISTINCT A.NPK, A.SHIFT, A.HARI_KJ, A.JAM_MASUK, A.JAM_PULANG, B.NAMA, B.KD_DEPT, B.KD_SECTION, B.KD_SUB_SECTION
                                    FROM TT_KRY_ABSENSI AS A
                                    LEFT JOIN TM_KRY AS B ON A.NPK = B.NPK
                                    WHERE A.TGL_ABSEN_MASUK LIKE '$selected_date%' 
                                            AND B.KD_DEPT LIKE '$dept_kode%'
                                            AND B.KD_SECTION LIKE '$kode_sect%'
                                            AND B.KD_SUB_SECTION LIKE '$kode_subsect%'")->result();
        return $data_absen;
    }

}
?>

