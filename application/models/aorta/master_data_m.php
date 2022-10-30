<?php

class Master_data_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function replacer_dept_prd($kode_dept) {
        $dept = $this->db->query("select CHR_DEPT from TM_DEPT where INT_ID_DEPT = '$kode_dept'")->row();

        if (count($dept) > 0) {
            $dept_kode = $dept->CHR_DEPT;
        } else {
            $dept_kode = $kode_dept;
        }
        // $dept_kode = str_replace("PR", "PRD", $dept_kode);
        return $dept_kode;
    }

    function get_section($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);

        if ($kode_dept == "all") {
            $section = $aortadb->query("SELECT DISTINCT KD_SECTION KODE, KD_SECTION NAMA_SECTION FROM TM_KRY WHERE KD_SECTION <> ''")->result();
        } else {
            $section = $aortadb->query("SELECT DISTINCT KD_SECTION KODE, KD_SECTION NAMA_SECTION FROM TM_KRY WHERE KD_DEPT = '$dept_kode' and KD_SECTION <> ''")->result();
        }
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
        $dept_kode = $this->get_kd_dept_aorta($dept_kode);
        $data_karyawan = $aortadb->query("SELECT    NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE, OPER_ENTRY , salary , position , tunj_transport ,  tunj_jabatan
            FROM         TM_KRY
            WHERE     (KD_DEPT = '$dept_kode') AND (FLAG_DELETE = '0')
            ORDER BY KD_SECTION, KD_SUB_SECTION, NPK")->result();

        return $data_karyawan;
    }

    function get_report_amount($kode_dept, $periode, $section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);

        if ($section == "ALL" OR $section == "") {
            $data_karyawan = $aortadb->query(""
                            . "select A.NPK , A.NAMA , (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) AS SALARY, A.KD_DEPT, A.KD_SECTION , CAST('40' AS INT) AS 'QUOTA_STANDARD', ( B.QUOTA - CAST('40' AS INT) ) AS 'QUOTA_TAMBAHAN',
                    B.QUOTA  , C.TOT_DUR_OT , 
                    ( 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 *  A.SALARY) AS 'AMOUNT_SALARY' ,
                    (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) + (0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY) AS 'THP', 
                    (CASE WHEN 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY > (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END)*50/100 THEN 'NG' ELSE 'OK' END) AS 'STAT' 
                    FROM TM_KRY AS A 
                    INNER JOIN
                    TT_QUOTA_KRY AS B
                    ON
                    A.NPK = B.NPK
                    LEFT JOIN
                    ( SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT) /60) AS 'TOT_DUR_OT' , NPK FROM TT_KRY_OVERTIME WHERE  TGL_OVERTIME LIKE '$periode%' GROUP BY NPK
                    ) AS C
                    ON 
                    A.NPK = C.NPK
                    WHERE A.KD_DEPT = '$dept_kode' AND B.TAHUNBULAN LIKE '$periode%' 
                    ORDER BY (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) + (0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY) DESC")->result();
        } else {
            $data_karyawan = $aortadb->query(""
                            . "Select A.NPK , A.NAMA , (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) AS SALARY, 
                                A.KD_DEPT, A.KD_SECTION , CAST('40' AS INT) AS 'QUOTA_STANDARD', ( B.QUOTA - CAST('40' AS INT) ) AS 'QUOTA_TAMBAHAN',
                    B.QUOTA  , C.TOT_DUR_OT , 
                    ( 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 *  A.SALARY) AS 'AMOUNT_SALARY' ,
                    (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) + (0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY) AS 'THP', 
                    (CASE WHEN 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY > (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END)*50/100 THEN 'NG' ELSE 'OK' END) AS 'STAT' 
                    FROM TM_KRY AS A 
                    INNER JOIN
                    TT_QUOTA_KRY AS B
                    ON
                    A.NPK = B.NPK
                    LEFT JOIN
                    ( SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT) /60) AS 'TOT_DUR_OT' , NPK FROM TT_KRY_OVERTIME WHERE  TGL_OVERTIME LIKE '$periode%' GROUP BY NPK
                    ) AS C
                    ON 
                    A.NPK = C.NPK
                    WHERE A.KD_DEPT = '$dept_kode' AND B.TAHUNBULAN LIKE '$periode%'  and A.KD_SECTION = '$section'
                    ORDER BY (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) + (0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY) DESC")->result();
        }

        return $data_karyawan;
    }

    function get_report_amount_bod($periode) {
        $aortadb = $this->load->database("aorta", TRUE);
        $data_karyawan = $aortadb->query(""
                        . "select A.NPK , A.NAMA , (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) AS SALARY, 
                    A.KD_DEPT, A.KD_SECTION , CAST('40' AS INT) AS 'QUOTA_STANDARD', ( B.QUOTA - CAST('40' AS INT) ) AS 'QUOTA_TAMBAHAN',
                    B.QUOTA  , C.TOT_DUR_OT , 
                    ( 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 *  A.SALARY) AS 'AMOUNT_SALARY' ,
                    (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) + (0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY) AS 'THP', 
                    (CASE WHEN 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY > (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END)*50/100 THEN 'NG' ELSE 'OK' END) AS 'STAT' 
                    FROM TM_KRY AS A 
                    INNER JOIN
                    TT_QUOTA_KRY AS B
                    ON
                    A.NPK = B.NPK
                    LEFT JOIN
                    ( SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT) /60) AS 'TOT_DUR_OT' , NPK FROM TT_KRY_OVERTIME WHERE  TGL_OVERTIME LIKE '$periode%' GROUP BY NPK
                    ) AS C
                    ON 
                    A.NPK = C.NPK
                    WHERE  B.TAHUNBULAN LIKE '$periode%' 
                    ORDER BY (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) + (0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY) DESC")->result();

        return $data_karyawan;
    }

    function get_chart($kode_dept, $periode, $section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);


        if ($section == "ALL" OR $section == "") {
            $data_karyawan = $aortadb->query(""
                            . "SELECT SUM(ISNULL(AMOUNT_SALARY,0)) AS 'AMOUNT_SALARY' , 
                            SUM(ISNULL(AMOUNT_PLANNING,0)) AS 'AMOUNT_PLANNING', 
                            SUM(ISNULL(PLAFOND_SALARY,0)) AS 'AMOUNT_PLAFOND' , KD_SECTION FROM (Select A.NPK , A.NAMA , (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) AS SALARY, A.KD_DEPT, A.KD_SECTION , CAST('40' AS INT) AS 'QUOTA_STANDARD', ( B.QUOTA - CAST('40' AS INT) ) AS 'QUOTA_TAMBAHAN',
                            B.QUOTA , C.TOT_DUR_OT , 
                            ( 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 *  A.SALARY) AS 'AMOUNT_SALARY' , ( 0.006 * 40) * 2 *  A.SALARY AS 'AMOUNT_PLANNING' , ( 0.006 * CAST(B.QUOTA AS INT) * 2 *  A.SALARY) AS 'PLAFOND_SALARY' ,
                            (CASE WHEN (CAST(C.TOT_DUR_OT AS INT) - 40) < 0 THEN 'OK' ELSE 'NG' END) AS 'STAT'
                            FROM  TM_KRY AS A
                            INNER JOIN
                            TT_QUOTA_KRY AS B
                            ON
                            A.NPK = B.NPK
                            LEFT JOIN
                            ( SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT) /60) AS 'TOT_DUR_OT' , NPK FROM TT_KRY_OVERTIME WHERE  TGL_OVERTIME LIKE '$periode%' GROUP BY NPK
                            ) AS C
                            ON 
                            A.NPK = C.NPK
                            WHERE A.KD_DEPT = '$dept_kode' AND B.TAHUNBULAN LIKE '$periode%' ) AS A GROUP BY KD_SECTION
                            ")->result();
        } else {
            $data_karyawan = $aortadb->query(""
                            . "SELECT SUM(ISNULL(AMOUNT_SALARY,0)) AS 'AMOUNT_SALARY' , 
                            SUM(ISNULL(AMOUNT_PLANNING,0)) AS 'AMOUNT_PLANNING', 
                            SUM(ISNULL(PLAFOND_SALARY,0)) AS 'AMOUNT_PLAFOND' , KD_SECTION FROM (Select A.NPK , A.NAMA , (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) AS SALARY, A.KD_DEPT, A.KD_SECTION , CAST('40' AS INT) AS 'QUOTA_STANDARD', ( B.QUOTA - CAST('40' AS INT) ) AS 'QUOTA_TAMBAHAN',
                            B.QUOTA  , C.TOT_DUR_OT , 
                            ( 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 *  A.SALARY) AS 'AMOUNT_SALARY' , ( 0.006 * 40) * 2 *  A.SALARY AS 'AMOUNT_PLANNING' , ( 0.006 * CAST(B.QUOTA AS INT) * 2 *  A.SALARY) AS 'PLAFOND_SALARY' ,
                            (CASE WHEN (CAST(C.TOT_DUR_OT AS INT) - 40) < 0 THEN 'OK' ELSE 'NG' END) AS 'STAT'
                            FROM  TM_KRY AS A
                            INNER JOIN
                            TT_QUOTA_KRY AS B
                            ON
                            A.NPK = B.NPK
                            LEFT JOIN
                            ( SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT) /60) AS 'TOT_DUR_OT' , NPK FROM TT_KRY_OVERTIME WHERE  TGL_OVERTIME LIKE '$periode%' GROUP BY NPK
                            ) AS C
                            ON 
                            A.NPK = C.NPK
                            WHERE A.KD_DEPT = '$dept_kode' AND B.TAHUNBULAN LIKE '$periode%' and A.KD_SECTION = '$section' )  AS A GROUP BY KD_SECTION
                            ")->result();
        }

        return $data_karyawan;
    }

    function get_chart_bod($periode) {
        $aortadb = $this->load->database("aorta", TRUE);

        $data_karyawan = $aortadb->query(""
                        . "SELECT SUM(ISNULL(AMOUNT_SALARY,0)) AS 'AMOUNT_SALARY' , 
                            SUM(ISNULL(AMOUNT_PLANNING,0)) AS 'AMOUNT_PLANNING', 
                            SUM(ISNULL(PLAFOND_SALARY,0)) AS 'AMOUNT_PLAFOND' , KD_DEPT FROM (Select A.NPK , A.NAMA , (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) AS SALARY, A.KD_DEPT, A.KD_SECTION , CAST('40' AS INT) AS 'QUOTA_STANDARD', ( B.QUOTA - CAST('40' AS INT) ) AS 'QUOTA_TAMBAHAN',
                            B.QUOTA , C.TOT_DUR_OT , 
                            ( 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 *  A.SALARY) AS 'AMOUNT_SALARY' , ( 0.006 * 40) * 2 *  A.SALARY AS 'AMOUNT_PLANNING' , ( 0.006 * CAST(B.QUOTA AS INT) * 2 *  A.SALARY) AS 'PLAFOND_SALARY' ,
                            (CASE WHEN (CAST(C.TOT_DUR_OT AS INT) - 40) < 0 THEN 'OK' ELSE 'NG' END) AS 'STAT'
                            FROM  TM_KRY AS A
                            INNER JOIN
                            TT_QUOTA_KRY AS B
                            ON
                            A.NPK = B.NPK
                            LEFT JOIN
                            ( SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT) /60) AS 'TOT_DUR_OT' , NPK FROM TT_KRY_OVERTIME WHERE  TGL_OVERTIME LIKE '$periode%' GROUP BY NPK
                            ) AS C
                            ON 
                            A.NPK = C.NPK
                            WHERE  B.TAHUNBULAN LIKE '$periode%' ) AS A GROUP BY KD_DEPT
                            ")->result();

        return $data_karyawan;
    }
    
    function get_chart_bod_prd($periode) {
        $aortadb = $this->load->database("aorta", TRUE);

        $data_karyawan = $aortadb->query(""
                        . "SELECT SUM(ISNULL(AMOUNT_SALARY,0)) AS 'AMOUNT_SALARY' , 
                            SUM(ISNULL(AMOUNT_PLANNING,0)) AS 'AMOUNT_PLANNING', 
                            SUM(ISNULL(PLAFOND_SALARY,0)) AS 'AMOUNT_PLAFOND' , KD_DEPT FROM (Select A.NPK , A.NAMA , (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) AS SALARY, A.KD_DEPT, A.KD_SECTION , CAST('40' AS INT) AS 'QUOTA_STANDARD', ( B.QUOTA - CAST('40' AS INT) ) AS 'QUOTA_TAMBAHAN',
                            B.QUOTA , C.TOT_DUR_OT , 
                            ( 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 *  A.SALARY) AS 'AMOUNT_SALARY' , ( 0.006 * 40) * 2 *  A.SALARY AS 'AMOUNT_PLANNING' , ( 0.006 * CAST(B.QUOTA AS INT) * 2 *  A.SALARY) AS 'PLAFOND_SALARY' ,
                            (CASE WHEN (CAST(C.TOT_DUR_OT AS INT) - 40) < 0 THEN 'OK' ELSE 'NG' END) AS 'STAT'
                            FROM  TM_KRY AS A
                            INNER JOIN
                            TT_QUOTA_KRY AS B
                            ON
                            A.NPK = B.NPK
                            LEFT JOIN
                            ( SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT) /60) AS 'TOT_DUR_OT' , NPK FROM TT_KRY_OVERTIME WHERE  TGL_OVERTIME LIKE '$periode%' GROUP BY NPK
                            ) AS C
                            ON 
                            A.NPK = C.NPK
                            WHERE  B.TAHUNBULAN LIKE '$periode%' and A.KD_DEPT IN ('PRD1' , 'PRD2' , 'PRD3' , 'PRD4') ) AS A GROUP BY KD_DEPT
                            ")->result();

        return $data_karyawan;
    }
    
    function get_chart_bod_spt($periode) {
        $aortadb = $this->load->database("aorta", TRUE);
        $data_karyawan = $aortadb->query("SELECT 
                            SUM(ISNULL(AMOUNT_SALARY,0)) AS 'AMOUNT_SALARY' , 
                            SUM(ISNULL(AMOUNT_PLANNING,0)) AS 'AMOUNT_PLANNING', 
                            SUM(ISNULL(PLAFOND_SALARY,0)) AS 'AMOUNT_PLAFOND' , KD_DEPT FROM (Select A.NPK , A.NAMA , 
                            (CASE WHEN A.SALARY IS NULL THEN '0' ELSE A.SALARY END) AS SALARY, A.KD_DEPT,
                             A.KD_SECTION , CAST('40' AS INT) AS 'QUOTA_STANDARD', ( B.QUOTA - CAST('40' AS INT) ) AS 'QUOTA_TAMBAHAN',
                              B.QUOTA , C.TOT_DUR_OT , ( 0.006 * CAST(C.TOT_DUR_OT AS INT) * 2 * A.SALARY) AS 'AMOUNT_SALARY' ,
                               ( 0.006 * 40) * 2 * A.SALARY AS 'AMOUNT_PLANNING' , ( 0.006 * CAST(B.QUOTA AS INT) * 2 * A.SALARY) AS 
                               'PLAFOND_SALARY' , (CASE WHEN (CAST(C.TOT_DUR_OT AS INT) - 40) < 0 THEN 'OK' ELSE 'NG' END) 
                               AS 'STAT' FROM TM_KRY AS A
                            INNER JOIN
                            TT_QUOTA_KRY AS B
                            ON
                            A.NPK = B.NPK
                            LEFT JOIN
                            ( SELECT SUM(CAST(REAL_DURASI_OV_TIME AS INT) /60) AS 'TOT_DUR_OT' , NPK FROM TT_KRY_OVERTIME WHERE  TGL_OVERTIME LIKE '$periode%' GROUP BY NPK
                            ) AS C
                            ON 
                            A.NPK = C.NPK
                            WHERE  B.TAHUNBULAN LIKE '$periode%' and A.KD_DEPT IN ('ENG' , 'KZN' , 'MISY' , 'MSU' , 'MTE' , 'PC' , 'PPIC' , 'QA' , 'QC') ) AS A GROUP BY KD_DEPT
                            ");

        return $data_karyawan->result();
    }

    //summary planning
    function select_summary_overtime_plan($period, $dept, $section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $stored_procedure = "EXEC zsp_get_summary_overtime_plan ?,?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept,
            'section' => $section);

        $query = $aortadb->query($stored_procedure, $param);

        return $query->result();
    }

    //summary realisasi
    function select_summary_overtime_real($period, $dept, $section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $stored_procedure = "EXEC zsp_get_summary_overtime_real ?,?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept,
            'section' => $section);

        $query = $aortadb->query($stored_procedure, $param);

        return $query->result();
    }

    //total row
    function total_row_summary($period, $dept, $section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $stored_procedure = "EXEC zsp_get_summary_overtime_real ?,?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept,
            'section' => $section);

        $query = $aortadb->query($stored_procedure, $param);

        return $query->num_rows();
    }
    
    function get_manager() {
        $get_manager = $this->db->query("SELECT * FROM TM_USER WHERE INT_ID_ROLE IN ('4','5','39','44','45','46','47','48','49','50','52')")->result();
        return $get_manager;
    }
    
    function get_all_user() {
        $get_user = $this->db->query("SELECT * FROM TM_USER WHERE INT_ID_ROLE NOT IN ('4','5','39','44','45','46','47','48','49','50','52')")->result();
        return $get_user;
    }
    
    function get_group() {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_group = $aortadb->query("select distinct KD_GROUP from TM_DEP")->result();
        return $get_group;
    }
    
    //============= QUERY DEPARTMENT -- BY ANP ===============================//
    function get_dept() {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_dept = $aortadb->query("select * from TM_DEP")->result();
        return $get_dept;
    }

    function get_top_dept() {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_dept = $aortadb->query("select top 1 KODE from TM_DEP")->row()->KODE;
        return $get_dept;
    }
    
    function get_dept_by_id($id) {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_dept = $aortadb->query("select * from TM_DEP where KODE = '$id'")->row();
        return $get_dept;
    }
    
    function save_dept($data) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert('TM_DEP', $data);
    }
    
    function update_dept($data, $dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->where('KODE', $dept);
        $aortadb->update('TM_DEP', $data);
    }
    
    function delete_dept($dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->query("DELETE FROM TM_DEP WHERE KODE = '$dept'");
    }
    //========================================================================//
    
    //============= QUERY SECTION -- BY ANP ==================================//
    function get_sect() {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_sect = $aortadb->query("select * from TM_SECTION")->result();
        return $get_sect;
    }

    function get_top_sect_by_dept($dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_dept = $aortadb->query("select top 1 KODE from TM_SECTION WHERE KODE_DEP = '$dept'")->row()->KODE;
        return $get_dept;
    }

    function get_sect_by_dept($dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_sect = $aortadb->query("select * from TM_SECTION WHERE KODE_DEP = '$dept'")->result();
        return $get_sect;
    }
    
    function get_sect_by_id($id) {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_sect = $aortadb->query("select * from TM_SECTION where KODE = '$id'")->row();
        return $get_sect;
    }
    
    function save_sect($data) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert('TM_SECTION', $data);
    }
    
    function update_sect($data, $sect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->where('KODE', $sect);
        $aortadb->update('TM_SECTION', $data);
    }
    
    function delete_sect($sect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->query("DELETE FROM TM_SECTION WHERE KODE = '$sect'");
    }
    //========================================================================//
    
    //============= QUERY SUBSECTION -- BY ANP ===============================//
    function get_subsect() {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_subsect = $aortadb->query("select * from TM_SUBSECTION")->result();
        return $get_subsect;
    }
    
    function get_subsect_by_id($id) {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_subsect = $aortadb->query("select * from TM_SUBSECTION where KODE = '$id'")->row();
        return $get_subsect;
    }
    
    function save_subsect($data) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert('TM_SUBSECTION', $data);
    }
    
    function update_subsect($data, $subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->where('KODE', $subsect);
        $aortadb->update('TM_SUBSECTION', $data);
    }
    
    function delete_subsect($subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->query("DELETE FROM TM_SUBSECTION WHERE KODE = '$subsect'");
    }
    //========================================================================//
    
    function get_ot_category() {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_cat = $aortadb->query("select * from TM_OT_CATEGORY where CHR_FLG_DELETE <> '1'")->result();
        return $get_cat;
    }
    
    //SUMMARY OVERTIME BY PRODUCTION DEPT --- ANP
    function get_overtime_summary_by_dept_prd($selected_date, $kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        if ($kode_dept == 'ALL' || $kode_dept == '' || $kode_dept == NULL){
            $dept_kode = '';
        } else {
            $dept_kode = $kode_dept;
        }
        
        if ($id_section == 'ALL' || $id_section == '' || $id_section == null){
            $id_section = '';
        } else {
            $id_section = $id_section;
        }
        return $aortadb->query("EXEC zsp_get_summary_ot_amount_by_dept_prd '$selected_date', '$dept_kode', '$id_section'")->result();
    }
    
    //SUMMARY OVERTIME BY SUPPORT DEPT --- ANP
    function get_overtime_summary_by_dept_spt($selected_date, $kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        if ($kode_dept == 'ALL' || $kode_dept == '' || $kode_dept == NULL){
            $dept_kode = '';
        } else {
            $dept_kode = $kode_dept;
        }
        
        if ($id_section == 'ALL' || $id_section == '' || $id_section == null){
            $id_section = '';
        } else {
            $id_section = $id_section;
        }
        return $aortadb->query("EXEC zsp_get_summary_ot_amount_by_dept_spt '$selected_date', '$dept_kode', '$id_section'")->result();
    }
        
    //SUMMARY OVERTIME BY SECTION --- ANP
    function get_overtime_summary_by_section($selected_date, $kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = trim($this->replacer_dept_prd($kode_dept));
        if($id_section == 'ALL' || $id_section == '' || $id_section == null){
            $id_section = '';
        }else{
            $id_section = $id_section;
        }
        return $aortadb->query("EXEC zsp_get_summary_ot_amount_by_section '$selected_date', '$dept_kode', '$id_section'")->result();
    }
    
    //SUMMARY OVERTIME PER KARYAWAN --- ANP
    function get_overtime_summary_per_kry($selected_date, $kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = trim($this->replacer_dept_prd($kode_dept));
        if($id_section == 'ALL' || $id_section == '' || $id_section == null){
            $id_section = '';
        }else{
            $id_section = $id_section;
        }
        return $aortadb->query("EXEC zsp_get_summary_ot_amount_per_kry '$selected_date', '$dept_kode', '$id_section'")->result();
    }
    
    //SUMMARY OVERTIME PER KARYAWAN FOR BOD VIEW --- ANP
    function get_overtime_summary_per_kry_bod($selected_date, $kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        if($kode_dept == 'ALL' || $kode_dept == '' || $kode_dept == NULL){
            $dept_kode = '';
        } else {
            $dept_kode = $kode_dept;
        }
        
        if($id_section == 'ALL' || $id_section == '' || $id_section == null){
            $id_section = '';
        }else{
            $id_section = $id_section;
        }
        return $aortadb->query("EXEC zsp_get_summary_ot_amount_per_kry '$selected_date', '$dept_kode', '$id_section'")->result();
    }
    
    //============= QUERY POLICY -- BY ANP ===================================//
    function get_policy() {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_policy = $aortadb->query("select * from TM_POLICY")->result();
        return $get_policy; 
    }
    
    function get_policy_by_id($id) {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_subsect = $aortadb->query("select * from TM_POLICY where POLICY_KEY = '$id'")->row();
        return $get_subsect;
    }
    
    function save_policy($data) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert('TM_POLICY', $data);
    }
    
    function update_policy($data, $id) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->where('POLICY_KEY', $id);
        $aortadb->update('TM_POLICY', $data);
    }
    
    function delete_policy($id) {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->query("DELETE FROM POLICY_KEY WHERE POLICY_KEY = '$id'");
    }

    function get_kd_dept_aorta($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $get_kode_dept = $aortadb->query("select CHR_KODE_DEPT_AORTA from TM_MATRIX_KODE_DEPT_AIS where CHR_KODE_DEPT_AIS = '$kode_dept'")->row();
        return trim($get_kode_dept->CHR_KODE_DEPT_AORTA);
    }
    //========================================================================//

}
