<?php

class raw_material_sto_m extends CI_Model
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

	function truncate_temp_data()
	{
		$this->db->query("truncate table TW_REPORT_WH00");
	}

	function save($data)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$dbqua->insert('TM_USER', $data);
	}

	function get_partno_by_wc($wc)
	{
		// $query = $this->db->query("select distinct a.CHR_PART_NO,a.CHR_BACK_NO from TM_KANBAN a inner join TM_PROCESS_PARTS b 
		// 							on a.CHR_PART_NO=b.CHR_PART_NO where a.CHR_BACK_NO<>'' and b.CHR_WORK_CENTER='$wc'
		// 							and (a.CHR_FLAG_DELETE <>'X' or a.CHR_FLAG_DELETE is null) 
		// 							order by a.CHR_BACK_NO");
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

	// function select_data_range_by_date_dept($date, $work_center, $item_cek)
	// {
	// 	$dbqua = $this->load->database("dbqua", TRUE);
	// 	$period = intval($date);

	// 	$stored_procedure = "EXEC dbo.zsp_get_data_range_by_date ?,?,?";
	// 	$param = array(
	// 		'periode' => $period,
	// 		'item_cek' => $item_cek,
	// 		'work_center' => $work_center
	// 	);

	// 	$query = $dbqua->query($stored_procedure, $param);

	// 	if ($query->num_rows() > 0) {
	// 		if ($query->row()->TOTAL > 0) {
	// 			return $query->result();
	// 		} else {
	// 			return false;
	// 		}
	// 	} else {
	// 		return false;
	// 	}
	// }

	function select_data_range_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_PARTNO, MIN(B.CHR_RESULT) AS MIN_VAL,MAX(B.CHR_RESULT) AS MAX_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='RANGE'
							GROUP BY A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR ORDER BY A.CHR_CREATED_DATE ASC");
		// $query = $dbqua->query("SELECT A.CHR_DOC_ID,A.CHR_PARTNO,MIN(B.CHR_RESULT) AS MIN_VAL,MAX(B.CHR_RESULT) AS MAX_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY 
		// 						FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
		// 						WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='RANGE'
		// 						GROUP BY A.CHR_DOC_ID,A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY ORDER BY A.CHR_CREATED_DATE ASC");					
		return $query->result();
	}

	function select_data_max_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_PARTNO,MAX(B.CHR_RESULT) AS MAX_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='MAX'
							GROUP BY A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR ORDER BY A.CHR_CREATED_DATE ASC");
		// $query = $dbqua->query("SELECT A.CHR_DOC_ID,A.CHR_PARTNO,MAX(B.CHR_RESULT) AS MAX_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY 
		// 					FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
		// 					WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='MAX'
		// 					GROUP BY A.CHR_DOC_ID,A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY ORDER BY A.CHR_CREATED_DATE ASC");
		return $query->result();
	}

	function select_data_min_by_date_dept($date, $wc, $partno, $item)
	{
		$dbqua = $this->load->database("dbqua", TRUE);
		$query = $dbqua->query("SELECT A.CHR_PARTNO,MIN(B.CHR_RESULT) AS MIN_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR 
							FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
							WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='MIN'
							GROUP BY A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR ORDER BY A.CHR_CREATED_DATE ASC");
		// $query = $dbqua->query("SELECT A.CHR_DOC_ID,A.CHR_PARTNO,MIN(B.CHR_RESULT) AS MIN_VAL,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY 
		// 					FROM TT_QUA_INSPECTION_H A INNER JOIN TT_QUA_INSPECTION_L B ON A.CHR_DOC_ID=B.CHR_DOC_ID 
		// 					WHERE A.CHR_WORK_CTR='$wc' AND LEFT(A.CHR_CREATED_DATE,6)='$date' and B.CHR_SEQ='$item' and A.CHR_PARTNO='$partno' and B.CHR_CONTROL='MIN'
		// 					GROUP BY A.CHR_DOC_ID,A.CHR_PARTNO,B.CHR_UOM_SL,B.CHR_TARGET_SL,B.CHR_RANGE_SL,B.CHR_LSL,B.CHR_USL,A.CHR_CREATED_DATE,A.CHR_LOT_NOMOR,B.CHR_STRATEGY ORDER BY A.CHR_CREATED_DATE ASC");
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

	function get_namaKary()
	{
		return $this->db->query('SELECT DISTINCT CHR_NAME FROM TT_SCAN_RFID_STO');
	}

	function get_PicScr()
	{
		return $this->db->query('SELECT DISTINCT CHR_NAME FROM TT_SCAN_OUT_RFID');
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

	function get_temp_data_upload_result_raw_material_by_date($date)
	{
		$query = $this->db->query("select CHR_PART_NUMBER,
                                CHR_PERIODE,
                                LEFT(CHR_PERIODE,6) as CHR_PERIODE_TT,
                                CHR_AREA,
                                CASE $date 
                                        WHEN 1 THEN INT_GR_RM_1
                                        WHEN 2 THEN INT_GR_RM_2
                                        WHEN 3 THEN INT_GR_RM_3
                                        WHEN 4 THEN INT_GR_RM_4
                                        WHEN 5 THEN INT_GR_RM_5
                                        WHEN 6 THEN INT_GR_RM_6
                                        WHEN 7 THEN INT_GR_RM_7
                                        WHEN 8 THEN INT_GR_RM_8
                                        WHEN 9 THEN INT_GR_RM_9
                                        WHEN 10 THEN INT_GR_RM_10
                                        WHEN 11 THEN INT_GR_RM_11
                                        WHEN 12 THEN INT_GR_RM_12
                                        WHEN 13 THEN INT_GR_RM_13
                                        WHEN 14 THEN INT_GR_RM_14
                                        WHEN 15 THEN INT_GR_RM_15
                                        WHEN 16 THEN INT_GR_RM_16
                                        WHEN 17 THEN INT_GR_RM_17
                                        WHEN 18 THEN INT_GR_RM_18
                                        WHEN 19 THEN INT_GR_RM_19
                                        WHEN 20 THEN INT_GR_RM_20
                                        WHEN 21 THEN INT_GR_RM_21
                                        WHEN 22 THEN INT_GR_RM_22
                                        WHEN 23 THEN INT_GR_RM_23
                                        WHEN 24 THEN INT_GR_RM_24
                                        WHEN 25 THEN INT_GR_RM_25
                                        WHEN 26 THEN INT_GR_RM_26
                                        WHEN 27 THEN INT_GR_RM_27
                                        WHEN 28 THEN INT_GR_RM_28
                                        WHEN 29 THEN INT_GR_RM_29
                                        WHEN 30 THEN INT_GR_RM_30
                                        ELSE INT_GR_RM_31 END AS INT_GR_RM,
                                CASE $date	
                                        WHEN 1 THEN INT_MOVE_RM_1
                                        WHEN 2 THEN INT_MOVE_RM_2
                                        WHEN 3 THEN INT_MOVE_RM_3
                                        WHEN 4 THEN INT_MOVE_RM_4
                                        WHEN 5 THEN INT_MOVE_RM_5
                                        WHEN 6 THEN INT_MOVE_RM_6
                                        WHEN 7 THEN INT_MOVE_RM_7
                                        WHEN 8 THEN INT_MOVE_RM_8
                                        WHEN 9 THEN INT_MOVE_RM_9
                                        WHEN 10 THEN INT_MOVE_RM_10
                                        WHEN 11 THEN INT_MOVE_RM_11
                                        WHEN 12 THEN INT_MOVE_RM_12
                                        WHEN 13 THEN INT_MOVE_RM_13
                                        WHEN 14 THEN INT_MOVE_RM_14
                                        WHEN 15 THEN INT_MOVE_RM_15
                                        WHEN 16 THEN INT_MOVE_RM_16
                                        WHEN 17 THEN INT_MOVE_RM_17
                                        WHEN 18 THEN INT_MOVE_RM_18
                                        WHEN 19 THEN INT_MOVE_RM_19
                                        WHEN 20 THEN INT_MOVE_RM_20
                                        WHEN 21 THEN INT_MOVE_RM_21
                                        WHEN 22 THEN INT_MOVE_RM_22
                                        WHEN 23 THEN INT_MOVE_RM_23
                                        WHEN 24 THEN INT_MOVE_RM_24
                                        WHEN 25 THEN INT_MOVE_RM_25
                                        WHEN 26 THEN INT_MOVE_RM_26
                                        WHEN 27 THEN INT_MOVE_RM_27
                                        WHEN 28 THEN INT_MOVE_RM_28
                                        WHEN 29 THEN INT_MOVE_RM_29
                                        WHEN 30 THEN INT_MOVE_RM_30
                                        ELSE INT_MOVE_RM_31 END AS INT_MOVE_RM,
                                INT_SALDO_AKHIR_RM 
                            from TW_REPORT_WH00");
		return $query->result();
	}

	function check_existence_temp_data()
	{
		$query = $this->db->query("select top 1 1
                                    from TW_REPORT_WH00");

		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	function check_existence_data_temp_raw_material_by_period($period)
	{
		$query = $this->db->query("select 1
                                    from TW_REPORT_WH00
                                    where CHR_PERIODE = $period");

		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	function check_existence_part_number_raw_material_by_part_number($part_no)
	{
		$part_number_string = "'" . $part_no . "'";

		$query = $this->db->query("select 1
                            from TW_REPORT_WH00
                            where CHR_PART_NUMBER = $part_number_string");

		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	function check_existence_data_raw_material_by_period_and_part_no($period, $part_no)
	{
		$part_number_string = "'" . $part_no . "'";

		$query = $this->db->query("select top 1 1
                            from TT_REPORT_WH00
                            where CHR_PART_NUMBER = $part_number_string AND CHR_PERIODE = $period");

		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	function check_existence_data_raw_material_by_period_and_part_no_and_date($period, $part_no, $date)
	{
		$part_number_string = "'" . $part_no . "'";

		$query = $this->db->query("select INT_ID_WH00, INT_GR_RM_$date as INT_GR_RM, INT_MOVE_RM_$date as INT_MOVE_RM, INT_SALDO_AKHIR_RM
                            from TT_REPORT_WH00
                            where CHR_PART_NUMBER = $part_number_string AND CHR_PERIODE = $period");

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}

	//    function update_qty_data_raw_material_by_id_and_period_and_part_no_and_date($id, $gr_rm, $move_rm, $period, $part_no, $date){
	//        $this->db->query("UPDATE TT_REPORT_WH00
	//                        SET INT_GR_RM_$date = $gr_rm, INT_MOVE_RM_$date = $move_rm
	//                        FROM TT_REPORT_WH00 WHERE INT_ID_WH00 = $id AND CHR_PERIODE = $period AND CHR_PART_NUMBER = $part_no");
	//    }
	//update tabel tt report wh00
	function update_qty_data_raw_material_by_id_and_period_and_part_number_and_date($id, $period, $part_no, $qty_gr_rm, $qty_move_rm, $qty_saldo_rm, $date)
	{
		$part_number_string = "'" . $part_no . "'";

		$query = $this->db->query("UPDATE TT_REPORT_WH00
                        SET INT_GR_RM_$date = $qty_gr_rm, INT_MOVE_RM_$date = $qty_move_rm, INT_SALDO_AKHIR_RM = $qty_saldo_rm
                        FROM TT_REPORT_WH00 WHERE INT_ID_WH00 = $id AND CHR_PERIODE = $period AND CHR_PART_NUMBER = $part_number_string");

		if ($query == 1) {
			return 1;
		} else {
			return 0;
		}
	}

	function save_temp_data_to_data_raw_material($data)
	{
		$query = $this->db->insert('TT_REPORT_WH00', $data);

		if ($query == 1) {
			return 1;
		} else {
			return 0;
		}
	}

	function save_temp_data_raw_material($data)
	{
		$query = $this->db->insert('TW_REPORT_WH00', $data);

		$this->db->_error_message();
		$this->db->_error_number();

		if ($query == 1) {
			return 1;
		} else {
			return 0;
		}
	}

	function merge_report_raw_material_by_period($date)
	{
		$query_check_exist = $this->db->query("SELECT TOP 1 1 
                                                        FROM TT_REPORT_WH00 TT INNER JOIN TW_REPORT_WH00 TW 
                                                        ON TT.CHR_PERIODE = LEFT(TW.CHR_PERIODE,6) AND TT.CHR_PART_NUMBER = TW.CHR_PART_NUMBER");

		if ($query_check_exist->num_rows() > 0) {
			$date_if = explode('.', $date);
			$date_if_if = intval($date_if[2]);

			$this->db->query("UPDATE TT 
							SET	TT.INT_GR_RM_$date_if_if = TW.INT_GR_RM_$date_if_if, TT.INT_MOVE_RM_$date_if_if = TW.INT_MOVE_RM_$date_if_if 
							FROM TT_REPORT_WH00 TT INNER JOIN TW_REPORT_WH00 TW 
								ON TT.CHR_PERIODE = LEFT(TW.CHR_PERIODE,6) AND TT.CHR_PART_NUMBER = TW.CHR_PART_NUMBER");
		} else {
			$this->db->query("INSERT INTO TT_REPORT_WH00 (CHR_PART_NUMBER, CHR_PERIODE, CHR_SLOC, CHR_AREA, 
												INT_GR_RM_1,
												INT_GR_RM_2,
												INT_GR_RM_3,
												INT_GR_RM_4,
												INT_GR_RM_5,
												INT_GR_RM_6,
												INT_GR_RM_7,
												INT_GR_RM_8,
												INT_GR_RM_9,
												INT_GR_RM_10,
												INT_GR_RM_11,
												INT_GR_RM_12,
												INT_GR_RM_13,
												INT_GR_RM_14,
												INT_GR_RM_15,
												INT_GR_RM_16,
												INT_GR_RM_17,
												INT_GR_RM_18,
												INT_GR_RM_19,
												INT_GR_RM_20,
												INT_GR_RM_21,
												INT_GR_RM_22,
												INT_GR_RM_23,
												INT_GR_RM_24,
												INT_GR_RM_25,
												INT_GR_RM_26,
												INT_GR_RM_27,
												INT_GR_RM_28,
												INT_GR_RM_29,
												INT_GR_RM_30,
												INT_GR_RM_31,
												INT_MOVE_RM_1,
												INT_MOVE_RM_2,
												INT_MOVE_RM_3,
												INT_MOVE_RM_4,
												INT_MOVE_RM_5,
												INT_MOVE_RM_6,
												INT_MOVE_RM_7,
												INT_MOVE_RM_8,
												INT_MOVE_RM_9,
												INT_MOVE_RM_10,
												INT_MOVE_RM_11,
												INT_MOVE_RM_12,
												INT_MOVE_RM_13,
												INT_MOVE_RM_14,
												INT_MOVE_RM_15,
												INT_MOVE_RM_16,
												INT_MOVE_RM_17,
												INT_MOVE_RM_18,
												INT_MOVE_RM_19,
												INT_MOVE_RM_20,
												INT_MOVE_RM_21,
												INT_MOVE_RM_22,
												INT_MOVE_RM_23,
												INT_MOVE_RM_24,
												INT_MOVE_RM_25,
												INT_MOVE_RM_26,
												INT_MOVE_RM_27,
												INT_MOVE_RM_28,
												INT_MOVE_RM_29,
												INT_MOVE_RM_30,
												INT_MOVE_RM_31,
												INT_SALDO_AKHIR_RM
											)
											SELECT CHR_PART_NUMBER, LEFT(CHR_PERIODE, 6) , CHR_SLOC, CHR_AREA, 
												INT_GR_RM_1,
												INT_GR_RM_2,
												INT_GR_RM_3,
												INT_GR_RM_4,
												INT_GR_RM_5,
												INT_GR_RM_6,
												INT_GR_RM_7,
												INT_GR_RM_8,
												INT_GR_RM_9,
												INT_GR_RM_10,
												INT_GR_RM_11,
												INT_GR_RM_12,
												INT_GR_RM_13,
												INT_GR_RM_14,
												INT_GR_RM_15,
												INT_GR_RM_16,
												INT_GR_RM_17,
												INT_GR_RM_18,
												INT_GR_RM_19,
												INT_GR_RM_20,
												INT_GR_RM_21,
												INT_GR_RM_22,
												INT_GR_RM_23,
												INT_GR_RM_24,
												INT_GR_RM_25,
												INT_GR_RM_26,
												INT_GR_RM_27,
												INT_GR_RM_28,
												INT_GR_RM_29,
												INT_GR_RM_30,
												INT_GR_RM_31,
												INT_MOVE_RM_1,
												INT_MOVE_RM_2,
												INT_MOVE_RM_3,
												INT_MOVE_RM_4,
												INT_MOVE_RM_5,
												INT_MOVE_RM_6,
												INT_MOVE_RM_7,
												INT_MOVE_RM_8,
												INT_MOVE_RM_9,
												INT_MOVE_RM_10,
												INT_MOVE_RM_11,
												INT_MOVE_RM_12,
												INT_MOVE_RM_13,
												INT_MOVE_RM_14,
												INT_MOVE_RM_15,
												INT_MOVE_RM_16,
												INT_MOVE_RM_17,
												INT_MOVE_RM_18,
												INT_MOVE_RM_19,
												INT_MOVE_RM_20,
												INT_MOVE_RM_21,
												INT_MOVE_RM_22,
												INT_MOVE_RM_23,
												INT_MOVE_RM_24,
												INT_MOVE_RM_25,
												INT_MOVE_RM_26,
												INT_MOVE_RM_27,
												INT_MOVE_RM_28,
												INT_MOVE_RM_29,
												INT_MOVE_RM_30,
												INT_MOVE_RM_31,
												INT_SALDO_AKHIR_RM 
											FROM TW_REPORT_WH00");
		}
	}

	function get_temp_data_period()
	{
		$query = $this->db->query("select CHR_PERIODE
                                    from TW_REPORT_WH00");

		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}

	function select_data_report_wh00_part_by_period($period)
	{

		$query = $this->db->query("select 
	WH00.INT_GR_RM_1 - WH00.INT_GR_SAP_1 as INT_GR_DIFF_1, 
	WH00.INT_GR_RM_2 - WH00.INT_GR_SAP_2 as INT_GR_DIFF_2, 
	WH00.INT_GR_RM_3 - WH00.INT_GR_SAP_3 as INT_GR_DIFF_3, 
	WH00.INT_GR_RM_4 - WH00.INT_GR_SAP_4 as INT_GR_DIFF_4, 
	WH00.INT_GR_RM_5 - WH00.INT_GR_SAP_5 as INT_GR_DIFF_5, 
	WH00.INT_GR_RM_6 - WH00.INT_GR_SAP_6 as INT_GR_DIFF_6, 
	WH00.INT_GR_RM_7 - WH00.INT_GR_SAP_7 as INT_GR_DIFF_7, 
	WH00.INT_GR_RM_8 - WH00.INT_GR_SAP_8 as INT_GR_DIFF_8, 
	WH00.INT_GR_RM_9 - WH00.INT_GR_SAP_9 as INT_GR_DIFF_9, 
	WH00.INT_GR_RM_10 - WH00.INT_GR_SAP_10 as INT_GR_DIFF_10, 
	WH00.INT_GR_RM_11 - WH00.INT_GR_SAP_11 as INT_GR_DIFF_11, 
	WH00.INT_GR_RM_12 - WH00.INT_GR_SAP_12 as INT_GR_DIFF_12, 
	WH00.INT_GR_RM_13 - WH00.INT_GR_SAP_13 as INT_GR_DIFF_13, 
	WH00.INT_GR_RM_14 - WH00.INT_GR_SAP_14 as INT_GR_DIFF_14, 
	WH00.INT_GR_RM_15 - WH00.INT_GR_SAP_15 as INT_GR_DIFF_15, 
	WH00.INT_GR_RM_16 - WH00.INT_GR_SAP_16 as INT_GR_DIFF_16, 
	WH00.INT_GR_RM_17 - WH00.INT_GR_SAP_17 as INT_GR_DIFF_17, 
	WH00.INT_GR_RM_18 - WH00.INT_GR_SAP_18 as INT_GR_DIFF_18, 
	WH00.INT_GR_RM_19 - WH00.INT_GR_SAP_19 as INT_GR_DIFF_19, 
	WH00.INT_GR_RM_20 - WH00.INT_GR_SAP_20 as INT_GR_DIFF_20, 
	WH00.INT_GR_RM_21 - WH00.INT_GR_SAP_21 as INT_GR_DIFF_21, 
	WH00.INT_GR_RM_22 - WH00.INT_GR_SAP_22 as INT_GR_DIFF_22, 
	WH00.INT_GR_RM_23 - WH00.INT_GR_SAP_23 as INT_GR_DIFF_23, 
	WH00.INT_GR_RM_24 - WH00.INT_GR_SAP_24 as INT_GR_DIFF_24, 
	WH00.INT_GR_RM_25 - WH00.INT_GR_SAP_25 as INT_GR_DIFF_25, 
	WH00.INT_GR_RM_26 - WH00.INT_GR_SAP_26 as INT_GR_DIFF_26, 
	WH00.INT_GR_RM_27 - WH00.INT_GR_SAP_27 as INT_GR_DIFF_27, 
	WH00.INT_GR_RM_28 - WH00.INT_GR_SAP_28 as INT_GR_DIFF_28, 
	WH00.INT_GR_RM_29 - WH00.INT_GR_SAP_29 as INT_GR_DIFF_29, 
	WH00.INT_GR_RM_30 - WH00.INT_GR_SAP_30 as INT_GR_DIFF_30, 
	WH00.INT_GR_RM_31 - WH00.INT_GR_SAP_31 as INT_GR_DIFF_31, 
	
	WH00.INT_MOVE_RM_1 - WH00.INT_MOVE_SAP_1 as INT_MOVE_DIFF_1, 
	WH00.INT_MOVE_RM_2 - WH00.INT_MOVE_SAP_2 as INT_MOVE_DIFF_2, 
	WH00.INT_MOVE_RM_3 - WH00.INT_MOVE_SAP_3 as INT_MOVE_DIFF_3, 
	WH00.INT_MOVE_RM_4 - WH00.INT_MOVE_SAP_4 as INT_MOVE_DIFF_4, 
	WH00.INT_MOVE_RM_5 - WH00.INT_MOVE_SAP_5 as INT_MOVE_DIFF_5, 
	WH00.INT_MOVE_RM_6 - WH00.INT_MOVE_SAP_6 as INT_MOVE_DIFF_6, 
	WH00.INT_MOVE_RM_7 - WH00.INT_MOVE_SAP_7 as INT_MOVE_DIFF_7, 
	WH00.INT_MOVE_RM_8 - WH00.INT_MOVE_SAP_8 as INT_MOVE_DIFF_8, 
	WH00.INT_MOVE_RM_9 - WH00.INT_MOVE_SAP_9 as INT_MOVE_DIFF_9, 
	WH00.INT_MOVE_RM_10 - WH00.INT_MOVE_SAP_10 as INT_MOVE_DIFF_10, 
	WH00.INT_MOVE_RM_11 - WH00.INT_MOVE_SAP_11 as INT_MOVE_DIFF_11, 
	WH00.INT_MOVE_RM_12 - WH00.INT_MOVE_SAP_12 as INT_MOVE_DIFF_12, 
	WH00.INT_MOVE_RM_13 - WH00.INT_MOVE_SAP_13 as INT_MOVE_DIFF_13, 
	WH00.INT_MOVE_RM_14 - WH00.INT_MOVE_SAP_14 as INT_MOVE_DIFF_14, 
	WH00.INT_MOVE_RM_15 - WH00.INT_MOVE_SAP_15 as INT_MOVE_DIFF_15, 
	WH00.INT_MOVE_RM_16 - WH00.INT_MOVE_SAP_16 as INT_MOVE_DIFF_16, 
	WH00.INT_MOVE_RM_17 - WH00.INT_MOVE_SAP_17 as INT_MOVE_DIFF_17, 
	WH00.INT_MOVE_RM_18 - WH00.INT_MOVE_SAP_18 as INT_MOVE_DIFF_18, 
	WH00.INT_MOVE_RM_19 - WH00.INT_MOVE_SAP_19 as INT_MOVE_DIFF_19, 
	WH00.INT_MOVE_RM_20 - WH00.INT_MOVE_SAP_20 as INT_MOVE_DIFF_20, 
	WH00.INT_MOVE_RM_21 - WH00.INT_MOVE_SAP_21 as INT_MOVE_DIFF_21, 
	WH00.INT_MOVE_RM_22 - WH00.INT_MOVE_SAP_22 as INT_MOVE_DIFF_22, 
	WH00.INT_MOVE_RM_23 - WH00.INT_MOVE_SAP_23 as INT_MOVE_DIFF_23, 
	WH00.INT_MOVE_RM_24 - WH00.INT_MOVE_SAP_24 as INT_MOVE_DIFF_24, 
	WH00.INT_MOVE_RM_25 - WH00.INT_MOVE_SAP_25 as INT_MOVE_DIFF_25, 
	WH00.INT_MOVE_RM_26 - WH00.INT_MOVE_SAP_26 as INT_MOVE_DIFF_26, 
	WH00.INT_MOVE_RM_27 - WH00.INT_MOVE_SAP_27 as INT_MOVE_DIFF_27, 
	WH00.INT_MOVE_RM_28 - WH00.INT_MOVE_SAP_28 as INT_MOVE_DIFF_28, 
	WH00.INT_MOVE_RM_29 - WH00.INT_MOVE_SAP_29 as INT_MOVE_DIFF_29, 
	WH00.INT_MOVE_RM_30 - WH00.INT_MOVE_SAP_30 as INT_MOVE_DIFF_30, 
	WH00.INT_MOVE_RM_31 - WH00.INT_MOVE_SAP_31 as INT_MOVE_DIFF_31, 
	WH00.INT_SALDO_AKHIR_RM - WH00.INT_SALDO_AKHIR_SAP as INT_SALDO_AKHIR_DIFF,
	   WH00.*, RM.INT_CONS_1, RM.INT_CONS_2, RM.INT_CONS_3, RM.INT_CONS_4, RM.INT_CONS_5, RM.INT_CONS_6, RM.INT_CONS_7,
			   RM.INT_CONS_8, RM.INT_CONS_9, RM.INT_CONS_10, RM.INT_CONS_11, RM.INT_CONS_12, RM.INT_CONS_13, RM.INT_CONS_14,
			   RM.INT_CONS_15, RM.INT_CONS_16, RM.INT_CONS_17, RM.INT_CONS_18, RM.INT_CONS_19, RM.INT_CONS_20, RM.INT_CONS_21,
			   RM.INT_CONS_22, RM.INT_CONS_23, RM.INT_CONS_24, RM.INT_CONS_25, RM.INT_CONS_26, RM.INT_CONS_27, RM.INT_CONS_28,
			   RM.INT_CONS_29, RM.INT_CONS_30, RM.INT_CONS_31
			   
	from TT_REPORT_WH00 WH00 
	inner join TT_REPORT_MOVEMENT RM 
	on WH00.CHR_PERIODE = RM.CHR_PERIODE and WH00.CHR_PART_NUMBER = RM.CHR_PART_NUMBER
                                    where WH00.CHR_PERIODE = $period");

		return $query->result();
	}
}
