<?php

class quota_employee_m extends CI_Model
{

    private $table_trans = 'TT_QUOTA_KRY';
    private $table_work = 'TT_QUOTA_HIS';

    function check_duplicate_req_quota($npk, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT ID_DOC, 
        CASE 
        WHEN KADEP_APPROVE = 1 AND GM_APPROVE = 0 AND DIR_APPROVE = 0 THEN 'Sudah disetujui Manager'
        WHEN KADEP_APPROVE = 1 AND GM_APPROVE = 1 AND DIR_APPROVE = 0 THEN 'Sudah disetujui GM'
        ELSE 'Belum disetujui'
        END AS STATUS
        FROM TT_QUOTA_HIS
                WHERE NPK = '$npk' AND TAHUNBULAN = '$period' 
                AND FLG_DELETE = 0  AND FLG_FINISH_APPROVE = 0");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_data_request_quota_by_id($id)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $data = $aortadb->query("SELECT  Q.ALASAN, Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.NPK, K.NAMA, K.KD_DEPT, K.KD_SECTION, K.KD_SUB_SECTION , 
                CONVERT(FLOAT,REPLACE(QUANTITY_QUOTA_PR,',','.')) QUANTITY_QUOTA_PR,
                CONVERT(FLOAT,REPLACE(SALDO_QUOTA_PR,',','.')) SALDO_QUOTA_PR,
                CONVERT(FLOAT,REPLACE(TERPAKAI_QUOTA_PR,',','.')) TERPAKAI_QUOTA_PR,
                CONVERT(FLOAT,REPLACE(ADJ_QUOTA_PR_BULAN,',','.')) ADJ_QUOTA_PR_BULAN,
                
                CONVERT(FLOAT,REPLACE(QUANTITY_QUOTA_IM,',','.')) QUANTITY_QUOTA_IM,
                CONVERT(FLOAT,REPLACE(SALDO_QUOTA_IM,',','.')) SALDO_QUOTA_IM,
                CONVERT(FLOAT,REPLACE(TERPAKAI_QUOTA_IM,',','.')) TERPAKAI_QUOTA_IM,
                CONVERT(FLOAT,REPLACE(ADJ_QUOTA_IM_BULAN,',','.')) ADJ_QUOTA_IM_BULAN,
                
                CONVERT(FLOAT,REPLACE(QUANTITY_QUOTA_PR,',','.')) + CONVERT(FLOAT,REPLACE(QUANTITY_QUOTA_IM,',','.')) QUANTITY_QUOTA_TOT,
                CONVERT(FLOAT,REPLACE(SALDO_QUOTA_PR,',','.')) + CONVERT(FLOAT,REPLACE(SALDO_QUOTA_IM,',','.')) SALDO_QUOTA_TOT,
                CONVERT(FLOAT,REPLACE(TERPAKAI_QUOTA_PR,',','.')) + CONVERT(FLOAT,REPLACE(TERPAKAI_QUOTA_IM,',','.')) TERPAKAI_QUOTA_TOT,
                CASE Q.FLG_FINISH_APPROVE WHEN 1 THEN 'Done' ELSE '-' END AS FLG_FINISH,
                CASE WHEN CONVERT(FLOAT,REPLACE(QUANTITY_QUOTA_PR,',','.')) +
                CONVERT(FLOAT,REPLACE(SALDO_QUOTA_PR,',','.')) +
                CONVERT(FLOAT,REPLACE(QUANTITY_QUOTA_IM,',','.')) +
                CONVERT(FLOAT,REPLACE(SALDO_QUOTA_IM,',','.')) > 40 THEN 'DIR' ELSE 'GM' END AS REMARK,
                Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE, Q.ALASAN
        FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
        WHERE Q.ID_DOC = '$id'");

        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return false;
        }
    }

    function get_policy_quota($id)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT POLICY_VAL FROM TM_POLICY WHERE POLICY_KEY = '$id'");

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_adjquota($month, $year, $saldo, $quota)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("DECLARE 
        @Month int = $month,
        @Year int = $year,
        @saldo FLOAT = $saldo,
        @quota_req FLOAT = $quota
        
        SELECT ROUND((
        CONVERT(FLOAT,
        DATEDIFF(WEEK, DATEADD(WEEK, 
          DATEDIFF(DAY,0,DATEADD(MONTH,
            DATEDIFF(MONTH,0,GETDATE()),0))/7, 0),GETDATE()-1) + 1) /
            
            CONVERT(FLOAT,
            DATEDIFF(WEEK, DATEADD(WEEK, 
          DATEDIFF(DAY,0,DATEADD(MONTH,
            DATEDIFF(MONTH,0,DATEADD(day,-1,DATEADD(month,@Month,DATEADD(year,@Year-1900,0)))),0))/7, 0),DATEADD(day,-1,DATEADD(month,@Month,DATEADD(year,@Year-1900,0)))-1) + 1
            ) * CONVERT(FLOAT,@saldo) + CONVERT(FLOAT,@quota_req))
            / CONVERT(FLOAT,DATEDIFF(DAY, DATEADD(month,@Month-1,DATEADD(year,@Year-1900,0)), GETDATE()) + 1),2) AS adj");

        return $query->row()->adj;
    }

    function check_underquota($npk, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $data_quota_existing = $aortadb->query("SELECT 
        ISNULL(SUM(CAST(REPLACE(TERPAKAIPLAN,',','.') AS FLOAT)),0) AS TERPAKAIPLAN,  ISNULL(SUM(CAST(REPLACE(SISAPLAN,',','.') AS FLOAT)),0) AS SISAPLAN, 
        ISNULL(SUM(CAST(REPLACE(TERPAKAIPLAN1,',','.') AS FLOAT)),0) AS TERPAKAIPLAN1,  ISNULL(SUM(CAST(REPLACE(SISAPLAN1,',','.') AS FLOAT)),0) AS SISAPLAN1
        FROM TT_QUOTA_KRY WHERE NPK = '$npk' AND TAHUNBULAN = '$period'");

        if ($data_quota_existing->num_rows() > 0) {
            return $data_quota_existing->row();
        } else {
            return false;
        }
    }

    //check for insert template quota employee
    function check_exist_quota_employee($npk, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT * FROM $this->table_trans  WHERE NPK = '$npk' AND TAHUNBULAN = '$period'");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function check_existing_npk($npk)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT * FROM TM_KRY  WHERE NPK = '$npk' AND FLAG_DELETE = 0");

        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function get_data_quota_by_npk_period($npk, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT  
        CONVERT(FLOAT,REPLACE(TERPAKAIPLAN,',','.')) TERPAKAIPLAN, 
        CONVERT(FLOAT,REPLACE(SISAPLAN,',','.')) SISAPLAN,
        CONVERT(FLOAT,REPLACE(QUOTAPLAN,',','.')) QUOTAPLAN,
        CONVERT(FLOAT,REPLACE(TERPAKAIPLAN1,',','.')) TERPAKAIPLAN1, 
        CONVERT(FLOAT,REPLACE(SISAPLAN1,',','.')) SISAPLAN1,
        CONVERT(FLOAT,REPLACE(QUOTAPLAN1,',','.')) QUOTAPLAN1
         FROM $this->table_trans 
         WHERE TAHUNBULAN = '$period' AND NPK = '$npk'")->row();
    }

    function save_upload_result($data)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert($this->table_work, $data);
    }

    function save($data)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->insert($this->table_trans, $data);
    }

    function generated_candidate_id_quota_request($period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $id_candidate = $aortadb->query("SELECT TOP 1 ID_DOC + 1 ID_DOC FROM TT_QUOTA_HIS 
        WHERE '20' + LEFT(ID_DOC,4) = '$period' GROUP BY ID_DOC ORDER BY ID_DOC DESC");

        if ($id_candidate->num_rows() > 0) {
            return $id_candidate->row()->ID_DOC;
        } else {
            return substr($period, -4) . '0001';
        }
    }

    function get_data_request_quota_employee($dept, $section, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if ($section == 'ALL') {
            return $aortadb->query("SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT, 
            COUNT(Q.NPK) AS TOT_MP,
            SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUOTA_PR,
            SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUOTA_IM,
            Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE STAT,
            CASE WHEN Q.FLG_FINISH_APPROVE = 1 THEN '(Selesai)' ELSE '-' END AS FLG_FINISH_APPROVE , Q.ALASAN
            FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
            WHERE TAHUNBULAN = '$period' AND K.KD_DEPT = '$dept' AND Q.FLG_DELETE = 0
            GROUP BY Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT, Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, 
            Q.FLG_FINISH_APPROVE, Q.ALASAN
            ORDER BY Q.SPV_APPROVE")->result();
        } else {
            return $aortadb->query("SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT, 
            COUNT(Q.NPK) AS TOT_MP,
            SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUOTA_PR,
            SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUOTA_IM,
            Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE STAT,
            CASE WHEN Q.FLG_FINISH_APPROVE = 1 THEN '(Selesai)' ELSE '-' END AS FLG_FINISH_APPROVE , Q.ALASAN
            FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
            WHERE TAHUNBULAN = '$period' AND K.KD_DEPT = '$dept' AND K.KD_SECTION = '$section' AND Q.FLG_DELETE = 0
            GROUP BY Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT, Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, 
            Q.FLG_FINISH_APPROVE, Q.ALASAN
            ORDER BY Q.SPV_APPROVE")->result();
        }
    }

    function get_data_request_quota_employee_by_dir($dept, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("  SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT, 
                                    COUNT(Q.NPK) AS TOT_MP,
                                    SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUOTA_PR,
                                    SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUOTA_IM,
                                    Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, 
                                    CASE WHEN Q.FLG_FINISH_APPROVE = 1 THEN '(Posted)' ELSE '-' END AS FLG_FINISH_APPROVE , Q.ALASAN
                                  FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                                  WHERE TAHUNBULAN = '$period' AND K.KD_DEPT = '$dept' AND Q.FLG_DELETE = 0
                                      AND (
                                        Q.KADEP_APPROVE = 1 AND Q.GM_APPROVE = 1 AND Q.DIR_APPROVE = 1 AND Q.FLG_FINISH_APPROVE = 1 
                                        OR 
                                        Q.KADEP_APPROVE = 1 AND Q.GM_APPROVE = 1 AND Q.DIR_APPROVE = 0 AND Q.FLG_FINISH_APPROVE = 0 
                                        OR 
                                        Q.KADEP_APPROVE = 1 AND Q.GM_APPROVE = 1 AND Q.DIR_APPROVE = 1 AND Q.FLG_FINISH_APPROVE = 0 
                                        ) 
                                  GROUP BY Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT, Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE, Q.ALASAN
                ORDER BY Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE ")->result();
    }

    function get_data_request_quota_employee_by_gm($dept, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("  SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT,
                                    COUNT(Q.NPK) AS TOT_MP,
                                    SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUOTA_PR,
                                    SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUOTA_IM, 
                                    Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE,  
                                    CASE WHEN Q.FLG_FINISH_APPROVE = 1 THEN '(Posted)' ELSE '-' END AS FLG_FINISH_APPROVE , Q.ALASAN
                                  FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                                  WHERE TAHUNBULAN = '$period' AND K.KD_DEPT = '$dept' AND Q.FLG_DELETE = 0
                                      AND (
                                        Q.KADEP_APPROVE = 1 AND Q.GM_APPROVE = 1 
                                        OR 
                                        Q.KADEP_APPROVE = 1 AND Q.GM_APPROVE = 0
                                        ) 
                                        GROUP BY Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT, Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.FLG_FINISH_APPROVE, Q.ALASAN
                                  ORDER BY Q.GM_APPROVE")->result();
    }

    function get_data_request_quota_employee_by_mgr($dept, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("  SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT,
                                    COUNT(Q.NPK) AS TOT_MP,
                                    SUM(CAST(REPLACE(QUANTITY_QUOTA_PR,',','.') AS DECIMAL(10,2))) AS QUOTA_PR,
                                    SUM(CAST(REPLACE(QUANTITY_QUOTA_IM,',','.') AS DECIMAL(10,2))) AS QUOTA_IM,
                                    Q.KADEP_APPROVE,  
                                    CASE WHEN Q.FLG_FINISH_APPROVE = 1 THEN '(Posted)' ELSE '-' END AS FLG_FINISH_APPROVE , Q.ALASAN
                                  FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                                  WHERE TAHUNBULAN = '$period' AND K.KD_DEPT = '$dept' AND Q.FLG_DELETE = 0
                                      AND (
                                        Q.KADEP_APPROVE = 1 
                                        OR 
                                        Q.KADEP_APPROVE = 0 
                                        ) 
                                        GROUP BY Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.KD_DEPT, Q.SPV_APPROVE, Q.KADEP_APPROVE,  Q.FLG_FINISH_APPROVE, Q.ALASAN
                                  ORDER BY Q.KADEP_APPROVE")->result();
    }

    function get_data_request_quota_employee_by_qrno($qrno)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("  SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.NPK, K.NAMA, K.KD_DEPT, K.KD_SECTION, K.KD_SUB_SECTION , 
                                                Q.QUANTITY_QUOTA_PR, 
                                                Q.SALDO_QUOTA_PR, 
                                                Q.TERPAKAI_QUOTA_PR, 
                                                Q.ADJ_QUOTA_PR_BULAN,
                                                Q.QUANTITY_QUOTA_IM, 
                                                Q.SALDO_QUOTA_IM, 
                                                Q.TERPAKAI_QUOTA_IM, 
                                                Q.ADJ_QUOTA_IM_BULAN,
                                                --Q.PRESENT_QUOTA_PR, 
                                                --Q.FORECAST_QUOTA_PR, 
                                                Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE, Q.ALASAN
                                  FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                                  WHERE Q.ID_DOC = '$qrno'
                                  ORDER BY K.KD_SUB_SECTION,  K.NPK  ")->result();
    }

    function get_data_request_quota_employee_by_qrno_for_dir($qrno)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("  SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.NPK, K.NAMA, K.KD_DEPT, K.KD_SECTION, K.KD_SUB_SECTION , 
                                                Q.QUANTITY_QUOTA_PR, 
                                                Q.SALDO_QUOTA_PR, 
                                                Q.TERPAKAI_QUOTA_PR, 
                                                Q.ADJ_QUOTA_PR_BULAN,
                                                Q.QUANTITY_QUOTA_IM, 
                                                Q.SALDO_QUOTA_IM, 
                                                Q.TERPAKAI_QUOTA_IM, 
                                                Q.ADJ_QUOTA_IM_BULAN,
                                                --Q.PRESENT_QUOTA_PR, 
                                                --Q.FORECAST_QUOTA_PR, 
                                                Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE, Q.ALASAN
                                  FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                                  WHERE Q.ID_DOC = '$qrno'
                                      AND (
                                        Q.KADEP_APPROVE = 1 AND Q.GM_APPROVE = 1 AND Q.DIR_APPROVE = 1 AND Q.FLG_FINISH_APPROVE = 1 
                                        OR 
                                        Q.KADEP_APPROVE = 1 AND Q.GM_APPROVE = 1 AND Q.DIR_APPROVE = 0 AND Q.FLG_FINISH_APPROVE = 0 
                                        OR 
                                        Q.KADEP_APPROVE = 1 AND Q.GM_APPROVE = 1 AND Q.DIR_APPROVE = 1 AND Q.FLG_FINISH_APPROVE = 0 
                                        ) 
                                   ")->result();
    }

    function get_data_request_quota_employee_by_qrno_for_mgr($qrno)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.NPK, K.NAMA, K.KD_DEPT, K.KD_SECTION, K.KD_SUB_SECTION , 
                                                Q.QUANTITY_QUOTA_PR, 
                                                Q.SALDO_QUOTA_PR, 
                                                Q.TERPAKAI_QUOTA_PR, 
                                                Q.ADJ_QUOTA_PR_BULAN,
                                                Q.QUANTITY_QUOTA_IM, 
                                                Q.SALDO_QUOTA_IM, 
                                                Q.TERPAKAI_QUOTA_IM, 
                                                Q.ADJ_QUOTA_IM_BULAN,
                                                Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE, Q.ALASAN,
                                                QUOTA_PR_DAY_1 + QUOTA_IM_DAY_1 AS DAY_1, QUOTA_PR_DAY_2 + QUOTA_IM_DAY_2 AS DAY_2, QUOTA_PR_DAY_3 + QUOTA_IM_DAY_3 AS DAY_3,
                                                QUOTA_PR_DAY_4 + QUOTA_IM_DAY_4 AS DAY_4, QUOTA_PR_DAY_5 + QUOTA_IM_DAY_5 AS DAY_5, QUOTA_PR_DAY_6 + QUOTA_IM_DAY_6 AS DAY_6,
                                                QUOTA_PR_DAY_7 + QUOTA_IM_DAY_7 AS DAY_7, QUOTA_PR_DAY_8 + QUOTA_IM_DAY_8 AS DAY_8, QUOTA_PR_DAY_9 + QUOTA_IM_DAY_9 AS DAY_9,
                                                QUOTA_PR_DAY_10 + QUOTA_IM_DAY_10 AS DAY_10, QUOTA_PR_DAY_11 + QUOTA_IM_DAY_11 AS DAY_11, QUOTA_PR_DAY_12 + QUOTA_IM_DAY_12 AS DAY_12,
                                                QUOTA_PR_DAY_13 + QUOTA_IM_DAY_13 AS DAY_13, QUOTA_PR_DAY_14 + QUOTA_IM_DAY_14 AS DAY_14, QUOTA_PR_DAY_15 + QUOTA_IM_DAY_15 AS DAY_15,
                                                QUOTA_PR_DAY_16 + QUOTA_IM_DAY_16 AS DAY_16, QUOTA_PR_DAY_17 + QUOTA_IM_DAY_17 AS DAY_17, QUOTA_PR_DAY_18 + QUOTA_IM_DAY_18 AS DAY_18,
                                                QUOTA_PR_DAY_19 + QUOTA_IM_DAY_19 AS DAY_19, QUOTA_PR_DAY_20 + QUOTA_IM_DAY_20 AS DAY_20,
                                                QUOTA_PR_DAY_21 + QUOTA_IM_DAY_21 AS DAY_21, QUOTA_PR_DAY_22 + QUOTA_IM_DAY_22 AS DAY_22, QUOTA_PR_DAY_23 + QUOTA_IM_DAY_23 AS DAY_23, 
                                                QUOTA_PR_DAY_24 + QUOTA_IM_DAY_24 AS DAY_24, QUOTA_PR_DAY_25 + QUOTA_IM_DAY_25 AS DAY_25, QUOTA_PR_DAY_26 + QUOTA_IM_DAY_26 AS DAY_26, 
                                                QUOTA_PR_DAY_27 + QUOTA_IM_DAY_27 AS DAY_27, QUOTA_PR_DAY_28 + QUOTA_IM_DAY_28 AS DAY_28,QUOTA_PR_DAY_29 + QUOTA_IM_DAY_29 AS DAY_29, 
                                                QUOTA_PR_DAY_30 + QUOTA_IM_DAY_30 AS DAY_30,QUOTA_PR_DAY_31 + QUOTA_IM_DAY_31 AS DAY_31
                                  FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                                  WHERE Q.ID_DOC = '$qrno'
                                      AND (
                                        Q.KADEP_APPROVE = 0 
                                        OR 
                                        Q.KADEP_APPROVE = 1 
                                        ) 
                                  ORDER BY K.KD_SUB_SECTION,  K.NPK  ")->result();
    }

    function get_data_request_quota_employee_by_qrno_for_spv($qrno)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.NPK, K.NAMA, K.KD_DEPT, K.KD_SECTION, K.KD_SUB_SECTION , 
                                                Q.QUANTITY_QUOTA_PR, 
                                                Q.SALDO_QUOTA_PR, 
                                                Q.TERPAKAI_QUOTA_PR, 
                                                Q.ADJ_QUOTA_PR_BULAN,
                                                Q.QUANTITY_QUOTA_IM, 
                                                Q.SALDO_QUOTA_IM, 
                                                Q.TERPAKAI_QUOTA_IM, 
                                                Q.ADJ_QUOTA_IM_BULAN,
                                                Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE, Q.ALASAN,
                                                QUOTA_PR_DAY_1 + QUOTA_IM_DAY_1 AS DAY_1, QUOTA_PR_DAY_2 + QUOTA_IM_DAY_2 AS DAY_2, QUOTA_PR_DAY_3 + QUOTA_IM_DAY_3 AS DAY_3,
                                                QUOTA_PR_DAY_4 + QUOTA_IM_DAY_4 AS DAY_4, QUOTA_PR_DAY_5 + QUOTA_IM_DAY_5 AS DAY_5, QUOTA_PR_DAY_6 + QUOTA_IM_DAY_6 AS DAY_6,
                                                QUOTA_PR_DAY_7 + QUOTA_IM_DAY_7 AS DAY_7, QUOTA_PR_DAY_8 + QUOTA_IM_DAY_8 AS DAY_8, QUOTA_PR_DAY_9 + QUOTA_IM_DAY_9 AS DAY_9,
                                                QUOTA_PR_DAY_10 + QUOTA_IM_DAY_10 AS DAY_10, QUOTA_PR_DAY_11 + QUOTA_IM_DAY_11 AS DAY_11, QUOTA_PR_DAY_12 + QUOTA_IM_DAY_12 AS DAY_12,
                                                QUOTA_PR_DAY_13 + QUOTA_IM_DAY_13 AS DAY_13, QUOTA_PR_DAY_14 + QUOTA_IM_DAY_14 AS DAY_14, QUOTA_PR_DAY_15 + QUOTA_IM_DAY_15 AS DAY_15,
                                                QUOTA_PR_DAY_16 + QUOTA_IM_DAY_16 AS DAY_16, QUOTA_PR_DAY_17 + QUOTA_IM_DAY_17 AS DAY_17, QUOTA_PR_DAY_18 + QUOTA_IM_DAY_18 AS DAY_18,
                                                QUOTA_PR_DAY_19 + QUOTA_IM_DAY_19 AS DAY_19, QUOTA_PR_DAY_20 + QUOTA_IM_DAY_20 AS DAY_20,
                                                QUOTA_PR_DAY_21 + QUOTA_IM_DAY_21 AS DAY_21, QUOTA_PR_DAY_22 + QUOTA_IM_DAY_22 AS DAY_22, QUOTA_PR_DAY_23 + QUOTA_IM_DAY_23 AS DAY_23, 
                                                QUOTA_PR_DAY_24 + QUOTA_IM_DAY_24 AS DAY_24, QUOTA_PR_DAY_25 + QUOTA_IM_DAY_25 AS DAY_25, QUOTA_PR_DAY_26 + QUOTA_IM_DAY_26 AS DAY_26, 
                                                QUOTA_PR_DAY_27 + QUOTA_IM_DAY_27 AS DAY_27, QUOTA_PR_DAY_28 + QUOTA_IM_DAY_28 AS DAY_28,QUOTA_PR_DAY_29 + QUOTA_IM_DAY_29 AS DAY_29, 
                                                QUOTA_PR_DAY_30 + QUOTA_IM_DAY_30 AS DAY_30,QUOTA_PR_DAY_31 + QUOTA_IM_DAY_31 AS DAY_31
                                  FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                                  WHERE Q.ID_DOC = '$qrno'
                                  ORDER BY K.KD_SUB_SECTION,  K.NPK  ")->result();
    }

    function get_data_request_quota_employee_by_qrno_for_user($qrno, $stat)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT Q.ID_DOC, Q.TAHUNBULAN, Q.TGL_DOC, K.NPK, K.NAMA, K.KD_DEPT, K.KD_SECTION, K.KD_SUB_SECTION , 
                                    Q.QUANTITY_QUOTA_PR, Q.SALDO_QUOTA_PR, Q.TERPAKAI_QUOTA_PR, Q.ADJ_QUOTA_PR_BULAN,
                                    Q.QUANTITY_QUOTA_IM, Q.SALDO_QUOTA_IM, Q.TERPAKAI_QUOTA_IM, Q.ADJ_QUOTA_IM_BULAN,
                                    QUOTA_PR_DAY_1, QUOTA_PR_DAY_2, QUOTA_PR_DAY_3 ,QUOTA_PR_DAY_4,QUOTA_PR_DAY_5,QUOTA_PR_DAY_6 ,QUOTA_PR_DAY_7 ,QUOTA_PR_DAY_8 ,QUOTA_PR_DAY_9 ,QUOTA_PR_DAY_10 ,
                                    QUOTA_PR_DAY_11 ,QUOTA_PR_DAY_12,QUOTA_PR_DAY_13 ,QUOTA_PR_DAY_14 ,QUOTA_PR_DAY_15,QUOTA_PR_DAY_16,QUOTA_PR_DAY_17,QUOTA_PR_DAY_18,QUOTA_PR_DAY_19,QUOTA_PR_DAY_20,
                                    QUOTA_PR_DAY_21,QUOTA_PR_DAY_22,QUOTA_PR_DAY_23,QUOTA_PR_DAY_24,QUOTA_PR_DAY_25,QUOTA_PR_DAY_26,QUOTA_PR_DAY_27,QUOTA_PR_DAY_28,QUOTA_PR_DAY_29,QUOTA_PR_DAY_30,QUOTA_PR_DAY_31,
                                    QUOTA_IM_DAY_1,QUOTA_IM_DAY_2,QUOTA_IM_DAY_3,QUOTA_IM_DAY_4,QUOTA_IM_DAY_5,QUOTA_IM_DAY_6,QUOTA_IM_DAY_7,QUOTA_IM_DAY_8,QUOTA_IM_DAY_9,QUOTA_IM_DAY_10,
                                    QUOTA_IM_DAY_11,QUOTA_IM_DAY_12,QUOTA_IM_DAY_13,QUOTA_IM_DAY_14,QUOTA_IM_DAY_15,QUOTA_IM_DAY_16,QUOTA_IM_DAY_17,QUOTA_IM_DAY_18,QUOTA_IM_DAY_19,QUOTA_IM_DAY_20,
                                    QUOTA_IM_DAY_21,QUOTA_IM_DAY_22,QUOTA_IM_DAY_23,QUOTA_IM_DAY_24,QUOTA_IM_DAY_25,QUOTA_IM_DAY_26,QUOTA_IM_DAY_27,QUOTA_IM_DAY_28,QUOTA_IM_DAY_29,QUOTA_IM_DAY_30,QUOTA_IM_DAY_31,
                                    Q.SPV_APPROVE, Q.KADEP_APPROVE, Q.GM_APPROVE, Q.DIR_APPROVE, Q.FLG_FINISH_APPROVE, Q.ALASAN
                      FROM TT_QUOTA_HIS Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                      WHERE Q.ID_DOC = '$qrno' --AND Q.FLG_FINISH_APPROVE = '$stat' 
                      AND Q.FLG_DELETE = 0 AND K.FLAG_DELETE = 0
                      ORDER BY K.KD_SUB_SECTION,  K.NPK  ")->result();
    }

    function get_data_quota_request_by_period_by_dir($period, $id_doc)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT 
                CASE WHEN QUANTITY_QUOTA_PR + SALDO_QUOTA_PR + QUANTITY_QUOTA_IM + SALDO_QUOTA_IM > 40 THEN 1 ELSE 0 END AS FLG_FINISH_APPROVE_BY_DIR, 
                ID_DOC, TGL_DOC, TGL_POSTING, TAHUNBULAN, NPK, CAST(QUANTITY_QUOTA_PR as float) QUANTITY_QUOTA_PR,
                SALDO_QUOTA_PR, TERPAKAI_QUOTA_PR, ADJ_QUOTA_PR_BULAN, CAST(QUANTITY_QUOTA_IM as float) QUANTITY_QUOTA_IM, SALDO_QUOTA_IM, 
                TERPAKAI_QUOTA_IM, ADJ_QUOTA_IM_BULAN, OPER_ENTRY, TGL_ENTRY, JAM_ENTRY, OPER_EDIT, TGL_EDIT, 
                JAM_EDIT, KADEP_APPROVE, OPER_KADEP_APPROVE, TGL_KADEP_APPROVE, JAM_KADEP_APPROVE, GM_APPROVE, 
                OPER_GM_APPROVE, TGL_GM_APPROVE, JAM_GM_APPROVE, DIR_APPROVE, OPER_DIR_APPROVE, TGL_DIR_APPROVE, 
                JAM_DIR_APPROVE, FLG_FINISH_APPROVE, FLG_DELETE, OPER_DELETE, TGL_DELETE, JAM_DELETE, ALASAN, 
                PRESENT_QUOTA_PR, FORECAST_QUOTA_PR, DATE_REMAIN_EMAIL  
                FROM TT_QUOTA_HIS WHERE TAHUNBULAN = '$period' AND ID_DOC = '$id_doc' AND FLG_FINISH_APPROVE = 0")->result();
    }

    function get_data_quota_request_approved_by_dir($period, $id_doc)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT 
        CASE WHEN QUANTITY_QUOTA_PR + SALDO_QUOTA_PR + QUANTITY_QUOTA_IM + SALDO_QUOTA_IM > 40 THEN 1 ELSE 0 END AS FLG_FINISH_APPROVE_BY_DIR, NPK, 
        CAST(QUANTITY_QUOTA_PR AS FLOAT) QUANTITY_QUOTA_PR, CAST(SALDO_QUOTA_PR AS FLOAT) SALDO_QUOTA_PR, CAST(TERPAKAI_QUOTA_PR AS FLOAT) TERPAKAI_QUOTA_PR, 
        CAST(QUANTITY_QUOTA_IM AS FLOAT) QUANTITY_QUOTA_IM, CAST(SALDO_QUOTA_IM AS FLOAT) SALDO_QUOTA_IM, CAST(TERPAKAI_QUOTA_IM AS FLOAT) TERPAKAI_QUOTA_IM, 
        QUOTA_PR_DAY_1,QUOTA_PR_DAY_2,QUOTA_PR_DAY_3,QUOTA_PR_DAY_4,QUOTA_PR_DAY_5,QUOTA_PR_DAY_6,QUOTA_PR_DAY_7,QUOTA_PR_DAY_8,QUOTA_PR_DAY_9,QUOTA_PR_DAY_10
        ,QUOTA_PR_DAY_11,QUOTA_PR_DAY_12,QUOTA_PR_DAY_13,QUOTA_PR_DAY_14,QUOTA_PR_DAY_15,QUOTA_PR_DAY_16,QUOTA_PR_DAY_17,QUOTA_PR_DAY_18,QUOTA_PR_DAY_19,QUOTA_PR_DAY_20
        ,QUOTA_PR_DAY_21,QUOTA_PR_DAY_22,QUOTA_PR_DAY_23,QUOTA_PR_DAY_24,QUOTA_PR_DAY_25,QUOTA_PR_DAY_26,QUOTA_PR_DAY_27,QUOTA_PR_DAY_28,QUOTA_PR_DAY_29,QUOTA_PR_DAY_30
        ,QUOTA_PR_DAY_31,QUOTA_IM_DAY_1,QUOTA_IM_DAY_2,QUOTA_IM_DAY_3,QUOTA_IM_DAY_4,QUOTA_IM_DAY_5,QUOTA_IM_DAY_6,QUOTA_IM_DAY_7,QUOTA_IM_DAY_8,QUOTA_IM_DAY_9,QUOTA_IM_DAY_10
        ,QUOTA_IM_DAY_11,QUOTA_IM_DAY_12,QUOTA_IM_DAY_13,QUOTA_IM_DAY_14,QUOTA_IM_DAY_15,QUOTA_IM_DAY_16,QUOTA_IM_DAY_17,QUOTA_IM_DAY_18,QUOTA_IM_DAY_19,QUOTA_IM_DAY_20
        ,QUOTA_IM_DAY_21,QUOTA_IM_DAY_22,QUOTA_IM_DAY_23,QUOTA_IM_DAY_24,QUOTA_IM_DAY_25,QUOTA_IM_DAY_26,QUOTA_IM_DAY_27,QUOTA_IM_DAY_28,QUOTA_IM_DAY_29,QUOTA_IM_DAY_30,QUOTA_IM_DAY_31
        FROM TT_QUOTA_HIS WHERE TAHUNBULAN = '$period' AND ID_DOC = '$id_doc' AND FLG_DELETE = 0
        AND QUANTITY_QUOTA_PR + SALDO_QUOTA_PR + QUANTITY_QUOTA_IM + SALDO_QUOTA_IM > 40")->result();
    }

    function get_data_quota_request_by_period($period, $id_doc)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT 
        CASE WHEN QUANTITY_QUOTA_PR + SALDO_QUOTA_PR + QUANTITY_QUOTA_IM + SALDO_QUOTA_IM > 40 THEN 1 ELSE 0 END AS FLG_FINISH_APPROVE_BY_DIR, NPK, 
        CAST(QUANTITY_QUOTA_PR AS FLOAT) QUANTITY_QUOTA_PR, CAST(SALDO_QUOTA_PR AS FLOAT) SALDO_QUOTA_PR, CAST(TERPAKAI_QUOTA_PR AS FLOAT) TERPAKAI_QUOTA_PR, 
        CAST(QUANTITY_QUOTA_IM AS FLOAT) QUANTITY_QUOTA_IM, CAST(SALDO_QUOTA_IM AS FLOAT) SALDO_QUOTA_IM, CAST(TERPAKAI_QUOTA_IM AS FLOAT) TERPAKAI_QUOTA_IM, 
        QUOTA_PR_DAY_1,QUOTA_PR_DAY_2,QUOTA_PR_DAY_3,QUOTA_PR_DAY_4,QUOTA_PR_DAY_5,QUOTA_PR_DAY_6,QUOTA_PR_DAY_7,QUOTA_PR_DAY_8,QUOTA_PR_DAY_9,QUOTA_PR_DAY_10
        ,QUOTA_PR_DAY_11,QUOTA_PR_DAY_12,QUOTA_PR_DAY_13,QUOTA_PR_DAY_14,QUOTA_PR_DAY_15,QUOTA_PR_DAY_16,QUOTA_PR_DAY_17,QUOTA_PR_DAY_18,QUOTA_PR_DAY_19,QUOTA_PR_DAY_20
        ,QUOTA_PR_DAY_21,QUOTA_PR_DAY_22,QUOTA_PR_DAY_23,QUOTA_PR_DAY_24,QUOTA_PR_DAY_25,QUOTA_PR_DAY_26,QUOTA_PR_DAY_27,QUOTA_PR_DAY_28,QUOTA_PR_DAY_29,QUOTA_PR_DAY_30
        ,QUOTA_PR_DAY_31,QUOTA_IM_DAY_1,QUOTA_IM_DAY_2,QUOTA_IM_DAY_3,QUOTA_IM_DAY_4,QUOTA_IM_DAY_5,QUOTA_IM_DAY_6,QUOTA_IM_DAY_7,QUOTA_IM_DAY_8,QUOTA_IM_DAY_9,QUOTA_IM_DAY_10
        ,QUOTA_IM_DAY_11,QUOTA_IM_DAY_12,QUOTA_IM_DAY_13,QUOTA_IM_DAY_14,QUOTA_IM_DAY_15,QUOTA_IM_DAY_16,QUOTA_IM_DAY_17,QUOTA_IM_DAY_18,QUOTA_IM_DAY_19,QUOTA_IM_DAY_20
        ,QUOTA_IM_DAY_21,QUOTA_IM_DAY_22,QUOTA_IM_DAY_23,QUOTA_IM_DAY_24,QUOTA_IM_DAY_25,QUOTA_IM_DAY_26,QUOTA_IM_DAY_27,QUOTA_IM_DAY_28,QUOTA_IM_DAY_29,QUOTA_IM_DAY_30,QUOTA_IM_DAY_31
        
        FROM TT_QUOTA_HIS WHERE TAHUNBULAN = '$period' AND ID_DOC = '$id_doc' AND FLG_DELETE = 0")->result();
    }

    function get_data_quota_employee_by_period_and_npk($period, $npk)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT QUOTA_STD, 
                    QUOTAPLAN, TERPAKAIPLAN,  SISAPLAN, QUOTA, TERPAKAI, SISA, 
                    QUOTAPLAN1, TERPAKAIPLAN1, SISAPLAN1, QUOTA1, TERPAKAI1, SISA1,

                    QUOTA_PR_DAY_1,QUOTA_PR_DAY_2,QUOTA_PR_DAY_3,QUOTA_PR_DAY_4,QUOTA_PR_DAY_5,QUOTA_PR_DAY_6,QUOTA_PR_DAY_7,QUOTA_PR_DAY_8,QUOTA_PR_DAY_9,QUOTA_PR_DAY_10
                    ,QUOTA_PR_DAY_11,QUOTA_PR_DAY_12,QUOTA_PR_DAY_13,QUOTA_PR_DAY_14,QUOTA_PR_DAY_15,QUOTA_PR_DAY_16,QUOTA_PR_DAY_17,QUOTA_PR_DAY_18,QUOTA_PR_DAY_19,QUOTA_PR_DAY_20
                    ,QUOTA_PR_DAY_21,QUOTA_PR_DAY_22,QUOTA_PR_DAY_23,QUOTA_PR_DAY_24,QUOTA_PR_DAY_25,QUOTA_PR_DAY_26,QUOTA_PR_DAY_27,QUOTA_PR_DAY_28,QUOTA_PR_DAY_29,QUOTA_PR_DAY_30
                    ,QUOTA_PR_DAY_31,QUOTA_IM_DAY_1,QUOTA_IM_DAY_2,QUOTA_IM_DAY_3,QUOTA_IM_DAY_4,QUOTA_IM_DAY_5,QUOTA_IM_DAY_6,QUOTA_IM_DAY_7,QUOTA_IM_DAY_8,QUOTA_IM_DAY_9,QUOTA_IM_DAY_10
                    ,QUOTA_IM_DAY_11,QUOTA_IM_DAY_12,QUOTA_IM_DAY_13,QUOTA_IM_DAY_14,QUOTA_IM_DAY_15,QUOTA_IM_DAY_16,QUOTA_IM_DAY_17,QUOTA_IM_DAY_18,QUOTA_IM_DAY_19,QUOTA_IM_DAY_20
                    ,QUOTA_IM_DAY_21,QUOTA_IM_DAY_22,QUOTA_IM_DAY_23,QUOTA_IM_DAY_24,QUOTA_IM_DAY_25,QUOTA_IM_DAY_26,QUOTA_IM_DAY_27,QUOTA_IM_DAY_28,QUOTA_IM_DAY_29,QUOTA_IM_DAY_30,QUOTA_IM_DAY_31

                    FROM $this->table_trans WHERE TAHUNBULAN = '$period' and NPK='$npk' ")->row();
    }

    function get_data_quota_employee($dept, $period)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT K.NAMA, K.KD_DEPT, K.KD_SECTION, K.KD_SUB_SECTION , 
                                        Q.QUOTA_STD, Q.QUOTAPLAN, Q.TERPAKAIPLAN, Q.SISAPLAN, 
                                        Q.QUOTAPLAN1, Q.TERPAKAIPLAN1, Q.SISAPLAN1, Q.QUOTA1, Q.TERPAKAI1, Q.SISA1,
                                        Q.QUOTA, Q.TERPAKAI, Q.SISA
                                  FROM $this->table_trans Q INNER JOIN TM_KRY K ON Q.NPK = K.NPK 
                                  WHERE TAHUNBULAN = '$period' AND K.KD_DEPT = '$dept'")->result();
    }

    function update_all_quota_employee_by_period_and_dept_for_mgr($data, $id)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->update($this->table_trans, $data, $id);
    }

    function get_quota_employee_by_groupquota_employee($id)
    {
        $query = $this->db->query("SELECT INT_ID_DEPT, CHR_DEPT ,CHR_DEPT_DESC FROM TM_DEPT WHERE BIT_FLG_DEL = 0 and INT_ID_GROUP_DEPT = '" . $id . "'")->result();
        return $query;
    }

    function get_groupquota_employee_by_quota_employee($id)
    {
        $query = $this->db->query("SELECT INT_ID_GROUP_DEPT FROM TM_DEPT WHERE INT_ID_DEPT = '" . $id . "'")->row_array();
        $part_of = $query['INT_ID_GROUP_DEPT'];
        return $part_of;
    }

    function update($id, $data)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $aortadb->WHERE('ID_DOC', trim($id));
        $aortadb->update($this->table_work, $data);
    }

    function update_quota_employee_by_id($data, $id, $npk)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $aortadb->WHERE('ID_DOC', $id);
        $aortadb->WHERE('NPK', $npk);
        $aortadb->update("TT_QUOTA_HIS", $data);
    }

    function update_quota_employee_by_id_and_period_and_npk($data, $id, $period, $npk)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $aortadb->WHERE('ID_DOC', $id);
        $aortadb->WHERE('TAHUNBULAN', $period);
        $aortadb->WHERE('NPK', $npk);
        $aortadb->update("TT_QUOTA_HIS", $data);
    }

    function get_policy($key)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        $query = $aortadb->query("SELECT * FROM TM_POLICY WHERE POLICY_KEY = '$key'")->row();

        return $query;
    }


    function get_quota_employee_by_period_dept_and_section($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if ($section == 'ALL') {
            $query = "SELECT Q.NPK, NAMA, KD_DEPT,KD_SECTION, KD_SUB_SECTION,
            QUOTAPLAN, TERPAKAIPLAN, SISAPLAN, 
            QUOTAPLAN1, TERPAKAIPLAN1, SISAPLAN1
            FROM TT_QUOTA_KRY Q 
            INNER JOIN TM_KRY K ON K.NPK = Q.NPK 
            WHERE TAHUNBULAN = '$period' AND FLAG_DELETE = 0 AND KD_DEPT = '$dept' ORDER BY Q.NPK ASC";
        } else {
            $query = "SELECT Q.NPK, NAMA, KD_DEPT,KD_SECTION, KD_SUB_SECTION,
            QUOTAPLAN, TERPAKAIPLAN, SISAPLAN, 
            QUOTAPLAN1, TERPAKAIPLAN1, SISAPLAN1
            FROM TT_QUOTA_KRY Q 
            INNER JOIN TM_KRY K ON K.NPK = Q.NPK 
            WHERE TAHUNBULAN = '$period' AND FLAG_DELETE = 0 AND KD_DEPT = '$dept' AND KD_SECTION = '$section' ORDER BY Q.NPK ASC";
        }

        return $aortadb->query($query);
    }


    function update_balance($req, $period, $npk, $editor)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $date = date('Ymd');
        $time = date('His');
        //QUOTA_STD add 20211119
        $aortadb->query("UPDATE TT_QUOTA_KRY SET 
        TOTAL_QUOTA_BALANCING = 
        REPLACE( CAST( CAST(REPLACE(TOTAL_QUOTA_BALANCING,',','.') AS FLOAT) + (REPLACE('$req',',','.')) AS VARCHAR(10)), '.',',') ,  
        QUOTA_STD = 
        REPLACE( CAST( CAST(REPLACE(QUOTA_STD,',','.') AS FLOAT) + (REPLACE('$req',',','.')) AS VARCHAR(10)), '.',',') ,  
        QUOTAPLAN = 
        REPLACE( CAST( CAST(REPLACE(QUOTAPLAN,',','.') AS FLOAT) + (REPLACE('$req',',','.')) AS VARCHAR(10)), '.',',') ,  
        SISAPLAN = 
        REPLACE( CAST( CAST(REPLACE(SISAPLAN,',','.') AS FLOAT) + (REPLACE('$req',',','.')) AS VARCHAR(10)), '.',',') , 
        OPER_EDIT = '$editor', TGL_EDIT = '$date', JAM_EDIT = '$time'

        WHERE TAHUNBULAN = '$period' AND NPK = '$npk'");
    }

    function update_balance_improvement($req, $period, $npk, $editor)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        $date = date('Ymd');
        $time = date('His');

        $aortadb->query("UPDATE TT_QUOTA_KRY SET 
        TOTAL_QUOTA1_BALANCING = 
        REPLACE( CAST( CAST(REPLACE(TOTAL_QUOTA1_BALANCING,',','.') AS FLOAT) + (REPLACE('$req',',','.')) AS VARCHAR(10)), '.',',') ,  
        QUOTAPLAN1 = 
        REPLACE( CAST( CAST(REPLACE(QUOTAPLAN1,',','.') AS FLOAT) + (REPLACE('$req',',','.')) AS VARCHAR(10)), '.',',') ,  
        SISAPLAN1 = 
        REPLACE( CAST( CAST(REPLACE(SISAPLAN1,',','.') AS FLOAT) + (REPLACE('$req',',','.')) AS VARCHAR(10)), '.',',') , 
        OPER_EDIT = '$editor', TGL_EDIT = '$date', JAM_EDIT = '$time'

        WHERE TAHUNBULAN = '$period' AND NPK = '$npk'");
    }

    function get_plan_quota_by_dept_and_period_detail($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        return $aortadb->query("EXEC getPlanQuotaDetail '$period', '$dept', '$section'")->result();
    }

    function get_plan_quota_by_sequence($id_doc)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        return $aortadb->query("EXEC getPlanQuotaRequest '$id_doc'")->row();
    }

    function get_actl_quota_by_dept_and_period($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        return $aortadb->query("EXEC getActualQuota '$period', '$dept', '$section'")->row();
    }

    function get_plan_quota_by_dept_and_period($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        return $aortadb->query("EXEC getPlanQuota '$period', '$dept', '$section'")->row();
    }

    function get_actl_quota_accumulation_by_dept_and_period($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        return $aortadb->query("EXEC getActualQuotaAccumulation '$period', '$dept', '$section'")->row();
    }

    function get_plan_quota_accumulation_by_dept_and_period($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);
        return $aortadb->query("EXEC getPlanQuotaAccumulation '$period', '$dept', '$section'")->row();
    }

    function get_quota_employee($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if ($section == 'ALL') {
            $data = $aortadb->query("SELECT A.NPK, A.NAMA, A.KD_GROUP, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, 
            B.QUOTA_STD, B.QUOTAPLAN, B.QUOTAPLAN1,
            (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) - CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2))) AS QUOTA_ADD,
            (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_QUOTAPLAN,
            ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS TERPAKAIPLAN, ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS TERPAKAIPLAN1,
            (CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_TERPAKAIPLAN,
            ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS SISAPLAN, ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS SISAPLAN1,
            (CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_SISAPLAN,
            QUOTA_PR_DAY_1, QUOTA_PR_DAY_2, QUOTA_PR_DAY_3 ,QUOTA_PR_DAY_4,QUOTA_PR_DAY_5,QUOTA_PR_DAY_6
            ,QUOTA_PR_DAY_7,QUOTA_PR_DAY_8,QUOTA_PR_DAY_9,QUOTA_PR_DAY_10,QUOTA_PR_DAY_11,QUOTA_PR_DAY_12
            ,QUOTA_PR_DAY_13,QUOTA_PR_DAY_14,QUOTA_PR_DAY_15,QUOTA_PR_DAY_16,QUOTA_PR_DAY_17,QUOTA_PR_DAY_18
            ,QUOTA_PR_DAY_19,QUOTA_PR_DAY_20,QUOTA_PR_DAY_21,QUOTA_PR_DAY_22,QUOTA_PR_DAY_23,QUOTA_PR_DAY_24
            ,QUOTA_PR_DAY_25,QUOTA_PR_DAY_26,QUOTA_PR_DAY_27,QUOTA_PR_DAY_28,QUOTA_PR_DAY_29,QUOTA_PR_DAY_30
            ,QUOTA_PR_DAY_31,QUOTA_IM_DAY_1,QUOTA_IM_DAY_2,QUOTA_IM_DAY_3,QUOTA_IM_DAY_4,QUOTA_IM_DAY_5
            ,QUOTA_IM_DAY_6,QUOTA_IM_DAY_7,QUOTA_IM_DAY_8,QUOTA_IM_DAY_9,QUOTA_IM_DAY_10,QUOTA_IM_DAY_11
            ,QUOTA_IM_DAY_12,QUOTA_IM_DAY_13,QUOTA_IM_DAY_14,QUOTA_IM_DAY_15,QUOTA_IM_DAY_16,QUOTA_IM_DAY_17
            ,QUOTA_IM_DAY_18,QUOTA_IM_DAY_19,QUOTA_IM_DAY_20,QUOTA_IM_DAY_21,QUOTA_IM_DAY_22,QUOTA_IM_DAY_23
            ,QUOTA_IM_DAY_24,QUOTA_IM_DAY_25,QUOTA_IM_DAY_26,QUOTA_IM_DAY_27,QUOTA_IM_DAY_28,QUOTA_IM_DAY_29
            ,QUOTA_IM_DAY_30,QUOTA_IM_DAY_31
            FROM TM_KRY AS A
            LEFT JOIN TT_QUOTA_KRY AS B ON A.NPK = B.NPK
            WHERE (A.KD_DEPT = '$dept') AND (A.FLAG_DELETE = '0') 
            AND (LEFT(B.TAHUNBULAN,6) = '$period')
            ORDER BY NPK")->result();
        } else {
            $data = $aortadb->query("SELECT A.NPK, A.NAMA, A.KD_GROUP, A.KD_DEPT, A.KD_SECTION, A.KD_SUB_SECTION, 
            B.QUOTA_STD, B.QUOTAPLAN, B.QUOTAPLAN1,
            (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) - CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2))) AS QUOTA_ADD,
            (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_QUOTAPLAN,
            ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS TERPAKAIPLAN, ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS TERPAKAIPLAN1,
            (CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_TERPAKAIPLAN,
            ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS SISAPLAN, ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS SISAPLAN1,
            (CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_SISAPLAN,
            QUOTA_PR_DAY_1, QUOTA_PR_DAY_2, QUOTA_PR_DAY_3 ,QUOTA_PR_DAY_4,QUOTA_PR_DAY_5,QUOTA_PR_DAY_6
            ,QUOTA_PR_DAY_7,QUOTA_PR_DAY_8,QUOTA_PR_DAY_9,QUOTA_PR_DAY_10,QUOTA_PR_DAY_11,QUOTA_PR_DAY_12
            ,QUOTA_PR_DAY_13,QUOTA_PR_DAY_14,QUOTA_PR_DAY_15,QUOTA_PR_DAY_16,QUOTA_PR_DAY_17,QUOTA_PR_DAY_18
            ,QUOTA_PR_DAY_19,QUOTA_PR_DAY_20,QUOTA_PR_DAY_21,QUOTA_PR_DAY_22,QUOTA_PR_DAY_23,QUOTA_PR_DAY_24
            ,QUOTA_PR_DAY_25,QUOTA_PR_DAY_26,QUOTA_PR_DAY_27,QUOTA_PR_DAY_28,QUOTA_PR_DAY_29,QUOTA_PR_DAY_30
            ,QUOTA_PR_DAY_31,QUOTA_IM_DAY_1,QUOTA_IM_DAY_2,QUOTA_IM_DAY_3,QUOTA_IM_DAY_4,QUOTA_IM_DAY_5
            ,QUOTA_IM_DAY_6,QUOTA_IM_DAY_7,QUOTA_IM_DAY_8,QUOTA_IM_DAY_9,QUOTA_IM_DAY_10,QUOTA_IM_DAY_11
            ,QUOTA_IM_DAY_12,QUOTA_IM_DAY_13,QUOTA_IM_DAY_14,QUOTA_IM_DAY_15,QUOTA_IM_DAY_16,QUOTA_IM_DAY_17
            ,QUOTA_IM_DAY_18,QUOTA_IM_DAY_19,QUOTA_IM_DAY_20,QUOTA_IM_DAY_21,QUOTA_IM_DAY_22,QUOTA_IM_DAY_23
            ,QUOTA_IM_DAY_24,QUOTA_IM_DAY_25,QUOTA_IM_DAY_26,QUOTA_IM_DAY_27,QUOTA_IM_DAY_28,QUOTA_IM_DAY_29
            ,QUOTA_IM_DAY_30,QUOTA_IM_DAY_31
            FROM TM_KRY AS A
            LEFT JOIN TT_QUOTA_KRY AS B ON A.NPK = B.NPK
            WHERE (A.KD_DEPT = '$dept') AND (A.FLAG_DELETE = '0') 
            AND (A.KD_SECTION = '$section') 
            AND (LEFT(B.TAHUNBULAN,6) = '$period')
            ORDER BY NPK")->result();
        }

        return $data;
    }

    function get_quota_employee_with_group($period, $dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if ($section == 'ALL') {
            $data = $aortadb->query("SELECT A.NPK, A.NAMA,  A.KD_SECTION, A.KD_SUB_SECTION, 
             CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2)) AS QUOTA_STD, 
            CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) AS QUOTAPLAN, 
            CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2)) AS QUOTAPLAN1, 
            (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) - CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2))) AS QUOTA_ADD,
            (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_QUOTAPLAN,
            ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS TERPAKAIPLAN, ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS TERPAKAIPLAN1,
            (CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_TERPAKAIPLAN,
            ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS SISAPLAN, ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS SISAPLAN1,
            (CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_SISAPLAN,
            QUOTA_PR_DAY_1, QUOTA_PR_DAY_2, QUOTA_PR_DAY_3 ,QUOTA_PR_DAY_4,QUOTA_PR_DAY_5,QUOTA_PR_DAY_6
            ,QUOTA_PR_DAY_7,QUOTA_PR_DAY_8,QUOTA_PR_DAY_9,QUOTA_PR_DAY_10,QUOTA_PR_DAY_11,QUOTA_PR_DAY_12
            ,QUOTA_PR_DAY_13,QUOTA_PR_DAY_14,QUOTA_PR_DAY_15,QUOTA_PR_DAY_16,QUOTA_PR_DAY_17,QUOTA_PR_DAY_18
            ,QUOTA_PR_DAY_19,QUOTA_PR_DAY_20,QUOTA_PR_DAY_21,QUOTA_PR_DAY_22,QUOTA_PR_DAY_23,QUOTA_PR_DAY_24
            ,QUOTA_PR_DAY_25,QUOTA_PR_DAY_26,QUOTA_PR_DAY_27,QUOTA_PR_DAY_28,QUOTA_PR_DAY_29,QUOTA_PR_DAY_30
            ,QUOTA_PR_DAY_31,QUOTA_IM_DAY_1,QUOTA_IM_DAY_2,QUOTA_IM_DAY_3,QUOTA_IM_DAY_4,QUOTA_IM_DAY_5
            ,QUOTA_IM_DAY_6,QUOTA_IM_DAY_7,QUOTA_IM_DAY_8,QUOTA_IM_DAY_9,QUOTA_IM_DAY_10,QUOTA_IM_DAY_11
            ,QUOTA_IM_DAY_12,QUOTA_IM_DAY_13,QUOTA_IM_DAY_14,QUOTA_IM_DAY_15,QUOTA_IM_DAY_16,QUOTA_IM_DAY_17
            ,QUOTA_IM_DAY_18,QUOTA_IM_DAY_19,QUOTA_IM_DAY_20,QUOTA_IM_DAY_21,QUOTA_IM_DAY_22,QUOTA_IM_DAY_23
            ,QUOTA_IM_DAY_24,QUOTA_IM_DAY_25,QUOTA_IM_DAY_26,QUOTA_IM_DAY_27,QUOTA_IM_DAY_28,QUOTA_IM_DAY_29
            ,QUOTA_IM_DAY_30,QUOTA_IM_DAY_31            
            FROM TM_KRY AS A
            LEFT JOIN TT_QUOTA_KRY AS B ON A.NPK = B.NPK
            WHERE (A.KD_DEPT = '$dept') AND (A.FLAG_DELETE = '0') 
            AND (LEFT(B.TAHUNBULAN,6) = '$period')
            UNION
            SELECT 'ALL' AS NPK, 'ALL' AS NAMA, 'ALL' AS KD_SECTION, 'ALL' AS KD_SUB_SECTION, 
            SUM(CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2))) AS QUOTA_STD, 
            SUM(CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2))) AS QUOTAPLAN, 
            SUM(CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS QUOTAPLAN1, 
            SUM((CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) - CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2)))) AS QUOTA_ADD,
            SUM((CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2)))) AS TOT_QUOTAPLAN,
            SUM(CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2))) AS TERPAKAIPLAN, 
			SUM(CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TERPAKAIPLAN1,
            SUM((CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2)))) AS TOT_TERPAKAIPLAN,
            SUM(CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2))) AS SISAPLAN, 
			SUM(CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS SISAPLAN1,
            SUM((CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2)))) AS TOT_SISAPLAN
            ,SUM(QUOTA_PR_DAY_1 ) AS QUOTA_PR_DAY_1 , SUM(QUOTA_PR_DAY_2 ) AS QUOTA_PR_DAY_2 , SUM(QUOTA_PR_DAY_3 ) AS QUOTA_PR_DAY_3 , SUM(QUOTA_PR_DAY_4 ) AS QUOTA_PR_DAY_4 , SUM(QUOTA_PR_DAY_5 ) AS QUOTA_PR_DAY_5 , SUM(QUOTA_PR_DAY_6) AS QUOTA_PR_DAY_6
			,SUM(QUOTA_PR_DAY_7 ) AS QUOTA_PR_DAY_7 , SUM(QUOTA_PR_DAY_8 ) AS QUOTA_PR_DAY_8 , SUM(QUOTA_PR_DAY_9 ) AS QUOTA_PR_DAY_9 , SUM(QUOTA_PR_DAY_10) AS QUOTA_PR_DAY_10, SUM(QUOTA_PR_DAY_11) AS QUOTA_PR_DAY_11, SUM(QUOTA_PR_DAY_12) AS QUOTA_PR_DAY_12
			,SUM(QUOTA_PR_DAY_13) AS QUOTA_PR_DAY_13, SUM(QUOTA_PR_DAY_14) AS QUOTA_PR_DAY_14, SUM(QUOTA_PR_DAY_15) AS QUOTA_PR_DAY_15, SUM(QUOTA_PR_DAY_16) AS QUOTA_PR_DAY_16, SUM(QUOTA_PR_DAY_17) AS QUOTA_PR_DAY_17, SUM(QUOTA_PR_DAY_18) AS QUOTA_PR_DAY_18
			,SUM(QUOTA_PR_DAY_19) AS QUOTA_PR_DAY_19, SUM(QUOTA_PR_DAY_20) AS QUOTA_PR_DAY_20, SUM(QUOTA_PR_DAY_21) AS QUOTA_PR_DAY_21, SUM(QUOTA_PR_DAY_22) AS QUOTA_PR_DAY_22, SUM(QUOTA_PR_DAY_23) AS QUOTA_PR_DAY_23, SUM(QUOTA_PR_DAY_24) AS QUOTA_PR_DAY_24
			,SUM(QUOTA_PR_DAY_25) AS QUOTA_PR_DAY_25, SUM(QUOTA_PR_DAY_26) AS QUOTA_PR_DAY_26, SUM(QUOTA_PR_DAY_27) AS QUOTA_PR_DAY_27, SUM(QUOTA_PR_DAY_28) AS QUOTA_PR_DAY_28, SUM(QUOTA_PR_DAY_29) AS QUOTA_PR_DAY_29, SUM(QUOTA_PR_DAY_30) AS QUOTA_PR_DAY_30
			,SUM(QUOTA_PR_DAY_31) AS QUOTA_PR_DAY_31, SUM(QUOTA_IM_DAY_1 ) AS QUOTA_IM_DAY_1 , SUM(QUOTA_IM_DAY_2 ) AS QUOTA_IM_DAY_2 , SUM(QUOTA_IM_DAY_3 ) AS QUOTA_IM_DAY_3 , SUM(QUOTA_IM_DAY_4 ) AS QUOTA_IM_DAY_4 , SUM(QUOTA_IM_DAY_5) AS QUOTA_IM_DAY_5
			,SUM(QUOTA_IM_DAY_6 ) AS QUOTA_IM_DAY_6 , SUM(QUOTA_IM_DAY_7 ) AS QUOTA_IM_DAY_7 , SUM(QUOTA_IM_DAY_8 ) AS QUOTA_IM_DAY_8 , SUM(QUOTA_IM_DAY_9 ) AS QUOTA_IM_DAY_9 , SUM(QUOTA_IM_DAY_10) AS QUOTA_IM_DAY_10, SUM(QUOTA_IM_DAY_11) AS QUOTA_IM_DAY_11
			,SUM(QUOTA_IM_DAY_12) AS QUOTA_IM_DAY_12, SUM(QUOTA_IM_DAY_13) AS QUOTA_IM_DAY_13, SUM(QUOTA_IM_DAY_14) AS QUOTA_IM_DAY_14, SUM(QUOTA_IM_DAY_15) AS QUOTA_IM_DAY_15, SUM(QUOTA_IM_DAY_16) AS QUOTA_IM_DAY_16, SUM(QUOTA_IM_DAY_17) AS QUOTA_IM_DAY_17
			,SUM(QUOTA_IM_DAY_18) AS QUOTA_IM_DAY_18, SUM(QUOTA_IM_DAY_19) AS QUOTA_IM_DAY_19, SUM(QUOTA_IM_DAY_20) AS QUOTA_IM_DAY_20, SUM(QUOTA_IM_DAY_21) AS QUOTA_IM_DAY_21, SUM(QUOTA_IM_DAY_22) AS QUOTA_IM_DAY_22, SUM(QUOTA_IM_DAY_23) AS QUOTA_IM_DAY_23
			,SUM(QUOTA_IM_DAY_24) AS QUOTA_IM_DAY_24, SUM(QUOTA_IM_DAY_25) AS QUOTA_IM_DAY_25, SUM(QUOTA_IM_DAY_26) AS QUOTA_IM_DAY_26, SUM(QUOTA_IM_DAY_27) AS QUOTA_IM_DAY_27, SUM(QUOTA_IM_DAY_28) AS QUOTA_IM_DAY_28, SUM(QUOTA_IM_DAY_29) AS QUOTA_IM_DAY_29
			,SUM(QUOTA_IM_DAY_30) AS QUOTA_IM_DAY_30, SUM(QUOTA_IM_DAY_31) AS QUOTA_IM_DAY_31
            FROM TM_KRY AS A
            LEFT JOIN TT_QUOTA_KRY AS B ON A.NPK = B.NPK
            WHERE (A.KD_DEPT = '$dept') AND (A.FLAG_DELETE = '0') 
            AND (LEFT(B.TAHUNBULAN,6) = '$period')
            ")->result();
        } else {
            $data = $aortadb->query("SELECT A.NPK, A.NAMA, A.KD_SECTION, A.KD_SUB_SECTION, 
            CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2)) AS QUOTA_STD, 
            CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) AS QUOTAPLAN, 
            CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2)) AS QUOTAPLAN1, 
            (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) - CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2))) AS QUOTA_ADD,
            (CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_QUOTAPLAN,
            ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS TERPAKAIPLAN, ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS TERPAKAIPLAN1,
            (CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_TERPAKAIPLAN,
            ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS SISAPLAN, ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS SISAPLAN1,
            (CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TOT_SISAPLAN,
            QUOTA_PR_DAY_1, QUOTA_PR_DAY_2, QUOTA_PR_DAY_3 ,QUOTA_PR_DAY_4,QUOTA_PR_DAY_5,QUOTA_PR_DAY_6
            ,QUOTA_PR_DAY_7,QUOTA_PR_DAY_8,QUOTA_PR_DAY_9,QUOTA_PR_DAY_10,QUOTA_PR_DAY_11,QUOTA_PR_DAY_12
            ,QUOTA_PR_DAY_13,QUOTA_PR_DAY_14,QUOTA_PR_DAY_15,QUOTA_PR_DAY_16,QUOTA_PR_DAY_17,QUOTA_PR_DAY_18
            ,QUOTA_PR_DAY_19,QUOTA_PR_DAY_20,QUOTA_PR_DAY_21,QUOTA_PR_DAY_22,QUOTA_PR_DAY_23,QUOTA_PR_DAY_24
            ,QUOTA_PR_DAY_25,QUOTA_PR_DAY_26,QUOTA_PR_DAY_27,QUOTA_PR_DAY_28,QUOTA_PR_DAY_29,QUOTA_PR_DAY_30
            ,QUOTA_PR_DAY_31,QUOTA_IM_DAY_1,QUOTA_IM_DAY_2,QUOTA_IM_DAY_3,QUOTA_IM_DAY_4,QUOTA_IM_DAY_5
            ,QUOTA_IM_DAY_6,QUOTA_IM_DAY_7,QUOTA_IM_DAY_8,QUOTA_IM_DAY_9,QUOTA_IM_DAY_10,QUOTA_IM_DAY_11
            ,QUOTA_IM_DAY_12,QUOTA_IM_DAY_13,QUOTA_IM_DAY_14,QUOTA_IM_DAY_15,QUOTA_IM_DAY_16,QUOTA_IM_DAY_17
            ,QUOTA_IM_DAY_18,QUOTA_IM_DAY_19,QUOTA_IM_DAY_20,QUOTA_IM_DAY_21,QUOTA_IM_DAY_22,QUOTA_IM_DAY_23
            ,QUOTA_IM_DAY_24,QUOTA_IM_DAY_25,QUOTA_IM_DAY_26,QUOTA_IM_DAY_27,QUOTA_IM_DAY_28,QUOTA_IM_DAY_29
            ,QUOTA_IM_DAY_30,QUOTA_IM_DAY_31
            FROM TM_KRY AS A
            LEFT JOIN TT_QUOTA_KRY AS B ON A.NPK = B.NPK
            WHERE (A.KD_DEPT = '$dept') AND (A.FLAG_DELETE = '0') 
            AND (A.KD_SECTION = '$section') 
            AND (LEFT(B.TAHUNBULAN,6) = '$period')
            UNION
            SELECT 'ALL' AS NPK, 'ALL' AS NAMA, A.KD_SECTION, 'ALL' KD_SUB_SECTION, 
            SUM(CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2))) AS QUOTA_STD, 
            SUM(CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2))) AS QUOTAPLAN, 
            SUM(CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS QUOTAPLAN1, 
            SUM((CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) - CAST(ISNULL(REPLACE(B.QUOTA_STD,',','.'),0) AS DECIMAL(10,2)))) AS QUOTA_ADD,
            SUM((CAST(ISNULL(REPLACE(B.QUOTAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.QUOTAPLAN1,',','.'),0) AS DECIMAL(10,2)))) AS TOT_QUOTAPLAN,
            SUM(CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2))) AS TERPAKAIPLAN, 
			SUM(CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2))) AS TERPAKAIPLAN1,
            SUM((CAST(ISNULL(REPLACE(B.TERPAKAIPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.TERPAKAIPLAN1,',','.'),0) AS DECIMAL(10,2)))) AS TOT_TERPAKAIPLAN,
            SUM(CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2))) AS SISAPLAN, 
			SUM(CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2))) AS SISAPLAN1,
            SUM((CAST(ISNULL(REPLACE(B.SISAPLAN,',','.'),0) AS DECIMAL(10,2)) + CAST(ISNULL(REPLACE(B.SISAPLAN1,',','.'),0) AS DECIMAL(10,2)))) AS TOT_SISAPLAN
            ,SUM(QUOTA_PR_DAY_1 ) AS QUOTA_PR_DAY_1 , SUM(QUOTA_PR_DAY_2 ) AS QUOTA_PR_DAY_2 , SUM(QUOTA_PR_DAY_3 ) AS QUOTA_PR_DAY_3 , SUM(QUOTA_PR_DAY_4 ) AS QUOTA_PR_DAY_4 , SUM(QUOTA_PR_DAY_5 ) AS QUOTA_PR_DAY_5 , SUM(QUOTA_PR_DAY_6) AS QUOTA_PR_DAY_6
			,SUM(QUOTA_PR_DAY_7 ) AS QUOTA_PR_DAY_7 , SUM(QUOTA_PR_DAY_8 ) AS QUOTA_PR_DAY_8 , SUM(QUOTA_PR_DAY_9 ) AS QUOTA_PR_DAY_9 , SUM(QUOTA_PR_DAY_10) AS QUOTA_PR_DAY_10, SUM(QUOTA_PR_DAY_11) AS QUOTA_PR_DAY_11, SUM(QUOTA_PR_DAY_12) AS QUOTA_PR_DAY_12
			,SUM(QUOTA_PR_DAY_13) AS QUOTA_PR_DAY_13, SUM(QUOTA_PR_DAY_14) AS QUOTA_PR_DAY_14, SUM(QUOTA_PR_DAY_15) AS QUOTA_PR_DAY_15, SUM(QUOTA_PR_DAY_16) AS QUOTA_PR_DAY_16, SUM(QUOTA_PR_DAY_17) AS QUOTA_PR_DAY_17, SUM(QUOTA_PR_DAY_18) AS QUOTA_PR_DAY_18
			,SUM(QUOTA_PR_DAY_19) AS QUOTA_PR_DAY_19, SUM(QUOTA_PR_DAY_20) AS QUOTA_PR_DAY_20, SUM(QUOTA_PR_DAY_21) AS QUOTA_PR_DAY_21, SUM(QUOTA_PR_DAY_22) AS QUOTA_PR_DAY_22, SUM(QUOTA_PR_DAY_23) AS QUOTA_PR_DAY_23, SUM(QUOTA_PR_DAY_24) AS QUOTA_PR_DAY_24
			,SUM(QUOTA_PR_DAY_25) AS QUOTA_PR_DAY_25, SUM(QUOTA_PR_DAY_26) AS QUOTA_PR_DAY_26, SUM(QUOTA_PR_DAY_27) AS QUOTA_PR_DAY_27, SUM(QUOTA_PR_DAY_28) AS QUOTA_PR_DAY_28, SUM(QUOTA_PR_DAY_29) AS QUOTA_PR_DAY_29, SUM(QUOTA_PR_DAY_30) AS QUOTA_PR_DAY_30
			,SUM(QUOTA_PR_DAY_31) AS QUOTA_PR_DAY_31, SUM(QUOTA_IM_DAY_1 ) AS QUOTA_IM_DAY_1 , SUM(QUOTA_IM_DAY_2 ) AS QUOTA_IM_DAY_2 , SUM(QUOTA_IM_DAY_3 ) AS QUOTA_IM_DAY_3 , SUM(QUOTA_IM_DAY_4 ) AS QUOTA_IM_DAY_4 , SUM(QUOTA_IM_DAY_5) AS QUOTA_IM_DAY_5
			,SUM(QUOTA_IM_DAY_6 ) AS QUOTA_IM_DAY_6 , SUM(QUOTA_IM_DAY_7 ) AS QUOTA_IM_DAY_7 , SUM(QUOTA_IM_DAY_8 ) AS QUOTA_IM_DAY_8 , SUM(QUOTA_IM_DAY_9 ) AS QUOTA_IM_DAY_9 , SUM(QUOTA_IM_DAY_10) AS QUOTA_IM_DAY_10, SUM(QUOTA_IM_DAY_11) AS QUOTA_IM_DAY_11
			,SUM(QUOTA_IM_DAY_12) AS QUOTA_IM_DAY_12, SUM(QUOTA_IM_DAY_13) AS QUOTA_IM_DAY_13, SUM(QUOTA_IM_DAY_14) AS QUOTA_IM_DAY_14, SUM(QUOTA_IM_DAY_15) AS QUOTA_IM_DAY_15, SUM(QUOTA_IM_DAY_16) AS QUOTA_IM_DAY_16, SUM(QUOTA_IM_DAY_17) AS QUOTA_IM_DAY_17
			,SUM(QUOTA_IM_DAY_18) AS QUOTA_IM_DAY_18, SUM(QUOTA_IM_DAY_19) AS QUOTA_IM_DAY_19, SUM(QUOTA_IM_DAY_20) AS QUOTA_IM_DAY_20, SUM(QUOTA_IM_DAY_21) AS QUOTA_IM_DAY_21, SUM(QUOTA_IM_DAY_22) AS QUOTA_IM_DAY_22, SUM(QUOTA_IM_DAY_23) AS QUOTA_IM_DAY_23
			,SUM(QUOTA_IM_DAY_24) AS QUOTA_IM_DAY_24, SUM(QUOTA_IM_DAY_25) AS QUOTA_IM_DAY_25, SUM(QUOTA_IM_DAY_26) AS QUOTA_IM_DAY_26, SUM(QUOTA_IM_DAY_27) AS QUOTA_IM_DAY_27, SUM(QUOTA_IM_DAY_28) AS QUOTA_IM_DAY_28, SUM(QUOTA_IM_DAY_29) AS QUOTA_IM_DAY_29
			,SUM(QUOTA_IM_DAY_30) AS QUOTA_IM_DAY_30, SUM(QUOTA_IM_DAY_31) AS QUOTA_IM_DAY_31
            FROM TM_KRY AS A
            LEFT JOIN TT_QUOTA_KRY AS B ON A.NPK = B.NPK
            WHERE (A.KD_DEPT = '$dept') AND (A.FLAG_DELETE = '0') 
            AND (A.KD_SECTION = '$section') 
            AND (LEFT(B.TAHUNBULAN,6) = '$period')
			GROUP BY  A.KD_SECTION
            ")->result();
        }

        return $data;
    }

    public function get_data_employee_by_dept_and_period($dept)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT * FROM TM_KRY WHERE KD_DEPT = '$dept' AND KD_SECTION <> '' AND KD_SUB_SECTION <> '' AND FLAG_DELETE = 0 AND FLG_NOT_OT = 0")->result();
    }

    public function get_data_employee_by_dept_section_and_period($dept, $section)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        if ($section == 'ALL') {
            return $aortadb->query("SELECT * FROM TM_KRY WHERE KD_DEPT = '$dept' AND KD_SECTION <> '' AND KD_SUB_SECTION <> '' AND FLAG_DELETE = 0 AND FLG_NOT_OT = 0")->result();
        } else {
            return $aortadb->query("SELECT * FROM TM_KRY WHERE KD_DEPT = '$dept' AND KD_SECTION = '$section' AND KD_SECTION <> '' AND KD_SUB_SECTION <> '' AND FLAG_DELETE = 0 AND FLG_NOT_OT = 0")->result();
        }
    }

    public function check_flg_approval_quota($qrno)
    {
        $aortadb = $this->load->database("aorta", TRUE);

        return $aortadb->query("SELECT TOP 1 1 FROM TT_QUOTA_HIS WHERE ID_DOC = '$qrno' AND FLG_DELETE = 0 AND KADEP_APPROVE = 1")->result();
    }
}
