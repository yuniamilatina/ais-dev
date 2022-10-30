<?php

class production_result_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //PART
    function select_data_prod_entry_by_date_and_dept_and_work_center($date, $dept_id, $work_center)
    {
        $period = intval($date);

        $stored_procedure = "EXEC PRD.zsp_get_qty_acc_part_ok_ng ?,?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept_id,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //additional
    function get_all_work_center_by_dept($dept_crop)
    {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("select LEFT(CHR_WORK_CENTER,4) AS CHR_WORK_CENTER FROM TM_PROCESS_PARTS WHERE CHR_PERSON_RESPONSIBLE = '$dept_crop' GROUP BY LEFT(CHR_WORK_CENTER,4) ORDER BY CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select LEFT(CHR_WORK_CENTER,4) AS CHR_WORK_CENTER FROM TM_PROCESS_PARTS GROUP BY LEFT(CHR_WORK_CENTER,4) ORDER BY CHR_WORK_CENTER ");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //chart line
    function select_perhour_qty_by_work_center_and_date($work_center, $period)
    {

        $stored_procedure = "EXEC PRD.zsp_get_data_prod_perday ?,?";

        $param = array(
            'work_center' => $work_center,
            'periode' => $period
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }


    //Data Detail Line Stop
    function select_data_detail_line_stop_by_date_and_dept_and_work_center($date, $work_center)
    {
        $period = intval($date);
        $stored_procedure = "EXEC PRD.zsp_get_detail_line_stop ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    public function select_data_reject_in_line($period, $group_product)
    {
        $db_report = $this->load->database('db_report', TRUE);

        if ($group_product == 0) {
            $query = $db_report->query("SELECT * FROM TR_REJECT_IN_LINE WHERE CHR_PERIOD = '$period' ORDER BY INT_PRODUCT_CODE, CHR_WORK_CENTER ");
        } else {
            $query = $db_report->query("SELECT * FROM TR_REJECT_IN_LINE WHERE CHR_PERIOD = '$period' AND INT_PRODUCT_CODE = $group_product ORDER BY INT_PRODUCT_CODE, CHR_WORK_CENTER");
        }

        return $query->result();
    }

    public function select_data_detail_reject_in_line($period, $group_product)
    {
        $db_report = $this->load->database('db_report', TRUE);

        $stored_procedure = "EXEC dbo.zsp_get_detail_ril_period ?,?";
        $param = array(
            'periode' => $period,
            'group_product' => $group_product
        );

        $query = $db_report->query($stored_procedure, $param);

        return $query->result();
    }

    function get_date_time_update_merging_reject_in_line($date, $group_product)
    {
        $db_report = $this->load->database('db_report', TRUE);

        if ($group_product == 0) {
            $query = $db_report->query("SELECT TOP 1 CHR_MODIFIED_DATE, CHR_MODIFIED_TIME FROM TR_REJECT_IN_LINE 
                WHERE CHR_PERIOD = '$date' GROUP BY CHR_MODIFIED_DATE, CHR_MODIFIED_TIME");
        } else {

            $query = $db_report->query("SELECT TOP 1 CHR_MODIFIED_DATE, CHR_MODIFIED_TIME FROM TR_REJECT_IN_LINE 
                WHERE CHR_PERIOD = '$date' AND INT_PRODUCT_CODE = $group_product
                GROUP BY CHR_MODIFIED_DATE, CHR_MODIFIED_TIME");
        }
        return $query->row();
    }

    function get_date_time_update_merging_production_result($date, $group_product)
    {
        $db_report = $this->load->database('db_report', TRUE);

        if ($group_product == 0) {
            $query = $db_report->query("SELECT TOP 1 CHR_MODIFIED_DATE, CHR_MODIFIED_TIME FROM DB_REPORT.dbo.TR_PRODUCTION_RESULT
                WHERE LEFT(CHR_DATE,6) = '$date' GROUP BY CHR_MODIFIED_DATE, CHR_MODIFIED_TIME");
        } else {
            $query = $db_report->query("SELECT TOP 1 CHR_MODIFIED_DATE, CHR_MODIFIED_TIME FROM DB_REPORT.dbo.TR_PRODUCTION_RESULT 
                WHERE LEFT(CHR_DATE,6) = '$date' AND CHR_GROUP_PRODUCT = $group_product
                GROUP BY CHR_MODIFIED_DATE, CHR_MODIFIED_TIME");
        }
        return $query->row();
    }

    //Report prod per hour per mp
    function select_data_prod_per_hour_per_mp_by_date_and_dept($period, $dept_id)
    {

        $stored_procedure = "EXEC PRD.zsp_get_prod_per_hour_per_mp ?,?";
        $param = array(
            'periode' => $period,
            'dept' => $dept_id
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //Report efficiency
    function select_data_efficiency_by_period($period, $group_product)
    {

        if ($group_product == 0) {
            $group_product = '1,2,3,4,5';
        }
        // --RUMUS : INT_TOTAL_OK * CT /WORKTIME - BT - LS (EXCLUDE BRIDGING)

        $query = "DECLARE
        @periode varchar(6) = '$period'
        
        ;WITH INES_CTE (CHR_GROUP_LINE, CHR_WORK_CENTER) AS ( 
            SELECT INT_PRODUCT_CODE, CHR_WORK_CENTER
            FROM TM_INLINE_SCAN INES 
            INNER JOIN TM_DIRECT_BACKFLUSH_GENERAL DB ON DB.CHR_WCENTER = INES.CHR_WORK_CENTER 
            WHERE DB.INT_LIVE = 1 AND INT_PRODUCT_CODE IN ($group_product)
            GROUP BY INT_PRODUCT_CODE, CHR_WORK_CENTER
        )
        ,CTE_WORK_TIME (NOROW, CHR_WORK_CENTER, CHR_DATE, CHR_SHIFT, CHR_WO_NUMBER, CHR_SHIFT_TYPE) AS (
            SELECT ROW_NUMBER() OVER(PARTITION BY CHR_WORK_CENTER, CHR_DATE, CHR_SHIFT ORDER BY CHR_WORK_CENTER, CHR_DATE, CHR_SHIFT ASC ) AS NOROW, 
            CHR_WORK_CENTER, CHR_DATE, CHR_SHIFT, CHR_WO_NUMBER, CHR_SHIFT_TYPE
            FROM TT_PRODUCTION_RESULT WHERE LEFT(CHR_DATE,6) = @periode
            AND CHR_STATUS_MOBILE IN ('I','DE') AND (INT_TOTAL_QTY <> 0 OR INT_TOTAL_NG <> 0)
            GROUP BY CHR_WORK_CENTER, CHR_WO_NUMBER, CHR_DATE, CHR_SHIFT, CHR_SHIFT_TYPE
        )
        ,CTE_LS_PLAN (CHR_WORK_CENTER, CHR_WO_NUMBER, INT_DURASI_LS) AS (
            SELECT CHR_WORK_CENTER, CHR_WO_NUMBER, SUM(INT_DURASI_LS*60) INT_DURASI_LS
            FROM TT_LINE_STOP_PROD
            WHERE CHR_WO_NUMBER IS NOT NULL AND SUBSTRING(CHR_WO_NUMBER,8,6)  = @periode 
            AND CHR_LINE_CODE <> 'LS14'
            GROUP BY CHR_WORK_CENTER, CHR_WO_NUMBER, SUBSTRING(CHR_WO_NUMBER,8,6)
        )
        ,CTE_LS_BRIDGING (CHR_WORK_CENTER, CHR_WO_NUMBER, INT_DURASI_LS) AS (
            SELECT CHR_WORK_CENTER, CHR_WO_NUMBER, SUM(INT_DURASI_LS*60) INT_DURASI_LS
            FROM TT_LINE_STOP_PROD
            WHERE CHR_WO_NUMBER IS NOT NULL AND SUBSTRING(CHR_WO_NUMBER,8,6)  = @periode 
            AND CHR_LINE_CODE = 'LS14'
            GROUP BY CHR_WORK_CENTER, CHR_WO_NUMBER, SUBSTRING(CHR_WO_NUMBER,8,6)
        )
        ,CTE_LS (CHR_WORK_CENTER, CHR_WO_NUMBER, INT_LS_NB, INT_LS_B) AS (
            SELECT ISNULL(NB.CHR_WORK_CENTER,B.CHR_WORK_CENTER) , ISNULL(NB.CHR_WO_NUMBER,B.CHR_WO_NUMBER), ISNULL(NB.INT_DURASI_LS,0), ISNULL(B.INT_DURASI_LS,0)
            FROM CTE_LS_PLAN NB 
            FULL OUTER JOIN CTE_LS_BRIDGING B ON NB.CHR_WORK_CENTER = B.CHR_WORK_CENTER AND NB.CHR_WO_NUMBER = B.CHR_WO_NUMBER
        )
        ,CTE_WORK_TIME_FIX (CHR_WORK_CENTER, CHR_WO_NUMBER, CHR_DATE, CHR_SHIFT, INT_WORK_TIME) AS (
            SELECT CHR_WORK_CENTER, CHR_WO_NUMBER, CHR_DATE, CHR_SHIFT, 
                CASE
                WHEN CHR_SHIFT = '1' AND CHR_SHIFT_TYPE = 'N' THEN (420) *60
                WHEN CHR_SHIFT = '1' AND CHR_SHIFT_TYPE = 'L' THEN (630) *60
                WHEN CHR_SHIFT = '2' THEN (405) *60
                WHEN CHR_SHIFT = '3' AND CHR_SHIFT_TYPE = 'N'  THEN (410) *60
                WHEN CHR_SHIFT = '3' AND CHR_SHIFT_TYPE = 'L' THEN (620) *60
                WHEN CHR_SHIFT = '4' AND CHR_SHIFT_TYPE = 'N' THEN (455) *60
                WHEN CHR_SHIFT = '4' AND CHR_SHIFT_TYPE = 'L' THEN (630) *60
                ELSE 0 END
            FROM CTE_WORK_TIME 
            WHERE NOROW = 1
        )
        ,CTE_PART_PROD (CHR_WORK_CENTER, CHR_WO_NUMBER, CHR_PART_NO, INT_CT, INT_TOTAL_QTY)AS (
            SELECT PR.CHR_WORK_CENTER, CHR_WO_NUMBER, PR.CHR_PART_NO, AVG(PP.INT_CYCLE_TIME), SUM(INT_TOTAL_QTY)
            FROM TT_PRODUCTION_RESULT PR
            INNER JOIN TM_PROCESS_PARTS PP ON PR.CHR_PART_NO = PP.CHR_PART_NO AND PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER
            WHERE LEFT(PR.CHR_DATE,6) = @periode
            AND CHR_STATUS_MOBILE IN ('I','DE')
            GROUP BY PR.CHR_WORK_CENTER, PR.CHR_PART_NO, CHR_WO_NUMBER
        )
        ,CTE_PROD (CHR_WORK_CENTER, CHR_WO_NUMBER , INT_TOTAL_QTY, INT_CT)AS ( 
            SELECT CHR_WORK_CENTER, CHR_WO_NUMBER , SUM(INT_TOTAL_QTY), AVG(INT_CT)
            FROM CTE_PART_PROD 
            GROUP BY CHR_WORK_CENTER, CHR_WO_NUMBER 
        )
        ,CTE_PROD_GROUP (CHR_WORK_CENTER, CHR_DATE, CHR_WORK, CHR_STOP, CHR_STBG, CHR_QTOK, INT_WORK_TIME, INT_STOP_TIME, INT_STOP_BRIDGING, INT_TOTAL_QTY, OA) AS (
            SELECT ISNULL(PRD.CHR_WORK_CENTER,LS.CHR_WORK_CENTER),
            'DATE_' + SUBSTRING(WT.CHR_DATE,7,2) CHR_DATE,
            'WORK_' + SUBSTRING(WT.CHR_DATE,7,2) CHR_WORK,
            'STOP_' + SUBSTRING(WT.CHR_DATE,7,2) CHR_STOP,
            'STBG_' + SUBSTRING(WT.CHR_DATE,7,2) CHR_STBG,
            'QTOK_' + SUBSTRING(WT.CHR_DATE,7,2) CHR_QTOK,
            SUM(ISNULL(INT_WORK_TIME,0)) INT_WORK_TIME,
            SUM(ISNULL(INT_LS_NB,0)) INT_LS_NON_BRIDGING,
            SUM(ISNULL(INT_LS_B,0)) INT_LS_BRIDGING,
            SUM(ISNULL(INT_TOTAL_QTY,0)) INT_TOTAL_QTY,
            ROUND( SUM(INT_TOTAL_QTY) * ROUND(AVG(INT_CT),2) / (SUM(INT_WORK_TIME) - SUM(ISNULL(INT_LS_NB,0))) * 100,2)
            FROM CTE_PROD PRD 
            INNER JOIN INES_CTE INES ON PRD.CHR_WORK_CENTER = INES.CHR_WORK_CENTER
            INNER JOIN CTE_WORK_TIME_FIX WT ON WT.CHR_WO_NUMBER = PRD.CHR_WO_NUMBER
            FULL OUTER JOIN CTE_LS LS ON LS.CHR_WO_NUMBER = WT.CHR_WO_NUMBER
            WHERE WT.INT_WORK_TIME IS NOT NULL 
            GROUP BY PRD.CHR_WORK_CENTER,LS.CHR_WORK_CENTER,
            'DATE_' + SUBSTRING(WT.CHR_DATE,7,2),
            'WORK_' + SUBSTRING(WT.CHR_DATE,7,2),
            'STOP_' + SUBSTRING(WT.CHR_DATE,7,2),
            'STBG_' + SUBSTRING(WT.CHR_DATE,7,2),
            'QTOK_' + SUBSTRING(WT.CHR_DATE,7,2)
        )
        ,CTE_DATE (
            CHR_WORK_CENTER , 
            DATE_01 ,
            DATE_02 ,
            DATE_03 ,
            DATE_04 ,
            DATE_05 ,
            DATE_06 ,
            DATE_07 ,
            DATE_08 ,
            DATE_09 ,
            DATE_10 ,
            DATE_11 ,
            DATE_12 ,
            DATE_13 ,
            DATE_14 ,
            DATE_15 ,
            DATE_16 ,
            DATE_17 ,
            DATE_18 ,
            DATE_19 ,
            DATE_20 ,
            DATE_21 ,
            DATE_22 ,
            DATE_23 ,
            DATE_24 ,
            DATE_25 ,
            DATE_26 ,
            DATE_27 ,
            DATE_28 ,
            DATE_29 ,
            DATE_30 ,
            DATE_31 ,
            WORK_01 ,
            WORK_02 ,
            WORK_03 ,
            WORK_04 ,
            WORK_05 ,
            WORK_06 ,
            WORK_07 ,
            WORK_08 ,
            WORK_09 ,
            WORK_10 ,
            WORK_11 ,
            WORK_12 ,
            WORK_13 ,
            WORK_14 ,
            WORK_15 ,
            WORK_16 ,
            WORK_17 ,
            WORK_18 ,
            WORK_19 ,
            WORK_20 ,
            WORK_21 ,
            WORK_22 ,
            WORK_23 ,
            WORK_24 ,
            WORK_25 ,
            WORK_26 ,
            WORK_27 ,
            WORK_28 ,
            WORK_29 ,
            WORK_30 ,
            WORK_31 ,
            STOP_01 ,
            STOP_02 ,
            STOP_03 ,
            STOP_04 ,
            STOP_05 ,
            STOP_06 ,
            STOP_07 ,
            STOP_08 ,
            STOP_09 ,
            STOP_10 ,
            STOP_11 ,
            STOP_12 ,
            STOP_13 ,
            STOP_14 ,
            STOP_15 ,
            STOP_16 ,
            STOP_17 ,
            STOP_18 ,
            STOP_19 ,
            STOP_20 ,
            STOP_21 ,
            STOP_22 ,
            STOP_23 ,
            STOP_24 ,
            STOP_25 ,
            STOP_26 ,
            STOP_27 ,
            STOP_28 ,
            STOP_29 ,
            STOP_30 ,
            STOP_31 ,
            STBG_01 ,
            STBG_02 ,
            STBG_03 ,
            STBG_04 ,
            STBG_05 ,
            STBG_06 ,
            STBG_07 ,
            STBG_08 ,
            STBG_09 ,
            STBG_10 ,
            STBG_11 ,
            STBG_12 ,
            STBG_13 ,
            STBG_14 ,
            STBG_15 ,
            STBG_16 ,
            STBG_17 ,
            STBG_18 ,
            STBG_19 ,
            STBG_20 ,
            STBG_21 ,
            STBG_22 ,
            STBG_23 ,
            STBG_24 ,
            STBG_25 ,
            STBG_26 ,
            STBG_27 ,
            STBG_28 ,
            STBG_29 ,
            STBG_30 ,
            STBG_31 ,
            QTOK_01 ,
            QTOK_02 ,
            QTOK_03 ,
            QTOK_04 ,
            QTOK_05 ,
            QTOK_06 ,
            QTOK_07 ,
            QTOK_08 ,
            QTOK_09 ,
            QTOK_10 ,
            QTOK_11 ,
            QTOK_12 ,
            QTOK_13 ,
            QTOK_14 ,
            QTOK_15 ,
            QTOK_16 ,
            QTOK_17 ,
            QTOK_18 ,
            QTOK_19 ,
            QTOK_20 ,
            QTOK_21 ,
            QTOK_22 ,
            QTOK_23 ,
            QTOK_24 ,
            QTOK_25 ,
            QTOK_26 ,
            QTOK_27 ,
            QTOK_28 ,
            QTOK_29 ,
            QTOK_30 ,
            QTOK_31 
            ) AS (
        SELECT *
        FROM CTE_PROD_GROUP
        PIVOT (
           SUM(OA)                                                   
           FOR CHR_DATE IN (DATE_01,DATE_02,DATE_03,DATE_04,DATE_05,DATE_06,DATE_07,DATE_08,DATE_09,DATE_10,DATE_11,DATE_12,DATE_13,DATE_14,DATE_15,DATE_16,DATE_17,DATE_18,DATE_19,DATE_20,DATE_21,DATE_22,DATE_23,DATE_24,DATE_25,DATE_26,DATE_27,DATE_28,DATE_29,DATE_30,DATE_31)
           )        
           AS PIVOT_OA
        PIVOT (
           SUM(INT_WORK_TIME)                                                   
           FOR CHR_WORK IN (WORK_01,WORK_02,WORK_03,WORK_04,WORK_05,WORK_06,WORK_07,WORK_08,WORK_09,WORK_10,WORK_11,WORK_12,WORK_13,WORK_14,WORK_15,WORK_16,WORK_17,WORK_18,WORK_19,WORK_20,WORK_21,WORK_22,WORK_23,WORK_24,WORK_25,WORK_26,WORK_27,WORK_28,WORK_29,WORK_30,WORK_31)
           )        
           AS PIVOT_WT
        PIVOT (
           SUM(INT_STOP_TIME)                                                   
           FOR CHR_STOP IN (STOP_01,STOP_02,STOP_03,STOP_04,STOP_05,STOP_06,STOP_07,STOP_08,STOP_09,STOP_10,STOP_11,STOP_12,STOP_13,STOP_14,STOP_15,STOP_16,STOP_17,STOP_18,STOP_19,STOP_20,STOP_21,STOP_22,STOP_23,STOP_24,STOP_25,STOP_26,STOP_27,STOP_28,STOP_29,STOP_30,STOP_31)
           )        
           AS PIVOT_LS
        PIVOT (
           SUM(INT_STOP_BRIDGING)                                                   
           FOR CHR_STBG IN (STBG_01,STBG_02,STBG_03,STBG_04,STBG_05,STBG_06,STBG_07,STBG_08,STBG_09,STBG_10,STBG_11,STBG_12,STBG_13,STBG_14,STBG_15,STBG_16,STBG_17,STBG_18,STBG_19,STBG_20,STBG_21,STBG_22,STBG_23,STBG_24,STBG_25,STBG_26,STBG_27,STBG_28,STBG_29,STBG_30,STBG_31)
           )        
           AS PIVOT_BG
        PIVOT (
           SUM(INT_TOTAL_QTY)                                                   
           FOR CHR_QTOK IN (QTOK_01,QTOK_02,QTOK_03,QTOK_04,QTOK_05,QTOK_06,QTOK_07,QTOK_08,QTOK_09,QTOK_10,QTOK_11,QTOK_12,QTOK_13,QTOK_14,QTOK_15,QTOK_16,QTOK_17,QTOK_18,QTOK_19,QTOK_20,QTOK_21,QTOK_22,QTOK_23,QTOK_24,QTOK_25,QTOK_26,QTOK_27,QTOK_28,QTOK_29,QTOK_30,QTOK_31)
           )        
           AS PIVOT_OK
        )
        
        SELECT CHR_WORK_CENTER, 
                ISNULL(SUM(DATE_01),0) AS DATE_01,
                ISNULL(SUM(DATE_02),0) AS DATE_02,
                ISNULL(SUM(DATE_03),0) AS DATE_03,
                ISNULL(SUM(DATE_04),0) AS DATE_04,
                ISNULL(SUM(DATE_05),0) AS DATE_05,
                ISNULL(SUM(DATE_06),0) AS DATE_06,
                ISNULL(SUM(DATE_07),0) AS DATE_07,
                ISNULL(SUM(DATE_08),0) AS DATE_08,
                ISNULL(SUM(DATE_09),0) AS DATE_09,
                ISNULL(SUM(DATE_10),0) AS DATE_10,
                ISNULL(SUM(DATE_11),0) AS DATE_11,
                ISNULL(SUM(DATE_12),0) AS DATE_12,
                ISNULL(SUM(DATE_13),0) AS DATE_13,
                ISNULL(SUM(DATE_14),0) AS DATE_14,
                ISNULL(SUM(DATE_15),0) AS DATE_15,
                ISNULL(SUM(DATE_16),0) AS DATE_16,
                ISNULL(SUM(DATE_17),0) AS DATE_17,
                ISNULL(SUM(DATE_18),0) AS DATE_18,
                ISNULL(SUM(DATE_19),0) AS DATE_19,
                ISNULL(SUM(DATE_20),0) AS DATE_20,
                ISNULL(SUM(DATE_21),0) AS DATE_21,
                ISNULL(SUM(DATE_22),0) AS DATE_22,
                ISNULL(SUM(DATE_23),0) AS DATE_23,
                ISNULL(SUM(DATE_24),0) AS DATE_24,
                ISNULL(SUM(DATE_25),0) AS DATE_25,
                ISNULL(SUM(DATE_26),0) AS DATE_26,
                ISNULL(SUM(DATE_27),0) AS DATE_27,
                ISNULL(SUM(DATE_28),0) AS DATE_28,
                ISNULL(SUM(DATE_29),0) AS DATE_29,
                ISNULL(SUM(DATE_30),0) AS DATE_30,
                ISNULL(SUM(DATE_31),0) AS DATE_31,
                
                ISNULL(SUM(WORK_01),0) +
                ISNULL(SUM(WORK_02),0) +
                ISNULL(SUM(WORK_03),0) +
                ISNULL(SUM(WORK_04),0) +
                ISNULL(SUM(WORK_05),0) +
                ISNULL(SUM(WORK_06),0) +
                ISNULL(SUM(WORK_07),0) +
                ISNULL(SUM(WORK_08),0) +
                ISNULL(SUM(WORK_09),0) +
                ISNULL(SUM(WORK_10),0) +
                ISNULL(SUM(WORK_11),0) +
                ISNULL(SUM(WORK_12),0) +
                ISNULL(SUM(WORK_13),0) +
                ISNULL(SUM(WORK_14),0) +
                ISNULL(SUM(WORK_15),0) +
                ISNULL(SUM(WORK_16),0) +
                ISNULL(SUM(WORK_17),0) +
                ISNULL(SUM(WORK_18),0) +
                ISNULL(SUM(WORK_19),0) +
                ISNULL(SUM(WORK_20),0) +
                ISNULL(SUM(WORK_21),0) +
                ISNULL(SUM(WORK_22),0) +
                ISNULL(SUM(WORK_23),0) +
                ISNULL(SUM(WORK_24),0) +
                ISNULL(SUM(WORK_25),0) +
                ISNULL(SUM(WORK_26),0) +
                ISNULL(SUM(WORK_27),0) +
                ISNULL(SUM(WORK_28),0) +
                ISNULL(SUM(WORK_29),0) +
                ISNULL(SUM(WORK_30),0) +
                ISNULL(SUM(WORK_31),0)  AS TOTAL_WORK_TIME,
                
                ISNULL(SUM(STOP_01),0) +
                ISNULL(SUM(STOP_02),0) +
                ISNULL(SUM(STOP_03),0) +
                ISNULL(SUM(STOP_04),0) +
                ISNULL(SUM(STOP_05),0) +
                ISNULL(SUM(STOP_06),0) +
                ISNULL(SUM(STOP_07),0) +
                ISNULL(SUM(STOP_08),0) +
                ISNULL(SUM(STOP_09),0) +
                ISNULL(SUM(STOP_10),0) +
                ISNULL(SUM(STOP_11),0) +
                ISNULL(SUM(STOP_12),0) +
                ISNULL(SUM(STOP_13),0) +
                ISNULL(SUM(STOP_14),0) +
                ISNULL(SUM(STOP_15),0) +
                ISNULL(SUM(STOP_16),0) +
                ISNULL(SUM(STOP_17),0) +
                ISNULL(SUM(STOP_18),0) +
                ISNULL(SUM(STOP_19),0) +
                ISNULL(SUM(STOP_20),0) +
                ISNULL(SUM(STOP_21),0) +
                ISNULL(SUM(STOP_22),0) +
                ISNULL(SUM(STOP_23),0) +
                ISNULL(SUM(STOP_24),0) +
                ISNULL(SUM(STOP_25),0) +
                ISNULL(SUM(STOP_26),0) +
                ISNULL(SUM(STOP_27),0) +
                ISNULL(SUM(STOP_28),0) +
                ISNULL(SUM(STOP_29),0) +
                ISNULL(SUM(STOP_30),0) +
                ISNULL(SUM(STOP_31),0) AS TOTAL_STOP_TIME,
                
                ISNULL(SUM(STBG_01),0) +
                ISNULL(SUM(STBG_02),0) +
                ISNULL(SUM(STBG_03),0) +
                ISNULL(SUM(STBG_04),0) +
                ISNULL(SUM(STBG_05),0) +
                ISNULL(SUM(STBG_06),0) +
                ISNULL(SUM(STBG_07),0) +
                ISNULL(SUM(STBG_08),0) +
                ISNULL(SUM(STBG_09),0) +
                ISNULL(SUM(STBG_10),0) +
                ISNULL(SUM(STBG_11),0) +
                ISNULL(SUM(STBG_12),0) +
                ISNULL(SUM(STBG_13),0) +
                ISNULL(SUM(STBG_14),0) +
                ISNULL(SUM(STBG_15),0) +
                ISNULL(SUM(STBG_16),0) +
                ISNULL(SUM(STBG_17),0) +
                ISNULL(SUM(STBG_18),0) +
                ISNULL(SUM(STBG_19),0) +
                ISNULL(SUM(STBG_20),0) +
                ISNULL(SUM(STBG_21),0) +
                ISNULL(SUM(STBG_22),0) +
                ISNULL(SUM(STBG_23),0) +
                ISNULL(SUM(STBG_24),0) +
                ISNULL(SUM(STBG_25),0) +
                ISNULL(SUM(STBG_26),0) +
                ISNULL(SUM(STBG_27),0) +
                ISNULL(SUM(STBG_28),0) +
                ISNULL(SUM(STBG_29),0) +
                ISNULL(SUM(STBG_30),0) +
                ISNULL(SUM(STBG_31),0) AS TOTAL_STBG_TIME,
                
                ISNULL(SUM(QTOK_01),0) +
                ISNULL(SUM(QTOK_02),0) +
                ISNULL(SUM(QTOK_03),0) +
                ISNULL(SUM(QTOK_04),0) +
                ISNULL(SUM(QTOK_05),0) +
                ISNULL(SUM(QTOK_06),0) +
                ISNULL(SUM(QTOK_07),0) +
                ISNULL(SUM(QTOK_08),0) +
                ISNULL(SUM(QTOK_09),0) +
                ISNULL(SUM(QTOK_10),0) +
                ISNULL(SUM(QTOK_11),0) +
                ISNULL(SUM(QTOK_12),0) +
                ISNULL(SUM(QTOK_13),0) +
                ISNULL(SUM(QTOK_14),0) +
                ISNULL(SUM(QTOK_15),0) +
                ISNULL(SUM(QTOK_16),0) +
                ISNULL(SUM(QTOK_17),0) +
                ISNULL(SUM(QTOK_18),0) +
                ISNULL(SUM(QTOK_19),0) +
                ISNULL(SUM(QTOK_20),0) +
                ISNULL(SUM(QTOK_21),0) +
                ISNULL(SUM(QTOK_22),0) +
                ISNULL(SUM(QTOK_23),0) +
                ISNULL(SUM(QTOK_24),0) +
                ISNULL(SUM(QTOK_25),0) +
                ISNULL(SUM(QTOK_26),0) +
                ISNULL(SUM(QTOK_27),0) +
                ISNULL(SUM(QTOK_28),0) +
                ISNULL(SUM(QTOK_29),0) +
                ISNULL(SUM(QTOK_30),0) +
                ISNULL(SUM(QTOK_31),0) AS TOTAL_QTY
                
         FROM CTE_DATE 
         GROUP BY CHR_WORK_CENTER
         ORDER BY CHR_WORK_CENTER
        ";

        // $stored_procedure =  "EXEC PRD.zsp_get_data_efficiency_by_period ?, ?";
        // $stored_procedure =  "EXEC PRD.zsp_get_efficiency_worktime_per_losstime ?, ?";

        // $param = array(
        //     'periode' => $period,
        //     'group_product' => $group_product
        // );

        return $this->db->query($query)->result();
    }

    function select_data_downtime_by_period($period, $group_product)
    {

        $stored_procedure =  "EXEC PRD.zsp_get_downtime_per_period_dept ?, ?";

        $param = array(
            'periode' => $period,
            'group_product' => $group_product
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //Report efficiency
    function select_data_mp_per_pcs_by_period($date, $dept_id)
    {

        $stored_procedure = "EXEC PRD.zsp_get_data_mp_per_pcs_by_period ?";
        $param = array(
            'date ' => $date,
            'dept' => $dept_id
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }


    function get_top_work_center_by_dept($dept_crop)
    {
        if ($dept_crop == '011' || $dept_crop == '012' || $dept_crop == '013' || $dept_crop == '014') {
            $query = $this->db->query("select TOP(1) LEFT(PR.CHR_WORK_CENTER,4) CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO AND PP.CHR_PERSON_RESPONSIBLE = $dept_crop
					ORDER BY PR.CHR_WORK_CENTER");
        } else {
            $query = $this->db->query("select TOP(1)LEFT(PR.CHR_WORK_CENTER,4) CHR_WORK_CENTER from  TT_PRODUCTION_RESULT PR INNER JOIN 
					TM_PROCESS_PARTS PP ON PR.CHR_WORK_CENTER = PP.CHR_WORK_CENTER AND PR.CHR_PART_NO = PP.CHR_PART_NO
					ORDER BY PR.CHR_WORK_CENTER");
        }

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return 0;
        }
    }

    function select_data_prod_line_stop($date, $shift)
    {
        $stored_procedure = "EXEC PRD.zsp_get_prod_line_stop ?,?";
        $param = array(
            'date' => $date,
            'shift' => $shift
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function select_data_prod_line_stop_detail($date, $shift)
    {
        $stored_procedure = "EXEC PRD.zsp_get_prod_line_stop_detail ?,?";
        $param = array(
            'date' => $date,
            'shift' => $shift
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_shift()
    {
        $query = $this->db->query("SELECT 1 AS CHR_SHIFT
                UNION
                SELECT 2 AS CHR_SHIFT
                UNION 
                SELECT 3 AS CHR_SHIFT
                UNION
                SELECT 4 AS CHR_SHIFT
            ");

        return $query->result();
    }

    function get_shift_by_date($date)
    {
        $query = $this->db->query("SELECT ISNULL(CHR_SHIFT,0) CHR_SHIFT FROM TT_PRODUCTION_RESULT WHERE CHR_DATE = '$date' GROUP BY CHR_SHIFT ORDER BY CHR_SHIFT");

        return $query->result();
    }

    //MTE
    public function get_data_accumulative_production_using_mold()
    {

        $stored_procedure = "EXEC MTE.zsp_get_data_accumulative_production_using_mold";
        $query = $this->db->query($stored_procedure);
        return $query->result();
    }

    // function select_data_efficiency_productivity_by_period_and_dept($date, $dept_id, $work_center) {
    //         $period = intval($date);

    //         $stored_procedure = "EXEC PRD.zsp_get_data_efficiency_line_stop_by_period ?,?,?";
    //         $param = array(
    //             'periode' => $period,
    //             'dept' => $dept_id,
    //             'work_center' => $work_center);

    //         $query = $this->db->query($stored_procedure, $param);

    //         return $query->result();
    // }

    function select_hourly_productivity_by_date_dept_and_work_center($date, $work_center)
    {
        $period = intval(date('Ymd', strtotime($date)));

        $stored_procedure = "EXEC PRD.zsp_get_qty_part_jam ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function select_hourly_line_stop_by_date_dept_and_work_center($date, $work_center)
    {
        $period = intval(date('Ymd', strtotime($date)));

        $stored_procedure = "EXEC PRD.zsp_get_line_stop_part_jam ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function select_data_prod_qty_by_date_and_dept_and_work_center($date, $work_center)
    {
        $period = intval($date);

        $stored_procedure = "EXEC PRD.zsp_get_qty_part_ok_ng ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //Status Detail NG
    function status_detail_ng_by_date_dept_and_workcenter($date, $work_center)
    {
        $period = intval($date);
        $stored_procedure = "EXEC PRD.zsp_get_detail_ng ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    //NG Detail
    function select_detail_ng_by_date_dept_and_workcenter($date, $work_center)
    {
        $period = intval($date);
        $stored_procedure = "EXEC PRD.zsp_get_detail_ng ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //NG Detail by Back No
    function select_detail_ng_per_part_by_date_dept_and_workcenter($date, $work_center)
    {
        $period = intval($date);
        $stored_procedure = "EXEC PRD.zsp_get_detail_part_ng ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    //Status Detail Line Stop
    function status_detail_line_stop_by_date_and_dept_and_work_center($date, $work_center)
    {
        $period = intval($date);
        $stored_procedure = "EXEC PRD.zsp_get_detail_line_stop ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    //Excel Data Detail NG LINE 
    function select_data_detail_ng_by_date_and_dept_and_work_center_excel($date, $work_center)
    {
        $period = intval($date);

        $stored_procedure = "EXEC PRD.zsp_get_detail_ng ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    //Excel Data Detail Line Stop
    function select_data_detail_line_stop_by_date_and_dept_and_work_center_excel($date, $work_center)
    {
        $period = intval($date);

        $stored_procedure = "EXEC PRD.zsp_get_detail_line_stop ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    //data to export for production master
    // function download_select_data_prod_entry_by_date_and_dept_and_work_center($date, $dept_id, $work_center) {
    //     $period = intval($date);

    //     $stored_procedure = "EXEC PRD.zsp_get_detail_production ?,?,?";
    //     $param = array(
    //         'periode' => $period,
    //         'dept' => $dept_id,
    //         'work_center' => $work_center);

    //     $query = $this->db->query($stored_procedure, $param);

    //     if ($query->num_rows() > 0) {
    //         return $query->result();
    //     } else {
    //         return false;
    //     }
    // }

    function select_data_efficiency_per_week()
    {
        $stored_procedure = "EXEC PRD.zsp_get_data_eff_result_perweek";

        $query = $this->db->query($stored_procedure);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_weekly_report_efficiency_per_week()
    {
        return $this->db->query("DECLARE
        @week1_end varchar(8), 
        @week1_start varchar(8),
        @week2_end varchar(8), 
        @week2_start varchar(8),
        @week3_end varchar(8), 
        @week3_start varchar(8),
        @week4_end varchar(8), 
        @week4_start varchar(8),
        @week5_end varchar(8), 
        @week5_start varchar(8)
        
        SET DATEFIRST 1
        SELECT @week1_end = CONVERT(varchar,DATEADD(DD, 3 - DATEPART(DW, GETDATE()), GETDATE()) ,112)
        
        SELECT @week1_end weekend5
        ,CONVERT(varchar,DATEADD(day, -7, @week1_end),112) weekstart5
        ,CONVERT(varchar,DATEADD(day, -7, @week1_end),112) weekend4
        ,CONVERT(varchar,DATEADD(day, -14, @week1_end),112) weekstart4
        ,CONVERT(varchar,DATEADD(day, -14, @week1_end),112) weekend3
        ,CONVERT(varchar,DATEADD(day, -21, @week1_end),112) weekstart3
        ,CONVERT(varchar,DATEADD(day, -21, @week1_end),112) weekend2
        ,CONVERT(varchar,DATEADD(day, -28, @week1_end),112) weekstart2
        ,CONVERT(varchar,DATEADD(day, -28, @week1_end),112) weekend1
        ,CONVERT(varchar,DATEADD(day, -35, @week1_end),112) weekstart1
        ")->row();
    }

    function select_data_efficiency_per_date($date)
    {
        $stored_procedure = "EXEC PRD.get_data_eff_result_perdate ?";

        $param = array(
            'period' => trim($date)
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function select_summary_man_minutes_perpieces_by_date_dept_and_workcenter($date, $work_center)
    {

        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$date' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$date' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $stored_procedure = "EXEC PRD.zsp_get_summary_man_minutes_per_pieces ?,?,?";
        $param = array(
            'periode_start' => trim($period_start),
            'periode_end' => trim($period_end),
            'work_center' => trim($work_center)
        );

        $query = $this->db->query($stored_procedure, $param);

        // $this->db->_error_message();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function select_data_man_minutes_perpieces_by_date_dept_and_workcenter($date, $work_center)
    {

        $db_report = $this->load->database('db_report', TRUE);

        $query = $db_report->query("SELECT * FROM DB_REPORT.dbo.TR_MAN_MINUTES_PER_PCS WHERE CHR_PERIOD = '$date' AND CHR_WORK_CENTER = '$work_center'");


        // $stored_procedure = "EXEC PRD.zsp_get_detail_man_minutes_per_pieces ?,?";
        // $param = array(
        //     'periode' => $period,
        //     'work_center' => $work_center);

        // $query = $this->db->query($stored_procedure, $param);


        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function select_data_man_minutes_perpieces_by_date_dept_and_workcenter_average($date, $work_center)
    {

        $db_report = $this->load->database('db_report', TRUE);

        $query = $db_report->query("SELECT 
        CAST(
            (DATE_01 +
            DATE_02 +
            DATE_03 +
            DATE_04 +
            DATE_05 +
            DATE_06 +
            DATE_07 +
            DATE_08 +
            DATE_09 +
            DATE_10 +
            DATE_11 +
            DATE_12 +
            DATE_13 +
            DATE_14 +
            DATE_15 +
            DATE_16 +
            DATE_17 +
            DATE_18 +
            DATE_19 +
            DATE_20 +
            DATE_21 +
            DATE_22 +
            DATE_23 +
            DATE_24 +
            DATE_25 +
            DATE_26 +
            DATE_27 +
            DATE_28 +
            DATE_29 +
            DATE_30 +
            DATE_31)
          as decimal(10,2)) / 31 AS AVERAGE
  
        FROM  TR_MAN_MINUTES_PER_PCS 
        WHERE CHR_WORK_CENTER = '$work_center' AND CHR_PERIOD = '$date'");

        // $stored_procedure = "EXEC PRD.zsp_get_detail_man_minutes_per_pieces_average ?,?";
        // $param = array(
        //     'periode' => $period,
        //     'work_center' => $work_center);

        // $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->row()->AVERAGE;
        } else {
            return false;
        }
    }

    function get_fiscal_year_by_period($date)
    {
        $fiscal = $this->db->query("SELECT 
        CHR_FISCAL_YEAR, CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$date' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$date'")->row()->CHR_FISCAL_YEAR;

        return $fiscal;
    }

    function select_summary_ratio_ril_by_date_dept_and_workcenter($date, $work_center)
    {
        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$date' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$date' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $stored_procedure = "EXEC PRD.zsp_get_summary_ratio_ril ?,?,?";
        $param = array(
            'periode_start' => $period_start,
            'periode_end' => $period_end,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function select_data_ratio_ril_by_date_dept_and_workcenter($date, $work_center)
    {
        $period = intval($date);

        $stored_procedure = "EXEC PRD.zsp_get_detail_ratio_ril ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            if ($query->row()->TOTAL > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function select_summary_efficiency_by_date_dept_and_workcenter($date, $work_center)
    {
        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$date' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$date' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $stored_procedure = "EXEC PRD.zsp_get_summary_efficiency ?,?,?";
        $param = array(
            'periode_start' => $period_start,
            'periode_end' => $period_end,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function select_data_efficiency_by_date_dept_and_workcenter($date, $work_center)
    {
        $period = intval($date);

        $stored_procedure = "EXEC PRD.zsp_get_detail_efficiency ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            if ($query->row()->TOTAL > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function select_data_efficiency_by_date_dept_and_workcenter_average($date, $work_center)
    {
        $period = intval($date);

        $stored_procedure = "EXEC PRD.zsp_get_detail_efficiency_average ?,?";
        $param = array(
            'periode' => $period,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->row()->AVERAGE;
        } else {
            return false;
        }
    }

    //Diagram 
    function select_total_part_work_center_by_dept_and_date_and_work_center($date, $work_center)
    {

        // $query = $this->db->query("SELECT PR.CHR_WORK_CENTER, 
        //                                 SUM(PR.INT_TOTAL_QTY) AS INT_TOTAL_QTY, 
        //                                 SUM(PR.INT_TOTAL_NG) AS  INT_TOTAL_QTY_NG,
        //                                 SUM(PR.INT_TOTAL_QTY) + SUM(PR.INT_TOTAL_NG) AS INT_TOTAL,
        //                                 SUBSTRING(PR.CHR_DATE,7,2) AS CHR_DATE
        //                             FROM TT_PRODUCTION_RESULT PR 
        //                             WHERE LEFT(PR.CHR_DATE,6) = '$date'
        //                             AND PR.CHR_WORK_CENTER = '$work_center'
        //                             GROUP BY PR.CHR_WORK_CENTER,PR.CHR_DATE");

        // if ($query->num_rows() > 0) {
        //     return $query->result();
        // } else {
        //     return 0;
        // }

        $stored_procedure = "EXEC PRD.zsp_get_detail_production ?,?";
        $param = array(
            'periode' => $date,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function select_ril_by_period($date)
    {

        $period = intval($date);

        $stored_procedure = "EXEC PRD.zsp_get_ril_by_date ?";
        $param = array('periode' => $period);
        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_daily_ril_by_period_all($period)
    {
        $db_report = $this->load->database('db_report', TRUE);

        $stored_procedure = "EXEC dbo.zsp_get_daily_ril_by_period_all ?";
        $param = array('period' => $period);

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function query_chart_daily_ril_by_date($date, $group_product)
    {

        $db_report = $this->load->database('db_report', TRUE);

        $stored_procedure = "EXEC dbo.zsp_get_daily_ril_by_period ?,?";
        $param = array(
            'period' => $date,
            'product_group' => $group_product,
        );

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function query_chart_daily_ril_by_date_all($date)
    {

        $db_report = $this->load->database('db_report', TRUE);

        $stored_procedure = "EXEC dbo.zsp_get_daily_ril_by_period_all ?";
        $param = array(
            'period' => $date
        );

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function query_chart_ril_by_fiscal($date, $group_product)
    {

        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$date' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$date' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $db_report = $this->load->database('db_report', TRUE);

        $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_chart ?,?,?";
        $param = array(
            'periode_start' => $period_start,
            'periode_end' => $period_end,
            'product_group' => $group_product,
        );

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function query_chart_ril_by_fiscal_all($date)
    {

        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$date' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$date' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $db_report = $this->load->database('db_report', TRUE);

        $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_chart_all ?,?";
        $param = array(
            'periode_start' => $period_start,
            'periode_end' => $period_end
        );

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    // function select_ril_by_fiscal($date, $group_product){

    //     $fiscal = $this->db->query("SELECT 
    //     CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
    //     ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
    //     CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
    //     ELSE CHR_MONTH_END END AS CHR_MONTH_END
    //     FROM CPL.TM_FISCAL 
    //     WHERE 
    //     CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
    //     ELSE CHR_MONTH_START END <= '$date' 
    //     AND 
    //     CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
    //     ELSE CHR_MONTH_END END >= '$date' ")->row();

    //     $period_start = $fiscal->CHR_MONTH_START;
    //     $period_end = $fiscal->CHR_MONTH_END;

    //     $stored_procedure = "EXEC PRD.zsp_get_ril_by_period ?,?,?";
    //     $param = array(
    //         'periode_start' => $period_start,
    //         'periode_end' => $period_end,
    //         'product_group' => $group_product,
    //     );

    //     $query = $this->db->query($stored_procedure, $param);

    //     if ($query->num_rows() > 0) {
    //         return $query;
    //     } else {
    //         return false;
    //     }

    // }

    // function select_ril_by_fiscal_all($date){

    //     $fiscal = $this->db->query("SELECT 
    //     CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
    //     ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
    //     CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
    //     ELSE CHR_MONTH_END END AS CHR_MONTH_END
    //     FROM CPL.TM_FISCAL 
    //     WHERE 
    //     CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
    //     ELSE CHR_MONTH_START END <= '$date' 
    //     AND 
    //     CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
    //     ELSE CHR_MONTH_END END >= '$date' ")->row();

    //     $period_start = $fiscal->CHR_MONTH_START;
    //     $period_end = $fiscal->CHR_MONTH_END;

    //     $stored_procedure = "EXEC PRD.zsp_get_ril_by_period_all ?,?";
    //     $param = array(
    //         'periode_start' => $period_start,
    //         'periode_end' => $period_end
    //     );

    //     $query = $this->db->query($stored_procedure, $param);

    //     if ($query->num_rows() > 0) {
    //         return $query;
    //     } else {
    //         return false;
    //     }

    // }



    function get_data_efficiency_per_group_by_date($group, $date)
    {

        $stored_procedure = "EXEC PRD.get_data_efficiency_per_group_by_date ?,?";
        $param = array(
            'group' => $group,
            'period' => $date
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_data_efficiency_per_group_by_range_date($group, $period)
    {

        $stored_procedure = "EXEC PRD.get_data_efficiency_per_group_by_range_date ?,?";
        $param = array(
            'group' => $group,
            'period' => $period
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_efficiency_per_group_and_period($group, $period)
    {

        $stored_procedure = "EXEC PRD.get_efficiency_per_group_and_period ?,?";
        $param = array(
            'group' => $group,
            'period' => $period
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function select_hourly_efficiency_date_and_work_center($date, $work_center)
    {
        $date = intval(date('Ymd', strtotime($date)));

        $stored_procedure = "EXEC PRD.get_data_efficiency_hourly_by_wc_and_date ?,?";
        $param = array(
            'date' => $date,
            'work_center' => $work_center
        );

        $query = $this->db->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    function get_data_summary_productivity_shift1($date, $work_center, $shift)
    {
        $query = $this->db->query("
        DECLARE @ACT AS TABLE(
            NOROW INT,
            CHR_WORK_CENTER VARCHAR(6),
            CHR_DATE VARCHAR(8),
            INT_SHIFT INT,
            INT_TARGET INT,
            INT_PLAN_CT INT,
            INT_PLAN_TT INT,
            INT_ACTUAL INT
        )
        
        INSERT INTO @ACT
            SELECT ROW_NUMBER() OVER(PARTITION BY CHR_WORK_CENTER ,CHR_DATE , INT_SHIFT 
            ORDER BY CHR_WORK_CENTER ,CHR_DATE, INT_SHIFT ASC, INT_PLAN_CT DESC) AS NOROW,
                CHR_WORK_CENTER, CHR_DATE, INT_SHIFT, INT_TARGET, INT_PLAN_CT, INT_PLAN_TT, INT_ACTUAL FROM PRD.TM_PRODUCTION_ACTIVITY
                WHERE CHR_WORK_CENTER = '$work_center' AND LEFT(CHR_DATE,6) = '$date' AND INT_SHIFT = $shift
        
        DECLARE @PROD AS TABLE(
            DESKRIPSI VARCHAR(20),
            QTY FLOAT,
            DATE VARCHAR(7)
        )
        INSERT INTO @PROD
        SELECT 'Percentage (%)' DESKRIPSI, CAST(NULLIF(INT_PLAN_CT,0) AS FLOAT) / CAST(NULLIF(INT_ACTUAL,0) AS FLOAT) *100 QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        UNION
        SELECT 'Planning' DESKRIPSI, INT_PLAN_CT QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        UNION
        SELECT 'Actual' DESKRIPSI, INT_ACTUAL QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        
        DECLARE @DEPT_ AS TABLE(
            DESKRIPSI VARCHAR(20),
            DATE_01 FLOAT,
            DATE_02 FLOAT,
            DATE_03 FLOAT,
            DATE_04 FLOAT,
            DATE_05 FLOAT,
            DATE_06 FLOAT,
            DATE_07 FLOAT,
            DATE_08 FLOAT,
            DATE_09 FLOAT,
            DATE_10 FLOAT,
            DATE_11 FLOAT,
            DATE_12 FLOAT,
            DATE_13 FLOAT,
            DATE_14 FLOAT,
            DATE_15 FLOAT,
            DATE_16 FLOAT,
            DATE_17 FLOAT,
            DATE_18 FLOAT,
            DATE_19 FLOAT,
            DATE_20 FLOAT,
            DATE_21 FLOAT,
            DATE_22 FLOAT,
            DATE_23 FLOAT,
            DATE_24 FLOAT,
            DATE_25 FLOAT,
            DATE_26 FLOAT,
            DATE_27 FLOAT,
            DATE_28 FLOAT,
            DATE_29 FLOAT,
            DATE_30 FLOAT,
            DATE_31 FLOAT
        )
        INSERT INTO @DEPT_
        SELECT * FROM @PROD
        pivot (
           SUM(QTY)                                                   
           for [DATE] in (DATE_01,DATE_02,DATE_03,DATE_04,DATE_05,DATE_06,DATE_07,DATE_08,DATE_09,DATE_10,DATE_11,DATE_12,DATE_13,DATE_14,DATE_15,DATE_16,DATE_17,DATE_18,DATE_19,DATE_20,DATE_21,DATE_22,DATE_23,DATE_24,DATE_25,DATE_26,DATE_27,DATE_28,DATE_29,DATE_30,DATE_31))        
           as MaxIncomePerDay
           
        SELECT DESKRIPSI, 
                ISNULL(DATE_01,0) as DATE_1,
                ISNULL(DATE_02,0) as DATE_2,
                ISNULL(DATE_03,0) as DATE_3,
                ISNULL(DATE_04,0) as DATE_4,
                ISNULL(DATE_05,0) as DATE_5,
                ISNULL(DATE_06,0) as DATE_6,
                ISNULL(DATE_07,0) as DATE_7,
                ISNULL(DATE_08,0) as DATE_8,
                ISNULL(DATE_09,0) as DATE_9,
                ISNULL(DATE_10,0) as DATE_10,
                ISNULL(DATE_11,0) as DATE_11,
                ISNULL(DATE_12,0) as DATE_12,
                ISNULL(DATE_13,0) as DATE_13,
                ISNULL(DATE_14,0) as DATE_14,
                ISNULL(DATE_15,0) as DATE_15,
                ISNULL(DATE_16,0) as DATE_16,
                ISNULL(DATE_17,0) as DATE_17,
                ISNULL(DATE_18,0) as DATE_18,
                ISNULL(DATE_19,0) as DATE_19,
                ISNULL(DATE_20,0) as DATE_20,
                ISNULL(DATE_21,0) as DATE_21,
                ISNULL(DATE_22,0) as DATE_22,
                ISNULL(DATE_23,0) as DATE_23,
                ISNULL(DATE_24,0) as DATE_24,
                ISNULL(DATE_25,0) as DATE_25,
                ISNULL(DATE_26,0) as DATE_26,
                ISNULL(DATE_27,0) as DATE_27,
                ISNULL(DATE_28,0) as DATE_28,
                ISNULL(DATE_29,0) as DATE_29,
                ISNULL(DATE_30,0) as DATE_30,
                ISNULL(DATE_31,0) as DATE_31
         from @DEPT_ WHERE DESKRIPSI = 'Percentage (%)'");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_data_summary_productivity_shift2($date, $work_center, $shift)
    {
        $query = $this->db->query("
        DECLARE @ACT AS TABLE(
            NOROW INT,
            CHR_WORK_CENTER VARCHAR(6),
            CHR_DATE VARCHAR(8),
            INT_SHIFT INT,
            INT_TARGET INT,
            INT_PLAN_CT INT,
            INT_PLAN_TT INT,
            INT_ACTUAL INT
        )
        
        INSERT INTO @ACT
            SELECT ROW_NUMBER() OVER(PARTITION BY CHR_WORK_CENTER ,CHR_DATE , INT_SHIFT 
            ORDER BY CHR_WORK_CENTER ,CHR_DATE, INT_SHIFT ASC, INT_PLAN_CT DESC) AS NOROW,
                CHR_WORK_CENTER, CHR_DATE, INT_SHIFT, INT_TARGET, INT_PLAN_CT, INT_PLAN_TT, INT_ACTUAL FROM PRD.TM_PRODUCTION_ACTIVITY
                WHERE CHR_WORK_CENTER = '$work_center' AND LEFT(CHR_DATE,6) = '$date' AND INT_SHIFT = $shift
        
        DECLARE @PROD AS TABLE(
            DESKRIPSI VARCHAR(20),
            QTY FLOAT,
            DATE VARCHAR(7)
        )
        INSERT INTO @PROD
        SELECT 'Percentage (%)' DESKRIPSI, CAST(NULLIF(INT_PLAN_CT,0) AS FLOAT) / CAST(NULLIF(INT_ACTUAL,0) AS FLOAT) *100 QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        UNION
        SELECT 'Planning' DESKRIPSI, INT_PLAN_CT QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        UNION
        SELECT 'Actual' DESKRIPSI, INT_ACTUAL QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        
        DECLARE @DEPT_ AS TABLE(
            DESKRIPSI VARCHAR(20),
            DATE_01 FLOAT,
            DATE_02 FLOAT,
            DATE_03 FLOAT,
            DATE_04 FLOAT,
            DATE_05 FLOAT,
            DATE_06 FLOAT,
            DATE_07 FLOAT,
            DATE_08 FLOAT,
            DATE_09 FLOAT,
            DATE_10 FLOAT,
            DATE_11 FLOAT,
            DATE_12 FLOAT,
            DATE_13 FLOAT,
            DATE_14 FLOAT,
            DATE_15 FLOAT,
            DATE_16 FLOAT,
            DATE_17 FLOAT,
            DATE_18 FLOAT,
            DATE_19 FLOAT,
            DATE_20 FLOAT,
            DATE_21 FLOAT,
            DATE_22 FLOAT,
            DATE_23 FLOAT,
            DATE_24 FLOAT,
            DATE_25 FLOAT,
            DATE_26 FLOAT,
            DATE_27 FLOAT,
            DATE_28 FLOAT,
            DATE_29 FLOAT,
            DATE_30 FLOAT,
            DATE_31 FLOAT
        )
        INSERT INTO @DEPT_
        SELECT * FROM @PROD
        pivot (
           SUM(QTY)                                                   
           for [DATE] in (DATE_01,DATE_02,DATE_03,DATE_04,DATE_05,DATE_06,DATE_07,DATE_08,DATE_09,DATE_10,DATE_11,DATE_12,DATE_13,DATE_14,DATE_15,DATE_16,DATE_17,DATE_18,DATE_19,DATE_20,DATE_21,DATE_22,DATE_23,DATE_24,DATE_25,DATE_26,DATE_27,DATE_28,DATE_29,DATE_30,DATE_31))        
           as MaxIncomePerDay
           
        SELECT DESKRIPSI, 
                ISNULL(DATE_01,0) as DATE_1,
                ISNULL(DATE_02,0) as DATE_2,
                ISNULL(DATE_03,0) as DATE_3,
                ISNULL(DATE_04,0) as DATE_4,
                ISNULL(DATE_05,0) as DATE_5,
                ISNULL(DATE_06,0) as DATE_6,
                ISNULL(DATE_07,0) as DATE_7,
                ISNULL(DATE_08,0) as DATE_8,
                ISNULL(DATE_09,0) as DATE_9,
                ISNULL(DATE_10,0) as DATE_10,
                ISNULL(DATE_11,0) as DATE_11,
                ISNULL(DATE_12,0) as DATE_12,
                ISNULL(DATE_13,0) as DATE_13,
                ISNULL(DATE_14,0) as DATE_14,
                ISNULL(DATE_15,0) as DATE_15,
                ISNULL(DATE_16,0) as DATE_16,
                ISNULL(DATE_17,0) as DATE_17,
                ISNULL(DATE_18,0) as DATE_18,
                ISNULL(DATE_19,0) as DATE_19,
                ISNULL(DATE_20,0) as DATE_20,
                ISNULL(DATE_21,0) as DATE_21,
                ISNULL(DATE_22,0) as DATE_22,
                ISNULL(DATE_23,0) as DATE_23,
                ISNULL(DATE_24,0) as DATE_24,
                ISNULL(DATE_25,0) as DATE_25,
                ISNULL(DATE_26,0) as DATE_26,
                ISNULL(DATE_27,0) as DATE_27,
                ISNULL(DATE_28,0) as DATE_28,
                ISNULL(DATE_29,0) as DATE_29,
                ISNULL(DATE_30,0) as DATE_30,
                ISNULL(DATE_31,0) as DATE_31
         from @DEPT_ WHERE DESKRIPSI = 'Percentage (%)'");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_data_summary_productivity_shift3($date, $work_center, $shift)
    {
        $query = $this->db->query("
        DECLARE @ACT AS TABLE(
            NOROW INT,
            CHR_WORK_CENTER VARCHAR(6),
            CHR_DATE VARCHAR(8),
            INT_SHIFT INT,
            INT_TARGET INT,
            INT_PLAN_CT INT,
            INT_PLAN_TT INT,
            INT_ACTUAL INT
        )
        
        INSERT INTO @ACT
            SELECT ROW_NUMBER() OVER(PARTITION BY CHR_WORK_CENTER ,CHR_DATE , INT_SHIFT 
            ORDER BY CHR_WORK_CENTER ,CHR_DATE, INT_SHIFT ASC, INT_PLAN_CT DESC) AS NOROW,
                CHR_WORK_CENTER, CHR_DATE, INT_SHIFT, INT_TARGET, INT_PLAN_CT, INT_PLAN_TT, INT_ACTUAL FROM PRD.TM_PRODUCTION_ACTIVITY
                WHERE CHR_WORK_CENTER = '$work_center' AND LEFT(CHR_DATE,6) = '$date' AND INT_SHIFT = $shift
        
        DECLARE @PROD AS TABLE(
            DESKRIPSI VARCHAR(20),
            QTY FLOAT,
            DATE VARCHAR(7)
        )
        INSERT INTO @PROD
        SELECT 'Percentage (%)' DESKRIPSI, CAST(NULLIF(INT_PLAN_CT,0) AS FLOAT) / CAST(NULLIF(INT_ACTUAL,0) AS FLOAT) *100 QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        UNION
        SELECT 'Planning' DESKRIPSI, INT_PLAN_CT QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        UNION
        SELECT 'Actual' DESKRIPSI, INT_ACTUAL QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        
        DECLARE @DEPT_ AS TABLE(
            DESKRIPSI VARCHAR(20),
            DATE_01 FLOAT,
            DATE_02 FLOAT,
            DATE_03 FLOAT,
            DATE_04 FLOAT,
            DATE_05 FLOAT,
            DATE_06 FLOAT,
            DATE_07 FLOAT,
            DATE_08 FLOAT,
            DATE_09 FLOAT,
            DATE_10 FLOAT,
            DATE_11 FLOAT,
            DATE_12 FLOAT,
            DATE_13 FLOAT,
            DATE_14 FLOAT,
            DATE_15 FLOAT,
            DATE_16 FLOAT,
            DATE_17 FLOAT,
            DATE_18 FLOAT,
            DATE_19 FLOAT,
            DATE_20 FLOAT,
            DATE_21 FLOAT,
            DATE_22 FLOAT,
            DATE_23 FLOAT,
            DATE_24 FLOAT,
            DATE_25 FLOAT,
            DATE_26 FLOAT,
            DATE_27 FLOAT,
            DATE_28 FLOAT,
            DATE_29 FLOAT,
            DATE_30 FLOAT,
            DATE_31 FLOAT
        )
        INSERT INTO @DEPT_
        SELECT * FROM @PROD
        pivot (
           SUM(QTY)                                                   
           for [DATE] in (DATE_01,DATE_02,DATE_03,DATE_04,DATE_05,DATE_06,DATE_07,DATE_08,DATE_09,DATE_10,DATE_11,DATE_12,DATE_13,DATE_14,DATE_15,DATE_16,DATE_17,DATE_18,DATE_19,DATE_20,DATE_21,DATE_22,DATE_23,DATE_24,DATE_25,DATE_26,DATE_27,DATE_28,DATE_29,DATE_30,DATE_31))        
           as MaxIncomePerDay
           
        SELECT DESKRIPSI, 
                ISNULL(DATE_01,0) as DATE_1,
                ISNULL(DATE_02,0) as DATE_2,
                ISNULL(DATE_03,0) as DATE_3,
                ISNULL(DATE_04,0) as DATE_4,
                ISNULL(DATE_05,0) as DATE_5,
                ISNULL(DATE_06,0) as DATE_6,
                ISNULL(DATE_07,0) as DATE_7,
                ISNULL(DATE_08,0) as DATE_8,
                ISNULL(DATE_09,0) as DATE_9,
                ISNULL(DATE_10,0) as DATE_10,
                ISNULL(DATE_11,0) as DATE_11,
                ISNULL(DATE_12,0) as DATE_12,
                ISNULL(DATE_13,0) as DATE_13,
                ISNULL(DATE_14,0) as DATE_14,
                ISNULL(DATE_15,0) as DATE_15,
                ISNULL(DATE_16,0) as DATE_16,
                ISNULL(DATE_17,0) as DATE_17,
                ISNULL(DATE_18,0) as DATE_18,
                ISNULL(DATE_19,0) as DATE_19,
                ISNULL(DATE_20,0) as DATE_20,
                ISNULL(DATE_21,0) as DATE_21,
                ISNULL(DATE_22,0) as DATE_22,
                ISNULL(DATE_23,0) as DATE_23,
                ISNULL(DATE_24,0) as DATE_24,
                ISNULL(DATE_25,0) as DATE_25,
                ISNULL(DATE_26,0) as DATE_26,
                ISNULL(DATE_27,0) as DATE_27,
                ISNULL(DATE_28,0) as DATE_28,
                ISNULL(DATE_29,0) as DATE_29,
                ISNULL(DATE_30,0) as DATE_30,
                ISNULL(DATE_31,0) as DATE_31
         from @DEPT_ WHERE DESKRIPSI = 'Percentage (%)'");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_data_summary_productivity_shift4($date, $work_center, $shift)
    {
        $query = $this->db->query("
        DECLARE @ACT AS TABLE(
            NOROW INT,
            CHR_WORK_CENTER VARCHAR(6),
            CHR_DATE VARCHAR(8),
            INT_SHIFT INT,
            INT_TARGET INT,
            INT_PLAN_CT INT,
            INT_PLAN_TT INT,
            INT_ACTUAL INT
        )
        
        INSERT INTO @ACT
            SELECT ROW_NUMBER() OVER(PARTITION BY CHR_WORK_CENTER ,CHR_DATE , INT_SHIFT 
            ORDER BY CHR_WORK_CENTER ,CHR_DATE, INT_SHIFT ASC, INT_PLAN_CT DESC) AS NOROW,
                CHR_WORK_CENTER, CHR_DATE, INT_SHIFT, INT_TARGET, INT_PLAN_CT, INT_PLAN_TT, INT_ACTUAL FROM PRD.TM_PRODUCTION_ACTIVITY
                WHERE CHR_WORK_CENTER = '$work_center' AND LEFT(CHR_DATE,6) = '$date' AND INT_SHIFT = $shift
        
        DECLARE @PROD AS TABLE(
            DESKRIPSI VARCHAR(20),
            QTY FLOAT,
            DATE VARCHAR(7)
        )
        INSERT INTO @PROD
        SELECT 'Percentage (%)' DESKRIPSI, CAST(NULLIF(INT_PLAN_CT,0) AS FLOAT) / CAST(NULLIF(INT_ACTUAL,0) AS FLOAT) *100 QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        UNION
        SELECT 'Planning' DESKRIPSI, INT_PLAN_CT QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        UNION
        SELECT 'Actual' DESKRIPSI, INT_ACTUAL QTY, 'DATE_'+CAST(RIGHT(CHR_DATE,2) AS VARCHAR(6)) AS DATE FROM @ACT WHERE NOROW = 1
        
        DECLARE @DEPT_ AS TABLE(
            DESKRIPSI VARCHAR(20),
            DATE_01 FLOAT,
            DATE_02 FLOAT,
            DATE_03 FLOAT,
            DATE_04 FLOAT,
            DATE_05 FLOAT,
            DATE_06 FLOAT,
            DATE_07 FLOAT,
            DATE_08 FLOAT,
            DATE_09 FLOAT,
            DATE_10 FLOAT,
            DATE_11 FLOAT,
            DATE_12 FLOAT,
            DATE_13 FLOAT,
            DATE_14 FLOAT,
            DATE_15 FLOAT,
            DATE_16 FLOAT,
            DATE_17 FLOAT,
            DATE_18 FLOAT,
            DATE_19 FLOAT,
            DATE_20 FLOAT,
            DATE_21 FLOAT,
            DATE_22 FLOAT,
            DATE_23 FLOAT,
            DATE_24 FLOAT,
            DATE_25 FLOAT,
            DATE_26 FLOAT,
            DATE_27 FLOAT,
            DATE_28 FLOAT,
            DATE_29 FLOAT,
            DATE_30 FLOAT,
            DATE_31 FLOAT
        )
        INSERT INTO @DEPT_
        SELECT * FROM @PROD
        pivot (
           SUM(QTY)                                                   
           for [DATE] in (DATE_01,DATE_02,DATE_03,DATE_04,DATE_05,DATE_06,DATE_07,DATE_08,DATE_09,DATE_10,DATE_11,DATE_12,DATE_13,DATE_14,DATE_15,DATE_16,DATE_17,DATE_18,DATE_19,DATE_20,DATE_21,DATE_22,DATE_23,DATE_24,DATE_25,DATE_26,DATE_27,DATE_28,DATE_29,DATE_30,DATE_31))        
           as MaxIncomePerDay
           
        SELECT DESKRIPSI, 
                ISNULL(DATE_01,0) as DATE_1,
                ISNULL(DATE_02,0) as DATE_2,
                ISNULL(DATE_03,0) as DATE_3,
                ISNULL(DATE_04,0) as DATE_4,
                ISNULL(DATE_05,0) as DATE_5,
                ISNULL(DATE_06,0) as DATE_6,
                ISNULL(DATE_07,0) as DATE_7,
                ISNULL(DATE_08,0) as DATE_8,
                ISNULL(DATE_09,0) as DATE_9,
                ISNULL(DATE_10,0) as DATE_10,
                ISNULL(DATE_11,0) as DATE_11,
                ISNULL(DATE_12,0) as DATE_12,
                ISNULL(DATE_13,0) as DATE_13,
                ISNULL(DATE_14,0) as DATE_14,
                ISNULL(DATE_15,0) as DATE_15,
                ISNULL(DATE_16,0) as DATE_16,
                ISNULL(DATE_17,0) as DATE_17,
                ISNULL(DATE_18,0) as DATE_18,
                ISNULL(DATE_19,0) as DATE_19,
                ISNULL(DATE_20,0) as DATE_20,
                ISNULL(DATE_21,0) as DATE_21,
                ISNULL(DATE_22,0) as DATE_22,
                ISNULL(DATE_23,0) as DATE_23,
                ISNULL(DATE_24,0) as DATE_24,
                ISNULL(DATE_25,0) as DATE_25,
                ISNULL(DATE_26,0) as DATE_26,
                ISNULL(DATE_27,0) as DATE_27,
                ISNULL(DATE_28,0) as DATE_28,
                ISNULL(DATE_29,0) as DATE_29,
                ISNULL(DATE_30,0) as DATE_30,
                ISNULL(DATE_31,0) as DATE_31
         from @DEPT_ WHERE DESKRIPSI = 'Percentage (%)'");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return 0;
        }
    }

    function get_data_pivot_production_result_by_period_and_group($period, $group_product)
    {

        $stored_procedure = "EXEC PRD.zsp_get_data_production_result_by_period_and_group ?,?";
        $param = array(
            'periode' => $period,
            'group_line' => $group_product
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_data_ratio_ril_qty_amount_by_period($period)
    {

        $stored_procedure = "EXEC PRD.zsp_get_ratio_ril_qty_and_amount_by_period ?";
        $param = array(
            'periode' => $period
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_data_ratio_ril_qty_amount_by_period_and_wc($period, $work_center)
    {

        if ($work_center != 'ALL') {
            $stored_procedure = "EXEC PRD.zsp_get_ratio_ril_qty_and_amount_by_period_and_wc ?,?";
            $param = array(
                'periode' => $period,
                'work_center' => $work_center
            );
        } else {
            $stored_procedure = "EXEC PRD.zsp_get_ratio_ril_detail_by_period ?";
            $param = array(
                'periode' => $period
            );
        }

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_data_ratio_ril_qty_amount_by_between_period($start_date, $end_date)
    {

        $stored_procedure = "EXEC PRD.zsp_get_ratio_ril_qty_and_amount_by_between_period ?,?";
        $param = array(
            'date_start' => $start_date,
            'date_end' => $end_date
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_data_oee_by_period($period)
    {

        $stored_procedure = "EXEC PRD.zsp_get_data_production_oee ?";
        $param = array(
            'date' => $period
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    public function get_performance_production($period)
    {
        $stored_procedure = "EXEC PRD.zsp_get_data_performance_production ?";
        $param = array(
            'date' => $period
        );

        $query = $this->db->query($stored_procedure, $param);

        return $query->result();
    }

    function get_daily_ril_by_period_and_type($type, $period, $group_product)
    {

        $db_report = $this->load->database('db_report', TRUE);

        switch ($type) {
            case 'Process':
                $stored_procedure = "EXEC dbo.zsp_get_daily_ril_pr_by_period ?,?";
                break;
            case 'Setup':
                $stored_procedure = "EXEC dbo.zsp_get_daily_ril_st_by_period ?,?";
                break;
            case 'Trial':
                $stored_procedure = "EXEC dbo.zsp_get_daily_ril_tr_by_period ?,?";
                break;
            case 'Broken Test':
                $stored_procedure = "EXEC dbo.zsp_get_daily_ril_bt_by_period ?,?";
                break;
        }

        $param = array('period' => $period, 'product_group' => $group_product,);

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function get_daily_ril_by_period_and_type_all($type, $period)
    {

        $db_report = $this->load->database('db_report', TRUE);

        switch ($type) {
            case 'Process':
                $stored_procedure = "EXEC dbo.zsp_get_daily_ril_pr_by_period_all ?";
                break;
            case 'Setup':
                $stored_procedure = "EXEC dbo.zsp_get_daily_ril_st_by_period_all ?";
                break;
            case 'Trial':
                $stored_procedure = "EXEC dbo.zsp_get_daily_ril_tr_by_period_all ?";
                break;
            case 'Broken Test':
                $stored_procedure = "EXEC dbo.zsp_get_daily_ril_bt_by_period_all ?";
                break;
        }

        $param = array('period' => $period);

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function query_chart_ril_by_fiscal_and_type($type, $date, $group_product)
    {

        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$date' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$date' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $db_report = $this->load->database('db_report', TRUE);

        switch ($type) {
            case 'Process':
                $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_and_pr_chart ?,?,?";
                break;
            case 'Setup':
                $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_and_st_chart ?,?,?";
                break;
            case 'Trial':
                $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_and_tr_chart ?,?,?";
                break;
            case 'Broken Test':
                $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_and_bt_chart ?,?,?";
                break;
        }

        $param = array(
            'periode_start' => $period_start,
            'periode_end' => $period_end,
            'product_group' => $group_product,
        );

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function query_chart_ril_by_fiscal_and_type_all($type, $date)
    {

        $fiscal = $this->db->query("SELECT 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END AS CHR_MONTH_START, 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END AS CHR_MONTH_END
        FROM CPL.TM_FISCAL 
        WHERE 
        CASE WHEN LEN(CHR_MONTH_START) = 1 THEN CHR_FISCAL_YEAR_START+'0'+CHR_MONTH_START 
        ELSE CHR_MONTH_START END <= '$date' 
        AND 
        CASE WHEN LEN(CHR_MONTH_END) = 1 THEN CHR_FISCAL_YEAR_END+'0'+CHR_MONTH_END 
        ELSE CHR_MONTH_END END >= '$date' ")->row();

        $period_start = $fiscal->CHR_MONTH_START;
        $period_end = $fiscal->CHR_MONTH_END;

        $db_report = $this->load->database('db_report', TRUE);

        switch ($type) {
            case 'Process':
                $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_and_pr_chart_all ?,?";
                break;
            case 'Setup':
                $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_and_st_chart_all ?,?";
                break;
            case 'Trial':
                $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_and_tr_chart_all ?,?";
                break;
            case 'Broken Test':
                $stored_procedure = "EXEC dbo.zsp_get_ril_by_period_and_bt_chart_all ?,?";
                break;
        }

        $param = array(
            'periode_start' => $period_start,
            'periode_end' => $period_end
        );

        $query = $db_report->query($stored_procedure, $param);

        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getLastMergeProductionResult()
    {
        $db_report = $this->load->database('db_report', TRUE);
        $query = $db_report->query("SELECT TOP 1 CHR_MODIFIED_DATE , CHR_MODIFIED_TIME FROM DB_REPORT.dbo.TR_PRODUCTION_RESULT ORDER BY INT_ID DESC")->row();

        return $query;
    }
}
