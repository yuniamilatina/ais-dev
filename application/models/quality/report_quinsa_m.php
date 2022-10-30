<?php

class report_quinsa_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function get_user()
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$hasil = $dbqua->query("select * from TM_USER order by CHR_NPK asc");
		return $hasil->result();
	}

	function save($data)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$dbqua->insert('TM_USER', $data);
	}

	function get_partno_by_wc($wc)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT distinct CHR_PARTNO as CHR_PART_NO,CHR_BACKNO as CHR_BACK_NO FROM TM_INSPECTION_PLAN_H WHERE CHR_WORK_CTR='$wc' and CHR_STAT_DEL='F' and CHR_STAT_LIST='T'");
		return $query->result();
	}

	function get_item_cek($work_center, $partno)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT distinct B.CHR_CHECK_POINT,B.CHR_DOC_ID,cast(B.CHR_SEQ as int) as CHR_SEQ FROM TM_INSPECTION_PLAN_H A INNER JOIN 
								TM_INSPECTION_PLAN_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID WHERE A.CHR_WORK_CTR='$work_center' and A.CHR_PARTNO='$partno' and B.CHR_STAT_DEL = 'F'
								ORDER BY cast(B.CHR_SEQ as int) ASC");

		return $query->result();
	}

	function select_data_range_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_PARTNO, MIN(B.CHR_RESULT) AS MIN_VAL,MAX(B.CHR_RESULT) AS MAX_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='RANGE'
							GROUP BY A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR ORDER BY A.CHR_CREATED_DATE ASC");
		
		return $query->result();
	}

	function select_data_max_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_PARTNO,MAX(B.CHR_RESULT) AS MAX_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='MAX'
							GROUP BY A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR ORDER BY A.CHR_CREATED_DATE ASC");
		
		return $query->result();
	}

	function select_data_min_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_PARTNO,MIN(B.CHR_RESULT) AS MIN_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='MIN'
							GROUP BY A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR ORDER BY A.CHR_CREATED_DATE ASC");
		
		return $query->result();
	}

	function select_data_ok_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_DOC_ID,A.CHR_PARTNO,B.CHR_RESULT,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY,B.CHR_QLT_CL 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_QLT_CL='OK'
							 ORDER BY A.CHR_CREATED_DATE DESC, A.CHR_LOT_NOMOR DESC, B.CHR_STRATEGY ASC");
		return $query->result();
	}

	function select_data_all_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_DOC_ID, A.CHR_REF_MASTER, A.CHR_LOT_NOMOR, A.CHR_WORK_CTR, A.CHR_PARTNO, A.CHR_PART_NM, A.CHR_MODEL_NM,
								A.CHR_EXEC_BY, A.CHR_INSPEC_TYPE, A.CHR_CREATED_DATE AS CHR_DOC_CREATED_DATE, A.CHR_CREATED_TIME AS CHR_DOC_CREATED_TIME, A.CHR_CREATE_BY  AS CHR_DOC_CREATE_BY, 
								B.CHR_SEQ, B.CHR_RECORD_TYPE, B.CHR_DEVICE_ID, B.CHR_SAMPLING, B.CHR_REPETITION,
								B.CHR_CHECK_POINT, B.CHR_TYPE, B.CHR_SPECIAL_CHAR, B.CHR_CONTROL, B.CHR_TARGET_SL, B.CHR_LSL, B.CHR_RANGE_SL, B.CHR_USL, B.CHR_UOM_SL,
								B.CHR_TARGET_CL, B.CHR_LCL, B.CHR_RANGE_CL, B.CHR_UCL, B.CHR_UOM_CL, B.CHR_QLT_CL, B.CHR_QLT_VAL, B.CHR_RESULT, 
								B.CHR_REMARK, B.CHR_STATUS, B.CHR_STRATEGY, B.CHR_CREATE_DATE, B.CHR_CREATED_TIME, B.CHR_CREATE_BY
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno'
							 ORDER BY A.CHR_CREATED_DATE DESC, A.CHR_LOT_NOMOR DESC, B.CHR_STRATEGY ASC");
		return $query->result();
	}

	function select_data_yes_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_DOC_ID,A.CHR_PARTNO,B.CHR_RESULT,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY,B.CHR_QLT_CL 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_QLT_CL='YES'
							 ORDER BY A.CHR_CREATED_DATE DESC, A.CHR_LOT_NOMOR DESC, B.CHR_STRATEGY ASC");
		return $query->result();
	}

	function get_data_range_by_row($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$sql = "SELECT A.CHR_DOC_ID,A.CHR_PARTNO,MIN(B.CHR_RESULT) AS MIN_VAL,MAX(B.CHR_RESULT) AS MAX_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno'  and B.CHR_CONTROL='RANGE'
							GROUP BY A.CHR_DOC_ID,A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY ORDER BY A.CHR_CREATED_DATE ASC";
		return $dbqua->query($sql)->row();
	}

	function get_data_max_by_row($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$sql = "SELECT A.CHR_DOC_ID,A.CHR_PARTNO,MAX(B.CHR_RESULT) AS MAX_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno'  and B.CHR_CONTROL='MAX'
							GROUP BY A.CHR_DOC_ID,A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY ORDER BY A.CHR_CREATED_DATE ASC";
		return $dbqua->query($sql)->row();
	}

	function get_data_min_by_row($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$sql = "SELECT A.CHR_DOC_ID,A.CHR_PARTNO,MIN(B.CHR_RESULT) AS MIN_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno'  and B.CHR_CONTROL='MIN'
							GROUP BY A.CHR_DOC_ID,A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY ORDER BY A.CHR_CREATED_DATE ASC";
		return $dbqua->query($sql)->row();
	}

	function get_npk()
	{
		return $this->db->query('SELECT DISTINCT CHR_NPK FROM TM_USER where CHR_NPK<>"0000"')->result();
	}

	function get_nama($npk)
	{
		$query = $this->db->query("SELECT DISTINCT CHR_USERNAME FROM TM_USER where CHR_NPK='$npk'")->row_array();
		$username = $query['CHR_USERNAME'];
		return $username;
	}

	function check_data($npk)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT top 1 * FROM TM_USER WHERE CHR_NPK = '$npk'");

		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	function get_data($id)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT TOP(1) * FROM TM_USER WHERE INT_ID = '$id'");

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}
	}

	function edit_data($data, $id)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$dbqua->where('INT_ID', $id);
		$dbqua->update('TM_USER', $data);
	}

	function delete_user($doc_id)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$data = array(
			'CHR_STAT_DEL' => 'T',
		);

		$dbqua->where('INT_ID', $doc_id);
		$dbqua->update('TM_USER', $data);
	}

	function undel_user($doc_id)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$data = array(
			'CHR_STAT_DEL' => 'F',
		);

		$dbqua->where('INT_ID', $doc_id);
		$dbqua->update('TM_USER', $data);
	}

	public function get_data_qcwis_by_daily($period, $work_center, $part_no)
    {

        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query(";WITH MAIN_DATA_CTE (CHR_CHECK_POINT, CHR_LSL, CHR_USL, CHR_UOM, INT_TARGET, INT_RANGE, CHR_MIN_DATE, CHR_MAX_DATE, MIN_VAL, MAX_VAL ) AS (
            SELECT CHR_CHECK_POINT, CONVERT(FLOAT,CHR_LSL), CONVERT(FLOAT,CHR_USL), CHR_UOM_SL, CHR_TARGET_SL, CHR_RANGE_SL,
			'MIN_'+CAST(RIGHT(A.CHR_CREATED_DATE,2) AS VARCHAR(6)) AS CHR_MIN_DATE, 
            'MAX_'+CAST(RIGHT(A.CHR_CREATED_DATE,2) AS VARCHAR(6)) AS CHR_MAX_DATE, 
            MIN(CONVERT(FLOAT, CHR_RESULT)),  MAX(CONVERT(FLOAT, CHR_RESULT))
            FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
            WHERE CHR_WORK_CTR = '$work_center' AND LEFT(A.CHR_CREATED_DATE,6) = '$period'
			AND A.CHR_PARTNO='$part_no' AND B.CHR_CONTROL <> ''
			GROUP BY CONVERT(FLOAT,CHR_LSL), CONVERT(FLOAT,CHR_USL), CHR_UOM_SL, CHR_TARGET_SL, CHR_RANGE_SL, CHR_CHECK_POINT, A.CHR_CREATED_DATE 
), PIVOT_CTE (CHR_CHECK_POINT, CHR_LSL, CHR_USL, CHR_UOM, INT_TARGET, INT_RANGE, 
MAX_01,MAX_02,MAX_03,MAX_04,MAX_05,MAX_06,MAX_07,MAX_08,MAX_09,MAX_10,MAX_11,MAX_12,MAX_13,MAX_14,MAX_15,MAX_16,MAX_17,MAX_18,MAX_19,MAX_20,MAX_21,MAX_22,MAX_23,MAX_24,MAX_25,MAX_26,MAX_27,MAX_28,MAX_29,MAX_30,MAX_31,
MIN_01,MIN_02,MIN_03,MIN_04,MIN_05,MIN_06,MIN_07,MIN_08,MIN_09,MIN_10,MIN_11,MIN_12,MIN_13,MIN_14,MIN_15,MIN_16,MIN_17,MIN_18,MIN_19,MIN_20,MIN_21,MIN_22,MIN_23,MIN_24,MIN_25,MIN_26,MIN_27,MIN_28,MIN_29,MIN_30,MIN_31) AS (
        SELECT * FROM MAIN_DATA_CTE
		PIVOT (
           SUM(MAX_VAL)                                                
           FOR CHR_MAX_DATE IN (MAX_01,MAX_02,MAX_03,MAX_04,MAX_05,MAX_06,MAX_07,MAX_08,MAX_09,MAX_10,MAX_11,MAX_12,MAX_13,MAX_14,MAX_15,MAX_16,MAX_17,MAX_18,MAX_19,MAX_20,MAX_21,MAX_22,MAX_23,MAX_24,MAX_25,MAX_26,MAX_27,MAX_28,MAX_29,MAX_30,MAX_31)
           ) AS MAX_VAL
		PIVOT (
           SUM(MIN_VAL)                                                
           FOR CHR_MIN_DATE IN (MIN_01,MIN_02,MIN_03,MIN_04,MIN_05,MIN_06,MIN_07,MIN_08,MIN_09,MIN_10,MIN_11,MIN_12,MIN_13,MIN_14,MIN_15,MIN_16,MIN_17,MIN_18,MIN_19,MIN_20,MIN_21,MIN_22,MIN_23,MIN_24,MIN_25,MIN_26,MIN_27,MIN_28,MIN_29,MIN_30,MIN_31)
           ) AS MIN_VAL
)
         SELECT REPLACE(RTRIM(CHR_CHECK_POINT),' ','') CHECK_POINT_ID, CHR_CHECK_POINT, CHR_LSL, CHR_USL, CASE CHR_LSL WHEN 0 THEN 0 ELSE CHR_LSL END AS LOWL, CHR_USL + 0.3 AS UPPL, CHR_UOM, INT_TARGET, INT_RANGE,
             ISNULL(SUM(MAX_01),0) MAX_01,ISNULL(SUM(MAX_02),0) MAX_02,ISNULL(SUM(MAX_03),0) MAX_03,ISNULL(SUM(MAX_04),0) MAX_04,ISNULL(SUM(MAX_05),0) MAX_05,
             ISNULL(SUM(MAX_06),0) MAX_06,ISNULL(SUM(MAX_07),0) MAX_07,ISNULL(SUM(MAX_08),0) MAX_08,ISNULL(SUM(MAX_09),0) MAX_09,ISNULL(SUM(MAX_10),0) MAX_10,
             ISNULL(SUM(MAX_11),0) MAX_11,ISNULL(SUM(MAX_12),0) MAX_12,ISNULL(SUM(MAX_13),0) MAX_13,ISNULL(SUM(MAX_14),0) MAX_14,ISNULL(SUM(MAX_15),0) MAX_15,
             ISNULL(SUM(MAX_16),0) MAX_16,ISNULL(SUM(MAX_17),0) MAX_17,ISNULL(SUM(MAX_18),0) MAX_18,ISNULL(SUM(MAX_19),0) MAX_19,ISNULL(SUM(MAX_20),0) MAX_20,
             ISNULL(SUM(MAX_21),0) MAX_21,ISNULL(SUM(MAX_22),0) MAX_22,ISNULL(SUM(MAX_23),0) MAX_23,ISNULL(SUM(MAX_24),0) MAX_24,ISNULL(SUM(MAX_25),0) MAX_25,
             ISNULL(SUM(MAX_26),0) MAX_26,ISNULL(SUM(MAX_27),0) MAX_27,ISNULL(SUM(MAX_28),0) MAX_28,ISNULL(SUM(MAX_29),0) MAX_29,ISNULL(SUM(MAX_30),0) MAX_30,
             ISNULL(SUM(MAX_31),0) MAX_31,
             ISNULL(SUM(MIN_01),0) MIN_01,ISNULL(SUM(MIN_02),0) MIN_02,ISNULL(SUM(MIN_03),0) MIN_03,ISNULL(SUM(MIN_04),0) MIN_04,ISNULL(SUM(MIN_05),0) MIN_05,
             ISNULL(SUM(MIN_06),0) MIN_06,ISNULL(SUM(MIN_07),0) MIN_07,ISNULL(SUM(MIN_08),0) MIN_08,ISNULL(SUM(MIN_09),0) MIN_09,ISNULL(SUM(MIN_10),0) MIN_10,
             ISNULL(SUM(MIN_11),0) MIN_11,ISNULL(SUM(MIN_12),0) MIN_12,ISNULL(SUM(MIN_13),0) MIN_13,ISNULL(SUM(MIN_14),0) MIN_14,ISNULL(SUM(MIN_15),0) MIN_15,
             ISNULL(SUM(MIN_16),0) MIN_16,ISNULL(SUM(MIN_17),0) MIN_17,ISNULL(SUM(MIN_18),0) MIN_18,ISNULL(SUM(MIN_19),0) MIN_19,ISNULL(SUM(MIN_20),0) MIN_20,
             ISNULL(SUM(MIN_21),0) MIN_21,ISNULL(SUM(MIN_22),0) MIN_22,ISNULL(SUM(MIN_23),0) MIN_23,ISNULL(SUM(MIN_24),0) MIN_24,ISNULL(SUM(MIN_25),0) MIN_25,
             ISNULL(SUM(MIN_26),0) MIN_26,ISNULL(SUM(MIN_27),0) MIN_27,ISNULL(SUM(MIN_28),0) MIN_28,ISNULL(SUM(MIN_29),0) MIN_29,ISNULL(SUM(MIN_30),0) MIN_30,
             ISNULL(SUM(MIN_31),0) MIN_31
         FROM PIVOT_CTE
		 GROUP BY CHR_CHECK_POINT, CHR_LSL, CHR_USL, CHR_UOM, INT_TARGET, INT_RANGE
        ");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

	public function get_data_qcwis_by_hourly($work_center, $date, $part_no)
    {

        $dbqua = $this->load->database("dbqua", TRUE);
        $query = $dbqua->query(";WITH MAIN_DATA_CTE (CHR_CHECK_POINT, CHR_LSL, CHR_USL, CHR_UOM, INT_TARGET, INT_RANGE, CHR_MIN_DATE, CHR_MAX_DATE, MIN_VAL, MAX_VAL ) AS (

            SELECT CHR_CHECK_POINT, CONVERT(FLOAT,CHR_LSL), CONVERT(FLOAT,CHR_USL), CHR_UOM_SL, CHR_TARGET_SL, CHR_RANGE_SL,
			'MIN_'+CAST(LEFT(A.CHR_CREATED_TIME,2) AS VARCHAR(6)) AS CHR_MIN_HOUR, 
            'MAX_'+CAST(LEFT(A.CHR_CREATED_TIME,2) AS VARCHAR(6)) AS CHR_MAX_HOUR, 
            MIN(CONVERT(FLOAT, CHR_RESULT)),  MAX(CONVERT(FLOAT, CHR_RESULT))
            FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
            WHERE CHR_WORK_CTR = '$work_center' AND A.CHR_CREATED_DATE = '$date'
			AND A.CHR_PARTNO='$part_no' AND B.CHR_CONTROL <> ''
			GROUP BY CONVERT(FLOAT,CHR_LSL), CONVERT(FLOAT,CHR_USL), CHR_UOM_SL, CHR_TARGET_SL,
			CHR_RANGE_SL, CHR_CHECK_POINT, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME
			
), PIVOT_CTE (CHR_CHECK_POINT, CHR_LSL, CHR_USL, CHR_UOM, INT_TARGET, INT_RANGE, 
MAX_01,MAX_02,MAX_03,MAX_04,MAX_05,MAX_06,MAX_07,MAX_08,MAX_09,MAX_10,MAX_11,MAX_12,MAX_13,MAX_14,MAX_15,MAX_16,MAX_17,MAX_18,MAX_19,MAX_20,MAX_21,MAX_22,MAX_23,MAX_24,
MIN_01,MIN_02,MIN_03,MIN_04,MIN_05,MIN_06,MIN_07,MIN_08,MIN_09,MIN_10,MIN_11,MIN_12,MIN_13,MIN_14,MIN_15,MIN_16,MIN_17,MIN_18,MIN_19,MIN_20,MIN_21,MIN_22,MIN_23,MIN_24) AS (
        SELECT * FROM MAIN_DATA_CTE
		PIVOT (
           MAX(MAX_VAL)                                                
           FOR CHR_MAX_DATE IN (MAX_01,MAX_02,MAX_03,MAX_04,MAX_05,MAX_06,MAX_07,MAX_08,MAX_09,MAX_10,MAX_11,MAX_12,MAX_13,MAX_14,MAX_15,MAX_16,MAX_17,MAX_18,MAX_19,MAX_20,MAX_21,MAX_22,MAX_23,MAX_24)
           ) AS MAX_VAL
		PIVOT (
           MIN(MIN_VAL)                                                
           FOR CHR_MIN_DATE IN (MIN_01,MIN_02,MIN_03,MIN_04,MIN_05,MIN_06,MIN_07,MIN_08,MIN_09,MIN_10,MIN_11,MIN_12,MIN_13,MIN_14,MIN_15,MIN_16,MIN_17,MIN_18,MIN_19,MIN_20,MIN_21,MIN_22,MIN_23,MIN_24)
           ) AS MIN_VAL
)
         SELECT REPLACE(RTRIM(CHR_CHECK_POINT),' ','') CHECK_POINT_ID, CHR_CHECK_POINT, CHR_LSL, CHR_USL, CASE CHR_LSL WHEN 0 THEN 0 ELSE CHR_LSL END AS LOWL, CHR_USL + 0.3 AS UPPL, CHR_UOM, INT_TARGET, INT_RANGE,
             ISNULL(SUM(MAX_01),0) MAX_01,ISNULL(SUM(MAX_02),0) MAX_02,ISNULL(SUM(MAX_03),0) MAX_03,ISNULL(SUM(MAX_04),0) MAX_04,ISNULL(SUM(MAX_05),0) MAX_05,
             ISNULL(SUM(MAX_06),0) MAX_06,ISNULL(SUM(MAX_07),0) MAX_07,ISNULL(SUM(MAX_08),0) MAX_08,ISNULL(SUM(MAX_09),0) MAX_09,ISNULL(SUM(MAX_10),0) MAX_10,
             ISNULL(SUM(MAX_11),0) MAX_11,ISNULL(SUM(MAX_12),0) MAX_12,ISNULL(SUM(MAX_13),0) MAX_13,ISNULL(SUM(MAX_14),0) MAX_14,ISNULL(SUM(MAX_15),0) MAX_15,
             ISNULL(SUM(MAX_16),0) MAX_16,ISNULL(SUM(MAX_17),0) MAX_17,ISNULL(SUM(MAX_18),0) MAX_18,ISNULL(SUM(MAX_19),0) MAX_19,ISNULL(SUM(MAX_20),0) MAX_20,
             ISNULL(SUM(MAX_21),0) MAX_21,ISNULL(SUM(MAX_22),0) MAX_22,ISNULL(SUM(MAX_23),0) MAX_23,ISNULL(SUM(MAX_24),0) MAX_24,
             ISNULL(SUM(MIN_01),0) MIN_01,ISNULL(SUM(MIN_02),0) MIN_02,ISNULL(SUM(MIN_03),0) MIN_03,ISNULL(SUM(MIN_04),0) MIN_04,ISNULL(SUM(MIN_05),0) MIN_05,
             ISNULL(SUM(MIN_06),0) MIN_06,ISNULL(SUM(MIN_07),0) MIN_07,ISNULL(SUM(MIN_08),0) MIN_08,ISNULL(SUM(MIN_09),0) MIN_09,ISNULL(SUM(MIN_10),0) MIN_10,
             ISNULL(SUM(MIN_11),0) MIN_11,ISNULL(SUM(MIN_12),0) MIN_12,ISNULL(SUM(MIN_13),0) MIN_13,ISNULL(SUM(MIN_14),0) MIN_14,ISNULL(SUM(MIN_15),0) MIN_15,
             ISNULL(SUM(MIN_16),0) MIN_16,ISNULL(SUM(MIN_17),0) MIN_17,ISNULL(SUM(MIN_18),0) MIN_18,ISNULL(SUM(MIN_19),0) MIN_19,ISNULL(SUM(MIN_20),0) MIN_20,
             ISNULL(SUM(MIN_21),0) MIN_21,ISNULL(SUM(MIN_22),0) MIN_22,ISNULL(SUM(MIN_23),0) MIN_23,ISNULL(SUM(MIN_24),0) MIN_24
         FROM PIVOT_CTE
		 GROUP BY CHR_CHECK_POINT, CHR_LSL, CHR_USL, CHR_UOM, INT_TARGET, INT_RANGE");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

	function get_list_partno_by_wc($wcenter, $date)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT DISTINCT A.CHR_PARTNO, B.CHR_BACK_NO 
					FROM TT_QUA_INSPECTION_H A 
					INNER JOIN (SELECT DISTINCT CHR_PART_NO, CHR_BACK_NO 
							FROM DB_AIS.dbo.TM_KANBAN
							WHERE CHR_KANBAN_TYPE IN ('1','5') AND CHR_FLAG_DELETE IS NULL) B ON A.CHR_PARTNO = B.CHR_PART_NO 
					WHERE A.CHR_WORK_CTR = '$wcenter' AND A.CHR_CREATED_DATE = '$date'");

		return $query;
	}

	function select_data_all_by_date_and_partno($date, $work_center, $partno)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_DOC_ID, A.CHR_REF_MASTER, A.CHR_LOT_NOMOR, A.CHR_WORK_CTR, A.CHR_PARTNO, A.CHR_PART_NM, A.CHR_MODEL_NM,
								A.CHR_EXEC_BY, A.CHR_INSPEC_TYPE, A.CHR_CREATED_DATE AS CHR_DOC_CREATED_DATE, A.CHR_CREATED_TIME AS CHR_DOC_CREATED_TIME, A.CHR_CREATE_BY  AS CHR_DOC_CREATE_BY, 
								B.CHR_SEQ, B.CHR_RECORD_TYPE, B.CHR_DEVICE_ID, B.CHR_SAMPLING, B.CHR_REPETITION,
								B.CHR_CHECK_POINT, B.CHR_TYPE, B.CHR_SPECIAL_CHAR, B.CHR_CONTROL, B.CHR_TARGET_SL, B.CHR_LSL, B.CHR_RANGE_SL, B.CHR_USL, B.CHR_UOM_SL,
								B.CHR_TARGET_CL, B.CHR_LCL, B.CHR_RANGE_CL, B.CHR_UCL, B.CHR_UOM_CL, B.CHR_QLT_CL, B.CHR_QLT_VAL, B.CHR_RESULT, 
								B.CHR_REMARK, B.CHR_STATUS, B.CHR_STRATEGY, B.CHR_CREATE_DATE, B.CHR_CREATED_TIME, B.CHR_CREATE_BY
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID = B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR = '$work_center' AND A.CHR_CREATED_DATE = '$date' and A.CHR_PARTNO = '$partno'
							 ORDER BY A.CHR_CREATED_DATE DESC, A.CHR_LOT_NOMOR DESC, B.CHR_STRATEGY ASC");
		return $query->result();
	}

	function check_approval_daily($work_center, $date, $partno)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT CHR_CREATED_DATE, CHR_WORK_CTR, CHR_PARTNO, INT_FLG_APPROVE, CHR_APPROVE_BY, CHR_APPROVE_DATE, CHR_APPROVE_TIME
							FROM TT_QUA_INSPECTION_H 
							WHERE CHR_WORK_CTR = '$work_center' AND CHR_CREATED_DATE = '$date' AND CHR_PARTNO = '$partno'");
		return $query->result();
	}

	function approve_qcwis_by_date($date, $work_center, $partno, $npk, $date_now, $time_now)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("UPDATE TT_QUA_INSPECTION_H
							SET INT_FLG_APPROVE = '1', 
								CHR_APPROVE_BY = '$npk', 
								CHR_APPROVE_DATE = '$date_now', 
								CHR_APPROVE_TIME = '$time_now'
							WHERE CHR_WORK_CTR = '$work_center' AND CHR_CREATED_DATE = '$date' AND CHR_PARTNO = '$partno'");
	}
}
