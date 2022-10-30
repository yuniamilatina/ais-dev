<?php
	class preventive_schedule_m extends CI_Model
	{
	    function get_parts_mte($group_line) {
	        $query = $this->db->query("SELECT * FROM TM_PARTS_MTE WHERE CHR_TYPE = '$group_line' AND INT_FLAG_DELETE = '0'");
	        return $query->result();
		}

		// function get_parts_mte_new() {
	    //     $query = $this->db->query(";WITH CTE_A(INT_ID, CHR_PART_CODE, CHR_PART_NAME, CHR_MODEL, CHR_STATUS) AS (				
		// 									SELECT INT_ID, CHR_PART_CODE, CHR_PART_NAME, CHR_MODEL, 
		// 									CASE WHEN CONVERT(VARCHAR, CHR_DATE_SMALL_PREVENTIVE, 112) =  CONVERT(VARCHAR, GETDATE(), 112) THEN 1 
		// 									ELSE 0 END AS CHR_STATUS
		// 									FROM TM_PARTS_MTE)
		// 									SELECT * FROM CTE_A");
	    //     return $query->result();
		// }
		
		//----- New Query by ANU 20200626 -----//
		function get_parts_mte_new($group_line) {
	        // $query = $this->db->query("SELECT INT_ID, CHR_PART_CODE, CHR_PART_NAME, CHR_MODEL, 
			// 							CASE WHEN CHR_TYPE = 'A' THEN 'MOLD'
			// 								WHEN CHR_TYPE = 'B' THEN 'DIES STP'
			// 								WHEN CHR_TYPE = 'C' THEN 'DIES DF'
			// 								WHEN CHR_TYPE = 'D' THEN 'MACHINE'
			// 								WHEN CHR_TYPE = 'E' THEN 'JIG'
			// 							END AS CHR_TYPE,
			// 							CASE WHEN CONVERT(VARCHAR, CHR_DATE_SMALL_PREVENTIVE, 112) =  CONVERT(VARCHAR, GETDATE(), 112) THEN 1 
			// 							ELSE 0 END AS CHR_STATUS
			// 						FROM TM_PARTS_MTE
			// 						WHERE CHR_TYPE = '$group_code'");

			$stored_procedure = "EXEC [MTE].[zsp_get_data_preventive_mte_all_new] ?";
			$param = array(
				'group_line' => $group_line );
			$query = $this->db->query($stored_procedure, $param);			

	        return $query->result();
		}
		
		function get_master_data($part_code) {
	        $query = $this->db->query("SELECT * FROM TM_PARTS_MTE WHERE CHR_PART_CODE = '$part_code' AND INT_FLAG_DELETE = '0'");
	        return $query;
		}

		function cek_double_data($part_code, $id) {
	        $query = $this->db->query("SELECT * FROM TM_PARTS_MTE WHERE CHR_PART_CODE = '$part_code' AND INT_ID <> '$id' AND INT_FLAG_DELETE = '0'");
	        return $query;
		}
		
		function save($data) {
			//$db_samanta = $this->load->database("samanta", TRUE);
			$this->db->insert('dbo.TM_PARTS_MTE', $data);
		}

		function update($data, $where) {
			//$db_1 = $this->load->database();
			if (is_array($data)) {
				return $this->db->update('dbo.TM_PARTS_MTE', $data, $where);
			}
			return false;
		}

		function update_detail($data, $where) {
			//$db_1 = $this->load->database();
			if (is_array($data)) {
				return $this->db->update('dbo.TM_PARTS_MTE_DETAIL', $data, $where);
			}
			return false;
		}

		function find($part_code) {
			$query = $this->db->query("SELECT * FROM TM_PARTS_MTE WHERE CHR_PART_CODE = '$part_code'");
			return $query->result();
		}

		function find_by_id($id) {
			$query = $this->db->query("SELECT * FROM TM_PARTS_MTE WHERE INT_ID = '$id'");
			return $query->row();
		}
        
        function delete($part_code, $pic, $datenow, $timenow) {
	        $this->db->query("UPDATE TM_PARTS_MTE SET 
								INT_FLAG_DELETE = '1',
								CHR_MODIFIED_BY = '$pic',
								CHR_MODIFIED_DATE = '$datenow',
								CHR_MODIFIED_TIME = '$timenow'
								WHERE CHR_PART_CODE = '$part_code'");
		}
		
		function get_detail_data($part_code) {
			$query = $this->db->query("SELECT * FROM TM_PARTS_MTE_DETAIL WHERE CHR_PART_CODE = '$part_code' AND INT_FLAG_DELETE = '0'");
	        return $query->result();
		}

		function get_data_part_number($term) {
			$query = $this->db->query("SELECT DISTINCT a.CHR_PART_NO, a.CHR_BACK_NO, b.CHR_PART_NAME FROM TM_KANBAN a INNER JOIN TM_PARTS b on b.CHR_PART_NO = a.CHR_PART_NO WHERE a.CHR_BACK_NO LIKE '%$term%'");
			return $query->result();
		}

		function get_work_center_by_part_no($backno){
			$query = $this->db->query("SELECT A.CHR_WORK_CENTER FROM TM_PROCESS_PARTS A INNER JOIN TM_KANBAN B ON B.CHR_PART_NO = A.CHR_PART_NO
																WHERE B.CHR_BACK_NO = '$backno' ORDER BY A.CHR_WORK_CENTER ASC");
	
			return $query->result();
		}

		function save_detail_data($data_detail) {
			$this->db->insert('dbo.TM_PARTS_MTE_DETAIL', $data_detail);
		}

		function delete_detail_data($partcode, $partno, $pic, $datenow, $timenow) {
	        $this->db->query("UPDATE TM_PARTS_MTE_DETAIL SET 
						INT_FLAG_DELETE = '1',
						CHR_MODIFIED_BY = '$pic',
						CHR_MODIFIED_DATE = '$datenow',
						CHR_MODIFIED_TIME = '$timenow'
			WHERE CHR_PART_CODE = '$partcode' AND CHR_PART_NO = '$partno'");
		}
		
		// schedule preventive store procedure
		function get_data_accumulative_production_preventive_schedule(){
			$stored_procedure = "EXEC [MTE].[zsp_get_preventive_mte_schedule_accumulative]";
			$query = $this->db->query($stored_procedure);
			return $query->result();
		}

		function check_flag($id) {
			$query = $this->db->query("SELECT * FROM TM_PARTS_MTE WHERE INT_ID = '$id'");
			return $query;
		}

		function update_flag_preventive1($part_code, $flag_small_prev, $flag_big_prev, $date_big_prev) {
			$this->db->query("UPDATE TM_PARTS_MTE SET 
											INT_SMALL_PREVENTIVE = '$flag_small_prev',
											CHR_DATE_SMALL_PREVENTIVE = '$date_big_prev',
											INT_BIG_PREVENTIVE = '$flag_big_prev',
											CHR_DATE_BIG_PREVENTIVE = '$date_big_prev'
											WHERE CHR_PART_CODE = '$part_code'");
		}

		function update_flag_preventive2($part_code, $flag_small_prev, $date_small_prev) {
			$this->db->query("UPDATE TM_PARTS_MTE SET 
											INT_SMALL_PREVENTIVE = '$flag_small_prev', 
											CHR_DATE_SMALL_PREVENTIVE = '$date_small_prev'
											WHERE CHR_PART_CODE = '$part_code'");
		}

		// update machine mte
		// start
		function get_production_hour($id) {
			$stored_procedure = "EXEC MTE.zsp_get_data_preventive_mte_machine ?";
			$param = array(
				'id' => $id);
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}
		
		function update_preventive_machine($id, $flag_small_prev_next, $date_small_prev,  $stroke_big_preventive_next) {
			$this->db->query("UPDATE TM_PARTS_MTE SET 
											INT_SMALL_PREVENTIVE = '$flag_small_prev_next', 
											CHR_DATE_SMALL_PREVENTIVE = '$date_small_prev',
											INT_STROKE_BIG_PREVENTIVE = '$stroke_big_preventive_next'
											WHERE INT_ID = '$id'");
		}
		// end

		// update df mte atau dies mte
		// start
		function get_stroke_now_df($part_code) {
			$stored_procedure = "EXEC MTE.zsp_get_data_preventive_mte_df ?";
			$param = array(
				'code' => $part_code);
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}

		function get_stroke_now_dies($part_code) {
			$stored_procedure = "EXEC MTE.zsp_get_data_preventive_mte_dies ?";
			$param = array(
				'code' => $part_code);
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}

		function get_stroke_now_jig($part_code) {
			$stored_procedure = "EXEC MTE.zsp_get_data_preventive_mte_jig ?";
			$param = array(
				'code' => $part_code);
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}

		function update_flag_preventive_df($part_code, $flag_small_prev_next, $date_small_prev, $next_stroke_preventive) {
			$this->db->query("UPDATE TM_PARTS_MTE SET 
											INT_SMALL_PREVENTIVE = '$flag_small_prev_next', 
											CHR_DATE_SMALL_PREVENTIVE = '$date_small_prev',
											INT_STROKE_BIG_PREVENTIVE = '$next_stroke_preventive'
											WHERE CHR_PART_CODE = '$part_code'");
		}

		function update_flag_preventive_dies($part_code, $flag_small_prev_next, $date_small_prev, $next_stroke_preventive, $last_cum) {
			$this->db->query("UPDATE TM_PARTS_MTE SET 
											INT_SMALL_PREVENTIVE = '$flag_small_prev_next', 
											CHR_DATE_SMALL_PREVENTIVE = '$date_small_prev',
											INT_STROKE_BIG_PREVENTIVE = '$next_stroke_preventive',
											INT_LAST_CUM = '$last_cum'
											WHERE CHR_PART_CODE = '$part_code'");
		}
		// end

		// update for mold mte logic
		// start
		function get_stroke_now_mold($part_code) {
			$stored_procedure = "EXEC MTE.zsp_get_data_preventive_mte_mold ?";
			$param = array(
				'code' => $part_code);
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}

		function update_big_preventive($part_code, $small_prev_next, $big_prev_next, $datenow, $next_stroke_preventive) {
			$this->db->query("UPDATE TM_PARTS_MTE SET 
									INT_SMALL_PREVENTIVE = '$small_prev_next', 
									CHR_DATE_SMALL_PREVENTIVE = '$datenow',
									INT_BIG_PREVENTIVE = '$big_prev_next',
									INT_STROKE_BIG_PREVENTIVE = '$next_stroke_preventive'
									WHERE CHR_PART_CODE = '$part_code'");
		}
		function update_small_preventive($part_code, $small_prev_next, $datenow, $next_stroke_preventive) {
			$this->db->query("UPDATE TM_PARTS_MTE SET 
									INT_SMALL_PREVENTIVE = '$small_prev_next', 
									CHR_DATE_SMALL_PREVENTIVE = '$datenow',
									INT_STROKE_BIG_PREVENTIVE = '$next_stroke_preventive'
									WHERE CHR_PART_CODE = '$part_code'");
		}
		// end

		function insert_transaction_preventive($type, $part_code, $count, $stroke_big_preventive, $type_prev, $npk, $datenow, $timenow, $id) {
			$this->db->query("INSERT INTO TT_PREVENTIVE (CHR_TYPE, CHR_PART_CODE, INT_COUNT, INT_PLAN_COUNT, CHR_TYPE_PREV, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, INT_ID_PART) 
								VALUES ('$type', '$part_code', '$count', '$stroke_big_preventive','$type_prev', '$npk', '$datenow', '$timenow', '$id')");
		}

		function insert_transaction_preventive_machine($type, $part_code, $count, $stroke_big_preventive, $type_prev, $npk, $datenow, $timenow, $id) {
			$this->db->query("INSERT INTO TT_PREVENTIVE (CHR_TYPE, CHR_PART_CODE, INT_COUNT, INT_PLAN_COUNT, CHR_TYPE_PREV, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, INT_ID_PART) 
								VALUES ('$type', '$part_code', '$count', '$stroke_big_preventive','$type_prev', '$npk', '$datenow', '$timenow', '$id')");
		}
		
		//===== Update for Add Preventive Detail - by ANU - 20210324 =====//
		function get_preventive_header($part_code) {
			$query = $this->db->query("SELECT TOP 1 * FROM TT_PREVENTIVE WHERE CHR_PART_CODE = '$part_code' ORDER BY INT_ID DESC");
			return $query->row();
		}

		function insert_transaction_preventive_detail($id_prev, $id, $part_code, $stroke_now, $pic, $datenow, $timenow) {
			$this->db->query("INSERT INTO MTE.TT_PREVENTIVE_DETAIL (INT_ID_PREV, INT_ID_PART, CHR_PART_CODE, INT_STROKE, INT_FLG_PREV, CHR_START_PREV_BY, CHR_START_PREV_DATE, CHR_START_PREV_TIME, CHR_FINISH_PREV_BY, CHR_FINISH_PREV_DATE, CHR_FINISH_PREV_TIME, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, CHR_REMARKS) 
								VALUES ('$id_prev', '$id', '$part_code', '$stroke_now', '2', '$pic', '$datenow', '$timenow', '$pic', '$datenow', '$timenow', '$pic', '$datenow', '$timenow', 'Done via AIS')");
		}
		//===== End Update for Add Preventive Detail - by ANU - 20210324 =====//

		function get_wo() {
			$query = $this->db->query("SELECT A.*, B.CHR_MODEL FROM TM_LINE_CAPACITY A INNER JOIN TM_PARTS_MTE B ON B.CHR_PART_CODE = A.CHR_PART_CODE");
			return $query->result();
		}

		function get_data_part_wo() {
			$query = $this->db->query("SELECT DISTINCT CHR_PART_CODE FROM TM_PARTS_MTE WHERE INT_FLAG_DELETE = 0 ORDER BY CHR_PART_CODE");
			return $query->result();
		}

		function update_data_upload($date_periode, $part_code, $quantity, $pic, $date_now, $time_now) {
			$this->db->query("UPDATE TM_LINE_CAPACITY SET 
									CHR_PERIODE = '$date_periode',
									CHR_PART_CODE = '$part_code',
									INT_QTY_WO = '$quantity',
									CHR_CREATED_BY = '$pic',
									CHR_CREATED_DATE = '$date_now',
									CHR_CREATED_TIME = '$time_now'
									WHERE CHR_PERIODE = '$date_periode' AND CHR_PART_CODE = '$part_code'");
		}

		function insert_data_upload($date_periode, $part_code, $quantity, $pic, $date_now, $time_now) {
			$this->db->query("INSERT INTO TM_LINE_CAPACITY SET 
									CHR_PERIODE = '$date_periode',
									CHR_PART_CODE = '$part_code',
									INT_QTY_WO = '$quantity',
									CHR_CREATED_BY = '$pic',
									CHR_CREATED_DATE = '$date_now',
									CHR_CREATED_TIME = '$time_now'
									WHERE CHR_PERIODE = '$date_periode' AND CHR_PART_CODE = '$part_code'");
		}


		function get_data_preventive() {
			$query = $this->db->query("SELECT PREV.*, B.CHR_PART_NAME, B.CHR_MODEL, A.CHR_USERNAME FROM TT_PREVENTIVE PREV 
							INNER JOIN TM_USER A ON A.CHR_NPK = PREV.CHR_CREATED_BY 
							INNER JOIN TM_PARTS_MTE B ON B.CHR_PART_CODE = PREV.CHR_PART_CODE  WHERE PREV.INT_COUNT <> 0
							ORDER BY PREV.CHR_TYPE ASC");
	        return $query->result();
		}

		function get_data_area() {
			$query = $this->db->query("SELECT DISTINCT CHR_TYPE FROM TT_PREVENTIVE ORDER BY CHR_TYPE ASC");
	        return $query->result();
		}


		// =========================================================================================
		function get_data_preventive_mte_report_daily($periode, $group) {
			$stored_procedure = "EXEC [MTE].[zsp_get_preventive_mte_report_daily] ?,?";
			$param = array(
				'periode' => $periode,
				'group_line' => $group );
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}

		function get_all_data_preventive_mte($group) {
			$stored_procedure = "EXEC [MTE].[zsp_get_data_preventive_mte_all] ?";
			$param = array(
				'group_line' => $group );
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}

		//===== Update by ANU --- 20201003 =====//
		function get_all_data_preventive_mte_new($group) {
			$stored_procedure = "EXEC [MTE].[zsp_get_data_preventive_mte_all_new] ?";
			$param = array(
				'group_line' => $group );
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}
		//===== End Edit by ANU =====//

		function get_all_product_group_custom() {
			$query = $this->db->query("SELECT (1) AS ID, ('MOLD') AS CHR_GROUP_LINE
											UNION SELECT (2) AS ID, ('DIES STP') AS CHR_GROUP_LINE
											UNION SELECT (3) AS ID, ('DIES DF') AS CHR_GROUP_LINE
											UNION SELECT (4) AS ID, ('MACHINE') AS CHR_GROUP_LINE
											UNION SELECT (5) AS ID, ('JIG - STROKE') AS CHR_GROUP_LINE
											UNION SELECT (6) AS ID, ('ELECTRODE') AS CHR_GROUP_LINE
											UNION SELECT (7) AS ID, ('JIG - SCHEDULE') AS CHR_GROUP_LINE
											UNION SELECT (8) AS ID, ('POKAYOKE') AS CHR_GROUP_LINE");
			return $query->result();
		}

		function group_preventive(){
			$query = $this->db->query("SELECT (1) AS ID, ('MACHINE') AS CHR_GROUP_PREVENTIVE
											UNION SELECT (2) AS ID, ('JIG') AS CHR_GROUP_PREVENTIVE");
			return $query->result();
		}

		function get_data_all_preventive() {
			$stored_procedure = "EXEC MTE.zsp_get_preventive_mte_machine_all";
			$query = $this->db->query($stored_procedure);
			return $query->result();
		}

		function get_data_all_preventive_filter($group) {
			$stored_procedure = "EXEC MTE.zsp_get_preventive_mte_all ?";
			$param = array(
				'group_line' => $group );
	
			$query = $this->db->query($stored_procedure, $param);
			return $query->result();
		}

		function get_data_history_preventive($group){
			if($group == '1'){
				$group = 'A';
			} elseif($group == '2'){
				$group = 'B';
			} elseif($group == '3'){
				$group = 'C';
			} elseif($group == '4'){
				$group = 'D';
			} elseif($group == '5'){
				$group = 'E';
			} elseif($group == '6'){
				$group = 'F';
			} elseif($group == '7'){
				$group = 'G';
			} elseif($group == '8'){
				$group = 'H';
			}

			$query = $this->db->query("SELECT CASE WHEN A.CHR_TYPE = 'A' THEN 'MOLD'
											WHEN A.CHR_TYPE = 'B' THEN 'DIES STP'
											WHEN A.CHR_TYPE = 'C' THEN 'DIES DF'
											WHEN A.CHR_TYPE = 'D' THEN 'MACHINE'
											WHEN A.CHR_TYPE = 'E' THEN 'JIG'
											ELSE 'ELECTRODE' END AS CHR_TYPE,
										A.INT_ID,
										A.CHR_TYPE AS KODE_TYPE,
										A.CHR_PART_CODE AS KODE_PART, 
										C.CHR_MODEL,
										C.CHR_PART_NAME,
										INT_COUNT AS STROKE,
										CASE WHEN CHR_TYPE_PREV = 'S' THEN 'SMALL'
											WHEN CHR_TYPE_PREV = 'B' THEN 'BIG'
										END AS TYPE_PREV,
										A.CHR_CREATED_BY AS NPK,
										B.CHR_USERNAME AS PIC,
										A.CHR_CREATED_DATE AS PREV_DATE,
										A.CHR_CREATED_TIME AS PREV_TIME,
										D.INT_ID AS INT_ID_PREV_DETAIL,
										D.INT_ID_PART,
										CONVERT(INT, D.CHR_START_PREV_BY) AS NPK_START,
										D.CHR_START_PREV_DATE AS DATE_START,
										D.CHR_START_PREV_TIME AS TIME_START,
										CONVERT(INT, D.CHR_FINISH_PREV_BY) AS NPK_END,
										D.CHR_FINISH_PREV_DATE AS DATE_END,
										D.CHR_FINISH_PREV_TIME AS TIME_END,
										D.INT_FLG_PREV,
										D.CHR_REMARKS AS NOTES,
										D.INT_FLG_CONFIRM,
										D.CHR_CONFIRM_BY,
										D.CHR_CONFIRM_DATE,
										D.CHR_CONFIRM_TIME
									FROM TT_PREVENTIVE A
									LEFT JOIN MTE.TT_PREVENTIVE_DETAIL D ON A.INT_ID = D.INT_ID_PREV
									LEFT JOIN TM_PARTS_MTE C ON A.CHR_PART_CODE = C.CHR_PART_CODE
									LEFT JOIN TM_USER B ON LTRIM(CONVERT(INT, A.CHR_CREATED_BY)) = RTRIM(B.CHR_NPK) 
									WHERE A.CHR_TYPE = '$group'");
			return $query->result();
		}

		function get_data_history_preventive_by_month($group, $month){
			if($group == '1'){
				$group = 'A';
			} elseif($group == '2'){
				$group = 'B';
			} elseif($group == '3'){
				$group = 'C';
			} elseif($group == '4'){
				$group = 'D';
			} elseif($group == '5'){
				$group = 'E';
			} elseif($group == '6'){
				$group = 'F';
			} elseif($group == '7'){
				$group = 'G';
			} elseif($group == '8'){
				$group = 'H';
			}

			$query = $this->db->query("SELECT CASE WHEN A.CHR_TYPE = 'A' THEN 'MOLD'
											WHEN A.CHR_TYPE = 'B' THEN 'DIES STP'
											WHEN A.CHR_TYPE = 'C' THEN 'DIES DF'
											WHEN A.CHR_TYPE = 'D' THEN 'MACHINE'
											WHEN A.CHR_TYPE = 'E' THEN 'JIG'
											ELSE 'ELECTRODE' END AS CHR_TYPE,
										A.INT_ID,
										A.CHR_TYPE AS KODE_TYPE,
										A.CHR_PART_CODE AS KODE_PART, 
										C.CHR_MODEL,
										C.CHR_PART_NAME,
										INT_COUNT AS STROKE,
										CASE WHEN CHR_TYPE_PREV = 'S' THEN 'SMALL'
											WHEN CHR_TYPE_PREV = 'B' THEN 'BIG'
										END AS TYPE_PREV,
										A.CHR_CREATED_BY AS NPK,
										B.CHR_USERNAME AS PIC,
										A.CHR_CREATED_DATE AS PREV_DATE,
										A.CHR_CREATED_TIME AS PREV_TIME,
										D.INT_ID AS INT_ID_PREV_DETAIL,
										D.INT_ID_PART,
										CONVERT(INT, D.CHR_START_PREV_BY) AS NPK_START,
										D.CHR_START_PREV_DATE AS DATE_START,
										D.CHR_START_PREV_TIME AS TIME_START,
										CONVERT(INT, D.CHR_FINISH_PREV_BY) AS NPK_END,
										D.CHR_FINISH_PREV_DATE AS DATE_END,
										D.CHR_FINISH_PREV_TIME AS TIME_END,
										D.INT_FLG_PREV,
										D.CHR_REMARKS AS NOTES,
										D.INT_FLG_CONFIRM,
										D.CHR_CONFIRM_BY,
										D.CHR_CONFIRM_DATE,
										D.CHR_CONFIRM_TIME
									FROM TT_PREVENTIVE A
									LEFT JOIN MTE.TT_PREVENTIVE_DETAIL D ON A.INT_ID = D.INT_ID_PREV
									LEFT JOIN TM_PARTS_MTE C ON A.CHR_PART_CODE = C.CHR_PART_CODE
									LEFT JOIN TM_USER B ON LTRIM(CONVERT(INT, A.CHR_CREATED_BY)) = RTRIM(B.CHR_NPK) 
									WHERE A.CHR_TYPE = '$group' AND SUBSTRING(D.CHR_START_PREV_DATE,1,6) = '$month'");
			return $query->result();
		}

		function get_data_history_repair($group){
			if($group == '1'){
				$group = 'A';
			} elseif($group == '2'){
				$group = 'B';
			} elseif($group == '3'){
				$group = 'C';
			} elseif($group == '4'){
				$group = 'D';
			} elseif($group == '5'){
				$group = 'E';
			} elseif($group == '6'){
				$group = 'F';
			} elseif($group == '7'){
				$group = 'G';
			} elseif($group == '8'){
				$group = 'H';
			}

			$query = $this->db->query("SELECT CASE WHEN C.CHR_TYPE = 'A' THEN 'MOLD'
											WHEN C.CHR_TYPE = 'B' THEN 'DIES STP'
											WHEN C.CHR_TYPE = 'C' THEN 'DIES DF'
											WHEN C.CHR_TYPE = 'D' THEN 'MACHINE'
											WHEN C.CHR_TYPE = 'E' THEN 'JIG'
											ELSE 'ELECTRODE' END AS CHR_TYPE,
										A.INT_ID,
										A.CHR_PROBLEM,
										A.CHR_ACTION,
										A.INT_STROKE AS ACT_STROKE,
										C.CHR_TYPE AS KODE_TYPE,
										A.CHR_PART_CODE AS KODE_PART, 
										A.INT_QTY_SPARE_PART,
										A.CHR_PART_NO_SPARE_PART,
										A.CHR_SPARE_PART_NAME,   
										C.CHR_MODEL,
										C.CHR_PART_NAME,
										A.INT_FLG_REPAIR,
										C.INT_STROKE_BIG_PREVENTIVE AS LAST_STROKE,
										A.CHR_CREATED_DATE AS LAST_DATE,
										A.CHR_CREATED_TIME AS LAST_TIME,
										CONVERT(INT, A.CHR_START_REPAIR_BY) AS NPK_START,
										A.CHR_START_REPAIR_DATE AS DATE_START,
										A.CHR_START_REPAIR_TIME AS TIME_START,
										CONVERT(INT, A.CHR_FINISH_REPAIR_BY) AS NPK_END,
										A.CHR_FINISH_REPAIR_DATE AS DATE_END,
										A.CHR_FINISH_REPAIR_TIME AS TIME_END,
										A.CHR_REMARKS AS NOTES,
										A.INT_FLG_CONFIRM,
										A.CHR_CONFIRM_BY,
										A.CHR_CONFIRM_DATE,
										A.CHR_CONFIRM_TIME										
									FROM MTE.TT_REPAIR_PREVENTIVE A
									LEFT JOIN TM_PARTS_MTE C ON A.INT_ID_PART = C.INT_ID 
									WHERE C.CHR_TYPE = '$group' ORDER BY A.CHR_CREATED_DATE DESC, A.INT_FLG_REPAIR ASC ");
			return $query->result();
		}

		function get_data_history_repair_by_month($group, $month){
			if($group == '1'){
				$group = 'A';
			} elseif($group == '2'){
				$group = 'B';
			} elseif($group == '3'){
				$group = 'C';
			} elseif($group == '4'){
				$group = 'D';
			} elseif($group == '5'){
				$group = 'E';
			} elseif($group == '6'){
				$group = 'F';
			} elseif($group == '7'){
				$group = 'G';
			} elseif($group == '8'){
				$group = 'H';
			}

			$query = $this->db->query("SELECT CASE WHEN C.CHR_TYPE = 'A' THEN 'MOLD'
											WHEN C.CHR_TYPE = 'B' THEN 'DIES STP'
											WHEN C.CHR_TYPE = 'C' THEN 'DIES DF'
											WHEN C.CHR_TYPE = 'D' THEN 'MACHINE'
											WHEN C.CHR_TYPE = 'E' THEN 'JIG'
											ELSE 'ELECTRODE' END AS CHR_TYPE,
										A.INT_ID,
										A.CHR_PROBLEM,
										A.CHR_ACTION,
										A.INT_STROKE AS ACT_STROKE,
										C.CHR_TYPE AS KODE_TYPE,
										A.CHR_PART_CODE AS KODE_PART, 
										A.INT_QTY_SPARE_PART,
										A.CHR_PART_NO_SPARE_PART,
										A.CHR_SPARE_PART_NAME,   
										C.CHR_MODEL,
										C.CHR_PART_NAME,
										A.INT_FLG_REPAIR,
										C.INT_STROKE_BIG_PREVENTIVE AS LAST_STROKE,
										A.CHR_CREATED_DATE AS LAST_DATE,
										A.CHR_CREATED_TIME AS LAST_TIME,
										CONVERT(INT, A.CHR_START_REPAIR_BY) AS NPK_START,
										A.CHR_START_REPAIR_DATE AS DATE_START,
										A.CHR_START_REPAIR_TIME AS TIME_START,
										CONVERT(INT, A.CHR_FINISH_REPAIR_BY) AS NPK_END,
										A.CHR_FINISH_REPAIR_DATE AS DATE_END,
										A.CHR_FINISH_REPAIR_TIME AS TIME_END,
										A.CHR_REMARKS AS NOTES,
										A.INT_FLG_CONFIRM,
										A.CHR_CONFIRM_BY,
										A.CHR_CONFIRM_DATE,
										A.CHR_CONFIRM_TIME										
									FROM MTE.TT_REPAIR_PREVENTIVE A
									LEFT JOIN TM_PARTS_MTE C ON A.INT_ID_PART = C.INT_ID 
									WHERE C.CHR_TYPE = '$group' AND SUBSTRING(A.CHR_START_REPAIR_DATE,1,6) = '$month' ORDER BY A.CHR_CREATED_DATE DESC, A.INT_FLG_REPAIR ASC ");
			return $query->result();
		}

	}
?>