<?php
	/**
	* 
	*/
	class group_prd_m extends CI_Model
	{
		private $table = 'TM_GROUP_PRD';

		function get_group_prd() {
			$query = $this->db->query("SELECT d.CHR_DEPT_DESC, g.INT_ID_GROUP, g.CHR_WORK_CENTER, g.CHR_GROUP_NO, g.CHR_NPK, g.CHR_NAME FROM TM_GROUP_PRD g JOIN TM_DEPT d ON g.INT_ID_DEPT = d.INT_ID_DEPT WHERE CHR_FLAG_DEL = '0'");
			return $query->result();
		}

		function filter_group_prd($dept,$workc,$no) {
			$query = $this->db->query("SELECT d.CHR_DEPT_DESC, g.INT_ID_GROUP, g.CHR_WORK_CENTER, g.CHR_GROUP_NO, g.CHR_NPK, g.CHR_NAME FROM TM_GROUP_PRD g JOIN TM_DEPT d ON g.INT_ID_DEPT = d.INT_ID_DEPT WHERE g.CHR_FLAG_DEL = '0' AND g.INT_ID_DEPT = $dept AND g.CHR_WORK_CENTER = '$workc' AND g.CHR_GROUP_NO = '$no'");
			return $query->result();
		}

		function get_data_group($id) {
			$query = $this->db->query("SELECT CHR_WORK_CENTER, CHR_GROUP_NO, INT_ID_DEPT FROM TM_GROUP_PRD WHERE INT_ID_GROUP = $id");
			return $query->result();
		}

		function get_npk($npk) {
			$query = $this->db->query("SELECT CHR_NPK FROM TM_GROUP_PRD WHERE CHR_NPK = '$npk'");
			return $query->result();
		}

		function get_dept() {
			$query = $this->db->query("SELECT * FROM TM_DEPT WHERE CHR_DEPT LIKE 'PR%'");
			return $query->result();
		}

		function get_mp() {
			$aortadb = $this->load->database("aorta", TRUE);

			$query = $aortadb->query("
			SELECT NPK, NAMA 
			FROM DB_AORTA.dbo.TM_KRY 
			WHERE KD_DEPT LIKE 'PR%' AND NPK COLLATE Latin1_General_CI_AS NOT IN 
			(
				SELECT CHR_NPK 
				FROM DB_AIS.dbo.TM_GROUP_PRD 
				WHERE CHR_FLAG_DEL = 0
			)");
			return $query->result();
		}

		function get_work_center() {
			$query = $this->db->query("SELECT CHR_WORK_CENTER, RIGHT(CHR_PERSON_RESPONSIBLE , 1) AS Prd FROM TM_PROCESS WHERE RIGHT(CHR_PERSON_RESPONSIBLE , 1) IN (SELECT RIGHT(TM_DEPT.CHR_DEPT ,1) FROM TM_DEPT)");
			return $query->result();
			}
			
		function save_group_prd($data) {
			$this->db->insert($this->table, $data);
		}

		function update_group_prd($data, $id) {
			$this->db->where('INT_ID_GROUP', $id);
			$this->db->update($this->table, $data);
		}	

		function update_mp($data, $npk) {
			$this->db->where('CHR_NPK', $npk);
			$this->db->update($this->table, $data);
		}		
	}
?>