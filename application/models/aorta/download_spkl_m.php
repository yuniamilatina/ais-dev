<?php

class download_spkl_m extends CI_Model
{

    private $tabel = 'TT_KRY_OVERTIME';
    private $temp_tabel = 'TW_KRY_OVERTIME';

    function  get($mulai, $selesai, $gm, $deptart, $download)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        if ($deptart == "ALL") {
            $query = $aortadb->query("EXEC getStatusOt '$gm','$mulai','$selesai','$download'");
        } else {
            $query = $aortadb->query("EXEC getStatusOtdept '$gm','$deptart','$mulai','$selesai','$download'");
        }

        return $query->result();
    }


    function check_excel_all($no_spkl)
    {
        $aortadb = $this->load->database("aorta", TRUE);


        // foreach ($this->input->post("SPKL") as $no_spkl) {
        $query = $aortadb->query("SELECT  NO_SEQUENCE,NPK, CEK_GM, TGL_OVERTIME, TGL_ENTRY, REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME,
        (RTRIM(NPK)+'/'+TGL_OVERTIME+'/01') AS Reference, 
        (NO_SEQUENCE+''+CLOSE_TRANS) AS Remark,
    	LEFT(REAL_MULAI_OV_TIME, 4) AS OVT_IN_TIME,
    	LEFT(REAL_SELESAI_OV_TIME, 4) AS OVT_OUT_TIME,
    	CASE 
    	WHEN REAL_MULAI_OV_TIME > REAL_SELESAI_OV_TIME 
    	THEN CONVERT(VARCHAR (8), DATEADD(DAY, 1, TGL_OVERTIME), 112)
    	ELSE TGL_OVERTIME
    	END AS OVT_OUT_DATE
        FROM TT_KRY_OVERTIME 
    	WHERE NO_SEQUENCE in ($no_spkl)
    	ORDER BY Remark DESC");

        return $query->result();
        // }
    }

    function  get_gm_m()
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query(" SELECT DISTINCT CEK_GM
       
        FROM TT_KRY_OVERTIME
        ORDER BY CEK_GM desc");

        return $query->result();
    }

    function  belum_GM_m()
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query(" SELECT DISTINCT TOP 10 NO_SEQUENCE AS SPKL, FLG_DOWNLOAD,
        COUNT(DISTINCT NPK) AS Karyawan, 
        ROUND(SUM(cast(RENC_DURASI_OV_TIME AS float))/60 ,2) as Plan_OT,
        ROUND(cast(SUM(cast(REAL_DURASI_OV_TIME AS float))/60 AS FLOAT), 2) as Real_OT
        
        FROM TT_KRY_OVERTIME 
        WHERE CEK_GM = 0
        GROUP BY NO_SEQUENCE, FLG_DOWNLOAD
        ORDER BY NO_SEQUENCE desc");

        return $query->result();
    }



    function getDatabyNo($no_spkl)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT  NO_SEQUENCE,NPK, CEK_GM, TGL_OVERTIME, TGL_ENTRY, REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME,
        (RTRIM(NPK)+'/'+TGL_OVERTIME+'/01') AS Reference, 
        (NO_SEQUENCE+''+CLOSE_TRANS) AS Remark,
    	CONVERT(VARCHAR,LEFT(REAL_MULAI_OV_TIME, 4)) AS OVT_IN_TIME,
    	CONVERT(VARCHAR,LEFT(REAL_SELESAI_OV_TIME, 4)) AS OVT_OUT_TIME,
    	CASE 
    	WHEN REAL_MULAI_OV_TIME > REAL_SELESAI_OV_TIME 
    	THEN CONVERT(VARCHAR (8), DATEADD(DAY, 1, TGL_OVERTIME), 112)
    	ELSE TGL_OVERTIME
    	END AS OVT_OUT_DATE
        FROM TT_KRY_OVERTIME 
    	WHERE NO_SEQUENCE ='$no_spkl'
        AND FLG_DELETE = 0
    	ORDER BY Remark DESC");

        return $query->result();
    }

    function excel_list_m($mulai, $selesai, $gm, $deptart, $download)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT DISTINCT TOP 100 NO_SEQUENCE AS SPKL, KD_DEPT, TGL_OVERTIME,
        COUNT(DISTINCT NPK) AS Karyawan, 
        ROUND(SUM(cast(RENC_DURASI_OV_TIME AS float))/60 ,2) as Plan_OT,
        ROUND(cast(SUM(cast(REAL_DURASI_OV_TIME AS float))/60 AS FLOAT), 2) as Real_OT
        FROM TT_KRY_OVERTIME 
        WHERE   CEK_GM = '$gm' AND KD_DEPT = '$deptart' AND  TGL_OVERTIME BETWEEN '$mulai' AND '$selesai' AND FLG_DOWNLOAD = '$download'
        GROUP BY NO_SEQUENCE, FLG_DOWNLOAD, KD_DEPT, TGL_OVERTIME
        ORDER BY NO_SEQUENCE desc");



        return $query->result();
    }

    function  status_m($status_spkl)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $query = $aortadb->query("UPDATE TT_KRY_OVERTIME set FLG_DOWNLOAD = 1
        WHERE NO_SEQUENCE in ($status_spkl)");
    }

    function detail_m($no_spkl)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT  NO_SEQUENCE,NPK, CEK_GM, TGL_OVERTIME, TGL_ENTRY, REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME,
        (RTRIM(NPK)+'/'+TGL_OVERTIME+'/01') AS Reference, 
        (NO_SEQUENCE+''+CLOSE_TRANS) AS Remark,
    	LEFT(REAL_MULAI_OV_TIME, 4) AS OVT_IN_TIME,
    	LEFT(REAL_SELESAI_OV_TIME, 4) AS OVT_OUT_TIME,
    	CASE 
    	WHEN REAL_MULAI_OV_TIME > REAL_SELESAI_OV_TIME 
    	THEN CONVERT(VARCHAR (8), DATEADD(DAY, 1, TGL_OVERTIME), 112)
    	ELSE TGL_OVERTIME
    	END AS OVT_OUT_DATE
        FROM TT_KRY_OVERTIME 
    	WHERE CEK_GM = 1 AND NO_SEQUENCE ='$no_spkl'
    	ORDER BY Remark DESC");

        return $query->result();
    }


    function excel_all()
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT TOP 10 NO_SEQUENCE,NPK, CEK_GM, TGL_OVERTIME, TGL_ENTRY, REAL_MULAI_OV_TIME, REAL_SELESAI_OV_TIME,
        (RTRIM(NPK)+'/'+TGL_OVERTIME+'/01') AS Reference, 
        (NO_SEQUENCE+''+CLOSE_TRANS) AS Remark,
    	LEFT(REAL_MULAI_OV_TIME, 4) AS OVT_IN_TIME,
    	LEFT(REAL_SELESAI_OV_TIME, 4) AS OVT_OUT_TIME,
    	CASE 
    	WHEN REAL_MULAI_OV_TIME > REAL_SELESAI_OV_TIME 
    	THEN CONVERT(VARCHAR (8), DATEADD(DAY, 1, TGL_OVERTIME), 112)
    	ELSE TGL_OVERTIME
    	END AS OVT_OUT_DATE
        FROM TT_KRY_OVERTIME 
    	WHERE CEK_GM = 1 
    	ORDER BY Remark DESC");

        return $query->result();
    }
}