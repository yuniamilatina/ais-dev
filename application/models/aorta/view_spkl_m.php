<?php

class view_spkl_m extends CI_Model
{

    private $tabel = 'TT_KRY_OVERTIME';
    private $temp_tabel = 'TW_KRY_OVERTIME';


    function get_join_table_nama($dept, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);


        $query = $aortadb->query("SELECT * FROM TT_KRY_OVERTIME 
        INNER JOIN TM_KRY ON TT_KRY_OVERTIME.NPK = TM_KRY.NPK
        WHERE LEFT(TT_KRY_OVERTIME.TGL_OVERTIME,6) = '$period' and TT_KRY_OVERTIME.KD_DEPT = '$dept' 
        ORDER BY TGL_OVERTIME DESC");
        return $query->result();
    }
    function get_option_filter_dept()
    {
        $aortadb = $this->load->database("aorta", TRUE);


        $query = $aortadb->query("SELECT * from TM_DEP ORDER BY KODE ASC");
        return $query;
    }

    function get_top_data_dept_by_division() {
        $query = $this->db->query("SELECT TOP 1 INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC, INT_ID_GROUP_DEPT FROM TM_DEPT WHERE INT_ID_GROUP_DEPT IN (
            SELECT INT_ID_GROUP_DEPT FROM TM_GROUP_DEPT WHERE INT_ID_DIVISION = '3' AND SUBSTRING(CHR_GROUP_DEPT,7,3) <> 'BOD') AND BIT_FLG_DEL = 0");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_all_dept_by_division_id() {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC FROM TM_DEPT WHERE INT_ID_GROUP_DEPT IN (
            SELECT INT_ID_GROUP_DEPT FROM TM_GROUP_DEPT WHERE INT_ID_DIVISION = '3' AND SUBSTRING(CHR_GROUP_DEPT,7,3) <> 'BOD') AND BIT_FLG_DEL = 0
            UNION SELECT '0', 'ALL','ALL'")->result();
        return $query;
    }

    function get_data_dept($id) {
        $query = $this->db->query("SELECT INT_ID_DEPT, RTRIM(CHR_DEPT) CHR_DEPT ,CHR_DEPT_DESC, INT_ID_GROUP_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = '$id'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_data_overtime($dept, $period, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if ($dept == 'ALL') {
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, SUM(CAST(REAL_MULAI_OV_TIME AS INT))/60 AS REAL_MULAI_OV_TIME, SUM(CAST(REAL_SELESAI_OV_TIME AS INT))/60 AS REAL_SELESAI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, FLG_DOWNLOAD, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND FLG_DELETE = 0
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, FLG_DOWNLOAD, ALASAN
                ORDER BY CEK_GM DESC
                ")->result();
        } elseif($dept == 'ALL' && $section == 'ALL') {
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, SUM(CAST(REAL_MULAI_OV_TIME AS INT))/60 AS REAL_MULAI_OV_TIME, SUM(CAST(REAL_SELESAI_OV_TIME AS INT))/60 AS REAL_SELESAI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, FLG_DOWNLOAD, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND FLG_DELETE = 0
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, FLG_DOWNLOAD, ALASAN
                ORDER BY CEK_GM DESC
                ")->result();
        } elseif($section == 'ALL') {
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, SUM(CAST(REAL_MULAI_OV_TIME AS INT))/60 AS REAL_MULAI_OV_TIME, SUM(CAST(REAL_SELESAI_OV_TIME AS INT))/60 AS REAL_SELESAI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, FLG_DOWNLOAD, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND FLG_DELETE = 0
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, FLG_DOWNLOAD, ALASAN
                ")->result();
        } else {
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, SUM(CAST(REAL_MULAI_OV_TIME AS INT))/60 AS REAL_MULAI_OV_TIME, SUM(CAST(REAL_SELESAI_OV_TIME AS INT))/60 AS REAL_SELESAI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, KD_SECTION, FLG_DOWNLOAD, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND KD_SECTION = '$section' AND FLG_DELETE = 0
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, KD_SECTION, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, FLG_DOWNLOAD, ALASAN
                ")->result();
        }
    }

}
