<?php

class overtime_m extends CI_Model
{

    private $tabel = 'TT_KRY_OVERTIME';
    private $temp_tabel = 'TW_KRY_OVERTIME';

    function save($no_sequence, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        //create ot id in this Sp and flag finish table tw
        $stored_procedure = "EXEC zsp_merge_overtime_by_no_sequence ?,?";
        $param = array('no_temp_sequence' => $no_sequence, 'period' => $period);

        $aortadb->query($stored_procedure, $param);
    }

    function decrease_quota_employee_by_no_sequence($no_sequence, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $data = $aortadb->query("SELECT RTRIM(NPK) NPK, ROUND(CONVERT(FLOAT,RENC_DURASI_OV_TIME) / 60,2) RENC_DURASI_OV_TIME 
        FROM TW_KRY_OVERTIME WHERE NO_SEQUENCE = '$no_sequence'")->result();

        foreach ($data as $isi) {
            $aortadb->query("UPDATE TT_QUOTA_KRY SET 
            TERPAKAIPLAN =  CAST(REPLACE(TERPAKAIPLAN,',','.') AS FLOAT) + $isi->RENC_DURASI_OV_TIME , 
            SISAPLAN = CAST(REPLACE(SISAPLAN,',','.') AS FLOAT) - $isi->RENC_DURASI_OV_TIME
            WHERE NPK = '$isi->NPK' AND TAHUNBULAN = '$period' ");
        }
    }

    function delete($no_sequence, $tgl_overtime){
        $aortadb = $this->load->database("aorta", TRUE);

        $aortadb->query("UPDATE TT_KRY_OVERTIME SET FLG_DELETE = 1 WHERE NO_SEQUENCE = '$no_sequence' AND TGL_OVERTIME = '$tgl_overtime'");
       
    }

    function increase_quota_employee_by_no_sequence($no_sequence, $period){
        $aortadb = $this->load->database("aorta", TRUE);

        $data = $aortadb->query("SELECT RTRIM(NPK) NPK, ROUND(CONVERT(FLOAT,RENC_DURASI_OV_TIME) / 60,2) RENC_DURASI_OV_TIME 
        FROM TT_KRY_OVERTIME WHERE NO_SEQUENCE = '$no_sequence'")->result();

        foreach ($data as $isi) {
            $aortadb->query("UPDATE TT_QUOTA_KRY SET 
            TERPAKAIPLAN =  CAST(REPLACE(TERPAKAIPLAN,',','.') AS FLOAT) - $isi->RENC_DURASI_OV_TIME , 
            SISAPLAN = CAST(REPLACE(SISAPLAN,',','.') AS FLOAT) + $isi->RENC_DURASI_OV_TIME
            WHERE NPK = '$isi->NPK' AND TAHUNBULAN = '$period' ");
        }
    }

    function save_temp_overtime($data)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert($this->temp_tabel, $data);
    }

    function remove_npk_temp_ot($id, $npk)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->where('NO_SEQUENCE', $id);
        $aortadb->where('NPK', $npk);
        $aortadb->delete($this->temp_tabel);
    }

    function check_ot_by_npk($npk, $tanggal)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT * FROM TW_KRY_OVERTIME WHERE NPK = '$npk' AND TGL_OVERTIME = '$tanggal'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    // function check_temp_ot_by_npk($npk, $tanggal)
    // {
    //     $aortadb = $this->load->database("aorta", TRUE);
    //     $query = $aortadb->query("SELECT * FROM TW_KRY_OVERTIME WHERE NPK = '$npk' AND TGL_OVERTIME = '$tanggal'");

    //     if ($query->num_rows() > 0) {
    //         return $query->row();
    //     } else {
    //         return false;
    //     }
    // }

    function check_ot_by_section($section, $tanggal)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT * FROM TT_KRY_OVERTIME WHERE KD_SECTION = '$section' AND TGL_OVERTIME = '$tanggal'");

        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function get_candidate_id_overtime($period)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 NO_SEQUENCE + 1 NO_SEQUENCE FROM TW_KRY_OVERTIME WHERE NO_SEQUENCE LIKE '$period%' ORDER BY NO_SEQUENCE DESC");

        if ($query->num_rows() > 0) {
            return $query->row()->NO_SEQUENCE;
        } else {
            return $period . '0001';
        }
    }

    function get_last_candidate_id_overtime($tanggal, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 NO_SEQUENCE + 1 NO_SEQUENCE FROM TW_KRY_OVERTIME WHERE 
            TGL_OVERTIME LIKE '$tanggal' AND KD_DEPT = '$dept' AND KD_SECTION = '$section' 
            ORDER BY NO_SEQUENCE DESC");

        return $query->row()->NO_SEQUENCE;
    }

    function get_data_quota_employee_by_period_and_npk($period, $npk)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT * FROM TT_QUOTA_KRY WHERE TAHUNBULAN='$period' AND NPK = '$npk'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function get_data_overtime($dept, $period, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, KD_SECTION, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND KD_SECTION = '$section' AND FLG_DELETE = 0
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, KD_SECTION, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, ALASAN
                ");
                
        return $query->result();
    }

    function get_data_overtime_by_spv($dept, $period, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if($section == 'ALL'){
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, KD_SECTION, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND FLG_DELETE = 0
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, KD_SECTION, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, ALASAN
                ")->result();
        }else{
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, KD_SECTION, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND KD_SECTION = '$section' AND FLG_DELETE = 0
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, KD_SECTION, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, ALASAN
                ")->result();
        }

    }

    function get_data_overtime_by_mgr($dept, $period, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if($section == 'ALL'){
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, KD_SECTION, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND CEK_SPV = '1'
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, KD_SECTION, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, ALASAN
                ")->result();
        }else{
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, KD_SECTION, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND KD_SECTION = '$section' AND CEK_SPV = '1'
                GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, KD_SECTION, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, ALASAN
                ")->result();
        }


    }

    function get_data_overtime_by_gm($dept, $period, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if($section == 'ALL'){
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, KD_SECTION, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND CEK_SPV = '1' AND CEK_KADEP = '1'
                    GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, KD_SECTION, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, ALASAN
                    ORDER BY CEK_GM
                    ")->result();
        }else{
            return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, COUNT(NPK) AS TOT_MP, SUM(CAST(RENC_DURASI_OV_TIME AS DECIMAL(10,2)))/60 AS RENC_DURASI_OV_TIME, CEK_GM, CEK_KADEP, CEK_SPV, KD_DEPT, KD_SECTION, ALASAN
            FROM TT_KRY_OVERTIME WHERE TGL_OVERTIME LIKE '$period%' AND KD_DEPT = '$dept' AND KD_SECTION = '$section' AND CEK_SPV = '1' AND CEK_KADEP = '1'
                    GROUP BY CEK_GM, CEK_KADEP, CEK_SPV, KD_SECTION, NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, ALASAN
                    ORDER BY CEK_GM
                    ")->result();
        }

    }

    function get_data_overtime_by_no_spkl($no_spkl)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $periode = substr($no_spkl, 0, 6);

        return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, HARI_KJ, A.NPK, K.NAMA, NPK_PIC, 
            RENC_MULAI_OV_TIME, RENC_SELESAI_OV_TIME, RENC_DURASI_OV_TIME ,
            REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME, REAL_DURASI_OV_TIME, 
            LEFT(RENC_MULAI_OV_TIME,2) +':'+ SUBSTRING(RENC_MULAI_OV_TIME,3,2) RENCANA_MULAI, 
            LEFT(RENC_SELESAI_OV_TIME,2) +':'+ SUBSTRING(RENC_SELESAI_OV_TIME,3,2) RENCANA_END, 
            LEFT(REAL_MULAI_OV_TIME,2) +':'+ SUBSTRING(REAL_MULAI_OV_TIME,3,2) REALISASI_MULAI,  
            LEFT(REAL_SELESAI_OV_TIME,2) +':'+ SUBSTRING(REAL_SELESAI_OV_TIME,3,2) REALISASI_END, 
            CEK_DIR, CEK_GM, CEK_KADEP, ALASAN, 
                CAST(REPLACE(QUOTA_STD,',','.') AS DECIMAL(10,2)) AS QUOTA_STD, 
                CAST(REPLACE(QUOTAPLAN,',','.') AS DECIMAL(10,2)) AS QUOTAPLAN, 
                CAST(REPLACE(TERPAKAIPLAN,',','.') AS DECIMAL(10,2)) AS TERPAKAIPLAN, 
                CAST(REPLACE(SISAPLAN,',','.') AS DECIMAL(10,2)) AS SISAPLAN
            FROM TT_KRY_OVERTIME A 
                INNER JOIN TM_KRY K ON K.NPK = A.NPK
            LEFT JOIN TT_QUOTA_KRY B ON A.NPK = B.NPK
            WHERE NO_SEQUENCE = '$no_spkl' AND TAHUNBULAN = '$periode'")->result();
    }

    function get_data_group_overtime_by_no_spkl($no_spkl)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $periode = substr($no_spkl, 0, 6);

        return $aortadb->query(";WITH CTE (KD_SECTION, NAMA_PIC) AS (
            SELECT G.KD_SECTION, G.NAMA FROM (SELECT KD_SECTION, NAMA FROM TM_KRY K INNER JOIN TM_SECTION S ON S.KASIE_NPK = K.NPK) G
            )
            
            SELECT COUNT(NO_SEQUENCE) JUM_MP, NO_SEQUENCE, CHR_DESC_CAT, DATENAME(WEEKDAY, TGL_OVERTIME) HARI_OT, TGL_OVERTIME, REPLACE(KETERANGAN,'Hari','') KETERANGAN, 
                K.NAMA, K.NAMA AS NAMA_PIC, A.CEK_DIR, A.CEK_GM, A.CEK_KADEP,
                    RTRIM(A.KD_DEPT) +' / '+ RTRIM(A.KD_SECTION) +' / '+ RTRIM(A.KD_SUB_SECTION) AS DEPT,
                    CASE HARI_KJ WHEN 1 THEN 'Libur' ELSE '-' END AS HARI_KJ, ALASAN, SUM(CAST(REPLACE(TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN
                        FROM TT_KRY_OVERTIME A  
                        INNER JOIN TM_KRY K ON K.NPK = A.NPK_PIC
                        INNER JOIN TM_OT_CATEGORY OTC ON OTC.CHR_ID_CAT = A.KAT_OT
                        LEFT JOIN TM_HOLIDAY H ON H.TGL_LIBUR = TGL_OVERTIME
                        INNER JOIN TT_QUOTA_KRY B ON A.NPK = B.NPK
                       
                        WHERE NO_SEQUENCE = '$no_spkl' AND TAHUNBULAN = '$periode'
                        GROUP BY NO_SEQUENCE, CHR_DESC_CAT,TGL_OVERTIME, A.KD_DEPT, A.KD_SECTION, 
                        KETERANGAN, A.KD_SUB_SECTION, HARI_KJ, ALASAN, K.NAMA, A.CEK_DIR, A.CEK_GM, A.CEK_KADEP
            ")->row();
             // LEFT JOIn CTE C ON C.KD_SECTION = A.KD_SECTION
    }

    function get_temp_data_overtime_by_organization($dept, $section, $tanggal)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT NO_SEQUENCE, TGL_OVERTIME, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, 
                HARI_KJ, A.NPK, K.NAMA, NPK_PIC, RENC_MULAI_OV_TIME, RENC_SELESAI_OV_TIME, RENC_DURASI_OV_TIME ,
            REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME, REAL_DURASI_OV_TIME, CEK_DIR, CEK_GM,CEK_KADEP, ALASAN ,
                CAST(REPLACE(QUOTA_STD,',','.') AS DECIMAL(10,2)) AS QUOTA_STD, 
                CAST(REPLACE(QUOTAPLAN,',','.') AS DECIMAL(10,2)) AS QUOTAPLAN, 
                CAST(REPLACE(TERPAKAIPLAN,',','.') AS DECIMAL(10,2)) AS TERPAKAIPLAN, 
                CAST(REPLACE(SISAPLAN,',','.') AS DECIMAL(10,2)) AS SISAPLAN
            FROM TW_KRY_OVERTIME A 
                INNER JOIN TM_KRY K ON K.NPK = A.NPK
            LEFT JOIN TT_QUOTA_KRY B ON A.NPK = B.NPK
            WHERE A.KD_DEPT = '$dept' AND A.KD_SECTION = '$section' AND TGL_OVERTIME = '$tanggal' 
            ")->result();
    }

    function get_top_temp_data_overtime_by_no_spkl($no_spkl)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $periode = substr($no_spkl, 0, 6);

        return $aortadb->query("SELECT TOP 1 NO_SEQUENCE, KAT_OT,TGL_OVERTIME, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, HARI_KJ, A.NPK, K.NAMA, 
        NPK_PIC, ALASAN,
        RENC_MULAI_OV_TIME, 
        RENC_SELESAI_OV_TIME, 
        LEFT(RENC_MULAI_OV_TIME,2) JAM_MULAI, 
        SUBSTRING(RENC_MULAI_OV_TIME,3,2) MENIT_MULAI,
        LEFT(RENC_SELESAI_OV_TIME,2) JAM_SELESAI, 
        SUBSTRING(RENC_SELESAI_OV_TIME,3,2) MENIT_SELESAI,
        RENC_DURASI_OV_TIME ,
            REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME, REAL_DURASI_OV_TIME, CEK_DIR, CEK_GM,CEK_KADEP, ALASAN ,
                CAST(REPLACE(QUOTA_STD,',','.') AS DECIMAL(10,2)) AS QUOTA_STD, 
                CAST(REPLACE(QUOTAPLAN,',','.') AS DECIMAL(10,2)) AS QUOTAPLAN, 
                CAST(REPLACE(TERPAKAIPLAN,',','.') AS DECIMAL(10,2)) AS TERPAKAIPLAN, 
                CAST(REPLACE(SISAPLAN,',','.') AS DECIMAL(10,2)) AS SISAPLAN
            FROM TW_KRY_OVERTIME A 
                INNER JOIN TM_KRY K ON K.NPK = A.NPK
            LEFT JOIN TT_QUOTA_KRY B ON A.NPK = B.NPK
            WHERE NO_SEQUENCE = '$no_spkl' AND TAHUNBULAN = '$periode'
            ")->row();
    }

    function get_temp_data_overtime_by_section_and_tgl_and_spkl($tgl, $section, $no_spkl)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $period = substr($tgl, 0, 6);

        return $aortadb->query("SELECT NO_SEQUENCE, KAT_OT,TGL_OVERTIME, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, HARI_KJ, A.NPK, K.NAMA, 
        NPK_PIC, RENC_MULAI_OV_TIME, RENC_SELESAI_OV_TIME, 
        LEFT(RENC_MULAI_OV_TIME,2) JAM_MULAI, 
        SUBSTRING(RENC_MULAI_OV_TIME,3,2) MENIT_MULAI,
        LEFT(RENC_SELESAI_OV_TIME,2) JAM_SELESAI, 
        SUBSTRING(RENC_SELESAI_OV_TIME,3,2) MENIT_SELESAI,
        RENC_DURASI_OV_TIME ,
            REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME, REAL_DURASI_OV_TIME, CEK_DIR, CEK_GM,CEK_KADEP, ALASAN ,
                CAST(REPLACE(QUOTA_STD,',','.') AS DECIMAL(10,2)) AS QUOTA_STD, 
                CAST(REPLACE(QUOTAPLAN,',','.') AS DECIMAL(10,2)) AS QUOTAPLAN, 
                CAST(REPLACE(TERPAKAIPLAN,',','.') AS DECIMAL(10,2)) AS TERPAKAIPLAN, 
                CAST(REPLACE(SISAPLAN,',','.') AS DECIMAL(10,2)) AS SISAPLAN
            FROM TW_KRY_OVERTIME A 
                INNER JOIN TM_KRY K ON K.NPK = A.NPK
            LEFT JOIN TT_QUOTA_KRY B ON A.NPK = B.NPK
            WHERE NO_SEQUENCE = '$no_spkl' AND A.KD_SECTION = '$section' AND A.TGL_OVERTIME = '$tgl' 
            AND B.TAHUNBULAN = '$period' AND FLG_PRINT = 1")->result();
    }

    function get_top_temp_data_overtime_by_section_and_tgl($tgl, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $period = substr($tgl, 0, 6);

        $query = $aortadb->query("SELECT TOP 1 NO_SEQUENCE, KAT_OT,TGL_OVERTIME, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, HARI_KJ, A.NPK, K.NAMA, 
        NPK_PIC, RENC_MULAI_OV_TIME, RENC_SELESAI_OV_TIME, 
        LEFT(RENC_MULAI_OV_TIME,2) JAM_MULAI, 
        SUBSTRING(RENC_MULAI_OV_TIME,3,2) MENIT_MULAI,
        LEFT(RENC_SELESAI_OV_TIME,2) JAM_SELESAI, 
        SUBSTRING(RENC_SELESAI_OV_TIME,3,2) MENIT_SELESAI,
        RENC_DURASI_OV_TIME ,
            REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME, REAL_DURASI_OV_TIME, CEK_DIR, CEK_GM,CEK_KADEP, ALASAN ,
                CAST(REPLACE(QUOTA_STD,',','.') AS DECIMAL(10,2)) AS QUOTA_STD, 
                CAST(REPLACE(QUOTAPLAN,',','.') AS DECIMAL(10,2)) AS QUOTAPLAN, 
                CAST(REPLACE(TERPAKAIPLAN,',','.') AS DECIMAL(10,2)) AS TERPAKAIPLAN, 
                CAST(REPLACE(SISAPLAN,',','.') AS DECIMAL(10,2)) AS SISAPLAN
            FROM TW_KRY_OVERTIME A 
                INNER JOIN TM_KRY K ON K.NPK = A.NPK
            LEFT JOIN TT_QUOTA_KRY B ON A.NPK = B.NPK
            WHERE A.KD_SECTION = '$section' AND A.TGL_OVERTIME = '$tgl'  
            AND B.TAHUNBULAN = '$period'  AND FLG_PRINT = 1");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function update_overtime_by_id($data, $id)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->where('NO_SEQUENCE', $id);
        $aortadb->update($this->tabel, $data);
    }

    //what the
    function generate_id_overtime()
    {
        return $this->db->query('SELECT max(INT_ID_DEPT) as a from TM_DEPT')->row()->a + 1;
    }

    function get_overtime_from_sect($sect)
    {
        return $this->db->query('SELECT INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC from TM_DEPT')->row();
    }

    function get_overtime_id($sect)
    {
        return $this->db->query("SELECT a.INT_ID_DEPT from TM_DEPT a, TM_SECTION b 
                                where a.INT_ID_DEPT=b.INT_ID_DEPT and b.INT_ID_SECTION=$sect")->row();
    }

    function get_all_prod_overtime()
    {
        $query = $this->db->query("SELECT INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC from TM_DEPT WHERE INT_ID_DEPT IN (21,22,23,24)")->result();
        return $query;
    }

    function get_all_overtime()
    {
        $query = $this->db->query("SELECT INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC from TM_DEPT where CHR_DEPT <> ''")->result();
        return $query;
    }

    function get_all_overtime_plant()
    {
        $query = $this->db->query("SELECT INT_ID_DEPT, CHR_DEPT, CHR_DEPT_DESC from TM_DEPT where CHR_DEPT is not null and INT_ID_GROUP_DEPT IN (SELECT INT_ID_GROUP_DEPT from TM_GROUP_DEPT where INT_ID_DIVISION = '3')")->result();
        return $query;
    }

    function get_sub_section_overtime($section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT RTRIM(KODE) KODE, RTRIM(NAMA_SUBSECT) NAMA_SUBSECT, RTRIM(KASUBS_NPK) KASUBS_NPK,
        RTRIM(KODE_SEC) KODE_SEC FROM TM_SUBSECTION WHERE KODE_SEC = '$section'")->result();
        return $query;
    }

    function get_top_sub_section_overtime($section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 RTRIM(KODE) KODE, RTRIM(NAMA_SUBSECT) NAMA_SUBSECT, RTRIM(KASUBS_NPK) KASUBS_NPK,
        RTRIM(KODE_SEC) KODE_SEC FROM TM_SUBSECTION WHERE KODE_SEC = '$section'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_section_overtime($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT RTRIM(KODE) KODE, RTRIM(NAMA_SECTION) NAMA_SECTION, RTRIM(KASIE_NPK) KASIE_NPK, RTRIM(KODE_DEP) KODE_DEP FROM TM_SECTION WHERE KODE_DEP = '$dept'")->result();
        return $query;
    }

    function get_section_by_dept($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT RTRIM(KODE) KODE FROM TM_SECTION WHERE KODE_DEP = '$dept' AND FLG_DELETE = 0 ")->result();
        return $query;
    }
    
    function get_all_section_drop($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT RTRIM(KODE) KODE, RTRIM(NAMA_SECTION) NAMA_SECTION FROM TM_SECTION WHERE KODE_DEP = '$dept' AND FLG_DELETE <> 1
        UNION SELECT 'ALL', 'ALL'")->result();
        return $query;
    }

    function get_top_section_overtime($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT TOP 1 RTRIM(KODE) KODE, RTRIM(NAMA_SECTION) NAMA_SECTION, RTRIM(KASIE_NPK) KASIE_NPK,
            RTRIM(KODE_DEP) KODE_DEP FROM TM_SECTION WHERE KODE_DEP = '$dept'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_top_section_overtime_by_mgr($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT TOP 1 RTRIM(KODE) KODE, RTRIM(NAMA_SECTION) NAMA_SECTION, RTRIM(KASIE_NPK) KASIE_NPK,
            RTRIM(KODE_DEP) KODE_DEP FROM TM_SECTION WHERE KODE_DEP = '$dept'");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_dept_overtime()
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT RTRIM(KODE) KODE, RTRIM(NAMA_DEP) NAMA_DEP, RTRIM(KADEP_NPK) KADEP_NPK,
                    RTRIM(KD_GROUP) KD_GROUP, KD_DIV, MIN_BACKDATE, OT_CATEGORY, SEQ FROM TM_DEP WHERE FLG_DEL = 0")->result();
        return $query;
    }

    function get_top_dept_overtime()
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 RTRIM(KODE) KODE, RTRIM(NAMA_DEP) NAMA_DEP, RTRIM(KADEP_NPK) KADEP_NPK,
        RTRIM(KD_GROUP) KD_GROUP, KD_DIV, MIN_BACKDATE, OT_CATEGORY, SEQ FROM TM_DEP WHERE FLG_DEL = 0");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_data_employee($dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if ($section == 'ALL') {
            $data = $aortadb->query("SELECT NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE, OPER_ENTRY, SALARY, POSITION
            FROM TM_KRY WHERE (KD_DEPT = '$dept') AND (FLAG_DELETE = '0')
            ORDER BY KD_SECTION, KD_SUB_SECTION, NPK")->result();
        } else {
            $data = $aortadb->query("SELECT NPK, NAMA, KD_GROUP, KD_DEPT, KD_SECTION, KD_SUB_SECTION, FLAG_DELETE, OPER_ENTRY, SALARY, POSITION
            FROM TM_KRY WHERE (KD_DEPT = '$dept') AND (FLAG_DELETE = '0') AND (KD_SECTION = '$section') 
            ORDER BY KD_SECTION, KD_SUB_SECTION, NPK")->result();
        }

        return $data;
    }

    function get_dept_overtime_by_dept($kode_dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT RTRIM(KODE) KODE FROM TM_DEP WHERE KODE = '$kode_dept'")->result();

        return $query;
    }

    function get_dept_overtime_by_gm($kode_group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT RTRIM(KODE) KODE FROM TM_DEP WHERE KD_GROUP = '$kode_group' AND FLG_DEL = 0")->result();
        return $query;
    }

    function get_dept_overtime_by_gm_for_mgr($kode_group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT RTRIM(KODE) KODE FROM TM_DEP WHERE KD_GROUP = '$kode_group' AND FLG_DEL = 0")->result();
        return $query;
    }

    function get_top_dept_overtime_by_gm($kode_group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 RTRIM(KODE) KODE FROM TM_DEP WHERE KD_GROUP = '$kode_group' AND FLG_DEL = 0");

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return 0;
        }
    }

    function get_top_pic_overtime($section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 S.KODE, N.NPK, N.NAMA, S.KODE_DEP FROM TM_SECTION S INNER JOIN TM_KRY N ON N.NPK = S.KASIE_NPK WHERE S.KODE = '$section'  ")->row();
        return $query->NPK;
    }

    function get_pic_overtime($section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT S.KODE, N.NPK, N.NAMA, S.KODE_DEP FROM TM_SECTION S INNER JOIN TM_KRY N ON N.NPK = S.KASIE_NPK WHERE S.KODE = '$section'  ")->result();
        return $query;
    }

    function get_employee_overtime($section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT NPK, NAMA FROM TM_KRY WHERE KD_SECTION = '$section' AND FLAG_DELETE = 0 AND position IS NOT NULL")->result();
        return $query;
    }

    function get_employee_by_dept($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT NPK, NAMA FROM TM_KRY WHERE KD_DEPT = '$dept' AND FLAG_DELETE = 0 AND position IS NOT NULL")->result();
        return $query;
    }

    function get_top_employee_by_dept($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 NPK, NAMA FROM TM_KRY WHERE KD_DEPT = '$dept' AND FLAG_DELETE = 0 AND position IS NOT NULL")->row();
        return $query;
    }

    function get_employee_by_section($dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT NPK, NAMA FROM TM_KRY WHERE KD_DEPT = '$dept' AND KD_SECTION = '$section' FLAG_DELETE = 0 AND position IS NOT NULL")->result();
        return $query;
    }

    function get_backdate_overtime($tgl, $kode_dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT CONVERT([varchar](10),DATEADD(DAY, DATEDIFF(DAY, 0, GETDATE()), CAST(MIN_BACKDATE AS INT)),(112)) MIN_BACKDATE, MIN_BACKDATE AS INT_BACKDATE FROM TM_DEP WHERE KODE= '$kode_dept' AND FLG_DEL = 0")->row();

        if ($query->MIN_BACKDATE < $tgl) {
            return $query->MIN_BACKDATE;
        } else {
            return 0;
        }
    }

    function get_top_category()
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 CHR_ID_CAT, UPPER(CHR_DESC_CAT) CHR_DESC_CAT FROM TM_OT_CATEGORY")->row();
        return $query->CHR_ID_CAT;
    }

    function get_category()
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT CHR_ID_CAT, UPPER(CHR_DESC_CAT) CHR_DESC_CAT FROM TM_OT_CATEGORY")->result();
        return $query;
    }

    function get_detail_user_by_npk($npk)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("SELECT TOP 1 * FROM TM_KRY WHERE NPK = '$npk'");
        return $query;
    }

    //===================== UPDATE 13/11/2017 --- ANU ========================//
    function get_dept_name($id)
    {
        $overtime = $this->db->query("SELECT CHR_DEPT from TM_DEPT where INT_ID_DEPT = '" . $id . "' ")->row();

        return $overtime;
    }

    function get_group_dept($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $group = $aortadb->query("SELECT RTRIM(KD_GROUP) KD_GROUP from TM_DEP where KODE = '" . $dept . "' ")->row();

        return $group;
    }

    function get_detail_ot($year, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("SELECT TAHUNBULAN, 
                                            sum(cast(replace(QUOTA_STD,',','.') as float)) as QUOTA_STD, 
                                            sum(cast(replace(QUOTAPLAN,',','.') as decimal(10,2))) as QUOTA_PLAN,
                                            sum(cast(replace(TERPAKAIPLAN,',','.') as decimal(10,2))) as TERPAKAI_PLAN,
                                            sum(cast(replace(SISAPLAN,',','.') as decimal(10,2))) as SISA_PLAN
                                    from TT_QUOTA_KRY
                                    where NPK in (SELECT NPK from TM_KRY where KD_DEPT = '$dept') and TAHUNBULAN like '$year%'
                                    group by TAHUNBULAN")->result();
        return $detail_ot;
    }

    function get_budget_quota_by_dept_and_period($periode, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT INT_BUDGET_QUOTA FROM TM_STD_BUDGET_QUOTA WHERE CHR_DEPT = '$dept' AND CHR_PERIOD = '$periode'");

        if ($query->num_rows() > 0) {
            return $query->row()->INT_BUDGET_QUOTA;
        } else {
            return 0;
        }
    }

    //========================== DETAIL QUOTA DEPT ===========================//
    function get_detail_quota_section_by_periode($periode, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $detail_ot = $aortadb->query("SELECT B.KD_SECTION, 
                    COUNT(A.NPK) AS KRY,
                    --(CAST(datediff(day, '20170301', dateadd(month, 1, '20170301')) AS INT)-CAST(SUBSTRING((CONVERT([char](10),getdate(),(112))),7,2) AS INT)) AS SISA_HARI,
                    ---- QUOTA PRD
                    SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                    SUM(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN,
                    SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                    SUM(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                    ---- QUOTA IMP
                    SUM(CAST(REPLACE(A.QUOTAPLAN1,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN1,
                    SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN1,
                    SUM(CAST(REPLACE(A.SISAPLAN1,',','.') AS DECIMAL(10,2))) AS SISAPLAN1,
                    ---- AVG QUOTA PRD
                    AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                    AVG(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA,
                    AVG(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA,
                    ---- AVG QUOTA IMP
                    AVG(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT1,
                    AVG(CAST(REPLACE(A.QUOTAPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA1,
                    AVG(CAST(REPLACE(A.SISAPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA1                    
            FROM TT_QUOTA_KRY A
            LEFT JOIN TM_KRY B ON A.NPK = B.NPK
            WHERE B.KD_DEPT = '$dept'
            AND A.TAHUNBULAN LIKE '$periode%'
            GROUP BY B.KD_SECTION")->result();
        return $detail_ot;
    }

    function get_detail_quota_section_by_periode_mgr($periode, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $detail_ot = $aortadb->query("SELECT B.KD_SECTION, 
                                COUNT(A.NPK) AS KRY,
                                SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                                ---- QUOTA PRD BASED ON APPROVAL                 
                                SUM(ISNULL(C.QUANTITY_QUOTA_PR,0)) AS QUOTAPLAN,
                                SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                                SUM(ISNULL(C.QUANTITY_QUOTA_PR,0)) - SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                                ---- QUOTA IMP BASED ON APPROVAL
                                SUM(ISNULL(C.QUANTITY_QUOTA_IM,0)) AS QUOTAPLAN1,
                                SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN1,
                                SUM(ISNULL(C.QUANTITY_QUOTA_IM,0)) - SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS SISAPLAN1,
                                ---- AVG QUOTA PRD BASED ON APPROVAL
                                AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                                AVG(ISNULL(C.QUANTITY_QUOTA_PR,0))/22 AS AVG_QUOTA,
                                AVG(ISNULL(C.QUANTITY_QUOTA_PR,0) - CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA,
                                ---- AVG QUOTA IMP BASED ON APPROVAL
                                AVG(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT1,
                                AVG(ISNULL(C.QUANTITY_QUOTA_IM,0))/22 AS AVG_QUOTA1,
                                AVG(ISNULL(C.QUANTITY_QUOTA_IM,0) - CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA1
                        FROM TT_QUOTA_KRY A
                        LEFT JOIN TM_KRY B ON A.NPK = B.NPK
                        LEFT JOIN (
                            SELECT TAHUNBULAN, NPK, 
                                SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUANTITY_QUOTA_PR, 
                                SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUANTITY_QUOTA_IM
                            FROM TT_QUOTA_HIS
                            WHERE TAHUNBULAN = '$periode' 
                                AND KADEP_APPROVE = '1'
                            GROUP BY TAHUNBULAN, NPK
                            ) C ON A.NPK = C.NPK AND A.TAHUNBULAN = C.TAHUNBULAN COLLATE DATABASE_DEFAULT
                        WHERE B.KD_DEPT = '$dept'
                        AND A.TAHUNBULAN = '$periode'
                        GROUP BY B.KD_SECTION")->result();
        return $detail_ot;
    }

    //========================== DETAIL QUOTA GROUP ==========================//
    function get_detail_quota_section_by_periode_gm($periode, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $detail_ot = $aortadb->query("SELECT B.KD_SECTION, 
                                COUNT(A.NPK) AS KRY,
                                SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                                ---- QUOTA PRD BASED ON APPROVAL                 
                                SUM(ISNULL(C.QUANTITY_QUOTA_PR,0)) AS QUOTAPLAN,
                                SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                                SUM(ISNULL(C.QUANTITY_QUOTA_PR,0)) - SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                                ---- QUOTA IMP BASED ON APPROVAL
                                SUM(ISNULL(C.QUANTITY_QUOTA_IM,0)) AS QUOTAPLAN1,
                                SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN1,
                                SUM(ISNULL(C.QUANTITY_QUOTA_IM,0)) - SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS SISAPLAN1,
                                ---- AVG QUOTA PRD BASED ON APPROVAL
                                AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                                AVG(ISNULL(C.QUANTITY_QUOTA_PR,0))/22 AS AVG_QUOTA,
                                AVG(ISNULL(C.QUANTITY_QUOTA_PR,0) - CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA,
                                ---- AVG QUOTA IMP BASED ON APPROVAL
                                AVG(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT1,
                                AVG(ISNULL(C.QUANTITY_QUOTA_IM,0))/22 AS AVG_QUOTA1,
                                AVG(ISNULL(C.QUANTITY_QUOTA_IM,0) - CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA1
                        FROM TT_QUOTA_KRY A
                        LEFT JOIN TM_KRY B ON A.NPK = B.NPK
                        LEFT JOIN (
                            SELECT TAHUNBULAN, NPK, 
                                SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUANTITY_QUOTA_PR, 
                                SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUANTITY_QUOTA_IM
                            FROM TT_QUOTA_HIS
                            WHERE TAHUNBULAN = '$periode' 
                                AND GM_APPROVE = '1'
                            GROUP BY TAHUNBULAN, NPK
                            ) C ON A.NPK = C.NPK AND A.TAHUNBULAN = C.TAHUNBULAN COLLATE DATABASE_DEFAULT
                        WHERE B.KD_DEPT = '$dept'
                        AND A.TAHUNBULAN = '$periode'
                        GROUP BY B.KD_SECTION")->result();
        return $detail_ot;
    }

    function get_detail_quota_group_by_periode($periode, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("DECLARE
        @budget_quota INT
        
        SELECT @budget_quota = SUM(INT_BUDGET_QUOTA) FROM TM_STD_BUDGET_QUOTA WHERE CHR_PERIOD = '$periode' AND CHR_GROUP = '$group' 
        
        SELECT '$group' AS KD_GROUP, 
                            COUNT(A.NPK) AS KRY,
                            SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                            SUM(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN,
                            SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                            CAST(REPLACE(@budget_quota,',','.') AS DECIMAL(10,2)) AS INT_BUDGET_QUOTA,
                            SUM(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                            AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                            AVG(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA,
                            AVG(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA
                    FROM TT_QUOTA_KRY A 
                    LEFT JOIN TM_KRY B ON A.NPK = B.NPK
                    WHERE B.KD_DEPT IN (SELECT KODE FROM TM_DEP WHERE KD_GROUP = '$group'  AND FLG_DEL = 0)
                    AND LEFT(A.TAHUNBULAN,6) = '$periode'")->row();

        return $detail_ot;
    }

    function get_detail_quota_group_by_periode_gm($periode, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("DECLARE
        @budget_quota INT
        
        SELECT @budget_quota = SUM(INT_BUDGET_QUOTA) FROM TM_STD_BUDGET_QUOTA WHERE CHR_PERIOD = '$periode' AND CHR_GROUP = '$group' 
        
        SELECT '$group' AS KD_GROUP, 
                        COUNT(A.NPK) AS KRY,
                        SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                        CAST(REPLACE(@budget_quota,',','.') AS DECIMAL(10,2)) AS INT_BUDGET_QUOTA,
                        ---- QUOTA PRD BASED ON APPROVAL                 
                        SUM(ISNULL(C.QUANTITY_QUOTA_PR,0)) AS QUOTAPLAN,
                        SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                        SUM(ISNULL(C.QUANTITY_QUOTA_PR,0)) - SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                        ---- QUOTA IMP BASED ON APPROVAL
                        SUM(ISNULL(C.QUANTITY_QUOTA_IM,0)) AS QUOTAPLAN1,
                        SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN1,
                        SUM(ISNULL(C.QUANTITY_QUOTA_IM,0)) - SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS SISAPLAN1,
                        ---- AVG QUOTA PRD BASED ON APPROVAL
                        AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                        AVG(ISNULL(C.QUANTITY_QUOTA_PR,0))/22 AS AVG_QUOTA,
                        AVG(ISNULL(C.QUANTITY_QUOTA_PR,0) - CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA,
                        ---- AVG QUOTA IMP BASED ON APPROVAL
                        AVG(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT1,
                        AVG(ISNULL(C.QUANTITY_QUOTA_IM,0))/22 AS AVG_QUOTA1,
                        AVG(ISNULL(C.QUANTITY_QUOTA_IM,0) - CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA1
                    FROM TT_QUOTA_KRY A 
                    LEFT JOIN TM_KRY B ON A.NPK = B.NPK
                    LEFT JOIN (
						SELECT TAHUNBULAN, NPK, 
							SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUANTITY_QUOTA_PR, 
							SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUANTITY_QUOTA_IM
						FROM TT_QUOTA_HIS
						WHERE TAHUNBULAN = '$periode' 
							AND GM_APPROVE = '1'
						GROUP BY TAHUNBULAN, NPK
						) C ON A.NPK = C.NPK AND A.TAHUNBULAN = C.TAHUNBULAN COLLATE DATABASE_DEFAULT
                    WHERE B.KD_DEPT IN (SELECT KODE FROM TM_DEP WHERE KD_GROUP = '$group'  AND FLG_DEL = 0)
                    AND LEFT(A.TAHUNBULAN,6) = '$periode'")->row();

        return $detail_ot;
    }

    function get_detail_quota_group_per_dept_by_periode($periode, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $detail_ot = $aortadb->query("SELECT '$group' AS KD_GROUP, 
                            KD_DEPT,
                            COUNT(A.NPK) AS KRY,
                            SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                            SUM(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN,
                            SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                            INT_BUDGET_QUOTA,
                            SUM(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                            AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                            AVG(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA,
                            AVG(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA
                    FROM TT_QUOTA_KRY A 
                    LEFT JOIN TM_KRY B ON A.NPK = B.NPK
                    LEFT JOIN (SELECT * FROM TM_STD_BUDGET_QUOTA WHERE CHR_PERIOD = '$periode') C ON B.KD_DEPT COLLATE DATABASE_DEFAULT = C.CHR_DEPT 
                    WHERE B.KD_DEPT IN (SELECT KODE FROM TM_DEP WHERE KD_GROUP = '$group'  AND FLG_DEL = 0)
                    AND LEFT(A.TAHUNBULAN,6) = '$periode'
                    GROUP BY KD_DEPT, INT_BUDGET_QUOTA")->result();

        return $detail_ot;
    }

    function get_detail_quota_group_per_dept_by_periode_gm($periode, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $detail_ot = $aortadb->query("SELECT '$group' AS KD_GROUP, 
                            KD_DEPT,
                            COUNT(A.NPK) AS KRY,
                            SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                            CAST(REPLACE(INT_BUDGET_QUOTA,',','.') AS DECIMAL(10,2)) AS INT_BUDGET_QUOTA,
                            ---- QUOTA PRD BASED ON APPROVAL                 
                            SUM(ISNULL(D.QUANTITY_QUOTA_PR,0)) AS QUOTAPLAN,
                            SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                            SUM(ISNULL(D.QUANTITY_QUOTA_PR,0)) - SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                            ---- QUOTA IMP BASED ON APPROVAL
                            SUM(ISNULL(D.QUANTITY_QUOTA_IM,0)) AS QUOTAPLAN1,
                            SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN1,
                            SUM(ISNULL(D.QUANTITY_QUOTA_IM,0)) - SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS SISAPLAN1,
                            ---- AVG QUOTA PRD BASED ON APPROVAL
                            AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                            AVG(ISNULL(D.QUANTITY_QUOTA_PR,0))/22 AS AVG_QUOTA,
                            AVG(ISNULL(D.QUANTITY_QUOTA_PR,0) - CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA,
                            ---- AVG QUOTA IMP BASED ON APPROVAL
                            AVG(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT1,
                            AVG(ISNULL(D.QUANTITY_QUOTA_IM,0))/22 AS AVG_QUOTA1,
                            AVG(ISNULL(D.QUANTITY_QUOTA_IM,0) - CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA1
                    FROM TT_QUOTA_KRY A 
                    LEFT JOIN TM_KRY B ON A.NPK = B.NPK
                    LEFT JOIN (SELECT * FROM TM_STD_BUDGET_QUOTA WHERE CHR_PERIOD = '$periode') C ON B.KD_DEPT COLLATE DATABASE_DEFAULT = C.CHR_DEPT 
                    LEFT JOIN (
                        SELECT TAHUNBULAN, NPK, 
                            SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUANTITY_QUOTA_PR, 
                            SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUANTITY_QUOTA_IM
                        FROM TT_QUOTA_HIS
                        WHERE TAHUNBULAN = '$periode' 
                            AND GM_APPROVE = '1'
                        GROUP BY TAHUNBULAN, NPK
                        ) D ON A.NPK = D.NPK AND A.TAHUNBULAN = D.TAHUNBULAN COLLATE DATABASE_DEFAULT
                    WHERE B.KD_DEPT IN (SELECT KODE FROM TM_DEP WHERE KD_GROUP = '$group'  AND FLG_DEL = 0)
                    AND LEFT(A.TAHUNBULAN,6) = '$periode'
                    GROUP BY KD_DEPT, INT_BUDGET_QUOTA")->result();

        return $detail_ot;
    }

    //========================== DETAIL QUOTA PLANT ==========================//
    function get_detail_quota_plant_by_periode($periode)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("SELECT 'PLANT' AS PLANT, 
                    COUNT(A.NPK) AS KRY,                    
                    SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                    SUM(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN,
                    SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                    SUM(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                    AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                    AVG(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA,
                    AVG(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA
            FROM TT_QUOTA_KRY A
            LEFT JOIN TM_KRY B ON A.NPK = B.NPK
            WHERE B.KD_DEPT IN (SELECT KODE FROM TM_DEP WHERE KD_DIV = 'PLNT'  AND FLG_DEL = 0)
            AND A.TAHUNBULAN LIKE '$periode%'")->row();
        return $detail_ot;
    }

    function get_detail_quota_plant_by_periode_by_dir($periode)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("DECLARE
        @budget_quota INT
        
        SELECT @budget_quota = SUM(INT_BUDGET_QUOTA) FROM TM_STD_BUDGET_QUOTA WHERE CHR_PERIOD = '$periode' 
        
        SELECT 'PLANT' AS PLANT, 
                            COUNT(A.NPK) AS KRY,
                            SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                            CAST(REPLACE(@budget_quota,',','.') AS DECIMAL(10,2)) AS INT_BUDGET_QUOTA,
                            ---- QUOTA PRD
                            SUM(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN,
                            SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,
                            SUM(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                            ---- QUOTA IMP
                            SUM(CAST(REPLACE(A.QUOTAPLAN1,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN1,
                            SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN1,
                            SUM(CAST(REPLACE(A.SISAPLAN1,',','.') AS DECIMAL(10,2))) AS SISAPLAN1,
                            ---- AVG QUOTA PRD
                            AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                            AVG(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA,
                            AVG(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA,
                            ---- AVG QUOTA IMP
                            AVG(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT1,
                            AVG(CAST(REPLACE(A.QUOTAPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA1,
                            AVG(CAST(REPLACE(A.SISAPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA1
                    FROM TT_QUOTA_KRY A 
                    LEFT JOIN TM_KRY B ON A.NPK = B.NPK
                    WHERE B.KD_DEPT IN (SELECT KODE FROM TM_DEP WHERE KD_DIV = 'PLNT'  AND FLG_DEL = 0)
                    AND LEFT(A.TAHUNBULAN,6) = '$periode'")->row();

        return $detail_ot;
    }

    function get_detail_quota_plant_per_dept_by_periode_by_dir($periode)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $detail_ot = $aortadb->query("SELECT 'PLANT' AS PLANT, 
                            KD_DEPT,
                            COUNT(A.NPK) AS KRY,
                            CAST(REPLACE(INT_BUDGET_QUOTA,',','.') AS DECIMAL(10,2)) AS INT_BUDGET_QUOTA,
                            SUM(CAST(REPLACE(A.QUOTA_STD,',','.') AS DECIMAL(10,2))) AS QUOTA_STD,
                            ---- QUOTA PRD
                            SUM(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN,
                            SUM(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN,                            
                            SUM(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2))) AS SISAPLAN,
                            AVG(CAST(REPLACE(A.TERPAKAIPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT,
                            AVG(CAST(REPLACE(A.QUOTAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA,
                            AVG(CAST(REPLACE(A.SISAPLAN,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA,
                            ---- QUOTA IMP
                            SUM(CAST(REPLACE(A.QUOTAPLAN1,',','.') AS DECIMAL(10,2))) AS QUOTAPLAN1,
                            SUM(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2))) AS TERPAKAIPLAN1,                            
                            SUM(CAST(REPLACE(A.SISAPLAN1,',','.') AS DECIMAL(10,2))) AS SISAPLAN1,
                            AVG(CAST(REPLACE(A.TERPAKAIPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_OT1,
                            AVG(CAST(REPLACE(A.QUOTAPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_QUOTA1,
                            AVG(CAST(REPLACE(A.SISAPLAN1,',','.') AS DECIMAL(10,2)))/22 AS AVG_SISA1
                    FROM TT_QUOTA_KRY A 
                    LEFT JOIN TM_KRY B ON A.NPK = B.NPK
                    LEFT JOIN (SELECT * FROM TM_STD_BUDGET_QUOTA WHERE CHR_PERIOD = '$periode') C ON B.KD_DEPT COLLATE DATABASE_DEFAULT = C.CHR_DEPT 
                    WHERE B.KD_DEPT IN (SELECT KODE FROM TM_DEP WHERE KD_DIV = 'PLNT'  AND FLG_DEL = 0)
                    AND LEFT(A.TAHUNBULAN,6) = '$periode'
                    GROUP BY KD_DEPT, INT_BUDGET_QUOTA")->result();

        return $detail_ot;
    }

    function get_detail_quota_std($year, $year_end, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_std_dept '$year', '$year_end', '$dept'")->row();

        return $detail_ot;
    }

    function get_detail_quota_plan($year, $year_end, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_plan_dept '$year', '$year_end', '$dept'")->row();
        return $detail_ot;
    }

    function get_detail_quota_plan_mgr($year, $year_end, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_plan_dept_mgr '$year', '$year_end', '$dept'")->row();
        return $detail_ot;
    }

    function get_detail_quota_used($year, $year_end, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_used_dept '$year', '$year_end', '$dept'")->row();
        return $detail_ot;
    }

    function get_detail_quota_saldo($year, $year_end, $dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_saldo_dept '$year', '$year_end', '$dept'")->row();
        return $detail_ot;
    }

    function get_detail_quota_budget_mgr($period, $dept)
    {
        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$period' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$period' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query(";WITH MAIN_DATA_CTE (CHR_DATE, RIL ) AS (
            SELECT 'DATA_'+CAST(SUBSTRING(CHR_PERIOD,5,2) AS VARCHAR(6)) AS CHR_PERIOD, 
            INT_BUDGET_QUOTA
            FROM TM_STD_BUDGET_QUOTA 
            WHERE CHR_DEPT = '$dept'
            AND LEFT(CHR_PERIOD,6) >= '$period_start'
            AND LEFT(CHR_PERIOD,6) <= '$period_end'
        ), PIVOT_CTE (DATA_01,DATA_02,DATA_03,DATA_04,DATA_05,DATA_06,DATA_07,DATA_08,DATA_09,DATA_10,DATA_11,DATA_12) AS (
        SELECT * FROM MAIN_DATA_CTE
        PIVOT (
           SUM(RIL)                                                
           FOR CHR_DATE IN (DATA_01,DATA_02,DATA_03,DATA_04,DATA_05,DATA_06,DATA_07,DATA_08,DATA_09,DATA_10,DATA_11,DATA_12)
           )        
           AS RIL
         )
         SELECT ISNULL(DATA_01,0) DATA_01,ISNULL(DATA_02,0) DATA_02,ISNULL(DATA_03,0) DATA_03,ISNULL(DATA_04,0) DATA_04,ISNULL(DATA_05,0) DATA_05,
             ISNULL(DATA_06,0) DATA_06,ISNULL(DATA_07,0) DATA_07,ISNULL(DATA_08,0) DATA_08,ISNULL(DATA_09,0) DATA_09,ISNULL(DATA_10,0) DATA_10,
             ISNULL(DATA_11,0) DATA_11,ISNULL(DATA_12,0) DATA_12
         FROM PIVOT_CTE")->row();
        return $detail_ot;
    }

    //========================== DETAIL QUOTA GROUP ==========================//
    function get_detail_quota_std_gm($year, $year_end, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_std_gm '$year', '$year_end', '$group'")->row();
        return $detail_ot;
    }

    function get_detail_quota_plan_gm($year, $year_end, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_plan_gm '$year', '$year_end', '$group'")->row();
        return $detail_ot;
    }

    function get_detail_quota_plan_gm_v2($year, $year_end, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_plan_gm_v2 '$year', '$year_end', '$group'")->row();
        return $detail_ot;
    }

    function get_detail_quota_used_gm($year, $year_end, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_used_gm '$year', '$year_end', '$group'")->row();
        return $detail_ot;
    }

    function get_detail_quota_saldo_gm($year, $year_end, $group)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_saldo_gm '$year', '$year_end', '$group'")->row();
        return $detail_ot;
    }

    function get_detail_quota_budget_gm($period, $group)
    {
        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$period' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$period' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query(";WITH MAIN_DATA_CTE (CHR_DATE, RIL ) AS (
            SELECT 'DATA_'+CAST(SUBSTRING(CHR_PERIOD,5,2) AS VARCHAR(6)) AS CHR_PERIOD, 
            INT_BUDGET_QUOTA
            FROM TM_STD_BUDGET_QUOTA 
            WHERE CHR_GROUP = '$group'
            AND LEFT(CHR_PERIOD,6) >= '$period_start'
            AND LEFT(CHR_PERIOD,6) <= '$period_end'
        ), PIVOT_CTE (DATA_01,DATA_02,DATA_03,DATA_04,DATA_05,DATA_06,DATA_07,DATA_08,DATA_09,DATA_10,DATA_11,DATA_12) AS (
        SELECT * FROM MAIN_DATA_CTE
        PIVOT (
           SUM(RIL)                                                
           FOR CHR_DATE IN (DATA_01,DATA_02,DATA_03,DATA_04,DATA_05,DATA_06,DATA_07,DATA_08,DATA_09,DATA_10,DATA_11,DATA_12)
           )        
           AS RIL
         )
         SELECT ISNULL(DATA_01,0) DATA_01,ISNULL(DATA_02,0) DATA_02,ISNULL(DATA_03,0) DATA_03,ISNULL(DATA_04,0) DATA_04,ISNULL(DATA_05,0) DATA_05,
             ISNULL(DATA_06,0) DATA_06,ISNULL(DATA_07,0) DATA_07,ISNULL(DATA_08,0) DATA_08,ISNULL(DATA_09,0) DATA_09,ISNULL(DATA_10,0) DATA_10,
             ISNULL(DATA_11,0) DATA_11,ISNULL(DATA_12,0) DATA_12
         FROM PIVOT_CTE")->row();
        return $detail_ot;
    }

    //========================== DETAIL QUOTA DIVISI ==========================//
    function get_detail_quota_std_dir($year, $year_end, $div)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_std_dir '$year', '$year_end', '$div'")->row();
        return $detail_ot;
    }

    function get_detail_quota_plan_dir($year, $year_end, $div)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_plan_dir '$year', '$year_end', '$div'")->row();
        return $detail_ot;
    }

    function get_detail_quota_used_dir($year, $year_end, $div)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_used_dir '$year', '$year_end', '$div'")->row();
        return $detail_ot;
    }

    function get_detail_quota_saldo_dir($year, $year_end, $div)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query("EXEC zsp_get_detail_quota_saldo_dir '$year', '$year_end', '$div'")->row();
        return $detail_ot;
    }

    function get_detail_quota_budget_dir($period, $div)
    {
        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$period' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$period' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $aortadb = $this->load->database("aorta", TRUE);
        $detail_ot = $aortadb->query(";WITH MAIN_DATA_CTE (CHR_DATE, RIL ) AS (
            SELECT 'DATA_'+CAST(SUBSTRING(CHR_PERIOD,5,2) AS VARCHAR(6)) AS CHR_PERIOD, 
            INT_BUDGET_QUOTA
            FROM TM_STD_BUDGET_QUOTA 
            WHERE CHR_DIV = '$div'
            AND LEFT(CHR_PERIOD,6) >= '$period_start'
            AND LEFT(CHR_PERIOD,6) <= '$period_end'
        ), PIVOT_CTE (DATA_01,DATA_02,DATA_03,DATA_04,DATA_05,DATA_06,DATA_07,DATA_08,DATA_09,DATA_10,DATA_11,DATA_12) AS (
        SELECT * FROM MAIN_DATA_CTE
        PIVOT (
           SUM(RIL)                                                
           FOR CHR_DATE IN (DATA_01,DATA_02,DATA_03,DATA_04,DATA_05,DATA_06,DATA_07,DATA_08,DATA_09,DATA_10,DATA_11,DATA_12)
           )        
           AS RIL
         )
         SELECT ISNULL(DATA_01,0) DATA_01,ISNULL(DATA_02,0) DATA_02,ISNULL(DATA_03,0) DATA_03,ISNULL(DATA_04,0) DATA_04,ISNULL(DATA_05,0) DATA_05,
             ISNULL(DATA_06,0) DATA_06,ISNULL(DATA_07,0) DATA_07,ISNULL(DATA_08,0) DATA_08,ISNULL(DATA_09,0) DATA_09,ISNULL(DATA_10,0) DATA_10,
             ISNULL(DATA_11,0) DATA_11,ISNULL(DATA_12,0) DATA_12
         FROM PIVOT_CTE")->row();
        return $detail_ot;
    }

    public function get_data_plan_actual($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $stored_procedure = "EXEC dbo.zsp_get_plan_vs_actual_by_dept ?, ?, ?";
        $param = array(
            'period' => $period,
            'dept ' => $dept,
            'section ' => $section,
        );

        $query = $aortadb->query($stored_procedure, $param)->result();

        return $query;
    }

    public function getHeaderOvertimebyId($no_sequence){
        $aortadb = $this->load->database("aorta", TRUE);

        $data =  $aortadb->query("SELECT TOP 1 NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, KD_SECTION FROM TT_KRY_OVERTIME WHERE NO_SEQUENCE = '$no_sequence' GROUP BY  NO_SEQUENCE, TGL_OVERTIME, KD_DEPT, KD_SECTION");
    
        return $data->row();
    }

    public function getTempOvertimeInProcess($tgl_overtime, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $data = $aortadb->query("SELECT NO_SEQUENCE FROM TW_KRY_OVERTIME 
        WHERE TGL_OVERTIME = '$tgl_overtime' AND KD_DEPT = '$dept' AND KD_SECTION = '$section' AND FLG_FINISH = 0
        GROUP BY NO_SEQUENCE, TGL_OVERTIME
        ORDER BY TGL_OVERTIME ASC")->result();

        return $data;
    }

    public function getTempOvertimebyId($no_sequence)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT NO_SEQUENCE, KAT_OT,TGL_OVERTIME, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, HARI_KJ, A.NPK, K.NAMA, 
        NPK_PIC, RENC_MULAI_OV_TIME, RENC_SELESAI_OV_TIME,
        LEFT(RENC_MULAI_OV_TIME,2) JAM_MULAI, 
        SUBSTRING(RENC_MULAI_OV_TIME,3,2) MENIT_MULAI,
        LEFT(RENC_SELESAI_OV_TIME,2) JAM_SELESAI, 
        SUBSTRING(RENC_SELESAI_OV_TIME,3,2) MENIT_SELESAI,
        RENC_DURASI_OV_TIME ,
            REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME, REAL_DURASI_OV_TIME, CEK_DIR, CEK_GM,CEK_KADEP, ALASAN
            FROM TW_KRY_OVERTIME A 
                INNER JOIN TM_KRY K ON K.NPK = A.NPK
            WHERE NO_SEQUENCE = '$no_sequence' AND FLG_FINISH = 0")->result();
    }
}
