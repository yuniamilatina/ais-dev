<?php

class report_ogawa_m extends CI_Model
{

    private $chute = 'PRD.TT_SETUP_CHUTE';
    private $ogawa = 'PRD.TM_PART_OGAWA';

    public function __construct()
    {
        parent::__construct();
    }

    // function get_part_ogawa_by_wcenter($work_center){
    //     $date = date('Ymd');
    //     $part = $this->db->query("SELECT A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_PART_NAME, A.CHR_PART_NO_OGAWA, A.CHR_FLAG_DEL, 
    //     CASE WHEN (SUM(C.INT_LOT_SIZE_ACTUAL * C.INT_QTY_PER_BOX)) IS NULL THEN 0 ELSE (SUM(C.INT_LOT_SIZE_ACTUAL * C.INT_QTY_PER_BOX)) END AS QTY_PROGRESS_PROD,
    //     CASE WHEN (SUM(E.INT_QTY_PCS)) IS NULL THEN 0 ELSE (SUM(E.INT_QTY_PCS)) END AS QTY_WAIT_PROD,
    //     CASE WHEN (SUM(F.INT_TOTAL_QTY)) IS NULL THEN 0 ELSE (SUM(F.INT_TOTAL_QTY)) END AS QTY_FINISH_PROD,
    //     CASE WHEN (SUM(G.INT_ACTUAL_DEL)) IS NULL THEN 0 ELSE (SUM(G.INT_ACTUAL_DEL)) END AS QTY_ONSHIPMENT,
    //     CASE WHEN (SUM(H.INT_SCAN_QTY)) IS NULL THEN 0 ELSE (SUM(H.INT_SCAN_QTY)) END AS QTY_READY_DEL
    // FROM PRD.TM_PART_OGAWA AS A 
    // INNER JOIN TM_PROCESS_PARTS AS B ON A.CHR_PART_NO = B.CHR_PART_NO
    // LEFT JOIN 
    //     (SELECT CHR_PART_NO, INT_LOT_SIZE_ACTUAL, INT_QTY_PER_BOX 
    //     FROM PRD.TT_SETUP_CHUTE
    //     WHERE CHR_WORK_CENTER = '$work_center'
    //         AND (CHR_DATE <= '$date' AND INT_STATUS_UNCOMPLETE = 1 AND INT_FLG_PRD <> 2 AND INT_FLG_DEL = 0)) AS C ON A.CHR_PART_NO = C.CHR_PART_NO
    // LEFT JOIN 
    //     (SELECT CHR_PART_NO, INT_QTY_PCS 
    //     FROM PRD.TT_SCHEDULE_KANBAN
    //     WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = 0 AND INT_FLG_DEL = 0) AS E ON A.CHR_PART_NO = E.CHR_PART_NO 
    // LEFT JOIN 
    //     (SELECT CHR_PART_NO, SUM(INT_TOTAL_QTY) AS INT_TOTAL_QTY
    //     FROM TT_PRODUCTION_RESULT
    //     WHERE CHR_WORK_CENTER = '$work_center'
    //     GROUP BY CHR_PART_NO) AS F ON A.CHR_PART_NO = F.CHR_PART_NO
    // LEFT JOIN
    //     (SELECT CHR_PART_NO, SUM(INT_ACTUAL_DEL) AS INT_ACTUAL_DEL
    //     FROM TT_DELIVERY_ITEM
    //     LEFT JOIN TT_DELIVERY ON TT_DELIVERY_ITEM.CHR_DEL_NO = TT_DELIVERY.CHR_DEL_NO
    //     WHERE CHR_CUS_NO = '9010-' AND CHR_GI_DEL = 'C' AND TT_DELIVERY_ITEM.CHR_DELETE_FLAG IS NULL
    //     GROUP BY CHR_PART_NO) AS G ON A.CHR_PART_NO = G.CHR_PART_NO
    // LEFT JOIN 
    //     (SELECT CHR_PART_NO, SUM(INT_SCAN_QTY) AS INT_SCAN_QTY
    //     FROM TT_DELIVERY_ITEM
    //     LEFT JOIN TT_DELIVERY ON TT_DELIVERY_ITEM.CHR_DEL_NO = TT_DELIVERY.CHR_DEL_NO
    //     WHERE CHR_CUS_NO = '9010-' AND CHR_GI_DEL <> 'C' AND TT_DELIVERY_ITEM.CHR_DELETE_FLAG IS NULL
    //     GROUP BY CHR_PART_NO) AS H ON A.CHR_PART_NO = H.CHR_PART_NO
    // WHERE A.CHR_FLAG_DEL = 0 AND B.CHR_WORK_CENTER = '$work_center'
    // GROUP BY A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_PART_NAME, A.CHR_PART_NO_OGAWA, A.CHR_FLAG_DEL, C.INT_QTY_PER_BOX")->result();
    //     return $part;
    // }

    function get_part_ogawa_by_wcenter($work_center)
    {
        $date = date('Ymd');
        $part = $this->db->query("SELECT DISTINCT A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_PART_NAME, A.CHR_PART_NO_OGAWA AS CHR_CUST_PART_NO, 
                                        CASE WHEN C.INT_QTY_PROD IS NULL THEN 0 ELSE C.INT_QTY_PROD END AS QTY_PROGRESS_PROD,
                                        CASE WHEN E.INT_QTY_PCS IS NULL THEN 0 ELSE E.INT_QTY_PCS END AS QTY_WAIT_PROD,
                                        CASE WHEN I.INT_QTY_FG IS NULL THEN 0 ELSE I.INT_QTY_FG END AS QTY_FINISH_PROD,
                                        CASE WHEN F.INT_TOTAL_QTY IS NULL THEN 0 ELSE F.INT_TOTAL_QTY END AS QTY_ALREADY_PROD,
                                        CASE WHEN G.INT_ACTUAL_DEL IS NULL THEN 0 ELSE G.INT_ACTUAL_DEL END AS QTY_ONSHIPMENT,
                                        CASE WHEN H.INT_QTY_READY_DEL IS NULL THEN 0 ELSE H.INT_QTY_READY_DEL END AS QTY_READY_DEL
                                    FROM PRD.TM_PART_OGAWA AS A 
                                    INNER JOIN TM_PROCESS_PARTS AS B ON A.CHR_PART_NO = B.CHR_PART_NO
                                    LEFT JOIN 
                                        (SELECT CHR_PART_NO, SUM(INT_LOT_SIZE_ACTUAL*INT_QTY_PER_BOX) AS INT_QTY_PROD 
                                        FROM PRD.TT_SETUP_CHUTE
                                        WHERE CHR_WORK_CENTER = '$work_center'
                                            AND (CHR_DATE <= '$date' AND INT_STATUS_UNCOMPLETE = 1 AND INT_FLG_PRD <> 2 AND INT_FLG_DEL = 0)
                                            GROUP BY CHR_PART_NO) AS C ON A.CHR_PART_NO = C.CHR_PART_NO
                                    LEFT JOIN 
                                        (SELECT CHR_PART_NO, SUM(INT_QTY_PCS) AS INT_QTY_PCS 
                                        FROM PRD.TT_SCHEDULE_KANBAN
                                        WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = 0 AND INT_FLG_DEL = 0
                                        GROUP BY CHR_PART_NO) AS E ON A.CHR_PART_NO = E.CHR_PART_NO 
                                    LEFT JOIN 
                                        (SELECT CHR_PART_NO, SUM(INT_TOTAL_QTY) AS INT_TOTAL_QTY
                                        FROM TT_PRODUCTION_RESULT
                                        WHERE CHR_WORK_CENTER = '$work_center'
                                        GROUP BY CHR_PART_NO) AS F ON A.CHR_PART_NO = F.CHR_PART_NO
                                    LEFT JOIN
                                        (SELECT CHR_PART_NO, SUM(INT_ACTUAL_DEL) AS INT_ACTUAL_DEL
                                        FROM TT_DELIVERY_ITEM
                                        LEFT JOIN TT_DELIVERY ON TT_DELIVERY_ITEM.CHR_DEL_NO = TT_DELIVERY.CHR_DEL_NO
                                        WHERE CHR_PART_NO IN (SELECT DISTINCT CHR_PART_NO FROM PRD.TM_PART_OGAWA WHERE CHR_FLAG_DEL = 0) AND CHR_GI_DEL = 'C' AND TT_DELIVERY_ITEM.CHR_DELETE_FLAG IS NULL
                                        GROUP BY CHR_PART_NO) AS G ON A.CHR_PART_NO = G.CHR_PART_NO
                                    LEFT JOIN 
                                        (SELECT CHR_PART_NO, SUM(INT_PART_QTY) AS INT_QTY_READY_DEL
                                        FROM TT_PARTS_SLOC
                                        WHERE CHR_SLOC = 'PP04'
                                        GROUP BY CHR_PART_NO) AS H ON A.CHR_PART_NO = H.CHR_PART_NO
                                    LEFT JOIN
                                        (SELECT CHR_PART_NO, SUM(INT_PART_QTY) AS INT_QTY_FG
                                        FROM TT_PARTS_SLOC
                                        WHERE CHR_SLOC IN ('PP02','PP03')
                                        GROUP BY CHR_PART_NO) AS I ON A.CHR_PART_NO = I.CHR_PART_NO
                                    WHERE A.CHR_FLAG_DEL = 0 AND B.CHR_WORK_CENTER = '$work_center'")->result();
        return $part;
    }

    function get_part_by_wcenter($work_center)
    {
        $date = date('Ymd');
        $part = $this->db->query("SELECT DISTINCT A.CHR_PART_NO, NULL AS CHR_BACK_NO, A.CHR_PART_NAME, NULL AS CHR_CUST_PART_NO, 
                                        CASE WHEN C.INT_QTY_PROD IS NULL THEN 0 ELSE C.INT_QTY_PROD END AS QTY_PROGRESS_PROD,
                                        CASE WHEN E.INT_QTY_PCS IS NULL THEN 0 ELSE E.INT_QTY_PCS END AS QTY_WAIT_PROD,
                                        CASE WHEN I.INT_QTY_FG IS NULL THEN 0 ELSE I.INT_QTY_FG END AS QTY_FINISH_PROD,
                                        CASE WHEN F.INT_TOTAL_QTY IS NULL THEN 0 ELSE F.INT_TOTAL_QTY END AS QTY_ALREADY_PROD,
                                        CASE WHEN G.INT_ACTUAL_DEL IS NULL THEN 0 ELSE G.INT_ACTUAL_DEL END AS QTY_ONSHIPMENT,
                                        CASE WHEN H.INT_QTY_READY_DEL IS NULL THEN 0 ELSE H.INT_QTY_READY_DEL END AS QTY_READY_DEL
                                    FROM TM_PARTS AS A 
                                    INNER JOIN TM_PROCESS_PARTS AS B ON A.CHR_PART_NO = B.CHR_PART_NO
                                    LEFT JOIN 
                                        (SELECT CHR_PART_NO, SUM(INT_LOT_SIZE_ACTUAL*INT_QTY_PER_BOX) AS INT_QTY_PROD 
                                        FROM PRD.TT_SETUP_CHUTE
                                        WHERE CHR_WORK_CENTER = '$work_center'
                                            AND (CHR_DATE <= '$date' AND INT_STATUS_UNCOMPLETE = 1 AND INT_FLG_PRD <> 2 AND INT_FLG_DEL = 0)
                                            GROUP BY CHR_PART_NO) AS C ON A.CHR_PART_NO = C.CHR_PART_NO
                                    LEFT JOIN 
                                        (SELECT CHR_PART_NO, SUM(INT_QTY_PCS) AS INT_QTY_PCS 
                                        FROM PRD.TT_SCHEDULE_KANBAN
                                        WHERE CHR_WORK_CENTER = '$work_center' AND INT_FLG_PRD = 0 AND INT_FLG_DEL = 0
                                        GROUP BY CHR_PART_NO) AS E ON A.CHR_PART_NO = E.CHR_PART_NO 
                                    LEFT JOIN 
                                        (SELECT CHR_PART_NO, SUM(INT_TOTAL_QTY) AS INT_TOTAL_QTY
                                        FROM TT_PRODUCTION_RESULT
                                        WHERE CHR_WORK_CENTER = '$work_center'
                                        GROUP BY CHR_PART_NO) AS F ON A.CHR_PART_NO = F.CHR_PART_NO
                                    LEFT JOIN
                                        (SELECT CHR_PART_NO, SUM(INT_ACTUAL_DEL) AS INT_ACTUAL_DEL
                                        FROM TT_DELIVERY_ITEM
                                        LEFT JOIN TT_DELIVERY ON TT_DELIVERY_ITEM.CHR_DEL_NO = TT_DELIVERY.CHR_DEL_NO
                                        WHERE CHR_PART_NO IN (SELECT DISTINCT CHR_PART_NO FROM PRD.TM_PART_OGAWA WHERE CHR_FLAG_DEL = 0) AND CHR_GI_DEL = 'C' AND TT_DELIVERY_ITEM.CHR_DELETE_FLAG IS NULL
                                        GROUP BY CHR_PART_NO) AS G ON A.CHR_PART_NO = G.CHR_PART_NO
                                    LEFT JOIN 
                                        (SELECT CHR_PART_NO, SUM(INT_PART_QTY) AS INT_QTY_READY_DEL
                                        FROM TT_PARTS_SLOC
                                        WHERE CHR_SLOC = 'PP04'
                                        GROUP BY CHR_PART_NO) AS H ON A.CHR_PART_NO = H.CHR_PART_NO
                                    LEFT JOIN
                                        (SELECT CHR_PART_NO, SUM(INT_PART_QTY) AS INT_QTY_FG
                                        FROM TT_PARTS_SLOC
                                        WHERE CHR_SLOC IN ('PP02','PP03')
                                        GROUP BY CHR_PART_NO) AS I ON A.CHR_PART_NO = I.CHR_PART_NO
                                    WHERE A.CHR_FLAG_DELETE IS NULL AND B.CHR_WORK_CENTER = '$work_center'")->result();
        return $part;
    }

    function get_history_prod_chute($periode, $work_center)
    {
        $data = $this->db->query("SELECT CASE WHEN CHR_PART_NO IS NULL THEN '' ELSE CHR_PART_NO END AS CHR_PART_NO, 
                            CASE WHEN CHR_BACK_NO IS NULL THEN 'TOTAL' ELSE CHR_BACK_NO END AS CHR_BACK_NO, 
                            -- PLANNING PROD
                            SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_PLAN ELSE 0 END) AS PLAN_01,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_PLAN ELSE 0 END) AS PLAN_02,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_PLAN ELSE 0 END) AS PLAN_03,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_PLAN ELSE 0 END) AS PLAN_04,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_PLAN ELSE 0 END) AS PLAN_05,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_PLAN ELSE 0 END) AS PLAN_06,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_PLAN ELSE 0 END) AS PLAN_07,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_PLAN ELSE 0 END) AS PLAN_08,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_PLAN ELSE 0 END) AS PLAN_09,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_PLAN ELSE 0 END) AS PLAN_10,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_PLAN ELSE 0 END) AS PLAN_11,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_PLAN ELSE 0 END) AS PLAN_12,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_PLAN ELSE 0 END) AS PLAN_13,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_PLAN ELSE 0 END) AS PLAN_14,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_PLAN ELSE 0 END) AS PLAN_15,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_PLAN ELSE 0 END) AS PLAN_16,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_PLAN ELSE 0 END) AS PLAN_17,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '18' THEN QTY_PLAN ELSE 0 END) AS PLAN_18,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_PLAN ELSE 0 END) AS PLAN_19,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_PLAN ELSE 0 END) AS PLAN_20,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_PLAN ELSE 0 END) AS PLAN_21,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_PLAN ELSE 0 END) AS PLAN_22,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_PLAN ELSE 0 END) AS PLAN_23,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_PLAN ELSE 0 END) AS PLAN_24,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_PLAN ELSE 0 END) AS PLAN_25,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_PLAN ELSE 0 END) AS PLAN_26,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_PLAN ELSE 0 END) AS PLAN_27,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_PLAN ELSE 0 END) AS PLAN_28,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_PLAN ELSE 0 END) AS PLAN_29,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_PLAN ELSE 0 END) AS PLAN_30,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_PLAN ELSE 0 END) AS PLAN_31,
                            -- ACTUAL PROD
                            SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_ACT ELSE 0 END) AS ACT_01,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_ACT ELSE 0 END) AS ACT_02,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_ACT ELSE 0 END) AS ACT_03,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_ACT ELSE 0 END) AS ACT_04,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_ACT ELSE 0 END) AS ACT_05,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_ACT ELSE 0 END) AS ACT_06,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_ACT ELSE 0 END) AS ACT_07,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_ACT ELSE 0 END) AS ACT_08,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_ACT ELSE 0 END) AS ACT_09,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_ACT ELSE 0 END) AS ACT_10,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_ACT ELSE 0 END) AS ACT_11,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_ACT ELSE 0 END) AS ACT_12,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_ACT ELSE 0 END) AS ACT_13,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_ACT ELSE 0 END) AS ACT_14,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_ACT ELSE 0 END) AS ACT_15,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_ACT ELSE 0 END) AS ACT_16,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_ACT ELSE 0 END) AS ACT_17,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '18' THEN QTY_ACT ELSE 0 END) AS ACT_18,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_ACT ELSE 0 END) AS ACT_19,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_ACT ELSE 0 END) AS ACT_20,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_ACT ELSE 0 END) AS ACT_21,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_ACT ELSE 0 END) AS ACT_22,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_ACT ELSE 0 END) AS ACT_23,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_ACT ELSE 0 END) AS ACT_24,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_ACT ELSE 0 END) AS ACT_25,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_ACT ELSE 0 END) AS ACT_26,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_ACT ELSE 0 END) AS ACT_27,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_ACT ELSE 0 END) AS ACT_28,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_ACT ELSE 0 END) AS ACT_29,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_ACT ELSE 0 END) AS ACT_30,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_ACT ELSE 0 END) AS ACT_31		
                        FROM 
                        (SELECT E.CHR_DEPT, A.CHR_WORK_CENTER, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_DATE, SUM(A.INT_QTY_PCS) AS QTY_PLAN, 0 AS QTY_ACT
                        FROM PRD.TT_SETUP_CHUTE AS A
                        LEFT JOIN (SELECT C.INT_DEPT, D.CHR_DEPT, C.CHR_WCENTER FROM TM_DIRECT_BACKFLUSH_GENERAL AS C LEFT JOIN TM_DEPT AS D ON C.INT_DEPT = D.INT_ID_DEPT) E ON A.CHR_WORK_CENTER = E.CHR_WCENTER
                        WHERE A.CHR_WORK_CENTER = '$work_center' AND A.CHR_DATE LIKE '$periode%'
                        GROUP BY E.CHR_DEPT, A.CHR_WORK_CENTER, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_DATE
                        UNION 
                        SELECT E.CHR_DEPT, X.CHR_WORK_CENTER, X.CHR_PART_NO, X.CHR_BACK_NO, X.CHR_DATE, 0 AS QTY_PLAN, SUM(INT_TOTAL_QTY) AS QTY_ACT
                        FROM TT_PRODUCTION_RESULT X
                        LEFT JOIN (SELECT C.INT_DEPT, D.CHR_DEPT, C.CHR_WCENTER FROM TM_DIRECT_BACKFLUSH_GENERAL AS C LEFT JOIN TM_DEPT AS D ON C.INT_DEPT = D.INT_ID_DEPT) E ON X.CHR_WORK_CENTER = E.CHR_WCENTER
                        WHERE X.CHR_WORK_CENTER = '$work_center' AND X.CHR_DATE LIKE '$periode%'
                        GROUP BY E.CHR_DEPT, X.CHR_WORK_CENTER, X.CHR_PART_NO, X.CHR_BACK_NO, X.CHR_DATE) B
                        GROUP BY B.CHR_PART_NO, B.CHR_BACK_NO")->result();
        return $data;
    }

    function get_history_prod_chute_with_ng($periode, $work_center)
    {
        $data = $this->db->query("SELECT CASE WHEN CHR_PART_NO IS NULL THEN '' ELSE CHR_PART_NO END AS CHR_PART_NO, 
                            CASE WHEN CHR_BACK_NO IS NULL THEN 'TOTAL' ELSE CHR_BACK_NO END AS CHR_BACK_NO, 
                            -- PLANNING PROD
                            SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_PLAN ELSE 0 END) AS PLAN_01,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_PLAN ELSE 0 END) AS PLAN_02,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_PLAN ELSE 0 END) AS PLAN_03,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_PLAN ELSE 0 END) AS PLAN_04,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_PLAN ELSE 0 END) AS PLAN_05,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_PLAN ELSE 0 END) AS PLAN_06,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_PLAN ELSE 0 END) AS PLAN_07,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_PLAN ELSE 0 END) AS PLAN_08,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_PLAN ELSE 0 END) AS PLAN_09,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_PLAN ELSE 0 END) AS PLAN_10,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_PLAN ELSE 0 END) AS PLAN_11,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_PLAN ELSE 0 END) AS PLAN_12,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_PLAN ELSE 0 END) AS PLAN_13,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_PLAN ELSE 0 END) AS PLAN_14,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_PLAN ELSE 0 END) AS PLAN_15,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_PLAN ELSE 0 END) AS PLAN_16,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_PLAN ELSE 0 END) AS PLAN_17,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '18' THEN QTY_PLAN ELSE 0 END) AS PLAN_18,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_PLAN ELSE 0 END) AS PLAN_19,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_PLAN ELSE 0 END) AS PLAN_20,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_PLAN ELSE 0 END) AS PLAN_21,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_PLAN ELSE 0 END) AS PLAN_22,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_PLAN ELSE 0 END) AS PLAN_23,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_PLAN ELSE 0 END) AS PLAN_24,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_PLAN ELSE 0 END) AS PLAN_25,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_PLAN ELSE 0 END) AS PLAN_26,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_PLAN ELSE 0 END) AS PLAN_27,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_PLAN ELSE 0 END) AS PLAN_28,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_PLAN ELSE 0 END) AS PLAN_29,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_PLAN ELSE 0 END) AS PLAN_30,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_PLAN ELSE 0 END) AS PLAN_31,
                            -- ACTUAL PROD OK
                            SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_ACT ELSE 0 END) AS ACT_01,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_ACT ELSE 0 END) AS ACT_02,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_ACT ELSE 0 END) AS ACT_03,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_ACT ELSE 0 END) AS ACT_04,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_ACT ELSE 0 END) AS ACT_05,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_ACT ELSE 0 END) AS ACT_06,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_ACT ELSE 0 END) AS ACT_07,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_ACT ELSE 0 END) AS ACT_08,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_ACT ELSE 0 END) AS ACT_09,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_ACT ELSE 0 END) AS ACT_10,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_ACT ELSE 0 END) AS ACT_11,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_ACT ELSE 0 END) AS ACT_12,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_ACT ELSE 0 END) AS ACT_13,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_ACT ELSE 0 END) AS ACT_14,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_ACT ELSE 0 END) AS ACT_15,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_ACT ELSE 0 END) AS ACT_16,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_ACT ELSE 0 END) AS ACT_17,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '18' THEN QTY_ACT ELSE 0 END) AS ACT_18,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_ACT ELSE 0 END) AS ACT_19,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_ACT ELSE 0 END) AS ACT_20,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_ACT ELSE 0 END) AS ACT_21,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_ACT ELSE 0 END) AS ACT_22,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_ACT ELSE 0 END) AS ACT_23,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_ACT ELSE 0 END) AS ACT_24,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_ACT ELSE 0 END) AS ACT_25,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_ACT ELSE 0 END) AS ACT_26,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_ACT ELSE 0 END) AS ACT_27,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_ACT ELSE 0 END) AS ACT_28,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_ACT ELSE 0 END) AS ACT_29,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_ACT ELSE 0 END) AS ACT_30,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_ACT ELSE 0 END) AS ACT_31,
                            -- ACTUAL PROD NG
                            SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_NG ELSE 0 END) AS NG_01,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_NG ELSE 0 END) AS NG_02,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_NG ELSE 0 END) AS NG_03,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_NG ELSE 0 END) AS NG_04,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_NG ELSE 0 END) AS NG_05,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_NG ELSE 0 END) AS NG_06,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_NG ELSE 0 END) AS NG_07,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_NG ELSE 0 END) AS NG_08,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_NG ELSE 0 END) AS NG_09,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_NG ELSE 0 END) AS NG_10,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_NG ELSE 0 END) AS NG_11,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_NG ELSE 0 END) AS NG_12,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_NG ELSE 0 END) AS NG_13,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_NG ELSE 0 END) AS NG_14,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_NG ELSE 0 END) AS NG_15,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_NG ELSE 0 END) AS NG_16,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_NG ELSE 0 END) AS NG_17,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '18' THEN QTY_NG ELSE 0 END) AS NG_18,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_NG ELSE 0 END) AS NG_19,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_NG ELSE 0 END) AS NG_20,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_NG ELSE 0 END) AS NG_21,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_NG ELSE 0 END) AS NG_22,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_NG ELSE 0 END) AS NG_23,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_NG ELSE 0 END) AS NG_24,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_NG ELSE 0 END) AS NG_25,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_NG ELSE 0 END) AS NG_26,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_NG ELSE 0 END) AS NG_27,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_NG ELSE 0 END) AS NG_28,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_NG ELSE 0 END) AS NG_29,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_NG ELSE 0 END) AS NG_30,
                            SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_NG ELSE 0 END) AS NG_31			
                        FROM 
                        (SELECT E.CHR_DEPT, A.CHR_WORK_CENTER, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_DATE, SUM(A.INT_QTY_PCS) AS QTY_PLAN, 0 AS QTY_ACT, 0 AS QTY_NG
                        FROM PRD.TT_SETUP_CHUTE AS A
                        LEFT JOIN (SELECT C.INT_DEPT, D.CHR_DEPT, C.CHR_WCENTER FROM TM_DIRECT_BACKFLUSH_GENERAL AS C LEFT JOIN TM_DEPT AS D ON C.INT_DEPT = D.INT_ID_DEPT) E ON A.CHR_WORK_CENTER = E.CHR_WCENTER
                        WHERE A.CHR_WORK_CENTER = '$work_center' AND A.CHR_DATE LIKE '$periode%'
                        GROUP BY E.CHR_DEPT, A.CHR_WORK_CENTER, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_DATE
                        UNION 
                        SELECT E.CHR_DEPT, X.CHR_WORK_CENTER, X.CHR_PART_NO, X.CHR_BACK_NO, X.CHR_DATE, 0 AS QTY_PLAN, SUM(INT_TOTAL_QTY) AS QTY_ACT, SUM(INT_TOTAL_NG) AS QTY_NG
                        FROM TT_PRODUCTION_RESULT X
                        LEFT JOIN (SELECT C.INT_DEPT, D.CHR_DEPT, C.CHR_WCENTER FROM TM_DIRECT_BACKFLUSH_GENERAL AS C LEFT JOIN TM_DEPT AS D ON C.INT_DEPT = D.INT_ID_DEPT) E ON X.CHR_WORK_CENTER = E.CHR_WCENTER
                        WHERE X.CHR_WORK_CENTER = '$work_center' AND X.CHR_DATE LIKE '$periode%'
                        GROUP BY E.CHR_DEPT, X.CHR_WORK_CENTER, X.CHR_PART_NO, X.CHR_BACK_NO, X.CHR_DATE) B
                        GROUP BY B.CHR_PART_NO, B.CHR_BACK_NO")->result();
        return $data;
    }

    // function get_history_prod_chute($periode, $id_dept, $work_center){
    //     $data = $this->db->query("SELECT CASE WHEN CHR_WORK_CENTER IS NULL THEN 'TOTAL' ELSE CHR_WORK_CENTER END AS CHR_WORK_CENTER, 
    //                             -- PLANNING PROD
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_PLAN ELSE 0 END) AS PLAN_01,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_PLAN ELSE 0 END) AS PLAN_02,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_PLAN ELSE 0 END) AS PLAN_03,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_PLAN ELSE 0 END) AS PLAN_04,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_PLAN ELSE 0 END) AS PLAN_05,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_PLAN ELSE 0 END) AS PLAN_06,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_PLAN ELSE 0 END) AS PLAN_07,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_PLAN ELSE 0 END) AS PLAN_08,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_PLAN ELSE 0 END) AS PLAN_09,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_PLAN ELSE 0 END) AS PLAN_10,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_PLAN ELSE 0 END) AS PLAN_11,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_PLAN ELSE 0 END) AS PLAN_12,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_PLAN ELSE 0 END) AS PLAN_13,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_PLAN ELSE 0 END) AS PLAN_14,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_PLAN ELSE 0 END) AS PLAN_15,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_PLAN ELSE 0 END) AS PLAN_16,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_PLAN ELSE 0 END) AS PLAN_17,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '18' THEN QTY_PLAN ELSE 0 END) AS PLAN_18,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_PLAN ELSE 0 END) AS PLAN_19,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_PLAN ELSE 0 END) AS PLAN_20,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_PLAN ELSE 0 END) AS PLAN_21,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_PLAN ELSE 0 END) AS PLAN_22,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_PLAN ELSE 0 END) AS PLAN_23,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_PLAN ELSE 0 END) AS PLAN_24,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_PLAN ELSE 0 END) AS PLAN_25,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_PLAN ELSE 0 END) AS PLAN_26,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_PLAN ELSE 0 END) AS PLAN_27,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_PLAN ELSE 0 END) AS PLAN_28,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_PLAN ELSE 0 END) AS PLAN_29,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_PLAN ELSE 0 END) AS PLAN_30,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_PLAN ELSE 0 END) AS PLAN_31,
    //                             -- ACTUAL PROD
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_ACT ELSE 0 END) AS ACT_01,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_ACT ELSE 0 END) AS ACT_02,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_ACT ELSE 0 END) AS ACT_03,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_ACT ELSE 0 END) AS ACT_04,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_ACT ELSE 0 END) AS ACT_05,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_ACT ELSE 0 END) AS ACT_06,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_ACT ELSE 0 END) AS ACT_07,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_ACT ELSE 0 END) AS ACT_08,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_ACT ELSE 0 END) AS ACT_09,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_ACT ELSE 0 END) AS ACT_10,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_ACT ELSE 0 END) AS ACT_11,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_ACT ELSE 0 END) AS ACT_12,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_ACT ELSE 0 END) AS ACT_13,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_ACT ELSE 0 END) AS ACT_14,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_ACT ELSE 0 END) AS ACT_15,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_ACT ELSE 0 END) AS ACT_16,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_ACT ELSE 0 END) AS ACT_17,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '18' THEN QTY_ACT ELSE 0 END) AS ACT_18,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_ACT ELSE 0 END) AS ACT_19,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_ACT ELSE 0 END) AS ACT_20,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_ACT ELSE 0 END) AS ACT_21,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_ACT ELSE 0 END) AS ACT_22,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_ACT ELSE 0 END) AS ACT_23,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_ACT ELSE 0 END) AS ACT_24,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_ACT ELSE 0 END) AS ACT_25,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_ACT ELSE 0 END) AS ACT_26,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_ACT ELSE 0 END) AS ACT_27,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_ACT ELSE 0 END) AS ACT_28,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_ACT ELSE 0 END) AS ACT_29,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_ACT ELSE 0 END) AS ACT_30,
    //                             SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_ACT ELSE 0 END) AS ACT_31		
    //                         FROM 
    //                         (SELECT E.CHR_DEPT, A.CHR_WORK_CENTER, SUM(A.INT_QTY_PCS) AS QTY_PLAN, ISNULL(B.ACT_TOTAL,0) AS QTY_ACT, A.CHR_DATE
    //                         FROM PRD.TT_SETUP_CHUTE AS A
    //                         LEFT JOIN (SELECT C.INT_DEPT, D.CHR_DEPT, C.CHR_WCENTER FROM TM_DIRECT_BACKFLUSH_GENERAL AS C LEFT JOIN TM_DEPT AS D ON C.INT_DEPT = D.INT_ID_DEPT) E ON A.CHR_WORK_CENTER = E.CHR_WCENTER
    //                         LEFT JOIN (SELECT CHR_WORK_CENTER, CHR_DATE, SUM(INT_TOTAL_QTY) AS ACT_TOTAL
    //                                 FROM TT_PRODUCTION_RESULT
    //                                 GROUP BY CHR_WORK_CENTER, CHR_DATE) AS B ON A.CHR_WORK_CENTER = B.CHR_WORK_CENTER AND A.CHR_DATE = B.CHR_DATE
    //                         WHERE E.INT_DEPT = '$id_dept' AND E.CHR_WCENTER = '$work_center' AND A.CHR_DATE LIKE '$periode%'
    //                         GROUP BY E.CHR_DEPT, A.CHR_WORK_CENTER, A.CHR_DATE, B.ACT_TOTAL) SUMMARY
    //                         GROUP BY ROLLUP (CHR_WORK_CENTER)")->result();
    //     return $data;
    // }

    function get_history_prod_chute_last_month($periode, $id_dept)
    {
        $data = $this->db->query("SELECT CASE WHEN CHR_WORK_CENTER IS NULL THEN 'TOTAL' ELSE CHR_WORK_CENTER END AS CHR_WORK_CENTER, 
                                -- PLANNING PROD
                                SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_PLAN ELSE 0 END) AS PLAN_01,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_PLAN ELSE 0 END) AS PLAN_02,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_PLAN ELSE 0 END) AS PLAN_03,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_PLAN ELSE 0 END) AS PLAN_04,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_PLAN ELSE 0 END) AS PLAN_05,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_PLAN ELSE 0 END) AS PLAN_06,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_PLAN ELSE 0 END) AS PLAN_07,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_PLAN ELSE 0 END) AS PLAN_08,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_PLAN ELSE 0 END) AS PLAN_09,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_PLAN ELSE 0 END) AS PLAN_10,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_PLAN ELSE 0 END) AS PLAN_11,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_PLAN ELSE 0 END) AS PLAN_12,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_PLAN ELSE 0 END) AS PLAN_13,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_PLAN ELSE 0 END) AS PLAN_14,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_PLAN ELSE 0 END) AS PLAN_15,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_PLAN ELSE 0 END) AS PLAN_16,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_PLAN ELSE 0 END) AS PLAN_17,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_PLAN ELSE 0 END) AS PLAN_19,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_PLAN ELSE 0 END) AS PLAN_20,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_PLAN ELSE 0 END) AS PLAN_21,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_PLAN ELSE 0 END) AS PLAN_22,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_PLAN ELSE 0 END) AS PLAN_23,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_PLAN ELSE 0 END) AS PLAN_24,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_PLAN ELSE 0 END) AS PLAN_25,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_PLAN ELSE 0 END) AS PLAN_26,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_PLAN ELSE 0 END) AS PLAN_27,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_PLAN ELSE 0 END) AS PLAN_28,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_PLAN ELSE 0 END) AS PLAN_29,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_PLAN ELSE 0 END) AS PLAN_30,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_PLAN ELSE 0 END) AS PLAN_31,
                                -- ACTUAL PROD
                                SUM(CASE WHEN CHR_DATE = '$periode' + '01' THEN QTY_ACT ELSE 0 END) AS ACT_01,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '02' THEN QTY_ACT ELSE 0 END) AS ACT_02,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '03' THEN QTY_ACT ELSE 0 END) AS ACT_03,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '04' THEN QTY_ACT ELSE 0 END) AS ACT_04,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '05' THEN QTY_ACT ELSE 0 END) AS ACT_05,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '06' THEN QTY_ACT ELSE 0 END) AS ACT_06,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '07' THEN QTY_ACT ELSE 0 END) AS ACT_07,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '08' THEN QTY_ACT ELSE 0 END) AS ACT_08,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '09' THEN QTY_ACT ELSE 0 END) AS ACT_09,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '10' THEN QTY_ACT ELSE 0 END) AS ACT_10,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '11' THEN QTY_ACT ELSE 0 END) AS ACT_11,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '12' THEN QTY_ACT ELSE 0 END) AS ACT_12,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '13' THEN QTY_ACT ELSE 0 END) AS ACT_13,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '14' THEN QTY_ACT ELSE 0 END) AS ACT_14,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '15' THEN QTY_ACT ELSE 0 END) AS ACT_15,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '16' THEN QTY_ACT ELSE 0 END) AS ACT_16,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '17' THEN QTY_ACT ELSE 0 END) AS ACT_17,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '18' THEN QTY_ACT ELSE 0 END) AS ACT_18,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '19' THEN QTY_ACT ELSE 0 END) AS ACT_19,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '20' THEN QTY_ACT ELSE 0 END) AS ACT_20,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '21' THEN QTY_ACT ELSE 0 END) AS ACT_21,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '22' THEN QTY_ACT ELSE 0 END) AS ACT_22,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '23' THEN QTY_ACT ELSE 0 END) AS ACT_23,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '24' THEN QTY_ACT ELSE 0 END) AS ACT_24,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '25' THEN QTY_ACT ELSE 0 END) AS ACT_25,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '26' THEN QTY_ACT ELSE 0 END) AS ACT_26,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '27' THEN QTY_ACT ELSE 0 END) AS ACT_27,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '28' THEN QTY_ACT ELSE 0 END) AS ACT_28,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '29' THEN QTY_ACT ELSE 0 END) AS ACT_29,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '30' THEN QTY_ACT ELSE 0 END) AS ACT_30,
                                SUM(CASE WHEN CHR_DATE = '$periode' + '31' THEN QTY_ACT ELSE 0 END) AS ACT_31		
                            FROM 
                            (SELECT E.CHR_DEPT, A.CHR_WORK_CENTER, SUM(A.INT_QTY_PCS) AS QTY_PLAN, ISNULL(B.ACT_TOTAL,0) AS QTY_ACT, A.CHR_DATE
                            FROM PRD.TT_SETUP_CHUTE AS A
                            LEFT JOIN (SELECT C.INT_DEPT, D.CHR_DEPT, C.CHR_WCENTER FROM TM_DIRECT_BACKFLUSH_GENERAL AS C LEFT JOIN TM_DEPT AS D ON C.INT_DEPT = D.INT_ID_DEPT) E ON A.CHR_WORK_CENTER = E.CHR_WCENTER
                            LEFT JOIN (SELECT CHR_WORK_CENTER, CHR_DATE, SUM(INT_TOTAL_QTY) AS ACT_TOTAL
                                    FROM TT_PRODUCTION_RESULT
                                    GROUP BY CHR_WORK_CENTER, CHR_DATE) AS B ON A.CHR_WORK_CENTER = B.CHR_WORK_CENTER AND A.CHR_DATE = B.CHR_DATE
                            WHERE E.INT_DEPT = '$id_dept' AND A.CHR_CREATED_DATE LIKE '$periode%'
                            GROUP BY E.CHR_DEPT, A.CHR_WORK_CENTER, A.CHR_DATE, B.ACT_TOTAL) SUMMARY
                            GROUP BY ROLLUP (CHR_WORK_CENTER)")->result();

        return $data;
    }

    function get_actual_lot($back_no, $act_date)
    {
        $part = $this->db->query("SELECT A.CHR_PRD_ORDER_NO, B.INT_LOT_SIZE, B.INT_QTY_PCS, SUM(A.INT_QTY_PERSCAN) AS TOT_SCAN 
            FROM TT_HISTORY_IN_LINE_SCAN A 
            LEFT JOIN PRD.TT_SETUP_CHUTE B ON A.CHR_PRD_ORDER_NO = B.CHR_PRD_ORDER_NO 
            WHERE A.CHR_BACK_NO = '$back_no' AND A.CHR_DATE = '$act_date' 
            GROUP BY A.CHR_PRD_ORDER_NO, A.CHR_DATE, B.INT_LOT_SIZE, B.INT_QTY_PCS");
        return $part;
    }

    function get_plan_lot($back_no, $plan_date)
    {
        $part = $this->db->query("SELECT CHR_PRD_ORDER_NO, INT_LOT_SIZE, INT_QTY_PCS
            FROM PRD.TT_SETUP_CHUTE
            WHERE CHR_BACK_NO = '$back_no' AND CHR_DATE = '$plan_date'");
        return $part;
    }

    function view_stock_part_by_wc($wc, $sloc) {
        $data = $this->db->query("SELECT STO.CHR_PART_NO, STO.CHR_SLOC, 
                                        CASE WHEN K.CHR_BACK_NO = '' THEN '-' ELSE ISNULL(K.CHR_BACK_NO,'-') END AS CHR_BACK_NO,  
                                        ISNULL(P.CHR_PART_NAME,'-') AS CHR_PART_NAME,
                                        STO.INT_PART_QTY, ISNULL(P.CHR_PART_UOM,'-') AS CHR_PART_UOM
                                        FROM TT_PARTS_SLOC STO 
                                        LEFT JOIN TM_KANBAN K 
                                        ON K.CHR_PART_NO = STO.CHR_PART_NO  
                                        LEFT JOIN TM_PARTS P
                                        ON P.CHR_PART_NO = STO.CHR_PART_NO
                                        WHERE STO.CHR_PART_NO IN (SELECT DISTINCT CHR_PART_NO FROM TM_PROCESS_PARTS WHERE CHR_WORK_CENTER = '$wc')
                                        AND (STO.CHR_SLOC LIKE '$sloc%')
                                        GROUP BY K.CHR_PART_NO, STO.CHR_PART_NO, STO.CHR_SLOC,STO.INT_PART_QTY,
                                K.CHR_BACK_NO, 
                                P.CHR_PART_NAME,
                                P.CHR_PART_UOM,
                                P.CHR_PART_UOM");

        return $data->result();
    }
}
