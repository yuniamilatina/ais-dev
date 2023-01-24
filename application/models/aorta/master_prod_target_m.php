<?php

class Master_prod_target_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function replacer_dept_prd($kode_dept) {

        if($kode_dept == '' || $kode_dept == null || $kode_dept == 'ALL'){
            $dept_kode = null;
        }else{
            $dept = $this->db->query("SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = '$kode_dept'")->row();
            if (count($dept) > 0) {
                $dept_kode = $dept->CHR_DEPT;

                // if($dept_kode == 'BRP'){
                //     $dept_kode = 'PR1';
                // } else if($dept_kode == 'ERP'){
                //     $dept_kode = 'PR3';
                // } else if($dept_kode == 'MFG'){
                //     $dept_kode = 'PR4';
                // } else if($dept_kode == 'QAS'){
                //     $dept_kode = 'QA';
                // } else if($dept_kode == 'PPC'){
                //     $dept_kode = 'PPIC';
                // } else if($dept_kode == 'OMD'){
                //     $dept_kode = 'KZN';
                // }

                // $dept_kode = str_replace("PR", "PRD", $dept_kode);
            }else{
                $dept_kode = null;
            }
        }
        
        return $dept_kode;
    }

    function replacer($kode_dept) {
        if($kode_dept == '' || $kode_dept == null || $kode_dept == 'ALL'){
            $dept_kode = null;
        }else{
            $dept = $this->db->query("SELECT CHR_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = '$kode_dept'")->row();
            if (count($dept) > 0) {
                $dept_kode = $dept->CHR_DEPT;

                // if($dept_kode == 'BRP'){
                //     $dept_kode = "PR1";
                //     // $dept_kode = "PR1','PR2";
                // } else if($dept_kode == 'ERP'){
                //     $dept_kode = 'PR3';
                // } else if($dept_kode == 'MFG'){
                //     $dept_kode = 'PR4';
                // } else if($dept_kode == 'QAS'){
                //     $dept_kode = 'QA';
                // } else if($dept_kode == 'PPC'){
                //     $dept_kode = 'PPIC';
                // } else if($dept_kode == 'OMD'){
                //     $dept_kode = 'KZN';
                // }

                // $dept_kode = str_replace("PR", "PRD", $dept_kode);
            }else{
                $dept_kode = null;
            }
        }
        
        return $dept_kode;
    }

    function get_section($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer($kode_dept);
        $section = $aortadb->query("select KODE, NAMA_SECTION from TM_SECTION where KODE_DEP IN ('$dept_kode') and KODE <> ''")->result();
        return $section;
    }

    function get_section_detail($kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer($kode_dept);
        $section = $aortadb->query("select KODE, NAMA_SECTION from TM_SECTION where KODE_DEP IN ('$dept_kode') and KODE = '$id_section'")->result();
        return $section;
    }
    
    function get_sub_section($kode_dept, $id_section) {
        $aortadb = $this->load->database("aorta", TRUE);
        //$dept_kode = $this->replacer_dept_prd($kode_dept);
        $sub_section = $aortadb->query("select KODE, NAMA_SUBSECT, KODE_SEC from TM_SUBSECTION where KODE_SEC = '$id_section' and KODE <> ''")->result();
        return $sub_section;
    }
   
    function get_data_karyawan($kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        $data_karyawan = $aortadb->query("SELECT     NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE, OPER_ENTRY , salary , position
            FROM         TM_KRY
            WHERE     (KD_DEPT = '$dept_kode') AND (FLAG_DELETE = '0')
            ORDER BY KD_SECTION, KD_SUB_SECTION, NPK")->result();
        //print_r($dept_kode);
        //exit();
        return $data_karyawan;
    }
    
    function get_prod_target($kode_dept, $date_selected, $id_section, $id_subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        
        if($dept_kode == '' || $dept_kode == null || $dept_kode == 'ALL'){
            $data_prod_target = $aortadb->query("SELECT CHR_DEPT
                                           , CHR_SECTION
                                           , CHR_LINE
                                           , CHR_DATE_PERIODE
                                           , INT_TARGET_PRD
                                           , INT_LOAD
                                           , INT_MP
                                           , INT_CT
                                           , FLT_MH_PCS
                                           , INT_PLAN_SHIFT
                                           , INT_WD
                                           FROM TM_PRODUCTION_TARGET
                                           WHERE CHR_DEPT LIKE '%' AND CHR_DATE_PERIODE = '$date_selected'
                                           ORDER BY CHR_DATE_UPLOAD")->result();
        }else{
            if($id_section == NULL || $id_section == '' || $id_section == 'ALL'){
                $data_prod_target = $aortadb->query("SELECT CHR_DEPT
                                               , CHR_SECTION
                                               , CHR_LINE
                                               , CHR_DATE_PERIODE
                                               , INT_TARGET_PRD
                                               , INT_LOAD
                                               , INT_MP
                                               , INT_CT
                                               , FLT_MH_PCS
                                               , INT_PLAN_SHIFT
                                               , INT_WD
                                               FROM TM_PRODUCTION_TARGET
                                               WHERE CHR_DEPT = '$dept_kode' AND CHR_DATE_PERIODE = '$date_selected'
                                               ORDER BY CHR_DATE_UPLOAD")->result();
            }else{
                if($id_subsect == NULL || $id_subsect == '' || $id_subsect == 'ALL'){
                    $data_prod_target = $aortadb->query("SELECT CHR_DEPT
                                                     , CHR_SECTION
                                                     , CHR_LINE
                                                     , CHR_DATE_PERIODE
                                                     , INT_TARGET_PRD
                                                     , INT_LOAD
                                                     , INT_MP
                                                     , INT_CT
                                                     , FLT_MH_PCS
                                                     , INT_PLAN_SHIFT
                                                     , INT_WD
                                                     FROM TM_PRODUCTION_TARGET
                                                     WHERE CHR_DEPT = '$dept_kode' AND CHR_DATE_PERIODE = '$date_selected' AND CHR_SECTION = '$id_section'
                                                     ORDER BY CHR_DATE_UPLOAD")->result(); 
                }else{
                    $data_prod_target = $aortadb->query("SELECT CHR_DEPT
                                                     , CHR_SECTION
                                                     , CHR_LINE
                                                     , CHR_DATE_PERIODE
                                                     , INT_TARGET_PRD
                                                     , INT_LOAD
                                                     , INT_MP
                                                     , INT_CT
                                                     , FLT_MH_PCS
                                                     , INT_PLAN_SHIFT
                                                     , INT_WD
                                                     FROM TM_PRODUCTION_TARGET
                                                     WHERE CHR_DEPT = '$dept_kode' AND CHR_DATE_PERIODE = '$date_selected' AND CHR_SECTION = '$id_section' AND CHR_LINE = '$id_subsect'
                                                     ORDER BY CHR_DATE_UPLOAD")->result();
                }
            }
        }
        return $data_prod_target;
    }
    
    //Get all SECTION and SUB SECTION for all DEPT
    function get_all_section_per_dept($dept){
        $aortadb = $this->load->database("aorta", TRUE);
        $all_section_per_dept = $aortadb->query("SELECT A.KODE AS KD_DEPT
                                                    ,B.KODE AS KD_SECTION
                                                    ,C.KODE AS KD_SUB_SECTION
                                                FROM TM_DEP A
                                                LEFT JOIN TM_SECTION B ON A.KODE = B.KODE_DEP
                                                LEFT JOIN TM_SUBSECTION C ON B.KODE = C.KODE_SEC
                                                WHERE A.KODE = '$dept'")->result();
        return $all_section_per_dept;
    }
    
    //Get overtime quota by SUB SECTION
    function get_overtime_quota($selected_date, $kode_dept, $section, $subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);

        if ($section == "ALL" OR $section == "") {
                $ove_quota = $aortadb->query("SELECT A.KD_DEPT
                                    ,A.KD_SECTION
                                    ,A.KD_SUB_SECTION
                                    ,B.TAHUNBULAN
                                    ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
                                    ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
                                    ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
                                FROM TM_KRY A
                                INNER JOIN (SELECT TAHUNBULAN
                                                    ,NPK
                                                    ,QUOTA_STD
                                                    ,QUOTAPLAN
                                                    ,QUOTA 
                                            FROM TT_QUOTA_KRY
                                            WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
                                WHERE A.KD_DEPT = '$dept_kode' AND A.FLAG_DELETE = '0' AND A.KD_SUB_SECTION <> ''
                                GROUP BY A.KD_DEPT
                                    ,A.KD_SECTION
                                    ,A.KD_SUB_SECTION
                                    ,B.TAHUNBULAN")->result();
            } else {
            if($subsect == "ALL" || $subsect == "" || $subsect == null){
                    $ove_quota = $aortadb->query("SELECT A.KD_DEPT
                                    ,A.KD_SECTION
                                    ,A.KD_SUB_SECTION
                                    ,B.TAHUNBULAN
                                    ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
                                    ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
                                    ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
                                FROM TM_KRY A
                                INNER JOIN (SELECT TAHUNBULAN
                                                    ,NPK
                                                    ,QUOTA_STD
                                                    ,QUOTAPLAN
                                                    ,QUOTA 
                                            FROM TT_QUOTA_KRY
                                            WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
                                WHERE A.KD_DEPT = '$dept_kode' AND A.KD_SECTION = '$section' AND A.KD_SUB_SECTION <> '' AND A.FLAG_DELETE = '0'
                                GROUP BY A.KD_DEPT
                                    ,A.KD_SECTION
                                    ,A.KD_SUB_SECTION
                                    ,B.TAHUNBULAN")->result();
                }else{
                    $ove_quota = $aortadb->query("SELECT A.KD_DEPT
                                    ,A.KD_SECTION
                                    ,A.KD_SUB_SECTION
                                    ,B.TAHUNBULAN
                                    ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
                                    ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
                                    ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
                                FROM TM_KRY A
                                INNER JOIN (SELECT TAHUNBULAN
                                                    ,NPK
                                                    ,QUOTA_STD
                                                    ,QUOTAPLAN
                                                    ,QUOTA 
                                            FROM TT_QUOTA_KRY
                                            WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
                                WHERE A.KD_DEPT = '$dept_kode' AND A.KD_SECTION = '$section' AND A.KD_SUB_SECTION = '$subsect' AND A.FLAG_DELETE = '0'
                                GROUP BY A.KD_DEPT
                                    ,A.KD_SECTION
                                    ,A.KD_SUB_SECTION
                                    ,B.TAHUNBULAN")->result();
                }
                
            }
            return $ove_quota;
    }
    
    //Get overtime quota by SECTION
    function get_overtime_quota_by_section($selected_date, $kode_dept, $section) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);

        // if($dept_kode == 'PRD1'){
        //     if ($section == 'ALL' || $section == '' || $section == null) {
        //         $ove_quota = $aortadb->query("SELECT A.KD_DEPT
        //                                 ,A.KD_SECTION
        //                                 ,B.TAHUNBULAN
        //                                 ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
        //                                 ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
        //                                 ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
        //                             FROM TM_KRY A
        //                             INNER JOIN (SELECT TAHUNBULAN
        //                                                 ,NPK
        //                                                 ,QUOTA_STD
        //                                                 ,QUOTAPLAN
        //                                                 ,QUOTA 
        //                                         FROM TT_QUOTA_KRY
        //                                         WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
        //                             WHERE A.KD_DEPT IN ('PRD1','PRD2') AND A.FLAG_DELETE = '0' AND A.KD_SUB_SECTION <> ''
        //                             GROUP BY A.KD_DEPT
        //                                 ,A.KD_SECTION
        //                                 ,B.TAHUNBULAN")->result();
        //     } else {
        //         $ove_quota = $aortadb->query("SELECT A.KD_DEPT
        //                                 ,A.KD_SECTION
        //                                 ,B.TAHUNBULAN
        //                                 ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
        //                                 ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
        //                                 ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
        //                             FROM TM_KRY A
        //                             INNER JOIN (SELECT TAHUNBULAN
        //                                                 ,NPK
        //                                                 ,QUOTA_STD
        //                                                 ,QUOTAPLAN
        //                                                 ,QUOTA 
        //                                         FROM TT_QUOTA_KRY
        //                                         WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
        //                             WHERE A.KD_DEPT IN ('PRD1','PRD2') AND A.FLAG_DELETE = '0' 
        //                                 AND A.KD_SECTION = '$section'
        //                             GROUP BY A.KD_DEPT
        //                                 ,A.KD_SECTION
        //                                 ,B.TAHUNBULAN")->result();
        //     }
        // }else{
            if ($section == 'ALL' || $section == '' || $section == null) {
                $ove_quota = $aortadb->query("SELECT A.KD_DEPT
                                        ,A.KD_SECTION
                                        ,B.TAHUNBULAN
                                        ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
                                        ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
                                        ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
                                    FROM TM_KRY A
                                    INNER JOIN (SELECT TAHUNBULAN
                                                        ,NPK
                                                        ,QUOTA_STD
                                                        ,QUOTAPLAN
                                                        ,QUOTA 
                                                FROM TT_QUOTA_KRY
                                                WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
                                    WHERE A.KD_DEPT = '$dept_kode' AND A.FLAG_DELETE = '0' AND A.KD_SUB_SECTION <> ''
                                    GROUP BY A.KD_DEPT
                                        ,A.KD_SECTION
                                        ,B.TAHUNBULAN")->result();
            } else {
                $ove_quota = $aortadb->query("SELECT A.KD_DEPT
                                        ,A.KD_SECTION
                                        ,B.TAHUNBULAN
                                        ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
                                        ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
                                        ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
                                    FROM TM_KRY A
                                    INNER JOIN (SELECT TAHUNBULAN
                                                        ,NPK
                                                        ,QUOTA_STD
                                                        ,QUOTAPLAN
                                                        ,QUOTA 
                                                FROM TT_QUOTA_KRY
                                                WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
                                    WHERE A.KD_DEPT = '$dept_kode' AND A.FLAG_DELETE = '0' 
                                        AND A.KD_SECTION = '$section'
                                    GROUP BY A.KD_DEPT
                                        ,A.KD_SECTION
                                        ,B.TAHUNBULAN")->result();
            }
        // }

        

        return $ove_quota;
    }
    
    //Get overtime quota by DEPARTMENT
    function get_overtime_quota_by_dept($selected_date, $kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = trim($this->replacer_dept_prd($kode_dept));
        // if($dept_kode == '' || $dept_kode == null){
        //     $dept_kode = 'PRD';
        // }

        //===== TEMPORARY EFFECT CHANGE DEPT NAME ======//
        // if($dept_kode == 'PRD1'){
        //     $ove_quota = $aortadb->query("SELECT A.KD_DEPT
        //                             ,B.TAHUNBULAN
        //                             ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
        //                             ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
        //                             ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
        //                         FROM TM_KRY A
        //                         INNER JOIN (SELECT TAHUNBULAN
        //                                             ,NPK
        //                                             ,QUOTA_STD
        //                                             ,QUOTAPLAN
        //                                             ,QUOTA 
        //                                     FROM TT_QUOTA_KRY
        //                                     WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
        //                         WHERE A.KD_DEPT IN ('PRD1', 'PRD2') AND A.FLAG_DELETE = '0' AND A.KD_SUB_SECTION <> ''
        //                         GROUP BY A.KD_DEPT ,B.TAHUNBULAN")->result();
        // } else {
            $ove_quota = $aortadb->query("SELECT A.KD_DEPT
                                    ,B.TAHUNBULAN
                                    ,SUM(CAST(B.QUOTA_STD AS INT)) AS QUOTA_STD
                                    ,SUM(CAST(B.QUOTAPLAN AS INT)) AS QUOTA_PLAN
                                    ,SUM(CAST(B.QUOTA AS INT)) AS PLAFOND
                                FROM TM_KRY A
                                INNER JOIN (SELECT TAHUNBULAN
                                                    ,NPK
                                                    ,QUOTA_STD
                                                    ,QUOTAPLAN
                                                    ,QUOTA 
                                            FROM TT_QUOTA_KRY
                                            WHERE TAHUNBULAN = '$selected_date') B ON A.NPK = B.NPK
                                WHERE A.KD_DEPT LIKE '$dept_kode%' AND A.FLAG_DELETE = '0' AND A.KD_SUB_SECTION <> ''
                                GROUP BY A.KD_DEPT ,B.TAHUNBULAN")->result();
        // }
        
        return $ove_quota;
    }
    
    //Get overtime summary by SUB SECTION
    function get_overtime_summary_all($selected_date, $kode_dept, $id_section, $id_subsect) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = $this->replacer_dept_prd($kode_dept);
        
        if ($id_section == "ALL" OR $id_section == "") {
                $summary_all = $aortadb->query("EXEC zsp_get_summary_overtime_by_dept '$selected_date', '$dept_kode'")->result();
            } else {
                if($id_subsect == 'ALL' || $id_subsect == '' || $id_subsect == null){
                    $summary_all = $aortadb->query("EXEC zsp_get_summary_overtime_by_sect '$selected_date', '$dept_kode', '$id_section'")->result();
                }else{
                    $summary_all = $aortadb->query("EXEC zsp_get_summary_overtime_by_subsect '$selected_date', '$dept_kode', '$id_section', '$id_subsect'")->result();
                }
                
            }

        return $summary_all;
    }
    
    //Get overtime summary by SECTION
    function get_overtime_summary_by_section($selected_date, $kode_dept, $id_section) {

        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = trim($this->replacer_dept_prd($kode_dept));

        if($id_section == 'ALL' || $id_section == '' || $id_section == null){
            $id_section = '';
        }else{
            $id_section = $id_section;
        }

        // if($dept_kode == 'PRD1'){
        //     return $aortadb->query("EXEC zsp_get_summary_overtime_by_section_prd1 '$selected_date', '$id_section'")->result();
        // }else{

            //$dept_kode = 'MIS';
            //$id_section = '';
            //echo 'hello '.$kode_dept;

            return $aortadb->query("EXEC zsp_get_summary_overtime_by_section '$selected_date', '$dept_kode', '$id_section'")->result();

        // }
        
    }
    
    //Get overtime summary by DEPARTMENT
    function get_overtime_summary_dept($selected_date, $kode_dept) {
        $aortadb = $this->load->database("aorta", TRUE);
        $dept_kode = trim($this->replacer_dept_prd($kode_dept));
        // if($dept_kode == '' || $dept_kode == null){
        //     $dept_kode = 'PRD';
        // }
        $id_section = '';
        $summary_all = $aortadb->query("EXEC zsp_get_summary_overtime_by_dept_anp '$selected_date', '$dept_kode', '$id_section'")->result();
       
        return $summary_all;
    }
    
    function get_holiday($selected_date){
        $aortadb = $this->load->database("aorta", TRUE);
        $get_holiday = $aortadb->query("SELECT TGL_LIBUR, KETERANGAN, CHR_TIPE_LB FROM TM_HOLIDAY "
                . "WHERE TGL_LIBUR LIKE '$selected_date%'")->result();
        return $get_holiday;
    }

}
