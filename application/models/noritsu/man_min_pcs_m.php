<?php
	/**
	* 
	*/
	class man_min_pcs_m extends CI_Model
	{
		private $table = 'TM_PARTS';

		function get_man_min_pcs() {
			$query = $this->db->query("SELECT pp.CHR_WORK_CENTER, pp.CHR_PART_NO, k.CHR_BACK_NO, p.CHR_PART_NAME, ISNULL(p.CHR_MAN_MIN_PCS,'-') CHR_MAN_MIN_PCS FROM TM_PROCESS_PARTS pp join TM_PARTS p ON pp.CHR_PART_NO = p.CHR_PART_NO join TM_KANBAN k ON k.CHR_PART_NO = p.CHR_PART_NO WHERE pp.CHR_WORK_CENTER = 'ASDL05'");
			return $query->result();
		}

		function get_data_template($dept, $wc) {
			$query = $this->db->query("SELECT pp.CHR_WORK_CENTER, pp.CHR_PART_NO, k.CHR_BACK_NO, p.CHR_PART_NAME, p.CHR_MAN_MIN_PCS FROM TM_PROCESS_PARTS pp join TM_PARTS p ON pp.CHR_PART_NO = p.CHR_PART_NO join TM_KANBAN k ON k.CHR_PART_NO = p.CHR_PART_NO WHERE pp.CHR_WORK_CENTER = '$wc' AND RIGHT(pp.CHR_PERSON_RESPONSIBLE , 1) IN (SELECT RIGHT(CHR_DEPT ,1) FROM TM_DEPT WHERE CHR_DEPT = '$dept')");
			return $query->result();
		}

		function get_dept() {
			$query = $this->db->query("SELECT * FROM TM_DEPT WHERE CHR_DEPT LIKE 'PR%'");
			return $query->result();
		}

		function get_work_center() {
			$query = $this->db->query("SELECT CHR_WORK_CENTER, RIGHT(CHR_PERSON_RESPONSIBLE , 1) AS Prd FROM TM_PROCESS WHERE RIGHT(CHR_PERSON_RESPONSIBLE , 1) IN (SELECT RIGHT(TM_DEPT.CHR_DEPT ,1) FROM TM_DEPT)");
			return $query->result();
			}
			

		function update_man_min_pcs($data, $id) {
			$this->db->where('RTRIM(CHR_PART_NO)', $id);
			$this->db->update($this->table, $data);
		}		
	}
?>